@extends('backend.layouts.backend')

@section('title', 'Order Details')

@section('content')

    <div class="customer-order-details-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-order-details-breadcrumb">

            <a href="{{ route('orders') }}">
                My Orders
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Order #ORD-2026-001
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-order-details-header">

            <div>

            <span class="customer-order-details-header__eyebrow">
                Order Details
            </span>

                <h1>
                    Order #ORD-2026-001
                </h1>

                <p>
                    Placed on August 12, 2026
                </p>

            </div>


            <div class="customer-order-details-header__actions">

                <a
                    href="{{ route('ecommerce-tracking', ['order' => 1]) }}"
                    class="customer-order-details-btn primary"
                >
                    <i class="ri-map-pin-line"></i>
                    Track Order
                </a>

                <a
                    href="{{ route('ecommerce-shipment', ['order' => 1]) }}"
                    class="customer-order-details-btn"
                >
                    <i class="ri-truck-line"></i>
                    Shipment
                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDER STATUS --}}
        {{-- ================================================================ --}}

        <div class="customer-order-details-status">

            <div class="customer-order-details-status__main">

                <div class="customer-order-details-status__icon">
                    <i class="ri-checkbox-circle-fill"></i>
                </div>

                <div>

                    <strong>
                        Delivered
                    </strong>

                    <span>
                    Your order was delivered successfully on August 15, 2026.
                </span>

                </div>

            </div>


            <a
                href="{{ route('ecommerce-tracking', ['order' => 1]) }}"
            >
                View Tracking
                <i class="ri-arrow-right-line"></i>
            </a>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDER CONTENT --}}
        {{-- ================================================================ --}}

        <div class="customer-order-details-layout">


            {{-- ============================================================ --}}
            {{-- LEFT COLUMN --}}
            {{-- ============================================================ --}}

            <div class="customer-order-details-main">


                {{-- ======================================================== --}}
                {{-- ORDER ITEMS --}}
                {{-- ======================================================== --}}

                <section class="customer-order-details-card">

                    <div class="customer-order-details-card__header">

                        <div>

                        <span>
                            Order Items
                        </span>

                            <h2>
                                Products in this order
                            </h2>

                        </div>

                        <strong>
                            3 Items
                        </strong>

                    </div>


                    <div class="customer-order-details-items">


                        {{-- ITEM 1 --}}

                        <div class="customer-order-details-item">

                            <div class="customer-order-details-item__image">

                                <img
                                    src="https://placehold.co/130x145"
                                    alt="Premium Cotton T-Shirt"
                                >

                            </div>


                            <div class="customer-order-details-item__info">

                            <span>
                                Clothing
                            </span>

                                <h3>
                                    Premium Cotton T-Shirt
                                </h3>

                                <p>
                                    Black / Medium
                                </p>

                                <small>
                                    SKU: TS-001
                                </small>

                            </div>


                            <div class="customer-order-details-item__quantity">

                            <span>
                                Quantity
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>


                            <div class="customer-order-details-item__price">

                            <span>
                                Price
                            </span>

                                <strong>
                                    $29.99
                                </strong>

                            </div>

                        </div>


                        {{-- ITEM 2 --}}

                        <div class="customer-order-details-item">

                            <div class="customer-order-details-item__image">

                                <img
                                    src="https://placehold.co/130x145"
                                    alt="Everyday Backpack"
                                >

                            </div>


                            <div class="customer-order-details-item__info">

                            <span>
                                Accessories
                            </span>

                                <h3>
                                    Everyday Backpack
                                </h3>

                                <p>
                                    Black
                                </p>

                                <small>
                                    SKU: BP-002
                                </small>

                            </div>


                            <div class="customer-order-details-item__quantity">

                            <span>
                                Quantity
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>


                            <div class="customer-order-details-item__price">

                            <span>
                                Price
                            </span>

                                <strong>
                                    $54.99
                                </strong>

                            </div>

                        </div>


                        {{-- ITEM 3 --}}

                        <div class="customer-order-details-item">

                            <div class="customer-order-details-item__image">

                                <img
                                    src="https://placehold.co/130x145"
                                    alt="Cotton Socks"
                                >

                            </div>


                            <div class="customer-order-details-item__info">

                            <span>
                                Accessories
                            </span>

                                <h3>
                                    Premium Cotton Socks
                                </h3>

                                <p>
                                    White / Free Size
                                </p>

                                <small>
                                    SKU: SK-003
                                </small>

                            </div>


                            <div class="customer-order-details-item__quantity">

                            <span>
                                Quantity
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>


                            <div class="customer-order-details-item__price">

                            <span>
                                Price
                            </span>

                                <strong>
                                    $12.99
                                </strong>

                            </div>

                        </div>


                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- ORDER TIMELINE --}}
                {{-- ======================================================== --}}

                <section class="customer-order-details-card">

                    <div class="customer-order-details-card__header">

                        <div>

                        <span>
                            Order Progress
                        </span>

                            <h2>
                                Delivery Status
                            </h2>

                        </div>

                    </div>


                    <div class="customer-order-timeline">


                        {{-- DELIVERED --}}

                        <div class="customer-order-timeline__item completed">

                            <div class="customer-order-timeline__marker">

                                <i class="ri-checkbox-circle-fill"></i>

                            </div>


                            <div class="customer-order-timeline__content">

                                <div>

                                    <strong>
                                        Delivered
                                    </strong>

                                    <span>
                                    Aug 15, 2026 · 02:30 PM
                                </span>

                                </div>

                                <p>
                                    Your order has been delivered successfully.
                                </p>

                            </div>

                        </div>


                        {{-- OUT FOR DELIVERY --}}

                        <div class="customer-order-timeline__item completed">

                            <div class="customer-order-timeline__marker">

                                <i class="ri-checkbox-circle-fill"></i>

                            </div>


                            <div class="customer-order-timeline__content">

                                <div>

                                    <strong>
                                        Out for Delivery
                                    </strong>

                                    <span>
                                    Aug 15, 2026 · 08:20 AM
                                </span>

                                </div>

                                <p>
                                    Your package is out for delivery.
                                </p>

                            </div>

                        </div>


                        {{-- SHIPPED --}}

                        <div class="customer-order-timeline__item completed">

                            <div class="customer-order-timeline__marker">

                                <i class="ri-checkbox-circle-fill"></i>

                            </div>


                            <div class="customer-order-timeline__content">

                                <div>

                                    <strong>
                                        Shipped
                                    </strong>

                                    <span>
                                    Aug 14, 2026 · 04:15 PM
                                </span>

                                </div>

                                <p>
                                    Your package has been handed over to the carrier.
                                </p>

                            </div>

                        </div>


                        {{-- PROCESSING --}}

                        <div class="customer-order-timeline__item completed">

                            <div class="customer-order-timeline__marker">

                                <i class="ri-checkbox-circle-fill"></i>

                            </div>


                            <div class="customer-order-timeline__content">

                                <div>

                                    <strong>
                                        Processing
                                    </strong>

                                    <span>
                                    Aug 13, 2026 · 10:30 AM
                                </span>

                                </div>

                                <p>
                                    Your order is being prepared for shipment.
                                </p>

                            </div>

                        </div>


                        {{-- PLACED --}}

                        <div class="customer-order-timeline__item completed last">

                            <div class="customer-order-timeline__marker">

                                <i class="ri-checkbox-circle-fill"></i>

                            </div>


                            <div class="customer-order-timeline__content">

                                <div>

                                    <strong>
                                        Order Placed
                                    </strong>

                                    <span>
                                    Aug 12, 2026 · 11:42 AM
                                </span>

                                </div>

                                <p>
                                    Your order has been successfully placed.
                                </p>

                            </div>

                        </div>


                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPING ADDRESS --}}
                {{-- ======================================================== --}}

                <section class="customer-order-details-card">

                    <div class="customer-order-details-card__header">

                        <div>

                        <span>
                            Delivery
                        </span>

                            <h2>
                                Shipping Address
                            </h2>

                        </div>

                        <a
                            href="{{ route('ecommerce-shipment', ['order' => 1]) }}"
                        >
                            Shipment Details
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>


                    <div class="customer-order-address">

                        <div class="customer-order-address__icon">

                            <i class="ri-map-pin-2-line"></i>

                        </div>


                        <div>

                            <strong>
                                John Doe
                            </strong>

                            <p>
                                123 Main Street<br>
                                Apartment 4B<br>
                                New York, NY 10001<br>
                                United States
                            </p>

                            <span>
                            <i class="ri-phone-line"></i>
                            +1 555 123 4567
                        </span>

                        </div>

                    </div>

                </section>


            </div>


            {{-- ============================================================ --}}
            {{-- RIGHT COLUMN --}}
            {{-- ============================================================ --}}

            <aside class="customer-order-details-sidebar">


                {{-- ======================================================== --}}
                {{-- ORDER SUMMARY --}}
                {{-- ======================================================== --}}

                <section class="customer-order-summary-card">

                    <div class="customer-order-summary-card__header">

                    <span>
                        Order Summary
                    </span>

                        <h2>
                            Payment Details
                        </h2>

                    </div>


                    <div class="customer-order-summary-row">

                    <span>
                        Subtotal
                    </span>

                        <strong>
                            $97.97
                        </strong>

                    </div>


                    <div class="customer-order-summary-row">

                    <span>
                        Shipping
                    </span>

                        <strong>
                            $0.00
                        </strong>

                    </div>


                    <div class="customer-order-summary-row">

                    <span>
                        Discount
                    </span>

                        <strong class="discount">
                            -$13.00
                        </strong>

                    </div>


                    <div class="customer-order-summary-row">

                    <span>
                        Tax
                    </span>

                        <strong>
                            $0.00
                        </strong>

                    </div>


                    <div class="customer-order-summary-total">

                    <span>
                        Total
                    </span>

                        <strong>
                            $84.97
                        </strong>

                    </div>


                    <div class="customer-order-payment">

                        <div class="customer-order-payment__icon">

                            <i class="ri-bank-card-line"></i>

                        </div>

                        <div>

                        <span>
                            Paid with
                        </span>

                            <strong>
                                Visa ending in 4242
                            </strong>

                        </div>

                        <i class="ri-checkbox-circle-fill"></i>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPING INFO --}}
                {{-- ======================================================== --}}

                <section class="customer-order-sidebar-card">

                    <div class="customer-order-sidebar-card__header">

                        <i class="ri-truck-line"></i>

                        <div>

                        <span>
                            Shipping Method
                        </span>

                            <strong>
                                Standard Shipping
                            </strong>

                        </div>

                    </div>


                    <div class="customer-order-sidebar-card__body">

                        <div>

                        <span>
                            Carrier
                        </span>

                            <strong>
                                FedEx
                            </strong>

                        </div>

                        <div>

                        <span>
                            Tracking Number
                        </span>

                            <strong>
                                FX123456789
                            </strong>

                        </div>

                        <div>

                        <span>
                            Estimated Delivery
                        </span>

                            <strong>
                                Aug 15, 2026
                            </strong>

                        </div>

                    </div>


                    <a
                        href="{{ route('ecommerce-tracking', ['order' => 1]) }}"
                        class="customer-order-sidebar-card__link"
                    >
                        Track Shipment
                        <i class="ri-arrow-right-line"></i>
                    </a>

                </section>


                {{-- ======================================================== --}}
                {{-- HELP --}}
                {{-- ======================================================== --}}

                <section class="customer-order-help-card">

                    <div class="customer-order-help-card__icon">

                        <i class="ri-customer-service-2-line"></i>

                    </div>

                    <div>

                        <h3>
                            Need Help?
                        </h3>

                        <p>
                            Have a question about this order?
                            Our support team is here to help.
                        </p>

                        <a href="#">
                            Contact Support
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>

                </section>


            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- BOTTOM ACTIONS --}}
        {{-- ================================================================ --}}

        <div class="customer-order-details-footer-actions">

            <a
                href="{{ route('orders') }}"
                class="customer-order-details-btn"
            >
                <i class="ri-arrow-left-line"></i>
                Back to Orders
            </a>


            <a
                href="{{ route('ecommerce-tracking', ['order' => 1]) }}"
                class="customer-order-details-btn primary"
            >
                <i class="ri-map-pin-line"></i>
                Track Order
            </a>

        </div>

    </div>

@endsection
