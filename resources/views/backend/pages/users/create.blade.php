@extends('backend.layouts.backend')

@section('title', 'Add User')

@section('content')

    <div class="add-user-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="add-user-page__header">

            <div class="add-user-page__heading">

            <span class="add-user-page__eyebrow">
                USERS / ADD USER
            </span>

                <h1>
                    Add New User
                </h1>

                <p>
                    Create a new user account and configure their access.
                </p>

            </div>


            <div class="add-user-page__actions">

                <a
                    href="{{ route('users') }}"
                    class="add-user-back-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to Users
                </span>

                </a>

            </div>

        </div>


        {{-- =========================================================
        Create User Form
        ========================================================== --}}
        <form
            action="{{ route('user-store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="add-user-form"
        >

            @csrf


            <div class="add-user-layout">


                {{-- =====================================================
                Main Content
                ====================================================== --}}
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
                                    Enter the user's basic personal and contact information.
                                </p>

                            </div>

                            <i class="ri-user-line"></i>

                        </div>


                        <div class="add-user-card__body">

                            <div class="add-user-form-grid">


                                {{-- =================================================
                                First Name
                                ================================================== --}}
                                <div class="add-user-field">

                                    <label for="first_name">

                                        First Name

                                        <span>
                                        *
                                    </span>

                                    </label>


                                    <div class="add-user-input">

                                        <i class="ri-user-line"></i>

                                        <input
                                            type="text"
                                            id="first_name"
                                            name="first_name"
                                            value="{{ old('first_name') }}"
                                            placeholder="Enter first name"
                                            autocomplete="given-name"
                                            maxlength="100"
                                            autofocus
                                            required
                                        >

                                    </div>

                                </div>


                                {{-- =================================================
                                Last Name
                                ================================================== --}}
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
                                            value="{{ old('last_name') }}"
                                            placeholder="Enter last name"
                                            autocomplete="family-name"
                                            maxlength="100"
                                        >

                                    </div>

                                </div>


                                {{-- =================================================
                                Email
                                ================================================== --}}
                                <div class="add-user-field">

                                    <label for="email">

                                        Email Address

                                        <span>
                                        *
                                    </span>

                                    </label>


                                    <div class="add-user-input">

                                        <i class="ri-mail-line"></i>

                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="user@example.com"
                                            autocomplete="email"
                                            maxlength="255"
                                            required
                                        >

                                    </div>

                                </div>


                                {{-- =================================================
                                Phone
                                ================================================== --}}
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
                                            value="{{ old('phone') }}"
                                            placeholder="+224 620 000 000"
                                            autocomplete="tel"
                                            maxlength="30"
                                        >

                                    </div>

                                </div>


                                {{-- =================================================
                                Address
                                ================================================== --}}
                                <div class="add-user-field add-user-field--full">

                                    <label for="address">
                                        Address
                                    </label>


                                    <div class="add-user-input add-user-input--textarea">

                                        <i class="ri-map-pin-line"></i>

                                        <textarea
                                            id="address"
                                            name="address"
                                            rows="4"
                                            placeholder="Enter user's address"
                                        >{{ old('address') }}</textarea>

                                    </div>

                                </div>


                                {{-- =================================================
                                Profile Image
                                ================================================== --}}
                                <div class="add-user-field add-user-field--full">

                                    <label for="profile_image">
                                        Profile Image
                                    </label>


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
                                                Upload Profile Image
                                            </strong>

                                            <small>
                                                JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                            </small>

                                        </div>


                                        <span class="add-user-upload__button">
                                        Choose Image
                                    </span>

                                    </div>

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
                                User Role
                                ================================================== --}}
                                <div class="add-user-field add-user-field--full">

                                    <label for="role">

                                        User Role

                                        <span>
                                        *
                                    </span>

                                    </label>


                                    <div class="add-user-input">

                                        <i class="ri-shield-user-line"></i>

                                        <select
                                            id="role"
                                            name="role"
                                            required
                                        >

                                            <option value="">
                                                Select Role
                                            </option>

                                            @forelse($roles as $role)

                                                <option
                                                    value="{{ $role->id }}"
                                                    {{ (string) old('role') === (string) $role->id ? 'selected' : '' }}
                                                >
                                                    {{ $role->name }}
                                                </option>

                                            @empty

                                                <option value="" disabled>
                                                    No roles available
                                                </option>

                                            @endforelse

                                        </select>

                                        <i class="ri-arrow-down-s-line add-user-select-icon"></i>

                                    </div>


                                    <p class="add-user-field__help">
                                        Select one role for this user.
                                    </p>

                                </div>


                                {{-- =================================================
                                Account Status
                                ================================================== --}}
                                <div class="add-user-field">

                                    <label for="status">

                                        Account Status

                                        <span>
                                        *
                                    </span>

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
                                                {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                                            >
                                                Active
                                            </option>

                                            <option
                                                value="inactive"
                                                {{ old('status') === 'inactive' ? 'selected' : '' }}
                                            >
                                                Inactive
                                            </option>

                                            <option
                                                value="suspended"
                                                {{ old('status') === 'suspended' ? 'selected' : '' }}
                                            >
                                                Suspended
                                            </option>

                                        </select>

                                        <i class="ri-arrow-down-s-line add-user-select-icon"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Login Credentials
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Login Credentials
                                </h2>

                                <p>
                                    Set the password the user will use to access the portal.
                                </p>

                            </div>

                            <i class="ri-lock-password-line"></i>

                        </div>


                        <div class="add-user-card__body">

                            <div class="add-user-form-grid">


                                {{-- =================================================
                                Password
                                ================================================== --}}
                                <div class="add-user-field">

                                    <label for="password">

                                        Password

                                        <span>
                                        *
                                    </span>

                                    </label>


                                    <div class="add-user-input">

                                        <i class="ri-lock-2-line"></i>

                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            placeholder="Create a secure password"
                                            autocomplete="new-password"
                                            minlength="8"
                                            required
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

                                </div>


                                {{-- =================================================
                                Confirm Password
                                ================================================== --}}
                                <div class="add-user-field">

                                    <label for="password_confirmation">

                                        Confirm Password

                                        <span>
                                        *
                                    </span>

                                    </label>


                                    <div class="add-user-input">

                                        <i class="ri-lock-password-line"></i>

                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            placeholder="Confirm password"
                                            autocomplete="new-password"
                                            minlength="8"
                                            required
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

                                </div>

                            </div>


                            {{-- =================================================
                            Password Information
                            ================================================== --}}
                            <div class="add-user-password-info">

                                <i class="ri-shield-check-line"></i>

                                <div>

                                    <strong>
                                        Keep the account secure
                                    </strong>

                                    <p>
                                        Use at least 8 characters with a combination
                                        of letters, numbers and special characters.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                Sidebar
                ====================================================== --}}
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
                                    Review the account setup.
                                </p>

                            </div>

                        </div>


                        <div class="add-user-summary">


                            {{-- Role --}}
                            <div class="add-user-summary__item">

                            <span>
                                Role
                            </span>

                                <strong id="summary-role">
                                    No Role Selected
                                </strong>

                            </div>


                            {{-- Status --}}
                            <div class="add-user-summary__item">

                            <span>
                                Status
                            </span>

                                <strong
                                    id="summary-status"
                                    class="is-active"
                                >
                                    Active
                                </strong>

                            </div>


                            {{-- Portal --}}
                            <div class="add-user-summary__item">

                            <span>
                                Portal
                            </span>

                                <strong>
                                    Enabled
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Role Information
                    ================================================== --}}
                    <div class="add-user-card">

                        <div class="add-user-card__header">

                            <div>

                                <h2>
                                    Role Information
                                </h2>

                                <p>
                                    Access depends on the selected role.
                                </p>

                            </div>

                        </div>


                        <div class="add-user-permissions">

                            <div>

                            <span class="add-user-permission-icon">
                                <i class="ri-check-line"></i>
                            </span>

                                <span>
                                Dashboard Access
                            </span>

                            </div>


                            <div>

                            <span class="add-user-permission-icon">
                                <i class="ri-check-line"></i>
                            </span>

                                <span>
                                Profile Management
                            </span>

                            </div>


                            <div>

                            <span class="add-user-permission-icon">
                                <i class="ri-check-line"></i>
                            </span>

                                <span>
                                Role Based Access
                            </span>

                            </div>


                            <div>

                            <span class="add-user-permission-icon">
                                <i class="ri-check-line"></i>
                            </span>

                                <span>
                                System Permissions
                            </span>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Info Box
                    ================================================== --}}
                    <div class="add-user-info-box">

                        <div class="add-user-info-box__icon">

                            <i class="ri-information-line"></i>

                        </div>


                        <div>

                            <strong>
                                New user account
                            </strong>

                            <p>
                                The user's access will be controlled by their
                                assigned role and account status.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            Form Actions
            ========================================================== --}}
            <div class="add-user-form-actions">

                <a
                    href="{{ route('users') }}"
                    class="add-user-cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="add-user-submit-btn"
                >

                    <i class="ri-user-add-line"></i>

                    <span>
                    Create User
                </span>

                </button>

            </div>

        </form>

    </div>


    {{-- =============================================================
    Page JavaScript
    ============================================================= --}}
    @push('scripts')

        <script>

            document.addEventListener(
                'DOMContentLoaded',
                function () {


                    /*
                    |--------------------------------------------------------------------------
                    | Password Toggle
                    |--------------------------------------------------------------------------
                    */

                    document
                        .querySelectorAll(
                            '.add-user-password-toggle'
                        )
                        .forEach(
                            function (button) {

                                button.addEventListener(
                                    'click',
                                    function () {

                                        const targetId =
                                            this.dataset.target;

                                        const input =
                                            document.getElementById(
                                                targetId
                                            );

                                        const icon =
                                            this.querySelector('i');


                                        if (!input || !icon) {
                                            return;
                                        }


                                        if (
                                            input.type === 'password'
                                        ) {

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

                                    }
                                );

                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Role Summary
                    |--------------------------------------------------------------------------
                    */

                    const roleSelect =
                        document.getElementById('role');

                    const roleSummary =
                        document.getElementById('summary-role');


                    if (
                        roleSelect &&
                        roleSummary
                    ) {

                        function updateRoleSummary() {

                            const selectedOption =
                                roleSelect.options[
                                    roleSelect.selectedIndex
                                    ];


                            if (
                                roleSelect.value &&
                                selectedOption
                            ) {

                                roleSummary.textContent =
                                    selectedOption.textContent.trim();

                            } else {

                                roleSummary.textContent =
                                    'No Role Selected';

                            }

                        }


                        roleSelect.addEventListener(
                            'change',
                            updateRoleSummary
                        );


                        updateRoleSummary();

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Status Summary
                    |--------------------------------------------------------------------------
                    */

                    const statusSelect =
                        document.getElementById('status');

                    const statusSummary =
                        document.getElementById('summary-status');


                    if (
                        statusSelect &&
                        statusSummary
                    ) {

                        const statusNames = {

                            active: 'Active',

                            inactive: 'Inactive',

                            suspended: 'Suspended'

                        };


                        function updateStatusSummary() {

                            const status =
                                statusSelect.value || 'active';


                            statusSummary.textContent =
                                statusNames[status] || 'Active';


                            statusSummary.classList.remove(
                                'is-active',
                                'is-inactive',
                                'is-suspended'
                            );


                            statusSummary.classList.add(
                                'is-' + status
                            );

                        }


                        statusSelect.addEventListener(
                            'change',
                            updateStatusSummary
                        );


                        updateStatusSummary();

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Profile Image File Name
                    |--------------------------------------------------------------------------
                    */

                    const imageInput =
                        document.getElementById(
                            'profile_image'
                        );


                    if (imageInput) {

                        imageInput.addEventListener(
                            'change',
                            function () {

                                const uploadContent =
                                    document.querySelector(
                                        '.add-user-upload__content'
                                    );


                                if (!uploadContent) {
                                    return;
                                }


                                const file =
                                    this.files[0];


                                if (!file) {
                                    return;
                                }


                                const strong =
                                    uploadContent.querySelector(
                                        'strong'
                                    );


                                const small =
                                    uploadContent.querySelector(
                                        'small'
                                    );


                                if (strong) {

                                    strong.textContent =
                                        file.name;

                                }


                                if (small) {

                                    small.textContent =
                                        'Selected profile image';

                                }

                            }
                        );

                    }

                }
            );

        </script>

    @endpush

@endsection
