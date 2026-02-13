<?php

namespace App\Livewire\WebClubs;

use Livewire\Component;

class PlayerRegistration extends Component
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
        return view('livewire.webclubs.player-registration')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Inscripción'
            ]);
    }
}
