@extends('app')
<style>
    /* Flex container for buttons */
    .sbtn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    /* Adjust input and dropdown widths for responsiveness */
    .form-label {
        white-space: nowrap;
        /* Prevent labels from wrapping */
    }

    #lot #district #division {
        max-width: 180px;
        /* Restrict width for smaller inputs */
    }

    /* Responsive layout tweaks */
    @media (max-width: 768px) {
        .search-row>.col-sm-6 {
            margin-bottom: 1rem;
            /* Add spacing on smaller screens */
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
    
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    /* Viewed button styling */
    .btn-viewed {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: white !important;
        position: relative;
    }
    
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        text-transform: capitalize;
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
</style>
<title>{{ trans('app.list_of_application') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('app.list_of_application') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row search-row align-items-center g-2 mt-3">
                            <!-- Search Input -->
                            <div class="col-md-3 col-sm-6 colsm36">
                                <label for="search" class="form-label"> {{ trans('app.search') }}:&nbsp;</label>
                                <input type="text" id="search" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.search') }}">
                            </div>
                            <!-- District Dropdown -->
                            <div class="col-md-3 col-sm-6" id="aside">
                                <label for="district" class="form-label">{{ trans('app.district') }}:</label>&nbsp;&nbsp;
                                <select id="district" class="form-select form-select-sm form-control form-control-sm">
                                    <option value="" selected disabled>{{ trans('app.select_district') }}</option>
                                    @foreach ($district as $value)
                                        <option value="{{ $value->iddaerah }}">{{ $value->daerah_code }} -
                                            {{ $value->daerah }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!-- Mukim Dropdown -->
                            <div class="col-md-3 col-sm-6" id="aside">
                                <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;
                                <select id="division" class="form-select form-select-sm form-control form-control-sm">
                                    <option value="" selected disabled>{{ trans('app.select_division') }}</option>
                                </select>
                            </div>
                            <!-- Lot/PT Input -->
                            <div class="col-md-3 col-sm-6" id="aside">
                                <label for="lot" class="form-label me-2">{{ trans('app.lot_pt') }}
                                    :</label>&nbsp;&nbsp;
                                <input type="text" id="lot" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.enter_lot_pt') }}">
                            </div>
                            <div class="col-md-12 col-sm-12 mt-3 text-right">
                                <a href="#" class="btn btn-primary btn-sm"
                                    style="background:#3c8dbc !important; border:solid 1px #3c8dbc;"><strong>{{ trans('app.search_b') }}</strong></a>
                            </div>
                            <div class="d-flex justify-content-between align-items-baseline mb-3 mx-3">
                            <div class="d-flex align-items-baseline mb-3 mx-1" style="width: auto">
                                <label for="perPageSelect" class="me-2" style="white-space: nowrap;">@lang('app.show') :&nbsp; </label>
                                <select id="perPageSelect" class="form-select form-select-sm" onchange="changePerPage()">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                    <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                                </select>
                            </div>
                             <div class="d-flex align-items-baseline mt-3 mx-3" id="aside">
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
                                        <th><strong>{{ trans('app.applicant_list') }}</strong></th>
                                        <th><strong>{{ trans('app.lot_pt') }}</strong></th>
                                        <th><strong>{{ trans('app.status') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        @php
                                           $isResubmitted = !is_null($item->resubmitted_at);
                                        @endphp
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
                                                {{ $item->landDistrict->daerah ?? '' }},
                                                {{ $item->landDivision->mukim ?? '' }}</td>
                                            <!--<td>-->
                                            <!--    <div class="sbtn">-->
                                            <!--        @if($canApproverViewApplicationDetails)-->
                                            <!--        <a href="{{ route('approvernewApplication', ['id' => $item->id]) }}"-->
                                            <!--         class="btn btn-primary btn-sm view-btn {{ isset($item->is_approver_viewed) && $item->is_approver_viewed ? 'btn-viewed' : '' }}" -->
                                            <!--         data-app-id="{{ $item->id }}"><i class="fa fa-eye mt-1"></i></a>-->
                                            <!--        @endif-->
                                            <!--        @if ($isAdminOrStaff)-->
                                            <!--            <a href="{{ route('updateApplication', ['id' => $item->id]) }}"-->
                                            <!--                class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>-->
                                            <!--        @endif-->
                                            <!--        @if($isResubmitted)-->
                                            <!--            <span class="badge bg-info text-warning " data-bs-toggle="tooltip" title="Resubmitted Application">-->
                                            <!--                <i class="fa-solid fa-rotate btn-sm view-btn" style="font-size: 1rem;"></i>-->
                                            <!--            </span>-->
                                            <!--        @endif-->
                                            <!--        @if($item->status == 'approved')-->
                                            <!--            <span class="badge bg-success text-white " data-bs-toggle="tooltip" title="Approved Application">-->
                                            <!--                <i class="fa-solid fa-check btn-sm view-btn" style="font-size: 1rem;"></i>-->
                                            <!--            </span>-->
                                            <!--        @elseif($item->status == 'rejected')-->
                                            <!--            <span class="badge bg-danger text-white " data-bs-toggle="tooltip" title="Rejected Application">-->
                                            <!--                <i class="fa-solid fa-xmark btn-sm view-btn" style="font-size: 1rem;"></i>-->
                                            <!--            </span>-->
                                            <!--        @endif-->
                                            <!--    </div>-->
                                            <!--</td>-->
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
                                            <td>
                                                <div class="sbtn">
                                                    @if($canApproverViewApplicationDetails)
                                                    <a href="{{ route('approvernewApplication', ['id' => $item->id]) }}"
                                                     class="btn btn-primary btn-sm view-btn {{ isset($item->is_approver_viewed) && $item->is_approver_viewed ? 'btn-viewed' : '' }}" 
                                                     data-app-id="{{ $item->id }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @endif
                                                    
                                                    @if ($isAdminOrStaff)
                                                        <a href="{{ route('updateApplication', ['id' => $item->id]) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    
                                                    @if($isResubmitted)
                                                        <span class="btn btn-info btn-sm" style="cursor: default;" data-bs-toggle="tooltip" title="Resubmitted Application">
                                                            <i class="fa-solid fa-rotate"></i>
                                                        </span>
                                                    @endif
                                                    
                                                    @if($item->status == 'approved')
                                                        <!--<span class="btn btn-success btn-sm" style="cursor: default;" data-bs-toggle="tooltip" title="Approved Application">-->
                                                        <!--    <i class="fa-solid fa-check"></i>-->
                                                        <!--</span>-->
                                                    @elseif($item->status == 'rejected')
                                                        <span class="btn btn-danger btn-sm" style="cursor: default;" data-bs-toggle="tooltip" title="Rejected Application">
                                                            <i class="fa-solid fa-xmark"></i>
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
                                        {{-- First Page --}}
                                        @if ($list->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->url(1) }}&per_page={{ $perPage }}">«
                                                    @lang('app.first')</a>
                                            </li>
                                        @endif

                                        {{-- Previous Page --}}
                                        @if ($list->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ @lang('app.prev')</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->previousPageUrl() }}&per_page={{ $perPage }}">‹
                                                    @lang('app.prev')</a>
                                            </li>
                                        @endif

                                        {{-- Default Pagination Links --}}
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
                                                            href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        {{-- Next Page --}}
                                        @if ($list->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->nextPageUrl() }}&per_page={{ $perPage }}">@lang('app.next')
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">@lang('app.next') ›</span>
                                            </li>
                                        @endif

                                        {{-- Last Page --}}
                                        @if ($list->currentPage() < $list->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->url($list->lastPage()) }}&per_page={{ $perPage }}">@lang('app.last')
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

            // Track view button clicks - Database version (no localStorage)
            $('.view-btn').on('click', function(e) {
                var appId = $(this).data('app-id');
                var button = $(this);
                
                // Only track if it has an app-id (it's a view button)
                if (appId) {
                    // Make AJAX call to track the view
                    $.ajax({
                        url: '/track-approver-application-view', 
                        type: 'POST',
                        data: {
                            application_id: appId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Turn button green immediately
                            button.removeClass('btn-primary').addClass('btn-viewed');
                        },
                        error: function() {
                            console.log('Error tracking application view');
                        }
                    });
                }
                
                // Let the normal click proceed (will navigate to view page)
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                const searchValue = $(this).val().toLowerCase();
                const searchWords = searchValue.split(/\s+/);

                $('table tbody tr').each(function() {
                    const rowText = $(this).text().toLowerCase();
                    const match = searchWords.some(word => rowText.includes(word));

                    if (match) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#lot').on('input', function() {
                const searchValue = $(this).val().toLowerCase();
                const searchWords = searchValue.split(/\s+/); // Split input into words

                // Loop through table rows and filter based on the "lot_pt" column
                $('table tbody tr').each(function() {
                    const lotColumnText = $(this).find('td:nth-child(4)').text()
                        .toLowerCase(); // Get the text of the "lot_pt" column
                    const match = searchWords.some(word => lotColumnText.includes(
                        word)); // Check if any word matches

                    if (match) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
    <script>
        function changePerPage() {
            let perPage = document.getElementById('perPageSelect').value;
            let url = new URL(window.location.href);

            // Reset to Page 1 when changing per_page value
            url.searchParams.set('page', 1);
            url.searchParams.set('per_page', perPage);

            window.location.href = url.toString(); // Reload with new per_page and reset to first page
        }
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@endsection