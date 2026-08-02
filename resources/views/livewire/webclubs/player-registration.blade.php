<div>
<style>
    .reg-outer {
        background: linear-gradient(160deg, var(--color-primary) 0%, var(--color-secondary) 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .reg-sheet {
        background: #fff;
        flex: 1;
        overflow-y: auto;
        padding-bottom: 2rem;
    }
    @media (min-width: 640px) {
        .reg-outer { padding: 2rem; align-items: center; justify-content: flex-start; }
        .reg-sheet { flex: none; width: 600px; border-radius: 1.5rem; box-shadow: 0 20px 60px rgba(0,0,0,0.15); padding-bottom: 2.5rem; }
    }
</style>

<div class="reg-outer">
@if($openInscriptionSeasons->count() >= 2)
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-start gap-3">
        <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <div>
            <p class="text-sm font-bold text-red-800">Advertencia: No se pueden realizar inscripciones,</p>
            <p class="text-sm text-red-700 mt-1">Contacte con el {{$school->name}} al teléfono {{$school->phone}} o al correo electrónico {{$school->email}} para comunicar la incidencia. Existen
                {{ $openInscriptionSeasons->count() }} temporadas que mantienen inscripciones abiertas. Solo puede haber una temporada con inscripciones abiertas a la vez.</p>
        </div>
    </div>
@elseif($openInscriptionSeasons->count() === 1)
    {{-- ── White sheet ─────────────────────────────────────────────── --}}
    <div class="reg-sheet sm:mx-auto">

        {{-- ── Header inside card ───────────────────────────────────── --}}
        <div class="px-5 pt-5 pb-4 flex items-center gap-3 border-b border-gray-100">
            {{-- @if($fromDashboard)
                <a href="{{ route('webclubs.team.dashboard', $tournament) }}"
                   class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Volver
                </a>
            @else
                <div class="w-8"></div>
            @endif --}}
            <div class="flex-1 flex items-center justify-center gap-2.5">
                {{-- @if($team->logo)
                    <img src="{{ Storage::url($team->logo) }}" alt="{{ $team->displayName() }}"
                         class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
                @endif --}}
                <div>
                    {{-- <p class="font-black text-sm leading-tight text-gray-900">{{ $team->displayName() }}</p>
                    <p class="text-xs text-gray-400">{{ $tournament->name }}</p> --}}
                </div>
            </div>
            <div class="w-8"></div>
        </div>

        {{-- Progress bar --}}
        {{-- @if(!$done)
        <div class="px-6 pt-5 pb-4 border-b border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Inscripción de jugador</p>
                <p class="text-xs font-bold" style="color: var(--color-primary)">Paso {{ $step }} de {{ $totalSteps - 1 }}</p>
            </div>
            <div class="flex gap-1.5">
                @for($s = 1; $s <= $totalSteps - 1; $s++)
                    <div class="h-1.5 flex-1 rounded-full transition-all duration-300 {{ $s <= $step ? '' : 'bg-gray-100' }}"
                         style="{{ $s <= $step ? 'background: linear-gradient(90deg, var(--color-primary), var(--color-secondary))' : '' }}">
                    </div>
                @endfor
            </div>
            <div class="flex justify-between mt-2">
                <span class="text-[10px] font-bold {{ $step >= 1 ? 'text-gray-700' : 'text-gray-300' }}">Datos</span>
                <span class="text-[10px] font-bold {{ $step >= 2 ? 'text-gray-700' : 'text-gray-300' }}">Documento</span>
                <span class="text-[10px] font-bold {{ $step >= 3 ? 'text-gray-700' : 'text-gray-300' }}">Deportivo</span>
            </div>
        </div>
        @endif --}}

        <div class="px-6">

            {{-- ═══════════════════════════════════════════ STEP 1 ═══ --}}
            @if($step === 1 && !$done)
            <div class="pt-6 space-y-4">
                <div>
                    <h2 class="text-lg font-black text-gray-900">Datos personales del jugador</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Introduce tus datos de identificación</p>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre *</label>
                    <input wire:model="name" type="text" placeholder="Nombre"
                           class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Surname --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Apellidos *</label>
                    <input wire:model="surname" type="text" placeholder="Apellidos"
                           class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    @error('surname') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Birthdate --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Fecha de nacimiento</label>
                    <input wire:model="birthdate" type="hidden" id="pr-birthdate-livewire"/>
                    <div class="relative">
                        <input type="text" id="pr-birthdate-text" placeholder="dd/mm/aaaa" maxlength="10"
                               oninput="prFormatBirthdate(this)"
                               class="w-full pl-3 pr-10 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        <input type="date" id="pr-birthdate-picker" tabindex="-1"
                               style="position:absolute;opacity:0;width:0;height:0;top:0;right:0;"
                               onchange="prSyncBirthdatePicker(this)"/>
                        <button type="button" onclick="document.getElementById('pr-birthdate-picker').showPicker()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round"/>
                                <line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </button>
                    </div>
                    @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Teléfono</label>
                    <input wire:model="phone" type="tel" placeholder="6XX XXX XXX"
                           class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                    <input wire:model="email" type="email" placeholder="correo@ejemplo.com"
                           class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button wire:click="nextStep" wire:loading.attr="disabled"
                        class="w-full py-4 rounded-2xl text-white text-base font-black shadow-lg hover:opacity-90 active:scale-[0.98] transition-all mt-2"
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    <span wire:loading.remove wire:target="nextStep">Siguiente →</span>
                    <span wire:loading wire:target="nextStep">Verificando...</span>
                </button>
            </div>
            @endif

            {{-- ═══════════════════════════════════════════ STEP 2 ═══ --}}
            @if($step === 2 && !$done)
            {{-- Reactive ref for JS to know the current docType --}}
            <span id="pr-doctype-ref" class="hidden" data-doctype="{{ $docType }}"></span>
            <div class="pt-6 space-y-4">
                <div>
                    <h2 class="text-lg font-black text-gray-900">Documento de identidad</h2>
                    <p class="text-sm text-gray-400 mt-0.5">DNI, NIE o Pasaporte</p>
                </div>

                {{-- Doc type --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipo de documento *</label>
                    <div class="flex gap-2">
                        @foreach($docTypes as $key => $label)
                            <button type="button" wire:click="$set('docType', '{{ $key }}')"
                                    class="flex-1 py-3 rounded-xl text-sm font-bold border transition-all {{ $docType === $key ? 'text-white border-transparent' : 'text-gray-500 border-gray-200 bg-white hover:border-gray-300' }}"
                                    style="{{ $docType === $key ? 'background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))' : '' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    @error('docType') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Doc number --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Número de {{ $docTypes[$docType] ?? 'documento' }} *
                    </label>
                    <input wire:model="docNumber" type="text"
                           placeholder="{{ $docType === 'passport' ? 'ABC123456' : ($docType === 'nie' ? 'X1234567Z' : '12345678A') }}"
                           oninput="this.value=this.value.replace(/\s/g,'').toUpperCase()"
                           class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                           style="text-transform:uppercase"/>
                    @error('docNumber') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Doc front --}}
                <div wire:key="doc-front-block">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Foto {{ $docType === 'passport' ? 'página principal' : 'anverso' }}
                        <span class="text-red-400">*</span>
                    </label>
                    <div wire:ignore>
                        <div id="doc-front-preview-container" class="hidden mb-2 relative">
                            <img id="doc-front-preview-img" class="w-full max-h-40 object-cover rounded-xl border border-gray-200" alt="Anverso">
                            <button type="button" onclick="clearDocImage('front', 'docFront')"
                                    class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/50 text-white flex items-center justify-center text-xs hover:bg-black/70 transition-colors">✕</button>
                        </div>
                        <div id="doc-front-buttons">
                            <button type="button" onclick="document.getElementById('doc-front-gallery').click()"
                                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Subir foto del documento
                            </button>
                        </div>
                        <input type="file" id="doc-front-gallery" accept="image/*,application/pdf" class="hidden" onchange="handleDocSelect(this, 'front', 'docFront')"/>
                    </div>
                    @error('docFront') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Doc back (only for dni/nie) --}}
                @if($docType !== 'passport')
                <div wire:key="doc-back-block">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Foto reverso
                        <span class="text-red-400">*</span>
                    </label>
                    <div wire:ignore>
                        <div id="doc-back-preview-container" class="hidden mb-2 relative">
                            <img id="doc-back-preview-img" class="w-full max-h-40 object-cover rounded-xl border border-gray-200" alt="Reverso">
                            <button type="button" onclick="clearDocImage('back', 'docBack')"
                                    class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/50 text-white flex items-center justify-center text-xs hover:bg-black/70 transition-colors">✕</button>
                        </div>
                        <div id="doc-back-buttons">
                            <button type="button" onclick="document.getElementById('doc-back-gallery').click()"
                                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Subir foto del documento
                            </button>
                        </div>
                        <input type="file" id="doc-back-gallery" accept="image/*,application/pdf" class="hidden" onchange="handleDocSelect(this, 'back', 'docBack')"/>
                    </div>
                    @error('docBack') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                @endif

                {{-- Navigation --}}
                <div class="flex gap-3 pt-2">
                    <button wire:click="prevStep" type="button"
                            class="flex-1 py-4 rounded-2xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                        ← Anterior
                    </button>
                    <button wire:click="nextStep" wire:loading.attr="disabled" type="button"
                            class="flex-[2] py-4 rounded-2xl text-white text-base font-black shadow-lg hover:opacity-90 active:scale-[0.98] transition-all"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <span wire:loading.remove wire:target="nextStep">Siguiente →</span>
                        <span wire:loading wire:target="nextStep">Verificando...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ═══════════════════════════════════════════ STEP 3 ═══ --}}
            @if($step === 3 && !$done)
            <div class="pt-6 space-y-4">
                <div>
                    <h2 class="text-lg font-black text-gray-900">Datos deportivos</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Posición, foto y documentación adicional</p>
                </div>

                {{-- Profile photo --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Foto selfi
                        <span class="text-red-400">*</span>
                    </label>
                    <div wire:ignore>
                        <div id="profile-photo-preview-container" class="hidden mb-2 relative">
                            <img id="profile-photo-preview-img" class="w-24 h-24 object-cover rounded-2xl border border-gray-200 mx-auto" alt="Foto">
                            <button type="button" onclick="clearProfilePhoto()"
                                    class="absolute top-0 right-0 w-6 h-6 rounded-full bg-black/50 text-white flex items-center justify-center text-xs hover:bg-black/70 transition-colors" style="margin-top:-8px;margin-right:-8px;position:absolute;top:calc(50% - 48px + 0px);right:calc(50% - 48px + 0px)">✕</button>
                        </div>
                        <div id="profile-photo-buttons">
                            <button type="button" onclick="document.getElementById('profile-photo-gallery').click()"
                                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                Hacerme una selfie
                            </button>
                        </div>
                        <input type="file" id="profile-photo-gallery" accept="image/*" capture="user" class="hidden" onchange="handleProfilePhotoSelect(this)"/>
                    </div>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Position --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Posición</label>
                    <select wire:model="position"
                            class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all appearance-none">
                        <option value="">Selecciona posición</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos }}">{{ $pos }}</option>
                        @endforeach
                    </select>
                    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Dorsal --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dorsal preferido</label>
                    <input wire:model="dorsal" type="number" min="1" max="99" placeholder="1-99"
                           class="w-full px-3 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    @error('dorsal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Federated --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <div class="relative flex-shrink-0">
                            <input wire:model="federado" type="checkbox" id="federado-check" class="sr-only peer"/>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-amber-400 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Estoy federado en otro equipo</p>
                            <p class="text-xs text-gray-500 mt-0.5">Activa si estás inscrito en otro club de forma federada</p>
                        </div>
                    </label>
                    @if($federado)
                    <div class="mt-3">
                        <input wire:model="fedTeam" type="text" placeholder="Nombre del equipo federado"
                               class="w-full px-3 py-3 text-sm border border-amber-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-amber-300 transition-all"/>
                    </div>
                    @endif
                </div>

                {{-- Extra document --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Documento adicional
                        <span class="text-gray-300 font-normal normal-case">(licencia, autorización, etc. – opcional)</span>
                    </label>
                    <div id="extra-doc-preview-container" class="hidden mb-2 flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-xl">
                        <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p id="extra-doc-name" class="text-sm font-bold text-gray-700 flex-1 truncate"></p>
                        <button type="button" onclick="clearExtraDoc()"
                                class="text-gray-400 hover:text-red-500 transition-colors text-xs font-bold">✕</button>
                    </div>
                    <div id="extra-doc-buttons">
                        <label onclick="document.getElementById('extra-doc-input').click()" class="flex items-center justify-center gap-2 py-3 rounded-xl border-2 border-dashed border-gray-200 text-sm font-bold text-gray-500 hover:border-gray-300 hover:bg-gray-50 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Adjuntar documento (PDF o imagen)
                        </label>
                        <input type="file" id="extra-doc-input" accept="image/*,application/pdf" class="hidden" onchange="handleExtraDocSelect(this)"/>
                    </div>
                    @error('extraDoc') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Navigation --}}
                <div class="flex gap-3 pt-2">
                    <button wire:click="prevStep" type="button"
                            class="flex-1 py-4 rounded-2xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                        ← Anterior
                    </button>
                    <button wire:click="nextStep" wire:loading.attr="disabled" type="button"
                            class="flex-[2] py-4 rounded-2xl text-white text-base font-black shadow-lg hover:opacity-90 active:scale-[0.98] transition-all"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <span wire:loading.remove wire:target="nextStep">Siguiente →</span>
                        <span wire:loading wire:target="nextStep">Verificando...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ═══════════════════════════════════════════ STEP 4 ════ --}}
            @if($step === 4 && !$done)
            <div class="space-y-5" wire:key="step-4-signature">
                <div>
                    <h2 class="text-xl font-black text-gray-900 mb-1">Firma de inscripción</h2>
                    <p class="text-sm text-gray-500">Lee el siguiente texto y firma en el recuadro para confirmar tu inscripción.</p>
                </div>

                {{-- Declaración de responsabilidad --}}
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-xs text-gray-600 leading-relaxed space-y-2">
                    <p class="font-bold text-gray-700 text-sm">Declaración de participación y responsabilidad</p>
                    <p>Declaro que participo en <span class="font-semibold text-gray-800">{{ $tournament->name }}</span> de forma voluntaria, bajo mi propia responsabilidad y conociendo los riesgos inherentes a la práctica deportiva. Manifiesto encontrarme en condiciones físicas adecuadas para participar.</p>
                    <p>Eximo al <span class="font-semibold text-gray-800">{{ $schoolName }}</span>, organización, colaboradores y responsables del torneo de cualquier responsabilidad derivada de lesiones, accidentes, daños personales o materiales que pudieran producirse durante mi participación.</p>
                    <p>Asimismo, me comprometo a respetar las normas del torneo y mantener una conducta adecuada, asumiendo personalmente la responsabilidad de cualquier altercado o actuación contraria a las normas.</p>
                    <p>Del mismo modo, autorizo al <span class="font-semibold text-gray-800">{{ $schoolName }}</span> a la captación y uso de imágenes, fotografías o vídeos en los que pueda aparecer durante el desarrollo del torneo, con fines informativos, deportivos o de difusión en medios oficiales del club y redes sociales.</p>
                </div>

                <div wire:ignore>
                    <div class="relative rounded-2xl border-2 border-dashed border-gray-300 bg-white overflow-hidden" style="touch-action:none">
                        <canvas id="pr-signature-canvas" class="block w-full" style="height:220px;touch-action:none;cursor:crosshair"></canvas>
                        <p id="pr-signature-hint" class="absolute inset-0 flex items-center justify-center text-gray-300 text-sm font-bold pointer-events-none select-none">✍ Firma aquí</p>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <button type="button" onclick="clearSignaturePad()"
                                class="text-xs font-bold text-gray-500 hover:text-gray-700 underline">
                            Borrar firma
                        </button>
                        <p class="text-xs text-gray-400">Al firmar confirmas que los datos son correctos.</p>
                    </div>
                </div>
                @error('signature') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                {{-- Navigation --}}
                <div class="flex gap-3 pt-2">
                    <button wire:click="prevStep" type="button"
                            class="flex-1 py-4 rounded-2xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                        ← Anterior
                    </button>
                    <button onclick="commitSignatureAndSubmit()" wire:loading.attr="disabled" wire:target="submit" type="button"
                            class="flex-[2] py-4 rounded-2xl text-white text-base font-black shadow-lg hover:opacity-90 active:scale-[0.98] transition-all"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <span wire:loading.remove wire:target="submit">✓ Confirmar inscripción</span>
                        <span wire:loading wire:target="submit">Enviando...</span>
                    </button>
                </div>
            </div>
            @endif

            {{-- ═══════════════════════════════════════════ DONE ══════ --}}
            @if($done)
            <div class="pt-10 pb-8 text-center flex flex-col items-center gap-4">
                <div class="w-20 h-20 rounded-full flex items-center justify-center shadow-lg"
                     style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900">¡Listo!</h2>
                <p class="text-gray-500 text-sm max-w-xs mx-auto leading-relaxed">{{ $doneMessage }}</p>

                @if($fromDashboard)
                    <div class="flex flex-col gap-3 w-full mt-4">
                        <a href="{{ route('webclubs.player.register', [$tournament, $team->registration_token]) }}"
                           class="w-full py-3.5 rounded-2xl border-2 text-sm font-bold text-center transition-colors hover:bg-gray-50"
                           style="border-color: var(--color-primary); color: var(--color-primary)">
                            + Inscribir otro jugador
                        </a>
                        <a href="{{ route('webclubs.team.dashboard', $tournament) }}"
                           class="w-full py-3.5 rounded-2xl text-white text-sm font-bold shadow text-center transition-opacity hover:opacity-90"
                           style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            Volver al panel del equipo
                        </a>
                    </div>
                @else
                    <div class="flex flex-col gap-3 w-full mt-4">
                        <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
                           class="w-full py-3.5 rounded-2xl text-white text-sm font-bold shadow text-center transition-opacity hover:opacity-90"
                           style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            Ver el torneo
                        </a>
                    </div>
                    <p class="text-xs text-gray-400">O puedes cerrar esta ventana.</p>
                @endif
            </div>
            @endif

        </div>{{-- /px-6 --}}
    </div>{{-- /reg-sheet --}}
@else
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-start gap-3">
        <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <div>
            <p class="text-sm font-bold text-red-800">Advertencia: No se pueden realizar inscripciones,</p>
            <p class="text-sm text-red-700 mt-1">No existe temporada abierta. Consulte con {{$school->name}} al teléfono {{$school->phone}} o al correo electrónico {{$school->email}} para más información.</p>
        </div>
    </div>
@endif
</div>{{-- /reg-outer --}}

{{-- ─── Document photo cropper overlay ────────────────────────────── --}}
<div id="pr-doc-cropper-overlay" class="fixed inset-0 z-[200] bg-black/90 flex items-center justify-center p-4" style="display:none" wire:ignore>
    <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-gray-100">
            <p class="text-sm font-black text-gray-900" id="pr-doc-crop-title">Encuadra el documento</p>
            <p class="text-xs text-gray-400 mt-0.5">Ajusta el recuadro a los bordes del documento</p>
        </div>
        <div class="bg-gray-900" style="max-height:320px;overflow:hidden">
            <img id="pr-doc-crop-img" class="max-w-full block" alt="Documento">
        </div>
        <div class="flex gap-2 p-4">
            <button type="button" onclick="cancelDocCrop()"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">Cancelar</button>
            <button type="button" onclick="applyDocCrop()"
                    class="flex-1 py-2.5 rounded-xl text-white text-sm font-bold transition-opacity hover:opacity-90"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">✓ Usar recorte</button>
        </div>
    </div>
</div>

{{-- ─── Profile photo cropper overlay ─────────────────────────────── --}}
<div id="pr-photo-cropper-overlay" class="fixed inset-0 z-[200] bg-black/85 flex items-center justify-center p-4" style="display:none" wire:ignore>
    <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-gray-100">
            <p class="text-sm font-black text-gray-900">Recortar foto de perfil</p>
        </div>
        <div class="p-4 bg-gray-900" style="max-height:300px;overflow:hidden">
            <img id="pr-crop-img" class="max-w-full block" alt="Recortar">
        </div>
        <div class="flex gap-2 p-4">
            <button type="button" onclick="cancelProfilePhotoCrop()"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">Cancelar</button>
            <button type="button" onclick="applyProfilePhotoCrop()"
                    class="flex-1 py-2.5 rounded-xl text-white text-sm font-bold transition-opacity hover:opacity-90"
                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">✓ Usar</button>
        </div>
    </div>
</div>

<script>
(function () {
    // ── Helper: find Livewire component ───────────────────────────
    function getLivewireComponent() {
        var el = document.querySelector('[wire\\:id]');
        return el ? Livewire.find(el.getAttribute('wire:id')) : null;
    }

    // ── Helper: upload file via Livewire JS API ────────────────────
    // property: Livewire property name e.g. 'docFront'
    // file: File object
    // onProgress: optional callback(percent)
    // onDone: optional callback
    function livewireUpload(property, file, onProgress, onDone) {
        var component = getLivewireComponent();
        if (!component) return;
        component.upload(property, file,
            function () { if (onDone) onDone(); },   // finish
            function () {},                           // upload error (silent)
            function (event) { if (onProgress) onProgress(event.detail.progress); }
        );
    }

    // ── Birthdate ──────────────────────────────────────────────────
    window.prFormatBirthdate = function (input) {
        var raw = input.value.replace(/\D/g, '');
        var f = raw;
        if (raw.length > 2) f = raw.slice(0,2) + '/' + raw.slice(2);
        if (raw.length > 4) f = raw.slice(0,2) + '/' + raw.slice(2,4) + '/' + raw.slice(4,8);
        input.value = f;
        if (raw.length === 8) {
            var iso = raw.slice(4,8) + '-' + raw.slice(2,4) + '-' + raw.slice(0,2);
            document.getElementById('pr-birthdate-picker').value = iso;
            prPushBirthdate(iso);
        } else { prPushBirthdate(''); }
    };
    window.prSyncBirthdatePicker = function (picker) {
        var iso = picker.value;
        var txt = document.getElementById('pr-birthdate-text');
        if (iso && txt) { var p = iso.split('-'); txt.value = p[2]+'/'+p[1]+'/'+p[0]; }
        prPushBirthdate(iso);
    };
    window.prPushBirthdate = function (iso) {
        var h = document.getElementById('pr-birthdate-livewire');
        if (!h) return;
        Object.getOwnPropertyDescriptor(HTMLInputElement.prototype,'value').set.call(h, iso);
        h.dispatchEvent(new Event('input', { bubbles: true }));
    };

    // ── Pre-resize helper ─────────────────────────────────────────
    // Loads a File via URL.createObjectURL (low memory) and resizes it to a
    // manageable size before passing to Cropper.js. Always returns a Blob URL
    // (never a giant base64 dataURL) so memory usage stays low on mobile.
    // The previous (origin) URL is revoked once a new one is produced.
    function resizeFileForCrop(file, maxPx, callback) {
        var url = URL.createObjectURL(file);
        var img = new Image();
        img.onload = function () {
            var w = img.naturalWidth, h = img.naturalHeight;
            try {
                if (w <= maxPx && h <= maxPx) {
                    // Already small enough — use the object URL directly
                    callback(url);
                    return;
                }
                var scale = maxPx / Math.max(w, h);
                var cw = Math.round(w * scale), ch = Math.round(h * scale);
                var canvas = document.createElement('canvas');
                canvas.width = cw; canvas.height = ch;
                canvas.getContext('2d').drawImage(img, 0, 0, cw, ch);
                canvas.toBlob(function (blob) {
                    URL.revokeObjectURL(url);
                    if (!blob) {
                        // Fallback: original file as blob URL
                        callback(URL.createObjectURL(file));
                        return;
                    }
                    callback(URL.createObjectURL(blob));
                }, 'image/jpeg', 0.90);
            } catch (e) {
                // If resizing fails (memory etc.), fall back to original
                callback(url);
            }
        };
        img.onerror = function () {
            URL.revokeObjectURL(url);
            alert('No se ha podido leer la imagen. Prueba con otra foto.');
        };
        img.src = url;
    }

    // Open the document cropper with a given Blob URL. Waits for the image
    // to decode (otherwise Cropper.js might race with display:none -> flex).
    function openDocCropper(resizedUrl, side) {
        var overlay = document.getElementById('pr-doc-cropper-overlay');
        var img = document.getElementById('pr-doc-crop-img');
        if (!overlay || !img) return;

        // Show the overlay FIRST so the image has real dimensions when Cropper measures it
        overlay.style.display = 'flex';

        // Aspect ratio: DNI/NIE = ID-1 card (85.6 × 54 mm = 1.586:1), Passport ≈ 1.414:1
        var docTypeEl = document.getElementById('pr-doctype-ref');
        var docType = docTypeEl ? docTypeEl.dataset.doctype : 'dni';
        var aspectRatio = docType === 'passport' ? 1.414 : 1.586;

        var title = document.getElementById('pr-doc-crop-title');
        if (title) {
            var docLabel = docType === 'passport' ? 'Pasaporte' : (docType === 'nie' ? 'NIE' : 'DNI');
            var sideLabel = side === 'front' ? (docType === 'passport' ? '— página principal' : '— anverso') : '— reverso';
            title.textContent = 'Encuadra el ' + docLabel + ' ' + sideLabel;
        }

        if (prDocCropper) { prDocCropper.destroy(); prDocCropper = null; }

        // Wait until the image is actually decoded before instantiating Cropper
        var ready = false;
        function init() {
            if (ready) return; ready = true;
            try {
                prDocCropper = new Cropper(img, {
                    aspectRatio: aspectRatio,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.92,
                    guides: true,
                    background: true
                });
            } catch (e) {
                alert('No se ha podido abrir el editor de imagen. Prueba a subir la foto desde la galería.');
                overlay.style.display = 'none';
            }
        }
        img.onload = init;
        img.onerror = function () {
            overlay.style.display = 'none';
            alert('No se ha podido cargar la foto. Inténtalo de nuevo.');
        };
        img.src = resizedUrl;
        // If the image was already cached/decoded, onload may not fire — fallback
        if (img.complete && img.naturalWidth > 0) { setTimeout(init, 30); }
        // Safety timeout: if for any reason onload never fires, init after 1.5s
        setTimeout(init, 1500);
    }

    // ── Doc image helpers ─────────────────────────────────────────
    var prDocCropper = null;
    var prDocCropSide = null;
    var prDocCropProperty = null;

    window.triggerDocCapture = function (side, mode) {
        document.getElementById('doc-' + side + '-' + mode).click();
    };

    window.handleDocSelect = function (input, side, property) {
        var file = input.files[0];
        if (!file) return;
        input.value = '';

        // PDFs: skip cropper, upload directly
        if (file.type === 'application/pdf') {
            var btns = document.getElementById('doc-' + side + '-buttons');
            if (btns) btns.innerHTML = '<p class="text-xs text-gray-400 py-3 text-center">Subiendo...</p>';
            livewireUpload(property, file, null, function () { showDocPreview(side, file); });
            return;
        }

        // Images: open document cropper
        prDocCropSide = side;
        prDocCropProperty = property;
        // Pre-resize via createObjectURL (low memory) before Cropper.js loads it
        resizeFileForCrop(file, 1600, function (resizedUrl) {
            openDocCropper(resizedUrl, side);
        });
    };

    window.applyDocCrop = function () {
        if (!prDocCropper) return;
        var overlay = document.getElementById('pr-doc-cropper-overlay');
        if (overlay) overlay.style.display = 'none';
        var side = prDocCropSide;
        var property = prDocCropProperty;
        var buttons = document.getElementById('doc-' + side + '-buttons');
        if (buttons) buttons.innerHTML = '<p class="text-xs text-gray-400 py-3 text-center">Subiendo...</p>';

        // Guard: getCroppedCanvas can return null on some mobile browsers if
        // the image hasn't fully loaded yet.
        var canvas = null;
        try { canvas = prDocCropper.getCroppedCanvas({ maxWidth: 1200, maxHeight: 900 }); } catch(e) {}
        if (!canvas) {
            // Cropper not ready — reset buttons and let user try again
            if (buttons) buttons.innerHTML = '';
            clearDocImage(side, property);
            return;
        }

        canvas.toBlob(function (blob) {
            if (prDocCropper) { prDocCropper.destroy(); prDocCropper = null; }
            // Guard: toBlob can return null on low-memory devices
            if (!blob) {
                if (buttons) buttons.innerHTML = '';
                clearDocImage(side, property);
                return;
            }
            var file = new File([blob], 'doc-' + side + '.jpg', { type: 'image/jpeg' });
            livewireUpload(property, file, null, function () { showDocPreview(side, file); });
        }, 'image/jpeg', 0.85);
    };

    window.cancelDocCrop = function () {
        var overlay = document.getElementById('pr-doc-cropper-overlay');
        if (overlay) overlay.style.display = 'none';
        if (prDocCropper) { prDocCropper.destroy(); prDocCropper = null; }
        prDocCropSide = null;
        prDocCropProperty = null;
    };

    function showDocPreview(side, file) {
        var c = document.getElementById('doc-' + side + '-preview-container');
        var i = document.getElementById('doc-' + side + '-preview-img');
        var b = document.getElementById('doc-' + side + '-buttons');
        if (!c) return;
        if (file.type === 'application/pdf') {
            if (i) { i.src = ''; i.alt = file.name; }
            c.classList.remove('hidden');
        } else {
            var reader = new FileReader();
            reader.onload = function (ev) {
                if (i) i.src = ev.target.result;
                c.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
        if (b) b.style.display = 'none';
    }

    window.clearDocImage = function (side, property) {
        var c = document.getElementById('doc-' + side + '-preview-container');
        var b = document.getElementById('doc-' + side + '-buttons');
        if (c) c.classList.add('hidden');
        if (b) { b.style.display = ''; }
        // Re-render buttons if they were replaced with "Subiendo..."
        if (b && b.innerHTML.indexOf('Subiendo') !== -1) {
            b.innerHTML = '<button type="button" onclick="triggerDocCapture(\'' + side + '\',\'gallery\')" class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>Galería</button><button type="button" onclick="triggerDocCapture(\'' + side + '\',\'camera\')" class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>Cámara</button>';
        }
        var component = getLivewireComponent();
        if (component) component.set(property, null);
    };

    // ── Profile photo crop ─────────────────────────────────────────
    var prCropper = null;
    window.handleProfilePhotoSelect = function (input) {
        var file = input.files[0];
        if (!file) return;
        input.value = '';
        resizeFileForCrop(file, 1200, function (resizedUrl) {
            var overlay = document.getElementById('pr-photo-cropper-overlay');
            var img = document.getElementById('pr-crop-img');
            if (!overlay || !img) return;
            overlay.style.display = 'flex';
            if (prCropper) { prCropper.destroy(); prCropper = null; }
            var ready = false;
            function init() {
                if (ready) return; ready = true;
                try {
                    prCropper = new Cropper(img, { aspectRatio: 1, viewMode: 1, dragMode: 'move', autoCropArea: 0.85, guides: false });
                } catch (e) {
                    overlay.style.display = 'none';
                    alert('No se ha podido abrir el editor de imagen.');
                }
            }
            img.onload = init;
            img.onerror = function () { overlay.style.display = 'none'; alert('No se ha podido cargar la foto.'); };
            img.src = resizedUrl;
            if (img.complete && img.naturalWidth > 0) { setTimeout(init, 30); }
            setTimeout(init, 1500);
        });
    };
    window.applyProfilePhotoCrop = function () {
        if (!prCropper) return;
        var overlay = document.getElementById('pr-photo-cropper-overlay');
        if (overlay) overlay.style.display = 'none';

        var canvas = null;
        try { canvas = prCropper.getCroppedCanvas({ width: 400, height: 400 }); } catch(e) {}
        if (!canvas) {
            if (prCropper) { prCropper.destroy(); prCropper = null; }
            return;
        }

        canvas.toBlob(function (blob) {
            if (prCropper) { prCropper.destroy(); prCropper = null; }
            if (!blob) return;

            var file = new File([blob], 'foto-perfil.jpg', { type: 'image/jpeg' });

            var pb = document.getElementById('profile-photo-buttons');
            if (pb) pb.innerHTML = '<p class="text-xs text-gray-400 py-3 text-center">Subiendo foto...</p>';

            livewireUpload('photo', file, null, function () {
                var pc = document.getElementById('profile-photo-preview-container');
                var pi = document.getElementById('profile-photo-preview-img');
                if (pc && pi) { pi.src = URL.createObjectURL(blob); pc.classList.remove('hidden'); }
                if (pb) pb.style.display = 'none';
            });
        }, 'image/jpeg', 0.85);
    };
    window.cancelProfilePhotoCrop = function () {
        var overlay = document.getElementById('pr-photo-cropper-overlay');
        if (overlay) overlay.style.display = 'none';
        if (prCropper) { prCropper.destroy(); prCropper = null; }
    };
    window.clearProfilePhoto = function () {
        var pc = document.getElementById('profile-photo-preview-container');
        var pb = document.getElementById('profile-photo-buttons');
        if (pc) pc.classList.add('hidden');
        if (pb) pb.style.display = '';
        var component = getLivewireComponent();
        if (component) component.set('photo', null);
    };

    // ── Extra document ─────────────────────────────────────────────
    window.handleExtraDocSelect = function (input) {
        var file = input.files[0];
        if (!file) return;
        input.value = '';
        var btns = document.getElementById('extra-doc-buttons');
        if (btns) btns.innerHTML = '<p class="text-xs text-gray-400 py-3 text-center">Subiendo...</p>';

        livewireUpload('extraDoc', file, null, function () {
            var preview = document.getElementById('extra-doc-preview-container');
            var name = document.getElementById('extra-doc-name');
            if (preview) preview.classList.remove('hidden');
            if (name) name.textContent = file.name;
            if (btns) btns.style.display = 'none';
        });
    };
    window.clearExtraDoc = function () {
        var preview = document.getElementById('extra-doc-preview-container');
        var btns = document.getElementById('extra-doc-buttons');
        if (preview) preview.classList.add('hidden');
        if (btns) { btns.style.display = ''; btns.innerHTML = '<label onclick="document.getElementById(\'extra-doc-input\').click()" class="flex items-center justify-center gap-2 py-3 rounded-xl border-2 border-dashed border-gray-200 text-sm font-bold text-gray-500 hover:border-gray-300 hover:bg-gray-50 transition-all cursor-pointer"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>Adjuntar documento (PDF o imagen)</label><input type="file" id="extra-doc-input" accept="image/*,application/pdf" class="hidden" onchange="handleExtraDocSelect(this)"/>'; }
        var component = getLivewireComponent();
        if (component) component.set('extraDoc', null);
    };

    // ── Step persistence across tab kills (Android camera intent) ───────────
    // When the user opens the camera from a file input, Android/Chrome may
    // kill the tab to free memory. On restore, Livewire re-mounts at step 1.
    // We persist the step in sessionStorage so we can restore it.
    var STEP_KEY = 'pr_step_' + window.location.pathname;
    var lastSavedStep = 0;

    function syncStepFromComponent() {
        var c = getLivewireComponent();
        if (!c) return;
        try {
            var s = parseInt(c.get('step') || 1, 10);
            var done = c.get('done');
            if (done) { sessionStorage.removeItem(STEP_KEY); lastSavedStep = 0; return; }
            if (s !== lastSavedStep) {
                lastSavedStep = s;
                if (s > 1) sessionStorage.setItem(STEP_KEY, String(s));
                else sessionStorage.removeItem(STEP_KEY);
            }
        } catch(e) {}
    }

    function restoreStepIfNeeded() {
        var saved = parseInt(sessionStorage.getItem(STEP_KEY) || '0', 10);
        if (!saved || saved < 2) return;
        var c = getLivewireComponent();
        if (!c) return;
        try {
            var current = parseInt(c.get('step') || 1, 10);
            var done = c.get('done');
            if (done) { sessionStorage.removeItem(STEP_KEY); return; }
            if (current === 1 && saved > 1) {
                c.call('setStep', saved);
            }
        } catch(e) {}
    }

    // Wait for Livewire to be ready, then restore + start polling
    function bootStepPersistence() {
        // Try restore immediately
        restoreStepIfNeeded();
        // Poll every 500 ms — covers all Livewire updates without depending on
        // version-specific hook APIs.
        setInterval(syncStepFromComponent, 500);
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(bootStepPersistence, 300);
    } else {
        document.addEventListener('DOMContentLoaded', function () { setTimeout(bootStepPersistence, 300); });
    }

    // Also restore when tab regains visibility (back from camera)
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
            // Slight delay so Livewire has time to settle after tab restore
            setTimeout(restoreStepIfNeeded, 200);
        }
    });

    // ── Signature pad ──────────────────────────────────────────────
    var sigCtx = null, sigCanvas = null, sigDrawing = false, sigEmpty = true, sigLast = null;

    function initSignaturePad() {
        sigCanvas = document.getElementById('pr-signature-canvas');
        if (!sigCanvas || sigCanvas.dataset.ready === '1') return;
        sigCanvas.dataset.ready = '1';

        // Resize canvas to its CSS size with proper DPR
        function resize() {
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            var rect = sigCanvas.getBoundingClientRect();
            sigCanvas.width = Math.round(rect.width * ratio);
            sigCanvas.height = Math.round(rect.height * ratio);
            sigCtx = sigCanvas.getContext('2d');
            sigCtx.scale(ratio, ratio);
            sigCtx.lineCap = 'round';
            sigCtx.lineJoin = 'round';
            sigCtx.strokeStyle = '#0f172a';
            sigCtx.lineWidth = 2.2;
        }
        resize();
        window.addEventListener('resize', function () {
            // Clearing on resize keeps it simple; user can re-sign
            resize();
            clearSignaturePad();
        });

        function pos(e) {
            var rect = sigCanvas.getBoundingClientRect();
            var x, y;
            if (e.touches && e.touches.length) {
                x = e.touches[0].clientX - rect.left;
                y = e.touches[0].clientY - rect.top;
            } else {
                x = e.clientX - rect.left;
                y = e.clientY - rect.top;
            }
            return { x: x, y: y };
        }

        function start(e) {
            e.preventDefault();
            sigDrawing = true;
            sigLast = pos(e);
            // hide hint
            var hint = document.getElementById('pr-signature-hint');
            if (hint) hint.style.display = 'none';
        }
        function move(e) {
            if (!sigDrawing) return;
            e.preventDefault();
            var p = pos(e);
            sigCtx.beginPath();
            sigCtx.moveTo(sigLast.x, sigLast.y);
            sigCtx.lineTo(p.x, p.y);
            sigCtx.stroke();
            sigLast = p;
            sigEmpty = false;
        }
        function end(e) {
            if (!sigDrawing) return;
            e.preventDefault();
            sigDrawing = false;
        }

        sigCanvas.addEventListener('mousedown', start);
        sigCanvas.addEventListener('mousemove', move);
        window.addEventListener('mouseup', end);
        sigCanvas.addEventListener('touchstart', start, { passive: false });
        sigCanvas.addEventListener('touchmove', move, { passive: false });
        sigCanvas.addEventListener('touchend', end, { passive: false });
        sigCanvas.addEventListener('touchcancel', end, { passive: false });
    }

    window.clearSignaturePad = function () {
        if (!sigCanvas || !sigCtx) return;
        sigCtx.clearRect(0, 0, sigCanvas.width, sigCanvas.height);
        sigEmpty = true;
        var hint = document.getElementById('pr-signature-hint');
        if (hint) hint.style.display = '';
    };

    window.commitSignatureAndSubmit = function () {
        if (!sigCanvas) return;
        if (sigEmpty) {
            alert('Por favor, firma en el recuadro antes de continuar.');
            return;
        }
        var dataUrl = sigCanvas.toDataURL('image/png');
        var c = getLivewireComponent();
        if (!c) return;
        // Set property (deferred) then call submit — both are flushed in one request
        c.set('signature', dataUrl, true);
        c.call('submit');
    };

    // Initialise the signature pad when its canvas appears in the DOM (step 4)
    function watchForSignatureCanvas() {
        if (document.getElementById('pr-signature-canvas')) {
            initSignaturePad();
        }
    }
    watchForSignatureCanvas();
    // Re-init after Livewire updates the DOM (when the user reaches step 4)
    document.addEventListener('livewire:update', watchForSignatureCanvas);
    document.addEventListener('livewire:navigated', watchForSignatureCanvas);
    if (window.Livewire && window.Livewire.hook) {
        try { window.Livewire.hook('morph.added', watchForSignatureCanvas); } catch (e) {}
        try { window.Livewire.hook('commit', function (payload) {
            // payload has succeed callback in Livewire 3
            if (payload && payload.succeed) {
                payload.succeed(function () { watchForSignatureCanvas(); });
            }
        }); } catch (e) {}
    }
    setInterval(watchForSignatureCanvas, 800);
})();
</script>
</div>
