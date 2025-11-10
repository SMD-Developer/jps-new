@extends('clientarea.app')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Flex container for buttons */
    .sbtn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
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

    /* Activity column styles */
    .activity-info {
        font-size: 11px;
        line-height: 1.2;
    }

    .activity-label {
        font-weight: bold;
        margin-bottom: 2px;
    }

    .activity-user {
        color: #666;
        margin-bottom: 1px;
    }

    .activity-date {
        color: #999;
        font-size: 10px;
    }

    .current-user {
        color: #28a745 !important;
        font-weight: bold;
    }

    /* Enhanced button styles */
    .btn-viewed {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        position: relative;
    }

    .btn-edited {
        background-color: #fd7e14 !important;
        border-color: #fd7e14 !important;
        position: relative;
    }

    .btn-viewed::after {
        content: "✓";
        position: absolute;
        top: -2px;
        right: -2px;
        background: #fff;
        color: #28a745;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .btn-edited::after {
        content: "✎";
        position: absolute;
        top: -2px;
        right: -2px;
        background: #fff;
        color: #fd7e14;
        border-radius: 50%;
        width: 14px;
        height: 14px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .activity-badge {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
        margin-right: 5px;
    }

    .viewed-badge {
        background-color: #d4edda;
        color: #155724;
    }

    .edited-badge {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;      
        font-weight: 600;
        padding: 0.35rem 0.8rem; 
        border-radius: 12px;     
        white-space: nowrap;     
    }

    .btn-reapply {
        display: inline-block;
        background-color: #ffc107; 
        color: #fff;
        padding: 8px 18px;
        border-radius: 50px; 
        font-weight: 600;
        text-decoration: none;
        font-size: 12px;
        white-space: nowrap;
        transition: background-color 0.3s ease;
    }

    .btn-reapply:hover {
        background-color: #0056b3; /* Darker blue on hover */
        color: #fff;
        text-decoration: none;
    }

    .btn-reapply i {
        margin-right: 5px;
    }


</style>
<title>{{ trans('app.claim_contribution_list_user') }} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('app.claim_contribution_list_user') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Filter Section -->
                <div class="card mb-3">
                    <div class="card-body">

                        <!-- Table Section -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.application_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_name') }}</strong></th>
                                        <th><strong>{{ trans('app.lot_pt') }}</strong></th>
                                        <!--<th><strong>Activity</strong></th>-->
                                        <th><strong>{{ trans('app.status') }}</strong></th>
                                        <th><strong>{{trans('app.total_payment')}}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td>{{ ($list->currentPage() - 1) * $list->perPage() + $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->uploade_date)) }}</td>
                                            <td>
                                                    {{ $item->client 
                                                        ? ($item->client->accountType == 1 ? 'Individu' 
                                                        : ($item->client->accountType == 2 ? 'Pemaju' 
                                                        : ($item->client->accountType == 3 ? 'Agensi Kerajaan' 
                                                        : ($item->client->accountType == 4 ? 'Perunding' : 'Unknown')))) 
                                                        : ''  
                                                    }}
                                            </td>

                                            <td>
                                                @switch($item->application_type)
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
                                            <td>{{ $item->applicant }}</td>
                                            <td>{{ $item->land_lot }}, {{ $item->land_area }},
                                                {{ $item->landDivision->mukim ?? '' }}, Daerah
                                                {{ $item->landDistrict->daerah ?? '' }}
                                            </td>
                                          
                                            <td>
                                                @if($item->status)
                                                    @switch($item->status)
                                                        @case('pending')
                                                            <div class="status-badge">
                                                                <span class="badge bg-primary text-dark d-flex align-items-center justify-content-center">
                                                                    <i class="bi bi-hourglass-split me-2"></i>
                                                                    {{ trans('app.in_process') }}
                                                                </span>
                                                            </div>
                                                        @break
                                                        @case('complete')
                                                            {{ trans('app.complete') }}
                                                        @break
                                                        @case('rejected')
                                                        <div class="status-badge">
                                                                <span class="badge bg-danger text-dark d-flex align-items-center justify-content-center">
                                                                    <i class="bi bi-hourglass-split me-2"></i>
                                                                    {{trans('app.rejected')}}
                                                                </span>
                                                            </div>

                                                            {{-- ✅ Show reason below --}}
                                                            @if(!empty($item->rejected_reason))
                                                                <p style="padding-top: 5px; font-size: 12px; color: #dc3545; font-weight: 500;">
                                                                    {{ trans('app.reason') }}: {{ $item->rejected_reason }}
                                                                </p>
                                                            @endif
                                                        
                                                        @break
                                                        @case('approve_payment_in_process')
                                                            <div class="status-badge">
                                                                <span class="badge bg-success text-dark d-flex align-items-center justify-content-center">
                                                                    <i class="bi bi-hourglass-split me-2"></i>
                                                                    {{trans('app.approve_payment_in_process')}}
                                                                </span>
                                                            </div>
                                                        @break
                                                        @case('approve_paid')
                                                        <div class="status-badge">
                                                                <span class="badge bg-info text-dark d-flex align-items-center justify-content-center">
                                                                    <i class="bi bi-hourglass-split me-2"></i>
                                                                    {{trans('app.approve_paid')}}
                                                                </span>
                                                            </div>
                                                        @break
                                                    @endswitch
                                                @else
                                                    {{ trans('app.no_status') }}
                                                @endif
                                            </td>
                                            <td>{{$item->payment_amount}}</td>
                                            <td>
                                                @if ($item->status == 'rejected')
                                                    <a href="{{ route('claim.application.reapply', $item->id) }}" class="btn-reapply">
                                                        Mohon semula
                                                    </a>

                                                @elseif ($item->status == 'approve_paid')
                                                {{-- ✅ Show verification date & payment remarks when approved and paid --}}
                                                @if(!empty($item->verified_date) || !empty($item->payment_remarks))
                                                    <div class="mb-1">
                                                        @if(!empty($item->verified_date))
                                                            <small class="text-muted">
                                                                <strong>Tarikh Pembayaran:</strong>
                                                                {{ \Carbon\Carbon::parse($item->verified_date)->format('d/m/Y') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                    @if(!empty($item->payment_remarks))
                                                        <div>
                                                            <small class="text-muted">
                                                                <strong>Catatan :</strong>
                                                                <strong>{{ $item->payment_remarks }}</strong>
                                                            </small>
                                                        </div>
                                                    @endif
                                                @else
                                                    <small class="text-muted">Tiada maklumat pembayaran.</small>
                                                @endif
                                                @elseif ($item->send_to_finance == 1 && $item->status != 'approve_paid')
                                                    @if(!empty($item->visit_date) || !empty($item->process_remarks))
                                                        {{-- ✅ Show visit date and remarks if available --}}
                                                        <div class="mb-1">
                                                            @if(!empty($item->visit_date))
                                                                <small class="text-muted">
                                                                    <strong>Tarikh Lawatan:</strong>
                                                                    {{ \Carbon\Carbon::parse($item->visit_date)->format('d/m/Y') }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                        @if(!empty($item->process_remarks))
                                                            <div>
                                                                <small class="text-muted">
                                                                    <strong>Catatan:</strong> <strong>{{ $item->process_remarks }}</strong>
                                                                </small>
                                                            </div>

                                                        @endif
                                                    @else
                                                        {{-- ❌ If no visit_date or remarks, show the original finance message --}}
                                                        @if(!empty($item->sent_to_finance_at))
                                                            <div class="mb-1">
                                                                <small class="text-muted">
                                                                    Tarikh Kelulusan pada: 
                                                                    <strong>{{ \Carbon\Carbon::parse($item->sent_to_finance_at)->format('d/m/Y') }}</strong>
                                                                </small>
                                                            </div>
                                                        @endif
                                                        <small>
                                                            Sila hadir ke <strong>Jabatan Pengairan dan Saliran Negeri Selangor, Bahagian Kewangan</strong> dalam masa 7 hari bekerja.
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#readMoreModal" class="text-primary">Baca Selanjutnya</a>
                                                        </small>
                                                    @endif
                                                @endif
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        @lang('app.page') <strong>{{ $list->currentPage() }}</strong> @lang('app.of')
                                        <strong>{{ $list->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        @if ($list->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->url(1) }}&per_page={{ $perPage }}">«
                                                    @lang('app.first')</a>
                                            </li>
                                        @endif

                                        @if ($list->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ @lang('app.prev')</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->previousPageUrl() }}&per_page={{ $perPage }}">‹
                                                    @lang('app.prev')</a>
                                            </li>
                                        @endif

                                        @foreach ($list->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled"><span
                                                        class="page-link">{{ $element }}</span></li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li
                                                        class="page-item {{ $page == $list->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($list->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->nextPageUrl() }}&per_page={{ $perPage }}">@lang('app.next')
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">@lang('app.next') ›</span>
                                            </li>
                                        @endif

                                        @if ($list->currentPage() < $list->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $list->url($list->lastPage()) }}&per_page={{ $perPage }}">@lang('app.last')
                                                    »</a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div> <!-- End Table Responsive -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Read More Modal -->
        <div class="modal fade" id="readMoreModal" tabindex="-1" aria-labelledby="readMoreModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="readMoreModalLabel">Maklumat Lanjut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p class="mb-3">
                            Sila hadir ke <strong>Kaunter Pembayaran Caruman Parit, Jabatan Pengairan dan Saliran Negeri Selangor</strong>
                            dalam masa <strong>7 hari bekerja</strong> dari tarikh Kelulusan Permohonan Tuntutan Pemulangan Bayaran Balik
                            pada waktu operasi kaunter seperti berikut:
                        </p>

                        <div class="ms-3">
                            <h6 class="fw-bold text-decoration-underline">KAUNTER CARUMAN PARIT</h6>

                            <p class="mb-1"><strong>Hari Isnin – Khamis:</strong></p>
                            <ul class="mb-2">
                                <li>8.30 pagi – 12.30 tengahari</li>
                                <li>2.30 petang – 3.30 petang</li>
                            </ul>

                            <p class="mb-1"><strong>Hari Jumaat:</strong></p>
                            <ul class="mb-2">
                                <li>8.30 pagi – 12.00 tengahari</li>
                                <li>2.45 petang – 3.30 petang</li>
                            </ul>

                            <p class="mb-1"><strong>Rehat:</strong></p>
                            <ul>
                                <li>12.30 tengahari – 2.30 petang (Isnin – Khamis)</li>
                                <li>12.00 tengahari – 2.45 petang (Jumaat)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS Bundle (includes Popper) -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#district').on('change', function() {
                const distId = $(this).val();
                $('#division').html('<option value="">Loading...</option>');

                if (distId) {
                    $.ajax({
                        url: `/division/${distId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sila Pilih</option>';
                            data.forEach(mukin => {
                                options +=
                                    `<option value="${mukin.idmukim}">${ mukin.mukim_code +' - '+mukin.mukim}</option>`;
                            });
                            $('#division').html(options);
                        },
                        error: function() {
                            $('#division').html(
                                '<option value="">Error loading mukin</option>');
                        }
                    });
                } else {
                    $('#division').html('<option value="">Sila Pilih</option>');
                }
            });

        });
    </script>

    <script>
        if (performance.navigation.type === 1 && window.location.search) {
            console.log('Query string on refresh:', window.location.search);
            const cleanUrl = window.location.pathname;

            if (window.history && window.history.replaceState) {
                window.history.replaceState({}, document.title, cleanUrl);
            }
            console.log('Reloading with clean URL:', cleanUrl);
            window.location.href = cleanUrl;
        }

        function changePerPage() {
            let perPage = document.getElementById('perPageSelect').value;
            let url = new URL(window.location.href);
            url.searchParams.set('page', 1);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }

        $(document).ready(function() {
            if (performance.navigation.type === 1) {
                setTimeout(function() {
                    if ($('#district').length) {
                        $('#district').val('').prop('selectedIndex', 0);
                    }
                    if ($('#division').length) {
                        $('#division').empty().html(
                            '<option value="" selected disabled>{{ trans('app.select_division') }}</option>'
                        );
                    }
                    if ($('#lot').length) {
                        $('#lot').val('');
                    }
                    $('#district').off('change.divisionLoader').on('change.divisionLoader', function() {
                        // Your existing change handler if needed
                    });
                }, 50);
                return;
            }

            // Handle selected values for search
            var selectedDistrict = "{{ request('district') }}";
            var selectedDivision = "{{ request('division') }}";

            if (selectedDistrict) {
                $('#district').trigger('change');
                var checkExist = setInterval(function() {
                    if ($('#division option').length > 1) {
                        $('#division').val(selectedDivision);
                        clearInterval(checkExist);
                    }
                }, 100);
            }

            $('.btn-primary.search-btn').click(function(e) {
                e.preventDefault();

                var district = $('#district').val();
                var division = $('#division').val();
                var lot = $('#lot').val();
                var per_page = "{{ $perPage }}";
                var queryParams = [];
                if (district) queryParams.push('district=' + district);
                if (division) queryParams.push('division=' + division);
                if (lot) queryParams.push('lot=' + encodeURIComponent(lot));
                if (per_page) queryParams.push('per_page=' + per_page);
                window.location.href = window.location.pathname + '?' + queryParams.join('&');
            });
            $('.sbtn a.btn-primary').on('click', function(e) {
                var href = $(this).attr('href');
                if (href) {
                    window.location.href = href;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection
