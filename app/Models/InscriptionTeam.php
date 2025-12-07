<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscriptionTeam extends Model
{
    use SoftDeletes;

    protected $fillable = [
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

    // Relationships
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
}
