<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white-pure overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black-deep">Pagos de Matrículas</h2>
                </div>

                <!-- Flash Messages -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline"><?php echo e(session('message')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(session()->has('error')): ?>
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Filters -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input wire:model.live="search" type="text" id="search" 
                            class="w-full rounded-lg border-silver focus:border-primary focus:ring-2 focus:ring-primary/20" 
                            placeholder="Buscar por descripción...">
                    </div>
                    <div>
                        <label for="seasonFilter" class="block text-sm font-medium text-gray-700 mb-1">Temporada</label>
                        <select wire:model.live="seasonFilter" id="seasonFilter" 
                            class="w-full rounded-lg border-silver focus:border-primary focus:ring-2 focus:ring-primary/20">
                            <option value="">Todas las temporadas</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($season->id); ?>"><?php echo e($season->season); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- Inscriptions Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-silver/30">
                        <thead class="bg-gradient-to-r from-gray-50 to-primary/5">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Temporada</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Cuota</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Monto</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Fecha Inicio</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Fecha Fin</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-primary uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white-pure divide-y divide-silver/30">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-primary/5">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-black-deep"><?php echo e($inscription->description); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"><?php echo e($inscription->season->season ?? '-'); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900"><?php echo e(number_format($inscription->price, 2)); ?> €</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"><?php echo e($inscription->cuota); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-green-600"><?php echo e(number_format($inscription->amount, 2)); ?> €</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"><?php echo e($inscription->date_start->format('d/m/Y')); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"><?php echo e($inscription->date_end->format('d/m/Y')); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-night-blue transition-colors duration-200 text-xs font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Editar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg class="w-16 h-16 mb-4 text-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-lg font-semibold">No hay pagos de matrículas registrados</p>
                                            <p class="text-sm mt-1">Los pagos aparecerán aquí una vez que se creen.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <?php echo e($inscriptions->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\inscriptions-teams\index.blade.php ENDPATH**/ ?>