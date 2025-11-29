<div>
    <form wire:submit="save">
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-8">
            
            <!-- Datos Personales -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-titanium mb-4 pb-2 border-b border-silver">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Nombre *</label>
                        <input wire:model="name" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Apellidos *</label>
                        <input wire:model="surname" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('surname') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">DNI</label>
                        <input wire:model="dni" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dni') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Fecha Nacimiento</label>
                        <input wire:model="dbirth" type="date" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dbirth') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Año Nacimiento</label>
                        <input wire:model="dbanio" type="number" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dbanio') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Tallas</label>
                        <input wire:model="sizes" type="text" placeholder="Ej: M, 42, etc."
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
                        <input wire:model="nametutor" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('nametutor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Apellidos Tutor</label>
                        <input wire:model="surnametutor" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('surnametutor') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">DNI Tutor</label>
                        <input wire:model="dnitutor" type="text" 
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
                        <input wire:model="address" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Población</label>
                        <input wire:model="town" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('town') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Provincia</label>
                        <input wire:model="province" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('province') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Código Postal</label>
                        <input wire:model="zip" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('zip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Teléfono 1</label>
                        <input wire:model="phone1" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('phone1') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Teléfono 2</label>
                        <input wire:model="phone2" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('phone2') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group lg:col-span-2">
                        <label class="block text-sm font-semibold text-titanium mb-2">Email</label>
                        <input wire:model="email" type="email" 
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
                        <input wire:model="dorsal" type="number" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('dorsal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Posición</label>
                        <input wire:model="position" type="text" placeholder="Ej: Delantero, Defensa, etc."
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('position') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group lg:col-span-2">
                        <label class="block text-sm font-semibold text-titanium mb-2">Código Matrícula</label>
                        <input wire:model="cod_matricula" type="text" 
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
                        <input wire:model="active" type="checkbox" id="active"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="active" class="text-sm font-semibold text-titanium cursor-pointer">Activo</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model="soccer" type="checkbox" id="soccer"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="soccer" class="text-sm font-semibold text-titanium cursor-pointer">Fútbol</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model="passport" type="checkbox" id="passport"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="passport" class="text-sm font-semibold text-titanium cursor-pointer">Pasaporte</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model="paddle" type="checkbox" id="paddle"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="paddle" class="text-sm font-semibold text-titanium cursor-pointer">Pádel</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model="goalie" type="checkbox" id="goalie"
                            class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                        <label for="goalie" class="text-sm font-semibold text-titanium cursor-pointer">Portero</label>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <input wire:model="file" type="checkbox" id="file"
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
                        <div class="mt-2">
                            <input wire:model="player_photo" type="file" accept="image/*" id="player_photo"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-night-blue cursor-pointer">
                            @error('player_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        @if ($player_photo)
                            <div class="mt-4">
                                <img src="{{ $player_photo->temporaryUrl() }}" alt="Preview" class="w-32 h-32 rounded-full object-cover border-4 border-primary/20">
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-2">Observaciones</label>
                        <textarea wire:model="observations" rows="5" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                        @error('observations') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-titanium mb-3">Secciones</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($sections as $section)
                                <label class="flex items-center p-3 border border-silver rounded-xl hover:bg-primary/5 cursor-pointer transition-colors">
                                    <input type="checkbox" wire:model="selectedSections" value="{{ $section->id }}"
                                        class="w-4 h-4 text-primary border-silver rounded focus:ring-primary">
                                    <span class="ml-2 text-sm text-titanium">{{ $section->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedSections') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="flex justify-end pt-6 border-t border-silver">
                <button type="submit" 
                    class="btn-primary bg-gradient-to-r from-primary to-night-blue text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    Crear Jugador
                </button>
            </div>
        </div>
    </form>
</div>
