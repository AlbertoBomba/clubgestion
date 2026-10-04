<div class="min-h-screen bg-gray-50 pb-28 relative">

    
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-3 min-w-0">
            <a href="<?php echo e(route('players.index')); ?>" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all shrink-0"
               title="Volver">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="min-w-0">
               
                <p class="text-[11px] font-bold text-gray-400 truncate">Formulario de Inscripción</p>
            </div>
        </div>
    </header>

    <form wire:submit="save" id="player-form" class="p-4 space-y-4">

        
        <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
            <h2 class="font-black text-base text-titanium border-b border-gray-50 pb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Datos del Jugador
            </h2>

            
            <div class="flex flex-col items-center justify-center py-2">
                <div class="relative mb-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player_photo): ?>
                        <img src="<?php echo e($player_photo->temporaryUrl()); ?>" class="w-28 h-28 rounded-full object-cover border-4 border-primary/20 shadow-md">
                    <?php else: ?>
                        <div class="w-28 h-28 rounded-full bg-primary/10 border-2 border-dashed border-primary/30 flex flex-col items-center justify-center text-primary shadow-sm">
                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                            <span class="text-[10px] font-extrabold uppercase">Sin Foto</span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <label class="absolute bottom-0 right-0 p-2.5 bg-primary text-white rounded-full shadow-lg cursor-pointer active:scale-95 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <input type="file" wire:model.live="player_photo" accept="image/*" class="hidden">
                    </label>
                </div>

                <div wire:loading wire:target="player_photo" class="text-xs font-bold text-primary flex items-center gap-1.5 my-1">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Subiendo fotografía...</span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['player_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1 text-center"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input wire:model.live="name" type="text" placeholder="Ej: Lucas"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Apellidos <span class="text-red-500">*</span></label>
                    <input wire:model.live="surname" type="text" placeholder="Ej: García Martínez"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">DNI / NIE</label>
                        <input wire:model.live="dni" type="text" placeholder="12345678X"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <?php if (isset($component)) { $__componentOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.date-input','data' => ['label' => 'F. Nacimiento','model' => 'dbirth','error' => 'dbirth']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('date-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'F. Nacimiento','model' => 'dbirth','error' => 'dbirth']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1)): ?>
<?php $attributes = $__attributesOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1; ?>
<?php unset($__attributesOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1)): ?>
<?php $component = $__componentOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1; ?>
<?php unset($__componentOriginal2c7cd37e2e80199b9dbc9a9aa91b96b1); ?>
<?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Año Nac.</label>
                        <input wire:model.live="dbanio" type="number" placeholder="2012"
                               class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium text-center focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['dbanio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dorsal</label>
                        <input wire:model.live="dorsal" type="number" placeholder="10"
                               class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium text-center focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['dorsal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Talla</label>
                        <button type="button" wire:click="openSizesModal" 
                                class="w-full py-3.5 px-2 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-primary flex items-center justify-between active:scale-95 transition-all">
                            <span class="truncate"><?php echo e($sizes ?: 'Elegir'); ?></span>
                            <svg class="w-3.5 h-3.5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sizes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
            <h2 class="font-black text-base text-titanium border-b border-gray-50 pb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                Datos Deportivos
            </h2>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Posición</label>
                    <input wire:model.live="position" type="text" placeholder="Ej: Delantero"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Cód. Matrícula</label>
                    <input wire:model.live="cod_matricula" type="text" placeholder="MAT-2026"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cod_matricula'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="space-y-2 pt-1">
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-gray-100 bg-gray-50/50 cursor-pointer select-none">
                    <span class="text-xs font-bold text-titanium">Jugador Activo</span>
                    <input wire:model.live="active" type="checkbox" id="active" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                </label>

                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-gray-100 bg-gray-50/50 cursor-pointer select-none">
                    <span class="text-xs font-bold text-titanium">Es Portero / Guardameta</span>
                    <input wire:model.live="goalie" type="checkbox" id="goalie" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                </label>

                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-gray-100 bg-gray-50/50 cursor-pointer select-none">
                    <span class="text-xs font-bold text-titanium">Ficha Entregada / Completa</span>
                    <input wire:model.live="file" type="checkbox" id="file" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                </label>
            </div>

            
            <div class="space-y-2 pt-2 border-t border-gray-50">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Equipo Asignado</span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedTeam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teams->isEmpty()): ?>
                    <p class="text-xs font-bold text-gray-400 p-3 bg-gray-50 rounded-2xl text-center">No hay equipos disponibles para esta temporada.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <label class="p-3.5 rounded-2xl border-2 transition-all cursor-pointer flex items-center justify-between <?php echo e($selectedTeam === null ? 'border-primary bg-primary/5 text-primary' : 'border-gray-100 bg-gray-50/50 text-titanium'); ?>">
                            <div class="flex items-center gap-2">
                                <input type="radio" wire:model.live="selectedTeam" value="" class="w-4 h-4 text-primary border-gray-300">
                                <span class="text-xs font-bold">Sin equipo asignado</span>
                            </div>
                        </label>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="p-3.5 rounded-2xl border-2 transition-all cursor-pointer flex items-center justify-between <?php echo e($selectedTeam == $team->id ? 'border-primary bg-primary/5 text-primary' : 'border-gray-100 bg-gray-50/50 text-titanium'); ?>">
                                <div class="flex items-center gap-2 min-w-0">
                                    <input type="radio" wire:model.live="selectedTeam" value="<?php echo e($team->id); ?>" class="w-4 h-4 text-primary border-gray-300">
                                    <div class="truncate">
                                        <p class="text-xs font-bold truncate leading-tight"><?php echo e($team->team); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->category): ?><p class="text-[10px] font-bold text-gray-400 truncate"><?php echo e($team->category->category); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="space-y-2 pt-2 border-t border-gray-50">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Secciones Participantes</span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedSections'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="grid grid-cols-2 gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <label class="p-3 rounded-2xl border-2 transition-all cursor-pointer flex items-center gap-2.5 <?php echo e(in_array($section->id, $selectedSections) ? 'border-primary bg-primary/5 text-primary' : 'border-gray-100 bg-gray-50/50 text-titanium'); ?>">
                            <input type="checkbox" wire:model.live="selectedSections" value="<?php echo e($section->id); ?>" class="w-4 h-4 text-primary border-gray-300 rounded">
                            <span class="text-xs font-bold truncate"><?php echo e($section->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="col-span-2 text-xs font-bold text-gray-400 p-3 bg-gray-50 rounded-2xl text-center">No hay secciones configuradas.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>

        
        <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
            <h2 class="font-black text-base text-titanium border-b border-gray-50 pb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Descuento de Cuota
            </h2>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tipo de Descuento</label>
                <select wire:model.live="discountType" 
                        class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <option value="ninguno">Sin descuento</option>
                    <option value="cantidad">Descuento en cantidad (€)</option>
                    <option value="porcentaje">Descuento en porcentaje (%)</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['discountType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discountType === 'cantidad'): ?>
                <div class="p-3 bg-amber-50 rounded-2xl border border-amber-100">
                    <label class="block text-[10px] font-bold text-amber-800 uppercase tracking-wider mb-1">Importe Descuento (€)</label>
                    <input wire:model.live="descEnt" type="text" onfocus="this.select()" placeholder="0,00"
                           class="w-full px-4 py-3 bg-white border-0 rounded-xl text-xs font-black text-amber-900 focus:ring-2 focus:ring-amber-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['descEnt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discountType === 'porcentaje'): ?>
                <div class="p-3 bg-amber-50 rounded-2xl border border-amber-100">
                    <label class="block text-[10px] font-bold text-amber-800 uppercase tracking-wider mb-1">Porcentaje Descuento (%)</label>
                    <input wire:model.live="descPerc" type="text" onfocus="this.select()" placeholder="0,00"
                           class="w-full px-4 py-3 bg-white border-0 rounded-xl text-xs font-black text-amber-900 focus:ring-2 focus:ring-amber-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['descPerc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </section>

        
        <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
            <h2 class="font-black text-base text-titanium border-b border-gray-50 pb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Tutor y Contacto
            </h2>

            
            <div class="space-y-3">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Datos del Tutor Legal</span>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre Tutor</label>
                    <input wire:model.live="nametutor" type="text" placeholder="Ej: Manuel"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nametutor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Apellidos Tutor</label>
                        <input wire:model.live="surnametutor" type="text" placeholder="García Fernández"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['surnametutor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">DNI Tutor</label>
                        <input wire:model.live="dnitutor" type="text" placeholder="12345678X"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['dnitutor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="space-y-3 pt-2 border-t border-gray-50">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Contacto Directo</span>
                
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Teléfono Principal</label>
                        <input wire:model.live="phone1" type="tel" placeholder="600000000"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Teléfono Secundario</label>
                        <input wire:model.live="phone2" type="tel" placeholder="600000000"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email de Contacto</label>
                    <input wire:model.live="email" type="email" placeholder="correo@ejemplo.com"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="space-y-3 pt-2 border-t border-gray-50">
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Dirección</span>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Dirección Completa</label>
                    <input wire:model.live="address" type="text" placeholder="Calle, número, piso..."
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div class="col-span-1">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">C.P.</label>
                        <input wire:model.live="zip" type="text" maxlength="5" placeholder="41000"
                               class="w-full px-3 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium text-center focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Población</label>
                        <input wire:model.live="town" type="text" placeholder="Población"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['town'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Provincia</label>
                    <input wire:model.live="province" type="text" placeholder="Provincia"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="pt-2 border-t border-gray-50">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Observaciones / Notas</label>
                <textarea wire:model.live="observations" rows="3" placeholder="Información médica, alérgica o notas adicionales..."
                          class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['observations'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-[10px] font-bold mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>

    </form>

    
    <div class="fixed bottom-0  flex-col items-start  left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex items-center gap-3">

        <div class="flex gap-2 w-full">
            <a href="<?php echo e(route('players.index')); ?>" 
            class="flex-1 py-4 bg-gray-100 text-titanium font-black text-sm rounded-2xl active:scale-95 transition-all text-center">
                Cancelar
            </a>

            <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save"
                    class="flex-[2] py-4 bg-blue-600 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2 disabled:opacity-60">
                <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Guardar Jugador</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>
         <h1 class="font-black text-lg text-titanium truncate leading-tight">
            Nuevo Jugador
        </h1>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSizesModal): ?>
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm"
             wire:keydown.window.escape="closeSizesModal">
            
            <div class="bg-white-pure w-full max-h-[85vh] rounded-t-3xl sm:rounded-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                
                
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="font-black text-lg text-titanium flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Seleccionar Talla
                    </h3>
                    <button type="button" wire:click="closeSizesModal" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>

                
                <div class="p-5 overflow-y-auto space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableSizes->isEmpty()): ?>
                        <div class="text-center py-8 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <p class="text-xs font-bold text-gray-400 mb-1">No hay tallas configuradas</p>
                            <p class="text-[10px] text-gray-400">Asocia marcas y tallas en la configuración de la escuela.</p>
                        </div>
                    <?php else: ?>
                        <?php $currentBrand = null; ?>

                        <div class="grid grid-cols-2 gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentBrand !== $size->brand_id): ?>
                                    <?php $currentBrand = $size->brand_id; ?>
                                    <div class="col-span-2 pt-2 pb-1 border-b border-gray-100">
                                        <span class="text-[10px] font-black uppercase text-primary tracking-wider">
                                            Marca: <?php echo e($size->brand->brand ?? 'General'); ?>

                                        </span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <button type="button" wire:click="selectSize(<?php echo e($size->id); ?>)"
                                        class="p-3.5 rounded-2xl border-2 text-center transition-all active:scale-95 flex flex-col items-center justify-center gap-0.5
                                            <?php echo e($sizes === $size->size ? 'border-primary bg-primary/10 text-primary shadow-sm' : 'border-gray-100 bg-gray-50/50 text-titanium'); ?>">
                                    <span class="text-base font-black"><?php echo e($size->size); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($size->description): ?>
                                        <span class="text-[9px] font-bold text-gray-400 block"><?php echo e($size->description); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="p-4 border-t border-gray-100 bg-white shrink-0">
                    <button type="button" wire:click="closeSizesModal" 
                            class="w-full py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95 transition-all">
                        Cerrar Ventana
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <style>
        .animate-slideUp { animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
    </style>

</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\players\create_mobile.blade.php ENDPATH**/ ?>