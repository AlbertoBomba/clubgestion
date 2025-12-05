<?php

namespace App\Livewire\Players;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Player;
use App\Models\Season;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';
    public $teamFilter = '';
    public $withoutTeam = false;
    public $sortField = 'surname';
    public $sortDirection = 'asc';
    public $confirmingDeletion = false;
    public $playerToDelete = null;
    public $selectedPlayers = [];
    public $confirmingDeactivation = false;
    public $confirmingTeamChange = false;
    public $newTeamId = '';

    protected $queryString = ['search', 'seasonFilter', 'teamFilter', 'withoutTeam', 'sortField', 'sortDirection'];

    public function mount()
    {
        // Set default season filter to active season
        if (empty($this->seasonFilter)) {
            $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($activeSeason) {
                $this->seasonFilter = $activeSeason->id;
            }
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSeasonFilter()
    {
        $this->resetPage();
    }

    public function updatingTeamFilter()
    {
        $this->resetPage();
    }

    public function updatingWithoutTeam()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function confirmDelete($playerId)
    {
        $player = Player::find($playerId);
        if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
            $this->playerToDelete = $playerId;
            $this->confirmingDeletion = true;
        }
    }

    public function deletePlayer()
    {
        $player = Player::find($this->playerToDelete);
        
        if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
            // Eliminar foto si existe
            if ($player->player_photo && \Storage::disk('public')->exists($player->player_photo)) {
                \Storage::disk('public')->delete($player->player_photo);
            }
            
            $player->delete();
            session()->flash('message', 'Jugador eliminado correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->playerToDelete = null;
    }

    public function confirmDeactivation()
    {
        if (count($this->selectedPlayers) > 0) {
            $this->confirmingDeactivation = true;
        }
    }

    public function deactivatePlayers()
    {
        $deactivated = 0;
        
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::find($playerId);
            
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
                $player->update(['active' => false]);
                $deactivated++;
            }
        }
        
        session()->flash('message', "Se desactivaron {$deactivated} jugador(es) correctamente.");
        
        $this->confirmingDeactivation = false;
        $this->selectedPlayers = [];
    }

    public function activatePlayers()
    {
        $activated = 0;
        
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::find($playerId);
            
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
                $player->update(['active' => true]);
                $activated++;
            }
        }
        
        session()->flash('message', "Se activaron {$activated} jugador(es) correctamente.");
        
        $this->confirmingDeactivation = false;
        $this->selectedPlayers = [];
    }

    public function confirmTeamChange()
    {
        if (count($this->selectedPlayers) > 0) {
            $this->newTeamId = '';
            $this->confirmingTeamChange = true;
        }
    }

    public function changeTeam()
    {
        $this->validate([
            'newTeamId' => 'required|exists:teams,id',
        ], [
            'newTeamId.required' => 'Debes seleccionar un equipo.',
            'newTeamId.exists' => 'El equipo seleccionado no es válido.',
        ]);

        $changed = 0;
        
        foreach ($this->selectedPlayers as $playerId) {
            $player = Player::find($playerId);
            
            if ($player && $player->sports_school_id === auth()->user()->sports_school_id) {
                // Sync the player with the new team (replace existing teams)
                $player->teams()->sync([$this->newTeamId]);
                $changed++;
            }
        }
        
        session()->flash('message', "Se cambiaron {$changed} jugador(es) de equipo correctamente.");
        
        $this->confirmingTeamChange = false;
        $this->selectedPlayers = [];
        $this->newTeamId = '';
    }

    public function render()
    {
        $players = Player::where('sports_school_id', auth()->user()->sports_school_id)
            ->with(['seasons', 'teams'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('surname', 'like', '%' . $this->search . '%')
                      ->orWhere('dni', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('dorsal', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->seasonFilter, function ($query) {
                $query->whereHas('seasons', function ($q) {
                    $q->where('seasons.id', $this->seasonFilter);
                });
            })
            ->when($this->teamFilter, function ($query) {
                $query->whereHas('teams', function ($q) {
                    $q->where('teams.id', $this->teamFilter);
                });
            })
            ->when($this->withoutTeam, function ($query) {
                $query->doesntHave('teams');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('season')
            ->get();

        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        // Obtener equipos de la temporada activa
        $teams = \App\Models\Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->when($activeSeason, function ($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->orderBy('team')
            ->get();

        return view('livewire.players.index', [
            'players' => $players,
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
            'teams' => $teams,
            'playerToDeleteModel' => $this->playerToDelete ? Player::find($this->playerToDelete) : null,
            'selectedPlayersModels' => Player::whereIn('id', $this->selectedPlayers)->get(),
        ]);
    }
}
