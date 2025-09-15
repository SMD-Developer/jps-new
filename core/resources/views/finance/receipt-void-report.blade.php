 @extends('app')
<style>
    /* Apply font size to all tables and text */
body, table, th, td, p {
    font-size: 12px; /* Adjust to 13px if needed */
}

/* Optional: Make headers slightly larger */
.header, .summary-table th, .acceptance-table th {
    font-size: 13px;
}

.table-container {
    width: 100%;
    border-collapse: collapse;
}

/* Report Layout */
.report-container {
    width: 100%;
    border: 1px solid #000;
    padding: 20px;
    box-sizing: border-box;
    overflow-x: auto;
    background: #fff;
}

.header {
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 20px;
    line-height: 1.5;
}

/* Tables */
.info-table, .summary-table {
    width: 97%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.info-table, .acceptance-table {
    width: 99%;
    border-collapse: collapse;
    margin-bottom: 20px;
    table-layout: fixed; /* Ensures content fits within columns */
    word-wrap: break-word;
}

.info-table td, .summary-table td, .summary-table th, 
.acceptance-table td, .acceptance-table th {
    border: 1px solid #000;
    padding: 10px;
    text-align: left;
}

/* Table Header Styling */
.summary-table th, .acceptance-table th, th {
    background-color: #f0f0f0;
    text-align: center;
}

.acceptance-table th, .acceptance-table td {
    padding: 6px; /* Reduce padding */
}

/* Custom Table */
.custom-receive-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid black;
}

/* Custom Table Headers */
.custom-header {
    font-weight: bold;
    padding: 8px;
    background: #f0f0f0;
}

/* Custom Column Styles */
.custom-label, .custom-code, .custom-description {
    padding: 8px;
    text-align: left;
}

.custom-code {
    width: 20%;
}

.custom-label {
    width: 15%;
    font-weight: bold;
}

.custom-description {
    width: 65%;
}

/* Flexbox Layout */
.contents-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    gap: 10px; /* Reduced gap */
}

.right-section {
    flex: 1;
    min-width: 300px;
    box-sizing: border-box;
}

/* Scrollable Section */
.right-section {
    overflow-x: auto; /* Prevent scrolling */
}

/* Responsive Design */
@media (max-width: 768px) {
    .contents-wrapper {
        flex-direction: column;
    }

    .right-section {
        margin-left: 0;
    }
}

/* Table Defaults */
table {
    width: 100%;
    border: 1px solid black;
    border-collapse: collapse;
    font-size: 13px;
}

/* Table Header Text Alignment */
th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}

/* Right-Aligned Text */
.right-align {
    text-align: right;
}

/* Status Highlight */
.status-lulus {
    text-align: center;
    font-weight: bold;
    color: green;
}
/* Payment Note Section */
    .payment-note {
        margin-top: 20px;
        font-weight: bold;
    }

    .payment-methods {
        display: flex;
        justify-content: stretch;
        font-size: 12px;
    }

    .payment-methods ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .payment-methods li {
        padding: 2px 0;
    }

</style>


<title>{{$title}} | JPS</title>

@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-file" aria-hidden="true"></i> {{$title}}</h5>
</div>
 <section class="card py-5">
         <div class="container px-2">
             <div class="row">
                 <div class="col-2">
                    <p class="mb-0"><b>TARIKH : {{ $currentDate }}</b></p>
                    <p><b>MASA : {{ $currentTime }}</b></p>
                </div>
                 <div class="col-8 text-center">
                     <p class="mb-0"><b>KERAJAAN NEGERI SELANGOR DARUL EHSAN</b></p>
                     <!--<p><b>S 10/01/2025 HINGGA 10/01/2025</b></p>-->
                     <p><b>SENARAI RESIT YANG DIBATALKAN {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} HINGGA {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</b></p>
                 </div>
                 <div class="col-2">
                     <p class="mb-0"><b>MUKA SURAT : 1/1</b></p>
                     <p><b></b></p>
                 </div>
             </div>
             <div class="row" style="font-size: 12px;">
                 <div class="col-md-12">
                     <table class="mb-2">
                         <tr>
                             <th>MENERIMA</th>
                             <th style="border-left: hidden; border-right: hidden;">KOD</th>
                             <th colspan="7">PERIHAL</th>
                         </tr>
                         <tr style="border-top: hidden; border-bottom: hidden;">
                             <th>JABATAN</th>
                             <th style="border-left: hidden; border-right: hidden;"> : 021000</th>
                             <th colspan="7">JABATAN PENGAIRAN & SALIRAN SELANGOR</th>
                         </tr>
                         <tr>
                             <th>PTJ/PK</th>
                             <th style="border-left: hidden; border-right: hidden;"> : 02100000</th>
                             <th colspan="7">PENGARAH PENGAIRAN & SALIRAN</th>
                         </tr>
                     </table>
                     <table>
                         <thead>
                             <tr>
                                 <th rowspan="2">BIL.</th>
                                 <th rowspan="2">NOMBOR RESIT</th>
                                 <th rowspan="2">TARIKH RESIT</th>
                                 {{-- <th rowspan="2">CARA BAYARAN </th> --}}
                                 {{-- <th rowspan="2">OPERATOR</th> --}}
                                 {{-- <th rowspan="2">KOD AKAUN</th> --}}
                                 <th rowspan="2">PERIHAL BAYARAN</th>
                                 <th rowspan="2">AMAUN (RM)</th>
                                 <th rowspan="2">SEBAB PEMBATALAN RESIT</th>
                                 {{-- <th rowspan="2">TARIKH BATAL</th> --}}
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($voidedReceipts as $index => $application)
                                 <tr>
                                     <td>{{ $index + 1 }}</td>
                                     <td>{{ $application->refference_no ?? 'N/A' }}</td>
                                     <td>{{ $application->deposit_date ?? 'N/A' }}</td>
                                     <td>{{ $application->note ?? 'N/A' }}</td>
                                     <td>RM {{ number_format($application->final_amount, 2) }}</td>
                                     <td>{{ $application->payment_rejection_reason ?? 'N/A' }}</td>
                                 </tr>
                             @endforeach
                             <!-- Grand Total Row -->
                             <tr style="font-weight: bold;">
                                 <td colspan="7" class="right-align" style="border-right: none;">JUMLAH(RM)</td>
                                 <td style="border-left: none; border-right:none;;">312,916.62</td>
                             </tr>
                         </tbody>
                     </table>
                     <!-- <p class="float-left">PENGKELASAN : ONLINE</p>-->
                     <!--<button type="button" class="btn btn-primary mt-5 float-right" onclick="window.print()">@lang('app.print')</button>-->
                 </div>
             </div>
             <!-- Nota: Maklumat Cara Bayaran -->
             <div class="payment-note">Nota : Maklumat Cara Bayaran</div>
             <div class="payment-methods">
                 <ul>
                     <li>1. TUNAI - Kutipan Tunai</li>
                     <li>3. KW - Kutipan Kiriman Wang</li>
                     <li>5. DB - Kutipan Draf Bank</li>
                     <li>7. KD - Kutipan Kad Debit</li>
                     <li>9. PT - Kutipan PindahanTelegraf / Pindahan Kredit</li>
                 </ul>
                 <ul>
                     <li>2. CEK - Kutipan Cek</li>
                     <li>4. WP - Kutipan Wang Pos</li>
                     <li>6. KK - Kutipan Kad Kredit</li>
                     <li>8. EFT - Kutipan EFT</li>
                 </ul>
             </div>
         </div>
         <div class="col-12 mt-5">
             <!--<p class="float-left "><b>PENGKELASAN : ONLINE</b></p>-->
             <button type="button" class="btn btn-primary float-right" onclick="window.print()">@lang('app.print')</button>
         </div>
         </div>
     </section>
@endsection