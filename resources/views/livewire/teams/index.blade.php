<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600">
                <span class="font-semibold text-primary text-lg">{{ $teams->total() }}</span> 
                <span class="text-titanium">{{ $teams->total() === 1 ? 'equipo encontrado' : 'equipos encontrados' }}</span>
            </div>
            @if($activeSeason)
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-600 text-white shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $activeSeason->season }} en curso
                </span>
            @endif
        </div>
        <button wire:click="openCreateModal" class="btn-primary inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Equipo
        </button>
    </div>

    <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <!-- Header with Search and Filters -->
        <div class="p-6 border-b border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Buscar equipos..." 
                        class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
                </div>
                <div>
                    <select wire:model.live="categoryFilter" 
                        class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select wire:model.live="seasonFilter" 
                        class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="">Todas las temporadas</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{ $season->season }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Teams Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Equipo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Género</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Sección</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Jugadores</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Entrenadores</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($teams as $team)
                        <tr class="hover:bg-primary/5">
                            <td class="px-6 py-4"><div class="text-sm font-semibold text-black-deep">{{ $team->team }}</div></td>
                            <td class="px-6 py-4"><div class="text-sm text-gray-600">{{ $team->description ?? '-' }}</div></td>
                            <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $team->category->category ?? '-' }}</div></td>
                            <td class="px-6 py-4">
                                @php
                                    $genderColors = [
                                        'masculino' => 'bg-blue-100 text-blue-800',
                                        'femenino' => 'bg-pink-100 text-pink-800',
                                        'mixto' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $genderIcons = [
                                        'masculino' => '♂',
                                        'femenino' => '♀',
                                        'mixto' => '⚥'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $genderColors[$team->gender] ?? 'bg-gray-100 text-gray-800' }}">
                                    <span class="mr-1">{{ $genderIcons[$team->gender] ?? '' }}</span>
                                    {{ ucfirst($team->gender) }}
                                </span>
                            </td>
                            <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $team->season->season ?? '-' }}</div></td>
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
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $team->players_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($team->coaches->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($team->coaches as $coach)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800" title="{{ $coach->email }}">
                                                @if($coach->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $coach->profile_photo_path) }}" 
                                                        class="w-4 h-4 rounded-full object-cover mr-1 border border-blue-200">
                                                @endif
                                                {{ $coach->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">Sin asignar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="openEditModal({{ $team->id }})" 
                                        class="text-primary hover:text-night-blue transition p-2 rounded-lg hover:bg-primary/5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $team->id }})" 
                                        class="text-red-600 hover:text-red-900 transition p-2 rounded-lg hover:bg-red-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No se encontraron equipos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teams->hasPages())
            <div class="px-6 py-4 border-t border-silver/30">{{ $teams->links() }}</div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Crear Equipo
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Nombre del Equipo *</label>
                    <input wire:model="team" type="text" 
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                    @error('team') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                    <textarea wire:model="description" rows="3"
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Categoría *</label>
                    <select wire:model="category_id" 
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="">Seleccione una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Género *</label>
                    <select wire:model="gender" 
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="mixto">Mixto</option>
                    </select>
                    @error('gender') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                    <input type="text" value="{{ $activeSeason ? $activeSeason->season : '' }}" disabled
                        class="w-full px-3 py-2 border border-silver rounded-xl bg-gray-100 text-gray-600 text-sm cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-1">Los equipos nuevos solo se pueden crear en la temporada activa</p>
                    @error('season_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Sección *</label>
                    <select wire:model="section_id" 
                        class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                        {{ !$season_id ? 'disabled' : '' }}>
                        <option value="">{{ $season_id ? 'Seleccione una sección' : 'Primero seleccione una temporada' }}</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    @if($season_id && $sections->isEmpty())
                        <p class="text-amber-600 text-xs mt-1">No hay secciones disponibles para esta temporada.</p>
                    @endif
                </div>

                <!-- Entrenadores del equipo -->
                @if($season_id && count($availableCoaches) > 0)
                <div class="pt-4 border-t border-silver/30">
                    <label class="block text-sm font-semibold text-titanium mb-3">
                        <svg class="w-5 h-5 inline mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Entrenadores del Equipo
                    </label>
                    
                    <div class="grid grid-cols-1 gap-2 max-h-48 overflow-y-auto">
                        @foreach($availableCoaches as $coach)
                            <label class="flex items-center p-2 border border-silver rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                <input type="checkbox" wire:model="selectedCoaches" value="{{ $coach->id }}"
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center">
                                        @if($coach->profile_photo_path)
                                            <img src="{{ asset('storage/' . $coach->profile_photo_path) }}" 
                                                class="w-6 h-6 rounded-full object-cover mr-2 border border-silver">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center mr-2">
                                                <span class="text-primary text-xs font-semibold">{{ substr($coach->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <p class="text-sm font-medium text-titanium">{{ $coach->name }}</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    
                    @if(count($selectedCoaches) > 0)
                        <p class="text-xs text-gray-600 mt-2">
                            <svg class="w-4 h-4 inline text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ count($selectedCoaches) }} entrenador(es) seleccionado(s)
                        </p>
                    @endif
                </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal">Cancelar</x-secondary-button>
            <button wire:click="save" class="ml-3 btn-primary inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm">
                Crear
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Equipo</x-slot>
        <x-slot name="content">¿Estás seguro de que deseas eliminar este equipo?</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deleteTeam">Eliminar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
