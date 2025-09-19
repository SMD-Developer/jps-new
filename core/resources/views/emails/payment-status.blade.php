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
                <p><strong>Pambayaran anda telah diterima</strong></p>
                <p><strong>Nombor Resit: {{ $application->reciept_number }}</strong></p>
                <p><strong>Rujukan Transaksi: {{ $application->transaction }}</strong></p>
                <p><strong>Status Pembayaran: <span style="color: #00AA00;">{{ $application->payment_status }}</span></strong></p>
                
                <p>Permohonan anda kini sedang diproses ke peringkat seterusnya. Anda boleh menyemak status permohonan anda pada bila-bila masa dengan log masuk ke akaun anda.</p>
                
                <p style="margin-top: 20px;">
                    <a href="{{ url('/client/applications/' . $application->id) }}" style="background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">Lihat Permohonan</a>
                </p>
                
                <p style="margin-top: 20px;">Yang benar,</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Portal e-CP Caruman Parit</p>
            </td>
        </tr>
        <tr>
            <td class="footer-container">
                <h3>JOM BERHUBUNG                </h3>
                <p>Jika anda mempunyai sebarang soalan, lawati tapak sokongan kami di <a href="https://www.jps.com">https://www.jps.com</a>,<br>
                    hubungi kami di <a href="mailto:support@jps.com">support@jps.com</a>
                </p>
                <p>E-mel ini adalah sulit. Ia juga mungkin mendapat keistimewaan dari segi undang-undang. Jika anda bukan penerima, anda tidak boleh menyalin, memajukan, mendedahkan atau menggunakan mana-mana bahagian daripadanya. Jika anda tersilap menerima mesej ini, sila padamkannya dan maklumkan kepada penghantar dengan segera melalui e-mel balasan. Komunikasi Internet tidak boleh dijamin tepat pada masanya, selamat, bebas ralat atau bebas virus. Pengirim tidak menerima liabiliti untuk sebarang kesilapan atau ketinggalan.
                </p>
                <p>"JIMAT KERTAS - FIKIRKAN SEBELUM ANDA CETAK"</p>
                <p>© Hak Cipta 2025. Hak Cipta Terpelihara</p>
            </td>
        </tr>
    </table>
</body>

</html>
