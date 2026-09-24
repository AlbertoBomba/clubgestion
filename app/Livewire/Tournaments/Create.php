<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\DetectsDevice;

class Create extends Component
{
    use WithFileUploads;
    use DetectsDevice;

    // Current Step for Wizard
    public int $currentStep = 1;

    // Form fields - Step 1
    public string  $name                  = '';
    public string  $description           = '';
    public string  $location              = '';
    public string  $start_date            = '';
    public string  $end_date              = '';
    public         $logo                  = null;

    // Form fields - Step 2
    public string  $max_teams             = '';
    public string  $max_players_per_team  = '';
    public string  $registration_fee      = '';
    public string  $min_age               = '';
    public string  $player_registration_deadline = '';
    public string  $team_type             = 'open'; // Obligado por requerimiento

    // Form fields - Settings (Step 3)
    public int     $points_per_win  = 3;
    public int     $points_per_draw = 1;
    public int     $points_per_loss = 0;

    // Status / Visibility (Valores por defecto internos)
    public string  $status      = 'draft';
    public string  $visibility  = 'private';

    public function mount()
    {
        $this->currentStep = 1;
        $this->team_type = 'open'; // Siempre Torneo Abierto
    }

    public function nextStep()
    {
        // Validar campos según el paso actual antes de avanzar
        if ($this->currentStep == 1) {
            $this->validate([
                'name'        => 'required|string|max:255',
                'location'    => 'nullable|string|max:255',
                'start_date'  => 'nullable|date',
                'end_date'    => 'nullable|date|after_or_equal:start_date',
                'logo'        => 'nullable|image|max:2048',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'max_teams'                    => 'nullable|integer|min:2|max:512',
                'max_players_per_team'         => 'nullable|integer|min:1|max:100',
                'registration_fee'             => 'nullable|numeric|min:0|max:99999',
                'min_age'                      => 'nullable|integer|min:1|max:100',
                'player_registration_deadline' => 'nullable|date',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'points_per_win'  => 'required|integer|min:0|max:10',
                'points_per_draw' => 'required|integer|min:0|max:10',
                'points_per_loss' => 'required|integer|min:0|max:10',
            ]);
        }

        // Ahora avanzamos hasta el paso 4 (Resumen)
        if ($this->currentStep < 4) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    protected function rules(): array
    {
        return [
            'name'                          => 'required|string|max:255',
            'description'                   => 'nullable|string',
            'location'                      => 'nullable|string|max:255',
            'start_date'                    => 'nullable|date',
            'end_date'                      => 'nullable|date|after_or_equal:start_date',
            'max_teams'                     => 'nullable|integer|min:2|max:512',
            'max_players_per_team'          => 'nullable|integer|min:1|max:100',
            'registration_fee'              => 'nullable|numeric|min:0|max:99999',
            'player_registration_deadline'  => 'nullable|date',
            'min_age'                       => 'nullable|integer|min:1|max:100',
            'logo'                          => 'nullable|image|max:2048',
            'points_per_win'                => 'required|integer|min:0|max:10',
            'points_per_draw'               => 'required|integer|min:0|max:10',
            'points_per_loss'               => 'required|integer|min:0|max:10',
        ];
    }

    public function save(): void
    {
        $this->validate();
        $user = auth()->user();

        // Forzar tipo de torneo a open antes de guardar
        $this->team_type = 'open';

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('tournaments/logos', 'public');
        }

        Tournament::create([
            'sports_school_id'              => $user->sports_school_id,
            'name'                          => $this->name,
            'description'                   => $this->description ?: null,
            'location'                      => $this->location ?: null,
            'start_date'                    => $this->start_date ?: null,
            'end_date'                      => $this->end_date ?: null,
            'max_teams'                     => $this->max_teams ?: null,
            'max_players_per_team'          => $this->max_players_per_team ?: null,
            'registration_fee'              => $this->registration_fee ?: null,
            'player_registration_deadline'  => $this->player_registration_deadline ?: null,
            'min_age'                       => $this->min_age ?: null,
            'team_type'                     => $this->team_type,
            'status'                        => $this->status,
            'visibility'                    => $this->visibility,
            'logo'                          => $logoPath,
            'settings'                      => [
                'points_per_win'  => $this->points_per_win,
                'points_per_draw' => $this->points_per_draw,
                'points_per_loss' => $this->points_per_loss,
            ],
            'created_user'                  => $user->id,
        ]);

        session()->flash('message', 'Torneo creado correctamente.');
        $this->redirect(route('tournaments.index'), navigate: true);
    }

    public function render()
    {
        if ($this->isMobile()) {
            return view('livewire.tournaments.create_mobile');
        }

        return view('livewire.tournaments.create');
    }
}