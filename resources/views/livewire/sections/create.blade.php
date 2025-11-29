<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8">
    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-titanium mb-2">Nombre *</label>
            <input wire:model="name" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
            <textarea wire:model="description" rows="3" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="flex items-center">
                <input wire:model="active" type="checkbox" class="rounded border-silver text-primary focus:ring-primary">
                <span class="ml-2 text-sm font-semibold text-titanium">Activa</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-silver/30">
            <a href="{{ route('sections.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="btn-primary inline-flex justify-center items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all">
                Crear Sección
            </button>
        </div>
    </form>
</div>
