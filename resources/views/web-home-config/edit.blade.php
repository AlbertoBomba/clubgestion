<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            {{ __('Gestión de la Portada Web') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- ── SECCIÓN: HERO / CARRUSEL ─────────────────────── --}}
            <div>
                <div class="mb-4 flex items-center gap-3">
                    <span class="text-2xl">🖼️</span>
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">Hero — Carrusel de Portada</h3>
                        <p class="text-xs text-gray-500">Slides de imagen o vídeo que aparecen en la cabecera de la portada pública</p>
                    </div>
                </div>
                @livewire('web-home-slides.index')
            </div>

            {{-- ── SECCIÓN: RESTO DE CONTENIDO ─────────────────── --}}
            <div>
                <div class="mb-4 flex items-center gap-3">
                    <span class="text-2xl">⚙️</span>
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">Contenido Estático</h3>
                        <p class="text-xs text-gray-500">Estadísticas, sección de socios y datos de contacto</p>
                    </div>
                </div>
                @livewire('web-home-config.edit')
            </div>

        </div>
    </div>
</x-app-layout>
