<div>
        {{-- Hero header --}}
        <section class=" pb-3  md:pb-14 relative overflow-hidden">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12 relative z-10">
                <a href="{{ route('webclubs.home') }}"
                   class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-6 md:mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Inicio
                </a>
                {{-- <h2 class="text-xs sm:text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/40 font-semibold mb-3 md:mb-5">Organizado por {{ tenantName() }}</h2> --}}
                <h1 class="section-title text-5xl sm:text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">Torneos</h1>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        {{-- Tournament grid --}}
        <section class="py-5 md:py-5">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">

                @if($tournaments->isEmpty())
                    <div class="text-center py-16 md:py-32">
                        <div class="text-8xl mb-6 opacity-10">🏆</div>
                        <p class="text-black/30 text-xl font-semibold">No hay torneos disponibles actualmente.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                        @foreach($tournaments as $index => $tournament)
                            @php
                                $statusColors = [
                                    'registration_open' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'label' => 'Inscripciones abiertas'],
                                    'in_progress'       => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'label' => 'En curso'],
                                    'completed'         => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Finalizado'],
                                    'draft'             => ['bg' => 'bg-gray-100',   'text' => 'text-gray-500',   'label' => 'Próximamente'],
                                ];
                                $sc = $statusColors[$tournament->status] ?? $statusColors['draft'];
                            @endphp
                            
                            <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
                            class="group relative bg-white rounded-3xl overflow-hidden border border-slate-200/80 transition-all duration-500 shadow-xl shadow-slate-200/60 hover:shadow-2xl hover:shadow-slate-300/80 hover:-translate-y-1 flex flex-col"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                                {{-- Banner con Degradado de Fusión --}}
                                <div class="relative h-48 sm:h-52 flex items-center justify-center overflow-hidden"
                                    style="background: linear-gradient(135deg, var(--color-primary, #1e293b) 0%, var(--color-secondary, #0f172a) 100%);">
                                    @if($tournament->logo)
                                        <img src="{{ Storage::url($tournament->logo) }}"
                                            alt="{{ $tournament->name }}"
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out opacity-90">
                                    @else
                                        <div class="text-white/30 text-8xl font-black select-none group-hover:scale-110 transition-transform duration-700 ease-out">🏆</div>
                                    @endif
                                    
                                    <!-- Fusión hacia abajo con el cuerpo blanco de la card -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-white via-white/20 to-transparent z-10"></div>

                                    <!-- Etiqueta de Estado -->
                                    <span class="absolute top-4 right-4 z-20 {{ $sc['bg'] }} {{ $sc['text'] }} text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                                        {{ $sc['label'] }}
                                    </span>
                                </div>

                                {{-- Contenido --}}
                                <div class="p-6 sm:p-8 flex-grow flex flex-col relative z-20 -mt-6">
                                    <!-- Título -->
                                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mb-3 uppercase tracking-wide group-hover:text-primary transition-colors duration-300 line-clamp-2">
                                        {{ $tournament->name }}
                                    </h2>

                                    <!-- Descripción -->
                                    @if($tournament->description)
                                        <p class="text-sm text-slate-600 font-medium leading-relaxed mb-6 line-clamp-2">
                                            {{ $tournament->description }}
                                        </p>
                                    @endif

                                    <!-- Meta Información (Fechas, Ubicación, Equipos) -->
                                    <div class="space-y-3 text-xs sm:text-sm text-slate-500 font-semibold mt-auto mb-8">
                                        @if($tournament->start_date)
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <span>{{ $tournament->start_date->locale('es')->translatedFormat('d M Y') }}@if($tournament->end_date) — {{ $tournament->end_date->locale('es')->translatedFormat('d M Y') }}@endif</span>
                                            </div>
                                        @endif
                                        
                                        @if($tournament->location)
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                </div>
                                                <span class="truncate">{{ $tournament->location }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($tournament->tournament_teams_count)
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                </div>
                                                <span>{{ $tournament->tournament_teams_count }} equipos inscritos</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Botón de acción -->
                                    <div class="mt-auto block w-full relative overflow-hidden rounded-xl bg-slate-50 border border-slate-100 group-hover:border-blue-200 transition-colors duration-300">
                                        <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative flex items-center justify-center gap-2 py-3 px-4 text-slate-600 group-hover:text-blue-700 font-bold uppercase tracking-widest text-sm transition-colors">
                                            <span>Ver torneo</span>
                                            <svg class="w-5 h-5 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Línea de acento inferior con gradiente CSS custom --}}
                                <div class="absolute bottom-0 left-0 h-1 w-0 group-hover:w-full transition-all duration-500 z-30"
                                    style="background: linear-gradient(to right, var(--color-primary, #2563eb), var(--color-secondary, #4f46e5))"></div>
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