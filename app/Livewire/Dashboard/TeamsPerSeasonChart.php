<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamsPerSeasonChart extends Component
{
    public $chartData;
    public $seasons;
    public $totalTeams;

    public function mount()
    {
        // Verificar que el usuario es school_admin y tiene sports_school_id
        if (!auth()->user()->hasRole('school_admin') || !auth()->user()->sports_school_id) {
            abort(403, 'No tienes permisos para ver esta información.');
        }

        $sportsSchoolId = auth()->user()->sports_school_id;

        // Obtener las últimas 6 temporadas de la escuela del usuario
        $this->seasons = Season::where('sports_school_id', $sportsSchoolId)
            ->orderBy('from_year', 'desc')
            ->take(6)
            ->get()
            ->reverse()
            ->values();

        // Obtener el conteo de equipos por temporada
        $teamsData = [];
        $this->totalTeams = 0;

        foreach ($this->seasons as $season) {
            $count = Team::where('season_id', $season->id)
                ->count();
            
            $teamsData[] = $count;
            $this->totalTeams += $count;
        }

        // Preparar datos para el gráfico
        $this->chartData = [
            'labels' => $this->seasons->pluck('season')->toArray(),
            'data' => $teamsData,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.teams-per-season-chart');
    }
}
