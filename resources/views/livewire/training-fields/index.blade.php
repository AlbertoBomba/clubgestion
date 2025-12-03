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
    <div class="mb-6 flex justify-between items-center">
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
        <button wire:click="openCreateModal" type="button" class="inline-flex items-center px-6 py-2.5 bg-primary text-white rounded-lg font-semibold text-sm hover:bg-primary/90 hover:-translate-y-1 transition-all duration-200 shadow-md hover:shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Campo
        </button>
    </div>

    <!-- Card Wrapper -->
    <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <!-- Filtros -->
        <div class="p-6 border-b border-silver">
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
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Campo</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Superficie</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Horario</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Secciones</th>
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
                                    <button wire:click="openEditModal({{ $field->id }})" 
                                            class="text-primary hover:text-primary/80 transition-colors" 
                                            title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $field->id }})" 
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este campo?')" 
                                            class="text-red-600 hover:text-red-800 transition-colors"
                                            title="Eliminar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12">
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
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" class="btn-primary">
                                {{ $fieldId ? 'Actualizar' : 'Crear' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
