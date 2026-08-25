@extends('third-party.layouts.app')
<style>
.payment-instructions {
    background-color: #e7f3ff;
    border-left: 4px solid #0066cc;
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.instructions-title {
    color: #0066cc;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.instructions-title i {
    font-size: 18px;
}

.instructions-list {
    margin: 0;
    padding-left: 20px;
    color: #333;
}

.instructions-list li {
    margin-bottom: 8px;
    line-height: 1.6;
    font-size: 14px;
}

.instructions-list li:last-child {
    margin-bottom: 0;
}

.instructions-list a {
    color: #0066cc;
    text-decoration: none;
    font-weight: 500;
}

.instructions-list a:hover {
    text-decoration: underline;
}
</style>
@section('title', 'Third Party Payment Selection | JPS')

@section('content')
<div class="page-wrapper">
    <div class="payment-form-container">
        <!-- Header -->

        <!-- FPX Header -->
        <div class="text-center mb-4">
            <h5 style="color: #0066cc;">
                Pembayaran Dengan
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
                <label class="form-label">Emel:</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ auth('third_party')->user()->email ?? '' }}" 
                       placeholder="Enter your email address" required>
            </div>

            <!-- Payment Mode Dropdown -->
            <div class="form-row">
                <label class="form-label">Mod Pembayaran:</label>
                <select name="payment_mode" id="paymentModeSelect" class="form-select" required>
                    <option value="">Pilih Mod Pembayaran</option>
                    <option value="b2c">B2C (Business to Consumer)</option>
                    <option value="b2b">B2B (Business to Business)</option>
                </select>
            </div>

            <!-- Bank Selection Dropdown -->
            <div class="form-row" id="bankSelectionRow" style="display: none;">
                <label class="form-label">Pilih Bank:</label>
                <div style="flex: 1;">
                    <select name="selected_bank" id="bankSelect" class="form-select" style="width: 100%;">
                        <option value="">Pilih Bank</option>
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
                <label class="form-label">Jumlah:</label>
                <input type="text" class="form-control" 
                       value="RM {{ number_format($amount, 2) }}" id="displayAmount"
                       readonly style="background-color: #f8f9fa; font-weight: bold;">
            </div>

            <!-- Terms and Conditions -->
            <div class="terms-section">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                    <label class="form-check-label" for="agreeTerms">
                        Dengan Klik butang "Teruskan", anda bersetuju dengan
                        <strong>
                            <a href="https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp" 
                               target="_blank" 
                               rel="noopener noreferrer">
                               Terma dan Syarat FPX
                            </a>
                        </strong>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="btn-section">
                <button type="submit" class="btn-proceed" id="proceedBtn" disabled>
                    Teruskan
                </button>
                <button type="button" class="btn-cancel" onclick="window.history.back()">
                    Batal
                </button>
            </div>

            <!-- Payment Instructions -->
            <div class="payment-instructions mt-2">
                <h6 class="instructions-title">
                    <i class="bi bi-info-circle-fill"></i> PANDUAN PEMBAYARAN
                </h6>
                <ol class="instructions-list">
                    <li>Pastikan anda tidak menutup laman web semasa pembayaran sedang dilakukan.</li>
                    <li>Setelah pembayaran dibuat, sila pastikan anda klik pada butang ”Lihat Resit” untuk mencetak resit SALINAN</li>
                    <li>Bagi Resit bayaran RM10.00, boleh didapati di Menu Pembayaran. Sila pastikan resit bayaran dicetak.</li>
                    <li>Untuk Mohon resit dan mod pembayaran B2B, resit SALINAN boleh didapati di Menu Pemohonan dalam tempoh 7-14 hari bekerja.</li>
                    <li>Masalah Pembayaran / Resit : Sila hubungi Unit Kewangan, Bahagian Khidmat Kewangan,  JPS Negeri Selangor di talian 03-55447376 atau emal ke <a href="mailto:ecp@selangor.gov.my">ecp@selangor.gov.my</a></li>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        const paymentAmount = {{ $amount }};
        // Payment mode selection change
        $('#paymentModeSelect').change(function() {
            const selectedMode = $(this).val();
        
            if (selectedMode === 'b2c' || selectedMode === 'b2b') {
                $('#bankSelectionRow').show();
                loadBankList();
                updateBankListNote(selectedMode);
            } else {
                $('#bankSelectionRow').hide();
            }
        
            validateForm();
        });
    
        function updateBankListNote(paymentMode) {
            const noteText = paymentMode === 'b2c'
                ? 'Select your bank from the list'
                : 'Select your corporate bank';
        
            $('.bank-list-note strong').text(noteText);
        }
    
        function loadBankList() {
            const paymentMode = $('#paymentModeSelect').val();
        
            fetch('{{ route("pay.bank.details") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                let bankOptions = '<option value="">Pilih Bank</option>';
            
                if (data.success && data.banks) {
                    const banksArray = Array.isArray(data.banks) ? data.banks : Object.entries(data.banks).map(([code, name]) => ({bank_code: code, bank_name: name}));
                
                    const filteredBanks = banksArray.filter(bank => {
                        if (paymentMode === 'b2c') {
                            return bank.type === 'B2C' || !bank.type;
                        } else if (paymentMode === 'b2b') {
                            return bank.type === 'B2B';
                        }
                        return false;
                    });
                
                    filteredBanks.sort((a, b) => {
                        const nameA = (a.display_name || a.bank_name || a.name || '').toUpperCase();
                        const nameB = (b.display_name || b.bank_name || b.name || '').toUpperCase();
                        return nameA.localeCompare(nameB);
                    });
                
                    filteredBanks.forEach(bank => {
                        const bankCode = bank.bank_code || bank.code;
                        const bankName = bank.bank_name || bank.name || bank;
                        const displayName = bank.display_name || bankName;
                        const status = bank.status || 'active';
                    
                        let optionText = `${displayName}`;
                    
                        if (status === 'inactive') {
                            optionText += ' (offline)';
                        }
                    
                        const disabled = status === 'inactive' ? 'disabled' : '';
                        const className = status === 'inactive' ? 'offline-bank' : 'online-bank';
                    
                        bankOptions += `<option value="${bankCode}" ${disabled} class="${className}">${optionText}</option>`;
                    });
                } else {
                
                    fallbackBanks.sort((a, b) => a.name.localeCompare(b.name));
                    fallbackBanks.forEach(bank => {
                        bankOptions += `<option value="${bank.code}">${bank.name}</option>`;
                    });
                }
            
                $('#bankSelect').html(bankOptions);
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to load bank list. Please refresh and try again.',
                    confirmButtonText: 'OK'
                });
            });
        }
    
        // Bank selection change with client-side blocking
        $('#bankSelect').change(function() {
            const selectedBank = $(this).val();
            const paymentMode = $('#paymentModeSelect').val();
        
            if (selectedBank) {
                let validation;
            
                if (paymentMode === 'b2c') {
                    validation = validateB2CPayment(paymentAmount, selectedBank);
                } else if (paymentMode === 'b2b') {
                    validation = validateB2BPayment(paymentAmount, selectedBank);
                }
            
                if (validation) {
                    // Client-side blocking for limit exceeded scenarios
                    if (!validation.isValid && (validation.testCase.includes('2.1') || validation.testCase.includes('2.2'))) {
                        showLimitExceededModal(validation);
                        $(this).val(''); // Reset bank selection
                        $('#validationMessage').hide();
                        window.validationResult = null;
                    } else {
                        displayValidationMessage(validation);
                        window.validationResult = validation;
                    }
                }
            } else {
                $('#validationMessage').hide();
                window.validationResult = null;
            }
        
            validateForm();
        });
    
        // Show limit exceeded alert (as per documentation Image 1)
        function showLimitExceededModal(validation) {
            let message = '';
        
            // Get the current payment mode from the select element
            const currentPaymentMode = $('#paymentModeSelect').val();
        
            if (validation.testCase.includes('2.1')) {
                message = currentPaymentMode === 'b2c' ?
                    'Maximum Transaction Limit Exceeded RM3000000' :
                    'Maximum Transaction Limit Exceeded RM1000000';
            } else if (validation.testCase.includes('2.2')) {
                message = currentPaymentMode === 'b2c' ?
                    'Transaction Amount is Lower than the Minimum Limit RM1.00' :
                    'Transaction Amount is Lower than the Minimum Limit RM2.00';
            }
        
            alert(message);
        }
    
        function displayValidationMessage(validation) {
            const messageDiv = $('#validationMessage');
        
            if (validation.isValid) {
                messageDiv.removeClass('alert-danger').addClass('alert-success').show();
                messageDiv.html(`<i class="bi bi-check-circle"></i> <strong>${validation.testCase}</strong> - Payment can proceed`);
            } else {
                messageDiv.removeClass('alert-success').addClass('alert-danger').show();
                messageDiv.html(`<i class="bi bi-exclamation-triangle"></i> <strong>${validation.testCase}</strong><br>${validation.errors.join('<br>')}`);
            }
        }
    
        // Form validation
        function validateForm() {
            const paymentMode = $('#paymentModeSelect').val();
            const email = $('input[name="email"]').val();
            const termsAccepted = $('#agreeTerms').is(':checked');
            let bankSelected = true;
            let validationPassed = true;
        
            if (paymentMode === 'b2c' || paymentMode === 'b2b') {
                bankSelected = $('#bankSelect').val() !== '';
            
                if (bankSelected && window.validationResult) {
                    validationPassed = window.validationResult.isValid;
                } else if (bankSelected) {
                    const selectedBank = $('#bankSelect').val();
                    let validation;
                
                    if (paymentMode === 'b2c') {
                        validation = validateB2CPayment(paymentAmount, selectedBank);
                    } else {
                        validation = validateB2BPayment(paymentAmount, selectedBank);
                    }
                
                    validationPassed = validation.isValid;
                    window.validationResult = validation;
                }
            }
        
            if (paymentMode && email && termsAccepted && bankSelected && validationPassed) {
                $('#proceedBtn').prop('disabled', false);
            } else {
                $('#proceedBtn').prop('disabled', true);
            }
        }
    
        // Form submission validation
        $('#paymentSelectionForm').on('submit', function(e) {
            const paymentMode = $('#paymentModeSelect').val();
            const selectedBank = $('#bankSelect').val();
        
            if ((paymentMode === 'b2c' || paymentMode === 'b2b') && selectedBank) {
                let validation;
            
                if (paymentMode === 'b2c') {
                    validation = validateB2CPayment(paymentAmount, selectedBank);
                } else {
                    validation = validateB2BPayment(paymentAmount, selectedBank);
                }
            
                if (!validation.isValid) {
                    e.preventDefault();
                
                    // Show appropriate alert for limit scenarios
                    if (validation.testCase.includes('2.1') || validation.testCase.includes('2.2')) {
                        showLimitExceededModal(validation);
                    } else {
                        alert('Payment Validation Failed: ' + validation.errors.join(', '));
                    }
                    return false;
                }
            }
        });
    
        $('input[name="email"], #agreeTerms').on('input change', validateForm);
    
        // B2C validation function (updated with exact documentation messages)
        function validateB2CPayment(amount, bankCode) {
            const validationRules = {
                minAmount: 1.00,
                maxAmount: 30000.00,
                currency: 'RM'
            };
    
            const validationResult = {
                isValid: true,
                errors: [],
                testCase: null
            };
    
            // Test Case 2.1 - Maximum Scenario
            if (amount > validationRules.maxAmount) {
                validationResult.isValid = false;
                validationResult.errors.push(`Maximum Transaction Limit Exceeded (Maximum: ${validationRules.currency}${validationRules.maxAmount.toLocaleString()})`);
                validationResult.testCase = '2.1 - Maximum Scenario (Exceeded Amount)';
                return validationResult;
            }
    
            // Test Case 2.2 - Minimum Scenario (updated message to match documentation)
            if (amount < validationRules.minAmount) {
                validationResult.isValid = false;
                validationResult.errors.push(`Transaction Amount is Lower Than Minimum Limit (Minimum: ${validationRules.currency}${validationRules.minAmount.toFixed(2)})`);
                validationResult.testCase = '2.2 - Minimum Scenario (Below Minimum)';
                return validationResult;
            }
    
            // Test Case 1.1 - Valid Account
            if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
                validationResult.testCase = 'Payment Validated Successfully';
                return validationResult;
            }
    
            validationResult.testCase = '4.1 - Retrieved Bank List';
            return validationResult;
        }
    
        // B2B validation function (updated with exact documentation messages)
        function validateB2BPayment(amount, bankCode) {
            const validationRules = {
                minAmount: 2.00,
                maxAmount: 1000000.00,
                currency: 'RM'
            };
    
            const validationResult = {
                isValid: true,
                errors: [],
                testCase: null
            };
    
            // Test Case 2.1 - Maximum Amount
            if (amount > validationRules.maxAmount) {
                validationResult.isValid = false;
                validationResult.errors.push(`Maximum Transaction Limit Exceeded (Maximum: ${validationRules.currency}${validationRules.maxAmount.toLocaleString()})`);
                validationResult.testCase = '2.1 - Maximum Scenario';
                return validationResult;
            }
    
            // Test Case 2.2 - Minimum Amount (updated message)
            if (amount < validationRules.minAmount) {
                validationResult.isValid = false;
                validationResult.errors.push(`Transaction Amount is Lower Than Minimum Limit (Minimum: ${validationRules.currency}${validationRules.minAmount.toFixed(2)})`);
                validationResult.testCase = '2.2 - Minimum Scenario';
                return validationResult;
            }
    
            // Test Case 1.1 - Success
            if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
                validationResult.testCase = 'Payment Validated Successfully';
                return validationResult;
            }
    
            validationResult.testCase = '3.1 - Re-query Scenario';
            validationResult.errors.push('Payment requires manual verification');
            validationResult.isValid = false;
            return validationResult;
        }
    });
</script>
@endpush
