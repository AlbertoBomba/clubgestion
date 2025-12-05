<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                {{-- @if(auth()->user()->sportsSchool && auth()->user()->sportsSchool->logo)
                    <div class="w-12 h-12 bg-white-pure rounded-xl flex items-center justify-center shadow-lg border border-primary/20 p-2">
                        <img src="{{ asset('storage/' . auth()->user()->sportsSchool->logo) }}" alt="{{ auth()->user()->sportsSchool->name }}" class="w-full h-full object-contain">
                    </div>
                @endif --}}
                <h2 class="font-bold text-2xl text-titanium leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <div class="text-sm text-gray-600">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ date('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Stats Grid -->
            @if(!auth()->user()->hasRole('school_admin'))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="card-modern bg-white-pure rounded-2xl shadow-lg p-6 border border-primary/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-titanium mb-1">Total Usuarios</p>
                            <p class="text-3xl font-bold text-black-deep">1,234</p>
                            <p class="text-sm text-neon-green mt-2">
                                <span class="font-semibold">↑ 12%</span> vs mes anterior
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-primary to-night-blue rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="card-modern bg-white-pure rounded-2xl shadow-lg p-6 border border-primary/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-titanium mb-1">Ventas</p>
                            <p class="text-3xl font-bold text-black-deep">€5,678</p>
                            <p class="text-sm text-neon-green mt-2">
                                <span class="font-semibold">↑ 8%</span> vs mes anterior
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-neon-green to-neon-green rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="card-modern bg-white-pure rounded-2xl shadow-lg p-6 border border-primary/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-titanium mb-1">Proyectos</p>
                            <p class="text-3xl font-bold text-black-deep">42</p>
                            <p class="text-sm text-neon-green mt-2">
                                <span class="font-semibold">↑ 5</span> este mes
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-night-blue to-primary rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="card-modern bg-white-pure rounded-2xl shadow-lg p-6 border border-primary/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-titanium mb-1">Tareas Pendientes</p>
                            <p class="text-3xl font-bold text-black-deep">18</p>
                            <p class="text-sm text-neon-green mt-2">
                                <span class="font-semibold">3</span> urgentes
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-neon-green to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Charts Grid (Only for school_admin) -->
            @if(auth()->user()->hasRole('school_admin') && auth()->user()->sports_school_id)
            
            <!-- Quick Access Links -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <a href="{{ route('seasons.index') }}" class="group card-modern bg-white-pure rounded-xl shadow-lg p-4 border border-primary/10 hover:border-primary hover:shadow-xl transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-night-blue rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-titanium text-sm">Temporadas</p>
                            <p class="text-xs text-gray-500">Ver todas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('teams.index') }}" class="group card-modern bg-white-pure rounded-xl shadow-lg p-4 border border-primary/10 hover:border-primary hover:shadow-xl transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-neon-green to-green-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-titanium text-sm">Equipos</p>
                            <p class="text-xs text-gray-500">Ver todos</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('players.index') }}" class="group card-modern bg-white-pure rounded-xl shadow-lg p-4 border border-primary/10 hover:border-primary hover:shadow-xl transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-night-blue to-purple-600 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-titanium text-sm">Jugadores</p>
                            <p class="text-xs text-gray-500">Ver todos</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('training-schedule.index') }}" class="group card-modern bg-white-pure rounded-xl shadow-lg p-4 border border-primary/10 hover:border-primary hover:shadow-xl transition-all">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-titanium text-sm">Horarios</p>
                            <p class="text-xs text-gray-500">Planificar</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Players Per Season Chart -->
                <div class="h-full">
                    <livewire:dashboard.players-per-season-chart />
                </div>
                
                <!-- Teams Per Season Chart -->
                <div class="h-full">
                    <livewire:dashboard.teams-per-season-chart />
                </div>
            </div>
            @endif

            <!-- Main Content Card -->
            {{-- <div class="card-modern bg-white-pure rounded-2xl shadow-xl overflow-hidden border border-primary/10">
                <x-welcome />
            </div> --}}
        </div>
    </div>
</x-app-layout>
