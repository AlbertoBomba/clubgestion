<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($story->media->isNotEmpty()): ?>
    <section data-story-viewer class="story-viewer rounded-2xl overflow-hidden bg-black text-white relative mx-auto" aria-label="Fotos y vídeos de la historia" tabindex="0">
        <div class="absolute top-0 inset-x-0 z-10 p-4 bg-gradient-to-b from-black to-transparent">
            <div class="flex gap-1 mb-3" aria-hidden="true">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $story->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="h-1 flex-1 bg-gray-600 rounded-full overflow-hidden"><div data-story-progress class="bg-white h-full" style="width:0%"></div></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="flex justify-between gap-3 items-center">
                <span data-story-counter aria-live="polite" class="text-sm">1 / <?php echo e($story->media->count()); ?></span>
                <button type="button" data-story-play class="text-sm bg-black px-3 py-2 rounded-lg" aria-pressed="false">Reproducción automática</button>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $story->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div data-story-slide <?php if(!$loop->first): ?> hidden <?php endif; ?> class="story-slide">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media->isVideo()): ?>
                    <video controls muted playsinline preload="metadata" class="w-full h-full object-contain" src="<?php echo e(route('webclubs.stories.media', $media)); ?>" aria-label="Vídeo <?php echo e($loop->iteration); ?> de <?php echo e($story->title); ?>"></video>
                <?php else: ?>
                    <a data-story-enlarge href="<?php echo e(route('webclubs.stories.media', $media)); ?>" target="_blank" rel="noopener" class="block w-full h-full cursor-zoom-in" aria-label="Ampliar foto <?php echo e($loop->iteration); ?> de <?php echo e($story->title); ?>">
                        <img src="<?php echo e(route('webclubs.stories.media', $media)); ?>" alt="Foto <?php echo e($loop->iteration); ?> de <?php echo e($story->title); ?>" class="w-full h-full object-contain" <?php if(!$loop->first): ?> loading="lazy" <?php endif; ?>>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="absolute bottom-16 inset-x-0 flex justify-between px-3 pointer-events-none">
            <button type="button" data-story-prev class="pointer-events-auto bg-black rounded-full w-10 h-10 border border-gray-600" aria-label="Archivo anterior">←</button>
            <button type="button" data-story-next class="pointer-events-auto bg-black rounded-full w-10 h-10 border border-gray-600" aria-label="Archivo siguiente">→</button>
        </div>
        <dialog data-story-lightbox class="story-lightbox" aria-label="Imagen ampliada">
            <button type="button" data-story-lightbox-close class="story-lightbox-close" aria-label="Cerrar imagen ampliada" autofocus>×</button>
            <img data-story-lightbox-image alt="" class="story-lightbox-image">
        </dialog>
    </section>
    <p class="text-sm text-gray-500 text-center mt-3">Pulsa una foto para ampliarla. Usa las flechas, desliza a los lados o activa la reproducción automática.</p>
    <noscript>
        <div class="space-y-4 mt-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $story->media->skip(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media->isVideo()): ?>
                    <video controls playsinline class="w-full" src="<?php echo e(route('webclubs.stories.media', $media)); ?>"></video>
                <?php else: ?>
                    <img src="<?php echo e(route('webclubs.stories.media', $media)); ?>" alt="<?php echo e($story->title); ?>" class="w-full">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </noscript>
    <?php $__env->startPush('styles'); ?>
        <style>
            .story-viewer { width: 100%; max-width: 430px; }
            .story-slide { height: min(75vh, 740px); min-height: 320px; }
            .story-slide[hidden] { display: none; }
            .story-lightbox { position: fixed; inset: 0; margin: auto; padding: 0; border: 0; width: 96vw; max-width: none; height: 94vh; height: 94dvh; max-height: none; background: #090c12; color: white; border-radius: 1rem; }
            .story-lightbox::backdrop { background: #000e; }
            .story-lightbox-image { width: 100%; height: 100%; object-fit: contain; }
            .story-lightbox-close { position: absolute; top: .75rem; right: .75rem; z-index: 1; width: 2.75rem; height: 2.75rem; border-radius: 999px; background: #000c; color: white; border: 1px solid #fff8; font-size: 1.75rem; }
        </style>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/webclubs/stories/_viewer.blade.php ENDPATH**/ ?>