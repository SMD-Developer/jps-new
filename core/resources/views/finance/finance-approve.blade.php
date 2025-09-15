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

    .status-badge .badge {
        font-size: 0.8rem;
        padding: 8px 15px;
        border-radius: 25px;
        background-color: #1991EE !important;
        color: #fff !important;
    }

    /* Add hover effects */
    .status-badge .badge:hover {
        opacity: 0.9;
        /* Slight transparency */
        cursor: pointer;
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

                        </div>
                        <!-- Table Wrapper for Responsiveness -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <!--<th><strong>{{ trans('app.reference _no') }}</strong></th>-->
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                         <th><strong>{{ trans('app.application_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.status') }}</strong></th>
                                        <!--<th><strong>{{ trans('app.total_contribution') }}</strong></th>-->
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applications as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}</td>
                                            <!--<td>{{ $application->refference_no ?? '-' }}</td>-->
                                            <td>
                                                @if ($application->client)
                                                    @php
                                                        $accountTypes = [
                                                            1 => 'Individu',
                                                            2 => 'Pemaju',
                                                            3 => 'Agensi Kerajaan',
                                                        ];
                                                    @endphp
                                                    {{ $accountTypes[$application->client->accountType] ?? 'N/A' }}
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
                                            <!--<td>{{ $application->client ? 'RM ' . number_format($application->final_amount, 2) : 'N/A' }}-->
                                            <!--</td>-->
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
                                                @if($canfinanceAdminViewDetails)
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
@endsection
