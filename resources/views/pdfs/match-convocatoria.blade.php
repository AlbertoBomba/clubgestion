<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Convocatoria</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 20px;
            padding: 0;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 5px 0;
            font-size: 20px;
            font-weight: bold;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 12px;
        }
        
        .info-section {
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .info-section p {
            margin: 4px 0;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .players-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        
        .players-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .players-table th {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        
        .players-table td {
            border: 1px solid #000;
            padding: 12px 8px;
            font-size: 11px;
        }
        
        .player-number {
            width: 40px;
            text-align: center;
        }
        
        .player-name {
            width: 60%;
        }
        
        .player-signature {
            width: 40%;
            height: 40px;
        }
        
        .footer {
            font-size: 9px;
            text-align: center;
            margin-top: 30px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        @if(auth()->user()->sportsSchool)
        <h1>{{ strtoupper(auth()->user()->sportsSchool->name) }}</h1>
        @endif
        <p><strong>{{ $data['team']->team ?? 'EQUIPO' }}@if($data['team']->category) - {{ strtoupper($data['team']->category->name) }}@endif</strong></p>
        <p>CONVOCATORIA DE PARTIDO {{ strtoupper($data['match']->opponent) }}</p>
    </div>
    
    <!-- INFORMACIÓN DEL PARTIDO -->
    <div class="info-section">
        <p><span class="info-label">RIVAL:</span> {{ strtoupper($data['match']->opponent) }}</p>
        <p><span class="info-label">FECHA:</span> {{ strtoupper(\Carbon\Carbon::parse($data['match']->date)->locale('es')->isoFormat('dddd, D [de] MMMM, YYYY')) }}</p>
        @if($data['match']->hour_match)
        <p><span class="info-label">HORA DEL PARTIDO:</span> {{ \Carbon\Carbon::parse($data['match']->hour_match)->format('H:i') }} H</p>
        @endif
        @if($data['match']->hour_meeting)
        <p><span class="info-label">HORA DE CITACIÓN:</span> {{ \Carbon\Carbon::parse($data['match']->hour_meeting)->format('H:i') }} H</p>
        @endif
        @if($data['match']->site)
        <p><span class="info-label">LUGAR:</span> {{ strtoupper($data['match']->site) }}</p>
        @endif
        @if($data['match']->observations)
        <p><span class="info-label">OBSERVACIONES:</span> {{ strtoupper($data['match']->observations) }}</p>
        @endif
    </div>
    
    <!-- TABLA DE JUGADORES -->
    <div class="players-title">JUGADORES CONVOCADOS ({{ count($data['calledPlayers']) }})</div>
    
    <table class="players-table">
        <thead>
            <tr>
                <th class="player-number">Nº</th>
                <th class="player-name">NOMBRE DEL JUGADOR</th>
                <th class="player-signature">FIRMA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['calledPlayers'] as $index => $player)
            <tr>
                <td class="player-number">{{ $index + 1 }}</td>
                <td class="player-name">{{ strtoupper($player->name) }} {{ strtoupper($player->surname) }}</td>
                <td class="player-signature"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- FOOTER -->
    <div class="footer">
        <p>
            ESTA CONVOCATORIA ES DE CARÁCTER PRIVADO Y CONFIDENCIAL
            @if(auth()->user()->sportsSchool) - {{ strtoupper(auth()->user()->sportsSchool->name) }}@endif
            - TEMPORADA {{ strtoupper($data['match']->season->season ?? '') }}
        </p>
    </div>
</body>
</html>
