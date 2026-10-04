<div x-data="{ showFilters: false }" class="min-h-screen bg-gray-50 pb-28 relative">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-2xl shadow-sm">
            <p class="text-sm text-neon-green font-bold"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div>
            
            <p class="text-xs font-bold text-gray-500">
                <span class="text-primary"><?php echo e($players->total()); ?></span> jugadores encontrados
            </p>
        </div>

        
        <button @click="showFilters = !showFilters" 
                class="p-2.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 active:scale-95 transition-all relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $seasonFilter || $teamFilter || $withoutTeam): ?>
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
         class="px-4 py-5 bg-white-pure border-b border-gray-100 shadow-inner z-30 relative space-y-4" style="display: none;">
        
        
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="search" placeholder="Buscar jugador..." 
                   class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep focus:ring-2 focus:ring-primary focus:bg-white transition-all text-sm font-semibold">
        </div>

        
        <div class="grid grid-cols-2 gap-3">
            <select wire:model.live="seasonFilter" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                <option value="">Temporada...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($season->id); ?>"><?php echo e($season->season); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $season->id === $activeSeason->id): ?> (En curso) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>

            <select wire:model.live="teamFilter" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                <option value="">Equipos...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($team->id); ?>"><?php echo e($team->team); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
        </div>

        
        <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 bg-gray-50/50 active:bg-gray-100 transition-colors cursor-pointer">
            <input type="checkbox" wire:model.live="withoutTeam" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
            <span class="text-sm font-bold text-titanium select-none">Solo jugadores sin equipo</span>
        </label>
    </div>

    
    <main class="p-4 space-y-4">
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $seasonFilter == $activeSeason->id && $players->count() > 0): ?>
            <div class="flex items-center justify-between px-2 pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" 
                           @change="$event.target.checked ? $wire.set('selectedPlayers', <?php echo e($players->pluck('id')->toJson()); ?>) : $wire.set('selectedPlayers', [])"
                           :checked="<?php echo e(count($selectedPlayers) === $players->count() && $players->count() > 0 ? 'true' : 'false'); ?>"
                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Seleccionar todos</span>
                </label>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isInactive = !$player->active;
                $hasNoTeam = $player->teams->count() === 0;
                $isHighlighted = $highlightPlayer == $player->id;
                
                // Estilos dinámicos de la tarjeta
                $cardClass = 'bg-white-pure border-gray-100 shadow-sm';
                if ($isInactive) $cardClass = 'bg-gray-100 border-gray-200 opacity-75';
                elseif ($hasNoTeam) $cardClass = 'bg-red-50/50 border-red-100 shadow-sm';
                
                if ($isHighlighted) $cardClass .= ' border-green-500 ring-2 ring-green-500 animate-pulse';
            ?>

            <article id="player-<?php echo e($player->id); ?>" class="rounded-3xl p-4 border <?php echo e($cardClass); ?> relative overflow-hidden transition-all duration-300">
                
                
                <div class="flex items-start gap-3 mb-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $seasonFilter == $activeSeason->id): ?>
                        <div class="pt-1.5">
                            <input type="checkbox" wire:model.live="selectedPlayers" value="<?php echo e($player->id); ?>"
                                   class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="flex-shrink-0 relative">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->player_photo): ?>
                            <img src="<?php echo e(asset('storage/' . $player->player_photo)); ?>" alt="<?php echo e($player->name); ?>" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-night-blue flex items-center justify-center border-2 border-white shadow-sm">
                                <span class="text-white font-bold text-sm"><?php echo e(substr($player->name, 0, 1)); ?><?php echo e(substr($player->surname, 0, 1)); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="flex-1 min-w-0 pt-0.5">
                        <h3 class="font-bold text-base text-gray-900 truncate leading-tight">
                            <?php echo $this->highlightText($player->full_name); ?>

                        </h3>
                        
                        
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->active): ?>
                                <span class="px-2 py-0.5 rounded-full bg-neon-green/10 text-neon-green text-[10px] font-extrabold uppercase tracking-wider border border-neon-green/20">Activo</span>
                            <?php else: ?>
                                <span class="px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-[10px] font-extrabold uppercase tracking-wider border border-gray-300">Inactivo</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-2 bg-white rounded-2xl p-3 border border-gray-50 shadow-inner mb-4">
                    
                    <div>
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Equipo</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->teams->count() > 0): ?>
                            <div class="flex flex-wrap gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $player->teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold"><?php echo e($team->team); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span class="inline-block px-2 py-1 bg-red-50 text-red-600 rounded-lg text-xs font-bold">Sin equipo</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div>
                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sección</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->sections->count() > 0): ?>
                            <div class="flex flex-wrap gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $player->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-block px-2 py-1 rounded-lg text-xs font-bold"
                                          style="<?php echo e($section->color ? 'background-color: ' . $section->color . '15; color: ' . $section->color . ';' : 'background-color: #DCFCE7; color: #166534;'); ?>">
                                        <?php echo e($section->name); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-bold">N/A</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="flex items-center gap-2">
                    
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $seasonFilter == $activeSeason->id): ?>
                        <a href="<?php echo e(route('players.edit', $player->id)); ?>" wire:click="saveFilters"
                           class="flex-1 py-3 bg-primary/10 text-primary font-bold text-sm rounded-xl active:bg-primary/20 transition-colors flex justify-center items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Editar
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php
                        $canDelete = $this->canDeletePlayer($player->id);
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canDelete && ($activeSeason && $seasonFilter == $activeSeason->id)): ?>
                        <button wire:click="confirmDelete(<?php echo e($player->id); ?>)" 
                                class="p-3 bg-red-50 text-red-600 font-bold rounded-xl active:bg-red-100 transition-colors flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
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
                <h3 class="text-lg font-bold text-gray-900 mb-1">Sin jugadores</h3>
                <p class="text-sm text-gray-500">No se encontraron resultados con los filtros actuales.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($players->hasPages()): ?>
            <div class="pt-4 pb-8">
                <?php echo e($players->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </main>

    
    <div class="fixed bottom-0 left-0 right-0 flex flex-col items-center gap-3 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50">
        
        

        <div class="flex items-center gap-3 w-full">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedPlayers) > 0): ?>
                <button wire:click="confirmTeamChange" 
                        class="w-full py-4 bg-green-600 text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Cambiar Equipo (<?php echo e(count($selectedPlayers)); ?>)
                </button>
            
            
            <?php else: ?>
                <button wire:click="exportExcel" 
                        class="flex-1 py-4 bg-gray-100 text-green-700 rounded-2xl font-bold text-sm active:scale-95 transition-all flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Excel
                </button>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $seasonFilter == $activeSeason->id): ?>
                    <a href="<?php echo e(route('players.create')); ?>" 
                    class="flex-[2] py-4 bg-blue-600 text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nuevo Jugador
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="text-center mb-3">
            <h2 class="font-black text-lg text-titanium ">
                Gestión de Jugadores
            </h2>
        </div>
    </div>

    
    
    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'confirmingDeletion']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmingDeletion']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold">Eliminar Jugador</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToDeleteModel): ?>
                <p class="text-gray-600">¿Estás seguro de que deseas eliminar a <strong><?php echo e($playerToDeleteModel->full_name); ?></strong>? Esta acción también eliminará su foto.</p>
            <?php else: ?>
                <p class="text-gray-600">¿Estás seguro de que deseas eliminar este jugador? Esta acción también eliminará su foto.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-3 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl active:bg-gray-200">Cancelar</button>
                <button wire:click="deletePlayer" wire:loading.attr="disabled" wire:target="deletePlayer" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl active:bg-red-700 flex justify-center items-center">
                    <span wire:loading.remove wire:target="deletePlayer">Eliminar</span>
                    <span wire:loading wire:target="deletePlayer">Eliminando...</span>
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

    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'confirmingTeamChange']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmingTeamChange']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold">Cambiar Equipo</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <p class="text-sm text-gray-600 mb-3">Jugadores seleccionados (<?php echo e(count($selectedPlayers)); ?>):</p>
            <div class="bg-gray-50 rounded-xl p-3 max-h-48 overflow-y-auto mb-4 border border-gray-100 space-y-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $selectedPlayersModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3 bg-white p-2 rounded-lg border border-gray-100">
                        <span class="font-bold text-xs text-gray-800"><?php echo e($player->full_name); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->teams->count() > 0): ?>
                            <span class="text-[10px] text-gray-500 ml-auto bg-gray-100 px-2 py-1 rounded"><?php echo e($player->teams->first()->team); ?></span>
                        <?php else: ?>
                            <span class="text-[10px] text-red-500 ml-auto bg-red-50 px-2 py-1 rounded">Sin equipo</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            <label class="block text-xs font-bold text-titanium mb-2 uppercase tracking-wide">Equipo destino</label>
            <select wire:model="newTeamId" class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                <option value="">Selecciona un equipo...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($team->id); ?>"><?php echo e($team->team); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </select>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['newTeamId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-xs font-bold text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex gap-3 w-full mt-2">
                <button wire:click="$set('confirmingTeamChange', false)" class="flex-1 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl active:bg-gray-200">Cancelar</button>
                <button wire:click="changeTeam" wire:loading.attr="disabled" wire:target="changeTeam" class="flex-1 py-3 bg-green-600 text-white font-bold rounded-xl active:bg-green-700 flex justify-center items-center">
                    <span wire:loading.remove wire:target="changeTeam">Traspasar</span>
                    <span wire:loading wire:target="changeTeam">Cambiando...</span>
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

    
    
    
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'showPlayerViewModal','maxWidth' => '2xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'showPlayerViewModal','maxWidth' => '2xl']); ?>
         <?php $__env->slot('title', null, []); ?> <span class="font-bold">Info. Jugador</span> <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> 
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToView): ?>
                <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToView->player_photo): ?>
                        <img src="<?php echo e(asset('storage/' . $playerToView->player_photo)); ?>" class="w-20 h-20 rounded-full object-cover shadow-sm">
                    <?php else: ?>
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-night-blue flex items-center justify-center shadow-sm">
                            <span class="text-white font-bold text-2xl"><?php echo e(substr($playerToView->name, 0, 1)); ?><?php echo e(substr($playerToView->surname, 0, 1)); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div>
                        <h3 class="text-lg font-black text-gray-900"><?php echo e($playerToView->full_name); ?></h3>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToView->active): ?>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-neon-green/10 text-neon-green text-[10px] font-extrabold uppercase">Activo</span>
                        <?php else: ?>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-[10px] font-extrabold uppercase">Inactivo</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Equipos</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToView->teams->count() > 0): ?>
                            <div class="flex flex-wrap gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $playerToView->teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-bold"><?php echo e($team->team); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm font-semibold text-gray-900">Sin equipo</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Secciones</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($playerToView->sections->count() > 0): ?>
                            <div class="flex flex-wrap gap-1">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $playerToView->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="px-2 py-1 rounded-lg text-xs font-bold" style="<?php echo e($section->color ? 'background-color: ' . $section->color . '20; color: ' . $section->color . ';' : 'background-color: #DCFCE7; color: #166534;'); ?>"><?php echo e($section->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm font-semibold text-gray-900">Sin sección</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <button wire:click="closePlayerViewModal" class="w-full py-4 bg-gray-100 text-gray-700 font-bold rounded-xl active:bg-gray-200 text-center">Cerrar</button>
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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($highlightPlayer): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => { window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('highlightPlayer', null); }, 3000);
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\players\index_mobile.blade.php ENDPATH**/ ?>