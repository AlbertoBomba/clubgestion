<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Season extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'season',
        'description',
        'sports_school_id',
        'from_year',
        'to_year',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'from_year' => 'integer',
        'to_year' => 'integer',
    ];

    /**
     * Get the sports school that owns the season.
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Get the players associated with the season.
     */
    public function players()
    {
        return $this->belongsToMany(Player::class, 'seasons_players')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at');
    }
}
