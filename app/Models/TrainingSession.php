<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'title',
        'description',
        'session_date',
        'start_time',
        'duration_minutes',
        'day_of_week',
        'is_completed',
        'notes',
    ];

    protected $casts = [
        'session_date' => 'date',
        'start_time' => 'datetime',
        'is_completed' => 'boolean',
    ];

    /**
     * Get the team that owns the training session.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the user (coach) who created the training session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the exercises for the training session.
     */
    public function sessionExercises(): HasMany
    {
        return $this->hasMany(TrainingSessionExercise::class)->orderBy('order');
    }

    /**
     * Get the total duration of all exercises in the session.
     */
    public function getTotalExercisesDurationAttribute()
    {
        return $this->sessionExercises->sum('duration_minutes');
    }

    /**
     * Get the number of exercises in the session.
     */
    public function getExercisesCountAttribute()
    {
        return $this->sessionExercises->count();
    }
}
