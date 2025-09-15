@extends('app')
<style>
        body {
            /*margin: 20px;*/
            font-size: 12px;
            
        }

        .table-container {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        /*th {*/
        /*    background-color: #f2f2f2;*/
        /*    text-align: center;*/
        /*}*/

        .right-align {
            text-align: right;
        }

        .status-lulus {
            text-align: center;
            font-weight: bold;
            color: green;
        }
table{
        font-size: 13px;
}

</style>
<title>{{ trans('app.checkbook_cash_book_report_by_date') }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ trans('app.checkbook_cash_book_report_by_date') }}</h5>
</div>


<section class="card py-5">
 <div class="container px-2">
    <div class="row">
      <div class="col-2">
          <p class="mb-0"><b>TARIKH : 10/01/2025</b></p>
          <p><b>MASA : 04:08:09</b></p>
      </div>
      <div class="col-8 text-center">
          <p class="mb-0"><b>KERAJAAN NEGERI SELANGOR DARUL EHSAN</b></p>
          <p><b>LAPORAN TERIMAAN HARIAN MENGIKUT JENIS DARI 10/01/2025 HINGGA 10/01/2025</b></p>
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
                    <th></th>
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
                <tbody>
                    <tr>
                        <th rowspan="2">TARIKH</th>
                        <th rowspan="2">BENTUK BAYARAN</th>
                        <th rowspan="2">NO. RESIT</th>
                        <th rowspan="2">AMAUN</th>
                        <th colspan="5">PEMBAYARAN KEPADA PERBENDAHARAAN</th>
                    </tr>
                    <tr>
                        <th>NO. PEMUNGUT TARIKH SLIP BANK</th>
                        <th>AMAUN</th>
                        <th>NO. RESIT PERBENDAHARAAN</th>
                        <th>PERBEZAAN HARIDI BANK</th>
                        <th>STATUS</th>
                    </tr>
                    
                    <tr style="border-bottom: hidden; border-left: hidden; border-right: hidden;">
                        <td style="border-right: hidden;">10/01/2025</td>
                        <td style="border-left: hidden; border-right: hidden;">Online</td>
                        <td style="border-left: hidden; border-right: hidden;">25CQTR0500048</td>
                        <td style="border-left: hidden; border-right: hidden;  text-align: right;">476.00</td>
                        <td style="border-left: hidden; border-right: hidden;">25CQPP0500009</td>
                        <td style="border-left: hidden; border-right: hidden;" colspan="3">63,512.00</td>
                        <td style="border-left: hidden; border-right: hidden;">LULUS</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">Online</td>
                        <td>25CQTR0500049</td>
                        <td  style="border: hidden;" colspan="6" >10,115.00</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">Online</td>
                        <td>25CQTR0500050</td>
                        <td style="border: hidden;" colspan="6" >3,000.00</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">BANK DRAF</td>
                        <td>25CQTR0500051</td>
                        <td style="border: hidden;" colspan="6">3,000.00</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">BANK DRAF</td>
                        <td>25CQTR0500052</td>
                        <td style="border: hidden;" colspan="6">3,945.00</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">BANK DRAF</td>
                        <td>25CQTR0500053</td>
                        <td style="border: hidden;" colspan="6">4,155.00</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">BANK DRAF</td>
                        <td>25CQTR0500054</td>
                        <td style="border: hidden;" colspan="6">34,791.00</td>
                    </tr>
                    <tr style="border: hidden;">
                        <td>10/01/2025</td>
                        <td style="border: hidden;">BANK DRAF</td>
                        <td>25CQTR0500055</td>
                        <td style="border: hidden;" colspan="6">4,030.00</td>
                    </tr>
                    <tr style="border-top: hidden; border-left: hidden; border-right: hidden;">
                        <td colspan="9"></td>
                    </tr>
                    <tr style="border-left: hidden; border-right: hidden;">
                        <td colspan="9"></td>
                    </tr>
                    <tr style="border-left: hidden; border-right: hidden;">
                        <th colspan="3" class="text-right">JUMLAH BESAR</th>
                        <th style="border-left: hidden; border-right: hidden;" colspan="2">63,512.00</th>
                        <th colspan="4">4,030.00</th>
                    </tr>
                </tbody>
            </table>
           <button type="button" class="btn btn-primary mt-5 float-right" onclick="window.print()">@lang('app.print')</button>
       </div>
    </div>
  </div>
</section>
@endsection