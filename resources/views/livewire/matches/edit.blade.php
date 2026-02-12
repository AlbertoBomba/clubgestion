<div x-data="{ hasUnsavedChanges: false, showWarning: false }" 
     x-init="
        // Mostrar alerta temporal cuando hay cambios
        $watch('hasUnsavedChanges', value => {
            if (value) {
                showWarning = true;
                setTimeout(() => showWarning = false, 5000);
            }
        });
        
        // Marcar como guardado cuando se actualiza exitosamente
        window.addEventListener('changes-saved', () => {
            hasUnsavedChanges = false;
        });
     "
     @input.window="hasUnsavedChanges = true"
     @change.window="hasUnsavedChanges = true">

    <!-- Trix Editor CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    
    <style>
        /* Personalizar el editor Trix */
        trix-editor {
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            padding: 0.75rem;
            min-height: 150px;
            font-size: 0.875rem;
        }
        trix-editor:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        trix-toolbar {
            border-radius: 0.75rem 0.75rem 0 0;
        }
    </style>
     
    <!-- Alerta emergente temporal (se auto-oculta) -->
    <div x-show="showWarning" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-20 right-4 z-50 max-w-md"
         style="display: none;">
        <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg shadow-2xl p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-bold text-amber-800">⚠️ Cambios detectados</h3>
                    <p class="mt-1 text-sm text-amber-700">No olvides guardar los cambios.</p>
                </div>
                <button @click="showWarning = false" class="ml-auto flex-shrink-0 text-amber-600 hover:text-amber-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @if (session()->has('message') && !session()->has('share_link'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- Mensaje fijo persistente arriba del formulario -->
    <div x-show="hasUnsavedChanges" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-lg"
         style="display: none;">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-amber-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <p class="text-sm text-amber-800 font-semibold">Hay cambios sin guardar</p>
                <p class="text-xs text-amber-700 mt-1">Recuerda hacer clic en el botón <strong>Actualizar</strong> para guardar los cambios realizados.</p>
            </div>
        </div>
    </div>

    <div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-2 overflow-hidden">
                <a href="" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                    {{ __('Partidos') }}
                </a>
                <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
                <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                    Editar Partido
                </h2>
            </div>
            
            <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
                {{-- <button wire:click="viewPublicConvocatoria" type="button" class="inline-flex items-center px-3 py-2 sm:px-4 bg-indigo-600 text-white rounded-xl font-semibold text-xs sm:text-sm hover:bg-indigo-700 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="hidden sm:inline">Ver Convocatoria</span>
                </button> --}}
                <button wire:click="generateShareLink" type="button" class="inline-flex items-center px-3 py-2 sm:px-4 bg-purple-600 text-white rounded-xl font-semibold text-xs sm:text-sm hover:bg-purple-700 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    <span class="hidden sm:inline">Compartir convocatoria</span>
                </button>
                <button wire:click="printPDF" type="button" class="inline-flex items-center px-3 py-2 sm:px-4 bg-green-600 text-white rounded-xl font-semibold text-xs sm:text-sm hover:bg-green-700 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Imprimir convocatoria</span>
                </button>
                <a href="{{ route('matches.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="hidden sm:inline">Salir</span>
                </a>
                <button type="submit" form="match-form" wire:loading.attr="disabled" wire:target="update" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
                    <svg wire:loading.remove wire:target="update" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg wire:loading wire:target="update" class="animate-spin h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="update">Actualizar</span>
                    <span wire:loading wire:target="update">Actualizando...</span>
                </button>
            </div>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        @if (session()->has('share_link'))
            <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded" x-data="{ copied: false }">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold text-purple-800 mb-2">{{ session('message') }}</p>
                        <div class="flex items-center space-x-2">
                            <input type="text" 
                                   value="{{ session('share_link') }}" 
                                   readonly 
                                   class="flex-1 px-3 py-2 bg-white border border-purple-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   id="share-link-input">
                            <button @click="navigator.clipboard.writeText('{{ session('share_link') }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-semibold transition-colors">
                                <svg x-show="!copied" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <svg x-show="copied" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span x-text="copied ? 'Copiado!' : 'Copiar'">Copiar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit="update" id="match-form">
            <div class="space-y-8">
                <!-- Datos del Partido -->
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Datos del Partido
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-4">
                        <div class="form-group md:col-span-2 lg:col-span-2">
                            <label class="block text-sm font-semibold text-titanium mb-2">Equipo *</label>
                            <select wire:model.live="team_id" 
                                class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                <option value="">Selecciona equipo</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team }} @if($team->category) - {{ $team->category->name }}@endif</option>
                                @endforeach
                            </select>
                            @error('team_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group max-w-[100px]">
                            <label class="block text-sm font-semibold text-titanium mb-2">Jornada</label>
                            <input wire:model="matchday" type="number" min="1"
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                placeholder="Ej: 1">
                            @error('matchday') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group md:col-span-1 lg:col-span-2">
                            <label class="block text-sm font-semibold text-titanium mb-2">Rival *</label>
                            <input wire:model="opponent" type="text" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                placeholder="Nombre del equipo rival">
                            @error('opponent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group sm:col-span-2 md:col-span-3 lg:col-span-2">
                            <label class="block text-sm font-semibold text-titanium mb-2">Escudo del Rival</label>
                            <div class="flex items-start gap-2">
                                <div class="flex-1">
                                    <input wire:model="newEscudoTeamOponent" type="file" accept="image/*"
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('newEscudoTeamOponent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                @if($escudo_team_oponent)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $escudo_team_oponent) }}" alt="Escudo" class="w-10 h-10 object-contain border border-gray-200 rounded p-1">
                                    </div>
                                @endif
                                @if($newEscudoTeamOponent)
                                    <div class="flex-shrink-0">
                                        <img src="{{ $newEscudoTeamOponent->temporaryUrl() }}" alt="Nuevo" class="w-10 h-10 object-contain border border-green-500 rounded p-1">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Fecha *</label>
                            <input wire:model="date" type="date" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Hora Partido</label>
                            <input wire:model="hour_match" type="time" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('hour_match') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Hora Citación</label>
                            <input wire:model="hour_meeting" type="time" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('hour_meeting') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group sm:col-span-2 md:col-span-2 lg:col-span-2">
                            <label class="block text-sm font-semibold text-titanium mb-2">Lugar</label>
                            <input wire:model="site" type="text" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                placeholder="Ej: Estadio Municipal">
                            @error('site') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Resultado del Partido, Observaciones y Nota Interna en la misma fila -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Resultado del Partido -->
                        <div class="bg-gray-50/50 rounded-xl p-4 border border-gray-200">
                            <h4 class="text-md font-semibold text-titanium mb-3 pb-2 border-b border-gray-300">Resultado del Partido</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div class="form-group">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Goles Propios</label>
                                    <input wire:model="goals_team" type="number" min="0"
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                        placeholder="0">
                                    @error('goals_team') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Goles Rival</label>
                                    <input wire:model="goals_oponent" type="number" min="0"
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                        placeholder="0">
                                    @error('goals_oponent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Local / Visitante</label>
                                    <select wire:model="sites"
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                        <option value="">Selecciona</option>
                                        <option value="home">Local (Casa)</option>
                                        <option value="away">Visitante (Fuera)</option>
                                    </select>
                                    @error('sites') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="bg-gray-50/50 rounded-xl p-4 border border-gray-200">
                            <h4 class="text-md font-semibold text-titanium mb-3 pb-2 border-b border-gray-300">Observaciones</h4>
                            <div class="form-group">
                                <textarea wire:model="observations" rows="11"
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"
                                    placeholder="Observaciones generales del partido"></textarea>
                                @error('observations') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Nota interno entrenador -->
                        <div class="bg-gray-50/50 rounded-xl p-4 border border-gray-200">
                            <h4 class="text-md font-semibold text-titanium mb-3 pb-2 border-b border-gray-300">Nota Interno Entrenador</h4>
                            <div class="form-group">
                                <textarea wire:model="match_description" rows="11"
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"
                                    placeholder="Descripción detallada del desarrollo del partido, estadísticas, jugadas destacadas, etc."></textarea>
                                @error('match_description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Publicación en Web Pública -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-titanium mb-4 pb-3 border-b border-blue-300 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            Publicación en Web Pública
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Publicación y Descripción Web -->
                            <div class="bg-blue-50/30 rounded-xl p-6 border border-blue-200">
                                <div class="space-y-4">
                                    <div class="form-group">
                                        <label class="flex items-center space-x-3 cursor-pointer group">
                                            <input wire:model="published" type="checkbox" 
                                                class="w-6 h-6 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                                            <span class="text-base font-bold text-titanium group-hover:text-primary transition-colors">Publicar en Web</span>
                                        </label>
                                        <p class="text-xs text-gray-600 mt-2 ml-9">Marcar para que el partido sea visible en la web pública</p>
                                        @error('published') <span class="text-red-500 text-xs mt-1 ml-9">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="block text-sm font-semibold text-titanium mb-2">Descripción Web Pública</label>
                                        <div wire:ignore>
                                            <input id="trix-web-description-{{ $match->id }}" 
                                                   type="hidden" 
                                                   value="{{ $web_description }}">
                                            <trix-editor 
                                                input="trix-web-description-{{ $match->id }}" 
                                                placeholder="Descripción del partido para mostrar en la web pública. Puedes dar formato al texto usando la barra de herramientas."
                                                class="text-black-deep"
                                                x-data
                                                x-init="
                                                    let trixEditor = $el;
                                                    let hiddenInput = document.getElementById('trix-web-description-{{ $match->id }}');
                                                    
                                                    trixEditor.addEventListener('trix-change', function(e) {
                                                        @this.set('web_description', hiddenInput.value);
                                                    });
                                                "></trix-editor>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Usa la barra de herramientas para dar formato: negrita, cursiva, listas, enlaces, etc.</p>
                                        @error('web_description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Galería de Imágenes -->
                            <div class="bg-purple-50/30 rounded-xl p-6 border border-purple-200">
                                <h4 class="text-sm font-bold text-titanium mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Galería de Imágenes
                                </h4>
                                
                                <!-- Upload Section -->
                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-titanium mb-2">Subir Imágenes</label>
                                    <input wire:model="newMatchImages" type="file" accept="image/*" multiple
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-black-deep text-xs bg-white">
                                    <p class="text-xs text-gray-500 mt-1">Máximo 5MB por imagen</p>
                                    @error('newMatchImages.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    
                                    @if($newMatchImages)
                                        <div class="mt-3 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-xs text-green-800 font-bold">{{ count($newMatchImages) }} imagen(es) lista(s)</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Gallery Grid Compact -->
                                @if($matchImages && count($matchImages) > 0)
                                    <div>
                                        <label class="block text-xs font-semibold text-titanium mb-2">Guardadas ({{ count($matchImages) }})</label>
                                        <div class="grid grid-cols-3 gap-2 max-h-60 overflow-y-auto">
                                            @foreach($matchImages as $index => $image)
                                                <div wire:key="match-image-{{ $index }}" class="group relative bg-white rounded-lg overflow-hidden border-2 border-gray-200 hover:border-purple-500 transition-colors">
                                                    <div class="aspect-square">
                                                        <img src="{{ asset('storage/' . $image) }}" 
                                                             alt="Imagen {{ $index + 1 }}" 
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-center justify-center">
                                                        <button type="button" 
                                                            wire:click="deleteMatchImage({{ $index }})" 
                                                            wire:confirm="¿Eliminar esta imagen?"
                                                            class="opacity-0 group-hover:opacity-100 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 transition-all"
                                                            title="Eliminar">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8 bg-white rounded-lg border-2 border-dashed border-gray-300">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-500 text-xs font-semibold">Sin imágenes</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Convocatoria - Dos Columnas -->
                @if($team_id)
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center justify-between border-b border-silver/30 pb-3 mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Convocatoria
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-normal text-gray-500">
                                Convocados: {{ count($calledPlayers) }} / {{ $maxPlayers }}
                            </span>
                            <button type="button" wire:click="openAddExternalPlayerModal" 
                                class="inline-flex items-center px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-semibold transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Añadir de otro equipo
                            </button>
                        </div>
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Columna Izquierda: Jugadores No Convocados (con motivo) -->
                        <div class="bg-red-50 rounded-xl p-4 border-2 border-red-200">
                            <h4 class="font-semibold text-titanium mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                No Convocados ({{ count($notCalledPlayerReasons) }})
                            </h4>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                @forelse($notCalledPlayersData as $player)
                                    <div wire:key="not-conv-{{ $player->id }}" class="bg-white rounded-lg p-3 border border-red-200">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center flex-1 min-w-0">
                                                @if($player->player_photo)
                                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-red-600/10 flex items-center justify-center mr-3">
                                                        <span class="text-red-600 font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-titanium truncate">{{ $player->surname }}, {{ $player->name }}</p>
                                                    @if($player->position)
                                                        <p class="text-xs text-gray-500">{{ $player->position }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removeFromNotCalled({{ $player->id }})" 
                                                class="ml-2 p-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors flex-shrink-0"
                                                title="Devolver a disponibles">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="mt-2">
                                            <textarea wire:model.defer="notCalledPlayerReasons.{{ $player->id }}" 
                                                rows="2"
                                                class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-red-500"
                                                placeholder="Motivo de la baja..."></textarea>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">No hay jugadores no convocados</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Columna Central: Jugadores Disponibles -->
                        <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                            <h4 class="font-semibold text-titanium mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Jugadores Disponibles ({{ count($notCalledPlayers) }})
                            </h4>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                @forelse($availablePlayersData as $player)
                                    <div wire:key="available-{{ $player->id }}" class="bg-white rounded-lg p-3 border border-blue-200 hover:border-primary transition-colors">
                                        <div class="flex items-center justify-between gap-2">
                                            <button type="button" 
                                                wire:click="markAsNotCalled({{ $player->id }})" 
                                                class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex-shrink-0"
                                                title="Marcar como no convocado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                            
                                            <div class="flex items-center flex-1 min-w-0">
                                                @if($player->player_photo)
                                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-blue-600/10 flex items-center justify-center mr-3">
                                                        <span class="text-blue-600 font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-titanium truncate">{{ $player->surname }}, {{ $player->name }}</p>
                                                    @if($player->position)
                                                        <p class="text-xs text-gray-500">{{ $player->position }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <button type="button" 
                                                wire:click="addPlayer({{ $player->id }})" 
                                                class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors flex-shrink-0"
                                                title="Convocar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">Todos los jugadores están asignados</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Columna Derecha: Jugadores Convocados -->
                        <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200">
                            <h4 class="font-semibold text-titanium mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Jugadores Convocados ({{ count($calledPlayers) }})
                            </h4>
                            <p class="text-xs text-gray-600 mb-3 flex items-center gap-2">
                                <span class="inline-block w-3 h-4 bg-yellow-400 rounded-sm"></span>
                                <span class="inline-block w-3 h-4 bg-red-600 rounded-sm"></span>
                                Haz clic en las tarjetas para registrar amonestaciones
                            </p>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                @forelse($calledPlayersData as $player)
                                    <div wire:key="called-{{ $player->id }}" class="bg-white rounded-lg p-3 border border-green-200 hover:border-primary transition-colors">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex items-center flex-1 min-w-0">
                                                @if($player->player_photo)
                                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-10 h-10 rounded-full object-cover mr-3 flex-shrink-0">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-green-600/10 flex items-center justify-center mr-3 flex-shrink-0">
                                                        <span class="text-green-600 font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-titanium truncate">{{ $player->surname }}, {{ $player->name }}</p>
                                                    @if($player->position)
                                                        <p class="text-xs text-gray-500">{{ $player->position }}</p>
                                                    @endif
                                                    
                                                    <!-- Tarjetas visuales -->
                                                    <div class="flex items-center gap-1 mt-2">
                                                        <button type="button" 
                                                            wire:click="toggleCard({{ $player->id }}, 'card_yellow1')"
                                                            class="relative group"
                                                            title="Tarjeta Amarilla 1">
                                                            <div class="w-5 h-7 rounded-sm transition-all {{ $player->pivot->card_yellow1 ? 'bg-yellow-400 shadow-md' : 'bg-gray-200 opacity-40 hover:opacity-60' }}"></div>
                                                            @if($player->pivot->card_yellow1)
                                                                <svg class="absolute inset-0 w-full h-full text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </button>
                                                        
                                                        <button type="button" 
                                                            wire:click="toggleCard({{ $player->id }}, 'card_yellow2')"
                                                            class="relative group"
                                                            title="Tarjeta Amarilla 2">
                                                            <div class="w-5 h-7 rounded-sm transition-all {{ $player->pivot->card_yellow2 ? 'bg-yellow-400 shadow-md' : 'bg-gray-200 opacity-40 hover:opacity-60' }}"></div>
                                                            @if($player->pivot->card_yellow2)
                                                                <svg class="absolute inset-0 w-full h-full text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </button>
                                                        
                                                        <button type="button" 
                                                            wire:click="toggleCard({{ $player->id }}, 'card_red')"
                                                            class="relative group ml-1"
                                                            title="Tarjeta Roja">
                                                            <div class="w-5 h-7 rounded-sm transition-all {{ $player->pivot->card_red ? 'bg-red-600 shadow-md' : 'bg-gray-200 opacity-40 hover:opacity-60' }}"></div>
                                                            @if($player->pivot->card_red)
                                                                <svg class="absolute inset-0 w-full h-full text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @endif
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removePlayer({{ $player->id }})" 
                                                class="p-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors flex-shrink-0"
                                                title="Devolver a disponibles">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">No hay jugadores convocados</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <p class="text-yellow-700 text-sm">Selecciona un equipo para gestionar la convocatoria</p>
                    </div>
                @endif

                <!-- Alineación Táctica - 11 Titular -->
                @if($team_id && count($calledPlayers) >= 11)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-6">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Alineación Táctica - {{ $footballType }} Titular
                    </h3>

                    <!-- Selector de Tipo de Fútbol y Formación -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Tipo de Fútbol -->
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Tipo de Fútbol</label>
                            <select wire:model.live="footballType" 
                                class="block w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                <option value="7">Fútbol 7</option>
                                <option value="8">Fútbol 8</option>
                                <option value="11">Fútbol 11</option>
                            </select>
                        </div>
                        
                        <!-- Formación -->
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Selecciona la Formación</label>
                            <select wire:model.live="formation" 
                                class="block w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                <option value="">-- Selecciona un sistema --</option>
                                @if(isset($availableFormations[$footballType]))
                                    @foreach($availableFormations[$footballType] as $key => $formationData)
                                        <option value="{{ $key }}">{{ $formationData['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($formation)
                                <p class="text-xs text-gray-500 mt-2">Sistema seleccionado: <span class="font-semibold text-primary">{{ $formation }}</span></p>
                            @endif
                        </div>
                    </div>

                    @if($formation && isset($availableFormations[$footballType][$formation]))
                        <!-- Contenedor Campo + Banquillo -->
                        <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
                            <!-- Campo de Fútbol (80% en desktop) -->
                            <div class="w-full lg:w-4/5">
                                <div class="relative bg-gradient-to-b from-green-600 to-green-700 rounded-2xl p-3 sm:p-4 md:p-6 shadow-2xl overflow-visible" style="min-height: 500px;">
                            <!-- Líneas del campo -->
                            <div class="absolute inset-3 sm:inset-4 md:inset-6 border-2 sm:border-3 md:border-4 border-white/30 rounded-xl">
                                <!-- Línea central -->
                                <div class="absolute top-0 left-1/2 w-0.5 h-full bg-white/30 -translate-x-1/2"></div>
                                <!-- Círculo central -->
                                <div class="absolute top-1/2 left-1/2 w-12 h-12 sm:w-16 sm:h-16 md:w-24 md:h-24 border-2 sm:border-3 md:border-4 border-white/30 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                                <div class="absolute top-1/2 left-1/2 w-1 h-1 sm:w-1.5 sm:h-1.5 md:w-2 md:h-2 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                                
                                <!-- Áreas -->
                                <div class="absolute top-0 left-1/2 w-24 sm:w-32 md:w-48 h-10 sm:h-14 md:h-20 border-2 sm:border-3 md:border-4 border-white/30 border-t-0 -translate-x-1/2"></div>
                                <div class="absolute bottom-0 left-1/2 w-24 sm:w-32 md:w-48 h-10 sm:h-14 md:h-20 border-2 sm:border-3 md:border-4 border-white/30 border-b-0 -translate-x-1/2"></div>
                            </div>

                            <!-- Jugadores por líneas -->
                            <div class="relative h-full flex flex-col justify-between py-6 px-2 sm:py-8 sm:px-4 md:py-12 md:px-8" style="min-height: 450px;">
                                @php
                                    $lines = $availableFormations[$footballType][$formation]['lines'];
                                    $lineCount = count($lines);
                                @endphp

                                @foreach($lines as $lineIndex => $playersInLine)
                                    <div class="flex justify-center items-center gap-1 sm:gap-2 md:gap-4" style="flex: 1;">
                                        @for($positionIndex = 0; $positionIndex < $playersInLine; $positionIndex++)
                                            @php
                                                $playerId = $lineup[$lineIndex][$positionIndex] ?? null;
                                                $player = $playerId ? $calledPlayersData->firstWhere('id', $playerId) : null;
                                            @endphp
                                            
                                            <div class="relative group w-full max-w-[60px] sm:max-w-[90px] md:max-w-[110px] lg:max-w-[140px]">
                                                @if($player)
                                                    <!-- Jugador asignado -->
                                                    <div class="relative">
                                                        <div class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 mx-auto bg-white rounded-full shadow-2xl border-2 sm:border-3 md:border-4 border-blue-500 overflow-hidden transition-all group-hover:scale-110 cursor-pointer">
                                                            @if($player->player_photo)
                                                                <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center bg-blue-100">
                                                                    <span class="text-blue-600 font-bold text-xs sm:text-sm md:text-lg lg:text-2xl">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="mt-2 text-center">
                                                            <p class="text-white text-[10px] sm:text-xs md:text-sm font-bold drop-shadow-lg line-clamp-1">{{ $player->name }} {{ $player->surname }}</p>
                                                            @if($player->position)
                                                                <p class="text-white/80 text-[8px] sm:text-[10px] md:text-xs drop-shadow hidden sm:block">{{ $player->position }}</p>
                                                            @endif
                                                            
                                                            <!-- Tarjetas en alineación -->
                                                            @if($player->pivot->card_yellow1 || $player->pivot->card_yellow2 || $player->pivot->card_red)
                                                                <div class="flex justify-center gap-0.5 sm:gap-1 mt-1">
                                                                    @if($player->pivot->card_yellow1)
                                                                        <div class="w-2 h-2.5 sm:w-2.5 sm:h-3 md:w-3 md:h-4 bg-yellow-400 rounded-sm shadow-md border border-yellow-500"></div>
                                                                    @endif
                                                                    @if($player->pivot->card_yellow2)
                                                                        <div class="w-2 h-2.5 sm:w-2.5 sm:h-3 md:w-3 md:h-4 bg-yellow-400 rounded-sm shadow-md border border-yellow-500"></div>
                                                                    @endif
                                                                    @if($player->pivot->card_red)
                                                                        <div class="w-2 h-2.5 sm:w-2.5 sm:h-3 md:w-3 md:h-4 bg-red-600 rounded-sm shadow-md border border-red-700"></div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <!-- Botón eliminar -->
                                                        <button type="button" wire:click="removeFromLineup({{ $player->id }})"
                                                            class="absolute -top-1 -right-1 sm:top-0 sm:right-2 w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 bg-red-500 hover:bg-red-600 rounded-full text-white shadow-lg opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @else
                                                    <!-- Posición vacía con dropdown -->
                                                    <div x-data="{ open: false, search: '' }" class="relative static">
                                                        <button type="button" 
                                                            x-ref="button"
                                                            @click="open = !open" @click.away="open = false"
                                                            class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 mx-auto bg-white/20 border-2 sm:border-3 md:border-4 border-white/50 border-dashed rounded-full shadow-lg hover:bg-white/30 hover:border-white transition-all flex items-center justify-center cursor-pointer">
                                                            <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                        </button>
                                                        <p class="text-white/60 text-[10px] sm:text-xs md:text-sm text-center mt-1 sm:mt-2">Pos {{ $positionIndex + 1 }}</p>
                                                        
                                                        <!-- Dropdown de jugadores -->
                                                        <div x-show="open" 
                                                             x-transition:enter="transition ease-out duration-200"
                                                             x-transition:enter-start="opacity-0 scale-95"
                                                             x-transition:enter-end="opacity-100 scale-100"
                                                             x-anchor.bottom-start="$refs.button"
                                                             class="fixed z-[9999] w-56 sm:w-64 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden"
                                                             style="max-height: 320px;">
                                                            <div class="p-2">
                                                                <p class="text-xs font-semibold text-gray-500 px-2 py-1">Selecciona un jugador:</p>
                                                                
                                                                <!-- Buscador -->
                                                                <div class="relative mb-2">
                                                                    <input type="text" 
                                                                        x-model="search" 
                                                                        placeholder="Buscar jugador..."
                                                                        class="w-full px-3 py-2 pl-9 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                                                        @click.stop>
                                                                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                                    </svg>
                                                                </div>

                                                                <!-- Lista de jugadores con scroll -->
                                                                <div class="max-h-60 overflow-y-auto">
                                                                    @foreach($calledPlayersData as $availablePlayer)
                                                                    @php
                                                                        $isInLineup = false;
                                                                        foreach($lineup as $positions) {
                                                                            if(in_array($availablePlayer->id, $positions)) {
                                                                                $isInLineup = true;
                                                                                break;
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    @if(!$isInLineup)
                                                                        <button type="button" 
                                                                            x-show="search === '' || '{{ strtolower($availablePlayer->name . ' ' . $availablePlayer->surname) }}'.includes(search.toLowerCase())"
                                                                            wire:click="addToLineup({{ $availablePlayer->id }}, {{ $lineIndex }}, {{ $positionIndex }})"
                                                                            @click="open = false; search = ''"
                                                                            class="w-full flex items-center gap-2 px-3 py-2 hover:bg-blue-50 rounded-lg transition-colors text-left">
                                                                            @if($availablePlayer->player_photo)
                                                                                <img src="{{ asset('storage/' . $availablePlayer->player_photo) }}" alt="{{ $availablePlayer->name }}" class="w-8 h-8 rounded-full object-cover">
                                                                            @else
                                                                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                                                    <span class="text-blue-600 font-bold text-xs">{{ substr($availablePlayer->name, 0, 1) }}{{ substr($availablePlayer->surname, 0, 1) }}</span>
                                                                                </div>
                                                                            @endif
                                                                            <div class="flex-1 min-w-0">
                                                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $availablePlayer->surname }}, {{ $availablePlayer->name }}</p>
                                                                                @if($availablePlayer->position)
                                                                                    <p class="text-xs text-gray-500">{{ $availablePlayer->position }}</p>
                                                                                @endif
                                                                            </div>
                                                                        </button>
                                                                    @endif
                                                                @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                @endforeach
                            </div>

                            <!-- Leyenda -->
                            <div class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-sm rounded-lg px-4 py-2">
                                <p class="text-white text-xs font-semibold">
                                    @php
                                        $totalInLineup = 0;
                                        foreach($lineup as $positions) {
                                            $totalInLineup += count($positions);
                                        }
                                    @endphp
                                    Jugadores en el campo: {{ $totalInLineup }} / {{ $footballType }}
                                </p>
                            </div>
                                </div>

                                @if($totalInLineup < $footballType)
                                    <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                        <p class="text-yellow-700 text-sm">Faltan {{ $footballType - $totalInLineup }} jugadores por añadir a la alineación</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Banquillo (20% en desktop) -->
                            @php
                                $benchPlayers = [];
                                $lineupPlayerIds = [];
                                foreach($lineup as $positions) {
                                    foreach($positions as $playerId) {
                                        $lineupPlayerIds[] = $playerId;
                                    }
                                }
                                foreach($calledPlayersData as $player) {
                                    if(!in_array($player->id, $lineupPlayerIds)) {
                                        $benchPlayers[] = $player;
                                    }
                                }
                            @endphp

                            @if(count($benchPlayers) > 0)
                            <div class="hidden lg:block w-full lg:w-1/5">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-4 shadow-lg h-full">
                                    <h4 class="text-base font-semibold text-titanium flex items-center border-b border-silver/30 pb-2 mb-4">
                                        <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="text-sm">Banquillo ({{ count($benchPlayers) }})</span>
                                    </h4>
                                    
                                    <div class="grid grid-cols-2 gap-2 overflow-y-auto" style="max-height: 600px;">
                                        @foreach($benchPlayers as $player)
                                            <div class="flex flex-col items-center group bg-white rounded-xl p-2 shadow-sm hover:shadow-md transition-all">
                                                <div class="w-12 h-12 bg-white rounded-full shadow-lg border-2 border-gray-400 overflow-hidden transition-all group-hover:scale-110 cursor-pointer mb-1">
                                                    @if($player->player_photo)
                                                        <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                            <span class="text-gray-600 font-bold text-xs">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-center w-full">
                                                    <p class="text-titanium text-[10px] font-bold line-clamp-2 leading-tight">{{ $player->name }} {{ $player->surname }}</p>
                                                    @if($player->position)
                                                        <p class="text-gray-500 text-[8px] mt-0.5">{{ $player->position }}</p>
                                                    @endif
                                                    
                                                    <!-- Tarjetas en banquillo -->
                                                    @if($player->pivot->card_yellow1 || $player->pivot->card_yellow2 || $player->pivot->card_red)
                                                        <div class="flex justify-center gap-0.5 mt-0.5">
                                                            @if($player->pivot->card_yellow1)
                                                                <div class="w-1.5 h-2 bg-yellow-400 rounded-sm shadow-sm border border-yellow-500"></div>
                                                            @endif
                                                            @if($player->pivot->card_yellow2)
                                                                <div class="w-1.5 h-2 bg-yellow-400 rounded-sm shadow-sm border border-yellow-500"></div>
                                                            @endif
                                                            @if($player->pivot->card_red)
                                                                <div class="w-1.5 h-2 bg-red-600 rounded-sm shadow-sm border border-red-700"></div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Banquillo versión móvil (oculto en desktop) -->
                        @php
                            $benchPlayers = [];
                            $lineupPlayerIds = [];
                            foreach($lineup as $positions) {
                                foreach($positions as $playerId) {
                                    $lineupPlayerIds[] = $playerId;
                                }
                            }
                            foreach($calledPlayersData as $player) {
                                if(!in_array($player->id, $lineupPlayerIds)) {
                                    $benchPlayers[] = $player;
                                }
                            }
                        @endphp

                        @if(count($benchPlayers) > 0)
                        <div class="mt-8 lg:hidden">
                            <h4 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-6">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Banquillo ({{ count($benchPlayers) }} jugador{{ count($benchPlayers) != 1 ? 'es' : '' }})
                            </h4>
                            
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6 shadow-lg">
                                <div class="flex flex-wrap gap-4 justify-start">
                                    @foreach($benchPlayers as $player)
                                        <div class="flex flex-col items-center group">
                                            <div class="w-20 h-20 bg-white rounded-full shadow-xl border-4 border-gray-400 overflow-hidden transition-all group-hover:scale-110 cursor-pointer">
                                                @if($player->player_photo)
                                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                        <span class="text-gray-600 font-bold text-xl">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mt-2 text-center">
                                                <p class="text-titanium text-sm font-bold line-clamp-1 max-w-[100px]">{{ $player->name }} {{ $player->surname }}</p>
                                                @if($player->position)
                                                    <p class="text-gray-500 text-xs">{{ $player->position }}</p>
                                                @endif
                                                
                                                <!-- Tarjetas en banquillo -->
                                                @if($player->pivot->card_yellow1 || $player->pivot->card_yellow2 || $player->pivot->card_red)
                                                    <div class="flex justify-center gap-1 mt-1">
                                                        @if($player->pivot->card_yellow1)
                                                            <div class="w-3 h-4 bg-yellow-400 rounded-sm shadow-md border border-yellow-500"></div>
                                                        @endif
                                                        @if($player->pivot->card_yellow2)
                                                            <div class="w-3 h-4 bg-yellow-400 rounded-sm shadow-md border border-yellow-500"></div>
                                                        @endif
                                                        @if($player->pivot->card_red)
                                                            <div class="w-3 h-4 bg-red-600 rounded-sm shadow-md border border-red-700"></div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
                @elseif($team_id && count($calledPlayers) < $footballType)
                <div class="mt-8">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <p class="text-blue-700 text-sm">Necesitas convocar al menos {{ $footballType }} jugadores para crear la alineación titular</p>
                    </div>
                </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Modal: Añadir Jugador de Otro Equipo -->
    @if($showAddExternalPlayerModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showAddExternalPlayerModal') }">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeAddExternalPlayerModal"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Añadir Jugador de Otro Equipo
                        </h3>
                        <button wire:click="closeAddExternalPlayerModal" type="button" class="text-white hover:text-purple-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-5">
                    <!-- Team Selector -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-titanium mb-2">Selecciona un Equipo</label>
                        <select wire:model.live="selectedExternalTeamId" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                            <option value="">-- Selecciona un equipo --</option>
                            @foreach($allTeams as $team)
                                <option value="{{ $team->id }}">
                                    {{ $team->team }} - {{ $team->category->category ?? '' }} ({{ $team->season->from_year }}/{{ $team->season->to_year }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Players List -->
                    @if($selectedExternalTeamId && count($externalPlayers) > 0)
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-semibold text-titanium">
                                Jugadores del Equipo ({{ count($externalPlayers) }})
                            </h4>
                        </div>
                        
                        <div class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded-xl p-3 bg-gray-50">
                            @foreach($externalPlayers as $player)
                                <div wire:key="external-{{ $player['id'] }}" class="bg-white rounded-lg p-3 border border-gray-200 hover:border-purple-400 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center flex-1 min-w-0">
                                            @if($player['player_photo'])
                                                <img src="{{ asset('storage/' . $player['player_photo']) }}" alt="{{ $player['name'] }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                    <span class="text-purple-600 font-bold text-sm">{{ substr($player['name'], 0, 1) }}{{ substr($player['surname'], 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-titanium truncate">{{ $player['surname'] }}, {{ $player['name'] }}</p>
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    @if($player['position'])
                                                        <span>{{ $player['position'] }}</span>
                                                    @endif
                                                    @if($player['dni'])
                                                        <span class="text-gray-400">•</span>
                                                        <span>{{ $player['dni'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if(in_array($player['id'], $calledPlayers))
                                            <span class="ml-2 px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold flex-shrink-0">
                                                Ya convocado
                                            </span>
                                        @else
                                            <button type="button" wire:click="addExternalPlayer({{ $player['id'] }})" 
                                                class="ml-2 px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-semibold transition-colors flex-shrink-0">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Añadir
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @elseif($selectedExternalTeamId)
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">No hay jugadores en este equipo</p>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="text-gray-500 text-sm">Selecciona un equipo para ver sus jugadores</p>
                    </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button type="button" wire:click="closeAddExternalPlayerModal" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold text-sm transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
