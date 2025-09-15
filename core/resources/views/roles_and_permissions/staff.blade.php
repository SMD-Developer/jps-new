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
    
    .profile-img {
    width: 40px; /* Adjust as needed */
    height: 40px; /* Set height to prevent stretching */
    object-fit: cover; /* Keeps proportions without stretching */
    border-radius: 50%; /* Makes it round (optional) */
}


.unblock-staff-btn {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.75rem !important;
}

.unblock-staff-btn .fa {
    font-size: 0.75rem !important;
}

.password-input-group {
    position: relative;
}
.password-toggle {
    position: absolute;
    right: 12px;
    top: 38px;
    cursor: pointer;
    color: #6c757d;
}
.password-toggle:hover {
    color: #495057;
}
 thead{
    border-color: inherit;
    border-style: none !important;
    border-width: 0;
}

.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.invalid-feedback {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
    display: block !important;
}

/* Ensure form groups have proper spacing for error messages */
.modal-body .mb-3 {
    margin-bottom: 1.5rem !important;
}

/* Style for when field has error */
.form-control.is-invalid:focus,
.form-select.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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
                                 
                            
                        <!--</div>-->
                        <div class="col-lg-12 col-md-12 g-2 mb-3 d-flex justify-content-end">
                            @if($canAdminStaffAddStaff)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal"><i class="fa fa-plus"></i> @lang('app.add_staff')</button>
                            @endif
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
                            <label for="show" class="form-label me-2">{{ trans('app.show') }} : &nbsp;&nbsp;&nbsp;</label>
                            <select type="select"  class="form-control form-control-sm w-auto form-select">
                                <option selected>10</option>
                                <option >20</option>
                                <option >50</option>
                                <option >100</option>
                                <option >500</option>
                            </select>&nbsp;&nbsp;    
                                <p><strong>{{ trans('app.entries') }}</strong></p>
                        </div>
                    </div>
                    <!-- Table Section -->
                    <p><strong>{{ trans('app.Showing') }} 1 {{ trans('app.to') }} 5 of {{ trans('app.entries') }}</strong></p>
                    <div class="table-responsive mt-3">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th><strong># <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.image') }} <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.staff_name') }} <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.email') }} <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.role') }} <i class="fa fa-sort"></i></strong></th>
                                    <!--<th><strong>{{ trans('app.department') }} <i class="fa fa-sort"></i></strong></th>-->
                                    <th><strong>{{ trans('app.status') }} <i class="fa fa-sort"></i></strong></th>
                                    <th><strong>{{ trans('app.action') }}</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffUsers as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ $user->photo ? asset('uploads/user_photos/' . $user->photo) : asset('assets/images/icon/user-default.png') }}" class="profile-img">
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role_name ?? 'N/A' }}</td>
                                        <td id="staff-status-cell-{{ $user->uuid }}" >
                                            <div style="display:flex; flex-direction:column; align-items:baseline;">
                                                @if($user->is_blocked)
                                                    <span class="badge bg-danger">Blocked</span>
                                                    <button class="btn btn-sm btn-success unblock-staff-btn mt-2"
                                                        data-staff-id="{{ $user->uuid }}"
                                                        style="width: 80px; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                                        <i class="fa fa-unlock"></i> 
                                                        <span>Unblock</span>
                                                    </button>
                                                @elseif($user->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </div>

                                        </td>
                                        <td>
                                             @if ($canAdminStaffEditStaff)
                                                    <div class="btn-group">
                                                        @php
                                                            // Split username into first and last name
                                                            $nameParts = explode(' ', $user->username, 2);
                                                            $firstName = $nameParts[0] ?? '';
                                                            $lastName = $nameParts[1] ?? '';
                                                        @endphp
                                                        <a href="#" class="btn btn-warning btn-sm editStaffBtn"
                                                            data-bs-toggle="modal" data-bs-target="#updateStaffModal"
                                                            data-id="{{ $user->uuid }}"
                                                            data-first_name="{{ $firstName }}"
                                                            data-last_name="{{ $lastName }}"
                                                            data-email="{{ $user->email }}"
                                                            data-role="{{ $user->role_id }}"
                                                            data-status="{{ $user->status == 1 ? 'active' : 'inactive' }}"
                                                            data-is_blocked="{{ $user->is_blocked ? 'blocked' : 'unblocked' }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- End Table Responsive -->
                </div>
                

<!-- Add Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-5"> <!-- Increased size for better alignment -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">@lang('app.add_staff')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStaffForm">
                    @csrf
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.first_name') }}</strong></label>
                            <input type="text" name="first_name" class="form-control" placeholder="{{ trans('app.enter_first_name') }}">
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.last_name') }}</strong></label>
                            <input type="text" name="last_name" class="form-control" placeholder="{{ trans('app.enter_last_name') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.email') }} <span class="text-danger">*</span></strong></label>
                            <input type="email" name="email" class="form-control" placeholder="{{ trans('app.email_valid') }}">
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.role') }}<span class="text-danger">*</span></strong></label>
                            <select name="role_id" class="form-select">
                                <option selected disabled>{{ trans('app.please_select') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->uuid }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.password') }} <span class="text-danger">*</span></strong></label>
                            <input type="password" name="password" class="form-control" placeholder="{{ trans('app.enter_password') }}">
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.confirm_password') }} <span class="text-danger">*</span></strong></label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('app.confirm_password') }}">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.status') }} <span class="text-danger">*</span></strong></label>
                            <select name="status" class="form-select">
                                <option value="active">@lang('app.active')</option>
                                <option value="inactive">@lang('app.inactive')</option>
                            </select>                            
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ trans('app.cancel') }}</button>
                <button type="submit" class="btn btn-dark" id="createBtn">{{ trans('app.create') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Staff Modal -->
<div class="modal fade" id="updateStaffModal" tabindex="-1" aria-labelledby="updateStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-5">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStaffModalLabel">{{ trans('app.update_staff') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="staff_id" name="staff_id"> 
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.first_name') }}</strong></label>
                            <input type="text" class="form-control" name="first_name" placeholder="{{ trans('app.enter_first_name') }}">
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.last_name') }}</strong></label>
                            <input type="text" class="form-control" name="last_name" placeholder="{{ trans('app.enter_last_name') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.email') }} <span class="text-danger">*</span></strong></label>
                            <input type="email" class="form-control" name="email" placeholder="{{ trans('app.email_valid') }}">
                        </div>

                        <!-- Role Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.role') }} <span class="text-danger">*</span></strong></label>
                            <select class="form-select" name="role_id">
                                <option selected disabled>{{ trans('app.please_select') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->uuid }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>{{ trans('app.password') }}</strong></label>
                        <div class="password-input-group">
                            <input type="password" name="password" class="form-control" placeholder="{{ trans('app.enter_password') }}" id="updatePassword">
                            <span class="password-toggle" onclick="togglePassword('updatePassword', 'updatePasswordIcon')">
                                <!--<i class="fas fa-eye" id="updatePasswordIcon"></i>-->
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><strong>{{ trans('app.confirm_password') }}</strong></label>
                        <div class="password-input-group">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('app.confirm_password') }}" id="updatePasswordConfirmation">
                            <span class="password-toggle" onclick="togglePassword('updatePasswordConfirmation', 'updatePasswordConfirmationIcon')">
                                <!--<i class="fas fa-eye" id="updatePasswordConfirmationIcon"></i>-->
                            </span>
                        </div>
                    </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><strong>{{ trans('app.status') }} <span class="text-danger">*</span></strong></label>
                            <select id="updateStatus" class="form-select" name="status">
                                <option value="active">@lang('app.active')</option>
                                <option value="inactive">@lang('app.inactive')</option>
                            </select>
                        </div>
                    </div>
                   
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ trans('app.cancel') }}</button>
                <button type="button" class="btn btn-dark" id="editBtn">{{ trans('app.update') }}</button>
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
    var updateStaffRoute = "{{ route('staff.update', ['uuid' => '__UUID__']) }}";
</script>

<script>
    function clearValidationErrors() {
        
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove();
        });
        
     
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
    }

    // Add this function to display validation errors
    function displayValidationErrors(errors, formId) {
        Object.keys(errors).forEach(function(fieldName) {
            const field = document.querySelector(`#${formId} [name="${fieldName}"]`);
            if (field) {
                // Add error styling
                field.classList.add('is-invalid');
                
                // Create error message element
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.style.display = 'block';
                errorDiv.textContent = errors[fieldName][0]; // Show first error message
                
                // Insert error message after the field
                field.parentNode.insertBefore(errorDiv, field.nextSibling);
            }
        });
    }
    
document.getElementById('createBtn').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent actual form submission

    Swal.fire({
        title: "@lang('app.are_you_sure_staff')",
        text: "@lang('app.you_are_about_to_create')",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "@lang('app.yes')",
        cancelButtonText: "@lang('app.cancel')"
    }).then((result) => {
        if (result.isConfirmed) {
            clearValidationErrors();
            let formData = new FormData(document.getElementById('addStaffForm'));
            fetch("{{ route('storeStaff') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                }
            })
            .then(response => {
                if (response.status === 422) {
                    return response.json().then(data => {
                        Swal.close();
                        if (data.errors) {
                            displayValidationErrors(data.errors, 'addStaffForm');
                        }
                        
                        Swal.fire({
                            title: "@lang('app.validation_error')!",
                            text: "@lang('app.please_fix_errors')",
                            icon: "error",
                            confirmButtonColor: "#d33",
                            confirmButtonText: "@lang('app.ok')"
                        });
                        
                        throw new Error('Validation failed');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "@lang('app.success')!",
                        text: "@lang('app.staff_added_successfully')",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "@lang('app.ok')"
                    }).then(() => {
                        location.reload(); // Reload page after success
                    });
                } else {
                    Swal.fire({
                        title: "@lang('app.error')!",
                        text: data.message || "@lang('app.staff_creation_failed')",
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "@lang('app.ok')"
                    });
                }
            })
            .catch(error => {
                if (error.message !== 'Validation failed') {
                    console.error("Error:", error);
                    Swal.fire({
                        title: "@lang('app.error')!",
                        text: "@lang('app.something_went_wrong')",
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "@lang('app.ok')"
                    });
                }
            });
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Clear validation errors when ADD modal is opened (not update modal)
    document.getElementById('addStaffModal').addEventListener('show.bs.modal', function () {
        clearValidationErrors();
        // Reset form
        document.getElementById('addStaffForm').reset();
    });

    // For update modal, only clear validation errors but don't reset form
    document.getElementById('updateStaffModal').addEventListener('show.bs.modal', function () {
        // Only clear validation errors, don't reset form data
        clearValidationErrors();
    });

    // Edit Staff Button Click Handler - This populates the form
    document.querySelectorAll('.editStaffBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Clear any existing validation errors first
            clearValidationErrors();
            
            const staffId = button.getAttribute('data-id');
            const firstName = button.getAttribute('data-first_name') || '';
            const lastName = button.getAttribute('data-last_name') || '';
            const email = button.getAttribute('data-email');
            const role = button.getAttribute('data-role');
            const status = button.getAttribute('data-status');
            const isBlocked = button.getAttribute('data-is_blocked');
            
            // Determine the actual status to show in dropdown
            let displayStatus;
            if (isBlocked === 'blocked') {
                displayStatus = 'blocked';
            } else {
                displayStatus = (status == 1 || status == '1' || status.toLowerCase() === "active") ? "active" : "inactive";
            }

            // Use setTimeout to ensure modal is fully shown before populating
            setTimeout(function() {
                document.getElementById('staff_id').value = staffId;

                const firstNameInput = document.querySelector('#updateStaffModal input[name="first_name"]');
                if (firstNameInput) {
                    firstNameInput.value = firstName;
                    console.log("Set first name:", firstName);
                }

                const lastNameInput = document.querySelector('#updateStaffModal input[name="last_name"]');
                if (lastNameInput) {
                    lastNameInput.value = lastName;
                    console.log("Set last name:", lastName);
                }

                // Set email
                const emailInput = document.querySelector('#updateStaffModal input[name="email"]');
                if (emailInput) {
                    emailInput.value = email;
                }

                // Set role dropdown
                const roleSelect = document.querySelector('#updateStaffModal select[name="role_id"]');
                if (roleSelect) {
                    roleSelect.value = role;
                    console.log("Set role:", role);
                }

                // Set status dropdown with the determined display status
                const statusSelect = document.querySelector('#updateStaffModal select[name="status"]');
                if (statusSelect) {
                    statusSelect.value = displayStatus;
                    console.log("Final selected status in modal:", displayStatus);
                }

                
                const passwordInput = document.querySelector('#updateStaffModal input[name="password"]');
                const confirmPasswordInput = document.querySelector('#updateStaffModal input[name="password_confirmation"]');
                if (passwordInput) passwordInput.value = '';
                if (confirmPasswordInput) confirmPasswordInput.value = '';
            }, 100); 
        });
    });

    // Update button click handler
    document.getElementById('editBtn').addEventListener('click', function(event) {
        event.preventDefault();

        let staffId = document.getElementById("staff_id").value;
        if (!staffId) {
            Swal.fire({
                title: "@lang('app.error')!",
                text: "UUID is missing. Please try again.",
                icon: "error"
            });
            return;
        }

        let formData = new FormData(document.getElementById('updateRoleForm'));
        formData.append("_method", "PUT");

        // Debug: Log form data
        console.log("Form data being sent:");
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        Swal.fire({
            title: "@lang('app.are_you_sure_staff')",
            text: "@lang('app.you_are_about_to_update')",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "@lang('app.yes')",
            cancelButtonText: "@lang('app.cancel')"
        }).then((result) => {
            if (result.isConfirmed) {
                clearValidationErrors();
                
                let updateUrl = updateStaffRoute.replace('__UUID__', staffId);
                console.log("Sending request to:", updateUrl);

                fetch(updateUrl, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    })
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (response.status === 422) {
                            // Handle validation errors
                            return response.json().then(data => {
                                // Close the confirmation dialog first
                                Swal.close();
                                
                                // Display validation errors below fields
                                if (data.errors) {
                                    displayValidationErrors(data.errors, 'updateRoleForm');
                                }
                                
                                // Show general error message
                                Swal.fire({
                                    title: "@lang('app.validation_error')!",
                                    text: "@lang('app.please_fix_errors')",
                                    icon: "error",
                                    confirmButtonColor: "#d33",
                                    confirmButtonText: "@lang('app.ok')"
                                });
                                
                                throw new Error('Validation failed');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data);
                        if (data.success) {
                            Swal.fire({
                                title: "@lang('app.success')!",
                                text: "@lang('app.staff_updated_successfully')",
                                icon: "success"
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                title: "@lang('app.error')!",
                                text: data.message || "@lang('app.staff_update_failed')",
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        if (error.message !== 'Validation failed') {
                            console.error("Error:", error);
                            Swal.fire({
                                title: "@lang('app.error')!",
                                text: "@lang('app.something_went_wrong')",
                                icon: "error"
                            });
                        }
                    });
            }
        });
    });
});







</script>

<script>
$(document).ready(function() {
    $('.unblock-staff-btn').on('click', function() {
        var staffId = $(this).data('staff-id');
        var button = $(this);
        var statusCell = $('#staff-status-cell-' + staffId);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to unblock this admin account?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, unblock it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading indicator
                Swal.fire({
                    title: 'Processing',
                    html: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: "{{ route('admin.unblock', ['admin_id' => ':id']) }}".replace(':id', staffId),
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                            // Update the status cell
                            statusCell.html('<span class="badge bg-success">Active</span>');
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        var errorMessage = 'An error occurred while processing your request.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    });
});
</script>


@endsection
