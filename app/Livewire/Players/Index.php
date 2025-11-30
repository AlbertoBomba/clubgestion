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
    public $sortField = 'surname';
    public $sortDirection = 'asc';
    public $confirmingDeletion = false;
    public $playerToDelete = null;

    protected $queryString = ['search', 'seasonFilter', 'sortField', 'sortDirection'];

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
        $this->playerToDelete = $playerId;
        $this->confirmingDeletion = true;
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

    public function render()
    {
        $players = Player::where('sports_school_id', auth()->user()->sports_school_id)
            ->with('seasons')
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

        return view('livewire.players.index', [
            'players' => $players,
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
        ]);
    }
}
