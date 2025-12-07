<?php

namespace App\Livewire\PaymentsTeams;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentTeam;
use App\Models\Season;
use App\Models\Team;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $seasonFilter = '';
    public $showModal = false;
    public $selectedSeasonId = '';
    public $modalTeams = [];
    public $numPlazos = 1;
    public $plazos = [];

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

    public function openGenerateModal()
    {
        // Get active season
        $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($activeSeason) {
            $this->selectedSeasonId = $activeSeason->id;
            $this->loadTeams();
            $this->numPlazos = 1;
            $this->initializePlazos();
            $this->showModal = true;
            $this->dispatch('modal-opened');
        } else {
            session()->flash('error', 'No hay temporada activa.');
        }
    }

    public function initializePlazos()
    {
        $oldPlazos = $this->plazos;
        $this->plazos = [];
        for ($i = 1; $i <= $this->numPlazos; $i++) {
            $this->plazos[$i] = [
                'date_start' => $oldPlazos[$i]['date_start'] ?? '',
                'date_end' => $oldPlazos[$i]['date_end'] ?? '',
            ];
        }
    }

    public function updatedNumPlazos()
    {
        $this->initializePlazos();
    }

    public function loadTeams()
    {
        if ($this->selectedSeasonId) {
            $this->modalTeams = Team::with(['category', 'section', 'season'])
                ->where('season_id', $this->selectedSeasonId)
                ->whereHas('season', function ($query) {
                    $query->where('sports_school_id', auth()->user()->sports_school_id);
                })
                ->orderBy('team')
                ->get();
        }
    }

    public function updatedSelectedSeasonId()
    {
        $this->loadTeams();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->modalTeams = [];
        $this->selectedSeasonId = '';
        $this->numPlazos = 1;
        $this->plazos = [];
    }

    public function render()
    {
        $userSchoolId = auth()->user()->sports_school_id;
        
        // Get teams with payment info
        $teams = Team::with(['category', 'season', 'section', 'payments'])
            ->whereHas('season', function ($query) use ($userSchoolId) {
                $query->where('sports_school_id', $userSchoolId);
            })
            ->when($this->search, function ($query) {
                $query->where('team', 'like', '%' . $this->search . '%');
            })
            ->when($this->seasonFilter, function ($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->withCount('payments')
            ->orderBy('team')
            ->get();

        $seasons = Season::where('sports_school_id', $userSchoolId)
            ->orderBy('from_year', 'desc')
            ->get();

        return view('livewire.payments-teams.index', [
            'teams' => $teams,
            'seasons' => $seasons,
        ]);
    }
}
