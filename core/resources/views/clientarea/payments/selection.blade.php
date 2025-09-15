@extends('clientarea.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
.payment-form-container {
    max-width: 600px;
    margin: 30px auto;
    padding: 40px;
    background: #ffffff;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.fpx-header {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.fpx-logo {
    background: #ffc107;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: bold;
    margin-right: 15px;
}

.form-row {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    min-height: 40px;
}

.form-label {
    width: 140px;
    font-weight: 600;
    color: #333;
    margin-bottom: 0;
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

.terms-section {
    margin: 25px 0;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.form-check-input {
    margin-right: 8px;
}

.btn-section {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
}

.btn-proceed {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
}

.btn-cancel {
    background: #6c757d;
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.validation-message {
    margin-top: 8px;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 13px;
    display: none;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.bank-list-note {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
    font-size: 12px;
}

.btn-proceed:disabled {
    background: #6c757d !important;
    cursor: not-allowed !important;
    opacity: 0.6;
}

.validation-failed {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2) !important;
}

.fpx-logo-inline {
    height: 70px;
    width: auto;
    vertical-align: middle;
    margin-left: 8px;
}

/* Custom SweetAlert2 styling */
.swal2-popup.limit-exceeded-modal {
    background: #fff;
    border: 2px solid #dc3545;
}

.swal2-popup.limit-exceeded-modal .swal2-title {
    color: #721c24;
    font-size: 18px;
}

.swal2-popup.limit-exceeded-modal .swal2-content {
    color: #721c24;
}

.reprint-notice {
    background: #e7f3ff;
    border: 1px solid #b3d9ff;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    color: #0066cc;
}
</style>

<title>Payment Selection | JPS</title>

@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-credit-card" aria-hidden="true"></i> Payment Selection</h5>
</div>

<section class="content">
    <div class="payment-form-container">
        @if(request()->get('type') === 'reprint')
        <div class="reprint-notice">
            <i class="bi bi-info-circle-fill"></i>
            <strong>Receipt Reprint Payment</strong><br>
            You are about to pay RM 10.00 for reprinting your receipt. This is a service charge for generating a duplicate copy of your receipt.
        </div>
        @endif
        
        <!-- FPX Header -->
        <div class="fpx-header">
            <div>
                <h5 style="margin: 0; color: #0066cc;">
                    Pay with 
                    <img src="{{ asset('assets/images/Logo-FPX.png') }}" 
                         alt="FPX Logo" 
                         class="fpx-logo-inline">
                </h5>
            </div>
        </div>

        <form id="paymentSelectionForm" method="POST" action="{{ route('process.payment.selection') }}">
            @csrf
            
            <input type="hidden" name="payment_type" value="{{ request()->get('type', 'original') }}">
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            
            <!-- Email Address -->
            <div class="form-row">
                <label class="form-label">Email Address:</label>
                <input type="email" name="email" class="form-control" 
                       value="{{ $application->email ?? '' }}" 
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
                    <select name="selected_bank" id="bankSelect" class="form-select" style="width: 385px;">
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
                       value="RM {{ request()->get('type') === 'reprint' ? '10.00' : number_format($application->final_amount, 2) }}" 
                       readonly style="background-color: #f8f9fa;">
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
                    @if(request()->get('type') === 'reprint')
                        Pay RM 10.00 for Reprint
                    @else
                        Proceed
                    @endif
                </button>
                <button type="button" class="btn-cancel" onclick="window.history.back()">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    const isReprint = $('input[name="payment_type"]').val() === 'reprint';
    const paymentAmount = isReprint ? 10.00 : {{ $application->final_amount ?? 0 }};

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
            ? 'Display Bank List via drop-down (B2C)' 
            : 'Display Corporate Bank List via drop-down (B2B)';
        
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
            let bankOptions = '<option value="">Select Bank</option>';
            
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
                // Fallback test banks
                const fallbackBanks = [];
                
                if (paymentMode === 'b2c') {
                    fallbackBanks.push(
                        { code: 'SBI_BANK_A', name: 'SBI Bank A (SBI_BANK_A) - Test Case 1.1 Valid Account' },
                        { code: 'SBI_BANK_B', name: 'SBI Bank B (SBI_BANK_B) - Test Case 2.3 Insufficient Funds' }
                    );
                } else if (paymentMode === 'b2b') {
                    fallbackBanks.push(
                        { code: 'SBI_BANK_A', name: 'SBI Bank A (SBI_BANK_A) - Test Case 1.1 Valid Account' },
                        { code: 'SBI_BANK_B', name: 'SBI Bank B (SBI_BANK_B) - Test Cases 2.1/2.2/2.3 Various Scenarios' }
                    );
                }
                
                fallbackBanks.sort((a, b) => a.name.localeCompare(b.name));
                
                fallbackBanks.forEach(bank => {
                    bankOptions += `<option value="${bank.code}">${bank.name}</option>`;
                });
            }
            
            $('#bankSelect').html(bankOptions);
        })
        .catch(error => {
            console.error('Error loading banks:', error);
            alert('Failed to load bank list. Please try again.');
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
                'Maximum Transaction Limit Exceeded RM30000' : 
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

        // Test Case 2.3 - Insufficient Funds
        if (bankCode === 'SBI_BANK_B') {
            validationResult.isValid = false;
            validationResult.errors.push('Insufficient funds in account (Test Scenario)');
            validationResult.testCase = '2.3 - Negative Scenario (Insufficient Funds)';
            return validationResult;
        }

        // Test Case 1.1 - Valid Account
        if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
            validationResult.testCase = bankCode === 'SBI_BANK_A' 
                ? '1.1 - Positive Scenario (SBI BANK A - Valid Account)' 
                : '1.1 - Positive Scenario (Valid Account)';
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

        // Test Case 2.3 - Insufficient Funds
        if (bankCode === 'SBI_BANK_B') {
            validationResult.isValid = false;
            validationResult.errors.push('Insufficient funds (Test Scenario)');
            validationResult.testCase = '2.3 - Negative Scenario';
            return validationResult;
        }

        // Test Case 1.1 - Success
        if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
            validationResult.testCase = bankCode === 'SBI_BANK_A' 
                ? '1.1 - Positive Scenario (SBI BANK A)' 
                : '1.1 - Positive Scenario (Valid Bank)';
            return validationResult;
        }

        validationResult.testCase = '3.1 - Re-query Scenario';
        validationResult.errors.push('Payment requires manual verification');
        validationResult.isValid = false;
        return validationResult;
    }
});
</script>
@endsection