<div class="space-y-6 bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-3 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-4">
        <div class="flex items-center gap-2 overflow-hidden">
            @php
                $indexRoute = (auth()->user()->isMaster() || session()->has('impersonator_id')) 
                    ? 'school-users.index' 
                    : 'my-school-users.index';
            @endphp
            <a href="{{ route($indexRoute) }}" class="font-bold text-lg sm:text-2xl text-primary hover:text-night-blue transition-colors leading-tight whitespace-nowrap">
                {{ __('Usuarios') }}
            </a>
            <span class="text-lg sm:text-2xl text-gray-400 font-bold">/</span>
            <h2 class="font-bold text-lg sm:text-2xl text-titanium leading-tight truncate">
                <span class="hidden sm:inline">Crear </span>Nuevo Usuario
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route($indexRoute) }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">Cancelar</span>
            </a>
            <button type="submit" form="user-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
                <svg wire:loading.remove wire:target="save" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Crear Usuario</span>
                <span wire:loading wire:target="save">Creando...</span>
            </button>
        </div>
    </div>

    <form wire:submit.prevent="save" id="user-form" enctype="multipart/form-data">
            <!-- Layout de una columna -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Información del Usuario -->
                <div class="space-y-6">
                    <div class="flex w-full gap-6">
                        <!-- Información Básica -->
                        <div class="space-y-4 flex-1">
                            <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Información Básica
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-titanium mb-2">Nombre completo *</label>
                                    <input wire:model.live="name" type="text" id="name" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('name') border-red-500 @enderror">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-titanium mb-2">Email *</label>
                                    <input wire:model.live="email" type="email" id="email" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('email') border-red-500 @enderror">
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex w-full gap-6">
                        <!-- Contraseña -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Contraseña
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-titanium mb-2">Contraseña *</label>
                                    <input wire:model.live="password" type="password" id="password" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('password') border-red-500 @enderror">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-titanium mb-2">Confirmar contraseña *</label>
                                    <input wire:model.live="password_confirmation" type="password" id="password_confirmation" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Escuela y Rol -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Escuela y Rol
                            </h3>

                            <div class="grid grid-cols-1 {{ auth()->user()->isMaster() || session()->has('impersonator_id') ? 'md:grid-cols-3' : 'md:grid-cols-2' }} gap-4">
                                @if(auth()->user()->isMaster() || session()->has('impersonator_id'))
                                    <div>
                                        <label for="sports_school_id" class="block text-sm font-semibold text-titanium mb-2">Escuela deportiva *</label>
                                        <select wire:model.live="sports_school_id" id="sports_school_id" 
                                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('sports_school_id') border-red-500 @enderror">
                                            <option value="">Selecciona una escuela</option>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sports_school_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                                <div>
                                    <label for="role" class="block text-sm font-semibold text-titanium mb-2">Rol *</label>
                                    <p class="text-xs text-gray-500 mb-2">Define permisos de usuario en la app</p>
                                    <select wire:model.live="role" id="role" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('role') border-red-500 @enderror">
                                        <option value="">Selecciona un rol</option>
                                        @foreach($roles as $roleOption)
                                            <option value="{{ $roleOption->name }}">{{ ucfirst(str_replace('_', ' ', $roleOption->name)) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- Estado -->
                                <div class="flex items-center pt-8">
                                    <label for="is_active" class="flex items-center cursor-pointer">
                                        <button type="button" wire:click="$toggle('is_active')" 
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ $is_active ? 'bg-neon-green' : 'bg-gray-300' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                        <div class="ml-3 text-titanium font-medium text-sm">Usuario activo</div>
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </form>
</div>

