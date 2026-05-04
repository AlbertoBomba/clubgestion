<div>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-3 sm:px-4 lg:px-6">
        <div class="max-w-5xl mx-auto">

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
                        <p class="text-sm text-gray-400 mt-0.5">{{ $players->count() }} jugador{{ $players->count() !== 1 ? 'es' : '' }}</p>
                    </div>
                    <a href="{{ route('tournament.team.player.create', [$tournament, $tournamentTeam]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-white rounded-xl shadow transition-opacity hover:opacity-90 bg-primary shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nuevo jugador
                    </a>
                </div>
            </div>

            @if (session('message'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium">
                    {{ session('message') }}
                </div>
            @endif

            {{-- Toolbar --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4 mb-5 flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nombre o DNI..."
                           class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                </div>
                <select wire:model.live="statusFilter"
                        class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                    <option value="">Todos los estados</option>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Players table --}}
            @if ($players->isEmpty())
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-12 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-sm font-semibold text-gray-400">No hay jugadores</p>
                    <p class="text-xs text-gray-300 mt-1">Añade el primer jugador con el botón de arriba.</p>
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Jugador</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Dorsal</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">DNI / Tipo</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($players as $player)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                @if ($player->photo)
                                                    <img src="{{ Storage::url($player->photo) }}"
                                                         class="w-9 h-9 rounded-lg object-cover border border-gray-200 shrink-0" alt="">
                                                @else
                                                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ $player->fullName() }}</p>
                                                    @if ($player->birthdate)
                                                        <p class="text-xs text-gray-400">{{ $player->birthdate->format('d/m/Y') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 hidden sm:table-cell">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-xs font-bold text-gray-600">
                                                {{ $player->dorsal ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell">
                                            <div>
                                                <p class="text-gray-700">{{ $player->dni ?: '-' }}</p>
                                                @if ($player->doc_type)
                                                    <p class="text-xs text-gray-400">{{ $docTypes[$player->doc_type] ?? $player->doc_type }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <select wire:change="setStatus({{ $player->id }}, $event.target.value)"
                                                    class="text-xs font-semibold rounded-lg px-2 py-1 border-0 ring-1 focus:outline-none focus:ring-2 cursor-pointer
                                                        {{ $player->status === 'approved' ? 'bg-green-50 text-green-700 ring-green-200' :
                                                          ($player->status === 'rejected'  ? 'bg-red-50 text-red-700 ring-red-200' :
                                                                                             'bg-amber-50 text-amber-700 ring-amber-200') }}">
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}" {{ $player->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('tournament.team.player.edit', [$tournament, $tournamentTeam, $player]) }}"
                                                   class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <button wire:click="confirmDelete({{ $player->id }})"
                                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

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