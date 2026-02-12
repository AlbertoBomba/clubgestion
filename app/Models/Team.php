<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team',
        'description',
        'team_image',
        'gender',
        'price',
        'federate',
        'published',
        'category_id',
        'season_id',
        'section_id',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'federate' => 'boolean',
        'published' => 'boolean',
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    /**
     * Horarios de entrenamiento del equipo
     */
    public function trainingSchedules()
    {
        return $this->hasMany(TrainingSchedule::class);
    }

    /**
     * Entrenadores del equipo
     */
    public function coaches()
    {
        return $this->belongsToMany(User::class, 'teams_coaches')->withTimestamps();
    }

    /**
     * Jugadores del equipo
     */
    public function players()
    {
        return $this->belongsToMany(Player::class, 'teams_players')
            ->withTimestamps()
            ->withPivot('created_user', 'updated_user', 'deleted_at')
            ->wherePivot('deleted_at', null);
    }

    /**
     * Pagos del equipo
     */
    public function payments()
    {
        return $this->hasMany(PaymentTeam::class);
    }

    /**
     * Sesiones de entrenamiento del equipo
     */
    public function trainingSessions()
    {
        return $this->hasMany(TrainingSession::class);
    }
}
