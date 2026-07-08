<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentMatchCard;
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

        // Get all match IDs for statistics
        $matchIds = $this->tournament->matches()->pluck('id');

        // Top scorers (excluding own goals)
        $topScorers = TournamentMatchGoal::whereIn('tournament_match_id', $matchIds)
            ->where('goal_type', '!=', 'own_goal')
            ->with(['player', 'team'])
            ->get()
            ->groupBy('tournament_player_id')
            ->map(function ($goals) {
                $first = $goals->first();
                return (object) [
                    'player'   => $first->player,
                    'team'     => $first->team,
                    'goals'    => $goals->count(),
                ];
            })
            ->sortByDesc('goals')
            ->values();

        // Player cards (grouped by player)
        $playerCards = TournamentMatchCard::whereIn('tournament_match_id', $matchIds)
            ->with(['player', 'team'])
            ->get()
            ->groupBy('tournament_player_id')
            ->map(function ($cards) {
                $first = $cards->first();
                return (object) [
                    'player'        => $first->player,
                    'team'          => $first->team,
                    'yellow_cards'  => $cards->where('card_type', 'yellow')->count(),
                    'red_cards'     => $cards->whereIn('card_type', ['red', 'double_yellow'])->count(),
                ];
            })
            ->filter(fn($card) => $card->yellow_cards > 0 || $card->red_cards > 0)
            ->sortByDesc(fn($card) => $card->red_cards * 1000 + $card->yellow_cards)
            ->values();

        return view('livewire.webclubs.tournament-detail', [
            'teams'                  => $teams,
            'standings'              => $standings,
            'matchesByPhaseAndRound' => $matchesByPhaseAndRound,
            'topScorers'             => $topScorers,
            'playerCards'            => $playerCards,
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
