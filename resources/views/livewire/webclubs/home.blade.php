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
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-20 text-center">
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="text-7xl md:text-8xl font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="{{ $players }}">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Jugadores</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="text-7xl md:text-8xl font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="{{ $teams }}">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Equipos</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="text-7xl md:text-8xl font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="{{ $coaches }}">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Entrenadores</div>
                </div>
                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="text-7xl md:text-8xl font-bold text-gray-900 mb-6 leading-none">
                        <span class="counter" data-target="80">0</span>
                    </div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-semibold">Años</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Próximos Partidos -->
    <section class="py-40 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-20">
                <h2 class="text-[13px] uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5">[01] Calendario</h2>
                <h3 class="section-title text-5xl md:text-7xl font-bold text-gray-900">Próximos Partidos</h3>
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
                            <div class="p-6 md:p-8">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                    <!-- Fecha -->
                                    <div class="md:col-span-2 text-center md:text-left">
                                        <div class="inline-block md:block bg-gray-50 rounded-xl p-4 group-hover:bg-primary/5 transition-colors duration-300">
                                            <div class="text-[9px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-1">
                                                {{ $match->date->locale('es')->translatedFormat('l') }}
                                            </div>
                                            <div class="text-4xl font-extrabold bg-gradient-to-br from-gray-900 to-gray-700 bg-clip-text text-transparent leading-none mb-2">
                                                {{ $match->date->format('d') }}
                                            </div>
                                            <div class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-bold">
                                                {{ $match->date->locale('es')->translatedFormat('M Y') }}
                                            </div>
                                            <div class="mt-2 pt-2 border-t border-gray-200">
                                                <div class="text-base font-bold text-primary">
                                                    {{ $match->hour_match ? $match->hour_match->format('H:i') : '--:--' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Información del Partido -->
                                    <div class="md:col-span-8">
                                        @if($match->team && $match->team->category)
                                            <div class="mb-3">
                                                <span class="bg-gradient-to-r from-primary to-black text-white text-[9px] font-bold px-4 py-1.5 uppercase tracking-[0.2em] inline-block rounded-full shadow-lg">
                                                    {{ $match->team->category->name ?? 'Partido' }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center justify-center gap-6">
                                            @if($match->sites === 'home')
                                                <!-- Escuela como Local (izquierda) -->
                                                <div class="flex items-center gap-3 flex-1 justify-end">
                                                    <div class="text-right">
                                                        <div class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300">
                                                            {{ $match->team ? $match->team->team : tenantName() }}
                                                        </div>
                                                        <div class="text-[9px] uppercase tracking-[0.15em] text-gray-400 font-semibold mt-0.5">
                                                            Local
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
                                                        <div class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-secondary transition-colors duration-300">
                                                            {{ $match->opponent }}
                                                        </div>
                                                        <div class="text-[9px] uppercase tracking-[0.15em] text-gray-400 font-semibold mt-0.5">
                                                            Visitante
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Oponente como Local (izquierda) -->
                                                <div class="flex items-center gap-3 flex-1 justify-end">
                                                    <div class="text-right">
                                                        <div class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-secondary transition-colors duration-300">
                                                            {{ $match->opponent }}
                                                        </div>
                                                        <div class="text-[9px] uppercase tracking-[0.15em] text-gray-400 font-semibold mt-0.5">
                                                            Local
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
                                                        <div class="text-lg md:text-xl font-bold text-gray-900 group-hover:text-primary transition-colors duration-300">
                                                            {{ $match->team ? $match->team->team : tenantName() }}
                                                        </div>
                                                        <div class="text-[9px] uppercase tracking-[0.15em] text-gray-400 font-semibold mt-0.5">
                                                            Visitante
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Ubicación -->
                                    <div class="md:col-span-2 text-center md:text-right">
                                        <div class="inline-block">
                                            <div class="text-[9px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-2">
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
                                                <div class="text-xs font-bold text-gray-700 leading-tight">
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
    <section class="py-40 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-[13px] uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5" data-aos="fade-up">[02] Resultados</h2>
            <h3 class="section-title text-5xl md:text-7xl font-bold mb-20 text-gray-900" data-aos="fade-up">Últimos Partidos</h3>
            
            @if($recentResults->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentResults->take(3) as $index => $result)
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
                        
                        <div class="bg-white overflow-hidden group cursor-pointer card-hover" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}" wire:key="result-{{ $result->id }}">
                            <!-- Imagen redondeada -->
                            <div class="relative h-72 overflow-hidden rounded-3xl">
                                <img src="{{ $backgroundImage }}" alt="{{ $result->team ? $result->team->team : tenantName() }} vs {{ $result->opponent }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            
                            <!-- Contenido debajo de la imagen -->
                            <div class="py-8">
                                <!-- Badge del tipo de resultado -->
                                <div class="mb-5">
                                    @if($resultInfo['type'] === 'Victoria')
                                        <span class="bg-secondary text-white text-[11px] font-semibold px-5 py-2 uppercase tracking-[0.15em] inline-block rounded-full">
                                            Victoria
                                        </span>
                                    @elseif($resultInfo['type'] === 'Derrota')
                                        <span class="bg-red-600 text-white text-[11px] font-semibold px-5 py-2 uppercase tracking-[0.15em] inline-block rounded-full">
                                            Derrota
                                        </span>
                                    @else
                                        <span class="bg-primary text-white text-[11px] font-semibold px-5 py-2 uppercase tracking-[0.15em] inline-block rounded-full">
                                            Empate
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Marcador -->
                                <div class="mb-5">
                                    <div class="text-5xl font-bold text-gray-900 mb-3 leading-none">
                                        {{ $goalsTeam }} - {{ $goalsOponent }}
                                    </div>
                                    <div class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $result->team ? $result->team->team : tenantName() }} vs {{ $result->opponent }}
                                    </div>
                                    @if($result->team && $result->team->category)
                                        <div class="text-sm text-gray-500 font-medium">
                                            {{ $result->team->category->name }}
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Fecha -->
                                <div class="text-[12px] text-gray-400 uppercase tracking-[0.12em] font-medium">
                                    {{ $result->date->locale('es')->translatedFormat('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20" data-aos="fade-up">
                    <div class="text-7xl mb-8 opacity-50">🏆</div>
                    <p class="text-lg text-gray-400 uppercase tracking-[0.15em] font-medium">No hay resultados recientes</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Nuestros Patrocinadores -->
    <section class="py-40 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-[13px] uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5 text-center" data-aos="fade-up">[03] Colaboran con Nosotros</h2>
            <h3 class="section-title text-5xl md:text-7xl font-bold mb-20 text-gray-900 text-center" data-aos="fade-up">Nuestros Patrocinadores</h3>
            
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
                <h2 class="text-[13px] uppercase tracking-[0.2em] text-gray-400 font-semibold mb-5">[04] Únete a Nosotros</h2>
                <h3 class="section-title text-5xl md:text-7xl font-bold mb-10">Hazte Socio</h3>
                <p class="text-xl md:text-2xl font-light text-gray-400 max-w-3xl mx-auto leading-relaxed">
                    Disfruta de beneficios exclusivos y forma parte de nuestra comunidad deportiva
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-24">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-6xl md:text-7xl font-bold mb-8 text-gray-300">01</div>
                    <div class="h-px bg-gray-700 mb-8"></div>
                    <h4 class="text-xl font-semibold mb-5 uppercase tracking-[0.15em]">Descuentos</h4>
                    <p class="text-gray-400 text-base leading-relaxed">Acceso a precios especiales en equipación y eventos</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-6xl md:text-7xl font-bold mb-8 text-gray-300">02</div>
                    <div class="h-px bg-gray-700 mb-8"></div>
                    <h4 class="text-xl font-semibold mb-5 uppercase tracking-[0.15em]">Eventos</h4>
                    <p class="text-gray-400 text-base leading-relaxed">Invitaciones exclusivas a eventos del club</p>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-6xl md:text-7xl font-bold mb-8 text-gray-300">03</div>
                    <div class="h-px bg-gray-700 mb-8"></div>
                    <h4 class="text-xl font-semibold mb-5 uppercase tracking-[0.15em]">Prioridad</h4>
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
            <h2 class="text-[13px] uppercase tracking-[0.2em] text-gray-500 font-semibold mb-5" data-aos="fade-up">[05] Contacto</h2>
            <h3 class="section-title text-5xl md:text-7xl font-bold mb-16 text-gray-900" data-aos="fade-up">¿Tienes Preguntas?</h3>
            
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
                    });
                });
            });
        });
    </script>
    @endpush
</div>
