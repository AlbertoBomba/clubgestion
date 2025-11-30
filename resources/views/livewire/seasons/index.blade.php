<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    <div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="Buscar temporadas..." 
                    class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Año Desde</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Año Hasta</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Players</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Secciones</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($seasons as $season)
                        @php
                            $isActive = $season->start_date && $season->end_date && 
                                        $season->start_date <= now() && 
                                        $season->end_date >= now();
                        @endphp
                        <tr class="{{ $isActive ? 'bg-green-50 hover:bg-green-100 border-l-4 border-green-600' : 'hover:bg-primary/5' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="text-sm font-semibold {{ $isActive ? 'text-green-700' : 'text-titanium' }}">
                                        {{ $season->season }}
                                    </div>
                                    @if($isActive)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-600 text-white shadow-sm">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            En Curso
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ $season->description ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-black-deep">{{ $season->from_year }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-black-deep">{{ $season->to_year }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                    {{ $season->players_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-neon-green/10 text-neon-green">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                    </svg>
                                    {{ $season->sections_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('seasons.edit', $season->id) }}" 
                                        class="text-primary hover:text-night-blue transition p-2 rounded-lg hover:bg-primary/5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button wire:click="confirmDelete({{ $season->id }})" 
                                        class="text-red-600 hover:text-red-900 transition p-2 rounded-lg hover:bg-red-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                No se encontraron temporadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($seasons->hasPages())
            <div class="px-6 py-4 border-t border-silver/30">
                {{ $seasons->links() }}
            </div>
        @endif
    </div>

    <x-dialog-modal wire:model="confirmingDeletion">
        <x-slot name="title">Eliminar Temporada</x-slot>
        <x-slot name="content">¿Estás seguro de que deseas eliminar esta temporada?</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDeletion', false)">Cancelar</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deleteSeason">Eliminar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
