@extends('backend.layouts.backend')

@section('title', 'Checkout')

@section('content')

    <div class="customer-checkout-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-checkout-breadcrumb">

            <a href="{{ route('cart') }}">
                Cart
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Checkout
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-checkout-header">

            <div>

            <span class="customer-checkout-header__eyebrow">
                Secure Checkout
            </span>

                <h1>
                    Checkout
                </h1>

                <p>
                    Enter your delivery details and review your order before payment.
                </p>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- CHECKOUT STEPS --}}
        {{-- ================================================================ --}}

        <div class="customer-checkout-steps">

            <div class="customer-checkout-step active">

                <div class="customer-checkout-step__number">
                    1
                </div>

                <div>
                    <span>Step 1</span>
                    <strong>Checkout</strong>
                </div>

            </div>


            <div class="customer-checkout-step__line"></div>


            <div class="customer-checkout-step">

                <div class="customer-checkout-step__number">
                    2
                </div>

                <div>
                    <span>Step 2</span>
                    <strong>Payment</strong>
                </div>

            </div>


            <div class="customer-checkout-step__line"></div>


            <div class="customer-checkout-step">

                <div class="customer-checkout-step__number">
                    3
                </div>

                <div>
                    <span>Step 3</span>
                    <strong>Confirmation</strong>
                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN LAYOUT --}}
        {{-- ================================================================ --}}

        <div class="customer-checkout-layout">


            {{-- ============================================================ --}}
            {{-- MAIN --}}
            {{-- ============================================================ --}}

            <main class="customer-checkout-main">


                {{-- ======================================================== --}}
                {{-- CONTACT INFORMATION --}}
                {{-- ======================================================== --}}

                <section class="customer-checkout-card">

                    <div class="customer-checkout-card__header">

                        <div>

                        <span>
                            Contact Information
                        </span>

                            <h2>
                                Your Details
                            </h2>

                        </div>

                    </div>


                    <div class="customer-checkout-form">

                        <div class="customer-checkout-form__group full">

                            <label for="checkout-email">
                                Email Address
                            </label>

                            <div class="customer-checkout-input">

                                <i class="ri-mail-line"></i>

                                <input
                                    type="email"
                                    id="checkout-email"
                                    name="email"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                >

                            </div>

                        </div>


                        <div class="customer-checkout-form__group">

                            <label for="checkout-first-name">
                                First Name
                            </label>

                            <input
                                type="text"
                                id="checkout-first-name"
                                name="first_name"
                                placeholder="John"
                                autocomplete="given-name"
                            >

                        </div>


                        <div class="customer-checkout-form__group">

                            <label for="checkout-last-name">
                                Last Name
                            </label>

                            <input
                                type="text"
                                id="checkout-last-name"
                                name="last_name"
                                placeholder="Doe"
                                autocomplete="family-name"
                            >

                        </div>


                        <div class="customer-checkout-form__group full">

                            <label for="checkout-phone">
                                Phone Number
                            </label>

                            <div class="customer-checkout-input">

                                <i class="ri-phone-line"></i>

                                <input
                                    type="tel"
                                    id="checkout-phone"
                                    name="phone"
                                    placeholder="+1 555 123 4567"
                                    autocomplete="tel"
                                >

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPING ADDRESS --}}
                {{-- ======================================================== --}}

                <section class="customer-checkout-card">

                    <div class="customer-checkout-card__header">

                        <div>

                        <span>
                            Delivery Information
                        </span>

                            <h2>
                                Shipping Address
                            </h2>

                        </div>

                    </div>


                    <div class="customer-checkout-form">

                        <div class="customer-checkout-form__group full">

                            <label for="checkout-country">
                                Country
                            </label>

                            <div class="customer-checkout-select">

                                <select
                                    id="checkout-country"
                                    name="country"
                                    autocomplete="country"
                                >

                                    <option value="">
                                        Select Country
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

                                <i class="ri-arrow-down-s-line"></i>

                            </div>

                        </div>


                        <div class="customer-checkout-form__group full">

                            <label for="checkout-address">
                                Street Address
                            </label>

                            <div class="customer-checkout-input">

                                <i class="ri-map-pin-line"></i>

                                <input
                                    type="text"
                                    id="checkout-address"
                                    name="address"
                                    placeholder="123 Main Street"
                                    autocomplete="street-address"
                                >

                            </div>

                        </div>


                        <div class="customer-checkout-form__group">

                            <label for="checkout-apartment">
                                Apartment / Suite
                                <span>Optional</span>
                            </label>

                            <input
                                type="text"
                                id="checkout-apartment"
                                name="apartment"
                                placeholder="Apartment 4B"
                                autocomplete="address-line2"
                            >

                        </div>


                        <div class="customer-checkout-form__group">

                            <label for="checkout-city">
                                City
                            </label>

                            <input
                                type="text"
                                id="checkout-city"
                                name="city"
                                placeholder="New York"
                                autocomplete="address-level2"
                            >

                        </div>


                        <div class="customer-checkout-form__group">

                            <label for="checkout-state">
                                State / Province
                            </label>

                            <input
                                type="text"
                                id="checkout-state"
                                name="state"
                                placeholder="New York"
                                autocomplete="address-level1"
                            >

                        </div>


                        <div class="customer-checkout-form__group">

                            <label for="checkout-zip">
                                ZIP / Postal Code
                            </label>

                            <input
                                type="text"
                                id="checkout-zip"
                                name="zip"
                                placeholder="10001"
                                autocomplete="postal-code"
                            >

                        </div>

                    </div>


                    <label class="customer-checkout-checkbox">

                        <input
                            type="checkbox"
                            name="save_address"
                        >

                        <span>
                        Save this address for future orders
                    </span>

                    </label>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPING METHOD --}}
                {{-- ======================================================== --}}

                <section class="customer-checkout-card">

                    <div class="customer-checkout-card__header">

                        <div>

                        <span>
                            Delivery Options
                        </span>

                            <h2>
                                Shipping Method
                            </h2>

                        </div>

                    </div>


                    <div class="customer-checkout-shipping">


                        {{-- STANDARD --}}

                        <label
                            class="customer-checkout-shipping-option active"
                        >

                            <input
                                type="radio"
                                name="shipping_method"
                                value="standard"
                                checked
                            >

                            <span class="customer-checkout-radio">
                            <span></span>
                        </span>


                            <span class="customer-checkout-shipping-option__icon">
                            <i class="ri-truck-line"></i>
                        </span>


                            <span class="customer-checkout-shipping-option__content">

                            <strong>
                                Standard Shipping
                            </strong>

                            <small>
                                Estimated delivery: Aug 18 – Aug 20
                            </small>

                        </span>


                            <strong class="customer-checkout-shipping-option__price">
                                Free
                            </strong>

                        </label>


                        {{-- EXPRESS --}}

                        <label
                            class="customer-checkout-shipping-option"
                        >

                            <input
                                type="radio"
                                name="shipping_method"
                                value="express"
                            >

                            <span class="customer-checkout-radio">
                            <span></span>
                        </span>


                            <span class="customer-checkout-shipping-option__icon">
                            <i class="ri-flashlight-line"></i>
                        </span>


                            <span class="customer-checkout-shipping-option__content">

                            <strong>
                                Express Shipping
                            </strong>

                            <small>
                                Estimated delivery: Aug 17 – Aug 18
                            </small>

                        </span>


                            <strong class="customer-checkout-shipping-option__price">
                                $12.99
                            </strong>

                        </label>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- ORDER NOTE --}}
                {{-- ======================================================== --}}

                <section class="customer-checkout-card">

                    <div class="customer-checkout-card__header">

                        <div>

                        <span>
                            Additional Information
                        </span>

                            <h2>
                                Order Notes
                            </h2>

                        </div>

                    </div>


                    <div class="customer-checkout-note">

                        <label for="checkout-note">
                            Special instructions
                            <span>Optional</span>
                        </label>

                        <textarea
                            id="checkout-note"
                            name="order_note"
                            rows="4"
                            placeholder="Add any special instructions for your order..."
                        ></textarea>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SECURITY --}}
                {{-- ======================================================== --}}

                <div class="customer-checkout-security">

                    <i class="ri-shield-check-line"></i>

                    <div>

                        <strong>
                            Secure Checkout
                        </strong>

                        <p>
                            Your personal information is protected and securely transmitted.
                        </p>

                    </div>

                </div>

            </main>


            {{-- ============================================================ --}}
            {{-- SIDEBAR --}}
            {{-- ============================================================ --}}

            <aside class="customer-checkout-sidebar">


                {{-- ======================================================== --}}
                {{-- ORDER SUMMARY --}}
                {{-- ======================================================== --}}

                <section class="customer-checkout-summary">

                    <div class="customer-checkout-summary__header">

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

                    <div class="customer-checkout-product">

                        <div class="customer-checkout-product__image">

                            <img
                                src="https://placehold.co/80x90"
                                alt="Premium Cotton T-Shirt"
                            >

                            <span>
                            1
                        </span>

                        </div>


                        <div class="customer-checkout-product__info">

                            <strong>
                                Premium Cotton T-Shirt
                            </strong>

                            <span>
                            Black / M
                        </span>

                        </div>


                        <strong class="customer-checkout-product__price">
                            $29.99
                        </strong>

                    </div>


                    {{-- PRODUCT 2 --}}

                    <div class="customer-checkout-product">

                        <div class="customer-checkout-product__image">

                            <img
                                src="https://placehold.co/80x90"
                                alt="Everyday Backpack"
                            >

                            <span>
                            1
                        </span>

                        </div>


                        <div class="customer-checkout-product__info">

                            <strong>
                                Everyday Backpack
                            </strong>

                            <span>
                            Black
                        </span>

                        </div>


                        <strong class="customer-checkout-product__price">
                            $54.99
                        </strong>

                    </div>


                    {{-- PRODUCT 3 --}}

                    <div class="customer-checkout-product">

                        <div class="customer-checkout-product__image">

                            <img
                                src="https://placehold.co/80x90"
                                alt="Classic Ceramic Mug"
                            >

                            <span>
                            1
                        </span>

                        </div>


                        <div class="customer-checkout-product__info">

                            <strong>
                                Classic Ceramic Mug
                            </strong>

                            <span>
                            White / 350ml
                        </span>

                        </div>


                        <strong class="customer-checkout-product__price">
                            $19.99
                        </strong>

                    </div>


                    {{-- TOTALS --}}

                    <div class="customer-checkout-summary__totals">

                        <div>

                        <span>
                            Subtotal
                        </span>

                            <strong>
                                $104.97
                            </strong>

                        </div>


                        <div>

                        <span>
                            Shipping
                        </span>

                            <strong id="checkout-shipping">
                                Free
                            </strong>

                        </div>


                        <div>

                        <span>
                            Discount
                        </span>

                            <strong class="discount">
                                -$0.00
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


                    <div class="customer-checkout-summary__total">

                    <span>
                        Total
                    </span>

                        <strong id="checkout-total">
                            $104.97
                        </strong>

                    </div>


                    {{-- PROCEED TO PAYMENT --}}

                    <a
                        href="{{ route('ecommerce-payment') }}"
                        class="customer-checkout-payment-btn"
                        id="continue-payment"
                    >

                    <span>
                        Continue to Payment
                    </span>

                        <i class="ri-arrow-right-line"></i>

                    </a>


                    <p class="customer-checkout-terms">

                        By continuing, you agree to our
                        <a href="#">
                            Terms & Conditions
                        </a>
                        and
                        <a href="#">
                            Privacy Policy
                        </a>.

                    </p>

                </section>


                {{-- ======================================================== --}}
                {{-- DELIVERY ADDRESS PREVIEW --}}
                {{-- ======================================================== --}}

                <section class="customer-checkout-sidebar-card">

                    <div class="customer-checkout-sidebar-card__header">

                        <div class="customer-checkout-sidebar-card__icon">
                            <i class="ri-map-pin-2-line"></i>
                        </div>

                        <div>

                        <span>
                            Delivering To
                        </span>

                            <strong>
                                Shipping Address
                            </strong>

                        </div>

                    </div>


                    <div class="customer-checkout-sidebar-address">

                        <strong id="address-preview-name">
                            John Doe
                        </strong>

                        <p id="address-preview">
                            123 Main Street<br>
                            New York, NY 10001<br>
                            United States
                        </p>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- TRUST --}}
                {{-- ======================================================== --}}

                <div class="customer-checkout-trust">

                    <div class="customer-checkout-trust__icon">
                        <i class="ri-shield-check-line"></i>
                    </div>

                    <div>

                        <strong>
                            Safe & Secure
                        </strong>

                        <p>
                            Your data is encrypted and protected.
                        </p>

                    </div>

                </div>

            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- MOBILE BOTTOM --}}
        {{-- ================================================================ --}}

        <div class="customer-checkout-mobile-bar">

            <div>

            <span>
                Total
            </span>

                <strong id="mobile-checkout-total">
                    $104.97
                </strong>

            </div>


            <a href="{{ route('ecommerce-payment') }}">

                Continue

                <i class="ri-arrow-right-line"></i>

            </a>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                /*
                |--------------------------------------------------------------------------
                | SHIPPING METHOD
                |--------------------------------------------------------------------------
                */

                const shippingOptions =
                    document.querySelectorAll(
                        '.customer-checkout-shipping-option'
                    );


                const shippingTotal =
                    document.querySelector(
                        '#checkout-shipping'
                    );


                const checkoutTotal =
                    document.querySelector(
                        '#checkout-total'
                    );


                const mobileTotal =
                    document.querySelector(
                        '#mobile-checkout-total'
                    );


                const subtotal = 104.97;


                function money(value) {

                    return '$' + value.toFixed(2);

                }


                function updateShipping(method) {

                    let shipping = 0;


                    if (method === 'express') {

                        shipping = 12.99;

                    }


                    const total =
                        subtotal + shipping;


                    if (shippingTotal) {

                        shippingTotal.textContent =
                            shipping === 0
                                ? 'Free'
                                : money(shipping);

                    }


                    if (checkoutTotal) {

                        checkoutTotal.textContent =
                            money(total);

                    }


                    if (mobileTotal) {

                        mobileTotal.textContent =
                            money(total);

                    }

                }


                shippingOptions.forEach(
                    function (option) {

                        option.addEventListener(
                            'click',
                            function () {

                                shippingOptions.forEach(
                                    function (item) {

                                        item.classList.remove(
                                            'active'
                                        );

                                    }
                                );


                                option.classList.add(
                                    'active'
                                );


                                const radio =
                                    option.querySelector(
                                        'input[type="radio"]'
                                    );


                                if (radio) {

                                    radio.checked = true;

                                    updateShipping(
                                        radio.value
                                    );

                                }

                            }
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | FORM PREVIEW
                |--------------------------------------------------------------------------
                */

                const firstName =
                    document.querySelector(
                        '#checkout-first-name'
                    );


                const lastName =
                    document.querySelector(
                        '#checkout-last-name'
                    );


                const address =
                    document.querySelector(
                        '#checkout-address'
                    );


                const city =
                    document.querySelector(
                        '#checkout-city'
                    );


                const state =
                    document.querySelector(
                        '#checkout-state'
                    );


                const zip =
                    document.querySelector(
                        '#checkout-zip'
                    );


                const namePreview =
                    document.querySelector(
                        '#address-preview-name'
                    );


                const addressPreview =
                    document.querySelector(
                        '#address-preview'
                    );


                function updateAddressPreview() {

                    if (namePreview) {

                        const first =
                            firstName
                                ? firstName.value.trim()
                                : '';


                        const last =
                            lastName
                                ? lastName.value.trim()
                                : '';


                        const fullName =
                            (first + ' ' + last).trim();


                        namePreview.textContent =
                            fullName || 'John Doe';

                    }


                    if (addressPreview) {

                        const addressValue =
                            address
                                ? address.value.trim()
                                : '';


                        const cityValue =
                            city
                                ? city.value.trim()
                                : '';


                        const stateValue =
                            state
                                ? state.value.trim()
                                : '';


                        const zipValue =
                            zip
                                ? zip.value.trim()
                                : '';


                        const lines = [];


                        if (addressValue) {
                            lines.push(addressValue);
                        }


                        const cityState =
                            [cityValue, stateValue]
                                .filter(Boolean)
                                .join(', ');


                        if (cityState || zipValue) {

                            lines.push(
                                [cityState, zipValue]
                                    .filter(Boolean)
                                    .join(' ')
                            );

                        }


                        lines.push(
                            'United States'
                        );


                        addressPreview.innerHTML =
                            lines.join('<br>');

                    }

                }


                [
                    firstName,
                    lastName,
                    address,
                    city,
                    state,
                    zip
                ].forEach(
                    function (field) {

                        if (!field) {
                            return;
                        }


                        field.addEventListener(
                            'input',
                            updateAddressPreview
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | PAYMENT BUTTON
                |--------------------------------------------------------------------------
                */

                const paymentButton =
                    document.querySelector(
                        '#continue-payment'
                    );


                if (paymentButton) {

                    paymentButton.addEventListener(
                        'click',
                        function (event) {

                            /*
                             * Demo validation.
                             * Replace with backend validation later.
                             */

                            const requiredFields = [
                                document.querySelector('#checkout-email'),
                                firstName,
                                lastName,
                                address,
                                city,
                                state,
                                zip
                            ];


                            const hasEmptyField =
                                requiredFields.some(
                                    function (field) {

                                        return field &&
                                            !field.value.trim();

                                    }
                                );


                            if (hasEmptyField) {

                                event.preventDefault();


                                alert(
                                    'Please complete your shipping and contact information.'
                                );

                            }

                        }
                    );

                }

            });

        </script>

    @endpush

@endsection
