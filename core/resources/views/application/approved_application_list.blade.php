@extends('app')

@section('content')
<style>
    table.table {
        text-align: center;
        font-size: 13px;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        text-transform: capitalize;
    }

    .status-approved { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .status-rejected { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .status-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }

    .sbtn {
        display: flex;
        gap: 5px; /* space between buttons */
        justify-content: center; /* center align */
        align-items: center;
    }
    .sbtn a {
        margin: 0; /* remove vertical spacing */
    }

    /* Add this improved CSS instead: */
    .search-row .form-label {
        font-weight: 500;
        min-width: fit-content;
    }

    .search-row .col-md-2 {
        min-width: 220px; /* increase width */
        flex: 1; /* make all boxes flexible */
    }
    .search-row .d-flex {
        height: 34px;
    }


    .search-row .btn {
        height: 31px;
        line-height: 1.2;
    }

    .search-row .col-md-3 {
        display: flex;
        justify-content: flex-end !important; 
        align-items: center;
    }

</style>

<div class="col-md-12 content-header">
    <h5><i class="fa fa-list-alt"></i> {{ trans('app.list_of_application') }}</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">

                    <div class="row search-row align-items-end mt-3 mx-1">
                        <!-- Search Input -->
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="d-flex align-items-center">
                                <label for="search" class="form-label mb-0 me-2" style="white-space: nowrap;">{{ trans('app.search') }} -</label>
                                <input type="text" id="search" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.search') }}">
                            </div>
                        </div>

                        <!-- District Dropdown -->
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="d-flex align-items-center">
                                <label for="district" class="form-label mb-0 me-2" style="white-space: nowrap;">{{ trans('app.district') }} -</label>
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
                        </div>

                        <!-- Division Dropdown -->
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="d-flex align-items-center">
                                <label for="division" class="form-label mb-0 me-2" style="white-space: nowrap;">{{ trans('app.division') }} -</label>
                                <select id="division" class="form-select form-select-sm form-control form-control-sm">
                                    <option value="">{{ trans('app.select_division') }}</option>
                                    @if(request('district'))
                                        @php
                                            $divisions = DB::table('division')->where('daerah_id', request('district'))->get();
                                        @endphp
                                        @foreach ($divisions as $div)
                                            <option value="{{ $div->idmukim }}" {{ request('division') == $div->idmukim ? 'selected' : '' }}>
                                                {{ $div->mukim_code }} - {{ $div->mukim }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <!-- Lot/PT Input -->
                        <div class="col-md-2 col-sm-6 mb-2">
                            <div class="d-flex align-items-center">
                                <label for="lot" class="form-label mb-0 me-2" style="white-space: nowrap;">{{ trans('app.lot_pt') }} -</label>
                                <input type="text" id="lot" class="form-control form-control-sm"
                                    placeholder="{{ trans('app.enter_lot_pt') }}" value="{{ request('lot') }}">
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-3 col-sm-12 mb-2 d-flex justify-content-md-end justify-content-sm-end justify-content-center gap-2">
                            <a href="#" class="btn btn-primary btn-sm search-btn"
                            style="background:#3c8dbc !important; border:solid 1px #3c8dbc;">
                                <strong>{{ trans('app.search_b') }}</strong>
                            </a>

                            <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">
                                <strong>{{ trans('app.reset') }}</strong>
                            </a>
                        </div>


                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('app.date') }}</th>
                                    <th>{{ trans('app.reference _no') }}</th>
                                    <th><strong>{{ trans('app.account_type') }}</strong></th>
                                    <th>{{ trans('app.application_type') }}</th>
                                    <th>{{ trans('app.applicant_name') }}</th>
                                    <th>{{ trans('app.status') }}</th>
                                    <th>{{ trans('app.for_action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvedApplications as $item)
                                    <tr>
                                        <td>{{ ($approvedApplications->currentPage() - 1) * $approvedApplications->perPage() + $loop->iteration }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>{{$item->refference_no }}</td>
                                         <td>
                                                {{ $item->client ? ($item->client->accountType == 1 ? 'Individu' : ($item->client->accountType == 2 ? 'Pemaju' : ($item->client->accountType == 3 ? 'Agensi Kerajaan' : 'Unknown'))) : '' }}
                                        </td>
                                        <td>
                                            @switch($item->application_type)
                                                @case('reapply')
                                                    {{ trans('app.reapply') }}
                                                @break

                                                @case('appeal')
                                                    {{ trans('app.appeal') }}
                                                @break
                                                @default
                                                    {{ trans('app.new') }}
                                            @endswitch
                                        </td>
                                        <td>{{ $item->applicant }}</td>

                                        <td>
                                            <span class="status-badge status-{{ $item->status }}">
                                                {{ trans('app.' . $item->status) }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <div class="sbtn">
                                                @php
                                                    $hasBeenViewed = DB::table('application_views')
                                                        ->where('application_id', $item->id)
                                                        ->exists();

                                                    $hasBeenEdited = DB::table('application_views')
                                                        ->where('application_id', $item->id)
                                                        ->where('action_type', 'edit')
                                                        ->exists();
                                                @endphp

                                                <a href="{{ route('newApplication', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm view-application {{ $hasBeenViewed ? 'btn-viewed' : '' }}"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if($isAdminOrStaff)
                                                    <a href="{{ route('updateApplication', ['id' => $item->id]) }}"
                                                        class="btn btn-warning btn-sm edit-application {{ $hasBeenEdited ? 'btn-edited' : '' }}"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif

                                                  <!-- Bill Icon (redirects to approver-letter) -->
                                                    <a href="{{ route('user_letter', ['application_id' => $item->id]) }}"
                                                        class="btn btn-info btn-sm"
                                                        title="View Bill">
                                                        <i class="fa fa-file-invoice"></i>
                                                    </a>

                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-2">
                            {{ $approvedApplications->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
        $('#search').on('input', function() {
            var searchTerm = $(this).val();
            if (searchTerm === '') {
                $('tbody tr').show();
                return;
            }
            
            // Filter table rows based on search term
            $('tbody tr').each(function() {
                var row = $(this);
                var found = false;
                
                // Search in specific columns (reference no, applicant name, account type)
                var refNo = row.find('td:nth-child(3)').text().toLowerCase();
                var applicantName = row.find('td:nth-child(6)').text().toLowerCase();
                var accountType = row.find('td:nth-child(4)').text().toLowerCase();
                
                searchTerm = searchTerm.toLowerCase();
                
                // Check if search term matches any of the columns
                if (refNo.includes(searchTerm) || 
                    applicantName.includes(searchTerm) || 
                    accountType.includes(searchTerm)) {
                    found = true;
                }
                
                // Show/hide row based on search result
                if (found) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });
    });
</script>
@endsection
