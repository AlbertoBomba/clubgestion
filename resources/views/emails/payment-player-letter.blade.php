<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carta de pago</title>
</head>
@php
    $primary    = $school->primary_color   ?: '#0f172a';
    $secondary  = $school->secondary_color ?: '#3b82f6';
    $logoUrl    = $school->logo ? asset('storage/' . $school->logo) : null;
    $schoolName = $school->name ?? config('app.name');
    $player     = $payment->player;
    $paymentTeam = $payment->paymentTeam;
    $amount     = number_format((float) $payment->amount, 2, ',', '.');
@endphp
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="background: linear-gradient(135deg, {{ $primary }} 0%, {{ $secondary }} 100%); padding:32px 24px; text-align:center;">
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $schoolName }}" style="max-height:70px; max-width:180px; margin-bottom:16px; display:block; margin-left:auto; margin-right:auto;">
                            @endif
                            <h1 style="margin:0; color:#ffffff; font-size:22px; font-weight:700; line-height:1.3;">
                                Tu carta de pago
                            </h1>
                            <p style="margin:8px 0 0 0; color:rgba(255,255,255,0.9); font-size:14px;">
                                {{ $schoolName }}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px 32px 16px 32px;">
                            <p style="margin:0 0 16px 0; font-size:16px; line-height:1.5;">
                                Hola{{ $player ? ' ' . $player->name . ' ' : '' }},
                            </p>
                            <p style="margin:0 0 20px 0; font-size:15px; line-height:1.6; color:#374151;">
                                Te adjuntamos la carta de pago. Puedes abonarla usando el código de referencia que aparece a continuación desde nuestro portal de pagos.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin:16px 0;">
                                <tr>
                                    <td style="padding:0 20px 16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Jugador</div>
                                        <div style="font-size:15px; color:#111827; margin-top:4px;"> {{ $player ? $player->name . ' ' . $player->surname : '' }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Código de referencia</div>
                                        <div style="font-size:22px; font-weight:800; color:{{ $primary }}; letter-spacing:2px; margin-top:4px;">{{ $payment->code }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Importe</div>
                                        <div style="font-size:26px; font-weight:800; color:{{ $secondary }}; margin-top:4px;">{{ $amount }} €</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Concepto</div>
                                        <div style="font-size:15px; color:#111827; margin-top:4px;">Cuota {{ $payment->cuota }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Periodo de pago legal</div>
                                        <div style="font-size:15px; color:#111827; margin-top:4px;"> Período: {{ \Carbon\Carbon::parse($payment->paymentTeam->date_start)->format('d/m/Y') }}
                                            – {{ \Carbon\Carbon::parse($payment->paymentTeam->date_end)->format('d/m/Y') }}</div>
                                    </td>
                                    {{-- <td style="padding:0 20px 16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Periodo de pago legal</div>
                                        <div style="font-size:26px; font-weight:800; color:{{ $secondary }}; margin-top:4px;">
                                            Período: {{ \Carbon\Carbon::parse($payment->paymentTeam->date_start)->format('d/m/Y') }}
                                            – {{ \Carbon\Carbon::parse($payment->paymentTeam->date_end)->format('d/m/Y') }}
                                        </div>
                                    </td> --}}
                                </tr>
                            </table>

                            <div style="text-align:center; margin:28px 0 12px 0;">
                                <a href="{{ 'https://'.$school->domain.'/search-pay' }}"
                                   style="display:inline-block; background-color:{{ $secondary }}; color:#ffffff; text-decoration:none; padding:14px 28px; border-radius:10px; font-weight:700; font-size:15px;">
                                    Ir al portal de pago
                                </a>
                            </div>
                            <p style="margin:24px 0 0 0; font-size:13px; line-height:1.6; color:#6b7280;">
                               Para cualquier duda contacta con {{ $school->email }}.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 32px 28px 32px; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af; text-align:center;">
                                Este mensaje ha sido enviado automáticamente. Por favor, no respondas.
                                {{-- Este correo se ha enviado desde el portal público de {{ $schoolName }}. No respondas directamente a este correo. --}}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
