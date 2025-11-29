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

        session()->flash('message', 'Sección actualizada correctamente.');
        
        return redirect()->route('sections.index');
    }

    public function render()
    {
        return view('livewire.sections.edit');
    }
}
