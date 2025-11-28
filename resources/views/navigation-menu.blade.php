<nav x-data="{ open: false, sidebarOpen: false }" class="glass-effect border-b border-primary/10 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                @if(auth()->user()->sportsSchool)
                    <!-- Botón Sidebar para Back2 (usuarios de escuela, incluso si están siendo suplantados) -->
                    <div class="flex items-center mr-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-titanium hover:bg-primary/10 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        @if(auth()->user()->sportsSchool && auth()->user()->sportsSchool->logo)
                            <div class="w-10 h-10 bg-white-pure rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110 border border-primary/20 p-1">
                                <img src="{{ asset('storage/' . auth()->user()->sportsSchool->logo) }}" alt="{{ auth()->user()->sportsSchool->name }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-night-blue rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="text-xl font-bold bg-gradient-to-r from-primary to-night-blue bg-clip-text text-transparent hidden lg:block">
                            @if(auth()->user()->sportsSchool && !auth()->user()->isMaster())
                                {{ auth()->user()->sportsSchool->name }}
                            @else
                                {{ config('app.name', 'Trevion APP') }}
                            @endif
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Solo para Back1 - Master sin suplantar O suplantando a otro Master) -->
                @if(auth()->user()->isMaster() && !auth()->user()->sportsSchool)
                    <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{ route('dashboard') }}" class="sidebar-link inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'active text-white-pure' : 'text-titanium' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>

                        {{-- Menú del Master (Back 1) --}}
                        <a href="{{ route('sports-schools.index') }}" class="sidebar-link inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('sports-schools.*') ? 'active text-white-pure' : 'text-titanium' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Escuelas
                        </a>

                        <a href="{{ route('school-users.index') }}" class="sidebar-link inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('school-users.*') ? 'active text-white-pure' : 'text-titanium' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Usuarios
                        </a>
                    </div>
                @endif
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-lg">
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-primary/20 text-sm leading-4 font-medium rounded-lg text-titanium bg-white-pure hover:bg-primary/5 focus:outline-none focus:ring-2 focus:ring-primary transition ease-in-out duration-150 shadow-sm">
                                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-primary font-semibold uppercase tracking-wider">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-primary/10"></div>

                                        <div class="block px-4 py-2 text-xs text-primary font-semibold uppercase tracking-wider">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex items-center text-sm border-2 border-primary/20 rounded-full focus:outline-none focus:border-primary transition hover:border-primary/50">
                                    <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-lg">
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-primary/20 text-sm leading-4 font-medium rounded-lg text-titanium bg-white-pure hover:bg-primary/5 focus:outline-none focus:ring-2 focus:ring-primary transition ease-in-out duration-150 shadow-sm">
                                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-primary font-semibold uppercase tracking-wider">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('Profile') }}
                                </div>
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                        {{ __('API Tokens') }}
                                    </div>
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-primary/10"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    <div class="flex items-center text-red-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-titanium hover:text-primary hover:bg-primary/5 focus:outline-none focus:ring-2 focus:ring-primary transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white-pure/95 backdrop-blur-lg border-t border-primary/10">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('dashboard') ? 'active text-white-pure' : 'text-titanium' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </div>
            </a>

            @if(auth()->user()->isMaster() || session()->has('impersonator_id'))
                {{-- Menú del Master móvil (Back 1) - también visible cuando suplanta --}}
                <a href="{{ route('sports-schools.index') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('sports-schools.*') ? 'active text-white-pure' : 'text-titanium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Escuelas Deportivas
                    </div>
                </a>

                <a href="{{ route('school-users.index') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('school-users.*') ? 'active text-white-pure' : 'text-titanium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Usuarios de Escuelas
                    </div>
                </a>
            @elseif(auth()->user()->sportsSchool && !session()->has('impersonator_id'))
                {{-- Menú de usuarios de escuela móvil (Back 2) --}}
                <a href="{{ route('my-school-users.index', ['filterSchool' => auth()->user()->sports_school_id]) }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('my-school-users.*') ? 'active text-white-pure' : 'text-titanium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Usuarios
                    </div>
                </a>

                <a href="{{ route('categories.index') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('categories.*') ? 'active text-white-pure' : 'text-titanium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Categorías
                    </div>
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-primary/10">
            <div class="flex items-center px-4 py-3 bg-gradient-to-r from-gray-50 to-primary/5 rounded-lg mx-2">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-12 rounded-full object-cover border-2 border-primary/20" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-semibold text-base text-black-deep">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-primary">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <a href="{{ route('profile.show') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('profile.show') ? 'active text-white-pure' : 'text-titanium' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('Profile') }}
                    </div>
                </a>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <a href="{{ route('api-tokens.index') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('api-tokens.index') ? 'active text-white-pure' : 'text-titanium' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            {{ __('API Tokens') }}
                        </div>
                    </a>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <a href="{{ route('logout') }}"
                               @click.prevent="$root.submit();"
                               class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium text-red-600 hover:bg-red-50 hover:text-red-700">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Log Out') }}
                        </div>
                    </a>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-primary/10 my-2"></div>

                    <div class="block px-4 py-2 text-xs text-primary font-semibold uppercase tracking-wider">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('teams.show') ? 'active text-white-pure' : 'text-titanium' }}">
                        {{ __('Team Settings') }}
                    </a>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <a href="{{ route('teams.create') }}" class="sidebar-link block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('teams.create') ? 'active text-white-pure' : 'text-titanium' }}">
                            {{ __('Create New Team') }}
                        </a>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-primary/10 my-2"></div>

                        <div class="block px-4 py-2 text-xs text-primary font-semibold uppercase tracking-wider">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar para Back2 (usuarios de escuela, incluso si están siendo suplantados) -->
    @if(auth()->user()->sportsSchool)
        <!-- Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black-deep bg-opacity-50 z-40"
             style="display: none;">
        </div>

        <!-- Sidebar Panel -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed top-0 bottom-0 left-0 w-64 bg-white-pure shadow-2xl z-50 overflow-y-auto flex flex-col"
             style="display: none; height: 100vh;">
            
            <!-- Sidebar Header -->
            <div class="p-6 bg-gradient-to-r from-primary to-night-blue flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-white-pure font-bold text-lg">Menú</h3>
                    <button @click="sidebarOpen = false" class="text-white-pure hover:text-silver">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Sidebar Menu Items -->
            <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-titanium hover:bg-primary/5 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('my-school-users.index', ['filterSchool' => auth()->user()->sports_school_id]) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-titanium hover:bg-primary/5 rounded-lg transition-colors duration-200 {{ request()->routeIs('my-school-users.*') ? 'bg-primary/10 text-primary font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Usuarios
                </a>

                <a href="{{ route('categories.index') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center px-4 py-3 text-titanium hover:bg-primary/5 rounded-lg transition-colors duration-200 {{ request()->routeIs('categories.*') ? 'bg-primary/10 text-primary font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Categorías
                </a>
            </nav>
        </div>
    @endif
</nav>
