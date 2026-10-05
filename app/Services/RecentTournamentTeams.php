<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\TournamentTeam;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class RecentTournamentTeams
{
    public function query(Tournament $tournament): Builder
    {
        return TournamentTeam::query()
            ->where('tournament_id', '!=', $tournament->id)
            ->whereHas('tournament', function (Builder $query) use ($tournament) {
                $query->where('sports_school_id', $tournament->sports_school_id)
                    ->where('status', '!=', 'cancelled')
                    ->whereBetween('created_at', [
                        today()->subMonthNoOverflow(),
                        now(),
                    ]);
            });
    }

    public function available(Tournament $tournament, ?int $categoryId): Collection
    {
        $existing = $this->destinationTeams($tournament, $categoryId)->get();

        return $this->query($tournament)
            ->with(['team', 'tournament', 'tournamentCategory.category'])
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get()
            ->reject(fn (TournamentTeam $team) => $existing->contains(
                fn (TournamentTeam $registered) => $this->sameTeam($team, $registered)
            ))
            ->unique(fn (TournamentTeam $team) => $this->identity($team))
            ->values();
    }

    public function import(Tournament $tournament, ?int $categoryId, int $sourceId): TournamentTeam
    {
        $copiedLogo = null;

        try {
            return DB::transaction(function () use ($tournament, $categoryId, $sourceId, &$copiedLogo) {
                Tournament::whereKey($tournament->id)->lockForUpdate()->firstOrFail();
                $source = $this->query($tournament)->with('team')->findOrFail($sourceId);

                if ($this->destinationTeams($tournament, $categoryId)->get()->contains(
                    fn (TournamentTeam $team) => $this->sameTeam($source, $team)
                )) {
                    throw ValidationException::withMessages([
                        'recentTeam' => 'Este equipo ya está inscrito en esta categoría del torneo.',
                    ]);
                }

                $data = $source->only([
                    'team_id', 'external_team', 'name_override', 'contact_name',
                    'contact_phone', 'email', 'password', 'seed', 'notes',
                ]);

                if ($tournament->team_type === 'open') {
                    $data['team_id'] = null;
                    $data['external_team'] = true;
                    $data['name_override'] = $source->displayName();
                }

                // Keep an independent logo file: editing the copy must not delete the original.
                $logo = $source->logo ?: $source->team?->logo;
                if ($logo) {
                    if (! Storage::disk('public')->exists($logo)) {
                        throw ValidationException::withMessages([
                            'recentTeam' => 'El escudo original no está disponible. Corrígelo en el equipo de origen antes de añadirlo.',
                        ]);
                    }
                    $copiedLogo = 'tournament-teams/logos/'.Str::uuid().'.'.pathinfo($logo, PATHINFO_EXTENSION);
                    if (! Storage::disk('public')->copy($logo, $copiedLogo)) {
                        throw ValidationException::withMessages([
                            'recentTeam' => 'No se pudo copiar el escudo del equipo. Inténtalo de nuevo.',
                        ]);
                    }
                }

                return TournamentTeam::create(array_merge($data, [
                    'tournament_id' => $tournament->id,
                    'tournament_category_id' => $tournament->team_type === 'open' ? null : $categoryId,
                    'logo' => $copiedLogo,
                    'group_label' => null,
                    'status' => 'registered',
                    'registration_token' => null,
                ]));
            });
        } catch (Throwable $exception) {
            if ($copiedLogo && Storage::disk('public')->exists($copiedLogo)) {
                if (! Storage::disk('public')->delete($copiedLogo)) {
                    report(new RuntimeException('No se pudo limpiar el escudo de una inscripción fallida.'));
                }
            }
            throw $exception;
        }
    }

    public function importMany(Tournament $tournament, ?int $categoryId, array $sourceIds): Collection
    {
        $copies = collect();
        try {
            return DB::transaction(function () use ($tournament, $categoryId, $sourceIds, $copies) {
                foreach ($sourceIds as $sourceId) {
                    $copies->push($this->import($tournament, $categoryId, (int) $sourceId));
                }

                return $copies;
            });
        } catch (Throwable $exception) {
            foreach ($copies as $copy) {
                if ($copy->logo && ! Storage::disk('public')->delete($copy->logo)) {
                    report(new RuntimeException('No se pudo limpiar el escudo de una inscripción múltiple fallida.'));
                }
            }
            throw $exception;
        }
    }

    private function destinationTeams(Tournament $tournament, ?int $categoryId): Builder
    {
        return $tournament->tournamentTeams()
            ->when($tournament->team_type !== 'open', fn (Builder $query) => $query->where('tournament_category_id', $categoryId))
            ->getQuery();
    }

    private function identity(TournamentTeam $team): string
    {
        if ($team->team_id) {
            return 'school:'.$team->team_id;
        }

        return 'external:'.Str::lower(trim($team->name_override ?? '')).':'.Str::lower(trim($team->email ?? ''));
    }

    private function sameTeam(TournamentTeam $source, TournamentTeam $destination): bool
    {
        return $this->identity($source) === $this->identity($destination)
            || ($source->team_id && $destination->external_team
                && Str::lower(trim($source->displayName())) === Str::lower(trim($destination->name_override ?? ''))
                && Str::lower(trim($source->email ?? '')) === Str::lower(trim($destination->email ?? '')));
    }
}
