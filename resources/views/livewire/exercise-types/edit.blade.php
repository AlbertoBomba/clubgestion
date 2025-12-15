<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 sm:p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-titanium">Editar Tipo de Ejercicio</h2>
        <p class="text-sm text-gray-600 mt-1">Modifica la información del tipo de ejercicio</p>
    </div>

    <form wire:submit.prevent="update">
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

            <!-- Info about exercises using this type -->
            @if($type->exercises()->count() > 0)
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-blue-800">
                            Este tipo está siendo usado por <strong>{{ $type->exercises()->count() }}</strong> ejercicio(s).
                        </p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('exercise-types.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Actualizar
                </button>
            </div>
        </div>
    </form>
</div>
