<div>
    <main class="max-w-4xl mx-auto px-4 py-8 sm:py-12">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
            <div class="flex items-center gap-4">
                {{-- Team logo or placeholder --}}
                <div class="w-16 h-16 rounded-2xl overflow-hidden flex items-center justify-center shrink-0 border border-gray-100"
                     style="background: linear-gradient(135deg, color-mix(in srgb, var(--color-primary) 15%, white), color-mix(in srgb, var(--color-secondary) 15%, white))">
                    @if($team->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($team->logo))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($team->logo) }}"
                             alt="{{ $team->displayName() }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl">🛡️</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">{{ $tournament->name }}</p>
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">{{ $team->displayName() }}</h1>
                    @php
                        $statusMap = [
                            'registered'   => ['label' => 'Inscrito',       'bg' => 'bg-blue-100',  'text' => 'text-blue-700'],
                            'confirmed'    => ['label' => 'Confirmado',     'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                            'eliminated'   => ['label' => 'Eliminado',      'bg' => 'bg-gray-100',  'text' => 'text-gray-500'],
                            'disqualified' => ['label' => 'Descalificado',  'bg' => 'bg-red-100',   'text' => 'text-red-600'],
                        ];
                        $sc = $statusMap[$team->status] ?? ['label' => $team->status, 'bg' => 'bg-gray-100', 'text' => 'text-gray-500'];
                    @endphp
                    <span class="inline-block mt-1.5 text-[10px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}">
                        {{ $sc['label'] }}
                    </span>
                </div>
            </div>

            <button wire:click="logout"
                    class="flex items-center gap-2 px-4 py-2 rounded-2xl border border-gray-200 text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar sesión
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

            {{-- Contact info --}}
            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm shadow-gray-200/60">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider">Contacto</h2>
                </div>
                <div class="space-y-3">
                    @if($team->contact_name)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Responsable</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->contact_name }}</p>
                        </div>
                    @endif
                    @if($team->contact_phone)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Teléfono</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->contact_phone }}</p>
                        </div>
                    @endif
                    @if($team->email)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->email }}</p>
                        </div>
                    @endif
                    @if(!$team->contact_name && !$team->contact_phone && !$team->email)
                        <p class="text-sm text-gray-400">Sin datos de contacto.</p>
                    @endif
                </div>
            </div>

            {{-- Tournament info --}}
            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm shadow-gray-200/60">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                         style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider">Torneo</h2>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nombre</p>
                        <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $tournament->name }}</p>
                    </div>
                    @if($team->group_label)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Grupo</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">Grupo {{ $team->group_label }}</p>
                        </div>
                    @endif
                    @if($team->seed)
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Cabeza de serie</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">#{{ $team->seed }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Inscripción</p>
                        <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Players section (placeholder) --}}
        <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 shadow-sm shadow-gray-200/60">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider">Jugadores</h2>
                </div>
            </div>

            <div class="text-center py-12 bg-gray-50/60 rounded-2xl border border-dashed border-gray-200">
                <div class="text-5xl mb-3 opacity-20">👥</div>
                <p class="text-gray-500 font-semibold text-sm">Gestión de jugadores próximamente</p>
                <p class="text-gray-400 text-xs mt-1">Podrás añadir y gestionar los jugadores de tu equipo desde aquí.</p>
            </div>
        </div>

        {{-- Back link --}}
        <div class="mt-6 text-center">
            <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
               class="text-sm text-gray-400 hover:text-gray-600 font-semibold transition-colors inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Ver el torneo
            </a>
        </div>

    </main>
</div>
