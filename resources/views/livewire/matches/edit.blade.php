<div>
    <div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-2 overflow-hidden">
                <a href="{{ route('matches.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
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
                    <span class="hidden sm:inline">Compartir</span>
                </button>
                <button wire:click="printPDF" type="button" class="inline-flex items-center px-3 py-2 sm:px-4 bg-green-600 text-white rounded-xl font-semibold text-xs sm:text-sm hover:bg-green-700 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Imprimir PDF</span>
                </button>
                <a href="{{ route('matches.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="hidden sm:inline">Cancelar</span>
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                            <select wire:model.live="season_id" 
                                class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                <option value="">Selecciona temporada</option>
                                @foreach($seasons as $season)
                                    <option value="{{ $season->id }}">{{ $season->season }}</option>
                                @endforeach
                            </select>
                            @error('season_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
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

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Rival *</label>
                            <input wire:model="opponent" type="text" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                placeholder="Nombre del equipo rival">
                            @error('opponent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Fecha *</label>
                            <input wire:model="date" type="date" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Hora del Partido</label>
                            <input wire:model="hour_match" type="time" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('hour_match') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-titanium mb-2">Hora de Citación</label>
                            <input wire:model="hour_meeting" type="time" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('hour_meeting') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group md:col-span-2">
                            <label class="block text-sm font-semibold text-titanium mb-2">Lugar</label>
                            <input wire:model="site" type="text" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                placeholder="Ej: Estadio Municipal">
                            @error('site') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group lg:col-span-3">
                            <label class="block text-sm font-semibold text-titanium mb-2">Observaciones</label>
                            <textarea wire:model="observations" rows="3"
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                placeholder="Observaciones generales del partido"></textarea>
                            @error('observations') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Resultado del Partido -->
                        <div class="form-group lg:col-span-3">
                            <h4 class="text-md font-semibold text-titanium mb-3 pb-2 border-b border-silver/30">Resultado del Partido</h4>
                        </div>

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

                        <div class="form-group lg:col-span-3">
                            <label class="block text-sm font-semibold text-titanium mb-2">Escudo del Equipo Rival</label>
                            <div class="flex items-start gap-4">
                                <div class="flex-1">
                                    <input wire:model="newEscudoTeamOponent" type="file" accept="image/*"
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('newEscudoTeamOponent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG. Máximo 2MB</p>
                                </div>
                                @if($escudo_team_oponent)
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $escudo_team_oponent) }}" alt="Escudo actual" class="w-16 h-16 object-contain border border-gray-200 rounded-lg p-1">
                                        <p class="text-xs text-gray-500 text-center mt-1">Actual</p>
                                    </div>
                                @endif
                                @if($newEscudoTeamOponent)
                                    <div class="flex-shrink-0">
                                        <img src="{{ $newEscudoTeamOponent->temporaryUrl() }}" alt="Nueva imagen" class="w-16 h-16 object-contain border border-green-500 rounded-lg p-1">
                                        <p class="text-xs text-green-600 text-center mt-1">Nueva</p>
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

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Columna Izquierda: Jugadores No Convocados -->
                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                            <h4 class="font-semibold text-titanium mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Jugadores Disponibles ({{ count($notCalledPlayers) }})
                            </h4>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                @forelse($notCalledPlayersData as $player)
                                    <div wire:key="not-called-{{ $player->id }}" class="bg-white rounded-lg p-3 border border-gray-200 hover:border-primary transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1 min-w-0">
                                                @if($player->player_photo)
                                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                                                        <span class="text-primary font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-titanium truncate">{{ $player->surname }}, {{ $player->name }}</p>
                                                    @if($player->position)
                                                        <p class="text-xs text-gray-500">{{ $player->position }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" wire:click="addPlayer({{ $player->id }})" 
                                                class="ml-2 p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors flex-shrink-0"
                                                title="Convocar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Campo de razón no convocado -->
                                        <div class="mt-2">
                                            <textarea wire:model.defer="playerReasons.{{ $player->id }}" 
                                                wire:key="reason-{{ $player->id }}"
                                                rows="2"
                                                class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-primary"
                                                placeholder="Razón de no convocatoria (opcional)"></textarea>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Todos los jugadores están convocados</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Columna Derecha: Jugadores Convocados -->
                        <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200">
                            <h4 class="font-semibold text-titanium mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Jugadores Convocados ({{ count($calledPlayers) }})
                            </h4>
                            <div class="space-y-2 max-h-96 overflow-y-auto">
                                @forelse($calledPlayersData as $player)
                                    <div wire:key="called-{{ $player->id }}" class="bg-white rounded-lg p-3 border border-green-200 hover:border-primary transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1 min-w-0">
                                                @if($player->player_photo)
                                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-green-600/10 flex items-center justify-center mr-3">
                                                        <span class="text-green-600 font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-titanium truncate">{{ $player->surname }}, {{ $player->name }}</p>
                                                    @if($player->position)
                                                        <p class="text-xs text-gray-500">{{ $player->position }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removePlayer({{ $player->id }})" 
                                                class="ml-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex-shrink-0"
                                                title="Quitar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">No hay jugadores convocados</p>
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
