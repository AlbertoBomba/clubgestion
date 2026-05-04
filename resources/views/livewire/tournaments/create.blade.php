<div>
    {{-- Breadcrumb + Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-2 text-xs text-titanium mb-1">
                <a href="{{ route('tournaments.index') }}" wire:navigate class="hover:text-primary transition-colors">Torneos</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-black-deep font-medium">Nuevo Torneo</span>
            </nav>
            <h1 class="text-2xl font-bold text-black-deep">Crear Torneo</h1>
            <p class="text-sm text-titanium mt-1">Configura tu torneo en unos sencillos pasos. Solo el nombre es obligatorio, el resto puedes completarlo después.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('tournaments.index') }}" wire:navigate
               class="inline-flex items-center gap-2 border border-silver text-sm font-semibold text-titanium px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button wire:click="save" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition-colors disabled:opacity-60">
                <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Crear Torneo
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- =========== MAIN COLUMN =========== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STEP 1: Basic info --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-primary text-white text-xs font-bold shrink-0">1</span>
                    <h2 class="text-base font-bold text-black-deep">Información del torneo</h2>
                </div>
                <p class="text-sm text-titanium mb-5 ml-10">Dale un nombre a tu torneo y opcionalmente una ubicación y descripción.</p>

                <div class="space-y-4 ml-10">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre del torneo <span class="text-red-500">*</span></label>
                        <input wire:model="name" type="text" placeholder="Ej: Copa Primavera 2026, Liga Interna Alevín..."
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Elige un nombre descriptivo que identifique fácilmente este torneo.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Descripción <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <textarea wire:model="description" rows="3" placeholder="Describe las reglas, formato o cualquier información importante del torneo..."
                                  class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Ubicación / Sede <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <input wire:model="location" type="text" placeholder="Ej: Polideportivo Municipal, Campo nº 3..."
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        <p class="text-xs text-titanium/70 mt-1">Dónde se jugará el torneo. Cada partido también puede tener su propia ubicación.</p>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Dates --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-primary/15 text-primary text-xs font-bold shrink-0">2</span>
                    <h2 class="text-base font-bold text-black-deep">Fechas</h2>
                </div>
                <p class="text-sm text-titanium mb-5 ml-10">Define cuándo empieza y acaba el torneo. No te preocupes, puedes cambiarlas después.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 ml-10">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fecha de inicio</label>
                        <input wire:model="start_date" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                        @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Primer día de competición.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fecha de fin</label>
                        <input wire:model="end_date" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                        @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Último día del torneo.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Cierre de inscripción</label>
                        <input wire:model="registration_deadline" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                        <p class="text-xs text-titanium/70 mt-1">Fecha límite para inscribir equipos.</p>
                    </div>
                </div>
            </div>

            {{-- STEP 3: Player restrictions --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-primary/15 text-primary text-xs font-bold shrink-0">3</span>
                    <h2 class="text-base font-bold text-black-deep">Restricciones de jugadores</h2>
                </div>
                <p class="text-sm text-titanium mb-5 ml-10">Configura los límites y requisitos para los jugadores que participan en este torneo.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 ml-10">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Máx. jugadores por equipo <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <input wire:model="max_players_per_team" type="number" min="1" max="100" placeholder="Sin límite"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        @error('max_players_per_team') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Número máximo de jugadores que puede inscribir cada equipo en el torneo.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Edad mínima <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <input wire:model="min_age" type="number" min="1" max="100" placeholder="Sin restricción"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        @error('min_age') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Los jugadores deben tener esta edad mínima para poder inscribirse.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fecha límite inscripción jugadores <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <input wire:model="player_registration_deadline" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                        @error('player_registration_deadline') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Fecha límite hasta la que se pueden añadir jugadores a los equipos inscritos.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Tipo de equipos participantes <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <select wire:model="team_type"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                            <option value="">Sin restricción</option>
                            <option value="school_teams">Equipos de Escuelas Deportivas</option>
                            <option value="open">Torneo Abierto</option>
                        </select>
                        @error('team_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Define si el torneo es exclusivo para escuelas o abierto a cualquier equipo.</p>
                    </div>
                </div>
            </div>

            {{-- STEP 4: Scoring system --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-3 mb-1">
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-primary/15 text-primary text-xs font-bold shrink-0">4</span>
                    <h2 class="text-base font-bold text-black-deep">Sistema de puntuación</h2>
                </div>
                <p class="text-sm text-titanium mb-5 ml-10">Define cuántos puntos recibe cada equipo por resultado. Los valores por defecto son los del fútbol estándar (3-1-0).</p>

                <div class="grid grid-cols-3 gap-4 ml-10">
                    <div class="text-center">
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Victoria</label>
                        <input wire:model="points_per_win" type="number" min="0" max="10"
                               class="w-full px-4 py-3 text-lg border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep text-center font-bold"/>
                        <p class="text-xs text-titanium/70 mt-1">Puntos al ganar</p>
                    </div>
                    <div class="text-center">
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Empate</label>
                        <input wire:model="points_per_draw" type="number" min="0" max="10"
                               class="w-full px-4 py-3 text-lg border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep text-center font-bold"/>
                        <p class="text-xs text-titanium/70 mt-1">Puntos al empatar</p>
                    </div>
                    <div class="text-center">
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Derrota</label>
                        <input wire:model="points_per_loss" type="number" min="0" max="10"
                               class="w-full px-4 py-3 text-lg border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep text-center font-bold"/>
                        <p class="text-xs text-titanium/70 mt-1">Puntos al perder</p>
                    </div>
                </div>

                <div class="ml-10 mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-blue-700">Estos puntos se usan para calcular la clasificación automáticamente en fases de tipo Liga o Grupos. En eliminatorias no se aplican.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- =========== SIDE COLUMN =========== --}}
        <div class="space-y-6">

            {{-- Status & visibility --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-bold text-black-deep flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    Configuración
                </h2>
                <p class="text-xs text-titanium mb-4">Controla el estado y visibilidad del torneo.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                        <select wire:model="status"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                            <option value="draft">Borrador — Aún no visible</option>
                            <option value="registration_open">Inscripción abierta — Aceptando equipos</option>
                            <option value="in_progress">En curso — Torneo activo</option>
                            <option value="completed">Completado — Torneo finalizado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                        <p class="text-xs text-titanium/70 mt-1">Te recomendamos empezar en "Borrador" y cambiarlo cuando todo esté listo.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Visibilidad</label>
                        <select wire:model="visibility"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                            <option value="private">Privado — Solo visible para la escuela</option>
                            <option value="public">Público — Visible para todos</option>
                        </select>
                        <p class="text-xs text-titanium/70 mt-1">Los torneos públicos pueden ser vistos por cualquier visitante en tu web.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Máximo de equipos <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <input wire:model="max_teams" type="number" min="2" max="512" placeholder="Sin límite"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        <p class="text-xs text-titanium/70 mt-1">Dejando vacío no hay límite de participantes.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Precio de inscripción <span class="text-titanium/50 normal-case font-normal">(opcional)</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-titanium text-sm font-semibold">€</span>
                            <input wire:model="registration_fee" type="number" min="0" step="0.01" placeholder="0.00"
                                   class="w-full pl-7 pr-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        </div>
                        @error('registration_fee') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-titanium/70 mt-1">Coste de inscripción por equipo. Dejar en blanco si es gratuito.</p>
                    </div>
                </div>
            </div>

            {{-- Logo upload --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-bold text-black-deep flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Logo del torneo
                </h2>
                <p class="text-xs text-titanium mb-4">Sube una imagen para identificar el torneo visualmente.</p>
                <div>
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="w-24 h-24 object-cover rounded-xl border border-silver mb-3 mx-auto"/>
                    @endif
                    <label class="flex flex-col items-center justify-center border-2 border-dashed border-silver rounded-xl p-5 cursor-pointer hover:border-primary/50 hover:bg-primary/5 transition-colors">
                        <svg class="w-8 h-8 text-titanium mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-xs font-semibold text-titanium">Haz clic para elegir imagen</span>
                        <span class="text-xs text-titanium/60 mt-0.5">PNG, JPG o SVG (max 2MB)</span>
                        <input wire:model="logo" type="file" accept="image/*" class="hidden"/>
                    </label>
                    @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Quick tips --}}
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-amber-800 flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    ¿Cómo funciona?
                </h3>
                <ol class="text-xs text-amber-800 space-y-1.5 list-decimal list-inside">
                    <li><strong>Crea el torneo</strong> con el nombre y datos básicos.</li>
                    <li><strong>Añade categorías</strong> (ej: Alevín, Infantil) para agrupar equipos.</li>
                    <li><strong>Inscribe equipos</strong> de tu escuela o equipos externos.</li>
                    <li><strong>Crea una fase</strong> (Liga, Eliminatoria, Grupos...).</li>
                    <li><strong>Genera los partidos</strong> automáticamente con un clic.</li>
                    <li><strong>Registra resultados</strong> haciendo clic en el marcador de cada partido.</li>
                </ol>
            </div>
        </div>
    </div>

    {{-- Mobile save button --}}
    <div class="lg:hidden mt-6">
        <button wire:click="save" wire:loading.attr="disabled"
                class="w-full inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow transition-colors disabled:opacity-60">
            <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
            <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Crear Torneo
        </button>
    </div>
</div>
