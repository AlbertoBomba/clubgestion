<?php

namespace App\Livewire\WebHomeConfig;

use Livewire\Component;
use App\Models\WebHomeConfig;

class Edit extends Component
{
    // Stats
    public $stats_years = 80;

    // Membership
    public $membership_show    = true;
    public $membership_title   = 'Hazte Socio';
    public $membership_subtitle = 'Disfruta de beneficios exclusivos y forma parte de nuestra comunidad deportiva';
    public $benefit_1_title    = 'Descuentos';
    public $benefit_1_description = 'Acceso a precios especiales en equipación y eventos';
    public $benefit_2_title    = 'Eventos';
    public $benefit_2_description = 'Invitaciones exclusivas a eventos del club';
    public $benefit_3_title    = 'Prioridad';
    public $benefit_3_description = 'Acceso prioritario a inscripciones y reservas';
    public $membership_button_text = 'Únete Ahora';
    public $membership_button_url  = '';

    // Contact
    public $contact_show  = true;
    public $contact_title = '¿Tienes Preguntas?';
    public $contact_email = '';
    public $contact_phone = '';

    public function mount()
    {
        $config = WebHomeConfig::where('sports_school_id', auth()->user()->sports_school_id)->first();

        if ($config) {
            $this->stats_years             = $config->stats_years;
            $this->membership_show         = $config->membership_show;
            $this->membership_title        = $config->membership_title;
            $this->membership_subtitle     = $config->membership_subtitle;
            $this->benefit_1_title         = $config->benefit_1_title;
            $this->benefit_1_description   = $config->benefit_1_description;
            $this->benefit_2_title         = $config->benefit_2_title;
            $this->benefit_2_description   = $config->benefit_2_description;
            $this->benefit_3_title         = $config->benefit_3_title;
            $this->benefit_3_description   = $config->benefit_3_description;
            $this->membership_button_text  = $config->membership_button_text;
            $this->membership_button_url   = $config->membership_button_url;
            $this->contact_show            = $config->contact_show;
            $this->contact_title           = $config->contact_title;
            $this->contact_email           = $config->contact_email;
            $this->contact_phone           = $config->contact_phone;
        }
    }

    protected $rules = [
        'stats_years'             => 'required|integer|min:0|max:500',
        'membership_show'         => 'boolean',
        'membership_title'        => 'nullable|string|max:255',
        'membership_subtitle'     => 'nullable|string|max:1000',
        'benefit_1_title'         => 'nullable|string|max:255',
        'benefit_1_description'   => 'nullable|string|max:500',
        'benefit_2_title'         => 'nullable|string|max:255',
        'benefit_2_description'   => 'nullable|string|max:500',
        'benefit_3_title'         => 'nullable|string|max:255',
        'benefit_3_description'   => 'nullable|string|max:500',
        'membership_button_text'  => 'nullable|string|max:100',
        'membership_button_url'   => 'nullable|string|max:500',
        'contact_show'            => 'boolean',
        'contact_title'           => 'nullable|string|max:255',
        'contact_email'           => 'nullable|email|max:255',
        'contact_phone'           => 'nullable|string|max:30',
    ];

    public function save()
    {
        $this->validate();

        $isNew = !WebHomeConfig::where('sports_school_id', auth()->user()->sports_school_id)->exists();

        WebHomeConfig::updateOrCreate(
            ['sports_school_id' => auth()->user()->sports_school_id],
            [
                'stats_years'            => $this->stats_years,
                'membership_show'        => $this->membership_show,
                'membership_title'       => $this->membership_title,
                'membership_subtitle'    => $this->membership_subtitle,
                'benefit_1_title'        => $this->benefit_1_title,
                'benefit_1_description'  => $this->benefit_1_description,
                'benefit_2_title'        => $this->benefit_2_title,
                'benefit_2_description'  => $this->benefit_2_description,
                'benefit_3_title'        => $this->benefit_3_title,
                'benefit_3_description'  => $this->benefit_3_description,
                'membership_button_text' => $this->membership_button_text,
                'membership_button_url'  => $this->membership_button_url ?: null,
                'contact_show'           => $this->contact_show,
                'contact_title'          => $this->contact_title,
                'contact_email'          => $this->contact_email ?: null,
                'contact_phone'          => $this->contact_phone ?: null,
                $isNew ? 'created_user' : 'updated_user' => auth()->id(),
            ]
        );

        session()->flash('message', 'Configuración de portada guardada correctamente.');
    }

    public function render()
    {
        return view('livewire.web-home-config.edit');
    }
}
