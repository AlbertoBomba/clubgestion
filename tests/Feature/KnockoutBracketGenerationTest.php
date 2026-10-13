<?php

namespace Tests\Feature;

use App\Livewire\Tournaments\Show;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentPhase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class KnockoutBracketGenerationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'knockout_bracket_tests',
            'database.connections.knockout_bracket_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);

        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tournament_phases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->string('name');
            $table->string('type');
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('tournament_category_id')->nullable();
            $table->unsignedBigInteger('phase_id');
            $table->unsignedInteger('round');
            $table->unsignedInteger('match_number');
            $table->unsignedBigInteger('home_team_id')->nullable();
            $table->unsignedBigInteger('away_team_id')->nullable();
            $table->string('status');
            $table->text('notes')->nullable();
            $table->json('settings')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        DB::purge('knockout_bracket_tests');
        parent::tearDown();
    }

    public function test_third_place_match_is_first_in_the_final_round_before_the_final(): void
    {
        $tournament = Tournament::create([
            'sports_school_id' => 1,
            'name' => 'Torneo eliminatorio',
        ]);
        $phase = TournamentPhase::create([
            'tournament_id' => $tournament->id,
            'name' => 'Eliminatoria',
            'type' => 'knockout',
        ]);
        $component = new Show;
        $component->tournament = $tournament;
        $component->bracketPhaseId = $phase->id;
        $component->bracketRoundCount = 2;
        $component->bracketThirdPlace = true;

        $component->generateKnockoutBracket();

        $matches = TournamentMatch::where('phase_id', $phase->id)->get();
        $thirdPlace = $matches->first(fn (TournamentMatch $match) => $match->settings['is_third_place'] ?? false);
        $final = $matches->firstWhere('notes', 'Final');
        $finalRoundMatches = $matches->where('round', 2)->sortBy('match_number')->values();

        $this->assertNotNull($thirdPlace);
        $this->assertSame(2, $thirdPlace->round);
        $this->assertSame(1, $thirdPlace->match_number);
        $this->assertSame(2, $final->match_number);
        $this->assertSame([$thirdPlace->id, $final->id], $finalRoundMatches->pluck('id')->all());
        $this->assertSame(2, $matches->where('round', 2)->count());
        $this->assertSame(2, $matches->where('round', 1)->count());
    }
}
