<div class="min-h-screen bg-gray-50 pb-28 relative">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-2xl shadow-sm">
            <p class="text-sm text-neon-green font-bold"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="m-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
            <p class="text-sm text-red-700 font-bold"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-2.5 min-w-0">
            <a href="<?php echo e(route('teams.index')); ?>" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="min-w-0">
               
                <p class="text-[11px] font-bold text-gray-400">
                    Edición de equipo
                </p>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($federate): ?>
            <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-[10px] uppercase tracking-wider flex-shrink-0 flex items-center gap-1">
                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Federado
            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </header>

    <div class="p-4 space-y-4">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasChanges): ?>
            <div class="p-4 bg-yellow-500/10 border-l-4 border-yellow-500 rounded-2xl flex items-center gap-3 animate-pulse">
                <span class="text-lg">⚠️</span>
                <p class="text-xs font-bold text-yellow-800">
                    Tienes cambios sin guardar. Toca en <span class="underline">Actualizar</span> abajo para guardarlos.
                </p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <form wire:submit.prevent="save" id="team-form" class="space-y-4">

            
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Datos del Equipo
                </h3>

                
                <div class="space-y-2 text-center">
                    <span class="block text-xs font-bold text-titanium uppercase tracking-wider text-left">Imagen del Equipo</span>
                    
                    <div class="relative inline-block w-full">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teamImage): ?>
                            <img src="<?php echo e($teamImage->temporaryUrl()); ?>" class="w-full h-36 rounded-2xl object-cover border-2 border-primary shadow-sm">
                        <?php elseif($team->team_image): ?>
                            <img src="<?php echo e(asset('storage/' . $team->team_image)); ?>" class="w-full h-36 rounded-2xl object-cover border border-gray-200 shadow-sm">
                        <?php else: ?>
                            <div class="w-full h-36 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-semibold">Sin imagen asignada</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <label class="block w-full py-3 bg-gray-100 text-titanium font-bold text-xs rounded-2xl active:scale-95 text-center cursor-pointer">
                        📷 Seleccionar Nueva Imagen
                        <input type="file" wire:model.live="teamImage" accept="image/*" class="hidden">
                    </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['teamImage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="space-y-3 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Nombre del Equipo *</label>
                        <input wire:model.live="teamName" type="text" 
                               class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['teamName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Descripción</label>
                        <input wire:model.live="description" type="text" 
                               class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Categoría *</label>
                            <select wire:model.live="category_id" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                                <option value="">Seleccionar...</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Género *</label>
                            <select wire:model.live="gender" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="mixto">Mixto</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Temporada</label>
                            <input type="text" value="<?php echo e($seasons->firstWhere('id', $season_id)?->season ?? 'No asignada'); ?>" disabled
                                   class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-2xl text-sm font-semibold cursor-not-allowed border-0">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Sección</label>
                            <input type="text" value="<?php echo e($sections->firstWhere('id', $section_id)?->name ?? 'No asignada'); ?>" disabled
                                   class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-2xl text-sm font-semibold cursor-not-allowed border-0">
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Precio Matrícula (€)</label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0): ?>
                            <input type="text" value="<?php echo e($price); ?>" disabled
                                   class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-2xl text-sm font-bold cursor-not-allowed border-0">
                            <p class="text-[11px] text-blue-700 font-semibold mt-1">Este equipo tiene <?php echo e($team->payments_count); ?> pagos generados. Precio bloqueado.</p>
                        <?php else: ?>
                            <input wire:model.live="price" type="text" inputmode="decimal" placeholder="0.00"
                                   class="w-full px-4 py-3 border-0 rounded-2xl text-black-deep text-sm font-black focus:ring-2 <?php echo e(empty($price) || $price == 0 ? 'bg-amber-50 text-amber-900 ring-1 ring-amber-300' : 'bg-gray-50 focus:ring-primary'); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($price) || $price == 0): ?>
                                <p class="text-[11px] text-amber-700 font-bold mt-1">⚠️ No se generará orden de pago si la matrícula es 0.</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="space-y-2 pt-2">
                        <label class="flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer select-none <?php if($federate): ?> border-primary bg-blue-50/60 <?php else: ?> border-gray-100 bg-gray-50/50 <?php endif; ?>">
                            <input type="checkbox" wire:model.live="federate" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="text-sm font-bold text-titanium">Equipo Federado</span>
                        </label>

                        <label class="flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer select-none <?php if($published): ?> border-green-500 bg-green-50/60 <?php else: ?> border-gray-100 bg-gray-50/50 <?php endif; ?>">
                            <input type="checkbox" wire:model.live="published" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-600">
                            <span class="text-sm font-bold text-titanium">Publicar en Web Pública</span>
                        </label>
                    </div>
                </div>
            </section>

            
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h3 class="font-bold text-base text-titanium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Entrenadores (<?php echo e($assignedCoaches->count()); ?>)
                    </h3>
                    <button type="button" wire:click="openAddCoachModal" 
                            class="px-3 py-1.5 bg-primary text-white rounded-xl text-xs font-bold active:scale-95 transition-all">
                        + Asignar
                    </button>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assignedCoaches->isEmpty()): ?>
                    <p class="text-xs text-gray-400 text-center py-3">Sin entrenadores asignados a este equipo.</p>
                <?php else: ?>
                    <div class="space-y-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $assignedCoaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex items-center gap-3 min-w-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coach->profile_photo_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $coach->profile_photo_path)); ?>" class="w-9 h-9 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    <?php else: ?>
                                        <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            <?php echo e(substr($coach->name, 0, 1)); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="min-w-0">
                                        <p class="font-bold text-xs text-titanium truncate"><?php echo e($coach->name); ?></p>
                                        <p class="text-[10px] text-gray-400 truncate"><?php echo e($coach->email); ?></p>
                                    </div>
                                </div>
                                <button type="button" wire:click="confirmRemoveCoach(<?php echo e($coach->id); ?>)" class="p-2 text-red-600 bg-red-50 rounded-xl active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </section>
        </form>

        
        <section class="space-y-3 pt-2">
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-base text-titanium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Jugadores (<?php echo e($teamPlayers->count()); ?>)
                    </h3>

                    <button type="button" wire:click="openAddPlayerModal" wire:loading.attr="disabled" wire:target="openAddPlayerModal"
                            class="px-3.5 py-2 bg-primary text-white font-bold text-xs rounded-xl active:scale-95 transition-all flex items-center gap-1.5 shadow-sm">
                        <svg wire:loading.remove wire:target="openAddPlayerModal" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Agregar</span>
                    </button>
                </div>

                
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="search" wire:model.live.debounce.300ms="searchPlayer" placeholder="Buscar por nombre o DNI..."
                               class="w-full pl-9 pr-3 py-2.5 bg-white-pure border border-gray-100 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <button type="button" wire:click="openPdfModal" class="px-3 py-2.5 bg-green-50 text-green-700 font-bold text-xs rounded-2xl active:scale-95 transition-all flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        PDF / Excel
                    </button>
                </div>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teamPlayers->isEmpty()): ?>
                <div class="bg-white-pure rounded-3xl p-8 text-center border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400">No hay jugadores asignados a este equipo.</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamPlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="bg-white-pure rounded-3xl p-4 shadow-sm border border-gray-100 space-y-3">
                            
                            
                            <div class="flex items-center gap-3">
                                
                                <div class="flex-shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->player_photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $player->player_photo)); ?>" alt="<?php echo e($player->name); ?>" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shadow-sm">
                                            <?php echo e(substr($player->name, 0, 1)); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-sm text-titanium truncate leading-snug">
                                        <?php echo e($player->name); ?> <?php echo e($player->surname); ?>

                                    </h4>
                                    <p class="text-[11px] font-semibold text-gray-400 truncate">
                                        DNI: <?php echo e($player->dni ?: '-'); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?> • Dorsal: #<?php echo e($player->dorsal); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                </div>

                                
                                <div class="flex-shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->active): ?>
                                        <span class="px-2.5 py-1 rounded-full bg-neon-green/10 text-neon-green text-[10px] font-extrabold uppercase tracking-wider">Activo</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-extrabold uppercase tracking-wider">Inactivo</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="grid grid-cols-2 gap-2 bg-gray-50 rounded-2xl p-2.5 text-xs">
                                
                                <div class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Estado y posición</span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->file): ?>
                                        <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-[10px] font-bold inline-block">Completa</span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-[10px] font-bold inline-block">Incompleta</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->goalie): ?>
                                        <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-[10px] font-bold inline-block">Portero - <?php echo e($player->dorsal ?? '-'); ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-[10px] font-bold inline-block">J. Campo - <?php echo e($player->dorsal ?? '-'); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Fecha Nacimiento</span>
                                    <span class="font-extrabold text-titanium text-xs block">
                                        <?php echo e($player->dbirth ? $player->dbirth->format('d/m/Y') : '-'); ?>

                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dbirth): ?>
                                        <span class="text-[10px] text-gray-400 block font-semibold">
                                            <?php echo e(\Carbon\Carbon::parse($player->dbirth)->age); ?> años
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($player->observations)): ?>
                                <div class="p-2 bg-red-50 border border-red-100 rounded-xl text-xs font-semibold text-red-700 flex items-center gap-1.5">
                                    <span class="text-sm">⚠️</span>
                                    <span class="truncate"><?php echo e($player->observations); ?></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <div class="flex items-center gap-1.5 pt-1 border-t border-gray-50">
                                <button type="button" wire:click="openEditPlayerModal(<?php echo e($player->id); ?>)"
                                        class="flex-1 py-2.5 bg-amber-50 text-amber-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Editar
                                </button>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->player_photo || !empty($player->documents)): ?>
                                    <button type="button" wire:click="downloadPlayerDocuments(<?php echo e($player->id); ?>)" 
                                            class="flex-1 py-2.5 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                        Docs
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <button type="button" wire:click="openMovePlayerModal(<?php echo e($player->id); ?>)" 
                                        class="flex-1 py-2.5 bg-blue-50 text-blue-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Mover
                                </button>

                                <button type="button" wire:click="confirmRemovePlayer(<?php echo e($player->id); ?>)" 
                                        class="py-2.5 px-3 bg-red-50 text-red-600 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Quitar
                                </button>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </section>
    </div>

    
    <div class="fixed bottom-0  flex-col items-center  left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-2">
        <div class="flex gap-2 w-full">
            <a href="<?php echo e(route('teams.index')); ?>" 
            class="py-4 px-4 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center">
                Salir
            </a>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0 || $team->players->count() > 0): ?>
                <button disabled class="py-4 px-4 bg-gray-200 text-gray-400 font-bold text-sm rounded-2xl cursor-not-allowed text-center" title="No se puede eliminar con jugadores o pagos">
                    Eliminar
                </button>
            <?php else: ?>
                <button wire:click="confirmDelete" wire:loading.attr="disabled"
                        class="py-4 px-4 bg-red-50 text-red-600 font-bold text-sm rounded-2xl active:scale-95 transition-all text-center">
                    Eliminar
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <button type="submit" form="team-form" wire:loading.attr="disabled" wire:target="save"
                    class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-base active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
                <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span wire:loading.remove wire:target="save">Actualizar</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>
         <h2 class="font-black text-base text-titanium truncate leading-tight">
            <?php echo e($teamName); ?>

        </h2>
    </div>

    
    
    

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'confirmingDeletion','maxWidth' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmingDeletion','maxWidth' => 'sm']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-red-600">Eliminar Equipo</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <p class="text-xs font-semibold text-gray-600">¿Estás seguro de que deseas eliminar el equipo <strong><?php echo e($teamName); ?></strong>? Esta acción no se puede deshacer.</p>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="deleteTeam" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Eliminar</button>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model.live' => 'confirmingPlayerRemoval','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'confirmingPlayerRemoval','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-red-600">Quitar Jugador del Equipo</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                <div class="p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-xl text-xs font-semibold text-yellow-800">
                    El jugador será quitado del equipo. Las cartas de pago pendientes asociadas se eliminarán.
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($paymentsToDeleteRemove) && count($paymentsToDeleteRemove) > 0): ?>
                    <div class="border border-red-200 rounded-2xl bg-red-50/50 p-3 space-y-2">
                        <span class="text-xs font-bold text-red-800 uppercase block">Cartas de pago a eliminar (<?php echo e(count($paymentsToDeleteRemove)); ?>)</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $paymentsToDeleteRemove; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white p-2.5 rounded-xl border border-red-100 text-xs flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-gray-800">Cuota <?php echo e($payment['cuota']); ?> - <?php echo e($payment['description']); ?></p>
                                    <p class="text-[10px] text-gray-400">Ref: <?php echo e($payment['code']); ?></p>
                                </div>
                                <span class="font-black text-red-600"><?php echo e(number_format($payment['amount'], 2)); ?>€</span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelRemovePlayer" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="removePlayer" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar Quitar</button>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model.live' => 'showMovePlayerModal','maxWidth' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'showMovePlayerModal','maxWidth' => 'lg']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-titanium">Mover Jugador</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToMoveName): ?>
                    <p class="text-xs font-bold text-gray-500">Moviendo a: <span class="text-primary"><?php echo e($playerToMoveName); ?></span></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableTeams->isEmpty()): ?>
                    <p class="text-xs text-amber-800 bg-amber-50 p-3 rounded-xl border border-amber-200">No hay otros equipos disponibles en esta temporada y sección.</p>
                <?php else: ?>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Equipo destino *</label>
                    <select wire:model.live="targetTeamId" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        <option value="">Seleccione un equipo...</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $availableTeam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($availableTeam->id); ?>"><?php echo e($availableTeam->team); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['targetTeamId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelMovePlayer" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="movePlayer" wire:loading.attr="disabled" :disabled="$availableTeams->isEmpty() || !$targetTeamId" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50">Mover Jugador</button>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model.live' => 'showAddPlayerModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'showAddPlayerModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-titanium">Agregar Jugadores al Equipo</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                <input type="search" wire:model.live.debounce.300ms="searchAvailablePlayer" placeholder="Buscar por nombre o DNI..."
                       class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">

                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" wire:model.live="filterByCategory" class="w-4 h-4 text-primary border-gray-300 rounded">
                    <span class="text-xs font-bold text-gray-600">Filtrar solo por categoría del equipo</span>
                </label>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availablePlayers->isEmpty()): ?>
                    <p class="text-xs text-amber-800 bg-amber-50 p-3 rounded-xl border border-amber-200">No se encontraron jugadores disponibles.</p>
                <?php else: ?>
                    <div class="space-y-2 pt-1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availablePlayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label wire:key="available-player-<?php echo e($player->id); ?>" class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-100 cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedPlayersToAdd" value="<?php echo e($player->id); ?>" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-xs text-titanium truncate"><?php echo e($player->name); ?> <?php echo e($player->surname); ?></p>
                                    <p class="text-[10px] text-gray-400">DNI: <?php echo e($player->dni ?: '-'); ?></p>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelAddPlayer" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="addPlayersToTeam" wire:loading.attr="disabled" :disabled="empty($selectedPlayersToAdd)" class="flex-1 py-3 bg-primary text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50">Agregar Seleccionados</button>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showEditPlayerModal): ?>
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closeEditPlayerModal"></div>
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-lg p-5 shadow-2xl z-10 flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-shrink-0">
                    <h3 class="font-black text-base text-titanium">Editar Jugador</h3>
                    <button type="button" wire:click="closeEditPlayerModal" class="p-2 text-gray-400">✕</button>
                </div>

                <div class="overflow-y-auto flex-1 py-3 space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Nombre *</label>
                            <input type="text" wire:model.defer="editPlayerName" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Apellidos *</label>
                            <input type="text" wire:model.defer="editPlayerSurname" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">DNI</label>
                            <input type="text" wire:model.defer="editPlayerDni" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Fecha Nac.</label>
                            <input type="date" wire:model.defer="editPlayerDbirth" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Año Nac.</label>
                            <input type="number" wire:model.defer="editPlayerDbanio" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Dorsal</label>
                            <input type="number" wire:model.defer="editPlayerShirtNumber" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Talla</label>
                            <button type="button" wire:click="openSizesModal" class="w-full py-2.5 bg-primary/10 text-primary font-bold text-xs rounded-xl truncate">
                                <?php echo e($editPlayerSize ?: 'Talla'); ?>

                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                                <input wire:model.live="active" type="checkbox" id="active"
                                    class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                                <label for="active" class="text-sm font-semibold text-titanium cursor-pointer">Activo</label>
                            </div>

                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                                <input wire:model.live="goalie" type="checkbox" id="goalie"
                                    class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                                <label for="goalie" class="text-sm font-semibold text-titanium cursor-pointer">Portero</label>
                            </div>

                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                                <input wire:model.live="file" type="checkbox" id="file"
                                    class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                                <label for="file" class="text-sm font-semibold text-titanium cursor-pointer">Ficha Completa</label>
                            </div>
                        </div>  

                    <div>
                        <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Observaciones</label>
                        <textarea wire:model.live="observations" rows="2" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold resize-none"></textarea>
                    </div>
                </div>

                <div class="pt-3 flex gap-2 flex-shrink-0">
                    <button type="button" wire:click="closeEditPlayerModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-xs rounded-xl">Cancelar</button>
                    <button type="button" wire:click="updatePlayer" wire:loading.attr="disabled" class="flex-1 py-3 bg-amber-600 text-white font-bold text-xs rounded-xl active:scale-95">Guardar Cambios</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPdfModal): ?>
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closePdfModal"></div>
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-lg p-5 shadow-2xl z-10 flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-shrink-0">
                    <h3 class="font-black text-base text-titanium">Exportar Listado de Jugadores</h3>
                    <button type="button" wire:click="closePdfModal" class="p-2 text-gray-400">✕</button>
                </div>

                <div class="overflow-y-auto flex-1 py-3 space-y-2">
                    <p class="text-xs font-semibold text-gray-500 mb-2">Selecciona las columnas a incluir:</p>
                    <div class="grid grid-cols-2 gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-gray-100 bg-gray-50 text-xs font-bold cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedColumns" value="<?php echo e($key); ?>" class="w-4 h-4 text-green-600 border-gray-300 rounded">
                                <span class="truncate"><?php echo e($label); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="pt-3 flex gap-2 flex-shrink-0">
                    <button type="button" wire:click="generateExcel" :disabled="empty($selectedColumns)" class="flex-1 py-3 bg-emerald-600 text-white font-bold text-xs rounded-xl active:scale-95 disabled:opacity-50">Excel</button>
                    <button type="button" wire:click="generatePdf" :disabled="empty($selectedColumns)" class="flex-1 py-3 bg-green-600 text-white font-bold text-xs rounded-xl active:scale-95 disabled:opacity-50">PDF</button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model.live' => 'showAddCoachModal','maxWidth' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'showAddCoachModal','maxWidth' => 'lg']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-titanium">Añadir Entrenador</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                <input type="search" wire:model.live.debounce.300ms="searchCoach" placeholder="Buscar por nombre o email..."
                       class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableCoaches->isEmpty()): ?>
                    <p class="text-xs text-amber-800 bg-amber-50 p-3 rounded-xl border border-amber-200">No hay entrenadores disponibles.</p>
                <?php else: ?>
                    <div class="space-y-2 pt-1">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableCoaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div wire:key="available-coach-<?php echo e($coach->id); ?>" class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-xs text-titanium truncate"><?php echo e($coach->name); ?></p>
                                    <p class="text-[10px] text-gray-400 truncate"><?php echo e($coach->email); ?></p>
                                </div>
                                <button type="button" wire:click="addCoach(<?php echo e($coach->id); ?>)" class="px-3 py-1.5 bg-primary text-white font-bold text-xs rounded-xl active:scale-95">Añadir</button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <button type="button" wire:click="closeAddCoachModal" class="w-full py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cerrar</button>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model.live' => 'confirmingCoachRemoval','maxWidth' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'confirmingCoachRemoval','maxWidth' => 'sm']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-red-600">Quitar Entrenador</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <p class="text-xs font-semibold text-gray-600">¿Está seguro de quitar a este entrenador del equipo? No se borrará el usuario.</p>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelRemoveCoach" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="removeCoach" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Quitar</button>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showPreviewModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showPreviewModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold text-blue-600">Cambios en Pagos</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1 text-xs">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($paymentsPaid) && count($paymentsPaid) > 0): ?>
                    <p class="text-green-700 font-bold">✅ <?php echo e(count($paymentsPaid)); ?> pagos realizados se mantendrán.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($paymentsToDelete) && count($paymentsToDelete) > 0): ?>
                    <p class="text-red-700 font-bold">🗑️ <?php echo e(count($paymentsToDelete)); ?> pagos pendientes se eliminarán.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($paymentsToCreate) && count($paymentsToCreate) > 0): ?>
                    <p class="text-blue-700 font-bold">➕ <?php echo e(count($paymentsToCreate)); ?> nuevas cartas de pago se generarán.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="$set('showPreviewModal', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="confirmPaymentsAction" wire:loading.attr="disabled" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar</button>
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>

    
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
            });
        });
    </script>
</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\teams\edit_mobile.blade.php ENDPATH**/ ?>