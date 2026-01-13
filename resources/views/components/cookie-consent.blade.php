<!-- Cookie Consent Banner -->
<div id="cookie-consent-banner" class="fixed bottom-0 left-0 right-0 z-50 hidden" style="animation: slideUp 0.5s ease-out;">
    <div class="bg-white border-t-4 border-indigo-600 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">🍪 Usamos Cookies</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Utilizamos cookies propias y de terceros para mejorar tu experiencia, personalizar contenido y analizar el tráfico. 
                        Puedes aceptar todas las cookies o configurar tus preferencias.
                        <a href="{{ url('/cookies') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold underline ml-1">Más información</a>
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                    <button onclick="acceptAllCookies()" 
                            class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-semibold text-sm whitespace-nowrap">
                        Aceptar Todas
                    </button>
                    <button onclick="showCookieSettings()" 
                            class="px-6 py-3 bg-white text-gray-700 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 font-semibold text-sm whitespace-nowrap">
                        Configurar
                    </button>
                    <button onclick="rejectAllCookies()" 
                            class="px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 font-medium text-sm whitespace-nowrap">
                        Rechazar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookie-settings-modal" class="fixed inset-0 z-[60] hidden" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 rounded-t-2xl">
                <h2 class="text-2xl font-bold mb-2">Configuración de Cookies</h2>
                <p class="text-indigo-100 text-sm">Personaliza tus preferencias de cookies</p>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-6">
                <!-- Essential Cookies -->
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Cookies Esenciales</h3>
                            <p class="text-sm text-gray-600">
                                Necesarias para el funcionamiento básico del sitio. No se pueden desactivar.
                            </p>
                        </div>
                        <div class="ml-4">
                            <div class="w-12 h-6 bg-green-500 rounded-full relative cursor-not-allowed opacity-50">
                                <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500">
                        <strong>Ejemplos:</strong> Sesión, autenticación, seguridad CSRF
                    </div>
                </div>

                <!-- Functional Cookies -->
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Cookies Funcionales</h3>
                            <p class="text-sm text-gray-600">
                                Permiten recordar tus preferencias y configuraciones personalizadas.
                            </p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-block w-12 h-6 cursor-pointer">
                                <input type="checkbox" id="functional-cookies" class="sr-only peer" checked>
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer-checked:bg-indigo-600 transition-colors">
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500">
                        <strong>Ejemplos:</strong> Idioma, tema, preferencias de interfaz
                    </div>
                </div>

                <!-- Analytics Cookies -->
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Cookies Analíticas</h3>
                            <p class="text-sm text-gray-600">
                                Nos ayudan a entender cómo los usuarios interactúan con el sitio.
                            </p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-block w-12 h-6 cursor-pointer">
                                <input type="checkbox" id="analytics-cookies" class="sr-only peer" checked>
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer-checked:bg-indigo-600 transition-colors">
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500">
                        <strong>Ejemplos:</strong> Google Analytics, métricas de uso
                    </div>
                </div>

                <!-- Advertising Cookies -->
                <div class="pb-4">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Cookies de Publicidad</h3>
                            <p class="text-sm text-gray-600">
                                Utilizadas para mostrar anuncios relevantes basados en tus intereses.
                            </p>
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-block w-12 h-6 cursor-pointer">
                                <input type="checkbox" id="advertising-cookies" class="sr-only peer">
                                <div class="w-12 h-6 bg-gray-300 rounded-full peer-checked:bg-indigo-600 transition-colors">
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500">
                        <strong>Ejemplos:</strong> Anuncios personalizados, remarketing
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex flex-col sm:flex-row gap-3 justify-end">
                <button onclick="closeCookieSettings()" 
                        class="px-6 py-2 text-gray-700 hover:bg-gray-200 rounded-lg transition duration-200 font-medium">
                    Cancelar
                </button>
                <button onclick="saveCustomCookiePreferences()" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200 font-semibold">
                    Guardar Preferencias
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<script>
    // Check if consent has been given
    function checkCookieConsent() {
        const consent = localStorage.getItem('cookie_consent');
        if (!consent) {
            document.getElementById('cookie-consent-banner').classList.remove('hidden');
        }
    }

    // Accept all cookies
    function acceptAllCookies() {
        const preferences = {
            essential: true,
            functional: true,
            analytics: true,
            advertising: true
        };
        saveCookiePreferences(preferences);
        document.getElementById('cookie-consent-banner').classList.add('hidden');
    }

    // Reject all non-essential cookies
    function rejectAllCookies() {
        const preferences = {
            essential: true,
            functional: false,
            analytics: false,
            advertising: false
        };
        saveCookiePreferences(preferences);
        document.getElementById('cookie-consent-banner').classList.add('hidden');
    }

    // Show cookie settings modal
    function showCookieSettings() {
        document.getElementById('cookie-settings-modal').classList.remove('hidden');
        // Load current preferences
        const savedPreferences = JSON.parse(localStorage.getItem('cookie_consent') || '{}');
        document.getElementById('functional-cookies').checked = savedPreferences.functional !== false;
        document.getElementById('analytics-cookies').checked = savedPreferences.analytics !== false;
        document.getElementById('advertising-cookies').checked = savedPreferences.advertising === true;
    }

    // Close cookie settings modal
    function closeCookieSettings() {
        document.getElementById('cookie-settings-modal').classList.add('hidden');
    }

    // Save custom cookie preferences
    function saveCustomCookiePreferences() {
        const preferences = {
            essential: true,
            functional: document.getElementById('functional-cookies').checked,
            analytics: document.getElementById('analytics-cookies').checked,
            advertising: document.getElementById('advertising-cookies').checked
        };
        saveCookiePreferences(preferences);
        document.getElementById('cookie-consent-banner').classList.add('hidden');
        document.getElementById('cookie-settings-modal').classList.add('hidden');
    }

    // Save preferences to localStorage and apply them
    function saveCookiePreferences(preferences) {
        localStorage.setItem('cookie_consent', JSON.stringify(preferences));
        localStorage.setItem('cookie_consent_date', new Date().toISOString());
        applyCookiePreferences(preferences);
    }

    // Apply cookie preferences (enable/disable tracking scripts)
    function applyCookiePreferences(preferences) {
        // Google Analytics
        if (preferences.analytics) {
            // Enable Google Analytics if you have it
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    'analytics_storage': 'granted'
                });
            }
        } else {
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    'analytics_storage': 'denied'
                });
            }
        }

        // Advertising
        if (preferences.advertising) {
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    'ad_storage': 'granted'
                });
            }
        } else {
            if (typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    'ad_storage': 'denied'
                });
            }
        }

        console.log('Cookie preferences applied:', preferences);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        checkCookieConsent();
        
        // Apply saved preferences if they exist
        const savedPreferences = localStorage.getItem('cookie_consent');
        if (savedPreferences) {
            applyCookiePreferences(JSON.parse(savedPreferences));
        }
    });

    // Close modal when clicking outside
    document.getElementById('cookie-settings-modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCookieSettings();
        }
    });

    // Make showCookieConsent available globally (for cookies page)
    window.showCookieConsent = showCookieSettings;
</script>
