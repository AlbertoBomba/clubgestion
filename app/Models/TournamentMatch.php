<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentMatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tournament_id',
        'tournament_category_id',
        'phase_id',
        'round',
        'match_number',
        'group_label',
        'home_team_id',
        'away_team_id',
        'home_score',
        'away_score',
        'home_score_extra',
        'away_score_extra',
        'penalty_winner',
        'scheduled_at',
        'played_at',
        'location',
        'status',
        'notes',
        'settings',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'settings'     => 'array',
        'scheduled_at' => 'datetime',
        'played_at'    => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    // ──────────────────────────────────────── Helpers
    public static function statuses(): array
    {
        return [
            'scheduled'   => 'Programado',
            'in_progress' => 'En juego',
            'completed'   => 'Completado',
            'cancelled'   => 'Cancelado',
            'postponed'   => 'Aplazado',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function tournamentCategory()
    {
        return $this->belongsTo(TournamentCategory::class);
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'scheduled'   => 'blue',
            'in_progress' => 'yellow',
            'completed'   => 'green',
            'cancelled'   => 'red',
            'postponed'   => 'orange',
            default       => 'gray',
        };
    }

    public function winner(): ?TournamentTeam
    {
        if ($this->status !== 'completed') return null;

        if ($this->penalty_winner === 'home') return $this->homeTeam;
        if ($this->penalty_winner === 'away') return $this->awayTeam;

        $homeTotal = ($this->home_score ?? 0) + ($this->home_score_extra ?? 0);
        $awayTotal = ($this->away_score ?? 0) + ($this->away_score_extra ?? 0);

        if ($homeTotal > $awayTotal) return $this->homeTeam;
        if ($awayTotal > $homeTotal) return $this->awayTeam;

        return null; // draw
    }

    // ──────────────────────────────────────── Relationships
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function phase()
    {
        return $this->belongsTo(TournamentPhase::class, 'phase_id');
    }

    public function homeTeam()
    {
        return $this->belongsTo(TournamentTeam::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(TournamentTeam::class, 'away_team_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    public function goals()
    {
        return $this->hasMany(TournamentMatchGoal::class);
    }

    public function cards()
    {
        return $this->hasMany(TournamentMatchCard::class);
    }

    public function sanctions()
    {
        return $this->hasMany(TournamentSanction::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }
}
