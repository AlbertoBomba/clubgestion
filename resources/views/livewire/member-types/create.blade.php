<div>
    <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 max-w-2xl">

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form wire:submit="save" class="space-y-5">

            {{-- Temporada --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">Temporada <span class="text-red-500">*</span></label>
                <select wire:model="season_id"
                        class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    <option value="">Seleccionar temporada...</option>
                    @foreach($seasons as $season)
                        <option value="{{ $season->id }}">{{ $season->season }}</option>
                    @endforeach
                </select>
                @error('season_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">Nombre <span class="text-red-500">*</span></label>
                <input wire:model="name" type="text" placeholder="Ej: Socio Estándar"
                       class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">Descripción</label>
                <textarea wire:model="description" rows="3" placeholder="Descripción opcional..."
                          class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium resize-none"></textarea>
                @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Precio y Periodicidad --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Precio (€) <span class="text-red-500">*</span></label>
                    <input wire:model="price" type="text" placeholder="0,00"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Periodicidad <span class="text-red-500">*</span></label>
                    <select wire:model="periodicity"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        <option value="">Seleccionar...</option>
                        @foreach($periodicities as $p)
                            <option value="{{ $p->value }}">{{ $p->label() }}</option>
                        @endforeach
                    </select>
                    @error('periodicity') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Activo --}}
            <div class="flex items-center gap-3">
                <input wire:model="active" type="checkbox" id="active" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                <label for="active" class="text-sm font-semibold text-titanium">Tipo activo (visible para nuevas inscripciones)</label>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model="bank_account" type="checkbox" id="bank_account" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                <label for="bank_account" class="text-sm font-semibold text-titanium">Cuenta Bancaria <span class="text-gray-400 text-xs">(Marque esta opción si este tipo de socio requiere cobro mediante cuenta bancaria con recibo domiciliado)</span></label>
            </div>
            <div class="flex items-center gap-3">
                <input wire:model="credit_card" type="checkbox" id="credit_card" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                <label for="credit_card" class="text-sm font-semibold text-titanium">Tarjeta de Crédito para usar cobro recurrente. <span class="text-gray-400 text-xs">(El club debe tener tpv virtual contratado con su banco, o usar el que ofrece vaed.)</span></label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center justify-between pt-4 border-t border-silver/30">
                <a href="{{ route('member-types.index') }}"
                   class="px-5 py-2.5 bg-gray-100 text-titanium rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors shadow-sm"
                        wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                    <span wire:loading.remove>Guardar Tipo</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        Guardando...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
