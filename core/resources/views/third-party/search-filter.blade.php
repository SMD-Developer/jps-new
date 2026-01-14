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

    .select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    color: #495057;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

/* FORCE dropdown to always open BELOW */
.select2-container--default.select2-container--open .select2-dropdown {
    top: 100% !important;
    bottom: auto !important;
}

.select2-dropdown {
    border: 1px solid #ced4da;
    border-top: none;
}

/* Always show dropdown below */
.select2-dropdown--below {
    border-top: 1px solid #ced4da;
    margin-top: -1px;
}

/* Remove above dropdown positioning */
.select2-dropdown--above {
    display: none !important;
}

/* Style the search input box INSIDE dropdown */
.select2-search--dropdown {
    padding: 10px;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.select2-search--dropdown .select2-search__field {
    border: 2px solid #007bff;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 4px;
    width: 100%;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: #0056b3;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

/* Add search icon placeholder */
.select2-search--dropdown .select2-search__field::placeholder {
    color: #6c757d;
    font-style: italic;
}

/* Style the dropdown results */
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #007bff;
    color: white;
}

.select2-results__option {
    padding: 10px 12px;
    cursor: pointer;
}

.select2-results__option:hover {
    background-color: #f8f9fa;
}

/* Dropdown container */
.select2-container--default .select2-results > .select2-results__options {
    max-height: 300px;
    overflow-y: auto;
}

/* Make sure dropdown has enough space */
.select2-container {
    z-index: 1050;
}

.select2-dropdown {
    z-index: 1051;
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
                            
                            <!-- Radio Button Group - FIRST -->
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
                                    <label class="form-check-label " for="searchByLot">
                                       No Lot/PT
                                    </label>
                                </div>
                            </div>

                            <!-- Applicant Dropdown with Search (Hidden by default) -->
                            <div class="form-group" id="applicantSection" style="display: none;">
                                <label>Nama Pemohon</label>
                                <select class="form-control select2-applicant" name="applicant_id" id="applicant_select">
                                    <option value="">{{ __('app.select_applicant_list') }}</option>
                                    @foreach ($applicants as $applicant)
                                        <option value="{{ $applicant->client_id }}" 
                                            {{ old('applicant_id', $request->applicant_id ?? '') == $applicant->client_id ? 'selected' : '' }}>
                                            {{ $applicant->userName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lot/PT Dropdown with Search (Hidden by default) -->
                            <div class="form-group" id="lotSection" style="display: none;">
                                <label>{{ __('app.lot_pt') }}</label>
                                <select class="form-control select2-lot" name="lot_pt_grant" id="lot_select">
                                    <option value="">{{ __('app.select_lot_pt') }}</option>
                                    @foreach ($lotPts ?? [] as $lotPt)
                                        <option value="{{ $lotPt->lot_number }}"
                                            {{ old('lot_pt_grant', $request->lot_pt_grant ?? '') == $lotPt->lot_number ? 'selected' : '' }}>
                                            {{ $lotPt->lot_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- District Dropdown - MOVED BELOW -->
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

                            <!-- Division Dropdown - MOVED BELOW -->
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
                    @if($request->hasAny(['lot_pt_grant', 'division', 'district', 'applicant_id']))
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

    <script>
// Toggle search fields based on radio selection
function toggleSearchFields() {
    const applicantRadio = document.getElementById('searchByApplicant');
    const lotRadio = document.getElementById('searchByLot');
    const applicantSection = document.getElementById('applicantSection');
    const lotSection = document.getElementById('lotSection');
    
    if (applicantRadio.checked) {
        applicantSection.style.display = 'block';
        lotSection.style.display = 'none';
        // Clear lot selection
        $('#lot_select').val('').trigger('change');
    } else if (lotRadio.checked) {
        lotSection.style.display = 'block';
        applicantSection.style.display = 'none';
        // Clear applicant selection
        $('#applicant_select').val('').trigger('change');
    }
}

// Reset form
function resetSearchForm() {
    document.getElementById('searchForm').reset();
    document.getElementById('applicantSection').style.display = 'none';
    document.getElementById('lotSection').style.display = 'none';
    
    // Reset Select2 dropdowns
    $('#applicant_select').val('').trigger('change');
    $('#lot_select').val('').trigger('change');
    
    // Uncheck radio buttons
    document.getElementById('searchByApplicant').checked = false;
    document.getElementById('searchByLot').checked = false;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for Applicant with enhanced search
    $('.select2-applicant').select2({
        placeholder: 'Pilih nama pemohon',
        allowClear: true,
        width: '100%',
        minimumResultsForSearch: 0, // Always show search box
        matcher: function(params, data) {
            // If there are no search terms, return all data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` is the user's search term
            // `data.text` is the text that is displayed for the option
            var searchTerm = params.term.toLowerCase();
            var optionText = data.text.toLowerCase();

            // Check if the option text contains the search term
            if (optionText.indexOf(searchTerm) > -1) {
                return data;
            }

            // Return `null` if the term should not be displayed
            return null;
        },
        language: {
            noResults: function() {
                return "Tiada keputusan ditemui";
            },
            searching: function() {
                return "Mencari...";
            },
            inputTooShort: function() {
                return "Sila masukkan nama untuk mencari";
            }
        }
    });
    
    // Initialize Select2 for Lot with enhanced search
    $('.select2-lot').select2({
        placeholder: 'Pilih lot/PT',
        allowClear: true,
        width: '100%',
        minimumResultsForSearch: 0, // Always show search box
        matcher: function(params, data) {
            // If there are no search terms, return all data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` is the user's search term
            // `data.text` is the text that is displayed for the option
            var searchTerm = params.term.toLowerCase();
            var optionText = data.text.toLowerCase();

            // Check if the option text contains the search term
            if (optionText.indexOf(searchTerm) > -1) {
                return data;
            }

            // Return `null` if the term should not be displayed
            return null;
        },
        language: {
            noResults: function() {
                return "Tiada keputusan ditemui";
            },
            searching: function() {
                return "Mencari...";
            },
            inputTooShort: function() {
                return "Sila masukkan lot/PT untuk mencari";
            }
        }
    });
    
    // Show the appropriate section if form was submitted
    if (document.getElementById('searchByApplicant').checked || 
        document.getElementById('searchByLot').checked) {
        toggleSearchFields();
    }
});
</script>

@endsection