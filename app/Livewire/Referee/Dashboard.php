<?php

namespace App\Livewire\Referee;

use App\Models\Tournament;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Obtener torneos asignados al árbitro actual
        $tournaments = Tournament::whereHas('referees', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->with(['sportsSchool', 'matches' => function ($query) {
            $query->orderBy('scheduled_at', 'desc');
        }])
        ->orderBy('start_date', 'desc')
        ->get();

        // Estadísticas del árbitro
        $stats = [
            'total_tournaments' => $tournaments->count(),
            'total_matches' => $tournaments->sum(fn($t) => $t->matches->count()),
            'completed_matches' => $tournaments->sum(fn($t) => $t->matches->where('status', 'completed')->count()),
            'pending_matches' => $tournaments->sum(fn($t) => $t->matches->whereIn('status', ['scheduled', 'in_progress'])->count()),
        ];

        return view('livewire.referee.dashboard', compact('tournaments', 'stats'));
    }
}
