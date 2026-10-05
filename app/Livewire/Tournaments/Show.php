<?php

namespace App\Livewire\Tournaments;

use App\Models\Category;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentCategory;
use App\Models\TournamentMatch;
use App\Models\TournamentMatchCard;
use App\Models\TournamentMatchGoal;
use App\Models\TournamentPhase;
use App\Models\TournamentSanction;
use App\Models\TournamentPlayer;
use App\Models\TournamentStanding;
use App\Models\TournamentTeam;
use App\Models\User;
use App\Services\RecentTournamentTeams;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Traits\DetectsDevice;

class Show extends Component
{
    use WithFileUploads;
    use DetectsDevice;
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
    public string $teamCreationMode = 'new';
    public array $selectedRecentTeamIds = [];

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
    public bool   $gm_showForm       = true;
    public ?int   $gm_deletingGoalId = null;
    public string $gm_action         = 'goal';   // 'goal' | 'card'
    public string $gm_player_search  = '';
    public string $gm_card_type      = 'yellow';
    public string $gm_card_minute    = '';
    public ?int   $gm_deletingCardId = null;

    // ------------------------------------------------------------------
    // Generate matches modal
    // ------------------------------------------------------------------
    public bool   $showGenerateModal   = false;
    public ?int   $generate_phase_id   = null;
    public int    $generate_legs       = 1;
    public bool   $generate_clear      = false;
    // Nº de equipos participantes en la liguilla (null = todos los disponibles)
    public ?int   $generate_team_count = null;

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

    // ------------------------------------------------------------------
    // Referees modal
    // ------------------------------------------------------------------
    public bool   $showRefereesModal   = false;
    public array  $selectedReferees    = [];

    // ------------------------------------------------------------------
    // Bracket / Knockout modal
    // ------------------------------------------------------------------
    public bool   $showBracketModal     = false;
    public ?int   $bracketPhaseId       = null;
    public array  $bracketSelectedTeams = [];
    public array  $bracketPairings      = [];
    public bool   $bracketClearExisting = false;
    public bool   $bracketThirdPlace    = false;
    public int    $bracketRoundCount    = 2;  // 1=Final, 2=Semi+Final, 3=Cuartos+…, 4=Octavos+…, 5=16avos+…

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
            'teamCreationMode',
            'selectedRecentTeamIds',
        ]);
        $this->resetValidation();
        // Open tournaments only allow external teams
        if ($this->tournament->team_type === 'open') {
            $this->external_team = true;
        }
        $this->showTeamModal = true;
    }

    public function openEditTeamModal(int $id): void
    {
        $this->teamCreationMode = 'new';
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
            'team_email'        => $isOpen ? 'email|max:255' : 'nullable|email|max:255',
            'team_password'     => $this->editingTeamId ? 'nullable|string|min:6|max:100' : ($isOpen ? 'string|min:6|max:100' : 'nullable|string|min:6|max:100'),
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

    public function addRecentTeam(int $sourceId): void
    {
        $this->selectedRecentTeamIds = [$sourceId];
        $this->addSelectedRecentTeams();
    }

    public function addSelectedRecentTeams(): void
    {
        abort_unless(auth()->user()?->sports_school_id === $this->tournament->sports_school_id, 403);
        abort_if($this->editingTeamId !== null, 403);
        $this->validate([
            'selectedRecentTeamIds' => 'required|array|min:1',
            'selectedRecentTeamIds.*' => 'required|integer|distinct|min:1',
        ], [
            'selectedRecentTeamIds.required' => 'Selecciona al menos un equipo.',
            'selectedRecentTeamIds.min' => 'Selecciona al menos un equipo.',
        ]);

        if ($this->tournament->team_type !== 'open') {
            if (!$this->activeCategoryId) {
                $this->addError('recentTeam', 'Selecciona una categoría antes de añadir un equipo.');
                return;
            }
            $this->tournament->categories()->findOrFail($this->activeCategoryId);
        }

        $copies = app(RecentTournamentTeams::class)->importMany(
            $this->tournament, $this->activeCategoryId, $this->selectedRecentTeamIds
        );
        $this->selectedRecentTeamIds = [];
        $this->resetValidation();
        $this->tournament->refresh();
        session()->flash('message', $copies->count() . ' equipo(s) añadido(s) con sus datos y acceso, sin grupo ni jugadores.');
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
            'match_home_id'    => 'nullable|exists:tournament_teams,id',
            'match_away_id'    => 'nullable|exists:tournament_teams,id|different:match_home_id',
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
        $this->reset(['generate_phase_id', 'generate_clear', 'generate_team_count']);
        $this->generate_legs = 1;
        $this->showGenerateModal = true;
    }

    public function generateMatches(): void
    {
        
        $this->validate([
            'generate_phase_id'   => 'required|exists:tournament_phases,id',
            'generate_legs'       => 'required|in:1,2',
            'generate_team_count' => 'nullable|integer|min:2',
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

        // Para fases tipo liga (liguilla): el usuario puede indicar un subconjunto
        // de equipos. Si lo hace, generamos el calendario de huecos sin asignar
        // equipos (home_team_id/away_team_id = null) para rellenarlos a mano.
        $isLeagueSubset = $phase->type === 'league'
            && $this->generate_team_count !== null
            && $this->generate_team_count >= 2
            && $this->generate_team_count < $teams->count();

        if ($isLeagueSubset) {
            // Validar que no se piden más equipos de los disponibles
            if ($this->generate_team_count > $teams->count()) {
                session()->flash('error', 'No hay suficientes equipos disponibles.');
                $this->showGenerateModal = false;
                return;
            }

            // Guardar nº de participantes en los settings de la fase para que
            // la clasificación sepa cuántas plazas «por definir» mostrar.
            $phaseSettings = $phase->settings ?? [];
            $phaseSettings['league_participants_count'] = (int) $this->generate_team_count;
            $phase->update(['settings' => $phaseSettings]);

            // Slots marcadores (1..N) solo para construir el calendario
            $slots  = range(1, $this->generate_team_count);
            $rounds = $this->buildRoundRobin($slots, $legs);
            foreach ($rounds as $round => $pairs) {
                foreach ($pairs as $pair) {
                    $matchNumber++;
                    TournamentMatch::create([
                        'tournament_id'          => $this->tournament->id,
                        'tournament_category_id' => $categoryId,
                        'phase_id'               => $phase->id,
                        'home_team_id'           => null,
                        'away_team_id'           => null,
                        'round'                  => $round,
                        'match_number'           => $matchNumber,
                        'status'                 => 'scheduled',
                        'created_user'           => $user,
                    ]);
                    $count++;
                }
            }

            // Recalcular clasificación para dejar los huecos sincronizados.
            $this->recalculateStandings($phase->id);
            session()->forget('message');

            $this->showGenerateModal = false;
            $this->tournament->refresh();
            $n          = $this->generate_team_count % 2 === 0 ? $this->generate_team_count : $this->generate_team_count + 1;
            $roundCount = ($n - 1) * $legs;
            session()->flash('message', "{$count} partidos generados en {$roundCount} jornadas (sin equipos asignados; asígnalos manualmente).");
            return;
        }

        // Al regenerar como liga «completa» limpiamos el flag de subset.
        if ($phase->type === 'league' && !empty($phase->settings['league_participants_count'])) {
            $phaseSettings = $phase->settings ?? [];
            unset($phaseSettings['league_participants_count']);
            $phase->update(['settings' => $phaseSettings]);
        }

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
            // Fase de grupos: sólo se enfrentan equipos del mismo group_label.
            $ungrouped = $teams->filter(fn($t) => blank($t->group_label));
            if ($ungrouped->isNotEmpty()) {
                session()->flash('error', 'Todos los equipos deben tener un grupo asignado antes de generar los partidos de la fase de grupos.');
                $this->showGenerateModal = false;
                return;
            }

            $groups = $teams->groupBy(fn($t) => (string) $t->group_label)->sortKeys();

            $validGroups = $groups->filter(fn($g) => $g->count() >= 2);
            if ($validGroups->isEmpty()) {
                session()->flash('error', 'Cada grupo necesita al menos 2 equipos para generar partidos.');
                $this->showGenerateModal = false;
                return;
            }

            foreach ($validGroups as $groupLabel => $groupTeams) {
                $rounds = $this->buildRoundRobin($groupTeams->values()->all(), $legs);
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
        $teamCount = $teams->count();
        if ($phase->type === 'group') {
            $groupCount = $teams->filter(fn($t) => filled($t->group_label))
                ->groupBy(fn($t) => (string) $t->group_label)
                ->filter(fn($g) => $g->count() >= 2)
                ->count();
            session()->flash('message', "{$count} partidos generados en {$groupCount} grupos ({$teamCount} equipos).");
        } else {
            $n          = $teamCount % 2 === 0 ? $teamCount : $teamCount + 1;
            $roundCount = ($n - 1) * $legs;
            session()->flash('message', "{$count} partidos generados en {$roundCount} jornadas ({$teamCount} equipos).");
        }
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

            if($this->tournament->team_type === 'open'){
                $phaseTeams = TournamentTeam::where('tournament_id', $this->tournament->id)
                    ->get(['id', 'group_label']);
            } elseif($this->tournament->team_type === 'school_teams') {
                $phaseTeams = TournamentTeam::where('tournament_category_id', $phase->tournament_category_id)
                    ->get(['id', 'group_label']);
            } else {
                $phaseTeams = collect();
            }

            // Para ligas con subset de equipos: solo incluir en la clasificación
            // los equipos que ya se hayan asignado a algún partido de esta fase.
            $subsetCount = ($phase->type === 'league')
                ? ($phase->settings['league_participants_count'] ?? null)
                : null;
            if ($subsetCount) {
                $assignedTeamIds = TournamentMatch::where('phase_id', $phase->id)
                    ->where(function ($q) {
                        $q->whereNotNull('home_team_id')->orWhereNotNull('away_team_id');
                    })
                    ->get(['home_team_id', 'away_team_id'])
                    ->flatMap(fn ($m) => [$m->home_team_id, $m->away_team_id])
                    ->filter()
                    ->unique()
                    ->values();
                $phaseTeams = $phaseTeams->whereIn('id', $assignedTeamIds);
            }

            $isGroupPhase = $phase->type === 'group';
            $teamGroupMap = $phaseTeams->pluck('group_label', 'id')->all();

            // dd($phase->id);
            TournamentStanding::where('phase_id', $phase->id)->delete();

            $stats = [];
            foreach ($phaseTeams as $tt) {
                $stats[$tt->id] = [
                    'played' => 0, 'won' => 0, 'drawn' => 0, 'lost' => 0,
                    'goals_for' => 0, 'goals_against' => 0, 'points' => 0,
                    'group_label' => $isGroupPhase ? ($tt->group_label ?: null) : null,
                ];
            }

            $matches = TournamentMatch::where('phase_id', $phase->id)
                ->where(function ($q) {
                    // Partidos finalizados o con marcador registrado (incluye 0-0).
                    $q->where('status', 'completed')
                      ->orWhere(function ($q2) {
                          $q2->whereNotNull('home_score')->whereNotNull('away_score');
                      });
                })
                ->get();

            // dd($matches);

            foreach ($matches as $match) {
                // dd($match."entra");
                $h = $match->home_team_id;
                $a = $match->away_team_id;

                // Si falta algún equipo (hueco de subset), no cuenta.
                if (! $h || ! $a) {
                    continue;
                }

                if (! isset($stats[$h])) {
                    $stats[$h] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,
                        'group_label' => $isGroupPhase ? ($teamGroupMap[$h] ?? null) : null];
                }
                if (! isset($stats[$a])) {
                    $stats[$a] = ['played'=>0,'won'=>0,'drawn'=>0,'lost'=>0,'goals_for'=>0,'goals_against'=>0,'points'=>0,
                        'group_label' => $isGroupPhase ? ($teamGroupMap[$a] ?? null) : null];
                }

                $hScore = (int) ($match->home_score ?? 0);
                $aScore = (int) ($match->away_score ?? 0);

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

            // dd($stats);

            $sorter = function ($a, $b) {
                if ($b['points'] !== $a['points']) return $b['points'] <=> $a['points'];
                $gdA = $a['goals_for'] - $a['goals_against'];
                $gdB = $b['goals_for'] - $b['goals_against'];
                if ($gdB !== $gdA) return $gdB <=> $gdA;
                return $b['goals_for'] <=> $a['goals_for'];
            };

            if ($isGroupPhase) {
                // Rankear posiciones dentro de cada grupo (1..n por grupo).
                $byGroup = [];
                foreach ($stats as $ttId => $row) {
                    $key = $row['group_label'] ?? '';
                    $byGroup[$key][$ttId] = $row;
                }
                ksort($byGroup);
                foreach ($byGroup as $groupKey => $groupStats) {
                    uasort($groupStats, $sorter);
                    $position = 1;
                    foreach ($groupStats as $ttId => $row) {
                        TournamentStanding::create([
                            'tournament_id'          => $this->tournament->id,
                            'tournament_category_id' => $phase->tournament_category_id,
                            'phase_id'               => $phase->id,
                            'tournament_team_id'     => $ttId,
                            'group_label'            => $row['group_label'],
                            'played'                 => $row['played'],
                            'won'                    => $row['won'],
                            'drawn'                  => $row['drawn'],
                            'lost'                   => $row['lost'],
                            'goals_for'              => $row['goals_for'],
                            'goals_against'          => $row['goals_against'],
                            'points'                 => $row['points'],
                            'position'               => $position++,
                        ]);
                    }
                }
            } else {
                uasort($stats, $sorter);
                $position = 1;
                foreach ($stats as $ttId => $row) {
                    TournamentStanding::create([
                        'tournament_id'          => $this->tournament->id,
                        'tournament_category_id' => $phase->tournament_category_id,
                        'phase_id'               => $phase->id,
                        'tournament_team_id'     => $ttId,
                        'group_label'            => $row['group_label'],
                        'played'                 => $row['played'],
                        'won'                    => $row['won'],
                        'drawn'                  => $row['drawn'],
                        'lost'                   => $row['lost'],
                        'goals_for'              => $row['goals_for'],
                        'goals_against'          => $row['goals_against'],
                        'points'                 => $row['points'],
                        'position'               => $position++,
                    ]);
                }
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
        $this->gm_showForm       = true;
        $this->gm_deletingGoalId = null;
        $this->gm_deletingCardId = null;
        $this->gm_goal_type      = 'normal';
        $this->gm_action         = 'goal';
        $this->gm_player_search  = '';
        $this->gm_card_type      = 'yellow';
        $this->gm_card_minute    = '';
        $this->reset(['gm_team_id', 'gm_player_id', 'gm_minute']);
        $this->showGoalsModal    = true;
    }

    public function closeGoalsModal(): void
    {
        $this->showGoalsModal    = false;
        $this->goalsMatchId      = null;
        $this->gm_showForm       = true;
        $this->gm_deletingGoalId = null;
        $this->gm_deletingCardId = null;
        $this->gm_player_search  = '';
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
            'gm_player_id' => 'nullable|exists:tournament_players,id',
            'gm_goal_type' => 'required|in:normal,penalty,own_goal',
            'gm_minute'    => 'nullable|integer|min:1|max:180',
        ]);

        $match  = TournamentMatch::findOrFail($this->goalsMatchId);
        $player = $this->gm_player_id ? TournamentPlayer::find((int) $this->gm_player_id) : null;

        // Equipo al que se le acredita el gol (propia meta se la lleva el rival).
        if ($player) {
            $teamId = $this->gm_goal_type === 'own_goal'
                ? ($player->tournament_team_id === $match->home_team_id
                    ? $match->away_team_id
                    : $match->home_team_id)
                : $player->tournament_team_id;
        } else {
            $selectedTeamId = (int) $this->gm_team_id;
            $teamId = $this->gm_goal_type === 'own_goal'
                ? ($selectedTeamId === $match->home_team_id ? $match->away_team_id : $match->home_team_id)
                : $selectedTeamId;
        }

        TournamentMatchGoal::create([
            'tournament_match_id'  => $this->goalsMatchId,
            'tournament_player_id' => $player?->id,
            'tournament_team_id'   => $teamId,
            'goal_type'            => $this->gm_goal_type,
            'minute'               => $this->gm_minute !== '' ? (int) $this->gm_minute : null,
        ]);

        $this->recalculateMatchScore($this->goalsMatchId);
        $this->gm_goal_type     = 'normal';
        $this->gm_player_search = '';
        $this->reset(['gm_player_id', 'gm_minute']);
        // Keep form open for fast multi-goal entry
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

    public function gmStartMatch(): void
    {
        $match = TournamentMatch::findOrFail($this->goalsMatchId);
        abort_unless($match->tournament_id === $this->tournament->id, 403);
        $match->update(['status' => 'in_progress', 'updated_user' => auth()->id()]);
        $this->tournament->refresh();
    }

    public function gmFinishMatch(): void
    {
        $match = TournamentMatch::with('phase')->findOrFail($this->goalsMatchId);
        abort_unless($match->tournament_id === $this->tournament->id, 403);
        $match->update([
            'status'       => 'completed',
            // Si no se registraron goles, fijamos marcador 0-0 para que compute en la clasificación.
            'home_score'   => $match->home_score ?? 0,
            'away_score'   => $match->away_score ?? 0,
            'played_at'    => $match->played_at ?? now(),
            'updated_user' => auth()->id(),
        ]);
        if ($match->phase && in_array($match->phase->type, ['league', 'group'])) {
            $this->recalculateStandings($match->phase_id);
        }
        $this->tournament->refresh();
    }

    public function gmSetAction(string $action): void
    {
        $this->gm_action        = in_array($action, ['goal', 'card']) ? $action : 'goal';
        $this->gm_player_search = '';
        $this->gm_card_type     = 'yellow';
        $this->reset(['gm_team_id', 'gm_player_id', 'gm_minute', 'gm_card_minute']);
        $this->gm_goal_type = 'normal';
    }

    public function gmSelectTeam(int $teamId): void
    {
        $this->gm_team_id       = (string) $teamId;
        $this->gm_player_search = '';
        $this->reset(['gm_player_id']);
    }

    public function gmSelectPlayer(int $playerId): void
    {
        $player = TournamentPlayer::find($playerId);
        if ($player) {
            $this->gm_player_id = (string) $playerId;
            $this->gm_team_id   = (string) $player->tournament_team_id;
        }
    }

    public function gmAddCard(): void
    {
        $this->validate([
            'gm_player_id'   => 'required|exists:tournament_players,id',
            'gm_card_type'   => 'required|in:yellow,red,double_yellow',
            'gm_card_minute' => 'nullable|integer|min:1|max:180',
        ]);

        $player = TournamentPlayer::findOrFail((int) $this->gm_player_id);

        TournamentMatchCard::create([
            'tournament_match_id'  => $this->goalsMatchId,
            'tournament_player_id' => $player->id,
            'tournament_team_id'   => $player->tournament_team_id,
            'card_type'            => $this->gm_card_type,
            'minute'               => $this->gm_card_minute !== '' ? (int) $this->gm_card_minute : null,
        ]);

        if (in_array($this->gm_card_type, ['red', 'double_yellow'])) {
            TournamentSanction::create([
                'tournament_id'        => $this->tournament->id,
                'tournament_match_id'  => $this->goalsMatchId,
                'tournament_team_id'   => $player->tournament_team_id,
                'tournament_player_id' => $player->id,
                'sanction_type'        => 'suspension',
                'matches_suspended'    => 1,
                'matches_served'       => 0,
                'reason'               => $this->gm_card_type === 'red'
                    ? 'Tarjeta roja directa'
                    : 'Expulsión por doble amarilla',
                'active'               => true,
            ]);
        }

        $this->gm_player_search = '';
        $this->gm_card_type     = 'yellow';
        $this->reset(['gm_player_id', 'gm_card_minute']);
        $this->tournament->refresh();
    }

    public function gmConfirmDeleteCard(int $id): void
    {
        $this->gm_deletingCardId = $id;
    }

    public function gmCancelDeleteCard(): void
    {
        $this->gm_deletingCardId = null;
    }

    public function gmDeleteCard(): void
    {
        TournamentMatchCard::where('id', $this->gm_deletingCardId)
            ->where('tournament_match_id', $this->goalsMatchId)
            ->delete();
        $this->gm_deletingCardId = null;
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
            'status'       => ($goals->isNotEmpty() && $match->status === 'scheduled') ? 'completed' : $match->status,
            'played_at'    => ($goals->isNotEmpty() && ! $match->played_at) ? now() : $match->played_at,
            'updated_user' => auth()->id(),
        ]);

        if ($match->phase && in_array($match->phase->type, ['league', 'group'])) {
            $this->recalculateStandings($match->phase_id);
        }

        if ($match->phase && in_array($match->phase->type, ['knockout', 'double_elimination'])
            && $homeScore !== $awayScore
            && ! ($match->settings['is_third_place'] ?? false)) {
            $this->advanceWinner($match->id);
        }
    }

    // ==================================================================
    // Referees management
    // ==================================================================

    public function openRefereesModal(): void
    {
        // Load current referees
        $this->selectedReferees = $this->tournament->referees()->pluck('user_id')->toArray();
        $this->showRefereesModal = true;
    }

    public function toggleReferee(int $userId): void
    {
        if (in_array($userId, $this->selectedReferees)) {
            $this->selectedReferees = array_diff($this->selectedReferees, [$userId]);
        } else {
            $this->selectedReferees[] = $userId;
        }
    }

    public function saveReferees(): void
    {
        $this->tournament->referees()->sync($this->selectedReferees);
        $this->showRefereesModal = false;
        session()->flash('message', 'Árbitros actualizados correctamente.');
    }

    // ==================================================================
    // Bracket / Knockout
    // ==================================================================

    public function openBracketModal(int $phaseId): void
    {
        $phase = TournamentPhase::findOrFail($phaseId);
        abort_unless($phase->tournament_id === $this->tournament->id, 403);

        $this->bracketPhaseId       = $phaseId;
        $this->bracketSelectedTeams = [];
        $this->bracketPairings      = [];
        $this->bracketClearExisting = false;
        $this->bracketThirdPlace    = $phase->settings['third_place'] ?? false;
        // Detect existing round count so the selector reflects reality
        $existing = TournamentMatch::where('phase_id', $phaseId)
            ->where('match_number', '!=', 999)
            ->max('round') ?? 0;
        $this->bracketRoundCount = max(1, (int)$existing ?: 2);
        $this->showBracketModal  = true;
    }

    public function updatedBracketSelectedTeams(): void
    {
        $this->initBracketPairings();
    }

    public function initBracketPairings(): void
    {
        $selected = array_values(array_map('intval', array_filter($this->bracketSelectedTeams)));
        $n        = count($selected);

        if ($n < 2) {
            $this->bracketPairings = [];
            return;
        }

        $slots      = (int) pow(2, ceil(log($n, 2)));
        $numMatches = $slots / 2;

        // Preserve existing pairings if teams are still selected; clear removed teams
        $newPairings = [];
        for ($i = 1; $i <= $numMatches; $i++) {
            $existing = $this->bracketPairings[$i] ?? ['home' => null, 'away' => null];
            $home = in_array((int)($existing['home'] ?? 0), $selected) ? (int)$existing['home'] : null;
            $away = in_array((int)($existing['away'] ?? 0), $selected) ? (int)$existing['away'] : null;
            $newPairings[$i] = ['home' => $home, 'away' => $away];
        }

        // Fill empty slots with unassigned teams (consecutive default)
        $assigned   = collect($newPairings)->flatMap(fn($p) => array_filter([(int)($p['home'] ?? 0), (int)($p['away'] ?? 0)]))->filter()->unique()->toArray();
        $unassigned = array_values(array_diff($selected, $assigned));

        $idx = 0;
        for ($i = 1; $i <= $numMatches; $i++) {
            if (! $newPairings[$i]['home'] && isset($unassigned[$idx])) {
                $newPairings[$i]['home'] = $unassigned[$idx++];
            }
            if (! $newPairings[$i]['away'] && isset($unassigned[$idx])) {
                $newPairings[$i]['away'] = $unassigned[$idx++];
            }
        }

        $this->bracketPairings = $newPairings;
    }

    public function quickSelectBracketTeams(int $n): void
    {
        if (!$this->bracketPhaseId) return;

        $phase  = TournamentPhase::find($this->bracketPhaseId);
        $catId  = $phase?->tournament_category_id;
        $isOpen = $this->tournament->team_type === 'open';

        // Get teams from previous-phase standings in order
        $prevPhaseIds = TournamentPhase::where('tournament_id', $this->tournament->id)
            ->when(!$isOpen && $catId, fn($q) => $q->where('tournament_category_id', $catId))
            ->whereIn('type', ['league', 'group'])
            ->where('order', '<', $phase->order)
            ->pluck('id');

        $topTeams = TournamentStanding::whereIn('phase_id', $prevPhaseIds)
            ->orderBy('position')
            ->pluck('tournament_team_id')
            ->unique()
            ->take($n)
            ->values()
            ->toArray();

        // Fill remaining slots from all teams if standings are insufficient
        if (count($topTeams) < $n) {
            $allTeamIds = TournamentTeam::where('tournament_id', $this->tournament->id)
                ->when(!$isOpen && $catId, fn($q) => $q->where('tournament_category_id', $catId))
                ->pluck('id')->toArray();
            $remaining  = array_values(array_diff($allTeamIds, $topTeams));
            $topTeams   = array_slice(array_merge($topTeams, $remaining), 0, $n);
        }

        $this->bracketSelectedTeams = array_map('intval', $topTeams);
        $this->initBracketPairings();
    }

    public function generateKnockoutBracket(): void
    {
        $this->validate([
            'bracketPhaseId'    => 'required|exists:tournament_phases,id',
            'bracketRoundCount' => 'required|integer|min:1|max:5',
        ]);

        $phase = TournamentPhase::findOrFail($this->bracketPhaseId);
        abort_unless($phase->tournament_id === $this->tournament->id, 403);

        if ($this->bracketClearExisting) {
            TournamentMatch::where('phase_id', $phase->id)->delete();
        }

        $totalRounds = $this->bracketRoundCount;
        $slots       = (int) pow(2, $totalRounds);

        $user       = auth()->id();
        $categoryId = $phase->tournament_category_id;

        // Round label from distance to Final: 0 = Final, 1 = Semifinal, 2 = Cuartos…
        $roundLabel = function (int $fromFinal): string {
            return match ($fromFinal) {
                0       => 'Final',
                1       => 'Semifinal',
                2       => 'Cuartos de Final',
                3       => 'Octavos de Final',
                4       => '16avos de Final',
                5       => '32avos de Final',
                default => 'Ronda ' . ($fromFinal + 1),
            };
        };

        // Create all rounds (ascending: round 1 = first round, round N = Final)
        for ($round = 1; $round <= $totalRounds; $round++) {
            $matchesInRound = $slots / (int) pow(2, $round);
            $fromFinal      = $totalRounds - $round;
            $baseLabel      = $roundLabel($fromFinal);

            for ($matchNum = 1; $matchNum <= $matchesInRound; $matchNum++) {
                $homeId = $awayId = null;

                // Teams assigned later via assignTeamToSlot()
                $notes = $matchesInRound > 1 ? $baseLabel . ' ' . $matchNum : $baseLabel;

                TournamentMatch::create([
                    'tournament_id'          => $this->tournament->id,
                    'tournament_category_id' => $categoryId,
                    'phase_id'               => $phase->id,
                    'round'                  => $round,
                    'match_number'           => $matchNum,
                    'home_team_id'           => $homeId,
                    'away_team_id'           => $awayId,
                    'status'                 => 'scheduled',
                    'notes'                  => $notes,
                    'created_user'           => $user,
                ]);
            }
        }

        // 3rd-place match (same round as semis = totalRounds - 1)
        if ($this->bracketThirdPlace && $totalRounds >= 2) {
            TournamentMatch::create([
                'tournament_id'          => $this->tournament->id,
                'tournament_category_id' => $categoryId,
                'phase_id'               => $phase->id,
                'round'                  => $totalRounds - 1,
                'match_number'           => 999,
                'home_team_id'           => null,
                'away_team_id'           => null,
                'status'                 => 'scheduled',
                'notes'                  => 'Partido por el 3er Puesto',
                'created_user'           => $user,
                'settings'               => ['is_third_place' => true, 'label' => '3º Puesto'],
            ]);
        }

        $phase->update([
            'settings' => array_merge($phase->settings ?? [], ['third_place' => $this->bracketThirdPlace]),
        ]);

        $this->showBracketModal = false;
        $this->tournament->refresh();
        session()->flash('message', "Cuadro generado: {$slots} plazas en {$totalRounds} rondas. Asigna los equipos directamente en el cuadro.");
    }

    public function assignTeamToSlot(int $matchId, string $side, mixed $teamId): void
    {
        $match = TournamentMatch::findOrFail($matchId);
        abort_unless($match->tournament_id === $this->tournament->id, 403);
        abort_unless(in_array($side, ['home', 'away']), 422);

        if ($teamId) {
            $teamId        = (int)$teamId;
            $opponentField = $side === 'home' ? 'away_team_id' : 'home_team_id';

            // Can't face yourself
            if ((int)($match->$opponentField ?? 0) === $teamId) {
                session()->flash('error', 'Un equipo no puede enfrentarse a sí mismo.');
                return;
            }

            // Can't appear twice in the same round
            $alreadyInRound = TournamentMatch::where('phase_id', $match->phase_id)
                ->where('round', $match->round)
                ->where('id', '!=', $matchId)
                ->where(fn($q) => $q->where('home_team_id', $teamId)->orWhere('away_team_id', $teamId))
                ->exists();

            if ($alreadyInRound) {
                session()->flash('error', 'Este equipo ya está asignado en otro partido de esta ronda.');
                return;
            }
        }

        $field = $side === 'home' ? 'home_team_id' : 'away_team_id';
        $match->update([$field => $teamId ?: null]);
        $this->tournament->refresh();
    }

    public function advanceWinner(int $matchId): void
    {
        $match = TournamentMatch::with(['homeTeam', 'awayTeam'])->findOrFail($matchId);
        abort_unless($match->tournament_id === $this->tournament->id, 403);

        $winner = $match->winner();
        if (! $winner) {
            session()->flash('error', 'No se puede avanzar: el partido no tiene un ganador claro (posible empate).');
            return;
        }

        $allKOMatches = TournamentMatch::where('phase_id', $match->phase_id)->get();
        $maxRound     = $allKOMatches->max('round');

        if ($match->round >= $maxRound) {
            session()->flash('message', '¡Campeón: ' . $winner->displayName() . '! Este era el partido final.');
            return;
        }

        $nextRound    = $match->round + 1;
        $nextMatchNum = (int) ceil($match->match_number / 2);

        $nextMatch = TournamentMatch::where('phase_id', $match->phase_id)
            ->where('round', $nextRound)
            ->where('match_number', $nextMatchNum)
            ->first();

        if (! $nextMatch) {
            session()->flash('error', 'No se encontró el partido de la siguiente ronda.');
            return;
        }

        // Odd match_number → home slot; even → away slot
        if ($match->match_number % 2 === 1) {
            $nextMatch->update(['home_team_id' => $winner->id]);
        } else {
            $nextMatch->update(['away_team_id' => $winner->id]);
        }

        $this->tournament->refresh();
        session()->flash('message', $winner->displayName() . ' ha avanzado a la siguiente ronda.');
    }

    // ==================================================================
    // Export PDF
    // ==================================================================

    public function exportPdf()
    {
        abort_unless($this->tournament->sports_school_id === auth()->user()->sports_school_id, 403);

        // mPDF loads very large HTML blocks; make sure PCRE won't abort the parse
        @ini_set('pcre.backtrack_limit', '50000000');
        @ini_set('pcre.recursion_limit', '50000000');
        @ini_set('memory_limit', '512M');

        $tournament = $this->tournament->load([
            'sportsSchool',
            'categories.category',
            'categories.phases',
            'categories.tournamentTeams.team',
            'tournamentTeams.team',
            'phases',
            'matches' => fn ($q) => $q->orderByRaw('scheduled_at IS NULL ASC')
                ->orderBy('scheduled_at')
                ->orderBy('phase_id')
                ->orderBy('round')
                ->orderBy('match_number'),
            'matches.phase',
            'matches.homeTeam.team',
            'matches.awayTeam.team',
            'matches.tournamentCategory.category',
        ]);

        // Build the public URL for this tournament (tenant-aware)
        $school = $tournament->sportsSchool;
        $publicUrl = null;
        if ($school) {
            if (! empty($school->domain)) {
                $publicUrl = 'https://' . ltrim(preg_replace('#^https?://#', '', $school->domain), '/') . '/torneos/' . $tournament->id;
            } elseif (! empty($school->slug)) {
                $publicUrl = 'https://' . $school->slug . '.vaed.es/torneos/' . $tournament->id;
            }
        }

        // Resolve a local file path for an image stored on the public disk (mPDF can read it directly)
        $resolveImage = function (?string $path): ?string {
            if (! $path) return null;
            try {
                $full = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
                return file_exists($full) ? $full : null;
            } catch (\Throwable $e) {
                return null;
            }
        };

        $tournamentImage = $resolveImage($tournament->logo);

        // Teams grouped by category + group_label (for group-phase display)
        $teamsByCategoryGroup = $tournament->tournamentTeams
            ->groupBy(fn ($t) => $t->tournament_category_id ?? 0)
            ->map(fn ($catTeams) => $catTeams->groupBy(fn ($t) => $t->group_label ?: '—'));

        // Resolve each team logo to a local file path
        $teamLogos = [];
        foreach ($tournament->tournamentTeams as $tt) {
            $logoPath = $tt->logo ?: $tt->team?->logo;
            $teamLogos[$tt->id] = $resolveImage($logoPath);
        }

        // Does any phase in the tournament use group/league layout?
        $hasGroupPhase = $tournament->phases->contains(fn ($p) => in_array($p->type, ['group', 'league']));

        // Matches grouped by category and phase
        $matchesByCategory = $tournament->matches->groupBy('tournament_category_id');

        $html = view('pdfs.tournament', [
            'tournament'           => $tournament,
            'school'               => $school,
            'publicUrl'            => $publicUrl,
            'tournamentImage'      => $tournamentImage,
            'teamsByCategoryGroup' => $teamsByCategoryGroup,
            'teamLogos'            => $teamLogos,
            'hasGroupPhase'        => $hasGroupPhase,
            'matchesByCategory'    => $matchesByCategory,
        ])->render();

        // Build mPDF directly and write the HTML in chunks (CSS first, then body)
        // to avoid PCRE backtrack issues on very large documents.
        $tempDir = config('pdf.temp_dir') ?: storage_path('app');
        if (! is_dir($tempDir)) {
            @mkdir($tempDir, 0775, true);
        }

        $pdfConfig = [
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 0,
            'margin_bottom' => 0,
            'margin_left'   => 0,
            'margin_right'  => 0,
            'tempDir'       => $tempDir,
        ];

        $mpdf = new \Mpdf\Mpdf($pdfConfig);
        $mpdf->SetTitle($tournament->name);
        $mpdf->SetAuthor($school?->name ?? config('app.name'));
        // Allow mPDF to load local files referenced by src="/absolute/path"
        $mpdf->allow_charset_conversion = true;

        // Split HTML into <style>...</style> block and the rest, writing each as its own chunk.
        if (preg_match('#<style\b[^>]*>(.*?)</style>#is', $html, $m)) {
            $mpdf->WriteHTML($m[1], \Mpdf\HTMLParserMode::HEADER_CSS);
            $body = preg_replace('#<style\b[^>]*>.*?</style>#is', '', $html, 1);
        } else {
            $body = $html;
        }

        $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY);

        $filename = 'torneo_' . \Illuminate\Support\Str::slug($tournament->name) . '.pdf';

        return response()->streamDownload(
            fn () => print($mpdf->Output($filename, \Mpdf\Output\Destination::STRING_RETURN)),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    // ==================================================================
    // Render
    // ==================================================================

    public function render()
    {
        $recentTeams = $this->showTeamModal && !$this->editingTeamId && $this->teamCreationMode === 'recent'
            ? app(RecentTournamentTeams::class)->available($this->tournament, $this->activeCategoryId)
            : collect();
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

        // dd(TournamentStanding::where('tournament_id', $this->tournament->id)->toRawSql());


        $standings = ($this->activeCategoryId || $isOpen)
            ? TournamentStanding::where('tournament_id', $this->tournament->id)
                ->when(!$isOpen, fn ($q) => $q->where('tournament_category_id', $this->activeCategoryId))
                ->with(['phase', 'tournamentTeam.team'])
                ->orderBy('phase_id')
                ->orderBy('group_label')
                ->orderBy('position')
                ->get()
            : collect();

        // dd($standings);

        // Detect if any phase is a league/group type (requires standings to always be visible)
        $hasLeaguePhase = $phases->contains(fn ($p) => in_array($p->type, ['league', 'group']));

        // Mapa [phase_id => nº participantes] para fases «liga» generadas con subset.
        $leagueSubsetSettings = $phases
            ->filter(fn ($p) => $p->type === 'league' && !empty($p->settings['league_participants_count']))
            ->mapWithKeys(fn ($p) => [$p->id => (int) $p->settings['league_participants_count']])
            ->all();

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
        $gmCardsForModal = $this->goalsMatchId
            ? TournamentMatchCard::where('tournament_match_id', $this->goalsMatchId)
                ->with(['player', 'team'])
                ->orderBy('minute')
                ->get()
            : collect();
        $gmTeamPlayers = $this->gm_team_id
            ? TournamentPlayer::where('tournament_team_id', $this->gm_team_id)
                ->when($this->gm_player_search !== '', function ($q) {
                    $s = $this->gm_player_search;
                    $q->where(function ($q2) use ($s) {
                        $q2->where('dorsal', $s)
                           ->orWhere('name', 'like', "%{$s}%")
                           ->orWhere('surname', 'like', "%{$s}%");
                    });
                })
                ->orderBy('dorsal')->orderBy('surname')->orderBy('name')->get()
            : collect();
        $gmMatchTeams = $goalsModalMatch
            ? TournamentTeam::whereIn('id', array_filter([
                $goalsModalMatch->home_team_id,
                $goalsModalMatch->away_team_id,
              ]))->with('team')->get()
            : collect();
        $gmAllPlayers = $goalsModalMatch
            ? TournamentPlayer::whereIn('tournament_team_id', array_filter([
                    $goalsModalMatch->home_team_id,
                    $goalsModalMatch->away_team_id,
                ]))
                ->when($this->gm_player_search !== '', function ($q) {
                    $s = $this->gm_player_search;
                    $q->where(function ($q2) use ($s) {
                        $q2->where('dorsal', $s)
                           ->orWhere('name', 'like', "%{$s}%")
                           ->orWhere('surname', 'like', "%{$s}%");
                    });
                })
                ->orderBy('dorsal')->orderBy('surname')->get()
            : collect();

        // Referees data
        $availableReferees = User::role('judge')
            ->where('sports_school_id', auth()->user()->sports_school_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        $assignedReferees = $this->tournament->referees;

        // Knockout bracket data ─────────────────────────────────────────
        $knockoutPhases = $phases->whereIn('type', ['knockout', 'double_elimination']);
        $hasKnockoutPhase = $knockoutPhases->isNotEmpty();

        $bracketData = collect();
        foreach ($knockoutPhases as $kPhase) {
            $kMatches = $matches->where('phase_id', $kPhase->id)
                ->filter(fn($m) => ! ($m->settings['is_third_place'] ?? false))
                ->sortBy([['round', 'asc'], ['match_number', 'asc']])
                ->values();

            $maxRound             = $kMatches->max('round') ?? 0;
            $firstRound           = $kMatches->min('round') ?? 1;
            $numFirstRoundMatches = max($kMatches->where('round', $firstRound)->count(), 1);
            $totalRounds          = $maxRound > 0 ? $maxRound - $firstRound + 1 : 0;

            $rounds = collect();
            for ($r = $firstRound; $r <= $maxRound; $r++) {
                $rounds->put($r, $kMatches->where('round', $r)->sortBy('match_number')->values());
            }

            $thirdPlace = $matches->where('phase_id', $kPhase->id)
                ->first(fn($m) => $m->settings['is_third_place'] ?? false);

            $bracketData->put($kPhase->id, [
                'phase'                => $kPhase,
                'rounds'               => $rounds,
                'maxRound'             => $maxRound,
                'firstRound'           => $firstRound,
                'numFirstRoundMatches' => $numFirstRoundMatches,
                'totalRounds'          => $totalRounds,
                'thirdPlace'           => $thirdPlace,
                'hasMatches'           => $kMatches->isNotEmpty(),
            ]);
        }

        // Bracket modal team data ─────────────────────────────────────────
        $bracketModalTeams      = collect();
        $bracketModalStandings  = collect();
        if ($this->showBracketModal && $this->bracketPhaseId) {
            $bPhase = TournamentPhase::find($this->bracketPhaseId);
            if ($bPhase) {
                $bCatId = $bPhase->tournament_category_id;
                $bIsOpen = $isOpen;

                $bracketModalTeams = TournamentTeam::where('tournament_id', $this->tournament->id)
                    ->when(! $bIsOpen && $bCatId, fn($q) => $q->where('tournament_category_id', $bCatId))
                    ->with('team')
                    ->get();

                $prevPhaseIds = TournamentPhase::where('tournament_id', $this->tournament->id)
                    ->when(! $bIsOpen && $bCatId, fn($q) => $q->where('tournament_category_id', $bCatId))
                    ->whereIn('type', ['league', 'group'])
                    ->where('order', '<', $bPhase->order)
                    ->pluck('id');

                $bracketModalStandings = TournamentStanding::whereIn('phase_id', $prevPhaseIds)
                    ->with(['tournamentTeam', 'phase'])
                    ->orderBy('position')
                    ->get()
                    ->keyBy('tournament_team_id');
            }
        }

        if ($this->isMobile()) {
            // en desarrollo la parte mobile
           return view('livewire.tournaments.show_mobile', compact(
                'categories', 'activeCategory',
                'phases', 'teams', 'matches', 'standings', 'hasLeaguePhase',
                'schoolTeams', 'schoolCategories',
                'goalsModalMatch', 'goalsForModal', 'gmCardsForModal', 'gmTeamPlayers', 'gmMatchTeams', 'gmAllPlayers',
                'availableReferees', 'assignedReferees',
                'hasKnockoutPhase', 'bracketData', 'bracketModalTeams', 'bracketModalStandings', 'recentTeams'
            ));
        //  return view('livewire.tournaments.show', compact(
        //     'categories', 'activeCategory',
        //     'phases', 'teams', 'matches', 'standings', 'hasLeaguePhase',
        //     'schoolTeams', 'schoolCategories',
        //     'goalsModalMatch', 'goalsForModal', 'gmCardsForModal', 'gmTeamPlayers', 'gmMatchTeams', 'gmAllPlayers',
        //     'availableReferees', 'assignedReferees',
        //     'hasKnockoutPhase', 'bracketData', 'bracketModalTeams', 'bracketModalStandings',
        //     'leagueSubsetSettings'
        // ));
        }

        return view('livewire.tournaments.show', compact(
            'categories', 'activeCategory',
            'phases', 'teams', 'matches', 'standings', 'hasLeaguePhase',
            'schoolTeams', 'schoolCategories',
            'goalsModalMatch', 'goalsForModal', 'gmCardsForModal', 'gmTeamPlayers', 'gmMatchTeams', 'gmAllPlayers',
            'availableReferees', 'assignedReferees',
            'hasKnockoutPhase', 'bracketData', 'bracketModalTeams', 'bracketModalStandings',
            'leagueSubsetSettings', 'recentTeams'
        ));
    }
}
