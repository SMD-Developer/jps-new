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

        font-size: 13px;
    }

    thead {
        border-color: inherit;
        border-style: none !important;
        border-width: 0;
    }

    .card.p-3 {
        background: aliceblue !important;
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
                        <!--<div class="row g-2 mb-3 d-flex justify-content-end">-->
                        <!--   <button class="btn btn-primary"><i class="fa fa-plus"></i> @lang('app.add_staff')</button>-->
                        <!--</div> -->
                        <div class="row search-row align-items-center g-2 mb-3">
                            <!-- Button Group -->
                            <!--<div class="col-lg-6 col-md-12 mb-2">-->
                            <!--    <div class="btn-group w-100" role="group">-->
                            <!--        <button class="btn btn-outline-secondary btn-sm">@lang('app.column_visibility')</button>-->
                            <!--        <button class="btn btn-outline-secondary btn-sm">@lang('app.copy')</button>-->
                            <!--        <button class="btn btn-outline-secondary btn-sm">@lang('app.csv')</button>-->
                            <!--        <button class="btn btn-outline-secondary btn-sm">@lang('app.excel')</button>-->
                            <!--        <button class="btn btn-outline-secondary btn-sm">@lang('app.pdf')</button>-->
                            <!--        <button class="btn btn-outline-secondary btn-sm">@lang('app.print')</button>-->
                            <!--    </div>-->


                            <!--</div>-->
                            <div class="col-lg-12 col-md-12 g-2 mb-3 d-flex justify-content-end">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i
                                        class="fa fa-plus"></i> @lang('app.add_role')</button>
                            </div>
                        </div>

                        <!-- Search Section Aligned to Right -->
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end align-items-baseline">
                                <label for="search" class="form-label me-2">{{ trans('app.search') }} :
                                    &nbsp;&nbsp;&nbsp;</label>
                                <input type="text" id="search" class="form-control form-control-sm w-auto"
                                    placeholder="{{ trans('app.search') }}">
                                <a href="#" class="btn btn-primary btn-sm ms-2" id="search-results">
                                    <strong>{{ trans('app.search_b') }}</strong>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-start align-items-baseline">
                                <label for="show" class="form-label me-2">{{ trans('app.show') }} :
                                    &nbsp;&nbsp;&nbsp;</label>
                                <select type="select" class="form-control form-control-sm w-auto form-select">
                                    <option selected>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>500</option>
                                </select>&nbsp;&nbsp;
                                <p><strong>{{ trans('app.entries') }}</strong></p>
                            </div>
                        </div>
                        <!-- Table Section -->
                        <p><strong>{{ trans('app.Showing') }} 1 {{ trans('app.to') }} 5 of
                                {{ trans('app.entries') }}</strong></p>
                        <!--<div class="table-responsive mt-3">-->

                        <!--     <table class="table">-->
                        <!--        <thead>-->
                        <!--            <tr>-->
                        <!--                <th><strong># <i class="fa fa-sort"></i></strong></th>-->
                        <!--                <th><strong>{{ trans('app.role') }} <i class="fa fa-sort"></i></strong></th>-->
                        <!--                <th><strong>{{ trans('app.department') }} <i class="fa fa-sort"></i></strong></th>-->
                        <!--                <th><strong>{{ trans('app.users') }}</strong></th>-->
                        <!--                <th><strong>{{ trans('app.status') }}</strong></th>-->
                        <!--                <th><strong>{{ trans('app.action') }}</strong></th>-->
                        <!--            </tr>-->
                        <!--        </thead>-->
                        <!--        <tbody>-->
                        <!--            @foreach ($roles as $index => $role)-->
                        <!--                <tr>-->
                        <!--                    <td>{{ $index + 1 }}</td>-->
                        <!--                    <td>{{ trans('app.' . $role->name) }}</td>-->
                        <!--                    <td>-->
                        <!--                        @if ($role->department && $role->department->status == 1)-->
                        <!--                            {{ $role->department->name }}-->
                        <!--                        @else-->
                        <!--                            --->
                        <!--                        @endif-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        @if (isset($role->users) && count($role->users) > 0)-->
                        <!--                            <ul class="list-unstyled">-->
                        <!--                                @foreach ($role->users as $user)-->
                        <!--                                    <li>{{ $user->name }}</li>-->
                        <!--                                @endforeach-->
                        <!--                            </ul>-->
                        <!--                        @else-->
                        <!--                            --->
                        <!--                        @endif-->
                        <!--                    </td>-->
                        <!--                   <td>-->
                        <!--                        @if (isset($role->users) && count($role->users) > 0)-->
                        <!--                            <ul class="list-unstyled">-->
                        <!--                                @foreach ($role->users as $user)-->
                        <!--                                    <li id="status-cell-{{ $user->uuid }}"-->
                        <!--                                        class="d-flex align-items-center gap-2">-->
                        <!--                                        @if ($user->is_blocked)-->
                        <!--                                            <span class="badge bg-danger">Blocked</span>-->
                        <!--                                            <button class="btn btn-sm btn-success unblock-btn"-->
                        <!--                                                data-user-id="{{ $user->uuid }}">-->
                        <!--                                                <i class="fa fa-unlock"></i> Unblock-->
                        <!--                                            </button>-->
                        <!--                                        @else-->
                        <!--                                            <span class="badge bg-success">Active</span>-->
                        <!--                                        @endif-->
                        <!--                                    </li>-->
                        <!--                                @endforeach-->
                        <!--                            </ul>-->
                        <!--                        @else-->
                        <!--                            <span class="text-muted">No users</span>-->
                        <!--                        @endif-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        <div class="btn-group">-->
                        <!--                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"-->
                        <!--                                data-bs-target="#updateRoleModal" data-id="{{ $role->uuid }}"-->
                        <!--                                data-name="{{ $role->name }}"-->
                        <!--                                data-display_name="{{ $role->display_name }}"-->
                        <!--                                data-description="{{ $role->description }}"-->
                        <!--                                data-department="{{ $role->department_id }}">-->
                        <!--                                <i class="fa fa-edit"></i>-->
                        <!--                            </a>-->
                        <!--                        </div>-->
                        <!--                    </td>-->
                        <!--                </tr>-->
                        <!--            @endforeach-->
                        <!--        </tbody>-->
                        <!--    </table>-->
                        <!--</div> -->
                        <div class="table-responsive mt-3">
    <table class="table">
        <thead>
            <tr>
                <th><strong># <i class="fa fa-sort"></i></strong></th>
                <th><strong>{{ trans('app.role') }} <i class="fa fa-sort"></i></strong></th>
                <th><strong>{{ trans('app.department') }} <i class="fa fa-sort"></i></strong></th>
                <th><strong>{{ trans('app.users') }}</strong></th>
                <th><strong>{{ trans('app.status') }}</strong></th>
                <th><strong>{{ trans('app.action') }}</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $index => $role)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $role->display_name}}</td>
                    <td>
                        @if ($role->department && $role->department->status == 1)
                            {{ $role->department->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if (isset($role->users) && count($role->users) > 0)
                            <ul class="list-unstyled">
                                @foreach ($role->users as $user)
                                    <li>{{ $user->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if (isset($role->users) && count($role->users) > 0)
                            @php
                                $hasBlockedUsers = $role->users->contains('is_blocked', true);
                            @endphp
                            
                            @if ($hasBlockedUsers)
                                <span class="badge bg-danger">Has Blocked Users</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        @else
                            <span class="text-muted">No users</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#updateRoleModal" data-id="{{ $role->uuid }}"
                                data-name="{{ $role->name }}"
                                data-display_name="{{ $role->display_name }}"
                                data-description="{{ $role->description }}"
                                data-department="{{ $role->department_id }}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> <!-- End Table Responsive -->
                    </div>

                    <!-- Add role Button -->

                    <!-- Add role Modal -->
                    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addRoleModalLabel">@lang('app.add_role')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add an ID for AJAX -->
                                    <form id="addRoleForm" action="{{ route('roles.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.role')</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="@lang('app.role')" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.display_name')</label>
                                            <input type="text" class="form-control" name="display_name"
                                                placeholder="@lang('app.display_name')" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.department')</label>
                                            <select class="form-control form-select" name="department_id" required>
                                                <option value="" disabled selected>@lang('app.select_department')</option>
                                                @foreach ($departments as $department)
                                                    @if ($department->status == 1)
                                                        <!-- Only show active departments -->
                                                        <option value="{{ $department->id }}">{{ $department->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.description')</label>
                                            <textarea class="form-control" name="description" placeholder="@lang('app.description')"></textarea>
                                        </div>
                                         <div class="row g-1">
                                            <label class="form-label fw-bold">@lang('app.permission')</label>
                                            @foreach ($groupedPermissions as $groupDisplayName => $permissions)
                                                <div class="col-md-6 mt-3">
                                                    <div class="card p-3">
                                                        <h5 class="card-title mb-0" style="font-size: 15px;">
                                                            {{ $groupDisplayName }}
                                                        </h5>
                                                        <hr>
                                                        <div class="row">
                                                            @foreach ($permissions as $permission)
                                                                <div class="col-6" style="font-size: 13px;">
                                                                    <input type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->uuid }}"
                                                                        id="add_perm_{{ $permission->uuid }}">
                                                                    {{ $permission->display_name ?? $permission->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer mt-4">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">@lang('app.close')</button>
                                            <button type="submit" class="btn btn-primary"
                                                id="submitBtn">@lang('app.submit')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Update role-->
                    <div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel">
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateRoleModalLabel">@lang('app.update_role')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateRoleForm" action="{{ route('roles.update') }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- This is required for PUT requests -->
                                        <input type="hidden" name="id" id="role_id">
                                        <!-- FIX: Ensure UUID is set -->

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.role')</label>
                                            <input type="text" class="form-control" name="name" id="role_name"
                                                placeholder="@lang('app.role')" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.display_name')</label>
                                            <input type="text" class="form-control" name="display_name"
                                                id="role_display_name" placeholder="@lang('app.display_name')" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.department')</label>
                                            <select class="form-control form-select" name="department_id"
                                                id="role_department" required>
                                                <option value="" disabled selected>@lang('app.select_department')</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">@lang('app.description')</label>
                                            <textarea class="form-control" name="description" id="role_description" placeholder="@lang('app.description')"></textarea>
                                        </div>

                                        <div class="row g-1">
                                            <label class="form-label fw-bold">@lang('app.permission')</label>
                                            @foreach ($groupedPermissions as $groupDisplayName => $permissions)
                                                <div class="col-md-6 mt-3">
                                                    <div class="card p-3">
                                                        <h5 class="card-title mb-0" style="font-size: 15px;">
                                                            {{ $groupDisplayName }}
                                                        </h5>
                                                        <hr>
                                                        <div class="row">
                                                            @foreach ($permissions as $permission)
                                                                <div class="col-6" style="font-size: 13px;">
                                                                    <input type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->uuid }}"
                                                                        id="perm_{{ $permission->uuid }}">
                                                                    {{ $permission->display_name ?? $permission->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">@lang('app.close')</button>
                                    <button type="submit" class="btn btn-primary"
                                        id="updateRoleSubmit">@lang('app.update')</button>
                                </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            <!-- Include SweetAlert2 (Move this inside your main layout) -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Bootstrap CSS & JS (if not already included) -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- JavaScript -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("addRoleForm").addEventListener("submit", function(event) {
                        event.preventDefault(); // Prevent default form submission

                        Swal.fire({
                            title: "@lang('app.are_you_sure_role')",
                            text: "@lang('app.you_are_about_to_add_role')",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "@lang('app.yes')",
                            cancelButtonText: "@lang('app.cancel')"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let form = document.getElementById("addRoleForm");
                                let formData = new FormData(form);

                                fetch("{{ route('roles.store') }}", {
                                        method: "POST",
                                        body: formData,
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector(
                                                'meta[name="csrf-token"]').content
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                title: "@lang('app.success')",
                                                text: "@lang('app.role_added_successfully')",
                                                icon: "success",
                                                confirmButtonColor: "#3085d6",
                                                confirmButtonText: "@lang('app.ok')"
                                            }).then(() => {
                                                location
                                                    .reload(); // Reload to update the role list
                                            });
                                        } else {
                                            Swal.fire("Error", data.message, "error");
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        Swal.fire("Error", "@lang('app.something_went_wrong')", "error");
                                    });
                            }
                        });
                    });
                });
            </script>
            <script>
                // Add this script at the bottom of your page or in a separate JS file
                document.addEventListener('DOMContentLoaded', function() {
                    // Handle the update role modal
                    const updateRoleModal = document.getElementById('updateRoleModal');
                    if (updateRoleModal) {
                        updateRoleModal.addEventListener('show.bs.modal', function(event) {
                            // Get the button that triggered the modal
                            const button = event.relatedTarget;

                            // Extract role data from button's data attributes
                            const roleId = button.getAttribute('data-id');
                            const roleName = button.getAttribute('data-name');
                            const roleDisplayName = button.getAttribute('data-display_name');
                            const roleDescription = button.getAttribute('data-description');
                            const roleDepartment = button.getAttribute('data-department');

                            // Set the values in the form
                            document.getElementById('role_id').value = roleId;
                            document.getElementById('role_name').value = roleName;
                            document.getElementById('role_display_name').value = roleDisplayName;
                            document.getElementById('role_description').value = roleDescription;
                            document.getElementById('role_department').value = roleDepartment;

                            // Fetch and set the role permissions
                            fetchRolePermissions(roleId);
                        });
                    }

                    // Handle the update role form submission
                    const updateRoleForm = document.getElementById('updateRoleForm');
                    if (updateRoleForm) {
                        updateRoleForm.addEventListener('submit', function(event) {
                            event.preventDefault();

                            // Show SweetAlert confirmation
                            Swal.fire({
                                title:"@lang('app.are_you_sure_admin')",
                                text: "",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: "@lang('app.no')",
                                confirmButtonText: "@lang('app.yes')",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Get form data
                                    const formData = new FormData(updateRoleForm);

                                    // Submit the form via AJAX
                                    fetch(updateRoleForm.action, {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest'
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire(
                                                    'Berjaya dikemaskini',
                                                ).then(() => {
                                                    // Reload the page to show updated data
                                                    window.location.reload();
                                                });
                                            } else {
                                                Swal.fire(
                                                    'Error!',
                                                    data.message || 'Something went wrong.',
                                                    'error'
                                                );
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            Swal.fire(
                                                'Error!',
                                                'There was a problem updating the role.',
                                                'error'
                                            );
                                        });
                                }
                            });
                        });
                    }
                });

                // Function to fetch role permissions
                // Function to fetch role permissions
                function fetchRolePermissions(roleId) {
                    // Make an AJAX call to get the role's current permissions
                    fetch(`/roles/${roleId}/permissions`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Reset all checkboxes first
                            const checkboxes = document.querySelectorAll('#updateRoleForm input[name="permissions[]"]');
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });

                            // Check the checkboxes for permissions this role has
                            if (data.permissions && data.permissions.length) {
                                data.permissions.forEach(permissionUuid => {
                                    if (permissionUuid) {
                                        const checkbox = document.getElementById(`perm_${permissionUuid}`);
                                        if (checkbox) {
                                            checkbox.checked = true;
                                        }
                                    }
                                });
                            }

                            // Log the permissions data for debugging
                            console.log('Permissions data:', data.permissions);
                        })
                        .catch(error => {
                            console.error('Error fetching permissions:', error);
                        });
                }
            </script>
            <script>
                $(document).ready(function() {
                    $('.group-status-toggle').on('change', function() {
                        const groupId = $(this).data('group-id');
                        const isActive = $(this).prop('checked') ? 1 : 0;

                        // Update the label text
                        $(this).next('label').text(isActive ? 'Active' : 'Inactive');

                        // Send AJAX request to update the group status
                        $.ajax({
                            url: '{{ route('update.permission.group.status') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                group_id: groupId,
                                status: isActive
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success('Permission group status updated successfully');
                                } else {
                                    toastr.error('Failed to update permission group status');
                                }
                            },
                            error: function() {
                                toastr.error(
                                    'An error occurred while updating permission group status');
                            }
                        });
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('.unblock-btn').on('click', function() {
                        var adminId = $(this).data('user-id');
                        var button = $(this);
                        var adminName = $(this).closest('li').siblings().first().text() || 'this admin';

                        Swal.fire({
                            title: 'Confirm Unblock',
                            text: 'Are you sure you want to unblock ' + adminName + '?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, unblock!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/admin/unblock/' + adminId,
                                    type: 'POST',
                                    data: {
                                        '_token': '{{ csrf_token() }}'
                                    },
                                    beforeSend: function() {
                                        button.prop('disabled', true);
                                        button.html(
                                            '<i class="fa fa-spinner fa-spin"></i> Processing...'
                                            );
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            var statusCell = $('#status-cell-' + adminId);
                                            statusCell.html(
                                                '<span class="badge bg-success">Active</span>'
                                                );

                                            Swal.fire({
                                                title: 'Success!',
                                                text: response.message,
                                                icon: 'success',
                                                timer: 3000,
                                                timerProgressBar: true
                                            });
                                        } else {
                                            // Show error message with SweetAlert
                                            Swal.fire({
                                                title: 'Error!',
                                                text: response.message,
                                                icon: 'error'
                                            });

                                            // Reset button state
                                            button.prop('disabled', false);
                                            button.html('<i class="fa fa-unlock"></i> Unblock');
                                        }
                                    },
                                    error: function(xhr) {
                                        // Show error message with SweetAlert
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'An error occurred: ' + (xhr
                                                .responseJSON ? xhr.responseJSON
                                                .message : 'Unknown error'),
                                            icon: 'error'
                                        });

                                        // Reset button state
                                        button.prop('disabled', false);
                                        button.html('<i class="fa fa-unlock"></i> Unblock');
                                    }
                                });
                            }
                        });
                    });
                });
            </script>
        @endsection
