<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirma tu correo - aislagratis</title>
</head>
<body style="margin:0;background:#edf5ee;color:#193522;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#edf5ee;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#fff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:24px 32px;background:#1b5e20;color:#fff;font-size:20px;font-weight:700;letter-spacing:.5px;">
                            aislagratis
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 32px 28px;">
                            <p style="margin:0 0 10px;color:#2e7d32;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">Tu espacio personal</p>
                            <h1 style="margin:0 0 18px;color:#193522;font-size:26px;line-height:1.25;">Confirma tu correo</h1>
                            <p style="margin:0 0 12px;font-size:16px;line-height:1.65;">Hola {{ $recipientName }},</p>
                            <p style="margin:0 0 26px;color:#526657;font-size:15px;line-height:1.7;">Confirma tu dirección para proteger tu cuenta y acceder al seguimiento de tus solicitudes.</p>
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="border-radius:4px;background:#1b5e20;">
                                        <a href="{{ $verificationUrl }}" style="display:inline-block;padding:14px 22px;color:#fff;font-size:15px;font-weight:700;text-decoration:none;">Confirmar correo</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:24px 0 8px;color:#657568;font-size:13px;line-height:1.6;">El enlace caduca en 60 minutos.</p>
                            <p style="margin:0;color:#657568;font-size:13px;line-height:1.6;">Si no creaste esta cuenta, puedes ignorar este mensaje.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 32px;background:#f5f8f5;color:#657568;font-size:12px;line-height:1.6;">
                            aislagratis · Eficiencia energética para tu hogar
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>