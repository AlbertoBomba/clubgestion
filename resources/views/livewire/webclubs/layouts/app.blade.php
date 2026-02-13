<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? tenantName() }}</title>
    <meta name="description" content="{{ $description ?? tenantName() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: {{ currentSchool()?->primary_color ?? '#1E40AF' }};
            --color-secondary: {{ currentSchool()?->secondary_color ?? '#10B981' }};
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        /* Clases utility para usar los colores dinámicos */
        .bg-primary { background-color: var(--color-primary) !important; }
        .bg-secondary { background-color: var(--color-secondary) !important; }
        .text-primary { color: var(--color-primary) !important; }
        .text-secondary { color: var(--color-secondary) !important; }
        .border-primary { border-color: var(--color-primary) !important; }
        .border-secondary { border-color: var(--color-secondary) !important; }
        .hover\:bg-primary:hover { background-color: var(--color-primary) !important; }
        .hover\:bg-secondary:hover { background-color: var(--color-secondary) !important; }
        .hover\:text-primary:hover { color: var(--color-primary) !important; }
        .hover\:text-secondary:hover { color: var(--color-secondary) !important; }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased bg-white text-gray-900">
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
                    <a href="{{ route('webclubs.about') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">El Club</a>
                    <a href="{{ route('webclubs.contact') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider transition">Contacto</a>
                    <a href="{{ route('webclubs.registration') }}" class="bg-primary text-white px-8 py-3 text-sm font-semibold uppercase tracking-wider hover:opacity-90 transition rounded-full">
                        Únete
                    </a>
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
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="px-6 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Inicio</a>
                <a href="{{ route('webclubs.about') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">El Club</a>
                <a href="{{ route('webclubs.contact') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Contacto</a>
                <a href="{{ route('webclubs.registration') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Inscríbete</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Panel</a>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-gray-900 font-medium text-sm uppercase tracking-wider">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Spacer for fixed navbar -->
    <div class="h-24"></div>

    <!-- Contenido Principal -->
    @isset($slot)
        {{ $slot }}
    @else
        @yield('content')
    @endisset

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
        
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-12 mt-16">
        <div class="max-wy-900 text-white py-20 mt-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Info de Contacto -->
                <div class="md:col-span-2">
                    @if(tenantLogo())
                        <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="h-12 w-auto mb-6 brightness-0 invert">
                    @endif
                    <h3 class="text-2xl font-bold mb-6">{{ tenantName() }}</h3>
                    @if($school = currentSchool())
                        <div class="space-y-3 text-gray-400">
                            <p>{{ $school->email }}</p>
                            <p>{{ $school->phone }}</p>
                            <p>{{ $school->address }}</p>
                            <p>{{ $school->city }}, {{ $school->province }} {{ $school->postal_code }}</p>
                        </div>
                    @endif
                </div>
                
                <!-- Enlaces Rápidos -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider mb-6">Enlaces</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('webclubs.about') }}" class="text-gray-400 hover:text-white transition text-sm">Sobre Nosotros</a></li>
                        <li><a href="{{ route('webclubs.contact') }}" class="text-gray-400 hover:text-white transition text-sm">Contacto</a></li>
                        <li><a href="{{ route('webclubs.registration') }}" class="text-gray-400 hover:text-white transition text-sm">Inscripción</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition text-sm">Privacidad</a></li>
                    </ul>
                </div>
                
                <!-- Redes Sociales -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider mb-6">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} {{ tenantName() }}. Todos los derechos reservados.</p>
                    <p class="mt-2 md:mt-0">Powered by VAED Sports Portal</p>
                </div
        </div>
    </footer>
</body>
</html>
