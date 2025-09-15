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
        justify-content: flex-start;
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
        background: #E85B6C !important;
        border: 1px solid #E85B6C;
        border-radius: 25px;
    }

    .btn-sm {
        padding: 4px 8px;
        /* Ensure consistency with other small buttons */
        font-size: 0.75rem;
        line-height: 1;
        /* Reduce button height */

    }

    /* Adjust button gap for smaller buttons */
    .sbtn {
        gap: 0.25rem;
        /* Smaller spacing between buttons */
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
</style>
<title>@lang('app.contribution_history') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-history"></i> @lang('app.contribution_history')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Table Wrapper for Responsiveness -->
                        <div class="d-flex align-items-baseline mb-3 mx-3">
                                <label for="perPageSelect" class="me-2">@lang('app.show') : &nbsp;</label>
                                <select id="perPageSelect" class="form-select form-select-sm" style="width: auto">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                    <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                                </select>
                        </div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($applications as $index => $application)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $application->refference_no ?? '-' }}</td>
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
                                            <td>RM {{ number_format($application->final_amount, 2) }}</td>
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
                                            <td style="display: flex;flex-direction: column;align-items: center;">
                                                <div class="sbtn">
                                                    <a href="#" class="btn btn-primary btn-sm"
                                                        style="background-color: green !important;"><strong>{{ trans('app.paid') }}</strong></a>
                                                </div><br>
                                                 <div class="sbtn">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-primary btn-sm {{ $application->print_status_count > 0 ? 'reprint-receipt' : 'print-receipt' }}"
                                                        data-application-id="{{ $application->id }}"
                                                        style="background:#3c8dbc !important; border:solid 1px #3c8dbc; white-space: nowrap;">
                                                        <strong>{{ $application->print_status_count > 0 ? __('app.reprint_receipt') : __('app.print_receipt') }}</strong>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                {{ trans('app.no_contribution_history') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <span class="me-2">
                                            @lang('app.page') <strong>{{ $applications->currentPage() }}</strong> 
                                            @lang('app.of') <strong>{{ $applications->lastPage() }}</strong>
                                        </span>
                                    </div>
                                    
                                    <nav>
                                        <ul class="pagination">
                                            {{-- First Page --}}
                                            <li class="page-item {{ $applications->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" 
                                                href="{{ $applications->url(1) }}"
                                                title="@lang('app.first')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-double-left"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            
                                            {{-- Previous Page --}}
                                            <li class="page-item {{ $applications->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" 
                                                href="{{ $applications->previousPageUrl() }}"
                                                title="@lang('app.prev')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-left"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            
                                            {{-- Page Numbers --}}
                                            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
                                                <li class="page-item {{ $page == $applications->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">
                                                        {{ $page }}
                                                    </a>
                                                </li>
                                            @endforeach
                                            
                                            {{-- Next Page --}}
                                            <li class="page-item {{ !$applications->hasMorePages() ? 'disabled' : '' }}">
                                                <a class="page-link" 
                                                href="{{ $applications->nextPageUrl() }}"
                                                title="@lang('app.next')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-right"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            
                                            {{-- Last Page --}}
                                            <li class="page-item {{ !$applications->hasMorePages() ? 'disabled' : '' }}">
                                                <a class="page-link" 
                                                href="{{ $applications->url($applications->lastPage()) }}"
                                                title="@lang('app.last')">
                                                    <span class="d-inline-flex align-items-center justify-content-center">
                                                        <i class="fas fa-angle-double-right"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <p>{{ trans('app.note') }} : {{ trans('app.receipt_reprints_charge') }} RM 10.00</p>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize buttons based on session storage
        document.querySelectorAll('[data-application-id]').forEach(button => {
            const appId = button.getAttribute('data-application-id');
            if (sessionStorage.getItem(`printed_${appId}`)) {
                button.classList.remove('print-receipt');
                button.classList.add('reprint-receipt');
                button.querySelector('strong').textContent = '@lang("app.reprint_receipt")';
            }
        });

        // Handle reprint receipt clicks
            document.querySelectorAll('.reprint-receipt').forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-application-id');

            Swal.fire({
                title: '@lang('app.Are_you_sure_you_want_to_reprint')',
                text: '@lang('app.Note_:_Receipt_reprints_are_subject_to_a_charge_RM_10.00')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang("app.yes")',
                cancelButtonText: '@lang("app.no")'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to payment selection page for reprint payment
                    window.location.href = '{{ route('payment.selection', '__ID__') }}'.replace('__ID__', applicationId) + '?type=reprint';
                }
            });
        });
    });

        // Handle print receipt clicks
        document.querySelectorAll('.print-receipt').forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-application-id');
                
                // Update button state
                button.classList.remove('print-receipt');
                button.classList.add('reprint-receipt');
                button.querySelector('strong').textContent = '@lang("app.reprint_receipt")';
                sessionStorage.setItem(`printed_${applicationId}`, 'true');

                // Update print status
                fetch('{{ route('update.print.status', '__ID__') }}'.replace('__ID__', applicationId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            // Revert if failed
                            button.classList.add('print-receipt');
                            button.classList.remove('reprint-receipt');
                            button.querySelector('strong').textContent = '@lang("app.print_receipt")';
                            sessionStorage.removeItem(`printed_${applicationId}`);
                        }
                        // Redirect with print parameter (original)
                        window.location.href = '{{ route('user_copy_receipt', '__ID__') }}'
                            .replace('__ID__', applicationId) + '?type=original&t=' + Date.now();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Revert on error
                        button.classList.add('print-receipt');
                        button.classList.remove('reprint-receipt');
                        button.querySelector('strong').textContent = '@lang("app.print_receipt")';
                        sessionStorage.removeItem(`printed_${applicationId}`);
                    });
            });
        });
    });
</script>
<script>
    document.getElementById('perPageSelect').addEventListener('change', function() {
        const perPage = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });
    </script>
@endsection
