<?php

namespace App\Livewire\TrainingSchedule;

use App\Models\TrainingSchedule;
use App\Models\Season;
use App\Models\Team;
use App\Models\Section;
use Livewire\Component;
use Carbon\Carbon;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

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

    public function exportPdf()
    {
        $user = auth()->user();

        // Obtener horarios de la temporada seleccionada
        $schedulesQuery = TrainingSchedule::with(['team.category', 'team.section', 'trainingField'])
            ->where('season_id', $this->seasonFilter)
            ->whereHas('trainingField', function($query) use ($user) {
                $query->where('sports_school_id', $user->sports_school_id);
            });

        // Aplicar filtros
        if ($this->teamFilter) {
            $schedulesQuery->where('team_id', $this->teamFilter);
        }

        if ($this->sectionFilter) {
            $schedulesQuery->whereHas('team', function($query) {
                $query->where('section_id', $this->sectionFilter);
            });
        }

        $schedules = $schedulesQuery->get();
        
        // Agrupar por equipo
        $schedulesByTeam = $schedules->groupBy('team_id');
        
        // Obtener temporada
        $season = Season::find($this->seasonFilter);
        
        // Días de la semana
        $daysOfWeek = [
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo',
        ];

        // Generar HTML para el PDF
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    color: #333;
                }
                h1 {
                    text-align: center;
                    color: #1e40af;
                    margin-bottom: 10px;
                }
                .season-badge {
                    text-align: center;
                    color: #059669;
                    font-weight: bold;
                    margin-bottom: 20px;
                }
                .team-section {
                    margin-bottom: 25px;
                    page-break-inside: avoid;
                }
                .team-header {
                    background: linear-gradient(to right, #1e40af, #1e3a8a);
                    color: white;
                    padding: 12px;
                    border-radius: 8px 8px 0 0;
                    font-size: 16px;
                    font-weight: bold;
                }
                .team-body {
                    border: 1px solid #e5e7eb;
                    border-top: none;
                    border-radius: 0 0 8px 8px;
                    padding: 15px;
                }
                .schedule-row {
                    background: #f9fafb;
                    padding: 10px;
                    margin-bottom: 8px;
                    border-radius: 6px;
                    display: table;
                    width: 100%;
                }
                .day-name {
                    display: table-cell;
                    width: 120px;
                    font-weight: bold;
                    color: #1e40af;
                    vertical-align: top;
                    padding-right: 15px;
                }
                .schedule-details {
                    display: table-cell;
                    vertical-align: top;
                }
                .time-slot {
                    font-weight: bold;
                    color: #111827;
                    margin-bottom: 5px;
                }
                .field-info {
                    color: #6b7280;
                    font-size: 11px;
                }
                .field-color {
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    margin-right: 5px;
                    vertical-align: middle;
                }
                .category-badge {
                    background: #dbeafe;
                    color: #1e40af;
                    padding: 4px 10px;
                    border-radius: 12px;
                    font-size: 11px;
                    margin-left: 10px;
                }
                .section-name {
                    color: rgba(255, 255, 255, 0.8);
                    font-size: 11px;
                    margin-top: 2px;
                }
                .duration-badge {
                    background: #e5e7eb;
                    color: #6b7280;
                    padding: 2px 8px;
                    border-radius: 10px;
                    font-size: 10px;
                    margin-left: 8px;
                }
                .notes-box {
                    background: #eff6ff;
                    border-left: 3px solid #3b82f6;
                    padding: 8px;
                    margin-top: 8px;
                    font-size: 11px;
                    color: #1e40af;
                    border-radius: 4px;
                }
                .schedule-item {
                    margin-bottom: 12px;
                    padding-bottom: 12px;
                    border-bottom: 1px solid #e5e7eb;
                }
                .schedule-item:last-child {
                    border-bottom: none;
                    margin-bottom: 0;
                    padding-bottom: 0;
                }
            </style>
        </head>
        <body>
            <h1>Horarios de Entrenamiento</h1>
            <div class="season-badge">Temporada: ' . ($season ? $season->season : 'N/A') . '</div>
        ';

        foreach ($schedulesByTeam as $teamId => $teamSchedules) {
            $team = $teamSchedules->first()->team;
            
            $html .= '
            <div class="team-section">
                <div class="team-header">
                    <div>
                        ' . $team->team;
            
            if ($team->section) {
                $html .= '<div class="section-name">' . $team->section->name . '</div>';
            }
            
            $html .= '</div>';
            
            if ($team->category) {
                $html .= '<span class="category-badge">' . $team->category->category . '</span>';
            }
            
            $html .= '
                </div>
                <div class="team-body">';
            
            // Agrupar por horario + campo + notas para mostrar días juntos
            $groupedSchedules = $teamSchedules->groupBy(function($schedule) {
                return $schedule->start_time . '|' . $schedule->end_time . '|' . $schedule->training_field_id . '|' . ($schedule->notes ?? '');
            });
            
            foreach ($groupedSchedules as $timeKey => $schedules) {
                $firstSchedule = $schedules->first();
                
                // Obtener todos los días de este grupo
                $days = $schedules->pluck('day_of_week')->map(function($day) use ($daysOfWeek) {
                    return $daysOfWeek[$day] ?? $day;
                })->toArray();
                $daysText = implode(', ', $days);
                
                $startTime = Carbon::parse($firstSchedule->start_time)->format('H:i');
                $endTime = Carbon::parse($firstSchedule->end_time)->format('H:i');
                
                // Calcular duración
                $start = Carbon::parse($firstSchedule->start_time);
                $end = Carbon::parse($firstSchedule->end_time);
                $diffInMinutes = $start->diffInMinutes($end);
                $hours = floor($diffInMinutes / 60);
                $minutes = $diffInMinutes % 60;
                $durationText = '';
                if ($hours > 0) {
                    $durationText .= $hours . 'h ';
                }
                $durationText .= $minutes . 'min';
                
                $html .= '
                <div class="schedule-row">
                    <div class="day-name">📅 ' . $daysText . '</div>
                    <div class="schedule-details">
                        <div class="schedule-item">
                            <div class="time-slot">
                                ⏰ ' . $startTime . ' - ' . $endTime . '
                                <span class="duration-badge">' . $durationText . '</span>
                            </div>
                            <div class="field-info">
                                <span class="field-color" style="background-color: ' . $firstSchedule->trainingField->color . '"></span>
                                ' . $firstSchedule->trainingField->name . '
                            </div>';
                
                if ($firstSchedule->notes) {
                    $html .= '
                            <div class="notes-box">
                                ℹ️ ' . htmlspecialchars($firstSchedule->notes) . '
                            </div>';
                }
                
                $html .= '
                        </div>
                    </div>
                </div>';
            }
            
            $html .= '
                </div>
            </div>';
        }

        $html .= '
        </body>
        </html>';

        // Crear PDF con LaravelMpdf
        $pdf = LaravelMpdf::loadHtml($html, [
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
            'author' => 'SVA Club Portal',
        ]);

        $filename = 'horarios_entrenamiento_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return response()->streamDownload(function() use ($pdf, $filename) {
            echo $pdf->output($filename);
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
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
