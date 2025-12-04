<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Section extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color',
        'active',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the seasons associated with the section.
     */
    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class, 'season_section')
            ->withTimestamps()
            ->withPivot('price', 'created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the players associated with the section.
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'player_section')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the training fields associated with the section.
     */
    public function trainingFields(): BelongsToMany
    {
        return $this->belongsToMany(TrainingField::class, 'section_training_field')
            ->withTimestamps();
    }
}
