<div>
    @section('title', 'Mis Torneos')

    <x-slot name="title">Mis Torneos</x-slot>
    <x-slot name="subtitle">Árbitro</x-slot>
    <x-slot name="bottomNav">{{ true }}</x-slot>

    <!-- Stats Cards -->
    <div class="p-4 space-y-3">
        <div class="grid grid-cols-2 gap-3">
            <!-- Torneos -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-2xl font-black text-gray-900">{{ $stats['total_tournaments'] }}</p>
                        <p class="text-xs font-semibold text-gray-500">Torneos</p>
                    </div>
                </div>
            </div>

            <!-- Partidos -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-2xl font-black text-gray-900">{{ $stats['completed_matches'] }}</p>
                        <p class="text-xs font-semibold text-gray-500">Completados</p>
                    </div>
                </div>
            </div>

            <!-- Pendientes -->
            <div class="col-span-2 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-4 border border-orange-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-black text-orange-900">{{ $stats['pending_matches'] }}</p>
                        <p class="text-sm font-bold text-orange-700">Partidos Pendientes</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-orange-500 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tournaments List -->
    <div class="px-4 pb-24">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-bold text-gray-900">Mis Torneos</h2>
            @if($tournaments->count() > 0)
                <span class="text-sm font-semibold text-gray-500">{{ $tournaments->count() }}</span>
            @endif
        </div>

        @if($tournaments->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No tienes torneos asignados</h3>
                <p class="text-sm text-gray-500">Cuando te asignen a un torneo, aparecerá aquí.</p>
            </div>
        @else
            <!-- Tournament Cards -->
            <div class="space-y-3">
                @foreach($tournaments as $tournament)
                    <a href="{{ route('referee.tournament.matches', $tournament) }}" 
                       wire:navigate
                       class="card-tap block bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-3">
                            <!-- Tournament Logo -->
                            @if($tournament->logo)
                                <img src="{{ asset('storage/' . $tournament->logo) }}" 
                                     class="w-14 h-14 rounded-xl object-cover border border-gray-200 shrink-0" 
                                     alt="{{ $tournament->name }}">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary/20 to-blue-500/20 flex items-center justify-center shrink-0 border border-primary/20">
                                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 mb-1 truncate">{{ $tournament->name }}</h3>
                                
                                @if($tournament->sportsSchool)
                                    <p class="text-xs text-gray-500 mb-2 truncate">{{ $tournament->sportsSchool->name }}</p>
                                @endif

                                <!-- Dates -->
                                @if($tournament->start_date)
                                    <div class="flex items-center gap-1 text-xs text-gray-600 mb-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="font-medium">{{ $tournament->start_date->format('d/m/Y') }}</span>
                                        @if($tournament->end_date)
                                            <span>-</span>
                                            <span class="font-medium">{{ $tournament->end_date->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Match stats -->
                                <div class="flex items-center gap-3">
                                    @php
                                        $totalMatches = $tournament->matches->count();
                                        $completedMatches = $tournament->matches->where('status', 'completed')->count();
                                        $pendingMatches = $tournament->matches->whereIn('status', ['scheduled', 'in_progress'])->count();
                                    @endphp
                                    
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-bold text-green-600">{{ $completedMatches }}</span>
                                        <span class="text-xs text-gray-500">completados</span>
                                    </div>
                                    
                                    @if($pendingMatches > 0)
                                        <div class="flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                            <span class="text-xs font-bold text-orange-600">{{ $pendingMatches }}</span>
                                            <span class="text-xs text-gray-500">pendientes</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Arrow -->
                            <svg class="w-5 h-5 text-gray-400 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
