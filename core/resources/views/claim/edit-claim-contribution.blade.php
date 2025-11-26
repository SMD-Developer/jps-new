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
        margin-right: 78px;
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


    .file-input {
        border: 1px solid #ccc;
        padding: 8px;
        border-radius: 6px;
        width: 100%;
        cursor: pointer;
    }

    .upload-button {
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        margin-top: 5px;
        display: inline-block;
        cursor: pointer;
    }

    .offset-area {
        margin-top: 5px;
    }

    .offset-area small a {
        color: #0d6efd;
        text-decoration: none;
    }

    .offset-area small a:hover {
        text-decoration: underline;
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
                        <h5 class="mb-4">@lang('Permohonan Pulang Balik (Refund)')</h5>
                        <form class="form" method="POST" 
                            action="{{ route('claims.send_to_finance', ['id' => $claim->id]) }}" 
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
                                            <textarea id="project_name" name="project_name"  class="form-control" rows="4" placeholder="Nama Projek">{{ $claim->project_name ?? '' }}</textarea>
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

                    <h4>@lang('Muat Naik Dokumen Sokongan')</h4>
                    <!-- Resit Bayaran Lama (Old Receipt) -->
                    <div class="form-group">
                        <label for="geran-tanah">@lang('Resit Bayaran Asal')<b class="starr">*</b></label>
                        <div class="offset-area mt-1">
                            @if ($claim->land_grant && is_array($claim->land_grant) && count($claim->land_grant) > 0)
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    @foreach ($claim->land_grant as $index => $filePath)
                                        <div style="display: flex; align-items: center; padding: 8px; background-color: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                            <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>
                                            <a href="{{ url('pdf/' . basename($filePath)) }}" target="_blank" style="flex: 1; color: #007bff; text-decoration: none;">
                                                {{ basename($filePath) }}
                                            </a>
                                            <span style="color: #666; font-size: 12px; margin-left: 8px;">
                                                ({{ number_format(file_exists(public_path('pdf/' . basename($filePath))) ? filesize(public_path('pdf/' . basename($filePath))) / 1024 / 1024 : 0, 2) }} MB)
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                                <small style="color: #007bff; margin-top: 8px; display: block;">
                                    <i class="fa fa-info-circle"></i> Jumlah fail: {{ count($claim->land_grant) }}
                                </small>
                            @else
                                <small class="text-muted">No file uploaded</small>
                            @endif
                        </div>
                    </div>

                    <!-- Resit Bayaran Baru (New Receipt) -->
                    <div class="form-group">
                        <label for="new_receipt">@lang('Resit Bayaran Baru') <b class="starr"></b></label>
                        <div class="offset-area">
                            @if ($claim->new_receipt)
                                @php
                                    $newReceiptFiles = is_array($claim->new_receipt) ? $claim->new_receipt : json_decode($claim->new_receipt, true);
                                @endphp
                                
                                @if (is_array($newReceiptFiles) && count($newReceiptFiles) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        @foreach ($newReceiptFiles as $index => $filePath)
                                            <div style="display: flex; align-items: center; padding: 8px; background-color: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                                <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>
                                                <a href="{{ url('pdf/' . basename($filePath)) }}" target="_blank" style="flex: 1; color: #007bff; text-decoration: none;">
                                                    {{ basename($filePath) }}
                                                </a>
                                                <span style="color: #666; font-size: 12px; margin-left: 8px;">
                                                    ({{ number_format(file_exists(public_path('pdf/' . basename($filePath))) ? filesize(public_path('pdf/' . basename($filePath))) / 1024 / 1024 : 0, 2) }} MB)
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small style="color: #007bff; margin-top: 8px; display: block;">
                                        <i class="fa fa-info-circle"></i> Jumlah fail: {{ count($newReceiptFiles) }}
                                    </small>
                                @else
                                    <small class="text-muted">No file uploaded</small>
                                @endif
                            @else
                                <small class="text-muted">No file uploaded</small>
                            @endif
                            @error('new_receipt')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Surat Permohonan Tuntutan Pulang Balik (Refund Claim Letter) -->
                    <div class="form-group">
                        <label for="refund_claim_letter">@lang('Surat Permohonan Tuntutan Pulang Balik') <b class="starr"></b></label>
                        <div class="offset-area">
                            @if ($claim->refund_claim_letter)
                                @php
                                    $refundClaimFiles = is_array($claim->refund_claim_letter) ? $claim->refund_claim_letter : json_decode($claim->refund_claim_letter, true);
                                @endphp
                                
                                @if (is_array($refundClaimFiles) && count($refundClaimFiles) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        @foreach ($refundClaimFiles as $index => $filePath)
                                            <div style="display: flex; align-items: center; padding: 8px; background-color: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                                <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>
                                                <a href="{{ url('pdf/' . basename($filePath)) }}" target="_blank" style="flex: 1; color: #007bff; text-decoration: none;">
                                                    {{ basename($filePath) }}
                                                </a>
                                                <span style="color: #666; font-size: 12px; margin-left: 8px;">
                                                    ({{ number_format(file_exists(public_path('pdf/' . basename($filePath))) ? filesize(public_path('pdf/' . basename($filePath))) / 1024 / 1024 : 0, 2) }} MB)
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small style="color: #007bff; margin-top: 8px; display: block;">
                                        <i class="fa fa-info-circle"></i> Jumlah fail: {{ count($refundClaimFiles) }}
                                    </small>
                                @else
                                    <small class="text-muted">No file uploaded</small>
                                @endif
                            @else
                                <small class="text-muted">No file uploaded</small>
                            @endif
                            @error('refund_claim_letter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Geran/Pelan Kelulusan KM -->
                    <div class="form-group">
                        <label for="ic_copy">@lang('Geran/Pelan Kelulusan KM') <b class="starr"></b></label>
                        <div class="offset-area">
                            @if ($claim->ic_copy)
                                @php
                                    $icCopyFiles = is_array($claim->ic_copy) ? $claim->ic_copy : json_decode($claim->ic_copy, true);
                                @endphp
                                
                                @if (is_array($icCopyFiles) && count($icCopyFiles) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        @foreach ($icCopyFiles as $index => $filePath)
                                            <div style="display: flex; align-items: center; padding: 8px; background-color: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                                <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>
                                                <a href="{{ url('pdf/' . basename($filePath)) }}" target="_blank" style="flex: 1; color: #007bff; text-decoration: none;">
                                                    {{ basename($filePath) }}
                                                </a>
                                                <span style="color: #666; font-size: 12px; margin-left: 8px;">
                                                    ({{ number_format(file_exists(public_path('pdf/' . basename($filePath))) ? filesize(public_path('pdf/' . basename($filePath))) / 1024 / 1024 : 0, 2) }} MB)
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small style="color: #007bff; margin-top: 8px; display: block;">
                                        <i class="fa fa-info-circle"></i> Jumlah fail: {{ count($icCopyFiles) }}
                                    </small>
                                @else
                                    <small class="text-muted">No file uploaded</small>
                                @endif
                            @else
                                <small class="text-muted">No file uploaded</small>
                            @endif
                            @error('ic_copy')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Surat Penetapan Jumlah Bayaran Caruman Parit -->
                    <div class="form-group">
                        <label for="bank_statement">@lang('Surat Penetapan Jumlah Bayaran Caruman Parit') <b class="starr"></b></label>
                        <div class="offset-area">
                            @if ($claim->bank_statement)
                                @php
                                    $bankStatementFiles = is_array($claim->bank_statement) ? $claim->bank_statement : json_decode($claim->bank_statement, true);
                                @endphp
                                
                                @if (is_array($bankStatementFiles) && count($bankStatementFiles) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        @foreach ($bankStatementFiles as $index => $filePath)
                                            <div style="display: flex; align-items: center; padding: 8px; background-color: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                                <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>
                                                <a href="{{ url('pdf/' . basename($filePath)) }}" target="_blank" style="flex: 1; color: #007bff; text-decoration: none;">
                                                    {{ basename($filePath) }}
                                                </a>
                                                <span style="color: #666; font-size: 12px; margin-left: 8px;">
                                                    ({{ number_format(file_exists(public_path('pdf/' . basename($filePath))) ? filesize(public_path('pdf/' . basename($filePath))) / 1024 / 1024 : 0, 2) }} MB)
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small style="color: #007bff; margin-top: 8px; display: block;">
                                        <i class="fa fa-info-circle"></i> Jumlah fail: {{ count($bankStatementFiles) }}
                                    </small>
                                @else
                                    <small class="text-muted">No file uploaded</small>
                                @endif
                            @else
                                <small class="text-muted">No file uploaded</small>
                            @endif
                            @error('bank_statement')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Surat Akuan Sumpah (Statutory Declaration) -->
                    <div class="form-group">
                        <label for="statutory_declaration">@lang('Surat Akuan Sumpah') <b class="starr"></b></label>
                        <div class="offset-area">
                            @if ($claim->statutory_declaration)
                                @php
                                    $statutoryDeclarationFiles = is_array($claim->statutory_declaration) ? $claim->statutory_declaration : json_decode($claim->statutory_declaration, true);
                                @endphp
                                
                                @if (is_array($statutoryDeclarationFiles) && count($statutoryDeclarationFiles) > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        @foreach ($statutoryDeclarationFiles as $index => $filePath)
                                            <div style="display: flex; align-items: center; padding: 8px; background-color: #f9f9f9; border-radius: 4px; border: 1px solid #ddd;">
                                                <i class="fa fa-file-pdf-o" style="color: #d32f2f; margin-right: 8px;"></i>
                                                <a href="{{ url('pdf/' . basename($filePath)) }}" target="_blank" style="flex: 1; color: #007bff; text-decoration: none;">
                                                    {{ basename($filePath) }}
                                                </a>
                                                <span style="color: #666; font-size: 12px; margin-left: 8px;">
                                                    ({{ number_format(file_exists(public_path('pdf/' . basename($filePath))) ? filesize(public_path('pdf/' . basename($filePath))) / 1024 / 1024 : 0, 2) }} MB)
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small style="color: #007bff; margin-top: 8px; display: block;">
                                        <i class="fa fa-info-circle"></i> Jumlah fail: {{ count($statutoryDeclarationFiles) }}
                                    </small>
                                @else
                                    <small class="text-muted">No file uploaded</small>
                                @endif
                            @else
                                <small class="text-muted">No file uploaded</small>
                            @endif
                            @error('statutory_declaration')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="geran-tanah">@lang('Dokumen Sokongan') <b class="starr"></b></label>
                        <div class="offset-area">
                            @if ($claim->supporting_docs)
                                <small class="text-info">Current file:
                                    <a href="{{ url('pdf/' . basename($claim->supporting_docs)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($claim->supporting_docs) }}
                                    </a></small>
                            @endif
                            @error('supporting_docs')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="claim-reason">@lang('Nyatakan Alasan Tuntutan')</label>
                        </div>
                        <div class="col-md-8">
                            <textarea id="claim-reason" name="claim_reason" class="form-control" rows="4" 
                                placeholder="@lang('Nyatakan alasan tuntutan anda')">{{$claim->claim_reason}}</textarea>
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
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                value="{{ old('payment_amount', $claim->payment_amount ?? '') }}">
                            <div id="claim_amount_error" class="invalid-feedback d-block" style="display:none;"></div>
                        </div>
                    </div>

                <p class="note">
                    *@lang('app.file_only_pdf_format_size_not_exceed_15mb')
                </p>

                <!-- Submit Section -->
                <div class="form-actions">
                    <button type="button" class="btn btn-success" onclick="window.history.back()">@lang('Kembali')</button>
                    @if($isAdminStaff)
                        @if($claim->status == 'approve_paid' || $claim->status == 'rejected' || $claim->send_to_finance == 1)
                            <button type="button" class="btn btn-danger" disabled>@lang('app.reject')</button>
                            <button type="button" class="btn btn-info no-print" disabled>
                                Sahkan
                            </button>
                        @else
                            <button type="button" class="btn btn-danger" onclick="rejectClaim({{ $claim->id }})">@lang('app.reject')</button>
                            <button type="button" class="btn btn-info no-print" data-bs-toggle="modal" data-bs-target="#statusModal">
                                Sahkan
                            </button>
                        @endif
                    @endif

                    @if($isFinanceStaff)
                        <button type="button"
                        class="btn btn-success no-print"
                        data-bs-toggle="modal" 
                        data-bs-target="#financeStatusModal"
                        @if($claim->status === 'approve_paid') disabled @endif
                        >
                            <i class="fas fa-edit me-1"></i> @lang('app.kemaskini')
                        </button>
                    @endif

                    <button type="button" class="btn btn-secondary no-print" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> @lang('app.print')
                    </button>
                </div>

                </form>

                <!-- Send to Finance Modal (for Admin Staff) -->
                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statusModalLabel">@lang('app.payment_status')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body">
                                    <p class="mb-3">
                                        <strong>Sila hadir ke </strong> <strong>Kaunter Pembayaran Caruman Parit, Jabatan Pengairan dan Saliran Negeri Selangor, Tingkat 5, Podium Selatan, Bangunan Sultan Salahuddin Abdul Aziz Shah dalam masa <strong>7 hari bekerja</strong> dari tarikh 
                                        <span class="text fw-bold">kelulusan permohonan tuntutan pulang balik</span>
                                        bayaran pada waktu operasi kaunter seperti berikut:
                                    </p>

                                    <div class="ms-3">
                                        <h6 class="fw-bold text-decoration-underline">KAUNTER CARUMAN PARIT</h6>

                                        <p class="mb-1"><strong>Hari Isnin – Khamis:</strong></p>
                                        <ul class="mb-2">
                                            <li>8.30 pagi – 12.30 tengahari</li>
                                            <li>2.30 petang – 3.30 petang</li>
                                        </ul>

                                        <p class="mb-1"><strong>Hari Jumaat:</strong></p>
                                        <ul class="mb-2">
                                            <li>8.30 pagi – 12.00 tengahari</li>
                                            <li>2.45 petang – 3.30 petang</li>
                                        </ul>

                                        <p class="mb-1"><strong>Rehat:</strong></p>
                                        <ul class="mb-3">
                                            <li>12.30 tengahari – 2.30 petang (Isnin – Khamis)</li>
                                            <li>12.00 tengahari – 2.45 petang (Jumaat)</li>
                                        </ul>

                                        <!-- Added section -->
                                        <div class="border-top pt-3">
                                            <h6 class="fw-bold text-decoration-underline text-dark">
                                                Sila bawa bersama dokumen seperti berikut:
                                            </h6>
                                            <ol class="mt-2">
                                                <li>Surat permohonan tuntutan pulang balik</li>
                                                <li>Salinan Kad Pengenalan pemohon</li>
                                                <li>Penyata bank individu / pemaju</li>
                                                <li>Resit bayaran asal / KEW38 asal</li>
                                                <li>Surat Akuan Sumpah / Majistret / Mahkamah / Pesuruhjaya (sekiranya dokumen/ resit asal hilang)</li>
                                                <li>Pendaftaran Syarikat (SSM/ROS/ROC/ROB/JMB) dan salinan Kad Pengenalan (terkini) semua "Board Of Directors"</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('app.close')</button>
                                    <button type="button" class="btn btn-primary" id="sendToFinanceBtn">Hantar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Modal (for Finance Staff) - MOVED OUTSIDE MAIN FORM -->
                    @if($isFinanceStaff)
                    <div class="modal fade" id="financeStatusModal" tabindex="-1" aria-labelledby="financeStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="financeStatusModalLabel">@lang('app.payment_status')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="statusUpdateForm" action="{{ route('updateClaimStatus', $claim->id ?? '') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="modal_status" class="form-label">@lang('app.status')</label>
                                            <select class="form-select" id="modal_status" name="status" required>
                                                <option value="pending" {{ ($claim->status ?? '') == 'pending' ? 'selected' : '' }}>Dalam Proses</option>
                                                <option value="approve_payment_in_process" style="display:none;" {{ ($claim->status ?? '') == 'approve_payment_in_process' ? 'selected' : '' }}>@lang('app.approve_payment_in_process')</option>
                                                <option value="approve_paid" {{ ($claim->status ?? '') == 'approve_paid' ? 'selected' : '' }}>@lang('app.approve_paid')</option>
                                                <option value="rejected" style="display:none;" {{ ($claim->status ?? '') == 'rejected' ? 'selected' : '' }}>@lang('app.rejected')</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Fields for "approve_payment_in_process" Status -->
                                        <div id="processFields" style="display: none;">
                                            <div class="mb-3">
                                                <label for="visit_date" class="form-label">Tarikh Dikemaskini: <span class="text-danger">*</span></label>
                                                <input type="date" 
                                                    class="form-control" 
                                                    id="visit_date" 
                                                    name="visit_date"
                                                    value="{{ $claim->visit_date ?? '' }}">
                                                <small class="text-muted">Tarikh pengguna hadir ke pejabat</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="process_remarks" class="form-label">Catatan:</label>
                                                <textarea 
                                                    class="form-control" 
                                                    id="process_remarks" 
                                                    name="process_remarks"
                                                    rows="3"
                                                    placeholder="Masukkan catatan jika ada dokumen yang kurang atau sebarang maklumat tambahan">{{ old('process_remarks', $claim->process_remarks ?? '') }}</textarea>
                                                <small class="text-muted">Contoh: Dokumen sokongan tidak lengkap</small>
                                            </div>
                                        </div>

                                        <!-- Fields for "approve_paid" Status -->
                                        <div id="paidFields" style="display: none;">
                                            <div class="mb-3">
                                                <label for="modal_payment_amount" class="form-label">Jumlah Bayaran: <span class="text-danger">*</span></label>
                                                <input type="number" 
                                                    class="form-control" 
                                                    id="modal_payment_amount" 
                                                    name="payment_amount" 
                                                    placeholder="Masukkan jumlah bayaran"
                                                    step="0.01"
                                                    min="0"
                                                    value="{{ old('payment_amount', $claim->payment_amount ?? '') }}">
                                                <small class="text-muted">Contoh: 1500.00</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="modal_verification_date" class="form-label">Tarikh Bayaran: <span class="text-danger">*</span></label>
                                                <input type="date" 
                                                    class="form-control" 
                                                    id="modal_verification_date" 
                                                    name="verification_date"
                                                    value="{{ old('verification_date', $claim->verified_date ?? '') }}">
                                                <small class="text-muted">Tarikh bayaran dibuat</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="payment_remarks" class="form-label">Catatan Bayaran:</label>
                                                <textarea 
                                                    class="form-control" 
                                                    id="payment_remarks" 
                                                    name="payment_remarks"
                                                    rows="2"
                                                    placeholder="Catatan tambahan (jika ada)">{{ old('payment_remarks', $claim->payment_remarks ?? '') }}</textarea>
                                            </div>
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
                @endif
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

            $('#sendToFinanceBtn').on('click', function() {
                $('#statusModal').modal('hide');

                Swal.fire({
                    title: "@lang('app.are_you_sure')",
                    text: "Adakah anda pasti untuk menghantar permohonan ini ke Bahagian Kewangan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "@lang('app.yes')",
                    cancelButtonText: "@lang('app.cancel')"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#send_to_finance').val(1);

                        // Show loading
                        Swal.fire({
                            title: 'Menghantar...',
                            text: 'Sila tunggu',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Prepare form data for AJAX
                        let formData = new FormData($('#registrationForm')[0]);

                        $.ajax({
                            url: $('#registrationForm').attr('action'),
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berjaya!',
                                    text: response.message || 'Status berjaya dikemaskini.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = "{{ route('claim.list') }}";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ralat!',
                                    text: xhr.responseJSON?.message || 'Sesuatu kesilapan telah berlaku. Sila cuba lagi.'
                                });
                            }
                        });
                    } else {
                        $('#statusModal').modal('show');
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

        function rejectClaim(claimId) {
            Swal.fire({
                title: 'Tolak Tuntutan',
                text: 'Nyatakan Alasan',
                input: 'textarea',
                inputPlaceholder: '',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Reason is required');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const reason = result.value;

                    Swal.fire({
                        title: 'Processing...',
                        text: 'Sila tunggu sementara kami menolak tuntutan',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ url('update-claim-status') }}/" + claimId,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            reason: reason,
                            status: 'rejected'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Tuntutan Ditolak',
                                text: '',
                            }).then(() => {
                                window.location.href = "{{ route('claim.list') }}";
                            });
                        },
                        error: function(xhr) {
                            // Close the loading alert and show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong while rejecting the claim.'
                            });
                        }
                    });
                }
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            updateConversionMessage();
            convertToHectare();
        });
    </script>
    <script>
        $(document).ready(function() {
            function toggleModalFields() {
            const status = $('#modal_status').val();
    
                // Hide all conditional fields first
                $('#processFields').hide();
                $('#paidFields').hide();
                
                if (status === 'pending' || status === 'approve_payment_in_process') {
                    $('#processFields').slideDown();
                    $('#visit_date').attr('required', 'required');
                } else {
                    $('#visit_date').removeAttr('required');
                }
                
                if (status === 'approve_paid') {
                    $('#paidFields').slideDown();
                    $('#modal_payment_amount').attr('required', 'required');
                    $('#modal_verification_date').attr('required', 'required');
                } else {
                    $('#modal_payment_amount').removeAttr('required');
                    $('#modal_verification_date').removeAttr('required');
                }
            }
            
            $('#financeStatusModal').on('shown.bs.modal', function() {
                toggleModalFields();
            });
            
            // Run when status changes
            $('#modal_status').on('change', function() {
                toggleModalFields();
            });
            
            // Initial call
            toggleModalFields();
            
            // Handle form submission with validation
            $('#statusUpdateForm').submit(function(e) {
                e.preventDefault();
                
                const status = $('#modal_status').val();
                

                if (status === 'approve_payment_in_process') {
                    const visitDate = $('#visit_date').val();
                    if (!visitDate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ralat!',
                            text: 'Sila masukkan tarikh kehadiran',
                            confirmButtonColor: '#d33'
                        });
                        return false;
                    }
                }
                
                if (status === 'approve_paid') {
                    const amount = $('#modal_payment_amount').val();
                    const verificationDate = $('#modal_verification_date').val();
                    
                    if (!amount || !verificationDate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ralat!',
                            text: 'Sila masukkan jumlah bayaran dan tarikh bayaran',
                            confirmButtonColor: '#d33'
                        });
                        return false;
                    }
                }
                
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sila tunggu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#financeStatusModal').modal('hide');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berjaya!',
                            text: response.message || 'Status tuntutan berjaya dikemaskini',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            // Redirect based on status
                            const status = $('#modal_status').val();
                            if (status === 'pending' || status === 'approve_payment_in_process') {
                                window.location.href = "{{ route('claim.list') }}";
                            } else if (status === 'approve_paid') {
                                window.location.href = "{{ route('claim.approved.list') }}";
                            } else {
                                // Default redirect
                                window.location.href = "{{ route('claim.list') }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        $('#financeStatusModal').modal('hide');
                        
                        let errorMessage = 'Gagal mengemaskini status';
                        
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                const errors = xhr.responseJSON.errors;
                                errorMessage = Object.values(errors).flat().join('<br>');
                            }
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Ralat!',
                            html: errorMessage,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });
        });
    </script>

 
@endsection
