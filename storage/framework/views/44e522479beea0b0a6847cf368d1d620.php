<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team): ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->logo): ?>
        <img src="<?php echo e(asset('storage/' . $team->logo)); ?>" alt=""
             class="<?php echo e($logoSize ?? 'w-6 h-6'); ?> rounded-md object-contain shrink-0 bg-white border border-gray-100">
    <?php elseif($team->team?->logo): ?>
        <img src="<?php echo e(Storage::url($team->team->logo)); ?>" alt=""
             class="<?php echo e($logoSize ?? 'w-6 h-6'); ?> rounded-md object-contain shrink-0 bg-white border border-gray-100">
    <?php else: ?>
        <span aria-hidden="true" class="<?php echo e($logoSize ?? 'w-6 h-6'); ?> rounded-md bg-gray-100 flex items-center justify-center shrink-0 text-[10px] font-black text-gray-400">
            <?php echo e(mb_strtoupper(mb_substr($team->displayName(), 0, 1))); ?>

        </span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/tournaments/_mobile-match-team-logo.blade.php ENDPATH**/ ?>