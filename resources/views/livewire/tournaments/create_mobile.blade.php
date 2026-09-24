<div class="min-h-screen bg-white pb-28 relative">

    {{-- APP HEADER (Fijo arriba) --}}
    <header class="sticky top-0 z-40 bg-white-pure shadow-sm border-b border-gray-100">
        <div class="px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                @if($currentStep > 1)
                    <button wire:click="previousStep" type="button" 
                            class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                @else
                    <a href="{{ route('tournaments.index') }}" wire:navigate 
                       class="p-2 rounded-full bg-gray-50 text-gray-600 active:scale-95 transition-all flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
                <div class="min-w-0">
                    
                    <p class="text-[11px] font-bold text-primary tracking-wide uppercase mt-0.5">
                        Paso {{ $currentStep }} de 4
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Barra de Progreso Fina --}}
        <div class="w-full bg-gray-100 h-1">
            <div class="bg-primary h-1 transition-all duration-300 ease-out" style="width: {{ ($currentStep / 4) * 100 }}%"></div>
        </div>
    </header>

    <main class="p-4 space-y-4">

        {{-- ==================== STEP 1: DATOS GENERALES ==================== --}}
        @if($currentStep == 1)
            <div class="animate-fadeIn space-y-4">
                <div class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-black text-lg text-titanium mb-5 text-center">Información General</h3>
                    
                   

                    {{-- Formulario Step 1 --}}
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nombre del Torneo <span class="text-red-500 text-sm">*</span></label>
                            <input wire:model="name" type="text" placeholder="Ej: Champions League Alevín"
                                   class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-bold transition-all"/>
                            @error('name') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Sede / Ubicación</label>
                            <input wire:model="location" type="text" placeholder="Ej: Instalaciones Municipales"
                                   class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Fecha Inicio</label>
                                <input wire:model="start_date" type="date"
                                       class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                                @error('start_date') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Fecha Fin</label>
                                <input wire:model="end_date" type="date"
                                       class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                                @error('end_date') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                     {{-- Upload Logo --}}
                    <div class="flex flex-col items-center ">
                        @if ($logo)
                            <div class="relative group mb-2">
                                <img src="{{ $logo->temporaryUrl() }}" class="w-28 h-28 object-cover rounded-3xl border-4 border-white shadow-md"/>
                                <button wire:click="$set('logo', null)" class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md active:scale-95 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        @else
                            <label class="flex flex-col items-center justify-center w-28 h-28 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer active:bg-gray-50 bg-gray-50/50 mb-2 transition-colors">
                                <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Logo</span>
                                <input wire:model="logo" type="file" accept="image/*" class="hidden"/>
                            </label>
                        @endif
                        @error('logo') <p class="text-red-500 text-[10px] font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- ==================== STEP 2: REGLAS ==================== --}}
        @if($currentStep == 2)
            <div class="animate-fadeIn space-y-4">
                
                {{-- Badge Fijo de Tipo de Torneo --}}
                {{-- <div class="bg-blue-50 border border-blue-100 rounded-3xl p-4 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="font-black text-blue-900 text-sm">Tipo de Torneo</p>
                        <p class="text-[10px] font-bold text-blue-700 mt-0.5">Torneo abierto a todos.</p>
                    </div>
                    <span class="bg-blue-600 text-white text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">Open</span>
                </div> --}}

                <div class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100 space-y-4">
                    <h3 class="font-black text-lg text-titanium mb-4 text-center">Inscripción y Límites</h3>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Límite Equipos</label>
                            <input wire:model="max_teams" type="number" min="2" placeholder="Ilimitado"
                                   class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                            @error('max_teams') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Jugadores / Eq.</label>
                            <input wire:model="max_players_per_team" type="number" min="1" placeholder="Ej: 15"
                                   class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                            @error('max_players_per_team') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Edad Mínima</label>
                            <div class="relative">
                                <input wire:model="min_age" type="number" min="1" placeholder="Sin límite"
                                       class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-[10px] uppercase">Años</span>
                            </div>
                            @error('min_age') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Precio Inscripción</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-black text-sm">€</span>
                                <input wire:model="registration_fee" type="number" step="0.01" min="0" placeholder="0.00"
                                       class="w-full pl-7 pr-3 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-black transition-all"/>
                            </div>
                            @error('registration_fee') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-50">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Cierre Inscripción Jugadores</label>
                        <input wire:model="player_registration_deadline" type="date"
                               class="w-full px-4 py-3.5 bg-gray-50 border-0 rounded-2xl focus:ring-2 focus:ring-primary focus:bg-white text-gray-900 text-sm font-semibold transition-all"/>
                        <p class="text-[10px] text-gray-400 mt-1.5 font-semibold leading-tight">Límite para que los equipos registren a su plantilla.</p>
                        @error('player_registration_deadline') <p class="text-red-500 text-[10px] mt-1.5 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- ==================== STEP 3: PUNTUACIÓN (REDISEÑADO) ==================== --}}
        @if($currentStep == 3)
            <div class="animate-fadeIn space-y-4">
                <div class="bg-white-pure rounded-3xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-black text-lg text-titanium mb-1 text-center">Sistema de Puntos</h3>
                    <p class="text-[10px] font-bold text-gray-400 mb-6 leading-tight text-center">Puntos otorgados al finalizar un partido en fase de liga o grupos.</p>

                    {{-- En móvil es mucho mejor apilar estos campos para que se vean grandes y no se corten --}}
                    <div class="space-y-4">
                        
                        {{-- Victoria --}}
                        <div class="flex items-center justify-between bg-green-50 rounded-2xl p-4 border border-green-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-200 text-green-700 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="font-black text-green-900 uppercase tracking-wider text-xs">Victoria</p>
                                    <p class="text-[9px] font-bold text-green-600 mt-0.5">Puntos al ganar</p>
                                </div>
                            </div>
                            <input wire:model="points_per_win" type="number" min="0" max="10"
                                   class="w-20 px-2 py-3 bg-white border border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 text-green-700 text-xl text-center font-black shadow-sm"/>
                        </div>

                        {{-- Empate --}}
                        <div class="flex items-center justify-between bg-amber-50 rounded-2xl p-4 border border-amber-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-200 text-amber-700 rounded-full flex items-center justify-center font-black text-xl leading-none pt-1">
                                    =
                                </div>
                                <div>
                                    <p class="font-black text-amber-900 uppercase tracking-wider text-xs">Empate</p>
                                    <p class="text-[9px] font-bold text-amber-600 mt-0.5">Puntos al empatar</p>
                                </div>
                            </div>
                            <input wire:model="points_per_draw" type="number" min="0" max="10"
                                   class="w-20 px-2 py-3 bg-white border border-amber-300 rounded-xl focus:ring-2 focus:ring-amber-500 text-amber-700 text-xl text-center font-black shadow-sm"/>
                        </div>

                        {{-- Derrota --}}
                        <div class="flex items-center justify-between bg-red-50 rounded-2xl p-4 border border-red-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-200 text-red-700 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <div>
                                    <p class="font-black text-red-900 uppercase tracking-wider text-xs">Derrota</p>
                                    <p class="text-[9px] font-bold text-red-600 mt-0.5">Puntos al perder</p>
                                </div>
                            </div>
                            <input wire:model="points_per_loss" type="number" min="0" max="10"
                                   class="w-20 px-2 py-3 bg-white border border-red-300 rounded-xl focus:ring-2 focus:ring-red-500 text-red-700 text-xl text-center font-black shadow-sm"/>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        {{-- ==================== STEP 4: RESUMEN FINAL ==================== --}}
        @if($currentStep == 4)
            <div class="animate-fadeIn space-y-4">
                
                {{-- Bloque principal de Resumen --}}
                <div class="bg-white-pure rounded-3xl p-5 shadow-sm border border-primary/20 space-y-4">
                    <div class="flex flex-col items-center mb-2">
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-full border-4 border-gray-50 shadow-sm mb-3"/>
                        @else
                            <div class="w-20 h-20 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-2xl shadow-sm border border-primary/20 mb-3">
                                {{ substr($name, 0, 1) }}
                            </div>
                        @endif
                        <h3 class="font-black text-xl text-titanium text-center leading-tight">{{ $name }}</h3>
                        @if($location)
                            <p class="text-[11px] font-bold text-gray-500 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $location }}
                            </p>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3">
                        <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Fechas</span>
                            <span class="text-xs font-black text-titanium">
                                @if($start_date && $end_date)
                                    {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                                @else
                                    <span class="text-amber-500 text-[10px]">No definidas</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Inscripción</span>
                            <span class="text-xs font-black text-green-600">
                                {{ $registration_fee ? number_format($registration_fee, 2).' €' : 'Gratis' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Lím. Equipos</span>
                            <span class="text-xs font-black text-titanium">{{ $max_teams ? $max_teams : 'Ilimitado' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Jugadores/Eq.</span>
                            <span class="text-xs font-black text-titanium">{{ $max_players_per_team ? $max_players_per_team : 'Ilimitado' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Puntuación</span>
                            <span class="text-xs font-black text-titanium flex items-center gap-1.5">
                                <span class="text-green-600">V:{{ $points_per_win }}</span>
                                <span class="text-amber-500">E:{{ $points_per_draw }}</span>
                                <span class="text-red-500">D:{{ $points_per_loss }}</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </main>

    {{-- BOTTOM APP BAR (Controles del Stepper fijos abajo) --}}
    <div class="fixed flex flex-col gap-2 bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-100 p-4 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] z-50 flex gap-3">
        <div class="flex justify-between items-center gap-2">
            {{-- Botón Anterior --}}
            @if($currentStep > 1)
                <button wire:click="previousStep" type="button" class="px-5 py-4 bg-gray-100 text-titanium font-black text-sm rounded-2xl active:scale-95 transition-all text-center flex justify-center items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
            @endif

            {{-- Botón Siguiente / Guardar --}}
            @if($currentStep < 4)
                <button wire:click="nextStep" type="button" class="flex-1 py-4 bg-gray-900 text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg flex justify-center items-center gap-2">
                    Siguiente
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            @else
                <button wire:click="save" type="button" wire:loading.attr="disabled" class="flex-1 py-4 bg-primary text-white rounded-2xl font-black text-sm active:scale-95 transition-all shadow-lg shadow-primary/30 flex justify-center items-center gap-2">
                    <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <svg wire:loading wire:target="save" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                    <span wire:loading.remove wire:target="save">Confirmar y Crear Torneo</span>
                    <span wire:loading wire:target="save">Creando...</span>
                </button>
            @endif
        </div>
        <h2 class="flex font-black text-xl text-titanium leading-tight mx-auto">
            Nuevo Torneo
        </h2>
    </div>

    {{-- Estilos de Animación Internos --}}
    <style>
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        /* Ocultar flechas de inputs numéricos en móvil */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</div>