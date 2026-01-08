@extends('third-party.layouts.app')

<style>
    .form-group {
        margin-bottom: 15px;
    }

    .dropdown-btn span {
        pointer-events: none;
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
                            <form action="{{ route('third.party.search-results') }}" method="GET" id="searchForm">
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

                                <!-- Hidden Input to Store Selected Lot/PT -->
                                <input type="hidden" id="lot_pt_grant" name="lot_pt_grant"
                                    value="{{ old('lot_pt_grant') }}">

                                <!-- Applicant Dropdown -->
                                <div class="form-group">
                                    <label>Nama Pemohon</label>
                                    <div class="dropdown-container">
                                        <button type="button" class="dropdown-btn" data-target="applicantDropdown"
                                                onclick="toggleDropdown('applicantDropdown', event)">
                                            <span id="selectedApplicantText">{{ __('app.select_applicant_list') }}</span>
                                            <span>▼</span>
                                        </button>

                                        <div id="applicantDropdown" class="dropdown-content">
                                            <input type="text" class="dropdown-search"
                                                placeholder="{{ __('app.search_applicant') }}" id="applicantSearchInput"
                                                onkeyup="filterApplicants()">

                                            <div id="applicantsList">
                                                @foreach ($applicants as $applicant)
                                                    <a href="#"
                                                        onclick="selectApplicant('{{ $applicant->userName }}', '{{ $applicant->client_id }}')">
                                                        {{ $applicant->userName }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="applicant_id" name="applicant_id"
                                        value="{{ old('applicant_id') }}">
                                    <input type="hidden" id="applicant_name" name="applicant_name" value="{{ old('applicant_name') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('app.date_of_application') }}</label>
                                    <input type="date" class="form-control" name="application_date" id="application_date"
                                        value="{{ old('application_date') }}">
                                </div>

                                <!-- ✅ FIXED: Lot/PT Dropdown -->
                                <div class="form-group">
                                    <label>{{ __('app.lot_pt') }}</label>
                                    <div class="dropdown-container">
                                        <button type="button" class="dropdown-btn" data-target="lotPtDropdown"
                                            onclick="toggleDropdown('lotPtDropdown', event)">
                                            <span id="selectedLotPtText">{{ __('app.select_lot_pt') }}</span>
                                            <span>▼</span>
                                        </button>

                                        <div id="lotPtDropdown" class="dropdown-content">
                                            <input type="text" class="dropdown-search"
                                                placeholder="{{ __('app.search_lot_pt') }}" id="lotPtSearchInput"
                                                onkeyup="filterLotPt()">

                                            <div id="lotPtList">
                                                @foreach ($lotPts ?? [] as $lotPt)
                                                    <a href="#" onclick="selectLotPt('{{ $lotPt->lot_number }}')">
                                                        {{ $lotPt->lot_number }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reference Number Field -->
                                <div class="form-group">
                                    <label>{{ __('app.reference_number') }}</label>
                                    <input type="text" class="form-control" name="reference_number" id="reference_number"
                                         value="{{ old('reference_number') }}">
                                </div>

                                <button type="submit" class="btn btn-primary float-right">{{ __('Cari') }}</button>
                                <button type="button" class="btn btn-secondary float-right mr-2" onclick="resetSearchForm()">{{ __('app.reset') }}</button>
                            </form>
                        </div>
                        {{-- ✅ Show results table only if search was performed --}}
                        @if($request->hasAny(['lot_pt_grant', 'division', 'district', 'applicant_id', 'reference_number', 'application_date']))
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
                                            <th>Tarikh Permohonan</th>
                                            <th>{{ __('app.reference_number') }}</th>
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
                                                    <td>{{ \Carbon\Carbon::parse($result->created_at)->format('d/m/Y') }}</td>
                                                    <td>
                                                        <a href="#">{{ $result->refference_no }}</a>
                                                    </td>
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
                                                <td colspan="6" class="text-center text-muted py-4">
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
    </section>

    <script>
        const allDivisions = @json($divisions ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            const applicantLinks = document.querySelectorAll('#applicantsList a');
            applicantLinks.forEach(link => {
                const userName = link.textContent.trim();
                const clientId = link.getAttribute('onclick').match(/selectApplicant\('([^']+)',\s*'?(\d+)'?/);
                if (clientId && clientId.length >= 3) {
                    link.setAttribute('data-name', clientId[1]);
                    link.setAttribute('data-id', clientId[2]);
                }
            });

            // ✅ FIXED: Simplified lot_pt links
            const lotPtLinks = document.querySelectorAll('#lotPtList a');
            lotPtLinks.forEach(link => {
                const lotName = link.textContent.trim();
                link.setAttribute('data-name', lotName);
            });
        });

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

        function toggleDropdown(dropdownId, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                if (dropdowns[i].id !== dropdownId) {
                    dropdowns[i].classList.remove("show");
                }
            }

            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle("show");
            }
        }

        function filterApplicants() {
            const input = document.getElementById("applicantSearchInput");
            if (!input) return;

            const filter = input.value.toUpperCase();
            const links = document.querySelectorAll("#applicantsList a");

            links.forEach(link => {
                const txtValue = link.textContent || link.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    link.style.display = "";
                } else {
                    link.style.display = "none";
                }
            });
        }

        function filterLotPt() {
            const input = document.getElementById("lotPtSearchInput");
            if (!input) return;

            const filter = input.value.toUpperCase();
            const links = document.querySelectorAll("#lotPtList a");

            links.forEach(link => {
                const txtValue = link.textContent || link.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    link.style.display = "";
                } else {
                    link.style.display = "none";
                }
            });
        }

        function selectApplicant(name, id) {
            const textElement = document.getElementById("selectedApplicantText");
            const idField = document.getElementById("applicant_id");
            const nameField = document.getElementById("applicant_name");
            const dropdown = document.getElementById("applicantDropdown");

            if (textElement) textElement.innerText = name;
            if (idField) idField.value = id;
            if (nameField) nameField.value = name;
            if (dropdown) dropdown.classList.remove("show");
        }

        // ✅ FIXED: Simplified selectLotPt function
        function selectLotPt(name) {
            const textElement = document.getElementById("selectedLotPtText");
            const idField = document.getElementById("lot_pt_grant");
            const dropdown = document.getElementById("lotPtDropdown");

            if (textElement) textElement.innerText = name;
            if (idField) idField.value = name;
            if (dropdown) dropdown.classList.remove("show");
        }

        function resetSearchForm() {
            const lotPtText = document.getElementById("selectedLotPtText");
            if (lotPtText) lotPtText.innerText = "{{ __('app.select_lot_pt') }}";

            const applicantText = document.getElementById("selectedApplicantText");
            if (applicantText) applicantText.innerText = "{{ __('app.select_applicant_list') }}";

            const lotPtField = document.getElementById("lot_pt_grant");
            if (lotPtField) lotPtField.value = "";

            const applicantIdField = document.getElementById("applicant_id");
            if (applicantIdField) applicantIdField.value = "";

            const applicantNameField = document.getElementById("applicant_name");  
            if (applicantNameField) applicantNameField.value = "";

            const dateField = document.getElementById("application_date");
            if (dateField) dateField.value = "";

            const refField = document.getElementById("reference_number");
            if (refField) refField.value = "";

            const districtField = document.getElementById("district");
            if (districtField) districtField.selectedIndex = 0;

            const divisionField = document.getElementById("division");
            if (divisionField) {
                divisionField.innerHTML = '<option value="">{{ __('app.select_division') }}</option>';
            }

            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.remove('show');
            }

            window.location.href = "{{ route('third.party.search') }}";
        }

        document.addEventListener('click', function(event) {
            if (!event.target.matches('.dropdown-btn') &&
                !event.target.matches('.dropdown-content') &&
                !event.target.closest('.dropdown-content')) {

                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    if (dropdowns[i].classList.contains('show')) {
                        dropdowns[i].classList.remove('show');
                    }
                }
            }
        });
    </script>
@endsection