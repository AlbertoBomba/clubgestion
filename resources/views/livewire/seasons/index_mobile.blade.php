<div x-data="{ showSearch: false }" class="min-h-screen bg-gray-50 pb-24 relative">
    {{-- Alertas y Mensajes Flash --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-xl shadow-sm">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    @php
        $now = now();
        $hasActiveSeason = $seasons->contains(function($season) use ($now) {
            return $season->start_date && $season->end_date && $season->start_date <= $now && $season->end_date >= $now;
        });
        $openInscriptionSeasons = $seasons->filter(function($season) use ($now) {
            return $season->inscription_start_at && $season->inscription_end_at &&
                   $season->inscription_start_at <= $now && $season->inscription_end_at >= $now;
        });
    @endphp

    @if($openInscriptionSeasons->count() >= 2)
        <div class="m-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-start gap-3 shadow-sm">
            <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-red-800">¡Atención! {{ $openInscriptionSeasons->count() }} temporadas con inscripciones abiertas.</p>
                <p class="text-xs text-red-700 mt-1">Revisa las fechas de: <span class="font-semibold">{{ $openInscriptionSeasons->pluck('season')->join(', ') }}</span>.</p>
            </div>
        </div>
    @endif

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-5 py-4 flex items-center justify-between">
        <h2 class="font-extrabold text-xl text-titanium tracking-tight">
            {{ __('Temporadas') }}
        </h2>
        
        {{-- Botón para mostrar/ocultar buscador --}}
        <button @click="showSearch = !showSearch" 
                class="p-2 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </header>

    {{-- BUSCADOR (Desplegable) --}}
    <div x-show="showSearch" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="px-4 py-3 bg-white-pure border-b border-gray-100 shadow-inner z-30 relative" style="display: none;">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="search" placeholder="Buscar temporada..." 
                class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep focus:ring-2 focus:ring-primary focus:bg-white transition-all">
        </div>
    </div>

    {{-- LISTA DE TARJETAS (Cards) --}}
    <main class="p-4 space-y-4">
        @forelse($seasons as $season)
            @php
                $isActive = $season->start_date && $season->end_date && $season->start_date <= now() && $season->end_date >= now();
                $hasOpenInscriptions = $season->inscription_start_at && $season->inscription_end_at && $season->inscription_start_at <= now() && $season->inscription_end_at >= now();
            @endphp
            
            <article class="bg-white-pure rounded-3xl p-5 shadow-sm border {{ $isActive ? 'border-green-500 ring-1 ring-green-500' : 'border-gray-100' }} relative overflow-hidden">
                
                {{-- Cabecera de la tarjeta --}}
                <div class="flex justify-between items-start mb-5 border-b border-gray-50 pb-4">
                    <div>
                        <h3 class="font-bold text-lg text-titanium">{{ $season->season }}</h3>
                        @if($isActive)
                            <span class="inline-flex items-center mt-1 text-xs font-bold text-green-600">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5 animate-pulse"></span>
                                Temporada en curso
                            </span>
                        @endif
                    </div>
                    
                    {{-- Badge Inscripción --}}
                    @if($hasOpenInscriptions)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-emerald-100 text-emerald-700">
                            Insc. Abierta
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-gray-100 text-gray-500">
                            Cerrada
                        </span>
                    @endif
                </div>

                {{-- Grid de Estadísticas --}}
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div class="bg-primary/5 rounded-2xl p-3 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Players</span>
                        <span class="text-lg font-black text-primary">{{ $season->players_count }}</span>
                    </div>
                    
                    <div class="bg-blue-50 rounded-2xl p-3 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Equipos</span>
                        <span class="text-lg font-black text-blue-700">{{ $season->teams_count }}</span>
                    </div>
                    
                    <div class="bg-neon-green/10 rounded-2xl p-3 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Secciones</span>
                        <span class="text-lg font-black text-neon-green">{{ $season->sections_count }}</span>
                    </div>
                </div>

                {{-- Botones de Acción (Estilo App) --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('seasons.edit', $season->id) }}" 
                       class="flex-1 flex justify-center items-center gap-2 py-3 bg-gray-50 text-primary font-bold text-sm rounded-xl active:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Editar
                    </a>

                    @if($season->players_count == 0 && $season->teams_count == 0 && $season->sections_count == 0)
                        <button wire:click="confirmDelete({{ $season->id }})" 
                                class="flex-1 flex justify-center items-center gap-2 py-3 bg-red-50 text-red-600 font-bold text-sm rounded-xl active:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Borrar
                        </button>
                    @else
                        <div class="flex-1 flex justify-center items-center gap-2 py-3 bg-gray-50/50 text-gray-400 font-bold text-sm rounded-xl cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Bloqueado
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Sin temporadas</h3>
                <p class="text-sm text-gray-500">No hay temporadas registradas o que coincidan con la búsqueda.</p>
            </div>
        @endforelse

        {{-- Paginación Móvil --}}
        @if($seasons->hasPages())
            <div class="pt-4 pb-8">
                {{ $seasons->links() }}
            </div>
        @endif
    </main>

    {{-- BOTTOM APP BAR (Fija abajo para acciones principales) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50">
        <a href="{{ route('seasons.create') }}" 
           class="w-full flex justify-center items-center gap-2 py-4 bg-blue-600 text-white rounded-2xl font-black text-lg active:scale-95 transition-transform shadow-lg shadow-blue-600/30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Crear Temporada
        </a>
    </div>

    {{-- Modal Confirmación (Sin cambios funcionales, adaptado a Tailwind estándar) --}}
    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title"><span class="font-bold">Eliminar Temporada</span></x-slot>
        <x-slot name="content">
            <p class="text-gray-600">¿Estás seguro de que deseas eliminar esta temporada de forma permanente?</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl active:bg-gray-200">
                    Cancelar
                </button>
                <button wire:click="deleteSeason" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl active:bg-red-700 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="deleteSeason">Eliminar</span>
                    <svg wire:loading wire:target="deleteSeason" class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- JS Modal CleanUp --}}
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
                }, 150);
            });
        });
    </script>
</div>