<?php

namespace App\Livewire\WebClubs;

use Livewire\Component;

class About extends Component
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
        return view('livewire.webclubs.about')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Sobre Nosotros'
            ]);
    }
}
