<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class EnsureMobileToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        if (! $request->bearerToken() || ! $token instanceof PersonalAccessToken) {
            return response()->json([
                'message' => 'Se requiere un token Bearer.',
                'code' => 'unauthenticated',
            ], 401)->header('Cache-Control', 'no-store');
        }

        if (! $user->is_active) {
            $token->delete();

            return response()->json([
                'message' => 'La cuenta está desactivada.',
                'code' => 'account_inactive',
            ], 403)->header('Cache-Control', 'no-store');
        }

        if ($user->hasEnabledTwoFactorAuthentication()) {
            $token->delete();

            return response()->json([
                'message' => 'Esta cuenta requiere doble factor. Utiliza el acceso web.',
                'code' => 'two_factor_required',
            ], 403)->header('Cache-Control', 'no-store');
        }

        if (! $token->can('mobile:profile')) {
            return response()->json([
                'message' => 'El token no permite acceder a la API móvil.',
                'code' => 'token_forbidden',
            ], 403)->header('Cache-Control', 'no-store');
        }

        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store');

        return $response;
    }
}
