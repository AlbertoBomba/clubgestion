<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Contacto</h1>
            <p class="text-xl">Estamos aquí para ayudarte</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Información de Contacto -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Información de Contacto</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">📍</div>
                        <div>
                            <h3 class="font-semibold">Dirección</h3>
                            <p class="text-gray-600">{{ $school->address }}</p>
                            <p class="text-gray-600">{{ $school->city }}, {{ $school->province }} {{ $school->postal_code }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">📧</div>
                        <div>
                            <h3 class="font-semibold">Email</h3>
                            <a href="mailto:{{ $school->email }}" class="text-blue-600 hover:underline">
                                {{ $school->email }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="text-blue-600 text-2xl mr-4">📱</div>
                        <div>
                            <h3 class="font-semibold">Teléfono</h3>
                            <a href="tel:{{ $school->phone }}" class="text-blue-600 hover:underline">
                                {{ $school->phone }}
                            </a>
                        </div>
                    </div>

                    @if($school->contact_person)
                        <div class="flex items-start">
                            <div class="text-blue-600 text-2xl mr-4">👤</div>
                            <div>
                                <h3 class="font-semibold">Persona de Contacto</h3>
                                <p class="text-gray-600">{{ $school->contact_person }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Envíanos un Mensaje</h2>
                
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                        <textarea id="message" name="message" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>

                    <button type="submit" 
                        class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
