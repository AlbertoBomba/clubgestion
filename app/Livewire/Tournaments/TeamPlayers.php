<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentPlayer;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class TeamPlayers extends Component
{
    public Tournament     $tournament;
    public TournamentTeam $tournamentTeam;

    public string $search       = '';
    public string $statusFilter = '';

    public bool $confirmingDeletion = false;
    public ?int $playerToDelete     = null;

    public function mount(Tournament $tournament, TournamentTeam $tournamentTeam): void
    {
        abort_unless($tournament->sports_school_id === auth()->user()->sports_school_id, 403);
        abort_unless($tournamentTeam->tournament_id === $tournament->id, 404);
        $this->tournament     = $tournament;
        $this->tournamentTeam = $tournamentTeam;
    }

    public function confirmDelete(int $id): void
    {
        $this->playerToDelete     = $id;
        $this->confirmingDeletion = true;
    }

    public function deletePlayer(): void
    {
        $player = TournamentPlayer::findOrFail($this->playerToDelete);
        abort_unless($player->tournament_team_id === $this->tournamentTeam->id, 403);

        foreach (['photo', 'doc_front', 'doc_back'] as $field) {
            if ($player->$field) Storage::disk('public')->delete($player->$field);
        }
        foreach ($player->extra_documents ?? [] as $doc) {
            Storage::disk('public')->delete($doc['path']);
        }

        $player->delete();
        $this->confirmingDeletion = false;
        $this->playerToDelete     = null;
        session()->flash('message', 'Jugador eliminado.');
    }

    public function setStatus(int $id, string $status): void
    {
        $player = TournamentPlayer::findOrFail($id);
        abort_unless($player->tournament_team_id === $this->tournamentTeam->id, 403);
        abort_unless(in_array($status, ['pending', 'approved', 'rejected']), 422);
        $player->update(['status' => $status]);
        session()->flash('message', 'Estado actualizado.');
    }

    public function render()
    {
        $players = TournamentPlayer::query()
            ->where('tournament_team_id', $this->tournamentTeam->id)
            ->when($this->search, fn ($q) =>
                $q->where(fn ($q2) =>
                    $q2->where('name', 'like', "%{$this->search}%")
                       ->orWhere('surname', 'like', "%{$this->search}%")
                       ->orWhere('dni', 'like', "%{$this->search}%")
                )
            )
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        return view('livewire.tournaments.team-players', [
            'players'  => $players,
            'docTypes' => TournamentPlayer::docTypes(),
            'statuses' => TournamentPlayer::statuses(),
        ]);
    }
}