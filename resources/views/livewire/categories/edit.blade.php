<div class="card-modern bg-white rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-8">
    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Categoría *</label>
            <input wire:model="category" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
            <textarea wire:model="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Edad Desde</label>
                <input wire:model="from_age" type="number" min="0" max="100" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                @error('from_age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Edad Hasta</label>
                <input wire:model="to_age" type="number" min="0" max="100" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                @error('to_age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Modalidad</label>
            <input wire:model="modality" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            @error('modality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold">Cancelar</a>
            <button type="submit" class="btn-primary px-6 py-3 rounded-xl text-white font-semibold">Actualizar Categoría</button>
        </div>
    </form>
</div>
