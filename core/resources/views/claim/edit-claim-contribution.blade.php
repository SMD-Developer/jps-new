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
        padding: 0;
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
    
        @media print {
        .no-print, .no-print * {
            display: none !important;
        }
        
        /* Optional: Add padding/margin adjustments for print layout */
        body {
            padding: 20px !important;
            margin: 0 !important;
        }
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
<title>@lang('app.claim_contribution') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-plus-circle nav-icon"></i> @lang('app.claim_contribution')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.claim_contribution')</h4>
                        <form class="form" method="POST" action="{{ route('client_claim_submit') }}"
                            enctype="multipart/form-data" id="registrationForm">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @csrf

                            <div class="container">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="tarikh">@lang('app.date')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" id="tarikh" name="uploade_date" class="form-control"
                                                value="{{ now()->format('Y-m-d') }}" placeholder="" readOnly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="pemohon">@lang('app.applicant_individual_company')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="pemohon" name="applicant" class="form-control"
                                                placeholder="Nama Pemohon" value="{{ $claim->applicant ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="ssm">@lang('app.identification_card_no')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="ssm" name="identities" class="form-control"
                                                placeholder="No. Kad Pengenalan / SSM No."
                                                value="{{ $claim->identities ?? '' }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="alamat">@lang('app.applicant_address')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="alamat" class="form-control" name="address" rows="4" placeholder="Alamat Pemohon">{{ $claim->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="poskod">@lang('app.postal_code')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="poskod" name="postal_code" class="form-control"
                                                placeholder="@lang('app.postal_code')" pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="{{ $claim->postal_code ?? '' }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="bandar">@lang('app.city')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="bandar" name="city" class="form-control"
                                                placeholder="Bandar" value="{{ $claim->city ?? '' }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="negeri">@lang('app.state')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id="negeri" class="form-control form-select" name="state">
                                                <option value="" disabled>@lang('Sila Pilih Negeri')</option>
                                                @foreach ($state as $value)
                                                    <option value="{{ $value->idnegeri }}"
                                                        {{ $claim->state == $value->idnegeri ? 'selected' : '' }}>
                                                        {{ $value->negeri_code }} - {{ $value->negeri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="daerah">@lang('app.district')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id="daerah" class="form-control form-select" name="district">
                                                <option value="" disabled>@lang('Sila Pilih Daerah')</option>
                                                @foreach ($district as $value)
                                                    <option value="{{ $value->iddaerah }}"
                                                        {{ $claim->district == $value->iddaerah ? 'selected' : '' }}>
                                                        {{ $value->daerah_code }} - {{ $value->daerah }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="emel">@lang('app.email_address')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" id="emel" name="email" class="form-control"
                                                placeholder="Alamat Emel" value="{{ $claim->email ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="telefon">@lang('app.telephone_no')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="tel" id="telefon" name="phone" class="form-control"
                                                placeholder="No. Telefon" pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                value="{{ $claim->phone ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Lot Information Section -->
                    <div class="section">
                        <h4>@lang('app.lot_information')</h4>

                        <div class="container">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="lot-tanah">@lang('app.land_lot')</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="lot-tanah" name="land_lot" class="form-control"
                                            placeholder="Land lot" value="{{ $claim->land_lot ?? '' }}">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="keluasan">@lang('app.land_area')</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center">
                                            <select id="land-unit" name="land_unit" class="form-control form-select me-3"
                                                readonly onclick="return false;" style="pointer-events: none;">
                                                <option value="" disabled>- Sila Pilih -</option>
                                                @foreach ($landMeasurement as $land)
                                                    <option value="{{ $land->id }}"
                                                        {{ $claim->land_unit == $land->id ? 'selected' : '' }}>
                                                        {{ $land->display_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" id="keluasan" name="land_area" class="form-control"
                                                placeholder="Land area" value="{{ $claim->land_area }}"
                                                oninput="validateInput(this); convertToHectare();">
                                            <span class="mx-2">=</span>
                                            <input type="text" id="hectare-display" class="form-control"
                                                placeholder="@lang('app.hectare')" readonly>
                                            <span class="ml-2">@lang('app.hectare')</span>
                                        </div>
                                        <div class="mt-1 px-5 mx-5">
                                            <small class="text-warning"
                                                style="color: orange !important;display: block;margin: 5px 0 5px 10px ;"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="land_district">@lang('app.district')</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="land_district" class="form-control form-select "
                                            name="land_district">
                                            <option value="" selected disabled>@lang('app.select_district')</option>
                                            @foreach ($district as $value)
                                                <option value="{{ $value->iddaerah }}"
                                                    {{ $claim->land_district == $value->iddaerah ? 'selected' : '' }}>
                                                    {{ $value->daerah_code }} - {{ $value->daerah }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('land_district')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="mukim">@lang('Mukim')</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="mukim" class="form-control form-select" name="land_state">
                                            <option value="" disabled>@lang('app.select_division')</option>
                                            @foreach ($division as $value)
                                                <option value="{{ $value->idmukim }}"
                                                    {{ $claim->land_state == $value->idmukim ? 'selected' : '' }}>
                                                    {{ $value->mukim_code }} - {{ $value->mukim }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('land_state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <h4>@lang('app.payment_receipt')</h4>
                    <div class="form-group">
                        <label for="geran-tanah">@lang('app.receipt') <b class="starr">*</b></label>
                        <input type="file" id="land_grant" name="land_grant" class="file-input"
                            accept="application/pdf">
                        <label for="land_grant" class="upload-button">@lang('app.choose_file')</label>
                        <div id="land_grantfileName" class="file-name"></div>
                        <div class="col-9 text-center">
                            @if ($claim->land_grant)
                                <small class="text-info">Current file:
                                    <a href="{{ url('core/public/pdf/' . basename($claim->land_grant)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($claim->land_grant) }}
                                    </a></small>
                            @endif
                            @error('land_grant')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>

                <p class="note">
                    *@lang('app.file_only_pdf_format_size_not_exceed_15mb')
                </p>
                
                


                <!-- Submit Section -->
                <div class="form-actions">
                        @if($isAdminStaff)
                        <button type="button" class="btn btn-info no-print" data-bs-toggle="modal" data-bs-target="#statusModal">
                            @lang('app.kemaskini')
                        </button>
                        @endif
                        <button type="button" class="btn btn-secondary no-print" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> @lang('app.print')
                        </button>
                    <!--<button type="button" class="btn btn-secondary">@lang('Kembali')</button>-->
                    <!--<button type="submit" class="btn btn-primary" id="updateButton">@lang('app.update')</button>-->
                    <!--<button type="submit" class="btn btn-primary">@lang('app.send')</button>-->
                </div>
                
                <!-- Status Update Modal -->
                

                </form>
                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statusModalLabel">@lang('app.payment_status')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="statusUpdateForm" action="{{ route('updateClaimStatus', $claim->id ?? '') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="status" class="form-label">@lang('app.status')</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="pending" {{ ($claim->status ?? '') == 'pending' ? 'selected' : '' }}>@lang('app.pending')</option>
                                                <option value="approve_payment_in_process" {{ ($claim->status ?? '') == 'approve_payment_in_process' ? 'selected' : '' }}>@lang('app.approve_payment_in_process')</option>
                                                <option value="approve_paid" {{ ($claim->status ?? '') == 'approve_paid' ? 'selected' : '' }}>@lang('app.approve_paid')</option>
                                                <option value="rejected" {{ ($claim->status ?? '') == 'rejected' ? 'selected' : '' }}>@lang('app.rejected')</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('app.close')</button>
                                            <button type="submit" class="btn btn-primary">@lang('app.kemaskini')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            let formIsReady = true;

            // Handle State Change for Districts
            $('#negeri').on('change', function() {
                const stateId = $(this).val();
                $('#daerah').html('<option value="">Loading...</option>');

                if (stateId) {
                    formIsReady = false;
                    $.ajax({
                        url: `/clientarea/districts/${stateId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih Daerah</option>';
                            data.forEach(district => {
                                options +=
                                    `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`;
                            });
                            $('#daerah').html(options);
                            formIsReady = true;
                        },
                        error: function() {
                            $('#daerah').html(
                                '<option value="">Error loading districts</option>');
                            formIsReady = true;
                        }
                    });
                } else {
                    $('#daerah').html('<option value="">Sila Pilih Daerah</option>');
                }
            });

            // Handle District Change for Mukim
            $('#land_district').on('change', function() {
                const distId = $(this).val();
                $('#mukim').html('<option value="">Loading...</option>');

                if (distId) {
                    formIsReady = false;
                    $.ajax({
                        url: `/clientarea/division/${distId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih</option>';
                            data.forEach(mukin => {
                                options +=
                                    `<option value="${mukin.idmukim}">${mukin.mukim_code} - ${mukin.mukim}</option>`;
                            });
                            $('#mukim').html(options);
                            formIsReady = true;
                        },
                        error: function() {
                            $('#mukim').html('<option value="">Error loading mukin</option>');
                            formIsReady = true;
                        }
                    });
                } else {
                    $('#mukim').html('<option value="">Sila Pilih</option>');
                }
            });

            $(document).on('input change', '.is-invalid', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });

            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();

                if (!formIsReady) {
                    Swal.fire({
                        title: "Error",
                        text: "Please wait for the form to load fully before submitting.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');

                Swal.fire({
                    title: "@lang('app.are_you_sure_admin')",
                    // text: "@lang('app.confirm_submit_application')",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "@lang('app.yes')",
                    cancelButtonText: "@lang('app.cancel')"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "@lang('app.processing')",
                            html: "@lang('app.please_wait')",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        var formData = new FormData(this);
                        console.log("FormData:", formData);

                        $.ajax({
                            url: "{{ route('client_claim_submit') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    // Send notification to admin staff
                                    $.ajax({
                                        url: "{{ route('notify-admin-new-application') }}", // Define this route in your Laravel routes
                                        type: "POST",
                                        data: {
                                            application_id: response
                                                .application_id,
                                            _token: $('meta[name="csrf-token"]')
                                                .attr(
                                                    'content'
                                                ) // CSRF token for Laravel
                                        },
                                        success: function(
                                            notificationResponse) {
                                            console.log(
                                                'Admin notification sent:',
                                                notificationResponse);
                                        },
                                        error: function(xhr) {
                                            console.error(
                                                'Error sending admin notification:',
                                                xhr);
                                        }
                                    });

                                    Swal.fire({
                                        title: "@lang('app.success')",
                                        text: response.message,
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        $('#registrationForm')[0].reset();
                                        window.location.href =
                                            "{{ route('client_application_status') }}";
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                console.log(xhr);
                                console.log(xhr.responseJSON);

                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        let inputField = $('[name="' + key +
                                            '"]');
                                        inputField.addClass('is-invalid');
                                        inputField.after(
                                            '<div class="invalid-feedback d-flex justify-content-end">' +
                                            value[0] + '</div>'
                                        );
                                        if (key === 'land_area') {
                                            let errorDiv = inputField.next(
                                                '.invalid-feedback');
                                            $('.d-flex.align-items-center')
                                                .after(errorDiv);
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "@lang('app.unexpected_error_occurred')",
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                }
                            }
                        });
                    }
                });
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
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : '@lang('app.no_file_chosen')';
                document.getElementById(this.id + 'fileName').textContent = fileName;
            });
        });
    </script>
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
    <script>
        function validateInput(input) {
            input.value = input.value.replace(/[^0-9.]/g, '');
        }

        function updateConversionMessage() {
            const landUnit = document.getElementById('land-unit').value;
            const messageElement = document.getElementById('conversion-message');
            switch (landUnit) {
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
            const hectareInput = document.getElementById('hectare');
            const landUnit = document.getElementById('land-unit').value;

            if (inputValue && !isNaN(inputValue) && landUnit) {
                let hectares = 0;

                switch (landUnit) {
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

                hectareDisplay.value = hectares.toFixed(3);

                if (hectareInput) {
                    hectareInput.value = hectares.toFixed(3);
                    if (document.getElementById('hectare_input')) {
                        document.getElementById('hectare_input').value = hectares.toFixed(2);
                    }

                    if (typeof updateAllValues === 'function') {
                        updateAllValues();
                    }
                }
            } else {
                hectareDisplay.value = '';
                if (hectareInput) {
                    hectareInput.value = '';
                    if (document.getElementById('hectare_input')) {
                        document.getElementById('hectare_input').value = '0.00';
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateConversionMessage();
            convertToHectare();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#statusUpdateForm').submit(function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#statusModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '@lang('app.success')',
                            text: response.message || '@lang('app.claim_status_updated_successfully')',
                        }).then(() => {
                            location.reload(); // Optional: reload page to see changes
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '@lang('app.error')',
                            text: xhr.responseJSON.message || '@lang('app.failed_to_update_status')',
                        });
                    }
                });
            });
        });
    </script>
@endsection
