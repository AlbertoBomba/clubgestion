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
    <title>Carta de Pago {{ $payment->code }}</title>
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
            background: #d97706;
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
            border-left: 4px solid #1e3a5f;
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
            color: #1e3a5f;
            text-align: right;
            white-space: nowrap;
        }

        .amount-detail {
            font-size: 9pt;
            color: #6b7280;
            text-align: right;
            margin-top: 4px;
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

        /* ============ PAYMENT METHODS ============ */
        .method {
            border: 1px solid #e5e7eb;
            border-left: 3px solid #1e3a5f;
            border-radius: 4px;
            padding: 12px 14px;
            margin-bottom: 10px;
            background: #ffffff;
        }

        .method-header {
            font-size: 10pt;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 6px;
        }

        .method-number {
            display: inline-block;
            background: #1e3a5f;
            color: #ffffff;
            width: 18px;
            height: 18px;
            line-height: 18px;
            text-align: center;
            border-radius: 50%;
            font-size: 8pt;
            margin-right: 6px;
        }

        .method-body {
            font-size: 9pt;
            color: #4b5563;
            line-height: 1.6;
        }

        .method-body a {
            color: #1e3a5f;
            text-decoration: none;
            font-weight: bold;
        }

        .method-body strong {
            color: #1f2937;
        }

        .method-fields {
            margin-top: 6px;
            padding: 8px 10px;
            background: #f8fafc;
            border-radius: 3px;
            font-size: 9pt;
        }

        .method-fields div {
            padding: 2px 0;
        }

        .code-highlight {
            display: inline-block;
            background: #1e3a5f;
            color: #ffffff;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* ============ NOTES ============ */
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

        .warning-note {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 3px solid #d97706;
            border-radius: 3px;
            padding: 8px 12px;
            margin-top: 8px;
            font-size: 8.5pt;
            color: #78350f;
            line-height: 1.5;
        }

        .warning-note strong {
            color: #92400e;
        }

        .warning-note a {
            color: #92400e;
            font-weight: bold;
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
                    <div class="doc-label">Código de pago</div>
                    <div class="doc-code">{{ $payment->code }}</div>
                    {{-- <div class="doc-date">{{ $generatedDate }}</div> --}}
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ TITLE + STATUS ============ --}}
    <div class="title-row">
        <table>
            <tr>
                <td>
                    <div class="title-main">Carta de pago</div>
                    <div class="title-sub">Instrucciones para el abono de la cuota</div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <span class="status-badge">PENDIENTE DE PAGO</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ============ AMOUNT ============ --}}
    <div class="amount-box">
        <table>
            <tr>
                <td>
                    <div class="amount-label">Importe a pagar</div>
                    <div class="amount-concept">Cuota {{ $payment->cuota }}</div>
                    @if($payment->paymentTeam)
                        <div style="font-size: 9pt; color: #6b7280; margin-top: 4px;">
                            Período: {{ \Carbon\Carbon::parse($payment->paymentTeam->date_start)->format('d/m/Y') }}
                            – {{ \Carbon\Carbon::parse($payment->paymentTeam->date_end)->format('d/m/Y') }}
                        </div>
                    @endif
                </td>
                <td>
                    <div class="amount-value">{{ number_format($payment->amount, 2, ',', '.') }} €</div>
                    @if($payment->amount_original && $payment->amount_original != $payment->amount)
                        <div class="amount-detail">
                            Original: {{ number_format($payment->amount_original, 2, ',', '.') }} € ·
                            Descuento: -{{ number_format($payment->amount_original - $payment->amount, 2, ',', '.') }} €
                        </div>
                    @endif
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
                        @if($player->dbirth)
                            <tr>
                                <td class="data-label">Edad</td>
                                <td class="data-value">{{ $player->dbirth->age }} años</td>
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
                            <td class="data-label">Código</td>
                            <td class="data-value">{{ $payment->code }}</td>
                        </tr>
                        <tr>
                            <td class="data-label">Cuota</td>
                            <td class="data-value">Nº {{ $payment->cuota }}</td>
                        </tr>
                        <tr>
                            <td class="data-label">Importe</td>
                            <td class="data-value">{{ number_format($payment->amount, 2, ',', '.') }} €</td>
                        </tr>
                        @if($payment->amount_original && $payment->amount_original != $payment->amount)
                            <tr>
                                <td class="data-label">Importe original</td>
                                <td class="data-value">{{ number_format($payment->amount_original, 2, ',', '.') }} €</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </td>
        </tr>
    </table>

    {{-- ============ PAYMENT METHODS ============ --}}
    <div class="section">
        <div class="section-title">Formas de pago disponibles</div>

        @php $methodIndex = 0; @endphp

        @if($sportsSchool && $sportsSchool->payments_enabled)
            @php $methodIndex++; @endphp
            <div class="method">
                <div class="method-header">
                    <span class="method-number">{{ $methodIndex }}</span> Tarjeta de crédito o débito
                </div>
                <div class="method-body">
                    Realice el pago de forma segura desde nuestra plataforma online.
                    <div class="method-fields">
                        <div><strong>Enlace de pago:</strong> <a href="https://{{ $sportsSchool->domain }}/search-pay" target="_blank">https://{{ $sportsSchool->domain }}/search-pay</a></div>
                        <div><strong>Código de pago:</strong> <span class="code-highlight">{{ $payment->code }}</span></div>
                    </div>
                </div>
            </div>
        @endif

        @if($sportsSchool && $sportsSchool->bank_account_enabled)
            @php $methodIndex++; @endphp
            <div class="method">
                <div class="method-header">
                    <span class="method-number">{{ $methodIndex }}</span> Transferencia bancaria
                </div>
                <div class="method-body">
                    Realice una transferencia con los siguientes datos:
                    <div class="method-fields">
                        <div><strong>Beneficiario:</strong> {{ $sportsSchool->name ?? 'Escuela Deportiva' }}</div>
                        <div><strong>IBAN:</strong> {{ wordwrap($sportsSchool->bank_account, 4, ' ', true) }}</div>
                        <div><strong>Concepto:</strong> Carta de pago {{ $payment->code }}</div>
                        <div><strong>Importe:</strong> {{ number_format($payment->amount, 2, ',', '.') }} €</div>
                    </div>
                    <div class="warning-note">
                        <strong>Importante:</strong> tras realizar la transferencia debe acceder a
                        <a href="https://{{ $sportsSchool->domain }}/search-pay" target="_blank">https://{{ $sportsSchool->domain }}/search-pay</a>,
                        seleccionar "transferencia bancaria" y adjuntar el justificante.
                        La verificación puede tardar hasta 7 días hábiles.
                    </div>
                </div>
            </div>
        @endif

        @php $methodIndex++; @endphp
        <div class="method">
            <div class="method-header">
                <span class="method-number">{{ $methodIndex }}</span> Efectivo
            </div>
            <div class="method-body">
                Puede abonar el importe en efectivo en las oficinas del club.
                <div class="method-fields">
                    <div><strong>Código de pago:</strong> <span class="code-highlight">{{ $payment->code }}</span></div>
                    {{-- @if($sportsSchool && $sportsSchool->address)
                        <div><strong>Dirección:</strong> {{ $sportsSchool->address }}</div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>

    {{-- ============ NOTE ============ --}}
    <div class="note">
        <strong>Conserve este documento como referencia.</strong><br>
        Indique siempre el código de pago <strong>{{ $payment->code }}</strong> al realizar el abono
        para poder identificar correctamente su transacción.
    </div>

    {{-- ============ FOOTER ============ --}}
    <div class="footer">
        Documento generado el {{ $generatedDate }}<br>
        @if($sportsSchool)
            {{ $sportsSchool->name }}
            @if($sportsSchool->phone) · Tel: {{ $sportsSchool->phone }}@endif
            @if($sportsSchool->email) · {{ $sportsSchool->email }}@endif
            <br>
        @endif
        <span class="brand">www.vaed.es</span> · Digitalización de escuelas deportivas
    </div>

</body>
</html>
