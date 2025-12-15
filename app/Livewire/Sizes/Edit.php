<?php

namespace App\Livewire\Sizes;

use Livewire\Component;
use App\Models\Size;

class Edit extends Component
{
    public $sizeId;
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

    public function mount($id)
    {
        $sizeModel = Size::findOrFail($id);
        $this->sizeId = $sizeModel->id;
        $this->size = $sizeModel->size;
        $this->description = $sizeModel->description;
        $this->category = $sizeModel->category;
        $this->active = $sizeModel->active;
        $this->order = $sizeModel->order;
    }

    public function update()
    {
        $this->validate();

        $sizeModel = Size::find($this->sizeId);
        
        $sizeModel->update([
            'size' => $this->size,
            'description' => $this->description,
            'category' => $this->category,
            'active' => $this->active,
            'order' => $this->order,
            'updated_user' => auth()->id(),
        ]);

        session()->flash('message', 'Talla actualizada correctamente.');

        return redirect()->route('sizes.index');
    }

    public function render()
    {
        return view('livewire.sizes.edit');
    }
}
