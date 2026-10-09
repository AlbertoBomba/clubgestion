<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PublicMatchController;
use App\Http\Middleware\EnsureMobileToken;
use App\Http\Resources\AuthUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json((new AuthUserResource($request->user()))->resolve())
        ->header('Cache-Control', 'no-store');
})->middleware('auth:sanctum');

Route::prefix('v1/auth')->name('api.auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:mobile-register')->name('register');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:mobile-login')->name('login');

    Route::middleware(['auth:sanctum', EnsureMobileToken::class, 'throttle:mobile-auth'])
        ->group(function () {
            Route::get('/me', [AuthController::class, 'me'])->name('me');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });
});

// Public API v1
Route::prefix('v1/public')
    ->middleware(['throttle:60,1', \App\Http\Middleware\ValidatePublicApiCors::class])
    ->group(function () {
        Route::get('/matches', [PublicMatchController::class, 'index']);
        Route::get('/matches/{id}', [PublicMatchController::class, 'show']);
        Route::get('/teams', [PublicMatchController::class, 'teams']);
    });
