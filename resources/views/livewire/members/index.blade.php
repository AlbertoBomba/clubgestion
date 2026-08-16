<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Filtros --}}
    <div class="sticky top-16 z-10 bg-white-pure flex flex-col sm:flex-row gap-3 items-start sm:items-center p-6 border-b border-gray-100 rounded-t-2xl shadow-xl border border-primary/10">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live="search" type="text" placeholder="Buscar por nombre, apellido, DNI o email..."
                   class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400">
        </div>
        <select wire:model.live="seasonFilter"
                class="border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium min-w-[160px]">
            <option value="">Todas las temporadas</option>
            @foreach($seasons as $season)
                <option value="{{ $season->id }}">{{ $season->season }}</option>
            @endforeach
        </select>
        <select wire:model.live="statusFilter"
                class="border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium min-w-[130px]">
            <option value="">Todos</option>
            <option value="active">Activos</option>
            <option value="inactive">Inactivos</option>
        </select>
        {{-- <a href="{{ route('members.create') }}"
           class="inline-flex items-center px-4 py-3 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Socio
        </a> --}}
    </div>

    {{-- Tabla --}}
    <div class="bg-white-pure rounded-b-2xl shadow-xl border border-primary/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-silver/30">
                <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Nº Socio</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">DNI</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Teléfono</th>
                        {{-- <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Tipo</th> --}}
                        <th class="px-6 py-4 text-center text-xs font-semibold text-primary uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white-pure divide-y divide-silver/30">
                    @forelse($members as $member)
                        <tr class="hover:bg-primary/5 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono text-titanium">{{ $member->member_number ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">
                                            {{ strtoupper(substr($member->name, 0, 1) . substr($member->surname, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-semibold text-titanium">{{ $member->name }}</div>
                                        {{-- <div class="text-xs text-gray-400">{{ $member->name }}</div> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-black-deep">{{ $member->dni ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-black-deep">{{ $member->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-black-deep">{{ $member->phone ?? '-' }}</td>
                            {{-- <td class="px-6 py-4 text-sm text-black-deep">
                                {{ $seasonSelected->season ?? '-' }}
                            </td> --}}
                            {{-- <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                                    {{ $member->member_seasons_count }}
                                    
                                    {{ $member->memberSeasons->first()?->memberType?->name ?? 'Sin tipo asignado' }}
                                </span>
                            </td> --}}
                            <td class="px-6 py-4 text-center">
                                @if($member->active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Activo</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('members.edit', $member->id) }}"
                                       class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors text-xs font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Ficha
                                    </a>
                                    {{-- <button wire:click="confirmDelete({{ $member->id }})"
                                            class="inline-flex items-center px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors text-xs font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                No se encontraron socios
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="px-6 py-4 border-t border-silver/30">
                {{ $members->links() }}
            </div>
        @endif
    </div>

    {{-- Modal confirmación eliminar --}}
    @if($confirmingDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Eliminar socio</h3>
                        <p class="text-sm text-gray-500">Se eliminará el socio y todo su historial.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="$set('confirmingDeletion', false)"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button wire:click="deleteMember"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl font-semibold text-sm hover:bg-red-700 transition-colors">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
