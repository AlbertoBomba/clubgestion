<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Política de Privacidad | {{ config('app.name', 'VaedSaas') }}</title>

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
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 sm:p-12 mb-8 text-white">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Política de Privacidad</h1>
                    <p class="text-lg text-indigo-100">Última actualización: {{ date('d/m/Y') }}</p>
                </div>

                <!-- Content Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10 prose prose-lg max-w-none">
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Información que Recopilamos</h2>
                    <p class="text-gray-700 mb-6">
                        En VaedSaas, recopilamos y procesamos diferentes tipos de información personal cuando utilizas nuestros servicios:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Datos de Registro:</strong> Nombre, apellidos, correo electrónico, teléfono, nombre del club/escuela.</li>
                        <li><strong>Datos de Jugadores:</strong> Información de los miembros del equipo como nombres, fechas de nacimiento, fotografías (con consentimiento).</li>
                        <li><strong>Datos de Uso:</strong> Información sobre cómo utilizas la plataforma, páginas visitadas, funciones utilizadas.</li>
                        <li><strong>Datos de Pago:</strong> Información necesaria para procesar pagos de cuotas (procesada de forma segura a través de nuestros proveedores de pago).</li>
                        <li><strong>Cookies y Tecnologías Similares:</strong> Datos técnicos para mejorar tu experiencia (ver nuestra <a href="{{ url('/cookies') }}" class="text-indigo-600 hover:text-indigo-800">Política de Cookies</a>).</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Cómo Utilizamos tu Información</h2>
                    <p class="text-gray-700 mb-4">Utilizamos la información recopilada para:</p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Proporcionar y mejorar nuestros servicios de gestión deportiva.</li>
                        <li>Procesar pagos y gestionar la tienda del club.</li>
                        <li>Enviar notificaciones importantes sobre convocatorias, entrenamientos y partidos.</li>
                        <li>Comunicarte novedades, promociones y actualizaciones del servicio (con tu consentimiento).</li>
                        <li>Garantizar la seguridad de la plataforma y prevenir fraudes.</li>
                        <li>Cumplir con obligaciones legales y regulatorias.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Base Legal del Tratamiento</h2>
                    <p class="text-gray-700 mb-4">Tratamos tus datos personales bajo las siguientes bases legales:</p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Ejecución de Contrato:</strong> Para proporcionar los servicios que has contratado.</li>
                        <li><strong>Consentimiento:</strong> Para enviar comunicaciones comerciales o procesar datos sensibles.</li>
                        <li><strong>Interés Legítimo:</strong> Para mejorar nuestros servicios y prevenir fraudes.</li>
                        <li><strong>Obligación Legal:</strong> Para cumplir con la normativa aplicable.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Compartición de Datos</h2>
                    <p class="text-gray-700 mb-4">
                        No vendemos ni alquilamos tus datos personales. Compartimos información únicamente con:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Proveedores de Servicios:</strong> Empresas que nos ayudan a operar la plataforma (hosting, pagos, emails).</li>
                        <li><strong>Procesadores de Pago:</strong> Para gestionar transacciones de forma segura.</li>
                        <li><strong>Autoridades Legales:</strong> Cuando sea requerido por ley.</li>
                        <li><strong>Otros Miembros del Club:</strong> Información necesaria para la gestión del equipo (con tu consentimiento).</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Seguridad de los Datos</h2>
                    <p class="text-gray-700 mb-6">
                        Implementamos medidas técnicas y organizativas apropiadas para proteger tus datos personales contra acceso no autorizado, alteración, divulgación o destrucción. Esto incluye:
                    </p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li>Cifrado SSL/TLS para todas las comunicaciones.</li>
                        <li>Almacenamiento seguro de contraseñas con algoritmos de hash.</li>
                        <li>Acceso restringido a datos personales.</li>
                        <li>Auditorías de seguridad regulares.</li>
                    </ul>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Retención de Datos</h2>
                    <p class="text-gray-700 mb-6">
                        Conservamos tus datos personales solo durante el tiempo necesario para cumplir con los propósitos descritos en esta política, a menos que la ley requiera o permita un período de retención más prolongado. Cuando elimines tu cuenta, procederemos a eliminar o anonimizar tus datos personales.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Tus Derechos</h2>
                    <p class="text-gray-700 mb-4">Conforme al RGPD, tienes los siguientes derechos:</p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        <li><strong>Acceso:</strong> Conocer qué datos personales tenemos sobre ti.</li>
                        <li><strong>Rectificación:</strong> Corregir datos inexactos o incompletos.</li>
                        <li><strong>Supresión:</strong> Solicitar la eliminación de tus datos ("derecho al olvido").</li>
                        <li><strong>Limitación:</strong> Restringir el procesamiento de tus datos.</li>
                        <li><strong>Portabilidad:</strong> Recibir tus datos en un formato estructurado y transferirlos a otro responsable.</li>
                        <li><strong>Oposición:</strong> Oponerte al tratamiento de tus datos.</li>
                        <li><strong>No estar sujeto a decisiones automatizadas:</strong> Incluida la elaboración de perfiles.</li>
                    </ul>
                    <p class="text-gray-700 mb-6">
                        Para ejercer estos derechos, contacta con nosotros en <a href="mailto:privacidad@vaedsaas.com" class="text-indigo-600 hover:text-indigo-800">privacidad@vaedsaas.com</a>
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Cookies y Tecnologías Similares</h2>
                    <p class="text-gray-700 mb-6">
                        Utilizamos cookies y tecnologías similares para mejorar tu experiencia. Para más información, consulta nuestra <a href="{{ url('/cookies') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Política de Cookies</a>.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Menores de Edad</h2>
                    <p class="text-gray-700 mb-6">
                        Nuestros servicios están diseñados para ser utilizados por clubes y organizadores. Los datos de menores de edad deben ser proporcionados por sus padres, tutores o representantes legales con el consentimiento correspondiente.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Cambios en esta Política</h2>
                    <p class="text-gray-700 mb-6">
                        Podemos actualizar esta Política de Privacidad ocasionalmente. Te notificaremos cualquier cambio significativo publicando la nueva política en esta página y actualizando la fecha de "Última actualización". Te recomendamos revisar esta política periódicamente.
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Contacto</h2>
                    <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-r-lg p-6">
                        <p class="text-gray-700 mb-2"><strong>Responsable del Tratamiento:</strong> VaedSaas</p>
                        <p class="text-gray-700 mb-2"><strong>Email:</strong> <a href="mailto:privacidad@vaedsaas.com" class="text-indigo-600 hover:text-indigo-800">privacidad@vaedsaas.com</a></p>
                        <p class="text-gray-700">Si tienes preguntas sobre esta política o sobre cómo tratamos tus datos personales, no dudes en contactarnos.</p>
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
