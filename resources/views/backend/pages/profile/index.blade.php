@extends('backend.layouts.backend')

@section('title', 'Profile Settings')

@section('content')

    <section class="profile-settings">

        {{--=================================
        Page Header
        =================================--}}
        <div class="profile-settings__header">

            <div class="profile-settings__heading">

                <span class="profile-settings__eyebrow">
                    My Account
                </span>

                <h1>
                    Profile Settings
                </h1>

                <p>
                    Manage your personal information, profile, and account security.
                </p>

            </div>

        </div>


        <form
            action="{{ route('profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="profile-settings__form"
        >

            @csrf

            @method('PUT')


            {{--=================================
            Profile Summary
            =================================--}}
            <div class="profile-card profile-summary">

                <div class="profile-summary__user">

                    <div class="profile-avatar">

                        <img
                            id="profilePreview"
                            src="{{ $user->profile_image ? asset($user->profile_image) : asset('backend/images/default-avatar.png') }}"
                            alt="{{ $user->first_name ?? 'User' }}"
                        >

                        <button
                            type="button"
                            class="profile-avatar__edit"
                            id="profilePhotoTrigger"
                            aria-label="Change profile photo"
                        >

                            <i class="ri-camera-line"></i>

                        </button>

                    </div>


                    <div class="profile-summary__info">

                        <h2>
                            {{ $user->first_name }}
                            {{ $user->last_name }}
                        </h2>


                        <div class="profile-summary__meta">

                            <span>

                                <i class="ri-mail-line"></i>

                                {{ $user->email }}

                            </span>


                            <span>

                                <i class="ri-calendar-line"></i>

                                Member since
                                {{ optional($user->created_at)->format('F Y') }}

                            </span>

                        </div>

                    </div>

                </div>


                <div class="profile-summary__action">

                    <input
                        type="file"
                        id="profilePhoto"
                        name="profile_image"
                        accept=".jpg,.jpeg,.png,.webp"
                        hidden
                    >


                    <button
                        type="button"
                        class="btn btn--primary"
                        id="profilePhotoButton"
                    >

                        <i class="ri-image-edit-line"></i>

                        <span>
                            Change Photo
                        </span>

                    </button>


                    <small>
                        JPG, PNG or WEBP · Max 2MB
                    </small>

                </div>

            </div>


            {{--=================================
            Personal Information
            =================================--}}
            <div class="profile-card">

                <div class="profile-card__header">

                    <div class="section-icon">

                        <i class="ri-user-line"></i>

                    </div>


                    <div>

                        <h2>
                            Personal Information
                        </h2>

                        <p>
                            Update your basic account information.
                        </p>

                    </div>

                </div>


                <div class="profile-card__body">

                    <div class="profile-form-grid">


                        {{-- First Name --}}
                        <div class="form-group">

                            <label for="first_name">

                                First Name

                                <span>*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="ri-user-line"></i>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    placeholder="Enter first name"
                                    autocomplete="given-name"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Last Name --}}
                        <div class="form-group">

                            <label for="last_name">

                                Last Name

                                <span>*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="ri-user-line"></i>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    placeholder="Enter last name"
                                    autocomplete="family-name"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="form-group">

                            <label for="email">

                                Email Address

                                <span>*</span>

                            </label>


                            <div class="input-wrapper">

                                <i class="ri-mail-line"></i>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="Enter email address"
                                    autocomplete="email"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="form-group">

                            <label for="phone">

                                Phone Number

                            </label>


                            <div class="input-wrapper">

                                <i class="ri-phone-line"></i>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="Enter phone number"
                                    autocomplete="tel"
                                >

                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="form-group form-group--full">

                            <label for="address">

                                Address

                            </label>


                            <div class="input-wrapper">

                                <i class="ri-map-pin-line"></i>

                                <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    value="{{ old('address', $user->address) }}"
                                    placeholder="Enter your address"
                                    autocomplete="street-address"
                                >

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{--=================================
            Security
            =================================--}}
            <div class="profile-card">

                <div class="profile-card__header">

                    <div class="section-icon section-icon--security">

                        <i class="ri-shield-keyhole-line"></i>

                    </div>


                    <div>

                        <h2>
                            Security
                        </h2>

                        <p>
                            Update your password to keep your account secure.
                        </p>

                    </div>

                </div>


                <div class="profile-card__body">

                    <div class="profile-form-grid">


                        {{-- New Password --}}
                        <div class="form-group">

                            <label for="password">

                                New Password

                            </label>


                            <div class="input-wrapper input-wrapper--password">

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
                                    class="password-toggle"
                                    data-target="password"
                                    aria-label="Show password"
                                >

                                    <i class="ri-eye-line"></i>

                                </button>

                            </div>


                            <span class="form-help">

                                Leave blank if you don't want to change your password.

                            </span>

                        </div>


                        {{-- Confirm Password --}}
                        <div class="form-group">

                            <label for="password_confirmation">

                                Confirm Password

                            </label>


                            <div class="input-wrapper input-wrapper--password">

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
                                    class="password-toggle"
                                    data-target="password_confirmation"
                                    aria-label="Show password"
                                >

                                    <i class="ri-eye-line"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{--=================================
            Form Actions
            =================================--}}
            <div class="profile-settings__actions">

                <a
                    href="{{ url()->previous() }}"
                    class="btn btn--secondary"
                >

                    Cancel

                </a>


                <button
                    type="submit"
                    class="btn btn--primary"
                >

                    <i class="ri-save-line"></i>

                    <span>
                        Save Changes
                    </span>

                </button>

            </div>

        </form>

    </section>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            =================================
            Profile Photo
            =================================
            */

            const photoInput =
                document.getElementById('profilePhoto');

            const photoButton =
                document.getElementById('profilePhotoButton');

            const photoTrigger =
                document.getElementById('profilePhotoTrigger');

            const profilePreview =
                document.getElementById('profilePreview');


            function openPhotoPicker() {

                if (photoInput) {

                    photoInput.click();

                }

            }


            if (photoButton) {

                photoButton.addEventListener(
                    'click',
                    openPhotoPicker
                );

            }


            if (photoTrigger) {

                photoTrigger.addEventListener(
                    'click',
                    openPhotoPicker
                );

            }


            if (photoInput) {

                photoInput.addEventListener(
                    'change',
                    function () {

                        const file =
                            this.files[0];


                        if (!file) {

                            return;

                        }


                        if (
                            file.size >
                            2 * 1024 * 1024
                        ) {

                            this.value = '';

                            return;

                        }


                        const reader =
                            new FileReader();


                        reader.onload =
                            function (event) {

                                if (profilePreview) {

                                    profilePreview.src =
                                        event.target.result;

                                }

                            };


                        reader.readAsDataURL(file);

                    }
                );

            }


            /*
            =================================
            Password Toggle
            =================================
            */

            const passwordToggles =
                document.querySelectorAll(
                    '.password-toggle'
                );


            passwordToggles.forEach(
                function (toggle) {

                    toggle.addEventListener(
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


                            if (!input) {

                                return;

                            }


                            if (
                                input.type ===
                                'password'
                            ) {

                                input.type =
                                    'text';


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

                                input.type =
                                    'password';


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

        });

    </script>

@endpush
