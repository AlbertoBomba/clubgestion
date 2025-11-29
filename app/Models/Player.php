<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sports_school_id',
        'name',
        'surname',
        'dni',
        'dbirth',
        'dbanio',
        'sizes',
        'dnitutor',
        'nametutor',
        'surnametutor',
        'address',
        'town',
        'province',
        'zip',
        'phone1',
        'phone2',
        'email',
        'active',
        'observations',
        'dorsal',
        'position',
        'soccer',
        'passport',
        'paddle',
        'cod_matricula',
        'goalie',
        'file',
        'player_photo',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'dbirth' => 'date',
        'dbanio' => 'integer',
        'active' => 'boolean',
        'soccer' => 'boolean',
        'passport' => 'boolean',
        'paddle' => 'boolean',
        'goalie' => 'boolean',
        'file' => 'boolean',
        'dorsal' => 'integer',
    ];

    /**
     * Get the sports school that owns the player.
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Get the seasons associated with the player.
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'seasons_players')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at');
    }

    /**
     * Get the sections associated with the player.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'player_section')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at');
    }

    /**
     * Get the player's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }
}
