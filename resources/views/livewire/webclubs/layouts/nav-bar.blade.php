<!-- Navbar -->
<nav class="bg-white border-b border-gray-100 fixed w-full top-0 z-50">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex items-center space-x-4">
                @if(tenantLogo())
                    <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="h-14 w-auto">
                @endif
                <div>
                    <span class="text-2xl font-bold text-gray-900 tracking-tight block">{{ tenantName() }}</span>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Inicio</a>
                {{-- <a href="{{ route('webclubs.about') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">El Club</a> --}}
                <a href="{{ route('webclubs.tournaments') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Torneos</a>
                {{-- <a href="{{ route('webclubs.contact') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Contacto</a> --}}
                {{-- <a href="{{ route('webclubs.registration') }}" class="bg-primary text-white px-8 py-3 text-sm font-semibold uppercase tracking-wider hover:opacity-90 transition rounded-full">
                    Únete
                </a> --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Login</a>
                @endauth
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-900">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Barra degradada -->
    <div class="h-1" style="background: linear-gradient(to right, var(--color-primary), var(--color-secondary));"></div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="px-6 py-4 space-y-3">
            <a href="{{ route('home') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Inicio</a>
            {{-- <a href="{{ route('webclubs.about') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">El Club</a> --}}
            <a href="{{ route('webclubs.tournaments') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Torneos</a>
            {{-- <a href="{{ route('webclubs.contact') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Contacto</a> --}}
            {{-- <a href="{{ route('webclubs.registration') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Inscríbete</a> --}}
            @auth
                <a href="{{ route('dashboard') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Panel</a>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Login</a>
            @endauth
        </div>
    </div>
</nav>