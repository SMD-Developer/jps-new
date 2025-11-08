@extends('third-party.layouts.app')

@section('title', 'Third Party Corporate Payment | JPS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <!-- Header -->
            <div class="text-center mb-4">
                <h3 class="text-white mb-2">JPS - Third Party Corporate Services</h3>
                <p class="text-white mb-0">Corporate Document Print Payment Gateway</p>
            </div>

            <!-- Card -->
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
                                <p class="text-muted mb-0">Service: Corporate Document Printing (RM 1.00)</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <h6 class="font-weight-bold">Total Amount</h6>
                                <p class="h5 text-success mb-0">MYR {{ number_format($fpx_txnAmount, 2) }}</p>
                                <small class="text-muted">Fixed printing fee</small>
                            </div>
                        </div>

                        <!-- Third Party Info -->
                        <div class="alert alert-success mb-4">
                            <h6 class="alert-heading"><i class="fas fa-building me-2"></i>Corporate Third Party Information</h6>
                            <p class="mb-1"><strong>Name:</strong> {{ $fpx_buyerName }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $fpx_buyerEmail }}</p>
                            <p class="mb-0"><strong>Service:</strong> Corporate Document Print - Third Party Access</p>
                        </div>

                        <!-- FPX Payment Form -->
                        <form name="form1" method="post" action="{{ $actionUrl }}">
                            @csrf

                            <!-- Hidden FPX Inputs -->
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

                            <!-- Payment Button -->
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fa fa-print me-2"></i>
                                    Proceed to Corporate FPX Payment - RM 1.00
                                </button>
                            </div>

                            <!-- FPX Logo -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/Logo-FPX.png') }}" 
                                     alt="FPX Payment" 
                                     class="img-fluid" 
                                     style="max-width: 100px;">
                                <p class="text-muted mt-2 mb-0">Secure Corporate Online Banking Payment</p>
                            </div>

                            <!-- Instructions -->
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

                            <!-- Notice -->
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
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
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
    .third-party-badge {
        background: #28a745;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@endpush
