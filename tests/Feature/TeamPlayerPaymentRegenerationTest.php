<?php

namespace Tests\Feature;

use App\Livewire\Teams\Edit;
use App\Models\PaymentPlayer;
use App\Models\PaymentTeam;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TeamPlayerPaymentRegenerationTest extends TestCase
{
    private Season $season;

    private Player $player;

    private Team $sourceTeam;

    private Team $otherTeam;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'team_payment_tests',
            'database.connections.team_payment_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'session.driver' => 'array',
        ]);

        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('section_id');
            $table->string('team');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('name');
            $table->string('surname');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('teams_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('payments_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('sports_school_id');
            $table->string('description');
            $table->integer('cuota');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('payments_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('sports_school_id');
            $table->string('code')->nullable();
            $table->integer('state');
            $table->integer('cuota');
            foreach (['price', 'amount', 'amount_original', 'descEnt', 'descPerc'] as $column) {
                $table->decimal($column, 10, 2)->nullable();
            }
            $table->timestamp('payment_date')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('payments_codes_sequentials', function (Blueprint $table) {
            $table->id();
            $table->integer('sequential');
            $table->timestamps();
        });
        DB::table('payments_codes_sequentials')->insert(['sequential' => 1]);

        $user = new User;
        $user->forceFill(['id' => 1, 'sports_school_id' => 1]);
        $this->actingAs($user);

        $this->season = Season::create([
            'sports_school_id' => 1,
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
        ]);
        $this->player = Player::create([
            'sports_school_id' => 1,
            'name' => 'Test',
            'surname' => 'Player',
        ]);
        $this->sourceTeam = $this->createTeam(1);
        $this->otherTeam = $this->createTeam(2);
        $this->player->teams()->attach([$this->sourceTeam->id, $this->otherTeam->id]);
    }

    protected function tearDown(): void
    {
        DB::purge('team_payment_tests');
        parent::tearDown();
    }

    public function test_preview_only_uses_source_section_payments_and_keeps_existing_filters(): void
    {
        $target = $this->createTeam(3);
        $pending = $this->createPlayerPayment($this->sourceTeam, 1, 0);
        $paid = $this->createPlayerPayment($this->sourceTeam, 2, 1);
        $this->createPlayerPayment($this->otherTeam, 1, 0);
        $this->createPlayerPayment($this->otherTeam, 3, 1);
        $this->createPlayerPayment($this->sourceTeam, 4, 2);
        $deleted = $this->createPlayerPayment($this->sourceTeam, 5, 0);
        $deleted->delete();
        $oldSeasonPayment = $this->createPlayerPayment($this->sourceTeam, 6, 0);
        $oldSeasonPayment->paymentTeam->update(['season_id' => $this->season->id + 1]);
        $foreignSchoolPayment = $this->createPlayerPayment($this->sourceTeam, 7, 0);
        $foreignSchoolPayment->update(['sports_school_id' => 2]);
        $otherPlayerPayment = $this->createPlayerPayment($this->sourceTeam, 8, 0);
        $otherPlayerPayment->update(['player_id' => $this->player->id + 1]);
        foreach ([1, 2, 3] as $cuota) {
            $this->createTeamPayment($target, $cuota);
        }

        $component = $this->previewMove($target);

        $this->assertTrue($component->showPreviewModal);
        $this->assertFalse($component->showMovePlayerModal);
        $this->assertSame([$pending->id], array_column($component->paymentsToDelete, 'id'));
        $this->assertSame([$pending->id], $component->selectedPaymentsToDelete);
        $this->assertSame([$paid->code], array_column($component->paymentsPaid, 'code'));
        $this->assertSame([1, 3], array_column($component->paymentsToCreate, 'cuota'));
        $this->assertSame(
            $target->payments()->whereIn('cuota', [1, 3])->pluck('id')->all(),
            array_column($component->paymentsToCreate, 'payment_id')
        );
        $this->assertSame(
            array_column($component->paymentsToCreate, 'unique_id'),
            $component->selectedPaymentsToCreate
        );
    }

    public function test_same_section_move_includes_payments_from_previous_teams_in_that_section(): void
    {
        $previousTeam = $this->createTeam(1);
        $pending = $this->createPlayerPayment($previousTeam, 1, 0);
        $paid = $this->createPlayerPayment($previousTeam, 2, 1);
        $this->createPlayerPayment($this->otherTeam, 3, 1);
        $target = $this->createTeam(1);
        foreach ([1, 2, 3] as $cuota) {
            $this->createTeamPayment($target, $cuota);
        }

        $component = $this->previewMove($target);

        $this->assertSame([$pending->id], array_column($component->paymentsToDelete, 'id'));
        $this->assertSame([$paid->code], array_column($component->paymentsPaid, 'code'));
        $this->assertSame([1, 3], array_column($component->paymentsToCreate, 'cuota'));
    }

    public function test_confirming_move_preserves_other_section_payments_and_membership(): void
    {
        $target = $this->createTeam(3);
        $pending = $this->createPlayerPayment($this->sourceTeam, 1, 0);
        $paid = $this->createPlayerPayment($this->sourceTeam, 2, 1);
        $otherPending = $this->createPlayerPayment($this->otherTeam, 1, 0);
        $otherPaid = $this->createPlayerPayment($this->otherTeam, 3, 1);
        foreach ([1, 2, 3] as $cuota) {
            $this->createTeamPayment($target, $cuota);
        }
        $component = $this->previewMove($target);

        $component->confirmPaymentsAction();

        $this->assertFalse(session()->has('error'), (string) session('error'));
        $this->assertSoftDeleted('payments_players', ['id' => $pending->id]);
        foreach ([$paid, $otherPending, $otherPaid] as $payment) {
            $this->assertDatabaseHas('payments_players', [
                'id' => $payment->id,
                'state' => $payment->state,
                'deleted_at' => null,
            ]);
        }
        $this->assertSame(
            [1, 3],
            PaymentPlayer::whereHas('paymentTeam', fn ($q) => $q->where('team_id', $target->id))
                ->orderBy('cuota')->pluck('cuota')->all()
        );
        $this->assertEqualsCanonicalizing(
            [$this->otherTeam->id, $target->id],
            $this->player->teams()->pluck('teams.id')->all()
        );
    }

    private function createTeam(int $sectionId): Team
    {
        return Team::create([
            'team' => 'Team '.$sectionId,
            'season_id' => $this->season->id,
            'section_id' => $sectionId,
            'price' => 300,
        ]);
    }

    private function createTeamPayment(Team $team, int $cuota): PaymentTeam
    {
        return PaymentTeam::create([
            'team_id' => $team->id,
            'season_id' => $this->season->id,
            'sports_school_id' => 1,
            'description' => $team->team.' - '.$cuota,
            'cuota' => $cuota,
            'amount' => 100,
        ]);
    }

    private function createPlayerPayment(Team $team, int $cuota, int $state): PaymentPlayer
    {
        $payment = $this->createTeamPayment($team, $cuota);

        return PaymentPlayer::create([
            'player_id' => $this->player->id,
            'payment_id' => $payment->id,
            'sports_school_id' => 1,
            'code' => 'PAY-'.$payment->id,
            'cuota' => $cuota,
            'state' => $state,
            'amount' => 100,
            'payment_date' => $state === 1 ? now() : null,
        ]);
    }

    private function previewMove(Team $target): Edit
    {
        $component = new Edit;
        $component->team = $this->sourceTeam;
        // An unsaved form section must not change the payment scope.
        $component->section_id = $this->otherTeam->section_id;
        $component->openMovePlayerModal($this->player->id);
        $component->targetTeamId = $target->id;
        $component->movePlayer();

        return $component;
    }
}
