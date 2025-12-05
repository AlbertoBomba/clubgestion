<?php

namespace App\Livewire\SchoolUsers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'password' => 'required|string|min:8|confirmed',
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
            'password' => Hash::make($this->password),
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

        session()->flash('message', 'Usuario creado correctamente. Ahora puedes agregar su foto de perfil y documentos.');
        
        // Redirigir al editar del usuario creado según el contexto
        $route = (auth()->user()->isMaster() || session()->has('impersonator_id')) 
            ? 'school-users.edit' 
            : 'my-school-users.edit';
            
        return redirect()->route($route, $user->id);
    }

    public function render()
    {
        $schools = SportsSchool::where('is_active', true)->orderBy('name')->get();
        $roles = Role::where('name', '!=', 'master')->get();
        
        return view('livewire.school-users.create', [
            'schools' => $schools,
            'roles' => $roles
        ]);
    }
}
