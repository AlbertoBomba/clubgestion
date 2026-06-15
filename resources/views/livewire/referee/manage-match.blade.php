<div x-data="{ activeTab: @entangle('activeTab') }">
    <x-slot name="title">Gestión del Partido</x-slot>
    <x-slot name="backUrl">{{ route('referee.tournament.matches', $match->tournament) }}</x-slot>

    <!-- Flash Messages -->
    @if (session('message'))
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 3000)" 
             x-show="show"
             x-transition
             class="fixed top-20 left-0 right-0 z-50 mx-auto max-w-md px-4">
            <div class="bg-green-500 text-white px-4 py-3 rounded-xl shadow-lg font-semibold text-sm text-center">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Match Header -->
    <div class="bg-gradient-to-br from-primary to-blue-600 px-4 py-6">
        <!-- Teams & Score -->
        <div class="space-y-4">
            <!-- Home Team -->
            <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                <div class="flex items-center gap-3 flex-1">
                    @if($match->homeTeam?->logo ?? $match->homeTeam?->team?->logo)
                        <img src="{{ asset('storage/' . ($match->homeTeam->logo ?? $match->homeTeam->team->logo)) }}" 
                             class="w-12 h-12 rounded-lg object-cover border-2 border-white" alt="">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center border-2 border-white">
                            <span class="text-sm font-bold text-white">{{ substr($match->homeTeam?->displayName() ?? 'TBD', 0, 1) }}</span>
                        </div>
                    @endif
                    <span class="font-bold text-white text-lg">{{ $match->homeTeam?->displayName() ?? 'Por definir' }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-4xl font-black text-white">{{ $homeGoals }}</span>
                    @if($match->status !== 'scheduled')
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center border border-white/40 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg overflow-hidden z-10">
                                <button wire:click="openGoalFormForTeam({{ $match->home_team_id }})" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Gol
                                </button>
                                <button wire:click="openCardFormForTeam({{ $match->home_team_id }})" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Tarjeta
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- VS -->
            <div class="text-center">
                <span class="text-xs font-bold text-white/60">VS</span>
            </div>

            <!-- Away Team -->
            <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                <div class="flex items-center gap-3 flex-1">
                    @if($match->awayTeam?->logo ?? $match->awayTeam?->team?->logo)
                        <img src="{{ asset('storage/' . ($match->awayTeam->logo ?? $match->awayTeam->team->logo)) }}" 
                             class="w-12 h-12 rounded-lg object-cover border-2 border-white" alt="">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center border-2 border-white">
                            <span class="text-sm font-bold text-white">{{ substr($match->awayTeam?->displayName() ?? 'TBD', 0, 1) }}</span>
                        </div>
                    @endif
                    <span class="font-bold text-white text-lg">{{ $match->awayTeam?->displayName() ?? 'Por definir' }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-4xl font-black text-white">{{ $awayGoals }}</span>
                    @if($match->status !== 'scheduled')
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center border border-white/40 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg overflow-hidden z-10">
                                <button wire:click="openGoalFormForTeam({{ $match->away_team_id }})" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Gol
                                </button>
                                <button wire:click="openCardFormForTeam({{ $match->away_team_id }})" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Tarjeta
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Match Status & Actions -->
        <div class="mt-4">
            @if($match->status === 'scheduled')
                <button wire:click="startMatch" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg transition-colors">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Iniciar Partido
                    </div>
                </button>
            @elseif($match->status === 'in_progress')
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/20">
                        <div class="flex items-center gap-2 justify-center">
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                            <span class="text-sm font-bold text-white">EN CURSO</span>
                        </div>
                    </div>
                    <button wire:click="finishMatch" 
                            wire:confirm="¿Estás seguro de finalizar el partido?"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-colors">
                        Finalizar
                    </button>
                </div>
            @elseif($match->status === 'completed')
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/20 text-center">
                        <span class="text-sm font-bold text-white">PARTIDO FINALIZADO</span>
                    </div>
                    <button wire:click="reopenMatch" 
                            wire:confirm="¿Quieres reabrir el partido para editarlo?"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-colors">
                        Reabrir
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white border-b border-gray-200 sticky top-16 z-40">
        <div class="flex overflow-x-auto">
            <button @click="activeTab = 'goals'" 
                    :class="activeTab === 'goals' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Goles ({{ $goals->count() }})
            </button>
            <button @click="activeTab = 'cards'" 
                    :class="activeTab === 'cards' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Tarjetas ({{ $cards->count() }})
            </button>
            <button @click="activeTab = 'notes'" 
                    :class="activeTab === 'notes' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Notas
            </button>
            <button @click="activeTab = 'players'" 
                    :class="activeTab === 'players' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Jugadores
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="p-4 pb-32">
        <!-- GOALS TAB -->
        <div x-show="activeTab === 'goals'" x-cloak>
            @if($match->status !== 'scheduled')
                <button wire:click="$set('showGoalForm', true)" 
                        class="w-full mb-4 flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Gol
                </button>
            @endif

            <!-- Goals List -->
            <div class="space-y-2">
                @forelse($goals as $goal)
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900">
                                {{ $goal->player?->surname }} {{ $goal->player?->name }}
                                @if($goal->goal_type === 'penalty')
                                    <span class="text-xs text-blue-600">(Penal)</span>
                                @elseif($goal->goal_type === 'own_goal')
                                    <span class="text-xs text-red-600">(Propia)</span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $goal->team?->displayName() }}
                                @if($goal->minute)
                                    · Min. {{ $goal->minute }}
                                @endif
                            </p>
                        </div>
                        @if($match->status !== 'scheduled')
                            <button wire:click="deleteGoal({{ $goal->id }})" 
                                    wire:confirm="¿Eliminar este gol?"
                                    class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <p class="text-sm text-gray-500">No hay goles registrados</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- CARDS TAB -->
        <div x-show="activeTab === 'cards'" x-cloak>
            @if($match->status !== 'scheduled')
                <button wire:click="$set('showCardForm', true)" 
                        class="w-full mb-4 flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-xl shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Tarjeta
                </button>
            @endif

            <!-- Cards List -->
            <div class="space-y-2">
                @forelse($cards as $card)
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $card->card_type === 'yellow' ? 'bg-yellow-100' : 'bg-red-100' }} flex items-center justify-center shrink-0">
                            <div class="w-6 h-8 rounded {{ $card->card_type === 'yellow' ? 'bg-yellow-500' : 'bg-red-600' }}"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900">
                                {{ $card->player?->surname }} {{ $card->player?->name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $card->team?->displayName() }}
                                @if($card->minute)
                                    · Min. {{ $card->minute }}
                                @endif
                            </p>
                            @if($card->notes)
                                <p class="text-xs text-gray-400 mt-1">{{ $card->notes }}</p>
                            @endif
                        </div>
                        @if($match->status !== 'scheduled')
                            <button wire:click="deleteCard({{ $card->id }})" 
                                    wire:confirm="¿Eliminar esta tarjeta?"
                                    class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <p class="text-sm text-gray-500">No hay tarjetas registradas</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- NOTES TAB -->
        <div x-show="activeTab === 'notes'" x-cloak>
            <textarea wire:model="matchNotes" 
                      rows="10" 
                      placeholder="Escribe aquí las incidencias del partido..."
                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 resize-none"></textarea>
            <button wire:click="saveNotes" 
                    class="w-full mt-3 bg-primary hover:bg-primary/90 text-white font-bold py-3 rounded-xl shadow-sm transition-colors">
                Guardar Notas
            </button>
        </div>

        <!-- PLAYERS TAB -->
        <div x-show="activeTab === 'players'" x-cloak class="space-y-4">
            <!-- Home Team Players -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-blue-600 px-4 py-3 flex items-center gap-3">
                    @if($match->homeTeam?->logo ?? $match->homeTeam?->team?->logo)
                        <img src="{{ asset('storage/' . ($match->homeTeam->logo ?? $match->homeTeam->team->logo)) }}" 
                             class="w-8 h-8 rounded-lg object-cover border-2 border-white" alt="">
                    @endif
                    <span class="font-bold text-white">{{ $match->homeTeam?->displayName() ?? 'Equipo Local' }}</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($homePlayers as $player)
                        <button wire:click="viewPlayerDetails({{ $player->id }})" 
                                class="w-full px-4 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors text-left">
                            @if($player->photo)
                                <img src="{{ asset('storage/' . $player->photo) }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200" alt="">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    @if($player->dorsal)
                                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">#{{ $player->dorsal }}</span>
                                    @endif
                                    <span class="font-semibold text-gray-900">{{ $player->surname }}</span>
                                    <span class="text-gray-600">{{ $player->name }}</span>
                                </div>
                                @if($player->position)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $player->position }}</p>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @empty
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            No hay jugadores registrados
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Away Team Players -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-blue-600 px-4 py-3 flex items-center gap-3">
                    @if($match->awayTeam?->logo ?? $match->awayTeam?->team?->logo)
                        <img src="{{ asset('storage/' . ($match->awayTeam->logo ?? $match->awayTeam->team->logo)) }}" 
                             class="w-8 h-8 rounded-lg object-cover border-2 border-white" alt="">
                    @endif
                    <span class="font-bold text-white">{{ $match->awayTeam?->displayName() ?? 'Equipo Visitante' }}</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($awayPlayers as $player)
                        <button wire:click="viewPlayerDetails({{ $player->id }})" 
                                class="w-full px-4 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors text-left">
                            @if($player->photo)
                                <img src="{{ asset('storage/' . $player->photo) }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200" alt="">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    @if($player->dorsal)
                                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">#{{ $player->dorsal }}</span>
                                    @endif
                                    <span class="font-semibold text-gray-900">{{ $player->surname }}</span>
                                    <span class="text-gray-600">{{ $player->name }}</span>
                                </div>
                                @if($player->position)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $player->position }}</p>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @empty
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            No hay jugadores registrados
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Goal Form Modal -->
    @if($showGoalForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" wire:click="$set('showGoalForm', false)">
            <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl" wire:click.stop @click.away="$wire.set('showGoalForm', false)">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Añadir Gol</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Equipo</label>
                        <select wire:model.live="goalTeamId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option value="">Seleccionar equipo</option>
                            <option value="{{ $match->home_team_id }}">{{ $match->homeTeam?->displayName() }}</option>
                            <option value="{{ $match->away_team_id }}">{{ $match->awayTeam?->displayName() }}</option>
                        </select>
                        @error('goalTeamId') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ search: @entangle('goalPlayerSearch'), showResults: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jugador <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input 
                                x-model="search"
                                @focus="showResults = true"
                                @click.away="showResults = false"
                                type="text" 
                                placeholder="Buscar por nombre, apellido o dorsal..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30"
                            >
                            <div x-show="showResults && search.length > 0" x-cloak class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto z-20">
                                @if($goalTeamId == $match->home_team_id)
                                    @foreach($homePlayers as $player)
                                        <button 
                                            type="button"
                                            @click="$wire.set('goalPlayerId', {{ $player->id }}); search = '#{{ $player->dorsal ?? '' }} {{ $player->surname }} {{ $player->name }}'; showResults = false"
                                            x-show="'{{ strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name) }}'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            @if($player->dorsal)
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">{{ $player->dorsal }}</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold">{{ $player->surname }}</span>
                                                <span class="text-gray-600">{{ $player->name }}</span>
                                            </div>
                                        </button>
                                    @endforeach
                                @elseif($goalTeamId == $match->away_team_id)
                                    @foreach($awayPlayers as $player)
                                        <button 
                                            type="button"
                                            @click="$wire.set('goalPlayerId', {{ $player->id }}); search = '#{{ $player->dorsal ?? '' }} {{ $player->surname }} {{ $player->name }}'; showResults = false"
                                            x-show="'{{ strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name) }}'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            @if($player->dorsal)
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">{{ $player->dorsal }}</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold">{{ $player->surname }}</span>
                                                <span class="text-gray-600">{{ $player->name }}</span>
                                            </div>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @error('goalPlayerId') 
                            <p class="text-red-500 text-xs mt-1">Debes seleccionar un jugador</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Minuto</label>
                            <input wire:model="goalMinute" type="number" min="1" max="180" placeholder="45" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                            <select wire:model="goalType" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="normal">Normal</option>
                                <option value="penalty">Penal</option>
                                <option value="own_goal">Propia</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button wire:click="$set('showGoalForm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl">
                            Cancelar
                        </button>
                        <button wire:click="addGoal" class="flex-1 py-2.5 bg-green-500 text-white font-semibold rounded-xl">
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Card Form Modal -->
    @if($showCardForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" wire:click="$set('showCardForm', false)">
            <div class="bg-white rounded-3xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto shadow-2xl" wire:click.stop>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Añadir Tarjeta</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Equipo</label>
                        <select wire:model.live="cardTeamId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option value="">Seleccionar equipo</option>
                            <option value="{{ $match->home_team_id }}">{{ $match->homeTeam?->displayName() }}</option>
                            <option value="{{ $match->away_team_id }}">{{ $match->awayTeam?->displayName() }}</option>
                        </select>
                    </div>
                    <div x-data="{ search: @entangle('cardPlayerSearch'), showResults: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jugador</label>
                        <div class="relative">
                            <input 
                                x-model="search"
                                @focus="showResults = true"
                                @click.away="showResults = false"
                                type="text" 
                                placeholder="Buscar por nombre, apellido o dorsal..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30"
                            >
                            <div x-show="showResults && search.length > 0" x-cloak class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto z-20">
                                @if($cardTeamId == $match->home_team_id)
                                    @foreach($homePlayers as $player)
                                        <button 
                                            type="button"
                                            @click="$wire.set('cardPlayerId', {{ $player->id }}); search = '#{{ $player->dorsal ?? '' }} {{ $player->surname }} {{ $player->name }}'; showResults = false"
                                            x-show="'{{ strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name) }}'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            @if($player->dorsal)
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">{{ $player->dorsal }}</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold">{{ $player->surname }}</span>
                                                <span class="text-gray-600">{{ $player->name }}</span>
                                            </div>
                                        </button>
                                    @endforeach
                                @elseif($cardTeamId == $match->away_team_id)
                                    @foreach($awayPlayers as $player)
                                        <button 
                                            type="button"
                                            @click="$wire.set('cardPlayerId', {{ $player->id }}); search = '#{{ $player->dorsal ?? '' }} {{ $player->surname }} {{ $player->name }}'; showResults = false"
                                            x-show="'{{ strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name) }}'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            @if($player->dorsal)
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">{{ $player->dorsal }}</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold">{{ $player->surname }}</span>
                                                <span class="text-gray-600">{{ $player->name }}</span>
                                            </div>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Minuto</label>
                            <input wire:model="cardMinute" type="number" min="1" max="180" placeholder="45" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                            <select wire:model="cardType" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="yellow">Amarilla</option>
                                <option value="red">Roja</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Motivo (opcional)</label>
                        <textarea wire:model="cardReason" rows="2" placeholder="Falta antideportiva..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 resize-none"></textarea>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button wire:click="$set('showCardForm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl">
                            Cancelar
                        </button>
                        <button wire:click="addCard" class="flex-1 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl">
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Player Details Modal -->
    @if($showPlayerDetails && $selectedPlayer)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" wire:click="closePlayerDetails">
            <div class="bg-white rounded-3xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl" wire:click.stop>
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-primary to-blue-600 px-6 py-4 flex items-center justify-between rounded-t-3xl">
                    <h3 class="text-lg font-bold text-white">Detalles del Jugador</h3>
                    <button wire:click="closePlayerDetails" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Player Photo -->
                    <div class="flex justify-center">
                        @if($selectedPlayer->photo)
                            <img src="{{ asset('storage/' . $selectedPlayer->photo) }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-lg" alt="Foto del jugador">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Player Info -->
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        @if($selectedPlayer->dorsal)
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-primary text-white font-bold text-lg flex items-center justify-center">
                                    {{ $selectedPlayer->dorsal }}
                                </div>
                                <span class="text-sm font-semibold text-gray-600">Dorsal</span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                            <p class="text-base font-semibold text-gray-900">{{ $selectedPlayer->name }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Apellidos</label>
                            <p class="text-base font-semibold text-gray-900">{{ $selectedPlayer->surname }}</p>
                        </div>

                        @if($selectedPlayer->dni)
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">{{ $selectedPlayer->doc_type ?? 'DNI' }}</label>
                                <p class="text-base font-semibold text-gray-900">{{ $selectedPlayer->dni }}</p>
                            </div>
                        @endif

                        @if($selectedPlayer->birthdate)
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha de Nacimiento</label>
                                <p class="text-base font-semibold text-gray-900">{{ $selectedPlayer->birthdate->format('d/m/Y') }}</p>
                            </div>
                        @endif

                        @if($selectedPlayer->position)
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Posición</label>
                                <p class="text-base font-semibold text-gray-900">{{ $selectedPlayer->position }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- DNI Images -->
                    @if($selectedPlayer->doc_front || $selectedPlayer->doc_back)
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Documentación</label>
                            <div class="space-y-3">
                                @if($selectedPlayer->doc_front)
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">DNI - Frontal</p>
                                        <img src="{{ asset('storage/' . $selectedPlayer->doc_front) }}" 
                                             class="w-full rounded-xl border border-gray-200 shadow-sm" 
                                             alt="DNI Frontal">
                                    </div>
                                @endif

                                @if($selectedPlayer->doc_back)
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">DNI - Reverso</p>
                                        <img src="{{ asset('storage/' . $selectedPlayer->doc_back) }}" 
                                             class="w-full rounded-xl border border-gray-200 shadow-sm" 
                                             alt="DNI Reverso">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 rounded-b-3xl">
                    <button wire:click="closePlayerDetails" 
                            class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
