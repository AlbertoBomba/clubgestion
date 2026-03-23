<div>
    {{-- Flash message --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="mb-6 flex items-center gap-3 bg-neon-green/10 border border-neon-green/30 text-neon-green rounded-xl px-4 py-3 text-sm font-medium shadow">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- Hero header --}}
    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start gap-5">
            {{-- Logo --}}
            <div class="shrink-0">
                @if ($tournament->logo)
                    <img src="{{ Storage::url($tournament->logo) }}" alt="{{ $tournament->name }}"
                         class="w-20 h-20 rounded-2xl object-cover border border-silver shadow-sm"/>
                @else
                    <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center border border-primary/20">
                        <svg class="w-9 h-9 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                @endif
            </div>
            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $tournament->statusColor() }}">
                        {{ $tournament->statusLabel() }}
                    </span>
                    @if ($tournament->visibility === 'public')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                            Público
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl font-bold text-black-deep truncate">{{ $tournament->name }}</h1>
                @if ($tournament->description)
                    <p class="text-sm text-titanium mt-1 line-clamp-2">{{ $tournament->description }}</p>
                @endif
                <div class="flex flex-wrap gap-4 mt-3 text-xs text-titanium">
                    @if ($tournament->location)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $tournament->location }}
                        </span>
                    @endif
                    @if ($tournament->start_date)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $tournament->start_date->format('d/m/Y') }}
                            @if ($tournament->end_date) – {{ $tournament->end_date->format('d/m/Y') }} @endif
                        </span>
                    @endif
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $categories->sum('tournament_teams_count') }} equipos · {{ $categories->count() }} categorías
                        @if ($tournament->max_teams) / {{ $tournament->max_teams }} @endif
                    </span>
                </div>
            </div>
            {{-- Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('tournaments.edit', $tournament) }}" wire:navigate
                   class="inline-flex items-center gap-2 border border-silver text-sm font-semibold text-titanium px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- CATEGORY SELECTOR                                            --}}
    {{-- ============================================================ --}}
    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-4 mb-6">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-titanium uppercase tracking-wide mr-1">Categoría:</span>

                @forelse ($categories as $cat)
                    <div class="relative group flex items-center gap-1">
                        <button wire:click="selectCategory({{ $cat->id }})"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-semibold border transition-all
                                    {{ $activeCategoryId === $cat->id ? 'bg-primary text-white border-primary shadow' : 'bg-white-pure text-black-deep border-silver hover:border-primary/40 hover:text-primary' }}">
                            {{ $cat->displayName() }}
                            <span class="text-xs opacity-70 font-normal">({{ $cat->tournament_teams_count }})</span>
                        </button>
                        <button wire:click="openEditCategoryModal({{ $cat->id }})"
                                class="p-1 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors opacity-0 group-hover:opacity-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button wire:click="confirmDeleteCategory({{ $cat->id }})"
                                class="p-1 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                @empty
                    <span class="text-sm text-titanium">Sin categorías todavía.</span>
                @endforelse
            </div>

            <button wire:click="openCreateCategoryModal"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary border border-primary/30 bg-primary/5 hover:bg-primary/10 px-3 py-1.5 rounded-xl transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva categoría
            </button>
        </div>
    </div>

    {{-- If no category is selected / no categories exist, show empty state --}}
    @if (! $activeCategoryId)
        <div class="text-center py-20 bg-white-pure border border-silver rounded-2xl">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-black-deep mb-2">Sin categorías</h3>
            <p class="text-sm text-titanium mb-6">Crea la primera categoría para empezar a gestionar equipos, fases y partidos.</p>
            <button wire:click="openCreateCategoryModal"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Crear primera categoría
            </button>
        </div>
    @else

    {{-- Tabs --}}
    <div class="border-b border-silver mb-6">
        <nav class="-mb-px flex gap-1 overflow-x-auto">
            @php
                $tabs = [
                    ['key' => 'overview',  'label' => 'Resumen',       'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['key' => 'phases',   'label' => 'Fases',         'icon' => 'M4 6h16M4 12h16M4 18h7'],
                    ['key' => 'teams',    'label' => 'Equipos',       'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['key' => 'matches',  'label' => 'Partidos',      'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z'],
                    ['key' => 'standings','label' => 'Clasificación', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ];
            @endphp
            @foreach ($tabs as $tab)
                <button wire:click="$set('activeTab', '{{ $tab['key'] }}')"
                        class="flex items-center gap-1.5 px-4 py-3 text-sm font-medium border-b-2 transition-colors whitespace-nowrap {{ $activeTab === $tab['key'] ? 'border-primary text-primary' : 'border-transparent text-titanium hover:text-black-deep hover:border-silver' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"/>
                    </svg>
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </nav>
    </div>

    {{-- ========================= OVERVIEW ========================= --}}
    @if ($activeTab === 'overview')
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach ([
                ['label' => 'Equipos',   'value' => $teams->count(),   'color' => 'text-primary',   'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Fases',     'value' => $phases->count(),  'color' => 'text-blue-600',  'icon' => 'M4 6h16M4 12h16M4 18h7'],
                ['label' => 'Partidos',  'value' => $matches->count(), 'color' => 'text-amber-600', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Completados', 'value' => $matches->where('status','completed')->count(), 'color' => 'text-green-600', 'icon' => 'M5 13l4 4L19 7'],
            ] as $stat)
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/5 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ $stat['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-black-deep">{{ $stat['value'] }}</p>
                        <p class="text-xs text-titanium">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Phase summary cards --}}
        @if ($phases->isNotEmpty())
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h3 class="text-sm font-semibold text-black-deep mb-4">Fases del torneo</h3>
                <div class="space-y-3">
                    @foreach ($phases as $phase)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-silver hover:border-primary/30 transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-bold text-primary">
                                    {{ $phase->order }}
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-black-deep">{{ $phase->name }}</p>
                                    <p class="text-xs text-titanium">{{ $phase->typeLabel() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-titanium">{{ $phase->matches_count }} partidos</span>
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $phase->status === 'in_progress' ? 'bg-amber-50 text-amber-700' : ($phase->status === 'completed' ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-600') }}">
                                    {{ $phase->status === 'pending' ? 'Pendiente' : ($phase->status === 'in_progress' ? 'En curso' : 'Completada') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    {{-- ========================= PHASES ========================= --}}
    @elseif ($activeTab === 'phases')
        <div class="flex justify-end mb-4">
            <button wire:click="openCreatePhaseModal"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nueva Fase
            </button>
        </div>

        @if ($phases->isEmpty())
            <div class="text-center py-16 bg-white-pure border border-silver rounded-2xl">
                <p class="text-titanium text-sm">No hay fases creadas. Añade la primera fase al torneo.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($phases as $phase)
                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center shrink-0 mt-0.5">
                                    <span class="text-sm font-bold text-primary">{{ $phase->order }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-semibold text-black-deep">{{ $phase->name }}</h3>
                                        <span class="text-xs font-medium text-titanium bg-gray-50 border border-silver px-2 py-0.5 rounded-lg">{{ $phase->typeLabel() }}</span>
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $phase->status === 'in_progress' ? 'bg-amber-50 text-amber-700' : ($phase->status === 'completed' ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-600') }}">
                                            {{ $phase->status === 'pending' ? 'Pendiente' : ($phase->status === 'in_progress' ? 'En curso' : 'Completada') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-titanium mt-1">{{ $phase->matches_count }} partidos en esta fase</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button wire:click="openEditPhaseModal({{ $phase->id }})"
                                        class="p-2 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="confirmDeletePhase({{ $phase->id }})"
                                        class="p-2 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    {{-- ========================= TEAMS ========================= --}}
    @elseif ($activeTab === 'teams')
        <div class="flex justify-end mb-4">
            <button wire:click="openCreateTeamModal"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Añadir Equipo
            </button>
        </div>

        @if ($teams->isEmpty())
            <div class="text-center py-16 bg-white-pure border border-silver rounded-2xl">
                <p class="text-titanium text-sm">No hay equipos inscritos en este torneo.</p>
            </div>
        @else
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-silver">
                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">#</th>
                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Equipo</th>
                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Grupo</th>
                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Estado</th>
                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Tipo</th>
                            <th class="px-5 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-silver">
                        @foreach ($teams as $team)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-3 text-titanium font-semibold">{{ $team->seed ?? '—' }}</td>
                                <td class="px-5 py-3 font-semibold text-black-deep">{{ $team->displayName() }}</td>
                                <td class="px-5 py-3 text-titanium">{{ $team->group_label ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $team->status === 'confirmed' ? 'bg-green-50 text-green-700' : ($team->status === 'eliminated' ? 'bg-red-50 text-red-600' : 'bg-gray-50 text-gray-600') }}">
                                        {{ ucfirst($team->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-titanium text-xs">{{ $team->external_team ? 'Externo' : 'Escuela' }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-1 justify-end">
                                        <button wire:click="openEditTeamModal({{ $team->id }})"
                                                class="p-1.5 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button wire:click="confirmDeleteTeam({{ $team->id }})"
                                                class="p-1.5 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors">
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

    {{-- ========================= MATCHES ========================= --}}
    @elseif ($activeTab === 'matches')
        <div class="flex justify-end mb-4">
            <button wire:click="openCreateMatchModal"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Partido
            </button>
        </div>

        @if ($matches->isEmpty())
            <div class="text-center py-16 bg-white-pure border border-silver rounded-2xl">
                <p class="text-titanium text-sm">No hay partidos programados en este torneo.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($matches->groupBy(fn($m) => $m->phase?->name ?? 'Sin fase') as $phaseName => $phaseMatches)
                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-gray-50/70 border-b border-silver px-5 py-3">
                            <h3 class="text-xs font-semibold text-titanium uppercase tracking-wide">{{ $phaseName }}</h3>
                        </div>
                        <div class="divide-y divide-silver">
                            @foreach ($phaseMatches as $match)
                                <div class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex-1 text-right">
                                        <p class="text-sm font-semibold text-black-deep">{{ $match->homeTeam?->displayName() ?? '—' }}</p>
                                    </div>
                                    <div class="text-center shrink-0">
                                        @if ($match->status === 'completed')
                                            <span class="text-base font-bold text-black-deep px-3">
                                                {{ $match->home_score }} – {{ $match->away_score }}
                                            </span>
                                        @else
                                            <span class="text-xs font-semibold text-titanium px-3 py-1 rounded-lg bg-gray-50 border border-silver">
                                                {{ $match->scheduled_at?->format('d/m H:i') ?? 'vs' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex-1 text-left">
                                        <p class="text-sm font-semibold text-black-deep">{{ $match->awayTeam?->displayName() ?? '—' }}</p>
                                    </div>
                                    <div class="shrink-0 flex items-center gap-1">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $match->status === 'completed' ? 'bg-green-50 text-green-700' : ($match->status === 'cancelled' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-700') }}">
                                            @if ($match->status === 'completed') Jugado
                                            @elseif ($match->status === 'in_progress') En curso
                                            @elseif ($match->status === 'cancelled') Cancelado
                                            @elseif ($match->status === 'postponed') Aplazado
                                            @else Prog.
                                            @endif
                                        </span>
                                        <button wire:click="openEditMatchModal({{ $match->id }})"
                                                class="p-1.5 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors ml-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button wire:click="confirmDeleteMatch({{ $match->id }})"
                                                class="p-1.5 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    {{-- ========================= STANDINGS ========================= --}}
    @elseif ($activeTab === 'standings')
        <div class="flex justify-end mb-4">
            <button wire:click="recalculateStandings"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Recalcular Clasificación
            </button>
        </div>

        @if ($standings->isEmpty())
            <div class="text-center py-16 bg-white-pure border border-silver rounded-2xl">
                <p class="text-titanium text-sm">No hay clasificación todavía. Recalcula para generar la tabla.</p>
            </div>
        @else
            @foreach ($standings->groupBy(fn($s) => $s->phase?->name ?? 'General') as $phaseName => $phaseStandings)
                @foreach ($phaseStandings->groupBy('group_label') as $groupLabel => $groupStandings)
                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden mb-5">
                        <div class="bg-gray-50/70 border-b border-silver px-5 py-3 flex items-center justify-between">
                            <h3 class="text-xs font-semibold text-titanium uppercase tracking-wide">
                                {{ $phaseName }} @if($groupLabel) – Grupo {{ $groupLabel }} @endif
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50/40 border-b border-silver">
                                        <th class="text-left text-xs font-semibold text-titanium px-5 py-2.5 w-8">#</th>
                                        <th class="text-left text-xs font-semibold text-titanium px-5 py-2.5">Equipo</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">PJ</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">G</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">E</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">P</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">GF</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">GC</th>
                                        <th class="text-center text-xs font-semibold text-titanium px-3 py-2.5">DG</th>
                                        <th class="text-center text-xs font-semibold text-primary px-5 py-2.5 font-bold">Pts</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-silver">
                                    @foreach ($groupStandings as $standing)
                                        <tr class="hover:bg-gray-50/50 transition-colors {{ $loop->first ? 'bg-primary/5' : '' }}">
                                            <td class="px-5 py-3 text-xs font-bold {{ $loop->first ? 'text-primary' : 'text-titanium' }}">
                                                {{ $standing->position }}
                                            </td>
                                            <td class="px-5 py-3 font-semibold text-black-deep">
                                                {{ $standing->tournamentTeam?->displayName() ?? '—' }}
                                            </td>
                                            <td class="px-3 py-3 text-center text-titanium">{{ $standing->played }}</td>
                                            <td class="px-3 py-3 text-center text-green-700 font-semibold">{{ $standing->won }}</td>
                                            <td class="px-3 py-3 text-center text-titanium">{{ $standing->drawn }}</td>
                                            <td class="px-3 py-3 text-center text-red-600 font-semibold">{{ $standing->lost }}</td>
                                            <td class="px-3 py-3 text-center text-titanium">{{ $standing->goals_for }}</td>
                                            <td class="px-3 py-3 text-center text-titanium">{{ $standing->goals_against }}</td>
                                            <td class="px-3 py-3 text-center text-titanium">
                                                {{ ($standing->goals_for - $standing->goals_against) >= 0 ? '+' : '' }}{{ $standing->goals_for - $standing->goals_against }}
                                            </td>
                                            <td class="px-5 py-3 text-center font-bold text-primary text-base">{{ $standing->points }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif
    @endif {{-- activeTab --}}

    @endif {{-- activeCategoryId --}}

    {{-- ======================= MODALS ======================= --}}

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
                            <select wire:model="phase_type"
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
                    {{-- External toggle --}}
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-silver">
                        <label class="text-sm font-medium text-black-deep">Equipo externo (fuera de la escuela)</label>
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
                            <input wire:model="match_round" type="text" placeholder="Ej: Jornada 1"
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
                        <p class="text-xs text-titanium mt-1">Vincular a una categoría filtrará los equipos disponibles por edad.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre personalizado (opcional)</label>
                        <input wire:model="cat_name" type="text" placeholder="Ej: Alevín Verano 2026, Categoría A..."
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        <p class="text-xs text-titanium mt-1">Si no se indica, se usará el nombre de la categoría vinculada.</p>
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
                <p class="text-sm text-titanium text-center mb-6">Se eliminarán <strong>todos</strong> los equipos, fases, partidos y clasificaciones de esta categoría. Esta acción no se puede deshacer.</p>
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
