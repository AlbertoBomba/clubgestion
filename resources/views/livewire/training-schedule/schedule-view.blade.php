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

    <!-- Header con filtros -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <h3 class="text-2xl font-bold text-gray-900">Horarios de Entrenamiento</h3>
                @if($activeSeason)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $activeSeason->season }} en curso
                    </span>
                @endif
            </div>
        </div>

        <!-- Filtros -->
        <div class="card-modern bg-white-pure rounded-xl shadow-md border border-primary/10 p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase">Filtrar por Equipo</label>
                    <select wire:model.live="teamFilter" class="w-full rounded-lg border-silver shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                        <option value="">Todos los equipos</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->team }} - {{ $team->category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase">Filtrar por Sección</label>
                    <select wire:model.live="sectionFilter" class="w-full rounded-lg border-silver shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                        <option value="">Todas las secciones</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2 uppercase">Temporada</label>
                    <select wire:model.live="seasonFilter" class="w-full rounded-lg border-silver shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->season }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    @if($schedulesByDay->isEmpty())
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay entrenamientos programados</h3>
            <p class="text-gray-500">Selecciona una temporada o añade horarios de entrenamiento.</p>
        </div>
    @else
        <!-- Vista de tabla semanal -->
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-primary uppercase tracking-wider border-r border-gray-200">
                                Hora
                            </th>
                            @foreach($daysOfWeek as $dayKey => $dayName)
                                @php
                                    $daySchedules = $schedulesByDay->get($dayKey, collect());
                                @endphp
                                <th class="px-6 py-4 text-center text-xs font-bold text-primary uppercase tracking-wider border-r border-gray-200 last:border-r-0">
                                    <div class="flex flex-col items-center gap-1">
                                        <span>{{ $dayName }}</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                                            {{ $daySchedules->count() }}
                                        </span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white-pure divide-y divide-gray-200">
                        @php
                            // Obtener todas las horas únicas de todos los horarios
                            $allTimes = $schedulesByDay->flatten(1)->map(function($schedule) {
                                return \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                            })->unique()->sort()->values();
                        @endphp

                        @forelse($allTimes as $timeSlot)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 bg-gray-50">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-bold text-sm text-gray-900">{{ $timeSlot }}</span>
                                    </div>
                                </td>
                                @foreach($daysOfWeek as $dayKey => $dayName)
                                    @php
                                        $daySchedules = $schedulesByDay->get($dayKey, collect());
                                        $schedulesAtTime = $daySchedules->filter(function($schedule) use ($timeSlot) {
                                            return \Carbon\Carbon::parse($schedule->start_time)->format('H:i') === $timeSlot;
                                        });
                                    @endphp
                                    <td class="px-4 py-3 border-r border-gray-200 last:border-r-0 align-top">
                                        @if($schedulesAtTime->count() > 0)
                                            <div class="space-y-2">
                                                @foreach($schedulesAtTime as $schedule)
                                                    @php
                                                        // Generar color único basado en el ID del equipo
                                                        $hash = md5($schedule->team_id);
                                                        $r = hexdec(substr($hash, 0, 2));
                                                        $g = hexdec(substr($hash, 2, 2));
                                                        $b = hexdec(substr($hash, 4, 2));
                                                        
                                                        $max = max($r, $g, $b);
                                                        if ($max > 0) {
                                                            $r = (int)(($r / $max) * 200 + 55);
                                                            $g = (int)(($g / $max) * 200 + 55);
                                                            $b = (int)(($b / $max) * 200 + 55);
                                                        }
                                                        
                                                        $teamColor = sprintf('#%02X%02X%02X', $r, $g, $b);
                                                        
                                                        // Calcular luminosidad para determinar si usar texto blanco o negro
                                                        $luminosity = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
                                                        $textColor = $luminosity > 0.5 ? '#000000' : '#FFFFFF';
                                                    @endphp
                                                    
                                                    <div class="p-3 rounded-lg border-l-4 shadow-sm hover:shadow-md transition-all" 
                                                         style="border-color: {{ $teamColor }}; background: linear-gradient(to right, {{ $teamColor }}10, transparent)">
                                                        
                                                        <!-- Horario, Equipo y Sección en la misma fila -->
                                                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                            <!-- Duración -->
                                                            <div class="text-xs font-semibold text-gray-600">
                                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                            </div>
                                                            
                                                            <!-- Equipo -->
                                                            <div class="inline-flex items-center px-2.5 py-1 rounded-md font-bold text-xs shadow-sm" 
                                                                 style="background-color: {{ $teamColor }}; color: {{ $textColor }}">
                                                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                                </svg>
                                                                {{ $schedule->team->team }}
                                                            </div>
                                                            
                                                            <!-- Sección -->
                                                            @if($schedule->team->section)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold text-white shadow-sm"
                                                                      style="background-color: {{ $schedule->team->section->color ?? '#8B5CF6' }}">
                                                                    {{ $schedule->team->section->name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Campo -->
                                                        <div class="flex items-center gap-1.5 mb-2">
                                                            <div class="w-3 h-3 rounded-full shadow-sm border border-white" 
                                                                 style="background-color: {{ $schedule->trainingField->color }}"></div>
                                                            <span class="text-xs font-medium text-gray-700">
                                                                {{ $schedule->trainingField->name }}
                                                            </span>
                                                        </div>
                                                        
                                                        <!-- Notas -->
                                                        @if($schedule->notes)
                                                            <div class="mt-2 pt-2 border-t border-gray-200">
                                                                <p class="text-xs text-gray-600 italic">
                                                                    💬 {{ $schedule->notes }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <span class="text-gray-300 text-xs">-</span>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">No hay entrenamientos en esta franja horaria</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>        <!-- Leyenda de campos -->
        <div class="mt-8 card-modern bg-white-pure rounded-xl shadow-md border border-primary/10 p-6">
            <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wide flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Campos de Entrenamiento
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @php
                    $allFields = $schedulesByDay->flatten(1)->pluck('trainingField')->unique('id');
                @endphp
                @foreach($allFields as $field)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                        <div class="w-6 h-6 rounded-full shadow-md border-2 border-white flex-shrink-0" 
                             style="background-color: {{ $field->color }}"></div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-sm text-gray-900 truncate">{{ $field->name }}</p>
                            <p class="text-xs text-gray-500">{{ $field->field_type_name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
