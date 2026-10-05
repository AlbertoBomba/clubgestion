<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TournamentBracket
{
    public function build(Collection $phases, Collection $matches): Collection
    {
        return $phases->whereIn('type', ['knockout', 'double_elimination'])
            ->mapWithKeys(function ($phase) use ($matches) {
                $phaseMatches = $matches->where('phase_id', $phase->id);
                $mainMatches = $phaseMatches
                    ->reject(fn ($match) => $match->settings['is_third_place'] ?? false)
                    ->sortBy([['round', 'asc'], ['match_number', 'asc'], ['id', 'asc']])
                    ->values();
                $firstRound = (int) ($mainMatches->min('round') ?? 1);
                $maxRound = (int) ($mainMatches->max('round') ?? 0);
                $rounds = collect();
                for ($round = $firstRound; $round <= $maxRound; $round++) {
                    $rounds->put($round, $mainMatches->where('round', $round)->values());
                }

                return [$phase->id => [
                    'phase' => $phase,
                    'rounds' => $rounds,
                    'maxRound' => $maxRound,
                    'firstRound' => $firstRound,
                    'totalRounds' => max(0, $maxRound - $firstRound + 1),
                    'numFirstRoundMatches' => max(1, $mainMatches->where('round', $firstRound)->count()),
                    'thirdPlace' => $phaseMatches->first(fn ($match) => $match->settings['is_third_place'] ?? false),
                    'hasMatches' => $mainMatches->isNotEmpty(),
                ]];
            });
    }
}
