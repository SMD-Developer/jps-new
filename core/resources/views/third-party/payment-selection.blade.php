<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Third Party Payment Selection | JPS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        .payment-form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        .btn-section {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
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
        .third-party-notice {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #0066cc;
        }
        .fpx-logo-inline {
            height: 70px;
            width: auto;
            vertical-align: middle;
            margin-left: 8px;
        }
        .bank-list-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 12px;
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
        .btn-proceed:disabled {
            background: #6c757d !important;
            cursor: not-allowed !important;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Header -->
                <div class="text-center mb-4">
                    <p class="text-white mb-0">Document Print Payment Selection</p>
                </div>

                <!-- Payment Card -->
                <div class="payment-form-container">
                    <!-- Third Party Notice -->
                    <div class="third-party-notice">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Third Party Document Print Service</strong><br>
                        You are about to pay RM 1.00 for printing documents as a third party. This is a fixed service charge for document printing.
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        const paymentAmount = 1.00; 

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
                    // Fallback banks
                    const fallbackBanks = [
                        {code: 'TEST0021', name: 'SBI Bank A'},
                        {code: 'TEST0022', name: 'SBI Bank B'},
                        {code: 'TEST0023', name: 'SBI Bank C'}
                    ];
                    
                    fallbackBanks.forEach(bank => {
                        bankOptions += `<option value="${bank.code}">${bank.name}</option>`;
                    });
                }
                
                $('#bankSelect').html(bankOptions);
            })
            .catch(error => {
                console.error('Error loading banks:', error);
                // Use fallback banks on error
                const fallbackBanks = [
                    {code: 'TEST0021', name: 'SBI Bank A'},
                    {code: 'TEST0022', name: 'SBI Bank B'},
                    {code: 'TEST0023', name: 'SBI Bank C'}
                ];
                
                let bankOptions = '<option value="">Select Bank</option>';
                fallbackBanks.forEach(bank => {
                    bankOptions += `<option value="${bank.code}">${bank.name}</option>`;
                });
                $('#bankSelect').html(bankOptions);
            });
        }

        // Bank selection change
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
                    displayValidationMessage(validation);
                    window.validationResult = validation;
                }
            } else {
                $('#validationMessage').hide();
                window.validationResult = null;
            }
            
            validateForm();
        });
        
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

        // B2C validation function
        function validateB2CPayment(amount, bankCode) {
            const validationRules = {
                minAmount: 1.00,
                maxAmount: 30000.00,
                currency: 'RM'
            };

            const validationResult = {
                isValid: true,
                errors: [],
                testCase: 'Payment Validated Successfully'
            };

            // For third party, amount is fixed at RM 10.00, so it should always be valid
            if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
                validationResult.isValid = true;
            } else {
                validationResult.isValid = false;
                validationResult.errors.push(`Amount validation failed`);
            }

            return validationResult;
        }
        
        // B2B validation function
        function validateB2BPayment(amount, bankCode) {
            const validationRules = {
                minAmount: 2.00,
                maxAmount: 1000000.00,
                currency: 'RM'
            };

            const validationResult = {
                isValid: true,
                errors: [],
                testCase: 'Payment Validated Successfully'
            };

            // For third party, amount is fixed at RM 10.00, so it should always be valid
            if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
                validationResult.isValid = true;
            } else {
                validationResult.isValid = false;
                validationResult.errors.push(`Amount validation failed`);
            }

            return validationResult;
        }

        $('input[name="email"], #agreeTerms').on('input change', validateForm);
    });
    </script>
</body>
</html>