@extends('app')
<style>
    /* Flex container for buttons */
    .sbtn {
        display: flex;
        justify-content: flex-start;
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

    /*some css need to remove*/

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
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    /* Headings */
    h2,
    h3,
    h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Flex container for buttons */
    /* Flex container for buttons */
    .sbtn {
        display: flex;
        flex-wrap: wrap;
        /* Allow wrapping for smaller screens */
        justify-content: center;
        gap: 0.5rem;
        /* Uniform spacing */
    }

    /* Smaller, compact buttons */
    .sbtn a {
        flex: 0 1 auto;
        /* Prevents buttons from stretching too much */
        max-width: 150px;
        /* Restrict the button width */
        padding: 4px 8px;
        /* Reduce padding for a compact size */
        font-size: 0.75rem;
        /* Smaller font size */
        line-height: 1;
        /* Compact line height */
        background: #E85B6C !important;
        border: 1px solid #E85B6C;
        border-radius: 25px;
    }

    .btn-sm {
        padding: 4px 8px;
        /* Ensure consistency with other small buttons */
        font-size: 0.75rem;
        line-height: 1;
        /* Reduce button height */

    }

    /* Adjust button gap for smaller buttons */
    .sbtn {
        gap: 0.25rem;
        /* Smaller spacing between buttons */
    }


    /* Responsive design */
    @media (max-width: 768px) {
        .sbtn {
            justify-content: center;
            /* Center buttons on smaller screens */
        }

        .sbtn a {
            flex: 1 1 100%;
            /* Stack buttons on smaller screens */
            max-width: none;
        }
    }

    /* Adjust button appearance */
    .btn-sm {
        padding: 6px 10px !important;
        /* Smaller padding for compact design */
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

    /*border-radius: 15px !important;*/


     /* Add extra styling for badges if needed */
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
</style>
<title>{{ trans('app.application_list') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-check" aria-hidden="true"></i> {{ trans('app.application_list') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row search-row align-items-center g-2 mb-5">
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
                                <label for="lot" class="form-label me-2">{{ trans('app.lot_pt') }}
                                    :</label>&nbsp;&nbsp;
                                <input type="text" id="lot" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.enter_lot_pt') }}">
                            </div>


                            <!-- Buttons + Show Per Page (Right Aligned) -->
                            <div class="col-md-12 col-sm-12 mt-3 mb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <!-- Show Per Page (LEFT) -->
                                <div class="d-flex align-items-center">
                                    <label for="perPageSelect" class="me-2 mb-0 fw-semibold" style="white-space: nowrap;">
                                        @lang('app.show'):
                                    </label>
                                    <select id="perPageSelect" name="perPage" class="form-select form-select-sm" style="width:80px;">
                                        <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                        <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500</option>
                                    </select>
                                </div>

                                <!-- Buttons (RIGHT) -->
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary btn-sm search-btn"
                                        style="background:#3c8dbc !important; border:solid 1px #3c8dbc;">
                                        <strong>{{ trans('app.search_b') }}</strong>
                                    </a>
                                    <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">
                                        <strong>{{ trans('app.reset') }}</strong>
                                    </a>
                                </div>
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
                                        <th><strong>{{ trans('app.application_type') }}</strong></th>
                                         <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.status') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applications as $key => $application)
                                        <tr>
                                            <td>{{ $applications->firstItem() + $key }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($application->client)
                                                    @php
                                                        $accountTypes = [
                                                            1 => 'Individu',
                                                            2 => 'Pemaju',
                                                            3 => 'Agensi Kerajaan',
                                                        ];
                                                        
                                                        $clientType = $accountTypes[$application->client->accountType] ?? 'N/A';
                                                        $applicantType = isset($application->applicant_type) ? ($accountTypes[$application->applicant_type] ?? null) : null;
                                                    @endphp
                                                    
                                                    @if($applicantType && $applicantType != $clientType)
                                                        {{ $clientType }}-{{ $applicantType }}
                                                    @else
                                                        {{ $clientType }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @switch($application->application_type)
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
                                            <td>{{ $application->applicant }}</td>
                                            <td>{{ $application->land_lot }}</td>
                                              <td>
                                                @switch($application->status)
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
                                                @if($canFinanceApproverApplicationDetails )
                                                <a href="{{ route('reviewLetter', ['application_id' => $application->id]) }}"
                                                     class="btn btn-primary btn-sm">
                                                      <i class="fa fa-eye"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <p class="text-muted small">
                                        Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} 
                                        of {{ $applications->total() }} results
                                    </p>
                                </div>
                                <div>
                                    {{ $applications->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- End Table Responsive -->
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
                    var queryParams = [];

                    if (status) queryParams.push('status=' + status);

                    // Redirect with status filter
                    window.location.href = window.location.pathname + '?' + queryParams.join('&');
                });

        });
    </script>
    <script>
        $(document).ready(function() {
        // Search button click handler
            $('.search-btn').on('click', function(e) {
                e.preventDefault();
                
                var searchTerm = $('#search').val();
                var district = $('#district').val();
                var division = $('#division').val();
                var lot = $('#lot').val();
                
                var queryParams = [];
                
                if (searchTerm) queryParams.push('search=' + encodeURIComponent(searchTerm));
                if (district) queryParams.push('district=' + district);
                if (division) queryParams.push('division=' + division);
                if (lot) queryParams.push('lot=' + encodeURIComponent(lot));
                
                // Redirect with all filters
                window.location.href = window.location.pathname + '?' + queryParams.join('&');
            });

            // Status filter
            $('#status').on('change', function() {
                var status = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('status', status);
                window.location.href = url.toString();
            });

        

            
        });
</script>
<script>
    document.getElementById('perPageSelect').addEventListener('change', function() {
        const perPage = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', '1'); 
        window.location.href = url.toString();
    });
</script>
@endsection
