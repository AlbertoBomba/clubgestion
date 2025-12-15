<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'category_id',
        'name',
        'description',
        'category',
        'price',
        'cost_price',
        'club_price',
        'image',
        'has_sizes',
        'active',
        'published_web',
        'observations',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'club_price' => 'decimal:2',
        'has_sizes' => 'boolean',
        'active' => 'boolean',
        'published_web' => 'boolean',
    ];

    /**
     * Relación con stock
     */
    public function stock(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    /**
     * Relación con medios (imágenes y videos)
     */
    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    /**
     * Relación con categoría
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Usuario que creó el registro
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    /**
     * Usuario que actualizó el registro
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    /**
     * Scope para productos activos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Obtener stock total del producto
     */
    public function getTotalStockAttribute()
    {
        return $this->stock()->sum('quantity');
    }

    /**
     * Verificar si el producto tiene stock bajo
     */
    public function hasLowStock()
    {
        return $this->stock()->whereRaw('quantity <= min_stock')->exists();
    }
}
