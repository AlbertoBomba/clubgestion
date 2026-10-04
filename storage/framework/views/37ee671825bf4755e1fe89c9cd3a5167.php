<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ tab: '<?php echo e($phases->isNotEmpty() ? 'matches' : 'setup'); ?>' }">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('message')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-[60] max-w-sm bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="fixed top-4 right-4 z-[60] max-w-sm bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm font-medium shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    
    <div class="w-full max-w-screen-2xl mx-auto px-4 sm:px-6 py-6">

        
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm mb-5 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-primary via-primary/60 to-primary/20"></div>
            <div class="p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->logo): ?>
                        <img src="<?php echo e(Storage::url($tournament->logo)); ?>"
                             class="w-16 h-16 rounded-2xl object-cover border border-silver shadow-sm shrink-0" alt="">
                    <?php else: ?>
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/5 border border-primary/20 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <h1 class="text-2xl font-bold text-black-deep leading-tight"><?php echo e($tournament->name); ?></h1>
                            <?php
                                $statusStyles = [
                                    'draft'             => 'bg-gray-100 text-gray-600',
                                    'registration_open' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'in_progress'       => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'completed'         => 'bg-green-50 text-green-700 border border-green-200',
                                    'cancelled'         => 'bg-red-50 text-red-600 border border-red-200',
                                ];
                                $statusLabels = [
                                    'draft'             => 'Borrador',
                                    'registration_open' => 'Inscripciones abiertas',
                                    'in_progress'       => 'En curso',
                                    'completed'         => 'Finalizado',
                                    'cancelled'         => 'Cancelado',
                                ];
                            ?>
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold <?php echo e($statusStyles[$tournament->status] ?? 'bg-gray-100 text-gray-600'); ?>">
                                <?php echo e($statusLabels[$tournament->status] ?? $tournament->status); ?>

                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-sm text-titanium">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->start_date): ?>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <?php echo e($tournament->start_date->translatedFormat('d M Y')); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->end_date): ?> – <?php echo e($tournament->end_date->translatedFormat('d M Y')); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->location): ?>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <?php echo e($tournament->location); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teams->isNotEmpty()): ?>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <?php echo e($teams->count()); ?> equipos
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->isNotEmpty()): ?>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <?php echo e($matches->where('status', 'completed')->count()); ?> / <?php echo e($matches->count()); ?> partidos jugados
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button"
                                wire:click="exportPdf"
                                wire:loading.attr="disabled"
                                wire:target="exportPdf"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm font-semibold hover:bg-red-100 transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg wire:loading.remove wire:target="exportPdf" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M8 6a4 4 0 118 0v6"/></svg>
                            <svg wire:loading wire:target="exportPdf" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="4"/><path stroke-linecap="round" stroke-width="4" d="M22 12a10 10 0 00-10-10"/></svg>
                            <span class="hidden sm:inline" wire:loading.remove wire:target="exportPdf">Descargar PDF</span>
                            <span class="hidden sm:inline" wire:loading wire:target="exportPdf">Generando…</span>
                        </button>
                        <a href="<?php echo e(route('tournaments.edit', $tournament)); ?>"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary/5 text-primary border border-primary/20 text-sm font-semibold hover:bg-primary/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span class="hidden sm:inline">Editar torneo</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type === 'open'): ?>
            <div class="flex items-center gap-2 mb-4 p-3 bg-blue-50 rounded-xl border border-blue-100">
                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs text-blue-700 font-medium">Torneo abierto: las categorías no aplican. Los equipos se gestionan por edad mínima<?php echo e($tournament->min_age ? ' (' . $tournament->min_age . ' años)' : ''); ?>.</p>
            </div>
        <?php else: ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isNotEmpty()): ?>
                <div class="flex items-center gap-2 mb-4 overflow-x-auto pb-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative group shrink-0">
                            <button wire:click="selectCategory(<?php echo e($cat->id); ?>)"
                                    class="whitespace-nowrap pl-4 pr-3 py-2 rounded-xl text-sm font-semibold transition-all
                                        <?php echo e($activeCategoryId === $cat->id
                                            ? 'bg-primary text-white shadow-sm'
                                            : 'bg-white-pure text-titanium border border-silver hover:border-primary/30 hover:text-primary'); ?>">
                                <?php echo e($cat->name ?? $cat->category?->category ?? 'Categoría'); ?>

                                <span class="ml-1.5 text-xs opacity-60"><?php echo e($cat->tournament_teams_count); ?></span>
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeCategoryId === $cat->id): ?>
                                <div class="absolute -top-1.5 -right-1.5 hidden group-hover:flex items-center gap-0.5 z-10">
                                    <button wire:click.stop="openEditCategoryModal(<?php echo e($cat->id); ?>)"
                                            class="w-5 h-5 rounded-full bg-white border border-silver shadow text-titanium hover:text-primary flex items-center justify-center" title="Editar categoría">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click.stop="confirmDeleteCategory(<?php echo e($cat->id); ?>)"
                                            class="w-5 h-5 rounded-full bg-white border border-silver shadow text-titanium hover:text-red-500 flex items-center justify-center" title="Eliminar categoría">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <button wire:click="openCreateCategoryModal"
                            class="shrink-0 whitespace-nowrap px-3 py-2 rounded-xl text-sm font-semibold text-primary border border-dashed border-primary/40 hover:bg-primary/5 transition-colors">
                        + Nueva
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeCategoryId || $tournament->team_type === 'open'): ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teams->isEmpty() && $matches->isEmpty()): ?>
                
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                    <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-black-deep mb-2">Añade los equipos participantes</h2>
                    <p class="text-sm text-titanium mb-7 max-w-md mx-auto">El primer paso es añadir los equipos que van a competir. Puedes elegir equipos de la escuela o añadir equipos externos.</p>
                    <button wire:click="openCreateTeamModal"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold px-7 py-3 rounded-xl shadow transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Añadir Primer Equipo
                    </button>
                </div>

            <?php else: ?>
                
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm mb-5 p-1.5">
                    <nav class="flex gap-1 overflow-x-auto">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phases->isNotEmpty()): ?>
                            <button @click="tab = 'teams'"
                                    :class="tab === 'teams' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Equipos
                                <span :class="tab === 'teams' ? 'bg-white/20 text-white' : 'bg-gray-100 text-titanium'"
                                      class="px-2 py-0.5 rounded-full text-xs font-bold"><?php echo e($teams->count()); ?></span>
                            </button>
                            <button @click="tab = 'matches'"
                                    :class="tab === 'matches' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Partidos
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->isNotEmpty()): ?>
                                    <span :class="tab === 'matches' ? 'bg-white/20 text-white' : 'bg-gray-100 text-titanium'"
                                          class="px-2 py-0.5 rounded-full text-xs font-bold"><?php echo e($matches->count()); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($standings->isNotEmpty() || ($hasLeaguePhase && $teams->isNotEmpty())): ?>
                                <button @click="tab = 'standings'"
                                        :class="tab === 'standings' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Clasificación
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasKnockoutPhase): ?>
                                <button @click="tab = 'bracket'"
                                        :class="tab === 'bracket' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                                    Cuadro
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <button @click="tab = 'stats'"
                                    :class="tab === 'stats' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Estadísticas
                            </button>
                            <button @click="tab = 'referees'"
                                    :class="tab === 'referees' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Árbitros
                                <span :class="tab === 'referees' ? 'bg-white/20 text-white' : 'bg-gray-100 text-titanium'"
                                      class="px-2 py-0.5 rounded-full text-xs font-bold"><?php echo e($assignedReferees->count()); ?></span>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <button @click="tab = 'setup'"
                                :class="tab === 'setup' ? 'bg-primary text-white shadow-sm' : 'text-titanium hover:text-black-deep hover:bg-gray-100'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all ml-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Configurar
                        </button>
                    </nav>
                </div>

                
                <div x-show="tab === 'matches'" x-cloak>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->isEmpty()): ?>
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-black-deep mb-2">Aún no hay partidos</h3>
                            <p class="text-sm text-titanium mb-5">Genera los encuentros automáticamente o añade uno manualmente.</p>
                            <div class="flex items-center justify-center gap-3 flex-wrap">
                                <button wire:click="openGenerateMatchesModal"
                                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    Generar automáticamente
                                </button>
                                <button wire:click="openCreateMatchModal"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-titanium border border-silver px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Añadir manual
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm text-titanium">
                                <span class="font-bold text-black-deep"><?php echo e($matches->where('status', 'completed')->count()); ?></span>
                                de
                                <span class="font-bold text-black-deep"><?php echo e($matches->count()); ?></span>
                                partidos jugados
                            </p>
                            <div class="flex items-center gap-2">
                                <button wire:click="openGenerateMatchesModal"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    <span class="hidden sm:inline">Generar</span>
                                </button>
                                <button wire:click="openCreateMatchModal"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-primary border border-primary/30 px-4 py-2 rounded-xl hover:bg-primary/5 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span class="hidden sm:inline">Añadir manual</span>
                                </button>
                            </div>
                        </div>

                        
                        <div class="space-y-8">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $matches->sortBy([['phase_id', 'asc'], ['round', 'asc'], ['match_number', 'asc'], ['scheduled_at', 'asc']])->groupBy(fn($m) => $m->phase_id ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $phaseMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $phase     = $phaseMatches->first()?->phase;
                                    $phaseName = $phase?->name ?? 'Sin fase';
                                ?>
                               

                                
                                <div>
                                    <div class="flex items-center gap-3 mb-4 px-1">
                                        <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                        </div>
                                        <h3 class="text-base font-black text-black-deep uppercase tracking-wide"><?php echo e($phaseName); ?></h3>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phase): ?>
                                            <span class="text-xs font-semibold text-titanium bg-gray-100 border border-silver px-2.5 py-1 rounded-full"><?php echo e($phase->typeLabel()); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="flex-1 h-px bg-silver mx-1"></div>
                                        <span class="text-xs font-semibold text-titanium shrink-0">
                                            <?php echo e($phaseMatches->where('status', 'completed')->count()); ?>/<?php echo e($phaseMatches->count()); ?> jugados
                                        </span>
                                    </div>

                                    <div class="space-y-6">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseMatches->groupBy(fn($m) => $m->round ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round => $roundMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                                <?php
                                    $roundLabel     = $round > 0 ? 'Jornada ' . $round : 'Sin jornada';
                                    $completedCount = $roundMatches->where('status', 'completed')->count();
                                    $totalCount     = $roundMatches->count();
                                    $datesInRound   = $roundMatches->filter(fn($m) => $m->scheduled_at)->sortBy('scheduled_at');
                                    $firstDate      = $datesInRound->first()?->scheduled_at;
                                    $lastDate       = $datesInRound->last()?->scheduled_at;
                                    if ($firstDate && $lastDate) {
                                        $sameDay = $firstDate->isSameDay($lastDate);
                                        $roundSubLabel = $sameDay
                                            ? $firstDate->translatedFormat('d \d\e F Y')
                                            : $firstDate->translatedFormat('d M') . ' – ' . $lastDate->translatedFormat('d M Y');
                                    } else {
                                        $roundSubLabel = null;
                                    }
                                    $allCompleted = $completedCount === $totalCount;
                                ?>
                                <div>
                                    
                                    <div class="flex items-center gap-3 mb-3 px-1">
                                        <div class="w-10 h-10 rounded-xl shrink-0 flex items-center justify-center text-sm font-black
                                            <?php echo e($allCompleted ? 'bg-green-100 text-green-700' : 'bg-primary/10 text-primary'); ?>">
                                            <?php echo e($round > 0 ? $round : '—'); ?>

                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-black-deep leading-tight"><?php echo e($roundLabel); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($roundSubLabel): ?>
                                                <p class="text-xs text-titanium mt-0.5"><?php echo e($roundSubLabel); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="flex-1 h-px bg-silver mx-1"></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($allCompleted): ?>
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full shrink-0">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Completada
                                            </span>
                                        <?php else: ?>
                                            <span class="text-sm font-semibold text-titanium shrink-0"><?php echo e($completedCount); ?>/<?php echo e($totalCount); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    
                                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roundMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $matchGroup = $match->phase?->type === 'group'
                                                    ? ($match->homeTeam?->group_label ?? $match->awayTeam?->group_label)
                                                    : null;
                                            ?>
                                            
                                            <div class="px-5 py-4 border-b last:border-0 transition-colors
                                                <?php echo e($match->status === 'in_progress'
                                                    ? 'border-green-100 bg-green-50/40 hover:bg-green-50/70'
                                                    : 'border-gray-50 hover:bg-gray-50/60'); ?>">
                                                
                                                <div class="sm:hidden space-y-2.5">
                                                    
                                                    <div class="flex items-center justify-between gap-2">
                                                        <div class="flex items-center gap-1.5 min-w-0">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'in_progress'): ?>
                                                                <span class="inline-flex items-center gap-1.5 text-[11px] font-black text-white bg-red-500 px-2.5 py-1 rounded-full animate-pulse">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-white shrink-0"></span>
                                                                    EN VIVO
                                                                </span>
                                                            <?php elseif($match->scheduled_at): ?>
                                                                <span class="text-xs font-semibold text-titanium"><?php echo e($match->scheduled_at->translatedFormat('d M · H:i')); ?></span>
                                                            <?php else: ?>
                                                                <span class="text-xs text-titanium/40">Sin fecha</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matchGroup): ?>
                                                                <span class="inline-flex items-center gap-1 text-[10px] font-black text-primary bg-primary/10 border border-primary/20 px-2 py-0.5 rounded-full shrink-0">
                                                                    Grupo <?php echo e($matchGroup); ?>

                                                                </span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->location): ?>
                                                                <span class="text-[11px] text-titanium truncate max-w-[140px]">
                                                                    <svg class="w-3 h-3 inline-block mr-0.5 -mt-px text-titanium/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                                    <?php echo e($match->location); ?>

                                                                </span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                                                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full shrink-0">
                                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                                    Jugado
                                                                </span>
                                                            <?php elseif($match->status === 'cancelled'): ?>
                                                                <span class="text-[10px] font-semibold text-red-500 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full shrink-0">Cancelado</span>
                                                            <?php elseif($match->status === 'postponed'): ?>
                                                                <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-full shrink-0">Aplazado</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="flex items-center gap-2">
                                                        <p class="flex-1 text-right text-sm font-bold text-black-deep leading-tight truncate"><?php echo e($match->homeTeam?->displayName() ?? '—'); ?></p>
                                                        <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)"
                                                                class="shrink-0 w-[72px] py-2 rounded-xl text-center font-black text-base transition-all
                                                                    <?php echo e($match->status === 'completed'
                                                                        ? 'bg-gray-50 border border-silver text-black-deep'
                                                                        : ($match->status === 'in_progress'
                                                                            ? 'bg-green-500 border border-green-600 text-white shadow-sm shadow-green-200'
                                                                            : 'bg-amber-50 border-2 border-dashed border-amber-300 text-amber-600')); ?>">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                                                                <?php echo e($match->home_score); ?> – <?php echo e($match->away_score); ?>

                                                            <?php elseif($match->status === 'in_progress'): ?>
                                                                <?php echo e($match->home_score ?? 0); ?> – <?php echo e($match->away_score ?? 0); ?>

                                                            <?php elseif($match->status === 'cancelled'): ?>
                                                                <span class="text-xs font-bold text-red-400">CANC.</span>
                                                            <?php elseif($match->status === 'postponed'): ?>
                                                                <span class="text-xs font-bold text-gray-400">APL.</span>
                                                            <?php else: ?>
                                                                <span class="text-xs font-bold">⚽ Goles</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </button>
                                                        <p class="flex-1 text-left text-sm font-bold text-black-deep leading-tight truncate"><?php echo e($match->awayTeam?->displayName() ?? '—'); ?></p>
                                                    </div>
                                                     <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->notes): ?>
                                                        <p class="text-xs font-bold text-gray-400"><?php echo e($match->notes); ?></p>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    
                                                    
                                                    <a wire:click="openEditMatchModal(<?php echo e($match->id); ?>)" wire:navigate
                                                       class="flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 active:bg-indigo-100 transition-colors">
                                                       <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> 
                                                       
                                                        Editas Partido
                                                    </a>
                                                </div>

                                                
                                                <div class="hidden sm:flex sm:items-center gap-3">
                                                    
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'in_progress'): ?>
                                                        <div class="flex flex-col items-center justify-center shrink-0 w-16 h-14 bg-red-500 rounded-xl border border-red-600 text-center shadow-sm shadow-red-200 animate-pulse">
                                                            <span class="flex items-center gap-1">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                                                <span class="text-[10px] font-black text-white tracking-wider">EN VIVO</span>
                                                            </span>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->scheduled_at): ?>
                                                                <span class="text-[10px] text-red-100 mt-0.5"><?php echo e($match->scheduled_at->format('H:i')); ?></span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="flex flex-col items-center justify-center shrink-0 w-16 h-14 bg-gray-50 rounded-xl border border-silver/60 text-center">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->scheduled_at): ?>
                                                                <span class="text-xs font-bold text-black-deep"><?php echo e($match->scheduled_at->format('d/m')); ?></span>
                                                                <span class="text-xs text-titanium"><?php echo e($match->scheduled_at->format('H:i')); ?></span>
                                                            <?php else: ?>
                                                                <span class="text-xs text-titanium/40 font-semibold">—</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <div class="flex-1 flex items-center justify-end gap-2 min-w-0">
                                                            <p class="text-sm font-bold text-black-deep truncate"><?php echo e($match->homeTeam?->displayName() ?? '—'); ?></p>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam?->logo): ?>
                                                                <img src="<?php echo e(asset('storage/' . $match->homeTeam->logo)); ?>" alt="<?php echo e($match->homeTeam->displayName()); ?>" class="w-8 h-8 rounded-lg object-contain shrink-0">
                                                            <?php elseif($match->homeTeam?->team?->logo): ?>
                                                                <img src="<?php echo e(Storage::url($match->homeTeam->team->logo)); ?>" alt="<?php echo e($match->homeTeam->displayName()); ?>" class="w-8 h-8 rounded-lg object-contain shrink-0">
                                                            <?php elseif($match->homeTeam): ?>
                                                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                                                    <span class="text-xs font-black text-primary"><?php echo e(mb_strtoupper(mb_substr($match->homeTeam->displayName(), 0, 1))); ?></span>
                                                                </div>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                        <div class="flex flex-col items-center gap-2">

                                                                <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)"
                                                                    class="shrink-0 min-w-[76px] px-3 py-2.5 rounded-xl text-center transition-all font-black text-base
                                                                        <?php echo e($match->status === 'completed'
                                                                            ? 'bg-gray-50 border border-silver text-black-deep hover:bg-amber-50 hover:border-amber-200'
                                                                            : ($match->status === 'in_progress'
                                                                                ? 'bg-green-500 border border-green-600 text-white shadow-sm shadow-green-200 hover:bg-green-600'
                                                                                : 'bg-amber-50 border-2 border-dashed border-amber-300 text-amber-600 hover:bg-amber-100 hover:border-amber-400')); ?>"
                                                                    title="Registrar goles / ver resultado">

                                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                                                                            <?php echo e($match->home_score); ?> – <?php echo e($match->away_score); ?>

                                                                        <?php elseif($match->status === 'in_progress'): ?>
                                                                            <?php echo e($match->home_score ?? 0); ?> – <?php echo e($match->away_score ?? 0); ?>

                                                                        <?php elseif($match->status === 'cancelled'): ?>
                                                                            <span class="text-xs font-bold text-red-400">CANC.</span>
                                                                        <?php elseif($match->status === 'postponed'): ?>
                                                                            <span class="text-xs font-bold text-gray-400">APL.</span>
                                                                        <?php else: ?>
                                                                            <span class="text-xs font-bold">⚽ Goles</span>
                                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                </button>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->notes): ?>
                                                                <p class="text-xs font-bold text-gray-400"><?php echo e($match->notes); ?></p>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                        <div class="flex-1 flex items-center gap-2 min-w-0">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam?->logo): ?>
                                                                <img src="<?php echo e(asset('storage/' . $match->awayTeam->logo)); ?>" alt="<?php echo e($match->awayTeam->displayName()); ?>" class="w-8 h-8 rounded-lg object-contain shrink-0">
                                                            <?php elseif($match->awayTeam?->team?->logo): ?>
                                                                <img src="<?php echo e(Storage::url($match->awayTeam->team->logo)); ?>" alt="<?php echo e($match->awayTeam->displayName()); ?>" class="w-8 h-8 rounded-lg object-contain shrink-0">
                                                            <?php elseif($match->awayTeam): ?>
                                                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                                                    <span class="text-xs font-black text-primary"><?php echo e(mb_strtoupper(mb_substr($match->awayTeam->displayName(), 0, 1))); ?></span>
                                                                </div>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <p class="text-sm font-bold text-black-deep truncate"><?php echo e($match->awayTeam?->displayName() ?? '—'); ?></p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="flex items-center gap-2 shrink-0">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matchGroup): ?>
                                                            <span class="inline-flex items-center gap-1 text-xs font-black text-primary bg-primary/10 border border-primary/20 px-2.5 py-1 rounded-full shrink-0">
                                                                Grupo <?php echo e($matchGroup); ?>

                                                            </span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full shrink-0">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                                Jugado
                                                            </span>
                                                        <?php elseif($match->status === 'in_progress'): ?>
                                                            <span class="inline-flex items-center gap-1.5 text-xs font-black text-white bg-red-500 border border-red-600 px-2.5 py-1 rounded-full animate-pulse shrink-0 shadow-sm shadow-red-200">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-white shrink-0"></span>
                                                                EN VIVO
                                                            </span>
                                                        <?php elseif($match->status === 'cancelled'): ?>
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full shrink-0">Cancelado</span>
                                                        <?php elseif($match->status === 'postponed'): ?>
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full shrink-0">Aplazado</span>
                                                        <?php else: ?>
                                                            <span class="hidden md:inline-flex items-center gap-1 text-xs font-semibold text-titanium bg-gray-50 border border-silver px-2.5 py-1 rounded-full shrink-0">Programado</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <a href="<?php echo e(route('tournament.match.events', [$tournament, $match])); ?>" wire:navigate
                                                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition-colors"
                                                           title="Tarjetas y sanciones">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                            <span class="hidden lg:inline">Eventos</span>
                                                        </a>
                                                        <button wire:click="openEditMatchModal(<?php echo e($match->id); ?>)"
                                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold bg-primary/5 text-primary border border-primary/20 hover:bg-primary/10 transition-colors"
                                                                title="Editar fecha, lugar, estado">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                            <span class="hidden lg:inline">Editar</span>
                                                        </button>
                                                        <button wire:click="confirmDeleteMatch(<?php echo e($match->id); ?>)"
                                                                class="p-2 rounded-xl text-titanium/40 hover:text-red-500 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                                                                title="Eliminar partido">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($round > 0 && $teams->isNotEmpty()): ?>
                                            <?php
                                                $busyIds      = $roundMatches->flatMap(fn($m) => [$m->home_team_id, $m->away_team_id])->unique();
                                                $restingTeams = $teams->whereNotIn('id', $busyIds);
                                            ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $restingTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $restingTeam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phase?->type === 'league'): ?>
                                                    
                                                    <div class="px-5 py-4 border-t-2 border-dashed border-amber-200 bg-amber-50/60 flex items-center gap-4">
                                                        <div class="w-9 h-9 rounded-xl bg-amber-100 border border-amber-200 flex items-center justify-center shrink-0">
                                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm font-bold text-amber-900"><?php echo e($restingTeam->displayName()); ?></span>
                                                        <span class="text-[11px] font-black uppercase tracking-wider text-amber-700 bg-amber-100 border border-amber-200 px-3 py-1 rounded-full">Descansa esta jornada</span>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <?php
                    $leagueSubsetSettings = $leagueSubsetSettings ?? [];
                    $subsetLeaguePhases   = $phases->filter(fn($p) => $p->type === 'league' && isset($leagueSubsetSettings[$p->id]));
                    $hasSubsetLeague      = $subsetLeaguePhases->isNotEmpty();
                ?>
                <?php if($standings->isNotEmpty() || ($hasLeaguePhase && $teams->isNotEmpty()) || $hasSubsetLeague): ?>
                    <div x-show="tab === 'standings'" x-cloak>
                        <div class="flex items-center justify-end mb-4">
                            <button wire:click="recalculateStandings"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-titanium border border-silver px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Recalcular
                            </button>
                        </div>
                        <?php if($standings->isNotEmpty()): ?>
                            <div class="space-y-5">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $standings->groupBy(fn($s) => $s->phase?->name ?? 'General'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseName => $phaseStandings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseStandings->groupBy('group_label'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $groupStandings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $__firstStanding   = $groupStandings->first();
                                            $__phaseId         = $__firstStanding?->phase_id;
                                            $__phaseIsSubset   = $__phaseId && isset($leagueSubsetSettings[$__phaseId]);
                                            $__subsetTotal     = $__phaseIsSubset ? $leagueSubsetSettings[$__phaseId] : null;
                                            $__placeholderRows = $__phaseIsSubset
                                                ? max(0, $__subsetTotal - $groupStandings->count())
                                                : 0;
                                            $__realCount       = $groupStandings->count();
                                        ?>
                                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                            <div class="bg-gray-50 border-b border-silver px-5 py-3">
                                                <h3 class="text-sm font-bold text-black-deep">
                                                    <?php echo e($phaseName); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($groupLabel): ?> <span class="text-titanium font-normal ml-1">· Grupo <?php echo e($groupLabel); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($__phaseIsSubset): ?>
                                                        <span class="ml-2 text-[11px] font-black uppercase tracking-wider text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-full align-middle">
                                                            <?php echo e($__realCount); ?>/<?php echo e($__subsetTotal); ?> equipos
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </h3>
                                            </div>
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm">
                                                    <thead>
                                                        <tr class="border-b border-silver">
                                                            <th class="text-left text-xs font-semibold text-titanium px-5 py-3 w-10">#</th>
                                                            <th class="text-left text-xs font-semibold text-titanium px-4 py-3">Equipo</th>
                                                            <th class="text-center text-xs font-bold text-primary px-5 py-3 w-16">Pts</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">PJ</th>
                                                            <th class="text-center text-xs font-semibold text-green-700 px-3 py-3 w-12">G</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">E</th>
                                                            <th class="text-center text-xs font-semibold text-red-600 px-3 py-3 w-12">P</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GF</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GC</th>
                                                            <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">DG</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-50">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupStandings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $standing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="<?php echo e($loop->first ? 'bg-primary/5' : ''); ?> hover:bg-gray-50 transition-colors">
                                                                <td class="px-5 py-4">
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->first): ?>
                                                                        <span class="w-6 h-6 rounded-full bg-primary text-white text-xs font-black flex items-center justify-center">1</span>
                                                                    <?php elseif($loop->index === 1): ?>
                                                                        <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-700 text-xs font-black flex items-center justify-center">2</span>
                                                                    <?php elseif($loop->index === 2): ?>
                                                                        <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 text-xs font-black flex items-center justify-center">3</span>
                                                                    <?php else: ?>
                                                                        <span class="text-xs text-titanium font-semibold pl-1"><?php echo e($standing->position); ?></span>
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                </td>
                                                                <td class="px-4 py-4 font-semibold text-black-deep"><div class="flex items-center gap-2"><img src="<?php echo e(asset('storage/' . $standing->tournamentTeam?->logo)); ?>" alt="<?php echo e($standing->tournamentTeam?->displayName()); ?>" class="w-8 h-8  object-contain shrink-0"> <?php echo e($standing->tournamentTeam?->displayName() ?? '—'); ?></div></td>
                                                                <td class="px-5 py-4 text-center"><span class="text-xl font-black text-primary"><?php echo e($standing->points); ?></span></td>
                                                                <td class="px-3 py-4 text-center text-titanium"><?php echo e($standing->played); ?></td>
                                                                <td class="px-3 py-4 text-center font-semibold text-green-700"><?php echo e($standing->won); ?></td>
                                                                <td class="px-3 py-4 text-center text-titanium"><?php echo e($standing->drawn); ?></td>
                                                                <td class="px-3 py-4 text-center font-semibold text-red-600"><?php echo e($standing->lost); ?></td>
                                                                <td class="px-3 py-4 text-center text-titanium"><?php echo e($standing->goals_for); ?></td>
                                                                <td class="px-3 py-4 text-center text-titanium"><?php echo e($standing->goals_against); ?></td>
                                                                <td class="px-3 py-4 text-center text-titanium"><?php echo e(($standing->goals_for - $standing->goals_against) >= 0 ? '+' : ''); ?><?php echo e($standing->goals_for - $standing->goals_against); ?></td>
                                                                
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($__i = 1; $__i <= $__placeholderRows; $__i++): ?>
                                                            <tr class="bg-indigo-50/30 hover:bg-indigo-50/50 transition-colors">
                                                                <td class="px-5 py-4">
                                                                    <span class="text-xs text-titanium font-semibold pl-1"><?php echo e($__realCount + $__i); ?></span>
                                                                </td>
                                                                <td class="px-4 py-4 font-semibold">
                                                                    <div class="flex items-center gap-2">
                                                                        <span class="w-8 h-8 rounded-lg border border-dashed border-indigo-300 bg-white flex items-center justify-center shrink-0">
                                                                            <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                                        </span>
                                                                        <span class="text-indigo-500 italic">Equipo <?php echo e($__realCount + $__i); ?> · por definir</span>
                                                                    </div>
                                                                </td>
                                                                <td class="px-5 py-4 text-center"><span class="text-xl font-black text-titanium/40">0</span></td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                                <td class="px-3 py-4 text-center text-titanium/40">0</td>
                                                            </tr>
                                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subsetLeaguePhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $__subsetPhase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($standings->where('phase_id', $__subsetPhase->id)->isEmpty()): ?>
                                        <?php echo $__env->make('livewire.tournaments._subset-placeholder-block', [
                                            'phase'     => $__subsetPhase,
                                            'slotCount' => $leagueSubsetSettings[$__subsetPhase->id],
                                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php elseif($hasSubsetLeague): ?>
                            
                            <div class="space-y-5">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $subsetLeaguePhases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $__subsetPhase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('livewire.tournaments._subset-placeholder-block', [
                                        'phase'     => $__subsetPhase,
                                        'slotCount' => $leagueSubsetSettings[$__subsetPhase->id],
                                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php elseif($hasLeaguePhase && $teams->isNotEmpty()): ?>
                            
                            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                <div class="bg-gray-50 border-b border-silver px-5 py-3 flex items-center gap-2">
                                    <h3 class="text-sm font-bold text-black-deep">Clasificación</h3>
                                    <span class="text-xs text-titanium bg-gray-100 px-2 py-0.5 rounded-full">Sin partidos jugados aún</span>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-silver">
                                                <th class="text-left text-xs font-semibold text-titanium px-5 py-3 w-10">#</th>
                                                <th class="text-left text-xs font-semibold text-titanium px-4 py-3">Equipo</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">PJ</th>
                                                <th class="text-center text-xs font-semibold text-green-700 px-3 py-3 w-12">G</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">E</th>
                                                <th class="text-center text-xs font-semibold text-red-600 px-3 py-3 w-12">P</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GF</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GC</th>
                                                <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">DG</th>
                                                <th class="text-center text-xs font-bold text-primary px-5 py-3 w-16">Pts</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams->sortBy(fn($t) => $t->displayName())->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-5 py-4">
                                                        <span class="text-xs text-titanium font-semibold pl-1"><?php echo e($loop->iteration); ?></span>
                                                    </td>
                                                    <td class="px-4 py-4 font-semibold text-black-deep"><?php echo e($team->displayName()); ?></td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-3 py-4 text-center text-titanium">0</td>
                                                    <td class="px-5 py-4 text-center"><span class="text-xl font-black text-primary">0</span></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasKnockoutPhase): ?>
                    <div x-show="tab === 'bracket'" x-cloak>
                        <?php
                            $getRoundLabel = function(int $roundIndex, int $totalRounds): string {
                                $fromFinal = $totalRounds - 1 - $roundIndex;
                                return match($fromFinal) {
                                    0 => 'Final',
                                    1 => 'Semifinal',
                                    2 => 'Cuartos de Final',
                                    3 => 'Octavos de Final',
                                    4 => '16avos de Final',
                                    default => 'Ronda ' . ($roundIndex + 1),
                                };
                            };
                            $matchH = 108;
                            $matchW = 232;
                            $gapX   = 24;
                            $unit   = $matchH + 32;
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracketData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $bracket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-5 mb-5">
                                
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-black-deep"><?php echo e($bracket['phase']->name); ?></h3>
                                            <p class="text-xs text-titanium"><?php echo e($bracket['phase']->typeLabel()); ?> · <?php echo e($bracket['phase']->statusLabel()); ?></p>
                                        </div>
                                    </div>
                                    <button wire:click="openBracketModal(<?php echo e($phaseId); ?>)"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-primary bg-primary/5 border border-primary/20 hover:bg-primary/10 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Configurar cuadro
                                    </button>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$bracket['hasMatches']): ?>
                                    <div class="flex flex-col items-center justify-center py-14 border-2 border-dashed border-silver rounded-2xl">
                                        <svg class="w-12 h-12 text-titanium/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <p class="text-sm font-semibold text-titanium mb-1">Sin cuadro generado</p>
                                        <p class="text-xs text-titanium/60 mb-4 text-center max-w-xs">Selecciona los equipos clasificados para generar el cuadro de eliminatorias.</p>
                                        <button wire:click="openBracketModal(<?php echo e($phaseId); ?>)"
                                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Generar cuadro
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <?php
                                        $numFirstRound = $bracket['numFirstRoundMatches'];
                                        $totalRounds   = $bracket['totalRounds'];
                                        $firstRound    = $bracket['firstRound'];
                                        $maxRound      = $bracket['maxRound'];
                                        $containerH    = max($numFirstRound, 1) * $unit;
                                        // Teams already used in the first round (to filter dropdowns)
                                        $firstRoundUsedTeams = collect($bracket['rounds'][$firstRound] ?? [])
                                            ->flatMap(fn($m) => [$m->home_team_id, $m->away_team_id])
                                            ->filter()->unique();
                                    ?>
                                    <div class="overflow-x-auto pb-2">
                                        <div class="flex min-w-max" style="align-items: flex-start;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracket['rounds']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roundNum => $roundMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $roundIndex = $roundNum - $firstRound;
                                                    $roundLabel = $getRoundLabel($roundIndex, $totalRounds);
                                                    $isLast     = ($roundNum === $maxRound);
                                                ?>

                                                
                                                <div style="width: <?php echo e($matchW); ?>px; flex-shrink: 0;">
                                                    <div class="text-center mb-2">
                                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                                            <?php echo e($isLast ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-gray-100 text-gray-600 border border-gray-200'); ?>">
                                                            <?php echo e($roundLabel); ?>

                                                        </span>
                                                    </div>

                                                    <div class="relative" style="height: <?php echo e($containerH); ?>px;">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roundMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matchIdx => $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $slotMult = (int) pow(2, $roundIndex);
                                                                $centerY  = (int)(($matchIdx + 0.5) * $unit * $slotMult);
                                                                $topPx    = $centerY - (int)($matchH / 2);
                                                                $mWinner  = $match->status === 'completed' ? $match->winner() : null;
                                                                $homeWins = $mWinner && $mWinner->id === $match->home_team_id;
                                                                $awayWins = $mWinner && $mWinner->id === $match->away_team_id;
                                                            ?>
                                                            <div class="absolute left-0 right-0 group z-10 hover:z-20 transition-all" style="top: <?php echo e($topPx); ?>px;">
    
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-gray-300 transition-all flex flex-col relative overflow-hidden" style="height: <?php echo e($matchH); ?>px;">
        <div class="h-7 shrink-0 flex items-center justify-between gap-2 px-2.5 bg-gray-50 border-b border-gray-100">
            <div class="min-w-0 flex items-center gap-1.5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($match->notes)): ?>
                    <svg class="w-3.5 h-3.5 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-[10px] leading-3 font-medium text-amber-800 line-clamp-2" title="<?php echo e($match->notes); ?>"><?php echo e($match->notes); ?></span>
                <?php else: ?>
                    <span class="text-[9px] font-semibold uppercase tracking-wide text-gray-400"><?php echo e($match->statusLabel()); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <a wire:click="openEditMatchModal(<?php echo e($match->id); ?>)" wire:navigate
                title="Editar partido"
                class="shrink-0 flex items-center justify-center w-5 h-5 rounded-md text-gray-400 hover:text-primary hover:bg-white transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
        </div>
        
        
        <div class="flex-1 min-h-0 flex items-center justify-between pr-2.5 relative border-l-[3px] <?php echo e($homeWins ? 'bg-emerald-50/60 border-emerald-500' : 'border-transparent hover:bg-gray-50'); ?> transition-colors group/home">
            
            <div class="flex items-center gap-2 flex-1 min-w-0 pl-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam): ?>
                    <!-- Logo -->
                    <div class="w-5 h-5 rounded-md shrink-0 flex items-center justify-center bg-white border border-gray-100 overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam->logo): ?>
                            <img src="<?php echo e(asset('storage/'.$match->homeTeam->logo)); ?>" class="w-full h-full object-contain" alt="">
                        <?php elseif($match->homeTeam->team?->logo): ?>
                            <img src="<?php echo e(Storage::url($match->homeTeam->team->logo)); ?>" class="w-full h-full object-contain" alt="">
                        <?php else: ?>
                            <span class="text-[8px] font-black text-gray-400"><?php echo e(mb_strtoupper(mb_substr($match->homeTeam->displayName(), 0, 1))); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <!-- Nombre -->
                    <span class="text-xs leading-tight truncate <?php echo e($homeWins ? 'font-bold text-gray-900' : 'font-medium text-gray-700'); ?>">
                        <?php echo e($match->homeTeam->displayName()); ?>

                    </span>
                <?php else: ?>
                    <!-- Select cuando no hay equipo -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($roundNum === $firstRound): ?>
                        <select @change="$wire.assignTeamToSlot(<?php echo e($match->id); ?>, 'home', $event.target.value || null)"
                            class="w-full text-[11px] text-gray-500 font-medium italic bg-transparent border-0 p-0 focus:ring-0 cursor-pointer appearance-none truncate">
                            <option value="">Por definir…</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $takenElsewhere = $firstRoundUsedTeams->reject(fn($id) => $id === ($match->home_team_id ?? 0))->contains($t->id);
                                    $isOpponent     = $t->id === ($match->away_team_id ?? 0);
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$takenElsewhere && !$isOpponent): ?>
                                    <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    <?php else: ?>
                        <span class="text-[11px] text-gray-400 italic truncate">Por definir</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Score y Acciones Derecha -->
            <div class="flex items-center gap-1.5 shrink-0 pl-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                        <span class="text-[11px] font-black <?php echo e($homeWins ? 'text-emerald-600' : 'text-gray-400'); ?>"><?php echo e($match->home_score ?? 0); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($homeWins): ?>
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'scheduled' && $roundNum === $firstRound): ?>
                        <button @click="$wire.assignTeamToSlot(<?php echo e($match->id); ?>, 'home', null)"
                            class="w-3.5 h-3.5 rounded-full bg-gray-100 hover:bg-red-100 hover:text-red-500 text-gray-400 text-[9px] font-black flex items-center justify-center transition-colors opacity-0 group-hover/home:opacity-100" title="Quitar equipo">×</button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Divisor Central -->
        <div class="h-px bg-gray-100 w-full"></div>

        
        <div class="flex-1 min-h-0 flex items-center justify-between pr-2.5 relative border-l-[3px] <?php echo e($awayWins ? 'bg-emerald-50/60 border-emerald-500' : 'border-transparent hover:bg-gray-50'); ?> transition-colors group/away">
            
            <div class="flex items-center gap-2 flex-1 min-w-0 pl-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam): ?>
                    <!-- Logo -->
                    <div class="w-5 h-5 rounded-md shrink-0 flex items-center justify-center bg-white border border-gray-100 overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam->logo): ?>
                            <img src="<?php echo e(asset('storage/'.$match->awayTeam->logo)); ?>" class="w-full h-full object-contain" alt="">
                        <?php elseif($match->awayTeam->team?->logo): ?>
                            <img src="<?php echo e(Storage::url($match->awayTeam->team->logo)); ?>" class="w-full h-full object-contain" alt="">
                        <?php else: ?>
                            <span class="text-[8px] font-black text-gray-400"><?php echo e(mb_strtoupper(mb_substr($match->awayTeam->displayName(), 0, 1))); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <!-- Nombre -->
                    <span class="text-xs leading-tight truncate <?php echo e($awayWins ? 'font-bold text-gray-900' : 'font-medium text-gray-700'); ?>">
                        <?php echo e($match->awayTeam->displayName()); ?>

                    </span>
                <?php else: ?>
                    <!-- Select cuando no hay equipo -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($roundNum === $firstRound): ?>
                        <select @change="$wire.assignTeamToSlot(<?php echo e($match->id); ?>, 'away', $event.target.value || null)"
                            class="w-full text-[11px] text-gray-500 font-medium italic bg-transparent border-0 p-0 focus:ring-0 cursor-pointer appearance-none truncate">
                            <option value="">Por definir…</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $takenElsewhere = $firstRoundUsedTeams->reject(fn($id) => $id === ($match->away_team_id ?? 0))->contains($t->id);
                                    $isOpponent     = $t->id === ($match->home_team_id ?? 0);
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$takenElsewhere && !$isOpponent): ?>
                                    <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    <?php else: ?>
                        <span class="text-[11px] text-gray-400 italic truncate">Por definir</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Score y Acciones Derecha -->
            <div class="flex items-center gap-1.5 shrink-0 pl-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                        <span class="text-[11px] font-black <?php echo e($awayWins ? 'text-emerald-600' : 'text-gray-400'); ?>"><?php echo e($match->away_score ?? 0); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($awayWins): ?>
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'scheduled' && $roundNum === $firstRound): ?>
                        <button @click="$wire.assignTeamToSlot(<?php echo e($match->id); ?>, 'away', null)"
                            class="w-3.5 h-3.5 rounded-full bg-gray-100 hover:bg-red-100 hover:text-red-500 text-gray-400 text-[9px] font-black flex items-center justify-center transition-colors opacity-0 group-hover/away:opacity-100" title="Quitar equipo">×</button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>

                                                
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isLast): ?>
                                                    <?php
                                                        $nextRoundMatches = $bracket['rounds'][$roundNum + 1] ?? collect();
                                                        $nextCount = $nextRoundMatches->count();
                                                    ?>
                                                    <div style="width: <?php echo e($gapX); ?>px; flex-shrink: 0; position: relative; height: <?php echo e($containerH + 32); ?>px; margin-top: 32px;">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($ci = 0; $ci < $nextCount; $ci++): ?>
                                                            <?php
                                                                $slotMult   = (int) pow(2, $roundIndex);
                                                                $topCenter  = (int)(($ci * 2 + 0.5) * $unit * $slotMult);
                                                                $botCenter  = (int)(($ci * 2 + 1.5) * $unit * $slotMult);
                                                                $midCenter  = (int)(($ci + 0.5) * $unit * (int)pow(2, $roundIndex + 1));
                                                            ?>
                                                            <div style="
                                                                position: absolute;
                                                                left: 0;
                                                                top: <?php echo e($topCenter); ?>px;
                                                                width: 50%;
                                                                height: <?php echo e(max($botCenter - $topCenter, 2)); ?>px;
                                                                border-right: 2px solid #d1d5db;
                                                                border-top: 2px solid #d1d5db;
                                                                border-bottom: 2px solid #d1d5db;
                                                                border-radius: 0 5px 5px 0;
                                                            "></div>
                                                            <div style="
                                                                position: absolute;
                                                                left: 50%;
                                                                top: <?php echo e($midCenter); ?>px;
                                                                width: 50%;
                                                                height: 2px;
                                                                background: #d1d5db;
                                                            "></div>
                                                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bracket['thirdPlace']): ?>
                                        <?php $tp = $bracket['thirdPlace']; ?>
                                        <div class="mt-6 pt-6 border-t border-dashed border-gray-300">
    
                                            <!-- Cabecera: Título y Botón de Editar separados -->
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-center gap-2.5">
                                                    <!-- Insignia 3er Puesto -->
                                                    <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-black shadow-sm border border-amber-200">
                                                        3
                                                    </span>
                                                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider">
                                                        Partido por el 3er Puesto <span class="text-gray-400 font-normal ml-1">#666</span>
                                                    </h4>
                                                </div>
                                                
                                                <!-- Botón Editar (Arreglado: ya no ocupa todo el ancho) -->
                                                <button wire:click="openEditMatchModal(<?php echo e($tp->id); ?>)" wire:navigate
                                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white text-indigo-600 border border-indigo-200 hover:bg-indigo-50 hover:border-indigo-300 active:bg-indigo-100 transition-all shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Editar
                                                </button>
                                            </div>

                                            <!-- Tarjeta del Partido -->
                                            <div class="flex items-center gap-4 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/60 rounded-2xl px-4 md:px-6 py-4 shadow-sm hover:shadow-md transition-shadow">
                                                
                                                <!-- Equipo Local -->
                                                <div class="flex-1 flex justify-end">
                                                    <span class="text-sm md:text-base font-bold text-gray-900 text-right truncate" title="<?php echo e($tp->homeTeam?->displayName() ?? 'Por definir'); ?>">
                                                        <?php echo e($tp->homeTeam?->displayName() ?? 'Por definir'); ?>

                                                    </span>
                                                </div>

                                                <!-- Marcador / VS Central -->
                                                <div class="shrink-0 flex flex-col items-center justify-center">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tp->status === 'completed'): ?>
                                                        <div class="px-4 py-2 bg-white rounded-xl border border-amber-200 shadow-sm min-w-[70px] md:min-w-[80px] text-center">
                                                            <span class="text-lg md:text-xl font-black text-gray-900 tracking-wider">
                                                                <?php echo e($tp->home_score); ?> <span class="text-gray-300 mx-0.5">-</span> <?php echo e($tp->away_score); ?>

                                                            </span>
                                                        </div>
                                                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mt-1.5">Final</span>
                                                    <?php else: ?>
                                                        
                                                            <span class="text-sm font-black text-amber-500 group-hover:text-amber-700 uppercase tracking-widest">VS</span>
                                                        
                                                        <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mt-1.5">Pendiente</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                                <!-- Equipo Visitante -->
                                                <div class="flex-1 flex justify-start">
                                                    <span class="text-sm md:text-base font-bold text-gray-900 text-left truncate" title="<?php echo e($tp->awayTeam?->displayName() ?? 'Por definir'); ?>">
                                                        <?php echo e($tp->awayTeam?->displayName() ?? 'Por definir'); ?>

                                                    </span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div x-show="tab === 'teams'" x-cloak>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-titanium">
                            <span class="font-bold text-black-deep"><?php echo e($teams->count()); ?></span> equipos inscritos
                        </p>
                        <button wire:click="openCreateTeamModal"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Añadir equipo
                        </button>
                    </div>

                    <?php
                        $hasGroups = $teams->contains(fn($t) => filled($t->group_label));
                        $teamGroups = $hasGroups
                            ? $teams->sortBy([['group_label','asc'],['seed','asc'],['name_override','asc']])->groupBy(fn($t) => $t->group_label ?: '')
                            : collect(['' => $teams->sortBy([['seed','asc'],['name_override','asc']])]);
                    ?>

                    <div class="space-y-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupTeams): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasGroups): ?>
                                    <div class="bg-gray-50 border-b border-silver px-5 py-3 flex items-center gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($groupKey !== ''): ?>
                                            <span class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-black text-primary shrink-0"><?php echo e($groupKey); ?></span>
                                            <h3 class="text-sm font-bold text-black-deep">Grupo <?php echo e($groupKey); ?></h3>
                                        <?php else: ?>
                                            <h3 class="text-sm font-bold text-black-deep">Sin grupo</h3>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="text-xs text-titanium bg-gray-100 px-2 py-0.5 rounded-full ml-1"><?php echo e($groupTeams->count()); ?> equipos</span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-silver bg-gray-50/60">
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3 "></th>
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3">Equipo</th>
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden md:table-cell">Contacto</th>
                                                <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden sm:table-cell">Teléfono</th>
                                                <th class="text-center text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3">Jugadores</th>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasGroups): ?>
                                                    <th class="text-center text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden lg:table-cell">Grupo</th>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <th class="text-right text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50/60 transition-colors">
                                                    
                                                    <td class="px-5 py-3">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->logo): ?>
                                                            <img src="<?php echo e(asset('storage/' . $team->logo)); ?>"
                                                                 class="w-9 h-9 rounded-lg object-contain   shrink-0" alt="">
                                                        <?php elseif($team->team?->logo): ?>
                                                            <img src="<?php echo e(Storage::url($team->team->logo)); ?>"
                                                                 class="w-9 h-9 rounded-lg object-contain   shrink-0" alt="">
                                                        <?php else: ?>
                                                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                                                <span class="text-sm font-black text-primary"><?php echo e(mb_strtoupper(mb_substr($team->displayName(), 0, 1))); ?></span>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="font-semibold text-black-deep"><?php echo e($team->displayName()); ?></span>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->seed): ?>
                                                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-full">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                                                    Cabeza <?php echo e($team->seed); ?>

                                                                </span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->external_team): ?>
                                                                <span class="text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">Externo</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="px-4 py-3 hidden md:table-cell text-titanium">
                                                        <?php echo e($team->contact_name ?: '—'); ?>

                                                    </td>
                                                    
                                                    <td class="px-4 py-3 hidden sm:table-cell text-titanium">
                                                        <?php echo e($team->contact_phone ?: '—'); ?>

                                                    </td>
                                                    
                                                    <td class="px-4 py-3">
                                                        <?php
                                                            $totalPlayers    = $team->players()->count();
                                                            $approvedPlayers = $team->players()->where('status', 'approved')->count();
                                                            $pct             = $totalPlayers > 0 ? round($approvedPlayers / $totalPlayers * 100) : 0;
                                                            $barColor        = $pct === 100 ? 'bg-green-500' : ($pct >= 50 ? 'bg-indigo-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-gray-200'));
                                                        ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalPlayers > 0): ?>
                                                            <div class="flex flex-col gap-1 min-w-[80px]">
                                                                <div class="flex items-center justify-between gap-2">
                                                                    <span class="text-xs font-bold <?php echo e($pct === 100 ? 'text-green-700' : 'text-indigo-700'); ?>">
                                                                        <?php echo e($approvedPlayers); ?>/<?php echo e($totalPlayers); ?>

                                                                    </span>
                                                                    <span class="text-[10px] font-black <?php echo e($pct === 100 ? 'text-green-600' : 'text-titanium'); ?>">
                                                                        <?php echo e($pct); ?>%
                                                                    </span>
                                                                </div>
                                                                <div class="h-1.5 w-full rounded-full bg-gray-100 overflow-hidden">
                                                                    <div class="h-full rounded-full transition-all <?php echo e($barColor); ?>"
                                                                         style="width: <?php echo e($pct); ?>%"></div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-xs text-titanium/40 font-semibold">—</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasGroups): ?>
                                                        <td class="px-4 py-3 text-center hidden lg:table-cell">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->group_label): ?>
                                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-primary/10 text-xs font-black text-primary"><?php echo e($team->group_label); ?></span>
                                                            <?php else: ?>
                                                                <span class="text-titanium/40">—</span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </td>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    
                                                    <td class="px-5 py-3">
                                                        <div class="flex items-center justify-end gap-1.5">
                                                            <a href="<?php echo e(route('tournament.team.players', [$tournament, $team])); ?>"
                                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition-colors"
                                                               title="Jugadores">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                                <span class="hidden sm:inline">Jugadores</span>
                                                            </a>
                                                            <button wire:click="openEditTeamModal(<?php echo e($team->id); ?>)"
                                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary/5 text-primary border border-primary/20 hover:bg-primary/10 transition-colors"
                                                                    title="Editar equipo">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                <span class="hidden sm:inline">Editar</span>
                                                            </button>
                                                            <button wire:click="confirmDeleteTeam(<?php echo e($team->id); ?>)"
                                                                    class="p-1.5 rounded-lg text-titanium/40 hover:text-red-500 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                                                                    title="Eliminar equipo">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div x-show="tab === 'setup'" x-cloak>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-black-deep">Fases del torneo</h3>
                                        <p class="text-xs text-titanium mt-0.5">Define el formato de competición</p>
                                    </div>
                                </div>
                                <button wire:click="openCreatePhaseModal"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-primary bg-primary/5 border border-primary/20 hover:bg-primary/10 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Nueva fase
                                </button>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phases->isEmpty()): ?>
                                <div class="flex flex-col items-center justify-center py-10 border-2 border-dashed border-silver rounded-2xl">
                                    <svg class="w-10 h-10 text-titanium/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <p class="text-sm text-titanium mb-3">Sin fases definidas</p>
                                    <button wire:click="openCreatePhaseModal"
                                            class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">
                                        + Crear primera fase
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="space-y-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-xl border border-silver/50">
                                            <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-sm font-black text-primary shrink-0"><?php echo e($phase->order); ?></span>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-black-deep"><?php echo e($phase->name); ?></p>
                                                <p class="text-xs text-titanium mt-0.5"><?php echo e($phase->typeLabel()); ?> · <?php echo e($phase->matches_count); ?> partidos</p>
                                            </div>
                                            <div class="flex items-center gap-1 shrink-0">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($phase->type, ['knockout', 'double_elimination'])): ?>
                                                    <button wire:click="openBracketModal(<?php echo e($phase->id); ?>)"
                                                            class="p-2 rounded-lg text-titanium hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Configurar cuadro eliminatorio">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                                                    </button>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <button wire:click="openEditPhaseModal(<?php echo e($phase->id); ?>)"
                                                        class="p-2 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors" title="Editar fase">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button wire:click="confirmDeletePhase(<?php echo e($phase->id); ?>)"
                                                        class="p-2 rounded-lg text-titanium hover:text-red-500 hover:bg-red-50 transition-colors" title="Eliminar fase">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="space-y-4">
                            <?php if($standings->isNotEmpty() || $matches->where('status', 'completed')->count() > 0): ?>
                                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-black-deep">Clasificación</h3>
                                            <p class="text-xs text-titanium mt-0.5">Recalcula puntos y posiciones</p>
                                        </div>
                                    </div>
                                    <button wire:click="recalculateStandings"
                                            class="w-full inline-flex items-center justify-center gap-2 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-2.5 rounded-xl hover:bg-green-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        Recalcular clasificación
                                    </button>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div x-show="tab === 'stats'" x-cloak>
                    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-black-deep mb-1">Estadísticas detalladas</h3>
                        <p class="text-sm text-titanium mb-5">Goleadores, tarjetas y sanciones del torneo.</p>
                        <a href="<?php echo e(route('tournament.stats', $tournament)); ?>" wire:navigate
                           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Ver estadísticas completas
                        </a>
                    </div>
                </div>

                
                <div x-show="tab === 'referees'" x-cloak>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-titanium">
                            <span class="font-bold text-black-deep"><?php echo e($assignedReferees->count()); ?></span> árbitros asignados
                        </p>
                        <button wire:click="openRefereesModal"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Gestionar árbitros
                        </button>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignedReferees->isEmpty()): ?>
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-black-deep mb-2">Aún no hay árbitros asignados</h3>
                            <p class="text-sm text-titanium mb-5">Asigna árbitros al torneo para que puedan gestionar los partidos.</p>
                            <button wire:click="openRefereesModal"
                                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Asignar árbitros
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-silver bg-gray-50/60">
                                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-5 py-3">Nombre</th>
                                            <th class="text-left text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden md:table-cell">Email</th>
                                            <th class="text-center text-xs font-semibold text-titanium uppercase tracking-wide px-4 py-3 hidden sm:table-cell">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $assignedReferees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50/60 transition-colors">
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referee->profile_photo_path): ?>
                                                            <img src="<?php echo e(asset('storage/' . $referee->profile_photo_path)); ?>"
                                                                 class="w-10 h-10 rounded-full object-cover border border-silver" alt="">
                                                        <?php else: ?>
                                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center shrink-0">
                                                                <span class="text-sm font-black text-indigo-700"><?php echo e(strtoupper(substr($referee->name, 0, 1))); ?></span>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <div>
                                                            <p class="font-semibold text-black-deep"><?php echo e($referee->name); ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-titanium hidden md:table-cell">
                                                    <?php echo e($referee->email); ?>

                                                </td>
                                                <td class="px-4 py-4 text-center hidden sm:table-cell">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referee->is_active): ?>
                                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                            Activo
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-600 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full">
                                                            Inactivo
                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php else: ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isEmpty() && $tournament->team_type !== 'open'): ?>
                <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-black-deep mb-2">Crea una categoría para empezar</h2>
                    <p class="text-sm text-titanium mb-6 max-w-md mx-auto">Las categorías agrupan equipos por edad o nivel (ej: Alevín, Infantil, Cadete). Crea al menos una para organizar tu torneo.</p>
                    <button wire:click="openCreateCategoryModal"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-bold px-6 py-3 rounded-xl shadow transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nueva Categoría
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGenerateModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Generar Partidos
                    </h3>
                    <button wire:click="$set('showGenerateModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fase *</label>
                        <select wire:model.live="generate_phase_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-500">
                            <option value="">— Selecciona una fase —</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($phase->id); ?>"><?php echo e($phase->name); ?> (<?php echo e($phase->typeLabel()); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['generate_phase_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <?php
                        $selectedGenPhase = $generate_phase_id ? $phases->firstWhere('id', (int) $generate_phase_id) : null;
                        $selectedGenPhaseType = $selectedGenPhase?->type;
                        $generateMaxTeams = 0;
                        if ($selectedGenPhase) {
                            $__isOpen = $tournament->team_type === 'open';
                            $__catId  = $__isOpen ? null : ($selectedGenPhase->tournament_category_id ?? $activeCategoryId ?? null);
                            $__q = \App\Models\TournamentTeam::where('tournament_id', $tournament->id);
                            if (!$__isOpen && $__catId) {
                                $__q->where('tournament_category_id', $__catId);
                            }
                            $generateMaxTeams = $__q->count();
                        }
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedGenPhaseType === 'league' && $generateMaxTeams >= 2): ?>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">
                                Equipos participantes en la liguilla
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="number"
                                       wire:model="generate_team_count"
                                       min="2"
                                       max="<?php echo e($generateMaxTeams); ?>"
                                       placeholder="Todos (<?php echo e($generateMaxTeams); ?>)"
                                       class="w-32 px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400/30 focus:border-indigo-500"/>
                                <span class="text-xs text-titanium">
                                    de <strong class="text-black-deep"><?php echo e($generateMaxTeams); ?></strong> disponibles
                                </span>
                            </div>
                            <p class="text-xs text-titanium mt-1.5 leading-relaxed">
                                Déjalo vacío (o pon <strong><?php echo e($generateMaxTeams); ?></strong>) para generar el calendario con todos los equipos cruzados.
                                Indica un número <strong>menor</strong> para generar los partidos <strong>sin equipos asignados</strong> y rellenarlos a mano después.
                            </p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['generate_team_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Vueltas</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 px-4 py-2.5 border rounded-xl cursor-pointer transition-colors
                                <?php echo e($generate_legs == 1 ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-silver text-titanium hover:border-indigo-300'); ?>">
                                <input type="radio" wire:model="generate_legs" value="1" class="text-indigo-600"/>
                                <span class="text-sm font-semibold">1 vuelta</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2.5 border rounded-xl cursor-pointer transition-colors
                                <?php echo e($generate_legs == 2 ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-silver text-titanium hover:border-indigo-300'); ?>">
                                <input type="radio" wire:model="generate_legs" value="2" class="text-indigo-600"/>
                                <span class="text-sm font-semibold">2 vueltas</span>
                            </label>
                        </div>
                    </div>
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-amber-200 bg-amber-50 cursor-pointer">
                        <input type="checkbox" wire:model="generate_clear" class="mt-0.5 text-amber-600"/>
                        <span class="text-xs text-amber-800">
                            <strong>Borrar partidos existentes</strong> de esta fase antes de generar los nuevos.
                        </span>
                    </label>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('showGenerateModal', false)"
                            class="px-4 py-2 text-sm font-semibold text-titanium border border-silver rounded-xl hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="generateMatches"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Generar
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPhaseModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep"><?php echo e($editingPhaseId ? 'Editar Fase' : 'Nueva Fase'); ?></h3>
                    <button wire:click="$set('showPhaseModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre *</label>
                        <input wire:model="phase_name" type="text" placeholder="Ej: Fase de grupos"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phase_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Tipo *</label>
                            <select wire:model.live="phase_type"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="league">Liga</option>
                                <option value="group">Grupos</option>
                                <option value="knockout">Eliminatoria</option>
                                <option value="swiss">Sistema Suizo</option>
                                <option value="double_elimination">Doble Eliminación</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Orden *</label>
                            <input wire:model="phase_order" type="number" min="1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center font-bold"/>
                        </div>
                    </div>
                    
                    <?php
                        $phaseDescriptions = [
                            'league'             => ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'color' => 'blue', 'title' => 'Liga', 'text' => 'Todos los equipos se enfrentan entre sí. Se puntúan victorias, empates y derrotas. Ideal para competiciones donde todos se miden entre sí.'],
                            'group'              => ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5m-5-2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'violet', 'title' => 'Fase de Grupos', 'text' => 'Los equipos se dividen en grupos donde juegan todos contra todos. Los primeros de cada grupo pasan a la siguiente ronda.'],
                            'knockout'           => ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'red', 'title' => 'Eliminatoria', 'text' => 'Eliminación directa: el perdedor queda fuera. Se resuelve por rondas hasta la final.'],
                            'swiss'              => ['icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 'color' => 'amber', 'title' => 'Sistema Suizo', 'text' => 'Sin eliminación. Cada ronda enfrenta a equipos con resultados similares. Permite clasificar con pocas rondas.'],
                            'double_elimination' => ['icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', 'color' => 'green', 'title' => 'Doble Eliminación', 'text' => 'Un equipo solo queda eliminado tras perder dos veces. Cuadro de ganadores y de perdedores.'],
                        ];
                        $desc = $phaseDescriptions[$phase_type] ?? $phaseDescriptions['league'];
                        $colorMap = ['blue' => 'bg-blue-50 border-blue-200 text-blue-800', 'violet' => 'bg-violet-50 border-violet-200 text-violet-800', 'red' => 'bg-red-50 border-red-200 text-red-800', 'amber' => 'bg-amber-50 border-amber-200 text-amber-800', 'green' => 'bg-green-50 border-green-200 text-green-800'];
                        $iconColor = ['blue' => 'text-blue-500', 'violet' => 'text-violet-500', 'red' => 'text-red-500', 'amber' => 'text-amber-500', 'green' => 'text-green-500'];
                    ?>
                    <div class="flex gap-3 p-3 rounded-xl border <?php echo e($colorMap[$desc['color']]); ?>">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 <?php echo e($iconColor[$desc['color']]); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($desc['icon']); ?>"/>
                        </svg>
                        <div>
                            <p class="text-xs font-bold mb-0.5"><?php echo e($desc['title']); ?></p>
                            <p class="text-xs leading-relaxed"><?php echo e($desc['text']); ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                        <select wire:model="phase_status"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="pending">Pendiente</option>
                            <option value="in_progress">En curso</option>
                            <option value="completed">Completada</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showPhaseModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="savePhase"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        <?php echo e($editingPhaseId ? 'Guardar cambios' : 'Crear Fase'); ?>

                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showTeamModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6 my-4">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep"><?php echo e($editingTeamId ? 'Editar Equipo' : 'Añadir Equipo'); ?></h3>
                    <button wire:click="$set('showTeamModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type === 'open'): ?>
                        <div class="flex items-center gap-2 p-3 bg-blue-50 rounded-xl border border-blue-100">
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs text-blue-700 font-medium">Torneo abierto: solo se pueden inscribir equipos externos.</p>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-silver">
                            <label class="text-sm font-medium text-black-deep">Equipo externo</label>
                            <button wire:click="$set('external_team', <?php echo e($external_team ? 'false' : 'true'); ?>)"
                                    class="relative inline-flex items-center w-10 h-6 rounded-full transition-colors <?php echo e($external_team ? 'bg-primary' : 'bg-silver'); ?>">
                                <span class="inline-block w-4 h-4 bg-white rounded-full shadow transition-transform <?php echo e($external_team ? 'translate-x-5' : 'translate-x-1'); ?>"></span>
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($external_team): ?>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre del equipo *</label>
                            <input wire:model="name_override" type="text" placeholder="Nombre del equipo externo"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name_override'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo de la escuela</label>
                            <select wire:model="team_id"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">Seleccionar equipo...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schoolTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($st->id); ?>"><?php echo e($st->team); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre personalizado (opcional)</label>
                            <input wire:model="name_override" type="text" placeholder="Dejar vacío para usar nombre del equipo"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Escudo del equipo</label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team_logo && !$team_logo_upload): ?>
                            <div class="flex items-center gap-3 mb-2">
                                <img src="<?php echo e(asset('storage/' . $team_logo)); ?>" class="w-14 h-14 object-cover rounded-xl border border-silver">
                                <button wire:click="deleteTeamLogo" type="button" class="text-xs text-red-500 hover:text-red-700 font-semibold">Eliminar</button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team_logo_upload): ?>
                            <img src="<?php echo e($team_logo_upload->temporaryUrl()); ?>" class="w-14 h-14 object-cover rounded-xl border border-silver mb-2">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <input wire:model="team_logo_upload" type="file" accept="image/*"
                               class="w-full text-sm text-titanium file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"/>
                        <div wire:loading wire:target="team_logo_upload" class="text-xs text-primary mt-1">Subiendo...</div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_logo_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="text-xs text-titanium/60 mt-1">PNG, JPG (máx. 2MB)</p>
                    </div>

                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre de contacto</label>
                            <input wire:model="team_contact_name" type="text" placeholder="Nombre"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Teléfono</label>
                            <input wire:model="team_contact_phone" type="tel" placeholder="600 000 000"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_contact_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">
                            Email de acceso <?php echo e($tournament->team_type === 'open' ? '*' : '(opcional)'); ?>

                        </label>
                        <input wire:model="team_email" type="email" placeholder="equipo@ejemplo.com"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">
                            Contraseña <?php echo e($editingTeamId ? '(dejar vacío para no cambiar)' : ($tournament->team_type === 'open' ? '*' : '(opcional)')); ?>

                        </label>
                        <input wire:model="team_password" type="password" placeholder="<?php echo e($editingTeamId ? '••••••' : 'Contraseña de acceso'); ?>"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="text-xs text-titanium/60 mt-1">Acceso al área de gestión del equipo (mínimo 6 caracteres).</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Cabeza de serie</label>
                            <input wire:model="team_seed" type="number" min="1" placeholder="0"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Grupo</label>
                            <input wire:model="team_group" type="text" placeholder="A, B, C..."
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center uppercase"/>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showTeamModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveTeam"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        <?php echo e($editingTeamId ? 'Guardar cambios' : 'Añadir Equipo'); ?>

                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showBracketModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-xl p-6 my-4">
                
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-black-deep">Configurar cuadro eliminatorio</h3>
                    </div>
                    <button wire:click="$set('showBracketModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                

                
                <div class="mb-5">
                    <p class="text-xs font-semibold text-titanium uppercase tracking-wide mb-3">Primera ronda del cuadro</p>
                    <div class="grid grid-cols-2 gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                            1 => ['label' => 'Final',           'sub' => '2 equipos'],
                            2 => ['label' => 'Semifinal',       'sub' => '4 equipos'],
                            3 => ['label' => 'Cuartos de Final','sub' => '8 equipos'],
                            4 => ['label' => 'Octavos de Final','sub' => '16 equipos'],
                            5 => ['label' => '16avos de Final', 'sub' => '32 equipos'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rc => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button wire:click="$set('bracketRoundCount', <?php echo e($rc); ?>)"
                                    class="flex flex-col items-center justify-center gap-0.5 px-3 py-3 rounded-xl border-2 transition-all text-center
                                        <?php echo e($bracketRoundCount === $rc
                                            ? 'border-primary bg-primary/5 text-primary'
                                            : 'border-silver bg-gray-50 text-titanium hover:border-primary/40 hover:text-black-deep'); ?>">
                                <span class="text-sm font-bold leading-tight"><?php echo e($info['label']); ?></span>
                                <span class="text-[11px] font-medium <?php echo e($bracketRoundCount === $rc ? 'text-primary/70' : 'text-titanium/60'); ?>"><?php echo e($info['sub']); ?></span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="mb-5 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                    <p class="text-xs text-blue-800">
                        Se generará un cuadro vacío con
                        <strong><?php echo e((int) pow(2, $bracketRoundCount)); ?></strong> plazas y
                        <strong><?php echo e($bracketRoundCount); ?></strong> <?php echo e($bracketRoundCount === 1 ? 'ronda' : 'rondas'); ?>.
                        Asigna los equipos directamente en cada partido del cuadro.
                    </p>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bracketModalStandings->isNotEmpty()): ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="mb-5 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" wire:model="bracketThirdPlace"
                               class="w-4 h-4 rounded text-primary border-silver focus:ring-primary/30">
                        <div>
                            <p class="text-sm font-semibold text-black-deep">Incluir partido por el 3er puesto</p>
                            <p class="text-xs text-titanium">Los perdedores de semifinales jugarán por el tercer lugar</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" wire:model="bracketClearExisting"
                               class="w-4 h-4 rounded text-red-500 border-silver focus:ring-red-300">
                        <div>
                            <p class="text-sm font-semibold text-red-700">Borrar partidos existentes</p>
                            <p class="text-xs text-titanium">Elimina todos los partidos actuales de esta fase antes de generar</p>
                        </div>
                    </label>
                </div>

                
                <div class="flex gap-3">
                    <button wire:click="$set('showBracketModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="generateKnockoutBracket"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        Generar cuadro
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showMatchModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-lg p-6 my-4">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep"><?php echo e($editingMatchId ? 'Editar Partido' : 'Nuevo Partido'); ?></h3>
                    <button wire:click="$set('showMatchModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fase</label>
                        <select wire:model="match_phase_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="">Sin fase</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($phase->id); ?>"><?php echo e($phase->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo local *</label>
                            <select wire:model="match_home_id"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['match_home_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Equipo visitante *</label>
                            <select wire:model="match_away_id"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['match_away_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Jornada / Ronda</label>
                            <input wire:model="match_round" type="text" placeholder="Ej: 1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nº Partido</label>
                            <input wire:model="match_number" type="number" min="1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fecha y hora</label>
                            <input wire:model="match_scheduled" type="datetime-local"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Ubicación</label>
                            <input wire:model="match_location" type="text"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                        <select wire:model="match_status"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="scheduled">Programado</option>
                            <option value="in_progress">En curso</option>
                            <option value="completed">Completado</option>
                            <option value="cancelled">Cancelado</option>
                            <option value="postponed">Aplazado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Notas</label>
                        <textarea wire:model="match_notes" rows="2"
                                  class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showMatchModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveMatch"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        <?php echo e($editingMatchId ? 'Guardar cambios' : 'Crear Partido'); ?>

                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGoalsModal && $goalsModalMatch): ?>
        <?php
            $gm_homeTeamId = $goalsModalMatch->home_team_id;
            $gm_awayTeamId = $goalsModalMatch->away_team_id;
            // Merge goals + cards into a unified timeline sorted by minute (nulls last)
            $gm_timeline = $goalsForModal->map(fn($g) => (object)[
                'type'    => 'goal',
                'minute'  => $g->minute,
                'player'  => $g->player,
                'team'    => $g->team,
                'subtype' => $g->goal_type,
                'id'      => $g->id,
                'teamId'  => $g->tournament_team_id,
            ])->merge(
                $gmCardsForModal->map(fn($c) => (object)[
                    'type'    => 'card',
                    'minute'  => $c->minute,
                    'player'  => $c->player,
                    'team'    => $c->team,
                    'subtype' => $c->card_type,
                    'id'      => $c->id,
                    'teamId'  => $c->tournament_team_id,
                ])
            )->sortBy(fn($e) => $e->minute ?? 999)->values();
        ?>

        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4 bg-black/50 backdrop-blur-sm"
             wire:keydown.window.escape="closeGoalsModal">
            <div class="bg-white w-full sm:max-w-2xl max-h-[96vh] sm:max-h-[92vh] sm:rounded-2xl rounded-t-2xl shadow-2xl border border-silver flex flex-col overflow-hidden">

                
                <div class="px-5 pt-4 pb-3 border-b border-silver shrink-0">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-titanium uppercase tracking-wider">Control del partido</p>
                        <button wire:click="closeGoalsModal" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                
                <div class="px-5 py-4 border-b border-silver shrink-0
                    <?php echo e($goalsModalMatch->status === 'in_progress' ? 'bg-green-50/60' : 'bg-gray-50/40'); ?>">
                    
                    <div class="flex items-center gap-2">
                        <p class="flex-1 text-right text-sm font-bold text-black-deep leading-tight"><?php echo e($goalsModalMatch->homeTeam?->displayName() ?? '—'); ?></p>
                        <button wire:click="openGoalsModal(<?php echo e($goalsModalMatch->id); ?>)"
                                class="shrink-0 px-4 py-2.5 rounded-xl text-center font-black text-2xl min-w-[90px]
                                    <?php echo e($goalsModalMatch->status === 'in_progress'
                                        ? 'bg-green-500 text-white border border-green-600 shadow-sm'
                                        : ($goalsModalMatch->status === 'completed'
                                            ? 'bg-gray-100 text-black-deep border border-silver'
                                            : 'bg-white border-2 border-dashed border-silver text-titanium')); ?>">
                            <?php echo e($goalsModalMatch->home_score ?? 0); ?> – <?php echo e($goalsModalMatch->away_score ?? 0); ?>

                        </button>
                        <p class="flex-1 text-left text-sm font-bold text-black-deep leading-tight"><?php echo e($goalsModalMatch->awayTeam?->displayName() ?? '—'); ?></p>
                    </div>
                    
                    <div class="flex items-center justify-center gap-2 mt-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goalsModalMatch->status === 'scheduled' || $goalsModalMatch->status === 'postponed'): ?>
                            <button wire:click="gmStartMatch"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary text-white text-xs font-bold hover:bg-primary/90 transition-colors shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                Iniciar partido
                            </button>
                        <?php elseif($goalsModalMatch->status === 'in_progress'): ?>
                            <span class="inline-flex items-center gap-1.5 text-xs font-black text-white bg-red-500 px-3 py-1.5 rounded-full animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-white shrink-0"></span>
                                EN VIVO
                            </span>
                            <button wire:click="gmFinishMatch"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-800 text-white text-xs font-bold hover:bg-black transition-colors">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><rect x="6" y="6" width="12" height="12"/></svg>
                                Finalizar partido
                            </button>
                        <?php elseif($goalsModalMatch->status === 'completed'): ?>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-100 border border-green-200 px-3 py-1.5 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Partido finalizado
                            </span>
                            <button wire:click="gmStartMatch"
                                    class="text-xs font-semibold text-titanium border border-silver px-3 py-1.5 rounded-xl hover:bg-gray-50 transition-colors">
                                Reabrir
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="flex-1 overflow-y-auto min-h-0">

                
                <div class="px-4 py-3 space-y-1.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_timeline->isEmpty()): ?>
                        <div class="text-center py-8">
                            <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl">⚽</span>
                            </div>
                            <p class="text-sm text-titanium">Aún no hay eventos registrados</p>
                        </div>
                    <?php else: ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gm_timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isHome = $event->teamId === $gm_homeTeamId; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'goal' && $gm_deletingGoalId === $event->id): ?>
                                <div class="flex items-center justify-between bg-red-50 border border-red-200 rounded-xl px-4 py-2.5">
                                    <span class="text-sm text-red-700">¿Eliminar este gol?</span>
                                    <div class="flex gap-2">
                                        <button wire:click="gmCancelDeleteGoal" class="px-3 py-1 text-xs font-semibold text-titanium border border-silver rounded-lg hover:bg-gray-50">No</button>
                                        <button wire:click="gmDeleteGoal" class="px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600">Sí</button>
                                    </div>
                                </div>
                            <?php elseif($event->type === 'card' && $gm_deletingCardId === $event->id): ?>
                                <div class="flex items-center justify-between bg-red-50 border border-red-200 rounded-xl px-4 py-2.5">
                                    <span class="text-sm text-red-700">¿Eliminar esta tarjeta?</span>
                                    <div class="flex gap-2">
                                        <button wire:click="gmCancelDeleteCard" class="px-3 py-1 text-xs font-semibold text-titanium border border-silver rounded-lg hover:bg-gray-50">No</button>
                                        <button wire:click="gmDeleteCard" class="px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600">Sí</button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 group transition-colors
                                    <?php echo e($event->type === 'card' && in_array($event->subtype, ['red','double_yellow']) ? 'bg-red-50/60' : ''); ?>">
                                    
                                    <span class="shrink-0 w-9 text-center text-[11px] font-bold text-titanium">
                                        <?php echo e($event->minute ? $event->minute . "'" : '—'); ?>

                                    </span>
                                    
                                    <span class="shrink-0 text-base leading-none">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'goal'): ?> ⚽
                                        <?php elseif($event->subtype === 'yellow'): ?> 🟨
                                        <?php elseif($event->subtype === 'red'): ?> 🟥
                                        <?php else: ?> 🟨🟥
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-black-deep truncate">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->player): ?>
                                                <?php echo e($event->player->dorsal ? '#' . $event->player->dorsal . ' ' : ''); ?><?php echo e($event->player->surname); ?> <?php echo e($event->player->name); ?>

                                            <?php else: ?>
                                                <span class="italic text-titanium">Gol sin jugador</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'goal'): ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->subtype === 'own_goal'): ?>
                                                    <span class="text-xs font-normal text-red-500">(p.p.)</span>
                                                <?php elseif($event->subtype === 'penalty'): ?>
                                                    <span class="text-xs font-normal text-blue-500">(pen.)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php elseif($event->subtype === 'double_yellow'): ?>
                                                <span class="text-xs font-normal text-orange-500">(2ª amarilla)</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                        <p class="text-xs text-titanium truncate"><?php echo e($event->team?->displayName()); ?></p>
                                    </div>
                                    
                                    <span class="shrink-0 text-[10px] font-bold px-1.5 py-0.5 rounded
                                        <?php echo e($isHome ? 'bg-primary/10 text-primary' : 'bg-orange-100 text-orange-600'); ?>">
                                        <?php echo e($isHome ? 'L' : 'V'); ?>

                                    </span>
                                    
                                    <button wire:click="<?php echo e($event->type === 'goal' ? 'gmConfirmDeleteGoal' : 'gmConfirmDeleteCard'); ?>(<?php echo e($event->id); ?>)"
                                            class="shrink-0 p-1.5 rounded-lg text-titanium/20 hover:text-red-500 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="border-t border-silver bg-gray-50/60 rounded-b-2xl">

                    
                    <div class="flex px-4 pt-3 gap-2">
                        <button wire:click="gmSetAction('goal')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-bold transition-all
                                    <?php echo e($gm_action === 'goal' ? 'bg-primary text-white shadow-sm' : 'bg-white border border-silver text-titanium hover:bg-gray-50'); ?>">
                            ⚽ Gol
                        </button>
                        <button wire:click="gmSetAction('card')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-sm font-bold transition-all
                                    <?php echo e($gm_action === 'card' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white border border-silver text-titanium hover:bg-gray-50'); ?>">
                            🟨 Tarjeta
                        </button>
                    </div>

                    <div class="px-4 pb-4 pt-4 space-y-4">

                        
                        <div>
                            <p class="text-[11px] font-bold text-titanium uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                <span class="inline-flex w-4 h-4 rounded-full bg-titanium/20 items-center justify-center text-[10px] font-black shrink-0">1</span>
                                ¿De qué equipo?
                            </p>
                            <div class="grid grid-cols-2 gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gmMatchTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isHome     = $t->id === $gm_homeTeamId;
                                        $isSelected = (string)$gm_team_id === (string)$t->id;
                                    ?>
                                    <button wire:click="gmSelectTeam(<?php echo e($t->id); ?>)"
                                            class="relative flex flex-col items-center justify-center gap-0.5 px-3 py-3.5 rounded-xl border-2 transition-all min-h-[68px]
                                                <?php echo e($isSelected
                                                    ? ($isHome ? 'border-primary bg-primary text-white shadow-md' : 'border-orange-500 bg-orange-500 text-white shadow-md')
                                                    : ($isHome ? 'border-primary/20 bg-white text-primary hover:border-primary/50 hover:bg-primary/5' : 'border-orange-200 bg-white text-orange-600 hover:border-orange-400 hover:bg-orange-50')); ?>">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isSelected): ?>
                                            <svg class="absolute top-1.5 right-1.5 w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="text-[10px] font-semibold uppercase tracking-wider <?php echo e($isSelected ? 'text-white/70' : 'opacity-60'); ?>">
                                            <?php echo e($isHome ? 'Local' : 'Visitante'); ?>

                                        </span>
                                        <span class="text-xs font-bold text-center leading-tight mt-0.5">
                                            <?php echo e($t->displayName()); ?>

                                        </span>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_team_id): ?>
                            <?php
                                $isHomeTeam     = (int)$gm_team_id === $gm_homeTeamId;
                                $teamHasPlayers = $gmTeamPlayers->isNotEmpty() || $gm_player_search !== '';
                            ?>
                            <div>
                                <p class="text-[11px] font-bold text-titanium uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                    <span class="inline-flex w-4 h-4 rounded-full bg-titanium/20 items-center justify-center text-[10px] font-black shrink-0">2</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_action === 'goal'): ?>
                                        ¿Qué jugador? <span class="text-titanium/60 normal-case font-semibold">(opcional)</span>
                                    <?php else: ?>
                                        ¿Qué jugador?
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teamHasPlayers): ?>
                                    <div class="relative mb-2.5">
                                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-titanium/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        <input wire:model.live="gm_player_search"
                                               type="text" placeholder="Buscar por dorsal o nombre..."
                                               class="w-full pl-9 pr-3 py-2 text-sm border border-silver rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gmTeamPlayers->isEmpty()): ?>
                                    <div class="bg-white border border-dashed border-silver rounded-xl px-4 py-4 text-center">
                                        <p class="text-xs text-titanium mb-2">
                                            <?php echo e($gm_player_search
                                                ? 'Sin resultados para "' . $gm_player_search . '"'
                                                : 'Este equipo no tiene jugadores inscritos.'); ?>

                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_action === 'goal' && $gm_player_search === ''): ?>
                                            <p class="text-[11px] text-titanium/70 leading-relaxed">
                                                Puedes registrar el gol <strong class="text-black-deep">sin asignarlo a ningún jugador</strong>; solo contará para el marcador del equipo.
                                            </p>
                                        <?php elseif($gm_action === 'card'): ?>
                                            <p class="text-[11px] text-titanium/70">Las tarjetas requieren un jugador registrado.</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="grid grid-cols-3 gap-1.5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gmTeamPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $pSel = (string)$gm_player_id === (string)$p->id; ?>
                                            <button wire:click="gmSelectPlayer(<?php echo e($p->id); ?>)"
                                                    class="flex flex-col items-center gap-0.5 px-1.5 py-2.5 rounded-xl border-2 text-center transition-all
                                                        <?php echo e($pSel
                                                            ? ($isHomeTeam ? 'border-primary bg-primary text-white shadow-sm' : 'border-orange-500 bg-orange-500 text-white shadow-sm')
                                                            : ($isHomeTeam ? 'border-silver bg-white hover:border-primary/40 hover:bg-primary/5' : 'border-silver bg-white hover:border-orange-300 hover:bg-orange-50')); ?>">
                                                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-black mb-0.5
                                                    <?php echo e($pSel
                                                        ? 'bg-white/20 text-white'
                                                        : ($isHomeTeam ? 'bg-primary/10 text-primary' : 'bg-orange-100 text-orange-600')); ?>">
                                                    <?php echo e($p->dorsal ?? '?'); ?>

                                                </span>
                                                <span class="text-[11px] font-bold leading-tight w-full truncate <?php echo e($pSel ? 'text-white' : 'text-black-deep'); ?>">
                                                    <?php echo e($p->surname); ?>

                                                </span>
                                                <span class="text-[10px] leading-tight w-full truncate <?php echo e($pSel ? 'text-white/70' : 'text-titanium'); ?>">
                                                    <?php echo e($p->name); ?>

                                                </span>
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['gm_player_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500 mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(
                            ($gm_action === 'goal' && $gm_team_id)
                            || ($gm_action === 'card' && $gm_player_id)
                        ): ?>
                            <div class="space-y-3">
                                <p class="text-[11px] font-bold text-titanium uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="inline-flex w-4 h-4 rounded-full bg-titanium/20 items-center justify-center text-[10px] font-black shrink-0">3</span>
                                    Detalles
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_action === 'goal' && !$gm_player_id): ?>
                                        <span class="ml-1 text-[10px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                            Gol sin jugador
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                                <div class="flex gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_action === 'goal'): ?>
                                        <select wire:model="gm_goal_type"
                                                class="flex-1 px-3 py-2.5 text-sm border border-silver rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                            <option value="normal">⚽ Normal</option>
                                            <option value="penalty">🎯 Penalti</option>
                                            <option value="own_goal">↩️ En propia</option>
                                        </select>
                                    <?php else: ?>
                                        <select wire:model="gm_card_type"
                                                class="flex-1 px-3 py-2.5 text-sm border border-silver rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400">
                                            <option value="yellow">🟨 Amarilla</option>
                                            <option value="red">🟥 Roja directa</option>
                                            <option value="double_yellow">🟨🟥 Doble amarilla</option>
                                        </select>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <input wire:model="<?php echo e($gm_action === 'goal' ? 'gm_minute' : 'gm_card_minute'); ?>"
                                           type="number" min="1" max="180" placeholder="Min."
                                           class="w-20 px-3 py-2.5 text-sm border border-silver rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center"/>
                                </div>
                                <button wire:click="<?php echo e($gm_action === 'goal' ? 'gmAddGoal' : 'gmAddCard'); ?>"
                                        class="w-full py-3 rounded-xl text-sm font-bold transition-colors shadow-sm
                                            <?php echo e($gm_action === 'goal'
                                                ? 'bg-primary text-white hover:bg-primary/90'
                                                : 'bg-amber-500 text-white hover:bg-amber-600'); ?>">
                                    <?php echo e($gm_action === 'goal'
                                        ? ($gm_player_id ? '+ Registrar gol' : '+ Registrar gol de equipo')
                                        : '+ Registrar tarjeta'); ?>

                                </button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>
                </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingPhaseDelete): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar fase?</h3>
                <p class="text-sm text-titanium text-center mb-6">Se eliminarán también todos los partidos y clasificaciones de esta fase.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingPhaseDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deletePhase"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingTeamDelete): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar equipo?</h3>
                <p class="text-sm text-titanium text-center mb-6">El equipo será eliminado del torneo.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingTeamDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deleteTeam"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showRefereesModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-6 border-b border-silver shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-black-deep flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Gestionar Árbitros
                        </h3>
                        <p class="text-sm text-titanium mt-1">Selecciona los árbitros que deseas asignar al torneo</p>
                    </div>
                    <button wire:click="$set('showRefereesModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableReferees->isEmpty()): ?>
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h4 class="text-base font-bold text-black-deep mb-2">No hay árbitros disponibles</h4>
                            <p class="text-sm text-titanium">No hay usuarios con el rol de "judge" en tu escuela deportiva.</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableReferees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center gap-4 p-4 rounded-xl border border-silver hover:border-primary/30 hover:bg-primary/5 cursor-pointer transition-all
                                    <?php echo e(in_array($referee->id, $selectedReferees) ? 'bg-primary/10 border-primary shadow-sm' : 'bg-white'); ?>">
                                    <input type="checkbox" 
                                           wire:click="toggleReferee(<?php echo e($referee->id); ?>)"
                                           <?php echo e(in_array($referee->id, $selectedReferees) ? 'checked' : ''); ?>

                                           class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary/30">
                                    
                                    <div class="flex items-center gap-3 flex-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referee->profile_photo_path): ?>
                                            <img src="<?php echo e(asset('storage/' . $referee->profile_photo_path)); ?>"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-silver" alt="">
                                        <?php else: ?>
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary/20 to-primary/5 border-2 border-primary/20 flex items-center justify-center shrink-0">
                                                <span class="text-lg font-black text-primary"><?php echo e(strtoupper(substr($referee->name, 0, 1))); ?></span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-black-deep"><?php echo e($referee->name); ?></p>
                                            <p class="text-sm text-titanium truncate"><?php echo e($referee->email); ?></p>
                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referee->is_active): ?>
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 px-2 py-1 rounded-full shrink-0">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Activo
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex items-center justify-between gap-3 p-6 border-t border-silver shrink-0">
                    <p class="text-sm text-titanium">
                        <span class="font-bold text-black-deep"><?php echo e(count($selectedReferees)); ?></span> 
                        <?php echo e(count($selectedReferees) === 1 ? 'árbitro seleccionado' : 'árbitros seleccionados'); ?>

                    </p>
                    <div class="flex gap-3">
                        <button wire:click="$set('showRefereesModal', false)"
                                class="px-5 py-2.5 text-sm font-semibold text-titanium border border-silver rounded-xl hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="saveReferees"
                                class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Guardar árbitros
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingMatchDelete): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar partido?</h3>
                <p class="text-sm text-titanium text-center mb-6">Esta acción no se puede deshacer.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingMatchDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deleteMatch"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPostponeModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-black-deep">Aplazar partido</h3>
                    <button wire:click="$set('showPostponeModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-titanium mb-4">El partido quedará marcado como aplazado. Puedes indicar la nueva fecha y hora.</p>
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nueva fecha y hora (opcional)</label>
                    <input wire:model="postponeDate" type="datetime-local"
                           class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                </div>
                <div class="flex gap-3">
                    <button wire:click="$set('showPostponeModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="postponeMatch"
                            class="flex-1 py-2.5 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 transition-colors">Aplazar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategoryModal): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-bold text-black-deep">
                        <?php echo e($editingCategoryId ? 'Editar Categoría' : 'Nueva Categoría'); ?>

                    </h3>
                    <button wire:click="$set('showCategoryModal', false)" class="p-1.5 rounded-lg text-titanium hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Categoría de la escuela</label>
                        <select wire:model="cat_category_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            <option value="">Sin categoría (personalizada)</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schoolCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sc->id); ?>"><?php echo e($sc->category); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <p class="text-xs text-titanium mt-1">Vincular a una categoría filtrará los equipos por edad.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre personalizado (opcional)</label>
                        <input wire:model="cat_name" type="text" placeholder="Ej: Alevín Verano 2026"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cat_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Orden</label>
                            <input wire:model="cat_order" type="number" min="1"
                                   class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-center font-bold"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                            <select wire:model="cat_status"
                                    class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="active">Activa</option>
                                <option value="completed">Finalizada</option>
                                <option value="cancelled">Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('showCategoryModal', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="saveCategory"
                            class="flex-1 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary/90 transition-colors">
                        <?php echo e($editingCategoryId ? 'Guardar cambios' : 'Crear Categoría'); ?>

                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingCategoryDelete): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
            <div class="bg-white-pure rounded-2xl shadow-2xl border border-silver w-full max-w-sm p-6">
                <h3 class="text-base font-bold text-black-deep text-center mb-2">¿Eliminar categoría?</h3>
                <p class="text-sm text-titanium text-center mb-6">Se eliminarán <strong>todos</strong> los equipos, fases, partidos y clasificaciones de esta categoría.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('confirmingCategoryDelete', false)"
                            class="flex-1 py-2.5 rounded-xl border border-silver text-sm font-semibold text-titanium hover:bg-gray-50 transition-colors">Cancelar</button>
                    <button wire:click="deleteCategory"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Eliminar categoría</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\tournaments\show.blade.php ENDPATH**/ ?>