<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Payment Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .success-icon {
            color: #fff;   /* Green tick */
            font-size: 45px;  /* Tick size */
            font-weight: bold;
            line-height: 1;
            display: inline-block; /* no circle container */
        }




        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .header p {
            font-size: 16px;
            opacity: 0.95;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .message {
            font-size: 15px;
            color: #666666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .details-card {
            background-color: #f8f9fb;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }
        .details-title {
            font-size: 16px;
            font-weight: 600;
            color: #333333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .details-title::before {
            content: "ðŸ“‹";
            margin-right: 10px;
            font-size: 20px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e4e8;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-size: 14px;
            color: #666666;
            font-weight: 500;
        }
        .detail-value {
            font-size: 14px;
            color: #333333;
            font-weight: 600;
            text-align: right;
        }
        .amount-highlight {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 30px;
        }
        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 8px;
        }
        .amount-value {
            font-size: 32px;
            font-weight: 700;
        }
        .info-box {
            background-color: #e8f4f8;
            border-left: 4px solid #3498db;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .info-box p {
            font-size: 14px;
            color: #2c3e50;
            line-height: 1.6;
            margin: 0;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 14px 35px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #f8f9fb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e4e8;
        }
        .footer-text {
            font-size: 13px;
            color: #999999;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
        }
        .divider {
            height: 1px;
            background-color: #e0e4e8;
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }
            .header {
                padding: 30px 20px;
            }
            .content {
                padding: 30px 20px;
            }
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
            .detail-value {
                text-align: left;
            }
            .amount-value {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="success-icon">&#10003;</div>
            <h1>Payment Successful!</h1>
            <p>Your transaction has been completed</p>
        </div>



        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello {{ $buyerName }},
            </div>

            <div class="message">
                We're pleased to confirm that your payment has been successfully processed. Thank you for your transaction!
            </div>

            <!-- Amount Highlight -->
            <div class="amount-highlight">
                <div class="amount-label">Total Amount Paid</div>
                <div class="amount-value">{{ $currency }} {{ number_format($amount, 2) }}</div>
            </div>

            <!-- Transaction Details -->
            <div class="details-card">
                <div class="details-title">Transaction Details</div>
                
                <div class="detail-row">
                    <span class="detail-label">Order Number- </span>
                    <span class="detail-value"> {{ $orderNo }}</span>
                </div>
                
                <div class="detail-row"> 
                    <span class="detail-label">Transaction ID- </span>
                    <span class="detail-value"> {{ $transactionId }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Payment Method- </span>
                    <span class="detail-value"> FPX Online Banking</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Bank- </span>
                    <span class="detail-value"> {{ $bankName }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Payment Date- </span>
                    <span class="detail-value"> {{ $paymentDate }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status- </span>
                    <span class="detail-value" style="color: #27ae60;"> âœ“Completed</span>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <p><strong>ðŸ“§ Receipt:</strong> A copy of this receipt has been sent to your registered email address. Please keep it for your records.</p>
            </div>

            <!-- Action Button -->
            <!--<div class="button-container">-->
            <!--    <a href="{{ $dashboardUrl ?? url('/dashboard') }}" class="button">View My Dashboard</a>-->
            <!--</div>-->

            <div class="divider"></div>

            <div class="message">
                If you have any questions regarding this transaction, please don't hesitate to contact our support team.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                This is an automated email confirmation. Please do not reply to this email.
            </p>
            <p class="footer-text">
                Â© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
            <div class="social-links">
                <a href="#">Support</a> â€¢ 
                <a href="#">Privacy Policy</a> â€¢ 
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</body>
</html>