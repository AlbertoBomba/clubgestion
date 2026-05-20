<div>
    <style>
        .team-register-outer {
            background: linear-gradient(160deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            min-height: calc(100vh - 4rem);
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 639px) {
            .team-register-sheet-wrap {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
            }
        }
    </style>

    <div class="team-register-outer">

        {{-- MOBILE HERO (hidden on sm+) --}}
        <div class="sm:hidden px-5 pt-5 pb-2">
            <a href="{{ route('webclubs.team.login', $tournament) }}"
               class="inline-flex items-center gap-1.5 text-white/80 text-sm font-semibold py-1.5 pr-3 active:opacity-60 transition-opacity">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver
            </a>
            <div class="mt-5 mb-2">
                </div>
        </div>

        {{-- SHEET WRAPPER --}}
        <div class="team-register-sheet-wrap sm:flex sm:min-h-[calc(100vh-6rem)] sm:items-center sm:justify-center sm:px-4 sm:py-12">
            <div class="w-full sm:max-w-2xl">

                <div class="bg-white  sm:rounded-3xl
                            shadow-[0_-6px_32px_rgba(0,0,0,0.10)] sm:shadow-sm sm:border sm:border-gray-100
                            overflow-hidden">
                            <div class="px-6 pt-6 pb-4 sm:p-7 sm:pb-5">
                                <p class="text-black/60 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $tournament->name }}</p>
                                <h1 class="text-black text-[1.6rem] font-black leading-tight">Inscribir equipo</h1>
                            </div>

                    {{-- Drag handle (mobile only) --}}
                    <div class="sm:hidden w-10 h-1 bg-gray-200 rounded-full mx-auto mt-5 mb-1"></div>

                    {{-- Desktop page header --}}
                    <div class="hidden sm:block px-6 pt-6 pb-0">
                        <a href="{{ route('webclubs.team.login', $tournament) }}"
                           class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            {{ $tournament->name }} / Inscribir equipo
                        </a>
                    </div>
                
                {{-- Step indicator --}}
                <div class="px-6 pt-5 pb-4 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Inscripción de equipo</p>
                        <p class="text-xs font-bold" style="color: var(--color-primary)">Paso {{ $step }} de 3</p>
                    </div>
                    <div class="flex gap-1.5">
                        @foreach([1,2,3] as $s)
                            <div class="h-1.5 flex-1 rounded-full transition-all duration-300 {{ $s <= $step ? '' : 'bg-gray-100' }}"
                                 style="{{ $s <= $step ? 'background: linear-gradient(90deg, var(--color-primary), var(--color-secondary))' : '' }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-[10px] font-bold {{ $step >= 1 ? 'text-gray-700' : 'text-gray-300' }}">Equipo</span>
                        <span class="text-[10px] font-bold {{ $step >= 2 ? 'text-gray-700' : 'text-gray-300' }}">Contacto</span>
                        <span class="text-[10px] font-bold {{ $step >= 3 ? 'text-gray-700' : 'text-gray-300' }}">Acceso</span>
                    </div>
                </div>

                {{-- Step content --}}
                <div class="px-6 py-6">

                    {{-- STEP 1: Team name + Logo --}}
                    @if($step === 1)
                    <div class="step-anim space-y-5">

                        {{-- Desktop: logo izquierda + nombre derecha en la misma fila. Móvil: apilados --}}
                        <div class="flex flex-col gap-5 md:flex-row md:items-start md:gap-6">

                            {{-- Logo uploader — columna izquierda en desktop --}}
                            <div class="order-2 md:order-1 md:w-44 md:shrink-0">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Escudo / Logo <span class="normal-case font-normal text-gray-400">(opcional)</span>
                                </label>

                                {{-- Hidden Livewire upload input — NEVER inside wire:ignore --}}
                                <input type="file" id="logo-livewire-input" wire:model.live="reg_logo"
                                       accept="image/*" class="hidden">

                                {{-- Trigger inputs — no wire: attributes --}}
                                <input type="file" id="logo-file-input" accept="image/*" class="hidden"
                                       onchange="handleLogoFileSelect(event)">
                                <input type="file" id="logo-camera-input" accept="image/*" capture="environment" class="hidden"
                                       onchange="handleLogoFileSelect(event)">

                                {{-- Hidden clear-logo button (clicked by JS to call Livewire) --}}
                                <button id="clear-logo-wire-btn" type="button" wire:click="clearRegLogo" class="hidden"></button>

                                @if($reg_logo)
                                    {{-- Server preview (after upload) --}}
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-200 md:flex-col md:items-center md:text-center md:py-4">
                                        <img src="{{ $reg_logo->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-xl border border-gray-200 md:w-20 md:h-20" alt="Escudo">
                                        <div class="flex-1 min-w-0 md:flex-none">
                                            <p class="text-xs font-bold text-gray-700">Escudo listo</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Se guardará al finalizar</p>
                                        </div>
                                        <button type="button" onclick="clearLogoPreview()"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                @else
                                    {{-- Drop zone --}}
                                    <div id="logo-dropzone"
                                         onclick="document.getElementById('logo-file-input').click()"
                                         class="border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center hover:border-primary/40 hover:bg-gray-50/50 transition-colors cursor-pointer md:flex md:flex-col md:items-center md:justify-center md:min-h-[140px]">
                                        <div class="text-3xl mb-2 opacity-30">🛡️</div>
                                        <p class="text-xs font-bold text-gray-500">Toca para subir</p>
                                        <p class="text-[10px] text-gray-300 mt-0.5">PNG, JPG · Máx 2 MB</p>
                                    </div>

                                    {{-- JS-managed preview while Livewire uploads --}}
                                    <div id="logo-preview-container" class="hidden items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-200">
                                        <img id="logo-preview-img" class="w-14 h-14 object-cover rounded-xl border border-gray-200" alt="Vista previa">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-gray-700">Escudo recortado</p>
                                            <div wire:loading wire:target="reg_logo" class="flex items-center gap-1 mt-0.5">
                                                <svg class="animate-spin w-3 h-3 text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                                <span class="text-[10px] text-gray-400">Subiendo...</span>
                                            </div>
                                        </div>
                                        <button type="button" onclick="clearLogoPreview()"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>

                                    {{-- Gallery / Camera buttons --}}
                                    <div id="logo-action-buttons" class="flex gap-2 mt-3">
                                        <button type="button" onclick="document.getElementById('logo-file-input').click()"
                                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Galería
                                        </button>
                                        <button type="button" onclick="document.getElementById('logo-camera-input').click()"
                                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Cámara
                                        </button>
                                    </div>
                                @endif

                                @error('reg_logo') <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Nombre del equipo — columna derecha en desktop, primera en móvil --}}
                            <div class="order-1 md:order-2 flex-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre del equipo *</label>
                                <input wire:model="reg_name" type="text" placeholder="Nombre de tu equipo"
                                       class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                                @error('reg_name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                        </div>

                    </div>
                    @endif

                    {{-- STEP 2: Contact data --}}
                    @if($step === 2)
                    <div class="step-anim space-y-4">
                        <div class="flex items-start gap-2.5 p-3.5 bg-gray-50 rounded-2xl border border-gray-100">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">Datos de la persona de contacto del equipo. Estos datos son opcionales pero recomendables para que el organizador pueda contactaros.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre del responsable</label>
                            <input wire:model="reg_contact_name" type="text" placeholder="Tu nombre completo"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('reg_contact_name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Teléfono de contacto</label>
                            <input wire:model="reg_contact_phone" type="tel" placeholder="600 000 000"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('reg_contact_phone') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    @endif

                    {{-- STEP 3: Access credentials --}}
                    @if($step === 3)
                    <div class="step-anim space-y-4">
                        @if($tournament->team_type === 'open')
                            <div class="flex items-start gap-2.5 p-3.5 bg-blue-50 rounded-2xl border border-blue-100">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-xs text-blue-700 font-medium leading-relaxed">Torneo abierto — el email y contrase&ntilde;a que configures te permitir&aacute;n acceder al &aacute;rea de gesti&oacute;n de tu equipo para a&ntilde;adir jugadores.</p>
                            </div>
                        @endif
                        <div class="flex items-start gap-2.5 p-3.5 {{ $tournament->team_type === 'open' ? 'bg-amber-50 border-amber-100' : 'bg-gray-50 border-gray-100' }} rounded-2xl border">
                            <svg class="w-4 h-4 {{ $tournament->team_type === 'open' ? 'text-amber-500' : 'text-gray-400' }} mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                            @if($tournament->team_type === 'open')
                                <p class="text-xs text-amber-700 font-medium leading-relaxed">Estas credenciales son <strong>obligatorias</strong>. Las usarás para acceder al área de gestión de tu equipo tras inscribirte.</p>
                            @else
                                <p class="text-xs text-gray-500 font-medium leading-relaxed">Las credenciales son opcionales. Si las proporcionas, podrás acceder al área de gestión de tu equipo.</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                                Email de acceso {{ $tournament->team_type === 'open' ? '*' : '(opcional)' }}
                            </label>
                            <input wire:model="reg_email" type="email" autocomplete="off"
                                   placeholder="equipo@ejemplo.com"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('reg_email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                                Contraseña {{ $tournament->team_type === 'open' ? '*' : '(opcional)' }}
                            </label>
                            <input wire:model="reg_password" type="password" autocomplete="new-password"
                                   placeholder="Mínimo 6 caracteres"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('reg_password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                                Confirmar contraseña {{ $tournament->team_type === 'open' ? '*' : '(opcional)' }}
                            </label>
                            <input wire:model="reg_confirm_password" type="password" autocomplete="new-password"
                                   placeholder="Repite la contraseña"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('reg_confirm_password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    @endif

                    {{-- STEP 4: Summary --}}
                    @if($step === 4)
                    <div class="step-anim space-y-4">
                        <div class="flex items-start gap-2.5 p-3.5 bg-green-50 rounded-2xl border border-green-100">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs text-green-700 font-medium leading-relaxed">Revisa los datos antes de confirmar. El organizador recibirá tu solicitud y la confirmará.</p>
                        </div>

                        <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden divide-y divide-gray-100">

                            {{-- Logo + Name --}}
                            <div class="flex items-center gap-4 p-4">
                                <div class="w-12 h-12 rounded-xl overflow-hidden flex items-center justify-center shrink-0 border border-gray-200 bg-white">
                                    @if($reg_logo)
                                        <img src="{{ $reg_logo->temporaryUrl() }}" class="w-full h-full object-cover" alt="Escudo">
                                    @else
                                        <span class="text-xl">🛡️</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Equipo</p>
                                    <p class="text-sm font-black text-gray-900">{{ $reg_name ?: '—' }}</p>
                                </div>
                            </div>

                            @if($reg_contact_name || $reg_contact_phone)
                            <div class="p-4 grid grid-cols-2 gap-4">
                                @if($reg_contact_name)
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Responsable</p>
                                    <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $reg_contact_name }}</p>
                                </div>
                                @endif
                                @if($reg_contact_phone)
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Teléfono</p>
                                    <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $reg_contact_phone }}</p>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($reg_email)
                            <div class="p-4">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email de acceso</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $reg_email }}</p>
                            </div>
                            @endif

                        </div>
                    </div>
                    @endif

                </div>

                {{-- Navigation buttons --}}
                <div class="flex gap-3 px-6 pb-8 sm:pb-6 pt-2">
                    @if($step > 1)
                        <button wire:click="prevStep"
                                class="flex items-center justify-center gap-1.5 px-5 py-4 sm:py-3 rounded-2xl border border-gray-200 text-base sm:text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Atrás
                        </button>
                    @else
                        <a href="{{ route('webclubs.team.login', $tournament) }}"
                           class="px-5 py-4 sm:py-3 rounded-2xl border border-gray-200 text-base sm:text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </a>
                    @endif

                    @if($step < 4)
                        <button wire:click="nextStep"
                                class="flex-1 flex items-center justify-center gap-1.5 py-4 sm:py-3 rounded-2xl text-white text-base sm:text-sm font-bold shadow hover:opacity-90 active:scale-[0.98] transition-all duration-150"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <span wire:loading.remove wire:target="nextStep">
                                Siguiente
                                <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                            <span wire:loading wire:target="nextStep" class="inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Validando...
                            </span>
                        </button>
                    @else
                        <button wire:click="registerTeam"
                                class="flex-1 flex items-center justify-center gap-1.5 py-4 sm:py-3 rounded-2xl text-white text-base sm:text-sm font-bold shadow hover:opacity-90 active:scale-[0.98] transition-all duration-150"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <span wire:loading.remove wire:target="registerTeam">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Confirmar
                            </span>
                            <span wire:loading wire:target="registerTeam" class="inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Inscribiendo...
                            </span>
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    </div>

    {{-- Cropper overlay — wire:ignore prevents Livewire morphing from touching it --}}
    <div id="cropper-overlay" class="fixed inset-0 z-[200] bg-black/85 flex items-center justify-center p-4" style="display:none" wire:ignore>
        <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-gray-100">
                <p class="text-sm font-black text-gray-900">Recortar escudo</p>
                <p class="text-xs text-gray-400 mt-0.5">Ajusta el recuadro al área que quieres usar</p>
            </div>
            <div class="p-4 bg-gray-900" style="max-height:320px;overflow:hidden">
                <img id="crop-img" class="max-w-full block" alt="Recortar">
            </div>
            <div class="flex gap-2 p-4">
                <button type="button" onclick="cancelLogoCrop()"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="applyLogoCrop()"
                        class="flex-1 py-2.5 rounded-xl text-white text-sm font-bold transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    ✓ Usar este recorte
                </button>
            </div>
        </div>
    </div>

    @once
    <script>
    (function () {
        var logoCropper = null;

        window.handleLogoFileSelect = function (event) {
            var file = event.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                var overlay = document.getElementById('cropper-overlay');
                var img = document.getElementById('crop-img');
                if (!overlay || !img) return;
                img.src = ev.target.result;
                overlay.style.display = 'flex';
                if (logoCropper) { logoCropper.destroy(); logoCropper = null; }
                logoCropper = new Cropper(img, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.85,
                    guides: false,
                    center: true,
                    highlight: false,
                });
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        };

        window.applyLogoCrop = function () {
            if (!logoCropper) return;
            logoCropper.getCroppedCanvas({ width: 400, height: 400 }).toBlob(function (blob) {
                var file = new File([blob], 'escudo.jpg', { type: 'image/jpeg' });
                var livewireInput = document.getElementById('logo-livewire-input');
                if (!livewireInput) return;
                var dt = new DataTransfer();
                dt.items.add(file);
                livewireInput.files = dt.files;
                livewireInput.dispatchEvent(new Event('change'));

                // Show JS preview
                var previewContainer = document.getElementById('logo-preview-container');
                var previewImg = document.getElementById('logo-preview-img');
                var dropzone = document.getElementById('logo-dropzone');
                var actionButtons = document.getElementById('logo-action-buttons');
                if (previewContainer && previewImg) {
                    previewImg.src = URL.createObjectURL(blob);
                    previewContainer.style.display = 'flex';
                }
                if (dropzone) dropzone.style.display = 'none';
                if (actionButtons) actionButtons.style.display = 'none';

                // Close overlay
                var overlay = document.getElementById('cropper-overlay');
                if (overlay) overlay.style.display = 'none';
                if (logoCropper) { logoCropper.destroy(); logoCropper = null; }
            }, 'image/jpeg', 0.92);
        };

        window.cancelLogoCrop = function () {
            var overlay = document.getElementById('cropper-overlay');
            if (overlay) overlay.style.display = 'none';
            if (logoCropper) { logoCropper.destroy(); logoCropper = null; }
        };

        window.clearLogoPreview = function () {
            var previewContainer = document.getElementById('logo-preview-container');
            var dropzone = document.getElementById('logo-dropzone');
            var actionButtons = document.getElementById('logo-action-buttons');
            var livewireInput = document.getElementById('logo-livewire-input');
            if (previewContainer) previewContainer.style.display = 'none';
            if (dropzone) dropzone.style.display = '';
            if (actionButtons) actionButtons.style.display = '';
            if (livewireInput) {
                livewireInput.value = '';
                livewireInput.dispatchEvent(new Event('change'));
            }
            // Tell Livewire to clear reg_logo via the hidden button
            var clearBtn = document.getElementById('clear-logo-wire-btn');
            if (clearBtn) clearBtn.click();
        };
    })();
    </script>
    @endonce

</div>
