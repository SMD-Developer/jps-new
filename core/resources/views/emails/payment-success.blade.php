<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .success-icon {
            font-size: 48px;
            color: #4CAF50;
            text-align: center;
            margin: 20px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
        }
        .details-table th,
        .details-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            background-color: #667eea;
            color: white;
            font-weight: bold;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .amount-highlight {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #f0f8f0;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Pembayaran Berjaya</h1>
        </div>
        
        <div class="success-icon">✅</div>
        
        <p>Assalamualaikum / Salam Sejahtera Pengguna yang Dihargai,{{ $buyer_name }},</p>
        <p>Terima kasih kerana menggunakan Portal e-CP.</p>
        
        <p>Sukacita dimaklumkan bahawa pembayaran anda telah <strong>berjaya</strong>.</p>
        
        <div class="amount-highlight">
            Jumlah Bayaran: {{ $amount }}
        </div>
        
        <table class="details-table">
            <tr>
                <th colspan="2">Butiran Transaksi:</th>
            </tr>
            <tr>
                <td><strong>Nombor Pesanan :</strong></td>
                <td>{{ $seller_order_no }}</td>
            </tr>
            <tr>
                <td><strong>ID Transaksi :</strong></td>
                <td>{{ $transaction_id }}</td>
            </tr>
            <tr>
                <td><strong>Kaedah Pembayaran :</strong></td>
                <td>{{ $payment_method }}</td>
            </tr>
            <tr>
                <td><strong>Bank :</strong></td>
                <td>{{ $bank_name }}</td>
            </tr>
            <tr>
                <td><strong>Tarikh Pembayaran :</strong></td>
                <td>{{ date('d M Y, H:i:s', strtotime($payment_date)) }}</td>
            </tr>
            <tr>
                <td><strong>Status :</strong></td>
                <td>Selesai</td>
            </tr>
        </table>
        
        <p>Sekiranya anda memerlukan bantuan atau mempunyai sebarang pertanyaan, sila emel kepada  kami di ecp@selangor.gov.my .</p>
        <p>Terima kasih atas kerjasama dan perhatian tuan/puan.</p>
        
        <div class="footer">
            <p>Yang benar</p>
            <p>Portal e-CP Caruman Parit</p>
        </div>
    </div>
</body>
</html>