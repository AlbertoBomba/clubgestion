<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 class="font-bold text-2xl text-titanium leading-tight">
                {{ __('Jugadores') }}
            </h2>
            <a href="{{ route('players.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Jugador
            </a>
        </div>
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-gray-600">
                    <span class="font-semibold text-primary text-lg">{{ $players->total() }}</span> 
                    <span class="text-titanium">{{ $players->total() === 1 ? 'jugador encontrado' : 'jugadores encontrados' }}</span>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Buscar jugadores..." 
                        class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
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

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                    <tr>
                        <th wire:click="sortBy('id')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                ID
                                @if($sortField === 'id')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Foto</th>
                        <th wire:click="sortBy('surname')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Jugador
                                @if($sortField === 'surname')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('dni')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                DNI
                                @if($sortField === 'dni')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th wire:click="sortBy('dorsal')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Dorsal
                                @if($sortField === 'dorsal')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('position')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Posición
                                @if($sortField === 'position')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Contacto</th>
                        <th wire:click="sortBy('created_at')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Fecha Creación
                                @if($sortField === 'created_at')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('active')" class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider cursor-pointer hover:bg-primary/10 transition">
                            <div class="flex items-center">
                                Estado
                                @if($sortField === 'active')
                                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($sortDirection === 'asc')
                                            <path d="M5 10l5-5 5 5H5z"/>
                                        @else
                                            <path d="M5 10l5 5 5-5H5z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($players as $player)
                        <tr class="hover:bg-primary/5">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-600">{{ $player->id }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($player->player_photo)
                                    <img src="{{ asset('storage/' . $player->player_photo) }}" alt="{{ $player->full_name }}" class="w-12 h-12 rounded-full object-cover border-2 border-primary/20">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-night-blue flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-black-deep">{{ $player->full_name }}</div>
                                @if($player->email)
                                    <div class="text-xs text-gray-500">{{ $player->email }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4"><div class="text-sm">{{ $player->dni ?? '-' }}</div></td>
                            <td class="px-6 py-4">
                                @if($player->seasons->count() > 0)
                                    @foreach($player->seasons as $season)
                                        <span class="inline-block px-2 py-1 bg-primary/10 text-primary rounded-lg text-xs font-semibold mb-1 mr-1">{{ $season->season }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->dorsal)
                                    <span class="px-2 py-1 bg-primary/10 text-primary rounded-lg font-bold text-sm">{{ $player->dorsal }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4"><div class="text-sm">{{ $player->position ?? '-' }}</div></td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    @if($player->phone1)
                                        <div>{{ $player->phone1 }}</div>
                                    @endif
                                    @if($player->phone2)
                                        <div class="text-xs text-gray-500">{{ $player->phone2 }}</div>
                                    @endif
                                    @if(!$player->phone1 && !$player->phone2)
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ $player->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $player->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($player->active)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-neon-green/10 text-neon-green border border-neon-green/20">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-300">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('players.edit', $player->id) }}" 
                                        class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <button wire:click="confirmDelete({{ $player->id }})" 
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">No se encontraron jugadores</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($players->hasPages())
            <div class="px-6 py-4 border-t border-silver/30">{{ $players->links() }}</div>
        @endif>
    </div>

    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Jugador</x-slot>
        <x-slot name="content">¿Estás seguro de que deseas eliminar este jugador? Esta acción también eliminará su foto.</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deletePlayer" wire:loading.attr="disabled" wire:target="deletePlayer">
                <span wire:loading.remove wire:target="deletePlayer">Eliminar</span>
                <span wire:loading wire:target="deletePlayer" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Eliminando...
                </span>
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
