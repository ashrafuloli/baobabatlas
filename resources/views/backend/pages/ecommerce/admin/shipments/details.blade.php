@extends('backend.layouts.backend')

@section('title', 'Shipment Details')

@section('content')

    <div class="shipment-details-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="shipment-details-page__header">

            <div>

                <a
                    href="{{ route('ecommerce-shipments') }}"
                    class="shipment-details-back"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back to Shipments

                </a>


                <div class="shipment-details-title">

                    <div>

                    <span class="shipment-details-page__eyebrow">
                        Ecommerce / Shipments
                    </span>

                        <h1>
                            Shipment #SHP-BA-001
                        </h1>

                        <p>
                            Created on August 15, 2026 at 10:48 AM
                        </p>

                    </div>


                    <span class="shipment-main-status shipment-main-status--processing">

                    <i></i>

                    Processing

                </span>

                </div>

            </div>


            <div class="shipment-details-page__actions">

                <a
                    href="{{ route('ecommerce-shipments') }}"
                    class="shipment-action-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    Back

                </a>


                <a
                    href="{{ route('ecommerce-shipment-create') }}"
                    class="shipment-action-btn shipment-action-btn--primary"
                >

                    <i class="ri-add-line"></i>

                    New Shipment

                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- SHIPMENT SUMMARY --}}
        {{-- ================================================================ --}}

        <div class="shipment-summary">


            {{-- Shipment ID --}}
            <div class="shipment-summary__item">

            <span>
                Shipment
            </span>

                <strong>
                    #SHP-BA-001
                </strong>

            </div>


            {{-- Order --}}
            <div class="shipment-summary__item">

            <span>
                Order
            </span>

                <a
                    href="{{ route('admin-order-details', ['order' => 1001]) }}"
                >
                    #BA-1001
                </a>

            </div>


            {{-- Carrier --}}
            <div class="shipment-summary__item">

            <span>
                Carrier
            </span>

                <strong>
                    DHL
                </strong>

            </div>


            {{-- Delivery --}}
            <div class="shipment-summary__item">

            <span>
                Delivery Status
            </span>

                <strong class="shipment-summary__success">
                    Pending
                </strong>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- MAIN GRID --}}
        {{-- ================================================================ --}}

        <div class="shipment-details-grid">


            {{-- ============================================================ --}}
            {{-- LEFT COLUMN --}}
            {{-- ============================================================ --}}

            <div class="shipment-details-main">


                {{-- ======================================================== --}}
                {{-- SHIPMENT INFORMATION --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <div>

                            <h2>
                                Shipment Information
                            </h2>

                            <span>
                            Basic shipment and carrier information.
                        </span>

                        </div>

                    </div>


                    <div class="shipment-info-grid">


                        <div class="shipment-info-item">

                        <span>
                            Shipment ID
                        </span>

                            <strong>
                                SHP-BA-001
                            </strong>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Order ID
                        </span>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                            >
                                #BA-1001
                            </a>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Carrier
                        </span>

                            <strong>
                                DHL
                            </strong>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Tracking Number
                        </span>

                            <strong>
                                DHL-784521963
                            </strong>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Shipment Status
                        </span>

                            <span class="shipment-status shipment-status--processing">

                            <i></i>

                            Processing

                        </span>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Delivery Status
                        </span>

                            <span class="shipment-status shipment-status--pending">

                            <i></i>

                            Pending

                        </span>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Created Date
                        </span>

                            <strong>
                                Aug 15, 2026
                            </strong>

                        </div>


                        <div class="shipment-info-item">

                        <span>
                            Estimated Delivery
                        </span>

                            <strong>
                                Aug 20, 2026
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- TRACKING --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <div>

                            <h2>
                                Shipment Tracking
                            </h2>

                            <span>
                            Current shipment progress and tracking history.
                        </span>

                        </div>

                    </div>


                    <div class="shipment-tracking">


                        {{-- Step 1 --}}
                        <div class="shipment-tracking__item shipment-tracking__item--completed">

                            <div class="shipment-tracking__indicator">

                                <i class="ri-check-line"></i>

                            </div>


                            <div class="shipment-tracking__content">

                                <strong>
                                    Shipment Created
                                </strong>

                                <span>
                                Shipment has been created successfully.
                            </span>

                                <small>
                                    Aug 15, 2026 · 10:48 AM
                                </small>

                            </div>

                        </div>


                        {{-- Step 2 --}}
                        <div class="shipment-tracking__item shipment-tracking__item--active">

                            <div class="shipment-tracking__indicator">

                                <i class="ri-truck-line"></i>

                            </div>


                            <div class="shipment-tracking__content">

                                <strong>
                                    Processing
                                </strong>

                                <span>
                                Shipment is being prepared for dispatch.
                            </span>

                                <small>
                                    Aug 15, 2026 · 11:15 AM
                                </small>

                            </div>

                        </div>


                        {{-- Step 3 --}}
                        <div class="shipment-tracking__item">

                            <div class="shipment-tracking__indicator">

                                <i class="ri-route-line"></i>

                            </div>


                            <div class="shipment-tracking__content">

                                <strong>
                                    In Transit
                                </strong>

                                <span>
                                Shipment will be in transit after dispatch.
                            </span>

                            </div>

                        </div>


                        {{-- Step 4 --}}
                        <div class="shipment-tracking__item">

                            <div class="shipment-tracking__indicator">

                                <i class="ri-map-pin-line"></i>

                            </div>


                            <div class="shipment-tracking__content">

                                <strong>
                                    Out for Delivery
                                </strong>

                                <span>
                                Shipment will be delivered to the customer.
                            </span>

                            </div>

                        </div>


                        {{-- Step 5 --}}
                        <div class="shipment-tracking__item">

                            <div class="shipment-tracking__indicator">

                                <i class="ri-checkbox-circle-line"></i>

                            </div>


                            <div class="shipment-tracking__content">

                                <strong>
                                    Delivered
                                </strong>

                                <span>
                                Shipment will be marked as delivered.
                            </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- SHIPPING ADDRESS --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <div>

                            <h2>
                                Shipping Address
                            </h2>

                            <span>
                            Customer delivery address.
                        </span>

                        </div>

                    </div>


                    <div class="shipment-address">

                        <div class="shipment-address__icon">

                            <i class="ri-map-pin-line"></i>

                        </div>


                        <div class="shipment-address__content">

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

                            <span>
                            +1 202 555 0147
                        </span>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- ORDER ITEMS --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <div>

                            <h2>
                                Shipment Items
                            </h2>

                            <span>
                            Products included in this shipment.
                        </span>

                        </div>

                    </div>


                    <div class="shipment-items-table-wrapper">

                        <table class="shipment-items-table">

                            <thead>

                            <tr>

                                <th>
                                    Product
                                </th>

                                <th>
                                    SKU
                                </th>

                                <th>
                                    Quantity
                                </th>

                            </tr>

                            </thead>


                            <tbody>


                            <tr>

                                <td>

                                    <div class="shipment-product">

                                        <div class="shipment-product__image">

                                            <img
                                                src="https://placehold.co/80x80"
                                                alt="Premium Cotton T-Shirt"
                                            >

                                        </div>


                                        <div>

                                            <strong>
                                                Premium Cotton T-Shirt
                                            </strong>

                                            <span>
                                                Size: M · Color: Black
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>
                                    BA-TS-001
                                </td>


                                <td>

                                    <span class="shipment-quantity">
                                        2
                                    </span>

                                </td>

                            </tr>


                            <tr>

                                <td>

                                    <div class="shipment-product">

                                        <div class="shipment-product__image">

                                            <img
                                                src="https://placehold.co/80x80"
                                                alt="Leather Wallet"
                                            >

                                        </div>


                                        <div>

                                            <strong>
                                                Leather Wallet
                                            </strong>

                                            <span>
                                                Color: Brown
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>
                                    BA-LW-006
                                </td>


                                <td>

                                    <span class="shipment-quantity">
                                        1
                                    </span>

                                </td>

                            </tr>


                            <tr>

                                <td>

                                    <div class="shipment-product">

                                        <div class="shipment-product__image">

                                            <img
                                                src="https://placehold.co/80x80"
                                                alt="Ceramic Coffee Mug"
                                            >

                                        </div>


                                        <div>

                                            <strong>
                                                Ceramic Coffee Mug
                                            </strong>

                                            <span>
                                                Color: White
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>
                                    BA-CM-005
                                </td>


                                <td>

                                    <span class="shipment-quantity">
                                        2
                                    </span>

                                </td>

                            </tr>


                            </tbody>

                        </table>

                    </div>

                </div>


            </div>


            {{-- ============================================================ --}}
            {{-- RIGHT SIDEBAR --}}
            {{-- ============================================================ --}}

            <div class="shipment-details-sidebar">


                {{-- ======================================================== --}}
                {{-- CUSTOMER --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <h2>
                            Customer
                        </h2>

                    </div>


                    <div class="shipment-customer">

                        <div class="shipment-customer__avatar">
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


                    <div class="shipment-customer-contact">

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
                {{-- CARRIER --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <h2>
                            Carrier
                        </h2>

                    </div>


                    <div class="shipment-carrier-box">

                        <div class="shipment-carrier-box__icon">

                            <i class="ri-truck-line"></i>

                        </div>


                        <div>

                            <strong>
                                DHL
                            </strong>

                            <span>
                            International Express
                        </span>

                        </div>

                    </div>


                    <div class="shipment-carrier-details">


                        <div>

                        <span>
                            Tracking Number
                        </span>

                            <strong>
                                DHL-784521963
                            </strong>

                        </div>


                        <div>

                        <span>
                            Service
                        </span>

                            <strong>
                                Express Delivery
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- QUICK ACTIONS --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <h2>
                            Quick Actions
                        </h2>

                    </div>


                    <div class="shipment-quick-actions">

                        <a
                            href="{{ route('ecommerce-shipment-create') }}"
                            class="shipment-quick-action"
                        >

                            <i class="ri-add-line"></i>

                            Create New Shipment

                        </a>


                        <a
                            href="{{ route('admin-order-details', ['order' => 1001]) }}"
                            class="shipment-quick-action"
                        >

                            <i class="ri-shopping-bag-line"></i>

                            View Order

                        </a>


                        <a
                            href="{{ route('ecommerce-shipments') }}"
                            class="shipment-quick-action"
                        >

                            <i class="ri-list-check-2"></i>

                            All Shipments

                        </a>

                    </div>

                </div>


                {{-- ======================================================== --}}
                {{-- NOTES --}}
                {{-- ======================================================== --}}

                <div class="shipment-details-card">

                    <div class="shipment-details-card__header">

                        <h2>
                            Shipment Notes
                        </h2>

                    </div>


                    <div class="shipment-note">

                        <i class="ri-information-line"></i>

                        <p>
                            Customer requested delivery between 9 AM and 5 PM.
                        </p>

                    </div>

                </div>


            </div>

        </div>

    </div>

@endsection
