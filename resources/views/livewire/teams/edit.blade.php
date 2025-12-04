<div class="space-y-6">
    <form wire:submit.prevent="save">
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8">
            
            <!-- Layout con dos columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Columna izquierda: Datos del equipo (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-titanium mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Datos del Equipo
                        </h3>
                    </div>

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

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Imagen del Equipo</label>
                        <div class="flex items-start gap-4">
                            <!-- Preview actual de la imagen -->
                            <div class="flex-shrink-0">
                                @if($team->team_image)
                                    <img src="{{ asset('storage/' . $team->team_image) }}" 
                                        class="w-48 h-32 rounded-xl object-cover border-2 border-silver shadow-sm">
                                @else
                                    <div class="w-48 h-32 rounded-xl bg-gray-100 border-2 border-dashed border-silver flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Upload input -->
                            <div class="flex-1">
                                <input type="file" wire:model="teamImage" accept="image/*" 
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('teamImage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500 mt-1">Imagen rectangular del equipo completo (ej: 1200x800px)</p>
                                
                                <!-- Preview temporal -->
                                @if($teamImage)
                                    <div class="mt-2">
                                        <p class="text-xs text-green-600 font-medium mb-1">Vista previa de la nueva imagen:</p>
                                        <img src="{{ $teamImage->temporaryUrl() }}" 
                                            class="w-48 h-32 rounded-xl object-cover border-2 border-primary shadow-sm">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

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
                        <label class="block text-sm font-semibold text-titanium mb-2">Género *</label>
                        <select wire:model="gender" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="mixto">Mixto</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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

                <!-- Columna derecha: Entrenadores (1/3) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        <h3 class="text-lg font-bold text-titanium mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Entrenadores
                        </h3>
                        
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
                            <div class="space-y-2 max-h-[600px] overflow-y-auto pr-2">
                                @foreach($availableCoaches as $coach)
                                    <label class="flex items-center p-3 border rounded-xl cursor-pointer transition-all
                                        {{ in_array($coach->id, $selectedCoaches) ? 'border-primary bg-primary/10 shadow-md' : 'border-silver hover:bg-gray-50' }}">
                                        <input type="checkbox" wire:model="selectedCoaches" value="{{ $coach->id }}"
                                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 flex-shrink-0">
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="flex items-center">
                                                @if($coach->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $coach->profile_photo_path) }}" 
                                                        class="w-8 h-8 rounded-full object-cover mr-2 border border-silver flex-shrink-0">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2 flex-shrink-0">
                                                        <span class="text-primary text-xs font-semibold">{{ substr($coach->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-titanium truncate">{{ $coach->name }}</p>
                                                    <p class="text-xs text-gray-500 truncate">{{ $coach->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
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
