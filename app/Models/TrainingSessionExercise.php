<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSessionExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_session_id',
        'exercise_id',
        'order',
        'custom_title',
        'custom_description',
        'duration_minutes',
        'recommended_players',
        'notes',
    ];

    /**
     * Get the training session that owns the exercise.
     */
    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }

    /**
     * Get the exercise (if not custom).
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Check if this is a custom exercise.
     */
    public function isCustom(): bool
    {
        return $this->exercise_id === null;
    }

    /**
     * Get the title of the exercise (custom or from exercise).
     */
    public function getTitleAttribute()
    {
        return $this->isCustom() ? $this->custom_title : $this->exercise?->title;
    }

    /**
     * Get the description of the exercise (custom or from exercise).
     */
    public function getDescriptionAttribute()
    {
        return $this->isCustom() ? $this->custom_description : $this->exercise?->description;
    }
}
