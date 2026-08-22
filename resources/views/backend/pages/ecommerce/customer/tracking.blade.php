@extends('backend.layouts.backend')

@section('title', 'Track Order')

@section('content')

    <div class="customer-tracking-page">

        {{-- ================================================================ --}}
        {{-- BREADCRUMB --}}
        {{-- ================================================================ --}}

        <div class="customer-tracking-breadcrumb">

            <a href="{{ route('orders') }}">
                My Orders
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <a href="{{ route('order-details', ['order' => $order ?? 1]) }}">
                Order #ORD-2026-001
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Tracking
        </span>

        </div>


        {{-- ================================================================ --}}
        {{-- HEADER --}}
        {{-- ================================================================ --}}

        <div class="customer-tracking-header">

            <div>

            <span class="customer-tracking-header__eyebrow">
                Shipment Tracking
            </span>

                <h1>
                    Track Your Order
                </h1>

                <p>
                    Follow your package from shipment to delivery.
                </p>

            </div>


            <div class="customer-tracking-header__actions">

                <a
                    href="{{ route('order-details', ['order' => $order ?? 1]) }}"
                    class="customer-tracking-btn"
                >
                    <i class="ri-file-list-3-line"></i>
                    Order Details
                </a>

                <a
                    href="{{ route('ecommerce-shipment', ['order' => $order ?? 1]) }}"
                    class="customer-tracking-btn primary"
                >
                    <i class="ri-truck-line"></i>
                    Shipment Details
                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- TRACKING SEARCH --}}
        {{-- ================================================================ --}}

        <section class="customer-tracking-search-card">

            <div class="customer-tracking-search-card__content">

                <div class="customer-tracking-search-card__icon">
                    <i class="ri-map-pin-search-line"></i>
                </div>

                <div>

                    <h2>
                        Tracking Number
                    </h2>

                    <p>
                        Your package is currently being tracked using the number below.
                    </p>

                </div>

            </div>


            <div class="customer-tracking-number">

                <input
                    type="text"
                    value="FX123456789"
                    readonly
                    aria-label="Tracking number"
                    id="tracking-number"
                >

                <button
                    type="button"
                    data-copy-tracking
                    title="Copy tracking number"
                >
                    <i class="ri-file-copy-line"></i>
                    Copy
                </button>

            </div>

        </section>


        {{-- ================================================================ --}}
        {{-- CURRENT STATUS --}}
        {{-- ================================================================ --}}

        <section class="customer-tracking-current">

            <div class="customer-tracking-current__main">

                <div class="customer-tracking-current__icon">
                    <i class="ri-truck-fill"></i>
                </div>

                <div>

                <span>
                    Current Status
                </span>

                    <h2>
                        Delivered
                    </h2>

                    <p>
                        Your package was delivered successfully.
                    </p>

                </div>

            </div>


            <div class="customer-tracking-current__location">

            <span>
                Delivered To
            </span>

                <strong>
                    New York, NY
                </strong>

                <small>
                    Aug 15, 2026 · 02:30 PM
                </small>

            </div>

        </section>


        {{-- ================================================================ --}}
        {{-- MAIN LAYOUT --}}
        {{-- ================================================================ --}}

        <div class="customer-tracking-layout">


            {{-- ============================================================ --}}
            {{-- LEFT --}}
            {{-- ============================================================ --}}

            <main class="customer-tracking-main">


                {{-- ======================================================== --}}
                {{-- TRACKING TIMELINE --}}
                {{-- ======================================================== --}}

                <section class="customer-tracking-card">

                    <div class="customer-tracking-card__header">

                        <div>

                        <span>
                            Tracking History
                        </span>

                            <h2>
                                Shipment Journey
                            </h2>

                        </div>

                        <span class="customer-tracking-delivered-badge">
                        <i class="ri-checkbox-circle-fill"></i>
                        Delivered
                    </span>

                    </div>


                    <div class="customer-tracking-timeline">


                        {{-- DELIVERED --}}

                        <div class="customer-tracking-timeline__item active">

                            <div class="customer-tracking-timeline__marker">

                                <i class="ri-checkbox-circle-fill"></i>

                            </div>


                            <div class="customer-tracking-timeline__content">

                                <div class="customer-tracking-timeline__top">

                                    <div>

                                        <strong>
                                            Delivered
                                        </strong>

                                        <span>
                                        Aug 15, 2026 · 02:30 PM
                                    </span>

                                    </div>

                                    <em>
                                        New York, NY
                                    </em>

                                </div>


                                <p>
                                    Package delivered successfully to the shipping address.
                                </p>

                            </div>

                        </div>


                        {{-- OUT FOR DELIVERY --}}

                        <div class="customer-tracking-timeline__item completed">

                            <div class="customer-tracking-timeline__marker">

                                <i class="ri-truck-fill"></i>

                            </div>


                            <div class="customer-tracking-timeline__content">

                                <div class="customer-tracking-timeline__top">

                                    <div>

                                        <strong>
                                            Out for Delivery
                                        </strong>

                                        <span>
                                        Aug 15, 2026 · 08:20 AM
                                    </span>

                                    </div>

                                    <em>
                                        New York, NY
                                    </em>

                                </div>


                                <p>
                                    The package is out for delivery.
                                </p>

                            </div>

                        </div>


                        {{-- ARRIVED AT FACILITY --}}

                        <div class="customer-tracking-timeline__item completed">

                            <div class="customer-tracking-timeline__marker">

                                <i class="ri-building-2-line"></i>

                            </div>


                            <div class="customer-tracking-timeline__content">

                                <div class="customer-tracking-timeline__top">

                                    <div>

                                        <strong>
                                            Arrived at Local Facility
                                        </strong>

                                        <span>
                                        Aug 15, 2026 · 05:45 AM
                                    </span>

                                    </div>

                                    <em>
                                        New York, NY
                                    </em>

                                </div>


                                <p>
                                    Package arrived at the local delivery facility.
                                </p>

                            </div>

                        </div>


                        {{-- IN TRANSIT --}}

                        <div class="customer-tracking-timeline__item completed">

                            <div class="customer-tracking-timeline__marker">

                                <i class="ri-route-line"></i>

                            </div>


                            <div class="customer-tracking-timeline__content">

                                <div class="customer-tracking-timeline__top">

                                    <div>

                                        <strong>
                                            In Transit
                                        </strong>

                                        <span>
                                        Aug 14, 2026 · 09:45 AM
                                    </span>

                                    </div>

                                    <em>
                                        Philadelphia, PA
                                    </em>

                                </div>


                                <p>
                                    Package is moving through the carrier network.
                                </p>

                            </div>

                        </div>


                        {{-- PICKED UP --}}

                        <div class="customer-tracking-timeline__item completed">

                            <div class="customer-tracking-timeline__marker">

                                <i class="ri-box-3-line"></i>

                            </div>


                            <div class="customer-tracking-timeline__content">

                                <div class="customer-tracking-timeline__top">

                                    <div>

                                        <strong>
                                            Shipment Picked Up
                                        </strong>

                                        <span>
                                        Aug 13, 2026 · 04:15 PM
                                    </span>

                                    </div>

                                    <em>
                                        Newark, NJ
                                    </em>

                                </div>


                                <p>
                                    FedEx picked up the package from the seller.
                                </p>

                            </div>

                        </div>


                        {{-- LABEL CREATED --}}

                        <div class="customer-tracking-timeline__item completed last">

                            <div class="customer-tracking-timeline__marker">

                                <i class="ri-file-text-line"></i>

                            </div>


                            <div class="customer-tracking-timeline__content">

                                <div class="customer-tracking-timeline__top">

                                    <div>

                                        <strong>
                                            Shipping Label Created
                                        </strong>

                                        <span>
                                        Aug 13, 2026 · 10:30 AM
                                    </span>

                                    </div>

                                    <em>
                                        Newark, NJ
                                    </em>

                                </div>


                                <p>
                                    Shipment information was received by FedEx.
                                </p>

                            </div>

                        </div>


                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- DELIVERY ESTIMATE --}}
                {{-- ======================================================== --}}

                <section class="customer-tracking-delivery">

                    <div class="customer-tracking-delivery__icon">
                        <i class="ri-calendar-check-line"></i>
                    </div>


                    <div>

                    <span>
                        Delivery Completed
                    </span>

                        <strong>
                            August 15, 2026
                        </strong>

                        <p>
                            Your package arrived within the estimated delivery window.
                        </p>

                    </div>

                </section>


            </main>


            {{-- ============================================================ --}}
            {{-- SIDEBAR --}}
            {{-- ============================================================ --}}

            <aside class="customer-tracking-sidebar">


                {{-- ======================================================== --}}
                {{-- CARRIER --}}
                {{-- ======================================================== --}}

                <section class="customer-tracking-sidebar-card">

                    <div class="customer-tracking-sidebar-card__header">

                        <div class="customer-tracking-sidebar-card__icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <div>

                        <span>
                            Carrier
                        </span>

                            <strong>
                                FedEx
                            </strong>

                        </div>

                    </div>


                    <div class="customer-tracking-sidebar-card__body">

                        <div>

                        <span>
                            Service
                        </span>

                            <strong>
                                Standard Shipping
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
                            Status
                        </span>

                            <strong class="success">
                                Delivered
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- DESTINATION --}}
                {{-- ======================================================== --}}

                <section class="customer-tracking-sidebar-card">

                    <div class="customer-tracking-sidebar-card__header">

                        <div class="customer-tracking-sidebar-card__icon">
                            <i class="ri-map-pin-2-line"></i>
                        </div>

                        <div>

                        <span>
                            Destination
                        </span>

                            <strong>
                                Delivery Address
                            </strong>

                        </div>

                    </div>


                    <div class="customer-tracking-address">

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
                {{-- PACKAGE --}}
                {{-- ======================================================== --}}

                <section class="customer-tracking-sidebar-card">

                    <div class="customer-tracking-sidebar-card__header">

                        <div class="customer-tracking-sidebar-card__icon">
                            <i class="ri-box-3-line"></i>
                        </div>

                        <div>

                        <span>
                            Package
                        </span>

                            <strong>
                                Package Details
                            </strong>

                        </div>

                    </div>


                    <div class="customer-tracking-package">

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


                        <div>

                        <span>
                            Items
                        </span>

                            <strong>
                                3 Items
                            </strong>

                        </div>

                    </div>

                </section>


                {{-- ======================================================== --}}
                {{-- ORDER LINK --}}
                {{-- ======================================================== --}}

                <a
                    href="{{ route('order-details', ['order' => $order ?? 1]) }}"
                    class="customer-tracking-order-link"
                >
                    <i class="ri-file-list-3-line"></i>

                    <span>
                    View Order Details
                </span>

                    <i class="ri-arrow-right-line"></i>
                </a>

            </aside>

        </div>


        {{-- ================================================================ --}}
        {{-- FOOTER --}}
        {{-- ================================================================ --}}

        <div class="customer-tracking-footer">

            <a
                href="{{ route('orders') }}"
                class="customer-tracking-btn"
            >
                <i class="ri-arrow-left-line"></i>
                Back to Orders
            </a>


            <a
                href="{{ route('ecommerce-shipment', ['order' => $order ?? 1]) }}"
                class="customer-tracking-btn primary"
            >
                Shipment Details
                <i class="ri-arrow-right-line"></i>
            </a>

        </div>

    </div>


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const copyButton =
                    document.querySelector(
                        '[data-copy-tracking]'
                    );


                if (!copyButton) {
                    return;
                }


                copyButton.addEventListener(
                    'click',
                    async function () {

                        const input =
                            document.querySelector(
                                '#tracking-number'
                            );


                        if (!input) {
                            return;
                        }


                        const value =
                            input.value;


                        try {

                            await navigator.clipboard.writeText(
                                value
                            );


                            const original =
                                copyButton.innerHTML;


                            copyButton.innerHTML =
                                '<i class="ri-check-line"></i> Copied';


                            copyButton.classList.add(
                                'copied'
                            );


                            setTimeout(function () {

                                copyButton.innerHTML =
                                    original;

                                copyButton.classList.remove(
                                    'copied'
                                );

                            }, 1600);


                        } catch (error) {

                            input.select();

                            document.execCommand(
                                'copy'
                            );

                        }

                    }
                );

            });

        </script>

    @endpush

@endsection
