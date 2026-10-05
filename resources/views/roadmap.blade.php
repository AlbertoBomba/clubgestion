<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('images/favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('images/favicon/ms-icon-144x144.png') }}">
        <meta name="theme-color" content="#10b981">

        <title>{{ config('app.name', 'Vaed-APP') }} - Hoja de Ruta & Próximos Lanzamientos</title>
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}" />
        
        <!-- SEO Meta Tags -->
        <meta name="description" content="@yield('description', 'Conoce la hoja de ruta y desarrollo de VaedSaas. Módulos operativos y próximas funcionalidades para clubes de fútbol amateur.')">
        <meta name="keywords" content="@yield('keywords', 'roadmap, hoja de ruta, desarrollo vaedsaas, gestión deportiva, futbol amateur, caracteristicas software futbol')">
        <meta name="robots" content="index, follow">
        <meta name="author" content="Vaed">

        <!-- Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif

        <style>
            body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }

            /* Animations */
            @keyframes floatSlow {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .animate-float-slow { animation: floatSlow 6s ease-in-out infinite; }

            /* Navbar Styles */
            .vs-nav {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 100;
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
                transition: all 0.3s ease;
            }
            .vs-nav.scrolled {
                box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
                background: rgba(255, 255, 255, 0.95);
            }

            /* Infinite Marquee for Club Logos */
            @keyframes marquee {
                0% { transform: translateX(0%); }
                100% { transform: translateX(-50%); }
            }
            .animate-marquee {
                display: flex;
                width: max-content;
                animation: marquee 35s linear infinite;
            }
            .animate-marquee:hover { animation-play-state: paused; }
        </style>
    </head>

    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

        <!-- Header / Navigation -->
        <header class="vs-nav" id="vsNav">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 p-1.5 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('images/logos/logo_vaed.png') }}" alt="{{ config('app.name', 'Vaed-APP') }}" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900">Vaed<span class="text-emerald-500">Saas</span></span>
                    </a>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition" id="navToggle" aria-label="Abrir menú">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Nav Links -->
                    <nav class="hidden md:flex items-center gap-8" id="navLinksDesktop">
                        <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Inicio</a>
                        <a href="{{ route('exito') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Casos de Éxito</a>
                        <a href="#roadmap" class="text-sm font-semibold text-emerald-600 font-bold border-b-2 border-emerald-500 pb-1">Roadmap</a>
                        {{-- <a href="#proximos" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">En Desarrollo</a> --}}
                        
                    </nav>

                    <!-- Auth Actions -->
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-emerald-600 shadow-md hover:shadow-emerald-500/20 transition-all duration-300 uppercase tracking-wider">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-emerald-600 shadow-md hover:shadow-emerald-500/20 transition-all duration-300 uppercase tracking-wider">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Overlay -->
            <div class="md:hidden hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3" id="navLinksMobile">
                <a href="{{ route('home') }}" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Inicio</a>
                <a href="{{ route('exito') }}" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Casos de éxito   </a>
                
                <a href="#roadmap" class="block py-2 text-base font-semibold text-emerald-600 border-b border-slate-100">Roadmap</a>
                {{-- <a href="#proximos" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">En Desarrollo</a> --}}
                
                <div class="pt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full text-center py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </header>


        <!-- HERO ROADMAP HEADER -->
        <section class="pt-28 sm:pt-36 pb-16 bg-slate-950 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_20%,_rgba(16,185,129,0.15),_transparent_70%)]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-xs sm:text-sm mb-6 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    ¿Porque somos diferentes?
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight max-w-4xl mx-auto">
                    Proyecto con <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Nombre y Apellidos</span>
                </h1>

                <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto mt-6">
                    Somos más que una aplicación comercial. Esta aplicación crece con vosotros, y se adapta a las necesidades de vuestro club en cada etapa de su desarrollo.
                </p>
                <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto mt-6">
                    Proyecto desarrollado por Alberto Martín Bomba, entrenador y desarrollador de soluciones para la gestión con más de 23 años de experiencia. 
                </p>
                 <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto mt-6">
                    "Solo trabajando desde dentro se conocen realmente las necesidades del club."
                </p>

                <!-- Barra de Progreso Global del Proyecto -->
                <div class="mt-12 max-w-2xl mx-auto bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-2xl">
                    <div class="flex items-center justify-between text-xs sm:text-sm font-bold mb-3">
                        <span class="text-slate-300">Progreso del Sistema Integral</span>
                        <span class="text-emerald-400">67% Completado (6 / 9 Módulos)</span>
                    </div>
                    <div class="w-full bg-slate-800 h-3.5 rounded-full overflow-hidden p-0.5 border border-slate-700">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-1000" style="width: 67%;"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-6 pt-4 border-t border-slate-800/80 text-center">
                        <div>
                            <p class="text-2xl font-black text-white">6</p>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5">Módulos Operativos (✓)</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-amber-400">3</p>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5">En Desarrollo con Fecha</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- TIMELINE ROADMAP SECTION -->
        <section id="roadmap" class="py-16 sm:py-24 bg-white relative">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-16">
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase bg-emerald-50 px-4 py-1.5 rounded-full border border-emerald-200">
                        Funcionalidades
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 tracking-tight">
                        Estado Actual y Futuras Entregas
                    </h2>
                </div>

                <!-- Vertical Timeline Container -->
                <div class="relative border-l-2 border-slate-200 ml-4 sm:ml-32 space-y-12">

                    <!-- ITEM 1: Panel Principal -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <!-- Date Marker Side (Desktop) -->
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100/80 px-2.5 py-1 rounded-md">Disponible</span>
                        </div>

                        <!-- Timeline Dot -->
                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-md shadow-emerald-500/30 ring-4 ring-white">
                            ✓
                        </div>

                        <!-- Content Card -->
                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2">
                                <h3 class="text-xl font-extrabold text-slate-900">1. Panel Principal de Control</h3>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 border border-emerald-500/20 text-xs font-bold rounded-full">
                                    ✓ Operativo
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Dashboard centralizado con estadísticas generales del club en tiempo real: métricas de socios, ingresos, resúmenes deportivos y estado global.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 2: Gestión Escuela -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100/80 px-2.5 py-1 rounded-md">Disponible</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-md shadow-emerald-500/30 ring-4 ring-white">
                            ✓
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-3">
                                <h3 class="text-xl font-extrabold text-slate-900">2. Gestión Integral de Escuela</h3>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 border border-emerald-500/20 text-xs font-bold rounded-full">
                                    ✓ Operativo
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                Administración completa de la estructura deportiva y académica del club dividida en submódulos:
                            </p>
                            
                            <!-- Sub-items 2.1, 2.2, 2.3 -->
                            <div class="grid sm:grid-cols-3 gap-3 pt-2 border-t border-slate-200/80">
                                <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="text-emerald-500">✓</span> 2.1. Gestión Temporada
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="text-emerald-500">✓</span> 2.2. Gestión Jugadores
                                </div>
                                <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="text-emerald-500">✓</span> 2.3. Gestión Equipos
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ITEM 3: Torneos -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100/80 px-2.5 py-1 rounded-md">Disponible</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-md shadow-emerald-500/30 ring-4 ring-white">
                            ✓
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2">
                                <h3 class="text-xl font-extrabold text-slate-900">3. Torneos & Web Pública de Competición</h3>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 border border-emerald-500/20 text-xs font-bold rounded-full">
                                    ✓ Operativo
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Administración automatizada de ligas y campeonatos locales con tablas de clasificación automática, goleadores y portal público interactivo para la afición.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 4: Web Personalizada -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100/80 px-2.5 py-1 rounded-md">Disponible</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-md shadow-emerald-500/30 ring-4 ring-white">
                            ✓
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2">
                                <h3 class="text-xl font-extrabold text-slate-900">4. Web Propia Exclusiva por Club</h3>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 border border-emerald-500/20 text-xs font-bold rounded-full">
                                    ✓ Operativo
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Generación automática del sitio web oficial con dominio propio, portal de noticias, alta de jugadores y escaparate corporativo.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 5: Partidos y Convocatorias -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100/80 px-2.5 py-1 rounded-md">Disponible</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-md shadow-emerald-500/30 ring-4 ring-white">
                            ✓
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2">
                                <h3 class="text-xl font-extrabold text-slate-900">5. Partidos & Gestor de Convocatorias</h3>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 border border-emerald-500/20 text-xs font-bold rounded-full">
                                    ✓ Operativo
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Notificación de citaciones oficiales para partidos con confirmación o declinación de asistencia en tiempo real por parte del jugador/familia.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 6: Tesorería -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100/80 px-2.5 py-1 rounded-md">Disponible</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-md shadow-emerald-500/30 ring-4 ring-white">
                            ✓
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2">
                                <h3 class="text-xl font-extrabold text-slate-900">6. Tesorería, Cobros e Impagos</h3>
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 border border-emerald-500/20 text-xs font-bold rounded-full">
                                    ✓ Operativo
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Control presupuestario, cobro de cuotas automatizadas, seguimiento de morosos, integración de TPV Virtual seguro y emisión de remesas.
                            </p>
                        </div>
                    </div>


                    <!-- ITEM 7: Entrenadores & Pizarra Táctica (Nov 2026) -->
                    <div id="proximos" class="relative pl-8 sm:pl-10 group pt-6">
                        <div class="hidden sm:block absolute -left-36 top-8 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-100 px-2.5 py-1 rounded-md">Nov 2026</span>
                        </div>

                        <div class="absolute -left-[17px] top-8 w-8 h-8 rounded-full bg-amber-400 text-slate-950 font-black text-sm flex items-center justify-center shadow-md ring-4 ring-white">
                            ⏳
                        </div>

                        <div class="bg-slate-900 text-white border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
                            
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2 relative z-10">
                                <h3 class="text-xl font-extrabold text-white">7. Módulo Entrenadores & Pizarra Táctica</h3>
                                <span class="px-3 py-1 bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold rounded-full">
                                    A partir de Noviembre 2026
                                </span>
                            </div>
                            <p class="text-slate-300 text-sm leading-relaxed relative z-10">
                                Preparación digital de sesiones de entrenamiento, catálogo de ejercicios técnicos, biblioteca táctica e interactiva con pizarra digital para entrenadores.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 7: Entrenadores & Pizarra Táctica (Nov 2026) -->
                    <div id="proximos" class="relative pl-8 sm:pl-10 group pt-6">
                        <div class="hidden sm:block absolute -left-36 top-8 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-100 px-2.5 py-1 rounded-md">Nov 2026</span>
                        </div>

                        <div class="absolute -left-[17px] top-8 w-8 h-8 rounded-full bg-amber-400 text-slate-950 font-black text-sm flex items-center justify-center shadow-md ring-4 ring-white">
                            ⏳
                        </div>

                        <div class="bg-slate-900 text-white border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
                            
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2 relative z-10">
                                <h3 class="text-xl font-extrabold text-white">8. Tienda web para el club</h3>
                                <span class="px-3 py-1 bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold rounded-full">
                                    A partir de Noviembre 2026
                                </span>
                            </div>
                            <p class="text-slate-300 text-sm leading-relaxed relative z-10">
                                Plataforma de comercio electrónico integrada para que el club pueda vender productos oficiales, entradas y servicios a sus socios y aficionados.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 8: Gestión de Campos e Instalaciones (Dic 2026) -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-100 px-2.5 py-1 rounded-md">Dic 2026</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-amber-400 text-slate-950 font-black text-sm flex items-center justify-center shadow-md ring-4 ring-white">
                            ⏳
                        </div>

                        <div class="bg-slate-900 text-white border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>

                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2 relative z-10">
                                <h3 class="text-xl font-extrabold text-white">9. Gestión de Campos e Instalaciones</h3>
                                <span class="px-3 py-1 bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold rounded-full">
                                    A partir de Diciembre 2026
                                </span>
                            </div>
                            <p class="text-slate-300 text-sm leading-relaxed relative z-10">
                                Cuadrante de reservas de terreno de juego, distribución de vestuarios, asignación de horarios de entrenamiento y gestión del mantenimiento de las sedes.
                            </p>
                        </div>
                    </div>

                    <!-- ITEM 9: App iOS y Android (Enero 2027) -->
                    <div class="relative pl-8 sm:pl-10 group">
                        <div class="hidden sm:block absolute -left-36 top-1.5 text-right w-28">
                            <span class="text-xs font-bold uppercase tracking-wider text-cyan-700 bg-cyan-100 px-2.5 py-1 rounded-md">Ene 2027</span>
                        </div>

                        <div class="absolute -left-[17px] top-1.5 w-8 h-8 rounded-full bg-cyan-400 text-slate-950 font-black text-sm flex items-center justify-center shadow-md ring-4 ring-white">
                            📲
                        </div>

                        <div class="bg-slate-900 text-white border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl"></div>

                            <div class="flex items-center justify-between gap-4 flex-wrap mb-2 relative z-10">
                                <h3 class="text-xl font-extrabold text-white">10. Aplicaciones Nativas iOS & Android</h3>
                                <span class="px-3 py-1 bg-cyan-400/20 text-cyan-300 border border-cyan-400/30 text-xs font-bold rounded-full">
                                    A partir de Enero 2027
                                </span>
                            </div>
                            <p class="text-slate-300 text-sm leading-relaxed relative z-10">
                                Publicación de apps nativas en App Store y Google Play para jugadores, familias y entrenadores con notificaciones push instantáneas.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>


        <!-- SECTION CONTACTO -->
        {{-- <section id="contacto" class="py-16 sm:py-24 bg-white relative border-t border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        ¿Quieres solicitar una funcionalidad o probar el sistema?
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 mt-3">
                        Completa el formulario y responderemos tus dudas sobre el Roadmap.
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-xl">
                    <form class="space-y-6" x-data="{ submitting: false }" @submit.prevent="submitting = true; setTimeout(() => { alert('Gracias por tu mensaje. Te contactaremos pronto.'); submitting = false; $el.reset(); }, 1000)">
                        
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-2">Nombre Completo *</label>
                                <input type="text" id="name" name="name" required class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-slate-900 text-sm" placeholder="Juan Pérez">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase mb-2">Correo Electrónico *</label>
                                <input type="email" id="email" name="email" required class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-slate-900 text-sm" placeholder="juan@escuelafutbol.com">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase mb-2">Teléfono</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-slate-900 text-sm" placeholder="+34 600 000 000">
                            </div>

                            <div>
                                <label for="club" class="block text-xs font-bold text-slate-700 uppercase mb-2">Nombre del Club / Escuela</label>
                                <input type="text" id="club" name="club" class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-slate-900 text-sm" placeholder="CD Mi Escuela FC">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-bold text-slate-700 uppercase mb-2">Mensaje *</label>
                            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-slate-900 text-sm" placeholder="Escríbenos cualquier sugerencia o consulta sobre la Hoja de Ruta..."></textarea>
                        </div>

                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="privacy" name="privacy" required class="mt-1 w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                            <label for="privacy" class="text-xs text-slate-600">Acepto la política de privacidad y el tratamiento de mis datos personales. *</label>
                        </div>

                        <button type="submit" :disabled="submitting" class="w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold py-4 px-8 rounded-xl transition duration-300 shadow-lg shadow-emerald-500/25 disabled:opacity-50">
                            <span x-show="!submitting">Enviar Consulta</span>
                            <span x-show="submitting" x-cloak>Enviando mensaje...</span>
                        </button>
                    </form>
                </div>

            </div>
        </section> --}}


        <!-- Carousel de Escudos de Equipos (Dinámico Blade) -->
        @php
            $schools = \App\Models\SportsSchool::whereNotNull('logo')->where('logo', '!=', '')->get();
        @endphp
        
        @if($schools->count() > 0)
        {{-- <section class="py-16 bg-slate-100 overflow-hidden border-t border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 mb-8 text-center">
                <h3 class="text-xl font-bold text-slate-800 tracking-tight">Clubes que confían en VaedSaas</h3>
            </div>
            
            <div class="relative w-full overflow-hidden">
                <div class="animate-marquee hover:[animation-play-state:paused] flex items-center gap-8">
                    @foreach($schools as $school)
                        <div class="flex-none">
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center p-4 w-28 h-28 hover:scale-105 transition">
                                <img src="{{ asset('storage/' . $school->logo) }}" 
                                     alt="{{ $school->name }}" 
                                     title="{{ $school->name }}"
                                     class="w-full h-full object-contain" 
                                     onerror="this.parentElement.parentElement.style.display='none'">
                            </div>
                        </div>
                    @endforeach

                    <!-- Repetición para Infinite Scroll continuo -->
                    @foreach($schools as $school)
                        <div class="flex-none">
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center p-4 w-28 h-28 hover:scale-105 transition">
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
        </section> --}}
        @endif


        <!-- FOOTER -->
        <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-800 text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                    <div class="col-span-2 md:col-span-1">
                        <span class="text-xl font-extrabold text-white">Vaed<span class="text-emerald-500">Saas</span></span>
                        <p class="mt-3 text-xs text-slate-400 leading-relaxed">
                            Plataforma para la gestión y monetización de clubes y escuelas de fútbol amateur.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navegación</h4>
                        <ul class="space-y-2 text-xs">
                            <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Inicio</a></li>
                            <li><a href="{{ route('exito') }}" class="hover:text-emerald-400 transition">Casos de Éxito</a></li>
                            <li><a href="#roadmap" class="hover:text-emerald-400 transition">Roadmap</a></li>
                            <li><a href="#proximos" class="hover:text-emerald-400 transition">En Desarrollo</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Soporte</h4>
                        <ul class="space-y-2 text-xs">
                            
                            <li><a href="https://wa.me/34600646123" target="_blank" class="hover:text-emerald-400 transition">Atención por WhatsApp</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Legal</h4>
                        <ul class="space-y-2 text-xs">
                            <li><a href="#" class="hover:text-emerald-400 transition">Privacidad</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition">Términos de Servicio</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-slate-900 pt-8 text-center text-xs text-slate-500">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Vaed-APP') }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>


        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/34600646123?text=Hola,%20me%20gustaría%20obtener%20más%20información%20sobre%20VaedSaas" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-400 text-slate-950 p-4 rounded-full shadow-2xl transition duration-300 hover:scale-110 flex items-center justify-center group"
           aria-label="Contactar por WhatsApp">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span class="absolute right-full mr-3 bg-slate-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap shadow-xl">
                ¡Háblanos por WhatsApp!
            </span>
        </a>


        <!-- Cookie Consent Component -->
        <x-cookie-consent />


        <!-- SCRIPTS DE COMPORTAMIENTO -->
        <script>
            (function () {
                // Navbar scroll shadow
                var nav = document.getElementById('vsNav');
                if (nav) {
                    window.addEventListener('scroll', function() {
                        nav.classList.toggle('scrolled', window.scrollY > 20);
                    });
                }

                // Navbar Mobile Menu Toggle
                var toggle = document.getElementById('navToggle');
                var mobileMenu = document.getElementById('navLinksMobile');
                if (toggle && mobileMenu) {
                    toggle.addEventListener('click', function() {
                        mobileMenu.classList.toggle('hidden');
                    });
                }
            })();
        </script>
    </body>
</html>