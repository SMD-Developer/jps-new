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
        /* Adjustments for table on mobile */
        .table {
            font-size: 12px;
        }

        /* Better horizontal scrolling for table */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Improve spacing for pagination on mobile */
        .d-flex.justify-content-between.align-items-center {
            flex-direction: column;
            gap: 1rem;
        }

        /* Adjust button sizes on mobile */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        /* Center pagination on mobile */
        nav {
            width: 100%;
            display: flex;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        /* Improve table appearance on small screens */
        .table th,
        .table td {
            padding: 0.5rem 0.25rem;
        }

        /* Simplify pagination for very small screens */
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
<title>State List | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-map" aria-hidden="true"></i>@lang('app.state_list')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Main Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Add New State Button -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-right add-btn">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addStateModal"
                                    style="background:#28a745 !important; border:solid 1px #28a745;">
                                    <i class="fa fa-plus"></i> <strong>@lang('app.add_new_state')</strong>
                                </button>
                            </div>
                        </div>

                        <!-- Records Per Page Selection -->
                        <div class="d-flex align-items-baseline mb-3 mx-3">
                            <label for="perPageSelect" class="me-2">@lang('app.show') :&nbsp; </label>
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
                                        <th><strong>@lang('app.state_code')</strong></th>
                                        <th><strong>@lang('app.state_name')</strong></th>
                                        {{-- <th><strong>Created Date</strong></th> --}}
                                        <th><strong>Status</strong></th>
                                        <th><strong>@lang('app.for_action')</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($states as $state)
                                        <tr>
                                            <td>{{ ($states->currentPage() - 1) * $states->perPage() + $loop->iteration }}</td>
                                            <td>{{ $state->negeri_code }}</td>
                                            <td>{{ $state->negeri }}</td>
                                            {{-- <td>-</td> --}}
                                            <td>
                                                @if($state->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="sbtn">
                                                    {{-- <a href="{{ route('viewState', ['id' => $state->idnegeri]) }}"
                                                        class="btn btn-primary btn-sm" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a> --}}
                                                    <a href="#" onclick="editState({{ $state->idnegeri }}, '{{ $state->negeri }}', '{{ $state->negeri_code }}', {{ $state->status }})"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    {{-- <form method="POST" action="{{ route('deleteState', $state->idnegeri) }}" style="display: inline;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this state?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination Section -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="me-2">
                                        Page <strong>{{ $states->currentPage() }}</strong> of
                                        <strong>{{ $states->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        @if ($states->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $states->url(1) }}&per_page={{ $perPage }}">«
                                                    First</a>
                                            </li>
                                        @endif

                                        @if ($states->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $states->previousPageUrl() }}&per_page={{ $perPage }}">‹
                                                    Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($states->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled"><span
                                                        class="page-link">{{ $element }}</span></li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li
                                                        class="page-item {{ $page == $states->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($states->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $states->nextPageUrl() }}&per_page={{ $perPage }}">Next
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next ›</span>
                                            </li>
                                        @endif

                                        @if ($states->currentPage() < $states->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $states->url($states->lastPage()) }}&per_page={{ $perPage }}">Last
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

    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1" role="dialog" aria-labelledby="addStateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStateModalLabel">
                        <i class="fa fa-plus"></i>@lang('app.add_new_state')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addStateForm" method="POST" action="{{ route('addState') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Alert container for form messages -->
                        <div id="formAlert" class="alert" style="display: none;"></div>
                        
                        <!-- State Name -->
                        <div class="form-group row">
                            <label for="negeri" class="col-sm-3 col-form-label">
                                @lang('app.state_name') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control" 
                                       id="negeri" 
                                       name="negeri"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- State Code -->
                        <div class="form-group row">
                            <label for="negeri_code" class="col-sm-3 col-form-label">
                                @lang('app.state_code') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control" 
                                       id="negeri_code" 
                                       name="negeri_code"
                                       maxlength="11"
                                       required>
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
                            <i class="fa fa-times"></i>@lang('app.cancel')
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> @lang('app.create')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit State Modal -->
    <div class="modal fade" id="editStateModal" tabindex="-1" role="dialog" aria-labelledby="editStateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStateModalLabel">
                        <i class="fa fa-edit"></i> @lang('app.edit_state')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editStateForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <!-- Alert container for form messages -->
                        <div id="editFormAlert" class="alert" style="display: none;"></div>
                        
                        <!-- State Name -->
                        <div class="form-group row">
                            <label for="edit_negeri" class="col-sm-3 col-form-label">
                                @lang('app.state_name') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control" 
                                       id="edit_negeri" 
                                       name="negeri"
                                       placeholder="Enter state name"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- State Code -->
                        <div class="form-group row">
                            <label for="edit_negeri_code" class="col-sm-3 col-form-label">
                                @lang('app.state_code') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control" 
                                       id="edit_negeri_code" 
                                       name="negeri_code"
                                       placeholder="Enter state code"
                                       maxlength="11"
                                       required>
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
                            <i class="fa fa-save"></i>  @lang('app.kemaskini')
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

        function editState(id, negeri, negeri_code, status) {
            $('#edit_negeri').val(negeri);
            $('#edit_negeri_code').val(negeri_code);
            $('#edit_status').val(status);
            $('#editStateForm').attr('action', '/states/' + id);
            $('#editStateModal').modal('show');
        }

        $(document).ready(function() {
            // Handle Add State Form Submission
            $('#addStateForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            $('#addStateModal').modal('hide');
                            location.reload(); // Reload page to show new state
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        
                        // Clear previous errors
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                        
                        // Show validation errors
                        if(errors) {
                            Object.keys(errors).forEach(function(key) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).siblings('.invalid-feedback').text(errors[key][0]);
                            });
                        }
                        
                        $('#formAlert').removeClass('alert-success').addClass('alert-danger')
                            .text(xhr.responseJSON.message || 'Error adding state').show();
                    }
                });
            });

            // Handle Edit State Form Submission
            $('#editStateForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            $('#editStateModal').modal('hide');
                            location.reload(); 
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                        
                        // Show validation errors
                        if(errors) {
                            Object.keys(errors).forEach(function(key) {
                                $('#edit_' + key).addClass('is-invalid');
                                $('#edit_' + key).siblings('.invalid-feedback').text(errors[key][0]);
                            });
                        }
                        
                        // Show general error message
                        $('#editFormAlert').removeClass('alert-success').addClass('alert-danger')
                            .text(xhr.responseJSON.message || 'Error updating state').show();
                    }
                });
            });

            // Clear form when modals are closed
            $('#addStateModal').on('hidden.bs.modal', function () {
                $('#addStateForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#formAlert').hide();
            });

            $('#editStateModal').on('hidden.bs.modal', function () {
                $('#editStateForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#editFormAlert').hide();
            });

            // Action button click handlers
            $('.sbtn a.btn-primary').on('click', function(e) {
                var href = $(this).attr('href');
                if (href && href !== '#') {
                    window.location.href = href;
                }
            });
        });
    </script>
@endsection