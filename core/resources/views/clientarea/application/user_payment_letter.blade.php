@extends('clientarea.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* General Styles */
    body {
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }

    .col-md-3.px-0 {
        font-size: 12px;
    }
    
    /* Payment Modal Styles */
    .payment-option-card {
        cursor: pointer;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .payment-option-card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,123,255,.25);
        transform: translateY(-2px);
    }
    
    .payment-option-card.selected {
        border-color: #28a745;
        background-color: #f8f9fa;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,.3);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

</style>
<title>@lang('app.trench_contribution_bill') | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-envelope" aria-hidden="true"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content">
        <div id="letter-content">
            <div class="container middle-body">
                <div class="row mt-3 head-row">
                    <div class="col-md-2">
                    <img src="{{ asset('assets/images/admin-images/Picture1-removebg-preview.png') }}" style="margin-bottom: 10px;" class="img-fluid img1 float-right"
                        alt="..." width="90%;">
                </div>
                    <div class="col-md-5">
                        <p class="mb-0 head-1"><b>@lang('JABATAN PENGAIRAN DAN SALIRAN NEGERI SELANGOR')</b></p>
                        <p class="mb-0 head-1">@lang('(SELANGOR STATE IRRIGATION AND DRAINAGE DEPARTMENT)')</p>
                        <p class="mb-0 head-1"><b>@lang('TINGKAT 5,BLOK PODIUM SELATAN')</b></p>
                        <p class="mb-0 head-1"><b>@lang('BANGUNAN SULTAN SALAHUDDIN ABDUL AZIZ SHAH')</b></p>
                        <p class="mb-0 head-1"><b>@lang('40626 SHAH ALAM,SELANGOR')</b></p>
                    </div>
                    <div class="col-md-3 px-0">
                        <i class="bi bi-telephone-forward-fill" style="font-size: 13px;"> </i> : 03-5544 7376/7586 <br>
                        <i class="bi bi-telephone-forward-fill" style="font-size: 13px;"> </i> : 03-5521 2204/2205/2207 <br>
                        <i class="bi bi-printer" style="font-size: 13px;"> </i> : 03-5544 2911/5510 4494 <br>
                        <i class="bi bi-envelope-arrow-up" style="font-size: 13px;"> </i> : webmaster@waterselangor.gov.my
                        <br>
                        <i class="bi bi-globe" style="font-size: 13px;"> </i> : http://water.selangor.gov.my
                    </div>
                    <div class="col-md-2 pl-0">
                        <img src="{{ asset('assets/images/admin-images/logo-jps-(tran)(wordwhite).png') }}"
                            class="img-fluid img2 float-left" alt="...">
                    </div>
                </div>
            </div>
            <div class="container middle-body">
                <div class="row mt-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <img src="{{ asset('assets/images/admin-images/logo-kita-selangor.png') }}" class="img-fluid img3"
                            alt="..." width="60%">
                    </div>
                    <div class="col-md-2 ruj text-left">
                        <!--<p class="mb-0">Ruj. Tuan</p>-->
                        <p class="mb-0">Ruj. Kami</p>
                        <p>Tarikh</p>
                    </div>
                    <div class="col-md-2 text-left p-0">
                        <p class="mb-0" style="white-space: nowrap;">:{{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
                        <p class="mb-0">
                            : {{ App\Helpers\DateHelper::formatMalayDate($application->created_at) }}
                        </p>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <p class="mb-0"> Tetuan {{ $application->applicant }}</p>
                        <p class="mb-0">{{ $application->address }}</p>
                        <p class="mb-0">{{ $application->city }}, {{ $application->postal_code }}</p>
                        <br>
                        <p class="">Tuan,</p>
                        <h6 class="mb-0 text-justify"><b>PENGESAHAN BAYARAN CARUMAN PARIT DI {{strtoupper($application->land_lot)}}, {{ strtoupper($application->land_mukim ?? 'N/A') }}, DAERAH {{ strtoupper($application->land_daerah ?? 'N/A') }}, NEGERI SELANGOR UNTUK TETUAN {{strtoupper($application->applicant)}}.</b></h6>
                        </h6>
                        <p class="pengesahan"><strong>-Pengesahan Bayaran Caruman Parit</strong></p>
                        <p>Dengan segala hormatnya saya diarahkan merujuk kepada perkara tersebut di atas.</p>
                        <p style="text-align:justify;">
                            2. Berdasarkan geran tanah dan dokumen sokongan yang dilampirkan, keluasan tanah yang perlu di bayar ialah
                            <b>{{ number_format($application->hectare, 2) }} hektar</b>. Oleh yang demikian pihak tuan adalah
                            dikehendaki membayar caruman parit ke jabatan ini <b>berjumlah RM
                                {{ number_format($application->final_amount, 2) }}
                                (RM {{ number_format($application->cost, 2) }} x {{ number_format($application->hectare, 2) }} hektar).
                        </p>
                        <p>Sekian, terima kasih.</p>
                        <p class="mb-0"><b>"#KITASELANGOR MAJU BERSAMA"</b></p>
                        <p class="mb-0"><b>"MALAYSA MADANI"</b></p>
                        <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                        <p>Saya yang menjalankan amanah,</p>
                        <p class="mb-0"><b>Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                        <!--<p><b>Selangor</b></p>-->
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row last_row mt-4">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 mt-4">
                       <p class="last_para" style="color: grey;";>@lang('app.computer_printout')</p>
                    </div>
                    <div class="col-md-2"></div>
                </div>

            </div>
        </div>
        <div class="container middle-body">
            <div class="row last_row">
                <div class="col-md-6"></div>
                <div class="col-6 float-right mt-5 col6">
                    <button type="button" class="btn btn-primary me-2 float-right mx-3" id="downloadButton">
                        @lang('app.download')
                    </button>
                    <a href="{{ route('original_receipts', ['application_id' => $application->id]) }}" type="button"
                        id="makePaymentButton" class="btn btn-danger float-right"
                        data-application-id="{{ $application->id }}">
                        @lang('app.please_make_payment')
                    </a>
                    <!--<a href="{{ route('pay.details.b2c') }}" type="button" class="btn btn-success float-right ml-3">-->
                    <!--    Click to Pay B2C-->
                    <!--</a>-->
                    <!--<a href="{{ route('pay.details.b2b') }}" type="button" class="btn btn-success float-right ml-3">-->
                    <!--    Click to Pay B2B-->
                    <!--</a>-->
                </div>
            </div>
        </div>
        <!-- Payment Selection Modal -->
        <div class="modal fade" id="paymentSelectionModal" tabindex="-1" aria-labelledby="paymentSelectionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentSelectionModalLabel">
                            <i class="bi bi-credit-card"></i> @lang('app.select_payment_type')
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="mb-4">@lang('app.please_select_payment_method')</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card payment-option-card h-100" onclick="selectPaymentType('b2c')">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-person-circle" style="font-size: 3rem; color: #28a745; margin-bottom: 1rem;"></i>
                                        <h6 class="card-title">B2C Payment</h6>
                                        <p class="card-text text-muted small">Business to Consumer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card payment-option-card h-100" onclick="selectPaymentType('b2b')">
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-building" style="font-size: 3rem; color: #007bff; margin-bottom: 1rem;"></i>
                                        <h6 class="card-title">B2B Payment</h6>
                                        <p class="card-text text-muted small">Business to Business</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> @lang('app.cancel')
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
    
    document.getElementById('makePaymentButton').addEventListener('click', function(event) {
        event.preventDefault();
        // Redirect to payment selection page instead of showing modal
        window.location.href = '{{ route("payment.selection", $application->id) }}';
    });


    function showPaymentSelectionModal() {
        // Show the payment selection modal
        const modal = new bootstrap.Modal(document.getElementById('paymentSelectionModal'));
        modal.show();
    }
    
    function selectPaymentType(paymentType) {
        if (paymentType === 'b2c') {
            $('#paymentSelectionModal').modal('hide');
            setTimeout(() => {
                showB2CValidationForm();
            }, 300);
        } else {
            $('#paymentSelectionModal').modal('hide');
            setTimeout(() => {
                showPaymentConfirmationPopup(paymentType);
            }, 300);
        }
    }

    function showPaymentSelectionModal() {
        $('#paymentSelectionModal').modal('show');
    }


function closeModal() {
    try {
        // Try Bootstrap 5 method first
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalElement = document.getElementById('paymentSelectionModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            } else {
                // Create new instance and hide
                const modal = new bootstrap.Modal(modalElement);
                modal.hide();
            }
        }
    } catch (error) {
        // Fallback to jQuery/Bootstrap 4
        if (typeof $ !== 'undefined') {
            $('#paymentSelectionModal').modal('hide');
        }
    }
}

    
    function showB2CValidationForm() {
        const paymentAmount = {{ $application->final_amount ?? 0 }};
        
        // First, fetch the bank list dynamically from your existing route
        fetch('{{ route("pay.bank.details") }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            let bankOptions = '<option value="">Choose Bank...</option>';
            
            if (data.success && data.banks) {
                // Handle both array and object formats
                const banksArray = Array.isArray(data.banks) ? data.banks : Object.entries(data.banks).map(([code, name]) => ({bank_code: code, bank_name: name}));
                
                banksArray.forEach(bank => {
                    const bankCode = bank.bank_code || bank.code;
                    const bankName = bank.bank_name || bank.name || bank;
                    
                    // Display bank name with code in brackets
                    let displayName = `${bankName} (${bankCode})`;
                    
                    // Add test scenario indicators based on B2C test cases
                    if (bankCode === 'SBI_BANK_A') {
                        displayName += ' - Test Case 1.1 Valid Account';
                    } else if (bankCode === 'SBI_BANK_B') {
                        displayName += ' - Test Case 2.3 Insufficient Funds';
                    }
                    
                    bankOptions += `<option value="${bankCode}">${displayName}</option>`;
                });
            } else {
                // Fallback banks for test cases with code in brackets
                bankOptions += `
                    <option value="SBI_BANK_A">SBI Bank A (SBI_BANK_A) - Test Case 1.1 Valid Account</option>
                    <option value="SBI_BANK_B">SBI Bank B (SBI_BANK_B) - Test Case 2.3 Insufficient Funds</option>
                `;
            }
            
            Swal.fire({
                title: 'B2C Payment Validation',
                width: '600px',
                html: `
                    <div class="mb-3">
                        <label class="form-label"><strong>Payment Amount: RM ${paymentAmount.toFixed(2)}</strong></label>
                        <small class="text-muted d-block">Valid range: RM1.00 - RM30,000.00</small>
                    </div>
                    <div class="mb-3">
                        <label for="bankSelect" class="form-label">Select Bank:</label>
                        <select id="bankSelect" class="form-select">
                            ${bankOptions}
                        </select>
                    </div>
                    <div id="validationMessage" class="mt-3"></div>
                    <div class="mt-3">
                        <small class="text-info">
                            <i class="bi bi-info-circle"></i> 
                            Test Cases: 1.1 (Valid), 2.1 (Max Exceeded), 2.2 (Below Min), 2.3 (Insufficient Funds)
                        </small>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Proceed to Payment',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                preConfirm: () => {
                    const selectedBank = document.getElementById('bankSelect').value;
                    if (!selectedBank) {
                        Swal.showValidationMessage('Please select a bank');
                        return false;
                    }
                    
                    // Validate the payment according to B2C test cases
                    const validation = validateB2CPayment(paymentAmount, selectedBank);
                    
                    if (!validation.isValid) {
                        Swal.showValidationMessage(validation.errors.join('<br>'));
                        return false;
                    }
                    
                    return { bank: selectedBank, amount: paymentAmount, validation: validation };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleB2CPaymentResult(result.value);
                }
            });
            
            // Add bank selection change listener for real-time validation
            setTimeout(() => {
                document.getElementById('bankSelect').addEventListener('change', function() {
                    const selectedBank = this.value;
                    const amount = paymentAmount;
                    
                    if (selectedBank) {
                        const validation = validateB2CPayment(amount, selectedBank);
                        const messageDiv = document.getElementById('validationMessage');
                        
                        if (validation.isValid) {
                            messageDiv.innerHTML = `
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle"></i> 
                                    <strong>${validation.testCase}</strong><br>
                                    Payment can proceed - All validations passed
                                </div>`;
                        } else {
                            messageDiv.innerHTML = `
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle"></i> 
                                    <strong>${validation.testCase}</strong><br>
                                    ${validation.errors.join('<br>')}
                                </div>`;
                        }
                    }
                });
            }, 100);
            
        })
        .catch(error => {
            console.error('Error fetching banks:', error);
            
            // Show fallback form with test banks
            Swal.fire({
                title: 'B2C Payment Validation',
                html: `
                    <div class="mb-3">
                        <label class="form-label"><strong>Payment Amount: RM ${paymentAmount.toFixed(2)}</strong></label>
                    </div>
                    <div class="mb-3">
                        <label for="bankSelect" class="form-label">Select Bank:</label>
                        <select id="bankSelect" class="form-select">
                            <option value="">Choose Bank...</option>
                            <option value="SBI_BANK_A">SBI Bank A (SBI_BANK_A) - Test Case 1.1 Valid Account</option>
                            <option value="SBI_BANK_B">SBI Bank B (SBI_BANK_B) - Test Case 2.3 Insufficient Funds</option>
                        </select>
                    </div>
                    <div id="validationMessage" class="mt-3"></div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Proceed to Payment',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const selectedBank = document.getElementById('bankSelect').value;
                    if (!selectedBank) {
                        Swal.showValidationMessage('Please select a bank');
                        return false;
                    }
                    
                    const validation = validateB2CPayment(paymentAmount, selectedBank);
                    if (!validation.isValid) {
                        Swal.showValidationMessage(validation.errors.join('<br>'));
                        return false;
                    }
                    
                    return { bank: selectedBank, amount: paymentAmount, validation: validation };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleB2CPaymentResult(result.value);
                }
            });
            
            // Add the same event listener for fallback
            setTimeout(() => {
                document.getElementById('bankSelect')?.addEventListener('change', function() {
                    const selectedBank = this.value;
                    if (selectedBank) {
                        const validation = validateB2CPayment(paymentAmount, selectedBank);
                        const messageDiv = document.getElementById('validationMessage');
                        
                        if (validation.isValid) {
                            messageDiv.innerHTML = `<div class="alert alert-success">✓ ${validation.testCase} - Payment can proceed</div>`;
                        } else {
                            messageDiv.innerHTML = `<div class="alert alert-danger">✗ ${validation.testCase}<br>${validation.errors.join('<br>')}</div>`;
                        }
                    }
                });
            }, 100);
        });
    }


   
   
   function handleB2CPaymentResult(paymentData) {
    // Simulate different scenarios based on test cases
    const { bank, amount, validation } = paymentData;
    
    if (bank === 'SBI_BANK_B') {
        // Simulate insufficient funds scenario
        Swal.fire({
            title: 'Payment Failed',
            text: 'Insufficient funds in your account. Please check your balance and try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    // For successful validation, proceed with payment
    Swal.fire({
        title: 'Validation Successful',
        text: `${validation.testCase} - Proceeding to payment gateway...`,
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        // Redirect to B2C payment with validation parameters
        const params = new URLSearchParams({
            amount: amount,
            bank: bank,
            testCase: validation.testCase
        });
        
        window.location.href = `{{ route("pay.details.b2c") }}?${params.toString()}`;
    });
}


    
    function showPaymentConfirmationPopup(paymentType) {
        const paymentTypeText = paymentType === 'b2c' ? 'B2C (Business to Consumer)' : 'B2B (Business to Business)';
        
        Swal.fire({
            title: '@lang('app.are_you_sure2')',
            text: `@lang('app.are_you_sure_to_pay') using ${paymentTypeText}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '@lang('app.yes')',
            cancelButtonText: '@lang('app.cancel')',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                proceedWithPayment(paymentType);
            }
        });
    }
    
    function proceedWithPayment(paymentType) {
        Swal.fire({
            title: '@lang('app.processing')',
            text: 'Please wait while we redirect you to the payment gateway...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    
        // Redirect to appropriate payment route after a short delay
        setTimeout(() => {
            if (paymentType === 'b2c') {
                window.location.href = '{{ route("pay.details.b2c") }}';
            } else {
                window.location.href = '{{ route("pay.details.b2b") }}';
            }
        }, 2000);
    }
    
    // Keep your existing download functionality
    document.getElementById('downloadButton').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });
    
        html2canvas(document.getElementById('letter-content'), {
            scale: 3,
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgProps = doc.getImageProperties(imgData);
            const pdfWidth = doc.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
    
            doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            doc.save('Trench_Contribution_Bill_' + '{{ $application->refference_no }}' + '.pdf');
        });
    });
    
    // B2C Validation Functions
    function validateB2CPayment(amount, bankCode) {
        const validationRules = {
            minAmount: 1.00,
            maxAmount: 30000.00,
            validBanks: ['SBI_BANK_A', 'SBI_BANK_B'],
            currency: 'RM'
        };
    
        const validationResult = {
            isValid: true,
            errors: [],
            testCase: null
        };
    
        // Test Case 1.1 - Positive Scenario (Valid Account)
        if (amount >= validationRules.minAmount && amount <= validationRules.maxAmount && 
            bankCode === 'SBI_BANK_A') {
            validationResult.testCase = '1.1 - Valid Account';
            return validationResult;
        }
    
        // Test Case 2.1 - Maximum Scenario (Exceeded Amount)
        if (amount > validationRules.maxAmount) {
            validationResult.isValid = false;
            validationResult.errors.push(`Transaction amount exceeds limit. Maximum allowed: ${validationRules.currency}${validationRules.maxAmount}`);
            validationResult.testCase = '2.1 - Exceeded Amount';
            return validationResult;
        }
    
        // Test Case 2.2 - Minimum Scenario (Below Minimum)
        if (amount < validationRules.minAmount) {
            validationResult.isValid = false;
            validationResult.errors.push(`Transaction amount below minimum. Minimum required: ${validationRules.currency}${validationRules.minAmount}`);
            validationResult.testCase = '2.2 - Below Minimum';
            return validationResult;
        }
    
        // Test Case 2.3 - Insufficient Funds (Bank B scenario)
        if (bankCode === 'SBI_BANK_B' && amount >= validationRules.minAmount && amount <= validationRules.maxAmount) {
            validationResult.isValid = false;
            validationResult.errors.push('Insufficient funds in account. Please check your account balance.');
            validationResult.testCase = '2.3 - Insufficient Funds';
            return validationResult;
        }
    
        return validationResult;
    }
    
    function getBankList() {
        // Test Case 4.1 - Retrieved Bank List
        return [
            { code: 'SBI_BANK_A', name: 'SBI Bank A', status: 'active' },
            { code: 'SBI_BANK_B', name: 'SBI Bank B', status: 'active' },
            { code: 'OTHER_BANK', name: 'Other Bank', status: 'inactive' }
        ];
    }
    
    function simulateAEMessage() {
        // Test Case 3.1 - Re-query Scenario (AE message)
        return {
            status: 'AE',
            message: 'Transaction status inquiry required. Please check existing transaction status.',
            action: 'requery'
        };
    }



 
    </script>
@endsection
