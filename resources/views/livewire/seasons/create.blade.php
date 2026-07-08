<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <a href="{{ route('seasons.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Temporadas') }}
            </a>
            <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                Nueva Temporada
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route('seasons.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">Cancelar</span>
            </a>
            <button type="submit" form="season-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
                <svg wire:loading.remove wire:target="save" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Crear Temporada</span>
                <span wire:loading wire:target="save">Creando...</span>
            </button>
        </div>
    </div>

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
                            <input wire:model.live="season" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('season') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                            <textarea wire:model.live="description" rows="3" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex w-full gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Año Desde *</label>
                                <input wire:model.live="from_year" type="number" min="1900" max="2100" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('from_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-titanium mb-2">Año Hasta *</label>
                                <input wire:model.live="to_year" type="number" min="1900" max="2100" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('to_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <x-date-input 
                                    label="Fecha Fin" 
                                    model="end_date" 
                                    error="end_date" 
                                />
                            </div>
                        </div>

                        <div class="flex w-full gap-4">
                            <div class="flex-1">
                                <x-date-input 
                                    label="Inicio Inscripciones" 
                                    model="inscription_start_at" 
                                    error="inscription_start_at" 
                                />
                            </div>
                            <div class="flex-1">
                                <x-date-input 
                                    label="Fin Inscripciones" 
                                    model="inscription_end_at" 
                                    error="inscription_end_at" 
                                />
                            </div>
                        </div>

                        <div class="flex w-full gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-titanium mb-2">Número de Cuotas *</label>
                                <select wire:model.live="cuota" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
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
                                       onfocus="this.select()"
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary text-black-deep text-sm font-semibold border-primary bg-white">
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
                                $isSelected = isset($sectionPrices[$section->id]) && $sectionPrices[$section->id] !== null && $sectionPrices[$section->id] !== '';
                            @endphp
                            <div class="rounded-xl p-4 border-2 {{ $isSelected ? 'border-primary bg-primary/5' : 'bg-white-pure border-silver' }}">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" 
                                           id="section_{{ $section->id }}"
                                           {{ $isSelected ? 'checked' : '' }}
                                           wire:click="$set('sectionPrices.{{ $section->id }}', $event.target.checked ? 0 : null)"
                                           class="w-5 h-5 text-primary border-silver rounded focus:ring-primary flex-shrink-0 cursor-pointer">
                                    <label for="section_{{ $section->id }}" class="text-sm font-bold flex-shrink-0 cursor-pointer {{ $isSelected ? 'text-primary' : 'text-titanium' }}">
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
                                               {{ !$isSelected ? 'disabled' : '' }}
                                               onfocus="this.select()"
                                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary text-black-deep text-sm font-semibold
                                                      {{ $isSelected ? 'border-primary bg-white' : 'border-silver bg-gray-100 cursor-not-allowed' }}">
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
</div>
