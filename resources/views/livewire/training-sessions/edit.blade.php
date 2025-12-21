<div x-data="{ 
    showExerciseDetails: false,
    selectedExercise: null
}">
    <div class="sticky top-16 z-10 bg-white-pure flex items-center justify-between p-6 border-b border-gray-100 rounded-t-2xl shadow-xl border border-primary/10 mb-6">
        <div>
            <h2 class="font-bold text-2xl text-titanium leading-tight">Editar Sesión de Entrenamiento</h2>
            <p class="text-sm text-gray-600 mt-1">Modifica tu sesión agregando o quitando ejercicios</p>
        </div>
        <a href="{{ route('training-sessions.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-gray-700 font-semibold text-sm border-2 border-gray-300 hover:border-gray-400 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver
        </a>
    </div>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Session Info -->
            <div class="lg:col-span-1">
                <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 sticky top-32">
                    <h3 class="text-lg font-bold text-titanium mb-4">Información de la Sesión</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Equipo *</label>
                            <select wire:model="team_id" class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                                <option value="">Selecciona un equipo</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team }}</option>
                                @endforeach
                            </select>
                            @error('team_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Título *</label>
                            <input type="text" wire:model="title" placeholder="Ej: Sesión técnica de pases"
                                class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                            @error('title') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                            <textarea wire:model="description" rows="3" placeholder="Descripción breve de la sesión..."
                                class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Fecha *</label>
                                <input type="date" wire:model="session_date"
                                    class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                                @error('session_date') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Hora</label>
                                <input type="time" wire:model="start_time"
                                    class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Duración (min)</label>
                                <input type="number" wire:model="duration_minutes" placeholder="90"
                                    class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Día</label>
                                <select wire:model="day_of_week" class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                                    <option value="">Seleccionar</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sábado">Sábado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Notas</label>
                            <textarea wire:model="notes" rows="2" placeholder="Notas adicionales..."
                                class="w-full px-4 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm"></textarea>
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_completed" 
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                                <span class="ml-2 text-sm font-semibold text-titanium">
                                    Marcar como completada
                                </span>
                            </label>
                        </div>

                        <button type="submit" class="w-full mt-6 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Actualizar Sesión
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Exercises -->
            <div class="lg:col-span-2">
                <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6">
                    <!-- Summary Section -->
                    @if(count($exercises) > 0)
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border-2 border-blue-200">
                            <h4 class="font-bold text-blue-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Resumen de la sesión
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <div class="text-xs text-gray-600 mb-1">Total ejercicios</div>
                                    <div class="text-2xl font-bold text-blue-600">{{ count($exercises) }}</div>
                                </div>
                                <div class="bg-white rounded-lg p-3 shadow-sm">
                                    <div class="text-xs text-gray-600 mb-1">Duración total</div>
                                    <div class="text-2xl font-bold text-purple-600">{{ $this->totalDuration }} <span class="text-sm">min</span></div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-titanium">Ejercicios de la Sesión</h3>
                        <div class="flex gap-2">
                            <button type="button" wire:click="toggleExerciseSearch" 
                                    class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none transition-all duration-300 {{ $showExerciseSearch ? 'bg-gray-500 hover:bg-gray-600' : 'bg-blue-600 hover:bg-blue-700' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                {{ $showExerciseSearch ? 'Cerrar' : 'Buscar Ejercicio' }}
                            </button>
                            
                            <button type="button" wire:click="toggleCustomForm" 
                                    class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none transition-all duration-300 {{ $showCustomForm ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-600 hover:bg-green-700' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ $showCustomForm ? 'Cancelar' : 'Ejercicio Libre' }}
                            </button>
                        </div>
                    </div>

                    <!-- Exercise Search -->
                    @if($showExerciseSearch)
                        <div class="mb-6 p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
                            <h4 class="font-bold text-blue-900 mb-4">Buscar en tu biblioteca de ejercicios</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                                <input type="text" wire:model.live.debounce.300ms="exerciseSearch" 
                                       placeholder="Buscar por nombre..."
                                       class="px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                
                                <select wire:model.live="selectedExerciseType" class="px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                    <option value="">Tipo de ejercicio</option>
                                    @foreach($exerciseTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <select wire:model.live="selectedCategory" class="px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                    <option value="">Categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>

                                <select wire:model.live="selectedDifficulty" class="px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                    <option value="">Dificultad</option>
                                    <option value="Baja">Baja</option>
                                    <option value="Media">Media</option>
                                    <option value="Alta">Alta</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="favoritesOnly" 
                                           class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                                    <span class="ml-2 text-sm font-semibold text-blue-900">
                                        <svg class="w-4 h-4 inline text-red-500 mr-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Solo mis ejercicios favoritos
                                    </span>
                                </label>
                            </div>

                            <div class="max-h-96 overflow-y-auto">
                                @if($searchExercises->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($searchExercises as $exercise)
                                            <div class="bg-white rounded-xl border-2 border-blue-200 hover:border-blue-400 hover:shadow-lg transition-all cursor-pointer overflow-hidden group"
                                                 wire:click="showPreview({{ $exercise->id }})">
                                                @if($exercise->images->isNotEmpty())
                                                    <div class="relative h-64 overflow-hidden bg-white border-b border-gray-200">
                                                        <img src="{{ Storage::url($exercise->images->first()->file_path) }}" 
                                                             alt="{{ $exercise->title }}"
                                                             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                                                        <div class="absolute top-2 left-2">
                                                            <span class="p-2 bg-blue-600/90 text-white text-xs rounded-lg shadow-lg font-semibold">
                                                                Click para ver
                                                            </span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="relative h-64 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                        <svg class="w-20 h-20 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                        </svg>
                                                        <div class="absolute top-2 left-2">
                                                            <span class="p-2 bg-blue-600/90 text-white text-xs rounded-lg shadow-lg font-semibold">
                                                                Click para ver
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="p-4">
                                                    <h5 class="font-bold text-base text-titanium mb-2 line-clamp-2">{{ $exercise->title }}</h5>
                                                    <div class="flex items-center gap-2 flex-wrap text-xs">
                                                        @if($exercise->exerciseType)
                                                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full font-semibold">{{ $exercise->exerciseType->name }}</span>
                                                        @endif
                                                        @if($exercise->category)
                                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold">{{ $exercise->category->category }}</span>
                                                        @endif
                                                        @if($exercise->difficulty)
                                                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full font-semibold">{{ $exercise->difficulty }}</span>
                                                        @endif
                                                    </div>
                                                    @if($exercise->recommended_time)
                                                        <div class="flex items-center gap-1 mt-3 text-sm text-gray-600">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            <span class="font-semibold">{{ $exercise->recommended_time }} min</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600 text-center py-4">
                                        @if(strlen($exerciseSearch) >= 2 || $selectedExerciseType || $selectedCategory || $selectedDifficulty || $favoritesOnly)
                                            No se encontraron ejercicios con los criterios seleccionados
                                        @else
                                            Escribe al menos 2 caracteres o selecciona algún filtro para buscar
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Custom Exercise Form -->
                    @if($showCustomForm)
                        <div class="mb-6 p-4 bg-green-50 rounded-xl border-2 border-green-200">
                            <h4 class="font-bold text-green-900 mb-4">Crear ejercicio libre</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-semibold text-green-900 mb-1">Título *</label>
                                    <input type="text" wire:model="customTitle" placeholder="Nombre del ejercicio"
                                        class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                    @error('customTitle') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-green-900 mb-1">Descripción</label>
                                    <textarea wire:model="customDescription" rows="2" placeholder="Descripción del ejercicio..."
                                        class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-green-900 mb-1">Imagen del ejercicio</label>
                                    <input type="file" wire:model="customImage" accept="image/*"
                                        class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                    @error('customImage') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                    @if ($customImage)
                                        <div class="mt-2">
                                            <img src="{{ $customImage->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg border border-green-300">
                                        </div>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-semibold text-green-900 mb-1">Intensidad</label>
                                        <select wire:model="customIntensity" class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                            <option value="">Seleccionar...</option>
                                            <option value="Baja">Baja</option>
                                            <option value="Media">Media</option>
                                            <option value="Alta">Alta</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-green-900 mb-1">Dificultad</label>
                                        <select wire:model="customDifficulty" class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                            <option value="">Seleccionar...</option>
                                            <option value="Baja">Baja</option>
                                            <option value="Media">Media</option>
                                            <option value="Alta">Alta</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-semibold text-green-900 mb-1">Duración (min)</label>
                                        <input type="number" wire:model="customDuration" placeholder="15"
                                            class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-green-900 mb-1">N° Jugadores</label>
                                        <input type="number" wire:model="customPlayers" placeholder="10"
                                            class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-green-900 mb-1">Notas</label>
                                    <textarea wire:model="customNotes" rows="2" placeholder="Notas adicionales..."
                                        class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-sm"></textarea>
                                </div>

                                <button type="button" wire:click="addCustomExercise" 
                                        class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-all">
                                    Agregar Ejercicio Libre
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Exercise List -->
                    <script>
                        if (typeof Alpine !== 'undefined') {
                            document.addEventListener('alpine:init', () => {
                                if (!window.sortableExercisesRegistered) {
                                    Alpine.data('sortableExercises', () => ({
                                        sortable: null,
                                        initSort() {
                                            const el = document.getElementById('exercises-list');
                                            if (!el) return;
                                            if (typeof Sortable === 'undefined') {
                                                console.error('Sortable.js is not loaded');
                                                return;
                                            }
                                            this.sortable = new Sortable(el, {
                                                animation: 200,
                                                handle: '.drag-handle',
                                                ghostClass: 'bg-blue-100',
                                                chosenClass: 'border-blue-500',
                                                dragClass: 'opacity-50',
                                                forceFallback: false,
                                                onEnd: (evt) => {
                                                    const items = el.querySelectorAll('.exercise-item');
                                                    const orderedIds = Array.from(items).map(item => item.dataset.exerciseId);
                                                    this.$wire.call('updateExerciseOrder', orderedIds);
                                                }
                                            });
                                        }
                                    }));
                                    window.sortableExercisesRegistered = true;
                                }
                            });
                        }
                    </script>
                    <div class="space-y-3" x-data="sortableExercises()" x-init="initSort()" wire:ignore.self>
                        <div id="exercises-list" class="space-y-3">
                        @if(count($exercises) > 0)
                            @foreach($exercises as $index => $exercise)
                                <div class="exercise-item bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-all" 
                                     data-exercise-id="{{ $exercise['id'] }}"
                                     wire:key="exercise-{{ $exercise['id'] }}">
                                    <div class="flex items-start gap-3">
                                        <div class="flex flex-col gap-1 items-center">
                                            <div class="drag-handle hidden sm:flex items-center justify-center w-8 h-8 bg-blue-600 text-white font-bold rounded-lg text-sm cursor-grab hover:bg-blue-700 active:cursor-grabbing" title="Arrastra para reordenar">
                                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-bold text-gray-500">{{ $index + 1 }}</span>
                                            
                                            <button type="button" wire:click="moveUp({{ $index }})" 
                                                    class="flex items-center justify-center w-9 h-9 bg-blue-600 sm:bg-transparent text-white sm:text-gray-500 hover:text-blue-600 rounded-lg sm:rounded-none sm:w-auto sm:h-auto sm:p-1 {{ $index === 0 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                                    {{ $index === 0 ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                                </svg>
                                            </button>
                                            
                                            <button type="button" wire:click="moveDown({{ $index }})" 
                                                    class="flex items-center justify-center w-9 h-9 bg-blue-600 sm:bg-transparent text-white sm:text-gray-500 hover:text-blue-600 rounded-lg sm:rounded-none sm:w-auto sm:h-auto sm:p-1 {{ $index === count($exercises) - 1 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                                    {{ $index === count($exercises) - 1 ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="flex-1 flex gap-4">
                                            <!-- Exercise Image -->
                                            @if($exercise['is_custom'] && isset($exercise['custom_image']))
                                                <div class="flex-shrink-0">
                                                    <img src="{{ Storage::url($exercise['custom_image']) }}" 
                                                         alt="{{ $exercise['title'] }}"
                                                         class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                                                </div>
                                            @elseif(!$exercise['is_custom'] && isset($exercise['image_url']))
                                                <div class="flex-shrink-0">
                                                    <img src="{{ Storage::url($exercise['image_url']) }}" 
                                                         alt="{{ $exercise['title'] }}"
                                                         class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200">
                                                </div>
                                            @else
                                                <div class="flex-shrink-0 w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg border-2 border-gray-200 flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                    </svg>
                                                </div>
                                            @endif

                                            <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                                        <h4 class="font-bold text-titanium">
                                                            {{ $exercise['title'] }}
                                                        </h4>
                                                        @if($exercise['is_custom'])
                                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded">Libre</span>
                                                        @endif
                                                        @if(isset($exercise['exercise_type']) && $exercise['exercise_type'])
                                                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs">{{ $exercise['exercise_type'] }}</span>
                                                        @endif
                                                        @if(isset($exercise['category']) && $exercise['category'])
                                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $exercise['category'] }}</span>
                                                        @endif
                                                        @if(isset($exercise['difficulty']) && $exercise['difficulty'])
                                                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs">{{ $exercise['difficulty'] }}</span>
                                                        @endif
                                                    </div>
                                                    
                                                    @if($exercise['description'])
                                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $exercise['description'] }}</p>
                                                    @endif

                                                    <div class="grid grid-cols-2 gap-2 mt-3">
                                                        <div>
                                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Duración (min)</label>
                                                            <input type="number" 
                                                                   wire:change="updateExerciseDuration({{ $index }}, $event.target.value)"
                                                                   value="{{ $exercise['duration_minutes'] }}"
                                                                   class="w-16 px-2 py-1 border border-gray-300 rounded text-sm text-center">
                                                        </div>

                                                        <div>
                                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Notas</label>
                                                            <input type="text" 
                                                                   wire:change="updateExerciseNotes({{ $index }}, $event.target.value)"
                                                                   value="{{ $exercise['notes'] ?? '' }}"
                                                                   placeholder="Notas..."
                                                                   class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" wire:click="removeExercise({{ $index }})" 
                                                        class="ml-3 p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay ejercicios agregados</h3>
                                <p class="mt-1 text-sm text-gray-500">Busca ejercicios en tu biblioteca o crea ejercicios libres</p>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Exercise Preview Modal -->
    @if($previewExercise)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" 
             wire:click="closePreview"
             style="overflow-y: auto;">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full" style="max-height: 90vh; display: flex; flex-direction: column;"
                 @click.stop>
                    
                    <!-- Modal Header -->
                    <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl flex-shrink-0">
                    <h3 class="text-xl font-bold text-titanium">Vista previa del ejercicio</h3>
                    <button type="button" 
                            wire:click="closePreview"
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6" style="overflow-y: auto; flex: 1;">
                    <!-- Exercise Image -->
                    @if($previewExercise->images->isNotEmpty())
                        <div class="mb-6 rounded-xl overflow-hidden bg-white border-2 border-gray-200">
                            <img src="{{ Storage::url($previewExercise->images->first()->file_path) }}" 
                                 alt="{{ $previewExercise->title }}"
                                 class="w-full max-h-96 object-contain">
                        </div>
                    @else
                        <div class="mb-6 h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Exercise Details -->
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <h4 class="text-2xl font-bold text-titanium mb-2">{{ $previewExercise->title }}</h4>
                        </div>

                        <!-- Badges -->
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($previewExercise->exerciseType)
                                <span class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold">
                                    {{ $previewExercise->exerciseType->name }}
                                </span>
                            @endif
                            @if($previewExercise->category)
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                    {{ $previewExercise->category->category }}
                                </span>
                            @endif
                            @if($previewExercise->difficulty)
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">
                                    Dificultad: {{ $previewExercise->difficulty }}
                                </span>
                            @endif
                            @if($previewExercise->intensity)
                                <span class="px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                    Intensidad: {{ $previewExercise->intensity }}
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        @if($previewExercise->description)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h5 class="font-semibold text-titanium mb-2">Descripción</h5>
                                <p class="text-gray-700 whitespace-pre-line">{{ $previewExercise->description }}</p>
                            </div>
                        @endif

                        <!-- Time and Players -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($previewExercise->recommended_time)
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="flex items-center gap-2 text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-semibold">Tiempo recomendado</span>
                                    </div>
                                    <p class="text-2xl font-bold text-blue-900 mt-2">{{ $previewExercise->recommended_time }} min</p>
                                </div>
                            @endif

                            @if($previewExercise->recommended_players)
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="flex items-center gap-2 text-green-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <span class="font-semibold">Jugadores recomendados</span>
                                    </div>
                                    <p class="text-2xl font-bold text-green-900 mt-2">{{ $previewExercise->recommended_players }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Objectives -->
                        @if($previewExercise->objectives)
                            <div class="bg-yellow-50 rounded-lg p-4">
                                <h5 class="font-semibold text-yellow-900 mb-2">Objetivos</h5>
                                <p class="text-yellow-900 whitespace-pre-line">{{ $previewExercise->objectives }}</p>
                            </div>
                        @endif

                        <!-- Notes -->
                        @if($previewExercise->notes)
                            <div class="bg-purple-50 rounded-lg p-4">
                                <h5 class="font-semibold text-purple-900 mb-2">Notas adicionales</h5>
                                <p class="text-purple-900 whitespace-pre-line">{{ $previewExercise->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex-shrink-0 bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-end gap-3 rounded-b-2xl">
                    <button type="button"
                            wire:click="closePreview"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Cerrar
                    </button>
                    <button type="button"
                            wire:click="addExercise({{ $previewExercise->id }})"
                            class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Añadir ejercicio
                    </button>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sortableExercises', () => ({
                sortable: null,
                initSort() {
                    const el = document.getElementById('exercises-list');
                    if (!el) return;

                    this.sortable = new Sortable(el, {
                        animation: 200,
                        handle: '.drag-handle',
                        ghostClass: 'bg-blue-100',
                        chosenClass: 'border-blue-500',
                        dragClass: 'opacity-50',
                        forceFallback: false,
                        onEnd: (evt) => {
                            const items = el.querySelectorAll('.exercise-item');
                            const orderedIds = Array.from(items).map(item => item.dataset.exerciseId);
                            this.$wire.call('updateExerciseOrder', orderedIds);
                        }
                    });
                }
            }));
        });
    </script>
    @endpush
</div>
