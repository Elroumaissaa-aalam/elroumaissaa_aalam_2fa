<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>2FA Login Code</title>
</head>
<body style="background-color:#f3f4f6; margin:0; padding:0; font-family:sans-serif;">
    <div style="max-width:420px; margin:40px auto; background:#fff; border-radius:12px; box-shadow:0 2px 8px #0001; padding:32px 24px;">
        <h2 style="color:#4f46e5; font-size:24px; font-weight:700; margin-bottom:16px; text-align:center;">Two-Factor Authentication</h2>
        <p style="color:#374151; font-size:16px; margin-bottom:24px; text-align:center;">Use the code below to complete your login:</p>
        <div style="background:#f1f5f9; color:#1e293b; font-size:32px; font-weight:700; letter-spacing:8px; border-radius:8px; padding:18px 0; text-align:center; margin-bottom:24px;">
            {{ $code }}
        </div>
        <p style="color:#6b7280; font-size:14px; text-align:center;">If you did not request this code, you can ignore this email.</p>
    </div>
</body>
</html>