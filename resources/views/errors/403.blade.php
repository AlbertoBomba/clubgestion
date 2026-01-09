<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>403 - Acceso Prohibido | {{ config('app.name', 'VaedSaas') }}</title>

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
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
            .animate-pulse-slow {
                animation: pulse 3s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-red-50 to-orange-50">
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
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base text-gray-700 hover:text-indigo-600 transition duration-200 font-medium">
                                    Iniciar Sesión
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- 403 Content -->
        <div class="min-h-screen flex items-center justify-center px-4 pt-16">
            <div class="max-w-2xl mx-auto text-center">
                <!-- Lock Icon -->
                <div class="flex justify-center mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center text-white shadow-2xl animate-pulse-slow">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>

                <!-- 403 Large Number -->
                <h1 class="text-8xl sm:text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-600 mb-4">
                    403
                </h1>

                <!-- Error Message -->
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    Acceso Prohibido
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Lo sentimos, no tienes permisos para acceder a esta página. 
                    Si crees que esto es un error, contacta con el administrador.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 to-orange-600 text-white rounded-lg hover:from-red-700 hover:to-orange-700 transition duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Volver al Inicio
                    </a>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition duration-200 font-semibold text-base">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition duration-200 font-semibold text-base">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-8 text-center text-gray-600 text-sm">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'VaedSaas') }}. Todos los derechos reservados.</p>
        </div>
    </body>
</html>
