@extends('frontend.layouts.frontend')

@section('contents')

    @php
        $user = auth()->user();
    @endphp


    {{-- ==========================================
        Page Hero
    =========================================== --}}

    <div
        class="c-hero-section"
        style="background-image: url({{ asset('assets/img/bg/bg-1.jpg') }});"
    >

        <div class="container">

            <div class="row align-items-center">

                <div class="col-xl-6 col-lg-6 col-md-10">

                    <div class="c-hero-content">

                        <ul class="breadcrumb-wrap">

                            <li>
                                <a href="{{ route('home') }}">
                                    Home
                                </a>
                            </li>

                            <li>
                                <span class="arrow">
                                    <i class="ri-arrow-right-line"></i>
                                </span>
                            </li>

                            <li>
                                <span class="current">
                                    My Account
                                </span>
                            </li>

                        </ul>

                        <h1 class="title">
                            My Account
                        </h1>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================
        My Account
    =========================================== --}}

    <div class="my-account-page">

        <div class="container">

            <div class="my-account-page__layout">

                {{-- ==========================================
                    Dashboard Content
                =========================================== --}}

                <main class="my-account-page__content">


                    {{-- ==========================================
                        Welcome
                    =========================================== --}}

                    <div class="my-account-page__welcome">

                        <div class="my-account-page__welcome-message">

                            <span>
                                Hello
                            </span>

                            <strong>
                                {{ $user->name }}
                            </strong>

                            <span>
                                (not {{ $user->name }}?
                            </span>

                            <form
                                action="{{ route('logout') }}"
                                method="POST"
                                class="my-account-page__inline-logout"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    data-logout-button
                                >
                                    Log out
                                </button>

                                <span>
                                    )
                                </span>

                            </form>

                        </div>


                        <p class="my-account-page__description">

                            From your account dashboard you can view your

                            <a href="{{ route('my-orders') }}">
                                recent orders
                            </a>,

                            manage your

                            <a href="{{ route('my-wishlist') }}">
                                wishlist
                            </a>,

                            and edit your

                            <a href="{{ route('profile') }}">
                                profile details
                            </a>.

                        </p>

                    </div>


                    {{-- ==========================================
                        Dashboard Cards
                    =========================================== --}}

                    <div class="my-account-page__cards">


                        {{-- ==========================================
                            Dashboard
                        =========================================== --}}

                        <a
                            href="{{ route('dashboard') }}"
                            class="my-account-page__card"
                        >

                            <div class="my-account-page__card-icon">

                                <i class="ri-dashboard-line"></i>

                            </div>

                            <span class="my-account-page__card-title">
                                Dashboard
                            </span>

                            <span class="my-account-page__card-arrow">

                                <i class="ri-arrow-right-line"></i>

                            </span>

                        </a>

                        {{-- ==========================================
                            Cart
                        =========================================== --}}

                        <a
                            href="{{ route('my-cart') }}"
                            class="my-account-page__card"
                        >

                            <div class="my-account-page__card-icon">

                                <i class="ri-shopping-bag-3-line"></i>

                            </div>

                            <span class="my-account-page__card-title">
                                Cart
                            </span>

                            <span class="my-account-page__card-arrow">

                                <i class="ri-arrow-right-line"></i>

                            </span>

                        </a>


                        {{-- ==========================================
                            Orders
                        =========================================== --}}

                        <a
                            href="{{ route('my-orders') }}"
                            class="my-account-page__card"
                        >

                            <div class="my-account-page__card-icon">

                                <i class="ri-file-list-3-line"></i>

                            </div>

                            <span class="my-account-page__card-title">
                                Orders
                            </span>

                            <span class="my-account-page__card-arrow">

                                <i class="ri-arrow-right-line"></i>

                            </span>

                        </a>


                        {{-- ==========================================
                            Wishlist
                        =========================================== --}}

                        <a
                            href="{{ route('my-wishlist') }}"
                            class="my-account-page__card"
                        >

                            <div class="my-account-page__card-icon">

                                <i class="ri-heart-3-line"></i>

                            </div>

                            <span class="my-account-page__card-title">
                                Wishlist
                            </span>

                            <span class="my-account-page__card-arrow">

                                <i class="ri-arrow-right-line"></i>

                            </span>

                        </a>


                        {{-- ==========================================
                            Profile
                        =========================================== --}}

                        <a
                            href="{{ route('profile') }}"
                            class="my-account-page__card"
                        >

                            <div class="my-account-page__card-icon">

                                <i class="ri-user-3-line"></i>

                            </div>

                            <span class="my-account-page__card-title">
                                Profile
                            </span>

                            <span class="my-account-page__card-arrow">

                                <i class="ri-arrow-right-line"></i>

                            </span>

                        </a>


                        {{-- ==========================================
                            Logout
                        =========================================== --}}

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            class="my-account-page__card-form"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="my-account-page__card my-account-page__card--logout"
                                data-logout-button
                            >

                                <div class="my-account-page__card-icon">

                                    <i class="ri-logout-box-r-line"></i>

                                </div>

                                <span class="my-account-page__card-title">
                                    Logout
                                </span>

                                <span class="my-account-page__card-arrow">

                                    <i class="ri-arrow-right-line"></i>

                                </span>

                            </button>

                        </form>

                    </div>

                </main>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        (function () {

            const initMyAccountPage = function () {

                const accountPage =
                    document.querySelector('.my-account-page');


                if (!accountPage) {
                    return;
                }


                /*
                ==========================================
                    Logout Protection
                ==========================================
                */

                const logoutButtons =
                    accountPage.querySelectorAll(
                        '[data-logout-button]'
                    );


                logoutButtons.forEach(function (button) {

                    const form = button.closest('form');


                    if (!form) {
                        return;
                    }


                    form.addEventListener(
                        'submit',
                        function () {

                            if (form.dataset.submitting === 'true') {
                                return;
                            }


                            form.dataset.submitting = 'true';

                            button.disabled = true;

                            button.classList.add(
                                'is-loading'
                            );


                            const buttonText =
                                button.querySelector('span');


                            if (buttonText) {

                                buttonText.textContent =
                                    'Logging out...';

                            }

                        }
                    );

                });

            };


            /*
            ==========================================
                DOM Ready
            ==========================================
            */

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

@endpush
