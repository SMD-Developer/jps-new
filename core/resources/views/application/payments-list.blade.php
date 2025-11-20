@extends('app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
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
    h2, h3, h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Payment method badge styling */
    .payment-method-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .method-online {
        background-color: #e3f2fd;
        color: #1976d2;
        border: 1px solid #bbdefb;
    }

    .method-offline {
        background-color: #fff3e0;
        color: #f57c00;
        border: 1px solid #ffcc02;
    }

    .method-pending {
        background-color: #f3e5f5;
        color: #7b1fa2;
        border: 1px solid #ce93d8;
    }

    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-failed {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-in-review {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    /* Table styling */
    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    table.table thead th {
        background-color: #f8f9fa;
        font-weight: 700;
        vertical-align: middle;
    }

    /* Button styling */
    .btn-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
        line-height: 1;
    }

    .btn-view-receipt {
        background: #1991EE !important;
        border: 1px solid #1991EE;
        color: white !important;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .btn-view-receipt:hover {
        background: #1570c7 !important;
        border: 1px solid #1570c7;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 1rem !important;
        }
    }
</style>

<title>{{ trans('Pembayaran Selesai') }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-money-bill"></i> {{ trans('Pembayaran Selesai') }}</h5>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- First Row: Filters -->
                        <div class="d-flex justify-content-between align-items-center mb-3 mx-3">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Per Page Selector -->
                                <div class="d-flex align-items-center">
                                    <label for="perPageSelect" class="me-2">@lang('app.show') : </label>
                                    <select id="perPageSelect" class="form-select form-select-sm" 
                                            onchange="changePerPage()" style="width: auto">
                                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                        <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div class="d-flex align-items-center">
                                    <label for="statusFilter" class="me-2">{{ trans('app.status') }} :</label>
                                    <select id="statusFilter" class="form-select form-select-sm"
                                        onchange="changeStatusFilter()" style="width: auto; min-width: 150px;">
                                        <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>
                                            @lang('app.all_payments')
                                        </option>
                                        <option value="completed" {{ ($statusFilter ?? 'all') == 'completed' ? 'selected' : '' }}>
                                            @lang('app.completed')
                                        </option>
                                        <option value="pending" {{ ($statusFilter ?? 'all') == 'pending' ? 'selected' : '' }}>
                                            @lang('app.pending')
                                        </option>
                                        <option value="failed" {{ ($statusFilter ?? 'all') == 'failed' ? 'selected' : '' }}>
                                            @lang('app.failed')
                                        </option>
                                        <option value="in_review" {{ ($statusFilter ?? 'all') == 'in_review' ? 'selected' : '' }}>
                                            @lang('app.in_review')
                                        </option>
                                    </select>
                                </div>

                                <!-- Method Filter -->
                                <div class="d-flex align-items-center">
                                    <label for="methodFilter" class="me-2">{{ trans('app.method') }} :</label>
                                    <select id="methodFilter" class="form-select form-select-sm" 
                                            onchange="changeMethodFilter()" style="width: auto; min-width: 150px;">
                                        <option value="all" {{ ($methodFilter ?? 'all') == 'all' ? 'selected' : '' }}>
                                            @lang('app.all_methods')
                                        </option>
                                        <option value="B2B" {{ ($methodFilter ?? 'all') == 'B2B' ? 'selected' : '' }}>B2B</option>
                                        <option value="B2C" {{ ($methodFilter ?? 'all') == 'B2C' ? 'selected' : '' }}>B2C</option>
                                        <option value="EFT" {{ ($methodFilter ?? 'all') == 'EFT' ? 'selected' : '' }}>EFT</option>
                                        <option value="Cheque" {{ ($methodFilter ?? 'all') == 'Cheque' ? 'selected' : '' }}>
                                            @lang('app.cheque')
                                        </option>
                                        <option value="Bank Transfer" {{ ($methodFilter ?? 'all') == 'Bank Transfer' ? 'selected' : '' }}>
                                            Bank Transfer
                                        </option>
                                        <option value="BAUCAR BAYARAN" {{ ($methodFilter ?? 'all') == 'BAUCAR BAYARAN' ? 'selected' : '' }}>
                                            BAUCAR BAYARAN
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Search Box - Right End -->
                            <form method="GET" class="d-flex align-items-center">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                                <input type="hidden" name="status_filter" value="{{ $statusFilter ?? 'all' }}">
                                <input type="hidden" name="method_filter" value="{{ $methodFilter ?? 'all' }}">
                                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                                <input type="hidden" name="date_to" value="{{ request('date_to') }}">

                                <div class="input-group" style="max-width: 300px;">
                                    <input type="search" name="q" value="{{ request('q') }}"
                                        placeholder="@lang('app.search')..."
                                        class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @if (request('q'))
                                        <a href="{{ request()->url() }}?per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}"
                                            class="btn btn-sm btn-outline-secondary" title="Clear search">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Second Row: Date Range Filter -->
                        <div class="d-flex align-items-center mx-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <label for="dateFrom" class="me-2" style="white-space: nowrap;">
                                    {{ trans('app.date') }}:
                                </label>
                                <input type="date" id="dateFrom" class="form-control form-control-sm" 
                                    value="{{ request('date_from') }}" style="width: 150px;">
                                <span>-</span>
                                <input type="date" id="dateTo" class="form-control form-control-sm" 
                                    value="{{ request('date_to') }}" style="width: 150px;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="applyDateFilter()">
                                    <i class="fa fa-filter"></i> 
                                </button>
                                @if(request('date_from') || request('date_to'))
                                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                                            onclick="clearDateFilter()" title="Clear date filter">
                                        <i class="fa fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('Bil') }}</strong></th>
                                        <th style="width: 100px;"><strong>{{ trans('app.payment_date') }}</strong></th>
                                        <th><strong>{{ trans('app.reference_no') }}</strong></th>
                                        <th><strong>{{trans('Jenis Akaun')}}</strong></th>
                                        <th><strong>{{ trans('Jenis Pembayaran') }}</strong></th>
                                        <th><strong>{{ trans('Nama Pembayar') }}</strong></th>
                                        <th><strong>{{ trans('Lot/PT') }}</strong></th> 
                                        <th><strong>{{ trans('Jumlah Caruman') }} (RM)</strong></th>
                                        <th><strong>Mod Terimaan</strong></th>
                                        <th><strong>{{ trans('app.payment_method') }}</strong></th>
                                        <th><strong>{{ trans('ID Transaksi') }}</strong></th>
                                        <th><strong>{{ trans('app.payment_status') }}</strong></th>
                                        <th><strong>{{ trans('Untuk Tindakan') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($list as $payment)
                                        @php
                                            $application = $payment->application;
                                            
                                            // Determine payment method display
                                            $paymentMethod = '-';
                                            $methodClass = 'method-pending';

                                            if ($payment->method) {
                                                switch ($payment->method) {
                                                    case 'FPX_B2C':
                                                        $paymentMethod = 'B2C';
                                                        $methodClass = 'method-online';
                                                        break;
                                                    case 'FPX_B2B':
                                                        $paymentMethod = 'B2B';
                                                        $methodClass = 'method-online';
                                                        break;
                                                    case 'cheque':
                                                        $paymentMethod = 'Cheque';
                                                        $methodClass = 'method-offline';
                                                        break;
                                                    case 'bank_transfer':
                                                        $paymentMethod = 'Bank Transfer';
                                                        $methodClass = 'method-offline';
                                                        break;
                                                    case 'EFT':
                                                        $paymentMethod = 'EFT';
                                                        $methodClass = 'method-offline';
                                                        break;
                                                    default:
                                                        $paymentMethod = $payment->method;
                                                        $methodClass = 'method-online';
                                                }

                                                // Government agency override
                                                if ($application && $application->client && $application->client->accountType == 3) {
                                                    $paymentMethod = 'BAUCAR BAYARAN';
                                                    $methodClass = 'method-offline';
                                                }
                                            }

                                            // Determine status badge class
                                            $statusClass = 'status-pending';
                                            switch ($payment->payment_status) {
                                                case 'completed':
                                                    $statusClass = 'status-completed';
                                                    break;
                                                case 'failed':
                                                    $statusClass = 'status-failed';
                                                    break;
                                                case 'in_review':
                                                    $statusClass = 'status-in-review';
                                                    break;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $loop->iteration }}</td>
                                            <td>
                                                {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : 
                                                   ($payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('d M Y') : 'N/A') }}
                                            </td>
                                            <td>{{ $application->refference_no ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $clientType = '';
                                                    $applicantType = '';
                                                    
                                                    if ($application && $application->client) {
                                                        // Get client account type
                                                        switch ($application->client->accountType) {
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
                                                        switch ($application->applicant_type) {
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
                                                                $applicantType = 'Perunding';
                                                                break;
                                                        }
                                                        
                                                        // Display logic
                                                        if ($applicantType && $applicantType != $clientType) {
                                                            echo $clientType . ' - ' . $applicantType;
                                                        } else {
                                                            echo $clientType;
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @if($payment && in_array($payment->payment_type, ['reprint', 'third_party']))
                                                    <span class="badge bg-warning text-dark">Salinan Resit</span>
                                                @elseif($payment && $payment->payment_type && in_array($payment->payment_type, ['B2B', 'B2C']))
                                                    Caruman Parit
                                                @elseif($payment && $payment->payment_type)
                                                    <span class="badge bg-info text-dark">{{ ucfirst($payment->payment_type) }}</span>
                                                @else
                                                    Caruman Parit
                                                @endif
                                            </td>
                                            <td>{{ strtoupper($application->applicant ?? '-') }}</td>
                                            <td>
                                                {{ $application->land_lot ?? '' }}{{ $application->land_lot && $application->land_area ? ', ' : '' }}{{ $application->land_area ?? '' }}{{ ($application->land_lot || $application->land_area) && $application->landDivision ? ', ' : '' }}{{ $application->landDivision->mukim ?? '' }}{{ $application->landDivision && $application->landDistrict ? ', Daerah ' : '' }}{{ $application->landDistrict->daerah ?? '' }}
                                            </td>
                                            <td>{{ number_format($payment->amount ?? 0, 2) }}</td>
                                             <td>
                                                @if(in_array($paymentMethod, ['EFT', 'B2B', 'B2C']))
                                                    <span class="payment-method-badge method-offline">EFT</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="payment-method-badge {{ $methodClass }}">
                                                    {{ $paymentMethod }}
                                                </span>
                                            </td>
                                            <td>{{ $payment->transaction_id ?? '-' }}</td>
                                            <td>
                                                <span class="status-badge {{ $statusClass }}">
                                                    @if ($payment->payment_status == 'completed')
                                                        {{ trans('app.completed') }}
                                                    @elseif ($payment->payment_status == 'pending')
                                                        {{ trans('app.pending') }}
                                                    @elseif ($payment->payment_status == 'failed')
                                                        {{ trans('app.failed') }}
                                                    @elseif ($payment->payment_status == 'in_review')
                                                        {{ trans('app.in_review') }}
                                                    @else
                                                        {{ ucfirst($payment->payment_status ?? 'unknown') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                @if ($canApproverViewReciept && $payment && $payment->payment_status === 'completed')
                                                    <a href="{{ route('user_original_receipts', ['application_id' => $application->id, 'payment_uuid' => $payment->uuid]) }}" 
                                                       class="btn btn-view-receipt btn-sm">
                                                        <i class="fa fa-eye"></i> 
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <em>{{ trans('app.no_payments_found') }}</em>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="me-2">
                                        @lang('app.page') <strong>{{ $list->currentPage() }}</strong>
                                        @lang('app.of') <strong>{{ $list->lastPage() }}</strong>
                                    </span>
                                    <span class="text-muted">
                                        (@lang('app.total'): {{ $list->total() }} @lang('app.payments'))
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination mb-0">
                                        {{-- First Page --}}
                                        <li class="page-item {{ $list->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link"
                                                href="{{ $list->url(1) }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}{{ request('date_from') ? '&date_from='.request('date_from') : '' }}{{ request('date_to') ? '&date_to='.request('date_to') : '' }}{{ request('q') ? '&q='.request('q') : '' }}"
                                                title="@lang('app.first')">
                                                <i class="fas fa-angle-double-left"></i>
                                            </a>
                                        </li>

                                        {{-- Previous Page --}}
                                        <li class="page-item {{ $list->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link"
                                                href="{{ $list->previousPageUrl() }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}{{ request('date_from') ? '&date_from='.request('date_from') : '' }}{{ request('date_to') ? '&date_to='.request('date_to') : '' }}{{ request('q') ? '&q='.request('q') : '' }}"
                                                title="@lang('app.prev')">
                                                <i class="fas fa-angle-left"></i>
                                            </a>
                                        </li>

                                        {{-- Page Numbers (show max 5 pages) --}}
                                        @php
                                            $start = max($list->currentPage() - 2, 1);
                                            $end = min($start + 4, $list->lastPage());
                                            $start = max($end - 4, 1);
                                        @endphp
                                        
                                        @for ($page = $start; $page <= $end; $page++)
                                            <li class="page-item {{ $page == $list->currentPage() ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $list->url($page) }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}{{ request('date_from') ? '&date_from='.request('date_from') : '' }}{{ request('date_to') ? '&date_to='.request('date_to') : '' }}{{ request('q') ? '&q='.request('q') : '' }}">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endfor

                                        {{-- Next Page --}}
                                        <li class="page-item {{ !$list->hasMorePages() ? 'disabled' : '' }}">
                                            <a class="page-link"
                                                href="{{ $list->nextPageUrl() }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}{{ request('date_from') ? '&date_from='.request('date_from') : '' }}{{ request('date_to') ? '&date_to='.request('date_to') : '' }}{{ request('q') ? '&q='.request('q') : '' }}"
                                                title="@lang('app.next')">
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>

                                        {{-- Last Page --}}
                                        <li class="page-item {{ !$list->hasMorePages() ? 'disabled' : '' }}">
                                            <a class="page-link"
                                                href="{{ $list->url($list->lastPage()) }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}{{ request('date_from') ? '&date_from='.request('date_from') : '' }}{{ request('date_to') ? '&date_to='.request('date_to') : '' }}{{ request('q') ? '&q='.request('q') : '' }}"
                                                title="@lang('app.last')">
                                                <i class="fas fa-angle-double-right"></i>
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
    </section>

    <script>
        // Filter functions
        function changePerPage() {
            updateFilters();
        }

        function changeStatusFilter() {
            updateFilters();
        }

        function changeMethodFilter() {
            updateFilters();
        }

        function updateFilters() {
            const perPage = document.getElementById('perPageSelect').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const methodFilter = document.getElementById('methodFilter').value;
            const search = '{{ request("q") }}';
            const dateFrom = '{{ request("date_from") }}';
            const dateTo = '{{ request("date_to") }}';

            let url = window.location.pathname + '?per_page=' + perPage + 
                      '&status_filter=' + statusFilter + 
                      '&method_filter=' + methodFilter;

            if (search) url += '&q=' + encodeURIComponent(search);
            if (dateFrom) url += '&date_from=' + dateFrom;
            if (dateTo) url += '&date_to=' + dateTo;

            window.location.href = url;
        }

        function applyDateFilter() {
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const perPage = document.getElementById('perPageSelect').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const methodFilter = document.getElementById('methodFilter').value;
            const searchQuery = '{{ request("q") }}';
            
            let url = window.location.pathname + '?per_page=' + perPage + 
                      '&status_filter=' + statusFilter + 
                      '&method_filter=' + methodFilter;
            
            if (dateFrom) url += '&date_from=' + dateFrom;
            if (dateTo) url += '&date_to=' + dateTo;
            if (searchQuery) url += '&q=' + encodeURIComponent(searchQuery);
            
            window.location.href = url;
        }

        function clearDateFilter() {
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            applyDateFilter();
        }
    </script>
@endsection