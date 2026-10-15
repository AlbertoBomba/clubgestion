<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\IdentifyTenant::class,
            \App\Http\Middleware\HandleImpersonation::class,
        ]);

        // Redsys sends server-to-server POSTs without CSRF token.
        $middleware->validateCsrfTokens(except: [
            'express-pay/redsys/notify',
            'search-pay/redsys/notify',
        ]);

        // Registrar alias para middlewares de API y tenant
        $middleware->alias([
            'api.key' => \App\Http\Middleware\ValidateApiKey::class,
            'api.rate' => \App\Http\Middleware\ApiRateLimiter::class,
            'tenant' => \App\Http\Middleware\IdentifyTenant::class,
            'judge' => \App\Http\Middleware\EnsureJudgeRole::class,
            'redirect.judge' => \App\Http\Middleware\RedirectIfJudge::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            if (! $request->is('historias')) {
                return null;
            }

            Log::warning('Story upload exceeded the PHP POST limit.', [
                'content_length' => $request->server('CONTENT_LENGTH'),
                'post_max_size' => ini_get('post_max_size'),
            ]);
            $message = 'El envío supera el tamaño total permitido por el servidor. No se ha guardado la historia. Vuelve al formulario y selecciona de nuevo los archivos, o contacta con el club si tu vídeo ocupa menos de 50 MB.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 413);
            }

            return response()->view('errors.story-upload-too-large', compact('message'), 413);
        });

        $exceptions->shouldRenderJsonWhen(function (Request $request): bool {
            return $request->is('api/v1/auth/*') || $request->expectsJson();
        });

        $exceptions->respond(function (Response $response): Response {
            if (request()->is('api/v1/auth/*')) {
                $response->headers->set('Cache-Control', 'no-store');
            }

            return $response;
        });

        // Personalizar página 404
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Recurso no encontrado.',
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });
    })->create();
