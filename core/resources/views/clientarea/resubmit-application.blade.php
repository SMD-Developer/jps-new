<!--@extends('clientarea.app')-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .file-input {
        display: none;
        /* Hide the default file input */
    }

    .upload-button {
        padding: 10px 20px;
        border: 2px solid #ccc;
        border-radius: 5px;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .upload-button:hover {
        background-color: #e0e0e0;
    }

    .file-name {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }

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


    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ccc !important;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f9f9f9;
    }

    .total-row td {
        font-weight: bold;
        background-color: #f1f1f1;
    }

    .delete-btn {
        color: red;
        cursor: pointer;
        font-weight: bold;
    }

    /* Form validation styling */
    .is-invalid {
        border-color: #dc3545 !important;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .text-danger {
        color: #dc3545 !important;
        font-size: 80%;
        margin-top: 0.25rem;
    }

    .starr {
        color: red;
    }

    /* Improved form styling */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-container {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .section h4 {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-actions button,
        .form-actions a {
            width: 100%;
        }
    }

    /* File upload styling */
    .file-input {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .upload-button {
        display: inline-block;
        padding: 8px 12px;
        cursor: pointer;
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .upload-button:hover {
        background-color: #e0e0e0;
    }

    .file-name {
        display: inline-block;
        margin-left: 10px;
        font-style: italic;
    }
    
    .remove-file-btn {
    font-size: 14px;
    cursor: pointer;
    }
    .remove-file-btn:hover {
        opacity: 0.8;
    }

    .submit-button.is-invalid {
        border: 1px solid grey !important;
        border-radius: 4px;
        padding: 6px 12px;
    }

</style>
<title>@lang('app.resumbit_application') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-wrench" aria-hidden="true"></i> @lang('app.resumbit_application')</h5>
    </div>


    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.applicant_informatio')</h4>
                        <form action="{{ route('updateResubmitApplication', $application->id) }}" method="POST"
                            enctype="multipart/form-data" id="updateApplicationForm">
                            @csrf
                            @method('PUT')
                            {{-- <div class="form-group">
                                <label for="application_reference">@lang('app.no_application_ref')</label>
                                <input type="text" id="application_reference" name="refference_no" class="form-control"
                                    value="{{ $application->refference_no ?? '' }}" placeholder="@lang('app.no_application_ref')"
                                    required>
                                @error('refference_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="tarikh">@lang('app.date')</label>
                                <input id="tarikh" name="uploade_date" class="form-control" placeholder=""
                                    value="{{ date('Y-m-d') }}" readonly>
                                @error('uploade_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="pemohon">@lang('app.applicant') @lang('app.individual') / @lang('app.company')</label>
                                <input type="text" id="pemohon" name="applicant" class="form-control"
                                    placeholder="@lang('app.applicant')  @lang('app.individual') / @lang('app.company')"
                                    value="{{ $application->applicant }}">
                                @error('applicant')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ssm">@lang('app.identification_card_no')</label>
                                <input type="text" name="identities" id="ssm" class="form-control"
                                    placeholder="@lang('app.identification_card_no')" value="{{ $application->identities }}">
                                @error('identities')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">@lang('app.address_of_applicant')</label>
                                <textarea id="alamat" name="address" class="form-control" rows="4" placeholder="@lang('app.address_of_applicant')">{{ $application->address }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="poskod">@lang('app.postal_code')</label>
                                <input type="text" id="poskod" name="postal_code" class="form-control"
                                    placeholder="@lang('app.postal_code')" value="{{ $application->postal_code }}"
                                    pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('postal_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="bandar">@lang('app.city')</label>
                                <input type="text" id="bandar" name="city" class="form-control"
                                    placeholder="@lang('app.city')" value="{{ $application->city }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="negeri">@lang('app.state')</label>
                                <select id="negeri" class="form-control form-select" name="state">
                                    <option value="" disabled>@lang('app.please_select_state')</option>
                                    @foreach ($state as $value)
                                        <option value="{{ $value->idnegeri }}" 
                                                data-state-code="{{ $value->negeri_code }}"
                                                {{ $application->state == $value->idnegeri ? 'selected' : '' }}>
                                            {{ $value->negeri_code }} - {{ $value->negeri }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="daerah">@lang('app.district')</label>
                                <select id="daerah" class="form-control form-select" name="district">
                                    <option value="">@lang('app.select_district')</option>
                                    @foreach ($district as $value)
                                        <option value="{{ $value->iddaerah }}"
                                            {{ $application->district == $value->iddaerah ? 'selected' : '' }}>
                                            {{ $value->daerah_code }} - {{ $value->daerah }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="emel">@lang('app.email_address')</label>
                                <input type="email" id="emel" name="email" class="form-control"
                                    placeholder="@lang('app.email_address')" value="{{ $application->email }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefon">@lang('app.telephone_no')</label>
                                <input type="tel" id="telefon" name="phone" class="form-control"
                                    placeholder="@lang('app.telephone_no')" value="{{ $application->phone }}" pattern="[0-9]*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>

                    {{-- <input type="hidden" id="adjustment_amount_input" name="adjustment_percentage"
                        value="{{ $application->adjustment_percentage ?? '0' }}">

                    <input type="hidden" id="land_category_input" name="land_category"
                        value="{{ $application->land_category ?? '0' }}">
                    <input type="hidden" id="hectare_input" name="hectare" value="{{ $application->hectare ?? '0' }}">
                    <input type="hidden" id="base_amount_input" name="base_amount"
                        value="{{ $application->base_amount ?? '0' }}">
                    <input type="hidden" id="discount_amount_input" name="discount_amount"
                        value="{{ $application->discount_amount ?? '0' }}">
                    <input type="hidden" id="final_amount_input" name="final_amount"
                        value="{{ $application->final_amount ?? '0' }}">
                    <input type="hidden" id="cost_input" name="cost" value="{{ $application->cost ?? '0' }}"> --}}


                    <div class="section">
                        <h4>Maklumat Projek</h4>                              
                                <div class="form-group">
                                        <label for="project_name">@lang('Nama dan Butiran Projek')</label>
                                        <textarea id="project_name" name="project_name" class="form-control" rows="4" 
                                            placeholder="Nama Projek">{{ $application->project_name ?? '' }}</textarea>
                                        @error('project_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                    </div>
                        

                    <!-- Lot Information Section -->
                    <div class="section">
                        <h4>@lang('app.lot_information')</h4>
                        <div class="form-group">
                            <label for="lot-tanah">@lang('app.land_lot')</label>
                            <input type="text" id="lot-tanah" name="land_lot" class="form-control"
                                placeholder="@lang('app.land_lot')" value="{{ $application->land_lot }}">
                            @error('land_lot')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keluasan">@lang('app.land_area')</label>
                            <div class="d-flex align-items-center">
                                <select id="land-unit" name="land_unit" class="form-control form-select me-3"
                                   onchange="updateConversionMessage(); convertToHectare();">
                                    <option value="" disabled>- Sila Pilih -</option>
                                    @foreach ($landMeasurement as $land)
                                        <option value="{{ $land->id }}"
                                            {{ $application->land_unit == $land->id ? 'selected' : '' }}>
                                            {{ $land->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" id="keluasan" name="land_area" class="form-control"
                                    placeholder="Land area" value="{{ $application->land_area }}"
                                    oninput="validateInput(this); convertToHectare();">
                                <span class="mx-2">=</span>
                                <input type="text" id="hectare-display" class="form-control"
                                    placeholder="@lang('app.hectare')">
                                <span class="ml-2">@lang('app.hectare')</span>
                            </div>
                            <div class="mt-1 px-5 mx-5">
                                <small id="conversion-message" class="text-warning"
                                    style="color: orange !important;display: block;margin: 5px 140px;">@lang('app.formula_divide_the_area')</small>
                            </div>
                            <div class="invalid-feedback d-flex justify-content-end"
                                style="color: red; display: block; margin-top: 5px;" id="hectare-conversion"></div>
                            @error('land_area')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('land_unit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="land_district">@lang('app.district')</label>
                            <select id="land_district" class="form-control form-select" name="land_district">
                                <option value="" selected disabled>@lang('app.select_district')</option>
                                @foreach ($district->where('idnegeri', 1) as $value)
                                    <option value="{{ $value->iddaerah }}"
                                        {{ $application->land_district == $value->iddaerah ? 'selected' : '' }}>
                                        {{ $value->daerah_code }} - {{ $value->daerah }}
                                    </option>
                                @endforeach
                            </select>
                            @error('land_district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mukim">@lang('Mukim')</label>
                            <select id="mukim" class="form-control form-select" name="land_state">
                                <option value="" disabled>@lang('app.select_division')</option>
                                @foreach ($division as $value)
                                    <option value="{{ $value->idmukim }}"
                                        {{ $application->land_state == $value->idmukim ? 'selected' : '' }}>
                                        {{ $value->mukim_code }} - {{ $value->mukim }}
                                    </option>
                                @endforeach
                            </select>
                            @error('land_state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="section">
                        <h4>@lang('app.supporting_documents')</h4>

                        <!-- Land Grant -->
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
                                
                                <!-- Show existing files with remove option -->
                                @if ($application->land_grant)
                                    @php
                                        // Handle both JSON string and array
                                        if (is_string($application->land_grant)) {
                                            $landGrantFiles = json_decode($application->land_grant, true);
                                        } else {
                                            $landGrantFiles = $application->land_grant;
                                        }
                                    @endphp
                                    @if (is_array($landGrantFiles) && count($landGrantFiles) > 0)
                                        <div class="mt-3">
                                            <small class="text-info"><strong>Current files:</strong></small>
                                            <div id="existing_land_grant_files" style="display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
                                                @foreach ($landGrantFiles as $index => $filePath)
                                                    <div class="existing-file-item" data-field="land_grant" data-index="{{ $index }}" style="display: flex; align-items: center; padding: 6px 10px; background-color: #e7f3ff; border-radius: 4px; border: 1px solid #b3d9ff;">
                                                        <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px; flex-shrink: 0;"></i>
                                                        <a href="{{ url($filePath) }}" target="_blank" style="flex: 1; color: #0056b3; text-decoration: none; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                           {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-existing-file" style="margin-left: 10px; padding: 2px 8px; font-size: 12px;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small id="land_grant_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($landGrantFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                <!-- Hidden input to track removed files -->
                                <input type="hidden" name="removed_land_grant" id="removed_land_grant" value="">
                                @error('land_grant')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>        
                        </div>

                        <!-- Planning Permission Plan -->
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
                                
                                <!-- Show existing files with remove option -->
                                @if ($application->permission_plan)
                                    @php
                                        // Handle both JSON string and array
                                        if (is_string($application->permission_plan)) {
                                            $permissionPlanFiles = json_decode($application->permission_plan, true);
                                        } else {
                                            $permissionPlanFiles = $application->permission_plan;
                                        }
                                    @endphp
                                    @if (is_array($permissionPlanFiles) && count($permissionPlanFiles) > 0)
                                        <div class="mt-3">
                                            <small class="text-info"><strong>Current files:</strong></small>
                                            <div id="existing_permission_plan_files" style="display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
                                                @foreach ($permissionPlanFiles as $index => $filePath)
                                                    <div class="existing-file-item" data-field="permission_plan" data-index="{{ $index }}" style="display: flex; align-items: center; padding: 6px 10px; background-color: #e7f3ff; border-radius: 4px; border: 1px solid #b3d9ff;">
                                                        <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px; flex-shrink: 0;"></i>
                                                        <a href="{{ url($filePath) }}" target="_blank" style="flex: 1; color: #0056b3; text-decoration: none; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-existing-file" style="margin-left: 10px; padding: 2px 8px; font-size: 12px;">
                                                            <i class="fa fa-times"></i> 
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small id="permission_plan_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($permissionPlanFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                <!-- Hidden input to track removed files -->
                                <input type="hidden" name="removed_permission_plan" id="removed_permission_plan" value="">
                                @error('permission_plan')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <!-- Letter of Support -->
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
                                
                                <!-- Show existing files with remove option -->
                                @if ($application->letter_of_support)
                                    @php
                                        // Handle both JSON string and array
                                        if (is_string($application->letter_of_support)) {
                                            $letterOfSupportFiles = json_decode($application->letter_of_support, true);
                                        } else {
                                            $letterOfSupportFiles = $application->letter_of_support;
                                        }
                                    @endphp
                                    @if (is_array($letterOfSupportFiles) && count($letterOfSupportFiles) > 0)
                                        <div class="mt-3">
                                            <small class="text-info"><strong>Current files:</strong></small>
                                            <div id="existing_letter_of_support_files" style="display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
                                                @foreach ($letterOfSupportFiles as $index => $filePath)
                                                    <div class="existing-file-item" data-field="letter_of_support" data-index="{{ $index }}" style="display: flex; align-items: center; padding: 6px 10px; background-color: #e7f3ff; border-radius: 4px; border: 1px solid #b3d9ff;">
                                                        <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px; flex-shrink: 0;"></i>
                                                        <a href="{{ url($filePath) }}" target="_blank" style="flex: 1; color: #0056b3; text-decoration: none; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-existing-file" style="margin-left: 10px; padding: 2px 8px; font-size: 12px;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small id="letter_of_support_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($letterOfSupportFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                <!-- Hidden input to track removed files -->
                                <input type="hidden" name="removed_letter_of_support" id="removed_letter_of_support" value="">
                                @error('letter_of_support')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>    
                        </div>
                        <p class="note">
                            * @lang('app.files_only_pdf_format_size_not_exceed_15mb')
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    </form>

                    <!--Submit Section -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn2"
                            id="updatetButton"><i class="fa fa-paper-plane"></i> @lang('app.send')</button>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        const today = new Date();
        const formattedDate = [
            String(today.getDate()).padStart(2, '0'), 
            String(today.getMonth() + 1).padStart(2, '0'), 
            String(today.getFullYear()).slice(0) 
        ].join('/');
        document.getElementById('tarikh').placeholder = formattedDate;
    </script>

    <script>
        let landCategories = @json($landCategories);
        document.addEventListener("DOMContentLoaded", function() {
            let landCategorySelect = document.getElementById("land_category");
            let costInput = document.getElementById("cost");
            let hectareInput = document.getElementById("hectare");
            let discountInput = document.getElementById("discount");
            let marginInput = document.getElementById("margin");
            let squareMetersInput = document.getElementById("keluasan");

            // Get saved values from hidden inputs
            const landCategoryId = document.getElementById('land_category_input')?.value;
            const hectareValue = document.getElementById('hectare_input')?.value;
            const discountValue = document.getElementById('adjustment_amount_input')?.value;
            const marginValue = marginInput?.value;


            const savedCostValue = document.getElementById('cost_input')?.value;

            // Initialize values
            if (landCategoryId && landCategoryId !== '0') {
                landCategorySelect.value = landCategoryId;

                // Check if it's the "Lain-Lain" category (ID 4)
                if (landCategoryId === '4') {
                    costInput.readOnly = false; // Make editable for Lain-Lain

                    // If there's a saved cost value from the database, use it
                    if (savedCostValue && savedCostValue !== '0') {
                        costInput.value = "RM " + parseFloat(savedCostValue).toFixed(2);
                    } else {
                        costInput.value = "RM ";
                    }
                } else {
                    // For standard categories, use the predefined rate
                    costInput.readOnly = true;
                    setCostFromCategory(landCategoryId);
                }
            }


            if (squareMetersInput && squareMetersInput.value) {
                convertToHectare();
            } else if (hectareValue && hectareValue !== '0') {
                hectareInput.value = parseFloat(hectareValue).toFixed(2);
            }

            if (discountValue && discountValue !== '0') {
                discountInput.value = parseFloat(discountValue).toFixed(2);
            }
            if (marginValue && marginValue !== '0') {
                marginInput.value = parseFloat(marginValue).toFixed(2);
            }

            // Run calculations immediately to use the populated values
            updateAllValues();

            // Square meters input validation and conversion
            if (squareMetersInput) {
                squareMetersInput.addEventListener("input", function() {
                    validateInput(this);
                    convertToHectare();
                    updateAllValues(); 
                });
            }

            function validateInput(input) {
                input.value = input.value.replace(/[^0-9]/g, '');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInputs = [{
                    input: 'land_grant',
                    display: 'land_grantfileName'
                },
                {
                    input: 'permission_plan',
                    display: 'permission_planfileName'
                },
                {
                    input: 'letter_of_support',
                    display: 'letter_of_supportfileName'
                }
            ];

            fileInputs.forEach(({
                input,
                display
            }) => {
                const fileInput = document.getElementById(input);
                const fileNameDisplay = document.getElementById(display);

                if (fileInput && fileNameDisplay) {
                    fileInput.addEventListener('change', function() {
                        const fileName = this.files[0] ? this.files[0].name : '';
                        fileNameDisplay.textContent = fileName ? `${fileName}` : '';
                    });
                }
            });
        });
    </script>
    <script>
        // Store files for each input
        let fileStorage = {};

        // Main function to handle multiple files
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
                if (fileListDiv) {
                    fileListDiv.innerHTML = '';
                }
                fileStorage[fieldName] = [];
                return false;
            }
            
            // MERGE: Add new files to existing files
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
            
            // Clear previous content
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
                fileInfo.innerHTML = `<i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>${file.name} <small style="color: #666;">(${formatFileSize(file.size)})</small>`;
                
                // Remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-danger';
                removeBtn.style.cssText = 'margin-left: 10px; padding: 2px 8px; font-size: 12px;';
                removeBtn.innerHTML = '<i class="fa fa-times"></i>';
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
            summary.innerHTML = `<i class="fa fa-check-circle"></i> Jumlah fail dipilih: ${files.length}`;
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
                    const errorDiv = document.getElementById(fieldName + '_error');
                    if (errorDiv) errorDiv.innerHTML = '';
                }
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxFileSize = 15 * 1024 * 1024; 
            const allowedTypes = ['application/pdf'];
            
            let fileValidationStatus = {
                land_grant: true,
                permission_plan: true,
                letter_of_support: true
            };
            
            function validateFile(file, fieldName) {
                const errors = [];
                
                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    errors.push(`Only PDF files are allowed.`);
                }
                
                // Check file size
                if (file.size > maxFileSize) {
                    errors.push(`Saiz fail melebihi had 15mb.Sila pilih fail yang lebih kecil.`);
                }
                
                return errors;
            }
            
    
            function showFileError(inputElement, message) {
                const errorId = inputElement.id + '-file-error';
                
                // Remove existing error messages
                document.getElementById(errorId)?.remove();
                
                // Add error message
                const errorDiv = document.createElement('div');
                errorDiv.id = errorId;
                errorDiv.className = 'text-danger mt-2';
                errorDiv.textContent = message;
                inputElement.parentNode.appendChild(errorDiv);
                
                // Add error styling to input
                inputElement.classList.add('is-invalid');
                
                // Update validation status
                fileValidationStatus[inputElement.id] = false;
            }
            

            function clearFileError(inputElement) {
                const errorId = inputElement.id + '-file-error';
                document.getElementById(errorId)?.remove();
                inputElement.classList.remove('is-invalid');
                
                // Update validation status
                fileValidationStatus[inputElement.id] = true;
            }
        
            // Function to check if all files are valid
            function areAllFilesValid() {
                return Object.values(fileValidationStatus).every(status => status === true);
            }
        
            function validateFilesOnSubmit() {
                const fileInputs = ['land_grant', 'permission_plan', 'letter_of_support'];
                let allValid = true;
                
                fileInputs.forEach(inputId => {
                    const fileInput = document.getElementById(inputId);
                    if (fileInput && fileInput.files.length > 0) {
                        Array.from(fileInput.files).forEach(file => {
                            const errors = validateFile(file, inputId);
                            
                            if (errors.length > 0) {
                                showFileError(fileInput, errors.join(' '));
                                allValid = false;
                            } else {
                                clearFileError(fileInput);
                            }
                        });
                    } else {
                        if (fileInput) {
                            clearFileError(fileInput);
                        }
                    }
                });
                
                return allValid;
            }
            window.validateFileSize = function() {
                return validateFilesOnSubmit() && areAllFilesValid();
            };
        });
    </script>
    <script>
        function confirmNavigation(url) {
            Swal.fire({
                title: "@lang('app.are_you_sure')", 
                text: "@lang('app.you_want_to_generate_letter')", 
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "@lang('app.yes')",
                cancelButtonText: "@lang('app.cancel')"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
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
            const hectareInput = document.getElementById('hectare'); // Add this line to get the hectare input
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

                hectareDisplay.value = hectares.toFixed(6);

                if (hectareInput) {
                    hectareInput.value = hectares.toFixed(6);
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
            let formIsReady = true;
            const applicationType = '{{ $application->applicant_type }}';
            function getApplicationType() {
                return applicationType;
            }

            function isDistrictRequired() {
                const selectedOption = $('#negeri option:selected');
                const stateCode = selectedOption.data('state-code');
                
                // District is NOT required for state codes 14, 15, 16
                const exemptStateCodes = [14, 15, 16];
                return !exemptStateCodes.includes(parseInt(stateCode));
            }

            // Function to update district field requirement
            function updateDistrictRequirement() {
                const districtField = $('#daerah');
                const districtLabel = $('label[for="daerah"]');
                
                if (!isDistrictRequired()) {
                    // Remove required validation for exempt states
                    districtField.removeClass('is-invalid');
                    districtField.next('.invalid-feedback').remove();
                    $('#daerah-error').remove();
                    
                    // Remove red asterisk
                    districtLabel.find('.starr').remove();
                    
                    // Clear the field if desired
                    // districtField.val('');
                } else {
                    // Add red asterisk for states that require district
                    if (!districtLabel.find('.starr').length) {
                        districtLabel.append(' <b class="starr">*</b>');
                    }
                }
            }

            // Function to update ID card field requirement based on account type
            function updateIdCardRequirement() {
                const appType = getApplicationType();
                const ssmField = $('#ssm');
                const ssmLabel = $('label[for="ssm"]');
                
                if (appType == '3') {
                    // Remove required validation for account type 3
                    ssmField.removeClass('is-invalid');
                    ssmField.next('.invalid-feedback').remove();
                    $('#ssm-error').remove();
                    
                    // Remove red asterisk
                    ssmLabel.find('.starr').remove();
                } else {
                    // Add red asterisk for other account types
                    if (!ssmLabel.find('.starr').length) {
                        ssmLabel.append(' <b class="starr">*</b>');
                    }
                }
            }

            // Initial check on page load
            updateIdCardRequirement();
            updateDistrictRequirement();

            // Function to check if form is valid
            function checkFormAndToggleButton() {
                let formIsValid = true;
                const appType = getApplicationType();

                // Build required fields list based on account type
                let requiredFields = [
                    'pemohon', 'alamat', 'poskod',
                    'bandar', 'negeri', 'emel',
                    'lot-tanah', 'keluasan', 'land_district', 'mukim', 'project_name'
                ];

                // Only add ssm if NOT account type 3
                if (appType != '3') {
                    requiredFields.push('ssm');
                }

                // Only add district if required (not state codes 14, 15, 16)
                if (isDistrictRequired()) {
                    requiredFields.push('daerah');
                }

                // Check each required field
                requiredFields.forEach(field => {
                    const element = $('#' + field);
                    if (element.length) {
                        let value = element.val();

                        // Skip validation for fields that are read-only or disabled
                        if (element.prop('readonly') || element.prop('disabled')) {
                            return;
                        }

                        if (!value || value.trim() === '') {
                            formIsValid = false;
                        }
                    }
                });

                // Check email validation
                const emailElement = $('#emel');
                if (emailElement.length && emailElement.val().trim() !== '') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailElement.val())) {
                        formIsValid = false;
                    }
                }

                // Check postal code validation
                const postalElement = $('#poskod');
                if (postalElement.length && postalElement.val().trim() !== '') {
                    const postalPattern = /^[0-9]+$/;
                    if (!postalPattern.test(postalElement.val())) {
                        formIsValid = false;
                    }
                }
                
                const landGrantInput = $('#land_grant');
                if (landGrantInput.length) {
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info').length > 0;
                    if (!hasExistingFile && landGrantInput[0].files.length === 0) {
                        formIsValid = false;
                    }
                }

                // Enable or disable the Generate Letter button based on form validity
                if (formIsValid) {
                    $('#generateLetterButton').removeClass('disabled').attr('onclick',
                        "confirmNavigation('{{ route('user_letter', ['application_id' => $application->id]) }}')"
                    );
                } else {
                    $('#generateLetterButton').addClass('disabled').attr('onclick', 'return false;');
                }
            }

            // Validate form function
            function validateForm() {
                let isValid = true;
                let firstInvalidField = null;
                const appType = getApplicationType();

                // Build required fields based on account type
                const requiredFields = [];
                
                const allFields = [
                    { id: 'pemohon', name: 'Applicant' },
                    { id: 'alamat', name: 'Address' },
                    { id: 'poskod', name: 'Postal Code' },
                    { id: 'bandar', name: 'City' },
                    { id: 'negeri', name: 'State' },
                    { id: 'emel', name: 'Email' },
                    { id: 'lot-tanah', name: 'Land Lot' },
                    { id: 'keluasan', name: 'Land Area' },
                    { id: 'land_district', name: 'Land District' },
                    { id: 'mukim', name: 'Mukim' }
                ];

                // Add ssm only if NOT account type 3
                if (appType != '3') {
                    requiredFields.push({ id: 'ssm', name: 'Identification Card No' });
                }

                // Add district only if required (not state codes 14, 15, 16)
                if (isDistrictRequired()) {
                    requiredFields.push({ id: 'daerah', name: 'District' });
                }

                // Add all other fields
                requiredFields.push(...allFields);

                // Check each required field
                requiredFields.forEach(field => {
                    const element = $('#' + field.id);
                    if (element.length) {
                        let value = element.val();

                        // Skip validation for fields that are read-only or disabled
                        if (element.prop('readonly') || element.prop('disabled')) {
                            return;
                        }

                        if (!value || value.trim() === '') {
                            isValid = false;

                            // Add error class and message
                            element.addClass('is-invalid');

                            // Create error message if it doesn't exist
                            let errorId = field.id + '-error';
                            if ($('#' + errorId).length === 0) {
                                element.after('<div id="' + errorId +
                                    '" class="text-danger">This field is required</div>');
                            } else {
                                $('#' + errorId).text('This field is required').show();
                            }

                            // Store first invalid field for scrolling
                            if (!firstInvalidField) {
                                firstInvalidField = element;
                            }
                        } else {
                            // Remove error class and hide message
                            element.removeClass('is-invalid');
                            $('#' + field.id + '-error').hide();
                        }
                    }
                });

                // Validate email format if provided
                const emailElement = $('#emel');
                if (emailElement.length && emailElement.val().trim() !== '') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailElement.val())) {
                        isValid = false;
                        emailElement.addClass('is-invalid');

                        if ($('#emel-error').length === 0) {
                            emailElement.after(
                                '<div id="emel-error" class="text-danger">Please enter a valid email address</div>'
                            );
                        } else {
                            $('#emel-error').text('Please enter a valid email address').show();
                        }

                        if (!firstInvalidField) {
                            firstInvalidField = emailElement;
                        }
                    }
                }

                // Validate postal code format if provided (numeric only)
                const postalElement = $('#poskod');
                if (postalElement.length && postalElement.val().trim() !== '') {
                    const postalPattern = /^[0-9]+$/;
                    if (!postalPattern.test(postalElement.val())) {
                        isValid = false;
                        postalElement.addClass('is-invalid');

                        if ($('#poskod-error').length === 0) {
                            postalElement.after(
                                '<div id="poskod-error" class="text-danger">Postal code must contain only numbers</div>'
                            );
                        } else {
                            $('#poskod-error').text('Postal code must contain only numbers').show();
                        }

                        if (!firstInvalidField) {
                            firstInvalidField = postalElement;
                        }
                    }
                }

                // Validate phone number format if provided (numeric only)
                const phoneElement = $('#telefon');
                if (phoneElement.length && phoneElement.val().trim() !== '') {
                    const phonePattern = /^[0-9]+$/;
                    if (!phonePattern.test(phoneElement.val())) {
                        isValid = false;
                        phoneElement.addClass('is-invalid');

                        if ($('#telefon-error').length === 0) {
                            phoneElement.after(
                                '<div id="telefon-error" class="text-danger">Phone number must contain only numbers</div>'
                            );
                        } else {
                            $('#telefon-error').text('Phone number must contain only numbers').show();
                        }

                        if (!firstInvalidField) {
                            firstInvalidField = phoneElement;
                        }
                    }
                }

                
                const landGrantInput = $('#land_grant');
                if (landGrantInput.length) {
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info').length > 0;

                    if (!hasExistingFile && landGrantInput[0].files.length === 0) {
                        isValid = false;

                        if ($('#land_grant-error').length === 0) {
                            landGrantInput.closest('.form-group').append(
                                '<div id="land_grant-error" class="text-danger">Land grant document is required</div>'
                            );
                        } else {
                            $('#land_grant-error').text('Land grant document is required').show();
                        }

                        if (!firstInvalidField) {
                            firstInvalidField = landGrantInput;
                        }
                    } else {
                        $('#land_grant-error').hide();
                    }
                }

                
                if (firstInvalidField) {
                    $('html, body').animate({
                        scrollTop: firstInvalidField.offset().top - 100
                    }, 500);
                }

                return isValid;
            }

            // Run the check when page loads
            checkFormAndToggleButton();

            // Add input validation on blur for all required fields
            $('.form-control').on('blur', function() {
                const id = $(this).attr('id');
                const appType = getApplicationType();
                
                if (id) {
                    // Skip validation for land_grant field
                    if (id === 'land_grant') {
                        return;
                    }

                    // Skip ssm validation if account type is 3
                    if (id === 'ssm' && appType == '3') {
                        return;
                    }

                    // Skip district validation if not required (state codes 14, 15, 16)
                    if (id === 'daerah' && !isDistrictRequired()) {
                        return;
                    }

                    const value = $(this).val();
                    if (id !== 'telefon') {
                        if (!value || value.trim() === '') {
                            $(this).addClass('is-invalid');

                            // Create error message if it doesn't exist
                            if ($('#' + id + '-error').length === 0) {
                                $(this).after('<div id="' + id +
                                    '-error" class="text-danger">This field is required</div>');
                            } else {
                                $('#' + id + '-error').text('This field is required').show();
                            }
                        } else {    
                            $(this).removeClass('is-invalid');
                            $('#' + id + '-error').hide();
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                        $('#' + id + '-error').hide();
                    }
                }
                checkFormAndToggleButton();
            });

            $('.form-control').on('input', function() {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('id') + '-error').hide();
                checkFormAndToggleButton();
            });

            $('select').on('change', function() {
                checkFormAndToggleButton();
            });

            // Handle State Change for Districts
           $('#negeri').on('change', function() {
                
                if (stateId) {
                    $.ajax({
                        url: `/clientarea/districts/${stateId}`,
                        type: 'GET',
                        success: function(data) {
                            $('#daerah').empty();
                            $('#daerah').append('<option value="">Sila Pilih Daerah</option>');
                            
                            data.forEach(district => {
                                $('#daerah').append(
                                    `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`
                                );
                            });
                            
                            // Trigger change event to refresh UI
                            $('#daerah').trigger('change');
                            
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            $('#daerah').html('<option value="">Error loading districts</option>');
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

            $('#updatetButton').on('click', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    $('#updateApplicationForm').submit();
                }
            });

            $('#updateApplicationForm').on('submit', function(e) {
                if (!formIsReady) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Error",
                        text: "Please wait for the form to load fully before submitting.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                if (!validateForm()) {
                    e.preventDefault();
                    return;
                }

                e.preventDefault();
                
                let formData = new FormData(this);
                const fileInputs = ['land_grant', 'permission_plan', 'letter_of_support'];
                
                let fileSizeValid = true;
                fileInputs.forEach(inputName => {
                    const fileInput = $(`#${inputName}`)[0];
                    if (fileInput.files.length > 0) {
                        Array.from(fileInput.files).forEach(file => {
                            if (file.size > 15 * 1024 * 1024) {
                                fileSizeValid = false;
                                return;
                            }
                        });
                    }
                });
                
                if (!fileSizeValid) {
                    Swal.fire({
                        title: "Error!",
                        text: "One or more files exceed the 15MB size limit. Please choose smaller files.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                Swal.fire({
                    title: "@lang('app.uploading')",
                    text: "@lang('app.please_wait_while_uploading')",
                    icon: "info",
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('updateResubmitApplication', $application->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "@lang('app.success')",
                                text: response.message || "@lang('app.application_has_been_updated')",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = "{{ route('client_application_status') }}";
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message || "@lang('app.unexpected_error_occurred')",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            Swal.fire({
                                title: "@lang('app.validation_error')",
                                text: "@lang('app.please_fill_up')",
                                icon: "error",
                                confirmButtonText: "OK"
                            });

                            $.each(errors, function(key, value) {
                                $("#" + key + "-error").text(value[0]);
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
            });

            // Add asterisks to required fields
            setTimeout(function() {
                const appType = getApplicationType();
                
                let requiredFields = [
                    'pemohon', 'alamat', 'poskod',
                    'bandar', 'negeri', 'emel',
                    'lot-tanah', 'keluasan', 'land_district', 'mukim'
                ];

                // Only add ssm if NOT account type 3
                if (appType != '3') {
                    requiredFields.push('ssm');
                }

                // Only add district if required (not state codes 14, 15, 16)
                if (isDistrictRequired()) {
                    requiredFields.push('daerah');
                }

                requiredFields.forEach(field => {
                    const label = $(`label[for="${field}"]`);
                    if (label.length && !label.find('.starr').length) {
                        label.append(' <b class="starr">*</b>');
                    }
                });

                // Ensure ssm doesn't have asterisk for account type 3
                if (appType == '3') {
                    $('label[for="ssm"]').find('.starr').remove();
                }

                // Ensure district doesn't have asterisk for exempt states
                if (!isDistrictRequired()) {
                    $('label[for="daerah"]').find('.starr').remove();
                }

                const landGrantInput = $('#land_grant');
                if (landGrantInput.length) {
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info').length > 0;
                    if (hasExistingFile) {
                        $('label[for="land_grant"]').find('.starr').remove();
                    }
                }
                
                checkFormAndToggleButton();
            }, 500);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.remove-file-btn').click(function() {
                $('#remove_' + $(this).data('target')).val('1');
                $(this).parent().remove();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.remove-existing-file', function() {
                const fileItem = $(this).closest('.existing-file-item');
                const fieldName = fileItem.data('field');
                const fileIndex = fileItem.data('index');
                
                Swal.fire({
                    title: 'Adakah anda pasti?',
                    text: "Fail ini akan dibuang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, buang!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const removedInput = $(`#removed_${fieldName}`);
                        let removedFiles = removedInput.val() ? removedInput.val().split(',') : [];
                        removedFiles.push(fileIndex);
                        removedInput.val(removedFiles.join(','));
                        
                        // Remove the file item from display
                        fileItem.fadeOut(300, function() {
                            $(this).remove();
                            
                            // Update file count
                            const container = $(`#existing_${fieldName}_files`);
                            const remainingCount = container.find('.existing-file-item').length;
                            $(`#${fieldName}_file_count .file-count`).text(remainingCount);
                            
                            // If no files left, hide the entire section
                            if (remainingCount === 0) {
                                container.parent().fadeOut();
                            }
                        });
                        
                        Swal.fire({
                            title: 'Berjaya!',
                            text: 'Fail telah dibuang.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    </script>
    
@endsection
