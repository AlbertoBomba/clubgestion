<div class="space-y-6">
    <form wire:submit.prevent="save">
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Nombre del Equipo *</label>
                    <input wire:model="teamName" type="text" 
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    @error('teamName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Categoría *</label>
                        <select wire:model="category_id" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="">Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                        <select wire:model.live="season_id" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="">Seleccione una temporada</option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->season }}</option>
                            @endforeach
                        </select>
                        @error('season_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Sección *</label>
                    <select wire:model="section_id" 
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                        {{ !$season_id ? 'disabled' : '' }}>
                        <option value="">{{ $season_id ? 'Seleccione una sección' : 'Primero seleccione una temporada' }}</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    @if($season_id && $sections->isEmpty())
                        <p class="text-amber-600 text-xs mt-1">No hay secciones disponibles para esta temporada.</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 mt-6 border-t border-silver/30">
                <a href="{{ route('teams.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary inline-flex justify-center items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>
