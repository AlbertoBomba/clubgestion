<?php

namespace App\Models;

use App\Enums\MemberPeriodicity;
use App\Models\Traits\BelongsToSportsSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberType extends Model
{
    use HasFactory, SoftDeletes, BelongsToSportsSchool;

    protected $fillable = [
        'sports_school_id',
        'season_id',
        'name',
        'description',
        'price',
        'periodicity',
        'card_template',
        'active',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'active'      => 'boolean',
        'periodicity' => MemberPeriodicity::class,
    ];

    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function memberSeasons(): HasMany
    {
        return $this->hasMany(MemberSeason::class);
    }

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('active', true);
    }
}
