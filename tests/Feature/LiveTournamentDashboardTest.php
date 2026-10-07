<?php

namespace Tests\Feature;

use App\Livewire\WebClubs\LiveDetail;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentTeam;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LiveTournamentDashboardTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'live_dashboard_tests',
            'database.connections.live_dashboard_tests' => [
                'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
            ],
        ]);

        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->integer('sports_school_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->integer('sports_school_id');
            $table->integer('season_id');
            $table->integer('type_id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->boolean('published')->default(true);
            $table->integer('order')->default(0);
            $table->softDeletes();
        });
        Schema::create('tournament_phases', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id');
            $table->string('name');
            $table->string('type');
            $table->integer('order')->default(1);
            $table->text('settings')->nullable();
            $table->softDeletes();
        });
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id')->default(1);
            foreach (['phase_id', 'round', 'home_team_id', 'away_team_id', 'home_score', 'away_score'] as $column) {
                $table->integer($column)->nullable();
            }
            $table->string('status');
            $table->text('settings')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('played_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team');
            $table->string('team_image')->nullable();
            $table->softDeletes();
        });
        Schema::create('tournament_teams', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id')->default(1);
            $table->integer('team_id')->nullable();
            $table->integer('seed')->default(1);
            $table->string('name_override');
            $table->string('logo')->nullable();
        });
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_team_id');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('photo')->nullable();
            $table->integer('dorsal')->nullable();
            $table->string('status')->default('approved');
        });
        Schema::create('tournament_standings', function (Blueprint $table) {
            $table->id();
            $table->integer('tournament_id')->default(1);
            $table->integer('tournament_team_id')->nullable();
            $table->integer('phase_id')->nullable();
            $table->string('group_label')->nullable();
            foreach (['position', 'points', 'goals_for', 'goals_against', 'played', 'won', 'drawn', 'lost'] as $column) {
                $table->integer($column)->default(0);
            }
        });
        foreach (['tournament_match_goals', 'tournament_match_cards'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->integer('tournament_match_id');
                $table->integer('tournament_player_id')->nullable();
                $table->integer('tournament_team_id')->nullable();
                $table->string('goal_type')->nullable();
            });
        }
        DB::table('tournament_teams')->insert(['id' => 1, 'name_override' => 'Equipo local']);
    }

    protected function tearDown(): void
    {
        DB::purge('live_dashboard_tests');
        parent::tearDown();
    }

    private function dashboard(?LiveDetail $component = null, ?int $schoolId = null): array
    {
        $component ??= new LiveDetail;
        $component->tournament = (new Tournament)->forceFill([
            'id' => 1, 'name' => 'Torneo de prueba', 'sports_school_id' => $schoolId,
        ]);
        $data = $component->render()->getData();
        $html = view('livewire.webclubs.live-detail', array_merge(get_object_vars($component), $data))->render();

        return [$data, $html];
    }

    public function test_sponsor_footer_only_includes_published_large_logos_from_the_current_school_season(): void
    {
        DB::table('seasons')->insert([
            ['id' => 1, 'sports_school_id' => 1, 'start_date' => now()->subDay(), 'end_date' => now()->addDay()],
            ['id' => 2, 'sports_school_id' => 1, 'start_date' => now()->subYear(), 'end_date' => now()->subMonth()],
            ['id' => 3, 'sports_school_id' => 2, 'start_date' => now()->subDay(), 'end_date' => now()->addDay()],
        ]);
        foreach ([
            [1, 1, 1, 1, true, 'very-large.png', 2, null],
            [2, 1, 1, 2, true, 'large.png', 1, null],
            [3, 1, 1, 3, true, 'medium.png', 0, null],
            [4, 1, 1, 4, true, 'small.png', 0, null],
            [5, 1, 1, 5, true, 'residual.png', 0, null],
            [6, 1, 1, 1, false, 'unpublished.png', 0, null],
            [7, 1, 2, 1, true, 'old-season.png', 0, null],
            [8, 2, 3, 1, true, 'other-school.png', 0, null],
            [9, 1, 1, 1, true, null, 0, null],
            [10, 1, 1, 2, true, '', 0, null],
            [11, 1, 1, 1, true, 'deleted.png', 0, now()],
        ] as [$id, $schoolId, $seasonId, $typeId, $published, $logo, $order, $deletedAt]) {
            DB::table('sponsors')->insert([
                'id' => $id, 'sports_school_id' => $schoolId, 'season_id' => $seasonId,
                'type_id' => $typeId, 'published' => $published, 'logo' => $logo,
                'order' => $order, 'name' => 'Sponsor '.$id, 'deleted_at' => $deletedAt,
            ]);
        }
        $component = new LiveDetail;
        [$data, $html] = $this->dashboard($component, 1);

        $this->assertSame([2, 1], $data['liveSponsors']->pluck('id')->all());
        $this->assertStringContainsString('live-screen--with-sponsors', $html);
        $this->assertStringContainsString('<footer class="live-sponsors"', $html);
        $this->assertStringContainsString('wire:ignore x-data="liveSponsorCarousel(2)"', $html);
        $this->assertSame(2, substr_count($html, 'alt="Sponsor 1"'));
        $this->assertSame(2, substr_count($html, 'alt="Sponsor 2"'));
        $this->assertStringNotContainsString('alt="Sponsor 8"', $html);
        $this->assertStringNotContainsString('alt="Sponsor 6"', $html);

        preg_match('/wire:key="(live-sponsors-[^"]+)"/', $html, $initialKey);
        DB::table('sponsors')->where('id', 1)->update(['logo' => 'updated.png']);
        [, $html] = $this->dashboard($component, 1);
        preg_match('/wire:key="(live-sponsors-[^"]+)"/', $html, $updatedKey);
        $this->assertNotSame($initialKey[1], $updatedKey[1]);
        $this->assertStringContainsString('updated.png', $html);

        DB::table('sponsors')->whereIn('id', [1, 2])->update(['published' => false]);
        [$data, $html] = $this->dashboard($component, 1);
        $this->assertTrue($data['liveSponsors']->isEmpty());
        $this->assertStringNotContainsString('<footer class="live-sponsors"', $html);
        $this->assertStringNotContainsString('class="live-screen live-screen--with-sponsors"', $html);
    }

    public function test_sponsor_footer_is_absent_without_a_current_season(): void
    {
        [$data, $html] = $this->dashboard(null, 1);

        $this->assertTrue($data['liveSponsors']->isEmpty());
        $this->assertStringNotContainsString('<footer class="live-sponsors"', $html);
    }

    public function test_desktop_bracket_waits_for_every_first_round_team_and_refreshes_automatically(): void
    {
        DB::table('tournament_phases')->insert([
            'id' => 1, 'tournament_id' => 1, 'name' => 'Eliminatorias', 'type' => 'knockout',
        ]);
        DB::table('tournament_teams')->insert(['id' => 2, 'name_override' => 'Equipo visitante']);
        DB::table('tournament_standings')->insert(['tournament_team_id' => 1]);
        $component = new LiveDetail;

        [$data, $html] = $this->dashboard($component);
        $this->assertSame([], $data['desktopBracketPhaseIds']);
        $this->assertStringContainsString('class="public-bracket public-bracket--desktop-hidden"', $html);
        $this->assertStringNotContainsString('class="live-col live-col--classification live-col--bracket-ready"', $html);
        $this->assertStringContainsString('class="live-panel-controls"', $html);
        $this->assertStringContainsString("x-show=\"panel === 'standings'\"", $html);
        $this->assertStringContainsString("x-show=\"panel === 'bracket'\"", $html);

        DB::table('tournament_matches')->insert([
            ['id' => 1, 'phase_id' => 1, 'round' => 2, 'status' => 'scheduled'],
            ['id' => 2, 'phase_id' => 1, 'round' => 2, 'status' => 'scheduled'],
            ['id' => 3, 'phase_id' => 1, 'round' => 3, 'status' => 'scheduled'],
        ]);
        [$data] = $this->dashboard($component);
        $this->assertSame([], $data['desktopBracketPhaseIds']);

        DB::table('tournament_matches')->where('id', 3)->update(['home_team_id' => 1, 'away_team_id' => 2]);
        [$data] = $this->dashboard($component);
        $this->assertSame([], $data['desktopBracketPhaseIds']);

        DB::table('tournament_matches')->where('id', 1)->update(['home_team_id' => 1, 'away_team_id' => 2]);
        DB::table('tournament_matches')->where('id', 2)->update(['home_team_id' => 1]);
        [$data] = $this->dashboard($component);
        $this->assertSame([], $data['desktopBracketPhaseIds']);

        DB::table('tournament_matches')->where('id', 3)->update(['home_team_id' => null, 'away_team_id' => null]);
        DB::table('tournament_matches')->where('id', 2)->update(['away_team_id' => 2]);
        [$data, $html] = $this->dashboard($component);
        $this->assertSame([1], $data['desktopBracketPhaseIds']);
        $this->assertStringContainsString('class="live-col live-col--classification live-col--bracket-ready"', $html);
        $this->assertStringContainsString('class="public-bracket"', $html);
        $this->assertStringContainsString('wire:key="public-bracket-match-3"', $html);
        $this->assertStringContainsString('Por definir', $html);
        $this->assertStringContainsString('wire:poll.5s', $html);
        $this->assertStringContainsString('class="live-panel-controls"', $html);

        DB::table('tournament_matches')->where('id', 2)->update(['away_team_id' => null]);
        [$data, $html] = $this->dashboard($component);
        $this->assertSame([], $data['desktopBracketPhaseIds']);
        $this->assertStringNotContainsString('class="live-col live-col--classification live-col--bracket-ready"', $html);
    }

    public function test_desktop_bracket_includes_third_place_when_it_exists_without_waiting_for_its_teams(): void
    {
        DB::table('tournament_phases')->insert([
            'id' => 1, 'tournament_id' => 1, 'name' => 'Eliminatorias', 'type' => 'knockout',
        ]);
        DB::table('tournament_teams')->insert(['id' => 2, 'name_override' => 'Equipo visitante']);
        foreach ([1, 2] as $id) {
            DB::table('tournament_matches')->insert([
                'id' => $id, 'phase_id' => 1, 'round' => 1, 'status' => 'scheduled',
                'home_team_id' => 1, 'away_team_id' => 2,
            ]);
        }
        DB::table('tournament_matches')->insert([
            'id' => 3, 'phase_id' => 1, 'round' => 2, 'status' => 'scheduled',
        ]);
        $component = new LiveDetail;
        [, $html] = $this->dashboard($component);
        $this->assertStringNotContainsString('<h4>Tercer puesto</h4>', $html);

        DB::table('tournament_matches')->insert([
            'id' => 4, 'phase_id' => 1, 'round' => 1, 'status' => 'scheduled',
            'settings' => json_encode(['is_third_place' => true]),
        ]);
        [$data, $html] = $this->dashboard($component);

        $this->assertSame([1], $data['desktopBracketPhaseIds']);
        $this->assertSame([1, 2], $data['bracketData'][1]['rounds'][1]->pluck('id')->all());
        $this->assertSame(4, $data['bracketData'][1]['thirdPlace']->id);
        $this->assertStringContainsString('class="live-col live-col--classification live-col--bracket-ready"', $html);
        $this->assertMatchesRegularExpression(
            '/class="public-bracket-third">\s*<h4>Tercer puesto<\/h4>\s*<div class="public-bracket-card" wire:key="public-bracket-match-4"/',
            $html,
        );
        $this->assertSame(1, substr_count($html, 'wire:key="public-bracket-match-4"'));

        DB::table('tournament_matches')->where('id', 4)->update([
            'home_team_id' => 1, 'away_team_id' => 2,
            'status' => 'completed', 'home_score' => 2, 'away_score' => 1,
        ]);
        [$data] = $this->dashboard($component);
        $thirdPlaceHtml = view('livewire.webclubs._tournament-bracket-match', [
            'match' => $data['bracketData'][1]['thirdPlace'],
        ])->render();
        $this->assertStringContainsString('Equipo local', $thirdPlaceHtml);
        $this->assertStringContainsString('Equipo visitante', $thirdPlaceHtml);
        $this->assertStringContainsString('public-bracket-winner', $thirdPlaceHtml);
        $this->assertMatchesRegularExpression('/<strong[^>]*>\s*2\s*/', $thirdPlaceHtml);

        DB::table('tournament_matches')->where('id', 4)->update(['deleted_at' => now()]);
        [$data, $html] = $this->dashboard($component);
        $this->assertNull($data['bracketData'][1]['thirdPlace']);
        $this->assertStringNotContainsString('<h4>Tercer puesto</h4>', $html);
    }

    public function test_desktop_only_shows_ready_knockout_phases(): void
    {
        DB::table('tournament_phases')->insert([
            ['id' => 1, 'tournament_id' => 1, 'name' => 'Fase lista', 'type' => 'double_elimination'],
            ['id' => 2, 'tournament_id' => 1, 'name' => 'Fase pendiente', 'type' => 'knockout'],
            ['id' => 3, 'tournament_id' => 1, 'name' => 'Liga', 'type' => 'league'],
            ['id' => 4, 'tournament_id' => 2, 'name' => 'Otro torneo', 'type' => 'knockout'],
        ]);
        DB::table('tournament_teams')->insert(['id' => 2, 'name_override' => 'Equipo visitante']);
        DB::table('tournament_matches')->insert([
            ['id' => 1, 'phase_id' => 1, 'round' => 1, 'status' => 'scheduled', 'home_team_id' => 1, 'away_team_id' => 2],
            ['id' => 2, 'phase_id' => 2, 'round' => 1, 'status' => 'scheduled', 'home_team_id' => 1, 'away_team_id' => null],
            ['id' => 3, 'phase_id' => 3, 'round' => 1, 'status' => 'scheduled', 'home_team_id' => 1, 'away_team_id' => 2],
            ['id' => 4, 'phase_id' => 4, 'round' => 1, 'status' => 'scheduled', 'home_team_id' => 1, 'away_team_id' => 2],
        ]);
        [$data, $html] = $this->dashboard();

        $this->assertSame([1], $data['desktopBracketPhaseIds']);
        $this->assertStringContainsString('class="public-bracket" wire:key="public-bracket-1"', $html);
        $this->assertStringContainsString('class="public-bracket public-bracket--desktop-hidden" wire:key="public-bracket-2"', $html);
        $this->assertStringNotContainsString('wire:key="public-bracket-3"', $html);
        $this->assertStringNotContainsString('wire:key="public-bracket-4"', $html);
    }

    public function test_live_bracket_cards_show_team_logos_with_club_fallback(): void
    {
        config(['filesystems.disks.public.url' => 'https://public.example.test/storage']);
        DB::table('teams')->insert([
            'id' => 1, 'team' => 'Club', 'team_image' => 'teams/club.png',
        ]);
        DB::table('tournament_teams')->where('id', 1)->update(['logo' => 'teams/local.png']);
        DB::table('tournament_teams')->insert([
            'id' => 2, 'name_override' => 'Visitante', 'team_id' => 1,
        ]);
        DB::table('tournament_phases')->insert([
            'id' => 1, 'tournament_id' => 1, 'name' => 'Final', 'type' => 'knockout',
        ]);
        DB::table('tournament_matches')->insert([
            'id' => 1, 'phase_id' => 1, 'round' => 1, 'status' => 'scheduled',
            'home_team_id' => 1, 'away_team_id' => 2,
        ]);
        [$data, $html] = $this->dashboard();

        $this->assertSame(2, substr_count($html, 'class="public-bracket-logo"'));
        $this->assertStringContainsString('src="https://public.example.test/storage/teams/local.png"', $html);
        $this->assertStringContainsString('src="https://public.example.test/storage/teams/club.png"', $html);
        $publicHtml = view('livewire.webclubs._tournament-bracket', [
            'bracketData' => $data['bracketData'],
        ])->render();
        $this->assertStringNotContainsString('class="public-bracket-logo"', $publicHtml);

        DB::table('tournament_teams')->where('id', 1)->update(['logo' => null]);
        DB::table('tournament_matches')->where('id', 1)->update(['away_team_id' => null]);
        [, $html] = $this->dashboard();
        $this->assertStringNotContainsString('class="public-bracket-logo"', $html);
        $this->assertStringContainsString('Por definir', $html);
    }

    public function test_empty_dashboard_keeps_all_match_sections_but_hides_scorers(): void
    {
        [$data, $html] = $this->dashboard();

        $this->assertFalse($data['hasPlayers']);
        $this->assertStringNotContainsString('Máximos Goleadores', $html);
        $this->assertStringContainsString('No hay partidos en juego', $html);
        $this->assertStringContainsString('No hay partidos finalizados aún', $html);
        $this->assertStringContainsString('No hay próximos partidos programados', $html);
    }

    public function test_goal_notifications_include_team_data_without_a_player(): void
    {
        config(['filesystems.disks.public.url' => 'https://public.example.test/storage']);
        DB::table('teams')->insert([
            'id' => 1, 'team' => 'Equipo del club', 'team_image' => 'teams/club.png',
        ]);
        DB::table('tournament_teams')->where('id', 1)->update([
            'logo' => 'teams/local.png', 'team_id' => 1,
        ]);
        DB::table('tournament_matches')->insert(['id' => 1, 'status' => 'in_progress']);
        DB::table('tournament_match_goals')->insert([
            'tournament_match_id' => 1, 'tournament_team_id' => 1, 'goal_type' => 'normal',
        ]);

        $component = new LiveDetail;
        $component->tournament = (new Tournament)->forceFill(['id' => 1]);
        $component->render();
        $event = \Livewire\store($component)->get('dispatched')[0]->serialize();
        $payload = $event['params'][0];

        $this->assertSame('live-event-notification', $event['name']);
        $this->assertNull($payload['player_name']);
        $this->assertNull($payload['player_photo']);
        $this->assertSame('Equipo local', $payload['team_name']);
        $this->assertSame('https://public.example.test/storage/teams/local.png', $payload['team_logo']);

        $component->render();
        $this->assertCount(1, \Livewire\store($component)->get('dispatched'));
    }

    public function test_goal_without_players_uses_the_linked_club_team_image(): void
    {
        config(['filesystems.disks.public.url' => 'https://public.example.test/storage']);
        DB::table('teams')->insert([
            'id' => 1, 'team' => 'Equipo del club', 'team_image' => 'teams/club.png',
        ]);
        DB::table('tournament_teams')->where('id', 1)->update(['team_id' => 1]);
        DB::table('tournament_matches')->insert(['id' => 1, 'status' => 'in_progress']);
        DB::table('tournament_match_goals')->insert([
            'tournament_match_id' => 1, 'tournament_team_id' => 1, 'goal_type' => 'normal',
        ]);

        $component = new LiveDetail;
        $component->tournament = (new Tournament)->forceFill(['id' => 1]);
        $component->render();
        $payload = \Livewire\store($component)->get('dispatched')[0]->serialize()['params'][0];

        $this->assertNull($payload['player_name']);
        $this->assertSame('Equipo local', $payload['team_name']);
        $this->assertSame('https://public.example.test/storage/teams/club.png', $payload['team_logo']);
    }

    public function test_goal_notifications_preserve_player_data_and_allow_teams_without_logos(): void
    {
        DB::table('tournament_matches')->insert(['id' => 1, 'status' => 'in_progress']);
        DB::table('tournament_players')->insert([
            'id' => 1, 'tournament_team_id' => 1, 'name' => 'Jugador',
            'surname' => 'Local', 'photo' => 'players/local.png',
        ]);
        DB::table('tournament_match_goals')->insert([
            'tournament_match_id' => 1, 'tournament_team_id' => 1,
            'tournament_player_id' => 1, 'goal_type' => 'normal',
        ]);

        $component = new LiveDetail;
        $component->tournament = (new Tournament)->forceFill(['id' => 1]);
        $component->render();
        $payload = \Livewire\store($component)->get('dispatched')[0]->serialize()['params'][0];

        $this->assertSame('Jugador Local', $payload['player_name']);
        $this->assertSame(Storage::url('players/local.png'), $payload['player_photo']);
        $this->assertSame('Equipo local', $payload['team_name']);
        $this->assertNull($payload['team_logo']);
    }

    public function test_only_three_scorers_are_shown_alongside_live_and_recent_matches(): void
    {
        DB::table('tournament_matches')->insert(['id' => 1, 'status' => 'in_progress']);
        for ($player = 1; $player <= 4; $player++) {
            DB::table('tournament_players')->insert([
                'id' => $player, 'tournament_team_id' => 1, 'name' => 'Goleador '.$player,
            ]);
            for ($goal = 0; $goal < $player; $goal++) {
                DB::table('tournament_match_goals')->insert([
                    'tournament_match_id' => 1, 'tournament_player_id' => $player,
                    'tournament_team_id' => 1, 'goal_type' => 'goal',
                ]);
            }
        }
        DB::table('tournament_match_goals')->insert([
            'tournament_match_id' => 1, 'tournament_player_id' => 1,
            'tournament_team_id' => 1, 'goal_type' => 'own_goal',
        ]);
        DB::table('tournament_match_goals')->insert([
            'tournament_match_id' => 1, 'tournament_player_id' => null,
            'tournament_team_id' => 1, 'goal_type' => 'goal',
        ]);
        [$data, $html] = $this->dashboard();

        $this->assertTrue($data['hasPlayers']);
        $this->assertSame([4, 3, 2], $data['topScorers']->pluck('player.id')->all());
        $this->assertSame([4, 3, 2], $data['topScorers']->pluck('goals')->all());
        $this->assertSame(3, substr_count($html, 'wire:key="scorer-'));
        $this->assertStringNotContainsString('Goleador 1', $html);
        $this->assertStringContainsString('wire:key="live-match-1"', $html);
        $this->assertStringContainsString('Últimos resultados', $html);
        $this->assertStringContainsString('Próximos partidos', $html);
    }

    public function test_players_without_goals_show_an_empty_scorer_section(): void
    {
        DB::table('tournament_players')->insert([
            'tournament_team_id' => 1, 'name' => 'Jugador', 'status' => 'pending',
        ]);
        [$data, $html] = $this->dashboard();

        $this->assertTrue($data['hasPlayers']);
        $this->assertStringContainsString('Máximos Goleadores', $html);
        $this->assertStringContainsString('Sin goleadores registrados aún', $html);
    }

    public function test_standings_show_team_logos_before_names_with_club_image_fallback(): void
    {
        config(['filesystems.disks.public.url' => 'https://public.example.test/storage']);
        DB::table('teams')->insert([
            'id' => 1, 'team' => 'Equipo del club', 'team_image' => 'teams/club.png',
        ]);
        DB::table('tournament_teams')->where('id', 1)->update([
            'logo' => 'teams/local.png', 'team_id' => 1,
        ]);
        DB::table('tournament_teams')->insert([
            ['id' => 2, 'name_override' => 'Equipo vinculado', 'team_id' => 1],
            ['id' => 3, 'name_override' => 'Equipo sin escudo', 'team_id' => null],
        ]);
        foreach ([1, 2, 3] as $teamId) {
            DB::table('tournament_standings')->insert([
                'tournament_team_id' => $teamId, 'position' => $teamId,
            ]);
        }

        [, $html] = $this->dashboard();
        $this->assertSame(2, substr_count($html, 'class="standings-team-logo"'));
        $this->assertMatchesRegularExpression(
            '/src="https:\/\/public\.example\.test\/storage\/teams\/local\.png"[^>]*>\s*<span class="standings-team-name">Equipo local/',
            $html,
        );
        $this->assertMatchesRegularExpression(
            '/src="https:\/\/public\.example\.test\/storage\/teams\/club\.png"[^>]*>\s*<span class="standings-team-name">Equipo vinculado/',
            $html,
        );
        $this->assertStringContainsString('class="standings-team-name">Equipo sin escudo', $html);
    }

    public function test_players_in_another_tournament_do_not_enable_scorers(): void
    {
        DB::table('tournament_teams')->insert([
            'id' => 2, 'tournament_id' => 2, 'name_override' => 'Otro equipo',
        ]);
        DB::table('tournament_players')->insert([
            'tournament_team_id' => 2, 'name' => 'Jugador de otro torneo',
        ]);
        [$data, $html] = $this->dashboard();

        $this->assertFalse($data['hasPlayers']);
        $this->assertStringNotContainsString('Máximos Goleadores', $html);
    }

    public function test_completed_card_shows_actual_date_extra_time_and_penalty_winner(): void
    {
        $match = (new TournamentMatch)->forceFill([
            'id' => 1, 'status' => 'completed', 'scheduled_at' => '2026-10-01 10:00:00',
            'played_at' => '2026-10-06 18:30:00', 'home_score' => 1, 'away_score' => 2,
            'home_score_extra' => 2, 'away_score_extra' => 1, 'penalty_winner' => 'away',
        ]);
        $match->setRelation('phase', null);
        $match->setRelation('homeTeam', null);
        $match->setRelation('awayTeam', (new TournamentTeam)->forceFill(['name_override' => 'Equipo ganador']));
        $html = view('livewire.webclubs._live-summary-match', compact('match'))->render();

        $this->assertStringContainsString('06/10 · 18:30', $html);
        $this->assertSame(2, substr_count($html, 'class="match-card__score-num">3'));
        $this->assertStringContainsString('Penaltis: Equipo ganador', $html);
        $this->assertStringContainsString('Local por definir', $html);
    }

    public function test_pending_standings_use_the_same_compact_desktop_columns(): void
    {
        $html = view('livewire.webclubs._pending-standings', [
            'pendingCount' => 1, 'assignedCount' => 2, 'compactDesktop' => true,
        ])->render();

        $this->assertStringContainsString('Equipo 3 · por definir', $html);
        $this->assertSame(6, substr_count($html, 'standings-table__desktop-hidden'));
        $fullHtml = view('livewire.webclubs._pending-standings', [
            'pendingCount' => 1, 'assignedCount' => 2,
        ])->render();
        $this->assertStringNotContainsString('standings-table__desktop-hidden', $fullHtml);
    }

    public function test_recent_results_use_playing_date_and_upcoming_matches_are_limited_to_two(): void
    {
        foreach ([
            [1, 'completed', '2026-10-01 10:00:00', '2026-10-06 10:00:00'],
            [2, 'completed', '2026-10-05 10:00:00', null],
            [3, 'completed', '2026-10-04 10:00:00', null],
            [4, 'scheduled', '2026-10-10 10:00:00', null],
            [5, 'postponed', '2026-10-09 10:00:00', null],
            [6, 'scheduled', '2026-10-11 10:00:00', null],
            [7, 'scheduled', null, null],
            [8, 'cancelled', '2026-10-07 10:00:00', null],
        ] as [$id, $status, $scheduledAt, $playedAt]) {
            DB::table('tournament_matches')->insert([
                'id' => $id, 'status' => $status, 'scheduled_at' => $scheduledAt,
                'played_at' => $playedAt, 'home_score' => 2, 'away_score' => 1,
            ]);
        }
        [$data, $html] = $this->dashboard();

        $this->assertSame([1, 2], $data['recentMatches']->pluck('id')->all());
        $this->assertSame([5, 4], $data['upcomingMatches']->pluck('id')->all());
        $this->assertSame(4, substr_count($html, 'wire:key="summary-match-'));
        $this->assertStringNotContainsString('wire:key="summary-match-3"', $html);
        $this->assertStringNotContainsString('wire:key="summary-match-8"', $html);

        DB::table('tournament_matches')->whereIn('id', [4, 6])->delete();
        [$data, $html] = $this->dashboard();
        $this->assertSame([5, 7], $data['upcomingMatches']->pluck('id')->all());
        $this->assertStringContainsString('Fecha por definir', $html);
        $this->assertStringContainsString('match-card__versus', $html);
    }
}
