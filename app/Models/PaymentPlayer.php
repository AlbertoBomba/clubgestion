<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentPlayer extends Model
{
    use SoftDeletes;

    protected $table = 'payments_players';

    protected $fillable = [
        'player_id',
        'payment_id',
        'sports_school_id',
        'code',
        'state',
        'cuota',
        'price',
        'amount',
        'amount_original',
        'descEnt',
        'descPerc',
        'payment_date',
        'payment_order',
        'payment_auth',
        'payment_type',
        'dtnotification',
        'notification',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'dtnotification' => 'datetime',
        'price' => 'decimal:2',
        'amount' => 'decimal:2',
        'amount_original' => 'decimal:2',
        'descEnt' => 'decimal:2',
        'descPerc' => 'decimal:2',
        'state' => 'integer',
        'notification' => 'integer',
    ];

    /**
     * Relación con el jugador
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Relación con el pago del equipo
     */
    public function paymentTeam(): BelongsTo
    {
        return $this->belongsTo(PaymentTeam::class, 'payment_id');
    }

    /**
     * Relación con la escuela deportiva
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Usuario que creó el registro
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    /**
     * Usuario que actualizó el registro
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    /**
     * Scope para pagos pendientes
     */
    public function scopePending($query)
    {
        return $query->where('state', 0);
    }

    /**
     * Scope para pagos realizados
     */
    public function scopePaid($query)
    {
        return $query->where('state', 1);
    }

    /**
     * Scope para pagos cancelados
     */
    public function scopeCancelled($query)
    {
        return $query->where('state', 2);
    }
}
