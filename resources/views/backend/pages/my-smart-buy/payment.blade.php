@extends('backend.layouts.backend')

@section('title', 'Smart Buy Payment')

@section('content')

    <div class="my-smart-buy-payment-page">

        {{-- ==========================================================
        | Header
        =========================================================== --}}

        <div class="my-smart-buy-payment-header">

            <div>

                <a
                    href="{{ route('smart-buy-quote', $smartBuy) }}"
                    class="my-smart-buy-payment-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Quote</span>
                </a>


                <div class="my-smart-buy-payment-heading">

                    <div class="my-smart-buy-payment-heading__icon">

                        <i class="ri-bank-card-line"></i>

                    </div>


                    <div>

                        <span>My Smart Buy</span>

                        <h1>
                            Payment
                        </h1>

                        <p>
                            Complete your payment to continue with your request.
                        </p>

                    </div>

                </div>

            </div>


            <span class="my-smart-buy-payment-secure">

            <i class="ri-lock-line"></i>

            Secure Checkout

        </span>

        </div>



        {{-- ==========================================================
        | Payment Notice
        =========================================================== --}}

        <section class="my-smart-buy-payment-notice">

            <div class="my-smart-buy-payment-notice__icon">

                <i class="ri-shield-check-line"></i>

            </div>


            <div>

                <strong>
                    Your quote has been accepted
                </strong>

                <p>
                    Complete the payment below so we can proceed with purchasing
                    your requested product.
                </p>

            </div>

        </section>



        {{-- ==========================================================
        | Layout
        =========================================================== --}}

        <div class="my-smart-buy-payment-layout">


            {{-- ======================================================
            | Payment Form
            ======================================================= --}}

            <div class="my-smart-buy-payment-main">


                {{-- ==================================================
                | Payment Method
                =================================================== --}}

                <section class="my-smart-buy-payment-card">

                    <div class="my-smart-buy-payment-card__header">

                        <div>

                            <h2>
                                Payment Method
                            </h2>

                            <p>
                                Choose how you would like to pay.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-payment-methods">


                        {{-- Card --}}
                        <label
                            class="my-smart-buy-payment-method is-selected"
                            data-payment-method="card"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="card"
                                checked
                            >


                            <div class="my-smart-buy-payment-method__radio">

                                <span></span>

                            </div>


                            <div class="my-smart-buy-payment-method__icon">

                                <i class="ri-bank-card-line"></i>

                            </div>


                            <div class="my-smart-buy-payment-method__content">

                                <strong>
                                    Credit / Debit Card
                                </strong>

                                <span>
                                Visa, Mastercard, American Express
                            </span>

                            </div>

                        </label>



                        {{-- Bank --}}
                        <label
                            class="my-smart-buy-payment-method"
                            data-payment-method="bank"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="bank"
                            >


                            <div class="my-smart-buy-payment-method__radio">

                                <span></span>

                            </div>


                            <div class="my-smart-buy-payment-method__icon">

                                <i class="ri-bank-line"></i>

                            </div>


                            <div class="my-smart-buy-payment-method__content">

                                <strong>
                                    Bank Transfer
                                </strong>

                                <span>
                                Pay using a bank transfer
                            </span>

                            </div>

                        </label>



                        {{-- Mobile Wallet --}}
                        <label
                            class="my-smart-buy-payment-method"
                            data-payment-method="wallet"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="wallet"
                            >


                            <div class="my-smart-buy-payment-method__radio">

                                <span></span>

                            </div>


                            <div class="my-smart-buy-payment-method__icon">

                                <i class="ri-wallet-3-line"></i>

                            </div>


                            <div class="my-smart-buy-payment-method__content">

                                <strong>
                                    Digital Wallet
                                </strong>

                                <span>
                                Pay using an available digital wallet
                            </span>

                            </div>

                        </label>

                    </div>

                </section>



                {{-- ==================================================
                | Card Details
                =================================================== --}}

                <section
                    class="my-smart-buy-payment-card"
                    id="cardPaymentSection"
                >

                    <div class="my-smart-buy-payment-card__header">

                        <div>

                            <h2>
                                Card Details
                            </h2>

                            <p>
                                Enter your card information securely.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-payment-form">


                        <div class="my-smart-buy-payment-field">

                            <label for="card_name">
                                Cardholder Name
                            </label>

                            <input
                                type="text"
                                id="card_name"
                                name="card_name"
                                placeholder="Enter cardholder name"
                                autocomplete="cc-name"
                            >

                        </div>



                        <div class="my-smart-buy-payment-field">

                            <label for="card_number">
                                Card Number
                            </label>

                            <div class="my-smart-buy-payment-input-icon">

                                <i class="ri-bank-card-line"></i>

                                <input
                                    type="text"
                                    id="card_number"
                                    name="card_number"
                                    placeholder="1234 5678 9012 3456"
                                    inputmode="numeric"
                                    autocomplete="cc-number"
                                    maxlength="19"
                                >

                            </div>

                        </div>



                        <div class="my-smart-buy-payment-fields-row">

                            <div class="my-smart-buy-payment-field">

                                <label for="expiry">
                                    Expiry Date
                                </label>

                                <input
                                    type="text"
                                    id="expiry"
                                    name="expiry"
                                    placeholder="MM / YY"
                                    inputmode="numeric"
                                    autocomplete="cc-exp"
                                    maxlength="7"
                                >

                            </div>


                            <div class="my-smart-buy-payment-field">

                                <label for="cvv">

                                    CVV

                                    <span
                                        title="3 or 4 digit security code"
                                    >
                                    <i class="ri-question-line"></i>
                                </span>

                                </label>

                                <input
                                    type="password"
                                    id="cvv"
                                    name="cvv"
                                    placeholder="•••"
                                    inputmode="numeric"
                                    autocomplete="cc-csc"
                                    maxlength="4"
                                >

                            </div>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Billing Information
                =================================================== --}}

                <section class="my-smart-buy-payment-card">

                    <div class="my-smart-buy-payment-card__header">

                        <div>

                            <h2>
                                Billing Information
                            </h2>

                            <p>
                                Information associated with this payment.
                            </p>

                        </div>

                    </div>


                    <div class="my-smart-buy-payment-form">


                        <div class="my-smart-buy-payment-fields-row">

                            <div class="my-smart-buy-payment-field">

                                <label for="billing_first_name">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    id="billing_first_name"
                                    name="billing_first_name"
                                    value="John"
                                >

                            </div>


                            <div class="my-smart-buy-payment-field">

                                <label for="billing_last_name">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    id="billing_last_name"
                                    name="billing_last_name"
                                    value="Doe"
                                >

                            </div>

                        </div>



                        <div class="my-smart-buy-payment-field">

                            <label for="billing_address">
                                Address
                            </label>

                            <input
                                type="text"
                                id="billing_address"
                                name="billing_address"
                                value="24 Rue de Paris"
                            >

                        </div>



                        <div class="my-smart-buy-payment-fields-row">

                            <div class="my-smart-buy-payment-field">

                                <label for="billing_city">
                                    City
                                </label>

                                <input
                                    type="text"
                                    id="billing_city"
                                    name="billing_city"
                                    value="Conakry"
                                >

                            </div>


                            <div class="my-smart-buy-payment-field">

                                <label for="billing_zip">
                                    ZIP Code
                                </label>

                                <input
                                    type="text"
                                    id="billing_zip"
                                    name="billing_zip"
                                    value="001"
                                >

                            </div>

                        </div>



                        <div class="my-smart-buy-payment-field">

                            <label for="billing_country">
                                Country
                            </label>

                            <select
                                id="billing_country"
                                name="billing_country"
                            >

                                <option value="GN" selected>
                                    Guinea
                                </option>

                                <option value="US">
                                    United States
                                </option>

                                <option value="CA">
                                    Canada
                                </option>

                                <option value="GB">
                                    United Kingdom
                                </option>

                                <option value="AU">
                                    Australia
                                </option>

                            </select>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Security
                =================================================== --}}

                <section class="my-smart-buy-payment-security">

                    <i class="ri-shield-check-line"></i>

                    <div>

                        <strong>
                            Your payment is secure
                        </strong>

                        <p>
                            Your payment information is encrypted and securely
                            processed. We never store your full card details.
                        </p>

                    </div>

                </section>

            </div>



            {{-- ======================================================
            | Sidebar
            ======================================================= --}}

            <aside class="my-smart-buy-payment-sidebar">


                {{-- ==================================================
                | Order Summary
                =================================================== --}}

                <section class="my-smart-buy-payment-card">

                    <div class="my-smart-buy-payment-card__header">

                        <div>

                            <h2>
                                Order Summary
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-payment-summary">


                        <div class="my-smart-buy-payment-summary__product">

                            <div class="my-smart-buy-payment-summary__product-icon">

                                <i class="ri-macbook-line"></i>

                            </div>


                            <div>

                                <strong>
                                    MacBook Pro 14-inch
                                </strong>

                                <span>
                                Qty: 1 Unit
                            </span>

                            </div>

                        </div>



                        <div class="my-smart-buy-payment-summary__rows">

                            <div>

                            <span>
                                Product Cost
                            </span>

                                <strong>
                                    $2,200.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Service Fee
                            </span>

                                <strong>
                                    $100.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Estimated Shipping
                            </span>

                                <strong>
                                    $150.00
                                </strong>

                            </div>


                            <div>

                            <span>
                                Customs & Handling
                            </span>

                                <strong>
                                    $0.00
                                </strong>

                            </div>

                        </div>



                        <div class="my-smart-buy-payment-summary__total">

                        <span>
                            Total Amount
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Payment Action
                =================================================== --}}

                <section class="my-smart-buy-payment-card">

                    <div class="my-smart-buy-payment-action">

                        <div class="my-smart-buy-payment-action__amount">

                        <span>
                            Amount to Pay
                        </span>

                            <strong>
                                $2,450.00
                            </strong>

                        </div>


                        <button
                            type="button"
                            class="my-smart-buy-payment-submit"
                            id="payNowButton"
                        >

                            <i class="ri-lock-line"></i>

                            <span>
                            Pay $2,450.00
                        </span>

                        </button>


                        <a
                            href="{{ route('smart-buy-quote', $smartBuy) }}"
                            class="my-smart-buy-payment-cancel"
                        >

                            Cancel & Back to Quote

                        </a>

                    </div>

                </section>



                {{-- ==================================================
                | Request Info
                =================================================== --}}

                <section class="my-smart-buy-payment-card">

                    <div class="my-smart-buy-payment-card__header">

                        <div>

                            <h2>
                                Request
                            </h2>

                        </div>

                    </div>


                    <div class="my-smart-buy-payment-request">

                        <div>

                        <span>
                            Request ID
                        </span>

                            <strong>
                                SB-2026-00128
                            </strong>

                        </div>


                        <div>

                        <span>
                            Status
                        </span>

                            <strong class="is-success">
                                Quote Accepted
                            </strong>

                        </div>


                        <div>

                        <span>
                            Quote Valid Until
                        </span>

                            <strong>
                                Aug 23, 2026
                            </strong>

                        </div>

                    </div>

                </section>



                {{-- ==================================================
                | Help
                =================================================== --}}

                <div class="my-smart-buy-payment-help">

                    <div class="my-smart-buy-payment-help__icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>


                    <div>

                        <strong>
                            Need Help?
                        </strong>

                        <p>
                            Contact support if you have any questions about your
                            payment.
                        </p>

                        <a href="#">
                            Contact Support
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Payment Method
            |--------------------------------------------------------------------------
            */

            const methods =
                document.querySelectorAll(
                    '.my-smart-buy-payment-method'
                );

            const cardSection =
                document.getElementById(
                    'cardPaymentSection'
                );


            methods.forEach(function (method) {

                method.addEventListener('click', function () {

                    methods.forEach(function (item) {

                        item.classList.remove(
                            'is-selected'
                        );

                    });


                    method.classList.add(
                        'is-selected'
                    );


                    const input =
                        method.querySelector(
                            'input[type="radio"]'
                        );


                    if (!input) {
                        return;
                    }


                    if (input.value === 'card') {

                        cardSection.style.display = '';

                    } else {

                        cardSection.style.display = 'none';

                    }

                });

            });



            /*
            |--------------------------------------------------------------------------
            | Card Number Formatting
            |--------------------------------------------------------------------------
            */

            const cardNumber =
                document.getElementById(
                    'card_number'
                );


            cardNumber?.addEventListener(
                'input',
                function () {

                    let value =
                        this.value
                            .replace(/\D/g, '')
                            .substring(0, 16);


                    value =
                        value.match(/.{1,4}/g)?.join(' ')
                        || value;


                    this.value = value;

                }
            );



            /*
            |--------------------------------------------------------------------------
            | Expiry Formatting
            |--------------------------------------------------------------------------
            */

            const expiry =
                document.getElementById(
                    'expiry'
                );


            expiry?.addEventListener(
                'input',
                function () {

                    let value =
                        this.value
                            .replace(/\D/g, '')
                            .substring(0, 4);


                    if (value.length >= 3) {

                        value =
                            value.substring(0, 2)
                            + ' / '
                            + value.substring(2);

                    }


                    this.value = value;

                }
            );



            /*
            |--------------------------------------------------------------------------
            | CVV
            |--------------------------------------------------------------------------
            */

            const cvv =
                document.getElementById(
                    'cvv'
                );


            cvv?.addEventListener(
                'input',
                function () {

                    this.value =
                        this.value
                            .replace(/\D/g, '')
                            .substring(0, 4);

                }
            );



            /*
            |--------------------------------------------------------------------------
            | Pay Button
            |--------------------------------------------------------------------------
            */

            const payButton =
                document.getElementById(
                    'payNowButton'
                );


            payButton?.addEventListener(
                'click',
                function () {

                    const selectedMethod =
                        document.querySelector(
                            '.my-smart-buy-payment-method.is-selected input'
                        );


                    if (!selectedMethod) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Demo Payment Flow
                    |--------------------------------------------------------------------------
                    |
                    | Replace this section later with the real
                    | payment gateway integration.
                    |
                    */

                    const confirmed =
                        window.confirm(
                            'Proceed with payment of $2,450.00?'
                        );


                    if (!confirmed) {
                        return;
                    }


                    payButton.disabled = true;


                    payButton.innerHTML = `
                <i class="ri-loader-4-line"></i>
                <span>Processing Payment...</span>
            `;


                    /*
                    |--------------------------------------------------------------------------
                    | Demo Redirect
                    |--------------------------------------------------------------------------
                    |
                    | For now this redirects to the payment success
                    | page. Later replace this with the gateway callback.
                    |
                    */

                    setTimeout(function () {

                        window.location.href =
                            "{{ route('smart-buy-payment-success', $smartBuy) }}";

                    }, 1200);

                }
            );

        });
    </script>

@endpush
