@extends('app')

<style>
    body {
        font-size: 14px;
    }

    .sbtn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table {
            font-size: 12px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            gap: 1rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        nav {
            width: 100%;
            display: flex;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .table th,
        .table td {
            padding: 0.5rem 0.25rem;
        }

        .pagination .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)) {
            display: none;
        }
    }
</style>

<title>{{ trans('app.goverment_agency_application') }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('app.list_of_application') }}</h5>
    </div>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Per Page Selection -->
                        <div class="d-flex align-items-baseline mb-3 mx-3">
                            <label for="perPageSelect" class="me-2">@lang('app.show') :&nbsp;</label>
                            <select id="perPageSelect" class="form-select form-select-sm" onchange="changePerPage()" style="width: auto">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                            </select>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>{{ trans('app.bil') }}</strong></th>
                                        <th><strong>{{ trans('app.date') }}</strong></th>
                                        <th><strong>{{ trans('app.account_type') }}</strong></th>
                                        <th><strong>{{ trans('app.applicant_list') }}</strong></th>
                                        <th><strong>{{ trans('app.lot_pt') }}</strong></th>
                                        <th><strong>{{ trans('app.for_action') }}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($applications as $item)
                                        <tr>
                                            <td>{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->uploade_date)) }}</td>
                                            <td>
                                                @if($item->client)
                                                    @switch($item->client->accountType)
                                                        @case(1)
                                                            Individu
                                                            @break
                                                        @case(2)
                                                            Pemaju
                                                            @break
                                                        @case(3)
                                                            Agensi Kerajaan
                                                            @break
                                                        @default
                                                            Unknown
                                                    @endswitch
                                                @endif
                                            </td>
                                            <td>{{ $item->applicant }}</td>
                                            <td>
                                                {{ $item->land_lot }}, {{ $item->land_area }},
                                                {{ $item->landDistrict->daerah ?? '' }},
                                                {{ $item->landDivision->mukim ?? '' }}
                                            </td>
                                            <td>
                                                <div class="sbtn">
                                                    <a href="{{ route('newApplication', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No applications found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        @lang('app.page') <strong>{{ $applications->currentPage() }}</strong> @lang('app.of')
                                        <strong>{{ $applications->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    {{ $applications->appends(['per_page' => $perPage])->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function changePerPage() {
            let perPage = document.getElementById('perPageSelect').value;
            let url = new URL(window.location.href);
            url.searchParams.set('page', 1);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }
    </script>
@endsection