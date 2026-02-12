<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleImpersonation::class,
        ]);

        // Registrar alias para middlewares de API
        $middleware->alias([
            'api.key' => \App\Http\Middleware\ValidateApiKey::class,
            'api.rate' => \App\Http\Middleware\ApiRateLimiter::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Personalizar página 404
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Recurso no encontrado.'
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });
    })->create();
