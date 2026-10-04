
<div class="bg-white-pure border border-silver rounded-2xl shadow-sm overflow-hidden">
    <div class="bg-gray-50 border-b border-silver px-5 py-3 flex items-center gap-2 flex-wrap">
        <h3 class="text-sm font-bold text-black-deep"><?php echo e($phase->name); ?></h3>
        <span class="text-[11px] font-black uppercase tracking-wider text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded-full">
            0/<?php echo e($slotCount); ?> equipos
        </span>
        <span class="text-xs text-titanium bg-gray-100 px-2 py-0.5 rounded-full">Sin equipos asignados aún</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-silver">
                    <th class="text-left text-xs font-semibold text-titanium px-5 py-3 w-10">#</th>
                    <th class="text-left text-xs font-semibold text-titanium px-4 py-3">Equipo</th>
                    <th class="text-center text-xs font-bold text-primary px-5 py-3 w-16">Pts</th>
                    <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">PJ</th>
                    <th class="text-center text-xs font-semibold text-green-700 px-3 py-3 w-12">G</th>
                    <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">E</th>
                    <th class="text-center text-xs font-semibold text-red-600 px-3 py-3 w-12">P</th>
                    <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GF</th>
                    <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">GC</th>
                    <th class="text-center text-xs font-semibold text-titanium px-3 py-3 w-12">DG</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($__slot = 1; $__slot <= $slotCount; $__slot++): ?>
                    <tr class="bg-indigo-50/30 hover:bg-indigo-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <span class="text-xs text-titanium font-semibold pl-1"><?php echo e($__slot); ?></span>
                        </td>
                        <td class="px-4 py-4 font-semibold">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-lg border border-dashed border-indigo-300 bg-white flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </span>
                                <span class="text-indigo-500 italic">Equipo <?php echo e($__slot); ?> · por definir</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center"><span class="text-xl font-black text-titanium/40">0</span></td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                        <td class="px-3 py-4 text-center text-titanium/40">0</td>
                    </tr>
                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\tournaments\_subset-placeholder-block.blade.php ENDPATH**/ ?>