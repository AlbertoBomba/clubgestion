<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use App\Models\TournamentPlayer;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamDashboard extends Component
{
    use WithFileUploads;

    public Tournament     $tournament;
    public TournamentTeam $team;

    // ── Tabs ───────────────────────────────────────────────
    public string $tab = 'perfil';

    // ── Edit profile ───────────────────────────────────────
    public bool   $editMode        = false;
    public string $editName        = '';
    public string $editContactName = '';
    public string $editContactPhone= '';
    public string $editEmail       = '';
    public        $editLogo        = null;   // UploadedFile | null
    public string $profileSuccess  = '';
    public string $profileError    = '';

    // ── Add player ─────────────────────────────────────────
    public bool   $showAddPlayer   = false;
    public string $pName           = '';
    public string $pSurname        = '';
    public string $pDorsal         = '';
    public string $pPosition       = '';
    public string $pBirthdate      = '';
    public        $pPhoto          = null;
    public string $playerError     = '';

    // ── Share registration link ────────────────────────────

    public string $registrationUrl = '';

    // ── Mount ──────────────────────────────────────────────
    public function mount(Tournament $tournament): void
    {
        $school = currentSchool();

        if (!$school) {
            abort(404);
        }

        if (
            $tournament->sports_school_id !== $school->id ||
            $tournament->visibility !== 'public' ||
            $tournament->status === 'cancelled'
        ) {
            abort(404);
        }

        $this->tournament = $tournament;

        $teamId = session('tt_auth_' . $tournament->id);

        if (!$teamId) {
            $this->redirect(route('webclubs.team.login', $tournament));
            return;
        }

        $team = TournamentTeam::where('tournament_id', $tournament->id)->find($teamId);

        if (!$team) {
            session()->forget('tt_auth_' . $tournament->id);
            $this->redirect(route('webclubs.team.login', $tournament));
            return;
        }

        $this->team = $team;

        // Always generate the permanent registration URL on mount
        $this->registrationUrl = route('webclubs.player.register', [
            $tournament,
            $team->getOrCreateRegistrationToken(),
        ]);
    }

    // ── Tab ────────────────────────────────────────────────
    public function switchTab(string $tab): void
    {
        $this->tab = $tab;
        $this->showAddPlayer = false;
    }

    // ── Logout ─────────────────────────────────────────────
    public function logout(): void
    {
        session()->forget('tt_auth_' . $this->tournament->id);
        $this->redirect(route('webclubs.team.login', $this->tournament));
    }

    // ── Registration link ──────────────────────────────────
    public function copyRegistrationLink(): void
    {
        // No-op: copying is handled client-side via JS
    }

    // ── Edit profile ───────────────────────────────────────
    public function startEdit(): void
    {
        $this->editName         = $this->team->name_override ?? $this->team->displayName();
        $this->editContactName  = $this->team->contact_name  ?? '';
        $this->editContactPhone = $this->team->contact_phone ?? '';
        $this->editEmail        = $this->team->email         ?? '';
        $this->editLogo         = null;
        $this->profileSuccess   = '';
        $this->profileError     = '';
        $this->editMode         = true;
    }

    public function cancelEdit(): void
    {
        $this->editMode = false;
        $this->editLogo = null;
    }

    public function saveProfile(): void
    {
        $this->validate([
            'editName'        => 'required|string|max:100',
            'editContactName' => 'nullable|string|max:100',
            'editContactPhone'=> 'nullable|string|max:30',
            'editEmail'       => 'nullable|email|max:150',
            'editLogo'        => 'nullable|image|max:2048',
        ], [
            'editName.required' => 'El nombre del equipo es obligatorio.',
            'editLogo.image'    => 'El escudo debe ser una imagen.',
            'editLogo.max'      => 'El escudo no puede superar 2 MB.',
        ]);

        $data = [
            'name_override'  => $this->editName,
            'contact_name'   => $this->editContactName  ?: null,
            'contact_phone'  => $this->editContactPhone ?: null,
            'email'          => $this->editEmail         ?: null,
        ];

        if ($this->editLogo) {
            if ($this->team->logo) {
                Storage::disk('public')->delete($this->team->logo);
            }
            $data['logo'] = $this->editLogo->store('tournament-teams', 'public');
        }

        $this->team->update($data);
        $this->team->refresh();
        $this->editMode      = false;
        $this->editLogo      = null;
        $this->profileSuccess = '¡Datos guardados correctamente!';
    }

    // ── Add player ─────────────────────────────────────────
    public function openAddPlayer(): void
    {
        $this->pName       = '';
        $this->pSurname    = '';
        $this->pDorsal     = '';
        $this->pPosition   = '';
        $this->pBirthdate  = '';
        $this->pPhoto      = null;
        $this->playerError = '';
        $this->showAddPlayer = true;
    }

    public function closeAddPlayer(): void
    {
        $this->showAddPlayer = false;
    }

    public function savePlayer(): void
    {
        $this->validate([
            'pName'      => 'required|string|max:80',
            'pSurname'   => 'nullable|string|max:80',
            'pDorsal'    => 'nullable|integer|min:1|max:999',
            'pPosition'  => 'nullable|string|max:50',
            'pBirthdate' => 'nullable|date',
            'pPhoto'     => 'nullable|image|max:2048',
        ], [
            'pName.required' => 'El nombre del jugador es obligatorio.',
            'pPhoto.image'   => 'La foto debe ser una imagen.',
            'pPhoto.max'     => 'La foto no puede superar 2 MB.',
        ]);

        $data = [
            'tournament_team_id' => $this->team->id,
            'name'               => $this->pName,
            'surname'            => $this->pSurname     ?: null,
            'dorsal'             => $this->pDorsal      ?: null,
            'position'           => $this->pPosition    ?: null,
            'birthdate'          => $this->pBirthdate   ?: null,
            'status'             => 'pending',
        ];

        if ($this->pPhoto) {
            $data['photo'] = $this->pPhoto->store('tournament-players', 'public');
        }

        TournamentPlayer::create($data);

        $this->showAddPlayer = false;
    }

    public function deletePlayer(int $playerId): void
    {
        $player = TournamentPlayer::where('tournament_team_id', $this->team->id)->findOrFail($playerId);

        if ($player->photo) {
            Storage::disk('public')->delete($player->photo);
        }

        $player->delete();
    }

    // ── Render ─────────────────────────────────────────────
    public function render()
    {
        $players = TournamentPlayer::where('tournament_team_id', $this->team->id)
            ->withCount('goals')
            ->withCount('cards')
            ->orderBy('dorsal')
            ->get();

        return view('livewire.webclubs.team-dashboard', compact('players'))
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' · ' . $this->team->displayName(),
            ]);
    }
}
