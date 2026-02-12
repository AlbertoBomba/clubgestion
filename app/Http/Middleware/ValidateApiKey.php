<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ValidateApiKey
{
    /**
     * Manejar una petición entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener la API key del header o query parameter
        $apiKey = $request->header('X-API-Key') ?? $request->input('api_key');

        if (empty($apiKey)) {
            return response()->json([
                'error' => 'API key requerida',
                'message' => 'Debe proporcionar una API key válida en el header X-API-Key o como parámetro api_key'
            ], 401);
        }

        // Validar formato de API key
        if (!str_starts_with($apiKey, 'sk_') || strlen($apiKey) !== 63) {
            return response()->json([
                'error' => 'API key inválida',
                'message' => 'El formato de la API key no es válido'
            ], 401);
        }

        // Buscar la escuela en caché primero para optimizar rendimiento
        $cacheKey = 'api_key:' . $apiKey;
        $school = Cache::remember($cacheKey, 300, function () use ($apiKey) {
            return SportsSchool::where('api_key', $apiKey)
                ->where('api_enabled', true)
                ->first();
        });

        if (!$school) {
            Log::warning('Intento de acceso con API key inválida', [
                'api_key' => substr($apiKey, 0, 10) . '...',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'path' => $request->path(),
            ]);

            return response()->json([
                'error' => 'API key no autorizada',
                'message' => 'La API key proporcionada no es válida o ha sido deshabilitada'
            ], 403);
        }

        // Adjuntar la escuela autenticada al request
        $request->attributes->set('authenticated_school', $school);

        // Registrar la petición de forma asíncrona
        dispatch(function () use ($school) {
            $school->logApiRequest();
        })->afterResponse();

        return $next($request);
    }
}
