

<?php $__env->startSection('content'); ?>
<main class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-8">
            <div>
                <p class="text-primary font-semibold uppercase tracking-wider text-sm">La memoria de nuestra afición</p>
                <h1 class="text-3xl sm:text-5xl font-bold mt-3">Cuéntanos tu historia</h1>
                <p class="text-gray-600 mt-4 max-w-2xl">Ese torneo inolvidable, tu primer partido, los amigos de siempre. Comparte los momentos que nos unen a <?php echo e(tenantName()); ?>.</p>
            </div>
            <a href="<?php echo e(route('webclubs.stories.create')); ?>" class="bg-primary text-white font-semibold px-6 py-3 rounded-full">+ Compartir mi historia</a>
        </div>
        <?php echo $__env->make('webclubs.stories._notice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <form method="get" action="<?php echo e(route('webclubs.stories.index')); ?>" class="flex flex-wrap items-end gap-3 mb-8">
            <div>
                <label for="category" class="block text-sm font-semibold mb-2">Explorar por categoría</label>
                <select id="category" name="category" onchange="this.form.requestSubmit()" class="rounded-lg border-gray-300">
                    <option value="">Todas las historias</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php if(request('category') == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            <noscript><button class="rounded-lg border border-gray-300 bg-white px-5 py-2">Filtrar</button></noscript>
        </form>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stories->isNotEmpty()): ?>
            <div class="flex gap-5 overflow-x-auto pb-6 mb-4" aria-label="Historias recientes">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('webclubs.stories.show', ['story' => $story->id] + $storyContext)); ?>" class="flex-shrink-0 text-center w-24">
                        <div class="rounded-full border-4 border-primary p-1 w-20 h-20 mx-auto bg-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($story->media->first() && !$story->media->first()->isVideo()): ?>
                                <img src="<?php echo e(route('webclubs.stories.media', $story->media->first())); ?>" alt="" loading="lazy" class="rounded-full w-full h-full object-cover">
                            <?php else: ?>
                                <span class="flex items-center justify-center rounded-full w-full h-full bg-gray-100 text-primary text-2xl font-bold"><?php echo e(mb_substr($story->author_name, 0, 1)); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <span class="block mt-2 text-sm truncate"><?php echo e($story->author_name); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="rounded-2xl overflow-hidden bg-white border border-gray-200 shadow-sm">
                    <a href="<?php echo e(route('webclubs.stories.show', ['story' => $story->id] + $storyContext)); ?>" class="block relative bg-gray-900">
                        <?php if($story->media->first()): ?>
                            <?php if($story->media->first()->isVideo()): ?>
                                <video data-story-feed-video src="<?php echo e(route('webclubs.stories.media', $story->media->first())); ?>" preload="metadata" muted playsinline loop controls class="w-full h-72 object-cover" aria-label="Vídeo de <?php echo e($story->title); ?>"></video>
                                <span data-story-video-status class="absolute top-4 left-4 bg-black text-white rounded-full px-3 py-1 text-xs" role="status"></span>
                            <?php else: ?>
                                <img src="<?php echo e(route('webclubs.stories.media', $story->media->first())); ?>" alt="<?php echo e($story->title); ?>" loading="lazy" class="w-full h-72 object-cover">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="absolute top-4 right-4 rounded-full bg-black text-white px-3 py-1 text-sm"><?php echo e($story->media->count()); ?> archivos</span>
                        <?php else: ?>
                            <div class="h-72 flex items-center justify-center bg-primary text-white text-7xl font-bold"><?php echo e(mb_substr($story->author_name, 0, 1)); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                    <div class="p-5">
                        <a href="<?php echo e(route('webclubs.stories.index', ['category' => $story->story_category_id])); ?>" class="text-xs font-semibold text-primary"><?php echo e($story->category->name); ?></a>
                        <h2 class="font-bold text-xl mt-2"><a href="<?php echo e(route('webclubs.stories.show', ['story' => $story->id] + $storyContext)); ?>"><?php echo e($story->title); ?></a></h2>
                        <p class="text-sm text-gray-500 mt-2"><?php echo e($story->author_name); ?> · <?php echo e($story->published_at->format('d/m/Y')); ?></p>
                        <p class="text-gray-600 mt-3"><?php echo e(\Illuminate\Support\Str::limit($story->body, 160)); ?></p>
                        <p class="text-sm text-gray-500 mt-4"><?php echo e($story->likes_count); ?> Me gusta · <?php echo e($story->approved_comments_count); ?> comentarios</p>
                        <div class="flex items-center justify-between gap-3 border-t mt-4 pt-4 text-sm">
                            <?php echo $__env->make('webclubs.stories._like', ['from' => 'index'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <a class="text-primary font-semibold" href="<?php echo e(route('webclubs.stories.show', ['story' => $story->id] + $storyContext)); ?>">Ver historia</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="sm:col-span-2 lg:col-span-3 rounded-2xl bg-white border p-12 text-center">
                    <h2 class="font-bold text-2xl">Aquí empieza nuestra historia</h2>
                    <p class="text-gray-600 mt-3">Todavía no hay historias publicadas en esta selección. ¡Anímate a compartir la tuya!</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="mt-8"><?php echo e($stories->links()); ?></div>
        <p class="text-center text-sm text-gray-500 mt-8">Las historias y los comentarios se revisan antes de publicarse. Los Me gusta se contabilizan al instante.</p>
       
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

  

<?php echo $__env->make('livewire.webclubs.layouts.app', ['title' => 'Cuéntanos tu historia - ' . tenantName()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/webclubs/stories/index.blade.php ENDPATH**/ ?>