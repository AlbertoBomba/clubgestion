<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentMatchCard;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentSanction;
use App\Models\TournamentTeam;
use Livewire\Component;

class TournamentStats extends Component
{
    public Tournament $tournament;

    public string $activeTab = 'scorers'; // scorers | cards | sanctions

    public function mount(Tournament $tournament): void
    {
        abort_unless($tournament->sports_school_id === auth()->user()->sports_school_id, 403);
        $this->tournament = $tournament;
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function toggleSanctionActive(int $id): void
    {
        $sanction = TournamentSanction::where('id', $id)
            ->where('tournament_id', $this->tournament->id)
            ->firstOrFail();
        $sanction->update(['active' => ! $sanction->active]);
        session()->flash('stats_message', 'Estado de sanción actualizado.');
    }

    public function incrementServed(int $id): void
    {
        $sanction = TournamentSanction::where('id', $id)
            ->where('tournament_id', $this->tournament->id)
            ->firstOrFail();

        if ($sanction->matches_served < $sanction->matches_suspended) {
            $served = $sanction->matches_served + 1;
            $sanction->update([
                'matches_served' => $served,
                'active'         => $served < $sanction->matches_suspended,
            ]);
            session()->flash('stats_message', 'Partido de sanción cumplido registrado.');
        }
    }

    public function render()
    {
        $matchIds = $this->tournament->matches()->pluck('id');

        // ── Scorers ranking
        $scorers = TournamentMatchGoal::whereIn('tournament_match_id', $matchIds)
            ->where('goal_type', '!=', 'own_goal') // propia no cuenta para el goleador
            ->with(['player', 'team'])
            ->get()
            ->groupBy('tournament_player_id')
            ->map(function ($goals) {
                $first = $goals->first();
                return [
                    'player'   => $first->player,
                    'team'     => $first->team,
                    'goals'    => $goals->count(),
                    'penalties'=> $goals->where('goal_type', 'penalty')->count(),
                ];
            })
            ->sortByDesc('goals')
            ->values();

        // ── Cards ranking
        $cardsRanking = TournamentMatchCard::whereIn('tournament_match_id', $matchIds)
            ->with(['player', 'team'])
            ->get()
            ->groupBy('tournament_player_id')
            ->map(function ($cards) {
                $first = $cards->first();
                return [
                    'player'        => $first->player,
                    'team'          => $first->team,
                    'yellows'       => $cards->where('card_type', 'yellow')->count(),
                    'reds'          => $cards->whereIn('card_type', ['red', 'double_yellow'])->count(),
                    'double_yellow' => $cards->where('card_type', 'double_yellow')->count(),
                    'total'         => $cards->count(),
                ];
            })
            ->sortByDesc('total')
            ->values();

        // ── Sanctions
        $sanctions = TournamentSanction::where('tournament_id', $this->tournament->id)
            ->with(['player', 'team', 'originMatch.homeTeam', 'originMatch.awayTeam'])
            ->latest()
            ->get();

        $teams = TournamentTeam::where('tournament_id', $this->tournament->id)->get();

        return view('livewire.tournaments.tournament-stats', compact(
            'scorers', 'cardsRanking', 'sanctions', 'teams'
        ));
    }
}
