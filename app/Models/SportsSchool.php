<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class SportsSchool extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'city',
        'postal_code',
        'phone',
        'email',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Boot method para generar slug automáticamente
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($school) {
            if (empty($school->slug)) {
                $school->slug = Str::slug($school->name);
            }
        });
        
        static::updating(function ($school) {
            if ($school->isDirty('name') && empty($school->slug)) {
                $school->slug = Str::slug($school->name);
            }
        });
    }

    /**
     * Relación con usuarios
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtener solo usuarios activos
     */
    public function activeUsers()
    {
        return $this->hasMany(User::class)->where('is_active', true);
    }

    /**
     * Obtener administradores de la escuela
     */
    public function admins()
    {
        return $this->hasMany(User::class)->where('role', 'school_admin');
    }

    /**
     * Obtener entrenadores de la escuela
     */
    public function coaches()
    {
        return $this->hasMany(User::class)->where('role', 'coach');
    }

    /**
     * Obtener estudiantes de la escuela
     */
    public function students()
    {
        return $this->hasMany(User::class)->where('role', 'student');
    }
}
