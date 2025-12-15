<?php

namespace App\Livewire\Sizes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Size;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $showDeleteModal = false;
    public $sizeToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->sizeToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteSize()
    {
        if ($this->sizeToDelete) {
            $size = Size::find($this->sizeToDelete);
            
            // Verificar si tiene stock asociado
            if ($size && $size->productStock()->count() > 0) {
                session()->flash('error', 'No se puede eliminar la talla porque tiene stock asociado.');
            } else {
                $size->delete();
                session()->flash('message', 'Talla eliminada correctamente.');
            }
        }

        $this->showDeleteModal = false;
        $this->sizeToDelete = null;
    }

    public function toggleActive($id)
    {
        $size = Size::find($id);
        if ($size) {
            $size->active = !$size->active;
            $size->updated_user = auth()->id();
            $size->save();
            
            session()->flash('message', 'Estado actualizado correctamente.');
        }
    }

    public function render()
    {
        $sizes = Size::when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('size', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy('order')
            ->orderBy('size')
            ->paginate(20);

        $categories = Size::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('livewire.sizes.index', [
            'sizes' => $sizes,
            'categories' => $categories,
        ]);
    }
}
