<?php

namespace Tests\Feature;

use App\Livewire\WebClubs\LiveDetail;
use App\Livewire\WebClubs\TournamentDetail;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentPhase;
use App\Models\TournamentTeam;
use App\Services\TournamentBracket;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PublicTournamentBracketTest extends TestCase
{
    private function phase(int $id, string $type = 'knockout'): TournamentPhase
    {
        return (new TournamentPhase)->forceFill([
            'id' => $id, 'name' => 'Fase '.$id, 'type' => $type,
        ]);
    }

    private function fixtureMatch(int $id, int $phase, int $round, int $number, array $attributes = []): TournamentMatch
    {
        $match = (new TournamentMatch)->forceFill(array_merge([
            'id' => $id, 'phase_id' => $phase, 'round' => $round,
            'match_number' => $number, 'status' => 'scheduled',
        ], $attributes));
        $match->setRelation('homeTeam', null);
        $match->setRelation('awayTeam', null);

        return $match;
    }

    public function test_brackets_only_include_elimination_phases_and_keep_round_and_match_order(): void
    {
        $first = $this->fixtureMatch(1, 1, 1, 1);
        $second = $this->fixtureMatch(2, 1, 1, 2);
        $final = $this->fixtureMatch(3, 1, 2, 1);
        $third = $this->fixtureMatch(4, 1, 1, 999, ['settings' => ['is_third_place' => true]]);
        $league = $this->fixtureMatch(5, 2, 1, 1);
        $data = app(TournamentBracket::class)->build(
            collect([$this->phase(1), $this->phase(2, 'league'), $this->phase(3, 'double_elimination')]),
            collect([$third, $final, $second, $league, $first])
        );

        $this->assertSame([1, 3], $data->keys()->all());
        $this->assertSame([1, 2], $data[1]['rounds']->get(1)->pluck('id')->all());
        $this->assertSame([3], $data[1]['rounds']->get(2)->pluck('id')->all());
        $this->assertSame($third, $data[1]['thirdPlace']);
        $this->assertSame(2, $data[1]['totalRounds']);
        $this->assertFalse($data[3]['hasMatches']);
        $html = view('livewire.webclubs._tournament-bracket', ['bracketData' => $data])->render();
        $this->assertStringContainsString('Semifinales', $html);
        $this->assertStringContainsString('Final', $html);
        $this->assertStringContainsString('Tercer puesto', $html);
        $this->assertStringContainsString('Por definir', $html);
        $this->assertStringContainsString('Todavía no hay cruces generados', $html);
        $this->assertStringNotContainsString('Fase 2', $html);
        $this->assertStringNotContainsString('wire:click', $html);
        $this->assertSame(1, substr_count($html, 'wire:key="public-bracket-match-4"'));
    }

    public function test_match_card_shows_extra_time_and_penalty_winner_without_admin_actions(): void
    {
        $match = $this->fixtureMatch(1, 1, 2, 1, [
            'status' => 'completed', 'home_score' => 1, 'away_score' => 2,
            'home_score_extra' => 2, 'away_score_extra' => 1, 'penalty_winner' => 'away',
        ]);
        $match->setRelation('homeTeam', (new TournamentTeam)->forceFill(['id' => 1, 'name_override' => 'Equipo local']));
        $match->setRelation('awayTeam', (new TournamentTeam)->forceFill(['id' => 2, 'name_override' => 'Equipo ganador']));
        $html = view('livewire.webclubs._tournament-bracket-match', compact('match'))->render();

        $this->assertStringContainsString('Equipo local', $html);
        $this->assertStringContainsString('Equipo ganador', $html);
        $this->assertSame(1, substr_count($html, 'public-bracket-winner'));
        $this->assertStringContainsString('(pen.)', $html);
        $this->assertMatchesRegularExpression('/<strong[^>]*>\s*3\s*/', $html);
        $this->assertStringNotContainsString('wire:click', $html);
    }

    public function test_live_card_and_empty_non_elimination_tournament(): void
    {
        $match = $this->fixtureMatch(1, 1, 1, 1, ['status' => 'in_progress', 'home_score' => 2, 'away_score' => 0]);
        $html = view('livewire.webclubs._tournament-bracket-match', compact('match'))->render();
        $this->assertStringContainsString('public-bracket-live', $html);
        $this->assertStringContainsString('En juego', $html);
        $this->assertTrue(app(TournamentBracket::class)->build(collect([$this->phase(1, 'league')]), collect([$match]))->isEmpty());
    }

    public function test_both_public_components_supply_brackets_and_live_refreshes_scores(): void
    {
        config([
            'database.default' => 'public_bracket_tests',
            'database.connections.public_bracket_tests' => [
                'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
            ],
        ]);
        try {
            Schema::create('tournament_phases', function (Blueprint $table) {
                $table->id();
                $table->integer('tournament_id');
                $table->string('name');
                $table->string('type');
                $table->text('settings')->nullable();
                $table->integer('order')->default(1);
                $table->softDeletes();
            });
            Schema::create('tournament_matches', function (Blueprint $table) {
                $table->id();
                $table->integer('tournament_id');
                $table->integer('phase_id');
                $table->integer('round');
                $table->integer('match_number');
                $table->integer('home_team_id')->nullable();
                $table->integer('away_team_id')->nullable();
                $table->integer('home_score')->nullable();
                $table->string('status');
                $table->dateTime('scheduled_at')->nullable();
                $table->softDeletes();
            });
            Schema::create('tournament_teams', function (Blueprint $table) {
                $table->id();
                $table->integer('tournament_id');
                $table->integer('seed');
            });
            Schema::create('tournament_players', function (Blueprint $table) {
                $table->id();
                $table->integer('tournament_team_id');
            });
            Schema::create('tournament_standings', function (Blueprint $table) {
                $table->id();
                $table->integer('tournament_id');
                $table->integer('tournament_team_id')->nullable();
                foreach (['phase_id', 'position', 'points', 'goals_for', 'goals_against'] as $column) {
                    $table->integer($column);
                }
                foreach (['played', 'won', 'drawn', 'lost'] as $column) {
                    $table->integer($column)->default(0);
                }
                $table->string('group_label');
            });
            foreach (['tournament_match_goals', 'tournament_match_cards'] as $tableName) {
                Schema::create($tableName, function (Blueprint $table) {
                    $table->id();
                    $table->integer('tournament_match_id');
                    $table->integer('tournament_player_id')->nullable();
                    $table->string('goal_type')->nullable();
                });
            }
            DB::table('tournament_phases')->insert([
                ['id' => 1, 'tournament_id' => 1, 'name' => 'Final', 'type' => 'knockout'],
                ['id' => 2, 'tournament_id' => 2, 'name' => 'Otro torneo', 'type' => 'knockout'],
            ]);
            DB::table('tournament_matches')->insert([
                'id' => 1, 'tournament_id' => 1, 'phase_id' => 1,
                'round' => 1, 'match_number' => 1, 'status' => 'scheduled',
            ]);
            $tournament = (new Tournament)->forceFill(['id' => 1, 'name' => 'Torneo', 'status' => 'in_progress']);
            foreach ([new TournamentDetail, new LiveDetail] as $component) {
                $component->tournament = $tournament;
                $data = $component->render()->getData();
                $this->assertSame([1], $data['bracketData']->keys()->all());
                $this->assertSame(1, $data['bracketData'][1]['rounds'][1]->first()->id);
                $viewName = $component instanceof LiveDetail ? 'livewire.webclubs.live-detail' : 'livewire.webclubs.tournament-detail';
                $html = view($viewName, array_merge(get_object_vars($component), $data))->render();
                $this->assertStringContainsString('Final · Cuadro de cruces', $html);
                $this->assertStringContainsString('wire:key="public-bracket-match-1"', $html);
                if ($component instanceof LiveDetail) {
                    $this->assertStringContainsString('wire:poll.5s', $html);
                    $dom = new \DOMDocument;
                    $previous = libxml_use_internal_errors(true);
                    try {
                        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
                        $xpath = new \DOMXPath($dom);
                        $this->assertSame(1, $xpath->query('//div[contains(@class, "live-col--classification")]//div[@x-show="panel === \'standings\'"]')->length);
                    } finally {
                        libxml_clear_errors();
                        libxml_use_internal_errors($previous);
                    }
                } else {
                    $dom = new \DOMDocument;
                    $previous = libxml_use_internal_errors(true);
                    try {
                        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
                        $xpath = new \DOMXPath($dom);
                        $this->assertSame(1, $xpath->query('//div[@x-show="tab === \'clasificacion\'"]//section[contains(@class, "public-bracket")]')->length);
                        $this->assertSame(0, $xpath->query('//div[@x-show="tab === \'partidos\'"]//section[contains(@class, "public-bracket")]')->length);
                        $this->assertStringNotContainsString('La clasificacion no esta disponible aun.', $html);
                    } finally {
                        libxml_clear_errors();
                        libxml_use_internal_errors($previous);
                    }
                }
            }
            DB::table('tournament_matches')->where('id', 1)->update(['home_score' => 4, 'status' => 'completed']);
            $data = $component->render()->getData();
            $this->assertEquals(4, $data['bracketData'][1]['rounds'][1]->first()->home_score);
            DB::table('tournament_matches')->where('id', 1)->update(['status' => 'in_progress']);
            $data = $component->render()->getData();
            $html = view('livewire.webclubs.live-detail', array_merge(get_object_vars($component), $data))->render();
            $this->assertStringContainsString('wire:key="live-match-1"', $html);
            $this->assertStringContainsString('Últimos resultados', $html);
            $this->assertStringContainsString('Próximos partidos', $html);
            $this->assertStringContainsString('wire:key="public-bracket-match-1"', $html);
            DB::table('tournament_phases')->where('id', 1)->update(['type' => 'league']);
            foreach ([new TournamentDetail, new LiveDetail] as $component) {
                $component->tournament = $tournament;
                $data = $component->render()->getData();
                $this->assertTrue($data['bracketData']->isEmpty());
                $viewName = $component instanceof LiveDetail ? 'livewire.webclubs.live-detail' : 'livewire.webclubs.tournament-detail';
                $html = view($viewName, array_merge(get_object_vars($component), $data))->render();
                $this->assertStringNotContainsString('public-bracket-card', $html);
            }
            DB::table('tournament_phases')->insert([
                'id' => 3, 'tournament_id' => 1, 'name' => 'Segunda liguilla',
                'type' => 'league', 'order' => 2,
                'settings' => json_encode(['league_participants_count' => 4]),
            ]);
            DB::table('tournament_standings')->insert([
                'id' => 1, 'tournament_id' => 1, 'phase_id' => 1,
                'position' => 1, 'points' => 9, 'goals_for' => 6,
                'goals_against' => 1, 'group_label' => '',
            ]);
            foreach ([new TournamentDetail, new LiveDetail] as $component) {
                $component->tournament = $tournament;
                $data = $component->render()->getData();
                $this->assertSame(['1:', '3:'], $data['standingGroups']->keys()->all());
                $this->assertSame(4, $data['standingGroups']['3:']['pending']);
                $this->assertEquals(9, $data['standingGroups']['1:']['rows']->first()->points);
                $viewName = $component instanceof LiveDetail ? 'livewire.webclubs.live-detail' : 'livewire.webclubs.tournament-detail';
                $html = view($viewName, array_merge(get_object_vars($component), $data))->render();
                $this->assertStringContainsString('Segunda liguilla', $html);
                $this->assertStringContainsString('Equipo 4 · por definir', $html);
                $this->assertStringNotContainsString('La clasificacion no esta disponible aun.', $html);
            }
        } finally {
            DB::purge('public_bracket_tests');
        }
    }
}
