<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Jugadores - <?php echo e($data['team']->team); ?></title>
    <style>
        @page {
            margin: 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            color: #333333;
            background: #ffffff;
            line-height: 1.4;
        }
        
        /* Header Banner */
        .header-banner {
            background: #ffffff;
            padding: 10px 0;
            text-align: center;
            position: relative;
            border-bottom: 3px solid #2c5f8d;
            margin-bottom: 15px;
        }
        
        .logo-container {
            margin-bottom: 10px;
        }
        
        .logo-img {
            max-height: 50px;
            max-width: 150px;
        }
        
        .club-title {
            font-size: 18pt;
            font-weight: bold;
            color: #2c5f8d;
            margin-bottom: 5px;
        }
        
        .document-title {
            font-size: 14pt;
            font-weight: bold;
            color: #333333;
            margin-bottom: 3px;
        }
        
        .team-info {
            font-size: 10pt;
            color: #666666;
            margin-bottom: 3px;
        }
        
        .generation-date {
            font-size: 8pt;
            color: #666666;
        }
        
        /* Info Box */
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .info-box table {
            width: 100%;
        }
        
        .info-box td {
            padding: 4px 8px;
            font-size: 9pt;
        }
        
        .info-label {
            font-weight: bold;
            color: #2c5f8d;
            width: 30%;
        }
        
        .info-value {
            color: #333333;
        }
        
        /* Players Table */
        .players-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        
        .players-table thead {
            background: #2c5f8d;
            color: white;
        }
        
        .players-table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
            border-bottom: 2px solid #1a4a6f;
        }
        
        .players-table tbody tr {
            border-bottom: 1px solid #e9ecef;
        }
        
        .players-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .players-table tbody tr:hover {
            background: #e7f3ff;
        }
        
        .players-table td {
            padding: 6px 6px;
            font-size: 8pt;
            color: #495057;
            vertical-align: top;
        }
        
        /* Counter Badge */
        .counter-badge {
            background: #2c5f8d;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 9pt;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }
        
        /* Footer */
        .footer-box {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #2c5f8d;
            text-align: center;
        }
        
        .footer-text {
            font-size: 8pt;
            color: #666666;
            line-height: 1.6;
        }
        
        /* Utility Classes */
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-small {
            font-size: 7pt;
        }
        
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header-banner">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->sportsSchool && auth()->user()->sportsSchool->logo): ?>
        <div class="logo-container">
            <img class="logo-img" src="<?php echo e(public_path('storage/' . auth()->user()->sportsSchool->logo)); ?>" alt="Escudo">
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(auth()->user()->sportsSchool): ?>
        <p class="club-title"><?php echo e(strtoupper(auth()->user()->sportsSchool->name)); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <p class="document-title">LISTADO DE JUGADORES</p>
        <p class="team-info"><?php echo e($data['team']->team); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data['category']): ?>- <?php echo e($data['category']->name); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></p>
        <p class="generation-date">Generado el <?php echo e(\Carbon\Carbon::now()->format('d/m/Y H:i')); ?></p>
    </div>
    
    <!-- INFO BOX -->
    <div class="info-box">
        <table>
            <tr>
                <td class="info-label">Equipo:</td>
                <td class="info-value"><?php echo e($data['team']->team); ?></td>
                <td class="info-label">Temporada:</td>
                <td class="info-value"><?php echo e($data['season']->season ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="info-label">Categoría:</td>
                <td class="info-value"><?php echo e($data['category']->name ?? 'N/A'); ?></td>
                <td class="info-label">Total Jugadores:</td>
                <td class="info-value"><?php echo e($data['players']->count()); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data['team']->gender): ?>
            <tr>
                <td class="info-label">Género:</td>
                <td class="info-value"><?php echo e(ucfirst($data['team']->gender)); ?></td>
                <td class="info-label">Federado:</td>
                <td class="info-value"><?php echo e($data['team']->federate ? 'Sí' : 'No'); ?></td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </table>
    </div>
    
    <!-- COUNTER BADGE -->
    <div class="text-center">
        <span class="counter-badge"><?php echo e($data['players']->count()); ?> JUGADOR<?php echo e($data['players']->count() != 1 ? 'ES' : ''); ?></span>
    </div>
    
    <!-- PLAYERS TABLE -->
    <table class="players-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">#</th>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $data['selectedColumns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($data['availableColumns'][$column] ?? $column); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $data['players']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $data['selectedColumns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($column === 'dbirth'): ?>
                            <?php echo e($player->dbirth ? $player->dbirth->format('d/m/Y') : '-'); ?>

                        <?php elseif($column === 'sizes'): ?>
                            <?php echo e($player->sizes ?? '-'); ?>

                        <?php elseif($column === 'position'): ?>
                            <?php echo e($player->goalie ? 'Portero' : 'Jugador de campo'); ?>

                        <?php elseif($column === 'shirt_number'): ?>
                            <?php echo e($player->dorsal ?? '-'); ?>

                        <?php else: ?>
                            <?php echo e($player->$column ?? '-'); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
    
    <!-- FOOTER -->
    <div class="footer-box">
        <p class="footer-text">
            Este documento es de carácter privado y confidencial
            <?php if(auth()->user()->sportsSchool): ?> - <?php echo e(auth()->user()->sportsSchool->name); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data['season']): ?> - Temporada <?php echo e($data['season']->season); ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>
        <p class="footer-text text-small">
            Generado automáticamente el <?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?> a las <?php echo e(\Carbon\Carbon::now()->format('H:i')); ?>

            <br>
            www.vaed.es digitalización de escuelas deportivas.
        </p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\pdfs\team-players-list.blade.php ENDPATH**/ ?>