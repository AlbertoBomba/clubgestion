@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar, .flatpickr-calendar.open { z-index: 10000 !important; }
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

    {{-- ALERTAS FLASH --}}
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

    <!-- Toast Notification (Alpine) -->
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
                Gestión de Cuotas
            </h2>
            <p class="text-xs font-bold text-gray-500">
                <span class="text-primary">{{ collect($teams)->count() }}</span> equipos encontrados
            </p>
        </div>
    </header>

    <main class="p-4 space-y-4">
        
        {{-- ADVERTENCIA DE EQUIPOS SIN CUOTAS --}}
        @if($isActiveSeason && $teamsPendingPayments->count() > 0)
            <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-black text-amber-900 leading-tight">Equipos sin cuotas</p>
                        <p class="text-xs font-semibold text-amber-800 mt-1">
                            Hay {{ $teamsPendingPayments->count() }} equipos con precio pero sin cuotas generadas.
                        </p>
                        
                        <details class="mt-2 text-xs">
                            <summary class="cursor-pointer text-amber-900 font-bold active:scale-95 outline-none select-none flex items-center gap-1">
                                Ver detalles
                            </summary>
                            <div class="mt-2 space-y-2">
                                @foreach($teamsPendingPayments as $team)
                                    <div class="bg-white/60 p-2 rounded-xl border border-amber-200 flex justify-between items-center">
                                        <span class="font-bold text-amber-900">{{ $team->team }}</span>
                                        <span class="font-black text-amber-700">{{ number_format($team->price, 2) }} €</span>
                                    </div>
                                @endforeach
                            </div>
                        </details>

                        <button wire:click="openGenerateModal" class="mt-3 w-full py-3 bg-amber-500 text-white font-black text-sm rounded-xl active:scale-95 transition-all shadow-sm">
                            Generar Cuotas Ahora
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- INFO IMPORTANTE --}}
        <div class="bg-blue-50 border border-blue-100 rounded-3xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            <div>
                <p class="text-xs font-bold text-blue-900">Solo podrás editar cuotas antes de que entren en vigor.</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white-pure p-4 rounded-3xl border border-gray-100 shadow-sm space-y-3">
            <button @click="showFilters = !showFilters" class="w-full flex items-center justify-between font-bold text-sm text-titanium active:scale-95 transition-all">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filtros de Búsqueda
                </span>
                <svg class="w-4 h-4 transition-transform" :class="showFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="showFilters" x-collapse class="space-y-3 pt-2">
                <input wire:model.live="search" type="search" placeholder="Buscar equipo..." class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                <select wire:model.live="seasonFilter" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                    <option value="">Todas las temporadas</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}">{{ $season->season }} @if($activeSeason && $season->id === $activeSeason->id) (En curso) @endif</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- SELECCIÓN MASIVA (Si hay temporada activa y equipos filtrados) --}}
        @if($isActiveSeason && collect($teams)->count() > 0)
            <div class="flex items-center justify-between px-2">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary"
                           wire:model.live="selectAllTeams"
                           @click="if($event.target.checked) { 
                               let selectableTeams = @js($teams->filter(function($t) {
                                   if (!$t->price || $t->price == 0) return false;
                                   if ($t->payments_count == 0) return true;
                                   foreach($t->payments as $payment) {
                                       if ($payment->isActive() || $payment->date_end < now()) return false;
                                   }
                                   return true;
                               })->pluck('id')->toArray());
                               $wire.set('selectedTeamsToDelete', selectableTeams); 
                           } else { 
                               $wire.set('selectedTeamsToDelete', []); 
                           }">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Seleccionar eliminables</span>
                </label>
            </div>
        @endif

        {{-- LISTADO DE TARJETAS (CARDS) DE EQUIPOS --}}
        <div class="space-y-4">
            @forelse($teams as $team)
                <article class="bg-white-pure rounded-3xl p-5 shadow-sm border {{ $team->payments_count > 0 ? 'border-primary ring-1 ring-primary/20 bg-primary/5' : 'border-gray-100' }}">
                    
                    {{-- Cabecera Card --}}
                    <div class="flex justify-between items-start gap-3 border-b {{ $team->payments_count > 0 ? 'border-primary/10' : 'border-gray-50' }} pb-3 mb-3">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            @if($isActiveSeason)
                                @php
                                    $hasActiveOrExpiredPayments = false;
                                    if($team->payments_count > 0) {
                                        foreach($team->payments as $payment) {
                                            if($payment->isActive() || $payment->date_end < now()) {
                                                $hasActiveOrExpiredPayments = true; break;
                                            }
                                        }
                                    }
                                    $canDelete = ($team->price && $team->price > 0 && !$hasActiveOrExpiredPayments);
                                @endphp

                                <div class="pt-1 flex-shrink-0">
                                    @if($canDelete)
                                        <input type="checkbox" wire:model.live="selectedTeamsToDelete" value="{{ $team->id }}" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                    @else
                                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    @endif
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h3 class="font-black text-base text-titanium truncate leading-tight">{{ $team->team }}</h3>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5">{{ $team->section->name ?? 'Sin sección' }} • {{ $team->category->category ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="text-right flex-shrink-0">
                            @if($team->price && $team->price > 0)
                                <p class="font-black text-lg text-green-600 leading-none">{{ number_format($team->price, 2) }} €</p>
                                <p class="text-[10px] text-gray-500 font-bold mt-1">Precio Temporada</p>
                            @else
                                <p class="font-black text-sm text-red-500 leading-none">Sin precio</p>
                            @endif
                        </div>
                    </div>

                    {{-- Estado de Cuotas Resumen --}}
                    <div class="flex items-center justify-between mb-3">
                        @if($team->price && $team->price > 0)
                            @if($team->payments_count > 0)
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 text-[10px] font-black uppercase rounded-lg border border-green-200">
                                    Con Cuotas ({{ $team->payments_count }})
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-[10px] font-black uppercase rounded-lg border border-amber-200">
                                    Sin Cuotas
                                </span>
                            @endif
                        @else
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[10px] font-black uppercase rounded-lg border border-gray-200">
                                No Generable
                            </span>
                        @endif

                        @php
                            $totalTeamAmount = 0;
                            if($team->payments_count > 0){
                                foreach($team->payments as $payment) {
                                    $totalTeamAmount += $payment->amount;
                                }
                            }
                        @endphp

                        @if($team->payments_count > 0)
                            <div class="text-right">
                                <p class="text-xs font-black {{ round($totalTeamAmount,2) != round($team->price,2) ? 'text-red-600' : 'text-green-600' }}">Total: {{ number_format($totalTeamAmount, 2) }} €</p>
                            </div>
                        @endif
                    </div>

                    {{-- DESGLOSE DE CUOTAS Y RECAUDACIÓN --}}
                    @if($team->payments_count > 0)
                        <div class="mt-4 space-y-3">
                            <h4 class="text-[10px] font-bold text-primary uppercase tracking-wider mb-1">Estado de Recaudación</h4>
                            @foreach($team->payments as $payment)
                                @php
                                    $totalPayments = $payment->paymentPlayers->count();
                                    $paidPayments = $payment->paymentPlayers->where('state', 1)->count();
                                    $unpaidPayments = $totalPayments - $paidPayments;
                                    
                                    $paidPercentage = $totalPayments > 0 ? round(($paidPayments / $totalPayments) * 100) : 0;
                                    $unpaidPercentage = 100 - $paidPercentage;
                                    
                                    $totalRecaudado = $paidPayments * $payment->amount;
                                    $totalPorRecaudar = $unpaidPayments * $payment->amount;
                                    $totalPosible = $totalPayments * $payment->amount;
                                @endphp

                                <div wire:click="openPaymentDetailsModal({{ $payment->id }})" 
                                     class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm active:scale-95 transition-all cursor-pointer relative overflow-hidden group">
                                     
                                     <div wire:loading wire:target="openPaymentDetailsModal({{ $payment->id }})" class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center">
                                         <svg class="animate-spin h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                         </svg>
                                     </div>

                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-sm group-hover:bg-primary group-hover:text-white transition-colors">{{ $payment->cuota }}</span>
                                            <div>
                                                <p class="font-bold text-sm text-titanium">{{ $payment->description }}</p>
                                                <p class="text-[10px] font-semibold text-gray-400 mt-0.5">{{ $payment->date_start->format('d/m/Y') }} - {{ $payment->date_end->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-black text-base text-primary">{{ number_format($payment->amount, 2) }} €</p>
                                            @if($payment->isActive())
                                                <span class="inline-block mt-1 text-[9px] font-bold text-green-600 uppercase tracking-wider bg-green-50 border border-green-200 px-1.5 py-0.5 rounded">En vigor</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Progress Bar & Stats --}}
                                    <div class="space-y-2 mt-3 pt-3 border-t border-gray-100">
                                        <div class="flex justify-between text-[11px] font-black">
                                            <span class="text-green-600">Recaudado: {{ number_format($totalRecaudado, 2) }} €</span>
                                            <span class="text-amber-600">Pendiente: {{ number_format($totalPorRecaudar, 2) }} €</span>
                                        </div>
                                        
                                        <div class="w-full bg-red-100 rounded-full h-2.5 overflow-hidden flex shadow-inner">
                                            <div class="bg-green-500 h-full transition-all duration-500" style="width: {{ $paidPercentage }}%"></div>
                                            <div class="bg-amber-500 h-full transition-all duration-500" style="width: {{ $unpaidPercentage }}%"></div>
                                        </div>
                                        
                                        <div class="flex justify-between text-[10px] font-semibold text-gray-500">
                                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> {{ $paidPayments }} pagados</span>
                                            <span>Total posible: <strong class="text-gray-700">{{ number_format($totalPosible, 2) }} €</strong></span>
                                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span> {{ $unpaidPayments }} impagos</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Acciones de la Tarjeta --}}
                    @if($team->price && $team->price > 0)
                        <div class="flex items-center gap-2 pt-4 mt-2 border-t border-gray-50">
                            @php
                                $canEdit = false;
                                $canDeleteSingle = false;
                                foreach($team->payments as $payment) {
                                    if ($payment->canBeEdited()) $canEdit = true;
                                    if ($payment->canBeDeleted()) $canDeleteSingle = true;
                                }
                            @endphp

                            @if($team->payments_count > 0)
                                @if($canEdit)
                                    <button wire:click="openEditModal({{ $team->id }})" class="flex-1 py-3 bg-blue-50 text-blue-700 font-bold text-xs rounded-xl active:scale-95 transition-all">Editar Cuotas</button>
                                @endif
                                @if($canDeleteSingle)
                                    <button wire:click="openDeleteSingleModal({{ $team->id }})" class="flex-1 py-3 bg-red-50 text-red-600 font-bold text-xs rounded-xl active:scale-95 transition-all">Eliminar Cuotas</button>
                                @endif
                                @if(!$canEdit && !$canDeleteSingle)
                                    <button disabled class="flex-1 py-3 bg-gray-100 text-gray-400 font-bold text-xs rounded-xl cursor-not-allowed border border-gray-200">Configuración bloqueada</button>
                                @endif
                            @endif
                        </div>
                    @endif
                </article>
            @empty
                <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="font-bold text-gray-900 mb-1">Sin equipos</p>
                    <p class="text-xs text-gray-500">No hay equipos registrados o con los filtros actuales.</p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- BOTTOM APP BAR (Fijo Abajo) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-2">
        <button wire:click="printPayments" wire:loading.attr="disabled" class="py-4 px-4 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex justify-center items-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        </button>

        @if(count($selectedTeamsToDelete) > 0)
            <button wire:click="openDeleteModal" wire:loading.attr="disabled" class="flex-[2] py-4 bg-red-600 text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Borrar Seleccionados
            </button>
        @else
            @if($isActiveSeason)
                <button wire:click="openGenerateModal" wire:loading.attr="disabled" class="flex-[2] py-4 bg-primary text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg shadow-primary/30 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Generar Cuotas
                </button>
            @else
                <button disabled class="flex-[2] py-4 bg-gray-200 text-gray-500 rounded-2xl font-black text-sm cursor-not-allowed flex justify-center items-center">
                    Temporada Inactiva
                </button>
            @endif
        @endif
    </div>

    {{-- MODAL GENERAR CUOTAS --}}
    <x-dialog-modal wire:model="showModal" maxWidth="2xl">
        <x-slot name="title"><span class="font-black text-lg text-titanium">Generar Cuotas de Matrícula</span></x-slot>
        <x-slot name="content">
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4 pb-12">
                @if(!$showPreview)
                    @if($selectedSeasonId)
                        <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-xl text-xs font-bold text-blue-900">
                            Temporada: {{ $seasons->firstWhere('id', $selectedSeasonId)->season ?? '' }}
                        </div>
                    @endif

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Número de Plazos</label>
                        <select wire:model.live="numPlazos" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary">
                            @for($i = 1; $i <= $maxPlazos; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'plazo' : 'plazos' }}</option>
                            @endfor
                        </select>
                        @if($maxPlazos < 12)
                            <p class="text-[10px] text-gray-500 font-bold">Máximo {{ $maxPlazos }} plazos según configuración de la temporada.</p>
                        @endif
                    </div>

                    {{-- Calendarios por plazo --}}
                    @if($numPlazos > 0)
                        <div class="space-y-3">
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Fechas de los Plazos</label>
                            
                            <div wire:loading wire:target="numPlazos" class="text-center py-4">
                                <svg class="animate-spin h-6 w-6 text-primary mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" wire:loading.remove wire:target="numPlazos">
                                @for($i = 1; $i <= $numPlazos; $i++)
                                    <div class="bg-gray-50 p-3 rounded-2xl border {{ isset($plazoErrors[$i]) ? 'border-red-500' : 'border-gray-200' }}">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Cuota {{ $i }}</p>
                                        <div wire:ignore>
                                            <input type="text" id="flatpickr-{{ $i }}" class="flatpickr-input w-full px-3 py-2 border-0 bg-white rounded-xl text-xs font-bold text-titanium shadow-sm focus:ring-2 focus:ring-primary" placeholder="Seleccionar fechas">
                                        </div>
                                        <input type="hidden" wire:model.live="plazos.{{ $i }}.date_start" id="date_start_{{ $i }}">
                                        <input type="hidden" wire:model.live="plazos.{{ $i }}.date_end" id="date_end_{{ $i }}">
                                        @if(isset($plazoErrors[$i]))
                                            <p class="text-[10px] text-red-500 font-bold mt-1">{{ $plazoErrors[$i] }}</p>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endif

                    {{-- Lista de Equipos con Importes y Fechas por Cuota (Restaurado) --}}
                    @if(count($modalTeams) > 0)
                        <div class="pt-4 border-t border-gray-100 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Equipos a Generar</label>
                                <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-primary">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                                           @click="$wire.selectedTeamIds = $event.target.checked ? @js($modalTeams->filter(fn($t) => $t->price > 0)->pluck('id')->toArray()) : []">
                                    <span>Seleccionar todos</span>
                                </label>
                            </div>

                            <div class="space-y-3">
                                @foreach($modalTeams as $team)
                                    @php
                                        $hasPrice = $team->price && $team->price > 0;
                                        $totalTeamAmount = 0;
                                        for($j = 1; $j <= $numPlazos; $j++) {
                                            $totalTeamAmount += floatval($teamAmounts[$team->id][$j] ?? 0);
                                        }
                                        $isTotalError = isset($teamTotalErrors[$team->id]);
                                    @endphp

                                    <div class="bg-white border rounded-2xl p-4 shadow-sm space-y-3 {{ !$hasPrice ? 'bg-red-50/50 border-red-200' : 'border-gray-200' }}">
                                        <div class="flex items-center justify-between gap-3 pb-2 border-b border-gray-100">
                                            <div class="flex items-center gap-3">
                                                @if($hasPrice)
                                                    <input type="checkbox" 
                                                           wire:model.live="selectedTeamIds" 
                                                           value="{{ $team->id }}" 
                                                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                                @else
                                                    <input type="checkbox" disabled class="w-5 h-5 border-gray-300 rounded opacity-50 cursor-not-allowed">
                                                @endif
                                                <div>
                                                    <p class="font-black text-sm {{ !$hasPrice ? 'text-red-700' : 'text-titanium' }}">{{ $team->team }}</p>
                                                    <p class="text-[10px] text-gray-500 font-bold">{{ $team->section->name ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                @if($hasPrice)
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Precio Temp.</p>
                                                    <p class="font-black text-sm text-green-600">{{ number_format($team->price, 2, ',', '.') }} €</p>
                                                @else
                                                    <span class="text-[10px] font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Sin precio</span>
                                                @endif
                                            </div>
                                        </div>

                                        @if(!$hasPrice)
                                            <p class="text-xs text-red-600 font-medium">⚠️ No se pueden generar cuotas porque el precio no está configurado.</p>
                                        @else
                                            {{-- Desglose por Plazo/Cuota --}}
                                            <div class="space-y-2">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Configurar Cuotas</p>
                                                <div class="space-y-2">
                                                    @for($i = 1; $i <= $numPlazos; $i++)
                                                        <div class="bg-gray-50 p-2.5 rounded-xl flex items-center justify-between gap-3 border border-gray-100">
                                                            <div class="min-w-0">
                                                                <span class="font-bold text-xs text-titanium block">Cuota {{ $i }}</span>
                                                                @if(isset($plazos[$i]))
                                                                    <span class="text-[10px] text-gray-500 font-semibold block truncate">
                                                                        {{ $plazos[$i]['date_start'] ? \Carbon\Carbon::parse($plazos[$i]['date_start'])->format('d/m/Y') : '-' }} al {{ $plazos[$i]['date_end'] ? \Carbon\Carbon::parse($plazos[$i]['date_end'])->format('d/m/Y') : '-' }}
                                                                    </span>
                                                                @endif
                                                            </div>

                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                <input type="number" 
                                                                       wire:model.blur="teamAmounts.{{ $team->id }}.{{ $i }}"
                                                                       step="0.01"
                                                                       min="0"
                                                                       {{ $numPlazos == 1 ? 'disabled' : '' }}
                                                                       class="w-24 px-2.5 py-1.5 text-xs font-black text-center border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary {{ $numPlazos == 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-blue-600' }}"
                                                                       placeholder="0.00">
                                                                <span class="text-xs font-bold text-gray-500">€</span>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>

                                            {{-- Suma total vs Precio temporada --}}
                                            <div class="flex items-center justify-between p-2.5 bg-gray-100 rounded-xl text-xs font-bold">
                                                <span class="text-gray-600">Suma total cuotas:</span>
                                                <span class="{{ $isTotalError ? 'text-red-600 font-black' : 'text-green-600 font-black' }}">
                                                    {{-- {{ number_format($totalTeamAmount, 2, ',', '.') }} € de  --}}
                                                    {{ number_format($team->price, 2, ',', '.') }} €
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if(count($teamTotalErrors) > 0)
                                <div class="mt-3 p-3 bg-red-50 border-l-4 border-red-500 rounded-xl">
                                    <p class="text-xs font-bold text-red-800 mb-1">Errores en importes:</p>
                                    <ul class="text-[10px] text-red-700 font-semibold pl-4 list-disc">
                                        @foreach($teamTotalErrors as $teamId => $error)
                                            <li>{{ $modalTeams->firstWhere('id', $teamId)->team }}: {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                @else
                    {{-- Previsualización paso final --}}
                    <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-2xl mb-4">
                        <p class="text-xs font-bold text-blue-900">Previsualización de Cuotas - {{ $seasons->firstWhere('id', $selectedSeasonId)->season ?? '' }}</p>
                        <p class="text-[10px] font-semibold text-blue-800 mt-1">Se generarán {{ count($previewData) }} equipos × {{ $numPlazos }} plazos = {{ count($previewData) * $numPlazos }} cuotas en total.</p>
                    </div>

                    <div class="space-y-4">
                        @foreach($previewData as $data)
                            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                                <div class="bg-gray-50 p-3 border-b border-gray-200 flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-sm text-titanium">{{ $data['team']->team }}</p>
                                        <p class="text-[10px] font-bold text-gray-500">{{ $data['players_count'] }} jugadores</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-green-600 text-sm">{{ number_format($data['team']->price, 2) }} €</p>
                                        <p class="text-[10px] font-bold text-gray-400">Total temporada</p>
                                    </div>
                                </div>
                                <div class="p-3 space-y-2">
                                    @foreach($data['payments'] as $payment)
                                        <div class="flex items-center justify-between bg-white border border-gray-100 rounded-xl p-2 shadow-sm text-xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center font-bold text-[10px]">{{ $payment['cuota'] }}</span>
                                                <div>
                                                    <p class="font-bold text-titanium">{{ $payment['description'] }}</p>
                                                    <p class="text-[9px] text-gray-400">{{ \Carbon\Carbon::parse($payment['date_start'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payment['date_end'])->format('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                            <span class="font-black text-green-600">{{ number_format($payment['amount'], 2) }} €</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                @if(!$showPreview)
                    <button wire:click="closeModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                    <button wire:click="generatePreview" wire:loading.attr="disabled" wire:target="generatePreview" class="flex-1 py-3 bg-primary text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50 flex items-center justify-center gap-2" @if(count($selectedTeamIds) == 0) disabled @endif>
                        <span wire:loading.remove wire:target="generatePreview">Continuar</span>
                        <span wire:loading wire:target="generatePreview" class="inline-flex items-center gap-1">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Calculando...
                        </span>
                    </button>
                @else
                    <button wire:click="backToConfig" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Volver</button>
                    <button wire:click="confirmAndSave" wire:loading.attr="disabled" wire:target="confirmAndSave" class="flex-[2] py-3 bg-green-600 text-white font-bold text-sm rounded-xl active:scale-95 flex justify-center items-center gap-2">
                        <span wire:loading.remove wire:target="confirmAndSave">Confirmar y Generar</span>
                        <span wire:loading wire:target="confirmAndSave" class="inline-flex items-center gap-1">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Generando...
                        </span>
                    </button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Editar Cuotas --}}
    <x-dialog-modal wire:model="showEditModal" maxWidth="2xl">
        <x-slot name="title"><span class="font-black text-lg text-titanium">Editar Cuotas - {{ $editingTeam->team ?? '' }}</span></x-slot>
        <x-slot name="content">
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4 pb-12">
                @if(!$showEditPreview)
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-xl text-xs font-bold text-blue-900 flex justify-between items-center">
                        <span>Precio matrícula total</span>
                        <span class="text-sm font-black">{{ number_format($editingTeam->price ?? 0, 2) }} €</span>
                    </div>

                    @php
                        $hasNonEditablePayments = false;
                        if($editingTeam) {
                            foreach($editPlazos as $plazo) {
                                if(isset($plazo['can_edit']) && !$plazo['can_edit']) { $hasNonEditablePayments = true; break; }
                            }
                        }
                    @endphp

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Número de Plazos</label>
                        <select wire:model.live="editNumPlazos" class="w-full px-4 py-3 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary {{ $hasNonEditablePayments ? 'bg-red-50 text-red-900 cursor-not-allowed' : 'bg-gray-50' }}" {{ $hasNonEditablePayments ? 'disabled' : '' }}>
                            @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Plazo' : 'Plazos' }}</option> @endfor
                        </select>
                        @if($hasNonEditablePayments)
                            <p class="text-[10px] font-bold text-red-600">⚠️ Bloqueado: Hay cuotas activas o caducadas.</p>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Fechas de los Plazos</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" wire:loading.remove wire:target="editNumPlazos">
                            @for($i = 1; $i <= $editNumPlazos; $i++)
                                @php
                                    $canEdit = $editPlazos[$i]['can_edit'] ?? true;
                                    $isExpired = $editPlazos[$i]['is_expired'] ?? false;
                                @endphp
                                <div class="p-3 rounded-2xl border-2 {{ $canEdit ? 'border-gray-100 bg-gray-50' : 'border-red-200 bg-red-50' }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="text-[10px] font-black uppercase tracking-wider {{ $canEdit ? 'text-gray-500' : 'text-red-700' }}">Cuota {{ $i }}</p>
                                        <p class="text-sm font-black {{ $canEdit ? 'text-primary' : 'text-red-600' }}">{{ number_format(($editingTeam->price ?? 0) / $editNumPlazos, 2) }} €</p>
                                    </div>
                                    @if(!$canEdit)
                                        <p class="text-[10px] font-bold text-red-600 mb-2">{{ $isExpired ? '❌ Caducada' : '🔒 En vigor' }}</p>
                                    @endif
                                    <div wire:ignore>
                                        <input type="text" id="edit_flatpickr_{{ $i }}" class="edit-flatpickr-input w-full px-3 py-2 border-0 bg-white rounded-xl text-xs font-bold shadow-sm focus:ring-2 {{ $canEdit ? 'text-titanium focus:ring-primary' : 'text-gray-400 cursor-not-allowed' }}" placeholder="{{ $canEdit ? 'Fechas' : 'No editable' }}" {{ $canEdit ? '' : 'disabled' }}>
                                    </div>
                                    <input type="hidden" wire:model.live="editPlazos.{{ $i }}.date_start" id="edit_date_start_{{ $i }}">
                                    <input type="hidden" wire:model.live="editPlazos.{{ $i }}.date_end" id="edit_date_end_{{ $i }}">
                                </div>
                            @endfor
                        </div>
                    </div>
                @else
                    {{-- Preview Edición --}}
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-xl text-xs font-bold text-blue-900 mb-4">
                        Revisión de cambios. Las cuotas caducadas o en vigor no se verán afectadas.
                    </div>
                    <div class="space-y-2">
                        @foreach($editPreviewData as $payment)
                            @php $canEdit = $payment['can_edit'] ?? true; @endphp
                            <div class="flex justify-between items-center p-3 rounded-xl border {{ $canEdit ? 'bg-white border-gray-200' : 'bg-gray-100 border-gray-200 opacity-70' }}">
                                <div>
                                    <p class="font-bold text-xs text-titanium"><span class="w-5 h-5 inline-flex items-center justify-center bg-gray-200 rounded-full mr-1 text-[10px]">{{ $payment['cuota'] }}</span> {{ $payment['description'] }}</p>
                                    <p class="text-[10px] text-gray-500 mt-1">{{ $payment['date_start'] }} - {{ $payment['date_end'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-sm {{ $canEdit ? 'text-green-600' : 'text-gray-500' }}">{{ number_format($payment['amount'], 2) }} €</p>
                                    <p class="text-[9px] font-bold mt-1 {{ $canEdit ? 'text-blue-500' : 'text-gray-400' }}">{{ $canEdit ? '✓ Se actualizará' : '🔒 Sin cambios' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                @if(!$showEditPreview)
                    <button wire:click="closeEditModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                    <button wire:click="generateEditPreview" class="flex-1 py-3 bg-amber-600 text-white font-bold text-sm rounded-xl active:scale-95">Continuar</button>
                @else
                    <button wire:click="backToEditConfig" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Volver</button>
                    <button wire:click="updatePayments" wire:loading.attr="disabled" class="flex-[2] py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar y Guardar</button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Eliminar Cuotas Masivo --}}
    <x-dialog-modal wire:model="showDeleteModal" maxWidth="2xl">
        <x-slot name="title"><span class="font-black text-lg text-red-600">Eliminar Cuotas Seleccionadas</span></x-slot>
        <x-slot name="content">
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4">
                @if(!$showDeleteConfirm)
                    <div class="p-3 bg-amber-50 border-l-4 border-amber-500 rounded-xl text-xs font-bold text-amber-900">
                        Revise los equipos a los que se les eliminarán las cuotas. Solo se eliminarán las cuotas pendientes.
                    </div>
                    @foreach($deletePreviewData as $data)
                        <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <h4 class="font-black text-sm text-titanium">{{ $data['team']->team }}</h4>
                                    <p class="text-[10px] font-bold text-gray-400">{{ $data['team']->section->name ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-500">Se eliminarán</p>
                                    <p class="font-black text-red-600 text-base">{{ number_format($data['total_deletable'], 2) }} €</p>
                                </div>
                            </div>
                            @if(count($data['deletable_payments']) > 0)
                                <div class="mt-2 space-y-1">
                                    @foreach($data['deletable_payments'] as $paymentData)
                                        <div class="flex justify-between bg-red-50 p-2 rounded-lg text-xs border border-red-100">
                                            <span class="font-bold text-red-900">C{{ $paymentData['payment']->cuota }} - {{ $paymentData['payment']->description }}</span>
                                            <span class="font-black text-red-600">{{ number_format($paymentData['payment']->amount, 2) }} €</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-6 space-y-4">
                        <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="font-black text-xl text-gray-900">¿Está completamente seguro?</h3>
                        <p class="text-sm font-bold text-gray-500">Esta acción eliminará de forma irreversible:</p>
                        <p class="text-3xl font-black text-red-600">
                            @php $totalP = 0; foreach($deletePreviewData as $d) $totalP += count($d['payments']); @endphp
                            {{ $totalP }} Pagos
                        </p>
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                @if(!$showDeleteConfirm)
                    <button wire:click="closeDeleteModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                    <button wire:click="showConfirmStep" class="flex-1 py-3 bg-amber-600 text-white font-bold text-sm rounded-xl active:scale-95">Continuar</button>
                @else
                    <button wire:click="closeDeleteModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                    <button wire:click="confirmDelete" wire:loading.attr="disabled" class="flex-[2] py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Sí, Eliminar Definitivamente</button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Eliminar Cuotas Individual --}}
    <x-dialog-modal wire:model="showDeleteSingleModal" maxWidth="md">
        <x-slot name="title"><span class="font-black text-lg text-red-600">Eliminar Cuotas</span></x-slot>
        <x-slot name="content">
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4">
                <div class="p-3 bg-amber-50 border-l-4 border-amber-500 rounded-xl text-xs font-bold text-amber-900">
                    Solo se eliminarán las cuotas que no estén en vigor ni tengan pagos realizados.
                </div>
                @if($teamToDelete)
                    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm text-center">
                        <h4 class="font-black text-lg text-titanium">{{ $teamToDelete->team }}</h4>
                        <p class="font-black text-red-600 text-2xl mt-2">{{ number_format(collect($deletablePaymentsSingle)->sum(fn($p) => $p['payment']->amount), 2) }} €</p>
                        <p class="text-[10px] font-bold text-gray-400">Total a eliminar</p>
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeDeleteSingleModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                @if(count($deletablePaymentsSingle) > 0)
                    <button wire:click="confirmDeleteSingleTeam" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Eliminar Cuotas</button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Detalles de Cuota y Jugadores --}}
    @if($showPaymentDetailsModal && $selectedPaymentDetails)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closePaymentDetailsModal"></div>
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-2xl p-5 shadow-2xl z-10 flex flex-col max-h-[90vh]">
                
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-shrink-0">
                    <div>
                        <h3 class="font-black text-lg text-titanium leading-tight">{{ $selectedPaymentDetails['payment']->description ?? '' }}</h3>
                        <p class="text-[10px] font-bold text-gray-500">{{ $selectedPaymentDetails['team']->team ?? '' }}</p>
                    </div>
                    <button wire:click="closePaymentDetailsModal" class="p-2 text-gray-400 bg-gray-50 rounded-full active:scale-95">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto pt-4 space-y-4">
                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-2">
                        <div class="bg-gray-50 rounded-2xl p-3 text-center">
                            <p class="text-xl font-black text-titanium">{{ $selectedPaymentDetails['total'] }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Total</p>
                        </div>
                        <div class="bg-green-50 rounded-2xl p-3 text-center">
                            <p class="text-xl font-black text-green-600">{{ $selectedPaymentDetails['paid'] }}</p>
                            <p class="text-[9px] font-bold text-green-700 uppercase tracking-wider">Pagados</p>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-3 text-center">
                            <p class="text-xl font-black text-red-600">{{ $selectedPaymentDetails['unpaid'] }}</p>
                            <p class="text-[9px] font-bold text-red-700 uppercase tracking-wider">Impagados</p>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="flex bg-gray-100 rounded-xl p-1">
                        <button wire:click="$set('paymentDetailsTab', 'paid')" 
                                wire:loading.attr="disabled"
                                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1.5 {{ $paymentDetailsTab === 'paid' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500' }}">
                            <span wire:loading.remove wire:target="paymentDetailsTab">Pagados ({{ $selectedPaymentDetails['paid'] }})</span>
                            <span wire:loading wire:target="paymentDetailsTab" class="inline-flex items-center gap-1">
                                <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Cargando...
                            </span>
                        </button>
                        <button wire:click="$set('paymentDetailsTab', 'unpaid')" 
                                wire:loading.attr="disabled"
                                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1.5 {{ $paymentDetailsTab === 'unpaid' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-500' }}">
                            <span wire:loading.remove wire:target="paymentDetailsTab">Impagados ({{ $selectedPaymentDetails['unpaid'] }})</span>
                            <span wire:loading wire:target="paymentDetailsTab" class="inline-flex items-center gap-1">
                                <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Cargando...
                            </span>
                        </button>
                    </div>

                    {{-- Lista Jugadores con Overlay de Carga --}}
                    <div class="relative min-h-[140px]">
                        <div wire:loading wire:target="paymentDetailsTab" class="absolute inset-0 bg-white/80 backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl transition-all">
                            <svg class="animate-spin h-7 w-7 text-primary mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-xs font-bold text-titanium">Actualizando lista...</span>
                        </div>

                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            @if($paymentDetailsTab === 'paid')
                                @forelse($selectedPaymentDetails['paidPlayers'] as $paymentPlayer)
                                    <div class="bg-green-50/50 border border-green-100 rounded-2xl p-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-bold text-xs text-titanium">{{ $paymentPlayer->player->name }} {{ $paymentPlayer->player->last_name }}</p>
                                            @if($paymentPlayer->payment_date)<p class="text-[9px] font-semibold text-gray-400">{{ $paymentPlayer->payment_date->format('d/m/Y H:i') }}</p>@endif
                                        </div>
                                        <span class="font-black text-sm text-green-600">{{ number_format($paymentPlayer->amount, 2) }} €</span>
                                    </div>
                                @empty
                                    <p class="text-center text-xs font-bold text-gray-400 py-6">No hay jugadores pagados</p>
                                @endforelse
                            @else
                                @forelse($selectedPaymentDetails['unpaidPlayers'] as $paymentPlayer)
                                    <div class="bg-red-50/50 border border-red-100 rounded-2xl p-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-bold text-xs text-titanium">{{ $paymentPlayer->player->name }} {{ $paymentPlayer->player->last_name }}</p>
                                            <p class="text-[9px] font-semibold {{ $paymentPlayer->state == 2 ? 'text-orange-500' : 'text-red-400' }}">{{ $paymentPlayer->state == 2 ? 'Cancelado' : 'Pendiente' }}</p>
                                        </div>
                                        <span class="font-black text-sm text-red-600">{{ number_format($paymentPlayer->amount, 2) }} €</span>
                                    </div>
                                @empty
                                    <p class="text-center text-xs font-bold text-gray-400 py-6">Todos han pagado</p>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-3 flex-shrink-0">
                    <button wire:click="closePaymentDetailsModal" class="w-full py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:bg-gray-200">Cerrar</button>
                </div>
            </div>
        </div>
    @endif

</div>

{{-- SCRIPT EXACTO DE FLATPICKR --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    console.log('Script cargado');
    
    let flatpickrInstances = {};
    let editFlatpickrInstances = {};
    
    function initializeFlatpickr() {
        console.log('=== Initializing Flatpickr ===');
        
        const inputs = document.querySelectorAll('.flatpickr-input');
        console.log('Found inputs:', inputs.length);
        
        inputs.forEach((element) => {
            const id = element.id;
            const plazoNumber = id.replace('flatpickr-', '');
            
            console.log('Processing:', id);
            
            if (flatpickrInstances[id]) {
                console.log('Destroying previous instance for', id);
                flatpickrInstances[id].destroy();
                delete flatpickrInstances[id];
            }
            
            const dateStartInput = document.getElementById('date_start_' + plazoNumber);
            const dateEndInput = document.getElementById('date_end_' + plazoNumber);
            
            if (!dateStartInput || !dateEndInput) {
                console.log('Hidden inputs not found for plazo', plazoNumber);
                return;
            }
            
            console.log('Creating Flatpickr for', id);
            
            const startDate = dateStartInput.value || null;
            const endDate = dateEndInput.value || null;
            const defaultDates = (startDate && endDate) ? [startDate, endDate] : [];
            
            flatpickrInstances[id] = flatpickr(element, {
                mode: 'range',
                dateFormat: 'd/m/Y',
                locale: 'es',
                minDate: 'today',
                defaultDate: defaultDates,
                allowInput: false,
                clickOpens: true,
                onReady: function() {
                    console.log('✓ Flatpickr ready for', id);
                },
                onChange: function(selectedDates, dateStr, instance) {
                    console.log('Date changed for', id, selectedDates);
                    
                    if (selectedDates.length === 2) {
                        const startDate = selectedDates[0];
                        const endDate = selectedDates[1];
                        
                        const formatDate = (date) => {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const day = String(date.getDate()).padStart(2, '0');
                            return `${year}-${month}-${day}`;
                        };
                        
                        const formattedStart = formatDate(startDate);
                        const formattedEnd = formatDate(endDate);
                        
                        dateStartInput.value = formattedStart;
                        dateEndInput.value = formattedEnd;
                        
                        dateStartInput.dispatchEvent(new Event('input', { bubbles: true }));
                        dateEndInput.dispatchEvent(new Event('input', { bubbles: true }));
                        
                        console.log('✓ Set dates:', formattedStart, formattedEnd);
                    }
                }
            });
            
            console.log('✓ Flatpickr instance created for', id);
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            setupObserver();
        });
    } else {
        console.log('DOM already loaded');
        setupObserver();
    }
    
    function setupObserver() {
        console.log('Setting up observer');
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) {
                            if (node.classList && (node.classList.contains('flatpickr-input') || node.classList.contains('edit-flatpickr-input'))) {
                                console.log('Flatpickr input added directly');
                                setTimeout(() => {
                                    initializeFlatpickr();
                                    initializeEditFlatpickr();
                                }, 100);
                            } else if (node.querySelectorAll) {
                                const inputs = node.querySelectorAll('.flatpickr-input');
                                const editInputs = node.querySelectorAll('.edit-flatpickr-input');
                                if (inputs.length > 0 || editInputs.length > 0) {
                                    console.log('Flatpickr inputs detected in added node:', inputs.length + editInputs.length);
                                    setTimeout(() => {
                                        initializeFlatpickr();
                                        initializeEditFlatpickr();
                                    }, 100);
                                }
                            }
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        console.log('Observer set up');
        
        setTimeout(() => {
            const existing = document.querySelectorAll('.flatpickr-input, .edit-flatpickr-input');
            if (existing.length > 0) {
                console.log('Found existing inputs:', existing.length);
                initializeFlatpickr();
                initializeEditFlatpickr();
            }
        }, 500);
    }

    function initializeEditFlatpickr() {
        console.log('=== Initializing Edit Flatpickr ===');
        
        const inputs = document.querySelectorAll('.edit-flatpickr-input');
        console.log('Found edit inputs:', inputs.length);
        
        inputs.forEach((element) => {
            const id = element.id;
            const plazoNumber = id.replace('edit_flatpickr_', '');
            
            console.log('Processing edit:', id);
            
            if (editFlatpickrInstances[id]) {
                console.log('Destroying previous edit instance for', id);
                editFlatpickrInstances[id].destroy();
                delete editFlatpickrInstances[id];
            }
            
            const dateStartInput = document.getElementById('edit_date_start_' + plazoNumber);
            const dateEndInput = document.getElementById('edit_date_end_' + plazoNumber);
            
            if (!dateStartInput || !dateEndInput) {
                console.log('Hidden inputs not found for edit plazo', plazoNumber);
                return;
            }
            
            console.log('Creating Edit Flatpickr for', id);
            
            const startDate = dateStartInput.value || null;
            const endDate = dateEndInput.value || null;
            const defaultDates = (startDate && endDate) ? [startDate, endDate] : [];
            
            editFlatpickrInstances[id] = flatpickr(element, {
                mode: 'range',
                dateFormat: 'd/m/Y',
                locale: 'es',
                minDate: 'today',
                defaultDate: defaultDates,
                allowInput: false,
                clickOpens: true,
                onReady: function() {
                    console.log('✓ Edit Flatpickr ready for', id);
                },
                onChange: function(selectedDates, dateStr, instance) {
                    console.log('Edit date changed for', id, selectedDates);
                    
                    if (selectedDates.length === 2) {
                        const startDate = selectedDates[0];
                        const endDate = selectedDates[1];
                        
                        const formatDate = (date) => {
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        };
                        
                        const formattedStart = formatDate(startDate);
                        const formattedEnd = formatDate(endDate);
                        
                        console.log('Setting edit dates:', formattedStart, formattedEnd);
                        
                        dateStartInput.value = formattedStart;
                        dateEndInput.value = formattedEnd;
                        
                        dateStartInput.dispatchEvent(new Event('input'));
                        dateEndInput.dispatchEvent(new Event('input'));
                        
                        @this.set('editPlazos.' + plazoNumber + '.date_start', formattedStart);
                        @this.set('editPlazos.' + plazoNumber + '.date_end', formattedEnd);
                    }
                }
            });
            
            console.log('✓ Edit Flatpickr created for', id);
        });
    }

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('modal-closed', () => {
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            document.body.classList.remove('overflow-hidden');
        });
    });
</script>