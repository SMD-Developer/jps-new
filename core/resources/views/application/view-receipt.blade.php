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

    /* Edit button styling */
    .btn-edit {
        background: #28a745 !important;
        border: 1px solid #28a745;
        color: white !important;
        padding: 6px 12px;
        font-size: 0.75rem;
    }

    .btn-edit:hover {
        background: #218838 !important;
        border: 1px solid #218838;
    }

    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    table.table thead th {
        background-color: #f8f9fa;
        font-weight: 700;
        vertical-align: middle;
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

    /* Form section styling */
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
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn-approve-custom {
        background-color: #1bbe28ff !important;
        border-radius: 10px !important;
        padding: 4px 10px !important;
        font-size: 12px !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-approve-custom i {
        font-size: 15px;
    }
    </style>
<title>{{ trans('Pembayaran Belum Selesai') }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-edit"></i> {{ trans('Pembayaran Belum Selesai') }}</h5>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Simple pagination control -->
                        <div class="card-body"> 
                            <!-- Simple pagination control --> 
                            <div class="d-flex justify-content-between align-items-center mb-3 mx-3"> 
                                <!-- Left side: Per Page and Status Filter -->
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Per Page Select -->
                                    <div class="d-flex align-items-center"> 
                                        <label for="perPageSelect" class="me-2">@lang('app.show') : </label> 
                                        <select id="perPageSelect" class="form-select form-select-sm"  
                                                onchange="changePerPage()" style="width: auto"> 
                                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option> 
                                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option> 
                                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option> 
                                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option> 
                                        </select> 
                                    </div> 

                                    <!-- Status Filter -->
                                    <div class="d-flex align-items-center"> 
                                        <label for="statusFilter" class="me-2">{{ trans('app.status') }} :</label> 
                                        <select id="statusFilter" class="form-select form-select-sm" 
                                                onchange="changeStatusFilter()" style="width: auto; min-width: 150px;"> 
                                            <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}> 
                                                @lang('app.all') 
                                            </option> 
                                            <option value="in_review" {{ ($statusFilter ?? 'all') == 'in_review' ? 'selected' : '' }}> 
                                                @lang('app.in_review') 
                                            </option> 
                                            <option value="belum_bayar" {{ ($statusFilter ?? 'all') == 'belum_bayar' ? 'selected' : '' }}> 
                                                Belum Bayar 
                                            </option> 
                                        </select> 
                                    </div>
                                </div>

                                <!-- Right side: Search Box --> 
                                <form method="GET" class="d-flex align-items-center"> 
                                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                                    <input type="hidden" name="status" value="{{ $statusFilter ?? 'all' }}">
                                    <div class="input-group" style="max-width: 300px;"> 
                                        <input type="search" name="q" value="{{ request('q') }}" 
                                            placeholder="@lang('app.search') reference, applicant..." 
                                            class="form-control form-control-sm"> 
                                        <button class="btn btn-sm btn-primary" type="submit"> 
                                            <i class="fa fa-search"></i> 
                                        </button> 
                                        @if (request('q')) 
                                            <a href="{{ request()->url() }}?per_page={{ $perPage }}&status={{ $statusFilter ?? 'all' }}" 
                                                class="btn btn-sm btn-outline-secondary" title="Clear search"> 
                                                <i class="fa fa-times"></i> 
                                            </a> 
                                        @endif 
                                    </div> 
                                </form> 
                            </div>
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('Bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.reference_no') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.amount') }} (RM)</strong></th>
                                        <th><strong>{{ trans('app.payment_status') }}</strong></th>
                                        <th><strong>{{ trans('app.action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($list as $item)
                                        @php
                                            $payment = $item->payment;
                                        @endphp
                                        <tr>
                                            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                            <td>{{ $item->refference_no }}</td>
                                            <td>{{ strtoupper($item->applicant) }}</td>
                                            
                                            <!-- Account Type -->
                                            <td>
                                                @php
                                                    $clientType = '';
                                                    $applicantType = '';
                                                    
                                                    if ($item->client) {
                                                        switch ($item->client->accountType) {
                                                            case 1: $clientType = 'Individu'; break;
                                                            case 2: $clientType = 'Pemaju'; break;
                                                            case 3: $clientType = 'Agensi Kerajaan'; break;
                                                            case 4: $clientType = 'Perunding'; break;
                                                            default: $clientType = 'Unknown';
                                                        }
                                                        
                                                        switch ($item->applicant_type) {
                                                            case 1: $applicantType = 'Individu'; break;
                                                            case 2: $applicantType = 'Pemaju'; break;
                                                            case 3: $applicantType = 'Agensi Kerajaan'; break;
                                                            case 4: $applicantType = 'Perunding'; break;
                                                        }
                                                        
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
                                            
                                            <!-- Lot/PT -->
                                            <td>
                                                {{ $item->land_lot ?? '' }}{{ $item->land_lot && $item->land_area ? ', ' : '' }}{{ $item->land_area ?? '' }}{{ ($item->land_lot || $item->land_area) && $item->landDivision ? ', ' : '' }}{{ $item->landDivision->mukim ?? '' }}{{ $item->landDivision && $item->landDistrict ? ', Daerah ' : '' }}{{ $item->landDistrict->daerah ?? '' }}
                                            </td>
                                            
                                            <!-- Amount -->
                                            <td>{{ number_format($item->final_amount ?? 0, 2) }}</td>
                                            
                                            <!-- Payment Status -->
                                            <td>
                                                @if ($payment && $payment->payment_status)
                                                    <span class="badge bg-info">
                                                        @if ($payment->payment_status == 'completed')
                                                            {{ trans('app.completed') }}
                                                        @elseif ($payment->payment_status == 'pending')
                                                            {{ trans('app.pending') }}
                                                        @elseif ($payment->payment_status == 'in_review')
                                                            {{ trans('app.in_review') }}
                                                        @elseif ($payment->payment_status == 'failed')
                                                            {{ trans('app.failed') }}
                                                        @else
                                                            {{ ucfirst($payment->payment_status) }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">{{ trans('app.unpaid') }}</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Action -->
                                            <td>

                                                {{-- FINANCE APPROVER ADMIN → Only Approve Button --}}
                                                @if ($isFinanceApprover)

                                                    @if ($payment && $payment->payment_status === 'in_review')
                                                        <button type="button" 
                                                            class="btn btn-approve-custom btn-sm"
                                                            onclick="window.location.href='{{ route('finance.payment.letter', ['application_id' => $item->id]) }}'"
                                                            title="{{ trans('app.view_receipt') }}">
                                                            <i class="fa fa-edit" style="color: white;"></i>
                                                        </button>
                                                    @else
                                                        <span class="text-muted"></span>
                                                    @endif

                                                {{-- FINANCE ADMIN → Only Update Button --}}
                                                @elseif ($isFinanceAdmin)

                                                    @if ($payment && $payment->payment_status === 'in_review')
                                                        {{-- Do NOT show any button for Finance Admin when payment is in_review --}}
                                                        <span class="text-muted"></span>
                                                    @else
                                                        <button type="button" class="btn btn-edit btn-sm"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editPaymentModal"
                                                            data-application-id="{{ $item->id }}"
                                                            data-reference-no="{{ $item->refference_no }}"
                                                            data-applicant="{{ $item->applicant }}"
                                                            data-amount="{{ $item->final_amount }}"
                                                            data-current-status="Belum Bayar"
                                                            title="{{ trans('app.update_payment') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    @endif

                                                @else
                                                    <span class="text-muted"></span>
                                                @endif

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <em>No approved applications found</em>
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
                                        (@lang('app.total'): {{ $list->total() }} applications)
                                    </span>
                                </div>

                                <nav>
                                    {{ $list->appends(['per_page' => $perPage, 'q' => request('q')])->links() }}
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
                        <i class="fa fa-edit"></i> {{ trans('Kemaskini Pembayaran') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPaymentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Payment Details -->
                        <div class="payment-details-modal">
                            <h6><i class="fa fa-info-circle"></i> {{ trans('Maklumat Permohonan') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ trans('app.reference_no') }}:</strong> <span id="modal-ref-no"></span></p>
                                    <p><strong>{{ trans('app.applicant_name') }}:</strong> <span id="modal-applicant"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ trans('app.amount') }}:</strong> RM <span id="modal-amount"></span></p>
                                    <p><strong>{{ trans('app.current_status') }}:</strong> <span id="modal-current-status"></span></p>
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
                                <label for="payment_method" class="form-label">{{ trans('app.payment_method') }} <span class="text-danger">*</span></label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="">{{ trans('Pilih Cara Bayaran') }}</option>
                                    <option value="cheque">{{ trans('app.cheque') }}</option>
                                    <option value="bank_draf">{{ trans('Bank Draf') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Cheque Payment Fields -->
                        <div class="form-section conditional-fields" id="cheque-fields">
                            <h6><i class="fa fa-money-check"></i> {{ trans('app.cheque_details') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cheque_number" class="form-label">{{ trans('app.cheque_number') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="cheque_number" id="cheque_number" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cheque_date" class="form-label">{{ trans('app.cheque_date') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="cheque_date" id="cheque_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="bank_name" class="form-label">{{ trans('app.bank_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="deposit_date" class="form-label">{{ trans('app.deposit_date') }}</label>
                                        <input type="date" name="deposit_date" id="deposit_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Fields -->
                        <div class="form-section conditional-fields" id="bank-transfer-fields">
                            <h6><i class="fa fa-university"></i> {{ trans('Butiran') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="transaction_id" class="form-label">{{ trans('No Bank Draf') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="transfer_date" class="form-label">{{ trans('Tarikh') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="transfer_date" id="transfer_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="amount" class="form-label">{{ trans('Jumlah (RM) :') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" id="amount" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6" style="display:none;">
                                    <div class="form-group mb-3">
                                        <label for="account_number" class="form-label">{{ trans('app.account_number') }}</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control" placeholder="{{ trans('app.enter_account_number') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="receipt_upload" class="form-label">{{ trans('app.upload_receipt') }} <span class="text-danger">*</span></label>
                                        <input type="file" name="receipt_upload" id="receipt_upload" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div class="form-section">
                            <h6><i class="fa fa-cog"></i> {{ trans('app.payment_status') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_status" class="form-label">{{ trans('app.payment_status') }} <span class="text-danger">*</span></label>
                                        <select name="payment_status" id="payment_status" class="form-select" required>
                                            <option value="">{{ trans('app.select_status') }}</option>
                                            <option value="completed">{{ trans('app.completed') }}</option>
                                            <option value="pending">{{ trans('app.pending') }}</option>
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
                            <i class="fa fa-save"></i> {{ trans('app.update') }}
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
        function changePerPage() {
            const perPage = document.getElementById('perPageSelect').value;
            const search = '{{ request("q") }}';
            let url = window.location.pathname + '?per_page=' + perPage;
            if (search) url += '&q=' + encodeURIComponent(search);
            window.location.href = url;
        }

        function changeStatusFilter() {
            const statusFilter = document.getElementById('statusFilter').value;
            const perPage = document.getElementById('perPageSelect').value;
            const search = '{{ request("q") }}';
            
            let url = window.location.pathname + '?per_page=' + perPage + '&status=' + statusFilter;
            if (search) url += '&q=' + encodeURIComponent(search);
            
            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodSelect = document.getElementById('payment_method');
            const conditionalFields = {
                'cheque': document.getElementById('cheque-fields'),
                'bank_draf': document.getElementById('bank-transfer-fields')
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
                } else if (method === 'bank_draf') {
                    ['transaction_id', 'transfer_date', 'amount'].forEach(id => {
                        const f = document.getElementById(id);
                        if (f) f.setAttribute('required', 'required');
                    });
                }
            }

            const editPaymentModal = document.getElementById('editPaymentModal');
            const editPaymentForm = document.getElementById('editPaymentForm');
            let editPaymentModalInstance = null;

            if (editPaymentModal && editPaymentForm) {
                editPaymentModalInstance = new bootstrap.Modal(editPaymentModal);

                editPaymentModal.addEventListener('show.bs.modal', function(event) {
                    const btn = event.relatedTarget;
                    const applicationId = btn.getAttribute('data-application-id');
                    const refNo = btn.getAttribute('data-reference-no');
                    const applicant = btn.getAttribute('data-applicant');
                    const amount = btn.getAttribute('data-amount');
                    const currentStatus = btn.getAttribute('data-current-status') || 'Belum Bayar';

                    document.getElementById('modal-ref-no').textContent = refNo;
                    document.getElementById('modal-applicant').textContent = applicant;
                    document.getElementById('modal-amount').textContent = parseFloat(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 2 });
                    document.getElementById('modal-current-status').textContent = currentStatus;

                    editPaymentForm.action = `admin/payment/update/${applicationId}`;
                    editPaymentForm.reset();
                    hideAllConditionalFields();
                });

                editPaymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    let isValid = true;
                    this.querySelectorAll('[required]').forEach(f => {
                        if (!f.value.trim() || (f.type === 'file' && f.files && !f.files.length)) {
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
                            if (editPaymentModalInstance) editPaymentModalInstance.hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message || 'Payment updated successfully',
                                confirmButtonColor: '#28a745'
                            }).then(() => window.location.reload());
                        } else {
                            throw new Error(data.message || 'Update failed');
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: `Error updating payment: ${err}`,
                            confirmButtonColor: '#F1AA2A'
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('loading');
                        submitBtn.innerHTML = originalText;
                    });
                });

                editPaymentModal.addEventListener('hidden.bs.modal', () => {
                    editPaymentForm.reset();
                    hideAllConditionalFields();
                });
            }
        });
    </script>
@endsection