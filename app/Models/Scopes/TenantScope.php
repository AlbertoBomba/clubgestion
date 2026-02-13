<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $tenantService = app('tenant');
        
        // Solo aplicar el filtro si hay una escuela actual
        if ($tenantService->hasCurrentSchool()) {
            $builder->where($model->getTable() . '.sports_school_id', $tenantService->getCurrentSchoolId());
        }
    }

    /**
     * Extend the query builder with the needed functions.
     */
    public function extend(Builder $builder): void
    {
        // Método para ignorar el scope de tenant
        $builder->macro('withoutTenant', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });

        // Método para cambiar de tenant temporalmente
        $builder->macro('forSchool', function (Builder $builder, ?int $schoolId) {
            return $builder->withoutGlobalScope($this)
                ->where($builder->getModel()->getTable() . '.sports_school_id', $schoolId);
        });

        // Método para obtener todos los tenants
        $builder->macro('allTenants', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
