<!DOCTYPE html>
<html>
<head>
    <title>Set Semula Kata Laluan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #3949e7;">Set Semula Kata Laluan</h2>
        <p>Anda menerima emel ini kerana kami menerima permintaan set semula kata laluan untuk akaun anda.</p>
        <p>Klik butang di bawah untuk set semula kata laluan anda:</p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ route('third.party.password.reset', $token) }}" 
               style="background-color: #3949e7; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Set Semula Kata Laluan
            </a>
        </p>
        <p>Atau salin dan tampal pautan ini ke pelayar anda:</p>
        <p style="word-break: break-all; color: #3949e7;">{{ route('third.party.password.reset', $token) }}</p>
        <p><strong>Pautan ini akan tamat tempoh dalam 24 jam.</strong></p>
        <p>Jika anda tidak membuat permintaan ini, sila abaikan emel ini.</p>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
        <p style="font-size: 12px; color: #666;">
            Portal e-CP (CARUMAN PARIT)<br>
            JPS NEGERI SELANGOR
        </p>
    </div>
</body>
</html>