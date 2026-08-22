@extends('backend.layouts.auth')

@section('title', 'Reset Password')

@section('content')

    <section class="reset-password-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-6 col-md-8">

                    <div class="reset-password-card">


                        {{--=================================
                        Header
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


                            <div class="icon">

                                <i class="ri-lock-unlock-line"></i>

                            </div>


                            <h2>
                                Reset Password
                            </h2>


                            <p>
                                Create a new secure password for your account.
                            </p>

                        </div>


                        {{--=================================
                        Reset Password Form
                        =================================--}}
                        <form
                            class="reset-password-form"
                            action="#"
                            method="POST"
                        >

                            @csrf


                            <input
                                type="hidden"
                                name="token"
                                value="{{ request()->route('token') }}"
                            >


                            {{--=================================
                            Email
                            =================================--}}
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
                                        value="{{ old('email', request()->email) }}"
                                        placeholder="Enter your email address"
                                        autocomplete="email"
                                        required
                                    >

                                </div>

                            </div>


                            {{--=================================
                            New Password
                            =================================--}}
                            <div class="form-group">

                                <label for="password">
                                    New Password
                                </label>


                                <div class="input-group input-group--password">

                                    <i class="ri-lock-2-line"></i>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Enter new password"
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


                            {{--=================================
                            Confirm Password
                            =================================--}}
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
                                        placeholder="Confirm new password"
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


                            {{--=================================
                            Password Info
                            =================================--}}
                            <div class="password-info">

                                <div class="password-info__icon">

                                    <i class="ri-shield-check-line"></i>

                                </div>


                                <div class="password-info__content">

                                    <strong>
                                        Keep your account secure
                                    </strong>

                                    <p>
                                        Use a strong password with a combination of
                                        letters, numbers and special characters.
                                    </p>

                                </div>

                            </div>


                            {{--=================================
                            Submit
                            =================================--}}
                            <button
                                class="reset-submit"
                                type="submit"
                            >

                                <i class="ri-lock-unlock-line"></i>

                                <span>
                                Reset Password
                            </span>

                            </button>

                        </form>


                        {{--=================================
                        Footer
                        =================================--}}
                        <div class="card-footer">

                            <a href="{{ route('login') }}">

                                <i class="ri-arrow-left-line"></i>

                                <span>
                                Back to Login
                            </span>

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
            * Password Toggle
            *=================================*/

            const passwordToggles = document.querySelectorAll('.password-toggle');


            passwordToggles.forEach(function(toggle){

                toggle.addEventListener('click', function(){

                    const targetId = this.dataset.target;

                    const passwordInput =
                        document.getElementById(targetId);

                    const icon =
                        this.querySelector('i');


                    if(!passwordInput){
                        return;
                    }


                    if(passwordInput.type === 'password'){

                        passwordInput.type = 'text';

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

                    }else{

                        passwordInput.type = 'password';

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

        });

    </script>

@endpush
