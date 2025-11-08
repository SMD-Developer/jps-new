@extends('third-party.layouts.app')

@section('title', 'Third Party Payment Selection | JPS')

@section('content')
<div class="page-wrapper">
    <div class="payment-form-container">
        <!-- Header -->
        <div class="text-center mb-4">
            <p class="text-black mb-0 fw-bold">Document Print Payment Selection</p>
        </div>

        <!-- Third Party Notice -->
        <div class="third-party-notice">
            <i class="bi bi-info-circle-fill"></i>
            <strong>Third Party Document Print Service</strong><br>
            You are about to pay RM 1.00 for printing documents as a third party. 
            This is a fixed service charge for document printing.
        </div>

        <!-- FPX Header -->
        <div class="text-center mb-4">
            <h5 style="color: #0066cc;">
                Pay with 
                <img src="{{ asset('assets/images/Logo-FPX.png') }}" 
                     alt="FPX Logo" 
                     class="fpx-logo-inline">
            </h5>
        </div>

        <form id="paymentSelectionForm" method="POST" action="{{ route('third.party.process.payment.selection') }}">
            @csrf
            
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            
            <!-- Email Address -->
            <div class="form-row">
                <label class="form-label">Email Address:</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ auth('third_party')->user()->email ?? '' }}" 
                       placeholder="Enter your email address" required>
            </div>

            <!-- Payment Mode Dropdown -->
            <div class="form-row">
                <label class="form-label">Payment Mode:</label>
                <select name="payment_mode" id="paymentModeSelect" class="form-select" required>
                    <option value="">Select Payment Mode</option>
                    <option value="b2c">B2C (Business to Consumer)</option>
                    <option value="b2b">B2B (Business to Business)</option>
                </select>
            </div>

            <!-- Bank Selection Dropdown -->
            <div class="form-row" id="bankSelectionRow" style="display: none;">
                <label class="form-label">Select Bank:</label>
                <div style="flex: 1;">
                    <select name="selected_bank" id="bankSelect" class="form-select" style="width: 100%;">
                        <option value="">Select Bank</option>
                    </select>
                    <div class="bank-list-note">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Display Bank List via drop-down</strong> - Retrieved from FPX system
                    </div>
                    <div id="validationMessage" class="validation-message"></div>
                </div>
            </div>

            <!-- Payment Amount -->
            <div class="form-row">
                <label class="form-label">Amount:</label>
                <input type="text" class="form-control" 
                       value="RM {{ number_format($amount, 2) }}" 
                       readonly style="background-color: #f8f9fa; font-weight: bold;">
            </div>

            <!-- Terms and Conditions -->
            <div class="terms-section">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                    <label class="form-check-label" for="agreeTerms">
                        By clicking on "Proceed" button, you hereby agree with 
                        <strong>
                            <a href="https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" 
                               target="_blank" 
                               rel="noopener noreferrer">
                               FPX's Terms & Condition
                            </a>
                        </strong>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="btn-section">
                <button type="submit" class="btn-proceed" id="proceedBtn" disabled>
                    Proceed to Pay RM 1.00
                </button>
                <button type="button" class="btn-cancel" onclick="window.history.back()">
                    Cancel
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-4">
            <small class="text-muted">
                © {{ date('Y') }} JPS. All rights reserved. | Third Party Services
            </small>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
    }

    /* Wrapper to center content */
    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .payment-form-container {
        width: 100%;
        max-width: 600px;
        background: #ffffff;
        padding: 15px 35px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .form-label {
        width: 140px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .form-control, .form-select {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0066cc;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.2);
    }

    .third-party-notice {
        background: #e7f3ff;
        border: 1px solid #b3d9ff;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        color: #0066cc;
        font-size: 14px;
    }

    .fpx-logo-inline {
        height: 60px;
        width: auto;
        vertical-align: middle;
        margin-left: 8px;
    }

    .terms-section {
        margin: 25px 0;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .btn-section {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-proceed {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-proceed:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(23,162,184,0.4);
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-proceed:disabled {
        background: #6c757d !important;
        cursor: not-allowed !important;
        opacity: 0.6;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            align-items: flex-start;
        }
        .form-label {
            width: 100%;
        }
        .btn-section {
            flex-direction: column;
        }
        .btn-proceed, .btn-cancel {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // You can paste your existing jQuery logic here
</script>
@endpush
