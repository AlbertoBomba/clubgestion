<div class="w-full px-4">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase">Peticiones Hoy</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_today']) }}</p>
                </div>
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase">Errores Hoy</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['errors_today']) }}</p>
                </div>
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase">Última Semana</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_week']) }}</p>
                </div>
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase">Tiempo Resp. Prom.</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_response_time'] ?? 0) }}ms</p>
                </div>
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card-modern rounded-2xl shadow-xl border border-primary/10 p-4 mb-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filtros
            </h3>
            <button wire:click="clearFilters" class="text-sm text-primary hover:text-primary-dark font-semibold">
                Limpiar Filtros
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Escuela</label>
                <select wire:model.live="sports_school_id" class="input-field block w-full px-2 py-2 text-sm border border-gray-300 rounded-lg">
                    <option value="">Todas</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Estado</label>
                <select wire:model.live="status_code" class="input-field block w-full px-2 py-2 text-sm border border-gray-300 rounded-lg">
                    <option value="">Todos</option>
                    @foreach($statusCodes as $code => $label)
                        <option value="{{ $code }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Endpoint</label>
                <select wire:model.live="endpoint" class="input-field block w-full px-2 py-2 text-sm border border-gray-300 rounded-lg">
                    <option value="">Todos</option>
                    @foreach($endpoints as $ep)
                        <option value="{{ $ep }}">{{ Str::limit($ep, 30) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Desde</label>
                <input wire:model.live="date_from" type="date" class="input-field block w-full px-2 py-2 text-sm border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Hasta</label>
                <input wire:model.live="date_to" type="date" class="input-field block w-full px-2 py-2 text-sm border border-gray-300 rounded-lg">
            </div>
        </div>
    </div>

    <!-- Tabla de Logs -->
    <div class="card-modern rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Registros de API ({{ $logs->total() }})
            </h3>
            <button wire:click="cleanupOldLogs(90)" 
                onclick="return confirm('¿Eliminar logs antiguos (>90 días)?')"
                class="text-xs px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Limpiar Antiguos
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Escuela</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Endpoint</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Método</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">IP</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tiempo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Detalles</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900">
                                {{ $log->sportsSchool->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-900">
                                <span class="font-mono">{{ Str::limit($log->endpoint, 40) }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $log->method === 'GET' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $log->method === 'POST' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $log->method === 'DELETE' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $log->method }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $log->status_code < 300 ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $log->status_code >= 300 && $log->status_code < 400 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $log->status_code >= 400 && $log->status_code < 500 ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $log->status_code >= 500 ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $log->status_code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900 font-mono">
                                {{ $log->ip_address ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900">
                                @if($log->response_time)
                                    <span class="font-semibold {{ $log->response_time > 1000 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $log->response_time }}ms
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-xs">
                                <button onclick="toggleDetails({{ $log->id }})" class="text-primary hover:text-primary-dark font-semibold">
                                    Ver
                                </button>
                            </td>
                        </tr>
                        <tr id="details-{{ $log->id }}" class="hidden bg-gray-50">
                            <td colspan="8" class="px-4 py-3">
                                <div class="text-xs space-y-2">
                                    <div>
                                        <span class="font-semibold text-gray-700">User Agent:</span>
                                        <span class="text-gray-600">{{ $log->user_agent ?? 'N/A' }}</span>
                                    </div>
                                    @if($log->referer)
                                        <div>
                                            <span class="font-semibold text-gray-700">Referer:</span>
                                            <span class="text-gray-600">{{ $log->referer }}</span>
                                        </div>
                                    @endif
                                    @if($log->request_params)
                                        <div>
                                            <span class="font-semibold text-gray-700">Parámetros:</span>
                                            <pre class="mt-1 bg-gray-900 text-green-400 p-2 rounded text-xs overflow-x-auto">{{ json_encode($log->request_params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </div>
                                    @endif
                                    @if($log->error_message)
                                        <div>
                                            <span class="font-semibold text-red-700">Error:</span>
                                            <span class="text-red-600">{{ $log->error_message }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm font-medium">No se encontraron registros</p>
                                <p class="text-xs text-gray-400 mt-1">Ajusta los filtros para ver resultados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<script>
function toggleDetails(id) {
    const element = document.getElementById('details-' + id);
    element.classList.toggle('hidden');
}
</script>
