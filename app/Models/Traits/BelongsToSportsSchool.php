<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToSportsSchool
{
    /**
     * Boot the trait and add global scope
     */
    protected static function bootBelongsToSportsSchool()
    {
        // Solo aplicar el scope si el usuario está autenticado
        static::addGlobalScope('sports_school', function (Builder $builder) {
            if (auth()->check() && auth()->user()->sports_school_id) {
                $builder->where($builder->getModel()->getTable() . '.sports_school_id', auth()->user()->sports_school_id);
            }
        });
    }

    /**
     * Scope para obtener registros de una escuela específica
     */
    public function scopeForSchool(Builder $query, $schoolId)
    {
        return $query->where($this->getTable() . '.sports_school_id', $schoolId);
    }

    /**
     * Scope para obtener registros sin filtro de escuela (útil para administradores)
     */
    public function scopeWithoutSchoolScope(Builder $query)
    {
        return $query->withoutGlobalScope('sports_school');
    }
}
