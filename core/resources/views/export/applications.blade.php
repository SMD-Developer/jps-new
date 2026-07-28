<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width:100%;
            border-collapse: collapse;
        }

        th {
            background:#f2f2f2;
            font-weight:bold;
        }

        th, td {
            border:1px solid #000;
            padding:5px;
            text-align:center;
        }

        .left {
            text-align:left;
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

    </style>
</head>

<body>
    <h3 style="text-align:center;">
        Permohonan Baru
    </h3>

    <table>
        <thead>
            <tr>
                <th>Bil</th>
                <th>Tarikh</th>
                <th>No Rujukan</th>
                <th>Jenis Akaun</th>
                <th>Jenis Permohonan</th>
                <th>Nama Pemohon</th>
                <th>Lot/PT</th>
                <th>Jumlah Caruman (RM)</th>
                <th>Status Penyedia</th>
                <th>Status Pelulus</th>
                <th>Status Keseluruhan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $key=>$application)                
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
                        
                        // Check if approver returned to staff after reapplication
                        $approverReturnAfterReapply = $logsAfterReapply
                            ->where('user_type', 'admin_approver')
                            ->where('status_to', 'returned_to_staff')
                            ->first();
                        
                        // Check if approver rejected after reapplication (old style)
                        $approverRejectionAfterReapply = $logsAfterReapply
                            ->where('user_type', 'admin_approver')
                            ->where('status_to', 'rejected')
                            ->first();
                        
                        if ($approverReturnAfterReapply) {
                            // Approver returned to staff - check if staff has acted after return
                            $staffActionAfterReturn = $logsAfterReapply
                                ->where('user_type', 'admin_staff')
                                ->where('created_at', '>', $approverReturnAfterReapply->created_at)
                                ->first();
                            
                            if ($staffActionAfterReturn) {
                                // Staff has acted after return
                                $displayStaffStatus = $staffActionAfterReturn;
                                
                                if ($staffActionAfterReturn->status_to == 'approved') {
                                    // Staff approved again - approver is pending
                                    $displayApproverStatus = (object) [
                                        'status_to' => 'pending',
                                        'additional_data' => ['performed_by' => 'Sistem'],
                                        'is_auto_status' => true,
                                    ];
                                } else {
                                    // Staff rejected
                                    $displayApproverStatus = $approverReturnAfterReapply;
                                }
                            } else {
                                // Staff hasn't acted yet after return - show pending
                                $displayStaffStatus = (object) [
                                    'status_to' => 'pending',
                                    'additional_data' => ['performed_by' => 'Sistem'],
                                    'is_auto_status' => true,
                                    'is_waiting_staff_action' => true,
                                ];
                                
                                $displayApproverStatus = (object) [
                                    'status_to' => 'na',
                                    'additional_data' => ['performed_by' => 'Sistem'],
                                    'is_auto_status' => true,
                                ];
                            }
                        } elseif ($approverRejectionAfterReapply) {
                            // Old style approver rejection - staff should be pending until they act
                            $staffActionAfterRejection = $logsAfterReapply
                                ->where('user_type', 'admin_staff')
                                ->where('created_at', '>', $approverRejectionAfterReapply->created_at)
                                ->first();
                            
                            if ($staffActionAfterRejection) {
                                // Staff has acted after rejection
                                $displayStaffStatus = $staffActionAfterRejection;
                                
                                if ($staffActionAfterRejection->status_to == 'approved') {
                                    // Staff approved again - approver is pending
                                    $displayApproverStatus = (object) [
                                        'status_to' => 'pending',
                                        'additional_data' => ['performed_by' => 'Sistem'],
                                        'is_auto_status' => true,
                                    ];
                                } else {
                                    // Staff rejected
                                    $displayApproverStatus = $approverRejectionAfterReapply;
                                }
                            } else {
                                // Staff hasn't acted yet after rejection - show pending
                                $displayStaffStatus = (object) [
                                    'status_to' => 'pending',
                                    'additional_data' => ['performed_by' => 'Sistem'],
                                    'is_auto_status' => true,
                                    'is_override' => true,
                                ];
                                
                                $displayApproverStatus = $approverRejectionAfterReapply;
                            }
                        } else {
                            // No rejection after reapply - normal flow
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
                        }
                    } else {
                        // Handle normal application flow
                        
                        // 1. Check if approver returned to staff (new two-step rejection)
                        $latestApproverReturnToStaff = $allLogs->where('user_type', 'admin_approver')
                                                                ->where('status_to', 'returned_to_staff')
                                                                ->first();
                        
                        if ($latestApproverReturnToStaff) {
                            // Check if staff has acted after the return
                            $staffActionAfterReturn = $allLogs
                                ->where('user_type', 'admin_staff')
                                ->where('created_at', '>', $latestApproverReturnToStaff->created_at)
                                ->first();
                            
                            if ($staffActionAfterReturn) {
                                // Staff has acted - show their action
                                $displayStaffStatus = $staffActionAfterReturn;
                                
                                // If staff approved after return, approver status is pending
                                if ($staffActionAfterReturn->status_to == 'approved') {
                                    $displayApproverStatus = (object) [
                                        'status_to' => 'pending',
                                        'additional_data' => ['performed_by' => 'Sistem'],
                                        'is_auto_status' => true,
                                    ];
                                } else {
                                    // Staff rejected - show the return status
                                    $displayApproverStatus = $latestApproverReturnToStaff;
                                }
                            } else {
                                // Staff hasn't acted yet - show pending for staff
                                $displayStaffStatus = (object) [
                                    'status_to' => 'pending',
                                    'additional_data' => ['performed_by' => 'Sistem'],
                                    'is_auto_status' => true,
                                    'is_waiting_staff_action' => true,
                                ];
                                
                                // Show "Belum Terima" for approver (reset status)
                                $displayApproverStatus = (object) [
                                    'status_to' => 'na',
                                    'additional_data' => ['performed_by' => 'Sistem'],
                                    'is_auto_status' => true,
                                ];
                            }
                        }
                        // 2. Check for old-style approver rejection (backward compatibility)
                        elseif ($latestApproverRejection = $allLogs->where('user_type', 'admin_approver')
                                                                    ->where('status_to', 'rejected')
                                                                    ->first()) {
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
                        // 3. If no rejection, check for staff approval
                        elseif ($latestStaffApproval = $allLogs->where('user_type', 'admin_staff')
                                                                ->where('status_to', 'approved')
                                                                ->first()) {
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
                        // 4. Default case - show latest status for each
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
                
                <tr>
                    <td>
                        {{ $key+1 }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}
                    </td>
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
                                    4 => 'Perunding'
                                ];
                                
                                $clientType = $accountTypes[$application->client->accountType] ?? 'N/A';
                                $applicantType = $accountTypes[$application->applicant_type] ?? null;
                                
                                if ($applicantType && $applicantType != $clientType) {
                                    echo $clientType . '-' . $applicantType;
                                } else {
                                    echo $clientType;
                                }
                            @endphp
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
                    <td>{{ strtoupper($application->applicant) }}</td>
                    <td>{{ strtoupper($application->land_lot . ', ' . $application->land_area . ', ' . ($application->landDivision->mukim ?? '') . ', DAERAH ' . ($application->landDistrict->daerah ?? '')) }}</td>
                    <td>{{ $application->client ? number_format($application->final_amount, 2) : 'N/A' }}</td>  
                    <td class="status-column">
                        @if ($displayStaffStatus)
                            <span class="badge status-{{ $displayStaffStatus->status_to ?? 'na' }}">
                                @switch($displayStaffStatus->status_to ?? '')
                                    @case('pending')
                                        {{ trans('app.in_process') }}
                                        @break
                                    @case('approved')
                                        {{ trans('app.passed') }}
                                        @break
                                    @case('rejected')
                                        {{ trans('Ditolak') }}
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

                                // Show a note if this is an override status or waiting for staff action
                                $overrideNote = '';
                                if (isset($displayStaffStatus->is_waiting_staff_action)) {
                                    $overrideNote = ' (Menunggu tindakan penyedia)';
                                } elseif (isset($displayStaffStatus->is_override)) {
                                    $overrideNote = ' (Status dikemaskini selepas penolakan)';
                                }
                            @endphp
                            <small class="text-info performed-by">Oleh -
                                {{ ucfirst($performedBy) }}{{ $overrideNote }}</small>
                        @else
                            <span class="badge status-na">N/A</span>
                        @endif
                    </td>
                    <td class="status-column">
                        @if ($displayApproverStatus)
                            <span class="badge status-{{ $displayApproverStatus->status_to ?? 'na' }}">
                                @switch($displayApproverStatus->status_to ?? '')
                                    @case('pending')
                                        @if(isset($displayApproverStatus->is_auto_status))
                                        Dalam Proses
                                        @else
                                            {{ trans('app.in_process') }}
                                        @endif
                                        @break
                                    @case('approved')
                                        {{ trans('app.passed') }}
                                        @break
                                    @case('rejected')
                                        {{ trans('Ditolak') }}
                                        @break
                                    @case('returned_to_staff')
                                        Dikembalikan ke Penyedia
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
                                    <span class="badge bg-warning text-dark d-flex align-items-center">
                                        <i class="bi bi-hourglass-split me-2"></i>
                                        {{ trans('app.completed') }}
                                    </span>
                                </a>
                                <small class="ms-2 text-muted">{{trans('app.click_to_view_bill')}}</small>
                            </div>
                        @elseif ($application->status == 'pending' || $application->status == 'returned_to_staff')
                            <div class="sbtn">
                                <a href="#" class="btn btn-primary btn-sm">
                                    <strong>
                                        @if($application->status == 'returned_to_staff')
                                            Dikembalikan - Tindakan Diperlukan
                                        @else
                                            {{trans('app.in_process')}}
                                        @endif
                                    </strong>
                                </a>
                            </div>
                            
                            {{-- Show approver's rejection reason if returned to staff --}}
                            @if ($application->status == 'returned_to_staff' && !empty($application->approver_rejection_reason))
                                <div class="mt-2" style="color: #d9534f; font-weight:500;">
                                    <strong>Alasan Pelulus:</strong> {{ $application->approver_rejection_reason }}
                                </div>
                            @endif
                            
                        @elseif ($application->status == 'rejected')
                            <div class="sbtn">
                                <a href="{{ route('updateApplicationForm', ['id' => $application->id]) }}"
                                    class="btn btn-danger btn-sm"><strong>{{ trans('Ditolak') }}</strong></a>
                            </div>

                            {{-- Show rejection reason --}}
                            @if (!empty($application->rejection_reason))
                                <div class="mt-2" style="color: #d9534f; font-weight:500;">
                                    <strong>Alasan Penyedia:</strong> {{ $application->rejection_reason }}
                                </div>
                            @endif

                        @else
                            <div class="sbtn">
                                <a href="{{ route('updateApplicationForm', ['id' => $application->id]) }}"
                                    class="btn btn-primary btn-sm"><strong>{{ trans('app.unknown_status') }}</strong></a>
                            </div>
                        @endif
                        <div class="mt-2">
                            <a href="#" class="log-link" onclick="showLogs({{ $application->id }})">
                                Log
                            </a>
                        </div>
                    </td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>