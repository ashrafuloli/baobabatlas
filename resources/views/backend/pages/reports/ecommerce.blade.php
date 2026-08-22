@extends('backend.layouts.backend')

@section('title', 'Ecommerce Reports')

@section('content')

    <div class="page-content ecommerce-reports-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Reports
            </span>

                <h1>
                    Ecommerce Reports
                </h1>

                <p>
                    Analyze ecommerce sales, orders, customers and product performance.
                </p>

            </div>


            <div class="page-header-actions">

                <a
                    href="{{ route('reports') }}"
                    class="btn btn-outline"
                >
                    <i class="fa-regular fa-arrow-left"></i>

                    <span>
                    Reports
                </span>
                </a>


                <div class="report-date-filter">

                    <i class="fa-regular fa-calendar"></i>

                    <select
                        name="period"
                        class="form-control"
                    >
                        <option value="30">
                            Last 30 Days
                        </option>

                        <option value="7">
                            Last 7 Days
                        </option>

                        <option value="90">
                            Last 90 Days
                        </option>

                        <option value="year">
                            This Year
                        </option>
                    </select>

                </div>

            </div>

        </div>


        {{-- ==================================================
            STATISTICS
        ================================================== --}}
        <div class="report-stat-grid">

            {{-- Sales --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon sales">
                        <i class="fa-regular fa-chart-line"></i>
                    </div>

                    <span class="stat-change positive">
                    +12.8%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Total Sales
                </span>

                    <h3>
                        $18,450.00
                    </h3>

                    <p>
                        Compared with previous period
                    </p>

                </div>

            </div>


            {{-- Orders --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon orders">
                        <i class="fa-regular fa-cart-shopping"></i>
                    </div>

                    <span class="stat-change positive">
                    +8.4%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Total Orders
                </span>

                    <h3>
                        326
                    </h3>

                    <p>
                        Orders placed
                    </p>

                </div>

            </div>


            {{-- Average Order --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon average">
                        <i class="fa-regular fa-receipt"></i>
                    </div>

                    <span class="stat-change positive">
                    +4.1%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Average Order Value
                </span>

                    <h3>
                        $56.60
                    </h3>

                    <p>
                        Average revenue per order
                    </p>

                </div>

            </div>


            {{-- Customers --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon customers">
                        <i class="fa-regular fa-users"></i>
                    </div>

                    <span class="stat-change positive">
                    +6.7%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Customers
                </span>

                    <h3>
                        284
                    </h3>

                    <p>
                        Active ecommerce customers
                    </p>

                </div>

            </div>

        </div>


        {{-- ==================================================
            SALES OVERVIEW
        ================================================== --}}
        <div class="reports-grid">


            {{-- Sales Chart --}}
            <div class="dashboard-card sales-chart-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Sales Overview
                        </h2>

                        <p>
                            Ecommerce revenue over the selected period.
                        </p>

                    </div>


                    <div class="chart-total">

                    <span>
                        Total Sales
                    </span>

                        <strong>
                            $18,450
                        </strong>

                    </div>

                </div>


                <div class="sales-chart">

                    <div class="chart-y-axis">

                    <span>
                        $20k
                    </span>

                        <span>
                        $15k
                    </span>

                        <span>
                        $10k
                    </span>

                        <span>
                        $5k
                    </span>

                        <span>
                        $0
                    </span>

                    </div>


                    <div class="chart-area">

                        <div class="chart-grid-lines">

                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>

                        </div>


                        <div class="chart-bars">

                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 38%;"
                                ></div>

                                <span>
                                01
                            </span>

                            </div>


                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 52%;"
                                ></div>

                                <span>
                                05
                            </span>

                            </div>


                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 45%;"
                                ></div>

                                <span>
                                10
                            </span>

                            </div>


                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 64%;"
                                ></div>

                                <span>
                                15
                            </span>

                            </div>


                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 58%;"
                                ></div>

                                <span>
                                20
                            </span>

                            </div>


                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 73%;"
                                ></div>

                                <span>
                                25
                            </span>

                            </div>


                            <div class="chart-bar-wrap">

                                <div
                                    class="chart-bar"
                                    style="height: 86%;"
                                ></div>

                                <span>
                                30
                            </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Order Status --}}
            <div class="dashboard-card order-status-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Order Status
                        </h2>

                        <p>
                            Current ecommerce orders.
                        </p>

                    </div>

                    <div class="chart-total">

                    <span>
                        Total Orders
                    </span>

                        <strong>326</strong>

                    </div>

                </div>


                <div class="order-status-content">

                    <div class="status-item">

                        <div class="status-item-info">
                            <span class="status-dot processing"></span>

                            <span>
                Processing
            </span>
                        </div>

                        <strong>
                            48
                        </strong>

                    </div>

                    <div class="status-progress">
        <span
            class="processing"
            style="width: 15%;"
        ></span>
                    </div>


                    <div class="status-item">

                        <div class="status-item-info">
                            <span class="status-dot shipped"></span>

                            <span>
                Shipped
            </span>
                        </div>

                        <strong>
                            72
                        </strong>

                    </div>

                    <div class="status-progress">
        <span
            class="shipped"
            style="width: 22%;"
        ></span>
                    </div>


                    <div class="status-item">

                        <div class="status-item-info">
                            <span class="status-dot delivered"></span>

                            <span>
                Delivered
            </span>
                        </div>

                        <strong>
                            192
                        </strong>

                    </div>

                    <div class="status-progress">
        <span
            class="delivered"
            style="width: 59%;"
        ></span>
                    </div>


                    <div class="status-item">

                        <div class="status-item-info">
                            <span class="status-dot cancelled"></span>

                            <span>
                Cancelled
            </span>
                        </div>

                        <strong>
                            14
                        </strong>

                    </div>

                    <div class="status-progress">
        <span
            class="cancelled"
            style="width: 4%;"
        ></span>
                    </div>

                </div>
            </div>

        </div>


        {{-- ==================================================
            PRODUCT & CUSTOMER PERFORMANCE
        ================================================== --}}
        <div class="reports-grid secondary-grid">


            {{-- Top Products --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Top Products
                        </h2>

                        <p>
                            Best performing products by sales.
                        </p>

                    </div>

                </div>


                <div class="product-list">


                    <div class="product-row">

                        <div class="product-rank">
                            01
                        </div>

                        <div class="product-info">

                            <strong>
                                Premium Shipping Box
                            </strong>

                            <span>
                            128 units sold
                        </span>

                        </div>

                        <strong class="product-sales">
                            $4,820
                        </strong>

                    </div>


                    <div class="product-row">

                        <div class="product-rank">
                            02
                        </div>

                        <div class="product-info">

                            <strong>
                                International Parcel Pack
                            </strong>

                            <span>
                            96 units sold
                        </span>

                        </div>

                        <strong class="product-sales">
                            $3,740
                        </strong>

                    </div>


                    <div class="product-row">

                        <div class="product-rank">
                            03
                        </div>

                        <div class="product-info">

                            <strong>
                                Express Delivery Package
                            </strong>

                            <span>
                            82 units sold
                        </span>

                        </div>

                        <strong class="product-sales">
                            $3,120
                        </strong>

                    </div>


                    <div class="product-row">

                        <div class="product-rank">
                            04
                        </div>

                        <div class="product-info">

                            <strong>
                                Standard Parcel Package
                            </strong>

                            <span>
                            64 units sold
                        </span>

                        </div>

                        <strong class="product-sales">
                            $2,480
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Customer Performance --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Customer Performance
                        </h2>

                        <p>
                            Customer activity and revenue.
                        </p>

                    </div>

                </div>


                <div class="customer-report-list">


                    <div class="customer-report-row">

                        <div class="customer-avatar">
                            JD
                        </div>

                        <div class="customer-report-info">

                            <strong>
                                John Doe
                            </strong>

                            <span>
                            18 orders
                        </span>

                        </div>

                        <strong>
                            $1,840
                        </strong>

                    </div>


                    <div class="customer-report-row">

                        <div class="customer-avatar">
                            SS
                        </div>

                        <div class="customer-report-info">

                            <strong>
                                Sarah Smith
                            </strong>

                            <span>
                            15 orders
                        </span>

                        </div>

                        <strong>
                            $1,620
                        </strong>

                    </div>


                    <div class="customer-report-row">

                        <div class="customer-avatar">
                            MB
                        </div>

                        <div class="customer-report-info">

                            <strong>
                                Michael Brown
                            </strong>

                            <span>
                            12 orders
                        </span>

                        </div>

                        <strong>
                            $1,280
                        </strong>

                    </div>


                    <div class="customer-report-row">

                        <div class="customer-avatar">
                            EW
                        </div>

                        <div class="customer-report-info">

                            <strong>
                                Emma Wilson
                            </strong>

                            <span>
                            10 orders
                        </span>

                        </div>

                        <strong>
                            $1,140
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT SUMMARY
        ================================================== --}}
        <div class="dashboard-card payment-summary-card">

            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Ecommerce Payment Summary
                    </h2>

                    <p>
                        Overview of ecommerce payment performance.
                    </p>

                </div>


                <a
                    href="{{ route('payments-ecommerce') }}"
                    class="view-report-link"
                >
                    View Payments

                    <i class="fa-regular fa-arrow-right"></i>
                </a>

            </div>


            <div class="payment-summary-grid">


                <div class="payment-summary-item">

                <span class="summary-icon paid">
                    <i class="fa-regular fa-circle-check"></i>
                </span>

                    <div>

                    <span>
                        Successful
                    </span>

                        <strong>
                            311
                        </strong>

                    </div>

                </div>


                <div class="payment-summary-item">

                <span class="summary-icon pending">
                    <i class="fa-regular fa-clock"></i>
                </span>

                    <div>

                    <span>
                        Pending
                    </span>

                        <strong>
                            9
                        </strong>

                    </div>

                </div>


                <div class="payment-summary-item">

                <span class="summary-icon failed">
                    <i class="fa-regular fa-circle-xmark"></i>
                </span>

                    <div>

                    <span>
                        Failed
                    </span>

                        <strong>
                            15
                        </strong>

                    </div>

                </div>


                <div class="payment-summary-item">

                <span class="summary-icon revenue">
                    <i class="fa-regular fa-money-bill-wave"></i>
                </span>

                    <div>

                    <span>
                        Collected
                    </span>

                        <strong>
                            $18,450
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
