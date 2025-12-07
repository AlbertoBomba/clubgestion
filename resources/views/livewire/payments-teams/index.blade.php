@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
@endpush

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black-deep">Generar pagos</h2>
                    <button wire:click="openGenerateModal" 
                        wire:loading.attr="disabled"
                        wire:target="openGenerateModal"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                        <svg wire:loading.remove wire:target="openGenerateModal" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <svg wire:loading wire:target="openGenerateModal" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="openGenerateModal">Generar Pagos</span>
                        <span wire:loading wire:target="openGenerateModal">Cargando...</span>
                    </button>
                </div>

                <!-- Flash Messages -->
                @if (session()->has('message'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input wire:model.live="search" type="text" id="search" 
                            class="w-full rounded-lg border-silver focus:border-primary focus:ring-2 focus:ring-primary/20" 
                            placeholder="Buscar equipo...">
                    </div>
                    <div>
                        <label for="seasonFilter" class="block text-sm font-medium text-gray-700 mb-1">Temporada</label>
                        <select wire:model.live="seasonFilter" id="seasonFilter" 
                            class="w-full rounded-lg border-silver focus:border-primary focus:ring-2 focus:ring-primary/20">
                            <option value="">Todas las temporadas</option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->season }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Teams Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-silver/30">
                        <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Sección</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Estado Pagos</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white-pure divide-y divide-silver/30">
                            @forelse($teams as $team)
                                <!-- Fila del equipo -->
                                <tr class="hover:bg-primary/5">
                                    <td class="px-6 py-2">
                                        <div class="text-sm font-semibold text-black-deep">{{ $team->team }}</div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="text-sm text-gray-900">{{ $team->category->category ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="text-sm text-gray-900">{{ $team->season->season ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="text-sm text-gray-900">{{ $team->section->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-2">
                                        @if($team->price && $team->price > 0)
                                            <div class="text-sm font-semibold text-green-600">{{ number_format($team->price, 2) }} €</div>
                                        @else
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-red-600 font-medium">Sin precio</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-2 text-center">
                                        @if($team->price && $team->price > 0)
                                            @if($team->payments_count > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Con pagos ({{ $team->payments_count }})
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Sin pagos
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                                </svg>
                                                No se puede generar
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                
                                <!-- Fila de pagos del equipo -->
                                @if($team->payments_count > 0)
                                    <tr>
                                        <td colspan="6" class="px-6 py-2 bg-gray-50">
                                            <div class="ml-8">
                                                <div class="text-xs font-semibold text-gray-600 mb-1">Pagos generados:</div>
                                                <div class="grid grid-cols-1 gap-1">
                                                    @foreach($team->payments as $payment)
                                                        <div class="flex items-center text-xs text-gray-700 bg-white px-3 py-1 rounded border border-gray-200">
                                                            <span class="font-medium text-primary mr-2">Cuota {{ $payment->cuota }}:</span>
                                                            <span class="mr-3">{{ $payment->description }}</span>
                                                            <span class="text-green-600 font-semibold mr-3">{{ number_format($payment->amount, 2) }} €</span>
                                                            <span class="text-gray-500">{{ $payment->date_start->format('d/m/Y') }} - {{ $payment->date_end->format('d/m/Y') }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg class="w-16 h-16 mb-4 text-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <p class="text-lg font-semibold">No hay equipos registrados</p>
                                            <p class="text-sm mt-1">Los equipos aparecerán aquí una vez creados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Generar Pagos -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeModal"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-[95vw] p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Generar Pagos de Matrícula
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div>
            @if($selectedSeasonId)
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-blue-900">
                            Temporada: {{ $seasons->firstWhere('id', $selectedSeasonId)->season ?? '' }}
                        </span>
                    </div>
                </div>
            @endif

            <!-- Configuración de Plazos -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="mb-4">
                    <label for="numPlazos" class="block text-sm font-medium text-gray-700 mb-2">
                        Número de Plazos
                    </label>
                    <select wire:model.live="numPlazos" id="numPlazos" 
                        class="w-full md:w-48 rounded-lg border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'plazo' : 'plazos' }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Fechas de los Plazos -->
                @if($numPlazos > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
                        @for($i = 1; $i <= $numPlazos; $i++)
                            <div class="p-2 bg-white rounded border border-gray-200">
                                <h4 class="text-xs font-semibold text-gray-700 mb-2 text-center">Plazo {{ $i }}</h4>
                                <div>
                                    <label class="block text-[9px] font-medium text-gray-600 mb-0.5">
                                        Desde - Hasta
                                    </label>
                                    <input type="text" 
                                        id="flatpickr-{{ $i }}" 
                                        class="w-full rounded border-gray-300 text-[10px] px-1 py-0.5 focus:border-primary focus:ring-1 focus:ring-primary/20"
                                        placeholder="Seleccionar fechas"
                                        readonly>
                                    <input type="hidden" wire:model.live="plazos.{{ $i }}.date_start" id="date_start_{{ $i }}">
                                    <input type="hidden" wire:model.live="plazos.{{ $i }}.date_end" id="date_end_{{ $i }}">
                                </div>
                            </div>
                        @endfor
                    </div>
                @endif
            </div>

            @if(count($modalTeams) > 0)
                <div class="overflow-x-auto max-h-96">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sección</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Matrícula</th>
                                @for($i = 1; $i <= $numPlazos; $i++)
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cuota {{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($modalTeams as $team)
                                <tr class="{{ (!$team->price || $team->price == 0) ? 'bg-red-50' : 'hover:bg-gray-50' }}">
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm font-medium {{ (!$team->price || $team->price == 0) ? 'text-red-700' : 'text-gray-900' }}">
                                            {{ $team->team }}
                                            @if(!$team->price || $team->price == 0)
                                                <div class="flex items-center mt-1">
                                                    <svg class="w-4 h-4 text-red-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="text-xs text-red-600 font-medium">No se puede generar pagos</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        <div class="text-sm {{ (!$team->price || $team->price == 0) ? 'text-red-600' : 'text-gray-500' }}">{{ $team->section->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-2 whitespace-nowrap">
                                        @if($team->price && $team->price > 0)
                                            <div class="text-sm font-semibold text-green-600">{{ number_format($team->price, 2) }} €</div>
                                        @else
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-red-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-sm font-semibold text-red-600">0,00 € - Precio no configurado</span>
                                            </div>
                                        @endif
                                    </td>
                                    @php
                                        $pricePerInstallment = ($team->price && $team->price > 0) ? $team->price / $numPlazos : 0;
                                    @endphp
                                    @for($i = 1; $i <= $numPlazos; $i++)
                                        <td class="px-6 py-2 text-center {{ $i % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                            @if($team->price && $team->price > 0)
                                                <div class="text-xs font-semibold text-blue-600 mb-1">
                                                    {{ number_format($pricePerInstallment, 2) }} €
                                                </div>
                                                @if(isset($plazos[$i]))
                                                    <div class="text-[11px] text-gray-700 font-medium">
                                                        Desde {{ $plazos[$i]['date_start'] ? \Carbon\Carbon::parse($plazos[$i]['date_start'])->format('d/m/Y') : '-' }} hasta {{ $plazos[$i]['date_end'] ? \Carbon\Carbon::parse($plazos[$i]['date_end'])->format('d/m/Y') : '-' }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-xs text-red-500">-</div>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    @if($selectedSeasonId)
                        <p>No hay equipos con precio de matrícula configurado para esta temporada.</p>
                    @else
                        <p>Seleccione una temporada para ver los equipos.</p>
                    @endif
                </div>
            @endif
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button wire:click="closeModal" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancelar
                    </button>

                    @if(count($modalTeams) > 0)
                        <button class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-night-blue focus:bg-night-blue active:bg-night-blue focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                            Continuar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        initializeFlatpickr();
        
        Livewire.on('modal-opened', () => {
            setTimeout(() => initializeFlatpickr(), 100);
        });
        
        Livewire.hook('morph.updated', () => {
            initializeFlatpickr();
        });
    });
    
    function initializeFlatpickr() {
        const numPlazos = @this.numPlazos || 1;
        
        for (let i = 1; i <= 12; i++) {
            const element = document.getElementById('flatpickr-' + i);
            if (element && !element._flatpickr) {
                const dateStartInput = document.getElementById('date_start_' + i);
                const dateEndInput = document.getElementById('date_end_' + i);
                
                // Obtener valores iniciales si existen
                const startDate = dateStartInput ? dateStartInput.value : null;
                const endDate = dateEndInput ? dateEndInput.value : null;
                const defaultDates = (startDate && endDate) ? [startDate, endDate] : [];
                
                flatpickr(element, {
                    mode: 'range',
                    dateFormat: 'd/m/Y',
                    locale: 'es',
                    defaultDate: defaultDates,
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length === 2) {
                            const startDate = selectedDates[0];
                            const endDate = selectedDates[1];
                            
                            // Formato YYYY-MM-DD para Livewire
                            const formatDate = (date) => {
                                const year = date.getFullYear();
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const day = String(date.getDate()).padStart(2, '0');
                                return `${year}-${month}-${day}`;
                            };
                            
                            if (dateStartInput) dateStartInput.value = formatDate(startDate);
                            if (dateEndInput) dateEndInput.value = formatDate(endDate);
                            
                            // Disparar evento de Livewire
                            dateStartInput.dispatchEvent(new Event('input'));
                            dateEndInput.dispatchEvent(new Event('input'));
                            
                            @this.set('plazos.' + i + '.date_start', formatDate(startDate));
                            @this.set('plazos.' + i + '.date_end', formatDate(endDate));
                        }
                    }
                });
            }
        }
    }
</script>
@endpush
