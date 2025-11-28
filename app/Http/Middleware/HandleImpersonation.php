<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class HandleImpersonation
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar que la sesión esté disponible
        if (!$request->hasSession()) {
            return $next($request);
        }
        
        // Si hay una suplantación activa, cargar el usuario correcto
        if ($request->session()->has('impersonated_user_id')) {
            $userId = $request->session()->get('impersonated_user_id');
            $user = User::with('sportsSchool')->find($userId);
            
            if ($user) {
                Log::info('HandleImpersonation: Setting user', ['user_id' => $user->id, 'name' => $user->name]);
                Auth::guard('web')->setUser($user);
            }
        }

        return $next($request);
    }
}
