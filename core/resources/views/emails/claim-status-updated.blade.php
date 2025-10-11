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
            color: #ff6600;
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
            color: white;
            font-weight: bold;
            font-size: 13px;
        }

        .status-pending {
            background-color: #FFA500;
        }

        .status-processing {
            background-color: #4169E1;
        }

        .status-rejected {
            background-color: #DC143C;
        }

        .status-approved {
            background-color: #28A745;
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
                Kemas Kini Status Tuntutan Caruman Parit
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Halo {{ $notifiable->name }},</p>

                <p>Kami dengan senang hati memberitahu bahawa status tuntutan caruman parit anda telah dikemaskini.</p>

                <div class="claim-details">
                    <table>
                        <tr>
                            <td class="label">ID Tuntutan:</td>
                            <td class="value"><strong>{{ $claim->id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Status Baru:</td>
                            <td class="value">
                                <span class="status-badge status-{{ str_replace('_', '-', $claim->status) }}" style="color: #ffffff !important;">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tarikh Kemas Kini:</td>
                            <td class="value">{{ $claim->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>

                @if($claim->status === 'pending')
                    <div class="message-box">
                        <strong>Maklumat:</strong> Tuntutan anda sedang menunggu semakan oleh pasukan kami. Kami akan memberitahu anda sebaik sahaja ada perkembangan. Sila ambil masa 3-5 hari bekerja.
                    </div>
                @elseif($claim->status === 'approve_payment_in_process')
                    <div class="message-box processing">
                        <strong>Maklumat:</strong> Tuntutan anda telah diluluskan dan pembayaran sedang diproses. Anda akan menerima dana dalam masa 3-5 hari bekerja. Sila periksa akaun bank anda.
                    </div>
                @elseif($claim->status === 'rejected')
                    <div class="message-box rejected">
                        <strong>Pemberitahuan:</strong> Maaf, tuntutan anda telah ditolak. Untuk maklumat lanjut mengenai sebab penolakan dan proses rayuan, sila hubungi kami.
                    </div>
                @elseif($claim->status === 'approve_paid')
                    <div class="message-box approved">
                        <strong>Tahniah:</strong> Tuntutan anda telah diluluskan dan pembayaran telah dihantar. Sila semak akaun bank anda untuk mengesahkan penerimaan dana.
                    </div>
                @endif

                <div class="divider"></div>

                <p>Sekiranya anda mempunyai sebarang pertanyaan atau memerlukan bantuan lanjut, sila jangan ragu untuk menghubungi kami melalui portal atau terus hubungi pasukan sokongan kami.</p>
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