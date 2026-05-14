<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; padding:30px;">
                    <tr>
                        <td>
                            <h2 style="margin-top:0; color:#111;">
                                Verify your email address
                            </h2>

                            <p style="font-size:15px; color:#333; line-height:1.6;">
                                Hello {{ $user->first_name ?? $user->name ?? 'there' }},
                            </p>

                            <p style="font-size:15px; color:#333; line-height:1.6;">
                                Thank you for creating an account. Please click the button below to verify your email address.
                            </p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ $verificationUrl }}"
                                   style="background:#2f6fc3; color:#ffffff; padding:12px 28px; text-decoration:none; border-radius:999px; font-weight:bold; display:inline-block;">
                                    Verify Email
                                </a>
                            </p>

                            <p style="font-size:14px; color:#666; line-height:1.6;">
                                This verification link will expire in 5 minutes.
                            </p>

                            <p style="font-size:14px; color:#666; line-height:1.6;">
                                If the button does not work, copy and paste this link into your browser:
                            </p>

                            <p style="font-size:13px; color:#2f6fc3; word-break:break-all;">
                                {{ $verificationUrl }}
                            </p>

                            <p style="font-size:14px; color:#666; line-height:1.6;">
                                If you did not create an account, no further action is required.
                            </p>

                            <p style="font-size:15px; color:#333;">
                                Thank you.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>