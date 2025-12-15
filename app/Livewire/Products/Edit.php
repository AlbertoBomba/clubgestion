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

class Edit extends Component
{
    use WithFileUploads;

    public $productId;
    public $code = '';
    public $category_id = '';
    public $name = '';
    public $description = '';
    public $category = '';
    public $price = 0;
    public $cost_price = 0;
    public $club_price = 0;
    public $image;
    public $currentImage;
    public $mediaFiles = [];
    public $existingMedia = [];
    public $has_sizes = true;
    public $active = true;
    public $published_web = false;
    public $observations = '';
    
    // Stock
    public $stockData = [];
    public $sizes = [];

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:products,code,' . $this->productId,
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
    }

    protected $messages = [
        'code.required' => 'El código es obligatorio.',
        'code.unique' => 'Este código ya existe.',
        'name.required' => 'El nombre es obligatorio.',
        'price.required' => 'El precio es obligatorio.',
        'price.min' => 'El precio debe ser mayor o igual a 0.',
    ];

    public function mount($id)
    {
        $product = Product::with(['stock', 'media'])->findOrFail($id);
        
        $this->productId = $product->id;
        $this->code = $product->code;
        $this->category_id = $product->category_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->category = $product->category;
        $this->price = $product->price;
        $this->cost_price = $product->cost_price;
        $this->club_price = $product->club_price;
        $this->currentImage = $product->image;
        $this->has_sizes = $product->has_sizes;
        $this->active = $product->active;
        $this->published_web = $product->published_web;
        $this->observations = $product->observations;
        $this->existingMedia = $product->media;

        $this->sizes = Size::active()->ordered()->get();

        // Cargar stock existente
        if ($this->has_sizes) {
            foreach ($this->sizes as $size) {
                $stock = $product->stock->where('size_id', $size->id)->first();
                $this->stockData[$size->id] = [
                    'quantity' => $stock ? $stock->quantity : 0,
                    'min_stock' => $stock ? $stock->min_stock : 0,
                ];
            }
        } else {
            $stock = $product->stock->where('size_id', null)->first();
            $this->stockData[0] = [
                'quantity' => $stock ? $stock->quantity : 0,
                'min_stock' => $stock ? $stock->min_stock : 0,
            ];
        }
    }

    public function update()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $product = Product::find($this->productId);

            $imagePath = $this->currentImage;
            if ($this->image) {
                // Eliminar imagen anterior
                if ($this->currentImage) {
                    Storage::disk('public')->delete($this->currentImage);
                }
                $imagePath = $this->image->store('products', 'public');
            }

            $product->update([
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
                'updated_user' => auth()->id(),
            ]);

            // Guardar nuevos archivos multimedia
            if ($this->mediaFiles) {
                $maxOrder = ProductMedia::where('product_id', $product->id)->max('order') ?? -1;
                foreach ($this->mediaFiles as $index => $file) {
                    $path = $file->store('products/media', 'public');
                    $ext = $file->getClientOriginalExtension();
                    $type = in_array(strtolower($ext), ['mp4', 'mov', 'avi']) ? 'video' : 'image';
                    
                    ProductMedia::create([
                        'product_id' => $product->id,
                        'file_path' => $path,
                        'type' => $type,
                        'order' => $maxOrder + $index + 1,
                        'is_primary' => false,
                        'created_user' => auth()->id(),
                    ]);
                }
            }

            // Actualizar stock
            foreach ($this->stockData as $sizeId => $stock) {
                ProductStock::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'size_id' => $sizeId == 0 ? null : $sizeId,
                    ],
                    [
                        'quantity' => $stock['quantity'],
                        'min_stock' => $stock['min_stock'],
                        'updated_user' => auth()->id(),
                    ]
                );
            }

            DB::commit();

            session()->flash('message', 'Producto actualizado correctamente.');

            return redirect()->route('products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    public function deleteMedia($mediaId)
    {
        $media = ProductMedia::find($mediaId);
        if ($media && $media->product_id == $this->productId) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
            
            $this->existingMedia = ProductMedia::where('product_id', $this->productId)->ordered()->get();
            session()->flash('message', 'Archivo eliminado correctamente.');
        }
    }

    public function render()
    {
        $categories = ProductCategory::active()->ordered()->get();
        
        return view('livewire.products.edit', [
            'categories' => $categories,
        ]);
    }
}
