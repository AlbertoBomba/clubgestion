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
                <h3 class="text-2xl font-bold text-gray-900">Horarios de Entrenamiento</h3>
                {{-- @if($activeSeason)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $activeSeason->season }} en curso
                    </span>
                @endif --}}
            </div>
            
            @if(!$schedulesByDay->isEmpty())
                <button wire:click="exportPdf" 
                        wire:loading.attr="disabled"
                        wire:target="exportPdf"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                    <svg wire:loading.remove wire:target="exportPdf" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <svg wire:loading wire:target="exportPdf" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="exportPdf">Exportar PDF</span>
                    <span wire:loading wire:target="exportPdf">Generando...</span>
                </button>
            @endif
        </div>

        <!-- Filtros -->
        <div class="bg-white-pure rounded-xl shadow-md border border-primary/10 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Temporada</label>
                    <select wire:model.live="seasonFilter" 
                        class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Filtrar por Equipo</label>
                    <select wire:model.live="teamFilter" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
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
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay entrenamientos programados</h3>
            <p class="text-gray-500">Selecciona una temporada o añade horarios de entrenamiento.</p>
        </div>
    @else
        <!-- Listado de equipos con horarios -->
        <div class="space-y-4">
            @php
                // Agrupar por equipo
                $schedulesByTeam = $schedulesByDay->flatten(1)->groupBy('team_id');
            @endphp
            
            @foreach($schedulesByTeam as $teamId => $teamSchedules)
                @php
                    $team = $teamSchedules->first()->team;
                @endphp
                
                <div class="bg-white-pure rounded-xl shadow-md border border-primary/10 overflow-hidden">
                    <!-- Cabecera del equipo -->
                    <div class="bg-gradient-to-r from-primary to-night-blue px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ $team->team }}</h3>
                                    @if($team->section)
                                        <p class="text-sm text-white/80 mt-0.5">{{ $team->section->name }}</p>
                                    @endif
                                </div>
                                @if($team->category)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white">
                                        {{ $team->category->category }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Horarios del equipo -->
                    <div class="p-6">
                        @php
                            // Agrupar por horario + campo para mostrar días juntos
                            $groupedSchedules = $teamSchedules->groupBy(function($schedule) {
                                return $schedule->start_time . '|' . $schedule->end_time . '|' . $schedule->training_field_id . '|' . ($schedule->notes ?? '');
                            });
                        @endphp
                        
                        <div class="space-y-3">
                            @foreach($groupedSchedules as $timeKey => $schedules)
                                @php
                                    $firstSchedule = $schedules->first();
                                    $days = $schedules->pluck('day_of_week')->map(function($day) use ($daysOfWeek) {
                                        return $daysOfWeek[$day] ?? $day;
                                    })->toArray();
                                    $daysText = implode(', ', $days);
                                @endphp
                                
                                <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-sm font-bold text-primary">{{ $daysText }}</span>
                                            </div>
                                            
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-base font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($firstSchedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($firstSchedule->end_time)->format('H:i') }}
                                            </span>
                                            @php
                                                $start = \Carbon\Carbon::parse($firstSchedule->start_time);
                                                $end = \Carbon\Carbon::parse($firstSchedule->end_time);
                                                $duration = $start->diff($end);
                                                $hours = $duration->h;
                                                $minutes = $duration->i;
                                            @endphp
                                            <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded-full">
                                                @if($hours > 0){{ $hours }}h @endif{{ $minutes }}min
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $firstSchedule->trainingField->color }}"></div>
                                            <span class="text-sm text-gray-600">{{ $firstSchedule->trainingField->name }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($firstSchedule->notes)
                                        <div class="mt-2 flex items-start gap-2 text-sm text-gray-600 bg-blue-50 p-2 rounded-lg">
                                            <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="flex-1">{{ $firstSchedule->notes }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
