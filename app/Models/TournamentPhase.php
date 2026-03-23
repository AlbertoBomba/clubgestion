<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TournamentPhase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tournament_id',
        'tournament_category_id',
        'name',
        'type',
        'order',
        'status',
        'settings',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'settings'   => 'array',
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ──────────────────────────────────────── Type helpers
    public static function types(): array
    {
        return [
            'league'              => 'Liga',
            'group'               => 'Fase de grupos',
            'knockout'            => 'Eliminatoria',
            'swiss'               => 'Sistema suizo',
            'double_elimination'  => 'Doble eliminación',
        ];
    }

    public function typeLabel(): string
    {
        return self::types()[$this->type] ?? $this->type;
    }

    public function typeIcon(): string
    {
        return match ($this->type) {
            'league'             => '🏆',
            'group'              => '⬡',
            'knockout'           => '⚡',
            'swiss'              => '🔀',
            'double_elimination' => '🔁',
            default              => '📋',
        };
    }

    public static function statuses(): array
    {
        return [
            'pending'     => 'Pendiente',
            'in_progress' => 'En curso',
            'completed'   => 'Completada',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    // ──────────────────────────────────────── Default settings per type
    public static function defaultSettings(string $type): array
    {
        return match ($type) {
            'league', 'group' => [
                'points_per_win'  => 3,
                'points_per_draw' => 1,
                'points_per_loss' => 0,
                'legs'            => 2,
                'groups_count'    => 1,
                'teams_advance'   => 2,
            ],
            'knockout' => [
                'legs'            => 1,
                'third_place'     => false,
                'away_goals'      => false,
                'extra_time'      => true,
                'penalties'       => true,
            ],
            'swiss' => [
                'rounds'          => 7,
                'points_per_win'  => 1,
                'points_per_draw' => 0.5,
                'points_per_loss' => 0,
            ],
            'double_elimination' => [
                'legs'            => 1,
                'extra_time'      => true,
                'penalties'       => true,
            ],
            default => [],
        };
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

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class, 'phase_id');
    }

    public function standings()
    {
        return $this->hasMany(TournamentStanding::class, 'phase_id');
    }
}
