<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentPlayer;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamPlayerForm extends Component
{
    use WithFileUploads;

    public Tournament      $tournament;
    public TournamentTeam  $tournamentTeam;
    public ?TournamentPlayer $player = null;

    // Personal
    public string $p_name      = '';
    public string $p_surname   = '';
    public string $p_birthdate = '';
    public string $p_dni       = '';
    public string $p_doc_type  = '';
    public string $p_phone     = '';
    public string $p_email     = '';

    // Sport
    public string $p_position  = '';
    public string $p_dorsal    = '';
    public bool   $p_federado  = false;
    public string $p_categoria = '';

    // Meta
    public string $p_status = 'pending';
    public string $p_notes  = '';

    // New file uploads
    public $p_photo     = null;
    public $p_doc_front = null;
    public $p_doc_back  = null;

    // Existing paths
    public ?string $existing_photo     = null;
    public ?string $existing_doc_front = null;
    public ?string $existing_doc_back  = null;

    public bool $clearPhoto    = false;
    public bool $clearDocFront = false;
    public bool $clearDocBack  = false;

    // Extra documents
    public array  $existing_extra_docs = [];
    public array  $staged_extra_docs   = [];
    public string $new_extra_label     = '';
    public        $new_extra_file      = null;

    protected function rules(): array
    {
        return [
            'p_name'      => 'required|string|max:100',
            'p_surname'   => 'nullable|string|max:100',
            'p_birthdate' => 'nullable|date',
            'p_dni'       => 'nullable|string|max:20',
            'p_doc_type'  => 'nullable|in:dni,nie,passport',
            'p_position'  => 'nullable|string|max:50',
            'p_dorsal'    => 'nullable|integer|min:0|max:999',
            'p_phone'     => 'nullable|string|max:20',
            'p_email'     => 'nullable|email|max:150',
            'p_federado'  => 'boolean',
            'p_categoria' => 'nullable|string|max:100',
            'p_status'    => 'required|in:pending,approved,rejected',
            'p_notes'     => 'nullable|string|max:500',
            'p_photo'     => 'nullable|image|max:4096',
            'p_doc_front' => 'nullable|image|max:8192',
            'p_doc_back'  => 'nullable|image|max:8192',
        ];
    }

    public function mount(Tournament $tournament, TournamentTeam $tournamentTeam, ?TournamentPlayer $player = null): void
    {
        abort_unless($tournament->sports_school_id === auth()->user()->sports_school_id, 403);
        abort_unless($tournamentTeam->tournament_id === $tournament->id, 404);

        $this->tournament     = $tournament;
        $this->tournamentTeam = $tournamentTeam;
        $this->player         = $player;

        if ($player) {
            abort_unless($player->tournament_team_id === $tournamentTeam->id, 404);

            $this->p_name              = $player->name;
            $this->p_surname           = $player->surname      ?? '';
            $this->p_birthdate         = $player->birthdate    ? $player->birthdate->format('Y-m-d') : '';
            $this->p_dni               = $player->dni          ?? '';
            $this->p_doc_type          = $player->doc_type     ?? '';
            $this->p_position          = $player->position     ?? '';
            $this->p_dorsal            = $player->dorsal !== null ? (string) $player->dorsal : '';
            $this->p_phone             = $player->phone        ?? '';
            $this->p_email             = $player->email        ?? '';
            $this->p_federado          = (bool) $player->federado;
            $this->p_categoria         = $player->categoria    ?? '';
            $this->p_status            = $player->status;
            $this->p_notes             = $player->notes        ?? '';
            $this->existing_photo      = $player->photo;
            $this->existing_doc_front  = $player->doc_front;
            $this->existing_doc_back   = $player->doc_back;
            $this->existing_extra_docs = $player->extra_documents ?? [];
        }
    }

    public function stageExtraDoc(): void
    {
        $this->validate([
            'new_extra_label' => 'required|string|max:100',
            'new_extra_file'  => 'required|image|max:8192',
        ]);

        $path = $this->new_extra_file->store('tournament-players/docs', 'public');

        $this->staged_extra_docs[] = ['label' => $this->new_extra_label, 'path' => $path];
        $this->new_extra_label     = '';
        $this->new_extra_file      = null;
        $this->resetValidation(['new_extra_label', 'new_extra_file']);
    }

    public function removeStagedDoc(int $index): void
    {
        if (isset($this->staged_extra_docs[$index])) {
            Storage::disk('public')->delete($this->staged_extra_docs[$index]['path']);
            array_splice($this->staged_extra_docs, $index, 1);
        }
    }

    public function removeExistingDoc(int $index): void
    {
        if (isset($this->existing_extra_docs[$index])) {
            Storage::disk('public')->delete($this->existing_extra_docs[$index]['path']);
            array_splice($this->existing_extra_docs, $index, 1);
        }
    }

    public function save(): mixed
    {
        $this->validate();

        $data = [
            'tournament_team_id' => $this->tournamentTeam->id,
            'name'               => $this->p_name,
            'surname'            => $this->p_surname      ?: null,
            'birthdate'          => $this->p_birthdate    ?: null,
            'dni'                => $this->p_dni          ?: null,
            'doc_type'           => $this->p_doc_type     ?: null,
            'position'           => $this->p_position     ?: null,
            'dorsal'             => $this->p_dorsal !== '' ? (int) $this->p_dorsal : null,
            'phone'              => $this->p_phone        ?: null,
            'email'              => $this->p_email        ?: null,
            'federado'           => $this->p_federado,
            'categoria'          => $this->p_categoria    ?: null,
            'status'             => $this->p_status,
            'notes'              => $this->p_notes        ?: null,
            'extra_documents'    => array_values(array_merge($this->existing_extra_docs, $this->staged_extra_docs)) ?: null,
        ];

        // Photo
        if ($this->p_photo) {
            if ($this->existing_photo) Storage::disk('public')->delete($this->existing_photo);
            $data['photo'] = $this->p_photo->store('tournament-players/photos', 'public');
        } elseif ($this->clearPhoto && $this->existing_photo) {
            Storage::disk('public')->delete($this->existing_photo);
            $data['photo'] = null;
        }

        // Doc front
        if ($this->p_doc_front) {
            if ($this->existing_doc_front) Storage::disk('public')->delete($this->existing_doc_front);
            $data['doc_front'] = $this->p_doc_front->store('tournament-players/docs', 'public');
        } elseif ($this->clearDocFront && $this->existing_doc_front) {
            Storage::disk('public')->delete($this->existing_doc_front);
            $data['doc_front'] = null;
        }

        // Doc back
        if ($this->p_doc_back) {
            if ($this->existing_doc_back) Storage::disk('public')->delete($this->existing_doc_back);
            $data['doc_back'] = $this->p_doc_back->store('tournament-players/docs', 'public');
        } elseif ($this->clearDocBack && $this->existing_doc_back) {
            Storage::disk('public')->delete($this->existing_doc_back);
            $data['doc_back'] = null;
        }

        if ($this->player) {
            $this->player->update($data);
        } else {
            TournamentPlayer::create($data);
        }

        session()->flash('message', $this->player ? 'Jugador actualizado correctamente.' : 'Jugador añadido correctamente.');

        return redirect()->route('tournament.team.players', [$this->tournament, $this->tournamentTeam]);
    }

    public function cancel(): mixed
    {
        // Clean up staged files on cancel
        foreach ($this->staged_extra_docs as $doc) {
            Storage::disk('public')->delete($doc['path']);
        }

        return redirect()->route('tournament.team.players', [$this->tournament, $this->tournamentTeam]);
    }

    public function render()
    {
        return view('livewire.tournaments.team-player-form', [
            'docTypes'  => TournamentPlayer::docTypes(),
            'statuses'  => TournamentPlayer::statuses(),
            'positions' => TournamentPlayer::positions(),
        ]);
    }
}
