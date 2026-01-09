<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Vaed-APP') }} - Gestión GRATUITA para Escuelas de Fútbol</title>

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
            .hero-fullscreen {
                min-height: 100vh;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                position: relative;
                overflow: hidden;
            }
            .hero-bg-pattern {
                position: absolute;
                inset: 0;
                background-image: 
                    radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                    url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
            }
            .card-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes slideInLeft {
                from {
                    transform: translateX(-50px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideInRight {
                from {
                    transform: translateX(50px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            .animate-slide-left {
                animation: slideInLeft 0.8s ease-out;
            }
            .animate-slide-right {
                animation: slideInRight 0.8s ease-out;
            }
            .mockup-shadow {
                filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.5));
            }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-800">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <img src="{{ asset('images/logos/logo_vaed.png') }}" alt="{{ config('app.name', 'Vaed-APP') }}" class="h-10 sm:h-12 md:h-14">
                        <span class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">VaedSaas</span>
                    </div>
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
                                    <span class="hidden sm:inline">Iniciar Sesión</span>
                                    <span class="sm:hidden">Iniciar sesión</span>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                                        <span class="hidden sm:inline">Registrarse</span>
                                        <span class="sm:hidden">Registro</span>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Fullscreen Section -->
        <section class="hero-fullscreen flex items-center relative">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=2000&auto=format&fit=crop" 
                     alt="Football Team" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/95 via-blue-900/90 to-blue-900/70"></div>
            </div>
            
            <!-- Decorative Diagonal Stripes (Left Side) -->
            <div class="absolute left-0 top-0 bottom-0 w-12 opacity-30">
                <div class="absolute top-16 left-0 w-8 h-20 bg-white/20 transform -skew-y-12"></div>
                <div class="absolute top-40 left-0 w-8 h-16 bg-white/15 transform -skew-y-12"></div>
                <div class="absolute top-60 left-0 w-8 h-24 bg-white/20 transform -skew-y-12"></div>
                <div class="absolute top-96 left-0 w-8 h-20 bg-white/15 transform -skew-y-12"></div>
            </div>
            
            <!-- Decorative Triangles (Bottom Right) -->
            <div class="absolute bottom-8 right-8 grid grid-cols-8 gap-4 opacity-40">
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
            </div>
            <div class="absolute bottom-16 right-8 grid grid-cols-8 gap-4 opacity-40">
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
            </div>
            <div class="absolute bottom-24 right-8 grid grid-cols-8 gap-4 opacity-40">
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
                <div class="w-2 h-2 bg-white transform rotate-45"></div>
            </div>
            
            <div class="relative z-10 w-full px-4 sm:px-6 lg:px-8 py-20">
                <div class="max-w-7xl mx-auto">
                    <div class="grid lg:grid-cols-2 gap-12 items-center min-h-[calc(100vh-10rem)]">
                        <!-- Left Content -->
                        <div class="text-white animate-slide-left">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 sm:mb-6 leading-tight">
                                La app nº1 para gestionar un equipo o un club de deporte amateur
                            </h1>
                            
                            <p class="text-sm sm:text-base lg:text-lg text-gray-200 mb-6 sm:mb-8 leading-relaxed max-w-xl">
                                Como dirigente de club o como entrenador, simplifica la organización y la comunicación interna de tu equipo o club deportivo.
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                               
                                    <a href="#contacto" 
                                       class="px-8 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:scale-105 text-center">
                                        Registrar mi equipo
                                    </a>
                                    <a href="#por-que-gratis" 
                                       class="px-8 py-3 bg-white bg-opacity-10 backdrop-blur-sm text-white rounded-lg hover:bg-opacity-20 transition duration-200 font-semibold text-base border border-white text-center">
                                       ¿Porque VaedSaas es gratis?
                                    </a>
                                
                            </div>
                        </div>
                        
                        <!-- Right Content - Interactive Mockup -->
                        <div class="relative animate-slide-right hidden lg:block min-h-[600px]">
                            <!-- Central Phone Mockup -->
                            <div class="relative mx-auto animate-float" style="max-width: 280px; z-index: 20;">
                                <div class="bg-black rounded-[2.5rem] p-2 shadow-2xl">
                                    <div class="bg-white rounded-[2.2rem] overflow-hidden" style="aspect-ratio: 9/19.5;">
                                        <img src="{{ asset('images/public/capturaappmovil.jpg') }}" 
                                             alt="Captura de la app móvil" 
                                             class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Desktop Monitor Mockup (Below Phone) -->
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2" style="width: 400px; z-index: 25; animation: float 7s ease-in-out infinite 0.3s;">
                                <!-- Monitor Stand -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full">
                                    <div class="w-24 h-6 bg-gradient-to-b from-gray-700 to-gray-800 rounded-b-xl shadow-xl"></div>
                                    <div class="w-40 h-2 bg-gradient-to-b from-gray-800 to-gray-900 rounded-full mx-auto -mt-1 shadow-2xl"></div>
                                </div>
                                
                                <!-- Monitor Frame -->
                                <div class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-xl p-2 shadow-2xl">
                                    <!-- Screen -->
                                    <div class="bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/10;">
                                        <img src="{{ asset('images/public/capturapc.jpg') }}" 
                                             alt="Captura de la app en escritorio" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <!-- Webcam -->
                                    <div class="absolute top-1 left-1/2 transform -translate-x-1/2 w-1.5 h-1.5 bg-gray-700 rounded-full border border-gray-600"></div>
                                </div>
                            </div>
                            
                            <!-- Floating Card: Disponible para el partido -->
                            <div class="absolute top-4 left-0 bg-gray-700/90 backdrop-blur-md text-white rounded-xl p-4 shadow-2xl" style="width: 240px; z-index: 30; animation: float 4s ease-in-out infinite;">
                                <p class="text-sm mb-3">¿Gestión de cobros?</p>
                                <div class="flex gap-2">
                                    <button class="flex-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                        Sí
                                    </button>
                                    <button class="flex-1 bg-gray-600 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                        No
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Floating Card: Estadísticas -->
                            <div class="absolute top-32 right-0 bg-gray-700/90 backdrop-blur-md text-white rounded-xl p-4 shadow-2xl" style="width: 220px; z-index: 30; animation: float 5s ease-in-out infinite 0.5s;">
                                <p class="text-sm font-semibold mb-3">Estadísticas del equipo</p>
                                <div class="relative h-16 bg-gray-800 rounded-lg overflow-hidden">
                                    <svg class="w-full h-full" viewBox="0 0 200 60" preserveAspectRatio="none">
                                        <path d="M0,50 Q50,20 100,35 T200,15" fill="none" stroke="#10b981" stroke-width="3"/>
                                        <path d="M0,50 Q50,20 100,35 T200,15 L200,60 L0,60 Z" fill="url(#gradient)" opacity="0.3"/>
                                        <defs>
                                            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                                <stop offset="0%" style="stop-color:#10b981;stop-opacity:0.8" />
                                                <stop offset="100%" style="stop-color:#10b981;stop-opacity:0" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div class="absolute top-2 right-2 w-2 h-2 bg-yellow-400 rounded-full"></div>
                                </div>
                            </div>
                            
                            <!-- Floating Card: Invitar socios -->
                            <div class="absolute bottom-12 left-4 bg-gray-700/90 backdrop-blur-md text-white rounded-xl p-4 shadow-2xl" style="width: 260px; z-index: 30; animation: float 6s ease-in-out infinite 1s;">
                                <p class="text-xs mb-3">Tienda del club</p>
                                <button class="w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                    Comprar
                                </button>
                            </div>
                            
                            <!-- Avatar Connections -->
                            <!-- Avatar 1 -->
                            <div class="absolute top-48 left-16" style="z-index: 25; animation: float 3s ease-in-out infinite 0.2s;">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-3 border-white shadow-lg overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold">👤</div>
                                </div>
                                <!-- Dotted line to phone -->
                                <svg class="absolute top-6 left-12" width="80" height="60" style="overflow: visible;">
                                    <path d="M0,0 Q40,20 80,30" stroke="#059669" stroke-width="2" stroke-dasharray="4,4" fill="none" opacity="0.6"/>
                                </svg>
                            </div>
                            
                            <!-- Avatar 2 -->
                            <div class="absolute top-60 left-4" style="z-index: 25; animation: float 4s ease-in-out infinite 0.7s;">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 border-3 border-white shadow-lg overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">👤</div>
                                </div>
                                <!-- Dotted line -->
                                <svg class="absolute top-5 left-10" width="60" height="40" style="overflow: visible;">
                                    <path d="M0,0 L60,20" stroke="#dc2626" stroke-width="2" stroke-dasharray="4,4" fill="none" opacity="0.6"/>
                                </svg>
                            </div>
                            
                            <!-- Avatar 3 -->
                            <div class="absolute top-20 right-24" style="z-index: 25; animation: float 3.5s ease-in-out infinite 1.2s;">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-green-400 to-green-600 border-3 border-white shadow-lg overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold">👤</div>
                                </div>
                                <!-- Dotted line with arrow -->
                                <svg class="absolute top-6 left-0" width="100" height="80" style="overflow: visible;">
                                    <defs>
                                        <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                                            <polygon points="0 0, 10 3.5, 0 7" fill="#10b981" />
                                        </marker>
                                    </defs>
                                    <path d="M0,10 Q-30,40 -70,60" stroke="#10b981" stroke-width="2" stroke-dasharray="5,5" fill="none" opacity="0.7" marker-end="url(#arrowhead)"/>
                                </svg>
                            </div>
                            
                            <!-- Connection dots/nodes -->
                            <div class="absolute top-56 left-28 w-2 h-2 bg-cyan-400 rounded-full shadow-lg" style="z-index: 12; animation: pulse 2s ease-in-out infinite;"></div>
                            <div class="absolute top-72 left-20 w-2 h-2 bg-green-400 rounded-full shadow-lg" style="z-index: 12; animation: pulse 2s ease-in-out infinite 0.5s;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 animate-bounce z-30">
                <svg class="w-8 h-8 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </section>

        <!-- Integrated Solution Section -->
        <section class="bg-gray-50 py-12 sm:py-16 md:py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 text-center mb-10 sm:mb-16 md:mb-20 px-4">
                   Solución integrada para la gestión de tu club.
                </h2>

                <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 md:gap-16 items-center">
                    <!-- Left Side: Image and Chart -->
                    <div class="relative h-[400px] sm:h-[500px] md:h-[600px]">
                        <!-- Background circles in top right -->
                        <div class="absolute top-20 right-0 z-0">
                            <svg width="250" height="250" viewBox="0 0 250 250">
                                <circle cx="125" cy="125" r="110" fill="none" stroke="#9ca3af" stroke-width="2.5" opacity="0.6"/>
                                <circle cx="125" cy="125" r="80" fill="none" stroke="#9ca3af" stroke-width="2.5" opacity="0.6"/>
                                <circle cx="125" cy="125" r="50" fill="none" stroke="#9ca3af" stroke-width="2.5" opacity="0.6"/>
                            </svg>
                        </div>
                        
                        <!-- Person Image Card -->
                        <div class="relative z-10 bg-white rounded-3xl shadow-xl overflow-hidden w-full max-w-md">
                            <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?q=80&w=800&auto=format&fit=crop" 
                                 alt="Gestión profesional" 
                                 class="w-full h-80 object-cover">
                        </div>

                        <!-- Chart Card Overlapping Image -->
                        <div class="absolute bottom-0 left-8 right-0 z-20 bg-white rounded-3xl shadow-2xl p-4 sm:p-8 max-w-xl">
                            <!-- Chart with curves -->
                            <div class="relative h-40 sm:h-56">
                                <svg class="w-full h-full" viewBox="0 0 500 200" preserveAspectRatio="none">
                                    <!-- Light green area fill under curves -->
                                    <path d="M10,175 Q90,95 170,90 Q250,85 310,110 Q370,135 490,155 L490,200 L10,200 Z" 
                                          fill="#d1fae5" 
                                          opacity="0.7"/>
                                    
                                    <!-- Purple/Blue curve -->
                                    <path d="M10,175 Q90,95 170,90 Q250,85 310,110 Q370,135 490,155" 
                                          fill="none" 
                                          stroke="#6366f1" 
                                          stroke-width="4" 
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    
                                    <!-- Turquoise/Green curve -->
                                    <path d="M10,180 Q90,120 170,105 Q250,95 310,85 Q370,100 490,140" 
                                          fill="none" 
                                          stroke="#10b981" 
                                          stroke-width="4" 
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    
                                    <!-- Point marker on purple curve at February -->
                                    <circle cx="310" cy="110" r="5" fill="white"/>
                                    <circle cx="310" cy="110" r="7" fill="none" stroke="#6366f1" stroke-width="3"/>
                                    
                                    <!-- Connecting dashed line to label -->
                                    <line x1="310" y1="110" x2="350" y2="50" stroke="#10b981" stroke-width="2.5" stroke-dasharray="4,4"/>
                                </svg>
                                
                                <!-- Price Label -->
                                <div class="absolute top-6 left-1/2 transform -translate-x-1/4 bg-white rounded-xl shadow-lg px-4 py-2 border border-gray-100">
                                    <div class="text-xl font-bold text-gray-900">1265 €</div>
                                    <div class="text-xs text-gray-500 text-center">Febrero</div>
                                </div>
                            </div>
                            
                            <!-- Month Labels -->
                            <div class="flex justify-between text-sm text-gray-500 font-semibold mt-5 px-1">
                                <span>NOV</span>
                                <span>DIC</span>
                                <span>ENE</span>
                                <span>FEB</span>
                                <span>MAR</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Content -->
                    <div class="lg:pl-8">
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            Herramientas de gestión de cobro de cuotas
                        </h3>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Elige las cuotas para los pagos, y automatiza los mismos. Envía recordatorios automáticos a los jugadores morosos y gestiona todo desde un mismo lugar.
                        </p>
                        <br>
                         <p class="text-lg text-gray-700 leading-relaxed">
                            Una solución sencilla y eficaz para que los clubes y escuelas de fútbol puedan centrarse en lo que realmente importa: ¡el deporte!
                        </p>
                        <br>
                         <p class="text-lg text-gray-700 leading-relaxed">
                            Si no dispone de TPV virtual, prestamos el nuestro respetando las mismas condiciones que si lo contrata directamente con el banco.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Calendarios de eventos y gestión de asistencia Section -->
        <section class="bg-white py-12 sm:py-16 md:py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 md:gap-16 items-center">
                    <!-- Left Side: Content -->
                    <div class="lg:pr-8">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6">
                            Calendarios de eventos y gestión de convocatorias
                        </h3>
                        <p class="text-lg text-gray-700 leading-relaxed mb-4">
                            Crea rápidamente programas de entrenamiento en función de tus instalaciones disponibles, equipos o cuerpo técnico. Envía actualizaciones personalizadas y automatizadas a los jugadores.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Obtén un registro preciso de la asistencia a las sesiones de entrenamiento con solo pulsar un botón, para optimizar tu planificación.
                        </p>
                    </div>

                    <!-- Right Side: Image -->
                    <div class="relative hidden lg:block">
                        <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden">
                            <div class="p-2 sm:p-6 md:p-8">
                                <!-- Attendance Card -->
                                <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-3 sm:p-6 md:p-8">
                                    <h4 class="text-lg sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-6">Convocatoria</h4>
                                    
                                    <!-- Attendance List -->
                                    <div class="space-y-2 sm:space-y-4 mb-6 sm:mb-8">
                                        <!-- Player 1 - Present -->
                                        <div class="flex items-center justify-between p-2 sm:p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                            <div class="flex items-center gap-2 sm:gap-3">
                                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                                                    👤
                                                </div>
                                                <div class="h-4 bg-gray-200 rounded w-32"></div>
                                            </div>
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Player 2 - Present -->
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    👤
                                                </div>
                                                <div class="h-4 bg-gray-200 rounded w-28"></div>
                                            </div>
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Player 3 - Absent -->
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    👤
                                                </div>
                                                <div class="h-4 bg-gray-200 rounded w-36"></div>
                                            </div>
                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Player 4 - Partial -->
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    👤
                                                </div>
                                                <div class="h-4 bg-gray-200 rounded w-24"></div>
                                            </div>
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Stats Badge -->
                                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-3 sm:p-4 flex items-center justify-between flex-wrap gap-2">
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Convocados</p>
                                            <p class="text-3xl font-bold text-gray-900">16</p>
                                        </div>
                                        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold text-sm">
                                            Partido contra "Los Tigres"
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative floating image in background -->
                        <div class="absolute -top-12 -right-12 w-64 h-64 opacity-20 z-0">
                            <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=800&auto=format&fit=crop" 
                                 alt="Football training" 
                                 class="w-full h-full object-cover rounded-full blur-sm">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ¿Gestionas un club? Section -->
        <section class="bg-gray-50 py-12 sm:py-16 md:py-20 px-4 relative overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 md:gap-16 items-center">
                    <!-- Left Side: Image with decorations -->
                    <div class="relative">
                        <!-- Decorative X grid pattern in top right -->
                        <div class="absolute -top-8 -right-8 z-0 grid grid-cols-14 gap-4 opacity-30">
                            <svg class="w-full h-auto" viewBox="0 0 280 100" xmlns="http://www.w3.org/2000/svg">
                                <!-- Row 1 -->
                                <text x="10" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="30" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="50" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="70" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="90" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="110" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="130" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="150" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="170" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="190" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="210" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="230" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="250" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="270" y="15" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <!-- Row 2 -->
                                <text x="10" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="30" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="50" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="70" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="90" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="110" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="130" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="150" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="170" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="190" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="210" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="230" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="250" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="270" y="35" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <!-- Row 3 partial -->
                                <text x="250" y="55" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="270" y="55" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <!-- Row 4 partial -->
                                <text x="250" y="75" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="270" y="75" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <!-- Row 5 partial -->
                                <text x="250" y="95" font-size="14" fill="#10b981" font-weight="bold">×</text>
                                <text x="270" y="95" font-size="14" fill="#10b981" font-weight="bold">×</text>
                            </svg>
                        </div>
                        
                        <!-- Image container with left arrow -->
                        <div class="relative z-10">
                            <!-- Left arrow -->
                            <div class="absolute left-0 top-1/2 transform -translate-x-12 -translate-y-1/2 z-20 hidden lg:block">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="18" stroke="#d1d5db" stroke-width="2" fill="white"/>
                                    <path d="M24 14l-6 6 6 6" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            
                            <!-- Main image card -->
                            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-4 border-blue-400">
                                <img src="https://images.unsplash.com/photo-1552674605-db6ffd4facb5?q=80&w=800&auto=format&fit=crop" 
                                     alt="Gestión de club deportivo" 
                                     class="w-full h-96 object-cover">
                            </div>
                        </div>
                        
                        <!-- Bottom decorative icons -->
                        <div class="flex items-center gap-8 mt-8 pl-4">
                            <!-- Circle -->
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-3 h-3 rounded-full border-2 border-gray-400 bg-white"></div>
                                <div class="w-0.5 h-12 bg-gray-300 border-l-2 border-dashed border-gray-400"></div>
                            </div>
                            
                            <!-- Circle -->
                            <div class="flex flex-col items-center gap-2 -ml-6">
                                <div class="w-3 h-3 rounded-full border-2 border-gray-400 bg-white"></div>
                                <div class="w-0.5 h-12 bg-gray-300 border-l-2 border-dashed border-gray-400"></div>
                            </div>
                            
                            <!-- X -->
                            <div class="flex flex-col items-center gap-2 -ml-6">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 2L10 10M2 10L10 2" stroke="#9ca3af" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                <div class="w-0.5 h-12 bg-gray-300 border-l-2 border-dashed border-gray-400"></div>
                            </div>
                            
                            <!-- X -->
                            <div class="flex flex-col items-center gap-2 -ml-6">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 2L10 10M2 10L10 2" stroke="#9ca3af" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                <div class="w-0.5 h-12 bg-gray-300 border-l-2 border-dashed border-gray-400"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Content -->
                    <div class="lg:pl-8">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 sm:mb-6">
                            ¿Gestionas tu club?
                        </h3>
                        
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4 sm:mb-6">
                            Un club de deporte amateur impulsa los vínculos sociales, pero también representa un tiempo de gestión considerable: 3800 horas de trabajo voluntario por año y por club. Haz que todo el club sea más eficiente con VaedSaas.
                        </p>
                        
                        {{-- <a href="#" class="inline-block text-green-600 font-semibold hover:text-green-700 mb-8 text-lg">
                            Más información →
                        </a> --}}
                        
                        {{-- <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" 
                               class="px-8 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200 font-semibold text-base shadow-lg hover:shadow-xl transform hover:scale-105 text-center">
                                Registrar mi club
                            </a>
                            <a href="#" 
                               class="px-8 py-3 bg-white text-green-600 border-2 border-green-500 rounded-lg hover:bg-green-50 transition duration-200 font-semibold text-base text-center">
                                Explorar SportEasy
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>

        <!-- ¿Por qué VaedSaas es gratuito? Section -->
        <section id="por-que-gratis" class="bg-gray-50 py-12 sm:py-16 md:py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 text-center mb-10 sm:mb-16 md:mb-20 px-4">
                    ¿Por qué VaedSaas es <span class="text-green-600">Gratuito para Siempre</span>?
                </h2>

                <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 md:gap-16 items-center mb-10 sm:mb-16 md:mb-20">
                    <!-- Left Side: Content -->
                    <div class="lg:pr-8">
                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6">
                            Modelo Win-Win: Ganamos juntos
                        </h3>
                        <p class="text-lg text-gray-700 leading-relaxed mb-4">
                            Creemos en crear una <span class="font-bold text-green-600">sinergia donde ambos ganamos</span>. VaedSaas vende productos deportivos a través de tu club, y esta es nuestra forma de monetizar la plataforma.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed mb-4">
                            Por cada venta realizada, tu club recibe automáticamente entre un <span class="font-bold text-green-600 text-xl">10% y 15%</span> como saldo acumulable que podrás solicitar en cualquier momento.
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Lo mejor: <span class="font-bold">tu club no gestiona nada</span>. VaedSaas tramita el pedido, lo personaliza con el logo de tu club y lo envía directamente. Cero preocupaciones, solo ganancias.
                        </p>
                    </div>

                    <!-- Right Side: Visual Diagram -->
                    <div class="relative h-[400px] sm:h-[500px] md:h-[600px] order-first lg:order-last">
                        <!-- Background circles in top right -->
                        <div class="absolute top-10 sm:top-20 right-0 z-0">
                            <svg width="250" height="250" viewBox="0 0 250 250">
                                <circle cx="125" cy="125" r="110" fill="none" stroke="#10b981" stroke-width="2.5" opacity="0.3"/>
                                <circle cx="125" cy="125" r="80" fill="none" stroke="#10b981" stroke-width="2.5" opacity="0.3"/>
                                <circle cx="125" cy="125" r="50" fill="none" stroke="#10b981" stroke-width="2.5" opacity="0.3"/>
                            </svg>
                        </div>
                        
                        <!-- Product Cards -->
                        <div class="relative z-10 bg-white rounded-3xl shadow-xl p-8 w-full max-w-md">
                            <h4 class="text-xl font-bold text-gray-900 mb-6 text-center">Productos Disponibles</h4>
                            
                            <!-- Product 1 -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 mb-4">
                                <div class="flex items-center gap-4 mb-3">
                                    <div>
                                        <h5 class="font-bold text-gray-900">Mochilas</h5>
                                        <p class="text-sm text-gray-600">Personalizadas</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">Desde 25€</span>
                                    <span class="text-green-600 font-bold">+3.75€ club</span>
                                </div>
                            </div>
                            
                            <!-- Product 2 -->
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 mb-4">
                                <div class="flex items-center gap-4 mb-3">
                                    {{-- <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center text-3xl">
                                        👕
                                    </div> --}}
                                    <div>
                                        <h5 class="font-bold text-gray-900">Ropa Entrenamiento</h5>
                                        <p class="text-sm text-gray-600">Con logo del club</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">Desde 35€</span>
                                    <span class="text-green-600 font-bold">+5.25€ club</span>
                                </div>
                            </div>
                            
                            <!-- Product 3 -->
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6">
                                <div class="flex items-center gap-4 mb-3">
                                    {{-- <div class="w-16 h-16 bg-purple-500 rounded-lg flex items-center justify-center text-3xl">
                                        ⚽
                                    </div> --}}
                                    <div>
                                        <h5 class="font-bold text-gray-900">Equipamiento</h5>
                                        <p class="text-sm text-gray-600">Material deportivo</p>
                                    </div>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">Desde 20€</span>
                                    <span class="text-green-600 font-bold">+3€ club</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Card Overlapping -->
                        <div class="absolute bottom-[-90px] sm:bottom-[-80px] left-4 sm:left-8 right-4 sm:right-0 z-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl sm:rounded-3xl shadow-2xl p-4 sm:p-8 max-w-xl text-white">
                            <h4 class="text-lg sm:text-2xl font-bold mb-4 sm:mb-6">Ejemplo Mensual</h4>
                            
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl p-3 sm:p-4 text-center">
                                    <div class="text-2xl sm:text-3xl font-bold">300€</div>
                                    <div class="text-xs sm:text-sm opacity-90">Ventas</div>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl p-3 sm:p-4 text-center">
                                    <div class="text-2xl sm:text-3xl font-bold">45€</div>
                                    <div class="text-xs sm:text-sm opacity-90">Para tu club</div>
                                </div>
                            </div>
                            
                            <div class="bg-white/30 backdrop-blur-sm rounded-lg sm:rounded-xl p-3 sm:p-4">
                                <p class="text-xs sm:text-sm font-semibold mb-2">✓ Sin gestión de inventario</p>
                                <p class="text-xs sm:text-sm font-semibold mb-2">✓ Sin gestión de envíos</p>
                                <p class="text-xs sm:text-sm font-semibold">✓ Saldo disponible cuando quieras</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How it Works - Simple 3 Steps -->
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 md:p-12">
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8 sm:mb-12 text-center">
                        Cómo Funciona en 3 Pasos
                    </h3>
                    
                    <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-8">
                        <!-- Step 1 -->
                        <div class="text-center flex-1 max-w-xs">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-6 shadow-lg">
                                1
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Jugadores Compran</h4>
                            <p class="text-gray-700 leading-relaxed">
                                Los jugadores de tu club compran productos deportivos personalizados a través de la tienda de VaedSaas de tu club
                            </p>
                        </div>

                        <!-- Arrow -->
                        <div class="hidden md:flex items-center justify-center flex-shrink-0">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path d="M5 20h30M25 10l10 10-10 10" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <!-- Step 2 -->
                        <div class="text-center flex-1 max-w-xs">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-6 shadow-lg">
                                2
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">VaedSaas Gestiona</h4>
                            <p class="text-gray-700 leading-relaxed">
                                Nosotros tramitamos el pedido, lo personalizamos con el logo del club y lo enviamos directamente
                            </p>
                        </div>

                        <!-- Arrow -->
                        <div class="hidden md:flex items-center justify-center flex-shrink-0">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path d="M5 20h30M25 10l10 10-10 10" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <!-- Step 3 -->
                        <div class="text-center flex-1 max-w-xs">
                            <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-6 shadow-lg">
                                3
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Tu Club Gana</h4>
                            <p class="text-gray-700 leading-relaxed">
                                El <span class="font-bold text-green-600">10-15%</span> de cada venta se acumula automáticamente en tu saldo. Retíralo cuando quieras
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Contact Form Section -->
        <section id="contacto" class="py-20 px-4 ">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">¿Tienes Preguntas? Contáctanos</h2>
                    <p class="text-xl text-gray-600">
                        Si quieres probar VaedSaas o tienes alguna duda, completa el formulario y te contactaremos pronto.
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 border-2 border-green-100">
                    <form class="space-y-6" x-data="{ submitting: false }" @submit.prevent="submitting = true; setTimeout(() => { alert('Gracias por tu mensaje. Te contactaremos pronto.'); submitting = false; $el.reset(); }, 1000)">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre Completo *
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                                    placeholder="Juan Pérez"
                                >
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email *
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                                    placeholder="juan@escuelafutbol.com"
                                >
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Teléfono
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                                    placeholder="+34 600 000 000"
                                >
                            </div>
                            
                            <div>
                                <label for="club" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre de tu Escuela/Club
                                </label>
                                <input 
                                    type="text" 
                                    id="club" 
                                    name="club"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                                    placeholder="CD Mi Escuela"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                Mensaje *
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5" 
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-200"
                                placeholder="Cuéntanos cómo podemos ayudarte..."
                            ></textarea>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <input 
                                type="checkbox" 
                                id="privacy" 
                                name="privacy" 
                                required
                                class="mt-1 w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                            >
                            <label for="privacy" class="text-sm text-gray-600">
                                Acepto la política de privacidad y el tratamiento de mis datos *
                            </label>
                        </div>
                        
                        <button 
                            type="submit"
                            :disabled="submitting"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-8 rounded-lg font-bold text-lg hover:from-green-600 hover:to-green-700 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span x-show="!submitting">Enviar Mensaje</span>
                            <span x-show="submitting" x-cloak>Enviando...</span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
        
        <!-- Aplicación Móvil Section -->
        <section class="py-12 sm:py-16 md:py-20 px-4 relative overflow-hidden" style="background-color: #1e3a8a;">
            <!-- Decorative elements -->
            <div class="absolute top-10 sm:top-20 right-10 sm:right-20 w-48 sm:w-96 h-48 sm:h-96 bg-blue-400 rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-10 sm:bottom-20 left-10 sm:left-20 w-48 sm:w-96 h-48 sm:h-96 bg-blue-300 rounded-full opacity-10 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 md:gap-16 items-center">
                    <!-- Left Side: Content -->
                    <div class="text-white">
                        <div class="inline-block px-4 py-2 bg-cyan-500/20 text-cyan-400 rounded-lg font-bold text-sm mb-6 border border-cyan-500/30">
                            APLICACIÓN MÓVIL
                        </div>
                        
                        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 sm:mb-6 leading-tight">
                            Para entrenadores, familiares y deportistas
                        </h2>
                        
                        <p class="text-base sm:text-lg text-gray-300 mb-6 sm:mb-8 leading-relaxed">
                            La App que simplifica los clubes deportivos. Disponible para los usuarios de los clubes registrados.
                        </p>
                        
                        <a href="#" class="inline-block text-cyan-400 font-semibold hover:text-cyan-300 mb-8 text-lg">
                            COMPRUEBE SI TU CLUB ESTÁ REGISTRADO →
                        </a>
                        
                        <!-- App Store Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#" class="inline-block transform hover:scale-105 transition-transform duration-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" 
                                     alt="Descargar en Google Play" 
                                     class="h-14">
                            </a>
                            <a href="#" class="inline-block transform hover:scale-105 transition-transform duration-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" 
                                     alt="Descargar en App Store" 
                                     class="h-14">
                            </a>
                        </div>
                    </div>

                    <!-- Right Side: Phone Mockups -->
                    <div class="relative h-[600px] hidden lg:block">
                        <!-- Decorative circles in background -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-96 h-96 border-2 border-cyan-500/20 rounded-full"></div>
                        </div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-80 h-80 border-2 border-purple-500/20 rounded-full"></div>
                        </div>
                        
                        <!-- Decorative icons -->
                        <div class="absolute top-20 right-20 w-16 h-16 bg-cyan-500/20 rounded-2xl flex items-center justify-center border border-cyan-500/30">
                            <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        
                        <div class="absolute bottom-32 right-8 w-20 h-20 bg-purple-500/20 rounded-2xl flex items-center justify-center border border-purple-500/30">
                            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        
                        <!-- Phone 1 - Left (Training Screen) -->
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2" style="z-index: 20;">
                            <div class="bg-gradient-to-b from-gray-900 to-black rounded-[2.5rem] p-3 shadow-2xl" style="width: 280px;">
                                <div class="bg-gradient-to-br from-cyan-500 to-green-500 rounded-[2rem] overflow-hidden" style="aspect-ratio: 9/19.5;">
                                    <div class="relative w-full h-full">
                                        <!-- Status bar -->
                                        <div class="absolute top-0 left-0 right-0 px-6 py-3 flex justify-between items-center text-white text-xs">
                                            <span>9:41</span>
                                            <div class="flex items-center gap-1">
                                                <div class="w-4 h-3 border border-white rounded-sm"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="pt-16 px-6">
                                            <button class="text-white mb-4">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                </svg>
                                            </button>
                                            
                                            <h1 class="text-white text-2xl font-bold mb-2">Training</h1>
                                            <p class="text-white text-sm opacity-90 mb-1">Under 16</p>
                                            <p class="text-white text-xs opacity-75 mb-6">AAA Esportiu (Xalest)</p>
                                            
                                            <!-- Info card -->
                                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 mb-6">
                                                <div class="flex justify-between text-white text-sm mb-3">
                                                    <div>
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <span class="text-xs">DATE</span>
                                                        </div>
                                                        <p class="font-semibold">6 Setjosember 2021</p>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            <span class="text-xs">TIME</span>
                                                        </div>
                                                        <p class="font-semibold">18:00 - 20:30</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Appearances section -->
                                            <div>
                                                <h3 class="text-white font-semibold mb-3">Appearances</h3>
                                                <div class="space-y-2">
                                                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-2 flex items-center justify-between">
                                                        <span class="text-white text-sm">Athletes</span>
                                                        <span class="text-white text-sm">12</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Bottom navigation -->
                                        <div class="absolute bottom-0 left-0 right-0 bg-black/40 backdrop-blur-md">
                                            <div class="flex justify-around py-3">
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-cyan-400">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phone 2 - Right (Invoices Screen) -->
                        <div class="absolute right-0 top-1/2 transform -translate-y-1/2" style="z-index: 25;">
                            <div class="bg-gradient-to-b from-gray-900 to-black rounded-[2.5rem] p-3 shadow-2xl" style="width: 280px;">
                                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-[2rem] overflow-hidden" style="aspect-ratio: 9/19.5;">
                                    <div class="relative w-full h-full">
                                        <!-- Status bar -->
                                        <div class="absolute top-0 left-0 right-0 px-6 py-3 flex justify-between items-center text-white text-xs">
                                            <span>9:41</span>
                                            <div class="flex items-center gap-1">
                                                <div class="w-4 h-3 border border-white rounded-sm"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="pt-16 px-6">
                                            <div class="flex justify-between items-center mb-6">
                                                <h1 class="text-white text-2xl font-bold">Invoices</h1>
                                                <button class="text-white">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <!-- Tabs -->
                                            <div class="flex gap-4 mb-6">
                                                <button class="px-4 py-2 bg-cyan-500 text-white rounded-lg text-sm font-semibold">
                                                    Invoices
                                                </button>
                                                <button class="px-4 py-2 text-gray-400 text-sm font-semibold">
                                                    Products
                                                </button>
                                            </div>
                                            
                                            <!-- Stats -->
                                            <div class="grid grid-cols-3 gap-4 mb-6">
                                                <div class="text-center">
                                                    <div class="text-3xl font-bold text-white mb-1">5</div>
                                                    <div class="text-xs text-cyan-400">Paid</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-3xl font-bold text-white mb-1">1</div>
                                                    <div class="text-xs text-orange-400">Pending</div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-3xl font-bold text-white mb-1">2</div>
                                                    <div class="text-xs text-yellow-400">Outstanding</div>
                                                </div>
                                            </div>
                                            
                                            <!-- Invoice list -->
                                            <div class="space-y-3">
                                                <div class="bg-gray-800/50 rounded-xl p-3">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <p class="text-purple-400 text-xs mb-1">Subscription • Nov/2022</p>
                                                            <p class="text-white text-sm font-semibold">€180.00</p>
                                                        </div>
                                                        <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                                            <span class="text-white text-xs">!</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="bg-gray-800/50 rounded-xl p-3">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <p class="text-purple-400 text-xs mb-1">Subscription • Oct/2023</p>
                                                            <p class="text-white text-sm font-semibold">€80.00</p>
                                                        </div>
                                                        <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                                            <span class="text-white text-xs">!</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="bg-gray-800/50 rounded-xl p-3">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <p class="text-green-400 text-xs mb-1">Registration Fee • 2022</p>
                                                            <p class="text-white text-sm font-semibold">€100.00</p>
                                                        </div>
                                                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="bg-gray-800/50 rounded-xl p-3">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <p class="text-purple-400 text-xs mb-1">Subscription • Sep/2022</p>
                                                            <p class="text-white text-sm font-semibold">€180.00</p>
                                                        </div>
                                                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Send Notification Button -->
                                            <button class="w-full mt-6 bg-gray-700/50 text-white py-3 px-4 rounded-xl flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                    </svg>
                                                    <span class="text-sm font-semibold">Send Notification</span>
                                                </div>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Bottom navigation -->
                                        <div class="absolute bottom-0 left-0 right-0 bg-black/40 backdrop-blur-md">
                                            <div class="flex justify-around py-3">
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-white/60">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="py-20 px-4 bg-white">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Comienza GRATIS y Empieza a Ganar
                </h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Únete a las escuelas de fútbol que ya gestionan sus equipos profesionalmente <span class="font-semibold">sin pagar nada</span> y además generan ingresos vendiendo productos
                </p>
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="inline-block px-10 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition duration-200 font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105">
                        Acceder al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-block px-10 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition duration-200 font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105">
                        Acceder si estás registrado
                    </a>
                @endauth
            </div>
        </section>

        <!-- Carousel de Escudos de Equipos -->
        @php
            $schools = \App\Models\SportsSchool::whereNotNull('logo')->where('logo', '!=', '')->get();
        @endphp
        
        @if($schools->count() > 0)
        <section class="py-16 px-4 bg-gray-50 overflow-hidden">
            <div class="max-w-full mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-12">
                    Clubes que Confían en VaedSaas
                </h2>
                
                <div class="carousel-wrapper">
                    <div class="carousel-track-wrapper">
                        <!-- First set of logos -->
                        @foreach($schools as $school)
                            <div class="carousel-slide">
                                <div class="bg-white rounded-2xl shadow-lg flex items-center justify-center p-6 transition-all duration-300 hover:scale-110 hover:shadow-2xl" style="width: 140px; height: 140px;">
                                    <img src="{{ asset('storage/' . $school->logo) }}" 
                                         alt="{{ $school->name }}" 
                                         title="{{ $school->name }}"
                                         class="w-full h-full object-contain" 
                                         onerror="this.parentElement.parentElement.style.display='none'">
                                </div>
                            </div>
                        @endforeach
                        <!-- Duplicate set for seamless loop -->
                        @foreach($schools as $school)
                            <div class="carousel-slide">
                                <div class="bg-white rounded-2xl shadow-lg flex items-center justify-center p-6 transition-all duration-300 hover:scale-110 hover:shadow-2xl" style="width: 140px; height: 140px;">
                                    <img src="{{ asset('storage/' . $school->logo) }}" 
                                         alt="{{ $school->name }}" 
                                         title="{{ $school->name }}"
                                         class="w-full h-full object-contain" 
                                         onerror="this.parentElement.parentElement.style.display='none'">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        
        <style>
            .carousel-wrapper {
                position: relative;
                width: 100%;
                overflow: hidden;
                margin: 0 auto;
            }
            
            .carousel-track-wrapper {
                display: flex;
                animation: scroll-logos 30s linear infinite;
                width: fit-content;
            }
            
            .carousel-track-wrapper:hover {
                animation-play-state: paused;
            }
            
            @keyframes scroll-logos {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-50%);
                }
            }
            
            .carousel-slide {
                flex: 0 0 auto;
                padding: 0 1.5rem;
            }
            
            @media (max-width: 640px) {
                .carousel-slide {
                    padding: 0 1rem;
                }
                .carousel-slide > div {
                    width: 100px !important;
                    height: 100px !important;
                }
            }
        </style>
        @endif

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">{{ config('app.name', 'Vaed-APP') }}</h3>
                        <p class="text-gray-400">
                            La plataforma GRATUITA para escuelas de fútbol. Gestiona y monetiza tu club deportivo
                        </p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Producto</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Funcionalidades</a></li>
                            <li><a href="#" class="hover:text-white transition">Precios</a></li>
                            <li><a href="#" class="hover:text-white transition">Actualizaciones</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Soporte</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Documentación</a></li>
                            <li><a href="#" class="hover:text-white transition">Ayuda</a></li>
                            <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                            <li><a href="#" class="hover:text-white transition">Términos</a></li>
                            <li><a href="#" class="hover:text-white transition">Cookies</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Vaed-APP') }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
