<div class="min-h-screen bg-gray-50 pb-28 relative">

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('pay-orders.index') }}" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all flex-shrink-0"
               title="Volver">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="min-w-0">
                <h2 class="font-black text-base text-titanium truncate leading-tight">
                    Cartas de Pago
                </h2>
                <p class="text-[11px] font-bold text-gray-400 truncate">
                    {{ $player->name }} {{ $player->surname }}
                </p>
            </div>
        </div>

        <span class="px-2.5 py-1 rounded-full bg-primary/10 text-primary font-black text-[10px] uppercase tracking-wider flex-shrink-0">
            {{ $payments->count() }} {{ $payments->count() === 1 ? 'Cuota' : 'Cuotas' }}
        </span>
    </header>

    <div class="p-4 space-y-4">

        {{-- FLASH MESSAGES --}}
        @if(session()->has('mail_message'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs font-bold text-emerald-800">{{ session('mail_message') }}</p>
            </div>
        @endif

        {{-- PERFIL DEL JUGADOR --}}
        <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    @if($player->profile_photo_path)
                        <img src="{{ asset('storage/' . $player->profile_photo_path) }}" 
                             class="w-16 h-16 rounded-full object-cover border-2 border-primary/20 shadow-sm">
                    @else
                        <div class="w-16 h-16 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-xl shadow-sm border border-primary/20">
                            {{ substr($player->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-black text-lg text-titanium truncate leading-tight">
                        {{ $player->name }} {{ $player->surname }}
                    </h3>
                    <p class="text-xs font-bold text-gray-400 mt-0.5 truncate">
                        {{ $player->teams->first()->team ?? 'Sin equipo' }} • {{ $player->teams->first()->category->category ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- METRICAS DEL JUGADOR --}}
            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-50 text-xs">
                <div class="bg-gray-50 rounded-2xl p-2.5">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">DNI / NIE</span>
                    <span class="font-black text-titanium">{{ $player->dni ?? '-' }}</span>
                </div>

                <div class="bg-gray-50 rounded-2xl p-2.5">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Edad</span>
                    <span class="font-black text-titanium">{{ $player->dbirth ? $player->dbirth->age . ' años' : '-' }}</span>
                </div>

                <div class="bg-gray-50 rounded-2xl p-2.5">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Teléfono</span>
                    <span class="font-black text-titanium truncate block">{{ $player->phone1 ?? $player->phone2 ?? '-' }}</span>
                </div>

                <div class="bg-gray-50 rounded-2xl p-2.5 min-w-0">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Tutor Legal</span>
                    <span class="font-black text-titanium truncate block">{{ $player->nametutor ? $player->nametutor . ' ' . ($player->surnametutor ?? '') : '-' }}</span>
                </div>
            </div>

            {{-- DESCUENTOS APLICADOS --}}
            @php
                $totalDescEnt = $payments->sum('descEnt');
                $totalDescPerc = $payments->first()->descPerc ?? 0;
            @endphp
            @if($totalDescEnt > 0 || $totalDescPerc > 0)
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-2xl flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-xs font-bold text-amber-800">
                        Descuentos: 
                        @if($totalDescEnt > 0) {{ number_format($totalDescEnt, 2) }}€ @endif
                        @if($totalDescEnt > 0 && $totalDescPerc > 0) + @endif
                        @if($totalDescPerc > 0) {{ number_format($totalDescPerc, 2) }}% @endif
                    </p>
                </div>
            @endif
        </section>

        {{-- LISTADO DE CARTAS DE PAGO --}}
        <section class="space-y-3">
            <h3 class="font-bold text-base text-titanium px-1 flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Desglose de Cartas de Pago
            </h3>

            @if($payments->count() > 0)
                <div class="space-y-3">
                    @foreach($payments as $payment)
                        @php
                            $now = now();
                            $dateStart = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_start) : null;
                            $dateEnd = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_end) : null;
                            
                            if ($payment->state == 1) {
                                $statusText = 'Pagada'; $bgColor = 'bg-green-50 border-green-200'; $textColor = 'text-green-800'; $badgeBg = 'bg-green-100 text-green-800';
                            } elseif ($payment->state == 2) {
                                $statusText = 'Lesión'; $bgColor = 'bg-orange-50 border-orange-200'; $textColor = 'text-orange-800'; $badgeBg = 'bg-orange-100 text-orange-800';
                            } elseif ($payment->state == 3) {
                                $statusText = 'Baja Jugador'; $bgColor = 'bg-purple-50 border-purple-200'; $textColor = 'text-purple-800'; $badgeBg = 'bg-purple-100 text-purple-800';
                            } elseif ($dateEnd && $now->isAfter($dateEnd)) {
                                $statusText = 'Impagada'; $bgColor = 'bg-red-50 border-red-200'; $textColor = 'text-red-800'; $badgeBg = 'bg-red-100 text-red-800';
                            } elseif ($dateStart && $dateEnd && $now->between($dateStart, $dateEnd)) {
                                $statusText = 'En plazo'; $bgColor = 'bg-blue-50 border-blue-200'; $textColor = 'text-blue-800'; $badgeBg = 'bg-blue-100 text-blue-800';
                            } elseif ($dateStart && $now->isBefore($dateStart)) {
                                $statusText = 'No ejecutada'; $bgColor = 'bg-gray-50 border-gray-200'; $textColor = 'text-gray-800'; $badgeBg = 'bg-gray-100 text-gray-800';
                            } else {
                                $statusText = 'Pendiente'; $bgColor = 'bg-amber-50 border-amber-200'; $textColor = 'text-amber-800'; $badgeBg = 'bg-amber-100 text-amber-800';
                            }
                        @endphp

                        <article class="bg-white-pure rounded-3xl p-5 shadow-sm border-2 {{ $bgColor }} space-y-3">
                            
                            {{-- Cabecera Tarjeta --}}
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-black text-sm shadow-sm">
                                        {{ $payment->cuota }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $badgeBg }}">
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-gray-400 block uppercase">Código</span>
                                    <span class="font-mono font-black text-sm text-titanium">#{!! $payment->id !!} • {{ $payment->code }}</span>
                                    @if($payment->notification > 0)
                                        <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800 mt-0.5" 
                                              title="Notificado {{ $payment->notification }} veces. Última: {{ $payment->dtnotification?->format('d/m/Y H:i') }}">
                                            📩 {{ $payment->notification }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Fechas e Importe --}}
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="bg-white/80 rounded-2xl p-2.5 border border-gray-100">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase block mb-0.5">Período de Pago</span>
                                    <span class="font-bold text-titanium block">
                                        @if($dateStart && $dateEnd)
                                            {{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}
                                        @else
                                            No especificado
                                        @endif
                                    </span>
                                </div>

                                <div class="bg-white/80 rounded-2xl p-2.5 border border-gray-100 text-right">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase block mb-0.5">Importe Final</span>
                                    <span class="font-black text-base text-green-600 block leading-tight">{{ number_format($payment->amount, 2) }} €</span>
                                    @if($payment->amount_original && $payment->amount_original != $payment->amount)
                                        <span class="text-[10px] text-gray-400 line-through font-bold block">{{ number_format($payment->amount_original, 2) }} €</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Selector de Estado --}}
                            <div class="space-y-1 pt-1">
                                <label class="block text-[10px] font-bold text-titanium uppercase tracking-wider">Cambiar Estado</label>
                                <select wire:change="updatePaymentState({{ $payment->id }}, $event.target.value)" 
                                        class="w-full px-4 py-3 bg-white border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary shadow-sm">
                                    @foreach(config('constants.states_payment_orders') as $label => $value)
                                        <option value="{{ $value }}" {{ $payment->state == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Acciones individuales de la cuota (Si está pendiente state == 0) --}}
                            @if($payment->state == 0)
                                <div class="grid grid-cols-2 gap-2 pt-2">
                                    <a href="{{ route('pay-orders.download-pdf', $payment->id) }}" 
                                       class="py-3 px-3 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Descargar PDF
                                    </a>

                                    <button wire:click="sendPaymentLetters({{ $payment->id }})" 
                                            wire:loading.attr="disabled" 
                                            wire:target="sendPaymentLetters({{ $payment->id }})"
                                            class="py-3 px-3 bg-emerald-600 text-white font-bold text-xs rounded-2xl active:scale-95 transition-all flex items-center justify-center gap-1 shadow-sm">
                                        <svg wire:loading.remove wire:target="sendPaymentLetters({{ $payment->id }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                        <svg wire:loading wire:target="sendPaymentLetters({{ $payment->id }})" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span wire:loading.remove wire:target="sendPaymentLetters({{ $payment->id }})">Enviar Email</span>
                                        <span wire:loading wire:target="sendPaymentLetters({{ $payment->id }})">Enviando...</span>
                                    </button>
                                </div>
                            @endif

                            {{-- Información de Pago Realizado --}}
                            @if($payment->state == 1 && $payment->payment_date)
                                <div class="p-3 bg-white/80 rounded-2xl border border-green-200 space-y-2 text-xs">
                                    <div class="flex justify-between items-center text-[11px] font-bold text-green-900">
                                        <span>Pagado el: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}</span>
                                        @if($payment->payment_type)<span class="uppercase font-black text-gray-500">{{ $payment->payment_type }}</span>@endif
                                    </div>
                                    @if($payment->payment_auth)
                                        <p class="text-[10px] text-gray-500 font-mono">Auth: {{ $payment->payment_auth }}</p>
                                    @endif
                                    <a href="{{ route('pay-orders.download-receipt', $payment->id) }}" target="_blank" 
                                       class="block w-full py-2.5 bg-green-600 text-white font-bold text-xs rounded-xl text-center active:scale-95 transition-all shadow-sm">
                                        Descargar Recibo
                                    </a>
                                </div>
                            @endif

                            {{-- Justificante Adjunto --}}
                            @if($payment->payment_receipt)
                                @php
                                    $receiptUrl = asset('storage/' . $payment->payment_receipt);
                                    $receiptExt = strtolower(pathinfo($payment->payment_receipt, PATHINFO_EXTENSION));
                                    $isImage = in_array($receiptExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                <div class="p-3 bg-white/80 rounded-2xl border border-gray-200 space-y-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="font-bold text-titanium">Justificante de pago ({{ strtoupper($receiptExt) }})</span>
                                        <a href="{{ $receiptUrl }}" target="_blank" class="text-primary font-bold text-xs underline">Abrir</a>
                                    </div>
                                    @if($isImage)
                                        <a href="{{ $receiptUrl }}" target="_blank" class="block">
                                            <img src="{{ $receiptUrl }}" class="max-h-40 w-full object-cover rounded-xl border border-gray-100">
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>

                {{-- TARJETA DE RESUMEN GLOBAL --}}
                <section class="bg-gradient-to-br from-primary/10 via-primary/5 to-white-pure rounded-3xl p-5 shadow-sm border border-primary/20 space-y-3">
                    <h4 class="font-black text-xs uppercase tracking-wider text-primary">Resumen Financiero Total</h4>
                    
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="bg-white/80 rounded-2xl p-3 border border-primary/10">
                            <span class="text-[10px] font-bold text-gray-400 uppercase block mb-0.5">Total Cuotas</span>
                            <span class="font-black text-titanium text-lg">{{ $payments->count() }}</span>
                        </div>

                        <div class="bg-white/80 rounded-2xl p-3 border border-primary/10">
                            <span class="text-[10px] font-bold text-gray-400 uppercase block mb-0.5">Original Total</span>
                            <span class="font-black text-titanium text-lg">{{ number_format($payments->sum(function($p) { return $p->amount_original ?? $p->amount; }), 2) }} €</span>
                        </div>

                        <div class="bg-white/80 rounded-2xl p-3 border border-primary/10">
                            <span class="text-[10px] font-bold text-gray-400 uppercase block mb-0.5">Descuentos</span>
                            <span class="font-black text-amber-600 text-lg">-{{ number_format($payments->sum(function($p) { return ($p->amount_original ?? $p->amount) - $p->amount; }), 2) }} €</span>
                        </div>

                        <div class="bg-white/80 rounded-2xl p-3 border border-primary/10">
                            <span class="text-[10px] font-bold text-gray-400 uppercase block mb-0.5">Total a Pagar</span>
                            <span class="font-black text-green-600 text-lg">{{ number_format($payments->sum('amount'), 2) }} €</span>
                        </div>
                    </div>
                </section>
            @else
                <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100 space-y-2">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="font-bold text-sm text-titanium">Sin cartas de pago</p>
                    <p class="text-xs text-gray-400">No hay cartas de pago generadas para este jugador.</p>
                </div>
            @endif
        </section>
    </div>

    {{-- BOTTOM APP BAR (Fijo Abajo) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-2">
        <a href="{{ route('pay-orders.index') }}" 
           class="w-full py-4 bg-gray-100 text-titanium font-black text-sm rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Volver a Cartas de Pago</span>
        </a>
    </div>

</div>