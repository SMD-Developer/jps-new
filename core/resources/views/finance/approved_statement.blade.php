<!-- @extends('app') -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* General Styles */
   

    /* Container */
    .content {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Header Styles */
    .content-header h5 {
        color: #2c3e50;
        margin: 0;
    }

    .content-header {
        background: #4a6fdc;
        color: white;
        padding: 15px 20px;
        margin-bottom: 0;
    }

    /* Summary Section */
    .summary-section {
        background: #f8f9fa;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e9ecef;
    }

    .summary-card {
        text-align: center;
        padding: 10px;
    }

    .summary-card h3 {
        margin: 0;
        color: #2c3e50;
    }

    .summary-card p {
        margin: 5px 0 0 0;
        color: #6c757d;
    }

    /* Table Container */
    .table-container {
        padding: 0;
        background: white;
    }

    /* Table Styles */
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 14px;
        background: white;
    }

    .modern-table thead {
        background: #f8f9fa;
    }

    .modern-table th {
        padding: 12px 10px;
        text-align: center;
        font-weight: 600;
        border: none;
        font-size: 13px;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
    }

    .modern-table td {
        padding: 12px 10px;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-reviewed {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
    }
    
    .status-rejected {
        background-color: #dc3545; /* Bootstrap danger red */
        color: #fff;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Action Button */
    .action-btn {
        background: #4a6fdc;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .action-btn:hover {
        background: #3b5fc7;
        color: white;
        text-decoration: none;
    }

    /* View Button */
    .view-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .view-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .view-btn i {
        font-size: 12px;
    }

    /* Amount styling */
    .amount-cell {
        font-weight: 600;
        color: #2c3e50;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Scrollable container */
    .table-scroll {
        overflow-x: auto;
    }

    /* Report period styling */
    .report-period {
        font-size: 11px;
        color: #6c757d;
        margin-top: 3px;
    }

    /* Days counter */
    .days-badge {
        background: #e9ecef;
        color: #495057;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 500;
    }

    .days-urgent {
        background: #f8d7da;
        color: #721c24;
    }

    .days-warning {
        background: #fff3cd;
        color: #856404;
    }
</style>

<title>@lang('app.new_assignment') | JPS</title>

@section('content')

<div class="col-md-12 content-header">
    <h5><i class="fa fa-tasks" aria-hidden="true"></i> Status Laporan</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Summary Section -->
            <div class="summary-section">
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-scroll">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Bil</th>
                                <th style="width: 120px;">Nombor Laporan</th>
                                <th style="width: 150px;">Tempoh Laporan</th>
                                <th style="width: 100px;">Jumlah (RM)</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 150px;">Disediakan Oleh</th>
                                <th style="width: 100px;">Tarikh Hantar</th>
                                <th style="width: 100px;">Untuk Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Make sure each table row has the correct ID --}}
                        @forelse($reports as $index => $report)
                        @php
                            // Use report_reviews data for display in the list
                            $reportData = null;
                            if (isset($report->review_report_data) && is_array($report->review_report_data)) {
                                $reportData = $report->review_report_data;
                            } elseif (isset($report->review_report_data)) {
                                $reportData = json_decode($report->review_report_data, true);
                            } else {
                                $reportData = [];
                            }
                            
                            // Determine the correct ID to use
                            $reportRowId = $report->approval_id ?? $report->review_id ?? $report->id;
                        @endphp

                        {{-- IMPORTANT: This tr tag must have the correct ID --}}
                        <tr id="report-row-{{ $reportRowId }}" data-report-id="{{ $reportRowId }}" data-report-number="{{ $report->report_number }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $report->report_number }}</strong>
                            </td>
                            <td>
                                @if(isset($reportData['formattedStartDate']) && isset($reportData['formattedEndDate']))
                                    {{ $reportData['formattedStartDate'] }}
                                    <div class="report-period">to {{ $reportData['formattedEndDate'] }}</div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="amount-cell">
                                @php
                                    $amount = $reportData['totalAmount'] ?? 0;
                                    
                                    if (is_string($amount)) {
                                        $cleanAmount = preg_replace('/[^\d.-]/', '', $amount);
                                        $numericAmount = is_numeric($cleanAmount) ? (float)$cleanAmount : 0;
                                    } else {
                                        $numericAmount = is_numeric($amount) ? (float)$amount : 0;
                                    }
                                @endphp
                                RM {{ number_format($numericAmount, 2) }}
                            </td>
                            <td>
                                @php
                                    // Show status from report_reviews or report_approvals
                                    $displayStatus = $report->review_status ?? $report->approval_status;
                                    $statusClass = 'status-pending';
                                    $statusText = ucfirst($displayStatus);
                            
                                    switch(strtolower($displayStatus)) {
                                        case 'pending':
                                            $statusClass = 'status-pending';
                                            $statusText = 'Menunggu Semakan';
                                            break;
                                        case 'under_review':
                                            $statusClass = 'status-under-review';
                                            $statusText = 'Sedang Disemak';
                                            break;
                                        case 'reviewed':
                                            $statusClass = 'status-reviewed';
                                            $statusText = 'Telah Disemak';
                                            break;
                                        case 'approved':
                                            $statusClass = 'status-approved';
                                            $statusText = 'Diluluskan';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'status-rejected';
                                            $statusText = 'Tolak';
                                            break;
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                {{-- Show original submitter from report_reviews --}}
                                {{ $report->review_submitter_name ?? 'Unknown' }}
                            </td>
                            <td>
                                @php
                                    // Show submission date from report_reviews table
                                    $createdDate = $report->review_created_at ? \Carbon\Carbon::parse($report->review_created_at) : null;
                                @endphp
                                {{ $createdDate ? $createdDate->format('d/m/Y') : '-' }}
                                <div class="report-period">
                                    {{ $createdDate ? $createdDate->format('H:i') : '' }}
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons" style="display: flex; gap: 5px; justify-content: center;">
                                    @if($report->approval_id)
                                        {{-- Show view button only if record exists in report_approvals --}}
                                        <a href="{{ route('finance.view_report', ['report_id' => $report->approval_id]) }}" 
                                        class="btn btn-primary btn-sm view-report"
                                        title="View Report Details"
                                        data-id="{{ $report->approval_id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @else
                                        {{-- Show disabled button or different action for review-only records --}}
                                        <span class="btn btn-secondary btn-sm disabled" title="Not yet submitted for approval">
                                            <i class="fa fa-clock"></i>
                                        </span>
                                    @endif
                                    
                                    {{-- Delete button with the same ID used in the row --}}
                                    <button type="button" 
                                        class="btn btn-danger btn-sm delete-report" 
                                        title="Delete Report"
                                        data-id="{{ $reportRowId }}"
                                        data-report-number="{{ $report->report_number }}"
                                        onclick="confirmDelete({{ $reportRowId }}, '{{ $report->report_number }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-state-row">
                            <td colspan="8" class="empty-state">
                                <i class="fa fa-inbox"></i>
                                <h4>Tiada Laporan Dijumpai</h4>
                                <p>Tiada laporan pembayaran yang menunggu semakan pada masa ini.</p>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                  
            
                    <!-- Add this pagination section after the table -->
                    @if($reports->hasPages())
                    <div class="pagination-container" style="padding: 20px; display: flex; justify-content: space-between; align-items: center; background: #f8f9fa; border-top: 1px solid #e9ecef;">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Showing {{ $reports->firstItem() ?? 0 }} to {{ $reports->lastItem() ?? 0 }} of {{ $reports->total() }} results
                            </small>
                        </div>
                        <div class="pagination-links">
                            {{ $reports->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

  <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JavaScript for Delete Functionality using SweetAlert2 --}}
    <script>
        function confirmDelete(reportId, reportNumber) {
            Swal.fire({
                title: 'Adakah anda pasti?',
                text: `Anda akan memadamkan laporan: ${reportNumber}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, padamkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteReport(reportId);
                }
            });
        }

        function deleteReport(reportId) {
            // Show loading alert
            Swal.fire({
                title: 'Memadamkan...',
                text: 'Sila tunggu semasa kami memadamkan laporan.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                console.error('CSRF token not found');
                Swal.fire({
                    title: 'Error!',
                    text: 'CSRF token tidak dijumpai. Sila muat semula halaman.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Make AJAX request using fetch
            fetch(`/finance/reports/${reportId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token.getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    // Try to get error message from response
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                    }).catch(() => {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                
                if (data.success) {
                    // First close the loading alert
                    Swal.close();
                    
                    // Find and remove the row from table
                    const row = document.getElementById(`report-row-${reportId}`);
                    console.log('Found row:', row);
                    
                    if (row) {
                        // Add fade out animation
                        row.style.transition = 'all 0.3s ease-out';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-20px)';
                        
                        // Remove row after animation
                        setTimeout(() => {
                            row.remove();
                            console.log('Row removed successfully');
                            
                            // Check if table is now empty
                            checkIfTableEmpty();
                            
                            // Update row numbers
                            updateRowNumbers();
                            
                        }, 300);
                    } else {
                        console.warn(`Row with ID report-row-${reportId} not found`);
                    }
                    
                    // Show success message
                    Swal.fire({
                        title: 'Berjaya Dipadamkan!',
                        text: data.message || 'Laporan telah berjaya dipadamkan.',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    
                } else {
                    // Show error message
                    Swal.fire({
                        title: 'Ralat!',
                        text: data.message || 'Gagal memadamkan laporan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                
                Swal.fire({
                    title: 'Ralat!',
                    text: 'Ralat berlaku semasa memadamkan laporan. Sila cuba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }

        // Function to check if table is empty and show empty state
        function checkIfTableEmpty() {
            const tbody = document.querySelector('.modern-table tbody');
            const dataRows = tbody.querySelectorAll('tr:not(.empty-state-row)');
            
            if (dataRows.length === 0) {
                // Add empty state row
                const emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-state-row';
                emptyRow.innerHTML = `
                    <td colspan="8" class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <h4>Tiada Laporan Dijumpai</h4>
                        <p>Tiada laporan pembayaran yang menunggu semakan pada masa ini.</p>
                    </td>
                `;
                tbody.appendChild(emptyRow);
            }
        }

        // Function to update row numbers after deletion
        function updateRowNumbers() {
            const tbody = document.querySelector('.modern-table tbody');
            const dataRows = tbody.querySelectorAll('tr:not(.empty-state-row)');
            
            dataRows.forEach((row, index) => {
                const firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.textContent = index + 1;
                }
            });
        }

        // Alternative jQuery version (if you prefer jQuery)
        function deleteReportJQuery(reportId) {
            // Show loading alert
            Swal.fire({
                title: 'Memadamkan...',
                text: 'Sila tunggu semasa kami memadamkan laporan.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Setup CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: `/finance/reports/${reportId}/delete`,
                type: 'DELETE',
                dataType: 'json',
                timeout: 30000, // 30 seconds timeout
                success: function(data) {
                    console.log('Success response:', data);
                    
                    if (data.success) {
                        // Close loading alert
                        Swal.close();
                        
                        // Remove row with animation
                        const $row = $(`#report-row-${reportId}`);
                        console.log('Found row:', $row.length);
                        
                        if ($row.length > 0) {
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                console.log('Row removed successfully');
                                
                                // Check if table is empty
                                checkIfTableEmptyJQuery();
                                
                                // Update row numbers
                                updateRowNumbersJQuery();
                            });
                        } else {
                            console.warn(`Row with ID report-row-${reportId} not found`);
                        }
                        
                        // Show success message
                        Swal.fire({
                            title: 'Berjaya Dipadamkan!',
                            text: data.message || 'Laporan telah berjaya dipadamkan.',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                        
                    } else {
                        Swal.fire({
                            title: 'Ralat!',
                            text: data.message || 'Gagal memadamkan laporan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Delete error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    
                    let errorMessage = 'Ralat berlaku semasa memadamkan laporan.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (status === 'timeout') {
                        errorMessage = 'Permintaan telah tamat masa. Sila cuba lagi.';
                    } else if (status === 'error' && xhr.status === 0) {
                        errorMessage = 'Tiada sambungan rangkaian. Sila semak sambungan internet anda.';
                    }
                    
                    Swal.fire({
                        title: 'Ralat!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // jQuery versions of helper functions
        function checkIfTableEmptyJQuery() {
            const $tbody = $('.modern-table tbody');
            const $dataRows = $tbody.find('tr:not(.empty-state-row)');
            
            if ($dataRows.length === 0) {
                const emptyRow = `
                    <tr class="empty-state-row">
                        <td colspan="8" class="empty-state">
                            <i class="fa fa-inbox"></i>
                            <h4>Tiada Laporan Dijumpai</h4>
                            <p>Tiada laporan pembayaran yang menunggu semakan pada masa ini.</p>
                        </td>
                    </tr>
                `;
                $tbody.append(emptyRow);
            }
        }

        function updateRowNumbersJQuery() {
            $('.modern-table tbody tr:not(.empty-state-row)').each(function(index) {
                $(this).find('td:first-child').text(index + 1);
            });
        }

        // Optional: Add a function to reload the page if needed
        function reloadPageData() {
            window.location.reload();
        }

    </script>

@endsection