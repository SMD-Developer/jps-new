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
                               
                            </div>
                               <!-- Search Box - Right End -->
                            <form method="GET" class="d-flex align-items-center mt-3">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                                <input type="hidden" name="status_filter" value="{{ $statusFilter ?? 'all' }}">

                                <div class="input-group" style="max-width: 300px;">
                                    <input type="search" name="q" value="{{ request('q') }}"
                                        placeholder="@lang('app.search') reference, applicant, lot..."
                                        class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @if (request('q'))
                                        <a href="{{ request()->url() }}?per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}"
                                            class="btn btn-sm btn-outline-secondary" title="Clear search">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
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
                                        <th><strong>{{ trans('app.applicant_list') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.total_contribution') }}</strong></th>
                                        <th><strong>{{ trans('app.payment_method') }}</strong></th>
                                        <th><strong>{{ trans('app.payment_status') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                       @php
                                                $isFinanceAdmin = auth('admin')->check() && 
                                                                 auth('admin')->user()->role_id === '9e032970-5f48-4d2b-b88e-abb9da79140f';
                                                
                                                // Initialize default values
                                                $paymentMethod = '-';
                                                $methodClass = 'method-pending';
                                                
                                                
                                                // If payment exists
                                                if ($item->payment) {
                                                    // Determine payment method
                                                    switch ($item->payment->method) {
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
                                                            if (strpos($item->payment->method, 'FPX') !== false) {
                                                                $paymentMethod = str_replace('_', ' ', $item->payment->method);
                                                                $methodClass = 'method-online';
                                                            } else {
                                                                $paymentMethod = 'Online'; // This will now only appear for unknown methods
                                                                $methodClass = 'method-online';
                                                            }
                                                    }
                                                    
                                                    // Special case for government agencies - always show as EFT if payment exists
                                                    if ($item->client && $item->client->accountType == 3) {
                                                        $paymentMethod = 'EFT';
                                                        $methodClass = 'method-offline';
                                                    }
                                                }
                                                
                                               // Determine payment status
                                                    if ($item->payment && $item->payment->payment_status) {
                                                        // Special TEMPORARY logic for B2B
                                                        if (
                                                            $item->payment->method === 'FPX_B2B'
                                                            && $item->payment->payment_status === 'pending_authorization'
                                                        ) {
                                                            $paymentStatus = trans('app.pending');
                                                        } elseif ($item->payment->payment_status == 'completed') {
                                                            $paymentStatus = trans('app.paids');
                                                        } elseif ($item->payment->payment_status == 'in_review') {
                                                            $paymentStatus = trans('app.payment_in_review');
                                                        } else {
                                                            // Use the payment status translation as usual
                                                            $paymentStatus = trans('app.' . $item->payment->payment_status);
                                                        }
                                                    }

                                            @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item['uploade_date'])) }}</td>
                                            <td>{{ $item->refference_no }}</td>
                                            <td>
                                                {{ $item->client ? ($item->client->accountType == 1 ? 'Individu' : ($item->client->accountType == 2 ? 'Pemaju' : ($item->client->accountType == 3 ? 'Agensi Kerajaan' : 'Unknown'))) : '' }}
                                            </td>
                                            <td>{{ $item->applicant }}</td>
                                            <td>{{ $item->land_lot }}</td>
                                            <td>{{ $item->final_amount ? 'RM ' . number_format($item->final_amount, 2) : 'N/A' }}
                                            </td>
                                            <td>
                                                @if($paymentMethod !== '-')
                                                    <span class="payment-method-badge {{ $methodClass }}">
                                                        {{ $paymentMethod }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <!--<td>-->
                                            <!--    @if ($item->payment && $item->payment->payment_status)-->
                                            <!--        @if ($item->payment->method === 'FPX_B2B' && $item->payment->payment_status === 'pending_authorization')-->
                                            <!--            {{ trans('app.payment_pending') }}-->
                                            <!--        @elseif ($item->payment->payment_status == 'completed')-->
                                            <!--            {{ trans('app.paids') }}-->
                                            <!--        @elseif ($item->payment->payment_status == 'in_review')-->
                                            <!--            {{ trans('app.payment_in_review') }}-->
                                            <!--        @elseif ($item->payment->payment_status == 'failed')-->
                                            <!--            {{ trans('app.payment_failed')}}-->
                                            <!--        @else-->
                                            <!--            @lang('app.' . $item->payment->payment_status)-->
                                            <!--        @endif-->
                                            <!--    @else-->
                                            <!--        {{ trans('app.unpaid') }}-->
                                            <!--    @endif-->
                                            <!--</td>-->
                                            
                                            
                                            <td>
                                                @if ($item->latestPayment && $item->latestPayment->payment_status)
                                                    @if ($item->latestPayment->method === 'FPX_B2B' && $item->latestPayment->payment_status === 'pending_authorization')
                                                        {{ trans('app.payment_pending') }}
                                                    @elseif ($item->latestPayment->payment_status == 'completed')
                                                        {{ trans('app.paids') }}
                                                    @elseif ($item->latestPayment->payment_status == 'in_review')
                                                        {{ trans('app.payment_in_review') }}
                                                    @elseif ($item->latestPayment->payment_status == 'failed')
                                                        {{ trans('app.payment_failed')}}
                                                    @else
                                                        @lang('app.' . $item->latestPayment->payment_status)
                                                    @endif
                                                @else
                                                    {{ trans('app.unpaid') }}
                                                @endif
                                            </td>

                                           
                                       
                                        <td>
                                                <div class="sbtn">
                                                    {{-- Don't show anything if payment status is 'failed' --}}
                                                    @if (!$item->payment || $item->payment->payment_status !== 'failed')
                                                        
                                                        {{-- If payment exists and status is completed, show view receipt --}}
                                                        @if (
                                                            $canApproverViewReciept && 
                                                            $item->latestPayment && 
                                                            $item->latestPayment->payment_status === 'completed'
                                                        )
                                                            <a href="{{ route('user_original_receipts', ['application_id' => $item->id]) }}" 
                                                               class="btn btn-primary btn-sm">
                                                                <strong>{{ trans('app.view_receipt') }}</strong>
                                                            </a>
                                                        @endif
                                                        
                                                        @if (
                                                            $isFinanceAdmin && 
                                                            $item->payment &&  
                                                            $item->payment->payment_status === 'in_review'
                                                        )
                                                           <!--<a href="{{ route('finance.payment.letter', ['application_id' => $item->id]) }}"-->
                                                           <!--         class="btn btn-success btn-sm"-->
                                                           <!--         title="{{ trans('app.view_receipt') }}">-->
                                                           <!--         <i class="fa fa-edit fa-lg"></i>-->
                                                           <!--     </a>-->
                                                           
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
                                                            $item->latestPayment  &&
                                                            $item->latestPayment ->payment_status !== 'completed' &&
                                                            $item->latestPayment ->payment_status !== 'in_review' &&
                                                            $item->latestPayment ->payment_status !== 'failed' // Added this condition
                                                        )
                                                            <button type="button" class="btn btn-edit btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#editPaymentModal"
                                                                data-application-id="{{ $item->id }}"
                                                                data-reference-no="{{ $item->refference_no }}"
                                                                data-applicant="{{ $item->applicant }}"
                                                                data-amount="{{ $item->final_amount }}"
                                                                data-current-status="{{ $item->payment->payment_status }}"
                                                                data-payment-method="{{ $paymentMethod }}"
                                                                title="{{ trans('app.edit_payment_status') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif
                                                        
                                                        {{-- Additional condition for cases where no payment exists at all --}}
                                                        @if (
                                                            $isFinanceAdmin && 
                                                            !$item->payment
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
                                            href="{{ $list->url(1) }}&per_page={{ $perPage }}&status_filter={{ $statusFilter ?? 'all' }}"
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
                            <!--<div class="alert alert-info">-->
                            <!--    <i class="fa fa-info-circle"></i> {{ trans('app.money_debited_update_status') }}-->
                            <!--</div>-->

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
                                <!--<div class="col-md-6">-->
                                <!--    <div class="form-group mb-3">-->
                                <!--        <label for="receipt_number"-->
                                <!--            class="form-label">{{ trans('app.receipt_number') }}</label>-->
                                <!--        <input type="text" name="receipt_number" id="receipt_number"-->
                                <!--            class="form-control"-->
                                <!--            placeholder="{{ trans('app.auto_generated_if_empty') }}">-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>

                            <!--<div class="form-group mb-3">-->
                            <!--    <label for="admin_notes" class="form-label">{{ trans('app.admin_notes') }}</label>-->
                            <!--    <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3"-->
                            <!--        placeholder="{{ trans('app.enter_notes_reason_for_status_change') }}"></textarea>-->
                            <!--</div>-->
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('perPageSelect').addEventListener('change', function() {
                const perPage = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', 1);
                window.location.href = url.toString();
            });

            const paymentMethodSelect = document.getElementById('payment_method');
            const conditionalFields = {
                'cheque': document.getElementById('cheque-fields'),
                'bank_transfer': document.getElementById('bank-transfer-fields'),
                'online': document.getElementById('online-fields')
            };

            Object.values(conditionalFields).forEach(field => {
                if (field) field.style.display = 'none';
            });
            paymentMethodSelect.addEventListener('change', function() {
                const selectedMethod = this.value;
                Object.values(conditionalFields).forEach(field => {
                    if (field) {
                        field.classList.remove('show');
                        setTimeout(() => {
                            field.style.display = 'none';
                        }, 300);
                    }
                });

                if (selectedMethod && conditionalFields[selectedMethod]) {
                    setTimeout(() => {
                        conditionalFields[selectedMethod].style.display = 'block';
                        setTimeout(() => {
                            conditionalFields[selectedMethod].classList.add('show');
                        }, 50);
                    }, 300);
                }
                updateRequiredFields(selectedMethod);
            });

            function updateRequiredFields(paymentMethod) {
                document.querySelectorAll('.conditional-fields input, .conditional-fields select').forEach(
                    input => {
                        input.removeAttribute('required');
                    });
                if (paymentMethod === 'cheque') {
                    ['cheque_number', 'cheque_date', 'bank_name'].forEach(id => {
                        const field = document.getElementById(id);
                        if (field) field.setAttribute('required', 'required');
                    });
                } else if (paymentMethod === 'bank_transfer') {
                    ['transaction_id', 'transfer_date', 'from_bank', 'receipt_upload'].forEach(id => {
                        const field = document.getElementById(id);
                        if (field) field.setAttribute('required', 'required');
                    });
                }
            }

            const editPaymentModal = document.getElementById('editPaymentModal');
            if (editPaymentModal) {
                editPaymentModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const applicationId = button.getAttribute('data-application-id');
                    const refNo = button.getAttribute('data-reference-no');
                    const applicant = button.getAttribute('data-applicant');
                    const amount = button.getAttribute('data-amount');
                    const currentStatus = button.getAttribute('data-current-status') || 'Not Set';
                    const paymentMethod = button.getAttribute('data-payment-method');
                    console.log('Modal Data:', {
                        applicationId,
                        refNo,
                        applicant,
                        amount,
                        currentStatus,
                        paymentMethod
                    });

                    document.getElementById('modal-ref-no').textContent = refNo;
                    document.getElementById('modal-applicant').textContent = applicant;
                    document.getElementById('modal-amount').textContent = parseFloat(amount || 0)
                        .toLocaleString('en-US', {
                            minimumFractionDigits: 2
                        });
                    document.getElementById('modal-current-status').textContent = currentStatus;
                    document.getElementById('editPaymentForm').action =
                        `admin/payment/update/${applicationId}`;
                    document.getElementById('editPaymentForm').reset();
                    Object.values(conditionalFields).forEach(field => {
                        if (field) {
                            field.classList.remove('show');
                            field.style.display = 'none';
                        }
                    });
                });


                const editPaymentForm = document.getElementById('editPaymentForm');
                if (editPaymentForm) {
                    editPaymentForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        let isValid = true;
                        const requiredFields = this.querySelectorAll('[required]');
                        requiredFields.forEach(field => {
                            if (!field.value.trim() && field.type !== 'file') {
                                field.classList.add('is-invalid');
                                isValid = false;
                            } else if (field.type === 'file' && !field.files.length) {
                                field.classList.add('is-invalid');
                                isValid = false;
                            } else {
                                field.classList.remove('is-invalid');
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

                        submitBtn.disabled = true;
                        submitBtn.classList.add('loading');
                        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';

                        fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    try {
                                        const modal = bootstrap.Modal.getInstance(editPaymentModal);
                                        if (modal) {
                                            modal.hide();
                                        }
                                    } catch (e) {
                                        try {
                                            $('#editPaymentModal').modal('hide');
                                        } catch (e2) {
                                            try {
                                                editPaymentModal.classList.remove('show');
                                                editPaymentModal.style.display = 'none';
                                                document.body.classList.remove('modal-open');
                                                const backdrop = document.querySelector(
                                                    '.modal-backdrop');
                                                if (backdrop) {
                                                    backdrop.remove();
                                                }
                                            } catch (e3) {
                                                console.log('Could not close modal automatically');
                                            }
                                        }
                                    }
                                    Swal.fire({
                                        icon: 'success',
                                        title: '@lang('app.success')!',
                                        text: data.message ||
                                            '@lang('app.payment_updated_successfully')',
                                        confirmButtonColor: '#28a745',
                                        confirmButtonText: 'OK',
                                        showCancelButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href =
                                                "{{ route('view.receipt') }}";
                                        }
                                    });
                                } else {
                                    throw new Error(data.message || 'Update failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: `Error updating payment status: ${error.message}`,
                                    confirmButtonColor: '#F1AA2A'
                                });
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('loading');
                                submitBtn.innerHTML = originalText;
                            });
                    });
                }
                editPaymentModal.addEventListener('hidden.bs.modal', function() {
                    if (editPaymentForm) {
                        editPaymentForm.reset();
                        const alerts = this.querySelectorAll('.alert');
                        alerts.forEach(alert => alert.remove());
                        Object.values(conditionalFields).forEach(field => {
                            if (field) {
                                field.classList.remove('show');
                                field.style.display = 'none';
                            }
                        });
                    }
                });
            }
            window.changePerPage = function() {
                document.getElementById('perPageSelect').dispatchEvent(new Event('change'));
            };
        });
    </script>
    <script>


        window.changePerPage = function() {
            const perPage = document.getElementById('perPageSelect').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('status_filter', statusFilter);
            url.searchParams.set('page', 1); 
            window.location.href = url.toString();
        };
        
        
        window.changeStatusFilter = function() {
            const perPage = document.getElementById('perPageSelect').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('status_filter', statusFilter);
            url.searchParams.set('page', 1); 
            window.location.href = url.toString();
        };
        
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('perPageSelect').addEventListener('change', function() {
                changePerPage();
            });
        
        
            document.getElementById('statusFilter').addEventListener('change', function() {
                changeStatusFilter();
            });
        
        });
    </script>
@endsection
