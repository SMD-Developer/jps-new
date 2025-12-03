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

    .example-link {
        color: #007bff;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-block;
        margin-top: 5px;
    }
    .example-link:hover {
        text-decoration: underline;
        color: #0056b3;
    }
    .example-link i {
        margin-right: 3px;
    }
    .modal-header {
        border-bottom: 3px solid #0056b3;
    }
    .example-content {
        transition: transform 0.2s;
    }
    .example-content:hover {
        transform: translateX(5px);
    }
    .tips-section ul li {
        margin-bottom: 8px;
    }

    label.required::after {
        content: " *";
        color: red;
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

                                <!-- Application Type Selection - New Field -->
                                @if($client->accountType == 1 || $client->accountType == 2 || $client->accountType == 3 || $client->accountType == 4)
                                    <!-- Application Type Selection - Only for Individu and Pemaju -->
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                            <label for="applicant_type">@lang('Permohonan bagi') <b class="starr"></b></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select id="applicant_type" name="applicant_type" class="form-control form-select" required>
                                                    @php
                                                        $userAccountType = $client->accountType ?? null;
                                                        // Only show account types 1 and 2
                                                        $allowedAccountTypes = $accountTypes->whereIn('id', [1, 2, 3, 4]);
                                                    @endphp
                                                    
                                                    @foreach($allowedAccountTypes as $accountType)
                                                        <option value="{{ $accountType->id }}" 
                                                            {{ $userAccountType == $accountType->id ? 'selected' : '' }}>
                                                            {{ $accountType->name }}
                                                            {{ $userAccountType == $accountType->id ? ' ' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Hidden field for Agency users - store their account type -->
                                    <input type="hidden" name="applicant_type" value="{{ $client->accountType }}">
                                @endif

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
                                           <label for="pemohon" class="required">@lang('app.applicant_individual_company')</label>
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
                                           <label for="ssm" class="required">@lang('app.identification_card_no')</label>
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
                                           <label for="alamat" class="required">@lang('app.applicant_address')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="alamat" class="form-control" name="address" rows="4" placeholder="Alamat Pemohon">{{ $client->registeredAddress ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                           <label for="poskod" class="required">@lang('app.postal_code')</label>
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
                                            <label for="bandar" class="required">@lang('app.city')</label>
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
                                            <label for="negeri" class="required">@lang('app.state')</label>
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
                                            <label for="daerah" >@lang('app.district')</label>
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
                                           <label for="emel" class="required">@lang('app.email_address')</label>
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

                    <!-- Project Information Section -->
                    <div class="section">
                        <h4>@lang('app.project_information')</h4>
                        <div class="container">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="project_name" class="required">@lang('Nama dan Butiran Projek')</label>
                                        <br>
                                        <a href="#" class="example-link" data-toggle="modal" data-target="#projectExampleModal" style="font-size:12px;">
                                            <i class="fa fa-info-circle"></i> Lihat Contoh
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea id="project_name" name="project_name" class="form-control" rows="4" placeholder="Nama Projek"></textarea>
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
                                        <label for="lot-tanah" class="required">Lot Tanah/PT</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="lot-tanah" name="land_lot" class="form-control" placeholder="Land lot">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="keluasan" class="required">@lang('app.land_area')</label>
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
                                        <label for="land_district" class="required">@lang('app.district')</label>
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
                                        <label for="mukim" class="required">@lang('Mukim')</label>
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
                       <!-- File Upload Section with Enhanced Validation -->
                    <h4>@lang('app.upload_supporting_documents')</h4>

                    <!-- Land Grant File Upload -->
                   <div class="form-group">
                        <div class="col-md-4">
                            <label for="geran-tanah">@lang('app.land_grant') <b class="starr">*</b></label>
                        </div>
                        <div class="col-md-8">
                            <label for="land_grant" class="submit-button is-invalid">@lang('app.choose_file')</label>
                            <input type="file" id="land_grant" name="land_grant[]" class="file-input"
                                accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'land_grant')">
                            <div id="land_grant_fileList" class="file-list mt-2"></div>
                            <div id="land_grant_error" class="text-danger mt-1"></div>
                        </div>        
                    </div>

                    <!-- Permission Plan File Upload -->
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="pelan">@lang('app.planning_permission_plan')</label>
                        </div> 
                        <div class="col-md-8">
                            <label for="permission_plan" class="submit-button is-invalid">@lang('app.choose_file')</label>
                            <input type="file" id="permission_plan" name="permission_plan[]" class="file-input"
                                accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'permission_plan')">
                            <div id="permission_plan_fileList" class="file-list mt-2"></div>
                            <div id="permission_plan_error" class="text-danger mt-1"></div>
                        </div>
                    </div>

                    <!-- Letter of Support File Upload -->
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="sokongan">@lang('app.letter_of_support')</label>
                        </div>
                        <div class="col-md-8">
                            <label for="letter_of_support" class="submit-button is-invalid">@lang('app.choose_file')</label>
                            <input type="file" id="letter_of_support" name="letter_of_support[]" class="file-input"
                                accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'letter_of_support')">
                            <div id="letter_of_support_fileList" class="file-list mt-2"></div>
                            <div id="letter_of_support_error" class="text-danger mt-1"></div>
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
            <div class="modal fade" id="projectExampleModal" tabindex="-1" role="dialog" aria-labelledby="projectExampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="projectExampleModalLabel">
                                <i class="fa fa-lightbulb"></i> Contoh Cara Mengisi Nama dan Butiran Projek
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Sila masukkan nama projek dan butiran projek dengan format berikut:
                            </div>
                            
                            <div class="example-content p-3 mb-3" style="background-color: #f8f9fa; border-left: 4px solid #007bff; border-radius: 5px;">
                                <h6 class="text-primary"><strong>Contoh 1: Projek Info</strong></h6>
                                <p class="mb-0"><strong>Butiran:</strong> CADANGAN PEMBANGUNAN UNTUK 50 UNIT RUMAH TERES DAN SEBUAH BANGUNAN PEJABAT 10 TINGKAT DI ATAS PT 121, PT 122, PT 123 DAN PT 124 , MUKIM KLANG,
                                DAERAH KLANG , SELANGOR DARUL EHSAN UNTUK TETUAN ABC SDN. BHD.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fa fa-times"></i> Tutup
                            </button>
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

            // Function to validate required fields
            function validateForm() {
                let isValid = true;
                $('.invalid-feedback').remove();
                $('.form-control').removeClass('is-invalid');

                const selectedAccountType = $('#applicant_type').val();

                // Check required fields
                const requiredFields = [
                    'applicant',  'address', 'postal_code', 
                    'city', 'state', 'district', 'email',
                    'land_lot', 'land_area', 'land_unit', 'land_district', 'land_state',
                    'land_grant', 'project_name'
                ];

                if (selectedAccountType != '3') {
                    requiredFields.push('identities');
                }

                requiredFields.forEach(field => {
                    let value;
                    
                    // Special handling for file inputs
                    if (field === 'land_grant' || field === 'permission_plan' || field === 'letter_of_support') {
                        const fileInput = $(`[name="${field}[]"]`)[0];
                        value = fileInput && fileInput.files.length > 0 ? 'has_files' : '';
                    } else {
                        value = $(`[name="${field}"]`).val();
                    }
                    
                    if (!value) {
                        // For file inputs, target the correct element
                        const targetElement = field === 'land_grant' || field === 'permission_plan' || field === 'letter_of_support' 
                            ? $(`[name="${field}[]"]`) 
                            : $(`[name="${field}"]`);
                            
                        targetElement.addClass('is-invalid');
                        
                        // Check if it's a file field
                        const errorMessage = (field === 'land_grant' || field === 'permission_plan' || field === 'letter_of_support') 
                            ? 'Fail wajib dimuatnaik' 
                            : 'Medan ini wajib diisi';
                        
                        targetElement.after(
                            `<div class="invalid-feedback d-flex justify-content-end">${errorMessage}</div>`
                        );
                        isValid = false;
                        
                        // Scroll to the first invalid field
                        if (isValid === false) {
                            $('html, body').animate({
                                scrollTop: targetElement.offset().top - 100
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

        // File validation functions - UPDATED FOR MULTIPLE FILES
        function validateFileSize(input) {
            const maxSize = 15 * 1024 * 1024; 
            const files = input.files;
            const fieldName = input.name.replace('[]', ''); 
            const fileNameDisplay = document.getElementById(fieldName + 'fileName');
            
            const existingError = input.parentElement.querySelector('.file-size-error');
            if (existingError) {
                existingError.remove();
            }
            
            if (files && files.length > 0) {
                let allValid = true;
                let invalidFiles = [];
                
                // Check each file
                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > maxSize) {
                        allValid = false;
                        invalidFiles.push(files[i].name);
                    }
                }
                
                if (!allValid) {
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
                    errorDiv.textContent = 'Fail berikut melebihi had 15MB: ' + invalidFiles.join(', ') + '. Sila pilih fail yang lebih kecil.';
                    
                    // Insert error message after the file name display
                    if (fileNameDisplay) {
                        fileNameDisplay.parentNode.insertBefore(errorDiv, fileNameDisplay.nextSibling);
                    } else {
                        input.parentElement.appendChild(errorDiv);
                    }
                    
                    return false;
                } else {
                    // All files are valid
                    if (fileNameDisplay) {
                        let fileList = '';
                        for (let i = 0; i < files.length; i++) {
                            fileList += files[i].name + ' (' + formatFileSize(files[i].size) + ')';
                            if (i < files.length - 1) fileList += ', ';
                        }
                        fileNameDisplay.textContent = fileList;
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applicantTypeSelect = document.getElementById('applicant_type');
        
        if (applicantTypeSelect) {
            // Store the original account type
            const originalAccountType = '{{ $client->accountType }}';
            
            applicantTypeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                
                // Check if selected type is different from original
                if (selectedType != originalAccountType) {
                    // Clear personal information fields
                    document.getElementById('pemohon').value = '';
                    document.getElementById('ssm').value = '';
                    document.getElementById('alamat').value = '';
                    document.getElementById('poskod').value = '';
                    document.getElementById('bandar').value = '';
                    document.getElementById('negeri').selectedIndex = 0;
                    document.getElementById('daerah').selectedIndex = 0;
                    document.getElementById('emel').value = '';
                    document.getElementById('telefon').value = '';
                    
                    // Clear project information
                    document.getElementById('project_name').value = '';
                    
                    // Clear lot information
                    document.getElementById('lot-tanah').value = '';
                    document.getElementById('land-unit').selectedIndex = 0;
                    document.getElementById('keluasan').value = '';
                    document.getElementById('hectare-display').value = '';
                    document.getElementById('land_district').selectedIndex = 0;
                    document.getElementById('mukim').selectedIndex = 0;
                    
                    // Clear file uploads
                    document.getElementById('land_grant').value = '';
                    document.getElementById('land_grantfileName').textContent = '';
                    document.getElementById('permission_plan').value = '';
                    document.getElementById('permission_planfileName').textContent = '';
                    document.getElementById('letter_of_support').value = '';
                    document.getElementById('letter_of_supportfileName').textContent = '';
                } else {
                    // Restore original values if switching back to original account type
                    document.getElementById('pemohon').value = '{{ $client->userName ?? "" }}';
                    document.getElementById('ssm').value = '{{ $client->idCardNumber ?? "" }}';
                    document.getElementById('alamat').value = '{{ $client->registeredAddress ?? "" }}';
                    document.getElementById('poskod').value = '{{ $client->postalCode ?? "" }}';
                    document.getElementById('bandar').value = '{{ $client->city ?? "" }}';
                    document.getElementById('emel').value = '{{ $client->email ?? "" }}';
                    document.getElementById('telefon').value = '{{ $client->mobileNumber ?? "" }}';
                    
                    // Restore state and district selections
                    @if(isset($client->state_id))
                    document.getElementById('negeri').value = '{{ $client->state_id }}';
                    @endif
                    
                    @if(isset($client->district_id))
                    document.getElementById('daerah').value = '{{ $client->district_id }}';
                    @endif
                }
            });
        }
    });
</script>

<script>
    let fileStorage = {};

    function handleMultipleFiles(input, fieldName) {
        const newFiles = Array.from(input.files);
        const maxSize = 15 * 1024 * 1024; // 15MB
        const errorDiv = document.getElementById(fieldName + '_error');
        const fileListDiv = document.getElementById(fieldName + '_fileList');
        
        // Clear previous errors
        if (errorDiv) {
            errorDiv.innerHTML = '';
        }
        
        // Validate each NEW file
        let hasError = false;
        let errorMessages = [];
        
        newFiles.forEach((file, index) => {
            // Check file type
            if (file.type !== 'application/pdf') {
                errorMessages.push(`${file.name}: Hanya fail PDF dibenarkan`);
                hasError = true;
            }
            
            // Check file size
            if (file.size > maxSize) {
                errorMessages.push(`${file.name}: Saiz fail melebihi 15MB`);
                hasError = true;
            }
        });
        
        if (hasError) {
            if (errorDiv) {
                errorDiv.innerHTML = errorMessages.join('<br>');
            }
            input.value = ''; // Clear the input
            return false;
        }
        
        // MERGE: Add new files to existing files (don't replace)
        const existingFiles = fileStorage[fieldName] || [];
        const allFiles = [...existingFiles, ...newFiles];
        
        // Store merged files
        fileStorage[fieldName] = allFiles;
        
        // Update the file input with all files
        const dt = new DataTransfer();
        allFiles.forEach(file => {
            dt.items.add(file);
        });
        input.files = dt.files;
        
        // Display all files
        displayFileList(fieldName, allFiles);
        
        return true;
    }

    function displayFileList(fieldName, files) {
        const fileListDiv = document.getElementById(fieldName + '_fileList');
        
        if (!fileListDiv) return;
        
        fileListDiv.innerHTML = '';
        
        if (files.length === 0) {
            return;
        }
        
        // Create container for file list
        const container = document.createElement('div');
        container.style.cssText = 'border: 1px solid #ddd; padding: 10px; border-radius: 5px; background-color: #f9f9f9; margin-top: 10px;';
        
        // Add each file
        files.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.style.cssText = 'display: flex; justify-content: space-between; align-items: center; padding: 8px; margin-bottom: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;';
            
            // File info
            const fileInfo = document.createElement('span');
            fileInfo.style.cssText = 'flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #333;';
            fileInfo.innerHTML = `<i class="fa fa-file-pdf" style="color: #d32f2f; margin-right: 8px;"></i>${file.name} <small style="color: #666;">(${formatFileSize(file.size)})</small>`;
            
            // Remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.style.cssText = 'margin-left: 10px; padding: 2px 8px; font-size: 12px;';
            removeBtn.innerHTML = '<i class="fa fa-times"></i> Buang';
            removeBtn.onclick = function(e) {
                e.preventDefault();
                removeFile(fieldName, index);
            };
            
            fileItem.appendChild(fileInfo);
            fileItem.appendChild(removeBtn);
            container.appendChild(fileItem);
        });
        
        // Add count summary
        const summary = document.createElement('div');
        summary.style.cssText = 'margin-top: 8px; font-weight: bold; color: #007bff; font-size: 14px;';
        summary.innerHTML = `<i class="fa fa-check-circle"></i> Jumlah fail: ${files.length}`;
        container.appendChild(summary);
        
        fileListDiv.appendChild(container);
    }

    function removeFile(fieldName, index) {
        // Remove file from storage
        if (fileStorage[fieldName]) {
            fileStorage[fieldName].splice(index, 1);
            
            // Update the file input
            const input = document.getElementById(fieldName);
            const dt = new DataTransfer();
            
            fileStorage[fieldName].forEach(file => {
                dt.items.add(file);
            });
            
            input.files = dt.files;
            
            // Update display
            displayFileList(fieldName, fileStorage[fieldName]);
            
            // If no files left, clear validation error if exists
            if (fileStorage[fieldName].length === 0) {
                $(input).removeClass('is-invalid');
                $(input).next('.invalid-feedback').remove();
            }
        }
    }

    // Helper function for file size formatting
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@endsection
