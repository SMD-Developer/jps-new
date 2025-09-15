@extends('clientarea.app')
<title>@lang('app.trench_contribution_bill') | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-credit-card" aria-hidden="true"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark text-center py-3">
                        <h6 class="mb-0"><strong>FPX PAYMENT GATEWAY</strong></h6>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="bg-light p-3 border-bottom">
                            <h6 class="text-center mb-0 text-dark">Payment Details</h6>
                        </div>
                        
                        <div class="p-4">
                            <!-- Payment Information -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <h6 class="font-weight-bold">Bayaran Caruman</h6>
                                    <p class="text-muted mb-0">No Rujukan : {{ $referenceNo ?? 'Trench Contribution Payment' }}</p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h6 class="font-weight-bold">Total Amount</h6>
                                    <p class="h5 text-primary mb-0">MYR {{ number_format($fpx_txnAmount, 2) }}</p>
                                </div>
                            </div>

                            <!-- FPX Payment Form -->
                            <form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp">
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
                                        <i class="fa fa-lock mr-2"></i>Proceed to FPX Payment
                                    </button>
                                </div>

                                <!-- FPX Logo -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/images/Logo-FPX.png') }}" alt="FPX Payment" class="img-fluid" style="max-width: 100px;">
                                </div>

                                <!-- Important Instructions -->
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">Important Instructions</h6>
                                    <ul class="mb-0 pl-3">
                                        <li>You must have an Internet Banking account to make transactions using FPX</li>
                                        <li>Please disable your browser's pop-up blocker to avoid interruptions during the transaction</li>
                                        <li>Do not close the browser or refresh the page until you receive a response</li>
                                        <li>This transaction is secure and encrypted</li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card-footer text-center py-2 bg-light">
                        <small class="text-muted">Copyright © {{ date('Y') }} JPS. All rights reserved.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .card {
            border-radius: 10px;
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
    </style>
@endsection