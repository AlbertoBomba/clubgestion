<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> <h1 class="font-bold text-2xl">Revisar historia</h1> <?php $__env->endSlot(); ?>
    <div class="max-w-5xl mx-auto py-8 px-4 space-y-8">
        <a href="<?php echo e(route('stories.index')); ?>" class="text-primary font-semibold">← Volver a moderación</a>
        <?php echo $__env->make('webclubs.stories._notice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <article class="bg-white border rounded-2xl p-6">
            <p class="text-primary font-semibold"><?php echo e($story->category?->name); ?></p>
            <h2 class="text-3xl font-bold mt-2"><?php echo e($story->title); ?></h2>
            <p class="text-sm text-gray-500 mt-3"><?php echo e($story->author_name); ?> · <?php echo e($story->author_email); ?> · <?php echo e($story->created_at->format('d/m/Y H:i')); ?></p>
            <p class="text-sm font-semibold mt-3">Estado: <?php echo e(['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$story->status]); ?></p>
            <p class="whitespace-pre-wrap break-words mt-6"><?php echo e($story->body); ?></p>
            <div class="grid sm:grid-cols-2 gap-4 mt-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $story->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-900 rounded-xl overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media->isVideo()): ?>
                            <video controls playsinline preload="metadata" src="<?php echo e(route('webclubs.stories.media', $media)); ?>" class="w-full h-80 object-contain"></video>
                        <?php else: ?>
                            <a href="<?php echo e(route('webclubs.stories.media', $media)); ?>" target="_blank" rel="noopener">
                                <img src="<?php echo e(route('webclubs.stories.media', $media)); ?>" alt="Foto <?php echo e($loop->iteration); ?> de la historia" loading="lazy" class="w-full h-80 object-contain">
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <p class="text-white text-sm p-3">Archivo <?php echo e($loop->iteration); ?> · <?php echo e(number_format($media->size / 1024 / 1024, 1)); ?> MB</p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <p class="mt-4 text-sm text-gray-500">Al aprobar la historia se publican todos sus archivos y su categoría. Al retirarla, también se ocultan sus comentarios, Me gusta y archivos.</p>
            <?php echo $__env->make('stories._review', ['kind' => 'stories', 'item' => $story], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </article>
        <section>
            <h2 class="text-2xl font-bold mb-4">Comentarios</h2>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white border rounded-xl p-5 mb-4">
                    <p class="font-semibold"><?php echo e($comment->author_name); ?> · <?php echo e($comment->author_email); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e(['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$comment->status]); ?></p>
                    <p class="whitespace-pre-wrap break-words mt-3"><?php echo e($comment->body); ?></p>
                    <?php echo $__env->make('stories._review', ['kind' => 'comments', 'item' => $comment], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500">Sin comentarios recibidos.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo e($comments->links()); ?>

        </section>
        <section>
            <h2 class="text-2xl font-bold mb-4">Me gusta</h2>
            <p class="text-gray-600"><?php echo e($story->likes_count); ?> Me gusta. Se contabilizan automáticamente y no necesitan moderación.</p>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/stories/show.blade.php ENDPATH**/ ?>