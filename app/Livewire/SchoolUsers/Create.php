<?php

namespace App\Livewire\SchoolUsers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\SportsSchool;
use App\Services\SchoolMailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    use WithFileUploads;
    
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $sports_school_id = '';
    public $role = 'student';
    public $is_active = true;
    public $profile_photo;
    public $document;
    public $documentLabel;
    public $documentType = '';
    public $captureMode = false;
    public bool $send_reset_email = false;

    public function mount()
    {
        // Si el usuario es school_admin, pre-cargar su escuela
        if (auth()->user()->hasRole('school_admin')) {
            $this->sports_school_id = auth()->user()->sports_school_id;
        }
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => $this->send_reset_email ? 'nullable' : 'required|string|min:8|confirmed',
            'sports_school_id' => 'required|exists:sports_schools,id',
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
        
        // Si hay un documento, requerir tipo
        if ($this->document) {
            $rules['documentType'] = 'required|in:dni_frontal,dni_trasero,otros';
            
            // Si es "otros", requerir etiqueta
            if ($this->documentType === 'otros') {
                $rules['documentLabel'] = 'required|string|max:255';
            }
        }
        
        return $rules;
    }

    public function save()
    {
        // Si el usuario es school_admin, forzar su escuela
        if (auth()->user()->hasRole('school_admin')) {
            $this->sports_school_id = auth()->user()->sports_school_id;
        }

        // Debug: Log del documento
        \Log::info('Create Save - Document:', [
            'has_document' => !is_null($this->document),
            'document_type' => $this->documentType,
            'document_label' => $this->documentLabel,
        ]);

        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->send_reset_email ? Str::random(32) : $this->password),
            'sports_school_id' => $this->sports_school_id,
            'role' => $this->role,
            'is_active' => $this->is_active,
            'email_verified_at' => now(),
        ];

        // Guardar foto de perfil
        if ($this->profile_photo) {
            $data['profile_photo_path'] = $this->profile_photo->store('profile-photos', 'public');
        }

        $user = User::create($data);

        // Guardar documento
        if ($this->document) {
            // Determinar la etiqueta según el tipo de documento
            $label = match($this->documentType) {
                'dni_frontal' => 'DNI Frontal',
                'dni_trasero' => 'DNI Trasero',
                'otros' => $this->documentLabel ?: 'Documento 1',
                default => 'Documento 1'
            };
            
            $path = $this->document->store('user-documents/' . $user->id, 'public');
            $savedDocuments = [[
                'path' => $path,
                'label' => $label,
                'original_name' => $this->document->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ]];
            $user->update(['documents' => $savedDocuments]);
        }

        // Asignar rol usando Spatie
        $user->assignRole($this->role);

        // Enviar email de bienvenida con enlace para establecer contraseña
        if ($this->send_reset_email) {
            try {
                $school  = SportsSchool::find($this->sports_school_id);
                $token   = Password::broker()->createToken($user);
                $resetUrl = url(route('password.reset', [
                    'token' => $token,
                    'email' => $user->email,
                ], false));

                $schoolName = $school?->name ?? config('app.name');
                $fromAddr   = $school?->mail_from_address ?: ($school?->mail_username ?: config('mail.from.address'));
                $fromName   = $school?->mail_from_name ?: $schoolName;

                $body = implode("\n\n", [
                    "Hola {$user->name},",
                    "Tu cuenta en {$schoolName} ha sido creada correctamente.",
                    "Para establecer tu contraseña y acceder a la plataforma, pulsa el siguiente enlace:",
                    $resetUrl,
                    "Este enlace expirará en 60 minutos. Si no lo usas a tiempo, puedes solicitar otro desde la pantalla de inicio de sesión.",
                    "Saludos,\n{$schoolName}",
                ]);

                $mailer = SchoolMailer::forSchool($school ?? new SportsSchool());
                $mailer->raw($body, function ($msg) use ($user, $fromAddr, $fromName, $schoolName) {
                    $msg->to($user->email, $user->name)
                        ->from($fromAddr, $fromName)
                        ->subject("Bienvenido a {$schoolName} — Establece tu contraseña");
                });

                session()->flash('message', "Usuario creado correctamente. Se ha enviado un email a {$user->email} con el enlace para establecer la contraseña.");
            } catch (\Exception $e) {
                \Log::error('Error enviando email de bienvenida: ' . $e->getMessage());
                session()->flash('message', 'Usuario creado correctamente. No se pudo enviar el email de bienvenida (revisa la configuración SMTP de la escuela).');
            }
        } else {
            session()->flash('message', 'Usuario creado correctamente. Ahora puedes agregar su foto de perfil y documentos.');
        }
        
        // Redirigir al editar del usuario creado según el contexto
        $route = (auth()->user()->isMaster() || session()->has('impersonator_id')) 
            ? 'school-users.edit' 
            : 'my-school-users.edit';
            
        return redirect()->route($route, $user->id);
    }

    public function render()
    {
        $schools = SportsSchool::where('is_active', true)->orderBy('name')->get();
        $roles   = Role::where('name', '!=', 'master')->get();

        $selectedSchool       = $this->sports_school_id ? SportsSchool::find($this->sports_school_id) : null;
        $schoolMailConfigured = $selectedSchool ? SchoolMailer::isConfigured($selectedSchool) : false;
        $schoolMailFrom       = $selectedSchool
            ? ($selectedSchool->mail_from_address ?: ($selectedSchool->mail_username ?: null))
            : null;

        return view('livewire.school-users.create', [
            'schools'             => $schools,
            'roles'               => $roles,
            'schoolMailConfigured'=> $schoolMailConfigured,
            'schoolMailFrom'      => $schoolMailFrom,
        ]);
    }
}
