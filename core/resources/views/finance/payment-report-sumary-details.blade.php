@extends('app')
<style>
    body {
        font-family: 'Calibri', Arial, sans-serif;
        font-size: 11px;
        background-color: #f8f9fa;
    }

    /* Excel-like table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    
     .report-header {
        padding: 20px;
        background: linear-gradient(135deg, #f6f8fa 0%, #ffffff 100%);
        border-bottom: 2px solid #0969da;
    }

    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }


    th {
        background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid #999999;
        border-right: 2px solid #999999;
        border-left: 2px solid #999999;
        padding: 8px 6px;
        text-align: center;
        font-weight: 600;
        font-size: 11px;
        color: #333;
        position: relative;
    }

    th::after {
        content: '';
        position: absolute;
        right: -1px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #999999;
        z-index: 1;
    }
    
    
    
       .department-info-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 13px;
    }

    .department-info-table th {
        background: #f0f0f0;
        color: #333;
        padding: 12px 15px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #ccc;
        font-size: 13px;
        text-transform: uppercase;
    }

    .department-info-table td {
        padding: 10px 15px;
        border: 1px solid #ccc;
        vertical-align: middle;
    }

    .department-info-table .label-cell {
        background: #f9f9f9;
        font-weight: 600;
        color: #333;
        width: 15%;
        text-align: center;
    }

    .department-info-table .code-cell {
        background: #ffffff;
        width: 20%;
        color: #333;
        font-weight: 500;
    }

    .department-info-table .description-cell {
        background: #ffffff;
        width: 65%;
        color: #333;
    }


    th:last-child::after {
        display: none;
    }

    td {
        border: 1px solid #999999;
        border-right: 2px solid #999999;
        border-left: 2px solid #999999;
        padding: 6px 8px;
        text-align: left;
        background-color: white;
        vertical-align: middle;
        position: relative;
    }

    td::after {
        content: '';
        position: absolute;
        right: -1px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #999999;
        z-index: 1;
    }

    td:last-child::after {
        display: none;
    }

    /* Excel-like hover effect */
    tbody tr:hover {
        background-color: #f0f8ff;
    }

    tbody tr:hover td {
        background-color: #f0f8ff;
    }

    /* Excel-like cell selection effect */
    td:hover {
        background-color: #e6f3ff !important;
        cursor: cell;
    }

    /* Zebra striping like Excel */
    tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    tbody tr:nth-child(even) td {
        background-color: #fafafa;
    }
    
    
    .main-title {
        text-align: center;
        flex: 1;
        padding: 0 20px;
    }

    .main-title h1 {
        font-size: 15px;
        font-weight: 600;
        color: #24292f !important;
        text-transform: uppercase;
        line-height: 1.3;
        margin-bottom: 5px;
    }

    .main-title h2 {
        font-size: 15px;
        font-weight: 600;
        color: #24292f !important;
        text-transform: uppercase;
        line-height: 1.3;
        margin-bottom: 5px;
    }

    .main-title p {
        font-size: 14px;
        text-transform: uppercase;
    }

    .scrollbar {
        overflow-x: auto;
        border: 2px solid #999999;
        border-radius: 3px;
    }

    .form-container {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background: white;
        margin: 15px 0;
    }

    .summary-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .summary-box h6 {
        color: rgba(255, 255, 255, 0.9);
        font-size: 12px;
        margin-bottom: 5px;
    }

    .summary-box h4 {
        color: white;
        font-weight: bold;
        margin: 0;
    }

    .amount-column {
        text-align: right;
        font-weight: 500;
        font-family: 'Courier New', monospace;
    }

    .transaction-column {
        text-align: center;
        font-weight: 500;
    }

    .total-row {
        background: linear-gradient(to bottom, #28a745 0%, #20c997 100%) !important;
        font-weight: bold;
        color: white;
    }

    .total-row td {
        background: transparent !important;
        border-color: #999999;
        border-width: 2px;
        font-weight: bold;
    }
    
     .date-time-info {
        font-size: 12px;
        line-height: 1.4;
    }

    .date-time-info strong {
        color: #24292f;
        font-weight: 600;
    }

    .header-info {
        border: 2px solid #495057;
        padding: 15px;
        margin-bottom: 20px;
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-radius: 5px;
    }

    .header-info table {
        box-shadow: none;
        margin: 0;
    }

    .header-info th {
        background: #495057;
        color: white;
        font-weight: bold;
    }

    /* Excel-like grid lines */
    .excel-grid {
        position: relative;
    }

    .excel-grid::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            linear-gradient(90deg, #e0e0e0 1px, transparent 1px),
            linear-gradient(180deg, #e0e0e0 1px, transparent 1px);
        background-size: 20px 20px;
        pointer-events: none;
        opacity: 0.3;
    }

    /* Excel-like column headers */
    .excel-column {
        background: linear-gradient(to bottom, #f1f3f4 0%, #e8eaed 100%);
        font-weight: 600;
        text-align: center;
        min-width: 80px;
    }

    /* Print button styling */
    .btn-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
    }

    /* Header table specific styles */
    .header-table {
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: none;
    }

    .header-table td {
        border: 1px solid #999;
        padding: 8px;
        background-color: white;
        vertical-align: top;
        position: static;
    }

    .header-table td::after {
        display: none;
    }

    .dept-table {
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: none;
    }

    .dept-table th {
        padding: 8px;
        border: 1px solid #999;
        background: #f0f0f0;
        text-align: center;
        position: static;
    }

    .dept-table th::after {
        display: none;
    }

    .dept-table td {
        padding: 8px;
        border: 1px solid #999;
        position: static;
    }

    .dept-table td::after {
        display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .scrollbar {
            font-size: 10px;
        }

        th,
        td {
            padding: 4px;
            font-size: 10px;
        }
    }

    /* Print styles - Fixed */
    @media print {
        body {
            background: white;
            font-size: 11px;
        }

        .form-container,
        .summary-box,
        .header-info {
            box-shadow: none;
            border: 1px solid #000;
            background: white !important;
        }

        #print-button {
            display: none;
        }

        /* Preserve header table layout in print */
        .header-table,
        .dept-table {
            box-shadow: none;
            page-break-inside: avoid;
        }

        .header-table td,
        .dept-table td,
        .dept-table th {
            border: 1px solid #000 !important;
            background: white !important;
            position: static !important;
        }

        .header-table td::after,
        .dept-table td::after,
        .dept-table th::after {
            display: none !important;
        }

        /* Ensure main table prints correctly */
        table {
            box-shadow: none;
            page-break-inside: auto;
        }

        th, td {
            border: 1px solid #000 !important;
            background: white !important;
            position: static !important;
        }

        th::after, td::after {
            display: none !important;
        }

        .excel-column {
            background: #f0f0f0 !important;
        }

        .total-row {
            background: #28a745 !important;
        }

        .total-row td {
            background: #28a745 !important;
            color: white !important;
        }

        .summary-box {
            background: #667eea !important;
            color: white !important;
        }
    }
</style>

<title>{{ $title ?? 'Payment Summary Report' }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-money" aria-hidden="true"></i> {{ $title ?? 'Payment Summary Report' }}</h5>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Header that repeats on each page -->
                <div class="page-header">
                    <div class="report-header">
                                <div class="header-row">
                                    <div class="date-time-info">
                                        <p><strong>TARIKH: {{ $reportData['currentDate'] }}</strong></p>
                                        <p><strong>MASA: {{ $reportData['currentTime'] }}</strong></p>
                                    </div>
                                    <div class="main-title">
                                        <h1>KERAJAAN NEGERI SELANGOR DARUL EHSAN</h1>
                                        <strong>LAPORAN RINGKASAN PEMBAYARAN MENGIKUT TARIKH</strong><br>
                                        <p><strong>{{ \Carbon\Carbon::parse($reportData['start_date'])->format('d/m/Y') }} HINGGA
                                         {{ \Carbon\Carbon::parse($reportData['end_date'])->format('d/m/Y') }}</strong></p>
                                    </div>
                                    <div class="page-info">
                                        <p><strong>MUKA SURAT : 1/1</strong></p>
                                    </div>
                                </div>

                                <!-- Department Information Table -->
                                <table class="department-info-table">
                                    <thead>
                                        <tr>
                                            <th>MENERIMA</th>
                                            <th>KOD</th>
                                            <th>PERIHAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>JABATAN</strong></td>
                                            <td><strong>: 021000</strong></td>
                                            <td><strong>JABATAN PENGAIRAN & SALIRAN SELANGOR</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>PTJ</strong></td>
                                            <td><strong>: 21000000</strong></td>
                                            <td><strong>PENGARAH PENGAIRAN & SALIRAN</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                </div>


                <!-- Summary Statistics -->
                <!--<div class="summary-box">-->
                <!--    <div class="row">-->
                <!--        <div class="col-md-4">-->
                <!--            <h6><strong>JUMLAH HARI:</strong></h6>-->
                <!--            <h4>{{ count($reportData['payments']) }}</h4>-->
                <!--        </div>-->
                <!--        <div class="col-md-4">-->
                <!--            <h6><strong>JUMLAH TRANSAKSI:</strong></h6>-->
                <!--            <h4>{{ number_format($reportData['total_payments']) }}</h4>-->
                <!--        </div>-->
                <!--        <div class="col-md-4">-->
                <!--            <h6><strong>JUMLAH KESELURUHAN:</strong></h6>-->
                <!--            <h4>RM {{ number_format($reportData['total_amount'], 2) }}</h4>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <!-- Main Report Table -->
                <div class="form-container excel-grid">
                    <div class="scrollbar">
                        <table>
                            <thead>
                                <tr>
                                    <th class="excel-column">@lang('app.bil')</th>
                                    <th class="excel-column">TARIKH PEMBAYARAN</th>
                                    <th class="excel-column">JUMLAH TRANSAKSI</th>
                                    <th class="excel-column">JUMLAH AMAUN (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grandTotalAmount = 0;
                                    $grandTotalTransactions = 0;
                                @endphp
                                @foreach ($reportData['payments'] as $index => $payment)
                                    <tr>
                                        <td class="transaction-column">{{ $index + 1 }}</td>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="transaction-column">{{ number_format($payment->transaction_count) }}
                                        </td>
                                        <td class="amount-column">{{ number_format($payment->total_amount, 2) }}</td>
                                    </tr>
                                    @php
                                        $grandTotalAmount += $payment->total_amount;
                                        $grandTotalTransactions += $payment->transaction_count;
                                    @endphp
                                @endforeach

                                <!-- Total Row -->
                                <tr class="total-row">
                                    <td colspan="2" class="text-center"><strong>JUMLAH KESELURUHAN</strong></td>
                                    <td class="transaction-column">
                                        <strong>{{ number_format($grandTotalTransactions) }}</strong></td>
                                    <td class="amount-column"><strong>{{ number_format($grandTotalAmount, 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Method Summary -->
                    @if (!empty($reportData['method_summary']))
                        <div class="mt-4">
                            <h6><strong>RINGKASAN MENGIKUT KAEDAH PEMBAYARAN:</strong></h6>
                            <div class="row">
                                @foreach ($reportData['method_summary'] as $method => $summary)
                                    <div class="col-md-3 mb-2">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <h6 class="card-title">{{ $method ?? 'N/A' }}</h6>
                                                <p class="card-text">
                                                    <small>Bilangan: {{ $summary['count'] }}</small><br>
                                                    <strong>RM {{ number_format($summary['total_amount'], 2) }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                   <!-- Status Summary -->
                    @if (!empty($reportData['status_summary']))
                        <div class="mt-4">
                            <h6><strong>RINGKASAN MENGIKUT STATUS:</strong></h6>
                            <div class="row">
                                @foreach ($reportData['status_summary'] as $status => $summary)
                                    @php
                                        $statusLabel = match($status) {
                                            'completed' => 'Selesai',
                                            'pending' => 'Belum Bayar',
                                            'pending_authorization' => 'Menunggu Kelulusan',
                                            'in_review'=> 'Dalam Semakan',
                                            default => $status ?? 'N/A',
                                        };
                                    @endphp
                    
                                    <div class="col-md-3 mb-2">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <h6 class="card-title">{{ $statusLabel }}</h6>
                                                <p class="card-text">
                                                    <small>Bilangan: {{ $summary['count'] }}</small><br>
                                                    <strong>RM {{ number_format($summary['total_amount'], 2) }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    <!-- Print Button -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-primary" id="print-button" onclick="window.print()">
                            <i class="fa fa-print"></i> @lang('app.print')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection