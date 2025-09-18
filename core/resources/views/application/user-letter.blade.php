<!--@extends('app')-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    /* Print-specific styles */
    @media print {
        @page {
            size: A4;
            margin: 10mm;
        }
        
        body {
            margin: 0;
            padding: 0;
            background: white;
            font-size: 12pt;
        }
        
        .no-print {
            display: none !important;
        }
        
        .container {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }
        
        img {
            max-width: 100% !important;
            height: auto !important;
        }
        
        .img1 {
            width: 120px !important;
            float: right !important;
        }
        
        .img2 {
            width: 100px !important;
            float: left !important;
        }
        
        .img3 {
            width: 200px !important;
        }
        
        /* Keep flexbox for print to maintain exact layout */
        .head-row, .row {
            display: flex !important;
            flex-wrap: wrap !important;
            margin-right: 0 !important;
            margin-left: 0 !important;
        }
        
        .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-8 {
            position: relative !important;
            padding-right: 15px !important;
            padding-left: 15px !important;
        }
        
        .col-md-2 {
            flex: 0 0 16.666667% !important;
            max-width: 16.666667% !important;
        }
        
        .col-md-3 {
            flex: 0 0 25% !important;
            max-width: 25% !important;
        }
        
        .col-md-4 {
            flex: 0 0 33.333333% !important;
            max-width: 33.333333% !important;
        }
        
        .col-md-5 {
            flex: 0 0 41.666667% !important;
            max-width: 41.666667% !important;
        }
        
        .col-md-6 {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
        
        .col-md-8 {
            flex: 0 0 66.666667% !important;
            max-width: 66.666667% !important;
        }
        
        /* Ensure float works properly in print with flexbox */
        .float-right {
            float: right !important;
            display: block !important;
            width: auto !important;
        }
        
        .float-left {
            float: left !important;
            display: block !important;
            width: auto !important;
        }
        
        /* Specific image positioning for print */
        .img1 {
            width: 120px !important;
            float: right !important;
            margin-left: auto !important;
        }
        
        .img2 {
            width: 100px !important;
            float: left !important;
            margin-right: auto !important;
        }
        
        /* Ensure column content alignment */
        .col-md-2:first-child {
            text-align: right !important;
        }
        
        .col-md-2:last-child {
            text-align: left !important;
        }
        
        /* Text alignment fixes */
        .text-right {
            text-align: right !important;
        }
        
        .text-left {
            text-align: left !important;
        }
        
        .text-justify {
            text-align: justify !important;
        }
        
        /* Spacing utilities */
        .mt-3 {
            margin-top: 1rem !important;
        }
        
        .mb-0 {
            margin-bottom: 0 !important;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem !important;
        }
        
        .pl-0 {
            padding-left: 0 !important;
        }
        
        .px-0 {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }
        
        .p-0 {
            padding: 0 !important;
        }
        
        .head-1 {
            font-size: 10pt;
            line-height: 1.2;
        }
        
        .ruj p {
            margin-bottom: 0.5rem;
        }
        
        .pengesahan {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .last_row {
            margin-top: 2rem;
        }
        
        .last_para {
            color: grey;
            font-size: 10pt;
        }
        
        .align-items-center {
            vertical-align: middle !important;
        }
        
        .mr-2 {
            margin-right: 0.5rem !important;
        }
        
        /* Additional print-specific layout fixes */
        .head-row {
            width: 100% !important;
        }
        
        /* Prevent breaking inside columns */
        .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-8 {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
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
</style>
<title>@lang('app.trench_contribution_bill') | JPS</title>
@section('content')
    <div class="col-md-12 content-header no-print">
        <h5><i class="fa fa-list"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content">
        <div class="container middle-body">
            <div class="row mt-3 head-row">
                <div class="col-md-2">
                    <img src="{{ asset('assets/images/admin-images/Picture1-removebg-preview.png') }}"
                        class="img-fluid img1 float-right" alt="JPS Logo" style="width: 120px;">
                </div>
                <div class="col-md-5">
                    <p class="mb-0 head-1"><b>@lang('JABATAN PENGAIRAN DAN SALIRAN NEGERI SELANGOR')</b></p>
                    <p class="mb-0 head-1">@lang('(SELANGOR STATE IRRIGATION AND DRAINAGE DEPARTMENT)')</p>
                    <p class="mb-0 head-1"><b>@lang('TINGKAT 5,BLOK PODIUM SELATAN')</b></p>
                    <p class="mb-0 head-1"><b>@lang('BANGUNAN SULTAN SALAHUDDIN ABDUL AZIZ SHAH')</b></p>
                    <p class="mb-0 head-1"><b>@lang('40626 SHAH ALAM,SELANGOR')</b></p>
                </div>
                <div class="col-md-3 px-0" style="font-size: 10pt;">
                    <i class="bi bi-telephone-forward-fill"> </i>&nbsp; : 03-5544 7376/7586 <br>
                    <i class="bi bi-telephone-forward-fill"> </i>&nbsp; : 03-5521 2204/2205/2207 <br>
                    <i class="bi bi-printer"> </i>&nbsp; : 03-5544 2911/5510 4494<br>
                    <span style="white-space: nowrap;">
                        <i class="bi bi-envelope-arrow-up"></i> &nbsp;&nbsp;: webmaster@waterselangor.gov.my
                    </span>
                    <i class="bi bi-globe"> </i>&nbsp; : http://water.selangor.gov.my
                </div>
                <div class="col-md-2 pl-0">
                    <img src="{{ asset('assets/images/admin-images/logo-jps-(tran)(wordwhite).png') }}"
                        class="img-fluid img2 float-left" alt="JPS Word Logo" style="width: 100px;">
                </div>
            </div>
        </div>
        <div class="container middle-body">
            <div class="row mt-3">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/admin-images/logo-kita-selangor.png') }}" class="img-fluid img3"
                        alt="Kita Selangor Logo" style="width: 200px;">
                </div>
                <div class="col-md-2 ruj text-left">
                    <p class="mb-0">Ruj. Kami</p>
                    <p>Tarikh</p>
                </div>
                <div class="col-md-2 text-left p-0">
                    <p class="mb-0" style="white-space: nowrap;">: {{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
                    <!--<p class="mb-0" style="white-space: nowrap;">: {{ $application->created_at ? $application->created_at->format('d M Y') : '10 hb September 2024' }}</p>-->
                    <p class="mb-0">
                        : {{ App\Helpers\DateHelper::formatMalayDate($application->created_at) }}
                    </p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <p class="mb-0">Tetuan {{ ucwords(strtolower($application->applicant)) }}</p>
                    <p class="mb-0">{{ ucwords(strtolower(str_replace(',', ', ', $application->address))) }}</p>
                    <p class="mb-0">{{ ucwords(strtolower($application->city)) }}, {{ $application->postal_code }}, {{ ucwords(strtolower($application->daerah ?? 'N/A')) }}</p>
                    <p class="mb-0">{{ ucwords(strtolower($application->negeri ?? 'N/A')) }} Darul Ehsan</p>

                    <br>
                    <p class="">Tuan,</p>
                    <h6 class="mb-0 text-justify"><b>PENGESAHAN BAYARAN CARUMAN PARIT DI ATAS
                            {{ strtoupper($application->land_lot) }}, {{ strtoupper($application->land_mukim ?? 'N/A') }},
                            DAERAH {{ strtoupper($application->land_daerah ?? 'N/A') }}, NEGERI SELANGOR UNTUK TETUAN
                            {{ strtoupper($application->applicant) }}.</b></h6>
                    <p class="pengesahan"><strong>-Pengesahan Bayaran Caruman Parit</strong></p>
                    <p>Dengan segala hormatnya saya diarahkan merujuk kepada perkara tersebut di atas.</p>
                    <p style="text-align:justify;">
                        2. Berdasarkan geran tanah dan dokumen sokongan yang dilampirkan, keluasan tanah yang perlu di bayar
                        ialah
                        <b>{{ number_format($application->hectare, 2) }}
                            hektar</b>. Oleh yang demikian pihak tuan adalah
                        dikehendaki membayar caruman parit ke jabatan ini <b>berjumlah RM
                            {{ number_format($application->final_amount, 2) }}
                            @if($application->appeal != 'yes')
                                (RM {{ number_format($application->cost, 2) }} x {{ number_format($application->hectare, 2) }}
                                hektar)
                            @endif
                            </b>.
                    </p>
                    <p>Sekian, terima kasih.</p>
                    <p class="mb-0"><b>"#KITASELANGOR MAJU BERSAMA"</b></p>
                    <p class="mb-0"><b>"MALAYSA MADANI"</b></p>
                    <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                    <p>Saya yang menjalankan amanah,</p>
                    <p class="mb-2"><b>Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row last_row align-items-center mt-3">
                <div class="col-md-6">
                    <p class="last_para mb-0" style="margin-left: 166px; color: grey; white-space: nowrap;">
                        @lang('app.computer_printout')</p>
                </div>
            </div>
            <div class="col-md-12 mt-3  text-right no-print display-flex jsutify-content-end">
                     <button type="button" class="btn btn-success mx-2" onclick="window.location.href='{{ route('updateApplicationForm', ['id' => $application->id]) }}'">
                        @lang('app.back')
                    </button>
                    <button type="button" class="btn btn-secondary mr-2" onclick="window.print()">
                        <i class="bi bi-printer"></i> @lang('app.print')
                    </button>
                    <!--<button type="button" class="btn btn-primary" id="successButton">-->
                    <!--    @lang('app.adminstaff_send_to_approver')-->
                    <!--</button>-->
                    <button type="button" class="btn btn-primary" id="successButton"
                        @if($application->status === 'approved') disabled style="background-color: #ccc; border-color: #ccc; color: #666;" @endif>
                        @lang('app.adminstaff_send_to_approver')
                    </button>
                </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showConfirmationPopup() {
            Swal.fire({
                title: '@lang('app.are_you_sure_approver')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('app.yes')',
                cancelButtonText: '@lang('app.cancel')',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route('send-to-approver') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                            },
                            body: JSON.stringify({
                                application_id: '{{ $application->id }}',
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showSuccessMessage();
                            } else {
                                Swal.fire('Error', data.message || 'Failed to send notification.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'An error occurred: ' + error.message, 'error');
                        });
                }
            });
        }

        function showSuccessMessage() {
            Swal.fire({
                title: '@lang('app.success')',
                text: '@lang('app.new_application_has_been_sent_for_check.')',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('application_list') }}';
                }
            });
        }

        document.getElementById('successButton').addEventListener('click', showConfirmationPopup);
    </script>
@endsection