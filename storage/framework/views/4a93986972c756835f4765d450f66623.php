<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="flex *:flex-col md:flex-row gap-6">
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 ">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                    <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form wire:submit="save" class="space-y-5">

                
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Temporada <span class="text-red-500">*</span></label>
                    <select wire:model="season_id"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        <option value="">Seleccionar temporada...</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($season->id); ?>"><?php echo e($season->season); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['season_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input wire:model="name" type="text"
                        class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div>
                    <label class="block text-sm font-semibold text-titanium mb-1">Descripción</label>
                    <textarea wire:model="description" rows="3"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium resize-none"></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Precio (€) <span class="text-red-500">*</span></label>
                        <input wire:model="price" type="text"
                            class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-titanium mb-1">Periodicidad <span class="text-red-500">*</span></label>
                        <select wire:model="periodicity"
                                class="block w-full border border-silver rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary text-titanium">
                            <option value="">Seleccionar...</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $periodicities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->value); ?>"><?php echo e($p->label()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['periodicity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="flex items-center gap-3">
                    <input wire:model="active" type="checkbox" id="active" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="active" class="text-sm font-semibold text-titanium">Activo</label>
                </div>
                <div class="flex items-center gap-3">
                    <input wire:model="bank_account" type="checkbox" id="bank_account" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="bank_account" class="text-sm font-semibold text-titanium">Cuenta Bancaria <span class="text-gray-400 text-xs">(Marque esta opción si este tipo de socio requiere cobro mediante cuenta bancaria con recibo domiciliado)</span></label>
                </div>
                <div class="flex items-center gap-3">
                    <input wire:model="credit_card" type="checkbox" id="credit_card" class="w-5 h-5 rounded border-silver text-primary focus:ring-primary">
                    <label for="credit_card" class="text-sm font-semibold text-titanium">Tarjeta de Crédito para usar cobro recurrente. <span class="text-gray-400 text-xs">(El club debe tener tpv virtual contratado con su banco, o usar el que ofrece vaed.)</span></label>
                </div>

                <!-- Card template -->
                <div>
                    <h3 class="text-lg font-semibold text-titanium flex items-center border-b border-silver/30 pb-3 mb-4">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Imagen de la tarjeta <span class="text-gray-400 text-sm ml-2">(Opcional)</span>
                    </h3>
                    <div class="space-y-6">
                        <div class="form-group">
                            <div class="flex gap-4 items-start">
                                <div class="flex-shrink-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($card_template instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile): ?>
                                        <div>
                                            <p class="text-sm text-titanium mb-2 text-center">Vista previa:</p>
                                            <img src="<?php echo e($card_template->temporaryUrl()); ?>" class="h-32 w-32 object-cover rounded-xl border-2 border-primary shadow-md">
                                        </div>
                                    <?php elseif($existing_card_template): ?>
                                        <div>
                                            <p class="text-sm text-titanium mb-2 text-center">Imagen actual:</p>
                                            <img src="<?php echo e(asset('storage/' . $existing_card_template)); ?>" class="h-32 w-32 object-cover rounded-xl border-2 border-primary shadow-md">
                                        </div>
                                    <?php else: ?>
                                        <div class="h-32 w-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-xs text-gray-500">Sin imagen</p>
                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-titanium mb-2">Subir imagen de la tarjeta</label>
                                    
                                    <input type="file" wire:model.live="card_template" accept="image/*" 
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                    
                                    <div wire:loading wire:target="card_template" class="text-sm text-primary mt-1">
                                        <svg class="animate-spin h-4 w-4 inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Subiendo foto...
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['card_template'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 2MB. Formatos: JPG, PNG</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($memberType->member_seasons_count ?? 0): ?>
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-800">
                        <strong><?php echo e($memberType->member_seasons_count); ?></strong> inscripciones activas con este tipo.
                        El precio histórico no se modifica.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="flex items-center justify-between pt-4 border-t border-silver/30">
                    <a href="<?php echo e(route('member-types.index')); ?>"
                    class="px-5 py-2.5 bg-gray-100 text-titanium rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-night-blue transition-colors shadow-sm"
                            wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-not-allowed">
                        <span wire:loading.remove>Guardar Cambios</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Guardando...
                        </span>
                    </button>
                </div>

            </form>
        </div>
        <div class="bg-white-pure rounded-2xl shadow-xl border border-primary/10 p-6 ">

            <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg">

                <div class="flex items-center justify-between mb-4">
                    <button type="button" wire:click="downloadRemesaXml" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Descargar XML remesa SEPA
                    </button>

                    <button type="button" wire:click="openNotifyModal"
                            wire:loading.attr="disabled" wire:target="openNotifyModal"
                            class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors disabled:opacity-70">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Notificar cargo (<?php echo e(now()->addDays(10)->format('d/m/Y')); ?>)
                    </button>
                </div>

                <?php if(session()->has('error')): ?>
                    <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-400 rounded text-sm text-red-700">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <p class="text-sm text-blue-700">
                    <strong>Histórico de precios y periodicidades:</strong><br>
                    Aquí se muestran los precios y periodicidades históricas de este tipo de socio para cada socio que lo ha tenido en alguna temporada.    
                <table class="w-full mt-2 text-sm text-left text-blue-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b border-blue-200">número</th>
                            <th class="px-4 py-2 border-b border-blue-200">Socio</th>
                            <th class="px-4 py-2 border-b border-blue-200">Temporada</th>
                            <th class="px-4 py-2 border-b border-blue-200">Precio histórico (€)</th>
                            <th class="px-4 py-2 border-b border-blue-200">Fecha alta</th>
                            <th class="px-4 py-2 border-b border-blue-200">Estado pago</th>
                            <th class="px-4 py-2 border-b border-blue-200">Aviso cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $memberType->memberSeasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memberSeason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-2 border-b border-blue-200"><?php echo e($loop->iteration); ?></td>
                                    <td class="px-4 py-2 border-b border-blue-200"><?php echo e($memberSeason->member->name); ?> <?php echo e($memberSeason->member->surname); ?></td>
                                    <td class="px-4 py-2 border-b border-blue-200"><?php echo e($memberSeason->season->season); ?></td>
                                    <td class="px-4 py-2 border-b border-blue-200">€<?php echo e(number_format($memberSeason->price, 2)); ?></td>
                                    <td class="px-4 py-2 border-b border-blue-200"><?php echo e($memberSeason->created_at->format('d/m/Y')); ?></td>
                                    <td class="px-4 py-2 border-b border-blue-200"><?php echo e($memberSeason->payment_status); ?></td>
                                                                        <td class="px-4 py-2 border-b border-blue-200">
                                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($memberSeason->charge_notified_at): ?>
                                                                                <span class="text-green-700">✔ <?php echo e($memberSeason->charge_notified_at->format('d/m/Y')); ?></span>
                                                                            <?php else: ?>
                                                                                <span class="text-gray-400">—</span>
                                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                                        </td>
                                                                    </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showNotifyModal): ?>
        <?php
            $withEmail    = collect($notifyPreview)->filter(fn ($r) => !empty($r['email']));
            $withoutEmail = collect($notifyPreview)->filter(fn ($r) => empty($r['email']));
        ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-data @keydown.escape.window="$wire.closeNotifyModal()">
            <div class="absolute inset-0 bg-black/50" wire:click="closeNotifyModal"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div>
                        <h3 class="text-lg font-bold text-titanium">Confirmar aviso de cargo</h3>
                        <p class="text-sm text-gray-500">
                            Fecha de cargo: <strong><?php echo e(now()->addDays(10)->format('d/m/Y')); ?></strong> ·
                            <?php echo e($withEmail->count()); ?> email(s) a enviar
                        </p>
                    </div>
                    <button type="button" wire:click="closeNotifyModal" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>

                <div class="px-6 py-4 overflow-y-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-gray-500">
                                <th class="py-2 pr-2 border-b">#</th>
                                <th class="py-2 pr-2 border-b">Socio</th>
                                <th class="py-2 pr-2 border-b">Email</th>
                                <th class="py-2 border-b text-right">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $notifyPreview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e(empty($row['email']) ? 'bg-red-50 text-red-700' : 'text-titanium'); ?>">
                                    <td class="py-2 pr-2 border-b"><?php echo e($loop->iteration); ?></td>
                                    <td class="py-2 pr-2 border-b"><?php echo e($row['name']); ?></td>
                                    <td class="py-2 pr-2 border-b"><?php echo e($row['email'] ?: 'Sin email (no se enviará)'); ?></td>
                                    <td class="py-2 border-b text-right"><?php echo e(number_format($row['price'], 2, ',', '.')); ?> €</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withoutEmail->isNotEmpty()): ?>
                        <p class="mt-3 text-xs text-red-600">
                            <?php echo e($withoutEmail->count()); ?> socio(s) no tienen email y no serán notificados.
                        </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200">
                    <button type="button" wire:click="closeNotifyModal"
                            class="px-5 py-2.5 bg-gray-100 text-titanium rounded-xl font-semibold text-sm hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button type="button" wire:click="notifyBankCharge"
                            wire:loading.attr="disabled" wire:target="notifyBankCharge"
                            <?php if($withEmail->isEmpty()): echo 'disabled'; endif; ?>
                            class="px-5 py-2.5 bg-amber-500 text-white rounded-xl font-semibold text-sm hover:bg-amber-600 transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="notifyBankCharge">Enviar <?php echo e($withEmail->count()); ?> email(s)</span>
                        <span wire:loading wire:target="notifyBankCharge">Enviando...</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/livewire/member-types/edit.blade.php ENDPATH**/ ?>