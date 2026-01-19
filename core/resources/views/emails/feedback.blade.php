<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #0066cc;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .content {
            background-color: white;
            padding: 20px;
            margin-top: 10px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #0066cc;
        }
        .value {
            margin-top: 5px;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 3px solid #0066cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Portal e-CP Feedback</h2>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Nama:</div>
                <div class="value">{{ $name }}</div>
            </div>
            
            <div class="field">
                <div class="label">Email:</div>
                <div class="value">{{ $email }}</div>
            </div>
            
            <div class="field">
                <div class="label">No. Telefon:</div>
                <div class="value">{{ $telephone }}</div>
            </div>
            
            <div class="field">
                <div class="label">Maklum Balas:</div>
                <div class="value">{{ $comment }}</div>
            </div>
            
            <div class="field">
                <div class="label">Tarikh & Masa:</div>
                <div class="value">{{ $submitted_at }}</div>
            </div>
        </div>
    </div>
</body>
</html>