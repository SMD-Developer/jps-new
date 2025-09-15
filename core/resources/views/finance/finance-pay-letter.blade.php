@extends('app')
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
</style>
<title>@lang('app.payment_details') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-plus-circle nav-icon"></i> @lang('app.payment_details')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.payment_details')</h4>
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
                                <label>@lang('app.amounts')</label>
                                <input type="text" class="form-control" value="{{ $application->final_amount }}" readonly>
                            </div>
                        
                            <div class="form-group">
                                <label for="deposit_date">@lang('app.deposited_date')*</label>
                                <input type="date" 
                                       id="deposit_date" 
                                       name="deposit_date" 
                                       value="{{ $application->deposit_date ? \Carbon\Carbon::parse($application->deposit_date)->format('Y-m-d') : '' }}" 
                                       class="form-control @error('deposit_date') is-invalid @enderror" 
                                       readonly>
                                @error('deposit_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="form-group">
                                <label for="transaction">@lang('app.transaction_no')*</label>
                                <input type="text" id="transaction" name="transaction" value="{{ $application->transaction }}" class="form-control @error('transaction') is-invalid @enderror" readonly>
                                @error('transaction')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                           <!--<div class="form-group">-->
                           <!--     <label for="receipt">@lang('app.upload_receipt')*</label>-->
                                
                           <!--     <label for="receipt" class="submit-button is-invalid">@lang('app.choose_file')</label>-->
                           <!--     <input type="file" id="receipt" name="receipt" class="file-input @error('receipt') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" onchange="validateFileSize(this)" readonly>-->
                           <!--     <div id="land_grantfileName" class="file-name"></div>-->
                                
                           <!--     @if($application->receipt_path)-->
                           <!--         <div class="col-9 text-center mt-2">-->
                           <!--             <small class="text-info">Current file:-->
                           <!--                 <a href="{{ url('core/' . $application->receipt_path) }}" target="_blank">-->
                           <!--                     <i class="fa fa-file-pdf-o"></i>-->
                           <!--                     {{ basename($application->receipt_path) }}-->
                           <!--                 </a>-->
                           <!--             </small>-->
                           <!--         </div>-->
                           <!--     @endif-->
                                
                           <!--     @error('receipt')-->
                           <!--         <div class="invalid-feedback">{{ $message }}</div>-->
                           <!--     @enderror-->
                           <!-- </div>-->
                           <div class="form-group">
                                <label for="receipt">@lang('app.upload_receipt')*</label>
                                
                                <label for="receipt" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="receipt" name="receipt" class="file-input @error('receipt') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" onchange="validateFileSize(this)" readonly>
                                <div id="land_grantfileName" class="file-name"></div>
                                
                                @if($application->receipt_path)
                                    <div class="col-9 text-center mt-2">
                                        <small class="text-info">Current file:
                                            <a href="{{ url('core/public/' . $application->receipt_path) }}" target="_blank">
                                                <i class="fa fa-file-pdf-o"></i>
                                                {{ basename($application->receipt_path) }}
                                            </a>
                                        </small>
                                    </div>
                                @endif
                                
                                @error('receipt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="form-group">
                                <label for="note">@lang('app.note')</label>
                                <textarea id="note" name="note" class="form-control" rows="4" readonly>{{ $application->note }}</textarea>
                            </div>
                        
                           <div class="row last_row">
                                <div class="col-md-6"></div>
                               <div class="col-md-6 text-right">
                                   @if($canFinanceAdminApproveReject)
                                    <button type="submit" class="btn btn-secondary btn1 mx-3" id="rejectButton"
                                        data-id="{{ $application->id }}">@lang('app.no')</button>
                                    <button type="submit" class="btn btn-primary btn2" id="approveButton"
                                        data-id="{{ $application->id }}">
                                        @lang('app.accept')
                                    </button>
                                    @endif
                                </div>
                            </div>
                </div>
            </div>
        </div>
        </div>
    </section>

          <script>
                  document.getElementById('approveButton').addEventListener('click', function() {
                const approveButton = this;
                let applicationId = this.getAttribute('data-id');
            
                Swal.fire({
                    title: '@lang('app.confirm_recieved_payment')',
                    text: '@lang('app.are_you_sure_want_to_approve_payment')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('app.yes')',
                    cancelButtonText: '@lang('app.cancel')'
                }).then((result) => {
                    if (result.isConfirmed) {
                        handleButtonState(approveButton, true);
            
                        fetch('/finance/payment/' + applicationId + '/approve', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                applicationId: applicationId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire('@lang('app.success')', '@lang('app.payment_approved_successfully')', 'success')
                                .then(() => {
                                   window.location.href = "{{ route('view.receipt') }}";
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Payment approval failed', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Approval Error:', error);
                            Swal.fire('Error', 'Something went wrong during payment approval.', 'error');
                        })
                        .finally(() => {
                            handleButtonState(approveButton, false);
                        });
                    }
                });
            });
    
    
        document.getElementById('rejectButton').addEventListener('click', function(event) {
                event.preventDefault();
                const rejectButton = this;
                const id = this.getAttribute('data-id');
            
                Swal.fire({
                    title: '@lang('app.reason_for_rejection')',
                    text: '@lang('app.specific_reason:_document_not_complete')',
                    icon: 'warning',
                    html: `
                        <label for="rejectionReason" style="display: block; text-align: center; font-weight: bold;">
                            @lang('app.reason_for_rejection')
                        </label>
                        <textarea id="rejectionReason" class="swal2-textarea" style="width: 85%;" placeholder="@lang('app.enter_reason_for_rejection')"></textarea>
                    `,
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '@lang('app.yes_reject')',
                    cancelButtonText: '@lang('app.cancel')',
                    preConfirm: () => {
                        const reason = document.getElementById('rejectionReason').value.trim();
                        if (!reason) {
                            Swal.showValidationMessage('@lang('app.please_provide_rejection_reason')');
                            return false;
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const rejectionReason = result.value;
                        handleButtonState(rejectButton, true);
            
                        fetch('/finance/payment/' + id + '/reject', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                reason: rejectionReason
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success', 'Payment has been rejected', 'success')
                                .then(() => {
                                    // Reload the page or redirect
                                    window.location.href = "{{ route('view.receipt') }}";
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Failed to reject payment.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Rejection Error:', error);
                            Swal.fire('Error', 'Something went wrong during payment rejection.', 'error');
                        })
                        .finally(() => {
                            handleButtonState(rejectButton, false);
                        });
                    }
                });
            });
    
        function handleButtonState(button, disabled) {
            button.disabled = disabled;
            button.classList.toggle('disabled', disabled);
        }
    </script>
    <script>
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : '@lang('app.no_file_chosen')';
                document.getElementById(this.id + 'fileName').textContent = fileName;
            });
        });
    </script>
@endsection
