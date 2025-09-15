<!DOCTYPE html>
<html>
<head>
    <title>Approval Letter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 20px; }
        .footer { text-align: center; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Approval Letter</h2>
        <p>JPS - Application Approval</p>
    </div>

    <div class="content">
        <p>{{ $date }}</p>
        <p>To: {{ $recipient }}</p>
        <p>Address: {{ $address }}</p>
        <p>Dear {{ $recipient }},</p>
        <p>We are pleased to inform you that your application for the land lot <strong>{{ $land_lot }}</strong> has been approved.</p>
        <p>Please contact us for further details or if you have any questions.</p>
        <p>Thank you.</p>
    </div>

    <div class="footer">
        <p>Sincerely,<br>JPS Administration</p>
    </div>
</body>
</html>