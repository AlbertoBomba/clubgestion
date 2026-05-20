<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'tournament_category_id',
        'team_id',
        'name_override',
        'external_team',
        'logo',
        'contact_name',
        'contact_phone',
        'email',
        'password',
        'status',
        'seed',
        'group_label',
        'notes',
        'registration_token',
    ];

    protected $casts = [
        'external_team' => 'boolean',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    protected $hidden = ['password'];

    // Generate a permanent 12-char registration token (created once, never changes)
    public function getOrCreateRegistrationToken(): string
    {
        if (!$this->registration_token) {
            do {
                $token = strtoupper(\Illuminate\Support\Str::random(12));
            } while (self::where('registration_token', $token)->exists());

            $this->update(['registration_token' => $token]);
        }
        return $this->registration_token;
    }

    // ──────────────────────────────────────── Helpers
    public static function statuses(): array
    {
        return [
            'registered'   => 'Inscrito',
            'confirmed'    => 'Confirmado',
            'eliminated'   => 'Eliminado',
            'disqualified' => 'Descalificado',
        ];
    }

    public function displayName(): string
    {
        if ($this->name_override) {
            return $this->name_override;
        }
        return $this->team?->team ?? "Equipo #{$this->id}";
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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(TournamentMatch::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(TournamentMatch::class, 'away_team_id');
    }

    public function standings()
    {
        return $this->hasMany(TournamentStanding::class);
    }

    public function players()
    {
        return $this->hasMany(TournamentPlayer::class);
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
}
