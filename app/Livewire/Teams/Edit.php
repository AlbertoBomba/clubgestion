<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Team;
use App\Models\Category;
use App\Models\Season;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;
    
    public Team $team;
    
    public $teamName = '';
    public $description = '';
    public $category_id = '';
    public $season_id = '';
    public $section_id = '';
    public $selectedCoaches = [];
    public $teamImage;
    public $gender = 'mixto';
    public $price = null;
    public $federate = false;
    public $hasChanges = false;
    
    // Gestión de jugadores
    public $searchPlayer = '';
    public $searchCoach = '';
    public $showMovePlayerModal = false;
    public $playerToMove = null;
    public $playerToMoveName = '';
    public $targetTeamId = null;
    public $confirmingPlayerRemoval = false;
    public $playerToRemove = null;
    
    // Agregar jugadores
    public $showAddPlayerModal = false;
    public $searchAvailablePlayer = '';
    public $selectedPlayersToAdd = [];
    public $filterByCategory = true;
    
    // Eliminar equipo
    public $confirmingDeletion = false;
    
    // Valores originales para detectar cambios
    private $originalTeamName;
    private $originalDescription;
    private $originalGender;
    private $originalPrice;
    private $originalFederate;
    private $originalCategoryId;
    private $originalSeasonId;
    private $originalSectionId;
    private $originalSelectedCoaches = [];

    protected function rules()
    {
        return [
            'teamName' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'federate' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'season_id' => 'required|exists:seasons,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    protected $messages = [
        'teamName.required' => 'El nombre del equipo es obligatorio.',
        'category_id.required' => 'La categoría es obligatoria.',
        'season_id.required' => 'La temporada es obligatoria.',
        'section_id.required' => 'La sección es obligatoria.',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->teamName = $team->team;
        $this->description = $team->description;
        $this->category_id = $team->category_id;
        $this->season_id = $team->season_id;
        $this->section_id = $team->section_id;
        $this->gender = $team->gender;
        $this->price = $team->price;
        $this->federate = $team->federate;
        
        // Cargar entrenadores actuales del equipo
        $this->selectedCoaches = $team->coaches->pluck('id')->toArray();
        
        // Guardar valores originales para detectar cambios
        $this->originalTeamName = $this->teamName;
        $this->originalDescription = $this->description ?? '';
        $this->originalGender = $this->gender;
        $this->originalPrice = $this->price;
        $this->originalFederate = $this->federate;
        $this->originalCategoryId = $this->category_id;
        $this->originalSeasonId = $this->season_id;
        $this->originalSectionId = $this->section_id;
        $this->originalSelectedCoaches = $this->selectedCoaches;
    }
    
    public function updated($propertyName)
    {
        // Detectar cambios en cualquier propiedad
        $this->checkForChanges();
    }
    
    public function updatedPrice($value)
    {
        // Handle different decimal separator formats
        if ($value) {
            // Remove spaces
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
        
        $this->checkForChanges();
    }
    
    private function checkForChanges()
    {
        $this->hasChanges = 
            $this->teamName !== $this->originalTeamName ||
            ($this->description ?? '') !== $this->originalDescription ||
            $this->gender !== $this->originalGender ||
            $this->price !== $this->originalPrice ||
            $this->federate !== $this->originalFederate ||
            $this->category_id !== $this->originalCategoryId ||
            $this->season_id !== $this->originalSeasonId ||
            $this->section_id !== $this->originalSectionId ||
            $this->selectedCoaches !== $this->originalSelectedCoaches;
    }

    public function save()
    {
        $this->validate();

        $dataToUpdate = [
            'team' => $this->teamName,
            'description' => $this->description,
            'gender' => $this->gender,
            'price' => $this->price,
            'federate' => $this->federate,
            'category_id' => $this->category_id,
            'season_id' => $this->season_id,
            'section_id' => $this->section_id,
            'updated_user' => auth()->id(),
        ];

        // Manejar la subida de la imagen si hay una nueva
        if ($this->teamImage) {
            // Eliminar la imagen anterior si existe
            if ($this->team->team_image) {
                Storage::disk('public')->delete($this->team->team_image);
            }
            
            // Guardar la nueva imagen
            $path = $this->teamImage->store('team-images', 'public');
            $dataToUpdate['team_image'] = $path;
        }

        $this->team->update($dataToUpdate);

        // Sincronizar entrenadores
        $this->team->coaches()->sync($this->selectedCoaches);

        // Resetear flag de cambios
        $this->hasChanges = false;

        session()->flash('message', 'Equipo actualizado correctamente.');
        session()->flash('highlightTeam', $this->team->id);
        
        return redirect()->route('teams.index');
    }

    public function confirmRemovePlayer($playerId)
    {
        $this->playerToRemove = $playerId;
        $this->confirmingPlayerRemoval = true;
    }

    public function removePlayer()
    {
        if ($this->playerToRemove) {
            // Eliminar la relación (soft delete en la tabla pivote)
            $this->team->players()->updateExistingPivot($this->playerToRemove, [
                'deleted_at' => now(),
                'updated_user' => auth()->id()
            ]);
            
            session()->flash('message', 'Jugador eliminado del equipo correctamente.');
        }
        
        $this->confirmingPlayerRemoval = false;
        $this->playerToRemove = null;
    }

    public function openMovePlayerModal($playerId)
    {
        $this->playerToMove = $playerId;
        $player = \App\Models\Player::find($playerId);
        $this->playerToMoveName = $player ? $player->name . ' ' . $player->surname : '';
        $this->targetTeamId = null;
        $this->showMovePlayerModal = true;
    }

    public function movePlayer()
    {
        if (!$this->playerToMove || !$this->targetTeamId) {
            session()->flash('error', 'Debe seleccionar un equipo de destino.');
            return;
        }

        if ($this->targetTeamId == $this->team->id) {
            session()->flash('error', 'No puede mover el jugador al mismo equipo.');
            return;
        }

        // Eliminar del equipo actual (soft delete)
        $this->team->players()->updateExistingPivot($this->playerToMove, [
            'deleted_at' => now(),
            'updated_user' => auth()->id()
        ]);

        // Agregar al nuevo equipo
        $targetTeam = Team::find($this->targetTeamId);
        $targetTeam->players()->attach($this->playerToMove, [
            'created_user' => auth()->id(),
            'updated_user' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        session()->flash('message', 'Jugador movido al nuevo equipo correctamente.');
        
        $this->showMovePlayerModal = false;
        $this->playerToMove = null;
        $this->playerToMoveName = '';
        $this->targetTeamId = null;
    }

    public function cancelMovePlayer()
    {
        $this->showMovePlayerModal = false;
        $this->playerToMove = null;
        $this->playerToMoveName = '';
        $this->targetTeamId = null;
    }
    
    public function openAddPlayerModal()
    {
        $this->showAddPlayerModal = true;
        $this->searchAvailablePlayer = '';
        $this->selectedPlayersToAdd = [];
    }
    
    public function toggleSelectAllPlayers()
    {
        $availablePlayers = $this->getAvailablePlayersForModal();
        
        if (count($this->selectedPlayersToAdd) === $availablePlayers->count()) {
            // Si todos están seleccionados, deseleccionar todos
            $this->selectedPlayersToAdd = [];
        } else {
            // Si no todos están seleccionados, seleccionar todos
            $this->selectedPlayersToAdd = $availablePlayers->pluck('id')->toArray();
        }
    }
    
    public function addPlayersToTeam()
    {
        if (empty($this->selectedPlayersToAdd)) {
            session()->flash('error', 'Debe seleccionar al menos un jugador.');
            return;
        }
        
        foreach ($this->selectedPlayersToAdd as $playerId) {
            // Verificar si existe un registro eliminado (soft deleted)
            $deletedRecord = \DB::table('teams_players')
                ->where('team_id', $this->team->id)
                ->where('player_id', $playerId)
                ->whereNotNull('deleted_at')
                ->first();
            
            if ($deletedRecord) {
                // Restaurar el registro eliminado
                \DB::table('teams_players')
                    ->where('id', $deletedRecord->id)
                    ->update([
                        'deleted_at' => null,
                        'updated_user' => auth()->id(),
                        'updated_at' => now()
                    ]);
            } else {
                // Verificar si el jugador ya está en el equipo (no eliminado)
                $existsInTeam = $this->team->players()->where('player_id', $playerId)->exists();
                
                if (!$existsInTeam) {
                    $this->team->players()->attach($playerId, [
                        'created_user' => auth()->id(),
                        'updated_user' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
        
        session()->flash('message', 'Jugador(es) agregado(s) al equipo correctamente.');
        
        $this->showAddPlayerModal = false;
        $this->searchAvailablePlayer = '';
        $this->selectedPlayersToAdd = [];
    }
    
    public function cancelAddPlayer()
    {
        $this->showAddPlayerModal = false;
        $this->searchAvailablePlayer = '';
        $this->selectedPlayersToAdd = [];
    }

    public function cancelRemovePlayer()
    {
        $this->confirmingPlayerRemoval = false;
        $this->playerToRemove = null;
    }
    
    public function confirmDelete()
    {
        // Verificar si el equipo tiene pagos generados o jugadores
        $team = Team::withCount(['payments', 'players'])->find($this->team->id);
        
        if ($team && $team->payments_count > 0) {
            session()->flash('error', 'No se puede eliminar este equipo porque tiene pagos generados. Debe eliminar los pagos primero desde la sección de Generar Pagos.');
            return;
        }
        
        if ($team && $team->players_count > 0) {
            session()->flash('error', 'No se puede eliminar este equipo porque tiene jugadores asignados. Debe reasignar o eliminar los jugadores primero.');
            return;
        }
        
        $this->confirmingDeletion = true;
    }
    
    public function deleteTeam()
    {
        // Eliminar imagen del equipo si existe
        if ($this->team->team_image) {
            Storage::disk('public')->delete($this->team->team_image);
        }
        
        // Eliminar el equipo
        $this->team->delete();
        
        session()->flash('message', 'Equipo eliminado correctamente.');
        
        return redirect()->route('teams.index');
    }

    protected function getAvailablePlayersForModal()
    {
        $availablePlayers = collect();
        
        if (!$this->showAddPlayerModal) {
            return $availablePlayers;
        }
        
        // Obtener sports_school_id
        $sportsSchoolId = null;
        if ($this->season_id) {
            $season = Season::find($this->season_id);
            if ($season) {
                $sportsSchoolId = $season->sports_school_id;
            }
        }
        
        if (!$sportsSchoolId || !$this->season_id) {
            return $availablePlayers;
        }
        
        $query = \App\Models\Player::where('active', true)
            ->where('sports_school_id', $sportsSchoolId)
            ->whereDoesntHave('teams')
            ->whereHas('seasons', function($q) {
                $q->where('seasons.id', $this->season_id);
            })
            ->whereHas('sections', function($q) {
                $q->where('sections.id', $this->section_id);
            });
            
        // Aplicar búsqueda si existe
        if ($this->searchAvailablePlayer) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchAvailablePlayer . '%')
                  ->orWhere('surname', 'like', '%' . $this->searchAvailablePlayer . '%')
                  ->orWhere('dni', 'like', '%' . $this->searchAvailablePlayer . '%');
            });
        }
        
        $availablePlayers = $query->orderBy('name')
            ->orderBy('surname')
            ->get();
        
        // Filtrar por categoría si está activado
        if ($this->filterByCategory && $this->category_id) {
            $category = Category::find($this->category_id);
            $season = Season::find($this->season_id);
            
            if ($category && $season && $season->from_year) {
                $availablePlayers = $availablePlayers->filter(function($player) use ($category, $season) {
                    if (!$player->dbirth) {
                        return false;
                    }
                    
                    // Calcular la edad del jugador al inicio de la temporada
                    $birthYear = $player->dbirth->year;
                    $ageAtSeasonStart = $season->from_year - $birthYear;
                    
                    // Verificar si la edad está dentro del rango de la categoría
                    return $ageAtSeasonStart >= $category->from_age && $ageAtSeasonStart <= $category->to_age;
                });
            }
        }
        
        return $availablePlayers;
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();
        $seasons = Season::orderBy('from_year', 'desc')->get();
        
        // Cargar el equipo con contadores de pagos y jugadores para la vista
        $this->team->loadCount(['payments', 'players']);
        
        // Obtener secciones de la temporada seleccionada
        $sections = collect();
        if ($this->season_id) {
            $sections = Section::whereHas('seasons', function($query) {
                $query->where('seasons.id', $this->season_id);
            })->orderBy('name')->get();
        }

        // Obtener la escuela del equipo a través de la temporada
        $sportsSchoolId = null;
        if ($this->season_id) {
            $season = Season::find($this->season_id);
            if ($season) {
                $sportsSchoolId = $season->sports_school_id;
            }
        }
        

        // Obtener entrenadores disponibles de la misma escuela
        $availableCoaches = collect();
        if ($sportsSchoolId) {
            $query = User::where('is_active', true)
                ->where('sports_school_id', $sportsSchoolId)
                ->role('coach');
                
            // Aplicar búsqueda si existe
            if ($this->searchCoach) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->searchCoach . '%')
                      ->orWhere('email', 'like', '%' . $this->searchCoach . '%');
                });
            }
            
            $availableCoaches = $query->orderBy('name')->get();
            
            // Ordenar: primero los seleccionados, luego los demás (mantener valores originales)
            $availableCoaches = $availableCoaches->sortBy([
                fn($coach) => in_array($coach->id, $this->selectedCoaches) ? 0 : 1,
                fn($coach) => strtolower($coach->name)
            ])->values();
        }

        // Obtener jugadores disponibles para agregar (no están en el equipo)
        $availablePlayers = $this->getAvailablePlayersForModal();

       

        return view('livewire.teams.edit', [
            'categories' => $categories,
            'seasons' => $seasons,
            'sections' => $sections,
            'availableCoaches' => $availableCoaches,
            'teamPlayers' => $this->team->players()
                ->when($this->searchPlayer, function($query) {
                    $query->where(function($q) {
                        $q->where('name', 'like', '%' . $this->searchPlayer . '%')
                          ->orWhere('surname', 'like', '%' . $this->searchPlayer . '%')
                          ->orWhere('dni', 'like', '%' . $this->searchPlayer . '%');
                    });
                })
                ->orderBy('name')
                ->orderBy('surname')
                ->get(),
            'availableTeams' => Team::where('season_id', $this->team->season_id)
                ->where('section_id', $this->team->section_id)
                ->where('id', '!=', $this->team->id)
                ->orderBy('team')
                ->get(),
            'availablePlayers' => $availablePlayers,
        ]);
    }
}
