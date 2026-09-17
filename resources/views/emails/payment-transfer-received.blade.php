<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Justificante recibido</title>
</head>
@php
    $primary    = $school->primary_color   ?: '#0f172a';
    $secondary  = $school->secondary_color ?: '#f59e0b';
    $logoUrl    = $school->logo ? asset('storage/' . $school->logo) : null;
    $schoolName = $school->name ?? config('app.name');
    $player     = $payment->player;
    $amount     = number_format((float) $payment->amount, 2, ',', '.');
    $notifiedAt = $payment->dtnotification ? \Carbon\Carbon::parse($payment->dtnotification)->format('d/m/Y H:i') : now()->format('d/m/Y H:i');
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
                            <div style="display:inline-block; width:56px; height:56px; border-radius:50%; background-color:rgba(255,255,255,0.2); line-height:56px; font-size:28px; color:#ffffff; margin-bottom:12px;">⏳</div>
                            <h1 style="margin:0; color:#ffffff; font-size:22px; font-weight:700; line-height:1.3;">
                                Justificante recibido
                            </h1>
                            <p style="margin:8px 0 0 0; color:rgba(255,255,255,0.9); font-size:14px;">
                                {{ $schoolName }}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px 32px 16px 32px;">
                            <p style="margin:0 0 16px 0; font-size:16px; line-height:1.5;">
                                Hola{{ $player ? ' <strong>' . $player->name . '</strong>' : '' }},
                            </p>
                            <p style="margin:0 0 20px 0; font-size:15px; line-height:1.6; color:#374151;">
                                Hemos recibido tu justificante de transferencia y el pago está <strong>en estudio</strong>. En los próximos días revisaremos la operación y te confirmaremos por correo si el pago es correcto.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb; border:1px solid #fde68a; border-radius:8px; margin:16px 0;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#92400e; font-weight:600;">Estado</div>
                                        <div style="font-size:16px; font-weight:700; color:#92400e; margin-top:4px;">⏳ Pendiente de validar</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 12px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Referencia</div>
                                        <div style="font-size:15px; color:#111827; margin-top:4px;">{{ $payment->code }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 12px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Concepto</div>
                                        <div style="font-size:15px; color:#111827; margin-top:4px;">Cuota {{ $payment->cuota }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 12px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Justificante enviado</div>
                                        <div style="font-size:15px; color:#111827; margin-top:4px;">{{ $notifiedAt }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 20px 16px 20px;">
                                        <div style="font-size:12px; text-transform:uppercase; letter-spacing:1px; color:#6b7280; font-weight:600;">Importe</div>
                                        <div style="font-size:26px; font-weight:800; color:{{ $secondary }}; margin-top:4px;">{{ $amount }} €</div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:20px 0 0 0; font-size:13px; line-height:1.6; color:#6b7280;">
                                No es necesario que hagas nada más. Si detectamos alguna incidencia con la transferencia, nos pondremos en contacto contigo respondiendo a este correo.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 32px 28px 32px; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af; text-align:center;">
                                Este correo se ha generado automáticamente desde el portal de {{ $schoolName }}.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
