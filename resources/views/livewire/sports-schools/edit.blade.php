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
                    <input wire:model="name" type="text" id="name" required
                        class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                    <textarea wire:model="description" id="description" rows="2"
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
                            <input id="logo-upload" type="file" wire:model="logo" class="hidden" accept="image/*">
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
                    <input wire:model="address" type="text" id="address"
                        class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                    @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700 mb-1">Ciudad</label>
                        <input wire:model="city" type="text" id="city"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-semibold text-gray-700 mb-1">Provincia</label>
                        <input wire:model="province" type="text" id="province"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('province') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-1">Código Postal</label>
                    <input wire:model="postal_code" type="text" id="postal_code"
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
                        <input wire:model="contact_person" type="text" id="contact_person"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('contact_person') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                        <input wire:model="phone" type="text" id="phone"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input wire:model="email" type="email" id="email"
                            class="input-field block w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 flex items-center justify-between pt-4 border-t border-gray-200">
                <label for="is_active" class="flex items-center cursor-pointer group">
                    <input wire:model="is_active" type="checkbox" id="is_active"
                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                    <span class="ml-2 text-sm font-semibold text-gray-700 group-hover:text-gray-900">Escuela Activa</span>
                </label>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('sports-schools.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                        class="btn-primary px-4 py-2 rounded-lg text-sm text-white font-semibold shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all">
                        Actualizar Escuela
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
