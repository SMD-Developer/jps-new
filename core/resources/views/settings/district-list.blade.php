@extends('app')
<style>
    /* Flex container for buttons */
    body {
        font-size: 14px;
    }

    .sbtn {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
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

    table.table.table-bordered.table-striped {
        text-align: center;
        font-size: 13px;
    }

    .add-btn {
        margin-bottom: 1rem;
    }
</style>
<title>District List | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-map" aria-hidden="true"></i> @lang('app.district_list')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Main Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Add New District Button -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-right add-btn">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#addDistrictModal"
                                    style="background:#28a745 !important; border:solid 1px #28a745;">
                                    <i class="fa fa-plus"></i> <strong>@lang('app.add_new_district')</strong>
                                </button>
                            </div>
                        </div>

                        <!-- Records Per Page Selection -->
                        <div class="d-flex align-items-baseline mb-3 mx-3">
                            <label for="perPageSelect" class="me-2">@lang('app.show'): </label>
                            <select id="perPageSelect" class="form-select form-select-sm" onchange="changePerPage()"
                                style="width: auto">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                            </select>
                        </div>

                        <!-- Table Section -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><strong>@lang('app.bil')</strong></th>
                                        <th><strong>@lang('app.state_name')</strong></th>
                                        <th><strong>@lang('app.district_code')</strong></th>
                                        <th><strong>@lang('app.district_name')</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong>@lang('app.for_action')</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>
                                    @foreach ($districts as $district)
                                        <tr>
                                            <td>{{ ($districts->currentPage() - 1) * $districts->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $district->negeri }}</td>
                                            <td>{{ $district->daerah_code }}</td>
                                            <td>{{ $district->daerah }}</td>
                                            <td>
                                                @if ($district->stat == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="sbtn">
                                                    <a href="#"
                                                        onclick="editDistrict({{ $district->iddaerah }}, {{ $district->idnegeri }}, '{{ $district->daerah }}', '{{ $district->daerah_code }}', {{ $district->stat }})"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </tbody>
                            </table>

                            <!-- Pagination Section -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        Page <strong>{{ $districts->currentPage() }}</strong> of
                                        <strong>{{ $districts->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        @if ($districts->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $districts->url(1) }}&per_page={{ $perPage }}">«
                                                    First</a>
                                            </li>
                                        @endif

                                        @if ($districts->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $districts->previousPageUrl() }}&per_page={{ $perPage }}">‹
                                                    Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($districts->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled"><span
                                                        class="page-link">{{ $element }}</span></li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li
                                                        class="page-item {{ $page == $districts->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($districts->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $districts->nextPageUrl() }}&per_page={{ $perPage }}">Next
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next ›</span>
                                            </li>
                                        @endif

                                        @if ($districts->currentPage() < $districts->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $districts->url($districts->lastPage()) }}&per_page={{ $perPage }}">Last
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
    </section>

    <!-- Add District Modal -->
    <div class="modal fade" id="addDistrictModal" tabindex="-1" role="dialog" aria-labelledby="addDistrictModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDistrictModalLabel">
                        <i class="fa fa-plus"></i> @lang('app.add_new_district')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="addDistrictForm" method="POST" action="{{ route('addDistrict') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Alert container for form messages -->
                        <div id="formAlert" class="alert" style="display: none;"></div>

                        <!-- State Selection -->
                        <div class="form-group row">
                            <label for="idnegeri" class="col-sm-3 col-form-label">
                                @lang('app.state') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="idnegeri" name="idnegeri" required>
                                    <option value="">@lang('app.select_state')</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->idnegeri }}">{{ $state->negeri }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- District Name -->
                        <div class="form-group row">
                            <label for="daerah" class="col-sm-3 col-form-label">
                                @lang('app.district_name') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="daerah" name="daerah" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- District Code -->
                        <div class="form-group row">
                            <label for="daerah_code" class="col-sm-3 col-form-label">
                                 @lang('app.district_code') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="daerah_code" name="daerah_code" maxlength="11" required>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">Maximum 11 characters</small>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">@lang('app.select_status')</option>
                                    <option value="1">@lang('app.active')</option>
                                    <option value="0">@lang('app.inactive')</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> @lang('app.cancel')
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> @lang('app.create')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit District Modal -->
    <div class="modal fade" id="editDistrictModal" tabindex="-1" role="dialog"
        aria-labelledby="editDistrictModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDistrictModalLabel">
                        <i class="fa fa-edit"></i>  @lang('app.edit_district')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="editDistrictForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <!-- Alert container for form messages -->
                        <div id="editFormAlert" class="alert" style="display: none;"></div>

                        <!-- State Selection -->
                        <div class="form-group row">
                            <label for="edit_idnegeri" class="col-sm-3 col-form-label">
                                @lang('app.state') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="edit_idnegeri" name="idnegeri" required>
                                    <option value="">@lang('app.select_state')</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->idnegeri }}">{{ $state->negeri }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- District Name -->
                        <div class="form-group row">
                            <label for="edit_daerah" class="col-sm-3 col-form-label">
                                @lang('app.district_name') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_daerah" name="daerah"
                                    placeholder="Enter district name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- District Code -->
                        <div class="form-group row">
                            <label for="edit_daerah_code" class="col-sm-3 col-form-label">
                                 @lang('app.district_code') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_daerah_code" name="daerah_code"
                                    placeholder="Enter district code" maxlength="11" required>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">Maximum 11 characters</small>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row">
                            <label for="edit_status" class="col-sm-3 col-form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="">@lang('app.select_status')</option>
                                    <option value="1">@lang('app.active')</option>
                                    <option value="0">@lang('app.inactive')</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> @lang('app.cancel')
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-save"></i> @lang('app.kemaskini')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function changePerPage() {
            let perPage = document.getElementById('perPageSelect').value;
            let url = new URL(window.location.href);
            url.searchParams.set('page', 1);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }

        function editDistrict(id, idnegeri, daerah, daerah_code, stat) {
            $('#edit_idnegeri').val(idnegeri);
            $('#edit_daerah').val(daerah);
            $('#edit_daerah_code').val(daerah_code);
            $('#edit_status').val(stat);
            $('#editDistrictForm').attr('action', '/districts/' + id);
            $('#editDistrictModal').modal('show');
        }

        $(document).ready(function() {
            $('#addDistrictForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#addDistrictModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;

                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        if (errors) {
                            Object.keys(errors).forEach(function(key) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).siblings('.invalid-feedback').text(errors[
                                    key][0]);
                            });
                        }

                        $('#formAlert').removeClass('alert-success').addClass('alert-danger')
                            .text(xhr.responseJSON.message || 'Error adding district').show();
                    }
                });
            });

            // Handle Edit District Form Submission
            $('#editDistrictForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#editDistrictModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;

                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        if (errors) {
                            Object.keys(errors).forEach(function(key) {
                                $('#edit_' + key).addClass('is-invalid');
                                $('#edit_' + key).siblings('.invalid-feedback').text(
                                    errors[key][0]);
                            });
                        }

                        $('#editFormAlert').removeClass('alert-success').addClass(
                                'alert-danger')
                            .text(xhr.responseJSON.message || 'Error updating district').show();
                    }
                });
            });

            // Clear form when modals are closed
            $('#addDistrictModal').on('hidden.bs.modal', function() {
                $('#addDistrictForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#formAlert').hide();
            });

            $('#editDistrictModal').on('hidden.bs.modal', function() {
                $('#editDistrictForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#editFormAlert').hide();
            });
        });
    </script>
@endsection
