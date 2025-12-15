<?php

namespace App\Livewire\ProductCategories;

use Livewire\Component;
use App\Models\ProductCategory;

class Create extends Component
{
    public $name = '';
    public $description = '';
    public $active = true;
    public $order = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'active' => 'boolean',
        'order' => 'required|integer|min:0',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.max' => 'El nombre no puede superar los 255 caracteres.',
        'order.required' => 'El orden es obligatorio.',
        'order.integer' => 'El orden debe ser un número entero.',
        'order.min' => 'El orden debe ser mayor o igual a 0.',
    ];

    public function save()
    {
        $this->validate();

        ProductCategory::create([
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
            'order' => $this->order,
            'created_user' => auth()->id(),
        ]);

        session()->flash('message', 'Categoría creada correctamente.');

        return redirect()->route('product-categories.index');
    }

    public function render()
    {
        return view('livewire.product-categories.create');
    }
}
