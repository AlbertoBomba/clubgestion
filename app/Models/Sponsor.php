<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sports_school_id',
        'season_id',
        'name',
        'logo',
        'web',
        'published',
        'order',
        'created_user',
        'updated_user',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'published' => 'boolean',
        'order' => 'integer',
    ];

    // Relaciones
    public function sportsSchool()
    {
        return $this->belongsTo(SportsSchool::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user');
    }

    // Scopes
    public function scopeBySchool($query, $schoolId)
    {
        return $query->where('sports_school_id', $schoolId);
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeBySeason($query, $seasonId)
    {
        return $query->where('season_id', $seasonId);
    }
}
