{{-- resources/views/emails/claim-status-updated.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kemas Kini Status Tuntutan Caruman Parit</title>
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
            border-bottom: 3px solid #ff6600;
        }

        .logo {
            max-width: 150px;
        }

        .title {
            text-align: left;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .content {
            padding: 20px;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        .content p {
            margin: 10px 0;
        }

        .claim-details {
            background: #f9f9f9;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #ff6600;
            border-radius: 3px;
        }

        .claim-details table {
            width: 100%;
            margin: 0;
            background: none;
            box-shadow: none;
            border-spacing: 0;
        }

        .claim-details td {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .claim-details td:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #555;
            width: 40%;
        }

        .value {
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            color: white !important;
            font-weight: bold;
            font-size: 13px;
        }

        .status-pending {
            background-color: #FFA500 !important;
        }

        .status-approve-payment-in-process {
            background-color: #4169E1 !important;
        }

        .status-rejected {
            background-color: #DC143C !important;
        }

        .status-approve-paid {
            background-color: #28A745 !important;
        }

        .message-box {
            background: #e8f4f8;
            border-left: 4px solid #4169E1;
            padding: 15px;
            margin: 15px 0;
            border-radius: 3px;
            font-size: 13px;
            color: #0c5460;
        }

        .message-box.rejected {
            background: #f8e8e8;
            border-left-color: #DC143C;
            color: #721c24;
        }

        .message-box.approved {
            background: #e8f8e8;
            border-left-color: #28A745;
            color: #155724;
        }

        .action-button {
            display: inline-block;
            background-color: #ff6600;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 4px;
            margin: 15px 0;
            font-weight: bold;
            text-align: center;
        }

        .footer {
            text-align: left;
            padding: 20px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #f0f0f0;
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
            color: #ff6600;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 15px 0;
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
                Status Pemulangan Balik Caruman Parit
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Assalamualaikum / Salam Sejahtera Pengguna yang Dihargai,{{ $notifiable->name }}</p>
                <p>Dimaklumkan bahawa status tuntutan Caruman Parit anda telah dikemas kini.</p>

                <div class="claim-details">
                    <table>
                        <tr>
                            <td class="label">Status Terbaharu :</td>
                            <td class="value">
                                <span class="status-badge status-{{ str_replace('_', '-', $claim->status) }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tarikh Kemas Kini:</td>
                            <td class="value">{{ $claim->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <p class="mt-1 text-muted">
                                    Sila log masuk ke Portal Caruman Parit (e-CP) untuk mendapatkan maklumat lebih lanjut atau mengemas kini permohonan anda. 
                                </p>
                                <p>Sila log masuk ke Portal Caruman Parit (e-CP) untuk mendapatkan maklumat lebih lanjut atau mengemas kini permohonan anda.</p>
                                <p>👉 <a href="https://ecp-jps.selangor.gov.my/clientarea/login" style="color: blue;">Klik di sini untuk log masuk.</a></p>
                                <p>Sekiranya anda memerlukan bantuan atau mempunyai sebarang pertanyaan, sila emel kepada  kami di ecp@selangor.gov.my.</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="divider"></div>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Terima kasih</p>
                <p><strong>Portal e-CP Caruman Parit</strong></p>
            </td>
        </tr>
    </table>
</body>

</html>