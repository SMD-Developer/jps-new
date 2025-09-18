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
                        <div class="card-header">{{ $title }}</div>

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

                                <!-- Hidden Input to Store Selected Lot/PT -->
                                <input type="hidden" id="lot_pt_grant" name="lot_pt_grant"
                                    value="{{ old('lot_pt_grant') }}">

                                <!-- Applicant Dropdown -->
                                <div class="form-group">
                                    <label>Nama Pemohon</label>
                                    <div class="dropdown-container">
                                        <button type="button" class="dropdown-btn" data-target="applicantDropdown"
                                            onclick="toggleDropdown('applicantDropdown')">
                                            <span id="selectedApplicantText">{{ __('app.select_applicant_list') }}</span>
                                            <span>▼</span>
                                        </button>

                                        <div id="applicantDropdown" class="dropdown-content">
                                            <!-- Search Input -->
                                            <input type="text" class="dropdown-search"
                                                placeholder="{{ __('app.search_applicant') }}" id="applicantSearchInput"
                                                onkeyup="filterApplicants()">

                                            <!-- List of Applicants -->
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
                                    <!-- Hidden Input to Store Selected Applicant -->
                                    <input type="hidden" id="applicant_id" name="applicant_id"
                                        value="{{ old('applicant_id') }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('app.date_of_application') }}</label>
                                    <input type="date" class="form-control" name="application_date" id="application_date"
                                        value="{{ old('application_date') }}">
                                </div>

                                <!-- Lot/PT Dropdown -->
                                <div class="form-group">
                                    <label>{{ __('app.lot_pt') }}</label>
                                    <div class="dropdown-container">
                                        <!-- Button to open dropdown -->
                                        <button type="button" class="dropdown-btn" data-target="lotPtDropdown"
                                            onclick="toggleDropdown('lotPtDropdown')">
                                            <span id="selectedLotPtText">{{ __('app.select_lot_pt') }}</span>
                                            <span>▼</span>
                                        </button>

                                        <!-- Lot/PT Dropdown -->
                                        <div id="lotPtDropdown" class="dropdown-content">
                                            <!-- Search Input -->
                                            <input type="text" class="dropdown-search"
                                                placeholder="{{ __('app.search_lot_pt') }}" id="lotPtSearchInput"
                                                onkeyup="filterLotPt()">

                                            <!-- List of Lot/PT options -->
                                            <div id="lotPtList">
                                                @foreach ($lotPts ?? [] as $lotPt)
                                                    <a href="#"
                                                        onclick="selectLotPt('{{ $lotPt->lot_number ?? $lotPt->name }}', '{{ $lotPt->id }}')">
                                                        {{ $lotPt->lot_number ?? $lotPt->name }}
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

                                <button type="submit" class="btn btn-primary float-right">{{ __('app.search') }}</button>
                            </form>
                        </div>

                        <table class="table table-bordered mt-4">
                            <thead class="table-header">
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Pemohon</th>
                                    <th>{{ __('app.land_lot') }}</th>
                                    <th>Daerah</th>
                                    <th>Mukim</th>
                                    <th>{{ __('app.date') }}</th>
                                    <th>{{ __('app.reference_number') }}</th>
                                    <th>status</th>
                                    {{-- <th>{{ __('app.actions') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($results) && count($results) > 0)
                                    @foreach ($results as $key => $result)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $result->applicant ?? 'N/A' }}</td>
                                            <td>{{ $result->land_lot ?? 'N/A' }}</td>
                                            <td>{{ $result->district->daerah ?? 'N/A' }}</td>
                                            <td>{{ $result->division->mukim ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($result->created_at)->format('d/m/Y') }}</td>
                                            <td>{{ $result->refference_no ?? 'N/A' }}</td>
                                            <td>{{ $result->status ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    @if (isset($request) && $request->isMethod('post'))
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('app.no_results_found') }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <!--<td colspan="7" class="text-center">{{ __('app.use_form_to_search') }}</td>-->
                                        </tr>
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        // Store all divisions data for client-side filtering
        const allDivisions = @json($divisions ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            const applicantLinks = document.querySelectorAll('#applicantsList a');
            applicantLinks.forEach(link => {
                const userName = link.textContent.trim();
                const clientId = link.getAttribute('onclick').match(/selectApplicant\('([^']+)',\s*(\d+)/);
                if (clientId && clientId.length >= 3) {
                    link.setAttribute('data-name', clientId[1]);
                    link.setAttribute('data-id', clientId[2]);
                }
            });

            // Same for lot_pt links if they exist
            const lotPtLinks = document.querySelectorAll('#lotPtList a');
            lotPtLinks.forEach(link => {
                const lotName = link.textContent.trim();
                const lotId = link.getAttribute('onclick').match(/selectLotPt\('([^']+)',\s*'([^']+)'/);
                if (lotId && lotId.length >= 3) {
                    link.setAttribute('data-name', lotId[1]);
                    link.setAttribute('data-id', lotId[2]);
                }
            });

            // Add form submission handler to reset form after search
            const searchForm = document.getElementById('searchForm');
            if (searchForm) {
                searchForm.addEventListener('submit', function() {
                    // Store the form submission action - will reset after results are shown
                    localStorage.setItem('formSubmitted', 'true');
                });
            }

            // Check if form was just submitted and results are now showing
            if (localStorage.getItem('formSubmitted') === 'true') {
                // Reset all form fields
                resetSearchForm();
                // Clear the flag
                localStorage.removeItem('formSubmitted');
            }
        });

        function loadDivisions() {
            const districtSelect = document.getElementById('district');
            const divisionSelect = document.getElementById('division');
            const selectedDistrictId = districtSelect.value;

            // Clear current division options
            divisionSelect.innerHTML = '<option value="">{{ __('app.select_division') }}</option>';

            if (selectedDistrictId) {
                // Filter divisions based on selected district
                const filteredDivisions = allDivisions.filter(division => {
                    return division.daerah_id == selectedDistrictId;
                });

                // Add filtered divisions to the division dropdown
                filteredDivisions.forEach(division => {
                    const option = document.createElement('option');
                    option.value = division.idmukim || '';
                    option.textContent = division.mukim || 'Unknown Division';
                    divisionSelect.appendChild(option);
                });
            }
        }

        function resetSearchForm() {
            // Reset dropdown text displays
            const lotPtText = document.getElementById("selectedLotPtText");
            if (lotPtText) lotPtText.innerText = lotPtText.getAttribute('data-default') || document.querySelector(
                'label[for="selectedLotPtText"]')?.innerText || "Select Lot/PT";

            const applicantText = document.getElementById("selectedApplicantText");
            if (applicantText) applicantText.innerText = applicantText.getAttribute('data-default') || document
                .querySelector('label[for="selectedApplicantText"]')?.innerText || "Select Applicant";

            // Reset hidden fields
            const lotPtField = document.getElementById("lot_pt_grant");
            if (lotPtField) lotPtField.value = "";

            const applicantIdField = document.getElementById("applicant_id");
            if (applicantIdField) applicantIdField.value = "";

            // Reset date and text inputs
            const dateField = document.getElementById("application_date");
            if (dateField) dateField.value = "";

            const refField = document.getElementById("reference_number");
            if (refField) refField.value = "";

            // Reset district dropdown
            const districtField = document.getElementById("district");
            if (districtField) districtField.selectedIndex = 0;

            // Reset division dropdown
            const divisionField = document.getElementById("division");
            if (divisionField) {
                divisionField.innerHTML = '<option value="">{{ __('app.select_division') }}</option>';
            }
        }

        function toggleDropdown(dropdownId) {
            const dropdowns = document.getElementsByClassName("dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                if (dropdowns[i].id !== dropdownId) {
                    dropdowns[i].classList.remove("show");
                }
            }

            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle("show");
            } else {
                console.error("Dropdown element not found:", dropdownId);
            }
        }

        function filterDropdown(dropdownId) {
            const input = document.querySelector(`#${dropdownId} .dropdown-search`);
            if (!input) return;

            const filter = input.value.toUpperCase();
            const links = document.querySelectorAll(`#${dropdownId} a`);

            links.forEach(link => {
                const txtValue = link.textContent || link.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    link.style.display = "";
                } else {
                    link.style.display = "none";
                }
            });
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
            const dropdown = document.getElementById("applicantDropdown");

            if (textElement) textElement.innerText = name;
            if (idField) idField.value = id;
            if (dropdown) dropdown.classList.remove("show");
        }

        function selectLotPt(name, id) {
            const textElement = document.getElementById("selectedLotPtText");
            const idField = document.getElementById("lot_pt_grant");
            const dropdown = document.getElementById("lotPtDropdown");

            if (textElement) textElement.innerText = name;
            if (idField) idField.value = name;
            if (dropdown) dropdown.classList.remove("show");
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
