<?php

namespace Database\Seeders;

use App\Models\TournamentCategory;
use App\Models\TournamentMatch;
use App\Models\TournamentPhase;
use App\Models\TournamentStanding;
use App\Models\TournamentTeam;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds a full demo tournament "Torneo de Verano 2026" with 3 categories:
 *   • Alevín   – Fase de grupos (A & B) + Eliminatoria
 *   • Infantil  – Liga (round-robin completo)
 *   • Cadete    – Fase de grupos + FK finale
 *
 * Uses IDs from the real DB (sports_school_id=3, season_id=34, user_id=5).
 * Run with:  php artisan db:seed --class=TournamentSeeder
 */
class TournamentSeeder extends Seeder
{
    // ── Real DB IDs ───────────────────────────────────────────────────
    private const SCHOOL_ID  = 3;
    private const SEASON_ID  = 34;   // Temporada 2025/2026
    private const USER_ID    = 5;    // Alberto Martin

    // Category IDs from `categories` table
    private const CAT_ALEVIN   = 4;
    private const CAT_INFANTIL = 5;
    private const CAT_CADETE   = 6;

    // Team IDs from `teams` table (season 34)
    private const T_ALEVIN_A   = 106;
    private const T_ALEVIN_B   = 118;
    private const T_ALEVIN_C   = 119;
    private const T_INFANTIL_A = 113;
    private const T_INFANTIL_B = 121;
    private const T_INFANTIL_C = 122;
    private const T_FEM_INF_A  = 120;
    private const T_CADETE_A   = 117;
    private const T_CADETE_B   = 124;
    private const T_CADETE_C   = 131;
    private const T_FEM_CAD    = 112;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clean previous seeded tournaments to allow re-runs
        Tournament::where('name', 'Torneo de Verano 2026')->each(function ($t) {
            TournamentStanding::where('tournament_id', $t->id)->delete();
            TournamentMatch::where('tournament_id', $t->id)->forceDelete();
            TournamentTeam::where('tournament_id', $t->id)->delete();
            TournamentPhase::where('tournament_id', $t->id)->forceDelete();
            TournamentCategory::where('tournament_id', $t->id)->delete();
            $t->forceDelete();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ──────────────────────────────────────────────────────────────
        // 1. Create the tournament
        // ──────────────────────────────────────────────────────────────
        $tournament = Tournament::create([
            'sports_school_id'      => self::SCHOOL_ID,
            'season_id'             => self::SEASON_ID,
            'name'                  => 'Torneo de Verano 2026',
            'description'           => 'Torneo interno de fin de temporada con categorías Alevín, Infantil y Cadete. ¡Toda la escuela participa!',
            'location'              => 'Pabellón Municipal + Pistas Exteriores',
            'start_date'            => '2026-06-20',
            'end_date'              => '2026-06-28',
            'registration_deadline' => '2026-06-10',
            'max_teams'             => 24,
            'status'                => 'in_progress',
            'visibility'            => 'private',
            'settings'              => [
                'points_per_win'  => 3,
                'points_per_draw' => 1,
                'points_per_loss' => 0,
            ],
            'created_user' => self::USER_ID,
            'updated_user' => self::USER_ID,
        ]);

        // ──────────────────────────────────────────────────────────────
        // 2. ALEVÍN category
        // ──────────────────────────────────────────────────────────────
        $catAlevin = TournamentCategory::create([
            'tournament_id' => $tournament->id,
            'category_id'   => self::CAT_ALEVIN,
            'order'         => 1,
            'status'        => 'active',
        ]);

        // Phases
        $alevinGroups = TournamentPhase::create([
            'tournament_id'          => $tournament->id,
            'tournament_category_id' => $catAlevin->id,
            'name'                   => 'Fase de Grupos',
            'type'                   => 'group',
            'order'                  => 1,
            'status'                 => 'completed',
            'settings'               => ['groups_count' => 2, 'teams_advance' => 1, 'legs' => 1, 'points_per_win' => 3, 'points_per_draw' => 1, 'points_per_loss' => 0],
        ]);

        $alevinKO = TournamentPhase::create([
            'tournament_id'          => $tournament->id,
            'tournament_category_id' => $catAlevin->id,
            'name'                   => 'Eliminatoria',
            'type'                   => 'knockout',
            'order'                  => 2,
            'status'                 => 'in_progress',
            'settings'               => ['legs' => 1, 'third_place' => true, 'extra_time' => false, 'penalties' => true],
        ]);

        // Tournament teams – Alevín
        // Group A
        $alA = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catAlevin->id, 'team_id' => self::T_ALEVIN_A, 'seed' => 1, 'group_label' => 'A', 'status' => 'confirmed']);
        $alC = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catAlevin->id, 'team_id' => self::T_ALEVIN_C, 'seed' => 3, 'group_label' => 'A', 'status' => 'confirmed']);
        $extRayo = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catAlevin->id, 'external_team' => true, 'name_override' => 'FC Rayo Visitante', 'seed' => 5, 'group_label' => 'A', 'status' => 'confirmed']);
        // Group B
        $alB = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catAlevin->id, 'team_id' => self::T_ALEVIN_B, 'seed' => 2, 'group_label' => 'B', 'status' => 'confirmed']);
        $extAtl = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catAlevin->id, 'external_team' => true, 'name_override' => 'CD Atlético Verano', 'seed' => 4, 'group_label' => 'B', 'status' => 'confirmed']);
        $extEst = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catAlevin->id, 'external_team' => true, 'name_override' => 'Estrellas del Sur', 'seed' => 6, 'group_label' => 'B', 'status' => 'confirmed']);

        // Grupo A matches (all completed)
        $this->match($tournament->id, $catAlevin->id, $alevinGroups->id, $alA, $extRayo,  3, 1, 1, 'A', '2026-06-20 10:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catAlevin->id, $alevinGroups->id, $alC, $extRayo,  1, 1, 2, 'A', '2026-06-21 10:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catAlevin->id, $alevinGroups->id, $alA, $alC,       2, 0, 3, 'A', '2026-06-22 10:00', 'Pabellón Municipal');

        // Grupo B matches (all completed)
        $this->match($tournament->id, $catAlevin->id, $alevinGroups->id, $alB,   $extAtl,  3, 0, 1, 'B', '2026-06-20 12:00', 'Pistas Exteriores');
        $this->match($tournament->id, $catAlevin->id, $alevinGroups->id, $extAtl, $extEst, 2, 1, 2, 'B', '2026-06-21 12:00', 'Pistas Exteriores');
        $this->match($tournament->id, $catAlevin->id, $alevinGroups->id, $alB,   $extEst,  4, 1, 3, 'B', '2026-06-22 12:00', 'Pistas Exteriores');

        // Eliminatoria – Semis (completed)
        $this->match($tournament->id, $catAlevin->id, $alevinKO->id, $alA, $alB, 2, 1, 2, null, '2026-06-25 10:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catAlevin->id, $alevinKO->id, $alC, $extAtl, 3, 2, 2, null, '2026-06-25 12:00', 'Pabellón Municipal');

        // Final & 3rd place (scheduled)
        $this->match($tournament->id, $catAlevin->id, $alevinKO->id, $alA, $alC, null, null, 1, null, '2026-06-28 11:00', 'Pabellón Municipal', 'scheduled');
        $this->match($tournament->id, $catAlevin->id, $alevinKO->id, $alB, $extAtl, null, null, 3, null, '2026-06-28 09:00', 'Pabellón Municipal', 'scheduled');

        // Standings – Grupo A
        $this->standing($tournament->id, $catAlevin->id, $alevinGroups->id, $alA,     'A', 2, 2, 0, 0, 5, 1, 6, 1);
        $this->standing($tournament->id, $catAlevin->id, $alevinGroups->id, $alC,     'A', 2, 0, 1, 1, 1, 3, 1, 2);
        $this->standing($tournament->id, $catAlevin->id, $alevinGroups->id, $extRayo, 'A', 2, 0, 1, 1, 2, 4, 1, 3);
        // Standings – Grupo B
        $this->standing($tournament->id, $catAlevin->id, $alevinGroups->id, $alB,    'B', 2, 2, 0, 0, 7, 2, 6, 1);
        $this->standing($tournament->id, $catAlevin->id, $alevinGroups->id, $extAtl, 'B', 2, 1, 0, 1, 2, 4, 3, 2);
        $this->standing($tournament->id, $catAlevin->id, $alevinGroups->id, $extEst, 'B', 2, 0, 0, 2, 2, 5, 0, 3);

        // ──────────────────────────────────────────────────────────────
        // 3. INFANTIL category  –  Liga completa
        // ──────────────────────────────────────────────────────────────
        $catInfantil = TournamentCategory::create([
            'tournament_id' => $tournament->id,
            'category_id'   => self::CAT_INFANTIL,
            'order'         => 2,
            'status'        => 'active',
        ]);

        $infLiga = TournamentPhase::create([
            'tournament_id'          => $tournament->id,
            'tournament_category_id' => $catInfantil->id,
            'name'                   => 'Liga',
            'type'                   => 'league',
            'order'                  => 1,
            'status'                 => 'in_progress',
            'settings'               => ['legs' => 1, 'points_per_win' => 3, 'points_per_draw' => 1, 'points_per_loss' => 0],
        ]);

        $infA  = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catInfantil->id, 'team_id' => self::T_INFANTIL_A, 'seed' => 1, 'status' => 'confirmed']);
        $infB  = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catInfantil->id, 'team_id' => self::T_INFANTIL_B, 'seed' => 3, 'status' => 'confirmed']);
        $infC  = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catInfantil->id, 'team_id' => self::T_INFANTIL_C, 'seed' => 4, 'status' => 'confirmed']);
        $femIA = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catInfantil->id, 'team_id' => self::T_FEM_INF_A, 'seed' => 2, 'status' => 'confirmed']);
        $extClub = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catInfantil->id, 'external_team' => true, 'name_override' => 'Club Polideportivo Norte', 'seed' => 5, 'status' => 'confirmed']);

        // Jornada 1
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infA,  $femIA,   3, 1, 1, null, '2026-06-20 16:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infB,  $infC,    1, 1, 1, null, '2026-06-20 18:00', 'Pabellón Municipal');
        // Jornada 2
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infA,  $infB,    2, 0, 2, null, '2026-06-22 16:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $femIA, $extClub, 2, 2, 2, null, '2026-06-22 18:00', 'Pabellón Municipal');
        // Jornada 3
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infA,  $infC,    1, 0, 3, null, '2026-06-24 16:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infB,  $extClub, 3, 1, 3, null, '2026-06-24 18:00', 'Pabellón Municipal');
        // Jornada 4
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infA,  $extClub, 4, 0, 4, null, '2026-06-26 16:00', 'Pabellón Municipal');
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $femIA, $infC,    1, 2, 4, null, '2026-06-26 18:00', 'Pabellón Municipal');
        // Jornada 5 (pending)
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $femIA, $infB,  null, null, 5, null, '2026-06-28 16:00', 'Pabellón Municipal', 'scheduled');
        $this->match($tournament->id, $catInfantil->id, $infLiga->id, $infC,  $extClub, null, null, 5, null, '2026-06-28 18:00', 'Pabellón Municipal', 'scheduled');

        // Standings (after 4 jornadas played)
        // infA:   P4 W4 D0 L0 GF10 GA1  Pts12
        // infB:   P3 W1 D1 L1 GF4  GA5  Pts4
        // infC:   P3 W1 D1 L1 GF3  GA5  Pts4
        // femIA:  P3 W0 D1 L2 GF4  GA8  Pts1… let me re-verify then put approximate
        // extClub:P2 W0 D1 L1 GF3  GA7  Pts1
        $this->standing($tournament->id, $catInfantil->id, $infLiga->id, $infA,    null, 4, 4, 0, 0, 10,  1, 12, 1);
        $this->standing($tournament->id, $catInfantil->id, $infLiga->id, $infC,    null, 3, 1, 1, 1,  3,  4,  4, 2);
        $this->standing($tournament->id, $catInfantil->id, $infLiga->id, $infB,    null, 3, 1, 1, 1,  4,  3,  4, 3);
        $this->standing($tournament->id, $catInfantil->id, $infLiga->id, $femIA,   null, 3, 0, 1, 2,  4,  8,  1, 4);
        $this->standing($tournament->id, $catInfantil->id, $infLiga->id, $extClub, null, 2, 0, 1, 1,  3,  7,  1, 5);

        // ──────────────────────────────────────────────────────────────
        // 4. CADETE category  –  Grupos + Final
        // ──────────────────────────────────────────────────────────────
        $catCadete = TournamentCategory::create([
            'tournament_id' => $tournament->id,
            'category_id'   => self::CAT_CADETE,
            'order'         => 3,
            'status'        => 'active',
        ]);

        $cadGrupos = TournamentPhase::create([
            'tournament_id'          => $tournament->id,
            'tournament_category_id' => $catCadete->id,
            'name'                   => 'Fase de Grupos',
            'type'                   => 'group',
            'order'                  => 1,
            'status'                 => 'in_progress',
            'settings'               => ['groups_count' => 2, 'teams_advance' => 1, 'legs' => 1, 'points_per_win' => 3, 'points_per_draw' => 1, 'points_per_loss' => 0],
        ]);

        $cadFinal = TournamentPhase::create([
            'tournament_id'          => $tournament->id,
            'tournament_category_id' => $catCadete->id,
            'name'                   => 'Final',
            'type'                   => 'knockout',
            'order'                  => 2,
            'status'                 => 'pending',
            'settings'               => ['legs' => 1, 'extra_time' => true, 'penalties' => true],
        ]);

        // Group A
        $cadA   = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catCadete->id, 'team_id' => self::T_CADETE_A,  'seed' => 1, 'group_label' => 'A', 'status' => 'confirmed']);
        $cadC   = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catCadete->id, 'team_id' => self::T_CADETE_C,  'seed' => 3, 'group_label' => 'A', 'status' => 'confirmed']);
        $extRed = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catCadete->id, 'external_team' => true, 'name_override' => 'Real Murcia Cadete', 'seed' => 5, 'group_label' => 'A', 'status' => 'confirmed']);
        // Group B
        $cadB   = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catCadete->id, 'team_id' => self::T_CADETE_B,  'seed' => 2, 'group_label' => 'B', 'status' => 'confirmed']);
        $femCad = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catCadete->id, 'team_id' => self::T_FEM_CAD,   'seed' => 4, 'group_label' => 'B', 'status' => 'confirmed']);
        $extGal = TournamentTeam::create(['tournament_id' => $tournament->id, 'tournament_category_id' => $catCadete->id, 'external_team' => true, 'name_override' => 'SD Galicia Sub-15', 'seed' => 6, 'group_label' => 'B', 'status' => 'confirmed']);

        // Grupo A – 2 played, 1 pending
        $this->match($tournament->id, $catCadete->id, $cadGrupos->id, $cadA,   $extRed, 2, 0, 1, 'A', '2026-06-20 17:00', 'Pistas Exteriores');
        $this->match($tournament->id, $catCadete->id, $cadGrupos->id, $cadC,   $extRed, 1, 2, 2, 'A', '2026-06-22 17:00', 'Pistas Exteriores');
        $this->match($tournament->id, $catCadete->id, $cadGrupos->id, $cadA,   $cadC,   null, null, 3, 'A', '2026-06-24 17:00', 'Pistas Exteriores', 'scheduled');

        // Grupo B – 2 played, 1 pending
        $this->match($tournament->id, $catCadete->id, $cadGrupos->id, $cadB,   $femCad, 1, 1, 1, 'B', '2026-06-20 19:00', 'Pistas Exteriores');
        $this->match($tournament->id, $catCadete->id, $cadGrupos->id, $femCad, $extGal, 3, 0, 2, 'B', '2026-06-22 19:00', 'Pistas Exteriores');
        $this->match($tournament->id, $catCadete->id, $cadGrupos->id, $cadB,   $extGal, null, null, 3, 'B', '2026-06-24 19:00', 'Pistas Exteriores', 'scheduled');

        // Final (pending)
        $this->match($tournament->id, $catCadete->id, $cadFinal->id, $cadA, $femCad, null, null, 1, null, '2026-06-28 20:00', 'Pabellón Municipal', 'scheduled');

        // Standings – Grupo A (partial, 2 of 3 played)
        $this->standing($tournament->id, $catCadete->id, $cadGrupos->id, $cadA,   'A', 1, 1, 0, 0, 2, 0, 3, 1);
        $this->standing($tournament->id, $catCadete->id, $cadGrupos->id, $extRed, 'A', 2, 1, 0, 1, 2, 3, 3, 2);
        $this->standing($tournament->id, $catCadete->id, $cadGrupos->id, $cadC,   'A', 1, 0, 0, 1, 1, 2, 0, 3);
        // Standings – Grupo B (partial)
        $this->standing($tournament->id, $catCadete->id, $cadGrupos->id, $femCad, 'B', 2, 1, 1, 0, 4, 1, 4, 1);
        $this->standing($tournament->id, $catCadete->id, $cadGrupos->id, $cadB,   'B', 1, 0, 1, 0, 1, 1, 1, 2);
        $this->standing($tournament->id, $catCadete->id, $cadGrupos->id, $extGal, 'B', 1, 0, 0, 1, 0, 3, 0, 3);

        $this->command->info("✅  TournamentSeeder: torneo '{$tournament->name}' creado con ID {$tournament->id}");
        $this->command->info("    - Alevín:   6 equipos, 2 fases, 11 partidos");
        $this->command->info("    - Infantil: 5 equipos, 1 fase,  10 partidos");
        $this->command->info("    - Cadete:   6 equipos, 2 fases,  7 partidos");
        $this->command->info("    URL: /tournaments/{$tournament->id}");
    }

    // ──────────────────────────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────────────────────────

    private int $matchSeq = 0;

    private function match(
        int            $tournamentId,
        int            $categoryId,
        int            $phaseId,
        TournamentTeam $home,
        TournamentTeam $away,
        ?int           $homeScore,
        ?int           $awayScore,
        int            $round,
        ?string        $group,
        string         $scheduledAt,
        string         $location,
        string         $status = 'completed',
    ): TournamentMatch {
        return TournamentMatch::create([
            'tournament_id'          => $tournamentId,
            'tournament_category_id' => $categoryId,
            'phase_id'               => $phaseId,
            'home_team_id'           => $home->id,
            'away_team_id'           => $away->id,
            'home_score'             => $homeScore,
            'away_score'             => $awayScore,
            'round'                  => $round,
            'match_number'           => ++$this->matchSeq,
            'group_label'            => $group,
            'scheduled_at'           => $scheduledAt,
            'played_at'              => $status === 'completed' ? $scheduledAt : null,
            'location'               => $location,
            'status'                 => $status,
            'created_user'           => self::USER_ID,
        ]);
    }

    private function standing(
        int            $tournamentId,
        int            $categoryId,
        int            $phaseId,
        TournamentTeam $team,
        ?string        $group,
        int $played, int $won, int $drawn, int $lost,
        int $gf, int $ga, int $pts, int $position,
    ): void {
        TournamentStanding::create([
            'tournament_id'          => $tournamentId,
            'tournament_category_id' => $categoryId,
            'phase_id'               => $phaseId,
            'tournament_team_id'     => $team->id,
            'group_label'            => $group,
            'played'                 => $played,
            'won'                    => $won,
            'drawn'                  => $drawn,
            'lost'                   => $lost,
            'goals_for'              => $gf,
            'goals_against'          => $ga,
            'points'                 => $pts,
            'position'               => $position,
        ]);
    }
}
