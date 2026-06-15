<div>
    <x-slot name="title">{{ $tournament->name }}</x-slot>
    <x-slot name="subtitle">Partidos</x-slot>
    <x-slot name="backUrl">{{ route('referee.dashboard') }}</x-slot>
    <x-slot name="bottomNav">{{ true }}</x-slot>

    <!-- Tournament Info Header -->
    <div class="bg-gradient-to-br from-primary to-blue-600 px-4 py-6">
        <div class="flex items-center gap-4 mb-4">
            @if($tournament->logo)
                <img src="{{ asset('storage/' . $tournament->logo) }}" 
                     class="w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-lg" 
                     alt="{{ $tournament->name }}">
            @else
                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center border-2 border-white shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-black text-white mb-1">{{ $tournament->name }}</h2>
                @if($tournament->location)
                    <p class="text-sm text-white/80 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $tournament->location }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-3 gap-2">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 text-center border border-white/20">
                <p class="text-2xl font-black text-white">{{ $stats['in_progress'] }}</p>
                <p class="text-xs font-semibold text-white/80">En Curso</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 text-center border border-white/20">
                <p class="text-2xl font-black text-white">{{ $stats['scheduled'] }}</p>
                <p class="text-xs font-semibold text-white/80">Programados</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 text-center border border-white/20">
                <p class="text-2xl font-black text-white">{{ $stats['completed'] }}</p>
                <p class="text-xs font-semibold text-white/80">Completados</p>
            </div>
        </div>
    </div>

    @if(!empty($rounds))
        <!-- Round Navigation -->
        <div class="bg-white border-b border-gray-200 sticky top-16 z-40">
            <div class="px-4 py-3">
                <div 
                    x-data="{
                        isDragging: false,
                        startX: 0,
                        scrollLeft: 0,
                        handleMouseDown(e) {
                            this.isDragging = true;
                            this.startX = e.pageX - this.$el.offsetLeft;
                            this.scrollLeft = this.$el.scrollLeft;
                        },
                        handleTouchStart(e) {
                            this.isDragging = true;
                            this.startX = e.touches[0].pageX - this.$el.offsetLeft;
                            this.scrollLeft = this.$el.scrollLeft;
                        },
                        handleMouseMove(e) {
                            if (!this.isDragging) return;
                            e.preventDefault();
                            const x = e.pageX - this.$el.offsetLeft;
                            const walk = (x - this.startX) * 2;
                            this.$el.scrollLeft = this.scrollLeft - walk;
                        },
                        handleTouchMove(e) {
                            if (!this.isDragging) return;
                            const x = e.touches[0].pageX - this.$el.offsetLeft;
                            const walk = (x - this.startX) * 2;
                            this.$el.scrollLeft = this.scrollLeft - walk;
                        },
                        handleMouseUp() {
                            this.isDragging = false;
                        }
                    }"
                    @mousedown="handleMouseDown"
                    @touchstart="handleTouchStart"
                    @mousemove="handleMouseMove"
                    @touchmove="handleTouchMove"
                    @mouseup="handleMouseUp"
                    @mouseleave="handleMouseUp"
                    @touchend="handleMouseUp"
                    class="flex items-center gap-2 overflow-x-auto cursor-grab active:cursor-grabbing select-none"
                    style="scrollbar-width: none; -ms-overflow-style: none;"
                >
                    <style>
                        .overflow-x-auto::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    @foreach($rounds as $round)
                        <button 
                            wire:click="selectRound({{ $round }})"
                            class="shrink-0 w-10 h-10 rounded-full font-bold text-sm transition-all {{ $selectedRound === $round ? 'bg-primary text-white shadow-md scale-110' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                        >
                            {{ $round }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Matches List -->
    <div class="px-4 py-4 pb-24">
        @if($matches->isNotEmpty())
            <div class="mb-3">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Jornada {{ $selectedRound }}</h3>
            </div>
            <div class="space-y-3">
                @foreach($matches as $match)
                    @include('livewire.referee.partials.match-card', ['match' => $match, 'live' => $match->status === 'in_progress'])
                @endforeach
            </div>
        @elseif(!empty($rounds))
            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No hay partidos en esta jornada</h3>
                <p class="text-sm text-gray-500">Selecciona otra jornada para ver los partidos.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No hay partidos</h3>
                <p class="text-sm text-gray-500">Este torneo aún no tiene partidos programados.</p>
            </div>
        @endif
    </div>
</div>
