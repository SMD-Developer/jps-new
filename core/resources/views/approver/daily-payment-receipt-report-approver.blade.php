@extends('app')

<style>
/* Apply font size to all tables and text */
table, th, td {
    font-size: 12px; /* Adjust to 13px if needed */
}

/* Optional: Make headers slightly larger */
.header, .summary-table th, .acceptance-table th {
    font-size: 13px;
}
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

    .info-table, .summary-table {
        width: 97%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
.info-table, .acceptance-table{
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

    .summary-table th, .acceptance-table th {
        background-color: #f0f0f0;
        text-align: center;
    }

.acceptance-table th, .acceptance-table td {
    padding: 6px; /* Reduce padding */
}


    .custom-receive-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
    }

    .custom-header {
        font-weight: bold;
        padding: 8px;
        background: #f0f0f0;
    }

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

</style>

<title>{{ trans('app.daily_payment_receipt_report') }} | JPS</title>

@section('content')

<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ trans('app.daily_payment_receipt_report') }}</h5>
</div>

<section>
    <div class="report-container container" style="width: 98%;">
        <div class="row mb-3">
            <div class="col-3">
                <p><strong>TARIKH:</strong> 10/01/2025</p>
                <p><strong>MASA:</strong> 04:03:09 PM</p>
            </div>
            <div class="col-8 header">
                <p>KERAJAAN NEGERI SELANGOR DARUL EHSAN</p>
                <p>LAPORAN TERIMAAN HARIAN MENGIKUT JENIS DARI 10/01/2025 HINGGA 10/01/2025</p>
            </div>
            <div class="col-12">
                <table class="custom-receive-table">
                    <tr>
                        <th class="custom-header">MENERIMA</th>
                        <th class="custom-header">KOD</th>
                        <th class="custom-header">PERIHAL</th>
                    </tr>
                    <tr>
                        <td class="custom-label"><strong>JABATAN</strong></td>
                        <td class="custom-code">: 021000</td>
                        <td class="custom-description">JABATAN PENGAIRAN & SALIRAN SELANGOR</td>
                    </tr>
                    <tr>
                        <td class="custom-label"><strong>PTJ</strong></td>
                        <td class="custom-code">: 21000000</td>
                        <td class="custom-description">PENGARAH PENGAIRAN & SALIRAN</td>
                    </tr>
                </table>
            </div>
        </div>

         <!-- Existing Tables Below -->
            <div class="contents-wrapper row">
                <div class="left-section">
                    <table class="summary-table mx-2">
                        <tr>
                            <th colspan="4">Ringkasan Terimaan</th>
                        </tr>
                        <tr>
                            <th>Bil</th>
                            <th>Kod Akaun</th>
                            <th>Bil Urusniaga</th>
                            <th>Amaun (RM)</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>H0161304</td>
                            <td>16</td>
                            <td style="text-align: right;">63,512.00</td>
                        </tr>
                    </table>
                    
                    
                    
                    <table class="summary-table mx-2">
                        <tr>
                            <td colspan="2">Jumlah Terimaan<br> (Mengikut Charge Line)</td>
                            <td>16</td>
                            <td style="text-align: right;">63,512.00</td>
                        </tr>
                        <tr>
                            <td colspan="2">Bilangan Urusniaga Batal</td>
                            <td>0</td>
                            <td style="text-align: right;">0</td>
                        </tr>
                        <tr>
                            <td colspan="2">Bilangan Urusniaga Diterima</td>
                            <td>16</td>
                            <td style="text-align: right;">63,512.00</td>
                        </tr>
                    </table>
                    <div style="padding: 10px;">
                    <p><strong>Disediakan Oleh:</strong> ___________________</p>
                    <p><strong>Ditandatangani Oleh:</strong> ___________________</p>
                    <p><strong>Jawatan:</strong> ___________________</p>
                    <p><strong>Tarikh:</strong> ___________________</p>
                    </div>
                </div>
                <div class="right-section">
                    <table class="acceptance-table">
                        <tr>
                            <th rowspan="2">Ringkasan Terimaan</th>
                            <th colspan="2">Penerimaan Rekod</th>
                            <th colspan="2">Penerimaan Rekod</th>
                        </tr>
                        <tr>
                            <th>Bil Rekod</th>
                            <th>Amaun (RM)</th>
                            <th>Bil Rekod</th>
                            <th>Amaun (RM)</th>
                        </tr>
                        <tr>
                            <td>1. Terimaan BANK DRAF (BD)</td>
                            <td>16</td>
                            <td style="text-align: right;">63,512.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>2. Terimaan CEK (CK)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>3. Terimaan CEK MANUAL (CM)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>4. Terimaan EFT (EF)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>5. Terimaan BANK DRAF (Dalam Negara) (F)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>6. Terimaan FPX ONLINE INDIVIDU (FPXI)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>7. Terimaan FPX ONLINE SYARIKAT (FPXS)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>8. Terimaan KAD DEBIT (KD)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>9. Terimaan KAD DEBIT ONLINE (KDO)</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                            <td>0</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <th style="border-bottom: none;/* font-size: 13px; */">Jumlah Terimaan Mengikut Jenis</th>
                            <td style="border-right: 0px;border-left: 0px;border-bottom: 0px;text-align: right;">16</td>
                            <td style="border-right: 0px;border-left: 0px;border-bottom: 0px;text-align: right;">63,512.00</td>
                            <td style="border-right: 0px;border-left: 0px;border-bottom: 0px;"></td>
                            <td style="text-align: right;border-left: 0px;border-bottom: 0px;"></td>
                        </tr>
                        <tr>
                            <th style="border-right: 0px;border-top: 0px;border-bottom: none;">Bilangan Urusniaga Batal</th>
                            <td style="border-right: 0px;border-top: 0px;border-bottom: none;"></td>
                            <td style="text-align: right;border-right: 0px;border-top: 0px;border-left: 0px;border-bottom: none;"></td>
                            <td style="text-align: right;border-left: 0px;border-bottom: 0px;border-right: 0;border-top: 0px;">0</td>
                            <td style="text-align: right;border-left: 0px;border-bottom: 0px;/* border-right: 0; */border-top: 0px;">0.00</td><!-- Empty columns for alignment -->
                        </tr>
                        <tr>
                            <th style="/* border-right: 0px; */border-top: 0px;">Bilangan Urusniaga Diterima</th>
                            <td style="text-align: right;border-right: 0px;border-top: 0px;border-left: 0px;">16</td>
                            <td style="text-align: right;border-right: 0px;border-top: 0px;border-left: 0px;">63,512.00</td>
                            <td style="text-align: right;border-right: 0px;border-top: 0px;border-left: none;"></td>
                            <td style="text-align: right;/* border-right: 0px; */border-top: 0px;border-left: none;"></td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <button onclick="window.print()" class="btn btn-primary float-right">{{ trans('app.print') }}</button>
            </div>
    </div>
</section>

@endsection