@extends('app')
<style>
    /* Make buttons take full width on small screens */
    @media (max-width: 768px) {
        .d-grid {
            display: block;
            width: 100%;
        }

        .btn-group {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
    }
    table.table {
        font-size:13px;
    }
     thead{
    border-color: inherit;
    border-style: none !important;
    border-width: 0;
}
</style>
<title>{{ $title }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ $title }}</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Filter Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row search-row align-items-center g-2 mb-3">
                        <div class="col-lg-12 col-md-12 g-2 mb-3 d-flex justify-content-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDepartmentModal"><i class="fa fa-plus"></i> @lang('app.add_department')</button>
                        </div>
                    </div>

                    <!-- Search Section Aligned to Right -->
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-end align-items-baseline">
                            <label for="search" class="form-label me-2">{{ trans('app.search') }} : &nbsp;&nbsp;&nbsp;</label>
                            <input type="text" id="search" class="form-control form-control-sm w-auto" placeholder="{{ trans('app.search') }}">
                            <a href="#" class="btn btn-primary btn-sm ms-2" id="search-results">
                                <strong>{{ trans('app.search_b') }}</strong>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-start align-items-baseline">
                            <label for="perPageSelect" class="form-label me-2">{{ trans('app.show') }} : &nbsp;&nbsp;&nbsp;</label>
                            <select id="perPageSelect" class="form-control form-control-sm w-auto form-select" onchange="changePerPage()">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                            </select>&nbsp;&nbsp;    
                            <p class="mb-0"><strong>{{ trans('app.entries') }}</strong></p>
                        </div>
                    </div>
                
                    <div class="table-responsive mt-3">
                        <table class="table  ">
                            <thead>
                                <tr>
                                    <th><strong># <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.name') }} <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.display_name') }} <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.status') }}</strong></th>
                                    <th><strong>{{ trans('app.action') }}</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $key => $department)
                                <tr>
                                    <td>{{ ($departments->currentPage() - 1) * $departments->perPage() + $key + 1 }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->display_name }}</td>
                                    <td>
                                        <span class="badge {{ $department->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $department->status == 1 ? __('app.active') : __('app.inactive') }}
                                        </span>
                                    </td>                                    
                                    <td>
                                        <div class="btn-group gap-3">
                                            <button type="button" class="btn btn-warning btn-sm editDepartmentBtn" 
                                                data-id="{{ $department->id }}" 
                                                data-name="{{ $department->name }}" 
                                                data-display-name="{{ $department->display_name }}" 
                                                data-status="{{ $department->status }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateRoleModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm deleteDepartmentBtn" 
                                                data-id="{{ $department->id }}" 
                                                data-name="{{ $department->name }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>                                    
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div> 
                    <!-- Pagination Section -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <span class="me-2">
                                Page <strong>{{ $departments->currentPage() }}</strong> of
                                <strong>{{ $departments->lastPage() }}</strong>
                            </span>
                        </div>

                        <nav>
                            <ul class="pagination">
                                @if ($departments->currentPage() > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $departments->url(1) }}&per_page={{ $perPage }}&search={{ $search ?? '' }}">« First</a>
                                    </li>
                                @endif

                                @if ($departments->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">‹ Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $departments->previousPageUrl() }}&per_page={{ $perPage }}&search={{ $search ?? '' }}">‹ Previous</a>
                                    </li>
                                @endif

                                @foreach ($departments->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                    @endif
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            <li class="page-item {{ $page == $departments->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}&per_page={{ $perPage }}&search={{ $search ?? '' }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($departments->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $departments->nextPageUrl() }}&per_page={{ $perPage }}&search={{ $search ?? '' }}">Next ›</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next ›</span>
                                    </li>
                                @endif

                                @if ($departments->currentPage() < $departments->lastPage())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $departments->url($departments->lastPage()) }}&per_page={{ $perPage }}&search={{ $search ?? '' }}">Last »</a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    
                </div>
                

<!-- Add role Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aaddDepartmentModalLabel">@lang('app.add_department')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.name') }}</strong></label>
                            <input type="text" name="name" class="form-control" placeholder="{{ trans('app.name') }}" required>
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.display_name') }}</strong></label>
                            <input type="text" name="display_name" class="form-control" placeholder="{{ trans('app.display_name') }}">
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.status') }} <span class="text-danger">*</span></strong></label>
                            <select name="status" class="form-select" required>
                                <option value="" disabled selected>@lang('app.select_status')</option>
                                <option value="active">@lang('app.active')</option>
                                <option value="inactive">@lang('app.inactive')</option>
                            </select>                            
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('app.cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('app.create')</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>


{{-- Update department --}}
<div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateRoleModalLabel">@lang('app.update_department')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateDepartmentForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Laravel requires this for PUT requests -->
                    <input type="hidden" id="updateDepartmentId" name="department_id">
                
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.name') }}</strong></label>
                            <input type="text" id="updateName" name="name" class="form-control" required>
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.display_name') }}</strong></label>
                            <input type="text" id="updateDisplayName" name="display_name" class="form-control">
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.status') }} <span class="text-danger">*</span></strong></label>
                            <select id="updateStatus" name="status" class="form-select" required>
                                <option value="active">@lang('app.active')</option>
                                <option value="inactive">@lang('app.inactive')</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('app.cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('app.update')</button>
                    </div>
                </form>
                               
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap CSS & JS (if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Add Role
    document.getElementById('submitBtn').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent actual form submission

        Swal.fire({
            title: "@lang('app.are_you_sure_department')",
            text: "@lang('app.you_are_about_to_add_department')",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "@lang('app.yes')",
            cancelButtonText: "@lang('app.cancel')"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "@lang('app.success')",
                    text: "@lang('app.department_added_successfully')",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "@lang('app.ok')"
                });
            }
    });

    
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".editDepartmentBtn").forEach(button => {
        button.addEventListener("click", function () {
            let departmentId = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let displayName = this.getAttribute("data-display-name");
            let status = this.getAttribute("data-status");

            // Set modal inputs
            document.getElementById("updateDepartmentId").value = departmentId;
            document.getElementById("updateName").value = name;
            document.getElementById("updateDisplayName").value = displayName;
            document.getElementById("updateStatus").value = status == "1" ? "active" : "inactive";

            // Set correct update URL
            let form = document.getElementById("updateDepartmentForm");
            form.action = "{{ url('/department/update') }}/" + departmentId;
        });
    });

    // Handle form submission with SweetAlert confirmation
    document.getElementById("updateDepartmentForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent immediate form submission

        Swal.fire({
            title: "@lang('app.are_you_sure')",
            text: "@lang('app.you_are_about_to_update_department')",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "@lang('app.yes')",
            cancelButtonText: "@lang('app.cancel')"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "@lang('app.success')",
                    text: "@lang('app.department_updated_successfully')",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "@lang('app.ok')"
                }).then(() => {
                    event.target.submit(); // Now submit the form
                });
            }
        });
    });
});
</script>
<script>
function changePerPage() {
    let perPage = document.getElementById('perPageSelect').value;
    let search = '{{ $search ?? '' }}';
    let url = new URL(window.location.href);
    url.searchParams.set('page', 1);
    url.searchParams.set('per_page', perPage);
    if(search) {
        url.searchParams.set('search', search);
    }
    window.location.href = url.toString();
}
</script>
<script>
$(document).ready(function() {
    // Delete Department
    $('.deleteDepartmentBtn').on('click', function() {
        const departmentId = $(this).data('id');
        const departmentName = $(this).data('name');
        
        Swal.fire({
            title: 'Adakah anda pasti?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/department/delete/${departmentId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Dipadamkan!',
                                text: response.message,
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to delete department',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection