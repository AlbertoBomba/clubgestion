<?php

namespace App\Livewire\WebClubs;

use Livewire\Component;

class PanelPlayerSchool extends Component
{

public $school;

public function mount()
    {
        $this->school = currentSchool();
        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

    }

    public function render()
    {
        return view('livewire.webclubs.panel-player-school')->layout('livewire.webclubs.layouts.app');;
    }

}
