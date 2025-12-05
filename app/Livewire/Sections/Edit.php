<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Section;

class Edit extends Component
{
    public Section $section;
    public $name = '';
    public $description = '';
    public $active = true;
    public $hasChanges = false;
    
    // Valores originales para comparar
    private $originalName;
    private $originalDescription;
    private $originalActive;

    public function updated($propertyName)
    {
        $this->checkForChanges();
    }

    private function checkForChanges()
    {
        $this->hasChanges = 
            $this->name !== $this->originalName ||
            ($this->description ?? '') !== ($this->originalDescription ?? '') ||
            $this->active !== $this->originalActive;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'active' => 'boolean',
    ];

    public function mount(Section $section)
    {
        $this->section = $section;
        $this->name = $section->name;
        $this->description = $section->description;
        $this->active = $section->active;
        
        // Guardar valores originales para detectar cambios
        $this->originalName = $this->name;
        $this->originalDescription = $this->description ?? '';
        $this->originalActive = $this->active;
    }

    public function save()
    {
        $this->validate();

        $this->section->update([
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
            'updated_user' => auth()->id(),
        ]);
        
        // Actualizar valores originales después de guardar
        $this->originalName = $this->name;
        $this->originalDescription = $this->description ?? '';
        $this->originalActive = $this->active;
        $this->hasChanges = false;

        session()->flash('message', 'Sección actualizada correctamente.');
        
        return redirect()->route('sections.index');
    }

    public function render()
    {
        return view('livewire.sections.edit');
    }
}
