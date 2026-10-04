<div class="min-h-screen bg-gray-50 pb-28 relative" x-data="{ tab: '<?php echo e($phases->isNotEmpty() ? 'matches' : 'setup'); ?>' }">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('message')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 left-4 z-[60] bg-green-50 border-l-4 border-green-500 rounded-2xl p-4 shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <p class="text-sm font-bold text-green-800"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="fixed top-20 right-4 left-4 z-[60] bg-red-50 border-l-4 border-red-500 rounded-2xl p-4 shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-bold text-red-800"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center gap-3">
        <a href="<?php echo e(route('tournaments.index')); ?>" wire:navigate 
           class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="min-w-0 flex-1">
            <h1 class="font-black text-lg text-titanium truncate"><?php echo e($tournament->name); ?></h1>
            <?php
                $statusStyles = [
                    'draft'             => 'text-gray-500',
                    'registration_open' => 'text-blue-600',
                    'in_progress'       => 'text-amber-600',
                    'completed'         => 'text-green-600',
                    'cancelled'         => 'text-red-600',
                ];
                $statusLabels = [
                    'draft'             => 'Borrador',
                    'registration_open' => 'Inscripciones abiertas',
                    'in_progress'       => 'En curso',
                    'completed'         => 'Finalizado',
                    'cancelled'         => 'Cancelado',
                ];
            ?>
            <p class="text-[10px] font-bold uppercase tracking-wider <?php echo e($statusStyles[$tournament->status] ?? 'text-gray-500'); ?>">
                <?php echo e($statusLabels[$tournament->status] ?? $tournament->status); ?>

            </p>
        </div>
        <button type="button"
                wire:click="exportPdf"
                wire:loading.attr="disabled"
                wire:target="exportPdf"
                class="p-2 rounded-full bg-red-50 text-red-600 active:scale-95 transition-all shrink-0 disabled:opacity-60"
                title="Descargar PDF">
            <svg wire:loading.remove wire:target="exportPdf" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M8 6a4 4 0 118 0v6"/></svg>
            <svg wire:loading wire:target="exportPdf" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke-width="4"/><path stroke-linecap="round" stroke-width="4" d="M22 12a10 10 0 00-10-10"/></svg>
        </button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->logo): ?>
            <img src="<?php echo e(Storage::url($tournament->logo)); ?>" class="w-10 h-10 rounded-xl object-cover border border-gray-100 shrink-0">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </header>

    <main class="p-4 space-y-4">

        
        <div class="bg-white-pure rounded-2xl p-1.5 shadow-sm border border-gray-100 mb-4 sticky top-[68px] z-30">
            <nav class="flex gap-1 overflow-x-auto no-scrollbar pb-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phases->isNotEmpty()): ?>
                    <button @click="tab = 'matches'" :class="tab === 'matches' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                            class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                        Partidos
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->isNotEmpty()): ?>
                            <span :class="tab === 'matches' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500'" class="px-2 py-0.5 rounded-full text-[10px]"><?php echo e($matches->count()); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </button>
                    <button @click="tab = 'teams'" :class="tab === 'teams' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                            class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                        Equipos
                        <span :class="tab === 'teams' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500'" class="px-2 py-0.5 rounded-full text-[10px]"><?php echo e($teams->count()); ?></span>
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($standings->isNotEmpty() || ($hasLeaguePhase && $teams->isNotEmpty())): ?>
                        <button @click="tab = 'standings'" :class="tab === 'standings' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                                class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                            Clasificación
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasKnockoutPhase): ?>
                        <button @click="tab = 'bracket'" :class="tab === 'bracket' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                                class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                            Cuadro
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <button @click="tab = 'stats'" :class="tab === 'stats' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                            class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                        Estadísticas
                    </button>
                    <button @click="tab = 'referees'" :class="tab === 'referees' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                            class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                        Árbitros
                        <span :class="tab === 'referees' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500'" class="px-2 py-0.5 rounded-full text-[10px]"><?php echo e($assignedReferees->count()); ?></span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button @click="tab = 'setup'" :class="tab === 'setup' ? 'bg-primary text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Configurar
                </button>
            </nav>
        </div>

        
        
        
        <div x-show="tab === 'matches'" x-cloak class="space-y-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->isEmpty()): ?>
                <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 rounded-full bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-titanium mb-2">Aún no hay partidos</h3>
                    <p class="text-xs text-gray-500 font-medium mb-6">Genera los encuentros de las fases automáticamente o añade uno manualmente.</p>
                    
                    <div class="flex flex-col gap-3">
                        <button wire:click="openGenerateMatchesModal" class="w-full py-3.5 bg-indigo-600 text-white font-bold text-sm rounded-xl active:scale-95 transition-all shadow-md">
                            Generar Automáticamente
                        </button>
                        <button wire:click="openCreateMatchModal" class="w-full py-3.5 bg-gray-50 border border-gray-200 text-titanium font-bold text-sm rounded-xl active:scale-95 transition-all">
                            Añadir Manual
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center justify-between px-1">
                    <p class="text-xs font-bold text-gray-500">
                        <span class="text-black-deep"><?php echo e($matches->where('status', 'completed')->count()); ?></span> de <span class="text-black-deep"><?php echo e($matches->count()); ?></span> jugados
                    </p>
                    <div class="flex gap-2">
                        <button wire:click="openGenerateMatchesModal" class="p-2 rounded-xl bg-indigo-50 text-indigo-600 active:scale-95 transition-all" title="Generar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.78 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </button>
                        <button wire:click="openCreateMatchModal" class="p-2 rounded-xl bg-primary/10 text-primary active:scale-95 transition-all" title="Manual">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $matches->sortBy([['phase_id', 'asc'], ['round', 'asc'], ['match_number', 'asc'], ['scheduled_at', 'asc']])->groupBy(fn($m) => $m->phase_id ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $phaseMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $phase     = $phaseMatches->first()?->phase;
                            $phaseName = $phase?->name ?? 'Sin fase';
                        ?>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-gray-200 flex items-center justify-center text-[10px] font-black"><?php echo e($phase?->order ?? '-'); ?></span>
                                <h3 class="font-black text-sm text-titanium uppercase tracking-wider"><?php echo e($phaseName); ?></h3>
                                <div class="flex-1 h-px bg-gray-200"></div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseMatches->groupBy(fn($m) => $m->round ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $round => $roundMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="space-y-3 pl-2 border-l-2 border-gray-100">
                                    <h4 class="text-xs font-bold text-gray-400 pl-2">
                                        <?php echo e($round > 0 ? 'Jornada/Ronda ' . $round : 'Sin jornada'); ?>

                                    </h4>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roundMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $matchGroup = $match->phase?->type === 'group'
                                                ? ($match->homeTeam?->group_label ?? $match->awayTeam?->group_label)
                                                : null;
                                        ?>
                                        <article class="bg-white-pure rounded-2xl p-4 shadow-sm border <?php echo e($match->status === 'in_progress' ? 'border-red-200 bg-red-50/10' : 'border-gray-100'); ?> relative">
                                            
                                            
                                            <div class="flex justify-between items-center mb-3">
                                                <div class="flex items-center gap-1.5 min-w-0">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'in_progress'): ?>
                                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-red-600 bg-red-100 px-2 py-0.5 rounded-full animate-pulse">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span> EN VIVO
                                                        </span>
                                                    <?php elseif($match->scheduled_at): ?>
                                                        <span class="text-[10px] font-bold text-gray-500"><?php echo e($match->scheduled_at->format('d/m · H:i')); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-[10px] font-bold text-gray-400 italic">Por definir</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matchGroup): ?>
                                                        <span class="inline-flex items-center gap-1 text-[10px] font-black text-primary bg-primary/10 border border-primary/20 px-2 py-0.5 rounded-full shrink-0">
                                                            Grupo <?php echo e($matchGroup); ?>

                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->location): ?>
                                                    <span class="text-[10px] font-semibold text-gray-400 truncate max-w-[120px]"><?php echo e($match->location); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>

                                            
                                            <div class="flex items-center justify-between gap-2 mb-3">
                                                <p class="flex-1 text-right text-sm font-black text-titanium leading-tight truncate"><?php echo e($match->homeTeam?->displayName() ?? '—'); ?></p>
                                                
                                                <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)"
                                                        class="shrink-0 w-20 py-2 rounded-xl text-center font-black text-lg transition-all active:scale-95
                                                        <?php echo e($match->status === 'completed' ? 'bg-gray-100 text-titanium' : ($match->status === 'in_progress' ? 'bg-red-500 text-white shadow-md shadow-red-200' : 'bg-gray-50 border-2 border-dashed border-gray-200 text-gray-400')); ?>">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                                                        <?php echo e($match->home_score); ?> - <?php echo e($match->away_score); ?>

                                                    <?php elseif($match->status === 'in_progress'): ?>
                                                        <?php echo e($match->home_score ?? 0); ?> - <?php echo e($match->away_score ?? 0); ?>

                                                    <?php elseif($match->status === 'cancelled'): ?>
                                                        <span class="text-[10px] text-red-400">CANC</span>
                                                    <?php elseif($match->status === 'postponed'): ?>
                                                        <span class="text-[10px] text-gray-400">APLAZ</span>
                                                    <?php else: ?>
                                                        <span class="text-xs">vs</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </button>

                                                <p class="flex-1 text-left text-sm font-black text-titanium leading-tight truncate"><?php echo e($match->awayTeam?->displayName() ?? '—'); ?></p>
                                            </div>

                                            
                                            <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                                                <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)" class="text-[10px] font-bold text-primary px-2 py-1 rounded bg-primary/10">⚽ Eventos</button>
                                                
                                                <div class="flex gap-2">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'scheduled' || $match->status === 'postponed'): ?>
                                                        <button wire:click="openPostponeModal(<?php echo e($match->id); ?>)" class="p-1.5 text-gray-400 hover:text-amber-500 rounded-lg bg-gray-50">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        </button>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <button wire:click="openEditMatchModal(<?php echo e($match->id); ?>)" class="p-1.5 text-gray-400 hover:text-blue-500 rounded-lg bg-gray-50">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <button wire:click="confirmDeleteMatch(<?php echo e($match->id); ?>)" class="p-1.5 text-gray-400 hover:text-red-500 rounded-lg bg-gray-50">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasKnockoutPhase): ?>
            <div x-show="tab === 'bracket'" x-cloak class="space-y-4">
                <?php
                    $getRoundLabel = function(int $roundIndex, int $totalRounds): string {
                        $fromFinal = $totalRounds - 1 - $roundIndex;
                        return match($fromFinal) {
                            0 => 'Final',
                            1 => 'Semifinal',
                            2 => 'Cuartos',
                            3 => 'Octavos',
                            4 => '16avos',
                            default => 'Ronda ' . ($roundIndex + 1),
                        };
                    };
                    $matchH = 76; 
                    $matchW = 200; 
                    $gapX   = 28; 
                    $unit   = $matchH + 12; 
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracketData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $bracket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white-pure rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                            <div>
                                <h3 class="font-black text-sm text-titanium uppercase tracking-wider"><?php echo e($bracket['phase']->name); ?></h3>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5"><?php echo e($bracket['phase']->typeLabel()); ?></p>
                            </div>
                            <button wire:click="openBracketModal(<?php echo e($phaseId); ?>)" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-600 active:scale-95 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$bracket['hasMatches']): ?>
                                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <p class="text-xs font-bold text-titanium mb-3">Sin cuadro generado</p>
                                    <button wire:click="openBracketModal(<?php echo e($phaseId); ?>)" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl active:scale-95">Generar Cuadro</button>
                                </div>
                            <?php else: ?>
                                <?php
                                    $numFirstRound = $bracket['numFirstRoundMatches'];
                                    $totalRounds   = $bracket['totalRounds'];
                                    $firstRound    = $bracket['firstRound'];
                                    $maxRound      = $bracket['maxRound'];
                                    $containerH    = max($numFirstRound, 1) * $unit;
                                    
                                    $firstRoundUsedTeams = collect($bracket['rounds'][$firstRound] ?? [])
                                        ->flatMap(fn($m) => [$m->home_team_id, $m->away_team_id])
                                        ->filter()
                                        ->unique();
                                ?>

                                <div class="overflow-x-auto no-scrollbar pb-6 relative">
                                    <div class="flex min-w-max" style="align-items: flex-start;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracket['rounds']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roundNum => $roundMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $roundIndex = $roundNum - $firstRound;
                                                $roundLabel = $getRoundLabel($roundIndex, $totalRounds);
                                                $isLast     = ($roundNum === $maxRound);
                                            ?>
                                            
                                            <div style="width: <?php echo e($matchW); ?>px; flex-shrink: 0;">
                                                <div class="text-center mb-4">
                                                    <span class="inline-block px-3 py-1.5 rounded-full text-[10px] font-black tracking-wider uppercase <?php echo e($isLast ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-500'); ?>">
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
                                                        
                                                        <div class="absolute left-0 right-0" style="top: <?php echo e($topPx); ?>px;">
                                                            <div class="bg-white border <?php echo e($match->status === 'in_progress' ? 'border-red-400' : 'border-gray-200'); ?> rounded-xl shadow-sm overflow-hidden flex flex-col relative" style="height: <?php echo e($matchH); ?>px;">
                                                                
                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'in_progress'): ?>
                                                                    <div class="absolute top-0 right-0 px-1.5 py-0.5 bg-red-500 text-white text-[8px] font-black rounded-bl-lg z-10 animate-pulse">EN VIVO</div>
                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                                <div class="flex-1 flex items-center justify-between px-2 <?php echo e($homeWins ? 'bg-green-50' : 'bg-white'); ?> border-b border-gray-100 relative">
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($roundNum === $firstRound && $match->status === 'scheduled'): ?>
                                                                        <select @change="$wire.assignTeamToSlot(<?php echo e($match->id); ?>, 'home', $event.target.value || null)" class="w-full h-full text-[10px] font-bold text-gray-600 bg-transparent border-none p-0 focus:ring-0 appearance-none pr-4">
                                                                            <option value="">-- Asignar --</option>
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$firstRoundUsedTeams->reject(fn($id)=>$id===($match->home_team_id??0))->contains($t->id) && $t->id !== ($match->away_team_id??0)): ?>
                                                                                    <option value="<?php echo e($t->id); ?>" <?php echo e($match->home_team_id == $t->id ? 'selected' : ''); ?>><?php echo e($t->displayName()); ?></option>
                                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                        </select>
                                                                    <?php else: ?>
                                                                        <div class="flex items-center gap-1.5 overflow-hidden">
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam?->logo): ?>
                                                                                <img src="<?php echo e(asset('storage/'.$match->homeTeam->logo)); ?>" class="w-4 h-4 rounded object-cover shrink-0">
                                                                            <?php elseif($match->homeTeam?->team?->logo): ?>
                                                                                <img src="<?php echo e(Storage::url($match->homeTeam->team->logo)); ?>" class="w-4 h-4 rounded object-cover shrink-0">
                                                                            <?php else: ?>
                                                                                <div class="w-4 h-4 bg-gray-100 rounded flex items-center justify-center shrink-0">
                                                                                    <span class="text-[8px] font-black text-gray-500"><?php echo e(mb_strtoupper(mb_substr($match->homeTeam?->displayName()??'?',0,1))); ?></span>
                                                                                </div>
                                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            <span class="text-[11px] font-bold text-gray-800 truncate"><?php echo e($match->homeTeam?->displayName() ?? 'Por definir'); ?></span>
                                                                        </div>
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                                    <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)" class="font-black text-xs min-w-[20px] text-center <?php echo e($homeWins ? 'text-green-600' : 'text-gray-900'); ?>">
                                                                        <?php echo e($match->status === 'completed' || $match->status === 'in_progress' ? ($match->home_score ?? 0) : '-'); ?>

                                                                    </button>
                                                                </div>

                                                                <div class="flex-1 flex items-center justify-between px-2 <?php echo e($awayWins ? 'bg-green-50' : 'bg-gray-50'); ?> relative">
                                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($roundNum === $firstRound && $match->status === 'scheduled'): ?>
                                                                        <select @change="$wire.assignTeamToSlot(<?php echo e($match->id); ?>, 'away', $event.target.value || null)" class="w-full h-full text-[10px] font-bold text-gray-600 bg-transparent border-none p-0 focus:ring-0 appearance-none pr-4">
                                                                            <option value="">-- Asignar --</option>
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php if(!$firstRoundUsedTeams->reject(fn($id)=>$id===($match->away_team_id??0))->contains($t->id) && $t->id !== ($match->home_team_id??0)): ?>
                                                                                    <option value="<?php echo e($t->id); ?>" <?php echo e($match->away_team_id == $t->id ? 'selected' : ''); ?>><?php echo e($t->displayName()); ?></option>
                                                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                        </select>
                                                                    <?php else: ?>
                                                                        <div class="flex items-center gap-1.5 overflow-hidden">
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam?->logo): ?>
                                                                                <img src="<?php echo e(asset('storage/'.$match->awayTeam->logo)); ?>" class="w-4 h-4 rounded object-cover shrink-0">
                                                                            <?php elseif($match->awayTeam?->team?->logo): ?>
                                                                                <img src="<?php echo e(Storage::url($match->awayTeam->team->logo)); ?>" class="w-4 h-4 rounded object-cover shrink-0">
                                                                            <?php else: ?>
                                                                                <div class="w-4 h-4 bg-gray-100 rounded flex items-center justify-center shrink-0">
                                                                                    <span class="text-[8px] font-black text-gray-500"><?php echo e(mb_strtoupper(mb_substr($match->awayTeam?->displayName()??'?',0,1))); ?></span>
                                                                                </div>
                                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                            <span class="text-[11px] font-bold text-gray-800 truncate"><?php echo e($match->awayTeam?->displayName() ?? 'Por definir'); ?></span>
                                                                        </div>
                                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                                    <button wire:click="openGoalsModal(<?php echo e($match->id); ?>)" class="font-black text-xs min-w-[20px] text-center <?php echo e($awayWins ? 'text-green-600' : 'text-gray-900'); ?>">
                                                                        <?php echo e($match->status === 'completed' || $match->status === 'in_progress' ? ($match->away_score ?? 0) : '-'); ?>

                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed' && $mWinner && !$isLast): ?>
                                                                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 z-10">
                                                                    <button wire:click="advanceWinner(<?php echo e($match->id); ?>)" class="bg-gray-900 text-white rounded-full p-1 shadow-md hover:bg-black active:scale-95">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isLast): ?>
                                                <?php
                                                    $nextRoundMatches = $bracket['rounds'][$roundNum + 1] ?? collect();
                                                    $nextCount = $nextRoundMatches->count();
                                                ?>
                                                <div style="width: <?php echo e($gapX); ?>px; flex-shrink: 0; position: relative; height: <?php echo e($containerH); ?>px;">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($ci = 0; $ci < $nextCount; $ci++): ?>
                                                        <?php
                                                            $slotMult   = (int) pow(2, $roundIndex);
                                                            $topCenter  = (int)(($ci * 2 + 0.5) * $unit * $slotMult);
                                                            $botCenter  = (int)(($ci * 2 + 1.5) * $unit * $slotMult);
                                                            $midCenter  = (int)(($ci + 0.5) * $unit * (int)pow(2, $roundIndex + 1));
                                                        ?>
                                                        <div style="position: absolute; left: 0; top: <?php echo e($topCenter); ?>px; width: 50%; height: <?php echo e(max($botCenter - $topCenter, 2)); ?>px; border-right: 2px solid #e5e7eb; border-top: 2px solid #e5e7eb; border-bottom: 2px solid #e5e7eb; border-radius: 0 4px 4px 0;"></div>
                                                        <div style="position: absolute; left: 50%; top: <?php echo e($midCenter); ?>px; width: 50%; height: 2px; background: #e5e7eb;"></div>
                                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bracket['thirdPlace']): ?>
                                <?php $tp = $bracket['thirdPlace']; ?>
                                <div class="mt-4 pt-4 border-t border-gray-100 bg-amber-50/30 rounded-xl p-3">
                                    <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-wider mb-2 text-center">Tercer Puesto</h4>
                                    <div class="bg-white border border-amber-200 rounded-xl shadow-sm overflow-hidden flex flex-col mx-auto max-w-xs">
                                        <div class="flex-1 flex items-center justify-between px-3 py-2 border-b border-gray-100">
                                            <span class="text-[11px] font-bold text-gray-800 truncate"><?php echo e($tp->homeTeam?->displayName() ?? 'Por definir'); ?></span>
                                            <button wire:click="openGoalsModal(<?php echo e($tp->id); ?>)" class="font-black text-sm w-8 text-center"><?php echo e($tp->status === 'completed' ? $tp->home_score : '-'); ?></button>
                                        </div>
                                        <div class="flex-1 flex items-center justify-between px-3 py-2 bg-gray-50">
                                            <span class="text-[11px] font-bold text-gray-800 truncate"><?php echo e($tp->awayTeam?->displayName() ?? 'Por definir'); ?></span>
                                            <button wire:click="openGoalsModal(<?php echo e($tp->id); ?>)" class="font-black text-sm w-8 text-center"><?php echo e($tp->status === 'completed' ? $tp->away_score : '-'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div x-show="tab === 'teams'" x-cloak class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <p class="text-xs font-bold text-gray-500">
                    <span class="text-black-deep"><?php echo e($teams->count()); ?></span> equipos
                </p>
                <button wire:click="openCreateTeamModal" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl shadow-sm active:scale-95 transition-all">
                    + Inscribir equipo
                </button>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teams->isEmpty()): ?>
                <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-titanium mb-2">No hay equipos</h3>
                    <p class="text-xs text-gray-500 font-medium">Añade los equipos que van a competir en este torneo.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="bg-white-pure rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden">
                            <div class="flex items-center gap-3 border-b border-gray-50 pb-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->logo): ?>
                                    <img src="<?php echo e(asset('storage/' . $team->logo)); ?>" class="w-12 h-12 rounded-xl object-cover border border-gray-100 shadow-sm">
                                <?php elseif($team->team?->logo): ?>
                                    <img src="<?php echo e(Storage::url($team->team->logo)); ?>" class="w-12 h-12 rounded-xl object-cover border border-gray-100 shadow-sm">
                                <?php else: ?>
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 text-gray-400 flex items-center justify-center font-black text-sm border border-gray-100">
                                        <?php echo e(mb_strtoupper(mb_substr($team->displayName(), 0, 1))); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-black text-sm text-titanium truncate"><?php echo e($team->displayName()); ?></h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->group_label): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-primary/10 text-primary text-[9px] font-black uppercase">Grupo <?php echo e($team->group_label); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->external_team): ?>
                                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[9px] font-black uppercase">Externo</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $totalPlayers    = $team->players()->count();
                                $approvedPlayers = $team->players()->where('status', 'approved')->count();
                                $pct             = $totalPlayers > 0 ? round($approvedPlayers / $totalPlayers * 100) : 0;
                            ?>
                            <div class="py-3">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">Plantilla</span>
                                    <span class="text-[10px] font-black <?php echo e($pct === 100 ? 'text-green-600' : 'text-primary'); ?>"><?php echo e($approvedPlayers); ?>/<?php echo e($totalPlayers); ?></span>
                                </div>
                                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full <?php echo e($pct === 100 ? 'bg-green-500' : 'bg-primary'); ?>" style="width: <?php echo e($pct); ?>%"></div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
                                <a href="<?php echo e(route('tournament.team.players', [$tournament, $team])); ?>" 
                                   class="flex-[3] py-2.5 bg-indigo-50 text-indigo-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Añadir jugadores
                                </a>
                                <button wire:click="openEditTeamModal(<?php echo e($team->id); ?>)" class="flex-1 py-2.5 bg-gray-50 text-gray-600 rounded-xl active:scale-95 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="confirmDeleteTeam(<?php echo e($team->id); ?>)" class="flex-1 py-2.5 bg-red-50 text-red-600 rounded-xl active:scale-95 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div x-show="tab === 'standings'" x-cloak class="space-y-4">
            <div class="flex justify-end">
                <button wire:click="recalculateStandings" class="px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-100 text-xs font-bold text-titanium active:scale-95 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Recalcular
                </button>
            </div>

            <?php if($standings->isNotEmpty()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $standings->groupBy(fn($s) => $s->phase?->name ?? 'General'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseName => $phaseStandings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseStandings->groupBy('group_label'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $groupStandings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white-pure rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="text-sm font-black text-titanium"><?php echo e($phaseName); ?></h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($groupLabel): ?> <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Grupo <?php echo e($groupLabel); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div class="overflow-x-auto no-scrollbar">
                                <table class="w-full text-xs text-left whitespace-nowrap">
                                    <thead class="bg-white border-b border-gray-50 text-[10px] uppercase text-gray-400 font-bold">
                                        <tr>
                                            <th class="px-3 py-2 w-8 text-center">#</th>
                                            <th class="px-2 py-2">Equipo</th>
                                            <th class="px-2 py-2 text-center text-primary font-black">Pts</th>
                                            <th class="px-2 py-2 text-center">PJ</th>
                                            <th class="px-2 py-2 text-center text-green-600">G</th>
                                            <th class="px-2 py-2 text-center">E</th>
                                            <th class="px-2 py-2 text-center text-red-500">P</th>
                                            <th class="px-2 py-2 text-center">DG</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupStandings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $standing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="<?php echo e($loop->first ? 'bg-primary/5' : ''); ?>">
                                                <td class="px-3 py-2 text-center">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->first): ?>
                                                        <span class="w-5 h-5 mx-auto rounded-full bg-primary text-white text-[10px] font-black flex items-center justify-center">1</span>
                                                    <?php elseif($loop->index === 1): ?>
                                                        <span class="w-5 h-5 mx-auto rounded-full bg-gray-200 text-gray-600 text-[10px] font-black flex items-center justify-center">2</span>
                                                    <?php elseif($loop->index === 2): ?>
                                                        <span class="w-5 h-5 mx-auto rounded-full bg-amber-100 text-amber-700 text-[10px] font-black flex items-center justify-center">3</span>
                                                    <?php else: ?>
                                                        <span class="text-gray-400 font-bold"><?php echo e($standing->position); ?></span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                                <td class="px-2 py-3 font-bold text-titanium truncate max-w-[120px]"><?php echo e($standing->tournamentTeam?->displayName() ?? '—'); ?></td>
                                                <td class="px-2 py-3 text-center text-base font-black text-primary"><?php echo e($standing->points); ?></td>
                                                <td class="px-2 py-3 text-center font-semibold text-gray-500"><?php echo e($standing->played); ?></td>
                                                <td class="px-2 py-3 text-center font-bold text-green-600"><?php echo e($standing->won); ?></td>
                                                <td class="px-2 py-3 text-center font-semibold text-gray-500"><?php echo e($standing->drawn); ?></td>
                                                <td class="px-2 py-3 text-center font-bold text-red-500"><?php echo e($standing->lost); ?></td>
                                                <td class="px-2 py-3 text-center font-bold text-gray-700"><?php echo e(($standing->goals_for - $standing->goals_against) >= 0 ? '+' : ''); ?><?php echo e($standing->goals_for - $standing->goals_against); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php else: ?>
                <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400">Sin datos de clasificación aún.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div x-show="tab === 'stats'" x-cloak class="space-y-4">
            <div class="bg-white-pure border border-gray-100 rounded-3xl shadow-sm p-8 text-center">
                <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-lg font-black text-titanium mb-2">Estadísticas del Torneo</h3>
                <p class="text-xs text-gray-500 font-medium mb-6">Goleadores, tarjetas, mejores ataques y defensas.</p>
                <a href="<?php echo e(route('tournament.stats', $tournament)); ?>" wire:navigate class="inline-flex w-full py-4 bg-amber-500 text-white font-black text-sm rounded-2xl active:scale-95 transition-all justify-center items-center gap-2 shadow-md">
                    Ver Stats Completas
                </a>
            </div>
        </div>

        
        <div x-show="tab === 'referees'" x-cloak class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <p class="text-xs font-bold text-gray-500">
                    <span class="text-black-deep"><?php echo e($assignedReferees->count()); ?></span> árbitros asignados
                </p>
                <button wire:click="openRefereesModal" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl shadow-sm active:scale-95 transition-all">
                    Gestionar
                </button>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignedReferees->isEmpty()): ?>
                <div class="bg-white-pure rounded-3xl p-8 text-center shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400">No hay árbitros asignados.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $assignedReferees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-3 p-3 bg-white-pure rounded-2xl border border-gray-100 shadow-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referee->profile_photo_path): ?>
                                <img src="<?php echo e(asset('storage/' . $referee->profile_photo_path)); ?>" class="w-10 h-10 rounded-full object-cover border border-gray-100">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm">
                                    <?php echo e(strtoupper(substr($referee->name, 0, 1))); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-sm text-titanium truncate"><?php echo e($referee->name); ?></p>
                                <p class="text-[10px] text-gray-400 truncate"><?php echo e($referee->email); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div x-show="tab === 'setup'" x-cloak class="space-y-4">
            
            <div class="bg-white-pure border border-gray-100 rounded-3xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-black text-lg text-titanium">Fases del Torneo</h3>
                    <button wire:click="openCreatePhaseModal" class="px-3 py-1.5 bg-primary/10 text-primary text-[10px] font-bold uppercase rounded-lg active:scale-95">
                        + Nueva
                    </button>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phases->isEmpty()): ?>
                    <div class="py-8 text-center border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
                        <p class="text-xs font-bold text-gray-400">Sin fases definidas</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <span class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-sm font-black text-primary shadow-sm shrink-0"><?php echo e($phase->order); ?></span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-black-deep truncate"><?php echo e($phase->name); ?></p>
                                    <p class="text-[10px] text-gray-500"><?php echo e($phase->typeLabel()); ?> · <?php echo e($phase->matches_count); ?> part.</p>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <button wire:click="openEditPhaseModal(<?php echo e($phase->id); ?>)" class="p-2 rounded-lg bg-white shadow-sm text-gray-400 hover:text-blue-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDeletePhase(<?php echo e($phase->id); ?>)" class="p-2 rounded-lg bg-white shadow-sm text-gray-400 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type !== 'open'): ?>
                <div class="bg-white-pure border border-gray-100 rounded-3xl shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-lg text-titanium">Categorías</h3>
                        <button wire:click="openCreateCategoryModal" class="px-3 py-1.5 bg-primary/10 text-primary text-[10px] font-bold uppercase rounded-lg active:scale-95">
                            + Añadir
                        </button>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isEmpty()): ?>
                        <div class="py-8 text-center border-2 border-dashed border-gray-100 rounded-2xl bg-gray-50/50">
                            <p class="text-xs font-bold text-gray-400">Sin categorías creadas</p>
                        </div>
                    <?php else: ?>
                        <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-50 border border-gray-100 px-4 py-2 rounded-xl whitespace-nowrap flex items-center gap-2">
                                    <span class="text-sm font-bold text-titanium"><?php echo e($cat->name ?? $cat->category?->category); ?></span>
                                    <span class="text-[10px] font-black text-primary bg-primary/10 px-1.5 py-0.5 rounded"><?php echo e($cat->tournament_teams_count); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </main>

    
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-30">
        <div x-show="tab === 'matches'" x-cloak>
            <button wire:click="openCreateMatchModal" class="w-full py-4 bg-indigo-600 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Añadir Partido Manual
            </button>
        </div>
        <div x-show="tab === 'teams'" x-cloak>
            <button wire:click="openCreateTeamModal" class="w-full py-4 bg-primary text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Inscribir Equipo
            </button>
        </div>
        <div x-show="tab !== 'matches' && tab !== 'teams'" x-cloak>
            <a href="<?php echo e(route('tournaments.edit', $tournament)); ?>" wire:navigate class="w-full flex py-4 bg-gray-900 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Configuración General
            </a>
        </div>
    </div>


    

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGoalsModal && $goalsModalMatch): ?>
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="closeGoalsModal">
            <div class="bg-white-pure w-full h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-titanium">Eventos del Partido</p>
                    <button wire:click="closeGoalsModal" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="p-4 bg-gray-50/80 border-b border-gray-200 shrink-0">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <p class="flex-1 text-right text-sm font-black text-titanium truncate leading-tight"><?php echo e($goalsModalMatch->homeTeam?->displayName() ?? 'L'); ?></p>
                        <div class="px-5 py-2.5 rounded-2xl font-black text-2xl bg-white shadow-sm border border-gray-200 text-titanium shrink-0">
                            <?php echo e($goalsModalMatch->home_score ?? 0); ?> - <?php echo e($goalsModalMatch->away_score ?? 0); ?>

                        </div>
                        <p class="flex-1 text-left text-sm font-black text-titanium truncate leading-tight"><?php echo e($goalsModalMatch->awayTeam?->displayName() ?? 'V'); ?></p>
                    </div>
                    <div class="flex gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goalsModalMatch->status === 'scheduled' || $goalsModalMatch->status === 'postponed'): ?>
                            <button wire:click="gmStartMatch" class="flex-1 py-3 bg-red-500 text-white text-xs font-black rounded-xl active:scale-95 shadow-sm">▶ INICIAR PARTIDO</button>
                        <?php elseif($goalsModalMatch->status === 'in_progress'): ?>
                            <button wire:click="gmFinishMatch" class="flex-1 py-3 bg-gray-900 text-white text-xs font-black rounded-xl active:scale-95 shadow-sm">⏹ FINALIZAR</button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="flex-1 overflow-y-auto bg-white p-4 space-y-6 pb-6">
                    <div>
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Línea de Tiempo</h4>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_timeline->isEmpty()): ?>
                            <div class="text-center py-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-xs font-bold text-gray-400">Sin eventos registrados</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gm_timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $isHome = $event->teamId === $gm_homeTeamId; ?>
                                    <div class="flex items-center gap-3 p-3 rounded-2xl border border-gray-100 bg-white shadow-sm relative">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center font-black text-[10px] text-titanium shrink-0">
                                            <?php echo e($event->minute ? $event->minute . "'" : '-'); ?>

                                        </div>
                                        <div class="text-base shrink-0">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'goal'): ?> ⚽
                                            <?php elseif($event->subtype === 'yellow'): ?> 🟨
                                            <?php elseif($event->subtype === 'red'): ?> 🟥
                                            <?php else: ?> 🟨🟥 <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-titanium truncate"><?php echo e($event->player?->surname); ?> <?php echo e($event->player?->name); ?></p>
                                            <p class="text-[9px] font-semibold text-gray-400 uppercase"><?php echo e($isHome ? 'Local' : 'Visitante'); ?></p>
                                        </div>
                                        <button wire:click="<?php echo e($event->type === 'goal' ? 'gmConfirmDeleteGoal' : 'gmConfirmDeleteCard'); ?>(<?php echo e($event->id); ?>)"
                                                class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-500 rounded-full active:scale-95">✕</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goalsModalMatch->status === 'in_progress' || $goalsModalMatch->status === 'completed'): ?>
                        <div class="bg-gray-50 rounded-3xl p-4 border border-gray-100">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3 text-center">Registrar Nuevo Evento</h4>
                            <div class="flex bg-white rounded-xl p-1 shadow-sm border border-gray-200 mb-4">
                                <button wire:click="gmSetAction('goal')" class="flex-1 py-2.5 text-xs font-black rounded-lg transition-all <?php echo e($gm_action === 'goal' ? 'bg-primary text-white' : 'text-gray-500'); ?>">⚽ Gol</button>
                                <button wire:click="gmSetAction('card')" class="flex-1 py-2.5 text-xs font-black rounded-lg transition-all <?php echo e($gm_action === 'card' ? 'bg-amber-500 text-white' : 'text-gray-500'); ?>">🟨 Tarjeta</button>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gmMatchTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isHome = $t->id === $gm_homeTeamId;
                                        $isSelected = (string)$gm_team_id === (string)$t->id;
                                    ?>
                                    <button wire:click="gmSelectTeam(<?php echo e($t->id); ?>)"
                                            class="py-3 px-2 rounded-xl text-xs font-black border-2 transition-all truncate <?php echo e($isSelected ? 'border-primary bg-primary/10 text-primary' : 'border-gray-200 bg-white text-gray-500'); ?>">
                                        <?php echo e($t->displayName()); ?>

                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_team_id): ?>
                                <div class="space-y-3">
                                    <select wire:model="gm_player_id" class="w-full bg-white px-4 py-3 rounded-xl border border-gray-200 text-xs font-bold focus:ring-2 focus:ring-primary">
                                        <option value="">Selecciona Jugador...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gmTeamPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->id); ?>"><?php echo e($p->dorsal ? '#'.$p->dorsal : ''); ?> <?php echo e($p->surname); ?> <?php echo e($p->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                    <div class="flex gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gm_action === 'goal'): ?>
                                            <select wire:model="gm_goal_type" class="flex-1 bg-white px-3 py-3 rounded-xl border border-gray-200 text-xs font-bold">
                                                <option value="normal">Normal</option>
                                                <option value="penalty">Penalti</option>
                                                <option value="own_goal">Propia Puerta</option>
                                            </select>
                                        <?php else: ?>
                                            <select wire:model="gm_card_type" class="flex-1 bg-white px-3 py-3 rounded-xl border border-gray-200 text-xs font-bold">
                                                <option value="yellow">Amarilla</option>
                                                <option value="red">Roja</option>
                                                <option value="double_yellow">Doble Amarilla</option>
                                            </select>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <input wire:model="<?php echo e($gm_action === 'goal' ? 'gm_minute' : 'gm_card_minute'); ?>" type="number" placeholder="Min" class="w-20 text-center bg-white px-2 py-3 rounded-xl border border-gray-200 text-xs font-bold">
                                    </div>
                                    <button wire:click="<?php echo e($gm_action === 'goal' ? 'gmAddGoal' : 'gmAddCard'); ?>"
                                            class="w-full py-3.5 rounded-xl font-black text-white text-xs shadow-md active:scale-95 transition-all <?php echo e($gm_action === 'goal' ? 'bg-primary' : 'bg-amber-500'); ?>">
                                        Guardar Evento
                                    </button>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showMatchModal): ?>
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showMatchModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-titanium"><?php echo e($editingMatchId ? 'Editar Partido' : 'Nuevo Partido'); ?></p>
                    <button wire:click="$set('showMatchModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Fase (Opcional)</label>
                        <select wire:model="match_phase_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary">
                            <option value="">-- Sin Fase --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($phase->id); ?>"><?php echo e($phase->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Local *</label>
                            <select wire:model="match_home_id" class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary truncate">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Visitante *</label>
                            <select wire:model="match_away_id" class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary truncate">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($t->id); ?>"><?php echo e($t->displayName()); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Fecha y Hora</label>
                        <input wire:model="match_scheduled" type="datetime-local" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary"/>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Lugar / Sede</label>
                        <input wire:model="match_location" type="text" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary"/>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Estado</label>
                        <select wire:model="match_status" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary">
                            <option value="scheduled">Programado</option>
                            <option value="in_progress">En curso</option>
                            <option value="completed">Completado</option>
                            <option value="cancelled">Cancelado</option>
                            <option value="postponed">Aplazado</option>
                        </select>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showMatchModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="saveMatch" class="flex-[2] py-3.5 bg-primary text-white font-black text-sm rounded-xl active:scale-95">Guardar Partido</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPhaseModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showPhaseModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-titanium"><?php echo e($editingPhaseId ? 'Editar Fase' : 'Nueva Fase'); ?></p>
                    <button wire:click="$set('showPhaseModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nombre *</label>
                        <input wire:model="phase_name" type="text" placeholder="Ej: Fase de Grupos" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary"/>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tipo *</label>
                            <select wire:model="phase_type" class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary">
                                <option value="league">Liga</option>
                                <option value="group">Grupos</option>
                                <option value="knockout">Eliminatoria</option>
                                <option value="swiss">Sistema Suizo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Orden *</label>
                            <input wire:model="phase_order" type="number" min="1" class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-center focus:ring-2 focus:ring-primary"/>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showPhaseModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="savePhase" class="flex-[2] py-3.5 bg-primary text-white font-black text-sm rounded-xl active:scale-95">Guardar Fase</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showTeamModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showTeamModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-titanium"><?php echo e($editingTeamId ? 'Editar Equipo' : 'Inscribir Equipo'); ?></p>
                    <button wire:click="$set('showTeamModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type !== 'open'): ?>
                        <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                            <label class="text-xs font-bold text-titanium">¿Es un equipo externo?</label>
                            <button wire:click="$set('external_team', <?php echo e($external_team ? 'false' : 'true'); ?>)" class="w-10 h-6 rounded-full transition-colors <?php echo e($external_team ? 'bg-primary' : 'bg-gray-300'); ?> relative">
                                <span class="absolute top-1 w-4 h-4 bg-white rounded-full transition-transform <?php echo e($external_team ? 'translate-x-5' : 'translate-x-1'); ?>"></span>
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($external_team): ?>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nombre del Equipo *</label>
                            <input wire:model="name_override" type="text" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary"/>
                        </div>
                    <?php else: ?>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Seleccionar de la Escuela *</label>
                            <select wire:model="team_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schoolTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($st->id); ?>"><?php echo e($st->team); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showTeamModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="saveTeam" class="flex-[2] py-3.5 bg-primary text-white font-black text-sm rounded-xl active:scale-95">Guardar Equipo</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGenerateModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showGenerateModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-indigo-600">Generar Partidos</p>
                    <button wire:click="$set('showGenerateModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Seleccionar Fase *</label>
                        <select wire:model="generate_phase_id" class="w-full px-4 py-3.5 bg-indigo-50 border-0 rounded-2xl text-indigo-900 text-xs font-bold focus:ring-2 focus:ring-indigo-400">
                            <option value="">— Elegir Fase —</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($phase->id); ?>"><?php echo e($phase->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Número de Vueltas</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center justify-center gap-2 py-3 rounded-xl border-2 cursor-pointer transition-all <?php echo e($generate_legs == 1 ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-gray-100 text-gray-500 bg-white'); ?>">
                                <input type="radio" wire:model="generate_legs" value="1" class="hidden">
                                <span class="text-xs font-black">1 Vuelta</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 py-3 rounded-xl border-2 cursor-pointer transition-all <?php echo e($generate_legs == 2 ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-gray-100 text-gray-500 bg-white'); ?>">
                                <input type="radio" wire:model="generate_legs" value="2" class="hidden">
                                <span class="text-xs font-black">Ida y Vuelta</span>
                            </label>
                        </div>
                    </div>
                    <label class="flex items-start gap-3 p-3.5 rounded-xl border border-red-200 bg-red-50 mt-4 cursor-pointer">
                        <input type="checkbox" wire:model="generate_clear" class="mt-0.5 text-red-600 rounded">
                        <span class="text-xs text-red-800 font-bold">Borrar todos los partidos actuales de esta fase antes de generar los nuevos.</span>
                    </label>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showGenerateModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="generateMatches" class="flex-[2] py-3.5 bg-indigo-600 text-white font-black text-sm rounded-xl active:scale-95">Generar Automático</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showBracketModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showBracketModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-primary">Configurar Cuadro</p>
                    <button wire:click="$set('showBracketModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Primera ronda del cuadro</p>
                        <div class="grid grid-cols-2 gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                                1 => ['label' => 'Final', 'sub' => '2 equipos'],
                                2 => ['label' => 'Semifinal', 'sub' => '4 equipos'],
                                3 => ['label' => 'Cuartos de Final', 'sub' => '8 equipos'],
                                4 => ['label' => 'Octavos de Final', 'sub' => '16 equipos'],
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rc => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button wire:click="$set('bracketRoundCount', <?php echo e($rc); ?>)"
                                        class="flex flex-col items-center justify-center gap-0.5 py-3 rounded-xl border-2 transition-all
                                            <?php echo e($bracketRoundCount === $rc ? 'border-primary bg-primary/10 text-primary' : 'border-gray-100 bg-gray-50 text-gray-500'); ?>">
                                    <span class="text-sm font-black"><?php echo e($info['label']); ?></span>
                                    <span class="text-[10px] font-bold"><?php echo e($info['sub']); ?></span>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer p-3 bg-gray-50 border border-gray-100 rounded-xl">
                        <input type="checkbox" wire:model="bracketThirdPlace" class="w-5 h-5 rounded text-primary border-gray-300">
                        <span class="text-xs font-bold text-titanium">Incluir partido por el 3er puesto</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-3 bg-red-50 border border-red-100 rounded-xl">
                        <input type="checkbox" wire:model="bracketClearExisting" class="w-5 h-5 rounded text-red-500 border-red-300">
                        <span class="text-xs font-bold text-red-700">Borrar partidos existentes</span>
                    </label>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showBracketModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="generateKnockoutBracket" class="flex-[2] py-3.5 bg-primary text-white font-black text-sm rounded-xl active:scale-95">Generar Cuadro</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingMatchDelete): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('confirmingMatchDelete', false)">
            <div class="bg-white-pure w-full rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp p-6">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-black text-lg text-titanium text-center mb-2">¿Eliminar partido?</h3>
                <p class="text-xs font-bold text-gray-500 text-center mb-6">Esta acción no se puede deshacer.</p>
                <div class="flex gap-2 w-full">
                    <button wire:click="$set('confirmingMatchDelete', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                    <button wire:click="deleteMatch" class="flex-1 py-3.5 bg-red-600 text-white font-black text-sm rounded-xl active:scale-95">Eliminar</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingPhaseDelete): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('confirmingPhaseDelete', false)">
            <div class="bg-white-pure w-full rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp p-6">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-black text-lg text-titanium text-center mb-2">¿Eliminar Fase?</h3>
                <p class="text-xs font-bold text-gray-500 text-center mb-6">Se borrarán todos los partidos y clasificaciones de esta fase.</p>
                <div class="flex gap-2 w-full">
                    <button wire:click="$set('confirmingPhaseDelete', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                    <button wire:click="deletePhase" class="flex-1 py-3.5 bg-red-600 text-white font-black text-sm rounded-xl active:scale-95">Eliminar Fase</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingTeamDelete): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('confirmingTeamDelete', false)">
            <div class="bg-white-pure w-full rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp p-6">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-black text-lg text-titanium text-center mb-2">¿Eliminar Equipo?</h3>
                <p class="text-xs font-bold text-gray-500 text-center mb-6">El equipo será eliminado de este torneo.</p>
                <div class="flex gap-2 w-full">
                    <button wire:click="$set('confirmingTeamDelete', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                    <button wire:click="deleteTeam" class="flex-1 py-3.5 bg-red-600 text-white font-black text-sm rounded-xl active:scale-95">Eliminar Equipo</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPostponeModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showPostponeModal', false)">
            <div class="bg-white-pure w-full rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-amber-600">Aplazar Partido</p>
                    <button wire:click="$set('showPostponeModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="p-5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nueva fecha y hora (Opcional)</label>
                    <input wire:model="postponeDate" type="datetime-local" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-amber-500 mb-6"/>
                    
                    <div class="flex gap-2 w-full">
                        <button wire:click="$set('showPostponeModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                        <button wire:click="postponeMatch" class="flex-1 py-3.5 bg-amber-500 text-white font-black text-sm rounded-xl active:scale-95">Confirmar Aplazamiento</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showRefereesModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showRefereesModal', false)">
            <div class="bg-white-pure w-full h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-titanium">Gestionar Árbitros</p>
                    <button wire:click="$set('showRefereesModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableReferees->isEmpty()): ?>
                        <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <p class="text-xs font-bold text-gray-400">No hay árbitros disponibles</p>
                        </div>
                    <?php else: ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableReferees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-3 p-3 rounded-2xl border transition-all cursor-pointer <?php echo e(in_array($referee->id, $selectedReferees) ? 'bg-primary/10 border-primary' : 'bg-gray-50 border-gray-100'); ?>">
                                <input type="checkbox" wire:click="toggleReferee(<?php echo e($referee->id); ?>)" <?php echo e(in_array($referee->id, $selectedReferees) ? 'checked' : ''); ?> class="w-5 h-5 text-primary rounded border-gray-300">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referee->profile_photo_path): ?>
                                    <img src="<?php echo e(asset('storage/' . $referee->profile_photo_path)); ?>" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center font-black text-sm text-gray-500"><?php echo e(strtoupper(substr($referee->name, 0, 1))); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-titanium truncate"><?php echo e($referee->name); ?></p>
                                    <p class="text-[10px] text-gray-400 truncate"><?php echo e($referee->email); ?></p>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showRefereesModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="saveReferees" class="flex-[2] py-3.5 bg-primary text-white font-black text-sm rounded-xl active:scale-95">Guardar Selección</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCategoryModal): ?>
        <div class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showCategoryModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <p class="font-black text-lg text-titanium"><?php echo e($editingCategoryId ? 'Editar Categoría' : 'Nueva Categoría'); ?></p>
                    <button wire:click="$set('showCategoryModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5 space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Categoría base</label>
                        <select wire:model="cat_category_id" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary">
                            <option value="">Sin categoría (Personalizada)</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schoolCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($sc->id); ?>"><?php echo e($sc->category); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nombre (Opcional)</label>
                        <input wire:model="cat_name" type="text" placeholder="Ej: Alevín" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary"/>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Orden</label>
                        <input wire:model="cat_order" type="number" min="1" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold focus:ring-2 focus:ring-primary text-center"/>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showCategoryModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:scale-95">Cancelar</button>
                    <button wire:click="saveCategory" class="flex-[2] py-3.5 bg-primary text-white font-black text-sm rounded-xl active:scale-95">Guardar Categoría</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .animate-slideUp { animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
        [x-cloak] { display: none !important; }
    </style>
</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\tournaments\show_mobile.blade.php ENDPATH**/ ?>