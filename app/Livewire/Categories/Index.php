<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $categoryToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($categoryId)
    {
        $this->categoryToDelete = $categoryId;
        $this->confirmingDeletion = true;
    }

    public function deleteCategory()
    {
        $category = Category::find($this->categoryToDelete);
        
        if ($category && $category->sports_school_id === auth()->user()->sports_school_id) {
            $category->delete();
            session()->flash('message', 'Categoría eliminada correctamente.');
        }
        
        $this->confirmingDeletion = false;
        $this->categoryToDelete = null;
    }

    public function render()
    {
        $categories = Category::bySchool(auth()->user()->sports_school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('category', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('modality', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('category')
            ->paginate(10);

        return view('livewire.categories.index', [
            'categories' => $categories
        ]);
    }
}
