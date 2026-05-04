<div>
    <main class="min-h-screen bg-white">

        {{-- Hero header --}}
        <section class="pt-8 pb-8 md:pt-16 md:pb-14 relative overflow-hidden">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12 relative z-10">
                <a href="{{ route('webclubs.home') }}"
                   class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-6 md:mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Inicio
                </a>
                <h2 class="text-xs sm:text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/40 font-semibold mb-3 md:mb-5">Competicion</h2>
                <h1 class="section-title text-5xl sm:text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">Torneos</h1>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        {{-- Tournament grid --}}
        <section class="py-10 md:py-20">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">

                @if($tournaments->isEmpty())
                    <div class="text-center py-16 md:py-32">
                        <div class="text-8xl mb-6 opacity-10">🏆</div>
                        <p class="text-black/30 text-xl font-semibold">No hay torneos disponibles actualmente.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
                        @foreach($tournaments as $index => $tournament)
                            @php
                                $statusColors = [
                                    'registration_open' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'label' => 'Inscripciones abiertas'],
                                    'in_progress'       => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'label' => 'En curso'],
                                    'completed'         => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Finalizado'],
                                    'draft'             => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'label' => 'Proximamente'],
                                ];
                                $sc = $statusColors[$tournament->status] ?? $statusColors['draft'];
                            @endphp
                            <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
                               class="group bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm shadow-gray-200/60 hover:shadow-xl hover:shadow-gray-200/80 hover:-translate-y-1 transition-all duration-500 flex flex-col">

                                {{-- Banner --}}
                                <div class="relative h-36 sm:h-44 flex items-center justify-center overflow-hidden"
                                     style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);">
                                    @if($tournament->logo)
                                        <img src="{{ Storage::url($tournament->logo) }}"
                                             alt="{{ $tournament->name }}"
                                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="text-white/30 text-8xl font-black select-none group-hover:scale-105 transition-transform duration-500">🏆</div>
                                    @endif
                                    <span class="absolute top-3 right-3 {{ $sc['bg'] }} {{ $sc['text'] }} text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                                        {{ $sc['label'] }}
                                    </span>
                                </div>

                                {{-- Content --}}
                                <div class="p-4 sm:p-6 flex flex-col flex-1">
                                    <h2 class="text-base sm:text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors duration-300">
                                        {{ $tournament->name }}
                                    </h2>

                                    @if($tournament->description)
                                        <p class="text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2">{{ $tournament->description }}</p>
                                    @endif

                                    <div class="space-y-2 text-xs text-gray-400 font-semibold uppercase tracking-wider mt-auto">
                                        @if($tournament->start_date)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ $tournament->start_date->locale('es')->translatedFormat('d M Y') }}@if($tournament->end_date) — {{ $tournament->end_date->locale('es')->translatedFormat('d M Y') }}@endif</span>
                                            </div>
                                        @endif
                                        @if($tournament->location)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span>{{ $tournament->location }}</span>
                                            </div>
                                        @endif
                                        @if($tournament->tournament_teams_count)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span>{{ $tournament->tournament_teams_count }} equipos inscritos</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-5 flex items-center gap-1.5 font-bold text-sm text-primary/60 group-hover:text-primary transition-colors duration-300">
                                        <span>Ver torneo</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Bottom accent --}}
                                <div class="h-0.5 w-0 group-hover:w-full transition-all duration-500"
                                     style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary))"></div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- Patrocinadores --}}
        <x-webclubs.sponsors />

    </main>
</div>