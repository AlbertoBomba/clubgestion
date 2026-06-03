<?php

namespace App\Livewire\Tournaments;

use App\Models\Category;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentCategory;
use App\Models\TournamentMatch;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentPhase;
use App\Models\TournamentPlayer;
use App\Models\TournamentStanding;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;
    public Tournament $tournament;

    // ------------------------------------------------------------------
    // Active category
    // ------------------------------------------------------------------
    public ?int $activeCategoryId = null;

    // ------------------------------------------------------------------
    // Active tab
    // ------------------------------------------------------------------
    public string $activeTab = 'matches';

    // ------------------------------------------------------------------
    // Setup panel toggle
    // ------------------------------------------------------------------
    public bool $showSetup = false;

    // ------------------------------------------------------------------
    // Category modal
    // ------------------------------------------------------------------
    public bool   $showCategoryModal   = false;
    public ?int   $editingCategoryId   = null;
    public ?int   $cat_category_id     = null;
    public string $cat_name            = '';
    public int    $cat_order           = 1;
    public string $cat_status          = 'active';

    // ------------------------------------------------------------------
    // Phase modal
    // ------------------------------------------------------------------
    public bool   $showPhaseModal    = false;
    public ?int   $editingPhaseId    = null;
    public string $phase_name        = '';
    public string $phase_type        = 'league';
    public int    $phase_order       = 1;
    public string $phase_status      = 'pending';

    // ------------------------------------------------------------------
    // Team modal
    // ------------------------------------------------------------------
    public bool   $showTeamModal     = false;
    public ?int   $editingTeamId     = null;
    public ?int   $team_id           = null;
    public bool   $external_team     = false;
    public string $name_override     = '';
    public string $team_logo         = '';  // path of existing logo
    public        $team_logo_upload  = null; // TemporaryUploadedFile
    public string $team_contact_name = '';
    public string $team_contact_phone= '';
    public string $team_email        = '';
    public string $team_password     = '';
    public string $team_seed         = '';
    public string $team_group        = '';

    // ------------------------------------------------------------------
    // Match modal
    // ------------------------------------------------------------------
    public bool   $showMatchModal    = false;
    public ?int   $editingMatchId    = null;
    public ?int   $match_phase_id    = null;
    public ?int   $match_home_id     = null;
    public ?int   $match_away_id     = null;
    public string $match_round       = '';
    public string $match_number      = '';
    public string $match_scheduled   = '';
    public string $match_location    = '';
    public string $match_status      = 'scheduled';
    public string $match_notes       = '';

    // ------------------------------------------------------------------
    // Goals modal (enter results via goal scorers)
    // ------------------------------------------------------------------
    public bool   $showGoalsModal    = false;
    public ?int   $goalsMatchId      = null;
    public string $gm_team_id        = '';
    public string $gm_player_id      = '';
    public string $gm_goal_type      = 'normal';
    public string $gm_minute         = '';
    public bool   $gm_showForm       = false;
    public ?int   $gm_deletingGoalId = null;

    // ------------------------------------------------------------------
    // Generate matches modal
    // ------------------------------------------------------------------
    public bool   $showGenerateModal   = false;
    public ?int   $generate_phase_id   = null;
    public int    $generate_legs       = 1;
    public bool   $generate_clear      = false;

    // ------------------------------------------------------------------
    // Delete confirms
    // ------------------------------------------------------------------
    public bool  $confirmingCategoryDelete = false;
    public ?int  $categoryToDelete         = null;
    public bool  $confirmingPhaseDelete    = false;
    public ?int  $phaseToDelete            = null;
    public bool  $confirmingTeamDelete     = false;
    public ?int  $teamToDelete             = null;
    public bool  $confirmingMatchDelete    = false;
    public ?int  $matchToDelete            = null;

    // ------------------------------------------------------------------
    // Postpone match modal
    // ------------------------------------------------------------------
    public bool   $showPostponeModal   = false;
    public ?int   $postponeMatchId     = null;
    public string $postponeDate        = '';

    public function mount(Tournament $tournament): void
    {
        abort_unless($tournament->sports_school_id === auth()->user()->sports_school_id, 403);
        $this->tournament = $tournament;

        // Auto-select first category if one exists
        $first = $tournament->categories()->first();
        if ($first) {
            $this->activeCategoryId = $first->id;
        }
    }

    // ==================================================================
    // Category selection
    // ==================================================================

    public function selectCategory(int $id): void
    {
        $this->activeCategoryId = $id;
    }

    // ==================================================================
    // Category CRUD
    // ==================================================================

    public function openCreateCategoryModal(): void
    {
        $this->reset(['editingCategoryId', 'cat_category_id', 'cat_name', 'cat_status']);
        $this->cat_order         = $this->tournament->categories()->count() + 1;
        $this->showCategoryModal = true;
    }

    public function openEditCategoryModal(int $id): void
    {
        $cat = TournamentCategory::findOrFail($id);
        $this->editingCategoryId = $id;
        $this->cat_category_id   = $cat->category_id;
        $this->cat_name          = $cat->name ?? '';
        $this->cat_order         = $cat->order;
        $this->cat_status        = $cat->status;
        $this->showCategoryModal = true;
    }

    public function saveCategory(): void
    {
        $this->validate([
            'cat_category_id' => 'nullable|exists:categories,id',
            'cat_name'        => 'nullable|string|max:255',
            'cat_order'       => 'required|integer|min:1',
            'cat_status'      => 'required|in:active,completed,cancelled',
        ]);

        $data = [
            'tournament_id' => $this->tournament->id,
            'category_id'   => $this->cat_category_id ?: null,
            'name'          => $this->cat_name ?: null,
            'order'         => $this->cat_order,
            'status'        => $this->cat_status,
        ];

        if ($this->editingCategoryId) {
            TournamentCategory::findOrFail($this->editingCategoryId)->update($data);
            session()->flash('message', 'Categoría actualizada correctamente.');
        } else {
            $newCat = TournamentCategory::create($data);
            $this->activeCategoryId = $newCat->id;
            session()->flash('message', 'Categoría creada correctamente.');
        }

        $this->showCategoryModal = false;
        $this->tournament->refresh();
    }

    public function confirmDeleteCategory(int $id): void
    {
        $this->categoryToDelete         = $id;
        $this->confirmingCategoryDelete = true;
    }

    public function deleteCategory(): void
    {
        TournamentCategory::findOrFail($this->categoryToDelete)->delete();

        if ($this->activeCategoryId === $this->categoryToDelete) {
            $first = $this->tournament->categories()->first();
            $this->activeCategoryId = $first?->id;
        }

        $this->confirmingCategoryDelete = false;
        $this->categoryToDelete         = null;
        $this->tournament->refresh();
        session()->flash('message', 'Categoría eliminada con todos sus datos.');
    }

    // ==================================================================
    // Phase CRUD
    // ==================================================================

    public function openCreatePhaseModal(): void
    {
        $this->reset(['editingPhaseId', 'phase_name', 'phase_type', 'phase_status']);
        $this->phase_order = $this->activeCategoryId
            ? TournamentPhase::where('tournament_category_id', $this->activeCategoryId)->count() + 1
            : 1;
        $this->showPhaseModal = true;
    }

    public function openEditPhaseModal(int $id): void
    {
        $phase = TournamentPhase::findOrFail($id);
        $this->editingPhaseId = $id;
        $this->phase_name     = $phase->name;
        $this->phase_type     = $phase->type;
        $this->phase_order    = $phase->order;
        $this->phase_status   = $phase->status;
        $this->showPhaseModal = true;
    }

    public function savePhase(): void
    {
        $this->validate([
            'phase_name'   => 'required|string|max:255',
            'phase_type'   => 'required|in:league,group,knockout,swiss,double_elimination',
            'phase_order'  => 'required|integer|min:1',
            'phase_status' => 'required|in:pending,in_progress,completed',
        ]);

        if ($this->editingPhaseId) {
            TournamentPhase::findOrFail($this->editingPhaseId)->update([
                'name'   => $this->phase_name,
                'type'   => $this->phase_type,
                'order'  => $this->phase_order,
                'status' => $this->phase_status,
            ]);
            session()->flash('message', 'Fase actualizada correctamente.');
        } else {
            TournamentPhase::create([
                'tournament_id'          => $this->tournament->id,
                'tournament_category_id' => $this->activeCategoryId,
                'name'                   => $this->phase_name,
                'type'                   => $this->phase_type,
                'order'                  => $this->phase_order,
                'status'                 => $this->phase_status,
                'settings'               => TournamentPhase::defaultSettings($this->phase_type),
            ]);
            session()->flash('message', 'Fase creada correctamente.');
        }

        $this->showPhaseModal = false;
        $this->tournament->refresh();
    }

    public function confirmDeletePhase(int $id): void
    {
        $this->phaseToDelete         = $id;
        $this->confirmingPhaseDelete = true;
    }

    public function deletePhase(): void
    {
        TournamentPhase::findOrFail($this->phaseToDelete)->delete();
        $this->confirmingPhaseDelete = false;
        $this->phaseToDelete         = null;
        $this->tournament->refresh();
        session()->flash('message', 'Fase eliminada correctamente.');
    }

    // ==================================================================
    // Team CRUD
    // ==================================================================

    public function openCreateTeamModal(): void
    {
        $this->reset([
            'editingTeamId', 'team_id', 'external_team', 'name_override',
            'team_logo', 'team_logo_upload',
            'team_contact_name', 'team_contact_phone', 'team_email', 'team_password',
            'team_seed', 'team_group',
        ]);
        // Open tournaments only allow external teams
        if ($this->tournament->team_type === 'open') {
            $this->external_team = true;
        }
        $this->showTeamModal = true;
    }

    public function openEditTeamModal(int $id): void
    {
        $tt = TournamentTeam::findOrFail($id);
        $this->editingTeamId       = $id;
        $this->team_id             = $tt->team_id;
        $this->external_team       = (bool) $tt->external_team;
        $this->name_override       = $tt->name_override ?? '';
        $this->team_logo           = $tt->logo ?? '';
        $this->team_logo_upload    = null;
        $this->team_contact_name   = $tt->contact_name ?? '';
        $this->team_contact_phone  = $tt->contact_phone ?? '';
        $this->team_email          = $tt->email ?? '';
        $this->team_password       = '';   // never prefill password
        $this->team_seed           = $tt->seed ? (string) $tt->seed : '';
        $this->team_group          = $tt->group_label ?? '';
        $this->showTeamModal       = true;
    }

    public function saveTeam(): void
    {
        // Open tournaments only allow external teams
        if ($this->tournament->team_type === 'open') {
            $this->external_team = true;
        }

        $isOpen = $this->tournament->team_type === 'open';

        $this->validate([
            'team_id'           => $this->external_team ? 'nullable' : 'nullable|exists:teams,id',
            'name_override'     => $this->external_team ? 'required|string|max:255' : 'nullable|string|max:255',
            'team_logo_upload'  => 'nullable|image|max:2048',
            'team_contact_name' => 'nullable|string|max:255',
            'team_contact_phone'=> 'nullable|string|max:50',
            'team_email'        => $isOpen ? 'required|email|max:255' : 'nullable|email|max:255',
            'team_password'     => $this->editingTeamId ? 'nullable|string|min:6|max:100' : ($isOpen ? 'required|string|min:6|max:100' : 'nullable|string|min:6|max:100'),
            'team_seed'         => 'nullable|integer|min:1',
            'team_group'        => 'nullable|string|max:50',
        ]);

        // Handle logo upload
        $logoPath = $this->team_logo ?: null;
        if ($this->team_logo_upload) {
            // Delete old logo if editing
            if ($this->editingTeamId && $this->team_logo) {
                Storage::disk('public')->delete($this->team_logo);
            }
            $logoPath = $this->team_logo_upload->store('tournament-teams/logos', 'public');
        }

        $data = [
            'tournament_id'          => $this->tournament->id,
            'tournament_category_id' => $isOpen ? null : $this->activeCategoryId,
            'team_id'                => $this->external_team ? null : ($this->team_id ?: null),
            'external_team'          => $this->external_team,
            'name_override'          => $this->name_override ?: null,
            'logo'                   => $logoPath,
            'contact_name'           => $this->team_contact_name ?: null,
            'contact_phone'          => $this->team_contact_phone ?: null,
            'email'                  => $this->team_email ?: null,
            'seed'                   => $this->team_seed ?: null,
            'group_label'            => $this->team_group ?: null,
            'status'                 => 'registered',
        ];

        // Only update password if a new one was provided
        if ($this->team_password !== '') {
            $data['password'] = Hash::make($this->team_password);
        }

        if ($this->editingTeamId) {
            TournamentTeam::findOrFail($this->editingTeamId)->update($data);
            session()->flash('message', 'Equipo actualizado correctamente.');
        } else {
            TournamentTeam::create($data);
            session()->flash('message', 'Equipo añadido al torneo.');
        }

        $this->showTeamModal = false;
        $this->tournament->refresh();
    }

    public function deleteTeamLogo(): void
    {
        if ($this->team_logo) {
            Storage::disk('public')->delete($this->team_logo);
        }
        $this->team_logo = '';
        if ($this->editingTeamId) {
            TournamentTeam::findOrFail($this->editingTeamId)->update(['logo' => null]);
        }
    }

    public function confirmDeleteTeam(int $id): void
    {
        $team = TournamentTeam::withCount('players')->findOrFail($id);

        if ($team->players_count > 0) {
            session()->flash('error', 'No se puede eliminar el equipo: tiene ' . $team->players_count . ' jugador(es) inscrito(s). Elimínalos primero.');
            return;
        }

        $hasCompleted = TournamentMatch::where(function ($q) use ($id) {
            $q->where('home_team_id', $id)->orWhere('away_team_id', $id);
        })->where('status', 'completed')->exists();

        if ($hasCompleted) {
            session()->flash('error', 'No se puede eliminar el equipo: tiene partidos finalizados asociados.');
            return;
        }

        $this->teamToDelete         = $id;
        $this->confirmingTeamDelete = true;
    }

    public function deleteTeam(): void
    {
        TournamentTeam::findOrFail($this->teamToDelete)->delete();
        $this->confirmingTeamDelete = false;
        $this->teamToDelete         = null;
        $this->tournament->refresh();
        session()->flash('message', 'Equipo eliminado del torneo.');
    }

    // ==================================================================
    // Match CRUD
    // ==================================================================

    public function openCreateMatchModal(): void
    {
        $this->reset([
            'editingMatchId', 'match_phase_id', 'match_home_id', 'match_away_id',
            'match_round', 'match_number', 'match_scheduled', 'match_location',
            'match_status', 'match_notes',
        ]);
        $this->match_status   = 'scheduled';
        $this->showMatchModal = true;
    }

    public function openEditMatchModal(int $id): void
    {
        $m = TournamentMatch::findOrFail($id);
        $this->editingMatchId     = $id;
        $this->match_phase_id     = $m->phase_id;
        $this->match_home_id      = $m->home_team_id;
        $this->match_away_id      = $m->away_team_id;
        $this->match_round        = $m->round ?? '';
        $this->match_number       = $m->match_number ? (string) $m->match_number : '';
        $this->match_scheduled    = $m->scheduled_at?->format('Y-m-d\TH:i') ?? '';
        $this->match_location     = $m->location ?? '';
        $this->match_status       = $m->status;
        $this->match_notes        = $m->notes ?? '';
        $this->showMatchModal     = true;
    }

    public function saveMatch(): void
    {
        $this->validate([
            'match_phase_id'   => 'nullable|exists:tournament_phases,id',
            'match_home_id'    => 'required|exists:tournament_teams,id',
            'match_away_id'    => 'required|exists:tournament_teams,id|different:match_home_id',
            'match_round'      => 'nullable|string|max:100',
            'match_number'     => 'nullable|integer|min:1',
            'match_scheduled'  => 'nullable|date',
            'match_location'   => 'nullable|string|max:255',
            'match_status'     => 'required|in:scheduled,in_progress,completed,cancelled,postponed',
        ]);

        // Validate: a team cannot appear twice in the same round
        if ($this->match_round !== '') {
            $conflict = TournamentMatch::where('tournament_id', $this->tournament->id)
                ->where('round', $this->match_round)
                ->when($this->match_phase_id, fn ($q) => $q->where('phase_id', $this->match_phase_id))
                ->when($this->editingMatchId, fn ($q) => $q->where('id', '!=', $this->editingMatchId))
                ->where(function ($q) {
                    $q->whereIn('home_team_id', [$this->match_home_id, $this->match_away_id])
                      ->orWhereIn('away_team_id', [$this->match_home_id, $this->match_away_id]);
                })
                ->with(['homeTeam', 'awayTeam'])
                ->first();

            if ($conflict) {
                $conflictTeams = collect();
                if (in_array($conflict->home_team_id, [$this->match_home_id, $this->match_away_id])) {
                    $conflictTeams->push($conflict->homeTeam?->displayName());
                }
                if (in_array($conflict->away_team_id, [$this->match_home_id, $this->match_away_id])) {
                    $conflictTeams->push($conflict->awayTeam?->displayName());
                }
                $teamNames = $conflictTeams->filter()->unique()->implode(' y ');
                session()->flash('error', "No se puede guardar: {$teamNames} ya tiene un partido en la Jornada {$this->match_round}.");
                return;
            }
        }

        $user = auth()->user();
        $data = [
            'tournament_id'          => $this->tournament->id,
            'tournament_category_id' => $this->activeCategoryId,
            'phase_id'               => $this->match_phase_id ?: null,
            'home_team_id'           => $this->match_home_id,
            'away_team_id'           => $this->match_away_id,
            'round'                  => $this->match_round ?: null,
            'match_number'           => $this->match_number ?: null,
            'scheduled_at'           => $this->match_scheduled ?: null,
            'location'               => $this->match_location ?: null,
            'status'                 => $this->match_status,
            'notes'                  => $this->match_notes ?: null,
        ];

        if ($this->editingMatchId) {
            TournamentMatch::findOrFail($this->editingMatchId)->update(
                array_merge($data, ['updated_user' => $user->id])
            );
            session()->flash('message', 'Partido actualizado correctamente.');
        } else {
            TournamentMatch::create(
                array_merge($data, [
                    'created_user' => $user->id,
                    'played_at'    => $this->match_status === 'completed' ? now() : null,
                ])
            );
            session()->flash('message', 'Partido creado correctamente.');
        }

        $this->showMatchModal = false;
        $this->tournament->refresh();
    }

    public function confirmDeleteMatch(int $id): void
    {
        $match = TournamentMatch::findOrFail($id);

        if ($match->status === 'completed' && (($match->home_score ?? 0) + ($match->away_score ?? 0)) > 0) {
            session()->flash('error', 'No se puede eliminar este partido: está finalizado y tiene goles registrados.');
            return;
        }

        $this->matchToDelete         = $id;
        $this->confirmingMatchDelete = true;
    }

    public function deleteMatch(): void
    {
        $match = TournamentMatch::findOrFail($this->matchToDelete);

        if ($match->status === 'completed' && (($match->home_score ?? 0) + ($match->away_score ?? 0)) > 0) {
            session()->flash('error', 'No se puede eliminar este partido: está finalizado y tiene goles registrados.');
            $this->confirmingMatchDelete = false;
            $this->matchToDelete         = null;
            return;
        }

        $match->delete();
        $this->confirmingMatchDelete = false;
        $this->matchToDelete         = null;
        $this->tournament->refresh();
        session()->flash('message', 'Partido eliminado correctamente.');
    }

    public function openPostponeModal(int $id): void
    {
        $match = TournamentMatch::findOrFail($id);
        abort_unless(in_array($match->status, ['scheduled', 'postponed', 'in_progress']), 403);

        $this->postponeMatchId   = $id;
        $this->postponeDate      = $match->scheduled_at?->format('Y-m-d\\TH:i') ?? '';
        $this->showPostponeModal = true;
    }

    public function postponeMatch(): void
    {
        $this->validate(['postponeDate' => 'nullable|date']);

        TournamentMatch::findOrFail($this->postponeMatchId)->update([
            'status'       => 'postponed',
            'scheduled_at' => $this->postponeDate ?: null,
        ]);

        $this->showPostponeModal = false;
        $this->postponeMatchId   = null;
        $this->postponeDate      = '';
        $this->tournament->refresh();
        session()->flash('message', 'Partido aplazado correctamente.');
    }

    // ==================================================================
    // Generate matches (random draw)
    // ==================================================================

    public function openGenerateMatchesModal(): void
    {
        $this->reset(['generate_phase_id', 'generate_clear']);
        $this->generate_legs = 1;
        $this->showGenerateModal = true;
    }

    public function generateMatches(): void
    {
        
        $this->validate([
            'generate_phase_id' => 'required|exists:tournament_phases,id',
            'generate_legs'     => 'required|in:1,2',
        ]);

        $phase = TournamentPhase::findOrFail($this->generate_phase_id);
        abort_unless($phase->tournament_id === $this->tournament->id, 403);

        if ($this->generate_clear) {
            TournamentMatch::where('phase_id', $phase->id)->delete();
        }
        
        $teamsQuery = TournamentTeam::where('tournament_id', $this->tournament->id);

        $isOpen     = $this->tournament->team_type === 'open';
        $categoryId = $isOpen ? null : ($phase->tournament_category_id ?? $this->activeCategoryId);

        if (!$isOpen && $categoryId) {
            $teamsQuery->where('tournament_category_id', $categoryId);
        }

        $teams = $teamsQuery->get()->shuffle()->values();

        if ($teams->count() < 2) {
            session()->flash('error', 'Se necesitan al menos 2 equipos para generar partidos.');
            $this->showGenerateModal = false;
            return;
        }

        $user        = auth()->id();
        $matchNumber = TournamentMatch::where('phase_id', $phase->id)->max('match_number') ?? 0;
        $count       = 0;
        $legs        = (int) $this->generate_legs;

        if (in_array($phase->type, ['knockout', 'double_elimination'])) {
            // Bracket: 1º vs último, 2º vs penúltimo...
            for ($i = 0; $i < intdiv($teams->count(), 2); $i++) {
                $matchNumber++;
                TournamentMatch::create([
                    'tournament_id'          => $this->tournament->id,
                    'tournament_category_id' => $categoryId,
                    'phase_id'               => $phase->id,
                    'home_team_id'           => $teams[$i]->id,
                    'away_team_id'           => $teams[$teams->count() - 1 - $i]->id,
                    'round'                  => 1,
                    'match_number'           => $matchNumber,
                    'status'                 => 'scheduled',
                    'created_user'           => $user,
                ]);
                $count++;
            }
        } elseif ($phase->type === 'group') {
            // Round-robin completo de todos los equipos juntos (berger).
            // El group_label de cada equipo se usa para la clasificación pero
            // no limita los enfrentamientos del calendario.
            $rounds = $this->buildRoundRobin($teams->all(), $legs);
            foreach ($rounds as $round => $pairs) {
                foreach ($pairs as [$home, $away]) {
                    $matchNumber++;
                    TournamentMatch::create([
                        'tournament_id'          => $this->tournament->id,
                        'tournament_category_id' => $categoryId,
                        'phase_id'               => $phase->id,
                        'home_team_id'           => $home->id,
                        'away_team_id'           => $away->id,
                        'round'                  => $round,
                        'match_number'           => $matchNumber,
                        'status'                 => 'scheduled',
                        'created_user'           => $user,
                    ]);
                    $count++;
                }
            }
        } else {
            // Liga / suizo: round-robin completo con algoritmo berger
            $rounds = $this->buildRoundRobin($teams->all(), $legs);
            foreach ($rounds as $round => $pairs) {
                foreach ($pairs as [$home, $away]) {
                    $matchNumber++;
                    TournamentMatch::create([
                        'tournament_id'          => $this->tournament->id,
                        'tournament_category_id' => $categoryId,
                        'phase_id'               => $phase->id,
                        'home_team_id'           => $home->id,
                        'away_team_id'           => $away->id,
                        'round'                  => $round,
                        'match_number'           => $matchNumber,
                        'status'                 => 'scheduled',
                        'created_user'           => $user,
                    ]);
                    $count++;
                }
            }
        }

        $this->showGenerateModal = false;
        $this->tournament->refresh();
        $teamCount  = $teams->count();
        $n          = $teamCount % 2 === 0 ? $teamCount : $teamCount + 1;
        $roundCount = ($n - 1) * $legs;
        session()->flash('message', "{$count} partidos generados en {$roundCount} jornadas ({$teamCount} equipos).");
    }

    /**
     * Algoritmo berger (circle method) para calendarios de liga.
     * Devuelve [ jornada => [ [local, visitante], ... ] ]
     * Para n impar añade un bye fantasma que se descarta.
     */
    private function buildRoundRobin(array $teamList, int $legs): array
    {
        $n = count($teamList);
        if ($n % 2 !== 0) {
            $teamList[] = null; // bye
            $n++;
        }

        $half     = $n / 2;
        $fixed    = $teamList[0];
        $rotating = array_slice($teamList, 1);
        $rounds   = [];

        for ($round = 1; $round <= $n - 1; $round++) {
            $circle = array_merge([$fixed], $rotating);
            $pairs  = [];
            for ($i = 0; $i < $half; $i++) {
                $home = $circle[$i];
                $away = $circle[$n - 1 - $i];
                if ($home !== null && $away !== null) {
                    // Alternar local/visitante por ronda para equilibrar
                    $pairs[] = $round % 2 === 0 ? [$away, $home] : [$home, $away];
                }
            }
            $rounds[$round] = $pairs;
            // Rotación: el último elemento pasa al principio del array giratorio
            array_unshift($rotating, array_pop($rotating));
        }

        // Segunda vuelta: los mismos emparejamientos con local/visitante invertidos
        if ($legs === 2) {
            for ($round = 1; $round <= $n - 1; $round++) {
                $rounds[$round + ($n - 1)] = array_map(fn($p) => [$p[1], $p[0]], $rounds[$round]);
            }
        }

        return $rounds;
    }

    // ==================================================================
    // Standings recalculation
    // ==================================================================

    public function recalculateStandings(?int $phaseId = null): void
    {
        $phasesQuery = $this->activeCategoryId
            ? TournamentPhase::where('tournament_category_id', $this->activeCategoryId)
            : $this->tournament->phases();

        $phases = $phaseId
            ? $phasesQuery->where('id', $phaseId)->get()
            : $phasesQuery->whereIn('type', ['league', 'group'])->get();

        $settings = $this->tournament->settings ?? [];
        $ptWin    = $settings['points_per_win']  ?? 3;
        $ptDraw   = $settings['points_per_draw'] ?? 1;
        $ptLoss   = $settings['points_per_loss'] ?? 0;

        foreach ($phases as $phase) {
            $teamIds = TournamentTeam::where('tournament_category_id', $phase->tournament_category_id)
                ->pluck('id');

            TournamentStanding::where('phase_id', $phase->id)->delete();

            $stats = [];
            foreach ($teamIds as $ttId) {
                $stats[$ttId] = [
                    'played' => 0, 'won' => 0, 'drawn' => 0, 'lost' => 0,
                    'goals_for' => 0, 'goals_against' => 0, 'points' => 0,
                    'group_label' => null,
                ];
            }

            $matches = TournamentMatch::where('phase_id', $phase->id)
                ->where('status', 'completed')
                ->whereNotNull('home_score')
                ->whereNotNull('away_score')
                ->get();

            foreach ($matches as $match) {
                $h = $match->home_team_id;
                $a = $match->away_team_id;

                if (! isset($stats[$h])) {
                    $stats[$h] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,'group_label'=>null];
                }
                if (! isset($stats[$a])) {
                    $stats[$a] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,'group_label'=>null];
                }

                $hScore = $match->home_score;
                $aScore = $match->away_score;

                $stats[$h]['played']++;
                $stats[$a]['played']++;
                $stats[$h]['goals_for']     += $hScore;
                $stats[$h]['goals_against'] += $aScore;
                $stats[$a]['goals_for']     += $aScore;
                $stats[$a]['goals_against'] += $hScore;

                if ($hScore > $aScore) {
                    $stats[$h]['won']++;   $stats[$h]['points'] += $ptWin;
                    $stats[$a]['lost']++;  $stats[$a]['points'] += $ptLoss;
                } elseif ($hScore === $aScore) {
                    $stats[$h]['drawn']++; $stats[$h]['points'] += $ptDraw;
                    $stats[$a]['drawn']++; $stats[$a]['points'] += $ptDraw;
                } else {
                    $stats[$h]['lost']++;  $stats[$h]['points'] += $ptLoss;
                    $stats[$a]['won']++;   $stats[$a]['points'] += $ptWin;
                }
            }

            uasort($stats, function ($a, $b) {
                if ($b['points'] !== $a['points']) return $b['points'] <=> $a['points'];
                $gdA = $a['goals_for'] - $a['goals_against'];
                $gdB = $b['goals_for'] - $b['goals_against'];
                if ($gdB !== $gdA) return $gdB <=> $gdA;
                return $b['goals_for'] <=> $a['goals_for'];
            });

            $position = 1;
            foreach ($stats as $ttId => $row) {
                TournamentStanding::create([
                    'tournament_id'          => $this->tournament->id,
                    'tournament_category_id' => $phase->tournament_category_id,
                    'phase_id'               => $phase->id,
                    'tournament_team_id'     => $ttId,
                    'group_label'        => $row['group_label'],
                    'played'             => $row['played'],
                    'won'                => $row['won'],
                    'drawn'              => $row['drawn'],
                    'lost'               => $row['lost'],
                    'goals_for'          => $row['goals_for'],
                    'goals_against'      => $row['goals_against'],
                    'points'             => $row['points'],
                    'position'           => $position++,
                ]);
            }
        }

        $this->tournament->refresh();
        session()->flash('message', 'Clasificaciones recalculadas correctamente.');
    }

    public function updateTournamentStatus(string $status): void
    {
        $this->tournament->update([
            'status'       => $status,
            'updated_user' => auth()->id(),
        ]);
        $this->tournament->refresh();
        session()->flash('message', 'Estado del torneo actualizado.');
    }

    // ==================================================================
    // Goals Modal — enter match results via goal scorers
    // ==================================================================

    public function openGoalsModal(int $matchId): void
    {
        $match = TournamentMatch::findOrFail($matchId);
        abort_unless($match->tournament_id === $this->tournament->id, 403);
        $this->goalsMatchId      = $matchId;
        $this->gm_showForm       = false;
        $this->gm_deletingGoalId = null;
        $this->gm_goal_type      = 'normal';
        $this->reset(['gm_team_id', 'gm_player_id', 'gm_minute']);
        $this->showGoalsModal    = true;
    }

    public function closeGoalsModal(): void
    {
        $this->showGoalsModal    = false;
        $this->goalsMatchId      = null;
        $this->gm_showForm       = false;
        $this->gm_deletingGoalId = null;
    }

    public function gmToggleForm(): void
    {
        $this->gm_showForm  = ! $this->gm_showForm;
        $this->gm_goal_type = 'normal';
        $this->reset(['gm_team_id', 'gm_player_id', 'gm_minute']);
    }

    public function gmAddGoal(): void
    {
        $this->validate([
            'gm_team_id'   => 'required|exists:tournament_teams,id',
            'gm_player_id' => 'required|exists:tournament_players,id',
            'gm_goal_type' => 'required|in:normal,penalty,own_goal',
            'gm_minute'    => 'nullable|integer|min:1|max:180',
        ]);

        TournamentMatchGoal::create([
            'tournament_match_id'  => $this->goalsMatchId,
            'tournament_player_id' => (int) $this->gm_player_id,
            'tournament_team_id'   => (int) $this->gm_team_id,
            'goal_type'            => $this->gm_goal_type,
            'minute'               => $this->gm_minute !== '' ? (int) $this->gm_minute : null,
        ]);

        $this->recalculateMatchScore($this->goalsMatchId);
        $this->gm_goal_type = 'normal';
        $this->reset(['gm_team_id', 'gm_player_id', 'gm_minute']);
        $this->gm_showForm = false;
        $this->tournament->refresh();
    }

    public function gmConfirmDeleteGoal(int $id): void
    {
        $this->gm_deletingGoalId = $id;
    }

    public function gmCancelDeleteGoal(): void
    {
        $this->gm_deletingGoalId = null;
    }

    public function gmDeleteGoal(): void
    {
        TournamentMatchGoal::where('id', $this->gm_deletingGoalId)
            ->where('tournament_match_id', $this->goalsMatchId)
            ->delete();

        $this->gm_deletingGoalId = null;
        $this->recalculateMatchScore($this->goalsMatchId);
        $this->tournament->refresh();
    }

    private function recalculateMatchScore(int $matchId): void
    {
        $match = TournamentMatch::with('phase')->findOrFail($matchId);
        $goals = TournamentMatchGoal::where('tournament_match_id', $matchId)->get();

        $homeScore = $goals->filter(
                fn($g) => $g->tournament_team_id === $match->home_team_id && $g->goal_type !== 'own_goal'
            )->count()
            + $goals->filter(
                fn($g) => $g->tournament_team_id === $match->away_team_id && $g->goal_type === 'own_goal'
            )->count();

        $awayScore = $goals->filter(
                fn($g) => $g->tournament_team_id === $match->away_team_id && $g->goal_type !== 'own_goal'
            )->count()
            + $goals->filter(
                fn($g) => $g->tournament_team_id === $match->home_team_id && $g->goal_type === 'own_goal'
            )->count();

        $match->update([
            'home_score'   => $homeScore,
            'away_score'   => $awayScore,
            'status'       => $goals->isNotEmpty() ? 'completed' : $match->status,
            'played_at'    => ($goals->isNotEmpty() && ! $match->played_at) ? now() : $match->played_at,
            'updated_user' => auth()->id(),
        ]);

        if ($match->phase && in_array($match->phase->type, ['league', 'group'])) {
            $this->recalculateStandings($match->phase_id);
        }
    }

    // ==================================================================
    // Render
    // ==================================================================

    public function render()
    {
        $categories = $this->tournament->categories()
            ->withCount(['tournamentTeams', 'phases', 'matches'])
            ->get();

        // Scoped queries — filter by active category, or fetch all for open tournaments
        $isOpen = $this->tournament->team_type === 'open';

        $phases = ($this->activeCategoryId || $isOpen)
            ? TournamentPhase::where('tournament_id', $this->tournament->id)
                ->when(!$isOpen, fn ($q) => $q->where('tournament_category_id', $this->activeCategoryId))
                ->withCount('matches')
                ->orderBy('order')
                ->get()
            : collect();

        $teams = ($this->activeCategoryId || $isOpen)
            ? TournamentTeam::where('tournament_id', $this->tournament->id)
                ->when(!$isOpen, fn ($q) => $q->where('tournament_category_id', $this->activeCategoryId))
                ->with('team')
                ->orderBy('seed')
                ->orderBy('group_label')
                ->get()
            : collect();

        $matches = ($this->activeCategoryId || $isOpen)
            ? TournamentMatch::where('tournament_id', $this->tournament->id)
                ->when(!$isOpen, fn ($q) => $q->where('tournament_category_id', $this->activeCategoryId))
                ->with(['phase', 'homeTeam.team', 'awayTeam.team'])
                ->orderByRaw('scheduled_at IS NULL ASC')
                ->orderBy('scheduled_at')
                ->orderBy('phase_id')
                ->orderBy('round')
                ->orderBy('match_number')
                ->get()
            : collect();

        $standings = ($this->activeCategoryId || $isOpen)
            ? TournamentStanding::where('tournament_id', $this->tournament->id)
                ->when(!$isOpen, fn ($q) => $q->where('tournament_category_id', $this->activeCategoryId))
                ->with(['phase', 'tournamentTeam.team'])
                ->orderBy('phase_id')
                ->orderBy('group_label')
                ->orderBy('position')
                ->get()
            : collect();

        // Detect if any phase is a league/group type (requires standings to always be visible)
        $hasLeaguePhase = $phases->contains(fn ($p) => in_array($p->type, ['league', 'group']));

        // School teams — narrow to the active category's age group when possible
        $activeCategory = $categories->firstWhere('id', $this->activeCategoryId);
        $schoolTeams = Team::whereHas('season', function ($query) {
                $query->where('sports_school_id', auth()->user()->sports_school_id);
            })
            ->when($activeCategory?->category_id, function ($query) use ($activeCategory) {
                $query->where('category_id', $activeCategory->category_id);
            })
            ->orderBy('team')
            ->get();

        $schoolCategories = Category::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('category')
            ->get();

        // Goals modal data
        $goalsModalMatch = $this->goalsMatchId
            ? TournamentMatch::with(['homeTeam.team', 'awayTeam.team'])->find($this->goalsMatchId)
            : null;
        $goalsForModal = $this->goalsMatchId
            ? TournamentMatchGoal::where('tournament_match_id', $this->goalsMatchId)
                ->with(['player', 'team'])
                ->orderBy('minute')
                ->get()
            : collect();
        $gmTeamPlayers = $this->gm_team_id
            ? TournamentPlayer::where('tournament_team_id', $this->gm_team_id)
                ->orderBy('surname')->orderBy('name')->get()
            : collect();
        $gmMatchTeams = $goalsModalMatch
            ? TournamentTeam::whereIn('id', array_filter([
                $goalsModalMatch->home_team_id,
                $goalsModalMatch->away_team_id,
              ]))->with('team')->get()
            : collect();

        return view('livewire.tournaments.show', compact(
            'categories', 'activeCategory',
            'phases', 'teams', 'matches', 'standings', 'hasLeaguePhase',
            'schoolTeams', 'schoolCategories',
            'goalsModalMatch', 'goalsForModal', 'gmTeamPlayers', 'gmMatchTeams'
        ));
    }
}
