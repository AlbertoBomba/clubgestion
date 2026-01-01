<div>
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
            <button type="button" wire:click="printPlayerCard" wire:loading.attr="disabled" wire:target="printPlayerCard" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
                <svg wire:loading.remove wire:target="printPlayerCard" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <svg wire:loading wire:target="printPlayerCard" class="animate-spin h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="printPlayerCard" class="hidden sm:inline">Imprimir</span>
                <span wire:loading wire:target="printPlayerCard" class="hidden sm:inline">Generando...</span>
            </button>
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
                    {{-- <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg> --}}
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
                                <input wire:model.live="cod_matricula" type="text" disabled
                                    class="w-full px-3 py-2 border border-silver rounded-xl bg-gray-100 text-gray-500 text-sm cursor-not-allowed">
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
                            {{-- <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Secciones del Jugador
                            </h3> --}}
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
                    
                </div>

                <!-- Datos del Tutor -->
                @if(!$this->isAdult)
                <div>
                    <!-- Equipo del Jugador -->
                    <div class="mb-8">
                        {{-- <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3v0a3 3 0 00-3 3v2zm-5-2a3 3 0 013-3m0 0a3 3 0 013 3m-6 0h6m2-13a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Equipo del Jugador
                        </h3> --}}
                        
                        @if($playerTeam)
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 border-2 border-blue-200 rounded-xl p-4">
                                <div class="flex items-center gap-3">
                                    @if($playerTeam->team_image)
                                        <img src="{{ asset('storage/' . $playerTeam->team_image) }}" alt="{{ $playerTeam->team }}" class="w-12 h-12 rounded-full object-cover border-2 border-blue-300">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-blue-200 flex items-center justify-center border-2 border-blue-300">
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Equipo asignado</p>
                                        <p class="text-lg font-bold text-blue-700">{{ $playerTeam->team }}</p>
                                        @if($playerTeam->category)
                                            <p class="text-xs text-gray-500">Categoría: {{ $playerTeam->category->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-yellow-800">El jugador no tiene equipo asignado</p>
                                        <p class="text-xs text-yellow-700 mt-1">Por favor, asigna al jugador a un equipo desde la gestión de equipos.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

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
                @endif

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
                                    @elseif($currentPhoto)
                                        <div>
                                            <div class="relative inline-block">
                                                <img src="{{ asset('storage/' . $currentPhoto) }}" 
                                                    class="h-32 w-32 object-cover rounded-xl border-2 border-silver shadow-md">
                                                <button type="button" wire:click="deletePhoto" wire:confirm="¿Estás seguro de eliminar la foto actual?"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
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
                                    <label class="block text-sm font-semibold text-titanium mb-2">{{ $currentPhoto ? 'Cambiar foto del jugador' : 'Subir foto del jugador' }}</label>
                                    
                                    <!-- Editor de recorte de imagen -->
                                    <div id="player-photo-editor" class="hidden mb-3 border-2 border-dashed border-primary rounded-xl p-4">
                                        <div class="mb-3">
                                            <img id="player-crop-image" style="max-width: 100%; display: block;">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="cropAndUploadPlayerPhoto()" 
                                                class="flex-1 px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                                                ✂️ Recortar y Usar
                                            </button>
                                            <button type="button" onclick="cancelPlayerPhotoCrop()" 
                                                class="px-4 py-2 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
                                                ✕ Cancelar
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <input type="file" id="player-photo-file-input" accept="image/*" 
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"
                                        onchange="handlePlayerPhotoSelect(event)">
                                    
                                    <!-- Input oculto para Livewire -->
                                    <input type="file" wire:model.live="player_photo" id="player-photo-livewire-input" accept="image/*" class="hidden">
                                    
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
                    <!-- Documentación -->
                    <div class="mb-8">
                        {{-- <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Documentación
                        </h3> --}}

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-semibold text-titanium mb-2">Agregar nuevo documento:</p>
                                <div class="p-3 border border-silver rounded-xl bg-gray-50/50">
                                    <label class="block text-sm font-semibold text-titanium mb-2">
                                        Tipo de documento *
                                    </label>
                                    <select wire:model.live="documentType" 
                                        class="block w-full px-3 py-2 mb-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-black-deep text-sm @error('documentType') border-red-500 @enderror">
                                        <option value="">Selecciona el tipo</option>
                                        <option value="dni_frontal">DNI Frontal</option>
                                        <option value="dni_trasero">DNI Trasero</option>
                                        <option value="ficha_medica">Ficha Médica</option>
                                        <option value="autorizacion">Autorización</option>
                                        <option value="otros">Otros documentos</option>
                                    </select>
                                    @error('documentType') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    
                                    @if($documentType === 'otros')
                                        <div class="mb-3">
                                            <label class="block text-sm font-semibold text-titanium mb-2">
                                                Descripción del documento
                                            </label>
                                            <input type="text" wire:model.live="documentLabel" 
                                                placeholder="Ej: Certificado médico, Autorización..." 
                                                class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-black-deep text-sm @error('documentLabel') border-red-500 @enderror">
                                            @error('documentLabel') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    @endif
                                    
                                    @if($documentType)
                                        <label class="block text-sm font-semibold text-titanium mb-2">
                                            Archivo
                                        </label>
                                        
                                        @if(in_array($documentType, ['dni_frontal', 'dni_trasero']))
                                        <!-- Opción de captura de foto para DNI -->
                                        <div class="space-y-3">
                                            <div class="flex gap-2">
                                                <button type="button" onclick="activateCamera()" 
                                                    class="flex-1 px-4 py-2 bg-primary/10 text-primary rounded-xl font-semibold text-sm hover:bg-primary/20 transition-colors">
                                                    📷 Tomar Foto
                                                </button>
                                                <label class="flex-1 cursor-pointer">
                                                    <div class="px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors text-center">
                                                        📁 Subir Archivo
                                                    </div>
                                                    <input type="file" id="dni-file-input" accept="image/*" class="hidden" onchange="handleDniFileSelect(event)">
                                                </label>
                                            </div>
                                            
                                            @if($captureMode)
                                                <div class="border-2 border-dashed border-primary rounded-xl p-4" wire:ignore>
                                                    <div class="relative bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/10;">
                                                        <video id="camera-preview" autoplay playsinline muted class="w-full h-full object-cover"></video>
                                                    </div>
                                                    <div class="flex gap-2 mt-3">
                                                        <button type="button" onclick="capturePhoto()" 
                                                            class="flex-1 px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                                                            📸 Capturar
                                                        </button>
                                                        <button type="button" onclick="cancelCamera()" 
                                                            class="px-4 py-2 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
                                                            ✕ Cancelar
                                                        </button>
                                                    </div>
                                                    <canvas id="photo-canvas" class="hidden"></canvas>
                                                </div>
                                            @endif
                                            
                                            <!-- Editor de imagen DNI -->
                                            <div id="dni-editor" class="hidden border-2 border-dashed border-primary rounded-xl p-4">
                                                <div class="mb-3">
                                                    <img id="dni-crop-image" style="max-width: 100%; display: block;">
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button" onclick="cropAndUploadDni()" 
                                                        class="flex-1 px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                                                        ✂️ Recortar y Usar
                                                    </button>
                                                    <button type="button" onclick="cancelDniCrop()" 
                                                        class="px-4 py-2 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
                                                        ✕ Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- Input oculto para Livewire -->
                                            <input type="file" wire:model.live="document" id="dni-livewire-input" accept="image/*" class="hidden">
                                        </div>
                                    @else
                                        <!-- Subida normal de archivos para otros documentos -->
                                        <input type="file" wire:model.live="document" 
                                            accept=".pdf,.jpg,.jpeg,.png" 
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                    @endif
                                        <div wire:loading wire:target="document" class="text-xs text-primary mt-1">
                                            <svg class="animate-spin h-3 w-3 inline mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Subiendo...
                                        </div>
                                        
                                        @if ($document && !$captureMode)
                                            <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-lg">
                                                <p class="text-xs text-green-700">✓ Archivo seleccionado: {{ $document->getClientOriginalName() }}</p>
                                            </div>
                                        @endif
                                        
                                        @error('document') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        
                                        <!-- Botón para subir documento -->
                                        @if($document)
                                            <button type="button" wire:click="uploadDocument" 
                                                class="mt-3 w-full px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors shadow-md hover:shadow-lg">
                                                <span wire:loading.remove wire:target="uploadDocument">📤 Subir Documento</span>
                                                <span wire:loading wire:target="uploadDocument">
                                                    <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Subiendo...
                                                </span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            @error('document') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                @if(in_array($documentType, ['dni_frontal', 'dni_trasero']))
                                    Máximo 5MB. Solo imágenes (JPG, PNG)
                                @else
                                    Máximo 5MB. Formatos: PDF, JPG, PNG
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(!empty($existingDocuments))
                        <div class="mt-4">
                            <p class="text-sm font-semibold text-titanium mb-2">Documentos actuales:</p>
                            @foreach($existingDocuments as $index => $doc)
                                <div class="flex items-center justify-between p-3 mb-2 border border-silver rounded-xl bg-gray-50">
                                    <div class="flex items-center space-x-3">
                                        @if(str_ends_with($doc['path'], '.pdf'))
                                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                            </svg>
                                        @else
                                            <!-- Miniatura de imagen -->
                                            <img src="{{ asset('storage/' . $doc['path']) }}" 
                                                 alt="{{ $doc['label'] }}"
                                                 class="w-16 h-16 object-cover rounded-lg border-2 border-primary/20">
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-titanium">{{ $doc['label'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $doc['original_name'] ?? 'Documento' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                                            class="text-primary hover:text-primary/70 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <button type="button" wire:click="confirmDeleteDocument({{ $index }})"
                                            class="text-red-500 hover:text-red-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div> 
        </div>
    </form>
    </div>

    @assets
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @endassets

    @script
    <script>
        let playerPhotoCropper = null;
        let dniCropper = null;
        let stream = null;
        let currentComponent = null;

        document.addEventListener('livewire:initialized', () => {
            currentComponent = @this;
            
            // Escuchar cuando se active el modo captura
            window.addEventListener('start-camera', () => {
                setTimeout(() => startCamera(), 300);
            });
        });
        
        // Activar cámara
        window.activateCamera = function() {
            if (currentComponent) {
                currentComponent.set('captureMode', true);
                setTimeout(() => startCamera(), 500);
            }
        }
        
        // Cancelar cámara
        window.cancelCamera = function() {
            stopCamera();
            if (currentComponent) {
                currentComponent.set('captureMode', false);
            }
        }

        // Manejar selección de foto del jugador para recortar
        window.handlePlayerPhotoSelect = function(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Mostrar editor de recorte
            const editor = document.getElementById('player-photo-editor');
            const image = document.getElementById('player-crop-image');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                editor.classList.remove('hidden');
                
                // Destruir cropper anterior si existe
                if (playerPhotoCropper) {
                    playerPhotoCropper.destroy();
                }
                
                // Inicializar Cropper con proporción cuadrada
                playerPhotoCropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            };
            reader.readAsDataURL(file);
        }
        
        // Recortar y subir foto del jugador
        window.cropAndUploadPlayerPhoto = function() {
            if (!playerPhotoCropper) return;
            
            playerPhotoCropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            }).toBlob(function(blob) {
                const timestamp = Date.now();
                const file = new File([blob], `player-photo-${timestamp}.jpg`, { type: 'image/jpeg' });
                
                // Asignar al input de Livewire
                const livewireInput = document.getElementById('player-photo-livewire-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                livewireInput.files = dataTransfer.files;
                
                // Disparar evento change para Livewire
                const event = new Event('change', { bubbles: true });
                livewireInput.dispatchEvent(event);
                
                // Cerrar editor
                window.cancelPlayerPhotoCrop();
            }, 'image/jpeg', 0.95);
        }
        
        // Cancelar recorte de foto del jugador
        window.cancelPlayerPhotoCrop = function() {
            const editor = document.getElementById('player-photo-editor');
            const fileInput = document.getElementById('player-photo-file-input');
            
            if (playerPhotoCropper) {
                playerPhotoCropper.destroy();
                playerPhotoCropper = null;
            }
            
            editor.classList.add('hidden');
            fileInput.value = '';
        }

        // Manejar selección de archivo DNI para recortar
        window.handleDniFileSelect = function(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Mostrar editor de recorte
            const editor = document.getElementById('dni-editor');
            const image = document.getElementById('dni-crop-image');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                editor.classList.remove('hidden');
                
                // Destruir cropper anterior si existe
                if (dniCropper) {
                    dniCropper.destroy();
                }
                
                // Inicializar Cropper con proporción de DNI (85.6mm x 53.98mm ≈ 1.586:1)
                dniCropper = new Cropper(image, {
                    aspectRatio: 1.586,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            };
            reader.readAsDataURL(file);
        }
        
        // Recortar y subir imagen DNI
        window.cropAndUploadDni = function() {
            if (!dniCropper) return;
            
            dniCropper.getCroppedCanvas({
                width: 1920,
                height: 1210,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            }).toBlob(function(blob) {
                const timestamp = Date.now();
                const file = new File([blob], `dni-cropped-${timestamp}.jpg`, { type: 'image/jpeg' });
                
                // Asignar al input de Livewire
                const livewireInput = document.getElementById('dni-livewire-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                livewireInput.files = dataTransfer.files;
                
                // Disparar evento change para Livewire
                const event = new Event('change', { bubbles: true });
                livewireInput.dispatchEvent(event);
                
                // Cerrar editor
                window.cancelDniCrop();
            }, 'image/jpeg', 0.95);
        }
        
        // Cancelar recorte DNI
        window.cancelDniCrop = function() {
            const editor = document.getElementById('dni-editor');
            const fileInput = document.getElementById('dni-file-input');
            
            if (dniCropper) {
                dniCropper.destroy();
                dniCropper = null;
            }
            
            editor.classList.add('hidden');
            fileInput.value = '';
        }

        async function startCamera() {
            try {
                const video = document.getElementById('camera-preview');
                if (!video) return;
                
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment',
                        width: { ideal: 1920 },
                        height: { ideal: 1080 }
                    } 
                });
                video.srcObject = stream;
                await video.play();
            } catch (err) {
                console.error('Error al acceder a la cámara:', err);
                alert('No se pudo acceder a la cámara. Por favor, usa la opción de subir archivo.');
                if (currentComponent) {
                    currentComponent.set('captureMode', false);
                }
            }
        }
        
        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }
        
        window.capturePhoto = async function() {
            const video = document.getElementById('camera-preview');
            const canvas = document.getElementById('photo-canvas');
            
            if (!video || !canvas) return;
            
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            
            // Convertir canvas a blob
            canvas.toBlob(async (blob) => {
                if (!blob) return;
                
                // Crear archivo desde el blob
                const timestamp = Date.now();
                const file = new File([blob], `dni-capture-${timestamp}.jpg`, { type: 'image/jpeg' });
                
                // Encontrar el input de Livewire
                const livewireInput = document.getElementById('dni-livewire-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                livewireInput.files = dataTransfer.files;
                
                // Disparar evento change para Livewire
                const event = new Event('change', { bubbles: true });
                livewireInput.dispatchEvent(event);
                
                // Detener cámara y cerrar modo captura
                stopCamera();
                if (currentComponent) {
                    currentComponent.set('captureMode', false);
                }
            }, 'image/jpeg', 0.9);
        }

        // Limpiar al salir
        window.addEventListener('beforeunload', () => {
            stopCamera();
            if (dniCropper) {
                dniCropper.destroy();
            }
            if (playerPhotoCropper) {
                playerPhotoCropper.destroy();
            }
        });
    </script>
    @endscript

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

    <!-- Modal de Confirmación Eliminar Documento -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cancelDeleteDocument"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Eliminar Documento
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de eliminar este documento? Esta acción no se puede deshacer y el archivo se eliminará permanentemente.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="deleteDocument"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                        <button type="button" wire:click="cancelDeleteDocument"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
