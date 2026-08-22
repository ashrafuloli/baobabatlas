@extends('backend.layouts.backend')

@section('title', 'Failed Payments')

@section('content')

    <div class="page-content failed-payments-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Payment Management
            </span>

                <h1>
                    Failed Payments
                </h1>

                <p>
                    Review failed payment transactions and take necessary action.
                </p>

            </div>


            <div class="page-header-actions">

                <a
                    href="{{ route('payments') }}"
                    class="btn btn-outline"
                >
                    <i class="fa-regular fa-arrow-left"></i>

                    <span>
                    All Payments
                </span>
                </a>

            </div>

        </div>


        {{-- ==================================================
            STATISTICS
        ================================================== --}}
        <div class="payment-stat-grid">


            {{-- Failed Amount --}}
            <div class="payment-stat-card">

                <div class="stat-icon danger">

                    <i class="fa-regular fa-money-bill-transfer"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Failed Amount
                </span>

                    <h3>
                        $2,480.00
                    </h3>

                    <p>
                        Total failed payment value
                    </p>

                </div>

                <span class="stat-growth negative">
                6.0%
            </span>

            </div>


            {{-- Failed Transactions --}}
            <div class="payment-stat-card">

                <div class="stat-icon danger">

                    <i class="fa-regular fa-circle-xmark"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Failed Transactions
                </span>

                    <h3>
                        26
                    </h3>

                    <p>
                        Requires attention
                    </p>

                </div>

                <span class="stat-growth negative">
                +4.2%
            </span>

            </div>


            {{-- Ecommerce --}}
            <div class="payment-stat-card">

                <div class="stat-icon">

                    <i class="fa-regular fa-cart-shopping"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Ecommerce Failed
                </span>

                    <h3>
                        15
                    </h3>

                    <p>
                        Ecommerce transactions
                    </p>

                </div>

            </div>


            {{-- Smart Buy --}}
            <div class="payment-stat-card">

                <div class="stat-icon gold">

                    <i class="fa-regular fa-bag-shopping"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Smart Buy Failed
                </span>

                    <h3>
                        11
                    </h3>

                    <p>
                        Smart Buy transactions
                    </p>

                </div>

            </div>

        </div>


        {{-- ==================================================
            FAILED TRANSACTIONS
        ================================================== --}}
        <div class="dashboard-card failed-transactions-card">


            {{-- Card Header --}}
            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Failed Payment Transactions
                    </h2>

                    <p>
                        Transactions that could not be completed successfully.
                    </p>

                </div>


                <div class="card-header-actions">

                    <div class="payment-filter">

                        <select
                            name="type"
                            class="form-control"
                        >

                            <option value="">
                                All Types
                            </option>

                            <option value="ecommerce">
                                Ecommerce
                            </option>

                            <option value="smart-buy">
                                Smart Buy
                            </option>

                        </select>

                    </div>


                    <div class="payment-filter">

                        <select
                            name="reason"
                            class="form-control"
                        >

                            <option value="">
                                All Reasons
                            </option>

                            <option value="declined">
                                Card Declined
                            </option>

                            <option value="insufficient">
                                Insufficient Funds
                            </option>

                            <option value="expired">
                                Card Expired
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                TABLE
            ================================================== --}}
            <div class="table-responsive">

                <table class="payment-table">

                    <thead>

                    <tr>

                        <th>
                            Transaction
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Type
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Payment Method
                        </th>

                        <th>
                            Failure Reason
                        </th>

                        <th>
                            Date
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>


                    {{-- ==================================================
                        FAILED PAYMENT 01
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10479
                            </strong>

                        </td>


                        <td>

                            <div class="customer-info">

                                <div class="customer-avatar">
                                    EW
                                </div>

                                <div class="customer-details">

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

                            <span class="payment-type smart-buy">
                                Smart Buy
                            </span>

                        </td>


                        <td>

                            <strong class="payment-amount">
                                $850.00
                            </strong>

                        </td>


                        <td>

                            <div class="payment-method">

                                <i class="fa-brands fa-cc-visa"></i>

                                <span>
                                    Visa **** 3351
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="failure-reason">
                                Card Declined
                            </span>

                        </td>


                        <td>
                            Aug 16, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 4) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- ==================================================
                        FAILED PAYMENT 02
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10465
                            </strong>

                        </td>


                        <td>

                            <div class="customer-info">

                                <div class="customer-avatar">
                                    SS
                                </div>

                                <div class="customer-details">

                                    <strong>
                                        Sarah Smith
                                    </strong>

                                    <span>
                                        sarah@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="payment-type ecommerce">
                                Ecommerce
                            </span>

                        </td>


                        <td>

                            <strong class="payment-amount">
                                $175.00
                            </strong>

                        </td>


                        <td>

                            <div class="payment-method">

                                <i class="fa-brands fa-cc-visa"></i>

                                <span>
                                    Visa **** 7712
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="failure-reason">
                                Insufficient Funds
                            </span>

                        </td>


                        <td>
                            Aug 15, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 5) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- ==================================================
                        FAILED PAYMENT 03
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10452
                            </strong>

                        </td>


                        <td>

                            <div class="customer-info">

                                <div class="customer-avatar">
                                    MB
                                </div>

                                <div class="customer-details">

                                    <strong>
                                        Michael Brown
                                    </strong>

                                    <span>
                                        michael@example.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="payment-type ecommerce">
                                Ecommerce
                            </span>

                        </td>


                        <td>

                            <strong class="payment-amount">
                                $320.00
                            </strong>

                        </td>


                        <td>

                            <div class="payment-method">

                                <i class="fa-brands fa-cc-mastercard"></i>

                                <span>
                                    Mastercard **** 8821
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="failure-reason">
                                Card Expired
                            </span>

                        </td>


                        <td>
                            Aug 14, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 6) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- ==================================================
                        FAILED PAYMENT 04
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10440
                            </strong>

                        </td>


                        <td>

                            <div class="customer-info">

                                <div class="customer-avatar">
                                    JD
                                </div>

                                <div class="customer-details">

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

                            <span class="payment-type smart-buy">
                                Smart Buy
                            </span>

                        </td>


                        <td>

                            <strong class="payment-amount">
                                $1,135.00
                            </strong>

                        </td>


                        <td>

                            <div class="payment-method">

                                <i class="fa-brands fa-cc-visa"></i>

                                <span>
                                    Visa **** 4242
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="failure-reason">
                                Card Declined
                            </span>

                        </td>


                        <td>
                            Aug 13, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 7) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                TABLE FOOTER
            ================================================== --}}
            <div class="table-footer">

                <div class="table-results">
                    Showing 1–4 of 26 failed payments
                </div>


                <div class="pagination">

                    <button
                        type="button"
                        disabled
                        aria-label="Previous page"
                    >
                        <i class="fa-regular fa-chevron-left"></i>
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

                    <span>
                    ...
                </span>

                    <button type="button">
                        7
                    </button>

                    <button
                        type="button"
                        aria-label="Next page"
                    >
                        <i class="fa-regular fa-chevron-right"></i>
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
