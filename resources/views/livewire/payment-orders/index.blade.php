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
                
                @if($activeSeason)
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $activeSeason->season }} en curso
                    </span>
                @endif
            </div>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
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

        <!-- Tabla de jugadores -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Jugador</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tutor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Cuotas de Pago</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($players as $player)
                        <tr class="hover:bg-primary/5">
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
                                @if($player->paymentPlayers->count() > 0)
                                    <button class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver Cartas
                                    </button>
                                @else
                                    <div class="text-xs text-gray-500 italic">No hay órdenes de pago generadas</div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
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
</div>
