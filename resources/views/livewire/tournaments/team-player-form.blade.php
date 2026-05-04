<div>
    {{-- Cropper overlay --}}
    <div id="tp-cropper-overlay" class="fixed inset-0 z-[300] bg-black/85 flex items-center justify-center p-4"
         style="display:none" wire:ignore>
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-black text-gray-900">Recortar imagen</p>
                    <p class="text-xs text-gray-400 mt-0.5" id="tp-cropper-subtitle">Ajusta el recuadro al area que quieres usar</p>
                </div>
                <button type="button" onclick="tpCancelCrop()"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-3 bg-gray-900" style="max-height:340px;overflow:hidden">
                <img id="tp-crop-img" class="max-w-full block" alt="Recortar">
            </div>
            <div class="flex gap-2 p-4">
                <button type="button" onclick="tpCancelCrop()"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="tpApplyCrop()"
                        class="flex-1 py-2.5 rounded-xl text-white text-sm font-bold bg-primary hover:bg-primary/90 transition-opacity">
                    Usar este recorte
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden Livewire wire:model.live inputs --}}
    <input type="file" id="tp-photo-wire"     wire:model.live="p_photo"        accept="image/*" class="hidden">
    <input type="file" id="tp-doc-front-wire" wire:model.live="p_doc_front"    accept="image/*" class="hidden">
    <input type="file" id="tp-doc-back-wire"  wire:model.live="p_doc_back"     accept="image/*" class="hidden">
    <input type="file" id="tp-extra-wire"     wire:model.live="new_extra_file" accept="image/*" class="hidden">

    {{-- Trigger inputs --}}
    <input type="file" id="tp-photo-trigger"     accept="image/*" class="hidden" onchange="tpOpenCropper(event,'photo')">
    <input type="file" id="tp-doc-front-trigger" accept="image/*" class="hidden" onchange="tpOpenCropper(event,'doc_front')">
    <input type="file" id="tp-doc-back-trigger"  accept="image/*" class="hidden" onchange="tpOpenCropper(event,'doc_back')">
    <input type="file" id="tp-extra-trigger"     accept="image/*" class="hidden" onchange="tpOpenCropper(event,'extra')">

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 px-3 sm:px-4 lg:px-6 max-w-3xl mx-auto">

        {{-- HEADER --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-5">
            <div class="px-5 py-4">
                <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-3 font-medium flex-wrap">
                    <a href="{{ route('tournaments.index') }}" class="hover:text-primary transition-colors">Torneos</a>
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('tournaments.show', $tournament) }}" class="hover:text-primary transition-colors truncate max-w-[120px]">{{ $tournament->name }}</a>
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('tournament.team.players', [$tournament, $tournamentTeam]) }}" class="hover:text-primary transition-colors truncate max-w-[120px]">{{ $tournamentTeam->displayName() }}</a>
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-800">{{ $player ? 'Editar jugador' : 'Nuevo jugador' }}</span>
                </nav>
                <h1 class="text-xl font-bold text-gray-900">{{ $player ? 'Editar jugador' : 'Nuevo jugador' }}</h1>
                @if ($player)
                    <p class="text-sm text-gray-400 mt-0.5">{{ $player->fullName() }}</p>
                @endif
            </div>
        </div>

        <div class="space-y-5">

            {{-- Datos personales --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Datos personales</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nombre *</label>
                        <input wire:model="p_name" type="text" placeholder="Nombre"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Apellidos</label>
                        <input wire:model="p_surname" type="text" placeholder="Apellidos"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_surname') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Fecha de nacimiento</label>
                        <input wire:model="p_birthdate" type="date"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Teléfono</label>
                        <input wire:model="p_phone" type="tel" placeholder="600 000 000"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                        <input wire:model="p_email" type="email" placeholder="jugador@ejemplo.com"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Datos deportivos --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Datos deportivos</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Posición</label>
                        <select wire:model="p_position"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                            <option value="">Selecciona posición</option>
                            @foreach ($positions as $pos)
                                <option value="{{ $pos }}">{{ $pos }}</option>
                            @endforeach
                        </select>
                        @error('p_position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Dorsal</label>
                        <input wire:model="p_dorsal" type="number" min="0" max="999" placeholder="Nº dorsal"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_dorsal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Categoría</label>
                        <input wire:model="p_categoria" type="text" placeholder="p.ej. Juvenil A, Sub-18..."
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_categoria') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center pt-4">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <div class="relative">
                                <input wire:model="p_federado" type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Jugador federado</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Foto carnet --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Foto carnet</h2>
                @if ($existing_photo && !$clearPhoto && !$p_photo)
                    <div class="flex items-center gap-4">
                        <img src="{{ Storage::url($existing_photo) }}" class="w-20 h-20 object-cover rounded-xl border border-gray-200" alt="">
                        <div class="flex flex-col gap-2">
                            <button type="button" onclick="document.getElementById('tp-photo-trigger').click()"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-primary border border-primary/30 rounded-lg hover:bg-primary/5 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Cambiar foto
                            </button>
                            <button type="button" wire:click="$set('clearPhoto', true)"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-500 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Eliminar foto
                            </button>
                        </div>
                    </div>
                @elseif ($p_photo)
                    <div class="flex items-center gap-4">
                        <img src="{{ $p_photo->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-xl border border-gray-200" alt="">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Nueva foto seleccionada</p>
                            <button type="button" onclick="document.getElementById('tp-photo-trigger').click()"
                                    class="text-xs text-primary hover:underline mt-1">Cambiar</button>
                        </div>
                    </div>
                @else
                    <button type="button" onclick="document.getElementById('tp-photo-trigger').click()"
                            class="w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl py-8 hover:border-primary/40 hover:bg-gray-50 transition-colors">
                        <svg class="w-10 h-10 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <p class="text-sm font-semibold text-gray-500">Subir foto carnet</p>
                        <p class="text-xs text-gray-300 mt-0.5">JPG / PNG · Se abrirá el recortador</p>
                    </button>
                    @error('p_photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @endif
            </div>

            {{-- Documento de identidad --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Documento de identidad</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Tipo</label>
                        <select wire:model.live="p_doc_type"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                            <option value="">Sin especificar</option>
                            @foreach ($docTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('p_doc_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Número</label>
                        <input wire:model="p_dni" type="text" placeholder="12345678A"
                               class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('p_dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if ($p_doc_type === 'passport')
                    <p class="text-xs text-amber-600 bg-amber-50 rounded-xl px-3 py-2 mb-4 border border-amber-100">Pasaporte: solo es necesaria la cara A.</p>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Cara A --}}
                    <div>
                        <p class="text-xs font-bold text-gray-600 mb-2">Cara A (frente)</p>
                        @if ($existing_doc_front && !$clearDocFront && !$p_doc_front)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ Storage::url($existing_doc_front) }}" class="w-full h-32 object-cover" alt="">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <a href="{{ Storage::url($existing_doc_front) }}" target="_blank"
                                       class="p-2 bg-white rounded-lg text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <button type="button" onclick="document.getElementById('tp-doc-front-trigger').click()"
                                            class="p-2 bg-white rounded-lg text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </button>
                                    <button type="button" wire:click="$set('clearDocFront', true)"
                                            class="p-2 bg-white rounded-lg text-red-500 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        @elseif ($p_doc_front)
                            <div class="rounded-xl overflow-hidden border border-gray-200 relative">
                                <img src="{{ $p_doc_front->temporaryUrl() }}" class="w-full h-32 object-cover" alt="">
                                <button type="button" onclick="document.getElementById('tp-doc-front-trigger').click()"
                                        class="absolute top-2 right-2 p-1.5 bg-white/90 rounded-lg text-gray-600 text-xs font-bold hover:bg-white">
                                    Cambiar
                                </button>
                            </div>
                        @else
                            <button type="button" onclick="document.getElementById('tp-doc-front-trigger').click()"
                                    class="w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl py-6 hover:border-primary/40 hover:bg-gray-50 transition-colors">
                                <svg class="w-8 h-8 text-gray-200 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs text-gray-400">Subir cara A</span>
                                <span class="text-[10px] text-gray-300 mt-0.5">Se abrirá el recortador</span>
                            </button>
                            @error('p_doc_front') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @endif
                    </div>

                    {{-- Cara B --}}
                    @if ($p_doc_type !== 'passport')
                    <div>
                        <p class="text-xs font-bold text-gray-600 mb-2">Cara B (reverso)</p>
                        @if ($existing_doc_back && !$clearDocBack && !$p_doc_back)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ Storage::url($existing_doc_back) }}" class="w-full h-32 object-cover" alt="">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <a href="{{ Storage::url($existing_doc_back) }}" target="_blank"
                                       class="p-2 bg-white rounded-lg text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <button type="button" onclick="document.getElementById('tp-doc-back-trigger').click()"
                                            class="p-2 bg-white rounded-lg text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </button>
                                    <button type="button" wire:click="$set('clearDocBack', true)"
                                            class="p-2 bg-white rounded-lg text-red-500 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        @elseif ($p_doc_back)
                            <div class="rounded-xl overflow-hidden border border-gray-200 relative">
                                <img src="{{ $p_doc_back->temporaryUrl() }}" class="w-full h-32 object-cover" alt="">
                                <button type="button" onclick="document.getElementById('tp-doc-back-trigger').click()"
                                        class="absolute top-2 right-2 p-1.5 bg-white/90 rounded-lg text-gray-600 text-xs font-bold hover:bg-white">
                                    Cambiar
                                </button>
                            </div>
                        @else
                            <button type="button" onclick="document.getElementById('tp-doc-back-trigger').click()"
                                    class="w-full flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl py-6 hover:border-primary/40 hover:bg-gray-50 transition-colors">
                                <svg class="w-8 h-8 text-gray-200 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs text-gray-400">Subir cara B</span>
                                <span class="text-[10px] text-gray-300 mt-0.5">Se abrirá el recortador</span>
                            </button>
                            @error('p_doc_back') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            {{-- Documentación adicional --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Documentación adicional</h2>
                <p class="text-xs text-gray-400 mb-4">Ficha médica, ficha federativa u otros documentos.</p>

                @if (!empty($existing_extra_docs))
                    <div class="space-y-2 mb-4">
                        @foreach ($existing_extra_docs as $idx => $doc)
                            <div class="flex items-center gap-3 p-2.5 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-200 shrink-0">
                                    <img src="{{ Storage::url($doc['path']) }}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-700 truncate">{{ $doc['label'] }}</p>
                                </div>
                                <a href="{{ Storage::url($doc['path']) }}" target="_blank"
                                   class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-500 hover:bg-indigo-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <button wire:click="removeExistingDoc({{ $idx }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!empty($staged_extra_docs))
                    <div class="space-y-2 mb-4">
                        @foreach ($staged_extra_docs as $idx => $doc)
                            <div class="flex items-center gap-3 p-2.5 bg-indigo-50 rounded-xl border border-indigo-100">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-indigo-200 shrink-0">
                                    <img src="{{ Storage::url($doc['path']) }}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-indigo-700 truncate">{{ $doc['label'] }}</p>
                                    <p class="text-[10px] text-indigo-400">Pendiente de guardar</p>
                                </div>
                                <button wire:click="removeStagedDoc({{ $idx }})"
                                        class="p-1.5 rounded-lg text-indigo-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="border border-dashed border-gray-200 rounded-xl p-4 space-y-3">
                    <p class="text-xs font-semibold text-gray-500">Añadir documento</p>
                    <input wire:model="new_extra_label" type="text"
                           placeholder="Nombre del documento (p.ej. Ficha médica)"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    @error('new_extra_label') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="document.getElementById('tp-extra-trigger').click()"
                                class="flex-1 flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50 transition-colors text-left">
                            @if ($new_extra_file ?? null)
                                <img src="{{ $new_extra_file->temporaryUrl() }}" class="w-8 h-8 object-cover rounded" alt="">
                                <span class="text-xs text-gray-600 truncate flex-1">{{ $new_extra_file->getClientOriginalName() }}</span>
                            @else
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs text-gray-400">Seleccionar imagen · Se abrirá el recortador</span>
                            @endif
                        </button>
                        <button wire:click="stageExtraDoc" wire:loading.attr="disabled"
                                class="px-4 py-2 text-xs font-bold text-white bg-indigo-500 hover:bg-indigo-600 rounded-lg shadow transition-colors disabled:opacity-60 whitespace-nowrap">
                            <span wire:loading.remove wire:target="stageExtraDoc">+ Añadir</span>
                            <span wire:loading wire:target="stageExtraDoc">...</span>
                        </button>
                    </div>
                    @error('new_extra_file') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Estado y notas --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Estado y notas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Estado</label>
                        <select wire:model="p_status"
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('p_status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-bold text-gray-600 mb-1">Observaciones</label>
                    <textarea wire:model="p_notes" rows="3" placeholder="Notas sobre el jugador..."
                              class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all resize-none"></textarea>
                    @error('p_notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex items-center justify-end gap-3 pb-6">
                <button wire:click="cancel"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-100 transition-colors">
                    Cancelar
                </button>
                <button wire:click="save" wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow transition-opacity hover:opacity-90 disabled:opacity-60 bg-primary">
                    <span wire:loading.remove wire:target="save">{{ $player ? 'Guardar cambios' : 'Añadir jugador' }}</span>
                    <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Guardando...
                    </span>
                </button>
            </div>

        </div>
    </div>

    @once
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
    (function () {
        var tpCropper = null;
        var tpTarget  = null;

        var wireMap = {
            photo:     'tp-photo-wire',
            doc_front: 'tp-doc-front-wire',
            doc_back:  'tp-doc-back-wire',
            extra:     'tp-extra-wire'
        };
        var subtitleMap = {
            photo:     'Recorta la foto carnet del jugador',
            doc_front: 'Recorta la cara frontal del documento',
            doc_back:  'Recorta la cara trasera del documento',
            extra:     'Recorta la imagen del documento adicional'
        };
        var aspectMap = {
            photo:     3/4,
            doc_front: 16/9,
            doc_back:  16/9,
            extra:     NaN
        };

        window.tpOpenCropper = function (event, target) {
            var file = event.target.files[0];
            if (!file) return;
            tpTarget = target;

            var reader = new FileReader();
            reader.onload = function (ev) {
                var overlay  = document.getElementById('tp-cropper-overlay');
                var img      = document.getElementById('tp-crop-img');
                var subtitle = document.getElementById('tp-cropper-subtitle');
                if (!overlay || !img) return;
                img.src = ev.target.result;
                if (subtitle) subtitle.textContent = subtitleMap[target] || 'Ajusta el recuadro';
                overlay.style.display = 'flex';
                if (tpCropper) { tpCropper.destroy(); tpCropper = null; }
                tpCropper = new Cropper(img, {
                    aspectRatio:  aspectMap[target] || NaN,
                    viewMode:     1,
                    dragMode:     'move',
                    autoCropArea: 0.9,
                    guides:       false,
                    center:       true,
                    highlight:    false
                });
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        };

        window.tpApplyCrop = function () {
            if (!tpCropper || !tpTarget) return;
            var w = tpTarget === 'photo' ? 600 : 1200;
            var h = tpTarget === 'photo' ? 800 : 800;
            tpCropper.getCroppedCanvas({ width: w, height: h }).toBlob(function (blob) {
                var input = document.getElementById(wireMap[tpTarget]);
                if (!input) return;
                var file = new File([blob], 'upload.jpg', { type: 'image/jpeg' });
                var dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
                document.getElementById('tp-cropper-overlay').style.display = 'none';
                if (tpCropper) { tpCropper.destroy(); tpCropper = null; }
                tpTarget = null;
            }, 'image/jpeg', 0.92);
        };

        window.tpCancelCrop = function () {
            document.getElementById('tp-cropper-overlay').style.display = 'none';
            if (tpCropper) { tpCropper.destroy(); tpCropper = null; }
            tpTarget = null;
        };
    })();
    </script>
    @endonce
</div>
