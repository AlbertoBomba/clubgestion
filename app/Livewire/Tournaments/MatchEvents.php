<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentMatchCard;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentPhase;
use App\Models\TournamentPlayer;
use App\Models\TournamentSanction;
use App\Models\TournamentStanding;
use App\Models\TournamentTeam;
use Livewire\Component;

class MatchEvents extends Component
{
    public Tournament $tournament;
    public TournamentMatch $match;

    // ──────────────────────────── Add Goal Form
    public bool   $showGoalForm    = false;
    public string $goal_team_id    = '';
    public string $goal_player_id  = '';
    public string $goal_type       = 'normal';
    public string $goal_minute     = '';
    public string $goal_notes      = '';

    // ──────────────────────────── Add Card Form
    public bool   $showCardForm    = false;
    public string $card_team_id    = '';
    public string $card_player_id  = '';
    public string $card_type       = 'yellow';
    public string $card_minute     = '';
    public string $card_notes      = '';

    // ──────────────────────────── Add Sanction Form
    public bool   $showSanctionForm     = false;
    public string $sanction_team_id     = '';
    public string $sanction_player_id   = '';
    public string $sanction_type        = 'suspension';
    public string $sanction_matches     = '1';
    public string $sanction_reason      = '';
    public string $sanction_notes       = '';

    // ──────────────────────────── Delete confirms
    public ?int   $deletingGoalId       = null;
    public ?int   $deletingCardId       = null;
    public ?int   $deletingSanctionId   = null;

    public function mount(Tournament $tournament, TournamentMatch $match): void
    {
        abort_unless($tournament->sports_school_id === auth()->user()->sports_school_id, 403);
        abort_unless($match->tournament_id === $tournament->id, 403);

        $this->tournament = $tournament;
        $this->match      = $match;
    }

    // ==================================================================
    // Goals
    // ==================================================================

    public function openGoalForm(): void
    {
        $this->reset(['goal_team_id', 'goal_player_id', 'goal_type', 'goal_minute', 'goal_notes']);
        $this->goal_type    = 'normal';
        $this->showGoalForm = true;
    }

    public function saveGoal(): void
    {
        $this->validate([
            'goal_team_id'   => 'required|exists:tournament_teams,id',
            'goal_player_id' => 'required|exists:tournament_players,id',
            'goal_type'      => 'required|in:normal,penalty,own_goal',
            'goal_minute'    => 'nullable|integer|min:1|max:180',
            'goal_notes'     => 'nullable|string|max:500',
        ]);

        // Verify player belongs to the team
        $player = TournamentPlayer::where('id', $this->goal_player_id)
            ->where('tournament_team_id', $this->goal_team_id)
            ->firstOrFail();

        TournamentMatchGoal::create([
            'tournament_match_id'  => $this->match->id,
            'tournament_player_id' => $player->id,
            'tournament_team_id'   => (int) $this->goal_team_id,
            'goal_type'            => $this->goal_type,
            'minute'               => $this->goal_minute !== '' ? (int) $this->goal_minute : null,
            'notes'                => $this->goal_notes ?: null,
        ]);

        $this->showGoalForm = false;
        $this->recalculateMatchScore();
        $this->match->refresh();
        session()->flash('events_message', 'Gol registrado correctamente.');
    }

    public function confirmDeleteGoal(int $id): void
    {
        $this->deletingGoalId = $id;
    }

    public function deleteGoal(): void
    {
        TournamentMatchGoal::where('id', $this->deletingGoalId)
            ->where('tournament_match_id', $this->match->id)
            ->delete();
        $this->deletingGoalId = null;
        $this->recalculateMatchScore();
        $this->match->refresh();
        session()->flash('events_message', 'Gol eliminado.');
    }

    // ==================================================================
    // Cards
    // ==================================================================

    public function openCardForm(): void
    {
        $this->reset(['card_team_id', 'card_player_id', 'card_type', 'card_minute', 'card_notes']);
        $this->card_type    = 'yellow';
        $this->showCardForm = true;
    }

    public function saveCard(): void
    {
        $this->validate([
            'card_team_id'   => 'required|exists:tournament_teams,id',
            'card_player_id' => 'required|exists:tournament_players,id',
            'card_type'      => 'required|in:yellow,red,double_yellow',
            'card_minute'    => 'nullable|integer|min:1|max:180',
            'card_notes'     => 'nullable|string|max:500',
        ]);

        $player = TournamentPlayer::where('id', $this->card_player_id)
            ->where('tournament_team_id', $this->card_team_id)
            ->firstOrFail();

        TournamentMatchCard::create([
            'tournament_match_id'  => $this->match->id,
            'tournament_player_id' => $player->id,
            'tournament_team_id'   => (int) $this->card_team_id,
            'card_type'            => $this->card_type,
            'minute'               => $this->card_minute !== '' ? (int) $this->card_minute : null,
            'notes'                => $this->card_notes ?: null,
        ]);

        // Auto-create suspension for red cards (1 match) if not already exists
        if (in_array($this->card_type, ['red', 'double_yellow'])) {
            TournamentSanction::create([
                'tournament_id'        => $this->tournament->id,
                'tournament_match_id'  => $this->match->id,
                'tournament_team_id'   => (int) $this->card_team_id,
                'tournament_player_id' => $player->id,
                'sanction_type'        => 'suspension',
                'matches_suspended'    => 1,
                'matches_served'       => 0,
                'reason'               => $this->card_type === 'red' ? 'Expulsión por tarjeta roja directa' : 'Expulsión por doble amarilla',
                'active'               => true,
            ]);
            session()->flash('events_message', 'Tarjeta registrada. Se ha generado automáticamente una sanción de 1 partido.');
        } else {
            session()->flash('events_message', 'Tarjeta registrada correctamente.');
        }

        $this->showCardForm = false;
        $this->match->refresh();
    }

    public function confirmDeleteCard(int $id): void
    {
        $this->deletingCardId = $id;
    }

    public function deleteCard(): void
    {
        TournamentMatchCard::where('id', $this->deletingCardId)
            ->where('tournament_match_id', $this->match->id)
            ->delete();
        $this->deletingCardId = null;
        $this->match->refresh();
        session()->flash('events_message', 'Tarjeta eliminada.');
    }

    // ==================================================================
    // Sanctions
    // ==================================================================

    public function openSanctionForm(): void
    {
        $this->reset(['sanction_team_id', 'sanction_player_id', 'sanction_type', 'sanction_matches', 'sanction_reason', 'sanction_notes']);
        $this->sanction_type    = 'suspension';
        $this->sanction_matches = '1';
        $this->showSanctionForm = true;
    }

    public function saveSanction(): void
    {
        $this->validate([
            'sanction_team_id'   => 'nullable|exists:tournament_teams,id',
            'sanction_player_id' => 'nullable|exists:tournament_players,id',
            'sanction_type'      => 'required|in:suspension,warning,fine,disqualification',
            'sanction_matches'   => 'required|integer|min:0|max:99',
            'sanction_reason'    => 'nullable|string|max:500',
            'sanction_notes'     => 'nullable|string|max:1000',
        ]);

        // At least one target required
        if (! $this->sanction_team_id && ! $this->sanction_player_id) {
            $this->addError('sanction_team_id', 'Debes seleccionar al menos un equipo o jugador.');
            return;
        }

        TournamentSanction::create([
            'tournament_id'        => $this->tournament->id,
            'tournament_match_id'  => $this->match->id,
            'tournament_team_id'   => $this->sanction_team_id   ?: null,
            'tournament_player_id' => $this->sanction_player_id ?: null,
            'sanction_type'        => $this->sanction_type,
            'matches_suspended'    => (int) $this->sanction_matches,
            'matches_served'       => 0,
            'reason'               => $this->sanction_reason ?: null,
            'notes'                => $this->sanction_notes ?: null,
            'active'               => true,
        ]);

        $this->showSanctionForm = false;
        session()->flash('events_message', 'Sanción registrada correctamente.');
    }

    public function toggleSanctionActive(int $id): void
    {
        $sanction = TournamentSanction::where('id', $id)
            ->where('tournament_id', $this->tournament->id)
            ->firstOrFail();
        $sanction->update(['active' => ! $sanction->active]);
        session()->flash('events_message', 'Estado de sanción actualizado.');
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
            session()->flash('events_message', 'Partido de sanción cumplido registrado.');
        }
    }

    public function confirmDeleteSanction(int $id): void
    {
        $this->deletingSanctionId = $id;
    }

    public function deleteSanction(): void
    {
        TournamentSanction::where('id', $this->deletingSanctionId)
            ->where('tournament_id', $this->tournament->id)
            ->delete();
        $this->deletingSanctionId = null;
        session()->flash('events_message', 'Sanción eliminada.');
    }

    // ==================================================================
    // Score recalculation
    // ==================================================================

    private function recalculateMatchScore(): void
    {
        $this->match->loadMissing('phase');
        $goals = TournamentMatchGoal::where('tournament_match_id', $this->match->id)->get();

        $homeScore = $goals->filter(
                fn($g) => $g->tournament_team_id === $this->match->home_team_id && $g->goal_type !== 'own_goal'
            )->count()
            + $goals->filter(
                fn($g) => $g->tournament_team_id === $this->match->away_team_id && $g->goal_type === 'own_goal'
            )->count();

        $awayScore = $goals->filter(
                fn($g) => $g->tournament_team_id === $this->match->away_team_id && $g->goal_type !== 'own_goal'
            )->count()
            + $goals->filter(
                fn($g) => $g->tournament_team_id === $this->match->home_team_id && $g->goal_type === 'own_goal'
            )->count();

        $this->match->update([
            'home_score'   => $homeScore,
            'away_score'   => $awayScore,
            'status'       => $goals->isNotEmpty() ? 'completed' : $this->match->status,
            'played_at'    => ($goals->isNotEmpty() && ! $this->match->played_at) ? now() : $this->match->played_at,
            'updated_user' => auth()->id(),
        ]);

        // Recalculate standings for league/group phases
        if ($this->match->phase && in_array($this->match->phase->type, ['league', 'group'])) {
            $this->recalculateStandings($this->match->phase_id);
        }
    }

    private function recalculateStandings(int $phaseId): void
    {
        $phase    = TournamentPhase::find($phaseId);
        if (! $phase) return;

        $settings = $this->tournament->settings ?? [];
        $ptWin    = $settings['points_per_win']  ?? 3;
        $ptDraw   = $settings['points_per_draw'] ?? 1;
        $ptLoss   = $settings['points_per_loss'] ?? 0;

        $teamIds = TournamentTeam::where('tournament_category_id', $phase->tournament_category_id)->pluck('id');

        TournamentStanding::where('phase_id', $phaseId)->delete();

        $stats = [];
        foreach ($teamIds as $ttId) {
            $stats[$ttId] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,'group_label'=>null];
        }

        $matches = TournamentMatch::where('phase_id', $phaseId)
            ->where('status', 'completed')
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->get();

        foreach ($matches as $m) {
            $h = $m->home_team_id;
            $a = $m->away_team_id;

            if (! isset($stats[$h])) {
                $stats[$h] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,'group_label'=>null];
            }
            if (! isset($stats[$a])) {
                $stats[$a] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,'group_label'=>null];
            }

            $stats[$h]['played']++;
            $stats[$a]['played']++;
            $stats[$h]['goals_for']     += $m->home_score;
            $stats[$h]['goals_against'] += $m->away_score;
            $stats[$a]['goals_for']     += $m->away_score;
            $stats[$a]['goals_against'] += $m->home_score;

            if ($m->home_score > $m->away_score) {
                $stats[$h]['won']++;    $stats[$h]['points'] += $ptWin;
                $stats[$a]['lost']++;   $stats[$a]['points'] += $ptLoss;
            } elseif ($m->home_score < $m->away_score) {
                $stats[$a]['won']++;    $stats[$a]['points'] += $ptWin;
                $stats[$h]['lost']++;   $stats[$h]['points'] += $ptLoss;
            } else {
                $stats[$h]['drawn']++;  $stats[$h]['points'] += $ptDraw;
                $stats[$a]['drawn']++;  $stats[$a]['points'] += $ptDraw;
            }
        }

        $rows = collect($stats)->map(fn($s, $tid) => array_merge($s, ['team_id' => $tid, 'gd' => $s['goals_for'] - $s['goals_against']]))
            ->sortByDesc('points')->sortByDesc('gd')->values();

        foreach ($rows as $pos => $row) {
            TournamentStanding::create([
                'tournament_id'          => $this->tournament->id,
                'tournament_category_id' => $phase->tournament_category_id,
                'phase_id'               => $phaseId,
                'tournament_team_id'     => $row['team_id'],
                'position'               => $pos + 1,
                'played'                 => $row['played'],
                'won'                    => $row['won'],
                'drawn'                  => $row['drawn'],
                'lost'                   => $row['lost'],
                'goals_for'              => $row['goals_for'],
                'goals_against'          => $row['goals_against'],
                'goal_difference'        => $row['gd'],
                'points'                 => $row['points'],
            ]);
        }
    }

    // ==================================================================
    // Render
    // ==================================================================

    public function render()
    {
        $teams = TournamentTeam::where('tournament_id', $this->tournament->id)
            ->with(['players' => fn($q) => $q->orderBy('surname')->orderBy('name')])
            ->get();

        $goals = TournamentMatchGoal::where('tournament_match_id', $this->match->id)
            ->with(['player', 'team'])
            ->orderBy('minute')
            ->get();

        $cards = TournamentMatchCard::where('tournament_match_id', $this->match->id)
            ->with(['player', 'team'])
            ->orderBy('minute')
            ->get();

        $sanctions = TournamentSanction::where('tournament_match_id', $this->match->id)
            ->with(['player', 'team'])
            ->latest()
            ->get();

        // Players for the selected goal/card team
        $goalTeamPlayers = $this->goal_team_id
            ? TournamentPlayer::where('tournament_team_id', $this->goal_team_id)
                ->orderBy('surname')->orderBy('name')->get()
            : collect();

        $cardTeamPlayers = $this->card_team_id
            ? TournamentPlayer::where('tournament_team_id', $this->card_team_id)
                ->orderBy('surname')->orderBy('name')->get()
            : collect();

        $sanctionTeamPlayers = $this->sanction_team_id
            ? TournamentPlayer::where('tournament_team_id', $this->sanction_team_id)
                ->orderBy('surname')->orderBy('name')->get()
            : collect();

        return view('livewire.tournaments.match-events', compact(
            'teams', 'goals', 'cards', 'sanctions',
            'goalTeamPlayers', 'cardTeamPlayers', 'sanctionTeamPlayers'
        ));
    }
}
