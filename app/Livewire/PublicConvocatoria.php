<?php

namespace App\Livewire;

use App\Models\SeasonMatch;
use App\Models\Player;
use Livewire\Component;

class PublicConvocatoria extends Component
{
    public $matchId;
    public $token;
    
    // Confirmation modal
    public $showConfirmModal = false;
    public $selectedPlayerId = null;
    public $selectedPlayerName = '';
    public $selectedPlayerSurname = '';
    public $selectedPlayerPhoto = '';
    public $dniInput = '';
    public $confirmationError = '';

    public function mount($token)
    {
        $match = SeasonMatch::where('share_token', $token)
            ->with(['team.season.sportsSchool', 'season'])
            ->firstOrFail();

        $this->matchId = $match->id;
        $this->token = $token;
    }

    public function openConfirmModal($playerId)
    {
        $player = Player::find($playerId);
        
        if ($player) {
            $this->selectedPlayerId = $playerId;
            $this->selectedPlayerName = $player->name;
            $this->selectedPlayerSurname = $player->surname;
            $this->selectedPlayerPhoto = $player->player_photo;
            $this->dniInput = '';
            $this->confirmationError = '';
            $this->showConfirmModal = true;
        }
    }

    public function closeConfirmModal()
    {
        $this->showConfirmModal = false;
        $this->selectedPlayerId = null;
        $this->selectedPlayerName = '';
        $this->selectedPlayerSurname = '';
        $this->selectedPlayerPhoto = '';
        $this->dniInput = '';
        $this->confirmationError = '';
    }

    public function confirmAttendance()
    {
        $this->confirmationError = '';

        // Validate DNI input
        if (empty($this->dniInput)) {
            $this->confirmationError = 'Por favor, introduce tu DNI.';
            return;
        }

        // Find the player
        $player = Player::find($this->selectedPlayerId);
        
        if (!$player) {
            $this->confirmationError = 'Jugador no encontrado.';
            return;
        }

        // Validate DNI matches
        if (strtoupper(trim($player->dni)) !== strtoupper(trim($this->dniInput))) {
            $this->confirmationError = 'El DNI no coincide con el del jugador.';
            return;
        }

        // Get match
        $match = SeasonMatch::find($this->matchId);
        
        // Update confirmation in pivot table
        $match->players()->updateExistingPivot($player->id, [
            'confirmed' => true,
            'confirmed_at' => now(),
            'updated_at' => now(),
        ]);

        // Close modal and show success
        $this->closeConfirmModal();
        session()->flash('confirmation_success', 'Convocatoria confirmada correctamente.');
    }

    public function render()
    {
        // Load match with fresh data every time
        $match = SeasonMatch::where('id', $this->matchId)
            ->with(['team.season.sportsSchool', 'season'])
            ->firstOrFail();

        $team = $match->team;

        // Get called players with pivot data and their teams
        $calledPlayers = $match->players()
            ->wherePivot('reason_not_called', null)
            ->with('teams')
            ->orderBy('position')
            ->orderBy('surname')
            ->get();

        return view('livewire.public-convocatoria', [
            'match' => $match,
            'team' => $team,
            'calledPlayers' => $calledPlayers
        ])->layout('layouts.guest');
    }
}
