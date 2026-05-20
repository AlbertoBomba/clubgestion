<div>
    <div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
            <div class="flex items-center gap-2 overflow-hidden">
                <a href="{{ route('players.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                    {{ __('Jugadores') }}
                </a>
                <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
                <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                    Crear Nuevo<span class="hidden sm:inline"> Jugador</span>
                </h2>
            </div>
            
            <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
                <a href="{{ route('players.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="hidden sm:inline">Cancelar</span>
                </a>
                <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
                    <svg wire:loading.remove wire:target="save" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save" class="hidden sm:inline">Guardar</span>
                    <span wire:loading wire:target="save" class="hidden sm:inline">Guardando...</span>
                </button>
            </div>
        </div>

    <form wire:submit="save" id="player-form">
        <div class="space-y-8">
            
            <!-- Datos Personales, Datos del Tutor y Foto y Observaciones -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Datos Personales -->
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Datos Jugador
                    </h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

                            <x-date-input 
                                label="Fecha Nacimiento" 
                                model="dbirth" 
                                error="dbirth" 
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-titanium mb-2">Año Nacimiento</label>
                                <input wire:model.live="dbanio" type="number" 
                                    class="w-28 px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('dbanio') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-semibold text-titanium mb-2">Tallas</label>
                                <div class="flex gap-2">
                                    <input wire:model.live="sizes" type="text" placeholder="Selecciona una talla" readonly
                                        class="w-24 px-3 py-2 border border-silver rounded-xl bg-gray-50 text-black-deep text-sm cursor-not-allowed">
                                    <button type="button" wire:click="openSizesModal" 
                                        class="px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors whitespace-nowrap">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('sizes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-semibold text-titanium mb-2">Dorsal</label>
                                <input wire:model.live="dorsal" type="number" 
                                    class="w-24 px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('dorsal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-start gap-4 mt-6">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-titanium mb-2">Tipo de Descuento</label>
                                <select wire:model.live="discountType" 
                                    class="block w-64 px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    <option value="ninguno">Sin descuento</option>
                                    <option value="cantidad">Descuento en cantidad (€)</option>
                                    <option value="porcentaje">Descuento en porcentaje (%)</option>
                                </select>
                                @error('discountType') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            @if($discountType === 'cantidad')
                                <div class="form-group">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Cantidad (€)</label>
                                    <input wire:model.live="descEnt" type="text" onfocus="this.select()"
                                        class="w-32 px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                        placeholder="0,00">
                                    @error('descEnt') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            @if($discountType === 'porcentaje')
                                <div class="form-group">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Porcentaje (%)</label>
                                    <input wire:model.live="descPerc" type="text" onfocus="this.select()"
                                        class="w-32 px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                                        placeholder="0,00">
                                    @error('descPerc') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Datos Deportivos -->
                    <div class="mt-8 ">
                        <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            Datos Deportivos
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <div class="form-group md:col-span-6">
                                <label class="block text-sm font-semibold text-titanium mb-2">Posición</label>
                                <input wire:model.live="position" type="text" placeholder="Ej: Delantero, Defensa, etc."
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('position') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group md:col-span-6">
                                <label class="block text-sm font-semibold text-titanium mb-2">Código Matrícula</label>
                                <input wire:model.live="cod_matricula" type="text"
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('cod_matricula') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                                <input wire:model.live="active" type="checkbox" id="active"
                                    class="w-5 h-5 text-primary border-silver rounded focus:ring-2 focus:ring-primary">
                                <label for="active" class="text-sm font-semibold text-titanium cursor-pointer">Activo</label>
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

                        <!-- Secciones -->
                        <div class="mb-8">
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
                                        <p class="text-sm text-gray-500 text-center py-4">No hay secciones disponibles para la temporada actual</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                       
                    </div>
                    
                </div>

                <!-- Datos del Tutor -->
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Datos del Tutor
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                    
                    <!-- Datos de Contacto -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Datos de Contacto
                        </h3>
                        <div class="space-y-6">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-titanium mb-2">Dirección</label>
                                <input wire:model.live="address" type="text" 
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <div class="form-group md:col-span-5">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Población</label>
                                    <input wire:model.live="town" type="text" 
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('town') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group md:col-span-2">
                                    <label class="block text-sm font-semibold text-titanium mb-2">C.P.</label>
                                    <input wire:model.live="zip" type="text" maxlength="5"
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('zip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group md:col-span-5">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Provincia</label>
                                    <input wire:model.live="province" type="text" 
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('province') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <div class="form-group md:col-span-3">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Teléfono 1</label>
                                    <input wire:model.live="phone1" type="text" 
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('phone1') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group md:col-span-3">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Teléfono 2</label>
                                    <input wire:model.live="phone2" type="text" 
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('phone2') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group md:col-span-6">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Email</label>
                                    <input wire:model.live="email" type="email" 
                                        class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-titanium mb-2">Observaciones</label>
                                <textarea wire:model.live="observations" rows="2" 
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                                @error('observations') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Foto y Observaciones -->
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Foto del Jugador
                    </h3>
                    <div class="space-y-6">
                        <div class="form-group">
                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0">
                                    @if ($player_photo)
                                        <div>
                                            <p class="text-sm text-titanium mb-2 text-center">Vista previa:</p>
                                            <img src="{{ $player_photo->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-xl border-2 border-primary shadow-md">
                                        </div>
                                    @else
                                        <div class="h-32 w-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-xs text-gray-500">Sin imagen</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Subir foto del jugador</label>
                                    
                                    <input type="file" wire:model.live="player_photo" accept="image/*" 
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                    
                                    <div wire:loading wire:target="player_photo" class="text-sm text-primary mt-1">
                                        <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Subiendo foto...
                                    </div>
                                    @error('player_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    <p class="text-xs text-gray-500 mt-1">Máximo 2MB. Formatos: JPG, PNG</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipo -->
        <div class="mb-8 p-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10">
            <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Equipo
            </h3>
            <p class="text-sm text-gray-600 mb-4">Seleccione el equipo al que pertenece el jugador (opcional)</p>

            @error('selectedTeam') <span class="text-red-500 text-sm block mb-3">{{ $message }}</span> @enderror

            @if($teams->isEmpty())
                <p class="text-sm text-gray-500 text-center py-4">No hay equipos disponibles para la temporada actual</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Opción sin equipo -->
                    <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200
                        {{ $selectedTeam === null ? 'border-primary bg-gradient-to-br from-primary/10 to-primary/5 shadow-md' : 'border-silver bg-white hover:border-primary/30' }}">
                        <input type="radio" wire:model.live="selectedTeam" value=""
                            class="w-5 h-5 text-primary border-silver focus:ring-primary">
                        <span class="ml-3 text-sm font-semibold {{ $selectedTeam === null ? 'text-primary' : 'text-titanium' }}">
                            Sin equipo
                        </span>
                    </label>

                    @foreach($teams as $team)
                        <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200
                            {{ $selectedTeam == $team->id ? 'border-primary bg-gradient-to-br from-primary/10 to-primary/5 shadow-md' : 'border-silver bg-white hover:border-primary/30' }}">
                            <input type="radio" wire:model.live="selectedTeam" value="{{ $team->id }}"
                                class="w-5 h-5 text-primary border-silver focus:ring-primary">
                            <div class="ml-3 flex-1">
                                <span class="text-sm font-semibold {{ $selectedTeam == $team->id ? 'text-primary' : 'text-titanium' }}">
                                    {{ $team->team }}
                                </span>
                                @if($team->category)
                                    <p class="text-xs text-gray-500">{{ $team->category->category }}</p>
                                @endif
                            </div>
                            @if($selectedTeam == $team->id)
                                <svg class="w-4 h-4 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </label>
                    @endforeach
                </div>
            @endif
        </div>
    </form>
    </div>

    <!-- Modal de Tallas -->
    @if($showSizesModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeSizesModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-4">
                            <h3 class="text-2xl font-bold text-titanium flex items-center">
                                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Seleccionar Talla
                            </h3>
                            <button type="button" wire:click="closeSizesModal" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            @if($availableSizes->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No hay tallas asociadas a esta escuela.</p>
                                    <p class="text-xs text-gray-400 mt-1">Por favor, asocia marcas a tu escuela deportiva.</p>
                                </div>
                            @else
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-h-96 overflow-y-auto">
                                    @php
                                        $currentBrand = null;
                                    @endphp
                                    
                                    @foreach($availableSizes as $size)
                                        @if($currentBrand !== $size->brand_id)
                                            @php $currentBrand = $size->brand_id; @endphp
                                            <div class="col-span-full mt-3 mb-2">
                                                <h4 class="text-sm font-bold text-primary uppercase tracking-wide">
                                                    {{ $size->brand->brand ?? 'Sin marca' }}
                                                </h4>
                                                <div class="h-px bg-primary/20 mt-1"></div>
                                            </div>
                                        @endif
                                        
                                        <button type="button" wire:click="selectSize({{ $size->id }})"
                                            class="p-4 border-2 rounded-xl transition-all duration-200 hover:border-primary hover:bg-primary/5 hover:shadow-md
                                                {{ $sizes === $size->size ? 'border-primary bg-primary/10' : 'border-gray-200' }}">
                                            <div class="text-center">
                                                <p class="text-lg font-bold text-titanium">{{ $size->size }}</p>
                                                @if($size->description)
                                                    <p class="text-xs text-gray-500 mt-1">{{ $size->description }}</p>
                                                @endif
                                                @if($size->edad || $size->pecho || $size->cintura || $size->cadera)
                                                    <div class="mt-2 text-xs text-gray-600 space-y-0.5">
                                                        @if($size->edad)
                                                            <p>Edad: {{ $size->edad }}</p>
                                                        @endif
                                                        @if($size->pecho)
                                                            <p>Pecho: {{ $size->pecho }}</p>
                                                        @endif
                                                        @if($size->cintura)
                                                            <p>Cintura: {{ $size->cintura }}</p>
                                                        @endif
                                                        @if($size->cadera)
                                                            <p>Cadera: {{ $size->cadera }}</p>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closeSizesModal"
                            class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
