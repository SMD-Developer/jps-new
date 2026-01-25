<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Tuntutan Pulang Balik Diterima Untuk Semakan</title>
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

        .details {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #f4a100;
        }

        .details p {
            margin: 5px 0;
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
               <strong>Resit Permintaan Diserahkan</strong>
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Penyedia Kewangan,</p>
                
                <div class="details">
                    <p><strong>Butiran Permohonan:</strong></p>
                    <p><strong>ID Permohonan:</strong> {{ $application->id ?? 'N/A' }}</p>
                    <p><strong>Nama Pemohon:</strong> {{ $application->applicant ?? 'N/A' }}</p>
                    <p><strong>Lot/PT:</strong> {{ $application->land_lot ?? 'N/A' }}</p>
                    <p><strong>Nombor Rujukan:</strong> {{ $application->refference_no ?? 'N/A' }}</p>
                    <p><strong>Pihak Ketiga:</strong> {{ $thirdParty->name ?? 'N/A' }}</p>
                </div>
                
                <p>Kerjasama dan perhatian tuan/puan dalam memproses permohonan ini amat dihargai.</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Yang Benar,</p>
                <p><strong>Portal e-CP Caruman Parit</strong></p>
            </td>
        </tr>
    </table>
</body>

</html>