@extends('third-party.layouts.app')
<style>
    .form-group {
        margin-bottom: 15px;
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
                        <form action="{{ route('third.party.search-results') }}" method="GET" id="searchForm" onsubmit="return validateForm()">
                            <!-- Radio Button Group -->
                            <div class="form-group">
                                <label class="d-block mb-2">Cari Berdasarkan</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="search_type" id="searchByApplicant" 
                                        value="applicant" onchange="toggleSearchFields()" 
                                        {{ old('search_type', $request->search_type ?? '') == 'applicant' ? 'checked' : '' }}>
                                    <label class="form-check-label me-5" for="searchByApplicant">
                                        Nama Pemohon
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="search_type" id="searchByLot" 
                                        value="lot" onchange="toggleSearchFields()"
                                        {{ old('search_type', $request->search_type ?? '') == 'lot' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="searchByLot">
                                       No Lot/PT
                                    </label>
                                </div>
                            </div>

                            <!-- Applicant Input (Hidden by default) -->
                            <div class="form-group" id="applicantSection" style="display: none;">
                                <label>Nama Pemohon</label>
                                <input type="text" class="form-control" name="applicant_name" id="applicant_name" 
                                    placeholder="Masukkan nama pemohon" 
                                    value="{{ old('applicant_name', $request->applicant_name ?? '') }}">
                            </div>

                            <!-- Lot/PT Input (Hidden by default) -->
                            <div class="form-group" id="lotSection" style="display: none;">
                                <label>{{ __('app.lot_pt') }}</label>
                                <input type="text" class="form-control" name="lot_pt_grant" id="lot_pt_grant" 
                                    placeholder="Masukkan no lot/PT" 
                                    value="{{ old('lot_pt_grant', $request->lot_pt_grant ?? '') }}">
                            </div>

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
                                    <option value="">{{ __('Pilih mukim') }}</option>
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

                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fas fa-search"></i> {{ __('Cari') }}
                            </button>
                            <button type="button" class="btn btn-secondary float-right mr-2" onclick="resetSearchForm()">
                                <i class="fas fa-redo"></i> {{ __('app.reset') }}
                            </button>
                        </form>
                    </div>
                    @if($request->hasAny(['lot_pt_grant', 'division', 'district', 'applicant_name']))
                    <div class="card-body mt-4">
                        <h5 class="mb-3">Hasil Carian</h5>
                        
                        <p class="mb-3"><strong>{{ $results->total() }}</strong> Permohonan Dijumpai</p>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-header">
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Pemohon</th>
                                        <th>Lot/PT</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($results->count() > 0)
                                        @foreach ($results as $key => $result)
                                            <tr>
                                                <td>{{ $results->firstItem() + $key }}</td>
                                                <td>{{ $result->applicant ?? 'N/A' }}</td>
                                                <td>{{ $result->land_lot ?? 'N/A' }}, {{ $result->landDivision->mukim ?? 'N/A' }}, DAERAH {{ $result->landDistrict->daerah ?? 'N/A' }}</td>
                                                <td>
                                                    @switch($result->status)
                                                        @case('approved')
                                                            <span class="badge bg-success">Diluluskan</span>
                                                            @break
                                                        @case('rejected')
                                                            <span class="badge bg-danger">Tolak</span>
                                                            @break
                                                        @case('pending')
                                                            <span class="badge bg-warning">Belum selesai</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">N/A</span>
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                Tiada Permohonan Ditemui
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if($results->count() > 0)
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <p class="text-muted mb-0">
                                        Menunjukkan {{ $results->firstItem() }} hingga {{ $results->lastItem() }} daripada {{ $results->total() }} rekod
                                    </p>
                                </div>
                                <div>
                                    {{ $results->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="border-0">
                        <h6 class="mb-3"><strong>Nota:</strong></h6>
                        <ol class="mb-0" style="line-height: 1.8;">
                            <li>Carian resit adalah bagi semakan status bayaran caruman parit.</li>
                            <li>Caj cetakan salinan resit: RM10.00 setiap salinan.</li>
                            <li>Carian boleh dibuat berdasarkan Nama Pemohon atau No. Lot/PT.</li>
                            <li>Masukkan nama pemohon atau No. Lot/PT. Maklumat daerah dan mukim adalah pilihan.</li>
                            <li>Permohonan salinan resit atau bayaran melalui B2B akan diproses dalam tempoh 7–14 hari bekerja.</li>
                        </ol>
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

        function toggleSearchFields() {
            const applicantRadio = document.getElementById('searchByApplicant');
            const lotRadio = document.getElementById('searchByLot');
            const applicantSection = document.getElementById('applicantSection');
            const lotSection = document.getElementById('lotSection');
            
            if (applicantRadio.checked) {
                applicantSection.style.display = 'block';
                lotSection.style.display = 'none';
                // Clear lot input
                document.getElementById('lot_pt_grant').value = '';
                // Focus on applicant input
                document.getElementById('applicant_name').focus();
            } else if (lotRadio.checked) {
                lotSection.style.display = 'block';
                applicantSection.style.display = 'none';

                document.getElementById('applicant_name').value = '';
                document.getElementById('lot_pt_grant').focus();
            }
        }

 
        function resetSearchForm() {
            document.getElementById('searchForm').reset();
            document.getElementById('applicantSection').style.display = 'none';
            document.getElementById('lotSection').style.display = 'none';
            
            document.getElementById('searchByApplicant').checked = false;
            document.getElementById('searchByLot').checked = false;
            
            document.getElementById('district').selectedIndex = 0;
            document.getElementById('division').innerHTML = '<option value="">{{ __('app.select_division') }}</option>';
            
            window.location.href = "{{ route('third.party.search') }}";
        }

        function validateForm() {
            const applicantRadio = document.getElementById('searchByApplicant');
            const lotRadio = document.getElementById('searchByLot');
            const applicantName = document.getElementById('applicant_name').value.trim();
            const lotPtGrant = document.getElementById('lot_pt_grant').value.trim();
            
            // Check if either radio is selected
            if (!applicantRadio.checked && !lotRadio.checked) {
                alert('Sila pilih sama ada Nama Pemohon atau No Lot/PT');
                return false;
            }
            
            // Check if applicant radio is selected but name is empty
            if (applicantRadio.checked && !applicantName) {
                alert('Sila masukkan Nama Pemohon');
                document.getElementById('applicant_name').focus();
                return false;
            }
            
            // Check if lot radio is selected but lot number is empty
            if (lotRadio.checked && !lotPtGrant) {
                alert('Sila masukkan No Lot/PT');
                document.getElementById('lot_pt_grant').focus();
                return false;
            }
            
            return true;
        }
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('searchByApplicant').checked || 
                document.getElementById('searchByLot').checked) {
                toggleSearchFields();
            }
        });
    </script>

@endsection