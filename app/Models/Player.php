<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\BelongsToSportsSchool;

class Player extends Model
{
    use SoftDeletes, BelongsToSportsSchool;

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
        'documents',
        'descEnt',
        'descPerc',
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
        'documents' => 'array',
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
            ->withPivot('created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the teams associated with the player.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'teams_players')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the sections associated with the player.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'players_sections')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Get the payment players (órdenes de pago) associated with the player.
     */
    public function paymentPlayers()
    {
        return $this->hasMany(PaymentPlayer::class, 'player_id');
    }

    /**
     * Get the player's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }
}
