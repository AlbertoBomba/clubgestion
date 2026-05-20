<?php

namespace App\Livewire\Tournaments;

use App\Classes\ExcelFile;
use App\Models\Tournament;
use App\Models\TournamentPlayer;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class TeamPlayers extends Component
{
    public Tournament     $tournament;
    public TournamentTeam $tournamentTeam;

    public string $search          = '';
    public string $dniFilter        = '';
    public string $statusFilter     = '';
    public string $positionFilter   = '';
    public string $docsFilter       = '';

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
                )
            )
            ->when($this->dniFilter, fn ($q) => $q->where('dni', 'like', "%{$this->dniFilter}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->positionFilter, fn ($q) => $q->where('position', $this->positionFilter))
            ->when($this->docsFilter === 'missing_photo', fn ($q) => $q->whereNull('photo'))
            ->when($this->docsFilter === 'missing_doc_front', fn ($q) => $q->whereNull('doc_front'))
            ->when($this->docsFilter === 'missing_doc_back', fn ($q) => $q->whereNull('doc_back'))
            ->when($this->docsFilter === 'complete', fn ($q) => $q->whereNotNull('photo')->whereNotNull('doc_front')->whereNotNull('doc_back'))
            ->orderBy('surname')
            ->orderBy('name')
            ->get();

        $positions = TournamentPlayer::positions();

        return view('livewire.tournaments.team-players', [
            'players'   => $players,
            'docTypes'  => TournamentPlayer::docTypes(),
            'statuses'  => TournamentPlayer::statuses(),
            'positions' => $positions,
        ]);
    }

    public function exportExcel(): mixed
    {
        $players = TournamentPlayer::query()
            ->where('tournament_team_id', $this->tournamentTeam->id)
            ->when($this->search, fn ($q) =>
                $q->where(fn ($q2) =>
                    $q2->where('name', 'like', "%{$this->search}%")
                       ->orWhere('surname', 'like', "%{$this->search}%")
                )
            )
            ->when($this->dniFilter, fn ($q) => $q->where('dni', 'like', "%{$this->dniFilter}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->positionFilter, fn ($q) => $q->where('position', $this->positionFilter))
            ->orderBy('surname')->orderBy('name')
            ->get();

        $statuses = TournamentPlayer::statuses();

        $excel = new ExcelFile(
            TournamentPlayer::class,
            [],
            [
                'name'      => ['title' => 'Nombre',        'value' => '$record->name',                            'type' => 'eval'],
                'surname'   => ['title' => 'Apellidos',     'value' => '$record->surname ?? "-"',                  'type' => 'eval'],
                'birthdate' => ['title' => 'F. Nacimiento', 'value' => '$record->birthdate ? $record->birthdate->format("d/m/Y") : "-"', 'type' => 'eval'],
                'dni'       => ['title' => 'DNI/Documento', 'value' => '$record->dni ?? "-"',                      'type' => 'eval'],
                'doc_type'  => ['title' => 'Tipo doc.',     'value' => '$record->doc_type ?? "-"',                  'type' => 'eval'],
                'position'  => ['title' => 'Posición',      'value' => '$record->position ?? "-"',                  'type' => 'eval'],
                'dorsal'    => ['title' => 'Dorsal',        'value' => '$record->dorsal !== null ? $record->dorsal : "-"', 'type' => 'eval'],
                'phone'     => ['title' => 'Teléfono',      'value' => '$record->phone ?? "-"',                    'type' => 'eval'],
                'email'     => ['title' => 'Email',         'value' => '$record->email ?? "-"',                    'type' => 'eval'],
                'federado'  => ['title' => 'Federado',      'value' => '$record->federado ? "Sí" : "No"',           'type' => 'eval'],
                'status'    => ['title' => 'Estado',        'value' => '$statuses[$record->status] ?? $record->status', 'type' => 'eval'],
                'photo'     => ['title' => 'Foto',          'value' => '$record->photo ? "Sí" : "No"',              'type' => 'eval'],
                'doc_front' => ['title' => 'Doc A',         'value' => '$record->doc_front ? "Sí" : "No"',          'type' => 'eval'],
                'doc_back'  => ['title' => 'Doc B',         'value' => '$record->doc_back ? "Sí" : "No"',           'type' => 'eval'],
            ],
            'jugadores_' . \Illuminate\Support\Str::slug($this->tournamentTeam->displayName()),
            [],
            [],
            $players
        );

        return response()->streamDownload(function () use ($excel) {
            $excel->generate();
        }, 'jugadores_' . \Illuminate\Support\Str::slug($this->tournamentTeam->displayName()) . '.xlsx');
    }
}