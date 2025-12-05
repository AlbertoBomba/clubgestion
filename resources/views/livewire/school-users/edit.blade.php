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
                <span class="hidden sm:inline">Actualizar </span>{{ $name }}
            </h2>
        </div>
        
        <div class="flex gap-2 sm:gap-3 flex-wrap sm:flex-nowrap">
            <a href="{{ route($indexRoute) }}" class="inline-flex items-center px-3 py-2 sm:px-4 bg-silver/30 text-titanium rounded-xl font-semibold text-xs sm:text-sm hover:bg-silver/50 transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="hidden sm:inline">{{ $hasChanges ? 'Cancelar' : 'Volver' }}</span>
            </a>
            @if($user->role !== 'master' && auth()->user()->isMaster() && !session()->has('impersonator_id'))
                <button type="button" wire:click="confirmDelete" 
                    wire:loading.attr="disabled"
                    wire:target="confirmDelete"
                    class="inline-flex items-center px-3 py-2 sm:px-4 rounded-xl text-white font-semibold text-xs sm:text-sm shadow-lg hover:shadow-xl transition-all bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg wire:loading.remove wire:target="confirmDelete" class="w-4 h-4 sm:w-5 sm:h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg wire:loading wire:target="confirmDelete" class="animate-spin h-4 w-4 sm:w-5 sm:h-5 sm:mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="hidden sm:inline">Eliminar</span>
                </button>
            @endif
            <button type="submit" form="user-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
                <svg wire:loading.remove wire:target="save" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Actualizar</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>
    </div>

    <!-- Alerta de cambios sin guardar -->
    @if($hasChanges)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg animate-pulse">
            <div class="flex">
                <div class="flex-shrink-0">
                    {{-- <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg> --}}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-yellow-800">
                        ⚠️ Tienes cambios sin guardar. Haz clic en <span class="font-bold">Actualizar</span> para guardar los cambios.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" id="user-form" enctype="multipart/form-data">
            <!-- Layout de dos columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna Izquierda: Información del Usuario (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex w-full gap-6">
                        <!-- Foto de Perfil -->
                        <div class="space-y-4 flex-1 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Foto de Perfil
                            </h3>

                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0">
                                    @if ($profile_photo)
                                        <div>
                                            <p class="text-sm text-titanium mb-2 text-center">Vista previa:</p>
                                            <img src="{{ $profile_photo->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-xl border-2 border-primary shadow-md">
                                        </div>
                                    @elseif($current_profile_photo)
                                        <div>
                                            {{-- <p class="text-sm text-titanium mb-2 text-center">Foto actual:</p> --}}
                                            <div class="relative inline-block">
                                                <img src="{{ asset('storage/' . $current_profile_photo) }}" 
                                                    class="h-32 w-32 object-cover rounded-xl border-2 border-silver shadow-md">
                                                <button type="button" wire:click="deleteProfilePhoto" 
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors shadow-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-32 w-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-xs text-gray-500">Sin imagen</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-titanium mb-2">{{ $current_profile_photo ? 'Cambiar foto de perfil' : 'Subir foto de perfil' }}</label>
                                    
                                    <!-- Editor de recorte de imagen de perfil -->
                                    <div id="profile-photo-editor" class="hidden mb-3 border-2 border-dashed border-primary rounded-xl p-4">
                                        <div class="mb-3">
                                            <img id="profile-crop-image" style="max-width: 100%; display: block;">
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="cropAndUploadProfilePhoto()" 
                                                class="flex-1 px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                                                ✂️ Recortar y Usar
                                            </button>
                                            <button type="button" onclick="cancelProfilePhotoCrop()" 
                                                class="px-4 py-2 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
                                                ✕ Cancelar
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <input type="file" id="profile-photo-file-input" accept="image/*" 
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer"
                                        onchange="handleProfilePhotoSelect(event)">
                                    
                                    <!-- Input oculto para Livewire -->
                                    <input type="file" wire:model.live="profile_photo" id="profile-photo-livewire-input" accept="image/*" class="hidden">
                                    
                                <div wire:loading wire:target="profile_photo" class="text-sm text-primary mt-1">
                                    <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Subiendo foto...
                                </div>
                                    @error('profile_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    <p class="text-xs text-gray-500 mt-1">Máximo 2MB. Formatos: JPG, PNG</p>
                                </div>
                            </div>
                        </div>

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
                        <!-- Cambiar Contraseña -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Cambiar Contraseña
                            </h3>
                            <p class="text-xs text-gray-500">Deja en blanco si no deseas cambiar la contraseña</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-titanium mb-2">Nueva contraseña</label>
                                    <input wire:model.live="password" type="password" id="password" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('password') border-red-500 @enderror">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-titanium mb-2">Confirmar contraseña</label>
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

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="sports_school_id" class="block text-sm font-semibold text-titanium mb-2">Escuela deportiva *</label>
                                    @if(auth()->user()->isMaster() || session()->has('impersonator_id'))
                                        <select wire:model.live="sports_school_id" id="sports_school_id" 
                                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('sports_school_id') border-red-500 @enderror">
                                            <option value="">Selecciona una escuela</option>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p class="text-xs text-gray-500 mb-2">La escuela está fijada automáticamente</p>
                                        <div class="block w-full px-3 py-2 border border-silver rounded-xl bg-gray-50 text-black-deep text-sm">
                                            {{ $schools->first()?->name ?? 'Sin escuela' }}
                                        </div>
                                    @endif
                                    @error('sports_school_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-semibold text-titanium mb-2">Rol *</label>
                                    <p class="text-xs text-gray-500 mb-2">Define permisos de usuario en la app</p>
                                    <select wire:model.live="role" id="role" 
                                        class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('role') border-red-500 @enderror"
                                        {{ $user->role === 'master' ? 'disabled' : '' }}>
                                        <option value="">Selecciona un rol</option>
                                        @if($user->role === 'master')
                                            <option value="master" selected>Master (no editable)</option>
                                        @else
                                            @foreach($roles as $roleOption)
                                                <option value="{{ $roleOption->name }}">{{ ucfirst(str_replace('_', ' ', $roleOption->name)) }}</option>
                                            @endforeach
                                        @endif
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

                <!-- Columna Derecha: Documentación (1/3) -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Documentación
                    </h3>

                    <div class="space-y-3">
                        @if(!empty($existingDocuments))
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-titanium mb-2">Documentos actuales:</p>
                                @foreach($existingDocuments as $index => $doc)
                                    <div class="flex items-center justify-between p-3 mb-2 border border-silver rounded-xl bg-gray-50">
                                        <div class="flex items-center space-x-3">
                                            @if(str_ends_with($doc['path'], '.pdf'))
                                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            <div>
                                                <p class="text-sm font-medium text-titanium">{{ $doc['label'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $doc['original_name'] ?? 'Documento' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                                                class="text-primary hover:text-primary/70 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <button type="button" wire:click="deleteDocument({{ $index }})" 
                                                class="text-red-500 hover:text-red-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div>
                            <p class="text-sm font-semibold text-titanium mb-2">Agregar nuevo documento:</p>
                            <div class="p-3 border border-silver rounded-xl bg-gray-50/50">
                                <label class="block text-sm font-semibold text-titanium mb-2">
                                    Tipo de documento *
                                </label>
                                <select wire:model.live="documentType" 
                                    class="block w-full px-3 py-2 mb-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-black-deep text-sm @error('documentType') border-red-500 @enderror">
                                    <option value="">Selecciona el tipo</option>
                                    <option value="dni_frontal">DNI Frontal</option>
                                    <option value="dni_trasero">DNI Trasero</option>
                                    <option value="otros">Otros documentos</option>
                                </select>
                                @error('documentType') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                
                                @if($documentType === 'otros')
                                    <div class="mb-3">
                                        <label class="block text-sm font-semibold text-titanium mb-2">
                                            Descripción del documento
                                        </label>
                                        <input type="text" wire:model.live="documentLabel" 
                                            placeholder="Ej: Certificado médico, Autorización..." 
                                            class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary text-black-deep text-sm @error('documentLabel') border-red-500 @enderror">
                                        @error('documentLabel') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                                
                                @if($documentType)
                                    <label class="block text-sm font-semibold text-titanium mb-2">
                                        Archivo
                                    </label>
                                    
                                    @if(in_array($documentType, ['dni_frontal', 'dni_trasero']))
                                    <!-- Opción de captura de foto para DNI -->
                                    <div class="space-y-3">
                                        <div class="flex gap-2">
                                            <button type="button" wire:click="$set('captureMode', true)" 
                                                class="flex-1 px-4 py-2 bg-primary/10 text-primary rounded-xl font-semibold text-sm hover:bg-primary/20 transition-colors">
                                                📷 Tomar Foto
                                            </button>
                                            <label class="flex-1 cursor-pointer">
                                                <div class="px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors text-center">
                                                    📁 Subir Archivo
                                                </div>
                                                <input type="file" id="dni-file-input" accept="image/*" class="hidden" onchange="handleDniFileSelect(event)">
                                            </label>
                                        </div>
                                        
                                        @if($captureMode)
                                            <div class="border-2 border-dashed border-primary rounded-xl p-4">
                                                <div class="relative bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/10;">
                                                    <video id="camera-preview" autoplay playsinline class="w-full h-full object-cover"></video>
                                                    <!-- Guías de DNI -->
                                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                                        <div class="border-4 border-white/50 rounded-xl" style="width: 85%; height: 60%; box-shadow: 0 0 0 9999px rgba(0,0,0,0.5);"></div>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2 mt-3">
                                                    <button type="button" onclick="capturePhoto()" 
                                                        class="flex-1 px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                                                        📸 Capturar
                                                    </button>
                                                    <button type="button" wire:click="$set('captureMode', false)" 
                                                        class="px-4 py-2 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
                                                        ✕ Cancelar
                                                    </button>
                                                </div>
                                                <canvas id="photo-canvas" class="hidden"></canvas>
                                            </div>
                                        @endif
                                        
                                        <!-- Editor de imagen DNI -->
                                        <div id="dni-editor" class="hidden border-2 border-dashed border-primary rounded-xl p-4">
                                            <div class="mb-3">
                                                <img id="dni-crop-image" style="max-width: 100%; display: block;">
                                            </div>
                                            <div class="flex gap-2">
                                                <button type="button" onclick="cropAndUploadDni()" 
                                                    class="flex-1 px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors">
                                                    ✂️ Recortar y Usar
                                                </button>
                                                <button type="button" onclick="cancelDniCrop()" 
                                                    class="px-4 py-2 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition-colors">
                                                    ✕ Cancelar
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Input oculto para Livewire -->
                                        <input type="file" wire:model.live="document" id="dni-livewire-input" accept="image/*" class="hidden">
                                    </div>
                                @else
                                    <!-- Subida normal de archivos para otros documentos -->
                                    <input type="file" wire:model.live="document" 
                                        accept=".pdf,.jpg,.jpeg,.png" 
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                @endif
                                
                                <div wire:loading wire:target="document" class="text-xs text-primary mt-1">
                                    <svg class="animate-spin h-3 w-3 inline mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Subiendo...
                                </div>
                                
                                @if ($document && !$captureMode)
                                    <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-lg">
                                        <p class="text-xs text-green-700">✓ Archivo seleccionado: {{ $document->getClientOriginalName() }}</p>
                                    </div>
                                @endif
                                
                                @error('document') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                
                                <!-- Botón para subir documento -->
                                @if($document)
                                    <button type="button" wire:click="uploadDocument" 
                                        class="mt-3 w-full px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition-colors shadow-md hover:shadow-lg">
                                        <span wire:loading.remove wire:target="uploadDocument">📤 Subir Documento</span>
                                        <span wire:loading wire:target="uploadDocument">
                                            <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Subiendo...
                                        </span>
                                    </button>
                                @endif
                            @endif
                            </div>
                        </div>
                        
                        @error('document') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            @if(in_array($documentType, ['dni_frontal', 'dni_trasero']))
                                Máximo 5MB. Solo imágenes (JPG, PNG)
                            @else
                                Máximo 5MB. Formatos: PDF, JPG, PNG
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </form>

        <!-- Equipos del Entrenador -->
        @if($coachTeams->isNotEmpty())
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8 mt-6">
            <h3 class="text-xl font-bold text-titanium mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Equipos que Entrena
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-silver/30">
                    <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Categoría</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Edades</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Sección</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white-pure divide-y divide-silver/30">
                        @foreach($coachTeams as $team)
                            <tr class="hover:bg-primary/5">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-black-deep">{{ $team->team }}</div>
                                    @if($team->description)
                                        <div class="text-xs text-gray-500">{{ $team->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $team->category->category ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($team->category)
                                        <div class="text-sm font-medium text-primary">
                                            {{ $team->category->from_age }} - {{ $team->category->to_age }} años
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $team->season->season ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($team->section)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white shadow-sm" 
                                              style="background-color: {{ $team->section->color ?? '#8B5CF6' }}">
                                            {{ $team->section->name }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        
        <script>
            let stream = null;
            let currentComponent = null;
            let cropper = null;
            let profilePhotoCropper = null;
            
            document.addEventListener('livewire:initialized', () => {
                currentComponent = @this;
                
                // Observar cambios en captureMode
                Livewire.hook('morph.updated', ({ el, component }) => {
                    if (currentComponent && currentComponent.captureMode) {
                        setTimeout(() => startCamera(), 100);
                    }
                });
            });
            
            // Manejar selección de foto de perfil para recortar
            function handleProfilePhotoSelect(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                // Mostrar editor de recorte
                const editor = document.getElementById('profile-photo-editor');
                const image = document.getElementById('profile-crop-image');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    editor.classList.remove('hidden');
                    
                    // Destruir cropper anterior si existe
                    if (profilePhotoCropper) {
                        profilePhotoCropper.destroy();
                    }
                    
                    // Inicializar Cropper con proporción cuadrada para foto de perfil
                    profilePhotoCropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 0.9,
                        responsive: true,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            }
            
            // Recortar y subir foto de perfil
            function cropAndUploadProfilePhoto() {
                if (!profilePhotoCropper) return;
                
                profilePhotoCropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                }).toBlob(function(blob) {
                    const timestamp = Date.now();
                    const file = new File([blob], `profile-photo-${timestamp}.jpg`, { type: 'image/jpeg' });
                    
                    // Asignar al input de Livewire
                    const livewireInput = document.getElementById('profile-photo-livewire-input');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    livewireInput.files = dataTransfer.files;
                    
                    // Disparar evento change para Livewire
                    const event = new Event('change', { bubbles: true });
                    livewireInput.dispatchEvent(event);
                    
                    // Cerrar editor
                    cancelProfilePhotoCrop();
                }, 'image/jpeg', 0.95);
            }
            
            // Cancelar recorte de foto de perfil
            function cancelProfilePhotoCrop() {
                const editor = document.getElementById('profile-photo-editor');
                const fileInput = document.getElementById('profile-photo-file-input');
                
                if (profilePhotoCropper) {
                    profilePhotoCropper.destroy();
                    profilePhotoCropper = null;
                }
                
                editor.classList.add('hidden');
                fileInput.value = '';
            }
            
            // Manejar selección de archivo DNI para recortar
            function handleDniFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                // Mostrar editor de recorte
                const editor = document.getElementById('dni-editor');
                const image = document.getElementById('dni-crop-image');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    editor.classList.remove('hidden');
                    
                    // Destruir cropper anterior si existe
                    if (cropper) {
                        cropper.destroy();
                    }
                    
                    // Inicializar Cropper con proporción de DNI (85.6mm x 53.98mm ≈ 1.586:1)
                    cropper = new Cropper(image, {
                        aspectRatio: 1.586,
                        viewMode: 1,
                        autoCropArea: 0.9,
                        responsive: true,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            }
            
            // Recortar y subir imagen DNI
            function cropAndUploadDni() {
                if (!cropper) return;
                
                cropper.getCroppedCanvas({
                    width: 1920,
                    height: 1210,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                }).toBlob(function(blob) {
                    const timestamp = Date.now();
                    const file = new File([blob], `dni-cropped-${timestamp}.jpg`, { type: 'image/jpeg' });
                    
                    // Asignar al input de Livewire
                    const livewireInput = document.getElementById('dni-livewire-input');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    livewireInput.files = dataTransfer.files;
                    
                    // Disparar evento change para Livewire
                    const event = new Event('change', { bubbles: true });
                    livewireInput.dispatchEvent(event);
                    
                    // Cerrar editor
                    cancelDniCrop();
                }, 'image/jpeg', 0.95);
            }
            
            // Cancelar recorte DNI
            function cancelDniCrop() {
                const editor = document.getElementById('dni-editor');
                const fileInput = document.getElementById('dni-file-input');
                
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                
                editor.classList.add('hidden');
                fileInput.value = '';
            }
            
            async function startCamera() {
                try {
                    const video = document.getElementById('camera-preview');
                    if (!video) return;
                    
                    stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { 
                            facingMode: 'environment',
                            width: { ideal: 1920 },
                            height: { ideal: 1080 }
                        } 
                    });
                    video.srcObject = stream;
                    await video.play();
                } catch (err) {
                    console.error('Error al acceder a la cámara:', err);
                    alert('No se pudo acceder a la cámara. Por favor, usa la opción de subir archivo.');
                    if (currentComponent) {
                        currentComponent.set('captureMode', false);
                    }
                }
            }
            
            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }
            
            async function capturePhoto() {
                const video = document.getElementById('camera-preview');
                const canvas = document.getElementById('photo-canvas');
                
                if (!video || !canvas) return;
                
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0);
                
                // Convertir canvas a blob
                canvas.toBlob(async (blob) => {
                    if (!blob) return;
                    
                    // Crear archivo desde el blob
                    const timestamp = Date.now();
                    const file = new File([blob], `dni-capture-${timestamp}.jpg`, { type: 'image/jpeg' });
                    
                    // Encontrar el input de Livewire
                    const livewireInput = document.getElementById('dni-livewire-input');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    livewireInput.files = dataTransfer.files;
                    
                    // Disparar evento change para Livewire
                    const event = new Event('change', { bubbles: true });
                    livewireInput.dispatchEvent(event);
                    
                    // Detener cámara y cerrar modo captura
                    stopCamera();
                    if (currentComponent) {
                        currentComponent.set('captureMode', false);
                    }
                }, 'image/jpeg', 0.9);
            }
            
            // Limpiar al salir
            window.addEventListener('beforeunload', () => {
                stopCamera();
                if (cropper) {
                    cropper.destroy();
                }
                if (profilePhotoCropper) {
                    profilePhotoCropper.destroy();
                }
            });
        </script>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ show: @entangle('confirmingDeletion') }" 
         x-show="show" 
         x-cloak
         class="fixed z-50 inset-0 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Eliminar Usuario
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer y se eliminarán todos sus archivos asociados.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteUser" wire:loading.attr="disabled" wire:target="deleteUser" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors disabled:opacity-70 disabled:cursor-not-allowed">
                        <svg wire:loading wire:target="deleteUser" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="deleteUser">Eliminar</span>
                        <span wire:loading wire:target="deleteUser">Eliminando...</span>
                    </button>
                    <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


