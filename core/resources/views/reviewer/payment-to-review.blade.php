<!-- @extends('app') -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Container */
    .content {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Header Styles */
    .content-header h5 {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        font-size: 1.25rem;
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
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .summary-card p {
        margin: 5px 0 0 0;
        color: #6c757d;
        font-size: 0.9rem;
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
    /*.days-badge {*/
    /*    background: #e9ecef;*/
    /*    color: #495057;*/
    /*    padding: 3px 8px;*/
    /*    border-radius: 10px;*/
    /*    font-size: 11px;*/
    /*    font-weight: 500;*/
    /*}*/

    .days-urgent {
        background: #f8d7da;
        color: #721c24;
    }

    .days-warning {
        background: #fff3cd;
        color: #856404;
    }
</style>

<title>Status Laporan | JPS</title>

@section('content')

<div class="col-md-12 content-header">
    <h5><i class="fa fa-tasks" aria-hidden="true"></i> Status Laporan</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
    
                <div class="summary-cards">
                    <h3>
                             @if($reports->count() > 0)
                            @php
                                $totalAmount = $reports->sum(function($report) { 
                                    $amount = $report->report_data['totalAmount'] ?? 0;
                                    
                                    // Remove commas from the amount string before converting to float
                                    if (is_string($amount)) {
                                        $cleanAmount = str_replace(',', '', $amount);
                                        return is_numeric($cleanAmount) ? (float)$cleanAmount : 0;
                                    }
                                    
                                    // If it's already a number, just return it
                                    return is_numeric($amount) ? (float)$amount : 0;
                                });
                            @endphp
                            <!--RM {{ number_format($totalAmount, 2) }}-->
                        @else
                            RM 0.00
                        @endif
                    </h3>
                </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-scroll">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
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
                            @forelse($reports as $index => $report)
                            @php
                                $reportData = is_array($report->report_data) ? $report->report_data : json_decode($report->report_data, true);
                            @endphp
                            <tr>
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
                                        $statusClass = 'status-pending';
                                        $statusText = ucfirst($report->status);
                                        
                                        switch(strtolower($report->status)) {
                                            case 'pending':
                                                $statusClass = 'status-pending';
                                                $statusText = 'Menunggu Semakan';
                                                break;
                                            case 'rejected':
                                                $statusClass = 'status-reviewed';
                                                $statusText = 'Tolak';
                                                break;
                                            case 'approved':
                                                $statusClass = 'status-approved';
                                                $statusText = 'Diluluskan';
                                                break;
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    {{ $report->submitter_name ?? 'Unknown' }}
                                </td>
                                <td>
                                    @php
                                        $createdDate = $report->created_at ? \Carbon\Carbon::parse($report->created_at) : null;
                                    @endphp
                                    {{ $createdDate ? $createdDate->format('d/m/Y') : '-' }}
                                    <div class="report-period">
                                        {{ $createdDate ? $createdDate->format('H:i') : '' }}
                                    </div>
                                </td>
                                <td>
                                    <!--<a href="{{ route('collector.receipt.reviewer', ['report_id' => $report->id]) }}" class="action-btn">-->
                                    <!--    <i class="fa fa-eye"></i> Review-->
                                    <!--</a>-->
                                    <a href="{{ route('collector.receipt.reviewer', ['report_id' => $report->id]) }}"
                                       class="btn btn-primary btn-sm view-application"
                                       data-id="{{ $report->id }}">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <i class="fa fa-inbox"></i>
                                    <h4>No Reports Found</h4>
                                    <p>There are no payment reports pending for review at the moment.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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

@endsection