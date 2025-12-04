<?php

namespace App\Livewire\Seasons;

use Livewire\Component;
use App\Models\Season;
use App\Models\Section;

class Edit extends Component
{
    public Season $seasonModel;
    
    public $season = '';
    public $description = '';
    public $from_year = '';
    public $to_year = '';
    public $end_date = '';
    public $sectionPrices = []; // Array: section_id => price
    public $selectedSections = []; // Array de section_ids seleccionadas
    public $isActive = false; // Si la temporada está activa

    protected function rules()
    {
        return [
            'season' => 'required|string|max:255',
            'description' => 'nullable|string',
            'from_year' => 'required|integer|min:1900|max:2100',
            'to_year' => 'required|integer|min:1900|max:2100',
            'end_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'season.required' => 'El campo temporada es obligatorio.',
        'from_year.required' => 'El año desde es obligatorio.',
        'to_year.required' => 'El año hasta es obligatorio.',
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
        $this->end_date = $season->end_date ? $season->end_date->format('Y-m-d') : '';
        
        // Verificar si la temporada está activa (entre start_date y end_date)
        $this->isActive = $season->start_date && $season->end_date &&
                          now()->between($season->start_date, $season->end_date);
        
        // Load existing section prices
        foreach ($season->sections as $section) {
            $this->sectionPrices[$section->id] = $section->pivot->price;
            $this->selectedSections[] = $section->id;
        }
    }

    public function save()
    {
        // Verificar que la temporada esté activa
        if (!$this->isActive) {
            session()->flash('error', 'No se puede modificar una temporada que no está activa.');
            return;
        }
        
        $this->validate();

        $this->seasonModel->update([
            'season' => $this->season,
            'description' => $this->description,
            'from_year' => $this->from_year,
            'to_year' => $this->to_year,
            'end_date' => $this->end_date,
            'updated_user' => auth()->id(),
        ]);

        // Sync sections with prices
        $syncData = [];
        foreach ($this->selectedSections as $sectionId) {
            $price = $this->sectionPrices[$sectionId] ?? 0;
            // Agregar si el precio es numérico y >= 0 (permite 0)
            if (is_numeric($price) && floatval($price) >= 0) {
                $syncData[$sectionId] = [
                    'price' => floatval($price),
                    'created_user' => auth()->id(),
                    'updated_user' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Validar que al menos haya una sección con precio
        if (empty($syncData)) {
            $this->addError('sectionPrices', 'Debe seleccionar al menos una sección con un precio válido.');
            return;
        }

        $this->seasonModel->sections()->sync($syncData);

        session()->flash('message', 'Temporada actualizada correctamente.');
        
        return redirect()->route('seasons.index');
    }

    public function render()
    {
        $sections = Section::where('active', true)->orderBy('name')->get();
        
        return view('livewire.seasons.edit', [
            'sections' => $sections
        ]);
    }
}
