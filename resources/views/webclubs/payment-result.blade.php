@extends('livewire.webclubs.layouts.app', ['title' => ($title ?? 'Resultado del pago')])

@section('content')
<main class="min-h-screen bg-white">

    <section class="pt-8 pb-8 md:pt-16 md:pb-14">
        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <a href="{{ route('webclubs.home') }}"
               class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-6 md:mb-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Inicio
            </a>
            <h2 class="text-xs sm:text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/40 font-semibold mb-3 md:mb-5">Resultado</h2>
            <h1 class="section-title text-4xl sm:text-5xl md:text-7xl font-bold text-black leading-none">
                {{ $title }}
            </h1>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-6 lg:px-12"><div class="h-px bg-gray-100"></div></div>

    <section class="py-10 md:py-20">
        <div class="max-w-3xl mx-auto px-6 lg:px-12">

            @if($status === 'success')
                <div class="rounded-2xl border border-green-200 bg-green-50 p-8 md:p-10 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-green-500 text-white flex items-center justify-center mb-4">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-green-800 mb-2">¡Pago confirmado!</h3>
                    <p class="text-green-900/80">{{ $message }}</p>
                </div>
            @else
                <div class="rounded-2xl border border-red-200 bg-red-50 p-8 md:p-10 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-red-500 text-white flex items-center justify-center mb-4">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-red-800 mb-2">El pago no se ha completado</h3>
                    <p class="text-red-900/80">{{ $message }}</p>
                </div>
            @endif

            {{-- Contexto técnico (útil para verificar la prueba) --}}
            @if(!empty($context))
                <details class="mt-6 rounded-xl border border-gray-200 bg-white p-4">
                    <summary class="cursor-pointer text-xs font-bold uppercase tracking-widest text-black/50">
                        Detalles técnicos
                    </summary>
                    <pre class="mt-3 text-[11px] text-black/70 overflow-auto whitespace-pre-wrap break-all">{{ json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                </details>
            @endif

            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('webclubs.express-pay') }}"
                   class="px-6 py-3 rounded-xl bg-black text-white font-bold text-sm text-center hover:bg-neutral-800 transition-colors">
                    Volver a probar
                </a>
                <a href="{{ route('webclubs.home') }}"
                   class="px-6 py-3 rounded-xl border-2 border-black text-black font-bold text-sm text-center hover:bg-black hover:text-white transition-colors">
                    Ir al inicio
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
