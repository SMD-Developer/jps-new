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
            padding: 20px 20px 10px;
            font-size: 14px;
            color: #333;
        }

        .footer {
            text-align: left;
            padding: 0px 20px 20px;
            font-size: 14px;
            color: #333;
        }

        .footer p{
            margin: 0px;
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
                <img src="{{ asset('assets/images/uploads/settings/1765011938.png') }}" alt="Company Logo" class="logo" width="30%">
            </td>
        </tr>
        <tr>
            <td class="title">
                Maklumat Pembayaran Agensi Kerajaan Diterima Untuk Semakan
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Kepada Pelulus Kewangan,</p>
                <p>Dimaklumkan bahawa satu maklumat pembayaran dari agensi kerajaan seperti maklumat di bawah telah diterima dan sedia untuk tindakan semakan oleh pihak tuan/puan.</p>
                <p><strong>Nama Pemohon: {{ $application->applicant }}</strong></p>
                <p><strong>ID Permohonan: {{ $application->id }}</strong></p>
                <p><strong>ID Transaksi: {{ $application->transaction }}</strong></p>
                <p><strong>Tarikh Pembayaran: {{ $application->deposit_date }}</strong></p>
                <p>Kerjasama dan perhatian tuan/puan dalam memproses pembayaran ini amat dihargai.</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Yang benar,<br>
                Portal e-CP Caruman Parit</p>
            </td>
        </tr>
    </table>
</body>

</html>
