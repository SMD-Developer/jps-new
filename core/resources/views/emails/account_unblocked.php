<!DOCTYPE html>
<html>
<head>
    <title>Account Unblocked</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px 20px; background-color: #f9f9f9; }
        .button { 
            display: inline-block; 
            padding: 12px 30px; 
            background-color: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 20px 0;
        }
        .warning { 
            background-color: #fff3cd; 
            border: 1px solid #ffeaa7; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Account Unblocked</h1>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->username }},</h2>
            
            <p>Your account has been <strong>unblocked</strong> by our administrator.</p>
            
            <div class="warning">
                <strong>Important:</strong> For security reasons, you need to set a new password before you can login again.
            </div>
            
            <p>Click the button below to set your new password:</p>
            
            <a href="{{ $resetUrl }}" class="button">Set New Password</a>
            
            <p><strong>This link will expire in 60 minutes.</strong></p>
            
            <p>If the button doesn't work, copy and paste this link into your browser:</p>
            <p style="word-break: break-all; background-color: #f8f9fa; padding: 10px; border-radius: 3px;">
                {{ $resetUrl }}
            </p>
            
            <hr style="margin: 30px 0;">
            
            <p><small>
                If you didn't request this or have any questions, please contact our support team.<br>
                This email was sent because your account was unblocked by an administrator.
            </small></p>
        </div>
    </div>
</body>
</html>