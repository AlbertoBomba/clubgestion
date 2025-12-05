<div class="space-y-6">
    <form wire:submit.prevent="save">
        <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8">
            
            <!-- Layout con dos columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Columna izquierda: Datos del equipo (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-titanium mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Datos del Equipo
                        </h3>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Nombre del Equipo *</label>
                        <input wire:model.live="teamName" type="text" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        @error('teamName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Descripción</label>
                        <textarea wire:model.live="description" rows="3"
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm resize-none"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Imagen del Equipo</label>
                        <div class="flex items-start gap-4">
                            <!-- Preview actual de la imagen -->
                            <div class="flex-shrink-0">
                                @if($team->team_image)
                                    <img src="{{ asset('storage/' . $team->team_image) }}" 
                                        class="w-48 h-32 rounded-xl object-cover border-2 border-silver shadow-sm">
                                @else
                                    <div class="w-48 h-32 rounded-xl bg-gray-100 border-2 border-dashed border-silver flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Upload input -->
                            <div class="flex-1">
                                <input type="file" wire:model.live="teamImage" accept="image/*" 
                                    class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                                @error('teamImage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500 mt-1">Imagen rectangular del equipo completo (ej: 1200x800px)</p>
                                
                                <!-- Preview temporal -->
                                @if($teamImage)
                                    <div class="mt-2">
                                        <p class="text-xs text-green-600 font-medium mb-1">Vista previa de la nueva imagen:</p>
                                        <img src="{{ $teamImage->temporaryUrl() }}" 
                                            class="w-48 h-32 rounded-xl object-cover border-2 border-primary shadow-sm">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Categoría *</label>
                        <select wire:model.live="category_id" 
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
                        <select wire:model.live="gender" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="mixto">Mixto</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Temporada *</label>
                        <select wire:model.live="season_id" 
                            class="w-full px-3 py-2 border border-silver rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                            <option value="">Seleccione una temporada</option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}">{{ $season->season }}</option>
                            @endforeach
                        </select>
                        @error('season_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-2">Sección *</label>
                        <select wire:model.live="section_id" 
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
                </div>

                <!-- Columna derecha: Entrenadores (1/3) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6">
                        <h3 class="text-lg font-bold text-titanium mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Entrenadores
                        </h3>
                        
                        @if(count($selectedCoaches) > 0)
                            <p class="text-xs text-gray-600 mb-3 p-2 bg-green-50 rounded-lg border border-green-200">
                                <svg class="w-4 h-4 inline text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ count($selectedCoaches) }} entrenador(es) seleccionado(s)
                            </p>
                        @endif
                        
                        @if(count($availableCoaches) === 0)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <p class="text-amber-800 text-sm">No hay entrenadores disponibles en esta escuela.</p>
                            </div>
                        @else
                            <div class="space-y-2 max-h-[600px] overflow-y-auto pr-2">
                                @foreach($availableCoaches as $coach)
                                    <label class="flex items-center p-3 border rounded-xl cursor-pointer transition-all
                                        {{ in_array($coach->id, $selectedCoaches) ? 'border-primary bg-primary/10 shadow-md' : 'border-silver hover:bg-gray-50' }}">
                                        <input type="checkbox" wire:model.live="selectedCoaches" value="{{ $coach->id }}"
                                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 flex-shrink-0">
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="flex items-center">
                                                @if($coach->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $coach->profile_photo_path) }}" 
                                                        class="w-8 h-8 rounded-full object-cover mr-2 border border-silver flex-shrink-0">
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-2 flex-shrink-0">
                                                        <span class="text-primary text-xs font-semibold">{{ substr($coach->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-titanium truncate">{{ $coach->name }}</p>
                                                    <p class="text-xs text-gray-500 truncate">{{ $coach->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 mt-6 border-t border-silver/30">
                <a href="{{ route('teams.index') }}" class="inline-flex justify-center items-center px-4 py-2 bg-silver/30 text-titanium rounded-xl font-semibold text-sm hover:bg-silver/50 transition-colors">
                    Cancelar
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn-primary inline-flex justify-center items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Guardar Cambios</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </div>
    </form>

    <!-- Listado de Jugadores del Equipo -->
    <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden p-6 sm:p-8">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-titanium flex items-center">
                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Jugadores del Equipo
                <span class="ml-2 px-2 py-1 bg-primary/10 text-primary rounded-lg text-xs font-semibold">
                    {{ $teamPlayers->count() }}
                </span>
            </h3>
        </div>

        @if($teamPlayers->isEmpty())
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-gray-600 font-medium">No hay jugadores asignados a este equipo</p>
                <p class="text-gray-500 text-sm mt-1">Los jugadores se pueden agregar desde la gestión de jugadores</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Jugador
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                DNI
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Fecha Nacimiento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Dorsal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-titanium uppercase tracking-wider">
                                Posición
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-titanium uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-titanium uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($teamPlayers as $player)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($player->player_photo)
                                            <img src="{{ asset('storage/' . $player->player_photo) }}" 
                                                class="w-10 h-10 rounded-full object-cover mr-3 border-2 border-silver">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center mr-3">
                                                <span class="text-primary text-sm font-semibold">{{ substr($player->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold text-titanium">{{ $player->name }} {{ $player->surname }}</div>
                                            <div class="text-xs text-gray-500">{{ $player->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-titanium">{{ $player->dni ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-titanium">
                                        {{ $player->dbirth ? $player->dbirth->format('d/m/Y') : '-' }}
                                    </div>
                                    @if($player->dbirth)
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($player->dbirth)->age }} años
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-primary">{{ $player->dorsal ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-titanium">{{ $player->position ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($player->active)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Botón Mover a otro equipo -->
                                        <button type="button" wire:click="openMovePlayerModal({{ $player->id }})"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors"
                                            title="Mover a otro equipo">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                            Mover
                                        </button>
                                        
                                        <!-- Botón Quitar del equipo -->
                                        <button type="button" wire:click="confirmRemovePlayer({{ $player->id }})"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors"
                                            title="Quitar del equipo">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Quitar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal: Confirmar eliminación de jugador -->
    <x-confirmation-modal wire:model.live="confirmingPlayerRemoval">
        <x-slot name="title">
            Quitar Jugador del Equipo
        </x-slot>

        <x-slot name="content">
            ¿Está seguro de quitar a este jugador del equipo? Esta acción no eliminará al jugador de la base de datos, solo lo quitará de este equipo.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelRemovePlayer">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="removePlayer" wire:loading.attr="disabled" wire:target="removePlayer">
                <span wire:loading.remove wire:target="removePlayer">Quitar del Equipo</span>
                <span wire:loading wire:target="removePlayer" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Quitando...
                </span>
            </x-danger-button>
                Quitar del Equipo
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Modal: Mover jugador a otro equipo -->
    <x-dialog-modal wire:model.live="showMovePlayerModal">
        <x-slot name="title">
            Mover Jugador a Otro Equipo
        </x-slot>

        <x-slot name="content">
            @if($playerToMoveName)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-blue-900 font-semibold text-sm">
                        <svg class="w-4 h-4 inline text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Jugador: {{ $playerToMoveName }}
                    </p>
                </div>
            @endif
            
            <p class="text-gray-700 mb-4">
                Seleccione el equipo al que desea mover al jugador:
            </p>
            
            @if($availableTeams->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <p class="text-amber-800 text-sm">
                        No hay otros equipos disponibles en esta temporada.
                    </p>
                </div>
            @else
                <select wire:model.live="targetTeamId" 
                    class="w-full px-3 py-2 border border-silver rounded-md focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep">
                    <option value="">Seleccione un equipo...</option>
                    @foreach($availableTeams as $availableTeam)
                        <option value="{{ $availableTeam->id }}">{{ $availableTeam->team }}</option>
                    @endforeach
                </select>
                @error('targetTeamId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            @endif
            
            <p class="text-xs text-gray-500 mt-3">
                <svg class="w-4 h-4 inline text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Solo se muestran equipos de la misma temporada y sección.
            </p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="cancelMovePlayer">
                Cancelar
            </x-secondary-button>

            <x-button class="ms-3" wire:click="movePlayer" wire:loading.attr="disabled" wire:target="movePlayer" :disabled="$availableTeams->isEmpty() || !$targetTeamId">
                <span wire:loading.remove wire:target="movePlayer">Mover Jugador</span>
                <span wire:loading wire:target="movePlayer" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Moviendo...
                </span>
            </x-button>
                Mover Jugador
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>

