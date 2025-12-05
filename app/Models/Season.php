<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\BelongsToSportsSchool;

class Season extends Model
{
    use SoftDeletes, BelongsToSportsSchool;

    protected $fillable = [
        'season',
        'description',
        'sports_school_id',
        'from_year',
        'to_year',
        'start_date',
        'end_date',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'from_year' => 'integer',
        'to_year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
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
            ->withPivot('created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the sections associated with the season.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'season_section')
            ->withTimestamps()
            ->withPivot('price', 'created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the teams associated with the season.
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
