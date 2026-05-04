<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use Livewire\Component;

class Tournaments extends Component
{
    public $school;
    public $tournaments;

    public function mount(): void
    {
        $this->school = currentSchool();

        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        $this->tournaments = Tournament::where('sports_school_id', $this->school->id)
            ->where('visibility', 'public')
            ->whereNotIn('status', ['cancelled'])
            ->withCount('tournamentTeams')
            ->withCount('phases')
            ->orderByRaw("FIELD(status, 'registration_open', 'in_progress', 'completed', 'draft')")
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.webclubs.tournaments')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Torneos',
            ]);
    }
}
