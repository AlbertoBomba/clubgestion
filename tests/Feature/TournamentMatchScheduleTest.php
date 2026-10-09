<?php

namespace Tests\Feature;

use App\Livewire\Tournaments\Show;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class TournamentMatchScheduleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'schedule_tests',
            'database.connections.schedule_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('name');
            $table->string('team_type');
            $table->date('start_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('tournament_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->integer('order')->default(1);
        });
        Schema::create('tournament_phases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('tournament_category_id')->nullable();
            $table->unsignedBigInteger('phase_id')->nullable();
            $table->integer('round')->nullable();
            $table->integer('match_number')->nullable();
            $table->unsignedBigInteger('home_team_id')->nullable();
            $table->unsignedBigInteger('away_team_id')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('scheduled');
            $table->integer('home_score')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->actingAs((new User)->forceFill(['id' => 7, 'sports_school_id' => 1]));
    }

    protected function tearDown(): void
    {
        DB::purge('schedule_tests');
        parent::tearDown();
    }

    private function scheduleComponent(string $teamType = 'open'): Show
    {
        $component = new Show;
        $component->tournament = Tournament::create([
            'sports_school_id' => 1,
            'name' => 'Torneo',
            'team_type' => $teamType,
            'start_date' => '2026-10-05',
        ]);
        $component->openScheduleModal();

        return $component;
    }

    private function match(Show $component, array $attributes = []): TournamentMatch
    {
        return $component->tournament->matches()->create(array_merge([
            'round' => 1,
            'match_number' => 1,
        ], $attributes));
    }

    public function test_assigns_all_phases_in_list_order_not_creation_or_date_order(): void
    {
        $component = $this->scheduleComponent();
        $phaseOne = DB::table('tournament_phases')->insertGetId(['tournament_id' => $component->tournament->id, 'name' => 'Liga']);
        $phaseTwo = DB::table('tournament_phases')->insertGetId(['tournament_id' => $component->tournament->id, 'name' => 'Final']);
        $last = $this->match($component, ['phase_id' => $phaseTwo, 'scheduled_at' => '2026-10-01 08:00']);
        $third = $this->match($component, ['phase_id' => $phaseOne, 'round' => 2, 'scheduled_at' => '2026-10-01 07:00']);
        $second = $this->match($component, ['phase_id' => $phaseOne, 'match_number' => 2]);
        $first = $this->match($component, ['phase_id' => $phaseOne, 'status' => 'completed', 'home_score' => 3, 'notes' => 'Conservar']);
        $deleted = $this->match($component);
        $deleted->delete();
        $other = $this->match($this->scheduleComponent());

        $component->assignMatchSchedule();

        foreach ([$first, $second, $third, $last] as $index => $match) {
            $this->assertSame(['09:00', '09:25', '09:50', '10:15'][$index], $match->refresh()->scheduled_at->format('H:i'));
            $this->assertSame('2026-10-05', $match->scheduled_at->format('Y-m-d'));
            $this->assertEquals(7, $match->updated_user);
        }
        $this->assertSame('completed', $first->status);
        $this->assertEquals(3, $first->home_score);
        $this->assertSame('Conservar', $first->notes);
        $this->assertNull($deleted->refresh()->scheduled_at);
        $this->assertNull($other->refresh()->scheduled_at);
        $this->assertFalse($component->showScheduleModal);
        $this->assertSame('Horarios asignados a 4 partidos en el orden del listado.', session('message'));
    }

    public function test_schedule_ties_follow_existing_time_then_id_and_remain_stable(): void
    {
        $component = $this->scheduleComponent();
        $late = $this->match($component, ['scheduled_at' => '2026-10-05 12:00']);
        $early = $this->match($component, ['scheduled_at' => '2026-10-05 08:00']);
        $unscheduled = $this->match($component);
        $anotherUnscheduled = $this->match($component);
        $component->assignMatchSchedule();
        $component->assignMatchSchedule();

        foreach ([$unscheduled, $anotherUnscheduled, $early, $late] as $index => $match) {
            $this->assertSame(['09:00', '09:25', '09:50', '10:15'][$index], $match->refresh()->scheduled_at->format('H:i'));
        }
    }

    public function test_category_tournaments_only_assign_matches_in_the_visible_category(): void
    {
        $component = $this->scheduleComponent('school');
        $category = DB::table('tournament_categories')->insertGetId(['tournament_id' => $component->tournament->id]);
        $component->activeCategoryId = $category;
        $visible = $this->match($component, ['tournament_category_id' => $category]);
        $hidden = $this->match($component);
        $component->assignMatchSchedule();

        $this->assertSame('09:00', $visible->refresh()->scheduled_at->format('H:i'));
        $this->assertNull($hidden->refresh()->scheduled_at);
    }

    public function test_midnight_rollover_and_zero_rest(): void
    {
        $component = $this->scheduleComponent();
        $component->schedule_time = '23:50';
        $component->schedule_break = '0';
        $first = $this->match($component);
        $second = $this->match($component, ['match_number' => 2]);
        $component->assignMatchSchedule();

        $this->assertSame('2026-10-05 23:50', $first->refresh()->scheduled_at->format('Y-m-d H:i'));
        $this->assertSame('2026-10-06 00:10', $second->refresh()->scheduled_at->format('Y-m-d H:i'));
    }

    public function test_invalid_inputs_do_not_change_existing_times(): void
    {
        $component = $this->scheduleComponent();
        $match = $this->match($component, ['scheduled_at' => '2026-10-05 08:00']);
        foreach ([
            ['schedule_date', ''],
            ['schedule_date', '2026-02-30'],
            ['schedule_time', '25:00'],
            ['schedule_duration', '0'],
            ['schedule_duration', '1.5'],
            ['schedule_duration', '1441'],
            ['schedule_parts', ''],
            ['schedule_parts', '0'],
            ['schedule_parts', '3'],
            ['schedule_parts', '1.5'],
            ['schedule_break', '-1'],
            ['schedule_break', 'abc'],
            ['schedule_fields', ''],
            ['schedule_fields', '0'],
            ['schedule_fields', '1.5'],
            ['schedule_fields', '51'],
        ] as [$field, $value]) {
            $previous = $component->{$field};
            $component->{$field} = $value;
            try {
                $component->assignMatchSchedule();
                $this->fail('Invalid input must be rejected.');
            } catch (ValidationException $exception) {
                $this->assertArrayHasKey($field, $exception->errors());
            }
            $component->{$field} = $previous;
            $this->assertSame('08:00', $match->refresh()->scheduled_at->format('H:i'));
            $this->assertTrue($component->showScheduleModal);
        }
    }

    public function test_empty_list_shows_error_instead_of_success(): void
    {
        $component = $this->scheduleComponent();
        $component->assignMatchSchedule();

        $this->assertTrue($component->showScheduleModal);
        $this->assertTrue($component->getErrorBag()->has('schedule_time'));
        $this->assertNull(session('message'));
    }

    public function test_other_club_cannot_assign_times(): void
    {
        $component = $this->scheduleComponent();
        $component->tournament->sports_school_id = 2;
        $this->expectException(HttpException::class);
        $component->assignMatchSchedule();
    }

    public function test_category_from_another_tournament_is_rejected(): void
    {
        $component = $this->scheduleComponent('school');
        $other = $this->scheduleComponent('school');
        $component->activeCategoryId = DB::table('tournament_categories')->insertGetId([
            'tournament_id' => $other->tournament->id,
        ]);

        $this->expectException(HttpException::class);
        $component->assignMatchSchedule();
    }

    public function test_update_failure_rolls_back_the_entire_batch(): void
    {
        $component = $this->scheduleComponent();
        $first = $this->match($component);
        $second = $this->match($component, ['match_number' => 2]);
        DB::unprepared("CREATE TRIGGER fail_schedule BEFORE UPDATE ON tournament_matches WHEN NEW.id = {$second->id} BEGIN SELECT RAISE(ABORT, 'schedule failure'); END");
        try {
            $component->assignMatchSchedule();
            $this->fail('The database failure must be surfaced.');
        } catch (QueryException $exception) {
            $this->assertStringContainsString('schedule failure', $exception->getMessage());
        }
        $this->assertNull($first->refresh()->scheduled_at);
        $this->assertNull($second->refresh()->scheduled_at);
        $this->assertTrue($component->showScheduleModal);
    }

    public function test_shared_modal_renders_inputs_and_overwrite_warning(): void
    {
        $component = $this->scheduleComponent();
        $data = get_object_vars($component);
        $data['errors'] = new \Illuminate\Support\ViewErrorBag;
        $html = view('livewire.tournaments._schedule-modal', $data)->render();

        $this->assertStringContainsString('wire:submit="assignMatchSchedule"', $html);
        foreach (['schedule_date', 'schedule_time', 'schedule_duration', 'schedule_parts', 'schedule_break', 'schedule_fields'] as $field) {
            $this->assertStringContainsString('wire:model="'.$field.'"', $html);
        }
        $this->assertStringContainsString('Se sustituirán las fechas y horas existentes.', $html);
        $this->assertStringContainsString('Dos partes', $html);
        $this->assertStringContainsString('Duración de cada parte', $html);
        $this->assertStringContainsString('09:00, 09:50, 10:40', $html);
        foreach (['date', 'time', 'parts', 'duration', 'break', 'fields'] as $field) {
            $this->assertStringContainsString('aria-describedby="schedule-'.$field.'-help"', $html);
            $this->assertStringContainsString('id="schedule-'.$field.'-help"', $html);
        }
        $this->assertStringContainsString('Número de partidos que pueden jugarse a la vez.', $html);
        $this->assertStringContainsString('Dos partes de 20 minutos suman 40 minutos de juego.', $html);
        $this->assertStringContainsString('Usa 0 si no hay descanso.', $html);
    }

    public function test_two_parts_apply_rest_between_parts_and_between_matches(): void
    {
        $component = $this->scheduleComponent();
        $component->schedule_parts = '2';
        $matches = [
            $this->match($component),
            $this->match($component, ['match_number' => 2]),
            $this->match($component, ['match_number' => 3]),
        ];

        $component->assignMatchSchedule();

        foreach ($matches as $index => $match) {
            $this->assertSame(['09:00', '09:50', '10:40'][$index], $match->refresh()->scheduled_at->format('H:i'));
        }
    }

    public function test_two_parts_with_no_rest_continue_after_midnight(): void
    {
        $component = $this->scheduleComponent();
        $component->schedule_parts = '2';
        $component->schedule_time = '23:50';
        $component->schedule_break = '0';
        $first = $this->match($component);
        $second = $this->match($component, ['match_number' => 2]);

        $component->assignMatchSchedule();

        $this->assertSame('2026-10-05 23:50', $first->refresh()->scheduled_at->format('Y-m-d H:i'));
        $this->assertSame('2026-10-06 00:30', $second->refresh()->scheduled_at->format('Y-m-d H:i'));
    }

    public function test_reopening_modal_resets_number_of_parts(): void
    {
        $component = $this->scheduleComponent();
        $component->schedule_parts = '2';
        $component->schedule_fields = '3';
        $component->openScheduleModal();

        $this->assertSame('1', $component->schedule_parts);
        $this->assertSame('1', $component->schedule_fields);
    }

    public function test_multiple_fields_share_start_time_in_list_order(): void
    {
        $component = $this->scheduleComponent();
        $component->schedule_fields = '2';
        $component->schedule_time = '09:20';
        $component->schedule_duration = '15';
        $component->schedule_parts = '2';
        $matches = [];
        foreach (range(1, 5) as $number) {
            $matches[] = $this->match($component, ['match_number' => $number]);
        }

        $component->assignMatchSchedule();

        foreach ($matches as $index => $match) {
            $this->assertSame(['09:20', '09:20', '10:00', '10:00', '10:40'][$index], $match->refresh()->scheduled_at->format('H:i'));
            $this->assertSame(['Campo 1', 'Campo 2', 'Campo 1', 'Campo 2', 'Campo 1'][$index], $match->location);
        }
    }

    public function test_single_field_keeps_existing_location(): void
    {
        $component = $this->scheduleComponent();
        $match = $this->match($component, ['location' => 'Polideportivo']);

        $component->assignMatchSchedule();

        $this->assertSame('Polideportivo', $match->refresh()->location);
    }

    public function test_match_location_is_visible_in_both_match_lists(): void
    {
        $component = $this->scheduleComponent();
        $component->tournament->status = 'draft';
        $data = get_object_vars($component);
        foreach ([
            'categories', 'phases', 'teams', 'standings', 'schoolTeams',
            'schoolCategories', 'goalsForModal', 'gmCardsForModal', 'gmTeamPlayers',
            'gmMatchTeams', 'gmAllPlayers', 'availableReferees', 'assignedReferees',
            'bracketData', 'bracketModalTeams', 'bracketModalStandings', 'recentTeams',
        ] as $name) {
            $data[$name] = collect();
        }
        $data['matches'] = collect([$this->match($component, ['location' => 'Campo 2'])]);
        $data += [
            'activeCategory' => null,
            'goalsModalMatch' => null,
            'hasLeaguePhase' => false,
            'hasKnockoutPhase' => false,
            'leagueSubsetSettings' => [],
            'errors' => new \Illuminate\Support\ViewErrorBag,
        ];
        $this->assertStringContainsString('<span class="truncate">Campo 2</span>', view('livewire.tournaments.show', $data)->render());
        $this->assertStringContainsString('📍 Campo 2', view('livewire.tournaments.show_mobile', $data)->render());
    }

    public function test_schedule_button_and_modal_are_available_in_both_views(): void
    {
        $component = $this->scheduleComponent();
        $component->tournament->status = 'draft';
        $data = get_object_vars($component);
        foreach ([
            'categories', 'phases', 'teams', 'standings', 'schoolTeams',
            'schoolCategories', 'goalsForModal', 'gmCardsForModal', 'gmTeamPlayers',
            'gmMatchTeams', 'gmAllPlayers', 'availableReferees', 'assignedReferees',
            'bracketData', 'bracketModalTeams', 'bracketModalStandings', 'recentTeams',
        ] as $name) {
            $data[$name] = collect();
        }
        $data['matches'] = collect([$this->match($component)]);
        $data += [
            'activeCategory' => null,
            'goalsModalMatch' => null,
            'hasLeaguePhase' => false,
            'hasKnockoutPhase' => false,
            'leagueSubsetSettings' => [],
            'errors' => new \Illuminate\Support\ViewErrorBag,
        ];
        foreach (['show', 'show_mobile'] as $view) {
            $html = view('livewire.tournaments.'.$view, $data)->render();
            $this->assertSame(1, substr_count($html, 'wire:click="openScheduleModal"'));
            $this->assertSame(1, substr_count($html, 'wire:submit="assignMatchSchedule"'));
            $this->assertSame(1, substr_count($html, 'wire:click="exportQrPdf"'));
        }
    }
}
