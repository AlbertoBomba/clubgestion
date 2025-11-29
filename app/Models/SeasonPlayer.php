<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeasonPlayer extends Model
{
    use SoftDeletes;

    protected $table = 'seasons_players';

    protected $fillable = [
        'season_id',
        'player_id',
        'created_user',
        'updated_user',
    ];

    /**
     * Get the season that owns the relationship.
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the player that owns the relationship.
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
