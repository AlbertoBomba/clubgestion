<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SportsSchool;
use App\Services\TenantService;

class IdentifyTenant
{
    protected TenantService $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        
        // Buscar la escuela por dominio completo o subdominio
        $school = $this->identifySchoolByDomain($host);
        
        if ($school) {
            $this->tenantService->setCurrentSchool($school);
            
            // Opcional: Compartir con las vistas
            view()->share('currentSchool', $school);
        }

        return $next($request);
    }

    /**
     * Identificar la escuela según el dominio
     */
    protected function identifySchoolByDomain(string $host): ?SportsSchool
    {
        // 1. Buscar por dominio completo (ej: www.clubdeportivo.com)
        $school = SportsSchool::where('domain', $host)
            ->where('is_active', true)
            ->first();

        if ($school) {
            return $school;
        }

        // 2. Buscar sin www
        $hostWithoutWww = preg_replace('/^www\./', '', $host);
        $school = SportsSchool::where('domain', $hostWithoutWww)
            ->where('is_active', true)
            ->first();

        if ($school) {
            return $school;
        }

        // 3. Buscar por subdominio (ej: equipo.vaed.es)
        if (preg_match('/^(.+?)\.vaed\.es$/', $host, $matches)) {
            $subdomain = $matches[1];
            
            $school = SportsSchool::where('is_active', true)
                ->where(function($query) use ($subdomain, $host) {
                    $query->where('slug', $subdomain)
                          ->orWhere('domain', $host);
                })
                ->first();

            if ($school) {
                return $school;
            }
        }

        // 4. Si es el dominio principal (vaed.es), no hay tenant específico
        // Esto permitirá acceso a panel administrativo master
        if (in_array($host, ['vaed.es', 'www.vaed.es', 'localhost', '127.0.0.1'])) {
            return null;
        }

        return null;
    }
}
