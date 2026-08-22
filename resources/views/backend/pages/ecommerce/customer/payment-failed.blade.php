@extends('backend.layouts.backend')

@section('title', 'Payment Failed')

@section('content')

    <div class="customer-payment-result-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-result-breadcrumb">

            <a href="{{ route('orders') }}">
                My Orders
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Payment Failed
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- RESULT CARD --}}
        {{-- ================================================================ --}}

        <section class="customer-payment-result-card failed">

            <div class="customer-payment-result-card__icon">
                <i class="ri-close-circle-fill"></i>
            </div>


            <span class="customer-payment-result-card__eyebrow">
            Payment Unsuccessful
        </span>


            <h1>
                We Couldn't Process Your Payment
            </h1>


            <p class="customer-payment-result-card__description">
                Your order was not completed because the payment could not be processed.
                Please try again or choose another payment method.
            </p>


            {{-- ============================================================ --}}
            {{-- ORDER INFO --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-result-order">

                <div>

                <span>
                    Order Number
                </span>

                    <strong>
                        #ORD-2026-005
                    </strong>

                </div>


                <div>

                <span>
                    Amount
                </span>

                    <strong>
                        $84.97
                    </strong>

                </div>


                <div>

                <span>
                    Date
                </span>

                    <strong>
                        Aug 16, 2026
                    </strong>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- ERROR MESSAGE --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-result-alert">

                <i class="ri-error-warning-line"></i>

                <div>

                    <strong>
                        Payment was declined
                    </strong>

                    <p>
                        The transaction was declined by your card issuer.
                        Please verify your card details or try another payment method.
                    </p>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- ACTIONS --}}
            {{-- ============================================================ --}}

            <div class="customer-payment-result-actions">

                <a
                    href="{{ route('ecommerce-payment') }}"
                    class="customer-payment-result-btn primary"
                >
                    <i class="ri-refresh-line"></i>
                    Try Again
                </a>


                <a
                    href="{{ route('checkout') }}"
                    class="customer-payment-result-btn"
                >
                    <i class="ri-bank-card-line"></i>
                    Choose Another Method
                </a>

            </div>


            <a
                href="{{ route('cart') }}"
                class="customer-payment-result-back"
            >
                <i class="ri-arrow-left-line"></i>
                Return to Cart
            </a>

        </section>


        {{-- ================================================================ --}}
        {{-- HELP --}}
        {{-- ================================================================ --}}

        <section class="customer-payment-result-help">

            <div class="customer-payment-result-help__icon">
                <i class="ri-customer-service-2-line"></i>
            </div>


            <div>

                <h2>
                    Need Help?
                </h2>

                <p>
                    If you believe this was a mistake or continue having trouble,
                    please contact our support team.
                </p>

            </div>


            <a href="#">
                Contact Support
                <i class="ri-arrow-right-line"></i>
            </a>

        </section>

    </div>

@endsection
