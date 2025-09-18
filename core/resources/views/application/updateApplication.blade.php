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

    /* Optional: Hover and focus styles for better UX */
    #adjustment_type:hover,
    #adjustment_type:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
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
                                    <span id="refference_no-error" class="text-danger"></span> 
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
                    <input type="hidden" id="remark_input" name="remark" value="{{ $application->remark ?? '' }}">
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
                                   <input type="hidden" id="appeal_input" name="appeal" value="{{ $application->appeal ?? '' }}">
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
                                    {{-- <tr class="total-row">
                                        <td colspan="5">
                                            <div class=" d-flex align-items-center justify-content-end"
                                                style="gap: 10px;">
                                                @lang('app.adjustment')
                                                <input type="text" id="discount" class="form-control small-input"
                                                    placeholder="@lang('app.adjustment')" style="max-width: 100px;">%
                                            </div>
                                        </td>
                                        <td>
                                            <div style="position: relative;">
                                                <span style=" right: 50px; top: 50%; transform: translateY(-50%);"></span>
                                            </div>
                                        </td>
                                    </tr> --}}

                                    <!--<tr class="total-row">-->
                                    <!--    <td colspan="5">-->
                                    <!--        <div class="d-flex align-items-center justify-content-end" style="gap: 10px;">-->
                                    <!--            @lang('app.adjustment')-->
                                    <!--            <div class="adjustment-container"-->
                                    <!--                style="display: flex; align-items: center; gap: 5px;">-->
                                    <!--                <select id="adjustment_type" class="form-control"-->
                                    <!--                    style="min-width: 100px;">-->
                                    <!--                    <option value="percentage">Percentage</option>-->
                                    <!--                    <option value="fixed">Fixed</option>-->
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
                                                    <select id="appeal_type" name="appeal_display" class="form-control" style="min-width: 120px;">
                                                        <option value="">@lang('app.select_option')</option>
                                                        <option value="yes" {{ ($application->appeal ?? '') == 'yes' ? 'selected' : '' }}>@lang('app.yes')</option>
                                                        <option value="no" {{ ($application->appeal ?? '') == 'no' ? 'selected' : '' }}>@lang('app.no')</option>
                                                    </select>
                                                </div>

                                                <!-- Existing Adjustment Section -->
                                                @lang('app.adjustment')
                                                <div class="adjustment-container"
                                                    style="display: flex; align-items: center; gap: 5px;">
                                                    <select id="adjustment_type" class="form-control"
                                                        style="min-width: 100px;">
                                                        <option value="percentage">@lang('app.percentage')</option>
                                                        <option value="fixed">@lang('app.fixed_amount')</option>
                                                    </select>
                                                    <input type="text" id="discount" class="form-control small-input"
                                                        placeholder="@lang('app.adjustment')" style="max-width: 100px;">
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
                                                <label for="remark"
                                                    style="margin: 0; font-weight: bold;">@lang('app.remark')</label>
                                                <input type="text" id="remark" name="remark" class="form-control"
                                                    value="{{ $application->remark ?? '' }}" style="width: 250px;">
                                                <!-- Adjust width as needed -->
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="5" style="text-align: end;">@lang('app.amount')</td>
                                        <td id="total_amount">0.00</td> <!-- Add an ID here -->
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>

                    <!--Submit Section -->
                    <div class="form-actions">
                        <!--<button type="submit" class="btn btn-secondary btn1" id="rejectButton">@lang('app.reject')</button>-->
                        <button type="submit" class="btn btn-primary btn2"
                            id="updatetButton">@lang('app.update')</button>
                        <a href="javascript:void(0);" class="btn btn-secondary btn3"
                            onclick="confirmNavigation('{{ route('user_letter', ['application_id' => $application->id]) }}')"
                            id="generateLetterButton">
                            @lang('app.generate_letter')
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Reference duplicate validation variables
            let timeout;
            let isDuplicateRef = false;
            let isChecking = false;
            
            // Form validation variables
            let formIsReady = true;
            
            // Elements
            const $refInput = $('#application_reference');
            const $errorSpan = $('#refference_no-error');
            const $form = $refInput.closest('form');
            const $submitBtn = $form.find('button[type="submit"], input[type="submit"]');
            const originalValue = $refInput.val();
            
            // Initialize Generate Letter button as disabled
            $('#generateLetterButton').addClass('disabled').attr('onclick', 'return false;');
        
            // REFERENCE DUPLICATE VALIDATION
            $refInput.on('input', function() {
                $errorSpan.text('').hide();
                $(this).removeClass('is-invalid');
                isDuplicateRef = false;
                isChecking = false;
                updateSubmitButton();
                
                clearTimeout(timeout);
                timeout = setTimeout(checkDuplicateReference, 500);
            });
            
            $refInput.on('blur', function() {
                if ($(this).val().trim() !== '' && !isChecking) {
                    checkDuplicateReference();
                }
            });
            
            function checkDuplicateReference() {
                const refValue = $refInput.val().trim();
                
                if (refValue === '' || refValue === originalValue) {
                    return;
                }
                
                isChecking = true;
                $errorSpan.text('Checking...').removeClass('text-danger').addClass('text-info').show();
                updateSubmitButton();
                
                $.ajax({
                    url: '{{ route("check.reference.duplicate") }}',
                    method: 'POST',
                    data: {
                        reference_no: refValue,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        exclude_id: '{{ $application->id ?? "" }}'
                    },
                    success: function(response) {
                        isChecking = false;
                        $errorSpan.removeClass('text-info');
                        
                        if (response.exists) {
                            $refInput.addClass('is-invalid');
                            $errorSpan.addClass('text-danger')
                                     .text('No Rujukan telah wujud')
                                     .show();
                            isDuplicateRef = true;
                        } else {
                            $refInput.removeClass('is-invalid');
                            $errorSpan.hide();
                            isDuplicateRef = false;
                            
                            // Simple success toast
                            // Swal.fire({
                            //     toast: true,
                            //     position: 'top-end',
                            //     icon: 'success',
                            //     title: 'Reference Available!',
                            //     showConfirmButton: false,
                            //     timer: 2000
                            // });
                        }
                        
                        updateSubmitButton();
                        checkFormAndToggleButton(); // Also check general form validity
                    },
                    error: function() {
                        isChecking = false;
                        $errorSpan.removeClass('text-info')
                                 .addClass('text-danger')
                                 .text('Error checking reference')
                                 .show();
                        isDuplicateRef = true;
                        updateSubmitButton();
                        checkFormAndToggleButton();
                    }
                });
            }
        
            // GENERAL FORM VALIDATION
            function validateForm() {
                let isValid = true;
                let firstInvalidField = null;
        
                const requiredFields = [
                    { id: 'application_reference', name: 'Application Reference' },
                    { id: 'pemohon', name: 'Applicant' },
                    { id: 'ssm', name: 'Identification Card No' },
                    { id: 'alamat', name: 'Address' },
                    { id: 'poskod', name: 'Postal Code' },
                    { id: 'bandar', name: 'City' },
                    { id: 'negeri', name: 'State' },
                    { id: 'daerah', name: 'District' },
                    { id: 'emel', name: 'Email' },
                    { id: 'telefon', name: 'Telephone' },
                    { id: 'lot-tanah', name: 'Land Lot' },
                    { id: 'keluasan', name: 'Land Area' },
                    { id: 'land-unit', name: 'Land Unit' },
                    { id: 'land_district', name: 'Land District' },
                    { id: 'mukim', name: 'Mukim' },
                    { id: 'land_category', name: 'Land Category' }
                ];
        
                // Check each required field
                requiredFields.forEach(field => {
                    const element = $('#' + field.id);
                    if (element.length) {
                        let value = element.val();
        
                        if (element.prop('readonly') || element.prop('disabled')) {
                            return;
                        }
        
                        if (!value || value.trim() === '') {
                            isValid = false;
                            element.addClass('is-invalid');
        
                            let errorId = field.id + '-error';
                            if ($('#' + errorId).length === 0) {
                                element.after('<div id="' + errorId + '" class="text-danger">Medan ini wajib diisi</div>');
                            } else {
                                $('#' + errorId).text('Medan ini wajib diisi').show();
                            }
        
                            if (!firstInvalidField) {
                                firstInvalidField = element;
                            }
                        } else {
                            element.removeClass('is-invalid');
                            $('#' + field.id + '-error').hide();
                        }
                    }
                });
        
                // Email validation
                const emailElement = $('#emel');
                if (emailElement.length && emailElement.val().trim() !== '') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailElement.val())) {
                        isValid = false;
                        emailElement.addClass('is-invalid');
                        if ($('#emel-error').length === 0) {
                            emailElement.after('<div id="emel-error" class="text-danger">Please enter a valid email address</div>');
                        } else {
                            $('#emel-error').text('Please enter a valid email address').show();
                        }
                        if (!firstInvalidField) firstInvalidField = emailElement;
                    }
                }
        
                // Postal code validation
                const postalElement = $('#poskod');
                if (postalElement.length && postalElement.val().trim() !== '') {
                    const postalPattern = /^[0-9]+$/;
                    if (!postalPattern.test(postalElement.val())) {
                        isValid = false;
                        postalElement.addClass('is-invalid');
                        if ($('#poskod-error').length === 0) {
                            postalElement.after('<div id="poskod-error" class="text-danger">Postal code must contain only numbers</div>');
                        } else {
                            $('#poskod-error').text('Postal code must contain only numbers').show();
                        }
                        if (!firstInvalidField) firstInvalidField = postalElement;
                    }
                }
        
                // Phone validation
                const phoneElement = $('#telefon');
                if (phoneElement.length && phoneElement.val().trim() !== '') {
                    const phonePattern = /^[0-9]+$/;
                    if (!phonePattern.test(phoneElement.val())) {
                        isValid = false;
                        phoneElement.addClass('is-invalid');
                        if ($('#telefon-error').length === 0) {
                            phoneElement.after('<div id="telefon-error" class="text-danger">Phone number must contain only numbers</div>');
                        } else {
                            $('#telefon-error').text('Phone number must contain only numbers').show();
                        }
                        if (!firstInvalidField) firstInvalidField = phoneElement;
                    }
                }
        
                // Land grant file validation
                const landGrantInput = $('#land_grant');
                if (landGrantInput.length) {
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info').length > 0;
                    if (!hasExistingFile && landGrantInput[0].files.length === 0) {
                        isValid = false;
                        if ($('#land_grant-error').length === 0) {
                            landGrantInput.closest('.form-group').append('<div id="land_grant-error" class="text-danger">Land grant document is required</div>');
                        } else {
                            $('#land_grant-error').text('Land grant document is required').show();
                        }
                        if (!firstInvalidField) firstInvalidField = landGrantInput;
                    } else {
                        $('#land_grant-error').hide();
                    }
                }
        
                // Scroll to first invalid field
                if (firstInvalidField) {
                    $('html, body').animate({
                        scrollTop: firstInvalidField.offset().top - 100
                    }, 500);
                }
        
                return isValid;
            }
        
            function checkFormAndToggleButton() {
                let formIsValid = true;
        
                const requiredFields = [
                    'application_reference', 'pemohon', 'ssm', 'alamat', 'poskod',
                    'bandar', 'negeri', 'daerah', 'emel', 'telefon',
                    'lot-tanah', 'keluasan', 'land-unit', 'land_district', 'mukim', 'land_category'
                ];
        
                requiredFields.forEach(field => {
                    const element = $('#' + field);
                    if (element.length) {
                        let value = element.val();
                        if (element.prop('readonly') || element.prop('disabled')) {
                            return;
                        }
                        if (!value || value.trim() === '') {
                            formIsValid = false;
                        }
                    }
                });
        
                // Check other validations
                const emailElement = $('#emel');
                if (emailElement.length && emailElement.val().trim() !== '') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailElement.val())) {
                        formIsValid = false;
                    }
                }
        
                const postalElement = $('#poskod');
                if (postalElement.length && postalElement.val().trim() !== '') {
                    const postalPattern = /^[0-9]+$/;
                    if (!postalPattern.test(postalElement.val())) {
                        formIsValid = false;
                    }
                }
        
                const phoneElement = $('#telefon');
                if (phoneElement.length && phoneElement.val().trim() !== '') {
                    const phonePattern = /^[0-9]+$/;
                    if (!phonePattern.test(phoneElement.val())) {
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
        
                // Enable/disable Generate Letter button
                if (formIsValid) {
                    $('#generateLetterButton').removeClass('disabled').attr('onclick',
                        "confirmNavigation('{{ route('user_letter', ['application_id' => $application->id]) }}')"
                    );
                } else {
                    $('#generateLetterButton').addClass('disabled').attr('onclick', 'return false;');
                }
            }
        
            function updateSubmitButton() {
                const shouldDisable = isDuplicateRef || isChecking;
                $submitBtn.prop('disabled', shouldDisable);
                
                if (shouldDisable) {
                    $submitBtn.addClass('btn-secondary').removeClass('btn-primary');
                } else {
                    $submitBtn.removeClass('btn-secondary').addClass('btn-primary');
                }
            }
        
            // UNIFIED FORM SUBMISSION HANDLER
            $form.on('submit', function(e) {
                e.preventDefault(); // Always prevent default first
                
                // Check reference duplicate first
                if (isDuplicateRef) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Nombor Rujukan telah wujud',
                        text: "@lang('app.reference_number_allready_exist')",
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        $refInput.focus();
                    });
                    return false;
                }
                
                // Check if still checking reference
                if (isChecking) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Please Wait',
                        text: 'Checking reference number...',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    return false;
                }
                
                // Check form readiness
                if (!formIsReady) {
                    Swal.fire({
                        title: "Error",
                        text: "Please wait for the form to load fully before submitting.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return false;
                }
        
                // Validate all form fields
                if (!validateForm()) {
                    // Don't show additional alert - validateForm already scrolls to first error
                    return false;
                }
        
                // If everything is valid, proceed with form submission
                const hectareValue = parseFloat($('input[name="hectare"]').val()) || 0;
                const adjustmentValue = parseFloat($('input[name="adjustment_percentage"]').val()) || 0;
        
                $('input[name="hectare"]').val(hectareValue.toFixed(2));
                $('input[name="adjustment_percentage"]').val(adjustmentValue.toFixed(2));
                const appealValue = $('#appeal_type').val() || '';
        
                let formData = new FormData(this);
                const fileInputs = ['land_grant', 'permission_plan', 'letter_of_support'];
                fileInputs.forEach(inputName => {
                    const fileInput = $(`#${inputName}`)[0];
                    if (fileInput.files.length > 0) {
                        formData.append(inputName, fileInput.files[0]);
                    }
                });
                
                formData.set('appeal', appealValue);
                
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
                    url: "{{ route('updateApplication', $application->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#generateLetterButton').removeClass('disabled').attr('onclick',
                                "confirmNavigation('{{ route('user_letter', ['application_id' => $application->id]) }}')"
                            );
        
                            Swal.fire({
                                title: "@lang('app.success')",
                                text: response.message || "@lang('app.application_has_been_updated')",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = "{{ route('user_letter', ['application_id' => $application->id]) }}";
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
        
            // EVENT HANDLERS
            $('.form-control').on('blur', function() {
                const id = $(this).attr('id');
                if (id && id !== 'land_grant' && id !== 'discount') {
                    const value = $(this).val();
                    if (!value || value.trim() === '') {
                        $(this).addClass('is-invalid');
                        if ($('#' + id + '-error').length === 0) {
                            $(this).after('<div id="' + id + '-error" class="text-danger">This field is required</div>');
                        } else {
                            $('#' + id + '-error').text('This field is required').show();
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
        
            $('#appeal_type').on('change', function() {
                console.log('Appeal type changed to:', $(this).val());
            });
        
            // State/District handlers (keep your existing code)
            $('#negeri').on('change', function() {
                const stateId = $(this).val();
                $('#daerah').html('<option value="">Loading...</option>');
        
                if (stateId) {
                    $.ajax({
                        url: `/districts/${stateId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih Daerah</option>';
                            data.forEach(district => {
                                options += `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`;
                            });
                            $('#daerah').html(options);
                            checkFormAndToggleButton();
                        },
                        error: function() {
                            $('#daerah').html('<option value="">Error loading districts</option>');
                            checkFormAndToggleButton();
                        }
                    });
                } else {
                    $('#daerah').html('<option value="">Sila Pilih Daerah</option>');
                    checkFormAndToggleButton();
                }
            });
        
            $('#land_district').on('change', function() {
                const districtId = $(this).val();
                $('#mukim').html('<option value="">Loading...</option>');
        
                if (districtId) {
                    $.ajax({
                        url: `/division/${districtId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih</option>';
                            data.forEach(mukin => {
                                options += `<option value="${mukin.idmukim}">${mukin.mukim_code} - ${mukin.mukim}</option>`;
                            });
                            $('#mukim').html(options);
                            checkFormAndToggleButton();
                        },
                        error: function() {
                            $('#mukim').html('<option value="">Error loading mukim</option>');
                            checkFormAndToggleButton();
                        }
                    });
                } else {
                    $('#mukim').html('<option value="">Sila Pilih</option>');
                    checkFormAndToggleButton();
                }
            });
        
            $('#updatetButton').on('click', function(e) {
                e.preventDefault();
                if (validateForm()) {
                    $('#updateApplicationForm').submit();
                }
            });
        
            // Add CSS styles
            $('<style>')
                .prop('type', 'text/css')
                .html(`
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
                    .btn.disabled {
                        cursor: not-allowed;
                        opacity: 0.65;
                        pointer-events: none;
                    }
                `)
                .appendTo('head');
        
            // Initialize required field markers
            setTimeout(function() {
                const requiredFields = [
                    'application_reference', 'pemohon', 'ssm', 'alamat', 'poskod',
                    'bandar', 'negeri', 'daerah', 'emel', 'telefon',
                    'lot-tanah', 'keluasan', 'land_district', 'mukim', 'land_category'
                ];
        
                requiredFields.forEach(field => {
                    const label = $(`label[for="${field}"]`);
                    if (label.length && !label.find('.starr').length) {
                        label.append(' <b class="starr">*</b>');
                    }
                });
        
                const landGrantInput = $('#land_grant');
                if (landGrantInput.length) {
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info').length > 0;
                    if (hasExistingFile) {
                        $('label[for="land_grant"]').find('.starr').remove();
                    }
                }
        
                checkFormAndToggleButton();
                updateSubmitButton();
            }, 500);
        });
    </script>
    

    <script>
        function showRejectionMessage() {
            Swal.fire({
                title: @lang('app.rejected') ',,
                text: "@lang('app.application_rejected')",
                icon: 'error', // You can use 'warning' if preferred
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33', // Red color for the rejection
            });
        }

        // Example: Attach the function to a button
        document.getElementById('rejectButton').addEventListener('click', function(e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "@lang('app.are_you_sure')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Reject',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show rejection confirmation
                    showRejectionMessage();
                }
            });
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
            let appealTypeSelect = document.getElementById("appeal_type");

            const landCategoryId = document.getElementById('land_category_input')?.value || '0';
            const hectareValue = document.getElementById('hectare_input')?.value || '0';
            const discountValue = document.getElementById('adjustment_amount_input')?.value || '0';
            const savedAdjustmentType = document.getElementById('adjustment_type_input')?.value || 'percentage';
            const savedCostValue = document.getElementById('cost_input')?.value || '0';
            const marginValue = marginInput?.value || '0';
            const savedAppealValue = document.getElementById('appeal_input')?.value || '';
            
            const remarkInput = document.getElementById('remark');
            if (remarkInput) {
                remarkInput.addEventListener('input', function() {
                    document.getElementById('remark_input').value = this.value;
                });

                const savedRemark = "{{ $application->remark ?? '' }}";
                if (savedRemark) {
                    remarkInput.value = savedRemark;
                    document.getElementById('remark_input').value = savedRemark;
                }
            }

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
                hectareInput.value = parseFloat(hectareValue).toFixed(3);

               } else if (squareMetersInput && squareMetersInput.value && !isNaN(squareMetersInput.value)) {
                convertToHectare();
            } else {
                hectareInput.value = '0.00';
                document.getElementById('hectare_input').value = '0.00';
            }
            
            if (savedAppealValue) {
                appealTypeSelect.value = savedAppealValue;
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
            
            appealTypeSelect.addEventListener("change", function() {
                document.getElementById('appeal_input').value = this.value;
                updateAllValues();
            });

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
                let finalAmount = Math.max(0, baseAmount + marginAmount - discountAmount); // Prevent negative
                let halfAmount = finalAmount / 2;
                
                 let appealValue = appealTypeSelect.value;
                 document.getElementById('appeal_input').value = appealValue;

                let firstRow = document.querySelector("tbody tr:first-child");
                if (firstRow) {
                    firstRow.innerHTML = `
                <td>${rate.toFixed(2)}</td>
                <td>${hectare.toFixed(2)}</td>
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

                let marginRow = document.querySelector("tbody tr:nth-child(3)");
                if (marginPercentage > 0) {
                    if (!marginRow || marginRow.className === "total-row") {
                        marginRow = document.createElement("tr");
                        document.querySelector("tbody").insertBefore(marginRow, document.querySelector(
                            "tr.total-row"));
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
                document.querySelector('input[name="hectare"]').value = hectare.toFixed(2);
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
