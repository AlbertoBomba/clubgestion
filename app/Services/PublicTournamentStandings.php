<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PublicTournamentStandings
{
    public function build(Collection $phases, Collection $standings): Collection
    {
        $groups = collect();
        foreach ($phases->whereIn('type', ['league', 'group']) as $phase) {
            $phaseRows = $standings->where('phase_id', $phase->id);
            $phaseGroups = $phaseRows->groupBy(fn ($row) => $row->group_label ?? '');
            if ($phaseGroups->isEmpty()) {
                $phaseGroups->put('', collect());
            }
            foreach ($phaseGroups as $label => $rows) {
                $slots = $phase->type === 'league' ? (int) ($phase->settings['league_participants_count'] ?? 0) : 0;
                $groups->put($phase->id . ':' . $label, [
                    'name' => $phase->name . ($label !== '' ? ' – ' . $label : ''),
                    'rows' => $rows->values(),
                    'pending' => max(0, $slots - $rows->count()),
                ]);
            }
        }
        foreach ($standings->whereNull('phase_id')->groupBy(fn ($row) => $row->group_label ?? '') as $label => $rows) {
            $groups->put('general:' . $label, [
                'name' => 'General' . ($label !== '' ? ' – ' . $label : ''),
                'rows' => $rows->values(),
                'pending' => 0,
            ]);
        }

        return $groups;
    }
}
