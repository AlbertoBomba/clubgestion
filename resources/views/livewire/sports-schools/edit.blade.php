<div class="w-full px-4">
    <div class="card-modern rounded-2xl shadow-xl border border-primary/10 p-4 w-full">
        <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-3">
                <h3 class="text-base font-semibold text-gray-900 flex items-center mb-3">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Información Básica
                </h3>
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nombre de la Escuela <span class="text-red-500">*</span>
                    </label>
                    <input wire:model.live="name" type="text" id="name" required
                        class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                    <textarea wire:model.live="description" id="description" rows="2"
                        class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Logo Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        <svg class="w-4 h-4 inline mr-1 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Logo de la Escuela
                    </label>
                    
                    @if ($currentLogo)
                        <div class="mb-2 flex items-center space-x-3 p-2 bg-gray-50 rounded-lg border border-gray-200">
                            <img src="{{ asset('storage/' . $currentLogo) }}" alt="Logo actual" class="h-12 w-12 object-contain rounded border border-gray-300 bg-white p-1">
                            <div class="flex-1">
                                <p class="text-xs text-gray-700 font-medium">Logo actual</p>
                                <button type="button" wire:click="deleteLogo" 
                                    class="mt-1 text-[10px] text-red-600 hover:text-red-800 font-semibold flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    @endif

                    @if ($logo)
                        <div class="mb-2 p-2 bg-neon-green/10 rounded-lg border border-neon-green/30">
                            <p class="text-xs text-neon-green font-medium flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $logo->getClientOriginalName() }}
                            </p>
                            <img src="{{ $logo->temporaryUrl() }}" alt="Vista previa" class="mt-2 h-12 w-12 object-contain rounded border border-gray-300 bg-white p-1">
                        </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label for="logo-upload" class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-3 pb-3">
                                <svg class="w-6 h-6 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-1 text-xs text-gray-500"><span class="font-semibold">Click para subir</span></p>
                                <p class="text-[10px] text-gray-400">PNG, JPG hasta 2MB</p>
                            </div>
                            <input id="logo-upload" type="file" wire:model.live="logo" class="hidden" accept="image/*">
                        </label>
                    </div>
                    @error('logo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    
                    <div wire:loading wire:target="logo" class="mt-2 text-sm text-primary flex items-center">
                        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Subiendo imagen...
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h3 class="text-base font-semibold text-gray-900 flex items-center mb-3">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Ubicación
                </h3>

                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                    <input wire:model.live="address" type="text" id="address"
                        class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                    @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-1">Ciudad</label>
                        <input wire:model.live="city" type="text" id="city"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-semibold text-gray-700 mb-1">Provincia</label>
                        <input wire:model.live="province" type="text" id="province"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('province') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-1">Código Postal</label>
                    <input wire:model.live="postal_code" type="text" id="postal_code"
                        class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                    @error('postal_code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="space-y-3 lg:col-span-2">
                <h3 class="text-base font-semibold text-gray-900 flex items-center mb-3">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contacto
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label for="contact_person" class="block text-sm font-semibold text-gray-700 mb-1">Persona de Contacto</label>
                        <input wire:model.live="contact_person" type="text" id="contact_person"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('contact_person') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                        <input wire:model.live="phone" type="text" id="phone"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input wire:model.live="email" type="email" id="email"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 flex items-center justify-between pt-4 border-t border-gray-200">
                <label for="is_active" class="flex items-center cursor-pointer group">
                    <input wire:model.live="is_active" type="checkbox" id="is_active"
                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                    <span class="ml-2 text-sm font-semibold text-gray-700 group-hover:text-gray-900">Escuela Activa</span>
                </label>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('sports-schools.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" wire:loading.attr="disabled" wire:target="save"
                        class="btn-primary px-4 py-2 rounded-lg text-sm text-white font-semibold shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 inline" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="save">Actualizar Escuela</span>
                        <span wire:loading wire:target="save">Guardando...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- API Security Section -->
    <div class="card-modern rounded-2xl shadow-xl border border-primary/10 p-4 w-full mt-6">
        <div class="space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Gestión de API Keys
                </h3>
                @if($school->api_key)
                    <div class="flex items-center space-x-2">
                        <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $school->api_enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $school->api_enabled ? 'Activa' : 'Deshabilitada' }}
                        </span>
                    </div>
                @endif
            </div>

            @if(session()->has('api_key_generated'))
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-yellow-800">¡Importante! Copia tu API Key</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p class="mb-2">Esta es tu nueva API Key. Cópiala ahora, no se volverá a mostrar:</p>
                                <div class="bg-white p-3 rounded border border-yellow-200 font-mono text-xs break-all flex items-center justify-between">
                                    <span id="api-key-display">{{ session('api_key_generated') }}</span>
                                    <button type="button" onclick="copyApiKey()" class="ml-2 text-primary hover:text-primary-dark">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($school->api_key)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- API Key Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Información de API Key</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Estado:</span>
                                <span class="font-semibold {{ $school->api_enabled ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $school->api_enabled ? 'Habilitada' : 'Deshabilitada' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Generada:</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $school->api_key_generated_at ? $school->api_key_generated_at->format('d/m/Y H:i') : 'N/A' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Peticiones:</span>
                                <span class="font-semibold text-gray-900">{{ number_format($school->api_requests_count) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Última Petición:</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $school->last_api_request_at ? $school->last_api_request_at->diffForHumans() : 'Nunca' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Acciones</h4>
                        <div class="space-y-2">
                            @if($school->api_enabled)
                                <button type="button" wire:click="disableApi" 
                                    class="w-full px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Deshabilitar API
                                </button>
                            @else
                                <button type="button" wire:click="enableApi" 
                                    class="w-full px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Habilitar API
                                </button>
                            @endif
                            
                            <button type="button" wire:click="regenerateApiKey" 
                                onclick="return confirm('¿Estás seguro? La API key anterior dejará de funcionar.')"
                                class="w-full px-4 py-2 bg-yellow-600 text-white text-sm font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Regenerar API Key
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay API Key generada</h3>
                    <p class="mt-1 text-sm text-gray-500">Genera una API Key para acceder a los endpoints públicos</p>
                    <div class="mt-6">
                        <button type="button" wire:click="generateApiKey" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Generar API Key
                        </button>
                    </div>
                </div>
            @endif

            <!-- Documentation -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">📘 Cómo usar la API Key</h4>
                <div class="text-xs text-blue-800 space-y-2">
                    <p>Para acceder a los endpoints públicos de la API, incluye tu API Key en cada petición:</p>
                    <div class="bg-white p-2 rounded border border-blue-300 font-mono text-[10px] overflow-x-auto">
                        <code class="text-gray-800">
// Opción 1: Header (recomendado)<br>
X-API-Key: tu_api_key_aqui<br><br>
// Opción 2: Query Parameter<br>
{{ url('/api/v1/public/matches') }}?api_key=tu_api_key_aqui
                        </code>
                    </div>
                    <p class="text-xs"><strong>Endpoints disponibles:</strong></p>
                    <ul class="list-disc list-inside ml-2 space-y-1">
                        <li><code class="bg-white px-1 rounded">GET /api/v1/public/matches</code> - Lista de partidos</li>
                        <li><code class="bg-white px-1 rounded">GET /api/v1/public/matches/{id}</code> - Detalles de un partido</li>
                        <li><code class="bg-white px-1 rounded">GET /api/v1/public/teams</code> - Lista de equipos</li>
                    </ul>
                    <p class="text-xs"><strong>Límite:</strong> 100 peticiones por minuto</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyApiKey() {
    const apiKey = document.getElementById('api-key-display').textContent;
    navigator.clipboard.writeText(apiKey).then(() => {
        alert('API Key copiada al portapapeles');
    });
}
</script>
