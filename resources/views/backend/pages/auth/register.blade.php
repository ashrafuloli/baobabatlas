@extends('backend.layouts.auth')

@section('title', 'Create Account')

@section('content')

    <section class="register-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-7 col-lg-8 col-md-10">

                    <div class="register-card">


                        {{--=================================
                        Card Header
                        =================================--}}
                        <div class="card-header">

                            <div class="card-logo">

                                <a href="{{ route('home') }}">

                                    <img
                                        src="{{ asset('logo.png') }}"
                                        alt="Baobab Atlas"
                                    >

                                </a>

                            </div>


                            <h2>
                                Create Account
                            </h2>


                            <p>
                                Create your account to manage shipments, services,
                                and marketplace orders.
                            </p>

                        </div>


                        {{--=================================
                        Registration Form
                        =================================--}}
                        <form
                            class="register-form"
                            action="{{ route('register.submit') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf


                            <div class="row g-3">


                                {{--=================================
                                First Name
                                =================================--}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="first_name">
                                            First Name
                                        </label>


                                        <div class="input-group">

                                            <i class="ri-user-line"></i>

                                            <input
                                                type="text"
                                                id="first_name"
                                                name="first_name"
                                                value="{{ old('first_name') }}"
                                                placeholder="Enter first name"
                                                autocomplete="given-name"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{--=================================
                                Last Name
                                =================================--}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="last_name">

                                            Last Name

                                            <span class="optional">
                                            Optional
                                        </span>

                                        </label>


                                        <div class="input-group">

                                            <i class="ri-user-line"></i>

                                            <input
                                                type="text"
                                                id="last_name"
                                                name="last_name"
                                                value="{{ old('last_name') }}"
                                                placeholder="Enter last name"
                                                autocomplete="family-name"
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{--=================================
                                Email
                                =================================--}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="email">
                                            Email Address
                                        </label>


                                        <div class="input-group">

                                            <i class="ri-mail-line"></i>

                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                placeholder="Enter email address"
                                                autocomplete="email"
                                                required
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{--=================================
                                Phone
                                =================================--}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="phone">

                                            Phone Number

                                            <span class="optional">
                                            Optional
                                        </span>

                                        </label>


                                        <div class="input-group">

                                            <i class="ri-phone-line"></i>

                                            <input
                                                type="tel"
                                                id="phone"
                                                name="phone"
                                                value="{{ old('phone') }}"
                                                placeholder="Enter phone number"
                                                autocomplete="tel"
                                            >

                                        </div>

                                    </div>

                                </div>


                                {{--=================================
                                Password
                                =================================--}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="password">
                                            Password
                                        </label>


                                        <div class="input-group input-group--password">

                                            <i class="ri-lock-2-line"></i>

                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                placeholder="Create a password"
                                                autocomplete="new-password"
                                                required
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

                                    </div>

                                </div>


                                {{--=================================
                                Confirm Password
                                =================================--}}
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="password_confirmation">
                                            Confirm Password
                                        </label>


                                        <div class="input-group input-group--password">

                                            <i class="ri-lock-password-line"></i>

                                            <input
                                                type="password"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                placeholder="Confirm your password"
                                                autocomplete="new-password"
                                                required
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


                                {{--=================================
                                Profile Image
                                =================================--}}
                                <div class="col-12">

                                    <div class="form-group form-group--upload">

                                        <label for="profile_image">

                                            Profile Image

                                            <span class="optional">
                                            Optional
                                        </span>

                                        </label>


                                        <label
                                            class="upload-box"
                                            for="profile_image"
                                        >

                                            <input
                                                type="file"
                                                id="profile_image"
                                                name="profile_image"
                                                accept="image/jpeg,image/png,image/webp"
                                            >


                                            <span class="upload-icon">

                                            <i class="ri-image-add-line"></i>

                                        </span>


                                            <span class="upload-content">

                                            <strong class="upload-title">
                                                Choose Profile Image
                                            </strong>

                                            <small class="upload-text">
                                                JPG, PNG or WebP — Max 2MB
                                            </small>

                                        </span>

                                        </label>

                                    </div>

                                </div>


                                {{--=================================
                                Account Information
                                =================================--}}
                                <div class="col-12">

                                    <div class="account-info">

                                        <div class="account-info__icon">

                                            <i class="ri-shield-user-line"></i>

                                        </div>


                                        <div class="account-info__content">

                                            <strong>
                                                Client Account
                                            </strong>

                                            <p>
                                                Your account will be created as a Client
                                                account. You can request services, manage
                                                shipments, track deliveries, and purchase
                                                products from the marketplace.
                                            </p>

                                        </div>

                                    </div>

                                </div>


                                {{--=================================
                                Terms & Conditions
                                =================================--}}
                                <div class="col-12">

                                    <div class="terms-check">

                                        <label>

                                            <input
                                                type="checkbox"
                                                name="terms"
                                                value="1"
                                                {{ old('terms') ? 'checked' : '' }}
                                                required
                                            >

                                            <span class="checkmark"></span>


                                            <span class="terms-text">

                                            I agree to the

                                            <a href="#">
                                                Terms & Conditions
                                            </a>

                                            and

                                            <a href="#">
                                                Privacy Policy
                                            </a>.

                                        </span>

                                        </label>

                                    </div>

                                </div>


                                {{--=================================
                                Submit
                                =================================--}}
                                <div class="col-12">

                                    <button
                                        class="register-submit"
                                        type="submit"
                                    >

                                        <i class="ri-user-add-line"></i>

                                        <span>
                                        Create Account
                                    </span>

                                    </button>

                                </div>

                            </div>

                        </form>


                        {{--=================================
                        Card Footer
                        =================================--}}
                        <div class="card-footer">

                        <span>
                            Already have an account?
                        </span>

                            <a href="{{ route('login') }}">
                                Login
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function(){

            /*=================================
            Password Toggle
            =================================*/

            const passwordToggles = document.querySelectorAll('.password-toggle');

            passwordToggles.forEach(function(toggle){

                toggle.addEventListener('click', function(){

                    const targetId = this.dataset.target;
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if(!passwordInput){
                        return;
                    }

                    if(passwordInput.type === 'password'){

                        passwordInput.type = 'text';

                        icon.classList.remove('ri-eye-line');
                        icon.classList.add('ri-eye-off-line');

                        this.setAttribute(
                            'aria-label',
                            'Hide password'
                        );

                    }else{

                        passwordInput.type = 'password';

                        icon.classList.remove('ri-eye-off-line');
                        icon.classList.add('ri-eye-line');

                        this.setAttribute(
                            'aria-label',
                            'Show password'
                        );

                    }

                });

            });


            /*=================================
            Profile Image Name
            =================================*/

            const profileImage = document.getElementById('profile_image');
            const uploadTitle = document.querySelector('.upload-title');

            if(profileImage && uploadTitle){

                profileImage.addEventListener('change', function(){

                    if(this.files && this.files.length){

                        uploadTitle.textContent =
                            this.files[0].name;

                    }else{

                        uploadTitle.textContent =
                            'Choose Profile Image';

                    }

                });

            }

        });
    </script>

@endpush
