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

    .sbtn a { margin: 0 2px; }
</style>

<div class="col-md-12 content-header">
    <h5><i class="fa fa-list-alt"></i> {{ trans('app.list_of_application') }}</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input type="text" id="search" class="form-control form-control-sm"
                                   placeholder="{{ trans('app.search') }}">
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
    // Live search
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().includes(value));
        });
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
@endsection
