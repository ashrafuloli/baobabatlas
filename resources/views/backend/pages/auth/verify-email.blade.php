@extends('backend.layouts.auth')

@section('title', 'Verify Email')

@section('content')

    <section class="verify-email-section">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-6 col-md-8">

                    <div class="verify-email-card">


                        {{-- Header --}}
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

                                <i class="ri-mail-check-line"></i>

                            </div>


                            <h2>
                                Verify Your Email
                            </h2>


                            <p>
                                We've sent a verification link to your email address.
                                Please check your inbox and verify your account.
                            </p>

                        </div>


                        {{-- Verification Content --}}
                        <div class="verification-content">


                            {{-- Inbox Message --}}
                            <div class="verification-message">

                                <div class="verification-message__icon">

                                    <i class="ri-mail-open-line"></i>

                                </div>


                                <div class="verification-message__content">

                                    <strong>
                                        Check your inbox
                                    </strong>

                                    <p>
                                        We sent a verification link to
                                        <strong>{{ $user->email }}</strong>.
                                        Click the link to activate your account.
                                    </p>

                                </div>

                            </div>


                            {{-- Resend Verification --}}
                            <form
                                action="{{ route('verification.send') }}"
                                method="POST"
                                class="resend-form"
                            >

                                @csrf


                                <button
                                    type="submit"
                                    class="resend-btn"
                                >

                                    <i class="ri-refresh-line"></i>

                                    <span>
                                        Resend Verification Email
                                    </span>

                                </button>

                            </form>

                        </div>


                        {{-- Footer --}}
                        <div class="card-footer">


                            {{-- Logout --}}
                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                                class="logout-form"
                            >

                                @csrf


                                <button type="submit">

                                    <i class="ri-logout-box-r-line"></i>

                                    <span>
                                        Logout
                                    </span>

                                </button>

                            </form>


                            {{-- Back To Login --}}
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
