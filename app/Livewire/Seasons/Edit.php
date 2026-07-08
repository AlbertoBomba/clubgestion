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
    public $cuota = 1;
    public $end_date = '';
    public $precio_preinscripcion = '';
    public $sectionPrices = []; // Array: section_id => price
    public $selectedSections = []; // Array de section_ids seleccionadas
    public $isActive = false; // Si la temporada está activa
    public $confirmingDeletion = false;
    public $hasChanges = false; // Indica si hay cambios sin guardar
    public $inscription_start_at = '';
    public $inscription_end_at = '';
    
    // Valores originales para comparar
    private $originalSeason;
    private $originalDescription;
    private $originalFromYear;
    private $originalToYear;
    private $originalCuota;
    private $originalEndDate;
    private $originalPrecioPreinscripcion;
    private $originalSectionPrices = [];
    private $originalInscriptionStartAt;
    private $originalInscriptionEndAt;
    private $originalSelectedSections = [];

    public function updated($propertyName)
    {
        // Detectar cambios en cualquier propiedad
        $this->checkForChanges();
    }

    private function checkForChanges()
    {
        $seasonChanged = $this->season !== $this->originalSeason;
        $descriptionChanged = $this->description !== $this->originalDescription;
        $fromYearChanged = (string)$this->from_year !== (string)$this->originalFromYear;
        $toYearChanged = (string)$this->to_year !== (string)$this->originalToYear;
        $cuotaChanged = (string)$this->cuota !== (string)$this->originalCuota;
        $endDateChanged = $this->end_date !== $this->originalEndDate;
        $precioPreinscripcionChanged = $this->precio_preinscripcion !== $this->originalPrecioPreinscripcion;
        $inscriptionStartAtChanged = $this->inscription_start_at !== $this->originalInscriptionStartAt;
        $inscriptionEndAtChanged = $this->inscription_end_at !== $this->originalInscriptionEndAt;
        $pricesChanged = $this->sectionPrices !== $this->originalSectionPrices;
        $sectionsChanged = count(array_diff($this->selectedSections, $this->originalSelectedSections)) > 0 ||
                          count(array_diff($this->originalSelectedSections, $this->selectedSections)) > 0;
        
        $this->hasChanges = $seasonChanged || $descriptionChanged || $fromYearChanged || 
                           $toYearChanged || $cuotaChanged || $endDateChanged || $precioPreinscripcionChanged || $pricesChanged || $sectionsChanged;
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
        $this->cuota = $season->cuota ?? 1;
        $this->end_date = $season->end_date ? $season->end_date->format('Y-m-d') : '';
        $this->precio_preinscripcion = $season->precio_preinscripcion;
        $this->inscription_start_at = $season->inscription_start_at ? $season->inscription_start_at->format('Y-m-d') : '';
        $this->inscription_end_at = $season->inscription_end_at ? $season->inscription_end_at->format('Y-m-d') : '';
        
        // Guardar valores originales para detectar cambios
        $this->originalSeason = $this->season;
        $this->originalDescription = $this->description ?? '';
        $this->originalFromYear = $this->from_year;
        $this->originalToYear = $this->to_year;
        $this->originalCuota = $this->cuota;
        $this->originalEndDate = $this->end_date ?? '';
        $this->originalPrecioPreinscripcion = $this->precio_preinscripcion ?? '';
        $this->originalInscriptionStartAt = $this->inscription_start_at ?? '';
        $this->originalInscriptionEndAt = $this->inscription_end_at ?? '';
        
        // Verificar si la temporada está activa (entre start_date y end_date)
        $this->isActive = $season->start_date && $season->end_date &&
                          now()->between($season->start_date, $season->end_date);
        
        // Load existing section prices
        foreach ($season->sections as $section) {
            $this->sectionPrices[$section->id] = $section->pivot->price;
            $this->selectedSections[] = $section->id;
        }
        
        // Guardar valores originales de secciones
        $this->originalSectionPrices = $this->sectionPrices;
        $this->originalSelectedSections = $this->selectedSections;
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
            'cuota' => $this->cuota,
            'end_date' => $this->end_date,
            'inscription_start_at' => $this->inscription_start_at,
            'inscription_end_at' => $this->inscription_end_at,
            'precio_preinscripcion' => $this->precio_preinscripcion ? floatval($this->precio_preinscripcion) : null,
            'updated_user' => auth()->id(),
        ]);

        // Sincronizar secciones con precios
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

        // Actualizar valores originales después de guardar
        $this->originalSeason = $this->season;
        $this->originalDescription = $this->description;
        $this->originalFromYear = $this->from_year;
        $this->originalToYear = $this->to_year;
        $this->originalCuota = $this->cuota;
        $this->originalEndDate = $this->end_date;
        $this->originalInscriptionStartAt = $this->inscription_start_at;
        $this->originalInscriptionEndAt = $this->inscription_end_at;
        $this->originalPrecioPreinscripcion = $this->precio_preinscripcion;
        $this->originalSectionPrices = $this->sectionPrices;
        $this->originalSelectedSections = $this->selectedSections;
        $this->hasChanges = false;

        session()->flash('message', 'Temporada actualizada correctamente.');
        
        return redirect()->route('seasons.index');
    }

    public function confirmDelete()
    {
        $this->confirmingDeletion = true;
    }

    public function deleteSeason()
    {
        // Verificar que no tenga datos asociados
        $this->seasonModel->loadCount(['players', 'teams', 'sections']);
        
        if ($this->seasonModel->players_count > 0 || $this->seasonModel->teams_count > 0 || $this->seasonModel->sections_count > 0) {
            session()->flash('error', 'No se puede eliminar una temporada con datos asociados.');
            $this->confirmingDeletion = false;
            return;
        }
        
        if ($this->seasonModel->sports_school_id === auth()->user()->sports_school_id) {
            $this->seasonModel->delete();
            session()->flash('message', 'Temporada eliminada correctamente.');
            return redirect()->route('seasons.index');
        }
        
        $this->confirmingDeletion = false;
    }

    public function render()
    {
        $sections = Section::where('active', true)->orderBy('name')->get();
        
        return view('livewire.seasons.edit', [
            'sections' => $sections
        ]);
    }
}
