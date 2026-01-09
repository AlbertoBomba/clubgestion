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
    public $match_description = '';
    public $goals_team = '';
    public $goals_oponent = '';
    public $escudo_team_oponent = '';
    public $sites = '';
    public $newEscudoTeamOponent = null; // Temporary file upload
    
    // Convocatoria - dos columnas
    public $calledPlayers = []; // Jugadores convocados (columna derecha)
    public $notCalledPlayers = []; // Jugadores no convocados (columna izquierda)
    public $playerReasons = []; // Razones de no convocatoria [playerId => reason]
    public $notCalledPlayerReasons = []; // Razones de jugadores no convocados [playerId => reason]
    
    public $maxPlayers = 25;
    
    // Formación y alineación táctica
    public $footballType = 11; // 7, 8 o 11
    public $formation = '';
    public $lineup = [];
    public $availableFormations = [
        7 => [
            '1-2-3-1' => ['lines' => [1, 2, 3, 1], 'name' => '2-3-1 Clásico F7'],
            '1-3-2-1' => ['lines' => [1, 3, 2, 1], 'name' => '3-2-1 Defensivo F7'],
            '1-2-2-2' => ['lines' => [1, 2, 2, 2], 'name' => '2-2-2 Equilibrado F7'],
            '1-1-3-2' => ['lines' => [1, 1, 3, 2], 'name' => '1-3-2 con Pivote F7'],
        ],
        8 => [
            '1-3-3-1' => ['lines' => [1, 3, 3, 1], 'name' => '3-3-1 Equilibrado F8'],
            '1-2-3-2' => ['lines' => [1, 2, 3, 2], 'name' => '2-3-2 Ofensivo F8'],
            '1-3-2-2' => ['lines' => [1, 3, 2, 2], 'name' => '3-2-2 Clásico F8'],
            '1-2-4-1' => ['lines' => [1, 2, 4, 1], 'name' => '2-4-1 con Mediocampo F8'],
        ],
        11 => [
            '1-4-4-2' => ['lines' => [1, 4, 4, 2], 'name' => '4-4-2 Clásico'],
            '1-4-3-3' => ['lines' => [1, 4, 3, 3], 'name' => '4-3-3 Ofensivo'],
            '1-4-2-3-1' => ['lines' => [1, 4, 2, 3, 1], 'name' => '4-2-3-1 Moderno'],
            '1-3-5-2' => ['lines' => [1, 3, 5, 2], 'name' => '3-5-2 con carrileros'],
            '1-3-4-3' => ['lines' => [1, 3, 4, 3], 'name' => '3-4-3 Ultra ofensivo'],
            '1-5-3-2' => ['lines' => [1, 5, 3, 2], 'name' => '5-3-2 Defensivo'],
            '1-4-1-4-1' => ['lines' => [1, 4, 1, 4, 1], 'name' => '4-1-4-1 con pivote'],
            '1-4-5-1' => ['lines' => [1, 4, 5, 1], 'name' => '4-5-1 Muy defensivo'],
        ],
    ];
    
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
        'match_description' => 'nullable|string',
        'goals_team' => 'nullable|integer|min:0',
        'goals_oponent' => 'nullable|integer|min:0',
        'escudo_team_oponent' => 'nullable|string|max:255',
        'sites' => 'nullable|in:home,away',
        'newEscudoTeamOponent' => 'nullable|image|max:2048',
        'footballType' => 'required|in:7,8,11',
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
        $this->match_description = $match->match_description ?? '';
        $this->goals_team = $match->goals_team ?? '';
        $this->goals_oponent = $match->goals_oponent ?? '';
        $this->escudo_team_oponent = $match->escudo_team_oponent ?? '';
        $this->sites = $match->sites ?? '';
        $this->formation = $match->formation ?? '';
        $this->lineup = $match->lineup ?? [];
        $this->footballType = $match->football_type ?? 11;
        
        // Load called players with their reasons
        $calledPlayerIds = [];
        foreach ($match->players as $player) {
            $calledPlayerIds[] = $player->id;
            if ($player->pivot->reason_not_called) {
                $this->playerReasons[$player->id] = $player->pivot->reason_not_called;
            }
        }
        $this->calledPlayers = $calledPlayerIds;
        
        // Load not called players with their reasons
        foreach ($match->notCalledPlayers as $player) {
            $this->notCalledPlayerReasons[$player->id] = $player->pivot->reason ?? '';
        }
        
        // Load all team players to separate called/not called
        $this->loadTeamPlayers();
    }

    public function loadTeamPlayers()
    {
        if ($this->team_id) {
            $team = Team::find($this->team_id);
            if ($team) {
                $allPlayers = $team->players()->pluck('players.id')->toArray();
                $notCalledPlayerIds = array_keys($this->notCalledPlayerReasons);
                $excludedPlayers = array_merge($this->calledPlayers, $notCalledPlayerIds);
                $this->notCalledPlayers = array_diff($allPlayers, $excludedPlayers);
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
            
            // Clear not called reason when adding player
            if (isset($this->notCalledPlayerReasons[$playerId])) {
                unset($this->notCalledPlayerReasons[$playerId]);
            }
        }
    }

    public function removePlayer($playerId)
    {
        // Verificar si el jugador ha confirmado su convocatoria
        $player = $this->match->players()->where('player_id', $playerId)->first();
        
        if ($player && $player->pivot->confirmed) {
            session()->flash('error', 'No se puede quitar de la convocatoria a un jugador que ya ha confirmado su asistencia.');
            return;
        }
        
        $this->calledPlayers = array_diff($this->calledPlayers, [$playerId]);
        if (!in_array($playerId, $this->notCalledPlayers)) {
            $this->notCalledPlayers[] = $playerId;
        }
    }
    
    public function markAsNotCalled($playerId, $reason = '')
    {
        // Verificar si el jugador ha confirmado su convocatoria
        $player = $this->match->players()->where('player_id', $playerId)->first();
        
        if ($player && $player->pivot->confirmed) {
            session()->flash('error', 'No se puede marcar como no convocado a un jugador que ya ha confirmado su asistencia.');
            return;
        }
        
        // Remove from called players if exists
        $this->calledPlayers = array_diff($this->calledPlayers, [$playerId]);
        
        // Remove from available players
        $this->notCalledPlayers = array_diff($this->notCalledPlayers, [$playerId]);
        
        // Always add to notCalledPlayerReasons (even with empty reason)
        $this->notCalledPlayerReasons[$playerId] = $reason;
    }
    
    public function removeFromNotCalled($playerId)
    {
        // Remove reason
        if (isset($this->notCalledPlayerReasons[$playerId])) {
            unset($this->notCalledPlayerReasons[$playerId]);
        }
        
        // Add back to available players
        if (!in_array($playerId, $this->notCalledPlayers)) {
            $this->notCalledPlayers[] = $playerId;
        }
    }
    
    public function toggleCard($playerId, $cardType)
    {
        // Load current card status from database
        $player = $this->match->players()->where('player_id', $playerId)->first();
        
        if (!$player) {
            return;
        }
        
        $currentValue = $player->pivot->$cardType ?? false;
        
        // If toggling red card, remove yellow cards
        if ($cardType === 'card_red' && !$currentValue) {
            $this->match->players()->updateExistingPivot($playerId, [
                'card_yellow1' => false,
                'card_yellow2' => false,
                'card_red' => true,
                'updated_at' => now(),
            ]);
        }
        // If toggling second yellow, auto-add red card
        elseif ($cardType === 'card_yellow2' && !$currentValue) {
            $this->match->players()->updateExistingPivot($playerId, [
                'card_yellow2' => true,
                'card_red' => true,
                'updated_at' => now(),
            ]);
        }
        // Normal toggle
        else {
            $this->match->players()->updateExistingPivot($playerId, [
                $cardType => !$currentValue,
                'updated_at' => now(),
            ]);
        }
        
        // Refresh match to get updated pivot data
        $this->match->refresh();
    }
    
    public function updatedFootballType()
    {
        // Reset formation and lineup when football type changes
        $this->formation = '';
        $this->lineup = [];
    }
    
    public function updatedFormation()
    {
        // Reset lineup when formation changes
        $this->lineup = [];
    }
    
    public function addToLineup($playerId, $lineIndex, $positionIndex)
    {
        // Initialize lineup structure if empty
        if (empty($this->lineup)) {
            $this->lineup = [];
        }
        
        // Remove player from any previous position
        foreach ($this->lineup as $line => $positions) {
            foreach ($positions as $pos => $pid) {
                if ($pid == $playerId) {
                    unset($this->lineup[$line][$pos]);
                }
            }
        }
        
        // Add player to new position
        if (!isset($this->lineup[$lineIndex])) {
            $this->lineup[$lineIndex] = [];
        }
        $this->lineup[$lineIndex][$positionIndex] = $playerId;
    }
    
    public function removeFromLineup($playerId)
    {
        foreach ($this->lineup as $line => $positions) {
            foreach ($positions as $pos => $pid) {
                if ($pid == $playerId) {
                    unset($this->lineup[$line][$pos]);
                }
            }
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
            'match_description' => $this->match_description,
            'goals_team' => $this->goals_team ?: null,
            'goals_oponent' => $this->goals_oponent ?: null,
            'escudo_team_oponent' => $escudoPath,
            'sites' => $this->sites ?: null,
            'formation' => $this->formation ?: null,
            'lineup' => $this->lineup ?: null,
            'football_type' => $this->footballType,
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

        // Sync not called players with their reasons
        $notCalledSyncData = [];
        foreach ($this->notCalledPlayerReasons as $playerId => $reason) {
            $notCalledSyncData[$playerId] = [
                'reason' => $reason ?: null,
                'created_user' => auth()->user()->id,
                'updated_user' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        $this->match->notCalledPlayers()->sync($notCalledSyncData);

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

        // Get players for called column with pivot data
        $calledPlayersData = $this->match->players()
            ->whereIn('player_id', $this->calledPlayers)
            ->wherePivot('reason_not_called', null)
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
            
        // Get players for available column (notCalledPlayers)
        $availablePlayersData = Player::whereIn('id', $this->notCalledPlayers)
            ->select('id', 'name', 'surname', 'player_photo', 'position', 'sports_school_id')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();
        
        // Get players for not called with reason column
        $notCalledWithReasonIds = array_keys($this->notCalledPlayerReasons);
        $notCalledPlayersData = Player::whereIn('id', $notCalledWithReasonIds)
            ->select('id', 'name', 'surname', 'player_photo', 'position', 'sports_school_id')
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        return view('livewire.matches.edit', [
            'seasons' => $seasons,
            'teams' => $teams,
            'calledPlayersData' => $calledPlayersData,
            'availablePlayersData' => $availablePlayersData,
            'notCalledPlayersData' => $notCalledPlayersData,
            'allTeams' => $allTeams,
        ]);
    }
}
