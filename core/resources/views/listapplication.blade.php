@extends('app')
<style>
    /* Your existing styles remain the same */
    .sbtn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .form-label {
        white-space: nowrap;
    }

    #lot #district #division {
        max-width: 180px;
    }

    @media (max-width: 768px) {
        .search-row>.col-sm-6 {
            margin-bottom: 1rem;
        }
    }

    #aside {
        display: flex;
        align-items: baseline;
    }

    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    /* Status badge styles */
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-approved {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    /* Activity column styles */
    .activity-info {
        font-size: 11px;
        line-height: 1.2;
    }

    .activity-label {
        font-weight: bold;
        margin-bottom: 2px;
    }

    .activity-user {
        color: #666;
        margin-bottom: 1px;
    }

    .activity-date {
        color: #999;
        font-size: 10px;
    }

    .current-user {
        color: #28a745 !important;
        font-weight: bold;
    }

    /* Enhanced button styles */
    .btn-viewed {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        position: relative;
    }

    .btn-edited {
        background-color: #fd7e14 !important;
        border-color: #fd7e14 !important;
        position: relative;
    }

    .btn-viewed::after {
        content: "✓";
        position: absolute;
        top: -2px;
        right: -2px;
        background: #fff;
        color: #28a745;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .btn-edited::after {
        content: "✎";
        position: absolute;
        top: -2px;
        right: -2px;
        background: #fff;
        color: #fd7e14;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .activity-badge {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
        margin-right: 5px;
    }

    .viewed-badge {
        background-color: #d4edda;
        color: #155724;
    }

    .edited-badge {
        background-color: #fff3cd;
        color: #856404;
    }

    /* Separate status filter styling */
    .status-filter {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .other-filters {
        border-top: 1px solid #dee2e6;
        padding-top: 1rem;
    }
    
    .status-badge {
        text-transform: capitalize;
    }

    /* Added styles to fix search row responsiveness and button alignment */
    .search-row {
        display: flex; /* Use flexbox to control layout */
        flex-wrap: wrap; /* Allow wrapping for smaller screens */
        align-items: center; /* Vertically center align items */
        gap: 1rem; /* Override inline gap:63px with responsive gap */
    }

    .search-row .col-sm-6 {
        flex: 1 1 auto; /* Allow columns to grow and shrink */
        min-width: 150px; /* Minimum width to prevent collapse */
    }

    .search-btn {
        flex: 0 0 auto; /* Prevent button from stretching */
        padding: 0.375rem 0.75rem; /* Match existing button padding */
        min-width: 100px; /* Ensure button has a minimum width */
    }

    /* Responsive adjustments for smaller screens */
    @media (max-width: 768px) {
        .search-row {
            flex-direction: column; /* Stack elements vertically */
            gap: 0.5rem; /* Smaller gap for mobile */
        }

        .search-row .col-sm-6 {
            width: 100%; /* Full width for each filter */
            margin-bottom: 0; /* Remove extra margin */
        }

        #aside {
            flex-direction: column; /* Stack label and input/select vertically */
            align-items: flex-start; /* Align to left */
        }

        #aside label {
            margin-bottom: 0.25rem; /* Space between label and input */
        }

        .search-btn {
            width: 100%; /* Full-width button on mobile */
            max-width: 200px; /* Limit maximum width */
            margin-left: auto; /* Center align on mobile */
            margin-right: auto;
        }
    }

    @media (min-width: 769px) {
        .search-row .col-sm-6 {
            max-width: 200px; /* Limit max width for consistency */
        }

        .search-btn {
            margin-left: auto; /* Push button to the right */
        }
    }
</style>
<title>{{ trans('app.list_of_application') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('app.list_of_application') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">

                        <!--<div class="row search-row align-items-center g-2 mt-3" style="gap:63px;">-->
                            <!-- Search Input -->
                        <!--    <div class="col-md-2 col-sm-6 colsm36">-->
                        <!--        <label for="search" class="form-label"> {{ trans('app.search') }}:&nbsp;</label>-->
                        <!--        <input type="text" id="search" class="form-control form-control-sm"-->
                        <!--            placeholder="{{ trans('app.search') }}">-->
                        <!--    </div>-->

                            <!-- District Dropdown -->
                        <!--    <div class="col-md-2 col-sm-6" id="aside">-->
                        <!--        <label for="district" class="form-label">{{ trans('app.district') }}:</label>&nbsp;&nbsp;-->
                        <!--        <select id="district" class="form-select form-select-sm form-control form-control-sm" style="width:190px;">-->
                        <!--            <option value="" selected disabled>{{ trans('app.select_district') }}</option>-->
                        <!--            @foreach ($district as $value)-->
                        <!--                <option value="{{ $value->iddaerah }}"-->
                        <!--                    {{ request('district') == $value->iddaerah ? 'selected' : '' }}>-->
                        <!--                    {{ $value->daerah_code }} - {{ $value->daerah }}-->
                        <!--                </option>-->
                        <!--            @endforeach-->
                        <!--        </select>-->
                        <!--    </div>-->

                            <!-- Mukim Dropdown -->
                        <!--    <div class="col-md-2 col-sm-6" id="aside">-->
                        <!--        <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;-->
                        <!--        <select id="division" class="form-select form-select-sm form-control form-control-sm" style="width:190px;">-->
                        <!--            <option value="" selected disabled>{{ trans('app.select_division') }}</option>-->
                                    <!-- Divisions are dynamically populated -->
                        <!--        </select>-->
                        <!--    </div>-->

                            <!-- Lot/PT Input -->
                        <!--    <div class="col-md-2 col-sm-6" id="aside">-->
                        <!--        <label for="lot"-->
                        <!--            class="form-label me-2">{{ trans('app.lot_pt') }}:</label>&nbsp;&nbsp;-->
                        <!--        <input type="text" id="lot" class="form-control form-control-sm"-->
                        <!--            placeholder="{{ trans('app.enter_lot_pt') }}" value="{{ request('lot') }}" style="width:190px;">-->
                        <!--    </div>-->

                            <!-- Search Button -->
                        <!--    <div class="col-md-2 col-sm-6 mt-3" style="margin-bottom:9px;">-->
                        <!--        <a href="#" class="btn btn-primary btn-sm search-btn w-100"-->
                        <!--            style="background:#3c8dbc !important; border:solid 1px #3c8dbc;">-->
                        <!--            <strong>{{ trans('app.search_b') }}</strong>-->
                        <!--        </a>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class="row search-row align-items-center gap-4 mt-3 mx-1">
                        <!-- Search Input -->
                        <div class="col-md-2 col-sm-6 colsm36">
                            <label for="search" class="form-label"> {{ trans('app.search') }}:&nbsp;</label>
                            <input type="text" id="search" class="form-control form-control-sm"
                                placeholder="{{ trans('app.search') }}">
                        </div>

                            <!-- District Dropdown -->
                            <div class="col-md-2 col-sm-6" id="aside">
                                <label for="district" class="form-label">{{ trans('app.district') }}:</label>&nbsp;&nbsp;
                                <select id="district" class="form-select form-select-sm form-control form-control-sm" style="width:190px;">
                                    <option value="" selected disabled>{{ trans('app.select_district') }}</option>
                                    @foreach ($district as $value)
                                        <option value="{{ $value->iddaerah }}"
                                            {{ request('district') == $value->iddaerah ? 'selected' : '' }}>
                                            {{ $value->daerah_code }} - {{ $value->daerah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Mukim Dropdown -->
                            <div class="col-md-2 col-sm-6" id="aside">
                                <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;
                                <select id="division" class="form-select form-select-sm form-control form-control-sm" style="width:210px;">
                                    <option value="" selected disabled>{{ trans('app.select_division') }}</option>
                                    <!-- Divisions are dynamically populated -->
                                </select>
                            </div>
                        
                            <!-- Lot/PT Input -->
                            <div class="col-md-2 col-sm-6" id="aside">
                                <label for="lot"
                                    class="form-label me-2">{{ trans('app.lot_pt') }}:</label>&nbsp;&nbsp;
                                <input type="text" id="lot" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.enter_lot_pt') }}" value="{{ request('lot') }}" style="width:190px;">
                            </div>
                        
                            <!-- Search Button - Moved to the right using ms-auto -->
                            <div class="col-md-2 col-sm-6 ms-auto d-flex" style="margin-bottom:9px;">
                                <a href="#" class="btn btn-primary btn-sm search-btn w-50"
                                    style="background:#3c8dbc !important; border:solid 1px #3c8dbc;">
                                    <strong>{{ trans('app.search_b') }}</strong>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-baseline mb-3 mx-3">
                            <div class="d-flex align-items-baseline">
                                <label for="perPageSelect" class="me-2">@lang('app.show') :&nbsp; </label>
                                <select id="perPageSelect" class="form-select form-select-sm" onchange="changePerPage()"
                                    style="width: auto">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                    <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-baseline mt-3" id="aside">
                                <label for="status" class="form-label">{{ trans('app.status') }}:</label>&nbsp;&nbsp;
                                <select id="status" class="form-select form-select-sm form-control form-control-sm"
                                    style="width:150px;">
                                    <option value="">{{ trans('app.all') }}</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        {{ trans('app.approved') }}
                                    </option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        {{ trans('app.rejected') }}
                                    </option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        {{ trans('app.pending') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.application_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.lot_pt') }}</strong></th>
                                        <th><strong>{{ trans('app.status') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->uploade_date)) }}</td>
                                            <td>
                                                {{ $item->client ? ($item->client->accountType == 1 ? 'Individu' : ($item->client->accountType == 2 ? 'Pemaju' : ($item->client->accountType == 3 ? 'Agensi Kerajaan' : 'Unknown'))) : '' }}
                                            </td>
                                            <td>
                                                @switch($item->application_type)
                                                    @case('reapply')
                                                        {{ trans('app.reapply') }}
                                                    @break

                                                    @case('appeal')
                                                        Appeal
                                                    @break

                                                    @default
                                                        {{ trans('app.new') }}
                                                @endswitch
                                            </td>
                                            <td>{{ $item->applicant }}</td>
                                            <td>{{ $item->land_lot }}, {{ $item->land_area }},
                                                {{ $item->landDivision->mukim ?? '' }}, Daerah
                                                {{ $item->landDistrict->daerah ?? '' }}
                                                </td>
                                            <td>
                                                @switch($item->status)
                                                    @case('approved')
                                                        <span
                                                            class="status-badge status-approved">{{ trans('app.approved') }}</span>
                                                    @break

                                                    @case('rejected')
                                                        <span
                                                            class="status-badge status-rejected">{{ trans('app.rejected') }}</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="status-badge status-pending">{{ trans('app.pending') }}</span>
                                                    @break

                                                    @default
                                                        <span class="status-badge status-pending">{{ trans('app.pending') }}</span>
                                                @endswitch
                                            </td>
                                            <!--<td>-->
                                            <!--    <div class="sbtn">-->
                                            <!--        @if ($canAdminStaffViewApplication)-->
                                            <!--            <a href="{{ route('newApplication', ['id' => $item->id]) }}"-->
                                            <!--                class="btn btn-primary btn-sm view-application {{ $item->viewed_by_current_user ? 'btn-viewed' : '' }}"-->
                                            <!--                data-id="{{ $item->id }}">-->
                                            <!--                <i class="fa fa-eye"></i>-->
                                            <!--            </a>-->
                                            <!--        @endif-->

                                            <!--        @if ($canAdminStaffEditApplication)-->
                                            <!--            <a href="{{ route('updateApplication', ['id' => $item->id]) }}"-->
                                            <!--                class="btn btn-warning btn-sm edit-application {{ $item->edited_by_current_user ? 'btn-edited' : '' }}"-->
                                            <!--                data-id="{{ $item->id }}">-->
                                            <!--                <i class="fa fa-edit"></i>-->
                                            <!--            </a>-->
                                            <!--        @endif-->

                                            <!--        @if ($item->status == 'rejected')-->
                                            <!--            <span class="btn btn-danger btn-sm" style="cursor: default;"-->
                                            <!--                title="Application Rejected">-->
                                            <!--                <i class="fa fa-times"></i>-->
                                            <!--            </span>-->
                                            <!--        @endif-->
                                            <!--    </div>-->
                                            <!--</td>-->
                                           <td>
                                                <div class="sbtn">
                                                    @if ($canAdminStaffViewApplication)
                                                        @php
                                                            $hasBeenViewed = DB::table('application_views')
                                                                ->where('application_id', $item->id)
                                                                ->exists();
                                                        @endphp
                                                        <a href="{{ route('newApplication', ['id' => $item->id]) }}"
                                                            class="btn btn-primary btn-sm view-application {{ $hasBeenViewed ? 'btn-viewed' : '' }}"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    @endif
                                            
                                                    @if ($canAdminStaffEditApplication)
                                                        @php
                                                            $hasBeenEdited = DB::table('application_views')
                                                                ->where('application_id', $item->id)
                                                                ->where('action_type', 'edit')
                                                                ->exists();
                                                        @endphp
                                                        <a href="{{ route('updateApplication', ['id' => $item->id]) }}"
                                                            class="btn btn-warning btn-sm edit-application {{ $hasBeenEdited ? 'btn-edited' : '' }}"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                            
                                                    @if ($item->status == 'rejected')
                                                        <span class="btn btn-danger btn-sm" style="cursor: default;"
                                                            title="Application Rejected">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        @lang('app.page') <strong>{{ $list->currentPage() }}</strong> @lang('app.of')
                                        <strong>{{ $list->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        @if ($list->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->url(1) }}&per_page={{ $perPage }}{{ request('status') ? '&status=' . request('status') : '' }}{{ request('district') ? '&district=' . request('district') : '' }}{{ request('division') ? '&division=' . request('division') : '' }}{{ request('lot') ? '&lot=' . request('lot') : '' }}">«
                                                    @lang('app.first')</a>
                                            </li>
                                        @endif

                                        @if ($list->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ @lang('app.prev')</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->previousPageUrl() }}&per_page={{ $perPage }}{{ request('status') ? '&status=' . request('status') : '' }}{{ request('district') ? '&district=' . request('district') : '' }}{{ request('division') ? '&division=' . request('division') : '' }}{{ request('lot') ? '&lot=' . request('lot') : '' }}">‹
                                                    @lang('app.prev')</a>
                                            </li>
                                        @endif

                                        @foreach ($list->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled"><span
                                                        class="page-link">{{ $element }}</span></li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li
                                                        class="page-item {{ $page == $list->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $url }}&per_page={{ $perPage }}{{ request('status') ? '&status=' . request('status') : '' }}{{ request('district') ? '&district=' . request('district') : '' }}{{ request('division') ? '&division=' . request('division') : '' }}{{ request('lot') ? '&lot=' . request('lot') : '' }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($list->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->nextPageUrl() }}&per_page={{ $perPage }}{{ request('status') ? '&status=' . request('status') : '' }}{{ request('district') ? '&district=' . request('district') : '' }}{{ request('division') ? '&division=' . request('division') : '' }}{{ request('lot') ? '&lot=' . request('lot') : '' }}">@lang('app.next')
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">@lang('app.next') ›</span>
                                            </li>
                                        @endif

                                        @if ($list->currentPage() < $list->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->url($list->lastPage()) }}&per_page={{ $perPage }}{{ request('status') ? '&status=' . request('status') : '' }}{{ request('district') ? '&district=' . request('district') : '' }}{{ request('division') ? '&division=' . request('division') : '' }}{{ request('lot') ? '&lot=' . request('lot') : '' }}">@lang('app.last')
                                                    »</a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div> <!-- End Table Responsive -->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {

            // District change handler for loading divisions
            $('#district').on('change', function() {
                const distId = $(this).val();
                $('#division').html('<option value="">Loading...</option>');

                if (distId) {
                    $.ajax({
                        url: `/division/${distId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih</option>';
                            data.forEach(mukin => {
                                options +=
                                    `<option value="${mukin.idmukim}">${ mukin.mukim_code +' - '+mukin.mukim}</option>`;
                            });
                            $('#division').html(options);
                        },
                        error: function() {
                            $('#division').html(
                                '<option value="">Error loading mukin</option>');
                        }
                    });
                } else {
                    $('#division').html('<option value="">Sila Pilih</option>');
                }
            });

            // Auto-filter for status dropdown
            $('#status').on('change', function() {
                var status = $(this).val();
                var per_page = "{{ $perPage }}";
                var queryParams = [];

                if (status) queryParams.push('status=' + status);
                if (per_page) queryParams.push('per_page=' + per_page);

                // Redirect with status filter
                window.location.href = window.location.pathname + '?' + queryParams.join('&');
            });

        });

        // Handle page refresh
        if (performance.navigation.type === 1 && window.location.search) {
            console.log('Query string on refresh:', window.location.search);
            const cleanUrl = window.location.pathname;

            if (window.history && window.history.replaceState) {
                window.history.replaceState({}, document.title, cleanUrl);
            }
            console.log('Reloading with clean URL:', cleanUrl);
            window.location.href = cleanUrl;
        }

        function changePerPage() {
            let perPage = document.getElementById('perPageSelect').value;
            let url = new URL(window.location.href);
            url.searchParams.set('page', 1);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }

        $(document).ready(function() {
            if (performance.navigation.type === 1) {
                setTimeout(function() {
                    // Don't reset status as it should maintain its value
                    if ($('#district').length) {
                        $('#district').val('').prop('selectedIndex', 0);
                    }
                    if ($('#division').length) {
                        $('#division').empty().html(
                            '<option value="" selected disabled>{{ trans('app.select_division') }}</option>'
                        );
                    }
                    if ($('#lot').length) {
                        $('#lot').val('');
                    }
                }, 50);
                return;
            }

            // Handle selected values for search
            var selectedDistrict = "{{ request('district') }}";
            var selectedDivision = "{{ request('division') }}";

            if (selectedDistrict) {
                $('#district').trigger('change');
                var checkExist = setInterval(function() {
                    if ($('#division option').length > 1) {
                        $('#division').val(selectedDivision);
                        clearInterval(checkExist);
                    }
                }, 100);
            }

            // Manual search button for other filters
            $('.btn-primary.search-btn').click(function(e) {
                e.preventDefault();

                var status = $('#status').val(); // Keep current status
                var district = $('#district').val();
                var division = $('#division').val();
                var lot = $('#lot').val();
                var per_page = "{{ $perPage }}";
                var queryParams = [];

                if (status) queryParams.push('status=' + status);
                if (district) queryParams.push('district=' + district);
                if (division) queryParams.push('division=' + division);
                if (lot) queryParams.push('lot=' + encodeURIComponent(lot));
                if (per_page) queryParams.push('per_page=' + per_page);

                window.location.href = window.location.pathname + '?' + queryParams.join('&');
            });

            $('.sbtn a.btn-primary').on('click', function(e) {
                var href = $(this).attr('href');
                if (href) {
                    window.location.href = href;
                }
            });
        });

        // Live search functionality
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });

        // Track application actions
        // $(document).ready(function() {
        //     // Track view clicks
        //     $(document).on('click', '.view-application', function(e) {
        //         const applicationId = $(this).data('id');
        //         trackAction(applicationId, 'view');
        //     });

        //     // Track edit clicks
        //     $(document).on('click', '.edit-application', function(e) {
        //         const applicationId = $(this).data('id');
        //         trackAction(applicationId, 'edit');
        //     });

        //     function trackAction(applicationId, actionType) {
        //         $.ajax({
        //             url: '/track-application-action',
        //             method: 'POST',
        //             data: {
        //                 application_id: applicationId,
        //                 action_type: actionType,
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function() {
        //                 console.log('Action tracked');
        //             },
        //             error: function() {
        //                 console.error('Failed to track action');
        //             }
        //         });
        //     }
        // });
        // Track application actions
    // Track application actions
    $(document).ready(function() {
        // Track view clicks
        $(document).on('click', '.view-application', function(e) {
            const applicationId = $(this).data('id');
            const $button = $(this); // Store reference to the clicked button
            trackAction(applicationId, 'view', $button);
        });
    
        // Track edit clicks
        $(document).on('click', '.edit-application', function(e) {
            const applicationId = $(this).data('id');
            const $button = $(this); // Store reference to the clicked button
            trackAction(applicationId, 'edit', $button);
        });
    
        function trackAction(applicationId, actionType, $button) {
            $.ajax({
                url: '/track-application-action',
                method: 'POST',
                data: {
                    application_id: applicationId,
                    action_type: actionType,
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    if (actionType === 'view') {
                        $button.addClass('btn-viewed');
                    } else if (actionType === 'edit') {
                        $button.addClass('btn-edited');
                    }
                    console.log('Action tracked and UI updated');
                },
                error: function() {
                    console.error('Failed to track action');
                }
            });
        }
    });
    </script>
@endsection
