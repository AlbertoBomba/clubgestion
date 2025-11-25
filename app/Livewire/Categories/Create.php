<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class Create extends Component
{
    public $category = '';
    public $description = '';
    public $from_age = '';
    public $to_age = '';
    public $modality = '';

    protected $rules = [
        'category' => 'required|string|max:255',
        'description' => 'nullable|string',
        'from_age' => 'nullable|integer|min:0|max:100',
        'to_age' => 'nullable|integer|min:0|max:100',
        'modality' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'sports_school_id' => auth()->user()->sports_school_id,
            'category' => $this->category,
            'description' => $this->description,
            'from_age' => $this->from_age ?: null,
            'to_age' => $this->to_age ?: null,
            'modality' => $this->modality,
            'created_user' => auth()->id(),
        ]);

        session()->flash('message', 'Categoría creada correctamente.');
        
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
