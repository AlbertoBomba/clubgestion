<div class="min-h-screen bg-gray-50 pb-28 relative" 
     x-data="{ 
        showFilters: false,
        showToast: false, 
        toastMessage: '', 
        toastType: 'success',
        showToastNotification(message, type = 'success') {
            this.toastMessage = message;
            this.toastType = type;
            this.showToast = true;
            setTimeout(() => { this.showToast = false; }, 5000);
        }
    }" 
    @toast-notification.window="showToastNotification($event.detail.message, $event.detail.type)">

    {{-- ALERTAS FLASH DE SESIÓN --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-2xl shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-neon-green flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <p class="text-sm text-neon-green font-bold">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="m-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <p class="text-sm text-red-700 font-bold">{{ session('error') }}</p>
        </div>
    @endif

    @if (session()->has('warning'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" 
             class="m-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-2xl shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-yellow-700 font-bold">{{ session('warning') }}</p>
        </div>
    @endif

    <!-- TOAST NOTIFICATION (ALPINE) -->
    <div x-show="showToast" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-20 right-4 left-4 z-50 shadow-lg rounded-2xl pointer-events-auto"
         :class="toastType === 'success' ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500'">
        <div class="p-4 flex items-start gap-3">
            <svg x-show="toastType === 'success'" class="h-6 w-6 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <svg x-show="toastType === 'error'" class="h-6 w-6 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-bold" :class="toastType === 'success' ? 'text-green-800' : 'text-red-800'" x-text="toastMessage"></p>
            </div>
            <button @click="showToast = false" class="text-gray-400 active:scale-95">✕</button>
        </div>
    </div>

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div>
            {{-- <h2 class="font-black text-xl text-titanium leading-tight">
                Torneos
            </h2> --}}
            <p class="text-xs font-bold text-gray-500 mt-0.5">
                {{ $tournaments->total() }} {{ $tournaments->total() === 1 ? 'Torneo' : 'Torneos' }}
            </p>
        </div>

        {{-- Botón Toggle Filtros --}}
        <button @click="showFilters = !showFilters" 
                class="p-2.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 active:scale-95 transition-all relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            @if($search || $statusFilter)
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-primary rounded-full border-2 border-white"></span>
            @endif
        </button>
    </header>

    {{-- PANEL DE FILTROS DESPLEGABLE --}}
    <div x-show="showFilters" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="px-4 py-5 bg-white-pure border-b border-gray-100 shadow-inner z-30 relative space-y-3" style="display: none;">
        
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar torneo o ubicación..." 
                   class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep focus:ring-2 focus:ring-primary focus:bg-white transition-all text-sm font-semibold">
        </div>

        <select wire:model.live="statusFilter" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
            <option value="">Todos los estados</option>
            <option value="draft">Borrador</option>
            <option value="registration_open">Inscripción abierta</option>
            <option value="in_progress">En curso</option>
            <option value="completed">Completado</option>
            <option value="cancelled">Cancelado</option>
        </select>
    </div>

    <main class="p-4 space-y-4">

        {{-- EMPTY STATE --}}
        @if ($tournaments->isEmpty())
            <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100 mt-4">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-titanium mb-2">No hay torneos todavía</h3>
                <p class="text-xs text-gray-500 font-medium mb-6">Crea tu primer torneo con nombre, formato y genera los partidos automáticamente.</p>
                <a href="{{ route('tournaments.create') }}" wire:navigate
                   class="inline-flex items-center justify-center gap-2 w-full bg-primary text-white font-black text-sm px-5 py-4 rounded-2xl active:scale-95 transition-all shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Crear mi primer torneo
                </a>
            </div>
        @else
            {{-- LISTADO DE TARJETAS (CARDS) --}}
            <div class="space-y-4">
                @foreach ($tournaments as $tournament)
                    <article class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden transition-all duration-300">
                        
                        {{-- Badge Estado Flotante --}}
                        <div class="absolute top-4 right-4">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm {{ $tournament->statusColor() }}">
                                {{ $tournament->statusLabel() }}
                            </span>
                        </div>

                        {{-- Fila Principal: Logo y Título --}}
                        <div class="flex items-start gap-4 mb-4 pr-24">
                            <div class="flex-shrink-0">
                                @if ($tournament->logo)
                                    <img src="{{ Storage::url($tournament->logo) }}" alt="{{ $tournament->name }}"
                                         class="w-14 h-14 rounded-2xl object-cover border border-gray-100 shadow-sm"/>
                                @else
                                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center border border-primary/20 shadow-sm">
                                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 pt-1">
                                <h3 class="font-black text-base text-titanium leading-tight line-clamp-2">{{ $tournament->name }}</h3>
                                @if ($tournament->location)
                                    <p class="text-[11px] font-bold text-gray-400 mt-1 flex items-center gap-1 truncate">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        {{ $tournament->location }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Descripción (Si existe) --}}
                        @if ($tournament->description)
                            <div class="mb-3 bg-gray-50 rounded-xl p-3 border border-gray-100">
                                <p class="text-[11px] font-medium text-gray-500 line-clamp-2 italic">"{{ $tournament->description }}"</p>
                            </div>
                        @endif

                        {{-- Métricas Grid --}}
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div class="bg-blue-50/50 rounded-xl p-2.5 border border-blue-100 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="block text-[9px] font-bold text-blue-700 uppercase tracking-wider">Equipos</span>
                                    <span class="block text-xs font-black text-blue-900">{{ $tournament->tournament_teams_count }}</span>
                                </div>
                            </div>
                            
                            <div class="bg-purple-50/50 rounded-xl p-2.5 border border-purple-100 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="block text-[9px] font-bold text-purple-700 uppercase tracking-wider">Fases</span>
                                    <span class="block text-xs font-black text-purple-900">{{ $tournament->phases_count }}</span>
                                </div>
                            </div>

                            @if ($tournament->start_date)
                                <div class="col-span-2 bg-gray-50 rounded-xl p-2.5 border border-gray-100 flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="min-w-0 flex-1 flex justify-between items-center">
                                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Inicio Competición</span>
                                        <span class="text-xs font-black text-titanium">{{ $tournament->start_date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Barra de Progreso (Solo en curso) --}}
                        @if ($tournament->status === 'in_progress' && $tournament->matches_count > 0)
                            @php $pct = round(($tournament->completed_matches_count / $tournament->matches_count) * 100); @endphp
                            <div class="mb-4">
                                <div class="flex items-center justify-between text-[10px] font-black mb-1.5">
                                    <span class="text-gray-500 uppercase tracking-wider">Progreso</span>
                                    <span class="text-primary">{{ $pct }}%</span>
                                </div>
                                <div class="h-2 bg-primary/10 rounded-full overflow-hidden shadow-inner">
                                    <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endif

                        {{-- Botones de Acción --}}
                        <div class="flex items-center gap-2 mt-auto pt-3 border-t border-gray-50">
                            <a href="{{ route('tournaments.show', $tournament) }}" wire:navigate
                               class="flex-[3] py-3.5 bg-primary text-white text-xs font-black rounded-xl active:scale-95 transition-all text-center flex items-center justify-center gap-2 shadow-md shadow-primary/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Configurar
                            </a>
                            <button wire:click="confirmDelete({{ $tournament->id }})"
                                    class="flex-1 py-3.5 bg-red-50 text-red-600 rounded-xl active:scale-95 transition-all flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Paginación --}}
            @if($tournaments->hasPages())
                <div class="pt-4 pb-8">
                    {{ $tournaments->links() }}
                </div>
            @endif
        @endif
    </main>

    {{-- BOTTOM APP BAR (Fijo Abajo) --}}
    <div class="fixed flex flex-col gap-2 bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50">
        <a href="{{ route('tournaments.create') }}" wire:navigate
           class="w-full flex items-center justify-center gap-2 py-4 bg-gray-900 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg shadow-gray-900/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Torneo
        </a>

        <h2 class="flex font-black text-xl text-titanium leading-tight mx-auto">
            Torneos
        </h2>
    </div>

    {{-- MODAL DE ELIMINACIÓN CON X-DIALOG-MODAL --}}
    <x-dialog-modal wire:model="confirmingDeletion" maxWidth="sm">
        <x-slot name="title"><span class="font-black text-lg text-red-600">Eliminar Torneo</span></x-slot>
        <x-slot name="content">
            <div class="text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 flex items-center justify-center mx-auto mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <p class="text-sm font-bold text-gray-900">¿Estás completamente seguro?</p>
                <p class="text-xs font-semibold text-gray-500">Esta acción no se puede deshacer. Se eliminarán permanentemente todas las categorías, fases, equipos, partidos y clasificaciones vinculadas a este torneo.</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-sm rounded-xl active:bg-gray-200 transition-colors">Cancelar</button>
                <button wire:click="deleteTournament" wire:loading.attr="disabled" class="flex-1 py-3.5 bg-red-600 text-white font-black text-sm rounded-xl active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="deleteTournament">Eliminar</span>
                    <span wire:loading wire:target="deleteTournament">Borrando...</span>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

</div>