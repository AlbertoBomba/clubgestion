<?php

namespace App\Models\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\SportsSchool;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    /**
     * Boot del trait
     */
    public static function bootBelongsToTenant(): void
    {
        // Aplicar scope global automáticamente
        static::addGlobalScope(new TenantScope());

        // Auto-asignar sports_school_id al crear
        static::creating(function ($model) {
            if (!$model->sports_school_id && tenantService()->hasCurrentSchool()) {
                $model->sports_school_id = tenantService()->getCurrentSchoolId();
            }
        });
    }

    /**
     * Relación con SportsSchool
     */
    public function sportsSchool(): BelongsTo
    {
        return $this->belongsTo(SportsSchool::class);
    }

    /**
     * Scope para filtrar por escuela
     */
    public function scopeForSchool($query, ?int $schoolId)
    {
        if ($schoolId) {
            return $query->where('sports_school_id', $schoolId);
        }
        
        return $query;
    }

    /**
     * Scope para la escuela actual
     */
    public function scopeForCurrentSchool($query)
    {
        return $query->forSchool(tenantService()->getCurrentSchoolId());
    }

    /**
     * Verificar si pertenece a la escuela actual
     */
    public function belongsToCurrentSchool(): bool
    {
        return $this->sports_school_id === tenantService()->getCurrentSchoolId();
    }
}
