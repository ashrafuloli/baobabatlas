@extends('backend.layouts.backend')

@section('content')

    <div class="smart-buy-client-index-page">

        {{--======================================================
            Page Header
        =======================================================--}}
        <div class="page-header">

            <div class="page-header-content">

                <div>

                <span class="page-eyebrow">
                    Smart Buy
                </span>

                    <h1 class="page-title">
                        My Smart Buy Requests
                    </h1>

                    <p class="page-description">
                        Track your product requests, quotes, payments,
                        and delivery progress from one place.
                    </p>

                </div>


                <a
                    href="{{ route('my-smart-buy-create') }}"
                    class="primary-button"
                >
                    <i class="ri-add-line"></i>

                    <span>
                    Start Smart Buy
                </span>
                </a>

            </div>

        </div>


        {{--======================================================
            Summary Cards
        =======================================================--}}
        <div class="summary-grid">

            <div class="summary-card">

                <div class="summary-icon">
                    <i class="ri-file-list-3-line"></i>
                </div>

                <div>

                <span>
                    Total Requests
                </span>

                    <strong>
                        12
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon pending">
                    <i class="ri-time-line"></i>
                </div>

                <div>

                <span>
                    Pending Review
                </span>

                    <strong>
                        2
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon quote">
                    <i class="ri-file-text-line"></i>
                </div>

                <div>

                <span>
                    Quotes Ready
                </span>

                    <strong>
                        1
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon active">
                    <i class="ri-truck-line"></i>
                </div>

                <div>

                <span>
                    Active Orders
                </span>

                    <strong>
                        3
                    </strong>

                </div>

            </div>

        </div>


        {{--======================================================
            Requests Card
        =======================================================--}}
        <div class="requests-card">

            <div class="card-header">

                <div>

                <span class="card-eyebrow">
                    Request History
                </span>

                    <h2>
                        All Smart Buy Requests
                    </h2>

                </div>


                {{-- Search --}}
                <div class="search-box">

                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        placeholder="Search requests..."
                        name="search"
                    >

                </div>

            </div>


            {{--==================================================
                Filters
            ===================================================--}}
            <div class="request-filters">

                <div class="filter-group">

                    <label for="status">
                        Status
                    </label>

                    <select id="status" name="status">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="submitted">
                            Request Submitted
                        </option>

                        <option value="review">
                            Under Review
                        </option>

                        <option value="quote">
                            Quote Ready
                        </option>

                        <option value="paid">
                            Payment Received
                        </option>

                        <option value="purchased">
                            Product Purchased
                        </option>

                        <option value="shipping">
                            In Transit
                        </option>

                        <option value="arrived">
                            Arrived in Guinea
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                    </select>

                </div>


                <div class="filter-group">

                    <label for="date">
                        Date
                    </label>

                    <select id="date" name="date">

                        <option value="">
                            All Time
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


                <button
                    type="button"
                    class="filter-button"
                >
                    <i class="ri-filter-3-line"></i>

                    <span>
                    Filter
                </span>
                </button>

            </div>


            {{--==================================================
                Desktop Table
            ===================================================--}}
            <div class="requests-table-wrapper">

                <table class="requests-table">

                    <thead>

                    <tr>

                        <th>
                            Request
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Submitted
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- Request 1 --}}
                    <tr>

                        <td>

                            <a
                                href="{{ route('my-smart-buy-details', 125) }}"
                                class="request-id"
                            >
                                SB-000125
                            </a>

                        </td>


                        <td>

                            <div class="product-cell">

                                <div class="product-thumb">
                                    <i class="ri-image-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        iPhone 16 Pro
                                    </strong>

                                    <span>
                                        Qty: 1 · Natural Titanium
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="table-date">
                                Aug 10, 2026
                            </span>

                        </td>


                        <td>

                            <strong class="table-amount">
                                $1,250.00
                            </strong>

                        </td>


                        <td>

                            <span class="status-badge paid">
                                Paid
                            </span>

                        </td>


                        <td>

                            <span class="status-badge active">
                                Product Purchased
                            </span>

                        </td>


                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('smart-buy-tracking', 125) }}"
                                    class="action-button primary"
                                    title="Track"
                                >
                                    <i class="ri-route-line"></i>
                                </a>


                                <a
                                    href="{{ route('my-smart-buy-details', 125) }}"
                                    class="action-button"
                                    title="View Details"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>

                            </div>

                        </td>

                    </tr>


                    {{-- Request 2 --}}
                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 124) }}"
                                class="request-id"
                            >
                                SB-000124
                            </a>

                        </td>


                        <td>

                            <div class="product-cell">

                                <div class="product-thumb">
                                    <i class="ri-image-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        Nike Air Max
                                    </strong>

                                    <span>
                                        Qty: 2 · Size 42
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="table-date">
                                Aug 08, 2026
                            </span>

                        </td>


                        <td>

                            <strong class="table-amount">
                                $285.00
                            </strong>

                        </td>


                        <td>

                            <span class="status-badge paid">
                                Paid
                            </span>

                        </td>


                        <td>

                            <span class="status-badge active">
                                In Transit
                            </span>

                        </td>


                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('smart-buy-tracking', 124) }}"
                                    class="action-button primary"
                                    title="Track"
                                >
                                    <i class="ri-route-line"></i>
                                </a>


                                <a
                                    href="{{ route('smart-buy-details', 124) }}"
                                    class="action-button"
                                    title="View Details"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>

                            </div>

                        </td>

                    </tr>


                    {{-- Request 3 --}}
                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 123) }}"
                                class="request-id"
                            >
                                SB-000123
                            </a>

                        </td>


                        <td>

                            <div class="product-cell">

                                <div class="product-thumb">
                                    <i class="ri-image-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        MacBook Air M4
                                    </strong>

                                    <span>
                                        Qty: 1
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="table-date">
                                Aug 05, 2026
                            </span>

                        </td>


                        <td>

                            <strong class="table-amount">
                                $1,450.00
                            </strong>

                        </td>


                        <td>

                            <span class="status-badge unpaid">
                                Unpaid
                            </span>

                        </td>


                        <td>

                            <span class="status-badge quote">
                                Quote Ready
                            </span>

                        </td>


                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('smart-buy-quote', 123) }}"
                                    class="action-button quote-action"
                                    title="View Quote"
                                >
                                    <i class="ri-file-text-line"></i>
                                </a>


                                <a
                                    href="{{ route('smart-buy-details', 123) }}"
                                    class="action-button"
                                    title="View Details"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>

                            </div>

                        </td>

                    </tr>


                    {{-- Request 4 --}}
                    <tr>

                        <td>

                            <a
                                href="{{ route('smart-buy-details', 122) }}"
                                class="request-id"
                            >
                                SB-000122
                            </a>

                        </td>


                        <td>

                            <div class="product-cell">

                                <div class="product-thumb">
                                    <i class="ri-image-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        Samsung Galaxy S26
                                    </strong>

                                    <span>
                                        Qty: 1 · Black
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="table-date">
                                Aug 02, 2026
                            </span>

                        </td>


                        <td>

                            <strong class="table-amount">
                                —
                            </strong>

                        </td>


                        <td>

                            <span class="status-badge unpaid">
                                Unpaid
                            </span>

                        </td>


                        <td>

                            <span class="status-badge pending">
                                Under Review
                            </span>

                        </td>


                        <td>

                            <div class="action-buttons">

                                <a
                                    href="{{ route('smart-buy-details', 122) }}"
                                    class="action-button"
                                    title="View Details"
                                >
                                    <i class="ri-eye-line"></i>
                                </a>

                            </div>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>


            {{--==================================================
                Mobile Request Cards
            ===================================================--}}
            <div class="mobile-request-list">


                <div class="mobile-request-card">

                    <div class="mobile-request-header">

                        <a
                            href="{{ route('my-smart-buy-details', 125) }}"
                            class="request-id"
                        >
                            SB-000125
                        </a>

                        <span class="status-badge active">
                        Product Purchased
                    </span>

                    </div>


                    <div class="mobile-product">

                        <div class="product-thumb">
                            <i class="ri-image-line"></i>
                        </div>

                        <div>

                            <strong>
                                iPhone 16 Pro
                            </strong>

                            <span>
                            Qty: 1 · Natural Titanium
                        </span>

                        </div>

                    </div>


                    <div class="mobile-request-info">

                        <div>

                        <span>
                            Submitted
                        </span>

                            <strong>
                                Aug 10, 2026
                            </strong>

                        </div>

                        <div>

                        <span>
                            Amount
                        </span>

                            <strong>
                                $1,250.00
                            </strong>

                        </div>

                        <div>

                        <span>
                            Payment
                        </span>

                            <span class="status-badge paid">
                            Paid
                        </span>

                        </div>

                    </div>


                    <div class="mobile-actions">

                        <a
                            href="{{ route('smart-buy-tracking', 125) }}"
                            class="mobile-primary-button"
                        >
                            <i class="ri-route-line"></i>
                            Track Order
                        </a>

                        <a
                            href="{{ route('my-smart-buy-details', 125) }}"
                            class="mobile-secondary-button"
                        >
                            <i class="ri-eye-line"></i>
                            Details
                        </a>

                    </div>

                </div>


                <div class="mobile-request-card">

                    <div class="mobile-request-header">

                        <a
                            href="{{ route('smart-buy-details', 123) }}"
                            class="request-id"
                        >
                            SB-000123
                        </a>

                        <span class="status-badge quote">
                        Quote Ready
                    </span>

                    </div>


                    <div class="mobile-product">

                        <div class="product-thumb">
                            <i class="ri-image-line"></i>
                        </div>

                        <div>

                            <strong>
                                MacBook Air M4
                            </strong>

                            <span>
                            Qty: 1
                        </span>

                        </div>

                    </div>


                    <div class="mobile-request-info">

                        <div>

                        <span>
                            Submitted
                        </span>

                            <strong>
                                Aug 05, 2026
                            </strong>

                        </div>

                        <div>

                        <span>
                            Amount
                        </span>

                            <strong>
                                $1,450.00
                            </strong>

                        </div>

                        <div>

                        <span>
                            Payment
                        </span>

                            <span class="status-badge unpaid">
                            Unpaid
                        </span>

                        </div>

                    </div>


                    <div class="mobile-actions">

                        <a
                            href="{{ route('smart-buy-quote', 123) }}"
                            class="mobile-primary-button"
                        >
                            <i class="ri-file-text-line"></i>
                            View Quote
                        </a>

                        <a
                            href="{{ route('smart-buy-details', 123) }}"
                            class="mobile-secondary-button"
                        >
                            <i class="ri-eye-line"></i>
                            Details
                        </a>

                    </div>

                </div>

            </div>


            {{--==================================================
                Pagination
            ===================================================--}}
            <div class="pagination-wrapper">

                <div class="pagination-info">
                    Showing
                    <strong>1</strong>
                    to
                    <strong>4</strong>
                    of
                    <strong>12</strong>
                    requests
                </div>


                <div class="pagination">

                    <button
                        type="button"
                        class="pagination-button disabled"
                    >
                        <i class="ri-arrow-left-s-line"></i>
                    </button>


                    <button
                        type="button"
                        class="pagination-button active"
                    >
                        1
                    </button>


                    <button
                        type="button"
                        class="pagination-button"
                    >
                        2
                    </button>


                    <button
                        type="button"
                        class="pagination-button"
                    >
                        3
                    </button>


                    <button
                        type="button"
                        class="pagination-button"
                    >
                        <i class="ri-arrow-right-s-line"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
