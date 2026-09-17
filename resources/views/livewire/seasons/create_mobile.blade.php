<div class="min-h-screen bg-gray-50 pb-28 relative">

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('seasons.index') }}" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-black text-lg text-titanium truncate">
                Nueva Temporada
            </h2>
        </div>

        <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-bold text-[10px] uppercase tracking-wider">
            Alta
        </span>
    </header>

    <div class="p-4 space-y-4">

        {{-- FORMULARIO --}}
        <form wire:submit.prevent="save" id="season-form" class="space-y-4">

            {{-- Bloque 1: Datos de la Temporada --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Información Principal
                </h3>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Temporada *</label>
                    <input wire:model.live="season" type="text" placeholder="Ej. 2026/2027"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    @error('season') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Descripción</label>
                    <textarea wire:model.live="description" rows="3" placeholder="Detalles de la temporada..."
                              class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm focus:ring-2 focus:ring-primary focus:bg-white transition-all resize-none"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            </section>

            {{-- Bloque 2: Fechas y Períodos --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Fechas y Períodos
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Año Desde *</label>
                        <input wire:model.live="from_year" type="number" min="1900" max="2100" placeholder="2026"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        @error('from_year') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Año Hasta *</label>
                        <input wire:model.live="to_year" type="number" min="1900" max="2100" placeholder="2027"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        @error('to_year') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <x-date-input 
                        label="Fecha Fin" 
                        model="end_date" 
                        error="end_date" 
                    />
                </div>

                <div class="pt-2 border-t border-gray-100 space-y-3">
                    <span class="block text-xs font-bold text-titanium uppercase tracking-wider">Inscripciones</span>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-date-input 
                                label="Inicio Inscripciones" 
                                model="inscription_start_at" 
                                error="inscription_start_at" 
                            />
                        </div>
                        <div>
                            <x-date-input 
                                label="Fin Inscripciones" 
                                model="inscription_end_at" 
                                error="inscription_end_at" 
                            />
                        </div>
                    </div>
                </div>
            </section>

            {{-- Bloque 3: Tarifas y Cuotas --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Condiciones Económicas
                </h3>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Número de Cuotas *</label>
                    <select wire:model.live="cuota" 
                            class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'cuota' : 'cuotas' }}</option>
                        @endfor
                    </select>
                    <p class="text-[11px] text-gray-400 mt-1">Cantidad de fraccionamientos para pagos.</p>
                    @error('cuota') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Precio Preinscripción (€)</label>
                    <input type="text" 
                           wire:model.live="precio_preinscripcion"
                           placeholder="0.00 €"
                           onfocus="this.select()"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-extrabold focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    <p class="text-[11px] text-gray-400 mt-1 flex items-start gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Pago obligatorio al realizar el alta en la escuela.
                    </p>
                    @error('precio_preinscripcion') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            </section>

            {{-- Bloque 4: Secciones y Precios --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <div>
                    <h3 class="font-bold text-base text-titanium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Secciones y Precios *
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Selecciona las secciones disponibles e indica la tarifa.</p>
                </div>

                @error('sectionPrices') 
                    <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                        <span class="text-red-700 text-xs font-semibold">{{ $message }}</span>
                    </div>
                @enderror

                <div class="space-y-3 pt-1">
                    @foreach($sections as $section)
                        @php
                            $isSelected = isset($sectionPrices[$section->id]) && $sectionPrices[$section->id] !== null && $sectionPrices[$section->id] !== '';
                        @endphp
                        <div class="rounded-2xl p-4 border-2 transition-all {{ $isSelected ? 'border-primary bg-primary/5 shadow-sm' : 'border-gray-100 bg-gray-50/50' }}">
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <label for="section_{{ $section->id }}" class="flex items-center gap-3 cursor-pointer select-none flex-1">
                                    <input type="checkbox" 
                                           id="section_{{ $section->id }}"
                                           {{ $isSelected ? 'checked' : '' }}
                                           wire:click="$set('sectionPrices.{{ $section->id }}', $event.target.checked ? 0 : null)"
                                           class="w-5 h-5 text-primary border-gray-300 rounded-lg focus:ring-primary cursor-pointer">
                                    <span class="font-bold text-sm {{ $isSelected ? 'text-primary' : 'text-titanium' }}">
                                        {{ $section->name }}
                                    </span>
                                </label>

                                @if($isSelected)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-primary text-white">
                                        Activa
                                    </span>
                                @endif
                            </div>

                            <div>
                                <input type="text" 
                                       wire:model.live="sectionPrices.{{ $section->id }}"
                                       placeholder="Precio Matrícula (€)"
                                       {{ !$isSelected ? 'disabled' : '' }}
                                       onfocus="this.select()"
                                       class="w-full px-3.5 py-3 rounded-xl text-sm font-bold border-0 transition-all {{ $isSelected ? 'bg-white text-black-deep ring-1 ring-primary/30 focus:ring-2 focus:ring-primary' : 'bg-gray-100/70 text-gray-400 cursor-not-allowed' }}">
                                @error('sectionPrices.' . $section->id) 
                                    <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </form>
    </div>

    {{-- BOTTOM APP BAR (Fijo abajo) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-3">
        <a href="{{ route('seasons.index') }}" 
           class="py-4 px-5 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center">
            Cancelar
        </a>

        <button type="submit" form="season-form" wire:loading.attr="disabled" wire:target="save"
                class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-base active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 disabled:opacity-70">
            <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <svg wire:loading wire:target="save" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="save">Crear Temporada</span>
            <span wire:loading wire:target="save">Creando...</span>
        </button>
    </div>
</div>