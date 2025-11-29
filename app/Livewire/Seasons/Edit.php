<?php

namespace App\Livewire\Seasons;

use Livewire\Component;
use App\Models\Season;

class Edit extends Component
{
    public Season $seasonModel;
    
    public $season = '';
    public $description = '';
    public $from_year = '';
    public $to_year = '';

    protected $rules = [
        'season' => 'required|string|max:255',
        'description' => 'nullable|string',
        'from_year' => 'required|integer|min:1900|max:2100',
        'to_year' => 'required|integer|min:1900|max:2100',
    ];

    public function mount(Season $season)
    {
        // Verificar que la temporada pertenece a la escuela del usuario
        if ($season->sports_school_id !== auth()->user()->sports_school_id) {
            abort(403, 'No tienes permisos para editar esta temporada.');
        }

        $this->seasonModel = $season;
        $this->season = $season->season;
        $this->description = $season->description;
        $this->from_year = $season->from_year;
        $this->to_year = $season->to_year;
    }

    public function save()
    {
        $this->validate();

        $this->seasonModel->update([
            'season' => $this->season,
            'description' => $this->description,
            'from_year' => $this->from_year,
            'to_year' => $this->to_year,
            'updated_user' => auth()->id(),
        ]);

        session()->flash('message', 'Temporada actualizada correctamente.');
        
        return redirect()->route('seasons.index');
    }

    public function render()
    {
        return view('livewire.seasons.edit');
    }
}
