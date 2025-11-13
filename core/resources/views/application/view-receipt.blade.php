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
    h2,
    h3,
    h4 {
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

    /* Smaller, compact buttons */
    .sbtn a {
        flex: 0 1 auto;
        max-width: 150px;
        padding: 4px 8px;
        font-size: 0.75rem;
        line-height: 1;
        background: #F1AA2A !important;
        border: 1px solid #F1AA2A;
        border-radius: 25px;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
        line-height: 1;
    }

    /* Edit button styling */
    .btn-edit {
        background: #28a745 !important;
        border: 1px solid #28a745;
        color: white !important;
    }

    .btn-edit:hover {
        background: #218838 !important;
        border: 1px solid #218838;
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

    /* Responsive design */
    @media (max-width: 768px) {
        .sbtn {
            justify-content: center;
        }

        .sbtn a {
            flex: 1 1 100%;
            max-width: none;
        }
    }

    /* Adjust input and dropdown widths for responsiveness */
    .form-label {
        white-space: nowrap;
    }

    #lot #district #division {
        max-width: 180px;
    }

    /* Responsive layout tweaks */
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

    /* Add extra styling for badges if needed */
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

    /* Payment details modal styling */
    .payment-details-modal {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .payment-details-modal h6 {
        color: #495057;
        margin-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
    }

    .payment-details-modal p {
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    /* Modal form styling */
    .modal-body .form-group {
        margin-bottom: 1rem;
    }

    .modal-body .form-label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #495057;
    }

    .modal-body .form-control,
    .modal-body .form-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
    }

    .modal-body .alert {
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 20px;
    }

    /* Condition section styling */
    .form-section {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        background: #fafafa;
    }

    .form-section h6 {
        color: #495057;
        margin-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 5px;
    }

    /* Conditional Fields Animation */
    .conditional-fields {
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.4s ease;
    }

    .conditional-fields.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .conditional-fields.show .form-group {
        animation: slideInUp 0.4s ease forwards;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading State */
    .btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .btn.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .date-filter-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-filter-container input[type="date"] {
        padding: 4px 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
    }

    .date-filter-container .btn-sm {
        padding: 4px 12px;
    }
</style>
<title>{{ trans('app.list_of_payments') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> {{ trans('app.list_of_payments') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- First Row: Existing Filters -->
                        <div class="d-flex justify-content-between align-items-center mb-3 mx-3">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Per Page Selector -->
                                <div class="d-flex align-items-center">
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

                                <div class="d-flex align-items-center">
                                    <label for="statusFilter" class="me-2">
                                        {{ trans('app.filter_payments') }} :
                                    </label>
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
                                        <option value="incomplete" {{ ($statusFilter ?? 'all') == 'incomplete' ? 'selected' : '' }}>
                                            @lang('app.incomplete')
                                        </option>
                                        <option value="in_review" {{ ($statusFilter ?? 'all') == 'in_review' ? 'selected' : '' }}>
                                            @lang('app.in_review')
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <select id="methodFilter" class="form-select form-select-sm" onchange="changeMethodFilter()" style="width: auto; min-width: 150px;">
                                        <option value="all" {{ ($methodFilter ?? 'all') == 'all' ? 'selected' : '' }}>@lang('app.all_payments')</option>
                                        <option value="B2B" {{ ($methodFilter ?? 'all') == 'B2B' ? 'selected' : '' }}>B2B</option>
                                        <option value="B2C" {{ ($methodFilter ?? 'all') == 'B2C' ? 'selected' : '' }}>B2C</option>
                                        <option value="EFT" {{ ($methodFilter ?? 'all') == 'EFT' ? 'selected' : '' }}>EFT</option>
                                        <option value="Cheque" {{ ($methodFilter ?? 'all') == 'Cheque' ? 'selected' : '' }}>@lang('app.cheque')</option>
                                        <option value="KAD KREDIT" {{ ($methodFilter ?? 'all') == 'KAD KREDIT' ? 'selected' : '' }}>KAD KREDIT</option>
                                        <option value="KAD DEBIT" {{ ($methodFilter ?? 'all') == 'KAD DEBIT' ? 'selected' : '' }}>KAD DEBIT</option>
                                        <option value="BAUCAR BAYARAN" {{ ($methodFilter ?? 'all') == 'BAUCAR BAYARAN' ? 'selected' : '' }}>BAUCAR BAYARAN</option>
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
                                        placeholder="@lang('app.search') reference, applicant, lot..."
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
                                <label for="dateFrom" class="me-2" style="white-space: nowrap;">Tarikh:</label>
                                <input type="date" id="dateFrom" class="form-control form-control-sm" 
                                    value="{{ request('date_from') }}" 
                                    style="width: 150px;">
                                <span>-</span>
                                <input type="date" id="dateTo" class="form-control form-control-sm" 
                                    value="{{ request('date_to') }}" 
                                    style="width: 150px;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="applyDateFilter()">
                                    <i class="fa fa-filter"></i> 
                                </button>
                                @if(request('date_from') || request('date_to'))
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearDateFilter()" title="Clear date filter">
                                        <i class="fa fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <!-- Table Wrapper for Responsiveness -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.reference_no') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{trans('Jenis Pembayaran')}}</strong></th>
                                        <th><strong>{{ trans('Nama Pembayar') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.total_contribution') }} (RM)</strong></th>
                                        <th><strong>Mod Terimaan </strong></th>
                                        <th><strong>Mod Transaksi Perbankan</strong></th>
                                         <th><strong>ID Transaksi</strong></th>
                                        <th><strong>{{ trans('app.payment_status') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $payment)
                                        @php
                                            // Now $payment is the Payment model, get application from relationship
                                            $item = $payment->application;
                                            
                                            $paymentMethod = '-';
                                            $methodClass = 'method-pending';

                                            if ($payment) {
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
                                                    default:
                                                        if (strpos($payment->method, 'FPX') !== false) {
                                                            $paymentMethod = str_replace('_', ' ', $payment->method);
                                                            $methodClass = 'method-online';
                                                        } else {
                                                            $paymentMethod = 'Online';
                                                            $methodClass = 'method-online';
                                                        }
                                                }

                                                // Government agency — always show as EFT
                                                if ($item->client && $item->client->accountType == 3) {
                                                    $paymentMethod = 'EFT';
                                                    $methodClass = 'method-offline';
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $loop->iteration }}</td>
                                            <td>
                                                {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $item->refference_no }}</td>
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

                                            <td>{{ strtoupper($item->applicant) }}</td>
                                            <td>{{ $item->land_lot }}, {{ $item->land_area }}, {{ $item->landDivision->mukim ?? '' }},
                                                Daerah
                                                {{ $item->landDistrict->daerah ?? '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $displayAmount = 'N/A';
                                                    if ($payment && $payment->amount) {
                                                        $displayAmount = number_format($payment->amount, 2);
                                                    } elseif ($item->final_amount) {
                                                        $displayAmount = number_format($item->final_amount, 2);
                                                    }
                                                @endphp
                                                
                                                {{ $displayAmount }}
                                            </td>
                                            <!-- ✅ First Column - EFT ONLY -->
                                            <td>
                                                @if(in_array($paymentMethod, ['EFT', 'B2B', 'B2C']))
                                                    <span class="payment-method-badge method-offline">EFT</span>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!-- ✅ Second Column - Show Original Method (like B2B, B2C, Cheque, etc.) -->
                                            <td>
                                                @if($paymentMethod === 'EFT' && $item->client && $item->client->accountType == 3)
                                                    <span class="payment-method-badge {{ $methodClass }}">Baucar Bayaran</span>
                                                @elseif($paymentMethod !== '-' && $paymentMethod !== 'EFT')
                                                    <span class="payment-method-badge {{ $methodClass }}">
                                                        {{ $paymentMethod }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $payment && $payment->transaction_id ? $payment->transaction_id : '-' }}</td>
                                            
                                            <td>
                                                @if ($payment && $payment->payment_status)
                                                    @if ($payment->method === 'FPX_B2B' && $payment->payment_status === 'pending_authorization')
                                                        {{ trans('app.payment_pending') }}
                                                    @elseif ($payment->payment_status == 'completed')
                                                        {{ trans('app.paids') }}
                                                    @elseif ($payment->payment_status == 'in_review')
                                                        {{ trans('app.payment_in_review') }}
                                                    @elseif ($payment->payment_status == 'failed')
                                                        {{ trans('app.payment_failed')}}
                                                    @else
                                                        @lang('app.' . $payment->payment_status)
                                                    @endif
                                                @else
                                                    {{ trans('app.unpaid') }}
                                                @endif
                                            </td>

                                            <td>
                                                <div class="sbtn">
                                                    {{-- Don't show anything if payment status is 'failed' --}}
                                                    @if (!$payment || $payment->payment_status !== 'failed')
                                                        
                                                        {{-- If payment exists and status is completed, show view receipt --}}
                                                        @if (
                                                            $canApproverViewReciept && 
                                                            $payment && 
                                                            $payment->payment_status === 'completed'
                                                        )
                                                            
                                                             <a href="{{ route('user_original_receipts', ['application_id' => $item->id, 'payment_uuid' => $payment->uuid]) }}" 
                                                                class="btn btn-primary btn-sm">
                                                                    <strong>{{ trans('app.view_receipt') }}</strong>
                                                            </a>
                                                        @endif
                                                        
                                                        {{-- Finance admin can edit in_review status --}}
                                                        @if (
                                                            $isFinanceAdmin && 
                                                            $payment &&  
                                                            $payment->payment_status === 'in_review'
                                                        )
                                                            <button type="button" 
                                                                    class="btn btn-edit btn-sm"
                                                                    onclick="window.location.href='{{ route('finance.payment.letter', ['application_id' => $item->id]) }}'"
                                                                    title="{{ trans('app.view_receipt') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif
                                                
                                                        {{-- If payment is NOT completed AND NOT in_review, show edit button for Finance Admin --}}
                                                        @if (
                                                            $isFinanceAdmin && 
                                                            $payment &&
                                                            $payment->payment_status !== 'completed' &&
                                                            $payment->payment_status !== 'in_review' &&
                                                            $payment->payment_status !== 'failed'
                                                        )
                                                            <button type="button" class="btn btn-edit btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#editPaymentModal"
                                                                data-application-id="{{ $item->id }}"
                                                                data-reference-no="{{ $item->refference_no }}"
                                                                data-applicant="{{ $item->applicant }}"
                                                                data-amount="{{ $item->final_amount }}"
                                                                data-current-status="{{ $payment->payment_status }}"
                                                                data-payment-method="{{ $paymentMethod }}"
                                                                title="{{ trans('app.edit_payment_status') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif
                                                        
                                                        {{-- Additional condition for cases where no payment exists at all --}}
                                                        @if (
                                                            $isFinanceAdmin && 
                                                            !$payment
                                                        )
                                                            <button type="button" class="btn btn-edit btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#editPaymentModal"
                                                                data-application-id="{{ $item->id }}"
                                                                data-reference-no="{{ $item->refference_no }}"
                                                                data-applicant="{{ $item->applicant }}"
                                                                data-amount="{{ $item->final_amount }}"
                                                                data-current-status=""
                                                                data-payment-method="{{ $paymentMethod }}"
                                                                title="{{ trans('app.edit_payment_status') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif
                                                        
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="me-2">
                                    @lang('app.page') <strong>{{ $list->currentPage() }}</strong>
                                    @lang('app.of') <strong>{{ $list->lastPage() }}</strong>
                                </span>
                            </div>

                            <nav>
                                <ul class="pagination">
                                    {{-- First Page --}}
                                    <li class="page-item {{ $list->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $list->url(1) }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}&method_filter={{ $methodFilter ?? 'all' }}{{ request('date_from') ? '&date_from='.request('date_from') : '' }}{{ request('date_to') ? '&date_to='.request('date_to') : '' }}{{ request('q') ? '&q='.request('q') : '' }}"
                                            title="@lang('app.first')">
                                            <span class="d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-angle-double-left"></i>
                                            </span>
                                        </a>
                                    </li>

                                    {{-- Previous Page --}}
                                    <li class="page-item {{ $list->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $list->previousPageUrl() }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}"
                                            title="@lang('app.prev')">
                                            <span class="d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-angle-left"></i>
                                            </span>
                                        </a>
                                    </li>

                                    {{-- Page Numbers --}}
                                    @foreach ($list->getUrlRange(1, $list->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $list->currentPage() ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $url }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page --}}
                                    <li class="page-item {{ !$list->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $list->nextPageUrl() }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}"
                                            title="@lang('app.next')">
                                            <span class="d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-angle-right"></i>
                                            </span>
                                        </a>
                                    </li>

                                    {{-- Last Page --}}
                                    <li class="page-item {{ !$list->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link"
                                            href="{{ $list->url($list->lastPage()) }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}"
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
    </section>

    <!-- Enhanced Edit Payment Modal -->
    <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">
                        <i class="fa fa-edit"></i> {{ trans('app.edit_payment_status') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPaymentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Payment Details -->
                        <div class="payment-details-modal">
                            <h6><i class="fa fa-info-circle"></i> {{ trans('app.payment_details') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ trans('app.reference_no') }}:</strong> <span id="modal-ref-no"></span>
                                    </p>
                                    <p><strong>{{ trans('app.applicant_name') }}:</strong> <span id="modal-applicant"></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ trans('app.amounts') }}:</strong> RM <span id="modal-amount"></span></p>
                                    <p><strong>{{ trans('app.current_status') }}:</strong> <span
                                            id="modal-current-status"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="form-section">
                            <h6><i class="fa fa-credit-card"></i> {{ trans('app.payment_method') }}</h6>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> {{ trans('app.select_payment_method_first') }}
                            </div>

                            <div class="form-group mb-4">
                                <label for="payment_method" class="form-label">{{ trans('app.payment_method') }} <span
                                        class="text-danger">*</span></label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="">{{ trans('app.select_payment_method_first') }}</option>
                                    <!--<option value="online">{{ trans('app.online_payment') }}</option>-->
                                    <option value="cheque">{{ trans('app.cheque') }}</option>
                                    <option value="bank_transfer">{{ trans('app.bank_transfer') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Cheque Payment Fields -->
                        <div class="form-section conditional-fields" id="cheque-fields">
                            <h6><i class="fa fa-money-check"></i> {{ trans('app.cheque_details') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cheque_number" class="form-label">{{ trans('app.cheque_number') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="cheque_number" id="cheque_number"
                                            class="form-control" placeholder="{{ trans('app.enter_cheque_number') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cheque_date" class="form-label">{{ trans('app.cheque_date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="cheque_date" id="cheque_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="bank_name" class="form-label">{{ trans('app.bank_name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control"
                                            placeholder="{{ trans('app.enter_bank_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="deposit_date"
                                            class="form-label">{{ trans('app.deposit_date') }}</label>
                                        <input type="date" name="deposit_date" id="deposit_date"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Fields -->
                        <div class="form-section conditional-fields" id="bank-transfer-fields">
                            <h6><i class="fa fa-university"></i> {{ trans('app.bank_transfer_details') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="transaction_id" class="form-label">{{ trans('app.transaction_id') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="transaction_id" id="transaction_id"
                                            class="form-control" placeholder="{{ trans('app.enter_transaction_id') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="transfer_date" class="form-label">{{ trans('app.transfer_date') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="date" name="transfer_date" id="transfer_date"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="from_bank" class="form-label">{{ trans('app.from_bank') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="from_bank" id="from_bank" class="form-control"
                                            placeholder="{{ trans('app.enter_bank_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="account_number"
                                            class="form-label">{{ trans('app.account_number') }}</label>
                                        <input type="text" name="account_number" id="account_number"
                                            class="form-control" placeholder="{{ trans('app.enter_account_number') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="receipt_upload" class="form-label">{{ trans('app.upload_receipt') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="file" name="receipt_upload" id="receipt_upload"
                                            class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Online Payment Fields -->
                        <div class="form-section conditional-fields" id="online-fields">
                            <h6><i class="fa fa-globe"></i> {{ trans('app.online_payment_details') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="gateway_transaction_id"
                                            class="form-label">{{ trans('app.gateway_transaction_id') }}</label>
                                        <input type="text" name="gateway_transaction_id" id="gateway_transaction_id"
                                            class="form-control"
                                            placeholder="{{ trans('app.enter_gateway_transaction_id') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_gateway"
                                            class="form-label">{{ trans('app.payment_gateway') }}</label>
                                        <select name="payment_gateway" id="payment_gateway" class="form-select">
                                            <option value="">{{ trans('app.select_gateway') }}</option>
                                            <option value="fpx">FPX</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="paypal">PayPal</option>
                                            <option value="stripe">Stripe</option>
                                            <option value="razorpay">Razorpay</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="receipt_number" class="form-label">{{ trans('app.receipt_number') }}</label>
                                        <input type="text" name="receipt_number" id="receipt_number"
                                            class="form-control" placeholder="{{ trans('app.auto_generated_if_empty') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="gateway_response" class="form-label">{{ trans('app.gateway_response') }}</label>
                                        <textarea name="gateway_response" id="gateway_response" class="form-control" rows="2"
                                            placeholder="{{ trans('app.enter_gateway_response') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- Common Fields -->
                        <div class="form-section">
                            <h6><i class="fa fa-cog"></i> {{ trans('app.payment_status_update') }}</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_status"
                                            class="form-label">{{ trans('app.update_payment_status') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="payment_status" id="payment_status" class="form-select" required>
                                            <option value="">{{ trans('app.select_status') }}</option>
                                            <option value="completed">{{ trans('app.completed') }}</option>
                                            <option value="pending">{{ trans('app.pending') }}</option>
                                            <option value="failed">{{ trans('app.failed') }}</option>
                                            <option value="in_review">{{ trans('app.in_review') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> {{ trans('app.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> {{ trans('app.kemaskini') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ================================
        // Global Filter Functions
        // ================================
        function updateFilters() {
            const perPage = document.getElementById('perPageSelect').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const methodFilter = document.getElementById('methodFilter').value;
            const search = '{{ request("q") }}';

            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('status_filter', statusFilter);
            url.searchParams.set('method_filter', methodFilter);
            url.searchParams.set('page', 1);

            if (search) {
                url.searchParams.set('q', search);
            }

            window.location.href = url.toString();
        }

        window.changePerPage = updateFilters;
        window.changeStatusFilter = updateFilters;
        window.changeMethodFilter = updateFilters;

        document.addEventListener('DOMContentLoaded', function() {

            // ========================
            // Conditional Payment Fields
            // ========================
            const paymentMethodSelect = document.getElementById('payment_method');
            const conditionalFields = {
                'cheque': document.getElementById('cheque-fields'),
                'bank_transfer': document.getElementById('bank-transfer-fields'),
                'online': document.getElementById('online-fields')
            };

            function hideAllConditionalFields() {
                Object.values(conditionalFields).forEach(field => {
                    if (field) {
                        field.classList.remove('show');
                        field.style.display = 'none';
                    }
                });
            }

            hideAllConditionalFields();

            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', function() {
                    hideAllConditionalFields();
                    const selected = this.value;
                    if (selected && conditionalFields[selected]) {
                        setTimeout(() => {
                            conditionalFields[selected].style.display = 'block';
                            setTimeout(() => {
                                conditionalFields[selected].classList.add('show');
                            }, 50);
                        }, 300);
                    }
                    updateRequiredFields(selected);
                });
            }

            function updateRequiredFields(method) {
                document.querySelectorAll('.conditional-fields input, .conditional-fields select')
                    .forEach(input => input.removeAttribute('required'));

                if (method === 'cheque') {
                    ['cheque_number', 'cheque_date', 'bank_name'].forEach(id => {
                        const f = document.getElementById(id);
                        if (f) f.setAttribute('required', 'required');
                    });
                } else if (method === 'bank_transfer') {
                    ['transaction_id', 'transfer_date', 'from_bank', 'receipt_upload'].forEach(id => {
                        const f = document.getElementById(id);
                        if (f) f.setAttribute('required', 'required');
                    });
                }
            }

            // ========================
            // Edit Payment Modal
            // ========================
            const editPaymentModal = document.getElementById('editPaymentModal');
            const editPaymentForm = document.getElementById('editPaymentForm');
            let editPaymentModalInstance = null;

            if (editPaymentModal && editPaymentForm) {

                // Initialize Bootstrap modal instance
                editPaymentModalInstance = new bootstrap.Modal(editPaymentModal);

                // Show modal event
                editPaymentModal.addEventListener('show.bs.modal', function(event) {
                    const btn = event.relatedTarget;
                    const applicationId = btn.getAttribute('data-application-id');
                    const refNo = btn.getAttribute('data-reference-no');
                    const applicant = btn.getAttribute('data-applicant');
                    const amount = btn.getAttribute('data-amount');
                    const currentStatus = btn.getAttribute('data-current-status') || 'Not Set';
                    const paymentMethod = btn.getAttribute('data-payment-method');

                    document.getElementById('modal-ref-no').textContent = refNo;
                    document.getElementById('modal-applicant').textContent = applicant;
                    document.getElementById('modal-amount').textContent = parseFloat(amount || 0)
                        .toLocaleString('en-US', { minimumFractionDigits: 2 });
                    document.getElementById('modal-current-status').textContent = currentStatus;

                    editPaymentForm.action = `admin/payment/update/${applicationId}`;
                    editPaymentForm.reset();
                    hideAllConditionalFields();

                    if (paymentMethod && conditionalFields[paymentMethod]) {
                        setTimeout(() => {
                            conditionalFields[paymentMethod].style.display = 'block';
                            setTimeout(() => {
                                conditionalFields[paymentMethod].classList.add('show');
                            }, 50);
                        }, 300);
                        updateRequiredFields(paymentMethod);
                    }
                });

                // Form submit
                editPaymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    // Validation
                    let isValid = true;
                    this.querySelectorAll('[required]').forEach(f => {
                        if (!f.value.trim() || (f.type === 'file' && !f.files.length)) {
                            f.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            f.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please fill in all required fields.',
                            confirmButtonColor: '#F1AA2A'
                        });
                        return;
                    }

                    // Submit button loading
                    submitBtn.disabled = true;
                    submitBtn.classList.add('loading');
                    submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.ok ? res.json() : Promise.reject(res.statusText))
                    .then(data => {
                        if (data.success) {
                            // Safely hide modal
                            if (editPaymentModalInstance) editPaymentModalInstance.hide();

                            Swal.fire({
                                icon: 'success',
                                title: '@lang("app.success")!',
                                text: data.message || '@lang("app.payment_updated_successfully")',
                                confirmButtonColor: '#28a745'
                            }).then(() => window.location.href = "{{ route('view.receipt') }}");
                        } else {
                            throw new Error(data.message || 'Update failed');
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: `Error updating payment status: ${err}`,
                            confirmButtonColor: '#F1AA2A'
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('loading');
                        submitBtn.innerHTML = originalText;
                    });
                });

                // Reset modal on hidden
                editPaymentModal.addEventListener('hidden.bs.modal', () => {
                    editPaymentForm.reset();
                    hideAllConditionalFields();
                });
            }
        });
    </script>
    <script>
        function applyDateFilter() {
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const perPage = document.getElementById('perPageSelect').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const methodFilter = document.getElementById('methodFilter').value;
            const searchQuery = document.querySelector('input[name="q"]')?.value || '';
            
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

        function changePerPage() {
            applyDateFilter();
        }

        function changeStatusFilter() {
            applyDateFilter();
        }

        function changeMethodFilter() {
            applyDateFilter();
        }
    </script>
@endsection
