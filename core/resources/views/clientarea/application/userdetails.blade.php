@extends('clientarea.app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* General Styles */
    body {
        font-family: sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }

    /* Container */
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px;
        /*background: #fff;*/
        border-radius: 10px;
        /*box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);*/
        /*border: 1px solid #ddd;*/
    }

    /* Headings */
    h2,
    h3,
    h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Form Layout */
    .form-group {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .form-group label {
        width: 220px;
        font-weight: 600;
        margin-right: 15px;
        font-size: 13px;
        color: #555;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 13px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        transition: border 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
    }

    input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* File Upload */
    .form-group input[type="file"] {
        padding: 5px;
        border-radius: 5px;
    }

    /* Section */
    .section {
        margin-bottom: 40px;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-secondary {
        background: #f1f1f1;
        color: #333;
        border: 1px solid #ccc;
    }

    .btn-primary {
        background: #007bff;
        color: #fff;
    }

    .btn-secondary:hover,
    .btn-primary:hover {
        opacity: 0.9;
    }

    /* File Upload Section */
    .note {
        font-size: 14px;
        color: #d9534f;
        margin-top: 10px;
        text-align: end;
    }

    .content {
        background: #F4F6F9;
    }

    .btn1,
    .btn2,
    .btn3 {
        border-radius: 20px !important;
        padding: 7px 25px !important;
    }

    .small-input {
        border-radius: 1px !important;
        border: 2px solid black !important;
        padding: 4px 0 !important;
    }

    div#swal2-html-container {
        overflow-x: hidden;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@lang('app.new_application') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-file-text"></i> @lang('app.new_application')</h5>
    </div>


    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!--<h2>@lang('Permohonan Baru')</h2>-->

                    <!-- Personal Information Section -->
                    <div class="section">
                        <h4>@lang('app.applicant_Information')</h4>
                        <form>
                            <div class="form-group">
                                <label for="refference_no">@lang('app.no_application_ref')</label>
                                <input id="refference_no" class="form-control"
                                    value="{{ $application->refference_no ?? '' }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tarikh">@lang('app.date')</label>
                                <input id="tarikh" class="form-control" value="{{ $application->uploade_date }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="pemohon">@lang('app.applicant') @lang('app.individual') / @lang('app.company')</label>
                                <input type="text" id="pemohon" class="form-control"
                                    value="{{ $application->applicant }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="ssm">@lang('app.identification_card_no')</label>
                                <input type="text" id="ssm" class="form-control"
                                    value="{{ $application->identities }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="alamat">@lang('app.applicant_address')</label>
                                <textarea id="alamat" class="form-control" rows="4" readonly>{{ $application->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="poskod">@lang('app.postal_code')</label>
                                <input type="text" id="poskod" class="form-control"
                                    value="{{ $application->postal_code }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="bandar">@lang('app.city')</label>
                                <input type="text" id="bandar" class="form-control" value="{{ $application->city }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="daerah">@lang('app.district')</label>
                                <input type="text" id="daerah" class="form-control" value="{{ $district }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="negeri">@lang('app.state')</label>
                                <input type="text" id="negeri" class="form-control" value="{{ $state }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="emel">@lang('app.email_address')</label>
                                <input type="email" id="emel" class="form-control" value="{{ $application->email }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="telefon">@lang('app.telephone_no')</label>
                                <input type="tel" id="telefon" class="form-control" value="{{ $application->phone }}"
                                    readonly>
                            </div>
                        </form>
                    </div>

                    <!-- Lot Information Section -->
                    <div class="section">
                        <h4>@lang('app.lot_information')</h4>
                        <form>
                            <div class="form-group">
                                <label for="lot-tanah">@lang('app.land_lot')</label>
                                <input type="text" id="lot-tanah" class="form-control"
                                    value="{{ $application->land_lot }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="keluasan">@lang('app.land_area')</label>
                                <input type="text" id="keluasan" class="form-control"
                                    value="{{ $application->land_area }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="daerah">@lang('app.district')</label>
                                <input type="text" id="daerah" class="form-control" value="{{ $landDistrict }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="mukim">@lang('Mukim')</label>
                                <input type="text" id="mukim" class="form-control" value="{{ $mukimDisplay }}" readonly>
                            </div>
                        </form>
                    </div>

                    <!-- File Upload Section -->
                    <div class="section">
                        <h4>@lang('app.upload_supporting_documents')</h4>
                        <form>
                            <div class="form-group">
                                <label for="geran-tanah">@lang('app.land_grant') <b class="starr">*</b></label>
                                @if ($application->land_grant)
                                    <a href="{{ url('core/public/pdf/' . basename($application->land_grant)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($application->land_grant) }}
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="pelan">@lang('app.planning_permission_plan')</label>
                                @if ($application->permission_plan)
                                    <a href="{{ url('core/public/pdf/' . basename($application->permission_plan)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($application->permission_plan) }}
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="sokongan">@lang('app.letter_of_support')</label>
                                @if ($application->letter_of_support)
                                    <a href="{{ url('core/public/pdf/' . basename($application->letter_of_support)) }}"
                                        target="_blank"><i class="fa fa-file-pdf-o"></i>
                                        {{ basename($application->letter_of_support) }}
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>

                            <p class="note">
                                * @lang('app.file_only_pdf_format_size_not_exceed_15mb')
                            </p>
                        </form>
                    </div>


                    <!-- Submit Section -->
                    <!--<div class="form-actions">-->
                    <!--    {{-- <button type="submit" class="btn btn-secondary btn1" id="rejectButton"-->
                    <!--        data-id="{{ $application->id }}">@lang('app.reject')</button> --}}-->
                    <!--    <button type="submit" class="btn btn-primary btn2" id="approveButton"-->
                    <!--        data-id="{{ $application->id }}">-->
                    <!--        @lang('app.next')-->
                    <!--    </button>-->
                    <!--</div>-->

                </div>
            </div>
        </div>
    </section>
    <script>
        // Get today's date
        const today = new Date();

        // Format the date as dd/mm/yy
        const formattedDate = [
            String(today.getDate()).padStart(2, '0'), // Day with leading zero
            String(today.getMonth() + 1).padStart(2, '0'), // Month with leading zero
            String(today.getFullYear()).slice(0) // Last two digits of the year
        ].join('/');

        // Set the placeholder for the date input
        document.getElementById('tarikh').placeholder = formattedDate;
    </script>
    <script>
        // document.getElementById('approveButton').addEventListener('click', function() {
        //     let applicationId = this.getAttribute('data-id');

        //     fetch('/application/' + applicationId + '/approve', {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                     'content'),
        //                 'Content-Type': 'application/json',
        //             },
        //             body: JSON.stringify({
        //                 action: 2,
        //                 applicationId: applicationId
        //             })
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 Swal.fire('Approved', 'Application has been approved.', 'success');
        //                 setTimeout(() => location.reload(), 1000);
        //             } else {
        //                 Swal.fire('Error', data.message, 'error');
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             Swal.fire('Error', 'Something went wrong.', 'error');
        //         });
        // });

        document.getElementById('approveButton').addEventListener('click', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get the application ID from the data attribute
            const applicationId = this.getAttribute('data-id');

            // Construct the URL for the update application route
            const updateUrl = "{{ route('approver_letter', ['application_id' => ':id']) }}".replace(':id',
                applicationId);

            // Navigate to the update application page
            window.location.href = updateUrl;
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
