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
                Guardar Torneo
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Basic info --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-black-deep flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Información básica
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Nombre del torneo *</label>
                        <input wire:model="name" type="text" placeholder="Ej: Copa Primavera 2026"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Descripción</label>
                        <textarea wire:model="description" rows="3" placeholder="Descripción o reglas del torneo..."
                                  class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Ubicación / Sede</label>
                        <input wire:model="location" type="text" placeholder="Ej: Polideportivo Municipal"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                    </div>
                </div>
            </div>

            {{-- Dates --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-black-deep flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Fechas
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Inicio</label>
                        <input wire:model="start_date" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                        @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Fin</label>
                        <input wire:model="end_date" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                        @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Cierre inscripción</label>
                        <input wire:model="registration_deadline" type="date"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep"/>
                    </div>
                </div>
            </div>

            {{-- Scoring system --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-black-deep flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Sistema de puntuación
                </h2>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Victoria</label>
                        <input wire:model="points_per_win" type="number" min="0" max="10"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep text-center font-bold"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Empate</label>
                        <input wire:model="points_per_draw" type="number" min="0" max="10"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep text-center font-bold"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Derrota</label>
                        <input wire:model="points_per_loss" type="number" min="0" max="10"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep text-center font-bold"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- Side column --}}
        <div class="space-y-6">

            {{-- Status & visibility --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-black-deep flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    Configuración
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Estado</label>
                        <select wire:model="status"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                            <option value="draft">Borrador</option>
                            <option value="registration_open">Inscripción abierta</option>
                            <option value="in_progress">En curso</option>
                            <option value="completed">Completado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Visibilidad</label>
                        <select wire:model="visibility"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                            <option value="private">Privado</option>
                            <option value="public">Público</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Máx. equipos</label>
                        <input wire:model="max_teams" type="number" min="2" max="512" placeholder="Sin límite"
                               class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep placeholder-titanium"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-titanium uppercase tracking-wide mb-1.5">Temporada</label>
                        <select wire:model="season_id"
                                class="w-full px-4 py-2.5 text-sm border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white-pure text-black-deep">
                            <option value="">Sin temporada</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Logo upload --}}
            <div class="bg-white-pure border border-silver rounded-2xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-black-deep flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Logo
                </h2>
                <div>
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="w-24 h-24 object-cover rounded-xl border border-silver mb-3 mx-auto"/>
                    @endif
                    <label class="flex flex-col items-center justify-center border-2 border-dashed border-silver rounded-xl p-4 cursor-pointer hover:border-primary/50 transition-colors">
                        <svg class="w-7 h-7 text-titanium mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-xs text-titanium">Subir imagen (max 2MB)</span>
                        <input wire:model="logo" type="file" accept="image/*" class="hidden"/>
                    </label>
                    @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>
</div>
