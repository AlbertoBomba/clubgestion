<div>
    <div class="card-modern bg-white rounded-2xl shadow-xl border border-purple-100 p-6 sm:p-8">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Información Básica
                </h3>
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre de la Escuela <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="name" type="text" id="name" required
                        class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                    <textarea wire:model="description" id="description" rows="3"
                        class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900"></textarea>
                </div>

                <!-- Logo Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Logo de la Escuela
                    </label>
                    
                    @if ($logo)
                        <div class="mb-4 p-4 bg-green-50 rounded-xl border border-green-200">
                            <p class="text-sm text-green-700 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Logo seleccionado: {{ $logo->getClientOriginalName() }}
                            </p>
                            <img src="{{ $logo->temporaryUrl() }}" alt="Vista previa" class="mt-3 h-20 w-20 object-contain rounded-lg border border-gray-300 bg-white p-2">
                        </div>
                    @endif

                    <div class="flex items-center justify-center w-full">
                        <label for="logo-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Click para subir</span> o arrastra y suelta</p>
                                <p class="text-xs text-gray-400">PNG, JPG, GIF hasta 2MB</p>
                            </div>
                            <input id="logo-upload" type="file" wire:model="logo" class="hidden" accept="image/*">
                        </label>
                    </div>
                    @error('logo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    
                    <div wire:loading wire:target="logo" class="mt-2 text-sm text-purple-600 flex items-center">
                        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Subiendo imagen...
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Ubicación
                </h3>

                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                    <input wire:model="address" type="text" id="address"
                        class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">Ciudad</label>
                        <input wire:model="city" type="text" id="city"
                            class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900">
                    </div>
                    <div>
                        <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-2">Código Postal</label>
                        <input wire:model="postal_code" type="text" id="postal_code"
                            class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contacto
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                        <input wire:model="phone" type="text" id="phone"
                            class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input wire:model="email" type="email" id="email"
                            class="input-field block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-gray-900">
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200">
                <label for="is_active" class="flex items-center cursor-pointer group">
                    <input wire:model="is_active" type="checkbox" id="is_active"
                        class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 cursor-pointer">
                    <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-gray-900">Escuela Activa</span>
                </label>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('sports-schools.index') }}" 
                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                    class="btn-primary px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1">
                    Crear Escuela
                </button>
            </div>
        </form>
    </div>
</div>