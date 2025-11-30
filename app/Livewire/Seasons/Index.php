<?php

namespace App\Livewire\Seasons;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Season;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $seasonToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($seasonId)
    {
        $this->seasonToDelete = $seasonId;
        $this->confirmingDeletion = true;
    }

    public function deleteSeason()
    {
        $season = Season::find($this->seasonToDelete);
        
        if ($season && $season->sports_school_id === auth()->user()->sports_school_id) {
            $season->delete();
            session()->flash('message', 'Temporada eliminada correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->seasonToDelete = null;
    }

    public function render()
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->withCount(['players', 'sections'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('season', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('from_year', 'like', '%' . $this->search . '%')
                      ->orWhere('to_year', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('from_year', 'desc')
            ->paginate(10);

        return view('livewire.seasons.index', [
            'seasons' => $seasons
        ]);
    }
}
