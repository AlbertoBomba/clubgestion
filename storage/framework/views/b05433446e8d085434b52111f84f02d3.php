<div class="min-h-screen bg-gray-50 pb-24 relative" x-data="{ tab: '<?php echo e($phases->isNotEmpty() ? 'matches' : 'setup'); ?>' }"
     x-effect="if (tab === 'bracket' && <?php echo e($hasKnockoutPhase ? 'false' : 'true'); ?>) tab = 'matches'">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('message')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 left-4 z-[60] bg-green-50 border-l-4 border-green-500 rounded-2xl p-4 shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <p class="text-xs font-bold text-green-800"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 left-4 z-[60] bg-red-50 border-l-4 border-red-500 rounded-2xl p-4 shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-xs font-bold text-red-800"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 px-4 py-3">
        <div class="flex items-center gap-3">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->logo): ?>
                <img src="<?php echo e(Storage::url($tournament->logo)); ?>" class="w-12 h-12 rounded-xl object-cover border border-gray-100 shadow-sm shrink-0" alt="">
            <?php else: ?>
                <div class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <div class="flex-1 min-w-0">
                <h1 class="text-base font-black text-titanium leading-tight truncate"><?php echo e($tournament->name); ?></h1>
                <?php
                    $statusStyles = [
                        'draft'             => 'bg-gray-100 text-gray-600',
                        'registration_open' => 'bg-blue-50 text-blue-700',
                        'in_progress'       => 'bg-amber-50 text-amber-700',
                        'completed'         => 'bg-green-50 text-green-700',
                        'cancelled'         => 'bg-red-50 text-red-600',
                    ];
                    $statusLabels = [
                        'draft'             => 'Borrador',
                        'registration_open' => 'Inscripciones abiertas',
                        'in_progress'       => 'En curso',
                        'completed'         => 'Finalizado',
                        'cancelled'         => 'Cancelado',
                    ];
                ?>
                <p class="text-[10px] font-bold mt-0.5 truncate">
                    <span class="px-1.5 py-0.5 rounded-md <?php echo e($statusStyles[$tournament->status] ?? 'bg-gray-100 text-gray-600'); ?>">
                        <?php echo e($statusLabels[$tournament->status] ?? $tournament->status); ?>

                    </span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->start_date): ?>
                         <span class="text-gray-400 ml-1"><?php echo e($tournament->start_date->translatedFormat('d M')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
            <a wire:click="exportPdf" 
               aria-label="Exportar PDF"
               title="Exportar PDF"
               class="shrink-0 flex flex-col items-center justify-center gap-1 w-12 h-12 rounded-xl bg-red-50 border border-red-100 text-gray-500 hover:bg-primary/5 hover:border-primary/20 hover:text-primary active:scale-95 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                <svg wire:loading.remove wire:target="exportPdf" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M8 6a4 4 0 118 0v6"/></svg>
                            <svg wire:loading wire:target="exportPdf" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="4"/><path stroke-linecap="round" stroke-width="4" d="M22 12a10 10 0 00-10-10"/></svg>
                            
                            <span class="text-[9px] font-bold leading-none" wire:loading.remove wire:target="exportPdf">PDF</span>
                            <span class="text-[9px] font-bold leading-none" wire:loading wire:target="exportPdf">Running…</span>
            </a>

            <a href="<?php echo e(route('tournaments.edit', $tournament)); ?>"
               aria-label="Editar torneo"
               title="Editar torneo"
               class="shrink-0 flex flex-col items-center justify-center gap-1 w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 text-gray-500 hover:bg-primary/5 hover:border-primary/20 hover:text-primary active:scale-95 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
                <svg class="w-4 h-4 shrink-0" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span class="text-[9px] font-bold leading-none">Editar</span>
            </a>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type !== 'open' && $categories->isNotEmpty()): ?>
            <div class="flex items-center gap-2 overflow-x-auto mt-3 pb-1 no-scrollbar">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button wire:click="selectCategory(<?php echo e($cat->id); ?>)"
                            class="whitespace-nowrap px-3 py-1.5 rounded-full text-[11px] font-bold transition-all shrink-0
                                <?php echo e($activeCategoryId === $cat->id ? 'bg-primary text-white shadow-sm' : 'bg-gray-100 text-gray-500 border border-transparent'); ?>">
                        <?php echo e($cat->name ?? $cat->category?->category ?? 'Categoría'); ?>

                        <span class="ml-1 opacity-70">(<?php echo e($cat->tournament_teams_count); ?>)</span>
                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button wire:click="openCreateCategoryModal" class="shrink-0 w-7 h-7 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </button>
            </div>

        <?php elseif($tournament->team_type === 'open'): ?>

            <div class="mt-2 text-[10px] text-blue-600 bg-blue-50 px-2 py-1 rounded-md text-center font-bold">
                <?php echo e($tournament->name); ?>

            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </header>

    <main class="p-3">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeCategoryId || $tournament->team_type === 'open'): ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teams->isEmpty() && $matches->isEmpty()): ?>
                
                <div x-show="tab === 'matches' || tab === 'teams'" x-cloak class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100 mt-10">
                    <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-lg font-black text-titanium mb-2">Añade equipos</h2>
                    <p class="text-xs text-gray-500 mb-6">El primer paso es añadir los equipos participantes para luego generar el cuadro o la liga.</p>
                    <button wire:click="openCreateTeamModal" class="w-full py-3.5 bg-primary text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-md">
                        Añadir Primer Equipo
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div x-show="tab === 'matches' && <?php echo e($teams->isNotEmpty() || $matches->isNotEmpty() ? 'true' : 'false'); ?>" x-cloak class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->isEmpty()): ?>
                        <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100 mt-4">
                            <div class="w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <h3 class="text-base font-black text-titanium mb-2">Sin partidos</h3>
                            <p class="text-xs text-gray-500 mb-6">Genera los encuentros automáticamente cruzando los equipos inscritos.</p>
                            
                            <button wire:click="openGenerateMatchesModal" class="w-full mb-3 py-3.5 bg-indigo-600 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-md">
                                Generar Automáticamente
                            </button>
                            <button wire:click="openCreateMatchModal" class="w-full py-3.5 bg-gray-50 text-titanium font-black text-sm rounded-2xl active:scale-95 transition-all">
                                Añadir Manual
                            </button>
                        </div>
                    <?php else: ?>
                        
                        <div class="flex items-center justify-between px-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Jugados: <span class="text-titanium"><?php echo e($matches->where('status', 'completed')->count()); ?>/<?php echo e($matches->count()); ?></span>
                            </p>
                            <div class="flex gap-2">
                                <button wire:click="openGenerateMatchesModal" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase rounded-lg active:scale-95">Generar</button>
                                <button wire:click="openCreateMatchModal" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-[10px] font-black uppercase rounded-lg active:scale-95">Añadir</button>
                            </div>
                        </div>

                        
                        <div class="space-y-6 pb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $matches->sortBy([['phase_id', 'asc'], ['round', 'asc'], ['match_number', 'asc'], ['scheduled_at', 'asc']])->groupBy(fn($m) => $m->phase_id ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $phaseMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $phase     = $phaseMatches->first()?->phase;
                                    $phaseName = $phase?->name ?? 'Sin fase';
                                ?>
                                
                                <div>
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="h-6 w-1 bg-primary rounded-full"></div>
                                        <h3 class="text-sm font-black text-titanium"><?php echo e($phaseName); ?></h3>
                                    </div>

                                    <div class="space-y-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseMatches->groupBy(fn($m) => $m->round ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round => $roundMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $roundLabel = $round > 0 ? 'Jornada ' . $round : 'Sin jornada';
                                                $completedCount = $roundMatches->where('status', 'completed')->count();
                                                $allCompleted = $completedCount === $roundMatches->count();
                                            ?>
                                            
                                            <div class="bg-white-pure rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                                                <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                                                    <span class="text-xs font-black text-gray-500"><?php echo e($roundLabel); ?></span>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($allCompleted): ?>
                                                        <span class="text-[9px] font-black uppercase text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Completada</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                                <div class="divide-y divide-gray-50">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roundMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $homeWins = $match->status === 'completed' && $match->home_score > $match->away_score;
                                                            $awayWins = $match->status === 'completed' && $match->away_score > $match->home_score;
                                                        ?>
                                                        <div class="p-3 relative <?php echo e($match->status === 'in_progress' ? 'bg-red-50/30' : ''); ?>">
                                                            
                                                            
                                                            <div class="flex justify-between items-center mb-2">
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'in_progress'): ?>
                                                                    <span class="text-[9px] font-black bg-red-500 text-white px-2 py-0.5 rounded-full animate-pulse">EN VIVO</span>
                                                                <?php elseif($match->scheduled_at): ?>
                                                                    <span class="text-[10px] font-bold text-gray-400"><?php echo e($match->scheduled_at->format('d/m H:i')); ?></span>
                                                                <?php else: ?>
                                                                    <span class="text-[10px] font-bold text-gray-300">Sin hora</span>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                                <button wire:click="openEditMatchModal(<?php echo e($match->id); ?>)" class="p-1 text-gray-400 active:text-primary">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                                </button>
                                                            </div>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($match->notes)): ?>
                                                                <p class="mb-2 px-3 py-2 rounded-xl bg-primary/5 text-[10px] leading-4 font-bold text-titanium whitespace-pre-line break-words"><?php echo e($match->notes); ?></p>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                            
                                                            <div class="flex items-center justify-between">
                                                                
                                                                <div class="flex flex-1 items-center justify-end gap-1.5 min-w-0 pr-2 <?php echo e($homeWins ? 'font-black text-black' : 'font-bold text-gray-600'); ?>">
                                                                    <?php echo $__env->make('livewire.tournaments._mobile-match-team-logo', ['team' => $match->homeTeam], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                                    <p class="text-xs truncate text-right"><?php echo e($match->homeTeam?->displayName() ?? '—'); ?></p>
                                                                </div>

                                                                
                                                                <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)"
                                                                        class="shrink-0 w-16 py-1.5 rounded-xl text-center font-black text-sm transition-all
                                                                            <?php echo e($match->status === 'completed' ? 'bg-gray-100 text-titanium' : 
                                                                               ($match->status === 'in_progress' ? 'bg-red-500 text-white shadow-md' : 'bg-gray-50 border border-dashed border-gray-300 text-gray-400')); ?>">
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed' || $match->status === 'in_progress'): ?>
                                                                        <?php echo e($match->home_score ?? 0); ?> - <?php echo e($match->away_score ?? 0); ?>

                                                                    <?php else: ?>
                                                                        VS
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                </button>

                                                                
                                                                <div class="flex flex-1 items-center gap-1.5 min-w-0 pl-2 <?php echo e($awayWins ? 'font-black text-black' : 'font-bold text-gray-600'); ?>">
                                                                    <?php echo $__env->make('livewire.tournaments._mobile-match-team-logo', ['team' => $match->awayTeam], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                                    <p class="text-xs truncate text-left"><?php echo e($match->awayTeam?->displayName() ?? '—'); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div x-show="tab === 'teams' && <?php echo e($teams->isNotEmpty() || $matches->isNotEmpty() ? 'true' : 'false'); ?>" x-cloak class="space-y-4 pb-4">
                    <div class="flex items-center justify-between px-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Total: <span class="text-titanium"><?php echo e($teams->count()); ?></span>
                        </p>
                        <button wire:click="openCreateTeamModal" class="px-3 py-1.5 bg-primary/10 text-primary text-[10px] font-black uppercase rounded-lg active:scale-95">+ Añadir</button>
                    </div>

                    <?php
                        $hasGroups = $teams->contains(fn($t) => filled($t->group_label));
                        $teamGroups = $hasGroups
                            ? $teams->sortBy([['group_label','asc'],['seed','asc'],['name_override','asc']])->groupBy(fn($t) => $t->group_label ?: '')
                            : collect(['' => $teams->sortBy([['seed','asc'],['name_override','asc']])]);
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupTeams): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white-pure rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasGroups): ?>
                                <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100">
                                    <h3 class="text-xs font-black text-titanium">Grupo <?php echo e($groupKey ?: 'Sin asignar'); ?></h3>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="divide-y divide-gray-50">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="p-3 flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->logo): ?>
                                                <img src="<?php echo e(asset('storage/' . $team->logo)); ?>" class="w-8 h-8 rounded-lg object-contain shrink-0 bg-white border border-gray-50">
                                            <?php elseif($team->team?->logo): ?>
                                                <img src="<?php echo e(Storage::url($team->team->logo)); ?>" class="w-8 h-8 rounded-lg object-contain shrink-0 bg-white border border-gray-50">
                                            <?php else: ?>
                                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                                    <span class="text-xs font-black text-gray-400"><?php echo e(mb_strtoupper(mb_substr($team->displayName(), 0, 1))); ?></span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-titanium truncate"><?php echo e($team->displayName()); ?></p>
                                                <div class="flex gap-1 mt-0.5">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->seed): ?>
                                                        <span class="text-[9px] bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded font-bold">Cbza <?php echo e($team->seed); ?></span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->external_team): ?>
                                                        <span class="text-[9px] bg-amber-50 text-amber-600 px-1.5 py-0.5 rounded font-bold">Ext</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <button wire:click="openEditTeamModal(<?php echo e($team->id); ?>)" class="p-2 text-gray-400 active:bg-gray-100 rounded-xl">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div x-show="tab === 'standings'" x-cloak class="space-y-4 pb-4">
                    <button wire:click="recalculateStandings" class="w-full py-3 bg-white border border-gray-200 text-titanium font-black text-xs rounded-2xl active:scale-95 transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Recalcular
                    </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($standings->isNotEmpty()): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $standings->groupBy(fn($s) => $s->phase?->name ?? 'General'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseName => $phaseStandings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseStandings->groupBy('group_label'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $groupStandings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white-pure rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                                    <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100">
                                        <h3 class="text-xs font-black text-titanium"><?php echo e($phaseName); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($groupLabel): ?>· Grupo <?php echo e($groupLabel); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></h3>
                                    </div>
                                    <div class="overflow-x-auto no-scrollbar">
                                        <table class="w-full text-left border-collapse">
                                            <thead>
                                                <tr class="border-b border-gray-100">
                                                    <th class="px-3 py-2 text-[10px] font-bold text-gray-400 w-8">#</th>
                                                    <th class="px-2 py-2 text-[10px] font-bold text-gray-400">Equipo</th>
                                                    <th class="px-2 py-2 text-[10px] font-black text-primary text-center w-10">Pts</th>
                                                    <th class="px-2 py-2 text-[10px] font-bold text-gray-400 text-center w-8">PJ</th>
                                                    <th class="px-2 py-2 text-[10px] font-bold text-gray-400 text-center w-8">DF</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupStandings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $standing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="<?php echo e($loop->first ? 'bg-primary/5' : ''); ?>">
                                                        <td class="px-3 py-2.5">
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->first): ?>
                                                                <span class="w-5 h-5 rounded-full bg-primary text-white text-[10px] font-black flex items-center justify-center">1</span>
                                                            <?php else: ?>
                                                                <span class="text-xs font-bold text-gray-400 flex justify-center"><?php echo e($standing->position); ?></span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </td>
                                                        <td class="px-2 py-2.5 font-bold text-xs text-titanium truncate max-w-[120px]">
                                                            <?php echo e($standing->tournamentTeam?->displayName() ?? '—'); ?>

                                                        </td>
                                                        <td class="px-2 py-2.5 text-center text-sm font-black text-primary"><?php echo e($standing->points); ?></td>
                                                        <td class="px-2 py-2.5 text-center text-[11px] font-bold text-gray-500"><?php echo e($standing->played); ?></td>
                                                        <td class="px-2 py-2.5 text-center text-[11px] font-bold text-gray-500"><?php echo e($standing->goals_for - $standing->goals_against); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-xs font-bold text-gray-400">Clasificación no disponible aún</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div x-show="tab === 'setup'" x-cloak class="space-y-4 pb-4">
                    <div class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-titanium">Fases del Torneo</h3>
                                <p class="text-[10px] text-gray-400">Define grupos, liga o eliminatorias</p>
                            </div>
                        </div>

                        <button wire:click="openCreatePhaseModal" class="w-full py-3 mb-4 bg-gray-50 border border-gray-200 text-titanium font-black text-xs rounded-2xl active:scale-95 transition-all">
                            + Añadir Fase
                        </button>

                        <div class="space-y-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-100 bg-white">
                                    <div>
                                        <p class="text-xs font-bold text-titanium"><?php echo e($phase->name); ?></p>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase"><?php echo e($phase->typeLabel()); ?></p>
                                    </div>
                                    <button wire:click="openEditPhaseModal(<?php echo e($phase->id); ?>)" class="p-2 bg-gray-50 rounded-lg text-gray-500 active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <a href="<?php echo e(route('tournaments.edit', $tournament)); ?>" class="flex items-center justify-center gap-2 w-full py-3.5 bg-gray-800 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Ajustes Generales del Torneo
                    </a>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasKnockoutPhase): ?>
                    <div x-show="tab === 'bracket'" x-cloak class="space-y-4 pb-4">
                        <?php echo $__env->make('livewire.tournaments._mobile-bracket', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <div x-show="tab === 'stats'" x-cloak class="space-y-4">
                    <a href="<?php echo e(route('tournament.stats', $tournament)); ?>" class="flex flex-col items-center justify-center p-8 bg-amber-50 rounded-3xl border border-amber-100 active:scale-95 transition-all mt-4">
                        <svg class="w-10 h-10 text-amber-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span class="text-sm font-black text-amber-700">Ver Estadísticas Completas</span>
                    </a>
                </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeCategoryId || $tournament->team_type === 'open'): ?>
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 px-2 py-2 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-40">
        <nav class="flex justify-around items-center h-14">
            
            <button @click="tab = 'matches'" class="flex flex-col items-center justify-center w-full h-full gap-1 rounded-xl transition-all" :class="tab === 'matches' ? 'text-primary' : 'text-gray-400 hover:text-gray-600'">
                <div class="relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->where('status', 'in_progress')->count() > 0): ?>
                        <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <span class="text-[9px] font-bold tracking-wide">Partidos</span>
            </button>
            
            
            <button @click="tab = 'teams'" class="flex flex-col items-center justify-center w-full h-full gap-1 rounded-xl transition-all" :class="tab === 'teams' ? 'text-primary' : 'text-gray-400 hover:text-gray-600'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="text-[9px] font-bold tracking-wide">Equipos</span>
            </button>

            
            <button @click="tab = 'standings'" class="flex flex-col items-center justify-center w-full h-full gap-1 rounded-xl transition-all" :class="tab === 'standings' ? 'text-primary' : 'text-gray-400 hover:text-gray-600'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span class="text-[9px] font-bold tracking-wide">Tabla</span>
            </button>

            
            <button @click="tab = 'stats'" class="flex flex-col items-center justify-center w-full h-full gap-1 rounded-xl transition-all" :class="tab === 'stats' ? 'text-primary' : 'text-gray-400 hover:text-gray-600'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-[9px] font-bold tracking-wide">Stats</span>
            </button>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasKnockoutPhase): ?>
                <button type="button" @click="tab = 'bracket'" aria-label="Cuadro eliminatorio"
                        class="flex flex-col items-center justify-center w-full h-full gap-1 rounded-xl transition-all"
                        :class="tab === 'bracket' ? 'text-primary' : 'text-gray-400 hover:text-gray-600'">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h4v4H4zM4 16h4v4H4zM16 10h4v4h-4zM8 6h4v12H8m4-6h4"/></svg>
                    <span class="text-[9px] font-bold tracking-wide">Cuadro</span>
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <button type="button" @click="tab = 'setup'" aria-label="Configuración del torneo"
                    class="flex flex-col items-center justify-center w-full h-full gap-1 rounded-xl transition-all"
                    :class="tab === 'setup' ? 'text-primary' : 'text-gray-400 hover:text-gray-600'">
                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="text-[9px] font-bold tracking-wide">Fases</span>
            </button>
        </nav>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <style>
        .animate-slideUp { animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
    </style>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGoalsModal && $goalsModalMatch): ?>
        <?php
            $gm_homeTeamId = $goalsModalMatch->home_team_id;
            $gm_awayTeamId = $goalsModalMatch->away_team_id;
            $gm_timeline = $goalsForModal->map(fn($g) => (object)[
                'type'    => 'goal', 'minute'  => $g->minute, 'player'  => $g->player, 'team'    => $g->team, 'subtype' => $g->goal_type, 'id'      => $g->id, 'teamId'  => $g->tournament_team_id,
            ])->merge($gmCardsForModal->map(fn($c) => (object)[
                'type'    => 'card', 'minute'  => $c->minute, 'player'  => $c->player, 'team'    => $c->team, 'subtype' => $c->card_type, 'id'      => $c->id, 'teamId'  => $c->tournament_team_id,
            ]))->sortBy(fn($e) => $e->minute ?? 999)->values();
        ?>

        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="closeGoalsModal">
            <div class="bg-gray-50 w-full h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                
                
                <div class="px-4 py-3 bg-white border-b border-gray-100 flex items-center justify-between shrink-0">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Panel de Partido</span>
                    <button wire:click="closeGoalsModal" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                
                <div class="px-4 py-6 bg-white border-b border-gray-100 shrink-0 shadow-sm z-10 relative">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex-1 min-w-0 text-center">
                            <div class="flex justify-center mb-2">
                                <?php echo $__env->make('livewire.tournaments._mobile-match-team-logo', ['team' => $goalsModalMatch->homeTeam, 'logoSize' => 'w-12 h-12'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                            <p class="text-xs font-bold text-gray-500 mb-1 truncate"><?php echo e($goalsModalMatch->homeTeam?->displayName()); ?></p>
                            <span class="text-4xl font-black text-black"><?php echo e($goalsModalMatch->home_score ?? 0); ?></span>
                        </div>
                        <div class="shrink-0 px-3">
                            <span class="text-xl font-black text-gray-300">-</span>
                        </div>
                        <div class="flex-1 min-w-0 text-center">
                            <div class="flex justify-center mb-2">
                                <?php echo $__env->make('livewire.tournaments._mobile-match-team-logo', ['team' => $goalsModalMatch->awayTeam, 'logoSize' => 'w-12 h-12'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                            <p class="text-xs font-bold text-gray-500 mb-1 truncate"><?php echo e($goalsModalMatch->awayTeam?->displayName()); ?></p>
                            <span class="text-4xl font-black text-black"><?php echo e($goalsModalMatch->away_score ?? 0); ?></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-2 mt-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goalsModalMatch->status === 'scheduled' || $goalsModalMatch->status === 'postponed'): ?>
                            <button wire:click="gmStartMatch" class="px-6 py-2.5 rounded-full bg-black text-white text-xs font-black uppercase tracking-wider active:scale-95 transition-transform">Iniciar Partido</button>
                        <?php elseif($goalsModalMatch->status === 'in_progress'): ?>
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-white bg-red-500 px-3 py-1.5 rounded-full animate-pulse"><span class="w-1.5 h-1.5 rounded-full bg-white shrink-0"></span> EN VIVO</span>
                            <button wire:click="gmFinishMatch" class="px-4 py-1.5 rounded-full bg-gray-200 text-gray-700 text-[10px] font-black uppercase tracking-wider active:scale-95">Finalizar</button>
                        <?php elseif($goalsModalMatch->status === 'completed'): ?>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-green-700 bg-green-100 px-3 py-1.5 rounded-full uppercase tracking-wider">Finalizado</span>
                            <button wire:click="gmStartMatch" class="px-3 py-1.5 rounded-full border border-gray-300 text-gray-500 text-[10px] font-bold uppercase active:scale-95">Reabrir</button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="flex-1 overflow-y-auto bg-gray-50 relative pb-40">
                    <div class="p-4 space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $gm_timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $isHome = $event->teamId === $gm_homeTeamId; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($event->type === 'goal' && $gm_deletingGoalId === $event->id) || ($event->type === 'card' && $gm_deletingCardId === $event->id)): ?>
                                <div class="bg-red-50 border border-red-200 rounded-2xl p-3 flex items-center justify-between">
                                    <span class="text-xs font-bold text-red-700">¿Eliminar?</span>
                                    <div class="flex gap-2">
                                        <button wire:click="<?php echo e($event->type === 'goal' ? 'gmCancelDeleteGoal' : 'gmCancelDeleteCard'); ?>" class="px-3 py-1.5 text-xs font-bold bg-white rounded-lg border border-gray-200">No</button>
                                        <button wire:click="<?php echo e($event->type === 'goal' ? 'gmDeleteGoal' : 'gmDeleteCard'); ?>" class="px-3 py-1.5 text-xs font-bold text-white bg-red-500 rounded-lg">Sí</button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 flex items-center gap-3">
                                    <span class="w-8 text-center text-xs font-black text-gray-400"><?php echo e($event->minute ? $event->minute . "'" : '—'); ?></span>
                                    <span class="text-lg">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'goal'): ?> ⚽
                                        <?php elseif($event->subtype === 'yellow'): ?> 🟨
                                        <?php elseif($event->subtype === 'red'): ?> 🟥
                                        <?php else: ?> 🟨🟥 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-titanium truncate">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->player): ?>
                                                <?php echo e($event->player->dorsal ? '#' . $event->player->dorsal . ' ' : ''); ?><?php echo e($event->player->surname); ?> <?php echo e($event->player->name); ?>

                                            <?php else: ?>
                                                <span class="italic text-gray-400">Sin jugador asignado</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'goal' && $event->subtype === 'own_goal'): ?> <span class="text-red-500 font-normal">(p.p.)</span>
                                            <?php elseif($event->type === 'goal' && $event->subtype === 'penalty'): ?> <span class="text-blue-500 font-normal">(pen.)</span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                    </div>
                                    <button wire:click="<?php echo e($event->type === 'goal' ? 'gmConfirmDeleteGoal' : 'gmConfirmDeleteCard'); ?>(<?php echo e($event->id); ?>)" class="p-2 text-gray-300 active:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-xs font-bold text-center text-gray-400 py-6">Sin eventos registrados aún.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.1)] z-20">
                    <div class="flex gap-2 mb-3">
                        <button wire:click="gmSetAction('goal')" class="flex-1 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all <?php echo e($gm_action === 'goal' ? 'bg-black text-white' : 'bg-gray-100 text-gray-400'); ?>">⚽ Gol</button>
                        <button wire:click="gmSetAction('card')" class="flex-1 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all <?php echo e($gm_action === 'card' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-400'); ?>">🟨 Tarjeta</button>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gmMatchTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isSelected = (string)$gm_team_id === (string)$t->id; ?>
                            <button wire:click="gmSelectTeam(<?php echo e($t->id); ?>)" class="flex items-center justify-center gap-2 min-w-0 py-2.5 px-2 rounded-xl text-[10px] font-black uppercase transition-all <?php echo e($isSelected ? 'bg-primary text-white border-2 border-primary' : 'bg-white border-2 border-gray-100 text-gray-500'); ?>">
                                <?php echo $__env->make('livewire.tournaments._mobile-match-team-logo', ['team' => $t, 'logoSize' => 'w-6 h-6'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <span class="truncate"><?php echo e($t->displayName()); ?></span>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_team_id): ?>
                        <div class="flex gap-2 mb-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_action === 'goal'): ?>
                                <select wire:model="gm_goal_type" class="flex-1 bg-gray-50 border-0 rounded-xl text-xs font-bold px-3 py-2.5 focus:ring-0">
                                    <option value="normal">Normal</option><option value="penalty">Penalti</option><option value="own_goal">Propia P.</option>
                                </select>
                            <?php else: ?>
                                <select wire:model="gm_card_type" class="flex-1 bg-amber-50 border-0 rounded-xl text-xs font-bold px-3 py-2.5 focus:ring-0 text-amber-800">
                                    <option value="yellow">Amarilla</option><option value="red">Roja</option><option value="double_yellow">2ª Amarilla</option>
                                </select>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <input wire:model="gm_minute" type="number" placeholder="Min" class="w-16 bg-gray-50 border-0 rounded-xl text-xs font-bold text-center px-2 py-2.5 focus:ring-0">
                        </div>
                        <button wire:click="<?php echo e($gm_action === 'goal' ? 'gmAddGoal' : 'gmAddCard'); ?>" class="w-full py-3.5 rounded-xl text-sm font-black text-white active:scale-95 transition-all shadow-md <?php echo e($gm_action === 'goal' ? 'bg-primary' : 'bg-amber-500'); ?>">
                            <?php echo e($gm_action === 'goal' ? '+ Añadir Gol Rápido' : '+ Añadir Tarjeta'); ?>

                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showMatchModal): ?>
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showMatchModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="font-black text-lg text-titanium"><?php echo e($editingMatchId ? 'Editar Partido' : 'Nuevo Partido'); ?></h3>
                    <button wire:click="$set('showMatchModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Local *</label>
                        <select wire:model="match_home_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            <option value="">Seleccionar...</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Visitante *</label>
                        <select wire:model="match_away_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            <option value="">Seleccionar...</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha y Hora</label>
                            <input wire:model="match_scheduled" type="datetime-local" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all"/>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Estado</label>
                            <select wire:model="match_status" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                                <option value="scheduled">Programado</option><option value="in_progress">En curso</option><option value="completed">Completado</option><option value="cancelled">Cancelado</option><option value="postponed">Aplazado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showMatchModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95">Cancelar</button>
                    <button wire:click="saveMatch" class="flex-[2] py-3.5 bg-primary text-white font-black text-xs rounded-2xl active:scale-95 shadow-md">Guardar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGenerateModal): ?>
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showGenerateModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="font-black text-lg text-indigo-700">Generar Partidos</h3>
                    <button wire:click="$set('showGenerateModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5 space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fase *</label>
                        <select wire:model.live="generate_phase_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-indigo-400 focus:bg-white transition-all">
                            <option value="">Selecciona una fase</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($phase->id); ?>"><?php echo e($phase->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Vueltas</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border-2 transition-all <?php echo e($generate_legs == 1 ? 'border-indigo-500 bg-indigo-50' : 'border-gray-100 bg-white'); ?>">
                                <input type="radio" wire:model="generate_legs" value="1" class="sr-only">
                                <span class="text-sm font-black <?php echo e($generate_legs == 1 ? 'text-indigo-700' : 'text-gray-400'); ?>">1 Vuelta</span>
                            </label>
                            <label class="flex flex-col items-center justify-center p-3 rounded-2xl border-2 transition-all <?php echo e($generate_legs == 2 ? 'border-indigo-500 bg-indigo-50' : 'border-gray-100 bg-white'); ?>">
                                <input type="radio" wire:model="generate_legs" value="2" class="sr-only">
                                <span class="text-sm font-black <?php echo e($generate_legs == 2 ? 'text-indigo-700' : 'text-gray-400'); ?>">2 Vueltas</span>
                            </label>
                        </div>
                    </div>

                    <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-red-100 bg-red-50/50 cursor-pointer">
                        <span class="text-xs font-bold text-red-700">Borrar partidos existentes de esta fase</span>
                        <input type="checkbox" wire:model="generate_clear" class="w-5 h-5 text-red-500 border-red-300 rounded focus:ring-red-500">
                    </label>
                </div>

                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showGenerateModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95">Cancelar</button>
                    <button wire:click="generateMatches" class="flex-[2] py-3.5 bg-indigo-600 text-white font-black text-xs rounded-2xl active:scale-95 shadow-md">Generar Calendario</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showTeamModal): ?>
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showTeamModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="font-black text-lg text-titanium"><?php echo e($editingTeamId ? 'Editar Equipo' : 'Nuevo Equipo'); ?></h3>
                    <button wire:click="$set('showTeamModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <?php echo $__env->make('livewire.tournaments._recent-teams', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingTeamId || $teamCreationMode === 'new'): ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type !== 'open'): ?>
                    <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-2xl border border-gray-100">
                        <span class="text-xs font-black text-titanium">Equipo Externo</span>
                        <button wire:click="$set('external_team', <?php echo e($external_team ? 'false' : 'true'); ?>)" class="relative inline-flex items-center w-12 h-7 rounded-full transition-colors <?php echo e($external_team ? 'bg-primary' : 'bg-gray-300'); ?>">
                            <span class="inline-block w-5 h-5 bg-white rounded-full shadow transition-transform <?php echo e($external_team ? 'translate-x-6' : 'translate-x-1'); ?>"></span>
                        </button>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($external_team): ?>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre del equipo *</label>
                            <input wire:model="name_override" type="text" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name_override'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Equipo de la escuela</label>
                            <select wire:model="team_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schoolTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($st->id); ?>"><?php echo e($st->team); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Escudo / Logo</label>
                        <input wire:model="team_logo_upload" type="file" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"/>
                        <div wire:loading wire:target="team_logo_upload" class="text-[10px] text-primary mt-1 font-bold">Subiendo...</div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_logo_upload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Contacto</label>
                            <input wire:model="team_contact_name" type="text" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Teléfono</label>
                            <input wire:model="team_contact_phone" type="tel" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_contact_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email de acceso <?php echo e($tournament->team_type === 'open' ? '*' : '(opcional)'); ?></label>
                        <input wire:model="team_email" type="email" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary"/>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Contraseña <?php echo e($editingTeamId ? '(dejar vacía para mantenerla)' : ($tournament->team_type === 'open' ? '*' : '(opcional)')); ?></label>
                        <input wire:model="team_password" type="password" autocomplete="new-password" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary"/>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Grupo</label>
                            <input wire:model="team_group" type="text" placeholder="A, B..." class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white text-center uppercase"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Cabeza de Serie</label>
                            <input wire:model="team_seed" type="number" placeholder="1" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white text-center"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_seed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2" data-team-modal-footer>
                    <button wire:click="$set('showTeamModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95">Cancelar</button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingTeamId || $teamCreationMode === 'new'): ?>
                        <button wire:click="saveTeam" class="flex-[2] py-3.5 bg-primary text-white font-black text-xs rounded-2xl active:scale-95 shadow-md">Guardar Equipo</button>
                    <?php else: ?>
                        <?php echo $__env->make('livewire.tournaments._recent-teams-submit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/tournaments/show_mobile.blade.php ENDPATH**/ ?>