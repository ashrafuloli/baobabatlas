@extends('backend.layouts.backend')

@section('title', 'Smart Buy Reports')

@section('content')

    <div class="page-content smart-buy-reports-page">

        {{-- ==================================================
            PAGE HEADER
        ================================================== --}}
        <div class="page-header">

            <div class="page-header-content">

            <span class="page-subtitle">
                Reports
            </span>

                <h1>
                    Smart Buy Reports
                </h1>

                <p>
                    Analyze Smart Buy requests, quotes, purchases, revenue and fulfillment.
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


            {{-- Requests --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon requests">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>

                    <span class="stat-change positive">
                    +15.2%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Total Requests
                </span>

                    <h3>
                        146
                    </h3>

                    <p>
                        Smart Buy requests submitted
                    </p>

                </div>

            </div>


            {{-- Quotes --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon quotes">
                        <i class="fa-regular fa-file-invoice-dollar"></i>
                    </div>

                    <span class="stat-change positive">
                    +10.4%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Quotes Sent
                </span>

                    <h3>
                        118
                    </h3>

                    <p>
                        Quotes prepared and sent
                    </p>

                </div>

            </div>


            {{-- Purchases --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon purchases">
                        <i class="fa-regular fa-bag-shopping"></i>
                    </div>

                    <span class="stat-change positive">
                    +12.6%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Completed Purchases
                </span>

                    <h3>
                        82
                    </h3>

                    <p>
                        Products purchased successfully
                    </p>

                </div>

            </div>


            {{-- Revenue --}}
            <div class="report-stat-card">

                <div class="stat-top">

                    <div class="stat-icon revenue">
                        <i class="fa-regular fa-money-bill-wave"></i>
                    </div>

                    <span class="stat-change positive">
                    +18.4%
                </span>

                </div>

                <div class="stat-content">

                <span class="stat-label">
                    Smart Buy Revenue
                </span>

                    <h3>
                        $6,400
                    </h3>

                    <p>
                        Revenue from Smart Buy
                    </p>

                </div>

            </div>

        </div>


        {{-- ==================================================
            REQUEST & REVENUE OVERVIEW
        ================================================== --}}
        <div class="reports-grid">


            {{-- Request Chart --}}
            <div class="dashboard-card request-chart-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Smart Buy Activity
                        </h2>

                        <p>
                            Requests and completed purchases during the selected period.
                        </p>

                    </div>


                    <div class="chart-legend">

                    <span>
                        <i class="request-dot"></i>
                        Requests
                    </span>

                        <span>
                        <i class="purchase-dot"></i>
                        Purchases
                    </span>

                    </div>

                </div>


                <div class="activity-chart">

                    <div class="chart-y-axis">

                    <span>
                        40
                    </span>

                        <span>
                        30
                    </span>

                        <span>
                        20
                    </span>

                        <span>
                        10
                    </span>

                        <span>
                        0
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


                        <div class="activity-bars">

                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 55%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 30%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                01
                            </span>

                            </div>


                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 70%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 38%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                05
                            </span>

                            </div>


                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 48%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 25%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                10
                            </span>

                            </div>


                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 78%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 48%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                15
                            </span>

                            </div>


                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 64%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 42%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                20
                            </span>

                            </div>


                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 84%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 56%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                25
                            </span>

                            </div>


                            <div class="activity-bar-group">

                                <div class="activity-bars-inner">

                                <span
                                    class="request-bar"
                                    style="height: 92%;"
                                ></span>

                                    <span
                                        class="purchase-bar"
                                        style="height: 64%;"
                                    ></span>

                                </div>

                                <span class="chart-label">
                                30
                            </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Request Status --}}
            <div class="dashboard-card request-status-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Request Status
                        </h2>

                        <p>
                            Current Smart Buy requests.
                        </p>

                    </div>

                    <div class="status-total">

                    <span>
                       Total Requests
                    </span>

                        <strong>146</strong>

                    </div>

                </div>


                <div class="request-status-content">


                    <div class="smart-status-item">

                        <div class="status-item-info">

                            <span class="status-dot submitted"></span>

                            <span>
                            Submitted
                        </span>

                        </div>

                        <strong>
                            22
                        </strong>

                    </div>

                    <div class="status-progress">

                    <span
                        class="submitted"
                        style="width: 15%;"
                    ></span>

                    </div>


                    <div class="smart-status-item">

                        <div class="status-item-info">

                            <span class="status-dot reviewing"></span>

                            <span>
                            Under Review
                        </span>

                        </div>

                        <strong>
                            18
                        </strong>

                    </div>

                    <div class="status-progress">

                    <span
                        class="reviewing"
                        style="width: 12%;"
                    ></span>

                    </div>


                    <div class="smart-status-item">

                        <div class="status-item-info">

                            <span class="status-dot quoted"></span>

                            <span>
                            Quote Sent
                        </span>

                        </div>

                        <strong>
                            24
                        </strong>

                    </div>

                    <div class="status-progress">

                    <span
                        class="quoted"
                        style="width: 16%;"
                    ></span>

                    </div>


                    <div class="smart-status-item">

                        <div class="status-item-info">

                            <span class="status-dot accepted"></span>

                            <span>
                            Accepted
                        </span>

                        </div>

                        <strong>
                            16
                        </strong>

                    </div>

                    <div class="status-progress">

                    <span
                        class="accepted"
                        style="width: 11%;"
                    ></span>

                    </div>


                    <div class="smart-status-item">

                        <div class="status-item-info">

                            <span class="status-dot purchased"></span>

                            <span>
                            Purchased
                        </span>

                        </div>

                        <strong>
                            82
                        </strong>

                    </div>

                    <div class="status-progress">

                    <span
                        class="purchased"
                        style="width: 56%;"
                    ></span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            QUOTE PERFORMANCE
        ================================================== --}}
        <div class="reports-grid secondary-grid">


            {{-- Quote Performance --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Quote Performance
                        </h2>

                        <p>
                            Quote acceptance and conversion.
                        </p>

                    </div>

                </div>


                <div class="quote-performance">

                    <div class="conversion-circle">

                        <div class="conversion-value">
                            69%
                        </div>

                        <span>
                        Acceptance Rate
                    </span>

                    </div>


                    <div class="quote-metrics">

                        <div class="quote-metric">

                        <span>
                            Quotes Sent
                        </span>

                            <strong>
                                118
                            </strong>

                        </div>


                        <div class="quote-metric">

                        <span>
                            Accepted
                        </span>

                            <strong>
                                82
                            </strong>

                        </div>


                        <div class="quote-metric">

                        <span>
                            Pending
                        </span>

                            <strong>
                                20
                            </strong>

                        </div>


                        <div class="quote-metric">

                        <span>
                            Declined
                        </span>

                            <strong>
                                16
                            </strong>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Average Quote --}}
            <div class="dashboard-card">

                <div class="dashboard-card-header">

                    <div class="card-header-content">

                        <h2>
                            Quote & Purchase Value
                        </h2>

                        <p>
                            Financial performance of Smart Buy quotes.
                        </p>

                    </div>

                </div>


                <div class="value-summary">


                    <div class="value-item">

                    <span class="value-icon quote">
                        <i class="fa-regular fa-file-invoice-dollar"></i>
                    </span>

                        <div>

                        <span>
                            Average Quote
                        </span>

                            <strong>
                                $780.00
                            </strong>

                        </div>

                    </div>


                    <div class="value-item">

                    <span class="value-icon purchase">
                        <i class="fa-regular fa-bag-shopping"></i>
                    </span>

                        <div>

                        <span>
                            Average Purchase
                        </span>

                            <strong>
                                $640.00
                            </strong>

                        </div>

                    </div>


                    <div class="value-item">

                    <span class="value-icon revenue">
                        <i class="fa-regular fa-money-bill-wave"></i>
                    </span>

                        <div>

                        <span>
                            Total Revenue
                        </span>

                            <strong>
                                $6,400
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            RECENT SMART BUY ACTIVITY
        ================================================== --}}
        <div class="dashboard-card recent-activity-card">

            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Recent Smart Buy Activity
                    </h2>

                    <p>
                        Latest requests and their current progress.
                    </p>

                </div>

            </div>


            <div class="activity-table-wrapper">

                <table class="activity-table">

                    <thead>

                    <tr>

                        <th>
                            Request
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Quote
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

                    </tr>

                    </thead>


                    <tbody>

                    <tr>

                        <td>
                            <strong>
                                #SB-10482
                            </strong>
                        </td>

                        <td>

                            <div class="customer-cell">

                                <span class="customer-avatar">
                                    JD
                                </span>

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
                            $1,250.00
                        </td>

                        <td>
                            $1,250.00
                        </td>

                        <td>
                            <span class="request-badge purchased">
                                Purchased
                            </span>
                        </td>

                        <td>
                            Aug 17, 2026
                        </td>

                    </tr>


                    <tr>

                        <td>
                            <strong>
                                #SB-10481
                            </strong>
                        </td>

                        <td>

                            <div class="customer-cell">

                                <span class="customer-avatar">
                                    SS
                                </span>

                                <div>

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
                            $850.00
                        </td>

                        <td>
                            $850.00
                        </td>

                        <td>
                            <span class="request-badge quoted">
                                Quote Sent
                            </span>
                        </td>

                        <td>
                            Aug 17, 2026
                        </td>

                    </tr>


                    <tr>

                        <td>
                            <strong>
                                #SB-10480
                            </strong>
                        </td>

                        <td>

                            <div class="customer-cell">

                                <span class="customer-avatar">
                                    MB
                                </span>

                                <div>

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
                            $620.00
                        </td>

                        <td>
                            $620.00
                        </td>

                        <td>
                            <span class="request-badge reviewing">
                                Under Review
                            </span>
                        </td>

                        <td>
                            Aug 16, 2026
                        </td>

                    </tr>


                    <tr>

                        <td>
                            <strong>
                                #SB-10479
                            </strong>
                        </td>

                        <td>

                            <div class="customer-cell">

                                <span class="customer-avatar">
                                    EW
                                </span>

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
                            $480.00
                        </td>

                        <td>
                            $480.00
                        </td>

                        <td>
                            <span class="request-badge submitted">
                                Submitted
                            </span>
                        </td>

                        <td>
                            Aug 16, 2026
                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ==================================================
            PAYMENT SUMMARY
        ================================================== --}}
        <div class="dashboard-card payment-summary-card">

            <div class="dashboard-card-header">

                <div class="card-header-content">

                    <h2>
                        Smart Buy Payment Summary
                    </h2>

                    <p>
                        Payment performance for Smart Buy transactions.
                    </p>

                </div>


                <a
                    href="{{ route('payments-smart-buy') }}"
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
                            82
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
                            8
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
                            4
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
                            $6,400
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
