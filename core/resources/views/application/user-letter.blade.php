@extends('app')
@section('title')
    @lang('app.trench_contribution_bill') | {{ get_company_name() }}
@endsection
@section('content')
    <div class="col-md-12 content-header no-print">
        <h5><i class="fa fa-list"></i> @lang('app.trench_contribution_bill')</h5>
    </div>

    <section class="content">
       <div class="row mt-3 head-row font-print">
            <div class="col-md-12 text-center font-print">
                <img src="{{ asset('assets/images/letterhead.jpg') }}" 
                    class="img-fluid" 
                    alt="JPS Header" 
                    style="width: 100%; max-width: 100%;">
            </div>
        </div>
        <div class="container middle-body font-print">
            <div class="row mt-3 font-print">
                <div class="col-md-1 font-print"></div>
                <div class="col-md-4 font-print">
                    <img src="{{ asset('assets/images/admin-images/new-title.png') }}" class="img-fluid img3"
                        alt="Kita Selangor Logo" style="width: 200px;">
                </div>
                <div class="col-md-4 ruj text-left font-print">
                    <p class="mb-0 font-print" style="white-space: nowrap;">Ruj. Kami</p>
                    <p class="font-print">Tarikh</p>
                </div>
                <div class="col-md-3 text-left p-0 font-print">
                    <p class="mb-0 font-print" style="white-space: nowrap;">: {{ $application->refference_no ?? 'SF/CV/1891/24' }}</p>
                    <!--<p class="mb-0" style="white-space: nowrap;">: {{ $application->created_at ? $application->created_at->format('d M Y') : '10 hb September 2024' }}</p>-->
                    <p class="mb-0" style="white-space: nowrap;">
                        : {{ $application->status === 'approved' ? App\Helpers\DateHelper::formatMalayDate($application->updated_at) : '-' }}
                    </p>
                </div>
                <div class="col-md-2 font-print"></div>
            </div>
            <div class="row font-print">
                <div class="col-md-1 font-print"></div>
                <div class="col-md-10 font-print">
                    <p class="mb-0 font-print">{{ $application->applicant }}</p>
                    <div class="row font-print">
                        <div class="col-6 font-print">
                            <p class="mb-0 address-wrap font-print">
                                {{ $application->address }}
                            </p>
                        </div>
                    </div>

                    <p class="mb-0 font-print">{{ ucwords(strtolower($application->city)) }}, {{ $application->postal_code }}, {{ ucwords(strtolower($application->daerah ?? 'N/A')) }}</p>
                    <p class="mb-0 font-print">{{ ucwords(strtolower($application->negeri ?? 'N/A')) }}</p>

                    <br>
                    <p class="font-print">Tuan,</p>
                    <h6 class="mb-0 text-justify font-print">
                        <b>{{ strtoupper($application->project_name ?? 'N/A') }}</b>
                    </h6>
                    <p class="pengesahan font-print"><strong>-Pengesahan Bayaran Caruman Parit</strong></p>
                    <p class="font-print">Dengan segala hormatnya saya diarahkan merujuk kepada perkara tersebut di atas.</p>
                    <p class="font-print" style="text-align:justify;">
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
                    <p class="font-print">Sekian, terima kasih.</p>
                    <p class="mb-0 font-print"><b>"KITASELANGOR MAJU BERSAMA"</b></p>
                    <p class="mb-0 font-print"><b>"MALAYSA MADANI"</b></p>
                    <p class="font-print"><b>"BERKHIDMAT UNTUK NEGARA"</b></p>
                    <p class="font-print">Saya yang menjalankan amanah,</p>
                    <p class="mb-2 font-print"><b>Pengarah Pengairan dan Saliran Negeri Selangor</b></p>
                </div>
                <div class="col-md-1 font-print"></div>
            </div>
            <div class="row last_row align-items-center mt-3 font-print">
                <div class="col-md-6 font-print">
                </div>
            </div>
             <p class="last_para  mb-0 font-print" >@lang('app.computer_printout')</p>
            <div class="col-md-12 mt-3  text-right no-print display-flex jsutify-content-end font-print">
                    <button type="button" class="btn btn-success mx-2" onclick="window.location.href='{{ url()->previous() }}'">
                        @lang('app.back')
                    </button>
                    <button type="button" class="btn btn-secondary mr-2" onclick="window.print()">
                        <i class="bi bi-printer"></i> @lang('app.print')
                    </button>
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
                    window.location.href = '{{ route('application_status') }}';
                }
            });
        }
        document.getElementById('successButton').addEventListener('click', showConfirmationPopup);
    </script>
@endsection