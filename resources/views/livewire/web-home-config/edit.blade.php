<div class="space-y-8">

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
             class="p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <p class="text-sm text-gray-500">Estadísticas, sección de socios y contacto de la portada pública</p>
            <button form="config-form" type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Cambios
            </button>
        </div>
    </div>

    <form wire:submit.prevent="save" id="config-form" class="space-y-6">

        <!-- ── SECCIÓN: ESTADÍSTICAS ─────────────────────────── -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <span class="text-2xl">📊</span>
                <div>
                    <h3 class="font-bold text-gray-800">Sección Estadísticas</h3>
                    <p class="text-xs text-gray-500">Los contadores de jugadores, equipos y entrenadores se calculan automáticamente</p>
                </div>
            </div>
            <div class="p-6">
                <div class="max-w-xs">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Contador "Años" del club
                    </label>
                    <input wire:model.live="stats_years" type="number" min="0" max="500"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('stats_years') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-400 mt-1">Actualmente: <span class="font-bold text-gray-600">{{ $stats_years }}</span> años</p>
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN: MEMBRESÍA / HAZTE SOCIO ──────────────── -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🏅</span>
                    <div>
                        <h3 class="font-bold text-gray-800">Sección "Hazte Socio"</h3>
                        <p class="text-xs text-gray-500">Personaliza el bloque de membresía y sus beneficios</p>
                    </div>
                </div>
                <!-- Toggle mostrar/ocultar -->
                <label class="flex items-center gap-2 cursor-pointer">
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Visible</span>
                    <button type="button" wire:click="$set('membership_show', !{{ $membership_show ? 'true' : 'false' }})"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 {{ $membership_show ? 'bg-green-500' : 'bg-gray-200' }}">
                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 {{ $membership_show ? 'translate-x-5' : 'translate-x-0' }}"></span>
                    </button>
                </label>
            </div>

            @if($membership_show)
            <div class="p-6 space-y-6">
                <!-- Título y subtítulo -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Título de la sección</label>
                        <input wire:model.live="membership_title" type="text" placeholder="Hazte Socio"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('membership_title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subtítulo / descripción</label>
                        <input wire:model.live="membership_subtitle" type="text" placeholder="Disfruta de beneficios exclusivos..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('membership_subtitle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Beneficios -->
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Los 3 beneficios</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach([1,2,3] as $n)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 space-y-3">
                            <div class="text-2xl font-extrabold text-gray-200">0{{ $n }}</div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Título</label>
                                <input wire:model.live="benefit_{{ $n }}_title" type="text"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error("benefit_{$n}_title") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Descripción</label>
                                <textarea wire:model.live="benefit_{{ $n }}_description" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                @error("benefit_{$n}_description") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Botón CTA -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Texto del botón</label>
                        <input wire:model.live="membership_button_text" type="text" placeholder="Únete Ahora"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('membership_button_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            URL del botón
                            <span class="text-gray-400 font-normal">(dejar vacío para usar la página de inscripción)</span>
                        </label>
                        <input wire:model.live="membership_button_url" type="text" placeholder="/inscripcion"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('membership_button_url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @else
            <div class="p-6 text-center text-gray-400 text-sm py-10">
                Esta sección está oculta en la portada pública.
            </div>
            @endif
        </div>

        <!-- ── SECCIÓN: CONTACTO ──────────────────────────────── -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📬</span>
                    <div>
                        <h3 class="font-bold text-gray-800">Sección Contacto</h3>
                        <p class="text-xs text-gray-500">Email y teléfono que aparecen en la portada pública</p>
                    </div>
                </div>
                <!-- Toggle mostrar/ocultar -->
                <label class="flex items-center gap-2 cursor-pointer">
                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Visible</span>
                    <button type="button" wire:click="$set('contact_show', !{{ $contact_show ? 'true' : 'false' }})"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 {{ $contact_show ? 'bg-green-500' : 'bg-gray-200' }}">
                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 {{ $contact_show ? 'translate-x-5' : 'translate-x-0' }}"></span>
                    </button>
                </label>
            </div>

            @if($contact_show)
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Título de la sección</label>
                        <input wire:model.live="contact_title" type="text" placeholder="¿Tienes Preguntas?"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('contact_title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email de contacto
                        </label>
                        <input wire:model.live="contact_email" type="email" placeholder="info@miclub.com"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('contact_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono de contacto
                        </label>
                        <input wire:model.live="contact_phone" type="text" placeholder="+34 600 000 000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('contact_phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @else
            <div class="p-6 text-center text-gray-400 text-sm py-10">
                Esta sección está oculta en la portada pública.
            </div>
            @endif
        </div>

        <!-- Botón guardar inferior -->
        <div class="flex justify-end pb-6">
            <button type="submit"
                    class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Configuración
            </button>
        </div>

    </form>
</div>
