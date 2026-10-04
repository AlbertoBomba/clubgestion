<!-- Navbar -->
<nav class="bg-white border-b border-gray-100 fixed w-full top-0 z-50">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex items-center space-x-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(tenantLogo()): ?>
                    <img src="<?php echo e(tenantLogo()); ?>" alt="<?php echo e(tenantName()); ?>" class="h-14 w-auto">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div>
                    <span class="text-2xl font-bold text-gray-900 tracking-tight block"><?php echo e(tenantName()); ?></span>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Inicio</a>
                
                <a href="<?php echo e(route('webclubs.tournaments')); ?>" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Torneos</a>
                
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Panel</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Login</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('webclubs.panel-player-school')); ?>" class="bg-primary text-white px-8 py-3 text-sm font-semibold uppercase tracking-wider hover:opacity-90 transition rounded-full">
                   
                    Inscripciones <?php echo e(tenantName()); ?>

                </a>
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-900">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Barra degradada -->
    <div class="h-1" style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="px-6 py-4 space-y-3">
            <a href="<?php echo e(route('home')); ?>" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Inicio</a>
            
            <a href="<?php echo e(route('webclubs.tournaments')); ?>" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Torneos</a>
            
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Panel</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Login</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <a href="<?php echo e(route('webclubs.panel-player-school')); ?>" class="block py-2 text-blue-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Inscripciones <?php echo e(tenantName()); ?></a>

        </div>
    </div>
</nav><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\webclubs\layouts\nav-bar.blade.php ENDPATH**/ ?>