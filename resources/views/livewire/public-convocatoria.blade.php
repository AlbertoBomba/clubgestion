<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-4 sm:py-8 px-2 sm:px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Success Message -->
        @if (session()->has('confirmation_success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-700 font-semibold">{{ session('confirmation_success') }}</p>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-xl sm:rounded-t-2xl shadow-lg p-4 sm:p-6 md:p-8 text-white">
            <div class="flex flex-col items-center gap-4 sm:gap-6">
                <!-- Team Shields -->
                <div class="flex items-center justify-center gap-4 sm:gap-6 md:gap-8 w-full">
                    @if($match->sites === 'away')
                        <!-- Away: Rival vs School -->
                        @if($match->escudo_team_oponent)
                            <div class="flex flex-col items-center">
                                <img src="{{ asset('storage/' . $match->escudo_team_oponent) }}" 
                                     alt="Escudo Rival" 
                                     class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 object-contain bg-white rounded-full p-2 shadow-lg">
                                {{-- <p class="text-xs sm:text-sm font-semibold mt-2 text-center">{{ $match->opponent }}</p> --}}
                            </div>
                        @endif
                        
                        <div class="flex flex-col items-center">
                            <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-white px-3 py-2 bg-white/20 rounded-full backdrop-blur-sm">VS</div>
                            {{-- <p class="text-xs sm:text-sm font-semibold mt-2 opacity-75">{{ $match->sites === 'away' ? 'VISITANTE' : 'LOCAL' }}</p> --}}
                        </div>
                        
                        @if($team->season->sportsSchool->logo)
                            <div class="flex flex-col items-center">
                                <img src="{{ asset('storage/' . $team->season->sportsSchool->logo) }}" 
                                     alt="Escudo Escuela" 
                                     class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 object-contain bg-white rounded-full p-2 shadow-lg">
                                {{-- <p class="text-xs sm:text-sm font-semibold mt-2 text-center">{{ $team->season->sportsSchool->name }}</p> --}}
                            </div>
                        @endif
                    @else
                        <!-- Home: School vs Rival -->
                        @if($team->season->sportsSchool->logo)
                            <div class="flex flex-col items-center">
                                <img src="{{ asset('storage/' . $team->season->sportsSchool->logo) }}" 
                                     alt="Escudo Escuela" 
                                     class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 object-contain bg-white rounded-full p-2 shadow-lg">
                                {{-- <p class="text-xs sm:text-sm font-semibold mt-2 text-center">{{ $team->season->sportsSchool->name }}</p> --}}
                            </div>
                        @endif
                        
                        <div class="flex flex-col items-center">
                            <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-white px-3 py-2 bg-white/20 rounded-full backdrop-blur-sm">VS</div>
                            {{-- <p class="text-xs sm:text-sm font-semibold mt-2 opacity-75">{{ $match->sites === 'home' ? 'LOCAL' : '' }}</p> --}}
                        </div>
                        
                        @if($match->escudo_team_oponent)
                            <div class="flex flex-col items-center">
                                <img src="{{ asset('storage/' . $match->escudo_team_oponent) }}" 
                                     alt="Escudo Rival" 
                                     class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 object-contain bg-white rounded-full p-2 shadow-lg">
                                {{-- <p class="text-xs sm:text-sm font-semibold mt-2 text-center">{{ $match->opponent }}</p> --}}
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Team Name and Badge -->
                <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-4 w-full">
                    <div class="text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1 sm:mb-2">{{ $team->season->sportsSchool->name }}</h1>
                        <h2 class="text-lg sm:text-xl md:text-2xl font-semibold opacity-90">{{ $team->team }}</h2>
                    </div>
                    {{-- <div class="text-center bg-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-sm">
                        <div class="text-4xl sm:text-5xl font-bold mb-1 sm:mb-2">{{ $calledPlayers->count() }}</div>
                        <div class="text-xs sm:text-sm uppercase tracking-wider opacity-90">Convocados</div>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Match Info -->
        <div class="bg-white shadow-lg p-4 sm:p-6 md:p-8 border-l-4 border-pink-400">
            <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 uppercase tracking-wide">Información del Partido</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Fecha</div>
                        <div class="text-lg font-semibold text-gray-800">{{ $match->date->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Hora del Partido</div>
                        <div class="text-lg font-semibold text-gray-800">{{ $match->hour_match ? \Carbon\Carbon::parse($match->hour_match)->format('H:i') : '-' }}</div>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Hora de quedada</div>
                        <div class="text-lg font-semibold text-gray-800">{{ $match->hour_meeting ? \Carbon\Carbon::parse($match->hour_meeting)->format('H:i') : '-' }}</div>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Rival</div>
                        <div class="text-lg font-semibold text-gray-800">{{ $match->opponent }}</div>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500 uppercase tracking-wide">Lugar</div>
                        <div class="text-lg font-semibold text-gray-800">{{ $match->site }}</div>
                    </div>
                </div>

                @if($match->sites)
                    <div class="flex items-start space-x-3">
                        @if($match->sites === 'away')
                            <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-blue-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        @endif
                        <div>
                            <div class="text-sm text-gray-500 uppercase tracking-wide">Ubicación</div>
                            <div class="text-lg font-semibold text-gray-800">
                                {{ $match->sites === 'home' ? 'En Casa' : 'Fuera de Casa' }}
                            </div>
                        </div>
                    </div>
                @endif

                @if($match->observations)
                    <div class="md:col-span-2 lg:col-span-3 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-orange-500 rounded-lg p-4 shadow-md">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-bold text-orange-700 uppercase tracking-wide mb-2 flex items-center gap-2">
                                    <span> Observaciones Importantes</span>
                                </div>
                                <div class="text-base sm:text-lg font-semibold text-gray-900 leading-relaxed bg-white/50 p-3 rounded border border-orange-200">
                                    {{ $match->observations }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Players List -->
        <div class="bg-white rounded-b-xl sm:rounded-b-2xl shadow-lg p-4 sm:p-6 md:p-8">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-6 sm:mb-8 pb-4 border-b-2 border-green-500 gap-3">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 uppercase tracking-wide text-center sm:text-left">Jugadores Convocados</h3>
                <div class="bg-green-500 text-white px-5 sm:px-6 py-2 sm:py-3 rounded-full text-xl sm:text-2xl font-bold shadow-lg">
                    {{ $calledPlayers->count() }}
                </div>
            </div>

            <!-- Confirmation Summary -->
            @php
                $confirmedCount = $calledPlayers->where('pivot.confirmed', true)->count();
                $pendingCount = $calledPlayers->where('pivot.confirmed', false)->count();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <!-- Confirmed -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border-2 border-green-300 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Confirmados</div>
                                <div class="text-3xl font-bold text-green-700">{{ $confirmedCount }}</div>
                            </div>
                        </div>
                        <div class="text-green-600">
                            @if($confirmedCount > 0)
                                <span class="text-xs font-bold bg-green-200 px-2 py-1 rounded-full">
                                    {{ number_format(($confirmedCount / $calledPlayers->count()) * 100, 0) }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border-2 border-yellow-300 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-yellow-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Pendientes</div>
                                <div class="text-3xl font-bold text-yellow-700">{{ $pendingCount }}</div>
                            </div>
                        </div>
                        <div class="text-yellow-600">
                            @if($pendingCount > 0)
                                <span class="text-xs font-bold bg-yellow-200 px-2 py-1 rounded-full">
                                    {{ number_format(($pendingCount / $calledPlayers->count()) * 100, 0) }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse($calledPlayers as $player)
                    @php
                        // Check if player belongs to the main team or is from another team
                        $isExternalPlayer = !$player->teams->contains('id', $team->id);
                    @endphp
                    <div class="bg-gradient-to-br @if($isExternalPlayer) from-purple-50 to-purple-100 @else from-gray-50 to-gray-100 @endif rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border-2 @if($player->pivot->confirmed) @if($isExternalPlayer) border-purple-500 @else border-green-400 @endif @else @if($isExternalPlayer) border-purple-300 @else border-gray-200 @endif @endif hover:border-blue-400">
                        <!-- Confirmation Status Badge -->
                        @if($isExternalPlayer)
                            <!-- External Player Badge -->
                            <div class="bg-purple-600 text-white px-3 py-1 text-xs font-bold flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                                JUGADOR EXTERNO
                                @if($player->pivot->confirmed)
                                    <span class="ml-2">✓ CONFIRMADO</span>
                                @endif
                            </div>
                        @else
                            @if($player->pivot->confirmed)
                                <div class="bg-green-500 text-white px-3 py-1 text-xs font-bold flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    CONFIRMADO
                                </div>
                            @else
                                <div class="bg-yellow-500 text-white px-3 py-1 text-xs font-bold flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    PENDIENTE
                                </div>
                            @endif
                        @endif

                        <div class="relative">
                            @if($player->player_photo)
                                <img src="{{ asset('storage/' . $player->player_photo) }}" 
                                     alt="{{ $player->name }}"
                                     class="w-full h-64 sm:h-72 md:h-80 object-cover">
                            @else
                                <div class="w-full h-64 sm:h-72 md:h-80 bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <span class="text-white text-6xl sm:text-7xl font-bold">
                                        {{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Number Badge -->
                            @if($player->shirt_number)
                                <div class="absolute top-3 right-3 @if($isExternalPlayer) bg-purple-600 @else bg-blue-600 @endif text-white font-bold px-3 sm:px-4 py-2 rounded-lg text-lg sm:text-xl shadow-lg">
                                    {{ $player->shirt_number }}
                                </div>
                            @endif
                        </div>

                        <div class="p-3 sm:p-4">
                            <!-- Position -->
                            @if($player->position)
                                <div class="text-xs sm:text-sm font-bold @if($isExternalPlayer) text-purple-600 @else text-blue-600 @endif uppercase tracking-wider mb-2">
                                    {{ $player->position }}
                                </div>
                            @endif

                            <!-- Player Name -->
                            <div class="text-base sm:text-lg md:text-xl font-bold text-gray-800 uppercase leading-tight">
                                {{ $player->name }}
                            </div>
                            <div class="text-base sm:text-lg md:text-xl font-bold text-gray-800 uppercase leading-tight mb-3">
                                {{ $player->surname }}
                            </div>

                            <!-- Confirm Button -->
                            @if(!$player->pivot->confirmed)
                                <button wire:click="openConfirmModal({{ $player->id }})" 
                                        class="w-full @if($isExternalPlayer) bg-purple-600 hover:bg-purple-700 @else bg-green-600 hover:bg-green-700 @endif text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Confirmar Asistencia
                                </button>
                            @else
                                <div class="text-center text-sm text-gray-600">
                                    <span class="font-semibold">Confirmado el</span><br>
                                    {{ \Carbon\Carbon::parse($player->pivot->confirmed_at)->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-xl text-gray-500">No hay jugadores convocados</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 sm:mt-8 text-center text-gray-600 px-4">
            <p class="text-xs sm:text-sm">Esta convocatoria es de carácter privado y confidencial</p>
            <p class="text-xs mt-2">{{ $team->season->sportsSchool->name }} - Temporada {{ $match->season->season }}</p>
        </div>
    </div>

    <!-- Confirmation Modal -->
    @if($showConfirmModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" x-data="{ show: true }">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden" @click.away="$wire.closeConfirmModal()">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirmar Asistencia
                        </h3>
                        <button wire:click="closeConfirmModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <!-- Player Info -->
                    <div class="flex flex-col items-center mb-6">
                        @if($selectedPlayerPhoto)
                            <img src="{{ asset('storage/' . $selectedPlayerPhoto) }}" 
                                 alt="{{ $selectedPlayerName }} {{ $selectedPlayerSurname }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-green-500 shadow-lg mb-3">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center border-4 border-green-500 shadow-lg mb-3">
                                <span class="text-white text-3xl font-bold">
                                    {{ substr($selectedPlayerName, 0, 1) }}{{ substr($selectedPlayerSurname, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <h4 class="text-xl font-bold text-gray-800 text-center">
                            {{ $selectedPlayerName }} {{ $selectedPlayerSurname }}
                        </h4>
                    </div>

                    <div class="mb-6 text-center border-t pt-4">
                        <p class="text-gray-700 text-base">Para confirmar tu asistencia al partido, por favor introduce tu <strong>DNI</strong>.</p>
                    </div>

                    <!-- DNI Input -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">DNI</label>
                        <input type="text" 
                               wire:model="dniInput" 
                               placeholder="Ejemplo: 12345678A"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg uppercase"
                               @keydown.enter="$wire.confirmAttendance()">
                    </div>

                    <!-- Error Message -->
                    @if($confirmationError)
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-red-700 text-sm">{{ $confirmationError }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button wire:click="closeConfirmModal" 
                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition-colors duration-200">
                            Cancelar
                        </button>
                        <button wire:click="confirmAttendance" 
                                wire:loading.attr="disabled"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <svg wire:loading class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>Confirmar</span>
                            <span wire:loading>Confirmando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
