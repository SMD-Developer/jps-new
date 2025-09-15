<!-- @extends('app') -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* General Styles */
    body {
        font-family: "Poppins", sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 400;
    }

    /*.content-header h5 {*/
    /*    font-weight: 600;*/
    /*    color: #ff7700;*/
    /*}*/

    /* Container */
    .form-container {
        /*max-width: 1000px;*/
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

    .table td, .table th {
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

    .page-navigation span, .page-navigation i {
        background-color: #f5f5f5;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    .page-navigation span:hover, .page-navigation i:hover {
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
        /*margin-bottom: 20px;*/
    }

    /* Buttons */
    .buttons button {
        margin-right: 10px;
        font-weight: 500;
    }
    
    

    
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
    th, td {
      border: 1px solid black;
      padding: 5px;
      text-align: left;
    }
    .header-table {
      text-align: center;
      border: none;
      margin-bottom: 20px;
    }
    .section-title {
      font-weight: bold;
      text-align: center;
      padding: 10px 0;
    }
    .note {
      text-align: center;
      font-size: 12px;
      font-weight: bold;
      color: orange;
    }
    .summary-table th, .summary-table td {
      text-align: center;
    }
    .total-row td {
      font-weight: bold;
    }
    
    
        }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    /*th {*/
    /*  background-color: #f2f2f2;*/
    /*}*/
    .header {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .total-row td {
      font-weight: bold;
      text-align: right;
    }
    .total-row td:first-child {
      text-align: left;
    }
    .note {
      font-size: 12px;
      font-weight: bold;
      color: orange;
      text-align: left;
    }
    .last td{
        text-align: center;
    }
    
    
    
    
    
    
        /*    }*/
        /*.header {*/
        /*    text-align: center;*/
        /*}*/
        /*.header h2, .header h3, .header h4 {*/
        /*    margin: 5px 0;*/
        /*}*/
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        /*th {*/
        /*    background-color: #f2f2f2;*/
        /*    text-align: center;*/
        /*}*/
        .section-title {
            font-weight: bold;
            margin: 20px 0 10px;
        }
        .no-border td {
            border: none;
        }
        .center {
            text-align: center;
        }
        
        
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td {
            border: 1px solid black;
            vertical-align: top;
        }
        .design-cell {
            text-align: left;
            padding: 10px;
        }
        .box-container {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .box {
            width: 20px;
            height: 20px;
            border: 1px solid black;
            margin-right: 10px;
        }
        .line-text {
            flex: 1;
        }
</style>

<title>@lang('app.collectors_receipt') | JPS</title>

@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-file" aria-hidden="true"></i> @lang('app.collectors_receipt')</h5>
</div>

<section class="content">
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
                              <td style="border-left: 0; border-right: 0;">Tarikh : 13/01/2025</td>
                              <td class="text-center" style="border-left: 0;">No. Slip Bank : 25CQPP0500009 </td>
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
                              <td>ENAM PULUH TIGA RIBU LIMA RATUS DUA BELAS SAHAJA</td>
                              <td class="text-center">63,512.00</td>
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
                              <td class="text-center">25CQPP500009</td>
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
                              <td>10/01/2025</td>
                              <td>Hingga:</td>
                              <td>Tarikh <br> diterima <br> oleh bank</td>
                              <td>10/01/2025</td>
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
                              <td>SITI AZILA BINTI TARMUJI</td>
                              <td>ANNIE AZKIAH BINTI ANOAR</td>
                              <td>NOORAZINI BINTI NAZIRUDDIN</td>
                            </tr>
                            <tr>
                              <td>Jawatan</td>
                              <td>PEMBANTU TADBIR (KEWANGAN) GRED W19</td>
                              <td>PEMBANTU TADBIR (KEWANGAN) GRED W22</td>
                              <td>PENOLONG AKAUNTAN GRED W29</td>
                            </tr>
                            <tr>
                              <td>Tarikh</td>
                              <td>10/01/2025</td>
                              <td>10/01/2025</td>
                              <td>10/01/2025</td>
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
                    
                    <section class="3" style="margin-top: 100px;">
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
                              <td class="text-center">25CQPP500009</td>
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
                              <td>10/01/2025</td>
                              <td>Hingga:</td>
                              <td>Tarikh <br> diterima <br> oleh bank</td>
                              <td>10/01/2025</td>
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
                                <td>31,756.00</td>
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
                                <td>31,756.00</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="7" class="text-left py-4" style="border-right: 0;"><b>CARUMAN PARIT</b></td>
                                <td colspan="2" style="border-left: 0; border-right: 0; padding-top: 24px;">JUMLAH</td>
                                <td style="border-left: 0; border-right: 0; text-decoration-line: underline overline; padding-top: 25px;">63,512.00</td>
                                <td style="border-left: 0; border-right: 0; padding-top: 20px;">Jumlah Bil. <br> Subsidiari</td>
                                <td style="border-left: 0; text-decoration-line: overline underline; padding-top: 25px;">63,512.00</td>
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
                              <tr>
                                <td>1</td>
                                <td>25CQTR0500055</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">4,030.00</td>
                                <td style="text-align: left;">L453 - BIL (6) DLM.JKS.PTG.C4/1780 G001 - ATAS LOT 28822 ALAM ENAM TAMAN TENAGA UCHONG MUKIM PETALING DAERAH PETALING</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>25CQTR0500054</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">34,791.00</td>
                                <td style="text-align: left;">L453-PTG.NO.2/119/2023(PM/20) G001 KE ATAS HAKMILIK PM 12571 LOT 9636 BANDAR SUNGAI BULOH, DAERAH GOMBAK</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>25CQTR0500053</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">4,155.00</td>
                                <td style="text-align: left;">L453 - PTSE/06/PSB/2024/8 G001 - HAKMILIK RM 13 LOT 12503 DJ JALAN BUKIT INDAH SEKSYEN 10 BANDAR KAJANG HULU LANGAT SELANGOR SELUAS 831 METER PERSEGI</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>25CQTR0500052</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">3,945.00</td>
                                <td style="text-align: left;">L453-PTSEL/06/PSB/2024/3 G001 KE ATAS HAKMILIK PM 14 LOT 12504 DI TAMAN BUKIT MEWAH, BANDAR KAJANG, SELANGOR SELUAS 831 METER PERSEGI</td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>25CQTR0500051</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">3,000.00</td>
                                <td style="text-align: left;">L453-PTKS.04/03/PB02/01/032021(12) G001 - DI LOT 1882 SELUAS 1.2414 HEKTAR DI PEKAN SIMPANG TIGA IJOK DAERAH KUALA SELANGOR</td>
                              </tr>
                              <tr>
                                <td>6</td>
                                <td>25CQTR0500050</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">3,000.00</td>
                                <td style="text-align: left;">L453 - PTKS.04/03/ PB02/02 032021(14) G001 - ATAS LOT 1883 SELUAS 1.2414 HEKTAR DI PEKAN SIMPANG TIGA IJOK DAERAH KUALA SELANGOR</td>
                              </tr>
                              <tr>
                                <td>7</td>
                                <td>25CQTR0500049</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">10,115.00</td>
                                <td style="text-align: left;">L453-BIL.(10)DLM.JPS. 1607/7/22/02 BTH 27.12.2024 G001 - ATAS LOT 43028 (PT 12724), JALAN KENCANA 20/1, MUKIM AMPANG, DAERAH HULU LANGAT SELUAS 0.2023 HEKTAR</td>
                              </tr>
                              <tr>
                                <td>8</td>
                                <td>25CQTR0500048</td>
                                <td>10/01/2025</td>
                                <td style="text-align: right;">476.00</td>
                                <td style="text-align: left;">L453 - BIL (11) DLM. PTHS. 2/201/2022 G001 - ATAS PT 1648 MUKIM RASA DAERAH HULU SELANGOR SELUAS 0.9516 EKAR (0.3854 HEKTAR)</td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr class="total-row">
                                <td style="border-right: 0; text-align: right;" colspan="3">JUMLAH</td>
                                <td style="border-left: 0; border-right: 0; text-align: right;">63,512.00</td>
                                <td style="border-left: 0;"></td>
                              </tr>
                            </tfoot>
                        </table>
                    </section>  
                    
                    <section class="4" style="margin-bottom: 50px;">
                        <table class="header-table mb-0">
                            <tr>
                              <td class="text-center"></td>
                              <td class="text-center">Disediakan</td>
                              <td class="text-center">Semak</td>
                              <td class="text-center">Lulus</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>SITI AZILA BINTI TARMUJI</td>
                              <td>ANNIE AZKIAH BINTI ANOAR</td>
                              <td>NOORAZINI BINTI NAZIRUDDIN</td>
                            </tr>
                            <tr>
                              <td>Jawatan</td>
                              <td>PEMBANTU TADBIR (KEWANGAN) GRED19</td>
                              <td>PEMBANTU TADBIR (KEWANGAN) GRED22</td>
                              <td>PENOLONG AKAUNTAN GRED29</td>
                            </tr>
                            <tr>
                              <td>Tarikh</td>
                              <td>10/01/2025</td>
                              <td>10/01/2025</td>
                              <td>10/01/2025</td>
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
                    
                    <section class="5" style="margin-top: 100px;">
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
                              <td class="text-center">25CQPP500009</td>
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
                              <td>10/01/2025</td>
                              <td>Hingga:</td>
                              <td>Tarikh <br> diterima <br> oleh bank</td>
                              <td>10/01/2025</td>
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
                    
                    <section class="6" style="margin-bottom: 50px;">
                        <table class="header-table mb-0">
                            <tr>
                              <td class="text-center"></td>
                              <td class="text-center">Disediakan</td>
                              <td class="text-center">Semak</td>
                              <td class="text-center">Lulus</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>SITI AZILA BINTI TARMUJI</td>
                              <td>ANNIE AZKIAH BINTI ANOAR</td>
                              <td>NOORAZINI BINTI NAZIRUDDIN</td>
                            </tr>
                            <tr>
                              <td>Jawatan</td>
                              <td>PEMBANTU TADBIR (KEWANGAN) GRED W19</td>
                              <td>PEMBANTU TADBIR (KEWANGAN) GRED W22</td>
                              <td>PENOLONG AKAUNTAN (KEWANGAN) GRED W29</td>
                            </tr>
                            <tr>
                              <td>Tarikh</td>
                              <td>10/01/2025</td>
                              <td>10/01/2025</td>
                              <td>10/01/2025</td>
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
                        <button class="btn btn-success mx-2" id="demo">
                            @lang('app.simpan')
                        </button>
                         <button class="btn btn-primary mx-2" onclick="window.print()">
                            @lang('app.print')
                        </button>
                        <!--<button class="btn btn-info mx-2" id="printButton">-->
                        <!--    @lang('app.send_to_reviewer2')-->
                        <!--</button>-->
                        <button class="btn btn-info mx-2" id="demo2">
                            @lang('app.send_to_reviewer')
                        </button>
                        
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    // Ensure DOM is fully loaded before running scripts
    document.addEventListener('DOMContentLoaded', function () {
        
        function attachClickEvent(selector, callback) {
            let element = document.querySelector(selector);
            if (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent default action
                    callback();
                });
            }
        }

        // Simpan Button Event
        attachClickEvent('#demo', function () {
            Swal.fire({
                title: '{{ __("app.are_you_sure_to_save_this_record?") }}',
                text: '{{ __("") }}',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("app.yes") }}',
                cancelButtonText: '{{ __("app.no") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('{{ __("app.list_of_receipt_save_successfully") }}', '', 'success');
                }
            });
        });
        
         attachClickEvent('#demo2', function () {
            Swal.fire({
                title: '{{ __("app.are_you_sure2") }}',
                text: '{{ __("") }}',
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
