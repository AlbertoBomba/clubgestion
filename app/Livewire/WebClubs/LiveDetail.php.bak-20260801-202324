<?php

namespace App\Livewire\Webclubs;

use Livewire\Component;
use App\Models\Tournament;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentMatchCard;
use App\Models\TournamentPhase;


class LiveDetail extends Component
{
    
    public $school;
    public Tournament $tournament;

    public int $lastGoalId = 0;
    public int $lastCardId = 0;

     public function mount(Tournament $tournament): void
    {
        $this->school = currentSchool();

        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        // Verify the tournament belongs to this school and is public
        if (
            $tournament->sports_school_id !== $this->school->id ||
            $tournament->live !== true ||
            $tournament->status === 'cancelled'
        ) {
            abort(404);
        }

        $this->tournament = $tournament;

        // Initialise watermarks so existing events don't trigger modals on first load
        $matchIds = $tournament->matches()->pluck('id');
        $this->lastGoalId = TournamentMatchGoal::whereIn('tournament_match_id', $matchIds)->max('id') ?? 0;
        $this->lastCardId = TournamentMatchCard::whereIn('tournament_match_id', $matchIds)->max('id') ?? 0;
    }

    public function render()
    {
        // ── Detect new goals / cards and dispatch browser events ──────────────
        $liveMatchIds = $this->tournament->matches()
            ->where('status', 'in_progress')
            ->pluck('id');

        if ($liveMatchIds->isNotEmpty()) {
            $newGoals = TournamentMatchGoal::whereIn('tournament_match_id', $liveMatchIds)
                ->where('id', '>', $this->lastGoalId)
                ->with(['player', 'team'])
                ->orderBy('id')
                ->get();

            foreach ($newGoals as $goal) {
                $this->dispatch('live-event-notification', [
                    'type'         => 'goal',
                    'goal_type'    => $goal->goal_type,
                    'label'        => $goal->goalTypeLabel(),
                    'player_name'  => $goal->player?->fullName() ?? '—',
                    'player_photo' => $goal->player?->photoUrl(),
                    'team_name'    => $goal->team?->displayName() ?? '—',
                    'minute'       => $goal->minute,
                ]);
            }

            if ($newGoals->isNotEmpty()) {
                $this->lastGoalId = $newGoals->last()->id;
            }

            $newCards = TournamentMatchCard::whereIn('tournament_match_id', $liveMatchIds)
                ->where('id', '>', $this->lastCardId)
                ->with(['player', 'team'])
                ->orderBy('id')
                ->get();

            foreach ($newCards as $card) {
                $this->dispatch('live-event-notification', [
                    'type'         => 'card',
                    'card_type'    => $card->card_type,
                    'label'        => $card->cardTypeLabel(),
                    'player_name'  => $card->player?->fullName() ?? '—',
                    'player_photo' => $card->player?->photoUrl(),
                    'team_name'    => $card->team?->displayName() ?? '—',
                    'minute'       => $card->minute,
                ]);
            }

            if ($newCards->isNotEmpty()) {
                $this->lastCardId = $newCards->last()->id;
            }
        }
        // ─────────────────────────────────────────────────────────────────────

        // Live matches (in progress right now)
        $liveMatches = $this->tournament->matches()
            ->with(['homeTeam.team', 'awayTeam.team', 'phase'])
            ->whereNull('deleted_at')
            ->where('status', 'in_progress')
            ->orderBy('scheduled_at')
            ->get();

        $goals = TournamentMatchGoal::whereIn('tournament_match_id', $this->tournament->matches()->pluck('id'))->get();
    
    $goalsPlayers = $goals->groupBy('tournament_player_id')->map(function ($playerGoals) {
        $firstGoal = $playerGoals->first();
        return (object) [
            'player' => $firstGoal->player,
            'team' => $firstGoal->team,
            'goals' => $playerGoals->count(),
        ];
    })->sortByDesc('goals')->values();
    
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

        // ── Rotating left panel data ──────────────────────────────────────────
        // All phases ordered
        $phases = TournamentPhase::where('tournament_id', $this->tournament->id)
            ->orderBy('order')
            ->get();

        // Flat matches collection (reuse already-loaded data)
        $allMatchesFlat = $matches->flatten(1);

        // Last 2 completed matches (most recent first)
        $recentMatches = $allMatchesFlat->where('status', 'completed')
            ->sortByDesc('scheduled_at')
            ->take(2)
            ->values();

        // Next 4 upcoming matches (earliest first)
        $upcomingMatches = $allMatchesFlat->whereIn('status', ['scheduled', 'postponed'])
            ->filter(fn($m) => $m->scheduled_at !== null)
            ->sortBy('scheduled_at')
            ->take(4)
            ->values();

        // If fewer than 4 with dates, append scheduled ones without a date
        if ($upcomingMatches->count() < 4) {
            $noDate = $allMatchesFlat->where('status', 'scheduled')
                ->filter(fn($m) => $m->scheduled_at === null)
                ->take(4 - $upcomingMatches->count())
                ->values();
            $upcomingMatches = $upcomingMatches->concat($noDate);
        }

        $recentAndUpcoming = $recentMatches->concat($upcomingMatches);

        // Bracket data for knockout phases
        $bracketData = collect();
        foreach ($phases->whereIn('type', ['knockout', 'double_elimination']) as $kPhase) {
            $kMatches = $allMatchesFlat->where('phase_id', $kPhase->id)
                ->filter(fn($m) => !(($m->settings['is_third_place'] ?? false)))
                ->sortBy([['round', 'asc'], ['match_number', 'asc']])
                ->values();

            $maxRound             = $kMatches->max('round') ?? 0;
            $firstRound           = $kMatches->min('round') ?? 1;
            $totalRounds          = $maxRound > 0 ? $maxRound - $firstRound + 1 : 0;
            $numFirstRoundMatches = max($kMatches->where('round', $firstRound)->count(), 1);

            $rounds = collect();
            for ($r = $firstRound; $r <= $maxRound; $r++) {
                $rounds->put($r, $kMatches->where('round', $r)->sortBy('match_number')->values());
            }

            $thirdPlace = $allMatchesFlat->where('phase_id', $kPhase->id)
                ->first(fn($m) => ($m->settings['is_third_place'] ?? false));

            $bracketData->put($kPhase->id, [
                'phase'                => $kPhase,
                'rounds'               => $rounds,
                'maxRound'             => $maxRound,
                'firstRound'           => $firstRound,
                'totalRounds'          => $totalRounds,
                'numFirstRoundMatches' => $numFirstRoundMatches,
                'thirdPlace'           => $thirdPlace,
                'hasMatches'           => $kMatches->isNotEmpty(),
            ]);
        }

        // Standings indexed by phase_id (for per-phase display in rotating panel)
        $standingsByPhaseId = $standings->flatten(1)->groupBy('phase_id');
        // ─────────────────────────────────────────────────────────────────────

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

        return view('livewire.webclubs.live-detail', [
            'liveMatches'           => $liveMatches,
            'teams'                 => $teams,
            'standings'             => $standings,
            'matchesByPhaseAndRound'=> $matchesByPhaseAndRound,
            'topScorers'            => $topScorers,
            'playerCards'           => $playerCards,
            'goalsPlayers'          => $goalsPlayers,
            'phases'                => $phases,
            'recentAndUpcoming'     => $recentAndUpcoming,
            'bracketData'           => $bracketData,
            'standingsByPhaseId'    => $standingsByPhaseId,
        ])->layout('livewire.webclubs.layouts.app_live', [
            'title' => tenantName() . ' - ' . $this->tournament->name,
        ]);
    }
}
