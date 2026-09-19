<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Recaudación y Cuotas por Equipo</title>
    <style>
        @page {
            margin: 12mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8.5pt;
            color: #1e293b;
            background: #ffffff;
            line-height: 1.3;
        }

        /* Utilidades */
        .w-full { width: 100%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* Header Principal */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .school-name {
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
        }

        .school-info {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 2px;
        }

        .doc-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
        }

        .doc-date {
            font-size: 7.5pt;
            color: #64748b;
            text-align: right;
            margin-top: 2px;
        }

        /* Resumen Global */
        .global-summary {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .global-summary-box {
            padding: 8px 10px;
            border-radius: 6px;
            text-align: center;
        }

        .bg-recaudado { background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .bg-pendiente { background-color: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
        .bg-total { background-color: #f1f5f9; border: 1px solid #e2e8f0; color: #1e293b; }

        .summary-label {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .summary-amount {
            font-size: 11pt;
            font-weight: bold;
        }

        /* Seccion de Equipo */
        .team-card {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }

        .team-header-table {
            width: 100%;
            background-color: #1e3a8a;
            color: #ffffff;
            border-radius: 6px 6px 0 0;
            padding: 6px 10px;
        }

        .team-title {
            font-size: 10.5pt;
            font-weight: bold;
        }

        .team-meta {
            font-size: 7.5pt;
            color: #cbd5e1;
            margin-top: 1px;
        }

        /* Tabla de Pagos */
        .payments-table {
            width: 100%;
            border-collapse: collapse;
            border-left: 1px solid #cbd5e1;
            border-right: 1px solid #cbd5e1;
        }

        .payments-table th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 8px;
            border-bottom: 1px solid #cbd5e1;
            border-top: 1px solid #cbd5e1;
        }

        .payments-table td {
            padding: 5px 8px;
            font-size: 8pt;
            border-bottom: 1px solid #f1f5f9;
        }

        .payments-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .cuota-pill {
            background-color: #1e3a8a;
            color: #ffffff;
            font-size: 7pt;
            font-weight: bold;
            padding: 1px 6px;
            border-radius: 8px;
        }

        .text-green { color: #15803d; font-weight: bold; }
        .text-amber { color: #b45309; font-weight: bold; }

        /* Barra de Resumen Inferior del Equipo */
        .team-footer-table {
            width: 100%;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-top: 1px solid #cbd5e1;
            border-radius: 0 0 6px 6px;
            padding: 5px 10px;
            font-size: 8pt;
        }

        /* Footer del Documento */
        .document-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    @php
        // Cálculo Global de Totales para la Cabecera del Documento
        $grandRecaudado = 0;
        $grandPendiente = 0;
        $grandPotencial = 0;

        if(isset($data['teams'])) {
            foreach($data['teams'] as $t) {
                foreach($t->payments as $p) {
                    $paidCount = $p->paymentPlayers->where('state', 1)->count();
                    $totalCount = $p->paymentPlayers->count();
                    
                    $grandRecaudado += ($paidCount * $p->amount);
                    $grandPendiente += (($totalCount - $paidCount) * $p->amount);
                    $grandPotencial += ($totalCount * $p->amount);
                }
            }
        }
    @endphp

    <!-- Cabecera del Documento -->
    <table class="header-table">
        <tr>
            <td class="text-left" style="width: 55%;">
                @if(isset($data['sportsSchool']))
                    <div class="school-name">{{ strtoupper($data['sportsSchool']->name) }}</div>
                    <div class="school-info">
                        @if($data['sportsSchool']->address){{ $data['sportsSchool']->address }}@endif
                        @if($data['sportsSchool']->city), {{ $data['sportsSchool']->city }}@endif
                        @if($data['sportsSchool']->phone) | Tel: {{ $data['sportsSchool']->phone }}@endif
                    </div>
                @else
                    <div class="school-name">ESCUELA DEPORTIVA</div>
                @endif
            </td>
            <td class="text-right" style="width: 45%;">
                <div class="doc-title">RECAUDACIÓN Y CUOTAS</div>
                <div class="doc-date">Fecha de emisión: {{ $data['generatedDate'] ?? now()->format('d/m/Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <!-- Resumen General Global (KPIs) -->
    <table class="global-summary">
        <tr>
            <td style="width: 32%; padding-right: 1%;">
                <div class="global-summary-box bg-recaudado">
                    <div class="summary-label">Total Recaudado</div>
                    <div class="summary-amount">{{ number_format($grandRecaudado, 2, ',', '.') }} €</div>
                </div>
            </td>
            <td style="width: 32%; padding-left: 0.5%; padding-right: 0.5%;">
                <div class="global-summary-box bg-pendiente">
                    <div class="summary-label">Total Pendiente</div>
                    <div class="summary-amount">{{ number_format($grandPendiente, 2, ',', '.') }} €</div>
                </div>
            </td>
            <td style="width: 34%; padding-left: 1%;">
                <div class="global-summary-box bg-total">
                    <div class="summary-label">Proyección Total</div>
                    <div class="summary-amount">{{ number_format($grandPotencial, 2, ',', '.') }} €</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Listado por Equipos -->
    @if(isset($data['teams']) && $data['teams']->count() > 0)
        @foreach($data['teams'] as $team)
            @php
                // Cálculo financiero específico para este equipo
                $teamRecaudado = 0;
                $teamPendiente = 0;
                $teamPotencial = 0;

                foreach($team->payments as $payment) {
                    $paidPlayers = $payment->paymentPlayers->where('state', 1)->count();
                    $totalPlayers = $payment->paymentPlayers->count();
                    
                    $teamRecaudado += ($paidPlayers * $payment->amount);
                    $teamPendiente += (($totalPlayers - $paidPlayers) * $payment->amount);
                    $teamPotencial += ($totalPlayers * $payment->amount);
                }

                $porcentajeCobro = $teamPotencial > 0 ? round(($teamRecaudado / $teamPotencial) * 100) : 0;
            @endphp

            <div class="team-card">
                <!-- Encabezado del Equipo -->
                <table class="team-header-table">
                    <tr>
                        <td class="text-left">
                            <div class="team-title">{{ strtoupper($team->team) }}</div>
                            <div class="team-meta">
                                Categoría: <strong>{{ $team->category->category ?? '-' }}</strong> | 
                                Sección: <strong>{{ $team->section->name ?? '-' }}</strong> | 
                                Temporada: <strong>{{ $team->season->season ?? '-' }}</strong>
                            </div>
                        </td>
                        <td class="text-right" style="vertical-align: middle;">
                            <span style="font-size: 8pt; background: rgba(255,255,255,0.2); padding: 3px 8px; border-radius: 4px;">
                                Matrícula: <strong>{{ number_format($team->price, 2, ',', '.') }} €</strong>
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Tabla de Cuotas del Equipo -->
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 8%;">Cuota</th>
                            <th class="text-left" style="width: 32%;">Descripción</th>
                            <th class="text-center" style="width: 20%;">Período de Pago</th>
                            <th class="text-center" style="width: 12%;">Jugadores</th>
                            <th class="text-right" style="width: 12%;">Recaudado</th>
                            <th class="text-right" style="width: 16%;">Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($team->payments as $payment)
                            @php
                                $pPaid = $payment->paymentPlayers->where('state', 1)->count();
                                $pTotal = $payment->paymentPlayers->count();
                                $pRecaudado = $pPaid * $payment->amount;
                                $pPendiente = ($pTotal - $pPaid) * $payment->amount;
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="cuota-badge">{{ $payment->cuota }}</span>
                                </td>
                                <td>
                                    <strong>{{ $payment->description }}</strong>
                                    <span style="font-size: 7pt; color: #64748b; display: block;">
                                        ({{ number_format($payment->amount, 2, ',', '.') }} €/cuota)
                                    </span>
                                </td>
                                <td class="text-center" style="font-size: 7.5pt; color: #475569;">
                                    {{ $payment->date_start->format('d/m/Y') }} al {{ $payment->date_end->format('d/m/Y') }}
                                </td>
                                <td class="text-center font-bold">
                                    <span class="text-green">{{ $pPaid }}</span> / <span style="color: #64748b;">{{ $pTotal }}</span>
                                </td>
                                <td class="text-right text-green">
                                    {{ number_format($pRecaudado, 2, ',', '.') }} €
                                </td>
                                <td class="text-right text-amber">
                                    {{ number_format($pPendiente, 2, ',', '.') }} €
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 12px; color: #94a3b8;">
                                    Este equipo no tiene cuotas configuradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Resumen Financiero del Equipo -->
                <table class="team-footer-table">
                    <tr>
                        <td class="text-left" style="width: 40%;">
                            Progreso de Cobro: <strong>{{ $porcentajeCobro }}%</strong>
                        </td>
                        <td class="text-right" style="width: 60%;">
                            Recaudado: <span class="text-green">{{ number_format($teamRecaudado, 2, ',', '.') }} €</span> | 
                            Pendiente: <span class="text-amber">{{ number_format($teamPendiente, 2, ',', '.') }} €</span> | 
                            Total: <strong>{{ number_format($teamPotencial, 2, ',', '.') }} €</strong>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach

        <!-- Pie de página -->
        <div class="document-footer">
            Documento informativo de gestión interna • Generado por VAED Digitalización Deportiva
        </div>
    @else
        <div class="no-payments">
            <p>No se encontraron datos de cuotas de equipos para los filtros seleccionados.</p>
        </div>
    @endif

</body>
</html>