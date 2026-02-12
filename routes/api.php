<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PublicMatchController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API v1
Route::prefix('v1/public')
    ->middleware(['throttle:60,1', \App\Http\Middleware\ValidatePublicApiCors::class])
    ->group(function () {
        Route::get('/matches', [PublicMatchController::class, 'index']);
        Route::get('/matches/{id}', [PublicMatchController::class, 'show']);
        Route::get('/teams', [PublicMatchController::class, 'teams']);
    });
