<div>
    
    <main class="min-h-screen bg-white">
        <section class="pt-5 pb-40 bg-white relative overflow-hidden">
            <div class="max-w-[1920px] mx-auto px-6 lg:px-12">
                <div class="mb-16" data-aos="fade-up">
                    <a href="{{ route('webclubs.home') }}"
                        class="inline-flex items-center gap-2 text-black/30 hover:text-black/60 text-sm font-semibold uppercase tracking-wider transition mb-6 md:mb-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Inicio
                    </a>
                    {{-- <h2 class="text-sm md:text-base lg:text-lg uppercase tracking-[0.2em] text-black/40 font-semibold mb-5">Jugadores {{ tenantName() }}</h2> --}}
                    <h3 class="section-title text-6xl md:text-8xl lg:text-9xl font-bold text-gray-900">Portal Jugador</h3>
                </div>
                
                <!-- Grid de Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- CARD 1: INSCRIPCIÓN (Tema Fuego / Naranja) -->
                    <div class="group relative bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:border-orange-500/50 transition-all duration-500 shadow-xl shadow-slate-200/60 hover:shadow-2xl hover:shadow-orange-500/15 hover:-translate-y-1 flex flex-col">
                        <!-- Imagen de Cabecera -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="images/public/fitness-rugby-coach-with-clipboard-teamwork-training-competition-workout-wellness-male-trainer-group-with-healthy-lifestyle-sports-practice-exercise-support-plan.jpg" alt="Inscripción" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                            <!-- Degradado blanco suave hacia abajo -->
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/30 to-transparent"></div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-8 flex-grow flex flex-col relative z-10 -mt-8">
                            <!-- Icono flotante con borde blanco -->
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-500/30 mb-6 border-4 border-white transform -rotate-3 group-hover:rotate-0 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-wide mb-3">
                                Inscripción <br><span class="text-orange-600">Oficial</span>
                            </h3>
                            <p class="text-slate-600 leading-relaxed mb-8 font-medium">
                                Rellena tu ficha deportiva. Introduce tus datos personales e historial médico para enfundarte la camiseta esta temporada.
                            </p>
                            
                            <!-- Botón de acción -->
                            <a href="{{ route('webclubs.registration') }}" class="mt-auto block w-full relative overflow-hidden rounded-xl group/btn shadow-md shadow-orange-600/20">
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-red-600 transition-transform duration-300 group-hover/btn:scale-105"></div>
                                <div class="relative flex items-center justify-center gap-2 py-4 px-6 text-white font-black uppercase tracking-widest text-lg">
                                    <span>Hacer inscripción</span>
                                    <svg class="w-6 h-6 group-hover/btn:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- CARD 2: PAGO (Tema Eléctrico / Cyan) -->
                    <div class="group relative bg-white rounded-3xl overflow-hidden border border-slate-200/80 hover:border-cyan-500/50 transition-all duration-500 shadow-xl shadow-slate-200/60 hover:shadow-2xl hover:shadow-cyan-500/15 hover:-translate-y-1 flex flex-col">
                        <!-- Imagen de Cabecera -->
                        <div class="relative h-56 overflow-hidden">
                            <img  src="images/public/soccer-ball-blurred-kids-soccer-team-with-coach-field.jpg" alt="Pago" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out grayscale-[20%] group-hover:grayscale-0">
                            <!-- Degradado blanco suave hacia abajo -->
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/30 to-transparent"></div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-8 flex-grow flex flex-col relative z-10 -mt-8">
                            <!-- Icono flotante con borde blanco -->
                            <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 mb-6 border-4 border-white transform -rotate-3 group-hover:rotate-0 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-wide mb-3">
                                Carta de <br><span class="text-cyan-600">Pago</span>
                            </h3>
                            <p class="text-slate-600 leading-relaxed mb-8 font-medium">
                                Abona tu matrícula de forma segura. Activa tu mátricula y consigue acceso completo a los entrenamientos y a las competiciones.
                            </p>
                            
                            <!-- Botón de acción -->
                            <a href="{{route('webclubs.payment')}}" class="mt-auto block w-full relative overflow-hidden rounded-xl group/btn shadow-md shadow-cyan-500/20">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-600 transition-transform duration-300 group-hover/btn:scale-105"></div>
                                <div class="relative flex items-center justify-center gap-2 py-4 px-6 text-white font-black uppercase tracking-widest text-lg">
                                    <span>Abonar Cuota</span>
                                    <svg class="w-6 h-6 group-hover/btn:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
</div>