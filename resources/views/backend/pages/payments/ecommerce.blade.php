@extends('backend.layouts.backend')

@section('title', 'Ecommerce Payments')

@section('content')

    <div class="page-content ecommerce-payments-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Payment Management
            </span>

                <h1>
                    Ecommerce Payments
                </h1>

                <p>
                    View and manage payments received from ecommerce orders.
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


            {{-- Revenue --}}
            <div class="payment-stat-card">

                <div class="stat-icon">

                    <i class="fa-regular fa-money-bill-wave"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Ecommerce Revenue
                </span>

                    <h3>
                        $18,450.00
                    </h3>

                    <p>
                        Total ecommerce payments
                    </p>

                </div>

                <span class="stat-growth positive">
                +14.8%
            </span>

            </div>


            {{-- Payments --}}
            <div class="payment-stat-card">

                <div class="stat-icon">

                    <i class="fa-regular fa-credit-card"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Total Payments
                </span>

                    <h3>
                        326
                    </h3>

                    <p>
                        Ecommerce transactions
                    </p>

                </div>

                <span class="stat-growth positive">
                +9.2%
            </span>

            </div>


            {{-- Successful --}}
            <div class="payment-stat-card">

                <div class="stat-icon success">

                    <i class="fa-regular fa-circle-check"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Successful
                </span>

                    <h3>
                        311
                    </h3>

                    <p>
                        Completed transactions
                    </p>

                </div>

                <span class="stat-growth positive">
                95.4%
            </span>

            </div>


            {{-- Failed --}}
            <div class="payment-stat-card">

                <div class="stat-icon danger">

                    <i class="fa-regular fa-circle-xmark"></i>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Failed
                </span>

                    <h3>
                        15
                    </h3>

                    <p>
                        Failed transactions
                    </p>

                </div>

                <span class="stat-growth negative">
                4.6%
            </span>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT TRANSACTIONS
        ================================================== --}}
        <div class="dashboard-card ecommerce-transactions-card">


            {{-- Card Header --}}
            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Ecommerce Payment Transactions
                    </h2>

                    <p>
                        Payments collected from customer orders.
                    </p>

                </div>


                <div class="card-header-actions">

                    <div class="payment-filter">

                        <select
                            name="status"
                            class="form-control"
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

                        </select>

                    </div>


                    <div class="payment-filter">

                        <select
                            name="method"
                            class="form-control"
                        >

                            <option value="">
                                All Methods
                            </option>

                            <option value="card">
                                Card
                            </option>

                            <option value="paypal">
                                PayPal
                            </option>

                            <option value="bank">
                                Bank Transfer
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
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Payment Method
                        </th>

                        <th>
                            Status
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
                        PAYMENT 01
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10482
                            </strong>

                        </td>


                        <td>

                            <strong class="order-id">
                                #ORD-20841
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

                            <strong class="payment-amount">
                                $249.00
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

                            <span class="payment-status success">
                                Paid
                            </span>

                        </td>


                        <td>
                            Aug 17, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 1) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- ==================================================
                        PAYMENT 02
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10477
                            </strong>

                        </td>


                        <td>

                            <strong class="order-id">
                                #ORD-20836
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

                            <strong class="payment-amount">
                                $89.00
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

                            <span class="payment-status success">
                                Paid
                            </span>

                        </td>


                        <td>
                            Aug 16, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 2) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- ==================================================
                        PAYMENT 03
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10471
                            </strong>

                        </td>


                        <td>

                            <strong class="order-id">
                                #ORD-20830
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

                            <strong class="payment-amount">
                                $420.00
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

                            <span class="payment-status pending">
                                Pending
                            </span>

                        </td>


                        <td>
                            Aug 16, 2026
                        </td>


                        <td class="text-end">

                            <a
                                href="{{ route('payments-details', 3) }}"
                                class="table-action"
                                title="View Payment Details"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- ==================================================
                        PAYMENT 04
                    ================================================== --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10465
                            </strong>

                        </td>


                        <td>

                            <strong class="order-id">
                                #ORD-20824
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

                            <span class="payment-status failed">
                                Failed
                            </span>

                        </td>


                        <td>
                            Aug 15, 2026
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

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                TABLE FOOTER
            ================================================== --}}
            <div class="table-footer">

                <div class="table-results">
                    Showing 1–4 of 326 payments
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
                        82
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
