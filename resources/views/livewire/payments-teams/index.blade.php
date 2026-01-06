@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar {
        z-index: 10000 !important;
    }
    .flatpickr-calendar.open {
        z-index: 10000 !important;
    }
</style>
@endpush

<div class="py-12">
    <div class=" sm:px-6 lg:px-8">
        <div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black-deep">Generar pagos</h2>
                    <div class="flex gap-3">
                        <!-- Botón Imprimir -->
                        <button 
                            wire:click="printPayments"
                            wire:loading.attr="disabled"
                            wire:target="printPayments"
                            title="Imprimir lista de pagos"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                            <svg wire:loading.remove wire:target="printPayments" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            <svg wire:loading wire:target="printPayments" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="printPayments">Imprimir</span>
                            <span wire:loading wire:target="printPayments">Generando...</span>
                        </button>
                        
                        <!-- Spinner mientras se cargan los equipos seleccionados -->
                        <div wire:loading wire:target="selectedTeamsToDelete" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest">
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Procesando...</span>
                        </div>
                        
                        <!-- Botón de eliminar (solo se muestra cuando hay selección y no está cargando) -->
                        @if(count($selectedTeamsToDelete) > 0)
                            <button wire:loading.remove wire:target="selectedTeamsToDelete" wire:click="openDeleteModal" 
                                wire:loading.attr="disabled"
                                wire:target="openDeleteModal"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                                <svg wire:loading.remove wire:target="openDeleteModal" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <svg wire:loading wire:target="openDeleteModal" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="openDeleteModal">Eliminar Pagos ({{ count($selectedTeamsToDelete) }})</span>
                                <span wire:loading wire:target="openDeleteModal">Cargando...</span>
                            </button>
                        @endif
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
                                <option value="{{ $season->id }}">
                                    {{ $season->season }}
                                    @if($activeSeason && $season->id === $activeSeason->id)
                                        🟢 (Temporada en curso)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Teams Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-silver/30">
                        <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                            <tr>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider w-16">
                                    <input type="checkbox" 
                                        class="rounded border-gray-300 text-primary focus:ring-primary"
                                        wire:model.live="selectAllTeams"
                                        @click="if($event.target.checked) { 
                                            $wire.set('selectedTeamsToDelete', @js($teams->filter(fn($t) => $t->price > 0)->pluck('id')->toArray())); 
                                        } else { 
                                            $wire.set('selectedTeamsToDelete', []); 
                                        }">
                                </th>
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
                                <tr class="{{ $team->payments_count > 0 ? 'bg-blue-50/50 hover:bg-blue-100/50 border-l-4 border-blue-500' : 'hover:bg-primary/5' }}">
                                    <td class="px-6 py-3 text-center">
                                        @if($team->price && $team->price > 0)
                                            <input type="checkbox" 
                                                wire:model.live="selectedTeamsToDelete" 
                                                value="{{ $team->id }}"
                                                class="rounded border-gray-300 text-primary focus:ring-primary">
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="text-sm font-bold text-black-deep">{{ $team->team }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="text-sm text-gray-900">{{ $team->category->category ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="text-sm text-gray-900">{{ $team->season->season ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="text-sm text-gray-900">{{ $team->section->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-3">
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
                                    <td class="px-6 py-3 text-center">
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
                                        <td colspan="7" class="px-6 py-3 bg-gradient-to-r from-primary/10 to-primary/5 border-l-4 border-primary">
                                            <div class="ml-8">
                                                <div class="flex justify-between items-center mb-3">
                                                    <div class="text-sm font-bold text-primary uppercase tracking-wide flex items-center">
                                                        <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Pagos generados: {{ $team->team }}
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <button wire:click="openEditModal({{ $team->id }})" 
                                                            class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 font-semibold">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                            Editar
                                                        </button>
                                                        <button wire:click="openDeleteSingleModal({{ $team->id }})" 
                                                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 font-semibold">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 gap-1">
                                                    @foreach($team->payments as $payment)
                                                        <div class="flex items-center text-xs text-gray-700 {{ $loop->iteration % 2 == 0 ? 'bg-gray-100' : 'bg-white' }} px-3 py-1 rounded border border-gray-200">
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
                                    <td colspan="7" class="px-6 py-12 text-center">
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
            @if(!$showPreview)
                <!-- Configuración de plazos -->
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
                        @for($i = 1; $i <= $maxPlazos; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'plazo' : 'plazos' }}</option>
                        @endfor
                    </select>
                    @if($maxPlazos < 12)
                        <p class="text-xs text-gray-500 mt-1">Máximo {{ $maxPlazos }} {{ $maxPlazos == 1 ? 'plazo' : 'plazos' }} según configuración de la temporada</p>
                    @endif
                </div>

                <!-- Fechas de los Plazos -->
                @if($numPlazos > 0)
                    <div wire:loading wire:target="numPlazos" class="text-center py-8">
                        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-primary transition ease-in-out duration-150">
                            <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-base">Cargando plazos...</span>
                        </div>
                    </div>
                    <div wire:loading.remove wire:target="numPlazos" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
                        @for($i = 1; $i <= $numPlazos; $i++)
                            <div class="p-2 bg-white rounded border {{ isset($plazoErrors[$i]) ? 'border-red-500' : 'border-gray-200' }}">
                                <h4 class="text-xs font-semibold {{ isset($plazoErrors[$i]) ? 'text-red-700' : 'text-gray-700' }} mb-2 text-center">Plazo {{ $i }}</h4>
                                <div wire:ignore>
                                    <label class="block text-[9px] font-medium {{ isset($plazoErrors[$i]) ? 'text-red-600' : 'text-gray-600' }} mb-0.5">
                                        Desde - Hasta
                                    </label>
                                    <input type="text" 
                                        id="flatpickr-{{ $i }}" 
                                        class="flatpickr-input w-full rounded {{ isset($plazoErrors[$i]) ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary focus:ring-primary/20' }} text-[10px] px-1 py-0.5 focus:ring-1"
                                        placeholder="Seleccionar fechas">
                                </div>
                                @if(isset($plazoErrors[$i]))
                                    <p class="text-[9px] text-red-600 font-semibold mt-1">{{ $plazoErrors[$i] }}</p>
                                @endif
                                <input type="hidden" wire:model.live="plazos.{{ $i }}.date_start" id="date_start_{{ $i }}">
                                <input type="hidden" wire:model.live="plazos.{{ $i }}.date_end" id="date_end_{{ $i }}">
                            </div>
                        @endfor
                    </div>
                @endif
            </div>

            @if(count($modalTeams) > 0)
                <div wire:loading wire:target="numPlazos" class="text-center py-12">
                    <div class="inline-flex flex-col items-center">
                        <svg class="animate-spin h-12 w-12 text-primary mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-lg font-semibold text-gray-700">Generando tabla de cuotas...</p>
                        <p class="text-sm text-gray-500 mt-1">Calculando {{ $numPlazos }} {{ $numPlazos == 1 ? 'plazo' : 'plazos' }} para {{ count($modalTeams) }} {{ count($modalTeams) == 1 ? 'equipo' : 'equipos' }}</p>
                    </div>
                </div>
                <div wire:loading.remove wire:target="numPlazos" class="overflow-x-auto max-h-96">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    <input type="checkbox" 
                                        class="rounded border-gray-300 text-primary focus:ring-primary"
                                        @click="$wire.selectedTeamIds = $event.target.checked ? @js($modalTeams->filter(fn($t) => $t->price > 0)->pluck('id')->toArray()) : []">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sección</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio temporada</th>
                                @for($i = 1; $i <= $numPlazos; $i++)
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cuota {{ $i }}</th>
                                @endfor
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 border-l-2 border-gray-300">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($modalTeams as $team)
                                <tr class="{{ (!$team->price || $team->price == 0) ? 'bg-red-50' : 'hover:bg-gray-50' }}">
                                    <td class="px-6 py-2 text-center">
                                        @if($team->price && $team->price > 0)
                                            <input type="checkbox" 
                                                wire:model.live="selectedTeamIds" 
                                                value="{{ $team->id }}"
                                                class="rounded border-gray-300 text-primary focus:ring-primary">
                                        @else
                                            <input type="checkbox" 
                                                disabled
                                                class="rounded border-gray-300 opacity-50 cursor-not-allowed">
                                        @endif
                                    </td>
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
                                        $totalTeamAmount = 0;
                                        for($j = 1; $j <= $numPlazos; $j++) {
                                            $totalTeamAmount += floatval($teamAmounts[$team->id][$j] ?? 0);
                                        }
                                    @endphp
                                    @for($i = 1; $i <= $numPlazos; $i++)
                                        <td class="px-6 py-2 text-center {{ $i % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                            @if($team->price && $team->price > 0)
                                                <div class="mb-1">
                                                    <input type="number" 
                                                        wire:model.blur="teamAmounts.{{ $team->id }}.{{ $i }}"
                                                        step="0.01"
                                                        min="0"
                                                        {{ $numPlazos == 1 ? 'disabled' : '' }}
                                                        class="w-20 px-2 py-1 text-xs font-semibold {{ $numPlazos == 1 ? 'text-gray-500 bg-gray-100 cursor-not-allowed' : 'text-blue-600' }} border border-gray-300 rounded focus:ring-2 focus:ring-primary focus:border-primary text-center"
                                                        placeholder="0.00">
                                                    <span class="text-xs text-gray-500">€</span>
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
                                    @if($team->price && $team->price > 0)
                                        <td class="px-6 py-2 text-center bg-gray-50 border-l-2 border-gray-300">
                                            <div class="text-sm font-bold {{ isset($teamTotalErrors[$team->id]) ? 'text-red-600' : 'text-green-600' }}">
                                                {{ number_format($totalTeamAmount, 2, ',', '.') }} €
                                            </div>
                                            <div class="text-[10px] text-gray-500 mt-1">
                                                de {{ number_format($team->price, 2, ',', '.') }} €
                                            </div>
                                        </td>
                                    @else
                                        <td class="px-6 py-2 text-center bg-gray-50 border-l-2 border-gray-300">
                                            <div class="text-xs text-red-500">-</div>
                                        </td>
                                    @endif
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

                <!-- Errores de validación -->
                @if(count($teamTotalErrors) > 0)
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-red-800 mb-2">Errores en los importes de las cuotas:</h3>
                                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                                    @foreach($teamTotalErrors as $teamId => $error)
                                        @php
                                            $team = $modalTeams->firstWhere('id', $teamId);
                                        @endphp
                                        <li><strong>{{ $team->team }}:</strong> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Footer Configuración -->
                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button wire:click="closeModal" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancelar
                    </button>

                    @if(count($modalTeams) > 0)
                        <button wire:click="generatePreview"
                            class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-night-blue focus:bg-night-blue active:bg-night-blue focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                            Continuar
                        </button>
                    @endif
                </div>
            @else
                <!-- Previsualización -->
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="text-sm font-semibold text-blue-900">
                            Previsualización de Pagos - {{ $seasons->firstWhere('id', $selectedSeasonId)->season ?? '' }}
                        </span>
                    </div>
                </div>

                <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800">Revisa los datos antes de confirmar</p>
                            <p class="text-xs text-yellow-700 mt-1">Se generarán {{ count($previewData) }} equipos × {{ $numPlazos }} {{ $numPlazos == 1 ? 'plazo' : 'plazos' }} = {{ count($previewData) * $numPlazos }} pagos en total</p>
                        </div>
                    </div>
                </div>

                <div class="max-h-96 overflow-y-auto">
                    @foreach($previewData as $data)
                        <div class="mb-4 border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Cabecera del equipo -->
                            <div class="bg-gradient-to-r from-primary/10 to-primary/5 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">{{ $data['team']->team }}</h4>
                                        <p class="text-xs text-gray-600">{{ $data['team']->section->name ?? '-' }} - Precio matrícula: {{ number_format($data['team']->price, 2) }} €</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $numPlazos }} {{ $numPlazos == 1 ? 'pago' : 'pagos' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagos del equipo -->
                            <div class="bg-white">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cuota</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Fecha Fin</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($data['payments'] as $payment)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 whitespace-nowrap">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary text-white text-xs font-bold">
                                                        {{ $payment['cuota'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $payment['description'] }}</td>
                                                <td class="px-4 py-2 text-right text-sm font-semibold text-green-600">{{ number_format($payment['amount'], 2) }} €</td>
                                                <td class="px-4 py-2 text-center text-xs text-gray-700">{{ \Carbon\Carbon::parse($payment['date_start'])->format('d/m/Y') }}</td>
                                                <td class="px-4 py-2 text-center text-xs text-gray-700">{{ \Carbon\Carbon::parse($payment['date_end'])->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer Previsualización -->
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                    <button wire:click="backToConfig" 
                        wire:loading.attr="disabled"
                        wire:target="confirmAndSave"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver
                    </button>

                    <button wire:click="confirmAndSave"
                        wire:loading.attr="disabled"
                        wire:target="confirmAndSave"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                        <svg wire:loading.remove wire:target="confirmAndSave" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <svg wire:loading wire:target="confirmAndSave" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="confirmAndSave">Confirmar y Guardar</span>
                        <span wire:loading wire:target="confirmAndSave">Guardando...</span>
                    </button>
                </div>
            @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Modal para Eliminar Pagos -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeDeleteModal"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                @if(!$showDeleteConfirm)
                    <!-- Vista previa de pagos a eliminar -->
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Confirmar Eliminación de Pagos
                        </h3>
                        <button wire:click="closeDeleteModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-6">
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-amber-700">
                                        Está a punto de eliminar los siguientes pagos. Por favor, revise cuidadosamente antes de continuar.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            @foreach($deletePreviewData as $data)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="text-base font-semibold text-gray-900">{{ $data['team']->team }}</h4>
                                            <p class="text-sm text-gray-600">{{ $data['team']->section->name ?? '-' }} - {{ $data['team']->season->season ?? '-' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Total a eliminar</p>
                                            <p class="text-lg font-bold text-red-600">{{ number_format($data['total'], 2) }} €</p>
                                        </div>
                                    </div>
                                    
                                    <div class="border-t border-gray-200 pt-3">
                                        <p class="text-xs font-semibold text-gray-700 mb-2">Pagos que se eliminarán ({{ count($data['payments']) }}):</p>
                                        <div class="grid grid-cols-1 gap-2">
                                            @foreach($data['payments'] as $payment)
                                                <div class="flex items-center justify-between text-xs bg-red-50 px-3 py-2 rounded border border-red-200">
                                                    <div class="flex items-center">
                                                        <span class="font-medium text-red-700 mr-2">Cuota {{ $payment->cuota }}:</span>
                                                        <span class="text-gray-700">{{ $payment->description }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-red-600 font-semibold">{{ number_format($payment->amount, 2) }} €</span>
                                                        <span class="text-gray-500">{{ $payment->date_start->format('d/m/Y') }} - {{ $payment->date_end->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button wire:click="closeDeleteModal" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                            Cancelar
                        </button>
                        <button wire:click="showConfirmStep" 
                            class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 font-semibold">
                            Continuar
                        </button>
                    </div>
                @else
                    <!-- Confirmación final -->
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                            <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">¿Está completamente seguro?</h3>
                        <p class="text-gray-600 mb-2">Esta acción eliminará permanentemente:</p>
                        <p class="text-2xl font-bold text-red-600 mb-4">
                            @php
                                $totalPayments = 0;
                                foreach($deletePreviewData as $data) {
                                    $totalPayments += count($data['payments']);
                                }
                            @endphp
                            {{ $totalPayments }} {{ $totalPayments == 1 ? 'pago' : 'pagos' }}
                        </p>
                        <p class="text-sm text-gray-500 mb-6">Esta acción NO se puede deshacer.</p>
                        
                        <div class="flex justify-center gap-3">
                            <button wire:click="closeDeleteModal" 
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                                Cancelar
                            </button>
                            <button wire:click="confirmDelete" 
                                wire:loading.attr="disabled"
                                wire:target="confirmDelete"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold disabled:opacity-50 inline-flex items-center">
                                <svg wire:loading.remove wire:target="confirmDelete" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <svg wire:loading wire:target="confirmDelete" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="confirmDelete">Sí, Eliminar Definitivamente</span>
                                <span wire:loading wire:target="confirmDelete">Eliminando...</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Modal para Editar Pagos de un Equipo -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showEditModal') }">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeEditModal"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Editar Pagos - {{ $editingTeam->team ?? '' }}
                    </h3>
                    <button wire:click="closeEditModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="mb-6">
                    <!-- Información del equipo -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-700"><span class="font-semibold">Precio matrícula:</span> {{ number_format($editingTeam->price ?? 0, 2) }} €</p>
                            </div>
                        </div>
                    </div>

                    <!-- Selector de número de plazos -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Número de Plazos</label>
                        <select wire:model.live="editNumPlazos" 
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Plazo' : 'Plazos' }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Configuración de fechas para cada plazo -->
                    @if($editNumPlazos > 0)
                        <div wire:loading wire:target="editNumPlazos" class="text-center py-8">
                            <div class="inline-flex flex-col items-center">
                                <svg class="animate-spin h-8 w-8 text-blue-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-sm text-gray-700">Actualizando plazos...</p>
                            </div>
                        </div>
                        
                        <div wire:loading.remove wire:target="editNumPlazos" class="space-y-3">
                            <p class="text-sm font-medium text-gray-700 mb-2">Configurar fechas de los plazos:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @for($i = 1; $i <= $editNumPlazos; $i++)
                                    <div class="border border-gray-300 rounded-lg p-3 bg-gray-50">
                                        <div class="flex justify-between items-center mb-2">
                                            <label class="text-xs font-semibold text-gray-700">Cuota {{ $i }}</label>
                                            <span class="text-xs font-bold text-blue-600">
                                                {{ number_format(($editingTeam->price ?? 0) / $editNumPlazos, 2) }} €
                                            </span>
                                        </div>
                                        <div wire:ignore>
                                            <input type="text" 
                                                id="edit_flatpickr_{{ $i }}" 
                                                class="edit-flatpickr-input w-full rounded border-gray-300 text-xs px-2 py-1 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                placeholder="Seleccionar fechas">
                                        </div>
                                        <input type="hidden" wire:model.live="editPlazos.{{ $i }}.date_start" id="edit_date_start_{{ $i }}">
                                        <input type="hidden" wire:model.live="editPlazos.{{ $i }}.date_end" id="edit_date_end_{{ $i }}">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif
                </div>

                @if(!$showEditPreview)
                    <!-- Configuración de plazos -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button wire:click="closeEditModal" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                            Cancelar
                        </button>
                        <button wire:click="generateEditPreview" 
                            class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 font-semibold">
                            Continuar
                        </button>
                    </div>
                @else
                    <!-- Preview de los pagos que se crearán -->
                    <div class="mb-6">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Se eliminarán los pagos anteriores y se crearán {{ count($editPreviewData) }} nuevos pagos.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cuota</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Importe</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Desde</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hasta</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($editPreviewData as $payment)
                                        <tr>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $payment['cuota'] }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-700">{{ $payment['description'] }}</td>
                                            <td class="px-4 py-2 text-sm font-semibold text-green-600 text-right">{{ number_format($payment['amount'], 2) }} €</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $payment['date_start'] }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $payment['date_end'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="2" class="px-4 py-2 text-sm text-gray-900 text-right">Total:</td>
                                        <td class="px-4 py-2 text-sm text-green-600 text-right">{{ number_format($editingTeam->price ?? 0, 2) }} €</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button wire:click="backToEditConfig" 
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                            Volver
                        </button>
                        <button wire:click="updatePayments" 
                            wire:loading.attr="disabled"
                            wire:target="updatePayments"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold disabled:opacity-50 inline-flex items-center">
                            <svg wire:loading.remove wire:target="updatePayments" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <svg wire:loading wire:target="updatePayments" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="updatePayments">Confirmar y Guardar</span>
                            <span wire:loading wire:target="updatePayments">Guardando...</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Modal para Eliminar Pagos de un Equipo Individual -->
    @if($showDeleteSingleModal && $teamToDelete)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="closeDeleteSingleModal"></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Confirmar Eliminación de Pagos
                    </h3>
                    <button wire:click="closeDeleteSingleModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="mb-6">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-red-800">
                                    ¿Está seguro de eliminar TODOS los pagos del equipo?
                                </p>
                                <p class="text-sm text-red-700 mt-1">
                                    Esta acción NO se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Información del equipo -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">{{ $teamToDelete->team }}</h4>
                                <p class="text-sm text-gray-600">
                                    {{ $teamToDelete->section->name ?? '-' }} - {{ $teamToDelete->season->season ?? '-' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Total a eliminar</p>
                                <p class="text-xl font-bold text-red-600">
                                    {{ number_format($teamToDelete->payments->sum('amount'), 2) }} €
                                </p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3">
                            <p class="text-xs font-semibold text-gray-700 mb-2">
                                Pagos que se eliminarán ({{ $teamToDelete->payments->count() }}):
                            </p>
                            <div class="max-h-60 overflow-y-auto">
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($teamToDelete->payments as $payment)
                                        <div class="flex items-center justify-between text-xs bg-red-50 px-3 py-2 rounded border border-red-200">
                                            <div class="flex items-center">
                                                <span class="font-medium text-red-700 mr-2">Cuota {{ $payment->cuota }}:</span>
                                                <span class="text-gray-700">{{ $payment->description }}</span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="text-red-600 font-semibold">{{ number_format($payment->amount, 2) }} €</span>
                                                <span class="text-gray-500 text-[10px]">
                                                    {{ $payment->date_start->format('d/m/Y') }} - {{ $payment->date_end->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button wire:click="closeDeleteSingleModal" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
                        Cancelar
                    </button>
                    <button wire:click="confirmDeleteSingleTeam" 
                        wire:loading.attr="disabled"
                        wire:target="confirmDeleteSingleTeam"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold disabled:opacity-50 inline-flex items-center">
                        <svg wire:loading.remove wire:target="confirmDeleteSingleTeam" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <svg wire:loading wire:target="confirmDeleteSingleTeam" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="confirmDeleteSingleTeam">Sí, Eliminar Todos los Pagos</span>
                        <span wire:loading wire:target="confirmDeleteSingleTeam">Eliminando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    console.log('Script cargado');
    
    let flatpickrInstances = {};
    let editFlatpickrInstances = {};
    
    function initializeFlatpickr() {
        console.log('=== Initializing Flatpickr ===');
        
        // Buscar todos los inputs con clase flatpickr-input
        const inputs = document.querySelectorAll('.flatpickr-input');
        console.log('Found inputs:', inputs.length);
        
        inputs.forEach((element) => {
            const id = element.id;
            const plazoNumber = id.replace('flatpickr-', '');
            
            console.log('Processing:', id);
            
            // Destruir instancia previa si existe
            if (flatpickrInstances[id]) {
                console.log('Destroying previous instance for', id);
                flatpickrInstances[id].destroy();
                delete flatpickrInstances[id];
            }
            
            const dateStartInput = document.getElementById('date_start_' + plazoNumber);
            const dateEndInput = document.getElementById('date_end_' + plazoNumber);
            
            if (!dateStartInput || !dateEndInput) {
                console.log('Hidden inputs not found for plazo', plazoNumber);
                return;
            }
            
            console.log('Creating Flatpickr for', id);
            
            // Obtener valores iniciales si existen
            const startDate = dateStartInput.value || null;
            const endDate = dateEndInput.value || null;
            const defaultDates = (startDate && endDate) ? [startDate, endDate] : [];
            
            flatpickrInstances[id] = flatpickr(element, {
                mode: 'range',
                dateFormat: 'd/m/Y',
                locale: 'es',
                defaultDate: defaultDates,
                allowInput: false,
                clickOpens: true,
                onReady: function() {
                    console.log('✓ Flatpickr ready for', id);
                },
                onChange: function(selectedDates, dateStr, instance) {
                    console.log('Date changed for', id, selectedDates);
                    
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
                        
                        const formattedStart = formatDate(startDate);
                        const formattedEnd = formatDate(endDate);
                        
                        dateStartInput.value = formattedStart;
                        dateEndInput.value = formattedEnd;
                        
                        // Disparar evento para que Livewire lo detecte
                        dateStartInput.dispatchEvent(new Event('input', { bubbles: true }));
                        dateEndInput.dispatchEvent(new Event('input', { bubbles: true }));
                        
                        console.log('✓ Set dates:', formattedStart, formattedEnd);
                    }
                }
            });
            
            console.log('✓ Flatpickr instance created for', id);
        });
    }
    
    // Inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            setupObserver();
        });
    } else {
        console.log('DOM already loaded');
        setupObserver();
    }
    
    function setupObserver() {
        console.log('Setting up observer');
        
        // Observar cambios en el DOM para detectar cuando se crea el modal
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Solo elementos
                            if (node.classList && (node.classList.contains('flatpickr-input') || node.classList.contains('edit-flatpickr-input'))) {
                                console.log('Flatpickr input added directly');
                                setTimeout(() => {
                                    initializeFlatpickr();
                                    initializeEditFlatpickr();
                                }, 100);
                            } else if (node.querySelectorAll) {
                                const inputs = node.querySelectorAll('.flatpickr-input');
                                const editInputs = node.querySelectorAll('.edit-flatpickr-input');
                                if (inputs.length > 0 || editInputs.length > 0) {
                                    console.log('Flatpickr inputs detected in added node:', inputs.length + editInputs.length);
                                    setTimeout(() => {
                                        initializeFlatpickr();
                                        initializeEditFlatpickr();
                                    }, 100);
                                }
                            }
                        }
                    });
                }
            });
        });
        
        // Observar todo el body
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        console.log('Observer set up');
        
        // También inicializar si ya existe el modal
        setTimeout(() => {
            const existing = document.querySelectorAll('.flatpickr-input, .edit-flatpickr-input');
            if (existing.length > 0) {
                console.log('Found existing inputs:', existing.length);
                initializeFlatpickr();
                initializeEditFlatpickr();
            }
        }, 500);
    }

    function initializeEditFlatpickr() {
        console.log('=== Initializing Edit Flatpickr ===');
        
        const inputs = document.querySelectorAll('.edit-flatpickr-input');
        console.log('Found edit inputs:', inputs.length);
        
        inputs.forEach((element) => {
            const id = element.id;
            const plazoNumber = id.replace('edit_flatpickr_', '');
            
            console.log('Processing edit:', id);
            
            if (editFlatpickrInstances[id]) {
                console.log('Destroying previous edit instance for', id);
                editFlatpickrInstances[id].destroy();
                delete editFlatpickrInstances[id];
            }
            
            const dateStartInput = document.getElementById('edit_date_start_' + plazoNumber);
            const dateEndInput = document.getElementById('edit_date_end_' + plazoNumber);
            
            if (!dateStartInput || !dateEndInput) {
                console.log('Hidden inputs not found for edit plazo', plazoNumber);
                return;
            }
            
            console.log('Creating Edit Flatpickr for', id);
            
            const startDate = dateStartInput.value || null;
            const endDate = dateEndInput.value || null;
            const defaultDates = (startDate && endDate) ? [startDate, endDate] : [];
            
            editFlatpickrInstances[id] = flatpickr(element, {
                mode: 'range',
                dateFormat: 'd/m/Y',
                locale: 'es',
                defaultDate: defaultDates,
                allowInput: false,
                clickOpens: true,
                onReady: function() {
                    console.log('✓ Edit Flatpickr ready for', id);
                },
                onChange: function(selectedDates, dateStr, instance) {
                    console.log('Edit date changed for', id, selectedDates);
                    
                    if (selectedDates.length === 2) {
                        const startDate = selectedDates[0];
                        const endDate = selectedDates[1];
                        
                        const formatDate = (date) => {
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        };
                        
                        const formattedStart = formatDate(startDate);
                        const formattedEnd = formatDate(endDate);
                        
                        console.log('Setting edit dates:', formattedStart, formattedEnd);
                        
                        dateStartInput.value = formattedStart;
                        dateEndInput.value = formattedEnd;
                        
                        dateStartInput.dispatchEvent(new Event('input'));
                        dateEndInput.dispatchEvent(new Event('input'));
                        
                        @this.set('editPlazos.' + plazoNumber + '.date_start', formattedStart);
                        @this.set('editPlazos.' + plazoNumber + '.date_end', formattedEnd);
                    }
                }
            });
            
            console.log('✓ Edit Flatpickr created for', id);
        });
    }

</script>

</div>