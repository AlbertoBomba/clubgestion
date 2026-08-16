<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureMasterRole;
use App\Http\Middleware\EnsureSchoolUser;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\WebClubs\TenantHomeController;
use App\Livewire\PublicConvocatoria;
use App\Livewire\WebClubs\Home as WebClubsHome;
use App\Livewire\WebClubs\About as WebClubsAbout;
use App\Livewire\WebClubs\Contact as WebClubsContact;
use App\Livewire\WebClubs\PlayerRegistration as WebClubsPlayerRegistration;
use App\Livewire\WebClubs\Tournaments as WebClubsTournaments;
use App\Livewire\WebClubs\TournamentDetail as WebClubsTournamentDetail;
use App\Livewire\WebClubs\TeamLogin as WebClubsTeamLogin;
use App\Livewire\WebClubs\TeamDashboard as WebClubsTeamDashboard;
use App\Livewire\WebClubs\TeamRegister as WebClubsTeamRegister;
use App\Livewire\WebClubs\TeamPlayerRegister as WebClubsTeamPlayerRegister;
use App\Models\SportsSchool;
use App\Models\User;
use App\Models\Category;
use App\Models\Season;
use App\Models\Player;
use App\Models\Section;
use App\Models\Team;
use App\Models\Exercise;
use App\Models\TrainingSession;
use App\Livewire\TrainingSessions\Index as TrainingSessionsIndex;
use App\Livewire\TrainingSessions\Create as TrainingSessionsCreate;
use App\Livewire\TrainingSessions\Edit as TrainingSessionsEdit;
use App\Livewire\Tournaments\TeamPlayers as TournamentTeamPlayers;
use App\Livewire\Tournaments\TeamPlayerForm as TournamentTeamPlayerForm;

// Public routes
Route::get('/convocatoria/{token}', PublicConvocatoria::class)->name('public.convocatoria');

// Ruta principal - usa TenantHomeController que maneja automáticamente tenant vs no-tenant
Route::get('/', [TenantHomeController::class, 'index'])->name('home');

// Vaed Sport - Tienda de ropa deportiva personalizada
Route::get('/vaed-sport', function () {
    return view('vaed-sport-home');
})->name('vaed-sport.home');

// Ruta específica para clubs (tenant)
Route::get('/club', WebClubsHome::class)->name('webclubs.home');

//Ruta para alta de socios MemberRegister pasando el ID del tipo de socio como parámetro
Route::get('/club/inscripcion/{memberTypeId}', App\Livewire\WebClubs\MemberRegister::class)->name('webclubs.member.register');



// Ruta específica para clubs (tenant)
Route::get('/live', App\Livewire\WebClubs\Live::class)->name('webclubs.live');
Route::get('/live/{tournament}', App\Livewire\WebClubs\LiveDetail::class)->name('webclubs.live.detail');

// Tenant Public Routes
Route::get('/sobre-nosotros', WebClubsAbout::class)->name('webclubs.about');
Route::get('/contacto', WebClubsContact::class)->name('webclubs.contact');
Route::get('/inscripcion', WebClubsPlayerRegistration::class)->name('webclubs.registration');
Route::get('/torneos', WebClubsTournaments::class)->name('webclubs.tournaments');
Route::get('/torneos/{tournament}', WebClubsTournamentDetail::class)->name('webclubs.tournament.detail');
Route::get('/torneos/{tournament}/equipo/login', WebClubsTeamLogin::class)->name('webclubs.team.login');
Route::get('/torneos/{tournament}/equipo', WebClubsTeamDashboard::class)->name('webclubs.team.dashboard');
Route::get('/torneos/{tournament}/inscripcion', WebClubsTeamRegister::class)->name('webclubs.team.register');
Route::get('/torneos/{tournament}/jugador/{token}', WebClubsTeamPlayerRegister::class)->name('webclubs.player.register');

// Legal Pages
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms-conditions');
})->name('terms');

Route::get('/cookies', function () {
    return view('cookies');
})->name('cookies');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // Redirigir a árbitros a su dashboard
        if (auth()->user()->hasRole('judge')) {
            return redirect()->route('referee.dashboard');
        }
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

        // Logs de API
        Route::get('/api-logs', function () {
            return view('api-logs.index');
        })->name('api-logs.index');

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

        // Gestión de Tallas
        Route::get('/sizes', function () {
            return view('sizes.index');
        })->name('sizes.index');

        Route::get('/sizes/create', function () {
            return view('sizes.create');
        })->name('sizes.create');

        Route::get('/sizes/{id}/edit', function ($id) {
            return view('sizes.edit', ['id' => $id]);
        })->name('sizes.edit');

        // Gestión de Categorías de Productos
        Route::get('/product-categories', function () {
            return view('product-categories.index');
        })->name('product-categories.index');

        Route::get('/product-categories/create', function () {
            return view('product-categories.create');
        })->name('product-categories.create');

        Route::get('/product-categories/{id}/edit', function ($id) {
            return view('product-categories.edit', ['id' => $id]);
        })->name('product-categories.edit');

        // Gestión de Productos
        Route::get('/products', function () {
            return view('products.index');
        })->name('products.index');

        Route::get('/products/create', function () {
            return view('products.create');
        })->name('products.create');

        Route::get('/products/{id}/edit', function ($id) {
            return view('products.edit', ['id' => $id]);
        })->name('products.edit');

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

        // Gestión de Pagos de Matrículas
        Route::get('/payments-teams', function () {
            return view('payments-teams.index');
        })->name('payments-teams.index');

        // Cartas de pago
        Route::get('/pay-orders', function () {
            return view('pay-orders.index');
        })->name('pay-orders.index');

        Route::get('/pay-orders/{playerId}', function ($playerId) {
            return view('pay-orders.show', compact('playerId'));
        })->name('pay-orders.show');

        Route::get('/pay-orders/download/{paymentId}', function ($paymentId) {
            return app(\App\Livewire\PaymentOrders\Show::class)->downloadPaymentPdf($paymentId);
        })->name('pay-orders.download-pdf');

        Route::get('/pay-orders/receipt/{paymentId}', function ($paymentId) {
            return app(\App\Livewire\PaymentOrders\Show::class)->downloadPaymentReceipt($paymentId);
        })->name('pay-orders.download-receipt');

        // Estadísticas de pagos
        Route::get('/payment-statistics', function () {
            return view('payment-statistics.index');
        })->name('payment-statistics.index');

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

        // Gestión de Ejercicios
        Route::get('/exercises', function () {
            return view('exercises.index');
        })->name('exercises.index');

        Route::get('/exercises/create', function () {
            return view('exercises.create');
        })->name('exercises.create');

        Route::get('/exercises/{exercise}/edit', function (Exercise $exercise) {
            return view('exercises.edit', compact('exercise'));
        })->name('exercises.edit');

        // Gestión de Sesiones de Entrenamiento
        Route::get('/training-sessions', TrainingSessionsIndex::class)
            ->name('training-sessions.index');

        Route::get('/training-sessions/create', TrainingSessionsCreate::class)
            ->name('training-sessions.create');

        Route::get('/training-sessions/{id}/edit', TrainingSessionsEdit::class)
            ->name('training-sessions.edit');

        // Gestión de Tipos de Ejercicios
        Route::get('/exercise-types', function () {
            return view('exercise-types.index');
        })->name('exercise-types.index');

        Route::get('/exercise-types/create', function () {
            return view('exercise-types.create');
        })->name('exercise-types.create');

        Route::get('/exercise-types/{type}/edit', function (App\Models\ExerciseType $type) {
            return view('exercise-types.edit', compact('type'));
        })->name('exercise-types.edit');

        // Gestión de Partidos
        Route::get('/matches', function () {
            return view('matches.index');
        })->name('matches.index');

        Route::get('/matches/create', function () {
            return view('matches.create');
        })->name('matches.create');

        Route::get('/matches/{match}/edit', function (App\Models\SeasonMatch $match) {
            return view('matches.edit', compact('match'));
        })->name('matches.edit');

        // Gestión de Torneos
        Route::get('/tournaments', function () {
            return view('tournaments.index');
        })->name('tournaments.index');

        Route::get('/tournaments/create', function () {
            return view('tournaments.create');
        })->name('tournaments.create');

        Route::get('/tournaments/{tournament}/edit', function (App\Models\Tournament $tournament) {
            return view('tournaments.edit', compact('tournament'));
        })->name('tournaments.edit');

        Route::get('/tournaments/{tournament}', function (App\Models\Tournament $tournament) {
            return view('tournaments.show', compact('tournament'));
        })->name('tournaments.show');

        Route::get('/tournaments/{tournament}/teams/{tournamentTeam}/players/create', TournamentTeamPlayerForm::class)
            ->name('tournament.team.player.create');

        Route::get('/tournaments/{tournament}/teams/{tournamentTeam}/players/{player}/edit', TournamentTeamPlayerForm::class)
            ->name('tournament.team.player.edit');

        Route::get('/tournaments/{tournament}/teams/{tournamentTeam}/players', TournamentTeamPlayers::class)
            ->name('tournament.team.players');

        Route::get('/tournaments/{tournament}/matches/{match}/events', App\Livewire\Tournaments\MatchEvents::class)
            ->name('tournament.match.events');

        Route::get('/tournaments/{tournament}/stats', App\Livewire\Tournaments\TournamentStats::class)
            ->name('tournament.stats');

        // Gestión de Patrocinadores
        Route::get('/sponsors', function () {
            return view('sponsors.index');
        })->name('sponsors.index');

        // Gestión de la portada web (Hero slides)
        Route::get('/web-home-slides/create', function () {
            return view('web-home-slides.create');
        })->name('web-home-slides.create');

        Route::get('/web-home-slides/{slide}/edit', function (App\Models\WebHomeSlide $slide) {
            return view('web-home-slides.edit', compact('slide'));
        })->name('web-home-slides.edit');

        // Configuración de la portada web
        Route::get('/web-home-config', function () {
            return view('web-home-config.edit');
        })->name('web-home-config.edit');

        // ── Gestión de Socios ──────────────────────────────────────────────────

        //  Tarjetas de socio
        Route::get('/member-types', function () {
            return view('member-types.index');
        })->name('member-types.index');

        Route::get('/member-types/create', function () {
            return view('member-types.create');
        })->name('member-types.create');

        Route::get('/member-types/{memberType}/edit', function (App\Models\MemberType $memberType) {
            return view('member-types.edit', compact('memberType'));
        })->name('member-types.edit');

        // Socios
        Route::get('/members', function () {
            return view('members.index');
        })->name('members.index');

        Route::get('/members/create', function () {
            return view('members.create');
        })->name('members.create');

        Route::get('/members/{member}/edit', function (App\Models\Member $member) {
            return view('members.edit', compact('member'));
        })->name('members.edit');
    });

    // Rutas para Árbitros (Judge role)
    Route::middleware([App\Http\Middleware\EnsureJudgeRole::class])->prefix('referee')->name('referee.')->group(function () {
        Route::get('/dashboard', App\Livewire\Referee\Dashboard::class)
            ->name('dashboard');
        
        Route::get('/tournament/{tournament}/matches', App\Livewire\Referee\TournamentMatches::class)
            ->name('tournament.matches');
        
        Route::get('/match/{match}/manage', App\Livewire\Referee\ManageMatch::class)
            ->name('match.manage');
    });
});
