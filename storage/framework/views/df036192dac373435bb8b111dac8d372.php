<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$editingTeamId): ?>
    <div class="grid grid-cols-2 gap-2 mb-4">
        <button type="button" wire:click="$set('teamCreationMode', 'new')"
                class="px-3 py-3 rounded-xl text-xs font-bold border transition-colors <?php echo e($teamCreationMode === 'new' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-gray-50 text-gray-500 border-gray-100'); ?>">
            Crear desde cero
        </button>
        <button type="button" wire:click="$set('teamCreationMode', 'recent')"
                class="px-3 py-3 rounded-xl text-xs font-bold border transition-colors <?php echo e($teamCreationMode === 'recent' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-gray-50 text-gray-500 border-gray-100'); ?>">
            Equipos recientes
        </button>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teamCreationMode === 'recent'): ?>
        <p class="text-xs text-gray-500 mb-3">Equipos inscritos en torneos de tu club creados durante el último mes, aunque todavía no se hayan celebrado. Se conservan sus datos y acceso, sin grupo, jugadores ni historial.</p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['recentTeam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p role="alert" class="text-red-600 text-xs mb-3"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedRecentTeamIds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p role="alert" class="text-red-600 text-xs mb-3"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedRecentTeamIds.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p role="alert" class="text-red-600 text-xs mb-3"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="space-y-2 max-h-96 overflow-y-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentTeam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div wire:key="recent-team-<?php echo e($recentTeam->id); ?>" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50">
                    <input type="checkbox" wire:model.live="selectedRecentTeamIds" value="<?php echo e($recentTeam->id); ?>"
                           wire:loading.attr="disabled" wire:target="addSelectedRecentTeams"
                           aria-label="Seleccionar <?php echo e($recentTeam->displayName()); ?>"
                           class="w-5 h-5 shrink-0 rounded border-gray-300 text-primary focus:ring-primary">
                    <?php echo $__env->make('livewire.tournaments._mobile-match-team-logo', ['team' => $recentTeam, 'logoSize' => 'w-10 h-10'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-titanium break-words"><?php echo e($recentTeam->displayName()); ?></p>
                        <p class="text-[10px] text-gray-500"><?php echo e($recentTeam->tournament->name); ?> · Creado el <?php echo e($recentTeam->tournament->created_at->format('d/m/Y')); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentTeam->tournamentCategory): ?>
                            <p class="text-[10px] text-gray-500"><?php echo e($recentTeam->tournamentCategory->name ?? $recentTeam->tournamentCategory->category?->category); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="p-5 text-center text-sm text-gray-500 bg-gray-50 rounded-xl">No hay equipos disponibles para añadir de otros torneos de tu club creados durante el último mes. Los equipos ya inscritos en esta categoría no se muestran.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/tournaments/_recent-teams.blade.php ENDPATH**/ ?>