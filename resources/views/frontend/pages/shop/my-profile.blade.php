@extends('frontend.layouts.frontend')

@section('contents')

    <div class="my-profile-page">

        <div class="container">

            <!--================================
                Page Header
            =================================-->

            <div class="my-profile-page__page-header">

            <span class="my-profile-page__eyebrow">
                MY ACCOUNT
            </span>

                <h1>
                    Profile Settings
                </h1>

                <p>
                    Manage your personal information, profile, and account security.
                </p>

            </div>


            <!--================================
                Profile Overview
            =================================-->

            <div class="my-profile-page__profile-card">

                <div class="my-profile-page__profile-left">

                    <div class="my-profile-page__avatar">

                        <img
                            src="{{ asset('assets/img/products/thumb-1.jpeg') }}"
                            alt="Admin Users"
                        >

                        <button
                            type="button"
                            class="my-profile-page__avatar-camera"
                            aria-label="Change profile photo"
                        >
                            <i class="ri-camera-line"></i>
                        </button>

                    </div>


                    <div class="my-profile-page__profile-info">

                        <h2>
                            Admin Users
                        </h2>

                        <div class="my-profile-page__profile-meta">

                        <span>
                            <i class="ri-mail-line"></i>
                            admin@gmail.com
                        </span>

                            <span>
                            <i class="ri-calendar-line"></i>
                            Member since August 2026
                        </span>

                        </div>

                    </div>

                </div>


                <div class="my-profile-page__photo-action">

                    <button
                        type="button"
                        class="my-profile-page__change-photo"
                    >
                        <i class="ri-image-edit-line"></i>
                        Change Photo
                    </button>

                    <span>
                    JPG, PNG or WEBP · Max 2MB
                </span>

                </div>

            </div>


            <!--================================
                Profile Form
            =================================-->

            <form
                action="#"
                method="POST"
                class="my-profile-page__form"
            >

                @csrf


                <!--================================
                Personal Information
            =================================-->

                <section class="my-profile-page__section-card">

                    <div class="my-profile-page__section-header">

                        <div class="my-profile-page__section-icon">
                            <i class="ri-user-line"></i>
                        </div>

                        <div class="my-profile-page__section-heading">

                            <h2>
                                Personal Information
                            </h2>

                            <p>
                                Update your basic account information.
                            </p>

                        </div>

                    </div>


                    <div class="my-profile-page__section-body">

                        <div class="my-profile-page__form-grid">

                            <!-- First Name -->

                            <div class="my-profile-page__field">

                                <label for="first_name">
                                    First Name
                                    <span>*</span>
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-user-line"></i>

                                    <input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        value="Admin"
                                        placeholder="Enter first name"
                                    >

                                </div>

                            </div>


                            <!-- Last Name -->

                            <div class="my-profile-page__field">

                                <label for="last_name">
                                    Last Name
                                    <span>*</span>
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-user-line"></i>

                                    <input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        value="Users"
                                        placeholder="Enter last name"
                                    >

                                </div>

                            </div>


                            <!-- Email -->

                            <div class="my-profile-page__field">

                                <label for="email">
                                    Email Address
                                    <span>*</span>
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-mail-line"></i>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="admin@gmail.com"
                                        placeholder="Enter email address"
                                    >

                                </div>

                            </div>


                            <!-- Phone -->

                            <div class="my-profile-page__field">

                                <label for="phone">
                                    Phone Number
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-phone-line"></i>

                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        placeholder="Enter phone number"
                                    >

                                </div>

                            </div>


                            <!-- Address -->

                            <div class="my-profile-page__field my-profile-page__field--full">

                                <label for="address">
                                    Address
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-map-pin-line"></i>

                                    <input
                                        type="text"
                                        id="address"
                                        name="address"
                                        placeholder="Enter your address"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                <!--================================
                    Security
                =================================-->

                <section class="my-profile-page__section-card">

                    <div class="my-profile-page__section-header">

                        <div class="my-profile-page__section-icon my-profile-page__section-icon--security">
                            <i class="ri-shield-keyhole-line"></i>
                        </div>

                        <div class="my-profile-page__section-heading">

                            <h2>
                                Security
                            </h2>

                            <p>
                                Update your password to keep your account secure.
                            </p>

                        </div>

                    </div>


                    <div class="my-profile-page__section-body">

                        <div class="my-profile-page__form-grid">

                            <!-- New Password -->

                            <div class="my-profile-page__field">

                                <label for="new_password">
                                    New Password
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-lock-line"></i>

                                    <input
                                        type="password"
                                        id="new_password"
                                        name="new_password"
                                        placeholder="Enter new password"
                                    >

                                    <button
                                        type="button"
                                        class="my-profile-page__password-toggle"
                                        data-password-toggle="new_password"
                                        aria-label="Show password"
                                    >
                                        <i class="ri-eye-line"></i>
                                    </button>

                                </div>

                                <small>
                                    Leave blank if you don't want to change your password.
                                </small>

                            </div>


                            <!-- Confirm Password -->

                            <div class="my-profile-page__field">

                                <label for="confirm_password">
                                    Confirm Password
                                </label>

                                <div class="my-profile-page__input-wrap">

                                    <i class="ri-lock-password-line"></i>

                                    <input
                                        type="password"
                                        id="confirm_password"
                                        name="confirm_password"
                                        placeholder="Confirm new password"
                                    >

                                    <button
                                        type="button"
                                        class="my-profile-page__password-toggle"
                                        data-password-toggle="confirm_password"
                                        aria-label="Show password"
                                    >
                                        <i class="ri-eye-line"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                <!--================================
                    Form Actions
                =================================-->

                <div class="my-profile-page__actions">

                    <button
                        type="button"
                        class="my-profile-page__cancel-btn"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="my-profile-page__save-btn"
                    >
                        <i class="ri-save-line"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        (function () {

            const initMyAccountPage = function () {

                const accountPage =
                    document.querySelector(
                        '.my-profile-page'
                    );

                if (!accountPage) {
                    return;
                }


                /*
                =====================================
                    Password Visibility
                =====================================
                */

                const passwordToggles =
                    accountPage.querySelectorAll(
                        '[data-password-toggle]'
                    );

                passwordToggles.forEach(function (toggle) {

                    toggle.addEventListener(
                        'click',
                        function () {

                            const inputId =
                                toggle.getAttribute(
                                    'data-password-toggle'
                                );

                            const input =
                                accountPage.querySelector(
                                    '#' + inputId
                                );

                            if (!input) {
                                return;
                            }


                            const icon =
                                toggle.querySelector('i');

                            if (
                                input.type === 'password'
                            ) {

                                input.type = 'text';

                                if (icon) {
                                    icon.className =
                                        'ri-eye-off-line';
                                }

                                toggle.setAttribute(
                                    'aria-label',
                                    'Hide password'
                                );

                            } else {

                                input.type = 'password';

                                if (icon) {
                                    icon.className =
                                        'ri-eye-line';
                                }

                                toggle.setAttribute(
                                    'aria-label',
                                    'Show password'
                                );

                            }

                        }
                    );

                });


                /*
                =====================================
                    Change Photo
                =====================================
                */

                const photoButtons =
                    accountPage.querySelectorAll(
                        '.my-profile-page__change-photo, .my-profile-page__avatar-camera'
                    );


                photoButtons.forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            let fileInput =
                                accountPage.querySelector(
                                    '[data-profile-photo-input]'
                                );


                            if (!fileInput) {

                                fileInput =
                                    document.createElement(
                                        'input'
                                    );

                                fileInput.type = 'file';

                                fileInput.accept =
                                    'image/jpeg,image/png,image/webp';

                                fileInput.setAttribute(
                                    'data-profile-photo-input',
                                    ''
                                );

                                fileInput.hidden = true;

                                accountPage.appendChild(
                                    fileInput
                                );


                                fileInput.addEventListener(
                                    'change',
                                    function () {

                                        const file =
                                            fileInput.files[0];

                                        if (!file) {
                                            return;
                                        }


                                        if (
                                            file.size >
                                            2 * 1024 * 1024
                                        ) {

                                            alert(
                                                'Please select an image smaller than 2MB.'
                                            );

                                            fileInput.value =
                                                '';

                                            return;
                                        }


                                        const image =
                                            accountPage.querySelector(
                                                '.my-profile-page__avatar img'
                                            );


                                        if (image) {

                                            const reader =
                                                new FileReader();

                                            reader.onload =
                                                function (event) {

                                                    image.src =
                                                        event.target.result;

                                                };

                                            reader.readAsDataURL(
                                                file
                                            );

                                        }

                                    }
                                );

                            }


                            fileInput.click();

                        }
                    );

                });


                /*
                =====================================
                    Cancel
                =====================================
                */

                const cancelButton =
                    accountPage.querySelector(
                        '.my-profile-page__cancel-btn'
                    );


                if (cancelButton) {

                    cancelButton.addEventListener(
                        'click',
                        function () {

                            window.location.reload();

                        }
                    );

                }

            };


            if (
                document.readyState === 'loading'
            ) {

                document.addEventListener(
                    'DOMContentLoaded',
                    initMyAccountPage
                );

            } else {

                initMyAccountPage();

            }

        })();
    </script>

@endsection
