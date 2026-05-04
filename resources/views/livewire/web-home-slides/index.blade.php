<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white rounded-t-2xl flex items-center justify-between p-6 border border-gray-200 border-b-0">
        <div class="flex items-center gap-3">
            <p class="text-sm text-gray-500">Gestiona las diapositivas del carrusel — imagen o vídeo corto</p>
            @if($slides->count() > 1)
                <span class="inline-flex items-center gap-1 text-xs text-blue-600 font-semibold bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    Arrastra para reordenar
                </span>
            @endif
        </div>
        <a href="{{ route('web-home-slides.create') }}"
           class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold bg-blue-600 hover:bg-blue-700 shadow-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Slide
        </a>
    </div>

    <!-- Sortable list -->
    <div class="bg-white rounded-b-2xl shadow-xl border border-gray-200 border-t-0 overflow-hidden">

        @if($slides->count() > 0)
            <div id="slides-sortable" class="divide-y divide-gray-100" data-wire-id="{{ $this->getId() }}">
                @foreach($slides as $index => $slide)
                    <div class="slide-row flex items-center gap-4 px-4 py-3 hover:bg-gray-50 transition-colors group"
                         data-id="{{ $slide->id }}"
                         wire:key="slide-{{ $slide->id }}">

                        {{-- Drag handle --}}
                        <div class="drag-handle flex-shrink-0 cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500 transition-colors px-1"
                             title="Arrastra para reordenar">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM8 13.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM8 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM16 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM16 13.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM16 21a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                        </div>

                        {{-- Número de orden --}}
                        <div class="flex-shrink-0 w-7 text-center">
                            <span class="text-xl font-extrabold text-gray-200 order-badge">{{ $index + 1 }}</span>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="flex-shrink-0">
                            @if($slide->media_path && $slide->media_type === 'image')
                                <img src="{{ Storage::url($slide->media_path) }}"
                                     alt="Preview"
                                     class="w-28 h-16 object-cover rounded-lg shadow-sm">
                            @elseif($slide->media_path && $slide->media_type === 'video')
                                <div class="w-28 h-16 bg-gray-800 rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-6 h-6 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-28 h-16 rounded-lg flex items-center justify-center shadow-sm"
                                     style="background-color: {{ $slide->background_color ?? '#1E40AF' }}">
                                    <span class="text-white text-xs font-bold opacity-80">Color</span>
                                </div>
                            @endif
                        </div>

                        {{-- Título / subtítulo --}}
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 truncate">
                                {{ $slide->title ?: '— Sin título —' }}
                            </div>
                            @if($slide->subtitle)
                                <div class="text-xs text-gray-500 truncate mt-0.5">{{ $slide->subtitle }}</div>
                            @endif
                            @if($slide->button_text)
                                <div class="text-xs text-blue-500 mt-0.5">
                                    <span class="font-medium">Botón:</span> {{ $slide->button_text }}
                                </div>
                            @endif
                        </div>

                        {{-- Tipo --}}
                        <div class="flex-shrink-0 hidden sm:block">
                            @if($slide->media_type === 'image')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                    🖼️ Imagen
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                                    🎬 Vídeo
                                </span>
                            @endif
                        </div>

                        {{-- Toggle activo --}}
                        <div class="flex-shrink-0">
                            <button wire:click="toggleActive({{ $slide->id }})"
                                    title="{{ $slide->active ? 'Activo — click para desactivar' : 'Inactivo — click para activar' }}"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $slide->active ? 'bg-green-500' : 'bg-gray-200' }}">
                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $slide->active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                            </button>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex-shrink-0 flex items-center gap-2">
                            <a href="{{ route('web-home-slides.edit', $slide->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                Editar
                            </a>
                            <button wire:click="confirmDelete({{ $slide->id }})"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-xs text-gray-400 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                El orden se guarda automáticamente al arrastrar
            </div>
        @else
            <div class="text-center py-20 px-6">
                <div class="text-6xl mb-4 opacity-30">🖼️</div>
                <p class="text-xl text-gray-400 font-semibold mb-2">No hay slides configurados</p>
                <p class="text-sm text-gray-400 mb-8">Crea el primer slide para personalizar la portada pública de tu club</p>
                <a href="{{ route('web-home-slides.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Crear primer slide
                </a>
            </div>
        @endif
    </div>

    <!-- Modal confirmación borrado -->
    @if($confirmingDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4">
                <div class="text-center">
                    <div class="text-5xl mb-4">🗑️</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">¿Eliminar este slide?</h3>
                    <p class="text-sm text-gray-500 mb-6">Esta acción no se puede deshacer. El archivo multimedia también será eliminado.</p>
                    <div class="flex gap-3 justify-center">
                        <button wire:click="cancelDelete"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                            Cancelar
                        </button>
                        <button wire:click="delete"
                                class="px-5 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors">
                            Sí, eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"></script>
<script>
(function () {
    function initSlidesSortable() {
        const el = document.getElementById('slides-sortable');
        if (!el) return;

        if (el._sortableInstance) {
            el._sortableInstance.destroy();
        }

        el._sortableInstance = Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'bg-blue-50',
            dragClass: 'shadow-2xl',
            onEnd() {
                const ids = [...el.querySelectorAll('.slide-row')].map(row => parseInt(row.dataset.id));

                // Update order badges optimistically
                el.querySelectorAll('.order-badge').forEach((badge, i) => {
                    badge.textContent = i + 1;
                });

                // Call Livewire method via wire:id (Livewire v3)
                const wireId = el.dataset.wireId;
                if (wireId) {
                    Livewire.find(wireId).call('updateOrder', ids);
                }
            }
        });
    }

    document.addEventListener('livewire:initialized', initSlidesSortable);
    document.addEventListener('livewire:navigated', initSlidesSortable);
})();
</script>
@endpush