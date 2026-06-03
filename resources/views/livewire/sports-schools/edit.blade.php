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

                <!-- Colores de la Escuela -->
                <div>
                    <h3 class="text-base font-semibold text-gray-900 flex items-center mb-3">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                        Colores de Identidad
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="primary_color" class="block text-sm font-semibold text-gray-700 mb-1">Color Principal</label>
                            <div class="flex items-center space-x-2">
                                <input wire:model.live="primary_color" type="color" id="primary_color"
                                    class="h-10 w-16 border border-gray-300 rounded-lg cursor-pointer">
                                <input wire:model.live="primary_color" type="text" placeholder="#1E40AF"
                                    class="input-field flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                            </div>
                            @error('primary_color') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="secondary_color" class="block text-sm font-semibold text-gray-700 mb-1">Color Secundario</label>
                            <div class="flex items-center space-x-2">
                                <input wire:model.live="secondary_color" type="color" id="secondary_color"
                                    class="h-10 w-16 border border-gray-300 rounded-lg cursor-pointer">
                                <input wire:model.live="secondary_color" type="text" placeholder="#10B981"
                                    class="input-field flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                            </div>
                            @error('secondary_color') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <!-- Vista previa de los colores -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs font-semibold text-gray-600 mb-2">Vista previa:</p>
                        <div class="flex space-x-2">
                            <div class="flex-1 h-12 rounded-lg border-2 border-gray-300 flex items-center justify-center text-xs font-semibold text-white shadow-sm"
                                style="background-color: {{ $primary_color }}">
                                Principal
                            </div>
                            <div class="flex-1 h-12 rounded-lg border-2 border-gray-300 flex items-center justify-center text-xs font-semibold text-white shadow-sm"
                                style="background-color: {{ $secondary_color }}">
                                Secundario
                            </div>
                        </div>
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

    {{-- ─── Mail configuration card ──────────────────────────────────────────────── --}}
    <div class="card-modern rounded-2xl shadow-xl border border-primary/10 p-4 w-full mt-6">
    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Configuración de correo electrónico
            </h3>
            @if($mail_has_password && $school->mail_host)
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-800">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Configurado
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                    Sin configurar
                </span>
            @endif
        </div>

        {{-- Info banner --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-800">
            <p class="font-semibold mb-1">¿Para qué sirve esto?</p>
            <p>Al configurar el servidor de correo de la escuela, todas las notificaciones enviadas a jugadores, entrenadores o familias utilizarán el correo oficial de <strong>{{ $school->name }}</strong> como remitente en lugar del correo genérico de la plataforma.</p>
        </div>

        {{-- Flash message --}}
        @if(session()->has('mail_message'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-3 text-sm text-green-800 font-medium flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('mail_message') }}
            </div>
        @endif

        {{-- Provider presets --}}
        <div>
            <p class="text-xs font-semibold text-gray-600 mb-2">Selecciona tu proveedor de correo:</p>
            <div class="flex flex-wrap gap-2">
                <button type="button" wire:click="applyMailPreset('gmail')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-red-300 transition-all">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6z" stroke="#EA4335" stroke-width="1.5"/><path d="M2 6l10 7 10-7" stroke="#EA4335" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Gmail
                </button>
                <button type="button" wire:click="applyMailPreset('outlook')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-blue-300 transition-all">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="#0078D4" stroke-width="1.5"/><path d="M2 8h20M8 8v12" stroke="#0078D4" stroke-width="1.5"/></svg>
                    Outlook / Hotmail
                </button>
                <button type="button" wire:click="applyMailPreset('yahoo')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-purple-300 transition-all">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#6001D2" stroke-width="1.5"/><path d="M8 8l4 5 4-5M12 13v4" stroke="#6001D2" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Yahoo
                </button>
                <button type="button" wire:click="applyMailPreset('strato')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-orange-300 transition-all">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="#E87722" stroke-width="1.5"/><path d="M3 10h18" stroke="#E87722" stroke-width="1.5"/><path d="M8 14h4" stroke="#E87722" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Strato
                </button>
                <span class="inline-flex items-center px-3 py-1.5 text-xs text-gray-400">o configura manualmente →</span>
            </div>
        </div>

        {{-- SMTP fields grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Host --}}
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Servidor SMTP (host)</label>
                <input wire:model="mail_host" type="text" placeholder="smtp.gmail.com"
                       class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                @error('mail_host') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Port --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Puerto</label>
                <input wire:model="mail_port" type="number" placeholder="587"
                       class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                @error('mail_port') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Encryption --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Cifrado</label>
                <div class="flex gap-2">
                    <button type="button" wire:click="$set('mail_encryption', 'tls')"
                            class="flex-1 py-2 text-xs font-bold rounded-lg border transition-all {{ $mail_encryption === 'tls' ? 'bg-primary text-white border-primary' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                        TLS (587)
                    </button>
                    <button type="button" wire:click="$set('mail_encryption', 'ssl')"
                            class="flex-1 py-2 text-xs font-bold rounded-lg border transition-all {{ $mail_encryption === 'ssl' ? 'bg-primary text-white border-primary' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                        SSL (465)
                    </button>
                </div>
                @error('mail_encryption') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Usuario (tu email)</label>
                <input wire:model="mail_username" type="email" placeholder="tucorreo@gmail.com"
                       autocomplete="off"
                       class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                @error('mail_username') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">
                    Contraseña / App Password
                    @if($mail_has_password)
                        <span class="ml-1 text-green-600 font-normal">✓ guardada</span>
                    @endif
                </label>
                <input wire:model="mail_password" type="password"
                       placeholder="{{ $mail_has_password ? 'Deja en blanco para no cambiarla' : 'Contraseña SMTP o App Password' }}"
                       autocomplete="new-password"
                       class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                @error('mail_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @if($mail_username && str_contains($mail_username, 'gmail'))
                    <p class="text-[10px] text-amber-600 mt-1">⚠ Gmail requiere una <strong>Contraseña de aplicación</strong> (no tu contraseña habitual). Actívala en <a href="https://myaccount.google.com/apppasswords" target="_blank" class="underline">myaccount.google.com/apppasswords</a>.</p>
                @endif
            </div>

        </div>

        {{-- From section --}}
        <div>
            <p class="text-xs font-semibold text-gray-700 mb-3">Remitente visible por el destinatario</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email remitente</label>
                    <input wire:model="mail_from_address" type="email" placeholder="noreply@miacademia.com"
                           class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                    <p class="text-[10px] text-gray-400 mt-1">Si se deja vacío se usará el usuario SMTP.</p>
                    @error('mail_from_address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre remitente</label>
                    <input wire:model="mail_from_name" type="text" placeholder="{{ $school->name }}"
                           class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                    <p class="text-[10px] text-gray-400 mt-1">Si se deja vacío se usará el nombre de la escuela.</p>
                    @error('mail_from_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- DNS records helper --}}
        @php
            $host = $school->mail_host ?? $mail_host;
            $fromDomain = $school->mail_from_address ? explode('@', $school->mail_from_address)[1] ?? '' : '';
            $isGmail   = str_contains($host, 'gmail') || str_contains($host, 'google');
            $isOutlook = str_contains($host, 'office365') || str_contains($host, 'outlook') || str_contains($host, 'hotmail');
            $isYahoo   = str_contains($host, 'yahoo');
            $isStrato  = str_contains($host, 'strato');
            $isCustom  = $host && !$isGmail && !$isOutlook && !$isYahoo && !$isStrato;
        @endphp

        <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
            <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors text-left">
                <span class="text-xs font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Registros DNS para evitar spam
                    @if($isGmail || $isOutlook || $isYahoo || $isStrato)
                        <span class="text-green-600 font-normal">(configurado con {{ $isGmail ? 'Gmail' : ($isOutlook ? 'Outlook' : ($isYahoo ? 'Yahoo' : 'Strato')) }})</span>
                    @endif
                </span>
                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-collapse class="px-4 pb-4 pt-3 space-y-4 text-xs">

                @if($isGmail)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-green-800">
                        <p class="font-semibold mb-1">✅ Con Gmail no necesitas configurar DNS</p>
                        <p>Google gestiona automáticamente SPF y DKIM cuando envías a través de <code class="bg-white px-1 rounded">smtp.gmail.com</code>. Los correos salen con la reputación de Google, lo que garantiza una entrega óptima.</p>
                    </div>

                @elseif($isOutlook)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-blue-800">
                        <p class="font-semibold mb-1">✅ Con Outlook/Hotmail no necesitas configurar DNS</p>
                        <p>Microsoft gestiona automáticamente SPF y DKIM cuando envías a través de <code class="bg-white px-1 rounded">smtp.office365.com</code>. Los correos salen con la reputación de Microsoft.</p>
                    </div>

                @elseif($isYahoo)
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 text-purple-800">
                        <p class="font-semibold mb-1">✅ Con Yahoo no necesitas configurar DNS</p>
                        <p>Yahoo gestiona automáticamente SPF y DKIM cuando envías a través de sus servidores SMTP.</p>
                    </div>

                @elseif($isStrato)

                    {{-- PASO 1: SPF --}}
                    <div class="rounded-lg border border-gray-200 overflow-hidden">
                        <div class="bg-gray-100 px-3 py-2 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-orange-500 text-white text-[11px] font-bold flex items-center justify-center shrink-0">1</span>
                            <p class="text-xs font-semibold text-gray-800">SPF — en la pestaña DNS → "Registros TXT y CNAME" → <u>administrar</u></p>
                        </div>
                        <div class="p-3 space-y-2 text-xs text-gray-700">
                            <p>Busca la sección <strong>"STRATO Parámetros de registro SPF"</strong> y selecciona:</p>
                            <div class="flex items-start gap-2 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                <span class="text-green-600 font-bold mt-0.5">●</span>
                                <span><strong>Servidor mail estándar de STRATO</strong></span>
                            </div>
                            <p class="text-gray-400">Pulsa guardar. Strato añade el registro SPF automáticamente — no tienes que escribir nada en los campos de abajo.</p>
                        </div>
                    </div>

                    {{-- PASO 2: DMARC --}}
                    <div class="rounded-lg border border-gray-200 overflow-hidden">
                        <div class="bg-gray-100 px-3 py-2 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-orange-500 text-white text-[11px] font-bold flex items-center justify-center shrink-0">2</span>
                            <p class="text-xs font-semibold text-gray-800">DMARC — en la misma pantalla "Registros TXT y CNAME"</p>
                        </div>
                        <div class="p-3 space-y-2 text-xs text-gray-700">
                            <p>Busca la sección <strong>"STRATO DMARC"</strong> y selecciona:</p>
                            <div class="flex items-start gap-2 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                                <span class="text-green-600 font-bold mt-0.5">●</span>
                                <span><strong>Regla DMARC estándar de STRATO</strong></span>
                            </div>
                            <p class="text-gray-400">Guarda. Con esto ya tienes DMARC configurado sin tocar los campos de texto.</p>
                            <hr class="border-gray-100">
                            <p class="font-medium text-gray-600">¿Quieres recibir informes de entrega en tu correo? Usa el campo TXT manual que aparece debajo en esa misma pantalla:</p>
                            <table class="w-full text-xs border-collapse">
                                <tr class="border-b border-gray-100">
                                    <td class="py-1 pr-3 font-semibold text-gray-500 whitespace-nowrap">Tipo</td>
                                    <td><code class="bg-gray-100 px-1 rounded">TXT</code></td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-1 pr-3 font-semibold text-gray-500 whitespace-nowrap">Prefijo</td>
                                    <td><code class="bg-gray-100 px-1 rounded">_dmarc</code> <span class="text-gray-400">(deja el resto del dominio que ya aparece)</span></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-3 font-semibold text-gray-500 whitespace-nowrap align-top">Valor</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <code class="bg-gray-100 px-1 rounded break-all">v=DMARC1; p=none; rua=mailto:{{ $school->email ?? 'tucorreo@tudominio.com' }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('v=DMARC1; p=none; rua=mailto:{{ $school->email ?? 'tucorreo@tudominio.com' }}')" class="shrink-0 text-primary hover:underline font-semibold">Copiar</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- PASO 3: DKIM --}}
                    <div class="rounded-lg border border-gray-200 overflow-hidden">
                        <div class="bg-gray-100 px-3 py-2 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-orange-500 text-white text-[11px] font-bold flex items-center justify-center shrink-0">3</span>
                            <p class="text-xs font-semibold text-gray-800">DKIM — en el paquete de email (no en DNS)</p>
                        </div>
                        <div class="p-3 space-y-2 text-xs text-gray-700">
                            <p>El DKIM <strong>no está en la sección DNS</strong>, está en la configuración del paquete de correo:</p>
                            <ol class="list-decimal list-inside space-y-1.5 text-gray-600">
                                <li>Entra en <a href="https://www.strato.es/apps/CustomerService" target="_blank" class="text-primary underline font-medium">strato.es → Mi cuenta</a></li>
                                <li>Ve a <strong>Paquetes</strong> → tu paquete de correo (Starter Mail, Business Mail, etc.)</li>
                                <li>Busca la opción <strong>"Seguridad del correo"</strong> o <strong>"Firma DKIM"</strong></li>
                                <li>Activa el interruptor de <strong>DKIM</strong></li>
                                <li>Strato crea el registro DNS automáticamente — no tienes que copiar nada</li>
                            </ol>
                        </div>
                    </div>

                    {{-- Verification Strato --}}
                    <div class="pt-2 border-t border-gray-100">
                        <p class="font-semibold text-gray-600 mb-2 text-xs">Verificar que todo está bien configurado:</p>
                        <div class="flex flex-wrap gap-2">
                            @if($fromDomain)
                                <a href="https://mxtoolbox.com/spf.aspx?domain={{ $fromDomain }}" target="_blank"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-orange-50 border border-orange-200 hover:bg-orange-100 text-orange-800 transition-colors font-medium text-xs">
                                    Verificar SPF
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <a href="https://mxtoolbox.com/dmarc.aspx?domain={{ $fromDomain }}" target="_blank"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-orange-50 border border-orange-200 hover:bg-orange-100 text-orange-800 transition-colors font-medium text-xs">
                                    Verificar DMARC
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            @endif
                            <a href="https://www.mail-tester.com" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors text-xs">
                                Puntuación anti-spam (mail-tester.com)
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>

                @else
                    <p class="text-gray-600">
                        Si usas un servidor SMTP propio o de hosting, el administrador del dominio
                        @if($fromDomain) <strong>{{ $fromDomain }}</strong> @else del email remitente @endif
                        debe añadir estos registros DNS:
                    </p>

                    {{-- SPF --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <p class="font-semibold text-gray-700">1. Registro SPF <span class="font-normal text-gray-400">(TXT en @)</span></p>
                            <button type="button" onclick="navigator.clipboard.writeText('v=spf1 a mx include:{{ $host ?? 'tuservidor.com' }} ~all')" class="text-primary hover:underline">Copiar</button>
                        </div>
                        <code class="block bg-gray-100 rounded-lg px-3 py-2 text-gray-800 break-all select-all">v=spf1 a mx{{ $host ? ' include:'.$host : '' }} ~all</code>
                        <p class="text-gray-400 mt-1">Añade este registro TXT en la raíz (@) de tu dominio. Si ya tienes un SPF, añade <code class="bg-gray-100 px-1 rounded">include:{{ $host ?? 'tuservidor' }}</code> dentro del existente.</p>
                    </div>

                    {{-- DMARC --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <p class="font-semibold text-gray-700">2. Registro DMARC <span class="font-normal text-gray-400">(TXT en _dmarc)</span></p>
                            <button type="button" onclick="navigator.clipboard.writeText('v=DMARC1; p=none; rua=mailto:{{ $school->email ?? 'admin@tudominio.com' }}')" class="text-primary hover:underline">Copiar</button>
                        </div>
                        <code class="block bg-gray-100 rounded-lg px-3 py-2 text-gray-800 break-all select-all">v=DMARC1; p=none; rua=mailto:{{ $school->email ?? 'admin@tudominio.com' }}</code>
                        <p class="text-gray-400 mt-1">Nombre del registro: <code class="bg-gray-100 px-1 rounded">_dmarc</code> — Tipo: <code class="bg-gray-100 px-1 rounded">TXT</code></p>
                    </div>

                    {{-- DKIM note --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-amber-800">
                        <p class="font-semibold mb-1">3. DKIM — lo genera tu proveedor de hosting</p>
                        <p>El registro DKIM es único para cada servidor. Entra en el panel de tu hosting (cPanel, Plesk, etc.) y busca la sección <strong>"Email Authentication"</strong> o <strong>"DKIM"</strong>. Te dará el registro TXT que hay que pegar en el DNS.</p>
                    </div>
                @endif

                {{-- Verification tools --}}
                <div class="pt-2 border-t border-gray-100">
                    <p class="font-semibold text-gray-600 mb-2">Verificar configuración:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="https://www.mail-tester.com" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                            mail-tester.com <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <a href="https://mxtoolbox.com/SuperTool.aspx" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                            MXToolbox <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <a href="https://dmarcian.com/dmarc-inspector/" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                            DMARC Inspector <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Save button --}}
        <div class="flex justify-end pt-2 border-t border-gray-100">
            <button type="button" wire:click="saveMailConfig" wire:loading.attr="disabled" wire:target="saveMailConfig"
                    class="btn-primary px-5 py-2 rounded-lg text-sm text-white font-semibold shadow hover:shadow-md disabled:opacity-70 transition-all">
                <svg wire:loading wire:target="saveMailConfig" class="animate-spin -ml-1 mr-2 h-4 w-4 inline" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span wire:loading.remove wire:target="saveMailConfig">Guardar configuración de correo</span>
                <span wire:loading wire:target="saveMailConfig">Guardando...</span>
            </button>
        </div>

        {{-- Test email --}}
        <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
            <p class="text-xs font-semibold text-gray-700 mb-3 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Enviar correo de prueba
            </p>
            <div class="flex gap-2 items-start">
                <div class="flex-1">
                    <input wire:model="mail_test_to" type="email" placeholder="destinatario@ejemplo.com"
                           class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900"/>
                    @error('mail_test_to') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <button type="button" wire:click="sendTestMail" wire:loading.attr="disabled" wire:target="sendTestMail"
                        class="shrink-0 px-4 py-2 rounded-lg text-sm font-semibold border border-gray-300 text-gray-700 hover:bg-white transition-colors disabled:opacity-60">
                    <span wire:loading.remove wire:target="sendTestMail">Enviar prueba</span>
                    <span wire:loading wire:target="sendTestMail">Enviando...</span>
                </button>
            </div>
            <p class="text-[10px] text-gray-400 mt-2">Usa los valores del formulario para la prueba. Guarda primero para que los cambios persistan.</p>
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
</div>
