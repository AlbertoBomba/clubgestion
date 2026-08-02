<?php

namespace App\Models;

use App\Models\Traits\BelongsToSportsSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes, BelongsToSportsSchool;

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
    ];

    protected $casts = [
        'birth_date' => 'date',
        'active'     => 'boolean',
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
