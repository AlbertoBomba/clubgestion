<?php

namespace App\Livewire\Sizes;

use Livewire\Component;
use App\Models\Size;

class Create extends Component
{
    public $size = '';
    public $description = '';
    public $category = 'general';
    public $active = true;
    public $order = 0;

    protected $rules = [
        'size' => 'required|string|max:50',
        'description' => 'nullable|string',
        'category' => 'required|string|max:50',
        'active' => 'boolean',
        'order' => 'integer|min:0',
    ];

    protected $messages = [
        'size.required' => 'El campo talla es obligatorio.',
        'category.required' => 'El campo categoría es obligatorio.',
    ];

    public function save()
    {
        $this->validate();

        Size::create([
            'size' => $this->size,
            'description' => $this->description,
            'category' => $this->category,
            'active' => $this->active,
            'order' => $this->order,
            'created_user' => auth()->id(),
        ]);

        session()->flash('message', 'Talla creada correctamente.');

        return redirect()->route('sizes.index');
    }

    public function render()
    {
        return view('livewire.sizes.create');
    }
}
