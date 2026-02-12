<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApiRateLimiter
{
    /**
     * Manejar una petición entrante con rate limiting.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener la escuela autenticada del request (establecida por ValidateApiKey)
        $school = $request->attributes->get('authenticated_school');

        if (!$school) {
            return response()->json([
                'error' => 'No autenticado',
                'message' => 'Debe autenticarse primero'
            ], 401);
        }

        // Clave única para el rate limiting por escuela
        $rateLimitKey = 'rate_limit:school:' . $school->id;
        
        // Límite: 100 peticiones por minuto
        $maxAttempts = 100;
        $decayMinutes = 1;

        // Obtener conteo actual de peticiones
        $attempts = Cache::get($rateLimitKey, 0);

        if ($attempts >= $maxAttempts) {
            // Obtener tiempo restante hasta el reset
            $remainingSeconds = Cache::get($rateLimitKey . ':timer', 60);

            Log::warning('Rate limit excedido', [
                'school_id' => $school->id,
                'school_name' => $school->name,
                'attempts' => $attempts,
                'ip' => $request->ip(),
                'path' => $request->path(),
            ]);

            return response()->json([
                'error' => 'Límite de peticiones excedido',
                'message' => 'Ha excedido el límite de ' . $maxAttempts . ' peticiones por minuto',
                'retry_after' => $remainingSeconds
            ], 429)
            ->header('X-RateLimit-Limit', $maxAttempts)
            ->header('X-RateLimit-Remaining', 0)
            ->header('X-RateLimit-Reset', now()->addSeconds($remainingSeconds)->timestamp)
            ->header('Retry-After', $remainingSeconds);
        }

        // Incrementar contador
        if ($attempts === 0) {
            // Primera petición, establecer TTL
            Cache::put($rateLimitKey, 1, $decayMinutes * 60);
            Cache::put($rateLimitKey . ':timer', 60, $decayMinutes * 60);
        } else {
            Cache::increment($rateLimitKey);
        }

        $remaining = max(0, $maxAttempts - ($attempts + 1));

        // Continuar con la petición y añadir headers de rate limit
        $response = $next($request);

        return $response
            ->header('X-RateLimit-Limit', $maxAttempts)
            ->header('X-RateLimit-Remaining', $remaining)
            ->header('X-RateLimit-Reset', now()->addMinutes($decayMinutes)->timestamp);
    }
}
