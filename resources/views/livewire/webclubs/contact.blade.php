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
                <h1 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">Contacto</h1>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        {{-- Content: info + form --}}
        <section class="py-20">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                    {{-- Contact Info --}}
                    <div>
                        <p class="text-black/40 text-sm font-semibold uppercase tracking-[0.2em] mb-10">[01] Dónde encontrarnos</p>

                        <div class="space-y-4">
                            @if($school->address)
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6 flex items-start gap-5">
                                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                     style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-1">Dirección</p>
                                    <p class="text-gray-900 font-semibold">{{ $school->address }}</p>
                                    <p class="text-gray-500 text-sm">{{ $school->city }}@if($school->province), {{ $school->province }}@endif @if($school->postal_code) — CP {{ $school->postal_code }}@endif</p>
                                </div>
                            </div>
                            @endif

                            @if($school->email)
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6 flex items-start gap-5">
                                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                     style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-1">Email</p>
                                    <a href="mailto:{{ $school->email }}" class="text-gray-900 font-semibold hover:underline break-all">{{ $school->email }}</a>
                                </div>
                            </div>
                            @endif

                            @if($school->phone)
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6 flex items-start gap-5">
                                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                     style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-1">Teléfono</p>
                                    <a href="tel:{{ $school->phone }}" class="text-gray-900 font-semibold hover:underline">{{ $school->phone }}</a>
                                </div>
                            </div>
                            @endif

                            @if($school->contact_person)
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6 flex items-start gap-5">
                                <div class="shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                     style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-1">Persona de Contacto</p>
                                    <p class="text-gray-900 font-semibold">{{ $school->contact_person }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Contact Form --}}
                    <div>
                        <p class="text-black/40 text-sm font-semibold uppercase tracking-[0.2em] mb-10">[02] Envíanos un mensaje</p>

                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-8">
                            <form action="#" method="POST" class="space-y-5">
                                @csrf

                                <div>
                                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Nombre</label>
                                    <input type="text" id="name" name="name" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                        style="--tw-ring-color: var(--color-primary)"
                                        placeholder="Tu nombre completo">
                                </div>

                                <div>
                                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Email</label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                        style="--tw-ring-color: var(--color-primary)"
                                        placeholder="tu@email.com">
                                </div>

                                <div>
                                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Teléfono</label>
                                    <input type="tel" id="phone" name="phone"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition"
                                        style="--tw-ring-color: var(--color-primary)"
                                        placeholder="Tu número de teléfono">
                                </div>

                                <div>
                                    <label for="message" class="block text-xs font-bold uppercase tracking-wider text-black/40 mb-2">Mensaje</label>
                                    <textarea id="message" name="message" rows="5" required
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:border-transparent transition resize-none"
                                        style="--tw-ring-color: var(--color-primary)"
                                        placeholder="Escribe tu mensaje aquí..."></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-sm uppercase tracking-wider transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                                    style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                                    Enviar Mensaje
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
</div>
