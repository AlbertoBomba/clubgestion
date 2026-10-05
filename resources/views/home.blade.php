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

        <title>{{ config('app.name', 'Vaed-APP') }} - Gestión deportivo educativa del fútbol amateur</title>
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}" />
        
        <!-- SEO Meta Tags -->
        <meta name="description" content="@yield('description', 'Gestión deportiva educativa gratuita para clubes y escuelas de fútbol amateur. Organiza entrenamientos, eventos y comunicación interna de tu equipo fácilmente.')">
        <meta name="keywords" content="@yield('keywords', 'gestión deportiva, fútbol amateur, clubes de fútbol, escuelas de fútbol, software gratuito, comunicación interna, organización de equipos, entrenamientos de fútbol, eventos deportivos')">
        <meta name="robots" content="index, follow">
        <meta name="author" content="Vaed">

        <!-- Fonts: Plus Jakarta Sans & Inter -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Alpine.js (para la reactividad del formulario) -->
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

            /* Animations & Effects */
            @keyframes floatSlow {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-12px) rotate(1deg); }
            }
            @keyframes floatDelayed {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(-1deg); }
            }
            .animate-float-slow { animation: floatSlow 6s ease-in-out infinite; }
            .animate-float-delayed { animation: floatDelayed 7s ease-in-out infinite 1s; }

            /* Hero Slider CSS Logic */
            html, body { overflow-x: hidden; }
            .hero-slider-wrapper { position: relative; overflow: hidden; width: 100%; }
            .hero-slides-track {
                display: flex;
                width: 100%;
                transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
                will-change: transform;
            }
            .hero-slide {
                width: 100%;
                min-width: 100%;
                flex-shrink: 0;
                position: relative;
                box-sizing: border-box;
                min-height: 100vh;
                display: flex;
                align-items: center;
                padding-top: 70px;
            }
            .hero-slide-bg { position: absolute; inset: 0; z-index: 0; }
            .hero-slider-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 40;
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                color: white;
                width: 48px;
                height: 48px;
                border-radius: 9999px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.25s ease;
            }
            .hero-slider-btn:hover {
                background: rgba(16, 185, 129, 0.9);
                border-color: rgba(16, 185, 129, 1);
                transform: translateY(-50%) scale(1.1);
            }
            .hero-slider-btn.prev { left: 24px; }
            .hero-slider-btn.next { right: 24px; }
            .hero-slider-dots {
                position: absolute;
                bottom: 24px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 8px;
                z-index: 40;
                background: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(8px);
                padding: 6px 12px;
                border-radius: 9999px;
                border: 1px solid rgba(255,255,255,0.1);
            }
            .hero-dot {
                width: 8px;
                height: 8px;
                border-radius: 9999px;
                background: rgba(255, 255, 255, 0.35);
                cursor: pointer;
                transition: all 0.3s ease;
                border: none;
                padding: 0;
            }
            .hero-dot.active {
                background: #10b981;
                width: 28px;
            }

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
                        <a href="{{route('roadmap')}}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Proyecto</a>
                        <a href="{{route('exito')}}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Casos Éxito</a>
                        <a href="#torneos" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Torneos</a>
                        <a href="#web-club" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Web para Clubes</a>
                        
                        {{-- <a href="#contacto" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Contacto</a> --}}
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
                
                <a href="{{route('roadmap')}}" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Proyecto</a>
                <a href="{{route('exito')}}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Casos de exito</a>
                
                {{-- <a href="#contacto" class="block py-2 text-base font-semibold text-slate-700 border-b border-slate-100">Contacto</a> --}}
                <div class="pt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block w-full text-center py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center py-3 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- HERO FULLSCREEN SLIDER -->
        <div class="hero-slider-wrapper " id="heroSlider">
            <div class="hero-slides-track" id="heroSlidesTrack">

                <!-- Slide 1: Gestión Deportiva Integrada -->
                <div class="hero-slide relative overflow-hidden  text-white">
                    <!-- Background Video & Overlay -->
                    <div class="hero-slide-bg">
                        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover  scale-105">
                            <source src="{{ asset('images/public/0_Goalkeeper_Soccer_Ball_1920x1080.mp4') }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/35 to-slate-950/10"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,_rgba(16,185,129,0.15),_transparent_60%)]"></div>
                    </div>

                    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 w-full">
                        <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center min-h-[calc(100vh-12rem)]">
                            
                            <!-- Left Content Column -->
                            <div class="lg:col-span-7 space-y-6 sm:space-y-8 text-center lg:text-left">
                                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-semibold text-xs sm:text-sm backdrop-blur-md">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                    Gestión Deportiva & Educativa 
                                </div>

                                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-[1.15]">
                                    La solución integral para profesionalizar <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">tu club amateur.</span>
                                </h1>

                                <p class="text-base sm:text-xl text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-normal">
                                    Centraliza entrenamientos, convocatorias, cuotas y comunicación interna en una sola plataforma diseñada para dirigentes, entrenadores y familias.
                                </p>

                                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                                    <a href="#contacto" class="w-full sm:w-auto px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-950 rounded-2xl font-bold text-base transition-all duration-300 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 text-center">
                                        ¿Qué es VaedSaas?
                                    </a>
                                    <a href="#soluciones" class="w-full sm:w-auto px-8 py-4 bg-slate-900/80 hover:bg-slate-800 text-white border border-slate-700/80 rounded-2xl font-semibold text-base transition-all duration-300 backdrop-blur-md text-center">
                                        Explorar Funciones
                                    </a>
                                </div>
                            </div>

                            <!-- Right Visual Mockups Column -->
                            <div class="lg:col-span-5 relative hidden lg:block">
                                <div class="relative mx-auto w-full max-w-md h-[520px]">
                                    
                                    <!-- Desktop Monitor Frame -->
                                    <div class="absolute bottom-0 left-0 w-full bg-slate-900 border border-slate-700/60 rounded-2xl p-2.5 shadow-2xl animate-float-slow backdrop-blur-xl">
                                        <div class="bg-slate-950 rounded-xl overflow-hidden border border-slate-800 aspect-[16/10]">
                                            <img src="{{ asset('images/public/capturapc.jpg') }}" alt="Captura de la app en escritorio" class="w-full h-full object-cover">
                                        </div>
                                    </div>

                                    <!-- Phone Frame Overlay -->
                                    <div class="absolute top-0 right-2 w-[220px] bg-slate-900 border-2 border-slate-700/80 rounded-[2.5rem] p-2 shadow-2xl animate-float-delayed z-20">
                                        <div class="bg-black rounded-[2.2rem] overflow-hidden aspect-[9/19.5]">
                                            <img src="{{ asset('images/public/capturaappmovil.jpg') }}" alt="Captura app móvil" class="w-full h-full object-cover">
                                        </div>
                                    </div>

                                    <!-- Floating Interactive Badge 1 -->
                                    <div class="absolute top-12 -left-6 z-30 bg-slate-900/90 border border-slate-700/80 backdrop-blur-xl rounded-2xl p-4 shadow-2xl text-white w-52 animate-bounce-slow">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-lg">💳</div>
                                            <div>
                                                <p class="text-xs text-slate-400 font-semibold">Cobros Automatizados</p>
                                                <p class="text-sm font-bold text-emerald-400">Cuotas al día</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Floating Interactive Badge 2 -->
                                    <div class="absolute -bottom-4 right-8 z-30 bg-slate-900/90 border border-slate-700/80 backdrop-blur-xl rounded-2xl p-3.5 shadow-2xl text-white flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full bg-emerald-400 animate-ping"></div>
                                        <span class="text-xs font-bold tracking-wide">100% Sincronizado en la Nube</span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- /Slide 1 -->

            </div><!-- /hero-slides-track -->

            <!-- Slider Controls -->
            <button class="hero-slider-btn prev hidden md:flex" id="heroPrevBtn" aria-label="Anterior">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="hero-slider-btn next hidden md:flex" id="heroNextBtn" aria-label="Siguiente">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Slider Dots -->
            <div class="hero-slider-dots">
                <button class="hero-dot active" data-index="0" aria-label="Diapositiva 1"></button>
                <button class="hero-dot" data-index="1" aria-label="Diapositiva 2"></button>
            </div>
        </div><!-- /hero-slider-wrapper -->


        <!-- SECTION 1: Herramientas de Gestión de Cobro de Cuotas -->
        <section id="soluciones" class="py-16 sm:py-24 bg-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase bg-emerald-50 px-4 py-1.5 rounded-full border border-emerald-200">
                        Gestión Financiera Sencilla
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mt-4 tracking-tight">
                        La gestión deportivo educativa del fútbol amateur, al alcance de todos.
                    </h2>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Visual Mockup & Graph Card -->
                    <div class="relative">
                        <div class="relative bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-800 text-white overflow-hidden">
                            <!-- Background Accent Glow -->
                            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
                            
                            <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
                                <div>
                                    <h3 class="font-bold text-lg text-white">Resumen de Cuotas Recaudadas</h3>
                                    <p class="text-xs text-slate-400">Automatización de pagos y morosos</p>
                                </div>
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-lg border border-emerald-500/30">
                                    En regla +94%
                                </span>
                            </div>

                            <!-- Interactive SVG Chart Mockup -->
                            <div class="relative h-48 sm:h-60 w-full mb-6">
                                <svg class="w-full h-full" viewBox="0 0 500 200" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#10b981" stop-opacity="0.4"/>
                                            <stop offset="100%" stop-color="#10b981" stop-opacity="0"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M10,160 Q120,80 240,110 T490,40 L490,200 L10,200 Z" fill="url(#chartGradient)" />
                                    <path d="M10,160 Q120,80 240,110 T490,40" fill="none" stroke="#10b981" stroke-width="4" stroke-linecap="round"/>
                                    <circle cx="360" cy="72" r="6" fill="#ffffff" stroke="#10b981" stroke-width="3"/>
                                </svg>

                                <!-- Floating Value Tag -->
                                <div class="absolute top-8 left-[65%] transform -translate-x-1/2 bg-slate-800 border border-slate-700 text-white rounded-xl px-3.5 py-1.5 shadow-xl text-center">
                                    <p class="text-xs font-bold text-emerald-400">1.265 € Recaudados</p>
                                    <p class="text-[10px] text-slate-400">Febrero 2026</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-5 text-center text-xs font-semibold text-slate-400 pt-2 border-t border-slate-800/80">
                                <span>NOV</span><span>DIC</span><span>ENE</span><span class="text-emerald-400 font-bold">FEB</span><span>MAR</span>
                            </div>
                        </div>

                        <!-- Secondary Overlapping Image -->
                        <div class="absolute -bottom-8 -right-6 w-48 sm:w-60 rounded-2xl overflow-hidden border-4 border-white shadow-2xl hidden sm:block">
                            <img src="{{ asset('images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg') }}" 
                                 alt="Gestión profesional" class="w-full h-36 object-cover">
                        </div>
                    </div>

                    <!-- Left Content -->
                    <div class="space-y-6">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                            Herramientas inteligentes de gestión de cobro de cuotas
                        </h3>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                            Elige la frecuencia de las cuotas y automatiza los cobros. Envía recordatorios automáticos sin fricción y gestiona todo el historial financiero desde un único panel intuitivo.
                        </p>

                        <div class="space-y-4 pt-2">
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0">
                                    ✓
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base">TPV Virtual Propio e Integrado</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Si no dispones de TPV, utiliza la pasarela segura de VaedSaas. Acepta tarjetas, Bizum o transferencias en un clic.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0">
                                    ✓
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base">Cero Tareas Manuales</h4>
                                    <p class="text-sm text-slate-600 mt-0.5">Una solución pensada para que la directiva y entrenadores se olviden del papeleo y se enfoquen en el campo de juego.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- SECTION 2: Gestión de Torneos y Competiciones -->
        <section id="torneos" class="py-16 sm:py-24 bg-slate-100 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Standings Mockup Visual (Left on Desktop) -->
                    <div class="order-2 lg:order-1 relative">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200 relative z-10">
                            
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                                <div>
                                    <h4 class="text-xl font-bold text-slate-900">Liga de Verano 2026</h4>
                                    <p class="text-xs font-semibold text-slate-500">Clasificación General y Estadísticas</p>
                                </div>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full">
                                    En curso
                                </span>
                            </div>

                            <!-- Standings Table Mockup -->
                            <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 mb-6">
                                <div class="grid grid-cols-12 gap-2 p-3 bg-slate-100 font-bold text-[11px] text-slate-500 uppercase tracking-wider">
                                    <div class="col-span-2 text-center">Pos</div>
                                    <div class="col-span-6">Equipo</div>
                                    <div class="col-span-2 text-center">PJ</div>
                                    <div class="col-span-2 text-center">Pts</div>
                                </div>
                                
                                <div class="grid grid-cols-12 gap-2 p-3 border-b border-slate-200 bg-emerald-50/50 items-center font-semibold text-sm">
                                    <div class="col-span-2 text-center font-bold text-emerald-600">1</div>
                                    <div class="col-span-6 font-bold text-slate-900 flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 inline-block"></span> Tu Club FC
                                    </div>
                                    <div class="col-span-2 text-center text-slate-600">10</div>
                                    <div class="col-span-2 text-center font-black text-slate-900">28</div>
                                </div>

                                <div class="grid grid-cols-12 gap-2 p-3 border-b border-slate-200 items-center text-sm text-slate-700">
                                    <div class="col-span-2 text-center font-bold text-slate-400">2</div>
                                    <div class="col-span-6 flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full bg-red-500 inline-block"></span> Atlético Norte
                                    </div>
                                    <div class="col-span-2 text-center text-slate-600">10</div>
                                    <div class="col-span-2 text-center font-bold text-slate-800">24</div>
                                </div>

                                <div class="grid grid-cols-12 gap-2 p-3 items-center text-sm text-slate-700">
                                    <div class="col-span-2 text-center font-bold text-slate-400">3</div>
                                    <div class="col-span-6 flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full bg-blue-500 inline-block"></span> Sporting Sur
                                    </div>
                                    <div class="col-span-2 text-center text-slate-600">10</div>
                                    <div class="col-span-2 text-center font-bold text-slate-800">21</div>
                                </div>
                            </div>

                            <!-- Floating Top Scorer Card -->
                            <div class="bg-slate-900 text-white p-4 rounded-2xl shadow-2xl border border-slate-800 flex items-center gap-4 transform rotate-1 hover:rotate-0 transition duration-300">
                                <div class="w-12 h-12 bg-amber-400 rounded-xl flex items-center justify-center text-slate-950 font-black text-xl shadow-lg">
                                    ⚽
                                </div>
                                <div>
                                    <p class="text-[10px] text-amber-400 font-bold uppercase tracking-widest">Máximo Goleador</p>
                                    <p class="text-sm font-bold text-white">Carlos M. <span class="text-slate-400 font-normal">(Tu Club FC)</span></p>
                                    <p class="text-xs font-semibold text-amber-300">14 Goles anotados</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Content Column -->
                    <div class="order-1 lg:order-2 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs">
                            🏆 Gestión de Competiciones
                        </div>

                        <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                            Torneos de nivel profesional al alcance de tu afición
                        </h3>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                            Dota a tu club de una herramienta automatizada para administrar ligas y torneos locales. Ofrece una experiencia interactiva única tanto para la directiva como para la afición.
                        </p>

                        <ul class="space-y-4 pt-2">
                            <li class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-1">✓</span>
                                <p class="text-sm sm:text-base text-slate-700"><strong class="text-slate-900">Clasificaciones en tiempo real:</strong> Introduce resultados y las tablas se recalculan automáticamente.</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-1">✓</span>
                                <p class="text-sm sm:text-base text-slate-700"><strong class="text-slate-900">Estadísticas detalladas:</strong> Control de pichichis, listas de sancionados y actas arbitrales.</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-sm flex-shrink-0 mt-1">✓</span>
                                <p class="text-sm sm:text-base text-slate-700"><strong class="text-slate-900">Acceso móvil para los fans:</strong> Tus seguidores podrán consultar la evolución del torneo desde su smartphone.</p>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>


        <!-- SECTION 3: Web Propia para el Club -->
        <section id="web-club" class="py-16 sm:py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left Content Column -->
                    <div class="space-y-6">
                        <span class="text-xs font-bold tracking-widest text-blue-600 uppercase bg-blue-50 px-4 py-1.5 rounded-full border border-blue-200">
                            Presencia Digital
                        </span>

                        <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                            Una web exclusiva y personalizada para tu club
                        </h3>

                        <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                            Otorga a tu equipo la presencia digital que merece. Con un sitio web oficial, centralizarás las noticias, galerías y comunicaciones sin requerir conocimientos técnicos.
                        </p>

                        <div class="space-y-4 pt-2">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <h4 class="font-bold text-slate-900 text-base">Noticias & Eventos Oficiales</h4>
                                <p class="text-sm text-slate-600 mt-1">Publica resultados, horarios de partidos y comunicados oficiales en un portal elegante.</p>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <h4 class="font-bold text-slate-900 text-base">Formularios Digitales de Inscripción</h4>
                                <p class="text-sm text-slate-600 mt-1">Captura las altas de nuevos jugadores y recopila la documentación legal de forma 100% digital.</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="#contacto" class="inline-flex items-center justify-center px-6 py-3.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition duration-300 shadow-lg shadow-blue-500/20">
                                Descubre cómo será tu web
                            </a>
                        </div>
                    </div>

                    <!-- Right Browser Mockup -->
                    <div class="relative">
                        <div class="bg-slate-900 rounded-3xl shadow-2xl overflow-hidden border border-slate-800">
                            <!-- Browser Chrome Bar -->
                            <div class="bg-slate-800/80 px-4 py-3 flex items-center gap-2 border-b border-slate-700">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                <div class="ml-4 bg-slate-900 text-slate-400 text-xs px-3 py-1 rounded-lg w-full truncate border border-slate-700/60 font-mono">
                                    https://www.tuclubfc.com
                                </div>
                            </div>

                            <!-- Website Mockup Body -->
                            <div class="p-6 bg-slate-950 text-white space-y-6">
                                <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-white">FC</div>
                                        <span class="font-bold text-base">Tu Club FC</span>
                                    </div>
                                    <div class="flex gap-3 text-xs text-slate-400 font-semibold">
                                        <span>Inicio</span><span>Plantilla</span><span class="text-blue-400">Noticias</span>
                                    </div>
                                </div>

                                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white relative overflow-hidden">
                                    <div class="relative z-10 space-y-2">
                                        <span class="text-[10px] font-bold bg-white/20 px-2.5 py-1 rounded-md uppercase">Última Hora</span>
                                        <h4 class="text-lg font-extrabold">¡Abierta la inscripción para la cantera 2026/2027!</h4>
                                        <p class="text-xs text-blue-100">Reserva tu plaza antes del 31 de mayo.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-800">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-2 font-bold">⚽</div>
                                        <p class="text-xs font-bold text-white">Próximo Partido</p>
                                        <p class="text-[11px] text-slate-400">Sábado 18:00h - Campo Municipal</p>
                                    </div>
                                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-800">
                                        <div class="w-8 h-8 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center mb-2 font-bold">👥</div>
                                        <p class="text-xs font-bold text-white">Plantilla Oficial</p>
                                        <p class="text-[11px] text-slate-400">24 Jugadores registrados</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        

        <!-- SECTION 4: Convocatorias de Partidos -->
        <section class="py-16 sm:py-24 bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_50%,_rgba(16,185,129,0.12),_transparent_70%)]"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left Column: Visual Mockup de Convocatoria -->
                    <div class="relative">
                        <div class="bg-slate-800 border border-slate-700/80 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                            
                            <!-- Header del Partido -->
                            <div class="flex items-center justify-between border-b border-slate-700/80 pb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center text-lg">
                                        ⚽
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-white">Jornada 14 • Liga Amateur</h4>
                                        <p class="text-xs text-slate-400">Domingo 11:30h • Campo Municipal</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold rounded-full">
                                    Convocatoria Abierta
                                </span>
                            </div>

                            <!-- Lista de Jugadores / Estado de Asistencia -->
                            <div class="space-y-3">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Confirmación de Asistencia</p>
                                
                                <!-- Jugador 1 - Confirmado -->
                                <div class="flex items-center justify-between p-3 bg-slate-900/80 rounded-2xl border border-slate-700/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-500/20 text-blue-400 font-bold text-xs flex items-center justify-center">
                                            MP
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-200">Marc Pérez</p>
                                            <p class="text-[10px] text-slate-400">Delantero</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-xl border border-emerald-500/30">
                                        ✓ Confirmado
                                    </span>
                                </div>

                                <!-- Jugador 2 - Confirmado -->
                                <div class="flex items-center justify-between p-3 bg-slate-900/80 rounded-2xl border border-slate-700/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-purple-500/20 text-purple-400 font-bold text-xs flex items-center justify-center">
                                            CG
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-200">Carlos Gómez</p>
                                            <p class="text-[10px] text-slate-400">Centrocampista</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-xl border border-emerald-500/30">
                                        ✓ Confirmado
                                    </span>
                                </div>

                                <!-- Jugador 3 - Pendiente -->
                                <div class="flex items-center justify-between p-3 bg-slate-900/80 rounded-2xl border border-slate-700/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-amber-500/20 text-amber-400 font-bold text-xs flex items-center justify-center">
                                            DR
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-200">David Ruiz</p>
                                            <p class="text-[10px] text-slate-400">Defensa</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/20 text-amber-400 text-xs font-bold rounded-xl border border-amber-500/30">
                                        ⏳ Pendiente
                                    </span>
                                </div>
                            </div>

                            <!-- Resumen de Convocatoria -->
                            <div class="pt-2 flex items-center justify-between text-xs border-t border-slate-700/80">
                                <span class="text-slate-400">Convocados: <strong class="text-white font-bold">16 jugadores</strong></span>
                                <span class="text-emerald-400 font-bold">14 Confirmados • 2 Pendientes</span>
                            </div>

                        </div>
                    </div>

                    <!-- Right Content Column -->
                    <div class="space-y-6">
                        <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase bg-emerald-500/10 px-4 py-1.5 rounded-full border border-emerald-500/30">
                            Convocatorias & Asistencia
                        </span>

                        <h3 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                            Convocatorias de partidos sin caos ni mensajes perdidos
                        </h3>

                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                            Envía la lista de convocados en un solo clic. Los jugadores y sus familias reciben una notificación instantánea en la App para confirmar o declinar su asistencia en segundos.
                        </p>

                        <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                            <p class="text-sm font-bold text-emerald-400">Control en tiempo real para el cuerpo técnico</p>
                            <p class="text-sm text-slate-300">
                                Visualiza exactamente con qué plantilla cuentas para el fin de semana, detecta bajas de última hora y gestiona sustitutos sin perder tiempo en grupos masivos de chat.
                            </p>
                        </div>

                        <div class="pt-2">
                            {{-- <a href="#contacto" 
                            class="inline-flex items-center justify-center px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold rounded-2xl transition duration-300 shadow-lg shadow-emerald-500/20">
                                Probar Gestor de Convocatorias
                            </a> --}}
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- SECTION 5: ¿Por qué VaedSaas es Gratuito? (Win-Win) -->
        <section id="" class="py-16 sm:py-24 bg-slate-50 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                        ¿Modelo <span class="text-emerald-600">Win-Win</span>?
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 mt-4">
                        Apostamos por un modelo colaborativo transparente donde la plataforma crece si tu club gana.
                    </p>
                </div>

                <div class="grid lg:grid-cols-12 gap-8 items-center mb-16">
                    
                    <!-- Explanation Left Column -->
                    <div class="lg:col-span-6 space-y-6">
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                            Modelo Win-Win para equipos amateur: Ganamos juntos
                        </h3>
                        
                        <p class="text-base sm:text-lg text-slate-700 leading-relaxed">
                            Monetizamos el servicio ofreciendo ropa y material deportivo oficial personalizado para tu club.
                        </p>
                        <p class="text-base sm:text-lg text-slate-700 leading-relaxed">
                            Venta de merchandising oficial del club en su tienda oficial del club.
                        </p>

                        <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                            <div class="text-3xl font-black text-emerald-600">5% - 10%</div>
                            <p class="text-sm sm:text-base text-slate-700 font-semibold">
                                Por cada compra efectuada por tus socios o jugadores, tu club acumula automáticamente entre un 5% y 10% en su saldo rescatable.
                            </p>
                        </div>

                        <p class="text-sm sm:text-base text-slate-600">
                            Sin gestión de almacenamiento, costes fijos de mantenimiento ni sorpresas en la factura.
                        </p>
                         <p class="text-sm sm:text-base text-slate-600">
                            El club podrá vender productos de otros proveedores, o los ofrecidos por vaed.
                        </p>
                    </div>

                    <!-- Earnings Breakdown Right Column -->
                    <div class="lg:col-span-6">
                        <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-800 space-y-6">
                            <h4 class="text-lg font-bold text-center border-b border-slate-800 pb-4">
                                Ejemplo de Rentabilidad Mensual
                            </h4>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-800/80 p-4 rounded-2xl border border-slate-700 text-center">
                                    <p class="text-2xl sm:text-3xl font-extrabold text-white">300 €</p>
                                    <p class="text-xs text-slate-400 mt-1">Ventas en Merchandising</p>
                                </div>
                                <div class="bg-emerald-500/20 p-4 rounded-2xl border border-emerald-500/40 text-center">
                                    <p class="text-2xl sm:text-3xl font-extrabold text-emerald-400">+45 €</p>
                                    <p class="text-xs text-emerald-200 mt-1">Beneficio directo para el club</p>
                                </div>
                            </div>

                            <div class="space-y-2 text-xs sm:text-sm text-slate-300 pt-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-emerald-400 font-bold">✓</span> Sin gestión de inventario ni envíos.
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-emerald-400 font-bold">✓</span> Transferencia a tu cuenta bancaria cuando lo solicites.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3 Steps Grid -->
                <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-slate-200">
                    <h3 class="text-2xl font-bold text-slate-900 text-center mb-10">Cómo Funciona en 3 Pasos</h3>

                    <div class="grid md:grid-cols-3 gap-8 text-center relative">
                        <div class="space-y-4">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-slate-950 font-black text-2xl flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">1</div>
                            <h4 class="text-lg font-bold text-slate-900">Jugadores Compran</h4>
                            <p class="text-sm text-slate-600">Tus jugadores encargan sus equipaciones y merchandising en la tienda digital oficial.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-slate-950 font-black text-2xl flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">2</div>
                            <h4 class="text-lg font-bold text-slate-900">VaedSaas Gestiona</h4>
                            <p class="text-sm text-slate-600">Personalizamos cada prenda con tu escudo y la enviamos al domicilio del comprador.</p>
                        </div>

                        <div class="space-y-4">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-slate-950 font-black text-2xl flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">3</div>
                            <h4 class="text-lg font-bold text-slate-900">Tu Club Acumula Saldo</h4>
                            <p class="text-sm text-slate-600">Recibes entre el 5% y el 10% de beneficio limpio de forma automática.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- SECTION 6: App Móvil -->
        <section class="py-16 sm:py-24 bg-slate-950 text-white relative overflow-hidden">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/10 rounded-full blur-[120px]"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left Content -->
                    <div class="space-y-6">
                        <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase bg-emerald-500/10 px-4 py-1.5 rounded-full border border-emerald-500/30">
                            Aplicación Móvil iOS & Android
                        </span>

                        <h2 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight">
                            Diseñada para entrenadores, jugadores y familias
                        </h2>

                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed">
                            Lleva el control de convocatorias, calendarios de partidos, asistencia a entrenamientos y avisos de última hora en el bolsillo.
                        </p>

                        <!-- Download Badges -->
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="#" title="Descargar app Android" class="transform hover:scale-105 transition duration-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-12 sm:h-14">
                            </a>
                            <a href="#" title="Descargar app iOS" class="transform hover:scale-105 transition duration-200">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store" class="h-12 sm:h-14">
                            </a>
                        </div>
                    </div>

                    <!-- Right Dual Phone Visual -->
                    <div class="relative hidden sm:block h-[450px]">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-64 bg-slate-900 border border-slate-700/80 rounded-[2.5rem] p-2.5 shadow-2xl transform -rotate-6 z-10">
                                <div class="bg-black rounded-[2.2rem] overflow-hidden aspect-[9/19.5]">
                                    <img src="{{ asset('images/public/capturaappmovil.jpg') }}" alt="App Móvil" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- SECTION 7: Formulario de Contacto -->
        {{-- <section id="contacto" class="py-16 sm:py-24 bg-white relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        ¿Tienes dudas? Hablemos sin compromiso
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 mt-3">
                        Completa el formulario y nos pondremos en contacto contigo para mostrarte una demo en vivo.
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
                            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-slate-900 text-sm" placeholder="Cuéntanos cuántos equipos gestionas y qué dudas tienes..."></textarea>
                        </div>

                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="privacy" name="privacy" required class="mt-1 w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                            <label for="privacy" class="text-xs text-slate-600">Acepto la política de privacidad y el tratamiento de mis datos personales. *</label>
                        </div>

                        <button type="submit" :disabled="submitting" class="w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold py-4 px-8 rounded-xl transition duration-300 shadow-lg shadow-emerald-500/25 disabled:opacity-50">
                            <span x-show="!submitting">Enviar Mensaje</span>
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
                        {{-- <p class="mt-3 text-xs text-slate-400 leading-relaxed">
                            Plataforma gratuita para la gestión y monetización de clubes y escuelas de fútbol amateur.
                        </p> --}}
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navegación</h4>
                        <ul class="space-y-2 text-xs">
                            <li><a href="#soluciones" class="hover:text-emerald-400 transition">Soluciones</a></li>
                            <li><a href="#torneos" class="hover:text-emerald-400 transition">Torneos</a></li>
                           
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

                // Hero Slider Logic
                var track = document.getElementById('heroSlidesTrack');
                var slides = track ? track.querySelectorAll('.hero-slide') : [];
                var dots = document.querySelectorAll('.hero-dot');
                var prevBtn = document.getElementById('heroPrevBtn');
                var nextBtn = document.getElementById('heroNextBtn');
                var current = 0;
                var total = slides.length || 1;
                var isAnimating = false;

                function goTo(index) {
                    if (isAnimating || total <= 1) return;
                    var next = ((index % total) + total) % total;
                    if (next === current) return;
                    isAnimating = true;
                    current = next;
                    track.style.transform = 'translateX(-' + (current * 100) + '%)';
                    dots.forEach(function (d, i) { d.classList.toggle('active', i === current); });
                    setTimeout(function () { isAnimating = false; }, 700);
                }

                if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); });
                if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); });
                dots.forEach(function (d, i) {
                    d.addEventListener('click', function () { goTo(i); });
                });
            })();
        </script>
    </body>
</html>