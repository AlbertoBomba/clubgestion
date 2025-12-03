<?php

namespace App\Livewire\TrainingSchedule;

use App\Models\TrainingSchedule;
use App\Models\Season;
use App\Models\Team;
use App\Models\Section;
use Livewire\Component;
use Carbon\Carbon;

class ScheduleView extends Component
{
    public $seasonFilter;
    public $teamFilter = '';
    public $sectionFilter = '';

    public function mount()
    {
        // Obtener la temporada activa
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        $this->seasonFilter = $activeSeason ? $activeSeason->id : null;
    }

    public function render()
    {
        $user = auth()->user();

        // Obtener horarios de la temporada seleccionada
        $schedulesQuery = TrainingSchedule::with(['team.category', 'team.section', 'trainingField'])
            ->where('season_id', $this->seasonFilter)
            ->whereHas('trainingField', function($query) use ($user) {
                $query->where('sports_school_id', $user->sports_school_id);
            });

        // Filtrar por equipo si se ha seleccionado
        if ($this->teamFilter) {
            $schedulesQuery->where('team_id', $this->teamFilter);
        }

        // Filtrar por sección si se ha seleccionado
        if ($this->sectionFilter) {
            $schedulesQuery->whereHas('team', function($query) {
                $query->where('section_id', $this->sectionFilter);
            });
        }

        $schedules = $schedulesQuery->get();

        // Agrupar por día de la semana y ordenar por hora
        $schedulesByDay = $schedules->groupBy('day_of_week')->map(function($daySchedules) {
            return $daySchedules->sortBy('start_time');
        });

        // Obtener temporadas y equipos para filtros
        $seasons = Season::orderBy('season', 'desc')->get();
        
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        $teams = Team::where('season_id', $activeSeason?->id)
            ->with('category')
            ->orderBy('team')
            ->get();

        // Obtener secciones de la temporada activa
        $sections = Section::whereHas('seasons', function($query) use ($activeSeason) {
            $query->where('seasons.id', $activeSeason?->id);
        })->orderBy('name')->get();

        return view('livewire.training-schedule.schedule-view', [
            'schedulesByDay' => $schedulesByDay,
            'seasons' => $seasons,
            'teams' => $teams,
            'sections' => $sections,
            'activeSeason' => $activeSeason,
        ]);
    }
}
