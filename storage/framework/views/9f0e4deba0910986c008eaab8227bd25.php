<div class="card-modern bg-white-pure rounded-2xl shadow-xl border border-primary/10 overflow-hidden h-full flex flex-col">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-night-blue rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white-pure" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-titanium">Equipos por Temporada</h3>
                    <p class="text-sm text-gray-600">Evolución de equipos en tu escuela</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Total</p>
                <p class="text-3xl font-bold text-primary"><?php echo e($totalTeams); ?></p>
            </div>
        </div>
    </div>

    <div class="p-6 flex-1">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($seasons->count() > 0): ?>
            <!-- Gráfico de barras simple -->
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $count = $chartData['data'][$index];
                        $maxCount = max($chartData['data']);
                        $percentage = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                    ?>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-titanium"><?php echo e($season->season); ?></span>
                            <span class="text-sm font-bold text-primary"><?php echo e($count); ?> equipo<?php echo e($count != 1 ? 's' : ''); ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-8 overflow-hidden">
                            <div class="bg-gradient-to-r from-primary to-night-blue h-8 rounded-full flex items-center justify-end pr-3 transition-all duration-500 ease-out"
                                style="width: <?php echo e($percentage); ?>%">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($percentage > 10): ?>
                                    <span class="text-xs font-bold text-white-pure"><?php echo e($count); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Estadísticas adicionales -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Promedio</p>
                        <p class="text-2xl font-bold text-primary">
                            <?php echo e($seasons->count() > 0 ? number_format($totalTeams / $seasons->count(), 1) : 0); ?>

                        </p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Máximo</p>
                        <p class="text-2xl font-bold text-neon-green">
                            <?php echo e(max($chartData['data'])); ?>

                        </p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Mínimo</p>
                        <p class="text-2xl font-bold text-night-blue">
                            <?php echo e(min($chartData['data'])); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="text-gray-600 font-medium">No hay datos de equipos disponibles</p>
                <p class="text-sm text-gray-500 mt-2">Crea tu primera temporada y añade equipos para ver las estadísticas</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\dashboard\teams-per-season-chart.blade.php ENDPATH**/ ?>