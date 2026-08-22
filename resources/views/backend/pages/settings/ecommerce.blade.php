@extends('backend.layouts.backend')

@section('title', 'Ecommerce Settings')

@section('content')

    <div class="settings-ecommerce-page">

        {{-- Page Header --}}
        <div class="settings-header">

            <div class="settings-header-text">

                <h1>
                    Ecommerce Settings
                </h1>

                <p>
                    Manage your store, checkout, order and payment preferences.
                </p>

            </div>

        </div>


        <form
            action="#"
            method="POST"
            class="settings-form"
        >

            @csrf


            {{-- =====================================================
                Store Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-store-2-line"></i>
                        </div>

                        <div>

                            <h2>
                                Store Settings
                            </h2>

                            <p>
                                Configure the basic settings for your online store.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Store Status --}}
                        <div class="form-group">

                            <label for="store_status">
                                Store Status
                            </label>

                            <select
                                id="store_status"
                                name="store_status"
                                class="form-control"
                            >

                                <option value="active" selected>
                                    Active
                                </option>

                                <option value="maintenance">
                                    Maintenance
                                </option>

                                <option value="disabled">
                                    Disabled
                                </option>

                            </select>

                        </div>


                        {{-- Default Currency --}}
                        <div class="form-group">

                            <label for="currency">
                                Currency
                            </label>

                            <select
                                id="currency"
                                name="currency"
                                class="form-control"
                            >

                                <option value="USD" selected>
                                    USD — US Dollar
                                </option>

                                <option value="EUR">
                                    EUR — Euro
                                </option>

                                <option value="GBP">
                                    GBP — British Pound
                                </option>

                                <option value="GNF">
                                    GNF — Guinean Franc
                                </option>

                            </select>

                        </div>


                        {{-- Currency Position --}}
                        <div class="form-group">

                            <label for="currency_position">
                                Currency Position
                            </label>

                            <select
                                id="currency_position"
                                name="currency_position"
                                class="form-control"
                            >

                                <option value="before" selected>
                                    Before Price — $100
                                </option>

                                <option value="after">
                                    After Price — 100$
                                </option>

                            </select>

                        </div>


                        {{-- Products Per Page --}}
                        <div class="form-group">

                            <label for="products_per_page">
                                Products Per Page
                            </label>

                            <input
                                type="number"
                                id="products_per_page"
                                name="products_per_page"
                                class="form-control"
                                value="12"
                                min="1"
                                max="100"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Order Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-shopping-bag-3-line"></i>
                        </div>

                        <div>

                            <h2>
                                Order Settings
                            </h2>

                            <p>
                                Control how customer orders are handled.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="preference-list">

                        {{-- Guest Checkout --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Guest Checkout
                                </h3>

                                <p>
                                    Allow customers to place orders without creating an account.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="guest_checkout"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Auto Confirm Orders --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Auto Confirm Orders
                                </h3>

                                <p>
                                    Automatically confirm new orders after successful checkout.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="auto_confirm_orders"
                                    value="1"
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Allow Order Cancellation --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Customer Order Cancellation
                                </h3>

                                <p>
                                    Allow customers to request cancellation of their orders.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="customer_order_cancellation"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Checkout Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-shopping-cart-2-line"></i>
                        </div>

                        <div>

                            <h2>
                                Checkout Settings
                            </h2>

                            <p>
                                Configure the customer checkout experience.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Checkout Page --}}
                        <div class="form-group">

                            <label for="checkout_page">
                                Checkout Page
                            </label>

                            <select
                                id="checkout_page"
                                name="checkout_page"
                                class="form-control"
                            >

                                <option value="standard" selected>
                                    Standard Checkout
                                </option>

                                <option value="one_page">
                                    One Page Checkout
                                </option>

                            </select>

                        </div>


                        {{-- Phone Required --}}
                        <div class="form-group">

                            <label for="phone_required">
                                Phone Requirement
                            </label>

                            <select
                                id="phone_required"
                                name="phone_required"
                                class="form-control"
                            >

                                <option value="required" selected>
                                    Required
                                </option>

                                <option value="optional">
                                    Optional
                                </option>

                            </select>

                        </div>


                        {{-- Terms --}}
                        <div class="form-group full-width">

                            <div class="inline-setting">

                                <div>

                                    <h3>
                                        Terms & Conditions
                                    </h3>

                                    <p>
                                        Require customers to accept the terms before placing an order.
                                    </p>

                                </div>

                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        name="require_terms"
                                        value="1"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Shipping Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <div>

                            <h2>
                                Shipping Settings
                            </h2>

                            <p>
                                Configure basic shipping and delivery options.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Shipping Status --}}
                        <div class="form-group">

                            <label for="shipping_status">
                                Shipping
                            </label>

                            <select
                                id="shipping_status"
                                name="shipping_status"
                                class="form-control"
                            >

                                <option value="enabled" selected>
                                    Enabled
                                </option>

                                <option value="disabled">
                                    Disabled
                                </option>

                            </select>

                        </div>


                        {{-- Default Shipping Method --}}
                        <div class="form-group">

                            <label for="shipping_method">
                                Default Shipping Method
                            </label>

                            <select
                                id="shipping_method"
                                name="shipping_method"
                                class="form-control"
                            >

                                <option value="standard" selected>
                                    Standard Shipping
                                </option>

                                <option value="express">
                                    Express Shipping
                                </option>

                                <option value="free">
                                    Free Shipping
                                </option>

                            </select>

                        </div>


                        {{-- Free Shipping Threshold --}}
                        <div class="form-group">

                            <label for="free_shipping_threshold">
                                Free Shipping Threshold
                            </label>

                            <input
                                type="number"
                                id="free_shipping_threshold"
                                name="free_shipping_threshold"
                                class="form-control"
                                value="100"
                                min="0"
                                step="0.01"
                            >

                        </div>


                        {{-- Processing Time --}}
                        <div class="form-group">

                            <label for="processing_time">
                                Processing Time
                            </label>

                            <select
                                id="processing_time"
                                name="processing_time"
                                class="form-control"
                            >

                                <option value="1-2">
                                    1–2 Business Days
                                </option>

                                <option value="2-3" selected>
                                    2–3 Business Days
                                </option>

                                <option value="3-5">
                                    3–5 Business Days
                                </option>

                                <option value="5-7">
                                    5–7 Business Days
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Payment Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-bank-card-line"></i>
                        </div>

                        <div>

                            <h2>
                                Payment Settings
                            </h2>

                            <p>
                                Select the payment methods available at checkout.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="payment-method-list">

                        {{-- Card --}}
                        <div class="payment-method-item">

                            <div class="payment-method-content">

                                <div class="payment-method-icon">
                                    <i class="ri-bank-card-line"></i>
                                </div>

                                <div>

                                    <h3>
                                        Credit / Debit Card
                                    </h3>

                                    <p>
                                        Accept card payments from customers.
                                    </p>

                                </div>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="payment_card"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Cash --}}
                        <div class="payment-method-item">

                            <div class="payment-method-content">

                                <div class="payment-method-icon">
                                    <i class="ri-money-dollar-circle-line"></i>
                                </div>

                                <div>

                                    <h3>
                                        Cash on Delivery
                                    </h3>

                                    <p>
                                        Allow customers to pay when their order arrives.
                                    </p>

                                </div>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="payment_cod"
                                    value="1"
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Bank Transfer --}}
                        <div class="payment-method-item">

                            <div class="payment-method-content">

                                <div class="payment-method-icon">
                                    <i class="ri-bank-line"></i>
                                </div>

                                <div>

                                    <h3>
                                        Bank Transfer
                                    </h3>

                                    <p>
                                        Allow customers to pay through a bank transfer.
                                    </p>

                                </div>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="payment_bank"
                                    value="1"
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Notification Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-notification-3-line"></i>
                        </div>

                        <div>

                            <h2>
                                Notifications
                            </h2>

                            <p>
                                Configure important ecommerce notifications.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="preference-list">

                        {{-- New Order --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    New Order Notification
                                </h3>

                                <p>
                                    Notify administrators when a new order is placed.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_new_order"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Payment --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Payment Notification
                                </h3>

                                <p>
                                    Notify administrators when an order payment is completed.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_payment"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Shipment --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Shipment Notification
                                </h3>

                                <p>
                                    Notify customers when their order shipment status changes.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_shipment"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Actions
            ====================================================== --}}
            <div class="settings-actions">

                <button
                    type="reset"
                    class="cancel-button"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="save-button"
                >

                    <i class="ri-save-line"></i>

                    Save Changes

                </button>

            </div>

        </form>

    </div>

@endsection
