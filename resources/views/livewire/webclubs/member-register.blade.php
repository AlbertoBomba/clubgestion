<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Resumen Plan Seleccionado -->
    @if($done)
        <div class="mb-8 p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border border-green-200 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
            <div>
                <span class="text-xs font-semibold text-green-700 uppercase tracking-wider">Sucripción completada</span>
                <h2 class="text-2xl font-bold text-gray-900">¡Gracias por registrarte!</h2>
                <p class="text-sm text-gray-600 mt-1">Hemos recibido tu inscripción y el mandato SEPA. Te enviaremos un correo de confirmación en breve.</p>
            </div>
            <div class="text-right flex-shrink-0">
                <a href="" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white font-bold text-sm rounded-xl shadow-md shadow-primary/20 transition-all">
                    Crear otra suscripción
                </a>
            </div>
        </div>

    @else
        @if($memberType)
            <div class="mb-8 p-6 bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl border border-primary/20 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                <div>
                    <span class="text-xs font-semibold text-primary uppercase tracking-wider">Plan seleccionado</span>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $memberType->name }}</h2>
                    @if($memberType->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $memberType->description }}</p>
                    @endif
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="text-3xl font-extrabold text-gray-900">{{ $memberType->price }}</span>
                    <span class="text-xl font-bold text-primary">€</span>
                </div>
            </div>
        @endif

        <form wire:submit="save" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">

            <!-- Datos Personales -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Datos Personales
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo *</label>
                        <input type="text" id="name" wire:model="name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI / NIE *</label>
                        <input type="text" id="dni" wire:model="dni" placeholder="12345678X" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm uppercase">
                        @error('dni') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico *</label>
                        <input type="email" id="email" wire:model="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-2 w-full">
                        <div class="w-full">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                            <input type="tel" id="phone" wire:model="phone" placeholder="600000000" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                            @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">F. Nacimiento</label>
                            <input   type="hidden" wire:model="birth_date" id="pr-birthdate-livewire"/>
                            <div class="relative">
                                <input type="text" id="pr-birthdate-text" placeholder="dd/mm/aaaa" maxlength="10"
                                    oninput="prFormatBirthdate(this)"
                                    class="w-full pl-3 pr-10 py-3.5 text-sm border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"/>
                                <input type="date" id="pr-birthdate-picker" tabindex="-1"
                                    style="position:absolute;opacity:0;width:0;height:0;top:0;right:0;"
                                    onchange="prSyncBirthdatePicker(this)"/>
                                <button type="button" onclick="document.getElementById('pr-birthdate-picker').showPicker()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round"/>
                                        <line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                </button>
                            </div>
                            {{-- <label for="birth_date" class="block text-sm font-medium text-gray-700">F.Nacimiento *</label>
                            <input type="date" id="birth_date" wire:model="birth_date" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm"> --}}
                            @error('birth_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- Dirección Postal -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Dirección Postal
                </h3>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Calle, número y piso *</label>
                    <input type="text" id="address" wire:model="address" placeholder="Ej: Av. Constitución 12, 3ºA" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                    @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="town" class="block text-sm font-medium text-gray-700">Población *</label>
                        <input type="text" id="town" wire:model="town" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                        @error('town') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="zip" class="block text-sm font-medium text-gray-700">Código Postal *</label>
                        <input type="text" id="zip" wire:model="zip" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                        @error('zip') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">Provincia *</label>
                        <input type="text" id="province" wire:model="province" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                        @error('province') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Datos Bancarios -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Datos Bancarios (Domiciliación)
                </h3>

                <div>
                    <label for="bank_account_holder" class="block text-sm font-medium text-gray-700">Titular de la cuenta bancaria *</label>
                    <input type="text" id="bank_account_holder" wire:model="bank_account_holder" placeholder="Nombre del titular del IBAN" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm">
                    <p class="text-xs text-gray-500 mt-1">Si el socio es menor, indica el nombre del padre, madre o tutor.</p>
                    @error('bank_account_holder') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="bank_account" class="block text-sm font-medium text-gray-700">Número de Cuenta (IBAN) *</label>
                    <input type="text" id="bank_account" wire:model="bank_account" x-mask="ES99 9999 9999 9999 9999 9999" placeholder="ES00 0000 0000 0000 0000 0000" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary text-sm uppercase font-mono">
                    @error('bank_account') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Cláusula SEPA -->
            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200/80 space-y-2">
                <label for="sepa_terms" class="flex items-start gap-3 cursor-pointer select-none">
                    <input type="checkbox" id="sepa_terms" wire:model="sepa_terms" class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer">
                    <span class="text-xs text-gray-600 leading-relaxed">
                        <strong class="font-semibold text-gray-800 block mb-0.5">Orden de Domiciliación Directa SEPA</strong>
                        Mediante la marcación de esta casilla, autorizo a la entidad a enviar instrucciones a mi entidad bancaria para adeudar los recibos en la cuenta facilitada, y a mi entidad bancaria a efectuar dichos adeudos siguiendo las instrucciones.
                    </span>
                </label>
                @error('sepa_terms') <span class="text-xs text-red-500 block">{{ $message }}</span> @enderror
            </div>

            <!-- Botón de Envío -->
            <div class="flex justify-end pt-2">
                <button type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto px-8 py-3 bg-primary hover:bg-primary/90 text-white font-bold text-sm rounded-xl shadow-md shadow-primary/20 active:scale-95 transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove>Completar Inscripción</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Procesando...
                    </span>
                </button>
            </div>

        </form>

    @endif
    <script>
        function prSyncBirthdatePicker(picker) {
            if (!picker.value) return;
            
            // 1. Convertir fecha YYYY-MM-DD a DD/MM/YYYY para el input visible
            const [year, month, day] = picker.value.split('-');
            document.getElementById('pr-birthdate-text').value = `${day}/${month}/${year}`;
            
            // 2. Asignar al input hidden y avisar a Livewire
            const hiddenInput = document.getElementById('pr-birthdate-livewire');
            hiddenInput.value = picker.value;
            hiddenInput.dispatchEvent(new Event('input')); // Dispatch requerido
        }

        function prFormatBirthdate(input) {
            // Tu lógica actual de formateo de texto...
            
            // Cuando el texto tenga el formato completo (10 caracteres "DD/MM/YYYY"):
            if (input.value.length === 10) {
                const [day, month, year] = input.value.split('/');
                const isoDate = `${year}-${month}-${day}`; // Formato YYYY-MM-DD para Livewire/SQL
                
                const hiddenInput = document.getElementById('pr-birthdate-livewire');
                hiddenInput.value = isoDate;
                hiddenInput.dispatchEvent(new Event('input')); // Dispatch requerido
            }
        }
    </script>
</div>