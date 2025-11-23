@extends('clientarea.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* General Styles */
    body {
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
        background-color: white !important;
    }
    .content-wrapper{
            background-color: #fff !important;
    }

    .address-wrap {
        white-space: normal !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }


    /* Print-specific styles */
    @media print {
         html, body {
            height: 100%;
        }

        .row, .head-row {
            display: table !important;
            width: 100% !important;
            
        }

        body, p, span, div, h6 {
            font-size: 15pt !important;
            line-height: 1.4 !important;
        }

        .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-8 {
            display: table-cell !important;
            float: none !important;
            vertical-align: top !important;
        }

        .last_para {
            position: absolute !important;
            bottom: 20px !important;
            left: 0;
            right: 0;
            text-align: center !important;
            width: 100%;
            font-size: 16pt;
            margin-left: 25px !important;
        }

            @media print {
            .img3 {
                float: left !important;
                margin-right: auto !important;
                margin-left: -15px !important;
            }
        }

    
    }

    
    /* Screen styles to maintain normal layout */
    @media screen {
        .head-row, .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        
        .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-8 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        
        .col-md-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
        
        .col-md-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
        
        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
        
        .col-md-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }
        
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        
        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }
    }

    .row.mt-3.head-row {
        border-bottom: none !important;
    }

    .col-md-4.ruj.text-left {
        padding-left: 250px !important;
    }
    .last_para {
        margin-left: 83px;
        color: grey; 
        white-space: nowrap;
    }
</style>
<title>@lang('app.trench_contribution_bill') | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-envelope" aria-hidden="true"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content">
        <div class="row mt-3 head-row">
            <div class="col-md-12 text-center">
                <img src="{{ asset('assets/images/letterhead.jpg') }}" 
                    class="img-fluid" 
                    alt="JPS Header" 
                    style="width: 100%; max-width: 100%;">
            </div>
        </div>
        <div class="container middle-body">
            <div class="row mt-3">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/admin-images/new-title.png') }}" class="img-fluid img3"
                        alt="Kita Selangor Logo" style="width: 200px;">
                </div>
                <div class="col-md-4 ruj text-left">
                    <p class="mb-0" style="white-space: nowrap;">Ruj. Kami</p>
                    <p>Tarikh</p>
                </div>
                <div class="col-md-3 text-left p-0">
                    <p class="mb-0" style="white-space: nowrap;">: {{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
                    <!--<p class="mb-0" style="white-space: nowrap;">: {{ $application->created_at ? $application->created_at->format('d M Y') : '10 hb September 2024' }}</p>-->
                    <p class="mb-0" style="white-space: nowrap;">
                        : {{ App\Helpers\DateHelper::formatMalayDate($application->created_at) }}
                    </p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <p class="mb-0">{{ ucwords(strtolower($application->applicant)) }}</p>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0 address-wrap">
                                {{ ucwords(strtolower(str_replace(',', ', ', $application->address))) }}
                            </p>
                       </div>
                    </div>

                    <p class="mb-0">{{ ucwords(strtolower($application->city)) }}, {{ $application->postal_code }}, {{ ucwords(strtolower($application->daerah ?? 'N/A')) }}</p>
                    <p class="mb-0">{{ ucwords(strtolower($application->negeri ?? 'N/A')) }} Darul Ehsan</p>

                    <br>
                    <p class="">Tuan,</p>
                    <h6 class="mb-0 text-justify">
                        <b>{{ strtoupper($application->project_name ?? 'N/A') }}</b>
                    </h6>
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
                    <p class="mb-0"><b>"KITASELANGOR MAJU BERSAMA"</b></p>
                    <p class="mb-0"><b>"MALAYSA MADANI"</b></p>
                    <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                    <p>Saya yang menjalankan amanah,</p>
                    <p class="mb-2"><b>Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row last_row align-items-center mt-3">
                <div class="col-md-6">
                </div>
            </div>
             <p class="last_para  mb-0" >@lang('app.computer_printout')</p>
            <div class="col-md-12 mt-3  text-right no-print display-flex jsutify-content-end">
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
