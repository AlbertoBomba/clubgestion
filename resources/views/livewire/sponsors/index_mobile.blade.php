<div class="min-h-screen bg-gray-50 pb-28 relative">

    {{-- ALERTAS FLASH --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 left-4 z-[60] bg-green-50 border-l-4 border-green-500 rounded-2xl p-4 shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <p class="text-xs font-bold text-green-800">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-20 right-4 left-4 z-[60] bg-red-50 border-l-4 border-red-500 rounded-2xl p-4 shadow-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-xs font-bold text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    {{-- APP HEADER Y BUSCADOR FIJOS (STICKY TOP-0) --}}
    <header class="sticky top-16  z-40 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 px-4 pt-3.5 pb-3 space-y-3">
        <div class="min-w-0 flex-1">
            @if($currentSeason)
                <p class="text-[11px] font-bold text-gray-400 truncate">
                    Temporada {{ $currentSeason->from_year }}/{{ $currentSeason->to_year }}
                </p>
            @else
                <p class="text-[10px] font-black text-red-500 uppercase tracking-wider">
                    ⚠️ Sin temporada activa
                </p>
            @endif
        </div>

        {{-- BARRA DE BÚSQUEDA FIJA --}}
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="text" placeholder="Buscar patrocinador..." 
                   class="w-full pl-10 pr-4 py-3 bg-gray-50/80 border border-gray-100 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white focus:outline-none transition-all placeholder-gray-400">
        </div>
    </header>

    <main class="p-4 space-y-4">

        {{-- GRID DE TARJETAS DE PATROCINADORES --}}
        @if($sponsors->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($sponsors as $sponsor)
                    <article class="sponsor-card bg-white-pure rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col justify-between">
                        
                        <div>
                            {{-- Cabecera de la Tarjeta (Tipo, Orden y Estados) --}}
                            <div class="p-3 bg-gray-50/60 border-b border-gray-100 flex items-center justify-between gap-2">
                                {{-- Badge Tipo de Patrocinador --}}
                                @php
                                    $sponsorType = config('constants.sponsors_type.' . $sponsor->type_id);
                                @endphp
                                @if($sponsorType)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shrink-0"></span>
                                        <span class="truncate">{{ $sponsorType }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-400 border border-gray-200/60 italic">
                                        Sin tipo
                                    </span>
                                @endif

                                {{-- Badges de Estado --}}
                                <div class="flex items-center gap-1.5 shrink-0">
                                    @if($currentSeason && $sponsor->season_id === $currentSeason->id)
                                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-800 text-[9px] font-black uppercase">Actual</span>
                                    @endif
                                    <span class="text-[10px] font-black text-gray-400 bg-gray-200/60 px-1.5 py-0.5 rounded-md">#{{ $sponsor->order + 1 }}</span>
                                </div>
                            </div>

                            {{-- Contenedor del Logo --}}
                            <div class="p-6 bg-white flex items-center justify-center min-h-[140px] relative">
                                @if($sponsor->logo)
                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" class="max-w-full max-h-28 object-contain">
                                @else
                                    <div class="w-20 h-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Información del Patrocinador --}}
                            <div class="p-4 border-t border-gray-50 text-center space-y-2">
                                <h3 class="font-black text-sm text-titanium line-clamp-2 leading-tight min-h-[2.5rem] flex items-center justify-center">
                                    {{ $sponsor->name }}
                                </h3>

                                <div class="flex items-center justify-center gap-3 text-xs">
                                    @if($sponsor->web)
                                        <a href="{{ $sponsor->web }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-blue-600 hover:underline text-[11px]">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            Visitar Web
                                        </a>
                                    @endif
                                    <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ $sponsor->season->from_year }}/{{ $sponsor->season->to_year }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción (Pie de Tarjeta) --}}
                        <div class="p-3 bg-gray-50/50 border-t border-gray-100 space-y-2">
                            @if($currentSeason && $sponsor->season_id === $currentSeason->id)
                                {{-- Switch Publicado --}}
                                <button wire:click="togglePublished({{ $sponsor->id }})" 
                                        class="w-full py-2 px-3 rounded-xl text-xs font-black transition-all flex items-center justify-center gap-1.5 active:scale-95 {{ $sponsor->published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                    <span class="w-2 h-2 rounded-full {{ $sponsor->published ? 'bg-green-600 animate-pulse' : 'bg-gray-400' }}"></span>
                                    <span>{{ $sponsor->published ? 'Publicado en Web' : 'No Publicado' }}</span>
                                </button>

                                {{-- Acciones Editar / Eliminar --}}
                                <div class="flex items-center gap-2">
                                    <button wire:click="openEditModal({{ $sponsor->id }})" 
                                            class="flex-1 py-2.5 bg-primary/10 text-primary font-bold text-xs rounded-xl active:scale-95 transition-all text-center flex items-center justify-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Editar
                                    </button>

                                    <button wire:click="confirmDelete({{ $sponsor->id }})" 
                                            class="flex-1 py-2.5 bg-red-50 text-red-600 font-bold text-xs rounded-xl active:scale-95 transition-all text-center flex items-center justify-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Eliminar
                                    </button>
                                </div>
                            @else
                                {{-- Alerta centrada: Sponsor caducado con icono parpadeante --}}
                                <div class="inline-flex items-center justify-center gap-1.5 px-3 py-1 bg-red-50 border border-red-200/80 rounded-full text-red-600 font-extrabold text-[11px] shadow-sm w-full">
                                    <svg class="w-4 h-4 text-red-500 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span>Sponsor caducado</span>
                                </div>
                                {{-- Botón de Renovación --}}
                                <button wire:click="openRenewModal({{ $sponsor->id }})" 
                                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black text-xs shadow-sm active:scale-95 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span>Renueva la</span>
                                    @if(!empty($currentSeason->season))
                                        <span class="px-2 py-0.5 bg-emerald-800/40 rounded font-extrabold">{{ $currentSeason->season }}</span>
                                    @endif
                                </button>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="bg-white-pure rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <p class="text-xs font-bold text-titanium mb-1">No se encontraron patrocinadores</p>
                <p class="text-[10px] text-gray-400">Intenta cambiar los términos de búsqueda o añade uno nuevo.</p>
            </div>
        @endif
    </main>

    {{-- BOTTOM APP BAR (Fijo Abajo) --}}
    <div class="fixed bottom-0 flex flex-col items-center gap-3 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-40">
        <button wire:click="openCreateModal" @if(!$currentSeason) disabled @endif
                class="w-full py-4 bg-blue-600 text-white font-black text-sm rounded-2xl active:scale-95 transition-all shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 disabled:opacity-50 disabled:active:scale-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Nuevo Patrocinador</span>
        </button>

        <h1 class="font-black text-lg text-titanium truncate leading-tight">
            {{ __('Patrocinadores') }}
        </h1>
    </div>


    {{-- ======================= MODALES MÓVILES (BOTTOM SHEETS) ======================= --}}

    {{-- MODAL DE RENOVACIÓN --}}
    @if($showRenewModal)
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showRenewModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="font-black text-lg text-emerald-700">Renovar Patrocinador</h3>
                    <button wire:click="$set('showRenewModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>
                <div class="p-5 overflow-y-auto space-y-4">
                    <p class="text-xs font-bold text-titanium leading-relaxed">
                        ¿Estás seguro de que deseas renovar el patrocinador <span class="text-primary font-black">"{{ $sponsorToRenew->name ?? '' }}"</span> para la temporada actual?
                    </p>
                </div>
                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button wire:click="$set('showRenewModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95">Cancelar</button>
                    <button wire:click="renew({{ $sponsorToRenew->id ?? '' }})" class="flex-[2] py-3.5 bg-emerald-600 text-white font-black text-xs rounded-2xl active:scale-95 shadow-md">Confirmar Renovación</button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL DE CREACIÓN / EDICIÓN --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('showModal', false)">
            <div class="bg-white-pure w-full max-h-[90vh] rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="font-black text-lg text-titanium">{{ $editMode ? 'Editar Patrocinador' : 'Nuevo Patrocinador' }}</h3>
                    <button wire:click="$set('showModal', false)" class="p-2 bg-gray-50 rounded-full text-gray-500 active:scale-95">✕</button>
                </div>

                <form wire:submit.prevent="save" class="flex-1 overflow-y-auto p-5 space-y-4">
                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre del Patrocinador *</label>
                        <input wire:model="name" type="text" id="name" placeholder="Ej: Empresa ABC"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Temporada & Tipo --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Temporada</label>
                            @if($currentSeason)
                                <div class="px-4 py-3 bg-gray-50 rounded-2xl text-xs font-bold text-titanium border border-gray-100">
                                    {{ $currentSeason->from_year }}/{{ $currentSeason->to_year }} <span class="text-[10px] font-normal text-gray-400">(En curso)</span>
                                </div>
                            @else
                                <div class="px-4 py-3 bg-red-50 text-red-600 rounded-2xl text-xs font-bold">⚠️ Sin temporada activa</div>
                            @endif
                        </div>

                        <div>
                            <label for="type" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tipo de Patrocinador *</label>
                            <select wire:model="type_id" id="type" 
                                    class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                                <option value="">Seleccionar Tipo...</option>
                                @foreach(config('constants.sponsors_type') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('type_id') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Subida de Logo --}}
                    <div>
                        <label for="logo" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fotografía / Logo</label>
                        <input wire:model="logo" type="file" id="logo" accept="image/*" 
                               class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                        @error('logo') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror

                        <div wire:loading wire:target="logo" class="text-xs font-bold text-primary flex items-center gap-1.5 my-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span>Procesando imagen...</span>
                        </div>

                        {{-- Previews --}}
                        @if($editMode && $existingLogo && !$logo)
                            <div class="mt-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Logo actual:</p>
                                <img src="{{ asset('storage/' . $existingLogo) }}" class="h-20 w-auto object-contain bg-gray-50 p-2 rounded-xl border border-gray-100">
                            </div>
                        @endif

                        @if($logo)
                            <div class="mt-3">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Vista previa:</p>
                                <img src="{{ $logo->temporaryUrl() }}" class="h-20 w-auto object-contain bg-gray-50 p-2 rounded-xl border border-gray-100">
                            </div>
                        @endif
                    </div>

                    {{-- Sitio Web --}}
                    <div>
                        <label for="web" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sitio Web</label>
                        <input wire:model="web" type="url" id="web" placeholder="https://www.ejemplo.com"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl text-xs font-bold text-titanium focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        @error('web') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Publicar --}}
                    <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-gray-100 bg-gray-50/50 cursor-pointer select-none">
                        <span class="text-xs font-bold text-titanium">Publicar en la web pública</span>
                        <input wire:model="published" type="checkbox" id="published" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                    </label>

                    {{-- Footer Modal submit escondido para activar con Enter --}}
                    <button type="submit" class="hidden"></button>
                </form>

                <div class="p-4 border-t border-gray-100 bg-white shrink-0 flex gap-2">
                    <button type="button" wire:click="$set('showModal', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95">Cancelar</button>
                    <button type="button" wire:click="save" wire:loading.attr="disabled" class="flex-[2] py-3.5 bg-blue-600 text-white font-black text-xs rounded-2xl active:scale-95 shadow-md flex justify-center items-center gap-1.5 disabled:opacity-50">
                        <span wire:loading.remove wire:target="save">{{ $editMode ? 'Actualizar' : 'Crear Patrocinador' }}</span>
                        <span wire:loading wire:target="save">Guardando...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL ELIMINAR --}}
    @if($confirmingDeletion)
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-sm" wire:keydown.window.escape="$set('confirmingDeletion', false)">
            <div class="bg-white-pure w-full rounded-t-3xl shadow-2xl flex flex-col overflow-hidden animate-slideUp p-6">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-black text-lg text-titanium text-center mb-2">¿Eliminar Patrocinador?</h3>
                <p class="text-xs font-bold text-gray-500 text-center mb-6 leading-relaxed">Esta acción no se puede deshacer. El patrocinador se borrará permanentemente.</p>
                <div class="flex gap-2 w-full">
                    <button wire:click="$set('confirmingDeletion', false)" class="flex-1 py-3.5 bg-gray-100 text-titanium font-black text-xs rounded-2xl active:scale-95">Cancelar</button>
                    <button wire:click="deleteSponsor" class="flex-1 py-3.5 bg-red-600 text-white font-black text-xs rounded-2xl active:scale-95 shadow-md">Eliminar</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-slideUp { animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
    </style>

</div>