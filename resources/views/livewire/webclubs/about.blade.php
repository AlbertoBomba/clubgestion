<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Sobre Nosotros</h1>
            <p class="text-xl">Conoce más sobre {{ tenantName() }}</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-bold mb-6">{{ $school->name }}</h2>
            
            <div class="prose max-w-none mb-8">
                <p class="text-gray-700 text-lg mb-4">
                    {{ $school->description ?? 'Bienvenido a nuestra escuela deportiva.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Nuestra Historia</h3>
                    <p class="text-gray-600">
                        Con años de experiencia en formación deportiva, nos hemos consolidado como 
                        referente en el desarrollo integral de deportistas.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Nuestra Misión</h3>
                    <p class="text-gray-600">
                        Formar deportistas con valores, técnica y pasión por el deporte, 
                        proporcionando las mejores herramientas para su desarrollo.
                    </p>
                </div>
            </div>

            <div class="border-t pt-8">
                <h3 class="text-xl font-semibold mb-4">Información de Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600"><strong>Dirección:</strong> {{ $school->address }}</p>
                        <p class="text-gray-600"><strong>Ciudad:</strong> {{ $school->city }}, {{ $school->province }}</p>
                        <p class="text-gray-600"><strong>Código Postal:</strong> {{ $school->postal_code }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Email:</strong> {{ $school->email }}</p>
                        <p class="text-gray-600"><strong>Teléfono:</strong> {{ $school->phone }}</p>
                        @if($school->contact_person)
                            <p class="text-gray-600"><strong>Persona de Contacto:</strong> {{ $school->contact_person }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
