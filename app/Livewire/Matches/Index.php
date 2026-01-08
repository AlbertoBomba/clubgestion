<?php

namespace App\Livewire\Matches;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SeasonMatch;
use App\Models\Season;
use App\Models\Team;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';
    public $teamFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $sortField = 'date';
    public $sortDirection = 'desc';
    public $confirmingDeletion = false;
    public $matchToDelete = null;

    protected $queryString = ['search', 'seasonFilter', 'teamFilter', 'dateFrom', 'dateTo', 'sortField', 'sortDirection'];

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

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
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
    }

    public function confirmDelete($matchId)
    {
        $this->matchToDelete = $matchId;
        $this->confirmingDeletion = true;
    }

    public function deleteMatch()
    {
        $match = SeasonMatch::find($this->matchToDelete);
        
        if ($match && $match->sports_school_id == auth()->user()->sports_school_id) {
            $match->delete();
            session()->flash('message', 'Partido eliminado correctamente.');
        }

        $this->confirmingDeletion = false;
        $this->matchToDelete = null;
    }

    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->matchToDelete = null;
    }

    public function render()
    {
        $matches = SeasonMatch::where('sports_school_id', auth()->user()->sports_school_id)
            ->with(['season', 'team.category', 'players'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('opponent', 'like', '%' . $this->search . '%')
                      ->orWhere('site', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->seasonFilter, function ($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->when($this->teamFilter, function ($query) {
                $query->where('team_id', $this->teamFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('date', '<=', $this->dateTo);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('from_year', 'desc')
            ->get();

        $teams = Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->when($this->seasonFilter, function ($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->orderBy('team')
            ->get();

        return view('livewire.matches.index', [
            'matches' => $matches,
            'seasons' => $seasons,
            'teams' => $teams,
        ]);
    }
}
