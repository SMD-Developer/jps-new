@extends('third-party.layouts.app')

@section('title', 'Third Party Corporate Payment | JPS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h6 class="mb-0"><strong><i class="fas fa-building me-2"></i>THIRD PARTY CORPORATE PAYMENT</strong></h6>
                </div>
                
                <div class="card-body p-0">
                    <div class="bg-light p-3 border-bottom">
                        <h6 class="text-center mb-0 text-dark">FPX B2B Payment Gateway</h6>
                    </div>
                    
                    <div class="p-4">
                        <!-- Payment Information -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h6 class="font-weight-bold">Service Description</h6>
                                <p class="text-muted mb-1">Third Party Corporate Document Print Service</p>
                                <p class="text-muted mb-0">No Rujukan: {{ $referenceNo ?? 'Third Party Corporate Document' }}</p>
                                <p class="text-muted mb-0">Service Type: Corporate Document Printing</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <h6 class="font-weight-bold">Total Amount</h6>
                                <p class="h5 text-success mb-0">MYR {{ number_format($fpx_txnAmount, 2) }}</p>
                                <small class="text-muted">Fixed printing fee</small>
                            </div>
                        </div>

                        <!-- Corporate Information -->
                        <div class="alert alert-success mb-4">
                            <h6 class="alert-heading"><i class="fas fa-building me-2"></i>Corporate Third Party Information</h6>
                            <p class="mb-1"><strong>Name:</strong> {{ $fpx_buyerName }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $fpx_buyerEmail }}</p>
                            <p class="mb-0"><strong>Service Fee:</strong> RM {{ number_format($fpx_txnAmount, 2) }} per document print</p>
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
                            
                            <!-- Test Case Information (if applicable) -->
                            @if(isset($testCase))
                                <div class="alert alert-info mb-4">
                                    <h6 class="alert-heading">Test Mode</h6>
                                    <p class="mb-1"><strong>Test Case:</strong> {{ $testCase }}</p>
                                    <p class="mb-0"><strong>Bank:</strong> {{ $fpx_buyerBankBranch }} ({{ $fpx_buyerBankId }})</p>
                                </div>
                            @endif

                            <!-- Payment Button -->
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-3">
                                    <i class="fa fa-lock mr-2"></i>Proceed to Corporate FPX Payment
                                </button>
                            </div>

                            <!-- FPX Logo -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/Logo-FPX.png') }}" alt="FPX Payment" class="img-fluid" style="max-width: 100px;">
                                <p class="text-muted mt-2 mb-0">Secure Corporate Online Banking Payment</p>
                            </div>

                            <!-- Important Instructions -->
                            <div class="alert alert-warning">
                                <h6 class="alert-heading">Corporate Payment Instructions</h6>
                                <ul class="mb-0 pl-3">
                                    <li>This is a <strong>corporate third party document print service</strong></li>
                                    <li>You must have corporate Internet Banking access to make B2B transactions</li>
                                    <li>Corporate payments may require authorization from multiple parties</li>
                                    <li>Please ensure you have the necessary corporate banking permissions</li>
                                    <li>Please disable your browser's pop-up blocker to avoid interruptions during the transaction</li>
                                    <li>Do not close the browser or refresh the page until you receive a response</li>
                                    <li>This transaction is secure and encrypted</li>
                                </ul>
                            </div>

                            <!-- Corporate Notice -->
                            <div class="alert alert-info">
                                <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Corporate Service Notice</h6>
                                <p class="mb-0">
                                    <strong>Note:</strong> This payment is for corporate third party document printing service. 
                                    You are accessing this service on behalf of a corporate entity.
                                </p>
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
</div>

<style>
    .card {
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40,167,69,0.3);
    }
    .alert {
        border-radius: 8px;
        border: none;
    }
</style>
@endsection