<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentMatchGoal extends Model
{
    protected $fillable = [
        'tournament_match_id',
        'tournament_player_id',
        'tournament_team_id',
        'minute',
        'goal_type',
        'notes',
    ];

    protected $casts = [
        'minute' => 'integer',
    ];

    public static function goalTypes(): array
    {
        return [
            'normal'    => 'Gol',
            'penalty'   => 'Penalti',
            'own_goal'  => 'Gol en propia',
        ];
    }

    public function goalTypeLabel(): string
    {
        return self::goalTypes()[$this->goal_type] ?? $this->goal_type;
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
