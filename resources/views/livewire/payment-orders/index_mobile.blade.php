@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar { z-index: 10000 !important; }
    .flatpickr-calendar.open { z-index: 10000 !important; }
</style>
@endpush

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
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-2xl shadow-sm">
            <p class="text-sm text-neon-green font-bold">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="m-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
            <p class="text-sm text-red-700 font-bold">{{ session('error') }}</p>
        </div>
    @endif

    @if (session()->has('warning'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" 
             class="m-4 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-2xl shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-amber-800 font-bold">{{ session('warning') }}</p>
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
            <svg x-show="toastType === 'success'" class="h-6 w-6 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg x-show="toastType === 'error'" class="h-6 w-6 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-bold" :class="toastType === 'success' ? 'text-green-800' : 'text-red-800'" x-text="toastMessage"></p>
            </div>
            <button @click="showToast = false" class="text-gray-400 active:scale-95">✕</button>
        </div>
    </div>

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div>
            <h2 class="font-black text-xl text-titanium leading-tight">
                Cartas de Pago
            </h2>
            @if($activeSeason)
                <p class="text-xs font-bold text-gray-500">
                    <span class="text-primary">{{ $players->total() }}</span> {{ $players->total() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}
                </p>
            @endif
        </div>

        {{-- Botón Toggle Filtros --}}
        <button @click="showFilters = !showFilters" 
                class="p-2.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 active:scale-95 transition-all relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            @if($search || $seasonFilter || $teamFilter || $cuotaFilter || $pendingPaymentsOnly || $pendingTransferValidationOnly)
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
        
        {{-- Campo de Búsqueda --}}
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="search" placeholder="Jugador, tutor, DNI o código de pago..." 
                   class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep focus:ring-2 focus:ring-primary focus:bg-white transition-all text-sm font-semibold">
        </div>

        {{-- Selects de Filtro --}}
        <div class="grid grid-cols-2 gap-2">
            <select wire:model.live="seasonFilter" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                <option value="">Todas las temporadas</option>
                @foreach($seasons as $season)
                    <option value="{{ $season->id }}">
                        {{ $season->season }} @if($activeSeason && $season->id === $activeSeason->id) (En curso) @endif
                    </option>
                @endforeach
            </select>

            <select wire:model.live="teamFilter" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                <option value="">Todos los equipos</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->team }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select wire:model.live="cuotaFilter" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                <option value="">Todas las cuotas</option>
                @for($i = 1; $i <= $maxCuotas; $i++)
                    <option value="{{ $i }}">Cuota {{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Switches / Checkboxes de Filtro --}}
        <div class="space-y-2 pt-1">
            <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-gray-100 bg-gray-50/50 cursor-pointer select-none">
                <input type="checkbox" wire:model.live="pendingPaymentsOnly" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="text-xs font-bold text-titanium">Todos los pagos pendientes</span>
            </label>

            <label class="flex items-center gap-3 p-3 rounded-2xl border-2 border-gray-100 bg-gray-50/50 cursor-pointer select-none">
                <input type="checkbox" wire:model.live="pendingTransferValidationOnly" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="text-xs font-bold text-titanium">Solo pendientes validar transferencia</span>
            </label>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="p-4 space-y-4">
        
        {{-- Selección masiva --}}
        @if($players->count() > 0)
            <div class="flex items-center justify-between px-2">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" wire:model.live="selectAll" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Seleccionar todos</span>
                </label>
            </div>
        @endif

        {{-- LISTADO DE TARJETAS (CARDS DE JUGADOR) --}}
        <div class="space-y-4">
            @forelse($players as $player)
                <article class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4 relative overflow-hidden transition-all duration-300">
                    
                    {{-- Fila Superior: Checkbox, Foto, Nombre, Apellidos, Edad --}}
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-3">
                        <div class="pt-1 flex-shrink-0">
                            <input type="checkbox" wire:model.live="selectedPlayers" value="{{ $player->id }}" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                        </div>

                        {{-- 1. Jugador (Foto) --}}
                        <div class="flex-shrink-0">
                            @if($player->profile_photo_path)
                                <img src="{{ asset('storage/' . $player->profile_photo_path) }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ substr($player->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        {{-- 1. Jugador (Nombre, Apellidos, Edad) --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-black text-base text-titanium truncate leading-tight">
                                {!! $this->highlightText(trim(($player->name ?? '') . ' ' . ($player->surname ?? ''))) !!}
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                @if($player->dbirth)
                                    <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-extrabold text-[10px] uppercase">{{ $player->dbirth->age }} años</span>
                                @endif
                                @php $tutorName = trim(($player->nametutor ?? '') . ' ' . ($player->surnametutor ?? '')); @endphp
                                @if(!empty($tutorName))
                                    <span class="text-[11px] font-bold text-gray-400 truncate">Tutor: {!! $this->highlightText($tutorName) !!}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- 2. Equipo --}}
                    <div class="bg-blue-50/70 rounded-2xl p-3 border border-blue-100 flex items-center justify-between">
                        <span class="text-[10px] font-extrabold text-blue-700 uppercase tracking-wider">Equipo Asignado</span>
                        <span class="font-black text-xs text-blue-900 truncate">{{ $player->teams->first()->team ?? 'Sin equipo' }}</span>
                    </div>

                    {{-- 3. Códigos de Pago --}}
                    @if($player->paymentPlayers->count() > 0)
                        <div class="space-y-1.5 pt-1">
                            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Códigos de Pago</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($player->paymentPlayers->sortBy('cuota') as $payment)
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 border border-gray-200 rounded-xl text-xs font-mono font-bold text-gray-700">
                                        @if($payment->notification > 0)
                                            <span class="inline-flex items-center gap-0.5 px-1.5 py-0.2 rounded-full text-[9px] bg-emerald-100 text-emerald-700 font-extrabold" 
                                                  title="Notificado {{ $payment->notification }} veces. Última: {{ $payment->dtnotification?->format('d/m/Y H:i') }}">
                                                📩 {{ $payment->notification }}
                                            </span>
                                        @endif
                                        <span class="text-gray-400 text-[10px]">#{{ $payment->id }}</span>
                                        <span>C{{ $payment->cuota }}: {!! $this->highlightText($payment->code) !!}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- 4. Cuotas de Pago (Badges de Estado) --}}
                    <div class="space-y-2 pt-1">
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Cuotas de Pago</span>
                        @if($player->paymentPlayers->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($player->paymentPlayers->sortBy('cuota') as $payment)
                                    @php
                                        $now = now();
                                        $dateStart = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_start) : null;
                                        $dateEnd = $payment->paymentTeam ? \Carbon\Carbon::parse($payment->paymentTeam->date_end) : null;

                                        if ($payment->state == 1) {
                                            $statusText = 'Pagada'; $bgColor = 'bg-green-100/80 border-green-300 text-green-900';
                                        } elseif ($payment->state == 6) {
                                            $statusText = 'Pendiente de validar'; $bgColor = 'bg-amber-100/90 border-amber-400 text-amber-900 animate-pulse';
                                        } elseif ($dateEnd && $now->isAfter($dateEnd)) {
                                            $statusText = 'Impagada'; $bgColor = 'bg-red-100/80 border-red-300 text-red-900';
                                        } elseif ($dateStart && $dateEnd && $now->between($dateStart, $dateEnd)) {
                                            $statusText = 'En plazo'; $bgColor = 'bg-blue-100/80 border-blue-300 text-blue-900';
                                        } elseif ($dateStart && $now->isBefore($dateStart)) {
                                            $statusText = 'No ejecutada'; $bgColor = 'bg-gray-100 border-gray-300 text-gray-700';
                                        } else {
                                            $statusText = 'Pendiente'; $bgColor = 'bg-amber-100/80 border-amber-300 text-amber-900';
                                        }
                                    @endphp

                                    <div class="p-2.5 rounded-2xl border text-xs {{ $bgColor }} space-y-0.5">
                                        <div class="flex justify-between items-center font-extrabold">
                                            <span>Cuota {{ $payment->cuota }} • {{ $statusText }}</span>
                                            <span class="font-black text-sm">{{ number_format($payment->amount, 2) }} €</span>
                                        </div>
                                        @if($dateStart && $dateEnd)
                                            <p class="text-[10px] font-semibold opacity-75">{{ $dateStart->format('d/m/Y') }} - {{ $dateEnd->format('d/m/Y') }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-3 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                                <span class="text-xs font-bold text-gray-400">Sin pagos generados</span>
                            </div>
                        @endif
                    </div>

                    {{-- Acciones del Jugador --}}
                    <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
                        @if($player->paymentPlayers->count() > 0)
                            <a href="{{ route('pay-orders.show', $player->id) }}" wire:navigate
                               class="flex-1 py-3 bg-primary text-white font-bold text-xs rounded-xl active:scale-95 transition-all text-center flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Ver Cartas
                            </a>
                            <button type="button" wire:click="confirmDeletePlayerPayments({{ $player->id }})" 
                                    class="py-3 px-4 bg-red-50 text-red-600 font-bold text-xs rounded-xl active:scale-95 transition-all">
                                Eliminar
                            </button>
                        @else
                            <button type="button" wire:click="generateSinglePlayerPayments({{ $player->id }})" 
                                    wire:loading.attr="disabled" wire:target="generateSinglePlayerPayments({{ $player->id }})"
                                    class="flex-1 py-3 bg-green-600 text-white font-bold text-xs rounded-xl active:scale-95 transition-all flex items-center justify-center gap-1.5">
                                <svg wire:loading.remove wire:target="generateSinglePlayerPayments({{ $player->id }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <span wire:loading.remove wire:target="generateSinglePlayerPayments({{ $player->id }})">Generar Pagos</span>
                                <span wire:loading wire:target="generateSinglePlayerPayments({{ $player->id }})">Generando...</span>
                            </button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="font-bold text-gray-900 mb-1">Sin jugadores</p>
                    <p class="text-xs text-gray-500">No se encontraron resultados con los filtros actuales.</p>
                </div>
            @endforelse

            {{-- Paginación --}}
            @if($players->hasPages())
                <div class="pt-4 pb-8">{{ $players->links() }}</div>
            @endif
        </div>
    </main>

    {{-- BOTTOM APP BAR (Fijo Abajo) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50">
        
        {{-- MODO ACCIÓN EN LOTE (Si hay jugadores seleccionados) --}}
        @if(count($selectedPlayers) > 0)
            <button wire:click="openStateChangeModal" 
                    class="w-full py-4 bg-blue-600 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Cambiar Estado ({{ count($selectedPlayers) }})
            </button>
        
        {{-- MODO NORMAL --}}
        @else
            <div class="flex items-center gap-2">
                {{-- Excel --}}
                {{-- <button wire:click="exportExcel" class="py-4 px-3 bg-gray-100 text-green-700 font-bold text-xs rounded-2xl active:scale-95 transition-all flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Excel</span>
                </button> --}}

                {{-- Transferencias --}}
                {{-- <button wire:click="openTransferModal" class="py-4 px-3 bg-purple-50 text-purple-700 font-bold text-xs rounded-2xl active:scale-95 transition-all flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Transf.</span>
                </button> --}}

                {{-- Notificar (Con Icono de Sobre/Notificación) --}}
                @if($activeSeason && $seasonFilter == $activeSeason->id)
                    <button wire:click="openNotifyModal" class="py-4 px-3 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-2xl active:scale-95 transition-all flex items-center justify-center gap-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Notificar</span>
                    </button>
                @endif

                {{-- Generar Cartas de Pago (Con Icono de Documento/Suma) --}}
                @if($activeSeason && $hasPlayersWithoutPayments)
                    <button wire:click="prepareGeneratePaymentOrders" wire:loading.attr="disabled"
                            class="flex-1 py-4 bg-green-600 text-white font-black text-xs rounded-2xl active:scale-95 transition-all shadow-lg shadow-green-600/30 flex justify-center items-center gap-1.5 relative">
                        <svg wire:loading.remove wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders" class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <svg wire:loading wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders" class="animate-spin w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders">Generar Cartas</span>
                        <span wire:loading wire:target="prepareGeneratePaymentOrders,confirmGeneratePaymentOrders">Generando...</span>
                        
                        {{-- Insignia Parpadeante --}}
                        <span class="absolute -top-1 -right-1 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                        </span>
                    </button>
                @endif
            </div>
        @endif
    </div>

    {{-- ============================================================== --}}
    {{-- MODALES CONVERTIDOS Y OPTIMIZADOS (Anti-Crash y Scroll Móvil)   --}}
    {{-- ============================================================== --}}

    {{-- 1. Modal Eliminar Pagos Jugador --}}
    <x-dialog-modal wire:model="showDeleteModal" maxWidth="sm">
        <x-slot name="title"><span class="font-black text-lg text-red-600">Eliminar Cartas de Pago</span></x-slot>
        <x-slot name="content">
            <p class="text-xs font-semibold text-gray-600">¿Estás seguro de que deseas eliminar todas las cartas de pago de <strong>{{ $playerToDelete?->name }} {{ $playerToDelete?->surname }}</strong>?</p>
            <p class="text-xs font-bold text-red-600 mt-2">Esta acción no se puede deshacer.</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="$set('showDeleteModal', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="deletePlayerPayments" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Eliminar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- 2. Modal Cambio de Estado en Lote --}}
    <x-dialog-modal wire:model="showStateChangeModal" maxWidth="md">
        <x-slot name="title"><span class="font-black text-lg text-titanium">Cambiar Estado de Pagos</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                <p class="text-xs font-bold text-gray-500">Aplica a <strong class="text-primary">{{ count($selectedPlayers) }}</strong> jugador(es) seleccionados.</p>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase mb-1">Cuotas</label>
                    <select wire:model="stateChangeCuota" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold">
                        <option value="">-- Selecciona cuota --</option>
                        @for($i = 1; $i <= $maxCuotas; $i++) <option value="{{ $i }}">Cuota {{ $i }}</option> @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase mb-1">Nuevo Estado</label>
                    <select wire:model="stateChangeNewState" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold">
                        <option value="">-- Selecciona estado --</option>
                        @foreach(config('constants.states_payment_orders') as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeStateChangeModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="bulkUpdateState" wire:loading.attr="disabled" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95">Actualizar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- 3. Modal Marcar Transferencias --}}
    <x-dialog-modal wire:model="showTransferModal" maxWidth="2xl">
        <x-slot name="title"><span class="font-black text-lg text-purple-700">Marcar Transferencias</span></x-slot>
        <x-slot name="content">
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                {{-- Búsqueda Rápida --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-titanium uppercase">Búsqueda rápida</label>
                    <div class="flex gap-2">
                        <input wire:model="transferSearch" wire:keydown.enter="searchTransfers" type="search" placeholder="Código, jugador o tutor..." class="flex-1 px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold">
                        <button wire:click="searchTransfers" class="px-4 py-3 bg-purple-600 text-white font-bold text-xs rounded-2xl active:scale-95">Buscar</button>
                    </div>
                </div>

                {{-- Importación Excel --}}
                <div class="p-4 bg-purple-50 rounded-2xl border border-purple-100 space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-purple-900">Importar Excel de Banco</span>
                        <button wire:click="downloadTransferTemplate" class="text-[10px] font-bold text-purple-700 underline">Plantilla</button>
                    </div>
                    <input type="file" wire:model="excelFile" accept=".xlsx,.xls,.csv" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:bg-purple-600 file:text-white cursor-pointer">
                    @if($excelFile)
                        <button wire:click="importExcelTransfers" wire:loading.attr="disabled" class="w-full py-2.5 bg-purple-600 text-white font-bold text-xs rounded-xl active:scale-95 mt-1">Procesar Excel</button>
                    @endif
                </div>

                {{-- Tabla de Resultados dentro del modal --}}
                @if(count($transferResults) > 0)
                    <div class="space-y-2 pt-2">
                        <span class="block text-xs font-bold text-titanium uppercase">Resultados Encontrados</span>
                        <div class="space-y-2">
                            @foreach($transferResults as $result)
                                @php
                                    $isNoMatch = $result['no_match'] ?? false;
                                    $isFromQuick = $result['from_quick_search'] ?? false;
                                @endphp
                                <div class="p-3 rounded-2xl border text-xs flex items-center justify-between gap-2 {{ $isNoMatch ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-100' }}">
                                    @if(!$isNoMatch)
                                        @if($isFromQuick)
                                            <input type="radio" wire:model="selectedQuickSearchPayment" value="{{ $result['id'] }}" class="w-4 h-4 text-purple-600">
                                        @else
                                            <input type="checkbox" wire:model="selectedTransferPayments" value="{{ $result['id'] }}" class="w-4 h-4 text-purple-600 rounded">
                                        @endif
                                    @endif

                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-gray-900 truncate">{{ $result['player_name'] }}</p>
                                        <p class="text-[10px] text-gray-500 font-mono">Ref: {{ $result['code'] }} • Cuota {{ $result['cuota'] }}</p>
                                    </div>
                                    <span class="font-black text-purple-700">{{ $result['amount'] !== '-' ? number_format($result['amount'], 2) . ' €' : '-' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeTransferModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="markTransfersAsPaid" wire:loading.attr="disabled" class="flex-1 py-3 bg-purple-600 text-white font-bold text-sm rounded-xl active:scale-95">Marcar Pagados</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- 4. Modal Confirmar Transferencias --}}
    <x-dialog-modal wire:model="showTransferConfirmModal" maxWidth="lg">
        <x-slot name="title"><span class="font-black text-lg text-purple-700">Confirmar Transferencias</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                <p class="text-xs font-bold text-gray-500">Se marcarán <strong class="text-purple-700">{{ count($paymentsToMarkPreview) }}</strong> pagos como realizados por transferencia.</p>
                <div class="space-y-2">
                    @foreach($paymentsToMarkPreview as $payment)
                        <div class="p-3 bg-purple-50/60 rounded-2xl border border-purple-100 text-xs flex justify-between items-center">
                            <div>
                                <p class="font-bold text-titanium">{{ $payment['player_name'] }}</p>
                                <p class="text-[10px] text-gray-400">Cuota {{ $payment['cuota'] }} • Code: {{ $payment['code'] }}</p>
                            </div>
                            <span class="font-black text-purple-700">{{ number_format($payment['amount'], 2) }} €</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeTransferConfirmModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="confirmMarkTransfersAsPaid" wire:loading.attr="disabled" class="flex-1 py-3 bg-purple-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar Todo</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- 5. Modal Notificar Cartas de Pago --}}
    <x-dialog-modal wire:model="showNotifyModal" maxWidth="lg">
        <x-slot name="title"><span class="font-black text-lg text-emerald-700">Notificar Cartas de Pago</span></x-slot>
        <x-slot name="content">
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                <div class="p-3.5 bg-emerald-50 rounded-2xl border border-emerald-100 text-xs text-emerald-900 font-semibold">
                    Se enviarán <strong class="text-emerald-950 font-black">{{ $notifyLettersCount }}</strong> cartas de pago a <strong class="text-emerald-950 font-black">{{ $notifyPlayersCount }}</strong> jugadores.
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-titanium uppercase">Filtros de Envíos</label>
                    <select wire:model.live="cuotaNotify" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold">
                        <option value="">Todas las cuotas</option>
                        @for($i = 1; $i <= $maxCuotas; $i++) <option value="{{ $i }}">Cuota {{ $i }}</option> @endfor
                    </select>

                    <select wire:model.live="teamNotify" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold">
                        <option value="">Todos los equipos</option>
                        @foreach($teams as $team) <option value="{{ $team->id }}">{{ $team->team }}</option> @endforeach
                    </select>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3 p-3.5 bg-emerald-50/70 rounded-2xl border border-emerald-200 cursor-pointer">
                        <input type="checkbox" wire:model.live="notifyChannelEmail" class="w-5 h-5 text-emerald-600 rounded">
                        <div>
                            <span class="text-xs font-bold text-emerald-900 block">Enviar por Email</span>
                            <span class="text-[10px] text-emerald-700 block">Adjunta el PDF con la carta de pago oficial.</span>
                        </div>
                    </label>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeNotifyModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="sendNotifications" wire:loading.attr="disabled" @disabled(!$notifyChannelEmail || $notifyLettersCount === 0) class="flex-[2] py-3 bg-emerald-600 text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="sendNotifications">Enviar Envíos</span>
                    <span wire:loading wire:target="sendNotifications">Encolando…</span>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- 6. Modal Confirmar Generar Cartas Pendientes --}}
    <x-dialog-modal wire:model="showGenerateConfirmModal" maxWidth="sm">
        <x-slot name="title"><span class="font-black text-lg text-green-700">Confirmar Generación</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3 text-center">
                <div class="p-4 bg-green-50 rounded-2xl border border-green-100">
                    <p class="text-2xl font-black text-green-700">{{ $previewGenerateCount }}</p>
                    <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Cartas de Pago</p>
                </div>
                <p class="text-xs font-semibold text-gray-600">Se generarán las cuotas pendientes para {{ $previewPlayersCount }} jugadores en {{ $previewTeamsCount }} equipos de la temporada activa.</p>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeGenerateConfirmModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="confirmGeneratePaymentOrders" wire:loading.attr="disabled" class="flex-[2] py-3 bg-green-600 text-white font-bold text-sm rounded-xl active:scale-95 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="confirmGeneratePaymentOrders">Generar</span>
                    <span wire:loading wire:target="confirmGeneratePaymentOrders">Procesando...</span>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- SCRIPTS DE LIMPIEZA DE OVERFLOW --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
            });
        });
    </script>
</div>