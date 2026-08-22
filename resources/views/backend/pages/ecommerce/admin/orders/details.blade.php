@extends('backend.layouts.backend')

@section('title', 'Order Details')

@section('content')

    <div class="order-details-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="order-details-page__header">

            <div>

                <a
                    href="{{ route('admin-orders') }}"
                    class="order-details-back"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back to Orders

                </a>


                <div class="order-details-title">

                    <div>

                    <span class="order-details-page__eyebrow">
                        Ecommerce / Orders
                    </span>

                        <h1>
                            Order #BA-1001
                        </h1>

                        <p>
                            Placed on August 15, 2026 at 10:42 AM
                        </p>

                    </div>


                    <span class="order-details-main-status order-details-main-status--processing">

                    <i></i>

                    Processing

                </span>

                </div>

            </div>


            <div class="order-details-page__actions">

                <button
                    type="button"
                    class="order-details-action-btn"
                >

                    <i class="ri-printer-line"></i>

                    Print

                </button>


                <button
                    type="button"
                    class="order-details-action-btn order-details-action-btn--primary"
                >

                    <i class="ri-edit-line"></i>

                    Update Order

                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDER SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="order-details-summary">


            <div class="order-details-summary__item">

            <span>
                Order Total
            </span>

                <strong>
                    $149.97
                </strong>

            </div>


            <div class="order-details-summary__item">

            <span>
                Items
            </span>

                <strong>
                    3
                </strong>

            </div>


            <div class="order-details-summary__item">

            <span>
                Payment
            </span>

                <strong class="order-details-summary__paid">
                    Paid
                </strong>

            </div>


            <div class="order-details-summary__item">

            <span>
                Shipment
            </span>

                <strong>
                    Not Shipped
                </strong>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN GRID --}}
        {{-- ================================================================ --}}

        <div class="order-details-grid">


            {{-- ============================================================ --}}
            {{-- LEFT COLUMN --}}
            {{-- ============================================================ --}}

            <div class="order-details-main">


                {{-- ======================================================== --}}
                {{-- ORDER ITEMS --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <div>

                            <h2>
                                Order Items
                            </h2>

                            <span>
                            3 products in this order
                        </span>

                        </div>

                    </div>


                    <div class="order-items-table-wrapper">

                        <table class="order-items-table">

                            <thead>

                            <tr>

                                <th>
                                    Product
                                </th>

                                <th>
                                    Price
                                </th>

                                <th>
                                    Quantity
                                </th>

                                <th>
                                    Total
                                </th>

                            </tr>

                            </thead>


                            <tbody>


                            {{-- Product 1 --}}

                            <tr>

                                <td>

                                    <div class="order-product">

                                        <div class="order-product__image">

                                            <img
                                                src="https://placehold.co/100x100"
                                                alt="Premium Cotton T-Shirt"
                                            >

                                        </div>


                                        <div class="order-product__content">

                                            <strong>
                                                Premium Cotton T-Shirt
                                            </strong>

                                            <span>
                                                SKU: BA-TS-001
                                            </span>

                                            <small>
                                                Size: M · Color: Black
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <strong>
                                        $39.99
                                    </strong>

                                </td>


                                <td>

                                    <span class="order-item-quantity">
                                        2
                                    </span>

                                </td>


                                <td>

                                    <strong>
                                        $79.98
                                    </strong>

                                </td>

                            </tr>


                            {{-- Product 2 --}}

                            <tr>

                                <td>

                                    <div class="order-product">

                                        <div class="order-product__image">

                                            <img
                                                src="https://placehold.co/100x100"
                                                alt="Leather Wallet"
                                            >

                                        </div>


                                        <div class="order-product__content">

                                            <strong>
                                                Leather Wallet
                                            </strong>

                                            <span>
                                                SKU: BA-LW-006
                                            </span>

                                            <small>
                                                Color: Brown
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <strong>
                                        $29.99
                                    </strong>

                                </td>


                                <td>

                                    <span class="order-item-quantity">
                                        1
                                    </span>

                                </td>


                                <td>

                                    <strong>
                                        $29.99
                                    </strong>

                                </td>

                            </tr>


                            {{-- Product 3 --}}

                            <tr>

                                <td>

                                    <div class="order-product">

                                        <div class="order-product__image">

                                            <img
                                                src="https://placehold.co/100x100"
                                                alt="Ceramic Coffee Mug"
                                            >

                                        </div>


                                        <div class="order-product__content">

                                            <strong>
                                                Ceramic Coffee Mug
                                            </strong>

                                            <span>
                                                SKU: BA-CM-005
                                            </span>

                                            <small>
                                                Color: White
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <strong>
                                        $19.99
                                    </strong>

                                </td>


                                <td>

                                    <span class="order-item-quantity">
                                        2
                                    </span>

                                </td>


                                <td>

                                    <strong>
                                        $39.98
                                    </strong>

                                </td>

                            </tr>


                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- ORDER TOTAL --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <div>

                            <h2>
                                Order Summary
                            </h2>

                        </div>

                    </div>


                    <div class="order-total-list">


                        <div class="order-total-row">

                        <span>
                            Subtotal
                        </span>

                            <strong>
                                $149.95
                            </strong>

                        </div>


                        <div class="order-total-row">

                        <span>
                            Shipping
                        </span>

                            <strong>
                                $0.00
                            </strong>

                        </div>


                        <div class="order-total-row">

                        <span>
                            Tax
                        </span>

                            <strong>
                                $0.02
                            </strong>

                        </div>


                        <div class="order-total-row order-total-row--grand">

                        <span>
                            Total
                        </span>

                            <strong>
                                $149.97
                            </strong>

                        </div>


                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SHIPMENT --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <div>

                            <h2>
                                Ecommerce Shipment
                            </h2>

                            <span>
                            Shipment information for this order
                        </span>

                        </div>


                        <span class="order-shipment-status order-shipment-status--pending">

                        <i></i>

                        Not Shipped

                    </span>

                    </div>


                    <div class="order-shipment-box">


                        <div class="order-shipment-info">

                        <span>
                            Carrier
                        </span>

                            <strong>
                                —
                            </strong>

                        </div>


                        <div class="order-shipment-info">

                        <span>
                            Tracking Number
                        </span>

                            <strong>
                                —
                            </strong>

                        </div>


                        <div class="order-shipment-info">

                        <span>
                            Shipment Status
                        </span>

                            <strong>
                                Not Shipped
                            </strong>

                        </div>


                        <div class="order-shipment-info">

                        <span>
                            Delivery Status
                        </span>

                            <strong>
                                —
                            </strong>

                        </div>


                    </div>


                    <div class="order-shipment-action">

                        <a
                            href="{{ route('ecommerce-shipments') }}"
                            class="order-details-secondary-btn"
                        >

                            <i class="ri-truck-line"></i>

                            Manage Shipment

                        </a>

                    </div>

                </div>


            </div>


            {{-- ============================================================ --}}
            {{-- RIGHT COLUMN --}}
            {{-- ============================================================ --}}

            <div class="order-details-sidebar">


                {{-- ======================================================== --}}
                {{-- CUSTOMER --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Customer
                        </h2>

                    </div>


                    <div class="order-customer-profile">

                        <div class="order-customer-profile__avatar">
                            JD
                        </div>


                        <div>

                            <strong>
                                John Doe
                            </strong>

                            <span>
                            Customer
                        </span>

                        </div>

                    </div>


                    <div class="order-customer-contact">


                        <div>

                            <i class="ri-mail-line"></i>

                            <span>
                            john@example.com
                        </span>

                        </div>


                        <div>

                            <i class="ri-phone-line"></i>

                            <span>
                            +1 202 555 0147
                        </span>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SHIPPING ADDRESS --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Shipping Address
                        </h2>

                    </div>


                    <div class="order-address">

                        <strong>
                            John Doe
                        </strong>

                        <span>
                        123 Main Street
                    </span>

                        <span>
                        Apt 4B
                    </span>

                        <span>
                        New York, NY 10001
                    </span>

                        <span>
                        United States
                    </span>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- BILLING ADDRESS --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Billing Address
                        </h2>

                    </div>


                    <div class="order-address">

                        <strong>
                            John Doe
                        </strong>

                        <span>
                        123 Main Street
                    </span>

                        <span>
                        Apt 4B
                    </span>

                        <span>
                        New York, NY 10001
                    </span>

                        <span>
                        United States
                    </span>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- PAYMENT --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Payment
                        </h2>

                    </div>


                    <div class="order-payment-details">


                        <div>

                        <span>
                            Payment Status
                        </span>

                            <span class="order-payment-status order-payment-status--paid">

                            <i></i>

                            Paid

                        </span>

                        </div>


                        <div>

                        <span>
                            Method
                        </span>

                            <strong>
                                Credit Card
                            </strong>

                        </div>


                        <div>

                        <span>
                            Transaction
                        </span>

                            <strong>
                                TXN-BA-893421
                            </strong>

                        </div>


                        <div>

                        <span>
                            Amount
                        </span>

                            <strong>
                                $149.97
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- ORDER NOTES --}}
                {{-- ======================================================== --}}

                <div class="order-details-card">

                    <div class="order-details-card__header">

                        <h2>
                            Order Notes
                        </h2>

                    </div>


                    <div class="order-note">

                        <i class="ri-information-line"></i>

                        <p>
                            Please deliver the order between 9 AM and 5 PM.
                        </p>

                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection
