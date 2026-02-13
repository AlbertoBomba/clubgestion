<?php

namespace App\Livewire\WebClubs;

use Livewire\Component;

class Contact extends Component
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
        return view('livewire.webclubs.contact')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Contacto'
            ]);
    }
}
