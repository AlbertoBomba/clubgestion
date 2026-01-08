<div>
    <div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-2 overflow-hidden">
                <a href="{{ route('matches.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                    {{ __('Partidos') }}
                </a>
                <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
                <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                    Crear Partido
                </h2>
            </div>
            
            <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
                <a href="{{ route('matches.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="hidden sm:inline">Cancelar</span>
                </a>
                <button type="submit" form="match-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
                    <svg wire:loading.remove wire:target="save" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Crear</span>
                    <span wire:loading wire:target="save">Creando...</span>
                </button>
            </div>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        <form wire:submit="save" id="match-form">
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
                        <span class="text-sm font-normal text-gray-500">
                            Convocados: {{ count($calledPlayers) }} / {{ $maxPlayers }}
                        </span>
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
</div>
