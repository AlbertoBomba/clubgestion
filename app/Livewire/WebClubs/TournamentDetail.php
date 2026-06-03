<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class TournamentDetail extends Component
{
    public $school;
    public Tournament $tournament;

    // Active tab: 'equipos' | 'clasificacion' | 'partidos'
    public string $activeTab = 'partidos';

    public function mount(Tournament $tournament): void
    {
        $this->school = currentSchool();

        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        // Verify the tournament belongs to this school and is public
        if (
            $tournament->sports_school_id !== $this->school->id ||
            $tournament->visibility !== 'public' ||
            $tournament->status === 'cancelled'
        ) {
            abort(404);
        }

        $this->tournament = $tournament;
    }

    public function render()
    {
        // Teams
        $teams = $this->tournament->tournamentTeams()
            ->with(['team', 'players' => fn ($q) => $q->where('status', 'approved')->orderBy('dorsal')->orderBy('surname')])
            ->orderBy('seed')
            ->orderBy('id')
            ->get();

        // Standings grouped by phase → group_label
        $standings = $this->tournament->standings()
            ->with(['tournamentTeam.team', 'phase'])
            ->orderBy('phase_id')
            ->orderBy('group_label')
            ->orderBy('position')
            ->orderByDesc('points')
            ->orderByRaw('(goals_for - goals_against) DESC')
            ->get()
            ->groupBy(fn ($s) => ($s->phase ? $s->phase->name : 'General') . ($s->group_label ? ' – ' . $s->group_label : ''));

        // Matches grouped by phase → round (accordion)
        $matches = $this->tournament->matches()
            ->with(['homeTeam.team', 'awayTeam.team', 'phase'])
            ->whereNull('deleted_at')
            ->orderBy('phase_id')
            ->orderBy('round')
            ->orderBy('scheduled_at')
            ->get()
            ->groupBy(fn ($m) => ($m->phase ? $m->phase->name : 'General'));

        // Further group each phase by round
        $matchesByPhaseAndRound = $matches->map(fn ($phaseMatches) =>
            $phaseMatches->groupBy(fn ($m) => $m->round ? 'Jornada ' . $m->round : 'Sin jornada')
        );

        return view('livewire.webclubs.tournament-detail', [
            'teams'                  => $teams,
            'standings'              => $standings,
            'matchesByPhaseAndRound' => $matchesByPhaseAndRound,
            'canRegister'            => $this->tournament->status === 'registration_open'
                && (
                    ! $this->tournament->registration_deadline
                    || $this->tournament->registration_deadline->gte(now()->startOfDay())
                ),
        ])->layout('livewire.webclubs.layouts.app', [
            'title' => tenantName() . ' - ' . $this->tournament->name,
        ]);
    }
}
