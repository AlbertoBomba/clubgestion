<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Brand extends Model
{
    protected $fillable = [
        'brand',
    ];

    /**
     * Relación con tallas
     */
    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }

    /**
     * Relación con escuelas deportivas (many-to-many)
     */
    public function sportsSchools(): BelongsToMany
    {
        return $this->belongsToMany(SportsSchool::class, 'sports_schools_brand', 'brand_id', 'sports_school_id');
    }
}
