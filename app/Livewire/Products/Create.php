<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMedia;
use App\Models\Size;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $code = '';
    public $category_id = '';
    public $name = '';
    public $description = '';
    public $category = '';
    public $price = 0;
    public $cost_price = 0;
    public $club_price = 0;
    public $image;
    public $mediaFiles = [];
    public $has_sizes = true;
    public $active = true;
    public $published_web = false;
    public $observations = '';
    
    // Stock
    public $stockData = [];
    public $sizes = [];

    protected $rules = [
        'code' => 'required|string|max:50|unique:products,code',
        'category_id' => 'nullable|exists:product_categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:100',
        'price' => 'required|numeric|min:0',
        'cost_price' => 'required|numeric|min:0',
        'club_price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'mediaFiles.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
        'has_sizes' => 'boolean',
        'active' => 'boolean',
        'published_web' => 'boolean',
        'observations' => 'nullable|string',
        'stockData.*.quantity' => 'required|integer|min:0',
        'stockData.*.min_stock' => 'required|integer|min:0',
    ];

    protected $messages = [
        'code.required' => 'El código es obligatorio.',
        'code.unique' => 'Este código ya existe.',
        'name.required' => 'El nombre es obligatorio.',
        'price.required' => 'El precio es obligatorio.',
        'price.min' => 'El precio debe ser mayor o igual a 0.',
    ];

    public function mount()
    {
        $this->sizes = Size::active()->ordered()->get();
        
        // Inicializar stock para cada talla
        foreach ($this->sizes as $size) {
            $this->stockData[$size->id] = [
                'quantity' => 0,
                'min_stock' => 0,
            ];
        }
    }

    public function updatedHasSizes()
    {
        // Si no tiene tallas, solo necesitamos un registro de stock
        if (!$this->has_sizes) {
            $this->stockData = [
                0 => [
                    'quantity' => 0,
                    'min_stock' => 0,
                ]
            ];
        } else {
            // Reinicializar con tallas
            $this->stockData = [];
            foreach ($this->sizes as $size) {
                $this->stockData[$size->id] = [
                    'quantity' => 0,
                    'min_stock' => 0,
                ];
            }
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('products', 'public');
            }

            $product = Product::create([
                'code' => $this->code,
                'category_id' => $this->category_id ?: null,
                'name' => $this->name,
                'description' => $this->description,
                'category' => $this->category,
                'price' => $this->price,
                'cost_price' => $this->cost_price,
                'club_price' => $this->club_price,
                'image' => $imagePath,
                'has_sizes' => $this->has_sizes,
                'active' => $this->active,
                'published_web' => $this->published_web,
                'observations' => $this->observations,
                'created_user' => auth()->id(),
            ]);

            // Guardar archivos multimedia
            if ($this->mediaFiles) {
                foreach ($this->mediaFiles as $index => $file) {
                    $filePath = $file->store('products/media', 'public');
                    $extension = $file->getClientOriginalExtension();
                    $type = in_array(strtolower($extension), ['mp4', 'mov', 'avi']) ? 'video' : 'image';
                    
                    ProductMedia::create([
                        'product_id' => $product->id,
                        'file_path' => $filePath,
                        'type' => $type,
                        'order' => $index,
                        'is_primary' => $index === 0,
                        'created_user' => auth()->id(),
                    ]);
                }
            }

            // Crear registros de stock
            foreach ($this->stockData as $sizeId => $stock) {
                ProductStock::create([
                    'product_id' => $product->id,
                    'size_id' => $sizeId == 0 ? null : $sizeId,
                    'quantity' => $stock['quantity'],
                    'min_stock' => $stock['min_stock'],
                    'created_user' => auth()->id(),
                ]);
            }

            DB::commit();

            session()->flash('message', 'Producto creado correctamente.');

            return redirect()->route('products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            session()->flash('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $availableSizes = Size::active()->ordered()->get();
        $categories = ProductCategory::active()->ordered()->get();
        
        return view('livewire.products.create', [
            'availableSizes' => $availableSizes,
            'categories' => $categories,
        ]);
    }
}
