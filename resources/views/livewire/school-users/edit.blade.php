<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
    <form wire:submit="save" class="p-6 sm:p-8 space-y-6">
            <!-- Información Básica -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Información Básica
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-titanium mb-2">Nombre completo *</label>
                        <input wire:model="name" type="text" id="name" 
                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('name') border-red-500 @enderror">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-titanium mb-2">Email *</label>
                        <input wire:model="email" type="email" id="email" 
                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('email') border-red-500 @enderror">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Cambiar Contraseña -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Cambiar Contraseña
                </h3>
                <p class="text-xs text-gray-500">Deja en blanco si no deseas cambiar la contraseña</p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-titanium mb-2">Nueva contraseña</label>
                        <input wire:model="password" type="password" id="password" 
                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('password') border-red-500 @enderror">
                        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-titanium mb-2">Confirmar contraseña</label>
                        <input wire:model="password_confirmation" type="password" id="password_confirmation" 
                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    </div>
                </div>
            </div>

            <!-- Asignación -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Escuela y Rol
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label for="sports_school_id" class="block text-sm font-semibold text-titanium mb-2">Escuela deportiva *</label>
                        <select wire:model="sports_school_id" id="sports_school_id" 
                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('sports_school_id') border-red-500 @enderror">
                            <option value="">Selecciona una escuela</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                        @error('sports_school_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-semibold text-titanium mb-2">Rol *</label>
                        <select wire:model="role" id="role" 
                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('role') border-red-500 @enderror"
                            {{ $user->role === 'master' ? 'disabled' : '' }}>
                            <option value="">Selecciona un rol</option>
                            @if($user->role === 'master')
                                <option value="master" selected>Master (no editable)</option>
                            @else
                                <option value="school_admin">Administrador de Escuela</option>
                                <option value="coach">Entrenador</option>
                                <option value="student">Estudiante</option>
                            @endif
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="flex items-center space-x-3">
                <label for="is_active" class="flex items-center cursor-pointer">
                    <button type="button" wire:click="$toggle('is_active')" 
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ $is_active ? 'bg-neon-green' : 'bg-gray-300' }}">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                    </button>
                    <div class="ml-3 text-titanium font-medium text-sm">Usuario activo</div>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-silver/30">
                <a href="{{ auth()->user()->isMaster() || session()->has('impersonator_id') ? route('school-users.index') : route('my-school-users.index') }}" 
                    class="inline-flex justify-center items-center px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                    class="btn-primary inline-flex justify-center items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all">
                    Actualizar Usuario
                </button>
            </div>
        </form>
</div>
