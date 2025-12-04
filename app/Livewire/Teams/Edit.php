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
    
    // Gestión de jugadores
    public $showMovePlayerModal = false;
    public $playerToMove = null;
    public $playerToMoveName = '';
    public $targetTeamId = null;
    public $confirmingPlayerRemoval = false;
    public $playerToRemove = null;

    protected function rules()
    {
        return [
            'teamName' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
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
        
        // Cargar entrenadores actuales del equipo
        $this->selectedCoaches = $team->coaches->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        $dataToUpdate = [
            'team' => $this->teamName,
            'description' => $this->description,
            'gender' => $this->gender,
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

        session()->flash('message', 'Equipo actualizado correctamente.');
        
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

    public function cancelRemovePlayer()
    {
        $this->confirmingPlayerRemoval = false;
        $this->playerToRemove = null;
    }

    public function render()
    {
        $categories = Category::orderBy('category')->get();
        $seasons = Season::orderBy('from_year', 'desc')->get();
        
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
            $availableCoaches = User::where('is_active', true)
                ->where('sports_school_id', $sportsSchoolId)
                ->role('coach')
                ->orderBy('name')
                ->get();
            
            // Ordenar: primero los seleccionados, luego los demás
            $availableCoaches = $availableCoaches->sortBy(function($coach) {
                return in_array($coach->id, $this->selectedCoaches) ? 0 : 1;
            })->values();
        }

       

        return view('livewire.teams.edit', [
            'categories' => $categories,
            'seasons' => $seasons,
            'sections' => $sections,
            'availableCoaches' => $availableCoaches,
            'teamPlayers' => $this->team->players()->orderBy('name')->orderBy('surname')->get(),
            'availableTeams' => Team::where('season_id', $this->team->season_id)
                ->where('section_id', $this->team->section_id)
                ->where('id', '!=', $this->team->id)
                ->orderBy('team')
                ->get(),
        ]);
    }
}
