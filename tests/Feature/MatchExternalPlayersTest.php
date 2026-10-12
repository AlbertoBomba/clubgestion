<?php

namespace Tests\Feature;

use App\Livewire\Matches\Edit;
use App\Models\Player;
use App\Models\SeasonMatch;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MatchExternalPlayersTest extends TestCase
{
    private SeasonMatch $match;

    private Player $player;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'match_player_tests',
            'database.connections.match_player_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'session.driver' => 'array',
        ]);

        Schema::create('season_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->unsignedBigInteger('season_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('opponent');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('name');
            $table->string('surname');
            $table->string('player_photo')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->integer('from_year');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->string('team');
            $table->softDeletes();
        });
        Schema::create('match_player', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('season_matches');
            $table->foreignId('player_id')->constrained('players');
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->string('reason_not_called')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->boolean('card_yellow1')->default(false);
            $table->boolean('card_yellow2')->default(false);
            $table->boolean('card_red')->default(false);
            $table->timestamps();
            $table->unique(['match_id', 'player_id']);
        });
        Schema::create('match_player_not_called', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('season_matches');
            $table->foreignId('player_id')->constrained('players');
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->unique(['match_id', 'player_id']);
        });

        $user = new User;
        $user->forceFill(['id' => 1, 'sports_school_id' => 1]);
        $this->actingAs($user);
        $this->match = SeasonMatch::create([
            'sports_school_id' => 1,
            'opponent' => 'Rival',
            'date' => '2026-10-09',
        ]);
        $this->player = Player::create([
            'sports_school_id' => 1,
            'name' => 'External',
            'surname' => 'Player',
        ]);
    }

    protected function tearDown(): void
    {
        DB::purge('match_player_tests');
        parent::tearDown();
    }

    private function editMatch(): Edit
    {
        $component = new Edit;
        $component->mount($this->match->fresh());

        return $component;
    }

    public function test_external_player_is_saved_visible_and_retained_after_reload(): void
    {
        $component = $this->editMatch();
        $component->openAddExternalPlayerModal();
        $component->addExternalPlayer($this->player->id);

        $this->assertSame([$this->player->id], $component->calledPlayers);
        $this->assertFalse($component->showAddExternalPlayerModal);
        $this->assertDatabaseHas('match_player', [
            'match_id' => $this->match->id,
            'player_id' => $this->player->id,
            'created_user' => 1,
            'updated_user' => 1,
            'reason_not_called' => null,
        ]);
        $this->assertSame(
            [$this->player->id],
            $component->render()->getData()['calledPlayersData']->pluck('id')->all()
        );

        $reloaded = $this->editMatch();
        $this->assertSame([$this->player->id], $reloaded->calledPlayers);
        $this->assertSame(
            [$this->player->id],
            $reloaded->render()->getData()['calledPlayersData']->pluck('id')->all()
        );
    }

    public function test_adding_external_player_twice_does_not_duplicate_callup(): void
    {
        $component = $this->editMatch();
        $component->addExternalPlayer($this->player->id);
        $component->addExternalPlayer($this->player->id);

        $this->assertSame([$this->player->id], $component->calledPlayers);
        $this->assertSame(1, $this->match->players()->count());
    }

    public function test_external_player_is_not_saved_when_callup_limit_is_reached(): void
    {
        $calledPlayer = Player::create([
            'sports_school_id' => 1,
            'name' => 'Called',
            'surname' => 'Player',
        ]);
        $this->match->players()->attach($calledPlayer->id);
        $component = $this->editMatch();
        $component->maxPlayers = 1;
        $component->openAddExternalPlayerModal();
        $component->addExternalPlayer($this->player->id);

        $this->assertSame([$calledPlayer->id], $component->calledPlayers);
        $this->assertSame(1, $this->match->players()->count());
        $this->assertDatabaseMissing('match_player', [
            'match_id' => $this->match->id,
            'player_id' => $this->player->id,
        ]);
        $this->assertTrue($component->showAddExternalPlayerModal);
        $this->assertTrue(session()->has('error'));
    }

    public function test_external_player_previously_not_called_is_moved_to_callup(): void
    {
        $this->match->notCalledPlayers()->attach($this->player->id, ['reason' => 'Unavailable']);
        $component = $this->editMatch();
        $component->addExternalPlayer($this->player->id);

        $this->assertSame([], $component->notCalledPlayerReasons);
        $this->assertSame(0, $this->match->notCalledPlayers()->count());
        $this->assertSame([$this->player->id], $this->editMatch()->calledPlayers);
        $this->assertSame([], $this->editMatch()->notCalledPlayerReasons);
    }
}
