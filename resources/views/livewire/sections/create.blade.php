<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <a href="{{ route('sections.index') }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Secciones') }}
            </a>
            <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                <span class="hidden sm:inline">Crear Nueva</span>
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route('sections.index') }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">Cancelar</span>
            </a>
            <button type="submit" form="section-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed whitespace-nowrap">
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

    <form wire:submit.prevent="save" id="section-form" class="space-y-4">
        <div>
            <label class="block text-sm font-semibold text-titanium mb-2">Nombre *</label>
            <input wire:model.live="name" type="text" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
            <textarea wire:model.live="description" rows="3" class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="flex items-center">
                <input wire:model.live="active" type="checkbox" class="rounded border-silver text-primary focus:ring-primary">
                <span class="ml-2 text-sm font-semibold text-titanium">Activa</span>
            </label>
        </div>
    </form>
</div>
