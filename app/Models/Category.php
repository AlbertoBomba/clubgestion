<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sports_school_id',
        'category',
        'description',
        'from_age',
        'to_age',
        'modality',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'from_age' => 'integer',
        'to_age' => 'integer',
    ];

    /**
     * Relación con escuela deportiva
     */
    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Usuario que creó la categoría
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    /**
     * Usuario que actualizó la categoría
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    /**
     * Scope para filtrar por escuela
     */
    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('sports_school_id', $schoolId);
    }
}
