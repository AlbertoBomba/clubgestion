<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Team;
use App\Models\Category;
use App\Models\Season;
use App\Models\Section;
use App\Models\User;
use App\Classes\ExcelFile;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $categoryFilter = '';
    public $seasonFilter = '';
    public $showModal = false;
    public $highlightTeam = null;
    
    // Form fields
    public $team = '';
    public $description = '';
    public $category_id = '';
    public $season_id = '';
    public $section_id = '';
    public $selectedCoaches = [];
    public $teamImage;
    public $gender = 'mixto';
    public $price = null;
    public $federate = false;
    
    // Confirmation step
    public $showConfirmation = false;
    public $confirmationData = [];
    
    // Delete confirmation
    public $confirmingDeletion = false;
    public $teamToDelete = null;

    protected $queryString = ['search', 'categoryFilter', 'seasonFilter'];

    protected $rules = [
        'team' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'gender' => 'required|in:masculino,femenino,mixto',
        'price' => 'nullable|numeric|min:0',
        'federate' => 'boolean',
        'category_id' => 'required|exists:categories,id',
        'season_id' => 'required|exists:seasons,id',
        'section_id' => 'required|exists:sections,id',
    ];

    public function mount()
    {
        // Verificar si hay un equipo para resaltar desde la sesión
        if (session()->has('highlightTeam')) {
            $this->highlightTeam = session('highlightTeam');
        }
        
        // Restore filters from session if available
        if (session()->has('teams_filters')) {
            $filters = session('teams_filters');
            $this->search = $filters['search'] ?? '';
            $this->categoryFilter = $filters['categoryFilter'] ?? '';
            $this->seasonFilter = $filters['seasonFilter'] ?? '';
            
            // Clear the session after restoring
            session()->forget('teams_filters');
        } else {
            // Set default season filter to active season only if no saved filters
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

    public function updatedSectionId($value)
    {
        // Auto-fill price from season_section pivot table
        if ($value && $this->season_id) {
            $sectionPrice = \DB::table('season_section')
                ->where('season_id', $this->season_id)
                ->where('section_id', $value)
                ->value('price');
            
            if ($sectionPrice !== null) {
                $this->price = $sectionPrice;
            }
        }
    }

    public function updatedPrice($value)
    {
        // Manejar diferentes formatos de separador decimal
        if ($value) {
            // Eliminar espacios
            $cleanValue = str_replace(' ', '', $value);
            
            // Detect format: if there's both dot and comma, determine which is decimal separator
            if (strpos($cleanValue, '.') !== false && strpos($cleanValue, ',') !== false) {
                // If comma comes after dot, comma is decimal separator (1.502,65)
                if (strrpos($cleanValue, ',') > strrpos($cleanValue, '.')) {
                    $cleanValue = str_replace('.', '', $cleanValue); // Remove thousands separator
                    $cleanValue = str_replace(',', '.', $cleanValue); // Convert comma to dot
                } else {
                    // If dot comes after comma, dot is decimal separator (1,502.65)
                    $cleanValue = str_replace(',', '', $cleanValue); // Remove thousands separator
                }
            } elseif (strpos($cleanValue, ',') !== false) {
                // Only comma present
                $parts = explode(',', $cleanValue);
                // If exactly 3 digits after comma, it's a thousands separator (1,500 = 1500)
                if (count($parts) == 2 && strlen($parts[1]) == 3 && ctype_digit($parts[1])) {
                    $cleanValue = str_replace(',', '', $cleanValue);
                } else {
                    // Otherwise it's a decimal separator (156,9)
                    $cleanValue = str_replace(',', '.', $cleanValue);
                }
            } elseif (strpos($cleanValue, '.') !== false) {
                // Only dot present
                $parts = explode('.', $cleanValue);
                // If exactly 3 digits after dot, it's a thousands separator (1.500 = 1500)
                if (count($parts) == 2 && strlen($parts[1]) == 3 && ctype_digit($parts[1])) {
                    $cleanValue = str_replace('.', '', $cleanValue);
                }
                // Otherwise it's already in correct format (156.9)
            }
            
            // Clean any remaining non-numeric characters except dot
            $cleanValue = preg_replace('/[^0-9.]/', '', $cleanValue);
            
            // Ensure only one decimal point remains
            $parts = explode('.', $cleanValue);
            if (count($parts) > 2) {
                $cleanValue = $parts[0] . '.' . implode('', array_slice($parts, 1));
            }
            
            $this->price = $cleanValue;
        }
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
        // Save current filters to session
        session()->put('teams_filters', [
            'search' => $this->search,
            'categoryFilter' => $this->categoryFilter,
            'seasonFilter' => $this->seasonFilter,
        ]);
        
        // Redirigir a la página de edición en lugar de abrir modal
        return redirect()->route('teams.edit', $teamId);
    }

    public function save()
    {
        $this->validate();

        // Prepare confirmation data
        $category = Category::find($this->category_id);
        $season = Season::find($this->season_id);
        $section = Section::find($this->section_id);

        $this->confirmationData = [
            'team' => $this->team,
            'description' => $this->description,
            'gender' => $this->gender,
            'price' => $this->price,
            'federate' => $this->federate,
            'category' => $category ? $category->category : '',
            'season' => $season ? $season->season : '',
            'section' => $section ? $section->name : '',
        ];

        // Show confirmation screen
        $this->showConfirmation = true;
    }

    public function confirmCreate()
    {
        // Ensure price is properly formatted for database storage
        $formattedPrice = null;
        if ($this->price !== null && $this->price !== '') {
            // Convert to float to ensure correct decimal format
            $formattedPrice = floatval($this->price);
        }
        
        $dataToCreate = [
            'team' => $this->team,
            'description' => $this->description,
            'gender' => $this->gender,
            'price' => $formattedPrice,
            'federate' => $this->federate,
            'category_id' => $this->category_id,
            'season_id' => $this->season_id,
            'section_id' => $this->section_id,
            'created_user' => auth()->id(),
        ];

        // Manejar la subida de la imagen si hay una
        if ($this->teamImage) {
            $path = $this->teamImage->store('team-images', 'public');
            $dataToCreate['team_image'] = $path;
        }

        $team = Team::create($dataToCreate);
        
        session()->flash('message', 'Equipo creado correctamente.');

        $this->closeModal();
    }

    public function backToForm()
    {
        $this->showConfirmation = false;
    }

    public function confirmDelete($teamId)
    {
        // Verificar si el equipo tiene pagos generados o jugadores
        $team = Team::withCount(['payments', 'players'])->find($teamId);
        
        if ($team && $team->payments_count > 0) {
            session()->flash('error', 'No se puede eliminar este equipo porque tiene pagos generados. Debe eliminar los pagos primero desde la sección de Generar Pagos.');
            return;
        }
        
        if ($team && $team->players_count > 0) {
            session()->flash('error', 'No se puede eliminar este equipo porque tiene jugadores asignados. Debe reasignar o eliminar los jugadores primero.');
            return;
        }
        
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
        $this->showConfirmation = false;
        $this->confirmationData = [];
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['team', 'description', 'category_id', 'season_id', 'section_id', 'selectedCoaches', 'teamImage', 'gender', 'price', 'federate']);
        $this->resetErrorBag();
    }

    public function exportExcel()
    {
        $userSchoolId = auth()->user()->sports_school_id;
        
        // Construir query con los mismos filtros de la vista
        $query = Team::with(['category', 'season', 'section', 'coaches', 'players'])
            ->whereHas('season', function ($query) use ($userSchoolId) {
                $query->where('sports_school_id', $userSchoolId);
            })
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
            ->get();

        $excel = new ExcelFile(
            Team::class,
            [],
            [
                'team' => [
                    'title' => 'Equipo',
                    'value' => '$record->team',
                    'type' => 'eval'
                ],
                'category' => [
                    'title' => 'Categoría',
                    'value' => '$record->category ? $record->category->category : "-"',
                    'type' => 'eval'
                ],
                'gender' => [
                    'title' => 'Género',
                    'value' => 'ucfirst($record->gender)',
                    'type' => 'eval'
                ],
                'season' => [
                    'title' => 'Temporada',
                    'value' => '$record->season ? $record->season->season : "-"',
                    'type' => 'eval'
                ],
                'section' => [
                    'title' => 'Sección',
                    'value' => '$record->section ? $record->section->name : "-"',
                    'type' => 'eval'
                ],
                'players_count' => [
                    'title' => 'N° Jugadores',
                    'value' => '$record->players->count()',
                    'type' => 'eval'
                ],
                'price' => [
                    'title' => 'Precio Matrícula (€)',
                    'value' => '$record->price ? number_format($record->price, 2, ",", ".") : "0,00"',
                    'type' => 'eval'
                ],
                'federate' => [
                    'title' => 'Federado',
                    'value' => '$record->federate ? "Sí" : "No"',
                    'type' => 'eval'
                ],
                'coaches' => [
                    'title' => 'Entrenadores',
                    'value' => '$record->coaches->pluck("name")->implode(", ") ?: "Sin asignar"',
                    'type' => 'eval'
                ],
            ],
            'Listado equipos',
            [],
            [],
            $query
        );
        
        return response()->streamDownload(
            fn () => print($excel->generate()),
            'Listado_equipos.xlsx'
        );
    }

    public function render()
    {
        $userSchoolId = auth()->user()->sports_school_id;
        
        $teams = Team::with(['category', 'season', 'section', 'coaches'])
            ->withCount(['players' => function ($query) {
                $query->whereNull('teams_players.deleted_at');
            }])
            ->withCount('payments')
            ->whereHas('season', function ($query) use ($userSchoolId) {
                $query->where('sports_school_id', $userSchoolId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('team', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->description . '%')
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
            ->paginate(50);

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

        // Obtener entrenadores disponibles filtrados por escuela deportiva de la temporada
        $availableCoaches = collect();
        if ($this->season_id) {
            $season = Season::find($this->season_id);
            if ($season && $season->sports_school_id) {
                $availableCoaches = User::where('is_active', true)
                    ->where('sports_school_id', $season->sports_school_id)
                    ->role('coach')
                    ->orderBy('name')
                    ->get();
            }
        }

        return view('livewire.teams.index', [
            'teams' => $teams,
            'categories' => $categories,
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
            'sections' => $sections,
            'availableCoaches' => $availableCoaches,
        ]);
    }
}
