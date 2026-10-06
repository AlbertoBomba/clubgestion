<?php
    $member = $memberSeason->member;
    $iban = $member->bank_account ? str_replace(' ', '', $member->bank_account) : '';
    $maskedIban = $iban ? substr($iban, 0, 4) . ' **** **** ' . substr($iban, -4) : '-';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso de cargo en cuenta</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f8; padding: 20px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; overflow: hidden;">
                    <tr>
                        <td align="center" style="background-color: #1e293b; padding: 30px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700;">
                                Aviso de cargo en cuenta
                            </h1>
                            <p style="color: #94a3b8; margin: 5px 0 0 0; font-size: 14px;">
                                <?php echo e($school->name ?? ''); ?>

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 40px; color: #334155; line-height: 1.6;">
                            <p style="font-size: 16px; margin-top: 0;">
                                Hola <strong><?php echo e($member->name); ?></strong>,
                            </p>
                            <p style="font-size: 14px; color: #64748b;">
                                Te informamos de que, conforme a la orden de domiciliación SEPA que firmaste, el día
                                <strong><?php echo e($chargeDate->format('d/m/Y')); ?></strong> se pasará al cobro en tu cuenta bancaria
                                el recibo correspondiente a tu cuota <strong><?php echo e($memberType->name); ?></strong>.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin: 25px 0; padding: 20px;">
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b; width: 45%;">Concepto</td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a;"><?php echo e($memberType->name); ?><?php echo e($memberSeason->season ? ' - ' . $memberSeason->season->season : ''); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;">Importe</td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a; font-weight: bold;"><?php echo e(number_format((float) $memberSeason->price, 2, ',', '.')); ?> €</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;">Fecha de cargo</td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a;"><?php echo e($chargeDate->format('d/m/Y')); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;">Cuenta (IBAN)</td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a; font-family: monospace;"><?php echo e($maskedIban); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b;">Referencia del mandato</td>
                                    <td style="padding: 8px 0; font-size: 13px; color: #0f172a;"><?php echo e($member->sepa_mandate_ref); ?></td>
                                </tr>
                            </table>

                            <p style="font-size: 13px; color: #64748b;">
                                Por favor, asegúrate de disponer de saldo suficiente en la cuenta en la fecha indicada.
                                Si tienes cualquier duda, ponte en contacto con el club respondiendo a este correo.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 15px; font-size: 11px; color: #94a3b8;">
                            <?php echo e($school->name ?? config('app.name')); ?>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/emails/member-bank-charge-notice.blade.php ENDPATH**/ ?>