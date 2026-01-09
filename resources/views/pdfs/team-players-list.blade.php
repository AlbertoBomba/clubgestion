<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Jugadores - {{ $data['team']->team }}</title>
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
        @if(auth()->user()->sportsSchool && auth()->user()->sportsSchool->logo)
        <div class="logo-container">
            <img class="logo-img" src="{{ public_path('storage/' . auth()->user()->sportsSchool->logo) }}" alt="Escudo">
        </div>
        @endif
        @if(auth()->user()->sportsSchool)
        <p class="club-title">{{ strtoupper(auth()->user()->sportsSchool->name) }}</p>
        @endif
        <p class="document-title">LISTADO DE JUGADORES</p>
        <p class="team-info">{{ $data['team']->team }} @if($data['category'])- {{ $data['category']->name }}@endif</p>
        <p class="generation-date">Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <!-- INFO BOX -->
    <div class="info-box">
        <table>
            <tr>
                <td class="info-label">Equipo:</td>
                <td class="info-value">{{ $data['team']->team }}</td>
                <td class="info-label">Temporada:</td>
                <td class="info-value">{{ $data['season']->season ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Categoría:</td>
                <td class="info-value">{{ $data['category']->name ?? 'N/A' }}</td>
                <td class="info-label">Total Jugadores:</td>
                <td class="info-value">{{ $data['players']->count() }}</td>
            </tr>
            @if($data['team']->gender)
            <tr>
                <td class="info-label">Género:</td>
                <td class="info-value">{{ ucfirst($data['team']->gender) }}</td>
                <td class="info-label">Federado:</td>
                <td class="info-value">{{ $data['team']->federate ? 'Sí' : 'No' }}</td>
            </tr>
            @endif
        </table>
    </div>
    
    <!-- COUNTER BADGE -->
    <div class="text-center">
        <span class="counter-badge">{{ $data['players']->count() }} JUGADOR{{ $data['players']->count() != 1 ? 'ES' : '' }}</span>
    </div>
    
    <!-- PLAYERS TABLE -->
    <table class="players-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">#</th>
                @foreach($data['selectedColumns'] as $column)
                    <th>{{ $data['availableColumns'][$column] ?? $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data['players'] as $index => $player)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                @foreach($data['selectedColumns'] as $column)
                    <td>
                        @if($column === 'dbirth')
                            {{ $player->dbirth ? $player->dbirth->format('d/m/Y') : '-' }}
                        @elseif($column === 'sizes')
                            {{ $player->sizes ?? '-' }}
                        @elseif($column === 'position')
                            {{ $player->position ? strtoupper($player->position) : '-' }}
                        @elseif($column === 'shirt_number')
                            {{ $player->shirt_number ?? '-' }}
                        @else
                            {{ $player->$column ?? '-' }}
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- FOOTER -->
    <div class="footer-box">
        <p class="footer-text">
            Este documento es de carácter privado y confidencial
            @if(auth()->user()->sportsSchool) - {{ auth()->user()->sportsSchool->name }}@endif
            @if($data['season']) - Temporada {{ $data['season']->season }}@endif
        </p>
        <p class="footer-text text-small">
            Generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y') }} a las {{ \Carbon\Carbon::now()->format('H:i') }}
        </p>
    </div>
</body>
</html>
