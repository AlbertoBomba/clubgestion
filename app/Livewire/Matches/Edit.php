<?php

namespace App\Livewire\Matches;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SeasonMatch;
use App\Models\Season;
use App\Models\Team;
use App\Models\Player;
use App\Classes\PdfFile;

class Edit extends Component
{
    use WithFileUploads;
    public SeasonMatch $match;
    
    public $season_id = '';
    public $team_id = '';
    public $opponent = '';
    public $date = '';
    public $hour_match = '';
    public $hour_meeting = '';
    public $site = '';
    public $observations = '';
    public $goals_team = '';
    public $goals_oponent = '';
    public $escudo_team_oponent = '';
    public $sites = '';
    public $newEscudoTeamOponent = null; // Temporary file upload
    
    // Convocatoria - dos columnas
    public $calledPlayers = []; // Jugadores convocados (columna derecha)
    public $notCalledPlayers = []; // Jugadores no convocados (columna izquierda)
    public $playerReasons = []; // Razones de no convocatoria [playerId => reason]
    
    public $maxPlayers = 25;
    
    // Modal para añadir jugadores de otros equipos
    public $showAddExternalPlayerModal = false;
    public $selectedExternalTeamId = '';
    public $externalPlayers = [];
    public $searchExternalPlayer = '';

    protected $rules = [
        'season_id' => 'required|exists:seasons,id',
        'team_id' => 'required|exists:teams,id',
        'opponent' => 'required|string|max:255',
        'date' => 'required|date',
        'hour_match' => 'nullable|date_format:H:i',
        'hour_meeting' => 'nullable|date_format:H:i',
        'site' => 'nullable|string|max:255',
        'observations' => 'nullable|string',
        'goals_team' => 'nullable|integer|min:0',
        'goals_oponent' => 'nullable|integer|min:0',
        'escudo_team_oponent' => 'nullable|string|max:255',
        'sites' => 'nullable|in:home,away',
        'newEscudoTeamOponent' => 'nullable|image|max:2048',
    ];

    public function mount(SeasonMatch $match)
    {
        // Verify the match belongs to the user's sports school
        if ($match->sports_school_id != auth()->user()->sports_school_id) {
            abort(403);
        }

        $this->match = $match;
        $this->season_id = $match->season_id;
        $this->team_id = $match->team_id;
        $this->opponent = $match->opponent;
        $this->date = $match->date->format('Y-m-d');
        $this->hour_match = $match->hour_match ? $match->hour_match->format('H:i') : '';
        $this->hour_meeting = $match->hour_meeting ? $match->hour_meeting->format('H:i') : '';
        $this->site = $match->site ?? '';
        $this->observations = $match->observations ?? '';
        $this->goals_team = $match->goals_team ?? '';
        $this->goals_oponent = $match->goals_oponent ?? '';
        $this->escudo_team_oponent = $match->escudo_team_oponent ?? '';
        $this->sites = $match->sites ?? '';
        
        // Load called players with their reasons
        $calledPlayerIds = [];
        foreach ($match->players as $player) {
            $calledPlayerIds[] = $player->id;
            if ($player->pivot->reason_not_called) {
                $this->playerReasons[$player->id] = $player->pivot->reason_not_called;
            }
        }
        $this->calledPlayers = $calledPlayerIds;
        
        // Load all team players to separate called/not called
        $this->loadTeamPlayers();
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
    
    public function openAddExternalPlayerModal()
    {
        $this->showAddExternalPlayerModal = true;
        $this->selectedExternalTeamId = '';
        $this->externalPlayers = [];
        $this->searchExternalPlayer = '';
    }
    
    public function closeAddExternalPlayerModal()
    {
        $this->showAddExternalPlayerModal = false;
        $this->selectedExternalTeamId = '';
        $this->externalPlayers = [];
        $this->searchExternalPlayer = '';
    }
    
    public function updatedSelectedExternalTeamId()
    {
        if ($this->selectedExternalTeamId) {
            $this->loadExternalPlayers();
        } else {
            $this->externalPlayers = [];
        }
    }
    
    public function loadExternalPlayers()
    {
        if (!$this->selectedExternalTeamId) {
            $this->externalPlayers = [];
            return;
        }
        
        $team = Team::find($this->selectedExternalTeamId);
        if ($team) {
            $this->externalPlayers = $team->players()
                ->select('players.id', 'players.name', 'players.surname', 'players.player_photo', 'players.position', 'players.dni')
                ->orderBy('surname')
                ->orderBy('name')
                ->get()
                ->toArray();
        }
    }
    
    public function addExternalPlayer($playerId)
    {
        if (count($this->calledPlayers) >= $this->maxPlayers) {
            session()->flash('error', 'No se pueden convocar más de ' . $this->maxPlayers . ' jugadores.');
            return;
        }
        
        if (!in_array($playerId, $this->calledPlayers)) {
            $this->calledPlayers[] = $playerId;
            
            // Remove from notCalledPlayers if it was there
            $this->notCalledPlayers = array_diff($this->notCalledPlayers, [$playerId]);
            
            // Clear reason when adding player
            if (isset($this->playerReasons[$playerId])) {
                unset($this->playerReasons[$playerId]);
            }
            
            $this->closeAddExternalPlayerModal();
            session()->flash('message', 'Jugador añadido correctamente a la convocatoria.');
        }
    }

    public function update()
    {
        $this->validate();

        // Handle file upload for escudo
        $escudoPath = $this->escudo_team_oponent;
        if ($this->newEscudoTeamOponent) {
            // Delete old file if exists
            if ($this->escudo_team_oponent && \Storage::disk('public')->exists($this->escudo_team_oponent)) {
                \Storage::disk('public')->delete($this->escudo_team_oponent);
            }
            // Store new file
            $escudoPath = $this->newEscudoTeamOponent->store('escudos', 'public');
        }

        $this->match->update([
            'season_id' => $this->season_id,
            'team_id' => $this->team_id,
            'opponent' => $this->opponent,
            'date' => $this->date,
            'hour_match' => $this->hour_match,
            'hour_meeting' => $this->hour_meeting,
            'site' => $this->site,
            'observations' => $this->observations,
            'goals_team' => $this->goals_team ?: null,
            'goals_oponent' => $this->goals_oponent ?: null,
            'escudo_team_oponent' => $escudoPath,
            'sites' => $this->sites ?: null,
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
        
        $this->match->players()->sync($syncData);

        session()->flash('message', 'Partido actualizado correctamente.');
        return redirect()->route('matches.index');
    }

    public function printPDF()
    {
        // Reload match to ensure fresh data
        $match = SeasonMatch::findOrFail($this->match->id);
        
        $pdf = new PdfFile();
        $pdf->file_name = 'convocatoria_' . $match->id;
        $pdf->templates[0] = 'pdfs.match-convocatoria';
        
        // Get called players with full details
        $calledPlayers = Player::whereIn('id', $this->calledPlayers)
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
        
        $team = Team::find($this->team_id);
        
        // Use single 'data' key so length() returns 1
        $pdf->records = ['data' => compact('match', 'calledPlayers', 'team')];

        $content = $pdf->generateFromTemplate($pdf->templates[0]);

        return response()->streamDownload(
            fn () => print($content),
            $pdf->getFileName()
        );
    }

    public function generateShareLink()
    {
        if (!$this->match->share_token) {
            $this->match->generateShareToken();
        }
        
        session()->flash('share_link', $this->match->getPublicUrl());
        session()->flash('message', 'Enlace generado correctamente. Copia el enlace para compartir con los jugadores.');
    }

    public function viewPublicConvocatoria()
    {
        if (!$this->match->share_token) {
            $this->match->generateShareToken();
        }
        
        return redirect()->route('public.convocatoria', ['token' => $this->match->share_token]);
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
        
        // Get all teams for external player modal (excluding current team)
        $allTeams = Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->where('id', '!=', $this->team_id)
            ->with('category', 'season')
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

        return view('livewire.matches.edit', [
            'seasons' => $seasons,
            'teams' => $teams,
            'calledPlayersData' => $calledPlayersData,
            'notCalledPlayersData' => $notCalledPlayersData,
            'allTeams' => $allTeams,
        ]);
    }
}
