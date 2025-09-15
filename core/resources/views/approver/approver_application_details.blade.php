<!--@extends('app')-->
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

    /* Style for adjustment_type dropdown */
    #adjustment_type {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #fff url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIiIGhlaWdodD0iOCIgdmlld0JveD0iMCAwIDEyIDgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEgMUw2IDdMMTEgMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPjwvc3ZnPg==') no-repeat right 10px center;
        background-size: 12px 8px;
        padding-right: 30px;
        /* Space for the arrow */
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 8px;
        font-size: 14px;
        cursor: pointer;
    }
    
    
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    th, td {
        /*border: 1px solid black;*/
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
        text-align: center;
    }

    /* Optional: Hover and focus styles for better UX */
    #adjustment_type:hover,
    #adjustment_type:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
    }
</style>
<title>@lang('app.update_application') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-wrench" aria-hidden="true"></i> @lang('app.update_application')</h5>
    </div>


    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.applicant_informatio')</h4>
                        <form action="{{ route('updateApplication', $application->id) }}" method="POST"
                            enctype="multipart/form-data" id="updateApplicationForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="application_reference">@lang('app.no_application_ref')</label>
                                <input type="text" id="application_reference" name="refference_no" class="form-control"
                                    value="{{ $application->refference_no ?? '' }}" placeholder="@lang('app.no_application_ref')"
                                    required>
                                @error('refference_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tarikh">@lang('app.date')</label>
                                <input id="tarikh" name="uploade_date" class="form-control" placeholder=""
                                    value="{{ $application->uploade_date }}" readonly>
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
                                    <option value="" disabled>@lang('app.select_district')</option>
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

                    <input type="hidden" id="adjustment_amount_input" name="adjustment_percentage"
                        value="{{ $application->adjustment_percentage ?? '0' }}">
                    <input type="hidden" id="adjustment_type_input" name="adjustment_type"
                        value="{{ $application->adjustment_type ?? '0' }}">
                    <input type="hidden" id="land_category_input" name="land_category"
                        value="{{ $application->land_category ?? '0' }}">
                    <input type="hidden" id="hectare_input" name="hectare" value="{{ $application->hectare ?? '0' }}">
                    <input type="hidden" id="base_amount_input" name="base_amount"
                        value="{{ $application->base_amount ?? '0' }}">
                    <input type="hidden" id="discount_amount_input" name="discount_amount"
                        value="{{ $application->discount_amount ?? '0' }}">
                    <input type="hidden" id="final_amount_input" name="final_amount"
                        value="{{ $application->final_amount ?? '0' }}">
                    <input type="hidden" id="cost_input" name="cost" value="{{ $application->cost ?? '0' }}">

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
                                <select id="land-unit" name="land_unit" class="form-control form-select me-3" readonly
                                    onclick="return false;" style="pointer-events: none;">
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
                                    placeholder="@lang('app.hectare')" readonly>
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
                            <select id="land_district" class="form-control form-select " name="land_district">
                                <option value="" selected disabled>@lang('app.select_district')</option>
                                @foreach ($district as $value)
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
                            <label for="geran-tanah">@lang('app.land_grant') <b class="starr">*</b></label>
                            <input type="file" id="land_grant" name="land_grant" class="file-input"
                                accept="application/pdf">
                            <label for="land_grant" class="upload-button">@lang('app.choose_file')</label>
                            <div id="land_grantfileName" class="file-name"></div>
                            <div class="col-9 text-center">
                                @if ($application->land_grant)
                                    <small class="text-info">Current file:
                                        <a href="{{ url('core/public/pdf/' . basename($application->land_grant)) }}"
                                            target="_blank"><i class="fa fa-file-pdf-o"></i>
                                            {{ basename($application->land_grant) }}
                                        </a></small>
                                @endif
                                @error('land_grant')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Planning Permission Plan -->
                        <div class="form-group">
                            <label for="pelan">@lang('app.planning_permission_plan')</label>
                            <input type="file" id="permission_plan" name="permission_plan" class="file-input"
                                accept="application/pdf">
                            <label for="permission_plan" class="upload-button">@lang('app.choose_file')</label>
                            <div id="permission_planfileName" class="file-name"></div>
                            <div class="col-9 text-center">
                                @if ($application->permission_plan)
                                    <small class="text-info">Current file:
                                        <a href="{{ url('core/public/pdf/' . basename($application->permission_plan)) }}"
                                            target="_blank"><i class="fa fa-file-pdf-o"></i>
                                            {{ basename($application->permission_plan) }}
                                        </a></small>
                                @endif
                                @error('permission_plan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Letter of Support -->
                        <div class="form-group">
                            <label for="sokongan">@lang('app.letter_of_support')</label>
                            <input type="file" id="letter_of_support" name="letter_of_support" class="file-input"
                                accept="application/pdf">
                            <label for="letter_of_support" class="upload-button">@lang('app.choose_file')</label>
                            <div id="letter_of_supportfileName" class="file-name"></div>
                            <div class="col-9 text-center">
                                @if ($application->letter_of_support)
                                    <small class="text-info">Current file:
                                        <a href="{{ url('core/public/pdf/' . basename($application->letter_of_support)) }}"
                                            target="_blank"><i class="fa fa-file-pdf-o"></i>
                                            {{ basename($application->letter_of_support) }}
                                        </a></small>
                                @endif
                                @error('letter_of_support')
                                    <span class="text-danger">{{ $message }}</span>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section">
                                <!-- All in One Line -->
                                <div class="form-group d-flex align-items-center" style="gap: 10px;width: fit-content;">
                                    <label for="land_category"
                                        class="form-label px-1"style="font-weight: bold; margin-bottom: 0;">@lang('app.land_category')</label>
                                    <select id="land_category" class="form-control form-select" name="land_category"
                                        required>
                                        <option value="" disabled selected>@lang('app.please_select')</option>
                                        @foreach ($landCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-flex align-items-center" style="gap: 10px;">
                                    <!-- Title -->

                                    <label for="rates" class="form-label px-1"
                                        style="font-weight: bold; margin-bottom: 0;">@lang('app.rates')</label>

                                    <!-- Cost Input -->
                                    <input type="text" id="cost" class="form-control small-input"
                                        placeholder="RM" style="max-width: 150px; padding-left: 35px;" readonly>

                                    <!-- Multiplier -->
                                    <span>X</span>

                                    <!-- Hectare Input -->
                                    <input type="text" id="hectare" class="form-control small-input"
                                        placeholder="Hectare" style="max-width: 150px; text-align: center;" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table>
                                <thead style="text-align: center;">
                                    <tr>
                                        <th>@lang('app.rates')</th>
                                        <th>@lang('app.hectare')</th>
                                        <th>@lang('app.amount')</th>
                                        <th>@lang('app.vote_dana')</th>
                                        <th>@lang('app.account_code')</th>
                                        <th>@lang('app.amounts') (RM)</th>
                                        <!--<th>Actions</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>L453</td>
                                        <td>H0161304</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>G001</td>
                                        <td>H0161304</td>
                                        <td></td>
                                    </tr>

                                    <!--<tr class="total-row">-->
                                    <!--    <td colspan="5">-->
                                    <!--        <div class="d-flex align-items-center justify-content-end" style="gap: 10px;">-->
                                    <!--            @lang('app.adjustment')-->
                                    <!--            <div class="adjustment-container"-->
                                    <!--                style="display: flex; align-items: center; gap: 5px;">-->
                                    <!--                <select id="adjustment_type" class="form-control"-->
                                    <!--                    style="min-width: 100px;">-->
                                    <!--                    <option value="percentage">@lang('app.percentage')</option>-->
                                    <!--                    <option value="fixed">@lang('app.fixed_amount')</option>-->
                                    <!--                </select>-->
                                    <!--                <input type="text" id="discount" class="form-control small-input"-->
                                    <!--                    placeholder="@lang('app.adjustment')" style="max-width: 100px;">-->
                                    <!--                <span id="adjustment_unit">%</span>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </td>-->
                                    <!--    <td>-->
                                    <!--        <div style="position: relative;">-->
                                    <!--            <span id="adjustment_amount_display">0.00</span>-->
                                    <!--        </div>-->
                                    <!--    </td>-->
                                    <!--</tr>-->
                                    <tr class="total-row">
                                       <td colspan="5">
                                            <div class="d-flex align-items-center justify-content-end" style="gap: 15px;">
                                                <!-- Appeal Dropdown -->
                                                <div class="appeal-container" style="display: flex; align-items: center; gap: 5px;">
                                                    <label for="appeal_type" style="margin: 0; font-weight: bold;">Rayuan:</label>
                                                    <select id="appeal_type" name="appeal_display" class="form-control" style="min-width: 120px;" disabled>
                                                        <option value="">@lang('app.select_option')</option>
                                                        <option value="yes" {{ ($application->appeal ?? '') == 'yes' ? 'selected' : '' }}>@lang('app.yes')</option>
                                                        <option value="no" {{ ($application->appeal ?? '') == 'no' ? 'selected' : '' }}>@lang('app.no')</option>
                                                    </select>
                                                </div>
                                        
                                                <!-- Existing Adjustment Section -->
                                                @lang('app.adjustment')
                                                <div class="adjustment-container" style="display: flex; align-items: center; gap: 5px;">
                                                    <select id="adjustment_type" class="form-control" style="min-width: 100px;" disabled>
                                                        <option value="percentage">@lang('app.percentage')</option>
                                                        <option value="fixed">@lang('app.fixed_amount')</option>
                                                    </select>
                                                    <input type="text" id="discount" class="form-control small-input" 
                                                           placeholder="@lang('app.adjustment')" style="max-width: 100px;" readonly>
                                                    <span id="adjustment_unit">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="position: relative;">
                                                <span id="adjustment_amount_display">0.00</span>
                                            </div>
                                        </td>
                                    </tr>
                                     <tr class="remark-row">
                                        <td colspan="5">
                                            <div class="d-flex align-items-center justify-content-end" style="gap: 10px;">
                                                <label for="remark" style="margin: 0; font-weight: bold;">@lang('app.remark')</label>
                                                <input type="text" id="remark" name="remark" class="form-control" 
                                                       value="{{ $application->remark ?? '' }}" style="width: 250px;" readonly>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="5" style="text-align:end;">@lang('app.amount')</td>
                                        <td id="total_amount">0.00</td> <!-- Add an ID here -->
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>

                    <!--Submit Section -->
                    <div class="form-actions">
                        <!--<button type="submit" class="btn btn-secondary btn1" id="rejectButton">@lang('app.reject')</button>-->
                        <button type="submit" class="btn btn-primary btn2" id="approveButton"
                            data-id="{{ $application->id }}">
                            @lang('app.next')
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
         document.getElementById('approveButton').addEventListener('click', function(event) {
            event.preventDefault();
            const applicationId = this.getAttribute('data-id');
            const updateUrl = "{{ route('approver_letter', ['application_id' => ':id']) }}".replace(':id',
                applicationId);

            window.location.href = updateUrl;
        });
    </script>

    <script>
        // Get today's date
        const today = new Date();

        // Format the date as dd/mm/yy
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
            let adjustmentTypeSelect = document.getElementById("adjustment_type");
            let adjustmentUnitSpan = document.getElementById("adjustment_unit");
            let marginInput = document.getElementById("margin");
            let squareMetersInput = document.getElementById("keluasan");

            const landCategoryId = document.getElementById('land_category_input')?.value || '0';
            const hectareValue = document.getElementById('hectare_input')?.value || '0';
            const discountValue = document.getElementById('adjustment_amount_input')?.value || '0';
            const savedAdjustmentType = document.getElementById('adjustment_type_input')?.value || 'percentage';
            const savedCostValue = document.getElementById('cost_input')?.value || '0';
            const marginValue = marginInput?.value || '0';

            // Initialize values
            if (landCategoryId && landCategoryId !== '0') {
                landCategorySelect.value = landCategoryId;
                if (landCategoryId === '4') {
                    costInput.readOnly = false;
                    costInput.value = savedCostValue && savedCostValue !== '0' ?
                        "RM " + parseFloat(savedCostValue).toFixed(2) : "RM ";
                } else {
                    costInput.readOnly = true;
                    setCostFromCategory(landCategoryId);
                }
            }

            // Initialize adjustment type and discount
            adjustmentTypeSelect.value = savedAdjustmentType;
            discountInput.value = parseFloat(discountValue).toFixed(2);
            if (marginValue && marginValue !== '0') {
                marginInput.value = parseFloat(marginValue).toFixed(2);
            }

            // Initialize hectare value
            if (hectareValue && hectareValue !== '0') {
                hectareInput.value = parseFloat(hectareValue).toFixed(2);
            } else if (squareMetersInput && squareMetersInput.value && !isNaN(squareMetersInput.value)) {
                convertToHectare();
            } else {
                hectareInput.value = '0.00';
                document.getElementById('hectare_input').value = '0.00';
            }

            updateAdjustmentUnit();
            updateAllValues();

            if (squareMetersInput) {
                squareMetersInput.addEventListener("input", function() {
                    validateInput(this);
                    convertToHectare();
                    updateAllValues();
                });
            }

            landCategorySelect.addEventListener("change", function() {
                document.getElementById('land_category_input').value = this.value;
                if (this.value === '4') {
                    costInput.readOnly = false;
                    costInput.value = savedCostValue && savedCostValue !== '0' && landCategoryId === '4' ?
                        "RM " + parseFloat(savedCostValue).toFixed(2) : "RM ";
                    costInput.focus();
                    costInput.setSelectionRange(3, costInput.value.length);
                } else {
                    costInput.readOnly = true;
                    setCostFromCategory(this.value);
                }
                updateAllValues();
            });

            costInput.addEventListener("input", function() {
                if (landCategorySelect.value === '4') {
                    let value = this.value.replace(/[^\d.]/g, '');
                    let parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts.slice(1).join('');
                    }
                    this.value = "RM " + value;
                    const numericValue = value.trim() === '' ? '0' : value;
                    document.getElementById('cost_input').value = parseFloat(numericValue).toFixed(2);
                    if (document.getElementById('custom_rate_input')) {
                        document.getElementById('custom_rate_input').value = parseFloat(numericValue)
                            .toFixed(2);
                    }
                    updateAllValues();
                }
            });

            hectareInput.addEventListener("input", function() {
                this.value = this.value.replace(/[^\d.]/g, '');
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }
                let value = this.value.trim() === '' ? '0' : this.value;
                document.getElementById('hectare_input').value = parseFloat(value).toFixed(2);
                updateAllValues();
            });

            discountInput.addEventListener("input", function() {
                this.value = this.value.replace(/[^\d.]/g, '');
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts.slice(1).join('');
                }
                let value = this.value.trim() === '' ? '0' : this.value;
                document.getElementById('adjustment_amount_input').value = parseFloat(value).toFixed(2);
                updateAllValues();
            });

            adjustmentTypeSelect.addEventListener("change", function() {
                document.getElementById('adjustment_type_input').value = this.value; // Save adjustment type
                updateAdjustmentUnit();
                updateAllValues();
            });

            if (marginInput) {
                marginInput.addEventListener("input", function() {
                    this.value = this.value.replace(/[^\d.]/g, '');
                    let parts = this.value.split('.');
                    if (parts.length > 2) {
                        this.value = parts[0] + '.' + parts.slice(1).join('');
                    }
                    updateAllValues();
                });
            }

            // Functions
            function validateInput(input) {
                input.value = input.value.replace(/[^0-9]/g, '');
            }

            function updateAdjustmentUnit() {
                adjustmentUnitSpan.textContent = adjustmentTypeSelect.value === "percentage" ? "%" : "RM";
                discountInput.placeholder = adjustmentTypeSelect.value === "percentage" ?
                    "@lang('app.adjustment')" : "Fixed Amount";
            }

            function setCostFromCategory(categoryId) {
                if (categoryId === '4') {
                    costInput.value = savedCostValue && savedCostValue !== '0' ?
                        "RM " + parseFloat(savedCostValue).toFixed(2) : "RM ";
                    return;
                }
                const selectedCategory = landCategories.find(cat => cat.id == categoryId);
                costInput.value = selectedCategory && selectedCategory.rate ?
                    "RM " + parseFloat(selectedCategory.rate).toFixed(2) : "";
            }

            function calculateBaseAmount() {
                let selectedId = landCategorySelect.value;
                let rate;
                if (selectedId === '4') {
                    let costValue = costInput.value.replace('RM ', '');
                    rate = parseFloat(costValue) || 0;
                } else {
                    let selectedCategory = landCategories.find(cat => cat.id == selectedId);
                    rate = selectedCategory ? parseFloat(selectedCategory.rate) : 0;
                }
                let hectare = parseFloat(hectareInput.value) || 0;
                return rate * hectare;
            }

            // function updateAllValues() {
            //     let selectedId = landCategorySelect.value;
            //     let rate;
            //     if (selectedId === '4') {
            //         let costValue = costInput.value.replace('RM ', '');
            //         rate = parseFloat(costValue) || 0;
            //     } else {
            //         let selectedCategory = landCategories.find(cat => cat.id == selectedId);
            //         if (!selectedCategory) return;
            //         rate = parseFloat(selectedCategory.rate);
            //     }

            //     document.getElementById('cost_input').value = rate.toFixed(2);
            //     let hectare = parseFloat(hectareInput.value) || 0;
            //     let discountValue = parseFloat(discountInput.value) || 0;
            //     let adjustmentType = adjustmentTypeSelect.value;
            //     let marginPercentage = parseFloat(marginInput?.value) || 0;

            //     let baseAmount = rate * hectare;
            //     let marginAmount = baseAmount * (marginPercentage / 100);
            //     let discountAmount = adjustmentType === "percentage" ?
            //         baseAmount * (discountValue / 100) : discountValue;
            //     let finalAmount = Math.max(0, baseAmount + marginAmount - discountAmount); // Prevent negative
            //     let halfAmount = finalAmount / 2;

            //     let firstRow = document.querySelector("tbody tr:first-child");
            //     if (firstRow) {
            //         firstRow.innerHTML = `
            //     <td>${rate.toFixed(2)}</td>
            //     <td>${hectare.toFixed(3)}</td>
            //     <td>${baseAmount.toFixed(2)}</td>
            //     <td>L453</td>
            //     <td>H0161304</td>
            //     <td>${halfAmount.toFixed(2)}</td>
            // `;
            //     }

            //     let secondRow = document.querySelector("tbody tr:nth-child(2)");
            //     if (secondRow) {
            //         secondRow.innerHTML = `
            //     <td></td>
            //     <td></td>
            //     <td></td>
            //     <td>G001</td>
            //     <td>H0161304</td>
            //     <td>${halfAmount.toFixed(2)}</td>
            // `;
            //     }

            //     let marginRow = document.querySelector("tbody tr:nth-child(3)");
            //     if (marginPercentage > 0) {
            //         if (!marginRow || marginRow.className === "total-row") {
            //             marginRow = document.createElement("tr");
            //             document.querySelector("tbody").insertBefore(marginRow, document.querySelector(
            //                 "tr.total-row"));
            //         }
            //         marginRow.innerHTML = `
            //     <td colspan="5">@lang('app.margin')</td>
            //     <td>${marginPercentage.toFixed(2)} % (${marginAmount.toFixed(2)})</td>
            // `;
            //     } else if (marginRow && marginRow.querySelector("td")?.textContent.includes("margin")) {
            //         marginRow.remove();
            //     }

            //     document.getElementById('cost_input').value = rate.toFixed(2);
            //     document.getElementById('base_amount_input').value = baseAmount.toFixed(2);
            //     document.getElementById('discount_amount_input').value = discountAmount.toFixed(2);
            //     document.getElementById('final_amount_input').value = finalAmount.toFixed(2);
            //     document.querySelector('input[name="land_category"]').value = selectedId;
            //     document.querySelector('input[name="hectare"]').value = hectare.toFixed(3);
            //     document.querySelector('input[name="adjustment_percentage"]').value = discountValue.toFixed(2);
            //     document.getElementById('adjustment_type_input').value = adjustmentType;

            //     let adjustmentAmountSpan = document.getElementById("adjustment_amount_display");
            //     if (adjustmentAmountSpan) {
            //         adjustmentAmountSpan.textContent = adjustmentType === "percentage" ?
            //             `${discountValue.toFixed(2)}% (${discountAmount.toFixed(2)})` :
            //             discountAmount.toFixed(2);
            //     }

            //     let totalAmountElement = document.getElementById("total_amount");
            //     if (totalAmountElement) {
            //         totalAmountElement.textContent = finalAmount.toFixed(2);
            //     }
            // }
            function updateAllValues() {
            let selectedId = landCategorySelect.value;
            let rate;
            if (selectedId === '4') {
                let costValue = costInput.value.replace('RM ', '');
                rate = parseFloat(costValue) || 0;
            } else {
                let selectedCategory = landCategories.find(cat => cat.id == selectedId);
                if (!selectedCategory) return;
                rate = parseFloat(selectedCategory.rate);
            }
        
            document.getElementById('cost_input').value = rate.toFixed(2);
            let hectare = parseFloat(hectareInput.value) || 0;
            let discountValue = parseFloat(discountInput.value) || 0;
            let adjustmentType = adjustmentTypeSelect.value;
            let marginPercentage = parseFloat(marginInput?.value) || 0;
        
            let baseAmount = rate * hectare;
            let marginAmount = baseAmount * (marginPercentage / 100);
            let discountAmount = adjustmentType === "percentage" ?
                baseAmount * (discountValue / 100) : discountValue;
            let finalAmount = Math.max(0, baseAmount + marginAmount - discountAmount);
            let halfAmount = finalAmount / 2;
        
            // Get the actual calculated hectare value from the conversion
            let displayHectare = hectare;
            const inputValue = document.getElementById('keluasan').value;
            const landUnit = document.getElementById('land-unit').value;
            
            if (inputValue && !isNaN(inputValue) && landUnit) {
                switch (landUnit) {
                    case '1':
                        displayHectare = parseFloat(inputValue) / 10000;
                        break;
                    case '2':
                        displayHectare = parseFloat(inputValue) / 2.47105;
                        break;
                    case '3':
                        displayHectare = parseFloat(inputValue);
                        break;
                }
            }
        
            let firstRow = document.querySelector("tbody tr:first-child");
            if (firstRow) {
                firstRow.innerHTML = `
                    <td>${rate.toFixed(2)}</td>
                    <td>${displayHectare.toFixed(2)}</td>
                    <td>${baseAmount.toFixed(2)}</td>
                    <td>L453</td>
                    <td>H0161304</td>
                    <td>${halfAmount.toFixed(2)}</td>
                `;
            }
        
            let secondRow = document.querySelector("tbody tr:nth-child(2)");
            if (secondRow) {
                secondRow.innerHTML = `
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>G001</td>
                    <td>H0161304</td>
                    <td>${halfAmount.toFixed(2)}</td>
                `;
            }
        
            // Rest of your existing code...
            let marginRow = document.querySelector("tbody tr:nth-child(3)");
            if (marginPercentage > 0) {
                if (!marginRow || marginRow.className === "total-row") {
                    marginRow = document.createElement("tr");
                    document.querySelector("tbody").insertBefore(marginRow, document.querySelector("tr.total-row"));
                }
                marginRow.innerHTML = `
                    <td colspan="5">@lang('app.margin')</td>
                    <td>${marginPercentage.toFixed(2)} % (${marginAmount.toFixed(2)})</td>
                `;
            } else if (marginRow && marginRow.querySelector("td")?.textContent.includes("margin")) {
                marginRow.remove();
            }
        
            document.getElementById('cost_input').value = rate.toFixed(2);
            document.getElementById('base_amount_input').value = baseAmount.toFixed(2);
            document.getElementById('discount_amount_input').value = discountAmount.toFixed(2);
            document.getElementById('final_amount_input').value = finalAmount.toFixed(2);
            document.querySelector('input[name="land_category"]').value = selectedId;
            document.querySelector('input[name="hectare"]').value = displayHectare.toFixed(4); // Use more precision
            document.querySelector('input[name="adjustment_percentage"]').value = discountValue.toFixed(2);
            document.getElementById('adjustment_type_input').value = adjustmentType;
        
            let adjustmentAmountSpan = document.getElementById("adjustment_amount_display");
            if (adjustmentAmountSpan) {
                adjustmentAmountSpan.textContent = adjustmentType === "percentage" ?
                    `${discountValue.toFixed(2)}% (${discountAmount.toFixed(2)})` :
                    discountAmount.toFixed(2);
            }
        
            let totalAmountElement = document.getElementById("total_amount");
            if (totalAmountElement) {
                totalAmountElement.textContent = finalAmount.toFixed(2);
            }
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

                        // Optional: Log file details for debugging
                        if (this.files[0]) {
                            console.log(`${input} file selected:`, {
                                name: this.files[0].name,
                                type: this.files[0].type,
                                size: this.files[0].size
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        function confirmNavigation(url) {
            Swal.fire({
                title: "@lang('app.are_you_sure')", // Localization string
                text: "@lang('app.you_want_to_generate_letter')", // Custom message
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

                hectareDisplay.value = hectares.toFixed(2);

                if (hectareInput) {
                    hectareInput.value = hectares.toFixed(2);
                    if (document.getElementById('hectare_input')) {
                        document.getElementById('hectare_input').value = hectares.toFixed(3);
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
@endsection
