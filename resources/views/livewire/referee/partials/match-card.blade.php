<a href="{{ route('referee.match.manage', $match) }}" 
   wire:navigate
   class="card-tap block bg-white rounded-2xl p-4 shadow-sm border {{ $live ?? false ? 'border-red-200 bg-red-50/30' : 'border-gray-100' }} hover:shadow-md transition-shadow">
    
    <!-- Match Header -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
            @if($match->phase)
                <span class="text-xs font-bold text-gray-500 uppercase">{{ $match->phase->name }}</span>
            @endif
            @if($match->round)
                <span class="text-xs font-semibold text-gray-400">Jornada {{ $match->round }}</span>
            @endif
        </div>
        @if($live ?? false)
            <span class="flex items-center gap-1 text-xs font-bold text-red-600 bg-red-100 px-2 py-1 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                EN VIVO
            </span>
        @endif
    </div>

    <!-- Teams -->
    <div class="space-y-3 mb-3">
        <!-- Home Team -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                @if($match->homeTeam?->logo)
                    <img src="{{ asset('storage/' . $match->homeTeam->logo) }}" 
                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0" 
                         alt="">
                @elseif($match->homeTeam?->team?->logo)
                    <img src="{{ asset('storage/' . $match->homeTeam->team->logo) }}" 
                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0" 
                         alt="">
                @else
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                        <span class="text-xs font-bold text-gray-500">{{ substr($match->homeTeam?->displayName() ?? 'TBD', 0, 1) }}</span>
                    </div>
                @endif
                <span class="font-bold text-gray-900 truncate">{{ $match->homeTeam?->displayName() ?? 'Por definir' }}</span>
            </div>
            @if($match->status === 'completed')
                <span class="text-2xl font-black {{ $match->home_score > $match->away_score ? 'text-green-600' : 'text-gray-400' }}">
                    {{ $match->home_score ?? 0 }}
                </span>
            @endif
        </div>

        <!-- VS Separator -->
        <div class="flex items-center gap-2">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs font-bold text-gray-400">VS</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- Away Team -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 flex-1 min-w-0">
                @if($match->awayTeam?->logo)
                    <img src="{{ asset('storage/' . $match->awayTeam->logo) }}" 
                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0" 
                         alt="">
                @elseif($match->awayTeam?->team?->logo)
                    <img src="{{ asset('storage/' . $match->awayTeam->team->logo) }}" 
                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0" 
                         alt="">
                @else
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                        <span class="text-xs font-bold text-gray-500">{{ substr($match->awayTeam?->displayName() ?? 'TBD', 0, 1) }}</span>
                    </div>
                @endif
                <span class="font-bold text-gray-900 truncate">{{ $match->awayTeam?->displayName() ?? 'Por definir' }}</span>
            </div>
            @if($match->status === 'completed')
                <span class="text-2xl font-black {{ $match->away_score > $match->home_score ? 'text-green-600' : 'text-gray-400' }}">
                    {{ $match->away_score ?? 0 }}
                </span>
            @endif
        </div>
    </div>

    <!-- Match Info -->
    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
        <div class="flex items-center gap-4 text-xs">
            @if($match->scheduled_at)
                <div class="flex items-center gap-1 text-gray-600">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">{{ $match->scheduled_at->format('d/m H:i') }}</span>
                </div>
            @endif
            @if($match->location)
                <div class="flex items-center gap-1 text-gray-600 truncate">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <span class="font-medium truncate">{{ $match->location }}</span>
                </div>
            @endif
        </div>
        
        <!-- Action Icon -->
        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </div>
</a>
