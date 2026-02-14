<div>
    @push('styles')
    <style>
        .swiper {
            width: 100%;
            height: 100vh;
        }
        
        /* Asegurar que el texto de temporada muy grande se renderice bien */
        @media (max-width: 768px) {
            .season-bg {
                font-size: 10rem !important;
            }
        }
        
        /* Estilos modernos inspirados en NITEX */
        .hero-title {
            line-height: 0.95;
            letter-spacing: -0.02em;
        }
        
        .section-title {
            line-height: 1.1;
            letter-spacing: -0.01em;
        }
        
        .btn-rounded {
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-rounded:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .card-hover {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }
        
        /* Animaciones para palabras flotantes */
        @keyframes float-1 {
            0% {
                transform: translate(0, 0) rotate(-2deg);
            }
            25% {
                transform: translate(-15px, -20px) rotate(1deg);
            }
            50% {
                transform: translate(-10px, -30px) rotate(3deg);
            }
            75% {
                transform: translate(5px, -15px) rotate(-1deg);
            }
            100% {
                transform: translate(0, 0) rotate(-2deg);
            }
        }
        
        @keyframes float-2 {
            0% {
                transform: translate(0, 0) rotate(1deg);
            }
            25% {
                transform: translate(20px, -10px) rotate(-2deg);
            }
            50% {
                transform: translate(25px, -25px) rotate(-4deg);
            }
            75% {
                transform: translate(10px, -20px) rotate(2deg);
            }
            100% {
                transform: translate(0, 0) rotate(1deg);
            }
        }
        
        @keyframes float-3 {
            0% {
                transform: translate(0, 0) rotate(-1deg);
            }
            25% {
                transform: translate(-25px, 15px) rotate(3deg);
            }
            50% {
                transform: translate(-30px, 20px) rotate(2deg);
            }
            75% {
                transform: translate(-15px, 10px) rotate(-2deg);
            }
            100% {
                transform: translate(0, 0) rotate(-1deg);
            }
        }
        
        .float-word-1 {
            animation: float-1 10s ease-in-out infinite;
            will-change: transform;
        }
        
        .float-word-2 {
            animation: float-2 12s ease-in-out infinite;
            will-change: transform;
        }
        
        .float-word-3 {
            animation: float-3 14s ease-in-out infinite;
            will-change: transform;
        }
    </style>
    @endpush

    <!-- Hero Carousel Section -->
    <div class="swiper heroSwiper h-screen w-full">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-primary"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white px-6 z-10 max-w-6xl">
                        <h1 class="hero-title text-7xl md:text-8xl lg:text-[10rem] font-bold mb-10" data-aos="fade-up">
                            {{ tenantName() }}
                        </h1>
                        <p class="text-xl md:text-3xl font-light mb-14 tracking-widest uppercase" data-aos="fade-up" data-aos-delay="200">
                            Formando Campeones
                        </p>
                        <a href="{{ route('webclubs.registration') }}" class="btn-rounded bg-primary text-white px-14 py-4 font-semibold text-[13px] uppercase tracking-[0.15em] inline-block" data-aos="fade-up" data-aos-delay="400">
                            Únete Ahora
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-secondary"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white px-6 z-10 max-w-6xl">
                        <h1 class="hero-title text-7xl md:text-8xl lg:text-[10rem] font-bold mb-10" data-aos="fade-up">
                            EXCELENCIA
                        </h1>
                        <p class="text-xl md:text-3xl font-light mb-14 tracking-widest uppercase" data-aos="fade-up" data-aos-delay="200">
                            En Cada Entrenamiento
                        </p>
                        <a href="{{ route('webclubs.about') }}" class="btn-rounded bg-white text-primary px-14 py-4 font-semibold text-[13px] uppercase tracking-[0.15em] inline-block" data-aos="fade-up" data-aos-delay="400">
                            Conoce Más
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-primary" style="opacity: 0.85;"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white px-6 z-10 max-w-6xl">
                        <h1 class="hero-title text-7xl md:text-8xl lg:text-[10rem] font-bold mb-10" data-aos="fade-up">
                            FAMILIA
                        </h1>
                        <p class="text-xl md:text-3xl font-light mb-14 tracking-widest uppercase" data-aos="fade-up" data-aos-delay="200">
                            Un Club Para Todos
                        </p>
                        <a href="{{ route('webclubs.contact') }}" class="btn-rounded bg-white text-primary px-14 py-4 font-semibold text-[13px] uppercase tracking-[0.15em] inline-block" data-aos="fade-up" data-aos-delay="400">
                            Contacto
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
        
        <!-- Navigation -->
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
    </div>

    <!-- Stats Section -->
    <section class="py-40 bg-white relative overflow-hidden">
        @if($activeSeason)
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="season-bg text-[20rem] md:text-[30rem] font-extrabold leading-none opacity-30" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                {{ $activeSeason->from_year }}/{{ substr($activeSeason->to_year, -2) }}
            </div>
        </div>
        @endif
        <div class="max-w-[1920px] mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-32 text-center">
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="text-8xl md:text-9xl lg:text-[10rem] font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="{{ $players }}">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Jugadores</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="text-8xl md:text-9xl lg:text-[10rem] font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="{{ $teams }}">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Equipos</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="text-8xl md:text-9xl lg:text-[10rem] font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="{{ $coaches }}">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Entrenadores</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="text-8xl md:text-9xl lg:text-[10rem] font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="80">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Años</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Próximos Partidos style="background: linear-gradient(to bottom right, {{ $primaryColor }}, {{ $secondaryColor }});"-->
    <section class="pt-20 pb-40 relative overflow-hidden" >
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-20">
                <h2 class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/70 font-semibold mb-5">[01] Calendario</h2>
                <h3 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold text-black">Próximos Partidos</h3>
            </div>
            
            <!-- Filtros -->
            <div class="mb-12" id="filters-section">
                <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                        <!-- Buscador de equipos -->
                        <div class="flex-1 w-full">
                            <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold mb-3">
                                Buscar Equipo
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.500ms="searchTeam"
                                    placeholder="Nombre del equipo..."
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                                    autocomplete="off"
                                >
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Checkbox solo partidos en casa -->
                        <div class="w-auto">
                            <label class="block text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold mb-3">
                                Partidos en Casa
                            </label>
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="onlyHomeMatches"
                                    class="sr-only peer"
                                >
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                                <span class="ml-3 text-sm font-bold text-gray-700 uppercase tracking-[0.15em] whitespace-nowrap">
                                    🏠 
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Indicador de resultados -->
                    @if($searchTeam || $onlyHomeMatches)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500 font-medium">
                                    <span class="font-bold text-primary">{{ $upcomingMatches->count() }}</span> partido(s) encontrado(s)
                                </span>
                                <button 
                                    wire:click="$set('searchTeam', ''); $set('onlyHomeMatches', false)"
                                    class="text-gray-400 hover:text-primary font-bold uppercase tracking-wider transition-colors duration-300"
                                >
                                    Limpiar filtros
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            @if($upcomingMatches->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingMatches as $index => $match)
                        <div class="bg-white shadow-lg shadow-gray-200/50 hover:shadow-xl hover:shadow-gray-300/50 transition-all duration-500 group rounded-xl overflow-hidden" wire:key="upcoming-{{ $match->id }}">
                            <div class="p-2 md:p-2">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                    <!-- Fecha -->
                                    <div class="md:col-span-2 text-center">
                                        <div class="inline-block">
                                            <div class="text-[14px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-1">
                                                {{ $match->date->locale('es')->translatedFormat('l') }}   <span class="text-base font-bold text-primary">
                                                        {{ $match->hour_match ? $match->hour_match->format('H:i') : '--:--' }}
                                                    </span>
                                            </div>
                                            <div class="text-4xl font-extrabold bg-gradient-to-br from-gray-900 to-gray-700 bg-clip-text text-transparent leading-none mb-2">
                                               
                                                {{ $match->date->format('d') }}
                                                
                                            </div>
                                            <div class="text-[14px] uppercase tracking-[0.2em] text-gray-500 font-bold">
                                                {{ $match->date->locale('es')->translatedFormat('M Y') }}
                                            </div>
                                            <div class="mt-2 pt-2 border-t border-gray-200">
                                               
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Información del Partido -->
                                    <div class="md:col-span-8">
                                        <div class="flex items-center justify-center gap-6">
                                            @if($match->sites === 'home')
                                                <!-- Escuela como Local (izquierda) -->
                                                <div class="flex items-center gap-3 flex-1 justify-end">
                                                    <div class="text-right">
                                                        <div class="text-xl md:text-3xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300">
                                                            {{ $match->team ? $match->team->team : tenantName() }}
                                                        </div>
                                                        
                                                    </div>
                                                    @if($match->team && $match->team->team_image)
                                                        <div class="w-14 h-14 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform duration-300">
                                                            <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="w-full h-full object-contain">
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- VS Badge -->
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-inner">
                                                        <span class="text-[10px] font-black text-gray-600 uppercase tracking-wider">VS</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Oponente como Visitante (derecha) -->
                                                <div class="flex items-center gap-3 flex-1">
                                                    @if($match->escudo_team_oponent)
                                                        <div class="w-14 h-14 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform duration-300">
                                                            <img src="{{ Storage::url($match->escudo_team_oponent) }}" alt="{{ $match->opponent }}" class="w-full h-full object-contain">
                                                        </div>
                                                    @endif
                                                    <div class="text-left">
                                                        <div class="text-xl md:text-3xl font-bold text-gray-900 group-hover:text-secondary transition-colors duration-300">
                                                            {{ $match->opponent }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Oponente como Local (izquierda) -->
                                                <div class="flex items-center gap-3 flex-1 justify-end">
                                                    <div class="text-right">
                                                        <div class="text-xl md:text-3xl font-bold text-gray-900 group-hover:text-secondary transition-colors duration-300">
                                                            {{ $match->opponent }}
                                                        </div>
                                                        
                                                    </div>
                                                    @if($match->escudo_team_oponent)
                                                        <div class="w-14 h-14 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform duration-300">
                                                            <img src="{{ Storage::url($match->escudo_team_oponent) }}" alt="{{ $match->opponent }}" class="w-full h-full object-contain">
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- VS Badge -->
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-inner">
                                                        <span class="text-[10px] font-black text-gray-600 uppercase tracking-wider">VS</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Escuela como Visitante (derecha) -->
                                                <div class="flex items-center gap-3 flex-1">
                                                    @if($match->team && $match->team->team_image)
                                                        <div class="w-14 h-14 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform duration-300">
                                                            <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="w-full h-full object-contain">
                                                        </div>
                                                    @endif
                                                    <div class="text-left">
                                                        <div class="text-xl md:text-3xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300">
                                                            {{ $match->team ? $match->team->team : tenantName() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Ubicación -->
                                    <div class="md:col-span-2 text-center">
                                        <div class="inline-block">
                                            <div class="text-[14px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-2">
                                                Ubicación
                                            </div>
                                            <div class="rounded-lg px-4 py-2 group-hover:bg-primary/5 transition-colors duration-300">
                                                <div class="text-2xl mb-1 opacity-60">
                                                    @if($match->sites === 'home')
                                                        🏠
                                                    @else
                                                        ✈️
                                                    @endif
                                                </div>
                                                <div class="text-[12px] font-bold text-gray-700 leading-tight">
                                                    {{ $match->site ?: 'Por confirmar' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-4">
                    <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 p-6 md:p-8 text-center">
                        <div class="text-5xl mb-4 opacity-40">
                            @if($searchTeam || $onlyHomeMatches)
                                🔍
                            @else
                                📅
                            @endif
                        </div>
                        <p class="text-xl text-gray-500 uppercase tracking-[0.2em] font-bold">
                            @if($searchTeam || $onlyHomeMatches)
                                No se encontraron partidos
                            @else
                                No hay partidos programados
                            @endif
                        </p>
                        <p class="text-sm text-gray-400 mt-4 tracking-wide">
                            @if($searchTeam || $onlyHomeMatches)
                                Intenta ajustar los filtros de búsqueda
                            @else
                                Próximamente actualizaremos el calendario
                            @endif
                        </p>
                        @if($searchTeam || $onlyHomeMatches)
                            <button 
                                wire:click="$set('searchTeam', ''); $set('onlyHomeMatches', false)"
                                class="mt-6 btn-rounded bg-primary text-white px-8 py-3 font-semibold text-xs uppercase tracking-[0.15em] inline-block"
                            >
                                Limpiar filtros
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Últimos Resultados -->
    <section class="pt-20 pb-40 bg-white relative overflow-hidden mt-4">
        <!-- Logo de fondo con opacidad -->
        <div class="absolute inset-x-0 top-20 bottom-0 flex items-center justify-center pointer-events-none opacity-5">
            <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="h-full w-auto object-contain">
        </div>
        
        <div class="w-full px-6 lg:px-12 relative z-10">
            <div class="max-w-[1920px] mx-auto">
                <div class="mb-20"  data-aos="fade-up">
                    <h2 class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5">[02] Resultados</h2>
                    <h3 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold text-gray-900">Últimas noticias</h3>
                    <p class="text-gray-500 mt-4 text-sm uppercase tracking-wider">Últimos 15 días</p>
                </div>
                
                @if($recentResults->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-12">
                        @foreach($recentResults as $index => $result)
                            @php
                                $goalsTeam = $result->goals_team ?? 0;
                                $goalsOponent = $result->goals_oponent ?? 0;
                                $resultInfo = $this->getResultType($goalsTeam, $goalsOponent);
                                
                                // Obtener la imagen: primero de match_images, si no hay usar el logo del tenant
                                $backgroundImage = tenantLogo();
                                if ($result->match_images && is_array($result->match_images) && count($result->match_images) > 0) {
                                    $backgroundImage = Storage::url($result->match_images[0]);
                                }
                            @endphp
                            
                            <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 overflow-hidden group cursor-pointer hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border"  wire:key="result-{{ $result->id }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                <!-- Imagen con overlay degradado -->
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $backgroundImage }}" alt="{{ $result->team ? $result->team->team : tenantName() }} vs {{ $result->opponent }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    
                                    <!-- Badge del resultado sobre la imagen -->
                                    <div class="absolute top-3 right-3">
                                        @if($resultInfo['type'] === 'Victoria')
                                            <span class="bg-green-500 text-white text-[9px] font-bold px-3 py-1.5 uppercase tracking-wider inline-block rounded-full shadow-lg">
                                                Victoria
                                            </span>
                                        @elseif($resultInfo['type'] === 'Derrota')
                                            <span class="bg-red-500 text-white text-[9px] font-bold px-3 py-1.5 uppercase tracking-wider inline-block rounded-full shadow-lg">
                                                Derrota
                                            </span>
                                        @else
                                            <span class="bg-yellow-500 text-white text-[9px] font-bold px-3 py-1.5 uppercase tracking-wider inline-block rounded-full shadow-lg">
                                                Empate
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Marcador sobre la imagen -->
                                    <div class="absolute bottom-3 left-3 right-3">
                                        <div class="flex items-center justify-center gap-3">
                                            @if($result->sites === 'home')
                                                <!-- Escuela en casa (goles izquierda) -->
                                                <div class="text-4xl font-black text-white bg-black rounded-lg px-4 py-2 shadow-lg" style="border: 1px solid {{ $secondaryColor }};">
                                                    {{ $goalsTeam }}
                                                </div>
                                                <div class="text-xs font-bold text-white/70 uppercase bg-black rounded-lg px-1 py-1 shadow-lg">-</div>
                                                <div class="text-4xl font-black text-white bg-black rounded-lg px-4 py-2 shadow-lg" style="border: 1px solid {{ $secondaryColor }};">
                                                    {{ $goalsOponent }}
                                                </div>
                                            @else
                                                <!-- Escuela fuera (goles derecha) -->
                                                <div class="text-4xl font-black text-white bg-black rounded-lg px-4 py-2 shadow-lg" style="border: 1px solid {{ $secondaryColor }};">
                                                    {{ $goalsOponent }}
                                                </div>
                                                <div class="text-xs font-bold text-white/70 uppercase bg-black rounded-lg px-1 py-1 shadow-lg">-</div>
                                                <div class="text-4xl font-black text-white bg-black rounded-lg px-4 py-2 shadow-lg" style="border: 1px solid {{ $secondaryColor }};">
                                                    {{ $goalsTeam }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Contenido del card -->
                                <div class="p-4">
                                    <!-- Escudos de los equipos -->
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        @if($result->sites === 'home')
                                            <!-- Escuela juega en casa (izquierda) -->
                                            <div class="w-12 h-12 bg-gray-50 rounded-full p-1.5 shadow-md">
                                                <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="w-full h-full object-contain">
                                            </div>
                                            <div class="text-gray-400 font-bold text-xs">VS</div>
                                            @if($result->escudo_team_oponent)
                                                <div class="w-12 h-12 bg-gray-50 rounded-full p-1.5 shadow-md">
                                                    <img src="{{ Storage::url($result->escudo_team_oponent) }}" alt="{{ $result->opponent }}" class="w-full h-full object-contain">
                                                </div>
                                            @endif
                                        @else
                                            <!-- Escuela juega fuera (derecha), oponente en izquierda -->
                                            @if($result->escudo_team_oponent)
                                                <div class="w-12 h-12 bg-gray-50 rounded-full p-1.5 shadow-md">
                                                    <img src="{{ Storage::url($result->escudo_team_oponent) }}" alt="{{ $result->opponent }}" class="w-full h-full object-contain">
                                                </div>
                                            @endif
                                            <div class="text-gray-400 font-bold text-xs">VS</div>
                                            <div class="w-12 h-12 bg-gray-50 rounded-full p-1.5 shadow-md">
                                                <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="w-full h-full object-contain">
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Equipos -->
                                    <div class="text-center mb-3">
                                        <div class="text-sm font-bold text-gray-900 leading-tight mb-1">
                                            {{ $result->team ? $result->team->team : tenantName() }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">VS</div>
                                        <div class="text-sm font-bold text-gray-900 leading-tight mt-1">
                                            {{ $result->opponent }}
                                        </div>
                                    </div>
                                    
                                    <!-- Categoría y fecha -->
                                    @if($result->team && $result->team->category)
                                        <div class="text-center mb-2">
                                            <span class="text-[9px] text-gray-500 uppercase tracking-wider font-medium">
                                                {{ $result->team->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="text-center pt-2 border-t border-gray-100">
                                        <div class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-2">
                                            {{ $result->date->locale('es')->translatedFormat('d M Y') }}
                                        </div>
                                        
                                        @if($result->web_description)
                                            <div class="mt-2 text-left px-1">
                                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                                    {!! strip_tags($result->web_description) !!}
                                                </p>
                                                <span class="text-[10px] text-primary font-semibold uppercase tracking-wider cursor-pointer hover:underline">
                                                    Leer más...
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Botón Ver Más Resultados -->
                    {{-- TODO: Crear ruta 'webclubs.results' para mostrar todos los resultados históricos --}}
                    <div class="text-center mt-16">
                        <div class="bg-gray-50 rounded-3xl p-12 inline-block">
                            <a href="#" class="group inline-flex items-center gap-4 text-white px-12 py-5 rounded-full font-bold text-sm uppercase tracking-[0.15em] shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-105" style="background: linear-gradient(to right, {{ $primaryColor }}, {{ $secondaryColor }});">
                                <span>Ver Todos Los Resultados</span>
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="inline-block bg-gray-50 rounded-3xl p-16">
                            <div class="text-7xl mb-6 opacity-30">🏆</div>
                            <p class="text-xl text-gray-400 uppercase tracking-[0.2em] font-bold">No hay resultados recientes</p>
                            <p class="text-sm text-gray-400 mt-4 tracking-wide">En los últimos 15 días</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Nuestros Patrocinadores -->
    <section class="py-40  relative overflow-hidden">
        <!-- Nombre de la escuela de fondo con palabras desordenadas -->
        <div class="absolute inset-0 pointer-events-none">
            @php
                $words = explode(' ', tenantName());
                $positions = [
                    ['top' => '10%', 'right' => '10%', 'class' => 'float-word-1'],
                    ['top' => '40%', 'left' => '5%', 'class' => 'float-word-2'],
                    ['top' => '65%', 'right' => '15%', 'class' => 'float-word-3'],
                ];
            @endphp
            
            @foreach($words as $index => $word)
                @if(isset($positions[$index]))
                    <div class="absolute {{ $positions[$index]['class'] }}" 
                         style="
                            {{ isset($positions[$index]['top']) ? 'top: ' . $positions[$index]['top'] . ';' : '' }}
                            {{ isset($positions[$index]['bottom']) ? 'bottom: ' . $positions[$index]['bottom'] . ';' : '' }}
                            {{ isset($positions[$index]['left']) ? 'left: ' . $positions[$index]['left'] . ';' : '' }}
                            {{ isset($positions[$index]['right']) ? 'right: ' . $positions[$index]['right'] . ';' : '' }}
                         ">
                        <span class="text-[12rem] md:text-[18rem] lg:text-[24rem] font-extrabold leading-none opacity-20 whitespace-nowrap"
                              style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            {{ $word }}
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <h2 class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5 text-center" data-aos="fade-up">[03] Colaboradores principales</h2>
            <h3 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold mb-20 text-gray-900 text-center" data-aos="fade-up">¡¡Gracias!!</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Patrocinador 1 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 2 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 3 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 4 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 5 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="500">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 6 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 7 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="700">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
                
                <!-- Patrocinador 8 -->
                <div class="bg-white border border-gray-200 p-12 flex items-center justify-center hover:border-primary transition-all duration-300 rounded-2xl" data-aos="fade-up" data-aos-delay="800">
                    <div class="text-center">
                        <div class="text-5xl font-extrabold text-gray-200 mb-3">LOGO</div>
                        <div class="text-[11px] uppercase tracking-[0.15em] text-gray-400 font-semibold">Patrocinador</div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-20" data-aos="fade-up">
                <p class="text-gray-500 text-base uppercase tracking-[0.15em] font-medium mb-8">¿Quieres ser patrocinador?</p>
                <a href="{{ route('webclubs.contact') }}" class="btn-rounded inline-block bg-primary text-white px-12 py-4 font-semibold text-[13px] uppercase tracking-[0.15em]">
                    Contacta con Nosotros
                </a>
            </div>
        </div>
    </section>

    <!-- Sección de Socios/Membresía -->
    <section class="py-40 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-24" data-aos="fade-up">
                <h2 class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-gray-400 font-semibold mb-5">[04] Únete a Nosotros</h2>
                <h3 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold mb-10">Hazte Socio</h3>
                <p class="text-xl md:text-2xl font-light text-gray-400 max-w-3xl mx-auto leading-relaxed">
                    Disfruta de beneficios exclusivos y forma parte de nuestra comunidad deportiva
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-24">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-6xl md:text-7xl font-bold mb-8 text-gray-300">01</div>
                    <div class="h-px bg-gray-700 mb-8"></div>
                    <h4 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-5 uppercase tracking-[0.15em]">Descuentos</h4>
                    <p class="text-gray-400 text-base leading-relaxed">Acceso a precios especiales en equipación y eventos</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-6xl md:text-7xl font-bold mb-8 text-gray-300">02</div>
                    <div class="h-px bg-gray-700 mb-8"></div>
                    <h4 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-5 uppercase tracking-[0.15em]">Eventos</h4>
                    <p class="text-gray-400 text-base leading-relaxed">Invitaciones exclusivas a eventos del club</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-6xl md:text-7xl font-bold mb-8 text-gray-300">03</div>
                    <div class="h-px bg-gray-700 mb-8"></div>
                    <h4 class="text-2xl md:text-3xl lg:text-4xl font-semibold mb-5 uppercase tracking-[0.15em]">Prioridad</h4>
                    <p class="text-gray-400 text-base leading-relaxed">Acceso prioritario a inscripciones y reservas</p>
                </div>
            </div>
            
            <div class="text-center" data-aos="fade-up">
                <a href="{{ route('webclubs.registration') }}" class="btn-rounded bg-secondary text-white px-14 py-4 font-semibold text-[13px] uppercase tracking-[0.15em] inline-block">
                    Únete Ahora
                </a>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-40 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5" data-aos="fade-up">[05] Contacto</h2>
            <h3 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold mb-16 text-gray-900" data-aos="fade-up">¿Tienes Preguntas?</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-20">
                <div class="text-center p-10" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl mb-5 opacity-70">📧</div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-500 font-semibold mb-3">Email</div>
                    <div class="text-lg font-semibold text-gray-900">info@ejemplo.com</div>
                </div>
                
                <div class="text-center p-10" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl mb-5 opacity-70">📱</div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-500 font-semibold mb-3">Teléfono</div>
                    <div class="text-lg font-semibold text-gray-900">+34 000 000 000</div>
                </div>
            </div>
            
            <div data-aos="fade-up">
                <a href="{{ route('webclubs.contact') }}" class="btn-rounded bg-primary text-white px-12 py-4 font-semibold text-[13px] uppercase tracking-[0.15em] inline-block">
                    Contáctanos
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Initialize Swiper Hero Carousel
        const swiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Counter Animation
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000; // 2 segundos
            const start = 0;
            const increment = target / (duration / 16); // 60fps
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Intersection Observer para detectar cuando la sección es visible
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.counter');
                    counters.forEach((counter, index) => {
                        setTimeout(() => {
                            animateCounter(counter);
                        }, index * 100); // Delay escalonado
                    });
                    observer.unobserve(entry.target); // Solo animar una vez
                }
            });
        }, observerOptions);

        // Observar la sección de estadísticas
        document.addEventListener('DOMContentLoaded', () => {
            const statsSection = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-4');
            if (statsSection) {
                observer.observe(statsSection.parentElement);
            }
        });
        
        // Prevenir scroll automático cuando Livewire actualiza el componente
        document.addEventListener('livewire:init', () => {
            Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                succeed(({ snapshot, effect }) => {
                    // Guardar la posición actual del scroll
                    const scrollPosition = window.scrollY;
                    
                    queueMicrotask(() => {
                        // Restaurar la posición del scroll después de la actualización
                        window.scrollTo(0, scrollPosition);
                        
                        // Reinicializar AOS para los nuevos elementos
                        if (typeof AOS !== 'undefined') {
                            AOS.refresh();
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</div>
