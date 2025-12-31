<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'size',
        'description',
        'category',
        'active',
        'order',
        'edad',
        'pecho',
        'cintura',
        'cadera',
        'brand_id',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relación con marca
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Relación con stock de productos
     */
    public function productStock(): HasMany
    {
        return $this->hasMany(ProductStock::class);
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
     * Scope para tallas activas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope para ordenar por campo order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('size');
    }
}
