@php
    $payment = $data['payment'];
    $player = $data['player'];
    $sportsSchool = $data['sportsSchool'];
    $generatedDate = $data['generatedDate'];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago {{ $payment->code }}</title>
    <style>
        @page {
            margin: 18mm 16mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            color: #1f2937;
            background: #ffffff;
            line-height: 1.5;
        }

        /* ============ HEADER ============ */
        .header {
            width: 100%;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-club {
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 4px;
        }

        .header-info {
            font-size: 9pt;
            color: #6b7280;
            line-height: 1.4;
        }

        .header-right {
            text-align: right;
            vertical-align: top;
        }

        .doc-label {
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .doc-code {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 6px;
        }

        .doc-date {
            font-size: 9pt;
            color: #4b5563;
        }

        /* ============ TITLE ============ */
        .title-row {
            margin-bottom: 22px;
        }

        .title-row table {
            width: 100%;
            border-collapse: collapse;
        }

        .title-main {
            font-size: 22pt;
            font-weight: bold;
            color: #1f2937;
            letter-spacing: -0.5px;
        }

        .title-sub {
            font-size: 10pt;
            color: #6b7280;
            margin-top: 2px;
        }

        .status-badge {
            display: inline-block;
            background: #059669;
            color: #ffffff;
            font-size: 10pt;
            font-weight: bold;
            padding: 6px 16px;
            border-radius: 4px;
            letter-spacing: 1px;
        }

        /* ============ AMOUNT SUMMARY ============ */
        .amount-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #059669;
            padding: 18px 22px;
            margin-bottom: 24px;
        }

        .amount-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .amount-label {
            font-size: 10pt;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .amount-concept {
            font-size: 12pt;
            color: #1f2937;
            font-weight: bold;
        }

        .amount-value {
            font-size: 26pt;
            font-weight: bold;
            color: #059669;
            text-align: right;
            white-space: nowrap;
        }

        /* ============ SECTIONS ============ */
        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #1e3a5f;
            padding-bottom: 6px;
            border-bottom: 1px solid #d1d5db;
            margin-bottom: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 7px 0;
            vertical-align: top;
            border-bottom: 1px solid #f3f4f6;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-label {
            font-size: 9pt;
            color: #6b7280;
            width: 38%;
        }

        .data-value {
            font-size: 10pt;
            color: #1f2937;
            font-weight: bold;
        }

        /* ============ TWO COLUMNS ============ */
        .two-col {
            width: 100%;
            border-collapse: collapse;
        }

        .two-col > tbody > tr > td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .two-col > tbody > tr > td:first-child {
            padding-right: 12px;
        }

        .two-col > tbody > tr > td:last-child {
            padding-left: 12px;
        }

        /* ============ VALIDITY NOTE ============ */
        .note {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 12px 16px;
            margin-top: 22px;
            font-size: 9pt;
            color: #4b5563;
            line-height: 1.5;
        }

        .note strong {
            color: #1f2937;
        }

        /* ============ FOOTER ============ */
        .footer {
            margin-top: 32px;
            padding-top: 14px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 8pt;
            color: #9ca3af;
            line-height: 1.5;
        }

        .footer .brand {
            color: #6b7280;
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- ============ HEADER ============ --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    @if($sportsSchool)
                        <div class="header-club">{{ $sportsSchool->name }}</div>
                        <div class="header-info">
                            @if($sportsSchool->address){{ $sportsSchool->address }}<br>@endif
                            @if($sportsSchool->phone)Tel: {{ $sportsSchool->phone }}@endif
                            @if($sportsSchool->email) &nbsp;·&nbsp; {{ $sportsSchool->email }}@endif
                        </div>
                    @endif
                </td>
                <td class="header-right">
                    <div class="doc-label">Nº Recibo</div>
                    <div class="doc-code">{{ $payment->code }}</div>
                    <div class="doc-date">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ TITLE + STATUS ============ --}}
    <div class="title-row">
        <table>
            <tr>
                <td>
                    <div class="title-main">Recibo de pago</div>
                    <div class="title-sub">Justificante de cuota abonada</div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <span class="status-badge">PAGADO</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ AMOUNT ============ --}}
    <div class="amount-box">
        <table>
            <tr>
                <td>
                    <div class="amount-label">Importe abonado</div>
                    <div class="amount-concept">Cuota {{ $payment->cuota }}</div>
                    <div class="amount-concept">Sección {{ $payment->paymentTeam->team->section->name ?? '' }}</div>
                </td>
                <td class="amount-value">
                    {{ number_format($payment->amount, 2, ',', '.') }} €
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ TWO COLUMN INFO ============ --}}
    <table class="two-col">
        <tr>
            <td>
                <div class="section">
                    <div class="section-title">Datos del jugador</div>
                    <table class="data-table">
                        <tr>
                            <td class="data-label">Nombre</td>
                            <td class="data-value">{{ $player->name }} {{ $player->surname }}</td>
                        </tr>
                        @if($player->dni)
                            <tr>
                                <td class="data-label">DNI</td>
                                <td class="data-value">{{ $player->dni }}</td>
                            </tr>
                        @endif
                        @if($player->phone1 || $player->phone2)
                            <tr>
                                <td class="data-label">Teléfono</td>
                                <td class="data-value">{{ $player->phone1 ?? $player->phone2 }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </td>
            <td>
                <div class="section">
                    <div class="section-title">Detalles del pago</div>
                    <table class="data-table">
                        <tr>
                            <td class="data-label">Fecha</td>
                            <td class="data-value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="data-label">Cuota</td>
                            <td class="data-value">Nº {{ $payment->cuota }}</td>
                        </tr>
                        @if($payment->payment_type)
                            <tr>
                                <td class="data-label">Método</td>
                                <td class="data-value">{{ ucfirst($payment->payment_type) }}</td>
                            </tr>
                        @endif
                        @if($payment->payment_auth)
                            <tr>
                                <td class="data-label">Nº autorización</td>
                                <td class="data-value">{{ $payment->payment_auth }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </td>
        </tr>
    </table>

    {{-- ============ NOTE ============ --}}
    <div class="note">
        <strong>Documento válido como justificante de pago.</strong><br>
        Este recibo certifica que el importe indicado ha sido recibido y procesado correctamente.
        Le recomendamos conservarlo para cualquier consulta futura.
    </div>

    {{-- ============ FOOTER ============ --}}
    <div class="footer">
        Documento generado el {{ $generatedDate }}<br>
        @if($sportsSchool)
            {{ $sportsSchool->name }}
            @if($sportsSchool->address) · {{ $sportsSchool->address }}@endif
            @if($sportsSchool->phone) · Tel: {{ $sportsSchool->phone }}@endif
            <br>
        @endif
        <span class="brand">www.vaed.es</span> · Digitalización de escuelas deportivas
    </div>

</body>
</html>
