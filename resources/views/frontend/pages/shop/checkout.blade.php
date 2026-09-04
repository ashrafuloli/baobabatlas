@extends('frontend.layouts.frontend')

@section('contents')

    <div class="checkout-page">

        <div class="container">

            {{-- Breadcrumb --}}
            <div class="checkout-breadcrumb">

                <a href="#">
                    Cart
                </a>

                <span class="breadcrumb-separator">
                <i class="ri-arrow-right-s-line"></i>
            </span>

                <span>
                Checkout
            </span>

            </div>


            {{-- Page Header --}}
            <div class="checkout-page__header">

                <div class="checkout-page__header-content">

                <span class="checkout-page__eyebrow">
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


            {{-- Main Checkout Layout --}}
            <div class="checkout-layout">

                {{-- =========================================
                    LEFT COLUMN
                ========================================== --}}
                <div class="checkout-main">


                    {{-- Contact Information --}}
                    <section class="checkout-card">

                        <div class="checkout-card__header">

                        <span class="checkout-card__eyebrow">
                            Contact Information
                        </span>

                            <h2>
                                Your Details
                            </h2>

                        </div>


                        <div class="checkout-card__body">

                            <div class="checkout-form">

                                {{-- Email --}}
                                <div class="form-group form-group--full">

                                    <label for="checkout-email">
                                        Email Address
                                    </label>

                                    <div class="input-with-icon">

                                        <i class="ri-mail-line"></i>

                                        <input
                                            type="email"
                                            id="checkout-email"
                                            name="email"
                                            placeholder="you@example.com"
                                            value="you@example.com"
                                        >

                                    </div>

                                </div>


                                {{-- First Name --}}
                                <div class="form-group">

                                    <label for="checkout-first-name">
                                        First Name
                                    </label>

                                    <input
                                        type="text"
                                        id="checkout-first-name"
                                        name="first_name"
                                        placeholder="John"
                                        value="John"
                                    >

                                </div>


                                {{-- Last Name --}}
                                <div class="form-group">

                                    <label for="checkout-last-name">
                                        Last Name
                                    </label>

                                    <input
                                        type="text"
                                        id="checkout-last-name"
                                        name="last_name"
                                        placeholder="Doe"
                                        value="Doe"
                                    >

                                </div>


                                {{-- Phone --}}
                                <div class="form-group form-group--full">

                                    <label for="checkout-phone">
                                        Phone Number
                                    </label>

                                    <div class="input-with-icon">

                                        <i class="ri-phone-line"></i>

                                        <input
                                            type="tel"
                                            id="checkout-phone"
                                            name="phone"
                                            placeholder="+1 555 123 4567"
                                            value="+1 555 123 4567"
                                        >

                                    </div>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- Shipping Address --}}
                    <section class="checkout-card">

                        <div class="checkout-card__header">

                        <span class="checkout-card__eyebrow">
                            Delivery Information
                        </span>

                            <h2>
                                Shipping Address
                            </h2>

                        </div>


                        <div class="checkout-card__body">

                            <div class="checkout-form">

                                {{-- Country --}}
                                <div class="form-group form-group--full">

                                    <label for="checkout-country">
                                        Country
                                    </label>

                                    <div class="select-wrapper">

                                        <select
                                            id="checkout-country"
                                            name="country"
                                        >

                                            <option value="">
                                                Select Country
                                            </option>

                                            <option value="us">
                                                United States
                                            </option>

                                            <option value="ca">
                                                Canada
                                            </option>

                                            <option value="uk">
                                                United Kingdom
                                            </option>

                                        </select>

                                        <i class="ri-arrow-down-s-line"></i>

                                    </div>

                                </div>


                                {{-- Street --}}
                                <div class="form-group form-group--full">

                                    <label for="checkout-address">
                                        Street Address
                                    </label>

                                    <div class="input-with-icon">

                                        <i class="ri-map-pin-line"></i>

                                        <input
                                            type="text"
                                            id="checkout-address"
                                            name="address"
                                            placeholder="123 Main Street"
                                            value="123 Main Street"
                                        >

                                    </div>

                                </div>


                                {{-- Apartment --}}
                                <div class="form-group">

                                    <label for="checkout-apartment">
                                        Apartment / Suite
                                        <span>Optional</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="checkout-apartment"
                                        name="apartment"
                                        placeholder="Apartment 4B"
                                    >

                                </div>


                                {{-- City --}}
                                <div class="form-group">

                                    <label for="checkout-city">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        id="checkout-city"
                                        name="city"
                                        placeholder="New York"
                                        value="New York"
                                    >

                                </div>


                                {{-- State --}}
                                <div class="form-group">

                                    <label for="checkout-state">
                                        State / Province
                                    </label>

                                    <input
                                        type="text"
                                        id="checkout-state"
                                        name="state"
                                        placeholder="New York"
                                        value="New York"
                                    >

                                </div>


                                {{-- ZIP --}}
                                <div class="form-group">

                                    <label for="checkout-zip">
                                        ZIP / Postal Code
                                    </label>

                                    <input
                                        type="text"
                                        id="checkout-zip"
                                        name="zip"
                                        placeholder="10001"
                                        value="10001"
                                    >

                                </div>


                                {{-- Save Address --}}
                                <div class="form-group form-group--full">

                                    <label class="checkout-checkbox">

                                        <input
                                            type="checkbox"
                                            name="save_address"
                                        >

                                        <span class="checkout-checkbox__mark"></span>

                                        <span class="checkout-checkbox__text">
                                        Save this address for future orders
                                    </span>

                                    </label>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- Shipping Method --}}
                    <section class="checkout-card d-none">

                        <div class="checkout-card__header">

                        <span class="checkout-card__eyebrow">
                            Delivery Options
                        </span>

                            <h2>
                                Shipping Method
                            </h2>

                        </div>


                        <div class="checkout-card__body">

                            <div class="shipping-methods">


                                {{-- Standard Shipping --}}
                                <label class="shipping-method is-selected">

                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        value="standard"
                                        checked
                                    >

                                    <span class="shipping-method__radio"></span>

                                    <span class="shipping-method__icon">
                                    <i class="ri-truck-line"></i>
                                </span>

                                    <span class="shipping-method__content">

                                    <strong>
                                        Standard Shipping
                                    </strong>

                                    <small>
                                        Estimated delivery: Aug 18 – Aug 20
                                    </small>

                                </span>

                                    <span class="shipping-method__price">
                                    Free
                                </span>

                                </label>


                                {{-- Express Shipping --}}
                                <label class="shipping-method">

                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        value="express"
                                    >

                                    <span class="shipping-method__radio"></span>

                                    <span class="shipping-method__icon">
                                    <i class="ri-flashlight-line"></i>
                                </span>

                                    <span class="shipping-method__content">

                                    <strong>
                                        Express Shipping
                                    </strong>

                                    <small>
                                        Estimated delivery: Aug 17 – Aug 18
                                    </small>

                                </span>

                                    <span class="shipping-method__price">
                                    $12.99
                                </span>

                                </label>

                            </div>

                        </div>

                    </section>



                    {{-- Order Notes --}}
                    <section class="checkout-card">

                        <div class="checkout-card__header">

                        <span class="checkout-card__eyebrow">
                            Additional Information
                        </span>

                            <h2>
                                Order Notes
                            </h2>

                        </div>


                        <div class="checkout-card__body">

                            <div class="checkout-form">

                                <div class="form-group form-group--full">

                                    <label for="checkout-notes">

                                        Special Instructions

                                        <span>
                                        Optional
                                    </span>

                                    </label>

                                    <textarea
                                        id="checkout-notes"
                                        name="notes"
                                        placeholder="Add any special instructions for your order..."
                                    ></textarea>

                                </div>

                            </div>

                        </div>

                    </section>



                    {{-- Secure Checkout Notice --}}
                    <div class="checkout-security">

                        <div class="checkout-security__icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div class="checkout-security__content">

                            <strong>
                                Secure Checkout
                            </strong>

                            <span>
                            Your personal information is protected and securely transmitted.
                        </span>

                        </div>

                    </div>

                </div>



                {{-- =========================================
                    RIGHT COLUMN
                ========================================== --}}
                <aside class="checkout-sidebar">


                    {{-- Order Summary --}}
                    <section class="order-summary">

                        <div class="order-summary__header">

                            <div>

                            <span class="order-summary__eyebrow">
                                Your Order
                            </span>

                                <h2>
                                    Order Summary
                                </h2>

                            </div>

                            <a href="{{route('my-cart')}}">
                                Edit
                            </a>

                        </div>


                        {{-- Products --}}
                        <div class="order-summary__products">


                            {{-- Product 1 --}}
                            <div class="summary-product">

                                <div class="summary-product__image">
                                <span>
                                    80 × 90
                                </span>

                                    <b>
                                        1
                                    </b>
                                </div>

                                <div class="summary-product__content">

                                    <strong>
                                        Premium Cotton T-Shirt
                                    </strong>

                                    <span>
                                    Black / M
                                </span>

                                </div>

                                <div class="summary-product__price">
                                    $29.99
                                </div>

                            </div>


                            {{-- Product 2 --}}
                            <div class="summary-product">

                                <div class="summary-product__image">

                                <span>
                                    80 × 90
                                </span>

                                    <b>
                                        1
                                    </b>

                                </div>

                                <div class="summary-product__content">

                                    <strong>
                                        Everyday Backpack
                                    </strong>

                                    <span>
                                    Black
                                </span>

                                </div>

                                <div class="summary-product__price">
                                    $54.99
                                </div>

                            </div>


                            {{-- Product 3 --}}
                            <div class="summary-product">

                                <div class="summary-product__image">

                                <span>
                                    80 × 90
                                </span>

                                    <b>
                                        1
                                    </b>

                                </div>

                                <div class="summary-product__content">

                                    <strong>
                                        Classic Ceramic Mug
                                    </strong>

                                    <span>
                                    White / 350ml
                                </span>

                                </div>

                                <div class="summary-product__price">
                                    $19.99
                                </div>

                            </div>

                        </div>


                        {{-- Summary Totals --}}
                        <div class="order-summary__totals">

                            <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                                <strong>
                                    $104.97
                                </strong>

                            </div>


                            <div class="summary-row">

                            <span>
                                Shipping
                            </span>

                                <strong>
                                    Free
                                </strong>

                            </div>


                            <div class="summary-row">

                            <span>
                                Discount
                            </span>

                                <strong class="is-discount">
                                    -$0.00
                                </strong>

                            </div>


                            <div class="summary-row">

                            <span>
                                Tax
                            </span>

                                <strong>
                                    $0.00
                                </strong>

                            </div>

                        </div>


                        {{-- Total --}}
                        <div class="order-summary__total">

                            <strong>
                                Total
                            </strong>

                            <strong>
                                $104.97
                            </strong>

                        </div>


                        {{-- Continue --}}
                        <button
                            type="button"
                            class="checkout-submit"
                        >

                        <span>
                            Continue to Payment
                        </span>

                            <i class="ri-arrow-right-line"></i>

                        </button>


                        {{-- Terms --}}
                        <div class="checkout-terms">

                            <p>
                                By continuing, you agree to our
                                <a href="#">
                                    Terms &amp; Conditions
                                </a>
                                and
                                <a href="#">
                                    Privacy Policy
                                </a>.
                            </p>

                        </div>

                    </section>



                    {{-- Secure Box --}}
                    <div class="checkout-sidebar-security">

                        <div class="checkout-sidebar-security__icon">
                            <i class="ri-shield-check-line"></i>
                        </div>

                        <div class="checkout-sidebar-security__content">

                            <strong>
                                Safe &amp; Secure
                            </strong>

                            <span>
                            Your data is encrypted and protected.
                        </span>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const checkoutPage =
                document.querySelector('.checkout-page');


            if (!checkoutPage) {
                return;
            }


            /*
            =========================================
                Shipping Method Selection
            =========================================
            */

            const shippingMethods =
                checkoutPage.querySelectorAll('.shipping-method');


            shippingMethods.forEach(function (method) {

                const radio =
                    method.querySelector('input[type="radio"]');


                if (!radio) {
                    return;
                }


                radio.addEventListener('change', function () {

                    if (!radio.checked) {
                        return;
                    }


                    shippingMethods.forEach(function (item) {

                        item.classList.remove('is-selected');

                    });


                    method.classList.add('is-selected');

                });

            });


            /*
            =========================================
                Country Select
            =========================================
            */

            const countrySelect =
                checkoutPage.querySelector('#checkout-country');


            if (countrySelect) {

                countrySelect.addEventListener('change', function () {

                    countrySelect.classList.toggle(
                        'has-value',
                        countrySelect.value !== ''
                    );

                });

            }


            /*
            =========================================
                Checkout Button
            =========================================
            */

            const checkoutButton =
                checkoutPage.querySelector('.checkout-submit');


            if (checkoutButton) {

                checkoutButton.addEventListener('click', function () {

                    checkoutButton.classList.add('is-processing');

                });

            }

        });

    </script>

@endsection
