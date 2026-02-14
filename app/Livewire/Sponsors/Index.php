<?php

namespace App\Livewire\Sponsors;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Sponsor;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $confirmingDeletion = false;
    public $sponsorToDelete = null;

    // Propiedades para el modal de creación/edición
    public $showModal = false;
    public $editMode = false;
    public $sponsorId;
    public $name;
    public $logo;
    public $existingLogo;
    public $web;
    public $published = false;

    protected $queryString = ['search'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|max:2048',
        'web' => 'nullable|url|max:255',
        'published' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'El nombre del patrocinador es obligatorio.',
        'logo.image' => 'El archivo debe ser una imagen.',
        'logo.max' => 'La imagen no puede superar los 2MB.',
        'web.url' => 'La URL debe ser válida.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($sponsorId)
    {
        $this->resetForm();
        $sponsor = Sponsor::findOrFail($sponsorId);
        
        if ($sponsor->sports_school_id !== auth()->user()->sports_school_id) {
            session()->flash('error', 'No tienes permiso para editar este patrocinador.');
            return;
        }

        // Verificar que el patrocinador pertenece a la temporada en curso
        $currentSeason = Season::forSchool(auth()->user()->sports_school_id)->current()->first();
        if (!$currentSeason || $sponsor->season_id !== $currentSeason->id) {
            session()->flash('error', 'Solo puedes editar patrocinadores de la temporada en curso.');
            return;
        }

        $this->editMode = true;
        $this->sponsorId = $sponsor->id;
        $this->name = $sponsor->name;
        $this->existingLogo = $sponsor->logo;
        $this->web = $sponsor->web;
        $this->published = $sponsor->published;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Obtener la temporada en curso
        $currentSeason = Season::forSchool(auth()->user()->sports_school_id)
            ->current()
            ->first();

        if (!$currentSeason) {
            session()->flash('error', 'No hay una temporada en curso activa.');
            return;
        }

        $data = [
            'sports_school_id' => auth()->user()->sports_school_id,
            'name' => $this->name,
            'web' => $this->web,
            'season_id' => $currentSeason->id,
            'published' => $this->published,
        ];

        // Handle logo upload
        if ($this->logo) {
            // Delete old logo if editing
            if ($this->editMode && $this->existingLogo) {
                Storage::disk('public')->delete($this->existingLogo);
            }
            $data['logo'] = $this->logo->store('sponsors', 'public');
        }

        if ($this->editMode) {
            $sponsor = Sponsor::findOrFail($this->sponsorId);
            $data['updated_user'] = auth()->id();
            $sponsor->update($data);
            session()->flash('message', 'Patrocinador actualizado correctamente.');
        } else {
            // Asignar el siguiente orden disponible
            $maxOrder = Sponsor::bySchool(auth()->user()->sports_school_id)
                ->where('season_id', $currentSeason->id)
                ->max('order');
            $data['order'] = ($maxOrder ?? -1) + 1;
            $data['created_user'] = auth()->id();
            Sponsor::create($data);
            session()->flash('message', 'Patrocinador creado correctamente.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete($sponsorId)
    {
        $this->sponsorToDelete = $sponsorId;
        $this->confirmingDeletion = true;
    }

    public function deleteSponsor()
    {
        $sponsor = Sponsor::find($this->sponsorToDelete);
        
        if ($sponsor && $sponsor->sports_school_id === auth()->user()->sports_school_id) {
            // Verificar que el patrocinador pertenece a la temporada en curso
            $currentSeason = Season::forSchool(auth()->user()->sports_school_id)->current()->first();
            if (!$currentSeason || $sponsor->season_id !== $currentSeason->id) {
                session()->flash('error', 'Solo puedes eliminar patrocinadores de la temporada en curso.');
                $this->confirmingDeletion = false;
                $this->sponsorToDelete = null;
                return;
            }

            // Delete logo if exists
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $sponsor->delete();
            session()->flash('message', 'Patrocinador eliminado correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->sponsorToDelete = null;
    }

    public function togglePublished($sponsorId)
    {
        $sponsor = Sponsor::find($sponsorId);
        
        if ($sponsor && $sponsor->sports_school_id === auth()->user()->sports_school_id) {
            // Verificar que el patrocinador pertenece a la temporada en curso
            $currentSeason = Season::forSchool(auth()->user()->sports_school_id)->current()->first();
            if (!$currentSeason || $sponsor->season_id !== $currentSeason->id) {
                session()->flash('error', 'Solo puedes cambiar el estado de patrocinadores de la temporada en curso.');
                return;
            }

            $sponsor->published = !$sponsor->published;
            $sponsor->updated_user = auth()->id();
            $sponsor->save();
            session()->flash('message', 'Estado de publicación actualizado.');
        }
    }

    public function updateOrder($sponsorId, $newPosition)
    {
        $sponsor = Sponsor::find($sponsorId);
        
        if (!$sponsor || $sponsor->sports_school_id !== auth()->user()->sports_school_id) {
            return;
        }

        // Verificar que pertenece a la temporada en curso
        $currentSeason = Season::forSchool(auth()->user()->sports_school_id)->current()->first();
        if (!$currentSeason || $sponsor->season_id !== $currentSeason->id) {
            session()->flash('error', 'Solo puedes reordenar patrocinadores de la temporada en curso.');
            return;
        }

        // Obtener todos los sponsors de la temporada en curso ordenados
        $sponsors = Sponsor::bySchool(auth()->user()->sports_school_id)
            ->where('season_id', $currentSeason->id)
            ->orderBy('order', 'asc')
            ->get();

        // Encontrar la posición actual del sponsor
        $currentPosition = $sponsors->search(function($item) use ($sponsorId) {
            return $item->id == $sponsorId;
        });

        if ($currentPosition === false) {
            return;
        }

        // Reordenar la colección
        $sponsors = $sponsors->values();
        $item = $sponsors->pull($currentPosition);
        $sponsors->splice($newPosition, 0, [$item]);

        // Actualizar el orden en la base de datos
        foreach ($sponsors as $index => $s) {
            $s->order = $index;
            $s->save();
        }

        session()->flash('message', 'Orden actualizado correctamente.');
    }

    private function resetForm()
    {
        $this->sponsorId = null;
        $this->name = '';
        $this->logo = null;
        $this->existingLogo = null;
        $this->web = '';
        $this->published = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        $sponsors = Sponsor::bySchool(auth()->user()->sports_school_id)
            ->with(['season'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('web', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $currentSeason = Season::forSchool(auth()->user()->sports_school_id)
            ->current()
            ->first();

        return view('livewire.sponsors.index', [
            'sponsors' => $sponsors,
            'currentSeason' => $currentSeason,
        ]);
    }
}
