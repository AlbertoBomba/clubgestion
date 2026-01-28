<div>
    @php
        $daysOfWeek = [
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo',
        ];
    @endphp

    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <h3 class="text-2xl font-semibold text-gray-800">Horarios de Entrenamiento</h3>
            </div>
            
            @if(!$schedulesByDay->isEmpty())
                <button wire:click="exportPdf" 
                        wire:loading.attr="disabled"
                        wire:target="exportPdf"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition disabled:opacity-50">
                    <svg wire:loading.remove wire:target="exportPdf" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <svg wire:loading wire:target="exportPdf" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="exportPdf">Exportar PDF</span>
                    <span wire:loading wire:target="exportPdf">Generando...</span>
                </button>
            @endif
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Temporada</label>
                    <select wire:model.live="seasonFilter" 
                        disabled
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent text-gray-700 text-sm bg-gray-100 cursor-not-allowed">
                        <option value="">Todas las temporadas</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">
                                {{ $season->season }}
                                @if($activeSeason && $season->id === $activeSeason->id)
                                    🟢 (Temporada en curso)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Equipo</label>
                    <select wire:model.live="teamFilter" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-gray-400 focus:ring-2 focus:ring-gray-400 text-gray-700 text-sm">
                        <option value="">Todos los equipos</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->team }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    @if($schedulesByDay->isEmpty())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-700 mb-2">No hay entrenamientos programados</h3>
            <p class="text-gray-500 text-sm">Selecciona una temporada o añade horarios de entrenamiento.</p>
        </div>
    @else
        <!-- Tabla de horarios -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrenadores</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jugadores</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horarios de Entrenamiento</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        // Agrupar por equipo
                        $schedulesByTeam = $schedulesByDay->flatten(1)->groupBy('team_id');
                    @endphp
                    
                    @foreach($schedulesByTeam as $teamId => $teamSchedules)
                        @php
                            $team = $teamSchedules->first()->team;
                            // Agrupar por horario + campo para mostrar días juntos
                            $groupedSchedules = $teamSchedules->groupBy(function($schedule) {
                                return $schedule->start_time . '|' . $schedule->end_time . '|' . $schedule->training_field_id . '|' . ($schedule->notes ?? '');
                            });
                        @endphp
                        
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $team->team }}</div>
                                        @if($team->category)
                                            <div class="text-xs text-gray-500">{{ $team->category->category }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                @if($team->coaches->count() > 0)
                                    <div class="space-y-1">
                                        @foreach($team->coaches as $coach)
                                            <div class="text-sm text-gray-700">{{ $coach->name }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Sin entrenadores</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold">
                                    {{ $team->players->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-3">
                                    @foreach($groupedSchedules as $timeKey => $schedules)
                                        @php
                                            $firstSchedule = $schedules->first();
                                            $days = $schedules->pluck('day_of_week')->map(function($day) use ($daysOfWeek) {
                                                return $daysOfWeek[$day] ?? $day;
                                            })->toArray();
                                            $daysText = implode(', ', $days);
                                            
                                            $start = \Carbon\Carbon::parse($firstSchedule->start_time);
                                            $end = \Carbon\Carbon::parse($firstSchedule->end_time);
                                            $duration = $start->diff($end);
                                            $hours = $duration->h;
                                            $minutes = $duration->i;
                                            $durationText = ($hours > 0 ? $hours . 'h ' : '') . $minutes . 'min';
                                        @endphp
                                        
                                        <div class="flex items-start gap-6 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-1">
                                                    <span class="text-sm font-medium text-gray-700">{{ $daysText }}</span>
                                                    <span class="text-sm font-semibold text-gray-900">
                                                        {{ \Carbon\Carbon::parse($firstSchedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($firstSchedule->end_time)->format('H:i') }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                        {{ $durationText }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $firstSchedule->trainingField->color }}"></div>
                                                    <span class="text-xs text-gray-600">{{ $firstSchedule->trainingField->name }}</span>
                                                </div>
                                                @if($firstSchedule->notes)
                                                    <div class="text-xs text-gray-500 mt-1 italic">{{ $firstSchedule->notes }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
