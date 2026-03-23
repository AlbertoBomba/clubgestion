<?php

namespace App\Livewire\Tournaments;

use App\Models\Category;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentCategory;
use App\Models\TournamentMatch;
use App\Models\TournamentPhase;
use App\Models\TournamentStanding;
use App\Models\TournamentTeam;
use Livewire\Component;

class Show extends Component
{
    public Tournament $tournament;

    // ------------------------------------------------------------------
    // Active category
    // ------------------------------------------------------------------
    public ?int $activeCategoryId = null;

    // ------------------------------------------------------------------
    // Tab state
    // ------------------------------------------------------------------
    public string $activeTab = 'overview'; // overview | phases | teams | matches | standings

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
    public string $home_score        = '';
    public string $away_score        = '';
    public string $home_score_extra  = '';
    public string $away_score_extra  = '';
    public string $penalty_winner    = '';
    public string $match_notes       = '';

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
        $this->activeTab        = 'overview';
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
        $this->reset(['editingTeamId', 'team_id', 'external_team', 'name_override', 'team_seed', 'team_group']);
        $this->showTeamModal = true;
    }

    public function openEditTeamModal(int $id): void
    {
        $tt = TournamentTeam::findOrFail($id);
        $this->editingTeamId  = $id;
        $this->team_id        = $tt->team_id;
        $this->external_team  = (bool) $tt->external_team;
        $this->name_override  = $tt->name_override ?? '';
        $this->team_seed      = $tt->seed ? (string) $tt->seed : '';
        $this->team_group     = $tt->group_label ?? '';
        $this->showTeamModal  = true;
    }

    public function saveTeam(): void
    {
        $this->validate([
            'team_id'       => $this->external_team ? 'nullable' : 'nullable|exists:teams,id',
            'name_override' => $this->external_team ? 'required|string|max:255' : 'nullable|string|max:255',
            'team_seed'     => 'nullable|integer|min:1',
            'team_group'    => 'nullable|string|max:50',
        ]);

        $data = [
            'tournament_id'          => $this->tournament->id,
            'tournament_category_id' => $this->activeCategoryId,
            'team_id'                => $this->external_team ? null : ($this->team_id ?: null),
            'external_team'          => $this->external_team,
            'name_override'          => $this->name_override ?: null,
            'seed'                   => $this->team_seed ?: null,
            'group_label'            => $this->team_group ?: null,
            'status'                 => 'registered',
        ];

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

    public function confirmDeleteTeam(int $id): void
    {
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
            'match_status', 'home_score', 'away_score', 'home_score_extra',
            'away_score_extra', 'penalty_winner', 'match_notes',
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
        $this->home_score         = $m->home_score !== null ? (string) $m->home_score : '';
        $this->away_score         = $m->away_score !== null ? (string) $m->away_score : '';
        $this->home_score_extra   = $m->home_score_extra !== null ? (string) $m->home_score_extra : '';
        $this->away_score_extra   = $m->away_score_extra !== null ? (string) $m->away_score_extra : '';
        $this->penalty_winner     = $m->penalty_winner ?? '';
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
            'home_score'       => 'nullable|integer|min:0',
            'away_score'       => 'nullable|integer|min:0',
            'home_score_extra' => 'nullable|integer|min:0',
            'away_score_extra' => 'nullable|integer|min:0',
            'penalty_winner'   => 'nullable|in:home,away',
        ]);

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
            'home_score'             => $this->home_score !== '' ? (int) $this->home_score : null,
            'away_score'             => $this->away_score !== '' ? (int) $this->away_score : null,
            'home_score_extra'       => $this->home_score_extra !== '' ? (int) $this->home_score_extra : null,
            'away_score_extra'       => $this->away_score_extra !== '' ? (int) $this->away_score_extra : null,
            'penalty_winner'         => $this->penalty_winner ?: null,
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
        $this->matchToDelete         = $id;
        $this->confirmingMatchDelete = true;
    }

    public function deleteMatch(): void
    {
        TournamentMatch::findOrFail($this->matchToDelete)->delete();
        $this->confirmingMatchDelete = false;
        $this->matchToDelete         = null;
        $this->tournament->refresh();
        session()->flash('message', 'Partido eliminado correctamente.');
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
    // Render
    // ==================================================================

    public function render()
    {
        $categories = $this->tournament->categories()
            ->withCount(['tournamentTeams', 'phases', 'matches'])
            ->get();

        // Scoped queries — filter everything to the active category
        $phases = $this->activeCategoryId
            ? TournamentPhase::where('tournament_category_id', $this->activeCategoryId)
                ->withCount('matches')
                ->orderBy('order')
                ->get()
            : collect();

        $teams = $this->activeCategoryId
            ? TournamentTeam::where('tournament_category_id', $this->activeCategoryId)
                ->with('team')
                ->orderBy('seed')
                ->orderBy('group_label')
                ->get()
            : collect();

        $matches = $this->activeCategoryId
            ? TournamentMatch::where('tournament_category_id', $this->activeCategoryId)
                ->with(['phase', 'homeTeam.team', 'awayTeam.team'])
                ->orderBy('phase_id')
                ->orderBy('round')
                ->orderBy('match_number')
                ->orderBy('scheduled_at')
                ->get()
            : collect();

        $standings = $this->activeCategoryId
            ? TournamentStanding::where('tournament_category_id', $this->activeCategoryId)
                ->with(['phase', 'tournamentTeam.team'])
                ->orderBy('phase_id')
                ->orderBy('group_label')
                ->orderBy('position')
                ->get()
            : collect();

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

        return view('livewire.tournaments.show', compact(
            'categories', 'activeCategory',
            'phases', 'teams', 'matches', 'standings',
            'schoolTeams', 'schoolCategories'
        ));
    }
}
