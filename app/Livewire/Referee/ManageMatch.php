<?php

namespace App\Livewire\Referee;

use App\Models\TournamentMatch;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentMatchCard;
use App\Models\TournamentPlayer;
use Livewire\Component;

class ManageMatch extends Component
{
    public TournamentMatch $match;
    public string $activeTab = 'goals';
    
    // Goal form
    public bool $showGoalForm = false;
    public $goalTeamId = null;
    public $goalPlayerId = null;
    public $goalMinute = '';
    public $goalType = 'normal';
    public $goalPlayerSearch = '';
    
    // Card form
    public bool $showCardForm = false;
    public $cardTeamId = null;
    public $cardPlayerId = null;
    public $cardMinute = '';
    public $cardType = 'yellow';
    public $cardReason = '';
    public $cardPlayerSearch = '';

    // Match notes
    public string $matchNotes = '';
    
    // Player details modal
    public bool $showPlayerDetails = false;
    public $selectedPlayer = null;

    public function mount(TournamentMatch $match)
    {
        // Verificar que el árbitro está asignado a este torneo
        if (!$match->tournament->referees()->where('user_id', auth()->id())->exists()) {
            abort(403, 'No tienes acceso a este partido.');
        }

        $this->match = $match;
        $this->matchNotes = $match->notes ?? '';
    }

    public function openGoalFormForTeam($teamId)
    {
        $this->reset(['goalPlayerId', 'goalPlayerSearch', 'goalMinute', 'goalType']);
        $this->goalTeamId = $teamId;
        $this->showGoalForm = true;
    }

    public function openCardFormForTeam($teamId)
    {
        $this->reset(['cardPlayerId', 'cardPlayerSearch', 'cardMinute', 'cardType', 'cardReason']);
        $this->cardTeamId = $teamId;
        $this->showCardForm = true;
    }

    public function startMatch()
    {
        $this->match->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
        
        $this->match->refresh();
        session()->flash('message', 'Partido iniciado correctamente.');
    }

    public function finishMatch()
    {
        // Calcular marcadores
        $homeGoals = $this->match->goals()->where('tournament_team_id', $this->match->home_team_id)->where('goal_type', '!=', 'own_goal')->count()
                   + $this->match->goals()->where('tournament_team_id', $this->match->away_team_id)->where('goal_type', 'own_goal')->count();
        
        $awayGoals = $this->match->goals()->where('tournament_team_id', $this->match->away_team_id)->where('goal_type', '!=', 'own_goal')->count()
                   + $this->match->goals()->where('tournament_team_id', $this->match->home_team_id)->where('goal_type', 'own_goal')->count();

        $this->match->update([
            'status' => 'completed',
            'completed_at' => now(),
            'home_score' => $homeGoals,
            'away_score' => $awayGoals,
            'notes' => $this->matchNotes,
        ]);

        $this->match->refresh();
        session()->flash('message', 'Partido finalizado correctamente.');
    }

    public function reopenMatch()
    {
        $this->match->update([
            'status' => 'in_progress',
            'completed_at' => null,
        ]);

        $this->match->refresh();
        session()->flash('message', 'Partido reabierto para edición.');
    }

    public function addGoal()
    {
        $this->validate([
            'goalTeamId' => 'required|exists:tournament_teams,id',
            'goalPlayerId' => 'required|exists:tournament_players,id',
            'goalMinute' => 'nullable|integer|min:1|max:180',
            'goalType' => 'required|in:normal,penalty,own_goal',
        ]);

        TournamentMatchGoal::create([
            'tournament_match_id' => $this->match->id,
            'tournament_team_id' => $this->goalTeamId,
            'tournament_player_id' => $this->goalPlayerId,
            'minute' => $this->goalMinute ?: null,
            'goal_type' => $this->goalType,
        ]);

        $this->reset(['showGoalForm', 'goalTeamId', 'goalPlayerId', 'goalMinute', 'goalType', 'goalPlayerSearch']);
        $this->match->refresh();
        session()->flash('message', 'Gol añadido correctamente.');
    }

    public function deleteGoal($goalId)
    {
        $goal = TournamentMatchGoal::findOrFail($goalId);
        
        if ($goal->tournament_match_id !== $this->match->id) {
            abort(403);
        }

        $goal->delete();
        $this->match->refresh();
        session()->flash('message', 'Gol eliminado correctamente.');
    }

    public function addCard()
    {
        $this->validate([
            'cardTeamId' => 'required|exists:tournament_teams,id',
            'cardPlayerId' => 'required|exists:tournament_players,id',
            'cardMinute' => 'nullable|integer|min:1|max:180',
            'cardType' => 'required|in:yellow,red',
            'cardReason' => 'nullable|string|max:500',
        ]);

        TournamentMatchCard::create([
            'tournament_match_id' => $this->match->id,
            'tournament_team_id' => $this->cardTeamId,
            'tournament_player_id' => $this->cardPlayerId,
            'minute' => $this->cardMinute ?: null,
            'card_type' => $this->cardType,
            'notes' => $this->cardReason,
        ]);

        $this->reset(['showCardForm', 'cardTeamId', 'cardPlayerId', 'cardMinute', 'cardType', 'cardReason', 'cardPlayerSearch']);
        $this->match->refresh();
        session()->flash('message', 'Tarjeta añadida correctamente.');
    }

    public function deleteCard($cardId)
    {
        $card = TournamentMatchCard::findOrFail($cardId);
        
        if ($card->tournament_match_id !== $this->match->id) {
            abort(403);
        }

        $card->delete();
        $this->match->refresh();
        session()->flash('message', 'Tarjeta eliminada correctamente.');
    }

    public function saveNotes()
    {
        $this->match->update([
            'notes' => $this->matchNotes,
        ]);

        session()->flash('message', 'Notas guardadas correctamente.');
    }

    public function viewPlayerDetails($playerId)
    {
        $this->selectedPlayer = TournamentPlayer::findOrFail($playerId);
        $this->showPlayerDetails = true;
    }

    public function closePlayerDetails()
    {
        $this->showPlayerDetails = false;
        $this->selectedPlayer = null;
    }

    public function render()
    {
        $goals = $this->match->goals()->with(['player', 'team'])->orderBy('minute')->get();
        $cards = $this->match->cards()->with(['player', 'team'])->orderBy('minute')->get();
        
        $homePlayers = TournamentPlayer::where('tournament_team_id', $this->match->home_team_id)
            ->where('status', 'approved')
            ->orderBy('surname')
            ->get();
        
        $awayPlayers = TournamentPlayer::where('tournament_team_id', $this->match->away_team_id)
            ->where('status', 'approved')
            ->orderBy('surname')
            ->get();

        // Calcular marcador actual
        $homeGoals = $goals->where('tournament_team_id', $this->match->home_team_id)->where('goal_type', '!=', 'own_goal')->count()
                   + $goals->where('tournament_team_id', $this->match->away_team_id)->where('goal_type', 'own_goal')->count();
        
        $awayGoals = $goals->where('tournament_team_id', $this->match->away_team_id)->where('goal_type', '!=', 'own_goal')->count()
                   + $goals->where('tournament_team_id', $this->match->home_team_id)->where('goal_type', 'own_goal')->count();

        return view('livewire.referee.manage-match', compact('goals', 'cards', 'homePlayers', 'awayPlayers', 'homeGoals', 'awayGoals'));
    }
}
