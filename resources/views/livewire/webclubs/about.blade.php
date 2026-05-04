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
                <h1 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold text-black leading-none">Sobre Nosotros</h1>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        {{-- Description --}}
        @if($school->description)
        <section class="py-20">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <div class="max-w-4xl">
                    <p class="text-black/40 text-sm font-semibold uppercase tracking-[0.2em] mb-6">[01] Descripción</p>
                    <p class="text-2xl md:text-3xl text-gray-700 leading-relaxed font-light">{{ $school->description }}</p>
                </div>
            </div>
        </section>
        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>
        @endif

        {{-- Historia y Misión --}}
        <section class="py-20">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <p class="text-black/40 text-sm font-semibold uppercase tracking-[0.2em] mb-12">[02] Quiénes somos</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-8">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-6"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Nuestra Historia</h3>
                        <p class="text-gray-500 leading-relaxed">Con años de experiencia en formación deportiva, nos hemos consolidado como referente en el desarrollo integral de deportistas, creando una comunidad sólida de valores y pasión por el deporte.</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-8">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-6"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Nuestra Misión</h3>
                        <p class="text-gray-500 leading-relaxed">Formar deportistas con valores, técnica y pasión por el deporte, proporcionando las mejores herramientas para su desarrollo personal y deportivo en cada etapa de su carrera.</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
            <div class="h-px bg-gray-100"></div>
        </div>

        {{-- Información de contacto --}}
        <section class="py-20">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <p class="text-black/40 text-sm font-semibold uppercase tracking-[0.2em] mb-12">[03] Información</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    @if($school->address)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-2">Dirección</p>
                        <p class="text-gray-900 font-semibold text-sm">{{ $school->address }}</p>
                        <p class="text-gray-500 text-sm">{{ $school->city }}@if($school->province), {{ $school->province }}@endif</p>
                        @if($school->postal_code)
                        <p class="text-gray-400 text-xs mt-1">CP {{ $school->postal_code }}</p>
                        @endif
                    </div>
                    @endif

                    @if($school->email)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-2">Email</p>
                        <a href="mailto:{{ $school->email }}" class="text-gray-900 font-semibold text-sm hover:underline break-all">{{ $school->email }}</a>
                    </div>
                    @endif

                    @if($school->phone)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-2">Teléfono</p>
                        <a href="tel:{{ $school->phone }}" class="text-gray-900 font-semibold text-sm hover:underline">{{ $school->phone }}</a>
                    </div>
                    @endif

                    @if($school->contact_person)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm shadow-gray-200/60 p-6">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-black/30 mb-2">Contacto</p>
                        <p class="text-gray-900 font-semibold text-sm">{{ $school->contact_person }}</p>
                    </div>
                    @endif

                </div>

                <div class="mt-10">
                    <a href="{{ route('webclubs.contact') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-sm uppercase tracking-wider transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                       style="background: linear-gradient(135deg, var(--color-primary), var(--color-secondary))">
                        Contactar con nosotros
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

    </main>
</div>
