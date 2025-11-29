<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Section;

class Create extends Component
{
    public $name = '';
    public $description = '';
    public $active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Section::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
            'created_user' => auth()->id(),
        ]);

        session()->flash('message', 'Sección creada correctamente.');
        
        return redirect()->route('sections.index');
    }

    public function render()
    {
        return view('livewire.sections.create');
    }
}
