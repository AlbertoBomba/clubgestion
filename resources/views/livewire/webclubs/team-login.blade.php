<div>
    <style>
        .team-login-outer {
            background: linear-gradient(160deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            min-height: calc(100vh - 4rem);
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 639px) {
            .team-login-sheet-wrap {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
            }
        }
    </style>

    <div class="team-login-outer">

        {{-- ============================================================ --}}
        {{-- MOBILE HERO (hidden on sm+) --}}
        {{-- ============================================================ --}}
        <div class="sm:hidden px-5 pt-5 pb-4">
            {{-- Back button --}}
            <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
               class="inline-flex items-center gap-1.5 text-white/80 text-sm font-semibold py-1.5 pr-3 active:opacity-60 transition-opacity">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver
            </a>

            {{-- Logo + Title --}}
            {{-- <div class="flex flex-col items-center mt-7 mb-3"> --}}
                {{-- @if(tenantLogo())
                    <div class="w-20 h-20 rounded-3xl bg-white/15 backdrop-blur-sm flex items-center justify-center shadow-xl shadow-black/20 mb-4 overflow-hidden">
                        <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}" class="w-16 h-16 object-contain">
                    </div>
                @endif --}}
                {{-- <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-1">{{ tenantName() }}</p> --}}
                {{-- <h1 class="text-white text-[1.6rem] font-black text-center leading-tight">Acceso equipos</h1>
                <p class="text-white/70 text-sm font-medium mt-1 text-center">{{ $tournament->name }}</p> --}}
            {{-- </div> --}}
        </div>

        {{-- ============================================================ --}}
        {{-- SHEET WRAPPER: full-height flex col on mobile / centered section on desktop --}}
        {{-- ============================================================ --}}
        <div class="team-login-sheet-wrap sm:flex sm:min-h-[calc(100vh-6rem)] sm:items-center sm:justify-center sm:px-4 sm:py-12">
            <div class="w-full sm:max-w-md">
               
                {{-- ---------------------------------------------------- --}}
                {{-- CARD / BOTTOM SHEET --}}
                {{-- ---------------------------------------------------- --}}
                <div class="bg-white  sm:rounded-3xl
                            shadow-[0_-6px_32px_rgba(0,0,0,0.10)] sm:shadow-xl sm:shadow-gray-200/60
                            sm:border sm:border-gray-100
                            px-6 pt-6 pb-10 sm:p-7 sm:pb-9">

                    {{-- Drag handle (mobile only) --}}
                    <div class="sm:hidden w-10 h-1 bg-gray-200 rounded-full mx-auto mb-7"></div>
                        <h1 class="text-black text-[1.6rem] font-black text-center leading-tight">Acceso equipos</h1>
                        <p class="text-black/70 text-sm font-medium mt-1 text-center">{{ $tournament->name }}</p>
            
                    {{-- Desktop header --}}
                    <div class="hidden sm:block mb-6">
                        {{-- <h1 class="text-2xl font-black text-gray-900">Acceso equipos</h1>
                        <p class="text-sm text-gray-500 mt-1 font-medium">
                            <span class="text-primary font-bold">{{ $tournament->name }}</span>
                        </p> --}}
                    </div>

                    {{-- Success after registration --}}
                    @if($registered)
                        <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-100 rounded-2xl mb-5">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-bold text-green-700">¡Inscripción completada!</p>
                                <p class="text-xs text-green-600 mt-0.5">Ya puedes acceder al área de tu equipo con las credenciales que elegiste.</p>
                            </div>
                        </div>
                    @endif

                    {{-- Error --}}
                    @if($error)
                        <div class="flex items-center gap-2.5 p-3.5 bg-red-50 border border-red-100 rounded-2xl mb-5">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-semibold text-red-600">{{ $error }}</p>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form wire:submit="login" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                            <input wire:model="email" type="email" autocomplete="email"
                                   placeholder="equipo@ejemplo.com"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Contraseña</label>
                            <input wire:model="password" type="password" autocomplete="current-password"
                                   placeholder="Tu contraseña"
                                   class="w-full px-4 py-4 sm:py-3 text-base sm:text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                            @error('password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit"
                                class="w-full py-4 sm:py-3.5 rounded-2xl text-white font-bold text-base sm:text-sm shadow-lg shadow-primary/25 hover:opacity-90 active:scale-[0.98] transition-all duration-150 mt-1"
                                style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <span wire:loading.remove wire:target="login">Entrar al área del equipo</span>
                            <span wire:loading wire:target="login" class="inline-flex items-center gap-2 justify-center">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Verificando...
                            </span>
                        </button>
                    </form>

                    {{-- Register CTA (mobile: inside sheet) --}}
                    @if($tournament->status === 'registration_open')
                        <div class="sm:hidden mt-6 pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-black text-gray-800">¿Tu equipo no estás inscrito?</p>
                                {{-- <p class="text-xs text-gray-400 font-medium mt-0.5">Inscribe tu equipo para recibir acceso</p> --}}
                            </div>
                            <a href="{{ route('webclubs.team.register', $tournament) }}"
                               class="shrink-0 px-4 py-2.5 rounded-xl text-white text-sm font-bold shadow active:opacity-80 transition-opacity"
                               style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                Inscribir equipo
                            </a>
                        </div>
                    @endif

                    {{-- Back link (mobile: inside sheet) --}}
                    {{-- <div class="sm:hidden text-center mt-5">
                        <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
                           class="text-sm text-gray-400 font-semibold inline-flex items-center gap-1.5 active:opacity-60 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Volver al torneo
                        </a>
                    </div> --}}

                </div>

                {{-- Register CTA (desktop: outside card) --}}
                @if($tournament->status === 'registration_open')
                    <div class="hidden sm:flex mt-4 bg-white rounded-3xl border border-gray-100 shadow-sm p-5 items-center gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-black text-gray-800">¿Tu equipo no está inscrito?</p>
                            {{-- <p class="text-xs text-gray-400 font-medium">Inscribe tu equipo para recibir acceso</p> --}}
                        </div>
                        <a href="{{ route('webclubs.team.register', $tournament) }}"
                           class="shrink-0 px-4 py-2 rounded-xl text-white text-xs font-bold shadow active:opacity-80"
                           style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            Inscribir equipo
                        </a>
                    </div>
                @endif

                {{-- Back link (desktop: outside card) --}}
                <div class="hidden sm:block text-center mt-5">
                    <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
                       class="text-sm text-gray-400 hover:text-gray-600 font-semibold transition-colors inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver al torneo
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
