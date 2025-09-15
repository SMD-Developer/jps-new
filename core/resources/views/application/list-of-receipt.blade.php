<!-- @extends('app') -->
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
<style>
    /* General Styles */
   

    /* Container */
    .form-container {
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Table Styles */
    .table-header {
        background-color: #eef5f9;
        font-weight: 600;
        text-align: center;
    }

    .table td,
    .table th {
        vertical-align: middle;
        text-align: center;
    }

    /* Scrollbar for Table */
    .scrollbar {
        overflow-x: auto;
        margin-bottom: 15px;
    }

    .scrollbar table {
        min-width: 100%;
    }

    /* Pagination Controls */
    .pagination-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .dropdowns {
        width: 80px;
        display: inline-block;
    }

    .page-navigation {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .page-navigation span,
    .page-navigation i {
        background-color: #f5f5f5;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    .page-navigation span:hover,
    .page-navigation i:hover {
        background-color: #ddd;
    }

    /* Summary Section */
    .summary-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        padding: 10px;
        background-color: #eef5f9;
        border-radius: 5px;
        font-weight: 600;
        color: #333;
    }

    .highlight-text {
        color: #ff7700;
        font-weight: 600;
    }

    /* Section Header */
    .section-header {
        background-color: #eef5f9;
        padding: 10px;
        border-radius: 5px 5px 0 0;
        font-weight: 600;
        color: #333;
    }

    /* Buttons */
    .buttons button {
        margin-right: 10px;
        font-weight: 500;
    }
</style>

<title>@lang('app.list_of_receipt') | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-file" aria-hidden="true"></i> @lang('app.list_of_receipt')</h5>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <div class="scrollbar">
                        <table class="table table-bordered">
                            <thead class="table-header">
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Bil</th>
                                    <th>@lang('app.receipt_no')</th>
                                    <th>@lang('app.receipt_date')</th>
                                    <th>@lang('app.description_type')</th>
                                    <th>@lang('app.amounts') (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $index => $application)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="rowCheckbox"
                                                data-amount="{{ $application->payment_amount}}"></td>
                                        <td>{{ ($applications->currentPage() - 1) * $applications->perPage() + $index + 1 }}
                                        </td>
                                        <td>{{ $application->receipt_number ?? 'NA' }}</td>
                                        <td class="date-column">
                                            @if ($application->payment_created_at)
                                                <div class="date">
                                                    {{ \Carbon\Carbon::parse($application-> payment_created_at)->format('d/m/Y') }}
                                                </div>
                                                <div class="time">
                                                    {{ \Carbon\Carbon::parse($application->payment_created_at)->format('h:i A') }}
                                                </div>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td style="width: 70px;padding: 0px 25px;">{{ $application->land_lot }}
                                            ({{ $application->hectare }}HEKTAR)
                                            DI MUKIM
                                            {{ $application->state_name ?? 'N/A' }}, DAERAH
                                            {{ $application->district_name ?? 'N/A' }}
                                        </td>
                                        <td>RM {{ number_format($application->payment_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="summary-bar">
                        <div>@lang('app.show')
                            <select class="form-select dropdowns" id="perPageSelect">
                                <option value="10" {{ request()->input('per_page', 10) == 10 ? 'selected' : '' }}>10
                                </option>
                                <option value="50" {{ request()->input('per_page') == 50 ? 'selected' : '' }}>50
                                </option>
                                <option value="100" {{ request()->input('per_page') == 100 ? 'selected' : '' }}>100
                                </option>
                                <option value="200" {{ request()->input('per_page') == 200 ? 'selected' : '' }}>200
                                </option>
                            </select> @lang('app.records_per_page')
                        </div>
                        <div>@lang('app.amount') (RM): <span
                                id="selectedTotalAmount">{{ number_format($applications->sum('final_amount'), 2) }}</span>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-controls">
                        <div class="page-navigation">
                            <a href="{{ $applications->url(1) }}"
                                class="{{ $applications->currentPage() == 1 ? 'disabled' : '' }}">
                                <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                            </a>
                            <span>@lang('app.page') {{ $applications->currentPage() }}</span>
                            <a href="{{ $applications->url($applications->lastPage()) }}"
                                class="{{ $applications->currentPage() == $applications->lastPage() ? 'disabled' : '' }}">
                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div>
                            Memaparkan rekod {{ ($applications->currentPage() - 1) * $applications->perPage() + 1 }}
                            hingga
                            {{ min($applications->currentPage() * $applications->perPage(), $applications->total()) }}
                            dari {{ $applications->total() }} rekod
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-3" style="display: flex;justify-content: flex-end;">
            <div class="col-md-12 text-right mb-3">
                <a href="{{ route('payment_report') }}" class="btn btn-primary">@lang('app.come_back')</a>
                <button id="printButton" class="btn btn-warning">@lang('app.print')</button>
                <button id="nextButton" class="btn btn-secondary">@lang('app.next')</button>
            </div>
        </div>
    </section>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Per page select functionality
        document.getElementById('perPageSelect').addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });

        // Checkbox selection functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
        const totalAmountSpan = document.getElementById('selectedTotalAmount');

        // Initialize total amount as 0
        let totalAmount = 0;
        totalAmountSpan.textContent = totalAmount.toFixed(2);

        // Update total amount when checkboxes change
        function updateTotalAmount() {
            totalAmount = 0;
            rowCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const amount = parseFloat(checkbox.dataset.amount);
                    if (!isNaN(amount)) { // Check if amount is a valid number
                        totalAmount += amount;
                    }
                }
            });
            totalAmountSpan.textContent = totalAmount.toFixed(2);
        }

        // Select all checkbox functionality - FIXED
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;

            // Use setTimeout to ensure the DOM is updated before calculating total
            setTimeout(() => {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateTotalAmount();
            }, 0);
        });

        // Individual row checkbox functionality
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Use setTimeout to ensure proper state update
                setTimeout(() => {
                    const allChecked = Array.from(rowCheckboxes).every(cb => cb
                    .checked);
                    const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);

                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = anyChecked && !allChecked;

                    updateTotalAmount();
                }, 0);
            });
        });

        // Initialize all checkboxes as unchecked by default
        window.addEventListener('load', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAllCheckbox.checked = false;
            updateTotalAmount(); // Update total amount after initialization
        });

        // Toast container setup
        if (!document.getElementById('toast-container')) {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(container);
        }

        // Next button functionality
        const nextButton = document.getElementById('nextButton');
        if (nextButton) {
            nextButton.addEventListener('click', function(e) {
                const selectedRows = [];
                rowCheckboxes.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const rowData = {
                            receipt_number: row.cells[2].textContent.trim(),
                            receipt_date: row.cells[3].querySelector('.date') ? row.cells[3]
                                .querySelector('.date').textContent.trim() : '',
                            receipt_time: row.cells[3].querySelector('.time') ? row.cells[3]
                                .querySelector('.time').textContent.trim() : '',
                            description: row.cells[4].textContent.trim(),
                            amount: row.cells[5].textContent.trim()
                        };

                        selectedRows.push(rowData);
                    }
                });

                if (selectedRows.length === 0) {
                    showToast('Please select at least one receipt to proceed.', 'danger');
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('collectors-receipt') }}';
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');
                form.appendChild(csrfInput);

                const dataInput = document.createElement('input');
                dataInput.type = 'hidden';
                dataInput.name = 'selectedReceipts';
                dataInput.value = JSON.stringify(selectedRows);
                form.appendChild(dataInput);

                const startDateInput = document.createElement('input');
                startDateInput.type = 'hidden';
                startDateInput.name = 'startDate';
                startDateInput.value = '{{ $startDate }}';
                form.appendChild(startDateInput);

                const endDateInput = document.createElement('input');
                endDateInput.type = 'hidden';
                endDateInput.name = 'endDate';
                endDateInput.value = '{{ $endDate }}';
                form.appendChild(endDateInput);

                document.body.appendChild(form);
                form.submit();
            });
        }

        function showToast(message, type = 'danger') {
            const toastContainer = document.getElementById('toast-container');

            const toastId = 'toast-' + Date.now();
            const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
            toastContainer.innerHTML = toastHtml;

            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                delay: 3000
            });

            toastElement.querySelector('.btn-close').addEventListener('click', function() {
                toast.hide();
            });

            toast.show();
        }
    });
</script>
