<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $stockFilter = ''; // all, low, out
    public $showDeleteModal = false;
    public $productToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStockFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->productToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        if ($this->productToDelete) {
            $product = Product::find($this->productToDelete);
            
            if ($product) {
                // Eliminar stock asociado
                $product->stock()->delete();
                $product->delete();
                
                session()->flash('message', 'Producto eliminado correctamente.');
            }
        }

        $this->showDeleteModal = false;
        $this->productToDelete = null;
    }

    public function toggleActive($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->active = !$product->active;
            $product->updated_user = auth()->id();
            $product->save();
            
            session()->flash('message', 'Estado actualizado correctamente.');
        }
    }

    public function render()
    {
        $products = Product::with(['stock.size'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->when($this->stockFilter == 'low', function($query) {
                $query->whereHas('stock', function($q) {
                    $q->whereRaw('quantity <= min_stock')->where('quantity', '>', 0);
                });
            })
            ->when($this->stockFilter == 'out', function($query) {
                $query->whereHas('stock', function($q) {
                    $q->where('quantity', 0);
                });
            })
            ->orderBy('code')
            ->paginate(15);

        $categories = Product::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        return view('livewire.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
