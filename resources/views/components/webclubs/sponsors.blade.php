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
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6 mb-12 md:mb-16">
            @foreach($sponsorsList as $sponsor)
                <div class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 flex items-center justify-center
                            shadow-sm shadow-gray-200/60 hover:shadow-md hover:shadow-gray-200/80
                            hover:border-gray-200 hover:-translate-y-0.5
                            transition-all duration-300 group">
                    @if($sponsor->logo)
                        <a href="{{ $sponsor->web ?: '#' }}"
                           target="{{ $sponsor->web ? '_blank' : '_self' }}"
                           rel="{{ $sponsor->web ? 'noopener noreferrer' : '' }}"
                           class="flex items-center justify-center w-full">
                            <img src="{{ asset('storage/' . $sponsor->logo) }}"
                                 alt="{{ $sponsor->name }}"
                                 class="max-w-full max-h-20 md:max-h-28 object-contain group-hover:scale-105 transition-transform duration-300">
                        </a>
                    @else
                        <div class="text-center">
                            <p class="text-sm font-bold text-gray-800 mb-1">{{ $sponsor->name }}</p>
                            @if($sponsor->web)
                                <a href="{{ $sponsor->web }}" target="_blank" rel="noopener noreferrer"
                                   class="text-xs font-semibold uppercase tracking-wider hover:underline"
                                   style="color: var(--color-primary)">
                                    Ver web
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
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
