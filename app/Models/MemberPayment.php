<?php

namespace App\Models;

use App\Enums\MemberPaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_season_id',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'concept',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'due_date'     => 'date',
        'payment_date' => 'date',
        'status'       => MemberPaymentStatus::class,
    ];

    public function memberSeason(): BelongsTo
    {
        return $this->belongsTo(MemberSeason::class);
    }

    public function scopePending(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', MemberPaymentStatus::Pending);
    }

    public function scopeOverdue(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', MemberPaymentStatus::Pending)
                     ->where('due_date', '<', now()->toDateString());
    }

    public function isPaid(): bool
    {
        return $this->status === MemberPaymentStatus::Paid;
    }

    public function isOverdue(): bool
    {
        return $this->status === MemberPaymentStatus::Pending
            && $this->due_date->isPast();
    }
}
