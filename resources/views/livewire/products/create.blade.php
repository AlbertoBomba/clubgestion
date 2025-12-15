<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <a href="{{ route('products.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Productos') }}
            </a>
            <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                <span class="hidden sm:inline">Crear Nuevo</span>
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">Cancelar</span>
            </a>
            <button type="submit" form="product-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
                <svg wire:loading.remove wire:target="save" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin h-4 h-4 sm:h-5 sm:w-5 sm:mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save" class="hidden sm:inline">Crear</span>
                <span wire:loading wire:target="save" class="hidden sm:inline">Creando...</span>
            </button>
        </div>
    </div>

    <form wire:submit.prevent="save" id="product-form">
        <div class="space-y-6">
            <!-- Información básica -->
            <div class="bg-gray-50 p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-titanium mb-4">Información Básica</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Código *</label>
                        <input wire:model.live="code" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Nombre *</label>
                        <input wire:model.live="name" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Categoría *</label>
                        <select wire:model.live="category" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="">Seleccionar...</option>
                            <option value="general">General</option>
                            <option value="ropa">Ropa</option>
                            <option value="calzado">Calzado</option>
                        </select>
                        @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Precio Venta *</label>
                        <input wire:model.live="price" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Precio Coste *</label>
                        <input wire:model.live="cost_price" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('cost_price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Precio Venta Club *</label>
                        <input wire:model.live="club_price" type="number" step="0.01" min="0" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('club_price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                        <textarea wire:model.live="description" rows="3" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Imagen -->
            <div class="bg-gray-50 p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-titanium mb-4">Imagen</h3>
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Imagen del producto</label>
                    <input wire:model="image" type="file" accept="image/*" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    
                    @if ($image)
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 mb-2">Vista previa:</p>
                            <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg border border-silver">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Galería multimedia -->
            <div class="bg-gray-50 p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-titanium mb-4">Galería Multimedia</h3>
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Imágenes y Videos adicionales</label>
                    <input wire:model="mediaFiles" type="file" multiple accept="image/*,video/*" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    <p class="text-xs text-gray-500 mt-1">Puedes subir múltiples imágenes (JPG, PNG, GIF) y videos (MP4, MOV, AVI). Máximo 20MB por archivo.</p>
                    @error('mediaFiles.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    
                    @if ($mediaFiles)
                        <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($mediaFiles as $file)
                                <div class="relative">
                                    @if(in_array($file->getClientOriginalExtension(), ['mp4', 'mov', 'avi']))
                                        <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <img src="{{ $file->temporaryUrl() }}" class="w-full h-32 object-cover rounded-lg border border-silver">
                                    @endif
                                    <p class="text-xs text-gray-600 mt-1 truncate">{{ $file->getClientOriginalName() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Opciones -->
            <div class="bg-gray-50 p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-titanium mb-4">Opciones</h3>
                <div class="space-y-3">
                    <label class="flex items-center cursor-pointer">
                        <input wire:model.live="has_sizes" type="checkbox" class="rounded border-silver text-primary focus:ring-2 focus:ring-primary focus:ring-offset-2 h-4 w-4">
                        <span class="ml-2 text-sm font-semibold text-titanium">Tiene tallas</span>
                    </label>
                    @error('has_sizes') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                    <label class="flex items-center cursor-pointer">
                        <input wire:model.live="active" type="checkbox" class="rounded border-silver text-primary focus:ring-2 focus:ring-primary focus:ring-offset-2 h-4 w-4">
                        <span class="ml-2 text-sm font-semibold text-titanium">Activo</span>
                    </label>
                    @error('active') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                    <label class="flex items-center cursor-pointer">
                        <input wire:model.live="published_web" type="checkbox" class="rounded border-silver text-primary focus:ring-2 focus:ring-primary focus:ring-offset-2 h-4 w-4">
                        <span class="ml-2 text-sm font-semibold text-titanium">Publicado en web</span>
                    </label>
                    @error('published_web') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Tallas (si está activado) -->
            @if($has_sizes)
                <div class="bg-gray-50 p-4 rounded-xl">
                    <h3 class="text-lg font-semibold text-titanium mb-4">Stock por Tallas</h3>
                    @if(count($availableSizes) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($availableSizes as $size)
                                <div class="bg-white p-3 rounded-lg border border-silver">
                                    <div class="font-semibold text-sm text-titanium mb-3">
                                        {{ $size->size }}
                                        @if($size->description)
                                            <span class="text-xs text-gray-500">({{ $size->description }})</span>
                                        @endif
                                    </div>
                                    <div class="space-y-2">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Cantidad</label>
                                            <input wire:model.live="sizeStock.{{ $size->id }}.quantity" type="number" min="0" class="w-full px-2 py-1 text-sm border border-silver rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                            @error('sizeStock.' . $size->id . '.quantity') 
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Stock Mín.</label>
                                            <input wire:model.live="sizeStock.{{ $size->id }}.min_stock" type="number" min="0" class="w-full px-2 py-1 text-sm border border-silver rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                            @error('sizeStock.' . $size->id . '.min_stock') 
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No hay tallas disponibles. Crea tallas primero para poder asignarlas a productos.</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Observaciones -->
            <div class="bg-gray-50 p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-titanium mb-4">Observaciones</h3>
                <div>
                    <textarea wire:model.live="observations" rows="3" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm" placeholder="Observaciones adicionales..."></textarea>
                    @error('observations') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </form>
</div>
