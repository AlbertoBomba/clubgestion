<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamRegister extends Component
{
    use WithFileUploads;

    public Tournament $tournament;

    public int    $step                 = 1;
    public string $reg_name             = '';
    public        $reg_logo             = null;
    public string $reg_contact_name     = '';
    public string $reg_contact_phone    = '';
    public string $reg_email            = '';
    public string $reg_password         = '';
    public string $reg_confirm_password = '';

    public function mount(Tournament $tournament): void
    {
        $school = currentSchool();

        if (!$school) {
            abort(404, 'Escuela no encontrada');
        }

        if (
            $tournament->sports_school_id !== $school->id ||
            $tournament->visibility !== 'public' ||
            $tournament->status === 'cancelled'
        ) {
            abort(404);
        }

        if ($tournament->status !== 'registration_open') {
            $this->redirect(route('webclubs.tournament.detail', $tournament));
            return;
        }

        if ($tournament->registration_deadline && $tournament->registration_deadline->lt(now()->startOfDay())) {
            $this->redirect(route('webclubs.tournament.detail', $tournament));
            return;
        }

        $this->tournament = $tournament;
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'reg_name' => 'required|string|max:255',
                'reg_logo' => 'nullable|image|max:2048',
            ], [
                'reg_name.required' => 'El nombre del equipo es obligatorio.',
                'reg_logo.image'    => 'El archivo debe ser una imagen.',
                'reg_logo.max'      => 'El escudo no puede superar 2 MB.',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'reg_contact_name'  => 'nullable|string|max:255',
                'reg_contact_phone' => 'nullable|string|max:50',
            ]);
        } elseif ($this->step === 3) {
            $isOpen = $this->tournament->team_type === 'open';
            $this->validate([
                'reg_email' => [
                    $isOpen ? 'required' : 'nullable',
                    'email', 'max:255',
                    Rule::unique('tournament_teams', 'email')
                        ->where('tournament_id', $this->tournament->id),
                ],
                'reg_password' => [
                    $isOpen ? 'required' : 'nullable',
                    'string', 'min:6', 'max:100',
                ],
                'reg_confirm_password' => [
                    $isOpen ? 'required' : 'nullable',
                    'string', 'same:reg_password',
                ],
            ], [
                'reg_email.required'            => 'El email es obligatorio para torneos abiertos.',
                'reg_email.unique'              => 'Ya existe un equipo inscrito con ese email.',
                'reg_password.required'         => 'La contraseña es obligatoria para torneos abiertos.',
                'reg_password.min'              => 'La contraseña debe tener al menos 6 caracteres.',
                'reg_confirm_password.required' => 'Confirma la contraseña.',
                'reg_confirm_password.same'     => 'Las contraseñas no coinciden.',
            ]);
        }

        $this->step++;
    }

    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
            $this->resetErrorBag();
        }
    }

    public function clearRegLogo(): void
    {
        $this->reg_logo = null;
        $this->resetErrorBag('reg_logo');
    }

    public function registerTeam(): void
    {
        $isOpen = $this->tournament->team_type === 'open';

        $this->validate([
            'reg_name'             => 'required|string|max:255',
            'reg_logo'             => 'nullable|image|max:2048',
            'reg_contact_name'     => 'nullable|string|max:255',
            'reg_contact_phone'    => 'nullable|string|max:50',
            'reg_email'            => [
                $isOpen ? 'required' : 'nullable',
                'email', 'max:255',
                Rule::unique('tournament_teams', 'email')
                    ->where('tournament_id', $this->tournament->id),
            ],
            'reg_password'         => [
                $isOpen ? 'required' : 'nullable',
                'string', 'min:6', 'max:100',
            ],
            'reg_confirm_password' => [$isOpen ? 'required' : 'nullable', 'string', 'same:reg_password'],
        ]);

        $logoPath = null;
        if ($this->reg_logo) {
            $logoPath = $this->reg_logo->store('tournament-teams/logos', 'public');
        }

        TournamentTeam::create([
            'tournament_id'          => $this->tournament->id,
            'tournament_category_id' => null,
            'team_id'                => null,
            'external_team'          => true,
            'name_override'          => $this->reg_name,
            'logo'                   => $logoPath,
            'contact_name'           => $this->reg_contact_name ?: null,
            'contact_phone'          => $this->reg_contact_phone ?: null,
            'email'                  => $this->reg_email ?: null,
            'password'               => $this->reg_password ? Hash::make($this->reg_password) : null,
            'status'                 => 'registered',
        ]);

        $this->redirect(route('webclubs.team.login', $this->tournament) . '?registered=1');
    }

    public function render()
    {
        return view('livewire.webclubs.team-register')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' · Inscripción — ' . $this->tournament->name,
            ]);
    }
}
