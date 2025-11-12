@extends('third-party.layouts.app')

@section('title', 'Third Party Corporate Payment | JPS')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-8">
        <!-- Header -->
        <div class="text-center mb-4">
            <h4 class="text-dark fw-bold">FPX PAYMENT GATEWAY</h4>
            <p class="text-muted mb-0">Payment Details</p>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <!-- Description -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h6 class="fw-bold text-dark mb-2">Description</h6>
                        <p class="text-muted mb-1">Permohonan Salinan Resit Caruman Parit</p>
                        <p class="text-muted mb-0">No Rujukan: {{ $referenceNo ?? 'Corporate Third Party Print' }}</p>
                    </div>
                    <div class="text-end">
                        <h6 class="fw-bold text-dark mb-2">Total Amount</h6>
                        <p class="h5 text-primary mb-0">MYR {{ number_format($fpx_txnAmount, 2) }}</p>
                    </div>
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

                <!-- FPX Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/Logo-FPX.png') }}" 
                         alt="FPX Payment" 
                         class="img-fluid"
                         style="max-width: 120px;">
                </div>

                <!-- Instructions -->
                <div class="alert alert-warning mb-0">
                    <h6 class="alert-heading fw-bold">Important Instructions</h6>
                    <ul class="mb-0 ps-3">
                        <li>You must have an Internet Banking account to make transactions using FPX.</li>
                        <li>Please disable your browser's pop-up blocker to avoid interruptions during the transaction.</li>
                        <li>Do not close or refresh the page until you receive a response.</li>
                        <li>This transaction is secure and encrypted.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: #f5f7fa;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }
    .alert-warning {
        background-color: #ffecb3;
        border: none;
        color: #5f4200;
        border-radius: 8px;
    }
</style>
@endpush