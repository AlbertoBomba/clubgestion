<div class="min-h-screen bg-gray-50 pb-28 relative">

    @php
        $seasonModel->loadCount(['players', 'teams', 'sections']);
        $canDelete = $seasonModel->players_count == 0 && $seasonModel->teams_count == 0 && $seasonModel->sections_count == 0;
    @endphp

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('seasons.index') }}" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-black text-lg text-titanium truncate max-w-[180px]">
                {{ $season }}
            </h2>
        </div>

        {{-- Acciones secundarias en cabecera --}}
        @if($isActive)
            @if($canDelete)
                <button type="button" wire:click="confirmDelete" class="p-2 rounded-full bg-red-50 text-red-600 active:scale-95 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            @else
                <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-400 font-bold text-[10px] uppercase">
                    Bloqueada
                </span>
            @endif
        @else
            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-bold text-[10px] uppercase">
                Inactiva
            </span>
        @endif
    </header>

    <div class="p-4 space-y-4">

        {{-- ALERTAS EN PARTE SUPERIOR --}}
        @if($hasChanges)
            <div class="p-4 bg-yellow-500/10 border-l-4 border-yellow-500 rounded-2xl flex items-center gap-3 animate-pulse">
                <span class="text-lg">⚠️</span>
                <p class="text-xs font-bold text-yellow-800">
                    Tienes cambios sin guardar. Toca en <span class="underline">Actualizar</span> abajo para guardarlos.
                </p>
            </div>
        @endif

        @if(!$isActive)
            <div class="p-4 bg-amber-500/10 border-l-4 border-amber-500 rounded-2xl flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs font-semibold text-amber-800">
                    Esta temporada no está activa y no se puede modificar. Solo consulta de información.
                </p>
            </div>
        @endif

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
                    <input wire:model.live="season" type="text" {{ !$isActive ? 'disabled' : '' }} 
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all {{ !$isActive ? 'bg-gray-100/70 text-gray-400 cursor-not-allowed' : '' }}">
                    @error('season') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Descripción</label>
                    <textarea wire:model.live="description" rows="3" {{ !$isActive ? 'disabled' : '' }} 
                              class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm focus:ring-2 focus:ring-primary focus:bg-white transition-all resize-none {{ !$isActive ? 'bg-gray-100/70 text-gray-400 cursor-not-allowed' : '' }}"></textarea>
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
                        <input wire:model.live="from_year" type="number" min="1900" max="2100" {{ !$isActive ? 'disabled' : '' }} 
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all {{ !$isActive ? 'bg-gray-100/70 text-gray-400 cursor-not-allowed' : '' }}">
                        @error('from_year') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Año Hasta *</label>
                        <input wire:model.live="to_year" type="number" min="1900" max="2100" {{ !$isActive ? 'disabled' : '' }} 
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all {{ !$isActive ? 'bg-gray-100/70 text-gray-400 cursor-not-allowed' : '' }}">
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
                                label="Inicio Inscripción" 
                                model="inscription_start_at" 
                                error="inscription_start_at"
                            />
                        </div>
                        <div>
                            <x-date-input 
                                label="Fin Inscripción" 
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
                    <select wire:model.live="cuota" {{ !$isActive ? 'disabled' : '' }} 
                            class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white transition-all {{ !$isActive ? 'bg-gray-100/70 text-gray-400 cursor-not-allowed' : '' }}">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'cuota' : 'cuotas' }}</option>
                        @endfor
                    </select>
                    <p class="text-[11px] text-gray-400 mt-1">Nº máximo de fraccionamientos de pago.</p>
                    @error('cuota') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1.5">Precio Preinscripción (€)</label>
                    <input type="text" 
                           wire:model.live="precio_preinscripcion"
                           placeholder="0.00 €"
                           {{ !$isActive ? 'disabled' : '' }}
                           onfocus="this.select()"
                           class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-extrabold focus:ring-2 focus:ring-primary focus:bg-white transition-all {{ !$isActive ? 'bg-gray-100/70 text-gray-400 cursor-not-allowed' : '' }}">
                    <p class="text-[11px] text-gray-400 mt-1 flex items-start gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Pago obligatorio del alumno al realizar el alta.
                    </p>
                    @error('precio_preinscripcion') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            </section>

            {{-- Bloque 4: Secciones y Precios en formato Cards --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <div>
                    <h3 class="font-bold text-base text-titanium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Secciones y Precios *
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Activa las secciones e indica la tarifa anual.</p>
                </div>

                @error('sectionPrices') 
                    <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded-2xl">
                        <span class="text-red-700 text-xs font-semibold">{{ $message }}</span>
                    </div>
                @enderror

                <div class="space-y-3 pt-1">
                    @foreach($sections as $section)
                        @php
                            $isSelected = in_array($section->id, $selectedSections);
                        @endphp
                        <div class="rounded-2xl p-4 border-2 transition-all {{ $isSelected ? 'border-primary bg-primary/5 shadow-sm' : 'border-gray-100 bg-gray-50/50' }}">
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <label for="section_{{ $section->id }}" class="flex items-center gap-3 cursor-pointer select-none flex-1">
                                    <input type="checkbox" 
                                           id="section_{{ $section->id }}"
                                           value="{{ $section->id }}"
                                           wire:model.live="selectedSections"
                                           {{ !$isActive ? 'disabled' : '' }}
                                           class="w-5 h-5 text-primary border-gray-300 rounded-lg focus:ring-primary {{ $isActive ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
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
                                       {{ !$isSelected || !$isActive ? 'disabled' : '' }}
                                       onfocus="this.select()"
                                       class="w-full px-3.5 py-3 rounded-xl text-sm font-bold border-0 transition-all {{ $isSelected && $isActive ? 'bg-white text-black-deep ring-1 ring-primary/30 focus:ring-2 focus:ring-primary' : 'bg-gray-100/70 text-gray-400 cursor-not-allowed' }}">
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

    {{-- BOTTOM APP BAR (Barra de acción principal fija abajo) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-3">
        <a href="{{ route('seasons.index') }}" 
           class="py-4 px-5 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center">
            Volver
        </a>

        @if($isActive)
            <button type="submit" form="season-form" wire:loading.attr="disabled" wire:target="save"
                    class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-base active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 disabled:opacity-70">
                <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Actualizar</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        @else
            <button type="button" disabled class="flex-1 py-4 bg-gray-200 text-gray-400 rounded-2xl font-bold text-base cursor-not-allowed text-center">
                Solo lectura
            </button>
        @endif
    </div>

    {{-- Modal de confirmación de eliminación --}}
    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title"><span class="font-bold">Eliminar Temporada</span></x-slot>
        <x-slot name="content">
            <p class="text-gray-600">¿Está seguro que desea eliminar esta temporada? Esta acción no se puede deshacer.</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl active:bg-gray-200">
                    Cancelar
                </button>
                <button wire:click="deleteSeason" wire:loading.attr="disabled" wire:target="deleteSeason" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl active:bg-red-700 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="deleteSeason">Eliminar</span>
                    <span wire:loading wire:target="deleteSeason" class="inline-flex items-center gap-1">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Eliminando...
                    </span>
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>