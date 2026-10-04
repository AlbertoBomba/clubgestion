<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmación de inscripción</title>
</head>
<?php
    $primary   = $school->primary_color   ?: '#0f172a';
    $secondary = $school->secondary_color ?: '#3b82f6';
    $logoUrl   = $school->logo ? asset('storage/' . $school->logo) : null;
    $schoolName = $school->name ?? config('app.name');
?>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                    
                    <tr>
                        <td style="background: linear-gradient(135deg, <?php echo e($primary); ?> 0%, <?php echo e($secondary); ?> 100%); padding:32px 24px; text-align:center;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logoUrl): ?>
                                <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($schoolName); ?>" style="max-height:70px; max-width:180px; margin-bottom:16px; display:block; margin-left:auto; margin-right:auto;">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h1 style="margin:0; color:#ffffff; font-size:24px; font-weight:700; line-height:1.3;">
                                ¡Inscripción confirmada!
                            </h1>
                            <p style="margin:8px 0 0 0; color:rgba(255,255,255,0.9); font-size:15px;">
                                <?php echo e($schoolName); ?>

                            </p>
                        </td>
                    </tr>

                    
                    <tr>
                        <td style="padding:32px 32px 16px 32px;">
                            <p style="margin:0 0 16px 0; font-size:16px; line-height:1.5;">
                                Hola <strong><?php echo e($player->name); ?></strong>,
                            </p>
                            <p style="margin:0 0 24px 0; font-size:15px; line-height:1.6; color:#374151;">
                                Tu inscripción en <strong><?php echo e($schoolName); ?></strong> se ha registrado correctamente.
                                A continuación te resumimos los datos que hemos recibido:
                            </p>

                            
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <h2 style="margin:0 0 12px 0; font-size:14px; text-transform:uppercase; letter-spacing:0.05em; color:<?php echo e($primary); ?>;">
                                            Datos del jugador
                                        </h2>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#374151;">
                                            <tr>
                                                <td style="padding:6px 0; color:#6b7280; width:40%;">Matricula</td>
                                                <td style="padding:6px 0; font-weight:600;"><?php echo e($player->cod_matricula); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:6px 0; color:#6b7280; width:40%;">Nombre</td>
                                                <td style="padding:6px 0; font-weight:600;"><?php echo e($player->name); ?> <?php echo e($player->surname); ?></td>
                                            </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dbirth): ?>
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Fecha de nacimiento</td>
                                                    <td style="padding:6px 0; font-weight:600;"><?php echo e(\Carbon\Carbon::parse($player->dbirth)->format('d/m/Y')); ?></td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->dni): ?>
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Documento</td>
                                                    <td style="padding:6px 0; font-weight:600;"><?php echo e($player->dni); ?></td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->email): ?>
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Email</td>
                                                    <td style="padding:6px 0; font-weight:600;"><?php echo e($player->email); ?></td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($player->phone1): ?>
                                                <tr>
                                                    <td style="padding:6px 0; color:#6b7280;">Teléfono</td>
                                                    <td style="padding:6px 0; font-weight:600;"><?php echo e($player->phone1); ?></td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($season): ?>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:24px;">
                                    <tr>
                                        <td style="padding:20px;">
                                            <h2 style="margin:0 0 12px 0; font-size:14px; text-transform:uppercase; letter-spacing:0.05em; color:<?php echo e($primary); ?>;">
                                                Temporada
                                            </h2>
                                            <p style="margin:0; font-size:14px; color:#374151;">
                                                <strong><?php echo e($season->name ?? ($season->from_year . '/' . $season->to_year)); ?></strong>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($sections)): ?>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; margin-bottom:24px;">
                                    <tr>
                                        <td style="padding:20px;">
                                            <h2 style="margin:0 0 12px 0; font-size:14px; text-transform:uppercase; letter-spacing:0.05em; color:<?php echo e($primary); ?>;">
                                                Secciones inscritas
                                            </h2>
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#374151;">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td style="padding:6px 0; border-bottom:1px solid #e5e7eb;"><?php echo e($section['name']); ?></td>
                                                        
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <p style="margin:24px 0 8px 0; font-size:14px; line-height:1.6; color:#374151;">
                                Si detectas algún dato incorrecto o tienes cualquier duda,
                                ponte en contacto con nosotros respondiendo a este correo.
                            </p>
                            <p style="margin:16px 0 0 0; font-size:14px; color:#374151;">
                                Un saludo,<br>
                                <strong><?php echo e($schoolName); ?></strong>
                            </p>
                        </td>
                    </tr>

                    
                    <tr>
                        <td style="background-color:#f9fafb; padding:20px 32px; text-align:center; border-top:1px solid #e5e7eb;">
                            <p style="margin:0; font-size:12px; color:#9ca3af; line-height:1.5;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($school->address || $school->city): ?>
                                    <?php echo e(trim(($school->address ?? '') . ' · ' . ($school->city ?? ''), ' ·')); ?><br>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($school->phone): ?>
                                    Tel. <?php echo e($school->phone); ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($school->email): ?> · <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($school->email): ?>
                                    <?php echo e($school->email); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                            <p style="margin:8px 0 0 0; font-size:11px; color:#9ca3af;">
                                Si tiene alguna incidencia contacte con <?php echo e($school->email); ?>.
                            </p>
                            <p style="margin:8px 0 0 0; font-size:11px; color:#9ca3af;">
                                Este mensaje ha sido enviado automáticamente. Por favor, no respondas.
                            </p>

                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views\emails\player-registration-confirmation.blade.php ENDPATH**/ ?>