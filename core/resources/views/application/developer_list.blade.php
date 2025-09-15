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

    .pagination {
        font-size: 14px;
        position: relative;
        z-index: 1;
        /* Reduce font size */
    }

    .pagination li {
        display: inline-block;
        margin: 0 2px;
        /* Reduce spacing */
    }

    .pagination a,
    .pagination span {
        padding: 5px 10px;
        /* Reduce button size */
        font-size: 12px;
        /* Reduce text size */
    }
    
    .unblock-btn {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem !important;
        border-radius: 10px;
    }
    
    .unblock-btn .fa {
        font-size: 0.75rem !important;
    }
</style>
<title>{{ trans('app.applicant_list') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-user" aria-hidden="true"></i> {{ trans('app.applicant_list') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row search-row align-items-center g-2 mt-5">
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
                        <!--    </div>-->
                        <!--</div>-->

                        <!-- Table Section -->
                        <!--<div class="card">-->
                        <!--<div class="card-body">-->
                        <!-- Table Wrapper for Responsiveness -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.address') }}</strong></th>
                                         @if($isAdminOrStaff)
                                        <th><strong>status</strong></th>
                                        @endif
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client_register as $value)
                                        <tr>
                                            <td>{{ ($client_register->currentPage() - 1) * $client_register->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
                                            <td>{{ $value->account_type_name }}</td>
                                            <td>{{ $value->userName }}</td>
                                            <td>{{ $value->registeredAddress }}</td>
                                            @if($isAdminOrStaff)
                                            <td id="status-cell-{{ $value->client_id }}">
                                                @if ($value->is_blocked)
                                                    <span class="badge bg-danger">Blocked</span>
                                                    <button class="btn btn-sm btn-success unblock-btn mt-2"
                                                        data-client-id="{{ $value->client_id }}">
                                                        <i class="fa fa-unlock"></i> Unblock
                                                    </button>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            @endif
                                            <td>
                                                <div class="sbtn">
                                                    @if ($canAdminStaffViewCustomerDetails)
                                                        <a href="{{ route('user_details', ['id' => $value->id]) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                    @endif
                                                    @if ($canAdminStaffEditCustomerDetails)
                                                        <a href="{{ route('user_details_update', ['id' => $value->id]) }}"
                                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        @lang('app.page') <strong>{{ $client_register->currentPage() }}</strong>
                                        @lang('app.of') <strong>{{ $client_register->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        {{-- First Page --}}
                                        @if ($client_register->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $client_register->url(1) }}&per_page={{ $perPage }}"
                                                   title="@lang('app.first')">
                                                    <i class="fas fa-angle-double-left"></i>
                                                    <span class="sr-only">@lang('app.first')</span>
                                                </a>
                                            </li>
                                        @endif
                                
                                        {{-- Previous Page --}}
                                        @if ($client_register->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link" title="@lang('app.prev')">
                                                    <i class="fas fa-angle-left"></i>
                                                    <span class="sr-only">@lang('app.prev')</span>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $client_register->previousPageUrl() }}&per_page={{ $perPage }}"
                                                   title="@lang('app.prev')">
                                                    <i class="fas fa-angle-left"></i>
                                                    <span class="sr-only">@lang('app.prev')</span>
                                                </a>
                                            </li>
                                        @endif
                                
                                        {{-- Page Numbers --}}
                                        @foreach ($client_register->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled">
                                                    <span class="page-link">{{ $element }}</span>
                                                </li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li class="page-item {{ $page == $client_register->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link" href="{{ $url }}&per_page={{ $perPage }}">
                                                            {{ $page }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach
                                
                                        {{-- Next Page --}}
                                        @if ($client_register->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $client_register->nextPageUrl() }}&per_page={{ $perPage }}"
                                                   title="@lang('app.next')">
                                                    <i class="fas fa-angle-right"></i>
                                                    <span class="sr-only">@lang('app.next')</span>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link" title="@lang('app.next')">
                                                    <i class="fas fa-angle-right"></i>
                                                    <span class="sr-only">@lang('app.next')</span>
                                                </span>
                                            </li>
                                        @endif
                                
                                        {{-- Last Page --}}
                                        @if ($client_register->currentPage() < $client_register->lastPage())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $client_register->url($client_register->lastPage()) }}&per_page={{ $perPage }}"
                                                   title="@lang('app.last')">
                                                    <i class="fas fa-angle-double-right"></i>
                                                    <span class="sr-only">@lang('app.last')</span>
                                                </a>
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
    <script>
        $(document).ready(function() {
            $('.unblock-btn').on('click', function() {
                var clientId = $(this).data('client-id');
                var button = $(this);
                var statusCell = $('#status-cell-' + clientId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to unblock this account?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, unblock it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading indicator
                        Swal.fire({
                            title: 'Processing',
                            html: 'Please wait...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });

                        $.ajax({
                            url: "{{ route('toggle_user_block_status', ['id' => ':id']) }}"
                                .replace(':id', clientId),
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.close();
                                if (response.success) {
                                    statusCell.html(
                                        '<span class="badge bg-success">Active</span>'
                                        );

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while processing your request.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
