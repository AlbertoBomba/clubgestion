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

    <div class="sticky top-16 z-10 bg-white-pure mb-4 flex items-center justify-between p-6 border-b border-gray-100 rounded-t-2xl shadow-xl border border-primary/10">
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
        <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700 disabled:opacity-70 disabled:cursor-not-allowed">
            <svg wire:loading.remove wire:target="openCreateModal" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <svg wire:loading wire:target="openCreateModal" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="openCreateModal">Nuevo Equipo</span>
            <span wire:loading wire:target="openCreateModal">Cargando...</span>
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
                        <tr class="hover:bg-primary/5 {{ $highlightTeam == $team->id ? 'bg-green-50 border-l-4 border-green-500 animate-pulse' : '' }}" 
                            id="team-{{ $team->id }}">
                            <td class="px-6 py-4"><div class="text-sm font-semibold text-black-deep">{{ $team->team }}</div></td>
                            <td class="px-6 py-4">
                                {{-- <div class="text-sm text-gray-600">{{ $team->description ?? '-' }}</div> --}}
                                <div class="flex gap-1 mt-1">
                                    @if($team->federate)
                                        <span class="inline-flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Federado
                                        </span>
                                    @endif
                                    
                                </div>
                            </td>
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
                                        class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </button>
                                    @if($team->payments_count > 0 || $team->players_count > 0)
                                        <!-- Botón deshabilitado con tooltip si tiene pagos o jugadores -->
                                        <div class="relative group">
                                            <button 
                                                disabled
                                                class="inline-flex items-center px-3 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed opacity-60 text-xs font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Eliminar
                                            </button>
                                            <div class="absolute hidden group-hover:block bottom-full right-0 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded whitespace-nowrap z-10 shadow-lg">
                                                @if($team->payments_count > 0 && $team->players_count > 0)
                                                    Este equipo tiene {{ $team->players_count }} {{ $team->players_count == 1 ? 'jugador' : 'jugadores' }} y {{ $team->payments_count }} {{ $team->payments_count == 1 ? 'pago generado' : 'pagos generados' }}
                                                @elseif($team->payments_count > 0)
                                                    Este equipo tiene {{ $team->payments_count }} {{ $team->payments_count == 1 ? 'pago generado' : 'pagos generados' }}
                                                @else
                                                    Este equipo tiene {{ $team->players_count }} {{ $team->players_count == 1 ? 'jugador' : 'jugadores' }}
                                                @endif
                                                <div class="absolute top-full right-4 transform -mt-1 border-4 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Botón normal si no tiene pagos ni jugadores -->
                                        <button wire:click="confirmDelete({{ $team->id }})" 
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
            {{ $showConfirmation ? 'Confirmar Creación de Equipo' : 'Crear Equipo' }}
        </x-slot>

        <x-slot name="content">
            @if(!$showConfirmation)
            <!-- Form Section -->
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                        <input type="text" value="{{ $activeSeason ? $activeSeason->season : '' }}" disabled
                            class="w-full px-3 py-2 border border-silver rounded-xl bg-gray-100 text-gray-600 text-sm cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">Los equipos nuevos solo se pueden crear en la temporada activa</p>
                        @error('season_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Nombre del Equipo *</label>
                        <input wire:model="team" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('team') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Categoría *</label>
                        <select wire:model="category_id" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="">Seleccionar..</option>
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
                        <label class="block text-sm font-semibold text-titanium mb-2">Sección *</label>
                        <select wire:model.live="section_id" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm"
                            {{ !$season_id ? 'disabled' : '' }}>
                            <option value="">{{ $season_id ? 'Seleccionar...' : 'Primero seleccione una temporada' }}</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('section_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        @if($season_id && $sections->isEmpty())
                            <p class="text-amber-600 text-xs mt-1">No hay secciones disponibles para esta temporada.</p>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-titanium mb-2">Precio Matrícula (€)</label>
                    <input wire:model.live="price" type="text" inputmode="decimal" pattern="[0-9]*[.,]?[0-9]*" maxlength="10"
                        class="w-32 px-3 py-2 border rounded-xl focus:ring-2 text-black-deep text-sm font-semibold @if(empty($price) || $price == 0) border-amber-400 bg-amber-50 focus:ring-amber-500 focus:border-amber-500 @else border-silver focus:ring-primary focus:border-transparent @endif"
                        placeholder="0.00">
                    @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                @if(empty($price) || $price == 0)
                    <div class="p-2 bg-amber-50 border border-amber-300 rounded-lg flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="text-xs text-amber-800 font-medium">No se generará la orden de pago a estos jugadores, si el precio de la matrícula es 0</span>
                    </div>
                @endif

                <div class="pt-4 border-t-2 border-blue-200">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-4">
                        <label class="flex items-start cursor-pointer group">
                            <input type="checkbox" wire:model.live="federate"
                                class="w-6 h-6 mt-0.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-all">
                            <div class="ml-4 flex-1">
                                <div class="flex items-center gap-2">
                                    <svg class="w-6 h-6 @if($federate) text-blue-600 @else text-blue-400 @endif transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-base font-bold @if($federate) text-blue-700 @else text-blue-600 @endif transition-colors">
                                        Equipo Federado
                                    </span>
                                    @if($federate)
                                        <span class="inline-flex items-center px-2 py-1 bg-blue-600 text-white rounded-full text-xs font-bold">
                                            ACTIVO
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-blue-700 mt-1 font-medium">Marca esta opción si el equipo está federado oficialmente</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            @else
            <!-- Confirmation Section -->
            <div class="space-y-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="ml-3 text-sm text-blue-800 font-medium">
                            Por favor, revisa los datos antes de crear el equipo. Los datos mostrados a continuación son los que se guardarán.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nombre del Equipo</label>
                        <p class="text-sm font-semibold text-titanium">{{ $confirmationData['team'] ?? '' }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Género</label>
                        <p class="text-sm text-titanium capitalize">{{ $confirmationData['gender'] ?? '' }}</p>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Descripción</label>
                        <p class="text-sm text-titanium">{{ $confirmationData['description'] ?? '-' }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Categoría</label>
                        <p class="text-sm text-titanium">{{ $confirmationData['category'] ?? '' }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Temporada</label>
                        <p class="text-sm text-titanium">{{ $confirmationData['season'] ?? '' }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Sección</label>
                        <p class="text-sm text-titanium">{{ $confirmationData['section'] ?? '' }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Equipo Federado</label>
                        <p class="text-sm">
                            @if($confirmationData['federate'] ?? false)
                                <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Sí
                                </span>
                            @else
                                <span class="text-gray-500">No</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Price Highlight -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Precio de Matrícula</label>
                    @if(!empty($confirmationData['price']) && $confirmationData['price'] > 0)
                        <div class="bg-green-50 border-2 border-green-500 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-500 rounded-full p-2">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-green-700">{{ number_format($confirmationData['price'], 2, ',', '.') }} €</p>
                                        <p class="text-xs text-green-600 font-medium mt-1">
                                            ⚠️ Este precio se usará para calcular las cuotas de pago de matrícula
                                        </p>
                                    </div>
                                </div>
                                <div class="bg-green-100 rounded-full p-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-amber-50 border-2 border-amber-400 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-lg font-bold text-amber-700">0,00 € - Matrícula Gratuita</p>
                                    <p class="text-xs text-amber-800 font-medium mt-1">
                                        No se generará orden de pago para los jugadores de este equipo
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            @if(!$showConfirmation)
                <x-secondary-button wire:click="closeModal">Cancelar</x-secondary-button>
                <button wire:click="save" wire:loading.attr="disabled" wire:target="save" class="ml-3 inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm disabled:opacity-70 disabled:cursor-not-allowed bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Continuar</span>
                    <span wire:loading wire:target="save">Validando...</span>
                </button>
            @else
                <x-secondary-button wire:click="backToForm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Volver
                </x-secondary-button>
                <button wire:click="confirmCreate" wire:loading.attr="disabled" wire:target="confirmCreate" class="ml-3 bg-green-600 hover:bg-green-700 inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm disabled:opacity-70 disabled:cursor-not-allowed transition-colors">
                    <svg wire:loading wire:target="confirmCreate" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <svg wire:loading.remove wire:target="confirmCreate" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span wire:loading.remove wire:target="confirmCreate">Confirmar y Crear</span>
                    <span wire:loading wire:target="confirmCreate">Creando...</span>
                </button>
            @endif
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Equipo</x-slot>
        <x-slot name="content">¿Estás seguro de que deseas eliminar este equipo?</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deleteTeam" wire:loading.attr="disabled" wire:target="deleteTeam">
                <span wire:loading.remove wire:target="deleteTeam">Eliminar</span>
                <span wire:loading wire:target="deleteTeam" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Eliminando...
                </span>
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    @if($highlightTeam)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const highlightedRow = document.getElementById('team-{{ $highlightTeam }}');
            if (highlightedRow) {
                // Scroll to the highlighted team
                highlightedRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Remove highlight after 3 seconds
                setTimeout(() => {
                    @this.set('highlightTeam', null);
                }, 3000);
            }
        });
    </script>
    @endif
</div>
