<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentStanding extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'tournament_category_id',
        'phase_id',
        'tournament_team_id',
        'group_label',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'points',
        'position',
        'extra',
    ];

    protected $casts = [
        'extra'      => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ──────────────────────────────────────── Derived attributes
    public function getGoalDifferenceAttribute(): int
    {
        return $this->goals_for - $this->goals_against;
    }

    // ──────────────────────────────────────── Relationships
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function tournamentCategory()
    {
        return $this->belongsTo(TournamentCategory::class);
    }

    public function phase()
    {
        return $this->belongsTo(TournamentPhase::class, 'phase_id');
    }

    public function tournamentTeam()
    {
        return $this->belongsTo(TournamentTeam::class);
    }
}
