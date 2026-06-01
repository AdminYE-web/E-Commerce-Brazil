<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verify New Email</title>
</head>

<body style="font-family: Arial, sans-serif; color:#111;">
    <h2>Verify your new email address</h2>

    <p>Hello {{ $user->name ?? ($user->first_name ?? 'User') }},</p>

    <p>
        We received a request to change your account email from
        <strong>{{ $emailChangeRequest->old_email }}</strong>
        to
        <strong>{{ $emailChangeRequest->new_email }}</strong>.
    </p>

    <p>Please click the button below to confirm this email change.</p>

    <p>
        <a href="{{ $verifyUrl }}"
            style="display:inline-block; padding:12px 20px; background:#2563eb; color:#fff; text-decoration:none; border-radius:8px;">
            Verify Email Change
        </a>
    </p>

    <p>This link will expire at {{ $emailChangeRequest->expires_at?->format('d/m/Y H:i') }}.</p>

    <p>If you did not request this change, please ignore this email.</p>
</body>

</html>
