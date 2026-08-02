<?php

namespace App\Livewire\WebClubs;

use Livewire\Component;
use App\Models\Tournament;

class Live extends Component
{
    public $school;
    public $tournaments;

    public function mount()
    {
        $this->school = currentSchool();
        // $this->tournaments = Tournament::where('sports_school_id', $this->school->id)->where('live', true)->get();
        // dd($this->tournaments);
        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        $this->tournaments = Tournament::where('sports_school_id', $this->school->id)
            ->where('live', true)
            ->whereNotIn('status', ['cancelled'])
            ->withCount('tournamentTeams')
            ->withCount('phases')
            ->orderByRaw("FIELD(status, 'registration_open', 'in_progress', 'completed', 'draft')")
            ->orderBy('start_date', 'asc')
            ->get();


            // dd($this->tournaments);

    }

    

    public function render()
    {
        return view('livewire.webclubs.live')->layout('livewire.webclubs.layouts.app_live');
    }
}
