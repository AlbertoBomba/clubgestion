<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <a href="{{ route('players.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Jugadores') }}
            </a>
            <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                <span class="hidden sm:inline">Actualizar </span>{{ $playerModel->name }} {{ $playerModel->surname }}
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route('players.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">Cancelar</span>
            </a>
            <button type="submit" form="player-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
                <svg wire:loading.remove wire:target="save" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save" class="hidden sm:inline">Actualizar</span>
                <span wire:loading wire:target="save" class="hidden sm:inline">Guardando...</span>
            </button>
        </div>
    </div>

    @if($hasChanges)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg animate-pulse">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-yellow-800">
                        ⚠️ Tienes cambios sin guardar. Haz clic en <span class="font-bold">Actualizar</span> para guardar los cambios.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit="save" id="player-form">
        <div class="space-y-8">
            
            <!-- Datos Personales -->
            <div>
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Nombre *</label>
                        <input wire:model.live="name" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Apellidos *</label>
                        <input wire:model.live="surname" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('surname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">DNI</label>
                        <input wire:model.live="dni" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dni') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Fecha Nacimiento</label>
                        <input wire:model.live="dbirth" type="date" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dbirth') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Año Nacimiento</label>
                        <input wire:model.live="dbanio" type="number" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dbanio') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Tallas</label>
                        <input wire:model.live="sizes" type="text" placeholder="Ej: M, 42, etc."
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('sizes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Datos del Tutor -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Datos del Tutor</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Nombre Tutor</label>
                        <input wire:model.live="nametutor" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('nametutor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Apellidos Tutor</label>
                        <input wire:model.live="surnametutor" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('surnametutor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">DNI Tutor</label>
                        <input wire:model.live="dnitutor" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dnitutor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Datos de Contacto -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Datos de Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="form-group lg:col-span-2">
                        <label class="block text-sm font-semibold text-titanium mb-2">Dirección</label>
                        <input wire:model.live="address" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Población</label>
                        <input wire:model.live="town" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('town') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Provincia</label>
                        <input wire:model.live="province" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('province') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Código Postal</label>
                        <input wire:model.live="zip" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('zip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Teléfono 1</label>
                        <input wire:model.live="phone1" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('phone1') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Teléfono 2</label>
                        <input wire:model.live="phone2" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('phone2') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group lg:col-span-2">
                        <label class="block text-sm font-semibold text-titanium mb-2">Email</label>
                        <input wire:model.live="email" type="email" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Datos Deportivos -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Datos Deportivos</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Dorsal</label>
                        <input wire:model.live="dorsal" type="number" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dorsal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Posición</label>
                        <input wire:model.live="position" type="text" placeholder="Ej: Delantero, Defensa, etc."
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('position') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group lg:col-span-2">
                        <label class="block text-sm font-semibold text-titanium mb-2">Código Matrícula</label>
                        <input wire:model.live="cod_matricula" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('cod_matricula') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Opciones y Estado -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Opciones y Estado</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model.live="active" type="checkbox" id="active"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="active" class="text-sm font-semibold text-titanium cursor-pointer">Activo</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model.live="soccer" type="checkbox" id="soccer"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="soccer" class="text-sm font-semibold text-titanium cursor-pointer">Fútbol</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model.live="passport" type="checkbox" id="passport"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="passport" class="text-sm font-semibold text-titanium cursor-pointer">Pasaporte</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model.live="paddle" type="checkbox" id="paddle"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="paddle" class="text-sm font-semibold text-titanium cursor-pointer">Pádel</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model.live="goalie" type="checkbox" id="goalie"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="goalie" class="text-sm font-semibold text-titanium cursor-pointer">Portero</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model.live="file" type="checkbox" id="file"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="file" class="text-sm font-semibold text-titanium cursor-pointer">Ficha Completa</label>
                    </div>
                </div>
            </div>

            <!-- Foto y Observaciones -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Foto y Observaciones</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Foto del Jugador</label>
                        
                        @if($currentPhoto)
                            <div class="mb-4 flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $currentPhoto) }}" alt="Foto actual" class="w-32 h-32 rounded-full object-cover border-4 border-primary/20">
                                <button type="button" wire:click="deletePhoto" wire:confirm="¿Estás seguro de eliminar la foto actual?"
                                    class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition text-sm font-semibold">
                                    Eliminar Foto
                                </button>
                            </div>
                        @endif

                        <div class="mt-2">
                            <input wire:model.live="player_photo" type="file" accept="image/*" id="player_photo"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-night-blue cursor-pointer">
                            @error('player_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        @if ($player_photo)
                            <div class="mt-4">
                                <p class="text-xs text-gray-500 mb-2">Vista previa de nueva foto:</p>
                                <img src="{{ $player_photo->temporaryUrl() }}" alt="Preview" class="w-32 h-32 rounded-full object-cover border-4 border-neon-green/40">
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Observaciones</label>
                        <textarea wire:model.live="observations" rows="5" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                        @error('observations') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Secciones -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Secciones del Jugador</h3>
                <p class="text-sm text-gray-600 mb-4">Seleccione las secciones en las que participa el jugador</p>
                
                @error('selectedSections') <span class="text-red-500 text-sm block mb-3">{{ $message }}</span> @enderror
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($sections as $section)
                        <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200
                            {{ in_array($section->id, $selectedSections) ? 'border-primary bg-gradient-to-br from-primary/10 to-primary/5 shadow-md' : 'border-silver bg-white hover:border-primary/30' }}">
                            <input type="checkbox" wire:model.live="selectedSections" value="{{ $section->id }}"
                                class="w-5 h-5 text-primary border-silver rounded focus:ring-primary">
                            <span class="ml-3 text-sm font-semibold {{ in_array($section->id, $selectedSections) ? 'text-primary' : 'text-titanium' }}">
                                {{ $section->name }}
                            </span>
                            @if(in_array($section->id, $selectedSections))
                                <svg class="w-4 h-4 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </label>
                    @empty
                        <div class="col-span-full">
                            <p class="text-sm text-gray-500 text-center py-4">No hay secciones disponibles para esta temporada</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </form>
</div>
