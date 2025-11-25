<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class Edit extends Component
{
    public Category $categoryModel;
    
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

    public function mount(Category $category)
    {
        // Verificar que la categoría pertenece a la escuela del usuario
        if ($category->sports_school_id !== auth()->user()->sports_school_id) {
            abort(403, 'No tienes permisos para editar esta categoría.');
        }

        $this->categoryModel = $category;
        $this->category = $category->category;
        $this->description = $category->description;
        $this->from_age = $category->from_age;
        $this->to_age = $category->to_age;
        $this->modality = $category->modality;
    }

    public function save()
    {
        $this->validate();

        $this->categoryModel->update([
            'category' => $this->category,
            'description' => $this->description,
            'from_age' => $this->from_age ?: null,
            'to_age' => $this->to_age ?: null,
            'modality' => $this->modality,
            'updated_user' => auth()->id(),
        ]);

        session()->flash('message', 'Categoría actualizada correctamente.');
        
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.edit');
    }
}
