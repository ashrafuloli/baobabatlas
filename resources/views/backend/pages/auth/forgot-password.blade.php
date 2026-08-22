@extends('backend.layouts.auth')

@section('title', 'Forgot Password')

@section('content')

    <section class="forgot-password-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-6 col-md-8">

                    <div class="forgot-password-card">


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

                                <i class="ri-lock-password-line"></i>

                            </div>


                            <h2>
                                Forgot Password?
                            </h2>


                            <p>
                                Enter your registered email address and we'll send
                                you a password reset link.
                            </p>

                        </div>


                        {{--=================================
                        Reset Form
                        =================================--}}
                        <form
                            class="forgot-password-form"
                            action="#"
                            method="POST"
                        >

                            @csrf


                            {{--=================================
                            Email Address
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

                            </div>


                            {{--=================================
                            Submit
                            =================================--}}
                            <button
                                class="forgot-submit"
                                type="submit"
                            >

                                <i class="ri-mail-send-line"></i>

                                <span>
                                Send Reset Link
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
