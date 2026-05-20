<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentSanction extends Model
{
    protected $fillable = [
        'tournament_id',
        'tournament_match_id',
        'tournament_team_id',
        'tournament_player_id',
        'sanction_type',
        'matches_suspended',
        'matches_served',
        'reason',
        'notes',
        'active',
    ];

    protected $casts = [
        'matches_suspended' => 'integer',
        'matches_served'    => 'integer',
        'active'            => 'boolean',
    ];

    public static function sanctionTypes(): array
    {
        return [
            'suspension'      => 'Suspensión',
            'warning'         => 'Apercibimiento',
            'fine'            => 'Multa',
            'disqualification'=> 'Descalificación',
        ];
    }

    public function sanctionTypeLabel(): string
    {
        return self::sanctionTypes()[$this->sanction_type] ?? $this->sanction_type;
    }

    public function matchesPending(): int
    {
        return max(0, $this->matches_suspended - $this->matches_served);
    }

    // ──────────────────────────── Relationships

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    // El partido/jornada donde se originó la sanción
    public function originMatch()
    {
        return $this->belongsTo(TournamentMatch::class, 'tournament_match_id');
    }

    public function team()
    {
        return $this->belongsTo(TournamentTeam::class, 'tournament_team_id');
    }

    public function player()
    {
        return $this->belongsTo(TournamentPlayer::class, 'tournament_player_id');
    }
}
