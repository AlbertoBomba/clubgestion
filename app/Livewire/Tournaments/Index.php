<?php

namespace App\Livewire\Tournaments;

use App\Models\Season;
use App\Models\Tournament;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $statusFilter = '';
    public string $seasonFilter = '';
    public string $sortField    = 'created_at';
    public string $sortDirection = 'desc';

    public bool $confirmingDeletion = false;
    public ?int $tournamentToDelete  = null;

    protected $queryString = ['search', 'statusFilter', 'seasonFilter', 'sortField', 'sortDirection'];

    public function mount(): void
    {
        if (empty($this->seasonFilter)) {
            $active = Season::where('sports_school_id', auth()->user()->sports_school_id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();
            if ($active) {
                $this->seasonFilter = (string) $active->id;
            }
        }
    }

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }
    public function updatingSeasonFilter(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->tournamentToDelete  = $id;
        $this->confirmingDeletion  = true;
    }

    public function deleteTournament(): void
    {
        $tournament = Tournament::where('sports_school_id', auth()->user()->sports_school_id)
            ->findOrFail($this->tournamentToDelete);

        $tournament->delete();

        session()->flash('message', 'Torneo eliminado correctamente.');
        $this->confirmingDeletion = false;
        $this->tournamentToDelete = null;
    }

    public function render()
    {
        $user = auth()->user();

        $tournaments = Tournament::query()
            ->where('sports_school_id', $user->sports_school_id)
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('location', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->seasonFilter, fn ($q) => $q->where('season_id', $this->seasonFilter))
            ->withCount('tournamentTeams')
            ->withCount('phases')
            ->withCount('matches')
            ->withCount(['matches as completed_matches_count' => fn ($q) => $q->where('status', 'completed')])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        $seasons = Season::where('sports_school_id', $user->sports_school_id)
            ->orderByDesc('start_date')
            ->get();

        $activeSeason = Season::where('sports_school_id', $user->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        return view('livewire.tournaments.index', compact('tournaments', 'seasons', 'activeSeason'));
    }
}
