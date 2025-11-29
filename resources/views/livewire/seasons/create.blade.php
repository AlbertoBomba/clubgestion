<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8">
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                <input wire:model="season" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                @error('season') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                <input wire:model="description" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">Año Desde *</label>
                <input wire:model="from_year" type="number" min="1900" max="2100" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                @error('from_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">Año Hasta *</label>
                <input wire:model="to_year" type="number" min="1900" max="2100" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                @error('to_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Secciones y Precios -->
        <div class="bg-gray-50 rounded-xl p-6 border border-primary/10">
            <h3 class="text-lg font-bold text-titanium mb-4">Secciones y Precios *</h3>
            <p class="text-sm text-gray-600 mb-4">Seleccione las secciones disponibles para esta temporada e indique el precio de matrícula anual de cada una.</p>
            
            @error('sectionPrices') <span class="text-red-500 text-sm block mb-3">{{ $message }}</span> @enderror
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($sections as $section)
                    <div class="bg-white-pure rounded-lg p-4 border border-silver">
                        <div class="flex items-center mb-2">
                            <input type="checkbox" 
                                   id="section_{{ $section->id }}"
                                   wire:model="sectionPrices.{{ $section->id }}"
                                   value="0"
                                   class="w-4 h-4 text-primary border-silver rounded focus:ring-primary">
                            <label for="section_{{ $section->id }}" class="ml-2 text-sm font-semibold text-titanium">
                                {{ $section->name }}
                            </label>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Precio (€)</label>
                            <input type="number" 
                                   wire:model="sectionPrices.{{ $section->id }}"
                                   step="0.01" 
                                   min="0"
                                   placeholder="0.00"
                                   class="w-full px-3 py-2 border border-silver rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            @error('sectionPrices.' . $section->id) 
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-silver/30">
            <a href="{{ route('seasons.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="btn-primary inline-flex justify-center items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all">
                Crear Temporada
            </button>
        </div>
    </form>
</div>
