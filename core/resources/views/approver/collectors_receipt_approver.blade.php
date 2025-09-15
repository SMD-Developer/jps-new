<!-- @extends('app') -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
/* Container */
.form-container {
    margin: 0 auto !important;
    padding: 20px !important;
    background: #fff !important;
    border-radius: 10px !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
}

/* Table Styles */
.table-header {
    background-color: #eef5f9 !important;
    font-weight: 600 !important;
    text-align: center !important;
}

table {
    width: 100% !important;
    border-collapse: collapse !important;
    font-size: 13px !important;
    margin: 20px 0 !important;
}

th, td {
    border: 1px solid black !important;
    padding: 5px 8px !important;
    text-align: left !important;
    vertical-align: middle !important;
}

th {
    text-align: center !important;
    background-color: #eef5f9 !important;
}

/* Scrollbar for Table */
.scrollbar {
    overflow-x: auto !important;
    margin-bottom: 15px !important;
}

.scrollbar table {
    min-width: 100% !important;
}

/* Pagination */
.pagination-controls {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-top: 10px !important;
}

.pagination {
    margin: 0 !important;
}

.pagination .page-item {
    margin: 0 2px !important;
}

.pagination .page-link {
    padding: 0.5rem 0.75rem !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 40px !important;
    border: 1px solid #dee2e6 !important;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

.pagination .page-item.disabled .page-link {
    opacity: 0.6 !important;
}

/* Buttons */
.sbtn {
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: center !important;
    gap: 0.25rem !important;
}

.sbtn a, .sbtn button {
    flex: 0 1 auto !important;
    max-width: 150px !important;
    padding: 4px 8px !important;
    font-size: 0.75rem !important;
    line-height: 1 !important;
    border-radius: 25px !important;
    text-align: center !important;
}

.btn-sm {
    padding: 6px 10px !important;
    font-size: 0.75rem !important;
    line-height: 1 !important;
}

/* Utility Classes */
.center {
    text-align: center !important;
}

.last td {
    text-align: center !important;
}

.total-row td {
    font-weight: bold !important;
    text-align: right !important;
}

.total-row td:first-child {
    text-align: left !important;
}
.section-title {
    font-weight: bold !important;
    margin: 20px 0 10px !important;
}

/* Special Elements */
.box-container {
    display: flex !important;
    align-items: center !important;
    margin: 10px 0 !important;
}

.box {
    width: 20px !important;
    height: 20px !important;
    border: 1px solid black !important;
    margin-right: 10px !important;
}

.line-text {
    flex: 1 !important;
}

/* Header Styles */
.header {
    text-align: center !important;
    font-weight: bold !important;
    margin-bottom: 10px !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    body {
        margin: 10px !important;
    }
    
    .form-container {
        padding: 15px !important;
    }
    
    .sbtn a, .sbtn button {
        flex: 1 1 100% !important;
        max-width: none !important;
    }
}
</style>

<title>@lang('app.collectors_receipt') | JPS</title>

@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-file" aria-hidden="true"></i> @lang('app.collectors_receipt')</h5>
</div>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                        <section class="1" style="margin-bottom: 50px;">
                            <table class="header-table">
                                <tr>
                                  <td class="text-center" colspan="4">SLIP BAYAR MASUK BANK</td>
                                </tr>
                                <tr style="border-bottom: 0;">
                                  <td colspan="2" style="border-right: 0;">NAMA BANK : CIMB BANK BERHAD</td>
                                  <td style="border-left: 0; border-right: 0;">Tarikh : {{ $report->submitted_at  }}</td>
                                  <td class="text-center" style="border-left: 0;">No. Slip Bank : {{$report->report_number }} </td>
                                </tr>
                                <tr style="border-top: 0;">
                                  <td class="text-center" colspan="4">Pej. Perakaunan: JABATAN PENGAIRAN & SALIRAN SELANGOR</td>
                                </tr>
                                <tr>
                                    <td rowspan="5" class="design-cell">
                                        <div class="box-container">
                                            <div class="box"></div>
                                            <div class="line-text">CEK CAWANGAN INI</div>
                                        </div>
                                        <div class="box-container">
                                            <div class="box"></div>
                                            <div class="line-text">CEK CAWANGAN LAIN</div>
                                        </div>
                                        <div class="box-container">
                                            <div class="box"></div>
                                            <div class="line-text">CEK BANK TEMPATAN</div>
                                        </div>
                                        <div class="box-container">
                                            <div class="box"></div>
                                            <div class="line-text">CEK TEMPAT LAIN</div>
                                        </div>
                                        <div class="box-container">
                                            <div class="box"></div>
                                            <div class="line-text">WANG TUNAI</div>
                                        </div>
                                        <div class="box-container">
                                            <div class="box"></div>
                                            <div class="line-text">.......................................</div>
                                        </div>
                                    </td>
                                    <td class="text-center" colspan="2">WANG TUNAI</td>
                                    <td class="text-center">AMAUN (RM)</td>
                                </tr>
                                <tr>
                                  <td class="text-center">RINGGIT MALAYSIA</td>
                                  <td>ENAM PULUH TIGA RIBU LIMA RATUS DUA BELAS <br> SAHAJA</td>
                                  <td class="text-center">
                                      @php
                                        $amount = $report->report_data['totalAmount'] ?? '0';
                                        $numericAmount = is_numeric($amount) ? (float)$amount : (float)preg_replace('/[^\d.-]/', '', $amount);
                                    @endphp
                                    {{ number_format($numericAmount, 2) }}
                                  </td>
                                </tr>
                                <tr>
                                  <td class="text-center" colspan="2"></td>
                                  <td class="text-center"></td>
                                </tr>
                                <tr>
                                  <td class="text-center" colspan="2">CEK-CEK</td>
                                  <td class="text-center">AMAUN (RM)</td>
                                </tr>
                                <tr>
                                  <td class="text-center" colspan="2">(BUTIRAN CEK SEPERTI DI SENARAI CEK)</td>
                                  <td class="text-center"></td>
                                </tr>
                            </table>
                        </section>
                    
                        <section class="2" style="margin-bottom: 50px; margin-top: 100px;">
                            <table class="mb-0">
                                <tr>
                                    <td>NO AKAUN: 8001954651</td>
                                    <td>NAMA:  &nbsp; &nbsp; &nbsp; CIMB BANK BERHAD</td>
                                </tr>
                            </table>
                            <table class="header-table" style="margin-top: 5px;">
                                <tr>
                                  <td colspan="2" class="text-right" style="border-right: 0; ">
                                    <h5><b>KERAJAAN NEGERI SELANGOR</b></h5>
                                    <h5 class="pr-5"><b>PENYATA PEMUNGUT</b></h5>
                                  </td>
                                  <td style="text-align: right; border-left: 0; border-start: red;">(Kew. 305E-Pind. 1/2015)<br>Muka surat 2/4</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td class="text-center">Tahun Kewangan 2025</td>
                                </tr>
                            </table>
                             <table class="header-table">
                                <tr>
                                  <td class="text-center">Jenis Urusniaga</td>
                                  <td class="text-center">Pej. Perakaunan</td>
                                  <td class="text-center">No. Penyata Pemungut</td>
                                  <td class="text-center">Tarikh Penyata Pemungut</td>
                                </tr>
                                <tr>
                                  <td class="text-center">PENYATA PEMUNGUT-AUTO</td>
                                  <td class="text-center"></td>
                                  <td class="text-center">{{$report->report_number }}</td>
                                  <td class="text-center">10/01/2025</td>
                                </tr>
                            </table>
                            
                            <table class="" style="margin-bottom: 0;">
                                <tr>
                                  <td style="width: 14.5%;">Jab.</td>
                                  <td style="width: 14.8%;">021000</td>
                                  <td colspan="2">JABATAN PENGAIRAN & SALIRAN SELANGOR</td>
                                </tr>
                                <tr>
                                  <td>PTJ/PK</td>
                                  <td>21000000</td>
                                  <td colspan="2">PENGARAH PENGAIRAN & SALIRAN</td>
                                </tr>
                                <tr>
                                  <td colspan="3">Kod Pembayar</td>
                                </tr>
                                <tr>
                                  <td>Kod Panjar</td>
                                  <td colspan="3"></td>
                                </tr>
                            </table>
                            <table style="margin: 0">
                                <tr>
                                  <td style="width: 45%;">Jenis Pungutan C = Pungutan diperbankan dan diperakaunkan.</td>
                                  <td>Perihal Pungutan </td>
                                  <td>BAYARAN CARUMAN PARIT</td>
                                </tr>
                            </table>
                            <table class="mt-0">
                                <tr>
                                  <td colspan="2">Tempoh Pungutan</td>
                                  <td>Dari: </td>
                                  <td>{{ $report->report_data['period']['start_date'] ?? '10/01/2025' }}</td>
                                  <td>Hingga:</td>
                                  <td>Tarikh <br> diterima <br> oleh bank</td>
                                  <td>{{ $report->report_data['period']['end_date'] ?? '10/01/2025' }}</td>
                                </tr>
                            </table>
                            
                            <table class="mb-0">
                                <tr>
                                  <td></td>
                                  <td class="text-center">Disediakan</td>
                                  <td class="text-center">Semak</td>
                                  <td class="text-center">Lulus</td>
                                </tr>
                                <tr>
                                  <td>Nama</td>
                                  <td>{{ $report->original_submitter_name }}</td>
                                  <td>{{ $report->submitter_name }}</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Jawatan</td>
                                  <td>PEMBANTU TADBIR (KEWANGAN) GRED W19</td>
                                  <td>PEMBANTU TADBIR (KEWANGAN) GRED W22</td>
                                  <td>PENOLONG AKAUNTAN GRED W29</td>
                                </tr>
                                <tr>
                                  <td>Tarikh</td>
                                  <td>{{$report->original_submitted_at}}</td>
                                  <td>{{$report->original_reviewed_at}}</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Tandatangan</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Catatan</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                            </table>
                            <p>No. Kelulusan Perb. : BNPK(8.15)248-10(SK.6)JD.33(9) </p>
                        </section>
                        
                        <section class="3" style="margin-bottom: 50px; margin-top: 100px;">
                            <!--<div class="section-title text-uppercase">Ini adalah cetakan komputer dan didak perlu ditandatangani</div>-->
                            <table class="header-table mb-0 mt-0">
                                <tr>
                                  <td colspan="2" class="text-right" style="border-right: 0;" >
                                    <h5><b>KERAJAAN NEGERI SELANGOR</b></h5>
                                    <h5 class="pr-5"><b>PENYATA PEMUNGUT</b></h5>
                                  </td>
                                  <td style="text-align: right; border-left: 0; border-start: red;">(Kew. 305E-Pind. 1/2015)<br>Muka surat 2/4</td>
                                </tr>
                            </table>
                            
                            <table class="header-table" style="margin-top: 5px;">
                                <tr class="mb-5">
                                  <td colspan="4" style="text-align: center;">Tahun Kewangan 2025</td>
                                </tr>
                            </table>
                            
                            <table class="header-table">
                                <tr>
                                  <td class="text-center">Jenis Urusniaga</td>
                                  <td class="text-center">Pej. Perakaunan</td>
                                  <td class="text-center">No. Penyata Pemungut</td>
                                  <td class="text-center">Tarikh Penyata Pemungut</td>
                                </tr>
                                <tr>
                                  <td class="text-center">PENYATA PEMUNGUT-AUTO</td>
                                  <td class="text-center"></td>
                                  <td class="text-center">{{$report->report_number }}</td>
                                  <td class="text-center">10/01/2025</td>
                                </tr>
                            </table>
                            
                            <table class="" style="margin-bottom: 0;">
                                <tr>
                                  <td style="width: 14.5%;">Jab.</td>
                                  <td style="width: 14.8%;">021000</td>
                                  <td colspan="2">JABATAN PENGAIRAN & SALIRAN SELANGOR</td>
                                </tr>
                                <tr>
                                  <td>PTJ/PK</td>
                                  <td>21000000</td>
                                  <td colspan="2">PENGARAH PENGAIRAN & SALIRAN</td>
                                </tr>
                                <tr>
                                  <td colspan="3">Kod Pembayar</td>
                                </tr>
                                <tr>
                                  <td>Kod Panjar</td>
                                  <td colspan="3"></td>
                                </tr>
                            </table>
                            <table style="margin: 0">
                                <tr>
                                  <td style="width: 45%;">Jenis Pungutan C = Pungutan diperbankan dan diperakaunkan.</td>
                                  <td>Perihal Pungutan </td>
                                  <td>BAYARAN CARUMAN PARIT</td>
                                </tr>
                            </table>
                            <table class="mt-0">
                                <tr>
                                  <td colspan="2">Tempoh Pungutan</td>
                                  <td>Dari: </td>
                                  <td>{{ $report->report_data['period']['start_date'] ?? '10/01/2025' }}</td>
                                  <td>Hingga:</td>
                                  <td>Tarikh <br> diterima <br> oleh bank</td>
                                  <td>{{ $report->report_data['period']['end_date'] ?? '10/01/2025' }}</td>
                                
                                </tr>
                            </table>
                            
                            
                             <div class="section-title">PUNGUTAN DIMASUKIRA KE DALAM AKAUN-AKAUN DI BAWAH</div>
        
                            <table class="summary-table">
                                <thead>
                                  <tr>
                                    <th>Bil.</th>
                                    <th>Vot</th>
                                    <th>Jab</th>
                                    <th>PTJ/PK</th>
                                    <th>Prog/Akt</th>
                                    <th>Projek</th>
                                    <th>Setia</th>
                                    <th>Sub Setia</th>
                                    <th>CP</th>
                                    <th>Objek</th>
                                    <th>Amaun (RM)</th>
                                    <th>Kod Kegunaan Jabatan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td colspan="12" class="">Perihal Am</td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>G001</td>
                                    <td>021000</td>
                                    <td>21000000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>H0161304</td>
                                        @php
                                        $totalAmount = $report->report_data['totalAmount'] ?? '0';
                                        $halfAmount = is_numeric($totalAmount) ? (float)$totalAmount / 2 : (float)preg_replace('/[^\d.-]/', '', $totalAmount) / 2;
                                    @endphp
                                   <td>{{ number_format($halfAmount, 2) }}</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td colspan="12" class="text-left"><b>CARUMAN PARIT</b></td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>G001</td>
                                    <td>021000</td>
                                    <td>21000000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>H0161304</td>
                                     @php
                                        $totalAmount = $report->report_data['totalAmount'] ?? '0';
                                        $halfAmount = is_numeric($totalAmount) ? (float)$totalAmount / 2 : (float)preg_replace('/[^\d.-]/', '', $totalAmount) / 2;
                                    @endphp
                                <td>{{ number_format($halfAmount, 2) }}</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td colspan="7" class="text-left py-4" style="border-right: 0;"><b>CARUMAN PARIT</b></td>
                                    <td colspan="2" style="border-left: 0; border-right: 0; padding-top: 24px;">JUMLAH</td>
                                    <td style="border-left: 0; border-right: 0; text-decoration-line: underline overline; padding-top: 25px;">
                                        @php
                                        $amount = $report->report_data['totalAmount'] ?? '0';
                                        $numericAmount = is_numeric($amount) ? (float)$amount : (float)preg_replace('/[^\d.-]/', '', $amount);
                                    @endphp
                                    {{ number_format($numericAmount, 2) }}
                                    </td>
                                    <td style="border-left: 0; border-right: 0; padding-top: 20px;">Jumlah Bil. <br> Subsidiari</td>
                                    <td style="border-left: 0; text-decoration-line: overline underline; padding-top: 25px;">
                                        @php
                                        $amount = $report->report_data['totalAmount'] ?? '0';
                                        $numericAmount = is_numeric($amount) ? (float)$amount : (float)preg_replace('/[^\d.-]/', '', $amount);
                                    @endphp
                                    {{ number_format($numericAmount, 2) }}
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        
                            <table class="mt-4">
                                <thead>
                                  <tr>
                                      <th colspan="5" class="header">SENARAI RESIT YANG DIKELUARKAN</th>
                                  </tr>
                                </thead>
                                <tbody class="last">
                            <tr>
                                <td>Bil.</td>
                                <td>No. Resit</td>
                                <td>Tarikh</td>
                                <td>Amaun (RM)</td>
                                <td style="width: 40%;">Perihal</td>
                            </tr>
                            @foreach($report->report_data['selectedReceipts'] ?? [] as $index => $receipt)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $receipt['receipt_number'] ?? 'NA' }}</td>
                                    <td>{{ $receipt['receipt_date'] ?? '10/01/2025' }}</td>
                                    @php
                                        $receiptAmount = $receipt['amount'] ?? '0';
                                        $numericReceiptAmount = is_numeric($receiptAmount) ? (float)$receiptAmount : (float)preg_replace('/[^\d.-]/', '', $receiptAmount);
                                    @endphp
                                    <td style="text-align: right;">{{ number_format($numericReceiptAmount, 2) }}</td>
                                    <td style="text-align: left;">{{ $receipt['description'] ?? '' }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td style="border-right: 0; text-align: right;" colspan="3">JUMLAH</td>
                                <td style="border-left: 0; border-right: 0; text-align: right;">{{ number_format($numericAmount, 2) }}</td>
                                <td style="border-left: 0;"></td>
                            </tr>
                        </tbody>
                                <!--<tfoot>-->
                                <!--  <tr class="total-row">-->
                                <!--    <td style="border-right: 0; text-align: right;" colspan="3">JUMLAH</td>-->
                                <!--    <td style="border-left: 0; border-right: 0; text-align: right;">63,512.00</td>-->
                                <!--    <td style="border-left: 0;"></td>-->
                                <!--  </tr>-->
                                <!--</tfoot>-->
                            </table>
                        </section>  
                        
                        <section class="4" style="margin-bottom: 50px; margin-top: 100px;">
                            <table class="header-table mb-0">
                                <tr>
                                  <td class="text-center"></td>
                                  <td class="text-center">Disediakan</td>
                                  <td class="text-center">Semak</td>
                                  <td class="text-center">Lulus</td>
                                </tr>
                                <tr>
                                  <td>Nama</td>
                                  <td>{{ $report->original_submitter_name }}</td>
                                  <td>{{ $report->submitter_name }}</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Jawatan</td>
                                  <td>PEMBANTU TADBIR (KEWANGAN) GRED W19</td>
                                  <td>PEMBANTU TADBIR (KEWANGAN) GRED W22</td>
                                  <td>PENOLONG AKAUNTAN GRED W29</td>
                                </tr>
                                <tr>
                                  <td>Tarikh</td>
                                  <td>{{$report->original_submitted_at}}</td>
                                  <td>{{$report->original_reviewed_at}}</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Tandatangan</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Catatan</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                            </table>
                            <p>No. Kelulusan Perb. : BNPK(8.15)248-10(SK.6)JD.33(9) </p>
                        </section>
                        
                        <section class="5" style="margin-bottom: 50px; margin-top: 100px;">
                            <table class="header-table mb-0">
                                <tr>
                                  <td colspan="2" class="text-right" style="border-right: 0;">
                                    <h5><b>KERAJAAN NEGERI SELANGOR</b></h5>
                                    <h5 class="pr-5"><b>PENYATA PEMUNGUT</b></h5>
                                  </td>
                                  <td style="text-align: right; border-left: 0; border-start: red;">(Kew. 305E-Pind. 1/2015)<br>Muka surat 1/4</td>
                                </tr>
                            </table>
                            
                            <table class="header-table" style="margin-top: 5px;">
                                <tr class="mb-5">
                                  <td colspan="4" style="text-align: center;">Tahun Kewangan 2025</td>
                                </tr>
                            </table>
                            
                            <table class="header-table">
                                <tr>
                                  <td class="text-center">Jenis Urusniaga</td>
                                  <td class="text-center">Pej. Perakaunan</td>
                                  <td class="text-center">No. Penyata Pemungut</td>
                                  <td class="text-center">Tarikh Penyata Pemungut</td>
                                </tr>
                                <tr>
                                  <td class="text-center">PENYATA PEMUNGUT-AUTO</td>
                                  <td class="text-center"></td>
                                  <td class="text-center">{{$report->report_number }}</td>
                                  <td class="text-center">10/01/2025</td>
                                </tr>
                            </table>
                            
                            <table class="mb-0">
                                <tr>
                                  <td style="width: 14.5%;">Jab.</td>
                                  <td style="width: 14.8%;">021000</td>
                                  <td colspan="2">JABATAN PENGAIRAN & SALIRAN SELANGOR</td>
                                </tr>
                                <tr>
                                  <td>PTJ/PK</td>
                                  <td>21000000</td>
                                  <td colspan="2">PENGARAH PENGAIRAN & SALIRAN</td>
                                </tr>
                                <tr>
                                  <td colspan="3">Kod Pembayar</td>
                                </tr>
                                <tr>
                                  <td>Kod Panjar</td>
                                  <td colspan="3"></td>
                                </tr>
                            </table>
                            <table class="my-0" style="border-bottom: 0;">
                                <tr>
                                  <td style="width: 45%;">Jenis Pungutan C = Pungutan diperbankan dan diperakaunkan.</td>
                                  <td>Perihal Pungutan </td>
                                  <td>BAYARAN CARUMAN PARIT</td>
                                </tr>
                            </table>
                            
                            <table class="my-0">
                                <tr>
                                  <td colspan="2">Tempoh Pungutan</td>
                                  <td>Dari: </td>
                                  <td>{{ $report->report_data['period']['start_date'] ?? '10/01/2025' }}</td>
                                  <td>Hingga:</td>
                                  <td>Tarikh <br> diterima <br> oleh bank</td>
                                  <td>{{ $report->report_data['period']['end_date'] ?? '10/01/2025' }}</td>
                                </tr>
                             </table>
                             
                             <table class="">
                                <tr>
                                  <td colspan="5"  class="text-center">SENARAI CEK/KIRIMAN WANG/WANG POS/BANK DRAF YANG DIBAYAR-MASUK </td>
                                </tr>
                                <tr>
                                  <th class="text-center">Bill</th>
                                  <th class="text-center">Bank Pembayar</th>
                                  <th class="text-center">No. Cek/Kiriman Wang</th>
                                  <th class="text-center">Tempat</th>
                                  <th class="text-center">Amaun(RM)</th>
                                </tr>
                                <tr>
                                  <td class="text-center">1</td>
                                  <td>MALAYAN BANKING BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">2</td>
                                  <td>PUBLIC BANK BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">3</td>
                                  <td>HONG LEONG BANK BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">4</td>
                                  <td>HONG LEONG BANK BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">5</td>
                                  <td>MALAYAN BANKING BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">6</td>
                                  <td>RHB BANK BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">7</td>
                                  <td>PUBLIC BANK BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td class="text-center">8</td>
                                  <td>MALAYAN BANKING BERHAD</td>
                                  <td>063151</td>
                                  <td></td>
                                  <td class="text-right">476.00</td>
                                </tr>
                                <tr>
                                  <td colspan="4" class="text-right" style="border-right: 0;">JUMLAH BERSIH</td>
                                  <td style="border-left: 0;" class="text-right">63,512.00</td>
                                </tr>
                             </table>
                        </section>
                        
                        <section class="6" style="margin-bottom: 50px; margin-top: 100px;">
                            <table class="header-table mb-0">
                                <tr>
                                  <td class="text-center"></td>
                                  <td class="text-center">Disediakan</td>
                                  <td class="text-center">Semak</td>
                                  <td class="text-center">Lulus</td>
                                </tr>
                                <tr>
                                  <td>Nama</td>
                                  <td>{{ $report->original_submitter_name }}</td>
                                  <td>{{ $report->submitter_name }}</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Jawatan</td>
                                  <td>PEMBANTU TADBIR (KEWANGAN) GRED W19</td>
                                  <td>PEMBANTU TADBIR (KEWANGAN) GRED W22</td>
                                  <td>PENOLONG AKAUNTAN GRED W29</td>
                                </tr>
                                <tr>
                                  <td>Tarikh</td>
                                  <td>{{$report->original_submitted_at}}</td>
                                  <td>{{$report->original_reviewed_at}}</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Tandatangan</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>Catatan</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                            </table>
                            <p>No. Kelulusan Perb. : BNPK(8.15)248-10(SK.6)JD.33(9) </p>
                        </section>
                        
                        <div class="row px-2 mb-3" style="display: flex;justify-content: flex-end;">
                            <div class="col d-flex justify-content-end">
                            <button class="btn btn-danger mx-2" id="demo" @if($report->status == 'approved') disabled @endif>
                                @lang('app.reject')
                            </button>
                             <button class="btn btn-primary mx-2" onclick="window.print()">
                                @lang('app.print')
                            </button>
                            <button class="btn btn-info mx-2"
                                    id="demo2"
                                    @if($report->status == 'approved') disabled @endif>
                                @lang('app.passed')
                            </button>

                            </div>
                            
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function attachClickEvent(selector, callback) {
            let element = document.querySelector(selector);
            if (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    callback();
                });
            }
        }

        // Reject Button with Reason
        attachClickEvent('#demo', function () {
            Swal.fire({
                title: '{{ __("app.are_you_sure_reviewer") }}',
                input: 'textarea',
                inputPlaceholder: '{{ __("app.enter_reason_for_rejection") }}',
                inputAttributes: {
                    'aria-label': '{{ __("app.enter_reason_for_rejection") }}'
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("app.yes") }}',
                cancelButtonText: '{{ __("app.no") }}',
                inputValidator: (value) => {
                    if (!value) {
                        return '{{ __("app.please_provide_rejection_reason") }}';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    let reason = result.value;

                    // Show loading
                    Swal.fire({
                        title: 'Rejecting Report...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route("approver.reports.reject", ["report_id" => $report->id]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            report_id: '{{ $report->id }}',
                            reason: reason   // ✅ send rejection reason
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '{{ route("approved_statement_approver") }}';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Network error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        });

        // Approve Button
        attachClickEvent('#demo2', function () {
            Swal.fire({
                title: '{{ __("app.are_you_sure_approver") }}',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("app.yes") }}',
                cancelButtonText: '{{ __("app.no") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('{{ __("app.sent_successfully") }}', '', 'success');
                }
            });
        });

    });
</script>


<script>
   document.addEventListener('DOMContentLoaded', function () {
    function attachClickEvent(selector, callback) {
        let element = document.querySelector(selector);
        if (element) {
            element.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default action
                callback(e);
            });
        }
    }

    // Passed Button
    attachClickEvent('#demo2', function (e) {
        const reportNumber = '{{ $report->report_number }}';

        Swal.fire({
            title: '{{ __("app.are_you_sure_approver") }}',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("app.yes") }}',
            cancelButtonText: '{{ __("app.no") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update status
                fetch('/update-report-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        report_number: reportNumber,
                        status: 'approved',
                        approved_at: new Date().toISOString().slice(0, 19).replace('T', ' ')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('{{ __("app.sent_successfully") }}', 'Report status updated to approved!', 'success')
                            .then(() => {
                                 window.location.href = '{{ route("approved_statement_approver") }}';
                            });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Something went wrong while updating the report status.', 'error');
                });
            }
        });
    });
});
</script>