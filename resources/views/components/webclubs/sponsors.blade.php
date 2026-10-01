@php
    use App\Models\Sponsor;
    use App\Models\Season;

    $school = currentSchool();
    $sponsorsList = collect();

    if ($school) {
        $activeSeason = Season::where('sports_school_id', $school->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($activeSeason) {
            $sponsorsList = Sponsor::where('sports_school_id', $school->id)
                ->where('season_id', $activeSeason->id)
                ->where('published', true)
                ->orderBy('order', 'asc')
                ->get();
        }
    }
@endphp

@push('styles')
<style>
    @keyframes sponsors-float-1 {
        0%   { transform: translate(0, 0) rotate(-2deg); }
        25%  { transform: translate(-15px, -20px) rotate(1deg); }
        50%  { transform: translate(-10px, -30px) rotate(3deg); }
        75%  { transform: translate(5px, -15px) rotate(-1deg); }
        100% { transform: translate(0, 0) rotate(-2deg); }
    }
    @keyframes sponsors-float-2 {
        0%   { transform: translate(0, 0) rotate(1deg); }
        25%  { transform: translate(20px, -10px) rotate(-2deg); }
        50%  { transform: translate(25px, -25px) rotate(-4deg); }
        75%  { transform: translate(10px, -20px) rotate(2deg); }
        100% { transform: translate(0, 0) rotate(1deg); }
    }
    @keyframes sponsors-float-3 {
        0%   { transform: translate(0, 0) rotate(-1deg); }
        25%  { transform: translate(-25px, 15px) rotate(3deg); }
        50%  { transform: translate(-30px, 20px) rotate(2deg); }
        75%  { transform: translate(-15px, 10px) rotate(-2deg); }
        100% { transform: translate(0, 0) rotate(-1deg); }
    }
    .sponsors-float-word-1 { animation: sponsors-float-1 10s ease-in-out infinite; will-change: transform; }
    .sponsors-float-word-2 { animation: sponsors-float-2 12s ease-in-out infinite; will-change: transform; }
    .sponsors-float-word-3 { animation: sponsors-float-3 14s ease-in-out infinite; will-change: transform; }
</style>
@endpush

@if($sponsorsList->count() > 0)
<section class="py-20 md:py-28 relative overflow-hidden border-t border-gray-100">

    {{-- Background watermark (animated, same effect as home) --}}
    <div class="absolute inset-0 pointer-events-none select-none overflow-hidden">
        @php
            $words = explode(' ', tenantName());
            $bgPositions = [
                ['top' => '10%', 'right' => '10%', 'class' => 'sponsors-float-word-1'],
                ['top' => '40%', 'left' => '5%',   'class' => 'sponsors-float-word-2'],
                ['top' => '65%', 'right' => '15%',  'class' => 'sponsors-float-word-3'],
            ];
        @endphp
        @foreach($words as $i => $word)
            @if(isset($bgPositions[$i]))
                <div class="absolute {{ $bgPositions[$i]['class'] }}"
                     style="{{ isset($bgPositions[$i]['top']) ? 'top:'.$bgPositions[$i]['top'].';' : '' }} {{ isset($bgPositions[$i]['bottom']) ? 'bottom:'.$bgPositions[$i]['bottom'].';' : '' }} {{ isset($bgPositions[$i]['left']) ? 'left:'.$bgPositions[$i]['left'].';' : '' }} {{ isset($bgPositions[$i]['right']) ? 'right:'.$bgPositions[$i]['right'].';' : '' }}">
                    <span class="text-[12rem] md:text-[18rem] lg:text-[24rem] font-extrabold leading-none opacity-20 whitespace-nowrap"
                          style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ $word }}
                    </span>
                </div>
            @endif
        @endforeach
    </div>

    <div class="max-w-[1920px] mx-auto px-6 lg:px-12 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-12 md:mb-16">
            <p class="text-xs sm:text-sm md:text-base uppercase tracking-[0.2em] text-black/40 font-semibold mb-4">Colaboradores principales</p>
            <h2 class="section-title text-5xl sm:text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">¡¡Gracias!!</h2>
        </div>

        {{-- Sponsors grid --}}
        {{-- Agrupamos los patrocinadores por type_id y ordenamos (1 primero, 5 al final) --}}
    @php
        $groupedSponsors = collect($sponsorsList)->groupBy('type_id')->sortKeys();
        $typeNames = config('constants.sponsors_type', []);
    @endphp

        {{-- Envolvemos todo en un componente de Alpine.js para gestionar el estado del Modal/Lightbox --}}
        <div x-data="{ lightboxOpen: false, lightboxImg: '', lightboxTitle: '' }" class="space-y-12 md:space-y-16 mb-12 md:mb-16">
            
            @foreach($groupedSponsors as $typeId => $sponsorsGroup)
                @php
                    $type = (int) $typeId;
                    $typeName = $typeNames[$type] ?? 'Otros Patrocinadores';

                    // 1. Columnas de la cuadrícula por grupo
                    $gridClasses = match($type) {
                        1 => 'grid-cols-1 sm:grid-cols-2',                 
                        2 => 'grid-cols-2 sm:grid-cols-3',                 
                        3 => 'grid-cols-2 sm:grid-cols-4 lg:grid-cols-5',  
                        4 => 'grid-cols-3 sm:grid-cols-5 lg:grid-cols-6',  
                        5 => 'grid-cols-4 sm:grid-cols-6 lg:grid-cols-8',  
                        default => 'grid-cols-2 sm:grid-cols-4 lg:grid-cols-6',
                    };

                    // 2. Padding 
                    $padClasses = match($type) {
                        1 => 'p-6 md:p-8',
                        2 => 'p-5 md:p-6',
                        3 => 'p-4',
                        4 => 'p-3',
                        5 => 'p-2',
                        default => 'p-4',
                    };

                    // 3. Altura de la imagen
                    $imgClasses = match($type) {
                        1 => 'h-32 md:h-48', 
                        2 => 'h-24 md:h-32', 
                        3 => 'h-16 md:h-20', 
                        4 => 'h-12 md:h-14', 
                        5 => 'h-10',         
                        default => 'h-16',
                    };

                    // 4. Tamaño de fuente para el texto inferior
                    $textClasses = match($type) {
                        1 => 'text-lg md:text-xl',
                        2 => 'text-base md:text-lg',
                        3 => 'text-xs md:text-sm',
                        4 => 'text-[10px] md:text-xs',
                        5 => 'text-[9px] md:text-[10px]',
                        default => 'text-sm',
                    };
                @endphp

                <div class="sponsor-section">
                    {{-- Título del grupo --}}
                    <h3 class="text-lg md:text-2xl font-black text-gray-800 mb-6 flex items-center gap-3">
                        <span class="w-8 h-1 bg-primary rounded-full"></span>
                        {{-- {{ $typeName }} --}}
                    </h3>

                    {{-- Grid específico para este tamaño --}}
                    <div class="grid gap-3 md:gap-5 {{ $gridClasses }}">
                        @foreach($sponsorsGroup as $sponsor)
                            <div class="bg-white border border-gray-100 rounded-2xl flex flex-col items-center justify-between 
                                        shadow-sm shadow-gray-200/60 hover:shadow-md hover:shadow-gray-200/80 
                                        hover:border-gray-200 hover:-translate-y-0.5 
                                        transition-all duration-300 group h-full {{ $padClasses }}">
                                
                                {{-- ZONA PRINCIPAL: LOGO (Al hacer clic abre el modal) --}}
                                <button type="button" 
                                        @if($sponsor->logo)
                                            @click="lightboxOpen = true; lightboxImg = '{{ asset('storage/' . $sponsor->logo) }}'; lightboxTitle = '{{ $sponsor->name }}'"
                                        @endif
                                        class="flex items-center justify-center w-full flex-1 mb-2 md:mb-3 focus:outline-none cursor-zoom-in">
                                    
                                    @if($sponsor->logo)
                                        <img src="{{ asset('storage/' . $sponsor->logo) }}"
                                            alt="{{ $sponsor->name }}"
                                            class="w-full object-contain group-hover:scale-105 transition-transform duration-300 {{ $imgClasses }}">
                                    @else
                                        <div class="w-full flex items-center justify-center bg-gray-50/50 rounded-xl {{ $imgClasses }} cursor-default">
                                            <span class="text-gray-300 font-bold text-xs">Sin Logo</span>
                                        </div>
                                    @endif
                                </button>
                                
                                {{-- ZONA INFERIOR: NOMBRE Y LINK A LA WEB --}}
                                <div class="text-center w-full mt-auto shrink-0 flex flex-col items-center">
                                    {{-- <p class="font-bold text-gray-800 line-clamp-2 leading-tight {{ $textClasses }}" title="{{ $sponsor->name }}">
                                        {{ $sponsor->name }}
                                    </p> --}}
                                    
                                    @if($sponsor->web)
                                        <a href="{{ $sponsor->web }}" target="_blank" rel="noopener noreferrer"
                                        class="text-[10px] md:text-xs font-semibold uppercase tracking-wider hover:underline mt-1.5 inline-flex items-center gap-1"
                                        style="color: var(--color-primary)">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Visitar web
                                        </a>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- ================= MODAL TIPO LIGHTBOX ================= --}}
            <div x-show="lightboxOpen" style="display: none;" 
                class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4 md:p-10"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @keydown.window.escape="lightboxOpen = false">
                
                {{-- Contenedor interior del Modal --}}
                <div class="relative w-full max-w-5xl flex flex-col items-center justify-center" @click.away="lightboxOpen = false">
                    
                    {{-- Botón Cerrar (Esquina superior derecha) --}}
                    <button @click="lightboxOpen = false" class="absolute -top-12 right-0 md:-right-8 text-gray-400 hover:text-white transition-colors focus:outline-none">
                        <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    {{-- Imagen Ampliada --}}
                    <img :src="lightboxImg" :alt="lightboxTitle" 
                        class="max-w-full max-h-[75vh] object-contain rounded-lg drop-shadow-2xl shadow-black">
                    
                    {{-- Título debajo de la imagen --}}
                    <h4 x-text="lightboxTitle" class="text-white text-xl md:text-3xl font-black mt-6 text-center tracking-wide"></h4>
                </div>
            </div>

        </div>

        {{-- CTA --}}
        <div class="text-center">
            <p class="text-gray-400 text-sm font-semibold uppercase tracking-[0.15em] mb-6">¿Quieres ser patrocinador?</p>
            <a href="{{ route('webclubs.contact') }}"
               class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-sm uppercase tracking-wider transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
               style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                Contacta con nosotros
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</section>
@endif
