<div class="min-h-screen bg-gray-50 pb-28 relative" x-data="{ showFilters: false }">

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div>
            <h2 class="font-black text-xl text-titanium leading-tight">
                Estadísticas
            </h2>
            @if($activeSeason)
                <p class="text-[10px] font-bold text-green-600 mt-0.5 uppercase tracking-wider flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    {{ $activeSeason->season }}
                </p>
            @endif
        </div>

        {{-- Botón Toggle Filtros --}}
        <button @click="showFilters = !showFilters" 
                class="p-2.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 active:scale-95 transition-all relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            @if($seasonFilter || $categoryFilter)
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-primary rounded-full border-2 border-white"></span>
            @endif
        </button>
    </header>

    {{-- PANEL DE FILTROS DESPLEGABLE --}}
    <div x-show="showFilters" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="px-4 py-5 bg-white-pure border-b border-gray-100 shadow-inner z-30 relative space-y-3" style="display: none;">
        
        <div class="grid grid-cols-2 gap-2">
            <select wire:model.live="seasonFilter" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                <option value="">Todas las temporadas</option>
                @foreach($seasons as $season)
                    <option value="{{ $season->id }}">{{ $season->season }}</option>
                @endforeach
            </select>

            <select wire:model.live="categoryFilter" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                <option value="">Todas las categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <main class="p-4 space-y-6">

        {{-- KPIS PRINCIPALES (GLOBALES) --}}
        <section class="grid grid-cols-2 gap-3">
            {{-- Recaudado (Destacado) --}}
            <div class="col-span-2 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl p-5 text-white shadow-md shadow-emerald-600/20">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-100">Recaudado Total</span>
                    <svg class="w-6 h-6 text-emerald-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-black leading-none">{{ number_format($totalCollected, 2, ',', '.') }} €</p>
                    <p class="text-xs font-semibold text-emerald-100 mb-0.5 whitespace-nowrap">{{ number_format($totalPending, 2, ',', '.') }} € pdte.</p>
                </div>
            </div>

            {{-- Total Pagos --}}
            <div class="bg-white-pure rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col justify-center">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pagos</span>
                <p class="text-2xl font-black text-titanium">{{ number_format($totalPayments, 0, ',', '.') }}</p>
            </div>

            {{-- Pagados vs Pendientes Mini-Grafico --}}
            @php
                $percentPaid = $totalPayments > 0 ? round(($paidPayments / $totalPayments) * 100) : 0;
                $percentPending = 100 - $percentPaid;
            @endphp
            <div class="bg-white-pure rounded-2xl p-4 border border-gray-100 shadow-sm space-y-2">
                <div class="flex justify-between text-[10px] font-bold">
                    <span class="text-green-600">✓ {{ $paidPayments }}</span>
                    <span class="text-amber-500">⚠ {{ $pendingPayments }}</span>
                </div>
                <div class="w-full h-1.5 bg-amber-100 rounded-full overflow-hidden flex">
                    <div class="h-full bg-green-500" style="width: {{ $percentPaid }}%"></div>
                    <div class="h-full bg-amber-500" style="width: {{ $percentPending }}%"></div>
                </div>
                <div class="flex justify-between text-[9px] font-bold text-gray-400 uppercase">
                    <span>{{ $percentPaid }}% cobr.</span>
                    <span>pdte.</span>
                </div>
            </div>
        </section>

        {{-- DISTRIBUCIÓN POR ESTADO --}}
        <section class="space-y-3">
            <h3 class="font-bold text-base text-titanium px-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
                Distribución por Estado
            </h3>

            <div class="grid grid-cols-2 gap-3">
                @php
                    $stateConfig = [
                        0 => ['name' => 'Pendientes', 'color' => 'amber', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                        1 => ['name' => 'Pagados', 'color' => 'green', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                        2 => ['name' => 'Lesiones', 'color' => 'orange', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z'],
                        3 => ['name' => 'Bajas', 'color' => 'red', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
                    ];
                @endphp

                @foreach($stateConfig as $stateId => $config)
                    @php
                        $stat = $statsByState->get($stateId);
                        $count = $stat ? $stat->total : 0;
                        $amount = $stat ? $stat->total_amount : 0;
                        $colorClass = $config['color'] === 'amber' ? 'text-amber-600' : ($config['color'] === 'green' ? 'text-green-600' : ($config['color'] === 'orange' ? 'text-orange-600' : 'text-red-600'));
                        $bgClass = $config['color'] === 'amber' ? 'bg-amber-50 border-amber-100' : ($config['color'] === 'green' ? 'bg-green-50 border-green-100' : ($config['color'] === 'orange' ? 'bg-orange-50 border-orange-100' : 'bg-red-50 border-red-100'));
                    @endphp
                    
                    <div class="rounded-2xl p-3 border {{ $bgClass }}">
                        <div class="flex items-center gap-1.5 mb-2">
                            <svg class="w-4 h-4 {{ $colorClass }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="{{ $config['icon'] }}" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-[10px] font-bold uppercase tracking-wider {{ $colorClass }}">{{ $config['name'] }}</span>
                        </div>
                        <p class="text-xl font-black text-titanium leading-none mb-1">{{ number_format($count, 0, ',', '.') }}</p>
                        <p class="text-[11px] font-bold text-gray-500">{{ number_format($amount, 2, ',', '.') }} €</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ESTADÍSTICAS POR CUOTA --}}
        <section class="space-y-3">
            <h3 class="font-bold text-base text-titanium px-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Análisis por Cuota
            </h3>

            <div class="space-y-3">
                @forelse($statsByQuota as $stat)
                    @php
                        $percentPaid = $stat->total > 0 ? round(($stat->paid / $stat->total) * 100) : 0;
                    @endphp
                    <article class="bg-white-pure rounded-3xl p-4 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-black text-sm text-titanium flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-xs shadow-sm">{{ $stat->cuota }}</span>
                                Cuota {{ $stat->cuota }}
                            </h4>
                            <span class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg border border-gray-100">{{ number_format($stat->total, 0, ',', '.') }} cartas</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <span class="block text-[10px] font-bold text-green-700 uppercase tracking-wider mb-0.5">Recaudado ({{ number_format($stat->paid, 0, ',', '.') }})</span>
                                <span class="font-black text-green-600 text-sm">{{ number_format($stat->collected, 2, ',', '.') }} €</span>
                            </div>
                            <div class="text-right">
                                <span class="block text-[10px] font-bold text-amber-700 uppercase tracking-wider mb-0.5">Pendiente ({{ number_format($stat->pending, 0, ',', '.') }})</span>
                                <span class="font-black text-amber-600 text-sm">{{ number_format($stat->pending_amount, 2, ',', '.') }} €</span>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-50 flex items-center gap-3">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="bg-primary h-full rounded-full" style="width: {{ $percentPaid }}%"></div>
                            </div>
                            <span class="text-[10px] font-black text-primary">{{ $percentPaid }}%</span>
                        </div>
                    </article>
                @empty
                    <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100">
                        <p class="text-xs font-bold text-gray-400">No hay datos disponibles por cuota</p>
                    </div>
                @endforelse
            </div>
        </section>
        {{-- ESTADÍSTICAS POR EQUIPO (VERSIÓN MÓVIL) --}}
        <section class="space-y-3">
            <h3 class="font-bold text-base text-titanium px-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Análisis por Equipo
            </h3>

            <!-- Nota informativa sobre 'Otros' y Leyenda -->
            <div class="p-3 bg-blue-50 border border-blue-100 rounded-2xl text-[11px] text-blue-800 space-y-2">
                <div class="flex items-start gap-1.5">
                    <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Nota:</strong> <strong>Otros</strong> incluye lesionados, bajas, abonos o casos especiales.</span>
                </div>
                <div class="flex items-center justify-around font-medium pt-1.5 border-t border-blue-100 text-[10px]">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Pagados</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span> Pendientes</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-slate-400"></span> Otros</span>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($statsByTeam as $stat)
                    @php
                        $totalCount = $stat->total > 0 ? $stat->total : 1;
                        $percentPaid = ($stat->paid / $totalCount) * 100;
                        $percentPending = ($stat->pending / $totalCount) * 100;
                        $percentOther = ($stat->other / $totalCount) * 100;
                        
                        // Suma total de los 3 importes
                        $totalAmount = $stat->collected + $stat->pending_amount + $stat->other_amount;
                    @endphp
                    <article class="bg-white-pure rounded-3xl p-4 shadow-sm border border-gray-100 space-y-3">
                        {{-- Encabezado de Tarjeta --}}
                        <div class="flex items-start justify-between border-b border-gray-50 pb-2">
                            <div>
                                <h4 class="font-black text-sm text-titanium leading-tight">{{ $stat->team }}</h4>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5">{{ $stat->category }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] font-bold text-gray-400 uppercase block">Total Final</span>
                                <span class="font-black text-xs text-gray-900">{{ number_format($totalAmount, 2, ',', '.') }}€</span>
                            </div>
                        </div>

                        {{-- Fila con Recibos Totales --}}
                        <div class="flex justify-between items-center bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100">
                            <span class="text-[10px] font-bold text-gray-500">Recibos Totales</span>
                            <span class="font-black text-xs text-titanium">{{ number_format($stat->total, 0, ',', '.') }}</span>
                        </div>

                        {{-- Desglose por Estados (3 Columnas compactas) --}}
                        <div class="grid grid-cols-3 gap-1.5 text-center">
                            {{-- Pagados --}}
                            <div class="bg-emerald-50/70 p-2 rounded-xl border border-emerald-100/80 flex flex-col justify-between">
                                <span class="text-[9px] font-bold text-emerald-800 uppercase block">Pagados</span>
                                <span class="inline-block font-black text-xs text-emerald-800 my-0.5">
                                    {{ number_format($stat->paid, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-extrabold text-emerald-700 block">
                                    {{ number_format($stat->collected, 2, ',', '.') }}€
                                </span>
                            </div>

                            {{-- Pendientes --}}
                            <div class="bg-amber-50/70 p-2 rounded-xl border border-amber-100/80 flex flex-col justify-between">
                                <span class="text-[9px] font-bold text-amber-800 uppercase block">Pendientes</span>
                                <span class="inline-block font-black text-xs text-amber-800 my-0.5">
                                    {{ number_format($stat->pending, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-extrabold text-amber-700 block">
                                    {{ number_format($stat->pending_amount, 2, ',', '.') }}€
                                </span>
                            </div>

                            {{-- Otros --}}
                            <div class="bg-slate-100/70 p-2 rounded-xl border border-slate-200/80 flex flex-col justify-between">
                                <span class="text-[9px] font-bold text-slate-700 uppercase block">Otros</span>
                                <span class="inline-block font-black text-xs text-slate-700 my-0.5">
                                    {{ number_format($stat->other, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-extrabold text-slate-600 block">
                                    {{ number_format($stat->other_amount, 2, ',', '.') }}€
                                </span>
                            </div>
                        </div>

                        {{-- Barra de Progreso Segmentada --}}
                        <div class="pt-1">
                            <div class="w-full bg-gray-100 rounded-full h-2 flex overflow-hidden">
                                <div class="bg-emerald-500 h-2 transition-all duration-300" style="width: {{ $percentPaid }}%"></div>
                                <div class="bg-amber-400 h-2 transition-all duration-300" style="width: {{ $percentPending }}%"></div>
                                <div class="bg-slate-400 h-2 transition-all duration-300" style="width: {{ $percentOther }}%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] font-bold mt-1.5">
                                <span class="text-emerald-700">{{ number_format($percentPaid, 0) }}% pag.</span>
                                <span class="text-amber-700">{{ number_format($percentPending, 0) }}% pdt.</span>
                                <span class="text-slate-600">{{ number_format($percentOther, 0) }}% otr.</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100">
                        <p class="text-xs font-bold text-gray-400">No hay datos disponibles por equipo</p>
                    </div>
                @endforelse
            </div>
        </section>

        

       

    </main>
</div>