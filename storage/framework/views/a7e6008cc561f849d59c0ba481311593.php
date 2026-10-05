<button type="button" wire:click="addSelectedRecentTeams"
        wire:loading.attr="disabled" wire:target="addSelectedRecentTeams"
        <?php if(count($selectedRecentTeamIds) === 0): echo 'disabled'; endif; ?>
        class="flex-[2] px-4 py-3 rounded-xl bg-primary text-white text-xs font-bold disabled:opacity-50 disabled:cursor-not-allowed">
    <span wire:loading.remove wire:target="addSelectedRecentTeams">Añadir seleccionados (<?php echo e(count($selectedRecentTeamIds)); ?>)</span>
    <span wire:loading wire:target="addSelectedRecentTeams">Añadiendo equipos…</span>
</button>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/tournaments/_recent-teams-submit.blade.php ENDPATH**/ ?>