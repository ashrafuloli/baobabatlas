@extends('backend.layouts.backend')

@section('title', 'Smart Buy Payments')

@section('content')

    <div class="page-content smart-buy-payments-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Payment Management
            </span>

                <h1>
                    Smart Buy Payments
                </h1>

                <p>
                    View and manage payments received for Smart Buy requests.
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


            {{-- Total Revenue --}}
            <div class="payment-stat-card">

                <div class="stat-icon gold">

                    <i class="fa-regular fa-money-bill-wave"></i>

                </div>


                <div class="stat-content">

                <span class="stat-label">
                    Smart Buy Revenue
                </span>

                    <h3>
                        $6,400.00
                    </h3>

                    <p>
                        Total Smart Buy payments
                    </p>

                </div>


                <span class="stat-growth positive">
                +11.6%
            </span>

            </div>


            {{-- Total Payments --}}
            <div class="payment-stat-card">

                <div class="stat-icon gold">

                    <i class="fa-regular fa-credit-card"></i>

                </div>


                <div class="stat-content">

                <span class="stat-label">
                    Total Payments
                </span>

                    <h3>
                        102
                    </h3>

                    <p>
                        Smart Buy transactions
                    </p>

                </div>


                <span class="stat-growth positive">
                +7.8%
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
                        91
                    </h3>

                    <p>
                        Completed payments
                    </p>

                </div>


                <span class="stat-growth positive">
                89.2%
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
                        11
                    </h3>

                    <p>
                        Failed transactions
                    </p>

                </div>


                <span class="stat-growth negative">
                10.8%
            </span>

            </div>

        </div>


        {{-- ==================================================
            SMART BUY PAYMENTS
        ================================================== --}}
        <div class="dashboard-card smart-buy-transactions-card">


            {{-- Card Header --}}
            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Smart Buy Payment Transactions
                    </h2>

                    <p>
                        Payments made by customers after accepting their quotes.
                    </p>

                </div>


                <div class="card-header-actions">

                    {{-- Status Filter --}}
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


                    {{-- Date Filter --}}
                    <div class="payment-filter">

                        <select
                            name="date"
                            class="form-control"
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
                            Request
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Quote Amount
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
                                #PAY-10481
                            </strong>

                        </td>


                        <td>

                            <strong class="request-id">
                                #SB-10042
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
                                $1,250.00
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
                                #PAY-10476
                            </strong>

                        </td>


                        <td>

                            <strong class="request-id">
                                #SB-10037
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
                                $850.00
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
                                #PAY-10470
                            </strong>

                        </td>


                        <td>

                            <strong class="request-id">
                                #SB-10031
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
                                $620.00
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
                                #PAY-10462
                            </strong>

                        </td>


                        <td>

                            <strong class="request-id">
                                #SB-10023
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
                                $1,180.00
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
                    Showing 1–4 of 102 payments
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
                        26
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
