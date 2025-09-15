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

    .readonly-field {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
    }
</style>
<title>Land Category List | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-tags" aria-hidden="true"></i> @lang('app.land_category_list')</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Main Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Add New Land Category Button -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-right add-btn">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addCategoryModal"
                                    style="background:#28a745 !important; border:solid 1px #28a745;">
                                    <i class="fa fa-plus"></i> <strong>@lang('app.add_new_land_category')</strong>
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
                                        <th><strong>@lang('app.category')</strong></th>
                                        <th><strong>@lang('app.rates')</strong></th>
                                        <th><strong>@lang('app.currency')</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong>@lang('app.for_action')</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($landCategories as $category)
                                        <tr>
                                            <td>{{ ($landCategories->currentPage() - 1) * $landCategories->perPage() + $loop->iteration }}</td>
                                            <td>{{ $category->category }}</td>
                                            <td>{{ number_format($category->rate, 2) }}</td>
                                            <td>{{ $category->currency }}</td>
                                            <td>
                                                @if($category->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="sbtn">
                                                    <a href="#" onclick="editCategory({{ $category->id }}, '{{ $category->category }}', '{{ $category->rate }}', '{{ $category->currency }}', {{ $category->status }})"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
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
                                        Page <strong>{{ $landCategories->currentPage() }}</strong> of
                                        <strong>{{ $landCategories->lastPage() }}</strong>
                                    </span>
                                </div>

                                <nav>
                                    <ul class="pagination">
                                        @if ($landCategories->currentPage() > 1)
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $landCategories->url(1) }}&per_page={{ $perPage }}">«
                                                    First</a>
                                            </li>
                                        @endif

                                        @if ($landCategories->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹ Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $landCategories->previousPageUrl() }}&per_page={{ $perPage }}">‹
                                                    Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($landCategories->links()->elements as $element)
                                            @if (is_string($element))
                                                <li class="page-item disabled"><span
                                                        class="page-link">{{ $element }}</span></li>
                                            @endif
                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li
                                                        class="page-item {{ $page == $landCategories->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $url }}&per_page={{ $perPage }}">{{ $page }}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($landCategories->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $landCategories->nextPageUrl() }}&per_page={{ $perPage }}">Next
                                                    ›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next ›</span>
                                            </li>
                                        @endif

                                        @if ($landCategories->currentPage() < $landCategories->lastPage())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $landCategories->url($landCategories->lastPage()) }}&per_page={{ $perPage }}">Last
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

    <!-- Add Land Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        <i class="fa fa-plus"></i> @lang('app.add_new_land_category')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addCategoryForm" method="POST" action="{{ route('addLandCategory') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Alert container for form messages -->
                        <div id="formAlert" class="alert" style="display: none;"></div>
                        
                        <!-- Category Name -->
                        <div class="form-group row">
                            <label for="category" class="col-sm-3 col-form-label">
                                @lang('app.category') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control" 
                                       id="category" 
                                       name="category"
                                       maxlength="250"
                                       required>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">Maximum 250 characters</small>
                            </div>
                        </div>

                        <!-- Rate -->
                        <div class="form-group row">
                            <label for="rate" class="col-sm-3 col-form-label">
                                @lang('app.rates') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="number" 
                                       class="form-control" 
                                       id="rate" 
                                       name="rate"
                                       step="0.01"
                                       min="0"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- Currency -->
                        <div class="form-group row">
                            <label for="currency" class="col-sm-3 col-form-label">
                               @lang('app.currency')
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control readonly-field" 
                                       id="currency" 
                                       name="currency"
                                       value="RM"
                                       readonly>
                                <small class="form-text text-muted">Currency is fixed as RM</small>
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

    <!-- Edit Land Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">
                        <i class="fa fa-edit"></i> @lang('app.edit_land_category')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <!-- Alert container for form messages -->
                        <div id="editFormAlert" class="alert" style="display: none;"></div>
                        
                        <!-- Category Name -->
                        <div class="form-group row">
                            <label for="edit_category" class="col-sm-3 col-form-label">
                                @lang('app.category') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control" 
                                       id="edit_category" 
                                       name="category"
                                       placeholder="Enter land category name"
                                       maxlength="250"
                                       required>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">Maximum 250 characters</small>
                            </div>
                        </div>

                        <!-- Rate -->
                        <div class="form-group row">
                            <label for="edit_rate" class="col-sm-3 col-form-label">
                                @lang('app.rates') <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="number" 
                                       class="form-control" 
                                       id="edit_rate" 
                                       name="rate"
                                       placeholder="Enter rate"
                                       step="0.01"
                                       min="0"
                                       required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- Currency -->
                        <div class="form-group row">
                            <label for="edit_currency" class="col-sm-3 col-form-label">
                                @lang('app.currency')
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       class="form-control readonly-field" 
                                       id="edit_currency" 
                                       name="currency"
                                       value="RM"
                                       readonly>
                                <small class="form-text text-muted">Currency is fixed as RM</small>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row">
                            <label for="edit_status" class="col-sm-3 col-form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value=""> @lang('app.select_status')</option>
                                    <option value="1"> @lang('app.active')</option>
                                    <option value="0"> @lang('app.inactive')</option>
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

        function editCategory(id, category, rate, currency, status) {
            $('#edit_category').val(category);
            $('#edit_rate').val(rate);
            $('#edit_currency').val(currency);
            $('#edit_status').val(status);
            $('#editCategoryForm').attr('action', '/land-categories/' + id);
            $('#editCategoryModal').modal('show');
        }

        $(document).ready(function() {
            // Handle Add Category Form Submission
            $('#addCategoryForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            $('#addCategoryModal').modal('hide');
                            location.reload(); // Reload page to show new category
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
                            .text(xhr.responseJSON.message || 'Error adding land category').show();
                    }
                });
            });

            // Handle Edit Category Form Submission
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            $('#editCategoryModal').modal('hide');
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
                            .text(xhr.responseJSON.message || 'Error updating land category').show();
                    }
                });
            });

            // Clear form when modals are closed
            $('#addCategoryModal').on('hidden.bs.modal', function () {
                $('#addCategoryForm')[0].reset();
                $('#currency').val('RM'); // Reset currency to RM
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#formAlert').hide();
            });

            $('#editCategoryModal').on('hidden.bs.modal', function () {
                $('#editCategoryForm')[0].reset();
                $('#edit_currency').val('RM'); // Reset currency to RM
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

            // Initialize currency fields as RM when modals open
            $('#addCategoryModal').on('show.bs.modal', function () {
                $('#currency').val('RM');
            });

            $('#editCategoryModal').on('show.bs.modal', function () {
                $('#edit_currency').val('RM');
            });
        });
    </script>
@endsection