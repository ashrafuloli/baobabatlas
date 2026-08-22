@extends('backend.layouts.backend')

@section('title', 'Orders')

@section('content')

    <div class="orders-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="orders-page__header">

            <div>

            <span class="orders-page__eyebrow">
                Ecommerce
            </span>

                <h1>
                    Orders
                </h1>

                <p>
                    Manage customer ecommerce orders and their status.
                </p>

            </div>


            <div class="orders-page__header-actions">

                <button
                    type="button"
                    class="orders-export-btn"
                >

                    <i class="ri-download-2-line"></i>

                    Export

                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- ORDER STATS --}}
        {{-- ================================================================ --}}

        <div class="orders-stats">


            {{-- Total Orders --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>

                <div>

                <span>
                    Total Orders
                </span>

                    <strong>
                        248
                    </strong>

                </div>

            </div>


            {{-- Pending --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon orders-stat-card__icon--warning">

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


            {{-- Processing --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon orders-stat-card__icon--info">

                    <i class="ri-loader-4-line"></i>

                </div>

                <div>

                <span>
                    Processing
                </span>

                    <strong>
                        32
                    </strong>

                </div>

            </div>


            {{-- Completed --}}
            <div class="orders-stat-card">

                <div class="orders-stat-card__icon orders-stat-card__icon--success">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div>

                <span>
                    Completed
                </span>

                    <strong>
                        181
                    </strong>

                </div>

            </div>


        </div>


        {{-- ================================================================ --}}
        {{-- ORDERS CARD --}}
        {{-- ================================================================ --}}

        <div class="orders-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="orders-toolbar">


                {{-- Search --}}
                <div class="orders-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Search order ID, customer or email..."
                    >

                </div>


                <div class="orders-toolbar__filters">


                    {{-- Status --}}
                    <select
                        name="status"
                        class="orders-filter"
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

                        <option value="delivered">
                            Delivered
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                        <option value="cancelled">
                            Cancelled
                        </option>

                        <option value="refunded">
                            Refunded
                        </option>

                    </select>


                    {{-- Payment --}}
                    <select
                        name="payment_status"
                        class="orders-filter"
                    >

                        <option value="">
                            Payment Status
                        </option>

                        <option value="paid">
                            Paid
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="failed">
                            Failed
                        </option>

                        <option value="refunded">
                            Refunded
                        </option>

                    </select>


                    {{-- Date --}}
                    <select
                        name="date"
                        class="orders-filter"
                    >

                        <option value="">
                            All Dates
                        </option>

                        <option value="today">
                            Today
                        </option>

                        <option value="week">
                            This Week
                        </option>

                        <option value="month">
                            This Month
                        </option>

                        <option value="year">
                            This Year
                        </option>

                    </select>

                </div>

            </div>


            {{-- ============================================================ --}}
            {{-- TABLE --}}
            {{-- ============================================================ --}}

            <div class="orders-table-wrapper">

                <table class="orders-table">

                    <thead>

                    <tr>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
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
                    {{-- ORDER 1 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                                class="orders-number"
                            >
                                #BA-1001
                            </a>

                        </td>


                        <td>

                            <div class="orders-customer">

                                <div class="orders-customer__avatar">
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

                            <span class="orders-products">
                                3 Items
                            </span>

                        </td>


                        <td>

                            <strong class="orders-total">
                                $149.97
                            </strong>

                        </td>


                        <td>

                            <span class="orders-payment orders-payment--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="orders-status orders-status--processing">

                                <i></i>

                                Processing

                            </span>

                        </td>


                        <td>

                            <span class="orders-date">
                                Aug 15, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                                class="orders-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- ORDER 2 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1002]) }}"
                                class="orders-number"
                            >
                                #BA-1002
                            </a>

                        </td>


                        <td>

                            <div class="orders-customer">

                                <div class="orders-customer__avatar">
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

                            <span class="orders-products">
                                2 Items
                            </span>

                        </td>


                        <td>

                            <strong class="orders-total">
                                $89.98
                            </strong>

                        </td>


                        <td>

                            <span class="orders-payment orders-payment--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="orders-status orders-status--shipped">

                                <i></i>

                                Shipped

                            </span>

                        </td>


                        <td>

                            <span class="orders-date">
                                Aug 14, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1002]) }}"
                                class="orders-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- ORDER 3 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1003]) }}"
                                class="orders-number"
                            >
                                #BA-1003
                            </a>

                        </td>


                        <td>

                            <div class="orders-customer">

                                <div class="orders-customer__avatar">
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

                            <span class="orders-products">
                                5 Items
                            </span>

                        </td>


                        <td>

                            <strong class="orders-total">
                                $279.95
                            </strong>

                        </td>


                        <td>

                            <span class="orders-payment orders-payment--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="orders-status orders-status--completed">

                                <i></i>

                                Completed

                            </span>

                        </td>


                        <td>

                            <span class="orders-date">
                                Aug 13, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1003]) }}"
                                class="orders-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- ORDER 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1004]) }}"
                                class="orders-number"
                            >
                                #BA-1004
                            </a>

                        </td>


                        <td>

                            <div class="orders-customer">

                                <div class="orders-customer__avatar">
                                    EW
                                </div>

                                <div>

                                    <strong>
                                        Emma Wilson
                                    </strong>

                                    <span>
                                        emma@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="orders-products">
                                1 Item
                            </span>

                        </td>


                        <td>

                            <strong class="orders-total">
                                $59.99
                            </strong>

                        </td>


                        <td>

                            <span class="orders-payment orders-payment--pending">

                                <i></i>

                                Pending

                            </span>

                        </td>


                        <td>

                            <span class="orders-status orders-status--pending">

                                <i></i>

                                Pending

                            </span>

                        </td>


                        <td>

                            <span class="orders-date">
                                Aug 12, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1004]) }}"
                                class="orders-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- ORDER 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1005]) }}"
                                class="orders-number"
                            >
                                #BA-1005
                            </a>

                        </td>


                        <td>

                            <div class="orders-customer">

                                <div class="orders-customer__avatar">
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

                            <span class="orders-products">
                                4 Items
                            </span>

                        </td>


                        <td>

                            <strong class="orders-total">
                                $199.96
                            </strong>

                        </td>


                        <td>

                            <span class="orders-payment orders-payment--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="orders-status orders-status--delivered">

                                <i></i>

                                Delivered

                            </span>

                        </td>


                        <td>

                            <span class="orders-date">
                                Aug 11, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1005]) }}"
                                class="orders-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- ORDER 6 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1006]) }}"
                                class="orders-number"
                            >
                                #BA-1006
                            </a>

                        </td>


                        <td>

                            <div class="orders-customer">

                                <div class="orders-customer__avatar">
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

                            <span class="orders-products">
                                2 Items
                            </span>

                        </td>


                        <td>

                            <strong class="orders-total">
                                $74.98
                            </strong>

                        </td>


                        <td>

                            <span class="orders-payment orders-payment--failed">

                                <i></i>

                                Failed

                            </span>

                        </td>


                        <td>

                            <span class="orders-status orders-status--cancelled">

                                <i></i>

                                Cancelled

                            </span>

                        </td>


                        <td>

                            <span class="orders-date">
                                Aug 10, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1006]) }}"
                                class="orders-view-btn"
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

            <div class="orders-pagination">

                <div class="orders-pagination__info">

                    Showing
                    <strong>1</strong>
                    to
                    <strong>6</strong>
                    of
                    <strong>248</strong>
                    orders

                </div>


                <div class="orders-pagination__buttons">

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
                        5
                    </button>


                    <button type="button">

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
