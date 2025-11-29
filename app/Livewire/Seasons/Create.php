<?php

namespace App\Livewire\Seasons;

use Livewire\Component;
use App\Models\Season;

class Create extends Component
{
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

    public function save()
    {
        $this->validate();

        Season::create([
            'sports_school_id' => auth()->user()->sports_school_id,
            'season' => $this->season,
            'description' => $this->description,
            'from_year' => $this->from_year,
            'to_year' => $this->to_year,
            'created_user' => auth()->id(),
        ]);

        session()->flash('message', 'Temporada creada correctamente.');
        
        return redirect()->route('seasons.index');
    }

    public function render()
    {
        return view('livewire.seasons.create');
    }
}
