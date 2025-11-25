<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureMasterRole;
use App\Http\Middleware\EnsureSchoolUser;
use App\Http\Controllers\ImpersonateController;
use App\Models\SportsSchool;
use App\Models\User;
use App\Models\Category;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas del Back 1 - Solo para usuario Master
    Route::middleware([EnsureMasterRole::class])->group(function () {
        // Gestión de Escuelas Deportivas
        Route::get('/sports-schools', function () {
            return view('sports-schools.index');
        })->name('sports-schools.index');

        Route::get('/sports-schools/create', function () {
            return view('sports-schools.create');
        })->name('sports-schools.create');

        Route::get('/sports-schools/{school}/edit', function (SportsSchool $school) {
            return view('sports-schools.edit', compact('school'));
        })->name('sports-schools.edit');

        // Gestión de Usuarios de Escuelas
        Route::get('/school-users', function () {
            return view('school-users.index');
        })->name('school-users.index');

        Route::get('/school-users/create', function () {
            return view('school-users.create');
        })->name('school-users.create');

        Route::get('/school-users/{user}/edit', function (User $user) {
            return view('school-users.edit', compact('user'));
        })->name('school-users.edit');

        // Suplantación de identidad
        Route::post('/impersonate/{user}', [ImpersonateController::class, 'impersonate'])->name('impersonate');
    });

    // Ruta para salir de la suplantación (disponible para todos los autenticados)
    Route::post('/leave-impersonation', [ImpersonateController::class, 'leaveImpersonation'])->name('leave-impersonation');

    // Rutas del Back 2 - Para usuarios de escuela
    Route::middleware([EnsureSchoolUser::class])->group(function () {
        // Gestión de Usuarios
        Route::get('/my-school-users', function () {
            return view('school-users.index');
        })->name('my-school-users.index');

        Route::get('/my-school-users/create', function () {
            return view('school-users.create');
        })->name('my-school-users.create');

        Route::get('/my-school-users/{user}/edit', function (User $user) {
            return view('school-users.edit', compact('user'));
        })->name('my-school-users.edit');

        // Gestión de Categorías
        Route::get('/categories', function () {
            return view('categories.index');
        })->name('categories.index');

        Route::get('/categories/create', function () {
            return view('categories.create');
        })->name('categories.create');

        Route::get('/categories/{category}/edit', function (Category $category) {
            return view('categories.edit', compact('category'));
        })->name('categories.edit');
    });
});
