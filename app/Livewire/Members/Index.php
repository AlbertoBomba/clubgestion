<?php

namespace App\Livewire\Members;

use App\Models\Member;
use App\Models\Season;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $seasonFilter = '';
    public string $statusFilter = '';
    public bool $confirmingDeletion = false;
    public ?int $memberToDelete = null;

    protected $queryString = ['search', 'seasonFilter', 'statusFilter'];

    public function mount(): void
    {
        if (empty($this->seasonFilter)) {
            $active = Season::where('sports_school_id', auth()->user()->sports_school_id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->orderByDesc('created_at')
                ->first();
            if ($active) {
                $this->seasonFilter = $active->id;
            }
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSeasonFilter(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->memberToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function deleteMember(): void
    {
        $member = Member::find($this->memberToDelete);

        if ($member && $member->sports_school_id === auth()->user()->sports_school_id) {
            $member->delete();
            session()->flash('message', 'Socio eliminado correctamente.');
        }

        $this->confirmingDeletion = false;
        $this->memberToDelete = null;
    }

    public function render(): \Illuminate\View\View
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('from_year')
            ->get();

        $query = Member::withCount('memberSeasons')
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('surname', 'like', '%' . $this->search . '%')
                          ->orWhere('member_number', 'like', '%' . $this->search . '%')
                          ->orWhere('dni', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->seasonFilter, function ($q) {
                $q->whereHas('memberSeasons', fn($ms) => $ms->where('season_id', $this->seasonFilter));
            })
            ->when($this->statusFilter === 'active', fn($q) => $q->where('active', true))
            ->when($this->statusFilter === 'inactive', fn($q) => $q->where('active', false))
            ->orderBy('surname')
            ->orderBy('name')
            ->paginate(20);

        return view('livewire.members.index', [
            'members' => $query,
            'seasons' => $seasons,
        ]);
    }
}
