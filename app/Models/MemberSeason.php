<?php

namespace App\Models;

use App\Enums\MemberPaymentStatus;
use App\Enums\MemberSeasonStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberSeason extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'season_id',
        'member_type_id',
        'join_date',
        'leave_date',
        'price',
        'payment_status',
        'status',
        'observations',
    ];

    protected $casts = [
        'join_date'      => 'date',
        'leave_date'     => 'date',
        'price'          => 'decimal:2',
        'payment_status' => MemberPaymentStatus::class,
        'status'         => MemberSeasonStatus::class,
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function memberType(): BelongsTo
    {
        return $this->belongsTo(MemberType::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(MemberPayment::class);
    }

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', MemberSeasonStatus::Active);
    }

    public function scopePendingPayment(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('payment_status', MemberPaymentStatus::Pending);
    }
}
