<div>
    <main class="min-h-screen bg-white">

        {{-- Hero header --}}
        <section class="pt-8 pb-8 md:pt-16 md:pb-14 relative overflow-hidden">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12 relative z-10">
                <a href="{{ route('webclubs.home') }}"
                   class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-6 md:mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Inicio
                </a>
                <h2 class="text-xs sm:text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/40 font-semibold mb-3 md:mb-5">pago exprés</h2>
                <h1 class="section-title text-5xl sm:text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">Prueba de pago</h1>
                <p class="mt-4 md:mt-6 text-black/50 max-w-2xl text-base md:text-lg">
                    Página pública para verificar que la pasarela de pago del club funciona correctamente.
                    Se generará un cargo simbólico de <strong>0,20€</strong>.
                </p>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        <section class="py-10 md:py-20">
            <div class="max-w-3xl mx-auto px-6 lg:px-12">

                {{-- Estado de configuración del club --}}
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl md:text-2xl font-bold text-black">{{ $school?->name }}</h3>
                            <p class="text-sm text-black/50">Comercio</p>
                        </div>
                        @php
                            $gw = $school?->payment_gateway ?: 'none';
                            $active = $school?->hasActivePayment() ?? false;
                        @endphp
                        <span class="text-[11px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full
                            {{ $active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $active ? ($gw . ' activa') : 'Sin pasarela' }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mb-6 pb-6 border-b border-gray-100">
                        <span class="text-sm text-black/50">Importe de prueba</span>
                        <span class="text-4xl md:text-5xl font-black tracking-tight text-black">0,20€</span>
                    </div>

                    @if($error)
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 text-red-800 text-sm px-4 py-3">
                            {{ $error }}
                        </div>
                    @endif

                    @if(! $active)
                        <div class="rounded-xl border border-amber-200 bg-amber-50 text-amber-900 text-sm px-4 py-3">
                            El administrador del club aún no ha configurado la pasarela de pago o está deshabilitada.
                            Ve a <em>Editar Escuela → Configuración de pasarelas de pago</em>.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button type="button" wire:click="pay('card')"
                                    wire:loading.attr="disabled" wire:target="pay"
                                    class="group relative w-full px-6 py-4 rounded-xl bg-black text-white font-bold text-base
                                           hover:bg-neutral-800 transition-colors disabled:opacity-60 disabled:cursor-not-allowed
                                           flex items-center justify-center gap-2">
                                <svg wire:loading wire:target="pay" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <svg wire:loading.remove wire:target="pay" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Pagar 0,20€ con tarjeta
                            </button>

                            <button type="button" wire:click="pay('bizum')"
                                    wire:loading.attr="disabled" wire:target="pay"
                                    class="group relative w-full px-6 py-4 rounded-xl border-2 border-black text-black font-bold text-base
                                           hover:bg-black hover:text-white transition-colors disabled:opacity-60 disabled:cursor-not-allowed
                                           flex items-center justify-center gap-2">
                                <svg wire:loading wire:target="pay" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="pay">Pagar 1&nbsp;€ con Bizum</span>
                                <span wire:loading wire:target="pay">Procesando...</span>
                            </button>
                        </div>

                        <p class="mt-4 text-xs text-black/40">
                            Serás redirigido a la pasarela {{ ucfirst($gw) }} para completar el pago.
                            Al finalizar volverás automáticamente a esta web.
                        </p>
                    @endif
                </div>

                {{-- Info técnica útil para depurar --}}
                <div class="mt-6 text-xs text-black/30 text-center space-y-1">
                    <p>URL retorno OK: <code class="text-black/50">{{ route('webclubs.express-pay.ok') }}</code></p>
                    <p>URL retorno KO: <code class="text-black/50">{{ route('webclubs.express-pay.ko') }}</code></p>
                    @if($gw === 'redsys')
                        <p>Notificación Redsys: <code class="text-black/50">{{ route('webclubs.express-pay.redsys-notify') }}</code></p>
                    @endif
                </div>
            </div>
        </section>

        {{-- Redsys: formulario auto-enviado --}}
        @if($redsysForm)
            <form id="redsys-auto-form"
                  method="POST"
                  action="{{ $redsysForm['endpoint'] }}"
                  x-data
                  x-init="$nextTick(() => $el.submit())"
                  class="hidden">
                <input type="hidden" name="Ds_SignatureVersion"   value="{{ $redsysForm['Ds_SignatureVersion'] }}">
                <input type="hidden" name="Ds_MerchantParameters" value="{{ $redsysForm['Ds_MerchantParameters'] }}">
                <input type="hidden" name="Ds_Signature"          value="{{ $redsysForm['Ds_Signature'] }}">
                <noscript>
                    <div class="max-w-3xl mx-auto px-6 py-8 text-center">
                        <p class="mb-4">Pulsa el botón para continuar al pago:</p>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-black text-white font-bold">Continuar al pago</button>
                    </div>
                </noscript>
            </form>
        @endif
    </main>
</div>
