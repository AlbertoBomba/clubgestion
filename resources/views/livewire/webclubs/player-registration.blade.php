<div>
    <main class="min-h-screen bg-white">

        {{-- Hero header --}}
        <section class="pt-16 pb-16 relative overflow-hidden">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12 relative z-10">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Inicio
                </a>
                <p class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/40 font-semibold mb-5">{{ tenantName() }}</p>
                <h1 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">Inscripción</h1>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        {{-- Registration Form --}}
        <section class="py-20">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <div class="max-w-4xl mx-auto">

                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-8 md:p-12">
                        <form action="#" method="POST" class="space-y-10">
                            @csrf

                            {{-- Datos del Jugador --}}
                            <div>
                                <p class="text-black/40 text-xs font-bold uppercase tracking-[0.2em] mb-6">[01] Datos del Jugador</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Nombre *</label>
                                        <input type="text" id="name" name="name" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Nombre">
                                    </div>
                                    <div>
                                        <label for="surname" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Apellidos *</label>
                                        <input type="text" id="surname" name="surname" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Apellidos">
                                    </div>
                                    <div>
                                        <label for="dni" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">DNI / NIE *</label>
                                        <input type="text" id="dni" name="dni" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="00000000X">
                                    </div>
                                    <div>
                                        <label for="dbirth" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Fecha de Nacimiento *</label>
                                        <input type="date" id="dbirth" name="dbirth" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:border-transparent transition">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Email *</label>
                                        <input type="email" id="email" name="email" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="tu@email.com">
                                    </div>
                                    <div>
                                        <label for="phone1" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Teléfono *</label>
                                        <input type="tel" id="phone1" name="phone1" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="600 000 000">
                                    </div>
                                </div>
                            </div>

                            <div class="h-px bg-gray-100"></div>

                            {{-- Dirección --}}
                            <div>
                                <p class="text-black/40 text-xs font-bold uppercase tracking-[0.2em] mb-6">[02] Dirección</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Dirección</label>
                                        <input type="text" id="address" name="address"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Calle, número, piso...">
                                    </div>
                                    <div>
                                        <label for="town" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Localidad</label>
                                        <input type="text" id="town" name="town"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Localidad">
                                    </div>
                                    <div>
                                        <label for="province" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Provincia</label>
                                        <input type="text" id="province" name="province"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Provincia">
                                    </div>
                                    <div>
                                        <label for="zip" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Código Postal</label>
                                        <input type="text" id="zip" name="zip"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="00000">
                                    </div>
                                </div>
                            </div>

                            <div class="h-px bg-gray-100"></div>

                            {{-- Tutor --}}
                            <div>
                                <p class="text-black/40 text-xs font-bold uppercase tracking-[0.2em] mb-2">[03] Tutor Legal</p>
                                <p class="text-gray-400 text-sm mb-6">Rellenar solo si el jugador es menor de edad</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="nametutor" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Nombre del Tutor</label>
                                        <input type="text" id="nametutor" name="nametutor"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Nombre del tutor">
                                    </div>
                                    <div>
                                        <label for="surnametutor" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Apellidos del Tutor</label>
                                        <input type="text" id="surnametutor" name="surnametutor"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="Apellidos del tutor">
                                    </div>
                                    <div>
                                        <label for="dnitutor" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">DNI del Tutor</label>
                                        <input type="text" id="dnitutor" name="dnitutor"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="00000000X">
                                    </div>
                                    <div>
                                        <label for="phone2" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Teléfono del Tutor</label>
                                        <input type="tel" id="phone2" name="phone2"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                            placeholder="600 000 000">
                                    </div>
                                </div>
                            </div>

                            <div class="h-px bg-gray-100"></div>

                            {{-- Observaciones --}}
                            <div>
                                <label for="observations" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Observaciones</label>
                                <textarea id="observations" name="observations" rows="3"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition resize-none"
                                    placeholder="Información adicional que quieras hacernos saber..."></textarea>
                            </div>

                            {{-- Terms --}}
                            <div class="flex items-start gap-3">
                                <input type="checkbox" id="terms" name="terms" required
                                    class="mt-0.5 h-4 w-4 rounded border-gray-300 focus:ring-primary"
                                    style="accent-color: var(--color-primary)">
                                <label for="terms" class="text-sm text-gray-500">
                                    Acepto la
                                    <a href="{{ route('privacy') }}" class="font-semibold text-gray-700 hover:underline" target="_blank">política de privacidad</a>
                                    y los
                                    <a href="{{ route('terms') }}" class="font-semibold text-gray-700 hover:underline" target="_blank">términos y condiciones</a> *
                                </label>
                            </div>

                            {{-- Actions --}}
                            <div class="flex flex-col sm:flex-row gap-4 pt-2">
                                <button type="reset"
                                    class="flex-1 sm:flex-none px-8 py-4 border border-gray-200 rounded-2xl text-gray-500 font-bold text-sm uppercase tracking-wider hover:bg-gray-50 transition-all duration-300">
                                    Limpiar
                                </button>
                                <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-sm uppercase tracking-wider transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    Enviar Inscripción
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </section>

    </main>
</div>
