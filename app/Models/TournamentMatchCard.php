<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentMatchCard extends Model
{
    protected $fillable = [
        'tournament_match_id',
        'tournament_player_id',
        'tournament_team_id',
        'card_type',
        'minute',
        'notes',
    ];

    protected $casts = [
        'minute' => 'integer',
    ];

    public static function cardTypes(): array
    {
        return [
            'yellow'        => 'Amarilla',
            'red'           => 'Roja directa',
            'double_yellow' => 'Doble amarilla (= roja)',
        ];
    }

    public function cardTypeLabel(): string
    {
        return self::cardTypes()[$this->card_type] ?? $this->card_type;
    }

    public function isRed(): bool
    {
        return in_array($this->card_type, ['red', 'double_yellow']);
    }

    // ──────────────────────────── Relationships

    public function match()
    {
        return $this->belongsTo(TournamentMatch::class, 'tournament_match_id');
    }

    public function player()
    {
        return $this->belongsTo(TournamentPlayer::class, 'tournament_player_id');
    }

    public function team()
    {
        return $this->belongsTo(TournamentTeam::class, 'tournament_team_id');
    }
}
