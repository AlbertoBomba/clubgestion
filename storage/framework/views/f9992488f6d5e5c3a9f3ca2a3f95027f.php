<form method="post" action="<?php echo e(route('webclubs.stories.like', ['story' => $story->id] + ($from === 'show' ? $storyContext : []))); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="from" value="<?php echo e($from); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($from === 'index'): ?>
        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
        <input type="hidden" name="page" value="<?php echo e($stories->currentPage()); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <button type="submit" <?php if($story->liked_by_visitor): echo 'disabled'; endif; ?>
        aria-label="<?php echo e($story->liked_by_visitor ? 'Ya te gusta: ' : 'Me gusta: '); ?><?php echo e($story->title); ?>"
        class="rounded-full px-4 py-2 text-sm font-semibold <?php echo e($story->liked_by_visitor ? 'bg-red-50 text-red-700 cursor-default' : 'bg-primary text-white hover:opacity-90'); ?>">
        <?php echo e($story->liked_by_visitor ? '♥ Te gusta' : '♡ Me gusta'); ?>

    </button>
</form>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/webclubs/stories/_like.blade.php ENDPATH**/ ?>