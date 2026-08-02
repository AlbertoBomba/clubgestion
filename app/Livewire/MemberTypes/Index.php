<?php

namespace App\Livewire\MemberTypes;

use App\Models\MemberType;
use App\Models\Season;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $seasonFilter = '';
    public bool $confirmingDeletion = false;
    public ?int $typeToDelete = null;

    protected $queryString = ['search', 'seasonFilter'];

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
        $this->typeToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function deleteMemberType(): void
    {
        $type = MemberType::find($this->typeToDelete);

        if ($type && $type->sports_school_id === auth()->user()->sports_school_id) {
            if ($type->memberSeasons()->count() > 0) {
                session()->flash('error', 'No se puede eliminar un tipo de socio con inscripciones asociadas.');
            } else {
                $type->delete();
                session()->flash('message', 'Tipo de socio eliminado correctamente.');
            }
        }

        $this->confirmingDeletion = false;
        $this->typeToDelete = null;
    }

    public function render(): \Illuminate\View\View
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('from_year')
            ->get();

        $types = MemberType::withCount('memberSeasons')
            ->when($this->seasonFilter, fn($q) => $q->where('season_id', $this->seasonFilter))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.member-types.index', compact('types', 'seasons'));
    }
}
