@if (!$editingTeamId)
    <div class="grid grid-cols-2 gap-2 mb-4">
        <button type="button" wire:click="$set('teamCreationMode', 'new')"
                class="px-3 py-3 rounded-xl text-xs font-bold border transition-colors {{ $teamCreationMode === 'new' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-gray-50 text-gray-500 border-gray-100' }}">
            Crear desde cero
        </button>
        <button type="button" wire:click="$set('teamCreationMode', 'recent')"
                class="px-3 py-3 rounded-xl text-xs font-bold border transition-colors {{ $teamCreationMode === 'recent' ? 'bg-primary/10 text-primary border-primary/20' : 'bg-gray-50 text-gray-500 border-gray-100' }}">
            Equipos recientes
        </button>
    </div>
    @if ($teamCreationMode === 'recent')
        <p class="text-xs text-gray-500 mb-3">Equipos inscritos en torneos de tu club creados durante el último mes, aunque todavía no se hayan celebrado. Se conservan sus datos y acceso, sin grupo, jugadores ni historial.</p>
        @error('recentTeam') <p role="alert" class="text-red-600 text-xs mb-3">{{ $message }}</p> @enderror
        @error('selectedRecentTeamIds') <p role="alert" class="text-red-600 text-xs mb-3">{{ $message }}</p> @enderror
        @error('selectedRecentTeamIds.*') <p role="alert" class="text-red-600 text-xs mb-3">{{ $message }}</p> @enderror
        <div class="space-y-2 max-h-96 overflow-y-auto">
            @forelse ($recentTeams as $recentTeam)
                <div wire:key="recent-team-{{ $recentTeam->id }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50">
                    <input type="checkbox" wire:model.live="selectedRecentTeamIds" value="{{ $recentTeam->id }}"
                           wire:loading.attr="disabled" wire:target="addSelectedRecentTeams"
                           aria-label="Seleccionar {{ $recentTeam->displayName() }}"
                           class="w-5 h-5 shrink-0 rounded border-gray-300 text-primary focus:ring-primary">
                    @include('livewire.tournaments._mobile-match-team-logo', ['team' => $recentTeam, 'logoSize' => 'w-10 h-10'])
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-titanium break-words">{{ $recentTeam->displayName() }}</p>
                        <p class="text-[10px] text-gray-500">{{ $recentTeam->tournament->name }} · Creado el {{ $recentTeam->tournament->created_at->format('d/m/Y') }}</p>
                        @if ($recentTeam->tournamentCategory)
                            <p class="text-[10px] text-gray-500">{{ $recentTeam->tournamentCategory->name ?? $recentTeam->tournamentCategory->category?->category }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="p-5 text-center text-sm text-gray-500 bg-gray-50 rounded-xl">No hay equipos disponibles para añadir de otros torneos de tu club creados durante el último mes. Los equipos ya inscritos en esta categoría no se muestran.</p>
            @endforelse
        </div>
    @endif
@endif
