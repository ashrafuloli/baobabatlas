@extends('backend.layouts.backend')

@section('title', 'Smart Buy')

@section('content')

    <div class="smart-buy-page">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}

        <div class="smart-buy-page__header">

            <div>

            <span class="smart-buy-page__eyebrow">
                Smart Buy Management
            </span>

                <h1>
                    Smart Buy
                </h1>

                <p>
                    Review customer requests, prepare quotes, manage purchases and shipments.
                </p>

            </div>


            <div class="smart-buy-page__header-actions">

                <a
                    href="{{ route('smart-buy-admin-payments') }}"
                    class="smart-buy-outline-btn"
                >

                    <i class="ri-bank-card-line"></i>

                    <span>
                    Payments
                </span>

                </a>

            </div>

        </div>



        {{-- ==========================================================
        | Statistics
        =========================================================== --}}

        <div class="smart-buy-stats">


            {{-- Total Requests --}}

            <div class="smart-buy-stat-card">

                <div class="smart-buy-stat-card__icon">

                    <i class="ri-file-list-3-line"></i>

                </div>

                <div class="smart-buy-stat-card__content">

                <span>
                    Total Requests
                </span>

                    <strong>
                        128
                    </strong>

                    <small>
                        All Smart Buy requests
                    </small>

                </div>

            </div>


            {{-- Pending Review --}}

            <div class="smart-buy-stat-card">

                <div class="smart-buy-stat-card__icon smart-buy-stat-card__icon--orange">

                    <i class="ri-time-line"></i>

                </div>

                <div class="smart-buy-stat-card__content">

                <span>
                    Pending Review
                </span>

                    <strong>
                        18
                    </strong>

                    <small>
                        Waiting for admin review
                    </small>

                </div>

            </div>


            {{-- Awaiting Payment --}}

            <div class="smart-buy-stat-card">

                <div class="smart-buy-stat-card__icon smart-buy-stat-card__icon--blue">

                    <i class="ri-bank-card-line"></i>

                </div>

                <div class="smart-buy-stat-card__content">

                <span>
                    Awaiting Payment
                </span>

                    <strong>
                        12
                    </strong>

                    <small>
                        Quotes accepted
                    </small>

                </div>

            </div>


            {{-- In Progress --}}

            <div class="smart-buy-stat-card">

                <div class="smart-buy-stat-card__icon smart-buy-stat-card__icon--purple">

                    <i class="ri-shopping-bag-3-line"></i>

                </div>

                <div class="smart-buy-stat-card__content">

                <span>
                    In Progress
                </span>

                    <strong>
                        24
                    </strong>

                    <small>
                        Purchase or shipment
                    </small>

                </div>

            </div>


        </div>



        {{-- ==========================================================
        | Main Card
        =========================================================== --}}

        <section class="smart-buy-card">


            {{-- ======================================================
            | Card Header
            ======================================================= --}}

            <div class="smart-buy-card__header">

                <div>

                    <h2>
                        Smart Buy Requests
                    </h2>

                    <p>
                        Manage customer product purchasing requests.
                    </p>

                </div>


                <div class="smart-buy-card__header-actions">

                    <div class="smart-buy-search">

                        <i class="ri-search-line"></i>

                        <input
                            type="text"
                            placeholder="Search request..."
                            autocomplete="off"
                        >

                    </div>


                    <button
                        type="button"
                        class="smart-buy-filter-btn"
                    >

                        <i class="ri-filter-3-line"></i>

                        <span>
                        Filter
                    </span>

                    </button>

                </div>

            </div>



            {{-- ======================================================
            | Filters
            ======================================================= --}}

            <div class="smart-buy-filters">

                <div class="smart-buy-filter-field">

                    <label for="smart-buy-status">
                        Status
                    </label>

                    <select id="smart-buy-status">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="pending">
                            Pending Review
                        </option>

                        <option value="quote">
                            Quote Prepared
                        </option>

                        <option value="awaiting-payment">
                            Awaiting Payment
                        </option>

                        <option value="paid">
                            Paid
                        </option>

                        <option value="purchased">
                            Purchased
                        </option>

                        <option value="shipment">
                            In Shipment
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                    </select>

                </div>


                <div class="smart-buy-filter-field">

                    <label for="smart-buy-service">
                        Service
                    </label>

                    <select id="smart-buy-service">

                        <option value="">
                            All Services
                        </option>

                        <option value="freight">
                            Freight Forwarding
                        </option>

                        <option value="customs">
                            Customs Clearance
                        </option>

                        <option value="warehousing">
                            Warehousing
                        </option>

                    </select>

                </div>


                <div class="smart-buy-filter-field">

                    <label for="smart-buy-date">
                        Date
                    </label>

                    <select id="smart-buy-date">

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

                    </select>

                </div>


                <button
                    type="button"
                    class="smart-buy-clear-filter"
                >

                    Clear Filters

                </button>

            </div>



            {{-- ======================================================
            | Table
            ======================================================= --}}

            <div class="smart-buy-table-wrapper">

                <table class="smart-buy-table">

                    <thead>

                    <tr>

                        <th>
                            Request
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Destination
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- ==================================================
                    | Request 1
                    =================================================== --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 1) }}"
                                class="smart-buy-request-number"
                            >
                                SB-2026-00128
                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-customer">

                                <div class="smart-buy-customer__avatar">
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

                            <div class="smart-buy-product">

                                <strong>
                                    MacBook Pro 14"
                                </strong>

                                <span>
                                    Apple · 1 unit
                                </span>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Paris, France
                                </span>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-amount">
                                $2,450.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-status smart-buy-status--pending">

                                <i></i>

                                Pending Review

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-date">
                                Aug 16, 2026
                            </span>

                        </td>


                        <td>

                            <div class="smart-buy-actions">

                                <a
                                    href="{{ route('smart-buy-details', 1) }}"
                                    class="smart-buy-action-btn"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('smart-buy-admin-quote', 1) }}"
                                    class="smart-buy-action-btn"
                                    title="Prepare Quote"
                                >

                                    <i class="ri-file-edit-line"></i>

                                </a>

                            </div>

                        </td>

                    </tr>



                    {{-- ==================================================
                    | Request 2
                    =================================================== --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 2) }}"
                                class="smart-buy-request-number"
                            >
                                SB-2026-00127
                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-customer">

                                <div class="smart-buy-customer__avatar">
                                    AM
                                </div>

                                <div>

                                    <strong>
                                        Amadou Mohamed
                                    </strong>

                                    <span>
                                        amadou@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-product">

                                <strong>
                                    Industrial Equipment
                                </strong>

                                <span>
                                    Equipment · 3 units
                                </span>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Conakry, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-amount">
                                $8,750.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-status smart-buy-status--quote">

                                <i></i>

                                Quote Prepared

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-date">
                                Aug 15, 2026
                            </span>

                        </td>


                        <td>

                            <div class="smart-buy-actions">

                                <a
                                    href="{{ route('smart-buy-details', 2) }}"
                                    class="smart-buy-action-btn"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('smart-buy-admin-quote', 2) }}"
                                    class="smart-buy-action-btn"
                                    title="Edit Quote"
                                >

                                    <i class="ri-edit-line"></i>

                                </a>

                            </div>

                        </td>

                    </tr>



                    {{-- ==================================================
                    | Request 3
                    =================================================== --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 3) }}"
                                class="smart-buy-request-number"
                            >
                                SB-2026-00126
                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-customer">

                                <div class="smart-buy-customer__avatar">
                                    MK
                                </div>

                                <div>

                                    <strong>
                                        Mariama Kante
                                    </strong>

                                    <span>
                                        mariama@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-product">

                                <strong>
                                    Samsung Galaxy S26
                                </strong>

                                <span>
                                    Electronics · 2 units
                                </span>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Kankan, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-amount">
                                $1,980.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-status smart-buy-status--payment">

                                <i></i>

                                Awaiting Payment

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-date">
                                Aug 14, 2026
                            </span>

                        </td>


                        <td>

                            <div class="smart-buy-actions">

                                <a
                                    href="{{ route('smart-buy-details', 3) }}"
                                    class="smart-buy-action-btn"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('smart-buy-admin-payments') }}"
                                    class="smart-buy-action-btn"
                                    title="View Payment"
                                >

                                    <i class="ri-bank-card-line"></i>

                                </a>

                            </div>

                        </td>

                    </tr>



                    {{-- ==================================================
                    | Request 4
                    =================================================== --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 4) }}"
                                class="smart-buy-request-number"
                            >
                                SB-2026-00125
                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-customer">

                                <div class="smart-buy-customer__avatar">
                                    AS
                                </div>

                                <div>

                                    <strong>
                                        Alpha Services
                                    </strong>

                                    <span>
                                        alpha@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-product">

                                <strong>
                                    Office Furniture
                                </strong>

                                <span>
                                    Furniture · 12 units
                                </span>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Labé, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-amount">
                                $4,620.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-status smart-buy-status--purchased">

                                <i></i>

                                Purchased

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-date">
                                Aug 13, 2026
                            </span>

                        </td>


                        <td>

                            <div class="smart-buy-actions">

                                <a
                                    href="{{ route('smart-buy-details', 4) }}"
                                    class="smart-buy-action-btn"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('smart-buy-shipment', 4) }}"
                                    class="smart-buy-action-btn"
                                    title="Manage Shipment"
                                >

                                    <i class="ri-truck-line"></i>

                                </a>

                            </div>

                        </td>

                    </tr>



                    {{-- ==================================================
                    | Request 5
                    =================================================== --}}

                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 5) }}"
                                class="smart-buy-request-number"
                            >
                                SB-2026-00124
                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-customer">

                                <div class="smart-buy-customer__avatar">
                                    FB
                                </div>

                                <div>

                                    <strong>
                                        Fatou Bah
                                    </strong>

                                    <span>
                                        fatou@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-product">

                                <strong>
                                    Medical Supplies
                                </strong>

                                <span>
                                    Supplies · 8 boxes
                                </span>

                            </div>

                        </td>


                        <td>

                            <div class="smart-buy-location">

                                <i class="ri-map-pin-line"></i>

                                <span>
                                    Nzérékoré, Guinea
                                </span>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-amount">
                                $3,240.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-status smart-buy-status--transit">

                                <i></i>

                                In Shipment

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-date">
                                Aug 12, 2026
                            </span>

                        </td>


                        <td>

                            <div class="smart-buy-actions">

                                <a
                                    href="{{ route('smart-buy-details', 5) }}"
                                    class="smart-buy-action-btn"
                                    title="View Details"
                                >

                                    <i class="ri-eye-line"></i>

                                </a>


                                <a
                                    href="{{ route('smart-buy-shipment', 5) }}"
                                    class="smart-buy-action-btn"
                                    title="View Shipment"
                                >

                                    <i class="ri-truck-line"></i>

                                </a>

                            </div>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>



            {{-- ======================================================
            | Pagination
            ======================================================= --}}

            <div class="smart-buy-pagination">

                <div class="smart-buy-pagination__info">

                    Showing

                    <strong>
                        1
                    </strong>

                    to

                    <strong>
                        5
                    </strong>

                    of

                    <strong>
                        128
                    </strong>

                    requests

                </div>


                <div class="smart-buy-pagination__links">

                    <button
                        type="button"
                        class="smart-buy-pagination__btn smart-buy-pagination__btn--disabled"
                        disabled
                    >

                        <i class="ri-arrow-left-s-line"></i>

                    </button>


                    <button
                        type="button"
                        class="smart-buy-pagination__btn smart-buy-pagination__btn--active"
                    >
                        1
                    </button>


                    <button
                        type="button"
                        class="smart-buy-pagination__btn"
                    >
                        2
                    </button>


                    <button
                        type="button"
                        class="smart-buy-pagination__btn"
                    >
                        3
                    </button>


                    <span class="smart-buy-pagination__dots">
                    ...
                </span>


                    <button
                        type="button"
                        class="smart-buy-pagination__btn"
                    >
                        26
                    </button>


                    <button
                        type="button"
                        class="smart-buy-pagination__btn"
                    >

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </section>

    </div>

@endsection
