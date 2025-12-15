<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sports_school_id',
        'exercise_type_id',
        'title',
        'description',
        'recommended_players',
        'recommended_time',
        'difficulty',
        'intensity',
        'category_id',
        'recommended_age_min',
        'recommended_age_max',
        'is_public',
        'is_active',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_active' => 'boolean',
        'recommended_time' => 'integer',
        'recommended_players' => 'integer',
        'recommended_age_min' => 'integer',
        'recommended_age_max' => 'integer',
    ];

    /**
     * Get the user that created the exercise.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sports school that owns the exercise.
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Get the exercise type.
     */
    public function exerciseType(): BelongsTo
    {
        return $this->belongsTo(ExerciseType::class);
    }

    /**
     * Get the category for the exercise.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the media for the exercise.
     */
    public function media(): HasMany
    {
        return $this->hasMany(ExerciseMedia::class)->orderBy('order');
    }

    /**
     * Get only images for the exercise.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ExerciseMedia::class)->where('file_type', 'image')->orderBy('order');
    }

    /**
     * Get only videos for the exercise.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(ExerciseMedia::class)->where('file_type', 'video')->orderBy('order');
    }

    /**
     * Get users who have favorited this exercise.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'exercise_user_favorites')
                    ->withTimestamps();
    }

    /**
     * Get training session exercises that use this exercise.
     */
    public function trainingSessionExercises(): HasMany
    {
        return $this->hasMany(TrainingSessionExercise::class);
    }

    /**
     * Scope a query to only include active exercises.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include public exercises.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to filter by sports school.
     */
    public function scopeForSchool($query, $schoolId)
    {
        return $query->where('sports_school_id', $schoolId);
    }
}
