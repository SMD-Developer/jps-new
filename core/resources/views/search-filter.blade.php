@extends('app')

<style>
    .form-group {
        margin-bottom: 15px;
    }

    .dropdown-container {
        position: relative;
        width: 100%;
    }

    .dropdown-btn {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        background: #fff;
        text-align: left;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        width: 100%;
        background: #f9f9f9;
        border: 1px solid #ced4da;
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
    }

    /* Add this CSS rule to show dropdown when 'show' class is added */
    .dropdown-content.show {
        display: block;
    }

    .dropdown-search {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        margin-bottom: 5px;
    }

    .dropdown-content a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: black;
        cursor: pointer;
    }

    .dropdown-content a:hover {
        background-color: #e9ecef;
    }

    .dropdown-item {
        padding: 8px;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #e9ecef;
    }

    .table-header {
        background: #f0f0f0;
        font-weight: bold;
        text-align: center;
    }

    .table td,
    .table th {
        vertical-align: middle;
        text-align: center;
    }

    .dropdown-btn * {
        pointer-events: none; 
    }

.dropdown-btn {
    pointer-events: auto; 
}
    
</style>

<title>{{ $title }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> {{ $title }}</h5>
    </div>

    <section class="card p-5 m-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <form action="{{ route('search-filter') }}" method="POST" id="searchForm">
                                @csrf
                                
                                <!-- District Dropdown -->
                                <div class="form-group">
                                    <label>Daerah</label>
                                    <select class="form-control" name="district" id="district" onchange="loadDivisions()">
                                        <option value="">{{ __('app.select_district') }}</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->iddaerah ?? '' }}"
                                                {{ old('district', $request->district ?? '') == ($district->iddaerah ?? '') ? 'selected' : '' }}>
                                                {{ $district->daerah ?? 'Unknown District' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Division Dropdown -->
                                <div class="form-group">
                                    <label>Mukim</label>
                                    <select class="form-control" name="division" id="division">
                                        <option value="">{{ __('app.select_division') }}</option>
                                        @if (old('district', $request->district ?? ''))
                                            @foreach ($divisions->where('daerah_id', old('district', $request->district ?? '')) as $division)
                                                <option value="{{ $division->idmukim ?? '' }}"
                                                    {{ old('division', $request->division ?? '') == ($division->idmukim ?? '') ? 'selected' : '' }}>
                                                    {{ $division->mukim ?? 'Unknown Division' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Applicant Name Input (Simple Text Box) -->
                                <div class="form-group">
                                    <label>Nama Pemohon</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="applicant_name" 
                                           id="applicant_name"
                                           placeholder="{{ __('') }}"
                                           value="{{ old('applicant_name', $request->applicant_name ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('app.date_of_application') }}</label>
                                    <input type="date" 
                                           class="form-control" 
                                           name="application_date" 
                                           id="application_date"
                                           value="{{ old('application_date', $request->application_date ?? '') }}">
                                </div>
                                
                                <!-- Lot/PT Input (Simple Text Box) -->
                                <div class="form-group">
                                    <label>{{ __('app.lot_pt') }}</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="lot_pt_grant" 
                                           id="lot_pt_grant"
                                           placeholder="{{ __('app.enter_lot_pt') }}"
                                           value="{{ old('lot_pt_grant', $request->lot_pt_grant ?? '') }}">
                                </div>

                                <!-- Reference Number Field -->
                                <div class="form-group">
                                    <label>{{ __('app.reference_number') }}</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="reference_number" 
                                           id="reference_number"
                                           value="{{ old('reference_number', $request->reference_number ?? '') }}">
                                </div>

                                <button type="submit" class="btn btn-primary float-right">Cari</button>
                                <button type="button" class="btn btn-secondary float-right mr-2" onclick="resetSearchForm()">{{ __('app.reset') }}</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                             <table class="table table-bordered mt-4" style="font-size: 14px;">
                                <thead class="table-header">
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Pemohon</th>
                                        <th>Lot/PT</th>
                                        <th>Daerah</th>
                                        <th>Mukim</th>
                                        <th>Tarikh Permohonan</th>
                                        <th>{{ __('app.reference_number') }}</th>
                                        <th>Status</th>
                                        <th>Untuk Tindakan</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($results) && $results->count() > 0)
                                        @foreach ($results as $key => $result)
                                            <tr>
                                                <td>{{ $results->firstItem() + $key }}</td>
                                                <td>{{ $result->applicant ?? 'N/A' }}</td>
                                                <td>{{ $result->land_lot ?? 'N/A' }}, {{ $result->division->mukim ?? 'N/A' }}, DAERAH {{ $result->districts->daerah ?? 'N/A' }}</td>
                                                <td>{{ $result->districts->daerah ?? 'N/A' }}</td>
                                                <td>{{ $result->division->mukim ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($result->created_at)->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('apporver_view_letter', $result->id) }}">{{ $result->refference_no }}</a>
                                                </td>
                                                <td>
                                                    @switch($result->status)
                                                        @case('approved')
                                                            Diluluskan
                                                            @break

                                                        @case('rejected')
                                                            Tolak
                                                            @break

                                                        @case('pending')
                                                            Belum selesai
                                                            @break

                                                        @default
                                                            N/A
                                                    @endswitch
                                                </td>

                                                <td>
                                                    @if($result->payment && $result->payment->payment_status === 'completed')
                                                        <a href="{{ route('user_original_receipts', ['application_id' => $result->id, 'payment_uuid' => $result->payment->uuid]) }}" 
                                                            class="btn btn-sm"
                                                            style="
                                                                background-color: #f4a100;
                                                                color: #fff;
                                                                border-radius: 20px;
                                                                padding: 6px 16px;
                                                                font-weight: 600;
                                                                white-space: nowrap;
                                                                font-size: 13px;
                                                                box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                                                                text-decoration: none;
                                                                border: none;
                                                                display: inline-block;
                                                                transition: background-color 0.3s ease;
                                                            "
                                                            onmouseover="this.style.backgroundColor='#d88f00';"
                                                            onmouseout="this.style.backgroundColor='#f4a100';">
                                                            <strong>{{ trans('app.view_receipt') }}</strong>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @if (isset($request) && $request->isMethod('post'))
                                            <tr>
                                                <td colspan="9" class="text-center">{{ __('Tiada Permohonan Ditemui') }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">{{ __('Sila gunakan borang carian di atas') }}</td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if(isset($results) && $results->count() > 0)
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <p class="text-muted mb-0">
                                        Menunjukkan {{ $results->firstItem() }} hingga {{ $results->lastItem() }} daripada {{ $results->total() }} rekod
                                    </p>
                                </div>
                                <div>
                                    {{ $results->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const allDivisions = @json($divisions ?? []);

        function loadDivisions() {
            const districtSelect = document.getElementById('district');
            const divisionSelect = document.getElementById('division');
            const selectedDistrictId = districtSelect.value;

            divisionSelect.innerHTML = '<option value="">{{ __('app.select_division') }}</option>';

            if (selectedDistrictId) {
                const filteredDivisions = allDivisions.filter(division => {
                    return division.daerah_id == selectedDistrictId;
                });

                filteredDivisions.forEach(division => {
                    const option = document.createElement('option');
                    option.value = division.idmukim || '';
                    option.textContent = division.mukim || 'Unknown Division';
                    divisionSelect.appendChild(option);
                });
            }
        }

        function resetSearchForm() {
            document.getElementById("applicant_name").value = "";
            document.getElementById("lot_pt_grant").value = "";
            document.getElementById("application_date").value = "";
            document.getElementById("reference_number").value = "";
            
            const districtField = document.getElementById("district");
            if (districtField) districtField.selectedIndex = 0;

            const divisionField = document.getElementById("division");
            if (divisionField) {
                divisionField.innerHTML = '<option value="">{{ __('app.select_division') }}</option>';
            }

            window.location.href = "{{ route('search-filter') }}";
        }
    </script>
@endsection
