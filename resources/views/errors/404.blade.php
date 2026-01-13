<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>404 - Página No Encontrada | {{ config('app.name', 'VaedSaas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body { font-family: 'Inter', sans-serif; }
            </style>
        @endif

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .animate-float {
                animation: float 4s ease-in-out infinite;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .fade-in {
                animation: fadeIn 0.8s ease-out forwards;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3">
                        <img src="{{ asset('images/logos/logo_vaed.png') }}" alt="{{ config('app.name', 'VaedSaas') }}" class="h-10 sm:h-12 md:h-14">
                        <span class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">VaedSaas</span>
                    </a>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-2 sm:gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                                    <span class="hidden sm:inline">Iniciar Sesión</span>
                                    <span class="sm:hidden">Iniciar sesión</span>
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- 404 Content -->
        <div class="min-h-screen flex items-center justify-center px-4 pt-16">
            <div class="max-w-6xl mx-auto w-full">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Side: 404 Message -->
                    <div class="text-center lg:text-left fade-in" style="animation-delay: 0.1s;">
                        <!-- 404 Large Number -->
                        <div class="mb-8">
                            <h1 class="text-8xl sm:text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
                                404
                            </h1>
                        </div>

                        <!-- Error Message -->
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                            ¡Ups! Página no encontrada
                        </h2>
                        
                        <p class="text-lg sm:text-xl text-gray-600 mb-8 leading-relaxed">
                            Lo sentimos, la página que buscas no existe o ha sido movida. 
                            Puede que hayas escrito mal la URL o que el enlace esté desactualizado.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ url('/') }}" 
                               class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Volver al Inicio
                            </a>
                            
                            <a href="javascript:history.back()" 
                               class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition duration-200 font-semibold text-base">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Página Anterior
                            </a>
                        </div>

                        <!-- Quick Links -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-4 font-semibold">Enlaces útiles:</p>
                            <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                                <a href="{{ url('/') }}#contacto" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    Contacto
                                </a>
                                <span class="text-gray-300">•</span>
                                <a href="{{ url('/') }}#por-que-gratis" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    ¿Por qué gratis?
                                </a>
                                @auth
                                    <span class="text-gray-300">•</span>
                                    <a href="{{ url('/dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                        Dashboard
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Illustration -->
                    <div class="relative hidden lg:block fade-in" style="animation-delay: 0.3s;">
                        <div class="relative animate-float">
                            <!-- Background Decorative Circles -->
                            <div class="absolute top-10 right-10 w-72 h-72 bg-gradient-to-br from-indigo-200 to-purple-200 rounded-full opacity-20 blur-3xl"></div>
                            <div class="absolute bottom-10 left-10 w-64 h-64 bg-gradient-to-br from-pink-200 to-purple-200 rounded-full opacity-20 blur-3xl"></div>
                            
                            <!-- Main Illustration Container -->
                            <div class="relative bg-white rounded-3xl shadow-2xl p-12">
                                <!-- Soccer Ball Icon -->
                                <div class="flex justify-center mb-8">
                                    <div class="w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white shadow-xl">
                                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Decorative Elements -->
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-indigo-600">⚽</div>
                                        <p class="text-xs text-gray-600 mt-2">Equipos</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-purple-600">📊</div>
                                        <p class="text-xs text-gray-600 mt-2">Estadísticas</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-4 text-center">
                                        <div class="text-2xl font-bold text-pink-600">🏆</div>
                                        <p class="text-xs text-gray-600 mt-2">Torneos</p>
                                    </div>
                                </div>

                                <!-- Search Bar Mockup -->
                                <div class="mt-8 bg-gray-50 rounded-xl p-4 border-2 border-dashed border-gray-300">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <div class="flex-1 h-4 bg-gray-300 rounded animate-pulse"></div>
                                    </div>
                                </div>

                                <!-- Info Message -->
                                <div class="mt-6 bg-indigo-50 border-l-4 border-indigo-500 rounded-r-lg p-4">
                                    <p class="text-sm text-indigo-800">
                                        <span class="font-semibold">¿Necesitas ayuda?</span> Estamos aquí para ti.
                                    </p>
                                </div>
                            </div>

                            <!-- Floating Elements -->
                            <div class="absolute -top-8 -left-8 w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full opacity-80 animate-float" style="animation-duration: 3s;"></div>
                            <div class="absolute -bottom-6 -right-6 w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full opacity-80 animate-float" style="animation-duration: 4s; animation-delay: 0.5s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-8 text-center text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'VaedSaas') }}. Todos los derechos reservados.</p>
        </div>
    </body>
</html>
