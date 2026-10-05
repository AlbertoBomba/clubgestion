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

        <title>{{ config('app.name', 'Vaed-APP') }} - Casos de Éxito & Historias Reales</title>
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}" />
        
        <!-- SEO Meta Tags -->
        <meta name="description" content="@yield('description', 'Descubre cómo clubes como el Club Deportivo Puebla han transformado su gestión, cuotas y convocatorias con VaedSaas.')">
        <meta name="keywords" content="@yield('keywords', 'casos de exito, cd puebla, vaedsaas resultados, gestion clubes futbol, historias de exito software deportivo')">
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

        <!-- HEADER / NAVIGATION -->
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
                        <a href="{{ route('roadmap') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Proyecto</a>
                        <a href="#puebla" class="text-sm font-semibold text-emerald-600 font-bold border-b-2 border-emerald-500 pb-1">Caso Destacado</a>
                        <a href="#mas-casos" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Otros Clubes</a>
                        <a href="#metricas" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Impacto</a>
                        <a href="#contacto" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Contacto</a>
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
                <a href="{{ route('roadmap') }}" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Proyecto</a>
                <a href="#puebla" class="block py-2 text-base font-semibold text-emerald-600 border-b border-slate-100">Caso Destacado</a>
                <a href="#mas-casos" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Otros Clubes</a>
                <a href="#metricas" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Impacto</a>
                <a href="#contacto" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Contacto</a>
                <div class="pt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full text-center py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </header>


        <!-- HERO HEADER -->
        <section class="pt-28 sm:pt-36 pb-16 bg-slate-950 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_20%,_rgba(16,185,129,0.15),_transparent_70%)]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-xs sm:text-sm mb-6 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    Experiencias Reales de Gestión
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight max-w-4xl mx-auto">
                    Casos de Éxito: Clubes que han transformado su <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">día a día.</span>
                </h1>

                <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-3xl mx-auto mt-6">
                    Descubre cómo entidades deportivas como el <strong class="text-emerald-400 font-bold">Club Deportivo Puebla</strong> han eliminado el caos administrativo, automatizado el cobro de cuotas y multiplicado sus ingresos con <strong class="text-white">vaed.es</strong>.
                </p>

                <!-- Summary Bar -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 max-w-4xl mx-auto">
                    <div class="bg-slate-900/80 border border-slate-800 p-4 rounded-2xl backdrop-blur-md">
                        <p class="text-2xl sm:text-3xl font-black text-emerald-400">+50</p>
                        <p class="text-xs text-slate-400 mt-1 font-semibold">Clubes Activos</p>
                    </div>
                    <div class="bg-slate-900/80 border border-slate-800 p-4 rounded-2xl backdrop-blur-md">
                        <p class="text-2xl sm:text-3xl font-black text-white">99%</p>
                        <p class="text-xs text-slate-400 mt-1 font-semibold">Efectividad en Cobros</p>
                    </div>
                    <div class="bg-slate-900/80 border border-slate-800 p-4 rounded-2xl backdrop-blur-md">
                        <p class="text-2xl sm:text-3xl font-black text-emerald-400">0 €</p>
                        <p class="text-xs text-slate-400 mt-1 font-semibold">Coste de Licencia</p>
                    </div>
                    <div class="bg-slate-900/80 border border-slate-800 p-4 rounded-2xl backdrop-blur-md">
                        <p class="text-2xl sm:text-3xl font-black text-white">+12h</p>
                        <p class="text-xs text-slate-400 mt-1 font-semibold">Ahorro Semanal Directiva</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- FEATURED CASE STUDY: CLUB DEPORTIVO PUEBLA -->
        <section id="puebla" class="py-16 sm:py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase bg-emerald-50 px-4 py-1.5 rounded-full border border-emerald-200">
                        Caso Destacado
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mt-4 tracking-tight">
                        El C.D. Puebla confía plenamente en vaed.es
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 mt-3">
                        Cómo un club con más de 250 jugadores pasó del papeleo manual y los chats masivos a una gestión 100% digitalizada.
                    </p>
                </div>

                <!-- Featured Story Card -->
                <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-10 lg:p-12 shadow-2xl border border-slate-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>

                    <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-center relative z-10">
                        
                        <!-- Left Media / Prototype Card -->
                        <div class="lg:col-span-6 space-y-4">
                            <div class="relative bg-slate-800 border border-slate-700/80 rounded-2xl overflow-hidden shadow-2xl p-2">
                                <!-- SUSTITUIR FOTO AQUÍ: Imagen principal del CD Puebla / Prototipo -->
                                <img src="{{ asset('images/public/prototipe-cdpuebla.png') }}" 
                                     alt="Club Deportivo Puebla usando vaed.es" 
                                     class="w-full h-80 sm:h-96 object-cover rounded-xl">
                                
                                <div class="absolute top-4 left-4 bg-slate-950/90 border border-slate-700 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-bold text-emerald-400">
                                    ✓ Cliente Activo vaed.es
                                </div>
                            </div>

                            <!-- Metrics Strip for Puebla -->
                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-slate-800/80 border border-slate-700/80 p-3 rounded-xl text-center">
                                    <p class="text-lg sm:text-xl font-extrabold text-emerald-400">+250</p>
                                    <p class="text-[11px] text-slate-400 font-semibold">Jugadores</p>
                                </div>
                                <div class="bg-slate-800/80 border border-slate-700/80 p-3 rounded-xl text-center">
                                    <p class="text-lg sm:text-xl font-extrabold text-white">100%</p>
                                    <p class="text-[11px] text-slate-400 font-semibold">Cuotas Digitales</p>
                                </div>
                                <div class="bg-slate-800/80 border border-slate-700/80 p-3 rounded-xl text-center">
                                    <p class="text-lg sm:text-xl font-extrabold text-emerald-400">+1.200 €</p>
                                    <p class="text-[11px] text-slate-400 font-semibold">Ingresos Merchandising</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Content Column -->
                        <div class="lg:col-span-6 space-y-6">
                            
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-black text-xl">
                                    CDP
                                </div>
                                <div>
                                    <h3 class="text-2xl font-extrabold text-white">Club Deportivo Puebla</h3>
                                    <p class="text-xs text-slate-400">Fútbol Base y Senior • Andalucía, España</p>
                                </div>
                            </div>

                            <!-- Before vs After -->
                            <div class="space-y-4 pt-2">
                                <div class="bg-slate-800/60 border border-slate-700/60 p-4 rounded-2xl space-y-1">
                                    <p class="text-xs font-bold text-red-400 uppercase tracking-wider">El Desafío Anterior</p>
                                    <p class="text-sm text-slate-300 leading-relaxed">
                                        Horas perdidas persiguiendo cuotas en efectivo, convocatorias caóticas por grupos de mensajes y sin una presencia web oficial donde ofrecer información de partidos y patrocinadores.
                                    </p>
                                </div>

                                <div class="bg-emerald-500/10 border border-emerald-500/30 p-4 rounded-2xl space-y-1">
                                    <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider">La Solución con vaed.es</p>
                                    <p class="text-sm text-slate-200 leading-relaxed">
                                        Automatización del cobro de cuotas por TPV virtual, web propia personalizada con el escudo del C.D. Puebla, convocatorias con un clic desde la App y venta de merchandising oficial que genera ingresos para el club.
                                    </p>
                                </div>
                            </div>

                            <!-- Testimonial Quote -->
                            <blockquote class="border-l-4 border-emerald-400 pl-4 py-1 italic text-slate-200 text-sm sm:text-base leading-relaxed">
                                "vaed.es ha transformado la gestión del C.D. Puebla. Los padres pagan las cuotas cómodamente desde el móvil, los entrenadores llevan las convocatorias al segundo."
                            </blockquote>

                            <div class="pt-2 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-white">Directiva del C.D. Puebla</p>
                                    <p class="text-xs text-slate-400">Gestión Deportivo-Educativa</p>
                                </div>

                                <a href="https://cdpuebla.es/club" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-emerald-400 hover:bg-emerald-300 transition shadow-lg shadow-emerald-400/20">
                                    Quiero algo así para mi club →
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </section>


        <!-- MORE SUCCESS STORIES GRID -->
        <section id="mas-casos" class="py-16 sm:py-24 bg-slate-100 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-200">
                        Comunidad en Crecimiento
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 tracking-tight">
                        Otros clubes que han digitalizado su estructura
                    </h2>
                    <p class="text-base text-slate-600 mt-2">
                        Escuelas de fútbol base y asociaciones deportivas que confían en las soluciones de VaedSaas.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    
                    <!-- Case Study 2: EF Sur -->
                    <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200 flex flex-col justify-between space-y-6 hover:-translate-y-1 transition duration-300">
                        <div class="space-y-4">
                            <!-- SUSTITUIR FOTO AQUÍ: Foto o logo del club 2 -->
                            <div class="h-44 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden relative">
                                <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" 
                                     alt="Escuela de Fútbol Sur" 
                                     class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 bg-slate-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-md backdrop-blur-md">
                                    Fútbol Base
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900">Escuela de Fútbol Sur</h3>
                            <p class="text-xs text-slate-500 font-medium">18 Equipos • 320 Alumnos</p>

                            <p class="text-sm text-slate-600 leading-relaxed">
                                "Eliminamos las listas de papel en las convocatorias y conseguimos que el 98% de los pagos de las cuotas de la temporada se completaran antes de comenzar las competiciones."
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-emerald-600">✓ 0% Impagados</span>
                            <span class="text-slate-400 font-semibold">Madrid</span>
                        </div>
                    </div>

                    <!-- Case Study 3: Sporting San José -->
                    <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200 flex flex-col justify-between space-y-6 hover:-translate-y-1 transition duration-300">
                        <div class="space-y-4">
                            <!-- SUSTITUIR FOTO AQUÍ: Foto o logo del club 3 -->
                            <div class="h-44 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden relative">
                                <img src="{{ asset('images/public/capturapc.jpg') }}" 
                                     alt="Sporting San José" 
                                     class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 bg-slate-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-md backdrop-blur-md">
                                    Web & Torneos
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900">Sporting San José C.F.</h3>
                            <p class="text-xs text-slate-500 font-medium">12 Equipos • Torneo Anual</p>

                            <p class="text-sm text-slate-600 leading-relaxed">
                                "Lanzamos nuestra web propia con VaedSaas en menos de 24 horas y automatizamos el torneo de verano con clasificaciones y goleadores accesibles para toda la afición."
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-emerald-600">✓ +30% Visibilidad</span>
                            <span class="text-slate-400 font-semibold">Comunidad Valenciana</span>
                        </div>
                    </div>

                    <!-- Case Study 4: Atlético Norte -->
                    <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-200 flex flex-col justify-between space-y-6 hover:-translate-y-1 transition duration-300">
                        <div class="space-y-4">
                            <!-- SUSTITUIR FOTO AQUÍ: Foto o logo del club 4 -->
                            <div class="h-44 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden relative">
                                <img src="{{ asset('images/public/capturaappmovil.jpg') }}" 
                                     alt="Atlético Norte" 
                                     class="w-full h-full object-cover object-top">
                                <span class="absolute top-3 left-3 bg-slate-900/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-md backdrop-blur-md">
                                    App Móvil
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900">Atlético Norte C.D.</h3>
                            <p class="text-xs text-slate-500 font-medium">8 Equipos • Cantera</p>

                            <p class="text-sm text-slate-600 leading-relaxed">
                                "Los entrenadores ahorran horas cada semana organizando los entrenamientos y citaciones. La comunicación con las familias es rápida, segura y centralizada."
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-emerald-600">✓ Convocatorias en 1 clic</span>
                            <span class="text-slate-400 font-semibold">Galicia</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>


        <!-- METRICS & IMPACT SECTION -->
        <section id="metricas" class="py-16 sm:py-24 bg-slate-900 text-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase bg-emerald-500/10 px-4 py-1.5 rounded-full border border-emerald-500/30">
                        Resultados Globales
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mt-4 tracking-tight">
                        El impacto real de VaedSaas en los clubes
                    </h2>
                    <p class="text-base text-slate-300 mt-2">
                        Promedio de mejoras conseguidas por los clubes asociados tras la implantación.
                    </p>
                </div>

                <div class="grid sm:grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="bg-slate-800/80 border border-slate-700/80 p-8 rounded-3xl text-center space-y-2">
                        <p class="text-4xl sm:text-5xl font-black text-emerald-400">-90%</p>
                        <h4 class="font-bold text-white text-base">Tiempo en Cobros</h4>
                        <p class="text-xs text-slate-400">Automatización completa de recibos y pasarela de pago.</p>
                    </div>

                    {{-- <div class="bg-slate-800/80 border border-slate-700/80 p-8 rounded-3xl text-center space-y-2">
                        <p class="text-4xl sm:text-5xl font-black text-white">100%</p>
                        <h4 class="font-bold text-white text-base">Gratis para el Club</h4>
                        <p class="text-xs text-slate-400">Sin cuotas de mantenimiento ni costes ocultos.</p>
                    </div> --}}

                    <div class="bg-slate-800/80 border border-slate-700/80 p-8 rounded-3xl text-center space-y-2">
                        <p class="text-4xl sm:text-5xl font-black text-emerald-400">5-10%</p>
                        <h4 class="font-bold text-white text-base">Ingreso por Ropa</h4>
                        <p class="text-xs text-slate-400">Comisión directa devuelta al saldo del club por cada venta.</p>
                    </div>

                    <div class="bg-slate-800/80 border border-slate-700/80 p-8 rounded-3xl text-center space-y-2">
                        <p class="text-4xl sm:text-5xl font-black text-white">24 h</p>
                        <h4 class="font-bold text-white text-base">Puesta en Marcha</h4>
                        <p class="text-xs text-slate-400">Configuración e inicio del club de forma casi inmediata.</p>
                    </div>

                </div>

            </div>
        </section>


       


        <!-- Carousel de Escudos de Equipos (Dinámico Blade) -->
        @php
            $schools = \App\Models\SportsSchool::whereNotNull('logo')->where('logo', '!=', '')->get();
        @endphp
        
        @if($schools->count() > 0)
        <section class="py-16 bg-slate-100 overflow-hidden border-t border-b border-slate-200">
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
        </section>
        @endif


        <!-- FOOTER -->
        <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-800 text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                    <div class="col-span-2 md:col-span-1">
                        <span class="text-xl font-extrabold text-white">Vaed<span class="text-emerald-500">Saas</span></span>
                        <p class="mt-3 text-xs text-slate-400 leading-relaxed">
                            Plataforma  para la gestión y monetización de clubes y escuelas de fútbol amateur.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navegación</h4>
                        <ul class="space-y-2 text-xs">
                            <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Inicio</a></li>
                            <li><a href="{{ route('roadmap') }}" class="hover:text-emerald-400 transition">Proyecto</a></li>
                            <li><a href="#puebla" class="hover:text-emerald-400 transition">C.D. Puebla</a></li>
                            <li><a href="#metricas" class="hover:text-emerald-400 transition">Impacto</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Soporte</h4>
                        <ul class="space-y-2 text-xs">
                            <li><a href="#contacto" class="hover:text-emerald-400 transition">Contacto Directo</a></li>
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
        <a href="https://wa.me/34600646123?text=Hola,%20quisiera%20saber%20cómo%20el%20Club%20Deportivo%20Puebla%20usa%20VaedSaas" 
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