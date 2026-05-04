<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class TeamLogin extends Component
{
    public Tournament $tournament;

    public string $email    = '';
    public string $password = '';
    public string $error    = '';
    public bool   $registered = false;

    public function mount(Tournament $tournament): void
    {
        $school = currentSchool();

        if (!$school) {
            abort(404);
        }

        if (
            $tournament->sports_school_id !== $school->id ||
            $tournament->visibility !== 'public' ||
            $tournament->status === 'cancelled'
        ) {
            abort(404);
        }

        $this->tournament  = $tournament;
        $this->registered  = request()->boolean('registered');

        // Already logged in → go to dashboard
        if (session('tt_auth_' . $tournament->id)) {
            $this->redirect(route('webclubs.team.dashboard', $tournament));
        }
    }

    public function login(): void
    {
        $this->error = '';

        $this->validate([
            'email'    => 'required|email|max:255',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Introduce tu email.',
            'email.email'       => 'El email no es válido.',
            'password.required' => 'Introduce tu contraseña.',
        ]);

        $team = TournamentTeam::where('tournament_id', $this->tournament->id)
            ->where('email', $this->email)
            ->first();

        if (!$team || !$team->password || !Hash::check($this->password, $team->password)) {
            $this->error = 'Email o contraseña incorrectos.';
            return;
        }

        session()->put('tt_auth_' . $this->tournament->id, $team->id);

        $this->redirect(route('webclubs.team.dashboard', $this->tournament));
    }

    public function render()
    {
        return view('livewire.webclubs.team-login')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' · Acceso equipo',
            ]);
    }
}
