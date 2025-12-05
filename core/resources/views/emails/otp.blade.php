<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 5px; }
        .otp-code { font-size: 32px; font-weight: bold; color: #007bff; text-align: center; margin: 20px 0; padding: 15px; background-color: #f0f8ff; border-radius: 5px; letter-spacing: 5px; }
        .footer { margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 5px; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pengesahan Emel Diperlukan </h2>
        </div>
        
        <p>Kepada Pengguna yang Dihargai {{ $userName ?? 'User' }},</p>
        
        <p>Terima kasih kerana mendaftar dengan kami. Bagi melengkapkan proses pendaftaran dan mengesahkan alamat emel tuan/puan, sila gunakan Kod Pengesahan Sekali (OTP) berikut:</p>
        
        <div class="otp-code">{{ $otp }}</div>
        
        <p><strong>Makluman Penting:</strong></p>
        <ul>
            <li>Kod OTP ini sah untuk 10 minit sahaja</li>
            <li>Jangan kongsikan kod ini dengan sesiapa</li>
            <li>Jika tuan/puan tidak membuat permohonan ini, sila abaikan emel ini</li>
        </ul>
        
        <p>Sekiranya anda memerlukan bantuan atau mempunyai sebarang pertanyaan, sila emel kepada kami di ecp@selangor.gov.my.</p>
        
        <div class="footer">
            <p><strong>Nota :</strong> Emel ini dijana oleh sistem dan tidak perlu dibalas.</p>
            <p>Yang benar,<br>
            Portal e-CP Caruman Pari</p>
        </div>

    </div>
</body>
</html>