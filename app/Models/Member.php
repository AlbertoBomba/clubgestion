<?php

namespace App\Models;

use App\Models\Traits\BelongsToSportsSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable; 

class Member extends Model
{
    use HasFactory, SoftDeletes, BelongsToSportsSchool, Notifiable;

    protected $fillable = [
        'sports_school_id',
        'user_id',
        'member_number',
        'name',
        'surname',
        'dni',
        'email',
        'phone',
        'birth_date',
        'address',
        'photo',
        'active',
        'town',
        'zip',
        'province',
        'bank_account',
        'bank_account_holder',
        'sepa_mandate_ref',
        'sepa_mandate_date',
        'sepa_mandate_ip',

    ];

    protected $casts = [
        'birth_date' => 'date',
        'active'     => 'boolean',
        'sepa_mandate_date' => 'datetime',
    ];

    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function memberSeasons(): HasMany
    {
        return $this->hasMany(MemberSeason::class);
    }

    public function currentSeason(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MemberSeason::class)->latestOfMany();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('active', true);
    }
}
