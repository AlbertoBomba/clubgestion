<div>
    <!-- Flash Messages -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo e(session('message')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <h3 class="text-lg font-semibold text-gray-900">Planificación de Entrenamientos</h3>
            
        </div>
        
        <!-- Filtros -->
        <div class="flex gap-3">
            <!-- Filtro de equipo -->
            <div class="w-64">
                <label class="block text-xs font-medium text-gray-700 mb-1">Filtrar por Equipo</label>
                <select wire:model.live="teamFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">Todos los equipos</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamsForFilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($team->id); ?>"><?php echo e($team->team); ?><?php echo e($team->category ? ' - ' . $team->category->category : ''); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <!-- Filtro de temporada -->
            <div class="w-64">
                <label class="block text-xs font-medium text-gray-700 mb-1">Temporada</label>
                <select wire:model.live="seasonFilter" disabled class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-100 cursor-not-allowed">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $seasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $season): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($season->id); ?>">
                            <?php echo e($season->season); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeSeason && $season->id === $activeSeason->id): ?>
                                🟢 (Temporada en curso)
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fields->isEmpty()): ?>
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded">
            <p>No hay campos de entrenamiento configurados. Por favor, <a href="<?php echo e(route('training-fields.index')); ?>" class="underline">crea un campo</a> primero.</p>
        </div>
    <?php else: ?>
        <!-- Leyenda de campos -->
        <div class="mb-6 bg-white rounded-lg shadow p-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Campos de Entrenamiento:</h4>
            <div class="flex flex-wrap gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded" style="background-color: <?php echo e($field->color); ?>"></div>
                        <span class="text-sm text-gray-700">
                            <strong><?php echo e($field->name); ?></strong> - <?php echo e($field->field_type_name); ?> (<?php echo e($field->surface_type_name); ?>)
                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Calendario Visual -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <div class="min-w-full">
                <!-- Header con días de la semana -->
                <div class="grid grid-cols-8 bg-gray-50 border-b border-gray-200">
                    <div class="p-4 text-xs font-semibold text-gray-600 uppercase">Horario</div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 text-xs font-semibold text-gray-600 uppercase text-center border-l border-gray-200">
                            <?php echo e(ucfirst($day)); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Grid de horarios -->
                <div class="divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- Cabecera del campo (visual del campo de fútbol) -->
                        <div class="grid grid-cols-8 border-b-2" style="border-color: <?php echo e($field->color); ?>">
                            <div class="col-span-8 p-3" style="background: linear-gradient(135deg, <?php echo e($field->color); ?>15 0%, <?php echo e($field->color); ?>05 100%);">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <!-- Mini campo de fútbol dibujado -->
                                        <div class="relative w-24 h-16 rounded border-2" style="border-color: <?php echo e($field->color); ?>; background-color: <?php echo e($field->color); ?>10;">
                                            <!-- Líneas del campo -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-px h-full" style="background-color: <?php echo e($field->color); ?>"></div>
                                            </div>
                                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full border" style="border-color: <?php echo e($field->color); ?>"></div>
                                            <!-- Áreas -->
                                            <div class="absolute left-0 top-1/4 w-2 h-1/2 border-t border-b border-r" style="border-color: <?php echo e($field->color); ?>"></div>
                                            <div class="absolute right-0 top-1/4 w-2 h-1/2 border-t border-b border-l" style="border-color: <?php echo e($field->color); ?>"></div>
                                        </div>
                                        
                                        <div>
                                            <h4 class="text-base font-bold text-gray-900"><?php echo e($field->name); ?></h4>
                                            <p class="text-xs text-gray-600"><?php echo e($field->field_type_name); ?> - <?php echo e($field->surface_type_name); ?></p>
                                        </div>
                                    </div>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->capacity): ?>
                                        <span class="text-xs text-gray-500">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Capacidad: <?php echo e($field->capacity); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($field->available_from && $field->available_to): ?>
                                        <span class="text-xs text-gray-500 ml-3">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Disponible: <?php echo e(\Carbon\Carbon::parse($field->available_from)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($field->available_to)->format('H:i')); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Slots de tiempo para este campo -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $timeSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timeSlot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="grid grid-cols-8 hover:bg-gray-50 transition-colors">
                                <div class="p-2 text-xs font-medium text-gray-500 border-r border-gray-200 flex items-center justify-center">
                                    <?php echo e($timeSlot); ?>

                                </div>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border-l border-gray-200 min-h-[80px] p-1 relative">
                                        <?php
                                            $daySchedules = $schedules[$field->id][$day] ?? collect();
                                            $slotTime = \Carbon\Carbon::createFromFormat('H:i', $timeSlot);
                                            
                                            // Encontrar todos los horarios que tocan este slot de 15 minutos
                                            // Un horario aparece si el slot está entre el inicio y el fin (inclusive)
                                            $currentSchedules = $daySchedules->filter(function($schedule) use ($slotTime) {
                                                $startTime = \Carbon\Carbon::parse($schedule->start_time);
                                                $endTime = \Carbon\Carbon::parse($schedule->end_time);
                                                
                                                // El horario aparece si el slot está entre inicio y fin (inclusive)
                                                return $slotTime->gte($startTime) && $slotTime->lte($endTime);
                                            });
                                        ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentSchedules->isNotEmpty()): ?>
                                            <!-- Horarios asignados -->
                                            <div class="space-y-1 h-full flex flex-col">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $currentSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $currentSchedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        // Generar un color único basado en el ID del equipo usando hash
                                                        $teamId = $currentSchedule->team_id;
                                                        $hash = md5($teamId);
                                                        
                                                        // Extraer valores RGB del hash y asegurar colores oscuros/saturados
                                                        $r = hexdec(substr($hash, 0, 2));
                                                        $g = hexdec(substr($hash, 2, 2));
                                                        $b = hexdec(substr($hash, 4, 2));
                                                        
                                                        // Ajustar para obtener colores más saturados y oscuros
                                                        // Reducir el valor más alto para evitar colores muy claros
                                                        $max = max($r, $g, $b);
                                                        if ($max > 200) {
                                                            $factor = 180 / $max;
                                                            $r = (int)($r * $factor);
                                                            $g = (int)($g * $factor);
                                                            $b = (int)($b * $factor);
                                                        }
                                                        
                                                        // Aumentar saturación: incrementar el componente dominante
                                                        $maxComponent = max($r, $g, $b);
                                                        $minComponent = min($r, $g, $b);
                                                        
                                                        if ($maxComponent - $minComponent < 80) {
                                                            if ($r == $maxComponent) $r = min(255, $r + 50);
                                                            elseif ($g == $maxComponent) $g = min(255, $g + 50);
                                                            else $b = min(255, $b + 50);
                                                        }
                                                        
                                                        $bgColor = sprintf('#%02X%02X%02X', $r, $g, $b);
                                                        $textColor = '#FFFFFF';
                                                        
                                                        // Determinar si este slot es el inicio o el final del entrenamiento
                                                        $startTime = \Carbon\Carbon::parse($currentSchedule->start_time);
                                                        $endTime = \Carbon\Carbon::parse($currentSchedule->end_time);
                                                        $isStartSlot = $slotTime->eq($startTime);
                                                        $isEndSlot = $slotTime->eq($endTime);
                                                    ?>
                                                    <div class="relative rounded-lg p-1.5 text-xs flex-1 shadow-md border border-white border-opacity-20" 
                                                         style="background-color: <?php echo e($bgColor); ?>; color: <?php echo e($textColor); ?>; min-height: 32px;">
                                                        <!-- Indicador visual de inicio -->
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isStartSlot): ?>
                                                            <div class="absolute -left-1 top-0 bottom-0 w-1.5 bg-white rounded-l-lg"></div>
                                                            <div class="absolute left-0.5 top-1/2 -translate-y-1/2 bg-white rounded-full p-1.5">
                                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M8 5v14l11-7z"/>
                                                                </svg>
                                                            </div>
                                                        <?php elseif($isEndSlot): ?>
                                                            <!-- Indicador visual de final -->
                                                            <div class="absolute -left-1 top-0 bottom-0 w-1.5 bg-white rounded-l-lg"></div>
                                                            <div class="absolute left-0.5 top-1/2 -translate-y-1/2 bg-white rounded-full p-1.5">
                                                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                                    <rect x="6" y="5" width="3" height="14" rx="1"/>
                                                                    <rect x="14" y="5" width="3" height="14" rx="1"/>
                                                                </svg>
                                                            </div>
                                                        <?php else: ?>
                                                            <!-- Icono de persona corriendo (en medio del entrenamiento) -->
                                                            <div class="absolute left-0.5 top-1/2 -translate-y-1/2 bg-white bg-opacity-90 rounded-full p-1">
                                                                <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M13.49 5.48c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm-3.6 13.9l1-4.4 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1l-5.2 2.2v4.7h2v-3.4l1.8-.7-1.6 8.1-4.9-1-.4 2 7 1.4z"/>
                                                                </svg>
                                                            </div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        
                                                        <div class="flex items-center justify-between gap-1 pr-5 <?php echo e($isStartSlot || $isEndSlot ? 'pl-8' : 'pl-6'); ?>">
                                                            <!-- Nombre del equipo y horario en la misma línea -->
                                                            <div class="font-bold text-xs leading-tight truncate flex-1"><?php echo e($currentSchedule->team->team); ?></div>
                                                            <div class="font-semibold text-xs leading-tight opacity-95 whitespace-nowrap">
                                                                <?php echo e(\Carbon\Carbon::parse($currentSchedule->start_time)->format('H:i')); ?>-<?php echo e(\Carbon\Carbon::parse($currentSchedule->end_time)->format('H:i')); ?>

                                                            </div>
                                                        </div>
                                                        <button wire:click="confirmDelete(<?php echo e($currentSchedule->id); ?>)"
                                                                class="absolute top-1 right-1 text-white hover:text-red-300 bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full p-0.5 transition-all">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                
                                                <!-- Botón para agregar más equipos al mismo horario -->
                                                <button wire:click="openAssignModal(<?php echo e($field->id); ?>, '<?php echo e($day); ?>', '<?php echo e($timeSlot); ?>')"
                                                        class="w-full py-2 rounded-md bg-blue-50 hover:bg-blue-100 border-2 border-dashed border-blue-300 hover:border-blue-400 transition-all flex items-center justify-center gap-1.5 group shadow-sm">
                                                    <svg class="w-4 h-4 text-blue-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    <span class="text-xs font-semibold text-blue-600 group-hover:text-blue-700">Añadir equipo</span>
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <!-- Slot vacío - clickeable -->
                                            <button wire:click="openAssignModal(<?php echo e($field->id); ?>, '<?php echo e($day); ?>', '<?php echo e($timeSlot); ?>')"
                                                    class="w-full h-full rounded-md bg-white hover:bg-blue-50 border-2 border-dashed border-gray-200 hover:border-blue-400 transition-all flex flex-col items-center justify-center gap-1 group">
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                <span class="text-xs font-medium text-gray-400 group-hover:text-blue-600">Asignar</span>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Modal Asignar Equipo -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Asignar Equipo</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Info del slot -->
                    <div class="mb-4 p-3 bg-blue-50 rounded-md">
                        <p class="text-sm text-blue-900">
                            <strong>Día:</strong> <?php echo e(ucfirst($selectedDay)); ?><br>
                            <strong>Campo:</strong> <?php echo e($fields->find($selectedField)?->name); ?>

                        </p>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="saveSchedule">
                        <div class="space-y-4">
                            <!-- Equipo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Equipo *</label>
                                <select wire:model="team_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Selecciona un equipo</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($team->id); ?>"><?php echo e($team->team); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['team_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Horario -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora Inicio *</label>
                                    <input type="time" wire:model="start_time" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hora Fin *</label>
                                    <input type="time" wire:model="end_time" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <!-- Notas -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                                <textarea wire:model="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancelar
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="saveSchedule" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-70 disabled:cursor-not-allowed inline-flex items-center">
                                <svg wire:loading wire:target="saveSchedule" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="saveSchedule">Asignar</span>
                                <span wire:loading wire:target="saveSchedule">Asignando...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Ventana emergente fija en la esquina inferior derecha -->
    <div class="fixed bottom-4 right-4 w-80 max-h-96 bg-white rounded-lg shadow-2xl border border-gray-200 overflow-hidden z-50">
        <!-- Header de la ventana -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-3 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h4 class="font-semibold text-sm">Horarios de Entrenamientos</h4>
        </div>
        
        <!-- Contenido scrollable -->
        <div class="overflow-y-auto max-h-80 p-3">
            <?php
                // Obtener todos los entrenamientos programados, agrupados por equipo
                $allSchedules = collect();
                foreach($schedules as $fieldSchedules) {
                    foreach($fieldSchedules as $daySchedules) {
                        $allSchedules = $allSchedules->merge($daySchedules);
                    }
                }
                
                // Agrupar por equipo y ordenar
                $schedulesByTeam = $allSchedules->groupBy('team_id')->sortBy(function($schedules, $teamId) {
                    return $schedules->first()->team->team;
                });
                
                $daysOfWeek = [
                    'monday' => 'Lunes',
                    'tuesday' => 'Martes',
                    'wednesday' => 'Miércoles',
                    'thursday' => 'Jueves',
                    'friday' => 'Viernes',
                    'saturday' => 'Sábado',
                    'sunday' => 'Domingo',
                    'lunes' => 'Lunes',
                    'martes' => 'Martes',
                    'miercoles' => 'Miércoles',
                    'jueves' => 'Jueves',
                    'viernes' => 'Viernes',
                    'sabado' => 'Sábado',
                    'domingo' => 'Domingo',
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedulesByTeam->isEmpty()): ?>
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm">No hay entrenamientos programados</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $schedulesByTeam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teamId => $teamSchedules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $team = $teamSchedules->first()->team;
                            
                            // Generar el mismo color único que en el calendario
                            $hash = md5($teamId);
                            $r = hexdec(substr($hash, 0, 2));
                            $g = hexdec(substr($hash, 2, 2));
                            $b = hexdec(substr($hash, 4, 2));
                            
                            $max = max($r, $g, $b);
                            if ($max > 200) {
                                $factor = 180 / $max;
                                $r = (int)($r * $factor);
                                $g = (int)($g * $factor);
                                $b = (int)($b * $factor);
                            }
                            
                            $maxComponent = max($r, $g, $b);
                            $minComponent = min($r, $g, $b);
                            
                            if ($maxComponent - $minComponent < 80) {
                                if ($r == $maxComponent) $r = min(255, $r + 50);
                                elseif ($g == $maxComponent) $g = min(255, $g + 50);
                                else $b = min(255, $b + 50);
                            }
                            
                            $bgColor = sprintf('#%02X%02X%02X', $r, $g, $b);
                            $textColor = '#FFFFFF';
                        ?>
                        
                        <div class="rounded-lg border border-gray-200 overflow-hidden">
                            <!-- Nombre del equipo con color -->
                            <div class="px-3 py-2 font-semibold text-sm" style="background-color: <?php echo e($bgColor); ?>; color: <?php echo e($textColor); ?>;">
                                <?php echo e($team->team); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($team->category): ?>
                                    <span class="text-xs opacity-90 ml-1">(<?php echo e($team->category->category); ?>)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <!-- Lista de entrenamientos -->
                            <div class="divide-y divide-gray-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teamSchedules->sortBy(function($schedule) use ($daysOfWeek) {
                                    return array_search($schedule->day_of_week, array_keys($daysOfWeek));
                                })->sortBy('start_time'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="px-3 py-2 bg-gray-50 hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="font-medium text-gray-700"><?php echo e($daysOfWeek[$schedule->day_of_week]); ?></span>
                                            </div>
                                            <div class="flex items-center space-x-1.5">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-800">
                                                    <?php echo e(\Carbon\Carbon::parse($schedule->start_time)->format('H:i')); ?>-<?php echo e(\Carbon\Carbon::parse($schedule->end_time)->format('H:i')); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 ml-5">
                                            📍 <?php echo e($schedule->trainingField->name); ?>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <?php if (isset($component)) { $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dialog-modal','data' => ['wire:model' => 'confirmingDeletion']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'confirmingDeletion']); ?>
         <?php $__env->slot('title', null, []); ?> Eliminar Horario de Entrenamiento <?php $__env->endSlot(); ?>
         <?php $__env->slot('content', null, []); ?> ¿Estás seguro de que deseas eliminar este horario? Esta acción no se puede deshacer. <?php $__env->endSlot(); ?>
         <?php $__env->slot('footer', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['wire:click' => '$set(\'confirmingDeletion\', false)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => '$set(\'confirmingDeletion\', false)']); ?>Cancelar <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-button','data' => ['class' => 'ml-3','wire:click' => 'deleteSchedule','wire:loading.attr' => 'disabled','wire:target' => 'deleteSchedule']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('danger-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'ml-3','wire:click' => 'deleteSchedule','wire:loading.attr' => 'disabled','wire:target' => 'deleteSchedule']); ?>
                <span wire:loading.remove wire:target="deleteSchedule">Eliminar</span>
                <span wire:loading wire:target="deleteSchedule" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Eliminando...
                </span>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $attributes = $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $component = $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $attributes = $__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__attributesOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f)): ?>
<?php $component = $__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f; ?>
<?php unset($__componentOriginal49bd1c1dd878e22e0fb84faabf295a3f); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\training-schedule\calendar.blade.php ENDPATH**/ ?>