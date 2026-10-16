

<?php $__env->startSection('content'); ?>
<main class="bg-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <a href="<?php echo e(route('webclubs.stories.index', array_filter(['category' => $storyContext['category'] ?? null, 'page' => $storyContext['feed_page'] ?? null]))); ?>" class="text-primary font-semibold">← Todas las historias</a>
        <div class="mt-6"><?php echo $__env->make('webclubs.stories._notice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
        <div class="grid md:grid-cols-2 gap-8 items-start">
            <div><?php echo $__env->make('webclubs.stories._viewer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
            <article class="bg-white border rounded-2xl p-6">
                <a href="<?php echo e(route('webclubs.stories.index', ['category' => $story->story_category_id])); ?>" class="text-primary text-sm font-semibold"><?php echo e($story->category->name); ?></a>
                <h1 class="text-3xl font-bold mt-3"><?php echo e($story->title); ?></h1>
                <p class="text-gray-500 text-sm mt-3"><?php echo e($story->author_name); ?> · <?php echo e($story->published_at->format('d/m/Y')); ?></p>
                <p class="whitespace-pre-wrap break-words mt-6 text-gray-700"><?php echo e($story->body); ?></p>
                <div class="border-t mt-6 pt-6">
                    <p class="font-semibold mb-3"><?php echo e($story->likes_count); ?> Me gusta</p>
                    <?php echo $__env->make('webclubs.stories._like', ['from' => 'show'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <p class="text-xs text-gray-500 mt-2">Un Me gusta por navegador. Se contabiliza al instante.</p>
                </div>
            </article>
        </div>
        <section class="max-w-3xl mx-auto mt-12" aria-label="Comentarios">
            <h2 class="text-2xl font-bold mb-6">Comentarios</h2>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="bg-white border rounded-xl p-5">
                        <p class="font-semibold"><?php echo e($comment->author_name); ?> <span class="font-normal text-sm text-gray-500">· <?php echo e($comment->created_at->format('d/m/Y')); ?></span></p>
                        <p class="whitespace-pre-wrap break-words mt-3 text-gray-700"><?php echo e($comment->body); ?></p>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500">Todavía no hay comentarios publicados. Comparte tu recuerdo.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="mt-6"><?php echo e($comments->links()); ?></div>
            <form method="post" action="<?php echo e(route('webclubs.stories.comment', ['story' => $story->id] + $storyContext)); ?>" class="bg-white border rounded-2xl p-6 space-y-5 mt-8">
                <?php echo csrf_field(); ?>
                <h3 class="text-xl font-bold">Añadir un comentario</h3>
                <p class="text-sm text-gray-500">El club revisará tu comentario antes de publicarlo. Nombre y correo son opcionales; si no indicas un nombre aparecerás como Anónimo. Tu correo no se mostrará.</p>
                <?php echo $__env->make('webclubs.stories._identity', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div>
                    <label for="body" class="block font-semibold mb-2">Tu comentario</label>
                    <textarea id="body" name="body" required maxlength="2000" rows="4" class="w-full rounded-lg border-gray-300"><?php echo e(old('body')); ?></textarea>
                </div>
                <?php echo $__env->make('webclubs.stories._consent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <button class="bg-primary text-white rounded-full px-6 py-3 font-semibold">Enviar para revisión</button>
            </form>
        </section>
    </div>
     <!-- Nuestros Patrocinadores -->
    <?php if (isset($component)) { $__componentOriginala2330208f20b2ec932812bb858503157 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2330208f20b2ec932812bb858503157 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.webclubs.sponsors','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('webclubs.sponsors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2330208f20b2ec932812bb858503157)): ?>
<?php $attributes = $__attributesOriginala2330208f20b2ec932812bb858503157; ?>
<?php unset($__attributesOriginala2330208f20b2ec932812bb858503157); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2330208f20b2ec932812bb858503157)): ?>
<?php $component = $__componentOriginala2330208f20b2ec932812bb858503157; ?>
<?php unset($__componentOriginala2330208f20b2ec932812bb858503157); ?>
<?php endif; ?>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('livewire.webclubs.layouts.app', ['title' => $story->title . ' - ' . tenantName()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/webclubs/stories/show.blade.php ENDPATH**/ ?>