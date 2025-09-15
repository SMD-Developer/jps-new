<!--@extends('app')-->
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

    .btn1,
    .btn2,
    .btn3 {
        border-radius: 20px !important;
        padding: 7px 25px !important;
    }

    .small-input {
        border-radius: 1px !important;
        border: 2px solid black !important;
        padding: 4px 0 !important;
    }

    div#swal2-html-container {
        overflow-x: hidden;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@lang('app.new_application') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-file-text"></i> @lang('app.new_application')</h5>
    </div>


    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.applicant_Information')</h4>
                        <form>
                            <div class="form-group">
                                <label for="refference_no">@lang('app.no_application_ref')</label>
                                <input id="refference_no" class="form-control" value="{{ $application->refference_no }}"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="tarikh">@lang('app.date')</label>
                                <input id="tarikh" class="form-control" value="{{ $application->uploade_date }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="pemohon">@lang('app.applicant') @lang('app.individual') / @lang('app.company')</label>
                                <input type="text" id="pemohon" class="form-control"
                                    value="{{ $application->applicant }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="ssm">@lang('app.identification_card_no')</label>
                                <input type="text" id="ssm" class="form-control"
                                    value="{{ $application->identities }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="alamat">@lang('app.applicant_address')</label>
                                <textarea id="alamat" class="form-control" rows="4" readonly>{{ $application->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="poskod">@lang('app.postal_code')</label>
                                <input type="text" id="poskod" class="form-control"
                                    value="{{ $application->postal_code }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="bandar">@lang('app.city')</label>
                                <input type="text" id="bandar" class="form-control" value="{{ $application->city }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="daerah">@lang('app.district')</label>
                                <input type="text" id="daerah" class="form-control" value="{{ $district }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="negeri">@lang('app.state')</label>
                                <input type="text" id="negeri" class="form-control" value="{{ $state }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="emel">@lang('app.email_address')</label>
                                <input type="email" id="emel" class="form-control" value="{{ $application->email }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="telefon">@lang('app.telephone_no')</label>
                                <input type="tel" id="telefon" class="form-control" value="{{ $application->phone }}"
                                    readonly>
                            </div>
                        </form>
                    </div>

                    <!-- Lot Information Section -->
                    <div class="section">
                        <h4>@lang('app.lot_information')</h4>
                        <form>
                            <div class="form-group">
                                <label for="lot-tanah">@lang('app.land_lot') </label>
                                <input type="text" id="lot-tanah" class="form-control"
                                    value="{{ $application->land_lot }}" readonly>
                            </div>

                           <div class="form-group">
                            <label for="keluasan">@lang('app.land_area')</label>
                            <div class="d-flex align-items-center">
                                <select id="land-unit" name="land_unit" class="form-control form-select me-3" readonly onclick="return false;" style="pointer-events: none;">
                                    <option value="" disabled>- Sila Pilih -</option>
                                    @foreach ($landMeasurement as $land)
                                        <option value="{{ $land->id }}" {{ $application->land_unit == $land->id ? 'selected' : '' }}>
                                            {{ $land->display_name}}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" id="keluasan" name="land_area" class="form-control"
                                    placeholder="Land area" value="{{ $application->land_area }}" 
                                    oninput="validateInput(this); convertToHectare();" readonly>
                                <span class="mx-2">=</span>
                                <input type="text" id="hectare-display" class="form-control" placeholder="@lang('app.hectare')" readonly>
                                <span class="ml-2">@lang('app.hectare')</span>
                            </div>
                            <div class="mt-1 px-5 mx-5">
                                <small id="conversion-message" class="text-warning" style="color: orange !important;display: block;margin: 5px 140px;">@lang('app.formula_divide_the_area')</small>
                            </div>
                            <div class="invalid-feedback d-flex justify-content-end" style="color: red; display: block; margin-top: 5px;" id="hectare-conversion"></div>
                            @error('land_area')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('land_unit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                            <div class="form-group">
                                <label for="daerah">@lang('app.district')</label>
                                <input type="text" id="daerah" class="form-control" value="{{ $landDistrict }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="mukim">@lang('Mukim')</label>
                                <input type="text" id="mukim" class="form-control" value="{{ $division }}"
                                    readonly>
                            </div>
                        </form>
                    </div>

                    <!-- File Upload Section -->
                    <div class="section">
                        <h4>@lang('app.upload_supporting_documents')</h4>
                        <form>
                            <div class="form-group">
                                <label for="geran-tanah">@lang('app.land_grant') <b class="starr">*</b></label>
                                @if ($application->land_grant)
                                    <a href="{{ url('core/public/pdf/' . basename($application->land_grant)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($application->land_grant) }}
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="pelan">@lang('app.planning_permission_plan')</label>
                                @if ($application->permission_plan)
                                    <a href="{{ url('core/public/pdf/' . basename($application->permission_plan)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($application->permission_plan) }}
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="sokongan">@lang('app.letter_of_support')</label>
                                @if ($application->letter_of_support)
                                    <a href="{{ url('core/public/pdf/' . basename($application->letter_of_support)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($application->letter_of_support) }}
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>

                            <p class="note">
                                * @lang('app.file_only_pdf_format_size_not_exceed_15mb')
                            </p>
                        </form>
                    </div>


                    <!-- Submit Section -->
                    <div class="form-actions">
                        <!--<button type="submit" class="btn btn-secondary btn1" id="rejectButton"-->
                        <!--    data-id="{{ $application->id }}" style="background-color: red; border-color: red;">@lang('app.reject')</button>-->
                            <button type="submit" class="btn btn-secondary btn1" id="rejectButton"
                                data-id="{{ $application->id }}" 
                                style="@if($application->status === 'approved' || $application->status === 'rejected') background-color: #ccc; border-color: #ccc; color: #666; @else background-color: red; border-color: red; @endif"
                                @if($application->status === 'approved' || $application->status === 'rejected') disabled @endif>
                                @lang('app.reject')
                            </button>
                        <button type="submit" class="btn btn-primary btn2" id="approveButton"
                            data-id="{{ $application->id }}" style="@if($application->status === 'approved' || $application->status === 'rejected') background-color: #ccc; border-color: #ccc; color: #666;  @endif"
                                @if($application->status === 'approved' || $application->status === 'rejected') disabled @endif>
                            @lang('app.next')
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
     <script>
        function validateInput(input) {
            input.value = input.value.replace(/[^0-9.]/g, '');
        }
        
        function updateConversionMessage() {
            const landUnit = document.getElementById('land-unit').value;
            const messageElement = document.getElementById('conversion-message');
            switch(landUnit) {
                case '1': 
                    messageElement.textContent = '@lang('app.formula_divide_the_area')';
                    break;
                case '2': 
                    messageElement.textContent = '@lang('app.formula_divide_by_2471')';
                    break;
                case '3': 
                    messageElement.textContent = '@lang('app.formula_already_in_hectare')';
                    break;
                default:
                    messageElement.textContent = '@lang('app.formula_divide_the_area')';
            }
        }
        
        function convertToHectare() {
            const inputValue = document.getElementById('keluasan').value;
            const hectareDisplay = document.getElementById('hectare-display');
            const landUnit = document.getElementById('land-unit').value;
            if (inputValue && !isNaN(inputValue) && landUnit) {
                let hectares = 0;
                switch(landUnit) {
                    case '1': 
                        hectares = parseFloat(inputValue) / 10000;
                        break;
                    case '2':
                        hectares = parseFloat(inputValue) / 2.47105;
                        break;
                    case '3': 
                        hectares = parseFloat(inputValue);
                        break;
                    default:
                        hectares = 0;
                }
                
                hectareDisplay.value = hectares.toFixed(6);
            } else {
                hectareDisplay.value = '';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateConversionMessage();
            convertToHectare();
        });
</script>
    <script>
        // Get today's date
        const today = new Date();

        // Format the date as dd/mm/yy
        const formattedDate = [
            String(today.getDate()).padStart(2, '0'), // Day with leading zero
            String(today.getMonth() + 1).padStart(2, '0'), // Month with leading zero
            String(today.getFullYear()).slice(0) // Last two digits of the year
        ].join('/');

        // Set the placeholder for the date input
        document.getElementById('tarikh').placeholder = formattedDate;
    </script>
    <script>
        function sendNotificationToUser(applicationId, notificationType) {
            fetch('{{ route('send-user-notification') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        application_id: applicationId,
                        notification_type: notificationType
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Notification response data:', data);
                    Swal.fire({
                        title: '@lang('app.rejected')',
                        text: '@lang('app.application_rejected_successfully')',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('application_status') }}";
                    });
                })
                .catch(error => {
                    console.error('Notification Error:', error);
                    Swal.fire({
                        title: '@lang('app.rejected')',
                        text: '@lang('app.application_rejected_successfully')',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('application_status') }}"; // Adjust route as needed
                    });
                });
        }

        document.getElementById('approveButton').addEventListener('click', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get the application ID from the data attribute
            const applicationId = this.getAttribute('data-id');

            // Construct the URL for the update application route
            const updateUrl = "{{ route('updateApplicationForm', ['id' => ':id']) }}".replace(':id',
                applicationId);

            // Navigate to the update application page
            window.location.href = updateUrl;
        });



        document.getElementById('rejectButton').addEventListener('click', function(event) {
            event.preventDefault();
            const applicationId = this.getAttribute('data-id');

            Swal.fire({
                title: '@lang('app.reason_for_rejection')',
                text: '@lang('app.specific_reason:_document_not_complete')',
                icon: 'warning',
                html: `
                <label for="rejectionReason" style="display: block; text-align: center; font-weight: bold;">
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
                    console.log("Rejection Reason:", rejectionReason);

                    fetch('/application/' + applicationId + '/reject', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                reason: rejectionReason
                            })
                        })
                        .then(response => {
                            console.log('Response Status:', response.status);
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response Data:', data);
                            if (data.success) {
                                sendNotificationToUser(applicationId, 'rejection');
                            } else {
                                Swal.fire('Error', data.message || 'Failed to reject application.',
                                    'error');
                            }
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error); // Log detailed error
                            Swal.fire('Error', 'Something went wrong: ' + error.message, 'error');
                        });
                }
            });
        });
    </script>
   
@endsection
