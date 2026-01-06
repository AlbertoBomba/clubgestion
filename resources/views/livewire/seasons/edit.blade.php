<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            {{-- <a href="{{ route('seasons.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Temporadas') }}
            </a> --}}
            {{-- <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span> --}}
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                <span class="hidden sm:inline">Actualizar </span>{{ $season }}
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route('seasons.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">{{ $isActive ? 'Salir sin guardar' : 'Volver' }}</span>
            </a>
            @if($isActive)
                @php
                    $seasonModel->loadCount(['players', 'teams', 'sections']);
                    $canDelete = $seasonModel->players_count == 0 && $seasonModel->teams_count == 0 && $seasonModel->sections_count == 0;
                @endphp
                @if($canDelete)
                    <button type="button" wire:click="confirmDelete" 
                        class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 whitespace-nowrap">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span class="hidden sm:inline">Eliminar</span>
                    </button>
                @else
                    <div class="relative group">
                        <button type="button" disabled
                            class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm bg-gray-400 cursor-not-allowed opacity-60 whitespace-nowrap">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="hidden sm:inline">Eliminar</span>
                        </button>
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                            No se puedeeliminar: tiene 
                            @if($seasonModel->players_count > 0) {{ $seasonModel->players_count }} jugador(es) @endif
                            @if($seasonModel->teams_count > 0)@if($seasonModel->players_count > 0), @endif{{ $seasonModel->teams_count }} equipo(s) @endif
                            @if($seasonModel->sections_count > 0)@if($seasonModel->players_count > 0 || $seasonModel->teams_count > 0), @endif{{ $seasonModel->sections_count }} sección(es) @endif
                            asociados
                        </div>
                    </div>
                @endif
                <button type="submit" form="season-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <svg wire:loading.remove wire:target="save" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Actualizar</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Alerta de cambios sin guardar -->
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
    
    <!-- Alerta de temporada inactiva -->
    @if(!$isActive)
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-amber-800">
                        Esta temporada no está activa y no se puede modificar. Solo puede consultar la información.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" id="season-form">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Datos de la Temporada -->
            <div class="lg:col-span-1">
                <div class=" bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6">
                    <h2 class="text-xl font-bold text-titanium mb-6 pb-3 border-b border-silver">
                        Datos de la Temporada
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                            <input wire:model.live="season" type="text" {{ !$isActive ? 'disabled' : '' }} class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm {{ !$isActive ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                            @error('season') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                            <textarea wire:model.live="description" rows="3" {{ !$isActive ? 'disabled' : '' }} class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none {{ !$isActive ? 'bg-gray-100 cursor-not-allowed' : '' }}"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex w-full gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Año Desde *</label>
                                <input wire:model.live="from_year" type="number" min="1900" max="2100" {{ !$isActive ? 'disabled' : '' }} class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm {{ !$isActive ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                @error('from_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Año Hasta *</label>
                                <input wire:model.live="to_year" type="number" min="1900" max="2100" {{ !$isActive ? 'disabled' : '' }} class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm {{ !$isActive ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                @error('to_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <x-date-input 
                                    label="Fecha Fin" 
                                    model="end_date" 
                                    error="end_date"
                                    {{-- @if(!$isActive) disabled @endif --}}
                                />
                            </div>
                        </div>

                        <div class="flex w-full gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-titanium mb-2">Número de Cuotas *</label>
                                <select wire:model.live="cuota" {{ !$isActive ? 'disabled' : '' }} class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm {{ !$isActive ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'cuota' : 'cuotas' }}</option>
                                    @endfor
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    Cantidad de cuotas permitidas en los pagos
                                </p>
                                @error('cuota') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-titanium mb-2">Precio Preinscripción (€)</label>
                                <input type="text" 
                                       wire:model.live="precio_preinscripcion"
                                       placeholder="0.00 €"
                                       {{ !$isActive ? 'disabled' : '' }}
                                       onfocus="this.select()"
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary text-black-deep text-sm font-semibold
                                              {{ $isActive ? 'border-primary bg-white' : 'border-silver bg-gray-100 cursor-not-allowed' }}">
                                <p class="text-xs text-gray-500 mt-1">
                                    <svg class="inline w-4 h-4 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Si establece un precio, el alumno deberá pagar la preinscripción cuando realice el alta en la escuela.
                                </p>
                                @error('precio_preinscripcion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Secciones y Precios -->
            <div class="lg:col-span-2">
                <div class=" bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-titanium mb-2">Secciones y Precios *</h2>
                        <p class="text-sm text-gray-600">Seleccione las secciones disponibles para esta temporada e indique el precio de matrícula anual de cada una.</p>
                    </div>
                    
                    @error('sectionPrices') 
                        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded">
                            <span class="text-red-700 text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($sections as $section)
                            @php
                                $isSelected = in_array($section->id, $selectedSections);
                            @endphp
                            <div class="rounded-xl p-4 border-2 {{ $isSelected ? 'border-primary bg-primary/5' : 'bg-white-pure border-silver' }}">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" 
                                           id="section_{{ $section->id }}"
                                           value="{{ $section->id }}"
                                           wire:model.live="selectedSections"
                                           {{ !$isActive ? 'disabled' : '' }}
                                           class="w-5 h-5 text-primary border-silver rounded focus:ring-primary flex-shrink-0 {{ $isActive ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
                                    <label for="section_{{ $section->id }}" class="text-sm font-bold flex-shrink-0 {{ $isActive ? 'cursor-pointer' : 'cursor-not-allowed' }} {{ $isSelected ? 'text-primary' : 'text-titanium' }}">
                                        {{ $section->name }}
                                    </label>
                                    @if($isSelected)
                                        <svg class="w-5 h-5 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <input type="text" 
                                               wire:model.live="sectionPrices.{{ $section->id }}"
                                               placeholder="0.00 €"
                                               {{ !$isSelected || !$isActive ? 'disabled' : '' }}
                                               onfocus="this.select()"
                                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary text-black-deep text-sm font-semibold
                                                      {{ $isSelected && $isActive ? 'border-primary bg-white' : 'border-silver bg-gray-100 cursor-not-allowed' }}">
                                        @error('sectionPrices.' . $section->id) 
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal de confirmación de eliminación -->
    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Temporada</x-slot>
        <x-slot name="content">
            ¿Está seguro que desea eliminar esta temporada? Esta acción no se puede deshacer.
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button wire:click="deleteSeason" wire:loading.attr="disabled" wire:target="deleteSeason" class="ml-3">
                <span wire:loading.remove wire:target="deleteSeason">Eliminar</span>
                <span wire:loading wire:target="deleteSeason" class="inline-flex items-center">
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
