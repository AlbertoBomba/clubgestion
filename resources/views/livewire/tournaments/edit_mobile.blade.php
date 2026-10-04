<div class="min-h-screen bg-[#F8F9FB] pb-24 relative">

    {{-- ================================================================ ALERTAS FLASH --}}
    @if (session('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 left-4 sm:left-auto z-[60] max-w-sm bg-green-50 border border-green-200 text-green-800 rounded-2xl px-4 py-3 text-sm font-bold shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="fixed top-4 right-4 left-4 sm:left-auto z-[60] max-w-sm bg-red-50 border border-red-200 text-red-700 rounded-2xl px-4 py-3 text-sm font-bold shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ================================================================ WRAPPER PRINCIPAL --}}
    <div class="w-full max-w-screen-xl ">

        {{-- BREADCRUMB & HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            {{-- <div>
                <nav class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                    <a href="{{ route('tournaments.index') }}" wire:navigate class="hover:text-blue-600 transition-colors">Torneos</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('tournaments.show', $tournament) }}" wire:navigate class="hover:text-blue-600 transition-colors truncate max-w-[120px] sm:max-w-none">{{ $tournament->name }}</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-900">Editar</span>
                </nav>
                
            </div> --}}
            
            {{-- Botones Escritorio (Ocultos en móvil, se muestran abajo) --}}
            <div class="hidden  sm:flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('tournaments.show', $tournament) }}" wire:navigate
                    class="px-5 py-2.5 rounded-xl bg-white border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
                        Cancelar
                    </a>
                    <button wire:click="save" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl shadow-sm transition-all disabled:opacity-60 disabled:scale-100 active:scale-95">
                        <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                        <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Guardar Cambios
                    </button>
                </div>
                
            </div>
        </div>

        {{-- ================================================================ FORMULARIO (GRID) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- COLUMNA PRINCIPAL (Izquierda) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- 1. Información Básica --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 sm:p-7">
                    <h2 class="text-sm font-black text-gray-900 flex items-center gap-2.5 mb-6">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        Información básica
                    </h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nombre del torneo *</label>
                            <input wire:model="name" type="text" placeholder="Ej: Torneo Verano 2026"
                                   class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                            @error('name') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Descripción</label>
                            <textarea wire:model="description" rows="3" placeholder="Opcional: detalles del torneo, normativas, etc."
                                      class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors resize-none"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Ubicación / Sede</label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <input wire:model="location" type="text" placeholder="Ej: Polideportivo Municipal"
                                       class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Fechas --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 sm:p-7">
                    <h2 class="text-sm font-black text-gray-900 flex items-center gap-2.5 mb-6">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        Fechas y plazos
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Inicio del Torneo</label>
                            <input wire:model="start_date" type="date"
                                   class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                            @error('start_date') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Fin del Torneo</label>
                            <input wire:model="end_date" type="date"
                                   class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                            @error('end_date') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Cierre de equipos</label>
                            <input wire:model="registration_deadline" type="date"
                                   class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                        </div>
                    </div>
                </div>

                {{-- 3. Normativa de jugadores y puntuación --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Restricciones --}}
                    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 sm:p-7">
                        <h2 class="text-sm font-black text-gray-900 flex items-center gap-2.5 mb-6">
                            <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            Normativa
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Máx. Jugadores/equipo</label>
                                <input wire:model="max_players_per_team" type="number" min="1" max="100" placeholder="Sin límite"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                                @error('max_players_per_team') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Edad mínima (Años)</label>
                                <input wire:model="min_age" type="number" min="1" max="100" placeholder="Sin límite"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                                @error('min_age') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Cierre Alta Jugadores</label>
                                <input wire:model="player_registration_deadline" type="date"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0 transition-colors"/>
                                @error('player_registration_deadline') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sistema de Puntuación --}}
                    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 sm:p-7 flex flex-col">
                        <h2 class="text-sm font-black text-gray-900 flex items-center gap-2.5 mb-6">
                            <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            Puntuación Liga/Grupos
                        </h2>
                        
                        <div class="space-y-4 flex-1">
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl border border-green-100">
                                <span class="text-xs font-bold text-green-800 uppercase">Victoria</span>
                                <div class="w-20">
                                    <input wire:model="points_per_win" type="number" min="0" max="10"
                                           class="w-full px-2 py-1.5 bg-white border border-green-200 rounded-lg text-center font-black text-green-700 focus:ring-0 focus:border-green-400"/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="text-xs font-bold text-gray-600 uppercase">Empate</span>
                                <div class="w-20">
                                    <input wire:model="points_per_draw" type="number" min="0" max="10"
                                           class="w-full px-2 py-1.5 bg-white border border-gray-300 rounded-lg text-center font-black text-gray-700 focus:ring-0 focus:border-gray-400"/>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl border border-red-100">
                                <span class="text-xs font-bold text-red-800 uppercase">Derrota</span>
                                <div class="w-20">
                                    <input wire:model="points_per_loss" type="number" min="0" max="10"
                                           class="w-full px-2 py-1.5 bg-white border border-red-200 rounded-lg text-center font-black text-red-700 focus:ring-0 focus:border-red-400"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- COLUMNA LATERAL (Derecha) --}}
            <div class="space-y-6">

                {{-- Estado y Visibilidad --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 sm:p-7">
                    <h2 class="text-sm font-black text-gray-900 flex items-center gap-2.5 mb-6">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        </div>
                        Configuración general
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Estado del Torneo</label>
                            <select wire:model="status" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0">
                                <option value="draft">Borrador (Oculto)</option>
                                <option value="registration_open">Inscripción abierta</option>
                                <option value="in_progress">En curso</option>
                                <option value="completed">Completado</option>
                                <option value="cancelled">Cancelado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Privacidad web</label>
                            <select wire:model="visibility" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0">
                                <option value="public">Público (Visible en la web)</option>
                                <option value="private">Privado (Solo administradores)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Tipo de inscripción</label>
                            <select wire:model="team_type" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-500 focus:ring-0">
                                <option value="">Mixto (Escuela + Externos)</option>
                                <option value="school_teams">Solo equipos de la Escuela</option>
                                <option value="open">Torneo Abierto (Solo Externos)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Máx. Equipos</label>
                                <input wire:model="max_teams" type="number" min="2" max="512"
                                       class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 text-center focus:bg-white focus:border-blue-500 focus:ring-0"/>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Precio (€)</label>
                                <input wire:model="registration_fee" type="number" min="0" step="0.01" placeholder="0.00"
                                       class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-900 text-center focus:bg-white focus:border-blue-500 focus:ring-0"/>
                                @error('registration_fee') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Logo / Imagen --}}
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-5 sm:p-7 text-center">
                    <h2 class="text-sm font-black text-gray-900 mb-4">Logo del Torneo</h2>
                    
                    <div class="mb-4 flex justify-center">
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-2xl border-2 border-blue-100 shadow-sm"/>
                        @elseif ($tournament->logo)
                            <img src="{{ Storage::url($tournament->logo) }}" alt="{{ $tournament->name }}" class="w-32 h-32 object-cover rounded-2xl border-2 border-gray-100 shadow-sm"/>
                        @else
                            <div class="w-32 h-32 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    
                    <label class="inline-flex w-full items-center justify-center bg-blue-50 text-blue-700 border border-blue-100 rounded-xl px-4 py-3 cursor-pointer hover:bg-blue-100 transition-colors font-bold text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        {{ $tournament->logo ? 'Cambiar imagen' : 'Subir logo (Max 2MB)' }}
                        <input wire:model="logo" type="file" accept="image/*" class="hidden"/>
                    </label>
                    @error('logo') <p class="text-red-500 text-[10px] font-bold mt-2">{{ $message }}</p> @enderror
                </div>
                
            </div>
        </div>

    </div>

    {{-- ================================================================ BOTTOM APP BAR (ACCIONES MOVILES) ================================================================ --}}
    <div class="sm:hidden  flex-col  fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-40 flex items-center gap-3">
        <div class="flex items-center gap-3 mb-4 w-full">
            <a href="{{ route('tournaments.show', $tournament) }}" wire:navigate class="w-14 h-14 bg-gray-100 text-gray-500 rounded-2xl flex items-center justify-center font-black active:scale-95 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <button wire:click="save" wire:loading.attr="disabled" class="flex-1 h-14 bg-blue-600 text-white rounded-2xl font-black text-sm active:scale-95 transition-transform flex items-center justify-center gap-2 shadow-sm disabled:opacity-60">
                <svg wire:loading wire:target="save" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Guardar Cambios
            </button>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">Ajustes del Torneo</h1>
    </div>

</div>