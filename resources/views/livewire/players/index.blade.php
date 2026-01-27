<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <div class="sticky top-16 z-10 bg-white-pure flex items-center justify-between p-6 border-b border-gray-100">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            <span class="">{{ $players->total() }}</span> 
                    <span class="text-titanium">{{ $players->total() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}</span>
            {{-- {{ __('Jugadores') }} --}}
        </h2>
        <div class="flex gap-3">
            @if(count($selectedPlayers) > 0)
                <button wire:click="confirmTeamChange" 
                    class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-green-600 hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Cambiar de  Equipo ({{ count($selectedPlayers) }} jugadores)
                </button>
                @if($this->hasActivePlayers)
                    <button wire:click="confirmDeactivation" 
                        class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-orange-600 hover:bg-orange-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Desactivar ({{ count($selectedPlayers) }} jugadores)
                    </button>
                @endif
                @if($this->hasInactivePlayers)
                    <button wire:click="confirmActivation" 
                        class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-green-600 hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Activar ({{ count($selectedPlayers) }} jugadores)
                    </button>
                @endif
            @endif
            <button wire:click="exportExcel" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-green-600 hover:bg-green-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Descargar Excel
            </button>
            <a href="{{ route('players.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Jugador
            </a>
        </div>
    </div>

    <div class=" bg-white-pure rounded-b-2xl shadow-xl border border-primary/10 overflow-hidden">
        <div class="p-6 border-b border-gray-100 ">
            <div class="flex items-center justify-between mb-4">
                {{-- <div class="text-sm text-gray-600">
                    <span class="font-semibold text-primary text-lg">{{ $players->total() }}</span> 
                    <span class="text-titanium">{{ $players->total() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}</span>
                </div> --}}
                {{-- @if($activeSeason)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $activeSeason->sseason }} en curso
                    </span>
                @endif --}}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Buscar jugadores..." 
                        class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                    </div>
                    <input wire:model.live="dniFilter" type="text" placeholder="Buscar por DNI..." 
                        class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                    </div>
                    <input wire:model.live="matriculaFilter" type="text" placeholder="Buscar por matrícula..." 
                        class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
                </div>
                <div>
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
                    <select wire:model.live="teamFilter" 
                        class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="">Todos los equipos</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->team }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="withoutTeam" class="w-4 h-4 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <span class="ml-2 text-sm font-semibold text-titanium">Solo sin equipo</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto max-h-[calc(100vh-400px)] overflow-y-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                            <input type="checkbox" 
                                @change="$event.target.checked ? $wire.set('selectedPlayers', {{ $players->pluck('id')->toJson() }}) : $wire.set('selectedPlayers', [])"
                                :checked="{{ count($selectedPlayers) === $players->count() && $players->count() > 0 ? 'true' : 'false' }}"
                                class="w-4 h-4 text-primary border-silver rounded focus:ring-2 focus:ring-primary cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Foto</th>
                        <th wire:click="sortBy('surname')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Jugador
                                @if($sortField === 'surname')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider" title="Cartas de pago generadas">
                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">DNI</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Edad</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tutor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Contacto</th>
                        <th wire:click="sortBy('active')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Estado
                                @if($sortField === 'active')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($players as $player)
                        <tr class="{{ !$player->active ? 'bg-gray-200 hover:bg-gray-300' : ($player->teams->count() === 0 ? 'bg-red-900/10 hover:bg-red-900/20' : 'hover:bg-primary/5') }} {{ $highlightPlayer == $player->id ? 'bg-green-50 border-l-4 border-green-500 animate-pulse' : '' }}" 
                            id="player-{{ $player->id }}">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                    wire:model.live="selectedPlayers" 
                                    value="{{ $player->id }}"
                                    class="w-4 h-4 text-primary border-silver rounded focus:ring-2 focus:ring-primary cursor-pointer">
                            </td>
                            <td class="px-6 py-4">
                                @if($player->player_photo)
                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->full_name }}" class="w-12 h-12 rounded-full object-cover border-2 border-primary/20">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-night-blue flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-black-deep">{!! $this->highlightText($player->full_name) !!}</div>
                                @if($player->email)
                                    <div class="text-xs text-gray-500">{!! $this->highlightText($player->email) !!}</div>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-center">
                                {{-- {{$player->payment_players_count}} --}}
                                @if($player->payment_players_count > 0)
                                    <div class="inline-flex items-center" title="{{ $player->payment_players_count }} carta(s) de pago">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                    </div>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->dni)
                                    <div class="text-sm text-gray-700">{!! $this->highlightText($player->dni) !!}</div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->dbirth)
                                    <div class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($player->dbirth)->age }} años</div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->seasons->count() > 0)
                                    @foreach($player->seasons as $season)
                                        <span class="inline-block px-2 py-1 bg-primary/10 text-primary rounded-lg text-xs font-semibold mb-1 mr-1">{{ $season->season }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->teams->count() > 0)
                                    @foreach($player->teams as $team)
                                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-semibold mb-1 mr-1">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ $team->team }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Sin equipo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->nametutor)
                                    <div class="text-sm font-medium text-black-deep">{!! $this->highlightText($player->nametutor) !!}</div>
                                    @if($player->dnitutor)
                                        <div class="text-xs text-gray-500">{!! $this->highlightText($player->dnitutor) !!}</div>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    @if($player->phone1)
                                        <div>{{ $player->phone1 }}</div>
                                    @endif
                                    @if($player->phone2)
                                        <div class="text-xs text-gray-500">{{ $player->phone2 }}</div>
                                    @endif
                                    @if(!$player->phone1 && !$player->phone2)
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($player->active)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-neon-green/10 text-neon-green border border-neon-green/20">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-300">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('players.edit', $player->id) }}" 
                                        wire:click="saveFilters"
                                        class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    @php
                                        $canDelete = $this->canDeletePlayer($player->id);
                                        $hasTeam = $player->teams()->exists();
                                        $hasPayments = \App\Models\PaymentPlayer::where('player_id', $player->id)->exists();
                                        $tooltipMessage = '';
                                        if (!$canDelete) {
                                            if ($hasTeam && $hasPayments) {
                                                $tooltipMessage = 'No se puede eliminar: el jugador tiene equipo asignado y pagos generados';
                                            } elseif ($hasTeam) {
                                                $tooltipMessage = 'No se puede eliminar: el jugador tiene equipo asignado';
                                            } elseif ($hasPayments) {
                                                $tooltipMessage = 'No se puede eliminar: el jugador tiene pagos generados';
                                            }
                                        }
                                    @endphp
                                    <div class="relative group">
                                        <button wire:click="confirmDelete({{ $player->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="confirmDelete"
                                            @if(!$canDelete) disabled @endif
                                            class="inline-flex items-center px-3 py-2 text-white rounded-lg transition-colors duration-200 text-xs font-semibold disabled:opacity-50 disabled:cursor-not-allowed
                                                {{ $canDelete ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-400' }}">
                                            <svg wire:loading.remove wire:target="confirmDelete" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <svg wire:loading wire:target="confirmDelete" class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                        @if(!$canDelete)
                                            <div class="absolute bottom-full right-0 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                                                {{ $tooltipMessage }}
                                                <div class="absolute top-full right-3 -mt-1">
                                                    <div class="border-4 border-transparent border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11" class="px-6 py-12 text-center text-gray-400">No se encontraron jugadores</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($players->hasPages())
            <div class="px-6 py-4 border-t border-silver/30 text-gray-600">{{ $players->links() }}</div>
        @endif
    </div>

    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Jugador</x-slot>
        <x-slot name="content">
            @if($playerToDeleteModel)
                ¿Estás seguro de que deseas eliminar al jugador <strong>{{ $playerToDeleteModel->full_name }}</strong>? Esta acción también eliminará su foto.
            @else
                ¿Estás seguro de que deseas eliminar este jugador? Esta acción también eliminará su foto.
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deletePlayer" wire:loading.attr="disabled" wire:target="deletePlayer">
                <span wire:loading.remove wire:target="deletePlayer">Eliminar</span>
                <span wire:loading wire:target="deletePlayer" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Eliminando...
                </span>
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal de Previsualización para Desactivar -->
    <x-dialog-modal wire:model="showDeactivatePreview" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Previsualización: Desactivar Jugadores</span>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <!-- Resumen de acciones -->
                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-orange-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="space-y-1 text-sm">
                            <p class="text-orange-900 font-semibold">Al desactivar {{ count($deactivatePreviewData) }} jugador(es), se realizarán las siguientes acciones:</p>
                            <ul class="list-disc list-inside text-orange-800 space-y-1">
                                <li>Se eliminarán todas las cartas de pago pendientes</li>
                                <li>Se quitarán de todos los equipos asignados</li>
                                <li>Se marcará el jugador como inactivo</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Lista de jugadores con detalles -->
                <div class="max-h-96 overflow-y-auto space-y-3">
                    @foreach($deactivatePreviewData as $playerData)
                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                            <!-- Encabezado del jugador -->
                            <div class="flex items-center gap-3 mb-3">
                                @if($playerData['photo'])
                                    <img src="{{ asset('storage/' . $playerData['photo']) }}" alt="{{ $playerData['name'] }}" class="w-12 h-12 rounded-full object-cover border-2 border-orange-200">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold">{{ substr($playerData['name'], 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">{{ $playerData['name'] }}</div>
                                    <div class="text-xs text-gray-500">DNI: {{ $playerData['dni'] ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <!-- Equipos a remover -->
                            @if(count($playerData['teams']) > 0)
                                <div class="mb-2">
                                    <div class="text-xs font-semibold text-gray-700 mb-1">🏆 Equipos a remover:</div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($playerData['teams'] as $team)
                                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ $team }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Pagos a eliminar -->
                            @if(count($playerData['payments']) > 0)
                                <div>
                                    <div class="text-xs font-semibold text-gray-700 mb-1">🗑️ Cartas de pago a eliminar ({{ count($playerData['payments']) }}):</div>
                                    <div class="space-y-1">
                                        @foreach($playerData['payments'] as $payment)
                                            <div class="flex items-center justify-between p-2 bg-red-50 rounded text-xs border border-red-100">
                                                <div>
                                                    <span class="font-medium">Cuota {{ $payment['cuota'] }}</span> • {{ $payment['description'] }}
                                                    <div class="text-gray-500 font-mono text-xs">{{ $payment['code'] }}</div>
                                                </div>
                                                <span class="font-bold text-red-600">{{ number_format($payment['amount'], 2) }}€</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-xs text-gray-500 italic">Sin cartas de pago pendientes</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showDeactivatePreview', false)">Cancelar</x-secondary-button>
            <button wire:click="deactivatePlayers" wire:loading.attr="disabled" wire:target="deactivatePlayers"
                class="ml-3 inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                <span wire:loading.remove wire:target="deactivatePlayers">Desactivar</span>
                <span wire:loading wire:target="deactivatePlayers" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Desactivando...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal de Previsualización para Activar -->
    <x-dialog-modal wire:model="showActivatePreview" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Previsualización: Activar Jugadores</span>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <!-- Resumen de acciones -->
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="space-y-1 text-sm">
                            <p class="text-green-900 font-semibold">Al activar {{ count($activatePreviewData) }} jugador(es), se realizarán las siguientes acciones:</p>
                            <ul class="list-disc list-inside text-green-800 space-y-1">
                                <li>Se marcará el jugador como activo</li>
                                <li>Se asignará al equipo seleccionado</li>
                                <li>Se generarán las cartas de pago correspondientes</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Selector de equipo -->
                <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        🏆 Selecciona el equipo para asignar a los jugadores:
                    </label>
                    <select wire:model="teamForActivation" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">-- Selecciona un equipo --</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->team }} ({{ $team->season->season }})</option>
                        @endforeach
                    </select>
                    @if(empty($teamForActivation))
                        <p class="text-xs text-gray-600 mt-2">⚠️ Debes seleccionar un equipo para continuar</p>
                    @endif
                </div>

                <!-- Lista de jugadores -->
                <div class="max-h-64 overflow-y-auto space-y-2">
                    @foreach($activatePreviewData as $playerData)
                        <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200">
                            @if($playerData['photo'])
                                <img src="{{ asset('storage/' . $playerData['photo']) }}" alt="{{ $playerData['name'] }}" class="w-10 h-10 rounded-full object-cover border-2 border-green-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">{{ substr($playerData['name'], 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-900">{{ $playerData['name'] }}</div>
                                <div class="text-xs text-gray-500">DNI: {{ $playerData['dni'] ?? 'N/A' }}</div>
                            </div>
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showActivatePreview', false)">Cancelar</x-secondary-button>
            <button wire:click="activatePlayers" wire:loading.attr="disabled" wire:target="activatePlayers"
                :disabled="!$wire.teamForActivation"
                class="ml-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                <span wire:loading.remove wire:target="activatePlayers">Activar</span>
                <span wire:loading wire:target="activatePlayers" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Activando...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="confirmingTeamChange">
        <x-slot name="title">Cambiar Equipo</x-slot>
        <x-slot name="content">
            <p class="mb-4">Selecciona el equipo al que deseas traspasar los siguientes jugadores:</p>
            <div class="bg-gray-50 rounded-lg p-4 max-h-64 overflow-y-auto mb-4">
                <ul class="space-y-2">
                    @foreach($selectedPlayersModels as $player)
                        <li class="flex items-center gap-3 p-2 bg-white rounded-lg border border-gray-200">
                            @if($player->player_photo)
                                <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->full_name }}" class="w-10 h-10 rounded-full object-cover border-2 border-primary/20">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-night-blue flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-xs">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-900">{{ $player->full_name }}</div>
                                @if($player->teams->count() > 0)
                                    <div class="text-xs text-gray-500">Equipo actual: {{ $player->teams->first()->team }}</div>
                                @else
                                    <div class="text-xs text-red-500">Sin equipo</div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4">
                <label for="newTeam" class="block text-sm font-semibold text-gray-700 mb-2">Equipo destino</label>
                <select wire:model="newTeamId" id="newTeam" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Selecciona un equipo</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->team }}</option>
                    @endforeach
                </select>
                @error('newTeamId')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <p class="mt-4 text-sm text-gray-600">Total: <strong>{{ count($selectedPlayers) }}</strong> jugador(es)</p>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingTeamChange', false)">Cancelar</x-secondary-button>
            <button wire:click="changeTeam" wire:loading.attr="disabled" wire:target="changeTeam"
                class="ml-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                <span wire:loading.remove wire:target="changeTeam">Cambiar Equipo</span>
                <span wire:loading wire:target="changeTeam" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Cambiando...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal de Previsualización de Pagos -->
    <x-dialog-modal wire:model="showPreviewModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span>Previsualización de Cambios en Pagos</span>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <!-- Resumen compacto -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="space-y-2 text-sm">
                            @if(count($paymentsPaid) > 0)
                                <p class="text-green-700">✅ <strong>{{ count($paymentsPaid) }}</strong> pagos ya pagados se mantendrán</p>
                            @endif
                            @if(count($paymentsToDelete) > 0)
                                <p class="text-red-700">🗑️ <strong>{{ count($paymentsToDelete) }}</strong> pagos pendientes se eliminarán</p>
                            @endif
                            @if(count($paymentsToCreate) > 0)
                                <p class="text-blue-700">➕ <strong>{{ count($paymentsToCreate) }}</strong> nuevas cartas de pago se generarán</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Grid de dos columnas -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Columna izquierda: Pagos a eliminar -->
                    <div class="border border-red-200 rounded-lg bg-white">
                        <div class="bg-red-50 px-3 py-2 border-b border-red-200">
                            <h4 class="text-sm font-semibold text-red-900">
                                🗑️ A Eliminar ({{ count($paymentsToDelete) }})
                            </h4>
                        </div>
                        <div class="p-3 space-y-2">
                            @forelse($paymentsToDelete as $payment)
                                <div class="flex flex-col gap-1 p-2 bg-red-50 rounded text-xs border border-red-100">
                                    <div class="flex items-center justify-between">
                                        <div class="font-semibold text-gray-900">{{ $payment['player_name'] }}</div>
                                        <span class="font-bold text-red-600">{{ number_format($payment['amount'], 2) }}€</span>
                                    </div>
                                    <div class="text-gray-600">
                                        <span class="font-medium">Cuota {{ $payment['cuota'] }}</span> • {{ $payment['description'] }}
                                    </div>
                                    <div class="text-gray-500 font-mono text-xs">
                                        Código: {{ $payment['code'] }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-xs">
                                    No hay pagos pendientes a eliminar
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Columna derecha: Nuevas cartas de pago -->
                    <div class="border border-green-200 rounded-lg bg-white">
                        <div class="bg-green-50 px-3 py-2 border-b border-green-200">
                            <h4 class="text-sm font-semibold text-green-900">
                                ➕ Nuevas Cartas de Pago ({{ count($paymentsToCreate) }})
                            </h4>
                        </div>
                        <div class="p-3 space-y-2">
                            @forelse($paymentsToCreate as $payment)
                                <div class="flex flex-col gap-1 p-2 bg-green-50 rounded text-xs border border-green-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <div class="flex items-center justify-between flex-1">
                                            <div class="font-semibold text-gray-900">{{ $payment['player_name'] }}</div>
                                            <span class="font-bold text-green-600 flex-shrink-0 ml-2">
                                                @if($payment['amount'] != $payment['amount_original'])
                                                    <span class="text-gray-400 line-through text-xs mr-1">{{ number_format($payment['amount_original'], 2) }}€</span>
                                                @endif
                                                {{ number_format($payment['amount'], 2) }}€
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-gray-600 ml-7">
                                        <span class="font-medium">Cuota {{ $payment['cuota'] }}</span> • {{ $payment['description'] }}
                                    </div>
                                    <div class="text-gray-500 ml-7 text-xs">
                                        🏆 Equipo: {{ $payment['team_name'] ?? 'N/A' }}
                                    </div>
                                    @if(isset($payment['is_restore']) && $payment['is_restore'])
                                        <div class="ml-7 text-blue-600 text-xs">
                                            🔄 Se restaurará pago existente
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-xs">
                                    No hay nuevas cartas de pago a generar
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Pagos pagados que se mantienen (compacto) -->
                @if(count($paymentsPaid) > 0)
                    <div class="border border-green-300 rounded-lg bg-green-50">
                        <button type="button" 
                                onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('span').textContent = this.nextElementSibling.classList.contains('hidden') ? 'Ver detalles' : 'Ocultar'"
                                class="w-full px-3 py-2 flex items-center justify-between hover:bg-green-100 transition-colors">
                            <h4 class="text-sm font-semibold text-green-900">
                                ✅ Pagos Ya Pagados - Se Mantienen ({{ count($paymentsPaid) }})
                            </h4>
                            <span class="text-xs text-green-700 hover:text-green-900 underline">
                                Ver detalles
                            </span>
                        </button>
                        <div class="hidden px-3 pb-3 space-y-1 border-t border-green-200">
                            @foreach($paymentsPaid as $payment)
                                <div class="flex items-center justify-between text-xs bg-white p-2 rounded">
                                    <div>
                                        <span class="font-semibold">{{ $payment['player_name'] }}</span>
                                        <span class="text-gray-600">- Cuota {{ $payment['cuota'] }}</span>
                                    </div>
                                    <span class="text-green-700">{{ number_format($payment['amount'], 2) }}€</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex items-center justify-between w-full gap-3">
                <x-secondary-button wire:click="$set('showPreviewModal', false)">
                    Cancelar
                </x-secondary-button>
                <button wire:click="confirmPaymentsAction" wire:loading.attr="disabled" wire:target="confirmPaymentsAction"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span wire:loading.remove wire:target="confirmPaymentsAction">
                        Confirmar Cambios
                    </span>
                    <span wire:loading wire:target="confirmPaymentsAction" class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Procesando...
                    </span>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    @if($highlightPlayer)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const highlightedRow = document.getElementById('player-{{ $highlightPlayer }}');
            if (highlightedRow) {
                // Scroll to the highlighted player
                highlightedRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Remove highlight after 3 seconds
                setTimeout(() => {
                    @this.set('highlightPlayer', null);
                }, 3000);
            }
        });
    </script>
    @endif

    <script>
        // Limpiar overflow del body cuando se cierra el modal
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                // Remover overflow-hidden y paddingRight del body
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
                
                // También limpiar en el html si existe
                document.documentElement.style.overflow = '';
                document.documentElement.classList.remove('overflow-hidden');
                
                // Forzar un reflow completo
                setTimeout(() => {
                    // Asegurar que todos los estilos inline se eliminen
                    document.body.removeAttribute('style');
                    document.body.classList.remove('overflow-hidden', 'overflow-y-hidden');
                    
                    // Restaurar scroll
                    window.scrollTo(window.scrollX, window.scrollY);
                }, 150);
            });
        });
    </script>

</div>
