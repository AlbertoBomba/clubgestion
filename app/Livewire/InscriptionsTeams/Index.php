<?php

namespace App\Livewire\InscriptionsTeams;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InscriptionTeam;
use App\Models\Season;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';

    protected $queryString = ['search', 'seasonFilter'];

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

    public function render()
    {
        $userSchoolId = auth()->user()->sports_school_id;
        
        $inscriptions = InscriptionTeam::with(['season', 'sportsSchool'])
            ->where('sports_school_id', $userSchoolId)
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->seasonFilter, function ($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->orderBy('date_start', 'desc')
            ->paginate(10);

        $seasons = Season::where('sports_school_id', $userSchoolId)
            ->orderBy('from_year', 'desc')
            ->get();

        return view('livewire.inscriptions-teams.index', [
            'inscriptions' => $inscriptions,
            'seasons' => $seasons,
        ]);
    }
}
