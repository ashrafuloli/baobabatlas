@extends('backend.layouts.backend')

@section('title', 'Edit User')

@section('content')

    <div class="add-user-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="add-user-page__header">

            <div class="add-user-page__heading">

            <span class="add-user-page__eyebrow">
                USERS / EDIT USER
            </span>

                <h1>
                    Edit User
                </h1>

                <p>
                    Update the user's personal information, access and account settings.
                </p>

            </div>


            <div class="add-user-page__actions">

                <a
                    href="{{ route('user-details', $user->id) }}"
                    class="add-user-back-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to User
                </span>

                </a>

            </div>

        </div>


        {{-- =========================================================
        Validation Errors
        ========================================================== --}}
        @if ($errors->any())

            <div class="add-user-validation-alert">

                <div class="add-user-validation-alert__icon">

                    <i class="ri-error-warning-line"></i>

                </div>

                <div>

                    <strong>
                        Please check the form
                    </strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- =========================================================
        Edit User Form
        ========================================================== --}}
        <form
            action="{{ route('user-update', $user->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="add-user-form"
        >

            @csrf

            @method('PUT')


            <div class="add-user-layout">


                {{-- =================================================
                Main Content
                ================================================== --}}
                <div class="add-user-main">


                    {{-- =================================================
                    Personal Information
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Personal Information
                                </h2>

                                <p>
                                    Update the user's basic personal and contact information.
                                </p>

                            </div>

                            <i class="ri-user-line"></i>

                        </div>


                        <div class="add-user-card__body">

                            <div class="add-user-form-grid">


                                {{-- First Name --}}
                                <div class="add-user-field">

                                    <label for="first_name">
                                        First Name
                                        <span>*</span>
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-user-line"></i>

                                        <input
                                            type="text"
                                            id="first_name"
                                            name="first_name"
                                            value="{{ old('first_name', $user->first_name) }}"
                                            placeholder="Enter first name"
                                            autocomplete="given-name"
                                            maxlength="100"
                                            required
                                        >

                                    </div>

                                    @error('first_name')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- Last Name --}}
                                <div class="add-user-field">

                                    <label for="last_name">
                                        Last Name
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-user-line"></i>

                                        <input
                                            type="text"
                                            id="last_name"
                                            name="last_name"
                                            value="{{ old('last_name', $user->last_name) }}"
                                            placeholder="Enter last name"
                                            autocomplete="family-name"
                                            maxlength="100"
                                        >

                                    </div>

                                    @error('last_name')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- Email --}}
                                <div class="add-user-field">

                                    <label for="email">
                                        Email Address
                                        <span>*</span>
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-mail-line"></i>

                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email', $user->email) }}"
                                            placeholder="user@example.com"
                                            autocomplete="email"
                                            maxlength="255"
                                            required
                                        >

                                    </div>

                                    @error('email')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- Phone --}}
                                <div class="add-user-field">

                                    <label for="phone">
                                        Phone Number
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-phone-line"></i>

                                        <input
                                            type="tel"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone', $user->phone) }}"
                                            placeholder="+224 620 000 000"
                                            autocomplete="tel"
                                            maxlength="30"
                                        >

                                    </div>

                                    @error('phone')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- Address --}}
                                <div class="add-user-field add-user-field--full">

                                    <label for="address">
                                        Address
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-map-pin-line"></i>

                                        <textarea
                                            id="address"
                                            name="address"
                                            rows="4"
                                            placeholder="Enter user's address"
                                        >{{ old('address', $user->address) }}</textarea>

                                    </div>

                                    @error('address')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- Profile Image --}}
                                <div class="add-user-field add-user-field--full">

                                    <label for="profile_image">
                                        Profile Image
                                    </label>


                                    @if($user->profile_image)

                                        <div class="edit-user-current-image">

                                            <div class="edit-user-current-image__preview">

                                                <img
                                                    src="{{ asset($user->profile_image) }}"
                                                    alt="{{ $user->name }}"
                                                >

                                            </div>


                                            <div class="edit-user-current-image__content">

                                                <strong>
                                                    Current Profile Image
                                                </strong>

                                                <small>
                                                    Upload a new image below to replace it.
                                                </small>

                                            </div>

                                        </div>

                                    @endif


                                    <div class="add-user-upload">

                                        <input
                                            type="file"
                                            id="profile_image"
                                            name="profile_image"
                                            accept=".jpg,.jpeg,.png,.webp"
                                        >

                                        <div class="add-user-upload__icon">

                                            <i class="ri-image-add-line"></i>

                                        </div>

                                        <div class="add-user-upload__content">

                                            <strong>
                                                {{ $user->profile_image ? 'Replace Profile Image' : 'Upload Profile Image' }}
                                            </strong>

                                            <small>
                                                JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                            </small>

                                        </div>

                                        <span class="add-user-upload__button">
                                        Choose Image
                                    </span>

                                    </div>

                                    @error('profile_image')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Account Information
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Account Information
                                </h2>

                                <p>
                                    Configure the user's role and account status.
                                </p>

                            </div>

                            <i class="ri-shield-user-line"></i>

                        </div>


                        <div class="add-user-card__body">

                            <div class="add-user-form-grid">


                                {{-- =================================================
                                Single Role
                                ================================================== --}}
                                <div class="add-user-field add-user-field--full">

                                    <label for="role">
                                        User Role
                                    </label>


                                    @php

                                        $currentRoleId = optional(
                                            $user->roles->first()
                                        )->id;

                                        $selectedRoleId = old(
                                            'role',
                                            $currentRoleId
                                        );

                                    @endphp


                                    <div class="add-user-input">

                                        <i class="ri-shield-user-line"></i>

                                        <select
                                            id="role"
                                            name="role"
                                        >

                                            <option value="">
                                                Select role
                                            </option>


                                            @forelse($roles as $role)

                                                <option
                                                    value="{{ $role->id }}"
                                                    {{ (string) $selectedRoleId === (string) $role->id ? 'selected' : '' }}
                                                >
                                                    {{ $role->name }}
                                                </option>

                                            @empty

                                                <option
                                                    value=""
                                                    disabled
                                                >
                                                    No roles available
                                                </option>

                                            @endforelse

                                        </select>

                                        <i class="ri-arrow-down-s-line add-user-select-icon"></i>

                                    </div>


                                    <span class="add-user-field__help">
                                    Select one role for this user.
                                </span>


                                    @error('role')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- =================================================
                                Status
                                ================================================== --}}
                                <div class="add-user-field">

                                    <label for="status">
                                        Account Status
                                        <span>*</span>
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-checkbox-circle-line"></i>

                                        <select
                                            id="status"
                                            name="status"
                                            required
                                        >

                                            <option
                                                value="active"
                                                {{ old('status', $user->status) === 'active' ? 'selected' : '' }}
                                            >
                                                Active
                                            </option>

                                            <option
                                                value="inactive"
                                                {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}
                                            >
                                                Inactive
                                            </option>

                                            <option
                                                value="suspended"
                                                {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}
                                            >
                                                Suspended
                                            </option>

                                        </select>

                                        <i class="ri-arrow-down-s-line add-user-select-icon"></i>

                                    </div>

                                    @error('status')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Change Password
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Change Password
                                </h2>

                                <p>
                                    Leave these fields blank if you do not want to change the password.
                                </p>

                            </div>

                            <i class="ri-lock-password-line"></i>

                        </div>


                        <div class="add-user-card__body">

                            <div class="add-user-form-grid">


                                {{-- New Password --}}
                                <div class="add-user-field">

                                    <label for="password">
                                        New Password
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-lock-2-line"></i>

                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            placeholder="Enter new password"
                                            autocomplete="new-password"
                                        >

                                        <button
                                            type="button"
                                            class="add-user-password-toggle"
                                            data-target="password"
                                            aria-label="Show password"
                                        >

                                            <i class="ri-eye-line"></i>

                                        </button>

                                    </div>

                                    @error('password')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>


                                {{-- Confirm Password --}}
                                <div class="add-user-field">

                                    <label for="password_confirmation">
                                        Confirm Password
                                    </label>

                                    <div class="add-user-input">

                                        <i class="ri-lock-password-line"></i>

                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            placeholder="Confirm new password"
                                            autocomplete="new-password"
                                        >

                                        <button
                                            type="button"
                                            class="add-user-password-toggle"
                                            data-target="password_confirmation"
                                            aria-label="Show password"
                                        >

                                            <i class="ri-eye-line"></i>

                                        </button>

                                    </div>

                                    @error('password_confirmation')

                                    <span class="form-error">
                                        {{ $message }}
                                    </span>

                                    @enderror

                                </div>

                            </div>


                            <div class="add-user-password-info">

                                <i class="ri-shield-check-line"></i>

                                <div>

                                    <strong>
                                        Password security
                                    </strong>

                                    <p>
                                        Leave the password fields empty to keep the current password.
                                        If changing it, use at least 8 characters.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Email Verification
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Email Verification
                                </h2>

                                <p>
                                    Manage the user's email verification status.
                                </p>

                            </div>

                            <i class="ri-mail-check-line"></i>

                        </div>


                        <div class="add-user-card__body">

                            <label class="add-user-checkbox">

                                <input
                                    type="checkbox"
                                    name="email_verified"
                                    value="1"
                                    {{ old('email_verified', $user->email_verified_at ? 1 : 0) ? 'checked' : '' }}
                                >

                                <span class="add-user-checkbox__box">

                                <i class="ri-check-line"></i>

                            </span>

                                <span class="add-user-checkbox__content">

                                <strong>
                                    Mark email as verified
                                </strong>

                                <small>
                                    The user will not be required to verify their email address.
                                </small>

                            </span>

                            </label>

                        </div>

                    </div>


                </div>


                {{-- =================================================
                Sidebar
                ================================================== --}}
                <div class="add-user-sidebar">


                    {{-- =================================================
                    Account Summary
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Account Summary
                                </h2>

                                <p>
                                    Review the current account setup.
                                </p>

                            </div>

                        </div>


                        <div class="add-user-summary">

                            <div class="add-user-summary__item">

                            <span>
                                User
                            </span>

                                <strong>
                                    #{{ $user->id }}
                                </strong>

                            </div>


                            <div class="add-user-summary__item">

                            <span>
                                Role
                            </span>

                                <strong>
                                    {{ $user->roles->first()?->name ?? 'No Role' }}
                                </strong>

                            </div>


                            <div class="add-user-summary__item">

                            <span>
                                Status
                            </span>

                                <strong
                                    id="summary-status"
                                    class="is-{{ $user->status }}"
                                >
                                    {{ ucfirst($user->status) }}
                                </strong>

                            </div>


                            <div class="add-user-summary__item">

                            <span>
                                Email
                            </span>

                                <strong>
                                    {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Assigned Role
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Assigned Role
                                </h2>

                                <p>
                                    The role currently assigned to this user.
                                </p>

                            </div>

                        </div>


                        <div class="add-user-permissions">

                            @if($user->roles->first())

                                <div>

                                <span class="add-user-permission-icon">

                                    <i class="ri-shield-user-line"></i>

                                </span>

                                    <span>
                                    {{ $user->roles->first()->name }}
                                </span>

                                </div>

                            @else

                                <div>

                                <span class="add-user-permission-icon">

                                    <i class="ri-information-line"></i>

                                </span>

                                    <span>
                                    No role assigned
                                </span>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                    User Information
                    ================================================== --}}
                    <div class="add-user-info-box">

                        <div class="add-user-info-box__icon">

                            <i class="ri-information-line"></i>

                        </div>

                        <div>

                            <strong>
                                User account
                            </strong>

                            <p>
                                Changes made here will immediately update the user's
                                account information and portal access.
                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                    Danger Zone
                    ================================================== --}}
                    <div class="edit-user-danger-box">

                        <div class="edit-user-danger-box__icon">

                            <i class="ri-delete-bin-line"></i>

                        </div>

                        <div>

                            <strong>
                                Delete User
                            </strong>

                            <p>
                                Permanently remove this user account.
                            </p>

                        </div>

                        <button
                            type="button"
                            class="edit-user-delete-btn"
                            data-user-id="{{ $user->id }}"
                        >
                            Delete
                        </button>

                    </div>


                </div>

            </div>


            {{-- =================================================
            Form Actions
            ================================================== --}}
            <div class="add-user-form-actions">

                <a
                    href="{{ route('user-details', $user->id) }}"
                    class="add-user-cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="add-user-submit-btn"
                >

                    <i class="ri-save-line"></i>

                    <span>
                    Save Changes
                </span>

                </button>

            </div>

        </form>

    </div>


    {{-- =========================================================
    Page JavaScript
    ========================================================= --}}
    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {


                /*
                |--------------------------------------------------------------------------
                | Password Toggle
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll('.add-user-password-toggle')
                    .forEach(function (button) {

                        button.addEventListener('click', function () {

                            const targetId = this.dataset.target;

                            const input =
                                document.getElementById(targetId);

                            const icon =
                                this.querySelector('i');


                            if (!input || !icon) {
                                return;
                            }


                            if (input.type === 'password') {

                                input.type = 'text';

                                icon.classList.remove(
                                    'ri-eye-line'
                                );

                                icon.classList.add(
                                    'ri-eye-off-line'
                                );

                                this.setAttribute(
                                    'aria-label',
                                    'Hide password'
                                );

                            } else {

                                input.type = 'password';

                                icon.classList.remove(
                                    'ri-eye-off-line'
                                );

                                icon.classList.add(
                                    'ri-eye-line'
                                );

                                this.setAttribute(
                                    'aria-label',
                                    'Show password'
                                );

                            }

                        });

                    });


                /*
                |--------------------------------------------------------------------------
                | Status Summary
                |--------------------------------------------------------------------------
                */

                const statusSelect =
                    document.getElementById('status');

                const statusSummary =
                    document.getElementById('summary-status');


                if (statusSelect && statusSummary) {

                    statusSelect.addEventListener(
                        'change',
                        function () {

                            const statusNames = {

                                active: 'Active',

                                inactive: 'Inactive',

                                suspended: 'Suspended'

                            };


                            statusSummary.textContent =
                                statusNames[this.value] || 'Active';


                            statusSummary.classList.remove(
                                'is-active',
                                'is-inactive',
                                'is-suspended'
                            );


                            statusSummary.classList.add(
                                'is-' + (this.value || 'active')
                            );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Submit Loading State
                |--------------------------------------------------------------------------
                */

                const form =
                    document.querySelector(
                        '.add-user-form'
                    );


                const submitButton =
                    document.querySelector(
                        '.add-user-submit-btn'
                    );


                if (form && submitButton) {

                    form.addEventListener(
                        'submit',
                        function () {

                            submitButton.classList.add(
                                'is-loading'
                            );


                            submitButton.disabled = true;


                            const icon =
                                submitButton.querySelector('i');


                            const text =
                                submitButton.querySelector('span');


                            if (icon) {

                                icon.classList.remove(
                                    'ri-save-line'
                                );

                                icon.classList.add(
                                    'ri-loader-4-line'
                                );

                            }


                            if (text) {

                                text.textContent =
                                    'Saving...';

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Delete User
                |--------------------------------------------------------------------------
                */

                const deleteButton =
                    document.querySelector(
                        '.edit-user-delete-btn'
                    );


                if (deleteButton) {

                    deleteButton.addEventListener(
                        'click',
                        function () {

                            const userId =
                                this.dataset.userId;


                            if (typeof Swal === 'undefined') {

                                if (
                                    confirm(
                                        'Are you sure you want to delete this user?'
                                    )
                                ) {

                                    submitDeleteForm(userId);

                                }

                                return;

                            }


                            Swal.fire({

                                icon: 'warning',

                                title: 'Delete User?',

                                text: 'This action cannot be undone.',

                                showCancelButton: true,

                                confirmButtonText:
                                    'Yes, Delete',

                                cancelButtonText:
                                    'Cancel',

                                reverseButtons: true

                            }).then(function (result) {

                                if (!result.isConfirmed) {
                                    return;
                                }


                                submitDeleteForm(userId);

                            });

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Delete Form
                |--------------------------------------------------------------------------
                */

                function submitDeleteForm(userId) {

                    const form =
                        document.createElement('form');


                    form.method = 'POST';


                    form.action =
                        "{{ url('/portal/users') }}/" +
                        userId;


                    const csrf =
                        document.createElement('input');


                    csrf.type = 'hidden';

                    csrf.name = '_token';

                    csrf.value =
                        "{{ csrf_token() }}";


                    const method =
                        document.createElement('input');


                    method.type = 'hidden';

                    method.name = '_method';

                    method.value = 'DELETE';


                    form.appendChild(csrf);

                    form.appendChild(method);

                    document.body.appendChild(form);

                    form.submit();

                }

            });

        </script>

    @endpush

@endsection
