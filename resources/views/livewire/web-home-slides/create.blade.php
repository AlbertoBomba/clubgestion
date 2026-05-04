<div class="space-y-6 bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <a href="{{ route('web-home-config.edit') }}" class="font-bold text-2xl text-blue-600 hover:underline">
                Portada Web
            </a>
            <span class="text-2xl text-gray-400">/</span>
            <h2 class="font-bold text-2xl text-gray-700">Nuevo Slide</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('web-home-config.edit') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                Cancelar
            </a>
            <button type="submit" form="slide-form"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg">
                Crear Slide
            </button>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save" id="slide-form" class="p-6 space-y-8">

        <!-- Sección: Textos -->
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Textos del slide</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Título principal</label>
                    <input wire:model.live="title" type="text" placeholder="Ej: BIENVENIDOS AL CLUB"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subtítulo</label>
                    <input wire:model.live="subtitle" type="text" placeholder="Ej: Formando campeones desde 1980"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('subtitle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Texto del botón</label>
                    <input wire:model.live="button_text" type="text" placeholder="Ej: Únete Ahora"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('button_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL del botón</label>
                    <input wire:model.live="button_url" type="text" placeholder="Ej: /inscripcion o https://..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('button_url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Sección: Media -->
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Imagen o Vídeo de fondo</h3>

            <!-- Tipo de media -->
            <div class="flex gap-4 mb-5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" wire:model.live="media_type" value="image" class="w-4 h-4 text-blue-600">
                    <span class="text-sm font-semibold text-gray-700">🖼️ Imagen</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" wire:model.live="media_type" value="video" class="w-4 h-4 text-blue-600">
                    <span class="text-sm font-semibold text-gray-700">🎬 Vídeo corto</span>
                </label>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
                <!-- Upload -->
                <div>
                    @if($media_type === 'image')
                        {{-- ── SELECTOR CON RECORTE ──────────────────────── --}}
                        <div x-data="cropperInit()" class="space-y-3">
                            <input type="file" x-ref="fileInput" accept="image/jpeg,image/png,image/gif,image/webp"
                                   class="hidden" @change="onFileSelected($event)">
                            <label class="block text-sm font-semibold text-gray-700">
                                Imagen de fondo
                                <span class="text-gray-400 font-normal">(JPG, PNG, WebP — máx. 5 MB)</span>
                            </label>
                            <button type="button" @click="$refs.fileInput.click()"
                                    class="flex items-center justify-center gap-2 w-full px-4 py-4 border-2 border-dashed border-gray-300 rounded-xl text-sm text-gray-500 hover:border-blue-400 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Seleccionar imagen y recortar...
                            </button>
                            {{-- Progreso --}}
                            <div x-show="uploading" class="space-y-2">
                                <div class="flex items-center gap-2 text-sm text-blue-600">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <span>Subiendo imagen... <span x-text="uploadProgress + '%'"></span></span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-blue-600 h-1.5 rounded-full transition-all" :style="'width:' + uploadProgress + '%'"></div>
                                </div>
                            </div>
                            {{-- Preview recortada --}}
                            <div x-show="croppedPreview">
                                <p class="text-xs text-green-600 font-semibold mb-2">✓ Imagen recortada lista para guardar</p>
                                <img :src="croppedPreview" class="w-full h-48 object-cover rounded-xl shadow-md">
                                <button type="button" @click="$refs.fileInput.click()"
                                        class="mt-2 text-xs text-blue-600 hover:underline font-semibold">Cambiar imagen</button>
                            </div>
                            {{-- Modal recortador --}}
                            <template x-teleport="body">
                                <div x-show="showCropper" style="display:none"
                                     class="fixed inset-0 z-[9999] bg-black/80 flex items-center justify-center p-4">
                                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden" @click.stop>
                                        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                                            <h3 class="font-bold text-gray-800 text-lg">✂️ Recortar imagen</h3>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Proporción:</span>
                                                <button type="button" @click="setAspectRatio(16/9)"
                                                        class="text-xs px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold border border-blue-200">16:9</button>
                                                <button type="button" @click="setAspectRatio(3/1)"
                                                        class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold">3:1</button>
                                                <button type="button" @click="setAspectRatio(NaN)"
                                                        class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-semibold">Libre</button>
                                            </div>
                                        </div>
                                        <div class="bg-gray-900 flex items-center justify-center" style="height:420px;overflow:hidden;">
                                            <img x-ref="cropperImg" class="block" style="max-height:420px;max-width:100%;">
                                        </div>
                                        <div class="flex items-center justify-between px-5 py-4 border-t border-gray-100">
                                            <div class="flex gap-2">
                                                <button type="button" @click="cropperInstance && cropperInstance.rotate(-90)"
                                                        class="text-xs px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 font-semibold">↺ -90°</button>
                                                <button type="button" @click="cropperInstance && cropperInstance.rotate(90)"
                                                        class="text-xs px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 font-semibold">↻ +90°</button>
                                                <button type="button" @click="cropperInstance && cropperInstance.reset()"
                                                        class="text-xs px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 font-semibold">↺ Reset</button>
                                            </div>
                                            <div class="flex gap-3">
                                                <button type="button" @click="closeCropper()"
                                                        class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200">Cancelar</button>
                                                <button type="button" @click="applyCrop($wire)"
                                                        class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg">✓ Aplicar recorte</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @error('media_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    @else
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Vídeo de fondo
                            <span class="text-gray-400 font-normal">(MP4, MOV, WebM — máx. 50 MB)</span>
                        </label>
                        <input wire:model="media_file" type="file" accept="video/mp4,video/quicktime,video/webm"
                               class="w-full px-4 py-3 border border-dashed border-gray-300 rounded-xl text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-50 file:text-purple-700 file:font-semibold hover:file:bg-purple-100 cursor-pointer">
                        @error('media_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="media_file" class="mt-2 text-sm text-blue-600 flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Subiendo archivo...
                        </div>
                    @endif
                </div>

                <!-- Color de fondo alternativo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Color de fondo
                        <span class="text-gray-400 font-normal">(se usa si no hay imagen/vídeo)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input wire:model.live="background_color" type="color"
                               class="h-12 w-16 border border-gray-300 rounded-lg cursor-pointer p-1">
                        <input wire:model.live="background_color" type="text"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="#1E40AF">
                    </div>
                    @error('background_color') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Sección: Orden y estado -->
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Configuración</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-center">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Orden de aparición</label>
                    <input wire:model.live="order" type="number" min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('order') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <input wire:model.live="active" type="checkbox" id="active"
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                    <label for="active" class="text-sm font-semibold text-gray-700 cursor-pointer">
                        Slide activo (visible en portada)
                    </label>
                </div>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
function cropperInit() {
    return {
        showCropper: false,
        cropperInstance: null,
        croppedPreview: null,
        uploading: false,
        uploadProgress: 0,


        onFileSelected(event) {
            const file = event.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.showCropper = true;
                this.$nextTick(() => {
                    if (this.cropperInstance) { this.cropperInstance.destroy(); this.cropperInstance = null; }
                    this.$refs.cropperImg.src = e.target.result;
                    this.cropperInstance = new Cropper(this.$refs.cropperImg, {
                        aspectRatio: 16 / 9,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.9,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                        responsive: true,
                    });
                });
            };
            reader.readAsDataURL(file);
        },

        setAspectRatio(ratio) {
            if (this.cropperInstance) this.cropperInstance.setAspectRatio(isNaN(ratio) ? NaN : ratio);
        },

        applyCrop(wire) {
            if (!this.cropperInstance) return;
            const canvas = this.cropperInstance.getCroppedCanvas({
                maxWidth: 2560, maxHeight: 1440,
                imageSmoothingEnabled: true, imageSmoothingQuality: 'high'
            });
            if (!canvas) return;
            this.croppedPreview = canvas.toDataURL('image/jpeg', 0.9);
            this.showCropper = false;
            canvas.toBlob((blob) => {
                const file = new File([blob], 'hero-slide.jpg', { type: 'image/jpeg' });
                if (this.cropperInstance) { this.cropperInstance.destroy(); this.cropperInstance = null; }
                this.uploading = true;
                this.uploadProgress = 0;
                wire.upload(
                    'media_file', file,
                    () => { this.uploading = false; },
                    () => { this.uploading = false; },
                    (progress) => { this.uploadProgress = progress; }
                );
            }, 'image/jpeg', 0.9);
        },

        closeCropper() {
            this.showCropper = false;
            if (this.cropperInstance) { this.cropperInstance.destroy(); this.cropperInstance = null; }
            this.$refs.fileInput.value = '';
        }
    };
}
</script>
@endpush
