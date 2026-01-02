<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Password Reset</title>
    </head>
    <body>
        <p>Hello {{ $user->name }},</p>
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <p>Click the button below to reset your password:</p>
        <a href="{{ url('/password/reset_password?token='.$token) }}" style="background-color: #09971aff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset Password</a>
        <br>
        <p>If you did not request a password reset, no further action is required. Ignore the email. Thanks</p>
        <p>Please remember, this password reset link will expire in 60 minutes.</p>
        <p>Regards,<br>{{ config('app.name') }}</p>
    </body>

</html>