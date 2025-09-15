@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('app.log_activities')</h3>
                </div>
                
                <!-- Filters Section -->
                <div class="card-body">
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_name">@lang('app.log_type')</label>
                                    <select class="form-control" id="log_name" name="log_name">
                                        <option value="">@lang('app.all')</option>
                                        @foreach($logNames as $logName)
                                            <option value="{{ $logName }}" 
                                                {{ request('log_name') == $logName ? 'selected' : '' }}>
                                                @lang('app.' . $logName, [], '', ucfirst(str_replace('_', ' ', $logName)))
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="event">@lang('app.activity')</label>
                                    <select class="form-control" id="event" name="event">
                                        <option value="">@lang('app.all_events')</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event }}" 
                                                {{ request('event') == $event ? 'selected' : '' }}>
                                                @lang('app.' . $event, [], '', ucfirst(str_replace('_', ' ', $event)))
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date_from">@lang('app.start_date')</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" 
                                           value="{{ request('date_from') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="date_to">@lang('app.due_date')</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" 
                                           value="{{ request('date_to') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(request()->hasAny(['search', 'log_name', 'event', 'date_from', 'date_to']))
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-times"></i> {{ __('Clear Filters') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </form>
                    
                    <!-- Results Summary -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="text-muted">
                                {{ __('Showing') }} {{ $logs->firstItem() ?? 0 }} {{ __('to') }} 
                                {{ $logs->lastItem() ?? 0 }} {{ __('of') }} 
                                {{ $logs->total() }} {{ __('results') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Logs Table -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('S.NO') }}</th>
                                    <th>{{ __('Date & Time') }}</th>
                                    <th>{{ __('Log Type') }}</th>
                                    <th>{{ __('Event') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Subject') }}</th>
                                    <!--<th>{{ __('Admin') }}</th>-->
                                    <!--<th>{{ __('IP Address') }}</th>-->
                                    <!--<th>{{ __('Actions') }}</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $index => $log)
                                    <tr>
                                        <td>{{ $logs->firstItem() + $index }}</td>
                                        <td>
                                            <small>
                                                {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}<br>
                                                {{ \Carbon\Carbon::parse($log->created_at)->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ ucfirst(str_replace('_', ' ', $log->log_name)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($log->event == 'created') badge-success
                                                @elseif($log->event == 'updated') badge-warning
                                                @elseif($log->event == 'status_updated') badge-primary
                                                @elseif($log->event == 'deleted') badge-danger
                                                @else badge-secondary
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $log->event)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="description-cell" title="{{ $log->description }}">
                                                {{ \Illuminate\Support\Str::limit($log->description, 60) }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($log->subject_type && $log->subject_id)
                                                <small>
                                                    {{ class_basename($log->subject_type) }}<br>
                                                    ID: {{ $log->subject_id }}
                                                </small>
                                            @else
                                                <span class="text-muted">{{ __('N/A') }}</span>
                                            @endif
                                        </td>
                                        <!--<td>-->
                                        <!--    @if($log->causer_id)-->
                                        <!--        <small>{{ $log->causer_id }}</small>-->
                                        <!--    @else-->
                                        <!--        <span class="text-muted">{{ __('System') }}</span>-->
                                        <!--    @endif-->
                                        <!--</td>-->
                                        <!--<td>-->
                                        <!--    <small>{{ $log->ip_address ?? 'N/A' }}</small>-->
                                        <!--</td>-->
                                        <!--<td>-->
                                        <!--    <div class="btn-group" role="group">-->
                                        <!--        <button type="button" class="btn btn-sm btn-outline-info" -->
                                        <!--                onclick="viewLogDetails({{ $log->id }})" -->
                                        <!--                title="{{ __('View Details') }}">-->
                                        <!--            <i class="fas fa-eye"></i>-->
                                        <!--        </button>-->
                                        <!--        @if(!empty($log->properties))-->
                                        <!--            <button type="button" class="btn btn-sm btn-outline-secondary" -->
                                        <!--                    onclick="viewChanges({{ $log->id }})" -->
                                        <!--                    title="{{ __('View Changes') }}">-->
                                        <!--                <i class="fas fa-history"></i>-->
                                        <!--            </button>-->
                                        <!--        @endif-->
                                        <!--    </div>-->
                                        <!--</td>-->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            {{ __('No activity logs found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($logs->hasPages())
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    {{ __('Showing') }} {{ $logs->firstItem() }} {{ __('to') }} 
                                    {{ $logs->lastItem() }} {{ __('of') }} {{ $logs->total() }} {{ __('entries') }}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                {{ $logs->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Log Details') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="logDetailsContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Changes Modal -->
<div class="modal fade" id="changesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Changes Details') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="changesContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function viewLogDetails(logId) {
    $.ajax({
        url: `/activity-logs/${logId}`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const log = response.data;
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <strong>{{ __('Log Name') }}:</strong> ${log.log_name || 'N/A'}<br>
                            <strong>{{ __('Event') }}:</strong> ${log.event || 'N/A'}<br>
                            <strong>{{ __('Subject Type') }}:</strong> ${log.subject_type || 'N/A'}<br>
                            <strong>{{ __('Subject ID') }}:</strong> ${log.subject_id || 'N/A'}<br>
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('Admin ID') }}:</strong> ${log.causer_id || 'System'}<br>
                            <strong>{{ __('IP Address') }}:</strong> ${log.ip_address || 'N/A'}<br>
                            <strong>{{ __('User Agent') }}:</strong> ${log.user_agent || 'N/A'}<br>
                            <strong>{{ __('Created At') }}:</strong> ${new Date(log.created_at).toLocaleString()}<br>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>{{ __('Description') }}:</strong><br>
                            <p class="mt-2">${log.description}</p>
                        </div>
                    </div>
                `;
                $('#logDetailsContent').html(content);
                $('#logDetailsModal').modal('show');
            }
        },
        error: function() {
            alert('{{ __("Failed to load log details") }}');
        }
    });
}

function viewChanges(logId) {
    $.ajax({
        url: `/activity-logs/${logId}`,
        method: 'GET',
        success: function(response) {
            if (response.success && response.data.properties) {
                const changes = response.data.properties;
                let content = '<div class="table-responsive"><table class="table table-sm">';
                content += '<thead><tr><th>{{ __("Field") }}</th><th>{{ __("Old Value") }}</th><th>{{ __("New Value") }}</th></tr></thead><tbody>';
                
                Object.keys(changes).forEach(function(field) {
                    const change = changes[field];
                    content += `
                        <tr>
                            <td><strong>${field.replace(/_/g, ' ').toUpperCase()}</strong></td>
                            <td class="text-danger">${change.old || 'N/A'}</td>
                            <td class="text-success">${change.new || 'N/A'}</td>
                        </tr>
                    `;
                });
                
                content += '</tbody></table></div>';
                $('#changesContent').html(content);
                $('#changesModal').modal('show');
            } else {
                $('#changesContent').html('<p class="text-muted">{{ __("No changes recorded") }}</p>');
                $('#changesModal').modal('show');
            }
        },
        error: function() {
            alert('{{ __("Failed to load changes") }}');
        }
    });
}

// Auto-submit form on filter change (optional)
$(document).ready(function() {
    $('#log_name, #event').change(function() {
        // Uncomment the line below if you want auto-submit on dropdown change
        // $(this).closest('form').submit();
    });
});
</script>
@endsection

@section('styles')
<style>
.description-cell {
    max-width: 200px;
    word-wrap: break-word;
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    margin-right: 2px;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.875rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 5px;
}
</style>
@endsection