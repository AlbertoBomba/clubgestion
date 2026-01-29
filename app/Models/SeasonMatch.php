<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeasonMatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'season_matches';

    protected $fillable = [
        'season_id',
        'team_id',
        'sports_school_id',
        'opponent',
        'date',
        'hour_match',
        'hour_meeting',
        'site',
        'observations',
        'match_description',
        'goals_team',
        'goals_oponent',
        'escudo_team_oponent',
        'sites',
        'formation',
        'lineup',
        'football_type',
        'share_token',
        'share_expires_at',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'date' => 'date',
        'hour_match' => 'datetime:H:i',
        'hour_meeting' => 'datetime:H:i',
        'lineup' => 'array',
        'share_expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'match_player', 'match_id', 'player_id')
            ->withPivot('created_user', 'updated_user', 'reason_not_called', 'confirmed', 'confirmed_at', 'card_yellow1', 'card_yellow2', 'card_red')
            ->withTimestamps();
    }

    public function notCalledPlayers()
    {
        return $this->belongsToMany(Player::class, 'match_player_not_called', 'match_id', 'player_id')
            ->withPivot('reason', 'created_user', 'updated_user')
            ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    // Generate unique share token
    public function generateShareToken()
    {
        do {
            $token = bin2hex(random_bytes(32));
        } while (self::where('share_token', $token)->exists());

        $this->share_token = $token;
        $this->share_expires_at = now()->addHours(48);
        $this->save();

        return $token;
    }

    // Check if share token is expired
    public function isShareTokenExpired()
    {
        if (!$this->share_token || !$this->share_expires_at) {
            return true;
        }
        
        return now()->greaterThan($this->share_expires_at);
    }

    // Get public URL
    public function getPublicUrl()
    {
        if (!$this->share_token) {
            $this->generateShareToken();
        }
        return url('/convocatoria/' . $this->share_token);
    }
}
