@extends('backend.layouts.backend')

@section('title', 'Payment')

@section('content')

    <div class="customer-payment-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-breadcrumb">

            <a href="{{ route('cart') }}">
                Cart
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <a href="{{ route('checkout') }}">
                Checkout
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Payment
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-header">

            <div>

            <span class="customer-payment-header__eyebrow">
                Secure Checkout
            </span>

                <h1>
                    Complete Your Payment
                </h1>

                <p>
                    Choose your preferred payment method and complete your order.
                </p>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- CHECKOUT STEPS --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-steps">

            <div class="customer-payment-step completed">

                <div class="customer-payment-step__number">
                    <i class="ri-check-line"></i>
                </div>

                <div>
                <span>
                    Step 1
                </span>

                    <strong>
                        Checkout
                    </strong>
                </div>

            </div>


            <div class="customer-payment-step__line completed"></div>


            <div class="customer-payment-step active">

                <div class="customer-payment-step__number">
                    2
                </div>

                <div>
                <span>
                    Step 2
                </span>

                    <strong>
                        Payment
                    </strong>
                </div>

            </div>


            <div class="customer-payment-step__line"></div>


            <div class="customer-payment-step">

                <div class="customer-payment-step__number">
                    3
                </div>

                <div>
                <span>
                    Step 3
                </span>

                    <strong>
                        Confirmation
                    </strong>
                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN LAYOUT --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-layout">


            {{-- ============================================================ --}}
            {{-- LEFT COLUMN --}}
            {{-- ============================================================ --}}

            <main class="customer-payment-main">


                {{-- ======================================================== --}}
                {{-- PAYMENT METHODS --}}
                {{-- ======================================================== --}}

                <section class="customer-payment-card">

                    <div class="customer-payment-card__header">

                        <div>

                        <span>
                            Payment Method
                        </span>

                            <h2>
                                Choose how you want to pay
                            </h2>

                        </div>

                        <div class="customer-payment-secure">
                            <i class="ri-lock-2-line"></i>
                            Secure
                        </div>

                    </div>


                    <div class="customer-payment-methods">


                        {{-- CREDIT / DEBIT CARD --}}

                        <label
                            class="customer-payment-method active"
                            data-payment-method="card"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="card"
                                checked
                            >

                            <span class="customer-payment-method__radio">
                            <span></span>
                        </span>


                            <span class="customer-payment-method__icon">
                            <i class="ri-bank-card-line"></i>
                        </span>


                            <span class="customer-payment-method__content">

                            <strong>
                                Credit / Debit Card
                            </strong>

                            <small>
                                Visa, Mastercard, American Express and Discover
                            </small>

                        </span>


                            <span class="customer-payment-method__cards">

                            <span>
                                VISA
                            </span>

                            <span>
                                MC
                            </span>

                            <span>
                                AMEX
                            </span>

                        </span>

                        </label>


                        {{-- PAYPAL --}}

                        <label
                            class="customer-payment-method"
                            data-payment-method="paypal"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="paypal"
                            >

                            <span class="customer-payment-method__radio">
                            <span></span>
                        </span>


                            <span class="customer-payment-method__icon paypal">
                            <i class="ri-paypal-line"></i>
                        </span>


                            <span class="customer-payment-method__content">

                            <strong>
                                PayPal
                            </strong>

                            <small>
                                Pay securely with your PayPal account
                            </small>

                        </span>

                        </label>


                        {{-- APPLE PAY --}}

                        <label
                            class="customer-payment-method"
                            data-payment-method="apple"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="apple"
                            >

                            <span class="customer-payment-method__radio">
                            <span></span>
                        </span>


                            <span class="customer-payment-method__icon apple">
                            <i class="ri-apple-fill"></i>
                        </span>


                            <span class="customer-payment-method__content">

                            <strong>
                                Apple Pay
                            </strong>

                            <small>
                                Fast and secure payment with Apple Pay
                            </small>

                        </span>

                        </label>


                        {{-- CASH ON DELIVERY --}}

                        <label
                            class="customer-payment-method"
                            data-payment-method="cod"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="cod"
                            >

                            <span class="customer-payment-method__radio">
                            <span></span>
                        </span>


                            <span class="customer-payment-method__icon cod">
                            <i class="ri-hand-coin-line"></i>
                        </span>


                            <span class="customer-payment-method__content">

                            <strong>
                                Cash on Delivery
                            </strong>

                            <small>
                                Pay when your order arrives
                            </small>

                        </span>

                        </label>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- CARD FORM --}}
                {{-- ======================================================== --}}

                <section
                    class="customer-payment-card customer-payment-card-form"
                    data-payment-panel="card"
                >

                    <div class="customer-payment-card__header">

                        <div>

                        <span>
                            Card Information
                        </span>

                            <h2>
                                Enter your card details
                            </h2>

                        </div>

                    </div>


                    <div class="customer-payment-form">

                        <div class="customer-payment-form__group full">

                            <label for="card_number">
                                Card Number
                            </label>

                            <div class="customer-payment-input">

                                <i class="ri-bank-card-line"></i>

                                <input
                                    type="text"
                                    id="card_number"
                                    name="card_number"
                                    placeholder="1234 5678 9012 3456"
                                    maxlength="19"
                                    autocomplete="cc-number"
                                >

                                <span class="customer-payment-input__brand">
                                VISA
                            </span>

                            </div>

                        </div>


                        <div class="customer-payment-form__group">

                            <label for="card_name">
                                Cardholder Name
                            </label>

                            <input
                                type="text"
                                id="card_name"
                                name="card_name"
                                placeholder="John Doe"
                                autocomplete="cc-name"
                            >

                        </div>


                        <div class="customer-payment-form__group">

                            <label for="card_expiry">
                                Expiry Date
                            </label>

                            <input
                                type="text"
                                id="card_expiry"
                                name="card_expiry"
                                placeholder="MM / YY"
                                maxlength="7"
                                autocomplete="cc-exp"
                            >

                        </div>


                        <div class="customer-payment-form__group">

                            <label for="card_cvv">
                                CVV
                            </label>

                            <div class="customer-payment-input">

                                <input
                                    type="password"
                                    id="card_cvv"
                                    name="card_cvv"
                                    placeholder="123"
                                    maxlength="4"
                                    autocomplete="cc-csc"
                                >

                                <i class="ri-question-line"></i>

                            </div>

                        </div>


                        <div class="customer-payment-form__group">

                            <label for="billing_zip">
                                Billing ZIP Code
                            </label>

                            <input
                                type="text"
                                id="billing_zip"
                                name="billing_zip"
                                placeholder="10001"
                                autocomplete="postal-code"
                            >

                        </div>

                    </div>


                    <label class="customer-payment-save-card">

                        <input
                            type="checkbox"
                            name="save_card"
                        >

                        <span>
                        Save this card securely for future purchases
                    </span>

                    </label>

                </section>


                {{-- ======================================================== --}}
                {{-- BILLING ADDRESS --}}
                {{-- ======================================================== --}}

                <section class="customer-payment-card">

                    <div class="customer-payment-card__header">

                        <div>

                        <span>
                            Billing Address
                        </span>

                            <h2>
                                Where should we send the receipt?
                            </h2>

                        </div>

                    </div>


                    <label class="customer-payment-address-option">

                        <input
                            type="radio"
                            name="billing_address"
                            value="shipping"
                            checked
                        >

                        <span class="customer-payment-address-option__radio">
                        <span></span>
                    </span>

                        <span>

                        <strong>
                            Same as shipping address
                        </strong>

                        <small>
                            John Doe · 123 Main Street, New York, NY 10001
                        </small>

                    </span>

                    </label>


                    <label class="customer-payment-address-option">

                        <input
                            type="radio"
                            name="billing_address"
                            value="different"
                        >

                        <span class="customer-payment-address-option__radio">
                        <span></span>
                    </span>

                        <span>

                        <strong>
                            Use a different billing address
                        </strong>

                        <small>
                            Enter another billing address
                        </small>

                    </span>

                    </label>

                </section>


                {{-- ======================================================== --}}
                {{-- SECURITY --}}
                {{-- ======================================================== --}}

                <div class="customer-payment-security">

                    <i class="ri-shield-check-line"></i>

                    <div>

                        <strong>
                            Your payment is secure
                        </strong>

                        <p>
                            Your card information is encrypted and securely processed.
                        </p>

                    </div>

                </div>

            </main>


            {{-- ============================================================ --}}
            {{-- RIGHT COLUMN --}}
            {{-- ============================================================ --}}

            <aside class="customer-payment-sidebar">


                {{-- ======================================================== --}}
                {{-- ORDER SUMMARY --}}
                {{-- ======================================================== --}}

                <section class="customer-payment-summary">

                    <div class="customer-payment-summary__header">

                        <div>

                        <span>
                            Your Order
                        </span>

                            <h2>
                                Order Summary
                            </h2>

                        </div>

                        <a href="{{ route('cart') }}">
                            Edit
                        </a>

                    </div>


                    {{-- PRODUCT 1 --}}

                    <div class="customer-payment-product">

                        <div class="customer-payment-product__image">

                            <img
                                src="https://placehold.co/80x90"
                                alt="Premium Cotton T-Shirt"
                            >

                            <span>
                            1
                        </span>

                        </div>


                        <div class="customer-payment-product__info">

                            <strong>
                                Premium Cotton T-Shirt
                            </strong>

                            <span>
                            Black / M
                        </span>

                        </div>


                        <strong class="customer-payment-product__price">
                            $29.99
                        </strong>

                    </div>


                    {{-- PRODUCT 2 --}}

                    <div class="customer-payment-product">

                        <div class="customer-payment-product__image">

                            <img
                                src="https://placehold.co/80x90"
                                alt="Everyday Backpack"
                            >

                            <span>
                            1
                        </span>

                        </div>


                        <div class="customer-payment-product__info">

                            <strong>
                                Everyday Backpack
                            </strong>

                            <span>
                            Black
                        </span>

                        </div>


                        <strong class="customer-payment-product__price">
                            $54.99
                        </strong>

                    </div>


                    {{-- TOTALS --}}

                    <div class="customer-payment-summary__totals">

                        <div>

                        <span>
                            Subtotal
                        </span>

                            <strong>
                                $84.98
                            </strong>

                        </div>


                        <div>

                        <span>
                            Shipping
                        </span>

                            <strong>
                                $0.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Discount
                        </span>

                            <strong class="discount">
                                -$10.00
                            </strong>

                        </div>


                        <div>

                        <span>
                            Tax
                        </span>

                            <strong>
                                $0.00
                            </strong>

                        </div>

                    </div>


                    <div class="customer-payment-summary__total">

                    <span>
                        Total
                    </span>

                        <strong>
                            $74.98
                        </strong>

                    </div>


                    {{-- PLACE ORDER --}}

                    <button
                        type="button"
                        class="customer-payment-place-order"
                        id="place-order-btn"
                    >
                        <i class="ri-lock-2-line"></i>

                        Pay $74.98

                        <i class="ri-arrow-right-line"></i>
                    </button>


                    <p class="customer-payment-summary__note">

                        By placing your order, you agree to our
                        <a href="#">
                            Terms & Conditions
                        </a>.

                    </p>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPING INFO --}}
                {{-- ======================================================== --}}

                <section class="customer-payment-sidebar-card">

                    <div class="customer-payment-sidebar-card__header">

                        <i class="ri-truck-line"></i>

                        <div>

                        <span>
                            Shipping
                        </span>

                            <strong>
                                Standard Shipping
                            </strong>

                        </div>

                    </div>


                    <div class="customer-payment-sidebar-card__body">

                    <span>
                        Estimated delivery
                    </span>

                        <strong>
                            Aug 15 – Aug 18, 2026
                        </strong>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SECURE PAYMENT --}}
                {{-- ======================================================== --}}

                <div class="customer-payment-secure-box">

                    <i class="ri-shield-check-line"></i>

                    <div>

                        <strong>
                            Secure Checkout
                        </strong>

                        <p>
                            Your information is protected with industry-standard encryption.
                        </p>

                    </div>

                </div>

            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- MOBILE BOTTOM ACTION --}}
        {{-- ================================================================ --}}

        <div class="customer-payment-mobile-action">

            <div>

            <span>
                Total
            </span>

                <strong>
                    $74.98
                </strong>

            </div>

            <button
                type="button"
                id="mobile-place-order-btn"
            >
                Pay Now
                <i class="ri-arrow-right-line"></i>
            </button>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                /*
                |--------------------------------------------------------------------------
                | PAYMENT METHOD SWITCH
                |--------------------------------------------------------------------------
                */

                const methods =
                    document.querySelectorAll(
                        '[data-payment-method]'
                    );

                const panels =
                    document.querySelectorAll(
                        '[data-payment-panel]'
                    );


                methods.forEach(function (method) {

                    method.addEventListener(
                        'click',
                        function () {

                            methods.forEach(function (item) {

                                item.classList.remove(
                                    'active'
                                );

                            });


                            method.classList.add(
                                'active'
                            );


                            const selected =
                                method.dataset.paymentMethod;


                            panels.forEach(function (panel) {

                                panel.hidden =
                                    panel.dataset.paymentPanel !== selected;

                            });

                        }
                    );

                });


                /*
                |--------------------------------------------------------------------------
                | CARD NUMBER FORMAT
                |--------------------------------------------------------------------------
                */

                const cardNumber =
                    document.querySelector(
                        '#card_number'
                    );


                if (cardNumber) {

                    cardNumber.addEventListener(
                        'input',
                        function () {

                            let value =
                                this.value
                                    .replace(/\D/g, '')
                                    .substring(0, 16);


                            value =
                                value.match(/.{1,4}/g);


                            this.value =
                                value
                                    ? value.join(' ')
                                    : '';

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | EXPIRY FORMAT
                |--------------------------------------------------------------------------
                */

                const expiry =
                    document.querySelector(
                        '#card_expiry'
                    );


                if (expiry) {

                    expiry.addEventListener(
                        'input',
                        function () {

                            let value =
                                this.value
                                    .replace(/\D/g, '')
                                    .substring(0, 4);


                            if (value.length > 2) {

                                value =
                                    value.substring(0, 2)
                                    + ' / '
                                    + value.substring(2);

                            }


                            this.value = value;

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | PLACE ORDER
                |--------------------------------------------------------------------------
                */

                const placeOrder =
                    document.querySelector(
                        '#place-order-btn'
                    );

                const mobilePlaceOrder =
                    document.querySelector(
                        '#mobile-place-order-btn'
                    );


                function processPayment() {

                    if (!placeOrder) {
                        return;
                    }


                    const original =
                        placeOrder.innerHTML;


                    placeOrder.disabled = true;

                    placeOrder.innerHTML =
                        '<i class="ri-loader-4-line customer-payment-loading"></i> Processing...';


                    setTimeout(function () {

                        /*
                         * Demo only.
                         * Replace this with your actual payment submission.
                         */

                        window.location.href =
                            "{{ route('ecommerce-payment-success') }}";

                    }, 1200);

                }


                if (placeOrder) {

                    placeOrder.addEventListener(
                        'click',
                        processPayment
                    );

                }


                if (mobilePlaceOrder) {

                    mobilePlaceOrder.addEventListener(
                        'click',
                        processPayment
                    );

                }

            });

        </script>

    @endpush

@endsection
