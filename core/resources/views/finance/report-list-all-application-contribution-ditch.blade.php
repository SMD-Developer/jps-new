@extends('app')

<style>
    /* Excel-like styling with larger fonts */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 13px;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .report-container {
        width: 100%;
        max-width: 1200px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        margin: 20px auto;
        background: white;
        border: 1px solid #d0d7de;
        box-shadow: 0 1px 3px rgba(16, 24, 40, 0.1);
        overflow: hidden;
    }

    /* Header Section */
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

    .date-time-info {
        font-size: 12px;
        line-height: 1.4;
    }

    .date-time-info strong {
        color: #24292f;
        font-weight: 600;
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

    .main-title p {
        font-size: 14px;
        text-transform: uppercase;
    }

    .page-info {
        font-size: 12px;
        color: #656d76;
        text-align: right;
    }

    .page-info strong {
        color: #24292f;
        font-weight: 600;
    }

    /* Department Info Table - Excel Style */
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

    /* Main Data Table - Excel Style */
    .main-data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 12px;
    }

    .main-data-table th {
        background: #f0f0f0;
        color: #333;
        padding: 12px 8px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #ccc;
        font-size: 12px;
        text-transform: uppercase;
        line-height: 1.2;
        vertical-align: middle;
    }

    .main-data-table td {
        padding: 8px;
        border: 1px solid #ccc;
        vertical-align: middle;
        background: white;
    }

    .main-data-table tbody tr:nth-child(even) {
        background: #f9f9f9;
    }

    .main-data-table tbody tr:hover {
        background: #e8f4f8;
    }

    /* Column specific styling */
    .main-data-table .col-bil {
        width: 4%;
        text-align: center;
        font-weight: 600;
        color: #333;
    }

    .main-data-table .col-resit {
        width: 10%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-perihal {
        width: 20%;
        text-align: left;
        color: #333;
    }

    .main-data-table .col-nama {
        width: 15%;
        text-align: left;
        color: #333;
    }

    .main-data-table .col-kategori {
        width: 10%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-vot {
        width: 6%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-kod {
        width: 8%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-tarikh {
        width: 8%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-masa {
        width: 7%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-mod {
        width: 8%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-jenis {
        width: 7%;
        text-align: center;
        color: #333;
    }

    .main-data-table .col-kategori-bank {
        width: 12%;
        text-align: center;
        color: #333;
        font-size: 11px;
    }

    .main-data-table .col-jumlah {
        width: 8%;
        text-align: right;
        color: #333;
        font-size: 11px;
    }

    /* Action Buttons */
    .action-section {
        padding: 20px;
        background: #f6f8fa;
        border-top: 1px solid #d0d7de;
        text-align: right;
    }

    .btn-print {
        background: linear-gradient(135deg, #0969da 0%, #54aeff 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(16, 24, 40, 0.1);
        transition: all 0.2s ease;
    }

    .btn-print:hover {
        background: linear-gradient(135deg, #0550ae 0%, #368ce7 100%);
        box-shadow: 0 3px 6px rgba(16, 24, 40, 0.15);
        transform: translateY(-1px);
    }

    /* Repeating header wrapper */
    .report-wrapper {
        width: 100%;
        border-collapse: collapse;
    }

    .report-wrapper thead {
        display: table-header-group;
    }

    .report-wrapper tbody {
        display: table-row-group;
    }

    /* Print Styles */
    @media print {
        body {
            background: white;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        
        .report-container {
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }
        
        .header-row {
            border: none !important;
            margin-bottom: 10px;
            padding: 5px 0;
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: center;
            width: 100%;
        }

        .header-row .date-time-info {
            text-align: left !important;
        }
    
        .header-row .main-title {
            text-align: center !important;
        }
    
        .header-row .page-info {
            text-align: right !important;
        }
    
        .department-info-table {
            border: 1px solid #000 !important; 
            border-collapse: collapse !important;
            width: 100% !important;
            table-layout: fixed !important;
            margin: 10px 0 !important;
        }
    
        .department-info-table th,
        .department-info-table td {
            border: 1px solid #000 !important; 
            padding: 4px !important;
            word-wrap: break-word !important;
            background: white !important;
        }
        
        .department-info-table th {
            background: #f0f0f0 !important;
        }
        
        #btn-section {
            display: none !important;
        }

        .report-wrapper {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        .report-wrapper thead {
            display: table-header-group;
        }

        .report-wrapper tbody {
            display: table-row-group;
        }

        .report-wrapper thead tr td {
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        .report-wrapper tbody tr:first-child td {
            page-break-before: avoid;
        }

        .report-header {
            padding: 10px 0 !important;
            background: white !important;
            border: none !important;
        }

        .main-data-table {
            border: 1px solid #000 !important;
            border-collapse: collapse !important;
            page-break-inside: auto;
        }

        .main-data-table thead {
            display: table-header-group;
        }

        .main-data-table tbody {
            display: table-row-group;
        }

        .main-data-table th,
        .main-data-table td {
            border: 1px solid #000 !important;
            background: white !important;
            padding: 4px !important;
        }

        .main-data-table th {
            background: #f0f0f0 !important;
        }

        .main-data-table tbody tr:nth-child(even) {
            background: #f9f9f9 !important;
        }

        .main-data-table tbody tr:last-child {
            background: #f0f0f0 !important;
            font-weight: bold !important;
        }
    }

    .summary-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 12px;
    }

    .summary-table th {
        background: #f0f0f0;
        color: #333;
        padding: 12px 8px;
        text-align: center;
        font-weight: 600;
        border: 1px solid #ccc;
        font-size: 12px;
        text-transform: uppercase;
    }

    .summary-table td {
        padding: 8px;
        border: 1px solid #ccc;
        vertical-align: middle;
        background: white;
    }

    .summary-table tbody tr:nth-child(even) {
        background: #f9f9f9;
    }

    .summary-table tbody tr:hover {
        background: #e8f4f8;
    }
    
    /* Section headers */
    h6 {
        font-size: 14px;
        font-weight: 600;
        margin: 15px 0 10px 0;
        color: #333;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .report-container {
            margin: 10px;
        }

        .header-row {
            flex-direction: column;
            text-align: center;
        }

        .main-data-table {
            font-size: 11px;
        }

        .main-data-table th,
        .main-data-table td {
            padding: 6px 4px;
        }
    }
</style>

<title></title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> Laporan Senarai Pemohon Caruman Parit</h5>
    </div>

    <section>
        <div class="report-container">
            <!-- Main Report Table with Repeating Header -->
            <table class="report-wrapper">
                <thead>
                    <tr>
                        <td style="padding: 0; border: none;">
                            <!-- Header Section that repeats on each page -->
                            <div class="report-header">
                                <div class="header-row">
                                    <div class="date-time-info">
                                        <p><strong>TARIKH: {{ $currentDate }}</strong></p>
                                        <p><strong>MASA: {{ $currentTime }}</strong></p>
                                    </div>
                                    <div class="main-title">
                                        <h1>KERAJAAN NEGERI SELANGOR DARUL EHSAN</h1>
                                        <p><strong>
                                            LAPORAN SENARAI PEMOHON CARUMAN PARIT
                                            {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
                                            HINGGA {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                                        </strong></p>
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
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 0; border: none;">
                            <!-- Main Data Section -->
                            <div style="padding: 0 20px;">
                                <table class="main-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('app.bil')</th>
                                            <th>@lang('app.date')</th>
                                            <th>@lang('app.account_type')</th>
                                            <th>@lang('app.applicant_name')</th>
                                            <th>@lang('app.lot_pt')</th>
                                            <th>@lang('app.total_contribution')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applications as $index => $application)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($application->deposit_date)
                                                        <div style="text-align: center;">
                                                            {{ \Carbon\Carbon::parse($application->deposit_date)->format('d/m/Y') }}
                                                        </div>
                                                        <div style="text-align: center; font-size: 11px; color: #555;">
                                                            {{ \Carbon\Carbon::parse($application->deposit_date)->format('h:i A') }}
                                                        </div>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $application->account_type_name ?? 'N/A' }}</td>
                                                <td>{{ $application->applicant ?? 'N/A' }}</td>
                                                <td>{{ $application->land_lot ?? 'N/A' }}</td>
                                                <td style="text-align: right;">RM {{ number_format($application->final_amount, 2) }}</td>
                                            </tr>
                                        @endforeach

                                        <!-- Grand Total Row -->
                                        <tr style="background-color: #f0f0f0; font-weight: bold;">
                                            <td colspan="5" style="text-align: right;">JUMLAH :</td>
                                            <td style="text-align: right;">RM {{ number_format($applications->sum('final_amount'), 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Print Button -->
            <div class="action-section" id="btn-section">
                <button onclick="window.print()" class="btn-print">{{ trans('app.print') }}</button>
            </div>
        </div>
    </section>
@endsection