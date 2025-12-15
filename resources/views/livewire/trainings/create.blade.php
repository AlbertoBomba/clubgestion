<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 sm:p-8">
    <form wire:submit.prevent="save">
        <div class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-titanium mb-2">
                    Título del Entrenamiento *
                </label>
                <input type="text" 
                       wire:model="title" 
                       id="title"
                       class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                       placeholder="Ej: Rondo 4vs2">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-titanium mb-2">
                    Descripción
                </label>
                <textarea wire:model="description" 
                          id="description" 
                          rows="6"
                          class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                          placeholder="Describe detalladamente el entrenamiento, objetivos, metodología..."></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Row 1: Players and Category -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="recommended_players" class="block text-sm font-semibold text-titanium mb-2">
                        Jugadores Recomendados
                    </label>
                    <input type="number" 
                           wire:model="recommended_players" 
                           id="recommended_players"
                           min="1" 
                           max="100"
                           class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                           placeholder="Ej: 10">
                    @error('recommended_players') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="recommended_time" class="block text-sm font-semibold text-titanium mb-2">
                        Tiempo Recomendado (minutos)
                    </label>
                    <input type="number" 
                           wire:model="recommended_time" 
                           id="recommended_time"
                           min="1" 
                           max="999"
                           class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                           placeholder="Ej: 30">
                    @error('recommended_time') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 2: Category and Age Min -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-titanium mb-2">
                        Categoría Recomendada
                    </label>
                    <select wire:model="category_id" 
                            id="category_id"
                            class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep">
                        <option value="">Selecciona una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="recommended_age_min" class="block text-sm font-semibold text-titanium mb-2">
                        Edad Mínima Recomendada
                    </label>
                    <input type="number" 
                           wire:model="recommended_age_min" 
                           id="recommended_age_min"
                           min="1" 
                           max="99"
                           class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                           placeholder="Ej: 10">
                    @error('recommended_age_min') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 3: Age Max -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="recommended_age_max" class="block text-sm font-semibold text-titanium mb-2">
                        Edad Máxima Recomendada
                    </label>
                    <input type="number" 
                           wire:model="recommended_age_max" 
                           id="recommended_age_max"
                           min="1" 
                           max="99"
                           class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                           placeholder="Ej: 14">
                    @error('recommended_age_max') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Images Upload -->
            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">
                    <svg class="w-4 h-4 inline mr-1 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Imágenes del Entrenamiento
                </label>
                
                <!-- Preview existing images -->
                @if(count($images) > 0)
                    <div class="mb-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($images as $index => $image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                <button type="button" 
                                        wire:click="removeImage({{ $index }})"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="images-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Click para subir imágenes</span></p>
                            <p class="text-xs text-gray-400">PNG, JPG hasta 10MB (múltiples archivos)</p>
                        </div>
                        <input id="images-upload" type="file" wire:model="images" class="hidden" accept="image/*" multiple>
                    </label>
                </div>
                @error('images.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                
                <div wire:loading wire:target="images" class="mt-2 text-sm text-primary">
                    Subiendo imágenes...
                </div>
            </div>

            <!-- Videos Upload -->
            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">
                    <svg class="w-4 h-4 inline mr-1 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Videos del Entrenamiento
                </label>
                
                <!-- Preview videos -->
                @if(count($videos) > 0)
                    <div class="mb-4 space-y-2">
                        @foreach($videos as $index => $video)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-300">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $video->getClientOriginalName() }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($video->getSize() / 1024 / 1024, 2) }} MB</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        wire:click="removeVideo({{ $index }})"
                                        class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="videos-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 4 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Click para subir videos</span></p>
                            <p class="text-xs text-gray-400">MP4, MOV, AVI hasta 100MB (múltiples archivos)</p>
                        </div>
                        <input id="videos-upload" type="file" wire:model="videos" class="hidden" accept="video/*" multiple>
                    </label>
                </div>
                @error('videos.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                
                <div wire:loading wire:target="videos" class="mt-2 text-sm text-primary">
                    Subiendo videos...
                </div>
            </div>

            <!-- Checkboxes -->
            <div class="space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" 
                           wire:model="is_public" 
                           id="is_public"
                           class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer">
                    <label for="is_public" class="ml-2 text-sm text-gray-700">
                        Hacer público (otros entrenadores de la escuela podrán verlo)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           wire:model="is_active" 
                           id="is_active"
                           class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">
                        Activo
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('trainings.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-night-blue transition-colors font-semibold shadow-lg hover:shadow-xl"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Crear Entrenamiento</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </div>
    </form>
</div>
