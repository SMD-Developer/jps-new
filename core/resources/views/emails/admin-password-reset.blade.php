<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title>Tetapkan Semula Kata Laluan Anda</title>
    <!-- Your existing styles -->
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/selangor.png') }}" alt="Company Logo" class="logo" width="30%">
            <div class="title">Tetapkan Semula Kata Laluan Anda</div>
        </div>
        <div class="content">
            <p>sayang {{ $notifiable->name ?? 'User' }},</p>
            <p>Anda menerima e-mel ini kerana kami menerima permintaan tetapan semula kata laluan untuk akaun anda.</p>            <p>
                <a href="{{ $actionUrl }}"
                    style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    Tetapkan Semula Kata Laluan
                </a>
            </p>
            <p>Pautan tetapan semula kata laluan ini akan tamat tempoh {{ config('auth.passwords.users.expire') }} minit.</p>
            <p>Jika anda tidak meminta tetapan semula kata laluan, sila abaikan e-mel ini atau hubungi sokongan.</p>        </div>
        <div class="footer">
            salam hormat,<br>
            <strong>JPS</strong>
        </div>
    </div>
</body>

</html>
