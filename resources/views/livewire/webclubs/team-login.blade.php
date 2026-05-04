<div>
    <section class="min-h-[calc(100vh-6rem)] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            {{-- Logo + Club name --}}
            <div class="text-center mb-8">
                <img src="{{ tenantLogo() }}" alt="{{ tenantName() }}"
                     class="w-16 h-16 object-contain mx-auto mb-3 rounded-2xl">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ tenantName() }}</p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-7 sm:p-9">

                {{-- Header --}}
                <div class="mb-6">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4"
                         style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-black text-gray-900">Acceso equipos</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">
                        <span class="text-primary font-bold">{{ $tournament->name }}</span>
                    </p>
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
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                        <input wire:model="email" type="email" autocomplete="email"
                               placeholder="equipo@ejemplo.com"
                               class="w-full px-4 py-3 text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('email') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Contraseña</label>
                        <input wire:model="password" type="password" autocomplete="current-password"
                               placeholder="Tu contraseña"
                               class="w-full px-4 py-3 text-sm border border-gray-200 rounded-2xl bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                        @error('password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full py-3.5 rounded-2xl text-white font-bold text-sm shadow-lg shadow-primary/25 hover:opacity-90 active:scale-[0.98] transition-all duration-150 mt-2"
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

            </div>

            {{-- Back link --}}
            <div class="text-center mt-5">
                <a href="{{ route('webclubs.tournament.detail', $tournament) }}"
                   class="text-sm text-gray-400 hover:text-gray-600 font-semibold transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Volver al torneo
                </a>
            </div>

        </div>
    </section>
</div>
