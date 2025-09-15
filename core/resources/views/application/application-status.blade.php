@extends('app')
<style>
    /* General Styles */
    body {
        font-family: "Poppins", sans-serif;
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
        font-family: "Poppins", sans-serif;
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Flex container for buttons */
    .sbtn {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
    }

    .sbtn a {
        flex: 0 1 auto;
        max-width: 150px;
        padding: 4px 8px;
        font-size: 0.75rem;
        line-height: 1;
        background: #E85B6C !important;
        border: 1px solid #E85B6C;
        border-radius: 25px;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
        line-height: 1;
    }

    .sbtn {
        gap: 0.25rem;
    }

    @media (max-width: 768px) {
        .sbtn {
            justify-content: center;
        }

        .sbtn a {
            flex: 1 1 100%;
            max-width: none;
        }
    }

    .btn-sm {
        padding: 6px 10px !important;
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
        padding: 8px 15px;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-content {
            width: 90%;
            margin: 15% auto;
            min-width: unset;
            max-height: 85vh;
            padding: 20px;
        }

        .modal-content h3 {
            font-size: 1.3rem;
        }

        .log-entry {
            padding: 15px;
        }
    }
    
    
    .input-group {
        max-width: 300px;
    }
    
    .float-end {
        float: right !important;
    }
    
    .form-inline {
        display: flex;
        align-items: center;
    }
    
    @media (max-width: 768px) {
        .float-end {
            float: none !important;
            margin-bottom: 15px;
        }
        
        .input-group {
            max-width: 100%;
        }
    }
</style>
<title>{{ trans('app.application_status') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> {{ trans('app.application_status') }}</h5>
    </div>
    <section class="content">
        
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Create a flex container for filters and search -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <!-- Left side: Filters -->
                            <div class="btn-group" role="group">
                                <label class="form-label fw-bold me-3">@lang('app.filter') :</label>
                                @if ($isStaffAdmin)
                                    <div class="d-flex align-items-center me-3">
                                        <label for="adminStaffStatusFilter" class="me-2">
                                            <!--Admin Staff Status: -->
                                        </label>
                                        <select id="adminStaffStatusFilter" class="form-select form-select-sm"
                                            onchange="window.location.href = this.value"
                                            style="width: auto; min-width: 150px;">
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['admin_staff_status' => 'all', 'page' => 1]) }}"
                                                {{ empty($adminStaffStatus) || $adminStaffStatus == 'all' ? 'selected' : '' }}>
                                                @lang('app.all')
                                            </option>
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['admin_staff_status' => 'pending', 'page' => 1]) }}"
                                                {{ $adminStaffStatus == 'pending' ? 'selected' : '' }}>
                                                @lang('app.in_process')
                                            </option>
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['admin_staff_status' => 'approved', 'page' => 1]) }}"
                                                {{ $adminStaffStatus == 'approved' ? 'selected' : '' }}>
                                                @lang('app.passed')
                                            </option>
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['admin_staff_status' => 'rejected', 'page' => 1]) }}"
                                                {{ $adminStaffStatus == 'rejected' ? 'selected' : '' }}>
                                                @lang('app.reject')
                                            </option>
                                        </select>
                                    </div>
                                @endif
                                @if ($isApproverAdmin)
                                    <div class="d-flex align-items-center">
                                        <label for="approverStatusFilter" class="me-2">
                                            <!--Approver Status: -->
                                        </label>
                                        <select id="approverStatusFilter" class="form-select form-select-sm"
                                            onchange="window.location.href = this.value"
                                            style="width: auto; min-width: 150px;">
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['approver_status' => 'all', 'page' => 1, 'per_page' => $perPage]) }}"
                                                {{ empty($approverStatus) || $approverStatus == 'all' ? 'selected' : '' }}>
                                                @lang('app.all')
                                            </option>
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['approver_status' => 'pending', 'page' => 1, 'per_page' => $perPage]) }}"
                                                {{ $approverStatus == 'pending' ? 'selected' : '' }}>
                                                @lang('app.in_process')
                                            </option>
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['approver_status' => 'approved', 'page' => 1, 'per_page' => $perPage]) }}"
                                                {{ $approverStatus == 'approved' ? 'selected' : '' }}>
                                                @lang('app.passed')
                                            </option>
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['approver_status' => 'rejected', 'page' => 1, 'per_page' => $perPage]) }}"
                                                {{ $approverStatus == 'rejected' ? 'selected' : '' }}>
                                                @lang('app.reject')
                                            </option>
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <!-- Right side: Search -->
                            <div class="search-container">
                                <form action="{{ route('application_status') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="@lang('app.search')..." value="{{ request('search') }}">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        @if (request('search'))
                                            <a href="{{ route('application_status') }}" class="btn btn-danger btn-sm"
                                                title="@lang('app.clear')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline mb-3 mx-3">
                            <div class="d-flex align-items-baseline">
                                <label for="perPageSelect" class="me-2">@lang('app.show') : </label>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.reference_no') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.application_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.total_contribution') }}</strong></th>
                                        <th class="status-column"><strong>{{ trans('app.admin_staff_status') }}</strong></th>
                                        <th class="status-column"><strong>{{ trans('app.approver_status') }}</strong></th>
                                        <th><strong>{{ trans('app.overall_status') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($applications as $key => $application)
                                        @php
                                            // Get all logs sorted by date (newest first)
                                            $allLogs = $application->logs->sortByDesc('created_at');
                                            
                                            // Check if this is a reapplication
                                            $isReapplication = $application->application_type === 'reapply';
                                            $reapplyLog = $allLogs->firstWhere('action', 'reapply');
                                        
                                            // Initialize display statuses
                                            $displayStaffStatus = null;
                                            $displayApproverStatus = null;
                                        
                                            if ($isReapplication && $reapplyLog) {
                                                // Handle reapplication case separately
                                                $logsAfterReapply = $allLogs->where('created_at', '>', $reapplyLog->created_at);
                                                
                                                $staffStatusAfterReapply = $logsAfterReapply->firstWhere('user_type', 'admin_staff');
                                                $approverStatusAfterReapply = $logsAfterReapply->firstWhere('user_type', 'admin_approver');
                                                
                                                if ($staffStatusAfterReapply) {
                                                    $displayStaffStatus = $staffStatusAfterReapply;
                                                    
                                                    if ($staffStatusAfterReapply->status_to == 'approved' && !$approverStatusAfterReapply) {
                                                        $displayApproverStatus = (object) [
                                                            'status_to' => 'pending',
                                                            'additional_data' => ['performed_by' => 'Sistem'],
                                                            'is_auto_status' => true,
                                                        ];
                                                    } else {
                                                        $displayApproverStatus = $approverStatusAfterReapply;
                                                    }
                                                } else {
                                                    $displayStaffStatus = (object) [
                                                        'status_to' => 'pending',
                                                        'additional_data' => ['performed_by' => 'Sistem'],
                                                        'is_auto_status' => true,
                                                    ];
                                                    
                                                    $displayApproverStatus = (object) [
                                                        'status_to' => 'na',
                                                        'additional_data' => ['performed_by' => 'Sistem'],
                                                        'is_auto_status' => true,
                                                    ];
                                                }
                                            } else {
                                                // Handle normal application flow
                                                
                                                // 1. First check for any approver rejection
                                                $latestApproverRejection = $allLogs->firstWhere('user_type', 'admin_approver.status_to', 'rejected');
                                                
                                                if ($latestApproverRejection) {
                                                    // After rejection, staff status should be pending until they act again
                                                    $displayStaffStatus = (object) [
                                                        'status_to' => 'pending',
                                                        'additional_data' => ['performed_by' => 'Sistem'],
                                                        'is_override' => true,
                                                        'is_auto_status' => true,
                                                    ];
                                                    
                                                    $displayApproverStatus = $latestApproverRejection;
                                                    
                                                    // Check if staff has approved after this rejection
                                                    $staffApprovalAfterRejection = $allLogs
                                                        ->where('user_type', 'admin_staff')
                                                        ->where('status_to', 'approved')
                                                        ->where('created_at', '>', $latestApproverRejection->created_at)
                                                        ->first();
                                                    
                                                    if ($staffApprovalAfterRejection) {
                                                        $displayStaffStatus = $staffApprovalAfterRejection;
                                                        $displayApproverStatus = (object) [
                                                            'status_to' => 'pending',
                                                            'additional_data' => ['performed_by' => 'Sistem'],
                                                            'is_auto_status' => true,
                                                        ];
                                                    }
                                                } 
                                                // 2. If no rejection, check for staff approval
                                                elseif ($latestStaffApproval = $allLogs->firstWhere('user_type', 'admin_staff.status_to', 'approved')) {
                                                    $displayStaffStatus = $latestStaffApproval;
                                                    
                                                    // Check if approver has acted after this approval
                                                    $approverActionAfterApproval = $allLogs
                                                        ->where('user_type', 'admin_approver')
                                                        ->where('created_at', '>', $latestStaffApproval->created_at)
                                                        ->first();
                                                    
                                                    if ($approverActionAfterApproval) {
                                                        $displayApproverStatus = $approverActionAfterApproval;
                                                    } else {
                                                        $displayApproverStatus = (object) [
                                                            'status_to' => 'pending',
                                                            'additional_data' => ['performed_by' => 'Sistem'],
                                                            'is_auto_status' => true,
                                                        ];
                                                    }
                                                } 
                                                // 3. Default case - show latest status for each
                                                else {
                                                    $displayStaffStatus = $allLogs->firstWhere('user_type', 'admin_staff');
                                                    $displayApproverStatus = $allLogs->firstWhere('user_type', 'admin_approver');
                                                }
                                            }
                                            
                                            // Fallback for empty statuses
                                            if (!$displayStaffStatus) {
                                                $displayStaffStatus = (object) [
                                                    'status_to' => 'pending',
                                                    'additional_data' => ['performed_by' => 'Sistem'],
                                                    'is_auto_status' => true,
                                                ];
                                            }
                                            
                                            if (!$displayApproverStatus) {
                                                $displayApproverStatus = (object) [
                                                    'status_to' => 'na',
                                                    'additional_data' => ['performed_by' => 'Sistem'],
                                                    'is_auto_status' => true,
                                                ];
                                            }
                                        @endphp
                                        <tr class="{{ $application->status == 'pending' ? 'pending-row' : '' }}">
                                            <td>{{ $applications->firstItem() + $loop->index }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}</td>
                                            <td style="word-break: break-all;">
                                                  {{ $application->refference_no ?? '-' }}
                                            </td>
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
                                            <td>{{ $application->client ? 'RM ' . number_format($application->final_amount, 2) : 'N/A' }}
                                            </td>
                                           
                                            <td class="status-column">
                                                @if ($displayStaffStatus)
                                                    <!--<span-->
                                                    <!--    class="badge status-{{ $displayStaffStatus->status_to ?? 'na' }}">-->
                                                    <!--    @if (($displayStaffStatus->status_to ?? '') == 'pending')-->
                                                    <!--       {{ trans('app.in_process') }}-->
                                                    <!--    @else-->
                                                    <!--        {{ ucfirst($displayStaffStatus->status_to ?? 'N/A') }}-->
                                                    <!--    @endif-->
                                                    <!--</span>-->
                                                    <span class="badge status-{{ $displayStaffStatus->status_to ?? 'na' }}">
                                                        @switch($displayStaffStatus->status_to ?? '')
                                                            @case('pending')
                                                                {{ trans('app.in_process') }}
                                                                @break
                                                            @case('approved')
                                                                {{ trans('app.passed') }}
                                                                @break
                                                            @case('rejected')
                                                                {{ trans('app.reject') }}
                                                                @break
                                                            @default
                                                                {{ trans('app.na') }}
                                                        @endswitch
                                                    </span>
                                                    <br>
                                                    @php
                                                        $additionalData = is_array($displayStaffStatus->additional_data)
                                                            ? $displayStaffStatus->additional_data
                                                            : json_decode($displayStaffStatus->additional_data, true);
                                                        $performedBy = $additionalData['performed_by'] ?? 'Unknown';

                                                        // Show a note if this is an override status
                                                        $overrideNote = isset($displayStaffStatus->is_override)
                                                            ? ' (Status updated after rejection)'
                                                            : '';
                                                    @endphp
                                                    <small class="text-info performed-by">Oleh -
                                                        {{ ucfirst($performedBy) }}{{ $overrideNote }}</small>
                                                @else
                                                    <span class="badge status-na">N/A</span>
                                                @endif
                                            </td>
                                            {{-- <td class="status-column">
                                                @if ($approverStatus)
                                                    <span class="badge status-{{ $approverStatus->status_to ?? 'na' }}">
                                                        {{ ucfirst($approverStatus->status_to ?? 'N/A') }}
                                                    </span>
                                                    <br>
                                                    @php
                                                        $additionalData = is_array($approverStatus->additional_data)
                                                            ? $approverStatus->additional_data
                                                            : json_decode($approverStatus->additional_data, true);
                                                        $performedBy = $additionalData['performed_by'] ?? 'Unknown';
                                                    @endphp
                                                    <small class="text-info performed-by">Performed by -
                                                        {{ ucfirst($performedBy) }}</small>
                                                @else
                                                    <span class="badge status-na">N/A</span>
                                                @endif
                                            </td> --}}
                                            <td class="status-column">
                                                @if ($displayApproverStatus)
                                                    <span class="badge status-{{ $displayApproverStatus->status_to ?? 'na' }}">
                                                        @switch($displayApproverStatus->status_to ?? '')
                                                            @case('pending')
                                                                @if(isset($displayApproverStatus->is_auto_status))
                                                                   Belum Terima
                                                                @else
                                                                    {{ trans('app.in_process') }}
                                                                @endif
                                                                @break
                                                            @case('approved')
                                                                {{ trans('app.passed') }}
                                                                @break
                                                            @case('rejected')
                                                                {{ trans('app.reject') }}
                                                                @break
                                                            @default
                                                              Belum Terima
                                                        @endswitch
                                                    </span>
                                                    <br>
                                                    @if (!isset($displayApproverStatus->is_auto_status))
                                                        @php
                                                            $additionalData = is_array($displayApproverStatus->additional_data)
                                                                ? $displayApproverStatus->additional_data
                                                                : json_decode($displayApproverStatus->additional_data, true);
                                                            $performedBy = $additionalData['performed_by'] ?? 'Unknown';
                                                        @endphp
                                                        <small class="text-info performed-by">Oleh - {{ ucfirst($performedBy) }}</small>
                                                    @else
                                                        <!--<small class="text-muted">in process</small>-->
                                                    @endif
                                                @else
                                                    <span class="badge status-na">Belum Terima</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($application->status == 'approved')
                                                    <div class="status-badge">
                                                        <a href="{{ $isAdminOrStaff ? route('apporver_view_letter', ['application_id' => $application->id]) : route('approver_letter', ['application_id' => $application->id]) }}"
                                                            style="text-decoration: none;">
                                                            <span
                                                                class="badge bg-warning text-dark d-flex align-items-center">
                                                                <i class="bi bi-hourglass-split me-2"></i>
                                                                {{ trans('app.completed') }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @elseif ($application->status == 'pending')
                                                    <div class="sbtn">
                                                        <a href="#"
                                                            class="btn btn-primary btn-sm"><strong>{{trans('app.in_process')}}</strong></a>
                                                    </div>
                                                @elseif ($application->status == 'rejected')
                                                    <div class="sbtn">
                                                        <a href="{{ route('updateApplicationForm', ['id' => $application->id]) }}"
                                                            class="btn btn-danger btn-sm"><strong>{{ trans('app.rejected') }}</strong></a>
                                                    </div>
                                                    @if ($application->rejection_reason)
                                                        <p style="padding-top: 5px;">{{ trans('app.reason') }} :
                                                            {{ $application->rejection_reason }}</p>
                                                    @endif
                                                @else
                                                    <div class="sbtn">
                                                        <a href="{{ route('updateApplicationForm', ['id' => $application->id]) }}"
                                                            class="btn btn-primary btn-sm"><strong>{{ trans('app.unknown_status') }}</strong></a>
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <a href="#" class="log-link"
                                                        onclick="showLogs({{ $application->id }})">
                                                        Log
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">{{ trans('app.no_records_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="me-2">
                                            @lang('app.page') <strong>{{ $applications->currentPage() }}</strong>
                                            @lang('app.of') <strong>{{ $applications->lastPage() }}</strong>
                                        </span>
                                    </div>
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item {{ $applications->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $applications->url(1) }}&status={{ $statusFilter }}&per_page={{ $perPage }}"
                                                    title="@lang('app.first')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-double-left"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="page-item {{ $applications->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $applications->previousPageUrl() }}&status={{ $statusFilter }}&per_page={{ $perPage }}"
                                                    title="@lang('app.prev')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-left"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
                                                <li
                                                    class="page-item {{ $page == $applications->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $url }}&status={{ $statusFilter }}&per_page={{ $perPage }}">
                                                        {{ $page }}
                                                    </a>
                                                </li>
                                            @endforeach
                                            <li class="page-item {{ !$applications->hasMorePages() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $applications->nextPageUrl() }}&status={{ $statusFilter }}&per_page={{ $perPage }}"
                                                    title="@lang('app.next')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-right"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="page-item {{ !$applications->hasMorePages() ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $applications->url($applications->lastPage()) }}&status={{ $statusFilter }}&per_page={{ $perPage }}"
                                                    title="@lang('app.last')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-double-right"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
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

            // function changePerPage() {
            //     const perPage = document.getElementById('perPageSelect').value;
            //     const url = new URL(window.location.href);
            //     const statusFilter = url.searchParams.get('status') || '';
            //     url.searchParams.set('page', 1);
            //     url.searchParams.set('per_page', perPage);
            //     if (statusFilter) {
            //         url.searchParams.set('status', statusFilter);
            //     }
            //     window.location.href = url.toString();
            // }
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
            @foreach ($applications as $application)
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
                    // Check if there's a rejection that would affect admin staff status
                    const hasRejection = logs.some(log =>
                        log.user_type === 'admin_approver' && log.status_to === 'rejected'
                    );

                    // Add a system note if there's a rejection that affects status display
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

                    // Sort logs by date in descending order (newest first)
                    sortedLogs.sort((a, b) => new Date(b.action_at) - new Date(a.action_at));

                    // Display all logs in chronological order (newest first)
                    sortedLogs.forEach(function(log) {
                        const userTypeBadge = log.user_type === 'admin_staff' ? 'user-type-staff' :
                            log.user_type === 'admin_approver' ? 'user-type-approver' : 'user-type-staff';

                        const actionDate = new Date(log.action_at).toLocaleString();
                        const displayUserType = log.user_type === 'admin_staff' ? 'Penyedia' :
                            log.user_type === 'admin_approver' ? 'Pelulus' :
                            log.user_type === 'applicant' ? 'Pemohon' :
                            log.user_type.toUpperCase();

                        // const formattedAction = formatAction(log.action);
                        const formattedAction = actionStatusTranslations[log.action] || 
                       actionStatusTranslations[log.action?.toLowerCase()] ||
                       actionStatusTranslations[log.status_to] || 
                       actionStatusTranslations[log.status_from] || 
                       log.action;

                        // Special formatting for status changes
                        let statusDisplay = '';
                        if (log.status_from || log.status_to) {
                            let fromStatus = log.status_from || 'Belum Terima';
                            let toStatus = log.status_to || 'Belum Terima';

                            // Format status for display
                            // fromStatus = fromStatus === 'pending' ? 'Dalam Proses' : fromStatus;
                            // toStatus = toStatus === 'pending' ? 'Dalam Proses' : toStatus;
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
                            // Add other common remarks here
                        };
                        
                        let remarksDisplay = '';
                        if (log.remarks && log.remarks.trim() !== '') {
                            const translatedRemark = remarkTranslations[log.remarks.trim()] || log.remarks;
                            remarksDisplay = `<div class="mt-2"><strong>Nota:</strong> ${translatedRemark}</div>`;
                        }

                        // Format remarks with special handling for empty remarks
                        // let remarksDisplay = '';
                        // if (log.remarks && log.remarks.trim() !== '') {
                        //     remarksDisplay = `<div class="mt-2"><strong>Remarks:</strong> ${log.remarks}</div>`;
                        // }

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
    @endsection
