<div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <!-- Mensajes de feedback -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-2xl font-bold text-black-deep">Cartas de Pago</h2>
                @if($activeSeason)
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-semibold text-primary">{{ $players->total() }}</span> 
                        {{ $players->total() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}
                    </p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="generatePaymentOrders" 
                    wire:loading.attr="disabled"
                    wire:target="generatePaymentOrders"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                    <svg wire:loading.remove wire:target="generatePaymentOrders" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <svg wire:loading wire:target="generatePaymentOrders" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="generatePaymentOrders">Generar Cartas de Pago</span>
                    <span wire:loading wire:target="generatePaymentOrders">Generando...</span>
                </button>
                
                {{-- @if($activeSeason)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $activeSeason->season }} en curso
                    </span>
                @endif --}}
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="Buscar jugadores..." 
                    class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
            </div>
            
            <div>
                <select wire:model.live="seasonFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
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
            
            <div>
                <select wire:model.live="categoryFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select wire:model.live="cuotaFilter" 
                    class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <option value="">Todas las cuotas</option>
                    <option value="1">Primera cuota</option>
                    <option value="2">Segunda cuota</option>
                    <option value="3">Tercera cuota</option>
                    <option value="4">Cuarta cuota</option>
                    <option value="5">Quinta cuota</option>
                    <option value="6">Sexta cuota</option>
                    <option value="7">Séptima cuota</option>
                    <option value="8">Octava cuota</option>
                    <option value="9">Novena cuota</option>
                    <option value="10">Décima cuota</option>
                    <option value="11">Undécima cuota</option>
                    <option value="12">Duodécima cuota</option>
                </select>
            </div>

            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="pendingPaymentsOnly" 
                        class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                    <span class="ml-3 text-sm font-semibold text-black-deep">Solo pagos pendientes</span>
                </label>
            </div>
        </div>

        <!-- Botón de acciones en lote -->
        @if(count($selectedPlayers) > 0)
            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">
                        {{ count($selectedPlayers) }} {{ count($selectedPlayers) === 1 ? 'jugador seleccionado' : 'jugadores seleccionados' }}
                    </span>
                </div>
                <button wire:click="openStateChangeModal" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Cambiar Estado
                </button>
            </div>
        @endif

        <!-- Tabla de jugadores -->
        <div class="overflow-x-auto max-h-[calc(100vh-400px)] overflow-y-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" wire:model.live="selectAll" 
                                class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Jugador</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tutor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Códigos de Pago</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Cuotas de Pago</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($players as $player)
                        <tr class="hover:bg-primary/5">
                            <td class="px-6 py-4">
                                <input type="checkbox" wire:model.live="selectedPlayers" value="{{ $player->id }}" 
                                    class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($player->profile_photo_path)
                                        <img src="{{ asset('storage/' . $player->profile_photo_path) }}" 
                                            class="w-10 h-10 rounded-full object-cover border border-silver mr-3">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center border border-silver mr-3">
                                            <span class="text-primary text-sm font-semibold">{{ substr($player->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-semibold text-black-deep">{{ $player->name }} {{ $player->surname }}</div>
                                        @if($player->dbirth)
                                            <div class="text-xs text-gray-500">{{ $player->dbirth->age }} años</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $player->nametutor ? $player->nametutor . ' ' . ($player->surnametutor ?? '') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $player->phone1 ?? $player->phone2 ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $player->teams->first()->team ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($player->paymentPlayers->count() > 0)
                                    <div class="flex flex-col gap-1">
                                        @foreach($player->paymentPlayers->sortBy('cuota') as $payment)
                                            <span class="text-xs font-mono text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-200">
                                                C{{ $payment->cuota }}: {{ $payment->code }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->paymentPlayers->count() > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($player->paymentPlayers->sortBy('cuota') as $payment)
                                            @php
                                                $now = now();
                                                $dateStart = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_start) : null;
                                                $dateEnd = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_end) : null;
                                                
                                                // Determinar el estado
                                                if ($payment->state == 1) {
                                                    $status = 'paid'; // Pagada
                                                    $statusText = 'Pagada';
                                                    $bgColor = 'bg-green-100';
                                                    $textColor = 'text-green-800';
                                                    $borderColor = 'border-green-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
                                                } elseif ($dateEnd && $now->isAfter($dateEnd)) {
                                                    $status = 'unpaid'; // Impagada
                                                    $statusText = 'Impagada';
                                                    $bgColor = 'bg-red-100';
                                                    $textColor = 'text-red-800';
                                                    $borderColor = 'border-red-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                                                } elseif ($dateStart && $dateEnd && $now->between($dateStart, $dateEnd)) {
                                                    $status = 'in-term'; // En plazo
                                                    $statusText = 'En plazo';
                                                    $bgColor = 'bg-blue-100';
                                                    $textColor = 'text-blue-800';
                                                    $borderColor = 'border-blue-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>';
                                                } elseif ($dateStart && $now->isBefore($dateStart)) {
                                                    $status = 'not-executed'; // No ejecutada
                                                    $statusText = 'No ejecutada';
                                                    $bgColor = 'bg-gray-100';
                                                    $textColor = 'text-gray-800';
                                                    $borderColor = 'border-gray-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>';
                                                } else {
                                                    $status = 'pending'; // Pendiente (por defecto)
                                                    $statusText = 'Pendiente';
                                                    $bgColor = 'bg-amber-100';
                                                    $textColor = 'text-amber-800';
                                                    $borderColor = 'border-amber-300';
                                                    $icon = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>';
                                                }
                                            @endphp
                                            <div class="inline-flex items-start">
                                                <span class="inline-flex flex-col px-3 py-2 rounded-lg text-xs font-semibold {{ $bgColor }} {{ $textColor }} border {{ $borderColor }}">
                                                    <span class="flex items-center mb-1">
                                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                            {!! $icon !!}
                                                        </svg>
                                                        {{ $payment->cuota }} - {{ $statusText }}
                                                    </span>
                                                    @if($dateStart && $dateEnd)
                                                        <span class="text-xs {{ str_replace('800', '700', $textColor) }} font-normal">
                                                            {{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-300">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Sin pagos generados
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($player->paymentPlayers->count() > 0)
                                        <a href="{{ route('pay-orders.show', $player->id) }}" 
                                            wire:navigate
                                            class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver Cartas
                                        </a>
                                        <button wire:click="confirmDeletePlayerPayments({{ $player->id }})" 
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    @else
                                        <button wire:click="generateSinglePlayerPayments({{ $player->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="generateSinglePlayerPayments({{ $player->id }})"
                                            class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-xs font-semibold disabled:opacity-50">
                                            <svg wire:loading.remove wire:target="generateSinglePlayerPayments({{ $player->id }})" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <svg wire:loading wire:target="generateSinglePlayerPayments({{ $player->id }})" class="animate-spin w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove wire:target="generateSinglePlayerPayments({{ $player->id }})">Generar Pagos</span>
                                            <span wire:loading wire:target="generateSinglePlayerPayments({{ $player->id }})">Generando...</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No se encontraron jugadores</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($players->hasPages())
            <div class="mt-6 border-t border-silver/30 pt-4">
                {{ $players->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de confirmación de eliminación -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showDeleteModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Confirmar eliminación
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que deseas eliminar todas las cartas de pago de <strong>{{ $playerToDelete?->name }} {{ $playerToDelete?->surname }}</strong>?
                                    </p>
                                    <p class="text-sm text-red-600 mt-2 font-semibold">
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deletePlayerPayments" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button wire:click="$set('showDeleteModal', false)" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de cambio de estado en lote -->
    @if($showStateChangeModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeStateChangeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Cambiar estado de pagos
                                </h3>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Vas a cambiar el estado para <strong>{{ count($selectedPlayers) }} {{ count($selectedPlayers) === 1 ? 'jugador' : 'jugadores' }}</strong>.
                                    </p>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona la cuota</label>
                                            <select wire:model="stateChangeCuota" 
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">-- Selecciona una cuota --</option>
                                                <option value="1">Primera cuota</option>
                                                <option value="2">Segunda cuota</option>
                                                <option value="3">Tercera cuota</option>
                                                <option value="4">Cuarta cuota</option>
                                                <option value="5">Quinta cuota</option>
                                                <option value="6">Sexta cuota</option>
                                                <option value="7">Séptima cuota</option>
                                                <option value="8">Octava cuota</option>
                                                <option value="9">Novena cuota</option>
                                                <option value="10">Décima cuota</option>
                                                <option value="11">Undécima cuota</option>
                                                <option value="12">Duodécima cuota</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nuevo estado</label>
                                            <select wire:model="stateChangeNewState" 
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                <option value="">-- Selecciona un estado --</option>
                                                <option value="0">Pendiente de pago</option>
                                                <option value="1">Pagado</option>
                                                <option value="2">Lesión</option>
                                                <option value="3">Baja Jugador</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <div class="p-3 bg-amber-50 border-l-4 border-amber-500 rounded">
                                            <p class="text-xs text-amber-700">
                                                <strong>Nota:</strong> Esta acción actualizará el estado de la cuota seleccionada para todos los jugadores marcados.
                                            </p>
                                        </div>
                                        
                                        @if($pendingPaymentsOnly)
                                            <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                                                <p class="text-xs text-blue-700">
                                                    <strong>Filtro activo:</strong> Tienes activado "Solo pagos pendientes". Los jugadores sin pagos pendientes podrían no mostrarse después de actualizar.
                                                </p>
                                            </div>
                                        @endif
                                        
                                        @if($cuotaFilter)
                                            <div class="p-3 bg-purple-50 border-l-4 border-purple-500 rounded">
                                                <p class="text-xs text-purple-700">
                                                    <strong>Filtro activo:</strong> Estás filtrando por cuota específica. La lista se actualizará según tus filtros activos.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="bulkUpdateState" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Actualizar Estados
                        </button>
                        <button wire:click="closeStateChangeModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
                document.documentElement.style.overflow = '';
                document.documentElement.classList.remove('overflow-hidden');
                setTimeout(() => {
                    document.body.removeAttribute('style');
                    document.body.classList.remove('overflow-hidden', 'overflow-y-hidden');
                    window.scrollTo(window.scrollX, window.scrollY);
                }, 150);
            });
        });
    </script>
</div>
