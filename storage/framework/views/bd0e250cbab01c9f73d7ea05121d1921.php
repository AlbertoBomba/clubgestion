<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-3 sm:px-4 lg:px-6 max-w-5xl mx-auto">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('events_message')): ?>
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show"
             class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <?php echo e(session('events_message')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-4 sm:p-5 mb-4">
        <div class="flex items-center gap-3 mb-1">
            <a href="<?php echo e(route('tournaments.show', $tournament)); ?>" wire:navigate
               class="p-1.5 rounded-lg text-titanium hover:text-primary hover:bg-primary/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <p class="text-xs text-titanium"><?php echo e($tournament->name); ?></p>
                <h1 class="text-lg sm:text-xl font-bold text-black-deep leading-tight">Eventos del Partido</h1>
            </div>
        </div>

        
        <div class="mt-3 bg-gray-50 rounded-xl border border-silver p-4">
            <div class="flex items-center justify-between gap-3">
                
                <div class="flex-1 text-right">
                    <p class="font-bold text-black-deep text-sm sm:text-base leading-tight">
                        <?php echo e($match->homeTeam?->displayName() ?? '—'); ?>

                    </p>
                    <p class="text-xs text-titanium mt-0.5">Local</p>
                </div>

                
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-2xl sm:text-3xl font-black text-black-deep tabular-nums">
                        <?php echo e($match->home_score ?? '—'); ?>

                    </span>
                    <span class="text-titanium font-bold text-xl">:</span>
                    <span class="text-2xl sm:text-3xl font-black text-black-deep tabular-nums">
                        <?php echo e($match->away_score ?? '—'); ?>

                    </span>
                </div>

                
                <div class="flex-1 text-left">
                    <p class="font-bold text-black-deep text-sm sm:text-base leading-tight">
                        <?php echo e($match->awayTeam?->displayName() ?? '—'); ?>

                    </p>
                    <p class="text-xs text-titanium mt-0.5">Visitante</p>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->scheduled_at || $match->location): ?>
                <div class="flex items-center justify-center gap-4 mt-2 text-xs text-titanium">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->scheduled_at): ?>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <?php echo e($match->scheduled_at->format('d/m/Y H:i')); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->location): ?>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <?php echo e($match->location); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-silver bg-gray-50/50">
                <h2 class="font-bold text-black-deep flex items-center gap-2">
                    <span class="w-6 h-6 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-primary" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="none"/><path fill="white" d="M12 2a10 10 0 100 20A10 10 0 0012 2zm0 2c1.3 0 2.5.3 3.6.8l-1.1 3.4-2.5.8-2.5-.8-1.1-3.4A8 8 0 0112 4zm-6.9 3.4l2.4 1.3.7 2.6-1.6 2.1H4.1A8 8 0 015.1 7.4zm1.5 9.3l1.3-1.8h4.2l1.3 1.8-1.3 3.8a8 8 0 01-5.5 0l-1.3-3.8zm9.3 2.5l-1.3-3.8 1.3-1.8h2.5c.7-1 1.1-2.1 1.3-3.3h-2.4l-1.6-2.1.7-2.6 2.4-1.3A8 8 0 0118.9 13.4h-2.4l-1.6-2.1z"/></svg>
                    </span>
                    Goles <span class="text-xs font-normal text-titanium ml-1">(<?php echo e($goals->count()); ?>)</span>
                </h2>
                <button wire:click="openGoalForm"
                        class="inline-flex items-center gap-1.5 bg-primary hover:bg-primary/90 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Añadir gol
                </button>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGoalForm): ?>
                <div class="p-4 border-b border-silver bg-primary/5">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Equipo *</label>
                            <select wire:model.live="goal_team_id"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="">— Equipo —</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($team->id); ?>"><?php echo e($team->displayName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['goal_team_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Jugador *</label>
                            <select wire:model.live="goal_player_id"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                                    <?php if(!$goal_team_id): ?> disabled <?php endif; ?>>
                                <option value="">— Jugador —</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $goalTeamPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($player->id); ?>"><?php echo e($player->fullName()); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?> (<?php echo e($player->dorsal); ?>) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['goal_player_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Tipo</label>
                            <select wire:model.live="goal_type"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                <option value="normal">Gol</option>
                                <option value="penalty">Penalti</option>
                                <option value="own_goal">Propia puerta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Minuto</label>
                            <input wire:model.live="goal_minute" type="number" min="1" max="180" placeholder="Ej: 45"
                                   class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"/>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button wire:click="$set('showGoalForm', false)"
                                class="px-3 py-1.5 text-xs text-titanium border border-silver rounded-lg hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button wire:click="saveGoal"
                                class="px-4 py-1.5 text-xs font-semibold bg-primary text-white rounded-lg hover:bg-primary/90">
                            Guardar gol
                        </button>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goals->isEmpty()): ?>
                <p class="text-sm text-titanium text-center py-6">Sin goles registrados</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-50">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center gap-3 px-4 py-3">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goal->goal_type === 'own_goal'): ?>
                                <span class="shrink-0 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-xs font-bold text-red-600">PP</span>
                            <?php elseif($goal->goal_type === 'penalty'): ?>
                                <span class="shrink-0 w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-xs font-bold text-amber-600">P</span>
                            <?php else: ?>
                                <span class="shrink-0 w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-primary" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9"/></svg>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-black-deep truncate"><?php echo e($goal->player?->fullName()); ?></p>
                                <p class="text-xs text-titanium truncate"><?php echo e($goal->team?->displayName()); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goal->minute): ?> · <?php echo e($goal->minute); ?>'<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deletingGoalId === $goal->id): ?>
                                <div class="flex items-center gap-1 shrink-0">
                                    <span class="text-xs text-red-600">¿Eliminar?</span>
                                    <button wire:click="deleteGoal" class="px-2 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600">Sí</button>
                                    <button wire:click="$set('deletingGoalId', null)" class="px-2 py-1 text-xs border border-silver rounded-lg hover:bg-gray-50">No</button>
                                </div>
                            <?php else: ?>
                                <button wire:click="confirmDeleteGoal(<?php echo e($goal->id); ?>)"
                                        class="shrink-0 p-1.5 text-titanium hover:text-red-500 transition-colors rounded-lg hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-silver bg-gray-50/50">
                <h2 class="font-bold text-black-deep flex items-center gap-2">
                    <span class="w-6 h-6 bg-yellow-400/20 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/></svg>
                    </span>
                    Tarjetas <span class="text-xs font-normal text-titanium ml-1">(<?php echo e($cards->count()); ?>)</span>
                </h2>
                <button wire:click="openCardForm"
                        class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Añadir tarjeta
                </button>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCardForm): ?>
                <div class="p-4 border-b border-silver bg-amber-50/50">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Equipo *</label>
                            <select wire:model.live="card_team_id"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="">— Equipo —</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($team->id); ?>"><?php echo e($team->displayName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['card_team_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Jugador *</label>
                            <select wire:model.live="card_player_id"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30"
                                    <?php if(!$card_team_id): ?> disabled <?php endif; ?>>
                                <option value="">— Jugador —</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cardTeamPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($player->id); ?>"><?php echo e($player->fullName()); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?> (<?php echo e($player->dorsal); ?>) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['card_player_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Tipo de tarjeta *</label>
                            <select wire:model.live="card_type"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="yellow">🟡 Amarilla</option>
                                <option value="red">🔴 Roja directa</option>
                                <option value="double_yellow">🟡🔴 Doble amarilla</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Minuto</label>
                            <input wire:model.live="card_minute" type="number" min="1" max="180" placeholder="Ej: 78"
                                   class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($card_type, ['red', 'double_yellow'])): ?>
                        <div class="flex items-center gap-2 p-2.5 bg-red-50 border border-red-200 rounded-lg text-xs text-red-700 mb-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Se creará automáticamente una sanción de 1 partido de suspensión.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="flex justify-end gap-2">
                        <button wire:click="$set('showCardForm', false)"
                                class="px-3 py-1.5 text-xs text-titanium border border-silver rounded-lg hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button wire:click="saveCard"
                                class="px-4 py-1.5 text-xs font-semibold bg-amber-500 text-white rounded-lg hover:bg-amber-600">
                            Guardar tarjeta
                        </button>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cards->isEmpty()): ?>
                <p class="text-sm text-titanium text-center py-6">Sin tarjetas registradas</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-50">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center gap-3 px-4 py-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($card->card_type === 'yellow'): ?>
                                <span class="shrink-0 w-5 h-6 bg-yellow-400 rounded-sm shadow-sm"></span>
                            <?php elseif($card->card_type === 'red'): ?>
                                <span class="shrink-0 w-5 h-6 bg-red-500 rounded-sm shadow-sm"></span>
                            <?php else: ?>
                                <div class="shrink-0 flex gap-0.5">
                                    <span class="w-4 h-6 bg-yellow-400 rounded-sm shadow-sm -rotate-6"></span>
                                    <span class="w-4 h-6 bg-red-500 rounded-sm shadow-sm rotate-6"></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-black-deep truncate"><?php echo e($card->player?->fullName()); ?></p>
                                <p class="text-xs text-titanium truncate"><?php echo e($card->team?->displayName()); ?>

                                    · <?php echo e($card->cardTypeLabel()); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($card->minute): ?> · <?php echo e($card->minute); ?>'<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deletingCardId === $card->id): ?>
                                <div class="flex items-center gap-1 shrink-0">
                                    <span class="text-xs text-red-600">¿Eliminar?</span>
                                    <button wire:click="deleteCard" class="px-2 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600">Sí</button>
                                    <button wire:click="$set('deletingCardId', null)" class="px-2 py-1 text-xs border border-silver rounded-lg hover:bg-gray-50">No</button>
                                </div>
                            <?php else: ?>
                                <button wire:click="confirmDeleteCard(<?php echo e($card->id); ?>)"
                                        class="shrink-0 p-1.5 text-titanium hover:text-red-500 transition-colors rounded-lg hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden lg:col-span-2">
            <div class="flex items-center justify-between px-4 py-3 border-b border-silver bg-gray-50/50">
                <h2 class="font-bold text-black-deep flex items-center gap-2">
                    <span class="w-6 h-6 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </span>
                    Sanciones de esta jornada <span class="text-xs font-normal text-titanium ml-1">(<?php echo e($sanctions->count()); ?>)</span>
                </h2>
                <button wire:click="openSanctionForm"
                        class="inline-flex items-center gap-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Añadir sanción
                </button>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSanctionForm): ?>
                <div class="p-4 border-b border-silver bg-red-50/50">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Tipo de sanción *</label>
                            <select wire:model.live="sanction_type"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="suspension">Suspensión</option>
                                <option value="warning">Apercibimiento</option>
                                <option value="fine">Multa</option>
                                <option value="disqualification">Descalificación</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Equipo</label>
                            <select wire:model.live="sanction_team_id"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="">— Ninguno —</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($team->id); ?>"><?php echo e($team->displayName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sanction_team_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-0.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-titanium mb-1">Jugador</label>
                            <select wire:model.live="sanction_player_id"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30"
                                    <?php if(!$sanction_team_id): ?> disabled <?php endif; ?>>
                                <option value="">— Ninguno —</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sanctionTeamPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($player->id); ?>"><?php echo e($player->fullName()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sanction_type === 'suspension'): ?>
                            <div>
                                <label class="block text-xs font-semibold text-titanium mb-1">Partidos de suspensión *</label>
                                <input wire:model.live="sanction_matches" type="number" min="0" max="99"
                                       class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="<?php echo e($sanction_type === 'suspension' ? '' : 'sm:col-span-2'); ?>">
                            <label class="block text-xs font-semibold text-titanium mb-1">Motivo</label>
                            <input wire:model.live="sanction_reason" type="text" placeholder="Ej: Conducta antideportiva"
                                   class="w-full text-sm border border-gray-200 rounded-lg px-2.5 py-2 bg-white-pure focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button wire:click="$set('showSanctionForm', false)"
                                class="px-3 py-1.5 text-xs text-titanium border border-silver rounded-lg hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button wire:click="saveSanction"
                                class="px-4 py-1.5 text-xs font-semibold bg-red-500 text-white rounded-lg hover:bg-red-600">
                            Guardar sanción
                        </button>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sanctions->isEmpty()): ?>
                <p class="text-sm text-titanium text-center py-6">Sin sanciones en esta jornada</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-silver bg-gray-50/50 text-xs font-semibold text-titanium uppercase tracking-wide">
                                <th class="px-4 py-2.5 text-left">Afectado</th>
                                <th class="px-4 py-2.5 text-left">Equipo</th>
                                <th class="px-4 py-2.5 text-left">Tipo</th>
                                <th class="px-4 py-2.5 text-center">Partidos</th>
                                <th class="px-4 py-2.5 text-center">Cumplidos</th>
                                <th class="px-4 py-2.5 text-left">Motivo</th>
                                <th class="px-4 py-2.5 text-center">Estado</th>
                                <th class="px-4 py-2.5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sanctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sanction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e(!$sanction->active ? 'opacity-60' : ''); ?>">
                                    <td class="px-4 py-3 font-medium text-black-deep">
                                        <?php echo e($sanction->player?->fullName() ?? '(Equipo)'); ?>

                                    </td>
                                    <td class="px-4 py-3 text-titanium">
                                        <?php echo e($sanction->team?->displayName() ?? '—'); ?>

                                    </td>
                                    <td class="px-4 py-3">
                                        <?php
                                            $typeColors = [
                                                'suspension'       => 'bg-red-100 text-red-700',
                                                'warning'          => 'bg-amber-100 text-amber-700',
                                                'fine'             => 'bg-purple-100 text-purple-700',
                                                'disqualification' => 'bg-gray-800 text-white',
                                            ];
                                        ?>
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($typeColors[$sanction->sanction_type] ?? 'bg-gray-100 text-gray-600'); ?>">
                                            <?php echo e($sanction->sanctionTypeLabel()); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center font-semibold">
                                        <?php echo e($sanction->matches_suspended); ?>

                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span><?php echo e($sanction->matches_served); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sanction->active && $sanction->matches_served < $sanction->matches_suspended): ?>
                                                <button wire:click="incrementServed(<?php echo e($sanction->id); ?>)"
                                                        title="Marcar 1 partido cumplido"
                                                        class="w-5 h-5 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white flex items-center justify-center transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-titanium text-xs max-w-[200px] truncate">
                                        <?php echo e($sanction->reason ?? '—'); ?>

                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="toggleSanctionActive(<?php echo e($sanction->id); ?>)"
                                                class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($sanction->active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200'); ?> transition-colors">
                                            <?php echo e($sanction->active ? 'Activa' : 'Cumplida'); ?>

                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($deletingSanctionId === $sanction->id): ?>
                                            <div class="flex items-center justify-center gap-1">
                                                <button wire:click="deleteSanction" class="px-2 py-1 text-xs bg-red-500 text-white rounded-lg">Sí</button>
                                                <button wire:click="$set('deletingSanctionId', null)" class="px-2 py-1 text-xs border border-silver rounded-lg">No</button>
                                            </div>
                                        <?php else: ?>
                                            <button wire:click="confirmDeleteSanction(<?php echo e($sanction->id); ?>)"
                                                    class="p-1.5 text-titanium hover:text-red-500 rounded-lg hover:bg-red-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\tournaments\match-events.blade.php ENDPATH**/ ?>