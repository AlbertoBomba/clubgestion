<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <!-- Header con migas de pan y botones -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <a href="{{ route('teams.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Equipos') }}
            </a>
            <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate flex items-center gap-2">
                <span class="hidden sm:inline">Editar </span>{{ $teamName }}
                @if($federate)
                    <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Federado
                    </span>
                @endif
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route('teams.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">Volver</span>
            </a>
            
            @if($team->payments_count > 0 || $team->players->count() > 0)
                <!-- Botón eliminar deshabilitado con tooltip -->
                <div class="relative group">
                    <button 
                        disabled
                        class="inline-flex items-center px-3 py-2 sm:px-4 bg-gray-400 text-white rounded-xl cursor-not-allowed opacity-60 text-xs sm:text-sm font-semibold whitespace-nowrap">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="hidden sm:inline">Eliminar</span>
                    </button>
                    <div class="absolute hidden group-hover:block bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded whitespace-nowrap z-10 shadow-lg">
                        @if($team->payments_count > 0 && $team->players->count() > 0)
                            Este equipo tiene {{ $team->players->count() }} {{ $team->players->count() == 1 ? 'jugador' : 'jugadores' }} y {{ $team->payments_count }} {{ $team->payments_count == 1 ? 'pago generado' : 'pagos generados' }}
                        @elseif($team->payments_count > 0)
                            Este equipo tiene {{ $team->payments_count }} {{ $team->payments_count == 1 ? 'pago generado' : 'pagos generados' }}
                        @else
                            Este equipo tiene {{ $team->players->count() }} {{ $team->players->count() == 1 ? 'jugador' : 'jugadores' }}
                        @endif
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900"></div>
                    </div>
                </div>
            @else
                <!-- Botón eliminar activo -->
                <button 
                    wire:click="confirmDelete" 
                    wire:loading.attr="disabled"
                    wire:target="confirmDelete"
                    class="inline-flex items-center px-3 py-2 sm:px-4 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors duration-200 text-xs sm:text-sm font-semibold disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                    <svg wire:loading.remove wire:target="confirmDelete" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg wire:loading wire:target="confirmDelete" class="animate-spin h-4 w-4 sm:h-5 sm:w-5 sm:mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="hidden sm:inline">Eliminar</span>
                </button>
            @endif
            
            <button type="submit" form="team-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
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

    <!-- Alerta de cambios sin guardar -->
    @if($hasChanges)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg animate-pulse">
            <p class="text-sm font-semibold text-yellow-800">
                ⚠️ Tienes cambios sin guardar. Haz clic en <span class="font-bold">Actualizar</span> para guardar los cambios.
            </p>
        </div>
    @endif

    <form wire:submit.prevent="save" id="team-form">
        <div class="space-y-8">
            
            <!-- Layout con dos columnas principales -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Columna izquierda: Datos del equipo (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-titanium mb-4 flex items-center border-b border-silver/30 pb-3">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Datos del Equipo
                        </h3>
                    </div>
                    
                    <!-- Imagen del Equipo y Datos básicos en la misma fila -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Imagen del Equipo (1/3) -->
                        <div class="lg:col-span-1">
                            <label class="block text-sm font-semibold text-titanium mb-2">Imagen del Equipo</label>
                            <div class="space-y-3">
                                <!-- Preview actual de la imagen -->
                                @if($team->team_image)
                                    <img src="{{ asset('storage/' . $team->team_image) }}" 
                                        class="w-full h-32 rounded-xl object-cover border-2 border-silver shadow-sm">
                                @else
                                    <div class="w-full h-32 rounded-xl bg-gray-100 border-2 border-dashed border-silver flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Upload input -->
                                <input type="file" wire:model.live="teamImage" accept="image/*" 
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('teamImage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500">Imagen rectangular (ej: 1200x800px)</p>
                                
                                <!-- Preview temporal -->
                                @if($teamImage)
                                    <div>
                                        <p class="text-xs text-green-600 font-medium mb-1">Vista previa:</p>
                                        <img src="{{ $teamImage->temporaryUrl() }}" 
                                            class="w-full h-32 rounded-xl object-cover border-2 border-primary shadow-sm">
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-titanium mb-2">Precio Matrícula (€)</label>
                                @if($team->payments_count > 0)
                                    <!-- Campo bloqueado si tiene pagos generados -->
                                    <div class="relative">
                                        <input type="text" value="{{ $price }}" disabled
                                            class="w-32 px-3 py-2 border border-gray-300 rounded-xl bg-gray-100 text-gray-600 text-sm font-semibold cursor-not-allowed">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-2 p-2 bg-blue-50 border border-blue-300 rounded-lg flex items-start gap-2">
                                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-xs text-blue-800 font-medium">Este equipo tiene {{ $team->payments_count }} {{ $team->payments_count == 1 ? 'pago generado' : 'pagos generados' }}. El precio no se puede modificar para mantener la consistencia de datos.</span>
                                    </div>
                                @else
                                    <!-- Campo editable si no tiene pagos -->
                                    <input wire:model.live="price" type="text" inputmode="decimal" pattern="[0-9]*[.,]?[0-9]*" maxlength="10"
                                        class="w-32 px-3 py-2 border rounded-xl focus:ring-2 text-black-deep text-sm font-semibold @if(empty($price) || $price == 0) border-amber-400 bg-amber-50 focus:ring-amber-500 focus:border-amber-500 @else border-silver focus:ring-primary focus:border-transparent @endif"
                                        placeholder="0.00">
                                    @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    @if(empty($price) || $price == 0)
                                        <div class="mt-2 p-2 bg-amber-50 border border-amber-300 rounded-lg flex items-start gap-2">
                                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <span class="text-xs text-amber-800 font-medium">No se generará la orden de pago a estos jugadores, si el precio de la matrícula es 0</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Nombre y Descripción (2/3) -->
                        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Nombre del Equipo *</label>
                                <input wire:model.live="teamName" type="text" 
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('teamName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                                <input wire:model.live="description" type="text"
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Categoría *</label>
                            <select wire:model.live="category_id" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                <option value="">Seleccione una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Género *</label>
                            <select wire:model.live="gender" 
                                class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="mixto">Mixto</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                            <input type="text" value="{{ $seasons->firstWhere('id', $season_id)?->season ?? 'No asignada' }}" disabled
                                class="w-full px-3 py-2 border border-silver rounded-xl bg-gray-100 text-gray-500 text-sm cursor-not-allowed">
                            @error('season_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Sección *</label>
                            <input type="text" value="{{ $sections->firstWhere('id', $section_id)?->name ?? 'No asignada' }}" disabled
                                class="w-full px-3 py-2 border border-silver rounded-xl bg-gray-100 text-gray-500 text-sm cursor-not-allowed">
                            @error('section_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer p-4 rounded-xl border-2 border-dashed transition-all hover:border-primary hover:shadow-md @if($federate) border-primary bg-blue-50 shadow-sm @else border-gray-300 bg-gray-50 @endif w-full">
                                <input type="checkbox" wire:model.live="federate" 
                                    class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2">
                                <span class="ml-3 text-sm font-bold @if($federate) text-primary @else text-titanium @endif">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Equipo Federado
                                </span>
                            </label>
                        </div>
                    </div>
                        </div>
                        
                


                    
                </div>

                <!-- Columna derecha: Entrenadores (1/3) -->
                <div class="lg:col-span-1">
                    <h3 class="text-lg font-bold text-titanium mb-4 flex items-center border-b border-silver/30 pb-3">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Entrenadores
                    </h3>
                    
                    <div class="mb-3">
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="searchCoach" 
                                placeholder="Buscar entrenador..."
                                class="w-full px-4 py-2 pl-10 border border-silver rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                        
                        @if(count($selectedCoaches) > 0)
                            <p class="text-xs text-gray-600 mb-3 p-2 bg-green-50 rounded-lg border border-green-200">
                                <svg class="w-4 h-4 inline text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ count($selectedCoaches) }} entrenador(es) seleccionado(s)
                            </p>
                        @endif
                        
                        @if(count($availableCoaches) === 0)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <p class="text-amber-800 text-sm">No hay entrenadores disponibles en esta escuela.</p>
                            </div>
                        @else
                            <div class="max-h-96 overflow-y-auto pr-2">
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($availableCoaches as $coach)
                                        <label wire:key="coach-{{ $coach->id }}" class="flex flex-col p-3 border rounded-xl cursor-pointer transition-all
                                            {{ in_array($coach->id, $selectedCoaches) ? 'border-primary bg-primary/10 shadow-md' : 'border-silver hover:bg-gray-50' }}">
                                            <div class="flex items-start gap-2">
                                                <input type="checkbox" wire:model.live="selectedCoaches" value="{{ $coach->id }}"
                                                    {{ in_array($coach->id, $selectedCoaches) ? 'checked' : '' }}
                                                    class="w-4 h-4 mt-0.5 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 flex-shrink-0">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        @if($coach->profile_photo_path)
                                                            <img src="{{ asset('storage/' . $coach->profile_photo_path) }}" 
                                                                class="w-8 h-8 rounded-full object-cover border border-silver flex-shrink-0">
                                                        @else
                                                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                                <span class="text-primary text-xs font-semibold">{{ substr($coach->name, 0, 1) }}</span>
                                                            </div>
                                                        @endif
                                                        <p class="text-sm font-medium text-titanium truncate">{{ $coach->name }}</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 truncate ml-10">{{ $coach->email }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                         
                </div>
            </div>
        </div>
    </form>

    <!-- Listado de Jugadores del Equipo -->
    <div class="mt-8">
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-silver/30 pb-3">
                <h3 class="text-lg font-bold text-titanium flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Jugadores del Equipo
                    <span class="ml-2 px-2 py-1 bg-primary/10 text-primary rounded-lg text-xs font-semibold">
                        {{ $teamPlayers->count() }}
                    </span>
                </h3>
                
                <div class="flex items-center gap-3">
                    <!-- Botón Agregar Jugadores -->
                    <button type="button" wire:click="openAddPlayerModal" wire:loading.attr="disabled" wire:target="openAddPlayerModal"
                        class="px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary-dark transition-colors flex items-center gap-2 text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg wire:loading.remove wire:target="openAddPlayerModal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <svg wire:loading wire:target="openAddPlayerModal" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="openAddPlayerModal">Agregar Jugadores</span>
                        <span wire:loading wire:target="openAddPlayerModal">Cargando...</span>
                    </button>
                    
                    <!-- Buscador -->
                    <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="searchPlayer" 
                        placeholder="Buscar jugaor por nombre o DNI..."
                        class="w-full sm:w-64 px-4 py-2 pl-10 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        @if($teamPlayers->isEmpty())
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-gray-600 font-medium">No hay jugadores asignados a este equipo</p>
                <p class="text-gray-500 text-sm mt-1">Los jugadores se pueden agregar desde la gestión de jugadores</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Jugador
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                DNI
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Fecha Nacimiento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Dorsal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Posición
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-titanium uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-titanium uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($teamPlayers as $player)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($player->player_photo)
                                            <img src="{{ asset('storage/' . $player->player_photo) }}" 
                                                class="w-10 h-10 rounded-full object-cover mr-3 border-2 border-silver">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                                                <span class="text-primary text-sm font-semibold">{{ substr($player->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold text-titanium">{{ $player->name }} {{ $player->surname }}</div>
                                            <div class="text-xs text-gray-500">{{ $player->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-titanium">{{ $player->dni ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-titanium">
                                        {{ $player->dbirth ? $player->dbirth->format('d/m/Y') : '-' }}
                                    </div>
                                    @if($player->dbirth)
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($player->dbirth)->age }} años
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-primary">{{ $player->dorsal ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-titanium">{{ $player->position ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($player->active)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Botón Mover a otro equipo -->
                                        <button type="button" wire:click="openMovePlayerModal({{ $player->id }})" wire:loading.attr="disabled" wire:target="openMovePlayerModal({{ $player->id }})"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            title="Mover a otro equipo">
                                            <svg wire:loading.remove wire:target="openMovePlayerModal({{ $player->id }})" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                            <svg wire:loading wire:target="openMovePlayerModal({{ $player->id }})" class="animate-spin w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove wire:target="openMovePlayerModal({{ $player->id }})">Mover</span>
                                            <span wire:loading wire:target="openMovePlayerModal({{ $player->id }})">...</span>
                                        </button>
                                        
                                        <!-- Botón Quitar del equipo -->
                                        <button type="button" wire:click="confirmRemovePlayer({{ $player->id }})" wire:loading.attr="disabled" wire:target="confirmRemovePlayer({{ $player->id }})"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            title="Quitar del equipo">
                                            <svg wire:loading.remove wire:target="confirmRemovePlayer({{ $player->id }})" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <svg wire:loading wire:target="confirmRemovePlayer({{ $player->id }})" class="animate-spin w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove wire:target="confirmRemovePlayer({{ $player->id }})">Quitar</span>
                                            <span wire:loading wire:target="confirmRemovePlayer({{ $player->id }})">...</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal: Confirmar eliminación de jugador -->
    <x-confirmation-modal wire:model.live="confirmingPlayerRemoval">
        <x-slot name="title">
            Quitar Jugador del Equipo
        </x-slot>

        <x-slot name="content">
            ¿Está seguro de quitar a este jugador del equipo? Esta acción no eliminará al jugador de la base de datos, solo lo quitará de este equipo.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelRemovePlayer">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="removePlayer" wire:loading.attr="disabled" wire:target="removePlayer">
                <span wire:loading.remove wire:target="removePlayer">Quitar del Equipo</span>
                <span wire:loading wire:target="removePlayer" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Quitando...
                </span>
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Modal: Mover jugador a otro equipo -->
    <x-dialog-modal wire:model.live="showMovePlayerModal">
        <x-slot name="title">
            Mover Jugador a Otro Equipo
        </x-slot>

        <x-slot name="content">
            @if($playerToMoveName)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-blue-900 font-semibold text-sm">
                        <svg class="w-4 h-4 inline text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Jugador: {{ $playerToMoveName }}
                    </p>
                </div>
            @endif
            
            <p class="text-gray-700 mb-4">
                Seleccione el equipo al que desea mover al jugador:
            </p>
            
            @if($availableTeams->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <p class="text-amber-800 text-sm">
                        No hay otros equipos disponibles en esta temporada.
                    </p>
                </div>
            @else
                <select wire:model.live="targetTeamId" 
                    class="w-full px-3 py-2 border border-silver rounded-md focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep">
                    <option value="">Seleccione un equipo...</option>
                    @foreach($availableTeams as $availableTeam)
                        <option value="{{ $availableTeam->id }}">{{ $availableTeam->team }}</option>
                    @endforeach
                </select>
                @error('targetTeamId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            @endif
            
            <p class="text-xs text-gray-500 mt-3">
                <svg class="w-4 h-4 inline text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Solo se muestran equipos de la misma temporada y sección.
            </p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelMovePlayer">
                Cancelar
            </x-secondary-button>

            <x-button class="ms-3" wire:click="movePlayer" wire:loading.attr="disabled" wire:target="movePlayer" :disabled="$availableTeams->isEmpty() || !$targetTeamId">
                <span wire:loading.remove wire:target="movePlayer">Mover Jugador</span>
                <span wire:loading wire:target="movePlayer" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Moviendo...
                </span>
            </x-button>
        </x-slot>
    </x-dialog-modal>
    
    <!-- Modal Agregar Jugadores -->
    <x-dialog-modal wire:model.live="showAddPlayerModal">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Agregar Jugadores al Equipo
            </div>
        </x-slot>

        <x-slot name="content">
            <!-- Buscador -->
            <div class="mb-4">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="searchAvailablePlayer" 
                        placeholder="Buscar por nombre, apellido o DNI..."
                        class="w-full px-4 py-2 pl-10 border border-silver rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Filtro por categoría -->
            <div class="mb-4">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="filterByCategory" 
                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2">
                    <span class="ml-2 text-sm text-gray-700">Filtrar solo jugadores de la categoría del equipo</span>
                </label>
            </div>
            
            @if(count($selectedPlayersToAdd) > 0)
                <p class="text-xs text-gray-600 mb-3 p-2 bg-green-50 rounded-lg border border-green-200">
                    <svg class="w-4 h-4 inline text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ count($selectedPlayersToAdd) }} jugador(es) seleccionado(s)
                </p>
            @endif
            
            @if($availablePlayers->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <p class="text-amber-800 text-sm">
                        @if($searchAvailablePlayer)
                            No se encontraron jugadores disponibles con esos criterios de búsqueda.
                        @else
                            No hay jugadores disponibles para agregar al equipo.
                        @endif
                    </p>
                </div>
            @else
                <div class="max-h-96 overflow-y-auto border border-silver rounded-lg">
                    <table class="min-w-full divide-y divide-silver">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    <input type="checkbox" 
                                        @if(count($selectedPlayersToAdd) === $availablePlayers->count() && $availablePlayers->count() > 0) checked @endif
                                        wire:click="toggleSelectAllPlayers"
                                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                </th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-silver">
                            @foreach($availablePlayers as $player)
                                <tr wire:key="available-player-{{ $player->id }}" 
                                    class="hover:bg-gray-50 cursor-pointer"
                                    onclick="document.getElementById('player-checkbox-{{ $player->id }}').click()">
                                    <td class="px-3 py-2" onclick="event.stopPropagation()">
                                        <input type="checkbox" 
                                            id="player-checkbox-{{ $player->id }}"
                                            wire:model.live="selectedPlayersToAdd" 
                                            value="{{ $player->id }}"
                                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($player->profile_photo_path)
                                            <img src="{{ asset('storage/' . $player->profile_photo_path) }}" 
                                                class="w-10 h-10 rounded-full object-cover border border-silver">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center border border-silver">
                                                <span class="text-primary text-sm font-semibold">{{ substr($player->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm text-titanium">{{ $player->name }} {{ $player->surname }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $player->dni }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600">{{ $player->dbirth ? $player->dbirth->age . ' años' : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelAddPlayer">
                Cancelar
            </x-secondary-button>

            <x-button class="ms-3" wire:click="addPlayersToTeam" wire:loading.attr="disabled" wire:target="addPlayersToTeam" :disabled="empty($selectedPlayersToAdd)">
                <span wire:loading.remove wire:target="addPlayersToTeam">Agregar Jugadores</span>
                <span wire:loading wire:target="addPlayersToTeam" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Agregando...
                </span>
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Equipo</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-700">¿Estás seguro de que deseas eliminar el equipo <span class="font-bold text-primary">{{ $teamName }}</span>?</p>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="ml-3 text-sm text-red-800 font-medium">Esta acción no se puede deshacer. Se eliminarán permanentemente todos los datos del equipo.</p>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deleteTeam" wire:loading.attr="disabled" wire:target="deleteTeam">
                <span wire:loading.remove wire:target="deleteTeam">Eliminar</span>
                <span wire:loading wire:target="deleteTeam" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Eliminando...
                </span>
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>