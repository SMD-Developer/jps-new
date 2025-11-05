<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Third Party Corporate Payment | JPS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40,167,69,0.4);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .third-party-badge {
            background: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h3 class="text-white mb-2">JPS - Third Party Corporate Services</h3>
                    <p class="text-white mb-0">Corporate Document Print Payment Gateway</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h6 class="mb-0">
                            <strong>THIRD PARTY FPX B2B PAYMENT GATEWAY</strong>
                            <span class="third-party-badge ms-2">Corporate Third Party</span>
                        </h6>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="bg-light p-3 border-bottom">
                            <h6 class="text-center mb-0 text-dark">Third Party Corporate Payment Details</h6>
                        </div>
                        
                        <div class="p-4">
                            <!-- Payment Information -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <h6 class="font-weight-bold">Description</h6>
                                    <p class="text-muted mb-1">Third Party Corporate Document Print Service</p>
                                    <p class="text-muted mb-0">No Rujukan: {{ $referenceNo ?? 'Corporate Third Party Print' }}</p>
                                    <p class="text-muted mb-0">Service: Corporate Document Printing (RM 10.00)</p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h6 class="font-weight-bold">Total Amount</h6>
                                    <p class="h5 text-success mb-0">MYR {{ number_format($fpx_txnAmount, 2) }}</p>
                                    <small class="text-muted">Fixed printing fee</small>
                                </div>
                            </div>

                            <!-- Third Party Information -->
                            <div class="alert alert-success mb-4">
                                <h6 class="alert-heading"><i class="fas fa-building me-2"></i>Corporate Third Party Information</h6>
                                <p class="mb-1"><strong>Name:</strong> {{ $fpx_buyerName }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $fpx_buyerEmail }}</p>
                                <p class="mb-0"><strong>Service:</strong> Corporate Document Print - Third Party Access</p>
                            </div>

                            <!-- FPX Payment Form -->
                            <form name="form1" method="post" action="{{ $actionUrl }}">
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
                                
                                <!-- Payment Button -->
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                        <i class="fa fa-print mr-2"></i>Proceed to Corporate FPX Payment - RM 10.00
                                    </button>
                                </div>

                                <!-- FPX Logo -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/images/Logo-FPX.png') }}" alt="FPX Payment" class="img-fluid" style="max-width: 100px;">
                                    <p class="text-muted mt-2 mb-0">Secure Corporate Online Banking Payment</p>
                                </div>

                                <!-- Corporate Instructions -->
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">Corporate Payment Instructions</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>This is a <strong>corporate third party document print service</strong> with fixed fee of RM 10.00</li>
                                        <li>You must have corporate Internet Banking access to make B2B transactions</li>
                                        <li>Corporate payments may require authorization from multiple parties</li>
                                        <li>Please ensure you have the necessary corporate banking permissions</li>
                                        <li>Do not close the browser or refresh the page during the transaction</li>
                                        <li><strong>Each corporate print requires a separate payment of RM 10.00</strong></li>
                                    </ul>
                                </div>

                                <!-- Corporate Notice -->
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">Corporate Service Notice</h6>
                                    <p class="mb-0">
                                        <strong>Note:</strong> This payment is for corporate third party document printing service. 
                                        You are accessing this service on behalf of a corporate entity. 
                                        Each corporate print session requires a separate payment of RM 10.00.
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-footer text-center py-3 bg-light">
                        <a href="{{ route('applications.search') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Search
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-white">
                        Copyright © {{ date('Y') }} JPS. All rights reserved. | Corporate Third Party Services
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>