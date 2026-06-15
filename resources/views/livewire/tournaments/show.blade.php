<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ tab: '{{ $phases->isNotEmpty() ? 'matches' : 'setup' }}' }">

    {{-- Flash messages (toast, fixed top-right) --}}
    @if (session('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-[60] max-w-sm bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="fixed top-4 right-4 z-[60] max-w-sm bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-medium shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif


    {{-- ================================================================ WRAPPER --}}
    <div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-6">

        {{-- ========================= HERO HEADER ========================= --}}
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm mb-5 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-primary via-primary/60 to-primary/20"></div>
            <div class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    {{-- Logo --}}
                    @if ($tournament->logo)
                        <img src="{{ Storage::url($tournament->logo) }}"
                             class="w-16 h-16 rounded-2xl object-cover border border-silver shadow-sm shrink-0" alt="">
                    @else
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/5 border border-primary/20 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    @endif
                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <h1 class="text-2xl font-bold text-black-deep leading-tight">{{ $tournament->name }}</h1>
                            @php
                                $statusStyles = [
                                    'draft'             => 'bg-gray-100 text-gray-600',
                                    'registration_open' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'in_progress'       => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'completed'         => 'bg-green-50 text-green-700 border border-green-200',
                                    'cancelled'         => 'bg-red-50 text-red-600 border border-red-200',
                                ];
                                $statusLabels = [
                                    'draft'             => 'Borrador',
                                    'registration_open' => 'Inscripciones abiertas',
                                    'in_progress'       => 'En curso',
                                    'completed'         => 'Finalizado',
                                    'cancelled'         => 'Cancelado',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusStyles[$tournament->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $statusLabels[$tournament->status] ?? $tournament->status }}
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-sm text-titanium">
                            @if ($tournament->start_date)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $tournament->start_date->translatedFormat('d M Y') }}
                                    @if ($tournament->end_date) – {{ $tournament->end_date->translatedFormat('d M Y') }} @endif
                                </span>
                            @endif
                            @if ($tournament->location)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $tournament->location }}
                                </span>
                            @endif
                            @if ($teams->isNotEmpty())
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $teams->count() }} equipos
                                </span>
                            @endif
                            @if ($matches->isNotEmpty())
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    {{ $matches->where('status', 'completed')->count() }} / {{ $matches->count() }} partidos jugados
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Header actions --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('tournaments.edit', $tournament) }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary/5 text-primary border border-primary/20 text-sm font-semibold hover:bg-primary/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span class="hidden sm:inline">Editar torneo</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================= CATEGORY SELECTOR ========================= --}}
        @if ($tournament->team_type === 'open')
            <div class="flex items-center gap-2 mb-4 p-3 bg-blue-50 rounded-xl border border-blue-100">
                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs text-blue-700 font-medium">Torneo abierto: las categorías no aplican. Los equipos se gestionan por edad mínima{{ $tournament->min_age ? ' (' . $tournament->min_age . ' años)' : '' }}.</p>
            </div>
        @else
            @if ($categories->isNotEmpty())
                <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-1">
                    @foreach ($categories as $cat)
                        <div class="relative group shrink-0">
                            <button wire:click="selectCategory({{ $cat->id }})"
                                    class="whitespace-nowrap pl-4 pr-3 py-2 rounded-xl text-sm font-semibold transition-all
                                        {{ $activeCategoryId === $cat->id
                                            ? 'bg-primary text-white shadow-sm'
                                            : 'bg-white-pure text-titanium border border-silver hover:border-primary/30 hover:text-primary' }}">
                                {{ $cat->name ?? $cat->category?->category ?? 'Categoría' }}
                                <span class="ml-1.5 text-xs opacity-60">{{ $cat->tournament_teams_count }}</span>
                            </button>
                            @if ($activeCategoryId === $cat->id)
                                <div class="absolute -top-1.5 -right-1.5 hidden group-hover:flex items-center gap-0.5 z-10">
                                    <button wire:click.stop="openEditCategoryModal({{ $cat->id }})"
                                            class="w-5 h-5 rounded-full bg-white border border-silver shadow text-titanium hover:text-primary flex items-center justify-center" title="Editar categoría">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click.stop="confirmDeleteCategory({{ $cat->id }})"
                                            class="w-5 h-5 rounded-full bg-white border border-silver shadow text-titanium hover:text-red-500 flex items-center justify-center" title="Eliminar categoría">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <button wire:click="openCreateCategoryModal"
                            class="shrink-0 whitespace-nowrap px-3 py-2 rounded-xl text-sm font-semibold text-primary border border-dashed border-primary/40 hover:bg-primary/5 transition-colors">
                        + Nueva
                    </button>
                </div>
            @endif
        @endif

        {{-- ========================= MAIN CONTENT ========================= --}}
        @if ($activeCategoryId || $tournament->team_type === 'open')

            @if ($teams->isEmpty() && $matches->isEmpty())
                {{-- EMPTY STATE: NO TEAMS --}}
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                    <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-black-deep mb-2">Añade los equipos participantes</h2>
                    <p class="text-sm text-titanium mb-7 max-w-md mx-auto">El primer paso es añadir los equipos que van a competir. Puedes elegir equipos de la escuela o añadir equipos externos.</p>
                    <button wire:click="openCreateTeamModal"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold px-7 py-3 rounded-xl shadow transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Añadir Primer Equipo
                    </button>
                </div>

            @else
                {{-- ========================= TABS NAV ========================= --}}
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm mb-5 p-1.5">
                    <nav class="flex gap-1 overflow-x-auto">
                        @if ($phases->isNotEmpty())
                            <button @click="tab = 'teams'"
                                    :class="tab === 'teams' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Equipos
                                <span :class="tab === 'teams' ? 'bg-white/20 text-white' : 'bg-gray-100 text-titanium'"
                                      class="px-2 py-0.5 rounded-full text-xs font-bold">{{ $teams->count() }}</span>
                            </button>
                            <button @click="tab = 'matches'"
                                    :class="tab === 'matches' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Partidos
                                @if ($matches->isNotEmpty())
                                    <span :class="tab === 'matches' ? 'bg-white/20 text-white' : 'bg-gray-100 text-titanium'"
                                          class="px-2 py-0.5 rounded-full text-xs font-bold">{{ $matches->count() }}</span>
                                @endif
                            </button>
                            @if ($standings->isNotEmpty() || ($hasLeaguePhase && $teams->isNotEmpty()))
                                <button @click="tab = 'standings'"
                                        :class="tab === 'standings' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Clasificación
                                </button>
                            @endif
                            <button @click="tab = 'stats'"
                                    :class="tab === 'stats' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Estadísticas
                            </button>
                            <button @click="tab = 'referees'"
                                    :class="tab === 'referees' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Árbitros
                                <span :class="tab === 'referees' ? 'bg-white/20 text-white' : 'bg-gray-100 text-titanium'"
                                      class="px-2 py-0.5 rounded-full text-xs font-bold">{{ $assignedReferees->count() }}</span>
                            </button>
                        @endif
                        <button @click="tab = 'setup'"
                                :class="tab === 'setup' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all ml-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Configurar
                        </button>
                    </nav>
                </div>

                {{-- ========================= TAB: PARTIDOS ========================= --}}
                <div x-show="tab === 'matches'" x-cloak>
                    @if ($matches->isEmpty())
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-black-deep mb-2">Aún no hay partidos</h3>
                            <p class="text-sm text-titanium mb-5">Genera los encuentros automáticamente o añade uno manualmente.</p>
                            <div class="flex items-center justify-center gap-3 flex-wrap">
                                <button wire:click="openGenerateMatchesModal"
                                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    Generar automáticamente
                                </button>
                                <button wire:click="openCreateMatchModal"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-titanium border border-silver px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Añadir manual
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- Counter + add button --}}
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm text-titanium">
                                <span class="font-bold text-black-deep">{{ $matches->where('status', 'completed')->count() }}</span>
                                de
                                <span class="font-bold text-black-deep">{{ $matches->count() }}</span>
                                partidos jugados
                            </p>
                            <div class="flex items-center gap-2">
                                <button wire:click="openGenerateMatchesModal"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    <span class="hidden sm:inline">Generar</span>
                                </button>
                                <button wire:click="openCreateMatchModal"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-primary border border-primary/30 px-4 py-2 rounded-xl hover:bg-primary/5 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span class="hidden sm:inline">Añadir manual</span>
                                </button>
                            </div>
                        </div>

                        {{-- Rounds --}}
                        <div class="space-y-6">
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
                                    {{-- Round header --}}
                                    <div class="flex items-center gap-3 mb-3 px-1">
                                        <div class="w-10 h-10 rounded-xl shrink-0 flex items-center justify-center text-sm font-black
                                            {{ $allCompleted ? 'bg-green-100 text-green-700' : 'bg-primary/10 text-primary' }}">
                                            {{ $round > 0 ? $round : '—' }}
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-black-deep leading-tight">{{ $roundLabel }}</p>
                                            @if ($roundSubLabel)
                                                <p class="text-xs text-titanium mt-0.5">{{ $roundSubLabel }}</p>
                                            @endif
                                        </div>
                                        <div class="flex-1 h-px bg-silver mx-1"></div>
                                        @if ($allCompleted)
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full shrink-0">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Completada
                                            </span>
                                        @else
                                            <span class="text-sm font-semibold text-titanium shrink-0">{{ $completedCount }}/{{ $totalCount }}</span>
                                        @endif
                                    </div>

                                    {{-- Match rows --}}
                                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                        @foreach ($roundMatches as $match)
                                            <div class="px-5 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/60 transition-colors">
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                                    {{-- Fixture --}}
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        {{-- Date/time block --}}
                                                        <div class="hidden sm:flex flex-col items-center justify-center shrink-0 w-16 h-14 bg-gray-50 rounded-xl border border-silver/60 text-center">
                                                            @if ($match->scheduled_at)
                                                                <span class="text-xs font-bold text-black-deep">{{ $match->scheduled_at->format('d/m') }}</span>
                                                                <span class="text-xs text-titanium">{{ $match->scheduled_at->format('H:i') }}</span>
                                                            @else
                                                                <span class="text-xs text-titanium/40 font-semibold">—</span>
                                                            @endif
                                                        </div>
                                                        {{-- Teams + score --}}
                                                        <div class="flex items-center gap-3 flex-1 min-w-0">
                                                            <div class="flex-1 text-right min-w-0">
                                                                <p class="text-sm font-bold text-black-deep truncate">{{ $match->homeTeam?->displayName() ?? '—' }}</p>
                                                            </div>
                                                            {{-- Score / Goals button --}}
                                                            <button wire:click="openGoalsModal({{ $match->id }})"
                                                                    class="shrink-0 min-w-[76px] px-3 py-2.5 rounded-xl text-center transition-all font-black text-base
                                                                        {{ $match->status === 'completed'
                                                                            ? 'bg-gray-50 border border-silver text-black-deep hover:bg-amber-50 hover:border-amber-200'
                                                                            : 'bg-amber-50 border-2 border-dashed border-amber-300 text-amber-600 hover:bg-amber-100 hover:border-amber-400' }}"
                                                                    title="Registrar goles / ver resultado">
                                                                @if ($match->status === 'completed')
                                                                    {{ $match->home_score }} – {{ $match->away_score }}
                                                                @elseif ($match->status === 'cancelled')
                                                                    <span class="text-xs font-bold text-red-400">CANC.</span>
                                                                @elseif ($match->status === 'postponed')
                                                                    <span class="text-xs font-bold text-gray-400">APL.</span>
                                                                @else
                                                                    <span class="text-xs font-bold">⚽ Goles</span>
                                                                @endif
                                                            </button>
                                                            <div class="flex-1 text-left min-w-0">
                                                                <p class="text-sm font-bold text-black-deep truncate">{{ $match->awayTeam?->displayName() ?? '—' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Status + Actions --}}
                                                    <div class="flex items-center gap-2 shrink-0">
                                                        {{-- Status badge --}}
                                                        @if ($match->status === 'completed')
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full shrink-0">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                                Jugado
                                                            </span>
                                                        @elseif ($match->status === 'in_progress')
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full animate-pulse shrink-0">En curso</span>
                                                        @elseif ($match->status === 'cancelled')
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full shrink-0">Cancelado</span>
                                                        @elseif ($match->status === 'postponed')
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full shrink-0">Aplazado</span>
                                                        @else
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-titanium bg-gray-50 border border-silver px-2.5 py-1 rounded-full shrink-0">Programado</span>
                                                        @endif
                                                        {{-- Action: Eventos --}}
                                                        <a href="{{ route('tournament.match.events', [$tournament, $match]) }}" wire:navigate
                                                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition-colors"
                                                           title="Tarjetas y sanciones">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                            <span class="hidden lg:inline">Eventos</span>
                                                        </a>
                                                        {{-- Action: Editar --}}
                                                        <button wire:click="openEditMatchModal({{ $match->id }})"
                                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-primary/5 text-primary border border-primary/20 hover:bg-primary/10 transition-colors"
                                                                title="Editar fecha, lugar, estado">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                            <span class="hidden lg:inline">Editar</span>
                                                        </button>
                                                        {{-- Action: Eliminar --}}
                                                        <button wire:click="confirmDeleteMatch({{ $match->id }})"
                                                                class="p-2 rounded-xl text-titanium/40 hover:text-red-500 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                                                                title="Eliminar partido">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- Mobile date --}}
                                                @if ($match->scheduled_at)
                                                    <p class="sm:hidden text-xs text-titanium mt-2 pl-1">
                                                        {{ $match->scheduled_at->translatedFormat('d/m/Y · H:i') }}
                                                        @if ($match->location) · {{ $match->location }} @endif
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                        {{-- Bye rows: teams not playing this round --}}
                                        @if ($round > 0 && $teams->isNotEmpty())
                                            @php
                                                $busyIds      = $roundMatches->flatMap(fn($m) => [$m->home_team_id, $m->away_team_id])->unique();
                                                $restingTeams = $teams->whereNotIn('id', $busyIds);
                                            @endphp
                                            @foreach ($restingTeams as $restingTeam)
                                                <div class="px-5 py-4 border-t-2 border-dashed border-amber-200 bg-amber-50/60 flex items-center gap-4">
                                                    <div class="w-9 h-9 rounded-xl bg-amber-100 border border-amber-200 flex items-center justify-center shrink-0">
                                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm font-bold text-amber-900">{{ $restingTeam->displayName() }}</span>
                                                    <span class="text-[11px] font-black uppercase tracking-wider text-amber-700 bg-amber-100 border border-amber-200 px-3 py-1 rounded-full">Descansa esta jornada</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- ========================= TAB: CLASIFICACIÓN ========================= --}}
                @if ($standings->isNotEmpty() || ($hasLeaguePhase && $teams->isNotEmpty()))
                    <div x-show="tab === 'standings'" x-cloak>
                        <div class="flex items-center justify-end mb-4">
                            <button wire:click="recalculateStandings"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-titanium border border-silver px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Recalcular
                            </button>
                        </div>
                        @if ($standings->isNotEmpty())
                            <div class="space-y-5">
                                @foreach ($standings->groupBy(fn($s) => $s->phase?->name ?? 'General') as $phaseName => $phaseStandings)
                                    @foreach ($phaseStandings->groupBy('group_label') as $groupLabel => $groupStandings)
                                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                            <div class="bg-gray-50 border-b border-silver px-5 py-3">
                                                <h3 class="text-sm font-bold text-black-deep">
                                                    {{ $phaseName }}
                                                    @if($groupLabel) <span class="text-titanium font-normal ml-1">· Grupo {{ $groupLabel }}</span> @endif
                                                </h3>
                                            </div>
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm">
                                                    <thead>
                                                        <tr class="border-b border-silver">
                                                            <th class="text-left text-xs font-semibold text-titanium px-5 py-3 w-10">#</th>
                                                            <th class="text-left text-xs font-semibold text-titanium px-4 py-3">Equipo</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">PJ</th>
                                                            <th class="text-center text-xs font-semibold text-green-700 px-3 py-3 w-12">G</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">E</th>
                                                            <th class="text-center text-xs font-semibold text-red-600 px-3 py-3 w-12">P</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GF</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GC</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">DG</th>
                                                            <th class="text-center text-xs font-bold text-primary px-5 py-3 w-16">Pts</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-50">
                                                        @foreach ($groupStandings as $standing)
                                                            <tr class="{{ $loop->first ? 'bg-primary/5' : '' }} hover:bg-gray-50 transition-colors">
                                                                <td class="px-5 py-4">
                                                                    @if ($loop->first)
                                                                        <span class="w-6 h-6 rounded-full bg-primary text-white text-xs font-black flex items-center justify-center">1</span>
                                                                    @elseif ($loop->index === 1)
                                                                        <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-700 text-xs font-black flex items-center justify-center">2</span>
                                                                    @elseif ($loop->index === 2)
                                                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 text-xs font-black flex items-center justify-center">3</span>
                                                                    @else
                                                                        <span class="text-xs text-titanium font-semibold pl-1">{{ $standing->position }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-4 py-4 font-semibold text-black-deep">{{ $standing->tournamentTeam?->displayName() ?? '—' }}</td>
                                                                <td class="px-3 py-4 text-center text-titanium">{{ $standing->played }}</td>
                                                                <td class="px-3 py-4 text-center font-semibold text-green-700">{{ $standing->won }}</td>
                                                                <td class="px-3 py-4 text-center text-titanium">{{ $standing->drawn }}</td>
                                                                <td class="px-3 py-4 text-center font-semibold text-red-600">{{ $standing->lost }}</td>
                                                                <td class="px-3 py-4 text-center text-titanium">{{ $standing->goals_for }}</td>
                                                                <td class="px-3 py-4 text-center text-titanium">{{ $standing->goals_against }}</td>
                                                                <td class="px-3 py-4 text-center text-titanium">{{ ($standing->goals_for - $standing->goals_against) >= 0 ? '+' : '' }}{{ $standing->goals_for - $standing->goals_against }}</td>
                                                                <td class="px-5 py-4 text-center"><span class="text-xl font-black text-primary">{{ $standing->points }}</span></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @elseif ($hasLeaguePhase && $teams->isNotEmpty())
                            {{-- Virtual standings: league phase exists but no matches played yet --}}
                            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                <div class="bg-gray-50 border-b border-silver px-5 py-3 flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-black-deep">Clasificación</h3>
                                    <span class="text-xs text-titanium bg-gray-100 px-2 py-0.5 rounded-full">Sin partidos jugados aún</span>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-silver">
                                                <th class="text-left text-xs font-semibold text-titanium px-5 py-3 w-10">#</th>
                                                <th class="text-left text-xs font-semibold text-titanium px-4 py-3">Equipo</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">PJ</th>
                                                <th class="text-center text-xs font-semibold text-green-700 px-3 py-3 w-12">G</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">E</th>
                                                <th class="text-center text-xs font-semibold text-red-600 px-3 py-3 w-12">P</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GF</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GC</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">DG</th>
                                                <th class="text-center text-xs font-bold text-primary px-5 py-3 w-16">Pts</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach ($teams->sortBy(fn($t) => $t->displayName())->values() as $team)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-5 py-4">
                                                        <span class="text-xs text-titanium font-semibold pl-1">{{ $loop->iteration }}</span>
                                                    </td>
                                                    <td class="px-4 py-4 font-semibold text-black-deep">{{ $team->displayName() }}</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-5 py-4 text-center"><span class="text-xl font-black text-primary">0</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- ========================= TAB: EQUIPOS ========================= --}}
                <div x-show="tab === 'teams'" x-cloak>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-titanium">
                            <span class="font-bold text-black-deep">{{ $teams->count() }}</span> equipos inscritos
                        </p>
                        <button wire:click="openCreateTeamModal"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Añadir equipo
                        </button>
                    </div>

                    @php
                        $hasGroups = $teams->contains(fn($t) => filled($t->group_label));
                        $teamGroups = $hasGroups
                            ? $teams->sortBy([['group_label','asc'],['seed','asc'],['name_override','asc']])->groupBy(fn($t) => $t->group_label ?: '')
                            : collect(['' => $teams->sortBy([['seed','asc'],['name_override','asc']])]);
                    @endphp

                    <div class="space-y-5">
                        @foreach ($teamGroups as $groupKey => $groupTeams)
                            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                @if ($hasGroups)
                                    <div class="bg-gray-50 border-b border-silver px-5 py-3 flex items-center gap-2">
                                        @if ($groupKey !== '')
                                            <span class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-black text-primary shrink-0">{{ $groupKey }}</span>
                                            <h3 class="text-sm font-bold text-black-deep">Grupo {{ $groupKey }}</h3>
                                        @else
                                            <h3 class="text-sm font-bold text-black-deep">Sin grupo</h3>
                                        @endif
                                        <span class="text-xs text-titanium bg-gray-100 px-2 py-0.5 rounded-full ml-1">{{ $groupTeams->count() }} equipos</span>
                                    </div>
                                @endif
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-silver bg-gray-50/60">
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3 w-12"></th>
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3">Equipo</th>
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden md:table-cell">Contacto</th>
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden sm:table-cell">Teléfono</th>
                                                <th class="text-center text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3">Jugadores</th>
                                                @if ($hasGroups)
                                                    <th class="text-center text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden lg:table-cell">Grupo</th>
                                                @endif
                                                <th class="text-right text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach ($groupTeams as $team)
                                                <tr class="hover:bg-gray-50/60 transition-colors">
                                                    {{-- Escudo --}}
                                                    <td class="px-5 py-3">
                                                        @if ($team->logo)
                                                            <img src="{{ asset('storage/' . $team->logo) }}"
                                                                 class="w-9 h-9 rounded-lg object-cover border border-silver" alt="">
                                                        @elseif ($team->team?->logo)
                                                            <img src="{{ Storage::url($team->team->logo) }}"
                                                                 class="w-9 h-9 rounded-lg object-cover border border-silver" alt="">
                                                        @else
                                                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                                                <span class="text-sm font-black text-primary">{{ mb_strtoupper(mb_substr($team->displayName(), 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    {{-- Nombre + badges --}}
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="font-semibold text-black-deep">{{ $team->displayName() }}</span>
                                                            @if ($team->seed)
                                                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-full">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                                                    Cabeza {{ $team->seed }}
                                                                </span>
                                                            @endif
                                                            @if ($team->external_team)
                                                                <span class="text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Externo</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    {{-- Contacto --}}
                                                    <td class="px-4 py-3 hidden md:table-cell text-titanium">
                                                        {{ $team->contact_name ?: '—' }}
                                                    </td>
                                                    {{-- Teléfono --}}
                                                    <td class="px-4 py-3 hidden sm:table-cell text-titanium">
                                                        {{ $team->contact_phone ?: '—' }}
                                                    </td>
                                                    {{-- Jugadores --}}
                                                    <td class="px-4 py-3">
                                                        @php
                                                            $totalPlayers    = $team->players()->count();
                                                            $approvedPlayers = $team->players()->where('status', 'approved')->count();
                                                            $pct             = $totalPlayers > 0 ? round($approvedPlayers / $totalPlayers * 100) : 0;
                                                            $barColor        = $pct === 100 ? 'bg-green-500' : ($pct >= 50 ? 'bg-indigo-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-200'));
                                                        @endphp
                                                        @if($totalPlayers > 0)
                                                            <div class="flex flex-col gap-1 min-w-[80px]">
                                                                <div class="flex items-center justify-between gap-2">
                                                                    <span class="text-xs font-bold {{ $pct === 100 ? 'text-green-700' : 'text-indigo-700' }}">
                                                                        {{ $approvedPlayers }}/{{ $totalPlayers }}
                                                                    </span>
                                                                    <span class="text-[10px] font-black {{ $pct === 100 ? 'text-green-600' : 'text-titanium' }}">
                                                                        {{ $pct }}%
                                                                    </span>
                                                                </div>
                                                                <div class="h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                                                                    <div class="h-full rounded-full transition-all {{ $barColor }}"
                                                                         style="width: {{ $pct }}%"></div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-xs text-titanium/40 font-semibold">—</span>
                                                        @endif
                                                    </td>
                                                    {{-- Grupo --}}
                                                    @if ($hasGroups)
                                                        <td class="px-4 py-3 text-center hidden lg:table-cell">
                                                            @if ($team->group_label)
                                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-primary/10 text-xs font-black text-primary">{{ $team->group_label }}</span>
                                                            @else
                                                                <span class="text-titanium/40">—</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    {{-- Acciones --}}
                                                    <td class="px-5 py-3">
                                                        <div class="flex items-center justify-end gap-1.5">
                                                            <a href="{{ route('tournament.team.players', [$tournament, $team]) }}"
                                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition-colors"
                                                               title="Jugadores">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                                <span class="hidden sm:inline">Jugadores</span>
                                                            </a>
                                                            <button wire:click="openEditTeamModal({{ $team->id }})"
                                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary/5 text-primary border border-primary/20 hover:bg-primary/10 transition-colors"
                                                                    title="Editar equipo">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                <span class="hidden sm:inline">Editar</span>
                                                            </button>
                                                            <button wire:click="confirmDeleteTeam({{ $team->id }})"
                                                                    class="p-1.5 rounded-lg text-titanium/40 hover:text-red-500 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                                                                    title="Eliminar equipo">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ========================= TAB: CONFIGURAR ========================= --}}
                <div x-show="tab === 'setup'" x-cloak>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Phases panel --}}
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-black-deep">Fases del torneo</h3>
                                        <p class="text-xs text-titanium mt-0.5">Define el formato de competición</p>
                                    </div>
                                </div>
                                <button wire:click="openCreatePhaseModal"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-primary bg-primary/5 border border-primary/20 hover:bg-primary/10 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Nueva fase
                                </button>
                            </div>
                            @if ($phases->isEmpty())
                                <div class="flex flex-col items-center justify-center py-10 border-2 border-dashed border-silver rounded-2xl">
                                    <svg class="w-10 h-10 text-titanium/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="text-sm text-titanium mb-3">Sin fases definidas</p>
                                    <button wire:click="openCreatePhaseModal"
                                            class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
                                        + Crear primera fase
                                    </button>
                                </div>
                            @else
                                <div class="space-y-2">
                                    @foreach ($phases as $phase)
                                        <div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-xl border border-silver/50">
                                            <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-sm font-black text-primary shrink-0">{{ $phase->order }}</span>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-black-deep">{{ $phase->name }}</p>
                                                <p class="text-xs text-titanium mt-0.5">{{ $phase->typeLabel() }} · {{ $phase->matches_count }} partidos</p>
                                            </div>
                                            <div class="flex items-center gap-1 shrink-0">
                                                <button wire:click="openEditPhaseModal({{ $phase->id }})"
                                                        class="p-2 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors" title="Editar fase">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button wire:click="confirmDeletePhase({{ $phase->id }})"
                                                        class="p-2 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors" title="Eliminar fase">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Actions panel --}}
                        <div class="space-y-4">
                            @if ($standings->isNotEmpty() || $matches->where('status', 'completed')->count() > 0)
                                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-black-deep">Clasificación</h3>
                                            <p class="text-xs text-titanium mt-0.5">Recalcula puntos y posiciones</p>
                                        </div>
                                    </div>
                                    <button wire:click="recalculateStandings"
                                            class="w-full inline-flex items-center justify-center gap-2 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-2.5 rounded-xl hover:bg-green-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Recalcular clasificación
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ========================= TAB: ESTADÍSTICAS ========================= --}}
                <div x-show="tab === 'stats'" x-cloak>
                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-black-deep mb-1">Estadísticas detalladas</h3>
                        <p class="text-sm text-titanium mb-5">Goleadores, tarjetas y sanciones del torneo.</p>
                        <a href="{{ route('tournament.stats', $tournament) }}" wire:navigate
                           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Ver estadísticas completas
                        </a>
                    </div>
                </div>

                {{-- ========================= TAB: ÁRBITROS ========================= --}}
                <div x-show="tab === 'referees'" x-cloak>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-titanium">
                            <span class="font-bold text-black-deep">{{ $assignedReferees->count() }}</span> árbitros asignados
                        </p>
                        <button wire:click="openRefereesModal"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Gestionar árbitros
                        </button>
                    </div>

                    @if ($assignedReferees->isEmpty())
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-black-deep mb-2">Aún no hay árbitros asignados</h3>
                            <p class="text-sm text-titanium mb-5">Asigna árbitros al torneo para que puedan gestionar los partidos.</p>
                            <button wire:click="openRefereesModal"
                                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Asignar árbitros
                            </button>
                        </div>
                    @else
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-silver bg-gray-50/60">
                                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Nombre</th>
                                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden md:table-cell">Email</th>
                                            <th class="text-center text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden sm:table-cell">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach ($assignedReferees as $referee)
                                            <tr class="hover:bg-gray-50/60 transition-colors">
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-3">
                                                        @if ($referee->profile_photo_path)
                                                            <img src="{{ asset('storage/' . $referee->profile_photo_path) }}"
                                                                 class="w-10 h-10 rounded-full object-cover border border-silver" alt="">
                                                        @else
                                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">
                                                                <span class="text-sm font-black text-indigo-700">{{ strtoupper(substr($referee->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <p class="font-semibold text-black-deep">{{ $referee->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-titanium hidden md:table-cell">
                                                    {{ $referee->email }}
                                                </td>
                                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                                    @if ($referee->is_active)
                                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                            Activo
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-600 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full">
                                                            Inactivo
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

            @endif

        @else
            @if ($categories->isEmpty() && $tournament->team_type !== 'open')
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
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

    </div>

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
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6 my-4">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep">{{ $editingTeamId ? 'Editar Equipo' : 'Añadir Equipo' }}</h3>
                    <button wire:click="$set('showTeamModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    @if ($tournament->team_type === 'open')
                        <div class="flex items-center gap-2 p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs text-blue-700 font-medium">Torneo abierto: solo se pueden inscribir equipos externos.</p>
                        </div>
                    @else
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-silver">
                            <label class="text-sm font-medium text-black-deep">Equipo externo</label>
                            <button wire:click="$set('external_team', {{ $external_team ? 'false' : 'true' }})"
                                    class="relative inline-flex items-center w-10 h-6 rounded-full transition-colors {{ $external_team ? 'bg-primary' : 'bg-silver' }}">
                                <span class="inline-block w-4 h-4 bg-white rounded-full shadow transition-transform {{ $external_team ? 'translate-x-5' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                    @endif
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

                    {{-- Logo / Escudo --}}
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Escudo del equipo</label>
                        @if ($team_logo && !$team_logo_upload)
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ asset('storage/' . $team_logo) }}" class="w-14 h-14 object-cover rounded-xl border border-silver">
                                <button wire:click="deleteTeamLogo" type="button" class="text-xs text-red-500 hover:text-red-700 font-semibold">Eliminar</button>
                            </div>
                        @endif
                        @if ($team_logo_upload)
                            <img src="{{ $team_logo_upload->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-xl border border-silver mb-2">
                        @endif
                        <input wire:model="team_logo_upload" type="file" accept="image/*"
                               class="w-full text-sm text-titanium file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"/>
                        <div wire:loading wire:target="team_logo_upload" class="text-xs text-primary mt-1">Subiendo...</div>
                        @error('team_logo_upload') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/60 mt-1">PNG, JPG (máx. 2MB)</p>
                    </div>

                    {{-- Contact --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre de contacto</label>
                            <input wire:model="team_contact_name" type="text" placeholder="Nombre"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                            @error('team_contact_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Teléfono</label>
                            <input wire:model="team_contact_phone" type="tel" placeholder="600 000 000"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                            @error('team_contact_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Access credentials --}}
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">
                            Email de acceso {{ $tournament->team_type === 'open' ? '*' : '(opcional)' }}
                        </label>
                        <input wire:model="team_email" type="email" placeholder="equipo@ejemplo.com"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        @error('team_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">
                            Contraseña {{ $editingTeamId ? '(dejar vacío para no cambiar)' : ($tournament->team_type === 'open' ? '*' : '(opcional)') }}
                        </label>
                        <input wire:model="team_password" type="password" placeholder="{{ $editingTeamId ? '••••••' : 'Contraseña de acceso' }}"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        @error('team_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/60 mt-1">Acceso al área de gestión del equipo (mínimo 6 caracteres).</p>
                    </div>

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

    {{-- Goals Modal — register match results by entering goal scorers --}}
    @if ($showGoalsModal && $goalsModalMatch)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
             wire:keydown.window.escape="closeGoalsModal">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-lg max-h-[90vh] flex flex-col">

                {{-- Header --}}
                <div class="px-6 pt-6 pb-4 border-b border-silver shrink-0">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-black-deep">Registrar goles</h3>
                        <button wire:click="closeGoalsModal"
                                class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    {{-- Match header --}}
                    <div class="flex items-center justify-center gap-3 bg-gray-50 rounded-xl p-3">
                        <span class="text-sm font-semibold text-black-deep text-right flex-1">{{ $goalsModalMatch->homeTeam?->displayName() ?? '—' }}</span>
                        <div class="shrink-0 px-3 py-1 bg-white-pure rounded-lg border border-silver text-center min-w-[64px]">
                            @if ($goalsModalMatch->status === 'completed' || $goalsModalMatch->home_score !== null)
                                <span class="text-lg font-bold text-black-deep">{{ $goalsModalMatch->home_score ?? 0 }} – {{ $goalsModalMatch->away_score ?? 0 }}</span>
                            @else
                                <span class="text-sm font-bold text-titanium">0 – 0</span>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-black-deep text-left flex-1">{{ $goalsModalMatch->awayTeam?->displayName() ?? '—' }}</span>
                    </div>
                </div>

                {{-- Goals list --}}
                <div class="flex-1 overflow-y-auto px-6 py-4 space-y-2">
                    @forelse ($goalsForModal as $goal)
                        @if ($gm_deletingGoalId === $goal->id)
                            <div class="flex items-center justify-between bg-red-50 border border-red-200 rounded-xl px-4 py-2.5">
                                <span class="text-sm text-red-700">¿Eliminar este gol?</span>
                                <div class="flex gap-2">
                                    <button wire:click="gmCancelDeleteGoal"
                                            class="px-3 py-1 text-xs font-semibold text-titanium border border-silver rounded-lg hover:bg-gray-50 transition-colors">No</button>
                                    <button wire:click="gmDeleteGoal"
                                            class="px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">Sí, eliminar</button>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-2.5 group">
                                <div class="flex items-center gap-3">
                                    <span class="text-base leading-none">
                                        @if ($goal->goal_type === 'own_goal') ⚽
                                        @elseif ($goal->goal_type === 'penalty') ⚽
                                        @else ⚽
                                        @endif
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-black-deep">
                                            {{ $goal->player?->surname }} {{ $goal->player?->name }}
                                            @if ($goal->goal_type === 'own_goal')
                                                <span class="text-xs text-red-500 font-normal">(p.p.)</span>
                                            @elseif ($goal->goal_type === 'penalty')
                                                <span class="text-xs text-blue-500 font-normal">(pen.)</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-titanium">
                                            {{ $goal->team?->displayName() }}{{ $goal->minute ? ' · min. ' . $goal->minute : '' }}
                                        </p>
                                    </div>
                                </div>
                                <button wire:click="gmConfirmDeleteGoal({{ $goal->id }})"
                                        class="p-1.5 rounded-lg text-titanium/30 hover:text-red-500 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        @endif
                    @empty
                        <p class="text-center text-sm text-titanium py-6">Aún no hay goles registrados.</p>
                    @endforelse
                </div>

                {{-- Add goal form --}}
                <div class="px-6 pb-6 pt-2 border-t border-silver shrink-0">
                    @if ($gm_showForm)
                        <div class="space-y-3 pt-4">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo</label>
                                    <select wire:model.live="gm_team_id"
                                            class="w-full px-3 py-2 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                        <option value="">— Equipo —</option>
                                        @foreach ($gmMatchTeams as $t)
                                            <option value="{{ $t->id }}">{{ $t->displayName() }}</option>
                                        @endforeach
                                    </select>
                                    @error('gm_team_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Jugador</label>
                                    <select wire:model="gm_player_id"
                                            class="w-full px-3 py-2 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary disabled:opacity-50"
                                            @if(!$gm_team_id) disabled @endif>
                                        <option value="">— Jugador —</option>
                                        @foreach ($gmTeamPlayers as $p)
                                            <option value="{{ $p->id }}">{{ $p->surname }} {{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('gm_player_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Tipo</label>
                                    <select wire:model="gm_goal_type"
                                            class="w-full px-3 py-2 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                        <option value="normal">Normal</option>
                                        <option value="penalty">Penalti</option>
                                        <option value="own_goal">En propia</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Minuto <span class="font-normal normal-case">(opcional)</span></label>
                                    <input wire:model="gm_minute" type="number" min="1" max="180" placeholder="ej. 45"
                                           class="w-full px-3 py-2 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                                </div>
                            </div>
                            <div class="flex gap-2 pt-1">
                                <button wire:click="gmToggleForm"
                                        class="flex-1 py-2 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                                    Cancelar
                                </button>
                                <button wire:click="gmAddGoal"
                                        class="flex-1 py-2 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                                    Añadir gol
                                </button>
                            </div>
                        </div>
                    @else
                        <button wire:click="gmToggleForm"
                                class="w-full mt-4 flex items-center justify-center gap-2 py-2.5 rounded-xl border-2 border-dashed border-primary/30 text-sm font-semibold text-primary hover:bg-primary/5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Añadir goleador
                        </button>
                    @endif
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

    {{-- Referees Modal --}}
    @if ($showRefereesModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-6 border-b border-silver shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-black-deep flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Gestionar Árbitros
                        </h3>
                        <p class="text-sm text-titanium mt-1">Selecciona los árbitros que deseas asignar al torneo</p>
                    </div>
                    <button wire:click="$set('showRefereesModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6">
                    @if ($availableReferees->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h4 class="text-base font-bold text-black-deep mb-2">No hay árbitros disponibles</h4>
                            <p class="text-sm text-titanium">No hay usuarios con el rol de "judge" en tu escuela deportiva.</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach ($availableReferees as $referee)
                                <label class="flex items-center gap-4 p-4 rounded-xl border border-silver hover:border-primary/30 hover:bg-primary/5 cursor-pointer transition-all
                                    {{ in_array($referee->id, $selectedReferees) ? 'bg-primary/10 border-primary shadow-sm' : 'bg-white' }}">
                                    <input type="checkbox" 
                                           wire:click="toggleReferee({{ $referee->id }})"
                                           {{ in_array($referee->id, $selectedReferees) ? 'checked' : '' }}
                                           class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary/30">
                                    
                                    <div class="flex items-center gap-3 flex-1">
                                        @if ($referee->profile_photo_path)
                                            <img src="{{ asset('storage/' . $referee->profile_photo_path) }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-silver" alt="">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary/20 to-primary/5 border-2 border-primary/20 flex items-center justify-center shrink-0">
                                                <span class="text-lg font-black text-primary">{{ strtoupper(substr($referee->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-black-deep">{{ $referee->name }}</p>
                                            <p class="text-sm text-titanium truncate">{{ $referee->email }}</p>
                                        </div>

                                        @if ($referee->is_active)
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2 py-1 rounded-full shrink-0">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Activo
                                            </span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-between gap-3 p-6 border-t border-silver shrink-0">
                    <p class="text-sm text-titanium">
                        <span class="font-bold text-black-deep">{{ count($selectedReferees) }}</span> 
                        {{ count($selectedReferees) === 1 ? 'árbitro seleccionado' : 'árbitros seleccionados' }}
                    </p>
                    <div class="flex gap-3">
                        <button wire:click="$set('showRefereesModal', false)"
                                class="px-5 py-2.5 text-sm font-semibold text-titanium border border-silver rounded-xl hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="saveReferees"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Guardar árbitros
                        </button>
                    </div>
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

    @if ($showPostponeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-black-deep">Aplazar partido</h3>
                    <button wire:click="$set('showPostponeModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-titanium mb-4">El partido quedará marcado como aplazado. Puedes indicar la nueva fecha y hora.</p>
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nueva fecha y hora (opcional)</label>
                    <input wire:model="postponeDate" type="datetime-local"
                           class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                </div>
                <div class="flex gap-3">
                    <button wire:click="$set('showPostponeModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="postponeMatch"
                            class="flex-1 py-2.5 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 transition-colors">Aplazar</button>
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