<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header con información del jugador -->
        <div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <a href="{{ route('pay-orders.index') }}" class="inline-flex items-center text-primary hover:text-night-blue mr-4">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver
                        </a>
                        <h2 class="text-2xl font-bold text-black-deep">Cartas de Pago</h2>
                    </div>
                </div>

                <!-- Información del jugador -->
                <div class="bg-gradient-to-r from-primary/5 to-primary/10 rounded-lg p-6 border border-primary/20">
                    <div class="flex items-center">
                        @if($player->profile_photo_path)
                            <img src="{{ asset('storage/' . $player->profile_photo_path) }}" 
                                class="w-20 h-20 rounded-full object-cover border-2 border-primary mr-6">
                        @else
                            <div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center border-2 border-primary mr-6">
                                <span class="text-primary text-2xl font-bold">{{ substr($player->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-black-deep mb-2">{{ $player->name }} {{ $player->surname }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600 font-semibold">DNI:</span>
                                    <span class="text-gray-900 ml-2">{{ $player->dni ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-semibold">Edad:</span>
                                    <span class="text-gray-900 ml-2">{{ $player->dbirth ? $player->dbirth->age . ' años' : '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-semibold">Teléfono:</span>
                                    <span class="text-gray-900 ml-2">{{ $player->phone1 ?? $player->phone2 ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-semibold">Tutor:</span>
                                    <span class="text-gray-900 ml-2">{{ $player->nametutor ? $player->nametutor . ' ' . ($player->surnametutor ?? '') : '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-semibold">Equipo:</span>
                                    <span class="text-gray-900 ml-2">{{ $player->teams->first()->team ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 font-semibold">Categoría:</span>
                                    <span class="text-gray-900 ml-2">{{ $player->teams->first()->category->category ?? '-' }}</span>
                                </div>
                            </div>
                            
                            @php
                                $totalDescEnt = $payments->sum('descEnt');
                                $totalDescPerc = $payments->first()->descPerc ?? 0; // El porcentaje es el mismo para todas las cuotas
                            @endphp
                            @if($totalDescEnt > 0 || $totalDescPerc > 0)
                                <div class="mt-4 inline-flex items-center px-4 py-2 bg-yellow-100 border border-yellow-300 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-yellow-800">
                                        Descuentos aplicados:
                                        @if($totalDescEnt > 0) {{ number_format($totalDescEnt, 2) }}€ @endif
                                        @if($totalDescEnt > 0 && $totalDescPerc > 0) + @endif
                                        @if($totalDescPerc > 0) {{ number_format($totalDescPerc, 2) }}% @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartas de pago -->
        <div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-bold text-black-deep mb-6">Desglose de Cartas de Pago</h3>
                
                @if($payments->count() > 0)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($payments as $payment)
                            @php
                                $now = now();
                                $dateStart = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_start) : null;
                                $dateEnd = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_end) : null;
                                
                                // Determinar el estado según el campo state
                                if ($payment->state == 1) {
                                    $statusText = 'Pagada';
                                    $bgColor = 'bg-green-50';
                                    $borderColor = 'border-green-300';
                                    $textColor = 'text-green-800';
                                    $badgeBg = 'bg-green-100';
                                } elseif ($payment->state == 2) {
                                    $statusText = 'Lesión';
                                    $bgColor = 'bg-orange-50';
                                    $borderColor = 'border-orange-300';
                                    $textColor = 'text-orange-800';
                                    $badgeBg = 'bg-orange-100';
                                } elseif ($payment->state == 3) {
                                    $statusText = 'Baja Jugador';
                                    $bgColor = 'bg-purple-50';
                                    $borderColor = 'border-purple-300';
                                    $textColor = 'text-purple-800';
                                    $badgeBg = 'bg-purple-100';
                                } elseif ($dateEnd && $now->isAfter($dateEnd)) {
                                    $statusText = 'Impagada';
                                    $bgColor = 'bg-red-50';
                                    $borderColor = 'border-red-300';
                                    $textColor = 'text-red-800';
                                    $badgeBg = 'bg-red-100';
                                } elseif ($dateStart && $dateEnd && $now->between($dateStart, $dateEnd)) {
                                    $statusText = 'En plazo';
                                    $bgColor = 'bg-blue-50';
                                    $borderColor = 'border-blue-300';
                                    $textColor = 'text-blue-800';
                                    $badgeBg = 'bg-blue-100';
                                } elseif ($dateStart && $now->isBefore($dateStart)) {
                                    $statusText = 'No ejecutada';
                                    $bgColor = 'bg-gray-50';
                                    $borderColor = 'border-gray-300';
                                    $textColor = 'text-gray-800';
                                    $badgeBg = 'bg-gray-100';
                                } else {
                                    $statusText = 'Pendiente';
                                    $bgColor = 'bg-amber-50';
                                    $borderColor = 'border-amber-300';
                                    $textColor = 'text-amber-800';
                                    $badgeBg = 'bg-amber-100';
                                }
                            @endphp
                            
                            <div class="border-2 {{ $borderColor }} {{ $bgColor }} rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <span class="text-2xl font-bold {{ $textColor }} mr-4">{{ $payment->cuota }}</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $badgeBg }} {{ $textColor }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600 font-semibold">Código de Pago</div>
                                        <div class="text-lg font-bold text-black-deep">{{ $payment->code }}</div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                                        <div class="text-sm text-gray-600 font-semibold mb-1">Período de Pago</div>
                                        <div class="text-base font-bold text-gray-900">
                                            @if($dateStart && $dateEnd)
                                                {{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}
                                            @else
                                                No especificado
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                                        <div class="text-sm text-gray-600 font-semibold mb-1">Importe Original</div>
                                        <div class="text-base font-bold text-gray-900">
                                            {{ number_format($payment->amount_original ?? $payment->amount, 2) }} €
                                        </div>
                                    </div>
                                    
                                    @if($payment->descEnt || $payment->descPerc)
                                        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                                            <div class="text-sm text-yellow-700 font-semibold mb-1">Descuentos Aplicados</div>
                                            <div class="text-base font-bold text-yellow-900">
                                                @if($payment->descEnt) {{ number_format($payment->descEnt, 2) }}€ @endif
                                                @if($payment->descEnt && $payment->descPerc) + @endif
                                                @if($payment->descPerc) {{ number_format($payment->descPerc, 2) }}% @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                        <div class="text-sm text-green-700 font-semibold mb-1">Importe Final a Pagar</div>
                                        <div class="text-xl font-bold text-green-900">
                                            {{ number_format($payment->amount, 2) }} €
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Estado y acciones -->
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cambiar Estado</label>
                                            <select wire:change="updatePaymentState({{ $payment->id }}, $event.target.value)" 
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
                                                @foreach(config('constants.states_payment_orders') as $label => $value)
                                                    <option value="{{ $value }}" {{ $payment->state == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if($payment->state == 0)
                                            <div class="ml-4">
                                                <a href="{{ route('pay-orders.download-pdf', $payment->id) }}" 
                                                    target="_blank"
                                                    class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-sm font-semibold shadow-md">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Descargar PDF
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($payment->state == 1 && $payment->payment_date)
                                        <div class="mt-3 bg-white rounded-lg p-3 border border-gray-200">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-600 font-semibold">Fecha de Pago:</span>
                                                    <span class="text-gray-900 ml-2">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}</span>
                                                </div>
                                                @if($payment->payment_type)
                                                    <div>
                                                        <span class="text-gray-600 font-semibold">Método:</span>
                                                        <span class="text-gray-900 ml-2">{{ ucfirst($payment->payment_type) }}</span>
                                                    </div>
                                                @endif
                                                @if($payment->payment_auth)
                                                    <div>
                                                        <span class="text-gray-600 font-semibold">Autorización:</span>
                                                        <span class="text-gray-900 ml-2">{{ $payment->payment_auth }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mt-3 flex justify-end">
                                                <a href="{{ route('pay-orders.download-receipt', $payment->id) }}" 
                                                    target="_blank"
                                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm font-semibold shadow-md">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Descargar Recibo
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Resumen total -->
                    <div class="mt-6 bg-gradient-to-r from-primary/10 to-primary/5 rounded-lg p-6 border-2 border-primary/30">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                            <div>
                                <div class="text-sm text-gray-600 font-semibold mb-1">Total de Cuotas</div>
                                <div class="text-2xl font-bold text-primary">{{ $payments->count() }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 font-semibold mb-1">Importe Total Original</div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ number_format($payments->sum(function($p) { return $p->amount_original ?? $p->amount; }), 2) }} €
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 font-semibold mb-1">Total Descuentos</div>
                                <div class="text-2xl font-bold text-yellow-600">
                                    -{{ number_format($payments->sum(function($p) { return ($p->amount_original ?? $p->amount) - $p->amount; }), 2) }} €
                                </div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600 font-semibold mb-1">Total a Pagar</div>
                                <div class="text-2xl font-bold text-green-600">
                                    {{ number_format($payments->sum('amount'), 2) }} €
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No hay cartas de pago generadas para este jugador</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
