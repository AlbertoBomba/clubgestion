<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horarios de Entrenamiento - {{ $season ? $season->season : 'N/A' }}</title>
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
            font-size: 11px;
            color: #374151;
            background: #ffffff;
            line-height: 1.4;
        }
        
        h1 {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 20px 0;
            text-align: left;
        }
        
        .season-info {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 12px;
        }
        
        .season-info strong {
            color: #1f2937;
            font-weight: 600;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid #e5e7eb;
            margin-bottom: 10px;
        }
        
        thead {
            background: #f9fafb;
        }
        
        th {
            padding: 12px 15px;
            text-align: left;
            font-size: 10px;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        tbody tr:last-child {
            border-bottom: none;
        }
        
        td {
            padding: 15px;
            vertical-align: top;
        }
        
        .team-name {
            font-size: 12px;
            font-weight: 500;
            color: #111827;
            margin-bottom: 3px;
        }
        
        .category-name {
            font-size: 10px;
            color: #6b7280;
        }
        
        .schedule-group {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .schedule-group:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .schedule-header {
            margin-bottom: 5px;
        }
        
        .days-text {
            font-size: 11px;
            font-weight: 500;
            color: #374151;
            display: inline-block;
            margin-right: 10px;
        }
        
        .time-text {
            font-size: 11px;
            font-weight: 600;
            color: #111827;
            display: inline-block;
            margin-right: 10px;
        }
        
        .duration-badge {
            display: inline-block;
            background: #f3f4f6;
            color: #4b5563;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 500;
        }
        
        .field-info {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        
        .field-color {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }
        
        .notes-text {
            font-size: 10px;
            color: #6b7280;
            font-style: italic;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <h1>Horarios de Entrenamiento</h1>
    
    <div class="season-info">
        Temporada: <strong>{{ $season ? $season->season : 'N/A' }}</strong>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 18%;">Equipo</th>
                <th style="width: 18%;">Entrenadores</th>
                <th style="width: 10%; text-align: center;">Jugadores</th>
                <th style="width: 54%;">Horarios de Entrenamiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedulesByTeam as $teamId => $teamSchedules)
                @php
                    $team = $teamSchedules->first()->team;
                    // Agrupar por horario + campo + notas para mostrar días juntos
                    $groupedSchedules = $teamSchedules->groupBy(function($schedule) {
                        return $schedule->start_time . '|' . $schedule->end_time . '|' . $schedule->training_field_id . '|' . ($schedule->notes ?? '');
                    });
                @endphp
                
                <tr>
                    <td>
                        <div class="team-name">{{ $team->team }}</div>
                        @if($team->category)
                            <div class="category-name">{{ $team->category->category }}</div>
                        @endif
                    </td>
                    <td>
                        @if($team->coaches->count() > 0)
                            @foreach($team->coaches as $coach)
                                <div style="font-size: 10px; color: #374151; margin-bottom: 2px;">{{ $coach->name }}</div>
                            @endforeach
                        @else
                            <span style="font-size: 9px; color: #9ca3af; font-style: italic;">Sin entrenadores</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <span style="display: inline-block; background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 50%; font-size: 11px; font-weight: 600;">
                            {{ $team->players->count() }}
                        </span>
                    </td>
                    <td>
                        @foreach($groupedSchedules as $timeKey => $schedules)
                            @php
                                $firstSchedule = $schedules->first();
                                
                                // Obtener todos los días de este grupo
                                $days = $schedules->pluck('day_of_week')->map(function($day) use ($daysOfWeek) {
                                    return $daysOfWeek[$day] ?? $day;
                                })->toArray();
                                $daysText = implode(', ', $days);
                                
                                $startTime = \Carbon\Carbon::parse($firstSchedule->start_time)->format('H:i');
                                $endTime = \Carbon\Carbon::parse($firstSchedule->end_time)->format('H:i');
                                
                                // Calcular duración
                                $start = \Carbon\Carbon::parse($firstSchedule->start_time);
                                $end = \Carbon\Carbon::parse($firstSchedule->end_time);
                                $diffInMinutes = $start->diffInMinutes($end);
                                $hours = floor($diffInMinutes / 60);
                                $minutes = $diffInMinutes % 60;
                                $durationText = '';
                                if ($hours > 0) {
                                    $durationText .= $hours . 'h ';
                                }
                                $durationText .= $minutes . 'min';
                            @endphp
                            
                            <div class="schedule-group">
                                <div class="schedule-header">
                                    <span class="days-text">{{ $daysText }}</span>
                                    <span class="time-text">{{ $startTime }} - {{ $endTime }}</span>
                                    <span class="duration-badge">{{ $durationText }}</span>
                                </div>
                                <div class="field-info">
                                    <span class="field-color" style="background-color: {{ $firstSchedule->trainingField->color }}"></span>
                                    {{ $firstSchedule->trainingField->name }}
                                </div>
                                @if($firstSchedule->notes)
                                    <div class="notes-text">{{ $firstSchedule->notes }}</div>
                                @endif
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
