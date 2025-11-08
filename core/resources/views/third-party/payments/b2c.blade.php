<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Third Party Document Print Payment - JPS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin: 0 auto;
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        .btn-payment {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 12px 30px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .btn-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23,162,184,0.4);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .back-link {
            color: #fff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h3 class="text-white mb-2">JPS - Third Party Services</h3>
                    <p class="text-white mb-0">Document Reprint Payment Gateway</p>
                </div>

                <!-- Payment Card -->
                <div class="card">
                    <div class="card-header bg-warning text-dark text-center py-3">
                        <h5 class="mb-0"><i class="fas fa-print me-2"></i><strong>THIRD PARTY DOCUMENT REPRINT PAYMENT</strong></h5>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="bg-light p-3 border-bottom">
                            <h6 class="text-center mb-0 text-dark">FPX Payment Gateway</h6>
                        </div>
                        
                        <div class="p-4">
                            <!-- Payment Information -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <h6 class="font-weight-bold text-dark">Service Description</h6>
                                    <p class="text-muted mb-1">Third Party Document Reprint Service</p>
                                    <p class="text-muted mb-0">Reference No: <strong>{{ $referenceNo ?? 'N/A' }}</strong></p>
                                    <p class="text-muted mb-0">Service Type: Document Reprinting</p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h6 class="font-weight-bold text-dark">Total Amount</h6>
                                    <p class="h4 text-primary mb-0">MYR {{ number_format($fpx_txnAmount, 2) }}</p>
                                    <small class="text-muted">Reprint service fee</small>
                                </div>
                            </div>

                            <!-- Third Party Information -->
                            <div class="alert alert-info mb-4">
                                <h6 class="alert-heading"><i class="fas fa-user me-2"></i>Third Party Information</h6>
                                <p class="mb-1"><strong>Name:</strong> {{ $fpx_buyerName }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $fpx_buyerEmail }}</p>
                                <p class="mb-0"><strong>Service Fee:</strong> RM 1.00 per document reprint</p>
                            </div>

                            <!-- FPX Payment Form -->
                            <form name="fpxPaymentForm" method="post" action="{{ $actionUrl }}">
                                <!-- All Hidden FPX Parameters -->
                                <input type="hidden" value="{{ $fpx_msgType }}" name="fpx_msgType">
                                <input type="hidden" value="{{ $fpx_msgToken }}" name="fpx_msgToken">
                                <input type="hidden" value="{{ $fpx_sellerExId }}" name="fpx_sellerExId">
                                <input type="hidden" value="{{ $fpx_sellerExOrderNo }}" name="fpx_sellerExOrderNo">
                                <input type="hidden" value="{{ $fpx_sellerTxnTime }}" name="fpx_sellerTxnTime">
                                <input type="hidden" value="{{ $fpx_sellerOrderNo }}" name="fpx_sellerOrderNo">
                                <input type="hidden" value="{{ $fpx_sellerId }}" name="fpx_sellerId">
                                <input type="hidden" value="{{ $fpx_sellerBankCode }}" name="fpx_sellerBankCode">
                                <input type="hidden" value="{{ $fpx_txnCurrency }}" name="fpx_txnCurrency">
                                <input type="hidden" value="{{ $fpx_txnAmount }}" name="fpx_txnAmount">
                                <input type="hidden" value="{{ $fpx_buyerEmail }}" name="fpx_buyerEmail">
                                <input type="hidden" value="{{ $fpx_checkSum }}" name="fpx_checkSum">
                                <input type="hidden" value="{{ $fpx_buyerName }}" name="fpx_buyerName">
                                <input type="hidden" value="{{ $fpx_buyerBankId }}" name="fpx_buyerBankId">
                                <input type="hidden" value="{{ $fpx_buyerBankBranch }}" name="fpx_buyerBankBranch">
                                <input type="hidden" value="{{ $fpx_buyerAccNo }}" name="fpx_buyerAccNo">
                                <input type="hidden" value="{{ $fpx_buyerId }}" name="fpx_buyerId">
                                <input type="hidden" value="{{ $fpx_makerName }}" name="fpx_makerName">
                                <input type="hidden" value="{{ $fpx_buyerIban }}" name="fpx_buyerIban">
                                <input type="hidden" value="{{ $fpx_version }}" name="fpx_version">
                                <input type="hidden" value="{{ $fpx_productDesc }}" name="fpx_productDesc">
                                
                                <!-- Test Case Information -->
                                @if(isset($testCase))
                                    <div class="alert alert-warning mb-4">
                                        <h6 class="alert-heading">Test Mode</h6>
                                        <p class="mb-1"><strong>Test Case:</strong> {{ $testCase }}</p>
                                        <p class="mb-0"><strong>Bank:</strong> {{ $fpx_buyerBankBranch }} ({{ $fpx_buyerBankId }})</p>
                                    </div>
                                @endif

                                <!-- Payment Button -->
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                        <i class="fas fa-lock me-2"></i>Proceed to FPX Payment - RM 1.00
                                    </button>
                                </div>

                                <!-- FPX Logo -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/images/Logo-FPX.png') }}" alt="FPX Payment" class="img-fluid" style="max-width: 100px;">
                                    <p class="text-muted mt-2 mb-0">Secure Online Banking Payment</p>
                                </div>
                            </form>

                            <!-- Important Instructions -->
                            <div class="alert alert-warning">
                                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Important Instructions</h6>
                                <ul class="mb-0 ps-3">
                                    <li>This is a <strong>third party document reprint service</strong> with fixed fee of RM 1.00</li>
                                    <li>You must have an Internet Banking account to make transactions using FPX</li>
                                    <li>Please disable your browser's pop-up blocker to avoid interruptions</li>
                                    <li>Do not close the browser or refresh the page until you receive a response</li>
                                    <li>After successful payment, you can download/print the receipt immediately</li>
                                    <li><strong>Each reprint requires a separate payment of RM 1.00</strong></li>
                                </ul>
                            </div>

                            <!-- Third Party Notice -->
                            <div class="alert alert-primary">
                                <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Third Party Service Notice</h6>
                                <p class="mb-0">
                                    <strong>Note:</strong> This payment is for third party document reprint service. 
                                    You are requesting to reprint a receipt as an authorized third party. 
                                    Each reprint session requires a separate payment of RM 10.00.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-white">
                        Copyright © {{ date('Y') }} JPS. All rights reserved. | Third Party Services
                    </small>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .alert-primary {
            background-color: #cce5ff;
            color: #004085;
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>