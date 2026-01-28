<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 bg-neon-green/10 border-l-4 border-neon-green text-black-deep px-4 py-3 rounded-lg shadow-sm" 
             role="alert">
            <span class="block sm:inline font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Header con contador y botón -->
    <div class="sticky top-16 z-10 bg-white-pure flex justify-between items-center p-6 border-b border-gray-100">
        <div>
            <h3 class="text-lg font-semibold text-primary">
                {{ $fields->total() }} campos encontrados
            </h3>
            @if($activeSeason)
                <p class="text-sm text-gray-600 mt-1">
                    Temporada: <span class="font-semibold text-titanium">{{ $activeSeason->season }}</span>
                </p>
            @else
                <p class="text-sm text-amber-600 mt-1">
                    <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    No hay temporada activa
                </p>
            @endif
        </div>
        <button wire:click="openCreateModal" type="button" class="inline-flex items-center px-6 py-2.5 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Campo
        </button>
    </div>

    <!-- Card Wrapper -->
    <div class=" bg-white-pure rounded-b-2xl shadow-xl border border-primary/10 overflow-hidden">
        <!-- Filtros -->
        <div class="p-6 border-b border-gray-100 ">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Búsqueda -->
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live="search" placeholder="Buscar campos..." class="w-full pl-10 pr-4 py-2.5 border-silver rounded-xl focus:ring-primary focus:border-primary transition-colors">
                </div>

                <!-- Tipo de campo -->
                <div>
                    <select wire:model.live="fieldTypeFilter" class="w-full px-4 py-2.5 border-silver rounded-xl focus:ring-primary focus:border-primary transition-colors">
                        <option value="">Todos los tipos</option>
                        <option value="futbol_11">Fútbol 11</option>
                        <option value="futbol_7">Fútbol 7</option>
                        <option value="futsal">Fútbol Sala</option>
                        <option value="polideportivo">Polideportivo</option>
                    </select>
                </div>

                <!-- Estado -->
                <div>
                    <select wire:model.live="activeFilter" class="w-full px-4 py-2.5 border-silver rounded-xl focus:ring-primary focus:border-primary transition-colors">
                        <option value="">Todos los estados</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla de campos -->
        <div class="overflow-x-auto max-h-[calc(100vh-400px)] overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Campo</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Superficie</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Horario</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Secciones</th>
                        <th class="px-3 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Entrenamientos</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Cap.</th>
                        <th class="px-3 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Estado</th>
                        <th class="px-3 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($fields as $field)
                        <tr class="hover:bg-primary/5 transition-colors duration-150">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full shadow-sm flex-shrink-0" style="background-color: {{ $field->color }}"></div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-black-deep">{{ $field->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($field->season)
                                    <span class="text-sm font-medium text-gray-700">{{ $field->season->season }}</span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $field->field_type_name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $field->surface_type_name }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($field->available_from && $field->available_to)
                                    <div class="text-xs text-gray-700">
                                        <span class="font-medium">{{ substr($field->available_from, 0, 5) }}</span>
                                        <span class="text-gray-400">-</span>
                                        <span class="font-medium">{{ substr($field->available_to, 0, 5) }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($field->sections->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($field->sections->take(2) as $section)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium text-white shadow-sm" 
                                                  style="background-color: {{ $section->color ?? '#8B5CF6' }}">
                                                {{ Str::limit($section->name, 15) }}
                                            </span>
                                        @endforeach
                                        @if($field->sections->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $field->sections->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                @if($field->schedules_count > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $field->schedules_count }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">0</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-center">
                                <span class="text-sm text-gray-700 font-medium">
                                    {{ $field->capacity ?? '-' }}
                                </span>
                            </td>
                            <td class="px-3 py-3">
                                @if($field->active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-neon-green/10 text-green-700">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                     <a wire:click="openEditModal({{ $field->id }})" 
                                        class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>

                                    {{-- <button  
                                            class="text-primary hover:text-primary/80 transition-colors" 
                                            title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button> --}}

                                    @if($field->schedules_count > 0)
                                        <button disabled
                                            title="No se puede eliminar: tiene {{ $field->schedules_count }} entrenamiento(s) programado(s)"
                                            class="inline-flex items-center px-3 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed opacity-50 text-xs font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    @else
                                        <button wire:click="confirmDelete({{ $field->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="confirmDelete"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-xs font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg wire:loading.remove wire:target="confirmDelete" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <svg wire:loading wire:target="confirmDelete" class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                    @endif

                                    {{-- <button wire:click="delete({{ $field->id }})" 
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este campo?')" 
                                            class="text-red-600 hover:text-red-800 transition-colors"
                                            title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="mt-4 text-sm text-gray-500 font-medium">No se encontraron campos de entrenamiento</p>
                                    <p class="mt-1 text-xs text-gray-400">Crea tu primer campo para comenzar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($fields->hasPages())
            <div class="px-6 py-4 border-t border-silver">
                {{ $fields->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Crear/Editar Campo -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $fieldId ? 'Editar Campo' : 'Crear Campo' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Campo *</label>
                                <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Tipo de Campo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Campo *</label>
                                <select wire:model="field_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="futbol_11">Fútbol 11</option>
                                    <option value="futbol_7">Fútbol 7</option>
                                    <option value="futsal">Fútbol Sala</option>
                                    <option value="polideportivo">Polideportivo</option>
                                </select>
                                @error('field_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Tipo de Superficie -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Superficie *</label>
                                <select wire:model="surface_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="cesped_natural">Césped Natural</option>
                                    <option value="cesped_artificial">Césped Artificial</option>
                                    <option value="tierra">Tierra</option>
                                    <option value="parquet">Parquet</option>
                                </select>
                                @error('surface_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Capacidad -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Capacidad (jugadores)</label>
                                <input type="number" wire:model="capacity" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('capacity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Color -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color (para visualización)</label>
                                <input type="color" wire:model="color" class="w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Horario Disponible Desde -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Disponible Desde</label>
                                <input type="time" wire:model="available_from" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('available_from') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Horario Disponible Hasta -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Disponible Hasta</label>
                                <input type="time" wire:model="available_to" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('available_to') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea wire:model="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Secciones -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Secciones que entrenan en este campo</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-48 overflow-y-auto p-3 border border-gray-200 rounded-md bg-gray-50">
                                    @forelse($allSections as $section)
                                        <label class="flex items-start space-x-2 p-2 hover:bg-white rounded transition-colors cursor-pointer">
                                            <input type="checkbox" 
                                                   wire:model="selectedSections" 
                                                   value="{{ $section->id }}" 
                                                   class="mt-0.5 rounded border-gray-300 text-primary focus:ring-primary">
                                            <span class="text-sm text-gray-700 leading-tight">{{ $section->name }}</span>
                                        </label>
                                    @empty
                                        <p class="col-span-full text-sm text-gray-500 text-center py-4">No hay secciones disponibles</p>
                                    @endforelse
                                </div>
                                @error('selectedSections') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Activo -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Campo activo</span>
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 font-semibold text-sm transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center px-4 py-2.5 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <svg wire:loading.remove wire:target="save" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="save">{{ $fieldId ? 'Actualizar' : 'Crear' }}</span>
                                <span wire:loading wire:target="save">{{ $fieldId ? 'Guardando...' : 'Creando...' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Eliminar Campo -->
    @if($showDeleteModal)
        <div x-data="{ show: @entangle('showDeleteModal').live }" 
             x-show="show" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     @click="show = false"></div>

                <!-- Modal panel -->
                <div x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Eliminar Campo
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que deseas eliminar el campo 
                                        <span class="font-semibold text-gray-900">{{ $fieldToDelete?->name }}</span>?
                                    </p>
                                    <p class="text-sm text-gray-500 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" 
                                wire:click="delete" 
                                wire:loading.attr="disabled" 
                                wire:target="delete"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg wire:loading.remove wire:target="delete" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <svg wire:loading wire:target="delete" class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="delete">Eliminar Campo</span>
                            <span wire:loading wire:target="delete">Eliminando...</span>
                        </button>
                        <button type="button" 
                                wire:click="closeDeleteModal"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
                document.documentElement.style.overflow = '';
                document.documentElement.classList.remove('overflow-hidden');
                setTimeout(() => {
                    document.body.removeAttribute('style');
                    document.body.classList.remove('overflow-hidden', 'overflow-y-hidden');
                    window.scrollTo(window.scrollX, window.scrollY);
                }, 150);
            });
        });
    </script>
</div>
