<div class="min-h-screen bg-gray-50 pb-28 relative">

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('players.index') }}" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="min-w-0">
                <h2 class="font-black text-base text-titanium truncate">
                    {{ $playerModel->name }} {{ $playerModel->surname }}
                </h2>
                <p class="text-[11px] font-bold text-gray-400">
                    Matrícula: <span class="text-primary">#{{ $playerModel->cod_matricula }}</span>
                </p>
            </div>
        </div>

        @if($playerModel->active)
            <span class="px-2.5 py-1 rounded-full bg-neon-green/10 text-neon-green font-extrabold text-[10px] uppercase tracking-wider flex-shrink-0">
                Activo
            </span>
        @else
            <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 font-extrabold text-[10px] uppercase tracking-wider flex-shrink-0">
                Inactivo
            </span>
        @endif
    </header>

    <div class="p-4 space-y-4">

        {{-- ALERTA CAMBIOS SIN GUARDAR --}}
        @if($hasChanges)
            <div class="p-4 bg-yellow-500/10 border-l-4 border-yellow-500 rounded-2xl flex items-center gap-3 animate-pulse">
                <span class="text-lg">⚠️</span>
                <p class="text-xs font-bold text-yellow-800">
                    Tienes cambios sin guardar. Toca en <span class="underline">Actualizar</span> abajo para aplicar.
                </p>
            </div>
        @endif

        <form wire:submit="save" id="player-form" class="space-y-4">

            {{-- FOTO Y PERFIL DE CABECERA --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4 text-center">
                <div class="relative inline-block mx-auto">
                    @if ($player_photo)
                        <img src="{{ $player_photo->temporaryUrl() }}" class="h-28 w-28 object-cover rounded-full border-4 border-primary shadow-md mx-auto">
                    @elseif($currentPhoto)
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $currentPhoto) }}" class="h-28 w-28 object-cover rounded-full border-4 border-gray-100 shadow-md mx-auto">
                            <button type="button" wire:click="deletePhoto" wire:confirm="¿Estás seguro de eliminar la foto actual?"
                                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1.5 shadow-lg active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="h-28 w-28 rounded-full border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center mx-auto text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Controles de Foto --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider">
                        {{ $currentPhoto ? 'Cambiar foto del jugador' : 'Subir foto del jugador' }}
                    </label>

                    {{-- Editor Recorte Foto --}}
                    <div id="player-photo-editor" class="hidden border-2 border-dashed border-primary rounded-2xl p-3 bg-gray-50">
                        <img id="player-crop-image" class="max-w-full block rounded-xl mb-3">
                        <div class="flex gap-2">
                            <button type="button" onclick="cropAndUploadPlayerPhoto()" class="flex-1 py-2.5 bg-primary text-white font-bold text-xs rounded-xl active:scale-95">
                                ✂️ Recortar y Usar
                            </button>
                            <button type="button" onclick="cancelPlayerPhotoCrop()" class="py-2.5 px-4 bg-red-500 text-white font-bold text-xs rounded-xl active:scale-95">
                                Cancelar
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-2 justify-center">
                        <label class="px-4 py-2.5 bg-gray-100 text-titanium rounded-xl font-bold text-xs active:scale-95 cursor-pointer">
                            📁 Seleccionar Imagen
                            <input type="file" id="player-photo-file-input" accept="image/*" class="hidden" onchange="handlePlayerPhotoSelect(event)">
                        </label>

                        @if($currentPhoto)
                            <a href="{{ Storage::url($currentPhoto) }}" download class="px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-xs active:scale-95 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Descargar
                            </a>
                        @endif
                    </div>

                    <input type="file" wire:model.live="player_photo" id="player-photo-livewire-input" accept="image/*" class="hidden">
                    
                    <div wire:loading wire:target="player_photo" class="text-xs text-primary font-bold">Subiendo foto...</div>
                    @error('player_photo') <span class="text-red-500 text-xs block font-medium">{{ $message }}</span> @enderror
                </div>
            </section>

            {{-- BLOQUE 1: DATOS JUGADOR --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Datos Personales
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Nombre *</label>
                        <input wire:model.live="name" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Apellidos *</label>
                        <input wire:model.live="surname" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('surname') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">DNI</label>
                        <input wire:model.live="dni" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('dni') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-date-input label="Fecha Nacimiento" model="dbirth" error="dbirth" />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Año Nac.</label>
                        <input wire:model.live="dbanio" type="number" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('dbanio') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Dorsal</label>
                        <input wire:model.live="dorsal" type="number" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('dorsal') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Tallas</label>
                        <button type="button" wire:click="openSizesModal" class="w-full py-3 bg-primary/10 text-primary rounded-2xl font-bold text-xs truncate">
                            {{ $sizes ?: 'Elegir' }}
                        </button>
                        @error('sizes') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- DESCUENTOS --}}
                <div class="pt-2 border-t border-gray-100 space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Tipo de Descuento</label>
                        <select wire:model.live="discountType" {{ $this->hasPaymentOrders ? 'disabled' : '' }}
                                class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white {{ $this->hasPaymentOrders ? 'opacity-60 cursor-not-allowed' : '' }}">
                            <option value="ninguno">Sin descuento</option>
                            <option value="cantidad">Descuento en cantidad (€)</option>
                            <option value="porcentaje">Descuento en porcentaje (%)</option>
                        </select>
                    </div>

                    @if($this->hasPaymentOrders)
                        <div class="p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded-xl">
                            <p class="text-xs font-bold text-yellow-800">Descuentos bloqueados</p>
                            <p class="text-[11px] text-yellow-700 mt-0.5">El jugador tiene cartas de pago generadas.</p>
                        </div>
                    @endif

                    @if($discountType === 'cantidad')
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Cantidad (€)</label>
                            <input wire:model.live="descEnt" type="text" onfocus="this.select()" {{ $this->hasPaymentOrders ? 'disabled' : '' }}
                                   class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        </div>
                    @endif

                    @if($discountType === 'porcentaje')
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Porcentaje (%)</label>
                            <input wire:model.live="descPerc" type="text" onfocus="this.select()" {{ $this->hasPaymentOrders ? 'disabled' : '' }}
                                   class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        </div>
                    @endif
                </div>
            </section>

            {{-- BLOQUE 2: DATOS DEPORTIVOS Y SECCIONES --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Estado y Secciones
                </h3>

                {{-- Checkboxes Estado --}}
                <div class="grid grid-cols-3 gap-2">
                    <label class="p-3 bg-gray-50 rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer select-none">
                        <input wire:model.live="active" type="checkbox" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary mb-1">
                        <span class="text-[11px] font-bold text-titanium">Activo</span>
                    </label>

                    <label class="p-3 bg-gray-50 rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer select-none">
                        <input wire:model.live="goalie" type="checkbox" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary mb-1">
                        <span class="text-[11px] font-bold text-titanium">Portero</span>
                    </label>

                    <label class="p-3 bg-gray-50 rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer select-none">
                        <input wire:model.live="file" type="checkbox" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary mb-1">
                        <span class="text-[11px] font-bold text-titanium">Ficha</span>
                    </label>
                </div>

                {{-- Lista de Secciones --}}
                <div class="pt-2">
                    <span class="block text-xs font-bold text-titanium uppercase tracking-wider mb-2">Secciones Participantes</span>
                    @error('selectedSections') <span class="text-red-500 text-xs block mb-2 font-medium">{{ $message }}</span> @enderror

                    @php $lockedSectionIds = $this->lockedSectionIds; @endphp

                    <div class="space-y-2">
                        @forelse($sections as $section)
                            @php $isLocked = in_array($section->id, $lockedSectionIds); @endphp
                            <div class="rounded-2xl p-3 border-2 transition-all flex items-center justify-between {{ in_array($section->id, $selectedSections) ? 'border-primary bg-primary/5' : 'border-gray-100 bg-gray-50/50' }}">
                                <label for="section_{{ $section->id }}" class="flex items-center gap-3 cursor-pointer flex-1">
                                    <input type="checkbox" id="section_{{ $section->id }}"
                                           wire:model.live="selectedSections" value="{{ $section->id }}"
                                           @if($isLocked) disabled @endif
                                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <span class="font-bold text-sm {{ in_array($section->id, $selectedSections) ? 'text-primary' : 'text-titanium' }}">
                                        {{ $section->name }}
                                    </span>
                                </label>

                                @if(in_array($section->id, $selectedSections))
                                    @if($isLocked)
                                        <svg class="w-4 h-4 text-primary/70" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    @else
                                        <button type="button" wire:click="openTeamsModal(null, {{ $section->id }})"
                                                class="px-3 py-1.5 bg-primary text-white rounded-xl font-bold text-xs active:scale-95">
                                            + Equipo
                                        </button>
                                    @endif
                                @endif
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-2">Sin secciones disponibles.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Observaciones --}}
                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Observaciones</label>
                    <textarea wire:model.live="observations" rows="2" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm focus:ring-2 focus:ring-primary focus:bg-white resize-none"></textarea>
                </div>
            </section>

            {{-- BLOQUE 3: EQUIPOS ASIGNADOS --}}
            @if($playerModel->active)
                <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
                    <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Equipos Asignados
                    </h3>

                    @if(count($playerTeams) > 0)
                        <div class="space-y-2">
                            @foreach($playerTeams as $playerTeam)
                                <div class="bg-blue-50/70 border border-blue-100 rounded-2xl p-4 flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-extrabold text-blue-700 uppercase">
                                            Cat: {{ $playerTeam->category->category ?? 'N/A' }} | Sec: {{ $playerTeam->section->name ?? 'N/A' }}
                                        </p>
                                        <p class="font-black text-base text-blue-900 truncate">{{ $playerTeam->team }}</p>
                                    </div>

                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <button type="button" wire:click="openTeamsModal({{ $playerTeam }})" class="p-2.5 bg-blue-600 text-white rounded-xl active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                        </button>
                                        <button type="button" wire:click="removeTeam({{ $playerTeam->id }})" class="p-2.5 bg-red-600 text-white rounded-xl active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 rounded-2xl border border-yellow-100 text-center">
                            <p class="text-xs font-bold text-yellow-800">El jugador no tiene equipo asignado.</p>
                        </div>
                    @endif
                </section>
            @endif

            {{-- BLOQUE 4: DATOS DEL TUTOR (Si es menor) --}}
            @if(!$this->isAdult)
                <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                    <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Datos del Tutor Legal
                    </h3>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Nombre Tutor</label>
                        <input wire:model.live="nametutor" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('nametutor') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">DNI Tutor</label>
                            <input wire:model.live="dnitutor" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                            @error('dnitutor') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Teléfono Tutor</label>
                            <input wire:model.live="phone2" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                            @error('phone2') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>
            @endif

            {{-- BLOQUE 5: CONTACTO Y DIRECCIÓN --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Contacto y Dirección
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Teléfono Jugador</label>
                        <input wire:model.live="phone1" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('phone1') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Email</label>
                        <input wire:model.live="email" type="email" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Dirección</label>
                    <input wire:model.live="address" type="text" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Población</label>
                        <input wire:model.live="town" type="text" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">C.P.</label>
                        <input wire:model.live="zip" type="text" maxlength="5" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Provincia</label>
                        <input wire:model.live="province" type="text" class="w-full px-3 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                    </div>
                </div>

                {{-- FIRMA REGISTRADA --}}
                @if ($existing_signature)
                    <div class="pt-2 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-titanium uppercase tracking-wider">Firma de inscripción</span>
                            <a href="{{ Storage::url($existing_signature) }}" download class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-xs">Descargar</a>
                        </div>
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-3 flex justify-center">
                            <img src="{{ Storage::url($existing_signature) }}" class="max-h-28 object-contain">
                        </div>
                    </div>
                @endif
            </section>

            {{-- BLOQUE 6: DOCUMENTACIÓN --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Documentación Adjunta
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Tipo de documento *</label>
                        <select wire:model.live="documentType" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                            <option value="">Selecciona el tipo...</option>
                            <option value="dni_frontal">DNI Frontal</option>
                            <option value="dni_trasero">DNI Trasero</option>
                            <option value="ficha_medica">Ficha Médica</option>
                            <option value="autorizacion">Autorización</option>
                            <option value="otros">Otros documentos</option>
                        </select>
                        @error('documentType') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    @if($documentType === 'otros')
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Descripción</label>
                            <input type="text" wire:model.live="documentLabel" placeholder="Ej: Certificado..." class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                            @error('documentLabel') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    @if($documentType)
                        <div class="space-y-2">
                            @if(in_array($documentType, ['dni_frontal', 'dni_trasero']))
                                <div class="flex gap-2">
                                    <button type="button" onclick="activateCamera()" class="flex-1 py-3 bg-primary/10 text-primary font-bold text-xs rounded-2xl active:scale-95">
                                        📷 Tomar Foto
                                    </button>
                                    <label class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-xs rounded-2xl active:scale-95 text-center cursor-pointer">
                                        📁 Subir
                                        <input type="file" id="dni-file-input" accept="image/*" class="hidden" onchange="handleDniFileSelect(event)">
                                    </label>
                                </div>

                                {{-- Previsualización Cámara --}}
                                @if($captureMode)
                                    <div class="border-2 border-dashed border-primary rounded-2xl p-3 bg-black space-y-2" wire:ignore>
                                        <video id="camera-preview" autoplay playsinline muted class="w-full rounded-xl object-cover" style="aspect-ratio: 16/10;"></video>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="capturePhoto()" class="flex-1 py-3 bg-primary text-white font-bold text-xs rounded-xl active:scale-95">
                                                📸 Capturar
                                            </button>
                                            <button type="button" onclick="cancelCamera()" class="py-3 px-4 bg-red-500 text-white font-bold text-xs rounded-xl active:scale-95">
                                                Cancelar
                                            </button>
                                        </div>
                                        <canvas id="photo-canvas" class="hidden"></canvas>
                                    </div>
                                @endif

                                {{-- Recortador DNI --}}
                                <div id="dni-editor" class="hidden border-2 border-dashed border-primary rounded-2xl p-3 bg-gray-50">
                                    <img id="dni-crop-image" class="max-w-full block rounded-xl mb-3">
                                    <div class="flex gap-2">
                                        <button type="button" onclick="cropAndUploadDni()" class="flex-1 py-2.5 bg-primary text-white font-bold text-xs rounded-xl active:scale-95">
                                            ✂️ Recortar DNI
                                        </button>
                                        <button type="button" onclick="cancelDniCrop()" class="py-2.5 px-4 bg-red-500 text-white font-bold text-xs rounded-xl active:scale-95">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                                <input type="file" wire:model.live="document" id="dni-livewire-input" accept="image/*" class="hidden">
                            @else
                                <input type="file" wire:model.live="document" accept=".pdf,.jpg,.jpeg,.png"
                                       class="block w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary cursor-pointer">
                            @endif

                            @if($document)
                                <button type="button" wire:click="uploadDocument" class="w-full py-3 bg-primary text-white font-bold text-xs rounded-2xl active:scale-95 shadow-md">
                                    📤 Confirmar y Subir Documento
                                </button>
                            @endif
                        </div>
                    @endif

                    {{-- Lista de Documentos Subidos --}}
                    @if(!empty($existingDocuments))
                        <div class="pt-3 space-y-2">
                            <span class="block text-xs font-bold text-titanium uppercase tracking-wider">Archivos Guardados</span>
                            @foreach($existingDocuments as $index => $doc)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if(str_ends_with($doc['path'], '.pdf'))
                                            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs flex-shrink-0">PDF</div>
                                        @else
                                            <img src="{{ asset('storage/' . $doc['path']) }}" class="w-10 h-10 rounded-xl object-cover border border-gray-200 flex-shrink-0">
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-bold text-xs text-titanium truncate">{{ $doc['label'] }}</p>
                                            <p class="text-[10px] text-gray-400 truncate">{{ $doc['original_name'] ?? 'Doc' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="p-2 bg-white text-primary rounded-xl border border-gray-100 active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <button type="button" wire:click="confirmDeleteDocument({{ $index }})" class="p-2 bg-red-50 text-red-600 rounded-xl active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </form>
    </div>

    {{-- BOTTOM APP BAR (Fijo abajo con acciones principales) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-2">
        <a href="{{ route('players.index') }}" class="py-4 px-4 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center">
            Salir
        </a>

        <button type="button" wire:click="printPlayerCard" wire:loading.attr="disabled" wire:target="printPlayerCard"
                class="py-4 px-4 bg-green-50 text-green-700 font-bold text-sm rounded-2xl active:scale-95 transition-all flex justify-center items-center gap-1.5">
            <svg wire:loading.remove wire:target="printPlayerCard" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span wire:loading.remove wire:target="printPlayerCard">Imprimir</span>
            <span wire:loading wire:target="printPlayerCard">Generando...</span>
        </button>

        <button type="submit" form="player-form" wire:loading.attr="disabled" wire:target="save"
                class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-base active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
            <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            <span wire:loading.remove wire:target="save">Actualizar</span>
            <span wire:loading wire:target="save">Guardando...</span>
        </button>
    </div>

    {{-- ASSETS Y SCRIPTS --}}
    @assets
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    @endassets

    @script
    <script>
        let playerPhotoCropper = null;
        let dniCropper = null;
        let stream = null;
        let currentComponent = null;

        document.addEventListener('livewire:initialized', () => {
            currentComponent = @this;
            window.addEventListener('start-camera', () => { setTimeout(() => startCamera(), 300); });
        });

        window.activateCamera = function() {
            if (currentComponent) {
                currentComponent.set('captureMode', true);
                setTimeout(() => startCamera(), 500);
            }
        }

        window.cancelCamera = function() {
            stopCamera();
            if (currentComponent) { currentComponent.set('captureMode', false); }
        }

        window.handlePlayerPhotoSelect = function(event) {
            const file = event.target.files[0];
            if (!file) return;
            const editor = document.getElementById('player-photo-editor');
            const image = document.getElementById('player-crop-image');
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                editor.classList.remove('hidden');
                if (playerPhotoCropper) { playerPhotoCropper.destroy(); }
                playerPhotoCropper = new Cropper(image, { aspectRatio: 1, viewMode: 1, autoCropArea: 0.9, responsive: true });
            };
            reader.readAsDataURL(file);
        }

        window.cropAndUploadPlayerPhoto = function() {
            if (!playerPhotoCropper) return;
            playerPhotoCropper.getCroppedCanvas({ width: 400, height: 400, imageSmoothingQuality: 'high' }).toBlob(function(blob) {
                const file = new File([blob], `player-photo-${Date.now()}.jpg`, { type: 'image/jpeg' });
                const livewireInput = document.getElementById('player-photo-livewire-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                livewireInput.files = dataTransfer.files;
                livewireInput.dispatchEvent(new Event('change', { bubbles: true }));
                window.cancelPlayerPhotoCrop();
            }, 'image/jpeg', 0.95);
        }

        window.cancelPlayerPhotoCrop = function() {
            const editor = document.getElementById('player-photo-editor');
            const fileInput = document.getElementById('player-photo-file-input');
            if (playerPhotoCropper) { playerPhotoCropper.destroy(); playerPhotoCropper = null; }
            editor.classList.add('hidden');
            if(fileInput) fileInput.value = '';
        }

        window.handleDniFileSelect = function(event) {
            const file = event.target.files[0];
            if (!file) return;
            const editor = document.getElementById('dni-editor');
            const image = document.getElementById('dni-crop-image');
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                editor.classList.remove('hidden');
                if (dniCropper) { dniCropper.destroy(); }
                dniCropper = new Cropper(image, { aspectRatio: 1.586, viewMode: 1, autoCropArea: 0.9, responsive: true });
            };
            reader.readAsDataURL(file);
        }

        window.cropAndUploadDni = function() {
            if (!dniCropper) return;
            dniCropper.getCroppedCanvas({ width: 1920, height: 1210, imageSmoothingQuality: 'high' }).toBlob(function(blob) {
                const file = new File([blob], `dni-cropped-${Date.now()}.jpg`, { type: 'image/jpeg' });
                const livewireInput = document.getElementById('dni-livewire-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                livewireInput.files = dataTransfer.files;
                livewireInput.dispatchEvent(new Event('change', { bubbles: true }));
                window.cancelDniCrop();
            }, 'image/jpeg', 0.95);
        }

        window.cancelDniCrop = function() {
            const editor = document.getElementById('dni-editor');
            const fileInput = document.getElementById('dni-file-input');
            if (dniCropper) { dniCropper.destroy(); dniCropper = null; }
            editor.classList.add('hidden');
            if(fileInput) fileInput.value = '';
        }

        async function startCamera() {
            try {
                const video = document.getElementById('camera-preview');
                if (!video) return;
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment', width: { ideal: 1920 }, height: { ideal: 1080 } } });
                video.srcObject = stream;
                await video.play();
            } catch (err) {
                alert('No se pudo acceder a la cámara. Sube la foto mediante archivo.');
                if (currentComponent) currentComponent.set('captureMode', false);
            }
        }

        function stopCamera() {
            if (stream) { stream.getTracks().forEach(track => track.stop()); stream = null; }
        }

        window.capturePhoto = async function() {
            const video = document.getElementById('camera-preview');
            const canvas = document.getElementById('photo-canvas');
            if (!video || !canvas) return;
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            canvas.toBlob(async (blob) => {
                if (!blob) return;
                const file = new File([blob], `dni-capture-${Date.now()}.jpg`, { type: 'image/jpeg' });
                const livewireInput = document.getElementById('dni-livewire-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                livewireInput.files = dataTransfer.files;
                livewireInput.dispatchEvent(new Event('change', { bubbles: true }));
                stopCamera();
                if (currentComponent) currentComponent.set('captureMode', false);
            }, 'image/jpeg', 0.9);
        }

        window.addEventListener('beforeunload', () => {
            stopCamera();
            if (dniCropper) dniCropper.destroy();
            if (playerPhotoCropper) playerPhotoCropper.destroy();
        });
    </script>
    @endscript

    {{-- ============================================================== --}}
    {{-- MODALES CONVERTIDOS A <x-dialog-modal> (Solución Anti-Crash)   --}}
    {{-- ============================================================== --}}

    {{-- Modal Tallas --}}
    <x-dialog-modal wire:model="showSizesModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="font-black text-lg text-titanium flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Seleccionar Talla
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="max-h-[60vh] overflow-y-auto pr-2 pb-2">
                @if(!empty($availableSizes) && $availableSizes->isEmpty())
                    <p class="text-xs text-gray-500 text-center py-6">No hay tallas disponibles para esta escuela.</p>
                @else
                    @php $currentBrand = null; @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($availableSizes as $size)
                            @if($currentBrand !== $size->brand_id)
                                @php $currentBrand = $size->brand_id; @endphp
                                <div class="col-span-full pt-2">
                                    <p class="text-xs font-black text-primary uppercase tracking-wider border-b border-primary/20 pb-1">{{ $size->brand->brand ?? 'Marca' }}</p>
                                </div>
                            @endif
                            <button type="button" wire:click="selectSize({{ $size->id }})"
                                    class="p-4 border-2 rounded-2xl text-center active:scale-95 transition-all {{ $sizes === $size->size ? 'border-primary bg-primary/10 font-black text-primary' : 'border-gray-100 bg-gray-50 font-bold text-titanium' }}">
                                <span class="text-lg block">{{ $size->size }}</span>
                                @if($size->description) <span class="text-[10px] text-gray-500 block font-normal mt-1 leading-tight">{{ $size->description }}</span> @endif
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <button type="button" wire:click="closeSizesModal" class="w-full sm:w-auto py-3 px-6 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cerrar</button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Equipos --}}
    <x-dialog-modal wire:model="showTeamsModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="font-black text-lg text-titanium flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3v0a3 3 0 00-3 3v2zm-5-2a3 3 0 013-3m0 0a3 3 0 013 3m-6 0h6m2-13a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Seleccionar Equipo
            </div>
        </x-slot>
        <x-slot name="content">
            @php
                $seasonPlayer = \App\Models\SeasonPlayer::where('player_id', $playerModel->id)
                    ->whereHas('season', function ($query) {
                        $query->where('sports_school_id', auth()->user()->sports_school_id)
                              ->where('start_date', '<=', now())
                              ->where('end_date', '>=', now());
                    })->first();

                $availableTeams = collect();
                if ($seasonPlayer) {
                    $availableTeams = \App\Models\Team::where('season_id', $seasonPlayer->season_id)
                        ->where('section_id', $selectedSectionId)
                        ->with('category' ,'section')->orderBy('team')->get();
                }
            @endphp
            <div class="max-h-[60vh] overflow-y-auto space-y-3 pr-2 pb-2">
                @forelse($availableTeams as $team)
                    <button type="button" wire:click="assignTeam({{ $team->id }})"
                            class="w-full p-4 border-2 rounded-2xl flex items-center justify-between text-left active:scale-95 transition-all {{ $playerTeams && $selectedTeamId === $team->id ? 'border-primary bg-primary/10' : 'border-gray-100 bg-gray-50' }}">
                        <div>
                            <p class="font-black text-base text-titanium">{{ $team->team }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-0.5">{{ $team->category->name ?? 'Cat. N/A' }}</p>
                        </div>
                        <span class="text-primary font-bold text-xs uppercase tracking-wider">Seleccionar →</span>
                    </button>
                @empty
                    <div class="text-center py-10">
                        <p class="text-sm font-bold text-gray-500 mb-1">No hay equipos disponibles</p>
                        <p class="text-xs text-gray-400">Asegúrate de tener una temporada activa con equipos creados en esta sección.</p>
                    </div>
                @endforelse
            </div>
        </x-slot>
        <x-slot name="footer">
            <button type="button" wire:click="closeTeamsModal" class="w-full sm:w-auto py-3 px-6 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cerrar</button>
        </x-slot>
    </x-dialog-modal>

    {{-- MODAL DE PREVISUALIZACIÓN DE PAGOS --}}
    <x-dialog-modal wire:model="showPreviewModal" maxWidth="2xl">
        <x-slot name="title">
            <div class="font-black text-lg text-blue-600 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Cambios en Pagos
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                {{-- Resumen general --}}
                <div class="bg-blue-50 border-2 border-blue-100 p-4 rounded-2xl">
                    <div class="space-y-2 text-sm font-semibold">
                        @if(!empty($paymentsPaid))
                            <p class="text-green-700">✅ <strong class="font-black">{{ count($paymentsPaid) }}</strong> pagos realizados se mantienen</p>
                        @endif
                        @if(!empty($paymentsToDelete))
                            <p class="text-red-700">🗑️ <strong class="font-black">{{ count($paymentsToDelete) }}</strong> pagos pendientes se eliminarán</p>
                        @endif
                        @if(!empty($paymentsToCreate))
                            <p class="text-blue-700">➕ <strong class="font-black">{{ count($paymentsToCreate) }}</strong> nuevas cartas de pago se generarán</p>
                        @endif
                    </div>
                </div>

                {{-- Pagos a eliminar --}}
                <div class="border-2 border-red-100 rounded-2xl bg-white overflow-hidden">
                    <div class="bg-red-50/50 px-4 py-3 border-b border-red-100">
                        <h4 class="text-xs font-black text-red-900 uppercase tracking-wider">A Eliminar ({{ !empty($paymentsToDelete) ? count($paymentsToDelete) : 0 }})</h4>
                    </div>
                    <div class="p-3 space-y-2 max-h-48 overflow-y-auto">
                        @if(!empty($paymentsToDelete))
                            @foreach($paymentsToDelete as $payment)
                                <div class="p-3 bg-red-50/50 rounded-xl text-xs border border-red-100">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-bold text-gray-900">{{ $payment['player_name'] ?? 'Jugador' }}</span>
                                        <span class="font-black text-red-600">{{ number_format($payment['amount'] ?? 0, 2) }}€</span>
                                    </div>
                                    <div class="text-gray-600"><span class="font-bold">Cuota {{ $payment['cuota'] ?? '' }}</span> • {{ $payment['description'] ?? '' }}</div>
                                    <div class="text-gray-400 mt-1">Ref: {{ $payment['code'] ?? '' }}</div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center py-2 text-gray-400 text-xs font-bold">No hay pagos a eliminar</p>
                        @endif
                    </div>
                </div>

                {{-- Nuevas Cartas --}}
                <div class="border-2 border-green-100 rounded-2xl bg-white overflow-hidden">
                    <div class="bg-green-50/50 px-4 py-3 border-b border-green-100">
                        <h4 class="text-xs font-black text-green-900 uppercase tracking-wider">Nuevas Cartas ({{ !empty($paymentsToCreate) ? count($paymentsToCreate) : 0 }})</h4>
                    </div>
                    <div class="p-3 space-y-2 max-h-48 overflow-y-auto">
                        @if(!empty($paymentsToCreate))
                            @foreach($paymentsToCreate as $payment)
                                <div class="p-3 bg-green-50/50 rounded-xl text-xs border border-green-100">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-bold text-gray-900">{{ $payment['player_name'] ?? 'Jugador' }}</span>
                                        <div class="flex items-center gap-2">
                                            @if(isset($payment['amount']) && isset($payment['amount_original']) && $payment['amount'] != $payment['amount_original'])
                                                <span class="text-gray-400 line-through">{{ number_format($payment['amount_original'], 2) }}€</span>
                                            @endif
                                            <span class="font-black text-green-600">{{ number_format($payment['amount'] ?? 0, 2) }}€</span>
                                        </div>
                                    </div>
                                    <div class="text-gray-600"><span class="font-bold">Cuota {{ $payment['cuota'] ?? '' }}</span> • {{ $payment['description'] ?? '' }}</div>
                                    <div class="text-gray-400 mt-1">Equipo: {{ $payment['team_name'] ?? 'N/A' }}</div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center py-2 text-gray-400 text-xs font-bold">No hay cartas nuevas</p>
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="$set('showPreviewModal', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                <button wire:click="confirmPaymentsAction" wire:loading.attr="disabled" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:bg-blue-700">Confirmar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Confirmación Quitar Equipo --}}
    <x-dialog-modal wire:model="showRemoveTeamModal" maxWidth="sm">
        <x-slot name="title">
            <div class="font-black text-lg text-red-600">Remover del Equipo</div>
        </x-slot>
        <x-slot name="content">
            <p class="text-sm font-semibold text-gray-600">El jugador quedará sin este equipo y sus cartas de pago pendientes se eliminarán. ¿Continuar?</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="$set('showRemoveTeamModal', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                <button type="button" wire:click="confirmRemoveTeam" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Quitar Equipo</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Eliminar Documento --}}
    <x-dialog-modal wire:model="showDeleteModal" maxWidth="sm">
        <x-slot name="title">
            <div class="font-black text-lg text-gray-900">¿Eliminar Documento?</div>
        </x-slot>
        <x-slot name="content">
            <p class="text-sm text-gray-500">Esta acción no se puede deshacer y el archivo se borrará permanentemente.</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelDeleteDocument" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl active:bg-gray-200">Cancelar</button>
                <button type="button" wire:click="deleteDocument" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Eliminar</button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>