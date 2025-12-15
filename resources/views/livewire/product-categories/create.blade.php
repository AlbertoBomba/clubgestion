<div class="bg-white rounded-2xl shadow-lg p-6">
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       wire:model="name" 
                       class="input-primary w-full @error('name') border-red-500 @enderror">
                @error('name') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea id="description" 
                          wire:model="description" 
                          rows="3"
                          class="input-primary w-full @error('description') border-red-500 @enderror"></textarea>
                @error('description') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Orden -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Orden <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="order" 
                       wire:model="order" 
                       min="0"
                       class="input-primary w-full @error('order') border-red-500 @enderror">
                @error('order') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
                <p class="text-xs text-gray-500 mt-1">Orden de visualización (menor número aparece primero)</p>
            </div>

            <!-- Activa -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Estado
                </label>
                <div class="flex items-center mt-3">
                    <input type="checkbox" 
                           id="active" 
                           wire:model="active" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="active" class="ml-2 block text-sm text-gray-900">
                        Categoría activa
                    </label>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('product-categories.index') }}" class="btn-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Guardar Categoría
            </button>
        </div>
    </form>
</div>
