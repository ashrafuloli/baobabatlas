@extends('backend.layouts.backend')

@section('title', 'Reports')

@section('content')

    <div class="page-content reports-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Analytics & Reports
            </span>

                <h1>
                    Reports
                </h1>

                <p>
                    Monitor ecommerce and Smart Buy performance from one place.
                </p>

            </div>


            <div class="page-header-actions">

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
            REPORT TYPE CARDS
        ================================================== --}}
        <div class="report-type-grid">


            {{-- Ecommerce --}}
            <a
                href="{{ route('reports-ecommerce') }}"
                class="report-type-card"
            >

                <div class="report-type-icon ecommerce">

                    <i class="fa-regular fa-cart-shopping"></i>

                </div>


                <div class="report-type-content">

                <span>
                    Ecommerce
                </span>

                    <h2>
                        Ecommerce Reports
                    </h2>

                    <p>
                        Analyze orders, sales, products and customers.
                    </p>

                </div>


                <div class="report-type-arrow">

                    <i class="fa-regular fa-arrow-right"></i>

                </div>

            </a>


            {{-- Smart Buy --}}
            <a
                href="{{ route('reports-smart-buy') }}"
                class="report-type-card"
            >

                <div class="report-type-icon smart-buy">

                    <i class="fa-regular fa-bag-shopping"></i>

                </div>


                <div class="report-type-content">

                <span>
                    Smart Buy
                </span>

                    <h2>
                        Smart Buy Reports
                    </h2>

                    <p>
                        Analyze requests, quotes, purchases and revenue.
                    </p>

                </div>


                <div class="report-type-arrow">

                    <i class="fa-regular fa-arrow-right"></i>

                </div>

            </a>

        </div>


        {{-- ==================================================
            OVERVIEW STATISTICS
        ================================================== --}}
        <div class="report-stat-grid">


            {{-- Revenue --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon revenue">

                        <i class="fa-regular fa-chart-line"></i>

                    </div>

                    <span class="stat-change positive">
                    +12.8%
                </span>

                </div>


                <div class="stat-content">

                <span class="stat-label">
                    Total Revenue
                </span>

                    <h3>
                        $24,850.00
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
                        428
                    </h3>

                    <p>
                        Ecommerce orders
                    </p>

                </div>

            </div>


            {{-- Smart Buy --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon smart-buy">

                        <i class="fa-regular fa-bag-shopping"></i>

                    </div>

                    <span class="stat-change positive">
                    +15.2%
                </span>

                </div>


                <div class="stat-content">

                <span class="stat-label">
                    Smart Buy Requests
                </span>

                    <h3>
                        146
                    </h3>

                    <p>
                        Total submitted requests
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
                        312
                    </h3>

                    <p>
                        Active customers
                    </p>

                </div>

            </div>

        </div>


        {{-- ==================================================
            REVENUE OVERVIEW
        ================================================== --}}
        <div class="reports-grid">


            {{-- Revenue Overview --}}
            <div class="dashboard-card revenue-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Revenue Overview
                        </h2>

                        <p>
                            Revenue generated across all sales channels.
                        </p>

                    </div>


                    <div class="revenue-legend">

                    <span>
                        <i></i>
                        Revenue
                    </span>

                    </div>

                </div>


                <div class="revenue-chart">

                    <div class="chart-y-axis">

                    <span>
                        $30k
                    </span>

                        <span>
                        $20k
                    </span>

                        <span>
                        $10k
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

                        </div>


                        <div class="chart-bars">

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 42%;"></div>
                                <span>01</span>
                            </div>

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 55%;"></div>
                                <span>05</span>
                            </div>

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 48%;"></div>
                                <span>10</span>
                            </div>

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 67%;"></div>
                                <span>15</span>
                            </div>

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 61%;"></div>
                                <span>20</span>
                            </div>

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 78%;"></div>
                                <span>25</span>
                            </div>

                            <div class="chart-bar-wrap">
                                <div class="chart-bar" style="height: 88%;"></div>
                                <span>30</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Payment Breakdown --}}
            <div class="dashboard-card payment-breakdown-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Revenue Breakdown
                        </h2>

                        <p>
                            Revenue by business type.
                        </p>

                    </div>

                </div>


                <div class="breakdown-content">


                    <div class="breakdown-total">

                    <span>
                        Total Revenue
                    </span>

                        <strong>
                            $24,850
                        </strong>

                    </div>


                    <div class="breakdown-item">

                        <div class="breakdown-info">

                            <span class="breakdown-dot ecommerce"></span>

                            <span>
                            Ecommerce
                        </span>

                        </div>

                        <strong>
                            $18,450
                        </strong>

                    </div>


                    <div class="breakdown-progress">

                    <span
                        style="width: 74%;"
                    ></span>

                    </div>


                    <div class="breakdown-item">

                        <div class="breakdown-info">

                            <span class="breakdown-dot smart-buy"></span>

                            <span>
                            Smart Buy
                        </span>

                        </div>

                        <strong>
                            $6,400
                        </strong>

                    </div>


                    <div class="breakdown-progress">

                    <span
                        class="smart-buy"
                        style="width: 26%;"
                    ></span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            QUICK REPORTS
        ================================================== --}}
        <div class="dashboard-card quick-reports-card">

            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Quick Reports
                    </h2>

                    <p>
                        Access detailed reports by category.
                    </p>

                </div>

            </div>


            <div class="quick-report-grid">


                <a
                    href="{{ route('reports-ecommerce') }}"
                    class="quick-report-item"
                >

                    <div class="quick-report-icon">

                        <i class="fa-regular fa-cart-shopping"></i>

                    </div>


                    <div>

                        <strong>
                            Ecommerce Report
                        </strong>

                        <span>
                        Sales, orders and product performance
                    </span>

                    </div>


                    <i class="fa-regular fa-chevron-right"></i>

                </a>


                <a
                    href="{{ route('reports-smart-buy') }}"
                    class="quick-report-item"
                >

                    <div class="quick-report-icon gold">

                        <i class="fa-regular fa-bag-shopping"></i>

                    </div>


                    <div>

                        <strong>
                            Smart Buy Report
                        </strong>

                        <span>
                        Requests, quotes and purchases
                    </span>

                    </div>


                    <i class="fa-regular fa-chevron-right"></i>

                </a>


            </div>

        </div>

    </div>

@endsection
