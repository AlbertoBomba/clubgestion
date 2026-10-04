<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha del Jugador - <?php echo e($player->name); ?> <?php echo e($player->surname); ?></title>
    <style>
        @page {
            margin: 20mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            color: #333333;
            background: #ffffff;
            line-height: 1.6;
        }
        
        /* Header Banner */
        .header-banner {
            background: #ffffff;
            padding: 10px 0;
            text-align: center;
            position: relative;
            border-bottom: 3px solid #2c5f8d;
            margin-bottom: 5px;
        }
        
        .logo-container {
            position: absolute;
            top: 10px;
            right: 0;
        }
        
        .club-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
        .player-photo {
            width: 120px;
            height: 120px;
            border-radius: 3px;
            border: 2px solid #2c5f8d;
            object-fit: cover;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .no-photo {
            width: 120px;
            height: 120px;
            border-radius: 3px;
            border: 2px solid #2c5f8d;
            background: #f5f5f5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #999999;
            font-size: 10pt;
            margin-bottom: 15px;
        }
        
        .player-name {
            font-size: 24pt;
            font-weight: 700;
            color: #2c5f8d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .player-subtitle {
            font-size: 11pt;
            color: #666666;
            font-weight: 400;
        }
        
        .player-subtitle strong {
            color: #2c5f8d;
            font-weight: 600;
        }
        
        /* Main Container */
        .main-container {
            margin-top: 0;
        }
        
        /* Info Cards Grid */
        .info-cards {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        
        .info-card {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-left: 3px solid #2c5f8d;
            vertical-align: top;
        }
        
        .card-title {
            font-size: 11pt;
            font-weight: 700;
            color: #2c5f8d;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }
        
        .card-item {
            margin-bottom: 8px;
            font-size: 9pt;
            line-height: 1.5;
        }
        
        .card-label {
            font-weight: 600;
            color: #666666;
            display: inline-block;
            min-width: 85px;
        }
        
        .card-value {
            color: #333333;
        }
        
        /* Status Bar */
        .status-bar {
            background: #f5f5f5;
            padding: 12px 20px;
            margin: 0 0 25px 0;
            text-align: center;
            border: 1px solid #e0e0e0;
            border-left: 3px solid #2c5f8d;
        }
        
        .status-item {
            display: inline-block;
            padding: 5px 15px;
            margin: 0 5px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid;
        }
        
        .status-active {
            background: #ffffff;
            color: #27ae60;
            border-color: #27ae60;
        }
        
        .status-inactive {
            background: #ffffff;
            color: #c0392b;
            border-color: #c0392b;
        }
        
        .status-info {
            background: #ffffff;
            color: #2c5f8d;
            border-color: #2c5f8d;
        }
        
        .status-warning {
            background: #ffffff;
            color: #d68910;
            border-color: #d68910;
        }
        
        /* Section Styling */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-header {
            background: #ffffff;
            color: #2c5f8d;
            padding: 10px 15px;
            margin-bottom: 15px;
            font-size: 12pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2c5f8d;
        }
        
        .section-content {
            padding: 0 15px;
        }
        
        /* Data Grid */
        .data-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-row {
            display: table-row;
        }
        
        .data-cell {
            display: table-cell;
            padding: 6px 7px;
            border-bottom: 1px solid #e0e0e0;
            width: 100%;
        }
        
        .data-cell:first-child {
            border-right: 1px solid #e0e0e0;
        }
        
        .data-label {
            font-size: 9pt;
            font-weight: 600;
            color: #666666;
            text-transform: uppercase;
            display: block;
            margin-bottom: 4px;
        }
        
        .data-value {
            font-size: 11pt;
            color: #333333;
            font-weight: 400;
        }
        
        .data-value.empty {
            color: #999999;
            font-style: italic;
            font-weight: 400;
        }
        
        /* Observations Box */
        .observations-box {
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-left: 3px solid #2c5f8d;
            padding: 15px;
            font-size: 10pt;
            line-height: 1.8;
            color: #333333;
        }
        
        /* Document List */
        .doc-list {
            list-style: none;
            padding: 0;
        }
        
        .doc-list li {
            padding: 10px 0 10px 30px;
            position: relative;
            font-size: 10pt;
            border-bottom: 1px solid #f0f0f0;
            color: #333333;
        }
        
        .doc-list li:last-child {
            border-bottom: none;
        }
        
        .doc-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            width: 18px;
            height: 18px;
            background: #ffffff;
            color: #27ae60;
            border: 2px solid #27ae60;
            text-align: center;
            line-height: 14px;
            border-radius: 3px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .doc-list strong {
            color: #2c5f8d;
            font-weight: 600;
        }
        
        /* Tutor Box */
        .tutor-box {
            background: #fafafa;
            border: 1px solid #e0e0e0;
            border-left: 3px solid #2c5f8d;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .tutor-name {
            font-size: 12pt;
            font-weight: 700;
            color: #2c5f8d;
            margin-bottom: 5px;
        }
        
        .tutor-dni {
            font-size: 10pt;
            color: #666666;
        }
    </style>
</head>
<body>
    <!-- Header Banner -->
    <div class="header-banner">
        
        
            
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->sportsSchool): ?>
        <p style="font-size: 10pt; color: #666666; margin-bottom: 10px; font-weight: 600;">
            <?php echo e($player->sportsSchool->name); ?>

        </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->player_photo): ?>
            <img src="<?php echo e(public_path('storage/' . $player->player_photo)); ?>" alt="Foto" class="player-photo">
        <?php else: ?>
            <div class="no-photo">Sin foto</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <h1 class="player-name"><?php echo e($player->name); ?> <?php echo e($player->surname); ?></h1>
        <p class="player-subtitle">
             <span class="data-label">Matrícula: </span>
            <span class="data-value <?php echo e(!$player->cod_matricula ? 'empty' : ''); ?>">
                <?php echo e($player->cod_matricula ?: 'No especificado'); ?>

            </span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->position): ?>
                <strong><?php echo e($player->position); ?></strong>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dorsal): ?>
                <?php echo e($player->position ? ' | ' : ''); ?>Dorsal <strong>#<?php echo e($player->dorsal); ?></strong>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span class="data-label">Talla</span>
            <span class="data-value <?php echo e(!$player->sizes ? 'empty' : ''); ?>">
                <?php echo e($player->sizes ?: 'No especificado'); ?>

            </span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dbanio): ?>
                | Año <strong><?php echo e($player->dbanio); ?></strong>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->goalie): ?>
                | <strong>Portero</strong>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span class=" <?php echo e($player->active ? 'status-active' : 'status-inactive'); ?>">
                <?php echo e($player->active ? '● Activo' : '● Inactivo'); ?>

            </span>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->goalie): ?>
            <span class=" status-warning">⚽ Portero</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>
    </div>
    
    <!-- Main Container -->
    <div class="main-container">
       
        
        <!-- Datos Jugador -->
        <div class="section">
            <div class="section-header">Datos Jugador</div>
            <div class="section-content">
                <div class="data-grid">
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">DNI: </span>
                            <span class="data-value <?php echo e(!$player->dni ? 'empty' : ''); ?>">
                                <?php echo e($player->dni ?: 'No especificado'); ?>

                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Fecha de Nacimiento: </span>
                            <span class="data-value <?php echo e(!$player->dbirth ? 'empty' : ''); ?>">
                                <?php echo e($player->dbirth ? \Carbon\Carbon::parse($player->dbirth)->format('d/m/Y') : 'No especificado'); ?>

                            </span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Escuela Deportiva</span>
                            <span class="data-value <?php echo e(!$player->sportsSchool ? 'empty' : ''); ?>">
                                <?php echo e($player->sportsSchool ? $player->sportsSchool->name : 'No especificado'); ?>

                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Equipo</span>
                            <span class="data-value <?php echo e(!$player->team ? 'empty' : ''); ?>">
                                <?php echo e($player->team ? $player->team->name : 'No especificado'); ?>

                            </span>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($player->nametutor) || !empty($player->surnametutor)): ?>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Tutor Legal - Nombre</span>
                            <span class="data-value <?php echo e(!$player->nametutor && !$player->surnametutor ? 'empty' : ''); ?>">
                                <?php echo e($player->nametutor); ?> <?php echo e($player->surnametutor); ?>

                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Tutor Legal - DNI</span>
                            <span class="data-value <?php echo e(!$player->dnitutor ? 'empty' : ''); ?>">
                                <?php echo e($player->dnitutor ?: 'No especificado'); ?>

                            </span>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Dirección</span>
                            <span class="data-value <?php echo e(!$player->address ? 'empty' : ''); ?>">
                                <?php echo e($player->address ?: 'No especificado'); ?>

                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Población</span>
                            <span class="data-value <?php echo e(!$player->town ? 'empty' : ''); ?>">
                                <?php echo e($player->town ?: 'No especificado'); ?>

                            </span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Código Postal</span>
                            <span class="data-value <?php echo e(!$player->zip ? 'empty' : ''); ?>">
                                <?php echo e($player->zip ?: 'No especificado'); ?>

                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Provincia</span>
                            <span class="data-value <?php echo e(!$player->province ? 'empty' : ''); ?>">
                                <?php echo e($player->province ?: 'No especificado'); ?>

                            </span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Teléfono</span>
                            <span class="data-value <?php echo e(!$player->phone1 ? 'empty' : ''); ?>">
                                <?php echo e($player->phone1 ?: 'No especificado'); ?>

                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Correo Electrónico</span>
                            <span class="data-value <?php echo e(!$player->email ? 'empty' : ''); ?>">
                                <?php echo e($player->email ?: 'No especificado'); ?>

                            </span>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->observations): ?>
        <!-- Observaciones -->
        <div class="section">
            <div class="section-header">Observaciones</div>
            <div class="section-content">
                <div class="observations-box">
                    <?php echo e($player->observations); ?>

                </div>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($player->documents) && is_array($player->documents)): ?>
        <!-- Documentación -->
        <div class="section">
            <div class="section-header">Documentación Adjunta</div>
            <div class="section-content">
                <ul class="doc-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $player->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <strong><?php echo e($doc['label'] ?? 'Documento'); ?></strong>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($doc['original_name'])): ?>
                            - <?php echo e($doc['original_name']); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\pdfs\playercard.blade.php ENDPATH**/ ?>