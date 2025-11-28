<div>
    <div class="card-modern bg-white rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-primary/5 to-blue-50">
            <h2 class="text-2xl font-bold text-gray-900">Crear Nuevo Usuario</h2>
            <p class="text-sm text-gray-600 mt-1">Completa la información del nuevo usuario del club deportivo</p>
        </div>

        <form wire:submit="save" class="p-6 space-y-6">
            <!-- Información Básica -->
            <div class="bg-gradient-to-r from-primary/5 to-blue-50 rounded-xl p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Información Básica
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo *</label>
                        <input wire:model="name" type="text" id="name" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 @error('name') border-red-500 @enderror">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input wire:model="email" type="email" id="email" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 @error('email') border-red-500 @enderror">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                        <input wire:model="password" type="password" id="password" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 @error('password') border-red-500 @enderror">
                        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar contraseña *</label>
                        <input wire:model="password_confirmation" type="password" id="password_confirmation" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                    </div>
                </div>
            </div>

            <!-- Asignación -->
            <div class="bg-gradient-to-r from-blue-50 to-night-blue-50 rounded-xl p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Escuela y Rol
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="sports_school_id" class="block text-sm font-medium text-gray-700 mb-2">Escuela deportiva *</label>
                        <select wire:model="sports_school_id" id="sports_school_id" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 @error('sports_school_id') border-red-500 @enderror">
                            <option value="">Selecciona una escuela</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                        @error('sports_school_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                        <select wire:model="role" id="role" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900 @error('role') border-red-500 @enderror">
                            <option value="">Selecciona un rol</option>
                            <option value="school_admin">Administrador de Escuela</option>
                            <option value="coach">Entrenador</option>
                            <option value="student">Estudiante</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="flex items-center space-x-3">
                <label for="is_active" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input wire:model="is_active" type="checkbox" id="is_active" class="sr-only" x-data="{ checked: @entangle('is_active') }">
                        <div class="block bg-gray-300 w-14 h-8 rounded-full" :class="{ 'bg-gradient-to-r from-neon-green to-neon-green-600': checked }"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform" :class="{ 'transform translate-x-6': checked }"></div>
                    </div>
                    <div class="ml-3 text-gray-700 font-medium">Usuario activo</div>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ auth()->user()->isMaster() || session()->has('impersonator_id') ? route('school-users.index') : route('my-school-users.index') }}" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-300">
                    Cancelar
                </a>
                <button type="submit" 
                    class="btn-primary px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>
