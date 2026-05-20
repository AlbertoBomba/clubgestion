<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-3 sm:px-4 lg:px-6 max-w-5xl mx-auto">

    {{-- Flash --}}
    @if (session('stats_message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show"
             class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('stats_message') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-4 sm:p-5 mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('tournaments.show', $tournament) }}" wire:navigate
               class="p-1.5 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <p class="text-xs text-titanium">{{ $tournament->name }}</p>
                <h1 class="text-lg sm:text-xl font-bold text-black-deep">Estadísticas del Torneo</h1>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 bg-white-pure border border-silver rounded-2xl shadow-sm p-1 mb-4">
        <button wire:click="setTab('scorers')"
                class="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl text-sm font-semibold transition-all
                       {{ $activeTab === 'scorers' ? 'bg-primary text-white shadow' : 'text-titanium hover:text-black-deep hover:bg-gray-50' }}">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8" stroke="none"/><path fill="white" d="M10 3a7 7 0 100 14A7 7 0 0010 3zm0 1.5c.9 0 1.8.2 2.6.6L11.7 8l-1.7.6L8.3 8 7.4 5.1A5.5 5.5 0 0110 4.5zM5.1 6.5l1.7 1-.5 1.8L4.7 11A5.5 5.5 0 015.1 6.5zm.8 7l.9-2.7h3L10.7 13 9.8 15.4a5.5 5.5 0 01-3.9-1.9zm5.9 1.9L10.9 13l.9-2.2h3l.9 2.8a5.5 5.5 0 01-3.9 1.9zm4.2-3.4L14.4 9.3l-.5-1.8 1.7-1A5.5 5.5 0 0115 14z"/></svg>
            Goleadores
        </button>
        <button wire:click="setTab('cards')"
                class="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl text-sm font-semibold transition-all
                       {{ $activeTab === 'cards' ? 'bg-amber-500 text-white shadow' : 'text-titanium hover:text-black-deep hover:bg-gray-50' }}">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><rect x="6" y="2" width="12" height="18" rx="2"/></svg>
            Tarjetas
        </button>
        <button wire:click="setTab('sanctions')"
                class="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl text-sm font-semibold transition-all
                       {{ $activeTab === 'sanctions' ? 'bg-red-500 text-white shadow' : 'text-titanium hover:text-black-deep hover:bg-gray-50' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            Sanciones
        </button>
    </div>

    {{-- ======================== SCORERS TAB ======================== --}}
    @if ($activeTab === 'scorers')
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-silver bg-gray-50/50">
                <h2 class="font-bold text-black-deep">Ranking de Goleadores</h2>
                <p class="text-xs text-titanium mt-0.5">Los goles en propia puerta no se contabilizan para el goleador.</p>
            </div>

            @if ($scorers->isEmpty())
                <div class="text-center py-12">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-titanium" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8" opacity=".4"/></svg>
                    </div>
                    <p class="text-sm text-titanium">Aún no hay goles registrados</p>
                    <p class="text-xs text-titanium/70 mt-1">Los goles se registran desde la página de eventos de cada partido.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-silver bg-gray-50/50 text-xs font-semibold text-titanium uppercase tracking-wide">
                                <th class="px-4 py-2.5 text-center w-10">#</th>
                                <th class="px-4 py-2.5 text-left">Jugador</th>
                                <th class="px-4 py-2.5 text-left">Equipo</th>
                                <th class="px-4 py-2.5 text-center">Goles</th>
                                <th class="px-4 py-2.5 text-center">Penaltis</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($scorers as $i => $row)
                                <tr class="{{ $i < 3 ? 'bg-primary/5' : '' }}">
                                    <td class="px-4 py-3 text-center">
                                        @if ($i === 0)
                                            <span class="inline-flex w-6 h-6 rounded-full bg-yellow-400 items-center justify-center text-xs font-black text-white">1</span>
                                        @elseif ($i === 1)
                                            <span class="inline-flex w-6 h-6 rounded-full bg-gray-400 items-center justify-center text-xs font-black text-white">2</span>
                                        @elseif ($i === 2)
                                            <span class="inline-flex w-6 h-6 rounded-full bg-amber-600 items-center justify-center text-xs font-black text-white">3</span>
                                        @else
                                            <span class="text-titanium font-semibold">{{ $i + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-black-deep">
                                        {{ $row['player']?->fullName() ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-titanium">
                                        {{ $row['team']?->displayName() ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $i === 0 ? 'bg-primary text-white font-black' : 'bg-gray-100 text-black-deep font-bold' }} text-base">
                                            {{ $row['goals'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-titanium">
                                        {{ $row['penalties'] > 0 ? $row['penalties'] : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    {{-- ======================== CARDS TAB ======================== --}}
    @if ($activeTab === 'cards')
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-silver bg-gray-50/50">
                <h2 class="font-bold text-black-deep">Ranking de Tarjetas</h2>
            </div>

            @if ($cardsRanking->isEmpty())
                <div class="text-center py-12">
                    <p class="text-sm text-titanium">Aún no hay tarjetas registradas</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-silver bg-gray-50/50 text-xs font-semibold text-titanium uppercase tracking-wide">
                                <th class="px-4 py-2.5 text-center w-10">#</th>
                                <th class="px-4 py-2.5 text-left">Jugador</th>
                                <th class="px-4 py-2.5 text-left">Equipo</th>
                                <th class="px-4 py-2.5 text-center">
                                    <span class="inline-block w-4 h-5 bg-yellow-400 rounded-sm"></span>
                                </th>
                                <th class="px-4 py-2.5 text-center">
                                    <span class="inline-block w-4 h-5 bg-red-500 rounded-sm"></span>
                                </th>
                                <th class="px-4 py-2.5 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($cardsRanking as $i => $row)
                                <tr>
                                    <td class="px-4 py-3 text-center text-titanium font-semibold">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-semibold text-black-deep">{{ $row['player']?->fullName() ?? '—' }}</td>
                                    <td class="px-4 py-3 text-titanium">{{ $row['team']?->displayName() ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center font-semibold text-amber-600">{{ $row['yellows'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center font-semibold text-red-600">{{ $row['reds'] ?: '—' }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-black-deep">{{ $row['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    {{-- ======================== SANCTIONS TAB ======================== --}}
    @if ($activeTab === 'sanctions')
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-silver bg-gray-50/50">
                <h2 class="font-bold text-black-deep">Sanciones del Torneo</h2>
                <p class="text-xs text-titanium mt-0.5">Todas las sanciones registradas, organizadas por jornada de origen.</p>
            </div>

            @if ($sanctions->isEmpty())
                <div class="text-center py-12">
                    <p class="text-sm text-titanium">Sin sanciones registradas en este torneo</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-silver bg-gray-50/50 text-xs font-semibold text-titanium uppercase tracking-wide">
                                <th class="px-4 py-2.5 text-left">Afectado</th>
                                <th class="px-4 py-2.5 text-left">Equipo</th>
                                <th class="px-4 py-2.5 text-left">Tipo</th>
                                <th class="px-4 py-2.5 text-left">Motivo</th>
                                <th class="px-4 py-2.5 text-center">Part.</th>
                                <th class="px-4 py-2.5 text-center">Cumpl.</th>
                                <th class="px-4 py-2.5 text-left">Jornada origen</th>
                                <th class="px-4 py-2.5 text-center">Estado</th>
                                <th class="px-4 py-2.5 text-center">Acc.</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($sanctions as $sanction)
                                <tr class="{{ !$sanction->active ? 'opacity-50' : '' }}">
                                    <td class="px-4 py-3 font-medium text-black-deep">
                                        {{ $sanction->player?->fullName() ?? '(Equipo)' }}
                                    </td>
                                    <td class="px-4 py-3 text-titanium text-xs">
                                        {{ $sanction->team?->displayName() ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $typeColors = [
                                                'suspension'       => 'bg-red-100 text-red-700',
                                                'warning'          => 'bg-amber-100 text-amber-700',
                                                'fine'             => 'bg-purple-100 text-purple-700',
                                                'disqualification' => 'bg-gray-800 text-white',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $typeColors[$sanction->sanction_type] ?? 'bg-gray-100 text-gray-600' }}">
                                            {{ $sanction->sanctionTypeLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-titanium text-xs max-w-[180px] truncate">
                                        {{ $sanction->reason ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold">
                                        {{ $sanction->matches_suspended }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span>{{ $sanction->matches_served }}</span>
                                            @if ($sanction->active && $sanction->matches_served < $sanction->matches_suspended)
                                                <button wire:click="incrementServed({{ $sanction->id }})"
                                                        title="Marcar 1 partido cumplido"
                                                        class="w-5 h-5 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-titanium">
                                        @if ($sanction->originMatch)
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('tournament.match.events', [$tournament, $sanction->originMatch]) }}" wire:navigate
                                                   class="hover:text-primary hover:underline truncate max-w-[140px]">
                                                    {{ $sanction->originMatch->homeTeam?->displayName() ?? '?' }}
                                                    vs
                                                    {{ $sanction->originMatch->awayTeam?->displayName() ?? '?' }}
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-titanium/60">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="toggleSanctionActive({{ $sanction->id }})"
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $sanction->active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition-colors">
                                            {{ $sanction->active ? 'Activa' : 'Cumplida' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{-- Actions managed in match-events page --}}
                                        @if ($sanction->originMatch)
                                            <a href="{{ route('tournament.match.events', [$tournament, $sanction->originMatch]) }}" wire:navigate
                                               class="p-1.5 text-titanium hover:text-primary rounded-lg hover:bg-primary/10 transition-colors inline-flex">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

</div>
