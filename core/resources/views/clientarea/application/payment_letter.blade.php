@extends('clientarea.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* General Styles */
    body {
        /*font-family: sans-serif;*/
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
        background-color: #f4f6f9 !important;
    }

</style>

@section('content')
    <div class="col-md-12 content-header" >
        <h5><i class="fa fa-list"></i>@lang('app.new_application')</h5>
    </div>
 

    <section class="content">
        <!--<div class="row">-->
        <!--    <div class="col-md-12">-->
        <!--        <h4>@lang('app.new_application')</h4>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="container middle-body">
        <div class="row  mt-3 head-row">
            <div class="col-md-2">
                <img src="{{ asset('assets/images/admin-images/selangorJata.png') }}" class="img-fluid img1 float-right" alt="..." width="90%;">
            </div>
            <div class="col-md-5">
                <p class="mb-0 head-1"><b>@lang('JABATAN PENGAIRAN DAN SALIRAN NEGERI SELANGOR')</b></p>
                <p class="mb-0 head-1">@lang('(SELANGOR STATE IRRIGATION AND DRAINAGE DEPARTMENT)')</p>
                <p class="mb-0 head-1"><b>@lang('TINGKAT 5,BLOK PODIUM SELATAN')</b></p>
                <p class="mb-0 head-1"><b>@lang('BANGUNAN SULTAN SALAHUDDIN ABDUL AZIZ SHAH')</b></p>
                <p class="mb-0 head-1"><b>@lang('40626 SHAH ALAM,SELANGOR')</b></p>
            </div>
            <div class="col-md-3 px-0">
                <i class="bi bi-telephone-forward-fill" style="font-size: 13px;"> </i>&nbsp; :03-5544 7376/7586 <br>
                <i class="bi bi-telephone-forward-fill" style="font-size: 13px;"> </i>&nbsp; :03-5521 2204/2205/2207 <br>
                <i class="bi bi-printer" style="font-size: 13px;"> </i>&nbsp; :03-5544 2911/5510 4494<br>
                <i class="bi bi-envelope-arrow-up" style="font-size: 13px;"> </i>&nbsp; :webmaster@waterselangor.gov.my <br>
                <i class="bi bi-globe" style="font-size: 13px;"> </i>&nbsp; :http://water.selangor.gov.my 
            </div>
             <div class="col-md-2 pl-0">
                 <img src="{{ asset('assets/images/admin-images/logo-jps-(tran)(wordwhite).png') }}" class="img-fluid img2 float-left" alt="...">
            </div>
        </div>
        </div>
        <div class="container middle-body">
            <!--<div class="row mt-3 ">-->
            <!--    <div class="col-md-12">-->
            <!--        <img src="{{ asset('assets/images/admin-images/logo-kita-selangor.png') }}"  class="img-fluid img3" alt="...">-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="row">-->
            <!--    <div class="col-md-1"></div>-->
            <!--    <div class="col-md-5 mx-5 mt-3">-->
            <!--        <img src="{{ asset('assets/images/admin-images/logo-kita-selangor.png') }}"  class="img-fluid img3" alt="..." width="100%">-->
            <!--    </div>-->
            <!--    <div class="col-md-4"></div>-->
            <!--    <div class="col-md-2"></div>-->
            <!--</div>-->
            <div class="row mt-3">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/admin-images/logo-kita-selangor.png') }}"  class="img-fluid img3" alt="..." width="60%">
                </div>
                <!--<div class="col-3">-->
                <!--</div>-->
                <div class="col-md-2 ruj text-left">
                    <!--<p class="mb-0">Ruj. Tuan</p>-->
                    <p class="mb-0">Ruj. Kami</p>
                    <p>Tarikh</p>
                </div>
                <div class="col-md-2 text-left p-0">
                    <!--<p class="mb-0">: SF/CV/1891/24</p>-->
                    <p class="mb-0">: Bil</p>
                    <p class="mb-0">: 10 hb September 2024</p>
                    <!--<p class="mb-0"></p>-->
                    <!--<p class="mb-0"></p>-->
                    <!--<p class="mb-0"></p>-->
                </div>
                <div class="col-md-2"></div>
                <!--<div class="col-3 pl-0">-->
                <!--    <p class="mb-0">SF/CV/1891/24</p>-->
                <!--    <p class="mb-0">Bil</p>-->
                <!--    <p class="mb-0">10 hb September 2024</p>-->
                <!--</div>-->
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <p class="mb-0">T.F Wong & Tee</p>
                    <p class="mb-0">No 37-1, 1st Floor, Jalan Batal Laut 3,</p>
                    <p class="mb-0">Taman Inatan. 41300 Klang,</p>
                    <p class="mb-0">Selangor Darul Ehsan.</p>
                    <br>
                    <p class="">Taun,</p>
                    <h6 class="mb-0"><b>PERMOHONAN PENGESAHAN BAYARAN CARCUMAN PARIT DI ATAS H.S.(D) 152420, PT 121638 MUKIM KLANG DAERAH KALNG NEGERI SELANGOR UNTUK TETUAN TRIUMPHERO SDN. BHD.</b></h6>
                    <p class="pengesahan"><strong>-Pengesahan Bayaran Caruman Parit</strong></p>
                    <p>Dengan segala homatnya saya diarakhan merujuk kepada perkara tersebut di atas.</p>
                    <p>
                        2. Berdasarkan geran tanah dan dokumen sokongan yang dilampirkan keluasan  tanah yang perlu di bayar ialah <b>0.933 hektar</b>. Oleh yang demikian pihak tuan adalah
                        dikehhendaki membayar caruman parit ke jabatan ini  <b>berjumlah RM 46,650.00 (RM 50,000.00 x 0.933 hektar) dalam bentuk Bank Deraf di atas 
                        nama Pengarah Pengairan dan Saliran negeri Selangor.</b> Sila sertakan surat ini semasa banayaran hendak dijelaskan.
                    </p>
                    <p>Sekian, terima kasih.</p>
                    <p class="mb-0"><b>"#KITASELANGOR MAJU BERSAMA"</b></p>
                    <p class="mb-0"><b>"#MALAYSA MADANI"</b></p>
                    <p><b>"BERKHIDAMAT UNTUK NEGARA"</b></p>
                    <p>Saya yang menjalankan amanah,</p>
                    <p class="mb-0"><b>Ir ZurraidyBin Jalal</b></p>
                    <p class="mb-0"><b>Helper DerectorRight,</b></p>
                    <p class="mb-0"><b>Division Drainage Friendly Nature and Contribution Ditch</b></p>
                    <p class="mb-0"><b>Mr Director Irrigation And Drainage</b></p>
                    <p><b>Selangor State</b></p>
                    <!--<p class="ml-5">This is print computer and no necessary signed</p>-->
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row last_row">
                <div class="col-md-2"></div>
                    <div class="col-md-8">
                    <p class="last_para">@lang('app.computer_printout')</p>
                </div> 
                <div class="col-md-2"></div>
            </div>
            <div class="row last_row">
                <div class="col-md-6"></div>
                <div class="col-6 float-right mt-5 col6">
                        <button type="button" class="btn btn-primary float-right">@lang('app.download')</button>&nbsp;&nbsp;&nbsp;
                        <a href="{{route('original_receipt')}}"  type="button" class="btn btn-danger float-right">@lang('app.please_make_payment')</a>
                </div>
            </div>
        </div>
    </section>
@endsection