<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracketData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $bracket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <section wire:key="mobile-bracket-<?php echo e($phaseId); ?>" class="bg-white-pure rounded-3xl p-4 shadow-sm border border-gray-100">
        <h3 class="text-sm font-black text-titanium"><?php echo e($bracket['phase']->name); ?></h3>
        <p class="text-[10px] text-gray-400 mt-1"><?php echo e($bracket['phase']->typeLabel()); ?> · <?php echo e($bracket['phase']->statusLabel()); ?></p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$bracket['hasMatches']): ?>
            <div class="mt-4 p-6 text-center border-2 border-dashed border-gray-200 rounded-2xl">
                <p class="text-xs font-bold text-gray-500">Sin cuadro generado</p>
                <p class="text-[10px] text-gray-400 mt-2">Todavía no hay partidos en esta fase eliminatoria.</p>
            </div>
        <?php else: ?>
            <?php
                $hasMatchNotes = $bracket['rounds']->flatten(1)->contains(fn ($match) => filled($match->notes));
                $matchHeight = $hasMatchNotes ? 160 : 112;
                $unit = $matchHeight + 32;
                $containerHeight = $bracket['numFirstRoundMatches'] * $unit;
            ?>
            <p class="text-[10px] text-gray-400 mt-3">Desliza para ver las rondas. Toca un partido para ver su marcador.</p>
            <div class="overflow-x-auto mt-4 pb-3" tabindex="0" aria-label="Rondas de <?php echo e($bracket['phase']->name); ?>">
                <div class="flex min-w-max items-start">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracket['rounds']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roundNum => $roundMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $roundIndex = $roundNum - $bracket['firstRound'];
                            $fromFinal = $bracket['totalRounds'] - 1 - $roundIndex;
                            $roundLabel = match ($fromFinal) {
                                0 => 'Final',
                                1 => 'Semifinal',
                                2 => 'Cuartos de Final',
                                3 => 'Octavos de Final',
                                4 => '16avos de Final',
                                default => 'Ronda ' . ($roundIndex + 1),
                            };
                            $isLast = $roundNum === $bracket['maxRound'];
                            $slotMultiplier = (int) pow(2, $roundIndex);
                        ?>
                        <div class="w-56 shrink-0">
                            <h4 class="h-8 text-center text-[10px] font-black <?php echo e($isLast ? 'text-amber-600' : 'text-gray-500'); ?>"><?php echo e($roundLabel); ?></h4>
                            <div class="relative" style="height: <?php echo e($containerHeight); ?>px;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roundMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matchIndex => $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $centerY = (int) (($matchIndex + 0.5) * $unit * $slotMultiplier);
                                    ?>
                                    <div class="absolute w-full" style="top: <?php echo e($centerY - $matchHeight / 2); ?>px; height: <?php echo e($matchHeight); ?>px;">
                                        <?php echo $__env->make('livewire.tournaments._mobile-bracket-match', ['match' => $match], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isLast): ?>
                            <div class="relative w-6 shrink-0 mt-8" style="height: <?php echo e($containerHeight); ?>px;" aria-hidden="true">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bracket['rounds']->get($roundNum + 1, collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $connectorIndex => $nextMatch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $topCenter = (int) (($connectorIndex * 2 + 0.5) * $unit * $slotMultiplier);
                                        $bottomCenter = (int) (($connectorIndex * 2 + 1.5) * $unit * $slotMultiplier);
                                        $middleCenter = (int) (($connectorIndex + 0.5) * $unit * $slotMultiplier * 2);
                                    ?>
                                    <div class="absolute left-0 w-1/2 border-r-2 border-y-2 border-gray-300 rounded-r"
                                         style="top: <?php echo e($topCenter); ?>px; height: <?php echo e($bottomCenter - $topCenter); ?>px;"></div>
                                    <div class="absolute left-1/2 w-1/2 border-t-2 border-gray-300" style="top: <?php echo e($middleCenter); ?>px;"></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bracket['thirdPlace']): ?>
            <div class="mt-4 pt-4 border-t border-dashed border-gray-200">
                <h4 class="text-xs font-black text-amber-600 mb-3">Tercer puesto</h4>
                <div style="height: <?php echo e(filled($bracket['thirdPlace']->notes) ? 160 : 112); ?>px;">
                    <?php echo $__env->make('livewire.tournaments._mobile-bracket-match', ['match' => $bracket['thirdPlace']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/tournaments/_mobile-bracket.blade.php ENDPATH**/ ?>