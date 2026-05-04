<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use App\Models\TournamentTeam;
use Livewire\Component;

class TeamDashboard extends Component
{
    public Tournament     $tournament;
    public TournamentTeam $team;

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

        $this->tournament = $tournament;

        $teamId = session('tt_auth_' . $tournament->id);

        if (!$teamId) {
            $this->redirect(route('webclubs.team.login', $tournament));
            return;
        }

        $team = TournamentTeam::where('tournament_id', $tournament->id)->find($teamId);

        if (!$team) {
            session()->forget('tt_auth_' . $tournament->id);
            $this->redirect(route('webclubs.team.login', $tournament));
            return;
        }

        $this->team = $team;
    }

    public function logout(): void
    {
        session()->forget('tt_auth_' . $this->tournament->id);
        $this->redirect(route('webclubs.team.login', $this->tournament));
    }

    public function render()
    {
        return view('livewire.webclubs.team-dashboard')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' · ' . $this->team->displayName(),
            ]);
    }
}
