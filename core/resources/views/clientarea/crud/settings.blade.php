@extends('clientarea.app')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title }} | JPS</title>
<style>
    .card {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .form-control {
        border-radius: 6px;
        padding: 10px 15px;
    }

    .input-group .btn-outline-secondary {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: none;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 6px;
        padding: 10px 24px;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    /* Password input container */
    .password-input-container {
        position: relative;
    }

    .password-input-container .form-control {
        padding-right: 40px;
        /* Space for the eye icon */
    }

    /* Eye icon positioning */
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 2;
        color: #6c757d;
    }

    /* Password validation box styles */
    .password-validation {
        display: none;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px 15px;
        margin-top: 0px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .password-validation p {
        font-weight: 500;
        margin-bottom: 8px;
    }

    .password-validation ul {
        list-style-type: none;
        padding-left: 5px;
        margin-bottom: 0;
    }

    .password-validation li {
        margin-bottom: 3px;
        font-size: 0.85rem;
    }


    input.is-invalid {
        background-image: none !important;
        padding-right: 0.75rem;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .row.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .row.align-items-center>div {
            width: 100%;
        }

        .password-input-container {
            margin-bottom: 1rem;
        }

        .col-md-3.col-12 {
            margin-bottom: 0.5rem;
        }

        /* Ensure eye icon stays properly positioned on mobile */
        .toggle-password {
            right: 10px;
        }
    }
    


</style>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="bi bi-gear me-2"></i>{{ $title }}</h5>
    </div>
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form id="changePasswordForm">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <!-- Old Password Field -->
                            <div class="row form-row my-3">
                                <div class="col-md-3 col-12">
                                    <label for="old_password" class="form-label fw-semibold">
                                        @lang('app.old_password') <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="password-input-container">
                                        <input type="password" id="old_password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            name="old_password" placeholder="@lang('app.enter_old_password')">
                                        <i class="bi bi-eye-slash toggle-password eye-icon2" id="eye-slash"
                                            data-target="old_password"></i>
                                    </div>
                                    @error('old_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="error-message text-danger" id="old-password-error"></div>
                                </div>
                            </div>

                            <!-- New Password Field -->
                            <div class="row form-row my-3">
                                <div class="col-md-3 col-12">
                                    <label for="new_password" class="form-label fw-semibold">
                                        @lang('app.new_password') <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="password-input-container">
                                        <input type="password" id="new_password" class="form-control" name="new_password"
                                            placeholder="@lang('app.enter_new_password')">
                                        <i class="bi bi-eye-slash toggle-password eye-icon2" id="eye-slash"
                                            data-target="new_password"></i>
                                    </div>
                                    <div class="error-message text-danger" id="new-password-error"></div>

                                    <!-- Password Validation Box -->
                                    <div id="password-validation" class="password-validation">
                                        <p>@lang('app.must_contain')</p>
                                        <ul>
                                            <li id="length"><span class="validation-icon">❌</span>
                                                {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20
                                                {{ trans('app.characters') }}</li>
                                            <li id="uppercase"><span class="validation-icon">❌</span>
                                                {{ trans('app.uppercase_letter') }} (A-Z)</li>
                                            <li id="lowercase"><span class="validation-icon">❌</span>
                                                {{ trans('app.lowercase_letter') }} (a-z)</li>
                                            <li id="number"><span class="validation-icon">❌</span>
                                                {{ trans('app.number') }} (0-9)</li>
                                            <li id="noSpaces"><span class="validation-icon">❌</span>
                                                {{ trans('app.no_spaces') }}</li>
                                            <li id="special"><span class="validation-icon">❌</span>
                                                {{ trans('app.special_character') }} (!@#$%)</li>
                                            <li id="noSequential"><span class="validation-icon">❌</span>
                                                {{ trans('app.no_sequential_characters') }} (abc, 123)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="row form-row my-3">
                                <div class="col-md-3 col-12">
                                    <label for="new_password_confirmation" class="form-label fw-semibold">
                                        @lang('app.new_password_confirmation') <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="password-input-container">
                                        <input type="password" id="new_password_confirmation" class="form-control"
                                            name="new_password_confirmation" placeholder="@lang('app.confirm_new_password')">
                                        <i class="bi bi-eye-slash toggle-password eye-icon2" id="eye-slash"
                                            data-target="new_password_confirmation"></i>
                                    </div>
                                    <div class="error-message text-danger" id="confirm-password-error"></div>
                                    <div class="error-message" id="password-match-error"></div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12 col-12 mt-2 mt-md-0">
                                    <span class="text-muted small">
                                        <i class="bi bi-info-circle me-1"></i>
                                        @lang('app.please_confirm_the_new_password_for_verification')
                                    </span>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="bi bi-save me-2"></i>@lang('app.update_password')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Load jQuery First -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('.toggle-password').on('click', function() {
                const targetId = $(this).data('target');
                const input = $('#' + targetId);
                const type = input.attr('type') === 'password' ? 'text' : 'password';

                input.attr('type', type);
                $(this).toggleClass('bi-eye bi-eye-slash');
            });

            // Password validation functionality
            let passwordInput = document.getElementById("new_password");
            let confirmPasswordInput = document.getElementById("new_password_confirmation");
            let validationBox = document.getElementById("password-validation");
            $('#password-validation').hide(); // Ensure it's hidden on page load

            if (passwordInput) {
                // Show/hide validation box based on typing
                passwordInput.addEventListener("input", function() {
                    let pwdValue = passwordInput.value.trim();
                    if (pwdValue.length > 0) {
                        validationBox.style.display = "block";
                    } else {
                        validationBox.style.display = "none";
                    }

                    validatePassword();
                    matchPasswords();
                });

                // Hide validation box when input loses focus (after short delay to allow click on box if needed)
                passwordInput.addEventListener("blur", function() {
                    setTimeout(() => {
                        validationBox.style.display = "none";
                    }, 150);
                });

                // Keep showing it if user clicks on the validation box
                validationBox.addEventListener("mousedown", function(e) {
                    e.preventDefault(); // Prevent blur from hiding box
                });
            }

            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener("input", matchPasswords);
            }
        });

        function validatePassword() {
            let password = document.getElementById("new_password").value;

            let length = document.getElementById("length");
            let uppercase = document.getElementById("uppercase");
            let lowercase = document.getElementById("lowercase");
            let number = document.getElementById("number");
            let noSpaces = document.getElementById("noSpaces");
            let special = document.getElementById("special");
            let noSequential = document.getElementById("noSequential");

            // Check conditions
            let checks = {
                length: password.length >= 8 && password.length <= 20,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                noSpaces: !/\s/.test(password),
                specialChar: /[!@#$%]/.test(password),
                noSequential: !
                    /(?:012|123|234|345|456|567|678|789|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i
                    .test(password),
            };

            // Update UI
            length.innerHTML = (checks.length ? "✅" : "❌") +
                " {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20 {{ trans('app.characters') }}";
            uppercase.innerHTML = (checks.uppercase ? "✅" : "❌") + " {{ trans('app.uppercase_letter') }} (A-Z)";
            lowercase.innerHTML = (checks.lowercase ? "✅" : "❌") + " {{ trans('app.lowercase_letter') }} (a-z)";
            number.innerHTML = (checks.number ? "✅" : "❌") + " {{ trans('app.number') }} (0-9)";
            noSpaces.innerHTML = (checks.noSpaces ? "✅" : "❌") + " {{ trans('app.no_spaces') }}";
            special.innerHTML = (checks.specialChar ? "✅" : "❌") + " {{ trans('app.special_character') }} (!@#$%)";
            noSequential.innerHTML = (checks.noSequential ? "✅" : "❌") +
                " {{ trans('app.no_sequential_characters') }} (abc, 123)";
        }

        function matchPasswords() {
            let password = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("new_password_confirmation").value;
            let matchError = document.getElementById("password-match-error");

            if (confirmPassword === "") {
                matchError.innerHTML = "";
            } else if (password !== confirmPassword) {
                matchError.innerHTML = "❌ {{ trans('app.passwords_do_not_match') }}";
                matchError.style.color = "red";
            } else {
                matchError.innerHTML = "✅ {{ trans('app.passwords_match') }}";
                matchError.style.color = "green";
            }
        }

        $(document).ready(function() {
            const messages = {
                success: 'Kata laluan berjaya dikemas kini',
                wrongOldPassword: 'Kata laluan lama salah',
                validationTitle: 'Medan kosong',
                defaultError: 'Sesuatu telah berlaku',
                passwordsNotMatch: 'Kata laluan tidak sepadan',
                fillRequiredFields: 'Isi medan yang diperlukan',
                confirmTitle: 'Adakah anda pasti',
                confirmText: '',
                confirmButton: 'Ya',
                cancelButton: 'Batal',
                accountLocked: 'Account locked',
                accountLockedMaxAttempts: 'Account locked. Maximum attempts reached. Try again in 30 minutes.',
                wrongPasswordTitle: 'Kata laluan salah',
                hideSuccess: false,
                hideWrongOldPassword: false,
                hideValidationErrors: false,
                hideDefaultError: false
            };

            const inputFields = ['#old_password', '#new_password', '#new_password_confirmation'];
            const fieldLabels = {
                'old_password': '@lang('app.old_password')',
                'new_password': '@lang('app.new_password')',
                'new_password_confirmation': '@lang('app.new_password_confirmation')'
            };

            // Check if account is locked on page load
            const isLocked = {{ $isLocked ? 'true' : 'false' }};
            const remainingTime = {{ $remainingTime ?? 'null' }};

            if (isLocked && remainingTime) {
                disableForm();
                showLockoutMessage(remainingTime);
            }

            function disableForm() {
                $('#changePasswordForm input').prop('disabled', true);
                $('#changePasswordForm button[type="submit"]').prop('disabled', true);
            }

            function enableForm() {
                $('#changePasswordForm input').prop('disabled', false);
                $('#changePasswordForm button[type="submit"]').prop('disabled', false);
            }

            function showLockoutMessage(minutes) {
                if ($('#lockout-message').length === 0) {
                    $('#changePasswordForm').prepend(
                        `<div id="lockout-message" class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                @lang('app.account_locked', ['minutes' => '${minutes}'])
            </div>`
                    );
                }
            }

            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault();
                inputFields.forEach(field => $(field).removeClass('is-invalid'));

                let formData = {
                    old_password: $('#old_password').val().trim(),
                    new_password: $('#new_password').val().trim(),
                    new_password_confirmation: $('#new_password_confirmation').val().trim(),
                };

                let emptyFields = [];
                Object.entries(formData).forEach(([key, value]) => {
                    if (!value) {
                        $(`#${key}`).addClass('is-invalid');
                        emptyFields.push(key);
                    }
                });

                if (formData.new_password && formData.new_password_confirmation &&
                    formData.new_password !== formData.new_password_confirmation) {
                    $('#new_password_confirmation').addClass('is-invalid');
                    if (!messages.hideValidationErrors) {
                        Swal.fire({
                            icon: 'warning',
                            title: messages.validationTitle,
                            text: messages.passwordsNotMatch,
                        });
                    }
                    return;
                }

                // Handle empty fields
                if (emptyFields.length > 0) {
                    let errorMessage;

                    if (emptyFields.length === Object.keys(formData).length) {
                        errorMessage = messages.fillRequiredFields;
                    } else {
                        // Some fields are empty - list them
                        const fieldNames = emptyFields.map(field => {
                            return `<b>${fieldLabels[field] || field}</b>`;
                        }).join(', ');

                        errorMessage = `@lang('app.please_fill') ${fieldNames}`;
                    }

                    Swal.fire({
                        icon: 'warning',
                        title: messages.validationTitle,
                        html: errorMessage,
                    });
                    return;
                }

                // Confirm before proceeding
                Swal.fire({
                    icon: 'question',
                    title: messages.confirmTitle,
                    text: messages.confirmText,
                    showCancelButton: true,
                    confirmButtonText: messages.confirmButton,
                    cancelButtonText: messages.cancelButton,
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('settings.change-password', $client->client_id) }}",
                            method: "POST",
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (!messages.hideSuccess) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '@lang('app.success')',
                                        text: messages.success,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    location.reload();
                                }

                                $('#changePasswordForm')[0].reset();
                                inputFields.forEach(field => $(field).removeClass(
                                    'is-invalid'));
                            },
                            error: function(xhr) {
                                handleErrorResponse(xhr);
                            }
                        });
                    }
                });
            });

            // Comprehensive error handler based on the backend responses
            function handleErrorResponse(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;

                    // Handle errors related to old_password specifically
                    if (errors.old_password && errors.old_password.length > 0) {
                        const errorMsg = errors.old_password[0];

                        // Case: Account completely blocked or temporarily locked
                        if (errorMsg.includes('@lang('app.account_locked')') ||
                            errorMsg.includes('account locked') ||
                            errorMsg.includes('account has been temporarily locked') ||
                            errorMsg.includes('account has been blocked you have reached maximum attempt')) {

                            // Extract minutes from the error message if available
                            let minutesMatch = errorMsg.match(/(\d+)\s*(?:minute|min)/i);
                            let minutes = minutesMatch ? minutesMatch[1] : 30;

                            disableForm();
                            showLockoutMessage(minutes);

                            Swal.fire({
                                icon: 'error',
                                title: 'Account has been blocked',
                                text: errorMsg,
                                confirmButtonText: 'ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    logoutUser();
                                }
                            });

                            return;
                        }

                        // Case: Wrong password with attempts remaining (matches your backend response pattern)
                        if (errorMsg.includes('@lang('app.old_password_incorrect')') ||
                            errorMsg.includes('attempts remaining')) {

                            $('#old_password').addClass('is-invalid');

                            Swal.fire({
                                icon: 'error',
                                title: messages.wrongPasswordTitle,
                                html: errorMsg,
                            });

                            return;
                        }
                    }

                    // Handle other validation errors
                    let errorList = '';
                    Object.entries(errors).forEach(([field, messagesArr]) => {
                        // Skip old_password as it was handled above
                        if (field !== 'old_password') {
                            $(`#${field}`).addClass('is-invalid');
                            messagesArr.forEach(msg => {
                                errorList += `<div>${msg}</div>`;
                            });
                        }
                    });

                    if (errorList) {
                        Swal.fire({
                            icon: 'warning',
                            title: messages.validationTitle,
                            html: errorList,
                        });
                    }
                } else {
                    // Handle general server errors
                    if (!messages.hideDefaultError) {
                        Swal.fire({
                            icon: 'error',
                            title: '@lang('app.oops')',
                            text: messages.defaultError,
                        });
                    }
                }
            }

            // Helper function to logout user
            function logoutUser() {
                $.ajax({
                    url: '/clientarea/logout',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        window.location.href = '/clientarea/login';
                    },
                    error: function() {
                        window.location.href = '/clientarea/login';
                    }
                });
            }
        });
    </script>
@endsection
