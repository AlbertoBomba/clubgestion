<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar, .flatpickr-calendar.open { z-index: 10000 !important; }
</style>
<?php $__env->stopPush(); ?>

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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-2xl shadow-sm">
            <p class="text-sm text-neon-green font-bold"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="m-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
            <p class="text-sm text-red-700 font-bold"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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

    
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div>
           
            <p class="text-xs font-bold text-gray-500">
                <span class="text-primary"><?php echo e(collect($teams)->count()); ?></span> equipos encontrados
            </p>
        </div>
    </header>

    <main class="p-4 space-y-4">
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActiveSeason && $teamsPendingPayments->count() > 0): ?>
            <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-black text-amber-900 leading-tight">Equipos sin cuotas</p>
                        <p class="text-xs font-semibold text-amber-800 mt-1">
                            Hay <?php echo e($teamsPendingPayments->count()); ?> equipos con precio pero sin cuotas generadas.
                        </p>
                        
                        <details class="mt-2 text-xs">
                            <summary class="cursor-pointer text-amber-900 font-bold active:scale-95 outline-none select-none flex items-center gap-1">
                                Ver detalles
                            </summary>
                            <div class="mt-2 space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamsPendingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white/60 p-2 rounded-xl border border-amber-200 flex justify-between items-center">
                                        <span class="font-bold text-amber-900"><?php echo e($team->team); ?></span>
                                        <span class="font-black text-amber-700"><?php echo e(number_format($team->price, 2)); ?> €</span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </details>

                        <button wire:click="openGenerateModal" class="mt-3 w-full py-3 bg-amber-500 text-white font-black text-sm rounded-xl active:scale-95 transition-all shadow-sm">
                            Generar Cuotas Ahora
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-blue-50 border border-blue-100 rounded-3xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            <div>
                <p class="text-xs font-bold text-blue-900">Solo podrás editar cuotas antes de que entren en vigor.</p>
            </div>
        </div>

        
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($season->id); ?>"><?php echo e($season->season); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $season->id === $activeSeason->id): ?> (En curso) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActiveSeason && collect($teams)->count() > 0): ?>
            <div class="flex items-center justify-between px-2">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary"
                           wire:model.live="selectAllTeams"
                           @click="if($event.target.checked) { 
                               let selectableTeams = <?php echo \Illuminate\Support\Js::from($teams->filter(function($t) {
                                   if (!$t->price || $t->price == 0) return false;
                                   if ($t->payments_count == 0) return true;
                                   foreach($t->payments as $payment) {
                                       if ($payment->isActive() || $payment->date_end < now()) return false;
                                   }
                                   return true;
                               })->pluck('id')->toArray())->toHtml() ?>;
                               $wire.set('selectedTeamsToDelete', selectableTeams); 
                           } else { 
                               $wire.set('selectedTeamsToDelete', []); 
                           }">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Seleccionar eliminables</span>
                </label>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white-pure rounded-3xl p-5 shadow-sm border <?php echo e($team->payments_count > 0 ? 'border-primary ring-1 ring-primary/20 bg-primary/5' : 'border-gray-100'); ?>">
                    
                    
                    <div class="flex justify-between items-start gap-3 border-b <?php echo e($team->payments_count > 0 ? 'border-primary/10' : 'border-gray-50'); ?> pb-3 mb-3">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActiveSeason): ?>
                                <?php
                                    $hasActiveOrExpiredPayments = false;
                                    if($team->payments_count > 0) {
                                        foreach($team->payments as $payment) {
                                            if($payment->isActive() || $payment->date_end < now()) {
                                                $hasActiveOrExpiredPayments = true; break;
                                            }
                                        }
                                    }
                                    $canDelete = ($team->price && $team->price > 0 && !$hasActiveOrExpiredPayments);
                                ?>

                                <div class="pt-1 flex-shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canDelete): ?>
                                        <input type="checkbox" wire:model.live="selectedTeamsToDelete" value="<?php echo e($team->id); ?>" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                    <?php else: ?>
                                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="min-w-0">
                                <h3 class="font-black text-base text-titanium truncate leading-tight"><?php echo e($team->team); ?></h3>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5"><?php echo e($team->section->name ?? 'Sin sección'); ?> • <?php echo e($team->category->category ?? '-'); ?></p>
                            </div>
                        </div>

                        <div class="text-right flex-shrink-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->price && $team->price > 0): ?>
                                <p class="font-black text-lg text-green-600 leading-none"><?php echo e(number_format($team->price, 2)); ?> €</p>
                                <p class="text-[10px] text-gray-500 font-bold mt-1">Precio Temporada</p>
                            <?php else: ?>
                                <p class="font-black text-sm text-red-500 leading-none">Sin precio</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="flex items-center justify-between mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->price && $team->price > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0): ?>
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 text-[10px] font-black uppercase rounded-lg border border-green-200">
                                    Con Cuotas (<?php echo e($team->payments_count); ?>)
                                </span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-[10px] font-black uppercase rounded-lg border border-amber-200">
                                    Sin Cuotas
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[10px] font-black uppercase rounded-lg border border-gray-200">
                                No Generable
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php
                            $totalTeamAmount = 0;
                            if($team->payments_count > 0){
                                foreach($team->payments as $payment) {
                                    $totalTeamAmount += $payment->amount;
                                }
                            }
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0): ?>
                            <div class="text-right">
                                <p class="text-xs font-black <?php echo e(round($totalTeamAmount,2) != round($team->price,2) ? 'text-red-600' : 'text-green-600'); ?>">Total: <?php echo e(number_format($totalTeamAmount, 2)); ?> €</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0): ?>
                        <div class="mt-4 space-y-3">
                            <h4 class="text-[10px] font-bold text-primary uppercase tracking-wider mb-1">Estado de Recaudación</h4>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $team->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $totalPayments = $payment->paymentPlayers->count();
                                    $paidPayments = $payment->paymentPlayers->where('state', 1)->count();
                                    $unpaidPayments = $totalPayments - $paidPayments;
                                    
                                    $paidPercentage = $totalPayments > 0 ? round(($paidPayments / $totalPayments) * 100) : 0;
                                    $unpaidPercentage = 100 - $paidPercentage;
                                    
                                    $totalRecaudado = $paidPayments * $payment->amount;
                                    $totalPorRecaudar = $unpaidPayments * $payment->amount;
                                    $totalPosible = $totalPayments * $payment->amount;
                                ?>

                                <div wire:click="openPaymentDetailsModal(<?php echo e($payment->id); ?>)" 
                                     class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm active:scale-95 transition-all cursor-pointer relative overflow-hidden group">
                                     
                                     <div wire:loading wire:target="openPaymentDetailsModal(<?php echo e($payment->id); ?>)" class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center">
                                         <svg class="animate-spin h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                         </svg>
                                     </div>

                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-sm group-hover:bg-primary group-hover:text-white transition-colors"><?php echo e($payment->cuota); ?></span>
                                            <div>
                                                <p class="font-bold text-sm text-titanium"><?php echo e($payment->description); ?></p>
                                                <p class="text-[10px] font-semibold text-gray-400 mt-0.5"><?php echo e($payment->date_start->format('d/m/Y')); ?> - <?php echo e($payment->date_end->format('d/m/Y')); ?></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-black text-base text-primary"><?php echo e(number_format($payment->amount, 2)); ?> €</p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->isActive()): ?>
                                                <span class="inline-block mt-1 text-[9px] font-bold text-green-600 uppercase tracking-wider bg-green-50 border border-green-200 px-1.5 py-0.5 rounded">En vigor</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <div class="space-y-2 mt-3 pt-3 border-t border-gray-100">
                                        <div class="flex justify-between text-[11px] font-black">
                                            <span class="text-green-600">Recaudado: <?php echo e(number_format($totalRecaudado, 2)); ?> €</span>
                                            <span class="text-amber-600">Pendiente: <?php echo e(number_format($totalPorRecaudar, 2)); ?> €</span>
                                        </div>
                                        
                                        <div class="w-full bg-red-100 rounded-full h-2.5 overflow-hidden flex shadow-inner">
                                            <div class="bg-green-500 h-full transition-all duration-500" style="width: <?php echo e($paidPercentage); ?>%"></div>
                                            <div class="bg-amber-500 h-full transition-all duration-500" style="width: <?php echo e($unpaidPercentage); ?>%"></div>
                                        </div>
                                        
                                        <div class="flex justify-between text-[10px] font-semibold text-gray-500">
                                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> <?php echo e($paidPayments); ?> pagados</span>
                                            <span>Total posible: <strong class="text-gray-700"><?php echo e(number_format($totalPosible, 2)); ?> €</strong></span>
                                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span> <?php echo e($unpaidPayments); ?> impagos</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->price && $team->price > 0): ?>
                        <div class="flex items-center gap-2 pt-4 mt-2 border-t border-gray-50">
                            <?php
                                $canEdit = false;
                                $canDeleteSingle = false;
                                foreach($team->payments as $payment) {
                                    if ($payment->canBeEdited()) $canEdit = true;
                                    if ($payment->canBeDeleted()) $canDeleteSingle = true;
                                }
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canEdit): ?>
                                    <button wire:click="openEditModal(<?php echo e($team->id); ?>)" class="flex-1 py-3 bg-blue-50 text-blue-700 font-bold text-xs rounded-xl active:scale-95 transition-all">Editar Cuotas</button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canDeleteSingle): ?>
                                    <button wire:click="openDeleteSingleModal(<?php echo e($team->id); ?>)" class="flex-1 py-3 bg-red-50 text-red-600 font-bold text-xs rounded-xl active:scale-95 transition-all">Eliminar Cuotas</button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$canEdit && !$canDeleteSingle): ?>
                                    <button disabled class="flex-1 py-3 bg-gray-100 text-gray-400 font-bold text-xs rounded-xl cursor-not-allowed border border-gray-200">Configuración bloqueada</button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="font-bold text-gray-900 mb-1">Sin equipos</p>
                    <p class="text-xs text-gray-500">No hay equipos registrados o con los filtros actuales.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </main>

    
    <div class="fixed bottom-0 items-center flex-col left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-2">
        <div class="flex gap-2 w-full">
            <button wire:click="printPayments" wire:loading.attr="disabled" class="py-4 px-4 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex justify-center items-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            </button>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedTeamsToDelete) > 0): ?>
                <button wire:click="openDeleteModal" wire:loading.attr="disabled" class="flex-[2] py-4 bg-red-600 text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Borrar Seleccionados
                </button>
            <?php else: ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActiveSeason): ?>
                    <button wire:click="openGenerateModal" wire:loading.attr="disabled" class="flex-[2] py-4 bg-primary text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg shadow-primary/30 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Generar Cuotas
                    </button>
                <?php else: ?>
                    <button disabled class="flex-[2] py-4 bg-gray-200 text-gray-500 rounded-2xl font-black text-sm cursor-not-allowed flex justify-center items-center">
                        Temporada Inactiva
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
         <h2 class="font-black text-xl text-titanium leading-tight">
            Gestión de Cuotas
        </h2>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-black text-lg text-titanium">Generar Cuotas de Matrícula</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4 pb-12">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showPreview): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSeasonId): ?>
                        <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-xl text-xs font-bold text-blue-900">
                            Temporada: <?php echo e($seasons->firstWhere('id', $selectedSeasonId)->season ?? ''); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Número de Plazos</label>
                        <select wire:model.live="numPlazos" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $maxPlazos; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?> <?php echo e($i == 1 ? 'plazo' : 'plazos'); ?></option>
                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($maxPlazos < 12): ?>
                            <p class="text-[10px] text-gray-500 font-bold">Máximo <?php echo e($maxPlazos); ?> plazos según configuración de la temporada.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($numPlazos > 0): ?>
                        <div class="space-y-3">
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Fechas de los Plazos</label>
                            
                            <div wire:loading wire:target="numPlazos" class="text-center py-4">
                                <svg class="animate-spin h-6 w-6 text-primary mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" wire:loading.remove wire:target="numPlazos">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $numPlazos; $i++): ?>
                                    <div class="bg-gray-50 p-3 rounded-2xl border <?php echo e(isset($plazoErrors[$i]) ? 'border-red-500' : 'border-gray-200'); ?>">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-2">Cuota <?php echo e($i); ?></p>
                                        <div wire:ignore>
                                            <input type="text" id="flatpickr-<?php echo e($i); ?>" class="flatpickr-input w-full px-3 py-2 border-0 bg-white rounded-xl text-xs font-bold text-titanium shadow-sm focus:ring-2 focus:ring-primary" placeholder="Seleccionar fechas">
                                        </div>
                                        <input type="hidden" wire:model.live="plazos.<?php echo e($i); ?>.date_start" id="date_start_<?php echo e($i); ?>">
                                        <input type="hidden" wire:model.live="plazos.<?php echo e($i); ?>.date_end" id="date_end_<?php echo e($i); ?>">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($plazoErrors[$i])): ?>
                                            <p class="text-[10px] text-red-500 font-bold mt-1"><?php echo e($plazoErrors[$i]); ?></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($modalTeams) > 0): ?>
                        <div class="pt-4 border-t border-gray-100 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Equipos a Generar</label>
                                <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-primary">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                                           @click="$wire.selectedTeamIds = $event.target.checked ? <?php echo \Illuminate\Support\Js::from($modalTeams->filter(fn($t) => $t->price > 0)->pluck('id')->toArray())->toHtml() ?> : []">
                                    <span>Seleccionar todos</span>
                                </label>
                            </div>

                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $modalTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $hasPrice = $team->price && $team->price > 0;
                                        $totalTeamAmount = 0;
                                        for($j = 1; $j <= $numPlazos; $j++) {
                                            $totalTeamAmount += floatval($teamAmounts[$team->id][$j] ?? 0);
                                        }
                                        $isTotalError = isset($teamTotalErrors[$team->id]);
                                    ?>

                                    <div class="bg-white border rounded-2xl p-4 shadow-sm space-y-3 <?php echo e(!$hasPrice ? 'bg-red-50/50 border-red-200' : 'border-gray-200'); ?>">
                                        <div class="flex items-center justify-between gap-3 pb-2 border-b border-gray-100">
                                            <div class="flex items-center gap-3">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasPrice): ?>
                                                    <input type="checkbox" 
                                                           wire:model.live="selectedTeamIds" 
                                                           value="<?php echo e($team->id); ?>" 
                                                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                                                <?php else: ?>
                                                    <input type="checkbox" disabled class="w-5 h-5 border-gray-300 rounded opacity-50 cursor-not-allowed">
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <div>
                                                    <p class="font-black text-sm <?php echo e(!$hasPrice ? 'text-red-700' : 'text-titanium'); ?>"><?php echo e($team->team); ?></p>
                                                    <p class="text-[10px] text-gray-500 font-bold"><?php echo e($team->section->name ?? '-'); ?></p>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasPrice): ?>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Precio Temp.</p>
                                                    <p class="font-black text-sm text-green-600"><?php echo e(number_format($team->price, 2, ',', '.')); ?> €</p>
                                                <?php else: ?>
                                                    <span class="text-[10px] font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Sin precio</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$hasPrice): ?>
                                            <p class="text-xs text-red-600 font-medium">⚠️ No se pueden generar cuotas porque el precio no está configurado.</p>
                                        <?php else: ?>
                                            
                                            <div class="space-y-2">
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Configurar Cuotas</p>
                                                <div class="space-y-2">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $numPlazos; $i++): ?>
                                                        <div class="bg-gray-50 p-2.5 rounded-xl flex items-center justify-between gap-3 border border-gray-100">
                                                            <div class="min-w-0">
                                                                <span class="font-bold text-xs text-titanium block">Cuota <?php echo e($i); ?></span>
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($plazos[$i])): ?>
                                                                    <span class="text-[10px] text-gray-500 font-semibold block truncate">
                                                                        <?php echo e($plazos[$i]['date_start'] ? \Carbon\Carbon::parse($plazos[$i]['date_start'])->format('d/m/Y') : '-'); ?> al <?php echo e($plazos[$i]['date_end'] ? \Carbon\Carbon::parse($plazos[$i]['date_end'])->format('d/m/Y') : '-'); ?>

                                                                    </span>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            </div>

                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                <input type="number" 
                                                                       wire:model.blur="teamAmounts.<?php echo e($team->id); ?>.<?php echo e($i); ?>"
                                                                       step="0.01"
                                                                       min="0"
                                                                       <?php echo e($numPlazos == 1 ? 'disabled' : ''); ?>

                                                                       class="w-24 px-2.5 py-1.5 text-xs font-black text-center border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary <?php echo e($numPlazos == 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-blue-600'); ?>"
                                                                       placeholder="0.00">
                                                                <span class="text-xs font-bold text-gray-500">€</span>
                                                            </div>
                                                        </div>
                                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>

                                            
                                            <div class="flex items-center justify-between p-2.5 bg-gray-100 rounded-xl text-xs font-bold">
                                                <span class="text-gray-600">Suma total cuotas:</span>
                                                <span class="<?php echo e($isTotalError ? 'text-red-600 font-black' : 'text-green-600 font-black'); ?>">
                                                    
                                                    <?php echo e(number_format($team->price, 2, ',', '.')); ?> €
                                                </span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($teamTotalErrors) > 0): ?>
                                <div class="mt-3 p-3 bg-red-50 border-l-4 border-red-500 rounded-xl">
                                    <p class="text-xs font-bold text-red-800 mb-1">Errores en importes:</p>
                                    <ul class="text-[10px] text-red-700 font-semibold pl-4 list-disc">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamTotalErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamId => $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($modalTeams->firstWhere('id', $teamId)->team); ?>: <?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    
                    <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-2xl mb-4">
                        <p class="text-xs font-bold text-blue-900">Previsualización de Cuotas - <?php echo e($seasons->firstWhere('id', $selectedSeasonId)->season ?? ''); ?></p>
                        <p class="text-[10px] font-semibold text-blue-800 mt-1">Se generarán <?php echo e(count($previewData)); ?> equipos × <?php echo e($numPlazos); ?> plazos = <?php echo e(count($previewData) * $numPlazos); ?> cuotas en total.</p>
                    </div>

                    <div class="space-y-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $previewData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                                <div class="bg-gray-50 p-3 border-b border-gray-200 flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-sm text-titanium"><?php echo e($data['team']->team); ?></p>
                                        <p class="text-[10px] font-bold text-gray-500"><?php echo e($data['players_count']); ?> jugadores</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-green-600 text-sm"><?php echo e(number_format($data['team']->price, 2)); ?> €</p>
                                        <p class="text-[10px] font-bold text-gray-400">Total temporada</p>
                                    </div>
                                </div>
                                <div class="p-3 space-y-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $data['payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center justify-between bg-white border border-gray-100 rounded-xl p-2 shadow-sm text-xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center font-bold text-[10px]"><?php echo e($payment['cuota']); ?></span>
                                                <div>
                                                    <p class="font-bold text-titanium"><?php echo e($payment['description']); ?></p>
                                                    <p class="text-[9px] text-gray-400"><?php echo e(\Carbon\Carbon::parse($payment['date_start'])->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($payment['date_end'])->format('d/m/Y')); ?></p>
                                                </div>
                                            </div>
                                            <span class="font-black text-green-600"><?php echo e(number_format($payment['amount'], 2)); ?> €</span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showPreview): ?>
                    <button wire:click="closeModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                    <button wire:click="generatePreview" wire:loading.attr="disabled" wire:target="generatePreview" class="flex-1 py-3 bg-primary text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50 flex items-center justify-center gap-2" <?php if(count($selectedTeamIds) == 0): ?> disabled <?php endif; ?>>
                        <span wire:loading.remove wire:target="generatePreview">Continuar</span>
                        <span wire:loading wire:target="generatePreview" class="inline-flex items-center gap-1">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Calculando...
                        </span>
                    </button>
                <?php else: ?>
                    <button wire:click="backToConfig" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Volver</button>
                    <button wire:click="confirmAndSave" wire:loading.attr="disabled" wire:target="confirmAndSave" class="flex-[2] py-3 bg-green-600 text-white font-bold text-sm rounded-xl active:scale-95 flex justify-center items-center gap-2">
                        <span wire:loading.remove wire:target="confirmAndSave">Confirmar y Generar</span>
                        <span wire:loading wire:target="confirmAndSave" class="inline-flex items-center gap-1">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Generando...
                        </span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showEditModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showEditModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-black text-lg text-titanium">Editar Cuotas - <?php echo e($editingTeam->team ?? ''); ?></span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4 pb-12">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showEditPreview): ?>
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-xl text-xs font-bold text-blue-900 flex justify-between items-center">
                        <span>Precio matrícula total</span>
                        <span class="text-sm font-black"><?php echo e(number_format($editingTeam->price ?? 0, 2)); ?> €</span>
                    </div>

                    <?php
                        $hasNonEditablePayments = false;
                        if($editingTeam) {
                            foreach($editPlazos as $plazo) {
                                if(isset($plazo['can_edit']) && !$plazo['can_edit']) { $hasNonEditablePayments = true; break; }
                            }
                        }
                    ?>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Número de Plazos</label>
                        <select wire:model.live="editNumPlazos" class="w-full px-4 py-3 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary <?php echo e($hasNonEditablePayments ? 'bg-red-50 text-red-900 cursor-not-allowed' : 'bg-gray-50'); ?>" <?php echo e($hasNonEditablePayments ? 'disabled' : ''); ?>>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 12; $i++): ?> <option value="<?php echo e($i); ?>"><?php echo e($i); ?> <?php echo e($i == 1 ? 'Plazo' : 'Plazos'); ?></option> <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasNonEditablePayments): ?>
                            <p class="text-[10px] font-bold text-red-600">⚠️ Bloqueado: Hay cuotas activas o caducadas.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Fechas de los Plazos</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" wire:loading.remove wire:target="editNumPlazos">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $editNumPlazos; $i++): ?>
                                <?php
                                    $canEdit = $editPlazos[$i]['can_edit'] ?? true;
                                    $isExpired = $editPlazos[$i]['is_expired'] ?? false;
                                ?>
                                <div class="p-3 rounded-2xl border-2 <?php echo e($canEdit ? 'border-gray-100 bg-gray-50' : 'border-red-200 bg-red-50'); ?>">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="text-[10px] font-black uppercase tracking-wider <?php echo e($canEdit ? 'text-gray-500' : 'text-red-700'); ?>">Cuota <?php echo e($i); ?></p>
                                        <p class="text-sm font-black <?php echo e($canEdit ? 'text-primary' : 'text-red-600'); ?>"><?php echo e(number_format(($editingTeam->price ?? 0) / $editNumPlazos, 2)); ?> €</p>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$canEdit): ?>
                                        <p class="text-[10px] font-bold text-red-600 mb-2"><?php echo e($isExpired ? '❌ Caducada' : '🔒 En vigor'); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div wire:ignore>
                                        <input type="text" id="edit_flatpickr_<?php echo e($i); ?>" class="edit-flatpickr-input w-full px-3 py-2 border-0 bg-white rounded-xl text-xs font-bold shadow-sm focus:ring-2 <?php echo e($canEdit ? 'text-titanium focus:ring-primary' : 'text-gray-400 cursor-not-allowed'); ?>" placeholder="<?php echo e($canEdit ? 'Fechas' : 'No editable'); ?>" <?php echo e($canEdit ? '' : 'disabled'); ?>>
                                    </div>
                                    <input type="hidden" wire:model.live="editPlazos.<?php echo e($i); ?>.date_start" id="edit_date_start_<?php echo e($i); ?>">
                                    <input type="hidden" wire:model.live="editPlazos.<?php echo e($i); ?>.date_end" id="edit_date_end_<?php echo e($i); ?>">
                                </div>
                            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    
                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded-xl text-xs font-bold text-blue-900 mb-4">
                        Revisión de cambios. Las cuotas caducadas o en vigor no se verán afectadas.
                    </div>
                    <div class="space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $editPreviewData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $canEdit = $payment['can_edit'] ?? true; ?>
                            <div class="flex justify-between items-center p-3 rounded-xl border <?php echo e($canEdit ? 'bg-white border-gray-200' : 'bg-gray-100 border-gray-200 opacity-70'); ?>">
                                <div>
                                    <p class="font-bold text-xs text-titanium"><span class="w-5 h-5 inline-flex items-center justify-center bg-gray-200 rounded-full mr-1 text-[10px]"><?php echo e($payment['cuota']); ?></span> <?php echo e($payment['description']); ?></p>
                                    <p class="text-[10px] text-gray-500 mt-1"><?php echo e($payment['date_start']); ?> - <?php echo e($payment['date_end']); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-sm <?php echo e($canEdit ? 'text-green-600' : 'text-gray-500'); ?>"><?php echo e(number_format($payment['amount'], 2)); ?> €</p>
                                    <p class="text-[9px] font-bold mt-1 <?php echo e($canEdit ? 'text-blue-500' : 'text-gray-400'); ?>"><?php echo e($canEdit ? '✓ Se actualizará' : '🔒 Sin cambios'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showEditPreview): ?>
                    <button wire:click="closeEditModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                    <button wire:click="generateEditPreview" class="flex-1 py-3 bg-amber-600 text-white font-bold text-sm rounded-xl active:scale-95">Continuar</button>
                <?php else: ?>
                    <button wire:click="backToEditConfig" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Volver</button>
                    <button wire:click="updatePayments" wire:loading.attr="disabled" class="flex-[2] py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar y Guardar</button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showDeleteModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showDeleteModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-black text-lg text-red-600">Eliminar Cuotas Seleccionadas</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showDeleteConfirm): ?>
                    <div class="p-3 bg-amber-50 border-l-4 border-amber-500 rounded-xl text-xs font-bold text-amber-900">
                        Revise los equipos a los que se les eliminarán las cuotas. Solo se eliminarán las cuotas pendientes.
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $deletePreviewData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <h4 class="font-black text-sm text-titanium"><?php echo e($data['team']->team); ?></h4>
                                    <p class="text-[10px] font-bold text-gray-400"><?php echo e($data['team']->section->name ?? '-'); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-500">Se eliminarán</p>
                                    <p class="font-black text-red-600 text-base"><?php echo e(number_format($data['total_deletable'], 2)); ?> €</p>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($data['deletable_payments']) > 0): ?>
                                <div class="mt-2 space-y-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $data['deletable_payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex justify-between bg-red-50 p-2 rounded-lg text-xs border border-red-100">
                                            <span class="font-bold text-red-900">C<?php echo e($paymentData['payment']->cuota); ?> - <?php echo e($paymentData['payment']->description); ?></span>
                                            <span class="font-black text-red-600"><?php echo e(number_format($paymentData['payment']->amount, 2)); ?> €</span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-6 space-y-4">
                        <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="font-black text-xl text-gray-900">¿Está completamente seguro?</h3>
                        <p class="text-sm font-bold text-gray-500">Esta acción eliminará de forma irreversible:</p>
                        <p class="text-3xl font-black text-red-600">
                            <?php $totalP = 0; foreach($deletePreviewData as $d) $totalP += count($d['payments']); ?>
                            <?php echo e($totalP); ?> Pagos
                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showDeleteConfirm): ?>
                    <button wire:click="closeDeleteModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                    <button wire:click="showConfirmStep" class="flex-1 py-3 bg-amber-600 text-white font-bold text-sm rounded-xl active:scale-95">Continuar</button>
                <?php else: ?>
                    <button wire:click="closeDeleteModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                    <button wire:click="confirmDelete" wire:loading.attr="disabled" class="flex-[2] py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Sí, Eliminar Definitivamente</button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showDeleteSingleModal','maxWidth' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showDeleteSingleModal','maxWidth' => 'md']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-black text-lg text-red-600">Eliminar Cuotas</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="max-h-[60vh] overflow-y-auto pr-1 space-y-4">
                <div class="p-3 bg-amber-50 border-l-4 border-amber-500 rounded-xl text-xs font-bold text-amber-900">
                    Solo se eliminarán las cuotas que no estén en vigor ni tengan pagos realizados.
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teamToDelete): ?>
                    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm text-center">
                        <h4 class="font-black text-lg text-titanium"><?php echo e($teamToDelete->team); ?></h4>
                        <p class="font-black text-red-600 text-2xl mt-2"><?php echo e(number_format(collect($deletablePaymentsSingle)->sum(fn($p) => $p['payment']->amount), 2)); ?> €</p>
                        <p class="text-[10px] font-bold text-gray-400">Total a eliminar</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="closeDeleteSingleModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($deletablePaymentsSingle) > 0): ?>
                    <button wire:click="confirmDeleteSingleTeam" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Eliminar Cuotas</button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPaymentDetailsModal && $selectedPaymentDetails): ?>
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closePaymentDetailsModal"></div>
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-2xl p-5 shadow-2xl z-10 flex flex-col max-h-[90vh]">
                
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-shrink-0">
                    <div>
                        <h3 class="font-black text-lg text-titanium leading-tight"><?php echo e($selectedPaymentDetails['payment']->description ?? ''); ?></h3>
                        <p class="text-[10px] font-bold text-gray-500"><?php echo e($selectedPaymentDetails['team']->team ?? ''); ?></p>
                    </div>
                    <button wire:click="closePaymentDetailsModal" class="p-2 text-gray-400 bg-gray-50 rounded-full active:scale-95">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto pt-4 space-y-4">
                    
                    <div class="grid grid-cols-3 gap-2">
                        <div class="bg-gray-50 rounded-2xl p-3 text-center">
                            <p class="text-xl font-black text-titanium"><?php echo e($selectedPaymentDetails['total']); ?></p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Total</p>
                        </div>
                        <div class="bg-green-50 rounded-2xl p-3 text-center">
                            <p class="text-xl font-black text-green-600"><?php echo e($selectedPaymentDetails['paid']); ?></p>
                            <p class="text-[9px] font-bold text-green-700 uppercase tracking-wider">Pagados</p>
                        </div>
                        <div class="bg-red-50 rounded-2xl p-3 text-center">
                            <p class="text-xl font-black text-red-600"><?php echo e($selectedPaymentDetails['unpaid']); ?></p>
                            <p class="text-[9px] font-bold text-red-700 uppercase tracking-wider">Impagados</p>
                        </div>
                    </div>

                    
                    <div class="flex bg-gray-100 rounded-xl p-1">
                        <button wire:click="$set('paymentDetailsTab', 'paid')" 
                                wire:loading.attr="disabled"
                                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1.5 <?php echo e($paymentDetailsTab === 'paid' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500'); ?>">
                            <span wire:loading.remove wire:target="paymentDetailsTab">Pagados (<?php echo e($selectedPaymentDetails['paid']); ?>)</span>
                            <span wire:loading wire:target="paymentDetailsTab" class="inline-flex items-center gap-1">
                                <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Cargando...
                            </span>
                        </button>
                        <button wire:click="$set('paymentDetailsTab', 'unpaid')" 
                                wire:loading.attr="disabled"
                                class="flex-1 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center justify-center gap-1.5 <?php echo e($paymentDetailsTab === 'unpaid' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-500'); ?>">
                            <span wire:loading.remove wire:target="paymentDetailsTab">Impagados (<?php echo e($selectedPaymentDetails['unpaid']); ?>)</span>
                            <span wire:loading wire:target="paymentDetailsTab" class="inline-flex items-center gap-1">
                                <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Cargando...
                            </span>
                        </button>
                    </div>

                    
                    <div class="relative min-h-[140px]">
                        <div wire:loading wire:target="paymentDetailsTab" class="absolute inset-0 bg-white/80 backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl transition-all">
                            <svg class="animate-spin h-7 w-7 text-primary mb-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-xs font-bold text-titanium">Actualizando lista...</span>
                        </div>

                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentDetailsTab === 'paid'): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $selectedPaymentDetails['paidPlayers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentPlayer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="bg-green-50/50 border border-green-100 rounded-2xl p-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-bold text-xs text-titanium"><?php echo e($paymentPlayer->player->name); ?> <?php echo e($paymentPlayer->player->last_name); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentPlayer->payment_date): ?><p class="text-[9px] font-semibold text-gray-400"><?php echo e($paymentPlayer->payment_date->format('d/m/Y H:i')); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <span class="font-black text-sm text-green-600"><?php echo e(number_format($paymentPlayer->amount, 2)); ?> €</span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-center text-xs font-bold text-gray-400 py-6">No hay jugadores pagados</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $selectedPaymentDetails['unpaidPlayers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentPlayer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="bg-red-50/50 border border-red-100 rounded-2xl p-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-bold text-xs text-titanium"><?php echo e($paymentPlayer->player->name); ?> <?php echo e($paymentPlayer->player->last_name); ?></p>
                                            <p class="text-[9px] font-semibold <?php echo e($paymentPlayer->state == 2 ? 'text-orange-500' : 'text-red-400'); ?>"><?php echo e($paymentPlayer->state == 2 ? 'Cancelado' : 'Pendiente'); ?></p>
                                        </div>
                                        <span class="font-black text-sm text-red-600"><?php echo e(number_format($paymentPlayer->amount, 2)); ?> €</span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-center text-xs font-bold text-gray-400 py-6">Todos han pagado</p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="pt-3 flex-shrink-0">
                    <button wire:click="closePaymentDetailsModal" class="w-full py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:bg-gray-200">Cerrar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>


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
                        
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('editPlazos.' + plazoNumber + '.date_start', formattedStart);
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('editPlazos.' + plazoNumber + '.date_end', formattedEnd);
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
</script><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\payments-teams\index_mobile.blade.php ENDPATH**/ ?>