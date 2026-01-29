<?php

namespace App\Livewire\Matches;

use Livewire\Component;
use App\Models\SeasonMatch;
use App\Models\Season;
use App\Models\Team;
use App\Models\Player;

class Create extends Component
{
    public $season_id = '';
    public $team_id = '';
    public $opponent = '';
    public $date = '';
    public $hour_match = '';
    public $hour_meeting = '';
    public $site = '';
    public $observations = '';
    public $match_description = '';
    
    // Convocatoria - dos columnas
    public $calledPlayers = []; // Jugadores convocados (columna derecha)
    public $notCalledPlayers = []; // Jugadores no convocados (columna izquierda)
    public $playerReasons = []; // Razones de no convocatoria [playerId => reason]
    
    public $maxPlayers = 18;

    protected $rules = [
        'season_id' => 'required|exists:seasons,id',
        'team_id' => 'required|exists:teams,id',
        'opponent' => 'required|string|max:255',
        'date' => 'required|date',
        'hour_match' => 'nullable|date_format:H:i',
        'hour_meeting' => 'nullable|date_format:H:i',
        'site' => 'nullable|string|max:255',
        'observations' => 'nullable|string',
        'match_description' => 'nullable|string',
    ];

    public function mount()
    {
        // Set default season to active season
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($activeSeason) {
            $this->season_id = $activeSeason->id;
        }
    }

    public function loadTeamPlayers()
    {
        if ($this->team_id) {
            $team = Team::find($this->team_id);
            if ($team) {
                $allPlayers = $team->players()->pluck('players.id')->toArray();
                $this->notCalledPlayers = array_diff($allPlayers, $this->calledPlayers);
            }
        }
    }

    public function updatedSeasonId()
    {
        // Reset team when season changes
        $this->team_id = '';
        $this->calledPlayers = [];
        $this->notCalledPlayers = [];
        $this->playerReasons = [];
    }

    public function updatedTeamId()
    {
        $this->loadTeamPlayers();
    }

    public function addPlayer($playerId)
    {
        if (count($this->calledPlayers) >= $this->maxPlayers) {
            session()->flash('error', 'No se pueden convocar más de ' . $this->maxPlayers . ' jugadores.');
            return;
        }

        if (!in_array($playerId, $this->calledPlayers)) {
            $this->calledPlayers[] = $playerId;
            $this->notCalledPlayers = array_diff($this->notCalledPlayers, [$playerId]);
            
            // Clear reason when adding player
            if (isset($this->playerReasons[$playerId])) {
                unset($this->playerReasons[$playerId]);
            }
        }
    }

    public function removePlayer($playerId)
    {
        $this->calledPlayers = array_diff($this->calledPlayers, [$playerId]);
        if (!in_array($playerId, $this->notCalledPlayers)) {
            $this->notCalledPlayers[] = $playerId;
        }
    }

    public function save()
    {
        $this->validate();

        $match = SeasonMatch::create([
            'season_id' => $this->season_id,
            'team_id' => $this->team_id,
            'sports_school_id' => auth()->user()->sports_school_id,
            'opponent' => $this->opponent,
            'date' => $this->date,
            'hour_match' => $this->hour_match,
            'hour_meeting' => $this->hour_meeting,
            'site' => $this->site,
            'observations' => $this->observations,
            'match_description' => $this->match_description,
            'created_user' => auth()->user()->id,
            'updated_user' => auth()->user()->id,
        ]);

        // Sync ONLY called players
        $syncData = [];
        foreach ($this->calledPlayers as $playerId) {
            $syncData[$playerId] = [
                'created_user' => auth()->user()->id,
                'updated_user' => auth()->user()->id,
                'reason_not_called' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        $match->players()->sync($syncData);

        session()->flash('message', 'Partido creado correctamente.');
        return redirect()->route('matches.edit', $match->id);
    }

    public function render()
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('from_year', 'desc')
            ->get();

        $teams = Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->when($this->season_id, function ($query) {
                $query->where('season_id', $this->season_id);
            })
            ->with('category')
            ->orderBy('team')
            ->get();

        // Get players for both columns
        $calledPlayersData = Player::whereIn('id', $this->calledPlayers)
            ->select('id', 'name', 'surname', 'player_photo', 'position', 'sports_school_id')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
            
        $notCalledPlayersData = Player::whereIn('id', $this->notCalledPlayers)
            ->select('id', 'name', 'surname', 'player_photo', 'position', 'sports_school_id')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        return view('livewire.matches.create', [
            'seasons' => $seasons,
            'teams' => $teams,
            'calledPlayersData' => $calledPlayersData,
            'notCalledPlayersData' => $notCalledPlayersData,
        ]);
    }
}
