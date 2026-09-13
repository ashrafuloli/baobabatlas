@extends('backend.layouts.backend')

@section('title', 'Payments')

@section('content')

    <div class="payments-page">

        {{-- ================================================================ --}}
        {{-- PAGE HEADER --}}
        {{-- ================================================================ --}}

        <div class="payments-page__header">

            <div>

            <span class="payments-page__eyebrow">
                Ecommerce
            </span>

                <h1>
                    Payments
                </h1>

                <p>
                    View and manage payments received from ecommerce orders.
                </p>

            </div>


            <div class="payments-page__header-actions">

                <button
                    type="button"
                    class="payments-export-btn"
                >

                    <i class="ri-download-2-line"></i>

                    Export

                </button>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PAYMENT STATS --}}
        {{-- ================================================================ --}}

        <div class="payments-stats">


            {{-- Total Payments --}}
            <div class="payments-stat-card">

                <div class="payments-stat-card__icon">

                    <i class="ri-bank-card-line"></i>

                </div>

                <div>

                <span>
                    Total Payments
                </span>

                    <strong>
                        $28,450
                    </strong>

                </div>

            </div>


            {{-- Paid --}}
            <div class="payments-stat-card">

                <div class="payments-stat-card__icon payments-stat-card__icon--success">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div>

                <span>
                    Paid
                </span>

                    <strong>
                        $24,680
                    </strong>

                </div>

            </div>


            {{-- Pending --}}
            <div class="payments-stat-card">

                <div class="payments-stat-card__icon payments-stat-card__icon--warning">

                    <i class="ri-time-line"></i>

                </div>

                <div>

                <span>
                    Pending
                </span>

                    <strong>
                        $2,190
                    </strong>

                </div>

            </div>


            {{-- Failed / Refunded --}}
            <div class="payments-stat-card">

                <div class="payments-stat-card__icon payments-stat-card__icon--danger">

                    <i class="ri-refund-2-line"></i>

                </div>

                <div>

                <span>
                    Failed / Refunded
                </span>

                    <strong>
                        $1,580
                    </strong>

                </div>

            </div>

        </div>


        {{-- ================================================================ --}}
        {{-- PAYMENTS CARD --}}
        {{-- ================================================================ --}}

        <div class="payments-card">


            {{-- ============================================================ --}}
            {{-- TOOLBAR --}}
            {{-- ============================================================ --}}

            <div class="payments-toolbar">


                {{-- Search --}}
                <div class="payments-search">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        name="search"
                        placeholder="Search transaction, order or customer..."
                    >

                </div>


                <div class="payments-toolbar__filters">


                    {{-- Payment Status --}}
                    <select
                        name="status"
                        class="payments-filter"
                    >

                        <option value="">
                            All Status
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


                    {{-- Payment Method --}}
                    <select
                        name="method"
                        class="payments-filter"
                    >

                        <option value="">
                            All Methods
                        </option>

                        <option value="card">
                            Credit / Debit Card
                        </option>

                        <option value="paypal">
                            PayPal
                        </option>

                        <option value="bank">
                            Bank Transfer
                        </option>

                        <option value="cash">
                            Cash on Delivery
                        </option>

                    </select>


                    {{-- Date --}}
                    <select
                        name="date"
                        class="payments-filter"
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

            <div class="payments-table-wrapper">

                <table class="payments-table">

                    <thead>

                    <tr>

                        <th>
                            Transaction
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Method
                        </th>

                        <th>
                            Amount
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
                    {{-- PAYMENT 1 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <span class="payments-transaction">
                                TXN-BA-893421
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                                class="payments-order"
                            >
                                #BA-1001
                            </a>

                        </td>


                        <td>

                            <div class="payments-customer">

                                <div class="payments-customer__avatar">
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

                            <span class="payments-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <strong class="payments-amount">
                                $149.97
                            </strong>

                        </td>


                        <td>

                            <span class="payments-status payments-status--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="payments-date">
                                Aug 15, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1001]) }}"
                                class="payments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PAYMENT 2 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <span class="payments-transaction">
                                TXN-BA-893420
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1002]) }}"
                                class="payments-order"
                            >
                                #BA-1002
                            </a>

                        </td>


                        <td>

                            <div class="payments-customer">

                                <div class="payments-customer__avatar">
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

                            <span class="payments-method">

                                <i class="ri-paypal-line"></i>

                                PayPal

                            </span>

                        </td>


                        <td>

                            <strong class="payments-amount">
                                $89.98
                            </strong>

                        </td>


                        <td>

                            <span class="payments-status payments-status--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="payments-date">
                                Aug 14, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1002]) }}"
                                class="payments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PAYMENT 3 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <span class="payments-transaction">
                                TXN-BA-893419
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1003]) }}"
                                class="payments-order"
                            >
                                #BA-1003
                            </a>

                        </td>


                        <td>

                            <div class="payments-customer">

                                <div class="payments-customer__avatar">
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

                            <span class="payments-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <strong class="payments-amount">
                                $279.95
                            </strong>

                        </td>


                        <td>

                            <span class="payments-status payments-status--paid">

                                <i></i>

                                Paid

                            </span>

                        </td>


                        <td>

                            <span class="payments-date">
                                Aug 13, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1003]) }}"
                                class="payments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PAYMENT 4 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <span class="payments-transaction">
                                TXN-BA-893418
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1004]) }}"
                                class="payments-order"
                            >
                                #BA-1004
                            </a>

                        </td>


                        <td>

                            <div class="payments-customer">

                                <div class="payments-customer__avatar">
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

                            <span class="payments-method">

                                <i class="ri-bank-line"></i>

                                Bank Transfer

                            </span>

                        </td>


                        <td>

                            <strong class="payments-amount">
                                $59.99
                            </strong>

                        </td>


                        <td>

                            <span class="payments-status payments-status--pending">

                                <i></i>

                                Pending

                            </span>

                        </td>


                        <td>

                            <span class="payments-date">
                                Aug 12, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1004]) }}"
                                class="payments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PAYMENT 5 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <span class="payments-transaction">
                                TXN-BA-893417
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1005]) }}"
                                class="payments-order"
                            >
                                #BA-1005
                            </a>

                        </td>


                        <td>

                            <div class="payments-customer">

                                <div class="payments-customer__avatar">
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

                            <span class="payments-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <strong class="payments-amount">
                                $199.96
                            </strong>

                        </td>


                        <td>

                            <span class="payments-status payments-status--refunded">

                                <i></i>

                                Refunded

                            </span>

                        </td>


                        <td>

                            <span class="payments-date">
                                Aug 11, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1005]) }}"
                                class="payments-view-btn"
                            >

                                <i class="ri-eye-line"></i>

                                View

                            </a>

                        </td>

                    </tr>


                    {{-- ================================================= --}}
                    {{-- PAYMENT 6 --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td>

                            <span class="payments-transaction">
                                TXN-BA-893416
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1006]) }}"
                                class="payments-order"
                            >
                                #BA-1006
                            </a>

                        </td>


                        <td>

                            <div class="payments-customer">

                                <div class="payments-customer__avatar">
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

                            <span class="payments-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <strong class="payments-amount">
                                $74.98
                            </strong>

                        </td>


                        <td>

                            <span class="payments-status payments-status--failed">

                                <i></i>

                                Failed

                            </span>

                        </td>


                        <td>

                            <span class="payments-date">
                                Aug 10, 2026
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('admin-order-details', ['order' => 1006]) }}"
                                class="payments-view-btn"
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

            <div class="payments-pagination">

                <div class="payments-pagination__info">

                    Showing
                    <strong>1</strong>
                    to
                    <strong>6</strong>
                    of
                    <strong>248</strong>
                    payments

                </div>


                <div class="payments-pagination__buttons">

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
