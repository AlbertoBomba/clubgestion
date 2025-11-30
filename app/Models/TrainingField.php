<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TrainingField extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'field_type',
        'surface_type',
        'description',
        'capacity',
        'color',
        'available_from',
        'available_to',
        'active',
        'sports_school_id',
        'season_id',
        'created_user',
        'updated_user'
    ];

    protected $casts = [
        'active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * Relación con la escuela deportiva
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Horarios asignados al campo
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(TrainingSchedule::class);
    }

    /**
     * Secciones que entrenan en este campo
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'section_training_field')
            ->withTimestamps();
    }

    /**
     * Relación con la temporada
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
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
     * Obtener el nombre legible del tipo de campo
     */
    public function getFieldTypeNameAttribute(): string
    {
        return match($this->field_type) {
            'futbol_11' => 'Fútbol 11',
            'futbol_7' => 'Fútbol 7',
            'futsal' => 'Fútbol Sala',
            'polideportivo' => 'Polideportivo',
            default => $this->field_type,
        };
    }

    /**
     * Obtener el nombre legible del tipo de superficie
     */
    public function getSurfaceTypeNameAttribute(): string
    {
        return match($this->surface_type) {
            'cesped_natural' => 'Césped Natural',
            'cesped_artificial' => 'Césped Artificial',
            'tierra' => 'Tierra',
            'parquet' => 'Parquet',
            default => $this->surface_type,
        };
    }
}
