<?php

namespace App\Services;

use App\Models\SportsSchool;
use Illuminate\Support\Facades\Cache;

class TenantService
{
    protected ?SportsSchool $currentSchool = null;
    protected bool $isInitialized = false;

    /**
     * Establecer la escuela actual
     */
    public function setCurrentSchool(?SportsSchool $school): void
    {
        $this->currentSchool = $school;
        $this->isInitialized = true;

        // Guardar el ID en la sesión si hay una escuela
        if ($school) {
            session(['current_school_id' => $school->id]);
        } else {
            session()->forget('current_school_id');
        }
    }

    /**
     * Obtener la escuela actual
     */
    public function getCurrentSchool(): ?SportsSchool
    {
        if (!$this->isInitialized && session()->has('current_school_id')) {
            $this->currentSchool = SportsSchool::find(session('current_school_id'));
            $this->isInitialized = true;
        }

        return $this->currentSchool;
    }

    /**
     * Obtener el ID de la escuela actual
     */
    public function getCurrentSchoolId(): ?int
    {
        return $this->getCurrentSchool()?->id;
    }

    /**
     * Verificar si hay una escuela activa
     */
    public function hasCurrentSchool(): bool
    {
        return $this->getCurrentSchool() !== null;
    }

    /**
     * Limpiar la escuela actual
     */
    public function clearCurrentSchool(): void
    {
        $this->currentSchool = null;
        $this->isInitialized = false;
        session()->forget('current_school_id');
    }

    /**
     * Ejecutar código en el contexto de una escuela específica
     */
    public function forSchool(?int $schoolId, callable $callback)
    {
        $originalSchool = $this->currentSchool;
        
        if ($schoolId) {
            $school = SportsSchool::find($schoolId);
            $this->setCurrentSchool($school);
        } else {
            $this->setCurrentSchool(null);
        }

        try {
            return $callback();
        } finally {
            $this->setCurrentSchool($originalSchool);
        }
    }

    /**
     * Verificar si el usuario tiene acceso a la escuela actual
     */
    public function userHasAccess($user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        // Master tiene acceso a todo
        if ($user->hasRole('master')) {
            return true;
        }

        // Si hay escuela actual, verificar que el usuario pertenezca a ella
        if ($this->hasCurrentSchool()) {
            return $user->sports_school_id === $this->getCurrentSchoolId();
        }

        return false;
    }

    /**
     * Obtener configuración personalizada de la escuela actual
     */
    public function getConfig(string $key, $default = null)
    {
        $school = $this->getCurrentSchool();

        if (!$school) {
            return $default;
        }

        // Aquí podrías implementar un sistema de configuraciones personalizadas
        // por escuela si lo necesitas en el futuro
        return match($key) {
            'name' => $school->name,
            'logo' => $school->logo,
            'email' => $school->email,
            'phone' => $school->phone,
            'domain' => $school->domain,
            default => $default,
        };
    }
}
