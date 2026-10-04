<div>
    <style>
        .team-login-outer {
            background: linear-gradient(160deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            min-height: calc(100vh - 4rem);
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 639px) {
            .team-login-sheet-wrap {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
            }
        }
    </style>

    <div class="team-login-outer">

        
        
        
        <div class="sm:hidden px-5 pt-5 pb-4">
            
            <a href="<?php echo e(route('webclubs.tournament.detail', $tournament)); ?>"
               class="inline-flex items-center gap-1.5 text-white/80 text-sm font-semibold py-1.5 pr-3 active:opacity-60 transition-opacity">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver
            </a>

            
            
                
                
                
            
        </div>

        
        
        
        <div class="team-login-sheet-wrap sm:flex sm:min-h-[calc(100vh-6rem)] sm:items-center sm:justify-center sm:px-4 sm:py-12">
            <div class="w-full sm:max-w-md">
               
                
                
                
                <div class="bg-white  sm:rounded-3xl
                            shadow-[0_-6px_32px_rgba(0,0,0,0.10)] sm:shadow-xl sm:shadow-gray-200/60
                            sm:border sm:border-gray-100
                            px-6 pt-6 pb-10 sm:p-7 sm:pb-9">

                    
                    <div class="sm:hidden w-10 h-1 bg-gray-200 rounded-full mx-auto mb-7"></div>
                        <h1 class="text-black text-[1.6rem] font-black text-center leading-tight">Acceso equipos</h1>
                        <p class="text-black/70 text-sm font-medium mt-1 text-center"><?php echo e($tournament->name); ?></p>
            
                    
                    <div class="hidden sm:block mb-6">
                        
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($registered): ?>
                        <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-100 rounded-2xl mb-5">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-bold text-green-700">¡Inscripción completada!</p>
                                <p class="text-xs text-green-600 mt-0.5">Ya puedes acceder al área de tu equipo con las credenciales que elegiste.</p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($error): ?>
                        <div class="flex items-center gap-2.5 p-3.5 bg-red-50 border border-red-100 rounded-2xl mb-5">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-semibold text-red-600"><?php echo e($error); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <form wire:submit="login" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                            <input wire:model="email" type="email" autocomplete="email"
                                   placeholder="equipo@ejemplo.com"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Contraseña</label>
                            <input wire:model="password" type="password" autocomplete="current-password"
                                   placeholder="Tu contraseña"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-medium"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <button type="submit"
                                class="w-full py-4 sm:py-3.5 rounded-2xl text-white font-bold text-base sm:text-sm shadow-lg shadow-primary/25 hover:opacity-90 active:scale-[0.98] transition-all duration-150 mt-1"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <span wire:loading.remove wire:target="login">Entrar al área del equipo</span>
                            <span wire:loading wire:target="login" class="inline-flex items-center gap-2 justify-center">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Verificando...
                            </span>
                        </button>
                    </form>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->status === 'registration_open'): ?>
                        <div class="sm:hidden mt-6 pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-black text-gray-800">¿Tu equipo no estás inscrito?</p>
                                
                            </div>
                            <a href="<?php echo e(route('webclubs.team.register', $tournament)); ?>"
                               class="shrink-0 px-4 py-2.5 rounded-xl text-white text-sm font-bold shadow active:opacity-80 transition-opacity"
                               style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                Inscribir equipo
                            </a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    

                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->status === 'registration_open'): ?>
                    <div class="hidden sm:flex mt-4 bg-white rounded-3xl border border-gray-100 shadow-sm p-5 items-center gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-gray-800">¿Tu equipo no está inscrito?</p>
                            
                        </div>
                        <a href="<?php echo e(route('webclubs.team.register', $tournament)); ?>"
                           class="shrink-0 px-4 py-2 rounded-xl text-white text-xs font-bold shadow active:opacity-80"
                           style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            Inscribir equipo
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="hidden sm:block text-center mt-5">
                    <a href="<?php echo e(route('webclubs.tournament.detail', $tournament)); ?>"
                       class="text-sm text-gray-400 hover:text-gray-600 font-semibold transition-colors inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver al torneo
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\webclubs\team-login.blade.php ENDPATH**/ ?>