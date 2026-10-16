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
     <?php $__env->slot('header', null, []); ?> <h1 class="font-bold text-2xl">Historias de aficionados</h1> <?php $__env->endSlot(); ?>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <?php echo $__env->make('webclubs.stories._notice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <p class="text-gray-600 mb-6">Revisa las historias y comentarios de tu club antes de hacerlos públicos. Los Me gusta no necesitan aprobación.</p>
        <div class="flex flex-wrap gap-3 mb-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['stories' => 'Historias', 'comments' => 'Comentarios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('stories.index', ['kind' => $type, 'status' => $status])); ?>" class="px-4 py-3 rounded-lg border <?php echo e($kind === $type ? 'bg-primary text-white' : 'bg-white'); ?>"><?php echo e($label); ?> · <?php echo e($pending[$type]); ?> pendientes</a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <form method="get" action="<?php echo e(route('stories.index')); ?>" class="flex items-end gap-3 mb-6">
            <input type="hidden" name="kind" value="<?php echo e($kind); ?>">
            <label class="text-sm font-semibold">Estado
                <select name="status" class="block rounded-lg border-gray-300 mt-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['pending' => 'Pendientes', 'approved' => 'Aprobados', 'rejected' => 'Rechazados', 'all' => 'Todos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if($status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </label>
            <button class="bg-white border rounded-lg px-4 py-2">Filtrar</button>
        </form>
        <div class="space-y-5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white border rounded-xl p-6">
                    <div class="flex flex-wrap justify-between gap-3">
                        <h2 class="font-bold text-xl">
                            <a class="text-primary" href="<?php echo e(route('stories.show', $kind === 'stories' ? $item->id : $item->club_story_id)); ?>"><?php echo e($kind === 'stories' ? $item->title : $item->story->title); ?></a>
                        </h2>
                        <span class="text-sm font-semibold"><?php echo e(['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$item->status]); ?></span>
                    </div>
                        <p class="text-sm text-gray-500 mt-2"><?php echo e($item->author_name); ?> · <?php echo e($item->author_email); ?></p>
                        <p class="whitespace-pre-wrap break-words mt-3"><?php echo e(\Illuminate\Support\Str::limit($item->body, 500)); ?></p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kind === 'stories'): ?>
                        <p class="text-sm mt-3"><?php echo e($item->category?->name); ?> · <?php echo e($item->comments_count); ?> comentarios · <?php echo e($item->likes_count); ?> Me gusta</p>
                        <a href="<?php echo e(route('stories.show', $item)); ?>" class="inline-block mt-4 font-semibold text-primary">Revisar texto y archivos →</a>
                    <?php else: ?>
                        <?php echo $__env->make('stories._review', ['kind' => $kind, 'item' => $item], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="bg-white border rounded-xl p-8 text-gray-500">No hay elementos con estos filtros.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="mt-6"><?php echo e($items->links()); ?></div>
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
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/stories/index.blade.php ENDPATH**/ ?>