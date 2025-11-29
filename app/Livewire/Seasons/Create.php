<?php

namespace App\Livewire\Seasons;

use Livewire\Component;
use App\Models\Season;
use App\Models\Section;

class Create extends Component
{
    public $season = '';
    public $description = '';
    public $from_year = '';
    public $to_year = '';
    public $sectionPrices = []; // Array: section_id => price

    protected function rules()
    {
        return [
            'season' => 'required|string|max:255',
            'description' => 'nullable|string',
            'from_year' => 'required|integer|min:1900|max:2100',
            'to_year' => 'required|integer|min:1900|max:2100',
            'sectionPrices' => 'required|array|min:1',
            'sectionPrices.*' => 'required|numeric|min:0',
        ];
    }

    protected $messages = [
        'sectionPrices.required' => 'Debe seleccionar al menos una sección.',
        'sectionPrices.min' => 'Debe seleccionar al menos una sección.',
        'sectionPrices.*.required' => 'El precio es obligatorio.',
        'sectionPrices.*.numeric' => 'El precio debe ser un número.',
        'sectionPrices.*.min' => 'El precio no puede ser negativo.',
    ];

    public function save()
    {
        $this->validate();

        $season = Season::create([
            'sports_school_id' => auth()->user()->sports_school_id,
            'season' => $this->season,
            'description' => $this->description,
            'from_year' => $this->from_year,
            'to_year' => $this->to_year,
            'created_user' => auth()->id(),
        ]);

        // Attach sections with prices
        $syncData = [];
        foreach ($this->sectionPrices as $sectionId => $price) {
            if (!empty($price) && $price >= 0) {
                $syncData[$sectionId] = [
                    'price' => $price,
                    'created_user' => auth()->id(),
                    'updated_user' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $season->sections()->sync($syncData);

        session()->flash('message', 'Temporada creada correctamente.');
        
        return redirect()->route('seasons.index');
    }

    public function render()
    {
        $sections = Section::where('active', true)->orderBy('name')->get();
        
        return view('livewire.seasons.create', [
            'sections' => $sections
        ]);
    }
}
