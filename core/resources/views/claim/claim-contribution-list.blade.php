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
        color: white !important;
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
</style>
<title>{{ trans('app.claim_contribution') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('app.claim_contribution') }}</h5>
    </div>
    <section class="content">
        <div class="row">
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
                                        <option value="{{ $value->iddaerah }}"
                                            {{ request('district') == $value->iddaerah ? 'selected' : '' }}>
                                            {{ $value->daerah_code }} - {{ $value->daerah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Mukim Dropdown -->
                            <div class="col-md-3 col-sm-6" id="aside">
                                <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;
                                <select id="division" class="form-select form-select-sm form-control form-control-sm">
                                    <option value="" selected disabled>{{ trans('app.select_division') }}</option>
                                    <!-- Divisions are dynamically populated -->
                                </select>
                            </div>
                            <!-- Lot/PT Input -->
                            <div class="col-md-3 col-sm-6" id="aside">
                                <label for="lot"
                                    class="form-label me-2">{{ trans('app.lot_pt') }}:</label>&nbsp;&nbsp;
                                <input type="text" id="lot" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.enter_lot_pt') }}" value="{{ request('lot') }}">
                            </div>
                            <div class="col-md-12 col-sm-12 mt-3 text-right">
                                <a href="#" class="btn btn-primary btn-sm search-btn"
                                    style="background:#3c8dbc !important; border:solid 1px #3c8dbc;">
                                    <strong>{{ trans('app.search_b') }}</strong>
                                </a>
                            </div>

                            <div class="d-flex align-items-baseline mb-3 mx-3">
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
                                        <th><strong>{{trans('app.status')}}</strong></th>
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
                                                {{ $item->landDistrict->daerah ?? '' }},
                                                {{ $item->landDivision->mukim ?? '' }}
                                            </td>
                                            <td>
                                                @if($item->status)
                                                    @lang('app.'.$item->status)
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($canAdminStaffEditClaimApplication)
                                                <div class="sbtn">
                                                    <a href="{{ route('claimEdit', ['id' => $item->id]) }}" 
                                                       class="btn btn-warning btn-sm edit-btn {{ isset($item->is_viewed) && $item->is_viewed ? 'btn-viewed' : '' }}" 
                                                       data-claim-id="{{ $item->id }}"
                                                       title="{{ trans('app.edit_claim') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                                @else
                                                <div class="sbtn">
                                                    <a href="{{ route('claimEdit', ['id' => $item->id]) }}" 
                                                       class="btn btn-primary btn-sm " 
                                                       data-claim-id="{{ $item->id }}"
                                                       title="{{ trans('app.edit_claim') }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                @endif
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
                                                    href="{{ $list->url(1) }}&per_page={{ $perPage }}">«
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
                                                    href="{{ $list->previousPageUrl() }}&per_page={{ $perPage }}">‹
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
                                                            href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

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

            // Track edit button clicks
            $('.edit-btn').on('click', function(e) {
                var claimId = $(this).data('claim-id');
                var button = $(this);
                
                // Make AJAX call to track the click
                $.ajax({
                    url: '/track-claim-view', // You'll need to create this route
                    type: 'POST',
                    data: {
                        claim_id: claimId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Turn button green immediately
                        button.removeClass('btn-warning').addClass('btn-viewed');
                    },
                    error: function() {
                        console.log('Error tracking claim view');
                    }
                });
                
                // Let the normal click proceed (will navigate to edit page)
            });

        });
    </script>

    <script>
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
                    $('#district').off('change.divisionLoader').on('change.divisionLoader', function() {
                        // Your existing change handler if needed
                    });
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

            $('.btn-primary.search-btn').click(function(e) {
                e.preventDefault();

                var district = $('#district').val();
                var division = $('#division').val();
                var lot = $('#lot').val();
                var per_page = "{{ $perPage }}";
                var queryParams = [];
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
    </script>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection