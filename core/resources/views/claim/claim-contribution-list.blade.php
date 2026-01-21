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
    .badge-lg-text {
        font-size: 0.95rem;   
        padding: 0.45em 0.8em; 
    }
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
        text-transform: capitalize;
        color: #fff;
        white-space: nowrap; 
        line-height: 1;  
    }

    /* Status colors */
    .status-rejected {
        background-color: #dc3545; 
    }

    .status-approved {
        background-color: #28a745; 
    }

    .status-pending {
        background-color: #17a2b8; 
        color: #fff;
    }

    .status-inprocess {
        background-color: #17a2b8; 
        color: #000;
    }

    .status-unknown {
        background-color: #6c757d; 
    }

    

</style>
<title>{{ trans('app.claim_contribution') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('Permohonan Baru') }}</h5>
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
                                <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">
                                        <strong>{{ trans('app.reset') }}</strong>
                                </a>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3 mx-3">
                                <!-- Per Page Select -->
                                <div class="d-flex align-items-center">
                                    <label for="perPageSelect" class="me-2">@lang('app.show') :&nbsp;</label>
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

                                <!-- Status Select -->
                                <div class="d-flex align-items-center">
                                    <label for="status" class="me-2">{{ trans('app.status') }}:</label>
                                    <select id="status" class="form-select form-select-sm form-control form-control-sm" style="width: auto">
                                        <option value="" selected disabled>{{ trans('app.select_status') }}</option>
                                        @foreach ($statuses as $key => $label)
                                            <option value="{{ $key }}" 
                                                {{ request('status') == $key ? 'selected' : '' }}>
                                                {{ $key == 'pending' ? 'Dalam Proses' : $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

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
                                        <th><strong>Catatan</strong></th>
                                        <th><strong>{{trans('app.total_payment')}} (RM)</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->uploade_date)) }}</td>
                                            <td>
                                                @php
                                                    $clientType = '';
                                                    $account_types = '';

                                                    if ($item->client) {
                                                        switch ($item->client->accountType) {
                                                            case 1: $clientType = 'Individu'; break;
                                                            case 2: $clientType = 'Pemaju'; break;
                                                            case 3: $clientType = 'Agensi Kerajaan'; break;
                                                            case 4: $clientType = 'Perunding'; break;
                                                            default: $clientType = 'Unknown';
                                                        }
                                                    }

                                                    switch ($item->account_types) {
                                                        case 1: $account_types = 'Individu'; break;
                                                        case 2: $account_types = 'Pemaju'; break;
                                                        case 3: $account_types = 'Agensi Kerajaan'; break;
                                                        case 4: $account_types = 'Perunding'; break;
                                                    }

                                                    if ($account_types && $clientType && $account_types != $clientType) {
                                                        echo ucfirst(strtolower($clientType)) . '-' . ucfirst(strtolower($account_types));
                                                    } else {
                                                        echo ucfirst(strtolower($clientType ?: $account_types ?: 'N/A'));
                                                    }
                                                @endphp
                                            </td>



                                            <td>
                                                @php
                                                    if (!empty($item->reapplication_count) && $item->reapplication_count > 0 && !empty($item->last_reapplied_at)) {
                                                        $applicationType = trans('app.reapply');
                                                    } else {
                                                        $applicationType = trans('app.new');
                                                    }
                                                @endphp

                                                {{ $applicationType }}
                                            </td>

                                            <td>{{ strtoupper($item->applicant) }}</td>
                                            <td>{{ $item->land_lot }}, {{ $item->land_area }},
                                                {{ $item->landDivision->mukim ?? '' }}, Daerah
                                                {{ $item->landDistrict->daerah ?? '' }}
                                            </td>
                                            <td>
                                                @if($item->status)
                                                    @php
                                                        switch($item->status) {
                                                            case 'rejected':
                                                                $badgeClass = 'status-badge status-rejected';
                                                                $badgeText = 'Ditolak';
                                                                break;

                                                            case 'check_query':
                                                                $badgeClass = 'status-badge status-rejected';
                                                                $badgeText = 'Kuiri';
                                                                break;

                                                            case 'approve_paid':
                                                                $badgeClass = 'status-badge status-approved';
                                                                $badgeText = 'Diluluskan';
                                                                break;

                                                            case 'pending':
                                                                $badgeClass = 'status-badge status-pending';
                                                                $badgeText = 'Dalam Proses';
                                                                break;

                                                            case 'approve_payment_in_process':
                                                                $badgeClass = 'status-badge status-inprocess';
                                                                $badgeText = 'Dalam Proses';
                                                                break;

                                                            default:
                                                                $badgeClass = 'status-badge status-unknown';
                                                                $badgeText = 'Tidak Diketahui';
                                                        }
                                                    @endphp
                                                    <span class="{{ $badgeClass }}">
                                                        {{ $badgeText }}
                                                    </span>
                                                    
                                                    @if($item->status === 'rejected' && !empty($item->rejected_reason))
                                                        <div class="mt-2 text-danger">
                                                            <strong>Alasan:</strong> {{ $item->rejected_reason }}
                                                            @if(!empty($item->rejected_by))
                                                                <br>
                                                                <small class="text-muted">
                                                                    Ditolak oleh: <strong>{{ $item->rejected_by }}</strong>
                                                                    @if(!empty($item->rejected_by_role))
                                                                        <span class="badge bg-secondary ms-1">
                                                                            {{ $item->rejected_by_role == 'admin_staff' ? 'Penyedia' : 'Pelulus' }}
                                                                        </span>
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="status-badge status-unknown">N/A</span>
                                                @endif

                                                {{-- Only show forward information if NOT rejected or approved/paid --}}
                                                @if(!in_array($item->status, ['rejected', 'approve_paid']))
                                                    @php
                                                        $showFinance = $item->send_to_finance == 1;
                                                        $showApprover = $item->sent_to_approver == 1;
                                                        
                                                        // If both exist, compare timestamps to show only the most recent
                                                        if ($showFinance && $showApprover) {
                                                            $financeTime = $item->sent_to_finance_at ? \Carbon\Carbon::parse($item->sent_to_finance_at) : null;
                                                            $approverTime = $item->sent_to_approver_at ? \Carbon\Carbon::parse($item->sent_to_approver_at) : null;
                                                            
                                                            if ($financeTime && $approverTime) {
                                                                // Show only the most recent one
                                                                if ($financeTime->gt($approverTime)) {
                                                                    $showApprover = false;
                                                                } else {
                                                                    $showFinance = false;
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    @if($showFinance)
                                                        <div class="mt-3 p-2 border-start border-3 border-primary bg-light rounded">
                                                            <small class="text-secondary d-block mb-1">Dihantar ke Kewangan oleh:</small>
                                                            <strong class="text-dark">{{ $item->sent_by ?? 'N/A' }}</strong><br>
                                                            <small class="text-muted">
                                                                {{ $item->sent_to_finance_at 
                                                                    ? \Carbon\Carbon::parse($item->sent_to_finance_at)->format('d/m/Y h:i A') 
                                                                    : '-' }}
                                                            </small>
                                                        </div>
                                                    @endif

                                                    @if($showApprover)
                                                        <div class="mt-3 p-2 border-start border-3 border-primary bg-light rounded">
                                                            <small class="text-secondary d-block mb-1">Dihantar ke Pelulus oleh:</small>
                                                            <strong class="text-dark">{{ $item->sent_to_approver_by ?? 'N/A' }}</strong><br>
                                                            <small class="text-muted">
                                                                {{ $item->sent_to_approver_at 
                                                                    ? \Carbon\Carbon::parse($item->sent_to_approver_at)->format('d/m/Y h:i A') 
                                                                    : '-' }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                             <td>
                                                @if ($item->status == 'rejected')
                                                    <a href="{{ route('claim.application.reapply', $item->id) }}" class="btn-reapply">
                                                        Mohon semula
                                                    </a>

                                                @elseif ($item->status == 'check_query')
                                                    {{-- ✅ Show query date and remarks for check_query status --}}
                                                    @if(!empty($item->query_date))
                                                        <div class="mb-1">
                                                            <small class="text-muted">
                                                                <strong>Tarikh Kuiri:</strong>
                                                                {{ \Carbon\Carbon::parse($item->query_date)->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                    @if(!empty($item->query_remarks))
                                                        <div>
                                                            <small class="text-muted">
                                                                <strong>{{ trans('app.reason') }}:</strong> <strong>{{ $item->query_remarks }}</strong>
                                                            </small>
                                                        </div>
                                                    @endif

                                                @elseif ($item->status == 'approve_paid')
                                                    {{-- ✅ Show verification date, EFT number & payment remarks when approved and paid --}}
                                                    @if(!empty($item->verified_date) || !empty($item->eft_no) || !empty($item->payment_remarks))
                                                        <div class="mb-1">
                                                            @if(!empty($item->verified_date))
                                                                <small class="text-muted">
                                                                    <strong>Tarikh Pembayaran:</strong>
                                                                    {{ \Carbon\Carbon::parse($item->verified_date)->format('d/m/Y') }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                        @if(!empty($item->eft_no))
                                                            <div class="mb-1">
                                                                <small class="text-muted">
                                                                    <strong>No. EFT:</strong>
                                                                    <strong>{{ $item->eft_no }}</strong>
                                                                </small>
                                                            </div>
                                                        @endif
                                                        @if(!empty($item->payment_remarks))
                                                            <div>
                                                                <small class="text-muted">
                                                                    <strong>Catatan:</strong>
                                                                    <strong>{{ $item->payment_remarks }}</strong>
                                                                </small>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <small class="text-muted">Tiada maklumat pembayaran.</small>
                                                    @endif

                                                @elseif ($item->send_to_finance == 1 && $item->status != 'approve_paid')
                                                    {{-- ✅ Show only visit date --}}
                                                    @if(!empty($item->visit_date))
                                                        <div class="mb-1">
                                                            <small class="text-muted">
                                                                <strong>Tarikh Kemaskini:</strong>
                                                                {{ \Carbon\Carbon::parse($item->visit_date)->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                    @else
                                                        {{-- ❌ If no visit_date, show the original finance message --}}
                                                        @if(!empty($item->sent_to_finance_at))
                                                            <div class="mb-1">
                                                                <small class="text-muted">
                                                                    Tarikh Kelulusan pada: 
                                                                    <strong>{{ \Carbon\Carbon::parse($item->sent_to_finance_at)->format('d/m/Y') }}</strong>
                                                                </small>
                                                            </div>
                                                        @endif
                                                        <small>
                                                            Sila hadir ke <strong>Jabatan Pengairan dan Saliran Negeri Selangor, Bahagian Kewangan</strong> dalam masa 7 hari bekerja.
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#readMoreModal" class="text-primary">Baca Selanjutnya</a>
                                                        </small>
                                                    @endif
                                                @endif
                                            </td>

                                            <td>{{$item->payment_amount}}</td>
                                            <td>
                                                @if ($financeStaff)
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
                                                       class="btn btn-sm {{ $item->send_to_finance == 1 ? 'btn-success' : 'btn-primary' }}" 
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
        <div class="modal fade" id="readMoreModal" tabindex="-1" aria-labelledby="readMoreModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="readMoreModalLabel">Maklumat Lanjut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                <div class="modal-body">
                    <p class="mb-3">
                        <strong>Sila hadir ke </strong> <strong>Kaunter Pembayaran Caruman Parit, Jabatan Pengairan dan Saliran Negeri Selangor, Tingkat 5, Podium Selatan, Bangunan Sultan Salahuddin Abdul Aziz Shah dalam masa <strong>7 hari bekerja</strong> dari tarikh 
                        <span class="text fw-bold">kelulusan permohonan tuntutan pulang balik</span>
                        bayaran pada waktu operasi kaunter seperti berikut:
                    </p>

                    <div class="ms-3">
                    <h6 class="fw-bold text-decoration-underline">KAUNTER CARUMAN PARIT</h6>

                        <p class="mb-1"><strong>Hari Isnin – Khamis:</strong></p>
                        <ul class="mb-2">
                            <li>8.30 pagi – 12.30 tengahari</li>
                            <li>2.30 petang – 3.30 petang</li>
                        </ul>

                        <p class="mb-1"><strong>Hari Jumaat:</strong></p>
                        <ul class="mb-2">
                            <li>8.30 pagi – 12.00 tengahari</li>
                            <li>2.45 petang – 3.30 petang</li>
                        </ul>

                        <p class="mb-1"><strong>Rehat:</strong></p>
                        <ul class="mb-3">
                            <li>12.30 tengahari – 2.30 petang (Isnin – Khamis)</li>
                            <li>12.00 tengahari – 2.45 petang (Jumaat)</li>
                        </ul>

                                                <!-- Added section -->
                        <div class="border-top pt-3">
                            <h6 class="fw-bold text-decoration-underline text-dark">
                                Sila bawa bersama dokumen seperti berikut:
                            </h6>
                            <ol class="mt-2">
                                <li>Surat permohonan tuntutan pulang balik</li>
                                <li>Salinan Kad Pengenalan pemohon</li>
                                <li>Penyata bank individu / pemaju</li>
                                <li>Resit bayaran asal / KEW38 asal</li>
                                <li>Surat Akuan Sumpah / Majistret / Mahkamah / Pesuruhjaya (sekiranya dokumen/ resit asal hilang)</li>
                                <li>Pendaftaran Syarikat (SSM/ROS/ROC/ROB/JMB) dan salinan Kad Pengenalan (terkini) semua "Board Of Directors"</li>
                            </ol>
                        </div>

                    </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {


                $('#status').on('change', function() {
                    var district = $('#district').val();
                    var division = $('#division').val();
                    var lot = $('#lot').val();
                    var status = $(this).val();
                    var per_page = "{{ $perPage }}";
                    var queryParams = [];
                    
                    if (district) queryParams.push('district=' + district);
                    if (division) queryParams.push('division=' + division);
                    if (lot) queryParams.push('lot=' + encodeURIComponent(lot));
                    if (status) queryParams.push('status=' + status);
                    if (per_page) queryParams.push('per_page=' + per_page);
                    
                    window.location.href = window.location.pathname + '?' + queryParams.join('&');
                });

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
        $(document).ready(function() {
            function performSearch() {
                let params = new URLSearchParams();
                
                let search = $('#search').val().trim();
                let district = $('#district').val();
                let division = $('#division').val();
                let lot = $('#lot').val().trim();
                let status = $('#status').val();
                let perPage = $('#perPageSelect').val();

                if (search) params.append('search', search);
                if (district) params.append('district', district);
                if (division) params.append('division', division);
                if (lot) params.append('lot', lot);
                if (status && status !== 'all') params.append('status', status);
                if (perPage) params.append('per_page', perPage);

                window.location.href = '{{ url()->current() }}?' + params.toString();
            }

            $('.search-btn').on('click', function(e) {
                e.preventDefault();
                performSearch();
            });


            $('#search, #lot').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    performSearch();
                }
            });


            $('#status, #perPageSelect, #division').on('change', function() {
                performSearch();
            });

            $('#district').on('change', function() {
                const distId = $(this).val();
                $('#division').html('<option value="">Loading...</option>');

                if (distId) {
                    $.ajax({
                        url: `/division/${distId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">{{ trans('app.select_division') }}</option>';
                            data.forEach(mukin => {
                                options += `<option value="${mukin.idmukim}">${mukin.mukim_code + ' - ' + mukin.mukim}</option>`;
                            });
                            $('#division').html(options);
                            
                            // Restore selected division if it exists
                            var selectedDivision = "{{ request('division') }}";
                            if (selectedDivision) {
                                $('#division').val(selectedDivision);
                            }
                        },
                        error: function() {
                            $('#division').html('<option value="">Error loading mukim</option>');
                        }
                    });
                } else {
                    $('#division').html('<option value="">{{ trans('app.select_division') }}</option>');
                }
            });


            var selectedDistrict = "{{ request('district') }}";
            if (selectedDistrict) {
                $('#district').val(selectedDistrict).trigger('change');
            }

            $('.sbtn a.btn-primary').on('click', function(e) {
                var href = $(this).attr('href');
                if (href) {
                    window.location.href = href;
                }
            });
        });
    </script>
@endsection