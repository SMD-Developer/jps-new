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
    
    
    
    
    
    #keluasan ~ .invalid-feedback {
    display: block !important;
    width: 100% !important;
    margin-top: 4px;
    order: 9999 !important;
    flex-basis: 100% !important;
    text-align: right !important;

}




    
</style>
<title>@lang('app.new_application') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-plus-circle nav-icon"></i> @lang('app.new_application')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.applicant_Information')</h4>
                        <form class="form" method="POST" action="{{ route('client_application_submit') }}"
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
                                           <input type="date" id="tarikh" name="uploade_date" class="form-control" value="{{ now()->format('Y-m-d') }}" placeholder="" readOnly>
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
                                             placeholder="Nama Pemohon" value="{{ $client->userName ?? '' }}">
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
                                            placeholder="No. Kad Pengenalan / SSM No." value="{{ $client->idCardNumber ?? '' }}">                             
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                           <label for="alamat">@lang('app.applicant_address')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="alamat" class="form-control" name="address" rows="4" placeholder="Alamat Pemohon">{{ $client->registeredAddress ?? '' }}</textarea>
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
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $client->postalCode ?? '' }}" >
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
                                             placeholder="Bandar" value="{{ $client->city ?? '' }}">
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
                                                        {{ $client->state_id == $value->idnegeri ? 'selected' : '' }}>
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
                                                        {{ $client->district_id == $value->iddaerah ? 'selected' : '' }}>
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
                                             placeholder="Alamat Emel" value="{{ $client->email ?? '' }}">                    
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
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $client->mobileNumber ?? '' }}">                     
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
                                        <input type="text" id="lot-tanah" name="land_lot" class="form-control" placeholder="Land lot">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="keluasan">@lang('app.land_area')</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="position-relative pe-5">
                                                <select id="land-unit" name="land_unit" class="form-control form-select me-3" onchange="convertToHectare()">
                                                    <option value="" selected disabled>- Sila Pilih -</option>
                                                    @foreach ($landMeasurement as $land)
                                                        <option value="{{ $land->id }}">{{ $land->display_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="position-relative">
                                                <input type="text" id="keluasan" name="land_area" class="form-control" placeholder="Land area" oninput="validateNumberInput(this); convertToHectare()" onkeypress="return isNumberKey(event)">
                                                @error('land_area')
                                                    <div class="invalid-feedback d-block " >{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <span class="mx-2">=</span>
                                            <input type="text" id="hectare-display" class="form-control" placeholder="@lang('app.hectare')" readonly>
                                            <span class="ml-2">@lang('app.hectare')</span>
                                        </div>
                            
                                        <div class="mt-1 px-5 mx-5">
                                            <small class="text-warning" style="color: orange !important;display: block;margin: 5px 0 5px 10px ;"></small>
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
                                        <select id="land_district" class="form-control form-select" name="land_district">
                                            <option value="" selected disabled>- Sila Pilih -</option>
                                            @foreach ($district as $value)
                                                <option value="{{ $value->iddaerah }}">{{ $value->daerah_code }} - {{ $value->daerah }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                            <option value="" selected disabled>- Sila Pilih -</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <!--<h4>@lang('app.upload_supporting_documents')</h4>-->
                    <!-- File Upload Section -->
                    <!--<div class="form-group">-->
                    <!--    <div class="col-md-4">-->
                    <!--       <label for="geran-tanah">@lang('app.land_grant') <b class="starr">*</b></label>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-8">-->
                    <!--        <label for="land_grant" class="submit-button is-invalid">@lang('app.choose_file')</label>-->
                    <!--        <input type="file" id="land_grant" name="land_grant" class="file-input"-->
                    <!--            accept="application/pdf" onchange="validateFileSize(this)">-->
                    <!--        <div id="land_grantfileName" class="file-name"></div>-->
                    <!--    </div>        -->
                    <!--</div>-->

                    <!--<div class="form-group">-->
                    <!--    <div class="col-md-4">-->
                    <!--       <label for="pelan">@lang('app.planning_permission_plan')</label>-->
                    <!--    </div> -->
                    <!--    <div class="col-md-8">-->
                    <!--        <label for="permission_plan" class="submit-button is-invalid">@lang('app.choose_file')</label>-->
                    <!--        <input type="file" id="permission_plan" name="permission_plan" class="file-input"-->
                    <!--            accept="application/pdf" onchange="validateFileSize(this)">-->
                    <!--        <div id="permission_planfileName" class="file-name"></div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <!--<div class="form-group">-->
                    <!--    <div class="col-md-4">-->
                    <!--      <label for="sokongan">@lang('app.letter_of_support')</label>-->
                    <!--    </div>-->
                    <!--    <div class="col-md-8">-->
                    <!--        <label for="letter_of_support" class="submit-button is-invalid">@lang('app.choose_file')</label>-->
                    <!--        <input type="file" id="letter_of_support" name="letter_of_support" class="file-input"-->
                    <!--            accept="application/pdf" onchange="validateFileSize(this)">-->
                    <!--        <div id="letter_of_supportfileName" class="file-name"></div>-->
                    <!--    </div>    -->
                    <!--</div>-->
                    <!--<p class="note">-->
                    <!--    *@lang('app.file_only_pdf_format_size_not_exceed_15mb')-->
                    <!--</p>-->
                    
                    
                       <!-- File Upload Section with Enhanced Validation -->
                    <h4>@lang('app.upload_supporting_documents')</h4>

                    <!-- Land Grant File Upload -->
                    <div class="form-group">
                        <div class="col-md-4">
                        <label for="geran-tanah">@lang('app.land_grant') <b class="starr">*</b></label>
                        </div>
                        <div class="col-md-8">
                            <label for="land_grant" class="submit-button is-invalid">@lang('app.choose_file')</label>
                            <input type="file" id="land_grant" name="land_grant" class="file-input"
                                accept="application/pdf" onchange="validateFileSize(this)">
                            <div id="land_grantfileName" class="file-name"></div>
                            <!-- Error message will be inserted here by JavaScript -->
                        </div>        
                    </div>

                    <!-- Permission Plan File Upload -->
                    <div class="form-group">
                        <div class="col-md-4">
                        <label for="pelan">@lang('app.planning_permission_plan')</label>
                        </div> 
                        <div class="col-md-8">
                            <label for="permission_plan" class="submit-button is-invalid">@lang('app.choose_file')</label>
                            <input type="file" id="permission_plan" name="permission_plan" class="file-input"
                                accept="application/pdf" onchange="validateFileSize(this)">
                            <div id="permission_planfileName" class="file-name"></div>
                            <!-- Error message will be inserted here by JavaScript -->
                        </div>
                    </div>

                    <!-- Letter of Support File Upload -->
                    <div class="form-group">
                        <div class="col-md-4">
                        <label for="sokongan">@lang('app.letter_of_support')</label>
                        </div>
                        <div class="col-md-8">
                            <label for="letter_of_support" class="submit-button is-invalid">@lang('app.choose_file')</label>
                            <input type="file" id="letter_of_support" name="letter_of_support" class="file-input"
                                accept="application/pdf" onchange="validateFileSize(this)">
                            <div id="letter_of_supportfileName" class="file-name"></div>
                            <!-- Error message will be inserted here by JavaScript -->
                        </div>    
                    </div>

                    <p class="note">
                        *@lang('app.file_only_pdf_format_size_not_exceed_15mb')
                    </p>


                    <!-- Submit Section -->
                    <div class="form-actions">
                        <!--<button type="button" class="btn btn-secondary">@lang('Kembali')</button>-->
                        <!--<button type="submit" class="btn btn-primary" id="updateButton">@lang('app.update')</button>-->
                        <button type="submit" class="btn btn-primary">@lang('app.send')</button>
                    </div>
                    </form>
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

            // Function to validate required fields
            function validateForm() {
                let isValid = true;
                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');

                // Check required fields
                const requiredFields = [
                    'applicant', 'identities', 'address', 'postal_code', 
                    'city', 'state', 'district', 'email',
                    'land_lot', 'land_area', 'land_unit', 'land_district', 'land_state',
                    'land_grant'
                ];

                requiredFields.forEach(field => {
                    const value = $(`[name="${field}"]`).val();
                    if (!value) {
                        $(`[name="${field}"]`).addClass('is-invalid');
                        $(`[name="${field}"]`).after(
                            `<div class="invalid-feedback d-flex justify-content-end">Medan ini wajib diisi</div>`
                        );
                        isValid = false;
                        
                        // Scroll to the first invalid field
                        if (isValid === false) {
                            $('html, body').animate({
                                scrollTop: $(`[name="${field}"]`).offset().top - 100
                            }, 500);
                        }
                    }
                });

                // Additional validation for email format
                const email = $('[name="email"]').val();
                if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    $('[name="email"]').addClass('is-invalid');
                    $('[name="email"]').after(
                        '<div class="invalid-feedback d-flex justify-content-end">Please enter a valid email address</div>'
                    );
                    isValid = false;
                }

                // Additional validation for phone number
                const phone = $('[name="phone"]').val();
                if (phone && !/^\d+$/.test(phone)) {
                    $('[name="phone"]').addClass('is-invalid');
                    $('[name="phone"]').after(
                        '<div class="invalid-feedback d-flex justify-content-end">Please enter only numbers</div>'
                    );
                    isValid = false;
                }

                return isValid;
            }

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

                // Check file size validation FIRST
                if (!validateAllFiles()) {
                    Swal.fire({
                        title: "File Size Error",
                        text: "One or more files exceed the 15MB size limit. Please choose smaller files.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                // Then validate the form
                if (!validateForm()) {
                    // Focus on the first invalid field
                    const firstInvalid = $('.is-invalid').first();
                    if (firstInvalid.length) {
                        $('html, body').animate({
                            scrollTop: firstInvalid.offset().top - 100
                        }, 500);
                        firstInvalid.focus();
                    }
                    return;
                }

                // If validation passes, show confirmation dialog
                Swal.fire({
                    title: "@lang('app.are_you_sure_admin')",
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
                            url: "{{ route('client_application_submit') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    // Send notification to admin staff
                                    $.ajax({
                                        url: "{{ route('notify-admin-new-application') }}",
                                        type: "POST",
                                        data: {
                                            application_id: response.application_id, 
                                            _token: $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function(notificationResponse) {
                                            console.log('Admin notification sent:', notificationResponse);
                                        },
                                        error: function(xhr) {
                                            console.error('Error sending admin notification:', xhr);
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
                                        let inputField = $('[name="' + key + '"]');
                                        inputField.addClass('is-invalid');
                                        inputField.after(
                                            '<div class="invalid-feedback d-flex justify-content-end">' +
                                            value[0] + '</div>'
                                        );
                                        if (key === 'land_area') {
                                            let errorDiv = inputField.next('.invalid-feedback');
                                            $('.d-flex.align-items-center').after(errorDiv);
                                        }
                                    });
                                    
                                    // Scroll to the first error
                                    const firstError = $('.is-invalid').first();
                                    if (firstError.length) {
                                        $('html, body').animate({
                                            scrollTop: firstError.offset().top - 100
                                        }, 500);
                                    }
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

        // File validation functions
        function validateFileSize(input) {
            const maxSize = 15 * 1024 * 1024; // 15MB in bytes
            const file = input.files[0];
            const fieldName = input.name;
            
            // Get the file name display element
            const fileNameDisplay = document.getElementById(fieldName + 'fileName');
            
            // Remove any existing error message
            const existingError = input.parentElement.querySelector('.file-size-error');
            if (existingError) {
                existingError.remove();
            }
            
            if (file) {
                if (file.size > maxSize) {
                    // File is too large
                    // Clear the input
                    input.value = '';
                    
                    // Clear the file name display
                    if (fileNameDisplay) {
                        fileNameDisplay.textContent = '';
                    }
                    
                    // Create and show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'file-size-error';
                    errorDiv.style.color = 'red';
                    errorDiv.style.fontSize = '12px';
                    errorDiv.style.marginTop = '5px';
                    errorDiv.textContent = 'File size exceeds 15MB limit. Please choose a smaller file.';
                    
                    // Insert error message after the file name display
                    if (fileNameDisplay) {
                        fileNameDisplay.parentNode.insertBefore(errorDiv, fileNameDisplay.nextSibling);
                    } else {
                        input.parentElement.appendChild(errorDiv);
                    }
                    
                    return false;
                } else {
                    // File is valid size
                    if (fileNameDisplay) {
                        fileNameDisplay.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
                        fileNameDisplay.style.color = 'green';
                    }
                    return true;
                }
            }
            
            return true;
        }

        // Helper function to format file size for display
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Function to validate all file inputs
        function validateAllFiles() {
            const fileInputs = document.querySelectorAll('input[type="file"]');
            let allValid = true;
            
            fileInputs.forEach(input => {
                if (input.files.length > 0) {
                    if (!validateFileSize(input)) {
                        allValid = false;
                    }
                }
            });
            
            return allValid;
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
    

    function validateNumberInput(input) {
        input.value = input.value.replace(/[^0-9.]/g, '');
        let parts = input.value.split('.');
        if (parts.length > 2) {
            input.value = parts[0] + '.' + parts.slice(1).join('');
        }
    }
    
    function convertToHectare() {
    const inputValue = document.getElementById('keluasan').value;
    const landUnitId = document.getElementById('land-unit').value;
    const hectareDisplay = document.getElementById('hectare-display');
    const formulaMessage = document.querySelector('.text-warning');
    
    if (!inputValue || isNaN(inputValue) || !landUnitId) {
        hectareDisplay.value = '';
        formulaMessage.style.display = 'none';
        return;
    }
    
    const numericValue = parseFloat(inputValue);
    
    switch(landUnitId) {
        case "1": 
            const hectares = numericValue * 0.0001; 
            hectareDisplay.value = hectares.toFixed(6);
            formulaMessage.textContent = "@lang('app.formula_divide_the_area')";
            formulaMessage.style.display = 'block';
            break;
            
        case "2": 
            const hectaresFromAcres = numericValue / 2.471;
            hectareDisplay.value = hectaresFromAcres.toFixed(6);
            formulaMessage.textContent = "@lang('app.formula_divide_by_2471')";
            formulaMessage.style.display = 'block';
            break;
            
        case "3":
            hectareDisplay.value = numericValue.toFixed(6);
            formulaMessage.style.display = 'none';
            break;
            
        default:
            hectareDisplay.value = '';
            formulaMessage.style.display = 'none';
    }
}


</script>
@endsection
