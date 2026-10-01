<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $tournament->name }}</title>
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

    {{-- ================================================================ --}}
    {{-- PÁGINA 1: PORTADA                                                --}}
    {{-- ================================================================ --}}
    <div class="cover-wrapper">
        <div class="cover-header">
            <div class="cover-brand">{{ $school?->name ?? config('app.name') }}</div>
            <h1 class="cover-title">{{ $tournament->name }}</h1>
            <div class="cover-subtitle">Dossier Oficial del Torneo</div>
        </div>

        <div class="cover-image-container">
            @if ($tournamentImage)
                <img src="{{ $tournamentImage }}" alt="Cartel del Torneo">
            @else
                <div style="padding-top: 60mm; color: #64748b; font-size: 14px;">
                    {{ $tournament->name }}
                </div>
            @endif
        </div>

        <div class="cover-footer">
            <table class="cover-meta-table">
                <tr>
                    <td>
                        <span class="cover-badge">Guía Oficial</span>
                        <span style="color: #ffffff; font-weight: bold; margin-left: 6px;">Información para Coordinadores</span>
                    </td>
                    <td class="text-right" style="width: 50%;">
                        @if ($tournament->start_date)
                            <strong style="color: #ffffff;">Fecha:</strong>
                            {{ \Carbon\Carbon::parse($tournament->start_date)->translatedFormat('d \d\e F, Y') }}
                        @endif
                        @if ($tournament->location)
                            &nbsp;·&nbsp; <strong style="color: #ffffff;">Sede:</strong> {{ $tournament->location }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Salto de página a páginas internas -->
    <div style="page-break-before: always;"></div>

    {{-- ================================================================ --}}
    {{-- ENCABEZADO Y PIE PÁGINAS INTERNAS                                --}}
    {{-- ================================================================ --}}
    <htmlpageheader name="pageHeader">
        <table class="header-table">
            <tr>
                <td class="font-bold" style="color: #0f172a;">{{ $tournament->name }}</td>
                <td class="text-right" style="color: #64748b;">{{ $school?->name ?? config('app.name') }}</td>
            </tr>
        </table>
    </htmlpageheader>

    <htmlpagefooter name="pageFooter">
        <table class="footer-table">
            <tr>
                <td style="width: 70%;">
                    @if ($publicUrl)
                        <span style="color: #2563eb; font-weight: bold;">Enlace público:</span> {{ $publicUrl }}
                    @else
                        Dossier informativo para delegados
                    @endif
                </td>
                <td class="text-right" style="width: 30%;">
                    Página {PAGENO} de {nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    {{-- ================================================================ --}}
    {{-- CONTENIDO EN FONDO BLANCO                                        --}}
    {{-- ================================================================ --}}
    <div>
        <h2 class="section-title">Información del Torneo</h2>

        <div class="info-card">
            <table class="tournament-summary-table">
                <tr>
                    <td style="width: 55px;">
                        @if ($tournamentImage)
                            <img src="{{ $tournamentImage }}" class="tournament-logo-img" alt="Logo">
                        @else
                            <div class="tournament-logo-placeholder">
                                {{ mb_strtoupper(mb_substr($tournament->name, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td style="padding-left: 10px;">
                        <div style="font-size: 15px; font-weight: bold; color: #0f172a; margin-bottom: 3px;">
                            {{ $tournament->name }}
                            <span class="status-pill {{ $tournament->status }}">
                                {{ \App\Models\Tournament::statuses()[$tournament->status] ?? $tournament->status }}
                            </span>
                        </div>
                        <div style="font-size: 9.5px; color: #64748b;">
                            @if ($tournament->start_date)
                                <span class="tag-micro tag-slate">FECHA</span>
                                {{ \Carbon\Carbon::parse($tournament->start_date)->translatedFormat('d/m/Y') }}
                                @if ($tournament->end_date) – {{ \Carbon\Carbon::parse($tournament->end_date)->translatedFormat('d/m/Y') }} @endif
                            @endif
                            @if ($tournament->location)
                                &nbsp;·&nbsp;
                                <span class="tag-micro tag-slate">SEDE</span>
                                {{ $tournament->location }}
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        @if ($tournament->description)
            <div class="description-box">
                <strong style="color: #0f172a; display: block; margin-bottom: 2px;">Descripción / Normativa:</strong>
                {!! nl2br(e($tournament->description)) !!}
            </div>
        @endif

        <table class="grid-table">
            @php
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
            @endphp

            @foreach (array_chunk($rows, 2) as $pair)
                <tr>
                    @foreach ($pair as $row)
                        <td>
                            <span class="grid-label">{{ $row[0] }}</span>
                            <span class="grid-value">{{ $row[1] }}</span>
                        </td>
                    @endforeach
                    @if (count($pair) === 1)
                        <td style="background-color: #ffffff; border-color: #e2e8f0;"></td>
                    @endif
                </tr>
            @endforeach
        </table>

        @if ($publicUrl)
            <div class="public-url-card">
                <span class="tag-micro tag-green">WEB</span>
                <strong>Consulta online del torneo:</strong><br>
                <span style="font-size: 10px; font-weight: bold;">{{ $publicUrl }}</span>
            </div>
        @endif

        {{-- ================= SECCIÓN: GRUPOS Y EQUIPOS ================= --}}
        @if ($hasGroupPhase)
            <h3 class="sub-title">Composición de Grupos y Equipos</h3>

            @foreach ($tournament->categories as $cat)
                @php $catTeams = $teamsByCategoryGroup->get($cat->id, collect()); @endphp
                @if ($catTeams->isNotEmpty())
                    @if ($tournament->team_type !== 'open')
                        <div class="group-header">Categoría: {{ $cat->displayName() }}</div>
                    @endif

                    @foreach ($catTeams as $groupLabel => $groupTeams)
                        <div style="font-weight: bold; color: #1e3a8a; margin: 8px 0 4px 0; font-size: 10px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 2px;">
                            {{ $groupLabel !== '—' ? 'Grupo ' . $groupLabel : 'Equipos del Grupo' }}
                        </div>

                        <table class="teams-table">
                            @foreach ($groupTeams->chunk(2) as $chunk)
                                <tr>
                                    @foreach ($chunk as $tt)
                                        <td style="width: 50%;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 20px; border:none; padding:0;">
                                                        @if (! empty($teamLogos[$tt->id]))
                                                            <img src="{{ $teamLogos[$tt->id] }}" class="team-logo-sm" alt="Logo">
                                                        @else
                                                            <span class="team-logo-ph">{{ mb_strtoupper(mb_substr($tt->displayName(), 0, 1)) }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="border:none; padding:0 0 0 5px; font-weight: bold; color: #0f172a;">
                                                        {{ $tt->displayName() }}
                                                    </td>
                                                    <td style="width: 30px; border:none; padding:0; text-align:right; color: #64748b; font-size: 8.5px;">
                                                        {{ $tt->seed ? 'Nº ' . $tt->seed : '' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @endforeach
                                    @if ($chunk->count() === 1)
                                        <td style="width: 50%; background-color: #ffffff; border-color: #e2e8f0;"></td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    @endforeach
                @endif
            @endforeach

            @php $uncategorized = $teamsByCategoryGroup->get(0, collect()); @endphp
            @if ($uncategorized->isNotEmpty())
                @foreach ($uncategorized as $groupLabel => $groupTeams)
                    <div style="font-weight: bold; color: #1e3a8a; margin: 8px 0 4px 0; font-size: 10px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 2px;">
                        {{ $groupLabel !== '—' ? 'Grupo ' . $groupLabel : 'Equipos Inscritos' }}
                    </div>

                    <table class="teams-table">
                        @foreach ($groupTeams->chunk(2) as $chunk)
                            <tr>
                                @foreach ($chunk as $tt)
                                    <td style="width: 50%;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="width: 20px; border:none; padding:0;">
                                                    @if (! empty($teamLogos[$tt->id]))
                                                        <img src="{{ $teamLogos[$tt->id] }}" class="team-logo-sm" alt="Logo">
                                                    @else
                                                        <span class="team-logo-ph">{{ mb_strtoupper(mb_substr($tt->displayName(), 0, 1)) }}</span>
                                                    @endif
                                                </td>
                                                <td style="border:none; padding:0 0 0 5px; font-weight: bold; color: #0f172a;">
                                                    {{ $tt->displayName() }}
                                                </td>
                                                <td style="width: 30px; border:none; padding:0; text-align:right; color: #64748b; font-size: 8.5px;">
                                                    {{ $tt->seed ? 'Nº ' . $tt->seed : '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                @endforeach
                                @if ($chunk->count() === 1)
                                    <td style="width: 50%; background-color: #ffffff; border-color: #e2e8f0;"></td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            @endif

        @elseif ($tournament->tournamentTeams->isNotEmpty())
            <h3 class="sub-title">Equipos Confirmados</h3>
            <table class="teams-table">
                @foreach ($tournament->tournamentTeams->chunk(2) as $chunk)
                    <tr>
                        @foreach ($chunk as $tt)
                            <td style="width: 50%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20px; border:none; padding:0;">
                                            @if (! empty($teamLogos[$tt->id]))
                                                <img src="{{ $teamLogos[$tt->id] }}" class="team-logo-sm" alt="Logo">
                                            @else
                                                <span class="team-logo-ph">{{ mb_strtoupper(mb_substr($tt->displayName(), 0, 1)) }}</span>
                                            @endif
                                        </td>
                                        <td style="border:none; padding:0 0 0 5px; font-weight: bold; color: #0f172a;">
                                            {{ $tt->displayName() }}
                                        </td>
                                        <td style="width: 30px; border:none; padding:0; text-align:right; color: #64748b; font-size: 8.5px;">
                                            {{ $tt->seed ? 'Nº ' . $tt->seed : '' }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endforeach
                        @if ($chunk->count() === 1)
                            <td style="width: 50%; background-color: #ffffff; border-color: #e2e8f0;"></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif

        {{-- ================= SECCIÓN: CALENDARIO DE PARTIDOS ================= --}}
        <h2 class="section-title" style="margin-top: 15px;">Calendario de Partidos</h2>

        @php $matchStatusLabels = \App\Models\TournamentMatch::statuses(); @endphp

        @if ($tournament->matches->isEmpty())
            <div style="padding: 15px; text-align: center; color: #64748b; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px;">
                No hay partidos programados en el sistema por el momento.
            </div>
        @else
            @foreach ($matchesByCategory as $catId => $catMatches)
                @php $category = $tournament->categories->firstWhere('id', $catId); @endphp
                @if ($category && $tournament->team_type !== 'open')
                    <h3 class="sub-title">Categoría: {{ $category->displayName() }}</h3>
                @endif

                @php $byPhase = $catMatches->groupBy('phase_id'); @endphp

                @foreach ($byPhase as $phaseId => $phaseMatches)
                    @php $phase = $phaseMatches->first()->phase; @endphp
                    <div class="group-header">
                        {{ $phase?->name ?? 'Fase de Partidos' }}
                        @if ($phase) <span style="font-weight: normal; color: #64748b;"> ({{ $phase->typeLabel() }})</span> @endif
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
                            @foreach ($phaseMatches as $match)
                                <tr>
                                    <td class="text-center font-bold" style="color: #64748b;">
                                        @if ($match->round)
                                            J{{ $match->round }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if ($match->scheduled_at)
                                            <span style="font-weight: bold; color: #0f172a;">
                                                {{ \Carbon\Carbon::parse($match->scheduled_at)->translatedFormat('d/m/Y') }}
                                            </span><br>
                                            <span style="color: #2563eb; font-weight: bold; font-size: 8.5px;">
                                                <span class="tag-micro tag-blue">HORA</span>
                                                {{ \Carbon\Carbon::parse($match->scheduled_at)->format('H:i') }} hs
                                            </span>
                                        @else
                                            <span style="color: #94a3b8; font-style: italic;">Por asignar</span>
                                        @endif
                                    </td>
                                    <!-- EQUIPO LOCAL -->
                                    <td class="text-right">
                                        @if ($match->homeTeam)
                                            @php $hLogo = $teamLogos[$match->homeTeam->id] ?? null; @endphp
                                            @if ($hLogo)
                                                <img src="{{ $hLogo }}" class="team-logo-sm" style="margin-right: 3px;" alt="">
                                            @else
                                                <span class="team-logo-ph" style="margin-right: 3px;">{{ mb_strtoupper(mb_substr($match->homeTeam->displayName(), 0, 1)) }}</span>
                                            @endif
                                            <span class="team-name">{{ $match->homeTeam->displayName() }}</span>
                                        @else
                                            <span class="team-name tbd">Por determinar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($match->status === 'completed')
                                            <span class="score-box">
                                                {{ $match->home_score ?? 0 }} – {{ $match->away_score ?? 0 }}
                                            </span>
                                        @else
                                            <span class="vs-badge">VS</span>
                                        @endif
                                    </td>
                                    <!-- EQUIPO VISITANTE -->
                                    <td class="text-left">
                                        @if ($match->awayTeam)
                                            @php $aLogo = $teamLogos[$match->awayTeam->id] ?? null; @endphp
                                            @if ($aLogo)
                                                <img src="{{ $aLogo }}" class="team-logo-sm" style="margin-right: 3px;" alt="">
                                            @else
                                                <span class="team-logo-ph" style="margin-right: 3px;">{{ mb_strtoupper(mb_substr($match->awayTeam->displayName(), 0, 1)) }}</span>
                                            @endif
                                            <span class="team-name">{{ $match->awayTeam->displayName() }}</span>
                                        @else
                                            <span class="team-name tbd">Por determinar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusColors = [
                                                'scheduled'   => ['#dbeafe', '#1e40af'],
                                                'in_progress' => ['#fef3c7', '#92400e'],
                                                'completed'   => ['#dcfce7', '#166534'],
                                                'cancelled'   => ['#fee2e2', '#991b1b'],
                                                'postponed'   => ['#ffedd5', '#9a3412'],
                                            ];
                                            $st = $statusColors[$match->status] ?? ['#f1f5f9', '#475569'];
                                        @endphp
                                        <span style="background-color: {{ $st[0] }}; color: {{ $st[1] }}; padding: 2px 4px; border-radius: 3px; font-size: 7.5px; font-weight: bold; text-transform: uppercase;">
                                            {{ $matchStatusLabels[$match->status] ?? $match->status }}
                                        </span>
                                        @if ($match->location)
                                            <div style="font-size: 7.5px; color: #64748b; margin-top: 2px; line-height: 1.1;">
                                                <span class="tag-micro tag-slate">SEDE</span>
                                                {{ $match->location }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endforeach
        @endif
    </div>

</body>
</html>