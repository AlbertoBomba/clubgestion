<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team;
use App\Models\Category;
use App\Models\Season;
use App\Models\Section;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $seasonFilter = '';
    public $showModal = false;
    
    // Form fields
    public $team = '';
    public $description = '';
    public $category_id = '';
    public $season_id = '';
    public $section_id = '';
    
    // Delete confirmation
    public $confirmingDeletion = false;
    public $teamToDelete = null;

    protected $queryString = ['search', 'categoryFilter', 'seasonFilter'];

    protected $rules = [
        'team' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'season_id' => 'required|exists:seasons,id',
        'section_id' => 'required|exists:sections,id',
    ];

    public function mount()
    {
        // Set default season filter to active season
        if (empty($this->seasonFilter)) {
            $activeSeason = Season::where('start_date', '<=', now())
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

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingSeasonFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        // Verificar que exista una temporada activa
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$activeSeason) {
            session()->flash('error', 'No se puede crear un equipo sin una temporada activa.');
            return;
        }
        
        $this->resetForm();
        $this->season_id = $activeSeason->id; // Pre-seleccionar temporada activa
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($teamId)
    {
        // Redirigir a la página de edición en lugar de abrir modal
        return redirect()->route('teams.edit', $teamId);
    }

    public function save()
    {
        $this->validate();

        Team::create([
            'team' => $this->team,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'season_id' => $this->season_id,
            'section_id' => $this->section_id,
            'created_user' => auth()->id(),
        ]);
        
        session()->flash('message', 'Equipo creado correctamente.');

        $this->closeModal();
    }

    public function confirmDelete($teamId)
    {
        $this->teamToDelete = $teamId;
        $this->confirmingDeletion = true;
    }

    public function deleteTeam()
    {
        $team = Team::find($this->teamToDelete);
        
        if ($team) {
            $team->delete();
            session()->flash('message', 'Equipo eliminado correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->teamToDelete = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['team', 'description', 'category_id', 'season_id', 'section_id']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $teams = Team::with(['category', 'season'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('team', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('category', function ($query) {
                          $query->where('category', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('season', function ($query) {
                          $query->where('season', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->seasonFilter, function ($query) {
                $query->where('season_id', $this->seasonFilter);
            })
            ->orderBy('team')
            ->paginate(10);

        $categories = Category::orderBy('category')->get();
        $seasons = Season::orderBy('from_year', 'desc')->get();

        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Obtener secciones de la temporada seleccionada en el formulario
        $sections = collect();
        if ($this->season_id) {
            $sections = Section::whereHas('seasons', function($query) {
                $query->where('seasons.id', $this->season_id);
            })->orderBy('name')->get();
        }

        return view('livewire.teams.index', [
            'teams' => $teams,
            'categories' => $categories,
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
            'sections' => $sections,
        ]);
    }
}
