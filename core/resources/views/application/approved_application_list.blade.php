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


      .status-column {
        min-width: 120px;
    }

    .status-pending {
        background-color: #ffc107;
        color: #000;
    }

    .status-approved {
        background-color: #28a745;
        color: #fff;
    }

       #aside {
        display: flex;
        align-items: baseline;
    }

    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    .status-column .badge {
        margin-bottom: 8px;
    }

    .status-column .performed-by {
        display: inline-block;
        margin-top: 4px;
    }

    .status-badge {
        display: inline-block;
        margin: 5px 0;
    }

    .status-badge .badge {
        font-size: 0.8rem;
        padding: 8px 29px;
        border-radius: 25px;
        background-color: #1991EE !important;
        color: #fff !important;
    }

    .status-badge .badge:hover {
        opacity: 0.9;
        cursor: pointer;
    }

    /* Highlight pending rows */
    table.table tbody tr.pending-row {
        background-color: #fff3cd;
    }

    .pagination {
        position: relative;
        z-index: 1;
    }

    /* Status column styles */
    .status-column {
        min-width: 120px;
    }

    .status-pending {
        background-color: #ffc107;
        color: #000;
    }

    .status-approved {
        background-color: #28a745;
        color: #fff;
    }

    .status-rejected {
        background-color: #dc3545;
        color: #fff;
    }

    .status-na {
        background-color: #6c757d;
        color: #fff;
    }

    .status-returned_to_staff {
        background-color: #ffc107;
        color: #fff;
    }

    .log-link {
        color: #17a2b8;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .log-link:hover {
        color: #0e8295;
        background-color: rgba(23, 162, 184, 0.1);
        transform: translateY(-1px);
        text-decoration: underline;
    }

    .log-link:active {
        transform: translateY(0);
    }

    /* Modal styles */
    .logs-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        background: linear-gradient(145deg, #ffffff, #f0f4f8);
        margin: 5% auto;
        padding: 30px;
        border: none;
        width: 65%;
        max-width: 700px;
        min-width: 350px;
        border-radius: 12px;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        position: relative;
        animation: slideIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .close {
        color: #555;
        float: right;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .close:hover {
        color: #000;
    }

    .log-entry {
        border: 1px solid #e0e4e8;
        margin-bottom: 15px;
        padding: 20px;
        border-radius: 8px;
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .log-entry:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .log-header {
        font-weight: 600;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #2c3e50;
    }

    .log-details {
        font-size: 0.85rem;
        color: #34495e;
        line-height: 1.6;
    }

    .user-type-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .user-type-staff {
        background-color: #3498db;
        color: white;
    }

    .user-type-approver {
        background-color: #2ecc71;
        color: white;
    }

    .modal-content h3 {
        margin: 0 0 25px 0;
        font-size: 1.5rem;
        color: #2c3e50;
        display: inline-block;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
    }

    .status-change {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-arrow {
        color: #7f8c8d;
        font-size: 0.9rem;
    }



</style>

<div class="col-md-12 content-header">
    <h5><i class="fa fa-list-alt"></i>Permohonan Yang Diluluskan</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">

                    <div class="row search-row align-items-end mt-3 mx-1">
                        <!-- Search Input -->
                        <div class="col-md-3 col-sm-6 colsm36">
                            <label for="search" class="form-label">{{ trans('app.search') }}:&nbsp;</label>
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
                            <label for="lot" class="form-label me-2">{{ trans('app.lot_pt') }}:</label>&nbsp;&nbsp;
                            <input type="text" id="lot" class="form-control form-control-sm"
                                placeholder="{{ trans('app.enter_lot_pt') }}" value="{{ request('lot') }}">
                        </div>

                        <!-- Buttons + Show Per Page (Right Aligned) -->
                        <div class="col-md-12 col-sm-12 mt-3 mb-2 d-flex align-items-center flex-wrap gap-3">

                            <!-- LEFT SIDE (Show Per Page + Year) -->
                            <div class="d-flex align-items-center gap-3">

                                <!-- Show Per Page -->
                                <div class="d-flex align-items-center">
                                    <label for="perPageSelect" class="me-2 mb-0 fw-semibold" style="white-space: nowrap;">
                                        @lang('app.show'):
                                    </label>
                                    <select id="perPageSelect" name="perPage"
                                        class="form-select form-select-sm" style="width:80px;">
                                        <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                        <option value="500" {{ request('perPage') == 500 ? 'selected' : '' }}>500</option>
                                    </select>
                                </div>

                                <!-- Year Dropdown -->
                                <div class="d-flex align-items-center">
                                    <label for="year" class="me-2 mb-0 fw-semibold">Tahun:</label>
                                    <select id="year" class="form-select form-select-sm" style="width:159px;">
                                        <option value="">Semua Tahun</option>
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2000;
                                        @endphp
                                        @for ($y = $currentYear; $y >= $startYear; $y--)
                                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                            </div>

                            <!-- RIGHT SIDE BUTTONS -->
                            <div class="d-flex gap-2 ms-auto">
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


                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><strong>{{ trans('app.bil') }}</strong></th>
                                    <th>{{ trans('app.date') }}</th>
                                    <th>{{ trans('app.reference _no') }}</th>
                                    <th><strong>{{ trans('app.account_type') }}</strong></th>
                                    <th>{{ trans('app.application_type') }}</th>
                                    <th>{{ trans('app.applicant_name') }}</th>
                                    <th>Lot/PT</th>
                                    <th>Jumlah Caruman (RM)</th>
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
                                                @php
                                                    $clientType = '';
                                                    $applicantType = '';
                                                    
                                                    if ($item->client) {
                                                        // Get client account type
                                                        switch ($item->client->accountType) {
                                                            case 1:
                                                                $clientType = 'Individu';
                                                                break;
                                                            case 2:
                                                                $clientType = 'Pemaju';
                                                                break;
                                                            case 3:
                                                                $clientType = 'Agensi Kerajaan';
                                                                break;
                                                            case 4:
                                                                $clientType = 'Perunding';
                                                                break;
                                                            default:
                                                                $clientType = 'Unknown';
                                                        }
                                                        
                                                        // Get applicant type from application
                                                        switch ($item->applicant_type) {
                                                            case 1:
                                                                $applicantType = 'Individu';
                                                                break;
                                                            case 2:
                                                                $applicantType = 'Pemaju';
                                                                break;
                                                            case 3:
                                                                $applicantType = 'Agensi Kerajaan';
                                                                break;
                                                            case 4:
                                                                $clientType = 'Perunding';
                                                                break;
                                                        }
                                                        
                                                        // Display logic
                                                        if ($applicantType && $applicantType != $clientType) {
                                                            echo $clientType . '-' . $applicantType;
                                                        } else {
                                                            echo $clientType;
                                                        }
                                                    }
                                                @endphp
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
                                        <td>{{ strtoupper($item->applicant) }}</td>
                                        <td>{{$item->land_lot}},{{ $item->land_area }}, {{ $item->landDivision->mukim ?? '' }},Daerah
                                                {{ $item->landDistrict->daerah ?? '' }}</td>
                                        <td>{{number_format($item->final_amount, 2)}}</td>

                                        <td>
                                            <span class="status-badge status-{{ $item->status }}">
                                                {{ trans('app.' . $item->status) }}
                                            </span>
                                            <div class="mt-2">
                                                <a href="#" class="log-link" onclick="showLogs({{ $item->id }})">
                                                    Log
                                                </a>
                                            </div>
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

                                                    $paymentCompleted = DB::table('payments')
                                                    ->where('application_id', $item->id)
                                                    ->where('payment_status', 'completed')
                                                    ->exists();
                                                @endphp

                                                <a href="{{ route('newApplication', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm view-application {{ $hasBeenViewed ? 'btn-viewed' : '' }}"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                               @if($isAdminOrStaff && !$paymentCompleted)
                                                        <a href="{{ route('updateApplication', ['id' => $item->id]) }}"
                                                            class="btn btn-warning btn-sm edit-application {{ $hasBeenEdited ? 'btn-edited' : '' }}"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                @elseif($isAdminOrStaff && $paymentCompleted)
                                                        <button class="btn btn-secondary btn-sm disabled" 
                                                                disabled
                                                                title="Cannot edit - Payment completed"
                                                                data-id="{{ $item->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
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
                        <div class="d-flex justify-content-end mt-2">
                            {{ $approvedApplications->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Logs Modal -->
        <div id="logsModal" class="logs-modal">
            <div class="modal-content">
                <span class="close" onclick="closeLogs()">×</span>
                <h3>@lang('app.application_logs')</h3>
                <div id="logsContent">
                    <!-- Logs will be loaded here -->
                </div>
            </div>
        </div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-primary').click(function() {
        $('table tbody tr').show();
    });

    $('.btn-alert').click(function() {
        $('table tbody tr').hide();
        $('table tbody tr').each(function() {
            if ($(this).find('.status-badge .badge').text().trim() ===
                '{{ trans('app.approved') }}') {
                $(this).show();
            }
        });
    });

    $('.btn-danger').click(function() {
        $('table tbody tr').hide();
        $('table tbody tr').each(function() {
            if ($(this).find('.sbtn a').text().trim() === '{{ trans('app.rejected') }}') {
                $(this).show();
            }
        });
    });
});

function changePerPage() {
    const perPage = document.getElementById('perPageSelect').value;
    const url = new URL(window.location.href);
    const statusFilter = url.searchParams.get('status') || '';
    const adminStaffStatus = url.searchParams.get('admin_staff_status') || '';
    const approverStatus = url.searchParams.get('approver_status') || '';

    url.searchParams.set('page', 1);
    url.searchParams.set('per_page', perPage);

    if (statusFilter) url.searchParams.set('status', statusFilter);
    if (adminStaffStatus) url.searchParams.set('admin_staff_status', adminStaffStatus);
    if (approverStatus) url.searchParams.set('approver_status', approverStatus);

    window.location.href = url.toString();
}

const applicationLogs = {};
@foreach ($approvedApplications as $application)
    applicationLogs[{{ $application->id }}] = {!! json_encode(
        $application->logs->map(function ($log) {
            return [
                'user_type' => $log->user_type,
                'action' => $log->action,
                'status_from' => $log->status_from,
                'status_to' => $log->status_to,
                'remarks' => $log->remarks,
                'user_id' => $log->user_id,
                'user_email' => $log->user ? $log->user->email : null,
                'action_at' => $log->action_at ? $log->action_at->format('Y-m-d H:i:s') : null,
            ];
        }),
    ) !!};
@endforeach

function formatAction(action) {
    return action
        .replace(/_/g, ' ')
        .replace(/\b\w/g, char => char.toUpperCase());
}

function showLogs(applicationId) {
    document.getElementById('logsModal').style.display = 'block';
    const logs = applicationLogs[applicationId] || [];
    displayLogs(logs);
}

const actionStatusTranslations = {
    'approved': 'Lulus',
    'rejected': 'Tolak',
    'forwarded_to_approver': 'Bil Telah Dihantar ke Pelulus',
    'Pending': 'Dalam Proses',
    'reapply': 'Memohon Semula',
    'Completed': 'Selesai',
    'Created': 'Dicipta',
    'Updated': 'Dikemaskini',
    'awaiting_review': 'Menunggu Semakan',
    'status_reset_for_appeal': 'Tetapan Semula Status Untuk Rayuan'
};

function displayLogs(logs) {
    let html = '';
    if (logs.length === 0) {
        html = '<p class="text-muted">No logs found for this application.</p>';
    } else {
        const hasRejection = logs.some(log =>
            log.user_type === 'admin_approver' && log.status_to === 'rejected'
        );
        if (hasRejection) {
            html += `
<div class="log-entry" style="background-color: #fff8e1; border-left: 4px solid #ffc107;">
    <div class="log-header">
        <div>
            <span class="user-type-badge" style="background-color: #6c757d;">SYSTEM</span>
            <strong>Status Update</strong>
        </div>
    </div>
    <div class="log-details">
        <div><strong>Note:</strong> Admin Staff status displayed as "In Process" because application was rejected by Approver.</div>
        <div class="mt-2"><small class="text-muted">This doesn't represent an actual status change in logs, but reflects the current workflow state.</small></div>
    </div>
</div>
`;
        }
        const sortedLogs = [...logs];
        sortedLogs.sort((a, b) => new Date(b.action_at) - new Date(a.action_at));
        sortedLogs.forEach(function(log) {
            const userTypeBadge = log.user_type === 'admin_staff' ? 'user-type-staff' :
                log.user_type === 'admin_approver' ? 'user-type-approver' : 'user-type-staff';

            const actionDate = new Date(log.action_at).toLocaleString();
            const displayUserType = log.user_type === 'admin_staff' ? 'Penyedia' :
                log.user_type === 'admin_approver' ? 'Pelulus' :
                log.user_type === 'applicant' ? 'Pemohon' :
                log.user_type.toUpperCase();

            const formattedAction = actionStatusTranslations[log.action] || 
           actionStatusTranslations[log.action?.toLowerCase()] ||
           actionStatusTranslations[log.status_to] || 
           actionStatusTranslations[log.status_from] || 
           log.action;

            let statusDisplay = '';
            if (log.status_from || log.status_to) {
                let fromStatus = log.status_from || 'Belum Terima';
                let toStatus = log.status_to || 'Belum Terima';
                fromStatus = fromStatus === 'pending' ? 'Dalam Proses' : 
                fromStatus === 'approved' ? 'Lulus' : 
                fromStatus === 'rejected' ? 'Tolak' : 
                fromStatus;

                toStatus = toStatus === 'pending' ? 'Dalam Proses' : 
                          toStatus === 'approved' ? 'Lulus' : 
                          toStatus === 'rejected' ? 'Tolak' : 
                          toStatus;

                statusDisplay = `
                <div class="status-change">
                    <strong>Status:</strong>
                    <span class="badge status-${log.status_from || 'na'}">${fromStatus}</span>
                    <span class="status-arrow">→</span>
                    <span class="badge status-${log.status_to || 'na'}">${toStatus}</span>
                </div>`;
            }
            
            const remarkTranslations = {
                'Application forwarded to approver for final review': 'Bil telah dijana dan dihantar kepada pelulus',
                'Application approved by approver': 'Permohonan telah diluluskan dan bil telah dihantar ke pemaju',
                'Application resubmitted by user' : 'Permohonan dihantar semula oleh pemohon',
                'Staff status reset to pending after approver rejection' : 'Status penyedia ditetapkan semula kepada dalam proses selepas penolakan oleh pelulus',
                'Approver status reset to pending after staff re-forwarded application' : 'Status pelulus ditetapkan semula kepada "Dalam Proses" selepas penyedia menghantar semula permohonan',
                'Application sent to approver for review': 'Permohonan dihantar ke pelulus untuk semakan',
                'Approver status reset after staff resubmitted rejected application': 'Status pelulus berubah selepas permohonan ditolak dihantar semula.',
                'Approver status reset to pending due to appeal submission': 'Status kelulusan ditetapkan semula kepada belum selesai kerana penyerahan rayuan'
            };
            
            let remarksDisplay = '';
            if (log.remarks && log.remarks.trim() !== '') {
                const translatedRemark = remarkTranslations[log.remarks.trim()] || log.remarks;
                remarksDisplay = `<div class="mt-2"><strong>Nota:</strong> ${translatedRemark}</div>`;
            }

            html += `
<div class="log-entry">
    <div class="log-header">
        <div>
            <span class="user-type-badge ${userTypeBadge}">${displayUserType}</span>
            <strong>${formattedAction}</strong>
        </div>
        <small class="text-muted">${actionDate}</small>
    </div>
    <div class="log-details">
        <div><strong>Oleh:</strong> ${log.user_email || 'Sistem'}</div>
        ${statusDisplay}
        ${remarksDisplay}
    </div>
</div>`;
        });
    }

    document.getElementById('logsContent').innerHTML = html;
}

function closeLogs() {
    document.getElementById('logsModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('logsModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

<script>
$(document).ready(function() {
    // SEARCH AND FILTER FUNCTIONALITY
    function performSearch() {
        let params = new URLSearchParams();
        
        let search = $('#search').val().trim();
        let district = $('#district').val();
        let division = $('#division').val();
        let lot = $('#lot').val().trim();
        let year = $('#year').val();
        let perPage = $('#perPageSelect').val();

        if (search) params.append('search', search);
        if (district) params.append('district', district);
        if (division) params.append('division', division);
        if (lot) params.append('lot', lot);
        if (year) params.append('year', year);
        if (perPage) params.append('perPage', perPage);

        window.location.href = '{{ url()->current() }}?' + params.toString();
    }

    // Handle search button click
    $('.search-btn').on('click', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Handle Enter key in search inputs
    $('#search, #lot').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            performSearch();
        }
    });

    // Handle year and perPage changes
    $('#year, #perPageSelect').on('change', function() {
        performSearch();
    });

    // DISTRICT CHANGE HANDLER - Load divisions, but DON'T auto-search
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
                        options += `<option value="${mukin.idmukim}">${mukin.mukim_code +' - '+mukin.mukim}</option>`;
                    });
                    $('#division').html(options);
                },
                error: function() {
                    $('#division').html('<option value="">Error loading mukin</option>');
                }
            });
        } else {
            $('#division').html('<option value="">Sila Pilih</option>');
        }
    });

    // DIVISION CHANGE - Trigger search when division selected
    $('#division').on('change', function() {
        performSearch();
    });

    // STATUS FILTER (if exists)
    $('#status').on('change', function() {
        var status = $(this).val();
        var queryParams = [];

        if (status) queryParams.push('status=' + status);

        window.location.href = window.location.pathname + '?' + queryParams.join('&');
    });
});
</script>

<script>
// Track application actions
$(document).ready(function() {
    // Track view clicks
    $(document).on('click', '.view-application', function(e) {
        const applicationId = $(this).data('id');
        const $button = $(this);
        trackAction(applicationId, 'view', $button);
    });

    // Track edit clicks
    $(document).on('click', '.edit-application', function(e) {
        const applicationId = $(this).data('id');
        const $button = $(this);
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
