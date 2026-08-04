<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmación de inscripción</title>
</head>
@php
    $primary   = $school->primary_color   ?: '#0f172a';
    $secondary = $school->secondary_color ?: '#3b82f6';
    $logoUrl   = $school->logo ? asset('storage/' . $school->logo) : null;
    $schoolName = $school->name ?? config('app.name');
@endphp
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, {{ $primary }} 0%, {{ $secondary }} 100%); padding:32px 24px; text-align:center;">
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $schoolName }}" style="max-height:70px; max-width:180px; margin-bottom:16px; display:block; margin-left:auto; margin-right:auto;">
                            @endif
                            <h1 style="margin:0; color:#ffffff; font-size:24px; font-weight:700; line-height:1.3;">
                                ¡Inscripción confirmada!
                            </h1>
                            <p style="margin:8px 0 0 0; color:rgba(255,255,255,0.9); font-size:15px;">
                                {{ $schoolName }}
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px 32px 16px 32px;">
                            <p style="margin:0 0 16px 0; font-size:16px; line-height:1.5;">
                                Hola <strong>{{ $player->name }}</strong>,
                            </p>
                            <p style="margin:0 0 24px 0; font-size:15px; line-height:1.6; color:#374151;">
                                Tu inscripción en <strong>{{ $schoolName }}</strong> se ha registrado correctamente.
                                A continuación te resumimos los datos que hemos recibido:
                            </p>

                            {{-- Player summary card --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <h2 style="margin:0 0 12px 0; font-size:14px; text-transform:uppercase; letter-spacing:0.05em; color:{{ $primary }};">
                                            Datos del jugador
                                        </h2>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#374151;">
                                            <tr>
                                                <td style="padding:6px 0; color:#6b7280; width:40%;">Nombre</td>
                                                <td style="padding:6px 0; font-weight:600;">{{ $player->name }} {{ $player->surname }}</td>
                                            </tr>
                                            @if($player->dbirth)
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Fecha de nacimiento</td>
                                                    <td style="padding:6px 0; font-weight:600;">{{ \Carbon\Carbon::parse($player->dbirth)->format('d/m/Y') }}</td>
                                                </tr>
                                            @endif
                                            @if($player->dni)
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Documento</td>
                                                    <td style="padding:6px 0; font-weight:600;">{{ $player->dni }}</td>
                                                </tr>
                                            @endif
                                            @if($player->email)
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Email</td>
                                                    <td style="padding:6px 0; font-weight:600;">{{ $player->email }}</td>
                                                </tr>
                                            @endif
                                            @if($player->phone1)
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Teléfono</td>
                                                    <td style="padding:6px 0; font-weight:600;">{{ $player->phone1 }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if($season)
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:24px;">
                                    <tr>
                                        <td style="padding:20px;">
                                            <h2 style="margin:0 0 12px 0; font-size:14px; text-transform:uppercase; letter-spacing:0.05em; color:{{ $primary }};">
                                                Temporada
                                            </h2>
                                            <p style="margin:0; font-size:14px; color:#374151;">
                                                <strong>{{ $season->name ?? ($season->from_year . '/' . $season->to_year) }}</strong>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            @if(!empty($sections))
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:24px;">
                                    <tr>
                                        <td style="padding:20px;">
                                            <h2 style="margin:0 0 12px 0; font-size:14px; text-transform:uppercase; letter-spacing:0.05em; color:{{ $primary }};">
                                                Secciones inscritas
                                            </h2>
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#374151;">
                                                @foreach($sections as $section)
                                                    <tr>
                                                        <td style="padding:6px 0; border-bottom:1px solid #e5e7eb;">{{ $section['name'] }}</td>
                                                        {{-- <td style="padding:6px 0; border-bottom:1px solid #e5e7eb; text-align:right; font-weight:600;">
                                                            {{ number_format($section['price'] ?? 0, 2, ',', '.') }} €
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                                {{-- @if($totalPrice > 0)
                                                    <tr>
                                                        <td style="padding:12px 0 0 0; font-weight:700; color:{{ $primary }};">Total</td>
                                                        <td style="padding:12px 0 0 0; text-align:right; font-weight:700; color:{{ $primary }};">
                                                            {{ number_format($totalPrice, 2, ',', '.') }} €
                                                        </td>
                                                    </tr>
                                                @endif --}}
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <p style="margin:24px 0 8px 0; font-size:14px; line-height:1.6; color:#374151;">
                                Si detectas algún dato incorrecto o tienes cualquier duda,
                                ponte en contacto con nosotros respondiendo a este correo.
                            </p>
                            <p style="margin:16px 0 0 0; font-size:14px; color:#374151;">
                                Un saludo,<br>
                                <strong>{{ $schoolName }}</strong>
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#f9fafb; padding:20px 32px; text-align:center; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af; line-height:1.5;">
                                @if($school->address || $school->city)
                                    {{ trim(($school->address ?? '') . ' · ' . ($school->city ?? ''), ' ·') }}<br>
                                @endif
                                @if($school->phone)
                                    Tel. {{ $school->phone }}
                                    @if($school->email) · @endif
                                @endif
                                @if($school->email)
                                    {{ $school->email }}
                                @endif
                            </p>
                            <p style="margin:8px 0 0 0; font-size:11px; color:#9ca3af;">
                                Este mensaje ha sido enviado automáticamente. Por favor, no respondas si no es necesario.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
