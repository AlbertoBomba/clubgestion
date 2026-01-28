<?php

namespace App\Livewire\TrainingFields;

use App\Models\TrainingField;
use App\Models\SportsSchool;
use App\Models\Section;
use App\Models\Season;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $fieldTypeFilter = '';
    public $activeFilter = '';
    
    // Modal properties
    public $showModal = false;
    public $showDeleteModal = false;
    public $fieldToDelete = null;
    public $fieldId = null;
    public $name = '';
    public $field_type = 'futbol_11';
    public $surface_type = 'cesped_natural';
    public $description = '';
    public $capacity = '';
    public $color = '#10B981';
    public $available_from = '';
    public $available_to = '';
    public $active = true;
    public $selectedSections = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'fieldTypeFilter' => ['except' => ''],
        'activeFilter' => ['except' => ''],
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'field_type' => 'required|in:futbol_11,futbol_7,futsal,polideportivo',
        'surface_type' => 'required|in:cesped_natural,cesped_artificial,tierra,parquet',
        'description' => 'nullable|string',
        'capacity' => 'nullable|integer|min:1',
        'color' => 'required|string|size:7',
        'available_from' => 'nullable|date_format:H:i',
        'available_to' => 'nullable|date_format:H:i|after:available_from',
        'active' => 'boolean',
        'selectedSections' => 'nullable|array',
        'selectedSections.*' => 'exists:sections,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFieldTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingActiveFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal($fieldId)
    {
        $field = TrainingField::findOrFail($fieldId);
        
        $this->fieldId = $field->id;
        $this->name = $field->name;
        $this->field_type = $field->field_type;
        $this->surface_type = $field->surface_type;
        $this->description = $field->description;
        $this->capacity = $field->capacity;
        $this->color = $field->color;
        $this->available_from = $field->available_from ? substr($field->available_from, 0, 5) : '';
        $this->available_to = $field->available_to ? substr($field->available_to, 0, 5) : '';
        $this->active = $field->active;
        $this->selectedSections = $field->sections->pluck('id')->toArray();
        
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();

        if ($this->fieldId) {
            // Actualizar
            $field = TrainingField::findOrFail($this->fieldId);
            $field->update([
                'name' => $this->name,
                'field_type' => $this->field_type,
                'surface_type' => $this->surface_type,
                'description' => $this->description,
                'capacity' => $this->capacity ?: null,
                'color' => $this->color,
                'available_from' => $this->available_from ?: null,
                'available_to' => $this->available_to ?: null,
                'active' => $this->active,
                'updated_user' => $user->id,
            ]);

            // Sincronizar secciones
            $field->sections()->sync($this->selectedSections);

            session()->flash('message', 'Campo actualizado correctamente.');
        } else {
            // Crear
            // Obtener temporada activa
            $activeSeason = Season::where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            $field = TrainingField::create([
                'name' => $this->name,
                'field_type' => $this->field_type,
                'surface_type' => $this->surface_type,
                'description' => $this->description,
                'capacity' => $this->capacity ?: null,
                'color' => $this->color,
                'available_from' => $this->available_from ?: null,
                'available_to' => $this->available_to ?: null,
                'active' => $this->active,
                'sports_school_id' => $user->sports_school_id,
                'season_id' => $activeSeason ? $activeSeason->id : null,
                'created_user' => $user->id,
            ]);

            // Sincronizar secciones
            $field->sections()->sync($this->selectedSections);

            session()->flash('message', 'Campo creado correctamente.');
        }

        $this->closeModal();
    }

    public function confirmDelete($fieldId)
    {
        $this->fieldToDelete = TrainingField::findOrFail($fieldId);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->fieldToDelete) {
            $this->fieldToDelete->delete();
            session()->flash('message', 'Campo eliminado correctamente.');
            $this->closeDeleteModal();
        }
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->fieldToDelete = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->fieldId = null;
        $this->name = '';
        $this->field_type = 'futbol_11';
        $this->surface_type = 'cesped_natural';
        $this->description = '';
        $this->capacity = '';
        $this->color = '#10B981';
        $this->available_from = '';
        $this->available_to = '';
        $this->active = true;
        $this->selectedSections = [];
        $this->resetValidation();
    }

    public function render()
    {
        $user = auth()->user();

        // Obtener temporada activa
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        $fields = TrainingField::where('sports_school_id', $user->sports_school_id)
            ->when($activeSeason, function($query) use ($activeSeason) {
                $query->where('season_id', $activeSeason->id);
            })
            ->with(['sections', 'season'])
            ->withCount('schedules')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->fieldTypeFilter, function ($query) {
                $query->where('field_type', $this->fieldTypeFilter);
            })
            ->when($this->activeFilter !== '', function ($query) {
                $query->where('active', $this->activeFilter);
            })
            ->orderBy('name')
            ->paginate(10);

        // Obtener solo secciones de la temporada activa
        $allSections = collect();
        
        if ($activeSeason) {
            $allSections = Section::where('active', true)
                ->whereHas('seasons', function($query) use ($activeSeason) {
                    $query->where('seasons.id', $activeSeason->id);
                })
                ->orderBy('name')
                ->get();
        }

        return view('livewire.training-fields.index', [
            'fields' => $fields,
            'allSections' => $allSections,
            'activeSeason' => $activeSeason,
        ]);
    }
}
