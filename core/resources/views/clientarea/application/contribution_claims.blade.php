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

    label.required::after {
        content: " *";
        color: red;
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
        color: #4dbd1aff;
    }

    .file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 10px;
    background-color: #f8f9fa;
    border-radius: 4px;
    margin-bottom: 5px;
}

.file-item-name {
    flex: 1;
    font-size: 12px;
}

.remove-file-btn {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    font-size: 12px;
    line-height: 1;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-file-btn:hover {
    background: #c82333;
}

.remove-existing-file-btn {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 2px 8px;
    cursor: pointer;
    font-size: 11px;
    margin-left: 10px;
}

.remove-existing-file-btn:hover {
    background: #c82333;
}
</style>
<title>@lang('Permohonan Baru') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-plus-circle nav-icon"></i> @lang('Permohonan Baru')</h5>
    </div>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-container">
                        <!--<h2>@lang('Permohonan Baru')</h2>-->

                        <!-- Personal Information Section -->
                        <div class="section">
                            <h4>@lang('Pulang Balik (Refund) Caruman Parit')</h4>
                            
                            <!-- Show reapplication notice if it's a reapply -->
                            @if(isset($claim))
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> 
                                    <strong>Permohonan Semula</strong> - Sila semak dan kemaskini maklumat anda sebelum menghantar semula.
                                </div>
                            @endif
                            
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

                                <!-- Hidden fields for reapplication -->
                                @if(isset($claim))
                                    <input type="hidden" name="is_reapply" id="is_reapply" value="1">
                                    <input type="hidden" name="original_claim_id" value="{{ $claim->id }}">
                                @else
                                    <input type="hidden" name="is_reapply" id="is_reapply" value="0">
                                @endif


                                <input type="hidden" name="removed_land_grant" id="removed_land_grant" value="">
                                <input type="hidden" name="removed_new_receipt" id="removed_new_receipt" value="">
                                <input type="hidden" name="removed_supporting_docs" id="removed_supporting_docs" value="">
                                <input type="hidden" name="removed_refund_claim_letter" id="removed_refund_claim_letter" value="">
                                <input type="hidden" name="removed_ic_copy" id="removed_ic_copy" value="">
                                <input type="hidden" name="removed_bank_statement" id="removed_bank_statement" value="">
                                <input type="hidden" name="removed_statutory_declaration" id="removed_statutory_declaration" value="">
                                <input type="hidden" name="removed_company_registration" id="removed_company_registration" value="">

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
                                                    <select id="account_types" name="account_types" class="form-control form-select" required>
                                                        @php
                                                            $userAccountType = isset($claim) ? $claim->account_types : ($client->accountType ?? null);
                                                            // Only show account types 1 and 2
                                                            $allowedAccountTypes = $accountTypes->whereIn('id', [1, 2, 3, 4]);
                                                        @endphp
                                                        
                                                        @foreach($allowedAccountTypes as $accountType)
                                                            <option value="{{ $accountType->id }}" 
                                                                {{ $userAccountType == $accountType->id ? 'selected' : '' }}>
                                                                {{ $accountType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Hidden field for Agency users - store their account type -->
                                        <input type="hidden" name="account_types" value="{{ $client->accountType }}">
                                    @endif
                                    
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
                                                <label for="pemohon" class="required">@lang('app.applicant_individual_company')</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="pemohon" name="applicant" class="form-control"
                                                    placeholder="Nama Pemohon" 
                                                    value="{{ old('applicant', isset($claim) ? $claim->applicant : ($client->userName ?? '')) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label for="ssm">
                                                    @lang('app.identification_card_no')
                                                    <span class="identities-required-asterisk" style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="ssm" name="identities" class="form-control"
                                                    placeholder="No. Kad Pengenalan / SSM No."
                                                    value="{{ old('identities', isset($claim) ? $claim->identities : ($client->idCardNumber ?? '')) }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label for="alamat" class="required">@lang('app.applicant_address')</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea id="alamat" class="form-control" name="address" rows="4" placeholder="Alamat Pemohon">{{ old('address', isset($claim) ? $claim->address : ($client->registeredAddress ?? '')) }}</textarea>
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
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    value="{{ old('postal_code', isset($claim) ? $claim->postal_code : ($client->postalCode ?? '')) }}">
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
                                                    placeholder="Bandar" 
                                                    value="{{ old('city', isset($claim) ? $claim->city : ($client->city ?? '')) }}">
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
                                                            {{ old('state', isset($claim) ? $claim->state : ($client->state_id ?? '')) == $value->idnegeri ? 'selected' : '' }}>
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
                                                <label for="daerah" class="district-label">
                                                    @lang('app.district')
                                                    <span class="required-asterisk" style="color: red;">*</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select id="daerah" class="form-control form-select" name="district">
                                                    <option value="" disabled>@lang('Sila Pilih Daerah')</option>
                                                    @foreach ($district as $value)
                                                        <option value="{{ $value->iddaerah }}"
                                                            {{ old('district', isset($claim) ? $claim->district : ($client->district_id ?? '')) == $value->iddaerah ? 'selected' : '' }}>
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
                                                    placeholder="Alamat Emel" 
                                                    value="{{ old('email', isset($claim) ? $claim->email : ($client->email ?? '')) }}">
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
                                                    value="{{ old('phone', isset($claim) ? $claim->phone : ($client->mobileNumber ?? '')) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                         <!-- Project Information Section -->
                        <div class="section">
                            <h4>@lang('Maklumat Projek')</h4>
                            
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
                                            <textarea id="project_name" name="project_name" class="form-control" rows="4" placeholder="Nama Projek">{{ $claim->project_name ?? '' }}</textarea>
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
                                            <input type="text" id="lot-tanah" name="land_lot" class="form-control"
                                                placeholder="Land lot"
                                                value="{{ old('land_lot', isset($claim) ? $claim->land_lot : '') }}">
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="keluasan" class="required">@lang('app.land_area')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-baseline flex-wrap">
                                            <div class="position-relative pe-5">
                                                <select id="land-unit" name="land_unit" class="form-control form-select me-3"
                                                    onchange="convertToHectare()">
                                                    <option value="" selected disabled>- Sila Pilih -</option>
                                                    @foreach ($landMeasurement as $land)
                                                        <option value="{{ $land->id }}"
                                                            {{ old('land_unit', isset($claim) ? $claim->land_unit : '') == $land->id ? 'selected' : '' }}>
                                                            {{ $land->display_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                            <div class="position-relative">
                                                <input type="text" id="keluasan" name="land_area" class="form-control"
                                                    placeholder="Land area"
                                                    oninput="validateNumberInput(this); convertToHectare()"
                                                    onkeypress="return isNumberKey(event)"
                                                    value="{{ old('land_area', isset($claim) ? $claim->land_area : '') }}">
                                            </div>        
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
                                            <label for="land_district" class="required">@lang('app.district')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id="land_district" class="form-control form-select" name="land_district">
                                                <option value="" selected disabled>- Sila Pilih -</option>
                                                @foreach ($district as $value)
                                                    <option value="{{ $value->iddaerah }}"
                                                        {{ old('land_district', isset($claim) ? $claim->land_district : '') == $value->iddaerah ? 'selected' : '' }}>
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
                                            <label for="mukim" class="required">@lang('Mukim')</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id="mukim" class="form-control form-select" name="land_state">
                                                <option value="" selected disabled>- Sila Pilih -</option>
                                                @if(isset($claim) && $claim->land_state)
                                                    @foreach($division as $div)
                                                        <option value="{{ $div->idmukim }}"
                                                            {{ old('land_state', $claim->land_state) == $div->idmukim ? 'selected' : '' }}>
                                                            {{ $div->mukim_code }} - {{ $div->mukim }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <h4>Muat Naik Dokumen Sokongan</h4>      
                        <!-- Old Receipt Upload -->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="geran-tanah">
                                    Resit Bayaran Asal 
                                        <b class="starr">*</b>
                                </label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->land_grant)
                                    @php
                                        // Handle both string and array
                                        if (is_string($claim->land_grant)) {
                                            $landGrantFiles = json_decode($claim->land_grant, true);
                                        } else {
                                            $landGrantFiles = $claim->land_grant;
                                        }
                                    @endphp
                                    @if (is_array($landGrantFiles) && count($landGrantFiles) > 0)
                                        <div class="mb-2 p-2" style="background-color: #f8f9fa; border-radius: 5px;">
                                            <small class="text-muted"><strong>Fail Sebelum:</strong></small>
                                            <div id="existing_land_grant_files" style="display: flex; flex-direction: column; gap: 8px; margin-top: 5px;">
                                                @foreach ($landGrantFiles as $index => $filePath)
                                                    <div class="existing-file-item" 
                                                        data-field="land_grant" 
                                                        data-index="{{ $index }}"
                                                        style="display: flex; align-items: center; justify-content: space-between; padding: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;">
                                                        <a href="{{ url($filePath) }}" target="_blank" class="text-primary" style="font-size: 12px; flex: 1;">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-existing-file" 
                                                                style="padding: 2px 8px; font-size: 11px; margin-left: 10px;">
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
                                
                                <label for="land_grant" class="submit-button">@lang('app.choose_file')</label>
                                <input type="file" id="land_grant" name="land_grant[]" class="file-input"
                                    accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'land_grant')">
                                <div id="land_grant_fileList" class="file-list mt-2"></div>
                                <div id="land_grant_error" class="text-danger mt-1"></div>
                            </div>
                        </div>

                        <!-- New Receipt Upload - Required -->
                         <div class="form-group">
                            <div class="col-md-4">
                                <label for="new-receipt">@lang('Resit Bayaran kali kedua')</label>
                                <small class="text-muted d-block">(sekiranya membuat dua kali pembayaran)</small>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->new_receipt)
                                    @php
                                        // Handle both string and array
                                        if (is_string($claim->new_receipt)) {
                                            $newReceiptFiles = json_decode($claim->new_receipt, true);
                                        } else {
                                            $newReceiptFiles = $claim->new_receipt;
                                        }
                                    @endphp
                                    @if (is_array($newReceiptFiles) && count($newReceiptFiles) > 0)
                                        <div class="mb-2 p-2" style="background-color: #f8f9fa; border-radius: 5px;">
                                            <small class="text-muted"><strong>Fail Sebelum:</strong></small>
                                            <!-- ✅ ADD ID HERE -->
                                            <div id="existing_new_receipt_files" style="display: flex; flex-direction: column; gap: 4px; margin-top: 5px;">
                                                <!-- ✅ ADD $index AND data ATTRIBUTES -->
                                                @foreach ($newReceiptFiles as $index => $filePath)
                                                <div class="existing-file-item" 
                                                    data-field="new_receipt" 
                                                    data-index="{{ $index }}"
                                                    style="display: flex; align-items: center; justify-content: space-between; padding: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;">
                                                    <a href="{{ url($filePath) }}" target="_blank" class="text-primary" style="font-size: 12px; flex: 1;">
                                                        <i class="fa fa-file-pdf-o text-danger"></i> {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                    </a>
                                                    <!-- ✅ CHANGE BUTTON: Remove onclick, add class -->
                                                    <button type="button" class="btn btn-sm btn-danger remove-existing-file" 
                                                            style="padding: 2px 8px; font-size: 11px; margin-left: 10px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <!-- ✅ ADD FILE COUNT -->
                                            <small id="new_receipt_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($newReceiptFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                
                                <label for="new_receipt" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="new_receipt" name="new_receipt[]" class="file-input"
                                    accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'new_receipt')">
                                <div id="new_receipt_fileList" class="file-list mt-2"></div>
                                <div id="new_receipt_error" class="text-danger mt-1"></div>
                            </div>
                        </div>

                        <!-- Surat Permohonan Tuntutan Pulang Balik (Required) -->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="refund_claim_letter">Surat Permohonan Tuntutan Pulang Balik <b class="starr"></b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->refund_claim_letter)
                                    @php
                                        if (is_string($claim->refund_claim_letter)) {
                                            $refundLetterFiles = json_decode($claim->refund_claim_letter, true);
                                        } else {
                                            $refundLetterFiles = $claim->refund_claim_letter;
                                        }
                                    @endphp
                                    @if (is_array($refundLetterFiles) && count($refundLetterFiles) > 0)
                                        <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                            <small class="text-muted"><strong>Fail Sebelum:</strong></small>
                                            <div id="existing_refund_claim_letter_files" style="display: flex; flex-direction: column; gap: 4px; margin-top: 5px;">
                                                @foreach ($refundLetterFiles as $index => $filePath)
                                                    <div  
                                                    class="existing-file-item"
                                                    data-field="refund_claim_letter" 
                                                    data-index="{{ $index }}"
                                                    style="display: flex; align-items: center; justify-content: space-between; padding: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;">
                                                        <a href="{{ url($filePath) }}" target="_blank" class="text-primary" style="font-size: 12px;">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-existing-file" 
                                                            style="padding: 2px 8px; font-size: 11px; margin-left: 10px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <label for="refund_claim_letter" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="refund_claim_letter" name="refund_claim_letter[]" class="file-input"
                                    accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'refund_claim_letter')">
                                <div id="refund_claim_letter_fileList" class="file-list mt-2"></div>
                                <div id="refund_claim_letter_error" class="text-danger mt-1"></div>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="ic_copy">Geran/Pelan Kelulusan KM <b class="starr"></b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->ic_copy)
                                    @php
                                        if (is_string($claim->ic_copy)) {
                                            $icCopyFiles = json_decode($claim->ic_copy, true);
                                        } else {
                                            $icCopyFiles = $claim->ic_copy;
                                        }
                                    @endphp
                                    @if (is_array($icCopyFiles) && count($icCopyFiles) > 0)
                                        <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                            <small class="text-muted"><strong>Fail Sebelum:</strong></small>
                                            <div id="existing_ic_copy_files" style="display: flex; flex-direction: column; gap: 4px; margin-top: 5px;">
                                                @foreach ($icCopyFiles  as $index => $filePath)
                                                    <div 
                                                    class="existing-file-item"
                                                    data-field="ic_copy" 
                                                    data-index="{{ $index }}"
                                                    style="display: flex; align-items: center; justify-content: space-between; padding: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;">
                                                        <a href="{{ url($filePath) }}" target="_blank" class="text-primary" style="font-size: 12px;">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                         <button type="button" class="btn btn-sm btn-danger remove-existing-file" 
                                                            style="padding: 2px 8px; font-size: 11px; margin-left: 10px;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small id="ic_copy_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($icCopyFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                <label for="ic_copy" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="ic_copy" name="ic_copy[]" class="file-input"
                                    accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'ic_copy')">
                                <div id="ic_copy_fileList" class="file-list mt-2"></div>
                                <div id="ic_copy_error" class="text-danger mt-1"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="bank_statement">Surat Penetapan Jumlah Bayaran Caruman Parit <b class="starr"></b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->bank_statement)
                                    @php
                                        if (is_string($claim->bank_statement)) {
                                            $bankStatementFiles = json_decode($claim->bank_statement, true);
                                        } else {
                                            $bankStatementFiles = $claim->bank_statement;
                                        }
                                    @endphp
                                    @if (is_array($bankStatementFiles) && count($bankStatementFiles) > 0)
                                        <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                            <small class="text-muted"><strong>Fail Sebelum:</strong></small>
                                            <div id="existing_bank_statement_files" style="display: flex; flex-direction: column; gap: 4px; margin-top: 5px;">
                                                @foreach ($bankStatementFiles as $index => $filePath)
                                                    <div 
                                                    class="existing-file-item"
                                                    data-field="bank_statement" 
                                                    data-index="{{ $index }}"
                                                    style="display: flex; align-items: center; justify-content: space-between; padding: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;">
                                                        <a href="{{ url($filePath) }}" target="_blank" class="text-primary" style="font-size: 12px;">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                         <button type="button" class="btn btn-sm btn-danger remove-existing-file" 
                                                            style="padding: 2px 8px; font-size: 11px; margin-left: 10px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small id="bank_statement_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($bankStatementFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                <label for="bank_statement" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="bank_statement" name="bank_statement[]" class="file-input"
                                    accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'bank_statement')">
                                <div id="bank_statement_fileList" class="file-list mt-2"></div>
                                <div id="bank_statement_error" class="text-danger mt-1"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="statutory_declaration">Surat Akuan Sumpah</label>
                                <br>
                                <small class="text-muted">(sekiranya dokumen/ resit asal hilang)</small>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->statutory_declaration)
                                    @php
                                        if (is_string($claim->statutory_declaration)) {
                                            $statutoryFiles = json_decode($claim->statutory_declaration, true);
                                        } else {
                                            $statutoryFiles = $claim->statutory_declaration;
                                        }
                                    @endphp
                                    @if (is_array($statutoryFiles) && count($statutoryFiles) > 0)
                                        <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                            <small class="text-muted"><strong>Fail Sebelum:</strong></small>
                                            <div id="existing_statutory_declaration_files" style="display: flex; flex-direction: column; gap: 4px; margin-top: 5px;">
                                                @foreach ($statutoryFiles as $filePath)
                                                    <div
                                                     class="existing-file-item"
                                                     data-field="statutory_declaration" 
                                                     data-index="{{ $index }}"
                                                     style="display: flex; align-items: center; justify-content: space-between; padding: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;">
                                                        <a href="{{ url($filePath) }}" target="_blank" class="text-primary" style="font-size: 12px;">
                                                            <i class="fa fa-file-pdf-o text-danger"></i> {{ preg_replace('/^\d+_[a-f0-9]+_/', '', basename($filePath)) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger remove-existing-file" 
                                                            style="padding: 2px 8px; font-size: 11px; margin-left: 10px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small id="statutory_declaration_file_count" style="color: #0056b3; margin-top: 5px; display: block;">
                                                <i class="fa fa-info-circle"></i> Total: <span class="file-count">{{ count($statutoryFiles) }}</span> file(s)
                                            </small>
                                        </div>
                                    @endif
                                @endif
                                <label for="statutory_declaration" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="statutory_declaration" name="statutory_declaration[]" class="file-input"
                                    accept="application/pdf" multiple onchange="handleMultipleFiles(this, 'statutory_declaration')">
                                <div id="statutory_declaration_fileList" class="file-list mt-2"></div>
                                <div id="statutory_declaration_error" class="text-danger mt-1"></div>
                            </div>
                        </div>


                        <div class="form-group" style="display:none;">
                            <div class="col-md-4">
                                <label for="company_registration">Pendaftaran Syarikat</label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->company_registration)
                                    <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> Fail Sebelum:
                                            <a href="{{ url('pdf/' . basename($claim->company_registration)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif

                                <label for="company_registration" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="company_registration" name="company_registration" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="company_registrationfileName" class="file-name"></div>
                                <div id="company_registration_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Supporting Documents Upload - Optional -->
                        <div class="form-group" style="display:none;">
                            <div class="col-md-4">
                                <label for="supporting-docs">@lang('Dokumen Sokongan')</label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->supporting_docs)
                                    <div class="mb-2 p-2" style="background-color: #f8f9fa; border-radius: 5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> 
                                            Fail Sebelum: 
                                            <a href="{{ url('pdf/' . basename($claim->supporting_docs)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif
                                <label for="supporting_docs" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="supporting_docs" name="supporting_docs" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="supporting_docsfileName" class="file-name"></div>
                                <div id="supporting_docs_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Claim Reason Text Area - Optional -->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="claim-reason">@lang('Nyatakan Alasan Tuntutan')<b class="starr">*</b></label>
                            </div>
                            <div class="col-md-8">
                                <textarea id="claim-reason" name="claim_reason" class="form-control" rows="4" 
                                    placeholder="@lang('Nyatakan alasan tuntutan anda')">{{ old('claim_reason', isset($claim) ? $claim->claim_reason : '') }}</textarea>
                                <div id="claim_reason_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>
                        
                        <!-- Claim Amount Field -->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="payment_amount">Jumlah Yang Dituntut (RM)<b class="starr">*</b></label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="payment_amount" name="payment_amount" class="form-control"
                                    pattern="[0-9]*" 
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                    value="{{ old('payment_amount', isset($claim) ? $claim->payment_amount : '') }}">
                                <div id="claim_amount_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>
                        
                        <p class="note">
                            *@lang('app.file_only_pdf_format_size_not_exceed_15mb')
                        </p>

                        <!-- Submit Section -->
                        <div class="form-actions">
                            <!--<button type="button" class="btn btn-secondary">@lang('Kembali')</button>-->
                            <!--<button type="submit" class="btn btn-primary" id="updateButton">@lang('app.update')</button>-->
                            <button type="submit" class="btn btn-primary">
                                @if(isset($claim))
                                    <i class="fa fa-refresh"></i> @lang('Hantar Semula')
                                @else
                                    @lang('app.send')
                                @endif
                            </button>
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


            let removedLandGrantFiles = [];

            function updateLandGrantRequirement() {
                const asteriskElement = $('label[for="land_grant"] .starr');
                if (asteriskElement.length === 0) {
                    $('label[for="land_grant"]').append(' <b class="starr">*</b>');
                }
            }


            $(document).on('click', '#existing_land_grant_files .remove-existing-file', function() {
                const fileItem = $(this).closest('.existing-file-item');
                const fileIndex = fileItem.data('index');
                
                removedLandGrantFiles.push(fileIndex);
                
                fileItem.remove();

                const remainingFiles = $('#existing_land_grant_files .existing-file-item').length;
                $('#land_grant_file_count .file-count').text(remainingFiles);
                
                if (remainingFiles === 0) {
                    $('#existing_land_grant_files').closest('.mb-2').hide();
                }
            });

            // Initialize on page load for reapply forms
            const isReapply = $('#is_reapply').length > 0 && $('#is_reapply').val() === '1';
            if (isReapply) {
                updateLandGrantRequirement();
            }

            

            $('#negeri').on('change', function() {
                const stateId = $(this).val();
                const selectedText = $(this).find('option:selected').text();
                const stateCode = selectedText.split(' - ')[0].trim();

                if (['14', '15', '16'].includes(stateCode)) {
                    $('.required-asterisk').hide();
                    $('#daerah').prop('required', false);
                } else {
                    $('.required-asterisk').show();
                    $('#daerah').prop('required', true);
                }

                $('#daerah').html('<option value="">Loading...</option>');

                if (stateId) {
                    $.ajax({
                        url: `/clientarea/districts/${stateId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih Daerah</option>';
                            data.forEach(district => {
                                options += `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`;
                            });

                            $('#daerah').html(options);
                            let selectedDistrict =
                                "{{ old('district', isset($claim) ? $claim->district : ($client->district_id ?? '')) }}";

                            if (selectedDistrict) {
                                $('#daerah').val(selectedDistrict);
                            }
                        },
                        error: function() {
                            $('#daerah').html('<option value="">Error loading districts</option>');
                        }
                    });
                } else {
                    $('#daerah').html('<option value="">Sila Pilih Daerah</option>');
                }
            });

            $('#negeri').trigger('change');


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

            
            $('#account_types').on('change', function() {
                const accountType = $(this).val();
                
                if (accountType == '3') {
                    $('.identities-required-asterisk').hide();
                    $('#ssm').prop('required', false);
                } else {
                    $('.identities-required-asterisk').show();
                    $('#ssm').prop('required', true);
                }
            }).trigger('change'); 

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

                const isReapply = $('#is_reapply').length > 0 && $('#is_reapply').val() === '1';

                // Get the selected account type from the dropdown
                const selectedAccountType = $('#account_types').val();

                let hasErrors = false;
                function showError(fieldName, message) {
                    hasErrors = true;
                    let inputField = $('[name="' + fieldName + '"]');
                    inputField.addClass('is-invalid');
                    inputField.after('<div class="invalid-feedback d-flex justify-content-end">' + message + '</div>');
                }

                // Validate required fields
                if (!$('[name="uploade_date"]').val()) {
                    showError('uploade_date', "@lang('app.uploade_date_required')");
                }
                if (!$('[name="applicant"]').val()) {
                    showError('applicant', "@lang('app.applicant_required')");
                }

                // Only validate identities if account type is NOT 3
                if (selectedAccountType != '3' && !$('[name="identities"]').val()) {
                    showError('identities', "@lang('app.identities_required')");
                }

                if (!$('[name="address"]').val()) {
                    showError('address', "@lang('app.address_required')");
                }
                
                const postalCode = $('[name="postal_code"]').val();
                if (!postalCode) {
                    showError('postal_code', "@lang('app.postal_code_required')");
                } else if (!/^\d+$/.test(postalCode)) {
                    showError('postal_code', "@lang('app.postal_code_numeric')");
                } else if (postalCode.length < 4 || postalCode.length > 8) {
                    showError('postal_code', "@lang('app.postal_code_digits')");
                }
                
                const phone = $('[name="phone"]').val();
                if (phone) {
                    if (!/^\d+$/.test(phone)) {
                        showError('phone', "@lang('app.phone_numeric')");
                    } else if (phone.length < 10 || phone.length > 15) {
                        showError('phone', "@lang('app.phone_digits_between')");
                    }
                }

                const paymentAmount = $('[name="payment_amount"]').val();
                if (!paymentAmount) {
                    showError('payment_amount', "@lang('Medan ini wajib diisi')");
                } else if (isNaN(paymentAmount)) {
                    showError('payment_amount', "@lang('app.claim_amount_numeric')");
                } else if (parseFloat(paymentAmount) <= 0) {
                    showError('payment_amount', "@lang('app.claim_amount_positive')");
                }

                const claimReason = $('[name="claim_reason"]').val();
                if(!claimReason){
                     showError('claim_reason', "@lang('Medan ini wajib diisi')");
                }
                
                // Validate email
                const email = $('[name="email"]').val();
                if (!email) {
                    showError('email', "@lang('app.email_required')");
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showError('email', "@lang('app.email_valid')");
                }
                
                if (!$('[name="city"]').val()) {
                    showError('city', "@lang('app.city_required')");
                }
                const selectedStateCode = $('#negeri option:selected').text().split(' - ')[0].trim();
                if (!['14', '15', '16'].includes(selectedStateCode) && !$('[name="district"]').val()) {
                    showError('district', "@lang('app.district_required')");
                }
                if (!$('[name="state"]').val()) {
                    showError('state', "@lang('app.state_required')");
                }
                if (!$('[name="land_district"]').val()) {
                    showError('land_district', "@lang('Medan ini wajib diisi')");
                }
                if (!$('[name="land_lot"]').val()) {
                    showError('land_lot', "@lang('Medan ini wajib diisi')");
                }
                if (!$('[name="land_area"]').val()) {
                    showError('land_area', "@lang('Medan ini wajib diisi')");
                }
                if (!$('[name="land_unit"]').val()) {
                    showError('land_unit', "@lang('Medan ini wajib diisi')");
                }

                 // Validate land_grant file - MULTIPLE FILES
                const landGrantFiles = $('#land_grant')[0].files;
                const remainingLandGrantFiles = $('#existing_land_grant_files .existing-file-item').length;

                if (remainingLandGrantFiles === 0 && landGrantFiles.length === 0) {
                    showError('land_grant', "@lang('Fail wajib dimuatnaik')");
                    $('#land_grant_error').text("@lang('Fail wajib dimuatnaik')").show();
                } else if (landGrantFiles.length > 0) {
                    Array.from(landGrantFiles).forEach((file) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('land_grant', "@lang('app.land_grant_max')");
                            $('#land_grant_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('land_grant', "@lang('app.land_grant_mimes')");
                            $('#land_grant_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }

                // Validate new_receipt file - NOW OPTIONAL (no required validation)
                const newReceiptFiles = $('#new_receipt')[0].files;
                if (newReceiptFiles.length > 0) {
                    // Only validate if files are selected
                    Array.from(newReceiptFiles).forEach((file, index) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('new_receipt', "@lang('app.land_grant_max')");
                            $('#new_receipt_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('new_receipt', "@lang('app.land_grant_mimes')");
                            $('#new_receipt_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }

                // Validate supporting_docs file (OPTIONAL - only validate if file is selected)
                const supportingDocsFiles = $('#supporting_docs')[0];
                if (supportingDocsFiles && supportingDocsFiles.files.length > 0) {
                    Array.from(supportingDocsFiles.files).forEach((file, index) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('supporting_docs', "@lang('app.land_grant_max')");
                            $('#supporting_docs_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('supporting_docs', "@lang('app.land_grant_mimes')");
                            $('#supporting_docs_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }

                // Validate refund_claim_letter (OPTIONAL) - MULTIPLE FILES
                const refundClaimLetterFile = $('#refund_claim_letter')[0];
                if (refundClaimLetterFile && refundClaimLetterFile.files.length > 0) {
                    Array.from(refundClaimLetterFile.files).forEach((file, index) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('refund_claim_letter', "@lang('app.land_grant_max')");
                            $('#refund_claim_letter_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('refund_claim_letter', "@lang('app.land_grant_mimes')");
                            $('#refund_claim_letter_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }

                // Validate ic_copy (OPTIONAL) - MULTIPLE FILES
                const icCopyFile = $('#ic_copy')[0];
                if (icCopyFile && icCopyFile.files.length > 0) {
                    Array.from(icCopyFile.files).forEach((file, index) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('ic_copy', "@lang('app.land_grant_max')");
                            $('#ic_copy_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('ic_copy', "@lang('app.land_grant_mimes')");
                            $('#ic_copy_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }

                // Validate bank_statement (OPTIONAL) - MULTIPLE FILES
                const bankStatementFile = $('#bank_statement')[0];
                if (bankStatementFile && bankStatementFile.files.length > 0) {
                    Array.from(bankStatementFile.files).forEach((file, index) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('bank_statement', "@lang('app.land_grant_max')");
                            $('#bank_statement_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('bank_statement', "@lang('app.land_grant_mimes')");
                            $('#bank_statement_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }

                // Validate statutory_declaration (OPTIONAL) - MULTIPLE FILES
                const statutoryDeclarationFile = $('#statutory_declaration')[0];
                if (statutoryDeclarationFile && statutoryDeclarationFile.files.length > 0) {
                    Array.from(statutoryDeclarationFile.files).forEach((file, index) => {
                        if (file.size > 15 * 1024 * 1024) {
                            showError('statutory_declaration', "@lang('app.land_grant_max')");
                            $('#statutory_declaration_error').text("@lang('app.land_grant_max')").show();
                        } else if (file.type !== 'application/pdf') {
                            showError('statutory_declaration', "@lang('app.land_grant_mimes')");
                            $('#statutory_declaration_error').text("@lang('app.land_grant_mimes')").show();
                        }
                    });
                }



                if (hasErrors) {
                    // Find the first invalid field
                    const firstError = $('.is-invalid').first();
                    
                    if (firstError.length > 0) {
                        // Scroll to the first error with smooth animation
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100 // 100px offset from top for better visibility
                        }, 500); // 500ms animation duration
                        
                        // Optionally focus on the field if it's an input
                        firstError.focus();
                    }
                    
                    return;
                }

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

                        if (removedLandGrantFiles.length > 0) {
                            formData.append('removed_land_grant', JSON.stringify(removedLandGrantFiles));
                        }

                        $.ajax({
                            url: "{{ route('client_claim_submit') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    Swal.fire({
                                        title: "@lang('app.success')",
                                        text: response.message,
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        $('#registrationForm')[0].reset();
                                        window.location.href = "{{ route('claim.contribution.list') }}";
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
        $(document).ready(function() {
            // Handle removing existing files (same as working application)
            $(document).on('click', '.remove-existing-file', function() {
                const fileItem = $(this).closest('.existing-file-item');
                const fieldName = fileItem.data('field');
                const fileIndex = fileItem.data('index');
                
                console.log('Removing file - Field:', fieldName, 'Index:', fileIndex); // DEBUG
                
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
                        
                        console.log('Updated removed files for', fieldName, ':', removedInput.val()); // DEBUG
                        
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
                        
                        // Show success message
                        Swal.fire({
                            title: 'Berjaya!',
                            text: 'Fail telah berjaya dibuang.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
            
        });
    
        let fileStorage = {};

        function handleMultipleFiles(input, fieldName) {
            const fileListDiv = document.getElementById(fieldName + '_fileList');
            const errorDiv = document.getElementById(fieldName + '_error');
            
            if (!fileStorage[fieldName]) {
                fileStorage[fieldName] = [];
            }
            
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
            
            const newFiles = Array.from(input.files);
            let hasError = false;
            
            newFiles.forEach(file => {
                if (file.size > 15 * 1024 * 1024) {
                    errorDiv.textContent = '@lang('app.land_grant_max')';
                    errorDiv.style.display = 'block';
                    hasError = true;
                    return;
                }
                if (file.type !== 'application/pdf') {
                    errorDiv.textContent = '@lang('app.land_grant_mimes')';
                    errorDiv.style.display = 'block';
                    hasError = true;
                    return;
                }
                
                if (!hasError) {
                    fileStorage[fieldName].push(file);
                }
            });
            
            displayFileList(fieldName, fileStorage[fieldName]);
            updateInputFiles(input, fieldName);
        }

        function displayFileList(fieldName, files) {
            const fileListDiv = document.getElementById(fieldName + '_fileList');
            
            if (!fileListDiv) return;
            
            fileListDiv.innerHTML = '';
            
            if (files.length === 0) {
                return;
            }
            
            const container = document.createElement('div');
            container.style.cssText = 'border: 1px solid #ddd; padding: 10px; border-radius: 5px; background-color: #f9f9f9; margin-top: 10px;';
            
            files.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.style.cssText = 'display: flex; justify-content: space-between; align-items: center; padding: 8px; margin-bottom: 5px; background-color: white; border-radius: 3px; border: 1px solid #e0e0e0;';
                
                const fileInfo = document.createElement('span');
                fileInfo.style.cssText = 'flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #333;';
                fileInfo.innerHTML = `<i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>${file.name} <small style="color: #666;">(${formatFileSize(file.size)})</small>`;
                
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
            
            const summary = document.createElement('div');
            summary.style.cssText = 'margin-top: 8px; font-weight: bold; color: #007bff; font-size: 14px;';
            summary.innerHTML = `<i class="fa fa-check-circle"></i> Jumlah fail dipilih: ${files.length}`;
            container.appendChild(summary);
            
            fileListDiv.appendChild(container);
        }

        function removeFile(fieldName, index) {
            if (fileStorage[fieldName]) {
                fileStorage[fieldName].splice(index, 1);
                
                const input = document.getElementById(fieldName);
                updateInputFiles(input, fieldName);
                
                displayFileList(fieldName, fileStorage[fieldName]);
                
                if (fileStorage[fieldName].length === 0) {
                    const errorDiv = document.getElementById(fieldName + '_error');
                    if (errorDiv) {
                        errorDiv.textContent = '';
                        errorDiv.style.display = 'none';
                    }
                }
            }
        }

        function updateInputFiles(input, fieldName) {
            const dataTransfer = new DataTransfer();
            
            if (fileStorage[fieldName]) {
                fileStorage[fieldName].forEach(file => {
                    dataTransfer.items.add(file);
                });
            }
            
            input.files = dataTransfer.files;
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

            switch (landUnitId) {
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
            const applicantTypeSelect = document.getElementById('account_types'); // Changed from 'applicant_type'
            
            if (applicantTypeSelect) {
                // Store the original account type
                const originalAccountType = '{{ $client->accountType }}';
                
                applicantTypeSelect.addEventListener('change', function() {
                    const selectedType = this.value;
                    
                    // Check if selected type is different from original
                    if (selectedType != originalAccountType) {
                        // Clear personal information fields
                        const fieldsToCheck = [
                            'pemohon', 'ssm', 'alamat', 'poskod', 'bandar', 
                            'negeri', 'daerah', 'emel', 'telefon',
                            'project_name', 'lot-tanah', 'land-unit', 
                            'keluasan', 'hectare-display', 'land_district', 'mukim',
                            'land_grant', 'land_grantfileName', 
                            'permission_plan', 'permission_planfileName',
                            'letter_of_support', 'letter_of_supportfileName'
                        ];
                        
                        fieldsToCheck.forEach(fieldId => {
                            const field = document.getElementById(fieldId);
                            if (field) {
                                if (field.tagName === 'SELECT') {
                                    field.selectedIndex = 0;
                                } else if (field.tagName === 'INPUT' && field.type === 'file') {
                                    field.value = '';
                                } else if (field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') {
                                    field.value = '';
                                } else {
                                    field.textContent = '';
                                }
                            }
                        });
                    } else {
                        // Restore original values if switching back to original account type
                        const restoreField = (id, value) => {
                            const field = document.getElementById(id);
                            if (field && value !== undefined && value !== null) {
                                field.value = value;
                            }
                        };
                        
                        restoreField('pemohon', '{{ $client->userName ?? "" }}');
                        restoreField('ssm', '{{ $client->idCardNumber ?? "" }}');
                        restoreField('alamat', '{{ $client->registeredAddress ?? "" }}');
                        restoreField('poskod', '{{ $client->postalCode ?? "" }}');
                        restoreField('bandar', '{{ $client->city ?? "" }}');
                        restoreField('emel', '{{ $client->email ?? "" }}');
                        restoreField('telefon', '{{ $client->mobileNumber ?? "" }}');
                        
                        // Restore state and district selections
                        @if(isset($client->state_id))
                        restoreField('negeri', '{{ $client->state_id }}');
                        @endif
                        
                        @if(isset($client->district_id))
                        restoreField('daerah', '{{ $client->district_id }}');
                        @endif
                    }
                });
            }
        });
    </script>
@endsection
