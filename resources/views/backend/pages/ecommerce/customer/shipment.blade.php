@extends('backend.layouts.backend')

@section('title', 'Shipment Details')

@section('content')

    <div class="customer-shipment-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-shipment-breadcrumb">

            <a href="{{ route('orders') }}">
                My Orders
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <a href="{{ route('order-details', ['order' => $order ?? 1]) }}">
                Order #ORD-2026-001
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Shipment
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-shipment-header">

            <div>

            <span class="customer-shipment-header__eyebrow">
                Delivery
            </span>

                <h1>
                    Shipment Details
                </h1>

                <p>
                    Track the delivery information for order #ORD-2026-001.
                </p>

            </div>


            <div class="customer-shipment-header__actions">

                <a
                    href="{{ route('order-details', ['order' => $order ?? 1]) }}"
                    class="customer-shipment-btn"
                >
                    <i class="ri-arrow-left-line"></i>
                    Order Details
                </a>

                <a
                    href="{{ route('ecommerce-tracking', ['order' => $order ?? 1]) }}"
                    class="customer-shipment-btn primary"
                >
                    <i class="ri-map-pin-line"></i>
                    Track Shipment
                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- SHIPMENT STATUS --}}
        {{-- ================================================================ --}}

        <div class="customer-shipment-status">

            <div class="customer-shipment-status__main">

                <div class="customer-shipment-status__icon">
                    <i class="ri-truck-fill"></i>
                </div>

                <div>

                <span>
                    Current Status
                </span>

                    <strong>
                        Delivered
                    </strong>

                    <p>
                        Your shipment was delivered successfully on August 15, 2026.
                    </p>

                </div>

            </div>


            <div class="customer-shipment-status__date">

            <span>
                Delivered On
            </span>

                <strong>
                    Aug 15, 2026
                </strong>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN GRID --}}
        {{-- ================================================================ --}}

        <div class="customer-shipment-layout">


            {{-- ============================================================ --}}
            {{-- MAIN CONTENT --}}
            {{-- ============================================================ --}}

            <main class="customer-shipment-main">


                {{-- ======================================================== --}}
                {{-- CARRIER INFORMATION --}}
                {{-- ======================================================== --}}

                <section class="customer-shipment-card">

                    <div class="customer-shipment-card__header">

                        <div>

                        <span>
                            Shipment Information
                        </span>

                            <h2>
                                Carrier Details
                            </h2>

                        </div>

                        <span class="customer-shipment-carrier-status">
                        <i class="ri-checkbox-circle-fill"></i>
                        Delivered
                    </span>

                    </div>


                    <div class="customer-shipment-carrier">

                        <div class="customer-shipment-carrier__logo">
                            <i class="ri-truck-line"></i>
                        </div>


                        <div class="customer-shipment-carrier__info">

                        <span>
                            Carrier
                        </span>

                            <strong>
                                FedEx
                            </strong>

                            <p>
                                Standard Shipping
                            </p>

                        </div>


                        <div class="customer-shipment-carrier__tracking">

                        <span>
                            Tracking Number
                        </span>

                            <strong>
                                FX123456789
                            </strong>

                            <button
                                type="button"
                                class="customer-shipment-copy"
                                data-copy="FX123456789"
                                title="Copy tracking number"
                            >
                                <i class="ri-file-copy-line"></i>
                            </button>

                        </div>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- DELIVERY PROGRESS --}}
                {{-- ======================================================== --}}

                <section class="customer-shipment-card">

                    <div class="customer-shipment-card__header">

                        <div>

                        <span>
                            Shipment Progress
                        </span>

                            <h2>
                                Delivery Timeline
                            </h2>

                        </div>

                        <a
                            href="{{ route('ecommerce-tracking', ['order' => $order ?? 1]) }}"
                        >
                            Full Tracking
                            <i class="ri-arrow-right-line"></i>
                        </a>

                    </div>


                    <div class="customer-shipment-timeline">


                        {{-- DELIVERED --}}

                        <div class="customer-shipment-timeline__item completed">

                            <div class="customer-shipment-timeline__marker">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>

                            <div class="customer-shipment-timeline__content">

                                <div>

                                    <strong>
                                        Delivered
                                    </strong>

                                    <span>
                                    Aug 15, 2026 · 02:30 PM
                                </span>

                                </div>

                                <p>
                                    Package delivered successfully to the shipping address.
                                </p>

                            </div>

                        </div>


                        {{-- OUT FOR DELIVERY --}}

                        <div class="customer-shipment-timeline__item completed">

                            <div class="customer-shipment-timeline__marker">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>

                            <div class="customer-shipment-timeline__content">

                                <div>

                                    <strong>
                                        Out for Delivery
                                    </strong>

                                    <span>
                                    Aug 15, 2026 · 08:20 AM
                                </span>

                                </div>

                                <p>
                                    The package is out for delivery.
                                </p>

                            </div>

                        </div>


                        {{-- IN TRANSIT --}}

                        <div class="customer-shipment-timeline__item completed">

                            <div class="customer-shipment-timeline__marker">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>

                            <div class="customer-shipment-timeline__content">

                                <div>

                                    <strong>
                                        In Transit
                                    </strong>

                                    <span>
                                    Aug 14, 2026 · 09:45 AM
                                </span>

                                </div>

                                <p>
                                    Package is moving through the carrier network.
                                </p>

                            </div>

                        </div>


                        {{-- SHIPPED --}}

                        <div class="customer-shipment-timeline__item completed">

                            <div class="customer-shipment-timeline__marker">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>

                            <div class="customer-shipment-timeline__content">

                                <div>

                                    <strong>
                                        Shipment Picked Up
                                    </strong>

                                    <span>
                                    Aug 13, 2026 · 04:15 PM
                                </span>

                                </div>

                                <p>
                                    Carrier picked up the package from the seller.
                                </p>

                            </div>

                        </div>


                        {{-- LABEL CREATED --}}

                        <div class="customer-shipment-timeline__item completed last">

                            <div class="customer-shipment-timeline__marker">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>

                            <div class="customer-shipment-timeline__content">

                                <div>

                                    <strong>
                                        Shipping Label Created
                                    </strong>

                                    <span>
                                    Aug 13, 2026 · 10:30 AM
                                </span>

                                </div>

                                <p>
                                    Shipment information was received by the carrier.
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- SHIPPED ITEMS --}}
                {{-- ======================================================== --}}

                <section class="customer-shipment-card">

                    <div class="customer-shipment-card__header">

                        <div>

                        <span>
                            Package Contents
                        </span>

                            <h2>
                                Shipped Items
                            </h2>

                        </div>

                        <strong>
                            3 Items
                        </strong>

                    </div>


                    <div class="customer-shipment-items">


                        <div class="customer-shipment-item">

                            <div class="customer-shipment-item__image">

                                <img
                                    src="https://placehold.co/100x110"
                                    alt="Premium Cotton T-Shirt"
                                >

                            </div>

                            <div class="customer-shipment-item__info">

                            <span>
                                Clothing
                            </span>

                                <h3>
                                    Premium Cotton T-Shirt
                                </h3>

                                <p>
                                    Black / Medium
                                </p>

                            </div>

                            <div class="customer-shipment-item__qty">

                            <span>
                                Qty
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>

                        </div>


                        <div class="customer-shipment-item">

                            <div class="customer-shipment-item__image">

                                <img
                                    src="https://placehold.co/100x110"
                                    alt="Everyday Backpack"
                                >

                            </div>

                            <div class="customer-shipment-item__info">

                            <span>
                                Accessories
                            </span>

                                <h3>
                                    Everyday Backpack
                                </h3>

                                <p>
                                    Black
                                </p>

                            </div>

                            <div class="customer-shipment-item__qty">

                            <span>
                                Qty
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>

                        </div>


                        <div class="customer-shipment-item">

                            <div class="customer-shipment-item__image">

                                <img
                                    src="https://placehold.co/100x110"
                                    alt="Premium Cotton Socks"
                                >

                            </div>

                            <div class="customer-shipment-item__info">

                            <span>
                                Accessories
                            </span>

                                <h3>
                                    Premium Cotton Socks
                                </h3>

                                <p>
                                    White / Free Size
                                </p>

                            </div>

                            <div class="customer-shipment-item__qty">

                            <span>
                                Qty
                            </span>

                                <strong>
                                    1
                                </strong>

                            </div>

                        </div>

                    </div>

                </section>


            </main>


            {{-- ============================================================ --}}
            {{-- SIDEBAR --}}
            {{-- ============================================================ --}}

            <aside class="customer-shipment-sidebar">


                {{-- ======================================================== --}}
                {{-- DELIVERY ADDRESS --}}
                {{-- ======================================================== --}}

                <section class="customer-shipment-sidebar-card">

                    <div class="customer-shipment-sidebar-card__header">

                        <i class="ri-map-pin-2-line"></i>

                        <div>

                        <span>
                            Delivering To
                        </span>

                            <strong>
                                Shipping Address
                            </strong>

                        </div>

                    </div>


                    <div class="customer-shipment-address">

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

                </section>


                {{-- ======================================================== --}}
                {{-- PACKAGE INFO --}}
                {{-- ======================================================== --}}

                <section class="customer-shipment-sidebar-card">

                    <div class="customer-shipment-sidebar-card__header">

                        <i class="ri-box-3-line"></i>

                        <div>

                        <span>
                            Package
                        </span>

                            <strong>
                                Package Information
                            </strong>

                        </div>

                    </div>


                    <div class="customer-shipment-package">

                        <div>

                        <span>
                            Package Type
                        </span>

                            <strong>
                                Standard Box
                            </strong>

                        </div>

                        <div>

                        <span>
                            Weight
                        </span>

                            <strong>
                                2.4 kg
                            </strong>

                        </div>

                        <div>

                        <span>
                            Dimensions
                        </span>

                            <strong>
                                32 × 24 × 14 cm
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- ESTIMATED DELIVERY --}}
                {{-- ======================================================== --}}

                <section class="customer-shipment-delivery-card">

                    <div class="customer-shipment-delivery-card__icon">

                        <i class="ri-calendar-check-line"></i>

                    </div>

                    <div>

                    <span>
                        Delivered On
                    </span>

                        <strong>
                            August 15, 2026
                        </strong>

                        <p>
                            Your package has arrived at its destination.
                        </p>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- TRACK BUTTON --}}
                {{-- ======================================================== --}}

                <a
                    href="{{ route('ecommerce-tracking', ['order' => $order ?? 1]) }}"
                    class="customer-shipment-track-btn"
                >
                    <i class="ri-map-pin-line"></i>
                    View Live Tracking
                    <i class="ri-arrow-right-line"></i>
                </a>


            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- FOOTER ACTIONS --}}
        {{-- ================================================================ --}}

        <div class="customer-shipment-footer">

            <a
                href="{{ route('orders') }}"
                class="customer-shipment-btn"
            >
                <i class="ri-arrow-left-line"></i>
                Back to Orders
            </a>

            <a
                href="{{ route('ecommerce-tracking', ['order' => $order ?? 1]) }}"
                class="customer-shipment-btn primary"
            >
                Track Shipment
                <i class="ri-arrow-right-line"></i>
            </a>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const copyButtons =
                    document.querySelectorAll(
                        '[data-copy]'
                    );


                copyButtons.forEach(function (button) {

                    button.addEventListener(
                        'click',
                        async function () {

                            const value =
                                button.dataset.copy;

                            if (!value) {
                                return;
                            }


                            try {

                                await navigator.clipboard.writeText(
                                    value
                                );

                                const original =
                                    button.innerHTML;

                                button.innerHTML =
                                    '<i class="ri-check-line"></i>';

                                button.classList.add(
                                    'copied'
                                );


                                setTimeout(function () {

                                    button.innerHTML =
                                        original;

                                    button.classList.remove(
                                        'copied'
                                    );

                                }, 1500);


                            } catch (error) {

                                console.error(
                                    'Unable to copy tracking number.',
                                    error
                                );

                            }

                        }
                    );

                });

            });

        </script>

    @endpush

@endsection
