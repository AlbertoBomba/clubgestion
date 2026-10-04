<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>500 - Error del Servidor | <?php echo e(config('app.name', 'VaedSaas')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
            <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php else: ?>
            <style>
                body { font-family: 'Inter', sans-serif; }
            </style>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <style>
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
            .animate-shake {
                animation: shake 2s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2 sm:gap-3">
                        <img src="<?php echo e(asset('images/logos/logo_vaed.png')); ?>" alt="<?php echo e(config('app.name', 'VaedSaas')); ?>" class="h-10 sm:h-12 md:h-14">
                        <span class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">VaedSaas</span>
                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login')): ?>
                        <div class="flex items-center gap-2 sm:gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(url('/dashboard')); ?>" 
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                                    Dashboard
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" 
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base text-gray-700 hover:text-indigo-600 transition duration-200 font-medium">
                                    Iniciar Sesión
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- 500 Content -->
        <div class="min-h-screen flex items-center justify-center px-4 pt-16">
            <div class="max-w-2xl mx-auto text-center">
                <!-- Warning Icon -->
                <div class="flex justify-center mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-yellow-400 to-red-500 rounded-full flex items-center justify-center text-white shadow-2xl animate-shake">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>

                <!-- 500 Large Number -->
                <h1 class="text-8xl sm:text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 via-red-600 to-red-700 mb-4">
                    500
                </h1>

                <!-- Error Message -->
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    ¡Algo salió mal!
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Lo sentimos, ha ocurrido un error en el servidor. 
                    Nuestro equipo ha sido notificado y estamos trabajando para solucionarlo.
                </p>

                <!-- Error Details (if in debug mode) -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('app.debug') && isset($exception)): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 mb-8 text-left">
                        <p class="text-sm font-semibold text-red-800 mb-2">Detalles del error (modo debug):</p>
                        <p class="text-xs text-red-700 font-mono"><?php echo e($exception->getMessage()); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo e(url('/')); ?>" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-red-600 text-white rounded-lg hover:from-yellow-600 hover:to-red-700 transition duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Volver al Inicio
                    </a>
                    
                    <button onclick="location.reload()" 
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition duration-200 font-semibold text-base">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reintentar
                    </button>
                </div>

                <!-- Support Info -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Si el problema persiste, por favor contacta con nuestro equipo de soporte:
                        <a href="<?php echo e(url('/')); ?>#contacto" class="text-indigo-600 hover:text-indigo-800 font-semibold ml-1">
                            Ir a Contacto
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-8 text-center text-gray-600 text-sm">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'VaedSaas')); ?>. Todos los derechos reservados.</p>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\errors\500.blade.php ENDPATH**/ ?>