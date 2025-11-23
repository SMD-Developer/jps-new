<!--@extends('app')-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    .last_para{
        padding-left: 162px;
    }
  
    .sweet-alert-text {
        font-size: 1.1rem !important;  /* Slightly larger than default */
        line-height: 1.4;
    }
    
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
                        alt="..." width="60%">
                </div>
                <!--<div class="col-3">-->
                <!--</div>-->
                <div class="col-md-4 ruj text-left">
                    <!--<p class="mb-0">Ruj. Tuan</p>-->
                    <p class="mb-0" style="white-space:nowrap;">Ruj. Kami</p>
                    <p>Tarikh</p>
                </div>
                <div class="col-md-3 text-left p-0">
                    <!--<p class="mb-0">: </p>-->
                    <p class="mb-0" style="white-space: nowrap;">: {{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
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
                    {{-- <p class="mb-0">{{$application->district->name}}, {{$application->state->name}}.</p> --}}
                    {{-- <p class="mb-0">Selangor Darul Ehsan.</p> --}}
                    <br>
                    <p class="">Tuan,</p>
                    <h6 class="mb-0 text-justify">
                        <b>{{ strtoupper($application->project_name ?? 'N/A') }} </b>
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
                    <p class="mb-2"><b><!--b.p!--> Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                </div>
                <div class="col-md-2"></div>
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <!-- LEFT column (text) -->
                </div>
            </div>

            <p class="last_para mb-0">
                        @lang('app.computer_printout')
            </p>
           <div class="row last_row align-items-center mt-5" style="justify-content: end;">
                <div class="col-12 col-md-6 d-flex justify-content-md-end mt-3 mt-md-0">
                    <button 
                        type="button" 
                        class="btn btn-success mx-2 no-print" 
                        onclick="window.history.back()"
                    >
                        @lang('app.back')
                    </button>

                    @if($application->status == 'approved')
                       <button type="button" class="btn btn-secondary btn3 no-print" onclick="window.print()">
                            @lang('app.print')
                        </button>
                    @else
                        {{-- Show Approve/Reject buttons if not approved --}}
                        <button type="submit" class="btn btn-danger btn1 mx-3" id="rejectButton"
                            data-id="{{ $application->id }}" 
                            @if($application->status == 'rejected') disabled @endif>
                            @lang('app.reject')
                        </button>
                        <button type="submit" class="btn btn-primary btn2" id="approveButton"
                            data-id="{{ $application->id }}"
                            @if($application->status == 'rejected') disabled @endif>
                            @lang('app.passed')
                        </button>
                    @endif
                </div>
            </div>


        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


       <script>
        document.getElementById('approveButton').addEventListener('click', function() {
            const approveButton = this;
            let applicationId = this.getAttribute('data-id');
    
            Swal.fire({
                title: 'Sahkan Kelulusan',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                customClass: {
                    content: 'sweet-alert-text'  
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleButtonState(approveButton, true);
    
                    fetch('/application/' + applicationId + '/approve', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            sendNotificationToUser(applicationId, 'approval');
                        } else {
                            Swal.fire('Error', data.message || 'Approval failed', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Approval Error:', error);
                        Swal.fire('Error', 'Something went wrong during approval.', 'error');
                    })
                    .finally(() => {
                        handleButtonState(approveButton, false);
                    });
                }
            });
        });
    
        // Modified sendNotificationToUser to accept notification type
        function sendNotificationToUser(applicationId, notificationType) {
            fetch('{{ route('send-user-notification') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    application_id: applicationId,
                    notification_type: notificationType
                }),
            })
            .then(response => {
                console.log('Notification response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Notification response data:', data);
                
                const successTitle = notificationType === 'approval' ? 'Lulus' : 'Tolak';
                const successText = notificationType === 'approval' 
                    ? 'Permohonan diluluskan dan bil dihantar kepada pemohon.' 
                    : 'Permohonan telah berjaya ditolak.';
    
                Swal.fire({
                    title: successTitle,
                    text: successText,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('approved_application_list') }}";
                });
            })
            .catch(error => {
                console.error('Notification Error:', error);
                const successTitle = notificationType === 'approval' ? 'Approved' : 'Rejected';
                const successText = notificationType === 'approval' 
                    ? 'Application has been approved successfully.' 
                    : 'Application has been rejected successfully.';
    
                Swal.fire({
                    title: successTitle,
                    text: successText,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('application_status') }}";
                });
            });
        }
    
        document.getElementById('rejectButton').addEventListener('click', function(event) {
            event.preventDefault();
            const rejectButton = this;
            const id = this.getAttribute('data-id');
    
            Swal.fire({
                title: '@lang('app.reason_for_rejection')',
                text: '@lang('app.specific_reason:_document_not_complete')',
                icon: 'warning',
                html: `
                    <label for="rejectionReason" style="display: block; text-align: center; font-weight: bold;">
                        
                    </label>
                    <textarea id="rejectionReason" class="swal2-textarea" style="width: 85%;"></textarea>
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
                    handleButtonState(rejectButton, true);
    
                    fetch('/application/' + id + '/reject', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            reason: rejectionReason
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            sendNotificationToUser(id, 'rejection');
                            window.location.href = "{{ route('application_status') }}";
                        } else {
                            Swal.fire('Error', data.message || 'Failed to reject application.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Rejection Error:', error);
                        Swal.fire('Error', 'Something went wrong during rejection.', 'error');
                    })
                    .finally(() => {
                        handleButtonState(rejectButton, false);
                    });
                }
            });
        });
    
        function handleButtonState(button, disabled) {
            button.disabled = disabled;
            button.classList.toggle('disabled', disabled);
        }
    </script>

@endsection
