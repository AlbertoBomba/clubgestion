<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-3 sm:px-4 lg:px-6 max-w-7xl mx-auto">

    {{-- Flash messages --}}
    @if (session('message'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ========================= HERO HEADER ========================= --}}
    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden mb-4">
        <div class="px-5 py-5 sm:px-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-4">
                    @if ($tournament->logo)
                        <img src="{{ Storage::url($tournament->logo) }}" class="w-14 h-14 rounded-xl object-cover border border-silver shadow-sm" alt="">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-black-deep">{{ $tournament->name }}</h1>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-sm text-titanium">
                            @if ($tournament->start_date)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $tournament->start_date->translatedFormat('d M Y') }}
                                    @if ($tournament->end_date) – {{ $tournament->end_date->translatedFormat('d M Y') }} @endif
                                </span>
                            @endif
                            @if ($tournament->location)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $tournament->location }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @php
                        $statusStyles = [
                            'draft' => 'bg-gray-100 text-gray-600',
                            'registration_open' => 'bg-blue-50 text-blue-700',
                            'in_progress' => 'bg-amber-50 text-amber-700',
                            'completed' => 'bg-green-50 text-green-700',
                            'cancelled' => 'bg-red-50 text-red-600',
                        ];
                        $statusLabels = [
                            'draft' => 'Borrador',
                            'registration_open' => 'Inscripciones',
                            'in_progress' => 'En curso',
                            'completed' => 'Finalizado',
                            'cancelled' => 'Cancelado',
                        ];
                    @endphp
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusStyles[$tournament->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $statusLabels[$tournament->status] ?? $tournament->status }}
                    </span>
                    <a href="{{ route('tournaments.edit', $tournament) }}"
                       class="p-2 rounded-xl text-titanium hover:text-primary hover:bg-primary/10 transition-colors"
                       title="Editar torneo">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= CATEGORY SELECTOR ========================= --}}
    <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-1 scrollbar-thin">
        @foreach ($categories as $cat)
            <button wire:click="selectCategory({{ $cat->id }})"
                    class="group relative whitespace-nowrap px-4 py-2 rounded-xl text-sm font-semibold transition-all
                        {{ $activeCategoryId === $cat->id
                            ? 'bg-primary text-white shadow-sm'
                            : 'bg-white-pure text-titanium border border-silver hover:border-primary/30 hover:text-primary' }}">
                {{ $cat->name ?? $cat->category?->category ?? 'Categoría' }}
                <span class="ml-1.5 text-xs opacity-70">{{ $cat->tournament_teams_count }}</span>
                @if ($activeCategoryId === $cat->id)
                    <span class="hidden group-hover:inline-flex items-center gap-0.5 ml-1">
                        <button wire:click.stop="openEditCategoryModal({{ $cat->id }})" class="p-0.5 rounded hover:bg-white/20" title="Editar">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button wire:click.stop="confirmDeleteCategory({{ $cat->id }})" class="p-0.5 rounded hover:bg-white/20" title="Eliminar">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </span>
                @endif
            </button>
        @endforeach
        <button wire:click="openCreateCategoryModal"
                class="whitespace-nowrap px-3 py-2 rounded-xl text-sm font-semibold text-primary border border-dashed border-primary/40 hover:bg-primary/5 transition-colors">
            + Nueva
        </button>
    </div>

    {{-- ========================= MAIN CONTENT ========================= --}}
    @if ($activeCategoryId)

        @if ($teams->isEmpty() && $matches->isEmpty())
            {{-- ==================== EMPTY STATE: NO TEAMS ==================== --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-8 sm:p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-black-deep mb-2">Añade los equipos participantes</h2>
                <p class="text-sm text-titanium mb-6 max-w-md mx-auto">El primer paso es añadir los equipos que van a competir en este torneo. Puedes elegir equipos de la escuela o añadir equipos externos.</p>
                <button wire:click="openCreateTeamModal"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold px-6 py-3 rounded-xl shadow transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Añadir Equipo
                </button>
            </div>

        @else
            {{-- ==================== TOOLBAR ==================== --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm px-4 py-3 mb-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    {{-- Summary --}}
                    <div class="flex items-center gap-3 text-sm">
                        <span class="inline-flex items-center gap-1.5 font-semibold text-black-deep">
                            <svg class="w-4 h-4 text-titanium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $teams->count() }} equipos
                        </span>
                        @if ($phases->isNotEmpty())
                            <span class="text-silver">·</span>
                            <span class="text-titanium">{{ $phases->first()?->typeLabel() }}</span>
                        @endif
                        @if ($matches->isNotEmpty())
                            <span class="text-silver">·</span>
                            <span class="text-titanium">
                                {{ $matches->where('status', 'completed')->count() }}/{{ $matches->count() }} jugados
                            </span>
                        @endif
                    </div>
                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <button wire:click="$toggle('showSetup')"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold px-3 py-1.5 rounded-lg transition-colors
                                    {{ $showSetup ? 'bg-primary/10 text-primary' : 'text-titanium hover:text-black-deep hover:bg-gray-100' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Configurar
                        </button>
                    </div>
                </div>
            </div>

            {{-- ==================== SETUP PANEL (collapsible) ==================== --}}
            @if ($showSetup)
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-5 mb-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Phases / Format --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-xs font-bold text-titanium uppercase tracking-wide">Fases del torneo</h3>
                                <button wire:click="openCreatePhaseModal" class="text-xs font-semibold text-primary hover:text-primary/80 transition-colors">+ Nueva fase</button>
                            </div>
                            @if ($phases->isEmpty())
                                <p class="text-sm text-titanium bg-gray-50 rounded-xl p-3 border border-silver">Crea una fase para definir el formato (liga, eliminatoria, grupos...)</p>
                            @else
                                <div class="space-y-1.5">
                                    @foreach ($phases as $phase)
                                        <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-xl border border-silver/50">
                                            <div class="flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-bold text-primary">{{ $phase->order }}</span>
                                                <span class="text-sm font-semibold text-black-deep">{{ $phase->name }}</span>
                                                <span class="text-xs text-titanium bg-gray-100 px-1.5 py-0.5 rounded">{{ $phase->typeLabel() }}</span>
                                            </div>
                                            <div class="flex items-center gap-0.5">
                                                <button wire:click="openEditPhaseModal({{ $phase->id }})" class="p-1.5 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button wire:click="confirmDeletePhase({{ $phase->id }})" class="p-1.5 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Teams --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-xs font-bold text-titanium uppercase tracking-wide">Equipos ({{ $teams->count() }})</h3>
                                <button wire:click="openCreateTeamModal" class="text-xs font-semibold text-primary hover:text-primary/80 transition-colors">+ Añadir equipo</button>
                            </div>
                            <div class="space-y-1.5 max-h-64 overflow-y-auto">
                                @foreach ($teams as $team)
                                    <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-xl border border-silver/50">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="text-sm font-semibold text-black-deep truncate">{{ $team->displayName() }}</span>
                                            @if ($team->group_label)
                                                <span class="text-xs text-titanium bg-gray-100 px-1.5 py-0.5 rounded shrink-0">Grupo {{ $team->group_label }}</span>
                                            @endif
                                            @if ($team->external_team)
                                                <span class="text-xs text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded shrink-0">Ext.</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-0.5 shrink-0">
                                            <button wire:click="openEditTeamModal({{ $team->id }})" class="p-1.5 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button wire:click="confirmDeleteTeam({{ $team->id }})" class="p-1.5 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex flex-wrap items-center gap-3 mt-5 pt-4 border-t border-silver">
                        <button wire:click="openGenerateMatchesModal"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            Generar Partidos
                        </button>
                        <button wire:click="openCreateMatchModal"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-titanium border border-silver px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                            + Partido manual
                        </button>
                        @if ($standings->isNotEmpty() || $matches->where('status', 'completed')->count() > 0)
                            <button wire:click="recalculateStandings"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-titanium border border-silver px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors ml-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Recalcular clasificación
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            @if ($matches->isEmpty() && $teams->isNotEmpty())
                {{-- ==================== EMPTY STATE: TEAMS BUT NO MATCHES ==================== --}}
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-black-deep mb-2">¡Genera los partidos!</h2>
                    <p class="text-sm text-titanium mb-6 max-w-md mx-auto">
                        Ya tienes {{ $teams->count() }} equipos listos.
                        @if ($phases->isEmpty())
                            Crea una fase para definir el formato y luego genera los partidos automáticamente.
                        @else
                            Genera los enfrentamientos automáticamente con un clic.
                        @endif
                    </p>
                    @if ($phases->isEmpty())
                        <button wire:click="openCreatePhaseModal"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold px-6 py-3 rounded-xl shadow transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Crear Fase
                        </button>
                    @else
                        <button wire:click="openGenerateMatchesModal"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-6 py-3 rounded-xl shadow transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Generar Partidos
                        </button>
                    @endif
                </div>
            @endif

            @if ($matches->isNotEmpty())
                {{-- ==================== MATCHES SECTION ==================== --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-base font-bold text-black-deep flex items-center gap-2">
                            <svg class="w-5 h-5 text-titanium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Partidos
                        </h2>
                    </div>

                    <div class="space-y-4">
                        @foreach ($matches->sortBy([['round', 'asc'], ['match_number', 'asc'], ['scheduled_at', 'asc']])->groupBy(fn($m) => $m->round ?? 0) as $round => $roundMatches)
                            @php
                                $roundLabel     = $round > 0 ? 'Jornada ' . $round : 'Sin jornada';
                                $completedCount = $roundMatches->where('status', 'completed')->count();
                                $totalCount     = $roundMatches->count();
                                $datesInRound   = $roundMatches->filter(fn($m) => $m->scheduled_at)->sortBy('scheduled_at');
                                $firstDate      = $datesInRound->first()?->scheduled_at;
                                $lastDate       = $datesInRound->last()?->scheduled_at;
                                if ($firstDate && $lastDate) {
                                    $sameDay = $firstDate->isSameDay($lastDate);
                                    $roundSubLabel = $sameDay
                                        ? $firstDate->translatedFormat('d \d\e F Y')
                                        : $firstDate->translatedFormat('d M') . ' – ' . $lastDate->translatedFormat('d M Y');
                                } else {
                                    $roundSubLabel = null;
                                }
                                $allCompleted = $completedCount === $totalCount;
                            @endphp
                            <div>
                                {{-- Jornada header --}}
                                <div class="flex items-center gap-3 mb-2 px-1">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $allCompleted ? 'bg-green-100 text-green-700' : 'bg-primary/10 text-primary' }} text-xs font-bold">
                                            {{ $round > 0 ? $round : '—' }}
                                        </span>
                                        <div>
                                            <p class="text-sm font-bold text-black-deep">{{ $roundLabel }}</p>
                                            @if ($roundSubLabel)
                                                <p class="text-xs text-titanium">{{ $roundSubLabel }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 h-px bg-silver"></div>
                                    <span class="text-xs font-medium {{ $allCompleted ? 'text-green-600' : 'text-titanium' }}">
                                        {{ $completedCount }}/{{ $totalCount }}
                                    </span>
                                </div>

                                {{-- Match cards --}}
                                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm divide-y divide-silver overflow-hidden">
                                    @foreach ($roundMatches as $match)
                                        <div class="px-4 py-3 hover:bg-gray-50/50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                {{-- Date/time --}}
                                                <div class="hidden sm:flex flex-col items-center shrink-0 w-14 text-center">
                                                    @if ($match->scheduled_at)
                                                        <span class="text-xs font-semibold text-titanium">{{ $match->scheduled_at->format('d/m') }}</span>
                                                        <span class="text-xs text-titanium/60">{{ $match->scheduled_at->format('H:i') }}</span>
                                                    @else
                                                        <span class="text-xs text-titanium/40">—</span>
                                                    @endif
                                                </div>

                                                {{-- Home team --}}
                                                <div class="flex-1 text-right">
                                                    <span class="text-sm font-semibold text-black-deep">{{ $match->homeTeam?->displayName() ?? '—' }}</span>
                                                </div>

                                                {{-- Score (inline editable) --}}
                                                @if ($editingScoreId === $match->id)
                                                    <div class="flex items-center gap-1.5 shrink-0" wire:keydown.enter="saveQuickScore" wire:keydown.escape="cancelEditScore">
                                                        <input wire:model="quick_home_score" type="number" min="0"
                                                               class="w-12 h-9 text-center text-sm font-bold border border-primary/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 bg-primary/5"
                                                               autofocus />
                                                        <span class="text-xs text-titanium font-bold">–</span>
                                                        <input wire:model="quick_away_score" type="number" min="0"
                                                               class="w-12 h-9 text-center text-sm font-bold border border-primary/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 bg-primary/5" />
                                                        <button wire:click="saveQuickScore"
                                                                class="p-1.5 rounded-lg bg-green-500 text-white hover:bg-green-600 transition-colors" title="Guardar">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        </button>
                                                        <button wire:click="cancelEditScore"
                                                                class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors" title="Cancelar">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div wire:click="startEditScore({{ $match->id }})"
                                                         class="shrink-0 cursor-pointer px-3 py-1 rounded-lg hover:bg-primary/5 transition-colors min-w-[60px] text-center"
                                                         title="Clic para introducir resultado">
                                                        @if ($match->status === 'completed')
                                                            <span class="text-base font-bold text-black-deep">{{ $match->home_score }} – {{ $match->away_score }}</span>
                                                        @else
                                                            <span class="text-sm font-bold text-titanium/40">vs</span>
                                                        @endif
                                                    </div>
                                                @endif

                                                {{-- Away team --}}
                                                <div class="flex-1 text-left">
                                                    <span class="text-sm font-semibold text-black-deep">{{ $match->awayTeam?->displayName() ?? '—' }}</span>
                                                </div>

                                                {{-- Status & actions --}}
                                                <div class="shrink-0 flex items-center gap-1">
                                                    @if ($match->status === 'completed')
                                                        <span class="w-2 h-2 rounded-full bg-green-500" title="Jugado"></span>
                                                    @elseif ($match->status === 'in_progress')
                                                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse" title="En curso"></span>
                                                    @elseif ($match->status === 'cancelled')
                                                        <span class="w-2 h-2 rounded-full bg-red-500" title="Cancelado"></span>
                                                    @else
                                                        <span class="w-2 h-2 rounded-full bg-gray-300" title="Programado"></span>
                                                    @endif
                                                    <button wire:click="openEditMatchModal({{ $match->id }})"
                                                            class="p-1 rounded-lg text-titanium/40 hover:text-primary hover:bg-primary/10 transition-colors" title="Editar detalles">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ==================== STANDINGS SECTION ==================== --}}
                @if ($standings->isNotEmpty())
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-base font-bold text-black-deep flex items-center gap-2">
                                <svg class="w-5 h-5 text-titanium" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Clasificación
                            </h2>
                            <button wire:click="recalculateStandings"
                                    class="text-xs font-semibold text-primary hover:text-primary/80 transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Recalcular
                            </button>
                        </div>

                        @foreach ($standings->groupBy(fn($s) => $s->phase?->name ?? 'General') as $phaseName => $phaseStandings)
                            @foreach ($phaseStandings->groupBy('group_label') as $groupLabel => $groupStandings)
                                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden mb-4">
                                    <div class="bg-gray-50/70 border-b border-silver px-5 py-2.5">
                                        <h3 class="text-xs font-semibold text-titanium uppercase tracking-wide">
                                            {{ $phaseName }} @if($groupLabel) – Grupo {{ $groupLabel }} @endif
                                        </h3>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead>
                                                <tr class="border-b border-silver">
                                                    <th class="text-left text-xs font-semibold text-titanium px-4 py-2 w-8">#</th>
                                                    <th class="text-left text-xs font-semibold text-titanium px-4 py-2">Equipo</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">PJ</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">G</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">E</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">P</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">GF</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">GC</th>
                                                    <th class="text-center text-xs font-semibold text-titanium px-2 py-2">DG</th>
                                                    <th class="text-center text-xs font-bold text-primary px-4 py-2">Pts</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-silver/50">
                                                @foreach ($groupStandings as $standing)
                                                    <tr class="{{ $loop->first ? 'bg-primary/5' : '' }}">
                                                        <td class="px-4 py-2.5 text-xs font-bold {{ $loop->first ? 'text-primary' : 'text-titanium' }}">{{ $standing->position }}</td>
                                                        <td class="px-4 py-2.5 font-semibold text-black-deep">{{ $standing->tournamentTeam?->displayName() ?? '—' }}</td>
                                                        <td class="px-2 py-2.5 text-center text-titanium">{{ $standing->played }}</td>
                                                        <td class="px-2 py-2.5 text-center text-green-700 font-semibold">{{ $standing->won }}</td>
                                                        <td class="px-2 py-2.5 text-center text-titanium">{{ $standing->drawn }}</td>
                                                        <td class="px-2 py-2.5 text-center text-red-600 font-semibold">{{ $standing->lost }}</td>
                                                        <td class="px-2 py-2.5 text-center text-titanium">{{ $standing->goals_for }}</td>
                                                        <td class="px-2 py-2.5 text-center text-titanium">{{ $standing->goals_against }}</td>
                                                        <td class="px-2 py-2.5 text-center text-titanium">
                                                            {{ ($standing->goals_for - $standing->goals_against) >= 0 ? '+' : '' }}{{ $standing->goals_for - $standing->goals_against }}
                                                        </td>
                                                        <td class="px-4 py-2.5 text-center font-bold text-primary text-base">{{ $standing->points }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @endif
            @endif
        @endif

    @else
        {{-- No category selected --}}
        @if ($categories->isEmpty())
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-8 sm:p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h2 class="text-lg font-bold text-black-deep mb-2">Crea una categoría para empezar</h2>
                <p class="text-sm text-titanium mb-6 max-w-md mx-auto">Las categorías agrupan equipos por edad o nivel (ej: Alevín, Infantil, Cadete). Crea al menos una para organizar tu torneo.</p>
                <button wire:click="openCreateCategoryModal"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold px-6 py-3 rounded-xl shadow transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nueva Categoría
                </button>
            </div>
        @endif
    @endif

    {{-- ======================= MODALS ======================= --}}

    {{-- Generate matches modal --}}
    @if ($showGenerateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Generar Partidos
                    </h3>
                    <button wire:click="$set('showGenerateModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fase *</label>
                        <select wire:model="generate_phase_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-500">
                            <option value="">— Selecciona una fase —</option>
                            @foreach ($phases as $phase)
                                <option value="{{ $phase->id }}">{{ $phase->name }} ({{ $phase->typeLabel() }})</option>
                            @endforeach
                        </select>
                        @error('generate_phase_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Vueltas</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 px-4 py-2.5 border rounded-xl cursor-pointer transition-colors
                                {{ $generate_legs == 1 ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-silver text-titanium hover:border-indigo-300' }}">
                                <input type="radio" wire:model="generate_legs" value="1" class="text-indigo-600"/>
                                <span class="text-sm font-semibold">1 vuelta</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2.5 border rounded-xl cursor-pointer transition-colors
                                {{ $generate_legs == 2 ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-silver text-titanium hover:border-indigo-300' }}">
                                <input type="radio" wire:model="generate_legs" value="2" class="text-indigo-600"/>
                                <span class="text-sm font-semibold">2 vueltas</span>
                            </label>
                        </div>
                    </div>
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-amber-200 bg-amber-50 cursor-pointer">
                        <input type="checkbox" wire:model="generate_clear" class="mt-0.5 text-amber-600"/>
                        <span class="text-xs text-amber-800">
                            <strong>Borrar partidos existentes</strong> de esta fase antes de generar los nuevos.
                        </span>
                    </label>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('showGenerateModal', false)"
                            class="px-4 py-2 text-sm font-semibold text-titanium border border-silver rounded-xl hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="generateMatches"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Generar
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Phase modal --}}
    @if ($showPhaseModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep">{{ $editingPhaseId ? 'Editar Fase' : 'Nueva Fase' }}</h3>
                    <button wire:click="$set('showPhaseModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre *</label>
                        <input wire:model="phase_name" type="text" placeholder="Ej: Fase de grupos"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        @error('phase_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Tipo *</label>
                            <select wire:model.live="phase_type"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="league">Liga</option>
                                <option value="group">Grupos</option>
                                <option value="knockout">Eliminatoria</option>
                                <option value="swiss">Sistema Suizo</option>
                                <option value="double_elimination">Doble Eliminación</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Orden *</label>
                            <input wire:model="phase_order" type="number" min="1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center font-bold"/>
                        </div>
                    </div>
                    {{-- Dynamic phase type description --}}
                    @php
                        $phaseDescriptions = [
                            'league'             => ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'color' => 'blue', 'title' => 'Liga', 'text' => 'Todos los equipos se enfrentan entre sí. Se puntúan victorias, empates y derrotas. Ideal para competiciones donde todos se miden entre sí.'],
                            'group'              => ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5m-5-2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'violet', 'title' => 'Fase de Grupos', 'text' => 'Los equipos se dividen en grupos donde juegan todos contra todos. Los primeros de cada grupo pasan a la siguiente ronda.'],
                            'knockout'           => ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'red', 'title' => 'Eliminatoria', 'text' => 'Eliminación directa: el perdedor queda fuera. Se resuelve por rondas hasta la final.'],
                            'swiss'              => ['icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 'color' => 'amber', 'title' => 'Sistema Suizo', 'text' => 'Sin eliminación. Cada ronda enfrenta a equipos con resultados similares. Permite clasificar con pocas rondas.'],
                            'double_elimination' => ['icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'color' => 'green', 'title' => 'Doble Eliminación', 'text' => 'Un equipo solo queda eliminado tras perder dos veces. Cuadro de ganadores y de perdedores.'],
                        ];
                        $desc = $phaseDescriptions[$phase_type] ?? $phaseDescriptions['league'];
                        $colorMap = ['blue' => 'bg-blue-50 border-blue-200 text-blue-800', 'violet' => 'bg-violet-50 border-violet-200 text-violet-800', 'red' => 'bg-red-50 border-red-200 text-red-800', 'amber' => 'bg-amber-50 border-amber-200 text-amber-800', 'green' => 'bg-green-50 border-green-200 text-green-800'];
                        $iconColor = ['blue' => 'text-blue-500', 'violet' => 'text-violet-500', 'red' => 'text-red-500', 'amber' => 'text-amber-500', 'green' => 'text-green-500'];
                    @endphp
                    <div class="flex gap-3 p-3 rounded-xl border {{ $colorMap[$desc['color']] }}">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 {{ $iconColor[$desc['color']] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $desc['icon'] }}"/>
                        </svg>
                        <div>
                            <p class="text-xs font-bold mb-0.5">{{ $desc['title'] }}</p>
                            <p class="text-xs leading-relaxed">{{ $desc['text'] }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                        <select wire:model="phase_status"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="pending">Pendiente</option>
                            <option value="in_progress">En curso</option>
                            <option value="completed">Completada</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showPhaseModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="savePhase"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        {{ $editingPhaseId ? 'Guardar cambios' : 'Crear Fase' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Team modal --}}
    @if ($showTeamModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep">{{ $editingTeamId ? 'Editar Equipo' : 'Añadir Equipo' }}</h3>
                    <button wire:click="$set('showTeamModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-silver">
                        <label class="text-sm font-medium text-black-deep">Equipo externo</label>
                        <button wire:click="$set('external_team', {{ $external_team ? 'false' : 'true' }})"
                                class="relative inline-flex items-center w-10 h-6 rounded-full transition-colors {{ $external_team ? 'bg-primary' : 'bg-silver' }}">
                            <span class="inline-block w-4 h-4 bg-white rounded-full shadow transition-transform {{ $external_team ? 'translate-x-5' : 'translate-x-1' }}"></span>
                        </button>
                    </div>
                    @if ($external_team)
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre del equipo *</label>
                            <input wire:model="name_override" type="text" placeholder="Nombre del equipo externo"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                            @error('name_override') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    @else
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo de la escuela</label>
                            <select wire:model="team_id"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">Seleccionar equipo...</option>
                                @foreach ($schoolTeams as $st)
                                    <option value="{{ $st->id }}">{{ $st->team }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre personalizado (opcional)</label>
                            <input wire:model="name_override" type="text" placeholder="Dejar vacío para usar nombre del equipo"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Cabeza de serie</label>
                            <input wire:model="team_seed" type="number" min="1" placeholder="0"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Grupo</label>
                            <input wire:model="team_group" type="text" placeholder="A, B, C..."
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center uppercase"/>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showTeamModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveTeam"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        {{ $editingTeamId ? 'Guardar cambios' : 'Añadir Equipo' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Match modal --}}
    @if ($showMatchModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-lg p-6 my-4">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep">{{ $editingMatchId ? 'Editar Partido' : 'Nuevo Partido' }}</h3>
                    <button wire:click="$set('showMatchModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fase</label>
                        <select wire:model="match_phase_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="">Sin fase</option>
                            @foreach ($phases as $phase)
                                <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo local *</label>
                            <select wire:model="match_home_id"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">Seleccionar...</option>
                                @foreach ($teams as $t)
                                    <option value="{{ $t->id }}">{{ $t->displayName() }}</option>
                                @endforeach
                            </select>
                            @error('match_home_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo visitante *</label>
                            <select wire:model="match_away_id"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">Seleccionar...</option>
                                @foreach ($teams as $t)
                                    <option value="{{ $t->id }}">{{ $t->displayName() }}</option>
                                @endforeach
                            </select>
                            @error('match_away_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Jornada / Ronda</label>
                            <input wire:model="match_round" type="text" placeholder="Ej: 1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nº Partido</label>
                            <input wire:model="match_number" type="number" min="1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fecha y hora</label>
                            <input wire:model="match_scheduled" type="datetime-local"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Ubicación</label>
                            <input wire:model="match_location" type="text"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                        <select wire:model="match_status"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="scheduled">Programado</option>
                            <option value="in_progress">En curso</option>
                            <option value="completed">Completado</option>
                            <option value="cancelled">Cancelado</option>
                            <option value="postponed">Aplazado</option>
                        </select>
                    </div>
                    @if ($match_status === 'completed' || $match_status === 'in_progress')
                        <div class="border-t border-silver pt-4">
                            <p class="text-xs font-semibold text-titanium uppercase tracking-wide mb-3">Resultado</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-titanium mb-1.5">Local</label>
                                    <input wire:model="home_score" type="number" min="0" placeholder="0"
                                           class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center font-bold text-lg"/>
                                </div>
                                <div>
                                    <label class="block text-xs text-titanium mb-1.5">Visitante</label>
                                    <input wire:model="away_score" type="number" min="0" placeholder="0"
                                           class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center font-bold text-lg"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label class="block text-xs text-titanium mb-1.5">Local (prórroga)</label>
                                    <input wire:model="home_score_extra" type="number" min="0"
                                           class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                                </div>
                                <div>
                                    <label class="block text-xs text-titanium mb-1.5">Visitante (prórroga)</label>
                                    <input wire:model="away_score_extra" type="number" min="0"
                                           class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-titanium mb-1.5">Ganador en penaltis</label>
                                <select wire:model="penalty_winner"
                                        class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                    <option value="">Sin penaltis</option>
                                    <option value="home">Local</option>
                                    <option value="away">Visitante</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Notas</label>
                        <textarea wire:model="match_notes" rows="2"
                                  class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showMatchModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveMatch"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        {{ $editingMatchId ? 'Guardar cambios' : 'Crear Partido' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete confirm modals --}}
    @if ($confirmingPhaseDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar fase?</h3>
                <p class="text-sm text-titanium text-center mb-6">Se eliminarán también todos los partidos y clasificaciones de esta fase.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingPhaseDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deletePhase"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

    @if ($confirmingTeamDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar equipo?</h3>
                <p class="text-sm text-titanium text-center mb-6">El equipo será eliminado del torneo.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingTeamDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deleteTeam"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

    @if ($confirmingMatchDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar partido?</h3>
                <p class="text-sm text-titanium text-center mb-6">Esta acción no se puede deshacer.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingMatchDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deleteMatch"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Category modal --}}
    @if ($showCategoryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep">
                        {{ $editingCategoryId ? 'Editar Categoría' : 'Nueva Categoría' }}
                    </h3>
                    <button wire:click="$set('showCategoryModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Categoría de la escuela</label>
                        <select wire:model="cat_category_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="">Sin categoría (personalizada)</option>
                            @foreach ($schoolCategories as $sc)
                                <option value="{{ $sc->id }}">{{ $sc->category }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-titanium mt-1">Vincular a una categoría filtrará los equipos por edad.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre personalizado (opcional)</label>
                        <input wire:model="cat_name" type="text" placeholder="Ej: Alevín Verano 2026"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        @error('cat_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Orden</label>
                            <input wire:model="cat_order" type="number" min="1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center font-bold"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                            <select wire:model="cat_status"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="active">Activa</option>
                                <option value="completed">Finalizada</option>
                                <option value="cancelled">Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showCategoryModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveCategory"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        {{ $editingCategoryId ? 'Guardar cambios' : 'Crear Categoría' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Category delete confirm --}}
    @if ($confirmingCategoryDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar categoría?</h3>
                <p class="text-sm text-titanium text-center mb-6">Se eliminarán <strong>todos</strong> los equipos, fases, partidos y clasificaciones de esta categoría.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingCategoryDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deleteCategory"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar categoría</button>
                </div>
            </div>
        </div>
    @endif
</div>