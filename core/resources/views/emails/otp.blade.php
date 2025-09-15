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
            <h2>Email Verification Required</h2>
        </div>
        
        <p>Hello {{ $userName ?? 'User' }},</p>
        
        <p>Thank you for registering with us. To complete your registration and verify your email address, please use the following One-Time Password (OTP):</p>
        
        <div class="otp-code">{{ $otp }}</div>
        
        <p><strong>Important:</strong></p>
        <ul>
            <li>This OTP is valid for 10 minutes only</li>
            <li>Do not share this code with anyone</li>
            <li>If you didn't request this verification, please ignore this email</li>
        </ul>
        
        <p>If you have any questions or need assistance, please contact our support team.</p>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply to this email address.</p>
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>