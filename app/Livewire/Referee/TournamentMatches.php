<?php

namespace App\Livewire\Referee;

use App\Models\Tournament;
use Livewire\Component;

class TournamentMatches extends Component
{
    public Tournament $tournament;
    public ?int $selectedRound = null;

    public function mount(Tournament $tournament)
    {
        // Verificar que el árbitro está asignado a este torneo
        if (!$tournament->referees()->where('user_id', auth()->id())->exists()) {
            abort(403, 'No tienes acceso a este torneo.');
        }

        $this->tournament = $tournament;
        
        // Seleccionar automáticamente la jornada más cercana a la fecha actual
        $now = now();
        
        // Primero buscar jornadas con partidos en curso
        $currentRound = $this->tournament->matches()
            ->where('status', 'in_progress')
            ->value('round');
        
        if (!$currentRound) {
            // Buscar la jornada con partidos más cercanos a hoy
            $closestMatch = $this->tournament->matches()
                ->whereNotNull('scheduled_at')
                ->selectRaw('round, MIN(ABS(TIMESTAMPDIFF(SECOND, scheduled_at, ?))) as time_diff', [$now])
                ->groupBy('round')
                ->orderBy('time_diff')
                ->first();
            
            $currentRound = $closestMatch?->round;
        }
        
        if (!$currentRound) {
            // Si no hay partidos con fecha, usar la última jornada
            $currentRound = $this->tournament->matches()
                ->orderBy('round', 'desc')
                ->value('round');
        }
        
        $this->selectedRound = $currentRound;
    }

    public function selectRound($round)
    {
        $this->selectedRound = $round;
    }

    public function render()
    {
        // Obtener todas las jornadas únicas
        $rounds = $this->tournament->matches()
            ->whereNotNull('round')
            ->distinct()
            ->orderBy('round')
            ->pluck('round')
            ->toArray();

        // Obtener partidos de la jornada seleccionada
        $matches = collect([]);
        if ($this->selectedRound) {
            $matches = $this->tournament->matches()
                ->where('round', $this->selectedRound)
                ->with(['homeTeam.team', 'awayTeam.team', 'phase'])
                ->orderByRaw("CASE 
                    WHEN status = 'in_progress' THEN 1
                    WHEN status = 'scheduled' THEN 2
                    WHEN status = 'completed' THEN 3
                    ELSE 4
                END")
                ->orderBy('scheduled_at')
                ->get();
        }

        // Calcular estadísticas generales del torneo
        $stats = [
            'in_progress' => $this->tournament->matches()->where('status', 'in_progress')->count(),
            'scheduled' => $this->tournament->matches()->where('status', 'scheduled')->count(),
            'completed' => $this->tournament->matches()->where('status', 'completed')->count(),
        ];

        return view('livewire.referee.tournament-matches', compact('rounds', 'matches', 'stats'));
    }
}
