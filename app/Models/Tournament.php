<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sports_school_id',
        'name',
        'description',
        'logo',
        'location',
        'start_date',
        'end_date',
        'registration_deadline',
        'max_teams',
        'max_players_per_team',
        'registration_fee',
        'player_registration_deadline',
        'min_age',
        'team_type',
        'status',
        'visibility',
        'settings',
        'created_user',
        'updated_user',
        'live',
    ];

    protected $casts = [
        'settings'                      => 'array',
        'start_date'                    => 'date',
        'end_date'                      => 'date',
        'registration_deadline'         => 'date',
        'player_registration_deadline'  => 'date',
        'registration_fee'              => 'decimal:2',
        'live'                          => 'boolean',
        'created_at'                    => 'datetime',
        'updated_at'                    => 'datetime',
        'deleted_at'                    => 'datetime',
    ];

    // ──────────────────────────────────────── Status helpers
    public static function statuses(): array
    {
        return [
            'draft'             => 'Borrador',
            'registration_open' => 'Inscripciones abiertas',
            'in_progress'       => 'En curso',
            'completed'         => 'Finalizado',
            'cancelled'         => 'Cancelado',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'draft'             => 'bg-gray-100 text-gray-600',
            'registration_open' => 'bg-blue-50 text-blue-700',
            'in_progress'       => 'bg-neon-green/10 text-green-700',
            'completed'         => 'bg-purple-50 text-purple-700',
            'cancelled'         => 'bg-red-50 text-red-600',
            default             => 'bg-gray-100 text-gray-600',
        };
    }

    // ──────────────────────────────────────── Relationships
    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
    }



    public function categories()
    {
        return $this->hasMany(TournamentCategory::class)->orderBy('order');
    }

    public function phases()
    {
        return $this->hasMany(TournamentPhase::class)->orderBy('order');
    }

    public function tournamentTeams()
    {
        return $this->hasMany(TournamentTeam::class);
    }

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class);
    }

    public function standings()
    {
        return $this->hasMany(TournamentStanding::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    public function referees()
    {
        return $this->belongsToMany(User::class, 'tournament_referees')
            ->withTimestamps();
    }
}
