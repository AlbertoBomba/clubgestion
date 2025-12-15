<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sports_school_id',
        'title',
        'description',
        'recommended_players',
        'recommended_time',
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
     * Get the user that created the training.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sports school that owns the training.
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Get the category for the training.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the media for the training.
     */
    public function media(): HasMany
    {
        return $this->hasMany(TrainingMedia::class)->orderBy('order');
    }

    /**
     * Get only images for the training.
     */
    public function images(): HasMany
    {
        return $this->hasMany(TrainingMedia::class)->where('file_type', 'image')->orderBy('order');
    }

    /**
     * Get only videos for the training.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(TrainingMedia::class)->where('file_type', 'video')->orderBy('order');
    }

    /**
     * Scope a query to only include active trainings.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include public trainings.
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
