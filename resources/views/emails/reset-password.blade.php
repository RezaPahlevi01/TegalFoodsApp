<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="font-family: Arial; background:#f4f4f4; padding:30px;">

<div style="max-width:600px;margin:auto;background:white;padding:30px;border-radius:10px;">

    <h2 style="color:#333;">Reset Password Anda</h2>

    <p style="color:#555;">
        Kami menerima permintaan reset password untuk akun Anda:
    </p>

    <p><b>{{ $email }}</b></p>

    <p style="margin-top:20px;">
        Klik tombol di bawah untuk reset password:
    </p>

    <a href="{{ $resetLink }}"
       style="display:inline-block;padding:12px 20px;background:#f97316;color:white;text-decoration:none;border-radius:8px;margin-top:10px;">
        Reset Password
    </a>

    <p style="margin-top:30px;color:#888;font-size:12px;">
        Link ini hanya berlaku untuk keamanan akun Anda.
    </p>

</div>

</body>
</html>