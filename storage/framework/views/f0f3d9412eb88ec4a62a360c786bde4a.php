<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 p-4 bg-neon-green/10 border-l-4 border-neon-green rounded-lg">
            <p class="text-sm text-neon-green font-medium"><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <p class="text-sm text-red-700 font-medium"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="sticky top-16 z-10 bg-white-pure flex items-center justify-between p-6 border-b border-gray-100">
        <div class="flex items-center gap-4">
            <div class="text-sm text-gray-600">
                <span class="font-semibold text-primary text-lg"><?php echo e($matches->total()); ?></span> 
                <span class="text-titanium"><?php echo e($matches->total() === 1 ? 'partido encontrado' : 'partidos encontrados'); ?></span>
            </div>
        </div>
        
        <div class="flex gap-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActiveSeason): ?>
                <a href="<?php echo e(route('matches.create')); ?>" class="inline-flex items-center px-4 py-2 rounded-xl text-white font-semibold text-sm shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:-translate-y-1 bg-blue-600 hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Partido
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="bg-white-pure rounded-b-2xl shadow-xl border border-primary/10 overflow-hidden">
        <!-- Header with Search and Filters -->
        <div class="p-6 border-b border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Buscar rival o lugar..." 
                        class="block w-full pl-10 pr-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep placeholder-gray-400 text-sm">
                </div>
                <div>
                    <select wire:model.live="seasonFilter" 
                        class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="">Todas las temporadas</option>
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
                <div>
                    <select wire:model.live="teamFilter" 
                        class="block w-full px-3 py-3 border border-silver rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-black-deep text-sm">
                        <option value="">Todos los equipos</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>"><?php echo e($team->team); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Matches Table -->
        <div class="overflow-x-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-primary/30 hover:-translate-y-1">
                        <!-- Header Card con fecha y temporada -->
                        <div class="bg-gradient-to-r from-primary/10 to-blue-500/10 px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-titanium"><?php echo e($match->date->format('d/m/Y')); ?></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->published): ?>
                                        <div class="flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full" title="Publicado en web pública">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                            </svg>
                                            <span class="text-xs font-bold">Web</span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php
                                        // Verificar si el partido ya se jugó
                                        $matchDateTime = $match->date;
                                        if ($match->hour_match) {
                                            $matchDateTime = \Carbon\Carbon::parse($match->date->format('Y-m-d') . ' ' . $match->hour_match->format('H:i:s'));
                                        }
                                        $matchHasPassed = $matchDateTime->isPast();
                                        $goalsTeam = $match->goals_team ?? 0;
                                        $goalsOponent = $match->goals_oponent ?? 0;
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matchHasPassed): ?>
                                        <!-- Resultado en miniatura en el header -->
                                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full font-bold text-sm shadow-sm
                                            <?php echo e($goalsTeam > $goalsOponent ? 'bg-green-500 text-white' : 
                                               ($goalsTeam < $goalsOponent ? 'bg-red-500 text-white' : 'bg-gray-500 text-white')); ?>">
                                            <span><?php echo e($goalsTeam); ?></span>
                                            <span class="text-xs opacity-90">-</span>
                                            <span><?php echo e($goalsOponent); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-500 rounded-full font-medium">
                                            Por jugar
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->matchday): ?>
                                        <span class="text-xs px-2 py-1 bg-white rounded-full text-gray-600 font-medium">Jornada <?php echo e($match->matchday); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->hour_match): ?>
                                <div class="mt-2 flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span><?php echo e($match->hour_match->format('H:i')); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->hour_meeting): ?>
                                        <span class="text-gray-400">• Citación: <?php echo e($match->hour_meeting->format('H:i')); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Versus Section -->
                        <div class="p-6">
                            <div class="flex items-center justify-between gap-4">
                                <?php
                                    $isHome = $match->sites === 'home';
                                    $isAway = $match->sites === 'away';
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isHome || !$isAway): ?>
                                    <!-- Equipo Local (Escuela) -->
                                    <div class="flex-1 text-center">
                                        <div class="flex justify-center mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->sportsSchool && $match->sportsSchool->logo): ?>
                                                <img src="<?php echo e(asset('storage/' . $match->sportsSchool->logo)); ?>" alt="<?php echo e($match->sportsSchool->sports_school); ?>" class="w-16 h-16 rounded-lg object-cover border-3 border-blue-500/30 shadow-md">
                                            <?php else: ?>
                                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/30 flex items-center justify-center border-3 border-blue-500/30 shadow-md">
                                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <h3 class="text-sm font-bold text-black-deep truncate">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->sportsSchool): ?>
                                                <?php echo e($match->sportsSchool->sports_school); ?>

                                            <?php else: ?>
                                                <?php echo e($match->team->team); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </h3>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->team->category): ?>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo e($match->team->category->name); ?></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="inline-block mt-2 text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                                            Local
                                        </span>
                                    </div>

                                    <!-- Marcador / VS -->
                                    <div class="flex flex-col items-center justify-center px-4">
                                        <?php
                                            // Verificar si el partido ya se jugó
                                            $matchDateTime = $match->date;
                                            if ($match->hour_match) {
                                                $matchDateTime = \Carbon\Carbon::parse($match->date->format('Y-m-d') . ' ' . $match->hour_match->format('H:i:s'));
                                            }
                                            $matchHasPassed = $matchDateTime->isPast();
                                            $goalsTeam = $match->goals_team ?? 0;
                                            $goalsOponent = $match->goals_oponent ?? 0;
                                        ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matchHasPassed): ?>
                                            <!-- Resultado final -->
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="text-center">
                                                    <div class="text-3xl font-black <?php echo e($goalsTeam > $goalsOponent ? 'text-green-600' : ($goalsTeam < $goalsOponent ? 'text-red-600' : 'text-gray-600')); ?>">
                                                        <?php echo e($goalsTeam); ?>

                                                    </div>
                                                </div>
                                                <div class="text-2xl font-bold text-gray-400">-</div>
                                                <div class="text-center">
                                                    <div class="text-3xl font-black <?php echo e($goalsOponent > $goalsTeam ? 'text-green-600' : ($goalsOponent < $goalsTeam ? 'text-red-600' : 'text-gray-600')); ?>">
                                                        <?php echo e($goalsOponent); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs px-3 py-1 rounded-full font-bold
                                                <?php echo e($goalsTeam > $goalsOponent ? 'bg-green-100 text-green-700' : 
                                                   ($goalsTeam < $goalsOponent ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')); ?>">
                                                <?php echo e($goalsTeam > $goalsOponent ? 'Victoria' : 
                                                   ($goalsTeam < $goalsOponent ? 'Derrota' : 'Empate')); ?>

                                            </span>
                                        <?php else: ?>
                                            <!-- Partido por jugar -->
                                            <div class="text-center">
                                                <div class="text-xl font-black text-gray-400">VS</div>
                                                <span class="text-xs text-gray-500 mt-1 block">Por jugar</span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <!-- Equipo Visitante (Rival) -->
                                    <div class="flex-1 text-center">
                                        <div class="flex justify-center mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->escudo_team_oponent): ?>
                                                <img src="<?php echo e(asset('storage/' . $match->escudo_team_oponent)); ?>" alt="<?php echo e($match->opponent); ?>" class="w-16 h-16 rounded-lg object-cover border-3 border-red-500/30 shadow-md">
                                            <?php else: ?>
                                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-500/20 to-red-600/30 flex items-center justify-center border-3 border-red-500/30 shadow-md">
                                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <h3 class="text-sm font-bold text-black-deep truncate"><?php echo e($match->opponent); ?></h3>
                                        <p class="text-xs text-gray-500 mt-1">Rival</p>
                                    </div>
                                <?php else: ?>
                                    <!-- Partido de VISITANTE: Rival primero, Escuela después -->
                                    
                                    <!-- Equipo Rival (Local del rival) -->
                                    <div class="flex-1 text-center">
                                        <div class="flex justify-center mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->escudo_team_oponent): ?>
                                                <img src="<?php echo e(asset('storage/' . $match->escudo_team_oponent)); ?>" alt="<?php echo e($match->opponent); ?>" class="w-16 h-16 rounded-lg object-cover border-3 border-red-500/30 shadow-md">
                                            <?php else: ?>
                                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-red-500/20 to-red-600/30 flex items-center justify-center border-3 border-red-500/30 shadow-md">
                                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <h3 class="text-sm font-bold text-black-deep truncate"><?php echo e($match->opponent); ?></h3>
                                        <p class="text-xs text-gray-500 mt-1">Rival</p>
                                    </div>

                                    <!-- Marcador / VS -->
                                    <div class="flex flex-col items-center justify-center px-4">
                                        <?php
                                            // Verificar si el partido ya se jugó
                                            $matchDateTime = $match->date;
                                            if ($match->hour_match) {
                                                $matchDateTime = \Carbon\Carbon::parse($match->date->format('Y-m-d') . ' ' . $match->hour_match->format('H:i:s'));
                                            }
                                            $matchHasPassed = $matchDateTime->isPast();
                                            $goalsTeam = $match->goals_team ?? 0;
                                            $goalsOponent = $match->goals_oponent ?? 0;
                                        ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matchHasPassed): ?>
                                            <!-- Resultado final -->
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="text-center">
                                                    <div class="text-3xl font-black <?php echo e($goalsOponent > $goalsTeam ? 'text-red-600' : ($goalsOponent < $goalsTeam ? 'text-green-600' : 'text-gray-600')); ?>">
                                                        <?php echo e($goalsOponent); ?>

                                                    </div>
                                                </div>
                                                <div class="text-2xl font-bold text-gray-400">-</div>
                                                <div class="text-center">
                                                    <div class="text-3xl font-black <?php echo e($goalsTeam > $goalsOponent ? 'text-green-600' : ($goalsTeam < $goalsOponent ? 'text-red-600' : 'text-gray-600')); ?>">
                                                        <?php echo e($goalsTeam); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs px-3 py-1 rounded-full font-bold
                                                <?php echo e($goalsTeam > $goalsOponent ? 'bg-green-100 text-green-700' : 
                                                   ($goalsTeam < $goalsOponent ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')); ?>">
                                                <?php echo e($goalsTeam > $goalsOponent ? 'Victoria' : 
                                                   ($goalsTeam < $goalsOponent ? 'Derrota' : 'Empate')); ?>

                                            </span>
                                        <?php else: ?>
                                            <!-- Partido por jugar -->
                                            <div class="text-center">
                                                <div class="text-xl font-black text-gray-400">VS</div>
                                                <span class="text-xs text-gray-500 mt-1 block">Por jugar</span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <!-- Equipo Visitante (Nuestra Escuela) -->
                                    <div class="flex-1 text-center">
                                        <div class="flex justify-center mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->sportsSchool && $match->sportsSchool->logo): ?>
                                                <img src="<?php echo e(asset('storage/' . $match->sportsSchool->logo)); ?>" alt="<?php echo e($match->sportsSchool->sports_school); ?>" class="w-16 h-16 rounded-lg object-cover border-3 border-blue-500/30 shadow-md">
                                            <?php else: ?>
                                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/30 flex items-center justify-center border-3 border-blue-500/30 shadow-md">
                                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <h3 class="text-sm font-bold text-black-deep truncate">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->sportsSchool): ?>
                                                <?php echo e($match->sportsSchool->sports_school); ?>

                                            <?php else: ?>
                                                <?php echo e($match->team->team); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </h3>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->team->category): ?>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo e($match->team->category->name); ?></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span class="inline-block mt-2 text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded-full font-medium">
                                            Visitante
                                        </span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Información adicional -->
                            <div class="mt-4 pt-4 border-t border-gray-100 space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->site): ?>
                                    <div class="flex items-center gap-2 text-xs text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="truncate"><?php echo e($match->site); ?></span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="text-xs font-medium text-gray-700"><?php echo e($match->players->count()); ?> convocados</span>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->notCalledPlayers->count() > 0): ?>
                                        <div class="flex items-center gap-1">
                                            <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-medium">
                                                <?php echo e($match->notCalledPlayers->count()); ?> bajas
                                            </span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Footer con acciones -->
                        <div class="bg-gray-50 px-4 py-3 flex items-center justify-end gap-2 border-t border-gray-100">
                            <a href="<?php echo e(route('matches.edit', $match)); ?>" class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition-colors shadow-sm hover:shadow">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <button wire:click="confirmDelete(<?php echo e($match->id); ?>)" class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition-colors shadow-sm hover:shadow">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full py-12">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">No se encontraron partidos</p>
                            <p class="text-gray-400 text-sm mt-1">Crea tu primer partido para comenzar</p>
                            <a href="<?php echo e(route('matches.create')); ?>" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Crear Primer Partido
                            </a>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($matches->hasPages()): ?>
            <div class="px-6 py-4 border-t border-silver/30 bg-gray-50">
                <?php echo e($matches->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Modal de confirmación eliminar -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($confirmingDeletion): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cancelDelete"></div>
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Eliminar Partido
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que quieres eliminar este partido? También se eliminará la convocatoria asociada. Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="deleteMatch" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Eliminar
                        </button>
                        <button type="button" wire:click="cancelDelete" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('modal-closed', () => {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('overflow-hidden');
                document.documentElement.style.overflow = '';
                document.documentElement.classList.remove('overflow-hidden');
                setTimeout(() => {
                    document.body.removeAttribute('style');
                    document.body.classList.remove('overflow-hidden', 'overflow-y-hidden');
                    window.scrollTo(window.scrollX, window.scrollY);
                }, 150);
            });
        });
    </script>
</div>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\livewire\matches\index.blade.php ENDPATH**/ ?>