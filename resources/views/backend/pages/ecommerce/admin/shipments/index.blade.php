@extends('backend.layouts.backend')

@section('title', 'Ecommerce Shipments')

@section('content')

    <div class="shipments-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="shipments-page__header">

            <div>

            <span class="shipments-page__eyebrow">
                Ecommerce
            </span>

                <h1>
                    Shipments
                </h1>

                <p>
                    Manage ecommerce order shipments, tracking and delivery status.
                </p>

            </div>


            <div class="shipments-page__header-actions">

                {{-- Create Shipment --}}
                <a
                    href="{{ route('ecommerce-shipment-create') }}"
                    class="shipments-create-btn"
                >

                    <i class="ri-add-line"></i>

                    Create Shipment

                </a>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- STATS --}}
        {{-- ================================================================ --}}

        <div class="shipments-stats">


            {{-- Total Shipments --}}
            <div class="shipments-stat-card">

                <div class="shipments-stat-card__icon">

                    <i class="ri-truck-line"></i>

                </div>

                <div>

                <span>
                    Total Shipments
                </span>

                    <strong>
                        186
                    </strong>

                </div>

            </div>


            {{-- Pending --}}
            <div class="shipments-stat-card">

                <div class="shipments-stat-card__icon shipments-stat-card__icon--warning">

                    <i class="ri-time-line"></i>

                </div>

                <div>

                <span>
                    Pending
                </span>

                    <strong>
                        18
                    </strong>

                </div>

            </div>


            {{-- In Transit --}}
            <div class="shipments-stat-card">

                <div class="shipments-stat-card__icon shipments-stat-card__icon--info">

                    <i class="ri-truck-line"></i>

                </div>

                <div>

                <span>
                    In Transit
                </span>

                    <strong>
                        42
                    </strong>

                </div>

            </div>


            {{-- Delivered --}}
            <div class="shipments-stat-card">

                <div class="shipments-stat-card__icon shipments-stat-card__icon--success">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div>

                <span>
                    Delivered
                </span>

                    <strong>
                        121
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- SHIPMENTS CARD --}}
        {{-- ================================================================ --}}

        <div class="shipments-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="shipments-toolbar">


                {{-- Search --}}
                <div class="shipments-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Search shipment, order or tracking number..."
                    >

                </div>


                <div class="shipments-toolbar__filters">


                    {{-- Shipment Status --}}
                    <select
                        name="status"
                        class="shipments-filter"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="processing">
                            Processing
                        </option>

                        <option value="shipped">
                            Shipped
                        </option>

                        <option value="in-transit">
                            In Transit
                        </option>

                        <option value="out-for-delivery">
                            Out for Delivery
                        </option>

                        <option value="delivered">
                            Delivered
                        </option>

                        <option value="failed">
                            Failed
                        </option>

                    </select>


                    {{-- Carrier --}}
                    <select
                        name="carrier"
                        class="shipments-filter"
                    >

                        <option value="">
                            All Carriers
                        </option>

                        <option value="dhl">
                            DHL
                        </option>

                        <option value="fedex">
                            FedEx
                        </option>

                        <option value="ups">
                            UPS
                        </option>

                        <option value="usps">
                            USPS
                        </option>

                        <option value="other">
                            Other
                        </option>

                    </select>


                    {{-- Delivery --}}
                    <select
                        name="delivery_status"
                        class="shipments-filter"
                    >

                        <option value="">
                            Delivery Status
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="in-transit">
                            In Transit
                        </option>

                        <option value="out-for-delivery">
                            Out for Delivery
                        </option>

                        <option value="delivered">
                            Delivered
                        </option>

                    </select>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="shipments-table-wrapper">

                <table class="shipments-table">

                    <thead>

                    <tr>

                        <th>
                            Shipment
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Carrier
                        </th>

                        <th>
                            Tracking Number
                        </th>

                        <th>
                            Shipment Status
                        </th>

                        <th>
                            Delivery
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- ================================================= --}}
                    {{-- SHIPMENT 1 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 1]) }}"
                                class="shipments-number"
                            >
                                SHP-BA-001
                            </a>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                                class="shipments-order"
                            >
                                #BA-1001
                            </a>

                        </td>


                        <td>

                            <div class="shipments-customer">

                                <div class="shipments-customer__avatar">
                                    JD
                                </div>

                                <div>

                                    <strong>
                                        John Doe
                                    </strong>

                                    <span>
                                        john@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="shipments-carrier">

                                <i class="ri-truck-line"></i>

                                DHL

                            </span>

                        </td>


                        <td>

                            <span class="shipments-tracking">
                                DHL-784521963
                            </span>

                        </td>


                        <td>

                            <span class="shipments-status shipments-status--processing">

                                <i></i>

                                Processing

                            </span>

                        </td>


                        <td>

                            <span class="shipments-delivery shipments-delivery--pending">
                                Pending
                            </span>

                        </td>


                        <td>

                            <span class="shipments-date">
                                Aug 15, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 1]) }}"
                                class="shipments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- SHIPMENT 2 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 2]) }}"
                                class="shipments-number"
                            >
                                SHP-BA-002
                            </a>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1002]) }}"
                                class="shipments-order"
                            >
                                #BA-1002
                            </a>

                        </td>


                        <td>

                            <div class="shipments-customer">

                                <div class="shipments-customer__avatar">
                                    SM
                                </div>

                                <div>

                                    <strong>
                                        Sarah Miller
                                    </strong>

                                    <span>
                                        sarah@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="shipments-carrier">

                                <i class="ri-truck-line"></i>

                                FedEx

                            </span>

                        </td>


                        <td>

                            <span class="shipments-tracking">
                                FX-982145763
                            </span>

                        </td>


                        <td>

                            <span class="shipments-status shipments-status--transit">

                                <i></i>

                                In Transit

                            </span>

                        </td>


                        <td>

                            <span class="shipments-delivery shipments-delivery--transit">
                                In Transit
                            </span>

                        </td>


                        <td>

                            <span class="shipments-date">
                                Aug 14, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 2]) }}"
                                class="shipments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- SHIPMENT 3 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 3]) }}"
                                class="shipments-number"
                            >
                                SHP-BA-003
                            </a>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1003]) }}"
                                class="shipments-order"
                            >
                                #BA-1003
                            </a>

                        </td>


                        <td>

                            <div class="shipments-customer">

                                <div class="shipments-customer__avatar">
                                    MA
                                </div>

                                <div>

                                    <strong>
                                        Michael Adams
                                    </strong>

                                    <span>
                                        michael@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="shipments-carrier">

                                <i class="ri-truck-line"></i>

                                UPS

                            </span>

                        </td>


                        <td>

                            <span class="shipments-tracking">
                                UPS-654821937
                            </span>

                        </td>


                        <td>

                            <span class="shipments-status shipments-status--out">

                                <i></i>

                                Out for Delivery

                            </span>

                        </td>


                        <td>

                            <span class="shipments-delivery shipments-delivery--out">
                                Out for Delivery
                            </span>

                        </td>


                        <td>

                            <span class="shipments-date">
                                Aug 13, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 3]) }}"
                                class="shipments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- SHIPMENT 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 4]) }}"
                                class="shipments-number"
                            >
                                SHP-BA-004
                            </a>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1005]) }}"
                                class="shipments-order"
                            >
                                #BA-1005
                            </a>

                        </td>


                        <td>

                            <div class="shipments-customer">

                                <div class="shipments-customer__avatar">
                                    DW
                                </div>

                                <div>

                                    <strong>
                                        David Williams
                                    </strong>

                                    <span>
                                        david@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="shipments-carrier">

                                <i class="ri-truck-line"></i>

                                USPS

                            </span>

                        </td>


                        <td>

                            <span class="shipments-tracking">
                                USPS-874125963
                            </span>

                        </td>


                        <td>

                            <span class="shipments-status shipments-status--delivered">

                                <i></i>

                                Delivered

                            </span>

                        </td>


                        <td>

                            <span class="shipments-delivery shipments-delivery--delivered">
                                Delivered
                            </span>

                        </td>


                        <td>

                            <span class="shipments-date">
                                Aug 11, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 4]) }}"
                                class="shipments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- SHIPMENT 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 5]) }}"
                                class="shipments-number"
                            >
                                SHP-BA-005
                            </a>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1006]) }}"
                                class="shipments-order"
                            >
                                #BA-1006
                            </a>

                        </td>


                        <td>

                            <div class="shipments-customer">

                                <div class="shipments-customer__avatar">
                                    OL
                                </div>

                                <div>

                                    <strong>
                                        Olivia Lee
                                    </strong>

                                    <span>
                                        olivia@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="shipments-carrier">

                                <i class="ri-truck-line"></i>

                                DHL

                            </span>

                        </td>


                        <td>

                            <span class="shipments-tracking">
                                DHL-741258963
                            </span>

                        </td>


                        <td>

                            <span class="shipments-status shipments-status--failed">

                                <i></i>

                                Failed

                            </span>

                        </td>


                        <td>

                            <span class="shipments-delivery shipments-delivery--failed">
                                Failed
                            </span>

                        </td>


                        <td>

                            <span class="shipments-date">
                                Aug 10, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('ecommerce-shipment-details', ['shipment' => 5]) }}"
                                class="shipments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>


            {{-- ============================================================ --}}
            {{-- PAGINATION --}}
            {{-- ============================================================ --}}

            <div class="shipments-pagination">

                <div class="shipments-pagination__info">

                    Showing
                    <strong>1</strong>
                    to
                    <strong>5</strong>
                    of
                    <strong>186</strong>
                    shipments

                </div>


                <div class="shipments-pagination__buttons">

                    <button
                        type="button"
                        disabled
                    >

                        <i class="ri-arrow-left-s-line"></i>

                    </button>


                    <button
                        type="button"
                        class="active"
                    >
                        1
                    </button>


                    <button type="button">
                        2
                    </button>


                    <button type="button">
                        3
                    </button>


                    <button type="button">
                        4
                    </button>


                    <button type="button">

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
