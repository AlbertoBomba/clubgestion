<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-3 sm:px-4 lg:px-6">
        <div class="max-w-7xl mx-auto">

            {{-- HEADER --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-5">
                <div class="px-5 py-4 flex items-start justify-between gap-3">
                    <div>
                        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2 font-medium flex-wrap">
                            <a href="{{ route('tournaments.index') }}" class="hover:text-primary transition-colors">Torneos</a>
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <a href="{{ route('tournaments.show', $tournament) }}" class="hover:text-primary transition-colors truncate max-w-[140px]">{{ $tournament->name }}</a>
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-gray-800">{{ $tournamentTeam->displayName() }}</span>
                        </nav>
                        <h1 class="text-xl font-bold text-gray-900">Jugadores</h1>
                    </div>
                </div>
            </div>

            @if (session('message'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                     class="mb-5 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
                    <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
                </div>
            @endif

            {{-- Main card --}}
            <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">

                {{-- Sticky top bar --}}
                <div class="sticky top-16 z-10 bg-white-pure flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-xl text-titanium leading-tight">
                        <span>{{ $players->count() }}</span>
                        <span class="text-titanium"> {{ $players->count() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}</span>
                    </h2>
                    <div class="flex gap-3">
                        <button wire:click="exportExcel"
                                class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-0.5 bg-green-600 hover:bg-green-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Descargar Excel
                        </button>
                        <a href="{{ route('tournament.team.player.create', [$tournament, $tournamentTeam]) }}"
                           class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-0.5 bg-primary hover:bg-primary/90">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nuevo jugador
                        </a>
                    </div>
                </div>

                {{-- Filters --}}
                <div class="p-5 border-b border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <div class="relative">
                            <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar jugador..."
                                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                        </div>
                        <div class="relative">
                            <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0M9 12h.01M15 12h.01M9 15h6"/></svg>
                            <input wire:model.live.debounce.300ms="dniFilter" type="text" placeholder="Buscar por DNI..."
                                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                        </div>
                        <div>
                            <select wire:model.live="statusFilter"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                <option value="">Todos los estados</option>
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select wire:model.live="positionFilter"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                <option value="">Todas las posiciones</option>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos }}">{{ $pos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select wire:model.live="docsFilter"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                <option value="">Filtrar por documentos</option>
                                <option value="complete">Documentación completa</option>
                                <option value="missing_photo">Sin foto selfie</option>
                                <option value="missing_doc_front">Sin DNI cara A</option>
                                <option value="missing_doc_back">Sin DNI cara B</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                @if ($players->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="w-14 h-14 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p class="text-sm font-semibold text-gray-400">No hay jugadores</p>
                        <p class="text-xs text-gray-300 mt-1">Añade el primer jugador con el botón de arriba.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-silver/30">
                            <thead class="bg-gradient-to-r from-gray-50 to-primary/5 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Jugador</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider hidden sm:table-cell">Dorsal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider hidden md:table-cell">Edad</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider hidden md:table-cell">DNI / Tipo</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider hidden lg:table-cell">Documentos</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white-pure divide-y divide-silver/30">
                                @foreach ($players as $player)
                                    <tr class="hover:bg-primary/5 transition-colors" id="player-{{ $player->id }}">
                                        {{-- Jugador --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($player->photo)
                                                    <img src="{{ Storage::url($player->photo) }}"
                                                         class="w-11 h-11 rounded-full object-cover border-2 border-primary/20 shrink-0" alt="">
                                                @else
                                                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-primary to-night-blue flex items-center justify-center shrink-0">
                                                        <span class="text-white font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname ?? '', 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-semibold text-black-deep">{{ $player->fullName() }}</p>
                                                    @if ($player->position)
                                                        <p class="text-xs text-gray-400">{{ $player->position }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Dorsal --}}
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-xs font-bold text-primary">
                                                {{ $player->dorsal ?? '-' }}
                                            </span>
                                        </td>
                                        {{-- Edad --}}
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            @if ($player->birthdate)
                                                <div class="text-sm font-medium text-gray-700">{{ $player->birthdate->age }} años</div>
                                                <div class="text-xs text-gray-400">{{ $player->birthdate->format('d/m/Y') }}</div>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        {{-- DNI --}}
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <div class="text-sm text-gray-700">{{ $player->dni ?: '-' }}</div>
                                            @if ($player->doc_type)
                                                <div class="text-xs text-gray-400">{{ $docTypes[$player->doc_type] ?? $player->doc_type }}</div>
                                            @endif
                                        </td>
                                        {{-- Documentos --}}
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            <div class="flex items-center gap-2">
                                                {{-- Foto selfie --}}
                                                <span title="{{ $player->photo ? 'Foto selfie subida' : 'Foto selfie pendiente' }}"
                                                      class="w-7 h-7 rounded-lg flex items-center justify-center border
                                                          {{ $player->photo ? 'bg-emerald-50 border-emerald-100 text-emerald-500' : 'bg-gray-50 border-gray-100 text-gray-300' }}">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </span>
                                                {{-- DNI cara A --}}
                                                <span title="{{ $player->doc_front ? 'DNI cara A subida' : 'DNI cara A pendiente' }}"
                                                      class="w-7 h-7 rounded-lg flex items-center justify-center border relative
                                                          {{ $player->doc_front ? 'bg-emerald-50 border-emerald-100 text-emerald-500' : 'bg-gray-50 border-gray-100 text-gray-300' }}">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0M9 12h.01M15 12h.01M9 15h6"/></svg>
                                                    <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full text-[8px] font-black flex items-center justify-center leading-none
                                                        {{ $player->doc_front ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-400' }}">A</span>
                                                </span>
                                                {{-- DNI cara B --}}
                                                <span title="{{ $player->doc_back ? 'DNI cara B subida' : 'DNI cara B pendiente' }}"
                                                      class="w-7 h-7 rounded-lg flex items-center justify-center border relative
                                                          {{ $player->doc_back ? 'bg-emerald-50 border-emerald-100 text-emerald-500' : 'bg-gray-50 border-gray-100 text-gray-300' }}">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0M9 12h.01M15 12h.01M9 15h6"/></svg>
                                                    <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full text-[8px] font-black flex items-center justify-center leading-none
                                                        {{ $player->doc_back ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-400' }}">B</span>
                                                </span>
                                            </div>
                                        </td>
                                        {{-- Estado --}}
                                        <td class="px-6 py-4">
                                            <select wire:change="setStatus({{ $player->id }}, $event.target.value)"
                                                    class="text-xs font-semibold rounded-full px-3 py-1.5 border-0 ring-1 focus:outline-none focus:ring-2 cursor-pointer
                                                        {{ $player->status === 'approved' ? 'bg-neon-green/10 text-neon-green ring-neon-green/20' :
                                                          ($player->status === 'rejected'  ? 'bg-red-100 text-red-600 ring-red-200' :
                                                                                             'bg-amber-50 text-amber-600 ring-amber-200') }}">
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}" {{ $player->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        {{-- Acciones --}}
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('tournament.team.player.edit', [$tournament, $tournamentTeam, $player]) }}"
                                                   class="p-2 rounded-xl text-gray-400 hover:text-primary hover:bg-primary/10 transition-colors"
                                                   title="Editar jugador">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <button wire:click="confirmDelete({{ $player->id }})"
                                                        class="p-2 rounded-xl text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                                        title="Eliminar jugador">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>{{-- /main card --}}

        </div>
    </div>

    {{-- Delete confirm modal --}}
    @if ($confirmingDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-black text-gray-900 text-center mb-2">Eliminar jugador</h3>
                <p class="text-sm text-gray-500 text-center mb-6">Esta acción eliminará también todas las imágenes del jugador y no puede deshacerse.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingDeletion', false)"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="deletePlayer" wire:loading.attr="disabled"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition-colors disabled:opacity-60">
                        <span wire:loading.remove wire:target="deletePlayer">Eliminar</span>
                        <span wire:loading wire:target="deletePlayer">Eliminando...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>