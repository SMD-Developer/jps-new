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
        color: #4dbd1aff;
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
                            <h4>@lang('app.claim_contribution')</h4>
                            
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
                                    <input type="hidden" name="is_reapply" value="1">
                                    <input type="hidden" name="original_claim_id" value="{{ $claim->id }}">
                                @endif

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
                                                <label for="pemohon">@lang('app.applicant_individual_company')</label>
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
                                                <label for="ssm">@lang('app.identification_card_no')</label>
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
                                                <label for="alamat">@lang('app.applicant_address')</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea id="alamat" class="form-control" name="address" rows="4" placeholder="Alamat Pemohon">{{ old('address', isset($claim) ? $claim->address : ($client->registeredAddress ?? '')) }}</textarea>
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
                                                    value="{{ old('postal_code', isset($claim) ? $claim->postal_code : ($client->postalCode ?? '')) }}">
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
                                                    placeholder="Bandar" 
                                                    value="{{ old('city', isset($claim) ? $claim->city : ($client->city ?? '')) }}">
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
                                                <label for="daerah">@lang('app.district')</label>
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
                                                <label for="emel">@lang('app.email_address')</label>
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
                            <h4>@lang('app.project_information')</h4>
                            
                            <div class="container">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="project_name">@lang('Nama dan Butiran Projek')</label>
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
                                            <label for="lot-tanah">Lot Tanah/PT</label>
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
                                            <label for="keluasan">@lang('app.land_area')</label>
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
                                            <label for="land_district">@lang('app.district')</label>
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
                                            <label for="mukim">@lang('Mukim')</label>
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
                                <label for="geran-tanah">Resit Bayaran Lama <b class="starr">*</b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->land_grant)
                                    <div class="mb-2 p-2" style="background-color: #f8f9fa; border-radius: 5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> 
                                            Fail Sebelum: 
                                            <a href="{{ url('pdf/' . basename($claim->land_grant)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif
                                <label for="land_grant" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="land_grant" name="land_grant" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="land_grantfileName" class="file-name"></div>
                                <div id="land_grant_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>


                        <!-- New Receipt Upload - Required -->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="new-receipt">@lang('Resit Bayaran Baru') <b class="starr">*</b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->new_receipt)
                                    <div class="mb-2 p-2" style="background-color: #f8f9fa; border-radius: 5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> 
                                            Fail Sebelum: 
                                            <a href="{{ url('pdf/' . basename($claim->new_receipt)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif
                                <label for="new_receipt" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="new_receipt" name="new_receipt" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="new_receiptfileName" class="file-name"></div>
                                <div id="new_receipt_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>

                        <!-- Surat Permohonan Tuntutan Pulang Balik (Required) -->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="refund_claim_letter">Surat Permohonan Tuntutan Pulang Balik <b class="starr"></b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->refund_claim_letter)
                                    <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> Fail Sebelum:
                                            <a href="{{ url('pdf/' . basename($claim->refund_claim_letter)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif

                                <label for="refund_claim_letter" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="refund_claim_letter" name="refund_claim_letter" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="refund_claim_letterfileName" class="file-name"></div>
                                <div id="refund_claim_letter_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="ic_copy">Salinan Kad Pengenalan Pemohon <b class="starr"></b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->ic_copy)
                                    <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> Fail Sebelum:
                                            <a href="{{ url('pdf/' . basename($claim->ic_copy)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif

                                <label for="ic_copy" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="ic_copy" name="ic_copy" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="ic_copyfileName" class="file-name"></div>
                                <div id="ic_copy_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="bank_statement">Penyata Bank Individu/Pemaju <b class="starr"></b></label>
                            </div>
                            <div class="col-md-8">
                                @if(isset($claim) && $claim->bank_statement)
                                    <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> Fail Sebelum:
                                            <a href="{{ url('pdf/' . basename($claim->bank_statement)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif

                                <label for="bank_statement" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="bank_statement" name="bank_statement" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="bank_statementfileName" class="file-name"></div>
                                <div id="bank_statement_error" class="invalid-feedback d-block" style="display:none;"></div>
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
                                    <div class="mb-2 p-2" style="background-color:#f8f9fa; border-radius:5px;">
                                        <small class="text-muted">
                                            <i class="fa fa-file-pdf-o text-danger"></i> Fail Sebelum:
                                            <a href="{{ url('pdf/' . basename($claim->statutory_declaration)) }}" target="_blank" class="text-primary">
                                                <i class="fa fa-eye"></i> Lihat Fail
                                            </a>
                                        </small>
                                    </div>
                                @endif

                                <label for="statutory_declaration" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                <input type="file" id="statutory_declaration" name="statutory_declaration" class="file-input"
                                    accept="application/pdf" onchange="validateFileSize(this)">
                                <div id="statutory_declarationfileName" class="file-name"></div>
                                <div id="statutory_declaration_error" class="invalid-feedback d-block" style="display:none;"></div>
                            </div>
                        </div>


                        <div class="form-group">
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
                        <div class="form-group">
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
                                <label for="claim-reason">@lang('Nyatakan Alasan Tuntutan')</label>
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
                
                // Validate phone
                const phone = $('[name="phone"]').val();
                if (!phone) {
                    showError('phone', "@lang('app.phone_required')");
                } else if (!/^\d+$/.test(phone)) {
                    showError('phone', "@lang('app.phone_numeric')");
                } else if (phone.length < 10 || phone.length > 15) {
                    showError('phone', "@lang('app.phone_digits_between')");
                }

                const paymentAmount = $('[name="payment_amount"]').val();
                if (!paymentAmount) {
                    showError('payment_amount', "@lang('Medan ini wajib diisi')");
                } else if (isNaN(paymentAmount)) {
                    showError('payment_amount', "@lang('app.claim_amount_numeric')");
                } else if (parseFloat(paymentAmount) <= 0) {
                    showError('payment_amount', "@lang('app.claim_amount_positive')");
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
                if (!$('[name="district"]').val()) {
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

                // Validate land_grant file
                const landGrantFile = $('#land_grant')[0].files[0];
                if (!landGrantFile) {
                    showError('land_grant', "@lang('Fail wajib dimuatnaik')");
                    $('#land_grant_error').text("@lang('Fail wajib dimuatnaik')").show();
                } else {
                    // Check file size (15MB = 15360KB)
                    if (landGrantFile.size > 15 * 1024 * 1024) {
                        showError('land_grant', "@lang('app.land_grant_max')");
                        $('#land_grant_error').text("@lang('app.land_grant_max')").show();
                    }
                    // Check file type (PDF only)
                    else if (landGrantFile.type !== 'application/pdf') {
                        showError('land_grant', "@lang('app.land_grant_mimes')");
                        $('#land_grant_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }

                // Validate new_receipt file (REQUIRED)
                const newReceiptFile = $('#new_receipt')[0].files[0];
                if (!newReceiptFile) {
                    showError('new_receipt', "@lang('Fail wajib dimuatnaik')");
                    $('#new_receipt_error').text("@lang('Fail wajib dimuatnaik')").show();
                } else {
                    if (newReceiptFile.size > 15 * 1024 * 1024) {
                        showError('new_receipt', "@lang('app.land_grant_max')");
                        $('#new_receipt_error').text("@lang('app.land_grant_max')").show();
                    } else if (newReceiptFile.type !== 'application/pdf') {
                        showError('new_receipt', "@lang('app.land_grant_mimes')");
                        $('#new_receipt_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }

                // Validate supporting_docs file (OPTIONAL - only validate if file is selected)
                const supportingDocsFile = $('#supporting_docs')[0].files[0];
                if (supportingDocsFile) {
                    if (supportingDocsFile.size > 15 * 1024 * 1024) {
                        showError('supporting_docs', "@lang('app.land_grant_max')");
                        $('#supporting_docs_error').text("@lang('app.land_grant_max')").show();
                    } else if (supportingDocsFile.type !== 'application/pdf') {
                        showError('supporting_docs', "@lang('app.land_grant_mimes')");
                        $('#supporting_docs_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }


                // Validate refund_claim_letter (OPTIONAL)
                const refundClaimLetterFile = $('#refund_claim_letter')[0];
                if (refundClaimLetterFile && refundClaimLetterFile.files[0]) {
                    const file = refundClaimLetterFile.files[0];
                    if (file.size > 15 * 1024 * 1024) {
                        showError('refund_claim_letter', "@lang('app.land_grant_max')");
                        $('#refund_claim_letter_error').text("@lang('app.land_grant_max')").show();
                    } else if (file.type !== 'application/pdf') {
                        showError('refund_claim_letter', "@lang('app.land_grant_mimes')");
                        $('#refund_claim_letter_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }

                // Validate ic_copy (OPTIONAL)
                const icCopyFile = $('#ic_copy')[0];
                if (icCopyFile && icCopyFile.files[0]) {
                    const file = icCopyFile.files[0];
                    if (file.size > 15 * 1024 * 1024) {
                        showError('ic_copy', "@lang('app.land_grant_max')");
                        $('#ic_copy_error').text("@lang('app.land_grant_max')").show();
                    } else if (file.type !== 'application/pdf') {
                        showError('ic_copy', "@lang('app.land_grant_mimes')");
                        $('#ic_copy_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }

                // Validate bank_statement (OPTIONAL)
                const bankStatementFile = $('#bank_statement')[0];
                if (bankStatementFile && bankStatementFile.files[0]) {
                    const file = bankStatementFile.files[0];
                    if (file.size > 15 * 1024 * 1024) {
                        showError('bank_statement', "@lang('app.land_grant_max')");
                        $('#bank_statement_error').text("@lang('app.land_grant_max')").show();
                    } else if (file.type !== 'application/pdf') {
                        showError('bank_statement', "@lang('app.land_grant_mimes')");
                        $('#bank_statement_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }

                // Validate statutory_declaration (OPTIONAL)
                const statutoryDeclarationFile = $('#statutory_declaration')[0];
                if (statutoryDeclarationFile && statutoryDeclarationFile.files[0]) {
                    const file = statutoryDeclarationFile.files[0];
                    if (file.size > 15 * 1024 * 1024) {
                        showError('statutory_declaration', "@lang('app.land_grant_max')");
                        $('#statutory_declaration_error').text("@lang('app.land_grant_max')").show();
                    } else if (file.type !== 'application/pdf') {
                        showError('statutory_declaration', "@lang('app.land_grant_mimes')");
                        $('#statutory_declaration_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }

                // Validate company_registration (OPTIONAL)
                const companyRegistrationFile = $('#company_registration')[0];
                if (companyRegistrationFile && companyRegistrationFile.files[0]) {
                    const file = companyRegistrationFile.files[0];
                    if (file.size > 15 * 1024 * 1024) {
                        showError('company_registration', "@lang('app.land_grant_max')");
                        $('#company_registration_error').text("@lang('app.land_grant_max')").show();
                    } else if (file.type !== 'application/pdf') {
                        showError('company_registration', "@lang('app.land_grant_mimes')");
                        $('#company_registration_error').text("@lang('app.land_grant_mimes')").show();
                    }
                }



                // If validation fails, don't show popup
                if (hasErrors) {
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
       function validateFileSize(input) {
            const file = input.files[0];
            const errorDiv = document.getElementById(input.id + '_error');

            if (file) {
                if (file.size > 15 * 1024 * 1024) { 
                    errorDiv.textContent = "Saiz fail melebihi had 15mb. Sila pilih fail yang lebih kecil.";
                    errorDiv.style.display = 'block';
                    input.value = ''; 
                } else {
                    errorDiv.textContent = '';
                    errorDiv.style.display = 'none';
                }
            } else {
                errorDiv.textContent = '';
                errorDiv.style.display = 'none';
            }
        }

    </script>
    <script>
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : '@lang('app.no_file_chosens')';
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
