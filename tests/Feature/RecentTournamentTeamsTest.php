<?php

namespace Tests\Feature;

use App\Livewire\Tournaments\Show;
use App\Models\Tournament;
use App\Models\TournamentTeam;
use App\Models\User;
use App\Services\RecentTournamentTeams;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RecentTournamentTeamsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'recent_team_tests',
            'database.connections.recent_team_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        $this->travelTo(now()->setDate(2026, 10, 5)->startOfDay());
        Storage::fake('public');

        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('name');
            $table->string('team_type')->default('open');
            $table->string('status')->default('completed');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('tournament_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('tournament_category_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->boolean('external_team')->default(true);
            foreach (['name_override', 'logo', 'contact_name', 'contact_phone', 'email', 'password', 'status', 'group_label', 'notes', 'registration_token'] as $column) {
                $table->string($column)->nullable();
            }
            $table->integer('seed')->nullable();
            $table->timestamps();
        });
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team');
            $table->string('logo')->nullable();
            $table->softDeletes();
        });
        Schema::create('tournament_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('order')->default(1);
        });
    }

    protected function tearDown(): void
    {
        DB::purge('recent_team_tests');
        $this->travelBack();
        parent::tearDown();
    }

    private function tournament(array $attributes = []): Tournament
    {
        $tournament = Tournament::create(array_merge([
            'sports_school_id' => 1,
            'name' => 'Torneo reciente',
            'team_type' => 'open',
            'status' => 'completed',
            'start_date' => '2026-09-20',
        ], $attributes));
        if (array_key_exists('created_at', $attributes)) {
            $tournament->forceFill(['created_at' => $attributes['created_at']])->save();
        }

        return $tournament;
    }

    private function team(Tournament $tournament, array $attributes = []): TournamentTeam
    {
        return $tournament->tournamentTeams()->create(array_merge([
            'name_override' => 'Equipo visitante',
            'external_team' => true,
            'email' => 'equipo@example.test',
            'password' => Hash::make('secret-password'),
            'status' => 'eliminated',
            'contact_name' => 'Contacto',
            'contact_phone' => '600000000',
            'seed' => 3,
            'group_label' => 'A',
            'notes' => 'Datos del equipo',
            'registration_token' => 'OLDTOKEN1234',
        ], $attributes));
    }

    public function test_recent_list_uses_tournament_creation_dates_and_club_scope(): void
    {
        $destination = $this->tournament(['start_date' => '2026-11-01']);
        $boundary = $this->team($this->tournament(['created_at' => '2026-09-05 00:00:00']), ['created_at' => '2020-01-01']);
        $upcoming = $this->team($this->tournament(['start_date' => '2026-11-01', 'status' => 'draft']));
        $undated = $this->team($this->tournament(['start_date' => null]));
        $this->team($this->tournament(['created_at' => '2026-09-04 23:59:59']));
        $this->team($this->tournament(['created_at' => '2026-10-06 00:00:00']));
        $this->team($this->tournament(['sports_school_id' => 2]));
        $this->team($this->tournament(['status' => 'cancelled']));
        $deleted = $this->tournament();
        $this->team($deleted);
        $deleted->delete();
        $this->team($destination);

        $ids = app(RecentTournamentTeams::class)->query($destination)->pluck('id')->all();
        $this->assertEqualsCanonicalizing([$boundary->id, $upcoming->id, $undated->id], $ids);
    }

    public function test_empty_destination_lists_and_imports_team_from_recent_upcoming_tournament(): void
    {
        $source = $this->team($this->tournament([
            'start_date' => '2026-11-15',
            'status' => 'registration_open',
            'created_at' => '2026-10-01 12:00:00',
        ]));
        $destination = $this->tournament(['start_date' => '2026-12-01', 'status' => 'draft']);
        $service = app(RecentTournamentTeams::class);
        $this->assertSame(0, $destination->tournamentTeams()->count());
        $this->assertSame([$source->id], $service->available($destination, null)->pluck('id')->all());
        $copy = $service->import($destination, null, $source->id);
        $this->assertSame($destination->id, $copy->tournament_id);
        $this->assertNull($copy->group_label);
    }

    public function test_import_preserves_data_and_password_but_resets_group_status_and_token(): void
    {
        $source = $this->team($this->tournament(), ['logo' => 'original.png']);
        Storage::disk('public')->put('original.png', 'logo contents');
        $destination = $this->tournament();
        $copy = app(RecentTournamentTeams::class)->import($destination, null, $source->id);

        foreach (['name_override', 'external_team', 'contact_name', 'contact_phone', 'email', 'password', 'seed', 'notes'] as $field) {
            $this->assertSame($source->{$field}, $copy->{$field});
        }
        $this->assertTrue(Hash::check('secret-password', $copy->password));
        $this->assertNull($copy->group_label);
        $this->assertNull($copy->registration_token);
        $this->assertSame('registered', $copy->status);
        $this->assertSame($destination->id, $copy->tournament_id);
        $this->assertNull($copy->tournament_category_id);
        $this->assertNotSame($source->logo, $copy->logo);
        $this->assertSame('logo contents', Storage::disk('public')->get($copy->logo));
        Storage::disk('public')->delete($copy->logo);
        Storage::disk('public')->assertExists('original.png');
        // No player or history tables exist: importing must not query or copy them.
        $this->assertSame(2, TournamentTeam::count());
    }

    public function test_list_deduplicates_recent_teams_and_excludes_already_registered_teams(): void
    {
        $old = $this->team($this->tournament());
        $latest = $this->team($this->tournament());
        $destination = $this->tournament();
        $service = app(RecentTournamentTeams::class);
        $this->assertSame([$latest->id], $service->available($destination, null)->pluck('id')->all());

        $service->import($destination, null, $latest->id);
        $this->assertCount(0, $service->available($destination, null));
        $this->expectException(ValidationException::class);
        $service->import($destination, null, $old->id);
    }

    public function test_import_rejects_other_clubs_even_with_a_direct_source_id(): void
    {
        $source = $this->team($this->tournament(['sports_school_id' => 2]));
        $this->expectException(ModelNotFoundException::class);
        app(RecentTournamentTeams::class)->import($this->tournament(), null, $source->id);
    }

    public function test_school_team_conversion_to_open_tournament_keeps_name_and_copies_school_logo(): void
    {
        DB::table('teams')->insert(['id' => 7, 'team' => 'Equipo escuela', 'logo' => 'school.png']);
        Storage::disk('public')->put('school.png', 'school logo');
        $source = $this->team($this->tournament(['team_type' => 'school']), [
            'team_id' => 7, 'external_team' => false, 'name_override' => null,
        ]);
        $destination = $this->tournament();
        $copy = app(RecentTournamentTeams::class)->import($destination, null, $source->id);
        $this->assertTrue($copy->external_team);
        $this->assertNull($copy->team_id);
        $this->assertSame('Equipo escuela', $copy->name_override);
        $this->assertSame('school logo', Storage::disk('public')->get($copy->logo));
        $this->assertCount(0, app(RecentTournamentTeams::class)->available($destination, null));
    }

    public function test_destination_category_and_component_modal_flow(): void
    {
        $source = $this->team($this->tournament());
        $destination = $this->tournament(['team_type' => 'school']);
        DB::table('tournament_categories')->insert(['id' => 5, 'tournament_id' => $destination->id]);
        $user = new User;
        $user->id = 1;
        $user->sports_school_id = 1;
        $this->actingAs($user);
        $component = new Show;
        $component->tournament = $destination;
        $component->activeCategoryId = 5;
        $component->openCreateTeamModal();
        $this->assertTrue($component->showTeamModal);
        $this->assertSame('new', $component->teamCreationMode);
        $component->teamCreationMode = 'recent';
        $component->addRecentTeam($source->id);
        $this->assertTrue($component->showTeamModal);
        $copy = $destination->tournamentTeams()->firstOrFail();
        $this->assertSame(5, $copy->tournament_category_id);
        $this->assertNull($copy->group_label);
    }

    public function test_duplicate_checks_are_scoped_to_the_destination_category(): void
    {
        $source = $this->team($this->tournament());
        $destination = $this->tournament(['team_type' => 'school']);
        $service = app(RecentTournamentTeams::class);
        $service->import($destination, 5, $source->id);
        $this->assertCount(0, $service->available($destination, 5));
        $this->assertCount(1, $service->available($destination, 6));
        $copy = $service->import($destination, 6, $source->id);
        $this->assertSame(6, $copy->tournament_category_id);
    }

    public function test_missing_logo_fails_explicitly_without_creating_a_team(): void
    {
        $source = $this->team($this->tournament(), ['logo' => 'missing.png']);
        $destination = $this->tournament();
        try {
            app(RecentTournamentTeams::class)->import($destination, null, $source->id);
            $this->fail('A missing logo must not be silently ignored.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('recentTeam', $exception->errors());
        }
        $this->assertSame(0, $destination->tournamentTeams()->count());
    }

    public function test_recent_list_renders_shared_choices_without_exposing_credentials(): void
    {
        $source = $this->team($this->tournament());
        $destination = $this->tournament();
        $html = view('livewire.tournaments._recent-teams', [
            'editingTeamId' => null,
            'teamCreationMode' => 'recent',
            'selectedRecentTeamIds' => [],
            'recentTeams' => app(RecentTournamentTeams::class)->available($destination, null),
            'errors' => new \Illuminate\Support\ViewErrorBag,
        ])->render();
        $this->assertStringContainsString('Crear desde cero', $html);
        $this->assertStringContainsString('Equipos recientes', $html);
        $this->assertStringNotContainsString('wire:click="addSelectedRecentTeams"', $html);
        $this->assertStringContainsString('value="'.$source->id.'"', $html);
        $this->assertStringNotContainsString($source->password, $html);
        $this->assertStringNotContainsString($source->registration_token, $html);
    }

    public function test_recent_team_choices_are_wired_into_both_tournament_views(): void
    {
        $source = $this->team($this->tournament());
        $this->team($source->tournament, ['name_override' => 'Segundo equipo']);
        $this->team($source->tournament, ['name_override' => 'Tercer equipo']);
        $destination = $this->tournament();
        $component = new Show;
        $component->tournament = $destination;
        $component->showTeamModal = true;
        $component->teamCreationMode = 'recent';
        $data = get_object_vars($component);
        foreach ([
            'categories', 'phases', 'teams', 'matches', 'standings', 'schoolTeams',
            'schoolCategories', 'goalsForModal', 'gmCardsForModal', 'gmTeamPlayers',
            'gmMatchTeams', 'gmAllPlayers', 'availableReferees', 'assignedReferees',
            'bracketData', 'bracketModalTeams', 'bracketModalStandings',
        ] as $name) {
            $data[$name] = collect();
        }
        $data += [
            'activeCategory' => null,
            'goalsModalMatch' => null,
            'hasLeaguePhase' => false,
            'hasKnockoutPhase' => false,
            'leagueSubsetSettings' => [],
            'errors' => new \Illuminate\Support\ViewErrorBag,
        ];
        $data['recentTeams'] = app(RecentTournamentTeams::class)->available($destination, null);
        foreach (['show', 'show_mobile'] as $view) {
            $html = view('livewire.tournaments.'.$view, $data)->render();
            $this->assertSame(1, substr_count($html, 'wire:click="addSelectedRecentTeams"'));
            $this->assertMatchesRegularExpression(
                '/<div[^>]*data-team-modal-footer[^>]*>.*?wire:click="addSelectedRecentTeams".*?<\/div>/s',
                $html
            );
            $this->assertSame(3, substr_count($html, 'wire:model.live="selectedRecentTeamIds"'));
            $this->assertStringNotContainsString('wire:click="saveTeam"', $html);
            $data['teamCreationMode'] = 'new';
            $html = view('livewire.tournaments.'.$view, $data)->render();
            $this->assertStringContainsString('wire:click="saveTeam"', $html);
            $this->assertStringNotContainsString('wire:click="addSelectedRecentTeams"', $html);
            $data['teamCreationMode'] = 'recent';
        }
    }

    public function test_creating_a_team_from_scratch_still_works(): void
    {
        $component = new Show;
        $component->tournament = $this->tournament();
        $component->openCreateTeamModal();
        $component->name_override = 'Nuevo equipo';
        $component->team_email = 'nuevo@example.test';
        $component->team_password = 'password-nuevo';
        $component->saveTeam();
        $team = $component->tournament->tournamentTeams()->firstOrFail();
        $this->assertSame('Nuevo equipo', $team->name_override);
        $this->assertTrue(Hash::check('password-nuevo', $team->password));
        $this->assertFalse($component->showTeamModal);
    }

    public function test_multiple_teams_are_added_and_modal_stays_open_for_more(): void
    {
        $sourceTournament = $this->tournament();
        $first = $this->team($sourceTournament);
        $second = $this->team($sourceTournament, ['name_override' => 'Segundo equipo']);
        $third = $this->team($sourceTournament, ['name_override' => 'Tercer equipo']);
        $user = new User;
        $user->id = 1;
        $user->sports_school_id = 1;
        $this->actingAs($user);
        $component = new Show;
        $component->tournament = $this->tournament();
        $component->openCreateTeamModal();
        $component->teamCreationMode = 'recent';
        $component->selectedRecentTeamIds = [(string) $first->id, (string) $second->id];
        $component->addSelectedRecentTeams();

        $this->assertTrue($component->showTeamModal);
        $this->assertSame([], $component->selectedRecentTeamIds);
        $this->assertSame(2, $component->tournament->tournamentTeams()->count());
        $this->assertSame(0, $component->tournament->tournamentTeams()->whereNotNull('group_label')->count());
        $this->assertSame([$third->id], app(RecentTournamentTeams::class)->available($component->tournament, null)->pluck('id')->all());
        $component->selectedRecentTeamIds = [$third->id];
        $component->addSelectedRecentTeams();
        $this->assertSame(3, $component->tournament->tournamentTeams()->count());
        $this->assertTrue($component->showTeamModal);
    }

    public function test_failed_batch_rolls_back_teams_and_copied_logos(): void
    {
        $first = $this->team($this->tournament(), ['logo' => 'original.png']);
        Storage::disk('public')->put('original.png', 'original logo');
        $second = $this->team($this->tournament(), ['name_override' => 'Second', 'logo' => 'missing.png']);
        $destination = $this->tournament();
        try {
            app(RecentTournamentTeams::class)->importMany($destination, null, [$first->id, $second->id]);
            $this->fail('Batch should fail when a selected logo is missing.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('recentTeam', $exception->errors());
        }
        $this->assertSame(0, $destination->tournamentTeams()->count());
        $this->assertSame(['original.png'], Storage::disk('public')->allFiles());
    }

    public function test_empty_selection_reports_validation_error(): void
    {
        $user = new User;
        $user->id = 1;
        $user->sports_school_id = 1;
        $this->actingAs($user);
        $component = new Show;
        $component->tournament = $this->tournament();
        $component->openCreateTeamModal();
        $this->expectException(ValidationException::class);
        $component->addSelectedRecentTeams();
    }
}
