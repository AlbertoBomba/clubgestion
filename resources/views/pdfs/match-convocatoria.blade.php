<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Convocatoria</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 8px;
            background: linear-gradient(135deg, #e3f2fd 0%, #c5cae9 100%);
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        .header-box {
            background: linear-gradient(90deg, #2196f3 0%, #3f51b5 100%);
            padding: 25px;
            text-align: center;
            margin-bottom: 12px;
            border-radius: 12px;
        }
        
        .logo-container {
            margin-bottom: 12px;
        }
        
        .logo-img {
            width: 75px;
            height: 75px;
            background-color: white;
            border: 3px solid white;
            padding: 4px;
            display: inline-block;
            border-radius: 50%;
        }
        
        .club-name {
            color: white;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0 5px 0;
            letter-spacing: 1px;
        }
        
        .team-name {
            color: white;
            font-size: 16px;
            font-weight: normal;
            margin: 5px 0;
            opacity: 0.9;
        }
        
        .counter-badge {
            background-color: rgba(255,255,255,0.15);
            color: white;
            padding: 12px 20px;
            display: inline-block;
            margin-top: 15px;
            border-radius: 12px;
        }
        
        .counter-badge-num {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
        }
        
        .counter-badge-text {
            font-size: 10px;
            letter-spacing: 2px;
            margin: 0;
        }
        
        .info-box {
            background-color: white;
            padding: 18px 20px;
            margin-bottom: 12px;
            border-left: 5px solid #ec407a;
            border-radius: 0 8px 8px 0;
        }
        
        .info-title {
            color: #424242;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .info-row td {
            padding: 8px 12px 8px 0;
            font-size: 10px;
        }
        
        .label {
            font-weight: bold;
            color: #757575;
        }
        
        .value {
            color: #212121;
            font-weight: bold;
        }
        
        .players-header {
            background-color: white;
            padding: 15px 20px;
            margin-bottom: 8px;
            border-radius: 8px;
            border-bottom: 3px solid #66bb6a;
        }
        
        .players-title {
            color: #424242;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            display: inline-block;
        }
        
        .players-count {
            background-color: #66bb6a;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            float: right;
        }
        
        .player-cell {
            width: 33.33%;
            padding: 6px;
            text-align: center;
        }
        
        .player-box {
            background: linear-gradient(135deg, #fafafa 0%, #eeeeee 100%);
            padding: 12px;
            border: 2px solid #e0e0e0;
            height: 240px;
            position: relative;
            border-radius: 12px;
        }
        
        .photo-box {
            width: 100%;
            height: 160px;
            background-color: #f5f5f5;
            margin: 0 auto 12px;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }
        
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .photo-placeholder {
            background: linear-gradient(135deg, #42a5f5 0%, #5c6bc0 100%);
            width: 100%;
            height: 100%;
            color: white;
            font-size: 55px;
            font-weight: bold;
            text-align: center;
            line-height: 160px;
            border-radius: 8px;
        }
        
        .number-badge {
            position: absolute;
            top: 18px;
            right: 18px;
            background-color: #2196f3;
            color: white;
            font-weight: bold;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 8px;
        }
        
        .position-text {
            color: #2196f3;
            font-size: 9px;
            font-weight: bold;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .name-text {
            color: #212121;
            font-size: 12px;
            font-weight: bold;
            margin: 0;
            line-height: 1.4;
            text-transform: uppercase;
        }
        
        .footer-box {
            background-color: white;
            padding: 12px;
            text-align: center;
            margin-top: 12px;
            border-radius: 8px;
        }
        
        .footer-text {
            font-size: 9px;
            color: #757575;
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header-box">
        @if(auth()->user()->sportsSchool && auth()->user()->sportsSchool->logo)
        <div class="logo-container">
            <img class="logo-img" src="{{ public_path('storage/' . auth()->user()->sportsSchool->logo) }}" alt="Escudo">
        </div>
        @endif
        @if(auth()->user()->sportsSchool)
        <p class="club-name">{{ strtoupper(auth()->user()->sportsSchool->name) }}</p>
        @endif
        <p class="team-name">{{ $data['team']->team ?? 'EQUIPO' }}@if($data['team']->category) - {{ $data['team']->category->name }}@endif</p>
        <div class="counter-badge">
            <p class="counter-badge-num">{{ count($data['calledPlayers']) }}</p>
            <p class="counter-badge-text">CONVOCADOS</p>
        </div>
    </div>
    
    <!-- INFO BOX -->
    <div class="info-box">
        <p class="info-title">Información del Partido</p>
        <table>
            <tr class="info-row">
                <td class="label" width="15%">Fecha:</td>
                <td class="value" width="35%">{{ \Carbon\Carbon::parse($data['match']->date)->locale('es')->isoFormat('dddd, D [de] MMMM, YYYY') }}</td>
                <td class="label" width="15%">VS Rival:</td>
                <td class="value" width="35%">{{ $data['match']->opponent }}</td>
            </tr>
            @if($data['match']->hour_match || $data['match']->hour_meeting)
            <tr class="info-row">
                @if($data['match']->hour_match)
                <td class="label">Hora Partido:</td>
                <td class="value">{{ \Carbon\Carbon::parse($data['match']->hour_match)->format('H:i') }} h</td>
                @else
                <td colspan="2"></td>
                @endif
                @if($data['match']->hour_meeting)
                <td class="label">Citación:</td>
                <td class="value">{{ \Carbon\Carbon::parse($data['match']->hour_meeting)->format('H:i') }} h</td>
                @else
                <td colspan="2"></td>
                @endif
            </tr>
            @endif
            @if($data['match']->site)
            <tr class="info-row">
                <td class="label">Lugar:</td>
                <td class="value" colspan="3">{{ $data['match']->site }}</td>
            </tr>
            @endif
            @if($data['match']->observations)
            <tr class="info-row">
                <td class="label">Observaciones:</td>
                <td class="value" colspan="3">{{ $data['match']->observations }}</td>
            </tr>
            @endif
        </table>
    </div>
    
    <!-- PLAYERS HEADER -->
    <div class="players-header">
        <span class="players-title">Jugadores Convocados</span>
        <span class="players-count">{{ count($data['calledPlayers']) }}</span>
    </div>
    
    <!-- PLAYERS GRID (3 columnas) -->
    <table>
        @php
            $chunks = $data['calledPlayers']->chunk(3);
        @endphp
        @foreach($chunks as $rowIndex => $playersRow)
        <tr>
            @foreach($playersRow as $colIndex => $player)
            <td class="player-cell" valign="top">
                <div class="player-box">
                    <div class="photo-box">
                        @if($player->player_photo)
                            <img src="{{ public_path('storage/' . $player->player_photo) }}" alt="{{ $player->name }}">
                        @else
                            <div class="photo-placeholder">{{ substr($player->name, 0, 1) }}{{ substr($player->surname, 0, 1) }}</div>
                        @endif
                    </div>
                    @if($player->shirt_number)
                    <div class="number-badge">{{ $player->shirt_number }}</div>
                    @endif
                    @if($player->position)
                    <p class="position-text">{{ strtoupper($player->position) }}</p>
                    @endif
                    <p class="name-text">{{ strtoupper($player->name) }}</p>
                    <p class="name-text">{{ strtoupper($player->surname) }}</p>
                </div>
            </td>
            @endforeach
            @php
                $remaining = 3 - count($playersRow);
            @endphp
            @for($i = 0; $i < $remaining; $i++)
            <td class="player-cell"></td>
            @endfor
        </tr>
        @endforeach
    </table>
    
    <!-- FOOTER -->
    <div class="footer-box">
        <p class="footer-text">
            Esta convocatoria es de carácter privado y confidencial
            @if(auth()->user()->sportsSchool) - {{ auth()->user()->sportsSchool->name }}@endif
            - Temporada {{ $data['match']->season->season ?? '' }}
        </p>
    </div>
</body>
</html>
