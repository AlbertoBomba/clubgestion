<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'category_id',
        'name',
        'order',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ──────────────────────────────────────── Helpers

    public static function statuses(): array
    {
        return [
            'active'    => 'Activa',
            'completed' => 'Finalizada',
            'cancelled' => 'Cancelada',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }

    public function displayName(): string
    {
        if ($this->name) {
            return $this->name;
        }
        return $this->category?->category ?? "Categoría #{$this->id}";
    }

    // ──────────────────────────────────────── Relationships

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
}
