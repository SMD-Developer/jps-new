<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Diterima Untuk Semakan</title>
    <style>
        body {
            font-family: "Poppins", sans-serif !important;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-spacing: 0;
            width: 100%;
        }

        .header {
            padding: 20px;
            text-align: center;
        }

        .logo {
            max-width: 150px;
        }

        .title {
            text-align: left;
            color: #ff6600;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 20px;
        }

        .content {
            padding: 20px;
            font-size: 14px;
            color: #333;
        }

        .footer {
            text-align: left;
            padding: 20px;
            font-size: 12px;
            color: #777;
        }

        .footer-container {
            font-size: 13px;
            background: #000;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
        }

        .footer-container a {
            color: #00aced;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td class="header">
                <img src="{{ asset('assets/images/selangor.png') }}" alt="Company Logo" class="logo" width="30%">
            </td>
        </tr>
        <tr>
            <td class="title">
                Permohonan Diterima Untuk Semakan
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Pelanggan yang dihormati,</p>
                <p><strong>Maaf! Bayaran anda telah ditolak!</strong></p>
                <p><strong>ID Permohonan: {{ $application->id }}</strong></p>
                <p><strong>Nombor Resit: {{ $application->transaction }}</strong></p>
                <p><strong>Sebab Penolakan: {{ $application->payment_rejection_reason }}</strong></p>
                <p><strong>Status Pembayaran: <span style="color: #eb231f;">{{ $application->payment_status }}</span></strong></p>
                
                <p style="margin-top: 20px;">
                    <a href="https://ecp-jps.selangor.gov.my/clientarea/login" style="background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">View Application</a>
                </p>
                
                <p style="margin-top: 20px;">Yang benar,</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <strong>Portal e-CP Caruman Parit</strong>
            </td>
        </tr>
    </table>
</body>

</html>
