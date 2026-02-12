<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTeam extends Model
{
    use SoftDeletes;

    protected $table = 'payments_teams';

    protected $fillable = [
        'team_id',
        'description',
        'amount',
        'price',
        'cuota',
        'date_start',
        'date_end',
        'season_id',
        'sports_school_id',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
        'amount' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    // Relaciones
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
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
     * Pagos de jugadores asociados a esta cuota
     */
    public function paymentPlayers()
    {
        return $this->hasMany(PaymentPlayer::class, 'payment_id');
    }

    /**
     * Verifica si la cuota está en vigor (la fecha actual está entre date_start y date_end)
     */
    public function isActive()
    {
        $now = now()->startOfDay();
        return $now->between($this->date_start, $this->date_end);
    }

    /**
     * Verifica si la cuota ya ha vencido
     */
    public function hasExpired()
    {
        return now()->startOfDay()->greaterThan($this->date_end);
    }

    /**
     * Verifica si tiene pagos realizados por jugadores
     */
    public function hasPaidPayments()
    {
        return $this->paymentPlayers()->where('state', 1)->exists();
    }

    /**
     * Verifica si la cuota puede ser eliminada
     */
    public function canBeDeleted()
    {
        // Solo se puede borrar si no está en vigor o ya venció
        $canDeleteByDate = !$this->isActive() || $this->hasExpired();
        
        // Y no tiene pagos realizados
        $hasNoPaidPayments = !$this->hasPaidPayments();
        
        return $canDeleteByDate && $hasNoPaidPayments;
    }

    /**
     * Verifica si la cuota puede ser editada
     * Solo se puede editar si aún no ha comenzado
     */
    public function canBeEdited()
    {
        $now = now()->startOfDay();
        // Se puede editar si la fecha actual es anterior a date_start
        return $now->lessThan($this->date_start);
    }
}
