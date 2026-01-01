<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha del Jugador - {{ $player->name }} {{ $player->surname }}</title>
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
        {{-- @if($player->sportsSchool && $player->sportsSchool->logo) --}}
        {{-- {{ asset('storage/' . auth()->user()->sportsSchool->logo) }} --}}
            {{-- <div class="logo-container">
                <img src="{{ asset('storage/' . $player->sportsSchool->logo) }}" alt="Logo" class="player-photo">
            </div>
        @endif --}}
        
        @if($player->sportsSchool)
        <p style="font-size: 10pt; color: #666666; margin-bottom: 10px; font-weight: 600;">
            {{ $player->sportsSchool->name }}
        </p>
        @endif
        
        @if($player->player_photo)
            <img src="{{ public_path('storage/' . $player->player_photo) }}" alt="Foto" class="player-photo">
        @else
            <div class="no-photo">Sin foto</div>
        @endif
        
        <h1 class="player-name">{{ $player->name }} {{ $player->surname }}</h1>
        <p class="player-subtitle">
             <span class="data-label">Matrícula: </span>
            <span class="data-value {{ !$player->cod_matricula ? 'empty' : '' }}">
                {{ $player->cod_matricula ?: 'No especificado' }}
            </span>
            @if($player->position)
                <strong>{{ $player->position }}</strong>
            @endif
            @if($player->dorsal)
                {{ $player->position ? ' | ' : '' }}Dorsal <strong>#{{ $player->dorsal }}</strong>
            @endif
            <span class="data-label">Talla</span>
            <span class="data-value {{ !$player->sizes ? 'empty' : '' }}">
                {{ $player->sizes ?: 'No especificado' }}
            </span>
            @if($player->dbanio)
                | Año <strong>{{ $player->dbanio }}</strong>
            @endif
            @if($player->goalie)
                | <strong>Portero</strong>
            @endif
            <span class=" {{ $player->active ? 'status-active' : 'status-inactive' }}">
                {{ $player->active ? '● Activo' : '● Inactivo' }}
            </span>
            {{-- @if($player->file)
             <span class="status-item status-info">✓ Ficha Completa</span>
            @endif --}}
            @if($player->goalie)
            <span class=" status-warning">⚽ Portero</span>
            @endif
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
                            <span class="data-value {{ !$player->dni ? 'empty' : '' }}">
                                {{ $player->dni ?: 'No especificado' }}
                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Fecha de Nacimiento: </span>
                            <span class="data-value {{ !$player->dbirth ? 'empty' : '' }}">
                                {{ $player->dbirth ? \Carbon\Carbon::parse($player->dbirth)->format('d/m/Y') : 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Escuela Deportiva</span>
                            <span class="data-value {{ !$player->sportsSchool ? 'empty' : '' }}">
                                {{ $player->sportsSchool ? $player->sportsSchool->name : 'No especificado' }}
                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Equipo</span>
                            <span class="data-value {{ !$player->team ? 'empty' : '' }}">
                                {{ $player->team ? $player->team->name : 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    @if(!empty($player->nametutor) || !empty($player->surnametutor))
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Tutor Legal - Nombre</span>
                            <span class="data-value {{ !$player->nametutor && !$player->surnametutor ? 'empty' : '' }}">
                                {{ $player->nametutor }} {{ $player->surnametutor }}
                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Tutor Legal - DNI</span>
                            <span class="data-value {{ !$player->dnitutor ? 'empty' : '' }}">
                                {{ $player->dnitutor ?: 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    @endif
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Dirección</span>
                            <span class="data-value {{ !$player->address ? 'empty' : '' }}">
                                {{ $player->address ?: 'No especificado' }}
                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Población</span>
                            <span class="data-value {{ !$player->town ? 'empty' : '' }}">
                                {{ $player->town ?: 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Código Postal</span>
                            <span class="data-value {{ !$player->zip ? 'empty' : '' }}">
                                {{ $player->zip ?: 'No especificado' }}
                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Provincia</span>
                            <span class="data-value {{ !$player->province ? 'empty' : '' }}">
                                {{ $player->province ?: 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell">
                            <span class="data-label">Teléfono</span>
                            <span class="data-value {{ !$player->phone1 ? 'empty' : '' }}">
                                {{ $player->phone1 ?: 'No especificado' }}
                            </span>
                        </div>
                        <div class="data-cell">
                            <span class="data-label">Correo Electrónico</span>
                            <span class="data-value {{ !$player->email ? 'empty' : '' }}">
                                {{ $player->email ?: 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    {{-- <div class="data-row">
                        <div class="data-cell">
                            @if($player->descEnt || $player->descPerc)
                            <span class="data-label">Descuentos</span>
                            <span class="data-value">
                                @if($player->descEnt)
                                    {{ number_format($player->descEnt, 2, ',', '.') }} €
                                @endif
                                @if($player->descPerc)
                                    {{ $player->descEnt ? ' | ' : '' }}{{ number_format($player->descPerc, 2, ',', '.') }}%
                                @endif
                            </span>
                            @endif
                        </div>
                    </div> --}}
                    
                </div>
            </div>
        </div>
        
        @if($player->observations)
        <!-- Observaciones -->
        <div class="section">
            <div class="section-header">Observaciones</div>
            <div class="section-content">
                <div class="observations-box">
                    {{ $player->observations }}
                </div>
            </div>
        </div>
        @endif
        
        @if(!empty($player->documents) && is_array($player->documents))
        <!-- Documentación -->
        <div class="section">
            <div class="section-header">Documentación Adjunta</div>
            <div class="section-content">
                <ul class="doc-list">
                    @foreach($player->documents as $doc)
                    <li>
                        <strong>{{ $doc['label'] ?? 'Documento' }}</strong>
                        @if(isset($doc['original_name']))
                            - {{ $doc['original_name'] }}
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
