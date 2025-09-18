<!--@extends('app')-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* General Styles */
    body {
        /*font-family: sans-serif;*/
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
        /*background-color: #f4f6f9 !important;*/
    }

    /* .row.mx-3.mt-3.head-row {*/
    /*    display: flex;*/
    /*    align-items: center;*/
    /*} */
    /*.head-1{*/
    /*        font-size: 13px;*/
    /*}*/
    /* .head-row{*/
    /*    border-bottom: 11px solid;*/
    /*    display: flex;*/
    /*    align-items: center;*/
    /* }*/
    /* .ruj{*/
    /*    display: flex;*/
    /*    flex-direction: column;*/
    /*    align-items: flex-start;*/
    /*    padding-left: 70px !important;*/
    /*    text-align: end;*/
    /* }*/
    /* .middle-body{*/
    /*         padding-inline: 0px !important;*/
    /* }*/
    /*.pengesahan{*/
    /*        border-bottom: 3px solid;*/
    /*}*/
    /*.content{*/
    /*    margin-bottom: 50px;*/
    /*}*/
    /*.last_para{*/
    /*    padding-left: 0px;*/
    /*}*/
    /*.last_row{*/
    /*        padding-bottom: 30px;*/
    /*}*/
    /*.img1, .img2,{*/
    /*        height: 135px !important;*/
    /*}*/
    /*.col6{*/
    /*    display: flex;*/
    /*    justify-content: end;*/
    /*}*/
</style>
<title>@lang('app.trench_contribution_bill') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-envelope" aria-hidden="true"></i> @lang('app.trench_contribution_bill')</h5>
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
                    <img src="{{ asset('assets/images/admin-images/Picture1-removebg-preview.png') }}" class="img-fluid img1 float-right"
                        alt="..." width="90%;" style="margin-bottom: 10px;">
                </div>
                <div class="col-md-5">
                    <p class="mb-0 head-1"><b>@lang('JABATAN PENGAIRAN DAN SALIRAN NEGERI SELANGOR')</b></p>
                    <p class="mb-0 head-1">@lang('(SELANGOR STATE IRRIGATION AND DRAINAGE DEPARTMENT)')</p>
                    <p class="mb-0 head-1"><b>@lang('TINGKAT 5,BLOK PODIUM SELATAN')</b></p>
                    <p class="mb-0 head-1"><b>@lang('BANGUNAN SULTAN SALAHUDDIN ABDUL AZIZ SHAH')</b></p>
                    <p class="mb-0 head-1"><b>@lang('40626 SHAH ALAM,SELANGOR')</b></p>
                </div>
                <div class="col-md-3 px-0" style="font-size: 12px;">
                    <i class="bi bi-telephone-forward-fill"> </i>&nbsp; : 03-5544 7376/7586 <br>
                    <i class="bi bi-telephone-forward-fill"> </i>&nbsp; : 03-5521 2204/2205/2207 <br>
                    <i class="bi bi-printer"> </i>&nbsp; : 03-5544 2911/5510 4494<br>
                    <i class="bi bi-envelope-arrow-up"> </i>&nbsp; : webmaster@waterselangor.gov.my <br>
                    <i class="bi bi-globe"> </i>&nbsp; : http://water.selangor.gov.my
                </div>
                <div class="col-md-2 pl-0">
                    <img src="{{ asset('assets/images/admin-images/logo-jps-(tran)(wordwhite).png') }}"
                        class="img-fluid img2 float-left" alt="...">
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
                    <img src="{{ asset('assets/images/admin-images/logo-kita-selangor.png') }}" class="img-fluid img3"
                        alt="..." width="60%">
                </div>
                <!--<div class="col-3">-->
                <!--</div>-->
                <div class="col-md-2 ruj text-left">
                    <!--<p class="mb-0">Ruj. Tuan</p>-->
                    <p class="mb-0">Ruj. Kami</p>
                    <p>Tarikh</p>
                </div>
                <div class="col-md-2 text-left p-0">
                    <p class="mb-0" style="white-space: nowrap;">: {{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
                    <!--<p class="mb-0">: Bil</p>-->
                    <p class="mb-0">:
                        {{ $application->created_at ? $application->created_at->format('d M Y') : '10 hb September 2024' }}
                    </p>
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
                    <p class="mb-0">Tetuan {{ ucwords(strtolower($application->applicant)) }}</p>
                    <p class="mb-0">{{ ucwords(strtolower(str_replace(',', ', ', $application->address))) }}</p>
                   <p class="mb-0">{{ ucwords(strtolower($application->city)) }}, {{ $application->postal_code }}, {{ ucwords(strtolower($application->daerah ?? 'N/A')) }}</p>
                    <p class="mb-0">{{ ucwords(strtolower($application->negeri ?? 'N/A')) }} Darul Ehsan</p>
                    <br>
                    <p class="">Tuan,</p>
                    <h6 class="mb-0 text-justify"><b>PENGESAHAN BAYARAN CARUMAN PARIT DI ATAS {{strtoupper($application->land_lot)}},{{ strtoupper($application->land_mukim ?? 'N/A') }}, DAERAH {{ strtoupper($application->land_daerah ?? 'N/A') }}, NEGERI SELANGOR UNTUK TETUAN {{strtoupper($application->applicant)}}.</b></h6>
                    <p class="pengesahan"><strong>-Pengesahan Bayaran Caruman Parit</strong></p>
                    <p>Dengan segala hormatnya saya diarahkan merujuk kepada perkara tersebut di atas.</p>
                    <p style="text-align:justify;">
                        2. Berdasarkan geran tanah yang dilampirkan, keluasan tanah yang perlu di bayar ialah
                        <b>{{ number_format($application->hectare, 2) }} hektar</b>. Oleh yang demikian pihak tuan adalah
                        dikehendaki membayar caruman parit ke jabatan ini <b>berjumlah RM {{ number_format($application->final_amount, 2) }}
                            (RM {{ number_format($application->cost, 2) }} x {{ number_format($application->hectare, 2) }} hektar).
                    </p>
                    <p>Sekian, terima kasih.</p>
                    <p class="mb-0"><b>"#KITASELANGOR MAJU BERSAMA"</b></p>
                    <p class="mb-0"><b>"MALAYSA MADANI"</b></p>
                    <p><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                    <p>Saya yang menjalankan amanah,</p>
                    <!--<p class="mb-0"><b>Ir Zurraidy Bin Jalal</b></p>-->
                    <!--<p class="mb-0"><b>Penolong Pengarah Kanan,</b></p>-->
                    <!--<p class="mb-0"><b>Bahagian Saliran Mesra Alam dan Caruman Parit</b></p>-->
                    <p class="mb-4" ><b><!--b.p!--> Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                    <!--<p><b>Selangor</b></p>-->
                    <!--<p class="ml-5">This is print computer and no necessary signed</p>-->
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row last_row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <p class="last_para" style="color: gray;">@lang('app.computer_printout')</p>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row last_row">
                <div class="col-md-6"></div>
                <div class="col-6 float-right mt-5 col6 float-right">
                    <button type="button" class="btn btn-primary float-right" id="rejectButton"
                        data-id="{{ $application->id ?? '' }}"
                        style="background:#C4C8D1; border-color:#C4C8D1;">@lang('app.reject')</button>&nbsp;&nbsp;&nbsp;
                    <!--<button type="button" class="btn btn-primary float-right" id="approveButton"-->
                    <!--    data-id="{{ $application->id ?? '' }}">@lang('app.passed')</button>-->
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('approveButton').addEventListener('click', function() {
            let applicationId = this.getAttribute('data-id');

            fetch('/application/' + applicationId + '/approve', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 2,
                        applicationId: applicationId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Approved', 'Application has been approved.', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Something went wrong.', 'error');
                });
        });



        document.getElementById('rejectButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent any default form submission behavior
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '@lang('app.reason_for_rejection')',
                text: '@lang('app.specific_reason:_document_not_complete')',
                icon: 'warning',
                html: `
            <label for="rejectionReason" style="display: block; text-align: center; font-weight: bold;">
                @lang('app.reason_for_rejection')
            </label>
            <textarea id="rejectionReason" class="swal2-textarea" style="width: 85%;" placeholder="@lang('app.enter_reason_for_rejection')"></textarea>
        `,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '@lang('app.yes_reject')',
                cancelButtonText: '@lang('app.cancel')',
                preConfirm: () => {
                    const reason = document.getElementById('rejectionReason').value.trim();
                    if (!reason) {
                        Swal.showValidationMessage('@lang('app.please_provide_rejection_reason')');
                        return false;
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const rejectionReason = result.value;
                    console.log("Rejection Reason:", rejectionReason); // Log the reason for debugging

                    fetch('/application/' + id + '/reject', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json', // Ensure the server returns JSON
                            },
                            body: JSON.stringify({
                                reason: rejectionReason
                            })
                        })
                        .then(response => {
                            console.log('Response Status:', response
                                .status); // Log status for debugging
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response Data:', data); // Log the response data
                            if (data.success) {
                                Swal.fire('@lang('app.application_rejected')', '@lang('app.application_rejected_successfully')', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message || 'Failed to reject application.',
                                    'error');
                            }
                        })
                        .catch(error => {
                            console.error('Fetch Error:', error); // Log detailed error
                            Swal.fire('Error', 'Something went wrong: ' + error.message, 'error');
                        });
                }
            });
        });
    </script>
@endsection
