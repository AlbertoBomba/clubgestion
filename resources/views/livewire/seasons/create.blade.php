<div class="space-y-6">
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Datos de la Temporada -->
            <div class="lg:col-span-1">
                <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6">
                    <h2 class="text-xl font-bold text-titanium mb-6 pb-3 border-b border-silver">
                        Datos de la Temporada
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                            <input wire:model="season" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('season') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                            <textarea wire:model="description" rows="3" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Año Desde *</label>
                            <input wire:model="from_year" type="number" min="1900" max="2100" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('from_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Año Hasta *</label>
                            <input wire:model="to_year" type="number" min="1900" max="2100" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('to_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Fecha Fin</label>
                            <input wire:model="end_date" type="date" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('end_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col gap-3 pt-6 mt-6 border-t border-silver/30">
                        <button type="submit" class="btn-primary w-full inline-flex justify-center items-center px-4 py-3 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Crear Temporada
                        </button>
                        <a href="{{ route('seasons.index') }}" class="w-full inline-flex justify-center items-center px-4 py-3 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Secciones y Precios -->
            <div class="lg:col-span-2">
                <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6">
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
                            <div class="rounded-xl p-4 border-2 transition-all duration-200 cursor-pointer {{ $isSelected ? 'border-primary bg-gradient-to-br from-primary/10 to-primary/5 shadow-md hover:shadow-lg hover:scale-[1.02]' : 'bg-white-pure border-silver hover:border-primary/50 hover:shadow-md hover:scale-[1.02]' }}"
                                 onclick="document.getElementById('section_{{ $section->id }}').click()">
                                <div class="flex items-center mb-3">
                                    <input type="checkbox" 
                                           id="section_{{ $section->id }}"
                                           {{ $isSelected ? 'checked' : '' }}
                                           wire:click="$set('sectionPrices.{{ $section->id }}', $event.target.checked ? 0 : null)"
                                           onclick="event.stopPropagation()"
                                           class="w-5 h-5 text-primary border-silver rounded focus:ring-primary cursor-pointer">
                                    <label for="section_{{ $section->id }}" class="ml-3 text-sm font-bold cursor-pointer {{ $isSelected ? 'text-primary' : 'text-titanium' }}">
                                        {{ $section->name }}
                                    </label>
                                    @if($isSelected)
                                        <svg class="w-5 h-5 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold mb-2 {{ $isSelected ? 'text-primary' : 'text-gray-600' }}">
                                        Precio de Matrícula (€)
                                    </label>
                                    <input type="number" 
                                           wire:model.live="sectionPrices.{{ $section->id }}"
                                           step="0.01" 
                                           min="0"
                                           placeholder="0.00"
                                           {{ !$isSelected ? 'disabled' : '' }}
                                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary text-black-deep text-sm font-semibold
                                                  {{ $isSelected ? 'border-primary bg-white' : 'border-silver bg-gray-100 cursor-not-allowed' }}">
                                    @error('sectionPrices.' . $section->id) 
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
