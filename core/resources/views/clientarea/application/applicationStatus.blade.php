@extends('clientarea.app')
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
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    /* Headings */
    h2,
    h3,
    h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Flex container for buttons */
    /* Flex container for buttons */
    .sbtn {
        display: flex;
        flex-wrap: wrap;
        /* Allow wrapping for smaller screens */
        /*justify-content: flex-start;*/
        justify-content: center;
        gap: 0.5rem;
        /* Uniform spacing */
    }

    /* Smaller, compact buttons */
    .sbtn a {
        flex: 0 1 auto;
        /* Prevents buttons from stretching too much */
        max-width: 150px;
        /* Restrict the button width */
        padding: 4px 8px;
        /* Reduce padding for a compact size */
        font-size: 0.75rem;
        /* Smaller font size */
        line-height: 1;
        /* Compact line height */
        background: #b9b9b9 !important;
        border: 1px solid #b9b9b9;
        border-radius: 25px;
    }

    .btn-sm {
        padding: 4px 8px;
        /* Ensure consistency with other small buttons */
        font-size: 0.75rem;
        line-height: 1;
        /* Reduce button height */

    }

    .sbtn {
        gap: 0.25rem;
    }


    /* Responsive design */
    @media (max-width: 768px) {
        .sbtn {
            justify-content: center;
            /* Center buttons on smaller screens */
        }

        .sbtn a {
            flex: 1 1 100%;
            /* Stack buttons on smaller screens */
            max-width: none;
        }
    }

    /* Adjust button appearance */
    .btn-sm {
        padding: 6px 10px !important;
        /* Smaller padding for compact design */
    }


    /* Adjust input and dropdown widths for responsiveness */
    .form-label {
        white-space: nowrap;
        /* Prevent labels from wrapping */
    }

    #lot #district #division {
        max-width: 180px;
        /* Restrict width for smaller inputs */
    }

    /* Responsive layout tweaks */
    @media (max-width: 768px) {
        .search-row>.col-sm-6 {
            margin-bottom: 1rem;
            /* Add spacing on smaller screens */
        }
    }

    #aside {
        display: flex;
        align-items: baseline;
    }

    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    /*border-radius: 15px !important;*/


    /* Add extra styling for badges if needed */
    .status-badge {
        display: inline-block;
        margin: 5px 0;
    }

    .status-badge .badge {
        font-size: 0.8rem;
        padding: 8px 15px;
        border-radius: 25px;
        background-color: #1991EE !important;
        color: #fff !important;
    }

    /* Add hover effects */
    .status-badge .badge:hover {
        opacity: 0.9;
        /* Slight transparency */
        cursor: pointer;
    }

    /* Style for the button */
    /* Scoped styles for .sbtnn */
    .sbtnn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .sbtnn a {
        flex: 0 1 auto;
        /* Prevents buttons from stretching too much */
        max-width: 150px;
        padding: 6px 12px;
        font-size: 0.85rem;
        line-height: 1.2;
        border-radius: 25px;
        border: 1px solid #E85B6C;
        background-color: #E85B6C;
        /* Initial background color */
        color: white;
        animation: blink 1s linear infinite;
        /* Adds blinking animation */
    }

    /* Keyframes for blinking effect */
    @keyframes blink {

        0%,
        100% {
            background-color: #E85B6C;
            /* Initial and end state color */
        }

        50% {
            background-color: #ff0000;
            /* Blinking color */
        }
    }
</style>
<title>@lang('app.application_status') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt nav-icon"></i> @lang('app.application_status')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.reference _no') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                        <th><strong>{{ trans('app.total_contribution') }}</strong></th>
                                        <th><strong>{{ trans('app.application_type') }}</strong></th>
                                        <th><strong>{{ trans('app.status') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($applications as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}</td>
                                            <!--<td>-->
                                            <!--    @if ($application->refference_no)-->
                                            <!--        <a href="{{ route('user.userDetails', ['id' => $application->id]) }}"-->
                                            <!--            class="text-primary">-->
                                            <!--            {{ $application->refference_no }}-->
                                            <!--        </a>-->
                                            <!--    @else-->
                                            <!--        --->
                                            <!--    @endif-->
                                            <!--</td>-->
                                            <td style="word-break: break-all;">
                                                @if ($application->refference_no && $application->status == 'approved')
                                                    <a href="{{ route('user.userDetails', ['id' => $application->id]) }}"
                                                        class="text-primary">
                                                        {{ $application->refference_no }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($application->client)
                                                    @php
                                                        $accountTypes = [
                                                            1 => 'Individu',
                                                            2 => 'Pemaju',
                                                            3 => 'Agensi Kerajaan',
                                                        ];
                                                    @endphp
                                                    {{ $accountTypes[$application->client->accountType] ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{ $application->applicant }}</td>
                                            <td>{{ $application->land_lot }}</td>
                                            <!--<td>{{ $application->client ? 'RM ' . number_format($application->final_amount, 2) : 'N/A' }}-->
                                            <!--</td>-->
                                            <td>
                                                @if ($application->client && $application->status == 'approved')
                                                    RM {{ number_format($application->final_amount, 2) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @switch($application->application_type)
                                                    @case('reapply')
                                                        {{ trans('app.reapply') }}
                                                    @break

                                                    @case('appeal')
                                                        Appeal
                                                    @break

                                                    @default
                                                        {{ trans('app.new') }}
                                                @endswitch
                                            </td>
                                            <td>
                                                @if ($application->status == 'approved')
                                                    <div class="status-badge">
                                                        <a href="{{ route('show_approval_letter', ['application_id' => $application->id]) }}"
                                                            class="badge bg-warning text-dark d-flex align-items-center text-decoration-none">
                                                            <i class="bi bi-hourglass-split me-2"></i>
                                                            {{ trans('app.approved') }}
                                                        </a>
                                                    </div>
                                                @elseif ($application->status == 'in_process')
                                                    <div class="status-badge">
                                                        <span class="badge bg-warning text-dark d-flex align-items-center">
                                                            <i class="bi bi-hourglass-split me-2"></i>
                                                            {{ trans('app.in_process') }}
                                                        </span>
                                                    </div>
                                                @elseif ($application->status == 'rejected')
                                                    <div class="sbtn">
                                                        <a href="{{ route('resubmit-application', ['id' => $application->id]) }}"
                                                            class="btn btn-danger btn-sm"
                                                            style="background-color: #ff0000 !important;">
                                                            <strong>{{ trans('app.rejected') }}</strong>
                                                        </a>
                                                    </div>
                                                    @if ($application->rejection_reason)
                                                        <p style="padding-top: 5px;">{{ trans('app.reason') }} :
                                                            {{ $application->rejection_reason }}</p>
                                                    @endif
                                                @else
                                                    <div class="status-badge">
                                                        <span class="badge bg-warning text-dark d-flex align-items-center">
                                                            <i class="bi bi-hourglass-split me-2"></i>
                                                            {{ trans('app.in_process') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>

                                            
                                            <td>
                                            @if ($application->status == 'approved')
                                                @if ($application->latestPayment && $application->latestPayment->payment_status === 'completed')
                                                    <span class="badge bg-success py-1 px-3 rounded-pill d-inline-block text-center" style="font-size: 0.7rem; line-height: 1.2; white-space: normal; width: 144px; word-break: break-word; hyphens: auto;">
                                                        {{ trans('app.payment_complete') }}
                                                    </span>
                                                        
                                                @elseif($application->latestPayment && $application->latestPayment->payment_status === 'pending_authorization')
                                                    <span class="badge bg-secondary py-1 px-3 rounded-pill d-inline-block text-center" style="font-size: 0.7rem; line-height: 1.2; white-space: normal; width: 144px; word-break: break-word; hyphens: auto;">
                                                        {{ trans('app.payment_pending') }}
                                                    </span>
                                        
                                                @elseif ($application->payment_status === 'in review' && $application->client && $application->client->accountType == 3)
                                                    <span class="badge bg-info py-1 px-3 rounded-pill d-inline-block text-center" style="font-size: 0.7rem; line-height: 1.2; white-space: normal; width: 144px; word-break: break-word; hyphens: auto;">
                                                        {{ trans('app.waiting_for_Review') }}
                                                    </span>
                                                    
                                                @elseif ($application->payment_status === 'rejected')
                                                    <div class="d-flex flex-column gap-1" style="max-width: 180px;">
                                                        <button class="btn btn-danger btn-xs py-1 px-3 rounded-pill"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectionReasonModal{{ $application->id }}"
                                                            style="font-size: 0.75rem;">
                                                            {{ trans('app.payment_rejected') }}
                                                        </button>
                                                        <a href="{{ $application->client && $application->client->accountType == 3
                                                            ? route('uploadDepositReceipt', ['application_id' => $application->id])
                                                            : route('user_payment_letter', ['application_id' => $application->id]) }}"
                                                            class="btn btn-primary btn-sm mt-2 py-1 px-3 rounded-pill"
                                                            style="font-size: 0.7rem; white-space: normal; line-height: 1.2; height: auto; min-height: 40px; display: flex; align-items: center; justify-content: center; text-align: center; word-break: break-word;">
                                                            {{ $application->client && $application->client->accountType == 3
                                                                ? trans('app.upload_deposit_receipt')
                                                                : trans('app.please_explain_payment') }}
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="sbtnn">
                                                        <a href="{{ $application->client && $application->client->accountType == 3
                                                            ? route('uploadDepositReceipt', ['application_id' => $application->id])
                                                            : route('user_payment_letter', ['application_id' => $application->id]) }}"
                                                            class="btn btn-primary btn-sm py-1 px-3 rounded-pill"
                                                            style="font-size: 0.7rem; white-space: normal; line-height: 1.2; height: auto; min-height: 40px; display: flex; align-items: center; justify-content: center; text-align: center; min-width: 120px; word-break: break-word;">
                                                            {{ $application->client && $application->client->accountType == 3
                                                                ? trans('app.upload_deposit_receipt')
                                                                : trans('app.please_explain_payment') }}
                                                        </a>
                                                    </div>
                                                @endif
                                            @elseif ($application->status == 'in_process')
                                                <span class="badge bg-secondary">In Process</span>
                                            @elseif ($application->status == 'rejected')
                                                @if ($application->rejected_by == 'admin_staff')
                                                    <div class="d-flex flex-column gap-2">
                                                        <a href="{{ route('resubmit-application', ['id' => $application->id]) }}"
                                                            class="btn btn-warning btn-sm py-0 px-2 rounded-pill text-white"
                                                            style="font-size: 0.8rem; font-weight: normal;white-space:nowrap;">
                                                            <strong>{{ trans('app.resbumit') }}</strong>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="d-flex flex-column gap-2">
                                                    </div>
                                                @endif
                                            @endif
                                        </td>

                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">{{ trans('app.no_applications_found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        @lang('app.page') <strong>{{ $applications->currentPage() }}</strong> @lang('app.of')
                                        <strong>{{ $applications->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        @if ($applications->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $applications->url(1) }}&per_page={{ $perPage }}">«
                                                    @lang('app.first')</a>
                                            </li>
                                        @endif

                                        @if ($applications->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ @lang('app.prev')</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $applications->previousPageUrl() }}&per_page={{ $perPage }}">‹
                                                    @lang('app.prev')</a>
                                            </li>
                                        @endif

                                        @foreach ($applications->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li class="page-item {{ $page == $applications->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link" href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($applications->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $applications->nextPageUrl() }}&per_page={{ $perPage }}">@lang('app.next')
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">@lang('app.next') ›</span>
                                            </li>
                                        @endif

                                        @if ($applications->currentPage() < $applications->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $applications->url($applications->lastPage()) }}&per_page={{ $perPage }}">@lang('app.last')
                                                    »</a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                            </div> <!-- End Table Responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modalTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="modal"]'));
                var modalList = modalTriggerList.map(function(modalTriggerEl) {
                    return new bootstrap.Modal(document.querySelector(modalTriggerEl.getAttribute(
                        'data-bs-target')));
                });

                modalTriggerList.forEach(function(modalTrigger) {
                    modalTrigger.addEventListener('click', function() {
                        var targetModal = document.querySelector(this.getAttribute('data-bs-target'));
                        var bsModal = bootstrap.Modal.getInstance(targetModal) || new bootstrap.Modal(
                            targetModal);
                        bsModal.show();
                    });
                });
            });
        </script>
        <script>
            function changePerPage() {
                let perPage = document.getElementById('perPageSelect').value;
                let url = new URL(window.location.href);

                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', 1);

                window.location.href = url.toString();
            }
        </script>
    @endsection
