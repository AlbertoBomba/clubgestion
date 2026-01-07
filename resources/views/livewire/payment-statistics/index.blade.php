<div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-2xl font-bold text-black-deep">Estadísticas de Pagos</h2>
                <p class="text-sm text-gray-600 mt-1">Análisis detallado de los cobros y estados de pago</p>
            </div>
            @if($activeSeason)
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $activeSeason->season }} en curso
                </span>
            @endif
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <select wire:model.live="seasonFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todas las temporadas</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}">{{ $season->season }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <select wire:model.live="categoryFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pagos -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Total Pagos</h3>
                    <svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalPayments, 0, ',', '.') }}</p>
            </div>

            <!-- Pagados -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Pagados</h3>
                    <svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($paidPayments, 0, ',', '.') }}</p>
                @if($totalPayments > 0)
                    <p class="text-sm opacity-90 mt-1">{{ number_format(($paidPayments / $totalPayments) * 100, 1) }}% del total</p>
                @endif
            </div>

            <!-- Pendientes -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Pendientes</h3>
                    <svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($pendingPayments, 0, ',', '.') }}</p>
                @if($totalPayments > 0)
                    <p class="text-sm opacity-90 mt-1">{{ number_format(($pendingPayments / $totalPayments) * 100, 1) }}% del total</p>
                @endif
            </div>

            <!-- Total Recaudado -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Recaudado</h3>
                    <svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($totalCollected, 2, ',', '.') }}€</p>
                <p class="text-sm opacity-90 mt-1">{{ number_format($totalPending, 2, ',', '.') }}€ pendiente</p>
            </div>
        </div>

        <!-- Estadísticas por Estado -->
        <div class="bg-white border border-silver rounded-xl shadow-sm p-6 mb-8">
            <h3 class="text-lg font-bold text-black-deep mb-4">Distribución por Estado</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $stateConfig = [
                        0 => ['name' => 'Pendiente', 'color' => 'amber', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                        1 => ['name' => 'Pagado', 'color' => 'green', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                        2 => ['name' => 'Lesión', 'color' => 'orange', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z'],
                        3 => ['name' => 'Baja', 'color' => 'red', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
                    ];
                @endphp

                @foreach($stateConfig as $stateId => $config)
                    @php
                        $stat = $statsByState->get($stateId);
                        $count = $stat ? $stat->total : 0;
                        $amount = $stat ? $stat->total_amount : 0;
                    @endphp
                    <div class="bg-{{ $config['color'] }}-50 border border-{{ $config['color'] }}-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-{{ $config['color'] }}-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="{{ $config['icon'] }}" clip-rule="evenodd"/>
                            </svg>
                            <h4 class="text-sm font-semibold text-{{ $config['color'] }}-900">{{ $config['name'] }}</h4>
                        </div>
                        <p class="text-2xl font-bold text-{{ $config['color'] }}-700">{{ number_format($count, 0, ',', '.') }}</p>
                        <p class="text-xs text-{{ $config['color'] }}-600 mt-1">{{ number_format($amount, 2, ',', '.') }}€</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Estadísticas por Cuota -->
        <div class="bg-white border border-silver rounded-xl shadow-sm p-6 mb-8">
            <h3 class="text-lg font-bold text-black-deep mb-4">Estadísticas por Cuota</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-silver/30">
                    <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-primary uppercase tracking-wider">Cuota</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Pagados</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Pendientes</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">% Cobrado</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Recaudado</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white-pure divide-y divide-silver/30">
                        @forelse($statsByQuota as $stat)
                            @php
                                $percentPaid = $stat->total > 0 ? ($stat->paid / $stat->total) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-primary/5">
                                <td class="px-6 py-4 text-sm font-semibold text-black-deep">Cuota {{ $stat->cuota }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($stat->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ number_format($stat->paid, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ number_format($stat->pending, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <div class="flex items-center justify-end">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentPaid }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">{{ number_format($percentPaid, 1) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-green-700">{{ number_format($stat->collected, 2, ',', '.') }}€</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-amber-700">{{ number_format($stat->pending_amount, 2, ',', '.') }}€</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">No hay datos disponibles</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estadísticas por Equipo -->
        <div class="bg-white border border-silver rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-black-deep mb-4">Estadísticas por Equipo</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-silver/30">
                    <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-primary uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Pagados</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Pendientes</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">% Cobrado</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Recaudado</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-primary uppercase tracking-wider">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white-pure divide-y divide-silver/30">
                        @forelse($statsByTeam as $stat)
                            @php
                                $percentPaid = $stat->total > 0 ? ($stat->paid / $stat->total) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-primary/5">
                                <td class="px-6 py-4 text-sm font-semibold text-black-deep">{{ $stat->team }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $stat->category }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($stat->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ number_format($stat->paid, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ number_format($stat->pending, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <div class="flex items-center justify-end">
                                        <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentPaid }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">{{ number_format($percentPaid, 1) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-green-700">{{ number_format($stat->collected, 2, ',', '.') }}€</td>
                                <td class="px-6 py-4 text-sm text-right font-semibold text-amber-700">{{ number_format($stat->pending_amount, 2, ',', '.') }}€</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">No hay datos disponibles</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
