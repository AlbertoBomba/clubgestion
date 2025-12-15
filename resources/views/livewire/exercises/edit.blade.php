<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 sm:p-8">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-neon-green mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-titanium mb-2">
                    Título del Ejercicio *
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
                          placeholder="Describe detalladamente el ejercicio, objetivos, metodología..."></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Row 1: Players and Time -->
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

            <!-- Row 2: Difficulty and Intensity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="difficulty" class="block text-sm font-semibold text-titanium mb-2">
                        Dificultad
                    </label>
                    <select wire:model="difficulty" 
                            id="difficulty"
                            class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep">
                        <option value="">Selecciona una dificultad</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                    @error('difficulty') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="intensity" class="block text-sm font-semibold text-titanium mb-2">
                        Intensidad
                    </label>
                    <select wire:model="intensity" 
                            id="intensity"
                            class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep">
                        <option value="">Selecciona una intensidad</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                    @error('intensity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 3: Category and Exercise Type -->
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
                    <label for="exercise_type_id" class="block text-sm font-semibold text-titanium mb-2">
                        Tipo de Ejercicio
                    </label>
                    <select wire:model="exercise_type_id" 
                            id="exercise_type_id"
                            class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep">
                        <option value="">Selecciona un tipo</option>
                        @foreach($exerciseTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('exercise_type_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Row 3: Age Min and Max -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

            <!-- Existing Media -->
            @if(count($existingMedia) > 0)
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">
                        Archivos Actuales
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($existingMedia as $media)
                            <div class="relative">
                                @if($media['file_type'] == 'image')
                                    <img src="{{ asset('storage/' . $media['file_path']) }}" 
                                         class="w-full h-48 object-contain rounded-lg border-2 border-gray-300">
                                @else
                                    <div class="w-full h-48 bg-gray-100 rounded-lg border-2 border-gray-300 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <button type="button" 
                                        wire:click="deleteExistingMedia({{ $media['id'] }})"
                                        wire:confirm="¿Estás seguro de eliminar este archivo?"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- New Images Upload -->
            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">
                    <svg class="w-4 h-4 inline mr-1 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Agregar Nuevas Imágenes
                </label>
                
                <!-- Preview new images -->
                @if(count($newImages) > 0)
                    <div class="mb-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($newImages as $index => $image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-48 object-contain rounded-lg border-2 border-green-300">
                                <button type="button" 
                                        wire:click="removeNewImage({{ $index }})"
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
                    <label for="new-images-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 4 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Click para subir nuevas imágenes</span></p>
                            <p class="text-xs text-gray-400">PNG, JPG hasta 10MB</p>
                        </div>
                        <input id="new-images-upload" type="file" wire:model="newImages" class="hidden" accept="image/*" multiple>
                    </label>
                </div>
                @error('newImages.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                
                <div wire:loading wire:target="newImages" class="mt-2 text-sm text-primary">
                    Subiendo imágenes...
                </div>
            </div>

            <!-- New Videos Upload -->
            <div>
                <label class="block text-sm font-semibold text-titanium mb-2">
                    <svg class="w-4 h-4 inline mr-1 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Agregar Nuevos Videos
                </label>
                
                <!-- Preview new videos -->
                @if(count($newVideos) > 0)
                    <div class="mb-4 space-y-2">
                        @foreach($newVideos as $index => $video)
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border-2 border-green-300">
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
                                        wire:click="removeNewVideo({{ $index }})"
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
                    <label for="new-videos-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 4 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Click para subir nuevos videos</span></p>
                            <p class="text-xs text-gray-400">MP4, MOV, AVI hasta 100MB</p>
                        </div>
                        <input id="new-videos-upload" type="file" wire:model="newVideos" class="hidden" accept="video/*" multiple>
                    </label>
                </div>
                @error('newVideos.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                
                <div wire:loading wire:target="newVideos" class="mt-2 text-sm text-primary">
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
                <a href="{{ route('exercises.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors font-semibold">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-xl hover:bg-night-blue transition-colors font-semibold shadow-lg hover:shadow-xl"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Actualizar Ejercicio</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </div>
    </form>
</div>
