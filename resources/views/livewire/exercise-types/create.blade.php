<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 sm:p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-titanium">Crear Tipo de Ejercicio</h2>
        <p class="text-sm text-gray-600 mt-1">Completa la información para crear un nuevo tipo de ejercicio</p>
    </div>

    <form wire:submit.prevent="save">
        <div class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-titanium mb-2">
                    Nombre *
                </label>
                <input type="text" 
                       wire:model="name" 
                       id="name"
                       class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                       placeholder="Ej: Táctico, Físico, Lúdico">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-titanium mb-2">
                    Descripción
                </label>
                <textarea wire:model="description" 
                          id="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep"
                          placeholder="Descripción del tipo de ejercicio..."></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('exercise-types.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Guardar
                </button>
            </div>
        </div>
    </form>
</div>
