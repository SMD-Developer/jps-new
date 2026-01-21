@extends('clientarea.app')
@section('title')
    @lang('app.trench_contribution_bill') | {{ get_company_name() }}
@endsection
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content trench-contribution-bill">
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
            <p class="last_para mb-0">@lang('app.computer_printout')</p>
            <div class="col-md-12 mt-3 text-right no-print display-flex jsutify-content-end">
                <button type="button" class="btn btn-success mx-2" onclick="window.location.href='{{ url()->previous() }}'">
                    @lang('app.back')
                </button>
                <button type="button" class="btn btn-secondary mr-2" onclick="window.print()">
                    <i class="bi bi-printer"></i> @lang('app.print')
                </button>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('approveButton').addEventListener('click', function() {
            const approveButton = this;
            let applicationId = this.getAttribute('data-id');
    
            Swal.fire({
                title: 'Confirm Approval',
                text: 'Are you sure you want to approve this application?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleButtonState(approveButton, true);
    
                    fetch('/application/' + applicationId + '/approve', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 2,
                            applicationId: applicationId
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

    <script>
        function showConfirmationPopup() {
            Swal.fire({
                title: '@lang('app.are_you_sure')',
                text: '@lang('app.this_action_cannot_be_undone')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('app.yes')',
                cancelButtonText: '@lang('app.cancel')',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, show the success message
                    showSuccessMessage();
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
                    // Redirect to the desired URL
                    window.location.href = '{{ route('application_list') }}';
                }
            });
        }

        // Attach the confirmation popup to a button
        document.getElementById('successButton').addEventListener('click', showConfirmationPopup);
    </script>
@endsection
