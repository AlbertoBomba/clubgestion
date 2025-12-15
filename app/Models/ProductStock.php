<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    use SoftDeletes;

    protected $table = 'product_stock';

    protected $fillable = [
        'product_id',
        'size_id',
        'quantity',
        'min_stock',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'min_stock' => 'integer',
    ];

    /**
     * Relación con producto
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relación con talla
     */
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
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
     * Scope para stock bajo
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= min_stock');
    }

    /**
     * Scope para sin stock
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }

    /**
     * Verificar si está en stock bajo
     */
    public function isLowStock()
    {
        return $this->quantity <= $this->min_stock;
    }

    /**
     * Verificar si está sin stock
     */
    public function isOutOfStock()
    {
        return $this->quantity == 0;
    }
}
