@extends('clientarea.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* General Styles */
    body {
        font-family: sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }

    /* Container */
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px;
        /*background: #fff;*/
        border-radius: 10px;
        /*box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);*/
        /*border: 1px solid #ddd;*/
    }

    /* Headings */
    h2,
    h3,
    h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Form Layout */
    .form-group {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .form-group label {
        width: 220px;
        font-weight: 600;
        margin-right: 15px;
        font-size: 13px;
        color: #555;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 13px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        transition: border 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
    }

    input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* File Upload */
    .form-group input[type="file"] {
        padding: 5px;
        border-radius: 5px;
    }

    /* Section */
    .section {
        margin-bottom: 40px;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-secondary {
        background: #f1f1f1;
        color: #333;
        border: 1px solid #ccc;
    }

    .btn-primary {
        background: #007bff;
        color: #fff;
    }

    .btn-secondary:hover,
    .btn-primary:hover {
        opacity: 0.9;
    }

    /* File Upload Section */
    .note {
        font-size: 14px;
        color: #d9534f;
        margin-top: 10px;
        text-align: end;
    }

    .content {
        background: #F4F6F9;
    }

    .starr {
        color: red;
    }

    /* file upload CSS */
    .file-input {
        display: none;
        /* Hide the default file input */
    }

    .submit-button {
        padding: 10px 20px;
        border: 2px solid #ccc;
        border-radius: 5px;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .submit-button:hover {
        background-color: #e0e0e0;
    }

    .file-name {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }
    
    .custom-file-button {
        display: inline-block;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    .custom-file-button:hover {
        background-color: #e9ecef;
    }

    .file-name-display {
        margin-left: 10px;
        color: #6c757d;
        font-size: 0.9em;
    }

    .is-invalid + .custom-file-button {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
    }

    /* Fix invalid feedback layout */
    .invalid-feedback {
        display: block;
        margin-top: 4px;
        font-size: 12px;
        color: #dc3545;
        font-weight: 500;
    }

    .is-invalid~.invalid-feedback{
        display: flex !important;
        justify-content: end !important;
        margin: 2px !important;
    }

    /* Keep form fields aligned even when invalid */
    .form-group input.is-invalid,
    .form-group select.is-invalid,
    .form-group textarea.is-invalid {
        border-color: #dc3545;
    }

</style>
<title>@lang('app.upload_deposit_receipt') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-plus-circle nav-icon"></i> @lang('app.upload_deposit_receipt')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.upload_deposit_receipt')</h4>
                       <form class="form" method="POST" action="{{ route('applications.submitDeposit') }}" enctype="multipart/form-data" id="depositForm">
                            @csrf
                            <input type="hidden" name="application_id" value="{{ $application->id }}">
                        
                            <div class="form-group">
                                <label>@lang('app.reference _no')</label>
                                <input type="text" class="form-control" value="{{ $application->refference_no }}" readonly>
                            </div>
                        
                            <div class="form-group">
                                <label>@lang('app.applicant_name')</label>
                                <input type="text" class="form-control" value="{{ $application->applicant }}" readonly>
                            </div>
                        
                            <div class="form-group">
                                <label>@lang('app.total_contribution')</label>
                                <input type="text" class="form-control" 
                                       value="{{ number_format($application->final_amount, 2) }}" 
                                       readonly>
                            </div>
                        
                            <div class="form-group">
                                <label for="deposit_date">@lang('app.deposited_date')<span class="text-danger">*</span></label>
                                <input type="date" id="deposit_date" name="deposit_date" class="form-control @error('deposit_date') is-invalid @enderror" required>
                                @error('deposit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="transaction" >No Transaksi EFT<span class="text-danger">*</span></label>
                                <input type="text" id="transaction" name="transaction" class="form-control @error('transaction') is-invalid @enderror" required>
                                @error('transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="voucher_number">No Baucar Bayaran<span class="text-danger">*</span></label>
                                <input type="text" id="voucher_number" name="voucher_number" class="form-control @error('voucher_number') is-invalid @enderror" required>
                                @error('voucher_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                             <div class="form-group">
                                <label for="receipt">@lang('app.upload_receipt')*</label>
                                <input type="file" id="receipt" name="receipt"
                                    class="form-control @error('receipt') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png" required style="display: none;">
                                <label for="receipt" class="custom-file-button">Pilih Fail</label>
                                <span class="file-name-display">No file chosen</span>
                                @error('receipt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="note">@lang('app.note')</label>
                                <textarea id="note" name="note" class="form-control" rows="4"></textarea>
                            </div>
                        
                            <button type="submit" class="btn btn-primary float-end">@lang('app.send')</button>
                       </form>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        // Form submission handler
        document.getElementById('depositForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
        
            document.querySelectorAll('.invalid-feedback').forEach(e => e.remove());
            document.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));
            let hasErrors = false;
            const errorMessages = {
                'deposit_date': 'Medan ini wajib diisi.',
                'transaction': 'Medan ini wajib diisi.',
                'voucher_number': 'Medan ini wajib diisi.',
                'receipt': 'Fail wajib dimuatnaik.'
            };
        
            const depositDate = document.querySelector('[name="deposit_date"]');
            if (!depositDate.value) {
                hasErrors = true;
                depositDate.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                errorDiv.textContent = errorMessages['deposit_date'];
                depositDate.closest('.form-group').appendChild(errorDiv);
            } else {
                // Create dates in local timezone from the YYYY-MM-DD string
                const [year, month, day] = depositDate.value.split('-').map(Number);
                const selectedDate = new Date(year, month - 1, day); // month is 0-indexed
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate > today) {
                    hasErrors = true;
                    depositDate.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.classList.add('invalid-feedback');
                    errorDiv.textContent = 'Tarikh bayaran tidak boleh melebihi hari ini.';
                    depositDate.closest('.form-group').appendChild(errorDiv);
                }
            }
            
            // Check transaction
            const transaction = document.querySelector('[name="transaction"]');
            if (!transaction.value) {
                hasErrors = true;
                transaction.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                errorDiv.textContent = errorMessages['transaction'];
                transaction.closest('.form-group').appendChild(errorDiv);
            }


            // Check voucher_number
            const voucherNumber = document.querySelector('[name="voucher_number"]');
            if (!voucherNumber.value) {
                hasErrors = true;
                voucherNumber.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                errorDiv.textContent = 'Medan ini wajib diisi.';
                voucherNumber.closest('.form-group').appendChild(errorDiv);
            }
            
            // Check receipt file
            const receipt = document.querySelector('[name="receipt"]');
            if (!receipt.files || receipt.files.length === 0) {
                hasErrors = true;
                receipt.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('invalid-feedback');
                errorDiv.textContent = errorMessages['receipt'];
                receipt.closest('.form-group').appendChild(errorDiv);
            } else {
                const file = receipt.files[0];
                const allowedTypes = ['application/pdf'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    hasErrors = true;
                    receipt.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.classList.add('invalid-feedback');
                    errorDiv.textContent = 'Fail mestilah dalam format PDF.';
                    receipt.closest('.form-group').appendChild(errorDiv);
                }
                // Check file size
                else if (file.size > maxSize) {
                    hasErrors = true;
                    receipt.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.classList.add('invalid-feedback');
                    errorDiv.textContent = 'Saiz fail tidak boleh melebihi 15MB.';
                    receipt.closest('.form-group').appendChild(errorDiv);
                }
            }
            
            // If validation fails, don't show popup
            if (hasErrors) {
                return;
            }
            
            const formData = new FormData(form);

            Swal.fire({
                title: 'Sahkan penghantaran',
                text: "Adakah anda pasti ingin menghantar butiran pembayaran ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading indicator
                    Swal.fire({
                        title: 'Processing...',
                        html: 'Sila tunggu sementara kami menghantar butiran pembayaran anda',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit form via AJAX
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(async response => {
                    Swal.close();

                            // If Laravel returns validation errors (for server-side validation like unique check)
                            if (!response.success && response.errors) {
                                // Clear old errors
                                document.querySelectorAll('.invalid-feedback').forEach(e => e.remove());
                                document.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));

                                // Loop through each error and show below field
                                for (const [field, messages] of Object.entries(response.errors)) {
                                    const input = document.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');
                                        const errorDiv = document.createElement('div');
                                        errorDiv.classList.add('invalid-feedback');
                                        errorDiv.textContent = messages[0];
                                        input.closest('.form-group').appendChild(errorDiv);
                                    }
                                }
                                return; 
                            }

                            // If success
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Resit berjaya dimuat naik',
                                    text: response.message || 'Butiran pembayaran berjaya dihantar',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    window.location.href = "{{ route('client_application_status') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Something went wrong!',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })

                    .catch(error => {
                        Swal.close(); 
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit the form. Please try again.',
                            confirmButtonText: 'OK'
                        });
                        console.error('Error:', error);
                    });
                }
            });
        });
    </script>
    <script>
        function validateFileSize(input) {
            const file = input.files[0];
            if (file) {
                if (file.size > 15 * 1024 * 1024) { // 15MB
                    alert('@lang('app.file_size_exceeds_15MB')');
                    input.value = ''; // Clear the input
                }
            }
        }
    </script>
    <script>
        document.getElementById('receipt').addEventListener('change', function() {
            const fileNameDisplay = document.querySelector('.file-name-display');
            if (this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        });
    </script>
@endsection
