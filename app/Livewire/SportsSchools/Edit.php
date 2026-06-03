<?php

namespace App\Livewire\SportsSchools;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SportsSchool;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public SportsSchool $school;
    
    public $name;
    public $description;
    public $address;
    public $city;
    public $province;
    public $postal_code;
    public $phone;
    public $email;
    public $contact_person;
    public $is_active;
    public $logo;
    public $currentLogo;
    public $primary_color;
    public $secondary_color;

    // ── Mail configuration ────────────────────────────────────────────
    public string $mail_host         = '';
    public string $mail_port         = '587';
    public string $mail_encryption   = 'tls';
    public string $mail_username     = '';
    public string $mail_password     = '';   // blank = keep existing
    public string $mail_from_address = '';
    public string $mail_from_name    = '';
    public bool   $mail_has_password = false; // read-only flag
    public string $mail_test_to      = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'province' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:10',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'contact_person' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'logo' => 'nullable|image|max:2048', // Max 2MB
        'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
    ];

    public function mount(SportsSchool $school)
    {
        $this->school = $school;
        $this->name = $school->name;
        $this->description = $school->description;
        $this->address = $school->address;
        $this->city = $school->city;
        $this->province = $school->province;
        $this->postal_code = $school->postal_code;
        $this->phone = $school->phone;
        $this->email = $school->email;
        $this->contact_person = $school->contact_person;
        $this->primary_color = $school->primary_color ?? '#1E40AF';
        $this->secondary_color = $school->secondary_color ?? '#10B981';
        $this->is_active = $school->is_active;
        $this->currentLogo = $school->logo;

        // Mail config
        $this->mail_host         = $school->mail_host ?? '';
        $this->mail_port         = (string) ($school->mail_port ?? '587');
        $this->mail_encryption   = $school->mail_encryption ?? 'tls';
        $this->mail_username     = $school->mail_username ?? '';
        $this->mail_from_address = $school->mail_from_address ?? '';
        $this->mail_from_name    = $school->mail_from_name ?? '';
        $this->mail_has_password = !empty($school->mail_password);
        $this->mail_test_to      = $school->email ?? '';
    }

    public function deleteLogo()
    {
        if ($this->currentLogo) {
            Storage::disk('public')->delete($this->currentLogo);
            $this->school->update(['logo' => null]);
            $this->currentLogo = null;
            session()->flash('message', 'Logo eliminado correctamente.');
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'contact_person' => $this->contact_person,
            'is_active' => $this->is_active,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
        ];

        // Handle logo upload
        if ($this->logo) {
            // Delete old logo if exists
            if ($this->currentLogo) {
                Storage::disk('public')->delete($this->currentLogo);
            }
            
            // Store new logo
            $logoPath = $this->logo->store('schools/logos', 'public');
            $data['logo'] = $logoPath;
            $this->currentLogo = $logoPath;
        }

        $this->school->update($data);

        session()->flash('message', 'Escuela deportiva actualizada correctamente.');
        
        return redirect()->route('sports-schools.index');
    }

    /**
     * Generar una nueva API key
     */
    public function generateApiKey()
    {
        $apiKey = $this->school->generateApiKey();
        session()->flash('api_key_generated', $apiKey);
        session()->flash('message', 'API Key generada correctamente. Cópiala ahora, no se volverá a mostrar.');
        
        // Refrescar el componente
        $this->school = $this->school->fresh();
        return redirect()->route('sports-schools.edit', $this->school);
    }

    /**
     * Regenerar API key existente
     */
    public function regenerateApiKey()
    {
        $apiKey = $this->school->regenerateApiKey();
        session()->flash('api_key_generated', $apiKey);
        session()->flash('message', 'API Key regenerada correctamente. La anterior ha sido invalidada.');
        
        // Refrescar el componente
        $this->school = $this->school->fresh();
        return redirect()->route('sports-schools.edit', $this->school);
    }

    /**
     * Habilitar API
     */
    public function enableApi()
    {
        $this->school->enableApi();
        session()->flash('message', 'API habilitada correctamente.');
        $this->school = $this->school->fresh();
    }

    /**
     * Deshabilitar API
     */
    public function disableApi()
    {
        $this->school->disableApi();
        session()->flash('message', 'API deshabilitada correctamente.');
        $this->school = $this->school->fresh();
    }

    // ── Mail configuration ────────────────────────────────────────────

    /** Auto-fill host / port / encryption for common providers. */
    public function applyMailPreset(string $provider): void
    {
        match ($provider) {
            'gmail'   => [
                $this->mail_host,
                $this->mail_port,
                $this->mail_encryption,
            ] = ['smtp.gmail.com', '587', 'tls'],
            'outlook' => [
                $this->mail_host,
                $this->mail_port,
                $this->mail_encryption,
            ] = ['smtp.office365.com', '587', 'tls'],
            'yahoo'   => [
                $this->mail_host,
                $this->mail_port,
                $this->mail_encryption,
            ] = ['smtp.mail.yahoo.com', '587', 'tls'],
            'strato'  => [
                $this->mail_host,
                $this->mail_port,
                $this->mail_encryption,
            ] = ['smtp.strato.de', '587', 'tls'],
            default   => null,
        };
    }

    /** Save only the mail configuration fields. */
    public function saveMailConfig(): void
    {
        $this->validate([
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|integer|min:1|max:65535',
            'mail_encryption'   => 'nullable|in:tls,ssl',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:500',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name'    => 'nullable|string|max:255',
        ], [
            'mail_port.integer' => 'El puerto debe ser un número.',
            'mail_port.min'     => 'El puerto debe ser mayor que 0.',
            'mail_port.max'     => 'El puerto no puede superar 65535.',
            'mail_encryption.in'    => 'La encriptación debe ser TLS o SSL.',
            'mail_from_address.email' => 'El email remitente no es válido.',
        ]);

        $data = [
            'mail_host'         => $this->mail_host ?: null,
            'mail_port'         => $this->mail_port ? (int) $this->mail_port : 587,
            'mail_encryption'   => $this->mail_encryption ?: 'tls',
            'mail_username'     => $this->mail_username ?: null,
            'mail_from_address' => $this->mail_from_address ?: null,
            'mail_from_name'    => $this->mail_from_name ?: null,
        ];

        // Only update the stored password when the user fills in a new one
        if ($this->mail_password !== '') {
            $data['mail_password'] = $this->mail_password;  // model cast will encrypt it
            $this->mail_has_password = true;
            $this->mail_password     = '';
        }

        $this->school->update($data);
        $this->school = $this->school->fresh();

        session()->flash('mail_message', 'Configuración de correo guardada correctamente.');
    }

    /** Send a test email using the current SMTP form values. */
    public function sendTestMail(): void
    {
        $this->validate([
            'mail_test_to' => 'required|email|max:255',
        ], [
            'mail_test_to.required' => 'Introduce una dirección de correo para la prueba.',
            'mail_test_to.email'    => 'La dirección de correo no es válida.',
        ]);

        $host       = $this->mail_host ?: $this->school->mail_host;
        $port       = (int) ($this->mail_port ?: $this->school->mail_port ?: 587);
        $encryption = $this->mail_encryption ?: $this->school->mail_encryption ?: 'tls';
        $username   = $this->mail_username ?: $this->school->mail_username;
        $password   = $this->mail_password !== '' ? $this->mail_password : $this->school->mail_password;
        $fromAddr   = $this->mail_from_address ?: $this->school->mail_from_address ?: $username;
        $fromName   = $this->mail_from_name ?: $this->school->mail_from_name ?: $this->school->name;

        if (!$host || !$username || !$password) {
            $this->addError('mail_test_to', 'Completa el host, usuario y contraseña antes de enviar la prueba.');
            return;
        }

        try {
            $mailer = Mail::build([
                'transport'  => 'smtp',
                'host'       => $host,
                'port'       => $port,
                'encryption' => $encryption,
                'username'   => $username,
                'password'   => $password,
                'timeout'    => 15,
            ]);

            $schoolName = $this->school->name;
            $testTo     = $this->mail_test_to;

            $mailer->raw(
                "Este es un correo de prueba enviado desde {$schoolName}.\n\nLa configuración SMTP está funcionando correctamente.",
                function ($msg) use ($fromAddr, $fromName, $schoolName, $testTo) {
                    $msg->to($testTo)
                        ->from($fromAddr, $fromName)
                        ->subject("✅ Correo de prueba – {$schoolName}");
                }
            );

            session()->flash('mail_message', "✅ Correo de prueba enviado correctamente a {$this->mail_test_to}.");
        } catch (\Exception $e) {
            $this->addError('mail_test_to', 'Error SMTP: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.sports-schools.edit');
    }
}
