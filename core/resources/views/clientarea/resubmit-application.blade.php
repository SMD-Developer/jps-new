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
                                    <div class="d-flex align-items-center justify-content-center">
                                        <small class="text-info">
                                            <a href="{{ url('core/public/pdf/' . basename($application->land_grant)) }}" 
                                               target="_blank">
                                               <i class="fa fa-file-pdf-o"></i> {{ basename($application->land_grant) }}
                                            </a>
                                        </small>
                                        <button type="button" class="btn btn-link text-danger remove-file-btn" 
                                                data-target="land_grant" style="font-size: larger;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <input type="hidden" name="remove_land_grant" id="remove_land_grant" value="0">
                                    </div>
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
                    updateAllValues(); // Update calculations when square meters changes
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
        document.addEventListener('DOMContentLoaded', function() {
            // File size validation constants
            const maxFileSize = 15 * 1024 * 1024; // 15MB in bytes
            const allowedTypes = ['application/pdf'];
            
            // Track file validation status
            let fileValidationStatus = {
                land_grant: true,
                permission_plan: true,
                letter_of_support: true
            };
            
            // Function to format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            // Function to validate file
            function validateFile(file, fieldName) {
                const errors = [];
                
                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    errors.push(`Only PDF files are allowed.`);
                }
                
                // Check file size
                if (file.size > maxFileSize) {
                    errors.push(`File size (${formatFileSize(file.size)}) exceeds the maximum limit of 15MB.`);
                }
                
                return errors;
            }
            
            // Function to show file error
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
                
                // Clear file input
                inputElement.value = '';
                const fileNameDisplay = document.getElementById(inputElement.id.replace('_', '_') + 'fileName');
                if (fileNameDisplay) {
                    fileNameDisplay.textContent = '';
                }
                
                // Update validation status
                fileValidationStatus[inputElement.id] = false;
            }
            
            // Function to clear file error
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
        
            // Function to validate files on form submission
            function validateFilesOnSubmit() {
                const fileInputs = ['land_grant', 'permission_plan', 'letter_of_support'];
                let allValid = true;
                
                fileInputs.forEach(inputId => {
                    const fileInput = document.getElementById(inputId);
                    if (fileInput && fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        const errors = validateFile(file, inputId);
                        
                        if (errors.length > 0) {
                            showFileError(fileInput, errors.join(' '));
                            allValid = false;
                        } else {
                            clearFileError(fileInput);
                        }
                    } else {
                        // No file selected, clear any existing errors
                        if (fileInput) {
                            clearFileError(fileInput);
                        }
                    }
                });
                
                return allValid;
            }
        
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
        
            fileInputs.forEach(({input, display}) => {
                const fileInput = document.getElementById(input);
                const fileNameDisplay = document.getElementById(display);
        
                if (fileInput && fileNameDisplay) {
                    fileInput.addEventListener('change', function() {
                        const file = this.files[0];
                        
                        if (file) {
                            // Validate file
                            const errors = validateFile(file, input);
                            
                            if (errors.length > 0) {
                                showFileError(this, errors.join(' '));
                                return;
                            }
                            
                            // Clear any previous errors
                            clearFileError(this);
                            
                            // Display file name with size
                            const fileName = `${file.name} (${formatFileSize(file.size)})`;
                            fileNameDisplay.textContent = fileName;
                            
                            // Optional: Log file details for debugging
                            console.log(`${input} file selected:`, {
                                name: file.name,
                                type: file.type,
                                size: file.size,
                                sizeFormatted: formatFileSize(file.size)
                            });
                        } else {
                            fileNameDisplay.textContent = '';
                            clearFileError(this);
                        }
                    });
                }
            });
        
            // Add global validation function for form submission
            window.validateFileSize = function() {
                return validateFilesOnSubmit() && areAllFilesValid();
            };
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

            // Initially disable the Generate Letter button
            $('#generateLetterButton').addClass('disabled').attr('onclick', 'return false;');

            // Function to check if form is valid and toggle the Generate Letter button
            function checkFormAndToggleButton() {
                let formIsValid = true;

                // List of all required fields to check
                const requiredFields = [
                    'application_reference', 'pemohon', 'ssm', 'alamat', 'poskod',
                    'bandar', 'negeri', 'daerah', 'emel', 'telefon',
                    'lot-tanah', 'keluasan', 'land-unit', 'land_district', 'mukim', 'land_category'
                ];

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

                // Check other validations (email, postal code, phone number, etc.)
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

                // Check land grant file validation
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

            // Add validation function
            function validateForm() {
                let isValid = true;
                let firstInvalidField = null;

                const requiredFields = [{
                        id: 'application_reference',
                        name: 'Application Reference'
                    },
                    {
                        id: 'pemohon',
                        name: 'Applicant'
                    },
                    {
                        id: 'ssm',
                        name: 'Identification Card No'
                    },
                    {
                        id: 'alamat',
                        name: 'Address'
                    },
                    {
                        id: 'poskod',
                        name: 'Postal Code'
                    },
                    {
                        id: 'bandar',
                        name: 'City'
                    },
                    {
                        id: 'negeri',
                        name: 'State'
                    },
                    {
                        id: 'daerah',
                        name: 'District'
                    },
                    {
                        id: 'emel',
                        name: 'Email'
                    },
                    {
                        id: 'telefon',
                        name: 'Telephone'
                    },
                    {
                        id: 'lot-tanah',
                        name: 'Land Lot'
                    },
                    {
                        id: 'keluasan',
                        name: 'Land Area'
                    },
                    {
                        id: 'land-unit',
                        name: 'Land Unit'
                    },
                    {
                        id: 'land_district',
                        name: 'Land District'
                    },
                    {
                        id: 'mukim',
                        name: 'Mukim'
                    },
                    {
                        id: 'land_category',
                        name: 'Land Category'
                    }
                ];

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

                // Validate land category separately as it's in a different part of the form
                const landCategoryElement = $('#land_category');
                if (landCategoryElement.length && (landCategoryElement.val() === null || landCategoryElement
                    .val() === '')) {
                    isValid = false;
                    landCategoryElement.addClass('is-invalid');

                    if ($('#land_category-error').length === 0) {
                        landCategoryElement.after(
                            '<div id="land_category-error" class="text-danger">Land category is required</div>');
                    } else {
                        $('#land_category-error').text('Land category is required').show();
                    }

                    if (!firstInvalidField) {
                        firstInvalidField = landCategoryElement;
                    }
                } else if (landCategoryElement.length) {
                    landCategoryElement.removeClass('is-invalid');
                    $('#land_category-error').hide();
                }

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

                // MODIFIED: Check land grant file only if there is no existing file
                const landGrantInput = $('#land_grant');
                if (landGrantInput.length) {
                    // Check if there's an existing file by looking for the "Current file" text
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info').length > 0;

                    // Only validate if there's no existing file and no new file uploaded
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

                // Scroll to the first invalid field if validation fails
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
                if (id) {
                    // Skip validation for land_grant and discount fields
                    if (id === 'land_grant' || id === 'discount') {
                        return;
                    }

                    const value = $(this).val();
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

            // Handle State Change for Districts - keep your existing code
            $('#negeri').on('change', function() {
                const stateId = $(this).val();
                $('#daerah').html('<option value="">Loading...</option>'); // Show loading

                if (stateId) {
                    $.ajax({
                        url: `/districts/${stateId}`, // Correct backend route
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih Daerah</option>';
                            data.forEach(district => {
                                options +=
                                    `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`;
                            });
                            $('#daerah').html(options); // Populate the dropdown
                            checkFormAndToggleButton
                        (); // Check form validity after populating dropdown
                        },
                        error: function() {
                            $('#daerah').html(
                                '<option value="">Error loading districts</option>');
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
                $('#mukim').html('<option value="">Loading...</option>'); // Show loading message

                if (districtId) {
                    $.ajax({
                        url: `/division/${districtId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih</option>';
                            data.forEach(mukin => {
                                options +=
                                    `<option value="${mukin.idmukim}">${mukin.mukim_code} - ${mukin.mukim}</option>`;
                            });
                            $('#mukim').html(options); 
                            checkFormAndToggleButton
                        (); 
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
                const hectareValue = parseFloat($('input[name="hectare"]').val()) || 0;
                const adjustmentValue = parseFloat($('input[name="adjustment_percentage"]').val()) || 0;

                $('input[name="hectare"]').val(hectareValue.toFixed(2));
                $('input[name="adjustment_percentage"]').val(adjustmentValue.toFixed(2));

                let formData = new FormData(this);
                const fileInputs = ['land_grant', 'permission_plan', 'letter_of_support'];
                
                let fileSizeValid = true;
                    fileInputs.forEach(inputName => {
                        const fileInput = $(`#${inputName}`)[0];
                        if (fileInput.files.length > 0) {
                            const file = fileInput.files[0];
                            if (file.size > 15 * 1024 * 1024) { // 15MB check
                                fileSizeValid = false;
                                return;
                            }
                            formData.append(inputName, file);
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
                
                
                // fileInputs.forEach(inputName => {
                //     const fileInput = $(`#${inputName}`)[0];
                //     if (fileInput.files.length > 0) {
                //         formData.append(inputName, fileInput.files[0]);
                //     }
                // });

                console.log("FormData prepared:", formData);
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
                        console.log("Response received:", response);
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
                                window.location.href =
                                    "{{ route('client_application_status') }}";
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
                        console.error("Error occurred:", xhr);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            console.log("Validation Errors:", errors);

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
                    const hasExistingFile = landGrantInput.closest('.form-group').find('.text-info')
                        .length > 0;
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
        // Set the hidden input to indicate file should be removed
        $('#remove_' + $(this).data('target')).val('1');
        // Remove the file display element
        $(this).parent().remove();
    });
});
</script>
    
@endsection
