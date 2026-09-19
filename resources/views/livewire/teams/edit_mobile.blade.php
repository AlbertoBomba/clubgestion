<div class="min-h-screen bg-gray-50 pb-28 relative">

    {{-- ALERTAS FLASH --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="m-4 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-2xl shadow-sm">
            <p class="text-sm text-neon-green font-bold">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="m-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl shadow-sm">
            <p class="text-sm text-red-700 font-bold">{{ session('error') }}</p>
        </div>
    @endif

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100 px-4 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-2.5 min-w-0">
            <a href="{{ route('teams.index') }}" 
               class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="min-w-0">
                <h2 class="font-black text-base text-titanium truncate leading-tight">
                    {{ $teamName }}
                </h2>
                <p class="text-[11px] font-bold text-gray-400">
                    Edición de equipo
                </p>
            </div>
        </div>

        @if($federate)
            <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-extrabold text-[10px] uppercase tracking-wider flex-shrink-0 flex items-center gap-1">
                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Federado
            </span>
        @endif
    </header>

    <div class="p-4 space-y-4">

        {{-- ALERTA CAMBIOS SIN GUARDAR --}}
        @if($hasChanges)
            <div class="p-4 bg-yellow-500/10 border-l-4 border-yellow-500 rounded-2xl flex items-center gap-3 animate-pulse">
                <span class="text-lg">⚠️</span>
                <p class="text-xs font-bold text-yellow-800">
                    Tienes cambios sin guardar. Toca en <span class="underline">Actualizar</span> abajo para guardarlos.
                </p>
            </div>
        @endif

        {{-- FORMULARIO PRINCIPAL DE EQUIPO --}}
        <form wire:submit.prevent="save" id="team-form" class="space-y-4">

            {{-- BLOQUE 1: DATOS DEL EQUIPO E IMAGEN --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-base text-titanium pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Datos del Equipo
                </h3>

                {{-- Imagen del Equipo --}}
                <div class="space-y-2 text-center">
                    <span class="block text-xs font-bold text-titanium uppercase tracking-wider text-left">Imagen del Equipo</span>
                    
                    <div class="relative inline-block w-full">
                        @if($teamImage)
                            <img src="{{ $teamImage->temporaryUrl() }}" class="w-full h-36 rounded-2xl object-cover border-2 border-primary shadow-sm">
                        @elseif($team->team_image)
                            <img src="{{ asset('storage/' . $team->team_image) }}" class="w-full h-36 rounded-2xl object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="w-full h-36 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-semibold">Sin imagen asignada</span>
                            </div>
                        @endif
                    </div>

                    <label class="block w-full py-3 bg-gray-100 text-titanium font-bold text-xs rounded-2xl active:scale-95 text-center cursor-pointer">
                        📷 Seleccionar Nueva Imagen
                        <input type="file" wire:model.live="teamImage" accept="image/*" class="hidden">
                    </label>
                    @error('teamImage') <span class="text-red-500 text-xs block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Campos de texto --}}
                <div class="space-y-3 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Nombre del Equipo *</label>
                        <input wire:model.live="teamName" type="text" 
                               class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('teamName') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Descripción</label>
                        <input wire:model.live="description" type="text" 
                               class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        @error('description') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Categoría *</label>
                            <select wire:model.live="category_id" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                                <option value="">Seleccionar...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Género *</label>
                            <select wire:model.live="gender" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="mixto">Mixto</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Temporada</label>
                            <input type="text" value="{{ $seasons->firstWhere('id', $season_id)?->season ?? 'No asignada' }}" disabled
                                   class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-2xl text-sm font-semibold cursor-not-allowed border-0">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Sección</label>
                            <input type="text" value="{{ $sections->firstWhere('id', $section_id)?->name ?? 'No asignada' }}" disabled
                                   class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-2xl text-sm font-semibold cursor-not-allowed border-0">
                        </div>
                    </div>

                    {{-- Precio de Matrícula --}}
                    <div>
                        <label class="block text-xs font-bold text-titanium uppercase tracking-wider mb-1">Precio Matrícula (€)</label>
                        @if($team->payments_count > 0)
                            <input type="text" value="{{ $price }}" disabled
                                   class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-2xl text-sm font-bold cursor-not-allowed border-0">
                            <p class="text-[11px] text-blue-700 font-semibold mt-1">Este equipo tiene {{ $team->payments_count }} pagos generados. Precio bloqueado.</p>
                        @else
                            <input wire:model.live="price" type="text" inputmode="decimal" placeholder="0.00"
                                   class="w-full px-4 py-3 border-0 rounded-2xl text-black-deep text-sm font-black focus:ring-2 {{ empty($price) || $price == 0 ? 'bg-amber-50 text-amber-900 ring-1 ring-amber-300' : 'bg-gray-50 focus:ring-primary' }}">
                            @error('price') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            @if(empty($price) || $price == 0)
                                <p class="text-[11px] text-amber-700 font-bold mt-1">⚠️ No se generará orden de pago si la matrícula es 0.</p>
                            @endif
                        @endif
                    </div>

                    {{-- Checkboxes Opciones --}}
                    <div class="space-y-2 pt-2">
                        <label class="flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer select-none @if($federate) border-primary bg-blue-50/60 @else border-gray-100 bg-gray-50/50 @endif">
                            <input type="checkbox" wire:model.live="federate" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="text-sm font-bold text-titanium">Equipo Federado</span>
                        </label>

                        <label class="flex items-center gap-3 p-3.5 rounded-2xl border-2 transition-all cursor-pointer select-none @if($published) border-green-500 bg-green-50/60 @else border-gray-100 bg-gray-50/50 @endif">
                            <input type="checkbox" wire:model.live="published" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-600">
                            <span class="text-sm font-bold text-titanium">Publicar en Web Pública</span>
                        </label>
                    </div>
                </div>
            </section>

            {{-- BLOQUE 2: ENTRENADORES --}}
            <section class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <h3 class="font-bold text-base text-titanium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Entrenadores ({{ $assignedCoaches->count() }})
                    </h3>
                    <button type="button" wire:click="openAddCoachModal" 
                            class="px-3 py-1.5 bg-primary text-white rounded-xl text-xs font-bold active:scale-95 transition-all">
                        + Asignar
                    </button>
                </div>

                @if($assignedCoaches->isEmpty())
                    <p class="text-xs text-gray-400 text-center py-3">Sin entrenadores asignados a este equipo.</p>
                @else
                    <div class="space-y-2">
                        @foreach($assignedCoaches as $coach)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if($coach->profile_photo_path)
                                        <img src="{{ asset('storage/' . $coach->profile_photo_path) }}" class="w-9 h-9 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ substr($coach->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-xs text-titanium truncate">{{ $coach->name }}</p>
                                        <p class="text-[10px] text-gray-400 truncate">{{ $coach->email }}</p>
                                    </div>
                                </div>
                                <button type="button" wire:click="confirmRemoveCoach({{ $coach->id }})" class="p-2 text-red-600 bg-red-50 rounded-xl active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </form>

        {{-- BLOQUE 3: JUGADORES DEL EQUIPO (Sustituyendo tabla por Cards) --}}
        <section class="space-y-3 pt-2">
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-base text-titanium flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Jugadores ({{ $teamPlayers->count() }})
                    </h3>

                    <button type="button" wire:click="openAddPlayerModal" wire:loading.attr="disabled" wire:target="openAddPlayerModal"
                            class="px-3.5 py-2 bg-primary text-white font-bold text-xs rounded-xl active:scale-95 transition-all flex items-center gap-1.5 shadow-sm">
                        <svg wire:loading.remove wire:target="openAddPlayerModal" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Agregar</span>
                    </button>
                </div>

                {{-- Buscador e Exportación --}}
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="search" wire:model.live.debounce.300ms="searchPlayer" placeholder="Buscar por nombre o DNI..."
                               class="w-full pl-9 pr-3 py-2.5 bg-white-pure border border-gray-100 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <button type="button" wire:click="openPdfModal" class="px-3 py-2.5 bg-green-50 text-green-700 font-bold text-xs rounded-2xl active:scale-95 transition-all flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        PDF / Excel
                    </button>
                </div>
            </div>

            {{-- LISTA DE TARJETAS DE JUGADORES (Sustituye a la tabla) --}}
            @if($teamPlayers->isEmpty())
                <div class="bg-white-pure rounded-3xl p-8 text-center border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400">No hay jugadores asignados a este equipo.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($teamPlayers as $player)
                        <article class="bg-white-pure rounded-3xl p-4 shadow-sm border border-gray-100 space-y-3">
                            
                            {{-- Fila 1: Foto, Nombre, Apellidos y Estado --}}
                            <div class="flex items-center gap-3">
                                {{-- 1. Foto --}}
                                <div class="flex-shrink-0">
                                    @if($player->player_photo)
                                        <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shadow-sm">
                                            {{ substr($player->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- 2. Nombre y apellido jugador --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-sm text-titanium truncate leading-snug">
                                        {{ $player->name }} {{ $player->surname }}
                                    </h4>
                                    <p class="text-[11px] font-semibold text-gray-400 truncate">
                                        DNI: {{ $player->dni ?: '-' }} @if($player->dorsal) • Dorsal: #{{ $player->dorsal }} @endif
                                    </p>
                                </div>

                                {{-- 5. Estado --}}
                                <div class="flex-shrink-0">
                                    @if($player->active)
                                        <span class="px-2.5 py-1 rounded-full bg-neon-green/10 text-neon-green text-[10px] font-extrabold uppercase tracking-wider">Activo</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-extrabold uppercase tracking-wider">Inactivo</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Fila 2: Ficha y Fecha de nacimiento --}}
                            <div class="grid grid-cols-2 gap-2 bg-gray-50 rounded-2xl p-2.5 text-xs">
                                {{-- 3. Ficha --}}
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Ficha</span>
                                    @if($player->file)
                                        <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 text-[10px] font-bold inline-block">Completa</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-[10px] font-bold inline-block">Incompleta</span>
                                    @endif
                                </div>

                                {{-- 4. Fecha de nacimiento --}}
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Fecha Nacimiento</span>
                                    <span class="font-extrabold text-titanium text-xs block">
                                        {{ $player->dbirth ? $player->dbirth->format('d/m/Y') : '-' }}
                                    </span>
                                    @if($player->dbirth)
                                        <span class="text-[10px] text-gray-400 block font-semibold">
                                            {{ \Carbon\Carbon::parse($player->dbirth)->age }} años
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Observaciones del jugador (si existen) --}}
                            @if(!empty($player->observations))
                                <div class="p-2 bg-red-50 border border-red-100 rounded-xl text-xs font-semibold text-red-700 flex items-center gap-1.5">
                                    <span class="text-sm">⚠️</span>
                                    <span class="truncate">{{ $player->observations }}</span>
                                </div>
                            @endif

                            {{-- Botones de Acción de la tarjeta --}}
                            <div class="flex items-center gap-1.5 pt-1 border-t border-gray-50">
                                <button type="button" wire:click="openEditPlayerModal({{ $player->id }})"
                                        class="flex-1 py-2.5 bg-amber-50 text-amber-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Editar
                                </button>

                                @if($player->player_photo || !empty($player->documents))
                                    <button type="button" wire:click="downloadPlayerDocuments({{ $player->id }})" 
                                            class="flex-1 py-2.5 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                        Docs
                                    </button>
                                @endif

                                <button type="button" wire:click="openMovePlayerModal({{ $player->id }})" 
                                        class="flex-1 py-2.5 bg-blue-50 text-blue-700 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Mover
                                </button>

                                <button type="button" wire:click="confirmRemovePlayer({{ $player->id }})" 
                                        class="py-2.5 px-3 bg-red-50 text-red-600 font-bold text-xs rounded-xl active:scale-95 transition-all text-center">
                                    Quitar
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    {{-- BOTTOM APP BAR (Acciones globales fijas abajo) --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-2">
        <a href="{{ route('teams.index') }}" 
           class="py-4 px-4 bg-gray-100 text-titanium font-bold text-sm rounded-2xl active:scale-95 transition-all text-center flex items-center justify-center">
            Salir
        </a>

        @if($team->payments_count > 0 || $team->players->count() > 0)
            <button disabled class="py-4 px-4 bg-gray-200 text-gray-400 font-bold text-sm rounded-2xl cursor-not-allowed text-center" title="No se puede eliminar con jugadores o pagos">
                Eliminar
            </button>
        @else
            <button wire:click="confirmDelete" wire:loading.attr="disabled"
                    class="py-4 px-4 bg-red-50 text-red-600 font-bold text-sm rounded-2xl active:scale-95 transition-all text-center">
                Eliminar
            </button>
        @endif

        <button type="submit" form="team-form" wire:loading.attr="disabled" wire:target="save"
                class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-base active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex justify-center items-center gap-2">
            <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            <span wire:loading.remove wire:target="save">Actualizar</span>
            <span wire:loading wire:target="save">Guardando...</span>
        </button>
    </div>

    {{-- ============================================================== --}}
    {{-- MODALES CONVERTIDOS A <x-dialog-modal> (Soporte Anti-Crash)   --}}
    {{-- ============================================================== --}}

    {{-- Modal Eliminar Equipo --}}
    <x-dialog-modal wire:model="confirmingDeletion" maxWidth="sm">
        <x-slot name="title"><span class="font-bold text-red-600">Eliminar Equipo</span></x-slot>
        <x-slot name="content">
            <p class="text-xs font-semibold text-gray-600">¿Estás seguro de que deseas eliminar el equipo <strong>{{ $teamName }}</strong>? Esta acción no se puede deshacer.</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button wire:click="deleteTeam" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Eliminar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Quitar Jugador del Equipo --}}
    <x-dialog-modal wire:model.live="confirmingPlayerRemoval" maxWidth="2xl">
        <x-slot name="title"><span class="font-bold text-red-600">Quitar Jugador del Equipo</span></x-slot>
        <x-slot name="content">
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                <div class="p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded-xl text-xs font-semibold text-yellow-800">
                    El jugador será quitado del equipo. Las cartas de pago pendientes asociadas se eliminarán.
                </div>

                @if(!empty($paymentsToDeleteRemove) && count($paymentsToDeleteRemove) > 0)
                    <div class="border border-red-200 rounded-2xl bg-red-50/50 p-3 space-y-2">
                        <span class="text-xs font-bold text-red-800 uppercase block">Cartas de pago a eliminar ({{ count($paymentsToDeleteRemove) }})</span>
                        @foreach($paymentsToDeleteRemove as $payment)
                            <div class="bg-white p-2.5 rounded-xl border border-red-100 text-xs flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-gray-800">Cuota {{ $payment['cuota'] }} - {{ $payment['description'] }}</p>
                                    <p class="text-[10px] text-gray-400">Ref: {{ $payment['code'] }}</p>
                                </div>
                                <span class="font-black text-red-600">{{ number_format($payment['amount'], 2) }}€</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelRemovePlayer" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="removePlayer" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar Quitar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Mover Jugador --}}
    <x-dialog-modal wire:model.live="showMovePlayerModal" maxWidth="lg">
        <x-slot name="title"><span class="font-bold text-titanium">Mover Jugador</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3">
                @if($playerToMoveName)
                    <p class="text-xs font-bold text-gray-500">Moviendo a: <span class="text-primary">{{ $playerToMoveName }}</span></p>
                @endif

                @if($availableTeams->isEmpty())
                    <p class="text-xs text-amber-800 bg-amber-50 p-3 rounded-xl border border-amber-200">No hay otros equipos disponibles en esta temporada y sección.</p>
                @else
                    <label class="block text-xs font-bold text-titanium uppercase tracking-wider">Equipo destino *</label>
                    <select wire:model.live="targetTeamId" class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-black-deep text-sm font-semibold focus:ring-2 focus:ring-primary focus:bg-white">
                        <option value="">Seleccione un equipo...</option>
                        @foreach($availableTeams as $availableTeam)
                            <option value="{{ $availableTeam->id }}">{{ $availableTeam->team }}</option>
                        @endforeach
                    </select>
                    @error('targetTeamId') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelMovePlayer" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="movePlayer" wire:loading.attr="disabled" :disabled="$availableTeams->isEmpty() || !$targetTeamId" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50">Mover Jugador</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Agregar Jugadores --}}
    <x-dialog-modal wire:model.live="showAddPlayerModal" maxWidth="2xl">
        <x-slot name="title"><span class="font-bold text-titanium">Agregar Jugadores al Equipo</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                <input type="search" wire:model.live.debounce.300ms="searchAvailablePlayer" placeholder="Buscar por nombre o DNI..."
                       class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">

                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" wire:model.live="filterByCategory" class="w-4 h-4 text-primary border-gray-300 rounded">
                    <span class="text-xs font-bold text-gray-600">Filtrar solo por categoría del equipo</span>
                </label>

                @if($availablePlayers->isEmpty())
                    <p class="text-xs text-amber-800 bg-amber-50 p-3 rounded-xl border border-amber-200">No se encontraron jugadores disponibles.</p>
                @else
                    <div class="space-y-2 pt-1">
                        @foreach($availablePlayers as $player)
                            <label wire:key="available-player-{{ $player->id }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl border border-gray-100 cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedPlayersToAdd" value="{{ $player->id }}" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-xs text-titanium truncate">{{ $player->name }} {{ $player->surname }}</p>
                                    <p class="text-[10px] text-gray-400">DNI: {{ $player->dni ?: '-' }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelAddPlayer" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="addPlayersToTeam" wire:loading.attr="disabled" :disabled="empty($selectedPlayersToAdd)" class="flex-1 py-3 bg-primary text-white font-bold text-sm rounded-xl active:scale-95 disabled:opacity-50">Agregar Seleccionados</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Editar Jugador Rápido --}}
    @if($showEditPlayerModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closeEditPlayerModal"></div>
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-lg p-5 shadow-2xl z-10 flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-shrink-0">
                    <h3 class="font-black text-base text-titanium">Editar Jugador</h3>
                    <button type="button" wire:click="closeEditPlayerModal" class="p-2 text-gray-400">✕</button>
                </div>

                <div class="overflow-y-auto flex-1 py-3 space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Nombre *</label>
                            <input type="text" wire:model.defer="editPlayerName" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Apellidos *</label>
                            <input type="text" wire:model.defer="editPlayerSurname" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">DNI</label>
                            <input type="text" wire:model.defer="editPlayerDni" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Fecha Nac.</label>
                            <input type="date" wire:model.defer="editPlayerDbirth" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Año Nac.</label>
                            <input type="number" wire:model.defer="editPlayerDbanio" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Dorsal</label>
                            <input type="number" wire:model.defer="editPlayerShirtNumber" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Talla</label>
                            <button type="button" wire:click="openSizesModal" class="w-full py-2.5 bg-primary/10 text-primary font-bold text-xs rounded-xl truncate">
                                {{ $editPlayerSize ?: 'Talla' }}
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-titanium uppercase mb-1">Observaciones</label>
                        <textarea wire:model.live="observations" rows="2" class="w-full px-3 py-2.5 bg-gray-50 border-0 rounded-xl text-xs font-semibold resize-none"></textarea>
                    </div>
                </div>

                <div class="pt-3 flex gap-2 flex-shrink-0">
                    <button type="button" wire:click="closeEditPlayerModal" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-xs rounded-xl">Cancelar</button>
                    <button type="button" wire:click="updatePlayer" wire:loading.attr="disabled" class="flex-1 py-3 bg-amber-600 text-white font-bold text-xs rounded-xl active:scale-95">Guardar Cambios</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Exportación PDF / Excel --}}
    @if($showPdfModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="closePdfModal"></div>
            <div class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-lg p-5 shadow-2xl z-10 flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 flex-shrink-0">
                    <h3 class="font-black text-base text-titanium">Exportar Listado de Jugadores</h3>
                    <button type="button" wire:click="closePdfModal" class="p-2 text-gray-400">✕</button>
                </div>

                <div class="overflow-y-auto flex-1 py-3 space-y-2">
                    <p class="text-xs font-semibold text-gray-500 mb-2">Selecciona las columnas a incluir:</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($availableColumns as $key => $label)
                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-gray-100 bg-gray-50 text-xs font-bold cursor-pointer">
                                <input type="checkbox" wire:model.live="selectedColumns" value="{{ $key }}" class="w-4 h-4 text-green-600 border-gray-300 rounded">
                                <span class="truncate">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-3 flex gap-2 flex-shrink-0">
                    <button type="button" wire:click="generateExcel" :disabled="empty($selectedColumns)" class="flex-1 py-3 bg-emerald-600 text-white font-bold text-xs rounded-xl active:scale-95 disabled:opacity-50">Excel</button>
                    <button type="button" wire:click="generatePdf" :disabled="empty($selectedColumns)" class="flex-1 py-3 bg-green-600 text-white font-bold text-xs rounded-xl active:scale-95 disabled:opacity-50">PDF</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Añadir Entrenador --}}
    <x-dialog-modal wire:model.live="showAddCoachModal" maxWidth="lg">
        <x-slot name="title"><span class="font-bold text-titanium">Añadir Entrenador</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1">
                <input type="search" wire:model.live.debounce.300ms="searchCoach" placeholder="Buscar por nombre o email..."
                       class="w-full px-4 py-3 bg-gray-50 border-0 rounded-2xl text-xs font-semibold focus:ring-2 focus:ring-primary focus:bg-white">

                @if($availableCoaches->isEmpty())
                    <p class="text-xs text-amber-800 bg-amber-50 p-3 rounded-xl border border-amber-200">No hay entrenadores disponibles.</p>
                @else
                    <div class="space-y-2 pt-1">
                        @foreach($availableCoaches as $coach)
                            <div wire:key="available-coach-{{ $coach->id }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-xs text-titanium truncate">{{ $coach->name }}</p>
                                    <p class="text-[10px] text-gray-400 truncate">{{ $coach->email }}</p>
                                </div>
                                <button type="button" wire:click="addCoach({{ $coach->id }})" class="px-3 py-1.5 bg-primary text-white font-bold text-xs rounded-xl active:scale-95">Añadir</button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <button type="button" wire:click="closeAddCoachModal" class="w-full py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cerrar</button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal Confirmación Quitar Entrenador --}}
    <x-dialog-modal wire:model.live="confirmingCoachRemoval" maxWidth="sm">
        <x-slot name="title"><span class="font-bold text-red-600">Quitar Entrenador</span></x-slot>
        <x-slot name="content">
            <p class="text-xs font-semibold text-gray-600">¿Está seguro de quitar a este entrenador del equipo? No se borrará el usuario.</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="cancelRemoveCoach" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="removeCoach" wire:loading.attr="disabled" class="flex-1 py-3 bg-red-600 text-white font-bold text-sm rounded-xl active:scale-95">Quitar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- MODAL PREVISUALIZACIÓN DE CAMBIOS EN PAGOS (GLOBAL) --}}
    <x-dialog-modal wire:model="showPreviewModal" maxWidth="2xl">
        <x-slot name="title"><span class="font-bold text-blue-600">Cambios en Pagos</span></x-slot>
        <x-slot name="content">
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-1 text-xs">
                @if(!empty($paymentsPaid) && count($paymentsPaid) > 0)
                    <p class="text-green-700 font-bold">✅ {{ count($paymentsPaid) }} pagos realizados se mantendrán.</p>
                @endif
                @if(!empty($paymentsToDelete) && count($paymentsToDelete) > 0)
                    <p class="text-red-700 font-bold">🗑️ {{ count($paymentsToDelete) }} pagos pendientes se eliminarán.</p>
                @endif
                @if(!empty($paymentsToCreate) && count($paymentsToCreate) > 0)
                    <p class="text-blue-700 font-bold">➕ {{ count($paymentsToCreate) }} nuevas cartas de pago se generarán.</p>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2 w-full mt-2">
                <button type="button" wire:click="$set('showPreviewModal', false)" class="flex-1 py-3 bg-gray-100 text-titanium font-bold text-sm rounded-xl">Cancelar</button>
                <button type="button" wire:click="confirmPaymentsAction" wire:loading.attr="disabled" class="flex-1 py-3 bg-blue-600 text-white font-bold text-sm rounded-xl active:scale-95">Confirmar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- SCRIPTS DE LIMPIEZA DE OVERFLOW Y SCROLL --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
            });
        });
    </script>
</div>