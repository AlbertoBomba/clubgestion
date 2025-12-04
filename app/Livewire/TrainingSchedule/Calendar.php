<?php

namespace App\Livewire\TrainingSchedule;

use App\Models\TrainingField;
use App\Models\TrainingSchedule;
use App\Models\Team;
use App\Models\Season;
use Livewire\Component;
use Carbon\Carbon;

class Calendar extends Component
{
    public $seasonFilter;
    public $teamFilter = '';
    public $selectedField = null;
    public $selectedDay = null;
    public $selectedTime = null;
    
    // Modal para asignar equipo
    public $showModal = false;
    public $team_id = '';
    public $start_time = '';
    public $end_time = '';
    public $notes = '';

    // Modal para confirmar eliminación
    public $confirmingDeletion = false;
    public $scheduleToDelete = null;

    public $days = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    public $timeSlots = [];

    protected $rules = [
        'team_id' => 'required|exists:teams,id',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        // Obtener la temporada activa
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        $this->seasonFilter = $activeSeason ? $activeSeason->id : null;

        // Generar slots de tiempo (de 8:00 a 22:00 en intervalos de 30 minutos)
        $this->generateTimeSlots();
    }

    private function generateTimeSlots()
    {
        $start = Carbon::createFromTime(8, 0);
        $end = Carbon::createFromTime(22, 0);
        
        while ($start < $end) {
            $this->timeSlots[] = $start->format('H:i');
            $start->addMinutes(15);
        }
    }

    private function generateDynamicTimeSlots($fields)
    {
        // Encontrar el rango de horas más amplio entre todos los campos activos
        $earliestTime = null;
        $latestTime = null;

        foreach ($fields as $field) {
            if ($field->available_from && $field->available_to) {
                $from = Carbon::parse($field->available_from);
                $to = Carbon::parse($field->available_to);

                if ($earliestTime === null || $from->lt($earliestTime)) {
                    $earliestTime = $from;
                }
                if ($latestTime === null || $to->gt($latestTime)) {
                    $latestTime = $to;
                }
            }
        }

        // Si no hay campos con horarios definidos, usar horario por defecto
        if ($earliestTime === null || $latestTime === null) {
            $this->generateTimeSlots();
            return;
        }

        // Generar slots desde la hora más temprana hasta la más tardía en intervalos de 15 minutos
        $this->timeSlots = [];
        $current = $earliestTime->copy();
        
        while ($current->lt($latestTime)) {
            $this->timeSlots[] = $current->format('H:i');
            $current->addMinutes(15);
        }
    }

    public function openAssignModal($fieldId, $day, $time)
    {
        $this->selectedField = $fieldId;
        $this->selectedDay = $day;
        $this->selectedTime = $time;
        
        // Pre-llenar horarios con valores por defecto (usuario puede cambiarlos libremente)
        $this->start_time = $time;
        $this->end_time = Carbon::createFromFormat('H:i', $time)->addMinutes(60)->format('H:i');
        
        $this->showModal = true;
        
        // Resetear team_id para forzar nueva selección con el filtro aplicado
        $this->team_id = '';
    }

    public function saveSchedule()
    {
        $this->validate();

        $user = auth()->user();

        // Validar que el equipo no tenga otro entrenamiento en el mismo día y horario que se solape
        $hasConflict = TrainingSchedule::where('team_id', $this->team_id)
            ->where('season_id', $this->seasonFilter)
            ->where('day_of_week', $this->selectedDay)
            ->where(function($query) {
                // Verificar solapamiento de horarios
                $query->where(function($q) {
                    // El nuevo entrenamiento empieza durante un entrenamiento existente
                    $q->where('start_time', '<=', $this->start_time)
                      ->where('end_time', '>', $this->start_time);
                })->orWhere(function($q) {
                    // El nuevo entrenamiento termina durante un entrenamiento existente
                    $q->where('start_time', '<', $this->end_time)
                      ->where('end_time', '>=', $this->end_time);
                })->orWhere(function($q) {
                    // El nuevo entrenamiento cubre completamente un entrenamiento existente
                    $q->where('start_time', '>=', $this->start_time)
                      ->where('end_time', '<=', $this->end_time);
                });
            })
            ->exists();

        if ($hasConflict) {
            $this->addError('team_id', 'Este equipo ya tiene un entrenamiento en este día y horario.');
            return;
        }

        TrainingSchedule::create([
            'team_id' => $this->team_id,
            'training_field_id' => $this->selectedField,
            'season_id' => $this->seasonFilter,
            'day_of_week' => $this->selectedDay,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'notes' => $this->notes,
            'created_user' => $user->id,
        ]);

        session()->flash('message', 'Horario asignado correctamente.');
        $this->closeModal();
    }

    public function confirmDelete($scheduleId)
    {
        $this->scheduleToDelete = $scheduleId;
        $this->confirmingDeletion = true;
    }

    public function deleteSchedule()
    {
        $schedule = TrainingSchedule::findOrFail($this->scheduleToDelete);
        $schedule->delete();

        session()->flash('message', 'Horario eliminado correctamente.');
        
        $this->confirmingDeletion = false;
        $this->scheduleToDelete = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->team_id = '';
        $this->notes = '';
        $this->resetValidation();
    }

    public function render()
    {
        $user = auth()->user();

        $fields = TrainingField::where('sports_school_id', $user->sports_school_id)
            ->where('active', true)
            ->with('sections')
            ->orderBy('name')
            ->get();

        // Generar slots de tiempo dinámicamente basados en la disponibilidad de los campos
        $this->generateDynamicTimeSlots($fields);

        $schedulesQuery = TrainingSchedule::with(['team.category', 'trainingField'])
            ->where('season_id', $this->seasonFilter)
            ->whereHas('trainingField', function($query) use ($user) {
                $query->where('sports_school_id', $user->sports_school_id);
            });

        // Filtrar por equipo si se ha seleccionado
        if ($this->teamFilter) {
            $schedulesQuery->where('team_id', $this->teamFilter);
        }

        $schedules = $schedulesQuery->get()
            ->groupBy(['training_field_id', 'day_of_week']);

        // Obtener la temporada activa (en curso)
        $activeSeason = Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Solo mostrar equipos de la temporada activa en el modal
        $teams = Team::where('season_id', $activeSeason?->id)
            ->orderBy('team')
            ->get();

        // Si hay un campo seleccionado en el modal, filtrar equipos por sección
        if ($this->selectedField) {
            $field = $fields->find($this->selectedField);
            if ($field) {
                // Obtener IDs de las secciones del campo
                $sectionIds = $field->sections->pluck('id')->toArray();
                
                // Filtrar equipos que tengan alguna de estas secciones
                $teams = Team::where('season_id', $activeSeason?->id)
                    ->whereIn('section_id', $sectionIds)
                    ->orderBy('team')
                    ->get();
            }
        }

        // Para el filtro, mostrar solo equipos de la temporada activa (en curso)
        $teamsForFilter = Team::where('season_id', $activeSeason?->id)
            ->orderBy('team')
            ->get();

        $seasons = Season::orderBy('season', 'desc')->get();

        return view('livewire.training-schedule.calendar', [
            'fields' => $fields,
            'schedules' => $schedules,
            'teams' => $teams,
            'teamsForFilter' => $teamsForFilter,
            'seasons' => $seasons,
            'activeSeason' => $activeSeason,
        ]);
    }
}
