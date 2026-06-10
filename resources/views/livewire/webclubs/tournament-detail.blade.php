<div x-data="{ tab: 'partidos', showBases: false, teamModal: false, modalTeam: null, modalPlayers: [] }">
    <main class="min-h-screen bg-white pb-20 md:pb-0">

        @php
            $statusColors = [
                'registration_open' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'label' => 'Inscripciones abiertas'],
                'in_progress'       => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'label' => 'En curso'],
                'completed'         => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Finalizado'],
                'draft'             => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'label' => 'Proximamente'],
            ];
            $sc = $statusColors[$tournament->status] ?? $statusColors['draft'];
        @endphp

        {{-- ══════════════════════ MOBILE HEADER (hidden md+) ══════════════════════ --}}
        <header class="md:hidden sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center gap-3 px-4 pt-4 pb-3">
                {{-- Back --}}
                <a href="{{ route('webclubs.tournaments') }}" class="shrink-0 p-1.5 -ml-1 rounded-xl text-gray-400 active:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                {{-- Logo --}}
                @if($tournament->logo)
                    <div class="w-14 h-14 shrink-0 rounded-xl overflow-hidden border border-gray-200"
                         style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <img src="{{ Storage::url($tournament->logo) }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-14 h-14 shrink-0 rounded-xl flex items-center justify-center text-2xl border border-gray-200"
                         style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))"></div>
                @endif
                {{-- Title & status --}}
                <div class="flex-1 min-w-0">
                    <span class="{{ $sc['bg'] }} {{ $sc['text'] }} text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full inline-block">{{ $sc['label'] }}</span>
                    <h1 class="text-sm font-black text-black leading-tight truncate mt-0.5">{{ $tournament->name }}</h1>
                </div>
            </div>
            {{-- Action strip --}}
            <div class="flex gap-2 px-4 pb-3">
                <a href="{{ route('webclubs.team.login', $tournament) }}"
                   class="flex-1 flex items-center gap-3 px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 active:bg-gray-100">
                    <svg class="w-4 h-4 shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    <span class="flex flex-col leading-tight">
                        <span class="text-xs font-black text-gray-800">Acceso equipos</span>
                        <span class="text-[10px] text-gray-400 font-medium">Inscríbete si aún no estás inscrito</span>
                    </span>
                </a>
                <button @click="showBases = true"
                        class="flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl text-gray-700 font-bold text-xs border border-gray-200 bg-gray-50 active:bg-gray-100">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Bases
                </button>
            </div>
        </header>

        {{-- Hero header (desktop only) --}}
        <section class="hidden md:block pt-8 pb-8 md:pt-16 md:pb-12 border-b border-gray-100">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <a href="{{ route('webclubs.tournaments') }}"
                   class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-6 md:mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Torneos
                </a>

                <div class="flex flex-col md:flex-row gap-8 items-start">
                    {{-- Logo --}}
                    @if($tournament->logo)
                        <div class="w-full h-48 sm:h-56 md:w-28 md:h-28 shrink-0 rounded-2xl overflow-hidden border border-gray-100 shadow-lg"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <img src="{{ Storage::url($tournament->logo) }}" alt="{{ $tournament->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-48 sm:h-56 md:w-28 md:h-28 shrink-0 rounded-2xl flex items-center justify-center text-5xl border border-gray-100 shadow-lg"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">??</div>
                    @endif

                    <div class="flex-1">
                        {{-- Status badge --}}
                        @php
                            $statusColors = [
                                'registration_open' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'label' => 'Inscripciones abiertas'],
                                'in_progress'       => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'label' => 'En curso'],
                                'completed'         => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Finalizado'],
                                'draft'             => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'label' => 'Proximamente'],
                            ];
                            $sc = $statusColors[$tournament->status] ?? $statusColors['draft'];
                        @endphp
                        <span class="{{ $sc['bg'] }} {{ $sc['text'] }} text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full inline-block mb-4">
                            {{ $sc['label'] }}
                        </span>
                        <h1 class="section-title text-3xl sm:text-5xl md:text-7xl font-bold text-black leading-none tracking-tight mb-3 md:mb-4">
                            {{ $tournament->name }}
                        </h1>
                        @if($tournament->description)
                            <p class="text-sm md:text-base text-gray-500 max-w-2xl leading-relaxed mb-4 md:mb-5">{{ $tournament->description }}</p>
                        @endif
                        <div class="flex flex-wrap gap-3 md:gap-5 text-xs sm:text-sm text-gray-400 font-semibold uppercase tracking-wider">
                            @if($tournament->start_date)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $tournament->start_date->locale('es')->translatedFormat('d M Y') }}@if($tournament->end_date) &mdash; {{ $tournament->end_date->locale('es')->translatedFormat('d M Y') }}@endif</span>
                                </div>
                            @endif
                            @if($tournament->location)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $tournament->location }}</span>
                                </div>
                            @endif
                            @if($teams->count())
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $teams->count() }} equipos</span>
                                </div>
                            @endif
                            @if($tournament->registration_deadline && $tournament->status === 'registration_open')
                                <div class="flex items-center gap-2 text-amber-500">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Inscripcion hasta {{ $tournament->registration_deadline->locale('es')->translatedFormat('d M Y') }}</span>
                                </div>
                            @endif
                            @if($tournament->registration_fee)
                                <div class="flex items-center gap-2 text-green-600">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Inscripci&#243;n: {{ number_format($tournament->registration_fee, 2, ',', '.') }} &euro;</span>
                                </div>
                            @endif
                            @if($tournament->max_players_per_team)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>M&#225;x. {{ $tournament->max_players_per_team }} jugadores/equipo</span>
                                </div>
                            @endif
                            @if($tournament->min_age)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span>Edad m&#237;nima: {{ $tournament->min_age }} a&#241;os</span>
                                </div>
                            @endif
                            @if($tournament->player_registration_deadline)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    <span>Alta jugadores hasta {{ $tournament->player_registration_deadline->locale('es')->translatedFormat('d M Y') }}</span>
                                </div>
                            @endif
                            @if($tournament->team_type)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                    </svg>
                                    <span>{{ $tournament->team_type === 'school_teams' ? 'Escuelas Deportivas' : 'Torneo Abierto' }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- CTAs --}}
                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            @if($canRegister)
                                <a href="{{ route('webclubs.team.register', $tournament) }}"
                                   class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-white font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all duration-150"
                                   style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Inscribir equipo
                                </a>
                            @endif
                            <a href="{{ route('webclubs.team.login', $tournament) }}"
                               class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-gray-700 font-bold text-sm border border-gray-200 bg-white hover:bg-gray-50 active:scale-95 transition-all duration-150 shadow-sm">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                Acceso equipos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tabs --}}
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-12 py-6 md:py-10">

            {{-- Tab nav (desktop only — mobile uses fixed bottom nav) --}}
            <div class="hidden md:flex gap-1 bg-gray-100 rounded-2xl p-1.5 mb-6 md:mb-10 w-full md:w-fit">
                <button @click="tab = 'partidos'"
                        :class="tab === 'partidos' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-gray-700'"
                        class="flex-1 md:flex-none flex items-center justify-center gap-1.5 sm:gap-2 px-3 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-200">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="hidden xs:inline sm:inline">Partidos</span>
                </button>
                <button @click="tab = 'clasificacion'"
                        :class="tab === 'clasificacion' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-gray-700'"
                        class="flex-1 md:flex-none flex items-center justify-center gap-1.5 sm:gap-2 px-3 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-200">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="hidden xs:inline sm:inline">Clasificacion</span>
                </button>
                <button @click="tab = 'equipos'"
                        :class="tab === 'equipos' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 hover:text-gray-700'"
                        class="flex-1 md:flex-none flex items-center justify-center gap-1.5 sm:gap-2 px-3 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-200">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="hidden xs:inline sm:inline">Equipos</span>
                </button>
            </div>

            {{-- --------------- TAB: PARTIDOS --------------- --}}
            <div x-show="tab === 'partidos'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                @if($matchesByPhaseAndRound->isEmpty())
                    <div class="text-center py-24 bg-gray-50 border border-gray-100 rounded-2xl">
                        <div class="text-6xl mb-4 opacity-10">??</div>
                        <p class="text-gray-400 text-lg font-semibold">No hay partidos registrados aun.</p>
                    </div>
                @else
                    @foreach($matchesByPhaseAndRound as $phaseName => $rounds)
                        @php
                            $roundKeys  = $rounds->keys()->values()->toArray();
                            $roundCount = count($roundKeys);
                            $today      = now()->startOfDay();

                            // All teams participating in this phase (appear in at least one match)
                            $phaseTeamIds = $rounds->flatMap(fn($rm) => $rm->flatMap(fn($m) => [$m->home_team_id, $m->away_team_id]))->filter()->unique()->values();
                            $phaseTeams   = $teams->whereIn('id', $phaseTeamIds);

                            // Default: last round
                            $activeIdx = $roundCount - 1;

                            // Find the first round that has a match today or in the future
                            foreach ($roundKeys as $idx => $rLabel) {
                                $hasFuture = $rounds[$rLabel]->contains(
                                    fn($m) => !$m->scheduled_at || $m->scheduled_at->gte($today)
                                );
                                if ($hasFuture) { $activeIdx = $idx; break; }
                            }
                        @endphp

                        <div x-data="{ activeRound: {{ $activeIdx }} }"
                             x-init="$nextTick(() => {
                                 const bar = $el.querySelector('[data-round-bar]');
                                 const active = bar?.querySelector('[data-active]');
                                 if (active) active.scrollIntoView({ inline: 'center', block: 'nearest' });
                             })"
                             class="mb-10">

                            @if($matchesByPhaseAndRound->count() > 1)
                                <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                                    <span class="w-1.5 h-8 rounded-full inline-block shrink-0" style="background: var(--color-primary)"></span>
                                    {{ $phaseName }}
                                </h2>
                            @endif

                            {{-- Round pill navigation --}}
                            <div class="flex items-center gap-2 mb-5">
                                {{-- Prev --}}
                                <button @click="activeRound = Math.max(0, activeRound - 1);
                                                $nextTick(() => { const a = $el.closest('[x-data]').querySelector('[data-active]'); if(a) a.scrollIntoView({inline:'center',block:'nearest'}); })"
                                        :disabled="activeRound === 0"
                                        class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>

                                {{-- Pills --}}
                                <div data-round-bar
                                     x-init="
                                         const el = $el;
                                         let isDown = false, startX = 0, scrollLeft = 0, moved = false;
                                         el.addEventListener('mousedown', e => {
                                             isDown = true; moved = false;
                                             el.style.cursor = 'grabbing';
                                             startX = e.pageX - el.offsetLeft;
                                             scrollLeft = el.scrollLeft;
                                         });
                                         document.addEventListener('mouseup', () => {
                                             isDown = false;
                                             el.style.cursor = '';
                                         });
                                         el.addEventListener('mousemove', e => {
                                             if (!isDown) return;
                                             e.preventDefault();
                                             moved = true;
                                             el.scrollLeft = scrollLeft - (e.pageX - el.offsetLeft - startX);
                                         });
                                         el.addEventListener('click', e => { if (moved) { e.stopPropagation(); moved = false; } }, true);
                                     "
                                     class="flex-1 overflow-x-auto [&::-webkit-scrollbar]:hidden flex gap-2 py-1 px-0.5 snap-x snap-proximity scroll-smooth cursor-grab"
                                     style="scrollbar-width:none;-ms-overflow-style:none;touch-action:pan-x;-webkit-overflow-scrolling:touch">
                                    @foreach($roundKeys as $idx => $rLabel)
                                        <button @click="activeRound = {{ $idx }}"
                                                {{ $idx === $activeIdx ? 'data-active' : '' }}
                                                :data-active="activeRound === {{ $idx }} ? '' : null"
                                                :class="activeRound === {{ $idx }}
                                                    ? 'bg-gray-900 text-white shadow-md scale-110'
                                                    : 'bg-white text-gray-500 border border-gray-200 hover:border-gray-400 hover:text-gray-800'"
                                                class="shrink-0 snap-center w-10 h-10 rounded-full font-black text-sm transition-all duration-200">
                                            {{ $idx + 1 }}
                                        </button>
                                    @endforeach
                                </div>

                                {{-- Next --}}
                                <button @click="activeRound = Math.min({{ $roundCount - 1 }}, activeRound + 1);
                                                $nextTick(() => { const a = $el.closest('[x-data]').querySelector('[data-active]'); if(a) a.scrollIntoView({inline:'center',block:'nearest'}); })"
                                        :disabled="activeRound === {{ $roundCount - 1 }}"
                                        class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 disabled:opacity-30 disabled:cursor-not-allowed transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Matches per round --}}
                            @foreach($roundKeys as $idx => $rLabel)
                                <div x-show="activeRound === {{ $idx }}"
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-x-2"
                                     x-transition:enter-end="opacity-100 translate-x-0">

                                    {{-- Round label + date range --}}
                                    @php
                                        $rMatches     = $rounds[$rLabel];
                                        $dates        = $rMatches->filter(fn($m) => $m->scheduled_at)->sortBy('scheduled_at');
                                        $firstDate    = $dates->first()?->scheduled_at;
                                        $lastDate     = $dates->last()?->scheduled_at;
                                        $dateLabel    = null;
                                        if ($firstDate) {
                                            $dateLabel = $firstDate->isSameDay($lastDate)
                                                ? $firstDate->locale('es')->translatedFormat('d \d\e F Y')
                                                : $firstDate->locale('es')->translatedFormat('d M') . ' – ' . $lastDate->locale('es')->translatedFormat('d M Y');
                                        }
                                        $busyIds      = $rMatches->flatMap(fn($m) => [$m->home_team_id, $m->away_team_id])->filter()->unique();
                                        $restingTeams = $phaseTeams->whereNotIn('id', $busyIds);
                                    @endphp
                                    <div class="flex items-center gap-3 mb-3 px-1">
                                        <p class="text-base font-black text-gray-900 uppercase tracking-wide">{{ $rLabel }}</p>
                                        @if($dateLabel)
                                            <span class="text-xs text-gray-400 font-medium">{{ $dateLabel }}</span>
                                        @endif
                                        <div class="flex-1 h-px bg-gray-100"></div>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        @foreach($rMatches as $match)
                                            @php
                                                $isCompleted = $match->status === 'completed';
                                                $homeTotal   = ($match->home_score ?? 0) + ($match->home_score_extra ?? 0);
                                                $awayTotal   = ($match->away_score ?? 0) + ($match->away_score_extra ?? 0);
                                                $homeWins    = $isCompleted && $homeTotal > $awayTotal;
                                                $awayWins    = $isCompleted && $awayTotal > $homeTotal;
                                                if ($match->penalty_winner === 'home') { $homeWins = true; $awayWins = false; }
                                                if ($match->penalty_winner === 'away') { $awayWins = true; $homeWins = false; }
                                            @endphp
                                            <div class="bg-white border border-gray-100 rounded-2xl px-3 sm:px-6 py-3 sm:py-4 flex items-center gap-2 sm:gap-4 shadow-sm hover:shadow-md hover:border-gray-200 transition-all duration-150">

                                                {{-- Date --}}
                                                <div class="w-20 shrink-0 text-center hidden md:block">
                                                    @if($match->scheduled_at)
                                                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                                                            {{ $match->scheduled_at->locale('es')->translatedFormat('d M') }}
                                                           
                                                        </div>
                                                        <div class="text-gray-400 text-xs">{{ $match->scheduled_at->format('H:i') }}</div>
                                                         @php
                                                           
                                                            $matchDate = $match->scheduled_at->locale('es')->translatedFormat('d M')." - ".$match->scheduled_at->format('H:i');
                                                           
                                                        @endphp

                                                    @else
                                                        <div class="text-gray-200 text-xs">&mdash;</div>
                                                        @php
                                                            $matchDate = null;
                                                        @endphp
                                                    @endif
                                                </div>

                                                {{-- Match --}}
                                                <div class="flex-1 flex items-center gap-1.5 sm:gap-3 min-w-0">
                                                    {{-- Home --}}
                                                    <div class="flex-1 flex items-center justify-end gap-1.5 sm:gap-2 min-w-0">
                                                        <span class="text-xs sm:text-sm font-bold truncate
                                                            {{ $homeWins ? 'text-gray-900' : ($isCompleted ? 'text-gray-400' : 'text-gray-700') }}">
                                                            {{ $match->homeTeam?->displayName() ?? 'Por definir' }}
                                                        </span>
                                                        {{-- Home shield --}}
                                                        <div class="shrink-0 w-7 h-7 sm:w-8 sm:h-8 rounded-lg overflow-hidden border {{ $homeWins ? 'border-gray-200' : 'border-gray-100' }} bg-gray-50 flex items-center justify-center">
                                                            @if($match->homeTeam?->logo)
                                                            
                                                                <img src="{{ Storage::url($match->homeTeam->logo) }}"
                                                                     alt="{{ $match->homeTeam->displayName() }}"
                                                                     class="w-full h-full object-contain {{ $isCompleted && !$homeWins ? 'opacity-40 grayscale' : '' }}">
                                                            @else
                                                                <span class="text-[10px] font-black text-gray-400">
                                                                    {{ mb_strtoupper(mb_substr($match->homeTeam?->displayName() ?? '?', 0, 1)) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Score --}}
                                                    <div class="shrink-0 flex items-center gap-0.5 sm:gap-1">
                                                        @if($isCompleted)
                                                            <span class="text-lg sm:text-xl font-black {{ $homeWins ? 'text-gray-900' : 'text-gray-300' }} w-5 sm:w-6 text-center">{{ $match->home_score ?? 0 }}</span>
                                                            <span class="text-gray-300 font-bold text-lg sm:text-xl">:</span>
                                                            <span class="text-lg sm:text-xl font-black {{ $awayWins ? 'text-gray-900' : 'text-gray-300' }} w-5 sm:w-6 text-center">{{ $match->away_score ?? 0 }}</span>
                                                            @if($match->home_score_extra !== null || $match->away_score_extra !== null)
                                                                <span class="text-gray-300 text-xs ml-1 hidden sm:inline">({{ ($match->home_score_extra ?? 0) }}:{{ ($match->away_score_extra ?? 0) }})</span>
                                                            @endif
                                                            @if($match->penalty_winner)
                                                                <span class="text-amber-500 text-xs ml-0.5 font-bold">P</span>
                                                            @endif
                                                        @else
                                                            @php
                                                                $stColors = ['scheduled'=>'text-blue-500','in_progress'=>'text-yellow-500','postponed'=>'text-orange-400','cancelled'=>'text-red-400'];
                                                            @endphp
                                                            <span class="px-1.5 sm:px-2.5 py-1 rounded-lg bg-gray-100 text-[10px] sm:text-xs font-bold uppercase tracking-wide {{ $stColors[$match->status] ?? 'text-gray-400' }}">
                                                                @if($matchDate)
                                                                   {{ $match->statusLabel() }} </br>  {{ $matchDate }} 
                                                                @else
                                                                   {{ $match->statusLabel() }}
                                                                @endif
                                                            </span>
                                                        @endif
                                                    </div>

                                                    {{-- Away --}}
                                                    <div class="flex-1 flex items-center justify-start gap-1.5 sm:gap-2 min-w-0">
                                                        {{-- Away shield --}}
                                                        <div class="shrink-0 w-7 h-7 sm:w-8 sm:h-8 rounded-lg overflow-hidden border {{ $awayWins ? 'border-gray-200' : 'border-gray-100' }} bg-gray-50 flex items-center justify-center">
                                                            @if($match->awayTeam?->logo)
                                                                <img src="{{ Storage::url($match->awayTeam->logo) }}"
                                                                     alt="{{ $match->awayTeam->displayName() }}"
                                                                     class="w-full h-full object-contain {{ $isCompleted && !$awayWins ? 'opacity-40 grayscale' : '' }}">
                                                            @else
                                                                <span class="text-[10px] font-black text-gray-400">
                                                                    {{ mb_strtoupper(mb_substr($match->awayTeam?->displayName() ?? '?', 0, 1)) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <span class="text-xs sm:text-sm font-bold truncate
                                                            {{ $awayWins ? 'text-gray-900' : ($isCompleted ? 'text-gray-400' : 'text-gray-700') }}">
                                                            {{ $match->awayTeam?->displayName() ?? 'Por definir' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Location --}}
                                                @if($match->location)
                                                    <div class="hidden lg:block text-xs text-gray-300 font-semibold uppercase tracking-wider shrink-0 max-w-36 truncate">
                                                        {{ $match->location }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        {{-- Bye rows: teams resting this round --}}
                                        @foreach($restingTeams as $restingTeam)
                                            <div class="border border-dashed border-amber-300 bg-amber-50/70 rounded-2xl px-3 sm:px-6 py-3 sm:py-4 flex items-center gap-3">
                                                {{-- Moon icon --}}
                                                <div class="shrink-0 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-100 border border-amber-200 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                                    </svg>
                                                </div>
                                                {{-- Team logo + name --}}
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    <div class="shrink-0 w-7 h-7 sm:w-8 sm:h-8 rounded-lg overflow-hidden border border-amber-200 bg-white flex items-center justify-center">
                                                        @if($restingTeam->logo)
                                                            <img src="{{ Storage::url($restingTeam->logo) }}"
                                                                 alt="{{ $restingTeam->displayName() }}"
                                                                 class="w-full h-full object-contain opacity-70">
                                                        @else
                                                            <span class="text-[10px] font-black text-amber-500">
                                                                {{ mb_strtoupper(mb_substr($restingTeam->displayName(), 0, 1)) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="text-sm font-bold text-amber-900 truncate">{{ $restingTeam->displayName() }}</span>
                                                </div>
                                                {{-- Badge --}}
                                                <span class="shrink-0 text-[10px] sm:text-xs font-black uppercase tracking-widest text-amber-700 bg-amber-100 border border-amber-200 px-2.5 py-1 rounded-full">
                                                    Descansa
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- --------------- TAB: CLASIFICACION --------------- --}}
            <div x-show="tab === 'clasificacion'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                @if($standings->isEmpty())
                    <div class="text-center py-24 bg-gray-50 border border-gray-100 rounded-2xl">
                        <div class="text-6xl mb-4 opacity-10">??</div>
                        <p class="text-gray-400 text-lg font-semibold">La clasificacion no esta disponible aun.</p>
                    </div>
                @else
                    <div class="space-y-10">
                        @foreach($standings as $groupName => $groupStandings)
                            <div>
                                @if($standings->count() > 1)
                                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                                        <span class="w-1.5 h-7 rounded-full inline-block shrink-0" style="background: var(--color-primary)"></span>
                                        {{ $groupName }}
                                    </h2>
                                @endif

                                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm shadow-gray-200/60">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead>
                                                        <tr class="border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider font-bold">
                                                                    <th class="text-left px-3 sm:px-5 py-3 w-8">Pos</th>
                                                                    <th class="text-left px-3 sm:px-5 py-3">Equipo</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3">PJ</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3">G</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3">E</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3">P</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3 hidden sm:table-cell">GF</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3 hidden sm:table-cell">GC</th>
                                                                    <th class="text-center px-2 sm:px-3 py-3 hidden xs:table-cell sm:table-cell">DG</th>
                                                                    <th class="text-center px-3 sm:px-4 py-3 text-gray-600">Pts</th>
                                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50">
                                                @foreach($groupStandings as $i => $standing)
                                                    <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                                                        <td class="px-3 sm:px-5 py-3 text-center">
                                                            @if($i === 0)
                                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black text-white"
                                                                      style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">1</span>
                                                            @elseif($i === 1)
                                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black bg-gray-400 text-white">2</span>
                                                            @elseif($i === 2)
                                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-black bg-amber-600 text-white">3</span>
                                                            @else
                                                                <span class="text-gray-300 font-bold text-xs">{{ $i + 1 }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 sm:px-5 py-3">
                                                            <span class="text-gray-900 font-semibold text-xs sm:text-sm">{{ $standing->tournamentTeam?->displayName() ?? '&mdash;' }}</span>
                                                        </td>
                                                        <td class="px-2 sm:px-3 py-3 text-center text-gray-500 text-xs sm:text-sm">{{ $standing->played }}</td>
                                                        <td class="px-2 sm:px-3 py-3 text-center text-green-600 font-semibold text-xs sm:text-sm">{{ $standing->won }}</td>
                                                        <td class="px-2 sm:px-3 py-3 text-center text-gray-400 text-xs sm:text-sm">{{ $standing->drawn }}</td>
                                                        <td class="px-2 sm:px-3 py-3 text-center text-red-500 font-semibold text-xs sm:text-sm">{{ $standing->lost }}</td>
                                                        <td class="px-2 sm:px-3 py-3 text-center text-gray-500 text-xs sm:text-sm hidden sm:table-cell">{{ $standing->goals_for }}</td>
                                                        <td class="px-2 sm:px-3 py-3 text-center text-gray-500 text-xs sm:text-sm hidden sm:table-cell">{{ $standing->goals_against }}</td>
                                                        <td class="px-2 sm:px-3 py-3 text-center font-semibold text-xs sm:text-sm hidden xs:table-cell sm:table-cell {{ ($standing->goals_for - $standing->goals_against) >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                                            {{ ($standing->goals_for - $standing->goals_against) >= 0 ? '+' : '' }}{{ $standing->goals_for - $standing->goals_against }}
                                                        </td>
                                                        <td class="px-3 sm:px-4 py-3 text-center">
                                                            <span class="text-gray-900 font-black text-sm sm:text-base">{{ $standing->points }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- --------------- TAB: EQUIPOS --------------- --}}
            <div x-show="tab === 'equipos'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                @if($teams->isEmpty())
                    <div class="text-center py-24 bg-gray-50 border border-gray-100 rounded-2xl">
                        <div class="text-6xl mb-4 opacity-10">??</div>
                        <p class="text-gray-400 text-lg font-semibold">Aun no hay equipos inscritos.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($teams as $tt)
                            @php
                                $teamSc = [
                                    'registered'   => ['bg' => 'bg-blue-100',  'text' => 'text-blue-700',  'label' => 'Inscrito'],
                                    'confirmed'    => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Confirmado'],
                                    'eliminated'   => ['bg' => 'bg-gray-100',  'text' => 'text-gray-500',  'label' => 'Eliminado'],
                                    'disqualified' => ['bg' => 'bg-red-100',   'text' => 'text-red-600',   'label' => 'Descalificado'],
                                ][$tt->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-500', 'label' => $tt->status];
                                $approvedPlayers = $tt->players;
                                $playersJson = $approvedPlayers->map(fn($p) => [
                                    'name'     => $p->fullName(),
                                    'dorsal'   => $p->dorsal,
                                    'position' => $p->position,
                                    'photo'    => $p->photoUrl(),
                                ])->values()->toJson();
                            @endphp
                            <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm shadow-gray-200/60 hover:shadow-md transition-all duration-200 cursor-pointer select-none"
                                 style="border: 1.5px solid color-mix(in srgb, var(--color-primary) 35%, transparent)"
                                 @click="modalTeam = @js($tt->displayName()); modalPlayers = {{ $playersJson }}; teamModal = true">
                                <div class="w-12 h-12 rounded-xl shrink-0 border border-gray-100 overflow-hidden flex items-center justify-center"
                                     style="background: linear-gradient(135deg, color-mix(in srgb, var(--color-primary) 10%, white), color-mix(in srgb, var(--color-secondary) 10%, white))">
                                    @if($tt->logo)
                                        <img src="{{ Storage::url($tt->logo) }}" alt="{{ $tt->displayName() }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xl font-black text-gray-400 uppercase">{{ mb_substr($tt->displayName(), 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-gray-900 font-bold truncate">{{ $tt->displayName() }}</p>
                                    @if($tt->group_label)
                                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Grupo {{ $tt->group_label }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                                        <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full {{ $teamSc['bg'] }} {{ $teamSc['text'] }}">
                                            {{ $teamSc['label'] }}
                                        </span>
                                        @if($approvedPlayers->count() > 0)
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700">
                                                {{ $approvedPlayers->count() }} jugador{{ $approvedPlayers->count() !== 1 ? 'es' : '' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($tt->seed)
                                    <div class="shrink-0 text-right">
                                        <span class="text-gray-300 text-xs font-bold uppercase tracking-wider block">Cabeza</span>
                                        <span class="text-gray-600 font-black text-lg leading-none">#{{ $tt->seed }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ══ MODAL JUGADORES ══ --}}
            <div x-show="teamModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="teamModal = false"></div>
                {{-- Panel --}}
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[80vh] flex flex-col overflow-hidden"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.stop>
                    {{-- Header --}}
                    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100 shrink-0">
                        <div>
                            <h3 class="text-base font-black text-gray-900" x-text="modalTeam"></h3>
                            <p class="text-xs text-gray-400 font-semibold mt-0.5">
                                <span x-text="modalPlayers.length"></span> jugador<span x-text="modalPlayers.length !== 1 ? 'es' : ''"></span> aprobado<span x-text="modalPlayers.length !== 1 ? 's' : ''"></span>
                            </p>
                        </div>
                        <button @click="teamModal = false" class="p-1.5 rounded-xl text-gray-400 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Body --}}
                    <div class="overflow-y-auto flex-1 px-5 py-4">
                        <template x-if="modalPlayers.length === 0">
                            <p class="text-center text-gray-400 text-sm py-10 font-semibold">Sin jugadores aprobados todavía.</p>
                        </template>
                        <template x-if="modalPlayers.length > 0">
                            <ul class="divide-y divide-gray-50">
                                <template x-for="(player, index) in modalPlayers" :key="index">
                                    <li class="flex items-center gap-3 py-3">
                                        {{-- Foto / inicial --}}
                                        <div class="w-10 h-10 rounded-xl shrink-0 overflow-hidden border border-gray-100 flex items-center justify-center bg-gray-50">
                                            <template x-if="player.photo">
                                                <img :src="player.photo" :alt="player.name" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!player.photo">
                                                <span class="text-sm font-black text-gray-400 uppercase" x-text="player.name.charAt(0)"></span>
                                            </template>
                                        </div>
                                        {{-- Info --}}
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-bold text-gray-900 truncate" x-text="player.name"></p>
                                            <p class="text-xs text-gray-400 font-medium truncate" x-text="player.position || '—'"></p>
                                        </div>
                                        {{-- Dorsal --}}
                                        <template x-if="player.dorsal">
                                            <div class="shrink-0 w-8 h-8 rounded-lg flex items-center justify-center bg-gray-100">
                                                <span class="text-xs font-black text-gray-600" x-text="'#' + player.dorsal"></span>
                                            </div>
                                        </template>
                                    </li>
                                </template>
                            </ul>
                        </template>
                    </div>
                </div>
            </div>

        </div>
      

        {{-- ══════════════════════ BASES BOTTOM SHEET (mobile) ══════════════════════ --}}
        <div x-show="showBases" x-cloak
             class="md:hidden fixed inset-0 z-50 flex flex-col justify-end"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showBases = false"></div>
            <div class="relative bg-white rounded-t-3xl shadow-2xl max-h-[88vh] flex flex-col"
                 @click.stop>
                {{-- Handle --}}
                <div class="flex-shrink-0 pt-3 pb-4 px-5 border-b border-gray-100">
                    <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-3"></div>
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-black text-black">{{ $tournament->name }}</h2>
                        <button @click="showBases = false" class="p-1.5 rounded-xl text-gray-400 hover:bg-gray-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                {{-- Scrollable body --}}
                <div class="flex-1 overflow-y-auto px-5 py-5 space-y-4">
                    @if($tournament->description)
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Descripción</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $tournament->description }}</p>
                        </div>
                    @endif
                    <div class="space-y-3">
                        @if($tournament->start_date)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Fechas</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $tournament->start_date->locale('es')->translatedFormat('d M Y') }}@if($tournament->end_date) &mdash; {{ $tournament->end_date->locale('es')->translatedFormat('d M Y') }}@endif</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->location)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Sede</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $tournament->location }}</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->registration_deadline && $tournament->status === 'registration_open')
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Plazo inscripción</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $tournament->registration_deadline->locale('es')->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->registration_fee)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Inscripción</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ number_format($tournament->registration_fee, 2, ',', '.') }} &euro;</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->max_players_per_team)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jugadores por equipo</p>
                                    <p class="text-sm font-semibold text-gray-800">Máx. {{ $tournament->max_players_per_team }}</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->min_age)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Edad mínima</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $tournament->min_age }} años</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->player_registration_deadline)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alta jugadores hasta</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $tournament->player_registration_deadline->locale('es')->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($tournament->team_type)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Modalidad</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $tournament->team_type === 'school_teams' ? 'Escuelas Deportivas' : 'Torneo Abierto' }}</p>
                                </div>
                            </div>
                        @endif
                        @if($teams->count())
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Equipos inscritos</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $teams->count() }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Sticky CTA at bottom of sheet --}}
                @if($canRegister)
                    <div class="flex-shrink-0 bg-white border-t border-gray-100 px-5 py-4">
                        <a href="{{ route('webclubs.team.register', $tournament) }}"
                           class="flex items-center justify-center gap-2 w-full py-3 rounded-2xl text-white font-bold text-sm shadow active:opacity-80"
                           style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Inscribir equipo
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══════════════════════ MOBILE FIXED BOTTOM NAV ══════════════════════ --}}
        <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-sm border-t border-gray-100"
             style="padding-bottom: env(safe-area-inset-bottom, 0px)">
            <div class="flex">
                <button @click="tab = 'partidos'"
                        :class="tab === 'partidos' ? 'text-gray-900' : 'text-gray-400'"
                        class="flex-1 flex flex-col items-center justify-center py-3 gap-0.5 transition-colors relative">
                    <span :class="tab === 'partidos' ? 'opacity-100' : 'opacity-0'"
                          class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded-full transition-opacity"
                          style="background: var(--color-primary)"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Partidos</span>
                </button>
                <button @click="tab = 'clasificacion'"
                        :class="tab === 'clasificacion' ? 'text-gray-900' : 'text-gray-400'"
                        class="flex-1 flex flex-col items-center justify-center py-3 gap-0.5 transition-colors relative">
                    <span :class="tab === 'clasificacion' ? 'opacity-100' : 'opacity-0'"
                          class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded-full transition-opacity"
                          style="background: var(--color-primary)"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Clasificación</span>
                </button>
                <button @click="tab = 'equipos'"
                        :class="tab === 'equipos' ? 'text-gray-900' : 'text-gray-400'"
                        class="flex-1 flex flex-col items-center justify-center py-3 gap-0.5 transition-colors relative">
                    <span :class="tab === 'equipos' ? 'opacity-100' : 'opacity-0'"
                          class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 rounded-full transition-opacity"
                          style="background: var(--color-primary)"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Equipos</span>
                </button>
            </div>
        </nav>

        {{-- Patrocinadores --}}
        <x-webclubs.sponsors />
    </main>

</div>