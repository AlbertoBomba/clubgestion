<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'training_field_id',
        'season_id',
        'day_of_week',
        'start_time',
        'end_time',
        'notes',
        'active',
        'created_user',
        'updated_user'
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Relación con el equipo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Relación con el campo de entrenamiento
     */
    public function trainingField(): BelongsTo
    {
        return $this->belongsTo(TrainingField::class);
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
     * Obtener el nombre del día formateado
     */
    public function getDayNameAttribute(): string
    {
        return ucfirst($this->day_of_week);
    }

    /**
     * Obtener el horario formateado
     */
    public function getTimeRangeAttribute(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }
}
