<!DOCTYPE html>
<html lang="es">
@php
    $payment = $data['payment'];
    $player = $data['player'];
    $sportsSchool = $data['sportsSchool'];
    $generatedDate = $data['generatedDate'];
@endphp
<head>
    <meta charset="UTF-8">
    <title>Carta de Pago - Cuota {{ $payment->cuota }}</title>
    <style>
        @page {
            margin: 12mm;
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
            line-height: 1.3;
        }
        
        /* Header Banner */
        .header-banner {
            background: #ffffff;
            padding: 8px 0;
            text-align: center;
            border-bottom: 3px solid #2c5f8d;
            margin-bottom: 12px;
        }
        
        .club-info {
            margin-bottom: 5px;
        }
        
        .club-title {
            font-size: 16pt;
            font-weight: bold;
            color: #2c5f8d;
            margin-bottom: 3px;
        }
        
        .club-details {
            font-size: 8pt;
            color: #666666;
            line-height: 1.2;
        }
        
        .document-title {
            font-size: 13pt;
            font-weight: bold;
            color: #333333;
            margin-top: 5px;
            margin-bottom: 2px;
        }
        
        .generation-date {
            font-size: 8pt;
            color: #666666;
        }
        
        /* Payment Code Box */
        .payment-code-box {
            background: #f0f7ff;
            border: 2px solid #2c5f8d;
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 12px;
            text-align: center;
        }
        
        .code-label {
            font-size: 9pt;
            color: #666666;
            margin-bottom: 3px;
        }
        
        .code-value {
            font-size: 18pt;
            font-weight: bold;
            color: #2c5f8d;
            letter-spacing: 1px;
        }
        
        /* Info Section */
        .info-section {
            margin-bottom: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 8px;
        }
        
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #2c5f8d;
            margin-bottom: 6px;
            border-bottom: 1px solid #2c5f8d;
            padding-bottom: 3px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
            margin-bottom: 4px;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #555555;
            padding: 2px 10px 2px 0;
            width: 35%;
            font-size: 9pt;
        }
        
        .info-value {
            display: table-cell;
            color: #333333;
            padding: 2px 0;
            font-size: 9pt;
        }
        
        /* Amount Box */
        .amount-box {
            background: #e8f5e9;
            border: 2px solid #4caf50;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
        
        .amount-label {
            font-size: 10pt;
            color: #666666;
            margin-bottom: 4px;
        }
        
        .amount-value {
            font-size: 24pt;
            font-weight: bold;
            color: #2e7d32;
        }
        
        .amount-detail {
            font-size: 8pt;
            color: #666666;
            margin-top: 4px;
            font-style: italic;
        }
        
        /* Payment Methods */
        .payment-methods {
            margin-top: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 8px;
        }
        
        .method-item {
            margin-bottom: 6px;
            padding: 6px;
            background: #fafafa;
            border-left: 3px solid #2c5f8d;
        }
        
        .method-item:last-child {
            margin-bottom: 0;
        }
        
        .method-title {
            font-weight: bold;
            color: #2c5f8d;
            font-size: 10pt;
            margin-bottom: 2px;
        }
        
        .method-description {
            font-size: 8pt;
            color: #555555;
            line-height: 1.3;
        }
        
        /* Footer */
        .footer {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 8pt;
            color: #666666;
        }
        
        .important-note {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 5px;
            padding: 6px;
            margin: 10px 0;
            font-size: 8pt;
            color: #856404;
        }
        
        .important-note strong {
            color: #856404;
        }
        
        .inline-text {
            font-size: 9pt;
            color: #333333;
            line-height: 1.4;
        }
        
        .inline-text strong {
            color: #2c5f8d;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-banner">
        @if($sportsSchool)
            <div class="club-info">
                <div class="club-title">{{ $sportsSchool->name }}</div>
                <div class="club-details">
                    @if($sportsSchool->address)
                        {{ $sportsSchool->address }}<br>
                    @endif
                    @if($sportsSchool->phone)
                        Teléfono: {{ $sportsSchool->phone }}
                    @endif
                    @if($sportsSchool->email)
                        - Email: {{ $sportsSchool->email }}
                    @endif
                </div>
            </div>
        @endif
        <div class="document-title">CARTA DE PAGO</div>
        <div class="generation-date">Generada el {{ $generatedDate }}</div>
    </div>

    <!-- Payment Code -->
    <div class="payment-code-box">
        <div class="code-label">Código de Pago</div>
        <div class="code-value">{{ $payment->code }}</div>
    </div>

    <!-- Player Information -->
    <div class="info-section">
        <div class="section-title">Datos del Jugador</div>
        <div class="inline-text">
            <strong>{{ $player->name }} {{ $player->surname }}</strong>
            @if($player->dni) | DNI: {{ $player->dni }} @endif
            @if($player->dbirth) | Edad: {{ $player->dbirth->age }} años @endif
            @if($player->phone1 || $player->phone2) | Tel: {{ $player->phone1 ?? $player->phone2 }} @endif
        </div>
    </div>

    <!-- Tutor Information -->
    @if($player->nametutor)
        <div class="info-section">
            <div class="section-title">Datos del Tutor</div>
            <div class="inline-text">
                <strong>{{ $player->nametutor }} {{ $player->surnametutor ?? '' }}</strong>
                @if($player->dnitutor) | DNI: {{ $player->dnitutor }} @endif
                @if($player->phonetutor) | Tel: {{ $player->phonetutor }} @endif
            </div>
        </div>
    @endif

    <!-- Payment Details -->
    <div class="info-section">
        <div class="section-title">Detalles del Pago</div>
        <div class="inline-text">
            <strong>Cuota {{ $payment->cuota }}</strong>
            @if($payment->paymentTeam)
                | Período: {{ \Carbon\Carbon::parse($payment->paymentTeam->date_start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payment->paymentTeam->date_end)->format('d/m/Y') }}
            @endif
            @if($payment->amount_original && $payment->amount_original != $payment->amount)
                | Importe original: {{ number_format($payment->amount_original, 2, ',', '.') }} €
                @if($payment->descEnt) | Desc. (€): -{{ number_format($payment->descEnt, 2, ',', '.') }} € @endif
                @if($payment->descPerc) | Desc. (%): {{ number_format($payment->descPerc, 2, ',', '.') }}% @endif
            @endif
        </div>
    </div>

    <!-- Amount to Pay -->
    <div class="amount-box">
        <div class="amount-label">Importe Total a Pagar</div>
        <div class="amount-value">{{ number_format($payment->amount, 2, ',', '.') }} €</div>
        @if($payment->amount_original && $payment->amount_original != $payment->amount)
            <div class="amount-detail">
                (Precio original: {{ number_format($payment->amount_original, 2, ',', '.') }} € 
                - Descuento: {{ number_format($payment->amount_original - $payment->amount, 2, ',', '.') }} €)
            </div>
        @endif
    </div>

    <!-- Important Note -->
    <div class="important-note">
        <strong>IMPORTANTE:</strong> Por favor, conserve esta carta de pago como comprobante. 
        Al realizar el pago, indique el código de pago mostrado arriba para facilitar la identificación de su transacción.
    </div>

    <!-- Payment Methods -->
    <div class="payment-methods">
        <div class="section-title">Formas de Pago Disponibles</div>
        
        <div class="method-item">
            <div class="method-title">💳 Tarjeta de Crédito/Débito</div>
            <div class="method-description">
                Puede realizar el pago con tarjeta de crédito o débito en nuestras oficinas o a través de la plataforma online.
                <br><strong>Código de pago:</strong> {{ $payment->code }}
            </div>
        </div>
        
        <div class="method-item">
            <div class="method-title">🏦 Transferencia Bancaria</div>
            <div class="method-description">
                Realice una transferencia bancaria indicando en el concepto el <strong>código de pago: {{ $payment->code }}</strong>
                @if($sportsSchool && $sportsSchool->iban)
                    <br><strong>IBAN:</strong> {{ $sportsSchool->iban }}
                @endif
                <br><strong>Beneficiario:</strong> {{ $sportsSchool->name ?? 'Escuela Deportiva' }}
            </div>
        </div>
        
        <div class="method-item">
            <div class="method-title">💵 Efectivo</div>
            <div class="method-description">
                Puede realizar el pago en efectivo en nuestras oficinas durante el horario de atención.
                <br><strong>Código de pago:</strong> {{ $payment->code }}
                @if($sportsSchool && $sportsSchool->address)
                    <br><strong>Dirección:</strong> {{ $sportsSchool->address }}
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Este documento ha sido generado automáticamente el {{ $generatedDate }}.<br>
        Para cualquier consulta o aclaración, póngase en contacto con nosotros.
        @if($sportsSchool)
            <br>
            @if($sportsSchool->phone)
                Teléfono: {{ $sportsSchool->phone }}
            @endif
            @if($sportsSchool->email)
                - Email: {{ $sportsSchool->email }}
            @endif
        @endif
    </div>
</body>
</html>
