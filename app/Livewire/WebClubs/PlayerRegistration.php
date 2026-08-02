<?php

namespace App\Livewire\WebClubs;

use App\Models\Season;
use Livewire\Component;
use Livewire\WithFileUploads;

class PlayerRegistration extends Component
{
    use WithFileUploads;

    public $school;
    public $openInscriptionSeasons;

   /** Current wizard step (1-5) */
    public int $step = 1;

     // ── Step 5: Done ────────────────────────────────────────────────
    public bool   $done       = false;
    public string $doneMessage = '';

    public function mount()
    {
        $this->school = currentSchool();
        //comprueba que la url tiene una escuela asociada, si no la tiene aborta con error 404
        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        $now = now()->toDateString();

        $seasons = Season::where('sports_school_id', $this->school->id)->get();

        $this->openInscriptionSeasons = $seasons->filter(function($season) use ($now) {
            return $season->inscription_start_at && $season->inscription_end_at &&
                   $season->inscription_start_at <= $now &&
                   $season->inscription_end_at >= $now;
        });

       


    }

    public function render()
    {
        return view('livewire.webclubs.player-registration')
            ->layout('livewire.webclubs.layouts.app', [
                'title' => tenantName() . ' - Inscripción'
            ]);
    }
}
