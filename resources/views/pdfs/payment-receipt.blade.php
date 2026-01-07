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
    <title>Recibo de Pago - Cuota {{ $payment->cuota }}</title>
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
            font-size: 10pt;
            color: #333333;
            background: #ffffff;
            line-height: 1.4;
        }
        
        /* Header Banner */
        .header-banner {
            background: linear-gradient(to right, #2c5f8d, #4a7ba7);
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .club-title {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .club-details {
            font-size: 9pt;
            line-height: 1.3;
        }
        
        .document-title {
            font-size: 20pt;
            font-weight: bold;
            color: #2c5f8d;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border: 3px solid #2c5f8d;
            border-radius: 8px;
            background: #f0f7ff;
        }
        
        /* Receipt Info Box */
        .receipt-info {
            background: #e8f5e9;
            border: 3px solid #4caf50;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .receipt-number {
            font-size: 11pt;
            color: #666666;
            margin-bottom: 5px;
        }
        
        .receipt-code {
            font-size: 20pt;
            font-weight: bold;
            color: #2e7d32;
            letter-spacing: 2px;
        }
        
        .paid-stamp {
            background: #4caf50;
            color: white;
            font-size: 24pt;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin: 15px 0;
            transform: rotate(-5deg);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        /* Info Sections */
        .info-section {
            margin-bottom: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            background: #fafafa;
        }
        
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2c5f8d;
            margin-bottom: 8px;
            border-bottom: 2px solid #2c5f8d;
            padding-bottom: 4px;
        }
        
        .info-row {
            margin-bottom: 6px;
            padding: 4px 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #555555;
            display: inline-block;
            width: 40%;
        }
        
        .info-value {
            color: #333333;
            display: inline-block;
        }
        
        /* Amount Box */
        .amount-paid-box {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            border: 3px solid #2e7d32;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .amount-label {
            font-size: 12pt;
            color: white;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .amount-value {
            font-size: 32pt;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        /* Payment Details */
        .payment-details {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 12px;
            margin: 15px 0;
        }
        
        .payment-details-title {
            font-size: 12pt;
            font-weight: bold;
            color: #856404;
            margin-bottom: 8px;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #2c5f8d;
            text-align: center;
        }
        
        .signature-line {
            margin-top: 40px;
            padding-top: 2px;
            border-top: 2px solid #333333;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            font-size: 9pt;
            color: #666666;
        }
        
        .validity-note {
            background: #e3f2fd;
            border: 2px solid #2196f3;
            border-radius: 8px;
            padding: 10px;
            margin: 20px 0;
            font-size: 9pt;
            text-align: center;
            color: #0d47a1;
        }
        
        .validity-note strong {
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-banner">
        @if($sportsSchool)
            <div class="club-title">{{ $sportsSchool->name }}</div>
            <div class="club-details">
                @if($sportsSchool->address)
                    {{ $sportsSchool->address }}<br>
                @endif
                @if($sportsSchool->phone)
                    Teléfono: {{ $sportsSchool->phone }}
                @endif
                @if($sportsSchool->email)
                    | Email: {{ $sportsSchool->email }}
                @endif
            </div>
        @endif
    </div>

    <!-- Document Title -->
    <div class="document-title">RECIBO DE PAGO</div>

    <!-- Paid Stamp -->
    <div class="paid-stamp">✓ PAGADO</div>

    <!-- Receipt Info -->
    <div class="receipt-info">
        <div class="receipt-number">Código de Recibo</div>
        <div class="receipt-code">{{ $payment->code }}</div>
    </div>

    <!-- Player Information -->
    <div class="info-section">
        <div class="section-title">Datos del Jugador</div>
        <div class="info-row">
            <span class="info-label">Nombre completo:</span>
            <span class="info-value">{{ $player->name }} {{ $player->surname }}</span>
        </div>
        @if($player->dni)
            <div class="info-row">
                <span class="info-label">DNI:</span>
                <span class="info-value">{{ $player->dni }}</span>
            </div>
        @endif
        @if($player->phone1 || $player->phone2)
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $player->phone1 ?? $player->phone2 }}</span>
            </div>
        @endif
    </div>

    <!-- Payment Details -->
    <div class="info-section">
        <div class="section-title">Detalles del Pago</div>
        <div class="info-row">
            <span class="info-label">Concepto:</span>
            <span class="info-value">Cuota número {{ $payment->cuota }}</span>
        </div>
        @if($payment->paymentTeam)
            <div class="info-row">
                <span class="info-label">Período:</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($payment->paymentTeam->date_start)->format('d/m/Y') }} 
                    - 
                    {{ \Carbon\Carbon::parse($payment->paymentTeam->date_end)->format('d/m/Y') }}
                </span>
            </div>
        @endif
        @if($payment->amount_original && $payment->amount_original != $payment->amount)
            <div class="info-row">
                <span class="info-label">Importe original:</span>
                <span class="info-value">{{ number_format($payment->amount_original, 2, ',', '.') }} €</span>
            </div>
            <div class="info-row">
                <span class="info-label">Descuento aplicado:</span>
                <span class="info-value">-{{ number_format($payment->amount_original - $payment->amount, 2, ',', '.') }} €</span>
            </div>
        @endif
    </div>

    <!-- Amount Paid -->
    <div class="amount-paid-box">
        <div class="amount-label">IMPORTE PAGADO</div>
        <div class="amount-value">{{ number_format($payment->amount, 2, ',', '.') }} €</div>
    </div>

    <!-- Payment Transaction Details -->
    <div class="payment-details">
        <div class="payment-details-title">Información de la Transacción</div>
        <div class="info-row">
            <span class="info-label">Fecha de pago:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}</span>
        </div>
        @if($payment->payment_type)
            <div class="info-row">
                <span class="info-label">Método de pago:</span>
                <span class="info-value">{{ ucfirst($payment->payment_type) }}</span>
            </div>
        @endif
        @if($payment->payment_auth)
            <div class="info-row">
                <span class="info-label">Número de autorización:</span>
                <span class="info-value">{{ $payment->payment_auth }}</span>
            </div>
        @endif
    </div>

    <!-- Validity Note -->
    <div class="validity-note">
        <strong>DOCUMENTO VÁLIDO</strong><br>
        Este recibo certifica que el pago ha sido recibido y procesado correctamente.<br>
        Conserve este documento como justificante de pago.
    </div>

    <!-- Footer -->
    <div class="footer">
        <p style="font-size: 9pt; color: #666666; margin-bottom: 10px;">
            Recibo generado el {{ $generatedDate }}
        </p>
        
        <div class="signature-line">
            Firma autorizada
        </div>
        
        @if($sportsSchool)
            <p style="font-size: 8pt; color: #888888; margin-top: 20px;">
                {{ $sportsSchool->name }}
                @if($sportsSchool->address)
                    <br>{{ $sportsSchool->address }}
                @endif
                @if($sportsSchool->phone)
                    <br>Tel: {{ $sportsSchool->phone }}
                @endif
            </p>
        @endif
    </div>
</body>
</html>
