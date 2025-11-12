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
                    <!-- 🔥 ALL REQUIRED FPX PARAMETERS -->
                    <input type="hidden" name="fpx_msgType" value="{{ $fpx_msgType }}">
                    <input type="hidden" name="fpx_msgToken" value="{{ $fpx_msgToken }}">
                    <input type="hidden" name="fpx_sellerExId" value="{{ $fpx_sellerExId }}">
                    <input type="hidden" name="fpx_sellerExOrderNo" value="{{ $fpx_sellerExOrderNo }}">
                    <input type="hidden" name="fpx_sellerTxnTime" value="{{ $fpx_sellerTxnTime }}">
                    <input type="hidden" name="fpx_sellerOrderNo" value="{{ $fpx_sellerOrderNo }}">
                    <input type="hidden" name="fpx_sellerId" value="{{ $fpx_sellerId }}">
                    <input type="hidden" name="fpx_sellerBankCode" value="{{ $fpx_sellerBankCode }}">
                    <input type="hidden" name="fpx_txnCurrency" value="{{ $fpx_txnCurrency }}">
                    <input type="hidden" name="fpx_txnAmount" value="{{ $fpx_txnAmount }}">
                    <input type="hidden" name="fpx_buyerEmail" value="{{ $fpx_buyerEmail }}">
                    <input type="hidden" name="fpx_checkSum" value="{{ $fpx_checkSum }}">
                    <input type="hidden" name="fpx_buyerName" value="{{ $fpx_buyerName }}">
                    <input type="hidden" name="fpx_buyerBankId" value="{{ $fpx_buyerBankId }}">
                    <input type="hidden" name="fpx_buyerBankBranch" value="{{ $fpx_buyerBankBranch }}">
                    <input type="hidden" name="fpx_buyerAccNo" value="{{ $fpx_buyerAccNo }}">
                    <input type="hidden" name="fpx_buyerId" value="{{ $fpx_buyerId }}">
                    <input type="hidden" name="fpx_makerName" value="{{ $fpx_makerName }}">
                    <input type="hidden" name="fpx_buyerIban" value="{{ $fpx_buyerIban }}">
                    <input type="hidden" name="fpx_version" value="{{ $fpx_version }}">
                    <input type="hidden" name="fpx_productDesc" value="{{ $fpx_productDesc }}">
                    
                    <!-- 🔥 CALLBACK URLs - CRITICAL! -->
                    <input type="hidden" name="fpx_callbackUrl" value="{{ $fpx_callbackUrl }}">
                    <input type="hidden" name="fpx_returnUrl" value="{{ $fpx_returnUrl }}">

                    <div class="text-center my-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 shadow-sm">
                            <i class="fa fa-lock me-2"></i> Proceed to FPX Payment
                        </button>
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