<button type="button" wire:click="addSelectedRecentTeams"
        wire:loading.attr="disabled" wire:target="addSelectedRecentTeams"
        @disabled(count($selectedRecentTeamIds) === 0)
        class="flex-[2] px-4 py-3 rounded-xl bg-primary text-white text-xs font-bold disabled:opacity-50 disabled:cursor-not-allowed">
    <span wire:loading.remove wire:target="addSelectedRecentTeams">Añadir seleccionados ({{ count($selectedRecentTeamIds) }})</span>
    <span wire:loading wire:target="addSelectedRecentTeams">Añadiendo equipos…</span>
</button>
