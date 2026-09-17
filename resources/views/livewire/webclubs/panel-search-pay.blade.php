@php
    $primary   = $school?->primary_color   ?: '#1e293b';
    $secondary = $school?->secondary_color ?: '#2563eb';
    $states    = config('constants.states_payment_orders');
    $isPaid    = $payment && (int) $payment->state === (int) $states['Pagado'];
    $isAwaiting = $payment && (int) $payment->state === (int) $states['Pendiente de validar'];
@endphp

<div
    class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 font-sans"
    x-data="{
        code: @entangle('code'),
        showEmailFallback: @entangle('showEmailFallback'),
        formatCode() { this.code = (this.code || '').toUpperCase().replace(/\s/g, ''); }
    }"
>
    <div class="max-w-3xl mx-auto">

        {{-- Cabecera --}}
        <div class="text-center mb-8">
            @if($school?->logo)
                <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->name }}"
                     class="mx-auto h-14 w-auto mb-4 object-contain">
            @endif
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">Portal de pagos</h1>
            <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto">
                Realiza el pago de tu cuota de forma rápida, segura y en pocos pasos.
            </p>
            <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-700">
                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 1a5 5 0 0 0-5 5v3H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 8V6a3 3 0 1 0-6 0v3h6Z" clip-rule="evenodd"/>
                </svg>
                Conexión cifrada · Pagos seguros
            </div>
        </div>

        {{-- Mensajes globales --}}
        @if($successMessage)
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.7-9.3a1 1 0 0 0-1.4-1.4L9 10.6 7.7 9.3a1 1 0 0 0-1.4 1.4l2 2a1 1 0 0 0 1.4 0l4-4Z" clip-rule="evenodd"/></svg>
                <div>{{ $successMessage }}</div>
            </div>
        @endif
        @if($infoMessage)
            <div class="mb-6 rounded-xl border border-sky-200 bg-sky-50 text-sky-800 px-4 py-3 text-sm flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-1 3a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1Z" clip-rule="evenodd"/></svg>
                <div>{{ $infoMessage }}</div>
            </div>
        @endif
        @if($errorMessage)
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-11a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V7Zm1 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" clip-rule="evenodd"/></svg>
                <div>{{ $errorMessage }}</div>
            </div>
        @endif

        {{-- ─────────────────────────────────────────────────────────────
             ESTADO 1: BÚSQUEDA (sin pago cargado y sin listado por email)
             ───────────────────────────────────────────────────────────── --}}
        @if(!$payment && (!$emailPayments || $emailPayments->isEmpty()))
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: {{ $secondary }}1a; color: {{ $secondary }};">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm0 4h12v6H4V8Z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Identifica tu carta de pago</h2>
                        <p class="text-sm text-slate-500">Introduce el código que aparece en tu carta.</p>
                    </div>
                </div>

                <form wire:submit="searchpay" class="space-y-4">
                    <div>
                        <label for="payment_code" class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">Código de referencia</label>
                        <input
                            type="text"
                            id="payment_code"
                            x-model="code"
                            @input="formatCode"
                            autocomplete="off"
                            placeholder="Ej. PAY-1234"
                            class="w-full px-5 py-4 text-lg font-bold tracking-widest text-center uppercase text-slate-900 bg-slate-50 border-2 rounded-xl outline-none transition
                                   @error('code') border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-500/20 @else border-slate-200 focus:bg-white focus:ring-4 @enderror"
                            style="--tw-ring-color: {{ $secondary }}33;"
                            onfocus="this.style.borderColor='{{ $secondary }}'"
                            onblur="this.style.borderColor=''"
                        >
                        @error('code')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-11a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V7Zm1 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled" wire:target="searchpay"
                        class="w-full py-4 rounded-xl text-white text-base font-semibold flex justify-center items-center gap-2 transition hover:opacity-90 disabled:opacity-70 disabled:cursor-not-allowed"
                        style="background-color: {{ $secondary }};"
                    >
                        <span wire:loading.remove wire:target="searchpay">Buscar recibo</span>
                        <span wire:loading wire:target="searchpay">Buscando…</span>
                        <svg wire:loading wire:target="searchpay" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                </form>

                {{-- Toggle búsqueda por email --}}
                <div x-show="!showEmailFallback" x-collapse>
                    <button
                        type="button"
                        @click="showEmailFallback = true"
                        class="mt-5 w-full text-sm text-slate-500 hover:text-slate-900 transition text-center py-2 underline underline-offset-2"
                    >
                        No tengo el código de mi carta de pago
                    </button>
                </div>

                <div
                    x-cloak
                    x-show="showEmailFallback"
                    x-transition
                    class="mt-6 pt-6 border-t border-dashed border-slate-200"
                >
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-slate-100 text-slate-700">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2.94 6.32A2 2 0 0 1 4.9 4h10.2a2 2 0 0 1 1.96 2.32L10 10.9 2.94 6.32Z"/><path d="M18 8.31v6.19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.31l7.4 4.8a1 1 0 0 0 1.2 0L18 8.31Z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Búsqueda por correo electrónico</h3>
                            <p class="text-xs text-slate-500">Te enviaremos las cartas de pago pendientes de la temporada activa.</p>
                        </div>
                    </div>

                    <form wire:submit="searchByEmail" class="space-y-3">
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="tu@email.com"
                            required
                            class="w-full px-4 py-3 text-base text-slate-900 bg-slate-50 border-2 rounded-xl outline-none transition
                                   @error('email') border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-500/20 @else border-slate-200 focus:bg-white focus:ring-4 @enderror"
                            style="--tw-ring-color: {{ $secondary }}33;"
                            onfocus="this.style.borderColor='{{ $secondary }}'"
                            onblur="this.style.borderColor=''"
                        >
                        @error('email')
                            <p class="text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-11a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V7Zm1 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror

                        <button
                            type="submit"
                            wire:loading.attr="disabled" wire:target="searchByEmail"
                            class="w-full py-3 rounded-xl border-2 text-base font-semibold flex justify-center items-center gap-2 transition hover:bg-slate-50 disabled:opacity-70"
                            style="border-color: {{ $primary }}; color: {{ $primary }};"
                        >
                            <span wire:loading.remove wire:target="searchByEmail">Buscar recibos por email</span>
                            <span wire:loading wire:target="searchByEmail">Comprobando…</span>
                            <svg wire:loading wire:target="searchByEmail" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        {{-- ─────────────────────────────────────────────────────────────
             ESTADO 2: LISTADO DE CARTAS POR EMAIL
             ───────────────────────────────────────────────────────────── --}}
        @elseif(!$payment && $emailPayments && $emailPayments->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Recibos pendientes</h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Hemos encontrado {{ $emailPayments->count() }} {{ $emailPayments->count() === 1 ? 'recibo' : 'recibos' }} pendientes para <span class="font-medium text-slate-800">{{ $email }}</span>.
                        </p>
                    </div>
                    <button wire:click="resetSearch" class="text-xs text-slate-500 hover:text-slate-900 shrink-0">← Nueva búsqueda</button>
                </div>

                <ul class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden mb-6">
                    @foreach($emailPayments as $p)
                        @php
                            $stateAwaiting = (int) $p->state === (int) $states['Pendiente de validar'];
                        @endphp
                        <li class="flex items-center justify-between gap-4 px-4 py-3 bg-white">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-slate-900 truncate">Cuota {{ $p->cuota }}</div>
                                <div class="text-xs text-slate-500 truncate">Código {{ $p->code }} · {{ $p->player?->name }} {{ $p->player?->surname }}</div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                @if($stateAwaiting)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 border border-amber-200 px-2.5 py-0.5 text-[11px] font-semibold text-amber-800">
                                        Pendiente de validar
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 border border-slate-200 px-2.5 py-0.5 text-[11px] font-semibold text-slate-700">
                                        Pendiente de pago
                                    </span>
                                @endif
                                <span class="text-base font-extrabold text-slate-900">{{ number_format((float) $p->amount, 2, ',', '.') }} €</span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if($emailSent)
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm mb-4 flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.7-9.3a1 1 0 0 0-1.4-1.4L9 10.6 7.7 9.3a1 1 0 0 0-1.4 1.4l2 2a1 1 0 0 0 1.4 0l4-4Z" clip-rule="evenodd"/></svg>
                        <div>
                            Hemos enviado {{ $lettersSent }} {{ $lettersSent === 1 ? 'carta de pago' : 'cartas de pago' }} a
                            <span class="font-semibold">{{ $email }}</span>. Revisa tu bandeja de entrada.
                        </div>
                    </div>
                @else
                    <button
                        wire:click="sendPaymentLetters"
                        wire:loading.attr="disabled" wire:target="sendPaymentLetters"
                        class="w-full py-4 rounded-xl text-white text-base font-semibold flex justify-center items-center gap-2 transition hover:opacity-90 disabled:opacity-70"
                        style="background-color: {{ $secondary }};"
                    >
                        <svg wire:loading.remove wire:target="sendPaymentLetters" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2.94 6.32A2 2 0 0 1 4.9 4h10.2a2 2 0 0 1 1.96 2.32L10 10.9 2.94 6.32Z"/><path d="M18 8.31v6.19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.31l7.4 4.8a1 1 0 0 0 1.2 0L18 8.31Z"/></svg>
                        <span wire:loading.remove wire:target="sendPaymentLetters">Enviar cartas de pago por email</span>
                        <span wire:loading wire:target="sendPaymentLetters">Enviando…</span>
                        <svg wire:loading wire:target="sendPaymentLetters" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                @endif
            </div>

        {{-- ─────────────────────────────────────────────────────────────
             ESTADO 3: RECIBO PAGADO
             ───────────────────────────────────────────────────────────── --}}
        @elseif($isPaid)
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.7-9.3a1 1 0 0 0-1.4-1.4L9 10.6 7.7 9.3a1 1 0 0 0-1.4 1.4l2 2a1 1 0 0 0 1.4 0l4-4Z" clip-rule="evenodd"/></svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Recibo pagado</h2>
                <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">Este recibo ya consta como abonado. Si necesitas justificante, contacta con el club.</p>
                <button wire:click="resetSearch" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border-2 border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                    ← Buscar otro recibo
                </button>
            </div>

        {{-- ─────────────────────────────────────────────────────────────
             ESTADO 4: RECIBO PENDIENTE DE VALIDAR (transferencia recibida)
             ───────────────────────────────────────────────────────────── --}}
        @elseif($isAwaiting)
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-8 text-center">
                <div class="mx-auto w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM11 6a1 1 0 1 0-2 0v4a1 1 0 0 0 .3.7l2.8 2.8a1 1 0 0 0 1.4-1.4L11 9.6V6Z" clip-rule="evenodd"/></svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Pago pendiente de validar</h2>
                <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                    Hemos recibido tu justificante de transferencia. En un plazo máximo de 7 días validaremos el pago y actualizaremos el estado del recibo.
                </p>
                <button wire:click="resetSearch" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border-2 border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 transition">
                    ← Buscar otro recibo
                </button>
            </div>

        {{-- ─────────────────────────────────────────────────────────────
             ESTADO 5: CHECKOUT (recibo pendiente)
             ───────────────────────────────────────────────────────────── --}}
        @else
            <div class="space-y-6">
                {{-- Resumen del recibo --}}
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-700 text-[11px] font-semibold px-3 py-1 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            Recibo pendiente
                        </div>
                        <button wire:click="resetSearch" class="text-xs text-slate-500 hover:text-slate-900">← Volver</button>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-6 items-center">
                        <div>
                            <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Concepto</div>
                            <div class="text-lg font-bold text-slate-900 mt-1">Cuota {{ $payment->cuota }}</div>
                            <div class="text-sm text-slate-500 mt-1">
                                {{ $payment->player?->name }} {{ $payment->player?->surname }}
                            </div>
                            <div class="text-xs text-slate-400 mt-2">Referencia: <span class="font-semibold text-slate-600">{{ $payment->code }}</span></div>
                        </div>
                        <div class="sm:text-right">
                            <div class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total a pagar</div>
                            <div class="text-4xl sm:text-5xl font-black tracking-tight mt-1" style="color: {{ $secondary }};">
                                {{ number_format((float) $payment->amount, 2, ',', '.') }} €
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Opciones de pago --}}
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Elige cómo quieres pagar</h3>

                    <div class="grid gap-4 md:grid-cols-2">
                        {{-- Opción 1: Tarjeta --}}
                        @if($school?->payments_enabled)
                            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 flex flex-col">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background-color: {{ $secondary }}1a; color: {{ $secondary }};">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 0 0-2 2v1h16V6a2 2 0 0 0-2-2H4Zm14 5H2v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9ZM4 13a1 1 0 0 1 1-1h2a1 1 0 1 1 0 2H5a1 1 0 0 1-1-1Z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">Tarjeta bancaria</div>
                                        <div class="text-xs text-slate-500">Pago inmediato y seguro</div>
                                    </div>
                                </div>

                                <p class="text-sm text-slate-500 mb-5 flex-1">
                                    Serás redirigido a la pasarela {{ ucfirst($school->payment_gateway) }} para completar el pago. El recibo se validará automáticamente al confirmar.
                                </p>

                                <button
                                    wire:click="payWithCard"
                                    wire:loading.attr="disabled" wire:target="payWithCard"
                                    class="w-full py-3 rounded-xl text-white font-semibold flex justify-center items-center gap-2 transition hover:opacity-90 disabled:opacity-70"
                                    style="background-color: {{ $secondary }};"
                                >
                                    <span wire:loading.remove wire:target="payWithCard">Pagar {{ number_format((float) $payment->amount, 2, ',', '.') }} €</span>
                                    <span wire:loading wire:target="payWithCard">Redirigiendo…</span>
                                    <svg wire:loading wire:target="payWithCard" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </button>

                                <div class="mt-3 flex items-center justify-center gap-2 text-[11px] text-slate-400 font-medium">
                                    <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a5 5 0 0 0-5 5v3H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 8V6a3 3 0 1 0-6 0v3h6Z" clip-rule="evenodd"/></svg>
                                    Pago cifrado extremo a extremo
                                </div>
                            </div>
                        @endif

                        {{-- Opción 2: Transferencia --}}
                        @if($school?->bank_account_enabled)
                            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 flex flex-col">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center bg-slate-100 text-slate-700">
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2 1 6v2h18V6l-9-4Zm-7 8v6H1v2h18v-2h-2v-6h-2v6h-2v-6h-2v6H9v-6H7v6H5v-6H3Z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">Transferencia bancaria</div>
                                        <div class="text-xs text-slate-500">Validación manual en 7 días</div>
                                    </div>
                                </div>

                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-600 space-y-1 mb-4">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="uppercase text-[10px] tracking-wider font-semibold text-slate-500">IBAN</span>
                                        <span class="font-mono font-semibold text-slate-800 truncate">{{ wordwrap($school->bank_account ?? '', 4, ' ', true) }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="uppercase text-[10px] tracking-wider font-semibold text-slate-500">Concepto</span>
                                        <span class="font-semibold text-slate-800 truncate">{{ $payment->code }}</span>
                                    </div>
                                </div>

                                <form wire:submit="submitTransfer" class="flex-1 flex flex-col">
                                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">
                                        Justificante del pago
                                    </label>
                                    <label
                                        for="receipt_file"
                                        class="cursor-pointer border-2 border-dashed border-slate-200 rounded-xl px-4 py-4 text-center hover:border-slate-300 transition block"
                                    >
                                        <input type="file" id="receipt_file" wire:model="receipt_file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                        <div wire:loading.remove wire:target="receipt_file">
                                            @if($receipt_file)
                                                <div class="text-sm font-semibold text-slate-800 truncate">{{ $receipt_file->getClientOriginalName() }}</div>
                                                <div class="text-xs text-slate-500 mt-1">Toca para cambiar el archivo</div>
                                            @else
                                                <div class="text-sm font-semibold text-slate-700">Sube tu justificante</div>
                                                <div class="text-xs text-slate-500 mt-1">PDF, JPG o PNG · máx. 5 MB</div>
                                            @endif
                                        </div>
                                        <div wire:loading wire:target="receipt_file" class="text-sm text-slate-600">Subiendo archivo…</div>
                                    </label>
                                    @error('receipt_file')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <button
                                        type="submit"
                                        wire:loading.attr="disabled" wire:target="submitTransfer,receipt_file"
                                        class="mt-4 w-full py-3 rounded-xl font-semibold flex justify-center items-center gap-2 transition disabled:opacity-70"
                                        style="background-color: {{ $primary }}; color: #fff;"
                                    >
                                        <span wire:loading.remove wire:target="submitTransfer">Enviar justificante</span>
                                        <span wire:loading wire:target="submitTransfer">Enviando…</span>
                                        <svg wire:loading wire:target="submitTransfer" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    @if(!$school?->payments_enabled && !$school?->bank_account_enabled)
                        <div class="mt-4 bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center text-sm text-slate-500">
                            No hay métodos de pago habilitados. Contacta con tu club.
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Footer confianza --}}
        <div class="mt-8 text-center text-xs text-slate-400 flex items-center justify-center gap-4 flex-wrap">
            <span class="inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1a5 5 0 0 0-5 5v3H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 8V6a3 3 0 1 0-6 0v3h6Z" clip-rule="evenodd"/></svg>
                Pagos seguros con cifrado SSL
            </span>
            <span class="hidden sm:inline">·</span>
            <span>© {{ date('Y') }} {{ $school?->name }}</span>
        </div>
    </div>

    {{-- Formulario auto-enviado a Redsys --}}
    @if($redsysForm)
        <form
            id="redsys-auto-form"
            method="POST"
            action="{{ $redsysForm['endpoint'] }}"
            x-data
            x-init="$nextTick(() => $el.submit())"
            class="hidden"
        >
            <input type="hidden" name="Ds_SignatureVersion"   value="{{ $redsysForm['Ds_SignatureVersion'] }}">
            <input type="hidden" name="Ds_MerchantParameters" value="{{ $redsysForm['Ds_MerchantParameters'] }}">
            <input type="hidden" name="Ds_Signature"          value="{{ $redsysForm['Ds_Signature'] }}">
            <noscript>
                <div class="max-w-md mx-auto px-6 py-8 text-center">
                    <p class="mb-4 text-slate-700">Pulsa el botón para continuar al pago:</p>
                    <button type="submit" class="px-6 py-3 rounded-xl text-white font-bold" style="background-color: {{ $secondary }};">
                        Continuar al pago
                    </button>
                </div>
            </noscript>
        </form>
    @endif
</div>
