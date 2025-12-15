<?php

namespace App\Livewire\ProductCategories;

use Livewire\Component;
use App\Models\ProductCategory;

class Index extends Component
{
    public $search = '';
    public $showDeleteModal = false;
    public $categoryToDelete = null;

    public function confirmDelete($categoryId)
    {
        $this->categoryToDelete = $categoryId;
        $this->showDeleteModal = true;
    }

    public function deleteCategory()
    {
        $category = ProductCategory::find($this->categoryToDelete);
        
        if ($category) {
            // Verificar si tiene productos asociados
            if ($category->products()->count() > 0) {
                session()->flash('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
            } else {
                $category->delete();
                session()->flash('message', 'Categoría eliminada correctamente.');
            }
        }

        $this->showDeleteModal = false;
        $this->categoryToDelete = null;
    }

    public function toggleActive($categoryId)
    {
        $category = ProductCategory::find($categoryId);
        if ($category) {
            $category->active = !$category->active;
            $category->updated_user = auth()->id();
            $category->save();
            
            session()->flash('message', 'Estado actualizado correctamente.');
        }
    }

    public function render()
    {
        $categories = ProductCategory::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount('products')
            ->ordered()
            ->get();

        return view('livewire.product-categories.index', [
            'categories' => $categories,
        ]);
    }
}
