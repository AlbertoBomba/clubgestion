<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($tournament->name); ?></title>
    <style>
        /* ============== CONFIGURACIÓN DE PÁGINAS MPDF ============== */
        /* Páginas internas: Fondo Blanco */
        @page {
            background-color: #ffffff;
            margin-top: 18mm;
            margin-bottom: 16mm;
            margin-left: 12mm;
            margin-right: 12mm;
            header: html_pageHeader;
            footer: html_pageFooter;
        }

        /* Primera página (Portada): Fondo Azul Marino sin márgenes ni header/footer */
        @page :first {
            background-color: #0f172a;
            margin: 0;
            header: _blank;
            footer: _blank;
        }

        * { 
            box-sizing: border-box; 
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1e293b;
            background-color: transparent;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }

        tr, table {
            page-break-inside: avoid;
        }

        /* ============== ETIQUETAS Y BADGES (REEMPLAZO DE ICONOS) ============== */
        .tag-micro {
            display: inline-block;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 1px 4px;
            border-radius: 2px;
            margin-right: 3px;
            vertical-align: middle;
            letter-spacing: 0.3px;
        }
        .tag-slate { background-color: #e2e8f0; color: #475569; }
        .tag-blue  { background-color: #dbeafe; color: #1e40af; }
        .tag-green { background-color: #dcfce7; color: #15803d; }
        .tag-amber { background-color: #fef3c7; color: #92400e; }

        /* ============== PORTADA (PÁGINA 1 - OSCURA) ============== */
        .cover-wrapper {
            width: 210mm;
            background-color: #0f172a;
            color: #ffffff;
        }

        .cover-header {
            padding: 12mm 15mm 6mm 15mm;
            background: #020617;
            border-bottom: 3px solid #2563eb;
        }
        .cover-brand {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #38bdf8;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .cover-title {
            font-size: 22px;
            line-height: 1.2;
            color: #ffffff;
            font-weight: bold;
            margin: 0 0 4px 0;
        }
        .cover-subtitle {
            font-size: 10px;
            color: #94a3b8;
        }

        .cover-image-container {
            width: 210mm;
            height: 220mm;
            text-align: center;
            vertical-align: middle;
            background-color: #0f172a;
            padding: 5mm;
        }
        .cover-image-container img {
            max-width: 195mm;
            max-height: 210mm;
            object-fit: contain;
            border-radius: 6px;
        }

        .cover-footer {
            padding: 6mm 15mm;
            background: #020617;
            border-top: 1px solid #1e293b;
        }
        .cover-meta-table td {
            vertical-align: middle;
            color: #cbd5e1;
            font-size: 9.5px;
        }
        .cover-badge {
            background-color: #1e293b;
            color: #38bdf8;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* ============== ENCABEZADO Y PIE PÁGINAS INTERNAS ============== */
        htmlpageheader, htmlpagefooter { 
            font-size: 8.5px; 
            color: #64748b; 
        }
        .header-table {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }
        .footer-table {
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }

        /* ============== CONTENIDO PÁGINAS INTERNAS ============== */
        .section-title {
            font-size: 14px;
            color: #0f172a;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 10px 0;
            padding-bottom: 4px;
            border-bottom: 2px solid #2563eb;
        }
        .sub-title {
            font-size: 11.5px;
            color: #1e3a8a;
            font-weight: bold;
            margin: 14px 0 6px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #cbd5e1;
        }
        .group-header {
            background-color: #f1f5f9;
            border-left: 3px solid #2563eb;
            padding: 5px 8px;
            font-size: 10.5px;
            font-weight: bold;
            color: #0f172a;
            margin: 10px 0 6px 0;
        }

        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 12px;
        }

        .tournament-summary-table td {
            vertical-align: middle;
        }
        .tournament-logo-img {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            object-fit: cover;
        }
        .tournament-logo-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            background-color: #2563eb;
            color: #ffffff;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            line-height: 50px;
        }

        .status-pill {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 4px;
        }
        .status-pill.in_progress { background: #fef3c7; color: #92400e; }
        .status-pill.registration_open { background: #dbeafe; color: #1e40af; }
        .status-pill.completed { background: #dcfce7; color: #166534; }
        .status-pill.draft { background: #f1f5f9; color: #475569; }
        .status-pill.cancelled { background: #fee2e2; color: #991b1b; }

        .grid-table {
            margin-bottom: 12px;
        }
        .grid-table td {
            width: 50%;
            padding: 5px 8px;
            vertical-align: top;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
        }
        .grid-label {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }
        .grid-value {
            font-size: 10px;
            color: #0f172a;
            font-weight: bold;
        }

        .description-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #0284c7;
            padding: 8px 10px;
            font-size: 9.5px;
            line-height: 1.4;
            color: #334155;
            margin-bottom: 12px;
        }

        .public-url-card {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 3px solid #16a34a;
            padding: 8px 10px;
            font-size: 9.5px;
            color: #15803d;
            margin-top: 8px;
            border-radius: 4px;
        }

        .teams-table {
            margin-bottom: 10px;
        }
        .teams-table td {
            padding: 5px 8px;
            border: 1px solid #e2e8f0;
            font-size: 9.5px;
            background-color: #ffffff;
            color: #0f172a;
            vertical-align: middle;
        }
        .team-logo-sm {
            width: 18px;
            height: 18px;
            object-fit: cover;
            border-radius: 3px;
            vertical-align: middle;
        }
        .team-logo-ph {
            display: inline-block;
            width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            background-color: #e2e8f0;
            color: #475569;
            font-size: 8.5px;
            font-weight: bold;
            border-radius: 3px;
            vertical-align: middle;
        }

        .matches-table {
            margin-bottom: 12px;
        }
        .matches-table thead td {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 7px;
            font-size: 8.5px;
            text-transform: uppercase;
            border: 1px solid #0f172a;
        }
        .matches-table tbody td {
            padding: 5px 7px;
            border: 1px solid #e2e8f0;
            font-size: 9.5px;
            vertical-align: middle;
            background-color: #ffffff;
            color: #0f172a;
        }
        .matches-table tbody tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        .team-name {
            font-weight: bold;
            color: #0f172a;
            vertical-align: middle;
        }
        .team-name.tbd {
            color: #94a3b8;
            font-weight: normal;
            font-style: italic;
        }

        .score-box {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            padding: 2px 5px;
            font-weight: bold;
            font-size: 10px;
            color: #0f172a;
        }
        .vs-badge {
            color: #94a3b8;
            font-size: 8.5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    
    
    
    <div class="cover-wrapper">
        <div class="cover-header">
            <div class="cover-brand"><?php echo e($school?->name ?? config('app.name')); ?></div>
            <h1 class="cover-title"><?php echo e($tournament->name); ?></h1>
            <div class="cover-subtitle">Dossier Oficial del Torneo</div>
        </div>

        <div class="cover-image-container">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournamentImage): ?>
                <img src="<?php echo e($tournamentImage); ?>" alt="Cartel del Torneo">
            <?php else: ?>
                <div style="padding-top: 60mm; color: #64748b; font-size: 14px;">
                    <?php echo e($tournament->name); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="cover-footer">
            <table class="cover-meta-table">
                <tr>
                    <td>
                        <span class="cover-badge">Guía Oficial</span>
                        <span style="color: #ffffff; font-weight: bold; margin-left: 6px;">Información para Coordinadores</span>
                    </td>
                    <td class="text-right" style="width: 50%;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->start_date): ?>
                            <strong style="color: #ffffff;">Fecha:</strong>
                            <?php echo e(\Carbon\Carbon::parse($tournament->start_date)->translatedFormat('d \d\e F, Y')); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->location): ?>
                            &nbsp;·&nbsp; <strong style="color: #ffffff;">Sede:</strong> <?php echo e($tournament->location); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Salto de página a páginas internas -->
    <div style="page-break-before: always;"></div>

    
    
    
    <htmlpageheader name="pageHeader">
        <table class="header-table">
            <tr>
                <td class="font-bold" style="color: #0f172a;"><?php echo e($tournament->name); ?></td>
                <td class="text-right" style="color: #64748b;"><?php echo e($school?->name ?? config('app.name')); ?></td>
            </tr>
        </table>
    </htmlpageheader>

    <htmlpagefooter name="pageFooter">
        <table class="footer-table">
            <tr>
                <td style="width: 70%;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($publicUrl): ?>
                        <span style="color: #2563eb; font-weight: bold;">Enlace público:</span> <?php echo e($publicUrl); ?>

                    <?php else: ?>
                        Dossier informativo para delegados
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-right" style="width: 30%;">
                    Página {PAGENO} de {nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    
    
    
    <div>
        <h2 class="section-title">Información del Torneo</h2>

        <div class="info-card">
            <table class="tournament-summary-table">
                <tr>
                    <td style="width: 55px;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournamentImage): ?>
                            <img src="<?php echo e($tournamentImage); ?>" class="tournament-logo-img" alt="Logo">
                        <?php else: ?>
                            <div class="tournament-logo-placeholder">
                                <?php echo e(mb_strtoupper(mb_substr($tournament->name, 0, 1))); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td style="padding-left: 10px;">
                        <div style="font-size: 15px; font-weight: bold; color: #0f172a; margin-bottom: 3px;">
                            <?php echo e($tournament->name); ?>

                            <span class="status-pill <?php echo e($tournament->status); ?>">
                                <?php echo e(\App\Models\Tournament::statuses()[$tournament->status] ?? $tournament->status); ?>

                            </span>
                        </div>
                        <div style="font-size: 9.5px; color: #64748b;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->start_date): ?>
                                <span class="tag-micro tag-slate">FECHA</span>
                                <?php echo e(\Carbon\Carbon::parse($tournament->start_date)->translatedFormat('d/m/Y')); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->end_date): ?> – <?php echo e(\Carbon\Carbon::parse($tournament->end_date)->translatedFormat('d/m/Y')); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->location): ?>
                                &nbsp;·&nbsp;
                                <span class="tag-micro tag-slate">SEDE</span>
                                <?php echo e($tournament->location); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->description): ?>
            <div class="description-box">
                <strong style="color: #0f172a; display: block; margin-bottom: 2px;">Descripción / Normativa:</strong>
                <?php echo nl2br(e($tournament->description)); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <table class="grid-table">
            <?php
                $teamTypeLabels = ['school' => 'Equipos del club', 'open' => 'Abierto (externos)', 'mixed' => 'Mixto'];
                $visibilityLabels = ['public' => 'Público', 'private' => 'Privado'];
                $rows = [];
                if ($tournament->location)                     $rows[] = ['Ubicación Principal', $tournament->location];
                if ($tournament->start_date)                   $rows[] = ['Fecha de Inicio', \Carbon\Carbon::parse($tournament->start_date)->translatedFormat('d/m/Y')];
                if ($tournament->end_date)                     $rows[] = ['Fecha de Finalización', \Carbon\Carbon::parse($tournament->end_date)->translatedFormat('d/m/Y')];
                if ($tournament->registration_deadline)        $rows[] = ['Cierre Inscripciones', \Carbon\Carbon::parse($tournament->registration_deadline)->translatedFormat('d/m/Y')];
                if ($tournament->player_registration_deadline) $rows[] = ['Cierre Jugadores', \Carbon\Carbon::parse($tournament->player_registration_deadline)->translatedFormat('d/m/Y')];
                if ($tournament->max_teams)                    $rows[] = ['Límite Equipos', $tournament->max_teams . ' equipos'];
                if ($tournament->max_players_per_team)         $rows[] = ['Máx. Jugadores / Equipo', $tournament->max_players_per_team . ' jugadores'];
                if ($tournament->min_age)                      $rows[] = ['Edad Mínima', $tournament->min_age . ' años'];
                if ($tournament->registration_fee !== null && (float) $tournament->registration_fee > 0) {
                    $rows[] = ['Cuota de Inscripción', number_format((float) $tournament->registration_fee, 2, ',', '.') . ' €'];
                }
                if ($tournament->team_type)                    $rows[] = ['Modalidad', $teamTypeLabels[$tournament->team_type] ?? $tournament->team_type];
                if ($tournament->visibility)                   $rows[] = ['Acceso', $visibilityLabels[$tournament->visibility] ?? $tournament->visibility];
                $rows[] = ['Equipos Confirmados', $tournament->tournamentTeams->count()];
                $rows[] = ['Total de Partidos', $tournament->matches->count()];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_chunk($rows, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $pair; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <span class="grid-label"><?php echo e($row[0]); ?></span>
                            <span class="grid-value"><?php echo e($row[1]); ?></span>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($pair) === 1): ?>
                        <td style="background-color: #ffffff; border-color: #e2e8f0;"></td>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </table>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($publicUrl): ?>
            <div class="public-url-card">
                <span class="tag-micro tag-green">WEB</span>
                <strong>Consulta online del torneo:</strong><br>
                <span style="font-size: 10px; font-weight: bold;"><?php echo e($publicUrl); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasGroupPhase): ?>
            <h3 class="sub-title">Composición de Grupos y Equipos</h3>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tournament->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $catTeams = $teamsByCategoryGroup->get($cat->id, collect()); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catTeams->isNotEmpty()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->team_type !== 'open'): ?>
                        <div class="group-header">Categoría: <?php echo e($cat->displayName()); ?></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $catTeams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $groupTeams): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="font-weight: bold; color: #1e3a8a; margin: 8px 0 4px 0; font-size: 10px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 2px;">
                            <?php echo e($groupLabel !== '—' ? 'Grupo ' . $groupLabel : 'Equipos del Grupo'); ?>

                        </div>

                        <table class="teams-table">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupTeams->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td style="width: 50%;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 20px; border:none; padding:0;">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($teamLogos[$tt->id])): ?>
                                                            <img src="<?php echo e($teamLogos[$tt->id]); ?>" class="team-logo-sm" alt="Logo">
                                                        <?php else: ?>
                                                            <span class="team-logo-ph"><?php echo e(mb_strtoupper(mb_substr($tt->displayName(), 0, 1))); ?></span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td style="border:none; padding:0 0 0 5px; font-weight: bold; color: #0f172a;">
                                                        <?php echo e($tt->displayName()); ?>

                                                    </td>
                                                    <td style="width: 30px; border:none; padding:0; text-align:right; color: #64748b; font-size: 8.5px;">
                                                        <?php echo e($tt->seed ? 'Nº ' . $tt->seed : ''); ?>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chunk->count() === 1): ?>
                                        <td style="width: 50%; background-color: #ffffff; border-color: #e2e8f0;"></td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </table>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php $uncategorized = $teamsByCategoryGroup->get(0, collect()); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($uncategorized->isNotEmpty()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $uncategorized; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupLabel => $groupTeams): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="font-weight: bold; color: #1e3a8a; margin: 8px 0 4px 0; font-size: 10px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 2px;">
                        <?php echo e($groupLabel !== '—' ? 'Grupo ' . $groupLabel : 'Equipos Inscritos'); ?>

                    </div>

                    <table class="teams-table">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupTeams->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td style="width: 50%;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="width: 20px; border:none; padding:0;">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($teamLogos[$tt->id])): ?>
                                                        <img src="<?php echo e($teamLogos[$tt->id]); ?>" class="team-logo-sm" alt="Logo">
                                                    <?php else: ?>
                                                        <span class="team-logo-ph"><?php echo e(mb_strtoupper(mb_substr($tt->displayName(), 0, 1))); ?></span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                                <td style="border:none; padding:0 0 0 5px; font-weight: bold; color: #0f172a;">
                                                    <?php echo e($tt->displayName()); ?>

                                                </td>
                                                <td style="width: 30px; border:none; padding:0; text-align:right; color: #64748b; font-size: 8.5px;">
                                                    <?php echo e($tt->seed ? 'Nº ' . $tt->seed : ''); ?>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chunk->count() === 1): ?>
                                    <td style="width: 50%; background-color: #ffffff; border-color: #e2e8f0;"></td>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </table>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php elseif($tournament->tournamentTeams->isNotEmpty()): ?>
            <h3 class="sub-title">Equipos Confirmados</h3>
            <table class="teams-table">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tournament->tournamentTeams->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td style="width: 50%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20px; border:none; padding:0;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($teamLogos[$tt->id])): ?>
                                                <img src="<?php echo e($teamLogos[$tt->id]); ?>" class="team-logo-sm" alt="Logo">
                                            <?php else: ?>
                                                <span class="team-logo-ph"><?php echo e(mb_strtoupper(mb_substr($tt->displayName(), 0, 1))); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td style="border:none; padding:0 0 0 5px; font-weight: bold; color: #0f172a;">
                                            <?php echo e($tt->displayName()); ?>

                                        </td>
                                        <td style="width: 30px; border:none; padding:0; text-align:right; color: #64748b; font-size: 8.5px;">
                                            <?php echo e($tt->seed ? 'Nº ' . $tt->seed : ''); ?>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chunk->count() === 1): ?>
                            <td style="width: 50%; background-color: #ffffff; border-color: #e2e8f0;"></td>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </table>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <h2 class="section-title" style="margin-top: 15px;">Calendario de Partidos</h2>

        <?php $matchStatusLabels = \App\Models\TournamentMatch::statuses(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tournament->matches->isEmpty()): ?>
            <div style="padding: 15px; text-align: center; color: #64748b; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px;">
                No hay partidos programados en el sistema por el momento.
            </div>
        <?php else: ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $matchesByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catId => $catMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $category = $tournament->categories->firstWhere('id', $catId); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category && $tournament->team_type !== 'open'): ?>
                    <h3 class="sub-title">Categoría: <?php echo e($category->displayName()); ?></h3>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php $byPhase = $catMatches->groupBy('phase_id'); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $byPhase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phaseId => $phaseMatches): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $phase = $phaseMatches->first()->phase; ?>
                    <div class="group-header">
                        <?php echo e($phase?->name ?? 'Fase de Partidos'); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phase): ?> <span style="font-weight: normal; color: #64748b;"> (<?php echo e($phase->typeLabel()); ?>)</span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <table class="matches-table">
                        <thead>
                            <tr>
                                <td style="width: 40px;" class="text-center">Jorn.</td>
                                <td style="width: 85px;">Fecha / Hora</td>
                                <td class="text-right" style="width: 30%;">Local</td>
                                <td class="text-center" style="width: 65px;">Resultado</td>
                                <td class="text-left" style="width: 30%;">Visitante</td>
                                <td style="width: 75px;" class="text-center">Estado / Campo</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $phaseMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center font-bold" style="color: #64748b;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->round): ?>
                                            J<?php echo e($match->round); ?>

                                        <?php else: ?>
                                            —
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->scheduled_at): ?>
                                            <span style="font-weight: bold; color: #0f172a;">
                                                <?php echo e(\Carbon\Carbon::parse($match->scheduled_at)->translatedFormat('d/m/Y')); ?>

                                            </span><br>
                                            <span style="color: #2563eb; font-weight: bold; font-size: 8.5px;">
                                                <span class="tag-micro tag-blue">HORA</span>
                                                <?php echo e(\Carbon\Carbon::parse($match->scheduled_at)->format('H:i')); ?> hs
                                            </span>
                                        <?php else: ?>
                                            <span style="color: #94a3b8; font-style: italic;">Por asignar</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <!-- EQUIPO LOCAL -->
                                    <td class="text-right">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->homeTeam): ?>
                                            <?php $hLogo = $teamLogos[$match->homeTeam->id] ?? null; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hLogo): ?>
                                                <img src="<?php echo e($hLogo); ?>" class="team-logo-sm" style="margin-right: 3px;" alt="">
                                            <?php else: ?>
                                                <span class="team-logo-ph" style="margin-right: 3px;"><?php echo e(mb_strtoupper(mb_substr($match->homeTeam->displayName(), 0, 1))); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <span class="team-name"><?php echo e($match->homeTeam->displayName()); ?></span>
                                        <?php else: ?>
                                            <span class="team-name tbd">Por determinar</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->status === 'completed'): ?>
                                            <span class="score-box">
                                                <?php echo e($match->home_score ?? 0); ?> – <?php echo e($match->away_score ?? 0); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="vs-badge">VS</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <!-- EQUIPO VISITANTE -->
                                    <td class="text-left">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->awayTeam): ?>
                                            <?php $aLogo = $teamLogos[$match->awayTeam->id] ?? null; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aLogo): ?>
                                                <img src="<?php echo e($aLogo); ?>" class="team-logo-sm" style="margin-right: 3px;" alt="">
                                            <?php else: ?>
                                                <span class="team-logo-ph" style="margin-right: 3px;"><?php echo e(mb_strtoupper(mb_substr($match->awayTeam->displayName(), 0, 1))); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <span class="team-name"><?php echo e($match->awayTeam->displayName()); ?></span>
                                        <?php else: ?>
                                            <span class="team-name tbd">Por determinar</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $statusColors = [
                                                'scheduled'   => ['#dbeafe', '#1e40af'],
                                                'in_progress' => ['#fef3c7', '#92400e'],
                                                'completed'   => ['#dcfce7', '#166534'],
                                                'cancelled'   => ['#fee2e2', '#991b1b'],
                                                'postponed'   => ['#ffedd5', '#9a3412'],
                                            ];
                                            $st = $statusColors[$match->status] ?? ['#f1f5f9', '#475569'];
                                        ?>
                                        <span style="background-color: <?php echo e($st[0]); ?>; color: <?php echo e($st[1]); ?>; padding: 2px 4px; border-radius: 3px; font-size: 7.5px; font-weight: bold; text-transform: uppercase;">
                                            <?php echo e($matchStatusLabels[$match->status] ?? $match->status); ?>

                                        </span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($match->location): ?>
                                            <div style="font-size: 7.5px; color: #64748b; margin-top: 2px; line-height: 1.1;">
                                                <span class="tag-micro tag-slate">SEDE</span>
                                                <?php echo e($match->location); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($match->notes)): ?>
                                    <tr>
                                        <td colspan="6" style="background-color: #fefce8; border-top: 1px dashed #fef08a; padding: 4px 10px; font-size: 8.5px; color: #713f12; line-height: 1.3;">
                                            <span class="tag-micro tag-amber">NOTA</span>
                                            <?php echo e($match->notes); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</body>
</html><?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\pdfs\tournament.blade.php ENDPATH**/ ?>