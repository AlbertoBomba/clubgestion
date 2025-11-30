<?php

namespace App\Livewire\Teams;

use Livewire\Component;
use App\Models\Team;
use App\Models\Category;
use App\Models\Season;
use App\Models\Section;

class Edit extends Component
{
    public Team $team;
    
    public $teamName = '';
    public $description = '';
    public $category_id = '';
    public $season_id = '';
    public $section_id = '';

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
    }

    public function save()
    {
        $this->validate();

        $this->team->update([
            'team' => $this->teamName,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'season_id' => $this->season_id,
            'section_id' => $this->section_id,
            'updated_user' => auth()->id(),
        ]);

        session()->flash('message', 'Equipo actualizado correctamente.');
        
        return redirect()->route('teams.index');
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

        return view('livewire.teams.edit', [
            'categories' => $categories,
            'seasons' => $seasons,
            'sections' => $sections,
        ]);
    }
}
