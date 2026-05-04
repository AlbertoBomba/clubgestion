<div>
    <main class="min-h-screen bg-white">

        {{-- Hero header --}}
        <section class="pt-8 pb-8 md:pt-16 md:pb-12 border-b border-gray-100">
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

                        {{-- Registration CTA --}}
                        @if($canRegister)
                            <div class="mt-6">
                                <a href="{{ route('webclubs.team.register', $tournament) }}"
                                   class="inline-flex items-center gap-2.5 px-6 py-3 rounded-2xl text-white font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all duration-150"
                                   style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Inscribir equipo
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Tabs --}}
        <div x-data="{ tab: 'partidos' }" class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-12 py-6 md:py-10">

            {{-- Tab nav --}}
            <div class="flex gap-1 bg-gray-100 rounded-2xl p-1.5 mb-6 md:mb-10 w-full md:w-fit">
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
                        <div class="mb-10">
                            @if($matchesByPhaseAndRound->count() > 1)
                                <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                                    <span class="w-1.5 h-8 rounded-full inline-block shrink-0" style="background: var(--color-primary)"></span>
                                    {{ $phaseName }}
                                </h2>
                            @endif

                            {{-- Accordion per round --}}
                            <div class="space-y-3">
                                @foreach($rounds as $roundLabel => $roundMatches)
                                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }"
                                         class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm shadow-gray-200/60">

                                        {{-- Accordion header --}}
                                        <button @click="open = !open"
                                                class="w-full flex items-center justify-between px-4 sm:px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                                <span class="w-8 h-8 rounded-xl flex items-center justify-center text-white font-bold text-sm shrink-0"
                                                      style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                                    {{ $loop->iteration }}
                                                </span>
                                                <span class="text-gray-900 font-bold uppercase tracking-wide text-sm truncate">{{ $roundLabel }}</span>
                                                <span class="text-gray-400 text-xs font-semibold shrink-0">{{ $roundMatches->count() }} {{ $roundMatches->count() === 1 ? 'partido' : 'partidos' }}</span>
                                            </div>
                                            <svg :class="open ? 'rotate-180' : ''"
                                                 class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>

                                        {{-- Accordion body --}}
                                        <div x-show="open" x-collapse class="border-t border-gray-100">
                                            <div class="divide-y divide-gray-50">
                                                @foreach($roundMatches as $match)
                                                    @php
                                                        $isCompleted = $match->status === 'completed';
                                                        $homeTotal = ($match->home_score ?? 0) + ($match->home_score_extra ?? 0);
                                                        $awayTotal = ($match->away_score ?? 0) + ($match->away_score_extra ?? 0);
                                                        $homeWins  = $isCompleted && $homeTotal > $awayTotal;
                                                        $awayWins  = $isCompleted && $awayTotal > $homeTotal;
                                                        if ($match->penalty_winner === 'home') { $homeWins = true; $awayWins = false; }
                                                        if ($match->penalty_winner === 'away') { $awayWins = true; $homeWins = false; }
                                                    @endphp
                                                <div class="px-3 sm:px-6 py-3 sm:py-4 flex items-center gap-2 sm:gap-4 hover:bg-gray-50/50 transition-colors duration-150">

                                                        {{-- Date --}}
                                                        <div class="w-20 shrink-0 text-center hidden md:block">
                                                            @if($match->scheduled_at)
                                                                <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                                                                    {{ $match->scheduled_at->locale('es')->translatedFormat('d M') }}
                                                                </div>
                                                                <div class="text-gray-400 text-xs">{{ $match->scheduled_at->format('H:i') }}</div>
                                                            @else
                                                                <div class="text-gray-200 text-xs">&mdash;</div>
                                                            @endif
                                                        </div>

                                                        {{-- Match --}}
                                                        <div class="flex-1 flex items-center gap-1.5 sm:gap-2 min-w-0">
                                                            {{-- Home --}}
                                                            <div class="flex-1 text-right min-w-0">
                                                                <span class="text-xs sm:text-sm font-bold truncate block
                                                                    {{ $homeWins ? 'text-gray-900' : ($isCompleted ? 'text-gray-400' : 'text-gray-700') }}">
                                                                    {{ $match->homeTeam?->displayName() ?? 'Por definir' }}
                                                                </span>
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
                                                                        {{ $match->statusLabel() }}
                                                                    </span>
                                                                @endif
                                                            </div>

                                                            {{-- Away --}}
                                                            <div class="flex-1 text-left min-w-0">
                                                                <span class="text-xs sm:text-sm font-bold truncate block
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
                            @endphp
                            <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-4 shadow-sm shadow-gray-200/60 hover:shadow-md hover:shadow-gray-200/80 transition-all duration-200">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl shrink-0 border border-gray-100"
                                     style="background: linear-gradient(135deg, color-mix(in srgb, var(--color-primary) 10%, white), color-mix(in srgb, var(--color-secondary) 10%, white))">
                                    ???
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-gray-900 font-bold truncate">{{ $tt->displayName() }}</p>
                                    @if($tt->group_label)
                                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Grupo {{ $tt->group_label }}</p>
                                    @endif
                                    <span class="inline-block mt-1 text-[10px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full {{ $teamSc['bg'] }} {{ $teamSc['text'] }}">
                                        {{ $teamSc['label'] }}
                                    </span>
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

        </div>
        {{-- Patrocinadores --}}
        <x-webclubs.sponsors />

    </main>

</div>