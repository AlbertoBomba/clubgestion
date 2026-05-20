<div>
    {{-- Flash message --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="mb-4 flex items-center gap-3 bg-neon-green/10 border border-neon-green/30 text-neon-green rounded-xl px-4 py-3 text-sm font-medium shadow">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- Header + Filters --}}
    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-4 mb-5">

        {{-- Title row --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-black-deep">Torneos</h1>
                <p class="text-sm text-titanium mt-0.5">Crea y gestiona torneos, ligas y competiciones.</p>
            </div>
            <a href="{{ route('tournaments.create') }}" wire:navigate
               class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-semibold px-5 py-3 sm:py-2.5 rounded-xl shadow transition-colors duration-200 text-sm w-full sm:w-auto">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Torneo
            </a>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-titanium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nombre o ubicación..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
            </div>
            <select wire:model.live="statusFilter"
                    class="w-full sm:w-auto sm:min-w-[220px] text-sm border border-silver rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                <option value="">Todos los estados</option>
                <option value="draft">Borrador</option>
                <option value="registration_open">Inscripción abierta</option>
                <option value="in_progress">En curso</option>
                <option value="completed">Completado</option>
                <option value="cancelled">Cancelado</option>
            </select>
        </div>
    </div>

    {{-- Tournament cards --}}
    @if ($tournaments->isEmpty())
        <div class="text-center py-16 sm:py-20 bg-white-pure border border-silver rounded-2xl shadow-sm px-4">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-black-deep mb-1">No hay torneos todavía</h3>
            <p class="text-sm text-titanium mb-2 max-w-md mx-auto">Los torneos te permiten organizar competiciones entre los equipos de tu escuela y equipos externos.</p>
            <p class="text-xs text-titanium mb-6 max-w-sm mx-auto">Crea tu primer torneo con nombre, formato (liga, eliminatoria, grupos...) y genera los partidos automáticamente.</p>
            <a href="{{ route('tournaments.create') }}" wire:navigate
               class="inline-flex items-center gap-2 bg-primary text-white text-sm font-semibold px-5 py-3 rounded-xl shadow hover:bg-primary/90 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Crear mi primer torneo
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
            @foreach ($tournaments as $tournament)
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col overflow-hidden">

                    {{-- Card header --}}
                    <div class="flex items-start justify-between p-4 sm:p-5 pb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @if ($tournament->logo)
                                <img src="{{ Storage::url($tournament->logo) }}" alt="{{ $tournament->name }}"
                                     class="w-12 h-12 rounded-xl object-cover border border-silver shrink-0"/>
                            @else
                                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h3 class="font-semibold text-black-deep text-base leading-tight line-clamp-2">{{ $tournament->name }}</h3>
                                @if ($tournament->location)
                                    <p class="text-xs text-titanium mt-0.5 truncate flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        {{ $tournament->location }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <span class="shrink-0 ml-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $tournament->statusColor() }}">
                            {{ $tournament->statusLabel() }}
                        </span>
                    </div>

                    {{-- Description snippet --}}
                    @if ($tournament->description)
                        <div class="px-4 sm:px-5 pb-2">
                            <p class="text-xs text-titanium line-clamp-2">{{ $tournament->description }}</p>
                        </div>
                    @endif

                    {{-- Stats row --}}
                    <div class="px-4 sm:px-5 pb-3 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-titanium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $tournament->tournament_teams_count }} equipos
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            {{ $tournament->phases_count }} {{ $tournament->phases_count === 1 ? 'fase' : 'fases' }}
                        </span>
                        @if ($tournament->start_date)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $tournament->start_date->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>

                    {{-- Progress bar for in-progress tournaments --}}
                    @if ($tournament->status === 'in_progress' && $tournament->matches_count > 0)
                        @php $pct = round(($tournament->completed_matches_count / $tournament->matches_count) * 100); @endphp
                        <div class="px-4 sm:px-5 pb-3">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-titanium">Progreso</span>
                                <span class="font-semibold text-primary">{{ $pct }}%</span>
                            </div>
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="mt-auto border-t border-silver flex items-stretch bg-gray-50/50">
                        <a href="{{ route('tournaments.show', $tournament) }}" wire:navigate
                           class="flex-1 flex items-center justify-center gap-2 py-3 text-sm font-semibold text-primary hover:bg-primary/5 transition-colors">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Configurar Torneo
                        </a>
                        <div class="w-px bg-silver"></div>
                        {{-- <a href="{{ route('tournaments.edit', $tournament) }}" wire:navigate
                           class="flex items-center justify-center px-4 py-3 text-titanium hover:text-primary hover:bg-primary/5 transition-colors" title="Editar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a> --}}
                        <div class="w-px bg-silver"></div>
                        <button wire:click="confirmDelete({{ $tournament->id }})"
                                class="flex items-center justify-center px-4 py-3 text-titanium hover:text-red-500 hover:bg-red-50 transition-colors" title="Eliminar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5">
            {{ $tournaments->links() }}
        </div>
    @endif

    {{-- Delete confirmation modal --}}
    @if ($confirmingDeletion)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-t-2xl sm:rounded-2xl shadow-2xl border border-silver w-full sm:max-w-sm p-6" x-data>
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-50 mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-black-deep text-center mb-2">¿Eliminar torneo?</h3>
                <p class="text-sm text-titanium text-center mb-6">Esta acción no se puede deshacer. Se eliminarán también todas las categorías, fases, equipos, partidos y clasificaciones de este torneo.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingDeletion', false)"
                            class="flex-1 py-3 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="deleteTournament"
                            class="flex-1 py-3 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
