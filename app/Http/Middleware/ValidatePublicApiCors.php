<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Cache;

class ValidatePublicApiCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get allowed origins from database (cached)
        $allowedOrigins = Cache::remember('api_allowed_origins', 3600, function () {
            return SportsSchool::whereNotNull('domain')
                ->where('is_active', true)
                ->pluck('domain')
                ->map(function ($domain) {
                    // Clean domain
                    $domain = preg_replace('/^www\./', '', $domain);
                    // Return both http and https versions
                    return [
                        'https://' . $domain,
                        'https://www.' . $domain,
                        'http://' . $domain,
                        'http://www.' . $domain,
                    ];
                })
                ->flatten()
                ->unique()
                ->values()
                ->toArray();
        });
        
        // Add localhost for development
        if (config('app.env') === 'local') {
            $allowedOrigins = array_merge($allowedOrigins, [
                'http://localhost',
                'http://localhost:3000',
                'http://localhost:8000',
                'http://127.0.0.1',
                'http://127.0.0.1:8000',
            ]);
        }
        
        $origin = $request->headers->get('Origin');
        
        // Handle preflight requests
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', $origin && in_array($origin, $allowedOrigins) ? $origin : '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                ->header('Access-Control-Max-Age', '86400');
        }
        
        $response = $next($request);
        
        // Add CORS headers to response
        if ($origin && in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        } else {
            // Allow all origins for public API (pero validamos en el controlador)
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
        }
        
        return $response;
    }
}
