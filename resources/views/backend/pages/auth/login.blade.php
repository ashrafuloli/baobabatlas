@extends('backend.layouts.auth')

@section('title', 'Login')

@section('content')

    <section class="login-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-6 col-md-8">

                    <div class="login-card">

                        {{--=================================
                        Login Header
                        =================================--}}
                        <div class="login-header">

                            <div class="login-logo">

                                <a href="{{ route('home') }}">

                                    <img
                                        src="{{ asset('logo.png') }}"
                                        alt="Baobab Atlas"
                                    >

                                </a>

                            </div>

                            <div class="login-heading">

                                <h2>
                                    Welcome Back
                                </h2>

                                <p>
                                    Sign in to access your account and manage
                                    your shipments and marketplace activity.
                                </p>

                            </div>

                        </div>


                        {{--=================================
                        Login Form
                        =================================--}}
                        <form
                            class="login-form"
                            action="{{ route('login.submit') }}"
                            method="POST"
                        >

                            @csrf


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
                                        value="{{ old('email') }}"
                                        placeholder="Enter your email address"
                                        autocomplete="email"
                                        autofocus
                                        required
                                    >

                                </div>

                                @error('email')

                                <span class="form-error">
                                {{ $message }}
                            </span>

                                @enderror

                            </div>


                            {{--=================================
                            Password
                            =================================--}}
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
                                        placeholder="Enter your password"
                                        autocomplete="current-password"
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

                                @error('password')

                                <span class="form-error">
                                {{ $message }}
                            </span>

                                @enderror

                            </div>


                            {{--=================================
                            Login Options
                            =================================--}}
                            <div class="login-options">

                                <label class="remember">

                                    <input
                                        type="checkbox"
                                        name="remember"
                                        value="1"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >

                                    <span>
                                    Remember Me
                                </span>

                                </label>

                                <a href="{{ route('forgot-password') }}">
                                    Forgot Password?
                                </a>

                            </div>


                            {{--=================================
                            Submit
                            =================================--}}
                            <button
                                class="login-submit"
                                type="submit"
                            >

                                <i class="ri-login-box-line"></i>

                                <span>
                                Login
                            </span>

                            </button>

                        </form>


                        {{--=================================
                        Login Footer
                        =================================--}}
                        <div class="login-footer">

                            <p>

                            <span>
                                Don't have an account?
                            </span>

                                <a href="{{ route('register') }}">
                                    Create Account
                                </a>

                            </p>

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

                        this.setAttribute('aria-label', 'Hide password');

                    }else{

                        passwordInput.type = 'password';

                        icon.classList.remove('ri-eye-off-line');
                        icon.classList.add('ri-eye-line');

                        this.setAttribute('aria-label', 'Show password');

                    }

                });

            });

        });
    </script>

@endpush
