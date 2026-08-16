<?php

namespace App\Livewire\Webclubs;

use Livewire\Component;
use App\Notifications\MemberRegisteredNotification;
use App\Rules\ValidIban;
use App\Rules\ValidDniNie; 
use App\Models\MemberType;
use App\Models\Member;
use Livewire\Attributes\Validate;
use App\Services\SchoolMailer;
use App\Mail\MemberRegisteredMail;
use App\Models\SportsSchool;


class MemberRegister extends Component
{
    public $memberTypeId;
    public ?MemberType $memberType = null;
    public ?SportsSchool $school = null;
    public $done = false;

    // Propiedades del formulario con atributos de validación de Livewire 3
    #[Validate('required|string|max:255', message: 'El nombre es obligatorio.')]
    public string $name = '';

    #[Validate(new ValidDniNie)]
    public string $dni = '';

    #[Validate('required|email|max:255', message: 'Introduce un correo electrónico válido.')]
    public string $email = '';

    #[Validate('required|string|max:20', message: 'El teléfono es obligatorio.')]
    public string $phone = '';

    #[Validate('required|date', message: 'Indica una fecha de nacimiento válida.')]
    public string $birth_date = '';

    #[Validate('required|string|max:255', message: 'La dirección es obligatoria.')]
    public string $address = '';

    #[Validate('required|string|max:255', message: 'La población es obligatoria.')]
    public string $town = '';

    #[Validate('required|string|max:10', message: 'El código postal es obligatorio.')]
    public string $zip = '';

    #[Validate('required|string|max:255', message: 'La provincia es obligatoria.')]
    public string $province = '';

    #[Validate('required|string|max:255', message: 'El titular de la cuenta es obligatorio.')]
    public string $bank_account_holder = '';

    #[Validate(new ValidIban)]
    public string $bank_account = '';

    #[Validate('accepted', message: 'Debes aceptar los términos de la orden de domiciliación SEPA.')]
    public bool $sepa_terms = false;

    
    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'dni.required' => 'El DNI/NIE es obligatorio.',
        'email.required' => 'Introduce un correo electrónico válido.',
        'phone.required' => 'El teléfono es obligatorio.',
        'birth_date.required' => 'Indica una fecha de nacimiento válida.',
        'address.required' => 'La dirección es obligatoria.',
        'town.required' => 'La población es obligatoria.',
        'zip.required' => 'El código postal es obligatorio.',
        'province.required' => 'La provincia es obligatoria.',
        'bank_account_holder.required' => 'El titular de la cuenta es obligatorio.',
        'bank_account.required' => 'El IBAN es obligatorio.',
        'sepa_terms.accepted' => 'Debes aceptar los términos de la orden de domiciliación SEPA.',
        'bank_account.valid_iban' => 'El número de cuenta bancaria (IBAN) introducido no es válido.',
        'dni.valid_dni_nie' => 'El DNI/NIE introducido no es válido.',
    ];

    public function mount($memberTypeId)
    {
        $this->memberTypeId = $memberTypeId;
        // Carga el tipo de socio o lanza un 404 si no existe
        $this->memberType = MemberType::findOrFail($memberTypeId);
        $this->school = currentSchool();
    }

    public function save()
    {
        // 1. Ejecutar validación
        $this->validate();

        // 2. Formatear y limpiar el IBAN (quitar espacios y convertir a mayúsculas)
        $cleanIban = strtoupper(str_replace(' ', '', $this->bank_account));

        // 3. Crear el socio con los metadatos legales de la firma SEPA
        $member = Member::create([
            'sports_school_id'   => currentSchool()->id,
            'member_type_id'      => $this->memberType->id,
            'name'                => $this->name,
            'dni'                 => strtoupper(trim($this->dni)),
            'email'               => $this->email,
            'phone'               => $this->phone,
            'birth_date'          => $this->birth_date,
            'address'             => $this->address,
            'town'                => $this->town,
            'zip'                 => $this->zip,
            'province'            => $this->province,
            'bank_account'        => $cleanIban,
            'bank_account_holder' => $this->bank_account_holder,
            'sepa_mandate_date'   => now(),            // Marca de tiempo de la firma
            'sepa_mandate_ip'     => request()->ip(),  // Captura la IP del cliente
        ]);

        // dd('Aun no esta operativo');

        $data = [
            'season_id'      => $this->memberType->season_id,
            'member_type_id' => $this->memberType->id,
            'join_date'      => now()->toDateString(),
            'price'          => (float) str_replace(',', '.', $this->memberType->price),
            'observations'   => '',
            'payment_status' => 'pending',
            'status'         => 'active',
        ];

        // Buscamos si la inscripción ya existe (incluyendo eliminados con SoftDelete)
        $existingSeason = $member->memberSeasons()
            ->withTrashed()
            ->where('season_id', $this->memberType->season_id)
            ->first();

        if ($existingSeason) {
            if ($existingSeason->trashed()) {
                $existingSeason->restore(); // Si estaba en la papelera, lo restauramos
            }
            $existingSeason->update($data); // Actualizamos el registro restaurado
        } else {
            $member->memberSeasons()->create($data); // Creación normal si no existía
        }

        // 4. Generar e insertar la Referencia del Mandato SEPA única
        $member->update([
            'sepa_mandate_ref' => 'MND-' . date('Y') . '-' . str_pad($member->id, 6, '0', STR_PAD_LEFT),
        ]);

        // 5. Enviar notificación electrónica por email (Prueba de Mandato SEPA)
        //$member->notify(new MemberRegisteredNotification($member));
        $this->sendMailRegistration($member);

        $this->done = true;
        // $this->resetForm();
    }

    public function sendMailRegistration($member)
    {


        $school = $this->school ?: currentSchool();
        $memberType = $this->memberType ?? new MemberType();

        $mailable = new MemberRegisteredMail(
            member: $member,
            school: $school,
            memberType: $memberType
        );

        try {
            SchoolMailer::forSchool($school)
                ->to($member->email, $member->name)
                ->send($mailable);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error enviando email de confirmación de inscripción', [
                'member_id' => $member->id,
                'error'     => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.webclubs.member-register')->layout('livewire.webclubs.layouts.app');
    }
}
