<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f77b29;
            --danger-color: #e63946;
            --light-bg: #f8f9fa;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        
        .card-header h4 {
            font-weight: 600;
            margin: 0;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .verification-icon {
            color: var(--primary-color);
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }
        
        .otp-input {
            letter-spacing: 15px;
            font-size: 28px;
            font-weight: 600;
            padding: 10px 15px;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .otp-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .otp-input:disabled {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
        }
        
        /*.btn-verify {*/
        /*    background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));*/
        /*    border: none;*/
        /*    padding: 12px;*/
        /*    font-weight: 500;*/
        /*    border-radius: 10px;*/
        /*    transition: all 0.3s;*/
        /*}*/
        
        
        .btn-verify {
            background: linear-gradient(120deg, #28a745, #218838); /* Green gradient */
            color: #fff; /* White text & icon */
            border: none;
            padding: 12px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-verify i {
            color: #fff; /* Ensure icon is white */
        }
        
        .btn-verify:hover {
            background: linear-gradient(120deg, #218838, #1e7e34); /* Darker green on hover */
        }

        
        .btn-verify:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-verify:disabled {
            background: #6c757d;
            transform: none;
            box-shadow: none;
        }
        
        .btn-resend {
            border-radius: 10px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        .timer-text {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .email-display {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px 15px;
            display: inline-block;
            margin: 10px 0;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #6c757d;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #dee2e6;
        }
        
        .divider::before {
            margin-right: 10px;
        }
        
        .divider::after {
            margin-left: 10px;
        }
        
        .countdown-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-top: 10px;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .countdown-badge.warning {
            background-color: var(--warning-color);
        }
        
        .countdown-badge.danger {
            background-color: var(--danger-color);
            animation: pulse 1s infinite;
        }
        
        .countdown-badge.expired {
            background-color: #6c757d;
            animation: none;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .otp-input-container {
            position: relative;
        }
        
        .otp-input-container .form-text {
            position: absolute;
            right: 0;
            bottom: -25px;
            font-size: 0.8rem;
        }
        
        .expired-notice {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .otp-input {
                font-size: 22px;
                letter-spacing: 10px;
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Email Verification</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-envelope-circle-check verification-icon"></i>
                            <p class="mb-1">Hi <strong>{{ $clientRegister->userName ?? 'User' }}</strong>,</p>
                            <p class="mb-2">We've sent a verification code to:</p>
                            <div class="email-display">
                                <strong>{{ $email }}</strong>
                            </div>
                            <div id="countdown-badge" class="countdown-badge" style="display: none;">
                                <i class="fas fa-clock me-1"></i> <span id="countdown-text">Loading...</span>
                            </div>
                        </div>
                        
                        <div id="expired-notice" class="expired-notice" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Code Expired!</strong> Please request a new verification code.
                        </div>
                        
                        <form id="otpForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            
                            <div class="mb-4">
                                <label for="otp" class="form-label fw-semibold">Enter 6-digit verification code</label>
                                <div class="otp-input-container">
                                    <input type="text" 
                                           class="form-control otp-input" 
                                           id="otp" 
                                           name="otp" 
                                           maxlength="6" 
                                           pattern="[0-9]{6}" 
                                           placeholder="000000" 
                                           required
                                           autocomplete="one-time-code">
                                    <div class="form-text">Press Enter to verify</div>
                                </div>
                                <div id="otp-error" class="text-danger mt-2"></div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-verify btn-lg" id="verifyBtn">
                                    <i class="fas fa-check-circle me-2"></i> Verify Code
                                </button>
                            </div>
                        </form>
                        
                        <div class="divider">Didn't receive the code?</div>
                        
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-primary btn-resend" id="resendBtn">
                                <i class="fas fa-paper-plane me-2"></i> Resend Code
                            </button>
                            <div id="resend-countdown" class="timer-text mt-3" style="display: none;"></div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('client_login') }}" class="text-decoration-none text-muted small">
                                <i class="fas fa-arrow-left me-1"></i> Back to login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    $(document).ready(function() {
        let resendTimeout = 60; // 60 seconds cooldown
        let isResendDisabled = false;
        let otpExpired = false;
        let countdownInterval = null;
        
        // Initialize remaining seconds from PHP
        let remainingSeconds = {{ $remainingSeconds ?? 0 }};

        // Auto-focus on OTP input
        $('#otp').focus();

        // Start OTP countdown if we have remaining time
        if (remainingSeconds > 0) {
            startOtpCountdown(remainingSeconds);
        } else {
            showExpiredState();
        }

        // Only allow numbers in OTP input
        $('#otp').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 6 && !otpExpired) {
                $('#verifyBtn').focus();
            }
        });

        // Handle OTP form submission
        $('#otpForm').on('submit', function(e) {
            e.preventDefault();
            
            if (otpExpired) {
                Swal.fire({
                    title: "Code Expired!",
                    text: "Please request a new verification code.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }
            
            let formData = $(this).serialize();
            let $verifyBtn = $('#verifyBtn');
            let originalText = $verifyBtn.html();
            
            // Clear previous errors
            $('#otp-error').text('');
            
            // Show loading state
            $verifyBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Verifying...');
            
            $.ajax({
                url: "{{ route('otp.verify') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Stop countdown
                        if (countdownInterval) {
                            clearInterval(countdownInterval);
                        }
                        
                        // Show success message
                        Swal.fire({
                            title: "Berjaya!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Log Masuk",
                            customClass: {
                                confirmButton: 'btn btn-verify'
                            },
                            buttonsStyling: false
                        }).then(() => {
                            // Redirect to login
                            if (response.redirect_to_login) {
                                window.location.href = "{{ route('client_login') }}";
                            }
                        });
                    } else {
                        $('#otp-error').text(response.message);
                        $('#otp').val('').focus();
                    }
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    if (response.errors && response.errors.otp) {
                        $('#otp-error').text(response.errors.otp[0]);
                    } else {
                        $('#otp-error').text(response.message || 'Verification failed. Please try again.');
                    }
                    $('#otp').val('').focus();
                },
                complete: function() {
                    // Reset button state if not expired
                    if (!otpExpired) {
                        $verifyBtn.prop('disabled', false).html(originalText);
                    }
                }
            });
        });

        // Handle resend OTP
        $('#resendBtn').on('click', function() {
            if (isResendDisabled) return;
            
            let $resendBtn = $(this);
            let originalText = $resendBtn.html();
            
            // Show loading state
            $resendBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
            
            $.ajax({
                url: "{{ route('otp.resend') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    email: "{{ $email }}"
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                        
                        // Reset OTP state
                        otpExpired = false;
                        $('#expired-notice').hide();
                        $('#otp').prop('disabled', false).val('').focus();
                        $('#verifyBtn').prop('disabled', false).html('<i class="fas fa-check-circle me-2"></i> Verify Code');
                        
                        // Start new countdown (assuming 10 minutes for new OTP)
                        startOtpCountdown(600); // 10 minutes = 600 seconds
                        startResendCountdown();
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'btn btn-verify'
                            },
                            buttonsStyling: false
                        });
                    }
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    Swal.fire({
                        title: "Error!",
                        text: response.message || 'Failed to resend OTP. Please try again.',
                        icon: "error",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: 'btn btn-verify'
                        },
                        buttonsStyling: false
                    });
                },
                complete: function() {
                    // Reset button state if not in countdown
                    if (!isResendDisabled) {
                        $resendBtn.prop('disabled', false).html(originalText);
                    }
                }
            });
        });

        // Start countdown for OTP expiration
        function startOtpCountdown(seconds) {
            let countdown = seconds;
            let $badge = $('#countdown-badge');
            let $countdownText = $('#countdown-text');
            
            $badge.show();
            
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            
            countdownInterval = setInterval(function() {
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    showExpiredState();
                    return;
                }
                
                let minutes = Math.floor(countdown / 60);
                let seconds = countdown % 60;
                let timeText = '';
                
                if (minutes > 0) {
                    timeText = minutes + 'm ' + seconds + 's';
                } else {
                    timeText = seconds + 's';
                }
                
                $countdownText.text('Expires in ' + timeText);
                
                // Change badge color based on remaining time
                $badge.removeClass('warning danger');
                if (countdown <= 30) {
                    $badge.addClass('danger');
                } else if (countdown <= 120) {
                    $badge.addClass('warning');
                }
                
                countdown--;
            }, 1000);
        }

        // Start countdown for resend button
        function startResendCountdown() {
            isResendDisabled = true;
            let countdown = resendTimeout;
            let $resendBtn = $('#resendBtn');
            let $countdownDiv = $('#resend-countdown');
            
            $resendBtn.prop('disabled', true);
            $countdownDiv.show().html(`<i class="fas fa-clock me-1"></i> You can resend in <span class="fw-bold">${countdown}</span> seconds`);
            
            let interval = setInterval(function() {
                countdown--;
                $countdownDiv.html(`<i class="fas fa-clock me-1"></i> You can resend in <span class="fw-bold">${countdown}</span> seconds`);
                
                if (countdown <= 0) {
                    clearInterval(interval);
                    isResendDisabled = false;
                    $resendBtn.prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Resend Code');
                    $countdownDiv.hide();
                }
            }, 1000);
        }

        // Show expired state
        function showExpiredState() {
            otpExpired = true;
            $('#countdown-badge').addClass('expired').find('#countdown-text').text('Code expired');
            $('#expired-notice').show();
            $('#otp').prop('disabled', true);
            $('#verifyBtn').prop('disabled', true).html('<i class="fas fa-times-circle me-2"></i> Code Expired');
        }

        // Auto-submit when 6 digits are entered
        $('#otp').on('input', function() {
            if (this.value.length === 6 && !otpExpired) {
                setTimeout(function() {
                    $('#otpForm').submit();
                }, 500);
            }
        });
        
        // Add Enter key support
        $('#otp').on('keypress', function(e) {
            if (e.which === 13 && !otpExpired) {
                $('#otpForm').submit();
            }
        });
    });
    </script>
</body>
</html>