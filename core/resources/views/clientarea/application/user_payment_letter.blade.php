@extends('clientarea.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* General Styles */
    body {
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }

    .col-md-3.px-0 {
        font-size: 12px;
    }
    
    /* Payment Modal Styles */
    .payment-option-card {
        cursor: pointer;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .payment-option-card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,123,255,.25);
        transform: translateY(-2px);
    }
    
    .payment-option-card.selected {
        border-color: #28a745;
        background-color: #f8f9fa;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,.3);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

</style>
<title>@lang('app.trench_contribution_bill') | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-envelope" aria-hidden="true"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content">
        <div id="letter-content">
            <div class="container middle-body">
                <div class="row mt-3 head-row">
                    <div class="col-md-2">
                    <img src="{{ asset('assets/images/admin-images/jps-latest-logo.png') }}" style="margin-bottom: 10px;" class="img-fluid img1 float-right"
                        alt="..." width="90%;">
                </div>
                    <div class="col-md-5">
                        <p class="mb-0 head-1"><b>@lang('JABATAN PENGAIRAN DAN SALIRAN NEGERI SELANGOR')</b></p>
                        <p class="mb-0 head-1">@lang('(SELANGOR STATE IRRIGATION AND DRAINAGE DEPARTMENT)')</p>
                        <p class="mb-0 head-1"><b>@lang('TINGKAT 5,BLOK PODIUM SELATAN')</b></p>
                        <p class="mb-0 head-1"><b>@lang('BANGUNAN SULTAN SALAHUDDIN ABDUL AZIZ SHAH')</b></p>
                        <p class="mb-0 head-1"><b>@lang('40626 SHAH ALAM,SELANGOR')</b></p>
                    </div>
                    <div class="col-md-3 px-0">
                        <i class="bi bi-telephone-forward-fill" style="font-size: 13px;"> </i> : 03-5544 7376/7586 <br>
                        <i class="bi bi-telephone-forward-fill" style="font-size: 13px;"> </i> : 03-5521 2204/2205/2207 <br>
                        <i class="bi bi-printer" style="font-size: 13px;"> </i> : 03-5544 2911/5510 4494 <br>
                        <i class="bi bi-envelope-arrow-up" style="font-size: 13px;"> </i> : webmaster@waterselangor.gov.my
                        <br>
                        <i class="bi bi-globe" style="font-size: 13px;"> </i> : http://water.selangor.gov.my
                    </div>
                    <div class="col-md-2 pl-0">
                        <img src="{{ asset('assets/images/admin-images/logo-jps-(tran)(wordwhite).png') }}"
                            class="img-fluid img2 float-left" alt="...">
                    </div>
                </div>
            </div>
            <div class="container middle-body">
                <div class="row mt-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <img src="{{ asset('assets/images/admin-images/new-title.png') }}" class="img-fluid img3"
                            alt="..." width="60%">
                    </div>
                    <div class="col-md-2 ruj text-left">
                        <!--<p class="mb-0">Ruj. Tuan</p>-->
                        <p class="mb-0">Ruj. Kami</p>
                        <p>Tarikh</p>
                    </div>
                    <div class="col-md-2 text-left p-0">
                        <p class="mb-0" style="white-space: nowrap;">:{{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
                        <p class="mb-0">
                            : {{ App\Helpers\DateHelper::formatMalayDate($application->created_at) }}
                        </p>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <p class="mb-0">{{ ucwords(strtolower($application->applicant)) }}</p>
                        <p class="mb-0">{{ ucwords(strtolower(str_replace(',', ', ', $application->address))) }}</p>
                        <p class="mb-0">{{ ucwords(strtolower($application->city)) }}, {{ $application->postal_code }}, {{ ucwords(strtolower($application->daerah ?? 'N/A')) }}</p>
                        <p class="mb-0">{{ ucwords(strtolower($application->negeri ?? 'N/A')) }} Darul Ehsan</p>
                        <br>
                        <p class="">Tuan,</p>
                        <h6 class="mb-0 text-justify"><b>{{ strtoupper($application->project_name ?? 'N/A') }}</b></h6>
                        <p class="pengesahan"><strong>-Pengesahan Bayaran Caruman Parit</strong></p>
                        <p>Dengan segala hormatnya saya diarahkan merujuk kepada perkara tersebut di atas.</p>
                        <p style="text-align:justify;">
                            @if($application->appeal === 'yes' && $application->appeal_status === 'approved')
                                <b>Dimaklumkan bahawa rayuan yang telah dikemukakan oleh pihak tuan berhubung bayaran caruman parit bagi tanah tersebut dan surat kelulusan yang dikemukakan. Berdasarkan semakan terhadap geran tanah keluasan tanah yang terlibat ialah
                                {{ number_format($application->hectare, 2) }} hektar.</b> 
                                Oleh yang demikian, pihak tuan adalah dikehendaki membayar caruman parit kepada jabatan ini berjumlah 
                                <b>RM {{ number_format($application->final_amount, 2) }}</b>.
                            @else
                                2. Berdasarkan geran tanah dan dokumen sokongan yang dilampirkan, keluasan tanah yang perlu di bayar
                                ialah <b>{{ number_format($application->hectare, 2) }} hektar</b>. Oleh yang demikian pihak tuan adalah
                                dikehendaki membayar caruman parit ke jabatan ini <b>berjumlah RM
                                    {{ number_format($application->final_amount, 2) }}
                                    @if($application->appeal != 'yes')
                                        (RM {{ number_format($application->cost, 2) }} x {{ number_format($application->hectare, 2) }} hektar)
                                    @endif
                                </b>.
                                <br><br>
                                3. Jabatan ini hanya akan mempertimbangkan kelulusan pelan-pelan kerja tanah dan sistem saliran di atas setelah bayaran 
                                caruman parit tersebut dijelaskan.
                            @endif
                        </p>
                        <p>Sekian, terima kasih.</p>
                        <p class="mb-0"><b>"#KITASELANGOR MAJU BERSAMA"</b></p>
                        <p class="mb-0"><b>"MALAYSA MADANI"</b></p>
                        <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                        <p>Saya yang menjalankan amanah,</p>
                        <p class="mb-0"><b>Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                        <!--<p><b>Selangor</b></p>-->
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row last_row mt-4">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 mt-4">
                       <p class="last_para" style="color: grey;";>@lang('app.computer_printout')</p>
                    </div>
                    <div class="col-md-2"></div>
                </div>

            </div>
        </div>
        <div class="container middle-body">
            <div class="row last_row">
                <div class="col-md-6"></div>
                <div class="col-6 float-right mt-5 col6">
                    <button type="button" class="btn btn-primary me-2 float-right mx-3" id="downloadButton">
                        @lang('app.download')
                    </button>
                    <a href="{{ route('payment.selection', ['application' => $application->id]) }}" 
                        type="button"
                        id="makePaymentButton" 
                        class="btn btn-danger float-right"
                        data-application-id="{{ $application->id }}">
                        @lang('app.please_make_payment')
                    </a>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
    // Keep your existing download functionality
    document.getElementById('downloadButton').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });
    
        html2canvas(document.getElementById('letter-content'), {
            scale: 3,
            useCORS: true,
            allowTaint: true
        }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgProps = doc.getImageProperties(imgData);
            const pdfWidth = doc.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
    
            doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            doc.save('Trench_Contribution_Bill_' + '{{ $application->refference_no }}' + '.pdf');
        });
    });

    </script>
@endsection
