<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="p-6 sm:p-8">
            <!-- Layout de dos columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna Izquierda: Información del Usuario (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Información Básica -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Información Básica
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                <input wire:model="password" type="password" id="password" 
                                    class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('password') border-red-500 @enderror">
                                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-titanium mb-2">Confirmar contraseña *</label>
                                <input wire:model="password_confirmation" type="password" id="password_confirmation" 
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if(auth()->user()->isMaster() || session()->has('impersonator_id'))
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
                            @else
                                <div>
                                    <label class="block text-sm font-semibold text-titanium mb-2">Escuela deportiva</label>
                                    <div class="block w-full px-3 py-2 border border-silver rounded-xl bg-gray-50 text-gray-700 text-sm">
                                        {{ auth()->user()->sportsSchool->name }}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Los usuarios creados se asignarán a tu escuela automáticamente</p>
                                </div>
                            @endif

                            <div>
                                <label for="role" class="block text-sm font-semibold text-titanium mb-2">Rol *</label>
                                <select wire:model="role" id="role" 
                                    class="block w-full px-3 py-2 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm @error('role') border-red-500 @enderror">
                                    <option value="">Selecciona un rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Foto de Perfil -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Foto de Perfil
                        </h3>

                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Imagen de perfil</label>
                            <input wire:model="profile_photo" type="file" accept="image/*" 
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                            <div wire:loading wire:target="profile_photo" class="text-sm text-primary mt-1">
                                <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Subiendo foto...
                            </div>
                            @error('profile_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Máximo 2MB. Formatos: JPG, PNG</p>
                            
                            @if ($profile_photo)
                                <div class="mt-3 flex justify-center">
                                    <div>
                                        <p class="text-sm text-titanium mb-2 text-center">Vista previa:</p>
                                        <img src="{{ $profile_photo->temporaryUrl() }}" class="h-40 w-40 object-cover rounded-xl border-2 border-silver shadow-md">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="flex items-center space-x-3 pt-4">
                        <label for="is_active" class="flex items-center cursor-pointer">
                            <button type="button" wire:click="$toggle('is_active')" 
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ $is_active ? 'bg-neon-green' : 'bg-gray-300' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                            <div class="ml-3 text-titanium font-medium text-sm">Usuario activo</div>
                        </label>
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
                        <div>
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
                                        <input type="text" wire:model="documentLabel" 
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
                                        <input type="file" wire:model="document" id="dni-livewire-input" accept="image/*" class="hidden">
                                    </div>
                                @else
                                    <!-- Subida normal de archivos para otros documentos -->
                                    <input type="file" wire:model="document" 
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
                            @endif
                            </div>
                        </div>
                        
                        @error('document') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @if($documentType)
                            <p class="text-xs text-gray-500">
                                @if(in_array($documentType, ['dni_frontal', 'dni_trasero']))
                                    Máximo 5MB. Solo imágenes (JPG, PNG)
                                @else
                                    Máximo 5MB. Formatos: PDF, JPG, PNG
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-silver/30">
                <a href="{{ auth()->user()->isMaster() || session()->has('impersonator_id') ? route('school-users.index') : route('my-school-users.index') }}" 
                    class="inline-flex justify-center items-center px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                    class="btn-primary inline-flex justify-center items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all">
                    Crear Usuario
                </button>
            </div>
        </form>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        
        <script>
            let stream = null;
            let currentComponent = null;
            let cropper = null;
            
            document.addEventListener('livewire:initialized', () => {
                currentComponent = @this;
                
                // Observar cambios en captureMode
                Livewire.hook('morph.updated', ({ el, component }) => {
                    if (currentComponent && currentComponent.captureMode) {
                        setTimeout(() => startCamera(), 100);
                    }
                });
            });
            
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
            });
        </script>
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
            });
        </script>
</div>
