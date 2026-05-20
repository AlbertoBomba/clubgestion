<div>
    <style>
        .dashboard-outer {
            background: linear-gradient(160deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            min-height: calc(100vh - 4rem);
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 639px) {
            .dashboard-scroll { padding-bottom: 80px; }
        }
    </style>
    <div class="dashboard-outer">

    {{-- GRADIENT HEADER --}}
    <div class="px-5 pt-5 pb-4 sm:max-w-2xl sm:mx-auto sm:w-full sm:px-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
               class="inline-flex items-center gap-1.5 text-white/70 text-xs font-bold uppercase tracking-widest active:opacity-60 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ $tournament->name }}
            </a>
            <button wire:click="logout"
                    class="inline-flex items-center gap-1.5 text-white/70 text-xs font-bold uppercase tracking-widest active:opacity-60 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Salir
            </button>
        </div>
    </div>

    {{-- WHITE SHEET --}}
    <div class="dashboard-scroll bg-white flex-1
                shadow-[0_-6px_32px_rgba(0,0,0,0.10)] sm:shadow-sm sm:w-[90%] sm:mx-auto sm:my-4 sm:rounded-3xl">

        {{-- Team identity --}}
        <div class="flex items-center gap-4 px-5 pt-5 pb-4 sm:px-8 sm:pt-7 sm:pb-5">
            @php
                $statusMap = [
                    'registered'   => ['label' => 'Inscrito',      'cls' => 'bg-primary/10 text-primary'],
                    'confirmed'    => ['label' => 'Confirmado',    'cls' => 'bg-green-100 text-green-700'],
                    'eliminated'   => ['label' => 'Eliminado',     'cls' => 'bg-gray-100 text-gray-500'],
                    'disqualified' => ['label' => 'Descalificado', 'cls' => 'bg-red-100 text-red-600'],
                ];
                $sc = $statusMap[$team->status] ?? ['label' => $team->status, 'cls' => 'bg-gray-100 text-gray-500'];
            @endphp
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden flex items-center justify-center shrink-0 border border-gray-100 bg-gray-50 shadow-sm">
                @if($team->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($team->logo))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($team->logo) }}" alt="{{ $team->displayName() }}" class="w-full h-full object-cover">
                @else
                    <span class="text-3xl">🛡️</span>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-gray-900 text-xl sm:text-2xl font-black leading-tight">{{ $team->displayName() }}</h1>
                <span class="inline-block mt-1 text-[10px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full {{ $sc['cls'] }}">{{ $sc['label'] }}</span>
            </div>
            @if(!$editMode)
            <button wire:click="startEdit"
                    class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:text-primary hover:border-primary/30 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar equipo
            </button>
            @endif
        </div>

        {{-- Desktop tab bar --}}
        <div class="hidden sm:flex gap-1 px-6 pt-6 border-b border-gray-100">
            <button wire:click="switchTab('perfil')"
                    class="px-5 py-2.5 text-sm font-bold rounded-t-xl transition-colors
                           {{ $tab === 'perfil' ? 'text-primary border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600' }}">
                Perfil del equipo
            </button>
            <button wire:click="switchTab('jugadores')"
                    class="px-5 py-2.5 text-sm font-bold rounded-t-xl transition-colors
                           {{ $tab === 'jugadores' ? 'text-primary border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600' }}">
                Jugadores
                @if($players->count())
                    <span class="ml-1.5 text-[10px] font-black px-1.5 py-0.5 rounded-full {{ $tab === 'jugadores' ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-gray-400' }}">{{ $players->count() }}</span>
                @endif
            </button>
        </div>

        {{-- TAB: PERFIL --}}
        @if($tab === 'perfil')
        <div class="px-5 py-6 sm:px-8 sm:pb-8 space-y-5">

            @if($profileSuccess)
                <div class="flex items-center gap-2.5 p-3.5 bg-green-50 border border-green-100 rounded-2xl">
                    <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-semibold text-green-700">{{ $profileSuccess }}</p>
                </div>
            @endif

            @if(!$editMode)
                {{-- View mode: 2-col grid on desktop --}}
                <div class="sm:grid sm:grid-cols-2 sm:gap-6 space-y-5 sm:space-y-0">

                    {{-- Left: contact info --}}
                    <div class="space-y-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-0.5">Contacto</p>
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden divide-y divide-gray-100">
                            @if($team->contact_name)
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Responsable</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->contact_name }}</p>
                            </div>
                            @endif
                            @if($team->contact_phone)
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Teléfono</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->contact_phone }}</p>
                            </div>
                            @endif
                            @if($team->email)
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->email }}</p>
                            </div>
                            @endif
                            @if(!$team->contact_name && !$team->contact_phone && !$team->email)
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-400">Sin datos de contacto.</p>
                            </div>
                            @endif
                        </div>

                        {{-- Mobile edit button (hidden on desktop, which has it in the header) --}}
                        <button wire:click="startEdit"
                                class="sm:hidden w-full py-4 rounded-2xl border-2 border-dashed border-gray-200 text-sm font-bold text-gray-400 hover:border-primary/40 hover:text-primary transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Editar datos del equipo
                        </button>
                    </div>

                    {{-- Right: tournament info --}}
                    <div class="space-y-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-0.5">Torneo</p>
                        <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden divide-y divide-gray-100">
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nombre</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $tournament->name }}</p>
                            </div>
                            @if($team->group_label)
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Grupo</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">Grupo {{ $team->group_label }}</p>
                            </div>
                            @endif
                            @if($team->seed)
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Cabeza de serie</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">#{{ $team->seed }}</p>
                            </div>
                            @endif
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Inscripción</p>
                                <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $team->created_at->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                            </div>
                        </div>
                    </div>

                </div>

            @else
                {{-- Edit mode --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Escudo / Logo</label>
                        @if($editLogo)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-200">
                                <img src="{{ $editLogo->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-xl border border-gray-200">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-700">Nueva imagen</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Se guardará al confirmar</p>
                                </div>
                                <button type="button" wire:click="$set('editLogo', null)" class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @else
                            <label for="edit-logo-input" class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 cursor-pointer hover:border-primary/40 transition-colors">
                                <div class="w-14 h-14 rounded-xl overflow-hidden flex items-center justify-center shrink-0 border border-gray-200 bg-white">
                                    @if($team->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($team->logo))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($team->logo) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl">🛡️</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-600">Toca para cambiar escudo</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">PNG, JPG · Máx 2 MB</p>
                                </div>
                            </label>
                            <input type="file" id="edit-logo-input" wire:model="editLogo" accept="image/*" class="hidden">
                        @endif
                        @error('editLogo') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nombre del equipo *</label>
                        <input wire:model="editName" type="text" placeholder="Nombre del equipo"
                               class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('editName') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Responsable</label>
                        <input wire:model="editContactName" type="text" placeholder="Nombre del responsable"
                               class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('editContactName') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Teléfono</label>
                        <input wire:model="editContactPhone" type="tel" placeholder="600 000 000"
                               class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('editContactPhone') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                        <input wire:model="editEmail" type="email" placeholder="equipo@ejemplo.com"
                               class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('editEmail') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex gap-3 pt-1 pb-2">
                        <button wire:click="cancelEdit"
                                class="px-5 py-4 sm:py-3 rounded-2xl border border-gray-200 text-base sm:text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="saveProfile"
                                class="flex-1 py-4 sm:py-3 rounded-2xl text-white text-base sm:text-sm font-bold shadow hover:opacity-90 active:scale-[0.98] transition-all"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <span wire:loading.remove wire:target="saveProfile">Guardar cambios</span>
                            <span wire:loading wire:target="saveProfile" class="inline-flex items-center gap-2 justify-center">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Guardando...
                            </span>
                        </button>
                    </div>
                </div>
            @endif

        </div>
        @endif

        {{-- TAB: JUGADORES --}}
        @if($tab === 'jugadores')
        <div class="px-5 py-6 sm:px-6">

            @if(!$showAddPlayer)
            {{-- Add player button --}}
            <div class="mb-4">
                <a href="{{ route('webclubs.player.register', [$tournament, $team->registration_token]) }}"
                   class="w-full py-4 sm:py-3 rounded-2xl text-white text-sm font-bold shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
                   style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Añadir jugador
                </a>
            </div>

            {{-- Permanent share link — always visible --}}
            <div class="mb-5 p-4 bg-blue-50 border border-blue-100 rounded-2xl space-y-3">
                <div>
                    <p class="text-xs font-black text-gray-900">Enlace de inscripción del equipo</p>
                    <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Comparte este enlace con tus jugadores. Es único para <strong>{{ $team->displayName() }}</strong> y no caduca.</p>
                </div>
                <div class="flex gap-2">
                    <input id="share-link-input" type="text" readonly value="{{ $registrationUrl }}"
                           class="flex-1 px-3 py-2.5 text-xs border border-blue-200 rounded-xl bg-white text-gray-700 focus:outline-none select-all"/>
                    <button type="button" onclick="copyShareLink()"
                            class="px-3 py-2.5 rounded-xl text-white text-xs font-bold transition-opacity hover:opacity-90 shrink-0"
                            style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        Copiar
                    </button>
                </div>
                <a href="https://wa.me/?text={{ urlencode('🏆 ' . $tournament->name . ' — Inscripción para ' . $team->displayName() . chr(10) . 'Regístrate como jugador de nuestro equipo haciendo clic aquí: ' . $registrationUrl) }}"
                   target="_blank" rel="noopener"
                   class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-green-500 text-white text-sm font-bold hover:bg-green-600 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Compartir por WhatsApp
                </a>
            </div>
            @endif

            @if($showAddPlayer)
            <div class="bg-gray-50 rounded-2xl border border-gray-100 p-4 mb-5 space-y-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-black text-gray-900">Nuevo jugador</p>
                    <button wire:click="closeAddPlayer" class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Foto <span class="normal-case font-normal text-gray-400">(opcional)</span></label>

                    {{-- Hidden Livewire upload input --}}
                    <input type="file" id="player-photo-livewire" wire:model="pPhoto" accept="image/*" class="hidden">
                    {{-- Trigger inputs —no wire: attributes --}}
                    <input type="file" id="player-photo-gallery" accept="image/*" class="hidden"
                           onchange="handlePlayerPhotoSelect(event)">
                    <input type="file" id="player-photo-camera" accept="image/*" capture="environment" class="hidden"
                           onchange="handlePlayerPhotoSelect(event)">

                    @if($pPhoto)
                        {{-- Livewire preview (after upload) --}}
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <img src="{{ $pPhoto->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-xl border border-gray-200">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-gray-700">Foto lista</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Se guardará al confirmar</p>
                            </div>
                            <button type="button" wire:click="$set('pPhoto', null)"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @else
                        {{-- JS-managed preview while Livewire uploads --}}
                        <div id="player-photo-preview-container" class="hidden items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 mb-2">
                            <img id="player-photo-preview-img" class="w-14 h-14 object-cover rounded-xl border border-gray-200" alt="Vista previa">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-gray-700">Foto recortada</p>
                                <div wire:loading wire:target="pPhoto" class="flex items-center gap-1 mt-0.5">
                                    <svg class="animate-spin w-3 h-3 text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    <span class="text-[10px] text-gray-400">Subiendo...</span>
                                </div>
                            </div>
                            <button type="button" onclick="clearPlayerPhoto()"
                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div id="player-photo-action-buttons" class="flex gap-2">
                            <button type="button" onclick="document.getElementById('player-photo-gallery').click()"
                                    class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Galería
                            </button>
                            <button type="button" onclick="document.getElementById('player-photo-camera').click()"
                                    class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-xl border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Cámara
                            </button>
                        </div>
                    @endif
                    @error('pPhoto') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre *</label>
                        <input wire:model="pName" type="text" placeholder="Nombre"
                               class="w-full px-3 py-3 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('pName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Apellidos</label>
                        <input wire:model="pSurname" type="text" placeholder="Apellidos"
                               class="w-full px-3 py-3 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dorsal</label>
                        <input wire:model="pDorsal" type="number" min="1" max="999" placeholder="Nº"
                               class="w-full px-3 py-3 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('pDorsal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Posición</label>
                        <select wire:model="pPosition"
                                class="w-full px-3 py-3 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                            <option value="">—</option>
                            @foreach(\App\Models\TournamentPlayer::positions() as $pos)
                                <option value="{{ $pos }}">{{ $pos }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Fecha de nacimiento</label>
                    {{-- Hidden input that Livewire reads (yyyy-mm-dd) --}}
                    <input wire:model="pBirthdate" type="hidden" id="pBirthdate-livewire"/>
                    <div class="relative">
                        <input type="text" id="pBirthdate-text"
                               placeholder="dd/mm/aaaa"
                               maxlength="10"
                               oninput="formatBirthdateInput(this)"
                               class="w-full pl-3 pr-10 py-3 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        <input type="date" id="pBirthdate-picker" tabindex="-1"
                               style="position:absolute;opacity:0;width:0;height:0;top:0;right:0;"
                               onchange="syncBirthdatePicker(this)"/>
                        <button type="button" onclick="document.getElementById('pBirthdate-picker').showPicker()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round"/>
                                <line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </button>
                    </div>
                    @error('pBirthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button wire:click="savePlayer"
                        class="w-full py-4 sm:py-3 rounded-2xl text-white text-base sm:text-sm font-bold shadow hover:opacity-90 active:scale-[0.98] transition-all"
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    <span wire:loading.remove wire:target="savePlayer">Guardar jugador</span>
                    <span wire:loading wire:target="savePlayer" class="inline-flex items-center gap-2 justify-center">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Guardando...
                    </span>
                </button>
            </div>
            @endif

            @if($players->isEmpty() && !$showAddPlayer)
                <div class="text-center py-14 bg-gray-50/60 rounded-2xl border border-dashed border-gray-200">
                    <div class="text-5xl mb-3 opacity-20">👥</div>
                    <p class="text-gray-500 font-semibold text-sm">Sin jugadores todavía</p>
                    <p class="text-gray-400 text-xs mt-1">Pulsa "Añadir jugador" para empezar.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($players as $player)
                    <div class="flex items-center gap-3 bg-white border border-gray-100 rounded-2xl p-3 shadow-sm">
                        <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-gray-100 flex items-center justify-center border border-gray-200">
                            @if($player->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($player->photo))
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($player->photo) }}" alt="{{ $player->fullName() }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xl">👤</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-black text-gray-900 truncate">{{ $player->fullName() }}</p>
                                @if($player->dorsal)
                                    <span class="shrink-0 text-[10px] font-black px-1.5 py-0.5 rounded-md bg-gray-100 text-gray-500">#{{ $player->dorsal }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                @if($player->position)
                                    <span class="text-[10px] font-bold text-gray-400">{{ $player->position }}</span>
                                @endif
                                @if($player->birthdate)
                                    <span class="text-[10px] text-gray-300">·</span>
                                    <span class="text-[10px] text-gray-400">{{ $player->birthdate->age }} años</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 shrink-0">
                            @if($player->goals_count > 0)
                            <div class="flex flex-col items-center min-w-[28px]">
                                <span class="text-sm font-black text-gray-800">{{ $player->goals_count }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">Goles</span>
                            </div>
                            @endif
                            @if($player->cards_count > 0)
                            <div class="flex flex-col items-center min-w-[28px]">
                                <span class="text-sm font-black text-gray-800">{{ $player->cards_count }}</span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">Tarj.</span>
                            </div>
                            @endif
                            @php
                                $pStatus = [
                                    'pending'  => ['dot' => 'bg-amber-400', 'label' => 'Pendiente'],
                                    'approved' => ['dot' => 'bg-green-400', 'label' => 'Aprobado'],
                                    'rejected' => ['dot' => 'bg-red-400',   'label' => 'Rechazado'],
                                ][$player->status] ?? ['dot' => 'bg-gray-300', 'label' => $player->status];
                            @endphp
                            <div class="flex flex-col items-center">
                                <div class="w-2 h-2 rounded-full {{ $pStatus['dot'] }}"></div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase mt-0.5">{{ $pStatus['label'] }}</span>
                            </div>
                            <button wire:click="deletePlayer({{ $player->id }})"
                                    wire:confirm="¿Eliminar a {{ $player->fullName() }}?"
                                    class="ml-1 p-1.5 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>
        @endif

    </div>{{-- end white sheet --}}
    </div>{{-- end outer --}}

    {{-- MOBILE BOTTOM TAB BAR --}}
    <div class="sm:hidden fixed bottom-0 inset-x-0 z-50 bg-white border-t border-gray-100 shadow-[0_-2px_16px_rgba(0,0,0,0.07)]">
        <div class="flex">
            <button wire:click="switchTab('perfil')"
                    class="flex-1 relative flex flex-col items-center justify-center gap-0.5 py-3 transition-colors {{ $tab === 'perfil' ? 'text-primary' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ $tab === 'perfil' ? '2.5' : '1.8' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span class="text-[10px] font-bold uppercase tracking-wider">Perfil</span>
                @if($tab === 'perfil')
                    <div class="absolute bottom-0 inset-x-0 h-0.5 rounded-t-full" style="background: linear-gradient(90deg, var(--color-primary), var(--color-secondary))"></div>
                @endif
            </button>
            <button wire:click="switchTab('jugadores')"
                    class="flex-1 relative flex flex-col items-center justify-center gap-0.5 py-3 transition-colors {{ $tab === 'jugadores' ? 'text-primary' : 'text-gray-400' }}">
                <div class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ $tab === 'jugadores' ? '2.5' : '1.8' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    @if($players->count())
                        <span class="absolute -top-1.5 -right-2.5 min-w-[16px] h-4 text-[9px] font-black rounded-full px-1 flex items-center justify-center text-white"
                              style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">{{ $players->count() }}</span>
                    @endif
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider">Jugadores</span>
                @if($tab === 'jugadores')
                    <div class="absolute bottom-0 inset-x-0 h-0.5 rounded-t-full" style="background: linear-gradient(90deg, var(--color-primary), var(--color-secondary))"></div>
                @endif
            </button>
        </div>
    </div>

    {{-- Player photo cropper overlay --}}
    <div id="player-photo-cropper-overlay" class="fixed inset-0 z-[200] bg-black/85 flex items-center justify-center p-4" style="display:none" wire:ignore>
        <div class="bg-white rounded-3xl w-full max-w-sm overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-gray-100">
                <p class="text-sm font-black text-gray-900">Recortar foto</p>
                <p class="text-xs text-gray-400 mt-0.5">Ajusta el recuadro al área que quieres usar</p>
            </div>
            <div class="p-4 bg-gray-900" style="max-height:320px;overflow:hidden">
                <img id="player-crop-img" class="max-w-full block" alt="Recortar">
            </div>
            <div class="flex gap-2 p-4">
                <button type="button" onclick="cancelPlayerPhotoCrop()"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="applyPlayerPhotoCrop()"
                        class="flex-1 py-2.5 rounded-xl text-white text-sm font-bold transition-opacity hover:opacity-90"
                        style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                    ✓ Usar este recorte
                </button>
            </div>
        </div>
    </div>

    <script>
    (function () {
        var playerCropper = null;

        window.handlePlayerPhotoSelect = function (event) {
            var file = event.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                var overlay = document.getElementById('player-photo-cropper-overlay');
                var img = document.getElementById('player-crop-img');
                if (!overlay || !img) return;
                img.src = ev.target.result;
                overlay.style.display = 'flex';
                if (playerCropper) { playerCropper.destroy(); playerCropper = null; }
                playerCropper = new Cropper(img, {
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

        window.applyPlayerPhotoCrop = function () {
            if (!playerCropper) return;
            playerCropper.getCroppedCanvas({ width: 400, height: 400 }).toBlob(function (blob) {
                var file = new File([blob], 'foto-jugador.jpg', { type: 'image/jpeg' });
                var livewireInput = document.getElementById('player-photo-livewire');
                if (!livewireInput) return;
                var dt = new DataTransfer();
                dt.items.add(file);
                livewireInput.files = dt.files;
                livewireInput.dispatchEvent(new Event('change'));

                var previewContainer = document.getElementById('player-photo-preview-container');
                var previewImg = document.getElementById('player-photo-preview-img');
                var actionButtons = document.getElementById('player-photo-action-buttons');
                if (previewContainer && previewImg) {
                    previewImg.src = URL.createObjectURL(blob);
                    previewContainer.style.display = 'flex';
                }
                if (actionButtons) actionButtons.style.display = 'none';

                var overlay = document.getElementById('player-photo-cropper-overlay');
                if (overlay) overlay.style.display = 'none';
                if (playerCropper) { playerCropper.destroy(); playerCropper = null; }
            }, 'image/jpeg', 0.92);
        };

        window.cancelPlayerPhotoCrop = function () {
            var overlay = document.getElementById('player-photo-cropper-overlay');
            if (overlay) overlay.style.display = 'none';
            if (playerCropper) { playerCropper.destroy(); playerCropper = null; }
        };

    window.copyShareLink = function () {
        var input = document.getElementById('share-link-input');
        if (!input) return;
        if (navigator.clipboard) {
            navigator.clipboard.writeText(input.value);
        } else {
            input.select(); document.execCommand('copy');
        }
    };

    window.clearPlayerPhoto = function () {
            var previewContainer = document.getElementById('player-photo-preview-container');
            var actionButtons = document.getElementById('player-photo-action-buttons');
            var livewireInput = document.getElementById('player-photo-livewire');
            if (previewContainer) previewContainer.style.display = 'none';
            if (actionButtons) actionButtons.style.display = '';
            if (livewireInput) {
                livewireInput.value = '';
                livewireInput.dispatchEvent(new Event('change'));
            }
        };
    })();

    // Birthdate field helpers
    window.formatBirthdateInput = function (input) {
        var raw = input.value.replace(/\D/g, '');
        var formatted = raw;
        if (raw.length > 2) formatted = raw.slice(0,2) + '/' + raw.slice(2);
        if (raw.length > 4) formatted = raw.slice(0,2) + '/' + raw.slice(2,4) + '/' + raw.slice(4,8);
        input.value = formatted;
        if (raw.length === 8) {
            var iso = raw.slice(4,8) + '-' + raw.slice(2,4) + '-' + raw.slice(0,2);
            document.getElementById('pBirthdate-picker').value = iso;
            pushBirthdateToLivewire(iso);
        } else {
            pushBirthdateToLivewire('');
        }
    };

    window.syncBirthdatePicker = function (picker) {
        var iso = picker.value;
        var textInput = document.getElementById('pBirthdate-text');
        if (iso && textInput) {
            var p = iso.split('-');
            textInput.value = p[2] + '/' + p[1] + '/' + p[0];
        }
        pushBirthdateToLivewire(iso);
    };

    window.pushBirthdateToLivewire = function (isoValue) {
        var hidden = document.getElementById('pBirthdate-livewire');
        if (!hidden) return;
        var setter = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value').set;
        setter.call(hidden, isoValue);
        hidden.dispatchEvent(new Event('input', { bubbles: true }));
    };
    </script>
</div>
