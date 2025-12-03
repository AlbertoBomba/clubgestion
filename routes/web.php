<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureMasterRole;
use App\Http\Middleware\EnsureSchoolUser;
use App\Http\Controllers\ImpersonateController;
use App\Models\SportsSchool;
use App\Models\User;
use App\Models\Category;
use App\Models\Season;
use App\Models\Player;
use App\Models\Section;
use App\Models\Team;

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

        // Gestión de Secciones
        Route::get('/sections', function () {
            return view('sections.index');
        })->name('sections.index');

        Route::get('/sections/create', function () {
            return view('sections.create');
        })->name('sections.create');

        Route::get('/sections/{section}/edit', function (Section $section) {
            return view('sections.edit', compact('section'));
        })->name('sections.edit');

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

        // Gestión de Temporadas
        Route::get('/seasons', function () {
            return view('seasons.index');
        })->name('seasons.index');

        Route::get('/seasons/create', function () {
            return view('seasons.create');
        })->name('seasons.create');

        Route::get('/seasons/{season}/edit', function (Season $season) {
            return view('seasons.edit', compact('season'));
        })->name('seasons.edit');

        // Gestión de Jugadores
        Route::get('/players', function () {
            return view('players.index');
        })->name('players.index');

        Route::get('/players/create', function () {
            return view('players.create');
        })->name('players.create');

        Route::get('/players/{player}/edit', function (Player $player) {
            return view('players.edit', compact('player'));
        })->name('players.edit');

        // Gestión de Equipos
        Route::get('/teams', function () {
            return view('teams.index');
        })->name('teams.index');

        Route::get('/teams/{team}/edit', function (Team $team) {
            return view('teams.edit', compact('team'));
        })->name('teams.edit');

        // Gestión de Campos de Entrenamiento
        Route::get('/training-fields', function () {
            return view('training-fields.index');
        })->name('training-fields.index');

        // Gestión de Horarios de Entrenamiento
        Route::get('/training-schedule', function () {
            return view('training-schedule.index');
        })->name('training-schedule.index');

        // Vista visual de Horarios de Entrenamiento
        Route::get('/training-schedule/view', function () {
            return view('training-schedule.view');
        })->name('training-schedule.view');
    });
});
