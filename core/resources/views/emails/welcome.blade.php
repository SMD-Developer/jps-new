<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Diluluskan</title>
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
            color: #000;
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
                Selamat Datang Ke Laman Portal e-CP
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Assalamualaikum / Salam Sejahtera, {{ $userName }},</p>
                <h3>Tahniah! Pendaftaran anda telah berjaya.</h3>
                <p>Anda kini boleh log masuk ke laman web Caruman Parit untuk mengakses akaun anda dan memulakan urusan seterusnya.</p>
                <p>👉 <a href="https://ecp-jps.selangor.gov.my/clientarea/login" style="color: blue;">Klik di sini untuk log masuk.</a></p>
                <p>Sekiranya anda memerlukan bantuan atau mempunyai sebarang pertanyaan, sila hubungi kami di support@e-cp.jps.com.my atau telefon 03-7333 4545.</p>
                <p>Terima kasih atas kerjasama anda.</p>
                <p>Yang benar,</p>
                <p>Portal e-CP Caruman Parit</p>
            </td>
        </tr>
    </table>
</body>

</html>
