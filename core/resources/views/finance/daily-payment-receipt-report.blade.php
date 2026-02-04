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
        text-align: center;
        vertical-align: middle;
        background: white;
    }

    .main-data-table tbody tr:nth-child(even) {
        background: #f9f9f9;
    }

    .main-data-table tbody tr:hover {
        background: #e8f4f8;
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
    
    h6 {
        font-size: 14px;
        font-weight: 600;
        margin: 15px 0 10px 0;
        color: #333;
    }

    .btn-prints {
        background: linear-gradient(135deg, #e6e33eff 0%, #bbb121ff 100%);
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


    .report-wrapper {
        width: 100%;
        border-collapse: collapse;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .report-container {
            max-width: 100%;
            margin: 0;
            border: none;
            box-shadow: none;
        }

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

        .report-wrapper thead td {
            padding: 0 !important;
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
        }
    
        .department-info-table th,
        .department-info-table td {
            border: 1px solid #000 !important; 
            padding: 4px !important;
            word-wrap: break-word !important;
        }
        
        #btn-section {
            display: none !important;
        }

        .main-data-table,
        .main-data-table th,
        .main-data-table td {
            border-collapse: collapse !important;
            border: 1px solid #000 !important;
            word-wrap: break-word !important;
            white-space: normal !important;
        }

        .main-data-table {
            width: 100% !important;
            table-layout: auto !important;
        }

        .main-data-table th,
        .main-data-table td {
            padding: 6px 4px !important;
            font-size: 10px !important;
        }

        .main-data-table thead {
            display: table-header-group; 
        }

        .summary-table,
        .summary-table th,
        .summary-table td {
            border: 1px solid #000 !important;
        }

        .main-data-table tr,
        .summary-table tr,
        .department-info-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .report-header {
            background: white !important;
            border-bottom: 2px solid #000 !important;
        }
    }
</style>

<title>{{ trans('app.daily_payment_receipt_report') }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> {{ trans('app.daily_payment_receipt_report_by') }}</h5>
    </div>

    <section>
        <div class="report-container">
            <table class="report-wrapper">
                <thead>
                    <tr>
                        <td>
                            <div class="report-header">
                                <div class="header-row">
                                    <div class="date-time-info">
                                        <p><strong>TARIKH: {{ $currentDate }}</strong></p>
                                        <p><strong>MASA: {{ $currentTime }}</strong></p>
                                    </div>
                                    <div class="main-title">
                                        <h1>KERAJAAN NEGERI SELANGOR DARUL EHSAN</h1>
                                        <p><strong>
                                            LAPORAN TERIMAAN HARIAN MENGIKUT JENIS DARI
                                            {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
                                            HINGGA {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                                        </strong></p>
                                    </div>
                                    <div class="page-info">
                                        <p><strong></strong></p>
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
                                            <td><strong>021000</strong></td>
                                            <td><strong>JABATAN PENGAIRAN & SALIRAN SELANGOR</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>PTJ</strong></td>
                                            <td><strong>21000000</strong></td>
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
                        <td style="padding: 0;">
                            <!-- Main Data Section -->
                            <div style="padding: 0 20px;">
                                <table class="main-data-table">
                                    <thead>
                                        <tr>
                                            <th>BIL.</th>
                                            <th>NOMBOR RESIT</th>
                                            <th>TARIKH URUSNIAGA</th>
                                            <th>MASA URUSNIAGA</th>
                                            <th>PERIHAL</th>
                                            <th>NAMA PEMBAYAR</th>
                                            <th>KATEGORI PEMBAYAR</th>
                                            <th>VOT DANA</th>
                                            <th>KOD HASIL</th>
                                            <th>Amaun (RM)</th>
                                            <th>MOD TERIMAAN</th>
                                            <th>KATEGORI TRANSAKSI PERBANKAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                        $grandTotal = 0;
                                        $totalCharges = 0;
                                        $charge = 0;
                                        $transactionCategory = 'N/A';
                                        @endphp
                                        @foreach ($applications as $index => $application)
                                            @php
                                                $grandTotal += $application->payment_amount;
                                                $isReprint = strtolower(trim($application->payment_type ?? '')) === 'reprint';
                                                $isThirdParty = strtolower(trim($application->payment_type ?? '')) === 'third_party';
                                                
                                                if ($isReprint || $isThirdParty) {
                                                    $amount = $application->payment_amount;
                                                } else {
                                                    $firstHalf = floor($application->payment_amount * 100 / 2) / 100;
                                                    $secondHalf = $application->payment_amount - $firstHalf;
                                                    $amount = $firstHalf; 
                                                }
                                                
                                                $method = $application->methods ?? '';
                                                if (stripos($method, 'FPX_B2B') !== false) {
                                                    $transactionCategory = 'B2B';
                                                    $charge = 1.0;
                                                } elseif (stripos($method, 'FPX_B2C') !== false) {
                                                    $transactionCategory = 'B2C';
                                                    $charge = 0.5;
                                                }
                                                elseif (stripos($method, 'bank_draf') !== false) {
                                                    $transactionCategory = 'MANUAL';
                                                } 
                                                elseif (stripos($method, 'cheque') !== false) {
                                                    $transactionCategory = 'MANUAL';
                                                    $charge = 0;
                                                }
                                                else {
                                                    if (isset($application->account_type_name) && 
                                                        strtoupper(trim($application->account_type_name)) === 'AGENSI KERAJAAN') {
                                                        $transactionCategory = 'BAUCAR BAYARAN';
                                                    } else {
                                                        $transactionCategory = 'N/A';
                                                    }
                                                    $charge = 0;
                                                }
                                                $totalCharges += $charge;
                                                
                                                $kodHasil = ($isReprint || $isThirdParty) ? 'H0272499' : 'H0161304';
                                                $rowspan = ($isReprint || $isThirdParty) ? '1' : '2';
                                            @endphp
                                            
                                            <tr>
                                                <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                                                <td rowspan="{{ $rowspan }}">{{ $application->receipt_numbers ?? 'N/A' }}</td>
                                                <td rowspan="{{ $rowspan }}">{{ $application->payment_date ? date('d/m/Y', strtotime($application->payment_date)) : 'N/A' }}</td>
                                                <td rowspan="{{ $rowspan }}">{{ $application->payment_created_at ? date('H:i:s', strtotime($application->payment_created_at)) : 'N/A' }}</td>
                                                <td rowspan="{{ $rowspan }}">
                                                    {{ strtoupper($application->land_lot) }},
                                                    {{ strtoupper($application->division_name) }},
                                                    DAERAH {{ strtoupper($application->district_name) }}, SELANGOR
                                                </td>
                                                <td rowspan="{{ $rowspan }}">
                                                    @if($isThirdParty && !empty($application->buyer_name))
                                                        {{ strtoupper($application->buyer_name) }}
                                                    @else
                                                        {{ strtoupper($application->applicant ?? 'N/A') }}
                                                    @endif
                                                </td>
                                                <td rowspan="{{ $rowspan }}">{{ strtoupper($application->account_type_name) }}</td>
                                                <td>G001</td>
                                                <td>{{ $kodHasil }}</td>
                                                <td>{{ ($isReprint || $isThirdParty) ? number_format($amount, 2) : number_format($firstHalf, 2) }}</td>
                                                <td rowspan="{{ $rowspan }}">
                                                    @if (stripos($method, 'cheque') !== false)
                                                        CEK
                                                    @elseif (stripos($method, 'bank_draf') !== false)
                                                        BANK DRAF
                                                    @else
                                                        EFT
                                                    @endif
                                                </td>
                                                <td rowspan="{{ $rowspan }}">{{ $transactionCategory }}</td>
                                            </tr>
                                            
                                            @if (!$isReprint && !$isThirdParty)
                                                <tr>
                                                    <td>L453</td>
                                                    <td>{{ $kodHasil }}</td>
                                                    <td>{{ number_format($secondHalf, 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        <!-- Grand Total Row -->
                                        <tr style="background-color: #f0f0f0; font-weight: bold;">
                                            <td colspan="9" style="text-align: right;">JUMLAH :</td>
                                            <td>{{ number_format($grandTotal, 2) }}</td>
                                            <td colspan="2" style="text-align: right;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Section 1: Ringkasan Terimaan Mengikut Kod Hasil -->
                            <div style="padding: 0 20px; margin-top: 10px;">
                                <h6>Ringkasan Terimaan Mengikut Kod Hasil</h6>
                                <table class="summary-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kod Hasil</th>
                                            <th>Vot Dana</th>
                                            <th>Amaun(RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $nonReprintAmount = $grandTotal - $totalReprintAmount;
                                            $firstHalf = floor($nonReprintAmount * 100 / 2) / 100;
                                            $secondHalf = $nonReprintAmount - $firstHalf;
                                        @endphp
                                        
                                        <tr>
                                            <td>1</td>
                                            <td>H0161304</td>
                                            <td>G001</td>
                                            <td>{{ number_format($firstHalf, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>L453</td>
                                            <td>{{ number_format($secondHalf, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>H0272499</td>
                                            <td>G001</td>
                                            <td>{{ number_format($totalReprintAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align:end;"><strong>JUMLAH :</strong></td>
                                            <td><strong>{{ number_format($grandTotal, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Section 2: Ringkasan Terimaan Mengikut Mod Terimaan -->
                            <div style="padding: 0 20px;">
                                <h6>Ringkasan Terimaan Mengikut Mod Terimaan</h6>
                                <table class="summary-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ringkasan Terimaan</th>
                                            <th>Bil Rekod</th>
                                            <th>Amaun(RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $eftCount = 0;
                                            $eftAmount = 0;
                                            $chequeCount = 0;
                                            $chequeAmount = 0;
                                            $bankDraftCount = 0;
                                            $bankDraftAmount = 0;

                                            foreach ($applications as $application) {
                                                $method = $application->methods ?? '';
                                                $amount = $application->payment_amount ?? 0;

                                                if (
                                                    stripos($method, 'EFT') !== false || 
                                                    stripos($method, 'transfer') !== false || 
                                                    stripos($method, 'FPX_B2B') !== false || 
                                                    stripos($method, 'FPX_B2C') !== false
                                                ) {
                                                    $eftCount++;
                                                    $eftAmount += $amount;
                                                }

                                                if (stripos($method, 'cheque') !== false || stripos($method, 'cek') !== false) {
                                                    $chequeCount++;
                                                    $chequeAmount += $amount;
                                                }

                                                if (stripos($method, 'bank_draf') !== false) {
                                                    $bankDraftCount++;
                                                    $bankDraftAmount += $amount;
                                                }
                                            }
                                        @endphp

                                        <tr>
                                            <td>1</td>
                                            <td>EFT</td>
                                            <td>{{ $eftCount }}</td>
                                            <td>{{ number_format($eftAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>CEK/BANK DRAF</td>
                                            <td>{{ $chequeCount + $bankDraftCount }}</td>
                                            <td>{{ number_format($chequeAmount + $bankDraftAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align:end;"><strong>JUMLAH :</strong></td>
                                            <td><strong>{{ $eftCount + $chequeCount + $bankDraftCount }}</strong></td>
                                            <td><strong>{{ number_format($eftAmount + $chequeAmount + $bankDraftAmount, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Section 3: Ringkasan Terimaan Mengikut Mod Transaksi Perbankan -->
                            <div style="padding: 0 20px;">
                                <h6>Ringkasan Terimaan Mengikut Mod Transaksi Perbankan</h6>
                                <table class="summary-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ringkasan Mod Transaksi Perbankan</th>
                                            <th>Bil Rekod</th>
                                            <th>Amaun(RM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $b2bCount = 0;
                                            $b2bAmount = 0;
                                            $b2cCount = 0;
                                            $b2cAmount = 0;
                                            $baucarCount = 0;
                                            $baucarAmount = 0;
                                            $manualPaymentCount = 0;
                                            $manualPaymentAmount = 0;

                                            foreach ($applications as $application) {
                                                $method = $application->methods ?? '';
                                                $amount = $application->payment_amount ?? 0;
                                                $accountTypeName = isset($application->account_type_name) 
                                                    ? strtoupper(trim($application->account_type_name)) 
                                                    : '';

                                                if (stripos($method, 'FPX_B2B') !== false) {
                                                    $b2bCount++;
                                                    $b2bAmount += $amount;
                                                }
                                                elseif (stripos($method, 'FPX_B2C') !== false) {
                                                    $b2cCount++;
                                                    $b2cAmount += $amount;
                                                }
                                                elseif (stripos($method, 'bank_draf') !== false || stripos($method, 'cheque') !== false) {
                                                    $manualPaymentCount++;
                                                    $manualPaymentAmount += $amount;
                                                }
                                                elseif ($accountTypeName === 'AGENSI KERAJAAN') {
                                                    $baucarCount++;
                                                    $baucarAmount += $amount;
                                                }
                                            }

                                            $totalCount = $b2bCount + $b2cCount + $baucarCount + $manualPaymentCount;
                                            $totalAmount = $b2bAmount + $b2cAmount + $baucarAmount + $manualPaymentAmount;
                                        @endphp

                                        <tr>
                                            <td>1</td>
                                            <td>B2B</td>
                                            <td>{{ $b2bCount }}</td>
                                            <td>{{ number_format($b2bAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>B2C</td>
                                            <td>{{ $b2cCount }}</td>
                                            <td>{{ number_format($b2cAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>BAUCAR BAYARAN AGENSI KERAJAAN</td>
                                            <td>{{ $baucarCount }}</td>
                                            <td>{{ number_format($baucarAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>PEMBAYARAN MANUAL</td>
                                            <td>{{ $manualPaymentCount }}</td>
                                            <td>{{ number_format($manualPaymentAmount, 2) }}</td>
                                        </tr>
                                        <tr style="background-color: #f0f0f0;">
                                            <td colspan="2" style="text-align:end;"><strong>JUMLAH :</strong></td>
                                            <td><strong>{{ $totalCount }}</strong></td>
                                            <td><strong>{{ number_format($totalAmount, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="action-section" id="btn-section">
                <button class="btn-prints" onclick="window.location.href='{{ route('daily_receipt_report_type_finance') }}'">
                    Kembali
                </button>
                <button onclick="window.print()" class="btn-print">{{ trans('app.print') }}</button>
            </div>
        </div>
    </section>
@endsection