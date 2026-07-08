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
    public $cuota = 1;
    public $end_date = '';
    public $precio_preinscripcion = '';
    public $sectionPrices = []; // Array: section_id => price

    public function mount()
    {
        // Establecer end_date predeterminada al 30 de junio del próximo año
        $this->end_date = now()->addYear()->month(6)->day(30)->format('Y-m-d');
    }

    public function updatedSectionPrices($value, $key)
    {
        // Convertir comas a puntos para permitir entrada decimal europea
        if (is_string($value)) {
            $this->sectionPrices[$key] = str_replace(',', '.', $value);
        }
    }

    public function updatedPrecioPreinscripcion($value)
    {
        // Convertir comas a puntos para permitir entrada decimal europea
        if (is_string($value)) {
            $this->precio_preinscripcion = str_replace(',', '.', $value);
        }
    }

    protected function rules()
    {
        return [
            'season' => 'required|string|max:255',
            'description' => 'nullable|string',
            'from_year' => 'required|integer|min:1900|max:2100',
            'to_year' => 'required|integer|min:1900|max:2100',
            'cuota' => 'required|integer|min:1|max:12',
            'end_date' => 'nullable|date',
            'inscription_start_at' => 'nullable|date',
            'inscription_end_at' => 'nullable|date',
            'precio_preinscripcion' => 'nullable|numeric|min:0',
        ];
    }

    protected $messages = [
        'season.required' => 'El campo temporada es obligatorio.',
        'from_year.required' => 'El año desde es obligatorio.',
        'to_year.required' => 'El año hasta es obligatorio.',
    ];

    public function save()
    {
        $this->validate();

        // Verificar que no exista una temporada activa
        // $activeSeason = Season::where('sports_school_id', auth()->user()->sports_school_id)
        //     ->where('start_date', '<=', now())
        //     ->where('end_date', '>=', now())
        //     ->first();
        
        // if ($activeSeason) {
        //     $this->addError('season', 'No se puede crear una nueva temporada mientras exista una temporada activa. La temporada "' . $activeSeason->season . '" está actualmente activa.');
        //     return;
        // }

        $season = Season::create([
            'sports_school_id' => auth()->user()->sports_school_id,
            'season' => $this->season,
            'description' => $this->description,
            'from_year' => $this->from_year,
            'to_year' => $this->to_year,
            'cuota' => $this->cuota,
            'start_date' => now()->toDateString(),
            'end_date' => $this->end_date,
            'inscription_start_at' => $this->inscription_start_at,
            'inscription_end_at' => $this->inscription_end_at,
            'precio_preinscripcion' => $this->precio_preinscripcion ? floatval($this->precio_preinscripcion) : null,
            'created_user' => auth()->id(),
        ]);

        // Attach sections with prices
        $syncData = [];
        foreach ($this->sectionPrices as $sectionId => $price) {
            // Agregar si el precio es numérico y >= 0 (permite 0)
            // Usamos is_numeric() primero para validar, luego verificamos que sea >= 0
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
