<div x-data="{ activeTab: <?php if ((object) ('activeTab') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('activeTab'->value()); ?>')<?php echo e('activeTab'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('activeTab'); ?>')<?php endif; ?> }">
     <?php $__env->slot('title', null, []); ?> Gestión del Partido <?php $__env->endSlot(); ?>
     <?php $__env->slot('backUrl', null, []); ?> <?php echo e(route('referee.tournament.matches', $match->tournament)); ?> <?php $__env->endSlot(); ?>

    <!-- Flash Messages -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('message')): ?>
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 3000)" 
             x-show="show"
             x-transition
             class="fixed top-20 left-0 right-0 z-50 mx-auto max-w-md px-4">
            <div class="bg-green-500 text-white px-4 py-3 rounded-xl shadow-lg font-semibold text-sm text-center">
                <?php echo e(session('message')); ?>

            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Match Header -->
    <div class="bg-gradient-to-br from-primary to-blue-600 px-4 py-6">
        <!-- Teams & Score -->
        <div class="space-y-4">
            <!-- Home Team -->
            <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                <div class="flex items-center gap-3 flex-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam?->logo ?? $match->homeTeam?->team?->logo): ?>
                        <img src="<?php echo e(asset('storage/' . ($match->homeTeam->logo ?? $match->homeTeam->team->logo))); ?>" 
                             class="w-12 h-12 rounded-lg object-cover border-2 border-white" alt="">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center border-2 border-white">
                            <span class="text-sm font-bold text-white"><?php echo e(substr($match->homeTeam?->displayName() ?? 'TBD', 0, 1)); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="font-bold text-white text-lg"><?php echo e($match->homeTeam?->displayName() ?? 'Por definir'); ?></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-4xl font-black text-white"><?php echo e($homeGoals); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status !== 'scheduled'): ?>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center border border-white/40 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg overflow-hidden z-10">
                                <button wire:click="openGoalFormForTeam(<?php echo e($match->home_team_id); ?>)" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Gol
                                </button>
                                <button wire:click="openCardFormForTeam(<?php echo e($match->home_team_id); ?>)" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Tarjeta
                                </button>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- VS -->
            <div class="text-center">
                <span class="text-xs font-bold text-white/60">VS</span>
            </div>

            <!-- Away Team -->
            <div class="flex items-center justify-between bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                <div class="flex items-center gap-3 flex-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam?->logo ?? $match->awayTeam?->team?->logo): ?>
                        <img src="<?php echo e(asset('storage/' . ($match->awayTeam->logo ?? $match->awayTeam->team->logo))); ?>" 
                             class="w-12 h-12 rounded-lg object-cover border-2 border-white" alt="">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center border-2 border-white">
                            <span class="text-sm font-bold text-white"><?php echo e(substr($match->awayTeam?->displayName() ?? 'TBD', 0, 1)); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="font-bold text-white text-lg"><?php echo e($match->awayTeam?->displayName() ?? 'Por definir'); ?></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-4xl font-black text-white"><?php echo e($awayGoals); ?></span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status !== 'scheduled'): ?>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center border border-white/40 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg overflow-hidden z-10">
                                <button wire:click="openGoalFormForTeam(<?php echo e($match->away_team_id); ?>)" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Gol
                                </button>
                                <button wire:click="openCardFormForTeam(<?php echo e($match->away_team_id); ?>)" @click="open = false" class="w-full px-4 py-2.5 text-left text-sm font-semibold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Tarjeta
                                </button>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Match Status & Actions -->
        <div class="mt-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'scheduled'): ?>
                <button wire:click="startMatch" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg transition-colors">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Iniciar Partido
                    </div>
                </button>
            <?php elseif($match->status === 'in_progress'): ?>
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/20">
                        <div class="flex items-center gap-2 justify-center">
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                            <span class="text-sm font-bold text-white">EN CURSO</span>
                        </div>
                    </div>
                    <button wire:click="finishMatch" 
                            wire:confirm="¿Estás seguro de finalizar el partido?"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-colors">
                        Finalizar
                    </button>
                </div>
            <?php elseif($match->status === 'completed'): ?>
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/20 text-center">
                        <span class="text-sm font-bold text-white">PARTIDO FINALIZADO</span>
                    </div>
                    <button wire:click="reopenMatch" 
                            wire:confirm="¿Quieres reabrir el partido para editarlo?"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-colors">
                        Reabrir
                    </button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white border-b border-gray-200 sticky top-16 z-40">
        <div class="flex overflow-x-auto">
            <button @click="activeTab = 'goals'" 
                    :class="activeTab === 'goals' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Goles (<?php echo e($goals->count()); ?>)
            </button>
            <button @click="activeTab = 'cards'" 
                    :class="activeTab === 'cards' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Tarjetas (<?php echo e($cards->count()); ?>)
            </button>
            <button @click="activeTab = 'notes'" 
                    :class="activeTab === 'notes' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Notas
            </button>
            <button @click="activeTab = 'players'" 
                    :class="activeTab === 'players' ? 'border-primary text-primary' : 'border-transparent text-gray-500'"
                    class="flex-1 min-w-max px-4 py-3 text-sm font-bold border-b-2 transition-colors">
                Jugadores
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="p-4 pb-32">
        <!-- GOALS TAB -->
        <div x-show="activeTab === 'goals'" x-cloak>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status !== 'scheduled'): ?>
                <button wire:click="$set('showGoalForm', true)" 
                        class="w-full mb-4 flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Gol
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Goals List -->
            <div class="space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900">
                                <?php echo e($goal->player?->surname); ?> <?php echo e($goal->player?->name); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goal->goal_type === 'penalty'): ?>
                                    <span class="text-xs text-blue-600">(Penal)</span>
                                <?php elseif($goal->goal_type === 'own_goal'): ?>
                                    <span class="text-xs text-red-600">(Propia)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                <?php echo e($goal->team?->displayName()); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goal->minute): ?>
                                    · Min. <?php echo e($goal->minute); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status !== 'scheduled'): ?>
                            <button wire:click="deleteGoal(<?php echo e($goal->id); ?>)" 
                                    wire:confirm="¿Eliminar este gol?"
                                    class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <p class="text-sm text-gray-500">No hay goles registrados</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- CARDS TAB -->
        <div x-show="activeTab === 'cards'" x-cloak>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status !== 'scheduled'): ?>
                <button wire:click="$set('showCardForm', true)" 
                        class="w-full mb-4 flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-xl shadow-sm transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Añadir Tarjeta
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Cards List -->
            <div class="space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg <?php echo e($card->card_type === 'yellow' ? 'bg-yellow-100' : 'bg-red-100'); ?> flex items-center justify-center shrink-0">
                            <div class="w-6 h-8 rounded <?php echo e($card->card_type === 'yellow' ? 'bg-yellow-500' : 'bg-red-600'); ?>"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900">
                                <?php echo e($card->player?->surname); ?> <?php echo e($card->player?->name); ?>

                            </p>
                            <p class="text-sm text-gray-500">
                                <?php echo e($card->team?->displayName()); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($card->minute): ?>
                                    · Min. <?php echo e($card->minute); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($card->notes): ?>
                                <p class="text-xs text-gray-400 mt-1"><?php echo e($card->notes); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status !== 'scheduled'): ?>
                            <button wire:click="deleteCard(<?php echo e($card->id); ?>)" 
                                    wire:confirm="¿Eliminar esta tarjeta?"
                                    class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <p class="text-sm text-gray-500">No hay tarjetas registradas</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- NOTES TAB -->
        <div x-show="activeTab === 'notes'" x-cloak>
            <textarea wire:model="matchNotes" 
                      rows="10" 
                      placeholder="Escribe aquí las incidencias del partido..."
                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 resize-none"></textarea>
            <button wire:click="saveNotes" 
                    class="w-full mt-3 bg-primary hover:bg-primary/90 text-white font-bold py-3 rounded-xl shadow-sm transition-colors">
                Guardar Notas
            </button>
        </div>

        <!-- PLAYERS TAB -->
        <div x-show="activeTab === 'players'" x-cloak class="space-y-4">
            <!-- Home Team Players -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-blue-600 px-4 py-3 flex items-center gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam?->logo ?? $match->homeTeam?->team?->logo): ?>
                        <img src="<?php echo e(asset('storage/' . ($match->homeTeam->logo ?? $match->homeTeam->team->logo))); ?>" 
                             class="w-8 h-8 rounded-lg object-cover border-2 border-white" alt="">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="font-bold text-white"><?php echo e($match->homeTeam?->displayName() ?? 'Equipo Local'); ?></span>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $homePlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <button wire:click="viewPlayerDetails(<?php echo e($player->id); ?>)" 
                                class="w-full px-4 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors text-left">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $player->photo)); ?>" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200" alt="">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">#<?php echo e($player->dorsal); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <span class="font-semibold text-gray-900"><?php echo e($player->surname); ?></span>
                                    <span class="text-gray-600"><?php echo e($player->name); ?></span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->position): ?>
                                    <p class="text-xs text-gray-500 mt-0.5"><?php echo e($player->position); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            No hay jugadores registrados
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Away Team Players -->
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-blue-600 px-4 py-3 flex items-center gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam?->logo ?? $match->awayTeam?->team?->logo): ?>
                        <img src="<?php echo e(asset('storage/' . ($match->awayTeam->logo ?? $match->awayTeam->team->logo))); ?>" 
                             class="w-8 h-8 rounded-lg object-cover border-2 border-white" alt="">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="font-bold text-white"><?php echo e($match->awayTeam?->displayName() ?? 'Equipo Visitante'); ?></span>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $awayPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <button wire:click="viewPlayerDetails(<?php echo e($player->id); ?>)" 
                                class="w-full px-4 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors text-left">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $player->photo)); ?>" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-gray-200" alt="">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                                        <span class="w-7 h-7 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0">#<?php echo e($player->dorsal); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <span class="font-semibold text-gray-900"><?php echo e($player->surname); ?></span>
                                    <span class="text-gray-600"><?php echo e($player->name); ?></span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->position): ?>
                                    <p class="text-xs text-gray-500 mt-0.5"><?php echo e($player->position); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            No hay jugadores registrados
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Goal Form Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showGoalForm): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" wire:click="$set('showGoalForm', false)">
            <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl" wire:click.stop @click.away="$wire.set('showGoalForm', false)">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Añadir Gol</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Equipo</label>
                        <select wire:model.live="goalTeamId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option value="">Seleccionar equipo</option>
                            <option value="<?php echo e($match->home_team_id); ?>"><?php echo e($match->homeTeam?->displayName()); ?></option>
                            <option value="<?php echo e($match->away_team_id); ?>"><?php echo e($match->awayTeam?->displayName()); ?></option>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['goalTeamId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div x-data="{ search: <?php if ((object) ('goalPlayerSearch') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('goalPlayerSearch'->value()); ?>')<?php echo e('goalPlayerSearch'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('goalPlayerSearch'); ?>')<?php endif; ?>, showResults: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jugador <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input 
                                x-model="search"
                                @focus="showResults = true"
                                @click.away="showResults = false"
                                type="text" 
                                placeholder="Buscar por nombre, apellido o dorsal..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30"
                            >
                            <div x-show="showResults && search.length > 0" x-cloak class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto z-20">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goalTeamId == $match->home_team_id): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $homePlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button 
                                            type="button"
                                            @click="$wire.set('goalPlayerId', <?php echo e($player->id); ?>); search = '#<?php echo e($player->dorsal ?? ''); ?> <?php echo e($player->surname); ?> <?php echo e($player->name); ?>'; showResults = false"
                                            x-show="'<?php echo e(strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name)); ?>'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0"><?php echo e($player->dorsal); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold"><?php echo e($player->surname); ?></span>
                                                <span class="text-gray-600"><?php echo e($player->name); ?></span>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php elseif($goalTeamId == $match->away_team_id): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $awayPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button 
                                            type="button"
                                            @click="$wire.set('goalPlayerId', <?php echo e($player->id); ?>); search = '#<?php echo e($player->dorsal ?? ''); ?> <?php echo e($player->surname); ?> <?php echo e($player->name); ?>'; showResults = false"
                                            x-show="'<?php echo e(strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name)); ?>'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0"><?php echo e($player->dorsal); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold"><?php echo e($player->surname); ?></span>
                                                <span class="text-gray-600"><?php echo e($player->name); ?></span>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['goalPlayerId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <p class="text-red-500 text-xs mt-1">Debes seleccionar un jugador</p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Minuto</label>
                            <input wire:model="goalMinute" type="number" min="1" max="180" placeholder="45" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                            <select wire:model="goalType" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="normal">Normal</option>
                                <option value="penalty">Penal</option>
                                <option value="own_goal">Propia</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button wire:click="$set('showGoalForm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl">
                            Cancelar
                        </button>
                        <button wire:click="addGoal" class="flex-1 py-2.5 bg-green-500 text-white font-semibold rounded-xl">
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Card Form Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showCardForm): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" wire:click="$set('showCardForm', false)">
            <div class="bg-white rounded-3xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto shadow-2xl" wire:click.stop>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Añadir Tarjeta</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Equipo</label>
                        <select wire:model.live="cardTeamId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                            <option value="">Seleccionar equipo</option>
                            <option value="<?php echo e($match->home_team_id); ?>"><?php echo e($match->homeTeam?->displayName()); ?></option>
                            <option value="<?php echo e($match->away_team_id); ?>"><?php echo e($match->awayTeam?->displayName()); ?></option>
                        </select>
                    </div>
                    <div x-data="{ search: <?php if ((object) ('cardPlayerSearch') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('cardPlayerSearch'->value()); ?>')<?php echo e('cardPlayerSearch'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('cardPlayerSearch'); ?>')<?php endif; ?>, showResults: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jugador</label>
                        <div class="relative">
                            <input 
                                x-model="search"
                                @focus="showResults = true"
                                @click.away="showResults = false"
                                type="text" 
                                placeholder="Buscar por nombre, apellido o dorsal..."
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30"
                            >
                            <div x-show="showResults && search.length > 0" x-cloak class="absolute w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-48 overflow-y-auto z-20">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardTeamId == $match->home_team_id): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $homePlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button 
                                            type="button"
                                            @click="$wire.set('cardPlayerId', <?php echo e($player->id); ?>); search = '#<?php echo e($player->dorsal ?? ''); ?> <?php echo e($player->surname); ?> <?php echo e($player->name); ?>'; showResults = false"
                                            x-show="'<?php echo e(strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name)); ?>'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0"><?php echo e($player->dorsal); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold"><?php echo e($player->surname); ?></span>
                                                <span class="text-gray-600"><?php echo e($player->name); ?></span>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php elseif($cardTeamId == $match->away_team_id): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $awayPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button 
                                            type="button"
                                            @click="$wire.set('cardPlayerId', <?php echo e($player->id); ?>); search = '#<?php echo e($player->dorsal ?? ''); ?> <?php echo e($player->surname); ?> <?php echo e($player->name); ?>'; showResults = false"
                                            x-show="'<?php echo e(strtolower(($player->dorsal ?? '') . ' ' . $player->surname . ' ' . $player->name)); ?>'.includes(search.toLowerCase())"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-gray-50 flex items-center gap-2"
                                        >
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                                                <span class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-xs flex items-center justify-center shrink-0"><?php echo e($player->dorsal); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <span class="font-semibold"><?php echo e($player->surname); ?></span>
                                                <span class="text-gray-600"><?php echo e($player->name); ?></span>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Minuto</label>
                            <input wire:model="cardMinute" type="number" min="1" max="180" placeholder="45" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                            <select wire:model="cardType" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <option value="yellow">Amarilla</option>
                                <option value="red">Roja</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Motivo (opcional)</label>
                        <textarea wire:model="cardReason" rows="2" placeholder="Falta antideportiva..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 resize-none"></textarea>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button wire:click="$set('showCardForm', false)" class="flex-1 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl">
                            Cancelar
                        </button>
                        <button wire:click="addCard" class="flex-1 py-2.5 bg-yellow-500 text-white font-semibold rounded-xl">
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Player Details Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPlayerDetails && $selectedPlayer): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4" wire:click="closePlayerDetails">
            <div class="bg-white rounded-3xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl" wire:click.stop>
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-primary to-blue-600 px-6 py-4 flex items-center justify-between rounded-t-3xl">
                    <h3 class="text-lg font-bold text-white">Detalles del Jugador</h3>
                    <button wire:click="closePlayerDetails" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Player Photo -->
                    <div class="flex justify-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $selectedPlayer->photo)); ?>" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-lg" alt="Foto del jugador">
                        <?php else: ?>
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Player Info -->
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->dorsal): ?>
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-primary text-white font-bold text-lg flex items-center justify-center">
                                    <?php echo e($selectedPlayer->dorsal); ?>

                                </div>
                                <span class="text-sm font-semibold text-gray-600">Dorsal</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                            <p class="text-base font-semibold text-gray-900"><?php echo e($selectedPlayer->name); ?></p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Apellidos</label>
                            <p class="text-base font-semibold text-gray-900"><?php echo e($selectedPlayer->surname); ?></p>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->dni): ?>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1"><?php echo e($selectedPlayer->doc_type ?? 'DNI'); ?></label>
                                <p class="text-base font-semibold text-gray-900"><?php echo e($selectedPlayer->dni); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->birthdate): ?>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha de Nacimiento</label>
                                <p class="text-base font-semibold text-gray-900"><?php echo e($selectedPlayer->birthdate->format('d/m/Y')); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->position): ?>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Posición</label>
                                <p class="text-base font-semibold text-gray-900"><?php echo e($selectedPlayer->position); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- DNI Images -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->doc_front || $selectedPlayer->doc_back): ?>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Documentación</label>
                            <div class="space-y-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->doc_front): ?>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">DNI - Frontal</p>
                                        <img src="<?php echo e(asset('storage/' . $selectedPlayer->doc_front)); ?>" 
                                             class="w-full rounded-xl border border-gray-200 shadow-sm" 
                                             alt="DNI Frontal">
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlayer->doc_back): ?>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">DNI - Reverso</p>
                                        <img src="<?php echo e(asset('storage/' . $selectedPlayer->doc_back)); ?>" 
                                             class="w-full rounded-xl border border-gray-200 shadow-sm" 
                                             alt="DNI Reverso">
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Footer -->
                <div class="sticky bottom-0 bg-white px-6 py-4 border-t border-gray-200 rounded-b-3xl">
                    <button wire:click="closePlayerDetails" 
                            class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\referee\manage-match.blade.php ENDPATH**/ ?>