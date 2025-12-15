<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg animate-slideUp">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-neon-green mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <div class="sticky top-16 z-10 bg-white-pure flex items-center justify-between p-6 border-b border-gray-100 rounded-t-2xl shadow-xl border border-primary/10 mb-6">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            {{ __('Sesiones de Entrenamiento') }}
        </h2>
        <a href="{{ route('training-sessions.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Sesión
        </a>
    </div>

    <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <!-- Filters -->
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-primary/5 to-night-blue/5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Buscar</label>
                    <input type="text" wire:model.live="search" placeholder="Buscar sesiones..." 
                        class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Equipo</label>
                    <select wire:model.live="selectedTeam" class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                        <option value="">Todos los equipos</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->team }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Sessions List -->
        <div class="p-6">
            @if($sessions->count() > 0)
                <div class="space-y-4">
                    @foreach($sessions as $session)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-200 bg-white">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-bold text-titanium">{{ $session->title }}</h3>
                                        @if($session->is_completed)
                                            <span class="px-3 py-1 bg-neon-green/10 text-neon-green text-xs font-semibold rounded-full">
                                                Completada
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $session->team->team }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $session->session_date->format('d/m/Y') }}</span>
                                        </div>
                                        @if($session->start_time)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>{{ $session->start_time->format('H:i') }}</span>
                                            </div>
                                        @endif
                                        @if($session->duration_minutes)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                                <span>{{ $session->duration_minutes }} min</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4 text-sm">
                                        <div class="flex items-center gap-1 text-blue-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <span class="font-semibold">{{ $session->exercises_count }} ejercicios</span>
                                        </div>
                                        @if($session->total_exercises_duration)
                                            <div class="flex items-center gap-1 text-gray-600">
                                                <span>Duración total: <span class="font-semibold">{{ $session->total_exercises_duration }} min</span></span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($session->description)
                                        <p class="text-sm text-gray-600 mt-3 line-clamp-2">{{ $session->description }}</p>
                                    @endif

                                    <!-- Exercise Images Preview -->
                                    @if($session->sessionExercises->isNotEmpty())
                                        <div class="mt-4">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                @php
                                                    $displayedImages = 0;
                                                    $maxImages = 4;
                                                @endphp
                                                @foreach($session->sessionExercises as $sessionExercise)
                                                    @if($displayedImages >= $maxImages)
                                                        @break
                                                    @endif
                                                    @if($sessionExercise->exercise && $sessionExercise->exercise->images->isNotEmpty())
                                                        @foreach($sessionExercise->exercise->images as $image)
                                                            @if($displayedImages >= $maxImages)
                                                                @break
                                                            @endif
                                                            <div class="relative w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                                                                <img src="{{ Storage::url($image->file_path) }}" 
                                                                     alt="{{ $sessionExercise->exercise->title }}"
                                                                     class="w-full h-full object-cover"
                                                                     title="{{ $sessionExercise->exercise->title }}">
                                                            </div>
                                                            @php $displayedImages++; @endphp
                                                            @break
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                @if($session->exercises_count > $maxImages)
                                                    <div class="w-20 h-20 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50">
                                                        <span class="text-sm font-semibold text-gray-500">+{{ $session->exercises_count - $maxImages }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 ml-4">
                                    <a href="{{ route('training-sessions.edit', $session->id) }}" 
                                       class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                       title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <button wire:click="duplicate({{ $session->id }})" 
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors"
                                            title="Duplicar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="delete({{ $session->id }})" 
                                            wire:confirm="¿Estás seguro de que deseas eliminar esta sesión?"
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $sessions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay sesiones de entrenamiento</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva sesión de entrenamiento.</p>
                    <div class="mt-6">
                        <a href="{{ route('training-sessions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Sesión
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
