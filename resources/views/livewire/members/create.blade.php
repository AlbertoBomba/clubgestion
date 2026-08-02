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

            {{-- Nombre y Apellidos --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input wire:model="name" type="text" placeholder="Nombre"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Apellidos <span class="text-red-500">*</span></label>
                    <input wire:model="surname" type="text" placeholder="Apellidos"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('surname') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- DNI --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">DNI / NIF</label>
                <input wire:model="dni" type="text" placeholder="12345678A"
                       class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                @error('dni') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email y Teléfono --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Email</label>
                    <input wire:model="email" type="email" placeholder="email@ejemplo.com"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Teléfono</label>
                    <input wire:model="phone" type="text" placeholder="600000000"
                           class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Fecha de nacimiento --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">Fecha de nacimiento</label>
                <input wire:model="birth_date" type="date"
                       class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                @error('birth_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dirección --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">Dirección</label>
                <input wire:model="address" type="text" placeholder="Calle, número, ciudad..."
                       class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Foto --}}
            <div>
                <label class="block text-sm font-semibold text-titanium mb-1">Foto</label>
                <input wire:model="photo" type="file" accept="image/*"
                       class="block w-full text-sm text-titanium file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                @error('photo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Activo --}}
            <div class="flex items-center gap-3">
                <input wire:model="active" type="checkbox" id="active" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                <label for="active" class="text-sm font-semibold text-titanium">Socio activo</label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center justify-between pt-4 border-t border-silver/30">
                <a href="{{ route('members.index') }}"
                   class="px-5 py-2.5 bg-gray-100 text-titanium rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors shadow-sm"
                        wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                    <span wire:loading.remove>Guardar Socio</span>
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
