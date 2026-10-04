<div x-data="{ showFilters: false }" class="min-h-screen bg-gray-50 pb-28 relative">

    
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
        <div>
          
            <p class="text-xs font-bold text-gray-500">
                <span class="text-primary"><?php echo e($teams->total()); ?></span> <?php echo e($teams->total() === 1 ? 'equipo encontrado' : 'equipos encontrados'); ?>

            </p>
        </div>

        
        <button @click="showFilters = !showFilters" 
                class="p-2.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 active:scale-95 transition-all relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $categoryFilter || $seasonFilter): ?>
                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-primary rounded-full border-2 border-white"></span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </button>
    </header>

    
    <div x-show="showFilters" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="px-4 py-5 bg-white-pure border-b border-gray-100 shadow-inner z-30 relative space-y-3" style="display: none;">
        
        
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="search" placeholder="Buscar equipos..." 
                   class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep focus:ring-2 focus:ring-primary focus:bg-white transition-all text-sm font-semibold">
        </div>

        
        <div class="grid grid-cols-2 gap-3">
            <select wire:model.live="categoryFilter" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                <option value="">Categorías...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->category); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>

            <select wire:model.live="seasonFilter" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                <option value="">Temporadas...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($season->id); ?>">
                        <?php echo e($season->season); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $season->id === $activeSeason->id): ?> (En curso) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
        </div>
    </div>

    
    <main class="p-4 space-y-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isHighlighted = $highlightTeam == $team->id;
                $genderColors = [
                    'masculino' => 'bg-blue-100 text-blue-800',
                    'femenino' => 'bg-pink-100 text-pink-800',
                    'mixto' => 'bg-purple-100 text-purple-800'
                ];
                $genderIcons = [
                    'masculino' => '♂',
                    'femenino' => '♀',
                    'mixto' => '⚥'
                ];
            ?>

            <article id="team-<?php echo e($team->id); ?>" 
                     class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 relative overflow-hidden transition-all duration-300 space-y-4 <?php echo e($isHighlighted ? 'border-green-500 ring-2 ring-green-500 animate-pulse' : ''); ?>">
                
                
                <div class="flex justify-between items-start gap-3 border-b border-gray-50 pb-3">
                    <div>
                        <h3 class="font-black text-lg text-titanium leading-snug"><?php echo e($team->team); ?></h3>
                        <p class="text-xs text-gray-500 font-semibold mt-0.5">
                            <?php echo e($team->category->category ?? 'Sin categoría'); ?>

                        </p>
                    </div>

                    <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                        
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider <?php echo e($genderColors[$team->gender] ?? 'bg-gray-100 text-gray-800'); ?>">
                            <span class="mr-1"><?php echo e($genderIcons[$team->gender] ?? ''); ?></span>
                            <?php echo e(ucfirst($team->gender)); ?>

                        </span>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->federate): ?>
                            <span class="inline-flex items-center px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md text-[10px] font-bold border border-blue-100">
                                <svg class="w-3 h-3 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Federado
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="grid grid-cols-3 gap-2">
                    
                    <div class="bg-primary/5 rounded-2xl p-2.5 text-center flex flex-col justify-center items-center">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Jugadores</span>
                        <span class="text-base font-black text-primary"><?php echo e($team->players_count); ?></span>
                    </div>

                    
                    <div class="bg-gray-50 rounded-2xl p-2.5 text-center flex flex-col justify-center items-center min-w-0">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Sección</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->section): ?>
                            <span class="text-xs font-extrabold truncate w-full px-1" style="color: <?php echo e($team->section->color ?? '#8B5CF6'); ?>">
                                <?php echo e($team->section->name); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-xs font-bold text-gray-400">-</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="bg-blue-50/70 rounded-2xl p-2.5 text-center flex flex-col justify-center items-center">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Temporada</span>
                        <span class="text-xs font-extrabold text-blue-900 truncate"><?php echo e($team->season->from_year."/".$team->season->to_year); ?></span>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->coaches->isNotEmpty()): ?>
                    <div class="pt-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Entrenadores</span>
                        <div class="flex flex-wrap gap-1.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $team->coaches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-bold bg-gray-100 text-titanium border border-gray-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coach->profile_photo_path): ?>
                                        <img src="<?php echo e(asset('storage/' . $coach->profile_photo_path)); ?>" class="w-4 h-4 rounded-full object-cover mr-1.5 border border-gray-300">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php echo e($coach->name); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
                    <button wire:click="openEditModal(<?php echo e($team->id); ?>)" 
                            class="flex-1 py-3 bg-primary/10 text-primary font-bold text-sm rounded-xl active:bg-primary/20 transition-colors flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Editar
                    </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->payments_count > 0 || $team->players_count > 0): ?>
                        <button disabled class="flex-1 py-3 bg-gray-100 text-gray-400 font-bold text-sm rounded-xl cursor-not-allowed flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Bloqueado
                        </button>
                    <?php else: ?>
                        <button wire:click="confirmDelete(<?php echo e($team->id); ?>)" 
                                wire:loading.attr="disabled"
                                wire:target="confirmDelete"
                                class="flex-1 py-3 bg-red-50 text-red-600 font-bold text-sm rounded-xl active:bg-red-100 transition-colors flex justify-center items-center gap-2">
                            <svg wire:loading.remove wire:target="confirmDelete" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <svg wire:loading wire:target="confirmDelete" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Eliminar
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Sin equipos</h3>
                <p class="text-sm text-gray-500">No se encontraron equipos con los criterios de búsqueda.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teams->hasPages()): ?>
            <div class="pt-4 pb-8">
                <?php echo e($teams->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    
    <div class="fixed bottom-0 flex-col items-center  left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-3">
        <div class="flex gap-2 w-full">
            <button wire:click="exportExcel" wire:loading.attr="disabled" wire:target="exportExcel"
                    class="py-4 px-5 bg-gray-100 text-green-700 font-bold text-sm rounded-2xl active:scale-95 transition-all flex justify-center items-center gap-2">
                <svg wire:loading.remove wire:target="exportExcel" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <svg wire:loading wire:target="exportExcel" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="exportExcel">Excel</span>
                <span wire:loading wire:target="exportExcel">Exportando...</span>
            </button>

            <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal"
                    class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-base active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
                <svg wire:loading.remove wire:target="openCreateModal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <svg wire:loading wire:target="openCreateModal" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="openCreateModal">Nuevo Equipo</span>
                <span wire:loading wire:target="openCreateModal">Cargando...</span>
            </button>
        </div>

        <h2 class="font-black text-xl text-titanium leading-tight">
            Equipos
        </h2>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> 
            <div class="font-black text-lg text-titanium">
                <?php echo e($showConfirmation ? 'Confirmar Creación de Equipo' : 'Crear Equipo'); ?>

            </div>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showConfirmation): ?>
                
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                    

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Nombre del Equipo *</label>
                        <input wire:model="team" type="text" placeholder="Ej. Benjamín A"
                               class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team'];
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
                            <select wire:model="category_id" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
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
                            <select wire:model="gender" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
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

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Sección *</label>
                        <select wire:model.live="section_id" <?php echo e(!$season_id ? 'disabled' : ''); ?>

                                class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white <?php echo e(!$season_id ? 'opacity-60 cursor-not-allowed' : ''); ?>">
                            <option value=""><?php echo e($season_id ? 'Seleccionar sección...' : 'Seleccione temporada'); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($section->id); ?>"><?php echo e($section->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['section_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1 block font-medium"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($season_id && $sections->isEmpty()): ?>
                            <p class="text-amber-600 text-xs mt-1 font-bold">No hay secciones disponibles para esta temporada.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Precio Matrícula (€)</label>
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
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($price) || $price == 0): ?>
                        <div class="p-3 bg-amber-50 border-l-4 border-amber-400 rounded-xl">
                            <p class="text-xs text-amber-800 font-bold">⚠️ Matrícula gratuita</p>
                            <p class="text-[11px] text-amber-700 mt-0.5">No se generarán cartas de pago.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="p-4 bg-blue-50/70 rounded-2xl border border-blue-100">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" wire:model.live="federate" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <div>
                                <span class="text-sm font-bold text-blue-900 block">Equipo Federado</span>
                                <span class="text-[11px] text-blue-700 block">Marca esta opción si el equipo participa en competición oficial.</span>
                            </div>
                        </label>
                    </div>
                </div>
            <?php else: ?>
                
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                    <div class="p-3.5 bg-blue-50 border-l-4 border-blue-500 rounded-2xl text-xs text-blue-900 font-medium">
                        Por favor, revisa los datos antes de crear el equipo. Los datos mostrados a continuación son los que se guardarán.
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-4 space-y-2 text-xs">
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-500 font-bold uppercase">Nombre del Equipo:</span>
                            <span class="font-black text-gray-900"><?php echo e($confirmationData['team'] ?? ''); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-500 font-bold uppercase">Categoría:</span>
                            <span class="font-bold text-gray-900"><?php echo e($confirmationData['category'] ?? ''); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-500 font-bold uppercase">Género:</span>
                            <span class="font-bold text-gray-900 capitalize"><?php echo e($confirmationData['gender'] ?? ''); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-500 font-bold uppercase">Sección:</span>
                            <span class="font-bold text-gray-900"><?php echo e($confirmationData['section'] ?? ''); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-500 font-bold uppercase">Descripción:</span>
                            <span class="font-bold text-gray-900"><?php echo e($confirmationData['description'] ?? '-'); ?></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-200 pb-2">
                            <span class="text-gray-500 font-bold uppercase">Temporada:</span>
                            <span class="font-bold text-gray-900"><?php echo e($confirmationData['season'] ?? ''); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-bold uppercase">Equipo Federado:</span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmationData['federate'] ?? false): ?>
                                <span class="inline-flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Sí
                                </span>
                            <?php else: ?>
                                <span class="text-gray-500 font-bold">No</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="pt-4">
                        <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Precio de Matrícula</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($confirmationData['price']) && $confirmationData['price'] > 0): ?>
                            <div class="bg-green-50 border-2 border-green-500 rounded-2xl p-4 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-500 rounded-full p-2 text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xl font-black text-green-700"><?php echo e(number_format($confirmationData['price'], 2, ',', '.')); ?> €</p>
                                        <p class="text-[10px] text-green-700 font-bold mt-0.5">⚠️ Este precio se usará para calcular las cuotas</p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="bg-amber-50 border-2 border-amber-400 rounded-2xl p-4 flex items-start gap-3">
                                <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-base font-black text-amber-700">0,00 € - Matrícula Gratuita</p>
                                    <p class="text-[11px] text-amber-800 font-bold mt-0.5">No se generará orden de pago para los jugadores.</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showConfirmation): ?>
                    <button wire:click="closeModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200 transition-colors">Cancelar</button>
                    <button wire:click="save" wire:loading.attr="disabled" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:bg-blue-700 flex justify-center items-center gap-2 transition-colors disabled:opacity-70">
                        <span wire:loading.remove wire:target="save">Continuar</span>
                        <span wire:loading wire:target="save">Validando...</span>
                    </button>
                <?php else: ?>
                    <button wire:click="backToForm" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200 transition-colors">Volver</button>
                    <button wire:click="confirmCreate" wire:loading.attr="disabled" class="flex-[2] py-3 bg-green-600 text-white font-bold text-sm rounded-xl active:bg-green-700 flex justify-center items-center gap-2 transition-colors disabled:opacity-70">
                        <svg wire:loading.remove wire:target="confirmCreate" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <svg wire:loading wire:target="confirmCreate" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span wire:loading.remove wire:target="confirmCreate">Confirmar y Crear</span>
                        <span wire:loading wire:target="confirmCreate">Creando...</span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'confirmingDeletion','maxWidth' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmingDeletion','maxWidth' => 'sm']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-black text-lg text-red-600">Eliminar Equipo</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <p class="text-xs font-semibold text-gray-600">¿Estás seguro de que deseas eliminar este equipo? Esta acción no se puede deshacer.</p>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200 transition-colors">Cancelar</button>
                <button wire:click="deleteTeam" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:bg-red-700 flex justify-center items-center gap-2 transition-colors">
                    <span wire:loading.remove wire:target="deleteTeam">Eliminar</span>
                    <span wire:loading wire:target="deleteTeam">Eliminando...</span>
                </button>
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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlightTeam): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => { window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('highlightTeam', null); }, 3000);
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
            });
        });
    </script>
</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\teams\index_mobile.blade.php ENDPATH**/ ?>