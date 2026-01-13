<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Política de Cookies | {{ config('app.name', 'VaedSaas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body { font-family: 'Inter', sans-serif; }
            </style>
        @endif
    </head>
    <body class="bg-gray-50 text-gray-800">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3">
                        <img src="{{ asset('images/logos/logo_vaed.png') }}" alt="{{ config('app.name', 'VaedSaas') }}" class="h-10 sm:h-12 md:h-14">
                        <span class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">VaedSaas</span>
                    </a>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-2 sm:gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-3 py-2 sm:px-4 md:px-6 text-sm sm:text-base text-gray-700 hover:text-indigo-600 transition duration-200 font-medium">
                                    Iniciar Sesión
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="pt-24 pb-16 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl shadow-xl p-8 sm:p-12 mb-8 text-white">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">Política de Cookies</h1>
                            <p class="text-lg text-green-100 mt-2">Última actualización: {{ date('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10 prose prose-lg max-w-none">
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">¿Qué son las Cookies?</h2>
                    <p class="text-gray-700 mb-6">
                        Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo (ordenador, tablet o móvil) cuando visitas un sitio web. Permiten que el sitio web recuerde tus acciones y preferencias durante un período de tiempo, para que no tengas que volver a configurarlas cada vez que regreses.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">¿Cómo Utilizamos las Cookies?</h2>
                    <p class="text-gray-700 mb-6">
                        En VaedSaas utilizamos cookies para mejorar tu experiencia, proporcionarte funcionalidades personalizadas y analizar el uso de nuestro sitio web. Las cookies nos ayudan a:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Mantener tu sesión activa durante tu visita.</li>
                        <li>Recordar tus preferencias y configuraciones.</li>
                        <li>Entender cómo utilizas nuestro sitio web.</li>
                        <li>Mejorar el rendimiento y la seguridad de la plataforma.</li>
                        <li>Personalizar el contenido y las funcionalidades.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Tipos de Cookies que Utilizamos</h2>
                    
                    <!-- Cookie Types Table -->
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Propósito</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b">Duración</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Esenciales
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        Necesarias para el funcionamiento básico del sitio. Permiten la autenticación y navegación.
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">Sesión / 1 año</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Funcionales
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        Recuerdan tus preferencias (idioma, configuración de la interfaz).
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">1 año</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Analíticas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        Nos ayudan a entender cómo los visitantes interactúan con el sitio (páginas visitadas, tiempo de permanencia).
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">2 años</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Publicidad
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        Utilizadas para mostrar anuncios relevantes basados en tus intereses.
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">1-2 años</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookies Específicas que Usamos</h2>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Cookies Propias</h3>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>vaedsaas_session:</strong> Mantiene tu sesión activa (Esencial)</li>
                        <li><strong>XSRF-TOKEN:</strong> Protección contra ataques CSRF (Esencial)</li>
                        <li><strong>cookie_consent:</strong> Almacena tus preferencias de cookies (Esencial)</li>
                        <li><strong>user_preferences:</strong> Guarda tus configuraciones personalizadas (Funcional)</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Cookies de Terceros</h3>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Google Analytics:</strong> Análisis de tráfico y comportamiento (_ga, _gid, _gat)</li>
                        <li><strong>Proveedores de Pago:</strong> Procesamiento seguro de transacciones</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Gestión de Cookies</h2>
                    <p class="text-gray-700 mb-4">
                        Puedes gestionar tus preferencias de cookies en cualquier momento:
                    </p>

                    <div class="bg-green-50 border-l-4 border-green-500 rounded-r-lg p-6 mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3">Desde Nuestro Panel de Cookies</h4>
                        <p class="text-gray-700 mb-4">
                            Puedes modificar tus preferencias haciendo clic en el botón de configuración de cookies en la parte inferior de la página.
                        </p>
                        <button onclick="openCookieSettings()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-semibold">
                            Configurar Cookies
                        </button>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Desde tu Navegador</h3>
                    <p class="text-gray-700 mb-4">
                        También puedes gestionar las cookies directamente desde la configuración de tu navegador:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Chrome:</strong> Configuración → Privacidad y seguridad → Cookies y otros datos de sitios</li>
                        <li><strong>Firefox:</strong> Opciones → Privacidad y seguridad → Cookies y datos de sitios</li>
                        <li><strong>Safari:</strong> Preferencias → Privacidad → Gestionar datos de sitios web</li>
                        <li><strong>Edge:</strong> Configuración → Privacidad, búsqueda y servicios → Cookies</li>
                    </ul>

                    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-r-lg p-6 mb-6">
                        <p class="text-gray-700">
                            <strong>Importante:</strong> Si bloqueas o eliminas las cookies esenciales, algunas funcionalidades de VaedSaas pueden no funcionar correctamente.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookies de Sesión vs Cookies Persistentes</h2>
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-indigo-50 rounded-xl p-6">
                            <h4 class="font-semibold text-gray-900 mb-3">🔄 Cookies de Sesión</h4>
                            <p class="text-gray-700 text-sm">
                                Se eliminan automáticamente cuando cierras el navegador. Utilizadas para mantener tu sesión activa durante la visita.
                            </p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-6">
                            <h4 class="font-semibold text-gray-900 mb-3">💾 Cookies Persistentes</h4>
                            <p class="text-gray-700 text-sm">
                                Permanecen en tu dispositivo durante un tiempo determinado. Utilizadas para recordar preferencias entre visitas.
                            </p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Cambios en la Política de Cookies</h2>
                    <p class="text-gray-700 mb-6">
                        Podemos actualizar esta Política de Cookies ocasionalmente para reflejar cambios en nuestras prácticas o por razones legales. Te notificaremos sobre cambios significativos actualizando la fecha de "Última actualización" al inicio de esta página.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Más Información</h2>
                    <p class="text-gray-700 mb-4">
                        Para más información sobre cómo tratamos tus datos personales, consulta:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><a href="{{ url('/privacy') }}" class="text-green-600 hover:text-green-800 font-semibold">Política de Privacidad</a></li>
                        <li><a href="{{ url('/terms') }}" class="text-green-600 hover:text-green-800 font-semibold">Términos y Condiciones</a></li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Contacto</h2>
                    <div class="bg-green-50 border-l-4 border-green-500 rounded-r-lg p-6">
                        <p class="text-gray-700 mb-2">
                            Si tienes preguntas sobre nuestra Política de Cookies, contáctanos:
                        </p>
                        <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:cookies@vaedsaas.com" class="text-green-600 hover:text-green-800">cookies@vaedsaas.com</a></p>
                        <p class="text-gray-700"><strong>Sitio web:</strong> <a href="{{ url('/') }}" class="text-green-600 hover:text-green-800">{{ url('/') }}</a></p>
                    </div>

                </div>

                <!-- Back Button -->
                <div class="mt-8 text-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="flex flex-wrap justify-center gap-6 mb-4 text-sm">
                    <a href="{{ url('/privacy') }}" class="hover:text-indigo-400 transition">Privacidad</a>
                    <a href="{{ url('/terms') }}" class="hover:text-indigo-400 transition">Términos</a>
                    <a href="{{ url('/cookies') }}" class="hover:text-indigo-400 transition">Cookies</a>
                </div>
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'VaedSaas') }}. Todos los derechos reservados.</p>
            </div>
        </footer>

        <script>
            function openCookieSettings() {
                // This will trigger the cookie consent modal
                if (typeof window.showCookieConsent === 'function') {
                    window.showCookieConsent();
                }
            }
        </script>
    </body>
</html>
