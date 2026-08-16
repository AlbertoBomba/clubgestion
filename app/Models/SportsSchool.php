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
        'province',
        'postal_code',
        'phone',
        'email',
        'domain',
        'contact_person',
        'logo',
        'primary_color',
        'secondary_color',
        'is_active',
        'nif',
        'bank_account',
        'api_key',
        'api_key_generated_at',
        'api_requests_count',
        'last_api_request_at',
        'api_enabled',
        // Mail configuration
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'mail_from_address',
        'mail_from_name',
    ];

    protected $casts = [
        'is_active'            => 'boolean',
        'api_enabled'          => 'boolean',
        'api_key_generated_at' => 'datetime',
        'last_api_request_at'  => 'datetime',
        'mail_port'            => 'integer',
        'mail_password'        => 'encrypted',  // stored encrypted at rest
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

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function memberTypes()
    {
        return $this->hasMany(MemberType::class);
    }

    /**
     * Relación con marcas (many-to-many)
     */
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'sports_schools_brand', 'sports_school_id', 'brand_id');
    }

    /**
     * Generar una nueva API key
     */
    public function generateApiKey(): string
    {
        $apiKey = 'sk_' . bin2hex(random_bytes(30));
        
        $this->update([
            'api_key' => $apiKey,
            'api_key_generated_at' => now(),
            'api_enabled' => true,
        ]);

        return $apiKey;
    }

    /**
     * Regenerar API key existente
     */
    public function regenerateApiKey(): string
    {
        return $this->generateApiKey();
    }

    /**
     * Registrar una petición API
     */
    public function logApiRequest(): void
    {
        $this->increment('api_requests_count');
        $this->update(['last_api_request_at' => now()]);
    }

    /**
     * Verificar si la API está habilitada
     */
    public function isApiEnabled(): bool
    {
        return $this->api_enabled && !empty($this->api_key);
    }

    /**
     * Deshabilitar acceso API
     */
    public function disableApi(): void
    {
        $this->update(['api_enabled' => false]);
    }

    /**
     * Habilitar acceso API
     */
    public function enableApi(): void
    {
        $this->update(['api_enabled' => true]);
    }
}
