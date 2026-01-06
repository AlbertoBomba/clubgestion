<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Pagos de Equipos</title>
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
        
        .generation-date {
            font-size: 8pt;
            color: #666666;
        }
        
        /* Team Section */
        .team-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        
        .team-header {
            background: linear-gradient(to right, #2c5f8d, #4a7ba7);
            color: white;
            padding: 8px 12px;
            border-radius: 4px 4px 0 0;
            margin-bottom: 0;
        }
        
        .team-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .team-details {
            font-size: 8pt;
            opacity: 0.9;
        }
        
        .team-details span {
            margin-right: 15px;
        }
        
        /* Payments Table */
        .payments-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .payments-table thead {
            background: #f8f9fa;
        }
        
        .payments-table th {
            padding: 8px 10px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
            color: #495057;
            border: 1px solid #dee2e6;
            text-transform: uppercase;
        }
        
        .payments-table td {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            font-size: 8pt;
        }
        
        .payments-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .payments-table tbody tr:hover {
            background: #e9ecef;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .amount {
            font-weight: bold;
            color: #28a745;
        }
        
        .cuota-badge {
            display: inline-block;
            background: #2c5f8d;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 7pt;
            font-weight: bold;
        }
        
        /* Summary */
        .team-summary {
            background: #e7f3ff;
            padding: 6px 12px;
            border: 1px solid #2c5f8d;
            border-top: none;
            border-radius: 0 0 4px 4px;
            text-align: right;
            font-size: 9pt;
        }
        
        .team-summary strong {
            color: #2c5f8d;
        }
        
        /* Footer */
        .document-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 7pt;
            color: #6c757d;
        }
        
        /* No Payments Message */
        .no-payments {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-size: 10pt;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-banner">
        @if(isset($data['sportsSchool']))
            <div class="club-title">{{ strtoupper($data['sportsSchool']->name) }}</div>
            @if($data['sportsSchool']->address || $data['sportsSchool']->city)
                <div style="font-size: 8pt; color: #666666; margin-bottom: 3px;">
                    @if($data['sportsSchool']->address){{ $data['sportsSchool']->address }}@endif
                    @if($data['sportsSchool']->address && $data['sportsSchool']->city), @endif
                    @if($data['sportsSchool']->city){{ $data['sportsSchool']->city }}@endif
                    @if($data['sportsSchool']->postal_code) - {{ $data['sportsSchool']->postal_code }}@endif
                </div>
            @endif
            @if($data['sportsSchool']->phone || $data['sportsSchool']->email)
                <div style="font-size: 8pt; color: #666666; margin-bottom: 5px;">
                    @if($data['sportsSchool']->phone)Tel: {{ $data['sportsSchool']->phone }}@endif
                    @if($data['sportsSchool']->phone && $data['sportsSchool']->email) | @endif
                    @if($data['sportsSchool']->email)Email: {{ $data['sportsSchool']->email }}@endif
                </div>
            @endif
        @else
            <div class="club-title">VAEDSASS</div>
        @endif
        <div class="document-title">LISTADO DE PAGOS DE EQUIPOS</div>
        <div class="generation-date">Generado el: {{ isset($data['generatedDate']) ? $data['generatedDate'] : now()->format('d/m/Y H:i') }}</div>
    </div>

    @if(isset($data['teams']) && $data['teams']->count() > 0)
        @foreach($data['teams'] as $team)
            <div class="team-section">
                <!-- Team Header -->
                <div class="team-header">
                    <div class="team-name">{{ $team->team }}</div>
                    <div class="team-details">
                        <span><strong>Temporada:</strong> {{ $team->season->season ?? '-' }}</span>
                        <span><strong>Categoría:</strong> {{ $team->category->category ?? '-' }}</span>
                        <span><strong>Sección:</strong> {{ $team->section->name ?? '-' }}</span>
                        <span><strong>Precio Matrícula:</strong> {{ number_format($team->price, 2, ',', '.') }} €</span>
                    </div>
                </div>

                <!-- Payments Table -->
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10%;">Cuota</th>
                            <th style="width: 40%;">Descripción</th>
                            <th class="text-right" style="width: 15%;">Importe</th>
                            <th class="text-center" style="width: 17%;">Fecha Inicio</th>
                            <th class="text-center" style="width: 17%;">Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAmount = 0;
                        @endphp
                        @foreach($team->payments as $payment)
                            @php
                                $totalAmount += $payment->amount;
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="cuota-badge">{{ $payment->cuota }}</span>
                                </td>
                                <td>{{ $payment->description }}</td>
                                <td class="text-right amount">{{ number_format($payment->amount, 2, ',', '.') }} €</td>
                                <td class="text-center">{{ $payment->date_start->format('d/m/Y') }}</td>
                                <td class="text-center">{{ $payment->date_end->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Team Summary -->
                <div class="team-summary">
                    <strong>Total pagos:</strong> {{ $team->payments->count() }} 
                    <span style="margin-left: 20px;"><strong>Suma total:</strong> {{ number_format($totalAmount, 2, ',', '.') }} €</span>
                </div>
            </div>

            @if(!$loop->last)
                <div style="margin-bottom: 25px;"></div>
            @endif
        @endforeach

        <!-- Document Footer -->
        <div class="document-footer">
            <p>Este documento ha sido generado automáticamente por el sistema de gestión del club.</p>
            <p>Total de equipos con pagos: {{ $data['teams']->count() }}</p>
        </div>
    @else
        <div class="no-payments">
            <p>No hay equipos con pagos registrados para mostrar.</p>
        </div>
    @endif
</body>
</html>
