<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfJudge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario autenticado tiene el rol 'judge', redirigirlo a su dashboard
        if (auth()->check() && auth()->user()->hasRole('judge')) {
            // No redirigir peticiones AJAX de Livewire
            if ($request->header('X-Livewire')) {
                return $next($request);
            }
            
            // Si no está intentando acceder a rutas de árbitro, redirigir
            if (!$request->is('referee*')) {
                return redirect()->route('referee.dashboard');
            }
        }

        return $next($request);
    }
}
