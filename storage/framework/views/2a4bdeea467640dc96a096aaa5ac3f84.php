<?php
    $winner = $match->winner();
    $showScore = in_array($match->status, ['completed', 'in_progress']);
?>
<div wire:key="mobile-bracket-match-<?php echo e($match->id); ?>"
     class="flex flex-col w-full h-full rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($match->notes)): ?>
        <div class="shrink-0 px-3 py-2 bg-primary/5 border-b border-gray-100">
            <span class="block text-[10px] leading-4 font-bold text-titanium break-words" title="<?php echo e($match->notes); ?>"
                  style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;"><?php echo e($match->notes); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<button type="button"
        wire:click="openGoalsModal(<?php echo e($match->id); ?>)"
        <?php if(!$match->home_team_id || !$match->away_team_id): echo 'disabled'; endif; ?>
        aria-label="Ver partido: <?php echo e($match->homeTeam?->displayName() ?? 'Por definir'); ?> contra <?php echo e($match->awayTeam?->displayName() ?? 'Por definir'); ?>"
        class="flex flex-col flex-1 min-h-0 w-full text-left bg-white enabled:active:scale-95 transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-primary disabled:cursor-default">
    <div class="w-full shrink-0 px-3 py-1.5 bg-gray-50 flex justify-between items-center gap-2">
        <span class="text-[9px] font-bold <?php echo e($match->status === 'in_progress' ? 'text-red-500' : 'text-gray-400'); ?>"><?php echo e($match->statusLabel()); ?></span>
        <span class="text-[9px] text-gray-400"><?php echo e($match->scheduled_at?->format('d/m H:i')); ?></span>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['home', 'away']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $side): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $team = $side === 'home' ? $match->homeTeam : $match->awayTeam;
            $score = $side === 'home' ? $match->home_score : $match->away_score;
            $extraScore = $side === 'home' ? $match->home_score_extra : $match->away_score_extra;
            $isWinner = $winner && $team && $winner->id === $team->id;
        ?>
        <div class="w-full shrink-0 flex items-center justify-between gap-2 px-3 py-2 <?php echo e($isWinner ? 'bg-green-50 text-green-700' : 'text-gray-600'); ?>">
            <span class="text-xs truncate <?php echo e($isWinner ? 'font-black' : 'font-bold'); ?>"><?php echo e($team?->displayName() ?? 'Por definir'); ?></span>
            <span class="shrink-0 text-xs font-black">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showScore): ?>
                    <?php echo e(($score ?? 0) + ($extraScore ?? 0)); ?>

                <?php else: ?>
                    —
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isWinner && $match->penalty_winner): ?>
                    <span class="text-[9px]">(pen.)</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</button>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/tournaments/_mobile-bracket-match.blade.php ENDPATH**/ ?>