<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro y Mandato SEPA</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f8; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Contenedor Principal -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);">
                    
                    <!-- Cabecera -->
                    <tr>
                        <td align="center" style="background-color: #1e293b; padding: 30px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; tracking-tight: tight;">
                                Suscripción {{ $memberType->name }} / {{ $school->name ?? '' }} Confirmada
                            </h1>
                            <p style="color: #94a3b8; margin: 5px 0 0 0; font-size: 14px;">
                                Copia de tu Orden de Domiciliación Directa SEPA
                            </p>
                        </td>
                    </tr>

                    <!-- Cuerpo -->
                    <tr>
                        <td style="padding: 30px 40px; color: #334155; line-height: 1.6;">
                            <p style="font-size: 16px; margin-top: 0;">
                                Hola <strong>{{ $member->name }}</strong>,
                            </p>
                            <p style="font-size: 14px; color: #64748b;">
                                Gracias por completar tu suscripción {{ $memberType->name }}. A continuación se detallan los datos registrados y la información legal correspondiente a tu autorización de cobro.
                            </p>

                            <!-- Tarjeta Datos del Mandato SEPA -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin: 25px 0; padding: 20px;">
                                <tr>
                                    <td colspan="2" style="border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 10px;">
                                        <strong style="color: #0f172a; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Detalles de la Orden de Domiciliación (Mandato SEPA)
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b; width: 40%;"><strong>Cuota anual:</strong></td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a; font-weight: bold;">{{ $memberType->price }} €</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b; width: 40%;"><strong>Referencia Mandato:</strong></td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a; font-weight: bold;">{{ $member->sepa_mandate_ref }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;"><strong>Fecha de Aceptación:</strong></td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $member->sepa_mandate_date->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;"><strong>Titular de la Cuenta:</strong></td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $member->bank_account_holder }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;"><strong>IBAN:</strong></td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a; font-family: monospace;">
                                        {{ substr($member->bank_account, 0, 4) }} **** **** **** **** {{ substr($member->bank_account, -4) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;"><strong>IP de Registro:</strong></td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a;">{{ $member->sepa_mandate_ip }}</td>
                                </tr>
                            </table>

                            <!-- Cláusula Informativa Legal -->
                            <div style="background-color: #fffbe3; border-left: 4px solid #f59e0b; padding: 12px 15px; font-size: 12px; color: #78350f; border-radius: 0 6px 6px 0; margin-bottom: 20px;">
                                <strong>Cláusula de Reembolso SEPA:</strong>
                                Mediante la firma de este mandato, autoriza a la entidad a enviar instrucciones a su entidad bancaria para adeudar su cuenta. Tiene derecho a reembolso por su entidad bancaria en los términos y condiciones de su contrato con la misma. La solicitud de reembolso deberá efectuarse dentro de las 8 semanas que siguen a la fecha de adeudo en su cuenta.
                            </div>

                            <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">
                                Conserva este correo electrónico como comprobante de tu autorización bancaria conforme a la normativa ISO 20022.
                            </p>
                        </td>
                    </tr>

                    <!-- Pie de página -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                            <p style="margin: 0 0 5px 0;"><strong>{{ $school->name ?? '' }}</strong></p>
                            <p style="margin: 0;"> {{ $school->nif ?? '' }} | {{$school->address}} 
                                {{$school->postal_code}} {{$school->city ?? ''}} {{$school->province ?? ''}}
                            </p>
                            <p style="margin: 5px 0 0 0;">Si tienes alguna duda, responde directamente a este correo. {{$school->email ?? ''}}</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>