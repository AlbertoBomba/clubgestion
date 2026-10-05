<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: dejavusans, sans-serif; color: #142d28; text-align: center; }
        .brand { border-top: 2mm solid {{ $primaryColor }}; padding-top: 2mm; }
        .school { font-size: 10pt; font-weight: bold; margin: 1mm 0 2mm; }
        .hero { background-color: #142d28; color: #ffffff; padding: 2mm 4mm; }
        .live { font-size: 9pt; font-weight: bold; letter-spacing: 2px; color: #a7f3d0; margin-bottom: 1mm; }
        h1 { font-size: 18pt; line-height: 1.1; margin: 0; }
        .callout { font-size: 16pt; font-weight: bold; margin: 2mm 0 1mm; }
        .caption { font-size: 9pt; color: #4b5563; margin: 0 0 2mm; }
        .qr-frame { border: 0.5mm solid {{ $primaryColor }}; padding: 1mm; background-color: #ffffff; }
        .qr { width: 190mm; height: 190mm; }
        .steps { width: 100%; margin-top: 2mm; border-collapse: collapse; }
        .steps td { width: 33.33%; font-size: 9pt; text-align: center; padding: 1mm; background-color: #f0f5f3; }
        .step-number { font-weight: bold; color: #142d28; }
        .url { font-size: 9pt; color: #374151; word-wrap: break-word; margin: 2mm 0 0; }
        .url a { color: #374151; text-decoration: none; }
    </style>
</head>
<body>
    <div class="brand">
        @if ($clubLogo)
            <img src="{{ $clubLogo }}" style="width: {{ $logoWidth }}mm; height: {{ $logoHeight }}mm;" alt="Logo de {{ $school->name }}"/>
        @endif
        <div class="school">{{ $school->name }}</div>
    </div>
    <div class="hero">
        <div class="live">TORNEO EN DIRECTO</div>
        <h1>{{ $tournament->name }}</h1>
    </div>
    <p class="callout">¡Escanea y vive el torneo!</p>
    <p class="caption">Partidos y resultados en directo desde tu móvil</p>
    <div class="qr-frame">
        <img class="qr" src="{{ $qrImage }}" alt="QR del torneo en directo"/>
    </div>
    <table class="steps">
        <tr>
            <td><span class="step-number">1.</span> Abre la cámara</td>
            <td><span class="step-number">2.</span> Escanea el QR</td>
            <td><span class="step-number">3.</span> Sigue el torneo</td>
        </tr>
    </table>
    <p class="url">Servicio prestado por vaed.es. Digitalización de escuelas deportivas.</p>
</body>
</html>
