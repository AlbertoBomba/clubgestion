<?php

namespace Tests\Feature;

use App\Models\TournamentPhase;
use App\Models\TournamentStanding;
use App\Services\PublicTournamentStandings;
use Tests\TestCase;

class PublicTournamentStandingsTest extends TestCase
{
    public function test_includes_pending_second_league_and_partially_assigned_slots(): void
    {
        $phases = collect([
            (new TournamentPhase)->forceFill(['id' => 1, 'name' => 'Liguilla', 'type' => 'league']),
            (new TournamentPhase)->forceFill(['id' => 2, 'name' => 'Liguilla', 'type' => 'league', 'settings' => ['league_participants_count' => 4]]),
            (new TournamentPhase)->forceFill(['id' => 3, 'name' => 'Final', 'type' => 'knockout']),
        ]);
        $firstRow = (new TournamentStanding)->forceFill(['id' => 1, 'phase_id' => 1, 'points' => 9]);
        $secondRow = (new TournamentStanding)->forceFill(['id' => 2, 'phase_id' => 2, 'points' => 3]);
        $service = app(PublicTournamentStandings::class);
        $groups = $service->build($phases, collect([$firstRow]));

        $this->assertSame(['1:', '2:'], $groups->keys()->all());
        $this->assertSame(9, $groups['1:']['rows']->first()->points);
        $this->assertSame(4, $groups['2:']['pending']);
        $this->assertTrue($groups['2:']['rows']->isEmpty());
        $groups = $service->build($phases, collect([$firstRow, $secondRow]));
        $this->assertSame(3, $groups['2:']['pending']);
        $this->assertSame($secondRow, $groups['2:']['rows']->first());
        $html = view('livewire.webclubs._pending-standings', [
            'pendingCount' => $groups['2:']['pending'],
            'assignedCount' => $groups['2:']['rows']->count(),
        ])->render();
        $this->assertStringContainsString('Equipo 2 · por definir', $html);
        $this->assertStringContainsString('Equipo 4 · por definir', $html);
        $this->assertStringNotContainsString('Equipo 1 · por definir', $html);
    }

    public function test_group_phases_and_general_standings_are_preserved(): void
    {
        $phase = (new TournamentPhase)->forceFill(['id' => 1, 'name' => 'Primera fase', 'type' => 'group']);
        $empty = (new TournamentPhase)->forceFill(['id' => 2, 'name' => 'Segunda fase', 'type' => 'group']);
        $rows = collect([
            (new TournamentStanding)->forceFill(['phase_id' => 1, 'group_label' => 'A']),
            (new TournamentStanding)->forceFill(['phase_id' => 1, 'group_label' => 'B']),
            (new TournamentStanding)->forceFill(['phase_id' => null]),
        ]);
        $groups = app(PublicTournamentStandings::class)->build(collect([$phase, $empty]), $rows);

        $this->assertSame(['1:A', '1:B', '2:', 'general:'], $groups->keys()->all());
        $this->assertSame('Primera fase – A', $groups['1:A']['name']);
        $this->assertSame('General', $groups['general:']['name']);
        $html = view('livewire.webclubs._pending-standings', ['pendingCount' => 0, 'assignedCount' => 0])->render();
        $this->assertStringContainsString('Sin equipos asignados aún.', $html);
        $this->assertTrue(app(PublicTournamentStandings::class)->build(collect(), collect())->isEmpty());
    }
}
