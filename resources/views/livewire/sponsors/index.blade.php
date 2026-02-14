<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg">
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="sticky top-16 z-10 bg-white-pure flex items-center justify-between p-6 border-b border-gray-100">
        <h2 class="font-bold text-2xl text-titanium leading-tight">
            {{ __('Gestión de Patrocinadores') }}
        </h2>
        <div class="flex items-center space-x-4">
            @if(!$currentSeason)
                <span class="text-sm text-red-600 font-medium">⚠️ No hay temporada en curso</span>
            @endif
            <button wire:click="openCreateModal" 
                @if(!$currentSeason) disabled @endif
                class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Patrocinador
            </button>
        </div>
    </div>

    <div class="card-modern bg-white-pure rounded-b-2xl shadow-xl border border-primary/10 overflow-hidden">
        @if($currentSeason)
            <div class="px-6 py-3 bg-blue-50 border-b border-blue-100">
                <div class="flex items-center text-sm text-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>💡 Arrastra y suelta las tarjetas para cambiar el orden de los patrocinadores</span>
                </div>
            </div>
        @endif
        <div class="p-6 border-b border-gray-100">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="Buscar patrocinadores..." 
                    class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400">
            </div>
        </div>

        <!-- Grid de Cards -->
        <div class="p-6">
            @if($sponsors->count() > 0)
                <div id="sponsors-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($sponsors as $sponsor)
                        <div class="sponsor-card bg-white rounded-xl border-2 border-gray-200 hover:border-primary transition-all duration-200 overflow-hidden shadow-sm hover:shadow-lg {{ $currentSeason && $sponsor->season_id === $currentSeason->id ? 'cursor-move' : 'cursor-default' }}"
                             data-sponsor-id="{{ $sponsor->id }}"
                             data-season-id="{{ $sponsor->season_id }}">
                            
                            <!-- Header con número de orden -->
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                <div class="flex items-center space-x-2">
                                    @if($currentSeason && $sponsor->season_id === $currentSeason->id)
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                        </svg>
                                    @endif
                                    <span class="text-sm font-bold text-gray-600">#{{ $sponsor->order + 1 }}</span>
                                </div>
                                
                                <!-- Badge de temporada -->
                                <div class="flex items-center space-x-2">
                                    @if($currentSeason && $sponsor->season_id === $currentSeason->id)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Actual
                                        </span>
                                    @endif
                                    @if($sponsor->published)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Logo -->
                            <div class="p-6 bg-white flex items-center justify-center" style="min-height: 150px;">
                                @if($sponsor->logo)
                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" class="max-w-full max-h-32 object-contain">
                                @else
                                    <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Información -->
                            <div class="p-4 border-t border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-center mb-2 line-clamp-2" style="min-height: 3rem;">{{ $sponsor->name }}</h3>
                                
                                @if($sponsor->web)
                                    <a href="{{ $sponsor->web }}" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center justify-center mb-2">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Visitar web
                                    </a>
                                @endif

                                <div class="text-xs text-gray-500 text-center mb-3">
                                    {{ $sponsor->season->from_year }}/{{ $sponsor->season->to_year }}
                                </div>

                                <!-- Estado publicado -->
                                @if($currentSeason && $sponsor->season_id === $currentSeason->id)
                                    <button wire:click="togglePublished({{ $sponsor->id }})" 
                                        class="w-full mb-2 inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold transition-colors {{ $sponsor->published ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                        @if($sponsor->published)
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Publicado
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            No Publicado
                                        @endif
                                    </button>
                                @else
                                    <div class="w-full mb-2 inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold {{ $sponsor->published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $sponsor->published ? 'Publicado' : 'No Publicado' }}
                                    </div>
                                @endif

                                <!-- Botones de acción -->
                                @if($currentSeason && $sponsor->season_id === $currentSeason->id)
                                    <div class="flex space-x-2">
                                        <button wire:click="openEditModal({{ $sponsor->id }})" 
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Editar
                                        </button>
                                        <button wire:click="confirmDelete({{ $sponsor->id }})" 
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center text-xs text-gray-400 italic py-2">
                                        Solo editable en temporada actual
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-lg font-medium">No se encontraron patrocinadores</p>
                </div>
            @endif
        </div>

        @if($sponsors->hasPages())
            <div class="px-6 py-4 border-t border-silver/30">{{ $sponsors->links() }}</div>
        @endif
    </div>

    <!-- Modal de Creación/Edición -->
    @if($showModal)
        <div class="fixed inset-0 bg-black-deep bg-opacity-50 overflow-y-auto h-full w-full z-50" x-data="{ show: @entangle('showModal') }" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-2xl bg-white-pure" @click.away="$wire.showModal = false">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-titanium">
                        {{ $editMode ? 'Editar Patrocinador' : 'Nuevo Patrocinador' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="p-6">
                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-titanium mb-2">Nombre del Patrocinador *</label>
                            <input wire:model="name" type="text" id="name" class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Ej: Empresa ABC">
                            @error('name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Temporada (solo informativo) -->
                        <div>
                            <label class="block text-sm font-semibold text-titanium mb-2">Temporada</label>
                            @if($currentSeason)
                                <div class="w-full px-4 py-3 border border-silver rounded-xl bg-gray-50">
                                    <span class="text-titanium font-medium">{{ $currentSeason->from_year }}/{{ $currentSeason->to_year }}</span>
                                    <span class="text-xs text-gray-500 ml-2">(Temporada en curso)</span>
                                </div>
                            @else
                                <div class="w-full px-4 py-3 border border-red-300 rounded-xl bg-red-50">
                                    <span class="text-red-600 text-sm">⚠️ No hay una temporada en curso activa</span>
                                </div>
                            @endif
                        </div>

                        <!-- Logo -->
                        <div>
                            <label for="logo" class="block text-sm font-semibold text-titanium mb-2">Logo</label>
                            <input wire:model="logo" type="file" id="logo" accept="image/*" class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            @error('logo') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                            
                            @if($editMode && $existingLogo && !$logo)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600 mb-2">Logo actual:</p>
                                    <img src="{{ asset('storage/' . $existingLogo) }}" alt="Logo actual" class="w-32 h-32 object-contain border border-gray-200 rounded-lg">
                                </div>
                            @endif

                            @if($logo)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600 mb-2">Vista previa:</p>
                                    <img src="{{ $logo->temporaryUrl() }}" alt="Vista previa" class="w-32 h-32 object-contain border border-gray-200 rounded-lg">
                                </div>
                            @endif
                        </div>

                        <!-- Web -->
                        <div>
                            <label for="web" class="block text-sm font-semibold text-titanium mb-2">Sitio Web</label>
                            <input wire:model="web" type="url" id="web" class="w-full px-4 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="https://www.ejemplo.com">
                            @error('web') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Publicado -->
                        <div class="flex items-center">
                            <input wire:model="published" type="checkbox" id="published" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                            <label for="published" class="ml-3 block text-sm font-semibold text-titanium">Publicar en la web pública</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="$set('showModal', false)" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="save">{{ $editMode ? 'Actualizar' : 'Crear' }}</span>
                            <span wire:loading wire:target="save">Guardando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal de Confirmación de Eliminación -->
    @if($confirmingDeletion)
        <div class="fixed inset-0 bg-black-deep bg-opacity-50 overflow-y-auto h-full w-full z-50" x-data="{ show: @entangle('confirmingDeletion') }" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white-pure">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mt-5">Eliminar Patrocinador</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar este patrocinador? Esta acción no se puede deshacer.</p>
                    </div>
                    <div class="flex items-center justify-center space-x-3 px-4 py-3">
                        <button wire:click="$set('confirmingDeletion', false)" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200">
                            Cancelar
                        </button>
                        <button wire:click="deleteSponsor" class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        .sortable-ghost {
            opacity: 0.3;
        }
        .sortable-drag {
            opacity: 1 !important;
            cursor: grabbing !important;
            transform: rotate(3deg) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }
        .sponsor-card[data-season-id="{{ $currentSeason?->id ?? '' }}"]:hover {
            transform: translateY(-2px);
        }
        .sponsor-card[data-season-id="{{ $currentSeason?->id ?? '' }}"] {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
    </style>
    <script>
        let sortableInstance = null;

        function initSortable() {
            const el = document.getElementById('sponsors-grid');
            if (!el) return;

            // Destruir instancia anterior si existe
            if (sortableInstance) {
                sortableInstance.destroy();
            }

            sortableInstance = Sortable.create(el, {
                animation: 250,
                easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                filter: function(evt, target) {
                    // Solo permitir arrastrar cards de la temporada actual
                    const card = target.closest('.sponsor-card');
                    if (!card) return true;
                    const seasonId = card.getAttribute('data-season-id');
                    const currentSeasonId = '{{ $currentSeason?->id ?? "" }}';
                    return seasonId !== currentSeasonId;
                },
                onStart: function() {
                    document.body.style.cursor = 'grabbing';
                },
                onEnd: function(evt) {
                    document.body.style.cursor = '';
                    
                    const sponsorId = evt.item.getAttribute('data-sponsor-id');
                    const newIndex = evt.newIndex;
                    const oldIndex = evt.oldIndex;

                    if (newIndex !== oldIndex && sponsorId) {
                        // Encontrar el componente Livewire
                        const livewireComponent = evt.from.closest('[wire\\:id]');
                        if (livewireComponent) {
                            const componentId = livewireComponent.getAttribute('wire:id');
                            Livewire.find(componentId).call('updateOrder', parseInt(sponsorId), newIndex);
                        }
                    }
                }
            });
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initSortable, 100);
        });

        // Reinicializar después de actualizaciones de Livewire
        document.addEventListener('livewire:navigated', function() {
            setTimeout(initSortable, 100);
        });

        // Hook para Livewire 3
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('morph.updated', () => {
                setTimeout(initSortable, 100);
            });
            
            Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                succeed(({ snapshot, effect }) => {
                    queueMicrotask(() => {
                        setTimeout(initSortable, 100);
                    });
                });
            });
        }
    </script>
    @endpush
</div>
