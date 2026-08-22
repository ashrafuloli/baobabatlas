@extends('backend.layouts.backend')

@section('title', 'All Payments')

@section('content')

    <div class="page-content payments-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Payment Management
            </span>

                <h1>
                    All Payments
                </h1>

                <p>
                    Monitor and manage all customer payment transactions.
                </p>

            </div>


            <div class="page-header-actions">

                <a
                    href="{{ route('payments-failed') }}"
                    class="btn btn-outline-danger"
                >

                    <i class="fa-regular fa-circle-exclamation"></i>

                    <span>
                    Failed Payments
                </span>

                </a>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT STATISTICS
        ================================================== --}}
        <div class="payment-stat-grid">


            {{-- Total Revenue --}}
            <div class="payment-stat-card">

                <div class="stat-icon">

                    <i class="fa-regular fa-money-bill-wave"></i>

                </div>


                <div class="stat-content">

                <span class="stat-label">
                    Total Revenue
                </span>

                    <h3>
                        $24,850.00
                    </h3>

                    <p>
                        Compared to last month
                    </p>

                </div>


                <span class="stat-growth positive">
                +12.5%
            </span>

            </div>


            {{-- Total Payments --}}
            <div class="payment-stat-card">

                <div class="stat-icon">

                    <i class="fa-regular fa-credit-card"></i>

                </div>


                <div class="stat-content">

                <span class="stat-label">
                    Total Payments
                </span>

                    <h3>
                        428
                    </h3>

                    <p>
                        Transactions this month
                    </p>

                </div>


                <span class="stat-growth positive">
                +8.4%
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
                        402
                    </h3>

                    <p>
                        Successful transactions
                    </p>

                </div>


                <span class="stat-growth positive">
                94.0%
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
                        26
                    </h3>

                    <p>
                        Requires attention
                    </p>

                </div>


                <span class="stat-growth negative">
                6.0%
            </span>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT TRANSACTIONS
        ================================================== --}}
        <div class="dashboard-card payment-transactions-card">


            {{-- Card Header --}}
            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Payment Transactions
                    </h2>

                    <p>
                        View and manage recent payment activity.
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

                </div>

            </div>


            {{-- ==================================================
                PAYMENT TABLE
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


                    {{-- Payment 01 --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10482
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

                            <span class="payment-type ecommerce">
                                Ecommerce
                            </span>

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


                    {{-- Payment 02 --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10481
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

                            <span class="payment-type smart-buy">
                                Smart Buy
                            </span>

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
                                href="{{ route('payments-details', 2) }}"
                                class="table-action"
                                title="View Payment Details"
                            >

                                <i class="fa-regular fa-eye"></i>

                            </a>

                        </td>

                    </tr>


                    {{-- Payment 03 --}}
                    <tr>

                        <td>

                            <strong class="transaction-id">
                                #PAY-10480
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
                                $89.00
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


                    {{-- Payment 04 --}}
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

                            <span class="payment-status failed">
                                Failed
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

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                TABLE FOOTER
            ================================================== --}}
            <div class="table-footer">

                <div class="table-results">
                    Showing 1–4 of 428 payments
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
                        108
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
