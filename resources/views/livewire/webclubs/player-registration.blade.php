<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Inscripción de Jugadores</h1>
            <p class="text-xl">Únete a {{ tenantName() }}</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Formulario de Inscripción</h2>
            
            <form action="#" method="POST" class="space-y-6">
                @csrf

                <!-- Datos del Jugador -->
                <div class="border-b pb-6">
                    <h3 class="text-xl font-semibold mb-4">Datos del Jugador</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="surname" class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
                            <input type="text" id="surname" name="surname" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIE *</label>
                            <input type="text" id="dni" name="dni" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="dbirth" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento *</label>
                            <input type="date" id="dbirth" name="dbirth" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone1" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                            <input type="tel" id="phone1" name="phone1" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="border-b pb-6">
                    <h3 class="text-xl font-semibold mb-4">Dirección</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                            <input type="text" id="address" name="address"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="town" class="block text-sm font-medium text-gray-700 mb-1">Localidad</label>
                            <input type="text" id="town" name="town"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                            <input type="text" id="province" name="province"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                            <input type="text" id="zip" name="zip"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Datos del Tutor (para menores) -->
                <div class="border-b pb-6">
                    <h3 class="text-xl font-semibold mb-4">Datos del Tutor Legal (si es menor de edad)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nametutor" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Tutor</label>
                            <input type="text" id="nametutor" name="nametutor"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="surnametutor" class="block text-sm font-medium text-gray-700 mb-1">Apellidos del Tutor</label>
                            <input type="text" id="surnametutor" name="surnametutor"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="dnitutor" class="block text-sm font-medium text-gray-700 mb-1">DNI del Tutor</label>
                            <input type="text" id="dnitutor" name="dnitutor"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone2" class="block text-sm font-medium text-gray-700 mb-1">Teléfono del Tutor</label>
                            <input type="tel" id="phone2" name="phone2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observations" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                    <textarea id="observations" name="observations" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>

                <!-- Aceptación de términos -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required
                        class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Acepto la <a href="{{ route('privacy') }}" class="text-blue-600 hover:underline" target="_blank">política de privacidad</a> 
                        y los <a href="{{ route('terms') }}" class="text-blue-600 hover:underline" target="_blank">términos y condiciones</a> *
                    </label>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="reset" 
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Limpiar
                    </button>
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                        Enviar Inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
