<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Términos y Condiciones | {{ config('app.name', 'VaedSaas') }}</title>

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
                <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl shadow-xl p-8 sm:p-12 mb-8 text-white">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Términos y Condiciones</h1>
                    <p class="text-lg text-blue-100">Última actualización: {{ date('d/m/Y') }}</p>
                </div>

                <!-- Content Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10 prose prose-lg max-w-none">
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-lg p-6 mb-8">
                        <p class="text-gray-700">
                            <strong>Importante:</strong> Por favor, lee estos términos cuidadosamente antes de utilizar VaedSaas. Al acceder o usar nuestro servicio, aceptas estar vinculado por estos términos.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Aceptación de los Términos</h2>
                    <p class="text-gray-700 mb-6">
                        Al registrarte y utilizar VaedSaas, aceptas cumplir con estos Términos y Condiciones, así como con nuestra <a href="{{ url('/privacy') }}" class="text-blue-600 hover:text-blue-800">Política de Privacidad</a>. Si no estás de acuerdo con alguna parte de estos términos, no debes utilizar nuestros servicios.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Descripción del Servicio</h2>
                    <p class="text-gray-700 mb-4">
                        VaedSaas es una plataforma SaaS (Software como Servicio) diseñada para facilitar la gestión de clubes deportivos, escuelas de fútbol y organizaciones deportivas amateurs. Nuestros servicios incluyen:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Gestión de equipos y jugadores</li>
                        <li>Organización de entrenamientos y convocatorias</li>
                        <li>Sistema de pagos y cuotas</li>
                        <li>Tienda online del club con comisiones</li>
                        <li>Comunicación interna</li>
                        <li>Estadísticas y reportes</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Registro y Cuenta de Usuario</h2>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">3.1 Requisitos</h3>
                    <p class="text-gray-700 mb-4">
                        Para utilizar VaedSaas, debes:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Tener al menos 18 años o contar con el consentimiento de un tutor legal.</li>
                        <li>Proporcionar información precisa y actualizada durante el registro.</li>
                        <li>Mantener la seguridad de tu contraseña y cuenta.</li>
                        <li>Notificarnos inmediatamente sobre cualquier uso no autorizado de tu cuenta.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 mb-3">3.2 Responsabilidad de la Cuenta</h3>
                    <p class="text-gray-700 mb-6">
                        Eres responsable de todas las actividades que ocurran bajo tu cuenta. VaedSaas no será responsable de ninguna pérdida o daño derivado del uso no autorizado de tu cuenta.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Uso Gratuito del Servicio</h2>
                    <p class="text-gray-700 mb-4">
                        VaedSaas es <strong>GRATUITO</strong> para todos los clubes y organizaciones. Nuestro modelo de negocio se basa en:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Tienda del Club:</strong> Vendemos productos deportivos personalizados a través de tu club.</li>
                        <li><strong>Comisiones para tu Club:</strong> Tu club recibe entre un 10% y 15% de cada venta realizada.</li>
                        <li><strong>Gestión Completa:</strong> Nosotros gestionamos inventario, personalización, envío y atención al cliente.</li>
                    </ul>
                    <p class="text-gray-700 mb-6">
                        No hay costes ocultos ni tarifas mensuales. El servicio permanece gratuito siempre.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Uso Aceptable</h2>
                    <p class="text-gray-700 mb-4">
                        Al utilizar VaedSaas, te comprometes a NO:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Usar el servicio para propósitos ilegales o no autorizados.</li>
                        <li>Violar leyes locales, nacionales o internacionales.</li>
                        <li>Transmitir contenido ilegal, ofensivo, difamatorio o que viole derechos de terceros.</li>
                        <li>Intentar obtener acceso no autorizado a sistemas o cuentas.</li>
                        <li>Interferir con el funcionamiento normal del servicio.</li>
                        <li>Recopilar o almacenar datos personales de otros usuarios sin consentimiento.</li>
                        <li>Reproducir, duplicar, copiar, vender o explotar cualquier parte del servicio sin autorización.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Procesamiento de Pagos</h2>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">6.1 Sistema de Cuotas</h3>
                    <p class="text-gray-700 mb-4">
                        VaedSaas ofrece un sistema integrado de gestión de pagos de cuotas. Los clubes pueden:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Utilizar su propio TPV virtual.</li>
                        <li>Utilizar nuestro TPV en las mismas condiciones que ofrecen los bancos.</li>
                    </ul>

                    <h3 class="text-xl font-semibold text-gray-800 mb-3">6.2 Tienda del Club</h3>
                    <p class="text-gray-700 mb-6">
                        Los pagos de la tienda del club son procesados directamente por VaedSaas. Las comisiones para el club se acumulan automáticamente y pueden solicitarse en cualquier momento.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Propiedad Intelectual</h2>
                    <p class="text-gray-700 mb-4">
                        VaedSaas y todo su contenido (diseño, código, logotipos, textos, gráficos) son propiedad de VaedSaas o sus licenciantes y están protegidos por leyes de propiedad intelectual.
                    </p>
                    <p class="text-gray-700 mb-6">
                        Los usuarios conservan todos los derechos sobre el contenido que suben a la plataforma (fotos, logos del club, etc.), pero otorgan a VaedSaas una licencia limitada para usar ese contenido en la prestación del servicio.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Limitación de Responsabilidad</h2>
                    <p class="text-gray-700 mb-6">
                        VaedSaas se proporciona "tal cual" y "según disponibilidad". No garantizamos que el servicio sea ininterrumpido, libre de errores o completamente seguro. En la máxima medida permitida por la ley, VaedSaas no será responsable de:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Pérdidas de datos o información.</li>
                        <li>Daños indirectos, incidentales o consecuentes.</li>
                        <li>Interrupciones del servicio por mantenimiento, actualizaciones o causas fuera de nuestro control.</li>
                        <li>Acciones de terceros, incluidos proveedores de pago.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Modificaciones del Servicio</h2>
                    <p class="text-gray-700 mb-6">
                        Nos reservamos el derecho de modificar, suspender o discontinuar cualquier aspecto del servicio en cualquier momento, con o sin previo aviso. No seremos responsables ante ti ni ante terceros por cualquier modificación, suspensión o discontinuación del servicio.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Terminación</h2>
                    <p class="text-gray-700 mb-6">
                        Podemos suspender o terminar tu acceso a VaedSaas en cualquier momento, sin previo aviso, por cualquier motivo, incluido el incumplimiento de estos Términos. Puedes cancelar tu cuenta en cualquier momento desde la configuración de tu perfil.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Ley Aplicable y Jurisdicción</h2>
                    <p class="text-gray-700 mb-6">
                        Estos Términos se regirán e interpretarán de acuerdo con las leyes de España. Cualquier disputa relacionada con estos términos estará sujeta a la jurisdicción exclusiva de los tribunales españoles.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Cambios en los Términos</h2>
                    <p class="text-gray-700 mb-6">
                        Podemos actualizar estos Términos ocasionalmente. Te notificaremos sobre cambios significativos publicando los nuevos términos en esta página y actualizando la fecha de "Última actualización". El uso continuado del servicio después de dichos cambios constituye tu aceptación de los nuevos términos.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">13. Contacto</h2>
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-lg p-6">
                        <p class="text-gray-700 mb-2">Si tienes preguntas sobre estos Términos y Condiciones, contáctanos:</p>
                        <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:legal@vaedsaas.com" class="text-blue-600 hover:text-blue-800">legal@vaedsaas.com</a></p>
                        <p class="text-gray-700"><strong>Sitio web:</strong> <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800">{{ url('/') }}</a></p>
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
    </body>
</html>
