<div class="pt-3">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        
        
        <div class="mb-5 px-4 sm:px-0">
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                <a href="<?php echo e(route('tournaments.index')); ?>" wire:navigate class="hover:text-primary transition-colors font-medium">Torneos</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 font-bold">Nuevo Torneo</span>
            </nav>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">Asistente de Creación</h1>
            
        </div>

        
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-200/60 flex flex-col">
            
            
            <div class="bg-white border-b border-gray-100 px-6 sm:px-12 pt-10 pb-2 rounded-t-3xl">
                <div class="flex items-start justify-between relative max-w-4xl mx-auto">
                    
                    
                    <div class="absolute left-0 top-6 -translate-y-1/2 w-full h-1.5 bg-gray-100 z-0 rounded-full"></div>
                    
                    
                    <div class="absolute left-0 top-6 -translate-y-1/2 h-1.5 bg-primary z-0 transition-all duration-700 ease-in-out rounded-full" 
                         style="width: <?php echo e(($currentStep - 1) * 33.33); ?>%"></div>

                    
                    <div class="relative z-10 flex flex-col items-center group w-1/4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg border-4 border-white transition-all duration-300 <?php echo e($currentStep >= 1 ? 'bg-primary text-white shadow-md scale-110' : 'bg-gray-100 text-gray-400'); ?>">1</div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-center transition-colors duration-300 <?php echo e($currentStep >= 1 ? 'text-primary' : 'text-gray-400'); ?>">Datos Generales</span>
                    </div>

                    
                    <div class="relative z-10 flex flex-col items-center group w-1/4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg border-4 border-white transition-all duration-300 <?php echo e($currentStep >= 2 ? 'bg-primary text-white shadow-md scale-110' : 'bg-gray-100 text-gray-400'); ?>">2</div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-center transition-colors duration-300 <?php echo e($currentStep >= 2 ? 'text-primary' : 'text-gray-400'); ?>">Inscripción</span>
                    </div>

                    
                    <div class="relative z-10 flex flex-col items-center group w-1/4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg border-4 border-white transition-all duration-300 <?php echo e($currentStep >= 3 ? 'bg-primary text-white shadow-md scale-110' : 'bg-gray-100 text-gray-400'); ?>">3</div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-center transition-colors duration-300 <?php echo e($currentStep >= 3 ? 'text-primary' : 'text-gray-400'); ?>">Puntuación</span>
                    </div>

                    
                    <div class="relative z-10 flex flex-col items-center group w-1/4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg border-4 border-white transition-all duration-300 <?php echo e($currentStep >= 4 ? 'bg-primary text-white shadow-md scale-110' : 'bg-gray-100 text-gray-400'); ?>">4</div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-center transition-colors duration-300 <?php echo e($currentStep >= 4 ? 'text-primary' : 'text-gray-400'); ?>">Resumen</span>
                    </div>
                </div>
            </div>

            
            <div class="p-2 sm:p-4 flex-grow bg-white">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep == 1): ?>
                    <div class="animate-fadeIn max-w-4xl mx-auto">
                        <h2 class="text-2xl font-black text-gray-900 mb-4">Información Principal</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                            
                            <div class="col-span-1 md:col-span-4 flex flex-col">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Logo del Torneo</label>
                                
                                <div class="flex-grow flex flex-col items-center justify-start">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
                                        <div class="relative group mb-4">
                                            <img src="<?php echo e($logo->temporaryUrl()); ?>" class="w-40 h-40 object-cover rounded-3xl border-4 border-white shadow-lg"/>
                                            <button wire:click="$set('logo', null)" class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600 transition-colors">
                                                ✕
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <label class="flex flex-col items-center justify-center w-full aspect-square border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer hover:border-primary hover:bg-primary/5 transition-all group bg-gray-50/50">
                                            <div class="w-14 h-14 bg-white rounded-full shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                            </div>
                                            <span class="text-sm font-bold text-gray-600 group-hover:text-primary transition-colors">Subir imagen</span>
                                            <span class="text-xs text-gray-400 mt-1 font-medium">PNG, JPG (Max. 2MB)</span>
                                            <input wire:model="logo" type="file" accept="image/*" class="hidden"/>
                                        </label>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-3 font-bold text-center"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            
                            <div class="col-span-1 md:col-span-8 space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nombre del Torneo <span class="text-red-500 text-sm">*</span></label>
                                    <input wire:model="name" type="text" placeholder="Ej: Champions League Alevín"
                                           class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-bold transition-all shadow-sm"/>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Sede / Ubicación</label>
                                    <input wire:model="location" type="text" placeholder="Ej: Instalaciones Deportivas Municipales"
                                           class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fecha de Inicio</label>
                                        <input wire:model="start_date" type="date"
                                               class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fecha de Fin</label>
                                        <input wire:model="end_date" type="date"
                                               class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep == 2): ?>
                    <div class="animate-fadeIn max-w-4xl mx-auto">
                        <h2 class="text-2xl font-black text-gray-900 mb-8">Reglas e Inscripción</h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-10 gap-y-8">
                            
                            

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Límite de Equipos</label>
                                <input wire:model="max_teams" type="number" min="2" placeholder="Sin límite"
                                       class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['max_teams'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jugadores por Equipo</label>
                                <input wire:model="max_players_per_team" type="number" min="1" placeholder="Ej: 15"
                                       class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['max_players_per_team'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Edad Mínima Requerida</label>
                                <div class="relative">
                                    <input wire:model="min_age" type="number" min="1" placeholder="Sin restricción"
                                           class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 font-black text-sm">Años</span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['min_age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Precio Inscripción Equipo</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 font-black text-lg">€</span>
                                    <input wire:model="registration_fee" type="number" step="0.01" min="0" placeholder="0.00"
                                           class="w-full pl-10 pr-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-black transition-all shadow-sm"/>
                                </div>
                                <p class="text-[11px] text-gray-400 mt-2 font-semibold">Dejar vacío o en 0 si la participación es gratuita.</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['registration_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cierre Inscripción de Jugadores</label>
                                <input wire:model="player_registration_deadline" type="date"
                                       class="w-full md:w-1/2 px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white text-gray-900 text-base font-semibold transition-all shadow-sm"/>
                                <p class="text-[11px] text-gray-400 mt-2 font-semibold">Fecha límite para que los equipos cierren sus plantillas.</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['player_registration_deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-2 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep == 3): ?>
                    <div class="animate-fadeIn max-w-4xl mx-auto text-center">
                        <h2 class="text-2xl font-black text-gray-900 mb-3">Sistema de Puntuación</h2>
                        <p class="text-base text-gray-500 mb-10 font-medium max-w-xl mx-auto">Configura los puntos otorgados al finalizar un partido. Los valores por defecto son los estándares del fútbol (3 - 1 - 0).</p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                            
                            <div class="bg-green-50/50 rounded-3xl p-8 border-2 border-green-200 shadow-sm relative overflow-hidden group hover:border-green-400 transition-colors">
                                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-5">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <label class="block text-sm font-black text-green-800 uppercase tracking-widest mb-4">Victoria</label>
                                <input wire:model="points_per_win" type="number" min="0" max="10"
                                       class="w-24 mx-auto px-2 py-4 bg-white border-2 border-green-300 rounded-2xl focus:ring-4 focus:ring-green-500/20 text-green-700 text-3xl text-center font-black transition-all shadow-inner"/>
                            </div>

                            
                            <div class="bg-amber-50/50 rounded-3xl p-8 border-2 border-amber-200 shadow-sm relative overflow-hidden group hover:border-amber-400 transition-colors">
                                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-5 font-black text-3xl leading-none pt-1">
                                    =
                                </div>
                                <label class="block text-sm font-black text-amber-800 uppercase tracking-widest mb-4">Empate</label>
                                <input wire:model="points_per_draw" type="number" min="0" max="10"
                                       class="w-24 mx-auto px-2 py-4 bg-white border-2 border-amber-300 rounded-2xl focus:ring-4 focus:ring-amber-500/20 text-amber-700 text-3xl text-center font-black transition-all shadow-inner"/>
                            </div>

                            
                            <div class="bg-red-50/50 rounded-3xl p-8 border-2 border-red-200 shadow-sm relative overflow-hidden group hover:border-red-400 transition-colors">
                                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <label class="block text-sm font-black text-red-800 uppercase tracking-widest mb-4">Derrota</label>
                                <input wire:model="points_per_loss" type="number" min="0" max="10"
                                       class="w-24 mx-auto px-2 py-4 bg-white border-2 border-red-300 rounded-2xl focus:ring-4 focus:ring-red-500/20 text-red-700 text-3xl text-center font-black transition-all shadow-inner"/>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep == 4): ?>
                    <div class="animate-fadeIn max-w-3xl mx-auto">
                        <h2 class="text-2xl font-black text-gray-900 mb-2 text-center">Resumen del Torneo</h2>
                        
                        <div class="bg-white rounded-3xl shadow-sm border border-primary/20 p-8 space-y-2">
                            
                            
                            <div class="flex items-center gap-6 pb-6 border-b border-gray-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
                                    <img src="<?php echo e($logo->temporaryUrl()); ?>" class="w-24 h-24 object-cover rounded-full border-4 border-gray-50 shadow-sm"/>
                                <?php else: ?>
                                    <div class="w-24 h-24 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-3xl shadow-sm border border-primary/20">
                                        <?php echo e(substr($name, 0, 1)); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div>
                                    <h3 class="font-black text-2xl text-titanium leading-tight"><?php echo e($name); ?></h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($location): ?>
                                        <p class="text-sm font-bold text-gray-500 mt-1 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <?php echo e($location); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 grid grid-cols-1 sm:grid-cols-3 gap-y-6 gap-x-8">
                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Fechas del Torneo</span>
                                    <span class="text-base font-black text-titanium">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($start_date && $end_date): ?>
                                            <?php echo e(\Carbon\Carbon::parse($start_date)->format('d/m/Y')); ?> al <?php echo e(\Carbon\Carbon::parse($end_date)->format('d/m/Y')); ?>

                                        <?php else: ?>
                                            <span class="text-amber-500 text-sm">No definidas</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                </div>

                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Cierre de Inscripción</span>
                                    <span class="text-base font-black text-titanium">
                                        <?php echo e($player_registration_deadline ? \Carbon\Carbon::parse($player_registration_deadline)->format('d/m/Y') : 'Sin límite'); ?>

                                    </span>
                                </div>

                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Precio de Inscripción</span>
                                    <span class="text-base font-black text-green-600">
                                        <?php echo e($registration_fee ? number_format($registration_fee, 2).' €' : 'Gratuito'); ?>

                                    </span>
                                </div>

                                <div>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Límites</span>
                                    <span class="text-sm font-black text-titanium block">
                                        Equipos: <?php echo e($max_teams ? $max_teams : 'Ilimitados'); ?>

                                    </span>
                                    <span class="text-sm font-black text-titanium block mt-1">
                                        Jugadores/Eq: <?php echo e($max_players_per_team ? $max_players_per_team : 'Ilimitados'); ?>

                                    </span>
                                </div>

                                <div class="sm:col-span-2 bg-white rounded-xl p-4 border border-gray-200 flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sistema de Puntos</span>
                                    <span class="text-base font-black text-titanium flex items-center gap-4">
                                        <span class="text-green-600 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> <?php echo e($points_per_win); ?></span>
                                        <span class="text-amber-500 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span> <?php echo e($points_per_draw); ?></span>
                                        <span class="text-red-500 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> <?php echo e($points_per_loss); ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="p-6 sm:px-12 sm:py-8 bg-gray-50 border-t border-gray-100 flex items-center justify-between rounded-b-3xl">
                <div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep > 1): ?>
                        <button wire:click="previousStep" type="button"
                                class="px-6 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-100 transition-colors flex items-center gap-2 text-sm shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            Anterior
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e(route('tournaments.index')); ?>" wire:navigate class="px-6 py-3.5 text-gray-500 font-bold hover:text-gray-900 transition-colors text-sm">Cancelar</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep < 4): ?>
                        <button wire:click="nextStep" type="button"
                                class="px-8 py-3.5 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all flex items-center gap-2 shadow-lg shadow-gray-900/20 hover:shadow-gray-900/40 text-sm">
                            Siguiente
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    <?php else: ?>
                        <button wire:click="save" type="button" wire:loading.attr="disabled"
                                class="px-8 py-3.5 bg-primary text-white font-black rounded-2xl hover:bg-primary/90 transition-all flex items-center gap-2 shadow-lg shadow-primary/30 hover:shadow-primary/50 text-base">
                            <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <svg wire:loading wire:target="save" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                            <span wire:loading.remove wire:target="save">Confirmar y Crear Torneo</span>
                            <span wire:loading wire:target="save">Creando torneo...</span>
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    
    <style>
        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Ocultar las flechas nativas en los inputs number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</div><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\tournaments\create.blade.php ENDPATH**/ ?>