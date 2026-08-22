@extends('backend.layouts.backend')

@section('title', 'Smart Buy Payments')

@section('content')

    <div class="smart-buy-payments-page">

        {{-- =========================================================
            Breadcrumb
        ========================================================== --}}
        <div class="smart-buy-payments-breadcrumb">

            <a href="{{ route('admin-dashboard') }}">
                Dashboard
            </a>

            <i class="ri-arrow-right-s-line"></i>

            <span>
            Smart Buy Payments
        </span>

        </div>


        {{-- =========================================================
            Page Header
        ========================================================== --}}
        <div class="smart-buy-payments-header">

            <div class="smart-buy-payments-header__content">

            <span class="smart-buy-payments-eyebrow">
                Smart Buy
            </span>

                <h1>
                    Payments
                </h1>

                <p>
                    Review and manage payments received for Smart Buy requests.
                </p>

            </div>

        </div>


        {{-- =========================================================
            Summary Cards
        ========================================================== --}}
        <div class="smart-buy-payment-stats">


            {{-- Total Payments --}}
            <div class="smart-buy-payment-stat">

                <div class="smart-buy-payment-stat__icon total">
                    <i class="ri-bank-card-line"></i>
                </div>

                <div class="smart-buy-payment-stat__content">

                <span>
                    Total Payments
                </span>

                    <strong>
                        128
                    </strong>

                    <small>
                        All Smart Buy payments
                    </small>

                </div>

            </div>


            {{-- Paid --}}
            <div class="smart-buy-payment-stat">

                <div class="smart-buy-payment-stat__icon paid">
                    <i class="ri-checkbox-circle-line"></i>
                </div>

                <div class="smart-buy-payment-stat__content">

                <span>
                    Paid
                </span>

                    <strong>
                        94
                    </strong>

                    <small>
                        Successfully received
                    </small>

                </div>

            </div>


            {{-- Pending --}}
            <div class="smart-buy-payment-stat">

                <div class="smart-buy-payment-stat__icon pending">
                    <i class="ri-time-line"></i>
                </div>

                <div class="smart-buy-payment-stat__content">

                <span>
                    Pending
                </span>

                    <strong>
                        21
                    </strong>

                    <small>
                        Awaiting payment
                    </small>

                </div>

            </div>


            {{-- Failed --}}
            <div class="smart-buy-payment-stat">

                <div class="smart-buy-payment-stat__icon failed">
                    <i class="ri-close-circle-line"></i>
                </div>

                <div class="smart-buy-payment-stat__content">

                <span>
                    Failed
                </span>

                    <strong>
                        8
                    </strong>

                    <small>
                        Payment failed
                    </small>

                </div>

            </div>


            {{-- Refunded --}}
            <div class="smart-buy-payment-stat">

                <div class="smart-buy-payment-stat__icon refunded">
                    <i class="ri-refund-2-line"></i>
                </div>

                <div class="smart-buy-payment-stat__content">

                <span>
                    Refunded
                </span>

                    <strong>
                        5
                    </strong>

                    <small>
                        Payments refunded
                    </small>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Payment List
        ========================================================== --}}
        <div class="smart-buy-payments-card">


            {{-- =====================================================
                Toolbar
            ====================================================== --}}
            <div class="smart-buy-payments-toolbar">

                <div class="smart-buy-payments-toolbar__title">

                    <h2>
                        Payment History
                    </h2>

                    <span>
                    128 payments
                </span>

                </div>


                <div class="smart-buy-payments-toolbar__actions">


                    {{-- Search --}}
                    <div class="smart-buy-payment-search">

                        <i class="ri-search-line"></i>

                        <input
                            type="search"
                            id="smart-buy-payment-search"
                            placeholder="Search payment..."
                        >

                    </div>


                    {{-- Status --}}
                    <div class="smart-buy-payment-filter">

                        <i class="ri-filter-3-line"></i>

                        <select id="smart-buy-payment-status">

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

                    </div>


                    {{-- Date --}}
                    <div class="smart-buy-payment-filter">

                        <i class="ri-calendar-line"></i>

                        <select id="smart-buy-payment-date">

                            <option value="">
                                All Dates
                            </option>

                            <option value="today">
                                Today
                            </option>

                            <option value="7-days">
                                Last 7 Days
                            </option>

                            <option value="30-days">
                                Last 30 Days
                            </option>

                            <option value="90-days">
                                Last 90 Days
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Table
            ====================================================== --}}
            <div class="smart-buy-payments-table-wrapper">

                <table class="smart-buy-payments-table">

                    <thead>

                    <tr>

                        <th>
                            Payment
                        </th>

                        <th>
                            Smart Buy
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Method
                        </th>

                        <th>
                            Date
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


                    {{-- =================================================
                        Payment 01
                    ================================================== --}}
                    <tr data-status="paid">

                        <td>

                            <div class="smart-buy-payment-id">

                                <strong>
                                    PAY-00128
                                </strong>

                                <span>
                                    TXN-78451296
                                </span>

                            </div>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 125) }}"
                                class="smart-buy-payment-request"
                            >

                                <strong>
                                    SB-000125
                                </strong>

                                <span>
                                    iPhone 16 Pro
                                </span>

                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-payment-customer">

                                <div class="smart-buy-payment-avatar">
                                    DC
                                </div>

                                <div>

                                    <strong>
                                        Demo Client
                                    </strong>

                                    <span>
                                        client@gmail.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-payment-amount">
                                $1,250.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-payment-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-date">
                                Aug 16, 2026
                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-status paid">
                                Paid
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 125) }}"
                                class="smart-buy-payment-action"
                                aria-label="View payment"
                            >

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- =================================================
                        Payment 02
                    ================================================== --}}
                    <tr data-status="paid">

                        <td>

                            <div class="smart-buy-payment-id">

                                <strong>
                                    PAY-00127
                                </strong>

                                <span>
                                    TXN-78451240
                                </span>

                            </div>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 124) }}"
                                class="smart-buy-payment-request"
                            >

                                <strong>
                                    SB-000124
                                </strong>

                                <span>
                                    Nike Air Max
                                </span>

                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-payment-customer">

                                <div class="smart-buy-payment-avatar">
                                    AD
                                </div>

                                <div>

                                    <strong>
                                        Amadou Diallo
                                    </strong>

                                    <span>
                                        amadou@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-payment-amount">
                                $320.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-payment-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-date">
                                Aug 15, 2026
                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-status paid">
                                Paid
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 124) }}"
                                class="smart-buy-payment-action"
                            >

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- =================================================
                        Payment 03
                    ================================================== --}}
                    <tr data-status="pending">

                        <td>

                            <div class="smart-buy-payment-id">

                                <strong>
                                    PAY-00126
                                </strong>

                                <span>
                                    TXN-78451082
                                </span>

                            </div>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 123) }}"
                                class="smart-buy-payment-request"
                            >

                                <strong>
                                    SB-000123
                                </strong>

                                <span>
                                    MacBook Air M4
                                </span>

                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-payment-customer">

                                <div class="smart-buy-payment-avatar">
                                    FK
                                </div>

                                <div>

                                    <strong>
                                        Fatoumata Kamara
                                    </strong>

                                    <span>
                                        fatoumata@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-payment-amount">
                                $1,480.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-payment-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-date">
                                Aug 14, 2026
                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-status pending">
                                Pending
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 123) }}"
                                class="smart-buy-payment-action"
                            >

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- =================================================
                        Payment 04
                    ================================================== --}}
                    <tr data-status="failed">

                        <td>

                            <div class="smart-buy-payment-id">

                                <strong>
                                    PAY-00125
                                </strong>

                                <span>
                                    TXN-78450961
                                </span>

                            </div>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 122) }}"
                                class="smart-buy-payment-request"
                            >

                                <strong>
                                    SB-000122
                                </strong>

                                <span>
                                    Samsung Galaxy S25
                                </span>

                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-payment-customer">

                                <div class="smart-buy-payment-avatar">
                                    IB
                                </div>

                                <div>

                                    <strong>
                                        Ibrahim Bah
                                    </strong>

                                    <span>
                                        ibrahim@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-payment-amount">
                                $890.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-payment-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-date">
                                Aug 13, 2026
                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-status failed">
                                Failed
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 122) }}"
                                class="smart-buy-payment-action"
                            >

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- =================================================
                        Payment 05
                    ================================================== --}}
                    <tr data-status="refunded">

                        <td>

                            <div class="smart-buy-payment-id">

                                <strong>
                                    PAY-00124
                                </strong>

                                <span>
                                    TXN-78450712
                                </span>

                            </div>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 121) }}"
                                class="smart-buy-payment-request"
                            >

                                <strong>
                                    SB-000121
                                </strong>

                                <span>
                                    Zara Collection
                                </span>

                            </a>

                        </td>


                        <td>

                            <div class="smart-buy-payment-customer">

                                <div class="smart-buy-payment-avatar">
                                    MA
                                </div>

                                <div>

                                    <strong>
                                        Mariama A.
                                    </strong>

                                    <span>
                                        mariama@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <strong class="smart-buy-payment-amount">
                                $245.00
                            </strong>

                        </td>


                        <td>

                            <span class="smart-buy-payment-method">

                                <i class="ri-bank-card-line"></i>

                                Card

                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-date">
                                Aug 11, 2026
                            </span>

                        </td>


                        <td>

                            <span class="smart-buy-payment-status refunded">
                                Refunded
                            </span>

                        </td>


                        <td>

                            <a
                                href="{{ route('smart-buy-details', 121) }}"
                                class="smart-buy-payment-action"
                            >

                                <i class="ri-arrow-right-line"></i>

                            </a>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>


            {{-- =========================================================
                Empty State
            ========================================================== --}}
            <div
                class="smart-buy-payments-empty"
                id="smart-buy-payments-empty"
                style="display: none;"
            >

                <div class="smart-buy-payments-empty__icon">

                    <i class="ri-bank-card-line"></i>

                </div>

                <h3>
                    No payments found
                </h3>

                <p>
                    No Smart Buy payments match your current filters.
                </p>

            </div>


            {{-- =========================================================
                Pagination
            ========================================================== --}}
            <div class="smart-buy-payments-pagination">

                <div class="smart-buy-payments-pagination__info">

                    Showing
                    <strong>1</strong>
                    to
                    <strong>5</strong>
                    of
                    <strong>128</strong>
                    payments

                </div>


                <div class="smart-buy-payments-pagination__buttons">

                    <button
                        type="button"
                        class="pagination-button disabled"
                        disabled
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


                    <span class="pagination-dots">
                    ...
                </span>


                    <button
                        type="button"
                        class="pagination-button"
                    >
                        26
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


    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const searchInput =
                    document.getElementById('smart-buy-payment-search');

                const statusFilter =
                    document.getElementById('smart-buy-payment-status');

                const dateFilter =
                    document.getElementById('smart-buy-payment-date');

                const tableRows =
                    document.querySelectorAll(
                        '.smart-buy-payments-table tbody tr'
                    );

                const emptyState =
                    document.getElementById(
                        'smart-buy-payments-empty'
                    );


                function filterPayments() {

                    const search =
                        searchInput
                            ? searchInput.value.toLowerCase().trim()
                            : '';

                    const status =
                        statusFilter
                            ? statusFilter.value
                            : '';


                    let visibleRows = 0;


                    tableRows.forEach(function (row) {

                        const rowText =
                            row.textContent.toLowerCase();

                        const rowStatus =
                            row.dataset.status || '';


                        const matchesSearch =
                            !search ||
                            rowText.includes(search);


                        const matchesStatus =
                            !status ||
                            rowStatus === status;


                        const visible =
                            matchesSearch &&
                            matchesStatus;


                        row.style.display =
                            visible
                                ? ''
                                : 'none';


                        if (visible) {
                            visibleRows++;
                        }

                    });


                    if (emptyState) {

                        emptyState.style.display =
                            visibleRows === 0
                                ? 'flex'
                                : 'none';

                    }

                }


                if (searchInput) {

                    searchInput.addEventListener(
                        'input',
                        filterPayments
                    );

                }


                if (statusFilter) {

                    statusFilter.addEventListener(
                        'change',
                        filterPayments
                    );

                }


                if (dateFilter) {

                    dateFilter.addEventListener(
                        'change',
                        function () {

                            /*
                             * Date filtering can be connected to
                             * backend query parameters later.
                             */

                        }
                    );

                }

            });

        </script>

    @endpush

@endsection
